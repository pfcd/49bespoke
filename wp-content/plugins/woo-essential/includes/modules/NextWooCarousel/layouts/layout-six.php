<?php

$thumbnail_id = get_post_thumbnail_id( $product_id );
$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);

$quickview_icon = sprintf(
    '<a href="#" title="Quick View" class="dnwoo_product_grid_quick_button dnwoo-quickview icon_quickview" data-icon="" data-quickid="%1$s" data-orderclass="%2$s"></a>',
    $product->get_id(),
    $order_class
);

$dnwooe_tag = et_pb_process_header_level($header_level, 'h3'); //if you add tag change option. header_level parent name array must header.

$product_btn_icon = sprintf(
    '<ul class="list-unstyled dnwoo_carousel_social_icon_wrap">
        <li>%1$s</li>
        <li>%2$s</li>
        <li>%3$s</li>
        <li>%4$s</li>
    </ul>',
    'on' === $show_add_to_cart_icon ? $add_to_cart_icon : '',
    'on' === $show_wish_list_icon ? dnwoo_add_to_wishlist_button() : '',
    'on' === $show_add_compare_icon ? dnwoo_product_compare_button() : '',
    'on' === $show_quickview_icon ? $quickview_icon : ''
);


$single_products .= '<div class="dnwoo_product_carousel dnwoo_product_carousel_container ' . 'product_type_'.$product_type .' dnwoo_product_carousel_layout_six">';
$single_products .= sprintf(
    '<div  class="dnwoo_product_imgwrap">
        %3$s
        %4$s
        %5$s
        <a href="%7$s" class="dnwoo_product_image_container"><img class="img-fluid dnwoo_product_image" src="%1$s"
        alt="%2$s"></a>
        %8$s
        %6$s
    </div>',
    $thumbnail ? $thumbnail : esc_attr($demo_image),
    $alt,
    DNWoo_Common::product_offer_badge($this, "show_badge"),
    DNWoo_Common::product_offer_badge($this, "hide_out_of_stock"),
    DNWoo_Common::product_offer_featured($this, "show_featured_product"),
    'on' === $show_add_to_cart_btn ? $add_to_cart_btn : '',
    $permalink,
    $product_btn_icon
);

$current_cats = get_the_terms( get_the_ID(), 'product_cat' );
if ( $current_cats && ! is_wp_error( $current_cats ) ) { 
    $cat_name = array();
    foreach ($current_cats as $dnwooe_cat ) {
        $cat_name[] = '<a href="'.esc_url( get_term_link($dnwooe_cat)).'">'.esc_html($dnwooe_cat->name).'</a>';
    }
}

$category_html = "on" == $show_category ? sprintf('<ul class="list-unstyled"><li>%1$s</li></ul>', join(', ', $cat_name )) : '';

$single_products .= sprintf(
    '<div class="dnwoo_product_content">
        <div class="dnwoo_product_categories">
            %3$s
            <a href="%7$s"><%6$s class="dnwoo_product_title">%1$s</%6$s></a>
            <p>%4$s</p>
            <div class="dnwoo_product_price">
                <div class="dnwoo_single_price">
                    %2$s
                </div>
            </div>
            %5$s
        </div>
    </div>',
    $product->get_name(),
    'on' === $show_price_text ? $product->get_price_html() : '',
    $category_html,
    'on' === $show_desc ? get_the_excerpt() : '',
    ( isset( $show_rating ) && 0 < $product->get_rating_count() && 'on' === $show_rating ? '<div class="dnwoo_product_ratting"><div class="star-rating"><span style="width:0%">'.esc_html__( 'Rated', 'dnwooe' ).' <strong class="rating">'.esc_html__('0', 'dnwooe').'</strong> '.esc_html__( 'out of 5', 'dnwooe').'</span>'.$product_rating.'</div></div>' : ''),
    $dnwooe_tag,
    $permalink
);

$single_products .= '</div>';