<?php
    $trigger_on_scroll_offset = get_post_meta(
        $post->ID, 'trigger_on_scroll-offset', true
    );
    if (empty($trigger_on_scroll_offset)) {
        $trigger_on_scroll_offset = '0';
    }
    $trigger_on_scroll_offset_units = get_post_meta(
        $post->ID, 'trigger_autotrigger-offset_units', true
    );
    if (empty($trigger_on_scroll_offset_units)) {
        $trigger_on_scroll_offset_units = 'px';
    }
    $trigger_on_scroll_offset_tablet = get_post_meta(
        $post->ID, 'trigger_on_scroll-offset_tablet', true
    );
    if (empty($trigger_on_scroll_offset_tablet)) {
        $trigger_on_scroll_offset_tablet = '';
    }
    $trigger_on_scroll_offset_units_tablet = get_post_meta(
        $post->ID, 'trigger_autotrigger-offset_units_tablet', true
    );
    if (empty($trigger_on_scroll_offset_units_tablet)) {
        $trigger_on_scroll_offset_units_tablet = '';
    }
     $trigger_on_scroll_offset_phone = get_post_meta(
        $post->ID, 'trigger_on_scroll-offset_phone', true
    );
    if (empty($trigger_on_scroll_offset_phone)) {
        $trigger_on_scroll_offset_phone = '';
    }
    $trigger_on_scroll_offset_units_phone = get_post_meta(
        $post->ID, 'trigger_autotrigger-offset_units_phone', true
    );
    if (empty($trigger_on_scroll_offset_units_phone)) {
        $trigger_on_scroll_offset_units_phone = '';
    }
?>
<div class="dipi_popup-sub">
    <label
        for="trigger_on_scroll-offset"
        class="dipi_popup-sub-lbl"
    >
        Scrolling offset
    </label>
    <div class="dipi_popup-sub-val-container" >
        <input class="dipi_popup-sub-val" 
            type="text"
            name="trigger_on_scroll-offset"
            size = 5
            value="<?php echo esc_attr($trigger_on_scroll_offset); ?>"
        />
        <p class="dipi_popup-sub-descr">Offset</p>
    </div>
    <div class="dipi_popup-sub-val-container raido" >
        <div class="dipi_popup-sub-val-radio-grp">
            <div class="dipi_popup-sub-val-radio-container">
                <input
                    type="radio"
                    name="trigger_autotrigger-offset_units"
                    value="px"
                    <?php if ( $trigger_on_scroll_offset_units == 'px' ) { ?> checked<?php } ?>
                >
                <label>px</label>      
            </div>
            <div class="dipi_popup-sub-val-radio-container">
                <input type="radio"
                    name="trigger_autotrigger-offset_units"
                    value="per"
                    <?php if ( $trigger_on_scroll_offset_units == 'per' ) { ?> checked<?php } ?>
                >
                <label>%</label>
            </div>
        </div>
        <p class="dipi_popup-sub-descr">Units</p>
    </div>
</div>
<div class="dipi_popup-sub">
    <label
        for="trigger_on_scroll-offset_tablet"
        class="dipi_popup-sub-lbl"
    >
        Tablet Scrolling offset
    </label>
    <div class="dipi_popup-sub-val-container" >
        <input class="dipi_popup-sub-val" 
            type="text"
            name="trigger_on_scroll-offset_tablet"
            size = 5
            value="<?php echo esc_attr($trigger_on_scroll_offset_tablet); ?>"
        />
        <p class="dipi_popup-sub-descr">Offset</p>
    </div>
    <div class="dipi_popup-sub-val-container raido" >
        <div class="dipi_popup-sub-val-radio-grp">
            <div class="dipi_popup-sub-val-radio-container">
                <input
                    type="radio"
                    name="trigger_autotrigger-offset_units_tablet"
                    value="px"
                    <?php if ( $trigger_on_scroll_offset_units_tablet == 'px' ) { ?> checked<?php } ?>
                >
                <label>px</label>      
            </div>
            <div class="dipi_popup-sub-val-radio-container">
                <input type="radio"
                    name="trigger_autotrigger-offset_units_tablet"
                    value="per"
                    <?php if ( $trigger_on_scroll_offset_units_tablet == 'per' ) { ?> checked<?php } ?>
                >
                <label>%</label>
            </div>
        </div>
        <p class="dipi_popup-sub-descr">Units</p>
    </div>
</div>
<div class="dipi_popup-sub">
    <label
        for="trigger_on_scroll-offset_phone"
        class="dipi_popup-sub-lbl"
    >
        Mobile Scrolling offset
    </label>
    <div class="dipi_popup-sub-val-container" >
        <input class="dipi_popup-sub-val" 
            type="text"
            name="trigger_on_scroll-offset_phone"
            size = 5
            value="<?php echo esc_attr($trigger_on_scroll_offset_phone); ?>"
        />
        <p class="dipi_popup-sub-descr">Offset</p>
    </div>
    <div class="dipi_popup-sub-val-container raido" >
        <div class="dipi_popup-sub-val-radio-grp">
            <div class="dipi_popup-sub-val-radio-container">
                <input
                    type="radio"
                    name="trigger_autotrigger-offset_units_phone"
                    value="px"
                    <?php if ( $trigger_on_scroll_offset_units_phone == 'px' ) { ?> checked<?php } ?>
                >
                <label>px</label>      
            </div>
            <div class="dipi_popup-sub-val-radio-container">
                <input type="radio"
                    name="trigger_autotrigger-offset_units_phone"
                    value="per"
                    <?php if ( $trigger_on_scroll_offset_units_phone == 'per' ) { ?> checked<?php } ?>
                >
                <label>%</label>
            </div>
        </div>
        <p class="dipi_popup-sub-descr">Units</p>
    </div>
</div>
<div></div> <!--Need to add this empty element to show bottom border-->

