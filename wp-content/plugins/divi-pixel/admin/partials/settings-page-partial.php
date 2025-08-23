<?php 
namespace DiviPixel;
$settings = DIPI_Settings::instance(); 
?>
<form method="post" action="options.php" id="dipi_settings_form">
    <?php settings_errors() ?> <!-- FIXME: Show our errors in a different way -->
    <?php settings_fields("divi_pixel_options"); ?>
    <div id="dipi_settings" class="dipi_container">
        <?php include plugin_dir_path(dirname(__FILE__)) . 'partials/settings-page-header-partial.php';?>
        <div class="dipi_row">
            <div class="col-md-3">
                <div class="dipi_settings_sidebar" data-sticky-container>
                    <div class="dipi_sidebar_tabs">
                        <?php foreach ($settings->get_tabs() as $tab_id => $setting_tab) : ?>
                            <div class="dipi_settings_tab_control" data-tab="<?php echo esc_attr($tab_id); ?>">
                                <span class="tab_icon <?php echo esc_attr($setting_tab["icon_class"]); ?>"></span>
                                <span class="label"><?php echo esc_attr($setting_tab["label"]); ?></span>
                            </div>
                        <?php endforeach; ?>
                        <div class="dipi_settings_submit">
                            <div class="submit">
                                <button class="dipi_submit_button">
                                    <div class="save-text"><?php echo esc_html__('Save Changes', 'dipi-divi-pixel'); ?></div>
                                    <div class="save-text save-text-mobile"><?php echo esc_html__('Save', 'dipi-divi-pixel'); ?></div>
                                    <!-- <div class="saved-text" style="opacity: 0; position: absolute;"><?php echo esc_html__('Changes Saved', 'dipi-divi-pixel'); ?></div>                                     -->
                                    <div class="ball-pulse loading-indicator" style="opacity: 0; position: absolute; height: 19px;">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div><!-- .dipi_sidebar_tabs -->
                </div><!-- .dipi_settings_tabs -->
            </div>
            <div class="col-md-9">
                <div class="dipi_settings_content">
                    <?php 
                    foreach ($settings->get_tabs() as $tab_id => $setting_tab) {
                        include plugin_dir_path(dirname(__FILE__)) . 'partials/settings-tab-partial.php';
                    }
                    ?>
                </div><!-- .dipi_settings_content -->
            </div>
        </div>
    </div>
</form>