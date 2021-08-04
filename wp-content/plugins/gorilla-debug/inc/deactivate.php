<?php

namespace gorilla_debug;
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


function wp_config_reset () {

	/* ************************************************************************
	 * 1. Read wp-config.php
	 * ************************************************************************/

	$wp_config = new WP_Config_Manager();

	if ($wp_config->is_successful_initialization() == false) {
		return null;
	}




	/* ************************************************************************
	 * 2. Disable all debug parameters
	 * ************************************************************************/

	$wp_config->update_named_constant('WP_DEBUG', 'false');
	$wp_config->update_named_constant('WP_DEBUG_LOG', 'false');
	$wp_config->update_named_constant('WP_DEBUG_DISPLAY', 'false');
	$wp_config->update_named_constant('SCRIPT_DEBUG', 'false');
	$wp_config->update_named_constant('SAVEQUERIES', 'false');





	/* ************************************************************************
	 * 3. Backup wp-config.php
	 * ************************************************************************/

	$result = $wp_config->backup_file();
	if ($result == false) {
		return null;
	}





	/* ************************************************************************
	 * 4. Save modified wp-config.php
	 * ************************************************************************/

	$wp_config->save_file_contents();

}

?>