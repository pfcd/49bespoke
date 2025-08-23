<?php
/* Template Name: Brands Directory */
get_header();
?>

<div class="brand-directory-wrapper">
    <h1>Our Brands</h1>
    <div class="brand-grid">
        <?php
        $brands = get_terms(array(
            'taxonomy' => 'yith_product_brand',
            'hide_empty' => false,
        ));

        foreach ($brands as $brand) {
            $logo_id = get_term_meta($brand->term_id, 'thumbnail_id', true);
            $logo_url = wp_get_attachment_url($logo_id) ?: get_stylesheet_directory_uri() . '/images/placeholder-logo.png';
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
</div>

<?php get_footer(); ?>