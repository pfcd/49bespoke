<?php 
$label = $field["label"];
$description = isset($field["description"]) ? $field["description"] : '';
$library_layouts = ['-1' => ['title' => esc_html__('-- Select a Layout --', 'dipi-divi-pixel')]];
$library_layouts += $this->get_library_layouts();
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
    <div class="dipi_settings_option_field dipi_settings_option_field_select dipi_settings_option_field_library_layout col-md-6">
        <div class="dipi_select">
            <select name='<?php echo esc_attr($id); ?>' id='<?php echo esc_attr($id); ?>'>
            <?php foreach($library_layouts as $layout_id => $library_layout) : ?>
                <option value='<?php echo esc_attr($layout_id); ?>' <?php selected( $layout_id, $value ); ?>>
                    <?php echo esc_html($library_layout['title']); ?>
                </option>
            <?php endforeach; ?>
            </select>
        </div> 
    </div> 
</div>