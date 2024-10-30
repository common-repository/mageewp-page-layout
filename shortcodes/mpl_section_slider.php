<?php
global $mpl_meta;

$btn_text_1 = '';
$btn_link_1 = '';
$btn_text_2 = '';
$btn_link_2 = '';
$fullheight = '';
$section_height = '';
$slider_css = '';
$fullheight_class = '';
$content_align = '';

extract($atts);

$atts['carousel'] = 'yes';
$atts['owl_navigation'] = 'yes';
$atts['owl_nav_style'] = 'arrow';
$owl = apply_filters( 'mpl-owl-carousel', $atts );
$el_classes = apply_filters( 'mpl-el-class', $atts );
$video_background = apply_filters('mpl-video-background', $atts);

$slides = $atts['slides'];
$section_class = esc_attr( implode(' ', $el_classes ) ) ;
$section_id = esc_attr( $atts['section_id'] );

if ( $fullheight == "yes" ) {
	$fullheight_class = 'mpl-fullheight';
} else {
	if ( $section_height !== '' && absint($section_height) > 0 ) {
		$slider_css = 'style="height:'.absint($section_height).'px;"';
	}
}

if (!empty($content_align))
	$content_align = 'text-' .$content_align;

$i = 0;
$output_item = '';
$slides_data = array();
if (isset($slides)) {    
	foreach ($slides as $slide) {
		$i++;
        $link_url_1 = $link_target_1 = $link_title_1 = $link_url_2 = $link_target_2 = $link_title_2 = '';
		$image   = isset($slide->image) ? $slide->image : '';
		$title   = isset($slide->title) ? $slide->title : '';
		$title_style = (isset($slide->title_style))?$slide->title_style:'';
		$subtitle = isset($slide->subtitle) ? $slide->subtitle : '';
		$btn_text_1 = (isset($slide->btn_text_1))?$slide->btn_text_1:'Button 1';
		$btn_link_1 = (isset($slide->btn_link_1))?$slide->btn_link_1:'#';
		$btn_text_2 = (isset($slide->btn_text_2))?$slide->btn_text_2:'Button 2';
		$btn_link_2 = (isset($slide->btn_link_2))?$slide->btn_link_2:'#';
		$link_url_1 = $link_title_1 = $link_target_1 = $link_url_2 = $link_title_2 = $link_target_2 = ''; 
		$content_align = isset($slide->content_align) ? 'text-'.$slide->content_align : $content_align;
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
		
		if (is_numeric($image)) {
			$image_attributes = wp_get_attachment_image_src($image, 'full');
			$image            = $image_attributes[0];
		}

		$slides_data[] = (object)array(
			'image' => $image,
			'content_align' => $content_align,
			'title' => $title,
			'title_style' => $title_style,
			'subtitle' => $subtitle,
			'btn_text_1' => $btn_text_1,
			'link_url_1' => $link_url_1,
			'link_target_1' => $link_target_1,
			'btn_text_2' => $btn_text_2,
			'link_url_2' => $link_url_2,
			'link_target_2' => $link_target_2
		);
	}
	$mpl_slider = '';
	if ($i > 1) {
		$mpl_slider = 'mpl-slider';
	}
}

/**/
$data = array(
	'section_class'     => $section_class, 
	'section_id' 		=> $section_id,
	'mpl_slider' 		=> $mpl_slider,
	'sliders'    		=> $slides_data,
	'fullheight'  		=> $fullheight_class,
	'section_height'	=> $slider_css,
	'carousel'         => $owl['carousel'],
	'owl_options' 	   => $owl['options'],
	'owl_nav_style'    => $owl['nav_style'],
	'video_background' 	=> $video_background, 
);
$data = (object)$data;

mpl_tpl_section_slider($data);
