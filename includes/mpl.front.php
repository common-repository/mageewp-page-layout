<?php

if (!defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

class mpl_front {

	public $MPL_URL;
	public $storage = array();
	
	private $allows = null;
	private $scripts = array();
	private $styles = array();
	private $css = '';
	private $css_str = '';
	private $css_obj = array();
	private $css_str_master = '';
	private $css_obj_master = array();
	private $css_responsive = array();
	private $js = '';
	private $pattern_filter = '';
	private $tags_filter = array();
	private $action = null;
	private $content_master = true;
	private $prevent_infinite_loop = array();
	private $prevent_duplicate_ids = array();
	private $min = '.min';

	public function __construct() {

		$this->MPL_URL = untrailingslashit( MPL_URL ).'/assets/frontend/';

		if (defined('MPL_DEVELOPMENT') && MPL_DEVELOPMENT === true)
			$this->min = '';
		
		add_action('wp_enqueue_scripts', array( &$this, 'before_header' ), 9999 );
		add_action('wp_head', array( &$this, 'front_head' ), 999 );
		add_action('wp_footer',array( $this,'front_footer' ), 999 );
		add_filter('body_class', array( &$this, 'body_classes' ) );
		add_filter('mpl-el-class', array( &$this, 'el_class'));
		add_filter('mpl-owl-carousel', array( &$this, 'owl_carousel'));
		add_filter('mpl-video-background', array( &$this, 'render_video_background'));

		$icl_array = array(
			'helper.functions.php' =>  MPL_PATH.'/includes/frontend/helpers/',
			'shortcodes.filters.php' =>  MPL_PATH.'/includes/frontend/helpers/'
		);

		foreach ($icl_array as $file => $dir) {

			if (file_exists(untrailingslashit($dir) .MDS .$file))
				include untrailingslashit($dir) .MDS .$file;
		}
		
		if (isset($_GET['mpl_action']) && !empty($_GET['mpl_action']))
			$this->action = sanitize_title($_GET['mpl_action']);
		else if (isset($_POST['mpl_action']) && !empty($_POST['mpl_action']))
			$this->action = sanitize_title($_POST['mpl_action']);
		
		if ($this->action == 'live-editor')
			show_admin_bar(false);
	}
	
	public static function globe() {
		global $mpl_front;
		
		if (isset($mpl_front))
			return $mpl_front;
		else 
			wp_die('MPL Error: Global varible could not be loaded.');
	}

	public function before_header() {
	
	   global $mpl_meta;

		// Get access of curent page
		// Return to $this->allows
		$this->register_assets();
		$this->load_scripts();

		if ($this->allowed_access() && mpl_is_using()) {
			global $post;
			
			if (isset($post) && !empty( $post->post_content_filtered)) {
				 $post->post_content =  html_entity_decode( stripslashes_deep( $post->post_content_filtered ) );
			}

			if ($this->front_builder_load() === false)
				return false;

			if (isset($post)) {
				$post_data = get_post_meta( $post->ID , 'mpl_data', true );
				
				if (!empty($post_data) && $post_data['mode'] == 'mpl') {
					remove_filter('the_content', 'wpautop');
					remove_filter('the_content', 'shortcode_unautop');
				}
			}
			
			$this->css_str = '';
			$this->css_obj = array();
			$this->prevent_infinite_loop = array();

			$post->post_content = apply_filters(
				'mpl-content-after',
				$this->do_filter_shortcode(apply_filters('mpl-content-before', $post->post_content ), true)
			);
			
			$this->css_str_master = $this->css_str;
			$this->css_obj_master = $this->css_obj;
		}

	
		wp_localize_script('mpl-front-scripts', 'mpl_params', array(
			'ajaxurl'          => admin_url('admin-ajax.php'),
			'plugin_url'       => MPL_URL,
		));
	}

	public function add_filters() {
	
		global $mpl;
		
		if (is_array($mpl->add_filters)) {
			foreach ($mpl->add_filters as $name => $filters) {
				if (is_array($filters)) {
					foreach ($filters as $callback) {
						if (is_callable($callback)) {
							add_filter('shortcode_' .$name, $callback);
						}
					}
				}
			}
		}
	}

	public function front_builder_load() {
		global $mpl, $mpl_pro, $post;
		$content = trim($post->post_content);

		if ($this->action == 'live-editor') {
			if ($mpl->user_can_edit() === false)
				wp_die('You do not have permission to edit this page. <a href="'.admin_url().'">Please  login</a> or edit <a href="'.admin_url('edit.php?post_type=page').'">the pages</a> that you have the permission.</p>');

			foreach ($this->scripts as $script)
				wp_enqueue_script($script);

			//masonry enqueue
			wp_enqueue_script( 'masonry' );

			foreach ($this->styles as $style)
				wp_enqueue_style($style);

			if (isset( $mpl_pro ) && is_callable(array(&$mpl_pro, 'bottom_builder')))
				add_filter('mpl-content-after', array(&$mpl_pro, 'bottom_builder'));

		} else if (empty($content)) {
			return false;
		}
		return true;
	}
	
	public function do_filter_shortcode($content, $is_master = true) {
		global $shortcode_tags;
	
		$this->tags_filter = array();
		$this->content_master = $is_master;
		
		$content = preg_replace_callback( '@\[([^<>&/\[\]\x00-\x20]++)@', array( &$this, 'do_shortcode_alter' ), $content );
		$tagnames = array_intersect( array_keys( $shortcode_tags ), $this->tags_filter );

		if ( empty( $tagnames ) )
			return $content;

		$pattern_filter = get_shortcode_regex( $tagnames );
		
		return preg_replace_callback( "/$pattern_filter/", array( &$this, 'do_shortcode_tag' ), $content );
	}

	public function do_shortcode_alter($m) {

		$al = preg_replace( "/[^\#]/", '', $m[1] );

		if( !empty( $al ) )
			$m[0].= ' __="'.$al.'"';
		else
			array_push( $this->tags_filter, $m[1] );

		return $m[0];

	}

	public function do_shortcode_tag($m) {
		if ( $m[1] == '[' && $m[6] == ']' )
	        return substr($m[0], 1, -1);
		
		global $mpl;
		
	    $tag =  $m[2];
	    $maps = $mpl->get_maps($tag);
		$params = $mpl->params_obj($tag);
		$css_code = '';	
		
		$atts = (array)$this->shortcode_parse_atts($m[3]);

		$closed = substr($m[0], strlen($m[0]) - strlen($tag) - 3);


		// If this shortcode has been disabled
		if (isset($atts['disabled']) && $atts['disabled'] == 'on')
			return '';
		/*
		*	Row is link to section	
		*/
		
		if ($tag == 'mpl_row' && isset( $atts['__section_link']))
		{
			
			if (!isset( $this->prevent_infinite_loop[ $atts['__section_link'] ]))
			{
			
				$this->prevent_infinite_loop[ $atts['__section_link'] ] = true;
				
				$is_master = $this->content_master;
				
				$section = mpl_raw_content($atts['__section_link']);
				$section_meta = get_post_meta($atts['__section_link'] , 'mpl_data', true);

				if (!empty($section_meta) && !empty($section_meta['css']))
					$this->css .= $section_meta['css'];
				
				if (!empty($section))
					$section = $this->do_filter_shortcode( $section, false );
				else
					$section = '<div class="mpl-infinite-loop">'.__('Section content is empty, please edit section to add content', 'mageewp-page-layout').'</div>';
				/*
				*	Set back primary
				*/
				$this->content_master = $is_master;
				
				/*
				*	unset to work for next seciton link
				*/
				unset( $this->prevent_infinite_loop[ $atts['__section_link'] ] );
			}
			else
			{
				$section = '<div class="mpl-infinite-loop">'.__('MPL fatal error occurred: Infinite loop when trying to include section', 'mageewp-page-layout').'</div>';
			}
			
			if ($this->action == 'live-editor')
			{
				$atts['content'] = '';
				$model = count( $this->storage );
				$storage = array( 
					'args' => $atts, 
					'name' => $tag,
					'content' => '',
					'end' => '[/'.$tag.']', 
					'full' => $m[0]
				);

				$this->storage[ $model ] = $storage;
			
				//2017/05/10 10:47
				//$section = '<!--mpl s '.$model.'-->'.trim($section).'<!--mpl e '.$model.'-->';
				
				/*
				*	Add to 
				*/
			}
				
			return $section;
		}
		
		/*
		*	Render id for each element
		*/
		
		if( !isset( $atts['_id'] ) || empty( $atts['_id'] ) || in_array( $atts['_id'], $this->prevent_duplicate_ids) ) {
			$atts['_id'] = rand(23035, 4362247);
		}
		/*
		*	Make sure the id of elements is unique
		*/
		array_push( $this->prevent_duplicate_ids, $atts['_id'] );
		
		$atts['_css'] = array();
							
		// Move all custom css to header css
		
		if( isset( $atts['css'] ) ){

			$strs = explode( '|', $atts['css'] );

			if( isset( $strs[1] ) && !empty( $strs[1] ) )
				$strs = explode( ';', $strs[1] );
			else if( !empty( $strs[0] ) )
				$strs = explode( ';', $strs[0] );
			
			foreach( $strs as $str ){
				$str = explode( ':', $str );
				if( !empty($str[0]) )
					$atts['_css'][] = '`'.$str[0].'`:`'.$str[1].'`';	
			}
			
			unset( $atts['css'] );

		}
		
		// Process width for columns
		if( isset( $atts['width'] ) && strpos($atts['width'], '%') !== false )
			$atts['_css'][] = '`width`:`'.esc_attr($atts['width']).'`';

		if( count( $atts['_css'] ) > 0 ){
			$css_code .= $this->render_element_css( '{`mpl-css`:{`1000-5000`:{`group`:{'.esc_attr(implode( ',', $atts['_css'] )).'}}}}', $atts['_id'] );
			unset( $atts['_css'] );
		}

		if (is_array( $atts ))
		{
			foreach($atts as $k => $v)
			{
				/*
				*	@since ver 2.5 
				*	Process fields have the type is css
				*/
				
				if ((isset($params[$k]) && is_array($params[$k]) && $params[$k]['type'] == 'css') || strpos($k, '_css_inspector') === 0) {
					$css_code .= $this->render_element_css( $v, $atts['_id'] );
				} else if (is_string($v)) {
					if( $k == '__empty__' )
						$atts[$k] = '';
					else $atts[$k] = $mpl->unesc( $v );
				}
			}
			
			if( $css_code !== '' )
				$this->css_str .= '/*s'.$atts['_id'].'*/'.$css_code.'/*e'.$atts['_id'].'*/';
			
			unset( $atts['_css'] );
		}

		$atts['__name'] = $tag;

		// add # for name of container
		if( isset( $atts['__'] ) ){
			$atts['__name'] .= $atts['__'];
			unset( $atts['__'] );
		}

		if( $closed == '[/'.esc_attr( $tag ).']' ){

			if ( isset( $m[5] ) && !empty( $m[5] ) )
				$atts['__content'] = $this->do_filter_shortcode( str_replace( $tag.'#', $tag, $m[5] ), $this->content_master );
			else
				$atts['__content'] = '';

		}

		$new_atts = '';
		$new_atts = apply_filters( 'shortcode_'.$tag, $atts );
		
		if( !is_array( $new_atts ) )
			$new_atts = $atts;
			
		if ($maps !== false && isset($maps['assets']) && is_array($maps['assets'])) {
			if (isset($maps['assets']['styles']) && is_array($maps['assets']['styles'])) {
				foreach($maps['assets']['styles'] as $key => $url)
					wp_enqueue_style($key);
			}
			if (isset($maps['assets']['scripts']) && is_array($maps['assets']['scripts'])) {
				foreach($maps['assets']['scripts'] as $key => $url){
					wp_enqueue_script($key);
				}
			}
		}
		
		return $m[1] . $this->filter_return( $new_atts ) .$m[6];
	}

	public function shortcode_parse_atts($text) {
		
	    $atts = array();
	    $pattern = '/([a-zA-Z0-9\-\_\.]+)="([^"]+)+"/';
	    $text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);
	    if ( preg_match_all($pattern, $text, $match, PREG_SET_ORDER) ) {
            foreach ($match as $m) {
                if (!empty($m[1]))
                        $atts[strtolower($m[1])] = stripcslashes($m[2]);
                elseif (!empty($m[3]))
                        $atts[strtolower($m[3])] = stripcslashes($m[4]);
                elseif (!empty($m[5]))
                        $atts[strtolower($m[5])] = stripcslashes($m[6]);
                elseif (isset($m[7]) && strlen($m[7]))
                        $atts[] = stripcslashes($m[7]);
                elseif (isset($m[8]))
                        $atts[] = stripcslashes($m[8]);
            }
            // Reject any unclosed HTML elements
            foreach( $atts as &$value ) {
                if ( false !== strpos( $value, '<' ) ) {
                        if ( 1 !== preg_match( '/^[^<]*+(?:<[^>]*+>[^<]*+)*+$/', $value ) ) {
                                $value = '';
                        }
                }
            }
	    } else {
	            $atts = ltrim($text);
	    }
	    return $atts;
	}

	public function filter_return( $atts ){
	
		global $mpl;
		
		$full = '['.$atts['__name'];
		$maps = $mpl->get_maps();
		$pure_name = str_replace( '#', '', $atts['__name'] );
		
		foreach( $atts as $k => $v ){
			if( $k != '__name' && $k != '__content' )
				$full .= ' '.$k.'="'.esc_attr($v).'"';
		}

		$full .= ']';
		
		if (in_array($pure_name, array('mpl_column', 'mpl_column_inner')) || 
			in_array($pure_name, $mpl->maps_view) ||
			(isset($maps[$pure_name]['nested']) && $maps[$pure_name]['nested'] === true)
		) $is_nested = true;
		else $is_nested = false;
		
		if (isset($atts['__content']) || $is_nested){

			$full .= isset($atts['__content']) ? $atts['__content'] : '';

			//2017/05/10 10:53			
			//if( $this->action == 'live-editor' && $this->content_master === true && $is_nested){
			//	$full .= '<div class="mpl-element drag-helper" data-model="-1"><a href="javascript:void(0)" class="mpl-add-elements-inner"><i class="sl-plus mpl-add-elements-inner"></i></a></div>';
			//}	
			
			$full .= '[/'.$atts['__name'].']';
		}

		if( $this->action == 'live-editor' && $this->content_master === true ){
			
			if( isset( $atts['__name'] ) )
				$atts['__name'] = explode( '#', $atts['__name'] );
				
			if( isset( $atts['__content'] ) ){
				$atts['content'] = preg_replace( '/<!--(.*)-->/Uis', '', $atts['__content'] );
				unset( $atts['__content'] );
			}
				
			$model = count( $this->storage );
			$storage = array( 'args' => $atts, 'name' => $atts['__name'][0], 'full' => preg_replace( '/<!--(.*)-->/Uis', '', $full ) );
			
			if( isset( $atts['content'] ) )
				$storage['end'] = '[/'.$storage['name'].']';
			
			$this->storage[ $model ] = $storage;
			
			//2017/05/10 10:53
			//$full = '<!--mpl s '.$model.'-->'.trim($full).'<!--mpl e '.$model.'-->';
		}
		return $full;
	}
	
	public function render_element_css( $code, $id ) {

		global $mpl;

		$css_code = '';
		$css_any_code = '';
		$css_desktop_code = '';
		$pro_maps = array( 
			'margin' => array('margin-top','margin-right','margin-bottom','margin-left'), 
			'padding' => array('padding-top','padding-right','padding-bottom','padding-left'), 
			'border-radius' => array('border-top-left-radius','border-top-right-radius','border-bottom-right-radius','border-bottom-left-radius')
		);
			
		try {
			/*
			*	Decode JSON object
			*/		
			$screens = json_decode( str_replace( '`', '"', $code ), true );
			/*
			*	Sort screens
			*/
			if (is_array( $screens['mpl-css']))
			{
				krsort ($screens['mpl-css']);
				foreach ($screens['mpl-css'] as $screen => $groups)
				{
					$css_array = array(); 
					$css_code_itm = '';
					
					foreach ($groups as $group => $properties)
					{
						foreach ($properties as $sel => $css)
						{
							$sel = explode( '|', $sel );
							
							if ($sel[0] == 'gap')
								$prefix = '';
							else $prefix = 'body.mpl-css-system ';
							
							if (!empty( $sel[1]))
							{
								$_sel = explode(',', $sel[1]);
								$selector = array();
								
								foreach ($_sel as $__sel)
								{
									/*
									*	add spacing for selector which is not :hover
									*/			
									
									$__sel = $mpl->unesc($__sel);
									
									if (strpos( trim($__sel), '+') === 0)
										$__sel = substr(trim($__sel), 1);
									else if (strpos( trim($__sel), ':') !== 0)
										$__sel = ' '.trim($__sel);
										
									$selector[] = $prefix.'.mpl-css-'.$id.$__sel;
								}
								
								$selector = implode (',', $selector);
							
							}
							else if ($sel[0] == 'gap')
							{
								// set low piorit for gap padding
								$selector = '#page .mpl-css-'.$id;
							}
							else
							{
								$selector = $prefix.'.mpl-css-'.$id;
							}
							
							$gap_selector = $prefix.'.mpl-css-'.$id.'>.mpl-wrap-columns';
							
							// group properties with same selector into one
								 
							if (!isset($css_array[ $selector ]))
								$css_array[ $selector ] = array();
							
							if (!isset($css_array[$gap_selector]))
								$css_array[ $gap_selector ] = array();
							
							if (isset($pro_maps[$sel[0]]) && strpos($css, 'inherit') !== false)
							{
								$css = explode(' ', $css);
								for ($i=0; $i<4; $i++)
								{
									if (!empty($css[$i]) && trim($css[$i]) != 'inherit')
									{
										if (isset($css[4]))
											$css[$i] .= ' '.$css[4];
											
										array_push( $css_array[ $selector ], $pro_maps[$sel[0]][$i].': '.$css[$i] );
									}
								}
							}
							else
							{
								if ($sel[0] == 'gap')
								{
									if( intval($css) < 0 )
										$css = '0px';
										
									array_push( $css_array[ $selector ], 'padding-left: '.$css.';padding-right: '.$css );
									array_push( $css_array[ $gap_selector ], 'margin-left: -'.$css.';margin-right: -'.$css.';width: calc(100% + '.(intval($css)*2).'px)' );
								}
								else if($sel[0] == 'border')
								{
									if (strpos( $css, '|') !== false)
									{	
										$css_line = '';
										
										$css = explode('|', $css);
										$bmap = array('top', 'right', 'bottom', 'left');
										
										for( $cj=0; $cj<4; $cj++ ){
											if( isset( $css[ $cj ] ) && !empty( $css[ $cj ] ) )
												$css_line .= 'border-'.$bmap[$cj].': '.$css[$cj].';';
										}
										array_push( $css_array[ $selector ], $css_line );
									}else array_push( $css_array[ $selector ], $sel[0].': '.$css );
								}
								else if( $sel[0] == 'custom' ) {
									$css = trim( str_replace( array('"', "'", '[', ']'), array('', '', '', ''), $css ) ).'{{{end}}}';
									$css = str_replace( array(';{{{end}}}', '{{{end}}}'), array('', ''), $css );
									array_push( $css_array[ $selector ], $css );
								}
								else if( $sel[0] == 'video-background' ) {
									$json = base64_decode( $css );
								}
								else if( $sel[0] == 'background' ) {
									$css_obj = array( 
										'color' => 'transparent', 
										'linearGradient' => array('',''), 
										'image' => 'none', 
										'position' => '0% 0%', 
										'size' => 'auto', 
										'repeat' => 'repeat', 
										'attachment' => 'scroll', 
										'advanced' => 0 ,
										'parallax_scrolling' => 'no' 
									); $val = '';
									
									$json = base64_decode( $css );
									$json = json_decode( $json, true );
									
									if (is_array( $json ))
									{
										$css_obj = array_merge( $css_obj, $json );
										
										if ($css_obj['linearGradient'][0] !== '')
										{
											if (strpos($css_obj['linearGradient'][0], 'deg') !== false)
											{
												if (isset($css_obj['linearGradient'][1]) && !empty($css_obj['linearGradient'][1]))
												{
													if (!isset($css_obj['linearGradient'][2]) || empty($css_obj['linearGradient'][2]))
													{
														$css_obj['linearGradient'][2] = $css_obj['linearGradient'][1];
													}
												}
											}
											else if (!isset($css_obj['linearGradient'][1]) || empty($css_obj['linearGradient'][1]))
												$css_obj['linearGradient'][1] = $css_obj['linearGradient'][0];
											
											$css_obj['linearGradient'] = implode(', ', $css_obj['linearGradient']);
											$css_obj['linearGradient'] = str_replace(', ,', ', ', $css_obj['linearGradient']);
											
											$val .= 'linear-gradient('.$css_obj['linearGradient'].')';
										}
										
										if ($css_obj['color'] != 'transparent' && $css_obj['color'] !== '')
										{
											if( $val == '' )
												$val .= $css_obj['color'];
											else $val .= ', '.$css_obj['color'];
										}
										
										if ($css_obj['image'] != 'none' && $css_obj['image'] != '')
										{
											if( $val == '' )
												$val .= $css_obj['color'];
											else if( $css_obj['color'] == 'transparent' || $css_obj['color'] === '' )
												$val .= ', transparent';
											
											$val .= ' url('.$css_obj['image'].') '.$css_obj['position'].'/'.$css_obj['size'].' '.$css_obj['repeat'].' '.$css_obj['attachment'];
										}
										if (!empty($val))
											array_push( $css_array[ $selector ], $sel[0].': '.$val );
									}
									else if(!empty($css))
									{
										array_push( $css_array[ $selector ], $sel[0].': '.$css );
									}
								}
								else array_push( $css_array[ $selector ], $sel[0].': '.$css );
							}
						}
					}
					
					foreach( $css_array as $sel => $pros ) {
						if( !empty( $pros ) ){
							$css_code_itm .= $sel.'{'.str_replace( array('{','}'), array('',''), implode( ';', $pros )).';}';
						}
					}
					
					if ($screen != 'any')
					{
						
						if( strpos( $screen, '-' ) === false ){
							$css_code .= '@media only screen and (max-width: '.trim($screen).'px){'.$css_code_itm.'}';
						}else{
							$screenx = explode('-', $screen);
							$css_code .= '@media only screen and (min-width: '.trim($screenx[0]).'px) and (max-width: '.trim($screenx[1]).'px){'.$css_code_itm.'}';
						}
						
					}else{
						$css_any_code .= $css_code_itm;
					}
					
					if( !isset( $this->css_obj[ $screen ] ) || !is_array( $this->css_obj[ $screen ] ) )
						$this->css_obj[ $screen ] = array();

					// Group all properties in the same screen
					$this->css_obj[ $screen ][] = $css_code_itm;
				}
			}
		}
		catch( Exception $e ) {
			 echo "\n\n/*Caught exception: ",  $e->getMessage(), "*/\n\n";
		};
		
		return mpl_images_filter($css_any_code.$css_code);
	}

	public function front_head() {
		if ($this->allows) {
			echo '<script type="text/javascript">'.$this->render_dynamic_js().'</script>';
			$this->render_dynamic_css();
		}
		// inline editor params
		$mpl_current_url = home_url(add_query_arg(array()));
		if(current_user_can ('publish_pages') && stristr($mpl_current_url, 'mpl_action=live-editor')) {
			$this->mpl_editor_admin_header();
		}
	}

	public function front_footer() {
		//$mpl_current_url = home_url(add_query_arg(array()));  
		//if(current_user_can ('publish_pages') && stristr($mpl_current_url,'mpl_action=live-editor')) {	
		//	$this->mpl_fronteditor_post_meta();
		//}
	}

	public function register_assets() {

	    $this->register_style('bootstrap', $this->vendor_script_url('bootstrap/css','bootstrap' . $this->min . '.css'));
	    $this->register_style('font-awesome', $this->vendor_script_url('font-awesome/css','font-awesome' . $this->min . '.css'));
		$this->register_style('prettyphoto', $this->vendor_script_url('prettyPhoto/css','prettyPhoto' . $this->min . '.css'));
		$this->register_style('owl-carousel', $this->vendor_script_url('owl-carousel/assets','owl.carousel' . $this->min . '.css'));
		//$this->register_style('owl-theme-default', $this->vendor_script_url('owl-carousel/assets','owl.theme.default.css'));
		$this->register_style('jquery-mb-ytplayer', $this->vendor_script_url('YTPlayer/css','jquery.mb.YTPlayer.min.css'));
		$this->register_style('jquery-mb-vimeo_player', $this->vendor_script_url('vimeo_player/css','jquery.mb.vimeo_player.min.css'));

		$styles = apply_filters( 'mpl_register_styles', array() );
		if( is_array( $styles ) && count( $styles ) ){
			foreach( $styles as $sid => $url ){
				if (!empty($url)) $this->register_style( $sid, $url );
			}
		}
		
		#Register scripts
        $this->register_script('bootstrap', $this->vendor_script_url('bootstrap/js','bootstrap' . $this->min . '.js'));
		
		$this->register_script('owl-carousel', $this->vendor_script_url('owl-carousel','owl.carousel' . $this->min . '.js'));

		$this->register_script('jquery-counterup', $this->vendor_script_url('jquery-counterup','jquery.counterup' . $this->min . '.js'));

		//lightbox script have to add latest
		$this->register_script('prettyphoto', $this->vendor_script_url('prettyPhoto/js','jquery.prettyPhoto' . $this->min . '.js') );
				
		$this->register_script('jquery-easypiechart', $this->vendor_script_url('jquery-easy-pie-chart','jquery.easypiechart.min.js'));

		//video background
		$this->register_script('jquery-mb-ytplayer', $this->vendor_script_url('YTPlayer','jquery.mb.YTPlayer' . $this->min . '.js'));
		$this->register_script('jquery-mb-vimeo_player', $this->vendor_script_url('vimeo_player','jquery.mb.vimeo_player' . $this->min . '.js'));


		//facebook isotope
		$this->register_script('isotope-pkgd', $this->vendor_script_url('isotope','isotope.pkgd.min.js'));
		
		//waypoint
		$this->register_script('jquery-waypoints', $this->vendor_script_url('waypoints','jquery.waypoints.min.js'));
		
		//jquery parallax
		$this->register_script('jquery-parallax', $this->vendor_script_url('jquery-parallax','jquery.parallax-1.1.3.js'));
		

		$scripts = apply_filters( 'mpl_register_scripts', array() );

		if( is_array( $scripts ) && count( $scripts ) ){
			foreach( $scripts as $sid => $url ){
				if (!empty($url)) $this->register_script( $sid, $url );
			}
		}
	}

	public function load_scripts(){

		global $mpl;
		$settings = $mpl->settings();
		
		/*
		*	enqueue fonts from general settings
		*/
		$mpl->enqueue_fonts();
		
		$styles = array(
			
			'mpl-sections' => array(
				'src'     => $this->MPL_URL.'css/sections' . $this->min . '.css',
				'deps'    => '',
				'version' => MPL_VERSION,
				'media'   => 'all'
			),
			'mpl-portfolio-post' => array(
				'src'     => $this->MPL_URL.'css/custom-posts.css',
				'deps'    => '',
				'version' => MPL_VERSION,
				'media'   => 'all'
			),
			
		);
		
		
		if (!isset($settings['animate']) || $settings['animate'] != 'disabled')
		{
			$styles['mpl-animate'] = array(
				'src'     => untrailingslashit(MPL_URL).'/assets/css/animate.css',
				'deps'    => '',
				'version' => MPL_VERSION,
				'media'   => 'all'
			);
		}
		
		if ($this->action == 'live-editor') {

			$styles['mpl-backend-builder'] = array(
				'src'     => str_replace( array( 'http:', 'https:' ), '', untrailingslashit( MPL_URL ) ) . 
							 '/assets/css/mpl.builder' . $this->min . '.css',
				'deps'    => '',
				'version' => MPL_VERSION,
				'media'   => 'all'
			);
		}
		
		$icon_sources = $mpl->get_icon_sources();
		if( is_array( $icon_sources ) && count( $icon_sources ) > 0 ){
			$i = 1;
			foreach( $icon_sources as $icon_source ){
				$styles['mpl-icon-'.$i++] = array(
					'src'     => $icon_source,
					'deps'    => '',
					'version' => MPL_VERSION,
					'media'   => 'all'
				);
			}
		}
		
		wp_enqueue_style( 'bootstrap' );
		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'owl-carousel' );
		wp_enqueue_style( 'owl-theme-default' );
		wp_enqueue_style( 'prettyphoto' );
		wp_enqueue_style( 'jquery-mb-yptlayer');
		wp_enqueue_style( 'jquery-mb-vimeo_player');
		
		foreach ( apply_filters( 'mpl_enqueue_styles', $styles ) as $handle => $args ) {
			wp_enqueue_style( $handle, $args['src'], $args['deps'], $args['version'], $args['media'] );
		}
		
		
		wp_enqueue_script( 'bootstrap' );
		wp_enqueue_script( 'owl-carousel' );
		wp_enqueue_script( 'prettyphoto' );
		wp_enqueue_script( 'jquery-easypiechart' );
		wp_enqueue_script( 'jquery-mb-ytplayer' );
		wp_enqueue_script( 'jquery-mb-vimeo_player' );

		wp_enqueue_script( 'isotope-pkgd' );
		wp_enqueue_script( 'jquery-waypoints' ); 
		wp_enqueue_script( 'jquery-parallax');
		
		
		$js_path = $this->MPL_URL . 'js/main.js';
		
		$scripts = array(
			'mpl-front-scripts' => $js_path
		);
		
		foreach ( apply_filters( 'mpl_enqueue_scripts', $scripts ) as $uid => $url ) {
			$this->enqueue_script( $uid, $url );
		}
	}
	
	public function el_class( $atts ){
		
		global $mpl,$post;
		$settings = $mpl->settings();
		$el_class = array();

		$postid = isset($post->ID)? $post->ID : "";
		$post_fullpage = get_post_meta($postid, 'peony_fullpage', true);
		$post_animation = get_post_meta($postid, 'peony_animation', true);
		
		if (!empty($atts['shortcode']))
			$el_class[] = $atts['shortcode'];
		
		$el_class[] = 'mpl-elm';
		if (!empty($atts['_id'])) {
			$el_class[] = 'mpl-css-' .$atts['_id'];
		}

		if (!empty($atts['css']))
			$el_class[] = $atts['css'];
		
		if (isset($atts['width']))
			$el_class[] = mpl_column_width_class($atts['width']);
		
		if (isset($atts['section_class']))
			$el_class[] = $atts['section_class'];
		
		if (!isset($settings['animate']) || $settings['animate'] != 'disabled')
		{
			if (isset($atts['animate']) && !empty($atts['animate']))
			{
				$ani = explode('|', $atts['animate']);
				if (isset($ani[0]) && !empty($ani[0]))
					$el_class[] = 'mpl-animated mpl-animate-eff-'.esc_attr($ani[0]);	
				if (isset($ani[1]) && !empty($ani[1]))
					$el_class[] = 'mpl-animate-delay-'.esc_attr($ani[1]);
				if (isset($ani[2]) && !empty($ani[2]))
					$el_class[] = 'mpl-animate-speed-'.esc_attr($ani[2]);
			}
		}
		
		if ( isset($atts['css_custom']) && $atts['css_custom'] != '' ){
			$css_custom = @json_decode( str_replace( '`', '"', $atts['css_custom']), true );
			if ( isset($css_custom['mpl-css']['any']['background']['background|'])  ){
					$background  = @base64_decode($css_custom['mpl-css']['any']['background']['background|']);
					$background  = @json_decode($background ,true);
					if ( isset($background['parallax_scrolling']) && $background['parallax_scrolling'] == 'yes' ){
						
						$el_class[] = 'mpl-parallax-scrolling';
						
						}
				}
	
	}
		
		return $el_class;
	}
	
	public function owl_carousel( $atts ) {
		$owl = array();

		$owl['carousel'] = '';
		$owl['options'] = '';
		$owl['nav_style'] = '';
		if (isset($atts['carousel']) && $atts['carousel'] == "yes") {
			$owl_options = array(
				'items' 		=> isset($atts['columns']) ? $atts['columns'] : 1,
				'speed' 		=> intval(isset($atts['owl_speed']) ? $atts['owl_speed'] : '500' ),
				'navigation' 	=> isset($atts['owl_navigation']) ? $atts['owl_navigation'] : '',
				'pagination' 	=> isset($atts['owl_pagination']) ? $atts['owl_pagination'] : '',
				'autoheight' 	=> isset($atts['owl_auto_height']) ? $atts['owl_auto_height'] : '',
				'autoplay' 		=> isset($atts['owl_auto_play']) ? $atts['owl_auto_play'] : ''
			);

			$owl['carousel'] = 'yes';
			$owl['options'] = "data-owl-options='" .strtolower(json_encode($owl_options)) ."'";
			$owl['nav_style'] = '';
			if (isset($atts['owl_navigation']) && $atts['owl_navigation'] === 'yes') {
				$owl['nav_style'] = 'owl-nav-' . $atts['owl_nav_style'];
			}
		}
		return $owl;
	}

	public function do_shortcode( $content ){

        //$this->css_str = '';
		$this->css_obj = array();
		$this->prevent_infinite_loop = array();
		
		$html = $this->do_filter_shortcode( $content, false );

		return '<style type="text/css">'.$this->render_css( $this->css_obj ).'</style>'.do_shortcode( $html );
	}
	
	public function render_css( $obj ){
		
		$any = ''; $css = ''; $item = '';
		
		if( is_array( $obj ) ){
			
			//krsort($this->css_obj);

			foreach( $obj as $screen => $properties ){
				
				$item = '';
				
				if( $screen == 'any' ){
					$any .= implode('', $properties);
				}else{
					
					if( strpos( $screen, '-' ) === false ){
						$item .= '@media only screen and (max-width: '.trim($screen).'px){'.implode('', $properties).'}';
					}else{
						$screen = explode('-', $screen);
						$item .= '@media only screen and (min-width: '.trim($screen[0]).'px) and (max-width: '.trim($screen[1]).'px){'.implode('', $properties).'}';
					}
					
					if (is_array($screen))
						$screen = implode('-', $screen);
					
					if ($screen == '1000-5000')
						$any = $item.$any;
					else $css .= $item;
					
				}
			}
			
		}
		
		return mpl_images_filter($any.$css);
		
	}
	
	public function body_classes( $classes ) {

		global $post;

		if( !empty( $post->ID ) )
		{
			$post_data = get_post_meta( $post->ID , 'mpl_data', true );

			if( !empty( $post_data['classes'] ) )
				$classes[] = $post_data['classes'];
		}
        return $classes;

	}

	public function vendor_script_url($vendor_dir, $srcipt_file){
		return untrailingslashit(MPL_URL).'/includes/frontend/vendors/'.$vendor_dir.'/'.$srcipt_file;
	}

	public function register_script( $handle, $path, $deps = array( 'jquery' ), $version = MPL_VERSION, $in_footer = true ) {
		$this->scripts[] = $handle;
		wp_register_script( $handle, $path, $deps, $version, $in_footer );
	}

	public function register_style( $handle, $path, $deps = array(), $version = MPL_VERSION, $media = 'all' ) {
		$this->styles[] = $handle;
		wp_register_style( $handle, $path, $deps, $version, $media );
	}

	public function enqueue_script( $handle, $path = '', $deps = array( 'jquery' ), $version = MPL_VERSION, $in_footer = true ) {
		
		if ( ! in_array( $handle, $this->scripts ) && $path ) {
			$this->register_script( $handle, $path, $deps, $version, $in_footer );
		}
		wp_enqueue_script( $handle );
	}

	private function allowed_access(){

		global $mpl;

		$settings = $mpl->settings();


		if( !isset( $settings['content_types'] ) )
			$settings['content_types'] = array();

		$content_types = array_merge( (array)$settings['content_types'], (array)$mpl->get_required_content_types() );

		$this->allows = is_singular( $content_types );
		
		return $this->allows;

	}

	private function render_dynamic_js(){
		if( !empty( $this->js ) )
			printf( $this->js );
	}

	public function add_header_js( $js = '' ){
		if( !empty( $js ) )
			$this->js .= $js;
	}

	public function add_header_css( $css = '' ){
		if( !empty( $css ) )
			$this->css .= $css;
	}

	public function add_header_css_responsive( $screen = '', $css = '' ){

		if( !empty( $screen ) && !empty( $css ) ){

			if( !isset( $this->css_responsive[ $screen ] ) )
				$this->css_responsive[ $screen ] = array();

			array_push( $this->css_responsive[ $screen ], $css );

		}
	}

	private function render_dynamic_css(){

		global $post, $mpl;
		

		$post_data = get_post_meta ($post->ID , 'mpl_data', true);
		$settings = $mpl->settings();

		if (!empty($post_data) && !empty($post_data['css']))
			$this->css .= $post_data['css'];
			
		if (!empty( $settings['css_code']))
			$this->css .= $settings['css_code'];
			
		
		if (!empty($post_data) && isset($post_data['max_width']) && !empty($post_data['max_width']))
			$this->css .= '.mpl-container{max-width: '.esc_attr($post_data['max_width']).';}';
		else if (!empty($settings['max_width']) && isset($settings['max_width']) && !empty($settings['max_width']))
			$this->css .= '.mpl-container{max-width: '.esc_attr($settings['max_width']).';}';
		
		$this->css = esc_html ($this->css);
		$this->css = str_replace(
					array( "\n","  ", ": ", " {", "  ", '&gt;', '&lt;', '&quot;', '&#039;', "</style>", "<style", "<script", "</script"),
					array( '', ' ', ':', '{', " ", '>', '<', '"', "'", "&lt;/style&quot;", "&lt;style", "&lt;script", "&lt;/script"),
					$this->css
				);
		
		$this->css = mpl_images_filter($this->css);
					
		echo '<style type="text/css" id="mpl-css-general">.mpl-off-notice{display: inline-block !important;}'.$this->css.'</style>';

		/*
		*	Start render CSS of all elements
		*/

		if ($this->action == 'live-editor')
			$this->css = $this->css_str;
		else
			$this->css = $this->render_css ($this->css_obj_master);

		$this->css = str_replace(
					array( "\n","  ", ": ", " {", "  ", '&gt;', '&lt;', '&quot;', '&#039;', "</style>", "<style", "<script", "</script"),
					array( '', ' ', ':', '{', " ", '>', '<', '"', "'", "&lt;/style&quot;", "&lt;style", "&lt;script", "&lt;/script"),
					$this->css
				);
				
		$this->css = mpl_images_filter($this->css);
		echo '<style type="text/css" id="mpl-css-render">'.$this->css.'</style>';


	}

	public function preg_match_css( $matches ){

		if( !empty( $matches[1] ) ){

			if( strpos( $matches[1], '|' ) !== false ){

				$class = substr( $matches[1], 0, strpos( $matches[1], '|' ) );
				if( strpos( $this->css, '.'.$class.'{' ) === false )
				{
					$this->css .= '.'.$class.'{'.substr( $matches[1], strpos( $matches[1], '|' ) + 1 ).'}';
				}
				return ' css="'.$class.'"';
			}
			else
			{
				$this->css .= $matches[1];
				return '';
			}
		}
		else return $matches[0];

	}
	
	public function get_tags_filter(){
		return $this->tags_filter;
	}
	
	public function get_global_css(){
		return $this->css = mpl_images_filter($this->css);
	} 
	
    public function mpl_editor_admin_header() 
	{
		if (is_admin() && !mpl_admin_enable())
			return;

		global $mpl,$post;

		$meta = $mpl->get_post_meta();
		/*
		*	The builder is active, force the wp editor to tinyMCE
		*	To load faster tinyMCE in the builder
		*/
		if ($meta['mode'] == 'mpl') {
			add_filter ('wp_default_editor', 'mpl_force_default_editor');
		}
		?>
		<script type="text/javascript">
			top.window.mpl_post_id = <?php global $post; echo $post->ID;?>;
			top.window.mpl_post_title = '<?php global $post; echo $post->post_title;?>';
			top.window.mpl_post_status = '<?php global $post; echo $post->post_status;?>';
			top.window.mpl_post_content = '<?php global $post; echo base64_encode($post->post_content);?>';
			top.window.mpl_current_url = '<?php echo home_url(add_query_arg(array()));?>';
			top.window.mpl_edit_post_url = '<?php global $post; echo get_edit_post_link($post->ID, '&'); ?>';
			top.window.mpl_post_url = '<?php global $post; echo get_permalink($post->ID); ?>';
			
		</script>
		<?php
	}

    public function mpl_fronteditor_post_meta()
	{
		global $mpl,$post;

		echo '<div style="display:none;">';
		$data = array(
			"mode" => "", 
			"classes" => "", 
			"css" => "", 
		);

		if (isset($post ) && isset( $post->ID ) && !empty( $post->ID)) {
			$get_data = (array)get_post_meta ($post->ID , 'mpl_data', true);
			if (!empty($get_data) && is_array($get_data)) {
				foreach ($get_data as $name => $value) {
					if (isset($data[$name]))
						$data[$name] = $value;
				}
			}
		}

		if ($mpl->action == 'live-editor' || (defined('MPL_FORCE_DEFAULT') && MPL_FORCE_DEFAULT === true)) {
			$data['mode'] = 'mpl';
		}

		foreach ($data as $key => $val) {
			echo '<input type="hidden" name="mpl_post_meta['.$key.']" id="mpl-page-cfg-'.$key.'" value="'.esc_attr($val).'" />';
		}

		$global_optimized = array_merge(array('enable' => '', 'global' => '', 'advanced' => ''), (array)get_option('mpl_optimized'));

		if ($data['mode'] == 'mpl') {
			echo '<style type="text/css">'.
					'#postdivrich{visibility: hidden;position:relative;}#mpl-switcher-buttons{display:none;}'.
				'</style>'.
				'<script tyle="text/javascript">'.
					'if(document.getElementById("postdivrich"))document.getElementById("postdivrich").className+=" first-load";'.
				'</script>';
		}
		echo '<script tyle="text/javascript">var mpl_global_optimized = '.json_encode($global_optimized).';</script>';
		echo '</div>';
	}

	public function render_video_background($atts)
	{
		$output = array();
		$video_type = '';
		$video_url = '';
		$mp4_url = '';
		$ogv_url = '';
		$webm_url = '';
		$start_time = '';
		$stop_time  = '';
		$video_mute = '';
		$enable_video_bg = '';
		$containment = '';

		$output = '';
		if (!isset($atts['css_custom']) || !isset($atts['_id']))
			return $output;
		
		$css_custom = $atts['css_custom'];
		$id = $atts['_id'];

		$screens = json_decode( str_replace( '`', '"', $css_custom ), true );
		if (!is_array( $screens['mpl-css']))
			return $output;

		krsort ($screens['mpl-css']);
		foreach ($screens['mpl-css'] as $screen => $groups)
		{
			foreach ($groups as $group => $properties)
			{
				foreach ($properties as $sel => $css)
				{
					$sel = explode( '|', $sel );

					if ($sel[0] != 'video-background')
						continue;

					$json = base64_decode( $css );
					$bgatts = json_decode( $json, true );

					extract($bgatts);

					if ($enable_video_bg != 'yes' && $enable_video_bg != '1')
						return $output;

					$output = 'data-property="{';
					$video_type = isset($video_type) ? $video_type : 'youtube';
					$containment = '.mpl-css-'.$id;
					//$containment = 'self';

					if ($video_type == 'youtube') {
						$output .= "videoURL:'" .$video_url ."',";
						$video_type = 'mpl-youtube-video';
					}
					else if ($video_type == 'vimeo') {
						$output .= "videoURL:'" .$video_url ."',";
						$video_type = 'mpl-vimeo-video';
					}
					else if ($video_type == 'html5') {
						$output .= "mp4URL:'" .$mp4_url ."',";
						$output .= "ogvURL:'" .$ogv_url ."',";
						$output .= "webmURL:'" .$webm_url ."',";
						$video_type = 'mpl-html5-video';
					}					
					else
						$output .= '';
					$output .= 'containment:\'' .$containment. '\',showControls:false';

					$output .= ',autoPlay:true';

					if ($video_loop == '1' || $video_loop == 'yes')
						$output .= ',loop:true';

					if ($video_mute !== '1' && $video_mute !== 'yes')
						$output .= ',mute:false';

					if (!empty($start_time))
						$output .= ',startAt:' .$start_time;
					
					if (!empty($stop_time)) 
						$output .= ',stopAt:' .$stop_time;
					
					$output .= ',opacity:1,addRaster:false,quality:\'default\'}"';

					$output = '<div id="bgndVideo" class="player ' .$video_type .'" ' .$output .'></div>';
				}
			}
		}
		return $output;
	}
}

/*
*-------------------------------
*/

global $mpl_front;
$mpl_front = new mpl_front();
