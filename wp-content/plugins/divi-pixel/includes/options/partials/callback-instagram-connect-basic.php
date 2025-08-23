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
                <?php echo esc_html($description); ?>
            </div>
        <?php endif;?>
    </div>
    <div class="dipi_settings_option_field dipi_settings_option_field_button col-md-6">
        <a  id="dipi_connect_insta_account_basic" 
            href="#" 
            type='button' 
            class="button dipi_connect_insta_account" 
            data-nonce="<?php echo esc_attr(wp_create_nonce("dipi_connect_insta_account_basic")); ?>"
            data-action="dipi_connect_insta_account_basic"
        >
            <div class="button_text">
                <?php echo esc_html__('Connect Account', 'dipi-divi-pixel'); ?>
            </div>
        </a>
    </div>
</div>
