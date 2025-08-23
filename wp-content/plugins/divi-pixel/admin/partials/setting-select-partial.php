<?php
if(!isset($field["options"])){
    return;
}

if(isset($field["computed"]) && $field["computed"] === true ){
    $options = call_user_func($field["options"]);
} else {
    $options = $field["options"];
}

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
    <div class="dipi_settings_option_field dipi_settings_option_field_select col-md-6">
        <div class="dipi_select">
            <select type="select" name='<?php echo esc_attr($id); ?>' id='<?php echo esc_attr($id); ?>'>
            <?php foreach($options as $option_id => $option_title) : ?>
                <option value='<?php echo esc_attr($option_id); ?>' <?php selected( esc_attr($option_id), esc_attr($value) ); ?>>
                    <?php echo esc_html($option_title); ?>
                </option>
            <?php endforeach; ?>
            </select>
        </div>  
    </div> 
</div>