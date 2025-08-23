<div
    id="tabs-trigger-settings"
    class="animated <?php echo esc_attr($dipi_pm_meta_tabs_anim); ?>"
>
    <?php
        $popup_post_id = get_the_ID();
        $pm_sub_setting_name_selected = get_post_meta(
            $popup_post_id, 'pm_sub_setting_triggering_settings', true
        );
        $pm_sub_setting_name = "pm_sub_setting_triggering_settings";
        $pm_sub_setting_options = array(
            'trigger_none'   => esc_html__( 'None', 'dipi-divi-pixel' ),
            'trigger_on_load'   => esc_html__( 'On Load', 'dipi-divi-pixel' ),
            'trigger_on_scroll'   => esc_html__( 'On Scroll', 'dipi-divi-pixel' ),
            'trigger_on_exit'   => esc_html__( 'On Exit', 'dipi-divi-pixel' ),
            'trigger_on_inactivity'   => esc_html__( 'On Inactivity', 'dipi-divi-pixel' ),
        );
    ?>
    <div class="dipi_popup-subs">
        <?php include_once( "trigger_general.php" ); ?>
        <div class="dipi_popup-sub">
            <label
                for=<?php echo esc_attr($pm_sub_setting_name) ?>
                class="dipi_popup-sub-lbl"
            >
                <?php esc_html_e( 'Trigger Event', 'dipi-divi-pixel' ); ?> 
            </label>
            <select
                id=<?php echo esc_attr($pm_sub_setting_name) ?>
                name=<?php echo esc_attr($pm_sub_setting_name) ?>
                class="popup-sub-sel dipi_popup-sub-val"
            >
                <?php
                foreach ( $pm_sub_setting_options as $pm_sub_setting_option_value => $pm_sub_setting_option_name ) {
                    printf( '<option value="%2$s"%3$s>%1$s</option>',
                        esc_html( $pm_sub_setting_option_name ),
                        esc_attr( $pm_sub_setting_option_value ),
                        selected(
                            $pm_sub_setting_option_value,
                            $pm_sub_setting_name_selected,
                            false
                        )
                    );
                } ?>
            </select>
        </div>
        <?php
        foreach ( $pm_sub_setting_options as $pm_sub_setting_option_value => $pm_sub_setting_option_name ) {
            printf( '<div id="%1$s" class="%2$s-tabs %1$s">',
                esc_attr($pm_sub_setting_option_value),
                esc_attr($pm_sub_setting_name)
            );
                include_once( "${pm_sub_setting_option_value}.php" );
            printf('</div>');
        } 
        include_once( "trigger_autotrigger.php" );
        include_once( "trigger_common.php" );
        ?>
    </div>
</div>
