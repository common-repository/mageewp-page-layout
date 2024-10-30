<?php

/*
 * Remove __empty__ code value
 */
function mpl_remove_empty_code( $atts ){

	$atts_tmp = array();

	foreach( $atts as $key => $value ){
		if('__empty__' === $value){
			$atts_tmp[$key] = '';
		}else{
			$atts_tmp[$key] = $value;
		}
	}

	return $atts_tmp;
}


//Row filter
function mpl_row_filter( $atts ){

	if( isset( $atts['video_bg'] ) && $atts['video_bg'] == 'yes' ){
		wp_register_script('mpl-youtube-iframe-api', 'https://www.youtube.com/iframe_api', null, MPL_VERSION, true );
		wp_enqueue_script('mpl-youtube-iframe-api');
	}

	return $atts;

}
//Row filter
function mpl_column_filter( $atts ){

	if( isset( $atts['video_bg'] ) && $atts['video_bg'] == 'yes' ){
		wp_register_script('mpl-youtube-iframe-api', 'https://www.youtube.com/iframe_api', null, MPL_VERSION, true );
		wp_enqueue_script('mpl-youtube-iframe-api');
	}
	
	return $atts;
	
}

function mpl_row_inner_filter( $atts ){

	if( isset( $atts['video_bg'] ) && $atts['video_bg'] == 'yes' ){
		wp_register_script('mpl-youtube-iframe-api', 'https://www.youtube.com/iframe_api', null, MPL_VERSION, true );
		wp_enqueue_script('mpl-youtube-iframe-api');
	}
	
	return $atts;
	
}

//Tab filter
function mpl_tabs_filter( $atts = array() ){

	if( isset( $atts['type'] ) && $atts['type'] === 'slider_tabs' ){
		wp_enqueue_script( 'owl-carousel' );
		wp_enqueue_style( 'owl-theme' );
		wp_enqueue_style( 'owl-carousel' );
	}

	return $atts;

}

function mpl_tab_filter( $atts = array() ){

	// Do your code here
	global $mpl_tab_id;

	if( !isset( $mpl_tab_id ) || empty( $mpl_tab_id ) )
		$mpl_tab_id = array();

	$i = 1; $_title = sanitize_title( !empty( $atts['title'] ) ? $atts['title'] : 'mpl-tab' );
	while( in_array( $_title, $mpl_tab_id ) )
	{
		$i++;
		$_title = sanitize_title( !empty( $atts['title'] ) ? $atts['title'] : 'mpl-tab' ).$i;
	}

	array_push( $mpl_tab_id, $_title );

	$atts['tab_id'] = $_title;

	return $atts;

}

function mpl_box_filter( $atts = array() ){

	global $mpl_front;

	if( isset( $atts['css_code'] ) && !empty( $atts['css_code'] ) ){
		$mpl_front->add_header_css( $atts['css_code'] );
	}

	return $atts;

}


function mpl_video_play_filter( $atts = array() ){

	if( isset( $atts['video_link'] ) && !empty( $atts['video_link'] ) ){

		if(preg_match('/youtu\.be/i', $atts['video_link']) || preg_match('/youtube\.com\/watch/i', $atts['video_link'])){
			$atts['check_video'] = 'true';
			wp_enqueue_script('mpl-youtube-api');
		}else if( (preg_match('/vimeo\.com/i', $atts['video_link'] )) ){
			$atts['check_video'] = 'true';
			wp_enqueue_script('mpl-vimeo-api');
		}else{
			$atts['check_video'] = 'false';
		}
	}else{
		$atts['check_video'] = 'false';
	}

	if( isset( $atts['video_upload'] ) && !empty( $atts['video_upload'] ) ){
		$atts['check_video'] = 'true';
	}

	wp_enqueue_script( 'mpl-video-play' );

	return $atts;
}


function mpl_counter_box_filter( $atts = array() ){

	wp_enqueue_script('jquery-waypoints');
	wp_enqueue_script('counter-up');

	return $atts;
}


function mpl_carousel_post_filter( $atts = array() ){

	$atts = mpl_remove_empty_code( $atts );
	extract( $atts );

	wp_enqueue_script( 'owl-carousel' );
	wp_enqueue_style( 'owl-theme' );
	wp_enqueue_style( 'owl-carousel' );

	return $atts;
}

/*
 * Pie chart shortcode custom css
 */
function mpl_pie_chart_filter( $atts = array() ){

	global $mpl_front;

	wp_enqueue_script( 'easypie-chart' );

	return $atts;

}


function mpl_twitter_feed_filter( $atts = array() ){

	global $mpl_front;

	$atts = mpl_remove_empty_code( $atts );
	extract( $atts );

	if( isset( $display_style ) && '2' === $display_style ){
		wp_enqueue_script( 'owl-carousel' );
		wp_enqueue_style( 'owl-theme' );
		wp_enqueue_style( 'owl-carousel' );
	}

	return $atts;
}

function mpl_carousel_images_filter( $atts = array() ){

	$atts = mpl_remove_empty_code( $atts );
	extract( $atts );

	wp_enqueue_script( 'owl-carousel' );
	wp_enqueue_style( 'owl-theme' );
	wp_enqueue_style( 'owl-carousel' );

	if( isset( $onclick ) && $onclick == 'lightbox' ){
		wp_enqueue_script( 'prettyPhoto' );
		wp_enqueue_style( 'prettyPhoto' );
	}

	return $atts;
}

function mpl_image_gallery_filter( $atts = array() ){

	global $mpl_front;
	$atts = mpl_remove_empty_code( $atts );
	
	extract( $atts );
	
	wp_enqueue_script( 'masonry' );
	
	if( isset( $click_action ) && 'lightbox' === $click_action ){
		wp_enqueue_script( 'prettyPhoto' );
		wp_enqueue_style( 'prettyPhoto' );
	}

	return $atts;
}


function mpl_blog_posts_filter( $atts = array() ) {

	if ( isset( $atts['layout'] ) && $atts['layout'] == '1' ) {

		wp_enqueue_script( 'owl-carousel' );
		wp_enqueue_style( 'owl-theme' );
		wp_enqueue_style( 'owl-carousel' );

	}

	wp_enqueue_script( 'masonry' );


	return $atts;

}
