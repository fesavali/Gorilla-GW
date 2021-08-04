<?php

namespace gorilla_debug;
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );



/*
 * Code to initially setup wp-config.php
 */
function wp_config_initial_setup () {


	/* ************************************************************************
	 * 1. Read wp-config.php
	 * ************************************************************************/

	$wp_config = new WP_Config_Manager();

	if ($wp_config->is_successful_initialization() == false) {
		return null;
	}



	/* ************************************************************************
	 * 2. Update wp-config.php
	 * ************************************************************************/

	$result = $wp_config->set_wp_config_with_debug_definitions();
	if ($result == false) {
		return null;
	}





	/* ************************************************************************
	 * 3. Backup wp-config.php
	 * ************************************************************************/

	$result = $wp_config->backup_file();
	if ($result == false) {
		return null;
	}





	/* ************************************************************************
	 * 4. Save updated wp-config.php
	 * ************************************************************************/

	$result = $wp_config->save_file_contents();

	// If writing the file failed, inform the user to do it manually
	if ($result == false) {

		// Returning null will eventually take us to the manual setup instructions page
		// ... this line of code is probably redundent, but it is added to ensure code comprehension
		return null;
	}

}


?>