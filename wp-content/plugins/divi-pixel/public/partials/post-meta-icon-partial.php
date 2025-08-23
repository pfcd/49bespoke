<?php
namespace DiviPixel;
//FIXME: This file covers partially the same stuff as custom-archive-styles-partial.php. Unify the files so we don't have duplicated CSS on the page.
$blog_archives_meta_font_select  = DIPI_Customizer::get_option('blog_archives_meta_font_select');
$blog_archives_meta_font_weight  = DIPI_Customizer::get_option('blog_archives_meta_font_weight');
$blog_archives_meta_font_size    = DIPI_Customizer::get_option('blog_archives_meta_font_size');
$blog_archives_meta_text_spacing = DIPI_Customizer::get_option('blog_archives_meta_text_spacing');
$blog_archives_meta_font_color   = DIPI_Customizer::get_option('blog_archives_meta_font_color');
$blog_archives_meta_font_color_hover = DIPI_Customizer::get_option('blog_archives_meta_font_color_hover');
$blog_archives_meta_icon_size    = DIPI_Customizer::get_option('blog_archives_meta_icon_size');
$blog_archives_meta_icon_color   = DIPI_Customizer::get_option('blog_archives_meta_icon_color');
$blog_archives_meta_icon_hover_color = DIPI_Customizer::get_option('blog_archives_meta_icon_hover_color');
?>
<script type="text/javascript" id="post-meta-icon-js">

	jQuery(document).ready(function($) {
		const $meta_selector = `body.archive article.et_pb_post .post-meta, body.blog article.et_pb_post .post-meta,
			body.single article.et_pb_post .post-meta,
			body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta,
			body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta`
		const $category_wrap_selector = `
			body.archive article.et_pb_post .post-meta .dipi-categories-wrap, body.blog article.et_pb_post .post-meta .dipi-categories-wrap,
			body.single article.et_pb_post .post-meta .dipi-categories-wrap,
			body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .dipi-categories-wrap,
			body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .dipi-categories-wrap
			`

		function applyMetaStyle(){
			$($meta_selector).html(function() {
				return $(this).html().replace(/\|/g, '').replace('by', '').replace('...', '').replace(/,/g, '');
			});

			$($meta_selector).each(function() {
				$("a", this).not(".author a, .comments-number a, .published a").wrapAll( "<span class='dipi-categories-wrap'></span>");
			});

			$($category_wrap_selector).each(function() {
				$("a", this).wrapAll( "<span class='dipi-categories'></span>");
			});

			$($meta_selector).addClass('dipi-post-meta-icon');
			document.querySelectorAll('.dipi-post-meta-icon').forEach(function(meta){
				var metaNodes = meta.childNodes;
				if(typeof metaNodes.length !== 'undefined' && metaNodes.length > 0){
					if(metaNodes[metaNodes.length -1].nodeType  === 3 && metaNodes[metaNodes.length -1].textContent.indexOf('Comment') > -1) {
						let node = metaNodes[metaNodes.length -1]
						const span = document.createElement('span');
						span.className = "comments-number";
						node.after(span);
						span.appendChild(node);
					}
				}
			})
		}
		applyMetaStyle();
		// fix icons after ajax calls
		let observer = new MutationObserver(applyMetaStyle);
		document.querySelectorAll('.et_pb_posts').forEach(function(node){
			observer.observe(node, {
				childList: true
			});
		})
	});
</script>

<style type="text/css" id="post-meta-icon-css">
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta,
body.archive article.et_pb_post .post-meta,
body.blog article.et_pb_post .post-meta {
	display: flex;
	flex-direction: row;
    flex-wrap: wrap;
    padding-bottom: 0;
}

body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta > span,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta > span,
body.archive article.et_pb_post .post-meta > span,
body.blog article.et_pb_post .post-meta > span {
	display: flex;
    hyphens: auto;
	align-items: center;
	flex-direction: row;
	margin-right: 10px;
	line-height: 1.4em;
}

@media screen and (max-width: 767px) {
	body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta > span,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta > span,
	body.archive article.et_pb_post .post-meta > span,
	body.blog article.et_pb_post .post-meta > span {
		line-height: 1.4em !important;
	}
	body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .author:before,
	body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .author:before,
	body.archive article.et_pb_post .post-meta .author:before, 
	body.blog article.et_pb_post .post-meta .author:before, 
	body.single article.et_pb_post .post-meta .author:before, 
	body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .comments-number:before,
	body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .comments-number:before,
	body.archive article.et_pb_post .post-meta .comments-number:before, 
	body.blog article.et_pb_post .post-meta .comments-number:before, 
	body.single article.et_pb_post .post-meta .comments-number:before, 
	body.archive article.et_pb_post .post-meta .published:before, 
	body.blog article.et_pb_post .post-meta .published:before, 
	body.single article.et_pb_post .post-meta .published:before, 
	body.archive article.et_pb_post .post-meta .dipi-categories:before, 
	body.blog article.et_pb_post .post-meta .dipi-categories:before, 
	body.single article.et_pb_post .post-meta .dipi-categories:before{
		display: inline !important;
	}

}

@media screen and (max-width: 481px) {
	body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta,
	body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta,
	body.archive article.et_pb_post .post-meta,
	body.blog article.et_pb_post .post-meta {
		display: block;
		margin: 20px 0;
		padding: 0px !important;
	}
	
	body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta > span,
	body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta > span,
	body.archive article.et_pb_post .post-meta > span,
	body.blog article.et_pb_post .post-meta > span {
		margin: 10px 0 0 0 !important;
	}
	body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .dipi-post-wrap,
	body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .dipi-post-wrap,
	body.archive article.et_pb_post .dipi-post-wrap,
	body.blog article.et_pb_post .dipi-post-wrap {
		padding: 20px !important;
	}
}

body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta a,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta a,
body.archive article.et_pb_post .post-meta a,
body.archive article.et_pb_post .post-meta,
body.blog article.et_pb_post .post-meta a,
body.blog article.et_pb_post .post-meta {
	<?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($blog_archives_meta_font_select)), 'html'); ?>
	<?php echo esc_html(DIPI_Customizer::print_font_style_option("blog_archives_meta_font_style")); ?>
	font-weight: <?php echo esc_html($blog_archives_meta_font_weight); ?>;
	font-size: <?php echo esc_html($blog_archives_meta_font_size); ?>px !important;
	letter-spacing: <?php echo esc_html($blog_archives_meta_text_spacing); ?>px !important;
	color: <?php echo esc_html($blog_archives_meta_font_color); ?> !important;
	transition: all .6s ease-in-out;
}
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .published:hover,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .published:hover,
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .published:hover a,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .published:hover a,
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .author:hover,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .author:hover,
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .author:hover a,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .author:hover a,
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta a:hover,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .dipi-categories:hover a,
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .dipi-categories:hover a,
body.archive article.et_pb_post .post-meta .published:hover,
body.archive article.et_pb_post .post-meta .published:hover a,
body.archive article.et_pb_post .post-meta .author:hover,
body.archive article.et_pb_post .post-meta .author:hover a,
body.archive article.et_pb_post .post-meta a:hover,
body.blog article.et_pb_post .post-meta a:hover,
body.blog article.et_pb_post .post-meta .published:hover,
body.blog article.et_pb_post .post-meta .author:hover a,
body.blog article.et_pb_post .post-meta .dipi-categories:hover a {
	transition: all .6s ease-in-out;
	color: <?php echo esc_html($blog_archives_meta_font_color_hover); ?> !important;
}

body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta:not(:last-child) span,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta:not(:last-child) span,
body.archive article.et_pb_post .post-meta:not(:last-child) span, 
body.blog article.et_pb_post .post-meta:not(:last-child) span, 
body.single article.et_pb_post .post-meta:not(:last-child) span {
	margin-right: 10px;
}

body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .author:before,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .author:before,
body.archive article.et_pb_post .post-meta .author:before, 
body.blog article.et_pb_post .post-meta .author:before, 
body.single article.et_pb_post .post-meta .author:before,
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .comments-number:before,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .comments-number:before,
body.archive article.et_pb_post .post-meta .comments-number:before, 
body.blog article.et_pb_post .post-meta .comments-number:before, 
body.single article.et_pb_post .post-meta .comments-number:before,
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .published:before, 
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .published:before,
body.archive article.et_pb_post .post-meta .published:before, 
body.blog article.et_pb_post .post-meta .published:before, 
body.single article.et_pb_post .post-meta .published:before,
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .dipi-categories:before,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .dipi-categories:before,
body.archive article.et_pb_post .post-meta .dipi-categories:before,
body.blog article.et_pb_post .post-meta .dipi-categories:before,
body.single article.et_pb_post .post-meta .dipi-categories:before {
	transition: all .6s ease-in-out;
	display: inline-block;
	box-sizing: border-box;
	font-family: ETmodules;
	font-size: <?php echo esc_html($blog_archives_meta_icon_size); ?>px;
	color: <?php echo esc_html($blog_archives_meta_icon_color); ?>;
	font-style: normal;
	font-variant: normal;
	line-height: 1.4em;
	text-transform: none;
	content: 'attr(data-icon)';
	speak: none;
	padding-right: 5px;
}

body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .author:hover::before,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .author:hover::before,
body.archive article.et_pb_post .post-meta .author:hover::before,
body.blog article.et_pb_post .post-meta .author:hover::before,
body.single article.et_pb_post .post-meta .author:hover::before,
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .comments-number:hover::before,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .comments-number:hover::before,
body.archive article.et_pb_post .post-meta .comments-number:hover::before,
body.blog article.et_pb_post .post-meta .comments-number:hover::before,
body.single article.et_pb_post .post-meta .comments-number:hover::before,
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .published:hover::before,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .published:hover::before,
body.archive article.et_pb_post .post-meta .published:hover::before,
body.blog article.et_pb_post .post-meta .published:hover::before,
body.single article.et_pb_post .post-meta .published:hover::before,
body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .dipi-categories:hover::before,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .dipi-categories:hover::before,
body.archive article.et_pb_post .post-meta .dipi-categories:hover::before,
body.blog article.et_pb_post .post-meta .dipi-categories:hover::before,
body.single article.et_pb_post .post-meta .dipi-categories:hover::before{
	transition: all .6s ease-in-out;
	color: <?php echo esc_html($blog_archives_meta_icon_hover_color); ?>;
}

body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .author:before,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .author:before,
body.archive article.et_pb_post .post-meta .author:before, 
body.blog article.et_pb_post .post-meta .author:before, 
body.single article.et_pb_post .post-meta .author:before{
	content: "\e08a";
}

body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .comments-number:before, 
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .comments-number:before,
body.archive article.et_pb_post .post-meta .comments-number:before, 
body.blog article.et_pb_post .post-meta .comments-number:before, 
body.single article.et_pb_post .post-meta .comments-number:before{
	content: 'w';
}

body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .published:before, 
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .published:before, 
body.archive article.et_pb_post .post-meta .published:before, 
body.blog article.et_pb_post .post-meta .published:before, 
body.single article.et_pb_post .post-meta .published:before{
	content: '}';
}

body.dipi-custom-archive-page .et_pb_module.et_pb_posts.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .dipi-categories:before,
body.dipi-custom-archive-page .et_pb_module.et_pb_blog_grid_wrapper.dipi-styled-blog .et_pb_ajax_pagination_container article.et_pb_post .post-meta .dipi-categories:before,
body.archive article.et_pb_post .post-meta .dipi-categories:before,
body.blog article.et_pb_post .post-meta .dipi-categories:before,
body.single article.et_pb_post .post-meta .dipi-categories:before{
	content: 'm';
}

.dipi-categories a{
	padding-right: 5px;
}

.dipi-categories a:not(:last-child):after {
	content: ",";
}

</style>