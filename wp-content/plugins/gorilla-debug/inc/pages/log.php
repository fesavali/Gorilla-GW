<?php

namespace gorilla_debug;
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


// Open and read debug.log

// First, read the debug.log file
$debug_log = new Debug_Log_Manager();

if ($debug_log->is_successful_initialization() == false) {

	?>
	<div class="notice notice-error is-dismissible">
		<p>Unable to access <em>debug.log</em>. Please refresh. If the message persists, try to reinstall the latest <em>Gorilla Debug</em> plugin.</p>
	</div>
	<?php

}

?>

<div class="wrap">

	<h2 id="title">Debug Log</h2>

	<p>Output of <em>debug.log</em>.</p>

	<p>
		<button id="reload" class="button button-primary">Reload</button>
		<button id="save" class="button button-primary">Save</button>
	</p>

	<textarea id="debug_log"><?php // echo $content; ?></textarea>

</div>