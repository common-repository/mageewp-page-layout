<?php


if(!defined('ABSPATH')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$mpl_fonts = get_option('mpl-fonts');

if( !is_array( $mpl_fonts ) )
	$mpl_fonts = array();

$count = count($mpl_fonts);

?>

<div id="mpl-fonts-manager">
	<div id="mpl-ggf-header">
		<h3>
			<?php _e('Fonts Manager', 'mageewp-page-layout'); ?>
			<small></small>
		</h3>
		<div id="mpl-ggf-hright">
			<input type="search" id="mpl-ggf-search" placeholder="<?php _e('Search by name', 'mageewp-page-layout'); ?>" />
			<i class="sl-magnifier"></i>
		</div>
		<ul>
			<li>
				<select id="mpl-ggf-filter">
					<option value="popularity"><?php _e('Sorting', 'mageewp-page-layout'); ?></option>
					<option value="popularity">Popular</option>
					<option value="trending">Trending</option>
					<option value="style">Style</option>
					<option value="alpha">Alpha</option>
				</select>
			</li>
			<li>
				<select id="mpl-ggf-language">
					<option value="">All subsets</option>
					<option value="arabic">Arabic</option>
					<option value="bengali">Bengali</option>
					<option value="cyrillic">Cyrillic</option>
					<option value="cyrillic-ext">Cyrillic Extended</option>
					<option value="devanagari">Devanagari</option>
					<option value="greek">Greek</option>
					<option value="greek-ext">Greek Extended</option>
					<option value="gujarati">Gujarati</option>
					<option value="hebrew">Hebrew</option>
					<option value="khmer">Khmer</option>
					<option value="latin">Latin</option>
					<option value="latin-ext">Latin Extended</option>
					<option value="tamil">Tamil</option>
					<option value="telugu">Telugu</option>
					<option value="thai">Thai</option>
					<option value="vietnamese">Vietnamese</option>
				</select>
			</li>
			<li>
				<select id="mpl-ggf-category">
					<option value="">All Categories</option>
					<option value="serif">Serif</option>
					<option value="sans serif">Sans Serif</option>
					<option value="display">Display</option>
					<option value="handwriting">Handwriting</option>
					<option value="monospace">Monospace</option>
				</select>
			</li>
			<li class="mpl-ggf-added" data-action="my-fonts">
				<i class="fa-folder-open" data-action="my-fonts"></i> 
				<?php _e('Your Fonts', 'mageewp-page-layout'); ?> 
				(<span data-action="my-fonts"><?php echo $count; ?></span>)
			</li>
			<li class="mpl-ggf-load-time">
				<?php _e('Load Time', 'mageewp-page-layout'); ?> 
				<?php
					if( $count < 4 )
						echo '<span>Fast</span>';
					else if( $count < 6 )
						echo '<span class="medium">Medium</span>';
					else if( $count < 9 )
						echo '<span class="slow">Slow</span>';
					else echo '<span class="slow">Very Slow</span>';
				?>
			</li>
		</ul>
	</div>
	<div id="mpl-ggf-my-fonts">
		<div id="mpl-ggf-mf-header">
			<span><?php _e('List fonts used in your site', 'mageewp-page-layout'); ?></span> 
			<i>(<?php _e('Please remove unused fonts to make your site load faster', 'mageewp-page-layout'); ?>)</i>
			<i class="sl-close" data-action="close-my-fonts"></i>
		</div>
		<div id="mpl-ggf-mf-body"></div>
	</div>
	<div id="mpl-ggf-body">
		<div id="mpl-ggf-pagination-top" class="mpl-ggf-pagination"></div>
		<div id="mpl-ggf-render"><span class="mpl-ggf-loading"><i class="fa-spinner fa-spin fa-2x fa-fw"></i></span></div>
		<div id="mpl-ggf-pagination-bottom" class="mpl-ggf-pagination"></div>
	</div>
	<div id="mpl-ggf-footer">
		
	</div>
</div>
<div id="mpl-fonts-manager-resource"></div>
<div id="mpl-fonts-manager-api"></div>
<script type="text/javascript">
	jQuery('#wpadminbar,#wpfooter,#adminmenuwrap,#adminmenuback,#adminmenumain,#screen-meta').remove();
	var mpl_fonts_nonce = '<?php echo wp_create_nonce( "mpl-fonts-nonce" ); ?>';
	var mpl_my_fonts = <?php echo json_encode( $mpl_fonts ); ?>
</script>