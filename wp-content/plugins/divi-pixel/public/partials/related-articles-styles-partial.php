<?php
namespace DiviPixel;
//Background
$blog_related_section_background_image = DIPI_Customizer::get_option('blog_related_section_background_image');
$blog_related_section_background_color = DIPI_Customizer::get_option('blog_related_section_background_color');
$blog_related_section_background_image_size = DIPI_Customizer::get_option('blog_related_section_background_image_size');
$blog_related_section_background_image_repeat = DIPI_Customizer::get_option('blog_related_section_background_image_repeat');
$blog_related_section_background_image_position = DIPI_Customizer::get_option('blog_related_section_background_image_position');

$blog_related_section_font_select = DIPI_Customizer::get_option('blog_related_section_font_select');
$blog_related_section_font_weight = DIPI_Customizer::get_option('blog_related_section_font_weight');
$blog_related_section_font_size = DIPI_Customizer::get_option('blog_related_section_font_size');
$blog_related_section_font_color = DIPI_Customizer::get_option('blog_related_section_font_color'); //FIXME: Default was 
$blog_related_section_text_spacing = DIPI_Customizer::get_option('blog_related_section_text_spacing');
$blog_related_font_select = DIPI_Customizer::get_option('blog_related_font_select');
$blog_related_font_line_height = DIPI_Customizer::get_option('blog_related_font_line_height');
$blog_related_font_weight = DIPI_Customizer::get_option('blog_related_font_weight');
$blog_related_font_size = DIPI_Customizer::get_option('blog_related_font_size');
$blog_related_font_color = DIPI_Customizer::get_option('blog_related_font_color');
$blog_related_font_color_hover = DIPI_Customizer::get_option('blog_related_font_color_hover');
$blog_related_text_spacing = DIPI_Customizer::get_option('blog_related_text_spacing');
$blog_related_image_overlay_color = DIPI_Customizer::get_option('blog_related_image_overlay_color');
$blog_related_image_overlay_color_hover = DIPI_Customizer::get_option('blog_related_image_overlay_color_hover');
$blog_related_icon_select = DIPI_Customizer::get_option('blog_related_icon_select'); //FIXME: Default was '\24'
$blog_related_icon_size = DIPI_Customizer::get_option('blog_related_icon_size');
$blog_related_icon_color = DIPI_Customizer::get_option('blog_related_icon_color');
$blog_related_icon_color_hover = DIPI_Customizer::get_option('blog_related_icon_color_hover');
$blog_related_box_background_color = DIPI_Customizer::get_option('blog_related_box_background_color');
$blog_related_border_radius = DIPI_Customizer::get_option('blog_related_border_radius');
$blog_related_border_width = DIPI_Customizer::get_option('blog_related_border_width');
$blog_related_box_border_color = DIPI_Customizer::get_option('blog_related_box_border_color');
$blog_related_image_height = DIPI_Customizer::get_option('blog_related_image_height');
$blog_related_box_shadow = DIPI_Customizer::get_option('blog_related_box_shadow');
$blog_related_box_shadow_color = DIPI_Customizer::get_option('blog_related_box_shadow_color');
$blog_related_box_shadow_offset = DIPI_Customizer::get_option('blog_related_box_shadow_offset');
$blog_related_box_shadow_blur = DIPI_Customizer::get_option('blog_related_box_shadow_blur');
$blog_related_hover_box_shadow_color = DIPI_Customizer::get_option('blog_related_hover_box_shadow_color');
$blog_related_hover_box_shadow_offset = DIPI_Customizer::get_option('blog_related_hover_box_shadow_offset');
$blog_related_hover_box_shadow_blur = DIPI_Customizer::get_option('blog_related_hover_box_shadow_blur');
?>

<style type="text/css" id="related-articles-css">
.dipi-related-articles {
	background-color: <?php echo esc_html($blog_related_section_background_color) ?> !important;
	<?php if ($blog_related_section_background_image && filter_var($blog_related_section_background_image, FILTER_VALIDATE_URL)): ?>
		background-image: url(<?php echo esc_url($blog_related_section_background_image) ?>) !important;
	<?php endif; ?>
	<?php if('cover' === $blog_related_section_background_image_size) : ?>
	background-size: cover;
	<?php elseif('fit' === $blog_related_section_background_image_size) : ?>
	background-size: contain;
	<?php elseif('actual' === $blog_related_section_background_image_size) : ?>
	background-size: auto auto ;
	<?php endif; ?>
	<?php if('no-repeat' === $blog_related_section_background_image_repeat) : ?>
	background-repeat: no-repeat ;
	<?php elseif('repeat' === $blog_related_section_background_image_repeat) : ?>
	background-repeat: repeat ;
	<?php elseif('repeat-x' === $blog_related_section_background_image_repeat) : ?>
	background-repeat: repeat-x;
	<?php elseif('repeat-y' === $blog_related_section_background_image_repeat) : ?>
	background-repeat: repeat-y;
	<?php endif; ?>
	<?php if('top_left' === $blog_related_section_background_image_position) : ?>
	background-position-x: left;
    background-position-y: top;
	<?php elseif('top_center' === $blog_related_section_background_image_position) : ?>
	background-position-x: center;
	background-position-y: top;
	<?php elseif('top_right' === $blog_related_section_background_image_position) : ?>
	background-position-x: right;
    background-position-y: top;
	<?php elseif('center_left' === $blog_related_section_background_image_position) : ?>
	background-position-x: left;
    background-position-y: center;
	<?php elseif('center_center' === $blog_related_section_background_image_position) : ?>
	background-position-x: center;
    background-position-y: center;
	<?php elseif('center_right' === $blog_related_section_background_image_position) : ?>
	background-position-x: right;
    background-position-y: center;
	<?php elseif('bottom_left' === $blog_related_section_background_image_position) : ?>
	background-position-x: left;
    background-position-y: bottom;
	<?php elseif('bottom_center' === $blog_related_section_background_image_position) : ?>
	background-position-x: center;
    background-position-y: bottom;
	<?php elseif('bottom_right' === $blog_related_section_background_image_position) : ?>
	background-position-x: right;
    background-position-y: bottom;
	<?php endif; ?>
}

	.dipi-related-section-articles-title {
		<?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($blog_related_section_font_select)), 'html'); ?>
		font-size:<?php echo esc_html($blog_related_section_font_size); ?>px !important;
		color:<?php echo esc_html($blog_related_section_font_color); ?> !important;
		letter-spacing: <?php echo esc_html($blog_related_section_text_spacing); ?>px !important;
	    font-weight: <?php echo esc_html($blog_related_section_font_weight); ?> !important;
	    <?php echo esc_html(DIPI_Customizer::print_font_style_option("blog_related_section_font_style")); ?>
	}

	.dipi-related-article-thumb img {
		height: <?php echo esc_html($blog_related_image_height); ?>px !important;
	}

	.dipi-related-article-thumb .dipi-image-overlay {
  		transition: all .3s ease-in-out !important;
		background: <?php echo esc_html($blog_related_image_overlay_color); ?> !important;
	}

	.dipi-related-article-thumb .dipi-image-overlay:hover,
	.dipi-related-article-thumb .dipi-image-overlay-hover{
  		transition: all .3s ease-in-out;
		background: <?php echo esc_html($blog_related_image_overlay_color_hover); ?> !important;
	}

	.dipi-related-article-column {
		background: <?php echo esc_html($blog_related_box_background_color); ?> !important;
		border-radius:<?php echo esc_html($blog_related_border_radius); ?>px !important;
		border-width:<?php echo esc_html($blog_related_border_width); ?>px !important;
		border-color:<?php echo esc_html($blog_related_box_border_color); ?> !important;
		<?php if(1 == $blog_related_box_shadow ) : ?>
        box-shadow: 0 <?php echo esc_html($blog_related_box_shadow_offset); ?>px <?php echo esc_html($blog_related_box_shadow_blur); ?>px <?php echo esc_html($blog_related_box_shadow_color); ?>;
		<?php endif; ?>
	}

	.dipi-related-article-column:hover {
		<?php if(1 == $blog_related_box_shadow ) : ?>
        box-shadow: 0 <?php echo esc_html($blog_related_hover_box_shadow_offset); ?>px <?php echo esc_html($blog_related_hover_box_shadow_blur); ?>px <?php echo esc_html($blog_related_hover_box_shadow_color); ?>;
		<?php endif; ?>
	}
	
  	.dipi-related-article-title{
		padding-right: calc(<?php echo esc_html($blog_related_icon_size); ?>px  + 25px);
	}
	
	.dipi-related-article-title {
		<?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($blog_related_font_select)), 'html'); ?>
		<?php echo esc_html(DIPI_Customizer::print_font_style_option("blog_related_font_style")); ?>
		font-size:<?php echo esc_html($blog_related_font_size); ?>px;
		line-height: <?php echo esc_html($blog_related_font_line_height); ?>px;
		color:<?php echo esc_html($blog_related_font_color); ?> !important;
		letter-spacing: <?php echo esc_html($blog_related_text_spacing); ?>px;
	    font-weight: <?php echo esc_html($blog_related_font_weight); ?>;
	}

	.dipi-related-article-title:hover,
	.dipi-related-article-title-hover {
		color:<?php echo esc_html($blog_related_font_color_hover); ?> !important;
	}

	.dipi-readmore-arrow:before {
		font-size: <?php echo esc_html($blog_related_icon_size); ?>px !important;
		<?php if(isset($blog_related_icon_color)): ?>
		color: <?php echo esc_html($blog_related_icon_color); ?> !important;
		<?php endif; ?>
		<?php if(isset($blog_related_icon_select)) : ?>
	    content: '<?php echo esc_html($blog_related_icon_select); ?>' !important;
		<?php endif; ?>
	}

	.dipi-readmore-arrow:hover:before,
	.dipi-related-article-arrow-hover .dipi-readmore-arrow:before {
		<?php if(isset($blog_related_icon_color_hover)) : ?>
		color: <?php echo esc_html($blog_related_icon_color_hover); ?> !important;
		<?php endif; ?>
	}

</style>

<script type="text/javascript" id="related-articles-js">
	jQuery(document).ready(function() {
		jQuery(document).on('hover', '.dipi-related-article-column', function (e) {
			if(e.type == 'mouseenter') {
				if (jQuery(this).find(".dipi-related-article-thumb").hasClass("dipi-zoom-in") ) {
					jQuery(this).find(".dipi-related-article-thumb").addClass("dipi-zoom-in-hover");
				}
				if (jQuery(this).find(".dipi-related-article-thumb").hasClass("dipi-zoom-out") ) {
					jQuery(this).find(".dipi-related-article-thumb").addClass("dipi-zoom-out-hover");
				}
				if ( jQuery(this).find(".dipi-related-article-thumb").hasClass("dipi-zoom-rotate") ) {
					jQuery(this).find(".dipi-related-article-thumb").addClass("dipi-zoom-rotate-hover");
				}
				jQuery(this).find(".dipi-related-article-title").addClass("dipi-related-article-title-hover");
				jQuery(this).find(".dipi-image-overlay").addClass("dipi-image-overlay-hover");
				jQuery(this).find(".dipi-related-article-arrow").addClass("dipi-related-article-arrow-hover");
			} else if (e.type == 'mouseleave') {
				if ( jQuery(this).find(".dipi-related-article-thumb").hasClass("dipi-zoom-in") ) {
					jQuery(this).find(".dipi-related-article-thumb").removeClass("dipi-zoom-in-hover");
				}
				if ( jQuery(this).find(".dipi-related-article-thumb").hasClass("dipi-zoom-out") ) {
					jQuery(this).find(".dipi-related-article-thumb").removeClass("dipi-zoom-out-hover");
				}
				if ( jQuery(this).find(".dipi-related-article-thumb").hasClass("dipi-zoom-rotate") ) {
					jQuery(this).find(".dipi-related-article-thumb").removeClass("dipi-zoom-rotate-hover");
				}
				jQuery(this).find(".dipi-related-article-title").removeClass("dipi-related-article-title-hover");
				jQuery(this).find(".dipi-image-overlay").removeClass("dipi-image-overlay-hover");
				jQuery(this).find(".dipi-related-article-arrow").removeClass("dipi-related-article-arrow-hover");
			}
	    });
	});
</script>

<!-- TODO: Instead of adding the class via JS, we should add the class directly in PHP -->
<?php if( is_single() ) : ?>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		const body = document.body;
		if (body && body.classList.contains('et-tb-has-template') && body.classList.contains('et-tb-has-body')) {
			const related_articles = document.getElementsByClassName('dipi-related-articles-row');
			const len = related_articles !== null ? related_articles.length : 0;
			var i = 0;
			for(i; i < len; i++) {
				related_articles[i].classList.add('et_pb_row'); 
			}
		}
	})
</script>
<?php endif; ?>