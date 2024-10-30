<?php

if(!defined('MPL_FILE')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

global $mpl;

?>
<div id="mpl-right-click-helper"><i class="sl-close"></i></div>
<div style="display:none;" id="mpl-storage-prepare">
	<div id="mpl-css-box-test"></div>
</div>
<img width="50" src="<?php echo MPL_URL; ?>/assets/images/drag.png" id="mpl-ui-handle-image" />
<img width="50" src="<?php echo MPL_URL; ?>/assets/images/drag-copy.png" id="mpl-ui-handle-image-copy" />
<div id="mpl-undo-deleted-element" style="display:none;">
	<a href="javascript:void(0)" class="do-action">
		<i class="icon-back"></i> <?php _e('Restore deleted items', 'mageewp-page-layout'); ?>
		<span class="amount">0</span>
	</a>	
	<div id="drop-to-delete"><span></span></div>
	<i class="sl-close"></i>	
</div>
<script type="text/html" id="tmpl-mpl-top-nav-template">
<?php do_action('mpl-top-nav'); ?>
</script>
<script type="text/html" id="tmpl-mpl-wp-widgets-template">
<div id="mpl-wp-list-widgets"><?php 
	
	if( !function_exists( 'submit_button' ) ){
		function submit_button( $text = null, $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null ) {
			echo mpl_get_submit_button( $text, $type, $name, $wrap, $other_attributes );
		}
	}
	
	ob_start();
		wp_list_widgets();
		$content = str_replace( array( '<script', '</script>' ), array( '&lt;script', '&lt;/script&gt;' ), ob_get_contents() );
	ob_end_clean();
	
	echo $content;
	
?></div>
</script>


