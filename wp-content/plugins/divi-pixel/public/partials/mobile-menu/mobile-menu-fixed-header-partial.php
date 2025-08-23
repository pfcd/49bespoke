<?php 
namespace DiviPixel;

$breakpoint_mobile = DIPI_Settings::get_mobile_menu_breakpoint();
$mobile_menu_header_height = DIPI_Customizer::get_option('mobile_menu_header_height');
$fixed_mobile_header = DIPI_Settings::get_option('fixed_mobile_header');
$adjust_anchor_links_pos_with_fixed_header = DIPI_Settings::get_option('adjust_anchor_links_pos_with_fixed_header');
?>

<style type="text/css" id="mobile-menu-fixed-header-css">
@media all and (max-width: <?php echo intval($breakpoint_mobile); ?>px) {
    #main-header,
    .et-l--header,
    #top-header { 
        position: fixed !important;
        display: flex;
        flex-direction: column;
        width: 100%;
        z-index: 9999999;
    }
    .et_menu_container {
        display: flex !important;
        flex-direction: column !important;
        height: 100%;
        justify-content: center;
    }
    #et-top-navigation {
        display: flex !important;
        flex-direction: row;
        justify-content: flex-end;
    }
    .dipi-fixed-header {
        top: 0px !important;
    }
<?php if ($fixed_mobile_header == 'on' && $adjust_anchor_links_pos_with_fixed_header == 'on'): ?>    
    .dipi-fixed-header #et-main-area {
        padding-top:  <?php echo intval($mobile_menu_header_height); ?>px;
    }
    div#et-main-area {
        transition: padding 0.3s;
    }
<?php endif; ?>
    .et_mobile_menu {
        max-height: calc(100vh - 120px);
        overflow: auto;
    }

    .et_header_style_centered header#main-header.et-fixed-header .logo_container.logo_container {
        height: auto !important;
    }
    
    .et_header_fullscreen_left .dipi-fixed-header.et-fixed-header #et-top-navigation,
    .et_header_style_left .dipi-fixed-header.et-fixed-header #et-top-navigation {
        padding: 24px 0 0 123px !important;
    }

    .et_header_style_left .et_slide_in_menu_container {
        z-index: 10000000;
    }
}
</style>
 