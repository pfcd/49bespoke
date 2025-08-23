<?php get_header(); ?>

<?php
$term = get_queried_object();
$logo_id = get_term_meta($term->term_id, 'thumbnail_id', true);
$logo_url = wp_get_attachment_url($logo_id);
?>

<div class="brand-wrapper" style="max-width: 900px; margin: 0 auto; text-align: center; padding: 2rem;">

    <?php if ($logo_url): ?>
        <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($term->name); ?> Logo" style="max-width: 200px; margin-bottom: 20px;">
    <?php endif; ?>

    <h1><?php echo esc_html($term->name); ?></h1>

    <div class="brand-description" style="margin: 20px 0;">
        <?php echo term_description(); ?>
    </div>

    <div style="margin-bottom: 30px;">
        <a href="<?php echo esc_url(home_url('/our-brands')); ?>" style="text-decoration: underline;">← Back to All Brands</a>
    </div>

    <button id="toggle-products" style="padding: 10px 20px; background-color: #0073aa; color: white; border: none; border-radius: 4px; cursor: pointer;">
        View This Brand's Products
    </button>

    <div id="brand-products" style="margin-top: 40px; display: none;">
        <?php
        // Display brand's products
        $args = array(
            'post_type' => 'product',
            'tax_query' => array(
                array(
                    'taxonomy' => 'yith_product_brand',
                    'field'    => 'slug',
                    'terms'    => $term->slug,
                ),
            ),
        );
        $products = new WP_Query($args);
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
</div>

<script>
document.getElementById('toggle-products').addEventListener('click', function () {
    var productSection = document.getElementById('brand-products');
    if (productSection.style.display === 'none') {
        productSection.style.display = 'block';
        this.textContent = 'Hide Products';
    } else {
        productSection.style.display = 'none';
        this.textContent = "View This Brand's Products";
    }
});
</script>

<?php get_footer(); ?>
