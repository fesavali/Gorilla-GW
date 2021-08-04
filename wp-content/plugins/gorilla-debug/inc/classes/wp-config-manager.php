<?php

namespace gorilla_debug;
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class WP_Config_Manager extends File_Manager {

	// Constructor (call parent constructor)
	function __construct() {
		parent::__construct('wp-config.php');
	}



	// This function generates the regex patter that is used to find the named constants in config.php
	private function generate_regex_pattern ($named_constant) {

		// The following definisions are patterns used for preg_match and preg_replace

		// Explanation of pattern:
		//  1. Start and end delimiters are the "/"
		//  2. Find if there are a bunch of characters before our pattern -----? .*
		//  3. Then, find the word "define"
		//  4. Then, there can be 0 or more white spaces ---->   \s*
		//  5. Then there is an open braket ---->   \(
		//  6. Then, there can be 0 or more white spaces ---->   \s*
		//  7. Then choose either a single or a double quote
		//  8. Then there is the word WP_DEBUG (or WP_DEBUG_LOG, WP_DEBUG_DISPLAY, SCRIPT_DEBUG or SAVEQUERIES)
		//  9. Then choose either a single or a double quote
		// 10. Then, there can be 0 or more white spaces ---->   \s*
		// 11. Thenthere is a comma ---->   ,
		// 12. Then, there can be 0 or more white spaces ---->   \s*
		// 13. The there is a buch of characters (to account for true, false, TRUE, FALSE, 0, 1 etc.) ---->   .*
		// 14. Then, there can be 0 or more white spaces ---->   \s*
		// 15. Then there is an closed braket ---->   \)
		// 16. Then, there can be 0 or more white spaces ---->   \s*
		// 17. Then there is a semi-colon ---->   ;
		// 18. Then we check if there is a carriage return or a new line (this may or may not exist) ---->     [\r?\n]?
		// 19. The whole regex is case insensitive (the letter "i" at the end of the expression)

		$pattern = '/.*define\s*\(\s*["|\']' . $named_constant . '["|\']\s*,\s*.*\s*\)\s*;[\r?\n]?/i';
		return $pattern;
	}



	// Find a named constant in wp-config.php
	public function find_named_constant ($named_constant) {
		$found = preg_match ($this->generate_regex_pattern($named_constant), $this->contents);
		return $found;
	}



	// Update the value of a named constant in wp-config.php
	public function update_named_constant ($named_constant, $value) {

		$result = preg_replace ($this->generate_regex_pattern($named_constant), "define('$named_constant', $value);\n" , $this->contents);

		if ($result == null) {
			return false;
		}

		else {
			$this->contents = $result;
			return true;
		}

	}



	// Add the debug variables to wp-config.php
	public function set_wp_config_with_debug_definitions () {


		// The params we are after are WP_DEBUG, WP_DEBUG_LOG, WP_DEBUG_DISPLAY, SCRIPT_DEBUG and SAVEQUERIES

		// For each of the parameters above, find out if any can be found in wp-config.php
		$found_WP_DEBUG = $this->find_named_constant('WP_DEBUG');
		$found_WP_DEBUG_LOG = $this->find_named_constant('WP_DEBUG_LOG');
		$found_WP_DEBUG_DISPLAY = $this->find_named_constant('WP_DEBUG_DISPLAY');
		$found_SCRIPT_DEBUG = $this->find_named_constant('SCRIPT_DEBUG');
		$found_SAVEQUERIES = $this->find_named_constant('SAVEQUERIES');



		// If for some reason, finding a pattern caused a error, so therefore we have to set it up manually.
		// Note that false means there is an error, but a 0 means item not found. We are checking for errors
		if (($found_WP_DEBUG === false) ||
			($found_WP_DEBUG_LOG === false) ||
			($found_WP_DEBUG_DISPLAY === false) ||
			($found_SCRIPT_DEBUG === false) ||
			($found_SAVEQUERIES === false)) {

			// Returning null will eventually lead to manual setup instructions page
			return false;
		}



		// Build the replacement string
		$replacement = "define('WP_DEBUG', true);";
		$replacement = $replacement . "\n";
		$replacement = $replacement . "define('WP_DEBUG_LOG', true);";
		$replacement = $replacement . "\n";
		$replacement = $replacement . "define('WP_DEBUG_DISPLAY', false);";
		$replacement = $replacement . "\n";
		$replacement = $replacement . "define('SCRIPT_DEBUG', false);";
		$replacement = $replacement . "\n";
		$replacement = $replacement . "define('SAVEQUERIES', true);";
		$replacement = $replacement . "\n";



		// We will start by removing every debug definition that is already in the file, except WP_DEBUG
		// .. i.e.  keep the WP_DEBUG line, but remove WP_DEBUG_LOG, WP_DEBUG_DISPLAY, SCRIPT_DEBUG and SAVEQUERIES lines

		if ($found_WP_DEBUG_LOG == 1) {
			$this->contents = preg_replace ($this->generate_regex_pattern('WP_DEBUG_LOG'), "" , $this->contents);
		}

		if ($found_WP_DEBUG_DISPLAY == 1) {
			$this->contents = preg_replace ($this->generate_regex_pattern('WP_DEBUG_DISPLAY'), "" , $this->contents);
		}

		if ($found_SCRIPT_DEBUG == 1) {
			$this->contents = preg_replace ($this->generate_regex_pattern('SCRIPT_DEBUG'), "" , $this->contents);
		}

		if ($found_SAVEQUERIES == 1) {
			$this->contents = preg_replace ($this->generate_regex_pattern('SAVEQUERIES'), "" , $this->contents);
		}



		// At this point, only WP_DEBUG should be left in the wp-config.php file.
		// If WP_DEBUG exists on the file, the we replace it with the debug parameters, otherwise, we add the debug parameters to the end of the file

		// Check for WP_DEBUG
		if ($found_WP_DEBUG == 1) {
			// Replace the existing WP_DEBUG line with the output
			$this->contents = preg_replace ($this->generate_regex_pattern('WP_DEBUG'),  $replacement, $this->contents);
		}

		else { // ($found_WP_DEBUG == 0)
			// Append to end of file
			$this->contents = $this->contents . "\n\n" . $replacement;
		}


		return true;

	}


}

?>