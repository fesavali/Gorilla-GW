<?php

namespace gorilla_debug;
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );



function display_admin_notices () {

	$screen = get_current_screen();

	switch ($screen->id) {

		case 'toplevel_page_' . SLUG__LOG:
		case sanitize_title_with_dashes (PAGE_TITLE__GORILLA_DEBUG) . '_page_' . SLUG__SETTINGS:

			if ( isset($_GET['update']) ) {

				switch ($_GET['update']) {

					case NOTICE__ERROR:
						$type = 'notice-error';
						break;

					case NOTICE__WARNING:
						$type = 'notice-warning';
						break;

					case NOTICE__SUCCESS:
						$type = 'notice-success';
						break;

					case NOTICE__INFO:
						$type = 'notice-info';
						break;

				}

				?>
				<div class="notice <?php echo $type ?> is-dismissible">
					<p><?php echo rawurldecode( $_GET['message'] ); ?></p>
				</div>
				<?php

			}

			break;



		case 'plugins':

			// URL to be used in error message
			$url = add_query_arg (

				array (
					'page' => SLUG__LOG
				),

				admin_url('admin.php')
			);


			// Open wp-config.php
			$wp_config = new WP_Config_Manager();

			if ($wp_config->is_successful_initialization() == false) {

				?>
				<div class="notice notice-error is-dismissible">
					<p>Unable to locate <em>wp-config.php</em>. <a href="<?php echo $url; ?>">Click here</a> to set it up manually.</p>
				</div>
				<?php

			}



			// For each of the debug definitions, find out if any can be found in wp-config.php
			$found_WP_DEBUG = $wp_config->find_named_constant('WP_DEBUG');
			$found_WP_DEBUG_LOG = $wp_config->find_named_constant('WP_DEBUG_LOG');
			$found_WP_DEBUG_DISPLAY = $wp_config->find_named_constant('WP_DEBUG_DISPLAY');
			$found_SCRIPT_DEBUG = $wp_config->find_named_constant('SCRIPT_DEBUG');
			$found_SAVEQUERIES = $wp_config->find_named_constant('SAVEQUERIES');

			// If for some reason, finding a pattern caused a error, so therefore we have to set it up manually.
			// Note that false means there is an error, but a 0 means item not found. We are checking for errors
			if (($found_WP_DEBUG === false) ||
				($found_WP_DEBUG_LOG === false) ||
				($found_WP_DEBUG_DISPLAY === false) ||
				($found_SCRIPT_DEBUG === false) ||
				($found_SAVEQUERIES === false)) {

				?>
				<div class="notice notice-error is-dismissible">
					<p>Error trying to find debug settings in <em>wp-config.php</em>. <a href="<?php echo $url; ?>">Click here</a> to set it up manually.</p>
				</div>
				<?php
			}

			// If at least one of the debug definitions was not found, then throw an error
			if (($found_WP_DEBUG == 0) ||
				($found_WP_DEBUG_LOG == 0) ||
				($found_WP_DEBUG_DISPLAY == 0) ||
				($found_SCRIPT_DEBUG == 0) ||
				($found_SAVEQUERIES == 0)) {

				?>
				<div class="notice notice-error is-dismissible">
					<p>Gorilla Debug plugin error. Unable to properly set debug settings in <em>wp-config.php</em>. <a href="<?php echo $url; ?>">Click here</a> to set it up manually.</p>
				</div>
				<?php
			}

			break;

	}

}

?>