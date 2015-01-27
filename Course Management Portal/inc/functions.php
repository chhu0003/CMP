<?php
/*
 * if functions are added here, they will be usable site wide
 *
 * @TODO: add any needed functions to the functions.php
 */

/*
 * auto loads any classes that are being called on
 * but haven't been included in the page
 * -> shouldn't be depended on, just a fail-safe
 */
function __autoload( $className )
{

	$className = strtolower( $className );

	$path = dirname( __FILE__ ) . "/classes/{$className}.php";

	//if the file exists in the classes folder
	if( file_exists( $path ) ) {

		//add it to the page
		require_once( $path );

	} else {

		die( "The file {$className}.php could not be found." );

	}

}

