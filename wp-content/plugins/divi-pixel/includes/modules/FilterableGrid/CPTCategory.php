<?php
namespace DiviPixel;

add_action( 'init', __NAMESPACE__.'\\create_dipi_cpt_categoryonomy', 0 );
 
function create_dipi_cpt_categoryonomy() {
 
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
  $post_types = get_post_types( array( 'public' => true ) );
  $included_post_types = array('dipi_faq', 'dipi_popup_maker', 'dipi_testimonial');
  $excluded_post_types = array( 'attachment', 'revision', 'nav_menu_item', 'custom_css', 'et_pb_layout', 'divi_bars', 'dipi_popup_maker', 'divi_mega_pro', 'customize_changeset' );
  $post_types = array_merge($post_types, $included_post_types);
  $post_types = array_diff( $post_types, $excluded_post_types);

  register_taxonomy('dipi_cpt_category', $post_types, array(
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

