<?php
/**
 * The shortcode functionality of the plugin
 *
 * @link       https://aarti.com
 * @since      1.0.0
 *
 * @package    Wp_Autocomplete
 * @subpackage Wp_Autocomplete/includes
 */

/**
 *
 * @package    Wp_Autocomplete
 * @subpackage Wp_Autocomplete/includes
 * @author     Aarti <chauhan.aarti13@gmail.com>
 */
class Wp_Autocomplete_Shortcodes {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}
	/**
	 * wp_autocomplete_callback the function to denfinr the [wp_autocomplete] shortcode.
	 *
	 * @since    1.0.0
	 * @param      string    $atts       The attributes for the shortcode.
	 * @param      string    $content    The content of the shortcode.
	 */
	public function wp_autocomplete_callback( $atts, $content = '' ) {
		?>
		<div class="site-search ajax-search">
			<div class="widget widget_search">
				<div class="ajax-search-result d-none"></div>
				<form role="search" method="get" class="wp-search" action="">
					<label class="screen-reader-text" for="wp-search-field-1">Search for:</label>
					<input type="search" id="wp-search-field-1" class="search-field" placeholder="I’m searching for…" autocomplete="off" value="" name="s">
					<button type="submit" value="Search">Search</button>
					<input type="hidden" name="post_type" value="product">

				</form>
				</div>
			</div>
		<?php
		$content .= ob_get_clean();

        return $content;
	}
}