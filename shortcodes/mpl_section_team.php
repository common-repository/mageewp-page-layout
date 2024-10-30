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

$columns = $columns == ''? 3 : $columns;
$persons = $atts['persons'];	
$persons_data = array();
if ( isset( $persons ) ) {
	foreach ($persons as $person) {
		
		$image = $person->image;
		$link  = $person->link;
		$name  = $person->name;
		$title = $person->title;
		$desc  = $person->desc;
		$social_1 = $person->social_1;
		$social_2 = $person->social_2;
		$social_3 = $person->social_3;
		$social_4 = $person->social_4;
		$social_1_link = $person->social_1_link;		
		$social_2_link = $person->social_2_link;
		$social_3_link = $person->social_3_link;
		$social_4_link = $person->social_4_link;  
		
		if (preg_match('/http|https:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is',$image))
		{
			$image           = $image;
		} else {
			$image_attributes = wp_get_attachment_image_src( $image,'full' );
			$image            = $image_attributes[0];
		}
		$persons_data[] = (object)array(
			'image'         => $image,
			'name'          => esc_attr($name),
			'link'          => esc_url($link),
			'title'         => esc_attr($title),
			'desc'          => do_shortcode($desc),
			'social_1'      => $social_1,
			'social_1_link' => $social_1_link,
			'social_2'      => $social_2,
			'social_2_link' => $social_2_link,
			'social_3'      => $social_3,
			'social_3_link' => $social_3_link,
			'social_4'      => $social_4,
			'social_4_link' => $social_4_link,
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
	'persons'          => $persons_data,
	'carousel'         => $owl['carousel'],
	'owl_options' 	   => $owl['options'],
	'owl_nav_style'    => $owl['nav_style'],
	'video_background' => $video_background, 
);

mpl_tpl_section_team($data);
