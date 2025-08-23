<?php
    $trigger_autotrigger_options = "trigger_on_load trigger_on_scroll trigger_on_exit trigger_on_inactivity";
    $trigger_autotrigger_responsive_disable_phone = get_post_meta(
        $post->ID, 'trigger-auto-resp_disable_phone', true
    );
    $trigger_autotrigger_responsive_disable_tablet = get_post_meta(
        $post->ID, 'trigger-auto-resp_disable_tablet', true
    );
    $trigger_autotrigger_responsive_disable_desktop = get_post_meta(
        $post->ID, 'trigger-auto-resp_disable_desktop', true
    );
    $trigger_autotrigger_periodicity = get_post_meta(
        $post->ID, 'trigger_autotrigger-periodicity', true
    );
    if (empty($trigger_autotrigger_periodicity)) {
        $trigger_autotrigger_periodicity = 'every_time';
    }
    $trigger_autotrigger_periodicity_hours = get_post_meta(
        $post->ID, 'trigger_autotrigger-periodicity-hours', true
    );
    if (empty($trigger_autotrigger_periodicity_hours)) {
        $trigger_autotrigger_periodicity_hours = '24';
    }
    $trigger_autotrigger_activity = get_post_meta(
        $post->ID, 'trigger_autotrigger-activity', true
    );
    if (empty($trigger_autotrigger_activity)) {
        $trigger_autotrigger_activity = 'always';
    }
    $trigger_autotrigger_activity_certain_period_from = get_post_meta(
        $post->ID, 'trigger_auto-activ-certain_period-from', true
    );
    $trigger_autotrigger_activity_certain_period_to = get_post_meta(
        $post->ID, 'trigger_auto-activ-certain_period-to', true
    );
    $dipi_timezone_string = get_option( 'timezone_string' );
    if ( !$dipi_timezone_string ) {
        $dipi_timezone_string = get_option('gmt_offset');
    }
?>
<?php printf( '<div id="%1$s" class="%2$s-tabs %3$s">',
                "trigger_autotrigger_settings",
                esc_attr($pm_sub_setting_name),
                esc_attr($trigger_autotrigger_options)
            );
?>    
    <div class="dipi_popup-sub">
        <label
            for="trigger_autotrigger-periodicity"
            class="dipi_popup-sub-lbl"
        >
            Periodicity
        </label>
        <div class="dipi_popup-sub-val-container raido" >
            <div
                class="dipi_popup-sub-val-radio-grp"
                data-radioshowhideblock="1"
            >
                <div class="dipi_popup-sub-val-radio-container">
                    <input
                        type="radio"
                        name="trigger_autotrigger-periodicity"
                        value="every_time"
                        <?php if ( $trigger_autotrigger_periodicity == 'every_time' ) { ?> checked<?php } ?>
                        data-showhideblock=".periodicity-every_time"
                    >
                    <label>Every Time</label>      
                </div>
                <div class="dipi_popup-sub-val-radio-container">
                    <input type="radio"
                        name="trigger_autotrigger-periodicity"
                        value="once_per_period"
                        <?php if ( $trigger_autotrigger_periodicity == 'once_per_period' ) { ?> checked<?php } ?>
                        data-showhideblock=".periodicity-once_per_period"
                    >
                    <label>Once per period</label>
                </div>
                <div class="dipi_popup-sub-val-radio-container">
                    <input type="radio"
                        name="trigger_autotrigger-periodicity"
                        value="once_only"
                        <?php if ( $trigger_autotrigger_periodicity == 'once_only' ) { ?> checked<?php } ?>                    
                        data-showhideblock=".periodicity-once_only"
                    >
                    <label>Once only</label>     
                </div>
            </div>
            <p class="dipi_popup-sub-descr">Periodicity mode</p>
        </div>
        <div
            class="dipi_popup-sub-val-container
                showhideblock
                periodicity-once_per_period
                <?php if ( $trigger_autotrigger_periodicity == "once_per_period" ) { ?> dpm-show<?php } ?>" 
            >
            <input class="dipi_popup-sub-val" 
                type="text"
                name="trigger_autotrigger-periodicity-hours"
                style="padding-right: 3em;"
                size = 3
                value="<?php echo esc_attr($trigger_autotrigger_periodicity_hours); ?>"
            />
            <span class="dipi_popup-sub-suf" style="margin-left: -3em;">hrs</span>
        </div>
    </div>        
    <div class="dipi_popup-sub">
        <label for="trigger_autotrigger-activity" class="dipi_popup-sub-lbl">
            Activity
        </label>
        <div class="dipi_popup-sub-val-container raido" >
            <div
                class="dipi_popup-sub-val-radio-grp"
                data-radioshowhideblock="1"
            >
                <div class="dipi_popup-sub-val-radio-container">
                    <input
                        type="radio"
                        name="trigger_autotrigger-activity"
                        value="always"
                        <?php if ( $trigger_autotrigger_activity == 'always' ) { ?> checked<?php } ?>
                        data-showhideblock=".activity-always"
                    >
                    <label>Always</label>      
                </div>
                <div class="dipi_popup-sub-val-radio-container">
                    <input type="radio"
                        name="trigger_autotrigger-activity"
                        value="certain_period"
                        <?php if ( $trigger_autotrigger_activity == 'certain_period' ) { ?> checked<?php } ?>
                        data-showhideblock=".activity-certain_period"
                    >
                    <label>Certain period</label>
                </div>
            </div>
            <p class="dipi_popup-sub-descr">Activity</p>
        </div>
        <div
            class="dipi_popup-sub-val-container
                showhideblock
                activity-certain_period
                <?php if ( $trigger_autotrigger_activity == "certain_period" ) { ?> dpm-show<?php } ?>"
             >
            <span class="dipi_popup-sub-suf dashicons dashicons-calendar-alt"></span>    
            <input
                type="text" 
                class="dipi_popup-sub-val dipi-datetime-input"
                data-timezone="<?php echo esc_attr($dipi_timezone_string);?>"
                name="trigger_auto-activ-certain_period-from"
                value="<?php echo esc_attr($trigger_autotrigger_activity_certain_period_from); ?>"
            />
            <p class="dipi_popup-sub-descr">From</p>
        </div>
        <div
            class="dipi_popup-sub-val-container
                showhideblock
                activity-certain_period<?php if ( $trigger_autotrigger_activity == "certain_period" ) { ?> dpm-show<?php } ?>"
            >
            <span class="dipi_popup-sub-suf dashicons dashicons-calendar-alt"></span>    
            <input
                type="text" 
                class="dipi_popup-sub-val dipi-datetime-input"
                data-timezone="<?php echo esc_attr($dipi_timezone_string);?>"
                name="trigger_auto-activ-certain_period-to"
                value="<?php echo esc_attr($trigger_autotrigger_activity_certain_period_to); ?>"
            />
            <p class="dipi_popup-sub-descr">To</p>
        </div>
    </div>
    <div class="dipi_popup-sub">
        <label class="dipi_popup-sub-lbl">
            Disable On
        </label>
        <div class="dipi_popup-sub-val-container checkbox" >
            <div class="dipi_popup-sub-val-radio-grp">
                <div class="dipi_popup-sub-val-radio-container">
                    <input
                        type="checkbox"
                        name="trigger-auto-resp_disable_phone"
                        <?php if ( $trigger_autotrigger_responsive_disable_phone == 'on' ) { ?> checked<?php } ?>
                    >
                    <label><span class="dashicons dashicons-smartphone"></span></label>
                </div>
                <div class="dipi_popup-sub-val-radio-container">
                    <input type="checkbox"
                        name="trigger-auto-resp_disable_tablet"
                        <?php if ( $trigger_autotrigger_responsive_disable_tablet == 'on' ) { ?> checked<?php } ?>
                    >
                    <label><span class="dashicons dashicons-tablet"></span></label>
                </div>
                <div class="dipi_popup-sub-val-radio-container">
                    <input type="checkbox"
                        name="trigger-auto-resp_disable_desktop"
                        <?php if ( $trigger_autotrigger_responsive_disable_desktop == 'on' ) { ?> checked<?php } ?>
                    >
                    <label><span class="dashicons dashicons-desktop"></span></label>
                </div>
            </div>
        </div>
    </div>
    <div></div> <!--Need to add this empty element to show bottom border-->
</div>