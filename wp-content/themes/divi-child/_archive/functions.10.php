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

// Auto-create Custom Brand post only if 'show_in_brand_partners' is true for a YITH brand term
add_action('acf/save_post', 'conditionally_create_custom_brand_post', 20);
function conditionally_create_custom_brand_post($post_id) {
    // Only run for YITH brand taxonomy terms
    if (strpos($post_id, 'yith_product_brand_') !== 0) {
        return;
    }

    $term_id = str_replace('yith_product_brand_', '', $post_id);
    $show = get_field('show_in_brand_partners', $post_id);

    // Only proceed if field is checked true
    if (!$show) return;

    // Avoid duplicate posts
    $existing = new WP_Query(array(
        'post_type' => 'custom_brand',
        'meta_query' => array(
            array(
                'key' => '_yith_brand_term_id',
                'value' => $term_id,
                'compare' => '='
            )
        ),
        'posts_per_page' => 1,
        'fields' => 'ids',
    ));
    if ($existing->have_posts()) return;

    // Get term info
    $term = get_term($term_id, 'yith_product_brand');
    if (is_wp_error($term)) return;

    // Create the post
    $post_id = wp_insert_post(array(
        'post_type' => 'custom_brand',
        'post_title' => $term->name,
        'post_status' => 'publish',
    ));

    if (!is_wp_error($post_id)) {
        update_post_meta($post_id, '_yith_brand_term_id', $term_id);
    }
}

add_action('created_yith_product_brand', 'create_custom_brand_post_on_brand_creation');

// Add meta box to custom_brand post edit screen to show linked YITH brand
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
    $term_id = get_post_meta($post->ID, '_yith_brand_term_id', true);
    if ($term_id) {
        $term = get_term($term_id, 'yith_product_brand');
        if (!is_wp_error($term)) {
            $edit_link = get_edit_term_link($term_id, 'yith_product_brand');
            echo '<p><strong>Brand:</strong> ' . esc_html($term->name) . '</p>';
            echo '<p><a href="' . esc_url($edit_link) . '" class="button button-primary" target="_blank">Edit YITH Brand</a></p>';
        } else {
            echo '<p>Linked YITH Brand term not found.</p>';
        }
    } else {
        echo '<p>No YITH brand linked.</p>';
    }
}

function add_edit_brand_content_button($term) {
    if (!$term || !isset($term->term_id)) {
        return;
    }

    $term_id = $term->term_id;

    // Query for the custom_brand post linked to this YITH brand term
    $linked_brand = new WP_Query(array(
        'post_type' => 'custom_brand',
        'meta_query' => array(
            array(
                'key' => '_yith_brand_term_id',
                'value' => $term_id,
                'compare' => '='
            )
        ),
        'posts_per_page' => 1,
        'fields' => 'ids',
    ));

    if ($linked_brand->have_posts()) {
        $custom_brand_post_id = $linked_brand->posts[0];
        $edit_link = get_edit_post_link($custom_brand_post_id);
        if ($edit_link) {
            ?>
            <tr class="form-field">
                <th scope="row"></th>
                <td>
                    <a href="<?php echo esc_url($edit_link); ?>" class="button button-primary" target="_blank" style="margin-top: 10px;">
                        <?php esc_html_e('Edit Brand Content', 'your-text-domain'); ?>
                    </a>
                </td>
            </tr>
            <?php
        }
    } else {
        // Optional: if no linked Custom Brand post found, show notice or nothing
        ?>
        <tr class="form-field">
            <th scope="row"></th>
            <td>
                <em><?php esc_html_e('No linked Brand Content found.', 'your-text-domain'); ?></em>
            </td>
        </tr>
        <?php
    }
}

// Add a meta-box-like container with 'Edit Brand Content' button on YITH Brand term edit screen sidebar
add_action('yith_product_brand_edit_form', 'add_edit_brand_content_metabox_on_yith_brand_edit', 10, 2);

function add_edit_brand_content_metabox_on_yith_brand_edit($term, $taxonomy) {
    if (!$term || $taxonomy !== 'yith_product_brand') {
        return;
    }

    $term_id = $term->term_id;

    // Query for linked custom_brand post
    $linked_brand = new WP_Query(array(
        'post_type' => 'custom_brand',
        'meta_query' => array(
            array(
                'key' => '_yith_brand_term_id',
                'value' => $term_id,
                'compare' => '='
            )
        ),
        'posts_per_page' => 1,
        'fields' => 'ids',
    ));

    ?>
    <div class="postbox" style="margin-top: 20px;">
        <h2 class="hndle"><span><?php esc_html_e('Brand Content', 'your-text-domain'); ?></span></h2>
        <div class="inside" style="padding: 10px;">
            <?php
            if ($linked_brand->have_posts()) {
                $custom_brand_post_id = $linked_brand->posts[0];
                $edit_link = get_edit_post_link($custom_brand_post_id);
                if ($edit_link) {
                    ?>
                    <p>
                        <a href="<?php echo esc_url($edit_link); ?>" class="button button-primary" target="_blank">
                            <?php esc_html_e('Edit Brand Content', 'your-text-domain'); ?>
                        </a>
                    </p>
                    <?php
                }
            } else {
                ?>
                <p><em><?php esc_html_e('No linked Brand Content found.', 'your-text-domain'); ?></em></p>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}

function show_linked_custom_brand_content() {
    $term = get_queried_object();
    if ($term && isset($term->term_id)) {
        $linked_brand = new WP_Query(array(
            'post_type' => 'custom_brand',
            'meta_query' => array(
                array(
                    'key' => '_yith_brand_term_id',
                    'value' => $term->term_id,
                    'compare' => '='
                )
            ),
            'posts_per_page' => 1
        ));

        if ($linked_brand->have_posts()) {
            $linked_brand->the_post();
            $content = apply_filters('the_content', get_the_content());
            wp_reset_postdata();
            return $content;
        } else {
            return '<p>No custom brand content found for this brand.</p>';
        }
    }
    return '';
}
add_shortcode('linked_brand_content', 'show_linked_custom_brand_content');

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

function render_user_manuals_html() {
    $post_id = get_the_ID(); // Automatically get current Brand CPT ID

    if (have_rows('user_manuals', $post_id)) {
        $output = '<div class="user-manuals-list">';
        while (have_rows('user_manuals', $post_id)) {
            the_row();
            $file_name = get_sub_field('user_manual_name');
            $file = get_sub_field('user_manual_file');
            $thumbnail = get_sub_field('user_manual_thumbnail');

            $output .= '<div class="user-manual">';
            if ($thumbnail) {
                $output .= '<img src="' . esc_url($thumbnail['url']) . '" alt="' . esc_attr($file_name) . '" style="max-width:100px;height:auto;">';
            }
            $output .= '<p><strong>' . esc_html($file_name) . '</strong></p>';
            if ($file) {
                $output .= '<a href="' . esc_url($file['url']) . '" download>Download</a>';
            }
            $output .= '</div>';
        }
        $output .= '</div>';
    } else {
        $output = '<p>No user manuals available.</p>';
    }

    return $output;
}

add_shortcode('user_manuals_list', 'render_user_manuals_html');
