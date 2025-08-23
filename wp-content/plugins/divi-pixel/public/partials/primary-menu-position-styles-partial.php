<?php 
namespace DiviPixel;
$dropdowns_width = DIPI_Customizer::get_option('dropdowns_width');
$dropdowns_item_width = DIPI_Customizer::get_option('dropdowns_item_width');
$use_social_icons_menu = DIPI_Settings::get_option('social_icons_menu');
$breakpoint_mobile = DIPI_Settings::get_mobile_menu_breakpoint();

$enable_menu_button = DIPI_Settings::get_option('menu_button');
$is_shrink_header = DIPI_Settings::get_option('shrink_header');
$dropdowns_vertical_position = (int)DIPI_Customizer::get_option('dropdowns_vertical_position');

$menu_btn_padding = [0,0,0,0];
if($enable_menu_button == 'on'){
    $menu_btn_padding = DIPI_Customizer::get_option('menu_btn_padding');
    foreach($menu_btn_padding as $key => $value){
        $menu_btn_padding[$key] = (float)$value;
    }
}

 
$menu_height = absint( et_get_option( 'menu_height', '66' ) );
$fixed_menu_height = absint( et_get_option( 'minimized_menu_height', '40' ) );

$top_spaceing = $menu_height / 2 ;
$bottom_spaceing = ($menu_height / 2);
$menu_item_bottom_padding = $bottom_spaceing * ($dropdowns_vertical_position / 100) + $menu_btn_padding[2];
$header_padding_bottom = $bottom_spaceing - $menu_item_bottom_padding + $menu_btn_padding[2];
 
$top_spaceing_fixed = $fixed_menu_height / 2 ;
$bottom_spaceing_fixed = ($fixed_menu_height / 2);
$menu_item_bottom_padding_fixed = $bottom_spaceing_fixed * ($dropdowns_vertical_position / 100) + $menu_btn_padding[2];
$header_padding_bottom_fixed = $bottom_spaceing_fixed - $menu_item_bottom_padding_fixed + $menu_btn_padding[2];

?>
<style type="text/css" id="primary-menu-position">

@media screen and (min-width: <?php echo intval($breakpoint_mobile) + 1; ?>px) {
    body.dipi-cta-button #et_top_search{
        margin: 15px 0 0 22px;
    }
    
    .et_header_style_split div#et-top-navigation,
    .et_header_style_left div#et-top-navigation{
        align-items: flex-start !important;
    }

    .et_header_style_left #et-top-navigation nav > ul > li > a,
    .et_header_style_split #et-top-navigation nav > ul > li > a {
        padding-bottom: <?php echo esc_html($menu_item_bottom_padding); ?>px !important;
    }

    <?php if($enable_menu_button != 'on'): ?>
        /* .et_header_style_left #et-top-navigation nav > ul > li > a,
        .et_header_style_split #et-top-navigation nav > ul > li > a,
        .et_header_style_centered #et-top-navigation nav > ul > li > a {
            line-height: 2.5em;
        } */
    <?php else: ?>
        .dipi-primary-menu-social-icons{
            margin-top: 5px;
        }
        .et_header_style_centered #top-menu > li > a,
        .et_header_style_left #et-top-navigation nav > ul > li > a,
        .et_header_style_split #et-top-navigation nav > ul > li > a {
            line-height: 1.7em;
        }
    <?php endif ?>

    .et_header_style_left div#et-top-navigation {
        display: flex;
        align-items: center;
        
        /* With social icons enabled, we remove the bottom padding below the li elements so we need to add it to the container */
        padding-top: <?php echo esc_html($top_spaceing); ?>px;
        padding-bottom: <?php echo esc_html($header_padding_bottom); ?>px;
    }
    
    .et_header_style_split div#et-top-navigation {
        align-items: center;

        /* With social icons enabled, we remove the bottom padding below the li elements so we need to add it to the container */
        padding-top: <?php echo esc_html($top_spaceing); ?>px !important;
        padding-bottom: <?php echo esc_html($header_padding_bottom); ?>px !important;
    }
    
    .et_header_style_fullscreen #et-top-navigation {  
        padding-bottom: <?php echo esc_html($header_padding_bottom); ?>px !important;   
    }

    /* Vertical Navigation Styles */
    .et_vertical_nav #main-header #top-menu>li>a {
        padding-bottom: 19px !important;
        line-height: inherit;
    }
    .et_vertical_nav #main-header #et-top-navigation {
        display: block;
    }
    .et_vertical_nav #top-header {
        position: initial;
    }
    .et_vertical_fixed.admin-bar #page-container #main-header {
        top:32px !important;
    }
    .et_vertical_nav.et_vertical_fixed.et_header_style_left #et-top-navigation {
        padding-top:33px !important;
    }
    .et_vertical_fixed.admin-bar #page-container #main-header {
        transform: translateY(0) !important;
    }
    .et_vertical_nav #page-container #main-header {
        top: 0 !important;
    }

    /* With do-not-shrink functionality enabeld, we also must apply padding to fixed menu */
    <?php if($is_shrink_header) : ?>
        .et_header_style_left .et-fixed-header div#et-top-navigation {
            padding-top: <?php echo esc_html($top_spaceing); ?>px;
            padding-bottom: <?php echo esc_html($header_padding_bottom); ?>px !important;
        }
        .et_header_style_left .et-fixed-header #et-top-navigation nav > ul > li > a,
        .et_header_style_split .et-fixed-header #et-top-navigation nav > ul > li > a{
            padding-bottom: <?php echo esc_html($menu_item_bottom_padding); ?>px !important;
        }

    <?php else: ?>
        .et_header_style_left .et-fixed-header #et-top-navigation,
        .et_header_style_split .et-fixed-header #et-top-navigation {
            padding-top: <?php echo esc_html($top_spaceing_fixed); ?>px !important;
            padding-bottom: <?php echo esc_html($header_padding_bottom_fixed); ?>px !important;
        }

        .et_header_style_centered .et-fixed-header #et-top-navigation {
            padding-top: <?php echo esc_html($top_spaceing_fixed); ?>px;
            padding-bottom: <?php echo esc_html($header_padding_bottom_fixed); ?>px !important; 
        }

        .et_header_style_left .et-fixed-header #et-top-navigation nav > ul > li > a,
        .et_header_style_split .et-fixed-header #et-top-navigation nav > ul > li > a{
            padding-bottom: <?php echo esc_html($menu_item_bottom_padding_fixed); ?>px !important;
        }
    <?php endif; ?>

    .et-menu li:not(.mega-menu) ul,
    #top-menu li:not(.mega-menu) ul{width: <?php echo esc_html($dropdowns_width) ?>px !important;}
    .et-menu li li a,
    #top-menu li li a{width:100% !important;}
    #top-menu li li,
    .et-menu li li{width: <?php echo esc_html($dropdowns_item_width); ?>%;}
}
</style>