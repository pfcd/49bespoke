<?php 
    $dipi_blog_slider_before_bottom_content = "";
    $dipi_blog_slider_before_bottom_content = apply_filters('dipi_blog_slider_before_bottom_content', $dipi_blog_slider_before_bottom_content);
    $dipi_blog_slider_before_bottom_content = apply_filters('dipi_blog_slider_before_bottom_content_with_post', $dipi_blog_slider_before_bottom_content, $post);
    $dipi_blog_slider_after_bottom_content = "";
    $dipi_blog_slider_after_bottom_content = apply_filters('dipi_blog_slider_after_bottom_content', $dipi_blog_slider_after_bottom_content);
    $dipi_blog_slider_after_bottom_content = apply_filters('dipi_blog_slider_after_bottom_content_with_post', $dipi_blog_slider_after_bottom_content, $post);
?>
<div class="dipi-bottom-content">
    <?php echo $dipi_blog_slider_before_bottom_content ? "<div>" . wp_kses_post($dipi_blog_slider_before_bottom_content) . "</div>" : ''; ?>
    <?php echo et_core_esc_previously($dipi_more); ?>
    <?php echo et_core_esc_previously($dipi_comments); ?>
    <?php echo $dipi_blog_slider_after_bottom_content ? "<div>" .  wp_kses_post($dipi_blog_slider_after_bottom_content) . "</div>" : ''; ?>
</div>