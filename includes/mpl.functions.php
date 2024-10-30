<?php

if(!defined('MPL_FILE')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

if( !function_exists('wp_list_widgets') )
	require_once(ABSPATH . '/wp-admin/includes/widgets.php');

//@if NODE_ENV == 'free'
function mpl_admin_enable( $force = false ){

	if( $force === true )
		return true;

	global $post, $mpl;

	$type = !empty( $post->post_type ) ? $post->post_type:'';
	$page = !empty( $_GET['page'] ) ? $_GET['page'] : '';

	$allows_types = $mpl->get_support_content_types();

	if( is_admin() && ( in_array( $type, $allows_types ) || $page == 'mpl-mapper' || $mpl->is_live() ) )
		return true;
	else return false;

}

function mpl_add_map( $map = array() ){

	global $mpl;

	if( !is_array( $map ) )
		return;

	$mpl->add_map( $map );

}
/*
*	Add maps from exported file
*/
function mpl_include_map($file) {

	if (!file_exists($file)) 
		return;
	
	ob_start();
	@include($file);
	$data = ob_get_contents();
	ob_end_clean();
	
	/*
	$handle = fopen($file, 'r' );
	$data = fread($handle, filesize($file));
	fclose($handle);
	*/
	
	$data = @json_decode($data, true);
	
	if (!empty($data) && is_array($data)) {
		global $mpl;
		$mpl->add_map($data);
	}
	
}

function mpl_remove_map( $name = '' ){

	global $mpl;

	if( empty( $name ) )
		return;

	$mpl->remove_map( $name );

}

function mpl_prebuilt_template ($name = '', $pack = '') {

	global $mpl;

	if (empty($name) || empty($pack))
		return false;

	$mpl->prebuilt_template ($name, $pack);

}

function mpl_hide_element( $name = '' ){

	global $mpl;

	if( empty( $name ) )
		return;

	$mpl->hide_element( $name );

}

function mpl_add_param_type( $name = '', $func = '' ){

	global $mpl;

	if( empty( $name ) || empty( $func ) )
		return;

	$mpl->add_param_type( $name, $func );
	
}

function mpl_add_icon( $source = '' ){
	
	if( !empty( $source ) ){
		MageewpPageLayout::globe()->add_icon_source( $source );	
	}
}

function mpl_remove_wpautop( $content, $autop = false ) {

	if ( $autop ) {
		$content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
	}

	return do_shortcode( shortcode_unautop( $content ) );
}

function mpl_validate_options( $plugin_options ){

	if( isset( $_POST['mpl_options'] ) && !empty( $_POST['mpl_options'] ) ){
		if( isset( $_POST['re-active-mpl-pro'] ) && $_POST['re-active-mpl-pro'] == '1' ){
			$result = activate_plugin( 'mpl_pro/mpl_pro.php' );
		}
		return $plugin_options;
	}

}

function mpl_youtube_id_from_url( $url = '' ) {

    parse_str( parse_url( $url, PHP_URL_QUERY ), $vars );
    
	return isset( $vars['v'] ) ? $vars['v'] : '';   

}

function mpl_loop_box( $items ){

	if( empty( $items ) )
		return '';

	$output = '';

	foreach( $items as $item ){
			
		if( is_object( $item ) && $item->tag != 'text' ){
			

			if( !isset( $item->attributes ) || !is_object( $item->attributes ) )
				$item->attributes = new stdClass();

			if( !isset( $item->attributes->class ) )
				$item->attributes->class = '';
			
			if( $item->tag == 'image' )
				$item->tag = 'img';
			if( $item->tag == 'icon' )
				$item->tag = 'i';
			if( $item->tag == 'column' ){
				$item->tag = 'div';
				$item->attributes->class .= ' '.$item->attributes->cols;
				unset( $item->attributes->cols );
			}
			
			$output .= '<'.$item->tag;
			
			if( $item->tag == 'img' ){
				if( empty( $item->attributes->src ) )
					$item->attributes->src = MPL_URL.'/assets/images/get_start.jpg';
				
				if( $item->tag == 'img' && !isset( $item->attributes->alt ) )
					$item->attributes->alt = '';
			}
			
			foreach( $item->attributes as $k => $v ){
				if( !empty($v) )$output .= ' '.$k.'="'.trim($v).'"';
			}

			if( $item->tag == 'img' )
				$output .= '/';

			$output .= '>';

			if( is_array( $item->children ) )
				$output .= mpl_loop_box( $item->children );

			if( $item->tag != 'img' )
				$output .= '</'.$item->tag.'>';

		}else $output .= $item->content;

	}

	return $output;

}

function mpl_get_terms( $tax = 'category', $key = 'id', $type = '', $default = '' ){

	$get_terms = (array) get_terms( $tax, array( 'hide_empty' => false ) );

	if( $type != '' ){
		$get_terms = mpl_get_terms_by_post_type( array($tax), array($type) );
	}

	$terms = array();

	if( $default != '' ){
		$terms[] = $default;
	}

	if ( $key == 'id' ){
		foreach ( $get_terms as $term ){
			if( isset( $term->term_id ) && isset( $term->name ) ){
				$terms[$term->term_id] = $term->name;
			}
		}
	}else if ( $key == 'slug' ){
		foreach ( $get_terms as $term ){
			if( !empty($term->name) ){
				if( isset( $term->slug ) && isset( $term->name ) ){
					$terms[$term->slug] = $term->name;
				}
			}
		}
	}

	return $terms;

}

function mpl_filter_search( $s, &$w ) {
	
	global $wpdb;
	
	if ( empty( $s ) )return '';
	
	$q = $w->query_vars;
	
	$n = ! empty( $q['exact'] ) ? '' : '%';
	$s = $sa = '';
	
	foreach ( (array) $q['search_terms'] as $t ) {
		$t = $wpdb->esc_like( $t );
		$l = $n . $t . $n;
		$s .= $wpdb->prepare( "{$sa}($wpdb->posts.post_title LIKE %s)", $l );
		$sa = ' AND ';
	}
	
	if ( ! empty( $s ) )
		$s = " AND ({$s}) ";

	return $s;
}

function mpl_get_submit_button( $text = '', $type = 'primary large', $name = 'submit', $wrap = true, $other_attributes = '' ) {
	
	if ( ! is_array( $type ) )
		$type = explode( ' ', $type );

	$button_shorthand = array( 'primary', 'small', 'large' );
	$classes = array( 'button' );
	foreach ( $type as $t ) {
		if ( 'secondary' === $t || 'button-secondary' === $t )
			continue;
		$classes[] = in_array( $t, $button_shorthand ) ? 'button-' . $t : $t;
	}
	$class = implode( ' ', array_unique( $classes ) );

	if ( 'delete' === $type )
		$class = 'button-secondary delete';

	$text = $text ? $text : __( 'Save Changes' );

	// Default the id attribute to $name unless an id was specifically provided in $other_attributes
	$id = $name;
	if ( is_array( $other_attributes ) && isset( $other_attributes['id'] ) ) {
		$id = $other_attributes['id'];
		unset( $other_attributes['id'] );
	}

	$attributes = '';
	if ( is_array( $other_attributes ) ) {
		foreach ( $other_attributes as $attribute => $value ) {
			$attributes .= $attribute . '="' . esc_attr( $value ) . '" '; // Trailing space is important
		}
	} elseif ( ! empty( $other_attributes ) ) { // Attributes provided as a string
		$attributes = $other_attributes;
	}

	// Don't output empty name and id attributes.
	$name_attr = $name ? ' name="' . esc_attr( $name ) . '"' : '';
	$id_attr = $id ? ' id="' . esc_attr( $id ) . '"' : '';

	$button = '<input type="submit"' . $name_attr . $id_attr . ' class="' . esc_attr( $class );
	$button	.= '" value="' . esc_attr( $text ) . '" ' . $attributes . ' />';

	if ( $wrap ) {
		$button = '<p class="submit">' . $button . '</p>';
	}

	return $button;
}

function mpl_process_tab_title( $matches ){

	if( !empty( $matches[0] ) ){

		$tab_atts = shortcode_parse_atts( $matches[0] );

		$title = ''; $adv_title = '';
		if ( isset( $tab_atts['title'] ) )
			$title = $tab_atts['title'];
		
		if( isset( $tab_atts['advanced'] ) && $tab_atts['advanced'] === 'yes' ){
			
			if( isset( $tab_atts['adv_title'] ) && !empty( $tab_atts['adv_title'] ) )
				$adv_title = base64_decode( $tab_atts['adv_title'] );
				
			$icon=$icon_class=$image=$image_id=$image_url=$image_thumbnail=$image_medium=$image_large=$image_full='';
			
			if( isset( $tab_atts['adv_icon'] ) && !empty( $tab_atts['adv_icon'] ) ){
				$icon_class = $tab_atts['adv_icon'];
				$icon = '<i class="'.$tab_atts['adv_icon'].'"></i>';
			}
			
			if( isset( $tab_atts['adv_image'] ) && !empty( $tab_atts['adv_image'] ) ){
				$image_id = $tab_atts['adv_image'];
				$image_url = wp_get_attachment_image_src( $image_id, 'full' );
				$image_medium = wp_get_attachment_image_src( $image_id, 'medium' );
				$image_large = wp_get_attachment_image_src( $image_id, 'large' );
				$image_thumbnail = wp_get_attachment_image_src( $image_id, 'thumbnail' );
				
				if( !empty( $image_url ) && isset( $image_url[0] ) ){
					$image_url = $image_url[0];
					$image_full = $image_url;
				}
				if( !empty( $image_medium ) && isset( $image_medium[0] ) )
					$image_medium = $image_medium[0];
				
				if( !empty( $image_large ) && isset( $image_large[0] ) )
					$image_large = $image_large[0];
					
				if( !empty( $image_thumbnail ) && isset( $image_thumbnail[0] ) )
					$image_thumbnail = $image_thumbnail[0];
				if( !empty( $image_url ) )
					$image = '<img src="'.$image_url.'" alt="" />';
			}
			
			$adv_title = str_replace( array( '{title}', '{icon}', '{icon_class}', '{image}', '{image_id}', '{image_url}', '{image_thumbnail}', '{image_medium}', '{image_large}', '{image_full}', '{tab_id}' ), array( $title, $icon, $icon_class, $image, $image_id, $image_url, $image_thumbnail, $image_medium, $image_large, $image_full, $tab_atts['tab_id'] ), $adv_title );
			
			echo '<li>'.$adv_title.'</li>';
				
		}else{
			if( isset( $tab_atts['icon_option'] ) && $tab_atts['icon_option']  == 'yes' ){
				if(empty($tab_atts['icon']))
					$tab_atts['icon'] = 'fa-leaf';
				$title = '<i class="'.$tab_atts['icon'].'"></i> '.$title;
			}
			echo '<li><a href="#'.$tab_atts['tab_id'].'" data-prevent="scroll">'.$title.'</a></li>';
		}

	}

	return $matches[0];

}

function mpl_is_using(){
	
	global $post;

	if( !isset( $post ) || !isset( $post->ID ) || empty( $post->ID ) || !get_post_meta( $post->ID , 'mpl_data', false ) )
		return false;
		
	$mpl_meta = get_post_meta( $post->ID , 'mpl_data', true );

	if( isset( $mpl_meta['mode'] ) && $mpl_meta['mode'] == 'mpl' )
		return true;
	else return false;
	
}

function mpl_js_callback( $callback ){
	
	global $mpl;
	$mpl->js_callback( $callback );
	
}

function mpl_add_content_type( $type = '', $setion = true  ){
	
	global $mpl;
	if( !empty( $type ) )
		$mpl->add_content_type( $type, $setion );
	
}

/*
 * Return the type of content
 */
function mpl_get_post_type(){
	
	global $post;
	
	$type = '';
	
	if( isset( $post ) && isset( $post->post_type ) )
		$type = $post->post_type;
	
	return $type;
	
}

/*
 * Get content as raw format
 */
function mpl_raw_content( $id = 0 ){
	
	$content = '';
	
	if ( FALSE !== get_post_status( $id ) ) {
	
		$content = get_post_field('post_content_filtered', $id );
		if( empty( $content ) )
			$content = get_post_field( 'post_content', $id );
		
	}
		
	return $content;
}

function mpl_do_shortcode( $content = '' ){
		
	if( empty( $content ) )
		return '';

	global $mpl_front;
	
	if( !isset( $mpl_front ) )
		return do_shortcode( $content );
	else return $mpl_front->do_shortcode( $content );

}

function mpl_remove_dir ($dirPath = '') {
		
	if (empty($dirPath))
		return false;
		
	$dirPath = untrailingslashit($dirPath).MDS;
	
	if ($dirPath == ABSPATH)
		return false;
	
    if (! is_dir($dirPath)) {
        return false;
    }
    
    $files = scandir($dirPath, 1);

    foreach ($files as $file) {
	    if ($file != '.' && $file != '..') {
	        if (is_dir($dirPath.$file)) {
	        	mpl_remove_dir($dirPath.$file);
	        } else {
	            unlink($dirPath.$file);
	        }
        }
    }
    
    if (is_file($dirPath.'.DS_Store'))
    	unlink($dirPath.'.DS_Store');
    	
    return rmdir($dirPath);

}
/*
* Read changelogs from readme.txt
*/
function mpl_changelogs(){
	
	$path = MPL_PATH.MDS.'readme.txt';
	if (file_exists($path)) {
		
		$content = @file_get_contents($path);
		$anchor = strpos($content, '== Changelog ==');

		if (!empty($content) && $anchor !== false) {
			
			$content = substr($content, $anchor + strlen('== Changelog =='));
			$content = explode("\n", $content);
			$group = array('newfeatures' => array(), 'improve' => array(), 'bugfixes' => array(), 'changes' => array(), 'remove' => array());
			
			foreach ($content as $n => $line) {
				
				$line = trim($line);
				
				if (substr ($line, 0, 1) == '*') {
					
					$line = trim(substr ($line, 1));
					if (strpos($line, '[New]') === 0)
						$group['newfeatures'][] = substr ($line, 5);
					else if (strpos($line, '[Improve]') === 0)
						$group['improve'][] = substr ($line, 9);
					else if (strpos($line, '[Fix]') === 0)
						$group['bugfixes'][] = substr ($line, 5);
					else if (strpos($line, '[Remove]') === 0)
						$group['remove'][] = substr ($line, 8);
					else $group['changes'][] = $line;
					
				}
				else {
					
					foreach ($group as $label => $items) {
						if (count($items) > 0) {
							echo '<div class="mpl-log-type '.esc_attr($label).'"><strong>'.esc_attr($label).'</strong></div>';
							echo '<ul>';
							foreach ($items as $i => $item) {
								if (!empty($item))
									echo '<li>'.esc_html($item).'</li>';
							}
							echo '</ul>';
						}
					}
					
					$group = array('newfeatures' => array(), 'improve' => array(), 'bugfixes' => array(), 'changes' => array(), 'remove' => array());
					
					if (substr ($line, strlen($line)-1) == '=' && substr ($line, 0, 1) == '=')
						echo '<h3 class="mpl-log-ver">Version '.substr ($line, 1, strlen($line)-2).'</h3>';
					
				}
			}
			
		} else {
			_e('Error: Could not read data', 'mageewp-page-layout');
		}
		
	} else {
		_e('Error: Could not find the file readme.txt', 'mageewp-page-layout');	
	}
	
}
/*
*	Build list template from prebuilt list
*/
function mpl_prerebuilt_templates ($data = array(), $registered = array()) {
	
	if (!isset($data['data']))
		return $data;
	
	$lz = array();
	
	foreach ($registered as $name => $path) {
		if (!isset($data['data']['term']) || empty($data['data']['term']) || !isset($registered[$data['data']['term']]))
			$data['data']['term'] = $name;
		$data['data']['terms'][] = array('name' => $name, 'id' => '', 'taxonomy' => $name);
	}
	
	$posts = mpl_get_template_xml($registered[$data['data']['term']], '', $data['data']['s']);
	
	if (count($posts) > 0) {
		
		$to = (int)$data['data']['paged']*(int)$data['data']['per_page'];
		$start = $to-(int)$data['data']['per_page'];
		
		$data['data']['items'] = array();
		
		for($i = $start; $i < $to; $i++){
			if (isset($posts[$i]))
				$data['data']['items'][] = $posts[$i];
		}
		
		$data['data']['total'] = ceil(count($posts)/(int)$data['data']['per_page']);
		$data['data']['count'] = count($posts);
		$data['stt'] = 1;
		$data['message'] = 'Success';
	}else{
		$data['message'] = '<span style="font-size: 50px;">\\(^Д^)/</span><br /><br /><span style="font-size: 16px">'.__('Oops, there are no template found in package', 'mageewp-page-layout').' <strong>'.$data['data']['term'].'</strong><br /><small><i>'.$registered[$data['data']['term']].'</i></small>';
	}
	
	return $data;
	
}
/*
*	Read templates from xml
*/	
function mpl_get_template_xml($file = '', $id = '', $s = '') {
	
	if (empty($file) || !file_exists($file))
		return null;
	
	$xml = simplexml_load_file($file);
	$posts = array();

	foreach ($xml->channel->item as $item) {

		$meta = $item->children('http://wordpress.org/export/1.2/');
		
		$mpl_meta = false;
		
		for ($i = 0; $i < count($meta->postmeta); $i++) {
			if ($meta->postmeta[$i]->meta_key == 'mpl_data') {
				$mpl_meta = unserialize($meta->postmeta[$i]->meta_value);
				break;
			}
		}
		
		if (!empty($id) && $id == (string)$meta->post_id) {
			if ($mpl_meta !== false && isset($mpl_meta['mode']) && $mpl_meta['mode'] == 'mpl') {
				$content = $item->children('http://purl.org/rss/1.0/modules/content/');
				return array((string)$content->encoded, $mpl_meta);
			}else{
				return array(null, null);
			}
		}
		
		if ($mpl_meta !== false && isset($mpl_meta['mode']) && $mpl_meta['mode'] == 'mpl') {
			if ($s === '' || strpos(strtolower(html_entity_decode($item->title)), strtolower($s)) !== false) {
				$posts[] = array(
					'title' => html_entity_decode($item->title),
					'preview' => isset($mpl_meta['thumbnail']) ? $mpl_meta['thumbnail'] : '',
					'date' => date('F d, Y', strtotime((string)$item->pubDate)),
					'categories' => array(),
					'id' => (string)$meta->post_id,
					'type' => 'xml'
				);
			}
		
		}
		
	}
	
	return $posts;
	
}
/*
*	Read templates from xml
*/	
function mpl_set_transient_xml_attachs() {
	
	global $mpl, $wpdb;
	
	$delete_transient = "delete from {$wpdb->options} where option_name like '_transient_mpl_attach_xml_%' or option_name like '_transient_timeout_mpl_attach_xml_%'";

	$xmls = $mpl->get_prebuilt_templates();
	
	if (is_array($xmls) && count($xmls) > 0) {
		
		$sizes = 0;
		$names = '';
		$unique_key = get_option('mpl_map_xml_attachments', true);
	
		foreach ($xmls as $file) {
			
			if (file_exists($file)) {
				
				$sizes += filesize($file);
				$names .= $file;
				
			}
		}
		
		$unique = md5($names).$sizes;
		
		if ($unique_key !== $unique) {

			update_option('mpl_map_xml_attachments', $unique);
			
			// DELETE transient	before adding new fresh bellow
			$wpdb->query($delete_transient);
			
			foreach ($xmls as $file) {
			
				if (file_exists($file)) {
					
					$xml = simplexml_load_file($file);
					foreach ($xml->channel->item as $item) {
	
						$meta = $item->children('http://wordpress.org/export/1.2/');
						if ((string)$meta->post_type == 'attachment') {
							
							$_wp_attached_file = '';
							$_wp_attachment_metadata = array();
							
							for ($i = 0; $i < count($meta->postmeta); $i++) {
								if ($meta->postmeta[$i]->meta_key == '_wp_attached_file') {
									$_wp_attached_file = (string)$meta->postmeta[$i]->meta_value;
								}
								if ($meta->postmeta[$i]->meta_key == '_wp_attachment_metadata') {
									$_wp_attachment_metadata = unserialize($meta->postmeta[$i]->meta_value);
								}
							}
							
							$serialized_value = maybe_serialize(array(
								'url' => (string)$meta->attachment_url,
								'metadata' => $_wp_attachment_metadata,
								'expiration' => (defined('MPL_ATTACHS_XML_EXPIRATION') ? (time()+(int)MPL_ATTACHS_XML_EXPIRATION) : 0)
							));
							
							$wpdb->query( $wpdb->prepare( "INSERT INTO `$wpdb->options` (`option_name`, `option_value`, `autoload`) VALUES (%s, %s, %s) ON DUPLICATE KEY UPDATE `option_name` = VALUES(`option_name`), `option_value` = VALUES(`option_value`), `autoload` = VALUES(`autoload`)", '_transient_mpl_attach_xml_'.(string)$meta->post_id, $serialized_value, 'no' ) );
							
						}
						
					}
					
				}
			}
			
		}
		
	} else if (get_option('mpl_map_xml_attachments')) {
		$wpdb->query($delete_transient);
		delete_option('mpl_map_xml_attachments');
	}
	
}

/*
*	preg replace attach url
*/
function mpl_images_filter($url = '') {

	//$regx = '/\%SITE\_URL\%(.+?)\.(jpg|gif|png|jpeg|JPG|GIF|PNG|JPEG|http)/';
	//$regx = '/\%SITE\_URL\%(.+?)\.([A-Za-z0-9\s]+)/i';
	$regx = '/\%SITE\_URL\%(.+?)(\'|\"|\)|\ )/i';
	
	return preg_replace_callback($regx, 'mpl_images_filter_callback', $url);
	
}
function mpl_images_filter_callback($m) {

	return mpl_attach_url(MPL_SITE.$m[1]).$m[2];
	
}
/*
*	Fix attach urls
*/
function mpl_attach_url($url = '') {
		
	if (strpos($url, MPL_SITE.'/wp-content') === false)
		return $url;

	global $mpl;
	$xmls = $mpl->get_prebuilt_templates();

	$test_exist = str_replace( 
		array(MPL_SITE, '/', '\\'), 
		array(untrailingslashit(ABSPATH), MDS, MDS), 
		$url
	);

	if (count($xmls) === 0) {

		if (strpos($url, MPL_SITE) === 0 && !file_exists($test_exist) ) {
			if (preg_match('/(jpg|gif|png|jpeg|JPG|GIF|PNG|JPEG)$/',$test_exist)){
			   return MPL_URL.'/assets/images/get_start.jpg';
			}
		}
		
		return $url;
		
	}
	
	if (strpos($url, MPL_SITE) === 0 && file_exists($test_exist)) {
		return $url;
	}else{
		
		global $wpdb;
		
		mpl_set_transient_xml_attachs();
		
		$xurl = str_replace(MPL_SITE, '', esc_url($url));
		$posts = $wpdb->get_results("select * from {$wpdb->options} where (option_name like '_transient_mpl_attach_xml_%' or option_name like '_transient_timeout_mpl_attach_xml_%') and option_value like '%".$xurl."%'");
		
		if (count($posts) > 0) {
			
			$attach = unserialize($posts[0]->option_value);
			
			if (isset($attach['expiration']) && ($attach['expiration'] === 0 || $attach['expiration'] > time())) {
				if (isset($attach['url']) && 
					strpos($attach['url'], $xurl) !== false && 
					strpos($attach['url'], "/wp-content/uploads") !== false
				){
					$attach['url'] = explode("/wp-content/uploads", $attach['url']);
					return $attach['url'][0].$xurl;
				}
			}else{
				delete_transient(str_replace('_transient_', '', $posts[0]->option_name));
			}
		}
	}
	
	return $url;
	
}
/*
 * Return a random string with length
 */
function mpl_random_string( $length = 10 ){
	$str = "";
	$allow_characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
	$_max_length = count($allow_characters) - 1;

	for ($i = 0; $i < $length; $i++) {
		$rand = mt_rand(0, $_max_length);
		$str .= $allow_characters[$rand];
	}

	return $str;
}
/*
 * Get first image in content of a post
 */
function mpl_first_image( $content ) {
	
	$first_img = '';
	
	ob_start();
	ob_end_clean();
	
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
	
	if( isset($matches[1][0]) )
		return $matches[1][0];
	
	return false;
}

// rgb color 
function mpl_color_rgb2hsl( $hex_color ) {

			$hex_color    = str_replace( '#', '', $hex_color );

			if( strlen( $hex_color ) < 3 ) {
				str_pad( $hex_color, 3 - strlen( $hex_color ), '0' );
			}

			$add         = strlen( $hex_color ) == 6 ? 2 : 1;
			$aa          = 0;
			$add_on      = $add == 1 ? ( $aa = 16 - 1 ) + 1 : 1;

			$red         = round( ( hexdec( substr( $hex_color, 0, $add ) ) * $add_on + $aa ) / 255, 6 );
			$green       = round( ( hexdec( substr( $hex_color, $add, $add ) ) * $add_on + $aa ) / 255, 6 );
			$blue        = round( ( hexdec( substr( $hex_color, ( $add + $add ) , $add ) ) * $add_on + $aa ) / 255, 6 );

			$hsl_color    = array( 'hue' => 0, 'sat' => 0, 'lum' => 0 );

			$minimum     = min( $red, $green, $blue );
			$maximum     = max( $red, $green, $blue );

			$chroma      = $maximum - $minimum;

			$hsl_color['lum'] = ( $minimum + $maximum ) / 2;

			if( $chroma == 0 ) {
				$hsl_color['lum'] = round( $hsl_color['lum'] * 100, 0 );

				return $hsl_color;
			}

			$range = $chroma * 6;

			$hsl_color['sat'] = $hsl_color['lum'] <= 0.5 ? $chroma / ( $hsl_color['lum'] * 2 ) : $chroma / ( 2 - ( $hsl_color['lum'] * 2 ) );

			if( $red <= 0.004 || 
				$green <= 0.004 || 
				$blue <= 0.004 
			) {
				$hsl_color['sat'] = 1;
			}

			if( $maximum == $red ) {
				$hsl_color['hue'] = round( ( $blue > $green ? 1 - ( abs( $green - $blue ) / $range ) : ( $green - $blue ) / $range ) * 255, 0 );
			} else if( $maximum == $green ) {
				$hsl_color['hue'] = round( ( $red > $blue ? abs( 1 - ( 4 / 3 ) + ( abs ( $blue - $red ) / $range ) ) : ( 1 / 3 ) + ( $blue - $red ) / $range ) * 255, 0 );
			} else {
				$hsl_color['hue'] = round( ( $green < $red ? 1 - 2 / 3 + abs( $red - $green ) / $range : 2 / 3 + ( $red - $green ) / $range ) * 255, 0 );
			}

			$hsl_color['sat'] = round( $hsl_color['sat'] * 100, 0 );
			$hsl_color['lum']  = round( $hsl_color['lum'] * 100, 0 );

			return $hsl_color;
		}		
		
/*
 * facebook shortcode function 
 */
function mpl_facebook_default_time($time) {
	$time = time() - $time;
    $time_units = array (
		31536000 => 'year',
		2592000 => 'month',
		604800 => 'week',
		86400 => 'day',
		3600 => 'hour',
		60 => 'minute',
		1 => 'second'
	);
	foreach ($time_units as $unit => $text) {
		if ($time < $unit) continue;
		$numberOfUnits = floor($time / $unit);
		return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
		}
	
	
} 

function mpl_mff_eventdate($original, $date_format){
	if($date_format == 'default'){
	$output = mpl_facebook_default_time($end_time);
	}else{	
	$output = date_i18n($date_format,$original);
	}	
	
	return $output;
	
}

function mpl_stripos_arr($haystack, $needle) {
    if(!is_array($needle)) $needle = array($needle);
    foreach($needle as $what) {
        if(($pos = stripos($haystack, ltrim($what) ))!==false) return $pos;
    }
    return false;
}

function mpl_mff_fetchUrl($url){
	
	if(is_callable('curl_init')){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 20);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$feedData = curl_exec($ch);
		curl_close($ch);
		//If not then use file_get_contents
		} elseif ( ini_get('allow_url_fopen') == 1 || ini_get('allow_url_fopen') === TRUE ) {
		$feedData = @file_get_contents($url);
		//Or else use the WP HTTP AP
		} else {
			if( !class_exists( 'WP_Http' ) ) include_once( ABSPATH . WPINC. '/class-http.php' );
			$request = new WP_Http;
			$result = $request->request($url);
			$feedData = $result['body'];
		}
	return $feedData;
	
}

function mpl_mff_substr_replace($string, $replacement, $start, $length=NULL) {
    if (is_array($string)) {
        $num = count($string);
        // $replacement
        $replacement = is_array($replacement) ? array_slice($replacement, 0, $num) : array_pad(array($replacement), $num, $replacement);
        // $start
        if (is_array($start)) {
            $start = array_slice($start, 0, $num);
            foreach ($start as $key => $value)
                $start[$key] = is_int($value) ? $value : 0;
        }
        else {
            $start = array_pad(array($start), $num, $start);
        }
        // $length
        if (!isset($length)) {
            $length = array_fill(0, $num, 0);
        }
        elseif (is_array($length)) {
            $length = array_slice($length, 0, $num);
            foreach ($length as $key => $value)
                $length[$key] = isset($value) ? (is_int($value) ? $value : $num) : 0;
        }
        else {
            $length = array_pad(array($length), $num, $length);
        }
        // Recursive call
        return array_map(__FUNCTION__, $string, $replacement, $start, $length);
    }
    preg_match_all('/./us', (string)$string, $smatches);
    preg_match_all('/./us', (string)$replacement, $rmatches);
    if ($length === NULL) $length = mb_strlen($string);
    array_splice($smatches[0], $start, $length, $rmatches[0]);
    return join($smatches[0]);
}		

/*
 * Post Category
 */
 function mpl_post_categories ( $taxonomy, $empty_choice = false ) {
	if( $empty_choice == true ) {
		$post_categories[''] = __('All','mageewp-page-layout');
	}
	$get_categories = get_categories('hide_empty=0&taxonomy=' . $taxonomy); 

	if( ! array_key_exists('errors', $get_categories) ) {
		if( $get_categories && is_array($get_categories) ) {
			foreach ( $get_categories as $cat ) {
				if(isset($cat->slug) && isset($cat->name))
				$post_categories[$cat->slug] = __($cat->name,'mageewp-page-layout');
			}
		}

		if( isset( $post_categories ) ) {
			return $post_categories;
		}
	}
}

/*
 * Display navigation to next/previous set of posts when applicable.
 */
 function mpl_get_pagination($wp_query = '') {
	$paging_nav = '';
    if (!$wp_query)	{
		global $wp_query;
	}
    global $wp_rewrite;
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

	$pagination = array(
		'base' => @add_query_arg('paged','%#%'),
		'format'             => '?page=%#%',
		'total'              => $wp_query->max_num_pages,
		'current'            => $current,
		'show_all'           => false,
		'end_size'           => 1,
		'mid_size'           => 2,
		'prev_next'          => true,
		'prev_text'          => __(' Prev', 'mageewp-page-layout'),
		'next_text'          => __('Next ', 'mageewp-page-layout'),
		'type'               => 'list',
		'add_args'           => false,
		'add_fragment'       => '',
		'before_page_number' => '',
		'after_page_number'  => ''
	);
 
    if( $wp_rewrite->using_permalinks() )
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg('s',get_pagenum_link(1) ) ) . 'page/%#%/', 'paged');
 
    if( !empty($wp_query->query_vars['s']) )
        $pagination['add_args'] = array('s'=>get_query_var('s'));
		
	if ($wp_query->max_num_pages > 1) {
		$paging_nav = '<nav class="mpl-post-pagination" role="navigation">' .paginate_links($pagination).'</nav>';
	}
	return $paging_nav;
}
	
 /*
  * get summary
  */
 function mpl_get_summary( $excerpt_length = false,$excerpt_or_content=false ){
	 
	if($excerpt_or_content == false)
	$excerpt_or_content = 'excerpt';
	if($excerpt_length == false)
	$excerpt_length     = 55;	
		
	 if( $excerpt_or_content == 'full_content' ){
	     $output = get_the_content();
	 }else{
	     $output = get_the_excerpt();
	 if( is_numeric($excerpt_length) && $excerpt_length !=0  ){
		 $excerpt = explode(' ', get_the_excerpt(), $excerpt_length);
		  if (count($excerpt)>=$excerpt_length) {
			array_pop($excerpt);
			$excerpt = implode(" ",$excerpt).'...';
		  } else {
			$excerpt = implode(" ",$excerpt);
		  } 
		 $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
		 $output = $excerpt;
	    }
	 }
	 return  $output;
}

/**
 * Get template part (for templates like the shop-loop).
 *
 */
function mpl_get_template_part( $slug, $name = '', $file = '') {
	global $mpl;
	$template = '';

	if ( $name ) {
		$template = locate_template( array( "{$slug}-{$name}.php", $mpl->template_path() . "{$slug}-{$name}.php" ) );
	}

	if ( ! $template && $name && file_exists( $mpl->plugin_path() . "/{$file}/{$slug}-{$name}.php" ) ) {
		$template = $mpl->plugin_path() . "/{$file}/{$slug}-{$name}.php";
	}

	if ( ! $template ) {
		$template = locate_template( array( "{$slug}.php", $mpl->template_path() . "{$slug}.php" ) );
	}

	$template = apply_filters( 'mpl_get_template_part', $template, $slug, $name );

	if ( $template ) {
		load_template( $template, false );
	}
}
/**
 * Query Post Data
 *
 */
function mpl_recent_posts_data($atts)
{
	$number_post = 0;
	$image_size = 'full';
	extract($atts);
	$data = array();
	$orderby = isset( $order_by ) ? $order_by : 'ID';
	$order = isset( $order_list ) ? $order_list : 'ASC';
	$post_type = isset($post_type)?$post_type:'post';
	
	$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
	$category = isset( $category ) ? $category : 'ID';
	
	$args = array(
		'paged' => $paged,
		'post_type' => $post_type,
		'posts_per_page' => $number_post,
		'orderby' => array( $order_by => $order),
		'ignore_sticky_posts' => true,
		'category_name' => $category
	);
	
	$the_query = new WP_Query($args);
	global $post;
	$i = 0;
	$categories = array();
	while ($the_query->have_posts() ) {
		$the_query->the_post();
		$post_data = array();
		$post_data['id'] = esc_attr($post->ID);
		
		$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), $image_size);
		$featured_image = $image[0];
		
		if ( !$featured_image):
		  
		 	 $portfolio_gallery  = get_post_meta( $post->ID, 'mpl_perm_metadata', true );
									   
			if( $portfolio_gallery ):
			   $attachment_id_arr = explode(",",$portfolio_gallery);
			   if($attachment_id_arr && is_array($attachment_id_arr)){
				$attachment_id = $attachment_id_arr[0];
	  
				   $image_attributes = wp_get_attachment_image_src( $attachment_id, $atts['image_size'] );
				   $featured_image   = $image_attributes[0];
			  
					} 

               endif;
		endif;
		
		if (has_post_thumbnail($post->ID) && 'yes' === strtolower($thumbnail))
			$post_data['thumbnail'] = get_the_post_thumbnail($post->ID, $image_size);
		elseif( $featured_image )
			$post_data['thumbnail'] = '<img src="'.$featured_image.'" alt=""/>';
		else
			$post_data['thumbnail'] = '';
				
		$post_data['link'] = esc_url(get_permalink($post->ID));
		$post_data['featured_image'] = esc_url($featured_image);
		
		if ( has_post_format( array( 'chat', 'status' ) ) )
			$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'mageewp-page-layout' );
		else
			$format_prefix = '%2$s';
			
		if (!empty($show_date) && strtolower($show_date) == 'yes') {
			$post_data['time'] = esc_attr(get_the_date('c'));
			$post_data['date'] = esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) );
		} else  {
			$post_data['time'] = '';
			$post_data['date'] = '';
		}
		$post_data['title_link'] = esc_url( get_permalink( $post->ID ) );
		$post_data['title'] = get_the_title();
		$post_data['excerpt'] = wp_trim_words(get_the_excerpt(), 25, ' [...]' );
		$post_data['author_link'] = get_the_author_link();
		$terms = get_the_terms($post->ID, $post_taxonomy );
		$terms_name_str = '';
		$terms_slug_str = '';
		if ($terms && ! is_wp_error($terms)) {
			$tnames_arr = array();
			$tslugs_arr = array();
			foreach ($terms as $term) {
				$tnames_arr[] = $term->name;
				$tslugs_arr[] = 'iso-filter-'.$term->slug;
				$categories[$term->name] = 'iso-filter-'.$term->slug;
			}
			$terms_name_str = join(" ", $tnames_arr);
			$terms_slug_str = join(" ", $tslugs_arr);
		}
		$post_data['categories'] = $terms_name_str;
		$post_data['cat_names']  = $terms_name_str;
		$post_data['cat_slugs']  = $terms_slug_str;

		$num_comments = get_comments_number(); // get_comments_number returns only a numeric value
		if ( comments_open() ) {
			if ( $num_comments == 0 ) {
				$comments = __('No Comments','mageewp-page-layout');
			} elseif ( $num_comments > 1 ) {
				$comments = $num_comments . __(' Comments','mageewp-page-layout');
			} else {
				$comments = __('1 Comment', 'mageewp-page-layout');
			}
			$post_data['comments'] = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
		} else {
			$post_data['comments'] =  __('Comments are off for this post.', 'mageewp-page-layout' );
		}
		
		$data[] = $post_data;
		$i ++;
	}
	$return_data = array();
	$return_data['data'] = $data;
	$return_data['pagination'] =  mpl_theme_native_pagenavi($the_query);
	$return_data['categories'] = array();
	foreach($categories as $key => $value) {
		$obj = array();
		$obj['name'] = $key;
		$obj['slug'] = $value;
		$return_data['categories'][] = $obj;
	}
	wp_reset_postdata() ;

	return $return_data;
}


/*
*  page navigation
*
*/
 function mpl_theme_native_pagenavi($wp_query,$echo=false){
    if(!$wp_query){global $wp_query;}
    global $wp_rewrite;      
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
    $pagination = array(
    'base' => @add_query_arg('paged','%#%'),
    'format' => '',
	'prev_text' =>  __('Prev', 'mageewp-page-layout' ),
    'total' => $wp_query->max_num_pages,
    'current' => $current,
	'type'      => 'list'
    );
 
    if( $wp_rewrite->using_permalinks() )
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg('s',get_pagenum_link(1) ) ) . 'page/%#%/', 'paged');
 
    if( !empty($wp_query->query_vars['s']) )
        $pagination['add_args'] = array('s'=>get_query_var('s'));
    if($echo == "echo"){
	echo "<nav class='post-pagination post-list-pagination' role='navigation'><div class='post-pagination-decoration'></div>".paginate_links($pagination)."</nav>";
	}else
	{
	return "<nav class='post-pagination post-list-pagination' role='navigation'><div class='post-pagination-decoration'></div>".paginate_links($pagination)."</nav>";
	}
}

/**
 * Query Post Data
 *
 */
function mpl_facebook_feed_data($atts)
{
	$date_format = '';
	extract($atts);
	if($date_format == '') $date_format = 'default';
	$data = array();
	$mpl_app_token = array(
                       '1377619605888926|LxwTNNAeRtn9nYhYS0VDkVDs0mI',
					   '393872077427061|ghfVBzNUFnMdFLAGlJbWAOVOelI',
					   '1505917499687703|2133Lp1cLt6Zk0N2por8X8QJf9k'
                       );
	$access_token = $mpl_app_token[rand(0,2)];
	
	$mpl_posts_json_url = 'https://graph.facebook.com/' . $page_id . '/posts?access_token=' . $access_token . '&limit=' . $num;
	
	//Use cURL
	$feedData = mpl_mff_fetchUrl($mpl_posts_json_url);
	
	$FBdata = json_decode($feedData) ;
	$fb_data = array();
	//If there's no data then show a pretty error message
	if( empty($FBdata->data) ) {
	$fb_data['error'] = array();	
			$fb_data['error'] = array(
				'message' => '',
				'type' => '',
				'code' => '',
				'error_subcode' => '',
				'error_msg' => '',
				'error_code' => '',
				'configuration' => '',
				'no_post' => ''
			);
	        if( isset($FBdata->error->message) ) $fb_data['error']['message'] = 'Error: ' . $FBdata->error->message;
            if( isset($FBdata->error->type) ) $fb_data['error']['type'] = '<br />Type: ' . $FBdata->error->type;
            if( isset($FBdata->error->code) ) $fb_data['error']['code'] = '<br />Code: ' . $FBdata->error->code;
            if( isset($FBdata->error->error_subcode) ) $fb_data['error']['error_subcode'] = '<br />Subcode: ' . $FBdata->error->error_subcode;

            if( isset($FBdata->error_msg) ) $fb_data['error']['error_msg'] = 'Error: ' . $FBdata->error_msg;
            if( isset($FBdata->error_code) ) $fb_data['error']['error_code'] = '<br />Code: ' . $FBdata->error_code;
            
            if($FBdata == null) $fb_data['error']['configuration'] = 'Error: Server configuration issue';

            if( empty($FBdata->error) && empty($FBdata->error_msg) && $FBdata !== null ) $fb_data['error']['no_post'] = 'Error: No posts available for this Facebook ID';
	
	} else {
	
	// Start Building HTML
	$mpl_final_post_text = ''; 
	$mpl_final_post_text_item_wrapper = '';
	$mpl_final_post_text_item_wrapper_complete = '';		
	$mpl_post_item = '';
	$fb_data['data'] = array();	
	foreach($FBdata->data as $post){
				$data = array(
					'post_type_class' => '',
					'author_id' => '',
					'post_id' => '',
					'author_form_id' => '',
					'author_form_name' => '',
					'updated_time' => '',
					'author_date' => '',
					'author_image_url' => '',
					'post_text' => '',
					'description' => '',
					'shared_link' => '',
					'event' => '',
					'media_link' => '',
					'share_link' => '',
					'share_link_text' => '',
					'share_facebook' => '',
					'share_twitter' => '',
					'share_google' => '',
					'share_linkedin' => '',
					'share_email' => ''
				);
	            $mpl_post_type = $post->type;
				isset($post->link) ? $link = htmlspecialchars($post->link) : $link = '';
				$PostID = '';
                $mpl_post_id = '';
				if( isset($post->id) ){
                $mpl_post_id = $post->id;
                $PostID = explode("_", $mpl_post_id);
                }   
				
				//POST AUTHOR
				/*$mpl_author = '<div class="mpl-fb-author">';*/
				//Author text
				$data['author_form_id'] = $post->from->id;
				$data['author_form_name'] = $post->from->name;
				$data['updated_time'] = $post->updated_time;
                /*$mpl_author .= '<a href="https://facebook.com/' . $post->from->id . '" target="_blank" title="'.$post->from->name.'">';
				$mpl_author .= '<div class="mpl-fb-author-text">';
                $mpl_author .= '<p class="mpl-fb-page-name">'.$post->from->name.'</p>';*/
				if(isset($post->updated_time) && $post->updated_time !=='' ){
					$time = strtotime($post->updated_time);
				if($date_format == 'default'){
					$data['author_date'] = mpl_facebook_default_time($time);
				}else{	
					$data['author_date'] = date_i18n($date_format,$time);
				}
					}
					
                /*$mpl_author .= '</div>';*/
				//Author image
                //Set the author image as a variable. If it already exists then don't query the api for it again.
				$data['author_image_url'] = 'https://graph.facebook.com/' . $post->from->id . '/picture?type=small';
				/*$author_image_url  = 'https://graph.facebook.com/' . $post->from->id . '/picture?type=small';
				if($author_image_url !== '')
				$mpl_author .= '<div class="mpl-fb-author-img"><img src="'.$author_image_url.'" title="'.$post->from->name.'" alt="'.$post->from->name.'" width=40 height=40></div>';
				
                $mpl_author .= '</a></div>'; */
				//POST TEXT
				$mpl_post_text = '<div class="mpl-fb-post-text">';
				
				$mpl_post_text .= '<span class="mpl-fb-text">';

                $mpl_post_text_type = '';
                $post_text = '';
                if (!empty($post->story)) {
                    $post_text = htmlspecialchars($post->story);
                    $mpl_post_text_type = 'story';
                }
                if (!empty($post->message)) {
                    $post_text = htmlspecialchars($post->message);
                    $mpl_post_text_type = 'message';
                }
                if (!empty($post->name) && empty($post->story) && empty($post->message)) {
                    $post_text = htmlspecialchars($post->name);
                    $mpl_post_text_type = 'name';
                }
                //Add message and story tags if there are any and the post text is the message or the story
                if(( isset($post->message_tags) || isset($post->story_tags) ) && ($mpl_post_text_type == 'message' || $mpl_post_text_type == 'story')){
                    
                    ( isset($post->message_tags) )? $text_tags = $post->message_tags : $text_tags = $post->story_tags;
                    if( ( $mpl_post_text_type == 'message' && isset($post->message_tags) ) || ( $mpl_post_text_type == 'story' && !isset($post->message_tags) ) ) {
                        $mpl_html_check_array = array('&lt;', '’', '“', '&quot;', '&amp;', '&gt;&gt;', '&gt;');
                        if( mpl_stripos_arr($post_text, $mpl_html_check_array) !== false ) {
							
                            foreach($text_tags as $message_tag ) {

                                ( isset($message_tag->id) ) ? $message_tag = $message_tag : $message_tag = $message_tag[0];

                                $tag_name = $message_tag->name;
                                $tag_link = '<a href="http://facebook.com/' . $message_tag->id . '" style="color: #'.$mpl_posttext_link_color.';" target="_blank">' . $message_tag->name . '</a>';

                                $post_text = str_replace($tag_name, $tag_link, $post_text);
                            }

                        } else {
                        //If it doesn't contain HTMl tags then use the offset to replace message tags
                            $message_tags_arr = array();

                            $i = 0;
                            foreach($text_tags as $message_tag ) {
                                $i++;

                                ( isset($message_tag->id) ) ? $message_tag = $message_tag : $message_tag = $message_tag[0];

                                $message_tags_arr[$i] = array(
                                        'id' => $message_tag->id,
                                        'name' => $message_tag->name,
                                        'type' => isset($message_tag->type) ? $message_tag->type : '',
                                        'offset' => $message_tag->offset,
                                        'length' => $message_tag->length
                                    );
                            }

                            for($i = count($message_tags_arr); $i >= 1; $i--) {

                                //If the name is blank (aka the story tag doesn't work properly) then don't use it
                                if( $message_tags_arr[$i]['name'] !== '' ) {
                               
                                    if( $mpl_post_text_type == 'story' && $message_tags_arr[$i]['type'] == 'event' ){
                                        //Don't use the story tag in this case otherwise it changes '__ created an event' to '__ created an Name Of Event'
                                    } else {
                                        $b = '<a href="http://facebook.com/' . $message_tags_arr[$i]['id'] . '">' . $message_tags_arr[$i]['name'] . '</a>';
                                        $c = $message_tags_arr[$i]['offset'];
                                        $d = $message_tags_arr[$i]['length'];

                                        $post_text = mpl_mff_substr_replace( $post_text, $b, $c, $d);
                                    }

                                }

                            } 

                        } 

                    } 

                } 

                //Replace line breaks in text (needed for IE8)
                $post_text = preg_replace("/\r\n|\r|\n/",'<br/>', $post_text);
                
                $mpl_post_text .= $post_text;
				$mpl_post_text .= '</span>';
				$mpl_post_text .= '</div>';
				$data['post_text'] = $post_text;
                //DESCRIPTION
				$mpl_description = '';
				$description_text = '';
				if ( !empty($post->description)  || !empty($post->caption) ) {

                    $description_text = '';
                    if ( !empty($post->description) ) {
                        $description_text = $post->description;
                    } else {
                        $description_text = $post->caption;
                    }
					
                    $mpl_description .= '<p class="mpl-fb-post-desc"><span>' .  htmlspecialchars($description_text). ' </span></p>';

                    //If the post text and description/caption are the same then don't show the description
                    if($post_text == $description_text) $mpl_description = '';

                    if( $mpl_post_type == 'event' ) $mpl_description = '';
                }
				
			  //Link Type Html
			  $mpl_shared_link = '';
                //Display shared link
                if ($mpl_post_type == 'link') {
                    $mpl_shared_link .= '<div class="mpl-fb-shared-link">';
                    if (!empty($post->description)) {
                        $mpl_shared_link .= '<div class="mpl-fb-text-link">';
                        //The link title:
                        $mpl_shared_link .= '<p class="mpl-fb-link-title"><a href="'.$link.'" target="_blank" >'. $post->name . '</a></p>';
                        //The link source:
                        (!empty($post->caption)) ? $mpl_link_caption = $post->caption : $mpl_link_caption = '';
                        if(!empty($mpl_link_caption)) $mpl_shared_link .= '<p class="mpl-fb-link-caption">'.$mpl_link_caption.'</p>';
                        if( $description_text != $mpl_link_caption ) $mpl_shared_link .= $mpl_description;
                        $mpl_shared_link .= '</div>';
                    }

                    $mpl_shared_link .= '</div>';
                }	
			//EVENT	Type Html
                $mpl_event = '';
                    //Check for media
                    if ($mpl_post_type == 'event') {
						$mpl_event_date = '';
                        $event_url = parse_url($link);
                        $url_parts = explode('/', $event_url['path']);
                        $eventID = $url_parts[count($url_parts)-2];

                        //Facebook changed the event link from absolute to relative, and so if the link isn't absolute then add facebook.com to front
                        ( stripos($link, 'facebook.com') ) ? $link = $link : $link = 'https://facebook.com' . $link;
                        
                        //Get the contents of the event using the WP HTTP API
                        $event_json_url = 'https://graph.facebook.com/'.$eventID.'?access_token=' . $access_token;
                        $event_json = mpl_mff_fetchUrl($event_json_url);
                        $event_object = json_decode($event_json);

                        //Event date
                        $event_time = $event_object->start_time;
						$event_end_time = '';
                        if(isset($event_object->end_time)){
							$end_time = strtotime($event_object->end_time);
							$event_end_time = ' - '.mpl_mff_eventdate($endtime);
									
						}
                        //If timezone migration is enabled then remove last 5 characters
                        if ( strlen($event_time) == 24 ) $event_time = substr($event_time, 0, -5);
                        if (!empty($event_time)) $mpl_event_date = '<p class="mpl-fb-date">' . mpl_mff_eventdate(strtotime($event_time), $date_format) .$event_end_time.'</p>';
						
                        //Display the event details
                        $mpl_event .= '<div class="mpl-fb-details">';
                        $mpl_event .= $mpl_event_date;
                        if (!empty($event_object->name)) {
                            $mpl_event .= '<a href="'.$link.'" target="_blank">';
                            $mpl_event .= '<p>' . $event_object->name . '</p>';
                            $mpl_event .= '</a>';
                        }                      
                        //Show event details
                        if (!empty($event_object->location)) $mpl_event .= '<p class="mpl-fb-location">' . $event_object->location . '</p>';
                            //Description
                            if (!empty($event_object->description)){
                                $description = $event_object->description;
                                $mpl_event .= '<p class="mpl-fb-info">' . $description . '</p>';
                            }
                        $mpl_event .= '</div>';
                        
                    }
                // Video Type Html

                //Check to see whether it's an embedded video so that we can show the name above the post text if necessary
                $mpl_is_video_embed = false;
                if ($post->type == 'video'){
                    $url = $post->source;
                    $youtube = 'youtube';
                    $youtu = 'youtu';
                    $vimeo = 'vimeo';
                    $youtubeembed = 'youtube.com/embed';
                    $youtube = stripos($url, $youtube);
                    $youtu = stripos($url, $youtu);
                    $youtubeembed = stripos($url, $youtubeembed);
                    if($youtube || $youtu || $youtubeembed || (stripos($url, $vimeo) !== false)) {
                        $mpl_is_video_embed = true;
                    }
                }
                $mpl_media = '';
                if ($post->type == 'video') {
                    if($mpl_is_video_embed) {
                        isset($post->name) ? $video_name = $post->name : $video_name = $link;
                        isset($post->description) ? $description_text = $post->description : $description_text = '';
                        //Add the 'cff-shared-link' class so that embedded videos display in a box
                        $mpl_description = '<div class="mpl-fb-desc-wrap mpl-fb-shared-link">';

                        if( isset($post->name) ) $mpl_description .= '<p class="mpl-fb-link-title"><a href="'.$link.'" target="_blank">'. $post->name . '</a></p>';
                        $mpl_description .= '<p class="mpl-fb-post-desc" ><span>' . htmlspecialchars($description_text) . '</span></p></div>';
                    } else {
                        isset($post->name) ? $video_name = $post->name : $video_name = $link;
                        if( isset($post->name) ) $mpl_description .= '<p class="mpl-fb-link-title"><a href="'.$link.'" target="_blank">'. $post->name . '</a></p>';
                    }
                }


                //Display the link to the Facebook post or external link
                $mpl_link = '';
                
                $link_text = 'View on Facebook';

                //Link to the Facebook post if it's a link or a video
                if($mpl_post_type == 'link' || $mpl_post_type == 'video') $link = "https://www.facebook.com/" . $page_id . "/posts/" . $PostID[1];

                //Social media sharing URLs
                $mpl_share_facebook = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($link);
                $mpl_share_twitter = 'https://twitter.com/intent/tweet?text=' . urlencode($link);
                $mpl_share_google = 'https://plus.google.com/share?url=' . urlencode($link);
                $mpl_share_linkedin = 'https://www.linkedin.com/shareArticle?mini=true&amp;url=' . urlencode($link) . '&amp;title=' . rawurlencode( strip_tags($mpl_post_text) );
                $mpl_share_email = 'mailto:?subject=Facebook&amp;body=' . urlencode($link) . '%20-%20' . rawurlencode( strip_tags($mpl_post_text) );

                //If it's a shared post then change the link to use the Post ID so that it links to the shared post and not the original post that's being shared
                if( isset($post->status_type) ){
                    if( $post->status_type == 'shared_story') $link = "https://www.facebook.com/" . $mpl_post_id;
                }

                //If it's an offer post then change the text
                if ($mpl_post_type == 'offer') $link_text = 'View Offer';

                //Create post action links HTML
                $mpl_link = '';
/*				$mpl_show_facebook_link = true;
				$mpl_show_facebook_share = true;*/
            
                    $mpl_link .= '<div class="mpl-fb-post-links">';
                    //View on Facebook link
					$data['share_link'] = $link;
					$data['share_link_text'] = $link_text;
					$data['share_facebook'] = $mpl_share_facebook;
					$data['share_twitter'] = $mpl_share_twitter;
					$data['share_google'] = $mpl_share_google;
					$data['share_linkedin'] = $mpl_share_linkedin;
					$data['share_email'] = $mpl_share_email;
                    $mpl_link .= '<a class="" href="' . $link . '" title="' . $link_text . '" target="_blank">' . $link_text . '</a>';
                    //Share link
                        $mpl_link .= '<div class="mpl-fb-share-container">';
                        //Only show separating dot if both links are enabled
                        $mpl_link .= '<span class="mpl-fb-dot">&nbsp;&middot;&nbsp;</span>';
                        $mpl_link .= '<a class="mpl-fb-share-link" href="javascript:void(0);" title="Share">Share</a>';
                        $mpl_link .= "<p class='mpl-fb-share-tooltip'><a href='".$mpl_share_facebook."' target='_blank' class='cff-facebook-icon'><i class='fa fa-facebook-square'></i></a><a href='".$mpl_share_twitter."' target='_blank' class='cff-twitter-icon'><i class='fa fa-twitter'></i></a><a href='".$mpl_share_google."' target='_blank' class='cff-google-icon'><i class='fa fa-google-plus'></i></a><a href='".$mpl_share_linkedin."' target='_blank' class='cff-linkedin-icon'><i class='fa fa-linkedin'></i></a><a href='".$mpl_share_email."' target='_blank' class='cff-email-icon'><i class='fa fa-envelope'></i></a><i class='fa fa-play fa-rotate-90'></i></p></div>";
                    
                    $mpl_link .= '</div>'; 


                /* MEDIA LINK */
                if (!isset($mpl_translate_photo_text) || empty($mpl_translate_photo_text)) $mpl_translate_photo_text = 'Photo';
                if (!isset($mpl_translate_video_text) || empty($mpl_translate_video_text)) $mpl_translate_video_text = 'Video';

                $mpl_media_link = '';
                if($mpl_post_type == 'photo' || $mpl_post_type == 'video' ){
                    $mpl_media_link .= '<p class="mpl-fb-media-link"><a href="'.$link.'" target="_blank"><i style="padding-right: 5px;" class="fa fa-';
                    if($mpl_post_type == 'photo') $mpl_media_link .=  'picture-o"></i>'. $mpl_translate_photo_text;
                    // if($mpl_post_type == 'video') $mpl_media_link .=  'file-video-o';
                    if($mpl_post_type == 'video') $mpl_media_link .=  'video-camera"></i>'. $mpl_translate_video_text;
                    $mpl_media_link .= '</a></p>';
                }


                //**************************//
                //***CREATE THE POST HTML***//
                //**************************//
                //Start the container
				/*if($style == "no") $mpl_post_item .= '<li class="mpl-isotope-item">';
				$mpl_post_item .= '<div class="mpl-fb-item ';*/
                if ($mpl_post_type == 'link') $data['post_type_class'] .= 'mpl-fb-link-item ';
                if ($mpl_post_type == 'event') $data['post_type_class'] .= 'mpl-fb-timeline-event ';
                if ($mpl_post_type == 'photo') $data['post_type_class'] .= 'mpl-fb-photo-post ';
                if ($mpl_post_type == 'video') $data['post_type_class'] .= 'mpl-fb-video-post ';
                if ($mpl_post_type == 'swf') $data['post_type_class'] .= 'mpl-fb-swf-post ';
                if ($mpl_post_type == 'status') $data['post_type_class'] .= 'mpl-fb-status-post ';
                if ($mpl_post_type == 'offer') $data['post_type_class'] .= 'mpl-fb-offer-post ';          
                $data['author_id'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-',$post->from->name)));
                $data['post_id'] = $mpl_post_id;
                    //POST AUTHOR
                    //$mpl_post_item .= $mpl_author;
                    //POST TEXT
                    //$mpl_post_item .= $mpl_post_text;
                    //DESCRIPTION
                    if($mpl_post_type != 'offer' && $mpl_post_type != 'link')
					$data['description']= $mpl_description;
					else
					$data['description']= '';
                    //LINK
                    //$mpl_post_item .= $mpl_shared_link;
					$data['shared_link'] = $mpl_shared_link;
                    //DATE BELOW
                    //$mpl_post_item .= $mpl_date;
                    //EVENT
                   // $mpl_post_item .= $mpl_event;
					$data['event'] = $mpl_event;
                    //DATE BELOW (only for Event posts)   
                    //if($mpl_post_type == 'event') $mpl_post_item .= $mpl_date;

                    //MEDIA LINK
                    //$mpl_post_item .= $mpl_media_link;
					$data['media_link'] = $mpl_media_link;
                    //VIEW ON FACEBOOK LINK
                    /*$mpl_post_item .= $mpl_link;*/
                
                //End the post item
                /*$mpl_post_item .= '</div>';
				if($style == "no") $mpl_post_item .= '</li>';*/
		$fb_data['data'][] = $data;
	}	
		
	}
	
	return $fb_data;
}

//@endif//@//@//@//@//@//@//@//@//@//@//@//@//@//@//@//@//@//@//@//@//@//@//@//@//@//@//@//@//@//@//@//@