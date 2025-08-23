<?php
// Add custom title field to variation admin panel
add_action('woocommerce_variation_options_pricing', 'add_variation_title_field', 10, 3);
function add_variation_title_field($loop, $variation_data, $variation) {
    if (!is_object($variation) || !isset($variation->ID)) {
        error_log("Variation object invalid for loop $loop");
        return;
    }
    $variation_product = wc_get_product($variation->ID);
    if (!$variation_product) {
        error_log("Could not load variation product for ID: " . $variation->ID);
        return;
    }
    $current_title = get_the_title($variation->ID);
    $variation_id = esc_attr($variation->ID);
    $current_title_escaped = esc_attr($current_title);
    
    echo '<div class="variation-custom-title">';
    echo '<p class="form-row form-row-full">';
    echo '<label>' . esc_html__('Variation Title', 'woocommerce') . '</label>';
    echo '<input type="text" class="variation_title_input" name="variable_post_title[' . $variation_id . ']" value="' . $current_title_escaped . '" placeholder="Enter custom variation title">';
    echo '</p>';
    echo '</div>';
}

// Save the custom variation title when product variations are saved
add_action('woocommerce_save_product_variation', 'save_variation_titles', 10, 2);
function save_variation_titles($variation_id, $i) {
    if (isset($_POST['variable_post_title'][$variation_id])) {
        $new_title = sanitize_text_field($_POST['variable_post_title'][$variation_id]);

        if (!empty($new_title)) {
            // Update the variation title directly in the database
            wp_update_post(array(
                'ID' => $variation_id,
                'post_title' => $new_title
            ));

            // Clear cache
            wc_delete_product_transients($variation_id);
            clean_post_cache($variation_id);

            error_log("Variation title saved for ID: $variation_id - New title: $new_title");
        } else {
            error_log("Variation title is empty for ID: $variation_id");
        }
    }
}

// Override the variation title on frontend when a user selects a variation
add_filter('woocommerce_product_variation_title', 'display_custom_variation_title', 10, 4);
function display_custom_variation_title($title, $product, $title_base, $variation) {
    if (!is_object($variation)) {
        error_log("Variation object invalid in display_custom_variation_title");
        return $title;
    }
    $custom_title = get_the_title($variation->get_id());
    return $custom_title ?: $title;
}

// Update cart item name to use custom variation title
add_filter('woocommerce_cart_item_name', 'custom_cart_variation_name_frontend', 10, 3);
function custom_cart_variation_name_frontend($title, $cart_item, $cart_item_key) {
    if (isset($cart_item['variation_id']) && $cart_item['variation_id'] > 0) {
        $variation = wc_get_product($cart_item['variation_id']);
        if ($variation) {
            $custom_title = get_the_title($cart_item['variation_id']);
            return $custom_title ?: $title;
        }
    }
    return $title;
}

// Optional admin styling
add_action('admin_head', 'variation_title_field_styles');
function variation_title_field_styles() {
    echo '<style>
        .variation-custom-title { margin: 10px 0; }
        .variation-custom-title label { display: block; margin-bottom: 5px; }
        .variation-custom-title input { width: 100%; max-width: 300px; }
    </style>';
}

function dynamic_category_product_table() {
    if (is_product_category()) {
        $current_category = get_queried_object();
        $category_slug = $current_category->slug;
        return do_shortcode('[product_table id="1" category="' . $category_slug . '"]');
    }
    return do_shortcode('[product_table id="1"]');
}

function custom_brand_grid_shortcode() {
    ob_start();

    $brands = get_terms(array(
        'taxonomy' => 'yith_product_brand',
        'hide_empty' => false,
    ));

    // Default placeholder image URL (change this to your own placeholder image if needed)
    $default_logo_url = get_stylesheet_directory_uri() . '/images/placeholder-logo.png';
    ?>

    <style>
    .custom-brand-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 30px;
        justify-items: center;
        align-items: center;
        padding: 2rem 0;
    }
    .custom-brand-grid .brand-logo {
        display: block;
        text-align: center;
        transition: transform 0.3s ease;
    }
    .custom-brand-grid .brand-logo img {
        max-height: 100px;
        max-width: 100%;
        object-fit: contain;
    }
    .custom-brand-grid .brand-logo:hover img {
        transform: scale(1.05);
    }
    </style>

    <div class="custom-brand-grid">
        <?php
        foreach ($brands as $brand) {
            $logo_id = get_term_meta($brand->term_id, 'thumbnail_id', true);
            $logo_url = $logo_id ? wp_get_attachment_url($logo_id) : $default_logo_url;
            $brand_link = get_term_link($brand);
            ?>
            <a href="<?php echo esc_url($brand_link); ?>" class="brand-logo">
                <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($brand->name); ?>">
            </a>
        <?php } ?>
    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('brand_grid', 'custom_brand_grid_shortcode');
