<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://profiles.wordpress.org/aarti1318/
 * @since      1.0.0
 *
 * @package    Autocomplete_Search
 * @subpackage Autocomplete_Search/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Autocomplete_Search
 * @subpackage Autocomplete_Search/includes
 * @author     Aarti Chauhan <chauhan.aarti13@gmail.com>
 */
class Atcl_Autocomplete_Search_Deactivator {

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
			$atcl_autosearch_enable_type[] = $key;
			delete_option('atcl_autosearch_'.$key.'_type_label');
			delete_option('atcl_autosearch_'.$key.'_suggestion');
		}
		delete_option('atcl_autosearch_enable_type');
	}

}
