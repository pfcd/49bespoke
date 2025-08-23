<?php
namespace DiviPixel;

// FIXME: Check if this works as intended. If no option is selected, DIPI_Settings should return >false<
$select_footer_layout = DIPI_Settings::get_option('select_footer_layout');
if (!$select_footer_layout || dipi_is_vb()) {
    return;
}
?>

<div id="dipi-injected-footer">
	<?php echo do_shortcode('[et_pb_section global_module="' . $select_footer_layout . '"][/et_pb_section]'); ?>
</div>

<script>
    // jQuery( document ).ready(function() {
    //     jQuery("#dipi-injected-footer").prependTo("#main-footer");
    // });
    document.addEventListener("DOMContentLoaded", function() {
        let main_footer = document.getElementById('main-footer');
        let injected_footer = document.getElementById('dipi-injected-footer');
        if(main_footer !== null)
            main_footer.insertBefore(injected_footer, main_footer.firstChild);
    });
</script>