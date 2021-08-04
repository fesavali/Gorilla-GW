<?php

/**
 * Plugin Name: Gorilla Debug
 * Plugin URI: http://debug.gorilla.solutions
 * Description: This is a simple and awesome debugging tool for WordPress.
 * Version: 1.0.0
 * Requires at least: 5.7
 * Requires PHP: 7.2
 * Author: Gorilla Solutions
 * Author URI: https://gorilla.solutions
 * License: GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

namespace gorilla_debug;
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


require_once (plugin_dir_path( __FILE__ ) . 'inc' . DIRECTORY_SEPARATOR . 'constants.php');
require_once (plugin_dir_path( __FILE__ ) . 'inc' . DIRECTORY_SEPARATOR . 'functions.php');

require_once (plugin_dir_path( __FILE__ ) . 'inc' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'file-manager.php');
require_once (plugin_dir_path( __FILE__ ) . 'inc' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'wp-config-manager.php');
require_once (plugin_dir_path( __FILE__ ) . 'inc' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'debug-log-manager.php');

require_once (plugin_dir_path( __FILE__ ) . 'inc' . DIRECTORY_SEPARATOR . 'activate.php');
require_once (plugin_dir_path( __FILE__ ) . 'inc' . DIRECTORY_SEPARATOR . 'deactivate.php');
require_once (plugin_dir_path( __FILE__ ) . 'inc' . DIRECTORY_SEPARATOR . 'enqueue.php');
require_once (plugin_dir_path( __FILE__ ) . 'inc' . DIRECTORY_SEPARATOR . 'admin-menus.php');
require_once (plugin_dir_path( __FILE__ ) . 'inc' . DIRECTORY_SEPARATOR . 'form-scripts.php');
require_once (plugin_dir_path( __FILE__ ) . 'inc' . DIRECTORY_SEPARATOR . 'notices.php');
require_once (plugin_dir_path( __FILE__ ) . 'inc' . DIRECTORY_SEPARATOR . 'ajax.php');




/* ****************************************************************************
 * Activate
 * ****************************************************************************/

// Plugin activation
register_activation_hook(__FILE__, 'gorilla_debug\wp_config_initial_setup');





/* ****************************************************************************
 * Deactivate
 * ****************************************************************************/

// Plugin deactivation
register_deactivation_hook( __FILE__, 'gorilla_debug\wp_config_reset' );





/* ****************************************************************************
 * Enqueue
 * ****************************************************************************/

// Load CSS files
add_action('admin_enqueue_scripts', 'gorilla_debug\load_styles_and_scripts' );





/* ****************************************************************************
 * Admin - Menus
 * ****************************************************************************/

// Add menu and pages to WordPress admin area
add_action('admin_menu', 'gorilla_debug\add_menus');





/******************************************************************************
 * Notices
 ******************************************************************************/
add_action('admin_notices', 'gorilla_debug\display_admin_notices');





/******************************************************************************
 * Form Scripts
 ******************************************************************************/
add_action('wp_loaded', 'gorilla_debug\run_form_scripts');





/******************************************************************************
 * Ajax
 ******************************************************************************/
add_action('wp_ajax_get_debug_log_content', 'gorilla_debug\get_debug_log_content');
add_action('wp_ajax_set_debug_log_content', 'gorilla_debug\set_debug_log_content');


?>