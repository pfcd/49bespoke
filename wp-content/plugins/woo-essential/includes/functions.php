<?php

defined('ABSPATH') || die();

require_once DNWOO_ESSENTIAL_PATH . '/includes/modules/NextWooFilterMasonry/core/Action.php';
use DNWoo_Essential\Includes\Modules\NextWooFilterMasonry\Action;

// Ajax submit
if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
    $obj = new Action();
    $obj->init();
}

if (!has_filter('et_global_assets_list', 'dnwoo__add_icons')) {
    add_filter('et_global_assets_list', 'dnwoo__add_icons', 10);
}

function dnwoo__add_icons($assets)
{
    if (isset($assets['et_icons_all']) && isset($assets['et_icons_fa'])) {
        return $assets;
    }

    $assets_prefix = et_get_dynamic_assets_path();

    $assets['et_icons_all'] = array(
        'css' => "{$assets_prefix}/css/icons_all.css",
    );

    $assets['et_icons_fa'] = array(
        'css' => "{$assets_prefix}/css/icons_fa_all.css",
    );

    return $assets;
}

function dnwoo_svg_icon()
{
    return 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1ODkuMjEgNDkxLjE4Ij48ZyBpZD0iTGF5ZXJfMiIgZGF0YS1uYW1lPSJMYXllciAyIj48ZyBpZD0iTGF5ZXJfMS0yIiBkYXRhLW5hbWU9IkxheWVyIDEiPjxwYXRoIGQ9Ik01ODguODMsMzkxLjcyLDU1OC4zNSw1Ni41MkE2Mi4xNCw2Mi4xNCwwLDAsMCw0OTYuNDcsMEg5Mi43NEE2Mi4xNSw2Mi4xNSwwLDAsMCwzMC44NSw1Ni41MkwuMzgsMzkxLjcyYTkxLjIxLDkxLjIxLDAsMCwwLDkwLjgzLDk5LjQ2SDQ5OEE5MS4yMSw5MS4yMSwwLDAsMCw1ODguODMsMzkxLjcyWk0xMTguMSwxNTUuNjZhMzIuNCwzMi40LDAsMSwxLDMyLjQsMzIuNEEzMi4zOSwzMi4zOSwwLDAsMSwxMTguMSwxNTUuNjZaTTM2My43MSwzNjYuNDhjLTIzLjIyLDAtNTIuMS05LjU3LTcxLjE1LTQ5LjUzLTE5LjI2LDQwLTQ1LjU4LDQ5LjUzLTY2LjI5LDQ5LjUzLTUyLjE1LDAtOTMtNjMtOTMtMTQzLjUxYTI0LjI5LDI0LjI5LDAsMCwxLDQ4LjU3LDBjMCw1My40NywyMy44OCw5NSw0NC40Myw5NSwyNC45MiwwLDQ0LjQ0LTcxLjI3LDQ0LjQ0LTE2Mi4yNmEyNC4yOCwyNC4yOCwwLDEsMSw0OC41NiwwYzAsNDguNTYsMCwxNjIuMjYsNDQuNDQsMTYyLjI2LDIwLjU1LDAsNDQuNDQtNDEuNDgsNDQuNDQtOTVhMjQuMjgsMjQuMjgsMCwxLDEsNDguNTYsMEM0NTYuNzEsMzAzLjQ1LDQxNS44NiwzNjYuNDgsMzYzLjcxLDM2Ni40OFptODEuNjItMTc4LjQyYTMyLjQsMzIuNCwwLDEsMSwzMi4zOS0zMi40QTMyLjM5LDMyLjM5LDAsMCwxLDQ0NS4zMywxODguMDZaIiBzdHlsZT0iZmlsbDojZjU5NGJjIi8+PC9nPjwvZz48L3N2Zz4=';
}

function dnwoo_wc_get_product_category_slug($product_names)
{
    $categories = category_arg(array('taxonomy' => 'product_cat'));
    $new_arr = array();
    foreach ($categories as $value) {
        $name = str_replace(' ', '', strtolower($value->name));
        if (in_array($name, $product_names)) {
            array_push($new_arr, $value->slug);
        }
    }

    return $new_arr;
}

/**
 * Category/Subcategory 
 *
 * @param [type] $params
 */
function category_arg($params=null) {
    $args = array('taxonomy' => 'product_cat' );
    if (!empty($params)) {
        $args['taxonomy']   = $params['taxonomy'];
        if (!empty($params['parent'])) {
            $args['hide_empty'] = 0;
            $args['parent']     = $params['parent'];
        }
    }
    return get_terms( $args );
}

function dnwoo_wc_get_product_category_slug_list($product_names)
{
    return implode(" ", dnwoo_wc_get_product_category_slug($product_names));
}


// Woo Product Carousel
add_action('wp_ajax_dnwoo_query_products', 'dnwoo_query_products');
function dnwoo_query_products($query = array())
{
    if (isset($_POST['dnwoo_query_products']) && !wp_verify_nonce(sanitize_text_field($_POST['dnwoo_query_products']), 'dnwoo_query_products')) {
        wp_send_json_error();
    }

    $query = empty($query) ? $_POST : $query;
    
    $products_number = isset($query['products_number']) ? $query['products_number'] : -1;
    $order = (isset($query['order']) ? $query['order'] : 'ASC');
    $orderby = (isset($query['orderby']) ? $query['orderby'] : 'date');
    $type = (isset($query['type']) ? $query['type'] : 'default');
    $offset = isset($query['offset']) ? intval($query['offset']) : 0;
    $include_categories = (isset($query['include_categories']) && 'all' !== $query['include_categories']) ? $query['include_categories'] : '';
    $current_categories = (isset($query['current_categories']) && '' !== $query['current_categories']) ? $query['current_categories'] : '';
    $hide_out_of_stock = (isset($query['hide_out_of_stock']) ? $query['hide_out_of_stock'] : 'on');
    $thumbnail_size = (isset($query['thumbnail_size']) ? $query['thumbnail_size'] : 'full');
    $paged = (isset($query['paged']) ? $query['paged'] : 1);
    $show_pagination = (isset($query['show_pagination']) ? $query['show_pagination'] : 'off');

    $request_from = (isset($query['request_from']) ? $query['request_from'] : '');

    
    $product_tag_arr = (isset($query['product_tag']) && is_array($query['product_tag'])) ? $query['product_tag'] : array();

    $search = (isset($query['s']) && '' != $query['s']) ? $query['s'] : '';

    $current_tags = (isset($query['current_tags']) && '' !== $query['current_tags']) ? $query['current_tags'] : '';
    $meta_key_arr = ['_wc_average_rating', '_price'];
    $meta_key = (isset($query['meta_key']) && in_array($query['meta_key'], $meta_key_arr)) ? $query['meta_key'] : '';

    $tax_query = ( isset( $query['tax_query'] ) ) ? $query['tax_query'] : [];
    $meta_query = ( isset( $query['meta_query'] ) ) ? $query['meta_query'] : [];

    $args = array(
        // 's' => $search,
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => intval($products_number),
        'product_tag' => $product_tag_arr,
        'paged' => intval($paged),
        'order' => $order,
        'orderby' => $orderby,
        'meta_key' => $meta_key, // phpcs:ignore
        'meta_query' => $meta_query, // phpcs:ignore
        'tax_query' => array_merge( // phpcs:ignore
            array(
                'taxonomy' => 'product_visibility',
                'field' => 'name',
                'terms' => 'exclude-from-catalog',
                'operator' => 'NOT IN',
            )
        ),
    );


    if( !empty( $search ) ) {
        $args['s'] = $search;
    }

    if ('off' === $show_pagination) {
        $args = array_merge($args, array(
            'offset' => in_array($request_from, array('filter-product', 'filter-product-backend')) ? 0 : $offset,
        ));
    }

    if ($current_categories && '' !== $current_categories) {
        $args['tax_query'] = array( // phpcs:ignore
            array(
                'taxonomy' => 'product_cat',
                'field'     => 'term_id',
                'terms' => $current_categories,
                'operator' => 'IN',
            ),
        );
    }else if($current_tags && '' !== $current_tags) {
        $args['tax_query'] = array( // phpcs:ignore
            array(
                'taxonomy' => 'product_tag',
                'field' => 'term_id',
                'terms' => array($current_tags),
            ),
        );
    } else if ($include_categories && '' !== $include_categories) {
        $args['tax_query'] = array( // phpcs:ignore
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => array_map('intval', explode(',', $include_categories)),
                'operator' => 'IN',
            ),
        );
    }

    if ('on' === $hide_out_of_stock) {
        $args['meta_query'][] = array(
            'key' => '_stock_status',
            'value' => 'instock',
            'compare' => 'IN',
        );
    }
    switch ($type) {
        case 'featured':
            $args['tax_query'][] = array(
                'taxonomy' => 'product_visibility',
                'terms' => 'featured',
                'field' => 'name',
                'operator' => 'IN',
                'include_children' => false,
            );
            break;

        case 'sale':
            if (function_exists('wc_get_product_ids_on_sale')) {
                $args['post__in'] = array_merge(array(0), wc_get_product_ids_on_sale());
            }
            break;

        case 'best_selling':
            $args['meta_key'] = 'total_sales'; // phpcs:ignore
            $args['order'] = 'DESC';
            $args['orderby'] = 'meta_value_num';
            break;

        case 'top_rated':
            $args['meta_key'] = '_wc_average_rating'; // phpcs:ignore
            $args['order'] = 'DESC';
            $args['orderby'] = 'meta_value_num';
            break;

        default:
            break;
    }
    
    if ( !empty($tax_query)) {
        array_push($args['tax_query'], $tax_query );
    }

    if (!empty($query)) {
        $args     = apply_filters('dnwoo_product_query_params', $args);
        $products = new WP_Query(apply_filters('woocommerce_shortcode_products_query', $args));
        $products_arr   = array();
        $products_cats  = get_included_categories( 
            array('include_categories'=>$include_categories,
            'order'=>$order,'orderby'=>$orderby) );

        if ("frontend" != $request_from && class_exists('WooCommerce')) {
            $products_arr = $products->posts;

            for ($i = 0; $i < count($products_arr); $i++) {
                $cats = get_the_terms($products_arr[$i]->ID, 'product_cat');
                $stripped_category = array();
                if((is_array($cats) || is_object($cats)) && count($cats)):
                    foreach ($cats as $key => $value) {
                    $product = wc_get_product($products_arr[$i]->ID);
                    $products_arr[$i]->get_type = $product->get_type();
                    $products_arr[$i]->sku = $product->get_sku();
                    $products_arr[$i]->stock_status = $product->get_stock_status();
                    $products_arr[$i]->is_on_sale = $product->is_on_sale();
                    $products_arr[$i]->get_rating_count = $product->get_rating_count();
                    $products_arr[$i]->get_price_html = $product->get_price_html();
                    $products_arr[$i]->is_featured = $product->is_featured();
                    $products_arr[$i]->product_rating = wc_get_rating_html($product->get_average_rating(), $product->get_rating_count());
                    $products_arr[$i]->category = wc_get_product_category_list($products_arr[$i]->ID, ', ', '<li>', '</li>');

                    $str_cat = explode(",", str_replace(' ', '', strtolower(wp_strip_all_tags($products_arr[$i]->category))));
                    array_push($stripped_category, $value->slug);

                    $products_arr[$i]->striped_category_list = dnwoo_wc_get_product_category_slug_list($str_cat);
                    $products_arr[$i]->striped_category = $stripped_category;

                    $percentage = "";
                    if ($product->get_type() == 'variable') {
                        $available_variations = $product->get_variation_prices();
                        $max_percentage = 0;

                        foreach ($available_variations['regular_price'] as $key => $regular_price) {
                            $sale_price = $available_variations['sale_price'][$key];

                            if ($sale_price < $regular_price) {
                                $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);

                                if ($percentage > $max_percentage) {
                                    $max_percentage = $percentage;
                                }
                            }
                        }

                        $products_arr[$i]->percentage = (string) $max_percentage . '%';
                    } elseif ($product->get_type() == 'simple' || $product->get_type() == 'external') {
                        if ($product->get_regular_price() > 0 && $product->get_sale_price() > 0) {
                            $percentage = (round((((float) $product->get_regular_price() - (float) $product->get_sale_price()) / (float) $product->get_regular_price()) * 100));
                            $products_arr[$i]->percentage = (string) $percentage . (string) "%";
                        }

                    }

                    $products_arr[$i]->thumbnail = get_the_post_thumbnail_url($products_arr[$i]->ID, $thumbnail_size);
                    $products_arr[$i]->permalink = get_permalink($products_arr[$i]->ID);

                    if ('' == $products_arr[$i]->post_excerpt) {
                        $products_arr[$i]->post_excerpt = dnwoo_get_excerpt($products_arr[$i]->post_content, 270);
                    } else {
                        $products_arr[$i]->post_excerpt = dnwoo_get_excerpt($products_arr[$i]->post_excerpt, 270);
                    }
                }
                endif;
            }

        }

        if ("modified-frontend" == $request_from) {
            return $products_arr;
        }

        if ("productGrid" == $request_from) {
            return wp_send_json(array(
                'products' => $products_arr,
                'total_products' => $products->found_posts,
            ));
        }

        if ('filter-product' == $request_from) {
            return array(
                'products' => $products_arr,
                'pages'=>$products->max_num_pages,
                'total' => $products->found_posts,
                'categories' => $products_cats,
            );
        }
        if ('filter-product-backend' == $request_from) {
            return wp_send_json(array(
                'products' => array_slice($products_arr, (int) $offset),
                'categories' => $products_cats,
            ));
        }
        if ( 'ajax-call' == $request_from ) {
            return array( 'products'=>$products_arr , 'pages'=>$products->max_num_pages,
            'total' => $products->found_posts );
        }

        return "frontend" == $request_from ? apply_filters('dnwoo_queried_products', $products, $query) : wp_send_json($products_arr);
    }
}

/**
 * Demo image
 */
if (! function_exists('dnxte_demo_image') ) {
    function dnxte_demo_image() {
		return 'data:image/png;base64,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';
    }
}

if (! function_exists('get_product_tags') ) {
	/**
	 * Get product tags 
	 *
	 * @param [type] $taxonomy
	 */
	function get_product_tags( $tag , $type = "" ) {
		if( !class_exists('WooCommerce')){
			return array();
		}
		$terms      = get_terms( array(
			'taxonomy'   => $tag,
			'hide_empty' => false,
		) );
		
		$result_terms = array();
		foreach ($terms as $key => $value) {
			if ($type == "assoc" ) {
				$result_terms[$value->term_id] = $value->name;
			}
			else if ($type == "label_value" ) {
				$result_terms[$key]['value'] = $value->term_id;
				$result_terms[$key]['label'] = $value->name;
			}
		}

		if ( $type == "" ) {
			$result_terms = $terms;
		} 
		
		return $result_terms;

	}
}

if (! function_exists('get_attributes') ) {
    /**
     * Get attributes 
     *
     * @param [type] $taxonomy
     * @return array
     */
    function get_attributes( $taxonomy = "" , $type="" ) {
        $data       = array();
        $terms      = get_product_tags( $taxonomy );
        $data['label'] = wc_attribute_label( $taxonomy );
        $data['terms'] = $terms;

        return $data;
    }
}

/**
 * Get filtered categories
 */
if (! function_exists('get_included_categories') ) {
    function get_included_categories( $args ) {
        extract($args); // phpcs:ignore
        $args = array(
            'taxonomy'      => 'product_cat',
            'parent'        => 0,
            'hide_empty'    => false,
            'orderby'       => $orderby,
            'order'         => $order,
        );

        $all_categories = get_categories( $args );

        if (!empty($all_categories)) {
            $all_categories = array_column($all_categories,'term_id');
        }

        $include_categories_arr = ( !empty($include_categories) && $include_categories !=='all' ) ? explode(',', $include_categories) : $all_categories;
        $order =='ASC' ? rsort ($include_categories_arr) : sort($include_categories_arr);

        $products_cats = array();
        foreach ($include_categories_arr as $key => $category_id) {
            $cats = get_term_by( 'id', $category_id, 'product_cat' );
            if( !empty($cats) ):
                $cats->sub_categories = category_arg( array('taxonomy' => 'product_cat', 'parent'=> $cats->term_id ) );
                $products_cats[$cats->name] = $cats;
            endif;
        }

        return $products_cats;
    }
}

// Woo Product Category Carousel
add_action('wp_ajax_dnwoo_get_category', 'dnwoo_get_category');

function dnwoo_get_category($query = array())
{
    if (isset($_POST['dnwoo_get_category']) && !wp_verify_nonce(sanitize_text_field($_POST['dnwoo_get_category']), 'dnwoo_get_category')) {
        wp_send_json_error();
    }

    $query = empty($query) ? $_POST : $query; 

    $products_number = (isset($query['products_number']) ? $query['products_number'] : -1);
    $order = (isset($query['order']) ? $query['order'] : 'ASC');
    $orderby = (isset($query['orderby']) ? $query['orderby'] : 'date');
    $include_categories = (isset($query['include_categories']) && 'all' !== $query['include_categories']) ? $query['include_categories'] : 'all';
    $hide_empty = (isset($query['hide_empty']) ? $query['hide_empty'] : "on");
    $offset = isset($query['offset']) ? $query['offset'] : '';
    $thumbnail_size = isset($query['thumbnail_size']) ? $query['thumbnail_size'] : 'woocommerce_thumbnail';
    $request_from = (isset($query['request_from']) ? $query['request_from'] : '');
    $show_sub_categories = (isset($query['show_sub_categories']) ? $query['show_sub_categories'] : 'off');

    $args = array(
        'taxonomy' => "product_cat",
        'hide_empty' => "on" == $hide_empty,
        'order' => $order,
        'orderby' => $orderby,
        'include' => $include_categories,
        'number' => $products_number,
        'thumbnail_size' => $thumbnail_size,
        'offset' => $offset,
        'show_sub_categories' => $show_sub_categories,
    );

    $catTerms = category_query_carousel($args);

    return "frontend" == $request_from ? $catTerms : wp_send_json($catTerms);
}

// Woo Product Category Carousel
function category_query_carousel($args, $parent = null ){
    $all_categories = array();
    if( !empty($parent)){
        $args['parent'] = $parent;
        unset($args['include']);
    } 

    $catTerms = get_terms( $args );

    foreach ($catTerms as $catTerm) {
        $thumbnail_id   = get_term_meta($catTerm->term_id, 'thumbnail_id', true);
        $thumbnail_size = isset($args['thumbnail_size']) ? $args['thumbnail_size'] : 'woocommerce_thumbnail';
        // get the image URL
        $image = !empty( $args['thumbnail_size'] ) && isset(wp_get_attachment_image_src($thumbnail_id, $args['thumbnail_size'])[0]) ? wp_get_attachment_image_src($thumbnail_id, $thumbnail_size)[0] : false;
        $catTerm->image = $image;
        $catTerm->link  = get_term_link($catTerm->term_id, 'product_cat');
        $all_categories[] = $catTerm;
        if ($args['show_sub_categories'] == 'on' ) {
            $child = category_query_carousel($args,$catTerm->term_id);
            if( !empty($child) ){
                $all_categories = array_merge($all_categories, $child);
            }
        }
    }

    return $all_categories;
}

function dnwoo_get_excerpt($content, $length)
{
    // $content = $post->post_content;
    $content = preg_replace('@\[caption[^\]]*?\].*?\[\/caption]@si', '', $content);
    $content = preg_replace('@\[et_pb_post_nav[^\]]*?\].*?\[\/et_pb_post_nav]@si', '', $content);
    $content = preg_replace('@\[audio[^\]]*?\].*?\[\/audio]@si', '', $content);
    $content = preg_replace('@\[embed[^\]]*?\].*?\[\/embed]@si', '', $content);
    $content = wp_strip_all_tags($content);
    // $content = et_strip_shortcodes( $content );// $content = et_builder_strip_dynamic_content( $content );
    // $content = apply_filters( 'et_truncate_post', $content, get_the_ID() );
    $content = rtrim(wp_trim_words($content, $length));
    return $content;
}

function dnwoo_add_to_wishlist_button($normalicon = '<span data-icon="" class="icon_heart"></span>', $addedicon = '<span data-icon="" class="icon_heart_alt"></span>')
{
    global $product, $yith_wcwl;

    if (!class_exists('YITH_WCWL') || empty(get_option('yith_wcwl_wishlist_page_id'))) {
        return '';
    }

    $url = YITH_WCWL()->get_wishlist_url();
    $product_type = $product->get_type();
    $exists = $yith_wcwl->is_product_in_wishlist($product->get_id());
    $classes = 'class="add_to_wishlist dnwoo-product-wishlist-btn"';
    $add = get_option('yith_wcwl_add_to_wishlist_text');
    $browse = get_option('yith_wcwl_browse_wishlist_text');
    $added = get_option('yith_wcwl_product_added_text');

    $output = '';

    $output .= '<div class="wishlist button-default yith-wcwl-add-to-wishlist add-to-wishlist-' . esc_attr($product->get_id()) . '">';
    $output .= '<div class="yith-wcwl-add-button';
    $output .= $exists ? ' hide" style="display:none;"' : ' show"';
    $output .= '><a href="' . esc_url(htmlspecialchars(YITH_WCWL()->get_wishlist_url())) . '" data-product-id="' . esc_attr($product->get_id()) . '" data-product-type="' . esc_attr($product_type) . '" ' . $classes . ' >' . $normalicon . '</a>';
    $output .= '<i class="fa fa-spinner fa-pulse ajax-loading" style="visibility:hidden"></i>';
    $output .= '</div>';

    $output .= '<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;"><a class="dnwoo-product-wishlist-btn" href="' . esc_url($url) . '">' . $addedicon . '</a></div>';
    $output .= '<div class="yith-wcwl-wishlistexistsbrowse ' . ($exists ? 'show' : 'hide') . '" style="display:' . ($exists ? 'block' : 'none') . '"><a href="' . esc_url($url) . '" class="dnwoo-product-action-btn">' . $addedicon . '</a></div>';
    $output .= '</div>';
    return $output;
}

function dnwoo_product_compare_button()
{
    if (!class_exists('YITH_Woocompare')) {
        return '';
    }

    global $product;
    $product_id = $product->get_id();
    $comp_link = home_url() . '?action=yith-woocompare-add-product';
    $comp_link = add_query_arg('id', $product_id, $comp_link);

    $output = '';

    $output .= '<div class="woocommerce product compare-button">';
    $output .= '<a href="' . esc_url($comp_link) . '" class="dnwoo-product-compare-btn compare icon_compare" data-product_id="' . esc_attr($product_id) . '" rel="nofollow"><span class="icon_left-right"></span></a></div>';
    $output .= '</div">';

    return $output;
}

add_action('wp_ajax_dnwoo_quickview', 'dnwoo_quickview_ajax');
add_action('wp_ajax_nopriv_dnwoo_quickview', 'dnwoo_quickview_ajax');
function dnwoo_quickview_ajax()
{

    $id = isset($_POST['id']) ? sanitize_text_field($_POST['id']) : ''; // phpcs:ignore
    if ((int) $id) {

        $order_class = isset($_POST['orderclass']) ? sanitize_text_field($_POST['orderclass']) : ''; // phpcs:ignore
        global $post, $product, $woocommerce;
        $product = wc_get_product($id);

        if ($product) {
            include_once apply_filters('dnwoo_quickview_tmp', DNWOO_ESSENTIAL_PATH . '/templates/woocommerce/template-parts/quick-view.php');
        }
    }
}


add_action('wp_ajax_product_grid_pagination', 'dnwoo_product_grid_pagination');
add_action('wp_ajax_nopriv_product_grid_pagination', 'dnwoo_product_grid_pagination');
function dnwoo_product_grid_pagination()
{
    if ( isset( $_POST['product_grid_pagination'] ) && ! wp_verify_nonce( sanitize_text_field( $_POST['product_grid_pagination'] ), 'product_grid_pagination' ) ) {
		wp_send_json_error();
	}

    $paged = isset($_POST['paged']) ? sanitize_text_field($_POST['paged']) : 1; // phpcs:ignore

    $props = [];
    $products_number = isset($_POST['per_page']) ? sanitize_text_field($_POST['per_page']) : '';
    $offset_number = isset($_POST['offset_number']) ? sanitize_text_field($_POST['offset_number']) : '';
    $products_order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : '';
    $products_orderby = isset($_POST['orderby']) ? sanitize_text_field($_POST['orderby']) : '';
    $order_class = isset($_POST['orderClass']) ? sanitize_text_field($_POST['orderClass']) : '';
    $current_tags = (isset($_POST['current_tags']) && '' != $_POST['current_tags']) ? sanitize_text_field($_POST['current_tags']) : '';
    $current_category = (isset($_POST['current_category']) && '' != $_POST['current_category']) ? sanitize_text_field($_POST['current_category']) : '';
    $include_categories = (isset($_POST['include_categories']) && 'all' !== $_POST['include_categories']) ? sanitize_text_field($_POST['include_categories']) : '';

    $wpf_args = (isset($_POST['wpf_args'])) ? sanitize_text_field($_POST['wpf_args']) : array();

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $products_number,
        'post_status' => 'publish',
        'suppress_filters' => false,
        'order' => $products_order,
        'orderby' => $products_orderby,
        'offset' => (int) $offset_number + (((int) $paged - 1) * (int) $products_number),
        'meta_query' => [] // phpcs:ignore
    );

    $args = array_merge($args, $wpf_args);

    // display products in category.
    if ($current_category && '' !== $current_category) {
        $args['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => $current_category,
            'operator' => 'IN',
        );
    }else if($current_tags && '' !== $current_tags) {
        $args['tax_query'][] = array(
            'taxonomy' => 'product_tag',
            'field' => 'term_id',
            'terms' => array($current_tags),
        );
    }else if ('' !== $include_categories) {
        $args['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => array_map('intval', explode(',', $include_categories)),
            'operator' => 'IN',
        );
    }


    $products = new WP_Query($args);
    $result = '';

    while ($products->have_posts()): $products->the_post();

        ob_start();
        include DNWOO_ESSENTIAL_PATH . '/templates/woocommerce/template-parts/woo-products-grid.php';
        $result .= ob_get_contents();
        ob_end_clean();
    endwhile;
    wp_reset_postdata();

    wp_send_json($result);
    wp_die();
}

function dnwoo_plugin_activate()
{
    add_option('dnwoo_do_activation_redirect', true);
}

function dnwoo_plugin_redirect()
{
    if (get_option('dnwoo_do_activation_redirect', false)) {
        delete_option('dnwoo_do_activation_redirect');
        // if (!isset($_GET['activate-multi'])) {
        //     wp_redirect('admin.php?page=dnwooe-essential');
        // }
    }
}
register_activation_hook(DNWOO_ESSENTIAL_FILE, 'dnwoo_plugin_activate');
add_action('admin_init', 'dnwoo_plugin_redirect');

add_action('woocommerce_widget_shopping_cart_buttons', function () {
    // Removing Buttons
    remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10);
    remove_action('woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20);

    // Adding customized Buttons
    add_action('woocommerce_widget_shopping_cart_buttons', 'dnwoo_widget_shopping_cart_button_view_cart', 5);
    add_action('woocommerce_widget_shopping_cart_buttons', 'dnwoo_widget_shopping_cart_proceed_to_checkout', 5);
}, 1);

// Custom cart button
function dnwoo_widget_shopping_cart_button_view_cart()
{
    $viewcart_text = get_option('dnwoo_view_cart_text', __('View Cart', 'dnwooe'));
    $original_link = wc_get_cart_url();
    echo '<a href="' . esc_url($original_link) . '" class="dnwoo-viewcart">' . esc_html__($viewcart_text) . '</a>';
}

// Custom Checkout button

function dnwoo_widget_shopping_cart_proceed_to_checkout()
{
    $checkout_text = get_option('dnwoo_checkout_text', __('Checkout', 'dnwooe'));
    $original_link = wc_get_checkout_url();
    // Use the $text variable instead of the hardcoded 'Checkout' string
    echo '<a href="' . esc_url($original_link) . '" class="dnwoo-checkout">' . esc_html__($checkout_text) . '</a>';
}


add_filter('woocommerce_locate_template', 'dnwoo_wc_template', 10, 3);
/**
 * Filter the cart template path to use cart.php in this plugin instead of the one in WooCommerce.
 *
 * @param string $template      Default template file path.
 * @param string $template_name Template file slug.
 * @param string $template_path Template file name.
 *
 * @return string The new Template file path.
 */
function dnwoo_wc_template($template, $template_name, $template_path)
{
    $template_directory = trailingslashit(DNWOO_ESSENTIAL_DIR) . 'templates/woocommerce/';
    $path = $template_directory . $template_name;
    return file_exists($path) ? $path : $template;

}


$active_modules = get_option('dnwooe_inactive_modules', array());
$inactive_features = get_option('dnwooe_inactive_features', array());



if (!function_exists('et_show_cart_total') && !in_array('mini-cart-feature', $inactive_features)) {
    function et_show_cart_total()
    {

        if (!class_exists('woocommerce') || !WC()->cart) {
            return;
        }

        $items_number = WC()->cart->get_cart_contents_count();
        
        ob_start();
        woocommerce_mini_cart();
        $mini_cart_data = ob_get_clean();
        

        $url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : WC()->cart->get_cart_url();
        $mini_cart_icon = get_option('dnwoo_mini_cart_selected_icon', '');
        $mini_cart_title_text = get_option('dnwoo_mini_cart_title_text_item', 'Items Selected');
        $mini_cart_data_vb = get_option('dnwoo_data_visibility', 'hover');
        $mini_cart_flyout_leri = get_option('dnwoo_data_vb_fly_out', 'left');
        $fly_out_lt = 'left' == $mini_cart_flyout_leri ? 'dnwoo_fly_out_appear_position_left' : 'dnwoo_fly_out_appear_position';
        $data_vb = ('click' == $mini_cart_data_vb) ? 'dnwoo_minicart_zoom_down' : (('fly-out' == $mini_cart_data_vb) ? $fly_out_lt . ' dnwoo_minicart_fly_out' : "dnwoo_minicart_slide_down");

        $fly_out_close_icon = ('fly-out' == esc_html($mini_cart_data_vb)) ? '<div class="dnwoo_minicart_cart_bag_fly_out_close_icon"></div>' : '';
        $fly_overlay_markup = ('fly-out' == esc_html($mini_cart_data_vb)) ? '<div class="dnwoo_minicart_cart_bag_fly_out_overlay"></div>' : '';

        printf(
            '<div class="dnwoo_minicart_cart_bag_position_left dnwoo_minicart %4$s" data-visibility="%3$s">
                <div class="dnwoo_minicart_wrapper">
                    <a data-icon="%2$s" class="dnwoo_minicart_icon">
                    <span class="dnwoo_count_number">%1$s</span>
                    </a>
                    <div class="dnwoo_minicart_cart_bag">
                        <div class="dnwoo_minicart_items_heading">
                            <span class="dnwoo_minicart_items_heading_text">%1$s</span> <span class="dnwoo_minicart_items_title_text">%7$s</span></div>
                            <div class="widget_shopping_cart_content">
                                %8$s
                            </div>
                        %5$s
                    </div>
                    %6$s
                </div>
            </div>',
            esc_html($items_number),
            esc_html($mini_cart_icon),
            esc_attr($mini_cart_data_vb),
            esc_attr($data_vb),
            wp_kses_post($fly_out_close_icon), //#5
            wp_kses_post($fly_overlay_markup),
            esc_html($mini_cart_title_text),
            $mini_cart_data // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        );
    }
}
if (!in_array('mini-cart-feature', $inactive_features)) {
    add_filter('woocommerce_add_to_cart_fragments', 'dnwoo_custom_functions');
    function dnwoo_custom_functions($fragments)
    {
        $fragments['.dnwoo_count_number'] = '<span class="dnwoo_count_number">' . WC()->cart->get_cart_contents_count() . '</span>';
        $fragments['.dnwoo_minicart_items_heading_text'] = '<span class="dnwoo_minicart_items_heading_text">' . WC()->cart->get_cart_contents_count() . '</span>';
        return $fragments;
    }
}

if (!in_array('dnwooe-woo-mini-cart-modules', $active_modules)) {
    add_filter('woocommerce_add_to_cart_fragments', 'dnwoo_mini_cart_modules');
    function dnwoo_mini_cart_modules($fragments)
    {
        $fragments['.dnwoo_mmini_cart_count_number'] = '<span class="dnwoo_mmini_cart_count_number">' . WC()->cart->get_cart_contents_count() . '</span>';
        $fragments['.dnwoo_mminicart_items_heading_text'] = '<span class="dnwoo_mminicart_items_heading_text">' . WC()->cart->get_cart_contents_count() . '</span>';
        return $fragments;
    }
}

if (!in_array('mini-cart-feature', $inactive_features)) {
    add_action('wp_head', 'dnwoo_customizer_css');

    function dnwoo_customizer_css()
    {
        $mini_cart_icon_color = get_option('dnwoo_mini_cart_icon_color', '#f6f7f7');
        $mini_cart_icon_size = get_option('dnwoo_mini_cart_icon_size', '14');
        $mini_cart_icon_bg = get_option('dnwoo_mini_cart_icon_bg', '#3042fd');
        $mini_cart_icon_bgbr = get_option('dnwoo_mini_cart_icon_bgbr', '50');
        $mini_cart_count_bgc = get_option('dnwoo_mini_cart_count_bg', '#6C4FFF');
        $mini_cart_count_cc = get_option('dnwoo_mini_cart_count_color', '#FFFFFF');

        $mini_cart_icon_wbgc = get_option('dnwoo_mini_cart_wbg_color', '#FFFFFF');
        $mini_cart_ww = get_option('dnwoo_mini_cart_window_width', '325');
        $mini_cart_hfs = get_option('dnwoo_mini_cart_heading_font_size', '20');
        $mini_cart_hc = get_option('dnwoo_mini_cart_heading_color', '#333333');
        $mini_cart_wimg_size = get_option('dnwoo_mini_cart_image_size', '70');
        $mini_cart_wtf = get_option('dnwoo_mini_cart_title_font', 'none');
        $mini_cart_wtc = get_option('dnwoo_mini_cart_title_color', '#333333');
        $mini_cart_wtfs = get_option('dnwoo_mini_cart_title_font_size', '16');
        $mini_cart_qpfc = get_option('dnwoo_mini_cart_quantity_price_font_color', '#999999');
        $mini_cart_qpfs = get_option('dnwoo_mini_cart_quantity_price_font_size', '14');
        $mini_cart_sfc = get_option('dnwoo_mini_cart_subtotal_font_color', '#333333');
        $mini_cart_sfs = get_option('dnwoo_mini_cart_subtotal_font_size', '16');

        $mini_cart_spfc = get_option('dnwoo_mini_cart_subtotal_price_font_color', '#333333');
        $mini_cart_spfs = get_option('dnwoo_mini_cart_subtotal_price_font_size', '21');

        $mini_cart_item_rbc = get_option('dnwoo_mini_cart_item_remove_btn_color', '#333333');
        $mini_cart_item_boc = get_option('dnwoo_mini_cart_item_border_color', 'rgba(0,0,0,0.1)');
        $mini_cart_vbc = get_option('dnwoo_view_cart_bg_color', '#FFFFFF');
        $mini_cart_vhbc = get_option('dnwoo_view_hbg_color', '#333333');
        $mini_cart_vtc = get_option('dnwoo_view_text_color', '#333333');
        $mini_cart_vbhtc = get_option('dnwoo_view_btn_hover_text_color', '#FFFFFF');
        $mini_cart_vbr = get_option('dnwoo_view_vbr', '0');
        $mini_cart_vbbc = get_option('dnwoo_view_button_border_color', 'rgba(0,0,0,0.2)');
        $mini_cart_vbfs = get_option('dnwoo_view_buttons_font_style', '', '', true);
        $mini_cart_vbf = get_option('dnwoo_view_buttons_font', 'none');

        

        ?>
<style type="text/css">
.dnwoo_minicart_wrapper .dnwoo_minicart_icon {
    color: <?php echo esc_html($mini_cart_icon_color) ?>;
    font-size: <?php echo esc_html($mini_cart_icon_size) ?>px;
    background-color: <?php echo esc_html($mini_cart_icon_bg) ?>;
    border-radius: <?php echo esc_html($mini_cart_icon_bgbr) ?>%;
}

.dnwoo_minicart_wrapper .dnwoo_count_number {
    background-color: <?php echo esc_html($mini_cart_count_bgc) ?>;
    color: <?php echo esc_html($mini_cart_count_cc) ?>;
}

.dnwoo_minicart_wrapper .dnwoo_minicart_cart_bag {
    background-color: <?php echo esc_html($mini_cart_icon_wbgc) ?>;
}

.dnwoo_minicart .dnwoo_minicart_wrapper .dnwoo_minicart_cart_bag {
    width: <?php echo esc_html($mini_cart_ww) ?>px;
}

.dnwoo_minicart_wrapper .dnwoo_minicart_items_heading,
.dnwoo_minicart_wrapper .woocommerce-mini-cart__empty-message {
    color: <?php echo esc_html($mini_cart_hc) ?>;
    font-size: <?php echo esc_html($mini_cart_hfs) ?>px;
}

.dnwoo_minicart_wrapper .dnwoo_minicart_cart_bag .woocommerce-mini-cart .mini_cart_item a {
    font-size: <?php echo esc_html($mini_cart_wtfs) ?>px;
    color: <?php echo esc_html($mini_cart_wtc) ?>;
    <?php echo sanitize_text_field(et_builder_get_font_family($mini_cart_wtf));// phpcs:ignore WordPress.Security.EscapeOutput ?>
}

.mini_cart_item .size-woocommerce_thumbnail {
    width: <?php echo esc_html($mini_cart_wimg_size) ?>px;
    height: <?php echo esc_html($mini_cart_wimg_size) ?>px;
}

.dnwoo_minicart_wrapper .dnwoo_minicart_cart_bag .woocommerce-mini-cart .mini_cart_item .quantity {
    font-size: <?php echo esc_html($mini_cart_qpfs) ?>px;
    color: <?php echo esc_html($mini_cart_qpfc) ?>;
}

.dnwoo_minicart_wrapper .dnwoo_minicart_cart_bag .woocommerce-mini-cart .mini_cart_item .remove_from_cart_button {
    color: <?php echo esc_html($mini_cart_item_rbc) ?>;
}

.dnwoo_minicart_wrapper .dnwoo_minicart_cart_bag .woocommerce-mini-cart .mini_cart_item {
    border-color: <?php echo esc_html($mini_cart_item_boc) ?>;
}

.woocommerce-mini-cart__total>strong {
    font-size: <?php echo esc_html($mini_cart_sfs) ?>px;
    color: <?php echo esc_html($mini_cart_sfc) ?>;
}

.woocommerce-mini-cart__total .woocommerce-Price-amount {
    font-size: <?php echo esc_html($mini_cart_spfs) ?>px;
    color: <?php echo esc_html($mini_cart_spfc) ?>;
}

.dnwoo_minicart_wrapper .woocommerce-mini-cart__buttons .dnwoo-viewcart {
    background-color: <?php echo esc_html($mini_cart_vbc) ?>;
    border-radius: <?php echo esc_html($mini_cart_vbr) ?>px;
    color: <?php echo esc_html($mini_cart_vtc) ?>;
    border-color: <?php echo esc_html($mini_cart_vbbc) ?>;
    <?php echo sanitize_text_field(et_builder_get_font_family($mini_cart_vbf));// phpcs:ignore WordPress.Security.EscapeOutput ?>
}

<?php if ('' !==$mini_cart_vbfs) {
    ?>.dnwoo_minicart_wrapper .woocommerce-mini-cart__buttons .dnwoo-viewcart {
        <?php echo esc_html(et_pb_print_font_style($mini_cart_vbfs, '!important'));// phpcs:ignore WordPress.Security.EscapeOutput ?>
    }

    <?php
}

?>
</style>
<?php

        if ('#333333' !== $mini_cart_vhbc) {
            ?>
<style type="text/css">
.dnwoo_minicart_wrapper .woocommerce-mini-cart__buttons .dnwoo-viewcart:hover {
    background-color: <?php echo esc_html($mini_cart_vhbc) ?> !important;
}
</style>
<?php
}

        if ('#FFFFFF' !== $mini_cart_vbhtc) {
            ?>
<style type="text/css">
.dnwoo_minicart_wrapper .woocommerce-mini-cart__buttons .dnwoo-viewcart:hover {
    color: <?php echo esc_html($mini_cart_vbhtc) ?>;
}
</style>
<?php
}

        $mini_cart_cbc = get_option('dnwoo_checkout_bg_color', '#333333');
        $mini_cart_chbc = get_option('dnwoo_checkout_hbg_color', '#FFFFFF');
        $mini_cart_ctc = get_option('dnwoo_checkout_text_color', '#FFFFFF');
        $mini_cart_cbhtc = get_option('dnwoo_checkout_btn_hover_text_color', '#333333');
        $mini_cart_cbr = get_option('dnwoo_mini_cart_cbr', '0');
        $mini_cart_cbbhc = get_option('dnwoo_checkout_btn_border_hover_color', 'rgba(0,0,0,0.2)');
        $mini_cart_cbfs = get_option('dnwoo_checkout_buttons_font_style', '', '', true);
        $mini_cart_cbf = get_option('dnwoo_checkout_buttons_font', 'none');

        ?>
<style type="text/css">
.dnwoo_minicart_wrapper .woocommerce-mini-cart__buttons .dnwoo-checkout {
    background-color: <?php echo esc_html($mini_cart_cbc) ?>;
    border-radius: <?php echo esc_html($mini_cart_cbr) ?>px;
    color: <?php echo esc_html($mini_cart_ctc) ?>;
    <?php echo sanitize_text_field(et_builder_get_font_family($mini_cart_cbf)); // phpcs:ignore WordPress.Security.EscapeOutput ?>
}

<?php if ('' !==$mini_cart_cbfs) {
    ?>.dnwoo_minicart_wrapper .woocommerce-mini-cart__buttons .dnwoo-checkout {
        <?php echo esc_html(et_pb_print_font_style($mini_cart_cbfs, '!important'));
        ?>
    }

    <?php
}

?>
</style>
<?php

        if ('#FFFFFF' !== $mini_cart_chbc) {
            ?>
<style type="text/css">
.dnwoo_minicart_wrapper .woocommerce-mini-cart__buttons .dnwoo-checkout:hover {
    background-color: <?php echo esc_html($mini_cart_chbc) ?> !important;
}
</style>
<?php
}

        if ('rgba(0,0,0,0.2)' !== $mini_cart_cbbhc) {
            ?>
<style type="text/css">
.dnwoo_minicart_wrapper .woocommerce-mini-cart__buttons .dnwoo-checkout:hover {
    border-color: <?php echo esc_html($mini_cart_cbbhc) ?>;
}
</style>
<?php
}

        if ('#333333' !== $mini_cart_chbc) {
            ?>
<style type="text/css">
.dnwoo_minicart_wrapper .woocommerce-mini-cart__buttons .dnwoo-checkout:hover {
    color: <?php echo esc_html($mini_cart_cbhtc) ?>;
}
</style>
<?php
}

$mini_cart_etc = get_option('dnwoo_empty_cart_text_color', '#333333');
$mini_cart_efs = get_option('dnwoo_empty_cart_text_font_size', '20');
$mini_cart_ebfs = get_option('dnwoo_empty_cart_font_style', '', '', true);
$mini_cart_etf = get_option('dnwoo_empty_cart_font', 'none');

// Coupon Code Text
$coupon_text_color = get_option('dnwoo_coupon_code_text_color', '#333333');
$coupon_icon_color = get_option('dnwoo_coupon_code_icon_color', '#333333');
$apply_btn_text_color = get_option('dnwoo_apply_button_text_color', '#FFFFFF');
$apply_btn_bg_color = get_option('dnwoo_apply_button_bg_color', '#333333');
$discount_text_color = get_option('dnwoo_discount_text_color', '#333333');
$discount_price_text_color = get_option('dnwoo_discount_price_color', '#E8112B');
$shipping_text_color = get_option('dnwoo_shipping_fee_text_color', '#333333');
$shipping_icon_color = get_option('dnwoo_shipping_icon_color', '#333333');
$tax_text_color = get_option('dnwoo_tax_fee_text_color', '#333333');
$total_text_color = get_option('dnwoo_total_price_text_color', '#333333');
$invaild_coupon_text_color = get_option('dnwoo_coupon_message_invaild_text_color', '#777C90');
$success_coupon_text_color = get_option('dnwoo_coupon_message_success_text_color', '#777C90');
$empty_coupon_text_color = get_option('dnwoo_coupon_message_empty_text_color', '#777C90');
$applied_coupon_text_color = get_option('dnwoo_coupon_message_applied_text_color', '#777C90');
$remove_coupon_text_color = get_option('dnwoo_coupon_message_remove_text_color', '#777C90');
$remove_coupon_code_color = get_option('dnwoo_discount_remove_coupon_color', '#009A34');

?>

<style type="text/css">
.widget_shopping_cart_content .woocommerce-mini-cart__empty-message {
    color: <?php echo esc_html($mini_cart_etc) ?>;
    font-size: <?php echo esc_html($mini_cart_efs) ?>px;
    <?php echo sanitize_text_field(et_builder_get_font_family($mini_cart_etf)); // phpcs:ignore WordPress.Security.EscapeOutput ?>
}

.dnwoo_minicart_wrapper .coupon-wrapper .cart-header, .dnwoo_minicart_wrapper .coupon-wrapper .cart-header:before{
    color: <?php echo esc_html($coupon_text_color) ?>;
}
.dnwoo_minicart_wrapper .coupon-wrapper .cart-header:after{
    color: <?php echo esc_html($coupon_icon_color) ?>;
}
button#minicart-apply-button{
    color: <?php echo esc_html($apply_btn_text_color) ?>;
    background-color: <?php echo esc_html($apply_btn_bg_color) ?>;
}
.dnwooe-coupon-label label {
    color: <?php echo esc_html($discount_text_color) ?>;
}
.discount-symbol, .discount-price .woocommerce-Price-amount {
    color: <?php echo esc_html($discount_price_text_color) ?>;
}
.dnwooe-shipping-fee, .dnwooe-shipping-fee span.woocommerce-Price-amount.amount {
    color: <?php echo esc_html($shipping_text_color) ?>;
}
.dnwooe-shipping-fee:before{
    color: <?php echo esc_html($shipping_text_color) ?>;
}
.dnwooe-tax-fee, .dnwooe-tax-fee span.woocommerce-Price-amount.amount {
    color: <?php echo esc_html($tax_text_color) ?>;
}
.dnwooe-order-total label, .dnwooe-order-total span.woocommerce-Price-amount.amount {
    color: <?php echo esc_html($total_text_color) ?>;
}
.dnwooe-invalid-msg {
    color: <?php echo esc_html($invaild_coupon_text_color) ?>;
}
.dnwooe-success-msg {
    color: <?php echo esc_html($success_coupon_text_color) ?>;
}
.dnwooe-empty-msg {
    color: <?php echo esc_html($empty_coupon_text_color) ?>;
}
.dnwooe-applied-msg {
    color: <?php echo esc_html($applied_coupon_text_color) ?>;
}
.dnwooe-remove-msg {
    color: <?php echo esc_html($remove_coupon_text_color) ?>;
}
#remove-coupon {
    color: <?php echo esc_html($remove_coupon_code_color) ?>;
    border: 2px solid <?php echo esc_html($remove_coupon_code_color) ?>;
}

<?php if ('' !== $mini_cart_ebfs) {
    ?>.widget_shopping_cart_content .woocommerce-mini-cart__empty-message {
        <?php echo esc_html(et_pb_print_font_style($mini_cart_ebfs, '!important'));// phpcs:ignore WordPress.Security.EscapeOutput ?>
    }

    <?php
}

?>

</style>
<?php


    }
}


add_action('wp_ajax_dnwoo_product_ajax_search', 'dnwoo_product_ajax_search');
add_action('wp_ajax_nopriv_dnwoo_product_ajax_search', 'dnwoo_product_ajax_search');

function dnwoo_arr_to_string_with_quotes($arrs) {
    $str = '';
    foreach($arrs as $arr) {
        $str .= "'$arr',";
    }
    return substr($str, 0, -1);
}
function get_category_by_product_id( $product_id ) {
    $terms = function_exists("wc_get_product_category_list") ?  wc_get_product_category_list($product_id) : '';
    return $terms;
}
function dnwoo_check_exist_in_array($fields, $search_in) {
    $str = '';
    foreach($fields as $key) {
        if( array_key_exists($key, $search_in) ) {
            $str .= $search_in[$key]. ',';
        } 
    }
    if( in_array('product_categories', $fields) || in_array('product_tags', $fields) ) {
        $str .= 'terms.name,terms.slug,';
    }
    return substr($str, 0,-1);
}

function dnwoo_product_ajax_search() {

        if ( isset( $_POST['searchNonce'] ) && ! wp_verify_nonce( sanitize_text_field( $_POST['searchNonce'] ), 'dnwoo_ajax_search_nonce' ) ) {
		wp_send_json_error();
	}


    $containerClass = isset( $_POST['containerClass'] ) ? sanitize_text_field( wp_unslash( $_POST['containerClass'] ) ) : 'dnwoo_ajax_search_masonry_layoutone';
    $image_size = isset( $_POST['thumbnailSize'] ) ? sanitize_text_field( wp_unslash( $_POST['thumbnailSize'] ) ) : 'woocommerce_thumbnail';

    $noResultText = isset( $_POST['noResultText'] ) ? sanitize_text_field( wp_unslash( $_POST['noResultText'] ) ) : '';
    $linkTarget = isset( $_POST['linkTarget'] ) ? sanitize_text_field( wp_unslash( $_POST['linkTarget'] ) ) : '';
    // Search Term
    $search_term        = isset( $_POST['searchTerm'] ) ? sanitize_text_field( wp_unslash( $_POST['searchTerm'] ) ) : '';
    // Search In
    $search_in = isset( $_POST['searchIn'] )? sanitize_text_field( wp_unslash( $_POST['searchIn'] ) ) : '';
    $search_in_arr = explode('|', $search_in);
    // Display fields
    $display = isset( $_POST['display'] )? sanitize_text_field( wp_unslash( $_POST['display'] ) ) : '';
    $display = explode('|', $display);
    // Order By
    $orderby = isset( $_POST['orderBy'] ) ? sanitize_text_field( wp_unslash( $_POST['orderBy'] ) ) : '';
    $order = isset( $_POST['order'] ) ? sanitize_text_field( wp_unslash( $_POST['order'] ) ) : 'DESC';
    $search_limit = isset( $_POST['search_limit'] ) ? sanitize_text_field( wp_unslash( $_POST['search_limit'] ) ) : '10';
    $categoryStatus = isset( $_POST['categoryStatus'] ) ? sanitize_text_field( wp_unslash( $_POST['categoryStatus'] ) ) : 'off';
    $selectedCategory = isset( $_POST['selectedCategory'] ) ? sanitize_text_field( wp_unslash( $_POST['selectedCategory'] ) ) : 'all';
    $categoryIds = isset( $_POST['categoryIds'] ) ? sanitize_text_field( wp_unslash( $_POST['categoryIds'] ) ) : '';
    
    $current_category = isset( $_POST['currentCategory'] ) ? sanitize_text_field( wp_unslash( $_POST['currentCategory'] ) ) : 'off';



    $search_items = array('product.ID', 'product.post_title', 'product.post_name', 'product.post_excerpt', 'product_data.sku','product_data.onsale', 'product_data.stock_status');
    $allowed_search_fields = array(
        'title' => 'product.post_title, product.post_name',
        'content' => 'product.post_content',
        'excerpt' => 'product.post_excerpt',
        'sku' => 'product_data.sku',
        'on_sale' => 'product_data.onsale',
        'stock_status' => 'product_data.stock_status',
        // 'product_categories' => 'terms.name terms.slug'
    );
    $search_in = dnwoo_check_exist_in_array($search_in_arr, $allowed_search_fields);
    $display_fields_query = "product.ID,";
    $display_fields_query .= dnwoo_check_exist_in_array($display, $allowed_search_fields);
    $category_fields = array('product_cat', 'product_tag');
    $post_types = array('product', 'product_variation');
    $post_status = array('publish');

    $post_type_str = dnwoo_arr_to_string_with_quotes($post_types);

    global $wpdb;

    $query = sprintf('select product.ID,product.post_parent ');
    $query .= sprintf('from %1$sposts as product left join %1$swc_product_meta_lookup as product_data on product.ID=product_data.product_id left join %1$sterm_relationships as relation on product.ID=relation.object_id left join %1$sterm_taxonomy as taxo on relation.term_taxonomy_id=taxo.term_taxonomy_id left join %1$sterms terms on terms.term_id=taxo.term_id ', $wpdb->prefix);
    $query .= sprintf('where product.post_type in (%1$s) ', $post_type_str);
    $query .= "and product.post_status='publish' ";

    if('off' == $current_category){
        if( 'all' != $selectedCategory && 'off' != $categoryStatus) {
            $query .= sprintf('and terms.term_id="%1$s" ', esc_sql($selectedCategory));
        }elseif( 'all' == $selectedCategory && '' != $categoryIds) {
            $categoryIds = explode(',', esc_sql($categoryIds));
            $categoryIds = "'" . implode("','",$categoryIds) . "'";
            $query .= sprintf('and terms.term_id in (%1$s) ', $categoryIds);
        }
    }elseif('on' == $current_category) {
        $categoryIds = explode(',', esc_sql($categoryIds));
        $categoryIds = "'" . implode("','",$categoryIds) . "'";
        $query .= sprintf('and terms.term_id in (%1$s) ', $categoryIds);
    }


    if((!in_array('custom_taxonomies', $search_in_arr))) {
        $category_fields_str = dnwoo_arr_to_string_with_quotes($category_fields);
        $query .= sprintf('and (taxo.taxonomy in (%1$s) ', $category_fields_str);
        
        if(in_array('attributes', $search_in_arr)){
            $query .= "or taxo.taxonomy like '%pa_%'";
        }
        $query .= ') ';
    }

    
    $query .= sprintf('and concat(%1$s) ', esc_sql($search_in));

    $query .= "like '%" . esc_sql($search_term) ."%' ";
    
    $query .= sprintf('group by product.ID order by product.%3$s %1$s limit %2$s;', esc_sql($order), esc_sql(absint($search_limit)), esc_sql($orderby));
    $results = $wpdb->get_results($query, OBJECT);// phpcs:ignore



    $late_query = array_filter($display, function($item) {
        $will_check_late = array('thumbnail', 'category', 'rating_count', 'product_price');
        return in_array($item, $will_check_late);
    });


    // -- We need - id, thumbnail image,title,price,excerpt,category, rating count
    // -- Search In - title, content, excerpt, product categories, product tags, custom taxonomies, attributes, sku
    // -- Order By - date, modified date, title, slug, id
    // -- Order - asc, desc --
    // -- Search Result Number Limit - 10 --
    $result_html = '';
    // $result_arr = [];
    if( 0 == count($results) ):
        $result_html .= sprintf('<div class="dnwoo_ajax_search_result "><div class="dnwoo_ajax_search_items %1$s"><p class="dnwoo_no_result">%2$s</p></div></div', $containerClass, $noResultText);
    endif;
    if( count($results) > 0 ) :
        $result_ids = array_column($results, 'ID');
        $parent_ids = [];
        $gutter_item = 'dnwoo_ajax_search_masonry_layoutthree' == $containerClass ? '<div class="dnwoo_search_item_masonry"><div class="gutter-sizer"></div>' : '';
        $result_html .= sprintf('<div class="dnwoo_ajax_search_items %1$s grid">%2$s', $containerClass, $gutter_item);

        foreach ($result_ids as $key) :
            $ID = intval($key);
            $parent_id = wp_get_post_parent_id( $ID );
            if( $parent_id ):
                if( in_array( $parent_id, $result_ids ) ):
                    continue;
                endif;
                $ID = $parent ? intval( $parent_id ) : $ID;
            endif;

            $_product = wc_get_product($ID);
            
            $thumbnail = (in_array('thumbnail', $display) && has_post_thumbnail($ID)) ? sprintf('<div class="dnwoo_ajax_search_img">%1$s</div>', get_the_post_thumbnail($ID, $image_size)) : '';
            $excerpt = in_array('excerpt', $display) ? sprintf('<p class="dnwoo_ajax_search_item_des">%1$s</p>', get_the_excerpt($ID) ) : '';
            // $category = wc_get_product_category_list($ID);
            $permalink = get_permalink($ID);
            $title = in_array('title', $display) ? sprintf('<p class="dnwoo_ajax_search_title">%1$s</p>',$_product->get_title() ) : '';

            $price_html = in_array('product_price', $display) ? $_product->get_price_html() : '';
            $stock_status = $_product->get_stock_status();
            $is_on_sale = (in_array('on_sale', $display) && '1' == $_product->is_on_sale()) ? '<div class="dnwoo_ajax_search_onsale_withprice">Sale</div>' : '';

            $rating_count = (in_array('rating_count', $display) && $_product->get_rating_count() > 0) ? sprintf('<div class="dnwoo_ajax_search_item_ratting_count"><span>(%1$s)</span></div>', $_product->get_rating_count() ) : '';

            $is_featured = $_product->is_featured();
            $product_rating = in_array('star_rating', $display) ? wc_get_rating_html($_product->get_average_rating(), $_product->get_rating_count()) : '';
            $product_avg_rating_count = in_array('star_rating', $display) ? '<div class="dnwoo_product_ratting"><div class="star-rating"><span style="width:0%">'.esc_html__('Rated', 'dnwooe').' <strong class="rating">'.esc_html__('0', 'dnwooe').'</strong> '.esc_html__('out of 5', 'dnwooe').'</span>'.$product_rating.'</div></div>' : '';

            $rating_div = ('' != $product_rating && '' != $rating_count) ? sprintf('<div class="dnwoo_ajax_search_item_ratting_count_combined">
                <div class="dnwoo_ajax_search_item_ratting">
                    %1$s
                </div>
                %2$s
            </div>',$product_avg_rating_count, $rating_count) : '';

            $result_html .= sprintf('
            <div class="dnwoo_ajax_search_single_item_wrapper grid-item">
            <div class="dnwoo_ajax_search_wrapper_inner">
              <a href="%1$s" class="dnwoo_ajax_search_item_link" target="%8$s">
                %2$s
                
                <div class="dnwoo_ajax_search_content_wrapper">
                    %3$s
                    %4$s
                  
    
                  <div class="dnwoo_ajax_search_pricewithsalecombined">
                    %5$s
                    %6$s
                    </div>
                    
                    %7$s
                </div>
              </a>
            </div>
          </div>',
          $permalink,
          $thumbnail,
            $title,
            $rating_div,
            $price_html,
            $is_on_sale,
            $excerpt,
            $linkTarget
        );


        endforeach;

        $result_html .= 'dnwoo_ajax_search_masonry_layoutthree' == $containerClass ? '</div>' : '';
        $result_html .= '</div>';
    endif;

    wp_send_json(array(
        // 'query' => $query,
        // 'display' => $display,
        // 'category_status' => $categoryStatus,
        // 'categoryIds' => $categoryIds,
        // 'current_category' => $current_category,
        // 'selectedCategory' =>$selectedCategory,
        'result_html' => $result_html,
    ));
    wp_die();
}

add_action('wp_ajax_dnwoo_ajax_add_to_cart', 'dnwoo_ajax_add_to_cart');
add_action('wp_ajax_nopriv_dnwoo_ajax_add_to_cart', 'dnwoo_ajax_add_to_cart');

function dnwoo_ajax_add_to_cart() {
    if (isset($_POST['dnwoo_ajax_add_to_cart']) && !wp_verify_nonce(sanitize_text_field($_POST['dnwoo_ajax_add_to_cart']), 'dnwoo_ajax_add_to_cart')) {
        wp_send_json_error();
    }

    $id = isset($_POST['product_id']) ? sanitize_text_field($_POST['product_id']) : '';
    $quantity = isset($_POST['quantity']) ? sanitize_text_field($_POST['quantity']) : '';
    $variation_id = isset($_POST['variation_id']) ? sanitize_text_field($_POST['variation_id']) : '';
    $attributes = isset($_POST['attributes']) ? array_map('sanitize_text_field', $_POST['attributes']) : '';

    $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($id));
    $quantity = $quantity ? 1 : wc_stock_amount($quantity);
    $variation_id = absint($variation_id);
    $variation  = array();

    if($attributes) {
        foreach($attributes as $key => $value) {
            $variation[$key] = $value;
        }
    }
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variation);
    $product_status = get_post_status($product_id);

    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation) && 'publish' === $product_status) {
        do_action('woocommerce_ajax_added_to_cart', $product_id);

        if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
            wc_add_to_cart_message(array($product_id => $quantity), true);
        }

        WC_AJAX::get_refreshed_fragments();
    } else {
        $data = array(
            'error' => true,
            'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

        wp_send_json($data);
    }

    wp_die();
}




function enqueue_mini_cart_coupon_script() {
    wp_enqueue_script(
        'mini-cart-coupon',
        DNWOO_ESSENTIAL_ASSETS . '/js/dnwoo.minicart-coupon.js',
        array('jquery'),
        null,
        true
    );

    wp_localize_script(
        'mini-cart-coupon',
        'miniCartCoupon',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('mini_cart_coupon_nonce')
        )
    );
}
add_action('wp_enqueue_scripts', 'enqueue_mini_cart_coupon_script');

// Apply Coupon Code
add_action('wp_ajax_apply_mini_cart_coupon', 'apply_mini_cart_coupon');
add_action('wp_ajax_nopriv_apply_mini_cart_coupon', 'apply_mini_cart_coupon');
function apply_mini_cart_coupon() {
    check_ajax_referer('mini_cart_coupon_nonce', 'nonce');


    $coupon_code = isset($_POST['coupon_code']) ? sanitize_text_field($_POST['coupon_code']) : '';
    $coupon_code = strtolower($coupon_code);

    /* Check if coupon code is empty */
    if ( empty($coupon_code) || !isset($coupon_code) ) {
        $message_empty_cz = get_option('dnwoo_coupon_message_empty_text', __('Coupon code is Empty', 'dnwooe'));
        $empty_msg = '<label class="dnwooe-empty-msg">'. esc_html($message_empty_cz) .'</label>';
        ob_start();
    
        WC()->cart->calculate_totals();
        WC()->cart->maybe_set_cart_cookies();
    
        woocommerce_mini_cart();
    
        $mini_cart = ob_get_clean();
        wp_send_json_error([
            'result' => 'empty',
            'message' => $empty_msg,
            'fragments' => apply_filters('woocommerce_add_to_cart_fragments', array(
                'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
            )),
        ]);
    }

    /* Create an instance of WC_Coupon with our code */
    $coupon = new WC_Coupon($coupon_code);
    $applied_coupons = WC()->cart->get_applied_coupons();


    if( $applied_coupons ) {
        $message_applied_cz = get_option('dnwoo_coupon_message_applied_text', __('Coupon Code already applied', 'dnwooe'));
        $applied_msg = '<label class="dnwooe-applied-msg">'. esc_html($message_applied_cz) .'</label>';
        ob_start();
    
        WC()->cart->calculate_totals();
        WC()->cart->maybe_set_cart_cookies();
    
        woocommerce_mini_cart();
    
        $mini_cart = ob_get_clean();
        wp_send_json_error([
            'result' => 'already applied',
            'message' => $applied_msg,
            'fragments' => apply_filters('woocommerce_add_to_cart_fragments', array(
                'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
            )),
        ]);
    } else if(!$coupon->is_valid()){
        WC()->cart->apply_coupon($coupon_code);
        $message_invaild_cz = get_option('dnwoo_coupon_message_invaild_text', __('Coupon Code is Invalid!', 'dnwooe'));
        $invalid_msg = '<label class="dnwooe-invalid-msg">'. esc_html($message_invaild_cz) .'</label>';
        ob_start();
    
        WC()->cart->calculate_totals();
        WC()->cart->maybe_set_cart_cookies();
    
        woocommerce_mini_cart();
    
        $mini_cart = ob_get_clean();

        wp_send_json_error([
            'result' => 'invalid',
            'message' => $invalid_msg,
            'fragments' => apply_filters('woocommerce_add_to_cart_fragments', array(
                'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
            )),
        ]);
    } else {
            WC()->cart->apply_coupon($coupon_code);

            $message_success_cz = get_option('dnwoo_coupon_message_success_text', __('Coupon applied successfully', 'dnwooe'));
            $success_msg = '<label class="dnwooe-success-msg">'. esc_html($message_success_cz) .'</label>';

            ob_start();
        
            WC()->cart->calculate_totals();
            WC()->cart->maybe_set_cart_cookies();
        
            woocommerce_mini_cart();
        
            $mini_cart = ob_get_clean();
            $response = array(
                'message' =>   $success_msg,
                'fragments' => apply_filters('woocommerce_add_to_cart_fragments', array(
                        'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
                )),
                
            );
        
        wp_send_json_success($response);   
    }
}


// Remove Coupon Code
add_action('wp_ajax_dnwooe_remove_mini_cart_coupon_code', 'dnwooe_remove_mini_cart_coupon_code');
add_action('wp_ajax_nopriv_dnwooe_remove_mini_cart_coupon_code', 'dnwooe_remove_mini_cart_coupon_code');

function dnwooe_remove_mini_cart_coupon_code() {
    check_ajax_referer('mini_cart_coupon_nonce', 'nonce');

    $remove_coupon = isset($_POST['coupon_code']) ? sanitize_text_field($_POST['coupon_code']) : '';

    $message_remove_cz = get_option('dnwoo_coupon_message_remove_text', __('Coupon Removed Successfully.', 'dnwooe'));
    $remove_msg = '<label class="dnwooe-remove-msg">'. esc_html($message_remove_cz) .'</label>';

    if (WC()->cart->remove_coupon($remove_coupon)) {
        ob_start();
        
        WC()->cart->calculate_totals();
        WC()->cart->maybe_set_cart_cookies();
    
        woocommerce_mini_cart();
    
        $mini_cart = ob_get_clean();
        wp_send_json_success([
            'message' => $remove_msg,
            'fragments' => apply_filters('woocommerce_add_to_cart_fragments', array(
                'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
        )),
        ]);
    }

    die();
}

add_action('wp_ajax_get_refresh_fragments', 'get_refreshed_fragments');
add_action('wp_ajax_nopriv_get_refresh_fragments', 'get_refreshed_fragments');

