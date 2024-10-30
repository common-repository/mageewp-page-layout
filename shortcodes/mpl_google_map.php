<?php

$output = $wrap_class  = $css_custom = $css = '';

$section_subtitle = '';
$section_title    = '';
$animation = '';
$container = 'mpl-container';

extract($atts);

$element_attributes = array();
$el_classes = apply_filters( 'mpl-el-class', $atts );

$slider_css = '';
if ( $map_height !== '' && intval($map_height) > 0 ) {
	$slider_css = 'style="height:'.intval($map_height).'px;"';
}

if( (isset($fullwidth) && $fullwidth == 'yes') )
	$container = 'mpl-container-fullwidth';

$embed_map = preg_replace( array('/width="\d+"/i', '/height="\d+"/i'), array(
        sprintf('width="%s"', '100%' ),
        sprintf('height="%d"', intval( $map_height ))
    ),
   $embed_map );

/*function data*/
$data = (object)array(
	'section_class'    => implode(' ', $el_classes),
	'section_id'       => esc_attr( $atts['section_id'] ),
	'section_title'    => $section_title,
	'section_subtitle' => $section_subtitle,
	'section_height'	=> $slider_css,
	'container' 	   => $container,
	'animation' 	   => $animation,
	'embed_map'		   => $embed_map,
);

mpl_tpl_section_google_map($data);
