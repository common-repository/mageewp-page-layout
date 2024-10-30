<?php

if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Field Color Picker.
 *
 * @param $settings
 * @param string $value
 *
 
 * @return string - html string.
 */
function mpl_form_color_picker( $settings, $value ) {

	$attrs = array();

	if ( !empty( $settings['name'] ) ) {
		$attrs[] = 'name="' . $settings['name'] . '"';
	}

	if ( !empty( $settings['id'] ) ) {
		$attrs[] = 'id="' . $settings['id'] . '"';
	}

	$el_class = isset( $settings['el_class'] ) ? $settings['el_class'] : '';


	$attrs[] = 'data-type="' . $settings['type'] . '"';

	return sprintf( '<input type="text" class="mpl-field mpl-color pf_value %3$s" value="%1$s" data-default-color="%1$s" %2$s/>', htmlspecialchars( $value ), implode( ' ', $attrs ), esc_attr( $el_class ) );
}
