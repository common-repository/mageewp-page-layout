<?php 

$output = $wrap_class  = $css_custom = $css = $enable_lightbox = '';

$section_subtitle = '';
$section_title    = '';
$section_lightbox = '';
$fullwidth = '';
$container = 'mpl-container';
$carousel = '';

extract($atts);

$element_attributes = array();

$owl = apply_filters( 'mpl-owl-carousel', $atts );
$el_classes = apply_filters( 'mpl-el-class', $atts );

if ($fullwidth == 'yes')
	$container = 'mpl-container-fullwidth';

$columns = isset($columns)? $columns : 4;
$items = $atts['items'];	
$items_data = array();	 			

if (isset($items)) {
	foreach ($items as $item) {
		$link_url = $link_title = $link_target = '';
		$attachment_id = $item->image;
		$image_link = isset($item->link) ? $item->link : ''; 
		if (!empty($image_link)) {
			$link_arr = explode( "|", $image_link );

			if ( !empty( $link_arr[0] ) )
				$link_url = $link_arr[0];
		
			if ( !empty( $link_arr[1] ) )
				$link_title = $link_arr[1];

			if ( !empty( $link_arr[2] ) )
				$link_target = $link_arr[2];
		}
		if (preg_match('/http|https:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is',$attachment_id)) {
		    $image           = $attachment_id;
		} else {
			$image_attributes = wp_get_attachment_image_src( $attachment_id,'full' );
			$image            = $image_attributes[0];
		}
		  
		$items_data[] = (object)array(
			'image' => $image,
			'link' => $link_url,
			'target' => $link_target,
		);  
	}
}

/*function data*/
$data = (object)array(
	'section_class'    => implode(' ', $el_classes),
	'section_id'       =>  esc_attr( $atts['section_id'] ),
	'section_title'    => $section_title,
	'section_subtitle' => $section_subtitle,
	'container'        => $container,
	'columns' 		   => $columns,
	'lightbox'   	   => $section_lightbox,
	'items' 	   	   => $items_data,
	'carousel'         => $owl['carousel'],
	'owl_options' 	   => $owl['options'],
	'owl_nav_style'    => $owl['nav_style'],
);

mpl_tpl_section_gallery($data);