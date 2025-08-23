<?php
/*
 * Contains code copied from and/or based on Divi and Woocommerce
 * See the ../license.txt file in the root directory for more information and licenses
 *
 */

/**
 * Custom "Empty Cart" message
 */

add_filter('wc_empty_cart_message', 'divi_ecommerce_pro_custom_wc_empty_cart_message');

function divi_ecommerce_pro_custom_wc_empty_cart_message() {

    if (!empty(get_theme_mod('dsdep_empty_cart_image'))) {
        $img_path = get_theme_mod('dsdep_empty_cart_image');
    } else {
        $img_path = get_stylesheet_directory_uri() . '/images/cart.png';
    }

    $content = '<div class="empty-cart">';
    $content .= '<img src="' . esc_url($img_path) . '" class="empty-cart-image">';
    $content .= '<p>';
    $content .= esc_html__('Your Cart is empty. Looks like you have not made your choice yet...', 'divi-ecommerce-pro');
    $content .= '</p></div>';
    echo et_core_intentionally_unescaped($content, 'html');
}

/**
 * Product loop hooks
 */

add_filter('woocommerce_after_shop_loop_item', 'divi_ecommerce_pro_woo_archive_product_open_div', 1);

function divi_ecommerce_pro_woo_archive_product_open_div() {
    echo '<div class="divi-ecommerce-pro-shop-buttons-wrapper">';
}

// Display Add to cart button
add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 15);

// Separator
add_action('woocommerce_after_shop_loop_item_title', 'divi_ecommerce_pro_after_single_product_title', 4);

function divi_ecommerce_pro_after_single_product_title() {
    echo '<hr class="sep">';
}

// Replace "Sale" text with %
function ds_replace_sale_text($text) {
    global $product;
    $stock = $product->get_stock_status();
    $product_type = $product->get_type();
    $sale_price = 0;
    $regular_price = 0;
    if ($product_type == 'variable') {
        $product_variations = $product->get_available_variations();
        foreach ($product_variations as $kay => $value) {
            if ($value['display_price'] < $value['display_regular_price']) {
                $sale_price = $value['display_price'];
                $regular_price = $value['display_regular_price'];
            }
        }
        if ($regular_price > $sale_price && $stock != 'outofstock') {
            $product_sale = intval(((floatval($regular_price) - floatval($sale_price)) / floatval($regular_price)) * 100);
            if ($product_sale > 5) {
                return '<span class="onsale">-' . $product_sale . '%</span>';
            }
            if ($product_sale <= 5) {
                return '<span class="onsale">' . esc_html__('Sale!', 'woocommerce') . '</span>';
            }
        } else {
            return '';
        }
    } else {
        $regular_price = get_post_meta(get_the_ID(), '_regular_price', true);
        $sale_price = get_post_meta(get_the_ID(), '_sale_price', true);
        if ($regular_price > 5) {
            $product_sale = intval(((floatval($regular_price) - floatval($sale_price)) / floatval($regular_price)) * 100);
            return '<span class="onsale">-' . $product_sale . '%</span>';
        }
        if ($regular_price >= 0 && $regular_price <= 5) {
            $product_sale = intval(((floatval($regular_price) - floatval($sale_price)) / floatval($regular_price)) * 100);
            return '<span class="onsale">' . esc_html__('Sale!', 'woocommerce') . '</span>';
        } else {
            return '';
        }
    }
}

/**
 * Hook woo checkout
 */

function divi_ecommerce_pro_woocommerce_checkout_open_div() {
    echo '<div class="dsdep-checkout-order">';
}

add_filter('woocommerce_checkout_before_order_review_heading', 'divi_ecommerce_pro_woocommerce_checkout_open_div');

function divi_ecommerce_pro_woocommerce_checkout_close_div() {
    echo '</div>';
}

add_filter('woocommerce_review_order_after_payment', 'divi_ecommerce_pro_woocommerce_checkout_close_div');

/**
 * Create Shortcode for WooCommerce Cart Menu Item
 */

function divi_ecommerce_pro_enqueue_ajax_script() {
    wp_enqueue_script('dsdep-cart-ajax', get_stylesheet_directory_uri() . '/js/cart-ajax.js', array('jquery'), true);
    wp_localize_script('dsdep-cart-ajax', 'divi_ecommerce_pro', array('ajaxurl' => admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'divi_ecommerce_pro_enqueue_ajax_script');


add_action('wp_ajax_divi_ecommerce_pro_get_cart_link_text', 'divi_ecommerce_pro_get_cart_link_text');
add_action('wp_ajax_nopriv_divi_ecommerce_pro_get_cart_link_text', 'divi_ecommerce_pro_get_cart_link_text');

function divi_ecommerce_pro_get_cart_link_text() {
    global $woocommerce;
    esc_html_e((int)$woocommerce->cart->cart_contents_count);
    exit;
}

function dsdep_cart_items() {
    global $woocommerce;
    ob_start();
    $cart_url = wc_get_cart_url();
    ?>

    <a class="dsdep-cart-contents" href="<?php echo esc_url($cart_url); ?>">
        <?php esc_html_e('Cart', 'divi-ecommerce-pro'); ?>
        - <span class="number">
            <?php esc_html_e((int)$woocommerce->cart->cart_contents_count); ?>
        </span>
    </a>

    <?php
    return ob_get_clean();
}


function dsdep_cart_ajax_hook_js() {
    ?>
    <script>
        jQuery(function ($) {
            $(document.body).on('wc_fragments_refreshed', function () {
                divi_ecommerce_pro_update_cart_link_text();
            });
        });
    </script>
    <?php
}

add_action('wp_head', 'dsdep_cart_ajax_hook_js');

/**
 * Shop categories list shortcode
 *
 * [dsdep-shop-categories inline_style="1" hide_empty="1" orderby="name" order="ASC" exclude="cat_id" show_subcategories="0"]
 *
 * inline_styles="0" | inline_styles="1"
 * Choose betwen inline and block layout
 *
 * show_subcategories="0" | show_subcategories="1"
 * If show_subcategories = 0 is passed, only top-level terms will be returned
 *
 * hide_empty="0" | hide_empty="1"
 * Hide empty categories. This means if no post is assigned to the category, then the category object for that category is not returned
 *
 * orderby=""
 * Sort retrieved categories by parameter
 * More: @url https://developer.wordpress.org/reference/classes/wp_query/#order-orderby-parameters
 *
 * order="ASC | DESC"
 * Designates the ascending or descending order of the ‘orderby‘ parameter
 *
 * exclude="cat_id"
 * Exclude multiple categories by category id
 */

function divi_ecommerce_pro_shop_categories_list($atts, $parent = 0, $level = null) {

    // define attributes and their defaults
    $shortcode_atts = shortcode_atts(array(
        'inline_style'       => 0,
        'show_subcategories' => 0,
        'hide_empty'         => 0,
        'orderby'            => 'name',
        'order'              => 'ASC',
        'exclude'            => ''
    ), $atts);

    $args = array(
        'taxonomy'   => 'product_cat',
        'parent'     => $parent,
        'hide_empty' => $shortcode_atts['hide_empty'],
        'orderby'    => $shortcode_atts['orderby'],
        'order'      => $shortcode_atts['order'],
        'exclude'    => $shortcode_atts['exclude']
    );

    $categories = get_categories($args);
    if (empty($categories)) return;

    $class = "dsdep-shop-categories-list";

    if ($shortcode_atts['inline_style'] == true) {
        $class .= ' list-inline';
    }

    if ($level !== "child") {
        echo '<ul class="' . esc_html($class) . '">';
    }

    foreach ($categories as $category) {
        $thumb_id = get_term_meta($category->term_id, 'thumbnail_id', true);
        $thumb_array = wp_get_attachment_image_src($thumb_id, 'medium');

        if ( is_array($thumb_array) && ! empty($thumb_array[0])) {
	        $image = $thumb_array[0];
        } else {
	        $image = wc_placeholder_img_src('medium');
        }

        $catClass = $category->term_id;
        if ($level == "child") {
            $catClass .= ' child';
        }

        echo sprintf(
            '<li class="category-%1$s"><a href="%2$s"><img src="%3$s" alt="%4$s">%4$s</a>',
            esc_html($catClass),
            esc_url(get_category_link($category->term_id)),
            esc_url($image),
            esc_html($category->name)
        );
        echo '</li>';

        if ($shortcode_atts['show_subcategories'] == true) {
            divi_ecommerce_pro_shop_categories_list($atts, $category->term_id, "child");
        }
    }

    if ($level !== "child") {
        echo '</ul>';
    }
}

function divi_ecommerce_pro_shop_categories_list_shortcode($atts) {
    ob_start();
    divi_ecommerce_pro_shop_categories_list($atts);
    return ob_get_clean();
}

/**
 * New Badge
 */

function divi_ecommerce_pro_new_badge_shop_page() {
    global $product;
    $days = get_theme_mod('dsdep_woocommerce_badge_new_days');
    $created = strtotime($product->get_date_created());
    if ((time() - (60 * 60 * 24 * $days)) < $created) {
        echo '<span class="new-badge">' . esc_html__('New', 'divi-ecommerce-pro') . '</span>';
    }
}

/**
 * Registration of shortcodes
 */

add_action('init', 'divi_ecommerce_pro_register_woo_shortcodes');

function divi_ecommerce_pro_register_woo_shortcodes() {
    add_shortcode('dsdep-shop-categories', 'divi_ecommerce_pro_shop_categories_list_shortcode');
    add_shortcode('dsdep_cart_items', 'dsdep_cart_items');
}
