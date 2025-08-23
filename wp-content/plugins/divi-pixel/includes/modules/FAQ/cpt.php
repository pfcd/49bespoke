<?php

if (!function_exists('dipi_faq_register_post_type')) {
    function dipi_faq_register_post_type()
    {
        $searchEnabeld = get_option('dipi_faq_search_enabled') == 'on';
        $labels = [
            'name' => __('FAQ', 'dipi-divi-pixel'),
            'singular_name' => __('FAQ', 'dipi-divi-pixel'),
            'menu_name' => __('FAQ', 'dipi-divi-pixel'),
            'name_admin_bar' => __('FAQ', 'dipi-divi-pixel'),
            'archives' => __('FAQ Archives', 'dipi-divi-pixel'),
            'attributes' => __('FAQ Attributes', 'dipi-divi-pixel'),
            'parent_item_colon' => __('Parent FAQ:', 'dipi-divi-pixel'),
            'all_items' => __('All FAQ', 'dipi-divi-pixel'),
            'add_new_item' => __('Add New FAQ', 'dipi-divi-pixel'),
            'add_new' => __('Add New', 'dipi-divi-pixel'),
            'new_item' => __('New FAQ', 'dipi-divi-pixel'),
            'edit_item' => __('Edit FAQ', 'dipi-divi-pixel'),
            'update_item' => __('Update FAQ', 'dipi-divi-pixel'),
            'view_item' => __('View FAQ', 'dipi-divi-pixel'),
            'view_items' => __('View FAQ', 'dipi-divi-pixel'),
            'search_items' => __('Search FAQ', 'dipi-divi-pixel'),
            'not_found' => __('Not found', 'dipi-divi-pixel'),
            'not_found_in_trash' => __('Not found in Trash', 'dipi-divi-pixel'),
            'featured_image' => __('Featured Image', 'dipi-divi-pixel'),
            'set_featured_image' => __('Set featured image', 'dipi-divi-pixel'),
            'remove_featured_image' => __('Remove featured image', 'dipi-divi-pixel'),
            'use_featured_image' => __('Use as featured image', 'dipi-divi-pixel'),
            'insert_into_item' => __('Insert into FAQ', 'dipi-divi-pixel'),
            'uploaded_to_this_item' => __('Uploaded to this FAQ', 'dipi-divi-pixel'),
            'items_list' => __('FAQ list', 'dipi-divi-pixel'),
            'items_list_navigation' => __('FAQ list navigation', 'dipi-divi-pixel'),
            'filter_items_list' => __('Filter FAQ list', 'dipi-divi-pixel'),
        ];

        $args = [
            'label' => __('FAQ', 'dipi-divi-pixel'),
            'description' => __('FAQ Description', 'dipi-divi-pixel'),
            'labels' => $labels,
            'supports' => ['title', 'editor'],
            'taxonomies' => ['dipi_faq_category'],
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-editor-help',
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => $searchEnabeld,
            'exclude_from_search' => !$searchEnabeld,
            'publicly_queryable' => $searchEnabeld,
            'capability_type' => 'page',
            'map_meta_cap' => true,
        ];

        register_post_type('dipi_faq', $args);
    }
    add_action('init', 'dipi_faq_register_post_type', 20);
}

if (!function_exists('dipi_faq_register_taxonomy')) {
    function dipi_faq_register_taxonomy()
    {
        $labels = array(
            'name' => __('Categories', 'dipi-divi-pixel'),
            'singular_name' => __('Category', 'dipi-divi-pixel'),
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
        $args = [
            'labels' => $labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => true,
        ];
        register_taxonomy('dipi_faq_category', ['dipi_faq_category'], $args);
    }
    add_action('init', 'dipi_faq_register_taxonomy', 10);
}
