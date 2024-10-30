<?php

if ( class_exists( 'WP_Customize_Control' ) ):

	/**
	 * Mpl_Customize_Multicheck_Control Class
	 */
	class Mpl_Customize_Multicheck_Control extends WP_Customize_Control {

		public $type = 'pf_multicheck';

		/**
		 * Maximum number of options the user will be able to select.
		 * Set to 1 for single-select.
		 *
		 * @access public
		 * @var int
		 */
		public $multiple = 1;

		/**
		 * Render control
		 * @access public
		 */
		public function render_content() {

			echo '<span class="customize-control-title">' . esc_attr( $this->label ) . '</span>';

			$args = array(
				'options' => $this->choices,
				'multiple' => $this->multiple,
				'type' => $this->type
			);
			$value = '';
			
			$my_value = $this->value();
			
			if ( is_string( $my_value ) && !empty( $my_value ) && $this->multiple ) {
				$value = explode( ',', $this->value() );
			} else if ( is_array( $this->value() ) ) {
				$value = $this->value();
			}

			$input_value = is_array( $this->value() ) ? implode( ',', $this->value() ) : $this->value();

			echo mpl_form_checkbox( $args, $value );

			printf( '<input class="pf-holder_value" type="hidden" value="%s" %s/>', $input_value, $this->get_link() );
		}

	}

	

endif;