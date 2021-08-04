<?php

namespace gorilla_debug;
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class Debug_Log_Manager extends File_Manager {

	// Constructor (call parent constructor)
	function __construct() {

		// Initial values
		$file_name = 'debug.log';

		$this->directory = WP_CONTENT_DIR;
		$this->file = $this->directory . DIRECTORY_SEPARATOR . $file_name;

		// If debug.log does not exist, then create it
		if (!file_exists($this->file)) {

			$fileHandle = fopen($this->file, 'w') or die("can't open file");
			fclose($fileHandle);
		}

		// Load debug.log
		$this->contents = file_get_contents ($this->file);
		$this->init_success = true;
	}

}

?>