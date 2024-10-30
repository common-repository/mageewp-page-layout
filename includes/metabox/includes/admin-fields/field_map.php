<?php

if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Field map
 *
 * @param $settings
 * @param string $value
 *
 
 * @return string - html string.
 */
function mpl_form_map( $settings, $value ) {
	ob_start();
	/**
	 * Css Class
	 */
	$css_class = 'mpl-field mpl-map';
	if ( !empty( $settings['el_class'] ) ) {
		$css_class.=' ' . $settings['el_class'];
	}
	
	/**
	 * Attributes
	 */
	$attrs = array();

	if ( !empty( $settings['name'] ) ) {
		$attrs[] = 'name="' . $settings['name'] . '"';
	}

	if ( !empty( $settings['id'] ) ) {
		$attrs[] = 'id="' . $settings['id'] . '"';
	}

	$attrs[] = 'data-type="' . $settings['type'] . '"';
	
	/**
	 * Support Customizer
	 */
	if ( !empty( $settings['customize_link'] ) ) {
		$attrs[] = $settings['customize_link'];
	}
	
	?>
	<div class=" <?php echo esc_attr( $css_class ) ?>" id="<?php echo esc_attr( uniqid('mpl-map-') ) ?>">
		
		<?php printf( '<input type="hidden" class="pf_value" value="%1$s" %2$s/>', $value, implode( ' ', $attrs ) ); ?>
		
		<div class="map_search">
			<input type="text" class="js-map_search"/>
			<i class="fa fa-search"></i>
		</div>
		<div class="map_canvas js-map_canvas"></div>
		
	</div>
	<?php
	return ob_get_clean();
}
