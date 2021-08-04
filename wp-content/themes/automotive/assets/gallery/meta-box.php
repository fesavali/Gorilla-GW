<?php
/**
 * Create meta box for editing pages in WordPress
 *
 * Compatible with custom post types since WordPress 3.0
 * Support input types: text, textarea, checkbox, checkbox list, radio box, select, wysiwyg, file, image, date, time, color
 *
 * @author Rilwis 
 * 
 * @license GNU General Public License v3.0
 */

/**
 * Meta Box class
 */
	function enqueue_js(){
			// make upload feature works even when custom post type doesn't support 'editor'
		wp_enqueue_script('media-upload');
		add_thickbox();
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-sortable');
	}
	add_action('wp_enqueue_scripts','enqueue_js');
?>