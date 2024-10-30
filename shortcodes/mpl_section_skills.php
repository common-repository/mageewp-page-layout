<?php 

$output = $wrap_class  = $css_custom = $css =  '';

$section_subtitle = '';
$section_title    = '';
$columns = '';
$style = '';
$carousel = '';
extract($atts);

$element_attributes = array();

$owl = apply_filters( 'mpl-owl-carousel', $atts );
$el_classes = apply_filters( 'mpl-el-class', $atts );
$video_background = apply_filters('mpl-video-background', $atts);
$columns = $columns == ''? 4 : $columns;

$items = $atts['items'];	
$items_data = array();					
if (isset($items)) {
	$i = 1;
	foreach ($items as $item) {
		
		$percent = $item->percent;
		$title   = $item->title;
		$dec     = $item->desc;
		$color   = $item->barcolor;
		if (preg_match('/(\d)/is',$percent)) {
			$percent = abs($percent);
		}else{
			$percent = preg_replace('/(^\d)/is','',$percent);	
		}

		$items_data[] = (object)array(
			'percent' => $percent,
			'title' => $title,
			'desc' => do_shortcode($dec),
			'barcolor' => $color,
			'i' => $i
		);	
		$i++;
	}
}

/*function data*/
$data = (object)array(
	'section_class'    => implode(' ', $el_classes),
	'section_id'       =>  esc_attr( $atts['section_id'] ),
	'section_title'    => $section_title,
	'section_subtitle' => $section_subtitle,
	'columns' 		   => $columns,
	'items'            => $items_data,
	'carousel'         => $owl['carousel'],
	'owl_options' 	   => $owl['options'],
	'owl_nav_style'    => $owl['nav_style'],	
	'video_background' => $video_background, 
);

mpl_tpl_section_skills($data);
