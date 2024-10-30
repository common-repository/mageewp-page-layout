<?php

$output = $row_class_container = $row_class = $row_id = $css = '';

extract( $atts );


$css_classes = apply_filters( 'mpl-el-class', $atts );

$css_classes = array_merge( $css_classes, array(
	'mpl_row',
	'mpl_row_inner',
	$row_class
));

if( $css != '' )
	$css_classes[] = $css;
	
$attributes = array();

if ( ! empty( $row_id ) ) {
	$attributes[] = 'id="' . esc_attr( $row_id ) . '"';
}




if( empty($atts['column_align']) )
    $atts['column_align'] = 'center';

if( !empty( $atts['equal_height'] ) )
{
	$attributes[] = 'data-mpl-equalheight="true"';
	$attributes[] = 'data-mpl-row-action="true"';
    $attributes[] = 'data-mpl-equalheight-align="'. $atts['column_align'] .'"';
}

/**
 *Check video background
 */

if( $atts['video_bg'] === 'yes' )
{
	$video_bg_url = $atts['video_bg_url'];
	
	$has_video_bg = mpl_youtube_id_from_url( $video_bg_url );
	
	if( !empty( $has_video_bg ) )
	{
		$css_classes[] = 'mpl-video-bg';
		$attributes[] = 'data-mpl-video-bg="' . esc_attr( $video_bg_url ) . '"';
	}
}

$attributes[] = 'class="' . esc_attr( trim( implode(' ', $css_classes) ) ) . '"';

$output .= '<div ' . implode( ' ', $attributes ) . '>';

if( !empty( $row_class_container ) )
	$output .= '<div class="'.esc_attr( $row_class_container ).'">';

$output .= do_shortcode( str_replace('mpl_row_inner#', 'mpl_row_inner', $content ) );

if( !empty( $row_class_container ) )
	$output .= '</div>';

$output .= '</div>';

echo $output;
