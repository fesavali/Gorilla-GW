<?php

namespace gorilla_debug;
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


/*
 * Creating a custom top-level menu entry into wordpress admin area
 */
function add_menus () {

	// Bring up the settings page or the setup page based on wp-config.php

	// First, read the wp-config.php file
	$wp_config = new WP_Config_Manager();

	if ($wp_config->is_successful_initialization() == false) {

		// There is a problem with initializing/accessing wp-config.php, so display the fallback page

		// Add a page called Gorilla Debug into the WP Admin area
		// Note that the slug for this menu is 'gorilla-debug-log-page'. This slug is similar to the slug of the menu that ...
		// ... is displayed when the installation of this plugin is successful ...
		// ... The reason for that is to ensure that when the user fixes the installation problem, and then refreshes the page, ...
		// ... the other menu item will be displayed without an error (because the slug is used in the url)
		add_menu_page(PAGE_TITLE__GORILLA_DEBUG, PAGE_TITLE__GORILLA_DEBUG, 'manage_options', SLUG__LOG, function () {
			require_once (plugin_dir_path( __FILE__ ) . 'pages' . DIRECTORY_SEPARATOR . 'fallback.php');
		});

		return;
	}



	// Check if wp-config.php was properly setup during plugin activation
	// ... in other words, look for WP_DEBUG, WP_DEBUG_LOG, WP_DEBUG_DISPLAY, SCRIPT_DEBUG and SAVEQUERIES, and if at least one of them does not exist, then it is manual setup

	$found_WP_DEBUG = $wp_config->find_named_constant('WP_DEBUG');
	$found_WP_DEBUG_LOG = $wp_config->find_named_constant('WP_DEBUG_LOG');
	$found_WP_DEBUG_DISPLAY = $wp_config->find_named_constant('WP_DEBUG_DISPLAY');
	$found_SCRIPT_DEBUG = $wp_config->find_named_constant('SCRIPT_DEBUG');
	$found_SAVEQUERIES = $wp_config->find_named_constant('SAVEQUERIES');

	// Check if installation is successful, and decide which page(s) to display based on the installation.
	if (($found_WP_DEBUG == 0) ||
		($found_WP_DEBUG_LOG == 0) ||
		($found_WP_DEBUG_DISPLAY == 0) ||
		($found_SCRIPT_DEBUG == 0) ||
		($found_SAVEQUERIES == 0)) {

		// Installation not successful. Display the setup page.

		// Add a page called Gorilla Debug into the WP Admin area
		// Note that the slug for this menu is 'gorilla-debug-log-page'. This slug is similar to the slug of the menu that ...
		// ... is displayed when the installation of this plugin is successful ...
		// ... The reason for that is to ensure that when the user fixes the installation problem, and then refreshes the page, ...
		// ... the other menu item will be displayed without an error (because the slug is used in the url)
		add_menu_page(PAGE_TITLE__GORILLA_DEBUG, PAGE_TITLE__GORILLA_DEBUG, 'manage_options', SLUG__LOG, function () {
			require_once (plugin_dir_path( __FILE__ ) . 'pages' . DIRECTORY_SEPARATOR . 'setup.php');
		});
	}

	else {

		// Installation successful. Display the WP Debug pages.

		// Create a top level menu called WP Debug into the WP Admin section
		add_menu_page(PAGE_TITLE__GORILLA_DEBUG, PAGE_TITLE__GORILLA_DEBUG, 'manage_options', SLUG__LOG);

		// The first menu item is Debug Log.
		add_submenu_page(SLUG__LOG, PAGE_TITLE__DEBUG_LOG, PAGE_TITLE__DEBUG_LOG, 'manage_options', SLUG__LOG, function () {
			require_once (plugin_dir_path( __FILE__ ) . 'pages' . DIRECTORY_SEPARATOR . 'log.php');
		});

		// The second menu item.
		add_submenu_page(SLUG__LOG, PAGE_TITLE__DEBUG_SETTINGS, PAGE_TITLE__DEBUG_SETTINGS, 'manage_options', SLUG__SETTINGS, function () {
			require_once (plugin_dir_path( __FILE__ ) . 'pages' . DIRECTORY_SEPARATOR . 'settings.php');
		});

	}

}


?>