<?php

namespace gorilla_debug;
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );





// First, read the wp-config.php file
$wp_config = new WP_Config_Manager();


if ($wp_config->is_successful_initialization() == false) {
	?>
	<div class="notice notice-error is-dismissible">
		<p>Unable to access <em>wp-config.php</em>. Please refresh. If the message persists, try to reinstall the latest <em>Gorilla Debug</em> plugin.</p>
	</div>
	<?php
}

?>

<div class="wrap">

	<h2>Gorilla Debug Setup</h2>

	<p>Unfortunately, setting up <em>wp-config.php</em> to allow the <em>Gorilla Debug</em> plugin to work was not successful.</p>

	<p>There are multiple reasons why this may have happeed. It could be that <em>wp-config.php</em> is write-protected, or it could be something else. Whatever the cause may be, you can update <em>wp-config.php</em> in one of two methods.</p>

	<br />
	<h4>Method 1</h4>

	<form method="POST" action="">

		<p>By clicking on the <em>Set Debug Settings</em> button, you attempt to modify <em>wp-config.php</em> to include the debug settings.</p>

		<input type="submit" name="set_debug_settings" id="set_debug_settings" class="button button-primary" value="Set Debug Settings" />
	</form>


	<br />
	<h4>Method 2</h4>

	<p>If the first method does not work, you can manually update <em>wp-config.php</em>.</p>

	<p><b>Please backup <em>wp-config.php</em> before modifying it.</b></p>

	<p>To update <em>wp-config.php</em>, replace its content with the following:</p>

	<textarea id="contents_of_wp_config" readonly><?php echo ($wp_config->is_successful_initialization() == true) ? $wp_config->get_contents() : ''; ?></textarea>

</div>