=== Gorilla Debug ===
Contributors: Gorilla Solutions
Tags: Debug, Debugging, Development
Requires at least: 5.7
Tested up to: 5.7
Stable tag: 1.0.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Gorilla Debug is a simple WordPress plugin. It is geared towards helping programmers with the development of WordPress themes and plugins. It has three main features (so far)!

== Description ==

Using this simple plugin, you can update `wp-config.php` by setting the PHP named constants used for WordPress debugging via a simple UI. Those named constants are `WP_DEBUG`, `WP_DEBUG_LOG`, `WP_DEBUG_DISPLAY`, `SCRIPT_DEBUG`, and `SAVEQUERIES`.

This plugin also allows you to view and edit the `debug.log` file from within the WP Admin panel, without the need to access this file directly through the file system.

Moreover, this plugin introduces a debugging function, `gorilla_debug()`, that allows you to output debugging messages to either the display or the `debug.log` file.

*This plugin is intended for development purposes only*

For full documentation, visit https://debug.gorilla.solutions and https://debug.gorilla.wtf

== Installation ==

You can install `Gorilla Debug` in any one of the following ways

**From your WordPress dashboard**

1. Visit `Plugins -> Add New`
2. Search for `Gorilla Debug`
3. Activate `Gorilla Debug` from your Plugins page.

**From WordPress.org**

1. Download `Gorilla Debug`
2. Upload the `gorilla-debug` directory to your `/wp-content/plugins/` directory
3. Activate `Gorilla Debug` from your Plugins page.

**If the plugin cannot be activated**

If you were unable to activate the plugin, it is most probably due to file protection and permissions set to protect `wp-config.php`. If this happens, then you will be instructed to activate manually.

Remember, this plugin is for development purposes only, and if you decide to change file permissions to change the access privileges for `wp-config.php`, then it is better to do so in a secure development environment. If you need to use this plugin in a live environment, and you change your file permissions to allow this plugin to work, then you have to ensure that `wp-config.php` is protected again after you finish using this plugin.

**Once Activated**

1. Access `Gorilla Debug` from the WP Admin panel, and then click on `Settings` (i.e., 'Gorilla Debug -> Settings`).
2. Change the debug settings to your preferences. The bottom section shows the settings changes that will be made to `wp-config.php`.
3. Click `Save Changes` to save the settings.

Visit https://debug.gorilla.solutions for documentation on how to use this plugin.

== Screenshots ==

1. The settings page for the Gorilla Debug plugin
2. An example of using the `gorilla_debug()` function
3. The output of the `gorilla_debug()` function call into `debug.log`

== Changelog ==

= 1.0.0 =
* Added functionality to edit debug.log from within the WP Admin panel

= 0.1.0 =
* Initial release