<?php
namespace DiviPixel;

$menu_btn_font_select = DIPI_Customizer::get_option('menu_btn_font_select');
$menu_btn_text_size = DIPI_Customizer::get_option('menu_btn_text_size');
$menu_btn_letter_spacing = DIPI_Customizer::get_option('menu_btn_letter_spacing');
$menu_btn_font_weight = DIPI_Customizer::get_option('menu_btn_font_weight');
$menu_btn_text_color = DIPI_Customizer::get_option('menu_btn_text_color');
$menu_btn_hover_text_color = DIPI_Customizer::get_option('menu_btn_hover_text_color');
$fixed_menu_btn_text_color = DIPI_Customizer::get_option('fixed_menu_btn_text_color');
$fixed_menu_btn_hover_text_color = DIPI_Customizer::get_option('fixed_menu_btn_hover_text_color');
$menu_btn_icon_size = DIPI_Customizer::get_option('menu_btn_icon_size');
$menu_btn_padding = DIPI_Customizer::get_option('menu_btn_padding');
$menu_btn_background = DIPI_Customizer::get_option('menu_btn_background');
$menu_btn_background_hover = DIPI_Customizer::get_option('menu_btn_background_hover');
$fixed_menu_btn_background = DIPI_Customizer::get_option('fixed_menu_btn_background');
$fixed_menu_btn_background_hover = DIPI_Customizer::get_option('fixed_menu_btn_background_hover');
$menu_btn_border_width = DIPI_Customizer::get_option('menu_btn_border_width');
$menu_btn_border_radius = DIPI_Customizer::get_option('menu_btn_border_radius');
$menu_btn_border_color = DIPI_Customizer::get_option('menu_btn_border_color');
$menu_btn_hover_border_color = DIPI_Customizer::get_option('menu_btn_hover_border_color');
$fixed_menu_btn_border_color = DIPI_Customizer::get_option('fixed_menu_btn_border_color');
$fixed_menu_btn_hover_border_color = DIPI_Customizer::get_option('fixed_menu_btn_hover_border_color');
$menu_btn_shadow = DIPI_Customizer::get_option('menu_btn_shadow');
$menu_btn_shadow_color = DIPI_Customizer::get_option('menu_btn_shadow_color');
$menu_btn_shadow_offset = DIPI_Customizer::get_option('menu_btn_shadow_offset');
$menu_btn_shadow_blur = DIPI_Customizer::get_option('menu_btn_shadow_blur');
$menu_btn_hover_shadow = DIPI_Customizer::get_option('menu_btn_hover_shadow');
$menu_btn_hover_shadow_color = DIPI_Customizer::get_option('menu_btn_hover_shadow_color');
$menu_btn_hover_shadow_offset = DIPI_Customizer::get_option('menu_btn_hover_shadow_offset');
$menu_btn_hover_shadow_blur = DIPI_Customizer::get_option('menu_btn_hover_shadow_blur');
$menu_btn_icon_display = DIPI_Customizer::get_option('menu_btn_icon_display');
$menu_btn_select_icon = DIPI_Customizer::get_option('menu_btn_select_icon');

// $mobile_menu_button = DIPI_Customizer::get_option('mobile_menu_button');
$mobile_button_font = DIPI_Customizer::get_option('mobile_button_font');
$mobile_menu_button_font_weight = DIPI_Customizer::get_option('mobile_menu_button_font_weight');
$mobile_button_font_size = DIPI_Customizer::get_option('mobile_button_font_size');
$mobile_button_letter_spacing = DIPI_Customizer::get_option('mobile_button_letter_spacing');
$mobile_menu_button_paddings = DIPI_Customizer::get_option('mobile_menu_button_paddings');
$mobile_menu_button_radius = DIPI_Customizer::get_option('mobile_menu_button_radius');
$mobile_menu_btn_border_width = DIPI_Customizer::get_option('mobile_menu_btn_border_width');
$mobile_menu_btn_border_color = DIPI_Customizer::get_option('mobile_menu_btn_border_color');
$mobile_menu_button_background = DIPI_Customizer::get_option('mobile_menu_button_background');
$mobile_menu_button_text = DIPI_Customizer::get_option('mobile_menu_button_text');
$mobile_menu_btn_shadow = DIPI_Customizer::get_option('mobile_menu_btn_shadow');
$mobile_menu_btn_shadow_color = DIPI_Customizer::get_option('mobile_menu_btn_shadow_color');
$mobile_menu_btn_shadow_offset = DIPI_Customizer::get_option('mobile_menu_btn_shadow_offset');
$mobile_menu_btn_shadow_blur = DIPI_Customizer::get_option('mobile_menu_btn_shadow_blur');

$breakpoint_mobile = DIPI_Settings::get_mobile_menu_breakpoint();

?>

<style type="text/css" id="cta-button-styles">


    header.et-l--header ul.et-menu {
        align-items: center !important;
    }
 
    .et-db #et-boc .et-l div[class^='et_pb_module et_pb_menu et_pb_menu_'].et_pb_menu ul li a.dipi-cta-button,
    .et-db #et-boc .et-l ul > li > a.dipi-cta-button,
    body #page-container .et-db #et-boc .et-l .et_pb_menu ul li a.dipi-cta-button,
    header.et-l--header ul > li > a.dipi-cta-button,
    header#main-header #et-top-navigation nav > ul > li > a.dipi-cta-button,
    #top-header #et-secondary-menu > ul > li > a.dipi-cta-button,
    nav > ul > li > a.dipi-cta-button {
        opacity: 1 !important;
        <?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($menu_btn_font_select)), 'html'); ?>
        <?php echo esc_html(DIPI_Customizer::print_font_style_option("menu_btn_font_style")); ?>
        font-weight: <?php echo esc_html($menu_btn_font_weight); ?>;
        font-size: <?php echo esc_html($menu_btn_text_size); ?>px;
        letter-spacing: <?php echo esc_html($menu_btn_letter_spacing); ?>px;
        color: <?php echo esc_html($menu_btn_text_color); ?> !important;
        background-color: <?php echo esc_html($menu_btn_background); ?>;
        <?php if(et_builder_tb_enabled()) : ?>
        padding-top: <?php echo esc_html($menu_btn_padding[0]); ?>px;
        padding-right: <?php echo esc_html($menu_btn_padding[1]); ?>px;
        padding-bottom: <?php echo esc_html($menu_btn_padding[2]); ?>px;
        padding-left: <?php echo esc_html($menu_btn_padding[3]); ?>px;
        <?php else : ?>
        padding-top: <?php echo esc_html($menu_btn_padding[0]); ?>px !important;
        padding-right: <?php echo esc_html($menu_btn_padding[1]); ?>px !important;
        padding-bottom: <?php echo esc_html($menu_btn_padding[2]); ?>px !important;
        padding-left: <?php echo esc_html($menu_btn_padding[3]); ?>px !important;
        <?php endif; ?>
        
        border-width: <?php echo esc_html($menu_btn_border_width); ?>px !important;
        border-color: <?php echo esc_html($menu_btn_border_color); ?>;
        border-radius: <?php echo esc_html($menu_btn_border_radius); ?>px  !important;
        border-style: solid !important;
            
        <?php if($menu_btn_shadow) : ?>
        box-shadow: 0 <?php echo esc_html($menu_btn_shadow_offset); ?>px <?php echo esc_html($menu_btn_shadow_blur); ?>px <?php echo esc_html($menu_btn_shadow_color); ?>;
        <?php endif; ?>
        transition: all .3s;
    }
    .et-db #et-boc .et-l div[class^='et_pb_module et_pb_menu et_pb_menu_'].et_pb_menu ul li a.dipi-cta-button,
    div[class^='et_pb_module et_pb_menu et_pb_menu_'].et_pb_menu ul li a.dipi-cta-button{
        color: <?php echo esc_html($menu_btn_text_color); ?> !important;
    }
    .et-db #et-boc .et-l div[class^='et_pb_module et_pb_menu et_pb_menu_'].et_pb_menu ul li a.dipi-cta-button span:before,
    .et-db #et-boc .et-l div[class^='et_pb_module et_pb_menu et_pb_menu_'].et_pb_menu ul li a.dipi-cta-button span:after,
    header.et-l--header .dipi-cta-button span:before,
    header.et-l--header .dipi-cta-button span:after,
    #top-header #et-secondary-menu .dipi-cta-button span:before,
    #top-header #et-secondary-menu .dipi-cta-button span:after,
    header#main-header .dipi-cta-button span:before,
    header#main-header .dipi-cta-button span:after {
        position: relative;
        text-shadow: 0 0;
        font-family: ETmodules !important;
        font-weight: 400;
        font-style: normal;
        font-variant: normal;
        line-height: 1;
        text-transform: none;
        speak: none;
    }


    .et-db #et-boc .et-l div[class^='et_pb_module et_pb_menu et_pb_menu_'].et_pb_menu ul li a.dipi-cta-button:hover,
    .et-db #et-boc .et-l ul > li > a.dipi-cta-button:hover,
    body #page-container .et-db #et-boc .et-l .et_pb_menu ul li a.dipi-cta-button:hover,
    ul li a.dipi-cta-button:hover,
    nav > ul > li > a.dipi-cta-button:hover,
    #top-header #et-secondary-menu > ul > li > a.dipi-cta-button:hover,
    header.et-l--header ul > li > a.dipi-cta-button:hover,
    header#main-header ul > li > a.dipi-cta-button:hover,
    header#main-header #et-top-navigation nav > ul > li > a.dipi-cta-button:hover
    {
        color: <?php echo esc_html($menu_btn_hover_text_color); ?> !important;
        background-color: <?php echo esc_html($menu_btn_background_hover); ?> !important;
        border-color: <?php echo esc_html($menu_btn_hover_border_color); ?> !important;
        padding-top: <?php echo esc_html($menu_btn_padding[0]); ?>px !important;
        padding-right: <?php echo esc_html($menu_btn_padding[1]); ?>px !important;
        padding-bottom: <?php echo esc_html($menu_btn_padding[2]); ?>px !important;
        padding-left: <?php echo esc_html($menu_btn_padding[3]); ?>px !important;
        <?php if($menu_btn_hover_shadow) : ?>
        box-shadow: 0 <?php echo esc_html($menu_btn_hover_shadow_offset); ?>px <?php echo esc_html($menu_btn_hover_shadow_blur); ?>px <?php echo esc_html($menu_btn_hover_shadow_color); ?>  !important;
        <?php endif; ?>
    }
    .et-db #et-boc .et-l div[class^='et_pb_module et_pb_menu et_pb_menu_'].et_pb_menu ul li a.dipi-cta-button span,
    #top-header #et-secondary-menu .dipi-cta-button span,
    header.et-l--header .dipi-cta-button span,
    header#main-header .dipi-cta-button span {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .et-db #et-boc .et-l div[class^='et_pb_module et_pb_menu et_pb_menu_'].et_pb_menu ul li a.dipi-cta-button span:before,
    header.et-l--header .et_pb_button.dipi-cta-button span:before,
    #top-header #et-secondary-menu .et_pb_button.dipi-cta-button span:before,
    header#main-header .et_pb_button.dipi-cta-button span:before {
        margin-right: 5px;
    }
    .et-db #et-boc .et-l div[class^='et_pb_module et_pb_menu et_pb_menu_'].et_pb_menu ul li a.dipi-cta-button span:after,
    header.et-l--header .et_pb_button.dipi-cta-button span:after,
    #top-header #et-secondary-menu .et_pb_button.dipi-cta-button span:after,
    header#main-header .et_pb_button.dipi-cta-button span:after {
        margin-left: 5px;
    }
    .et-db #et-boc .et-l div[class^='et_pb_module et_pb_menu et_pb_menu_'].et_pb_menu ul li a.dipi-cta-button.dipi-cta-button-icon-none span:after,
    .et-db #et-boc .et-l div[class^='et_pb_module et_pb_menu et_pb_menu_'].et_pb_menu ul li a.dipi-cta-button.dipi-cta-button-icon-none span:before,
    .et-db #et-boc .et-l div[class^='et_pb_module et_pb_menu et_pb_menu_'].et_pb_menu ul li a.dipi-cta-button:after,
    .et-db #et-boc .et-l div[class^='et_pb_module et_pb_menu et_pb_menu_'].et_pb_menu ul li a.dipi-cta-button.dipi-cta-button-icon-none span:after,
    .et-db #et-boc .et-l div[class^='et_pb_module et_pb_menu et_pb_menu_'].et_pb_menu ul li a.dipi-cta-button.dipi-cta-button-icon-none span:before,
    header.et-l--header .dipi-cta-button-menu-item .et_pb_button:after,
    header.et-l--header .dipi-cta-button-menu-item .et_pb_button:before,
    header.et-l--header .dipi-cta-button-icon-none span:after,
    header.et-l--header .dipi-cta-button-icon-none span:before,
    #top-header #et-secondary-menu .dipi-cta-button-menu-item .et_pb_button:after,
    #top-header #et-secondary-menu .dipi-cta-button-menu-item .et_pb_button:before,
    #top-header #et-secondary-menu .dipi-cta-button-icon-none span:after,
    #top-header #et-secondary-menu .dipi-cta-button-icon-none span:before,
    header#main-header .dipi-cta-button-menu-item .et_pb_button:after,
    header#main-header .dipi-cta-button-menu-item .et_pb_button:before,
    header#main-header .dipi-cta-button-icon-none span:after,
    header#main-header .dipi-cta-button-icon-none span:before {
        content: none !important;
    }

    .et-db #et-boc .et-l div[class^='et_pb_module et_pb_menu et_pb_menu_'].et_pb_menu ul li a.dipi-cta-button.dipi-cta-button-icon-left span:before,
    .et-db #et-boc .et-l div[class^='et_pb_module et_pb_menu et_pb_menu_'].et_pb_menu ul li a.dipi-cta-button.dipi-cta-button-icon-right span:after,
    header.et-l--header .et_pb_button.dipi-cta-button-icon-left span:before,
    header.et-l--header .et_pb_button.dipi-cta-button-icon-right span:after,
    #top-header #et-secondary-menu .et_pb_button.dipi-cta-button-icon-left span:before,
    #top-header #et-secondary-menu .et_pb_button.dipi-cta-button-icon-right span:after,
    header#main-header .et_pb_button.dipi-cta-button-icon-left span:before,
    header#main-header .et_pb_button.dipi-cta-button-icon-right span:after {
        content: "<?php echo esc_html(et_pb_process_font_icon($menu_btn_select_icon)); ?>";
        font-size: <?php echo esc_html($menu_btn_icon_size); ?>px;
    }

    header#main-header.et-fixed-header #et-top-navigation .dipi-cta-button {
        background-color: <?php echo esc_html($fixed_menu_btn_background); ?> !important;
        border-color: <?php echo esc_html($fixed_menu_btn_border_color); ?> !important;
        color: <?php echo esc_html($fixed_menu_btn_text_color); ?> !important;
    }

    header#main-header.et-fixed-header #et-top-navigation .dipi-cta-button:hover {
        background-color: <?php echo esc_html($fixed_menu_btn_background_hover); ?> !important;
        border-color: <?php echo esc_html($fixed_menu_btn_hover_border_color); ?> !important;
        color: <?php echo esc_html($fixed_menu_btn_hover_text_color); ?> !important;
    }

    /* Vertical Navigation CTA Button Style */
    .et_vertical_nav #main-header #et-top-navigation nav > ul > li > a.dipi-cta-button ,
    #top-header #et-secondary-menu > ul > li > a.dipi-cta-button,
    nav > ul > li > a.dipi-cta-button {
        margin-right: 0;
    }


</style>

<style type="text/css" id="mobile-cta-button-styles">
@media (max-width: <?php echo intval($breakpoint_mobile); ?>px) {
    .et-db #et-boc .et-l div[class^='et_pb_module et_pb_menu et_pb_menu_'].et_pb_menu ul li a.dipi-cta-button,
    div[class^='et_pb_module et_pb_menu et_pb_menu_'].et_pb_menu ul li a.dipi-cta-button,
    body.dipi-mobile-cta-button .dipi-cta-button,
    body.dipi-mobile-cta-button #main-header.et-fixed-header .dipi-cta-button {
        <?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($mobile_button_font)), 'html'); ?>
        <?php echo esc_html(DIPI_Customizer::print_font_style_option("mobile_button_font_style")); ?>
        font-weight: <?php echo esc_html($mobile_menu_button_font_weight); ?> !important;
        font-size: <?php echo esc_html($mobile_button_font_size); ?>px !important;
        letter-spacing: <?php echo esc_html($mobile_button_letter_spacing); ?>px !important;
        color: <?php echo esc_html($mobile_menu_button_text); ?> !important;
        background-color: <?php echo esc_html($mobile_menu_button_background); ?> !important;
        padding: <?php echo esc_html($mobile_menu_button_paddings); ?>px !important;
        border-style: solid;
        border-width: <?php echo esc_html($mobile_menu_btn_border_width); ?>px !important;
        border-color: <?php echo esc_html($mobile_menu_btn_border_color); ?> !important;
        border-radius: <?php echo esc_html($mobile_menu_button_radius); ?>px !important;
        transition: all .5s ease-in-out; 
        <?php if($mobile_menu_btn_shadow) : ?>
        box-shadow: 0 <?php echo esc_html($mobile_menu_btn_shadow_offset); ?>px <?php echo esc_html($mobile_menu_btn_shadow_blur); ?>px <?php echo esc_html($mobile_menu_btn_shadow_color); ?> !important;
        <?php endif; ?>
    }

    .dipi-hide-cta-button-mobile {
        display: none !important;
    }

}
</style>