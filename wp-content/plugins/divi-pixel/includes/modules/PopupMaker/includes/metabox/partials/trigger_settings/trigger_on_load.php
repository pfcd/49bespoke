<?php
    $trigger_on_load_delay_start = get_post_meta(
        $post->ID, 'trigger_on_load-delay-start', true
    );
    if (empty($trigger_on_load_delay_start)) {
        $trigger_on_load_delay_start = '0';
    }
    $trigger_on_load_delay_end = get_post_meta(
        $post->ID, 'trigger_on_load-delay-end', true
    );
    if (empty($trigger_on_load_delay_end)) {
        $trigger_on_load_delay_end = '0';
    }

?>
<div class="dipi_popup-sub">
    <label
        for="trigger_on_load-delay-start"
        class="dipi_popup-sub-lbl"
    >
        Delay
    </label>
    <div class="dipi_popup-sub-val-container" >
        <input class="dipi_popup-sub-val" 
            type="text"
            name="trigger_on_load-delay-start"
            size = 5
            style="padding-right: 3em;"
            value="<?php echo esc_attr($trigger_on_load_delay_start); ?>"
        />
        <span class="dipi_popup-sub-suf">sec</span>
        <p class="dipi_popup-sub-descr">Start Delay</p>
    </div>
    <div class="dipi_popup-sub-val-container" >
        <input class="dipi_popup-sub-val" 
            type="text"
            name="trigger_on_load-delay-end"
            size = 5
            style="padding-right: 3em;"
            value="<?php echo esc_attr($trigger_on_load_delay_end); ?>"
        />
        <span class="dipi_popup-sub-suf">sec</span>
        <p class="dipi_popup-sub-descr">End Delay</p>
    </div>
</div>

<div></div> <!--Need to add this empty element to show bottom border-->

