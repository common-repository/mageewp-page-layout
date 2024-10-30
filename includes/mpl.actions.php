<?php

if(!defined('MPL_FILE')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

/*
*	admin init
*/

add_action('admin_init', 'mpl_admin_init');
function mpl_admin_init() {
	
	global $mpl;
		
	if (($mpl->action == 'live-editor' || $mpl->action == 'fonts-manager') && !defined('IFRAME_REQUEST')) {
		/*
		*	@live editor mode
		*	We sent the iframe request to wp system
		*/
		define ('IFRAME_REQUEST', true);
	}
	
	/* register mpl options */
	register_setting ('mageewp_page_layout_group', 'mpl_options', 'mpl_validate_options');

	$roles = array ('administrator', 'admin', 'editor','manage_options');

	foreach ($roles as $role) {
		if (!$role = get_role($role)) 
			continue;
			
		$role->add_cap('access_mageewp_page_layout');
	}
}


register_activation_hook( MPL_FILE, 'mpl_plugin_activate' );
function mpl_plugin_activate() {
	add_option('mpl_do_activation_redirect', true);
}

/*
*	Load languages
*/
add_action('plugins_loaded', 'mpl_load_lang');
function mpl_load_lang() {
	load_plugin_textdomain( 'mageewp-page-layout', false, MPL_SLUG . '/languages/' );
}

/*
*	Register assets ( js, css, font icons )
*/
add_action('admin_enqueue_scripts', 'mpl_assets', 1);
function mpl_assets() {
	
	global $mpl;
	$min = WP_DEBUG ? '' : '.min';

	wp_enqueue_style('mpl-global', MPL_URL.'/assets/css/mpl.global.css', false, MPL_VERSION );
	
	if ($mpl->action == 'fonts-manager') {
		wp_enqueue_style('mpl-icons', MPL_URL.'/assets/css/icons.css', false, MPL_VERSION );
		wp_enqueue_style('mpl-icons-mg', MPL_URL.'/assets/css/mpl.icons.css', false, MPL_VERSION );	
		wp_enqueue_style('mpl-fonts-manager-css', MPL_URL.'/assets/css/mpl.fonts.css', false, MPL_VERSION );
		wp_register_script('mpl-fonts-manager-js', MPL_URL.'/assets/js/mpl.fonts.js', null, MPL_VERSION, true );
		wp_enqueue_script('mpl-fonts-manager-js');
	}

	if (!isset($_GET['mpl_action']) || $_GET['mpl_action'] !== 'live-editor')
		return;
		
		if(class_exists('Jetpack')){

		add_action( 'admin_print_footer_scripts',  'mpl_editor_view_js_templates' );

		wp_enqueue_style( 'grunion-editor-ui', untrailingslashit(MPL_URL) .'/assets/jetpack/css/editor-ui.css' );
		wp_style_add_data( 'grunion-editor-ui', 'rtl', 'replace' );
		wp_enqueue_script( 'grunion-editor-view', untrailingslashit(MPL_URL). '/assets/jetpack/js/editor-view.js', array( 'wp-util', 'jquery', 'quicktags' ), false, true );
		wp_localize_script( 'grunion-editor-view', 'grunionEditorView', array(
			'inline_editing_style' => untrailingslashit(MPL_URL). '/assets/jetpack/css/editor-inline-editing-style.css', 
			'inline_editing_style_rtl' => untrailingslashit(MPL_URL). '/assets/jetpack/css/editor-inline-editing-style-rtl.css', 
			'dashicons_css_url'    => includes_url( 'css/dashicons.css' ),
			'default_form'  => '[contact-field label="' . __( 'Name', 'mageewp-page-layout' ) . '" type="name"  required="true" /]' .
								'[contact-field label="' . __( 'Email', 'mageewp-page-layout' )   . '" type="email" required="true" /]' .
								'[contact-field label="' . __( 'Website', 'mageewp-page-layout' ) . '" type="url" /]' .
								'[contact-field label="' . __( 'Message', 'mageewp-page-layout' ) . '" type="textarea" /]',
			'labels'      => array(
				'submit_button_text'  => __( 'Submit', 'mageewp-page-layout' ),
				/** This filter is documented in modules/contact-form/grunion-contact-form.php */
				'required_field_text' => apply_filters( 'jetpack_required_field_text', __( '(required)', 'mageewp-page-layout' ) ),
				'edit_close_ays'      => __( 'Are you sure you\'d like to stop editing this form without saving your changes?', 'mageewp-page-layout' ),
				'quicktags_label'     => __( 'contact form', 'mageewp-page-layout' ),
				'tinymce_label'       => __( 'Add contact form', 'mageewp-page-layout' ),
			)
		) );

		add_editor_style( untrailingslashit(MPL_URL). '/assets/jetpack/css/editor-style.css' );
		}

	// Stop loading assets from admin if not in allows content type
	if( is_admin() && !mpl_admin_enable() )
		return;
	
	$mpl->enqueue_fonts();
	
	wp_enqueue_script('wp-util');
	
	$p = untrailingslashit (MPL_URL).'/assets/css/';
	
	$args = array( 
		'builder' => $p.'mpl.builder' . $min . '.css', 
		'params' => $p.'mpl.params' . $min . '.css', 
		'animate' => $p.'animate.css',	
	);
	
	$icon_sources = $mpl->get_icon_sources();
	if (is_array($icon_sources) && count ($icon_sources) > 0) {
		$i = 1;
		foreach ($icon_sources as $icon_source)	{
			$args['sys-icon-'.$i++] = $icon_source;
		}
	}
		
	foreach ($args as $k => $v)	{
		wp_enqueue_style ('mpl-'.$k, $v, false, MPL_VERSION);
	}

	wp_register_script ('mpl-builder-backend-js', untrailingslashit(MPL_URL).'/assets/js/mpl.builder' . $min . '.js', array('jquery','wp-util'), MPL_VERSION, true);
	wp_enqueue_script ('mpl-builder-backend-js');
	wp_enqueue_script ('masonry');
	if ($mpl->action == 'live-editor') {
		wp_register_script ('mpl-shortcodes-js', untrailingslashit(MPL_URL).'/assets/js/shortcodes-tpl' . $min . '.js', array('jquery'), MPL_VERSION, true); 
		wp_register_script ('mpl-builder-frontend-js', untrailingslashit(MPL_URL).'/assets/js/mpl.front_builder' . $min . '.js', array('jquery','wp-util','mpl-tools','mpl-views','mpl-params','mpl-jscolor','mpl-pikaday','mpl-freshslider','mpl-shortcodes-js'), MPL_VERSION, true);
		
		wp_enqueue_script ('mpl-shortcodes-js');
		wp_enqueue_script ('mpl-builder-frontend-js');
	}

	$p = untrailingslashit (MPL_URL).'/assets/js/mpl.';
	$args = array(
		'tools' => $p.'tools' . $min . '.js', 
		'views' => $p.'views' . $min . '.js', 
		'params' => $p.'params' . $min . '.js', 
		'jscolor' => $p.'vendors/jscolor.js', 
		'pikaday' => $p.'vendors/pikaday.js', 
		'freshslider' => $p.'vendors/freshslider.min.js');
	
	foreach ($args as $k => $v)	{
		wp_register_script ('mpl-'.$k, $v, null, MPL_VERSION, true);
		wp_enqueue_script ('mpl-'.$k);
	}

	wp_enqueue_media();
	wp_enqueue_style('wp-pointer');
}


/**
*	Register filter for menu title
*/


add_filter( 'mpl_admin_menu_title', 'mpl_filter_admin_menu_title');

function mpl_filter_admin_menu_title ($menu_title) {

	$current = get_site_transient ('update_plugins');
	
	$count = 0;
    if (isset($current->response[MPL_BASE]))
    	$count++;
    
	if (defined('MPLP_BASENAME') && isset($current->response[MPLP_BASENAME]))
		$count++;
	
	if ($count > 0)
		$menu_title .= '&nbsp;<span class="update-plugins"><span class="plugin-count">'.$count.'</span></span>';
	
	return $menu_title;
	
}


/**
*	Register filter for adding body classes in backend
*/


add_filter ('admin_body_class', 'mpl_admin_body_classes');
function mpl_admin_body_classes ($classes) {
	
	global $mpl;
	
	if ($mpl->action == 'live-editor')
		return "$classes mpl-live-editor mpl-request-iframe";
		
	if ($mpl->action == 'fonts-manager')
		return "$classes mpl-fonts-manager mpl-request-iframe";
	
	return $classes;
		
}


/*
*	Add Menu Page in Backend
*/

add_action ('admin_bar_menu', 'mpl_admin_bar', 999);
function mpl_admin_bar ($wp_admin_bar) {

	global $mpl;
	if ($mpl->user_can_edit() !== false)
	{
		do_action('mpl-live-edit-link', $wp_admin_bar);	
	}
	
}

/*
*	Register settings page
*/
add_action ('admin_menu', 'mpl_settings_menu', 0);
function mpl_settings_menu() {
	
	$capability = apply_filters('access_mageewp_page_layout_capability', 'access_mageewp_page_layout');
	$icon = MPL_URL.'/assets/images/page_layout_icon.png';
	$menu_title = apply_filters('mpl_admin_menu_title', __( 'Mageewp Page Layout' , 'mageewp-page-layout'));

	add_menu_page(
		 __( 'Mageewp Page Layout' , 'mageewp-page-layout' ),
		$menu_title,
		$capability,
		'mageewp_page_layout',
		'mpl_main_page_screen',
		$icon
	);

	remove_submenu_page ('mageewp_page_layout', 'mageewp_page_layout');

	add_submenu_page(
		'mageewp_page_layout',
		esc_html__('Mageewp Page Layout', 'mageewp-page-layout'),
		esc_html__('Mageewp Page Layout', 'mageewp-page-layout'),
		$capability,
		'mageewp_page_layout',
		'mpl_main_page_screen'
	);

}

/*
*	Include admin pages' file
*/


function mpl_main_page_screen() {
	
	global $mpl, $pagenow;
	
	if( $mpl->action == 'live-editor' )
		$file = 'live.builder';
	else if( $mpl->action == 'fonts-manager' )
		$file = 'fonts';
	else if( $mpl->action == 'install-preset' )
		$file = 'install.preset';
	else if( $pagenow == 'admin.php' && isset($_GET['page']) && $_GET['page'] == 'mageewp_page_layout' )
		$file = 'dashboard';

	require_once MPL_PATH.MDS.'includes'.MDS.'mpl.'.$file.'.php';
}

add_action ('admin_head', 'mpl_admin_header');
add_action ('edit_form_after_title', 'mpl_after_title');
//add_action ('edit_form_after_editor', 'mpl_after_editor');
add_action ('admin_footer', 'mpl_admin_footer');



/*
*	Header init
*/
function mpl_admin_header() {

	if (is_admin() && !mpl_admin_enable())
		return;
	
	global $mpl;
	
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
	var mpl_site_url = '<?php echo site_url(); ?>',
		mpl_plugin_url = '<?php echo MPL_URL; ?>',
		shortcode_tags = '<?php
			global $shortcode_tags;

			$arrg = array();
			$maps = $mpl->get_maps();

			foreach( $maps as $key => $val ){
				array_push( $arrg, $key );
			}

			foreach( $shortcode_tags as $key => $val ){
				if( !in_array( $key, $arrg ) )
					array_push( $arrg, $key );
			}

			echo implode( '|', $arrg );
		?>',
		<?php 
			
		if( isset( $_GET['id'] ) ){
			echo 'mpl_post_ID = "'.$_GET['id'].'",';
			echo 'mpl_post_title = "'. esc_attr( get_the_title( $_GET['id'] ) ) .'",';
			if ( $_GET['id'] && has_post_thumbnail( $_GET['id'] ) ) {
				$image_id = get_post_thumbnail_id( $_GET['id'] );
			} else {
				$image_id = 0;
			}
			echo 'mpl_post_thumnail_ID = "'. esc_attr( $image_id ) .'",';
		}

		?>
		mpl_version = '<?php echo MPL_VERSION; ?>',
		mpl_url = '<?php echo MPL_URL; ?>',
		mpl_ajax_url = "<?php echo site_url('/wp-admin/admin-ajax.php'); ?>",
		mpl_profiles = <?php echo $mpl->get_profiles_db( false ); ?>,
		mpl_profiles_external = <?php echo json_encode( (object)$mpl->get_profile_sections() ); ?>,
		mpl_ajax_nonce = '<?php echo wp_create_nonce( "mpl-nonce" ); ?>',
		mpl_fonts_update = function( datas){ mpl.ui.fonts_callback( datas ); },
		mpl_fonts = <?php echo json_encode( get_option('mpl-fonts') ); ?>,
		mpl_action = '<?php echo $mpl->action; ?>',
		mpl_allows_types = <?php echo json_encode($mpl->get_support_content_types()); ?>,
		mpl_ignored_types = <?php echo json_encode($mpl->get_ignored_section_content_types()); ?>,
		mpl_top_bar_header = '<?php echo get_option('mpl_top_bar_header'); ?>',
		mpl_post_id = '',
		mpl_post_title = '',
		mpl_post_status = '',
		mpl_post_content = '',
		mpl_current_url = '',
		mpl_edit_post_url = '',
		mpl_post_url = '';
</script>
<?php
}

function mpl_utf8replacer($captures) {
	
	if ($captures[1] != "")
		return $captures[1];
	elseif ($captures[2] != "")
		return "\xC2".$captures[2];
	else return "\xC3".chr(ord($captures[3])-64);
	
}

/*
*	Create MPL buttons before wp editor
*/


function mpl_after_title ($post) {

	if (!is_admin() || !mpl_admin_enable())
		return;
	
	global $post;
	
	if (isset($post) && isset($post->post_content_filtered) && !empty( $post->post_content_filtered)) {
		$post->post_content = html_entity_decode (stripslashes_deep($post->post_content_filtered));
		$regex = '/((?: [\x00-\x7F] | [\xC0-\xDF][\x80-\xBF] | [\xE0-\xEF][\x80-\xBF]{2} | [\xF0-\xF7][\x80-\xBF]{3} ){1,100} ) | ( [\x80-\xBF] ) | ( [\xC0-\xFF] )/x';
		
		$post->post_content = preg_replace_callback($regex, "mpl_utf8replacer", $post->post_content);
		
	}
	
?>	
<div id="mpl-switcher-buttons">
	<?php do_action('mpl-switcher-buttons'); ?>
	<a href="#mpl-switcher-buttons" onclick="switch_live_editor('<?php echo site_url(); ?>')" class="mpl-button green alignleft" id="mpl-switch-builder">
		<img src="<?php echo MPL_URL.'/assets/images/page_layout_icon.png'?>"/>
		<?php _e('Mageewp Page Layout', 'mageewp-page-layout'); ?>
	</a>
</div>
<script type="text/javascript">
function switch_live_editor(site_url) {
	var id = jQuery('#post_ID').val(),
		type = jQuery('#post_type').val();
	
	if (typeof(id) == 'undefined')
		alert('Please save or submit first!');
	else if (typeof(type) == 'undefined')
		alert('type');
	else if (jQuery('#original_post_status').val() == 'auto-draft' ||  jQuery('#original_post_status').val() == 'draft')
		alert('Please publish!');
	else window.open(site_url + '/wp-admin/?page=mageewp_page_layout&mpl_action=live-editor&id=' + id);

	if (e !== undefined)	
		e.preventDefault();

	return false;
}
</script>
<?php
}

/*
*	Put post settings forms after editor
*/
function mpl_after_editor ($post) {

	if (!is_admin() || !mpl_admin_enable())
		return;
	
	global $mpl;
			
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
	
	if ($data['mode'] == 'mpl'){
	
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


// stop TinyMCE from removing <br> tags
function mpl_tinymce_fix($in) {
	
    //don't remove line breaks
    $in['remove_linebreaks'] = false;

    // convert newline characters to BR
    $in['convert_newlines_to_brs'] = true;

    // don't remove redundant BR
    $in['remove_redundant_brs'] = false;

    return $in;
    
}
add_filter ('tiny_mce_before_init', 'mpl_tinymce_fix');


/*
*	Load builder template at footer
*/

function mpl_admin_footer() {

	if (is_admin() && !mpl_admin_enable())
		return;

	do_action('mpl_before_admin_footer');
	
	require_once MPL_PATH.'/includes/mpl.js_languages.php';
	require_once MPL_PATH.'/includes/mpl.nocache_templates.php';
	
	do_action('mpl_after_admin_footer');
}


/*
*	Save post settings
*/
add_action('save_post', 'mpl_process_save', 10, 2);
function mpl_process_save ($post_id, $post) {

	if (!isset($_POST['content']) || !isset($_POST['post_ID']) || !current_user_can('publish_pages'))
		return;
		
	global $wpdb, $mpl;
	$id = $_POST['post_ID'];
	if (isset($_POST['mpl_post_meta']) && is_array($_POST['mpl_post_meta'])) {
		$meta = mpl_process_save_meta($id, $_POST['mpl_post_meta']);
	}
	
	
	$meta = get_post_meta( $id, 'mpl_data', FALSE );
	/*
	*	Create cache when MPL active
	*/
	if (isset($meta['mode']) && $meta['mode'] == 'mpl')
	{
		$mpl_front = apply_filters('mpl_front',  MPL_PATH.'/includes/mpl.front.php' );
        require_once $mpl_front;
		
		$content =  stripslashes_deep( $_POST['content'] );
		$content_processed = '';
		
		if (!empty($content))
		{
			/*
			* 	we don't have body class if the plugin was disabled
			*/
			$ext = '<style type="text/css" id="mpl-basic-css">'.mpl_basic_layout_css().'</style>';
			$ext .= '<p class="mpl-off-notice">'.__('Notice: You are using wrong way to display MPL Content', 'mageewp-page-layout').'</p>';
			
			$content_processed = $mpl->do_shortcode ($content);
			
			if (empty($content_processed))
			{
				$content_processed = $ext.$content_processed;
			
				$content_processed = str_replace( 
					array( "\n", 'body.mpl-css-system' ), 
					array( "", 'html body' ), 
					$content_processed 
				);
				$content_processed = preg_replace('/(?<=\>)[\s]+(?=\<)/i', '', $content_processed);
			}
		
		}
		
		$data = array(
			'ID' => $id,
			'post_title'   => $_POST['post_title'],
			'post_content' => $content_processed,
			'post_content_filtered' => $content
		);
		
		if (current_user_can('publish_pages'))
			$data['post_status']  = 'publish';
		
		$wpdb->update( 
			
		    $wpdb->prefix.'posts', 
		    
		    $data,
		    
		    array( 'ID' => $id )
		);
	}
	else{
		if( $_POST['action'] !== 'inline-save'){
			$wpdb->update(
				$wpdb->prefix.'posts',
				array(
					'ID' => $id,
					'post_content_filtered' => ''
				),
				array( 'ID' => $id )
			);
		}
	}
}

function mpl_process_save_meta($id, $meta = array()) {
	
	global $mpl;
	
	if (isset($mpl->optimized)) {
		$permalink = get_the_permalink($id);
		if (!empty($permalink))
			$mpl->optimized->delete_cache(get_the_permalink($id));
		$mpl->optimized->delete_cache(site_url());
	}

	$param = (array)get_post_meta ($id, 'mpl_data', true);

	if (!is_array($meta))
		$meta = array();
		
	foreach(
		array(  "mode" => "",'css' => '',  'classes' => '') 
		as $key => $value
	) {
		if (!isset($meta[$key]))
			$meta[$key] = '';
	}
	
	if (!add_post_meta( $id, 'mpl_data', $meta, true)) {
		foreach ($meta as $key => $value) {
			$param[$key] = $value;
		}
		update_post_meta( $id, 'mpl_data', $param );
		return $param;
	} return $meta;
}

/*
*	Include admin pages' file
*/
function mpl_force_default_editor() {
	// Force the editor switch to tinyMCE when the builder is active
	//allowed: tinymce, html, test
	return 'tinymce';
}

add_filter('single_template', 'mpl_content_template');
function mpl_content_template($single) {
	
    global $wp_query, $post;
    
    if ($post->post_type == "mpl-section") 
    {    
        if (file_exists(MPL_PATH.'/includes/single-section.php'))
            return MPL_PATH.'/includes/single-section.php';
    }
    
    return $single;
}

add_filter('page_row_actions', 'mpl_content_row_actions', 10, 2);
add_filter('post_row_actions', 'mpl_content_row_actions', 10, 2);
 
function mpl_content_row_actions ($actions, $post) {
	
	global $mpl;
	if (!current_user_can('edit_posts'))
		return $actions;
	$mpl_contents = $mpl->get_support_content_types();
	
    // Check for your post type.
    if (in_array($post->post_type, $mpl_contents)) 
    {
		$actions = array_merge($actions, array(
			'mpl' => sprintf( '<a href="%1$s">%2$s</a>',
				esc_url(admin_url('/?page=mageewp_page_layout&mpl_action=live-editor&id=' .$post->ID)),
					__('Mageewp Page Layout', 'mageewp-page-layout')
				) 
			)
		);
	}
 
    return $actions;
}

add_filter ('mpl_autocomplete_widget_content', 'mpl_widget_content_autocomplete');
function mpl_widget_content_autocomplete(){
	
	global $mpl;
	$mpl_contents = $mpl->get_support_content_types();
	$mpl_contents = implode(',', $mpl_contents);
	
	$query = array( 
		'post_type' => explode(',', $mpl_contents), 
		'posts_per_page' => 30, 
		'post_status'  => 'publish', 
		's' => isset($_POST['s']) ? esc_attr($_POST['s']) : '' 
	);
	
	$posts = new WP_Query($query);
	$data = array();
	if ($posts->have_posts())
	{
	    	
	    while ($posts->have_posts())
	    {
	    	
	    	$posts->the_post();
	    	
	    	$type = get_post_type();
	    	$type = str_replace (array('mpl-', '_', '-'),array('MPL ', ' ', ' '), $type);
	    	$type = ucwords ($type);
	    	
	    	$data[get_the_ID()] = esc_attr( $type.' - '.get_the_title() );
	    	
	    }
	    
	}
	
	return $data;
	
}

add_filter ('wp_get_attachment_image_src', 'mpl_get_attachment_image_src', 999, 4);
function mpl_get_attachment_image_src ($image = '', $id = '', $size = 'full', $icon = '') {
	
	if (is_array($image)) 
		return $image;

	// Move all attachs from xml to transient
	mpl_set_transient_xml_attachs();

	$atch = get_transient('mpl_attach_xml_'.$id);
	
	if (!empty($atch) && is_array($atch)){
		
		if (isset($atch['expiration']) && ($atch['expiration'] === 0 || $atch['expiration'] > time())) {
			if ($size == 'full' || !isset($atch['metadata']['sizes'][$size])) {
				
				return array(
					$atch['url'],
					$atch['metadata']['width'],
					$atch['metadata']['height'],
					''
				);
				
			}else{
				
				$url = explode('/', $atch['url']);
				array_pop($url);
				$url = implode('/', $url).'/';
				$atch = $atch['metadata']['sizes'][$size];
				
				return array(
					$url.$atch['file'],
					$atch['width'],
					$atch['height'],
					''
				);
			}
		}else{
			delete_transient('mpl_attach_xml_'.$id);
		}
	}
	
	/*return array(
		MPL_URL.'/assets/images/get_start.jpg',
		2000,
		1000,
		''
	);
	*/
	
	return array(
		'',
		'',
		'',
		''
	);
}

add_filter( 'the_content_export', 'mpl_the_content_export');
function mpl_the_content_export( $data ){
	
	global $post, $mpl;
	
	$allows_types = $mpl->get_support_content_types();
	
	if (in_array($post->post_type, $allows_types) && !empty( $post->post_content_filtered))
		return $post->post_content_filtered;
	else
		return $data;
}

//frontend edit inline
if (!function_exists('mpl_page_content_edit')) {
	function mpl_page_content_edit($wp_admin_bar) {
		global $post,$mpl;
		if (!is_object($wp_admin_bar)) {
			global $wp_admin_bar;
		}
		if ( is_page() ) {
			$wp_admin_bar->add_menu( array(
				'id' => 'mpl_inline-admin-bar-link',
				'title' => __( 'Mageewp Page Layout', 'jasmine' ),
				'href' => esc_url( admin_url('/?page=mageewp_page_layout&mpl_action=live-editor&id=' .$post->ID) ),
				'meta' => array( 'class' => 'mpl_inline-link' ),
			) );
		}
	}
	add_action('admin_bar_menu', 'mpl_page_content_edit',1000);
}

/**
* JS Templates.
*/
function mpl_editor_view_js_templates() {
		?>
<script type="text/html" id="tmpl-grunion-contact-form">
	<form class="card" action='#' method='post' class='contact-form commentsblock' onsubmit="return false;">
		{{{ data.body }}}
		<p class='contact-submit'>
			<input type='submit' value='{{ data.submit_button_text }}' class='pushbutton-wide'/>
		</p>
	</form>
</script>

<script type="text/html" id="tmpl-grunion-field-email">
	<div>
		<label for='{{ data.id }}' class='grunion-field-label email'>{{ data.label }}<# if ( data.required ) print( " <span>" + data.required + "</span>" ) #></label>
		<input type='email' name='{{ data.id }}' id='{{ data.id }}' value='{{ data.value }}' class='{{ data.class }}' placeholder='{{ data.placeholder }}' />
	</div>
</script>

<script type="text/html" id="tmpl-grunion-field-telephone">
	<div>
		<label for='{{ data.id }}' class='grunion-field-label telephone'>{{ data.label }}<# if ( data.required ) print( " <span>" + data.required + "</span>" ) #></label>
		<input type='tel' name='{{ data.id }}' id='{{ data.id }}' value='{{ data.value }}' class='{{ data.class }}' placeholder='{{ data.placeholder }}' />
	</div>
</script>

<script type="text/html" id="tmpl-grunion-field-textarea">
	<div>
		<label for='contact-form-comment-{{ data.id }}' class='grunion-field-label textarea'>{{ data.label }}<# if ( data.required ) print( " <span>" + data.required + "</span>" ) #></label>
		<textarea name='{{ data.id }}' id='contact-form-comment-{{ data.id }}' rows='20' class='{{ data.class }}' placeholder='{{ data.placeholder }}'>{{ data.value }}</textarea>
	</div>
</script>

<script type="text/html" id="tmpl-grunion-field-radio">
	<div>
		<label class='grunion-field-label'>{{ data.label }}<# if ( data.required ) print( " <span>" + data.required + "</span>" ) #></label>
		<# _.each( data.options, function( option ) { #>
			<label class='grunion-radio-label radio'>
				<input type='radio' name='{{ data.id }}' value='{{ option }}' class="{{ data.class }}" <# if ( option === data.value ) print( "checked='checked'" ) #> />
				<span>{{ option }}</span>
			</label>
		<# }); #>
		<div class='clear-form'></div>
	</div>
</script>

<script type="text/html" id="tmpl-grunion-field-checkbox">
	<div>
		<label class='grunion-field-label checkbox'>
			<input type='checkbox' name='{{ data.id }}' value='<?php esc_attr__( 'Yes', 'mageewp-page-layout' ); ?>' class="{{ data.class }}" <# if ( data.value ) print( 'checked="checked"' ) #> />
				<span>{{ data.label }}</span><# if ( data.required ) print( " <span>" + data.required + "</span>" ) #>
		</label>
		<div class='clear-form'></div>
	</div>
</script>

<script type="text/html" id="tmpl-grunion-field-checkbox-multiple">
	<div>
		<label class='grunion-field-label'>{{ data.label }}<# if ( data.required ) print( " <span>" + data.required + "</span>" ) #></label>
		<# _.each( data.options, function( option ) { #>
			<label class='grunion-checkbox-multiple-label checkbox-multiple'>
				<input type='checkbox' name='{{ data.id }}[]' value='{{ option }}' class="{{ data.class }}" <# if ( option === data.value || _.contains( data.value, option ) ) print( "checked='checked'" ) #> />
				<span>{{ option }}</span>
			</label>
		<# }); #>
		<div class='clear-form'></div>
	</div>
</script>

<script type="text/html" id="tmpl-grunion-field-select">
	<div>
		<label for='{{ data.id }}' class='grunion-field-label select'>{{ data.label }}<# if ( data.required ) print( " <span>" + data.required + "</span>" ) #></label>
		<select name='{{ data.id }}' id='{{ data.id }}' class="{{ data.class }}">
			<# _.each( data.options, function( option ) { #>
				<option <# if ( option === data.value ) print( "selected='selected'" ) #>>{{ option }}</option>
			<# }); #>
		</select>
	</div>
</script>

<script type="text/html" id="tmpl-grunion-field-date">
	<div>
		<label for='{{ data.id }}' class='grunion-field-label {{ data.type }}'>{{ data.label }}<# if ( data.required ) print( " <span>" + data.required + "</span>" ) #></label>
		<input type='date' name='{{ data.id }}' id='{{ data.id }}' value='{{ data.value }}' class="{{ data.class }}" />
	</div>
</script>

<script type="text/html" id="tmpl-grunion-field-text">
	<div>
		<label for='{{ data.id }}' class='grunion-field-label {{ data.type }}'>{{ data.label }}<# if ( data.required ) print( " <span>" + data.required + "</span>" ) #></label>
		<input type='text' name='{{ data.id }}' id='{{ data.id }}' value='{{ data.value }}' class='{{ data.class }}' placeholder='{{ data.placeholder }}' />
	</div>
</script>


<script type="text/html" id="tmpl-grunion-field-edit">
	<div class="card is-compact grunion-field-edit grunion-field-{{ data.type }}" aria-label="<?php esc_attr_e( 'Form Field', 'mageewp-page-layout' ); ?>">
		<label class="grunion-name">
			<span><?php esc_html_e( 'Field Label', 'mageewp-page-layout' ); ?></span>
			<input type="text" name="label" placeholder="<?php esc_attr_e( 'Label', 'mageewp-page-layout' ); ?>" value="{{ data.label }}"/>
		</label>

		<?php
		$grunion_field_types = array(
			'text'              => __( 'Text', 'mageewp-page-layout' ),
			'name'              => __( 'Name', 'mageewp-page-layout' ),
			'email'             => __( 'Email', 'mageewp-page-layout' ),
			'url'               => __( 'Website', 'mageewp-page-layout' ),
			'textarea'          => __( 'Textarea', 'mageewp-page-layout' ),
			'checkbox'          => __( 'Checkbox', 'mageewp-page-layout' ),
			'checkbox-multiple' => __( 'Checkbox with Multiple Items', 'mageewp-page-layout' ),
			'select'            => __( 'Drop down', 'mageewp-page-layout' ),
			'radio'             => __( 'Radio', 'mageewp-page-layout' ),
		);
		?>
		<div class="grunion-type-options">
			<label class="grunion-type">
				<?php esc_html_e( 'Field Type', 'mageewp-page-layout' ); ?>
				<select name="type">
					<?php foreach ( $grunion_field_types as $type => $label ) : ?>
					<option <# if ( '<?php echo esc_js( $type ); ?>' === data.type ) print( "selected='selected'" ) #> value="<?php echo esc_attr( $type ); ?>">
						<?php echo esc_html( $label ); ?>
					</option>
					<?php endforeach; ?>
				</select>
			</label>

			<label class="grunion-required">
				<input type="checkbox" name="required" value="1" <# if ( data.required ) print( 'checked="checked"' ) #> />
				<span><?php esc_html_e( 'Required?', 'mageewp-page-layout' ); ?></span>
			</label>
		</div>

		<label class="grunion-options">
			<?php esc_html_e( 'Options', 'mageewp-page-layout' ); ?>
			<ol>
				<# if ( data.options ) { #>
					<# _.each( data.options, function( option ) { #>
						<li><input type="text" name="option" value="{{ option }}" /> <a class="delete-option" href="javascript:;"><span class="screen-reader-text"><?php esc_html_e( 'Delete Option', 'mageewp-page-layout' ); ?></span></a></li>
					<# }); #>
				<# } else { #>
					<li><input type="text" name="option" /> <a class="delete-option" href="javascript:;"><span class="screen-reader-text"><?php esc_html_e( 'Delete Option', 'mageewp-page-layout' ); ?></span></a></li>
					<li><input type="text" name="option" /> <a class="delete-option" href="javascript:;"><span class="screen-reader-text"><?php esc_html_e( 'Delete Option', 'mageewp-page-layout' ); ?></span></a></li>
					<li><input type="text" name="option" /> <a class="delete-option" href="javascript:;"><span class="screen-reader-text"><?php esc_html_e( 'Delete Option', 'mageewp-page-layout' ); ?></span></a></li>
				<# } #>
				<li><a class="add-option" href="javascript:;"><?php esc_html_e( 'Add new option...', 'mageewp-page-layout' ); ?></a></li>
			</ol>
		</label>

		<a href="javascript:;" class="delete-field"><span class="screen-reader-text"><?php esc_html_e( 'Delete Field', 'mageewp-page-layout' ); ?></span></a>
	</div>
</script>

<script type="text/html" id="tmpl-grunion-field-edit-option">
	<li><input type="text" name="option" /> <a class="delete-option" href="javascript:;"><span class="screen-reader-text"><?php esc_html_e( 'Delete Option', 'mageewp-page-layout' ); ?></span></a></li>
</script>

<script type="text/html" id="tmpl-grunion-editor-inline">
			<h1 id="form-settings-header" class="grunion-section-header"><?php esc_html_e( 'Contact form information', 'mageewp-page-layout' ); ?></h1>
			<section class="card grunion-form-settings" aria-labelledby="form-settings-header">
				<label><?php esc_html_e( 'What would you like the subject of the email to be?', 'mageewp-page-layout' ); ?>
					<input type="text" name="subject" value="{{ data.subject }}" />
				</label>
				<label><?php esc_html_e( 'Which email address should we send the submissions to?', 'mageewp-page-layout' ); ?>
					<input type="text" name="to" value="{{ data.to }}" />
				</label>
			</section>
			<h1 id="form-fields-header" class="grunion-section-header"><?php esc_html_e( 'Contact form fields', 'mageewp-page-layout' ); ?></h1>
			<section class="grunion-fields" aria-labelledby="form-fields-header">
				{{{ data.fields }}}
			</section>
			<section class="grunion-controls">
				<?php submit_button( esc_html__( 'Add Field', 'mageewp-page-layout' ), 'secondary', 'add-field', false ); ?>

				<div class="grunion-update-controls">
					<?php submit_button( esc_html__( 'Cancel', 'mageewp-page-layout' ), 'delete', 'cancel', false ); ?>
					<?php submit_button( esc_html__( 'Update Form', 'mageewp-page-layout' ), 'primary', 'submit', false ); ?>
				</div>
			</section>
</script>

</div>
	<?php
	}