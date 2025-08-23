<?php
namespace DiviPixel;

$blog_comments_font_select = DIPI_Customizer::get_option('blog_comments_font_select');
$blog_comments_font_weight = DIPI_Customizer::get_option('blog_comments_font_weight');
$blog_comments_font_style = DIPI_Customizer::get_option('blog_comments_font_style');
$blog_comments_font_size = 	DIPI_Customizer::get_option('blog_comments_font_size');
$blog_comments_text_spacing = DIPI_Customizer::get_option('blog_comments_text_spacing');
$blog_comments_field_padding = 	DIPI_Customizer::get_option('blog_comments_field_padding');
$blog_comments_field_border_radius = 	DIPI_Customizer::get_option('blog_comments_field_border_radius');
$blog_comments_field_border = DIPI_Customizer::get_option('blog_comments_field_border');
$blog_comments_field_color = DIPI_Customizer::get_option('blog_comments_field_color');
$blog_comments_font_color = DIPI_Customizer::get_option('blog_comments_font_color');
$blog_comments_field_background_color = DIPI_Customizer::get_option('blog_comments_field_background_color');
$blog_comments_field_shadow = DIPI_Customizer::get_option('blog_comments_field_shadow');
$blog_comments_field_shadow_color = DIPI_Customizer::get_option('blog_comments_field_shadow_color');
$blog_comments_field_shadow_offset = DIPI_Customizer::get_option('blog_comments_field_shadow_offset');
$blog_comments_field_shadow_blur = DIPI_Customizer::get_option('blog_comments_field_shadow_blur');
$blog_comments_submit_btn_effect = DIPI_Customizer::get_option('blog_comments_submit_btn_effect');
$blog_comments_btn_font_select = DIPI_Customizer::get_option('blog_comments_btn_font_select');
$blog_comments_btn_font_weight = DIPI_Customizer::get_option('blog_comments_btn_font_weight');
$blog_comments_btn_font_size = 	DIPI_Customizer::get_option('blog_comments_btn_font_size');
$blog_comments_btn_text_spacing = DIPI_Customizer::get_option('blog_comments_btn_text_spacing');
$blog_comments_btn_text_spacing_hover = DIPI_Customizer::get_option('blog_comments_btn_text_spacing_hover');
$blog_comments_btn_padding = DIPI_Customizer::get_option('blog_comments_btn_padding');
$blog_comments_btn_border_radius = DIPI_Customizer::get_option('blog_comments_btn_border_radius');
$blog_comments_btn_border = DIPI_Customizer::get_option('blog_comments_btn_border');
$blog_comments_btn_color = 	DIPI_Customizer::get_option('blog_comments_btn_color');
$blog_comments_btn_font_color = DIPI_Customizer::get_option('blog_comments_btn_font_color');
$blog_comments_btn_background_color = DIPI_Customizer::get_option('blog_comments_btn_background_color');

$blog_comments_btn_color_hover = DIPI_Customizer::get_option('blog_comments_btn_color_hover');
$blog_comments_btn_font_color_hover = DIPI_Customizer::get_option('blog_comments_btn_font_color_hover');
$blog_comments_btn_background_color_hover = DIPI_Customizer::get_option('blog_comments_btn_background_color_hover');

$blog_comments_btn_shadow = DIPI_Customizer::get_option('blog_comments_btn_shadow');
$blog_comments_btn_shadow_color = DIPI_Customizer::get_option('blog_comments_btn_shadow_color');
$blog_comments_btn_shadow_offset = DIPI_Customizer::get_option('blog_comments_btn_shadow_offset');
$blog_comments_btn_shadow_blur = DIPI_Customizer::get_option('blog_comments_btn_shadow_blur');

$blog_comments_btn_shadow_color_hover = DIPI_Customizer::get_option('blog_comments_btn_shadow_color_hover');
$blog_comments_btn_shadow_offset_hover = DIPI_Customizer::get_option('blog_comments_btn_shadow_offset_hover');
$blog_comments_btn_shadow_blur_hover = DIPI_Customizer::get_option('blog_comments_btn_shadow_blur_hover');
?>

<style type="text/css" id="custom-comments-section-css">

#commentform input[type=email]::placeholder, 
#commentform input[type=text]::placeholder, 
#commentform input[type=url]::placeholder, 
#commentform textarea::placeholder,
#commentform input[type=email], 
#commentform input[type=text], 
#commentform input[type=url], 
#commentform textarea {
  <?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($blog_comments_font_select)), 'html'); ?>
  <?php echo esc_html(DIPI_Customizer::print_font_style_option("blog_comments_font_style")); ?>
  font-weight: <?php echo esc_html($blog_comments_font_weight); ?>;
  font-size: <?php echo esc_html($blog_comments_font_size); ?>px;
  letter-spacing: <?php echo esc_html($blog_comments_text_spacing); ?>px;
	padding: <?php echo esc_html($blog_comments_field_padding); ?>px;
	border-radius: <?php echo esc_html($blog_comments_field_border_radius); ?>px;
	border-width: <?php echo esc_html($blog_comments_field_border); ?>px;
	border-color: <?php echo esc_html($blog_comments_field_color); ?>;
	color: <?php echo esc_html($blog_comments_font_color); ?>;
	background-color: <?php echo esc_html($blog_comments_field_background_color); ?>;
	<?php if($blog_comments_field_shadow) : ?>
		box-shadow: 0px <?php echo esc_html($blog_comments_field_shadow_offset); ?>px <?php echo esc_html($blog_comments_field_shadow_blur); ?>px <?php echo esc_html($blog_comments_field_shadow_color); ?>;
	<?php endif; ?>

}

#commentform .form-submit .et_pb_button {
	<?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($blog_comments_btn_font_select)), 'html'); ?>
	font-size: <?php echo esc_html($blog_comments_btn_font_size); ?>px;
	letter-spacing: <?php echo esc_html($blog_comments_btn_text_spacing); ?>px;
	font-weight: <?php echo esc_html($blog_comments_btn_font_weight); ?>;
	padding: <?php echo esc_html($blog_comments_btn_padding); ?>px !important;
	border-radius: <?php echo esc_html($blog_comments_btn_border_radius); ?>px;
	border-width: <?php echo esc_html($blog_comments_btn_border); ?>px;
	border-color: <?php echo esc_html($blog_comments_btn_color); ?>;
	color: <?php echo esc_html($blog_comments_btn_font_color); ?>;
	background-color: <?php echo esc_html($blog_comments_btn_background_color); ?> !important;
  <?php echo esc_html(DIPI_Customizer::print_font_style_option("blog_comments_btn_font_style")); ?>
	<?php if($blog_comments_btn_shadow) : ?>
		box-shadow: 0px <?php echo esc_html($blog_comments_btn_shadow_offset); ?>px <?php echo esc_html($blog_comments_btn_shadow_blur); ?>px <?php echo esc_html($blog_comments_btn_shadow_color); ?> !important;
	<?php endif; ?>
}

#commentform .form-submit .et_pb_button:hover {
	color: <?php echo esc_html($blog_comments_btn_font_color_hover); ?>;
	border-color: <?php echo esc_html($blog_comments_btn_color_hover); ?>;
	background-color: <?php echo esc_html($blog_comments_btn_background_color_hover); ?> !important;
  	letter-spacing: <?php echo esc_html($blog_comments_btn_text_spacing_hover); ?>px;
  	<?php if($blog_comments_btn_shadow) : ?>
	box-shadow: 0px <?php echo esc_html($blog_comments_btn_shadow_offset_hover); ?>px <?php echo esc_html($blog_comments_btn_shadow_blur_hover); ?>px <?php echo esc_html($blog_comments_btn_shadow_color_hover); ?> !important;
	<?php endif; ?>
}

#commentform .form-submit .et_pb_button.dipi-shadow-hide-onhover:hover {
	box-shadow: none;
}

</style>

<script type="text/javascript" id="custom-comments-section-js">
	jQuery( document ).ready(function() {
		<?php if( 'zoomin' === $blog_comments_submit_btn_effect) : ?>
			jQuery("#commentform .form-submit .et_pb_button").addClass("dipi-zoom-in");
		<?php endif; ?>
		<?php if( 'zoomout' === $blog_comments_submit_btn_effect) : ?>
			jQuery("#commentform .form-submit .et_pb_button").addClass("dipi-zoom-out");
		<?php endif; ?>
		<?php if( 'moveup' === $blog_comments_submit_btn_effect) : ?>
			jQuery("#commentform .form-submit .et_pb_button").addClass("dipi-move-up");
		<?php endif; ?>
	});
</script>