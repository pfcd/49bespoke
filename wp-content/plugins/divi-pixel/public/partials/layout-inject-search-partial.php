<?php
namespace DiviPixel;

$dipi_after_nav_search = DIPI_Settings::get_option('after_nav_search');

if (!$dipi_after_nav_search || $dipi_after_nav_search < 0 || !is_search()) {
    return;
}
?>

<div id="dipi-injected-after-nav-search">
	<?php echo do_shortcode('[et_pb_section global_module="' . $dipi_after_nav_search . '"][/et_pb_section]'); ?>
</div>

<script id="dipi_layout_inject_search_partial_js">
jQuery(document).ready(function() {
	var $after_nav_search_layout = jQuery("#dipi-injected-after-nav-search").detach();
	$after_nav_search_layout.insertAfter('#main-header');
	$after_nav_search_layout.insertAfter(".et-l--header");
});
</script>