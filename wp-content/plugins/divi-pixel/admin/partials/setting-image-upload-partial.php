<?php
$label = $field["label"];
$description = isset($field["description"]) && $field["description"] && '' !== $field["description"] ? $field["description"] : "";
$placeholder = isset($field["placeholder"]) && $field["placeholder"] ? esc_attr($field['placeholder']) : "";
$extension = isset($field["extension"]) && $field["extension"] ? esc_attr($field['extension']) : "";

?>
<?php $this->render_ribbon($field); ?>
<div class="dipi_row">
    <div class="dipi_settings_option_description col-md-6">
        <div class="dipi_option_label">
            <?php echo esc_html($label); ?>
        </div>
        <?php if ('' !== $description) : ?>
            <div class="dipi_option_description">
                <?php echo wp_kses_post ($description); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="dipi_settings_option_field dipi_settings_option_field_image_upload col-md-6">
        <div class="dipi_input_wrapper">
            <input type='text' name='<?php echo esc_attr($id); ?>' id='<?php echo esc_attr($id); ?>' value='<?php echo esc_attr($value); ?>' placeholder='<?php echo esc_attr($placeholder); ?>' />
            <button type="submit" class="dipi_upload_image_button button" <?php echo $extension? "data-extension='". esc_attr($extension)."'" : "" ?>><?php echo esc_html__('Upload', 'dipi-divi-pixel'); ?></button>
        </div>
    </div>
</div>