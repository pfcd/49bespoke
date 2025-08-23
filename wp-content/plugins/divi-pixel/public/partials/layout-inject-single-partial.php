<?php
namespace DiviPixel;

$dipi_after_nav_post_layout = DIPI_Settings::get_option('after_nav_post_layout');

if(!$dipi_after_nav_post_layout || $dipi_after_nav_post_layout < 0 || !is_single()){
	return;
}
?>

<div id="dipi-injected-after-nav-post">
	<?php echo do_shortcode('[et_pb_section global_module="' . $dipi_after_nav_post_layout . '"][/et_pb_section]'); ?>
</div>

<script id="dipi_layout_inject_single_partial_js">
jQuery(document).ready(function() {
	var $after_nav_post_layout = jQuery("#dipi-injected-after-nav-post").detach();
	$after_nav_post_layout.insertAfter('#main-header');
	$after_nav_post_layout.insertAfter(".et-l--header");
});
</script>