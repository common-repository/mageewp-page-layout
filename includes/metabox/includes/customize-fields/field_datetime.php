<?php


if ( class_exists( 'WP_Customize_Control' ) ):

	/**
	 * Mpl_Customize_Datetime_Control Class
	 */
	class Mpl_Customize_Datetime_Control extends WP_Customize_Control {

		/**
		 * @var string Field type
		 */
		public $type = 'pf_datetime';

		/**
		 * @var array Datetimepicker options
		 */
		public $options = array();

		/**
		 * Constructor.
		 */
		public function __construct( $manager, $id, $args = array() ) {

			parent::__construct( $manager, $id, $args );

			if ( empty( $args['options'] ) || !is_array( $args['options'] ) ) {
				$args['options'] = array();
			}

			$this->options = $args['options'];
		}

		/**
		 * Render control
		 * @access public
		 */
		public function render_content() {

			echo '<span class="customize-control-title">' . esc_attr( $this->label ) . '</span>';

			$args = array(
				'options' => $this->options,
				'type' => $this->type,
				'customize_link' => $this->get_link(),
			);
			
			echo mpl_form_datetime( $args, $this->value() );
		}

	}
endif;