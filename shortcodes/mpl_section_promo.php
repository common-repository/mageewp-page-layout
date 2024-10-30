<?php

$output = $wrap_class  = $css_custom = $css = $button_link = $link_url = $link_title = $link_target = '';

$section_subtitle = '';
$section_title    = '';
$desc     = '';
$button_text      = '';
$button_link      = '';
$button_target    = '';
$image       = '';
$content_position   = '';
$image_align      = '';

extract($atts);

if (!empty($button_link)) {
	$link_arr = explode( "|", $button_link );

	if ( !empty( $link_arr[0] ) )
		$link_url = $link_arr[0];

	if ( !empty( $link_arr[1] ) )
		$link_title = $link_arr[1];

	if ( !empty( $link_arr[2] ) )
		$link_target = $link_arr[2];
}

$element_attributes = array();

$el_classes = apply_filters( 'mpl-el-class', $atts );
$video_background = apply_filters('mpl-video-background', $atts);

if (is_numeric($image)) {
	$image_attributes = wp_get_attachment_image_src($image, 'full');
	$image       = $image_attributes[0];
}

$content_position = ($content_position == "" || !isset($content_position)) ? 'right' : $content_position;
$image_align = ($image_align == "" || !isset($image_align) )? 'text-center' : 'text-' .$image_align;

/*function data*/
$data = (object)array(
	'section_class'    => implode(' ', $el_classes),
	'section_id'       =>  esc_attr( $atts['section_id'] ),
	'section_title'    => $section_title,
	'section_subtitle' => $section_subtitle,
	'image'	   		   => $image,
	'desc' 	           => $desc,
	'content_position' => $content_position,
	'image_align'      => $image_align,
	'button_text'      => $button_text,
	'link_url'         => $link_url,
	'link_target'      => $link_target,
	'video_background' => $video_background, 
);

mpl_tpl_section_promo($data);
