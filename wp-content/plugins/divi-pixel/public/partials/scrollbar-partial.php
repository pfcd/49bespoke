<?php
namespace DiviPixel;

$browser_scrollbar_background = DIPI_Customizer::get_option('browser_scrollbar_background');
$browser_scrollbar_color = DIPI_Customizer::get_option('browser_scrollbar_color');
$browser_scrollbar_width = DIPI_Customizer::get_option('browser_scrollbar_width');
$browser_scrollbar_radius = DIPI_Customizer::get_option('browser_scrollbar_radius');
$browser_scrollbar_shadow = DIPI_Customizer::get_option('browser_scrollbar_shadow');
$browser_scrollbar_shadow_color = DIPI_Customizer::get_option('browser_scrollbar_shadow_color');
$browser_scrollbar_shadow_offset = DIPI_Customizer::get_option('browser_scrollbar_shadow_offset');
$browser_scrollbar_shadow_blur = DIPI_Customizer::get_option('browser_scrollbar_shadow_blur'); //FIXME: Default was '6'
?>

<style type="text/css">

body::-webkit-scrollbar {
	width: <?php echo esc_html($browser_scrollbar_width); ?>px;
	background-color: <?php echo esc_html($browser_scrollbar_background); ?>;
	outline: none;
}

body::-webkit-scrollbar-thumb {
	border-radius: <?php echo esc_html($browser_scrollbar_radius); ?>px;
	background-color: <?php echo esc_html($browser_scrollbar_color); ?>;
}

body::-webkit-scrollbar-track {
	background-color: <?php echo esc_html($browser_scrollbar_background); ?>;
	border-radius: 0px;
}

<?php if(true === $browser_scrollbar_shadow || 1 ==  $browser_scrollbar_shadow) : ?>
body::-webkit-scrollbar-track {
	-webkit-box-shadow: inset 0 <?php echo esc_html($browser_scrollbar_shadow_offset); ?>px <?php echo esc_html($browser_scrollbar_shadow_blur); ?>px <?php echo esc_html($browser_scrollbar_shadow_color); ?>;
}
<?php endif; ?>
</style>