<?php
namespace DiviPixel;

$label = $field["label"];
$description = $field["description"];
?>
<div class="dipi_row">
    <div class="dipi_settings_option_description col-md-6">
        <div class="dipi_option_label">
            <?php echo esc_html($label); ?>
        </div>
        <?php if ('' !== $description): ?>
            <div class="dipi_option_description">
                <?php echo wp_kses_post($description); ?>
            </div>
        <?php endif;?>
    </div>
    <div class="dipi_settings_option_field dipi_settings_option_field_button col-md-6">
        <button type='button' class="button dipi_export_button" name='<?php echo esc_attr($field_id); ?>' id='<?php echo esc_attr($field_id); ?>'>
            <div class="button_text">
                <?php echo esc_html__('Export', 'dipi-divi-pixel'); ?>
            </div>
            <div class="ball-pulse loading_indicator" style="opacity: 0; position: absolute; height: 19px;">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </button>
    </div>
</div>
