<?php
namespace DiviPixel;

$menu_hover_element_color               = DIPI_Customizer::get_option('menu_hover_element_color');
$menu_hover_element_color_fixed       = DIPI_Customizer::get_option('menu_hover_element_color_fixed');
$menu_hover_element_top_size          = DIPI_Customizer::get_option('menu_hover_element_top_size');
$menu_hover_element_top_space         = DIPI_Customizer::get_option('menu_hover_element_top_space');
$menu_hover_element_bottom_space      = DIPI_Customizer::get_option('menu_hover_element_bottom_space');
$menu_hover_element_top_space_between = DIPI_Customizer::get_option('menu_hover_element_top_space_between');
$menu_hover_element_radius            = DIPI_Customizer::get_option('menu_hover_element_radius');
$active_menu_item_style               = DIPI_Customizer::get_option('active_menu_item_style');
$active_parent_menu_item_style        = DIPI_Customizer::get_option('active_parent_menu_item_style');
$disable_element_animation            = DIPI_Customizer::get_option('disable_element_animations');
$menu_hover_element_dot_size          = DIPI_Customizer::get_option('menu_hover_element_dot_size');
$filled_background_border_size        = DIPI_Customizer::get_option('filled_background_border_size');
$filled_background_border_color       = DIPI_Customizer::get_option('filled_background_border_color');
$filled_background_shadow             = DIPI_Customizer::get_option('filled_background_shadow');
$filled_background_shadow_color       = DIPI_Customizer::get_option('filled_background_shadow_color');
$filled_background_shadow_offset      = DIPI_Customizer::get_option('filled_background_shadow_offset');
$filled_background_shadow_blur        = DIPI_Customizer::get_option('filled_background_shadow_blur');
$filled_background_border_radii       = DIPI_Customizer::get_option('filled_background_border_radii');

?>

<script id="dipi-menu-hover-styles-js">
    jQuery(document).ready(function($){
        $("#top-menu-nav #top-menu li a").not(".dipi-cta-button").wrapInner("<span></span>");
        $(".et_pb_menu__menu > nav > ul > li > a").not(".dipi-cta-button").wrapInner("<span></span>");
    });
</script>

<style id="dipi-menu-hover-styles">

    #top-menu li a,
    .et_pb_menu__menu > nav > ul > li a {
        -webkit-transition: all .3s ease-in-out;
        -moz-transition: all .3s ease-in-out;
        transition: all .3s ease-in-out;
    }

    #top-menu li > a > span,
    .et_pb_menu__menu > nav > ul > li a > span {
        position: relative;
    }

    <?php if($disable_element_animation) : ?>
    .three_dots #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span:after,
    .three_dots .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span:after
    <?php else : ?>

    .three_dots #top-menu li:not(.dipi-cta-button-menu-item) > a > span:after,
    .three_dots .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item) > a > span:after
    <?php endif; ?> {
        position: absolute;
        content: '';
        left: 50%;
        top: <?php echo esc_html($menu_hover_element_top_space); ?>px;
        transition: all .3s ease-in-out;
        text-shadow: 0 0 transparent;
        width: <?php echo esc_html($menu_hover_element_dot_size); ?>px;
        height: <?php echo esc_html($menu_hover_element_dot_size); ?>px;
        border-radius: 100px;
        transform: translateX(-50%);
    }

    <?php if($active_parent_menu_item_style) : ?>
    .three_dots #top-menu li.current-menu-ancestor > a > span:after,
    .three_dots .et_pb_menu__menu > nav > ul > li.current-menu-ancestor > a > span:after,
    <?php endif; ?>
    <?php if($active_menu_item_style) : ?>
    .three_dots #top-menu li.current-menu-item > a > span:after,
    .three_dots .et_pb_menu__menu > nav > ul > li.current-menu-item > a > span:after,
    <?php endif; ?>
    <?php if($disable_element_animation) : ?>
    .three_dots #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover > a > span:after,
    .three_dots .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover > a > span:after
    <?php else : ?>
    .three_dots #top-menu li:not(.dipi-cta-button-menu-item):hover > a > span:after,
    .three_dots .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item):hover > a > span:after
    <?php endif; ?> {
        background-color: <?php echo esc_html($menu_hover_element_color); ?>;
        box-shadow: <?php echo esc_html($menu_hover_element_top_space_between); ?>px 0 <?php echo esc_html($menu_hover_element_color); ?>, -<?php echo esc_html($menu_hover_element_top_space_between); ?>px 0 <?php echo esc_html($menu_hover_element_color); ?>;
    }

    <?php if($active_parent_menu_item_style) : ?>
    .three_dots .et-fixed-header #top-menu li.current-menu-ancestor > a > span:after,
    <?php endif; ?>
    <?php if($active_menu_item_style) : ?>
    .three_dots .et-fixed-header #top-menu > li.current-menu-item > a > span:after,
    <?php endif; ?>

    <?php if($disable_element_animation) : ?>
    .three_dots .et-fixed-header #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover > a > span:after
    <?php else : ?>
    .three_dots .et-fixed-header #top-menu > li:not(.dipi-cta-button-menu-item):hover > a > span:after
    <?php endif; ?> {
        background-color: <?php echo esc_html($menu_hover_element_color_fixed); ?> !important;
        box-shadow: <?php echo esc_html($menu_hover_element_top_space_between); ?>px 0 <?php echo esc_html($menu_hover_element_color_fixed); ?>, -<?php echo esc_html($menu_hover_element_top_space_between); ?>px 0 <?php echo esc_html($menu_hover_element_color_fixed); ?> !important;
    }
    
    <?php if( ! $disable_element_animation ) : ?>
        .filled_background #top-menu .menu-item-has-children > a:first-child:after, 
        .filled_background #et-secondary-nav .menu-item-has-children > a:first-child:after,
        .filled_background .et_pb_menu__menu .menu-item-has-children > a:first-child:after {
            content: none;
        }
        .filled_background #top-menu .menu-item-has-children > a > span:after, 
        .filled_background #et-secondary-nav .menu-item-has-children > a > span:after,
        .filled_background .et_pb_menu__menu > nav .menu-item-has-children > a > span:after  {
            font-family: 'ETmodules';
            content: "3";
            font-size: 16px;
            position: absolute;
            right: 5px;
            top: 5px;
            font-weight: 800;
        }
    <?php endif; ?>
    
    <?php if($disable_element_animation) : ?>
    .filled_background #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span,
    .filled_background .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span
    <?php else : ?>
    .filled_background .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item) > a > span,
    .filled_background #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span,
    .filled_background #top-menu > li.menu-item-has-children > a > span
    /* .filled_background .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span */
    <?php endif; ?> {
        border-style: solid;
        border-color: transparent;
        background-color: transparent;
        transition: background-color .3s ease-in-out, box-shadow .3s ease-in-out, border-color .3s ease-in-out;
        border-width: <?php echo esc_html($filled_background_border_size); ?>px;
        border-top-left-radius: <?php echo esc_html($filled_background_border_radii[0]); ?>px;
        border-top-right-radius: <?php echo esc_html($filled_background_border_radii[1]); ?>px;
        border-bottom-left-radius: <?php echo esc_html($filled_background_border_radii[2]); ?>px;
        border-bottom-right-radius: <?php echo esc_html($filled_background_border_radii[3]); ?>px;
    }

    <?php if($active_parent_menu_item_style) : ?>
    .filled_background #top-menu li.current-menu-ancestor > a > span,
    .filled_background .et_pb_menu__menu > nav > ul > li.current-menu-ancestor > a > span,
    <?php endif; ?>

    <?php if($active_menu_item_style) : ?>
    .filled_background #top-menu li.current-menu-item:not(.dipi-cta-button-menu-item) > a > span,
    .filled_background .et_pb_menu__menu > nav > ul > li.current-menu-item:not(.dipi-cta-button-menu-item) > a > span,
    <?php endif; ?>

    <?php if($disable_element_animation) : ?>
    .filled_background #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover > a > span,
    .filled_background .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover > a > span
    <?php else : ?>

    .filled_background #top-menu li:not(.dipi-cta-button-menu-item):hover > a > span,
    .filled_background .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item):hover > a > span
    <?php endif; ?> {
        border-color: <?php echo esc_html($filled_background_border_color); ?>;
        background-color: <?php echo esc_html($menu_hover_element_color); ?>;
        <?php if($filled_background_shadow) : ?>
        box-shadow: 0px <?php echo esc_html($filled_background_shadow_offset); ?>px <?php echo esc_html($filled_background_shadow_blur); ?>px <?php echo esc_html($filled_background_shadow_color); ?>;
        <?php endif; ?>
    }




    <?php if($active_menu_item_style) : ?>
    .filled_background #top-menu li.current-menu-item:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span,
    .filled_background .et_pb_menu__menu > nav > ul > li.current-menu-item:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span,
    <?php endif; ?>
    .filled_background #top-menu  li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover > a > span,
    .filled_background .et_pb_menu__menu > nav  ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover > a > span
    {
        padding: 5px 10px;
        margin: -5px -10px;
    }

    .filled_background #top-menu li.menu-item-has-children > a > span,
    .filled_background .et_pb_menu__menu > nav > ul > li.menu-item-has-children > a > span,
    .filled_background #top-menu li.menu-item-has-children:hover > a > span,
    .filled_background .et_pb_menu__menu > nav > ul > li.menu-item-has-children:hover > a > span {
        padding: 5px 25px 5px 10px;
        margin: -5px -25px -5px -10px;
    }

    <?php if($active_parent_menu_item_style) : ?>
    .filled_background .et-fixed-header #top-menu li.current-menu-ancestor > a > span,
    <?php endif; ?>
    <?php if($active_menu_item_style) : ?>
    .filled_background .et-fixed-header #top-menu > li.current-menu-item > a > span,
    <?php endif; ?>

    <?php if($disable_element_animation) : ?>
    .filled_background .et-fixed-header #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover > a > span
    <?php else : ?>
    .filled_background .et-fixed-header #top-menu > li:not(.dipi-cta-button-menu-item):hover > a > span
    <?php endif; ?> {
        background-color: <?php echo esc_html($menu_hover_element_color_fixed); ?> !important;
    }

    <?php if($disable_element_animation) : ?>
    .slide_up_below #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span:after,
    .slide_up_below .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span:after
    <?php else : ?> 

    .slide_up_below #top-menu li:not(.dipi-cta-button-menu-item) > a > span:after,
    .slide_up_below .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item) > a > span:after
    <?php endif; ?>  {
        content: '';
        display: block;
        background: <?php echo esc_html($menu_hover_element_color); ?>;
        width: 100%;
        height: <?php echo esc_html($menu_hover_element_top_size); ?>px;
        left: 0;
        position: absolute;
        top: <?php echo esc_html($menu_hover_element_top_space); ?>px;
        transition: all .3s ease-in-out;
        opacity: 0;
        border-radius: <?php echo esc_html($menu_hover_element_radius); ?>px;
    }

    <?php if($active_parent_menu_item_style) : ?>
    .slide_up_below #top-menu li.current-menu-ancestor > a > span:after,
    .slide_up_below .et_pb_menu__menu > nav > ul > li.current-menu-ancestor > a > span:after,
    <?php endif; ?>

    <?php if($active_menu_item_style) : ?>
    .slide_up_below #top-menu li.current-menu-item > a > span:after,
    .slide_up_below .et_pb_menu__menu > nav > ul > li.current-menu-item > a > span:after,
    <?php endif; ?>

    <?php if($disable_element_animation) : ?>
    .slide_up_below #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover > a > span:after,
    .slide_up_below .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover > a > span:after
    <?php else : ?> 

    .slide_up_below #top-menu li:not(.dipi-cta-button-menu-item):hover > a > span:after,
    .slide_up_below .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item):hover > a > span:after
    <?php endif; ?> {
        top: calc(<?php echo esc_html($menu_hover_element_top_space); ?>px - 5px) !important;
        opacity: 1 !important;
    }

    <?php if($active_parent_menu_item_style) : ?>
    .slide_up_below .et-fixed-header #top-menu li.current-menu-ancestor > a > span:after,
    <?php endif; ?>
    <?php if($active_menu_item_style) : ?>
    .slide_up_below .et-fixed-header #top-menu > li.current-menu-item > a > span:after,
    <?php endif; ?>
    <?php if($disable_element_animation) : ?>
    .slide_up_below .et-fixed-header #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span:after
    <?php else : ?>
    .slide_up_below .et-fixed-header #top-menu > li:not(.dipi-cta-button-menu-item) > a > span:after
    <?php endif; ?> {
        background-color: <?php echo esc_html($menu_hover_element_color_fixed); ?> !important;
    }

    <?php if($disable_element_animation) : ?>
    .slide_down_below #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) a > span:after,
    .slide_down_below .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) a > span:after
    <?php else : ?> 

    .slide_down_below #top-menu li:not(.dipi-cta-button-menu-item) > a > span:after,
    .slide_down_below .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item) > a > span:after
    <?php endif; ?> {
        content: '';
        display: block;
        background: <?php echo esc_html($menu_hover_element_color); ?>;
        width: 100%;
        height: <?php echo esc_html($menu_hover_element_top_size); ?>px;
        left: 0;
        position: absolute;
        top: <?php echo esc_html($menu_hover_element_top_space); ?>px;
        transition: all .3s ease-in-out;
        opacity: 0;
        border-radius: <?php echo esc_html($menu_hover_element_radius); ?>px;
    }

    <?php if($active_parent_menu_item_style) : ?>
    .slide_down_below #top-menu li.current-menu-ancestor > a > span:after,
    .slide_down_below .et_pb_menu__menu > nav > ul > li.current-menu-ancestor > a > span:after,
    <?php endif; ?>

    <?php if($active_menu_item_style) : ?>
    .slide_down_below #top-menu li.current-menu-item > a > span:after,
    .slide_down_below .et_pb_menu__menu > nav > ul > li.current-menu-item > a > span:after,
    <?php endif; ?>

    <?php if($disable_element_animation) : ?>
    .slide_down_below #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):not(.centered-inline-logo-wrap):hover a > span:after,
    .slide_down_below .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):not(.centered-inline-logo-wrap):hover a > span:after
    <?php else : ?>

    .slide_down_below #top-menu li:not(.dipi-cta-button-menu-item):not(.centered-inline-logo-wrap):hover > a > span:after,
    .slide_down_below .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item):not(.centered-inline-logo-wrap):hover > a > span:after
    <?php endif; ?> {
        top: calc(<?php echo esc_html($menu_hover_element_top_space); ?>px + 5px) !important;
        opacity: 1 !important;
    }
    
    <?php if($active_parent_menu_item_style) : ?>
    .slide_down_below .et-fixed-header #top-menu li.current-menu-ancestor > a > span:after,
    <?php endif; ?>
    <?php if($active_menu_item_style) : ?>
    .slide_down_below .et-fixed-header #top-menu > li.current-menu-item > a > span:after,
    <?php endif; ?>
    <?php if($disable_element_animation) : ?>
    .slide_down_below .et-fixed-header #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span:after
    <?php else : ?>
    .slide_down_below .et-fixed-header #top-menu > li:not(.dipi-cta-button-menu-item) > a > span:after
    <?php endif; ?> {
        background-color: <?php echo esc_html($menu_hover_element_color_fixed); ?> !important;
    }

    <?php if($disable_element_animation) : ?>
    .grow_below_left #top-menu > li:not(.menu-item-has-children):not(.centered-inline-logo-wrap) a > span:after,
    .grow_below_left .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children) a > span:after,
    .grow_above_and_below_left #top-menu > li:not(.menu-item-has-children) a > span:after,
    .grow_above_and_below_left .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children) a > span:after
    <?php else : ?>

    .grow_below_left #top-menu li:not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_below_left .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_above_and_below_left #top-menu li:not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_above_and_below_left .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item) > a > span:after 
    <?php endif; ?> {
        content: '';
        display: block;
        background: <?php echo esc_html($menu_hover_element_color); ?>;
        width: 0;
        height: <?php echo esc_html($menu_hover_element_top_size); ?>px;
        left: 0;
        position: absolute;
        top: <?php echo esc_html($menu_hover_element_top_space); ?>px;
        transition: all .3s ease-in-out;
        opacity: 0;
        border-radius: <?php echo esc_html($menu_hover_element_radius); ?>px;
    }

    <?php if($disable_element_animation) : ?>
    .grow_above_and_below_left #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) a > span:before,
    .grow_above_and_below_left .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) a > span:before
    <?php else : ?>

    .grow_above_and_below_left #top-menu li:not(.dipi-cta-button-menu-item) > a > span:before,
    .grow_above_and_below_left .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item) > a > span:before
    <?php endif; ?> {
        content: '';
        display: block;
        background: <?php echo esc_html($menu_hover_element_color); ?>;
        width: 0;
        height: <?php echo esc_html($menu_hover_element_top_size); ?>px;
        left: 0;
        position: absolute;
        top: <?php echo esc_html($menu_hover_element_bottom_space); ?>px;
        transition: all .3s ease-in-out;
        opacity: 0;
        border-radius: <?php echo esc_html($menu_hover_element_radius); ?>px;
    }

    <?php if( $active_parent_menu_item_style ) : ?>
    .grow_below_left #top-menu li.current-menu-ancestor > a > span:after,
    .grow_below_left .et_pb_menu__menu > nav > ul > li.current-menu-ancestor > a > span:after,
    .grow_above_and_below_left #top-menu li.current-menu-ancestor > a > span:after,
    .grow_above_and_below_left #top-menu li.current-menu-ancestor > a > span:before,
    .grow_above_and_below_left .et_pb_menu__menu > nav > ul > li.current-menu-ancestor > a > span:after,
    .grow_above_and_below_left .et_pb_menu__menu > nav > ul > li.current-menu-ancestor > a > span:before,
    <?php endif; ?>

    <?php if($active_menu_item_style) : ?>
    .grow_below_left #top-menu li.current-menu-item > a > span:after,
    .grow_below_left .et_pb_menu__menu > nav > ul > li.current-menu-item > a > span:after,
    .grow_above_and_below_left #top-menu li.current-menu-item > a > span:before,
    .grow_above_and_below_left #top-menu li.current-menu-item > a > span:after,
    .grow_above_and_below_left .et_pb_menu__menu > nav > ul > li.current-menu-item > a > span:before,
    .grow_above_and_below_left .et_pb_menu__menu > nav > ul > li.current-menu-item > a > span:after,
    <?php endif; ?>

    <?php if($disable_element_animation) : ?>
    .grow_below_left #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:after,
    .grow_below_left .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:after,
    .grow_above_and_below_left #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):not(.centered-inline-logo-wrap):hover a > span:after,
    .grow_above_and_below_left #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):not(.centered-inline-logo-wrap):hover a > span:before,
    .grow_above_and_below_left .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:after,
    .grow_above_and_below_left .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:before
    <?php else : ?>
    .grow_below_left #top-menu li:not(.dipi-cta-button-menu-item):hover > a > span:after,
    .grow_below_left .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item):hover > a > span:after,
    .grow_above_and_below_left #top-menu li:not(.dipi-cta-button-menu-item):hover > a > span:after,
    .grow_above_and_below_left #top-menu li:not(.dipi-cta-button-menu-item):hover > a > span:before,
    .grow_above_and_below_left .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item):hover > a > span:after,
    .grow_above_and_below_left .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item):hover > a > span:before
    <?php endif; ?> {
        width: 100% !important;
        opacity: 1 !important;
    }

    <?php if($active_parent_menu_item_style) : ?>
    .grow_below_left .et-fixed-header #top-menu li.current-menu-ancestor > a > span:after,
    .grow_above_and_below_left .et-fixed-header #top-menu li.current-menu-ancestor > a > span:after,
    .grow_above_and_below_left .et-fixed-header #top-menu li.current-menu-ancestor > a > span:before,
    <?php endif; ?>
    <?php if($active_menu_item_style) : ?>
    .grow_below_left .et-fixed-header #top-menu li.current-menu-item > a > span:after,
    .grow_above_and_below_left .et-fixed-header #top-menu li.current-menu-item > a > span:after,
    .grow_above_and_below_left .et-fixed-header #top-menu li.current-menu-item > a > span:before,
    <?php endif; ?>

    <?php if($disable_element_animation) : ?>
    .grow_below_left .et-fixed-header #top-menu li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_above_and_below_left .et-fixed-header #top-menu li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_above_and_below_left .et-fixed-header #top-menu li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span:before
    <?php else : ?>
    .grow_below_left .et-fixed-header #top-menu li:not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_above_and_below_left .et-fixed-header #top-menu li:not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_above_and_below_left .et-fixed-header #top-menu li:not(.dipi-cta-button-menu-item) > a > span:before
    <?php endif; ?> {
        background-color: <?php echo esc_html($menu_hover_element_color_fixed); ?> !important;
    }

    <?php if($disable_element_animation) : ?>
    .grow_below_center #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):not(.centered-inline-logo-wrap) a > span:after,
    .grow_above_and_below_center #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):not(.centered-inline-logo-wrap) a > span:after,
    .grow_below_center .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) a > span:after,
    .grow_above_and_below_center .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) a > span:after
    <?php else : ?>
    .grow_below_center #top-menu li:not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_above_and_below_center #top-menu li:not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_below_center .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_above_and_below_center .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item) > a > span:after 
    <?php endif; ?> {
        content: '';
        display: block;
        background: <?php echo esc_html($menu_hover_element_color); ?>;
        width: 0;
        height: <?php echo esc_html($menu_hover_element_top_size); ?>px;
        left: 50%;
        position: absolute;
        top: <?php echo esc_html($menu_hover_element_top_space); ?>px;
        transition: all .3s ease-in-out;
        opacity: 0;
        border-radius: <?php echo esc_html($menu_hover_element_radius); ?>px;
    }

    <?php if($disable_element_animation) : ?>
    .grow_above_and_below_center #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):not(.centered-inline-logo-wrap) a > span:before,
    .grow_above_and_below_center .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) a > span:before
    <?php else : ?>
    .grow_above_and_below_center #top-menu li:not(.dipi-cta-button-menu-item) > a > span:before,
    .grow_above_and_below_center .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item) > a > span:before
    <?php endif; ?> {
        content: '';
        display: block;
        background: <?php echo esc_html($menu_hover_element_color); ?>;
        width: 0;
        height: <?php echo esc_html($menu_hover_element_top_size); ?>px;
        left: 50%;
        position: absolute;
        top: <?php echo esc_html($menu_hover_element_bottom_space); ?>px;
        transition: all .3s ease-in-out;
        opacity: 0;
        border-radius: <?php echo esc_html($menu_hover_element_radius); ?>px;
    }

    <?php if( $active_parent_menu_item_style ) : ?>
    .grow_below_center #top-menu li.current-menu-ancestor > a > span:after,
    .grow_above_and_below_center #top-menu li.current-menu-ancestor > a > span:before,
    .grow_above_and_below_center #top-menu li.current-menu-ancestor > a > span:after,
    .grow_below_center .et_pb_menu__menu > nav > ul > li.current-menu-ancestor > a > span:after,
    .grow_above_and_below_center .et_pb_menu__menu > nav > ul > li.current-menu-ancestor > a > span:before,
    .grow_above_and_below_center .et_pb_menu__menu > nav > ul > li.current-menu-ancestor > a > span:after,
    <?php endif; ?>

    <?php if($active_menu_item_style) : ?>
    .grow_below_center #top-menu li.current-menu-item > a > span:after,
    .grow_above_and_below_center #top-menu li.current-menu-item > a > span:before,
    .grow_above_and_below_center #top-menu li.current-menu-item > a > span:after,
    .grow_below_center .et_pb_menu__menu > nav > ul > li.current-menu-item > a > span:after,
    .grow_above_and_below_center .et_pb_menu__menu > nav > ul > li.current-menu-item > a > span:before,
    .grow_above_and_below_center .et_pb_menu__menu > nav > ul > li.current-menu-item > a > span:after,
    <?php endif; ?>

    <?php if($disable_element_animation) : ?>
    .grow_below_center #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:after,
    .grow_above_and_below_center #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:before,
    .grow_above_and_below_center #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:after,
    .grow_below_center .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:after,
    .grow_above_and_below_center .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:before,
    .grow_above_and_below_center .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:after
    <?php else : ?>
    .grow_below_center #top-menu li:not(.dipi-cta-button-menu-item):hover > a > span:after,
    .grow_above_and_below_center #top-menu li:not(.dipi-cta-button-menu-item):hover > a > span:before,
    .grow_above_and_below_center #top-menu li:not(.dipi-cta-button-menu-item):hover > a > span:after,
    .grow_below_center .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item):hover > a > span:after,
    .grow_above_and_below_center .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item):hover > a > span:before,
    .grow_above_and_below_center .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item):hover > a > span:after
    <?php endif; ?> {
        width: 100% !important;
        opacity: 1 !important;
        left: 0 !important;
    }

    <?php if($active_parent_menu_item_style) : ?>
    .grow_below_center .et-fixed-header #top-menu li.current-menu-ancestor > a > span:after,
    .grow_above_and_below_center .et-fixed-header #top-menu li.current-menu-ancestor > a > span:after,
    .grow_above_and_below_center .et-fixed-header #top-menu li.current-menu-ancestor > a > span:before,
    <?php endif; ?>
    <?php if($active_menu_item_style) : ?>
    .grow_below_center .et-fixed-header #top-menu li.current-menu-item > a > span:after,
    .grow_above_and_below_center .et-fixed-header #top-menu li.current-menu-item > a > span:after,
    .grow_above_and_below_center .et-fixed-header #top-menu li.current-menu-item > a > span:before,
    <?php endif; ?>

    <?php if($disable_element_animation) : ?>
    .grow_below_center .et-fixed-header #top-menu li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_above_and_below_center .et-fixed-header #top-menu li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_above_and_below_center .et-fixed-header #top-menu li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span:before
    <?php else : ?>
    .grow_below_center .et-fixed-header #top-menu li:not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_above_and_below_center .et-fixed-header #top-menu li:not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_above_and_below_center .et-fixed-header #top-menu li:not(.dipi-cta-button-menu-item) > a > span:before
    <?php endif; ?> {
        background-color: <?php echo esc_html($menu_hover_element_color_fixed); ?> !important;
    }

    <?php if($disable_element_animation) : ?>
    .grow_below_right #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):not(.centered-inline-logo-wrap) a > span:after,
    .grow_above_and_below_right #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):not(.centered-inline-logo-wrap) a > span:after,
    .grow_below_right .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) a > span:after,
    .grow_above_and_below_right .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) a > span:after
    <?php else : ?>
    .grow_below_right #top-menu li:not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_above_and_below_right #top-menu li:not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_below_right .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_above_and_below_right .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item) > a > span:after 
    <?php endif; ?> {
        content: '';
        display: block;
        background: <?php echo esc_html($menu_hover_element_color); ?>;
        width: 0;
        height: <?php echo esc_html($menu_hover_element_top_size); ?>px;
        right: 0;
        position: absolute;
        top: <?php echo esc_html($menu_hover_element_top_space); ?>px;
        transition: all .3s ease-in-out;
        opacity: 0;
        border-radius: <?php echo esc_html($menu_hover_element_radius); ?>px;
    }

    <?php if($disable_element_animation) : ?>
    .grow_above_and_below_right #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):not(.centered-inline-logo-wrap) a > span:before,
    .grow_above_and_below_right .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) a > span:before
    <?php else : ?>
    .grow_above_and_below_right #top-menu li:not(.dipi-cta-button-menu-item) > a > span:before,
    .grow_above_and_below_right .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item) > a > span:before 
    <?php endif; ?> {
        content: '';
        display: block;
        background: <?php echo esc_html($menu_hover_element_color); ?>;
        width: 0;
        height: <?php echo esc_html($menu_hover_element_top_size); ?>px;
        right: 0;
        position: absolute;
        top: <?php echo esc_html($menu_hover_element_bottom_space); ?>px;
        transition: all .3s ease-in-out;
        opacity: 0;
        border-radius: <?php echo esc_html($menu_hover_element_radius); ?>px;
    }

    <?php if( $active_parent_menu_item_style ) : ?>
    .grow_below_right #top-menu li.current-menu-ancestor > a > span:after,
    .grow_above_and_below_right #top-menu li.current-menu-ancestor > a > span:after,
    .grow_above_and_below_right #top-menu li.current-menu-ancestor > a > span:before,
    .grow_below_right .et_pb_menu__menu > nav > ul > li.current-menu-ancestor > a > span:after,
    .grow_above_and_below_right .et_pb_menu__menu > nav > ul > li.current-menu-ancestor > a > span:after,
    .grow_above_and_below_right .et_pb_menu__menu > nav > ul > li.current-menu-ancestor > a > span:before,
    <?php endif; ?>

    <?php if($active_menu_item_style) : ?>
    .grow_below_right #top-menu li.current-menu-item > a > span:after,
    .grow_above_and_below_right #top-menu li.current-menu-item > a > span:after,
    .grow_above_and_below_right #top-menu li.current-menu-item > a > span:before,
    .grow_below_right .et_pb_menu__menu > nav > ul > li.current-menu-item > a > span:after,
    .grow_above_and_below_right .et_pb_menu__menu > nav > ul > li.current-menu-item > a > span:after,
    .grow_above_and_below_right .et_pb_menu__menu > nav > ul > li.current-menu-item > a > span:before,
    <?php endif; ?>

    <?php if($disable_element_animation) : ?>
    .grow_below_right #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:after,
    .grow_above_and_below_right #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:after,
    .grow_above_and_below_right #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:before,
    .grow_below_right .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:after,
    .grow_above_and_below_right .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:after,
    .grow_above_and_below_right .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:before

    <?php else : ?>
    .grow_below_right #top-menu li:not(.dipi-cta-button-menu-item):hover > a > span:after, 
    .grow_above_and_below_right #top-menu li:not(.dipi-cta-button-menu-item):hover > a > span:after, 
    .grow_above_and_below_right #top-menu li:not(.dipi-cta-button-menu-item):hover > a > span:before,
    .grow_below_right .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item):hover > a > span:after, 
    .grow_above_and_below_right .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item):hover > a > span:after, 
    .grow_above_and_below_right .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item):hover > a > span:before
    <?php endif; ?> {
        width: 100% !important;
        opacity: 1 !important;
    }

    <?php if($active_parent_menu_item_style) : ?>
    .grow_below_right .et-fixed-header #top-menu li.current-menu-ancestor > a > span:after,
    .grow_above_and_below_right .et-fixed-header #top-menu li.current-menu-ancestor > a > span:after,
    .grow_above_and_below_right .et-fixed-header #top-menu li.current-menu-ancestor > a > span:before,
    <?php endif; ?>

    <?php if($active_menu_item_style) : ?>
    .grow_below_right .et-fixed-header #top-menu li.current-menu-item > a > span:after,
    .grow_above_and_below_right .et-fixed-header #top-menu li.current-menu-item > a > span:after,
    .grow_above_and_below_right .et-fixed-header #top-menu li.current-menu-item > a > span:before,
    <?php endif; ?>

    <?php if($disable_element_animation) : ?>
    .grow_below_right .et-fixed-header #top-menu li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_above_and_below_right .et-fixed-header #top-menu li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_above_and_below_right .et-fixed-header #top-menu li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) > a > span:before
    <?php else : ?>
    .grow_below_right .et-fixed-header #top-menu li:not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_above_and_below_right .et-fixed-header #top-menu li:not(.dipi-cta-button-menu-item) > a > span:after,
    .grow_above_and_below_right .et-fixed-header #top-menu li:not(.dipi-cta-button-menu-item) > a > span:before
    <?php endif; ?> {
        background-color: <?php echo esc_html($menu_hover_element_color_fixed); ?> !important;
    }

    <?php if($disable_element_animation) : ?>
    .bracketed_out #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):not(.centered-inline-logo-wrap) a > span:before,
    .bracketed_out .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) a > span:before
    <?php else : ?>
    .bracketed_out #top-menu li:not(.dipi-cta-button-menu-item) > a > span:before,
    .bracketed_out .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item) > a > span:before 
    <?php endif; ?> {
        content: '[';
        display: inline-block;
        color: <?php echo esc_html($menu_hover_element_color); ?>;
        transition: all .15s ease-in-out;
        opacity: 0;
        left: 0;
        position: absolute;
        top: 0;
        font-size: 120%;
    }

    <?php if($disable_element_animation) : ?>
    .bracketed_out #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):not(.centered-inline-logo-wrap) a > span:after,
    .bracketed_out .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) a > span:after
    <?php else : ?>
    .bracketed_out #top-menu li:not(.dipi-cta-button-menu-item) > a > span:after,
    .bracketed_out .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item) > a > span:after
    <?php endif; ?> {
        content: ']';
        display: inline-block;
        color: <?php echo esc_html($menu_hover_element_color); ?>;
        transition: all .15s ease-in-out;
        opacity: 0;
        right: 0;
        position: absolute;
        top: 0;
        font-size: 120%;
    }

    <?php if($disable_element_animation) : ?>
    .bracketed_in #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):not(.centered-inline-logo-wrap) a > span:before,
    .bracketed_in .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) a > span:before
    <?php else : ?>
    .bracketed_in #top-menu li:not(.dipi-cta-button-menu-item) > a > span:before,
    .bracketed_in .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item) > a > span:before 
    <?php endif; ?> {
        content: '[';
        display: inline-block;
        color: <?php echo esc_html($menu_hover_element_color); ?>;
        transition: all .15s ease-in-out;
        opacity: 0;
        left: -20px;
        position: absolute;
        top: 0;
        font-size: 120%;
    }

    <?php if($disable_element_animation) : ?>
    .bracketed_in #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):not(.centered-inline-logo-wrap) a > span:after,
    .bracketed_in .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) a > span:after
    <?php else : ?>
    .bracketed_in #top-menu li:not(.dipi-cta-button-menu-item) > a > span:after,
    .bracketed_in .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item) > a > span:after
    <?php endif; ?> {
        content: ']';
        display: inline-block;
        color: <?php echo esc_html($menu_hover_element_color); ?>;
        transition: all .15s ease-in-out;
        opacity: 0;
        right: -20px;
        position: absolute;
        top: 0;
        font-size: 120%;
    }

    <?php if( $active_parent_menu_item_style ) : ?>
    .bracketed_out #top-menu li.current-menu-ancestor > a > span:before,
    .bracketed_in #top-menu li.current-menu-ancestor > a > span:before,
    .bracketed_out .et_pb_menu__menu > nav > ul > li.current-menu-ancestor > a > span:before,
    .bracketed_in .et_pb_menu__menu > nav > ul > li.current-menu-ancestor > a > span:before,
    <?php endif; ?>

    <?php if($active_menu_item_style) : ?>
    .bracketed_out #top-menu li.current-menu-item > a > span:before,
    .bracketed_in #top-menu li.current-menu-item > a > span:before,

    .bracketed_out .et_pb_menu__menu > nav > ul > li.current-menu-item > a > span:before,
    .bracketed_in .et_pb_menu__menu > nav > ul > li.current-menu-item > a > span:before,
    <?php endif; ?>

    <?php if($disable_element_animation) : ?>
    .bracketed_out #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:before,
    .bracketed_in #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:before,

    .bracketed_out .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:before,
    .bracketed_in .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:before
    <?php else : ?>

    .bracketed_out #top-menu li:not(.dipi-cta-button-menu-item):hover > a > span:before, 
    .bracketed_in #top-menu li:not(.dipi-cta-button-menu-item):hover > a > span:before,
    .bracketed_out .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item):hover > a > span:before, 
    .bracketed_in .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item):hover > a > span:before
    <?php endif; ?> {
        left: -10px !important;
        opacity: 1 !important;
    }

    <?php if( $active_parent_menu_item_style ) : ?>
    .bracketed_out #top-menu li.current-menu-ancestor > a > span:after,
    .bracketed_in #top-menu li.current-menu-ancestor > a > span:after,
    .bracketed_out .et_pb_menu__menu > nav > ul > li.current-menu-ancestor > a > span:after,
    .bracketed_in .et_pb_menu__menu > nav > ul > li.current-menu-ancestor > a > span:after,
    <?php endif; ?>

    <?php if($active_menu_item_style) : ?>
    .bracketed_out #top-menu li.current-menu-item > a > span:after,
    .bracketed_in #top-menu li.current-menu-item > a > span:after,
    .bracketed_out .et_pb_menu__menu > nav > ul > li.current-menu-item > a > span:after,
    .bracketed_in .et_pb_menu__menu > nav > ul > li.current-menu-item > a > span:after,
    <?php endif; ?>

    <?php if($disable_element_animation) : ?>
    .bracketed_out #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:after,
    .bracketed_in #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:after,
    .bracketed_out .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:after,
    .bracketed_in .et_pb_menu__menu > nav > ul > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item):hover a > span:after

    <?php else : ?>
    .bracketed_out #top-menu li:not(.dipi-cta-button-menu-item):hover > a > span:after, 
    .bracketed_in #top-menu li:not(.dipi-cta-button-menu-item):hover > a > span:after,
    .bracketed_out .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item):hover > a > span:after, 
    .bracketed_in .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item):hover > a > span:after
    <?php endif; ?> {
        right: -10px !important;
        opacity: 1 !important;
    }

    @-moz-document url-prefix() { 
        .filled_background #top-menu li:not(.dipi-cta-button-menu-item) > a > span,
        .filled_background .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item) > a > span,
        .filled_background #top-menu li:not(.dipi-cta-button-menu-item):hover > a > span,
        .filled_background .et_pb_menu__menu > nav > ul > li:not(.dipi-cta-button-menu-item):hover > a > span {
            margin: 0 !important;
        }
    }

    <?php if($active_parent_menu_item_style) : ?>
    .bracketed_out .et-fixed-header #top-menu > li.current-menu-ancestor a > span:before,
    .bracketed_in .et-fixed-header #top-menu > li.current-menu-ancestor a > span:before,
    .bracketed_out .et-fixed-header #top-menu > li.current-menu-ancestor a > span:after,
    .bracketed_in .et-fixed-header #top-menu > li.current-menu-ancestor a > span:after,
    <?php endif; ?>

    <?php if($active_menu_item_style) : ?>
    .bracketed_out .et-fixed-header #top-menu > li.current-menu-item a > span:before,
    .bracketed_in .et-fixed-header #top-menu > li.current-menu-item a > span:before,
    .bracketed_out .et-fixed-header #top-menu > li.current-menu-item a > span:after,
    .bracketed_in .et-fixed-header #top-menu > li.current-menu-item a > span:after,
    <?php endif; ?>

    <?php if($disable_element_animation) : ?>
    .bracketed_out .et-fixed-header #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) a > span:before,
    .bracketed_in .et-fixed-header #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) a > span:before,
    .bracketed_out .et-fixed-header #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) a > span:after,
    .bracketed_in .et-fixed-header #top-menu > li:not(.menu-item-has-children):not(.dipi-cta-button-menu-item) a > span:after
    <?php else : ?>
    .bracketed_out .et-fixed-header #top-menu > li:not(.dipi-cta-button-menu-item) a > span:before,
    .bracketed_in .et-fixed-header #top-menu > li:not(.dipi-cta-button-menu-item) a > span:before,
    .bracketed_out .et-fixed-header #top-menu > li:not(.dipi-cta-button-menu-item) a > span:after,
    .bracketed_in .et-fixed-header #top-menu > li:not(.dipi-cta-button-menu-item) a > span:after
    <?php endif; ?> {
        color: <?php echo esc_html($menu_hover_element_color_fixed); ?> !important;
    }

</style>