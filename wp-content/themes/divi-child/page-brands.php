<?php
// Add custom title field to variation admin panel
add_action('woocommerce_variation_options_pricing', 'add_variation_title_field', 10, 3);
function add_variation_title_field($loop, $variation_data, $variation) {
    if (!is_object($variation) || !isset($variation->ID)) {
        return;
    }
    $variation_product = wc_get_product($variation->ID);
    if (!$variation_product) {
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
        }
    }
}

// Override the variation title on frontend when a user selects a variation
add_filter('woocommerce_product_variation_title', 'display_custom_variation_title', 10, 4);
function display_custom_variation_title($title, $product, $title_base, $variation) {
    if (!is_object($variation)) {
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
    if (is_product_category()) {
        $current_category = get_queried_object();
        $category_slug = $current_category && isset($current_category->slug) ? $current_category->slug : 'none';
        return do_shortcode('[product_table id="1" category="' . $category_slug . '"]');
    }
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

function brand_grid_shortcode() {
    // Get all brand terms
    $all_brands = get_terms(array(
        'taxonomy' => 'yith_product_brand',
        'hide_empty' => false
    ));

    // Filter brands based on show_in_brand_partners
    $brands = array_filter($all_brands, function($brand) {
        return get_term_meta($brand->term_id, 'show_in_brand_partners', true) === '1';
    });

    // If no brands, return a message
    if (empty($brands) || is_wp_error($brands)) {
        return '<p>No brand partners found.</p>';
    }

    // Output the grid
    ob_start();
    echo '<div class="brand-grid">';
    foreach ($brands as $brand) {
        $link = get_term_link($brand);
        $image_id = get_term_meta($brand->term_id, 'thumbnail_id', true);
        $logo = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
        echo '<div class="brand-item">';
        if ($logo) echo '<a href="' . esc_url($link) . '"><img src="' . esc_url($logo) . '" alt="' . esc_attr($brand->name) . '"></a>';
        echo '<h4><a href="' . esc_url($link) . '">' . esc_html($brand->name) . '</a></h4>';
        if ($brand->description) echo '<p>' . esc_html($brand->description) . '</p>';
        echo '</div>';
    }
    echo '</div>';

    return ob_get_clean();
}
add_shortcode('brand_grid', 'brand_grid_shortcode');

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
        <button id="toggle-products" style="padding: 10px 20px; margin-bottom: 20px;">Show Products</button>
        <div id="brand-products" style="display:none;">
            <ul>
            <?php while ($products->have_posts()) : $products->the_post(); ?>
                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php endwhile; wp_reset_postdata(); ?>
            </ul>
        </div>
        <script>
        document.getElementById('toggle-products').addEventListener('click', function() {
            var prodDiv = document.getElementById('brand-products');
            if (prodDiv.style.display === 'none') {
                prodDiv.style.display = 'block';
                this.textContent = 'Hide Products';
            } else {
                prodDiv.style.display = 'none';
                this.textContent = 'Show Products';
            }
        });
        </script>
        <?php
        return ob_get_clean();
    }
    return '';
}
add_shortcode('brand_products_toggle', 'pfc_brand_products_toggle');

// Register custom post type for brands
function register_custom_brand_post_type() {
    $labels = array(
        'name' => 'Custom Brands',
        'singular_name' => 'Custom Brand',
        'menu_name' => 'Custom Brands',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Custom Brand',
        'edit_item' => 'Edit Custom Brand',
        'new_item' => 'New Custom Brand',
        'view_item' => 'View Custom Brand',
        'search_items' => 'Search Custom Brands',
        'not_found' => 'No Custom Brands found',
        'not_found_in_trash' => 'No Custom Brands found in Trash',
        'all_items' => 'All Custom Brands',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'custom-brands'),
    );

    register_post_type('custom_brand', $args);
}
add_action('init', 'register_custom_brand_post_type');

// Auto-create a custom_brand post when a new YITH brand term is created
function create_custom_brand_post_on_brand_creation($term_id) {
    $term = get_term($term_id, 'yith_product_brand');
    if ($term && !is_wp_error($term)) {
        // Check if a custom_brand post linked to this term already exists
        $existing = new WP_Query(array(
            'post_type' => 'custom_brand',
            'meta_query' => array(
                array(
                    'key' => '_yith_brand_term_id',
                    'value' => $term_id,
                    'compare' => '=',
                ),
            ),
            'posts_per_page' => 1,
            'fields' => 'ids',
        ));
        if (!$existing->have_posts()) {
            // Create post
            $post_data = array(
                'post_title' => $term->name,
                'post_content' => '',
                'post_status' => 'publish',
                'post_type' => 'custom_brand',
            );
            $post_id = wp_insert_post($post_data);
            if ($post_id && !is_wp_error($post_id)) {
                update_post_meta($post_id, '_yith_brand_term_id', $term_id);
            }
        }
    }
}
add_action('created_yith_product_brand', 'create_custom_brand_post_on_brand_creation');

// Add meta box to custom