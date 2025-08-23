<?php
namespace DiviPixel;

$dipi_after_nav_categories = DIPI_Settings::get_option('after_nav_categories', '-1');

if(!$dipi_after_nav_categories || $dipi_after_nav_categories < 0 || !is_category()){
	return;
}
?>

<div id="dipi-injected-after-nav-categories">
	<?php echo do_shortcode('[et_pb_section global_module="' . $dipi_after_nav_categories . '"][/et_pb_section]'); ?>
</div>
