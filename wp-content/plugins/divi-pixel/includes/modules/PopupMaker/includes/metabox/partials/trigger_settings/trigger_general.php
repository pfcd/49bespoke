<?php
    $dipi_popup_active = get_post_meta(
        $post->ID, 'dipi_popup-active', true
    );
    if (empty($dipi_popup_active)) {
        $dipi_popup_active = 'true';
    }
?>
<div id="trigger_general_settings">
    <div class="dipi_popup-sub">
          <label
            for="dipi_popup-active"
            class="dipi_popup-sub-lbl"
        >
            Active
        </label>
        <div class="dipi_popup-sub-val-container raido" >
            <div class="dipi-popup-toggle__button">
                <input
                    type="hidden"
                    name="dipi_popup-active"
                    value = "false"
                >
                <input
                    class="dipi-popup-toggle__switch"
                    type="checkbox"
                    name="dipi_popup-active"
                    value = "true"
                    <?php if ( $dipi_popup_active  === 'true') { ?> checked<?php } ?>
                >
                <div class="dipi-popup-toggle__slider"></div>
                <label class="for-checked">Yes</label>  
                <label class="for-unchecked">No</label>
            </div>
            <p class="dipi_popup-sub-descr">Active/Inactive</p>
        </div>
    </div>
</div>