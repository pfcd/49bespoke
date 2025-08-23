<?php
namespace DiviPixel;

add_action('init', __NAMESPACE__ . '\\dipi_testimonial_post_type');
function dipi_testimonial_post_type()
{
    // Little hack so we can use a prefixed category in Divi Sensei modules while 
    // at the same time keep backwards compatibility for Divi Pixel
    $prefix = 'dipi_';
    if($prefix !== 'ds_'){
        $prefix = '';
    }

    // Register Custom Post Type
    $labels = [
        'name' => _x('Testimonials', 'Post Type General Name', 'dipi-divi-pixel'),
        'singular_name' => _x('Testimonial', 'Post Type Singular Name', 'dipi-divi-pixel'),
        'menu_name' => __('Testimonials', 'dipi-divi-pixel'),
        'name_admin_bar' => __('Testimonial', 'dipi-divi-pixel'),
        'archives' => __('Item Archives', 'dipi-divi-pixel'),
        'attributes' => __('Item Attributes', 'dipi-divi-pixel'),
        'parent_item_colon' => __('Parent Item:', 'dipi-divi-pixel'),
        'all_items' => __('All Items', 'dipi-divi-pixel'),
        'add_new_item' => __('Add New Item', 'dipi-divi-pixel'),
        'add_new' => __('Add New', 'dipi-divi-pixel'),
        'new_item' => __('New Item', 'dipi-divi-pixel'),
        'edit_item' => __('Edit Item', 'dipi-divi-pixel'),
        'update_item' => __('Update Item', 'dipi-divi-pixel'),
        'view_item' => __('View Item', 'dipi-divi-pixel'),
        'view_items' => __('View Items', 'dipi-divi-pixel'),
        'search_items' => __('Search Item', 'dipi-divi-pixel'),
        'not_found' => __('Not found', 'dipi-divi-pixel'),
        'not_found_in_trash' => __('Not found in Trash', 'dipi-divi-pixel'),
        'featured_image' => __('Featured Image', 'dipi-divi-pixel'),
        'set_featured_image' => __('Set featured image', 'dipi-divi-pixel'),
        'remove_featured_image' => __('Remove featured image', 'dipi-divi-pixel'),
        'use_featured_image' => __('Use as featured image', 'dipi-divi-pixel'),
        'insert_into_item' => __('Insert into item', 'dipi-divi-pixel'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'dipi-divi-pixel'),
        'items_list' => __('Items list', 'dipi-divi-pixel'),
        'items_list_navigation' => __('Items list navigation', 'dipi-divi-pixel'),
        'filter_items_list' => __('Filter items list', 'dipi-divi-pixel'),
    ];

    $args = [
        'label' => __('Testimonial', 'dipi-divi-pixel'),
        'description' => __('Testimonial Description', 'dipi-divi-pixel'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail'),
        'taxonomies' => array($prefix . 'testimonial_cat', $prefix . 'testimonial_tag'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-format-quote',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => false,
        'exclude_from_search' => true,
        'publicly_queryable' => true,
        'capability_type' => 'page',
        'map_meta_cap' => true,
    ];

    register_post_type('dipi_testimonial', $args);

    // Register Custom Taxonomies
    $labels = array(
        'name' => _x('Categories', 'Taxonomy General Name', 'dipi-divi-pixel'),
        'singular_name' => _x('Category', 'Taxonomy Singular Name', 'dipi-divi-pixel'),
        'menu_name' => __('Categories', 'dipi-divi-pixel'),
        'all_items' => __('All Items', 'dipi-divi-pixel'),
        'parent_item' => __('Parent Item', 'dipi-divi-pixel'),
        'parent_item_colon' => __('Parent Item:', 'dipi-divi-pixel'),
        'new_item_name' => __('New Item Name', 'dipi-divi-pixel'),
        'add_new_item' => __('Add New Item', 'dipi-divi-pixel'),
        'edit_item' => __('Edit Item', 'dipi-divi-pixel'),
        'update_item' => __('Update Item', 'dipi-divi-pixel'),
        'view_item' => __('View Item', 'dipi-divi-pixel'),
        'separate_items_with_commas' => __('Separate items with commas', 'dipi-divi-pixel'),
        'add_or_remove_items' => __('Add or remove items', 'dipi-divi-pixel'),
        'choose_from_most_used' => __('Choose from the most used', 'dipi-divi-pixel'),
        'popular_items' => __('Popular Items', 'dipi-divi-pixel'),
        'search_items' => __('Search Items', 'dipi-divi-pixel'),
        'not_found' => __('Not Found', 'dipi-divi-pixel'),
        'no_terms' => __('No items', 'dipi-divi-pixel'),
        'items_list' => __('Items list', 'dipi-divi-pixel'),
        'items_list_navigation' => __('Items list navigation', 'dipi-divi-pixel'),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
    );
    
    register_taxonomy($prefix . 'testimonial_cat', ['dipi_testimonial'], $args);

    $labels = array(
        'name' => _x('Tags', 'Taxonomy General Name', 'dipi-divi-pixel'),
        'singular_name' => _x('Tag', 'Taxonomy Singular Name', 'dipi-divi-pixel'),
        'menu_name' => __('Tags', 'dipi-divi-pixel'),
        'all_items' => __('All Items', 'dipi-divi-pixel'),
        'parent_item' => __('Parent Item', 'dipi-divi-pixel'),
        'parent_item_colon' => __('Parent Item:', 'dipi-divi-pixel'),
        'new_item_name' => __('New Item Name', 'dipi-divi-pixel'),
        'add_new_item' => __('Add New Item', 'dipi-divi-pixel'),
        'edit_item' => __('Edit Item', 'dipi-divi-pixel'),
        'update_item' => __('Update Item', 'dipi-divi-pixel'),
        'view_item' => __('View Item', 'dipi-divi-pixel'),
        'separate_items_with_commas' => __('Separate items with commas', 'dipi-divi-pixel'),
        'add_or_remove_items' => __('Add or remove items', 'dipi-divi-pixel'),
        'choose_from_most_used' => __('Choose from the most used', 'dipi-divi-pixel'),
        'popular_items' => __('Popular Items', 'dipi-divi-pixel'),
        'search_items' => __('Search Items', 'dipi-divi-pixel'),
        'not_found' => __('Not Found', 'dipi-divi-pixel'),
        'no_terms' => __('No items', 'dipi-divi-pixel'),
        'items_list' => __('Items list', 'dipi-divi-pixel'),
        'items_list_navigation' => __('Items list navigation', 'dipi-divi-pixel'),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
    );

    register_taxonomy($prefix . 'testimonial_tag', ['dipi_testimonial'], $args);
}

if (!wp_next_scheduled('dipi_testimonial_google_review_callback')) {
    wp_schedule_event(time(), 'twicedaily', 'dipi_testimonial_google_review_callback');
}

if (!wp_next_scheduled('dipi_testimonial_facebook_review_callback')) {
    wp_schedule_event(time(), 'twicedaily', 'dipi_testimonial_facebook_review_callback');
}

add_action('wp_ajax_dipi_google_review', __NAMESPACE__ . '\\dipi_testimonial_google_review_callback');
add_action('dipi_testimonial_google_review_callback', __NAMESPACE__ . '\\dipi_testimonial_google_review_callback');
function dipi_testimonial_google_review_callback()
{
    include_once plugin_dir_path(__FILE__) . 'google-review.php';
    $g_api = new DIPI_Google_Review();
    $g_api->run();
    if (wp_doing_ajax()) {
        //TODO: Based on whether downloading was successful, return success or error and show message to user
        wp_die();
    }
}

add_action('wp_ajax_dipi_facebook_review', __NAMESPACE__ . '\\dipi_testimonial_facebook_review_callback');
add_action('dipi_testimonial_facebook_review_callback', __NAMESPACE__ . '\\dipi_testimonial_facebook_review_callback');
function dipi_testimonial_facebook_review_callback()
{
    include_once plugin_dir_path(__FILE__) . 'facebook-review.php';
    $f_api = new DIPI_Facebook_Review();
    $f_api->run();
    
    if (wp_doing_ajax()) {
        //TODO: Based on whether downloading was successful, return success or error and show message to user
        wp_die();
    }
}

add_action('admin_enqueue_scripts', __NAMESPACE__ . '\\dipi_testimonial_admin_enqueue_scripts', 12, 0);
function dipi_testimonial_admin_enqueue_scripts()
{
    global $current_screen;
    if ('dipi_testimonial' === $current_screen->post_type) {
        wp_enqueue_script('dipi_testimonial_admin');
        wp_localize_script('dipi_testimonial_admin', 'dipi_testimonial', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'downloading_reviews_text' => esc_html__('Downloading Reviews...', 'dipi-divi-pixel'),
            'no_apis_message' => sprintf(
                esc_html__('To fetch reviews from Facebook and Google, please enter the App detail in the %1$s.', 'dipi-divi-pixel'),
                sprintf(
                    '<a href="%1$s">%2$s</a>',
                    admin_url('admin.php?page=divi_pixel_options'),
                    esc_html__('Divi Pixel Plugin Settings', 'dipi-divi-pixel')
                )
            ),

            'google_action' => 'dipi_google_review',
            'google_nonce' => wp_create_nonce('dipi_google_nonce'),
            'google_place_id' => DIPI_Settings::get_option('google_place_id'),
            'google_api_key' => DIPI_Settings::get_option('google_api_key'),
            'google_button_text' => esc_html__('Fetch Google Reviews', 'dipi-divi-pixel'),

            'facebook_action' => 'dipi_facebook_review',
            'facebook_nonce' => wp_create_nonce('dipi_facebook_nonce'),
            'facebook_page_id' => DIPI_Settings::get_option('facebook_page_id'),
            'facebook_page_access_token' => DIPI_Settings::get_option('facebook_page_access_token'),
            'facebook_button_text' => esc_html__('Fetch Facebook Reviews', 'dipi-divi-pixel'),
        ]);
    }
}
