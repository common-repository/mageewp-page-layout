<?php

if(!defined('MPL_FILE')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}
	
$mpl = MageewpPageLayout::globe();
	
?>
<script type="text/html" id="tmpl-mpl-container-template">
	<#
		var claz = [];
		if (mpl.cfg.showTips == 0)
			claz.push('hideTips');
		if (jQuery('#mpl-page-cfg-collapsed').val() == 'collapse'){
			claz.push('collapse');
		}
	#>
	<div id="mpl-container" class="{{claz.join(' ')}}">
		<div id="mpl-controls">
			<button class="button button-large red classic-mode">
				<i class="icon-back"></i> 
				<?php _e('Classic Mode', 'mageewp-page-layout'); ?>
			</button>
			<button class="button button-large yellow front-editor">
				<i class="et-edit"></i> 
				<?php _e('Frontend Editor', 'mageewp-page-layout'); ?>	 
			</button>
			{{{mpl.template('top-nav')}}}
			<button class="button button-large alignright collapse mtips">
				<i class="icon-expand1"></i> 
				<span class="mt-mes"><?php _e('Expand / Collapse Builder', 'mageewp-page-layout'); ?></span>
			</button>
			<button class="button button-large alignright post-settings mtips">
				<i class="icon-content-setting"></i> 
				<span class="mt-mes"><?php _e('Page Settings', 'mageewp-page-layout'); ?></span>
			</button>
			
			<button class="button button-large alignright green mtips basic-add">
				<i class="icon-sections"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></i><?php _e('Add Sections', 'mageewp-page-layout'); ?>
				<span class="mt-mes"><?php _e('Add Sections', 'mageewp-page-layout'); ?></span>
			</button>
<button class="button button-large alignright blue mtips mpl-add-sections">
				<i class="icon-sections-library"></i><?php _e('Import Templates', 'mageewp-page-layout'); ?>
				<span class="mt-mes"><?php _e('Import Templates', 'mageewp-page-layout'); ?></span>
			</button>
			
			<!--button class="button button-large alignright save-page-content mtips">
				<i class="sl-paper-plane"></i> 
				<span class="mt-mes"><?php _e('Save all content to section', 'mageewp-page-layout'); ?></span>
			</button-->
			
			
		</div>
		
		<div id="mpl-rows">
			<div id="mpl-empty-screen">
				<h3><?php _e('You have a blank page', 'mageewp-page-layout'); ?></h3>
				<p><?php _e('Add new section layout', 'mageewp-page-layout'); ?></p>
			</div>
		</div>
		
		<div id="mpl-footers">
		  <div class="mpl-add-new">
			<button class="mpl-button green basic-add"><i class="icon-sections"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span></i><?php _e('Add new section', 'mageewp-page-layout'); ?></button>
		  </div>
		</div>
		
	</div>	
</script>
<script type="text/html" id="tmpl-mpl-clipboard-template">
	<div id="mpl-clipboard">
		<ul class="ms-funcs">
			<li>
				<strong><?php _e('Tips', 'mageewp-page-layout'); ?>:</strong> 
				<?php _e('Drag and drop to arrange items, click to select an item.', 'mageewp-page-layout'); ?> 
				
			</li>
			<li class="delete button delete right">
				<?php _e('Delete selected', 'mageewp-page-layout'); ?> <i class="sl-close"></i>
			</li>
			<li class="select button right">
				<?php _e('Select all', 'mageewp-page-layout'); ?> <i class="sl-check"></i>
			</li>
			<li class="unselect button right">
				<?php _e('Unselect all', 'mageewp-page-layout'); ?> <i class="sl-close"></i>
			</li>
		</ul>
		<#
		try{
			var clipboards = mpl.backbone.stack.get( 'MPL_ClipBoard' ), 
				outer = '<div style="text-align:center;margin:20px auto;"><?php _e('The ClipBoard is empty, Please copy elements to clipboard', 'mageewp-page-layout'); ?>.</div>';
			
			if( clipboards.length > 0 ){
				
				var stack, map, li = '';
					
				for( var n in clipboards ){
					if( clipboards[n] != null && clipboards[n] != undefined ){
						
						stack = clipboards[n];
						map = mpl.maps[stack.title];
						
						li += '<li data-sid="'+n+'" title="<?php _e('Click to select, drag to move', 'mageewp-page-layout'); ?>">';
						if( map != undefined ){
							if( map['icon'] != undefined )
								li += '<span class="ms-icon cpicon '+map['icon']+'"></span>';
						}
						li += '<span class="ms-title">'+stack.title.replace(/\mpl_/g,'').replace(/\_/g,' ').replace(/\-/g,' ')+'</span>';
						li += '<span class="ms-des">'+mpl.tools.unesc(stack.des)+'</span>';
						li += '<i title="<?php _e('Paste now', 'mageewp-page-layout'); ?>" class="ms-quick-paste fa-paste"></i></li>';
						
					}
				}
				
			}else{
				li = '<h2 class="align-center"><?php _e('No items found, please copy elements first.', 'mageewp-page-layout'); ?></h2>';
			}
		}catch(e){console.log(e);}	
		#>
		<ul class="ms-list">{{{li}}}</ul>
	</div>
	<# 
		data.callback = mpl.ui.clipboard;
	#>
</script>
<script type="text/html" id="tmpl-mpl-post-settings-template">
	<div id="mpl-page-settings">
		<h1 class="mgs-t02">
			<?php _e('Page Settings', 'mageewp-page-layout'); ?>
		</h1>
		<button class="button pop-btn save-post-settings"><?php _e('Save', 'mageewp-page-layout'); ?></button>
		
		
		<div class="m-settings-row">
			<div class="msr-left">
				<label><?php _e('Body Class', 'mageewp-page-layout'); ?></label>
				<span><?php _e('The class will be added to body tag on the front-end', 'mageewp-page-layout'); ?> </span>
			</div>
			<div class="msr-right">
				<div class="msr-content">
					<input data-page-setting="classes" type="text" placeholder="Body classes" value="{{data.classes}}" />
				</div>
			</div>
		</div>
		
		<div class="m-settings-row">
			<div class="msr-left msr-single">
				<label><?php _e('Css Code', 'mageewp-page-layout'); ?></label>
				<button class="button button-larger css-beautifier float-right">
					<i class="sl-energy"></i> <?php _e('Beautifier', 'mageewp-page-layout'); ?>
				</button>
				<textarea class="rt03" data-page-setting="css" >{{data.css}}</textarea>
				<i><?php _e('Notice: CSS must contain selectors', 'mageewp-page-layout'); ?></i>
			</div>
		</div>
		
		
	
	
		<button class="button pop-btn save-post-settings"><?php _e('Save', 'mageewp-page-layout'); ?></button>
	</div>
	<#
		data.callback = function( wrp, $ ){
			
			wrp.find('.save-post-settings').on( 'click', wrp, function(e){
				var obj = {};
				$('[data-page-setting]').each(function(){
					$('#mpl-page-cfg-'+$(this).data('page-setting')).val(this.value);
					obj[$(this).data('page-setting')] = this.value;
				});
				
				mpl.get.popup( this, 'close' ).trigger('click');
				
				if(mpl.front){
					$.ajax({
						method: 'POST',
						url: mpl_ajax_url,
						dataType:'json',
						data: {action : 'mpl_post_meta_update',id:mpl_post_id,post_meta:obj},
						success: function(data){
							console.log(data);
							},
						error:function(data){
							console.log(data);
							}
						});
				}
				
			});
			
			wrp.find('.css-beautifier').on( 'click', function(){
				var txta = $(this).parent().find('textarea');
				txta.val( mpl.tools.decode_css( txta.val() ) );
			});
			
			wrp.find('.showTipsCfg').on( 'click', function(event){
				mpl.ui.elms( event, this );
				if( mpl.cfg.showTips == 1 )
					$('#mpl-container').removeClass('hideTips');
				else $('#mpl-container').addClass('hideTips');
			});
			
			wrp.find('.open-library').on('click', { callback : function( atts ){
		
				var wrp = $(this.el).closest('.m-settings-row'), url = atts.url;

				if( atts.size != undefined && atts.size != null && atts.sizes[atts.size] != undefined ){
					var url = atts.sizes[atts.size].url;
				}else if( typeof atts.sizes.medium == 'object' ){
					var url = atts.sizes.medium.url;
				}

				if( url != undefined && url != '' ){
					wrp.find('input[name="m-c-thumbnail"]').val(url);
					wrp.find('img.thumnail-preview').attr({src: url});
				}
				
			}, atts : {frame:'post'} }, mpl.tools.media.open );
			
			wrp.find('input[name="m-c-thumbnail"]').on('change', function(){
				$(this).closest('.m-settings-row').find('img.thumnail-preview').attr({src: this.value});
			})
			
		}
	#>
</script>

<script type="text/html" id="tmpl-mpl-optimized-settings-template">
	<div id="mpl-page-settings" class="mpl-optimize-settings mpl-optimized-{{mpl_global_optimized.enable}}">
		<h1 class="mgs-t02">
			<span><?php _e('Enable Optimized', 'mageewp-page-layout'); ?>:</span>
			<div class="mpl-ui-kit boolen">
				<input value="on" type="checkbox" {{(mpl_global_optimized.enable=='on'?'checked':'')}} data-optimized="enable" />
				<label></label>
			</div>
			<button class="button clear-cache"><i class="fa-warning"></i> <?php _e('Clear Cache', 'mageewp-page-layout'); ?></button>
		</h1>
		<div class="m-settings-row show-on">
			<div class="msr-left">
				<label><?php _e('Things that will be optimized on your website:', 'mageewp-page-layout'); ?></label>
				<span>
					<ol>
						<li><?php _e('Pre-render all resources to static files', 'mageewp-page-layout'); ?></li>
						<li><?php _e('Combined js internal & external resources', 'mageewp-page-layout'); ?></li>
						<li><?php _e('Combined css internal & external resources', 'mageewp-page-layout'); ?></li>
						<li><?php _e('Minify HTML, JS, CSS', 'mageewp-page-layout'); ?></li>
						<li><?php _e('Prevent javascript blocking', 'mageewp-page-layout'); ?></li>
						<li><?php _e('Compression and gzip for page speed', 'mageewp-page-layout'); ?></li>
						<li><?php _e('Leverage browser caching', 'mageewp-page-layout'); ?></li>
					</ol>
				</span>
			</div>
			<div class="msr-right">
				<i class="sl-rocket"></i>
			</div>
		</div>
		<div class="m-settings-row">
			<div class="msr-left">
				<label><?php _e('Active This Page', 'mageewp-page-layout'); ?></label>
				<span>
					<?php _e('Force to active or deactive from global settings', 'mageewp-page-layout'); ?>.
				</span>
			</div>
			<div class="msr-right">
				<div class="msr-content">
					<select data-optimized="this_page">
						<option<# if (data.optimized != 'active' && data.optimized != 'deactive'){ #> selected<# } #> value="global">
							<?php _e('Use global settings' , 'mageewp-page-layout'); ?>
						</option>
						<option<# if (data.optimized == 'active'){ #> selected<# } #> value="active">
							<?php _e('Force Active' , 'mageewp-page-layout'); ?>
						</option>
						<option<# if (data.optimized == 'deactive'){ #> selected<# } #> value="deactive">
							<?php _e('Force Deactive' , 'mageewp-page-layout'); ?>
						</option>
					</select>
				</div>
			</div>
		</div>
		<div class="m-settings-row m-notice">
			<i class="fa-info-circle"></i>
			<?php _e('Notice: The optimization mode  is activated only for not logged in and cart empty (woocommerce)', 'mageewp-page-layout'); ?>
		</div>
		<div class="m-settings-row">
			<div class="msr-left">
				<label><?php _e('Active All Page (Global Settings)', 'mageewp-page-layout'); ?></label>
				<span>
					<?php _e('Active optimization for all pages built with MPL. You can active or deactive for each specific page', 'mageewp-page-layout'); ?>.
				</span>
			</div>
			<div class="msr-right">
				<div class="msr-content">
					<div class="mpl-ui-kit boolen">
						<input value="1" type="checkbox" {{(mpl_global_optimized.global==1?'checked':'')}} data-optimized="global" />
						<label></label>
					</div>
				</div>
			</div>
		</div>
		
		<div class="m-settings-row">
			<div class="msr-left">
				<label><?php _e('Advanced Optimization', 'mageewp-page-layout'); ?></label>
				<span>
					<?php _e('Enable advanced optimization such as gzip, browser caching (required changes .htaccess)', 'mageewp-page-layout'); ?>.
				</span>
			</div>
			<div class="msr-right">
				<div class="msr-content">
					<div class="mpl-ui-kit boolen">
						<input value="1" type="checkbox" {{(mpl_global_optimized.advanced==1?'checked':'')}} data-optimized="advanced" />
						<label></label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<# data.callback = mpl.ui.callbacks.optimize_settings; #>
</script>

<script type="text/html" id="tmpl-mpl-sections-template">
<div id="mpl-sections"<# if( mpl.sections.total > 1 ){ #> class="paged"<# } #> data-cols="{{mpl.sections.cols}}">
	
	<# if( mpl.sections.total > 1 ){ #> 
		<div class="mpl-section-pagination">
			<# if (mpl.sections.count !== undefined && mpl.sections.count != 0) { #>
				<span class="items">{{mpl.sections.count}} <?php _e('items total', 'mageewp-page-layout'); ?></span>
			<# } #>
			<#	
			if (mpl.sections.total <= 15) {
				#><ul><li data-action="page" data-page='prev'><?php _e('Previous', 'mageewp-page-layout'); ?></li><#
				for( var i=1; i<=mpl.sections.total; i++ ){
					#><li class="<# if( mpl.sections.paged == i ){ #>active <# } #>page-{{i}}" data-action="page">{{i}}</li><#
				}
				#><li data-action="page" data-page='next'><?php _e('Next', 'mageewp-page-layout'); ?></li></ul><#
			}else{
				#><span class="pages-select"><select><#
				for( var i=1; i<=mpl.sections.total; i++ ){
					#><option<# if( mpl.sections.paged == i ){ #> selected<# } #> value="{{i}}"><# if( mpl.sections.paged == i ){ #><?php _e('Page', 'mageewp-page-layout'); ?> {{i}}/{{mpl.sections.total}} <# }else{ #>{{i}}<#} #></option><#
				}	
				#></select></span><#
			}
			#>
		</div>
	<# }else if (mpl.sections.count !== undefined && mpl.sections.count != 0){ #>
		<div class="mpl-section-pagination">
			<span class="items">{{mpl.sections.count}} <?php _e('items total', 'mageewp-page-layout'); ?></span>
		</div>
	<# } #>
	<#
		
		var current_item = data.pop.data('current_item');
		
		for( var i=0; i<mpl.sections.items.length; i++ ){
			var item = mpl.sections.items[i];
			
			if( !item.preview )
				item.preview = mpl_plugin_url+'/assets/images/get_start.jpg';
	#>
	<div class="mpl-sections-item<#
		
			if( item.id == current_item ){
			#> selected<#	
			}
			
		#>" data-id="{{item.id}}" data-title="{{item.title}}">
		<div class="mpl-section-sceenshot">
			<img src="{{item.preview}}" alt="" />
			<# 
			if (item.type !== undefined && item.type == 'xml') {
			#>
				<span class="mpl-section-no-push"><?php
					_e('Do not support saving to prebuilt template, please chose another content types.', 'mageewp-page-layout');
				?></span>
				<button class="button button-primary button-large mpl-section-use-prebuilt" data-action="prebuilt">
					<i class="sl-plus" data-action="prebuilt"></i> <?php _e('Use this template', 'mageewp-page-layout'); ?>
				</button>
			<#
			}else{
			#>
			<button class="mpl-section-include" data-action="link">
				<i class="sl-link" data-action="link"></i> <?php _e('Include', 'mageewp-page-layout'); ?>
			</button>
			<button class="mpl-section-clone" data-action="clone">
				<i class="icon-double" data-action="clone"></i> <?php _e('Clone', 'mageewp-page-layout'); ?>
			</button>
			<button class="mpl-section-push" data-action="push">
				<i class="fa-plus" data-action="push"></i> <?php _e('Push In', 'mageewp-page-layout'); ?>
			</button>
			<button class="mpl-section-overwrite" data-action="overwrite">
				<i class="fa-refresh" data-action="overwrite"></i> <?php _e('Overwrite', 'mageewp-page-layout'); ?>
			</button>
			<# } #>
		</div>
		<div class="mpl-section-info">
			<span>{{item.title}}</span>
			<# 
			if (item.type !== undefined && item.type == 'xml') {
			#>
				<i class="date">{{item.date}}</i>
			<#	
			}else{
			#>
			<div class="mpl-section-funcs">
				<a class="edit-section" href="<?php echo esc_url(admin_url('/?page=mageewp_page_layout&mpl_action=live-editor&id=')); ?>{{item.id}}" target="_blank">
					<i title="<?php _e('Edit section', 'mageewp-page-layout'); ?>" class="sl-pencil edit-section"></i>
				</a>
				<a class="share-section" href="#share" data-action="share">
					<i title="<?php _e('Share this section to MPL Hub', 'mageewp-page-layout'); ?>" class="sl-share share-section" data-action="share"></i>
				</a>
				<a class="delete-section" href="#delete" data-action="delete">
					<i title="<?php _e('Delete section', 'mageewp-page-layout'); ?>" class="sl-trash delete-section" data-action="delete"></i>
				</a>
			</div>
			<i class="taxonomies">{{item.categories.join(', ')}}</i>
			<# } #>
		</div>
	</div>
	<#		
		}
	#>
	
	<# if( mpl.sections.total > 1 ){ #> 
		<div class="mpl-section-pagination bottom">
			<#	
			if (mpl.sections.total <= 15) {
				#><ul><li data-action="page" data-page='prev'><?php _e('Previous', 'mageewp-page-layout'); ?></li><#
				for( var i=1; i<=mpl.sections.total; i++ ){
					#><li class="<# if( mpl.sections.paged == i ){ #>active <# } #>page-{{i}}" data-action="page">{{i}}</li><#
				}
				#><li data-action="page" data-page='next'><?php _e('Next', 'mageewp-page-layout'); ?></li></ul><#
			}else{
				#><span class="pages-select"><select><#
				for( var i=1; i<=mpl.sections.total; i++ ){
					#><option<# if( mpl.sections.paged == i ){ #> selected<# } #> value="{{i}}"><# if( mpl.sections.paged == i ){ #><?php _e('Page', 'mageewp-page-layout'); ?> {{i}}/{{mpl.sections.total}} <# }else{ #>{{i}}<#} #></option><#
				}	
				#></select></span><#
			}
			#>
		</div>
	<# } #>
	
	
	<div class="mpl-section-share">
		<div class="mpl-ss-body">
			<div class="mpl-ss-left">
				<div class="mpl-ss-thumbnail"></div>
				<div class="mpl-ss-section">
					<label><?php _e('Section', 'mageewp-page-layout'); ?>:</label>
					<span></span>
				</div>
				<div class="mpl-ss-source">
					<label><?php _e('Source', 'mageewp-page-layout'); ?>:</label>
					<span>{{mpl_site_url}}</span>
				</div>
				<div class="mpl-ss-name">
					<label><?php _e('Your Name', 'mageewp-page-layout'); ?>:</label>
					<span><input type="text" /></span>
				</div>
				<div class="mpl-ss-email">
					<label><?php _e('Your Email', 'mageewp-page-layout'); ?>:</label>
					<span><input type="email" /></span>
				</div>
				<div class="mpl-ss-btns">
					<button class="button button-primary mpl-ss-share-submit">
						<?php _e('Submit to MPL Hub', 'mageewp-page-layout'); ?>
					</button>
					<button class="button mpl-ss-share-cancel">
						<?php _e('Cancel', 'mageewp-page-layout'); ?>
					</button>
				</div>
			</div>
			<div class="mpl-ss-right">
				<h1><?php _e('Share your design to MPL Hub', 'mageewp-page-layout'); ?></h1>
				<h2><?php _e('What is MPL Hub?', 'mageewp-page-layout'); ?></h2>
				<p>
					<?php _e('MPL Hub is a free resource, where you can install any preset design template with one click. You can use anyone\'s design sharing and you can also share your design so that anyone can use them.', 'mageewp-page-layout'); ?>
				</p>
				<br />
				<h2><?php _e('How to be accepted?', 'mageewp-page-layout'); ?></h2>
				<p>
					<?php _e('After submitting, we will review before publishing. We only accept which design has been built on our CSS system and does not require external CSS. Then MPL Users can install them everywhere.', 'mageewp-page-layout'); ?>
				</p>
			</div>
		</div>
	</div>
</div>
<# data.callback = mpl.ui.sections.render_callback; #>
</script>

<script type="text/html" id="tmpl-mpl-components-template">
<#

var maps = jQuery.extend({}, mpl.maps, true), /* Clone maps */
	categories = [],
	more = [],
	category = catz = li = name = desc = icon = n = '',
	i = 0;
				
	var parent = {name: ''},
		accept_child = [], except_child = [],
		accept_parent = except_parent = '';
	
	if (mpl.storage[data.model] !== undefined && maps[mpl.storage[data.model].name] !== undefined) {
		parent = maps[mpl.storage[data.model].name];
		parent.name = mpl.storage[data.model].name;
	}
	
	if (parent.accept_child !== undefined && parent.accept_child !== '')
		accept_child = parent.accept_child.replace(/\ /g, '').split(',');
	
	if (parent.except_child !== undefined && parent.except_child !== '')
		except_child = parent.except_child.replace(/\ /g, '').split(',');

	for (n in maps) {
		
		if (
			(accept_child.length > 0 && accept_child.indexOf(n) === -1) ||
			(except_child.length > 0 && except_child.indexOf(n) > -1)
		) {
			delete maps[n];
		}
		
		if (maps[n] !== undefined && maps[n].accept_parent !== undefined && maps[n].accept_parent !== '') {
			accept_parent = maps[n].accept_parent.replace(/\ /g, '').split(',');
			if (accept_parent.indexOf(parent.name) === -1) {
				delete maps[n];
			}
		}
		
		if (maps[n] !== undefined && maps[n].except_parent !== undefined && maps[n].except_parent !== '') {
			except_parent = maps[n].except_parent.replace(/\ /g, '').split(',');
			if (except_parent.indexOf(parent.name) > -1) {
				delete maps[n];
			}
		}
		
	}

#>
	<div class="mpl-components">
		<ul class="mpl-components-categories">
			<li data-category="all" class="all active"><?php _e('All', 'mageewp-page-layout'); ?></li>
			<#
				
				for (n in maps) {
					category = (maps[n].category !== undefined) ? maps[n].category : '';
					category = category.toString();
					if (categories.indexOf(category) === -1 && category !== '') {
						categories.push(category);
					}
				}
				
				categories.sort();
				var limitcatz = 6;
				if (jQuery(window).width() < 1350)
					limitcatz = 2;
					
				for (i=0 ; i<categories.length; i++) {
					catz = mpl.tools.esc_slug (categories[i]);
					li = '<li data-category="'+catz+'" class="'+catz+'">'+categories[i]+'</li>';
					
					if (i < limitcatz){ #>{{{li}}}<# }
					else more.push(li);
				}
				
				if (more.length > 0) {
					#><li class="more"><?php _e('More', 'mageewp-page-layout'); ?> <i class="sl-options" aria-hidden="true"></i><ul><#
					
					for (i=0; i<more.length; i++) {
						#>{{{more[i]}}}</li><#
					}
					#></ul></li><#
				}
				
			#>
			
			
			
			
		</ul>
		<ul class="mpl-components-list-main mpl-components-list">
			<#
			
				for (n in maps) {
					if (maps[n].system_only !== true) {
						category = (maps[n].category !== undefined) ? maps[n].category : uncategoried;
						name = (maps[n].name !== undefined) ? maps[n].name : '';
						desc = (maps[n].description !== undefined) ? maps[n].description : '';
						icon = (maps[n].icon !== undefined) ? maps[n].icon : '';
						support = (maps[n].support !== undefined) ? maps[n].support : '';
						rule = (maps[n].rule !== undefined) ? maps[n].rule : '';
						#>
							<li title="{{desc}}" data-support="{{support}}" data-rule="{{rule}}"  data-category="{{mpl.tools.esc_slug(category)}}" data-name="{{n}}" class="mpl-element-item mcpn-{{mpl.tools.esc_slug(category)}}">
								<div>
									<i class="cpicon {{icon}}" aria-hidden="true"></i>
									<span class="cpdes">
										<strong>{{name}}</strong>
									</span>
									
								</div>
							</li>
						<#
					}
				}
				
				delete maps, categories, more, category, catz, li, 
					   name, desc, icon, n, i;
					   
				if (parent !== undefined)
					delete parent, accept_child, except_child, accept_parent, except_parent;
				
			#>
		</ul>
	</div>
</script>
<script type="text/html" id="tmpl-mpl-templates-template">

</script>

<script type="text/html" id="tmpl-mpl-row-template">
<#
 
var fEr3 = '', Hrdw = '', sEtd4 = '';

if( data.row_id !== undefined && data.row_id != '__empty__' )
	sEtd4 = '#'+data.row_id;

if( data.disabled !== undefined && data.disabled == 'on' ){
	fEr3 = ' collapse',
	Hrdw = ' disabled';
}

if( data.__section_link !== undefined )
	fEr3 += ' mpl-section-link';

if (data._collapse !== undefined && data._collapse == '1')
	fEr3 += ' collapse';

#>
	<div class="mpl-row m-r-sortdable{{fEr3}}">
		<ul class="mpl-row-control row-container-control">
		
		<# if( data.__section_link === undefined ){ #>
		
			<li class="right close mtips">
				<i class="sl-close"></i>
				<span class="mt-mes"><?php _e('Delete this section', 'mageewp-page-layout'); ?></span>
			</li>
			<li class="right move mtips">
				<i class="icon-dragndrop"></i>
				<span class="order-row">
					<input type="number" placeholder="order" /> <button><i class="fa-exchange"></i></button>
				</span>
				<span class="mt-mes"><?php _e('Drag and drop to arrange this section', 'mageewp-page-layout'); ?></span>
			</li>
			<li class="double mtips">
				<i class="icon-double"></i>
				<span class="mt-mes"><?php _e('Double this section', 'mageewp-page-layout'); ?></span>
			</li>

			
		<# }else{ #>
		
			<li class="right close mtips">
				<i class="sl-close"></i>
				<span class="mt-mes"><?php _e('Delete this section', 'mageewp-page-layout'); ?></span>
			</li>
			<li class="right move mtips">
				<i class="icon-dragndrop"></i>
				<span class="order-row">
					<input type="number" placeholder="order" /> <button><i class="fa-exchange"></i></button>
				</span>
				<span class="mt-mes"><?php _e('Drag and drop to arrange this section', 'mageewp-page-layout'); ?></span>
			</li>
			
		<# } #>
		
		</ul>
		<div class="mpl-row-admin-view">{{sEtd4}}</div>
		<!--<ul class="mpl-row-control row-container-control pos-left">
			
			<# if( data.__section_link === undefined ){ #>
			
			<li class="right collapse mtips">
				<i class="icon-expand1"></i>
				<span class="mt-mes"><?php _e('Expand / Collapse this row', 'mageewp-page-layout'); ?></span>
			</li>
			
						
			<li class="rowStatus{{Hrdw}} mtips">
				<i></i>
				<span class="mt-mes"><?php _e('Publish / Unpublish this section', 'mageewp-page-layout'); ?></span>
			</li>
			<# }else if( data.__section_title !== undefined ){ #>
				<li class="right collapse mtips">
					<i class="icon-expand1"></i>
					<span class="mt-mes"><?php _e('Expand / Collapse this section', 'mageewp-page-layout'); ?></span>
				</li>
				<li class="bpdl">
					<strong class="red"><i class="sl-link"></i> {{data.__section_title}}</strong>
					<?php if(!defined('MPL_SLUG'))exit; ?>
				</li>
				<li class="rowStatus{{Hrdw}} mtips">
					<i></i>
					<span class="mt-mes"><?php _e('Publish / Unpublish this section', 'mageewp-page-layout'); ?></span>
				</li>
			<# } #>
		</ul>	-->
		<div class="mpl-row-wrap"><# 
			if( data.__section_link !== undefined ){
			#>
			<div class="mpl-row-section-body">
				<div class="mpl-row-section-preview">
					<img src="<?php echo admin_url("/admin-ajax.php?action=mpl_get_thumbn&size=full&type=post_featured&id="); ?>{{data.__section_link}}" />
					<a href="<?php echo admin_url('/post.php?action=edit&post='); ?>{{data.__section_link}}" class="kcrbtn edit" target=_blank>
						<i class="icon-section-settings"></i> <?php _e('Go to edit this section', 'mageewp-page-layout'); ?>
					</a>
					<button class="kcrbtn select select-another-section" data-current="{{data.__section_link}}">
						<i class="sl-list"></i> <?php _e('Select another section', 'mageewp-page-layout'); ?>
					</button>
				</div>
			</div>
			<# } #></div>
	</div>
</script>
<script type="text/html" id="tmpl-mpl-row-inner-template">
	<div class="mpl-row-inner">
		<ul class="mpl-row-control mpl-row-inner-control">
			<li class="right delete mtips">
				<i class="sl-close"></i>
				<span class="mt-mes"><?php _e('Delete this row', 'mageewp-page-layout'); ?></span>
			</li>
			<li class="right settings edit mtips">
				<i class="icon-section-settings"></i>
				<span class="mt-mes"><?php _e('Open row settings', 'mageewp-page-layout'); ?></span>
			</li>
			<li class="right double mtips">
				<i class="icon-double"></i>
				<span class="mt-mes"><?php _e('Double this row', 'mageewp-page-layout'); ?></span>
			</li>
			<li class="right move mtips">
				<i class="icon-dragndrop"></i>
				<span class="mt-mes"><?php _e('Drag and drop to arrange this row', 'mageewp-page-layout'); ?></span>
			</li>
		</ul>
		<ul class="mpl-row-control pos-left mpl-row-inner-control">
			<li class="right collapse mtips">
				<i class="icon-expand1"></i>
				<span class="mt-mes"><?php _e('Expand / Collapse this row', 'mageewp-page-layout'); ?></span>
			</li>
			<li class="right columns mtips">
				<i class="sl-list"></i>
				<span class="mt-mes"><?php _e('Set number of columns for this row', 'mageewp-page-layout'); ?></span>
			</li>
			<li class="right copyRowInner mtips">
				<i class="sl-doc"></i>
				<span class="mt-mes"><?php _e('Copy this row', 'mageewp-page-layout'); ?></span>
			</li>
		</ul>	
		<div class="mpl-row-wrap"></div>
	</div>	
</script>
<script type="text/html" id="tmpl-mpl-column-template">
	<div class="mpl-column" style="width: {{data.width}}">
		<ul class="mpl-column-control column-container-control">
			<li class="mpl-column-settings more">
				
			</li>
		</ul>
		<div class="mpl-column-wrap">
			<div class="mpl-element drag-helper">
				<a href="javascript:void(0)" class="mpl-add-elements-inner">
					<i class="sl-plus"></i> <?php _e('Add Element', 'mageewp-page-layout'); ?>
				</a>
			</div>
		</div>
		
		<div class="column-resize cr-left"></div>
		<div class="column-resize cr-right"></div>
		<div class="mpl-cols-info">{{Math.round(parseFloat(data.width))}}%</div>
	</div>
</script>
<script type="text/html" id="tmpl-mpl-column-inner-template">
	<div class="mpl-column-inner" style="width: {{data.width}}">
		<ul class="mpl-column-control column-inner-control">
			<li class="mpl-column-settings more">
				
			</li>
		</ul>
		<div class="mpl-column-wrap">
			<div class="mpl-element drag-helper">
				<a href="javascript:void(0)" class="mpl-add-elements-inner">
					<i class="sl-plus"></i> <?php _e('Add Sections', 'mageewp-page-layout'); ?>
				</a>
			</div>
		</div>
		
		<div class="column-resize cr-left"></div>
		<div class="column-resize cr-right"></div>
		<div class="mpl-cols-info">{{Math.round(parseFloat(data.width))}}%</div>
	</div>
</script>
<script type="text/html" id="tmpl-mpl-views-sections-template">
	<#
		try{
			var sct = mpl.maps[data.name].views.sections;
			if( mpl.maps[data.name].views.display == 'vertical' )
				var vertical = ' mpl-views-vertical';
		}catch(e){
			var sct = 'mpl_tab', vertical = 'mpl-views-horizontal';
		}	
	#>
	<div class="mpl-views-sections mpl-views-{{data.name}}{{vertical}}">
		<ul class="mpl-views-sections-control mpl-controls">
			<li class="right move mtips">
				<i class="icon-dragndrop"></i> {{mpl.maps[data.name].name}}
				<span class="mt-mes"><?php _e('Drag and drop to arrange this element', 'mageewp-page-layout'); ?></span>
			</li>
			<li class="more" title="<?php _e('More Actions', 'mageewp-page-layout'); ?>">
				<i class="fa fa-caret-right"></i>
				<div class="mme-more-actions">
					<ul>
						<li class="right edit" title="<?php _e('Edit', 'mageewp-page-layout'); ?>">
							<i class="icon-section-settings"></i>
						</li>
						<li class="double" title="<?php _e('Double', 'mageewp-page-layout'); ?>">
							<i class="icon-double"></i>
						</li>
						<li class="copy" title="<?php _e('Copy', 'mageewp-page-layout'); ?>">
							<i class="sl-doc"></i>
						</li>
						<li class="cut" title="<?php _e('Cut', 'mageewp-page-layout'); ?>">
							<i class="fa fa-cut"></i> 
						</li>
						<li class="delete" title="<?php _e('Delete', 'mageewp-page-layout'); ?>">
							<i class="fa fa-trash-o"></i>
						</li>
					</ul>
				</div>
			</li>
		</ul>
		<div class="mpl-views-sections-wrap">
			<div class="mpl-views-sections-label">
				<div class="add-section">
					<i class="sl-plus"></i> <span> <?php _e('Add', 'mageewp-page-layout'); ?> {{mpl.maps[sct].name}}</span>
				</div>
			</div>	
		</div>
	</div>
</script>
<script type="text/html" id="tmpl-mpl-views-section-template">
	<#
		var icon = '';
		if( data.args.icon != undefined )
			icon = '<i class="'+data.args.icon+'"></i> ';
	#>
	<div class="mpl-views-section<# if(data.first==true){ #> mpl-section-active<# } #>">
		<h3 class="mpl-vertical-label icon-expand1">{{{icon}}}{{data.args.title}}</h3>
		<ul class="mpl-controls-2 mpl-vs-control">
			<li class="right add mtips">
				<i class="sl-plus"></i>
				<span class="mt-mes"><?php _e('Add Sections', 'mageewp-page-layout'); ?></span>
			</li>
			<li class="right double mtips">
				<i class="icon-double"></i>
				<span class="mt-mes"><?php _e('Double this section', 'mageewp-page-layout'); ?></span>
			</li>
			<li class="right settings mtips">
				<i class="icon-section-settings"></i>
				<span class="mt-mes"><?php _e('Open settings', 'mageewp-page-layout'); ?></span>
			</li>
			<li class="right delete mtips" title="<?php _e('Remove', 'mageewp-page-layout'); ?>">
				<i class="sl-close"></i>
				<span class="mt-mes"><?php _e('Remove this section', 'mageewp-page-layout'); ?></span>
			</li>
		</ul>
		<div class="mpl-views-section-wrap mpl-column-wrap">
			<div class="mpl-element drag-helper">
				<a href="javascript:void(0)" class="mpl-add-elements-inner">
					<i class="sl-plus"></i> <?php _e('Add Section', 'mageewp-page-layout'); ?>
				</a>
			</div>
		</div>
	</div>
</script>
<script type="text/html" id="tmpl-mpl-element-template">
	<#
		var el_class = [];
		el_class.push (data.params.name);
		
		if(data.map.preview_editable == true)
			el_class.push ('viewEditable');
		
		if(data.map.nested === true)
			el_class.push ('nestedView');				
	#>
	
	<div class="mpl-element {{el_class.join(' ')}}">
		<div class="mpl-element-icon"><span class="cpicon {{data.map.icon}}"></span></div>
		<span class="mpl-element-label">{{data.map.name}}</span>  {{data.params.args.section_title}} 
		<div class="mpl-element-control" title="<?php _e('Drag to move this element', 'mageewp-page-layout'); ?>">
			<ul class="mpl-controls pos-bottom">
				<li class="edit mtips" title="">
					<i class="icon-section-settings"></i>
					<span><?php _e('Edit this section', 'mageewp-page-layout'); ?></span>
				</li>
				
			</ul>
		</div>
		<# if (data.map.nested === true){ #>
		<div class="mpl-column-wrap">
			<div class="mpl-element drag-helper">
				<a href="javascript:void(0)" class="mpl-add-elements-inner">
					<i class="sl-plus"></i> <?php _e('Add Element', 'mageewp-page-layout'); ?>
				</a>
			</div>
		</div>
		<# } #>
	</div>
</script>
<script type="text/html" id="tmpl-mpl-undefined-template">
	 <div class="mpl-undefined mpl-element {{data.params.name}}">
		<div class="admin-view content">{{data.params.args.content}}</div>
		<div class="mpl-element-control">
		
			<ul class="mpl-controls">
				<li class="edit" title="<?php _e('Edit', 'mageewp-page-layout'); ?>">
					<i class="icon-section-settings"></i>
				</li>
				
			</ul>
		</div>		
	</div>
</script>
<script type="text/html" id="tmpl-mpl-popup-template">
	<div class="mpl-params-popup wp-pointer-top {{data.class}}<# if(data.bottom!=0){ #> posbottom<# } #>" style="<# if(data.bottom!=0){ #>bottom:{{data.bottom}}px;top:auto;<# }else{ #>top:{{data.top}}px;<# } #>left:{{data.left}}px;<#
			if( data.width != undefined ){ #>width:{{data.width}}px<# } 
		#>">
		<div class="m-p-wrap wp-pointer-content">
			<h3 class="m-p-header">
				<i data-prevent-drag="true" class="m-p-toggle dashicons icon-expand1" title="<?php _e('Collapse popup', 'mageewp-page-layout'); ?>"></i>
				<span data-st="label">{{data.title}}</span>
				<# if( data.help != '' ){ #>
				<a href="{{data.help}}" target="_blank" title="<?php _e('Help', 'mageewp-page-layout'); ?>" class="sl-help sl-func">
					&nbsp;
				</a>
				<# } #>
				<i data-prevent-drag="true" title="<?php _e('Cancel & close popup', 'mageewp-page-layout'); ?>" class="sl-close fa fa-close mpl-close sl-func"></i>
				<i data-prevent-drag="true" title="<?php _e('Save changes (ctrl+s)', 'mageewp-page-layout'); ?>" class="sl-check sl-func"></i></h3>
			<div class="m-p-body">
				{{{data.content}}}
			</div>
			<# if( data.footer === true ){ #>
			<div class="m-p-footer">
				<ul class="m-p-controls">
					<li>
						<button class="button save button-large">
							<i class="sl-check"></i> {{data.save_text}}
						</button>
					</li>
					<# if (data.no_cancel === false) { #>
					<li>
						<button class="button cancel button-large">
							<i class="sl-close"></i> {{data.cancel_text}}
						</button>
					</li>
					<# } #>
					<li class="pop-tips">{{{data.footer_ext}}}</li>
				</ul>
			</div>
			<# } #>
			<# if( data.success_mesage !== undefined ){ #>
			<div class="m-p-overlay">{{{data.success_mesage}}}</div>
			<# } #>
		</div>
		<div class="wp-pointer-arrow"<#
				if( data.pos != undefined ){
					var css = '';
					if( data.pos == 'center' ){
						css += 'left:50%;margin-left:-13px;';
					}else if( data.pos == 'right' ){
						css += 'left:auto;right:50px;';
					}
					if( css != '' ){
						#> style="{{css}}"<#
					}
				}
			#>>
			<div class="wp-pointer-arrow-inner"></div>
		</div>
	</div>
</script>
<script type="text/html" id="tmpl-mpl-field-template">
	<#
		
		/*
		*	Some of param name is not allowed to use, because it would conflict with the system
		*	So if we will not render this field & display the warning instead
		*/
		//console.log(data.base);
		var iglist = ['css', 'css_data', 'content', '_name', '_id', '_full', '_content', '_base', '_collapse'];
		if (data.name == 'textarea_html')
		{
			if (data.base != 'content')
				data.content = '<p class="mpl-notice"><i class="fa-warning"></i> <?php _e('The name of this field must be set to "content"', 'mageewp-page-layout'); ?></p>';
		}else if (iglist.indexOf(data.base) > -1 && ['text', 'textarea'].indexOf(data.name) === -1) 
		{
			data.content = '<p class="mpl-notice"><i class="fa-warning"></i> <?php _e('The name of this field is not allowed to use as', 'mageewp-page-layout'); ?> "'+data.base+'"</p>';
		}
	
		var el_class = ['mpl-param-row'], 
			base_class = '';
		
		el_class.push ('field-'+data.name.replace(/[^0-9a-zA-Z\-\_]/g,''));
		
		if (data.base !== undefined) {
			base_class = data.base;
			if (data.base.indexOf('[') > -1)
				base_class = data.base.substr(0, data.base.indexOf('['));
				
			if (data.base.indexOf('[') > -1)
				base_class += '-' + data.base.substr(data.base.indexOf('[') + 1).replace(/\[/g, '-').replace(/\]/g, '');
			//if (data.base.indexOf('][') > -1)
			//	base_class += '-'+data.base.substr(data.base.indexOf('][') + 2).replace(/\]/g, '');
		}
		
		el_class.push( 'field-base-'+base_class );
		
		if( data.relation != undefined )
			el_class.push( 'relation-hidden' );
			
	#>
	<div class="{{el_class.join(' ')}}">
		<# if( data.label != undefined && data.label != '' ){ #>
		<div class="m-p-r-label">
			<label>{{{data.label}}}:</label>
		</div>
		<div class="m-p-r-content">
		<# }else{ #>
		<div class="m-p-r-content full-width">
		<# } #>	
			{{{data.content}}}
			<# if( data.des != undefined && data.des != '' ){ #>
				<div class="m-p-r-des">{{{data.des}}}</div>
			<# } #>
		</div>
	</div>
</script>

<script type="text/html" id="tmpl-mpl-row-columns-template">
	<div class="mpl-row-columns">
		&nbsp; <input type="checkbox" data-name="columnDoubleContent" id="m-r-c-double-content" {{mpl.cfg.columnDoubleContent}} /> 
		<?php _e('Double content', 'mageewp-page-layout'); ?> 
		<a href="javascript:alert('<?php _e('Copy content in the last column to the newly-created column. This option is available when you choose to set the column amount greater than the current column amount', 'mageewp-page-layout'); ?>.\n\n<?php _e('For example: Currently there is 1 column and you are going to set 2 columns', 'mageewp-page-layout'); ?>')"> <i class="sl-question"></i> </a> &nbsp; &nbsp; 
		<input type="checkbox" data-name="columnKeepContent" id="m-r-c-keep-content" {{mpl.cfg.columnKeepContent}} /> 
		<?php _e('Keep content', 'mageewp-page-layout'); ?> <a href="javascript:alert('<?php _e('Keep content of the removed column and transfer it to the last existing column', 'mageewp-page-layout'); ?>.\n\n<?php _e('This option is available when you choose to set the column amount smaller than the current column amount', 'mageewp-page-layout'); ?>.\n\n<?php _e('For example: Currently there are 2 columns and you are going to set 1 column', 'mageewp-page-layout'); ?>.')"> <i class="sl-question"></i> </a>
		<br /><br />
		<p class="mpl-col-btns">
			<button class="button button-large<# if( data.current == 1 ){ #> active<# } #>" data-column="1">
				1 <?php _e('Column', 'mageewp-page-layout'); ?> &nbsp;
			</button>
			<button class="button button-large<# if( data.current == 2 ){ #> active<# } #>" data-column="2">
				2 <?php _e('Columns', 'mageewp-page-layout'); ?> &nbsp;
			</button>
			<button class="button button-large<# if( data.current == 3 ){ #> active<# } #>" data-column="3">
				3 <?php _e('Columns', 'mageewp-page-layout'); ?> &nbsp;
			</button>
		</p>
		<p class="mpl-col-btns">
			<button class="button button-large<# if( data.current == 4 ){ #> active<# } #>" data-column="4">
				4 <?php _e('Columns', 'mageewp-page-layout'); ?> &nbsp;
			</button>
			<button class="button button-large<# if( data.current == 5 ){ #> active<# } #>" data-column="5">
				5 <?php _e('Columns', 'mageewp-page-layout'); ?> &nbsp;
			</button>
			<button class="button button-large<# if( data.current == 6 ){ #> active<# } #>" data-column="6">
				6 <?php _e('Columns', 'mageewp-page-layout'); ?> &nbsp;
			</button>
		</p>
		<p class="mpl-col-custom">
			<input type="text" placeholder="Example: 15% + 35% + 6/12" />
			<button data-column="custom" class="button button-large">Apply</button>
		</p>
	</div>
</script>

<script type="text/html" id="tmpl-mpl-box-design-template">
<#
	if( typeof data == 'object' && data.length > 0 ){
		
		data.forEach( function( item ){
			
	        if( typeof item.attributes != 'object' )
	        	item.attributes = {};
	        if( item.tag == 'a' && item.attributes.href == undefined )
	        	item.attributes.href = '';
	        
	        var classes = '';	
	        if( item.tag == 'icon' || item.tag == 'text' || item.tag == 'image' ){
	        	classes += ' mpl-box-elm';
			}else if( item.tag == 'clumn' ){
				var ncl = 'one-one';
				if( item.attributes.class !== undefined ){
					['one-one','one-second','one-third','two-third'].forEach(function(cl){
						if( item.attributes.class.indexOf( cl ) > -1 )
							ncl = cl;
					});
				}
				classes += ' mpl-column-'+ncl;
			}
			
			
	        if( item.attributes.cols != undefined )
	        	classes += ' mpl-column-'+item.attributes.cols;
	        	
#>
			<div class="mpl-box mpl-box-{{item.tag}}{{classes}}" data-tag="{{item.tag}}" data-attributes='{{JSON.stringify(item.attributes)}}'>
		        <ul class="mb-header">
			        <li class="mb-toggle" data-action="toggle"><i class="mb-toggle fa-caret-down"></i></li>
			        <li class="mb-tag">{{item.tag}}</li>
			        <# if( item.attributes.id != undefined && item.attributes.id != '' ){ #>
			        	<li class="mb-id">Id: <span>{{item.attributes.id}}</span></li>
			        <# } if( item.attributes.class != undefined && item.attributes.class != '' ){ #>
			        	<li class="mb-class">
			        		Class: <span title="{{item.attributes.class}}">{{item.attributes.class.substr(0,30)}}..</span>
			        	</li>
			        <# } if( item.attributes.href != '' && item.attributes.href != undefined ){ #>
			        	<li class="mb-href">
			        		Href: <span title="{{item.attributes.href}}">{{item.attributes.href.substr(0,30)}}..</span>
			        	</li>
			        <# } #>
			        <li class="mb-funcs">
			        	<ul>
					        <li title="<?php _e('Remove', 'mageewp-page-layout'); ?>" class="mb-remove mb-func" data-action="remove">
					        	<i class="sl-close"></i>
					        </li>
					        <# if( item.tag == 'text' ){ #>
					        <li  title="<?php _e('Edit with Editor', 'mageewp-page-layout'); ?>"class="mb-edit mb-func" data-action="editor">
					        	<i class="sl-pencil"></i>
					        </li>
					        <# }else{ #>
					        <li  title="<?php _e('Settings', 'mageewp-page-layout'); ?>"class="mb-edit mb-func" data-action="settings">
					        	<i class="icon-content-setting"></i>
					        </li>
					        <# } #>
					        <li title="<?php _e('Double', 'mageewp-page-layout'); ?>" class="mb-double mb-func" data-action="double">
					        	<i class="icon-double"></i>
					        </li>
					        <# if( item.tag != 'div' ){ #>
					        <li title="<?php _e('Add Node', 'mageewp-page-layout'); ?>" class="mb-add mb-func" data-action="add" data-pos="inner"><i class="sl-plus"></i></li>
					        <# }else{ #>
					        <li title="<?php _e('Columns', 'mageewp-page-layout'); ?>" class="mb-columns mb-func" data-action="columns"><i class="sl-list"></i></li>    
							<# } #>
						</ul>
				    </li>
		        </ul>
		        <div class="mpl-box-body"><# 
			        
			        var empcol = false;
			        
		        	if( item.tag == 'div' ){
			        	if( item.children == undefined )
				        		empcol = true;
			        	else if( item.children.length == 0 )
				        		empcol = true;
				        else if( item.children[0].tag != 'column' )
				        	empcol = true;
			        }
			        
			        if( empcol == true ){
				        
				       #>{{{mpl.template( 'box-design', [{ tag: 'column', attributes: { cols:'one-one' }, children: item.children }]
				       	)}}}<# 
				        
			        }else{
			        
			        	
				        if( empcol == true ){
					        #><div data-cols="one-one" class="mpl-box-column one-one"><#
				        }	


				        if( item.tag == 'text' ){
					        if( item.content == undefined )
					        	item.content = 'Sample Text';
					        #>
								<div class="mpl-box-inner-text" contenteditable="true">{{{item.content}}}</div>
						    <#
					    }else if( item.tag == 'image' ){
						    if( item.attributes.src == undefined )
						    	item.attributes.src = mpl_plugin_url+'/assets/images/get_start.jpg';
					        #>
								<img data-action="select-image" src="{{item.attributes.src}}" />
						    <#
					    }else if( item.tag == 'icon' ){
						    if( item.attributes.class == undefined )
						    	item.attributes.class = 'fa-leaf';
					        #>
							<span data-action="icon-picker"><i class="{{item.attributes.class}}"></i></span>
						    <#
					    }else{
				        
					       					        	
					        #>{{{mpl.template( 'box-design', item.children )}}}<#
				        
				        }
				        
				        #><div class="mpl-box mb-helper">
					        <a href="#" data-action="add" data-pos="inner">
						        <i class="sl-plus"></i> 
						        <?php _e('Add Node', 'mageewp-page-layout'); ?>
						    </a>
					    </div>
				    
				    <# }/*EndIf*/ #>
				    
		        </div>
		    </div>
		    
		<#
		
		});
	}	
#>
</script>

<script type="text/html" id="tmpl-mpl-param-group-template">

	<div class="mpl-group-row">
		<div class="mpl-group-controls">
			<ul>
				<li class="mpl-collapse" data-action="collapse" title="<?php _e('expand / collapse', 'mageewp-page-layout' ); ?>">
					<i class="icon-expand1" data-action="collapse"></i>
				</li>
				<li class="counter"> #1 </li>
				<li class="delete" data-action="delete" title="<?php _e('Delete this section', 'mageewp-page-layout' ); ?>">
					<i data-action="delete" class="sl-close"></i>
				</li>

				<li class="double" data-action="double" title="<?php _e('Double this section', 'mageewp-page-layout' ); ?>">
					<i class="icon-double" data-action="double"></i>
				</li>			
			</ul>
		</div>
		<div class="mpl-group-body"></div>
	</div>

</script>

<script type="text/html" id="tmpl-mpl-param-microwidgets-template">
	<div class="mpl-widgets-row">
		<div class="mpl-widgets-controls">
			<ul>
				<li class="mpl-collapse" data-action="collapse" title="<?php _e('expand / collapse', 'mageewp-page-layout' ); ?>">
					<i class="icon-expand1" data-action="collapse"></i>
				</li>
				<li class="counter"> #1 </li>
				<li class="delete" data-action="delete" title="<?php _e('Delete this MicroWidgets', 'mageewp-page-layout' ); ?>">
					<i data-action="delete" class="sl-close"></i>
				</li>
			</ul>
		</div>
		<div class="mpl-widgets-body"></div>
	</div>
</script>

<script type="text/html" id="tmpl-mpl-param-radiotabs-template">
	<div class="mpl-radiotabs-row">
		<div class="mpl-radiotabs-body"></div>
	</div>
</script>

<script type="text/html" id="tmpl-mpl-param-mytabs-template">
	<div class="mpl-group-row">
		<div class="mpl-group-body"></div>
	</div>
</script>

<script type="text/html" id="tmpl-mpl-param-panel-template">
	<div class="mpl-group-row">
		<div class="mpl-group-body"></div>
	</div>
</script>

<script type="text/html" id="tmpl-mpl-wp-widgets-element-template">
<ul class="mpl-wp-widgets-ul mpl-components-list mpl-wp-widgets-pop">
	<li data-category="wp_widgets" data-name="mpl_wp_sidebar" class="mpl-element-item" title="<?php _e('Display WordPress sidebar', 'mageewp-page-layout'); ?>">
		<div>
			<i class="cpicon mpl-icon-sidebar"></i>
			<span class="cpdes">
				<strong><?php _e('WordPress SideBar', 'mageewp-page-layout'); ?></strong>
			</span>
		</div>
	</li>
	<#
	mpl.widgets.find('>div.widget').each(function(){
		var tit = jQuery(this).find('.widget-title').text(),
			des = jQuery(this).find('.widget-description').html(),
			base = '{"'+jQuery(this).find('input[name="id_base"]').val()+'":{}}';
			
#>	
		<li class="mpl-element-item" data-data="{{mpl.tools.base64.encode(base)}}" data-category="wp_widgets" data-name="mpl_wp_widget" title="{{des}}">
			<div>
				<span class="cpicon mpl-icon-wordpress"></span>
				<span class="cpdes">
					<strong>{{tit}}</strong>
					<i>{{des}}</i>
				</span>
			</div>
		</li>
<#	
	});
#>
</ul>
<#
	data.callback = function( wrp, e ){
		wrp.find( 'li' ).on( 'click', e.data.items );
	}
#>
</script>

