<#
	if( data === undefined )data = {};
	var width = '', output = '', attributes = [],
		atts = ( data.atts !== undefined ) ? data.atts : {},
		classes = mpl.front.el_class( atts );

classes.push('mpl_column');

if (atts['col_class'] !== undefined)
	classes.push( atts['col_class'] );

if (atts['css'] !== undefined && typeof atts['css'] == 'string')
	classes.push( atts['css'].split('|')[0] );
	
if( atts['col_id'] !== undefined && atts['col_id'] !== '' )
	attributes.push( 'id="'+ atts['col_id'] +'"' );
	
	
if( atts['video_bg'] !== undefined && atts['video_bg'] === 'yes' ){
	
	var video_bg_url = atts['video_bg_url'];
	
	if( atts['video_bg_url'] !== undefined ){
	
		classes.push('mpl-video-bg');
		attributes.push('data-mpl-video-bg="'+atts['video_bg_url']+'"');
	}
}
	
attributes.push( 'class="'+classes.join(' ')+'"' );

var col_container_class = ( atts['col_container_class'] !== undefined ) ? ' '+atts['col_container_class'] : '';

if( data.content === undefined )
	data.content = '';
	
data.content += '<div class="mpl-element drag-helper" data-model="-1" droppable="true" draggable="true"><a href="javascript:void(0)" class="mpl-add-elements-inner"><i class="sl-plus mpl-add-elements-inner"></i></a></div>';

#><div {{{attributes.join(' ')}}}>
	<div class="mpl-col-container{{col_container_class}}">{{{data.content}}}</div>
</div>
