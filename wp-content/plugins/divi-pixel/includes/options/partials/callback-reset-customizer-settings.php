<?php
namespace DiviPixel;

$label = $field["label"];
$description = isset($field["description"]) && $field["description"] && '' !== $field["description"] ? $field["description"] : "";
$placeholder = isset($field["placeholder"]) && $field["placeholder"] ? esc_attr($field['placeholder']) : "";
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
        <button type='button' class="button dipi_reset_customizer_settings_button" name='<?php echo esc_attr($field_id); ?>' id='<?php echo esc_attr($field_id); ?>'>
            <?php echo esc_html__('Reset', 'dipi-divi-pixel'); ?>
        </button>
    </div>
</div>
