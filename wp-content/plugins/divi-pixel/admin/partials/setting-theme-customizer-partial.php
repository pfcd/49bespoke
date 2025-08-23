<?php
$label = $field["label"];
$description = isset($field["description"]) && $field["description"] && '' !== $field["description"] ? $field["description"] : "";
$icon = isset($field['icon']) && $field['icon'] ? $field['icon'] : 'dp-back-to-top';

$query_args = [];

if (isset($field['customizer_panel'])) {
    $query_args['autofocus[panel]'] = "dipi_{$field['customizer_panel']}";
} else if (isset($field['customizer_section'])) {
    $query_args['autofocus[section]'] = "dipi_customizer_section_{$field['customizer_section']}";
}

if (isset($field['target_url'])) {
    $query_args['url'] = esc_url($field['target_url']);
}

$theme_customizer_url = add_query_arg($query_args, admin_url('customize.php'));
?>
<div class="dipi_settings_option_field_theme_customizer <?php echo isset($field["class"]) ? esc_attr($field["class"]) : ""; ?>">
    <span class="theme_customizer_icon <?php echo esc_attr($icon); ?>"></span>
    <div class="dipi_settings_option_description">
        <?php $this->render_ribbon($field); ?>
        <div class="dipi_option_label">
            <?php echo esc_html($label); ?>
        </div>
        <?php if ('' !== $description): ?>
            <div class="dipi_option_description">
                <?php echo wp_kses_post($description); ?>
            </div>
        <?php endif;?>
    </div>
    <div class="dipi_option_theme_customizer_button_wrapper">
        <a class="dipi_option_theme_customizer_button" href="<?php echo esc_url($theme_customizer_url); ?>" target="_blank">
            <span class="theme_customizer_url"><?php echo esc_html__('Theme Customizer', 'dipi-divi-pixel'); ?></span>&nbsp;
            <span class="button_icon dp-settings"></span>
        </a>
    </div>
</div>