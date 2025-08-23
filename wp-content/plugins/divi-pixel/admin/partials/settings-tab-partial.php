<div id="<?php echo esc_attr($tab_id); ?>" class="hidden dipi_settings_tab" 
     data-tab="<?php echo esc_attr($tab_id); ?>" style="display: none;">
<?php 
foreach ($settings->get_sections() as $section_id => $section) :
    if ($section["tab"] !== $tab_id) {
        continue;
    }
    include plugin_dir_path(dirname(__FILE__)) . 'partials/settings-section-partial.php';
endforeach; 
?>
</div>