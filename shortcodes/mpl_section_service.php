<?php

$title_link = $link_url = $link_title = $link_target = '';
$video_background = '';
$section_subtitle = '';
$section_title    = '';
$service_item     = '';
$icon_type        = '';
$icon_shape       = '';

extract($atts);

$element_attributes = array();
$el_classes = apply_filters( 'mpl-el-class', $atts );
$video_background = apply_filters('mpl-video-background', $atts);

$layout = isset($layout) ? $layout : '1';
if($layout == "__empty__" || $layout == "")
	$layout     =  '1';

$services = $atts['services'];
$services_data = array();
if (isset($atts['columns']) && $atts['columns'] !='')
	$columns  = absint($atts['columns']);
  
if ($columns > 6 || $columns < 1)
	$columns = 3;

$icon_shape = isset($icon_shape) ? $icon_shape : 'icon';
$icon_html = '';
$image_margin_left = '';

if (isset($services)) {
	$i = 1;
	foreach ( $services as $service ) {
		$icon_css = '';
		$link_url  = '';
		$link_title = '';
		$link_target = '';
		$title           = $service->title;
		$title_link      = $service->title_link;
		$description     = $service->description;

		$image       = (isset($service->image)) ? $service->image : '';
		$icon_color      = (isset($service->icon_color)) ? $service->icon_color : '#595959';

		//<i class="fa {{val.icon}} {{val.shape}}" style="background-color:#595959;"></i>
		if ($icon_type == 'icon') {
			if ($icon_shape == 'none') {
				$icon_style = 'color';
				$shape = '';
			} else  {
				$icon_style = 'background-color';
				$shape = $icon_shape;
			}
			$icon_html = '<i class="fa ' .$service->icon .' ' .$shape .'" style="' .$icon_style .':' .$icon_color .';"></i>';
			$image_margin_left = '';
		}
		else {
			$image_margin_left = 'style="margin-left:' .($image_width + 20) .'px;"';
			$icon_html = '<image style="width:' .$image_width .'px;" src="' .$image .'">';
		}

		if (!empty( $title_link)) {
			$link_arr = explode( "|", $title_link );

			if ( !empty( $link_arr[0] ) )
				$link_url = $link_arr[0];

			if ( !empty( $link_arr[1] ) )
				$link_title = $link_arr[1];

			if ( !empty( $link_arr[2] ) )
				$link_target = $link_arr[2];
		}
		$services_data[] = (object)array(
			'icon_html' => $icon_html,
			'icon_color' => $icon_color,
			'link_url' => $link_url,
			'link_target' => $link_target,
			'title' => $title,
			'description' => do_shortcode($description)
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
	'image_margin_left'=> $image_margin_left,
	'services'         => $services_data,
	'video_background' => $video_background, 
);

switch($layout){
	case '1':
		mpl_tpl_section_service_1($data);
		break;

	case '2':
		mpl_tpl_section_service_2($data);
		break;

	case '3':
		mpl_tpl_section_service_3($data);
		break;

	default:
		mpl_tpl_section_service_2($data);
		break;
}	


