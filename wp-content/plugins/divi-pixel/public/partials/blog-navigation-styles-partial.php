<?php 
namespace DiviPixel;
//Background
$blog_nav_section_background_image = DIPI_Customizer::get_option('blog_nav_section_background_image');
$blog_nav_section_background_color = DIPI_Customizer::get_option('blog_nav_section_background_color');
$blog_nav_section_background_image_size = DIPI_Customizer::get_option('blog_nav_section_background_image_size');
$blog_nav_section_background_image_repeat = DIPI_Customizer::get_option('blog_nav_section_background_image_repeat');

$blog_nav_btn_select = DIPI_Customizer::get_option('blog_nav_btn_select');
$blog_nav_btn_weight = DIPI_Customizer::get_option('blog_nav_btn_weight');
$blog_nav_btn_size = DIPI_Customizer::get_option('blog_nav_btn_size');
$blog_nav_btn_spacing = DIPI_Customizer::get_option('blog_nav_btn_spacing');
$blog_nav_btn_color = DIPI_Customizer::get_option('blog_nav_btn_color');
$blog_nav_btn_color_hover = DIPI_Customizer::get_option('blog_nav_btn_color_hover');
$blog_nav_btn_icon_size = DIPI_Customizer::get_option('blog_nav_btn_icon_size');
$blog_nav_box_padding = DIPI_Customizer::get_option('blog_nav_box_padding');
$blog_nav_border_radius = DIPI_Customizer::get_option('blog_nav_border_radius');
$blog_nav_border = DIPI_Customizer::get_option('blog_nav_border');
$blog_nav_border_color = DIPI_Customizer::get_option('blog_nav_border_color');
$blog_nav_border_color_hover = DIPI_Customizer::get_option('blog_nav_border_color_hover');
$blog_nav_background_color = DIPI_Customizer::get_option('blog_nav_background_color');
$blog_nav_background_color_hover = DIPI_Customizer::get_option('blog_nav_background_color_hover');
$blog_nav_shadow = DIPI_Customizer::get_option('blog_nav_shadow');
$blog_nav_shadow_color = DIPI_Customizer::get_option('blog_nav_shadow_color');
$blog_nav_shadow_offset = DIPI_Customizer::get_option('blog_nav_shadow_offset');
$blog_nav_shadow_blur = DIPI_Customizer::get_option('blog_nav_shadow_blur');
$blog_nav_shadow_color_hover = DIPI_Customizer::get_option('blog_nav_shadow_color_hover');
$blog_nav_shadow_offset_hover = DIPI_Customizer::get_option('blog_nav_shadow_offset_hover');
$blog_nav_shadow_blur_hover = DIPI_Customizer::get_option('blog_nav_shadow_blur_hover');

?>

<style type="text/css" id="blog-navigation-styles-partial-js">

	#dipi-post-navigation{
		background-color: <?php echo esc_html($blog_nav_section_background_color); ?> !important;
		<?php if ($blog_nav_section_background_image && filter_var($blog_nav_section_background_image, FILTER_VALIDATE_URL)): ?>
		background-image: url(<?php echo esc_html($blog_nav_section_background_image) ?>) !important;
		<?php endif; ?>
		<?php if('cover' === $blog_nav_section_background_image_size) : ?>
		background-size: cover;
		<?php elseif('fit' === $blog_nav_section_background_image_size) : ?>
		background-size: contain;
		<?php elseif('actual' === $blog_nav_section_background_image_size) : ?>
		background-size: auto auto ;
		<?php endif; ?>
		<?php if('no-repeat' === $blog_nav_section_background_image_repeat) : ?>
		background-repeat: no-repeat ;
		<?php elseif('repeat' === $blog_nav_section_background_image_repeat) : ?>
		background-repeat: repeat ;
		<?php elseif('repeat-x' === $blog_nav_section_background_image_repeat) : ?>
		background-repeat: repeat-x;
		<?php elseif('repeat-y' === $blog_nav_section_background_image_repeat) : ?>
		background-repeat: repeat-y;
		<?php endif; ?>
	}

	.dipi-post-row .dipi-post-left,
	.dipi-post-row .dipi-post-left a,
	.dipi-post-row .dipi-post-right,
	.dipi-post-row .dipi-post-right a {
		transition: all .5s ease-in-out;
		<?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($blog_nav_btn_select)), 'html'); ?>
		font-weight: <?php echo esc_html($blog_nav_btn_weight); ?>;
	  	<?php echo esc_html(DIPI_Customizer::print_font_style_option("blog_nav_btn_style")); ?>
		font-size: <?php echo esc_html($blog_nav_btn_size); ?>px;
		letter-spacing: <?php echo esc_html($blog_nav_btn_spacing); ?>px;
		color: <?php echo esc_html($blog_nav_btn_color); ?>;
		display: block;
    	display: flex;
    	align-items: center;
	}


	.dipi-post-left .et-pb-icon,
	.dipi-post-right .et-pb-icon {
		font-size: <?php echo esc_html($blog_nav_btn_icon_size); ?>px !important;
	}

	.dipi-post-left,
	.dipi-post-right {
	    padding: <?php echo esc_html($blog_nav_box_padding) ?>px;
	    border-radius: <?php echo esc_html($blog_nav_border_radius); ?>px;
	    border-width: <?php echo esc_html($blog_nav_border); ?>px;
	    border-color: <?php echo esc_html($blog_nav_border_color); ?>;
	    border-style: solid;
	    background-color: <?php echo esc_html($blog_nav_background_color); ?>;
	    <?php if( $blog_nav_shadow ):?>
			box-shadow: 0px <?php echo esc_html($blog_nav_shadow_offset); ?>px <?php echo esc_html($blog_nav_shadow_blur); ?>px <?php echo esc_html($blog_nav_shadow_color); ?> !important;
		<?php endif; ?>
	}

	.dipi-post-left:hover,
	.dipi-post-right:hover {
    	<?php if($blog_nav_shadow) : ?>
			box-shadow: 0px <?php echo esc_html($blog_nav_shadow_offset_hover); ?>px <?php echo esc_html($blog_nav_shadow_blur_hover); ?>px <?php echo esc_html($blog_nav_shadow_color_hover); ?> !important;
		<?php endif; ?>
	}

	.dipi-post-left:hover,
	.dipi-post-right:hover {
    	border-color: <?php echo esc_html($blog_nav_border_color_hover); ?>;
    	background-color: <?php echo esc_html($blog_nav_background_color_hover); ?>;
	}

	.dipi-post-row .dipi-post-left:hover,
	.dipi-post-row .dipi-post-right:hover,
	.dipi-post-row .dipi-post-left:hover a,
	.dipi-post-row .dipi-post-right:hover a,
	.dipi-post-row .dipi-post-left a:hover, 
	.dipi-post-row .dipi-post-right a:hover {
    	transition: all .3s ease-in-out;
		color: <?php echo esc_html($blog_nav_btn_color_hover); ?>;
		cursor: pointer;
	}
</style>