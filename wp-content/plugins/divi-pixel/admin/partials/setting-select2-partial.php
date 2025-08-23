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
        <div class="dipi_select2">
            <select multiple="multiple" name='<?php echo esc_attr($id); ?>[]' id='<?php echo esc_attr($id); ?>'>
        <?php
            foreach($options as $option_id => $option_title) : 
                $selected = is_array($value) && in_array($option_id, $value ) ? ' selected="selected" ' : '';
        ?>
                <option value='<?php echo esc_attr($option_id); ?>' <?php echo esc_attr($selected); ?>>
                    <?php echo esc_html($option_title); ?>
                </option>

            <?php endforeach; ?>
            </select>
        </div>  
    </div> 
</div>

<script type="text/javascript">
jQuery(function ($) {
    $(document).ready(function () {
        $('#<?php echo esc_attr($id); ?>').select2({
            placeholder: "-- Select Pages --",
            tags: true
        });
    });
});
</script>