<?php 

$output = $wrap_class  = $css_custom = $css = '';

$section_subtitle = '';
$section_title    = '';
$layout = '';

extract($atts);

$element_attributes = array();

$owl = apply_filters( 'mpl-owl-carousel', $atts );
$el_classes = apply_filters( 'mpl-el-class', $atts );
$video_background = apply_filters('mpl-video-background', $atts);

$columns = $columns == ''? 2 : $columns;
$layout = isset($layout) ? $layout : 'style3';

$testimonials = $atts['testimonials'];	
$testimonials_data = array();
if (isset($testimonials)) {
	foreach ($testimonials as $testimonials_list) {
		$image = $testimonials_list->image;
		$name  = $testimonials_list->name;
		$title = $testimonials_list->title;
		$desc  = $testimonials_list->desc;
		
		if (preg_match('/http|https:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is',$image))
		{
			$image           = $image;
		} else {
			$image_attributes = wp_get_attachment_image_src( $image,'full' );
			$image            = $image_attributes[0];
		}
		
		$testimonials_data[] = (object)array(
			'image' => esc_url($image),
			'name' => esc_attr($name),
			'title' => esc_attr($title),
			'desc' => do_shortcode($desc)
		);  
	}
}

/*function data*/
$data = (object)array(
	'section_class'    => implode(' ', $el_classes),
	'section_id'       =>  esc_attr( $atts['section_id'] ),
	'section_title'    => $section_title,
	'section_subtitle' => $section_subtitle,
	'columns'	       => $columns,
	'testimonials'     => $testimonials_data,
	'carousel'         => $owl['carousel'],
	'owl_options' 	   => $owl['options'],
	'owl_nav_style'    => $owl['nav_style'],
	'video_background' => $video_background, 
);

switch($layout){
	case '2':
		mpl_tpl_section_testimonials_2($data);
	break;
	default:
		mpl_tpl_section_testimonials_3($data);
	break;
}
