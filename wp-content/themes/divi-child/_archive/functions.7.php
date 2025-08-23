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

// Add custom short description field to YITH Brands edit form
add_action('yith_product_brand_add_form_fields', 'add_brand_short_description_field');
add_action('yith_product_brand_edit_form_fields', 'add_brand_short_description_field');
function add_brand_short_description_field($term) {
    // If editing, get the existing value
    $short_description = '';
    if (is_object($term)) {
        $short_description = get_term_meta($term->term_id, 'short_description', true);
    }
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="short_description">Card Short Description</label></th>
        <td>
            <textarea name="short_description" id="short_description" rows="3" cols="50"><?php echo esc_textarea($short_description); ?></textarea>
            <p class="description">Enter a short description for the brand card (recommended: at least 50 characters).</p>
        </td>
    </tr>
    <?php
}

// Save the custom short description field
add_action('created_yith_product_brand', 'save_brand_short_description');
add_action('edited_yith_product_brand', 'save_brand_short_description');
function save_brand_short_description($term_id) {
    if (isset($_POST['short_description'])) {
        $short_description = sanitize_textarea_field($_POST['short_description']);
        update_term_meta($term_id, 'short_description', $short_description);
    }
}

function custom_brand_grid_shortcode() {
    ob_start();

    $brands = get_terms(array(
        'taxonomy' => 'yith_product_brand',
        'hide_empty' => false,
    ));

    $default_logo_url = get_stylesheet_directory_uri() . '/images/placeholder-logo.png';
    ?>
    <div class="brand-grid">
        <?php
        foreach ($brands as $brand) {
            $logo_id = get_term_meta($brand->term_id, 'thumbnail_id', true);
            $logo_url = $logo_id ? wp_get_attachment_url($logo_id) : $default_logo_url;
            $brand_link = get_term_link($brand);
            $short_description = get_term_meta($brand->term_id, 'short_description', true);
            // Ensure minimum length of 50 characters
            $min_length = 50;
            if (strlen($short_description) < $min_length) {
                $short_description .= str_repeat(' ', $min_length - strlen($short_description));
            }
            ?>
            <div class="brand-item">
                <a href="<?php echo esc_url($brand_link); ?>" class="brand-logo-wrapper">
                    <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($brand->name); ?>" class="brand-logo">
                </a>
                <div class="brand-info">
                    <div class="brand-title"><?php echo esc_html(strtoupper($brand->name)); ?></div>
                    <div class="brand-description"><?php echo esc_html($short_description); ?></div>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('brand_grid', 'custom_brand_grid_shortcode');

function pfc_yith_brand_description_shortcode() {
    if (is_tax('yith_product_brand')) {
        $term = get_queried_object();
        if ($term && isset($term->description)) {
            return wpautop($term->description);
        }
    }
    return '';
}
add_shortcode('brand_description', 'pfc_yith_brand_description_shortcode');

// Brand logo shortcode
function pfc_brand_logo() {
    if (is_tax('yith_product_brand')) {
        $term = get_queried_object();
        $logo_id = get_term_meta($term->term_id, 'thumbnail_id', true);
        $logo_url = wp_get_attachment_url($logo_id);
        if ($logo_url) {
            return '<img src="' . esc_url($logo_url) . '" alt="' . esc_attr($term->name) . ' Logo" style="max-width: 200px; margin-bottom: 20px;" />';
        }
    }
    return '';
}
add_shortcode('brand_logo', 'pfc_brand_logo');

// Brand name shortcode
function pfc_brand_name() {
    if (is_tax('yith_product_brand')) {
        $term = get_queried_object();
        return '<h1>' . esc_html($term->name) . '</h1>';
    }
    return '';
}
add_shortcode('brand_name', 'pfc_brand_name');

// Brand description shortcode
function pfc_brand_description() {
    if (is_tax('yith_product_brand')) {
        return '<div class="brand-description" style="margin: 20px 0;">' . term_description() . '</div>';
    }
    return '';
}
add_shortcode('brand_description', 'pfc_brand_description');

// Brand products toggle shortcode
function pfc_brand_products_toggle() {
    if (is_tax('yith_product_brand')) {
        $term = get_queried_object();

        $args = array(
            'post_type' => 'product',
            'tax_query' => array(
                array(
                    'taxonomy' => 'yith_product_brand',
                    'field'    => 'slug',
                    'terms'    => $term->slug,
                ),
            ),
            'posts_per_page' => -1,
        );
        $products = new WP_Query($args);

        ob_start();

        ?>
        <button id="toggle-products" style="padding: 10px 20px; background-color: #0073aa; color: white; border: none; border-radius: 4px; cursor: pointer;">
            View This Brand's Products
        </button>

        <div id="brand-products" style="margin-top: 40px; display: none;">
            <?php
            if ($products->have_posts()) :
                echo '<ul class="products columns-4">';
                while ($products->have_posts()) : $products->the_post();
                    wc_get_template_part('content', 'product');
                endwhile;
                echo '</ul>';
                wp_reset_postdata();
            else :
                echo '<p>No products found for this brand.</p>';
            endif;
            ?>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            var btn = document.getElementById('toggle-products');
            var productSection = document.getElementById('brand-products');
            if(btn){
                btn.addEventListener('click', function () {
                    if (productSection.style.display === 'none') {
                        productSection.style.display = 'block';
                        this.textContent = 'Hide Products';
                    } else {
                        productSection.style.display = 'none';
                        this.textContent = "View This Brand's Products";
                    }
                });
            }
        });
        </script>
        <?php

        return ob_get_clean();
    }
    return '';
}
add_shortcode('brand_products_toggle', 'pfc_brand_products_toggle');

function pfc_brand_dropdown_shortcode() {
    $brands = get_terms(array(
        'taxonomy' => 'yith_product_brand',
        'hide_empty' => false,
    ));

    if (empty($brands) || is_wp_error($brands)) {
        return ''; // no brands found
    }

    ob_start();
    ?>
    <form id="brand-selector" style="margin-bottom: 30px; text-align: center;">
        <select onchange="if(this.value) window.location.href=this.value;" style="padding:8px 12px; font-size:16px; max-width:300px; border-radius:4px; border:1px solid #ccc;">
            <option value=""><?php echo esc_html__('Select a Brand', 'your-textdomain'); ?></option>
            <?php
            $current_brand_id = get_queried_object_id();
            foreach ($brands as $brand) : ?>
                <option value="<?php echo esc_url(get_term_link($brand)); ?>" <?php selected($current_brand_id, $brand->term_id); ?>>
                    <?php echo esc_html($brand->name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('brand_dropdown', 'pfc_brand_dropdown_shortcode');


