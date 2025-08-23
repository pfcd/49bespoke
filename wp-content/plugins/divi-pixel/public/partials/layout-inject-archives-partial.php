<?php
namespace DiviPixel;

$dipi_after_nav_archives = DIPI_Settings::get_option('after_nav_archives');

if(!$dipi_after_nav_archives || $dipi_after_nav_archives < 0 || !is_home() || is_category()){
	return;
}
?>

<div id="dipi-injected-after-nav-archives">
	<?php echo do_shortcode('[et_pb_section global_module="' . $dipi_after_nav_archives . '"][/et_pb_section]'); ?>
</div>