<?php
/**
 * The setting functionality of the plugin
 *
 * @link       https://aarti.com
 * @since      1.0.0
 *
 * @package    Wp_Autocomplete
 * @subpackage Wp_Autocomplete/admin/includes
 */

/**
 *
 * @package    Wp_Autocomplete
 * @subpackage Wp_Autocomplete/admin/includes
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
        add_menu_page(__('WP Autocomplete', 'wp_autocomplete'), __('WP Autocomplete', 'wp_autocomplete'), 'manage_options', 'autocomplete-settings', array($this, 'wp_autocomplete_settings_callback'));
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
			<h1><?php _e('Autocomplete', 'wp_autocomplete');?></h1>
			<p><?php _e('The autocomplete feature adds a find-as-you-type dropdown menu to your search bar.', 'wp_autocomplete');?></p>
			<?php
			if(isset($_POST['submit']) && $_POST['submit'] != ""){
			
				update_option('wpauto_enable_type',$_POST['wpauto_enable_type']);
				foreach($_POST['wpauto_enable_type'] as $key => $type){
					// $label = $type.'type';
					// $suggesion = $type.'suggesion';
					update_option('wpauto_'.$type.'_type_label',$_POST['wpauto_'.$type.'_type_label']);
					update_option('wpauto_'.$type.'_suggestion',$_POST['wpauto_'.$type.'_suggestion']);
				}
			}
			$post_types = get_post_types( array( 'exclude_from_search' => false ), 'objects' );
			
			?>
			<form method="post" action="" novalidate="novalidate">
				<table class="config-div" cellpadding="10">
					<tr>
						<td><h4><?php _e('Configuration', 'wp_autocomplete');?></h4></td>
						<td>
							<table class="config-div-inner" cellpadding="5">
								<tr>
									<th><h4><?php _e('Enable', 'wp_autocomplete');?></h4></th>
									<th><h4><?php _e('Type', 'wp_autocomplete');?></h4></th>
									<th><h4><?php _e('Label', 'wp_autocomplete');?></h4></th>
									<th><h4><?php _e('Max. Suggestions', 'wp_autocomplete');?></h3></th>
								</tr>
								<tr>
									<td colspan="4"><hr></td>
								</tr>
								<?php 
								foreach($post_types as $key => $type) {  if( $key == "attachment" ) continue;?>
								<tr>
									<td><input type="checkbox" name="wpauto_enable_type[]" value="<?php echo $key;?>" <?php echo in_array($key, get_option('wpauto_enable_type')) ? 'checked' : ''; ?> >
									</td>
									<td><?php _e($type->label, 'wp_autocomplete');?></td>
									<td><input type="text" value="<?php _e((get_option('wpauto_'.$key.'_type_label'))? get_option('wpauto_'.$key.'_type_label'): $type->label);?>" name="<?php echo 'wpauto_'.$key.'_type_label';?>"></td>
									<td><input style="width:28%" type="number" value="<?php _e((get_option('wpauto_'.$key.'_suggestion'))? get_option('wpauto_'.$key.'_suggestion'): "5");?>" name="<?php echo 'wpauto_'.$key.'_suggestion';?>" max="5" min="1"></td>
								</tr>
								<?php } ?>
								<!-- <tr>
									<td><input type="checkbox" name="wpauto_enable_type[]" value="page" <?php echo in_array("page", get_option('wpauto_enable_type')) ? 'checked' : ''; ?> ></td>
									<td><?php _e('Pages', 'wp_autocomplete');?></td>
									<td><input type="text" value="<?php _e((get_option('wpauto_page_type_label'))?get_option('wpauto_page_type_label'):"Pages");?>" name="wpauto_page_type_label"></td>
									<td ><input style="width:28%" type="number" value="<?php _e((get_option('wpauto_page_suggestion'))? get_option('wpauto_page_suggestion'): "5");?>" name="wpauto_page_suggestion" max="5" min="1"></td>
								</tr>
								<tr>
									<td><input type="checkbox" name="wpauto_enable_type[]" value="product"  <?php echo in_array("product", get_option('wpauto_enable_type')) ? 'checked' : ''; ?>></td>
									<td><?php _e('Products', 'wp_autocomplete');?></td>
									<td><input type="text" value="<?php _e((get_option('wpauto_product_type_label')) ? get_option('wpauto_product_type_label'): "Products");?>" name="wpauto_product_type_label"></td>
									<td ><input style="width:28%" type="number" value="<?php _e((get_option('wpauto_product_suggestion'))? get_option('wpauto_product_suggestion'): "5");?>" name="wpauto_product_suggestion" max="5" min="1"></td>
								</tr> -->
							</table>
						</td>
					</tr>
				</table>
				<div class="sumit-btn">
				<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
				</div>
			</form>
		</div>
	<?php 
	}
	
}