<?php
$width = $css = $output = $col_class = $col_container_class = $col_id = $css_data =  '';
extract( $atts );

$attributes = array();
$style = array();
$classes = apply_filters( 'mpl-el-class', $atts );
$classes[] = 'mpl_column';
$classes[] = @mpl_column_width_class( $width );

if ( !empty( $col_class ) )
$classes[] = $col_class;

if ( !empty( $col_id ) )
$attributes[] = 'id="' . $col_id . '"';

if ( count($style) > 0 )
$attributes[] = 'style="' . implode( ';', $style ) . '"';

$col_container_class = !empty( $col_container_class ) ? $col_container_class . ' mpl-col-container' : 'mpl-col-container';
$attributes[] = 'class="' . esc_attr( trim( implode(' ', $classes ) ) ) . '"';

$output = do_shortcode( str_replace('mpl_column#', 'mpl_column', $content ) );
echo $output;