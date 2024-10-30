<?php

$output = $css_data = $css = '';

$cont_class = array( 'mpl-row-container' );
$element_attributes = array();
$containment = '';

extract($atts);

$css_classes = apply_filters( 'mpl-el-class', $atts );

if( $css != '' )
	$css_classes[] = $css;
	
if( !empty( $atts['row_class'] ) )
	$css_classes[] = $atts['row_class'];

if( !empty( $atts['full_height'] ) && $atts['full_height'] == "yes" )
{
	$css_classes[] = 'mpl-fullheight mpl-verticalmiddle';
	
}

if( !empty( $atts['css'] ) )
	$css_classes[] = $atts['css'];


if( !empty( $atts['row_id'] ) )
	$element_attributes[] = 'id="' . esc_attr( $atts['row_id'] ) . '"';

$css_class = implode(' ', $css_classes);
$element_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

if( !empty( $css_data ) )
	$element_attributes[] = 'style="' . esc_attr( trim( $css_data ) ) . '"';

echo do_shortcode( str_replace( 'mpl_row#', 'mpl_row', $content ) );
