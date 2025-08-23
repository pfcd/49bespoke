<?php
namespace DiviPixel;

$dipi_before_nav_layout = intval(DIPI_Settings::get_option('before_nav_layout'));
$dipi_after_nav_layout = intval(DIPI_Settings::get_option('after_nav_layout'));
$dipi_nav_layout_homepage = DIPI_Settings::get_option('nav_layout_homepage');
$dipi_nav_layout_custom = DIPI_Settings::get_option('nav_layout_custom');
$dipi_nav_specific_pages = DIPI_Settings::get_option('nav_specific_pages');

$inject_layout = false;
if (!$dipi_nav_layout_homepage && $dipi_nav_layout_custom) {
    $inject_layout = true;
} else if ($dipi_nav_layout_homepage && (is_home() || is_front_page())) {
    $inject_layout = true;
} else if ($dipi_nav_layout_custom && !empty($dipi_nav_specific_pages) && is_page($dipi_nav_specific_pages)) {
    $inject_layout = true;
} else if ($dipi_before_nav_layout > 0 || $dipi_after_nav_layout > 0) {
    $inject_layout = true;
}

if (!$inject_layout) {
    return;
}
?>

<?php if ($dipi_before_nav_layout > 0): ?>

	<div id="dipi-injected-before-nav">
		<?php echo do_shortcode('[et_pb_section global_module="' . $dipi_before_nav_layout . '"][/et_pb_section]'); ?>
	</div>
	<script id="dipi_layout_inject_header_partial_js-before">
	jQuery(document).ready(function() {
		var $before_header_layout = jQuery("#dipi-injected-before-nav").detach();
		$before_header_layout.insertBefore("#main-header");
		$before_header_layout.insertBefore("#top-header");
		$before_header_layout.insertBefore(".et-l--header");
	});
	</script>
<?php endif;?>

<?php if ($dipi_after_nav_layout > 0): ?>
	<div id="dipi-injected-after-nav">
		<?php echo do_shortcode('[et_pb_section global_module="' . $dipi_after_nav_layout . '"][/et_pb_section]'); ?>
	</div>

	<script id="dipi_layout_inject_header_partial_js-before">
	jQuery(document).ready(function() {
		var $after_header_layout = jQuery("#dipi-injected-after-nav").detach();
		$after_header_layout.insertAfter('#main-header');
		$after_header_layout.insertAfter(".et-l--header");
	});
	</script>
<?php endif;?>