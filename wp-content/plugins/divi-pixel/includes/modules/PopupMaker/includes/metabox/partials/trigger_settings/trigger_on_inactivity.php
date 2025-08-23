<?php
    $trigger_on_inactivity_delay = get_post_meta(
        $post->ID, 'trigger_on_inactivity-delay', true
    );
    if (empty($trigger_on_inactivity_delay)) {
        $trigger_on_inactivity_delay = '0';
    }
?>
<div class="dipi_popup-sub">
    <label for="trigger_on_inactivity-delay" class="dipi_popup-sub-lbl">
        Inactivity Delay
    </label>
    <div class="dipi_popup-sub-val-container" >
        <input class="dipi_popup-sub-val" 
            type="text"
            name="trigger_on_inactivity-delay"
            size = 5
            style="padding-right: 3em;"
            value="<?php echo esc_attr($trigger_on_inactivity_delay); ?>"
        />
        <span class="dipi_popup-sub-suf">sec</span>
        <p class="dipi_popup-sub-descr">Seconds</p>
    </div>
</div>

<div></div> <!--Need to add this empty element to show bottom border-->

