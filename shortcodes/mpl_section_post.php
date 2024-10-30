<?php
$output 		= $title = $wrap_class = $taxonomy = $thumbnail = $show_button = $css = '';
$image_size 	= 'full';

extract($atts);

$owl = apply_filters( 'mpl-owl-carousel', $atts );
$el_classes = apply_filters( 'mpl-el-class', $atts );

$video_background = apply_filters('mpl-video-background', $atts);

$atts['post_taxonomy'] = 'post';
$post_data = mpl_recent_posts_data($atts);
$posts = array();
foreach ($post_data['data'] as $data) {
	$posts[] = (object)$data;
}

$post_type 		= 'post';
/*function data*/
$data = (object)array(
	'section_class'    => implode(' ', $el_classes),
	'section_id'       => esc_attr( $atts['section_id'] ),
	'section_title'    => $section_title,
	'section_subtitle' => $section_subtitle,
	'post_type' 	   => $post_type,
	'wrap_class'       => $wrap_class,
	'posts' 		   => $posts,
	'category' 		   => $category,
	'columns'          => $columns,
	'carousel'         => $owl['carousel'],
	'owl_options' 	   => $owl['options'],
	'owl_nav_style'    => $owl['nav_style'],
	'video_background'  => $video_background
);

mpl_tpl_section_post($data);

