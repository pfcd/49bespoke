<?php
    $post_dipi_popup_bg_color = get_post_meta(
        $popup_post_id, 'post_dipi_popup_bg_color', true
    );
    $popup_anim_name = "popup_anim_name";
    $popup_anim_name_selected = get_post_meta(
        $popup_post_id, $popup_anim_name, true
    );
    $popup_anim_options = array( 
        'none'  => esc_html__('None', 'dipi-divi-pixel'),
        'fadeIn'  => esc_html__('Fade In', 'dipi-divi-pixel'),
        'fadeInLeftShort'  => esc_html__('FadeIn Left', 'dipi-divi-pixel'),
        'fadeInRightShort' => esc_html__('FadeIn Right', 'dipi-divi-pixel'),
        'fadeInUpShort'    => esc_html__('FadeIn Up', 'dipi-divi-pixel'),
        'fadeInDownShort'  => esc_html__('FadeIn Down', 'dipi-divi-pixel'),
        'zoomInShort'       => esc_html__('Grow', 'dipi-divi-pixel'),
        'bounceInShort' => esc_html__('BounceIn', 'dipi-divi-pixel'),
        'bounceInLeftShort' => esc_html__('BounceIn Left', 'dipi-divi-pixel'),
        'bounceInRightShort' => esc_html__('BounceIn Right', 'dipi-divi-pixel'),
        'bounceInUpShort' => esc_html__('BounceIn Up', 'dipi-divi-pixel'),
        'bounceInDownShort' => esc_html__('BounceIn Down', 'dipi-divi-pixel'),
        'flipInXShort' => esc_html__('FlipInX', 'dipi-divi-pixel'),
        'flipInYShort' => esc_html__('FlipInY', 'dipi-divi-pixel'),
        'jackInTheBoxShort' => esc_html__('JackInTheBox', 'dipi-divi-pixel'),
        'rotateInShort'  => esc_html__('RotateIn', 'dipi-divi-pixel'),
        'rotateInDownLeftShort' => esc_html__('RotateIn DownLeft', 'dipi-divi-pixel'),
        'rotateInUpLeftShort' => esc_html__('RotateIn UpLeft', 'dipi-divi-pixel'),
        'rotateInDownRightShort' => esc_html__('RotateIn DownRight', 'dipi-divi-pixel'),
        'rotateInUpRightShort' => esc_html__('RotateIn UpRight', 'dipi-divi-pixel'),
    );
    $popup_pos_location_name = "popup_pos_location_name";
    $popup_pos_location_name_selected =  get_post_meta(
        $popup_post_id, $popup_pos_location_name, true
    );
    $popup_pos_location_options = array( 
        'start_start'  => esc_html__('Top Left', 'dipi-divi-pixel'),
        'start_center'  => esc_html__('Top Center', 'dipi-divi-pixel'),
        'start_end'  => esc_html__('Top Right', 'dipi-divi-pixel'),
        'center_start'  => esc_html__('Center Left', 'dipi-divi-pixel'),
        'center_center'  => esc_html__('Center', 'dipi-divi-pixel'),
        'center_end'  => esc_html__('Center Right', 'dipi-divi-pixel'),
        'end_start'  => esc_html__('Bottom Left', 'dipi-divi-pixel'),
        'end_center'  => esc_html__('Bottom Center', 'dipi-divi-pixel'),
        'end_end'  => esc_html__('Bottom Right', 'dipi-divi-pixel'),
    );
    $dipi_popup_enable_blur =  get_post_meta(
        $popup_post_id, 'dipi_popup_enable_blur', true
    );
    if (empty($dipi_popup_enable_blur)) {
        $dipi_popup_enable_blur = 'true';
    }
    $dipi_custom_overlay_z_index = get_post_meta(
        $popup_post_id, 'dipi_custom_overlay_z_index', true 
    );
    $dipi_custom_show_close_btn_within_popup_phone = get_post_meta(
        $popup_post_id, 'dipi_custom_show_close_btn_within_popup_phone', true
    );
    $dipi_custom_show_close_btn_within_popup_tablet = get_post_meta(
        $popup_post_id, 'dipi_custom_show_close_btn_within_popup_tablet', true
    );
    $dipi_custom_show_close_btn_within_popup_desktop = get_post_meta(
        $popup_post_id, 'dipi_custom_show_close_btn_within_popup_desktop', true
    );
    if (empty($dipi_custom_show_close_btn_within_popup_phone)) {
        $dipi_custom_show_close_btn_within_popup_phone = 'on';
    }
    /*if (!isset($dipi_custom_overlay_z_index)) {
        $dipi_custom_overlay_z_index = "9999999";
    } */
    $dipi_custom_desktop_popup_width = get_post_meta(
        $popup_post_id, 'dipi_custom_desktop_popup_width', true
    );
    if (empty($dipi_custom_desktop_popup_width)) {
        if ($dipi_custom_show_close_btn_within_popup_desktop !== 'on') {
            $dipi_custom_desktop_popup_width = '90';
        }
    }
    $dipi_custom_desktop_popup_unit = get_post_meta(
        $popup_post_id, 'dipi_custom_desktop_popup_unit', true 
    );
    if (empty($dipi_custom_desktop_popup_unit)) {
        $dipi_custom_desktop_popup_unit = '%';
    }

    $dipi_custom_tablet_popup_width = get_post_meta(
        $popup_post_id, 'dipi_custom_tablet_popup_width', true
    );
    if (empty($dipi_custom_tablet_popup_width)) {
        if ($dipi_custom_show_close_btn_within_popup_tablet !== 'on') {
            $dipi_custom_tablet_popup_width = '90';
        }
    }
    $dipi_custom_tablet_popup_unit = get_post_meta(
        $popup_post_id, 'dipi_custom_tablet_popup_unit', true 
    );
    if (empty($dipi_custom_tablet_popup_unit)) {
        $dipi_custom_tablet_popup_unit = '%';
    }
    
    $dipi_custom_mobile_popup_width = get_post_meta(
        $popup_post_id, 'dipi_custom_mobile_popup_width', true
    );
    if (empty($dipi_custom_mobile_popup_width)) {
        if ($dipi_custom_show_close_btn_within_popup_phone !== 'on') {
            $dipi_custom_mobile_popup_width = '80'; 
        }
    }
    $dipi_custom_mobile_popup_unit = get_post_meta(
        $popup_post_id, 'dipi_custom_mobile_popup_unit', true 
    );
    if (empty($dipi_custom_mobile_popup_unit)) {
        $dipi_custom_mobile_popup_unit = '%';
    }
    $dipi_custom_min_popup_width = get_post_meta(
        $popup_post_id, 'dipi_custom_min_popup_width', true
    );
    if (empty($dipi_custom_min_popup_width)) {
        $dipi_custom_min_popup_width = '300';
    }
    $dipi_custom_min_popup_unit = get_post_meta(
        $popup_post_id, 'dipi_custom_min_popup_unit', true 
    );
    if (empty($dipi_custom_min_popup_unit)) {
        $dipi_custom_min_popup_unit = 'px';
    }

    $dipi_custom_hide_close_btn =  get_post_meta(
        $popup_post_id, 'dipi_custom_hide_close_btn', true
    );
    if (empty($dipi_custom_hide_close_btn)) {
        $dipi_custom_hide_close_btn = 'false';
    }


    
    $close_btn_bg_color = get_post_meta( $popup_post_id, 'close_btn_bg_color', true );    
    $close_btn_icon_color = get_post_meta( $popup_post_id, 'close_btn_icon_color', true );    
    $dipi_custom_close_btn_icon_size = get_post_meta(
        $popup_post_id, 'dipi_custom_close_btn_icon_size', true 
    );    
    $dipi_custom_close_btn_padding = get_post_meta(
        $popup_post_id, 'dipi_custom_close_btn_padding', true 
    );    
    $dipi_custom_close_btn_margin = get_post_meta(
        $popup_post_id, 'dipi_custom_close_btn_margin', true 
    );
    
    $dipi_custom_close_btn_border_radius =  get_post_meta(
        $popup_post_id, 'dipi_custom_close_btn_border_radius', true
    );    
?>
<div
    id="tabs-customization"
    class="animated <?php echo esc_attr($dipi_pm_meta_tabs_anim); ?>"
>
    <div class="dipi_popup-subs">
        <div class="dipi_popup-sub">
            <label for="post_dipi_popup_bg_color" class="dipi_popup-sub-lbl">
                Overlay Background Color
            </label>    
            <input
                class="cs-wp-color-picker"
                type="text"
                name="post_dipi_popup_bg_color"
                value="<?php echo esc_attr($post_dipi_popup_bg_color); ?>"
            />
        </div>
        <div class="dipi_popup-sub">
            <label
                for=<?php echo esc_attr($popup_anim_name) ?>
                class="dipi_popup-sub-lbl"
            >
                <?php esc_html_e( 'Popup Animation', 'dipi-divi-pixel' ); ?> 
            </label>
            <select
                id=<?php echo esc_attr($popup_anim_name) ?>
                name=<?php echo esc_attr($popup_anim_name) ?>
                class="popup-sub-sel dipi_popup-sub-val">
                <?php
                foreach ( $popup_anim_options as $popup_anim_option_value => $pm_sub_setting_option_name ) {
                    printf( '<option value="%2$s"%3$s>%1$s</option>',
                        esc_html( $pm_sub_setting_option_name ),
                        esc_attr( $popup_anim_option_value ),
                        selected(
                            $popup_anim_option_value,
                            $popup_anim_name_selected,
                            false
                        )
                    );
                } ?>
            </select>
        </div>
        <div class="dipi_popup-sub">
            <label
                for=<?php echo esc_attr($popup_pos_location_name) ?>
                class="dipi_popup-sub-lbl"
            >
                <?php esc_html_e( 'Popup Position', 'dipi-divi-pixel' ); ?> 
            </label>
            <div class="dipi-position-control">
            <?php
            foreach ( $popup_pos_location_options as $popup_pos_location_option_value => $popup_pos_location_option_name ) {
                    printf( 
                        '<label class="dipi-position-control-item" for="dipi-position-control-input-%3$s">
                            <input id="dipi-position-control-input-%3$s" name="%1$s" value="%3$s" %4$s type="radio" />
                            <span class="checkmark"></span>
                        </label>',
                        esc_html( $popup_pos_location_name ),
                        esc_html( $popup_pos_location_option_name ),
                        esc_attr( $popup_pos_location_option_value ),
                        checked(
                            $popup_pos_location_option_value,
                            $popup_pos_location_name_selected,
                            false
                        )
                    );
                } 
                ?>
                 
            </div>
        </div>
      
        
        <div class="dipi_popup-sub">
            <label for="dipi_popup_enable_blur" class="dipi_popup-sub-lbl">
                Enable Overlay Blur
            </label>
            <div class="dipi_popup-sub-val-container raido" >
                <!--div class="dipi_popup-sub-val-radio-grp">
                    <div class="dipi_popup-sub-val-radio-container">
                        <input
                            type="radio"
                            name="dipi_popup_enable_blur"
                            value="true"
                            <?php if ( $dipi_popup_enable_blur == 'true' ) { ?> checked<?php } ?>
                        >
                        <label>Yes</label>      
                    </div>
                    <div class="dipi_popup-sub-val-radio-container">
                        <input type="radio"
                            name="dipi_popup_enable_blur"
                            value="false"
                            <?php if ( $dipi_popup_enable_blur == 'false' ) { ?> checked<?php } ?>
                        >
                        <label>No</label>
                    </div>
                </div-->
                <div class="dipi-popup-toggle__button">
                <input
                    type="hidden"
                    name="dipi_popup_enable_blur"
                    value = "false"
                >
                <input
                    class="dipi-popup-toggle__switch"
                    type="checkbox"
                    name="dipi_popup_enable_blur"
                    value = "true"
                    <?php if ( $dipi_popup_enable_blur  === 'true') { ?> checked<?php } ?>
                >
                <div class="dipi-popup-toggle__slider"></div>
                <label class="for-checked">Yes</label>  
                <label class="for-unchecked">No</label>
            </div>
            </div>
        </div>
        <div class="dipi_popup-sub">
            <label
                for="dipi_custom_overlay_z_index"
                class="dipi_popup-sub-lbl"
            >
                Overlay Z Index
            </label>
            <div class="dipi_popup-sub-val-container" >
                <input class="dipi_popup-sub-val" 
                    type="text"
                    name="dipi_custom_overlay_z_index"
                    size = 10
                    style="padding-right: 3em;"
                    placeholder="9999999"
                    value="<?php echo esc_attr($dipi_custom_overlay_z_index); ?>"
                />
                <p class="dipi_popup-sub-descr">Integer</p>
            </div>
        </div>
        <div class="dipi_popup-sub">
            <label
                for="dipi_custom_desktop_popup_width"
                class="dipi_popup-sub-lbl"
            >
                Popup Desktop Width
            </label>
            <div class="dipi_popup-sub-val-container
                showhideblock
                dpm-show
                desktop_popup_unit
            " >
                <input class="dipi_popup-sub-val" 
                    type="text"
                    name="dipi_custom_desktop_popup_width"
                    size = 5
                    value="<?php echo esc_attr($dipi_custom_desktop_popup_width); ?>"
                />
                <p class="dipi_popup-sub-descr">Value</p>
            </div>
            <div class="dipi_popup-sub-val-container raido" >
                <div class="dipi_popup-sub-val-radio-grp"
                >
                    <div class="dipi_popup-sub-val-radio-container">
                        <input
                            type="radio"
                            name="dipi_custom_desktop_popup_unit"
                            value="px"
                            <?php if ( $dipi_custom_desktop_popup_unit == 'px' ) { ?> checked<?php } ?>
                        >
                        <label>px</label>      
                    </div>
                    <div class="dipi_popup-sub-val-radio-container">
                        <input type="radio"
                            name="dipi_custom_desktop_popup_unit"
                            value="%"
                            <?php if ( $dipi_custom_desktop_popup_unit == '%' ) { ?> checked<?php } ?>
                        >
                        <label>%</label>
                    </div>
                    <div class="dipi_popup-sub-val-radio-container">
                        <input type="radio"
                            name="dipi_custom_desktop_popup_unit"
                            value="none"
                            <?php if ( $dipi_custom_desktop_popup_unit == 'none' ) { ?> checked<?php } ?>
                            
                        >
                        <label>None</label>
                    </div>
                </div>
                <p class="dipi_popup-sub-descr">Units</p>
            </div>
        </div>
        <div class="dipi_popup-sub">
            <label
                for="dipi_custom_tablet_popup_width"
                class="dipi_popup-sub-lbl"
            >
                Popup Tablet Width
            </label>
            <div class="dipi_popup-sub-val-container
                tablet_popup_unit
            " >
                <input class="dipi_popup-sub-val" 
                    type="text"
                    name="dipi_custom_tablet_popup_width"
                    size = 5
                    value="<?php echo esc_attr($dipi_custom_tablet_popup_width); ?>"
                />
                <p class="dipi_popup-sub-descr">Value</p>
            </div>
            <div class="dipi_popup-sub-val-container raido" >
                <div class="dipi_popup-sub-val-radio-grp"
                >
                    <div class="dipi_popup-sub-val-radio-container">
                        <input
                            type="radio"
                            name="dipi_custom_tablet_popup_unit"
                            value="px"
                            <?php if ( $dipi_custom_tablet_popup_unit == 'px' ) { ?> checked<?php } ?>
                        >
                        <label>px</label>      
                    </div>
                    <div class="dipi_popup-sub-val-radio-container">
                        <input type="radio"
                            name="dipi_custom_tablet_popup_unit"
                            value="%"
                            <?php if ( $dipi_custom_tablet_popup_unit == '%' ) { ?> checked<?php } ?>
                        >
                        <label>%</label>
                    </div>
                    <div class="dipi_popup-sub-val-radio-container">
                        <input type="radio"
                            name="dipi_custom_tablet_popup_unit"
                            value="none"
                            <?php if ( $dipi_custom_tablet_popup_unit == 'none' ) { ?> checked<?php } ?>
                            
                        >
                        <label>None</label>
                    </div>
                </div>
                <p class="dipi_popup-sub-descr">Units</p>
            </div>
        </div>
        <div class="dipi_popup-sub">
            <label
                for="dipi_custom_mobile_popup_width"
                class="dipi_popup-sub-lbl"
            >
                Popup Mobile Width
            </label>
            <div class="dipi_popup-sub-val-container
                mobile_popup_unit
            " >
                <input class="dipi_popup-sub-val" 
                    type="text"
                    name="dipi_custom_mobile_popup_width"
                    size = 5
                    value="<?php echo esc_attr($dipi_custom_mobile_popup_width); ?>"
                />
                <p class="dipi_popup-sub-descr">Value</p>
            </div>
            <div class="dipi_popup-sub-val-container raido" >
                <div class="dipi_popup-sub-val-radio-grp"
                >
                    <div class="dipi_popup-sub-val-radio-container">
                        <input
                            type="radio"
                            name="dipi_custom_mobile_popup_unit"
                            value="px"
                            <?php if ( $dipi_custom_mobile_popup_unit == 'px' ) { ?> checked<?php } ?>
                        >
                        <label>px</label>      
                    </div>
                    <div class="dipi_popup-sub-val-radio-container">
                        <input type="radio"
                            name="dipi_custom_mobile_popup_unit"
                            value="%"
                            <?php if ( $dipi_custom_mobile_popup_unit == '%' ) { ?> checked<?php } ?>
                        >
                        <label>%</label>
                    </div>
                    <div class="dipi_popup-sub-val-radio-container">
                        <input type="radio"
                            name="dipi_custom_mobile_popup_unit"
                            value="none"
                            <?php if ( $dipi_custom_mobile_popup_unit == 'none' ) { ?> checked<?php } ?>
                            
                        >
                        <label>None</label>
                    </div>
                </div>
                <p class="dipi_popup-sub-descr">Units</p>
            </div>
        </div>
        <div class="dipi_popup-sub">
            <label
                for="dipi_custom_min_popup_width"
                class="dipi_popup-sub-lbl"
            >
                Popup Min Width
            </label>
            <div class="dipi_popup-sub-val-container
                showhideblock
                dpm-show
                min_popup_unit
            " >
                <input class="dipi_popup-sub-val" 
                    type="text"
                    name="dipi_custom_min_popup_width"
                    size = 5
                    value="<?php echo esc_attr($dipi_custom_min_popup_width); ?>"
                />
                <p class="dipi_popup-sub-descr">Value</p>
            </div>
            <div class="dipi_popup-sub-val-container raido" >
                <div class="dipi_popup-sub-val-radio-grp"
                >
                    <div class="dipi_popup-sub-val-radio-container">
                        <input
                            type="radio"
                            name="dipi_custom_min_popup_unit"
                            value="px"
                            <?php if ( $dipi_custom_min_popup_unit == 'px' ) { ?> checked<?php } ?>
                        >
                        <label>px</label>      
                    </div>
                    <div class="dipi_popup-sub-val-radio-container">
                        <input type="radio"
                            name="dipi_custom_min_popup_unit"
                            value="%"
                            <?php if ( $dipi_custom_min_popup_unit == '%' ) { ?> checked<?php } ?>
                        >
                        <label>%</label>
                    </div>
                    <div class="dipi_popup-sub-val-radio-container">
                        <input type="radio"
                            name="dipi_custom_min_popup_unit"
                            value="none"
                            <?php if ( $dipi_custom_min_popup_unit == 'none' ) { ?> checked<?php } ?>
                            
                        >
                        <label>None</label>
                    </div>
                </div>
                <p class="dipi_popup-sub-descr">Units</p>
            </div>
        </div>

        <div class="dipi_popup-sub">
            <label for="dipi_custom_hide_close_btn" class="dipi_popup-sub-lbl">
                Hide Close Button
            </label>
            <div class="dipi_popup-sub-val-container raido" >
                <!--div class="dipi_popup-sub-val-radio-grp">
                    <div class="dipi_popup-sub-val-radio-container">
                        <input
                            type="radio"
                            name="dipi_custom_hide_close_btn"
                            value="true"
                            <?php if ( $dipi_custom_hide_close_btn == 'true' ) { ?> checked<?php } ?>
                        >
                        <label>Yes</label>      
                    </div>
                    <div class="dipi_popup-sub-val-radio-container">
                        <input type="radio"
                            name="dipi_custom_hide_close_btn"
                            value="false"
                            <?php if ( $dipi_custom_hide_close_btn == 'false' ) { ?> checked<?php } ?>
                        >
                        <label>No</label>
                    </div>
                </div-->
                <div class="dipi-popup-toggle__button">
                    <input
                        type="hidden"
                        name="dipi_custom_hide_close_btn"
                        value = "false"
                    >
                    <input
                        class="dipi-popup-toggle__switch"
                        type="checkbox"
                        name="dipi_custom_hide_close_btn"
                        value = "true"
                        <?php if ( $dipi_custom_hide_close_btn  === 'true') { ?> checked<?php } ?>
                    >
                    <div class="dipi-popup-toggle__slider"></div>
                    <label class="for-checked">Yes</label>  
                    <label class="for-unchecked">No</label>
                </div>
            </div>
        </div>
        <div class="dipi_popup-sub">
            <label for="dipi_custom_show_close_btn_within_popup" class="dipi_popup-sub-lbl">
                Show Close Button within Popup
            </label>
            <!--div class="dipi_popup-sub-val-container raido" >
                <div class="dipi_popup-sub-val-radio-grp">
                    <div class="dipi_popup-sub-val-radio-container">
                        <input
                            type="radio"
                            name="dipi_custom_show_close_btn_within_popup"
                            value="true"
                            <?php if ( $dipi_custom_show_close_btn_within_popup == 'true' ) { ?> checked<?php } ?>
                        >
                        <label>Yes</label>      
                    </div>
                    <div class="dipi_popup-sub-val-radio-container">
                        <input type="radio"
                            name="dipi_custom_show_close_btn_within_popup"
                            value="false"
                            <?php if ( $dipi_custom_show_close_btn_within_popup == 'false' ) { ?> checked<?php } ?>
                        >
                        <label>No</label>
                    </div>
                </div>
                <div class="dipi-popup-toggle__button">
                    <input
                        type="hidden"
                        name="dipi_custom_show_close_btn_within_popup"
                        value = "false"
                    >
                    <input
                        class="dipi-popup-toggle__switch"
                        type="checkbox"
                        name="dipi_custom_show_close_btn_within_popup"
                        value = "true"
                        <?php if ( $dipi_custom_show_close_btn_within_popup  === 'true') { ?> checked<?php } ?>
                    >
                    <div class="dipi-popup-toggle__slider"></div>
                    <label class="for-checked">Yes</label>  
                    <label class="for-unchecked">No</label>
                </div>
            </div-->
            <div class="dipi_popup-sub-val-container checkbox" >
                <div class="dipi_popup-sub-val-radio-grp">
                    <div class="dipi_popup-sub-val-radio-container">
                        <input
                            type="hidden"
                            name="dipi_custom_show_close_btn_within_popup_phone"
                            value="false"
                        >
                        <input
                            type="checkbox"
                            name="dipi_custom_show_close_btn_within_popup_phone"
                            <?php if ( $dipi_custom_show_close_btn_within_popup_phone === 'on' ) { ?> checked<?php } ?>
                        >
                        <label><span class="dashicons dashicons-smartphone"></span></label>
                    </div>
                    <div class="dipi_popup-sub-val-radio-container">
                        <input
                            type="hidden"
                            name="dipi_custom_show_close_btn_within_popup_tablet"
                            value="false"
                        >
                        <input type="checkbox"
                            name="dipi_custom_show_close_btn_within_popup_tablet"
                            <?php if ( $dipi_custom_show_close_btn_within_popup_tablet === 'on' ) { ?> checked<?php } ?>
                        >
                        <label><span class="dashicons dashicons-tablet"></span></label>
                    </div>
                    <div class="dipi_popup-sub-val-radio-container">
                        <input
                            type="hidden"
                            name="dipi_custom_show_close_btn_within_popup_desktop"
                            value="false"
                        >
                        <input type="checkbox"
                            name="dipi_custom_show_close_btn_within_popup_desktop"
                            <?php if ( $dipi_custom_show_close_btn_within_popup_desktop === 'on' ) { ?> checked<?php } ?>
                        >
                        <label><span class="dashicons dashicons-desktop"></span></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="dipi_popup-sub">
            <label for="close_btn_bg_color" class="dipi_popup-sub-lbl">
                Close Button Background Color
            </label>    
            <input
                class="cs-wp-color-picker"
                type="text"
                name="close_btn_bg_color"
                value="<?php echo esc_attr($close_btn_bg_color); ?>"
            />
        </div>
        <div class="dipi_popup-sub">
            <label
                for="close_btn_icon_color"
                class="dipi_popup-sub-lbl"
            >
                Close Button Icon Color
            </label>    
            <input
                class="cs-wp-color-picker"
                type="text"
                name="close_btn_icon_color"
                value="<?php echo esc_attr($close_btn_icon_color); ?>"
            />
        </div>
        <div class="dipi_popup-sub">
            <label
                for="dipi_custom_close_btn_icon_size"
                class="dipi_popup-sub-lbl"
            >
                Close Button Icon Size
            </label>
            <div class="dipi_popup-sub-val-container" >
                <input class="dipi_popup-sub-val" 
                    type="text"
                    name="dipi_custom_close_btn_icon_size"
                    size = 5
                    style="padding-right: 3em;"
                    value="<?php echo esc_attr($dipi_custom_close_btn_icon_size); ?>"
                />
                <span class="dipi_popup-sub-suf">px</span>
                <p class="dipi_popup-sub-descr">Pixels</p>
            </div>
        </div>
        <div class="dipi_popup-sub">
            <label
                for="dipi_custom_close_btn_padding"
                class="dipi_popup-sub-lbl"
            >
                Close Button Padding
            </label>
            <div class="dipi_popup-sub-val-container" >
                <input class="dipi_popup-sub-val" 
                    type="text"
                    name="dipi_custom_close_btn_padding"
                    size = 5
                    style="padding-right: 3em;"
                    value="<?php echo esc_attr($dipi_custom_close_btn_padding); ?>"
                />
                <span class="dipi_popup-sub-suf">px</span>
                <p class="dipi_popup-sub-descr">Pixels</p>
            </div>
        </div>
        <div class="dipi_popup-sub">
            <label
                for="dipi_custom_close_btn_margin"
                class="dipi_popup-sub-lbl"
            >
                Close Button Margin
            </label>
            <div class="dipi_popup-sub-val-container" >
                <input class="dipi_popup-sub-val" 
                    type="text"
                    name="dipi_custom_close_btn_margin"
                    size = 5
                    style="padding-right: 3em;"
                    value="<?php echo esc_attr($dipi_custom_close_btn_margin); ?>"
                />
                <span class="dipi_popup-sub-suf">px</span>
                <p class="dipi_popup-sub-descr">Pixels</p>
            </div>
        </div>
        <div class="dipi_popup-sub">
            <label
                for="dipi_custom_close_btn_border_radius"
                class="dipi_popup-sub-lbl"
            >
                Close Button Border Radius
            </label>
            <div class="dipi_popup-sub-val-container" >
                <input class="dipi_popup-sub-val" 
                    type="text"
                    name="dipi_custom_close_btn_border_radius"
                    size = 5
                    style="padding-right: 3em;"
                    value="<?php echo esc_attr($dipi_custom_close_btn_border_radius); ?>"
                />
                <span class="dipi_popup-sub-suf">%</span>
                <p class="dipi_popup-sub-descr">Border Radius</p>
            </div>
        </div>
    </div>
</div>