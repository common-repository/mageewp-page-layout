<?php 

$output = $wrap_class  = $css_custom = $css = '';

$section_subtitle = '';
$section_title    = '';
$carousel = '';

extract($atts);

$element_attributes = array();

$owl = apply_filters( 'mpl-owl-carousel', $atts );
$el_classes = apply_filters( 'mpl-el-class', $atts );

$video_background = apply_filters('mpl-video-background', $atts);
$columns = $columns == ''? 4 : $columns;
$counter = $atts['counter'];	
$counter_data = array();
if (isset($counter)) {
	foreach ($counter as $counter_item) {

		$title = $counter_item->title;
		$number = absint($counter_item->number);
		$counter_data[] = (object)array(
			'number' => $number,
			'title'  => $title
		);
	}
}

/*function data*/
$data = (object)array(
	'section_class'    => implode(' ', $el_classes),
	'section_id'       =>  esc_attr( $atts['section_id'] ),
	'section_title'    => $section_title,
	'section_subtitle' => $section_subtitle,
	'columns' 		   => $columns,
	'counter' 	   	   => $counter_data,
	'carousel'         => $owl['carousel'],
	'owl_options' 	   => $owl['options'],
	'owl_nav_style'    => $owl['nav_style'],
	'video_background' => $video_background, 
);

mpl_tpl_section_counter($data);