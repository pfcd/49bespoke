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
            wp_update_post(array(
                'ID' => $variation_id,
                'post_title' => $new_title
            ));
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

add_action('admin_head', 'variation_title_field_styles');
function variation_title_field_styles() {
    echo '<style>
        .variation-custom-title { margin: 10px 0; }
        .variation-custom-title label { display: block; margin-bottom: 5px; }
        .variation-custom-title input { width: 100%; max-width: 300px; }
    </style>';
}

add_shortcode('dynamic_product_table', 'dynamic_category_product_table');

function dynamic_category_product_table() {
    error_log('Dynamic Product Table: Function called | Page: ' . get_permalink());
    
    if (is_product_category()) {
        $current_category = get_queried_object();
        $category_slug = $current_category && isset($current_category->slug) ? $current_category->slug : 'none';
        error_log('Dynamic Product Table: is_product_category=true | Category Slug: ' . $category_slug);
        return do_shortcode('[product_table id="1" category="' . $category_slug . '"]');
    }
    
    error_log('Dynamic Product Table: Default table (no category)');
    return do_shortcode('[product_table id="1"]');
}

add_action('yith_product_brand_add_form_fields', 'add_brand_short_description_field');
add_action('yith_product_brand_edit_form_fields', 'add_brand_short_description_field');
function add_brand_short_description_field($term) {
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
        <?php foreach ($brands as $brand) {
            $logo_id = get_term_meta($brand->term_id, 'thumbnail_id', true);
            $logo_url = $logo_id ? wp_get_attachment_url($logo_id) : $default_logo_url;
            $brand_link = get_term_link($brand);
            $short_description = get_term_meta($brand->term_id, 'short_description', true);
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

function pfc_brand_name() {
    if (is_tax('yith_product_brand')) {
        $term = get_queried_object();
        return '<h1>' . esc_html($term->name) . '</h1>';
    }
    return '';
}
add_shortcode('brand_name', 'pfc_brand_name');

function pfc_brand_description() {
    if (is_tax('yith_product_brand')) {
        return '<div class="brand-description" style="margin: 20px 0;">' . term_description() . '</div>';
    }
    return '';
}
add_shortcode('brand_description', 'pfc_brand_description');

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
        <button id="toggle-products" style="padding: 10px 20px; background-color: #c61921; color: white; border: none; border-radius: 20px; cursor: pointer; font-weight: bold;">
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
        return '';
    }

    ob_start();
    $current_brand_id = get_queried_object_id();
    ?>
    <style>
        .pfc-brand-dropdown-wrapper {
            text-align: center;
            margin-bottom: 30px;
        }
        .pfc-brand-dropdown {
            padding: 10px 16px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #fff;
            color: #333;
            cursor: pointer;
            max-width: 300px;
            width: 100%;
        }
        @media screen and (max-width: 480px) {
            .pfc-brand-dropdown {
                font-size: 14px;
            }
        }
    </style>
    <div class="pfc-brand-dropdown-wrapper">
        <select class="pfc-brand-dropdown" onchange="if(this.value) window.location.href=this.value;">
            <option value=""><?php echo esc_html__('Select a Brand', 'your-textdomain'); ?></option>
            <?php foreach ($brands as $brand) : ?>
                <option value="<?php echo esc_url(get_term_link($brand)); ?>" <?php selected($current_brand_id, $brand->term_id); ?>>
                    <?php echo esc_html($brand->name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('brand_dropdown', 'pfc_brand_dropdown_shortcode');

function pfc_brand_card_short_description_shortcode() {
    if (is_tax('yith_product_brand')) {
        $term = get_queried_object();
        $short_description = get_term_meta($term->term_id, 'short_description', true);
        if (!empty($short_description)) {
            return '<div class="brand-short-description" style="margin: 20px 0; font-size: 0.7em;">' . esc_html($short_description) . '</div>';
        }
    }
    return '';
}
add_shortcode('brand_short_description', 'pfc_brand_card_short_description_shortcode');

function register_custom_brand_post_type() {
    $labels = array(
        'name'               => 'Brands',
        'singular_name'      => 'Brand',
        'menu_name'          => 'Brands (Custom)',
        'add_new'            => 'Add New Brand',
        'add_new_item'       => 'Add New Brand',
        'edit_item'          => 'Edit Brand',
        'new_item'           => 'New Brand',
        'view_item'          => 'View Brand',
        'search_items'       => 'Search Brands',
        'not_found'          => 'No brands found',
        'not_found_in_trash' => 'No brands found in Trash',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-tag',
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'brands' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'page-attributes' ),
        'show_in_rest'       => true,
    );

    register_post_type( 'custom_brand', $args );
}
add_action( 'init', 'register_custom_brand_post_type' );

// Enable Divi Builder for custom_brand
function enable_divi_on_custom_post_types($post_types) {
    $post_types[] = 'custom_brand';
    return $post_types;
}
add_filter('et_builder_post_types', 'enable_divi_on_custom_post_types');

// Automatically create a custom_brand post when a YITH brand is created or edited
add_action('created_yith_product_brand', function($term_id) {
    // Get term object
    $term = get_term($term_id, 'yith_product_brand');

    if (!$term || is_wp_error($term)) {
        error_log("Failed to get brand term.");
        return;
    }

    // Check if a custom post already exists for this brand
    $existing = get_posts([
        'post_type'  => 'custom_brand',
        'meta_query' => [
            [
                'key'     => '_yith_brand_term_id',
                'value'   => $term_id,
                'compare' => '='
            ]
        ],
        'posts_per_page' => 1
    ]);

    if ($existing) {
        error_log("Post for brand ID $term_id already exists.");
        return;
    }

    // Create the custom post
    $post_id = wp_insert_post([
        'post_title'  => $term->name,
        'post_type'   => 'custom_brand',
        'post_status' => 'publish',
    ]);

    if (is_wp_error($post_id)) {
        error_log("Failed to create custom_brand post.");
        return;
    }

    // Link the custom post to the term via post meta
    update_post_meta($post_id, '_yith_brand_term_id', $term_id);

    error_log("Created custom_brand post ID $post_id for brand ID $term_id.");
});

// Hook into the YITH brand edit form
add_action('yith_product_brand_edit_form_fields', function($term) {
    // Look for a custom_brand post that has a meta value matching this brand ID
    $linked_post = get_posts(array(
        'post_type'  => 'custom_brand',
        'meta_key'   => '_yith_brand_id',
        'meta_value' => $term->term_id,
        'posts_per_page' => 1
    ));

    if (!empty($linked_post)) {
        $post = $linked_post[0];
        $edit_link = get_edit_post_link($post->ID);
        ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label>Custom Brand Page</label>
            </th>
            <td>
                <a href="<?php echo esc_url($edit_link); ?>" class="button button-secondary" target="_blank">Edit Linked Brand Page</a>
                <p class="description">Click to edit the custom post associated with this YITH brand.</p>
            </td>
        </tr>
        <?php
    } else {
        ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label>Custom Brand Page</label>
            </th>
            <td>
                <em>No linked brand page found.</em>
            </td>
        </tr>
        <?php
    }
});

// Add meta box to custom_brand post edit screen
function add_custom_brand_meta_box() {
    add_meta_box(
        'linked_yith_brand',
        'Linked YITH Brand',
        'render_custom_brand_meta_box',
        'custom_brand',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'add_custom_brand_meta_box');

// Render the meta box content
function render_custom_brand_meta_box($post) {
    $term_id = get_post_meta($post->ID, '_yith_brand_id', true);

    if ($term_id) {
        $term = get_term($term_id, 'yith_product_brand');
        if (!is_wp_error($term)) {
            $edit_link = get_edit_term_link($term_id, 'yith_product_brand');
            echo '<p><strong>Brand:</strong> ' . esc_html($term->name) . '</p>';
            echo '<p><a href="' . esc_url($edit_link) . '" class="button button-primary" target="_blank">Edit YITH Brand</a></p>';
        } else {
            echo '<p>Linked term not found.</p>';
        }
    } else {
        echo '<p>No YITH brand linked.</p>';
    }
}
