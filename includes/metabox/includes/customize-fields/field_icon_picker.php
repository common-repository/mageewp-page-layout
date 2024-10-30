<?php

if ( class_exists( 'WP_Customize_Control' ) ):

	/**
	 * Mpl_Customize_Icon_Picker_Control Class
	 */
	class Mpl_Customize_Icon_Picker_Control extends WP_Customize_Control {

		public $type = 'pf_icon_picker';

		/**
		 * Render control
		 * @access public
		 */
		public function render_content() {

			echo '<span class="customize-control-title">' . esc_attr( $this->label ) . '</span>';

			$args = array(
				'type' => $this->type,
				'customize_link' => $this->get_link(),
			);

			echo mpl_form_icon_picker( $args, $this->value() );
		}

	}
	
endif;