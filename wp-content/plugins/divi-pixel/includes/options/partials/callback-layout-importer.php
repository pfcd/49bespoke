<?php
namespace DiviPixel;

$label = $field["label"];
$description = $field["description"];
?>
<div class="dipi_row">
    <div class="dipi_settings_option_description col-md-6">
        <div class="dipi_option_label">
            <?php echo esc_html($label); ?>
        </div>
        <?php if ('' !== $description): ?>
            <div class="dipi_option_description">
            <?php echo wp_kses_post($description); ?>
            </div>
        <?php endif;?>
    </div>
    <div class="dipi_settings_option_field dipi_settings_option_field_button col-md-6">
    
                        
                    
        <?php if(!file_exists(WP_PLUGIN_DIR  . '/divi-pixel-layout-importer/dipi-layout-importer.php') ) { ?>
            <button style="display:inline-block" type='button' id="dipi_install_layout_importer" class="button " name='<?php echo esc_attr($field_id); ?>' id='<?php echo esc_attr($field_id); ?>'>
                <div class="button_text"><?php echo esc_html__('Install Importer', 'dipi-divi-pixel'); ?></div>
            </button>
            
        <?php } ?>
        <?php if(file_exists(WP_PLUGIN_DIR  . '/divi-pixel-layout-importer/dipi-layout-importer.php') && !is_plugin_active('divi-pixel-layout-importer/dipi-layout-importer.php')) { ?>
            <button style="display:inline-block" type='button' id="dipi_install_layout_importer" class="button " name='<?php echo esc_attr($field_id); ?>' id='<?php echo esc_attr($field_id); ?>'>
                <div class="button_text"><?php echo esc_html__('Activate Importer', 'dipi-divi-pixel'); ?></div>
            </button>
            
        <?php } ?>
        
        <?php if(file_exists(WP_PLUGIN_DIR  . '/divi-pixel-layout-importer/dipi-layout-importer.php')) { ?>
            <button style="display:inline-block" type='button' id="dipi_uninstall_layout_importer" class="button " name='<?php echo esc_attr($field_id); ?>' id='<?php echo esc_attr($field_id); ?>'>
                <div class="button_text"><?php echo esc_html__('Delete Importer', 'dipi-divi-pixel'); ?></div>
            </button>
        <?php } ?>
    </div>
</div> 