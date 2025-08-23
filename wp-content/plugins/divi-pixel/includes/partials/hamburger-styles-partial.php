<?php 
namespace DiviPixel;
$style = DIPI_Settings::get_option('hamburger_animation_styles'); 
?>

<div class="dipi_hamburger hamburger <?php echo esc_attr($style); ?>" style="display:none; float: right; margin-bottom: 24px; line-height: 1em;">
    <div class="hamburger-box">
        <div class="hamburger-inner"></div>
    </div>
</div>