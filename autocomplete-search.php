<?php
/**
 * Plugin Name:       Autocomplete Search
 * Description:       Easily add an autocomplete search feature to your WordPress site. Search across posts, pages, and WooCommerce products with a fast, AJAX-powered search box. [atcl_autocomplete_search]
 * Version:           1.0.0
 * Requires PHP:      7.2
 * Author:            Aarti Chauhan
 * Author URI:          https://profiles.wordpress.org/aarti1318/
 * Contributors:      aarti1318
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       autocomplete-search
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (! defined('WPINC') ) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('ATCL_AUTOCOMPLETE_SEARCH_VERSION', '1.0.0');
define('ATCL_IMAGES_URL', plugins_url('/autocomplete-search/public/images/', dirname(__FILE__)));
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-autocomplete-search-activator.php
 */
if (! function_exists('atcl_activate_autocomplete_search') ) {
    function Atcl_activate_autocomplete_search()
    {
        include_once plugin_dir_path(__FILE__) . 'includes/class-autocomplete-search-activator.php';
        Atcl_Autocomplete_Search_Activator::activate();
    }
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-autocomplete-search-deactivator.php
 */
if (! function_exists('atcl_deactivate_autocomplete_search') ) {
    function atcl_deactivate_autocomplete_search()
    {
        include_once plugin_dir_path(__FILE__) . 'includes/class-autocomplete-search-deactivator.php';
        Atcl_Autocomplete_Search_Deactivator::deactivate();
    }
}

register_activation_hook(__FILE__, 'atcl_activate_autocomplete_search');
register_deactivation_hook(__FILE__, 'atcl_deactivate_autocomplete_search');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-autocomplete-search.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 */
if (! function_exists('atcl_run_autocomplete_search') ) {
    function atcl_run_autocomplete_search()
    {
        $plugin = new Atcl_Autocomplete_Search();
        $plugin->run();

    }
}
atcl_run_autocomplete_search();
