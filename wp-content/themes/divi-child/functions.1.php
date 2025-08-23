<?php

// === SHORTCODE: dynamic_product_table ===
add_shortcode('dynamic_product_table', 'dynamic_category_product_table');
function dynamic_category_product_table() {
    try {
        if (!is_product_category()) return do_shortcode('[product_table id="1"]');

        $current_category = get_queried_object();
        if (!is_object($current_category) || empty($current_category->term_id) || empty($current_category->slug)) {
            return '<!-- Invalid or missing category -->';
        }

        $category_id = (int) $current_category->term_id;
        $category_slug = sanitize_title($current_category->slug);

        $subcategories = get_terms([
            'taxonomy' => 'product_cat',
            'parent' => $category_id,
            'hide_empty' => false,
        ]);

        if (!empty($subcategories) && !is_wp_error($subcategories)) {
            ob_start();
            echo '<div class="subcategory-grid">';
            foreach ($subcategories as $subcategory) {
                $link = get_term_link($subcategory);
                $thumbnail_id = get_term_meta($subcategory->term_id, 'thumbnail_id', true);
                $image = wp_get_attachment_image($thumbnail_id, 'medium');
                echo '<div class="subcategory-item">';
                echo '<a href="' . esc_url($link) . '">';
                echo $image ?: '<div class="subcategory-placeholder" style="width:100%;height:200px;background:#eee;"></div>';
                echo '<div class="subcategory-name">' . esc_html($subcategory->name) . '</div>';
                echo '</a>';
                echo '</div>';
            }
            echo '</div>';

            echo '<style>
                .subcategory-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                    gap: 20px;
                    margin: 20px 0;
                }
                .subcategory-item {
                    text-align: center;
                }
                .subcategory-item img {
                    max-width: 100%;
                    height: auto;
                    display: block;
                    margin: 0 auto 10px;
                }
                .subcategory-name {
                    font-weight: bold;
                    font-size: 1.1em;
                }
            </style>';

            return ob_get_clean();
        }

        return do_shortcode('[product_table id="1" category="' . esc_attr($category_slug) . '"]');
    } catch (Throwable $e) {
        return '<!-- Error in dynamic_category_product_table: ' . esc_html($e->getMessage()) . ' -->';
    }
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
        $logo_id = get_term_meta($brand->term_id, 'thumbnail_id', true);
        $logo_url = wp_get_attachment_url($logo_id) ?: get_stylesheet_directory_uri() . '/images/placeholder-logo.png';
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
        <?php
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

function pfc_brand_dropdown_shortcode() {
    // Get all brands in the 'yith_product_brand' taxonomy
    $all_brands = get_terms(array(
        'taxonomy' => 'yith_product_brand',
        'hide_empty' => false,
    ));

    // Filter to only those with 'show_in_brand_partners' meta = 1
    $filtered_brands = array_filter($all_brands, function($brand) {
        return get_term_meta($brand->term_id, 'show_in_brand_partners', true) === '1';
    });

    if (empty($filtered_brands)) {
        return '<p>No brand partners available.</p>';
    }

    // Build the dropdown HTML
    ob_start();
    echo '<select onchange="if (this.value) window.location.href=this.value;" style="max-width: 300px; padding: 5px;">';
    echo '<option value="">Select Another Brand</option>';
    foreach ($filtered_brands as $brand) {
        $link = get_term_link($brand);
        echo '<option value="' . esc_url($link) . '">' . esc_html($brand->name) . '</option>';
    }
    echo '</select>';
    return ob_get_clean();
}
add_shortcode('brand_dropdown', 'pfc_brand_dropdown_shortcode');

// Store the current YITH brand term globally for later use in shortcodes
function pfc_capture_current_brand_term() {
    if (is_tax('yith_product_brand')) {
        global $pfc_current_brand_term;
        $pfc_current_brand_term = get_queried_object();
    }
}
add_action('template_redirect', 'pfc_capture_current_brand_term');

function user_manuals_list_shortcode() {
    if (!is_tax('yith_product_brand')) {
        return '';
    }

    $term = get_queried_object();

    // Get the custom_brand post linked to this term via post meta (_yith_brand_term_id)
    $args = [
        'post_type' => 'custom_brand',
        'posts_per_page' => 1,
        'meta_query' => [
            [
                'key' => '_yith_brand_term_id',
                'value' => $term->term_id,
                'compare' => '='
            ]
        ]
    ];

    $posts = get_posts($args);

    if (empty($posts)) {
        return 'No matching custom_brand post found for this brand.';
    }

    $custom_post_id = $posts[0]->ID;

    if (have_rows('user_manuals', $custom_post_id)) {
        ob_start();
        echo '<ul class="user-manuals-list">';
        while (have_rows('user_manuals', $custom_post_id)) {
            the_row();
            $name = get_sub_field('user_manual_name');
            $file = get_sub_field('user_manual_file');
            $thumb = get_sub_field('user_manual_thumbnail');
            
            echo '<li>';
            if ($thumb) {
                echo wp_get_attachment_image($thumb, 'thumbnail');
            }
            if ($file) {
                echo '<a href="' . esc_url($file['url']) . '" target="_blank">' . esc_html($name ?: $file['filename']) . '</a>';
            } else {
                echo esc_html($name);
            }
            echo '</li>';
        }
        echo '</ul>';
        return ob_get_clean();
    } else {
        return 'No user manuals found for this brand.';
    }
}
add_shortcode('user_manuals_list', 'user_manuals_list_shortcode');

function user_manuals_grid_shortcode() {
    if (!is_tax('yith_product_brand')) {
        return '';
    }

    $term = get_queried_object();

    // Get the custom_brand post linked to this term via post meta (_yith_brand_term_id)
    $args = [
        'post_type' => 'custom_brand',
        'posts_per_page' => 1,
        'meta_query' => [
            [
                'key' => '_yith_brand_term_id',
                'value' => $term->term_id,
                'compare' => '='
            ]
        ]
    ];

    $posts = get_posts($args);

    if (empty($posts)) {
        return 'No matching custom_brand post found for this brand.';
    }

    $custom_post_id = $posts[0]->ID;

    if (have_rows('user_manuals', $custom_post_id)) {
        ob_start();
        echo '<div class="user-manuals-grid">';
        while (have_rows('user_manuals', $custom_post_id)) {
            the_row();
            $name = get_sub_field('user_manual_name');
            $file = get_sub_field('user_manual_file');
            $thumb = get_sub_field('user_manual_thumbnail');

            echo '<div class="user-manual-card">';
            if ($file) {
                echo '<a href="' . esc_url($file['url']) . '" target="_blank">';
            }
            if ($thumb) {
                $thumb_id = is_array($thumb) && isset($thumb['ID']) ? $thumb['ID'] : $thumb;
                echo wp_get_attachment_image($thumb_id, 'thumbnail', false, ['class' => 'user-manual-thumbnail']);
            }
            echo '<span class="user-manual-filename">' . esc_html($name ?: $file['filename']) . '</span>';
            if ($file) {
                echo '</a>';
            }
            echo '</div>';
        }
        echo '</div>';
        return ob_get_clean();
    } else {
        return 'No user manuals found for this brand.';
    }
}
add_shortcode('user_manuals_grid', 'user_manuals_grid_shortcode');

add_action('add_meta_boxes', 'pfc_add_edit_brand_term_meta_box');
function pfc_add_edit_brand_term_meta_box() {
    add_meta_box(
        'edit_brand_term_link',
        'Linked Brand Term',
        'pfc_render_edit_brand_term_link_box',
        'custom_brand',
        'side',
        'default'
    );
}

function pfc_render_edit_brand_term_link_box($post) {
    $term_id = get_post_meta($post->ID, '_yith_brand_term_id', true);

    if ($term_id) {
        $term = get_term($term_id, 'yith_product_brand');
        if ($term && !is_wp_error($term)) {
            $edit_link = get_edit_term_link($term_id, 'yith_product_brand');
            echo '<a href="' . esc_url($edit_link) . '" class="button button-primary" target="_blank">Edit Brand Settings</a>';
            echo '<p class="description">This links to the YITH Product Brand term assigned to this brand content page.</p>';
        } else {
            echo '<p>No valid brand term found.</p>';
        }
    } else {
        echo '<p>This brand post is not linked to a YITH Product Brand term.</p>';
    }
}

add_action('yith_product_brand_edit_form_fields', 'pfc_add_edit_custom_brand_button_debug', 10, 2);
function pfc_add_edit_custom_brand_button_debug($term, $taxonomy) {
    // Output the current term ID for debugging
    echo '<tr class="form-field"><th>Debug</th><td><code>Term ID: ' . esc_html($term->term_id) . '</code></td></tr>';

    // Fetch related custom_brand post
    $related_post = get_posts([
        'post_type' => 'custom_brand',
        'posts_per_page' => 1,
        'meta_query' => [
            [
                'key' => '_yith_brand_term_id',
                'value' => $term->term_id,
                'compare' => '=',
            ]
        ]
    ]);

    // Output debugging info
    echo '<tr class="form-field"><th>Linked Post Found</th><td><code>' . (empty($related_post) ? 'No' : 'Yes: ID ' . $related_post[0]->ID) . '</code></td></tr>';

    // If a linked post exists, show the button
    if (!empty($related_post)) {
        $edit_url = get_edit_post_link($related_post[0]->ID);
        echo '<tr class="form-field">';
        echo '<th scope="row">Edit Brand Page</th>';
        echo '<td>';
        echo '<a href="' . esc_url($edit_url) . '" class="button button-secondary" target="_blank">Edit Brand Content Page</a>';
        echo '<p class="description">Click to edit the Custom Brand post linked to this brand.</p>';
        echo '</td>';
        echo '</tr>';
    }
}

function pfc_brand_content_shortcode() {
    if (!is_tax('yith_product_brand')) {
        return '';
    }

    $term = get_queried_object();

    $args = [
        'post_type' => 'custom_brand',
        'posts_per_page' => 1,
        'meta_query' => [
            [
                'key' => '_yith_brand_term_id',
                'value' => $term->term_id,
                'compare' => '='
            ]
        ]
    ];

    $posts = get_posts($args);

    if (empty($posts)) {
        return 'No matching custom_brand post found for this brand.';
    }

    $custom_post_id = $posts[0]->ID;
    $post_content = get_post_field('post_content', $custom_post_id);

    $post_content = apply_filters('the_content', $post_content);

    return $post_content ? '<div class="brand-content">' . $post_content . '</div>' : 'No content available for this brand.';
}
add_shortcode('brand_content', 'pfc_brand_content_shortcode');

// === SKU updater for Barn2 Product Table (live variation updates) ===
add_action('wp_footer', function () {
    if (!is_product_category()) return;
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.variations_form').forEach(function (form) {
            form.addEventListener('found_variation', function (event) {
                const variation = event.detail.variation;
                if (!variation || !variation.sku) return;

                const skuCell = form.closest('tr').querySelector('.column-sku');
                if (skuCell) {
                    skuCell.textContent = variation.sku;
                }
            });
        });
    });
    </script>
    <?php
});