<?php

if( !class_exists('Mpl_Field') ):
class Mpl_Field {


	/**
	 * The single instance of the class.
	 *
	 * @var Mpl_Field
	 
	 */
	 
	protected static $_instance = null;

	/**
	 * Main Mpl_Field Instance.
	 *	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct() {

		$this->defined();
		$this->admin_fields();
		$this->includes();
		$this->hooks();
	}

	public function hooks() {

		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_action( 'customize_register', array( $this, 'customize_fields' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_scripts' ) );
	}

	public function customize_fields() {
		$this->register_customize_field( 'Mpl_Customize_Select_Control' );
		$this->register_customize_field( 'Mpl_Customize_Multicheck_Control' );
		$this->register_customize_field( 'Mpl_Customize_Icon_Picker_Control' );
		$this->register_customize_field( 'Mpl_Customize_Repeater_Control' );
		$this->register_customize_field( 'Mpl_Customize_Map_Control' );
		$this->register_customize_field( 'Mpl_Customize_Link_Control' );
		$this->register_customize_field( 'Mpl_Customize_Datetime_Control' );
		$this->set_control_types();
	}

	private function set_control_types() {

		global $mpl_control_types;

		$mpl_control_types = apply_filters( 'mpl_control_types', array(
			'image' => 'WP_Customize_Image_Control',
			'cropped_image' => 'WP_Customize_Cropped_Image_Control',
			'upload' => 'WP_Customize_Upload_Control',
			'color' => 'WP_Customize_Color_Control',
			'pf_select' => 'Mpl_Customize_Select_Control',
			'pf_multicheck' => 'Mpl_Customize_Multicheck_Control',
			'pf_icon_picker' => 'Mpl_Customize_Icon_Picker_Control',
			'pf_repeater' => 'Mpl_Customize_Repeater_Control',
			'pf_map' => 'Mpl_Customize_Map_Control',
			'pf_link' => 'Mpl_Customize_Link_Control',
			'pf_datetime' => 'Mpl_Customize_Datetime_Control'
				) );

		// Make sure the defined classes actually exist.
		foreach ( $mpl_control_types as $key => $classname ) {

			if ( !class_exists( $classname ) ) {
				unset( $mpl_control_types[$key] );
			}
		}
	}

	public function admin_fields() {
		include MPL_METABOX_DIR . 'includes/admin-fields/field_default.php';
		include MPL_METABOX_DIR . 'includes/admin-fields/field_color_picker.php';
		include MPL_METABOX_DIR . 'includes/admin-fields/field_image_picker.php';
		include MPL_METABOX_DIR . 'includes/admin-fields/field_image_select.php';
		include MPL_METABOX_DIR . 'includes/admin-fields/field_icon_picker.php';
		include MPL_METABOX_DIR . 'includes/admin-fields/field_link.php';
		include MPL_METABOX_DIR . 'includes/admin-fields/field_map.php';
		include MPL_METABOX_DIR . 'includes/admin-fields/field_repeater.php';
		include MPL_METABOX_DIR . 'includes/admin-fields/field_datetime.php';
	}

	public function includes() {
		include MPL_METABOX_DIR . 'includes/class-mpl-metaboxes.php';

		include MPL_METABOX_DIR . 'includes/mpl-functions.php';
	}

	public function defined() {
		define( 'MPL_METABOX_DIR', MPL_PATH.'/includes/metabox/' );
		define( 'MPL_METABOX_URL', MPL_URL.'/includes/metabox/' );
	}


	/**
	 * Register and load customize field
	 * @return void
	 */
	private function register_customize_field( $control_class ) {
		$path = str_replace( 'Mpl_Customize_', 'field_', $control_class );
		$path = str_replace( '_Control', '.php', $path );
		$path = strtolower( $path );
		$path = MPL_METABOX_DIR . 'includes/customize-fields/' . $path;

		if ( is_readable( $path ) ) {
			include $path;
			global $wp_customize;
			$wp_customize->register_control_type( $control_class );
		}
	}

	/**
	 * Enqueue admin scripts
	 * @return void
	 */
	public function admin_scripts( $hook_suffix ) {

		$min = WP_DEBUG ? '' : '.min';

		global $mpl_registered_fields;

		if ( !empty( $mpl_registered_fields ) ) {

			wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/plugins/font-awesome/css/font-awesome' . $min . '.css', null, '4.4.0' );
			wp_enqueue_style( 'mpl-admin', MPL_METABOX_URL . 'assets/css/admin' . $min . '.css', null, MPL_VERSION );

			wp_enqueue_script( 'mpl-libs', MPL_METABOX_URL . 'assets/js/mpl-libs' . $min . '.js', array( 'jquery' ), MPL_VERSION );
			wp_enqueue_script( 'mpl-admin', MPL_METABOX_URL . 'assets/js/admin_fields' . $min . '.js', array( 'jquery' ), MPL_VERSION );

			$upload_dir = wp_upload_dir();


			wp_localize_script( 'mpl-admin', 'mpl_var', array(
				'upload_url' => $upload_dir['baseurl']
			) );

			foreach ( $mpl_registered_fields as $type ) {
				switch ( $type ) {
					case 'color_picker':
						wp_enqueue_script( 'wp-color-picker' );
						wp_enqueue_style( 'wp-color-picker' );
						break;
					case 'image_picker';
						wp_enqueue_media();
						wp_enqueue_script( 'jquery-ui' );
						break;
					case 'map':
						$gmap_key = sanitize_text_field( apply_filters( 'mpl_gmap_key', 'AIzaSyCsBPWZ52X6EvpYCPuSWdqiIrazdJodFLk' ) );
						wp_enqueue_script( 'google-map-v-3', "//maps.googleapis.com/maps/api/js?libraries=places&key={$gmap_key}", array( 'jquery' ), null, true );
						wp_enqueue_script( 'geocomplete', MPL_METABOX_URL . 'assets/vendors/geocomplete/jquery.geocomplete' . $min . '.js', null, MPL_VERSION );
						break;
					case 'icon_picker':
						wp_enqueue_script( 'font-iconpicker', MPL_METABOX_URL . 'assets/vendors/fonticonpicker/js/jquery.fonticonpicker' . $min . '.js', array( 'jquery' ), MPL_VERSION );
						wp_enqueue_style( 'font-iconpicker', MPL_METABOX_URL . 'assets/vendors/fonticonpicker/css/jquery.fonticonpicker' . $min . '.css', null, MPL_VERSION );
						break;
					case 'link':

						$screens = apply_filters( 'mpl_link_on_screens', array( 'post.php', 'post-new.php' ) );
						if ( !in_array( $hook_suffix, $screens ) ) {
							wp_enqueue_style( 'editor-buttons' );
							wp_enqueue_script( 'wplink' );

							add_action( 'in_admin_header', 'mpl_link_editor_hidden' );
							add_action( 'customize_controls_print_footer_scripts', 'mpl_link_editor_hidden' );
						}
						break;
					case 'repeater':
						wp_enqueue_script( 'jquery-repeater', MPL_METABOX_URL . 'assets/js/repeater-libs' . $min . '.js', array( 'jquery' ), MPL_VERSION );
						break;
					case 'select':
						wp_enqueue_script( 'selectize', MPL_METABOX_URL . 'assets/vendors/selectize/selectize' . $min . '.js', array( 'jquery' ), MPL_VERSION );
						wp_enqueue_style( 'selectize', MPL_METABOX_URL . 'assets/vendors/selectize/selectize' . $min . '.css', null, MPL_VERSION );
						wp_enqueue_style( 'selectize-skin', MPL_METABOX_URL . 'assets/vendors/selectize/selectize.default' . $min . '.css', null, MPL_VERSION );
						break;
					case 'datetime':
						wp_enqueue_script( 'datetimepicker', MPL_METABOX_URL . 'assets/vendors/datetimepicker/jquery.datetimepicker.full' . $min . '.js', array( 'jquery' ), MPL_VERSION );
						wp_enqueue_style( 'datetimepicker', MPL_METABOX_URL . 'assets/vendors/datetimepicker/jquery.datetimepicker' . $min . '.css', null, MPL_VERSION );
						break;
					default :
						do_action( 'mpl_admin_scripts', $type );
						break;
				}
			}
		}
	}

	/**
	 * Binds the JS listener to make Customizer control
	 *
	 
	 */
	function customize_scripts() {
		$min = WP_DEBUG ? '' : '.min';
		wp_enqueue_script( 'color-scheme-control', MPL_METABOX_URL . 'assets/js/customize-fields' . $min . '.js', array( 'customize-controls' ), MPL_VERSION, true );
	}

}

/**
 * Main instance of Mpl_Field.
 *
 * Returns the main instance of Mpl_Field to prevent the need to use globals.
 *
  */
function mpl_field_load() {
	return Mpl_Field::instance();
}

// Global for backwards compatibility.
$GLOBALS['mageewp_page_layout'] = mpl_field_load();

endif;
