<?php
/**
 * The setting functionality of the plugin
 *
 * @link       https://aarti.com
 * @since      1.0.0
 *
 * @package    Autocomplete_Search
 * @subpackage Autocomplete_Search/admin/includes
 */

/**
 *
 * @package    Autocomplete_Search
 * @subpackage Autocomplete_Search/admin/includes
 * @author     Aarti <chauhan.aarti13@gmail.com>
 */
class Wp_Autocomplete_Settings {

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
	 * create_menu the function to show the settings
	 *
	 * @since    1.0.0
	 */
    public function create_menu() {
        add_menu_page(__('Autocomplete Search', 'autocomplete-search'), __('Autocomplete Search', 'autocomplete-search'), 'manage_options', 'autocomplete-settings', array($this, 'wp_autocomplete_settings_callback'));
        // add_submenu_page('bcp-settings', __('Settings', 'wp_autocomplete'), __('Settings', 'wp_autocomplete'), 'manage_options', 'bcp-settings', array($this, 'bcp_settings_callback'));
        // add_submenu_page('bcp-settings', __('Manage Pages', 'wp_autocomplete'), __('Manage Pages', 'wp_autocomplete'), 'manage_options', 'bcp-filter-pages', array($this, 'bcp_filter_pages_callback'));

		
    }

	/**
	 * create_menu the function to show the settings
	 *
	 * @since    1.0.0
	 */

	public function wp_autocomplete_settings_callback() { ?>
		<div class="wrap">
			<h1><?php esc_html_e('Autocomplete', 'autocomplete-search');?></h1>
			<p><?php esc_html_e('The autocomplete feature adds a find-as-you-type dropdown menu to your search bar.', 'autocomplete-search');?></p>
			<?php
			if (isset($_POST['submit']) && !empty($_POST['submit'])) { 
				if (isset($_REQUEST['submit_form']) && wp_verify_nonce(sanitize_text_field(wp_unslash($_REQUEST['submit_form'])), 'form_action')) { 
					if (isset($_POST['wpauto_enable_type'])) {
						update_option('wpauto_enable_type', array_map('sanitize_text_field', wp_unslash($_POST['wpauto_enable_type'])));
					//	$enable_types = sanitize_text_field(wp_unslash($_POST['wpauto_enable_type']));
						foreach ((array)$_POST['wpauto_enable_type'] as $type) {
							$type_label = 'wpauto_' . $type . '_type_label';
							$type_suggestion = 'wpauto_' . $type . '_suggestion';
							
							if (isset($_POST[$type_label])) {
								update_option($type_label, sanitize_text_field(wp_unslash($_POST[$type_label])));
							}
							if (isset($_POST[$type_suggestion])) {
								update_option($type_suggestion, absint($_POST[$type_suggestion]));
							}
						}
					}
					add_settings_error(
						'', // No group name specified
						'my_plugin_notice',   // Unique error code
						'Settings saved successfully!', // The message
						'updated' // Message type ('updated' or 'error')
					);
					settings_errors();
				}
			}
			
			$post_types = get_post_types( array( 'exclude_from_search' => false ), 'objects' );
			
			?>
			<form method="post" action="" novalidate="novalidate">
				<table class="config-div" cellpadding="10">
					<tr>
						<td><h4><?php esc_html_e('Configuration', 'autocomplete-search');?></h4></td>
						<td>
							<table class="config-div-inner" cellpadding="5">
								<tr>
									<th><h4><?php esc_html_e('Enable', 'autocomplete-search');?></h4></th>
									<th><h4><?php esc_html_e('Type', 'autocomplete-search');?></h4></th>
									<th><h4><?php esc_html_e('Label', 'autocomplete-search');?></h4></th>
									<th><h4><?php esc_html_e('Max. Suggestions', 'autocomplete-search');?></h3></th>
								</tr>
								<tr>
									<td colspan="4"><hr></td>
								</tr>
								<?php 
								foreach($post_types as $key => $type) {  if( $key == "attachment" ) continue;?>
								<tr>
								<td>
									<input type="checkbox" name="wpauto_enable_type[]" value="<?php echo esc_attr($key); ?>" 
									<?php echo in_array($key, (array) get_option('wpauto_enable_type', [])) ? 'checked' : ''; ?>>
								</td>
									<td><?php echo esc_attr($type->label, 'autocomplete-search');?></td>
									<td><input type="text" value="<?php echo esc_attr((get_option('wpauto_'.$key.'_type_label'))? get_option('wpauto_'.$key.'_type_label'): $type->label,'autocomplete-search');?>" name="<?php echo esc_attr('wpauto_'.$key.'_type_label', 'autocomplete-search'); ?>"></td>
									<td><input style="width:28%" type="number" value="<?php echo esc_attr((get_option('wpauto_'.$key.'_suggestion'))? get_option('wpauto_'.$key.'_suggestion'): "5",'autocomplete-search');?>" name="<?php echo esc_attr('wpauto_'.$key.'_suggestion', 'autocomplete-search'); ?>" max="5" min="1"></td>
								</tr>
								<?php } ?>
								<!-- <tr>
									<td><input type="checkbox" name="wpauto_enable_type[]" value="page" <?php echo in_array("page", get_option('wpauto_enable_type')) ? 'checked' : ''; ?> ></td>
									<td><?php esc_html_e('Pages', 'autocomplete-search');?></td>
									<td><input type="text" value="<?php esc_html((get_option('wpauto_page_type_label'))?get_option('wpauto_page_type_label'):"Pages",'autocomplete-search');?>" name="wpauto_page_type_label"></td>
									<td ><input style="width:28%" type="number" value="<?php esc_html((get_option('wpauto_page_suggestion'))? get_option('wpauto_page_suggestion'): "5",'autocomplete-search');?>" name="wpauto_page_suggestion" max="5" min="1"></td>
								</tr>
								<tr>
									<td><input type="checkbox" name="wpauto_enable_type[]" value="product"  <?php echo in_array("product", get_option('wpauto_enable_type')) ? 'checked' : ''; ?>></td>
									<td><?php esc_html_e('Products', 'autocomplete-search');?></td>
									<td><input type="text" value="<?php esc_html((get_option('wpauto_product_type_label')) ? get_option('wpauto_product_type_label'): "Products",'autocomplete-search');?>" name="wpauto_product_type_label"></td>
									<td ><input style="width:28%" type="number" value="<?php esc_html((get_option('wpauto_product_suggestion'))? get_option('wpauto_product_suggestion'): "5",'autocomplete-search');?>" name="wpauto_product_suggestion" max="5" min="1"></td>
								</tr> -->
							</table>
						</td>
					</tr>
				</table>
				<div class="sumit-btn">
					<?php wp_nonce_field('form_action', 'submit_form'); ?>
				<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
				</div>
			</form>
		</div>
	<?php
	}
	
}