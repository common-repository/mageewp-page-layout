<?php

if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Field Link
 *
 * @param $settings
 * @param string $value
 *
 
 * @return string - html string.
 */
function mpl_form_link( $settings, $value ) {
	ob_start();

	/**
	 * @var string Css Class
	 */
	$css_class = 'mpl-field mpl-link';

	if ( !empty( $settings['el_class'] ) ) {
		$css_class.=' ' . $settings['el_class'];
	}


	/**
	 * @var array Attributes
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


	$link = mpl_build_link( $value );

	$json_value = htmlentities( json_encode( $link ), ENT_QUOTES, 'utf-8' );

	$input_value = htmlentities( $value, ENT_QUOTES, 'utf-8' );
	?>
	<div class="<?php echo esc_attr( $css_class ) ?>" id="mpl-link-<?php echo esc_attr( uniqid() ) ?>">

		<?php printf( '<input type="hidden" class="pf_value" value="%1$s" data-json="%2$s" %3$s/>', $input_value, $json_value, implode( ' ', $attrs ) ); ?>

		<a href="#" class="button link_button"><?php echo esc_attr__( 'Select URL', 'mageewp-page-layout' ) ?></a> 
		<span class="group_title">
			<span class="link_label_title link_label"><?php echo esc_attr__( 'Link Text:', 'mageewp-page-layout' ) ?></span> 
			<span class="title-label"><?php echo isset( $link['title'] ) ? esc_attr( $link['title'] ) : ''; ?></span> 
		</span>
		<span class="group_url">
			<span class="link_label"><?php echo esc_attr__( 'URL:', 'mageewp-page-layout' ) ?></span> 
			<span class="url-label">
				<?php
				echo isset( $link['url'] ) ? esc_url( $link['url'] ) : '';
				echo isset( $link['target'] ) ? ' ' . esc_attr( $link['target'] ) : '';
				?> 
			</span>
		</span>
	</div>
	<?php
	return ob_get_clean();
}

/**
 * Build Link from string
 * 
 * @param string $value
 *
 
 * @return array
 */
function mpl_build_link( $value ) {
	return mpl_parse_multi_attribute( $value, array( 'url' => '', 'title' => '', 'target' => '', 'rel' => '' ) );
}

/**
 * Print link editor template
 * Link field need a hidden textarea to work
 * 
 
 * @return void
 */
function mpl_link_editor_hidden() {
	echo '<textarea id="content" class="hide hidden"></textarea>';
	require_once ABSPATH . "wp-includes/class-wp-editor.php";
	_WP_Editors::wp_link_dialog();
}
