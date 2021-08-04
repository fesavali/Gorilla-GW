<?php

namespace gorilla_debug;
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );



function run_form_scripts () {

	// Check if this is a post call
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		if (( isset($_POST['save_debug_settings_changes']) ) ||
			( isset($_POST['set_debug_settings']) ) ) {

			// Default result value
			$result = true;
			$message = '';

			do {

				/* ********************************************************************
				* 1. Read wp-config.php
				* ********************************************************************/

				$wp_config = new WP_Config_Manager();

				// If we cannot find the wp-config.php file, then we cannot do anything
				if ($wp_config->is_successful_initialization() == false) {
					$message = "Unable to locate <em>wp-config.php</em>.";
					break;
				}



				/* ************************************************************************
				 * 2. Update wp-config.php
				 * ************************************************************************/

				// Depending on which post method was called, we update the config.php file differently

				if ( isset($_POST['save_debug_settings_changes']) ) {

					//  Get the checkbox values to prepare for updating wp-config.php

					$array_of_debug_settings = array (
						'wp_debug_constant'			=> 'WP_DEBUG',
						'wp_debug_log_constant'		=> 'WP_DEBUG_LOG',
						'wp_debug_display_constant'	=> 'WP_DEBUG_DISPLAY',
						'script_debug_constant'		=> 'SCRIPT_DEBUG',
						'savequeries_constant'		=> 'SAVEQUERIES',
					);

					foreach ($array_of_debug_settings as $html_checkbox_name => $debug_constant) {

						$result = $wp_config->update_named_constant($debug_constant, isset($_POST[$html_checkbox_name]) ? 'true' : 'false' );

						// If an error occured, then send a message
						if ($result === false) {
							$message = "Failed to update <em>$debug_constant</em>.";

							// break 2 levels up
							break 2;
						}

					}

				}

				elseif ( isset($_POST['set_debug_settings']) ) {

					$result = $wp_config->set_wp_config_with_debug_definitions();
					if ($result == false) {
						$message = "Failed to set up-config.php with debugging definitions.";
						break;
					}
				}



				/* ************************************************************************
				 * 3. Backup wp-config.php
				 * ************************************************************************/

				$result = $wp_config->backup_file();
				if ($result == false) {
					$message = "Failed to back-up wp-config.php. File is not changed.";
					break;
				}



				/* ********************************************************************
				* 3. Save modified wp-config.php
				* ********************************************************************/

				$result = $wp_config->save_file_contents();

				// If an error occured while saving
				if ($result === false) {
					$message = "Saving debug settings failed. Try to manually update <em>wp-config.php</em>.";
					break;
				}


			} while (false);



			// Adding this function is very important. It looks like WordPress takes
			// ... its time to update the values of the debug defined constants after saving
			// ... the wp-debug.php file (namely, those defined constants are WP_DEBUG,
			// ... WP_DEBUG_LOG, WP_DEBUG_DISPLAY, SCRIPT_DEBUG, and SAVEQUERIES).
			// ... So we wait few seconds after the save, to make sure the values of those
			// ... defined constants reflect the changes that we made, otherwise we end up
			// ... with the updated values in the UI
			sleep(5);



			$redirect_to_page = '';
			if ( isset($_POST['save_debug_settings_changes']) ) {
				$redirect_to_page = SLUG__SETTINGS;
			}

			elseif ( isset($_POST['set_debug_settings']) ) {
				$redirect_to_page = SLUG__LOG;
			}

			// Generate the url to be used in displaying the message
			$redirect_url = add_query_arg (

				array (
						'page'		=> $redirect_to_page,
						'update'	=> ($result == false) ? NOTICE__ERROR : NOTICE__SUCCESS,
						'message'	=> ($result == false) ? rawurlencode($message) : rawurlencode('Saving debug settings succeeded.')
				),

				admin_url('admin.php')
			);

			wp_redirect($redirect_url);
			exit;

		} // End of: if (( isset($_POST['save_debug_settings_changes']) ) || ( isset($_POST['set_debug_settings']) ) )

	} // End of: if ($_SERVER["REQUEST_METHOD"] == "POST")

}

?>