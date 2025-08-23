<?php
$attachment_id = get_post_thumbnail_id(get_the_ID());
$attachment = wp_get_attachment_image_src($attachment_id, "full");

if (isset($attachment[0])) {
    $image = $attachment[0];
    $image_desktop_url = DIPI_Blog_Slider::get_attachment_image($attachment_id, $args['image_size'], $image);
    $image_tablet_url = DIPI_Blog_Slider::get_attachment_image($attachment_id, $args['image_size_tablet'], $image);
    $image_phone_url = DIPI_Blog_Slider::get_attachment_image($attachment_id, $args['image_size_phone'], $image);

    $image_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
    $image_title = get_the_title($attachment_id);
}
?>
<div class="dipi-entry-featured-image-url <?php echo esc_attr($image_animation_class); ?>">

	<?php if ('off' === $args['card_clickable'] && 'on' === $args['image_clickable']): ?>
	<a class="dipi-blog-post-overlay-link" href="<?php echo esc_url(get_permalink()); ?>"></a>
	<?php endif;?>

    <div class="dipi-blog-post-overlay">
        <?php printf('%1$s', et_core_esc_wp($author));?>
    </div>

    <?php 
    if (isset($attachment[0])) {
        echo sprintf(
            '<img
                decoding="async"
                loading="lazy"
                class="wp-post-image"
                src="%1$s"
                alt="%2$s"
                srcset="%6$s 768w, %5$s 980w, %4$s 1024w"
                sizes="(max-width: 768px) 768px, (max-width: 980px) 980px, 1024px"
            />
            ',
            esc_url($image),
            esc_attr($image_alt),
            esc_attr($image_title),
            esc_url($image_desktop_url),
            esc_url($image_tablet_url),
            esc_url($image_phone_url)
        ); 
    } ?>

</div>