<?php

if(!defined('MPL_FILE')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

/**
 * Template Loader
 */
class MPL_Template_Loader {

	/**
	 * Hook in methods.
	 */
	public static function init() {
		add_filter( 'template_include', array( __CLASS__, 'template_loader' ) );
	}

	/**
	 * Load a template.
	 */
	public static function template_loader( $template ) {
		global $mpl;
		$find = array( 'mageewp-page-layout.php' );
		$file = '';

		if ( is_embed() ) {
			return $template;
		}

		if ( is_single() && get_post_type() == 'mpl-portfolio' ) {

			$file 	= 'single-mpl-portfolio.php';
			$find[] = $file;
			$find[] = MPL_PRO_PATH.'/includes/theme-templates/'. $file;

		} elseif ( is_post_type_archive('mpl-portfolio') || is_tax( 'mpl-portfolio-category' ) || is_tax( 'mpl-portfolio-tag' ) ) {

			$term   = get_queried_object();

			if ( is_tax( 'mpl-portfolio-category' ) || is_tax( 'mpl-portfolio-tag' ) ) {
				$file = 'taxonomy-' . $term->taxonomy . '.php';
			} else {
				$file = 'archive-mpl-portfolio.php';
			}

			$find[] = 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			$find[] = MPL_PRO_PATH.'/includes/theme-templates/' . 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			$find[] = 'taxonomy-' . $term->taxonomy . '.php';
			$find[] = MPL_PRO_PATH.'/includes/theme-templates/' . 'taxonomy-' . $term->taxonomy . '.php';
			$find[] = $file;
			$find[] = MPL_PRO_PATH.'/includes/theme-templates/' . $file;

		}

		if ( $file ) {
			$template       = locate_template( array_unique( $find ) );
			if ( ! $template ) {
				$template = MPL_PRO_PATH.'/includes/theme-templates/' . $file;
			}
		}

		return $template;
	}

}

MPL_Template_Loader::init();
