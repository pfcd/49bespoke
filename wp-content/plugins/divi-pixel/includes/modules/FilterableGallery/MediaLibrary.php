<?php
namespace DiviPixel;

// add categories for attachments
/*function add_categories_for_attachments() {
    register_taxonomy_for_object_type( 'category', 'attachment' );
}
add_action( 'init' , __NAMESPACE__.'\\add_categories_for_attachments' );

// add tags for attachments
function add_tags_for_attachments() {
    register_taxonomy_for_object_type( 'post_tag', 'attachment' );
}
add_action( 'init' , __NAMESPACE__.'\\add_tags_for_attachments' );
*/


add_action( 'init', __NAMESPACE__.'\\create_dipi_media_categoryonomy', 0 );
 
function create_dipi_media_categoryonomy() {
 
// Labels part for the GUI
 
  $labels = array(
    'name' => _x( 'Divi Pixel Category', 'taxonomy general name' ),
    'singular_name' => _x( 'Divi Pixel Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Divi Pixel Categories' ),
    'popular_items' => __( 'Popular Divi Pixel Categories' ),
    'all_items' => __( 'All Divi Pixel Categories' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Divi Pixel Category' ), 
    'update_item' => __( 'Update Divi Pixel Category' ),
    'add_new_item' => __( 'Add New Divi Pixel Category' ),
    'new_item_name' => __( 'New Topic Name' ),
    'separate_items_with_commas' => __( 'Separate Divi Pixel Categories with commas' ),
    'add_or_remove_items' => __( 'Add or remove Divi Pixel Categories' ),
    'choose_from_most_used' => __( 'Choose from the most used Divi Pixel Categories' ),
    'menu_name' => __( 'Divi Pixel Categories' ),
  ); 
 
// Now register the non-hierarchical taxonomy like tag
 
  register_taxonomy('dipi_media_category','attachment',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    /*'update_count_callback' => '_update_post_term_count',*/
    'update_count_callback' => '_update_generic_term_count',
    'query_var' => true,
  ));
}

