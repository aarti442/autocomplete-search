<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://aarti.com
 * @since      1.0.0
 *
 * @package    Autocomplete_Search
 * @subpackage Autocomplete_Search/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Autocomplete_Search
 * @subpackage Autocomplete_Search/includes
 * @author     Aarti <chauhan.aarti13@gmail.com>
 */
class Wp_Autocomplete_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'autocomplete-search',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
