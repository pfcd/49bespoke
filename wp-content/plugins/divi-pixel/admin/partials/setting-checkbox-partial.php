<?php
$off = isset($field["options"]["off"]) ? $field["options"]["off"] : esc_html__( 'Off', 'dipi-divi-pixel' );
$on = isset($field["options"]["on"]) ? $field["options"]["on"] : esc_html__( 'On', 'dipi-divi-pixel' );

$checked = isset($value) && ($value === true || $value === 'on' || $value === 'yes' || $value === 'true' || $value === 1) ? 'checked="checked"' : '';
$disabled = isset($field["coming_soon"]) ? 'disabled' : '';
 
?>
<?php $this->render_ribbon($field); ?>   
<div class="dipi_row">
    <div class="dipi_settings_option_description col-md-6">
        <div class="dipi_option_label">
            <?php echo esc_html($field["label"]); ?>
        </div>
        <?php if (isset($field["description"]) && '' !== $field["description"]) : ?>
        <div class="dipi_option_description">
            <?php echo wp_kses_post($field["description"]); ?>
        </div>        
        <?php endif; ?>
    </div>
    <div class="dipi_settings_option_field dipi_settings_option_field_checkbox col-md-6 dipi_switch <?php echo esc_attr($disabled); ?>">
        <input type='checkbox' 
                name='<?php echo esc_attr($id); ?>' 
                id='<?php echo esc_attr($id); ?>' 
                data-off-title='<?php echo esc_attr($off); ?>'
                data-on-title='<?php echo esc_attr($on); ?>' 
                <?php echo esc_attr($checked) ?>
                <?php echo esc_attr($disabled); ?>
        />
    </div> 
</div>