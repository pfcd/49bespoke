<?php
$additional_class = isset($field["class"]) ? $field["class"] : "";
$options = $field["options"];
?>

<?php $this->render_ribbon($field); ?>
<div class="dipi_row">
    <div class="dipi_settings_option_description col-md-12">
        <div class="dipi_option_label">
            <?php echo esc_html($field["label"]); ?>
        </div>
        <?php if (isset($field["description"]) && '' !== $field["description"]) : ?>
        <div class="dipi_option_description">
            <?php echo wp_kses_post($field["description"]); ?>
        </div>        
        <?php endif; ?>
        <div class="dipi_settings_option_field dipi_settings_option_field_menu_styles dipi_settings_option_field_multiple_buttons <?php echo esc_attr($additional_class); ?>">
            <?php foreach($options as $option_id => $option_title) : ?>
            <div class="dipi_radio_option">
                <input type='radio'
                        name='<?php echo esc_attr($id); ?>'
                        id='<?php echo esc_attr($id . "_" . $option_id); ?>'
                        value='<?php echo esc_attr($option_id); ?>'
                        <?php checked( $option_id, $value ); ?>
                />
                <label for='<?php echo esc_attr($id . "_" . $option_id); ?>'>
                    <div class="dipi_menu_style <?php echo esc_attr($option_id); ?>">
                        <span><?php echo esc_html($option_title); ?></span>
                    </div>
                </label>
            </div>
            <?php endforeach; ?> 
        </div> 
    </div>
</div>