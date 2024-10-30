<#
	
	if( data === undefined )
		data = {};
	var attributes = [], classes = [], 
		cont_class = ['mpl-row-container'], 
		css_data = '', output = '', 
		atts = ( data.atts !== undefined ) ? data.atts : {};


classes = mpl.front.el_class( atts );
classes.push( 'mpl_row' );

if( atts['row_class'] !== undefined && atts['row_class'] !== '' )
	classes.push( atts['row_class'] );

if( atts['full_height'] !== undefined && atts['full_height'] !== '' ){
	
	if( atts['content_placement'] !== undefined && atts['content_placement'] == 'middle' )
		attributes.push( 'data-mpl-fullheight="middle-content"' );
	else attributes.push( 'data-mpl-fullheight="true"' );
	
}
	
if( atts['column_align'] === undefined || atts['column_align'] === '' )
	atts['column_align'] = 'center';
	
if( atts['equal_height'] !== undefined && atts['equal_height'] !== '' ){
	
	attributes.push( 'data-mpl-equalheight="true"' );
	attributes.push( 'data-mpl-equalheight-align="' + atts['column_align'] + '"' );
}

if( atts['use_container'] !== undefined && atts['use_container'] == 'yes' )
	cont_class.push( 'mpl-container' );

if( atts['container_class'] !== undefined && atts['container_class'] !== '' )
	cont_class.push( atts['container_class'] );

if( atts['css'] !== undefined && atts['css'] !== '' )
	classes .push( atts['css'].split('|')[0] );

if( atts['video_bg'] !== undefined && atts['video_bg'] === 'yes' ){
	
	var video_bg_url = atts['video_bg_url'];

	if( atts['video_bg_url'] !== undefined ){
		
		classes.push('mpl-video-bg');
		attributes.push('data-mpl-video-bg="'+atts['video_bg_url']+'"');
		css_data += 'position: relative;';
	}
} 

if( atts['row_id'] !== undefined && atts['row_id'] !== '' )
	attributes.push( 'id="'+atts['row_id']+'"' );

if( atts['video_bg_url'] === undefined || atts['video_bg'] !== 'yes' )
{
	if( atts['parallax'] !== undefined )
	{

		attributes.push( 'data-mpl-parallax="true"' );

		if( atts['parallax'] == 'yes-new' )
		{
			var bg_image = '<?php echo admin_url('/admin-ajax.php?action=mpl_get_thumbn&size=full&id='); ?>'+atts['parallax_image'];
			css_data += "background-image:url('"+bg_image+"');";
		}
		
	}
}

attributes.push( 'class="'+classes.join(' ')+'"' );

if( css_data !== '' )
	attributes.push( 'style="'+css_data+'"' );

output += '<section '+attributes.join(' ')+'>';

output += '<div class="'+cont_class.join(' ')+'">';

output += '<div class="mpl-wrap-columns">'+data.content+'</div>';

output += '</div>';

output += '</section>';

data.callback = function( wrp, $ ){
	//mpl_front.init( wrp );
	$('#mpl-live-frame').get(0).contentWindow.mpl_front.init(mpl._$);
}
	
#>

{{{output}}}
