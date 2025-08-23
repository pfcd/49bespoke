<?php
function dt_enqueue_styles() {
    $parenthandle = 'divi-style'; 
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css', 
        array(), // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
    wp_enqueue_style( 'child-style', get_stylesheet_uri(),
        array( $parenthandle ),
        $theme->get('Version') 
    );
}
add_action( 'wp_enqueue_scripts', 'dt_enqueue_styles' );

/**
 * @snippet       Filter by Featured @ WooCommerce Products Admin
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 8
 * @community     https://businessbloomer.com/club/
 */
 
add_filter( 'woocommerce_products_admin_list_table_filters', 'bbloomer_featured_filter' );
 
function bbloomer_featured_filter( $filters ) {
   $filters['featured_choice'] = 'bbloomer_filter_by_featured';
   return $filters;
}
 
function bbloomer_filter_by_featured() {
   $current_featured_choice = isset( $_REQUEST['featured_choice'] ) ? wc_clean( wp_unslash( $_REQUEST['featured_choice'] ) ) : false;
   $output = '<select name="featured_choice" id="dropdown_featured_choice"><option value="">Filter by featured status</option>';
   $output .= '<option value="onlyfeatured" ';
   $output .= selected( 'onlyfeatured', $current_featured_choice, false );
   $output .= '>Featured Only</option>';
   $output .= '<option value="notfeatured" ';
   $output .= selected( 'notfeatured', $current_featured_choice, false );
   $output .= '>Not Featured</option>';
   $output .= '</select>';
   echo $output;
}
 
add_filter( 'parse_query', 'bbloomer_featured_products_query' );
 
function bbloomer_featured_products_query( $query ) {
    global $typenow;
    if ( $typenow == 'product' ) {
        if ( ! empty( $_GET['featured_choice'] ) ) {
            if ( $_GET['featured_choice'] == 'onlyfeatured' ) {
                $query->query_vars['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field' => 'slug',
                    'terms' => 'featured',
                );
            } elseif ( $_GET['featured_choice'] == 'notfeatured' ) {
                $query->query_vars['tax_query'][] = array(
                    'taxonomy' => 'product_visibility',
                    'field' => 'slug',
                    'terms' => 'featured',
                    'operator' => 'NOT IN',
                );
            }
        }
    }
    return $query;
} 

// Remove "Select options" button from (variable) products on the main WooCommerce shop page.
add_filter( 'woocommerce_loop_add_to_cart_link', function( $product ) {

	global $product;

	if ( is_shop() && 'variable' === $product->product_type ) {
		return '';
	} else {
		sprintf( '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
			esc_url( $product->add_to_cart_url() ),
			esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
			esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
			isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
			esc_html( $product->add_to_cart_text() )
		);
	}

}