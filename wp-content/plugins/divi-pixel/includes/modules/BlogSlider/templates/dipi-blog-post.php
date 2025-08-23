<?php
$excerpt_length = '' !== $args['excerpt_length'] ? intval($args['excerpt_length']) : 70;
$expert_as_raw_html = $args['expert_as_raw_html'];
$handle_shortcode_with_rawhtml = $args['handle_shortcode_with_rawhtml'];
$handle_shortcode_without_rawhtml = $args['handle_shortcode_without_rawhtml'];
global $authordata;
global $post;

$author = 'on' === $args['show_author'] ? sprintf(
    '<div class="dipi-author">
        <span class="author vcard">%3$s <img src=" %1$s" /> %2$s</span>
    </div>',
    esc_url(get_avatar_url($authordata->ID)),
    ('on' === $args['card_clickable']) ? get_the_author(): et_pb_get_the_author_posts_link(),
    __('By', 'dipi-divi-pixel')
    )    
 : '';
$date_content = sprintf('
        <span class="dipi-month">%1$s</span>
        <span class="dipi-day">%2$s</span>
        <span class="dipi-year">%3$s</span>
    ',
    get_the_date('M'),
    get_the_date('d'),
    get_the_date('Y')
);
if ('on' === $args['show_date']) {
    $date_content = apply_filters('dipi_blog_slider_date', $date_content);
    $date_content = apply_filters('dipi_blog_slider_date_with_post', $date_content, $post);
}
$date = 'on' === $args['show_date'] ?
sprintf(
    '<div class="dipi-date">
        %1$s
    </div>',
    $date_content
) : '';


$categories = 'on' === $args['show_categories'] ? et_builder_get_the_term_list(', ') : '';
if ('on' === $args['card_clickable']) {
    $categories = strip_tags($categories);
}
if ('on' === $args['show_categories']) {
    $categories = apply_filters('dipi_blog_slider_categories', $categories);
    $categories = apply_filters('dipi_blog_slider_categories_with_post', $categories, $post);
}

$comment_icon = '<svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="comment" class="svg-inline--fa fa-comment fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 32C114.6 32 0 125.1 0 240c0 47.6 19.9 91.2 52.9 126.3C38 405.7 7 439.1 6.5 439.5c-6.6 7-8.4 17.2-4.6 26S14.4 480 24 480c61.5 0 110-25.7 139.1-46.3C192 442.8 223.2 448 256 448c141.4 0 256-93.1 256-208S397.4 32 256 32zm0 368c-26.7 0-53.1-4.1-78.4-12.1l-22.7-7.2-19.5 13.8c-14.3 10.1-33.9 21.4-57.5 29 7.3-12.1 14.4-25.7 19.9-40.2l10.6-28.1-20.6-21.8C69.7 314.1 48 282.2 48 240c0-88.2 93.3-160 208-160s208 71.8 208 160-93.3 160-208 160z"></path></svg>';
if ('on' === $args['show_comments']) {
    $comment_icon = apply_filters('dipi_blog_slider_comment_icon', $comment_icon);
    $comment_icon = apply_filters('dipi_blog_slider_comment_icon_with_post', $comment_icon, $post);
}
$comment_number = number_format_i18n(get_comments_number());
if ('on' === $args['show_comments']) {
    $comment_number = apply_filters('dipi_blog_slider_comment_number', $comment_number);
    $comment_number = apply_filters('dipi_blog_slider_comment_number_with_post', $comment_number, $post);
}
$dipi_comments = 'on' === $args['show_comments'] ?
et_core_maybe_convert_to_utf_8(
    sprintf(
        '<%4$s href="%3$s" class="dipi-comments"> <span class="comment-icon">%1$s</span><span class="comment-number"> %2$s </span></%4$s>',
        $comment_icon,
        $comment_number,
        esc_url(get_the_permalink()),
        $args['card_clickable'] === 'on' ? 'div' : 'a'
    )
) : '';

$header_element = et_core_esc_previously($processed_header_level);

$cats = get_the_category();
$cats_class = '';
foreach($cats as $dipi_cat){
    $cats_class .= ' category-' . $dipi_cat->slug;
}
?>
<?php if ('on' === $args['card_clickable']): ?>
<a class="dipi-blog-post clearfix<?php echo esc_attr($cats_class); ?>" href="<?php echo esc_url(get_permalink()); ?>">
<?php else: ?>
<div class="dipi-blog-post clearfix<?php echo esc_attr($cats_class); ?>">
<?php endif;?>
<?php
if ('on' === $args['show_thumbnail']) {
    include dirname(__FILE__) . '/dipi-entry-featured-image-url.php';
    printf('%1$s', et_core_esc_wp($date));
} else {
    include dirname(__FILE__) . '/dipi-blog-post-meta.php';
}

ET_Builder_Element::clean_internal_modules_styles();

include dirname(__FILE__) . '/dipi-post-content.php';

$button_use_icon = $args['button_use_icon'];
$button_icon     = $args['button_icon'];

$data_icon       = '$';
$data_icon_class = '';

if('on' === $button_use_icon) {
    $data_icon       = $button_icon ? et_pb_process_font_icon($button_icon) : '$';
    $data_icon_class = 'et_pb_custom_button_icon';
}

$dipi_more = 'on' === $args['show_more'] ? sprintf(
    '<%5$s href="%1$s" class="et_pb_button %4$s dipi-more-link" data-icon="%3$s">%2$s</%5$s>',
    esc_url(get_permalink()),
    $args['show_more_text'],
    esc_attr($data_icon),
    $data_icon_class,
    $args['card_clickable'] === 'on' ? 'div' : 'a'
) : '';

// Uses $more and $comments
if(!empty($dipi_more) || !empty($dipi_comments))
    include dirname(__FILE__) . '/dipi-bottom-content.php';
?>
<?php if ('on' === $args['card_clickable']): ?>
</a><!-- dipi-blog-post -->
<?php else: ?>
</div><!-- dipi-blog-post -->
<?php endif; ?>