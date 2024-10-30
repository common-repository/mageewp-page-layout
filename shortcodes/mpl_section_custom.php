<?php

$output =  $wrap_class  = '';
$section_subtitle = '';
$section_title    = '';

extract( $atts );

$element_attributes = array();

$el_classes = apply_filters( 'mpl-el-class', $atts );
$video_background = apply_filters('mpl-video-background', $atts);

/*function data*/
$data = (object)array(
	'section_class'    => implode(' ', $el_classes),
	'section_id'       => esc_attr( $atts['section_id'] ),
	'section_title'    => $section_title,
	'section_subtitle' => $section_subtitle,
	'content' 	   	   => $content,
	'video_background' => $video_background,
);

mpl_tpl_section_custom($data);
