<div class="dipi_row">
     
    <div class="dipi_settings_option_description col-md-6">
        <div style="padding-top:17px;" class="dipi_option_label"><?php echo esc_html__('VIP Access', 'dipi-divi-pixel') ?> </div>
        <div class="dipi_option_description">
            <?php echo wp_kses_post($field['description']); ?>
        </div>
    </div>
    <div class="dipi_settings_option_field dipi_settings_option_field_select col-md-6">
        <div style="display:flex" class="field-container">
            <div style="align-self: center;color:#acb0b6;font-size:9px; margin-left: -10px; margin-top: 2px; margin-right: 2px;"><?php echo esc_url(get_home_url()); ?>/</div>
            <input type="text" class="inner-field" name="<?php echo esc_attr($id) ?>" id ="<?php echo esc_attr($id) ?>" value="<?php echo esc_attr($value) ?>" />
        </div>
        <div style="display:flex;margin-top:10px;">
            <button style="padding:4px 20px;text-transform:none;" type="button" class="button" name="" id="dipi_coming_soon_vip_gen"><?php echo esc_html('Generate Link' , 'dipi-divi-pixel') ?></button>
            <span style=" text-align:center;margin-left:10px;padding:4px 20px;text-transform:none;" data-siteurl="<?php echo esc_url(get_home_url() . '/'); ?>" class="button" name="" id="dipi_coming_soon_vip_copy"><?php echo esc_html('Copy URL' , 'dipi-divi-pixel') ?></span>
        </div>
    </div> 
</div>