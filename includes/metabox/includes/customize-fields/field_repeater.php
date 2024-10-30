<?php


if ( class_exists( 'WP_Customize_Control' ) ):

	/**
	 * Mpl_Customize_Repeater_Control Class
	 */
	class Mpl_Customize_Repeater_Control extends WP_Customize_Control {

		/**
		 * The control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'pf_repeater';
		
		/**
		 * The fields that each container row will contain.
		 *
		 * @access public
		 * @var array
		 */
		public $fields = array();

		/**
		 * Constructor.
		 * Supplied `$args` override class property defaults.
		 * If `$args['settings']` is not defined, use the $id as the setting ID.
		 *
		 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
		 * @param string               $id      Control ID.
		 * @param array                $args    {@see WP_Customize_Control::__construct}.
		 */
		public function __construct( $manager, $id, $args = array() ) {

			parent::__construct( $manager, $id, $args );

			if ( empty( $args['fields'] ) || !is_array( $args['fields'] ) ) {
				$args['fields'] = array();
			}

			$this->fields = $args['fields'];
			
		}

		/**
		 * Render control
		 */
		public function render_content() {
			
			echo '<span class="customize-control-title">' . esc_attr( $this->label ) . '</span>';
			
			$args = array(
				'customize_link' => $this->get_link(),
				'type' => 'repeater',
				'fields' => $this->fields,
				'name' => $this->id
			);
			
			echo mpl_form_repeater( $args, $this->value() );
		}

	}
endif;