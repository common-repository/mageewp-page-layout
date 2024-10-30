<?php

$output = $wrap_class  = $css_custom = $css = $link_url_1 = $link_target_1 = $link_title_1 = $link_url_2 = $link_target_2 = $link_title_2 = '';
$btn_text_1 = '';
$btn_link_1 = '';
$btn_text_2 = '';
$btn_link_2 = '';
$fullheight = '';
$section_height = '';
$slider_css = '';
$fullheight_class = '';
$content_align = '';
$section_title = '';
$section_subtitle = '';
$title_style   = '';
extract($atts);

$element_attributes = array();

$el_classes = apply_filters( 'mpl-el-class', $atts );
$video_background = apply_filters('mpl-video-background', $atts);

if ($fullheight == "yes" ) {
	$fullheight_class = 'mpl-fullheight';
} else {
	if ( $section_height !== '' && absint($section_height) > 0 ) {
		$slider_css = 'style="height:'.absint($section_height).'px;"';
	}
}

if(!empty($content_align))
	$content_align = 'text-'.$content_align;

$i = 0;
$output_item = '';
if (!empty($btn_link_1)) {
	$link_arr = explode( "|", $btn_link_1 );

	if ( !empty( $link_arr[0] ) )
		$link_url_1 = $link_arr[0];

	if ( !empty( $link_arr[1] ) )
		$link_title_1 = $link_arr[1];

	if ( !empty( $link_arr[2] ) )
		$link_target_1 = $link_arr[2];
	
}

if (!empty($btn_link_2)) {
	$link_arr = explode( "|", $btn_link_2 );

	if ( !empty( $link_arr[0] ) )
		$link_url_2 = $link_arr[0];

	if ( !empty( $link_arr[1] ) )
		$link_title_2 = $link_arr[1];

	if ( !empty( $link_arr[2] ) )
		$link_target_2 = $link_arr[2];
	
}

if (count($social_icons) > 0)
	$enable_social_icon = 'yes';
else
	$enable_social_icon = '';

$social_icons = array();
$icon_link_url = '#';
$icon_link_title = '';
$icon_link_target = '#';
	
foreach ($atts['social_icons'] as $icon) {

	if (!empty($icon->icon_link)) {
		$link_arr = explode("|", $icon->icon_link);

		if (!empty($link_arr[0]))
			$icon_link_url = $link_arr[0];
	
		if (!empty($link_arr[1]))
			$icon_link_title = $link_arr[1];
	
		if (!empty($link_arr[2]))
			$icon_link_target = $link_arr[2];
	}

	$social_icons[] = (object)array(
		'icon'        => $icon->icon_name,
		'link_url'    => $icon_link_url,
		'link_title'  => $icon_link_title,
		'link_target' => $icon_link_target
	);
}

/*function data*/
$data = (object)array(
	'section_class'  	 => implode(' ', $el_classes),
	'fullheight'     	 => $fullheight_class,
	'section_height'	 => $slider_css,
	'section_id'      	 =>  esc_attr( $atts['section_id'] ),
	'section_title'   	 => $section_title,
	'section_subtitle'	 => $section_subtitle,
	'title_style'		 => $title_style,
	'content_align'		 => $content_align,
	'btn_text_1' 		 => $btn_text_1,
	'link_url_1' 		 => $link_url_1,
	'link_target_1'		 => $link_target_1,
	'btn_text_2'  	     => $btn_text_2,
	'link_url_2'         => $link_url_2,
	'link_target_2'      => $link_target_2,
	'enable_social_icon' => $enable_social_icon,
	'social_icons' 		 => $social_icons,
	'video_background'   => $video_background,  
);

mpl_tpl_section_banner($data);