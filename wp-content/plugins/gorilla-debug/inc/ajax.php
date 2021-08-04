<?php

namespace gorilla_debug;
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


// Get debug.log content
function get_debug_log_content () {

	$result = array ();


	$debug_log = new Debug_Log_Manager();

	if ($debug_log->is_successful_initialization() == false) {

		$result['status'] = 'failure';
		$result['message'] = 'Unable to access <em>debug.log</em>. Please refresh. If the message persists, try to reinstall the latest <em>Gorilla Debug</em> plugin.';
	}

	else {

		$result['status'] = 'success';
		$result['message'] = 'Opened <em>debug.log</em> successfully';
		$result['content'] = $debug_log->get_contents();
	}

	wp_send_json($result);

}


// Set debug.log content
function set_debug_log_content () {

	$data = $_REQUEST['data'];

	$result = array ();


	$debug_log = new Debug_Log_Manager();

	if ($debug_log->is_successful_initialization() == false) {

		$result['status'] = 'failure';
		$result['message'] = "Unable to access <em>debug.log</em>. Please refresh. If the message persists, try to reinstall the latest <em>Gorilla Debug</em> plugin.";
	}

	else {

		$debug_log->set_contents($data);
		$saved = $debug_log->save_file_contents();

		if ($saved === false) {

			$result['status'] = 'failure';
			$result['message'] = 'Unable to save <em>debug.log</em>.';
		}

		else {

			$result['status'] = 'success';
			$result['message'] = 'Saved <em>debug.log</em> successfully.';
		}

	}

	wp_send_json($result);

}

?>