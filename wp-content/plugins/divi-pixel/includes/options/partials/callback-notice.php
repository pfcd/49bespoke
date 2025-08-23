<?php
namespace DiviPixel;

 
$description = $field["description"];
?>
<div class="dipi_row">
    <div class="dipi_settings_option_description col-md-12">
        <?php if ('' !== $description): ?>
            <div class="dipi_option_description">
                <?php echo wp_kses_post($description); ?>
            </div>
        <?php endif;?>
    </div>
     
</div>
