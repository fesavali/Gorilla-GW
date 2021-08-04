<?php

namespace gorilla_debug;
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class File_Manager {


	protected  $init_success = false;

	protected  $directory = "";
	protected  $file = "";
	protected  $contents = "";



	// Constructor, setup initial values
	function __construct($file_name) {

		$this->directory = __DIR__;

		do {
			if (file_exists($this->directory . DIRECTORY_SEPARATOR . $file_name)) {

				$this->file = $this->directory . DIRECTORY_SEPARATOR . $file_name;
				$this->contents = file_get_contents ($this->file);

				$this->init_success = true;
				return;
			}
		} while ($this->directory = realpath($this->directory . DIRECTORY_SEPARATOR . '..'));

		$this->init_success = false;
	}



	// Make a backup copy of the file
	public function backup_file () {
		$backup_file = $this->file . '.gorilla_debug.bak';
		$result = copy ($this->file, $backup_file);
		return $result;
	}


	// Get the contents
	public function get_contents () {
		return $this->contents;
	}


	// Function to check if the constructor initialized successfully
	public function is_successful_initialization () {
		return $this->init_success;
	}


	// Save to file
	public function save_file_contents () {
		$result = file_put_contents($this->file, $this->contents);
		return $result;
	}


	// Set the contents
	public function set_contents ($new_contents) {
		$this->contents = $new_contents;
	}


}

?>