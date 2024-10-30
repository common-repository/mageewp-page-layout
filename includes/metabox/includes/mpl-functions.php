<?php

function mpl_parse_multi_attribute( $value, $default = array() ) {
	$result = $default;
	$params_pairs = explode( '|', $value );
	if ( !empty( $params_pairs ) ) {
		foreach ( $params_pairs as $pair ) {
			$param = preg_split( '/\:/', $pair );
			if ( !empty( $param[0] ) && isset( $param[1] ) ) {
				$result[$param[0]] = rawurldecode( $param[1] );
			}
		}
	}

	return $result;
}

function mpl_init( $func ) {
	/**
	 * Hook to post screen
	 */
	if ( is_admin() ) {

		add_action( 'load-post.php', $func );
		add_action( 'load-post-new.php', $func );
	}
}
