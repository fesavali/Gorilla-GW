<?php

namespace gorilla_debug;
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


// Values to use in the "update" paramenter of the url
const NOTICE__ERROR		= 0;
const NOTICE__WARNING	= 1;
const NOTICE__SUCCESS	= 2;
const NOTICE__INFO		= 3;


// Page titles (also used as menu titles)
const PAGE_TITLE__GORILLA_DEBUG		= 'Gorilla Debug';
const PAGE_TITLE__DEBUG_LOG			= 'Debug Log';
const PAGE_TITLE__DEBUG_SETTINGS	= 'Settings';


// Slugs
const SLUG__LOG			= 'gorilla-debug-log-page';
const SLUG__SETTINGS	= 'gorilla-debug-settings-page';



?>