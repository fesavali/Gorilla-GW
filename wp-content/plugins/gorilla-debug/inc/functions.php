<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


/**
 * gorilla_debug() helps in logging debug statements. To use this function, make one of the following calls:
 *
 * 		gorilla_debug('This message is for debugging purposes'); // Prints a message
 * 		gorilla_debug($array); // Prints an array
 * 		gorilla_debug($object); // Prints an object
 */

function gorilla_debug($message) {

	// If we passed an array or an object, then display it
	if (is_array($message) || is_object($message)) {
		error_log(print_r($message, true));
	}

	// If we pass a string, then display it
	else {
		error_log($message);
	}

}



?>