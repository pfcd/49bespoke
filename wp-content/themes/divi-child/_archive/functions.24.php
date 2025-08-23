<?php
if (!shortcode_exists('dynamic_product_table')) {
    add_shortcode('dynamic_product_table', 'dynamic_category_product_table');
}

function dynamic_category_product_table() {
    try {
        if (!is_product_category()) {
            return '';
        }

        $current_category = get_queried_object();
        if (!is_object($current_category)) {
            return '<!-- Invalid queried object -->';
        }

        if (empty($current_category->term_id) || empty($current_category->slug)) {
            return '<!-- Missing category data -->';
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

            // Inline CSS for responsiveness
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

        // If no subcategories, show the product table
        return do_shortcode('[product_table id="1" category="' . esc_attr($category_slug) . '"]');

    } catch (Throwable $e) {
        return '<!-- Error in dynamic_category_product_table: ' . esc_html($e->getMessage()) . ' -->';
    }
}

add_action('init', function () {
    $domains = [
        'woocommerce-product-table',
        'the-events-calendar',
        'tribe-events-calendar-pro',
        'woocommerce',
        'formidable',
        'wordpress-seo',
    ];

    foreach ($domains as $domain) {
        if (is_textdomain_loaded($domain)) {
            unload_textdomain($domain);
        }

        load_plugin_textdomain($domain, false, plugin_basename(dirname(__FILE__)) . '/languages');
    }
});

function pfc_enqueue_variation_sku_script() {
    wp_register_script('pfc-sku-updater', false);
    wp_enqueue_script('pfc-sku-updater');

    add_action('wp_print_footer_scripts', function () {
        ?>
        <script>
        console.log('SKU updater script loaded');
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                const forms = document.querySelectorAll('form.wpt_variations_form');
                console.log('Delayed form check: found', forms.length);

                forms.forEach(function (form) {
                    const selects = form.querySelectorAll('select');
                    selects.forEach(function (select) {
                        select.addEventListener('change', function () {
                            setTimeout(function () {
                                const variationInput = form.querySelector('.variation_id');
                                const skuCell = form.closest('tr').querySelector('[data-title="SKU"]');
                                if (!variationInput || !variationInput.value || !skuCell) return;
                                console.log('Selected variation ID:', variationInput.value);

                                fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                    body: 'action=get_variation_sku&variation_id=' + variationInput.value
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.sku) {
                                        skuCell.textContent = data.sku;
                                    }
                                });
                            }, 250);
                        });
                    });
                });
            }, 1000);
        });
        </script>
        <?php
    });
}
add_action('init', 'pfc_enqueue_variation_sku_script');

add_action('wp_ajax_get_variation_sku', 'pfc_get_variation_sku');
add_action('wp_ajax_nopriv_get_variation_sku', 'pfc_get_variation_sku');

function pfc_get_variation_sku() {
    if (!isset($_POST['variation_id'])) {
        wp_send_json_error(['message' => 'Missing variation ID']);
    }

    $variation_id = (int) $_POST['variation_id'];
    $sku = get_post_meta($variation_id, '_sku', true);

    wp_send_json_success(['sku' => $sku]);
}