<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://aarti.com
 * @since             1.0.0
 * @package           Wp_Autocomplete
 *
 * @wordpress-plugin
 * Plugin Name:       WP Autocomplete
 * Plugin URI:        https://wpautocomplete.com
 * Description:       The autocomplete feature adds a find-as-you-type dropdown menu to your search bar.
 * Version:           1.0.0
 * Author:            Aarti
 * Author URI:        https://aarti.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-autocomplete
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_AUTOCOMPLETE_VERSION', '1.0.0' );
define('WP_IMAGES_URL', plugins_url('/wp-autocomplete/public/images/', dirname(__FILE__)));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-autocomplete-activator.php
 */
function activate_wp_autocomplete() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-autocomplete-activator.php';
	Wp_Autocomplete_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-autocomplete-deactivator.php
 */
function deactivate_wp_autocomplete() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-autocomplete-deactivator.php';
	Wp_Autocomplete_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_autocomplete' );
register_deactivation_hook( __FILE__, 'deactivate_wp_autocomplete' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-autocomplete.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_autocomplete() {

	$plugin = new Wp_Autocomplete();
	$plugin->run();

}
run_wp_autocomplete();
