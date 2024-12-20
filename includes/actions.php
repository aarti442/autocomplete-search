<?php
/**
 * The action functionality of the plugin
 *
 * @link  https://profiles.wordpress.org/aarti1318/
 * @since 1.0.0
 *
 * @package    Autocomplete_Search
 * @subpackage Autocomplete_Search/includes
 */

/**
 *
 * @package    Autocomplete_Search
 * @subpackage Autocomplete_Search/includes
 * @author     Aarti Chauhan <chauhan.aarti13@gmail.com>
 */
class Atcl_Autocomplete_Actions
{

    /**
     * The ID of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since  1.0.0
     * @access private
     * @var    string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since 1.0.0
     * @param string $plugin_name The name of the plugin.
     * @param string $version     The version of this plugin.
     */
    public function __construct( $plugin_name, $version )
    {
        
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    /**
     * atcl_autocomplete_search the function to show the search result
     *
     * @since 1.0.0
     * @param string $atts    The attributes for the shortcode.
     * @param string $content The content of the shortcode.
     */
    public function atcl_autocomplete_search()
    {
        // Sanitize the search input

        if (!isset($_POST['security']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['security'])), 'autocomplete_search_nonce')) {
            wp_send_json_error('Invalid nonce');
            die();
        }
            
        $search_value = isset($_POST['search_input']) ? sanitize_text_field(wp_unslash($_POST['search_input'])) : '';
        if (empty($search_value)) {
            exit;
        }
        
            // Get enabled post types and their respective post limits
            $atcl_autosearch_enable_type = get_option('atcl_autosearch_enable_type', []);
        
        
        foreach ($atcl_autosearch_enable_type as $type) {
            $post_limits[$type] = get_option('atcl_autosearch_'.$type.'_suggestion');
        }
        if (empty($atcl_autosearch_enable_type)) {
            echo '<div class="no-result">No post types enabled for search.</div>';
            exit;
        }
        
            // Dynamically initialize $grouped_content based on enabled post types
            $grouped_content = [];
        foreach ($atcl_autosearch_enable_type as $type) {
            $grouped_content[$type] = [];
                
            // Set the posts_per_page for each post type based on custom limits
            $posts_per_page = isset($post_limits[$type]) ? $post_limits[$type] : 5; // Default to 5 if not specified
        
            // Query for post IDs matching the search term for each type
            $args = array(
            's' => $search_value,
            'post_type' => $type,
            'posts_per_page' => $posts_per_page,
            'fields' => 'ids', // Only get post IDs
            'no_found_rows' => true, // Skip total row count
            'update_post_meta_cache' => false, // Skip post meta cache
            'update_post_term_cache' => false, // Skip term cache
            );
                
            $post_ids = get_posts($args);
        
            if (!empty($post_ids)) {
                // Fetch full post data for found post IDs
                $all_posts = get_posts(
                    array(
                    'post__in' => $post_ids,
                    'post_type' => $type,
                    'posts_per_page' => -1,
                    'orderby' => 'post__in', // Preserve order by ID
                    'no_found_rows' => true, // No need to count total rows
                    )
                );
        
                // Loop through fetched posts and group them by post type
                foreach ($all_posts as $post) {
                    setup_postdata($post);
        
                    $post_id = $post->ID;
                    $post_title = esc_html(get_the_title($post_id));
                    $post_link = esc_url(get_permalink($post_id));
                    $thumbnail_url = get_the_post_thumbnail_url($post_id, 'thumbnail') ?: esc_url(ATCL_IMAGES_URL . '/placeholder.jpg');
                    $trimmed_content = wp_trim_words(wp_strip_all_tags(strip_shortcodes($post->post_content)), 15, '...');
        
                    // Prepare post data
                    $post_data = [
                     'ID' => $post_id,
                     'title' => $post_title,
                     'link' => $post_link,
                     'thumbnail' => $thumbnail_url,
                     'content' => esc_html($trimmed_content),
                    ];
        
                    // Handle WooCommerce products separately
                    if ($type === 'product' && class_exists('WooCommerce')) {
                        $cache_key = 'product_' . $post_id . '_price';
                        $price = get_transient($cache_key);
        
                        if ($price === false) {
                            $product = wc_get_product($post_id);
                            $price = $product ? wc_price($product->get_price()) : '';
                                
                        }
        
                        $post_data['price'] = $price;
                    }
        
                    // Add the post data to the appropriate type group
                    $grouped_content[$type][] = $post_data;
                }
            }
        }
        
            wp_reset_postdata(); // Reset global post data after the loop
            
            // Render grouped content for all types
            $noresult = [];
        foreach ($atcl_autosearch_enable_type as $type) {
            if (!empty($grouped_content[$type])) {
                array_push($noresult, 1);
                $label = (get_option('atcl_autosearch_'.$type.'_type_label')) ? get_option('atcl_autosearch_'.$type.'_type_label') : ucfirst($type);
                ?>
                    <div class="autocomplete-result">
                        <div class="autocomplete-Header">
                            <div class="autocomplete-HeaderTitle"><?php echo esc_attr($label)?></div>
                            <div class="autocomplete-HeaderLine"></div>
                        </div>
                <?php foreach ($grouped_content[$type] as $item) { ?>
                            <div class="wp-item-search">
                                <a class="wp-link" href="<?php echo esc_attr($item['link']);?>" title="<?php echo esc_attr($item['title']); ?>">
                                    <img src="<?php echo esc_attr($item['thumbnail']); ?>" alt="<?php echo esc_attr($item['title']); ?>">
									<?php wp_get_attachment_image( $post_id, 'thumbnail' ); ?>
                                    <div class="wp-content">
                                        <p class="wp-title"><?php echo esc_attr($item['title']); ?></p>
                    <?php if ($type !== 'product') { ?>
                                            <span class="item-content"><?php echo esc_attr($item['content']); ?></span>
                    <?php } else { ?>
                                            <span class="wp-Price-amount amount"><?php echo esc_attr(sanitize_text_field($item['price'])); ?></span>
                    <?php } ?>
                                    </div>
                                </a>
                            </div>
                <?php } ?>
                    </div>
                <?php
            }
        }
        
        if (empty($noresult)) {
            echo '<div class="no-result">No results matched your query <strong>' . esc_html($search_value) . '</strong>.</div>';
        }
        
    
        exit;
    }
}
