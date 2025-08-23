<div class="dipi_settings_toggle dipi_container" data-toggle-id="<?php echo esc_attr($toggle_id); ?>">
<?php 
foreach ($settings->get_fields() as $field_id => $field) {
    if(!isset($field['type']) || $field['type'] === 'skip') {
        continue;
    }

    if ($field["tab"] !== $tab_id || $field["section"] !== $section_id || $field["toggle"] !== $toggle_id) {
        continue;
    }
    $settings_page->render_field($field_id, $field);
}
?>
</div><!-- .dipi_settings_toggle -->