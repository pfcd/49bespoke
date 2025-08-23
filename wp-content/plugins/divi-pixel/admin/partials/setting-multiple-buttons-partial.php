<?php
if(!isset($field["options"])){
    return;
}
$options = $field["options"];
$additional_class = isset($field["class"]) ? $field["class"] : "";
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
    <div class="dipi_settings_option_field dipi_settings_option_field_multiple_buttons col-md-6 <?php echo esc_attr($additional_class); ?>">
        <?php foreach($options as $option_id => $option) : ?>
        <div class="dipi_radio_option">
            <input type='radio'
                    name='<?php echo esc_attr($id); ?>'
                    id='<?php echo esc_attr($id . "_" . $option_id); ?>'
                    value='<?php echo esc_attr($option_id); ?>'
                    <?php checked( $option_id, $value ); ?>
            />
            <label for='<?php echo esc_attr($id . "_" . $option_id); ?>'>
                <?php if(isset($option['icon'])) : ?>
                <span class="dipi_radio_option_icon <?php echo esc_attr($option["icon"]); ?>"></span>
                <?php endif; ?>
                <?php if(isset($option['title'])) : ?>
                <span class="dipi_radio_option_title"><?php echo esc_html($option["title"]); ?></span>
                <?php endif; ?>
                <?php if(isset($option['description'])) : ?>
                <span class="dipi_radio_option_description"><?php echo wp_kses_post($option["description"]); ?></span>
                <?php endif; ?>
                <?php if(isset($option['image'])) : ?>
                <img src="<?php echo  esc_url(plugin_dir_url(__FILE__) . '../assets/' . $option['image']); ?>" /> <!-- TODO: maybe use a wrapper for the image? -->
                <?php endif; ?>
                <?php if(isset($option['svg'])) : ?>
                <?php echo  wp_kses_post($option['svg']); ?>
                <?php endif; ?>
            </label>
        </div>
        <?php endforeach; ?> 
    </div> 
</div>