<?php

if(!defined('MPL_FILE')){
	header('HTTP/1.0 403 Forbidden');
	exit;
}

$mpl = MageewpPageLayout::globe();

//Cache

foreach(

	array(
		'text' => 'mpl_param_type_text',
		'number' => 'mpl_param_type_number',
		'hidden' => 'mpl_param_type_hidden',
		'textarea' => 'mpl_param_type_textarea_raw_html',
		'custom' => 'mpl_param_type_textarea_custom',
		'select' => 'mpl_param_type_select',
		'dropdown' => 'mpl_param_type_select',
		'textarea_html' => 'mpl_param_type_textarea_html',
		'editor' => 'mpl_param_type_editor',
		'multiple' => 'mpl_param_type_multiple',
		'checkbox' => 'mpl_param_type_checkbox',
		'radio' => 'mpl_param_type_radio',
		'radio_image' => 'mpl_param_type_radio_image',
		'toggle' => 'mpl_param_type_toggle',
		'attach_media' => 'mpl_param_type_attach_media',
		'attach_image' => 'mpl_param_type_attach_image',
		'attach_image_url' => 'mpl_param_type_attach_image_url',
		'attach_images' => 'mpl_param_type_attach_images',
		'color_picker' => 'mpl_param_type_color_picker',
		'icon_picker' => 'mpl_param_type_icon_picker',
		'date_picker' => 'mpl_param_type_date_picker',
		'mpl_box' => 'mpl_param_type_mpl_box',
		'wp_widget' => 'mpl_param_type_wp_widget',
		'css_box_tbtl' => 'mpl_param_type_css_box_tbtl',
		'css_box_border' => 'mpl_param_type_css_box_border',
		'group' => 'mpl_param_type_group',
		'css' => 'mpl_param_type_css',
		'select_group' => 'mpl_param_type_select_group',
		'css_border' => 'mpl_param_type_css_box_border',
		'corners' => 'mpl_param_type_corners',
		'css_background' => 'mpl_param_type_css_background',
		'css_video_background' => 'mpl_param_type_css_video_background',
		'link' => 'mpl_param_type_link',
		'autocomplete' => 'mpl_param_type_autocomplete',
		'number_slider' => 'mpl_param_type_number_slider',
		'random' => 'mpl_param_type_random',
		'css_family' => 'mpl_param_type_css_family',
		'animate' => 'mpl_param_type_animate',
		'undefined' => 'mpl_param_type_undefined',
		'microwidgets' => 'mpl_param_type_microwidgets',
		'radiotabs' => 'mpl_param_type_radiotabs',
		'mytabs' => 'mpl_param_type_mytabs',
		'panel' => 'mpl_param_type_panel',
	) as $name => $func ){

	$mpl->add_param_type_cache( $name, $func );
	
}

// Nocache

foreach(

	array(
		'post_taxonomy' => 'mpl_param_type_post_taxonomy',
		'wp_sidebars' => 'mpl_param_type_wp_sidebars',
	) as $name => $func ){

	$mpl->add_param_type( $name, $func );
	
}

function mpl_param_type_text(){
	echo '<input name="{{data.name}}" class="mpl-param" value="{{data.value}}" type="text" />';
}

function mpl_param_type_number(){
?>
	<input value="{{data.value.replace(/[^0-9\.]/g,'')}}" type="number" />
	<input name="{{data.name}}" class="mpl-param" value="{{data.value}}" type="hidden" />
	<#
		if( data.options !== undefined && data.options.units !== undefined ){
			var unit = data.value.replace(/[0-9\.]/g,'');
			if( unit === '' )
				unit =  data.options.units[0];
	#>
		<ul>
			<#
				for( var i=0; i<data.options.units.length; i++ ){
					#><li<# if( unit == data.options.units[i] ){ #> class="active"<# } #>>{{data.options.units[i]}}</li><#
				}
			#>
		</ul>
	<#		
		}
	#>
<#
	data.callback = mpl.ui.callbacks.number;
#>	
<?php
}

function mpl_param_type_hidden(){
	echo '<input name="{{data.name}}" class="mpl-param" value="{{data.value}}" type="hidden" />';
}

function mpl_param_type_textarea_raw_html(){
?><#
	if( data.value === undefined )
		var value = '';
	else var value = data.value;
#>
<textarea name="{{data.name}}" cols="46" rows="8" data-encode="base64" class="mpl-param mpl-row-area">{{mpl.tools.base64.decode( value.replace(/(?:\r\n|\r|\n)/g,'') )}}</textarea>
<?php
}

function mpl_param_type_textarea_custom(){
?><#
	if( data.value === undefined )
		var value = '';
	else var value = data.value;
#>
<textarea name="{{data.name}}" cols="46" rows="8" class="mpl-param mpl-row-area">{{value}}</textarea>
<?php
}

function mpl_param_type_select(){
?>
	<select class="mpl-param" name="{{data.name}}">
		<# if( data.options ){
			for( var n in data.options ){
				if( typeof data.options[n] == 'array' ||  typeof data.options[n] == 'object' ){
				#><optgroup label="{{n}}"><#
					for( var m in data.options[n] ){
						#><option<#
							if( m == data.value ){ #> selected<# }
							#> value="{{m}}">{{data.options[n][m]}}</option><#
					}
				#></optgroup><#

				}else{

		#><option<#
					if( n == data.value ){ #> selected<# }
				#> value="{{n}}">{{data.options[n]}}</option><#
				}
			}
		} #>
	</select>
<?php
}

function mpl_param_type_textarea_html(){
?>
	<# 
	
	if( data.name == 'content' ){
		
	var eid = parseInt( Math.random()*100000 ); #>

	<div class="mpl-textarea_html-field-wrp">
		<div class="mpl-editor-wrapper">
            <div id="wp-mpl-content-{{eid}}-wrap" class="wp-core-ui wp-editor-wrap tmce-active">
                <div id="wp-mpl-content-{{eid}}-editor-tools" class="wp-editor-tools hide-if-no-js">
                    <div id="wp-mpl-content-{{eid}}-media-buttons" class="wp-media-buttons">
                        <button type="button" class="button mpl-insert-media" data-editor="mpl-content-{{eid}}">
                        	<i class="sl-cloud-upload"></i> <?php _e('Insert Media', 'mageewp-page-layout'); ?>
                        </button>
                    </div>
                    <i class="mpl-edtip"><?php _e('Press shift+enter to break new line', 'mageewp-page-layout'); ?></i>
                    <div class="wp-editor-tabs">
                        <button type="button" class="wp-switch-editor switch-tmce" data-wp-editor-id="mpl-content-{{eid}}"><?php _e('Visual', 'mageewp-page-layout'); ?></button>
                        <button type="button" class="wp-switch-editor switch-html" data-wp-editor-id="mpl-content-{{eid}}"><?php _e('Text', 'mageewp-page-layout'); ?></button>
                    </div>
                </div>
                <div id="wp-mpl-content-{{eid}}-editor-container" class="wp-editor-container">
                    <div id="qt_mpl-content-{{eid}}_toolbar" class="quicktags-toolbar"></div>
                    <textarea class="wp-editor-area mpl-param" rows="10" autocomplete="off" width="100%" name="{{data.name}}" id="mpl-content-{{eid}}">{{data.value}}</textarea>
                </div>
            </div>
        </div>
	</div>
	<#
		data.callback = function( wrp, $ ){
			
			mpl.tools.editor.init( $('#mpl-content-'+eid) );

			var pop = wrp.closest('.mpl-params-popup'), model = pop.data('model');
			
			if( mpl.storage[model] !== undefined && mpl.maps[mpl.storage[model].name] !== undefined && mpl.maps[mpl.storage[model].name].is_container !== true ){
				wrp.html('<i style="color:red"><?php _e('Editor Error: This field type requires shortcode type is_container.', 'mageewp-page-layout'); ?></i>');
				return;
			}
			
			mpl.tools.popup.callback( pop, { 
				before_callback : function( pop ){
					pop.find('.mpl-textarea_html-field-wrp').each(function(){
						if( $(this).find('.wp-editor-wrap').hasClass('tmce-active') ){
							var txt = $(this).find('textarea.mpl-param');
							txt.val( switchEditors.wpautop( tinyMCE.get( txt.attr('id') ).getContent() ) );
						}
					});
				}
			}, 'field-column-text-callback' );

			wrp.find('.mpl-insert-media').on('click', function( atts ){
			
				mpl.tools.editor.insert( window.wpActiveEditor ,wp.media.string.image( atts ) );

			}, mpl.tools.media.opens );

		}
		
	}else{
		#><i style="color:red"><?php _e('Editor Error: This field type requires name is "content", you set the name is ', 'mageewp-page-layout'); ?>"{{data.name}}"</i><#
	}
	#>

<?php
}

function mpl_param_type_editor(){
?>
	<# 
	
		var eid = parseInt( Math.random()*100000 ), value = '';
		if( data.value !== undefined )
			value = data.value;
		if( value !== '' )
			value = mpl.tools.base64.decode(value.replace(/(?:\r\n|\r|\n)/g,'')).replace(/\%SITE\_URL\%/g,mpl_site_url);
	#>

	<div class="mpl-textarea_html-field-wrp">
		<div class="mpl-editor-wrapper">
            <div id="wp-mpl-content-{{eid}}-wrap" class="wp-core-ui wp-editor-wrap">
                <div id="wp-mpl-content-{{eid}}-editor-tools" class="wp-editor-tools hide-if-no-js">
                    <div id="wp-mpl-content-{{eid}}-media-buttons" class="wp-media-buttons">
                        <button type="button" class="button mpl-insert-media" data-editor="mpl-content-{{eid}}">
                        	<i class="sl-cloud-upload"></i> <?php _e('Insert Media', 'mageewp-page-layout'); ?>
                        </button>
                    </div>
                    <i class="mpl-edtip"><?php _e('Press shift+enter to break new line', 'mageewp-page-layout'); ?></i>
                    <div class="wp-editor-tabs">
                        <button type="button" class="wp-switch-editor switch-tmce" data-wp-editor-id="mpl-content-{{eid}}"><?php _e('Visual', 'mageewp-page-layout'); ?></button>
                        <button type="button" class="wp-switch-editor switch-html" data-wp-editor-id="mpl-content-{{eid}}"><?php _e('Text', 'mageewp-page-layout'); ?></button>
                    </div>
                </div>
                <div id="wp-mpl-content-{{eid}}-editor-container" class="wp-editor-container">
                    <div id="qt_mpl-content-{{eid}}_toolbar" class="quicktags-toolbar">
	                  <?php _e('To optimize performance the editor is not activated automatically, Click to active.', 'mageewp-page-layout'); ?>
                    </div>
                    <textarea class="wp-editor-area mpl-param" data-encode="base64" rows="10" autocomplete="off" width="100%" name="{{data.name}}" id="mpl-content-{{eid}}">{{value}}</textarea>
                </div>
            </div>
        </div>
	</div>
	
	<#
		data.callback = function( wrp, $ ){
			
			wrp.on('click', eid, function(e){
				mpl.tools.editor.init( $('#mpl-content-'+e.data) );
				$(this).off('click');
			});

			var pop = wrp.closest('.mpl-params-popup');
			mpl.tools.popup.callback( pop, { 
				before_callback : function( pop ){

					pop.find('.wp-editor-wrap').each(function(){
						
						if( $(this).data('loaded') !== true )
							$(this).data({'loaded': true});
						else return;
						
						var txt = $(this).find('textarea.mpl-param');
						if( $(this).hasClass('tmce-active') ){
							var id = txt.get(0).id, 
								content = switchEditors.wpautop( tinyMCE.get( id ).getContent() ), 
								rex = new RegExp( mpl_site_url, "g");
							content = content.replace( rex, '%SITE_URL%' );
							txt.val( content );
						}
					});
	
				}
			}, 'field-editor-callback' );

			wrp.find('.mpl-insert-media').on('click', function( atts ){
			
				mpl.tools.editor.insert( window.wpActiveEditor ,wp.media.string.image( atts ) );

			}, mpl.tools.media.opens );

		}
	#>

<?php
}

function mpl_param_type_multiple(){
?>
<#
	var value = '';
	if( data.value !== undefined )
		value = data.value;
#>
	<div mpl-multiple-field-wrp>
		<select multiple>
			<# if( data.options ){
				var vals = value.split(',');
				for( var n in data.options ){
					if( typeof data.options[n] == 'array' ||  typeof data.options[n] == 'object' ){
					#><optgroup label="{{n}}"><#
						for( var m in data.options[n] ){
							#><option<#
								if( vals.indexOf( m ) > -1 ){ #> selected<# }
								#> value="{{m}}">{{data.options[n][m]}}</option><#
						}
					#></optgroup><#

					}else{

			#><option<#
						if( vals.indexOf( n ) > -1 ){ #> selected<# }
					#> value="{{n}}">{{data.options[n]}}</option><#
					}
				}
			} #>
		</select>
		<input type="hidden" name="{{data.name}}" class="mpl-param mpl-empty-param" value="{{data.value}}" />
		<a href="#" class="clear-selected">
			<i class="sl-close"></i> <?php _e('Remove Selection', 'mageewp-page-layout'); ?>
		</a>
	</div>
	<#
		data.callback = function( el ){
			el.find('select').on( 'change', el, function(e){
				e.data.find('input.mpl-param').val( jQuery(this).val() );
			});
			el.find('.clear-selected').on( 'click', el, function(e){
				e.data.find('select option:selected').removeAttr('selected');
				e.data.find('input.mpl-param').val('');
				e.preventDefault();
			});
		}
	#>
<?php
}

function mpl_param_type_checkbox(){
?>
<#
	var value = '';
	if( data.value !== undefined )
		value = data.value;
#>
	<# if( data.options ){
		var vals = value.split(','), rid;
		for( var n in data.options ){
			rid = parseInt(Math.random()*100000);
			#><input type="checkbox" id="mpl-radio-{{data.name}}-{{rid}}" class="mpl-param" name="{{data.name}}" <#
				if( vals.indexOf( n ) > -1 ){ #> checked<# }
			#> value="{{n}}" /> <label class="rbtn" for="mpl-radio-{{data.name}}-{{rid}}">{{data.options[n]}}</label>
		<# }
	} #>
	<input type="checkbox" checked class="mpl-param mpl-empty-param" value="" name="{{data.name}}" style="display:none;" />
<?php
}

function mpl_param_type_radio(){
?>
	<div class="mpl-radio-field-wrp">
		<# if( data.options ){
				var rid;
			for( var n in data.options ){
				rid = parseInt(Math.random()*100000);
				#><input type="radio" id="mpl-radio-{{data.name}}-{{rid}}" class="mpl-param" name="{{data.name}}" <#
					if( n == data.value ){ #> checked<# }
				#> value="{{n}}" /> <label class="rbtn" for="mpl-radio-{{data.name}}-{{rid}}">{{data.options[n]}}</label>
			<# } #>
			<a href="#" class="clear-selected">
				<?php _e('Remove Selection', 'mageewp-page-layout'); ?>
			</a>
		<# } #><input type="radio" class="mpl-param empty-value mpl-empty-param" value="" name="{{data.name}}" style="display:none;" />
	</div>
	<#
		data.callback = function( el ){
			el.find('.clear-selected').on( 'click', el, function(e){
				e.data.find('input.mpl-param.empty-value').attr({'checked':true});
				e.preventDefault();
			});
		}
	#>
<?php
}

function mpl_param_type_radio_image(){
?>
	<div class="mpl-radio-image-field-wrp">
		<# if( data.options ){
			#>
			<div class="mpl-radio-image-field-body">
				<# 
					var rid;
					for( var n in data.options ){
						rid = parseInt(Math.random()*100000);
                        if( n.indexOf('pro_') <= -1){
					#><input type="radio" id="mpl-radio-{{data.name}}-{{rid}}" class="mpl-param" name="{{data.name}}" <#
						if( n == data.value ){ #> checked<# }
					#> value="{{n}}" /> <# } #>
					<# if (data.sprite === 'true') { 
						#>
						<label class="rbtn {{data.options[n]}}" <# if(n.indexOf('pro_') > -1){ #> data-support="pro" <# } #> for="mpl-radio-{{data.name}}-{{rid}}"></label>
					<# } else { 
						#>
						<label class="rbtn" <# if(n.indexOf('pro_') > -1){ #> data-support="pro" <# } #> for="mpl-radio-{{data.name}}-{{rid}}"><img src="{{data.options[n]}}" /></label>
					<# } #>
				<# } #>
				<img class="large-view" src="{{data.options[n]}}" />
			</div>
     		<# } #><input type="radio" class="mpl-param empty-value mpl-empty-param" value="" name="{{data.name}}" style="display:none;" />
	</div>
	<#
		data.callback = mpl.ui.callbacks.radio_image;
	#>
<?php
}

function mpl_param_type_select_group(){
?>
	<div class="mpl-select_group-field-wrp">
		<div class="buttons">
		<# if( data.options !== undefined && data.options.buttons !== undefined ){
			
			var type = 'hidden';
			if( data.options.custom === true ){
				type = 'text';
			}
				
			for( var n in data.options.buttons ){
				#><button data-value="{{n}}"<#
					if( n == data.value ){ #> class="active"<# }
				#>>{{{data.options.buttons[n]}}}<#
					if( data.options.tooltip === true && n !== '' ){
						#><span class="tooltip">{{n.replace(/\-/g,' ')}}</span><#
					}
				#></button>
			<# } #>
		<# } #>
		</div>
		<input type="{{type}}" placeholder="<?php _e('Custom', 'mageewp-page-layout'); ?>" class="mpl-param" value="{{data.value}}" name="{{data.name}}" />
	</div>
	<#
		data.callback = mpl.ui.callbacks.select_group;
	#>
<?php
}

function mpl_param_type_toggle(){
	
?>	<#
		if( data.options === undefined || data.options.label === undefined )
			data.options = { 'label': 'yes|no' };
		data.options.label = data.options.label.split('|');
		
		if( data.value == 'yes' )
			checked = 'checked';
		else checked = '';
		
	#>
	<div class="mpl-toggle-field-wrp">
		<div class="switch">
			<input type="checkbox" {{checked}} value="yes" name="{{data.name}}" class="toggle-button mpl-param">
			<span class="toggle-label" data-on="{{data.options.label[0]}}" data-off="{{data.options.label[1]}}"></span>
			<span class="toggle-handle"></span>
			<input type="checkbox" checked class="mpl-param mpl-hidden mpl-empty-param" value="" name="{{data.name}}" />
		</div>
	</div>
<?php
}

function mpl_param_type_attach_media(){
?>
<#
	var value = '';
	if( data.value !== undefined )
		value = data.value;
#>
	<div class="mpl-attach-field-wrp">
		<input name="{{data.name}}" class="mpl-param" value="{{value}}" type="hidden" />
		<div class="media-wrp">
			<div class="filename"><#
				if( value != '' ){
					value = value.split('/');
					#>{{value[value.length-1]}}<#
				}else{
					#>empty<#
				}
			#></div>
			<i class="sl-close" title="<?php _e('Delete this mdia', 'mageewp-page-layout'); ?>"></i>		</div>
		<div class="clear"></div>
		<a class="button media button-primary">
			<i class="sl-cloud-upload"></i> <?php _e('Browse Media', 'mageewp-page-layout'); ?>
		</a>
	</div>
	<#
		data.callback = function( el, $ ){

			el.find('.media').on( 'click', { callback: function( atts ){

				var wrp = $(this.el).closest('.mpl-attach-field-wrp'), url = atts.url;

				wrp.find('input.mpl-param').val(url).change();
				
				url = url.split('/');
				
				wrp.find('.filename').html(url[url.length-1]);

			}, atts : { frame: 'select' } }, mpl.tools.media.open );

			el.find('div.media-wrp .sl-close').on( 'click', el, function( e ){
				e.data.find('input.mpl-param').val('');
				$(this).closest('div.media-wrp').find('.filename').html('empty');
			});

			el.find('div.media-wrp .filename').on( 'click', el, function( e ){
				el.find('.media').trigger('click');
			});



		}
	#>
<?php
}

function mpl_param_type_attach_image(){
?>
	<# if( data.value ==='undefined' )
	    data.value = '';
	 #>
	<div class="mpl-attach-field-wrp">
		<input name="{{data.name}}" class="mpl-param" value="{{data.value}}" type="hidden" />
		<# if( data.value != '' ){ #>
		<div class="img-wrp">
			<img src="{{mpl_site_url}}/wp-admin/admin-ajax.php?action=mpl_get_thumbn&id={{data.value}}" alt="" />
			<i class="sl-close" title="<?php _e('Delete this image', 'mageewp-page-layout'); ?>"></i>
		</div>
		<# } #>
		<div class="clear"></div>
		<a class="button media button-primary">
			<i class="sl-cloud-upload"></i> <?php _e('Browse Image', 'mageewp-page-layout'); ?>
		</a>
	</div>
	
	<# data.callback = mpl.ui.callbacks.upload_image; #>
	
<?php
}

function mpl_param_type_attach_image_url(){
?>

	<div class="mpl-attach-field-wrp">
		<input name="{{data.name}}" class="mpl-param" value="{{data.value}}" data-mpl-param="{{data.name}}" type="hidden" />
		<# if( data.value != '' ){ #>
		<div class="img-wrp">
			<img src="{{data.value}}" alt="" />
			<i class="sl-close" title="<?php _e('Delete this image', 'mageewp-page-layout'); ?>"></i>
			<div class="img-sizes"></div>
		</div>
		<# } #>
		<div class="clear"></div>
		<a class="button media button-primary">
			<i class="sl-cloud-upload"></i> <?php _e('Select Image', 'mageewp-page-layout'); ?>
		</a>
	</div>
	
	<# data.callback = mpl.ui.callbacks.upload_image_url; #>
	
<?php
}


function mpl_param_type_attach_images(){
?>
	<div class="mpl-attach-field-wrp">
		<input name="{{data.name}}" class="mpl-param" value="{{data.value}}" type="hidden" />
		<#
			if( data.value !== undefined && data.value != '' ){
				data.value = data.value.split(',');
				for( var n in data.value ){
					#><div data-id="{{data.value[n]}}" class="img-wrp"><img title="<?php _e('Drag image to sort', 'mageewp-page-layout'); ?>" src="{{mpl_site_url}}/wp-admin/admin-ajax.php?action=mpl_get_thumbn&id={{data.value[n]}}&size=thumbnail" alt="" /><i class="sl-close"></i></div><#
				}
		 #>
		<# } #>
		<div class="clear"></div>
		<a class="button media button-primary">
			<i title="<?php _e('Delete this image', 'mageewp-page-layout'); ?>" class="sl-cloud-upload"></i> <?php _e('Browse Images', 'mageewp-page-layout'); ?>
		</a>
	</div>

	<# data.callback = mpl.ui.callbacks.upload_images; #>

<?php
}

function mpl_param_type_color_picker(){
?>
	<input name="{{data.name}}" value="{{data.value}}" placeholder="Select color" class="mpl-param" type="search" />
	<#
		data.callback = function( el, $ ){
			el.find('input').each(function(){
				this.color = new jscolor.color(this, {});
			});
	    }
	#>
<?php
}

function mpl_param_type_icon_picker(){

?>	<# if( data.value == undefined || data.value == '' )data.value=''; #>
	<div class="icons-preview">
		<i class="{{data.value}}"></i>
	</div>
	<input name="{{data.name}}" value="{{data.value}}" placeholder="Click to select icon" class="mpl-param mpl-param-icons" type="text" />
	<#
		data.callback = mpl.ui.callbacks.icon_picker;
	#>
<?php
}

function mpl_param_type_date_picker(){
?>

	<input name="{{data.name}}" class="mpl-param" value="{{data.value}}" type="text" />
	<#
		data.callback = function( wrp, $ ){
			var d = new Pikaday(
		    {
		        field: wrp.find('.mpl-param').get(0),
		        firstDay: 1,
				format: 'yyyy/mm/dd',
		        minDate: new Date(2016, 0, 1),
		        maxDate: new Date(2020, 12, 31),
		        yearRange: [2000,2020]
		    });
		}
	#>

<?php
}

function mpl_param_type_mpl_box(){

?>

	<textarea name="data" class="mpl-param mpl-box-area forceHide">{{data.value}}</textarea>
	<button class="button html-code" data-action="html-code">
		<i class="sl-doc"></i> <?php _e('HTML Code', 'mageewp-page-layout'); ?>
	</button>
	<button class="button css-code" data-action="css-code">
		<i class="icon-content-setting"></i> <?php _e('CSS Code', 'mageewp-page-layout'); ?>
	</button>
	<button class="button align-center add-top" data-action="add" data-pos="top">
		<i class="sl-plus"></i>
	</button>
	<div class="mpl-box-render"></div>
	<button class="button align-center add-bottom" data-action="add" data-pos="bottom">
		<i class="sl-plus"></i>
	</button>
	<div class="mpl-box-trash">
		<a href="#" class="button forceHide" data-action="undo">
			<i class="icon-back"></i> Undo Delete(0)
		</a>
	</div>
<#

	data.callback = function( wrp, $ ){

		try{
			var data_obj = mpl.tools.base64.decode( data.value.replace(/(?:\r\n|\r|\n)/g,'') );
			data_obj = data_obj.replace( /\%SITE\_URL\%/g, mpl_site_url );
			data_obj = JSON.parse( data_obj );
		}catch(e){
			var data_obj = [{tag:'div',children:[{tag:'text', content:'There was an error with content structure.'}]}];
		}

		wrp.find('.mpl-box-render').eq(0).append( mpl.template( 'box-design', data_obj ) );

		var pop = mpl.get.popup( wrp );
		
		mpl.tools.popup.callback( pop, { before_callback : mpl.ui.mpl_box.renderBack }, 'field-mpl-box-callback' );
		pop.addClass('preventCancel');

		mpl.ui.mpl_box.sort();

		wrp.on( 'click', function( e ){

			if( e.target.tagName == 'I' )
				var el = $( e.target.parentNode );
			else var el = $( e.target );

			mpl.ui.mpl_box.actions( el, e );

		} );

	}

#>
<?php
}


function mpl_param_type_wp_widget(){

?><#

	try{
		var obj = JSON.parse( mpl.tools.base64.decode( data.value ) );
	}catch(e){
		return '<center><?php _e('There was an error with content structure.', 'mageewp-page-layout'); ?></center>';
	}
	var html = '';

	for( var n in obj ){

		mpl.widgets.find('input[name="id_base"]').each(function(){

			if( this.value == n ){

				html = jQuery(this).closest('div.widget').find('.widget-content').html();
				html = '<div class="mpl-widgets-container" data-name="'+n+'">'
					   +html.replace(/name="([^"]*)"/g,function(r,v){

							v = v.split('][');
							v = ( v[1] != undefined ) ? v[1] : v[0];
							v = v.replace(/\]/g,'').trim();
							var str = 'name="'+v+'"';

							if( obj[n][v] != undefined )
								str += ' data-value="'+mpl.tools.esc(obj[n][v])+'"';

							return str;

						})+'</div>';
			}
		});
	}

	#>{{{html}}}<#

	data.callback = mpl.ui.callbacks.wp_widgets;

#>
<?php
}


function mpl_param_type_css_box_tbtl(){
?>
	<#
		var imp = data.value.indexOf('!important');
		if( imp > -1 )
			imp = '!important';
		else imp = '';
		var val = data.value.replace('!important','').split(' ');
	#>
	<ul class="multi-fields-ul">
		<li>
			<input class="mpl-param" name="{{data.name}}-top" class="m-f-u-first" value="{{val[0]}}" type="text" /><br /> <strong>Top</strong>
		</li>
		<li>
			<input class="mpl-param" name="{{data.name}}-bottom" type="text" value="{{val[2]}}" /><br /> Bottom
		</li>
		<li>
			<input class="mpl-param" name="{{data.name}}-left" type="text" value="{{val[3]}}" /><br /> Left
		</li>
		<li>
			<input class="mpl-param" name="{{data.name}}-right" class="m-f-u-last" type="text" value="{{val[1]}}" /><br /> Right
		</li>
		<li class="m-f-u-li-link">
			<span><input <# if( val[0] == val[1] && val[1] == val[2] && val[2] == val[3] ){ #>checked<#} #> type="checkbox" /></span><br /> <i class="sl-link"></i>
		</li>
		<input type="hidden" class="mpl-param" name="{{data.name}}-important" value="{{imp}}" />
		<br />
		<div class="m-p-r-des"><?php _e('Click & hold the input, then move up or move down to change value', 'mageewp-page-layout'); ?></div>
	</ul>
	<#
		data.callback = function( el, $ ){
			el.find('input[type=text]').on( 'keyup', el, function( e ){
				if( e.data.find('input[type=checkbox]').get(0).checked == true ){
					var cur = this;
					e.data.find('input[type=text]').each(function(){
						if( this != cur )
							this.value = cur.value;
					});
				}
			}).on( 'mousedown', function(e){
				
				if( e.which !== undefined && e.which !== 1 )
					return false;
					
				$(document).on( 'mouseup', function(){
					$(document).off( 'mousemove' ).off('mouseup');
					$('body').css({cursor:''});
				});
				
				var ext = this.value.replace(/[0-9\-]/g,'');
				if( ext === '' )
					ext = 'px';
				$(document).on( 'mousemove', { 
					el: this,
					cur: parseInt(this.value!==''?this.value:0),
					ext: ext,
					top: e.clientY
				}, function(e){
					var offset = e.clientY-e.data.top;
					e.data.el.value = (e.data.cur-offset)+e.data.ext;
					$(e.data.el).trigger('change');
				});
				
				$('body').css({cursor:'ns-resize'});
				
				$( window ).off('mouseup').on('mouseup', function(){
					$(document).off('mousemove');
					$(window).off('mouseup');
					$('html,body').removeClass('mpl_dragging noneuser');
				});
				
			});
			el.find('input[type=checkbox]').on( 'change', el, function( e ){
				if( this.checked == true ){
					e.data.find('input[type=text]').val( e.data.find('input[type=text]').get(0).value );
				}
			});
		}
	#>
<?php
}

function mpl_param_type_corners(){
?>
	<#
		var val = data.value.trim().split(' ');

		if( data.options === undefined )
			data.options = {};

	#>
	<input name="{{data.name}}" class="mpl-param" data-css-corners-value="" value="{{data.value}}" type="hidden" />
	
	<div class="mpl-corners-wrp">
		<# 
			var i=0, pos = ['top', 'right', 'bottom', 'left'], va = '';
			if( data.options ){
				for( var c in data.options ){
					
					if( val[i] !== undefined && val[i] != 'inherit' )
						va = val[i];
					else va = '';
				#>
					<div class="mpl-corners-{{pos[i]}} mpl-corners-pos">
						<input data-css-corners="{{c}}" name="{{c}}" value="{{va}}" type="text" />
					</div>
				<# 
				i++; 
				} 
			} 
		
		#>
		<div class="m-f-u-li-link<# if( val[0] == val[1] && val[2] == val[0] && val[3] == val[0] ){ #> active<# } #>">
			<span><i class="sl-link"></i></span>
		</div>
	</div>

	<# data.callback = mpl.ui.callbacks.corners; #>
<?php
}
function mpl_param_type_css_box_border(){
?>
	<#
		var imp = (data.value.indexOf('!important')>-1) ? '!important' : '';
	#>
	
	<div class="mpl-corners-wrp hidden">
		
		<div class="mpl-corners-top mpl-corners-pos">
			<button data-dir="top"></button>
		</div>
	
		<div class="mpl-corners-right mpl-corners-pos">
			<button data-dir="right"></button>
		</div>
	
		<div class="mpl-corners-bottom mpl-corners-pos">
			<button data-dir="bottom"></button>
		</div>
	
		<div class="mpl-corners-left mpl-corners-pos">
			<button data-dir="left"></button>
		</div>
				
		<div class="m-f-u-li-link">
			<span><i class="sl-link"></i></span>
		</div>
		
	</div>
	
	<input name="{{data.name}}" class="mpl-param" data-css-border="value" value="{{data.value}}" type="hidden" />
	
	<ul class="multi-fields-ul">
		<li>
			<input name="border-width" placeholder="Width" class="m-f-u-first" data-css-border="width" value="" type="text" />
		</li>
		<li>
			<span class="m-f-u-li-splect">
				<select name="border-style" data-css-border="style">
					<option value="none">- <?php _e('Style', 'mageewp-page-layout'); ?> -</option>
					<option value="hidden">hidden</option>
					<option value="dotted">dotted</option>
					<option value="dashed">dashed</option>
					<option value="solid">solid</option>
					<option value="double">double</option>
					<option value="groove">groove</option>
					<option value="ridge">ridge</option>
					<option value="inset">inset</option>
					<option value="outset">outset</option>
					<option value="initial">initial</option>
					<option value="inherit">inherit</option>
				</select>
			</span>
		</li>
		<li>
			<input type="text" name="border-color" placeholder="<?php _e('Select color', 'mageewp-page-layout'); ?>" data-css-border="color" value="" width="80" class="m-f-bb-color" />
		</li>
	</ul>
	<a href="#" class="css-border-advanced"><?php _e('Advanced setting borders', 'mageewp-page-layout'); ?></a>
	<#
		data.callback = mpl.ui.callbacks.css_border;
	#>
<?php
}

function mpl_param_type_group(){
?>
<input type="hidden" name="{{data.name}}[0]" class="mpl-param" />
<div class="mpl-group-rows {{data.options.disable_button}}"></div>
<#
	try{
		data.value = mpl.tools.base64.decode( data.value );
		data.value = data.value.replace( /\%SITE\_URL\%/g, mpl_site_url );
		data.value = JSON.parse( data.value );
		var values = {};
		for( var i in data.value ){
			if( typeof( data.value[i] ) == 'object' ){
				if( i.indexOf( data.name+'[' ) == -1 ){
					values[ data.name+'['+i+']' ] = {};
					for( var j in data.value[i] ){
						values[ data.name+'['+i+']['+j+']' ] = data.value[i][j];
					}
				}else values[ i ] = data.value[i];
			}
		}
	}catch(e){
		data.value = {'0':{}};
		var values = {};
	}

	data.callback = function( wrp, $, data ){
		
		var add_text;
		if( data.options === undefined || data.options.add_text === undefined )
			add_text = '<?php _e('Add new Item', 'mageewp-page-layout'); ?>';
		else add_text = data.options.add_text;
		
		wrp.data({ 'name' : data.name, 'params': data.params });

		for( var n in data.value ){
			if( typeof( data.value[n] ) == 'object' ){
				var params = mpl.params.fields.group.set_index( data.params, data.name, n );
				
				var grow = $( mpl.template( 'param-group' ) );
				wrp.find('.mpl-group-rows').append( grow );
				
				mpl.params.fields.render( grow.find('.mpl-group-body'), params, values );
			}

		}
       
      
		wrp.find('.mpl-group-rows').append( '<div class="mpl-group-controls mpl-add-group"><i class="sl-plus"></i> '+add_text+'</div>' );

		mpl.params.fields.group.callback( wrp );
		
	}

#>
<?php
}

function mpl_param_type_microwidgets() {
?>
<!-- <input type="hidden" name="{{data.name}}" class="mpl-param" /> -->
<div class="mpl-widgets-rows {{data.options.disable_button}}"></div>
<#
	try {
		data.value = mpl.tools.base64.decode( data.value );
		data.value = data.value.replace( /\%SITE\_URL\%/g, mpl_site_url );
		data.value = JSON.parse( data.value );
		var values = {};
		for ( var i in data.value ) {
			if ( typeof( data.value[i] ) == 'object' ) {
				if ( i.indexOf( data.name+'[' ) == -1 ) {
					values[ data.name+'['+i+']' ] = {};
					for ( var j in data.value[i] ) {
						values[ data.name+'['+i+']['+j+']' ] = data.value[i][j];
					}
				} else values[ i ] = data.value[i];
			}
		}
	} catch(e) {
		//data.value = {'0':{}};
		data.value = {};
		var values = {};
	}

	data.callback = function( wrp, $, data ) {
		var add_text;
		if ( data.options === undefined || data.options.add_text === undefined )
			add_text = '<?php _e('Add new Item', 'mageewp-page-layout'); ?>';
		else add_text = data.options.add_text;
		
		wrp.data({ 'name' : data.name, 'params': data.params });
		var rows = wrp.find('.mpl-widgets-rows');

		for ( var n in data.value ) {
			if ( typeof( data.value[n] ) == 'object' ) {
				var params = mpl.params.fields.microwidgets.set_index( data.params[n], data.name, n );

				var grow = $( mpl.template( 'param-microwidgets' ) );
				var ct = grow.find('li.counter');
				ct.html(n);
				rows.append( grow );
				mpl.params.fields.render( grow.find('.mpl-widgets-body'), params, values );
			}
		}
		rows.append( '<div class="mpl-widgets-controls mpl-add-widgets"><i class="sl-plus"></i> ' + add_text + '</div>' );
		mpl.params.fields.microwidgets.callback( wrp );
	}
#>
<?php
}

function mpl_param_type_radiotabs() {
?>
<input type="radio" name="{{data.name}}" class="mpl-param mpl-ns-param" value="" style="display:none;"/>
<div class="mpl-radiotabs-rows {{data.options.disable_button}}"><ul class="radiotabs-nav"></ul></div>
<#
	try {
		//data.value = mpl.tools.base64.decode( data.value );
		data.value = data.value;
		data.value = data.value.replace( /\%SITE\_URL\%/g, mpl_site_url );
		data.value = JSON.parse( data.value );
		var values = {};
		for ( var i in data.value ) {
			if ( typeof( data.value[i] ) == 'object' ) {
				if ( i.indexOf( data.name+'[' ) == -1 ) {
					values[ data.name+'['+i+']' ] = {};
					for ( var j in data.value[i] ) {
						if (typeof(data.value[i][j]) == 'object') 
							values[ data.name+'['+i+']['+j+']' ] = JSON.stringify(data.value[i][j]);
						else
							values[ data.name+'['+i+']['+j+']' ] = data.value[i][j];
					}
				} else values[ i ] = data.value[i];
			}
		}
	} catch(e) {
		data.value = {'0':{}};
		var values = {};
	}

	data.callback = function( wrp, $, data ) {
		wrp.data({ 'name' : data.name, 'params': data.params });
		var first_tab = '';
		for ( var n in data.params ) {
			var params = mpl.params.fields.radiotabs.set_index( data.params[n], data.name, n );

			//var slug = 'mpl-radiotabs-' + Math.abs(parseInt(Math.random() * 1000));
			var li = $('<li data-tab="' + n + '"><img src="' + data.options[n] + '"></li>');
			wrp.find('.mpl-radiotabs-rows ul').append(li);

			var radiotabs = $( mpl.template( 'param-radiotabs' ) );
			radiotabs.attr('data-tab', n);
			radiotabs.addClass('hidden');
			wrp.find('.mpl-radiotabs-rows').append( radiotabs );

			li.on('click', function() {
				var wrp1 = $(this).closest('.field-radiotabs');
				wrp1.find('.mpl-radiotabs-rows li').removeClass('active');
				$(this).addClass('active');
				var cls = $(this).data('tab');

				wrp1.find('.mpl-param').first().attr('value', cls);

				wrp1.find('div[data-tab] .mpl-param').addClass('mpl-ns-param');
				wrp1.find('div[data-tab="' + cls + '"] .mpl-param').removeClass('mpl-ns-param');

				wrp1.find('div[data-tab]').removeClass('active').addClass('hidden');
				wrp1.find('div[data-tab="' + cls + '"]').removeClass('hidden').addClass('active');
			});
			if (typeof( values[data.name + '[' + n + ']'] ) == 'object') {
				first_tab = n;
				mpl.params.fields.render( radiotabs.find('.mpl-radiotabs-body'), params, values );
				wrp.find('.mpl-radiotabs-rows li[data-tab="' + first_tab + '"]').trigger('click');
			}
			else {
				mpl.params.fields.render( radiotabs.find('.mpl-radiotabs-body'), params, {} );
			}
		}
		if (first_tab === '') {
			wrp.find('.mpl-radiotabs-rows li').first().trigger('click');
		}
		mpl.params.fields.radiotabs.callback( wrp );
	}
#>
<?php
}

function mpl_param_type_mytabs() {
?>
<div class="mpl-group-rows {{data.options.disable_button}}"><ul class="tabs-nav"></ul></div>
<#
	try {
		//data.value = mpl.tools.base64.decode( data.value );
		data.value = data.value;
		data.value = data.value.replace( /\%SITE\_URL\%/g, mpl_site_url );
		data.value = JSON.parse( data.value );
		var values = {};
		for ( var i in data.value ) {
			if ( typeof( data.value[i] ) == 'object' ) {
				if ( i.indexOf( data.name+'[' ) == -1 ) {
					values[ data.name+'['+i+']' ] = {};
					for ( var j in data.value[i] ) {
						if (typeof(data.value[i][j]) == 'object') 
							values[ data.name+'['+i+']['+j+']' ] = JSON.stringify(data.value[i][j]);
						else
							values[ data.name+'['+i+']['+j+']' ] = data.value[i][j];
					}
				} else values[ i ] = data.value[i];
			}
		}
	} catch(e) {
		data.value = {'0':{}};
		var values = {};
	}

	data.callback = function( wrp, $, data ) {
		wrp.data({ 'name' : data.name, 'params': data.params });
		for ( var n in data.params ) {
			var params = mpl.params.fields.mytabs.set_index( data.params[n], data.name, n );

			var slug = 'mpl-mytabs-' + Math.abs(parseInt(Math.random() * 1000));
			var li = $('<li data-tab="' + slug + '">' + data.options[n] + '</li>');
			wrp.find('.mpl-group-rows ul').append(li);

			var mytabs = $( mpl.template( 'param-mytabs' ) );
			mytabs.attr('data-tab', slug);
			mytabs.addClass('hidden');
			wrp.find('.mpl-group-rows').append( mytabs );

			li.on('click', function() {
				var wrp1 = $(this).closest('.field-mytabs');
				wrp1.find('.mpl-group-rows li').removeClass('active');
				$(this).addClass('active');
				var cls = $(this).data('tab');

				wrp1.find('div[data-tab]').removeClass('active').addClass('hidden');
				wrp1.find('div[data-tab="' + cls + '"]').removeClass('hidden').addClass('active');
			});
			if (typeof( values[data.name + '[' + n + ']'] ) == 'object') {
				mpl.params.fields.render( mytabs.find('.mpl-group-body'), params, values );
			}
			else {
				mpl.params.fields.render( mytabs.find('.mpl-group-body'), params, {} );
			}
		}
		wrp.find('.mpl-group-rows li').first().trigger('click');
		mpl.params.fields.mytabs.callback( wrp );
	}
#>
<?php
}

function mpl_param_type_panel() {
?>
<div class='mpl-panel-field-wrp'>
	<div class='mpl-panel-body'></div>
</div>
<#
	try {
		//data.value = mpl.tools.base64.decode( data.value );
		data.value = data.value;
		data.value = data.value.replace( /\%SITE\_URL\%/g, mpl_site_url );
		data.value = JSON.parse( data.value );
		var values = {};
		for ( var i in data.value ) {
			if ( typeof( data.value[i] ) == 'object' ) {
				if ( i.indexOf( data.name+'[' ) == -1 ) {
					values[ data.name + '[' + i + ']' ] = {};
					values[ data.name +'[' + i + ']' ] = JSON.stringify(data.value[i]);
				}
			} else values[data.name + '[' + i + ']'] = data.value[i];
		}
	} catch(e) {
		data.value = {'0':{}};
		var values = {};
	}

	data.callback = function( wrp, $, data ) {
		var params = [];
		var data_name = data.name;
        for (var i = 0; i < data.params.length; i++) {
            if (data.params[i]['type'] != 'panel') {
                params[params.length] = $().extend({}, data.params[i]);
                if (data.params[i]['name'].indexOf(data_name + '[') == -1)
                    params[params.length - 1]['name'] = data_name + '[' + data.params[i]['name'] + ']';
            }
        }		
		mpl.params.fields.render( wrp.find('.mpl-panel-body'), params, values );
	}
#>

<?php
}

function mpl_param_type_css(){
?>
<input type="hidden" name="{{data.name}}" class="mpl-param mpl-field-css-value" value="{{data.value}}" />
<div class="mpl-css-rows" style="min-height:500px"></div>
<# data.callback = mpl.ui.callbacks.css; #>
<?php
}

function mpl_param_type_link(){
?>
<#
	if( typeof data.value != 'undefined' && data.value != '' )
		var value = data.value.split('|');
	else value = ['','','','',''];
#>
	<input name="{{data.name}}" class="mpl-param" value="{{data.value}}" type="hidden" />
	<a class="button link button-primary">
		<i class="sl-link"></i> <?php _e( 'Add your link', 'mageewp-page-layout' ); ?>
	</a>
	<br />
	<span class="link-preview">
		<# if( value[0] !== undefined && value[0] != '' ){ #><strong>Link:</strong> {{value[0]}}<br /><# } #>
		<# if( value[1] !== undefined && value[1] != '' ){ #><# } #>
		<# if( value[2] !== undefined && value[2] != '' ){ #><strong>Target:</strong> {{value[2]}}<br /><# } #>
	</span>

<#

	data.callback = function( wrp, $ ){

		wrp.find('.button.link').on( 'click', wrp, function(e) {  


            wpLink.open();

            var value = e.data.find('.mpl-param').val();
            if( value != '' )
				value = value.split('|');
			else value = ['','','','',''];

            $('#wp-link-url').val( value[0] );
	        $('#wp-link-text').val( value[1] );
	        if( value[2] == '_blank' )
	        	$('#wp-link-target').attr({checked: true});

            if( $('#wp-link-update #mpl-link-submit').length == 0 ){
            	$('#wp-link-update').append('<input type="submit" value="Add Link to MPL" class="button button-primary" id="mpl-link-submit" name="wp-link-submit" style="display: none">');
				$('#wp-link-cancel, #wp-link-close').on( 'click', function(e) {
					$('#wp-link-submit').css({display: 'block'});
					$('#mpl-link-submit').css({display: 'none'});
			        wpLink.close();
			        e.preventDefault ? e.preventDefault() : e.returnValue = false;
			        e.stopPropagation();
			        return false;
			    });
            }

            $('#wp-link-submit').css({display: 'none'});
            $('#wp-link-text').parents(".wp-link-text-field").css({display: 'none'});
            
            $('#wp-link-update #mpl-link-submit').css({display: 'block'}).off('click').on( 'click', e.data, function(e) {

	            var url = $('#wp-link-url').val(),
	            	target = $('#wp-link-target').get(0).checked?'_blank':'';

				e.data.find('.mpl-param').val(url+'|'+''+'|'+target).change();

				var preview = '';
				if( url != '' )
					preview += '<strong>Link:</strong> '+url+'<br />';
				if( target != '' )
					preview += '<strong>Target:</strong> '+target+'<br />';

				e.data.find('.link-preview').html( preview );

				$('#wp-link-close').trigger('click');

	            wpLink.close();
	            e.preventDefault
	            return false;
	        });
            return false;
        });
	}

#>

<?php
}

function mpl_param_type_post_taxonomy(){

	$post_types = get_post_types( array(
			'public'   => true,
			'_builtin' => false
		),
		'names'
	);

	$post_types = array_merge( array( 'post' => 'post'), $post_types );

	foreach($post_types as $post_type){
		$taxonomy_objects = get_object_taxonomies( $post_type, 'objects' );
		$taxonomy = key( $taxonomy_objects );
		$args[ $post_type ] = mpl_get_terms( $taxonomy, 'slug' );
	}

	echo '<label>'.__( 'Select Content Type', 'mageewp-page-layout' ).': </label>';
	echo '<br />';
	echo '<select class="mpl-content-type">';
	foreach( $args as $k => $v ){
		echo '<option value="'.esc_attr($k).'">'.ucwords( str_replace(array('-','_'), array(' ', ' '), $k ) ).'</option>';
	}
	echo '</select>';
	echo '<div class="mpl-select-wrp">';
		echo '<select style="height: 150px" multiple class="mpl-taxonomies-select">';

		foreach( $args as $type => $arg ){

			echo '<option class="'.esc_attr($type).'-st" value="'.esc_attr($type).'" style="display:none;">'.esc_html($type).'</option>';

			foreach( $arg as $k => $v ){

				$k = $type.':'.str_replace( ':', '&#58;', $k );

				echo '<option class="'.esc_attr($type).' '.esc_attr($k).'" value="'.esc_attr($k).'" style="display:none;">'.esc_html($v).'</option>';

			}
		}

		echo '</select>';
		echo '<button class="button unselected" style="margin-top: 10px;">'.__('Remove selection', 'mageewp-page-layout').'</button>';
	echo '</div>';

?>
<# data.callback = mpl.ui.callbacks.taxonomy; #>
<?php
}

function mpl_param_type_autocomplete(){
	
?>
<div class="mpl_autocomplete_wrp">
	<input class="mpl-param" name="{{data.name}}" type="hidden" value="{{data.value}}" />
	<ul class="autcp-items"></ul>
	<input type="text" class="mpl-autp-enter" placeholder="<?php _e('Enter your word', 'mageewp-page-layout'); ?>..." />
	<div class="mpl-autp-suggestion mpl-free-scroll">
		<ul>
			<li><?php _e('Show up 120 relate posts', 'mageewp-page-layout'); ?></li>
		</ul>
	</div>
</div>
<# data.callback = mpl.ui.callbacks.autocomplete;	#>	
<?php	
}	

function mpl_param_type_number_slider(){

?>
<div class="mpl-number_slider-field-wrp">
    <div class="mpl_percent_slider"></div>
	<input type="text" class="mpl-param number_slider_field" name="{{data.name}}" value="{{data.value}}" />
</div>
<# data.callback = mpl.ui.callbacks.number_slider; #>
	<?php
}


function mpl_param_type_random(){
?>
	<#
		var new_random = parseInt(Math.random()*1000000);
	#>
	<input name="{{data.name}}" class="mpl-param" value="{{new_random}}" type="text" />

<?php
}


function mpl_param_type_css_background(){
?>
<# 
	var labels = { 
		color: '<?php _e('Background Color', 'mageewp-page-layout'); ?>', 
		image: '<?php _e('BG Image', 'mageewp-page-layout'); ?>', 
		repeat: '<?php _e('BG repeat', 'mageewp-page-layout'); ?>', 
		position: '<?php _e('BG position', 'mageewp-page-layout'); ?>', 
		attachment: '<?php _e('BG attachment', 'mageewp-page-layout'); ?>', 
		size: '<?php _e('BG size', 'mageewp-page-layout'); ?>',
		gradient: '<?php _e('BG Overlay & Gradient', 'mageewp-page-layout'); ?>' ,
        parallax_scrolling: '<?php _e('Parallax Scrolling', 'mageewp-page-layout'); ?>' ,
	};
	
	if( typeof data.label != 'object' )
		data.label = {};
		
	labels = jQuery.extend( labels, data.label );
					
#>
	<input name="{{data.name}}" class="mpl-param" data-css-background-value="" value="{{data.value}}" type="hidden" />
	<div class="mpl-param-row field-color_picker">
		<div class="m-p-r-label">
			<label>{{labels.color}}:</label>
		</div>
		<div class="m-p-r-content">
			<input name="color" value="" data-css-background="color" placeholder="<?php _e('Select color', 'mageewp-page-layout'); ?>" type="search" autocomplete="off">
		</div>
	</div>
	
	<div class="mpl-param-row field-toggle">
		<div class="m-p-r-label">
			<label><?php _e('Advanced', 'mageewp-page-layout'); ?> :</label>
		</div>
		<div class="m-p-r-content">			
			<div class="mpl-toggle-field-wrp">
				<div class="switch">
					<input type="checkbox" name="use_image" data-css-background="toggle" class="toggle-button">
					<span class="toggle-label" data-on="yes" data-off="no"></span>
					<span class="toggle-handle"></span>
				</div>
			</div>
			<div class="m-p-r-des"><?php _e('Background image, gradient', 'mageewp-page-layout'); ?></div>
		</div>
	</div>
	
	<div class="mpl-control-field children box-bg mpl-hidden">
		<div class="mpl-param-row field-attach_image_url">
			<div class="m-p-r-label">
				<label>{{labels.image}}:</label>
			</div>
			<div class="m-p-r-content">
				<div class="mpl-attach-field-wrp">
					<input name="image" value="" data-css-background="image" data-mpl-param="image" type="hidden">
					<div class="img-wrp">
						<img src="" alt="" />
						<i class="sl-close" title="<?php _e('Delete this image', 'mageewp-page-layout'); ?>"></i>
						<div class="img-sizes"></div>
					</div>
					<div class="clear"></div>
					<a class="button media button-primary">
						<i class="sl-cloud-upload"></i> <?php _e('Select background image', 'mageewp-page-layout'); ?>	
					</a>
				</div>	
			</div>
		</div>
        
        
		<?php
			
			$args = array(
				array(
					'repeat', 
					array(
						array('no-repeat', 'no', 'No Repeat'),
						array('repeat', 'repeat', 'Repeat'),
						array('repeat-x', 'X', 'Horizontally'),
						array('repeat-y', 'Y', 'Vertically')
					),
					'style="width: 131px;"'
				),
				array(
					'position', 
					array(
						array('center center', 'center', 'Center Center'),
						array('top left', 'default', 'Top Left'),
						array('50% 50%', '50%', '50% 50%')
					),
					'style="width: 140px;"'
				),
				array(
					'attachment', 
					array(
						array('fixed', 'fixed', 'Fixed'),
						array('scroll', 'scroll', 'Scroll'),
						array('local', 'local', 'Local'),
						array('inherit', 'inherit', 'Inherit'),
					),
					'style="width: 95px;"'
				),
				array(
					'size', 
					array(
						array('auto', 'auto', 'Auto'),
						array('cover', 'cover', 'Cover'),
						array('contain', 'contain', 'Contain'),
						array('inherit', 'inherit', 'Inherit')
					),
					''
				),
			);
			foreach( $args as $arg ){
		?>
		
		<div class="mpl-param-row field-select_group">
			<div class="m-p-r-label">
				<label>{{labels.<?php echo $arg[0]; ?>}}:</label>
			</div>
			<div class="m-p-r-content">
				<div class="mpl-select_group-field-wrp">
					<div class="buttons">
						<?php foreach( $arg[1] as $btn ){
							echo '<button data-value="'.$btn[0].'">'.$btn[1].'<span class="tooltip">'.$btn[2].'</span></button>';
						} ?>
						<button data-value="" class="active"><i class="fa-ban"></i></button>
					</div>
					<input type="text" placeholder="Custom" <?php echo $arg[2]; ?> value="" name="<?php echo $arg[0];?>" data-css-background="<?php echo $arg[0];?>">
				</div>
			</div>
		</div>

		<?php } ?>
        
       <div class="mpl-param-row field-select_group">
			<div class="m-p-r-label">
				<label>{{labels.parallax_scrolling}}:</label>
			</div>
            <div class="m-p-r-content">
            <div class="mpl-select_group-field-wrp">
				<select name="parallax_scrolling" data-css-background="parallax_scrolling" data-mpl-param="parallax_scrolling">
		          <option selected="" value="no"><?php _e('No', 'mageewp-page-layout'); ?></option>
                  <option value="yes"><?php _e('Yes', 'mageewp-page-layout'); ?></option>
	            </select>
                </div>
		    </div>
		</div>
		
	</div>
	
	<# data.callback = mpl.ui.callbacks.background; #>
	
<?php
}

function mpl_param_type_css_video_background(){
?>
<# 
	var labels = { 
		enable_video_bg: '<?php _e('Enable Video Background', 'mageewp-page-layout'); ?>', 
		video_type: '<?php _e('Video Type', 'mageewp-page-layout'); ?>', 
		video_url: '<?php _e('Video Url', 'mageewp-page-layout'); ?>',
		mp4_url: '<?php _e('MP4 Video URL', 'mageewp-page-layout'); ?>',
		ogv_url: '<?php _e('OGV Video URL', 'mageewp-page-layout'); ?>',
		webm_url: '<?php _e('Webm Video URL ', 'mageewp-page-layout'); ?>',
		start_time: '<?php _e('Start Time', 'mageewp-page-layout'); ?>', 
		stop_time: '<?php _e('Stop Time', 'mageewp-page-layout'); ?>',
		video_mute: '<?php _e('Mute', 'mageewp-page-layout'); ?>', 
        video_loop: '<?php _e('Loop', 'mageewp-page-layout'); ?>',
	};
	
	if( typeof data.label != 'object' )
		data.label = {};
		
	labels = jQuery.extend( labels, data.label );
					
#>
	<input name="{{data.name}}" class="mpl-param" data-css-video-background-value="" value="{{data.value}}" type="hidden" />
	<div class="mpl-param-row field-toggle">
		<div class="m-p-r-label">
			
		</div>
		<div class="m-p-r-content">			
			<div class="mpl-toggle-field-wrp">
				<div class="switch">
					<input type="checkbox" name="enable_video_bg" data-css-video-background="toggle" class="toggle-button">
					<span class="toggle-label" data-on="yes" data-off="no"></span>
					<span class="toggle-handle"></span>
				</div>
			</div>
			<div class="m-p-r-des"><?php _e('Choose to show video background', 'mageewp-page-layout'); ?></div>
		</div>
	</div>
	
	<div class="mpl-control-field children box-bg mpl-hidden">
		
		<div class="mpl-param-row field-select">
			<div class="m-p-r-label">
				<label>{{labels.video_type}}:</label>
			</div>
            <div class="m-p-r-content">
				<select class="mpl-param m-p-rela" name="video_type" data-css-video-background="video_type" data-mpl-param="video_type">
		          <option selected="" value="youtube"><?php _e('Youtube Video', 'mageewp-page-layout'); ?></option>
                  <option value="vimeo"><?php _e('Vimeo Video', 'mageewp-page-layout'); ?></option>
	            </select>
		    </div>
		</div>
		<?php
			$args = array(
				array(
					'video_url', 
					__('Insert the youtube/vimeo video URL here, e.g. http://youtu.be/XDLmLYXuIDM<br>https://vimeo.com/193338881','mageewp-page-layout'),
					'mpl-video_url-field'
				),
				array(
					'start_time', 
					__('Choose time to start to play, in seconds.','mageewp-page-layout'),
					''
				),
				array(
					'stop_time',
					__('Choose time to stop to play, in seconds.','mageewp-page-layout'),
					''
				)
			);
			
			foreach( $args as $arg ){
		?>
		
		<div class="mpl-param-row field-text <?php echo $arg[2]; ?>">
			<div class="m-p-r-label">
				<label>{{labels.<?php echo $arg[0]; ?>}}:</label>
			</div>
            <div class="m-p-r-content">
			<input name="<?php echo $arg[0];?>" class="mpl-param" value="" data-css-video-background="<?php echo $arg[0];?>" type="text">
				<div class="m-p-r-des"><?php echo $arg[1];?></div>
		    </div>
		</div>
		<?php } ?>
		
        <?php
			$sel_args = array(
			    array(
					'video_mute', 
					__('Choose to set the video mute','mageewp-page-layout')
				),
				array(
					'video_loop', 
					__('Choose to set the video loop','mageewp-page-layout')
				),
			);
			foreach( $sel_args as $sel_arg ){
		?>
		
		<div class="mpl-param-row field-toggle">
			<div class="m-p-r-label">
				<label>{{labels.<?php echo $sel_arg[0]; ?>}}:</label>
			</div>
            <div class="m-p-r-content">	
                <div class="mpl-toggle-field-wrp">
                    <div class="switch">
                        <input type="checkbox" value="" name="<?php echo $sel_arg[0];?>" data-css-video-background="<?php echo $sel_arg[0];?>" class="toggle-button mpl-param">
                        <span class="toggle-label" data-on="yes" data-off="no"></span>
                        <span class="toggle-handle"></span>
                    </div>
                </div>
                <div class="m-p-r-des"><?php echo $sel_arg[1];?></div>
		    </div>
		</div>
		
		<?php } ?>
        
	</div>
	
	<# data.callback = mpl.ui.callbacks.video_background; #>
	
<?php
}

function mpl_param_type_css_family(){
?>
	<div class="mpl-fonts-picker">
		<input placeholder="<?php _e('Select font', 'mageewp-page-layout'); ?>" name="{{data.name}}" class="mpl-css-param" value="{{data.value}}" type="text" />
		<button><?php _e('Fonts Manager', 'mageewp-page-layout'); ?> <i class="fa-send"></i></button>
		<ul class="mpl-fonts-list"></ul>
	</div>
	<# data.callback = mpl.ui.callbacks.css_fonts; #>
<?php
}


function mpl_param_type_animate(){
?>
	<input name="{{data.name}}" class="mpl-param" value="{{data.value}}" type="hidden" />
	<div class="mpl-animate-preview">
		<?php _e('Animate preview', 'mageewp-page-layout'); ?>
		<small><?php _e('It happens when scroll over', 'mageewp-page-layout'); ?></small>
	</div>
	<div class="mpl-animate-field">
		<strong><?php _e('Effect', 'mageewp-page-layout'); ?>:</strong>  
		<select class="input input-dropdown js-animations mpl-animate-effect">
			<option value="" selected><?php _e('--Select an animate--', 'mageewp-page-layout'); ?></option>
	        <optgroup label="Most Popular">
	        	<option value="fadeIn">fadeIn</option>
	        	<option value="fadeInUp">fadeInUp</option>
	        	<option value="fadeInDown">fadeInDown</option>
	        	<option value="fadeInLeft">fadeInLeft</option>
	        	<option value="fadeInRight">fadeInRight</option>
	        	<option value="bounceIn">bounceIn</option>
	        	<option value="bounceInLeft">bounceInLeft</option>
				<option value="bounceInRight">bounceInRight</option>
	        </optgroup>
	        <optgroup label="Attention Seekers">
	          <option value="bounce">bounce</option>
	          <option value="flash">flash</option>
	          <option value="pulse">pulse</option>
	          <option value="rubberBand">rubberBand</option>
	          <option value="shake">shake</option>
	          <option value="swing">swing</option>
	          <option value="tada">tada</option>
	          <option value="wobble">wobble</option>
	          <option value="jello">jello</option>
	        </optgroup>
	
	        <optgroup label="Bouncing Entrances">
	          <option value="bounceIn">bounceIn</option>
	          <option value="bounceInDown">bounceInDown</option>
	          <option value="bounceInLeft">bounceInLeft</option>
	          <option value="bounceInRight">bounceInRight</option>
	          <option value="bounceInUp">bounceInUp</option>
	        </optgroup>
	
	        <optgroup label="Fading Entrances">
	          <option value="fadeIn">fadeIn</option>
	          <option value="fadeInDown">fadeInDown</option>
	          <option value="fadeInDownBig">fadeInDownBig</option>
	          <option value="fadeInLeft">fadeInLeft</option>
	          <option value="fadeInLeftBig">fadeInLeftBig</option>
	          <option value="fadeInRight">fadeInRight</option>
	          <option value="fadeInRightBig">fadeInRightBig</option>
	          <option value="fadeInUp">fadeInUp</option>
	          <option value="fadeInUpBig">fadeInUpBig</option>
	        </optgroup>
	
	        <optgroup label="Flippers">
	          <option value="flip">flip</option>
	          <option value="flipInX">flipInX</option>
	          <option value="flipInY">flipInY</option>
	        </optgroup>
	
	        <optgroup label="Lightspeed">
	          <option value="lightSpeedIn">lightSpeedIn</option>
	        </optgroup>
	
	        <optgroup label="Rotating Entrances">
	          <option value="rotateIn">rotateIn</option>
	          <option value="rotateInDownLeft">rotateInDownLeft</option>
	          <option value="rotateInDownRight">rotateInDownRight</option>
	          <option value="rotateInUpLeft">rotateInUpLeft</option>
	          <option value="rotateInUpRight">rotateInUpRight</option>
	        </optgroup>
	
	        <optgroup label="Sliding Entrances">
	          <option value="slideInUp">slideInUp</option>
	          <option value="slideInDown">slideInDown</option>
	          <option value="slideInLeft">slideInLeft</option>
	          <option value="slideInRight">slideInRight</option>
	        </optgroup>
	        
	        <optgroup label="Zoom Entrances">
	          <option value="zoomIn">zoomIn</option>
	          <option value="zoomInDown">zoomInDown</option>
	          <option value="zoomInLeft">zoomInLeft</option>
	          <option value="zoomInRight">zoomInRight</option>
	          <option value="zoomInUp">zoomInUp</option>
	        </optgroup>
	
	        <optgroup label="Specials">
	          <option value="rollIn">rollIn</option>
	        </optgroup>
	      </select>
	</div>
	<div class="mpl-animate-field">
		<strong><?php _e('Delay', 'mageewp-page-layout'); ?>:</strong> 
		<input type="text" class="mpl-animate-delay" placeholder="<?php _e('Example: 200', 'mageewp-page-layout'); ?>" />
	</div>
	<div class="mpl-animate-field">
		<strong><?php _e('Speed', 'mageewp-page-layout'); ?>:</strong> 
		<select class="small-sel mpl-animate-speed">
			<option value="">Normal</option>
			<option value="1s">Fast</option>
			<option value="3s">Slow</option>
			<option value=".5s">Fastest</option>
			<option value="3.5s">Slowest</option>
		</select>
	</div>
	
	<# data.callback = mpl.ui.callbacks.animate; #>
<?php
}

function mpl_param_type_undefined(){
?>
	<input name="{{data.name}}" class="mpl-param" value="{{data.value}}" type="text" />
<?php
}

function mpl_param_type_wp_sidebars(){
?>
<select class="mpl-param" name="{{data.name}}">
	<?php
		global $mpl;
		$sidebars = $mpl->get_sidebars();
		foreach( $sidebars as $slug => $name ){
			echo '<option<# if (data.value == "'.$slug.'"){ #> selected<# } #> value="'.$slug.'">'.$name.'</option>';
		}
	?>
</select>
<?php
}
