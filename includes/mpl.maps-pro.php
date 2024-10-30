<?php

if(!defined('MPL_FILE')) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

/*
	* plugins_loaded
 	*/
if ( !function_exists( 'mplpro_get_maps_hook' ) ):

function mplpro_get_maps_hook() 
{
	$maps = array(

	);

	return $maps;
}
endif;