<?php

namespace gorilla_debug;
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


?>


<div class="wrap">

	<h2>Debug Settings</h2>

	<p>Make changes to the debug settings via input boxes below, then click <em>Save Changes</em>.</p>

	<form method="POST" action="">

		<label for="wp_debug_constant">
			<input type="checkbox"  name="wp_debug_constant" id="wp_debug_constant" class="debug_setting_in_wp_config" <?php if (WP_DEBUG == true) { ?> checked="checked" <?php } ?> /> WP_DEBUG
			&nbsp;<span class="description">&mdash; Enable/disable debugging</span>
		</label>
		<br/>


		<label for="wp_debug_log_constant">
			<input type="checkbox" name="wp_debug_log_constant" id="wp_debug_log_constant" class="debug_setting_in_wp_config" <?php if (WP_DEBUG_LOG == true) { ?> checked="checked" <?php } ?> /> WP_DEBUG_LOG
			&nbsp;<span class="description">&mdash; Enable/disable logging into the debug.log file</span>
		</label>
		<br/>


		<label for="wp_debug_display_constant">
			<input type="checkbox"  name="wp_debug_display_constant" id="wp_debug_display_constant" class="debug_setting_in_wp_config" <?php if (WP_DEBUG_DISPLAY == true) { ?> checked="checked" <?php } ?> /> WP_DEBUG_DISPLAY
			&nbsp;<span class="description">&mdash; Enable/disable display of errors and warnings</span>
		</label>
		<br/>


		<label for="script_debug_constant">
			<input type="checkbox" name="script_debug_constant" id="script_debug_constant" class="debug_setting_in_wp_config" <?php if (SCRIPT_DEBUG == true) { ?> checked="checked" <?php } ?> /> SCRIPT_DEBUG
			&nbsp;<span class="description">&mdash; Enable/disable use of development versions of core JS and CSS files (only needed if you are modifying these core files)</span>
		</label>
		<br/>


		<label for="savequeries_constant">
			<input type="checkbox" name="savequeries_constant" id="savequeries_constant" class="debug_setting_in_wp_config" <?php if (SAVEQUERIES == true) { ?> checked="checked" <?php } ?> /> SAVEQUERIES
			&nbsp;<span class="description">&mdash; Enable/disable displaying database queries</span>
		</label>
		<br/>
		<br/>


		<p>The debug settings in <em>wp-config.php</em> will be updated as follows:</p>
		<textarea id="debug_settings_in_wp_config" readonly></textarea>
		<br/>
		<br/>


		<input type="submit" name="save_debug_settings_changes" id="save_debug_settings_changes" class="button button-primary" value="Save Changes" />

	</form>


	<br/>
	<br/>
	<p class="description">If for any reason, after successfully saving your debug settings you notice that debug messages are not being displayed as expected, then we suggest that you try to modify your <em>wp-config.php</em> file manually.</p>

	<p class="description">The problem might be caused by block comments or line comments around the debugging defined constants, so uncomment those.</p>


</div>