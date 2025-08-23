<?php
/* Template Name: Brands Directory */
get_header();

// Debug: Confirm template is loaded
error_log('Brands Directory page template loaded');

?>
<div class="brand-directory-wrapper">
    <h1>Our Brands</h1>
    <div class="brand-grid">
        <?php
        $all_brands = get_terms(array(
            'taxonomy' => 'yith_product_brand',
            'hide_empty' => false,
        ));

        // Debug: Log all brands and their meta values
        if (is_wp_error($all_brands)) {
            error_log('get_terms Error: ' . $all_brands->get_error_message());
        } elseif (empty($all_brands)) {
            error_log('No brands found for yith_product_brand');
        } else {
            error_log('Found ' . count($all_brands) . ' brands');
            foreach ($all_brands as $brand) {
                $meta_value = get_term_meta($brand->term_id, 'show_in_brand_partners', true);
                error_log("Brand {$brand->name} (ID: {$brand->term_id}) - show_in_brand_partners: '$meta_value'");
            }
        }

        $brands = array_filter($all_brands, function($brand) {
            return get_term_meta($brand->term_id, 'show_in_brand_partners', true) === '1';
        });

        if (!empty($brands) && !is_wp_error($brands)) {
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
        } else {
            echo '<p>No brands found with "Show in Brand Partners" enabled.</p>';
        }
        ?>
    </div>
</div>
<?php get_footer(); ?>