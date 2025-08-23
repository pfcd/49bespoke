<?php
namespace DiviPixel;

$style = DIPI_Settings::get_option('hamburger_animation_styles');
$breakpoint_mobile = DIPI_Settings::get_mobile_menu_breakpoint();

?>
<style id="global-hamburger-styles-css">

.mobile_nav .select_page {
    display: none !important;
}
.et-db #et-boc .et-l.et-l--header .mobile_menu_bar:before,
.et-l--header .mobile_menu_bar:before{
    content: unset;
}

.et_header_style_centered #main-header .mobile_nav.mobile_nav,
.et_header_style_split #main-header .mobile_nav.mobile_nav {
    padding: 0;
    border-radius: 0;
    background-color: unset;
    background: unset;
}
.et_header_style_centered #et_mobile_nav_menu#et_mobile_nav_menu,
.et_header_style_split #et_mobile_nav_menu#et_mobile_nav_menu {
    position: unset;
}

.et_header_style_centered.et_header_style_centered .mobile_menu_bar.mobile_menu_bar,
.et_header_style_split.et_header_style_split .mobile_menu_bar.mobile_menu_bar {
    position: relative;
}


.et_header_style_centered .et_mobile_menu.et_mobile_menu,
.et_header_style_split .et_mobile_menu.et_mobile_menu {
    top: 62px;
}

.et_header_style_left .et_mobile_menu.et_mobile_menu {
    top: 90px;
}

.et_header_style_centered .et_menu_container .mobile_menu_bar.mobile_menu_bar,
.et_header_style_split .et_menu_container .mobile_menu_bar.mobile_menu_bar,
.et_header_style_split .et_menu_container #et-top-navigation .mobile_menu_bar.mobile_menu_bar {
    top: unset;
    left: unset;
    right: unset;
    bottom: unset;
    padding: 0;
    float:right;
}

.et_header_style_split #main-header div#et-top-navigation {
    bottom: 0;
}
    
#main-header .mobile_menu_bar:before{
    content: unset;
}


@media all and (max-width: <?php echo esc_attr($breakpoint_mobile); ?>px) {
    .et_header_style_centered #main-header#main-header div#et-top-navigation,
    .et_header_style_split #main-header#main-header div#et-top-navigation {
        position: absolute;
    }

    .et_header_style_fullscreen .dipi_hamburger,
    .et_header_style_centered .dipi_hamburger,
    .et_header_style_split .dipi_hamburger {
        margin-bottom: 0 !important;
    }

    .et_header_style_centered .dipi_hamburger {
        margin-top: 6px;
    }

    .et_header_style_fullscreen .et-fixed-header #et-top-navigation, .et_header_style_fullscreen #et-top-navigation {
        padding-bottom: 0 !important;
    }
}

/* FIXME: only if style is not fullscreen oder slidein */
@media all and (min-width: <?php echo esc_attr($breakpoint_mobile + 1) ; ?>px) {
    .dipi_hamburger {
        display: none;
    }

    .et_header_style_slide .dipi_hamburger,
    .et_header_style_fullscreen .dipi_hamburger {
        display: block;
        margin-bottom: 0 !important;
    }
}
</style>
