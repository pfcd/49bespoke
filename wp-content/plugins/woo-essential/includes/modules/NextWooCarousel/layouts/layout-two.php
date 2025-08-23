<?php

$quickview_icon = sprintf(
    '<a href="#" class="dnwoo_product_grid_quick_button dnwoo-quickview icon_quickview" data-icon="" data-quickid="%1$s" data-orderclass="%2$s"></a>',
    $product->get_id(),
    $order_class
);

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

$dnwooe_tag = et_pb_process_header_level($header_level, 'h3'); //if you add tag change option. header_level parent name array must header.

$current_cats = get_the_terms( get_the_ID(), 'product_cat' );
if ( $current_cats && ! is_wp_error( $current_cats ) ) {
    $cat_name = array();
    foreach ($current_cats as $dnwooe_cat ) {
        $cat_name[] = '<a href="'.esc_url( get_term_link($dnwooe_cat)).'">'.esc_html($dnwooe_cat->name).'</a>';
    }
}

$category_html = 'on' == $show_category ? sprintf('<div class="dnwoo_product_carousel_categories"><ul class="list-unstyled"><li>%1$s</li></ul></div>', join(', ', $cat_name )) : '';

$single_products .= '<div class="dnwoo_product_carousel dnwoo_product_carousel_container' . ' product_type_'.$product_type .' dnwoo_product_carousel_layout_two">';
$single_products .= sprintf(
    '<div class="dnwoo_product_imgwrap">
        <a href="%5$s">
            <div class="dnwoo_img_wrap">
                %2$s
                %3$s
                %4$s
                <img class="img-fluid" src="%1$s" alt="Product Image"
                    title="Woo Single Product">
            </div>
        </a>
        %6$s
    </div>',
    $thumbnail ? $thumbnail : esc_attr($demo_image),
    DNWoo_Common::product_offer_badge($this, "show_badge"),
    DNWoo_Common::product_offer_badge($this, "hide_out_of_stock"),
    DNWoo_Common::product_offer_featured($this, "show_featured_product"),
    $permalink,
    $product_btn_icon
);

$product_rating = wc_get_rating_html($product->get_average_rating(), $product->get_rating_count());

$single_products .= sprintf(
    '<div class="dnwoo_product_details_container">
        %7$s
        <div class="dnwoo_product_details_wrap">
            <div class="dnwoo_product_details">
                <a href="%4$s"><%6$s class="dnwoo_product_title">%1$s</%6$s></a>
                <p>%5$s</p>
                
            </div>
            <div class="dnwoo_product_price">
                <div class="dnwoo_single_price">
                    %3$s
                </div>
            </div>
        </div>
        %2$s
    </div>',
    $product->get_name(),
    ( isset( $show_rating ) && 0 < $product->get_rating_count() && 'on' === $show_rating ? '<div class="dnwoo_product_ratting"><div class="star-rating"><span style="width:0%">'.esc_html__('Rated', 'dnwooe').' <strong class="rating">'.esc_html__('0', 'dnwooe').'</strong> '.esc_html__('out of 5', 'dnwooe').'</span>'.$product_rating.'</div></div>' : ''),
    'on' === $show_price_text ? $product->get_price_html() : '',
    $permalink,
    'on' === $show_desc ? get_the_excerpt() : '',
    $dnwooe_tag,
    $category_html
);

$single_products .= '</div>';