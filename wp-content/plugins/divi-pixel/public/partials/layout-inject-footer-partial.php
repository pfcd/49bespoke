<?php
namespace DiviPixel;

$dipi_before_footer_layout = DIPI_Settings::get_option('before_footer_layout');
$dipi_after_footer_layout = DIPI_Settings::get_option('after_footer_layout');
$dipi_footer_layout_homepage = DIPI_Settings::get_option('footer_layout_homepage');
$dipi_footer_layout_custom = DIPI_Settings::get_option('footer_layout_custom');
$dipi_footer_specific_pages = DIPI_Settings::get_option('footer_specific_pages');

$inject_layout = false;
if (!$dipi_footer_layout_homepage && $dipi_footer_layout_custom) {
    $inject_layout = true;
} else if ($dipi_footer_layout_homepage && (is_home() || is_front_page())) {
    $inject_layout = true;
} else if ($dipi_footer_layout_custom && !empty($dipi_footer_specific_pages) && is_page($dipi_footer_specific_pages)) {
    $inject_layout = true;
} else if($dipi_before_footer_layout > 0 || $dipi_after_footer_layout > 0) {
    $inject_layout = true;
}

if (!$inject_layout) {
    return;
}
?>

<?php if ($dipi_before_footer_layout > 0): ?>
	<div id="dipi-injected-before-footer">
		<?php echo do_shortcode('[et_pb_section global_module="' . $dipi_before_footer_layout . '"][/et_pb_section]'); ?>
	</div>
	<script id="dipi_layout_inject_footer_partial_js-before">
	jQuery(document).ready(function() {
		var $before_footer_layout = jQuery("#dipi-injected-before-footer").detach();
		$before_footer_layout.insertBefore("#main-footer");
		$before_footer_layout.insertBefore(".et-l--footer");
	});
	</script>
<?php endif;?>

<?php if ($dipi_after_footer_layout > 0): ?>
	<div id="dipi-injected-after-footer">
		<?php echo do_shortcode('[et_pb_section global_module="' . $dipi_after_footer_layout . '"][/et_pb_section]'); ?>
	</div>
	<script id="dipi_layout_inject_footer_partial_js-after">
	jQuery(document).ready(function() {
		var $after_footer_layout = jQuery("#dipi-injected-after-footer").detach();
		$after_footer_layout.insertAfter('#main-footer');
		$after_footer_layout.insertAfter(".et-l--footer");
	});
	</script>
<?php endif;?>
