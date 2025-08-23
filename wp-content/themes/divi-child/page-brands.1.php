<?php
/* Template Name: Brands Directory */
get_header();
?>

<div class="brand-directory-wrapper" style="max-width: 1200px; margin: auto; padding: 2rem;">
    <h1 style="text-align: center; margin-bottom: 2rem;">Our Brands</h1>

    <div class="brand-grid" style="
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 30px;
        justify-items: center;
        align-items: center;
    ">

        <?php
        $brands = get_terms(array(
            'taxonomy' => 'yith_product_brand',
            'hide_empty' => false,
        ));

        foreach ($brands as $brand) {
            $logo_id = get_term_meta($brand->term_id, 'thumbnail_id', true);
            $logo_url = wp_get_attachment_url($logo_id);
            $brand_link = get_term_link($brand);

            if ($logo_url): ?>
                <a href="<?php echo esc_url($brand_link); ?>" class="brand-logo" style="display: block; text-align: center;">
                    <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($brand->name); ?>" style="max-height: 100px; max-width: 100%; object-fit: contain;">
                </a>
            <?php endif;
        }
        ?>

    </div>
</div>

<?php get_footer(); ?>
