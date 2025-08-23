<div class="dipi_settings_section">
    <div class="dipi_settings_section_title"><?php echo esc_html($section["label"]); ?></div>
    <?php 
    foreach ($settings->get_toggles() as $toggle_id => $toggle) :
        if ($toggle["tab"] !== $tab_id || $toggle["section"] !== $section_id) {
            continue;
        }
        include plugin_dir_path(dirname(__FILE__)) . 'partials/settings-toggle-partial.php';
    endforeach; 
    ?>
</div>