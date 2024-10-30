<?php
/*
Plugin Name: Mageewp Page Layout
Description: Mageewp Page Layout, accompanied with different kinds of page layout styles, makes page building and editing a much easier thing.
Version: 2.1.4
Author: Mageewp
Author URI: https://www.mageewp.com/
Text Domain: mageewp-page-layout
Domain Path: /languages
*/

if ( defined('MPL_VERSION') || isset( $GLOBALS['mpl'] ) ) {
    die('ERROR: the plugin has been loaded before.');
}
/**
*	unorthodox
*/
if ( !defined('ABSPATH') ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}
/**
*	Start
*/
class MageewpPageLayout{
    /**
    *	Global Settings
    */
    private $settings = array();
    /**
    * Definde where to load shortcode template
    */
    private $template_path = null;
    /**
    * Definde where to load templates library
    */
    private $templates_path = null;
    /**
    * Definde where to load shortcodes function
    */
    private $shortcodes_function_path = null;
    /**
    * re-definde where to load shortcode template such as in theme or 3rd party plugin
    */
    private $template_path_extend = array();
    /**
    * re-definde where to load templates library such as in theme or pro plugin
    */
    private $templates_library_path = array();
    /**
    * register list of external sections
    */
    private $profile_section_paths = array();
    /**
    * re-definde where to load shortocdes function such as in theme or pro plugin
    */
    private $shortcodes_function_path_extend = array();
    /**
    * Maps of core & extended
    */
    private $maps = array();
    /**
    * list of views
    */
    public $maps_views = array();
    /**
    * list of views
    */
    public $maps_view = array();
    /**
    * Param types
    */
    public $param_types = array();
    /**
    *	WP Add_Shortcode $shortcode_tags
    */
    public $shortcode_tags = array();
    /**
    *	support content types
    */
    private $param_types_cache = array();
    /**
    *	Support icons
    */
    private $icon_sources = array();
    
    /**
    *	support content types
    */
    private $content_types = array();
    /**
    *	required content types
    */
    private $required_content_types = array( 'page' );
    /**
    *	ignored content types use as section
    */
    private $ignored_section_content_types = array();
    /**
    *	All filters of shortcodes
    */
    public $filters = array();
    /**
    *	Register filters for shortcodes
    */
    public $add_filters = array();
    /**
    *	register callback for live view on front-end editor
    */
    public $live_js_callback = array();
    /**
    *	status of premium version
    */
    public $verify = false;
    /**
    *	Default Key
    */
    public $key = '';
    /**
    *	DD PP KK
    */
    private $pdk = array( 'pack' => '', 'date' => '', 'stt' => 0 );
    /*
    * MPL Action request
    */
    public $action;
    /*
    * MPL Optimized
    */
    public $optimized;
    /*
    *	register prebuilt templates
    */
    private $prebuilt_templates = array();
    /*
    *	load assets from map
    */
    private $map_styles = array();
    private $map_scripts = array();
    
    public function __construct() {
        // Constants
        $version = get_file_data( __FILE__, array('Version') );
        define('MPL_VERSION', $version[0] );
        define('MDS', DIRECTORY_SEPARATOR );
        define('MPL_FILE', __FILE__);
        define('MPL_PATH', dirname(__FILE__));
        define('MPL_URL', plugins_url('', __FILE__));
        define('MPL_SLUG', basename(dirname(__FILE__)));
        define('MPL_BASE', plugin_basename(__FILE__));
        define('MPL_SITE', site_url());
        define('MPL_TEXTDOMAIN', 'mageewp-page-layout');
        
        /*
        *	Set default template path
        */
        $this->template_path = MPL_PATH.MDS.'shortcodes'.MDS;
        /*
        *	Set template path for activate theme
        */
        array_push( $this->template_path_extend, get_template_directory().MDS.'mageewp-page-layout'.MDS );
        /*
        *	Set default templates library path
        */
        $this->templates_path = MPL_PATH.MDS.'templates'.MDS;
        /*
        *	Set templates library path for activate theme
        */
        array_push( $this->templates_library_path, get_template_directory().MDS.'templates'.MDS );
        /*
        *	Set default shortocdes function path
        */
        $this->shortcodes_function_path = MPL_PATH.MDS.'shortcodes'.MDS;
        /*
        *	Set shortocdes function path for activate theme
        */
        array_push( $this->shortcodes_function_path_extend, get_template_directory().MDS.'shortcodes'.MDS );
        /*
        *	Get settings
        */
        $this->settings = array(
			"content_types" => array(),
			"css_code" => "",
			"animate" => "",
			"max_width" => "1170px"
        );
        
        if ( get_option('mpl_options') !== false ) {
            $this->settings = get_option('mpl_options', true);
        } else {
            add_option('mpl_options', $this->settings, null, 'no');
        }
        /*
        *	Get PDK informations
        */
        if ( get_option('mpl_tkl_pdk', false) )
            $this->pdk = get_option('mpl_tkl_pdk');
        /*
        *	Load optimized
        */
        $optimized = get_option('mpl_optimized');
        if ( $this->is($optimized, array('enable'), 'on' ) ) {
            require_once MPL_PATH.'/includes/mpl.optimized.php';
            $this->optimized = new mpl_optimized();
        }
        /*
        *	Load builder actions
        */
        require_once MPL_PATH.'/includes/mpl.actions.php';
        require_once MPL_PATH.'/includes/mpl.widgets.php';
        
        /*
        *	Load metabox
        */
        require_once MPL_PATH . '/includes/metabox/metabox.php';
		


        /*
        *	Set request action
        */
        if (isset($_GET['mpl_action']) && !empty($_GET['mpl_action']))
            $this->action = sanitize_title($_GET['mpl_action']);
        else if (isset($_POST['mpl_action']) && !empty($_POST['mpl_action']))
            $this->action = sanitize_title($_POST['mpl_action']);
        
        if( get_option('mpl_tkl_cc') && get_option('mpl_tkl_dd') )
        $this->verify = true;
        /*
        *	Run on wp-init
        */
        add_action( 'init', array( &$this, 'init_first' ), 10 );
        add_action( 'init', array( &$this, 'init' ), 9999 );
        
        register_deactivation_hook(__FILE__, array(&$this, 'deactive'));
        /*
        *	Register assets via map
        */
        add_filter('mpl_register_styles', array( &$this, 'register_map_styles' ));
        add_filter('mpl_register_scripts', array( &$this, 'register_map_scripts' ));
        
        add_action('wp_ajax_mpl_contact',  array( &$this, 'contact_form'));
        add_action('wp_ajax_nopriv_mpl_contact', array( &$this, 'contact_form'));
        add_action('wp_ajax_mpl_get_template',  array( &$this, 'get_template'));
        add_action('wp_ajax_nopriv_mpl_get_templatet', array( &$this, 'get_template'));
		add_action('wp_ajax_mpl_do_shortcode',  array( &$this, 'do_shortcode'));
        add_action('wp_ajax_nopriv_mpl_do_shortcode', array( &$this, 'do_shortcode'));
		
        /*
         *	Load portfolio post type templates
         */
        require_once  MPL_PATH.'/gallery/featured-galleries.php' ;
        
        /*
        *	Load events post type templates
        */
        //require_once MPL_PATH.'/includes/mpl.events_templates.php';
    }
    
    public static function globe() {
        global $mpl;
        
        if ( isset( $mpl ) )
            return $mpl;
        else wp_die('MPL Error: Global varible could not be loaded.');
    }
    
    public function init_first() {
        
        /*
        *	Register events type
        */
        //require_once MPL_PATH.'/includes/mpl.events.php';
        //require_once MPL_PATH.'/includes/mpl.events_metabox_options.php';
        
         /*
        *	Register maps
        */
		$mpl_maps = apply_filters('mpl_maps', MPL_PATH.'/includes/mpl.maps.php' );
        require_once $mpl_maps;
        /*
        *	Register params
        */
		$mpl_param_types = apply_filters('mpl_param_types', MPL_PATH.'/includes/mpl.param.types.php' );
        require_once $mpl_param_types;
    }
    
    public function init() {
        
        /*
        *  add shortcode html
        */
        global $mpl;
        $base = 'shortcodes-tpl.php';
        $path = $mpl->get_shortcodes_function_path( $base );
        if (empty($path))
            $path = $mpl->get_shortcodes_function_default_path( $base );
        
        require_once $path;
        
        add_filter('the_content', array( &$this, 'mpl_filter_content'));
        add_action('mpl_before_admin_footer', array( &$this, 'convert_maps' ) );
        add_action('mpl_after_admin_footer', array( &$this, 'convert_paramTypes' ) );
        
        $this->add_icon_source( MPL_URL.'/assets/css/icons.css' );
        $this->add_icon_source( MPL_URL.'/assets/css/mpl.icons.css' );
        
        $this->register_shortcodes();
        
        /*
        *	Register shortcode filters
        */
        
        $core_filters = apply_filters(
			'mpl-core-shortcode-filters',
			array(
				'row',
				'row_inner',
				'column',
				'tabs',
				'tab',
				'box',
				'video_play',
				'counter_box',
				'carousel_images',
				'twitter_feed',
				'pie_chart',
				'carousel_post',
				'image_gallery',
				'blog_posts'
			)
        );
        
        foreach ($core_filters as $k => $v) {
            
            $this->add_filter ('mpl_'.$v, 'mpl_'.$v.'_filter');
        }
        
        if (is_admin()) {
            /*
            *	auto activate if the license registered
            */
            $this->auto_verify();
		} else {
            global $mpl_front;
            $mpl_front->add_filters();
        }
        
        if ($this->action == 'dismiss' && isset($_GET['nid'])) {
            
            $dismiss = get_option('mpl_notices_dismiss', true);
            if(!$dismiss) {
                $dismiss = array();
                add_option('mpl_notices_dismiss', $dismiss, null, 'no');
            }
            
            if (!is_array($dismiss))
                $dismiss = array();
            
            array_push($dismiss, esc_attr($_GET['nid']));
            
            update_option('mpl_notices_dismiss', $dismiss);
        }
    }
    
    public function deactive(){
        if (isset($this->optimized))
            $this->optimized->deactive();
    }
    
    public function load(){
        // Shared
        require_once MPL_PATH.'/includes/mpl.functions.php';
        require_once MPL_PATH.'/includes/mpl.tools.php';
        require_once MPL_PATH.'/includes/mpl.ajax.php';
        
        // Back-end only
        if( is_admin() ) {
            require_once MPL_PATH.'/includes/frontend/helpers/mpl.ajax.php';
            // Front-end only
        } else {
			$mpl_front = apply_filters('mpl_front',  MPL_PATH.'/includes/mpl.front.php' );
        	require_once $mpl_front;
           
        }
        
    }
    
    
    public function add_map( $map = array(), $flag = '' ){
        /*
        Add to global maps
        */
        
        foreach( $map as $base => $atts )
        {
            
            $atts = apply_filters( 'mpl_add_map', $atts, $base );
            
            if( is_array( $atts ) ){
                
                if (isset($atts['nested']) &&
                    $atts['nested'] === true
                ) {
                    $atts['is_container'] = true;
                    $atts['preview_editable'] = true;
                }
                
                $atts['flag'] = esc_attr($flag);
                
                $this->maps[ $base ] = $atts;
                
                if (isset($atts['filter']) &&
                    !empty($atts['filter'])
                ) {
                    $this->filters[ $base ] = $atts['filter'];
                }
                
                if (isset($atts['views']) &&
                    !empty($atts['views']['sections'])
                ){
                    array_push ($this->maps_views, $base);
                    array_push ($this->maps_view, $atts['views']['sections']);
                }
                
                if (isset($atts['assets']) &&
                    is_array($atts['assets'])
                ) {
                    if (isset($atts['assets']['scripts']) &&
                        is_array($atts['assets']['scripts'])
                    ){
                        $this->map_scripts += $atts['assets']['scripts'];
                    }
                    
                    if (isset($atts['assets']['styles']) &&
                        is_array($atts['assets']['styles'])
                    ){
                        $this->map_styles += $atts['assets']['styles'];
                    }
                }
                
            }
        }
        
    }
    
    public function remove_map( $map = '' ){
        /*
        Add to global maps
        */
        
        if( isset( $this->maps[ $map ] ) )
        unset( $this->maps[ $map ] );
        
    }
    
    public function hide_element( $name = '' ){
        /*
        Add to global maps
        */
        
        if( isset( $this->maps[ $map ] ) ){
            $this->maps[ $map ]['is_system'] = true;
        }
        
    }
    
    public function add_param_type( $name = '', $func = '' ){
        /*
        Add to global params
        */
        if( !empty( $name ) && !empty( $func ) )
        {
            $this->param_types[ $name ] = $func;
        }
        
    }
    
    public function add_param_type_cache( $name = '', $func = '' ){
        /*
        Add to global params
        */
        if( !empty( $name ) && !empty( $func ) )
        {
            $this->param_types_cache[ $name ] = $func;
        }
        
    }
    
    public function get_maps($tag = ''){
        
        if (isset($tag) && !empty($tag)) {
            if (isset($this->maps[$tag]))
                return $this->maps[$tag];
            else return false;
            }
        
        return $this->maps;
        
    }
    
    public function convert_maps(){
        /*
        Convert maps from php to js
        */
        echo '<script type="text/javascript">';
        echo 'var mpl_maps = '.json_encode( (object)$this->maps ).';';
        echo 'var mpl_maps_views = '.json_encode( $this->maps_views ).';';
        echo 'var mpl_maps_view = '.json_encode( $this->maps_view ).';';
        echo '</script>';
        
    }
    
    public function convert_paramTypes(){
        
        $type_support = array();
        foreach ($this->param_types as $name => $func) {
            if (function_exists($func)) {
                
                echo '<script type="text/html" id="tmpl-mpl-field-type-'.esc_attr($name).'-template">';
                $func();
                echo "</script>\n";
                if (!in_array($name, $type_support))
                    array_push ($type_support, $name);
            }
        }
        
        foreach ($this->param_types_cache as $name => $func) {
            if (!in_array($name, $type_support))
                array_push ($type_support, $name);
        }
        
        ?>
  <script type="text/javascript">
    var mpl_param_types_support = <?php echo json_encode($type_support); ?>
  </script>
  <?php
        
    }
    
    public function convert_paramTypes_cache(){
        /*
        Convert param types to js
        */
        foreach ($this->param_types_cache as $name => $func) {
            if (function_exists( $func )) {
                echo '<script type="text/html" id="tmpl-mpl-field-type-'.esc_attr($name).'-template">';
                $func();
                echo "</script>";
            }
        }
        
    }
    
    public function add_map_param($map = '', $param = '', $index = null, $group = '') 
	{
        if( isset( $this->maps[ $map ] ) )
        {
            if( is_array( $param ) )
            {
                $params = array();
                
                if (!empty($group) && isset($this->maps[$map]['params'][$group]))
                {
                    $params =  $this->maps[$map]['params'][$group];
                } else {
                    foreach ($this->maps[ $map ][ 'params' ] as $group => $params) {
                        if ($group === 0) {
                            $params = $this->maps[$map]['params'];
                            $group = '';
                        }
                        break;
                	}
            	}
            
				if( $index == null )
				{
					array_push( $params, $param );
				}
				else if( empty( $params[ $index-1 ] ) )
				{
					array_push( $params, $param );
				}
				else
				{
					
					$new_array = array();
					$done = false;
					$j = 0;
					
					for( $i = 0; $i <= count( $params ); $i++ )
					{
						if( $i != $index - 1 )
						{
							if( isset( $params[$j] ) )
								$new_array[ $i ] = $params[$j];
							$j++;
						}
						else
						{
							$new_array[ $i ] = $param;
							$done = true;
						}
					}
					
					if( $done == false )
						array_push( $new_array, $param );
					
					$params = $new_array;
					
				}
				
				if( $group === '' )
					$this->maps[ $map ][ 'params' ] = $params;
				else 
					$this->maps[ $map ][ 'params' ][$group] = $params;
			}
		}
	}

	public function remove_map_param( $map = '', $name = '', $group = '' ){
		
		if (isset($this->maps[$map]) && isset($this->maps[$map]['params'])) {
			
			if ($name != '') {
				
				$new_array = array();
				$i = 0;
				
				foreach ($this->maps[$map]['params'] as $key => $params) {
					
					if ($group == '' && isset($params[0]) && isset($params[0]['name']))
						$group = $key;
					
					if ($group !== '' && isset($this->maps[$map]['params'][$group])) {
						
						if ($key == $group) {
							
							$new_array = array();
							foreach ($this->maps[$map]['params'][$key] as $nn => $param) {
								if (isset($param['name']) && $param['name'] == $name)
									unset($this->maps[$map]['params'][$key][$nn]);
							}
							
						}
						
					}else{
						
						foreach( $this->maps[$map]['params'] as $nn => $param ){
							if (isset($param['name']) && $param['name'] == $name)
								unset($this->maps[$map]['params'][$nn]);
						}
					}
					
				}
				
				
			}
		}
	}

	public function update_map ($map = '', $name = '', $val = '') {
		
		if (isset($this->maps[$map]))
		{
			if (!isset($this->maps[$map][$name]) && is_array($val))
				$this->maps[$map][$name] = array();
			
			if (is_array($val) && is_array($this->maps[$map][$name])) {
				
				foreach ($val as $n => $v) {
					
					if (is_array($v)) {
						
						if (!is_array($this->maps[$map][$name][$n]))
							$this->maps[$map][$name][$n] = array();
						
						foreach ($v as $k => $l) {
							if (!is_array($l)) {
								$this->maps[$map][$name][$n][$k] = $l;
							} else {
								foreach ($l as $j => $r) {
									$this->maps[$map][$name][$n][$k][$j] = $r;
								}
							}
						}
						
					} else {
						$this->maps[$map][$name][$n] = $v;
					}
				}
			} else if(!is_array($val) && !is_array($this->maps[$map][$name])) {
				$this->maps[$map][$name] = $val;
			}
			
		}
	}

	public function set_default_value ($map = '', $param_name = '', $val = '') {
		
		if (isset($this->maps[$map]))
		{
			foreach ($this->maps[$map]['params'] as $n => $params) {
				if( is_array($params) )
				foreach ($params as $k => $v) {
					
					if( is_array( $v ) && $v['name'] == $param_name ){
						$this->maps[$map]['params'][$n][$k]['value'] = $val;
					}
					
				}
			}
		}
	}

	public function add_icon_source( $source ){
		
		$source = esc_url($source);
		
		$path = str_replace( WP_PLUGIN_URL, untrailingslashit( WP_PLUGIN_DIR ), $source );
		$path = str_replace( site_url(), untrailingslashit( ABSPATH ), $path );
		
		if( is_file( $path ) ){
			$this->icon_sources[] = $source;
		}
		
	}

	public function get_icon_sources(){
		
		return $this->icon_sources;
		
	}

	public function set_template_path( $path ){
		
		if( is_dir( $path ) )
		{
			array_push( $this->template_path_extend, $path );
		}
	}

	public function set_templates_library_path( $path ){
		
		if( is_dir( $path ) )
		{
			array_push( $this->templates_library_path, $path );
		}
	}

	public function set_shortcodes_function_path( $path ){
		
		if( is_dir( $path ) )
		{
			array_push( $this->shortcodes_function_path_extend, $path );
		}
	}

	public function locate_profile_sections( $profiles = array() ){
		
		if( !is_array( $profiles ) )
		$profiles = array( $profiles );
		
		foreach( $profiles as $path ){
			if( file_exists( $path ) ){
				
				$path_info = pathinfo( $path );
				$path = str_replace( untrailingslashit( ABSPATH ), '', $path );
				
				if( !in_array( $path, $this->profile_section_paths ) && $path_info['extension'] == 'mpl' ){
					array_push( $this->profile_section_paths, $path );
				}
				
			}
		}
		
	}

	public function get_profile_sections(){
		
		$list = array();
		$from_db = $this->get_profiles_db();
		$slug = '';
		
		if( !is_array( $this->profile_section_paths ) )
		return $list;
		
		foreach( $this->profile_section_paths as $path ){
			
			$slug = sanitize_title( basename( $path, '.mpl' ) );
			
			if( !isset( $from_db[ $slug ] ) )
			$list[ $slug ] = $path;
		}
		
		return $list;
		
	}

	public function get_data_profile ($name = ''){
		
		$profile_section_paths = $this->get_profile_sections();
		
		if( isset( $profile_section_paths[ $name ] ) && is_file( untrailingslashit( ABSPATH ).$profile_section_paths[ $name ] ) ){
			
			$file = untrailingslashit( ABSPATH ).$profile_section_paths[ $name ];
			
			$path_info = pathinfo( $file );
			
			if( $path_info['extension'] != 'mpl' )
			return false;
			
			$fp = @fopen( $file, 'r' );
			$data = '';
			
			if( !empty( $fp ) ){
				
				$data = @fread( $fp, filesize( $file ) );
				$data = base64_encode( $data );
				$name = str_replace( array( '-', '_' ), array( ' ', ' ' ), basename( $name, '.mpl' ) );
				$slug = sanitize_title( basename( $name, '.mpl' ) );
				
				@fclose( $fp );
				
				return array( $name, $slug, $data );
				
			} return false;
			
			
		}else return false;
		
	}

	public function get_template_path_extend( $base = '' ){
		
		$path = '';
		
		foreach( $this->template_path_extend as $tmpl )
		{
			if( file_exists( $tmpl.$base ) )
			$path = $tmpl.$base;
		}
		
		return $path;
		
	}

	public function get_templates_library_path( $base = '' ){
		
		$path = '';
		
		foreach( $this->templates_library_path as $tmpl )
		{
			if( file_exists( $tmpl.$base ) )
			$path = $tmpl.$base;
		}
		
		return $path;
		
	}
	
	public function get_templates_library_path_dir(){
				
		return $this->templates_library_path ;
		
	}

	public function get_templates_library_default_path ($base = ''){
		
		return $this->templates_path.$base;
		
	}

	public function get_shortcodes_function_path( $base = '' ){
		
		$path = '';
		
		foreach( $this->shortcodes_function_path_extend as $tmpl )
		{
			if( file_exists( $tmpl.$base ) )
			$path = $tmpl.$base;
		}
		
		return $path;
		
	}

	public function get_shortcodes_function_default_path ($base = ''){
		
		return $this->shortcodes_function_path.$base;
		
	}

	public function get_template_path ($base = ''){
		
		return $this->template_path.$base;
		
	}
	/**
	* Get the plugin path.
	* @return string
	*/
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

	/**
	* Get the template path.
	* @return string
	*/
	public function template_path(){
		
		return apply_filters( 'mageewp_page_layout_template_path', 'mageewp-page-layout/' );
		
	}

	public function prebuilt_template ($name = '', $pack = '') {
		
		$atx = explode('.', $pack);
		$type = array_pop($atx);
		
		if (empty($name) || empty($pack) || $type != 'xml' || !file_exists($pack))
			return false;
		
		$this->prebuilt_templates[$name] = $pack;
		
	}

	public function get_prebuilt_templates ($st = 'registered', $data = array()) {
		if ($st == 'registered')
			return $this->prebuilt_templates;
		else if ($st == 'load_sections') {
			return mpl_prerebuilt_templates($data, $this->prebuilt_templates);
		}
		return null;
	}

	private function register_shortcodes(){
		
		global $shortcode_tags;
		
		$shortcode = new mpl_load_shortcodes();
		
		$this->maps = apply_filters( 'mpl_maps', $this->maps );
		
		foreach( $this->maps as $name => $atts ){
			
			if( isset( $shortcode_tags[$name] ) )
			$this->shortcode_tags[$name] = $shortcode_tags[$name];
			
			add_shortcode( $name, array( &$shortcode, 'mpl_'.$name ) );
			
		}
		
	}

	public function do_shortcode( $content = '', $echo = false ){
		
		if( isset( $_POST['content'] ) )
			$content = $_POST['content'];
			
		if( isset( $_POST['echo'] ) )
			$echo = $_POST['echo'];
		
		if( empty( $content ) )
			return '';
		
		global $mpl_front;
		
		if( !isset( $mpl_front ) )
			$return = do_shortcode( $content );
		else 
			$return =  $mpl_front->do_shortcode( $content );
		
		if ( $echo == false ){
			return $return;
		}else{
			echo stripslashes($return);
			exit(0);
		}
		
	
			
	}

	public function get_default_atts( $params ){
		
		$sc = $params[2];
		
		if( isset( $this->maps[$sc] ) ){
			
			$pairs = $params[0];
			$reparams = $params[0];
			
			foreach( $this->params_merge( $sc ) as $param ){
				
				$name = $param['name'];
				
				if( isset( $reparams[ $name ] ) && $reparams[ $name ] === '__empty__' ){
					$param['value'] = '';
					$reparams[ $name ] = '';
				}
				
				$pairs[ $name ] = isset( $param['value'] ) ? $param['value'] : '';
				
				if( in_array( $param['type'], array( 'editor', 'textarea', 'group','tabs' ) ) ){
					
					if( !empty( $pairs[ $name ] ) ){
						
						$pairs[ $name ] = mpl_images_filter(base64_decode($pairs[$name]));
						
						if( $param['type'] == 'group' || $param['type'] == 'tabs' )
						$pairs[ $name ] = $this->get_default_group_atts( $pairs[ $name ], $param['params'] );
						
					}
					if( isset( $reparams[ $name ]) && !empty( $reparams[ $name ] ) ){
						$reparams[ $name ] = mpl_images_filter(base64_decode(str_replace( "\n", '', $reparams[$name])));
						if( $param['type'] == 'group' || $param['type'] == 'tabs' )
						$reparams[ $name ] = $this->get_default_group_atts($reparams[ $name ], $param['params']);
						
					}
				}
			}
			
			/*test*/
			
			$atts = shortcode_atts( $pairs, $reparams, $sc );
			
			return $atts;
			
		}else return array();
		
	}

	public function get_default_group_atts( $atts, $params ) 
	{
		$atts = json_decode( $atts, true );
		
		if (count($atts) > 0) {
			foreach ($atts as $key => $obj) {
				$atts[$key] = (array)$atts[$key];
			
				foreach ((array)$params as $i => $std) {
					
					if (!isset($atts[$key][$std['name']]) && isset($sid['value'])) {
						$atts[$key][$std['name']] = $sid['value'];
					}
					
					if (isset( $atts[ $key ][ $std['name'] ] ) && in_array( $std['type'], array( 'editor', 'textarea' ) ) )
					
					if (base64_encode(base64_decode($atts[$key][$std['name']])) == $atts[$key][$std['name']]){
						$atts[ $key ][ $std['name'] ] = mpl_images_filter( base64_decode($atts[$key][$std['name']]));
					} else {
						$atts[ $key ][ $std['name'] ] = mpl_images_filter( $atts[$key][$std['name']]);
					}
					
					if( $std['type'] == 'group' )
						$atts[ $key ][ $std['name'] ] = __( 'Do not support field type GROUP in its self', 'mageewp-page-layout' );
				}
				
				$atts[$key] = (object)$atts[$key];
				
			}
		}
		
		return $atts;
	}

	public function get_profiles_db( $_return = true ){
		
		global $wpdb;
		
		$list = array();
		$query = "SELECT * FROM `".$wpdb->prefix."options` WHERE `".$wpdb->prefix."options`.`option_name` LIKE 'mpl-profile%'";
		$item = '';
		$name = '';
		
		$fromDB = $wpdb->get_results( $query );
		
		if( isset( $fromDB ) ){
			foreach( $fromDB as $profile ){
				
				$name = substr( $profile->option_name, 11 );
				
				if( !in_array( $name, $list ) ){
					$item = @unserialize( $profile->option_value );
					$list[ $name ] = isset( $item[0] ) ? $item[0] : str_replace( array( '-', '_' ), array( ' ', ' ' ), $name );
				}
			}
		}
		
		if( $_return === false ){
			
			return json_encode( (object)$list );
			
		}
		
		return $list;
		
	}

	public function get_post_meta(){
		
		global $post;
		
		$data = array( "mode" => "", "classes" => "", "css" => "" );
		
		if( isset( $post ) && isset( $post->ID ) && !empty( $post->ID ) ){
			$meta = get_post_meta( $post->ID , 'mpl_data', true );
			if (!empty( $meta ) ){
				$data = $meta;
			}
		}
		
		return $data;
		
	}

	public function settings(){
		
		return array_merge( array(
		
		'content_types' => array(),
		'load_icon' => '',
		'css_code' => '',
		'max_width' => '',
		'animate' => '',
		'envato_username' => '',
		'api_key' => '',
		'license_key' => '',
		'theme_key' => ''
		
		), (array)$this->settings );
	}

	public function get_content_types(){
		
		$default = $this->required_content_types;
		$settings = $this->settings();
		$types = $settings['content_types'];
		
		if( empty( $types ) ){
			return $default;
		}else if( !is_array( $types ) ){
			$types = explode( ',', $types );
		}
		
		return array_merge( $default, $types );
		
	}

	public function add_content_type( $type, $section = true ){
		
		if( is_string( $type ) )
		{
			
			if( !in_array( $type, $this->required_content_types ) )
			array_push( $this->required_content_types, $type );
			
			if( $section === false && !in_array( $type, $this->ignored_section_content_types ) )
			array_push( $this->ignored_section_content_types, $type );
			
		}else if( is_array( $type ) ){
			
			foreach( $type as $item ){
				
				if( !in_array( $item, $this->required_content_types ) )
				array_push( $this->required_content_types, $item );
				
				if( $section === false && !in_array( $item, $this->ignored_section_content_types ) )
				array_push( $this->ignored_section_content_types, $item );
				
			}
			
		}
		
	}

	public function get_required_content_types(){
		
		return $this->required_content_types;
		
	}

	public function get_ignored_section_content_types(){
		
		return $this->ignored_section_content_types;
		
	}

	public function add_filter( $name, $callback ){
		
		if( is_callable( $callback ) ){
			
			if( !isset( $this->add_filters[$name] ) || !is_array( $this->add_filters[$name] ) )
			$this->add_filters[$name] = array();
			
			$this->add_filters[$name][] = $callback;
			
		}
	}

	public function params_merge( $name ){
		
		if( !isset( $name ) || empty( $name ) || !isset( $this->maps[ $name ] ) )
		return array();
		
		$params = $this->maps[ $name ]['params'];
		$merge = array();
		
		if( isset( $params[0] ) ){
			
			return $params;
			
		}else{
			
			foreach( $params as $k => $v ){
				if( isset( $v[0] ) ){
					
					foreach( $v as $prm )
					array_push( $merge, $prm );
				}
			}
			
		}
		
		return $merge;
		
	}

	public function params_obj( $name ){
		
		if( !isset( $name ) || empty( $name ) || !isset( $this->maps[ $name ] ) )
		return array();
		
		$params = $this->maps[ $name ]['params'];
		$merge = array();
		
		if( isset( $params[0] ) ){
			
			foreach( $params as $k => $v ){
				$merge[$v['name']] = $v;
			}
			
		}else{
			
			foreach( $params as $k => $v ){
				if( isset( $v[0] ) ){
					
					foreach( $v as $p => $t )
					$merge[$t['name']] = $t;
				}
			}
			
		}
		
		return $merge;
		
	}

	public function js_callback( $func ){
		
		array_push( $this->live_js_callback,  array( 'callback' => $func ) );
		
	}

	public function esc( $str ) {
		
		if( empty( $str ) )
		return '';
		
		return str_replace( array('<','>','[',']','"','\''), array( ':lt:', ':gt:', ':lsqb:', ':rsqb:', ':quot:', ':apos:' ) );
	}

	public function unesc( $str ){
		
		if( empty( $str ) )
		return '';
		
		return str_replace( array( ':lt:', ':gt:', ':lsqb:', ':rsqb:', ':quot:', ':apos:' ), array('<','>','[',']','"','\''), $str );
		
	}

	public function user_can_edit( $post = null ){
		
		global $wp_the_query, $current_user;
		
		if( !isset( $post ) || empty( $post ) || $post === null )
		global $post;
		
		if (!is_admin() && (!isset($_GET['mpl_action']) || $_GET['mpl_action'] != 'live-editor')){
			$post = $wp_the_query->get_queried_object();
		}
		
		wp_get_current_user();
		
		if( isset($post) && is_object($post) && isset($post->ID) && isset($post->post_author) &&
		isset($current_user) && is_object($current_user) && isset($current_user->ID) &&
		(current_user_can('edit_others_posts', $post->ID) || ($post->post_author == $current_user->ID))
		){
			return true;
		}
		return false;
		
	}

	public static function is_live(){
		
		if( isset( $_GET['mpl_action'] ) && $_GET['mpl_action'] == 'live-editor' )
		return true;
		else return false;
			
	}

	public function secrect_storage( $key = '', $mode = '' ){
		
		if( empty( $key ) )
		return '';
		
		$mpl_secrect_storage = get_option('mpl_secrect_storage');
		
		if( $mpl_secrect_storage === false ){
			add_option( 'mpl_secrect_storage', array(), null, 'no' );
		}
		
		if( !is_array( $mpl_secrect_storage ) )
		$mpl_secrect_storage = array();
		
		if( $mode != 'hidden' ){
			
			foreach( $mpl_secrect_storage as $secrect => $relate ){
				if( $relate == $key )
				return $secrect;
			}
			
			/*
			*	If the key has not been hidden yet
			*/
			
			$mode = 'encrypt';
			
		}
		
		if( $mode == 'encrypt' ){
			
			if( !isset( $mpl_secrect_storage[$key] ) ){
				
				$relate_key = 'mpl-secrect-'.rand(4564585,234523453456);
				$mpl_secrect_storage[$key] = $relate_key;
				
				update_option( 'mpl_secrect_storage', $mpl_secrect_storage );
				
				return $relate_key;
				
			}else return $mpl_secrect_storage[$key];
		}
		
	}

	public function enqueue_fonts(){
		
		$fonts = get_option('mpl-fonts');
		$uri = '//fonts.googleapis.com/css?family=';
		
		if( !is_array( $fonts ) || count( $fonts ) === 0 )
		return;
		
		foreach( $fonts as $family => $cfg ){
			
			$params = urldecode( $family );
			$params = str_replace( ' ', '+', $params );
			
			if( isset( $cfg[3] ) ){
				$params .= ':'.$cfg[3];
			}else $params .= ':'.$cfg[1];
			
			if( isset( $cfg[2] ) )
			$params .= '&subset='.$cfg[2];
			else $params .= '&subset='.$cfg[0];
				
			$unique = strtolower( str_replace( ' ', '-', urldecode( $family ) ) );
			
			wp_enqueue_style( $unique, $uri.$params, false, MPL_VERSION );
			
		}
		
		
	}

	public function verify( $code = '' ){
		
		if(!defined('MPL_LICENSE') && strlen($code) == 41)
		define('MPL_LICENSE', esc_attr($code));
		
	}

	public function kcp_remote( $code = '', $act = 'kcp_access' ){
		
		/*
		*	check valid code
		*/
		
		if (empty ($code) || strlen ($code) != 41)
			return false;
		/*
		*	prepare info
		*/
		
		$theme = sanitize_title( basename( get_template_directory() ) );
		$domain = str_replace( '=', '-d', base64_encode( site_url() ) );
		$url = $this->kcp_uri.$act.'&domain='.$domain.'&theme='.$theme.'&license='.$code;
		$date = time()+604800;
		
		/*
		*	create a request to kcp
		*/
		
		$request = @wp_remote_get($url);
		$response = @wp_remote_retrieve_body( $request );
		if (is_wp_error($request) || empty($response)) {
			$response = @file_get_contents($url);
		}
		
		$response = json_decode( $response, true );
		
		$data = array('pack'=>'trial', 'key'=>'', 'theme'=>$theme, 'domain'=>$domain, 'date'=>$date, 'key'=>$code, 'stt'=>0);
		
		/*
		*	merge with default
		*/
		foreach ($data as $i => $v)
		{
			if (isset ($response[$i]))
				$data[$i] = $response[$i];
		}
		/*
		*	storage
		*/
		if ($data['stt'] == 1)
		{
			if ($act == 'kcp_access')
			{
				if (get_option ('mpl_tkl_pdk' ) === false)
					add_option ('mpl_tkl_pdk', $data , null, 'no');
				else update_option ('mpl_tkl_pdk', $data);
				}
			else if ($act == 'revoke_domain')
			{
				delete_option ('mpl_tkl_pdk');
			}
		}
		
		return $data;
		
	}

	private function auto_verify() {
		
		if (defined('MPL_LICENSE') && ( $this->pdk['pack'] == 'trial' || $this->check_pdk() != 1))
		{
			
			$key = MPL_LICENSE;
			$time = time();
			
			/*
			*	if nonactivate + defined license key
			*/
			
			if (get_option('mpl_license_log') === false)
			{
				/*
				*	storage log
				*/
				
				$mplp_log = array();
				add_option('mpl_license_log', $mplp_log, null, 'no' );
				
			}else $mplp_log = get_option('mpl_license_log');
			
			/*
			*	Make sure that do not sent too much request
			*/
			
			if (!isset( $mplp_log[$key] ) || ( $mplp_log[$key]['timer'] < $time && $mplp_log[$key]['counter'] < 10))
			{
				
				$data = $this->kcp_remote($key);
				
				if(!isset($mplp_log[$key]) || !is_array($mplp_log[$key])){
					
					$mplp_log[$key] = array( 'timer' => $time+180, 'counter' => 0 );
					
				}else{
					
					$mplp_log[$key]['timer'] = $time+180;
					$mplp_log[$key]['counter']++;
					
				}
				
				update_option('mpl_license_log', $mplp_log);
				
			}
			else if( $mplp_log[$key]['timer'] < $time-(60*60*24*7) )
			{
				$mplp_log[$key]['timer'] = $time+300;
				$mplp_log[$key]['counter'] = 0;
			}
			
		}
		
	}

	public function check_pdk(){
		
		if( !isset( $this->pdk['pack'] ) || !isset( $this->pdk['date'] ) )
		return 0;
		else if( $this->pdk['date'] < time() ){
			if( $this->pdk['pack'] == 'trial' )
			return 3;
			else return 2;
			}else if( $this->pdk['date'] - time() > 604800 && $this->pdk['pack'] == 'trial' )
		return 3;
		
		return 1;
		
	}

	public function get_pdk(){
		
		return $this->pdk;
		
	}

	public function get_support_content_types(){
		
		$settings = $this->settings();
		
		if( !isset( $settings['content_types'] ) )
		$settings['content_types'] = array();
		
		$allows_types = array_merge( (array)$settings['content_types'], (array)$this->get_required_content_types() );
		
		if (count($this->prebuilt_templates) > 0) {
			$allows_types[] = 'prebuilt-templates-('.count($this->prebuilt_templates).')';
		}
		
		return $allows_types;
		
	}

	public function get_sidebars(){
		
		global $wp_registered_sidebars;
		$sidebars = array();
		
		if (isset($wp_registered_sidebars))
		{
			foreach ($wp_registered_sidebars as $name => $args)
			{
				$sidebars[$name] = $args['name'];
			}
		}
		
		return $sidebars;
		
	}

	public function plugin_active ($plugin = '') {
		return in_array( $plugin, (array) get_option( 'active_plugins', array() ) );
	}

	/*
	* Check value of an object
	*/

	public function is ( $obj, $var, $val ) {
		
		if (count((array)$obj) === 0)
			return false;
		
		$check = '';
		foreach ($var as $i) {
			if (isset($obj[$i]))
				$check = $obj[$i];
			else return false;
			}
		
		if ($check == $val)
			return true;
		else return false;
			
	}

	public function register_map_styles( $styles ) {
		return $styles+$this->map_styles;
	}

	public function register_map_scripts( $scripts ) {
		return $scripts+$this->map_scripts;
	}


	// contact form

	public function contact_form() {
		
		if ( trim( $_POST['message'] ) === '' ) {
			$Error =  __( 'Please enter a message.', 'mageewp-page-layout' );
			$hasError = true;
		} else {
			if ( function_exists('stripslashes') ) {
				$message = stripslashes( trim( $_POST['message'] ) );
			} else {
				$message = trim( $_POST['message'] );
			}
		}
		
		if ( trim( $_POST['subject'] ) === '' ) {
			$Error = __( 'Please enter your subject.', 'mageewp-page-layout' );
			$hasError = true;
		} else {
			$subject = trim( $_POST['subject'] );
		}
		
		if ( trim( $_POST['email'] ) === '')  {
			$Error = __( 'Please enter your email address.', 'mageewp-page-layout' );
			$hasError = true;
		} elseif ( ! preg_match( "/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim( $_POST['email'] ) ) ) {
			$Error = __( 'You entered an invalid email address.', 'mageewp-page-layout' );
			$hasError = true;
		} else {
			$email = trim( $_POST['email'] );
		}
		
		if ( trim( $_POST['name'] ) === '' ) {
			$Error = __( 'Please enter your name.', 'mageewp-page-layout' );
			$hasError = true;
		} else {
			$name = trim( $_POST['name'] );
		}
		
		if( ! isset( $hasError ) ) {
			
			if ( isset( $_POST['receiver'] ) && preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim( $_POST['receiver'] ) ) ) {
				$emailTo = $_POST['receiver'];
			} else {
				$emailTo = get_option('admin_email');
			}
			
			if ( $emailTo != "" ) {
				if ( trim( $_POST['subject'] ) === '' )
					$subject = 'From ' . $name;
				else
					$subject = trim( $_POST['subject'] );
				
				$body  = __( 'Name', 'mageewp-page-layout' ) . ': ';
				$body .= $name;
				$body .= "\n\n";
				$body .= __( 'Email', 'mageewp-page-layout' ) . ': ';
				$body .= $email;
				$body .= "\n\n";
				$body .= __( 'Message', 'mageewp-page-layout' ) . ': ';
				$body .= $message;
				$body .= "\n\n";
				
				$headers  = sprintf(__( 'From: %s <%s>', 'mageewp-page-layout' ), $name, $emailTo );
				$headers .= "\r\n" ;
				$headers .=  sprintf(__( 'Reply-To: %s', 'mageewp-page-layout' ), $email );
				
				wp_mail( $emailTo, $subject, $body, $headers );
				$emailSent = true;
				
			}
			
			echo json_encode( array( "msg" => __( "Your message has been successfully sent!", 'mageewp-page-layout' ), "error" => 0 ) );
			
		}
		else
		{
			echo json_encode( array( "msg" => $Error, "error" => 1 ) );
		}
		die();
	}

	// get template
	public function get_template() {
		global $mpl;

		if ( isset( $_POST['template'] ) && !empty( $_POST['template'] ) ) {
			$template = $_POST['template'];
			$base = $template . '.php';
			$path = $mpl->get_templates_library_path( $base );
			if ( empty( $path ) )
				$path = $mpl->get_templates_library_default_path( $base );
			
			$template = '';
			if ( file_exists( $path ) ) {
				require_once $path;
				if ( isset( $template['fonts'] ) && !empty( $template['fonts'] ) ) {
					$fonts = array_merge( get_option('mpl-fonts'), unserialize( $template['fonts'] ) );
					update_option('mpl-fonts', $fonts);
					$template['fonts'] = json_encode( $fonts );
				}

				if ( isset( $template['content'] ) && !empty( $template['content'] ) ) {
					$mpl_front = apply_filters('mpl_front',  MPL_PATH.'/includes/mpl.front.php' );
        			require_once $mpl_front;
					global $mpl_front;
					$template['html'] = $mpl_front->do_shortcode( $template['content'] );
				}
				wp_send_json( $template );
			}
			
		}
		exit;
	}
	
	// add content wrapper

	function mpl_filter_content($content){
		$new_content  = '<div class="mpl-content-wrap">';
		$new_content .= $content ;
		$new_content .=  '</div>' ;
		return $new_content;
	}
	
	// get file config
	
	public function get_file_config($configfilename){
		$debug=0;
		
		$configs = array();    
		$rows = @file($configfilename); 
		foreach($rows as $row)
		{
		   
			$config = trim($row);
			if ($config)
			{
				if(substr($config,0,1)<>"#" && substr($config,0,2)<>"//" )
				{
					$configs[]=$config;                        
				}
			}
		}    
		$ini = array();
		$section = 'templates';
		$section_config=array();
	
		foreach($configs as $value)
		{
			if (substr($value,0,1)=='[')
			{
				if ($debug) print "$value\n";
				$ini[$section]=$section_config;
				$section=strtolower(trim($value,"[]"));
				$section_config=array();
			}
			else
			{
				if ($pos=strpos($value,":",0))
				{
	
					$key=strtolower(trim(substr($value,0,$pos)));
					$value=trim(substr($value,$pos+1));
					if ($debug) print "$key=$value\n";          
					$section_config[$key]=$value;            
				}    
			}
			
		}
		$ini[$section]=$section_config;
		print "\n";
		if ($debug) print_r ($ini);
	
		return $ini;
        
	}
	
	// resort array
	
	public function array_sort_by($array, $field, $sortby = 'asc'){
		if (is_array($array))
		{
		  $refer = $resultSet = array();
		  foreach ($array as $i => $data)
		  {
			$refer[$i] = &$data[$field];
		  }
		  switch ($sortby)
		  {
			case 'asc': 
			  asort($refer);
			  break;
			case 'desc': 
			  arsort($refer);
			  break;
			case 'nat': 
			  natcasesort($refer);
			  break;
		  }
		  foreach ($refer as $key => $val)
		  {
			$resultSet[] = &$array[$key];
		  }
		  return $resultSet;
		}
		return false;
	  }
	
	
	
}

/*
*
*	Use magic method to autoload shortcode templates
*
*/

class mpl_load_shortcodes{
    
    public function __call( $func, $params ){
        
        global $mpl;
        
        $shortcode = $params[2];
        $content = str_replace( array('&#8221;', '&#8243;' ), array( '"', '"' ), $params[1] );
        $base = $shortcode.'.php';
        $atts = $mpl->get_default_atts( $params );
        $path = $mpl->get_template_path_extend( $base );
        $content = apply_filters( 'mpl_shortcode_content', $content, $shortcode );

        if ( isset( $atts['content'] ) && isset( $content ) && !empty( $content ) )
            $atts['content'] = $content;
    
        $atts = apply_filters( 'mpl_shortcode_attributes', $atts, $shortcode );
        
        if ( isset( $mpl->shortcode_tags[$shortcode] ) && is_callable( $mpl->shortcode_tags[$shortcode] ) ){
            return call_user_func( $mpl->shortcode_tags[$shortcode], $atts, $content, $shortcode );
        }
        
        if ( empty( $path ) )
            $path = $mpl->get_template_path( $base );
        
        if ( ! file_exists( $path ) ) {
            return __('MPL Error: could not find shortcode template: ', 'mageewp-page-layout') . get_template_directory() . MDS . 'mageewp-page-layout' . MDS . $base;
        }
    
        ob_start();
        include $path;
        $content = ob_get_contents();
        ob_end_clean();
        
        return $content;
        
    }

	
	
    
}

/************************/
global $mpl;
$mpl = new MageewpPageLayout();
// Load  core
$mpl->load();
/************************/