<?php

if ( class_exists( 'WP_Customize_Control' ) ):

	/**
	 * Mpl_Customize_Link_Control Class
	 */
	class Mpl_Customize_Link_Control extends WP_Customize_Control {
	
		/**
		 * @var string Field type
		 */
		public $type = 'pf_link';

		/**
		 * Render control
		 * @access public
		 */
		public function render_content() {

			echo '<span class="customize-control-title">' . esc_attr( $this->label ) . '</span>';

			$args = array(
				'type' => $this->type,
				'customize_link' => $this->get_link()
			);

			echo mpl_form_link( $args, $this->value() );
		}

	}
endif;