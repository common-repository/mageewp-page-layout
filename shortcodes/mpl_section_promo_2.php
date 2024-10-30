<?php

$button_link = $link_url = $link_title = $link_target = '';

$section_subtitle = '';
$section_title = '';
$desc = '';
$button_text = '';
$button_link = '';
$button_target = '';
$image = '';
$layout = '';
$image_position_class = '';
$image_align = '';
extract($atts);

if (!empty($button_link)) {
	$link_arr = explode( "|", $button_link );
	if (!empty( $link_arr[0]))
		$link_url = $link_arr[0];

	if (!empty( $link_arr[1]))
		$link_title = $link_arr[1];

	if (!empty( $link_arr[2]))
		$link_target = $link_arr[2];
}

$element_attributes = array();

$owl = apply_filters( 'mpl-owl-carousel', $atts );
$el_classes = apply_filters( 'mpl-el-class', $atts );
$video_background = apply_filters('mpl-video-background', $atts);

if (is_numeric($image)) {
	$image_attributes = wp_get_attachment_image_src( $image,'full' );
	$image = $image_attributes[0];
}

$layout = ($layout == "" || !isset($layout) )? 'left':$layout;
$image_align = ($image_align == "" || !isset($image_align) )? 'left':$image_align;
			   
/*function data*/
$data = (object)array(
	'section_class'    => implode(' ', $el_classes),
	'section_id'       =>  esc_attr( $atts['section_id'] ),
	'section_title'    => $section_title,
	'section_subtitle' => $section_subtitle,
	'image'	   		   => $image,
	'desc' 		       => do_shortcode($desc),
	'image_align'      => $image_align,
	'button_text'      => $button_text,
	'link_url'         => $link_url,
	'link_target'      => $link_target,
	'video_background' => $video_background, 
);

switch($layout) {
	case 'left':
		mpl_tpl_section_promo2_style1($data);					
		break;
	case 'right':
		mpl_tpl_section_promo2_style2($data);				
		break;
	case 'top':
		mpl_tpl_section_promo2_style3($data);
		break;
	case 'bottom':
		mpl_tpl_section_promo2_style4($data);
		break;	
}
