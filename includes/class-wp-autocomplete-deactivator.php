<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://aarti.com
 * @since      1.0.0
 *
 * @package    Wp_Autocomplete
 * @subpackage Wp_Autocomplete/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wp_Autocomplete
 * @subpackage Wp_Autocomplete/includes
 * @author     Aarti <chauhan.aarti13@gmail.com>
 */
class Wp_Autocomplete_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		$post_types = get_post_types( array( 'exclude_from_search' => false ), 'objects' );
		foreach($post_types as $key => $type) {  if( $key == "attachment" ) continue;
			$wpauto_enable_type[] = $key;
			delete_option('wpauto_'.$key.'_type_label');
			delete_option('wpauto_'.$key.'_suggestion');
		}
		delete_option('wpauto_enable_type');
	}

}
