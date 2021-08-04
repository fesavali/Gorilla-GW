<?php

namespace gorilla_debug;
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


// This function is used to load CSS
function load_styles_and_scripts ($hook_suffix) {

	// Only load the scripts and CSS files if we are in the correct page
	if ($hook_suffix == 'toplevel_page_' . SLUG__LOG) :

		// Load the Code Mirror Styles file
		wp_register_style('gorilla-codemirror-style',
			plugins_url(DIRECTORY_SEPARATOR . 'vendors' . DIRECTORY_SEPARATOR . 'codemirror' . DIRECTORY_SEPARATOR . 'codemirror.css', dirname(__FILE__))
		);

		wp_enqueue_style('gorilla-codemirror-style');


		// Load CSS styles file
		wp_register_style('gorilla-debug-style',
			plugins_url(DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'style.css', dirname(__FILE__)),
			array('gorilla-codemirror-style')
		);
		wp_enqueue_style('gorilla-debug-style');




		// Load the Code Mirror script
		wp_register_script('gorilla-codemirror-script',
			plugins_url(DIRECTORY_SEPARATOR . 'vendors' . DIRECTORY_SEPARATOR . 'codemirror' . DIRECTORY_SEPARATOR . 'codemirror.js', dirname(__FILE__))
		);

		wp_enqueue_script('gorilla-codemirror-script');



		// // Load the Code Mirror script
		wp_register_script('gorilla-debug-log-script',
			plugins_url(DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'page-log.js', dirname(__FILE__)),
			array('jquery', 'gorilla-codemirror-script')
		);

		wp_enqueue_script('gorilla-debug-log-script');


	elseif ($hook_suffix == sanitize_title_with_dashes (PAGE_TITLE__GORILLA_DEBUG) . '_page_' . SLUG__SETTINGS) :

		// Load CSS styles file
		wp_register_style('gorilla-debug-settings-page-style',
			plugins_url(DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'style.css', dirname(__FILE__))
		);
		wp_enqueue_style('gorilla-debug-settings-page-style');



		// Load the jQuery script that is needed for our work
		wp_register_script('gorilla-debug-settings-page-script',
			plugins_url(DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'page-settings.js', dirname(__FILE__)),
			array('jquery')
		);

		wp_enqueue_script('gorilla-debug-settings-page-script');

	endif;

}


?>