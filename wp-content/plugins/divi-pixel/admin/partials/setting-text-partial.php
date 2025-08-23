<?php 
$label = $field["label"];
$description = isset($field["description"]) && $field["description"] && '' !== $field["description"] ? $field["description"] : "";
$placeholder = isset($field["placeholder"]) && $field["placeholder"] ? esc_attr($field['placeholder']) : "";
$additional_class = isset($field["class"]) ? $field["class"] : "";
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
        <input type='text' name='<?php echo esc_attr($id); ?>' id='<?php echo esc_attr($id); ?>' value='<?php echo esc_attr($value); ?>' placeholder='<?php echo esc_attr($placeholder); ?>'/>
    </div> 
</div>