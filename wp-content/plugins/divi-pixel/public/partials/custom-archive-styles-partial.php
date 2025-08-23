<?php
namespace DiviPixel;

//Background
$blog_archives_page_background_image = DIPI_Customizer::get_option('blog_archives_page_background_image');
$blog_archives_page_background_color = DIPI_Customizer::get_option('blog_archives_page_background_color');
$blog_archives_page_background_image_size = DIPI_Customizer::get_option('blog_archives_page_background_image_size');
$blog_archives_page_background_image_repeat = DIPI_Customizer::get_option('blog_archives_page_background_image_repeat');

$blog_archives_title_font = DIPI_Customizer::get_option('blog_archives_title_font');
$blog_archives_title_font_select = DIPI_Customizer::get_option('blog_archives_title_font_select');
$blog_archives_title_font_weight = DIPI_Customizer::get_option('blog_archives_title_font_weight');
$blog_archives_title_font_size = DIPI_Customizer::get_option('blog_archives_title_font_size');
$blog_archives_title_text_spacing = DIPI_Customizer::get_option('blog_archives_title_text_spacing');
$blog_archives_title_line_height = DIPI_Customizer::get_option('blog_archives_title_line_height');
$blog_archives_title_font_color = DIPI_Customizer::get_option('blog_archives_title_font_color');
$blog_archives_title_font_color_hover = DIPI_Customizer::get_option('blog_archives_title_font_color_hover');

$blog_archives_meta_font_select = DIPI_Customizer::get_option('blog_archives_meta_font_select');
$blog_archives_meta_font_weight = DIPI_Customizer::get_option('blog_archives_meta_font_weight');
$blog_archives_meta_font_size = DIPI_Customizer::get_option('blog_archives_meta_font_size');
$blog_archives_meta_text_spacing = DIPI_Customizer::get_option('blog_archives_meta_text_spacing');
$blog_archives_meta_font_color = DIPI_Customizer::get_option('blog_archives_meta_font_color');
$blog_archives_meta_font_color_hover = DIPI_Customizer::get_option('blog_archives_meta_font_color_hover');
$blog_archives_meta_icon_color = DIPI_Customizer::get_option('blog_archives_meta_icon_color');
$blog_archives_meta_icon_color_hover = DIPI_Customizer::get_option('blog_archives_meta_icon_hover_color');
$blog_archives_meta_icon_size = DIPI_Customizer::get_option('blog_archives_meta_icon_size');

$blog_archives_excerpt_font_select = DIPI_Customizer::get_option('blog_archives_excerpt_font_select');
$blog_archives_excerpt_font_weight = DIPI_Customizer::get_option('blog_archives_excerpt_font_weight');
$blog_archives_excerpt_font_size = DIPI_Customizer::get_option('blog_archives_excerpt_font_size');
$blog_archives_excerpt_text_spacing = DIPI_Customizer::get_option('blog_archives_excerpt_text_spacing');
$blog_archives_excerpt_line_height = DIPI_Customizer::get_option('blog_archives_excerpt_line_height');
$blog_archives_excerpt_font_color = DIPI_Customizer::get_option('blog_archives_excerpt_font_color');
$blog_archives_content_alignment = DIPI_Customizer::get_option('blog_archives_content_alignment');
$blog_archives_hover_animation = DIPI_Customizer::get_option('blog_archives_hover_animation');
$archive_box_overlay = DIPI_Customizer::get_option('archive_box_overlay');
$blog_archives_box_overlay_color = DIPI_Customizer::get_option('blog_archives_box_overlay_color');
$blog_archives_box_overlay_color_hover = DIPI_Customizer::get_option('blog_archives_box_overlay_color_hover');
$archive_box_icon = DIPI_Customizer::get_option('archive_box_icon');
$archive_box_select_icon = DIPI_Customizer::get_option('archive_box_select_icon');
$archives_box_icon_size = DIPI_Customizer::get_option('archives_box_icon_size');
$archive_box_icon_color = DIPI_Customizer::get_option('archive_box_icon_color');
$blog_archives_box_color = DIPI_Customizer::get_option('blog_archives_box_color');
$blog_archives_box_color_hover = DIPI_Customizer::get_option('blog_archives_box_color_hover');
$blog_archives_box_padding = DIPI_Customizer::get_option('blog_archives_box_padding');
$blog_archives_image_height = DIPI_Customizer::get_option('blog_archives_image_height');
$blog_archives_image_radii = DIPI_Customizer::get_option('blog_archives_image_radii');
$blog_archives_box_content_padding = DIPI_Customizer::get_option('blog_archives_box_content_padding');
$blog_archives_box_radius = DIPI_Customizer::get_option('blog_archives_box_radius');
$blog_archives_box_border = DIPI_Customizer::get_option('blog_archives_box_border');
$archive_box_border_color = DIPI_Customizer::get_option('archive_box_border_color');
$archive_box_border_color_hover = DIPI_Customizer::get_option('archive_box_border_color_hover');
$archive_box_shadow = DIPI_Customizer::get_option('archive_box_shadow');
$archive_box_shadow_color = DIPI_Customizer::get_option('archive_box_shadow_color');
$archive_box_shadow_offset = DIPI_Customizer::get_option('archive_box_shadow_offset');
$archive_box_shadow_blur = DIPI_Customizer::get_option('archive_box_shadow_blur');
$archive_box_shadow_color_hover = DIPI_Customizer::get_option('archive_box_shadow_color_hover');
$archive_box_shadow_offset_hover = DIPI_Customizer::get_option('archive_box_shadow_offset_hover');
$archive_box_shadow_blur_hover = DIPI_Customizer::get_option('archive_box_shadow_blur_hover');

$dipi_image_overlay_icon_class = '';
if ('always' == $archive_box_icon):
    $dipi_image_overlay_icon_class = 'dipi-image-overlay-icon-always';
elseif ('onhover' == $archive_box_icon):
    $dipi_image_overlay_icon_class = 'dipi-image-overlay-icon-onhover';
elseif ('hideonhover' == $archive_box_icon):
    $dipi_image_overlay_icon_class = 'dipi-image-overlay-icon-hideonhover';
endif;

?>

<style type="text/css" id="custom-archive-styles-css">
body.archive div#et-main-area div#main-content,
body.blog div#et-main-area div#main-content{
	background-color: <?php echo esc_html($blog_archives_page_background_color) ?> !important;
    <?php if ($blog_archives_page_background_image && filter_var($blog_archives_page_background_image, FILTER_VALIDATE_URL)): ?>
		background-image: url(<?php echo esc_html($blog_archives_page_background_image) ?>) !important;
	<?php endif;?>
	<?php if('cover' === $blog_archives_page_background_image_size) : ?>
	background-size: cover;
	<?php elseif('fit' === $blog_archives_page_background_image_size) : ?>
	background-size: contain;
	<?php elseif('actual' === $blog_archives_page_background_image_size) : ?>
	background-size: auto auto ;
	<?php endif; ?>
	<?php if('no-repeat' === $blog_archives_page_background_image_repeat) : ?>
	background-repeat: no-repeat ;
	<?php elseif('repeat' === $blog_archives_page_background_image_repeat) : ?>
	background-repeat: repeat ;
	<?php elseif('repeat-x' === $blog_archives_page_background_image_repeat) : ?>
	background-repeat: repeat-x;
	<?php elseif('repeat-y' === $blog_archives_page_background_image_repeat) : ?>
	background-repeat: repeat-y;
	<?php endif; ?>
}

body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post,
body.dipi-custom-archive-page.search article.et_pb_post,
body.archive article.et_pb_post,
body.blog article.et_pb_post {
    transition: all .6s ease-in-out;
	border-style: solid;
	overflow: hidden;
	text-align: <?php echo esc_html($blog_archives_content_alignment); ?>;
	background-color: <?php echo esc_html($blog_archives_box_color); ?> !important;
	padding: <?php echo esc_html($blog_archives_box_padding); ?>px;
	border-radius: <?php echo esc_html($blog_archives_box_radius); ?>px;
	border-width: <?php echo esc_html($blog_archives_box_border); ?>px;
	border-color: <?php echo esc_html($archive_box_border_color); ?>;
	<?php if ($archive_box_shadow): ?>
    box-shadow: 0 <?php echo esc_html($archive_box_shadow_offset); ?>px <?php echo esc_html($archive_box_shadow_blur); ?>px <?php echo esc_html($archive_box_shadow_color); ?>;
	<?php endif;?>
}

<?php
	if($blog_archives_content_alignment == 'left')
		$meta_align = 'flex-start';
	else if($blog_archives_content_alignment == 'right')
		$meta_align = 'flex-end';
	else
		$meta_align = 'center';
?>
#left-area .post-meta{
	justify-content: <?php echo esc_html($meta_align) ?>;
}

body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .entry-featured-image-url,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .entry-featured-image-url,
body.dipi-custom-archive-page.search article.et_pb_post .entry-featured-image-url,
body.archive article.et_pb_post .entry-featured-image-url,
body.single article.et_pb_post .entry-featured-image-url,
body.blog article.et_pb_post .entry-featured-image-url {
	overflow: hidden;
}

body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .entry-featured-image-url img,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .entry-featured-image-wrap img,
body.dipi-custom-archive-page.search #left-area article.et_pb_post .entry-featured-image-wrap img,
body.archive #left-area article.et_pb_post .entry-featured-image-wrap img,
body.blog #left-area article.et_pb_post .entry-featured-image-wrap img {
	height: <?php echo esc_html($blog_archives_image_height); ?>px !important;
}

body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .entry-featured-image-url,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .entry-featured-image-wrap,
body.dipi-custom-archive-page.search #left-area article.et_pb_post .entry-featured-image-wrap,
body.archive #left-area article.et_pb_post .entry-featured-image-wrap,
body.blog #left-area article.et_pb_post .entry-featured-image-wrap {
	border-top-left-radius:<?php echo  esc_html($blog_archives_image_radii[0]); ?>px;
	border-top-right-radius:<?php echo  esc_html($blog_archives_image_radii[1]); ?>px;
	border-bottom-left-radius:<?php echo esc_html($blog_archives_image_radii[2]); ?>px;
	border-bottom-right-radius:<?php echo  esc_html($blog_archives_image_radii[3]); ?>px;
}

body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post:hover,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post:hover,
body.dipi-custom-archive-page.search article.et_pb_post:hover,
body.archive article.et_pb_post:hover,
body.blog article.et_pb_post:hover {
	cursor: pointer;
    transition: all .6s ease-in-out;
	background-color: <?php echo esc_html($blog_archives_box_color_hover); ?> !important;
	border-color: <?php echo esc_html($archive_box_border_color_hover); ?>;
	<?php if ($archive_box_shadow): ?>
    box-shadow: 0 <?php echo esc_html($archive_box_shadow_offset_hover); ?>px <?php echo esc_html($archive_box_shadow_blur_hover); ?>px <?php echo esc_html($archive_box_shadow_color_hover); ?>;
	<?php endif;?>
}
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-content,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-content,
body.dipi-custom-archive-page.search article.et_pb_post .dipi-post-content,
body.archive article.et_pb_post .dipi-post-content,
body.blog article.et_pb_post .dipi-post-content {
    transition: all .6s ease-in-out;
	<?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($blog_archives_excerpt_font_select)), 'html'); ?>
    <?php echo esc_html(DIPI_Customizer::print_font_style_option("blog_archives_excerpt_font_style")); ?>
	font-weight: <?php echo esc_html($blog_archives_excerpt_font_weight); ?>;
	font-size: <?php echo esc_html($blog_archives_excerpt_font_size); ?>px !important;
	letter-spacing: <?php echo esc_html($blog_archives_excerpt_text_spacing); ?>px !important;
	line-height: <?php echo esc_html($blog_archives_excerpt_line_height); ?>px !important;
	color: <?php echo esc_html($blog_archives_excerpt_font_color); ?>;
}

body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-content *,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-content *,
body.dipi-custom-archive-page.search article.et_pb_post .dipi-post-content *,
body.archive article.et_pb_post .dipi-post-content *,
body.blog article.et_pb_post .dipi-post-content * {
	color: <?php echo esc_html($blog_archives_excerpt_font_color); ?>;
}

@media screen and (min-width: 981px) {
	body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .dipi-post-wrap,
	body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .dipi-post-wrap,
	body.dipi-custom-archive-page.search article.et_pb_post .dipi-post-wrap,
    body.archive article.et_pb_post .dipi-post-wrap,
    body.blog article.et_pb_post .dipi-post-wrap {
        padding-top: <?php echo esc_html($blog_archives_box_content_padding[0]); ?>px !important;
        padding-right: <?php echo esc_html($blog_archives_box_content_padding[1]); ?>px !important;
        padding-bottom: <?php echo esc_html($blog_archives_box_content_padding[2]); ?>px !important;
        padding-left: <?php echo esc_html($blog_archives_box_content_padding[3]); ?>px !important;
	}
	
}
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .entry-title,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .entry-title,
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post h2,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post h2,
body.dipi-custom-archive-page.search article.et_pb_post .entry-title,
body.archive article.et_pb_post .entry-title,
body.blog article.et_pb_post .entry-title,
body.dipi-custom-archive-page.search article.et_pb_post h2,
body.archive article.et_pb_post h2,
body.blog article.et_pb_post h2 {
    transition: all .6s ease-in-out;
	<?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($blog_archives_title_font_select)), 'html'); ?>
    <?php echo esc_html(DIPI_Customizer::print_font_style_option("blog_archives_title_font_style")); ?>
	font-weight: <?php echo esc_html($blog_archives_title_font_weight); ?>;
	font-size: <?php echo esc_html($blog_archives_title_font_size); ?>px !important;
	letter-spacing: <?php echo esc_html($blog_archives_title_text_spacing); ?>px !important;
	line-height: <?php echo esc_html($blog_archives_title_line_height); ?>px !important;
	color: <?php echo esc_html($blog_archives_title_font_color); ?>;
}

body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta,
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta a,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta a,
body.dipi-custom-archive-page.search article.et_pb_post .post-meta,
body.archive article.et_pb_post .post-meta,
body.blog article.et_pb_post .post-meta,
body.dipi-custom-archive-page.search article.et_pb_post .post-meta a,
body.archive article.et_pb_post .post-meta a,
body.blog article.et_pb_post .post-meta a{
	<?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($blog_archives_meta_font_select)), 'html'); ?>
	font-weight: <?php echo esc_html($blog_archives_meta_font_weight); ?> !important;
	font-size: <?php echo esc_html($blog_archives_meta_font_size); ?>px !important;
	letter-spacing: <?php echo esc_html($blog_archives_meta_text_spacing); ?>px !important;
	color: <?php echo esc_html($blog_archives_meta_font_color); ?> !important;
}
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta a:hover,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta a:hover,
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta span:hover,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta span:hover,
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta span:hover a,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta span:hover a,
body.dipi-custom-archive-page.search article.et_pb_post .post-meta span:hover,
body.archive article.et_pb_post .post-meta span:hover,
body.blog article.et_pb_post .post-meta span:hover,
body.dipi-custom-archive-page.search article.et_pb_post .post-meta span:hover a,
body.archive article.et_pb_post .post-meta span:hover a,
body.blog article.et_pb_post .post-meta span:hover a{
	color: <?php echo esc_html($blog_archives_meta_font_color_hover); ?> !important;
}

body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta span:before,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta span:before,
body.dipi-custom-archive-page.search article.et_pb_post .post-meta span:before,
body.archive article.et_pb_post .post-meta span:before,
body.blog article.et_pb_post .post-meta span:before {
	font-size: <?php echo esc_html($blog_archives_meta_icon_size); ?>px !important;
	color: <?php echo esc_html($blog_archives_meta_icon_color); ?> !important;
}

body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta span:hover:before,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta span:hover:before,
body.dipi-custom-archive-page.search article.et_pb_post .post-meta span:hover:before,
body.archive article.et_pb_post .post-meta span:hover:before,
body.blog article.et_pb_post .post-meta span:hover:before {
	color: <?php echo esc_html($blog_archives_meta_icon_color_hover); ?> !important;
}

body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .entry-title a,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .entry-title a,
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post h2 a,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post h2 a,
body.dipi-custom-archive-page.search article.et_pb_post .entry-title a,
body.archive article.et_pb_post .entry-title a,
body.archive article.et_pb_post h2 a,
body.dipi-custom-archive-page.search article.et_pb_post .entry-title a,
body.blog article.et_pb_post .entry-title a,
body.blog article.et_pb_post h2 a {
  transition: all .6s ease-in-out;
	color: <?php echo esc_html($blog_archives_title_font_color); ?> !important;
}

body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post:hover .entry-title,
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post:hover .entry-title a,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post:hover .entry-title,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post:hover .entry-title a,
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post:hover h2,
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post:hover h2 a,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post:hover h2,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post:hover h2 a,
body.dipi-custom-archive-page.search article.et_pb_post:hover .entry-title,
body.dipi-custom-archive-page.search article.et_pb_post:hover .entry-title a,
body.dipi-custom-archive-page.search article.et_pb_post:hover h2,
body.dipi-custom-archive-page.search article.et_pb_post:hover h2 a,
body.archive article.et_pb_post:hover .entry-title,
body.archive article.et_pb_post:hover .entry-title a,
body.archive article.et_pb_post:hover h2,
body.archive article.et_pb_post:hover h2 a,
body.blog article.et_pb_post:hover .entry-title,
body.blog article.et_pb_post:hover .entry-title a,
body.blog article.et_pb_post:hover h2,
body.blog article.et_pb_post:hover h2 a{
	color: <?php echo esc_html($blog_archives_title_font_color_hover); ?> !important;
	transition: all .6s ease-in-out;
}

.dipi-image-overlay-active .dipi-image-overlay {
  transition: all .6s ease-in-out;
	background-color: <?php echo esc_html($blog_archives_box_overlay_color); ?>;
}

.dipi-image-overlay-active:hover .dipi-image-overlay {
  transition: all .6s ease-in-out;
	background-color: <?php echo esc_html($blog_archives_box_overlay_color_hover); ?>;
}

.dipi-image-overlay-active .dipi-overlay-icon,
.dipi-image-icon-active .dipi-image-icon {
	font-size: <?php echo esc_html($archives_box_icon_size); ?>px;
}

.dipi-image-overlay-active .dipi-overlay-icon:before,
.dipi-image-icon-active .dipi-image-icon:before {
	content: '<?php echo esc_html($archive_box_select_icon); ?>';
	color: <?php echo esc_html($archive_box_icon_color); ?>;
}

</style>

<script type="text/javascript" id="custom-archive-styles-js">
jQuery(document).ready(function($) {

	const et_pb_post_selector = `body.archive article.et_pb_post,
		body.blog article.et_pb_post,
		body.dipi-custom-archive-page.search article.et_pb_post,
		body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post,
		body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post`
		const et_pb_post_image_selector = `body.archive .et_pb_post .entry-featured-image-url,
			body.blog .et_pb_post .entry-featured-image-url,
			body.dipi-custom-archive-page.search .et_pb_post .entry-featured-image-url,
			body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .entry-featured-image-url,
			body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .entry-featured-image-url`

	const ajax_container_selector = '.dipi-styled-blog'
	
	let observer = new MutationObserver(function(mutationRecords)   {
		if(document.querySelector(ajax_container_selector) === null) return;
		loadStyle().then(function(){
			observer.observe(document.querySelector(ajax_container_selector), {
				childList: true,
				subtree: true
			});
		});
	});
	loadStyle().then(function(){
		if(document.querySelector(ajax_container_selector) === null) return;
		observer.observe(document.querySelector(ajax_container_selector), {
			childList: true,
			 subtree: true
		});
	});
	async function loadStyle(){
		observer.disconnect()
		$('body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .et_pb_image_container .entry-featured-image-url').unwrap()
		$('body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post').unwrap().unwrap()
		$(et_pb_post_selector).contents().filter(function() {
			return this.nodeType == 3 && $.trim(this.nodeValue).length;
		}).wrap('<p class="dipi-post-content">');

		$(et_pb_post_selector).each(function() {
			if ($('.dipi-post-wrap', this).length < 1) {
				$('>:not(.entry-featured-image-url)', this).wrapAll('<div class="dipi-post-wrap"></div>');
			}
		});

		$(et_pb_post_image_selector).each(function() {
				$(this).wrapAll('<div class="entry-featured-image-wrap"></div>');
		});

		<?php if ('zoomin' === $blog_archives_hover_animation): ?>
		$(et_pb_post_selector).addClass('dipi-post-zoomin');
		<?php elseif ('zoomout' === $blog_archives_hover_animation): ?>
		$(et_pb_post_selector).addClass('dipi-post-zoomout');
		<?php elseif ('zoomrotate' === $blog_archives_hover_animation): ?>
		$(et_pb_post_selector).addClass('dipi-post-zoomrotate');
		<?php elseif ('blacktocolor' === $blog_archives_hover_animation): ?>
		$(et_pb_post_selector).addClass('dipi-post-blacktocolor');
		<?php elseif ('zoombox' === $blog_archives_hover_animation): ?>
		$(et_pb_post_selector).addClass('dipi-post-zoombox');
		<?php elseif ('slideupbox' === $blog_archives_hover_animation): ?>
		$(et_pb_post_selector).addClass('dipi-post-slideupbox');
		<?php endif;?>

		<?php if ($archive_box_overlay): ?>
		$(et_pb_post_selector).addClass('dipi-image-overlay-active');
		$(et_pb_post_image_selector).append('<div class="dipi-image-overlay"><span class="et-pb-icon dipi-overlay-icon <?php echo esc_attr($dipi_image_overlay_icon_class); ?>"></span></div>');
		<?php else: ?>
		$(et_pb_post_selector).addClass('dipi-image-icon-active');
		$(et_pb_post_image_selector).append('<div class="dipi-icon-wrap"><span class="et-pb-icon dipi-image-icon <?php echo esc_attr($dipi_image_overlay_icon_class); ?>"></span></div>');
		<?php endif;?>
	}	
});
</script>