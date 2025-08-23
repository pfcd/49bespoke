<?php 
$label = $field["label"];
$description = isset($field["description"]) && $field["description"] && '' !== $field["description"] ? $field["description"] : "";
$placeholder = isset($field["placeholder"]) && $field["placeholder"] ? esc_attr($field['placeholder']) : "";
$additional_class = isset($field["class"]) ? $field["class"] : "";
$value = empty($value) ? '' : constant("DIPI_PASSWORD_MASK");

$license_status = \DiviPixel\DIPI_Settings::get_option('license_status');
$license_limit = \DiviPixel\DIPI_Settings::get_option('license_limit');
$license_site_count = \DiviPixel\DIPI_Settings::get_option('license_site_count');
$license_limit = $license_limit == 0 ? esc_html__('∞', 'dipi-divi-pixel') : $license_limit;
?>
<?php $this->render_ribbon($field); ?>
<div class="dipi_row <?php echo esc_attr($additional_class); ?>">
    <div class="dipi_settings_option_description col-md-6">
        <div class="dipi_option_label">
            <?php echo esc_html($label); ?>
        </div>
        <?php if ('' !== $description) : ?>
        <div class="dipi_option_description">
            <?php echo wp_kses_post($description); ?>
        </div>        
        <?php endif; ?>
    </div>
    <div class="dipi_settings_option_field dipi_settings_option_field_text col-md-6">
        <input type='password' 
               name='<?php echo esc_attr($id); ?>' 
               id='<?php echo esc_attr($id); ?>' 
               value='<?php echo esc_attr($value); ?>' 
               placeholder='<?php echo esc_attr($placeholder); ?>'/>
        <div class="dipi_license_status_bar">

            <?php if(\DiviPixel\DIPI_Settings::is_usable_license()) : ?>
            
                <button type='button' class="button dipi_deactivate_license_button" >
                    <div class="button_text">
                        <?php echo esc_html__('Deactivate License', 'dipi-divi-pixel'); ?>
                    </div>
                    <div class="ball-pulse loading_indicator" style="opacity: 0; position: absolute; height: 19px;">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </button>

            <?php else: ?>

                <button type='button' class="button dipi_activate_license_button">
                    <div class="button_text">
                        <?php echo esc_html__('Activate License', 'dipi-divi-pixel'); ?>
                    </div>
                    <div class="ball-pulse loading_indicator" style="opacity: 0; position: absolute; height: 19px;">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </button>

            <?php endif; ?>

            <div class="dipi_license_status">
                <span class="dipi_license_status_indicator dipi_license_status_<?php echo esc_attr($license_status); ?>"></span>
                <?php if(\DiviPixel\DIPI_Settings::get_option('license_status') === 'valid') : ?>
                <?php echo esc_html($license_status); ?> - <span><?php echo esc_html($license_site_count); ?> / <?php echo esc_html($license_limit); ?></span>
                <?php else: ?>
                <?php echo esc_html($license_status); ?>
                <?php endif; ?>
            </div> 
        </div> 
    </div> 
</div>