<?php
namespace DiviPixel;
/**
 * mobile-options-partial.php is always inclueded in wp_head. 
 * Here we include all general mobile menu customizations
 */

$breakpoint_mobile = DIPI_Settings::get_mobile_menu_breakpoint();

?>
<style>
@media all and (max-width: <?php echo intval($breakpoint_mobile); ?>px) {
    .et_header_style_centered.et_header_style_centered header#main-header.et-fixed-header .logo_container {
        height: auto;
    }

    .et_header_style_split #et_mobile_nav_menu,
    .et_header_style_centered #et_mobile_nav_menu{
		    flex: 1;
    }

    #et-top-navigation {
        display: flex !important;
    }
}

@media all and (min-width: <?php echo intval($breakpoint_mobile) + 1; ?>px) {
    .et_header_style_centered #et-top-navigation {
        justify-content: center;
    }

    .et_header_style_centered #et_search_icon#et_search_icon:before {
        position: relative;
        top: 0;
    }
}
</style>
