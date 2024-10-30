<?php

if (!defined('ABSPATH')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

$id = isset( $_GET['id'] ) ? esc_attr( $_GET['id'] ) : 0;

if (FALSE === get_post_status($id)) {
    echo '<script type="text/javascript">window.location.href="'.admin_url('/post.php?action=edit&post='.$id).'";</script>';
    return;
}

$link = get_permalink($id);
if (is_ssl()) {
	$link = str_replace('http:', 'https:', $link);
}

$data = get_post_meta($id, 'mpl_data', true);

if (!is_array($data))
	$data = array( "mode" => "mpl", "classes" => "", "css" => "");

$data["mode"] = 'mpl';

if (!add_post_meta($id, 'mpl_data', $data, true))
	update_post_meta($id, 'mpl_data', $data);

if (strpos($link, '?') === false)
	$link .= '?mpl_action=live-editor';
else 
	$link .= '&mpl_action=live-editor';
    
?>
<div id="mpladminbar">
<div class="mpladminbar-loading"><div id="preloader_1"> <span></span> <span></span> <span></span> <span></span> <span></span> </div></div>
<div class="mpladminbar-content">
	<ul class="mpl-bar-left">
		<li class="mpl-logo"><?php _e('Mageewp Page Layout', 'mageewp-page-layout');?></li>
	</ul>
	<ul class="mpl-bar-right">
        <?php do_action('mpl_before_bar');?>
		<li class="mobile"><i class="fa-mobile"></i></li>
		<li class="tablet"><i class="fa-tablet"></i></li>
		<li class="desktop"><i class="fa-desktop"></i></li>
		<li class="remove"><i class="fa-trash-o">&nbsp;<?php _e('Remove All Section', 'mageewp-page-layout');?></i></li>
		<li class="import"><i class="fa-pencil-square-o">&nbsp;<?php _e('Import Templates', 'mageewp-page-layout');?></i></li>
		<li class="add"><i class="fa-plus">&nbsp;<?php _e('Add Section', 'mageewp-page-layout');?></i></li>
		<li class="save"><i class="fa-check ">&nbsp;<?php _e('Update', 'mageewp-page-layout');?></i></li>
		<li class="exit"><i class="fa-sign-in">&nbsp;<?php _e('Exit', 'mageewp-page-layout');?></i></li>
        <?php do_action('mpl_after_bar');?>
	</ul>
    </div>
</div>
<div id="mpl-live-frame-wrp">
	<iframe id="mpl-live-frame" src="<?php echo esc_url( $link ); ?>"></iframe>
    <div id="mpl-live-frame-resizer"></div>
</div>
<div style="height: 0px;width: 0px;overflow:hidden;">
	<?php wp_editor('', 'mpl-editor-preload', array("wpautop" => false, "quicktags" => true)); ?>
</div>
<script type="text/javascript">
	function mpl_load_delay(){
		setTimeout(function(){
			var mpl_live_frame = jQuery('#mpl-live-frame').get(0).contentWindow.jQuery;
			if( typeof mpl_live_frame != 'undefined' && typeof top != 'undefined' && typeof (top.mpl) != 'undefined' && typeof (top.mpl.front) != 'undefined'){
				top.mpl.front.init();
				jQuery('.mpladminbar-loading').hide();
				jQuery('.mpladminbar-content').show();
			}else{
				mpl_load_delay();
				}
		},500);
		}
	jQuery('#wpadminbar,#wpfooter,#adminmenuwrap,#adminmenuback,#adminmenumain,#screen-meta,.notice').remove();
	jQuery('.mpladminbar-content').hide();
	jQuery('.mpladminbar-loading').show();
	mpl_load_delay();
</script>