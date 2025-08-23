<?php 
    $dipi_blog_slider_before_post_content = "";
    $dipi_blog_slider_before_post_content = apply_filters('dipi_blog_slider_before_post_content', $dipi_blog_slider_before_post_content);
    $dipi_blog_slider_before_post_content = apply_filters('dipi_blog_slider_before_post_content_with_post', $dipi_blog_slider_before_post_content, $post);
    $dipi_blog_slider_after_post_content = "";
    $dipi_blog_slider_after_post_content = apply_filters('dipi_blog_slider_after_post_content', $dipi_blog_slider_after_post_content);
    $dipi_blog_slider_after_post_content = apply_filters('dipi_blog_slider_after_post_content_with_post', $dipi_blog_slider_after_post_content, $post);
?>
<div class="dipi-post-content">
<?php
    echo $dipi_blog_slider_before_post_content ? "<div>" . wp_kses_post($dipi_blog_slider_before_post_content) . "</div>" : ''; 
if ('on' === $args['show_categories']) {
?>
    <div class="dipi-categories">
        <?php echo et_core_esc_wp($categories); ?>
    </div>
<?php
}
?>
    <?php include dirname(__FILE__) . '/dipi-entry-title.php';?>
    <?php include dirname(__FILE__) . '/dipi-post-text.php';?>
    <?php echo $dipi_blog_slider_after_post_content ? "<div>". wp_kses_post($dipi_blog_slider_after_post_content) . "</div>" : ''; ?>
</div><!-- dipi-post-content -->