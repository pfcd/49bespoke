<?php 
namespace DiviPixel;

$main_header_shadow = DIPI_Customizer::get_option('main_header_shadow');
$main_header_shadow_color = DIPI_Customizer::get_option('main_header_shadow_color');
$main_header_shadow_offset = DIPI_Customizer::get_option('main_header_shadow_offset');
$main_header_shadow_blur = DIPI_Customizer::get_option('main_header_shadow_blur');
$fixed_header_shadow = DIPI_Customizer::get_option('fixed_header_shadow');
$fixed_header_shadow_color = DIPI_Customizer::get_option('fixed_header_shadow_color');
$fixed_header_shadow_offset = DIPI_Customizer::get_option('fixed_header_shadow_offset');  //FIXME: Default was 50
$fixed_header_shadow_blur = DIPI_Customizer::get_option('fixed_header_shadow_blur');//FIXME: Default was 100
?>

<?php if($main_header_shadow) : ?>
<style type="text/css" id="main-header-bar-css">
#main-header,
.et-l--header {
	box-shadow: 0px <?php echo esc_html($main_header_shadow_offset); ?>px <?php echo esc_html($main_header_shadow_blur); ?>px <?php echo esc_html($main_header_shadow_color); ?> !important;
	transition: all 0.3s ease-in-out;
}
</style>

<?php endif; ?>

<?php if($fixed_header_shadow) : ?>
<style type="text/css" id="fixed-header-bar-css">
header#main-header.et-fixed-header {
	box-shadow: 0px <?php echo esc_html($fixed_header_shadow_offset); ?>px <?php echo esc_html($fixed_header_shadow_blur); ?>px <?php echo esc_html($fixed_header_shadow_color); ?> !important;
	transition: all 0.3s ease-in-out;
}
</style>

<?php endif; ?>
<style type="text/css" id="main-header-bar-mobile-css">
/* .et_header_style_centered header#main-header.et-fixed-header .logo_container.logo_container {
	height: auto !important;
} */
</style>