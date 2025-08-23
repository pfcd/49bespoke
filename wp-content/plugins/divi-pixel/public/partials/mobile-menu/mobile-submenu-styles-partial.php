<?php 
namespace DiviPixel;

$mobile_submenu_link_paddings = DIPI_Customizer::get_option('mobile_submenu_link_paddings'); 
$mobile_submenu_text_bottom_margin = DIPI_Customizer::get_option('mobile_submenu_text_bottom_margin'); 
$mobile_submenu_border_size = DIPI_Customizer::get_option('mobile_submenu_border_size'); 
$mobile_submenu_border_radii = DIPI_Customizer::get_option('mobile_submenu_border_radii'); 
$mobile_submenu_border_color = DIPI_Customizer::get_option('mobile_submenu_border_color'); 
$mobile_submenu_item_background = DIPI_Customizer::get_option('mobile_submenu_item_background'); 
$mobile_submenu_padding = DIPI_Customizer::get_option('mobile_submenu_padding'); 

//Sub menu
$mobile_submenu_text_align = DIPI_Customizer::get_option('mobile_submenu_text_align'); 
$mobile_submenu_font = DIPI_Customizer::get_option('mobile_submenu_font'); 
$mobile_submenu_font_style = DIPI_Customizer::get_option('mobile_submenu_font_style'); 
$mobile_submenu_font_weight = DIPI_Customizer::get_option('mobile_submenu_font_weight'); 
$mobile_submenu_text_size = DIPI_Customizer::get_option('mobile_submenu_text_size'); 
$mobile_submenu_letter_spacing = DIPI_Customizer::get_option('mobile_submenu_letter_spacing'); 
$mobile_submenu_text_color = DIPI_Customizer::get_option('mobile_submenu_text_color'); 








?>
<style id="mobile-submenu-styles-partial">
.et_mobile_menu li > .sub-menu > li {
    margin-bottom: <?php echo esc_html($mobile_submenu_text_bottom_margin) ?>px !important;
}
body.dipi-collapse-submenu-mobile .et-l--header .et_mobile_menu li .sub-menu,
.et_mobile_menu li > .sub-menu{
    padding-right: <?php echo esc_html($mobile_submenu_padding[1]) ?>px !important;
    padding-left: <?php echo esc_html($mobile_submenu_padding[3]) ?>px !important;
}
body.dipi-collapse-submenu-mobile .et-l--header .et_mobile_menu li .sub-menu:before,
.et_mobile_menu li > .sub-menu:before {
    content:'';
    display:block;
    height: <?php echo esc_html($mobile_submenu_padding[0]) ?>px !important;
}
body.dipi-collapse-submenu-mobile .et-l--header .et_mobile_menu li .sub-menu:after,
.et_mobile_menu li > .sub-menu:after {
    content:'';
    display:block;
    height: <?php echo esc_html($mobile_submenu_padding[2]) ?>px !important;
}
.et_mobile_menu li > .sub-menu > li > a {
    padding-top: <?php echo esc_html($mobile_submenu_link_paddings[0]) ?>px !important;
    padding-right: <?php echo esc_html($mobile_submenu_link_paddings[1]) ?>px !important;
    padding-bottom: <?php echo esc_html($mobile_submenu_link_paddings[2]) ?>px !important;
    padding-left: <?php echo esc_html($mobile_submenu_link_paddings[3]) ?>px !important;
    border-width:  <?php echo esc_html($mobile_submenu_border_size) ?>px !important;
    border-radius: <?php echo esc_html($mobile_submenu_border_radii[0]) ?>px <?php echo esc_html($mobile_submenu_border_radii[1]) ?>px <?php echo esc_html($mobile_submenu_border_radii[3]) ?>px <?php echo esc_html($mobile_submenu_border_radii[2]) ?>px !important;
    border-color: <?php echo esc_html($mobile_submenu_border_color) ?> !important;
    background-color: <?php echo esc_html($mobile_submenu_item_background) ?> !important;
    <?php echo esc_html(DIPI_Customizer::print_font_style_option("mobile_submenu_font_style")); ?>
    text-align: <?php echo esc_html($mobile_submenu_text_align) ?>;
    font-family: <?php echo esc_html($mobile_submenu_font) ?>;
    font-weight: <?php echo esc_html($mobile_submenu_font_weight) ?>;
    font-size: <?php echo esc_html($mobile_submenu_text_size) ?>px !important;
    letter-spacing: <?php echo esc_html($mobile_submenu_letter_spacing) ?>px !important;
    color: <?php echo esc_html($mobile_submenu_text_color) ?> !important;
}
</style>