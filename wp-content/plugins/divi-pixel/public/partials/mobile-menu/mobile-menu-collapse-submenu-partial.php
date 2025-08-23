<?php
namespace DiviPixel;
add_filter('et_late_global_assets_list', function ($assets, $assets_args, $et_dynamic_assets) {
    if (!isset($assets['et_icons_fa'])) {
        $assets_prefix = et_get_dynamic_assets_path();
        $assets['et_icons_fa'] = array(
            'css' => "{$assets_prefix}/css/icons_fa_all.css",
        );
    }
    if (!isset($assets['et_icons_all'])) {
        $assets_prefix = et_get_dynamic_assets_path();
        $assets['et_icons_all'] = array(
            'css' => "{$assets_prefix}/css/icons_all.css",
        );
    }
    return $assets;
}, 100, 3);

$breakpoint_mobile = DIPI_Settings::get_mobile_menu_breakpoint();
$collapse_submenu_prevent_parent_opening = DIPI_Settings::get_option('collapse_submenu_prevent_parent_opening');

$mobile_menu_font_weight = DIPI_Customizer::get_option('mobile_menu_font_weight');
$mobile_submenu_icon_on_collapse = DIPI_Customizer::get_option('mobile_submenu_icon_on_collapse');
$mobile_submenu_icon_on_collapse_border_radius = DIPI_Customizer::get_option('mobile_submenu_icon_on_collapse_border_radius');
$mobile_submenu_icon_on_collapse_color = DIPI_Customizer::get_option('mobile_submenu_icon_on_collapse_color');
$mobile_submenu_icon_on_collapse_background_color = DIPI_Customizer::get_option('mobile_submenu_icon_on_collapse_background_color');
$mobile_submenu_icon_on_expand = DIPI_Customizer::get_option('mobile_submenu_icon_on_expand');
$mobile_submenu_icon_on_expand_border_radius = DIPI_Customizer::get_option('mobile_submenu_icon_on_expand_border_radius');
$mobile_submenu_icon_on_expand_color = DIPI_Customizer::get_option('mobile_submenu_icon_on_expand_color');
$mobile_submenu_icon_on_expand_background_color = DIPI_Customizer::get_option('mobile_submenu_icon_on_expand_background_color');
?>

<style type="text/css" id="mobile-menu-collapse-submenu-css">
@media all and (max-width: <?php echo esc_html(intval($breakpoint_mobile)); ?>px) {
    body.dipi-collapse-submenu-mobile .et-l--header .et_mobile_menu li .sub-menu,
    body.dipi-collapse-submenu-mobile #main-header .et_mobile_menu li .sub-menu {
        width: 100%;
        overflow: hidden;
        max-height: 0;
        visibility: hidden !important;
    }

    body.dipi-collapse-submenu-mobile .et-l--header .et_mobile_menu li .dipi-collapse-closed,
    body.dipi-collapse-submenu-mobile #main-header .et_mobile_menu li .dipi-collapse-closed {
        width: 100%;
        max-height: 0px;
        display: none !important;
    }
    body.dipi-collapse-submenu-mobile .et-l--header .et_mobile_menu li .dipi-collapse-animating,
    body.dipi-collapse-submenu-mobile #main-header .et_mobile_menu li .dipi-collapse-animating {
        display: block !important;
    }

    body.dipi-collapse-submenu-mobile .et-l--header .et_mobile_menu li .dipi-collapse-opened,
    body.dipi-collapse-submenu-mobile #main-header .et_mobile_menu li .dipi-collapse-opened {
        width: 100%;
        max-height: 3000px;
        display: block !important;
        visibility: visible !important;

    }
    body.dipi-collapse-submenu-mobile .et-l--header .et_mobile_menu li ul.sub-menu,
    body.dipi-collapse-submenu-mobile #main-header .et_mobile_menu li ul.sub-menu{
        -webkit-transition: all 800ms ease-in-out;
        -moz-transition: all 800ms ease-in-out;
        -o-transition: all 800ms ease-in-out;
        transition: all 800ms ease-in-out;
    }

    body.dipi-collapse-submenu-mobile .et_mobile_menu li li {
        padding-left: 0 !important;
    }

    body.dipi-collapse-submenu-mobile .et-l--header .et_mobile_menu li.menu-item-has-children > a,
    body.dipi-collapse-submenu-mobile #main-header .et_mobile_menu li.menu-item-has-children > a {
        cursor: pointer;
        font-weight: <?php echo esc_html($mobile_menu_font_weight); ?> !important;
        position: relative;
    }

    body.dipi-collapse-submenu-mobile .et-l--header .et_mobile_menu li.menu-item-has-children ul li a,
    body.dipi-collapse-submenu-mobile #main-header .et_mobile_menu li.menu-item-has-children ul li a {
        font-weight: <?php echo esc_html($mobile_menu_font_weight); ?> !important;
    }


    body.dipi-collapse-submenu-mobile .et-l--header .et_mobile_menu li.menu-item-has-children>a:before,
    body.dipi-collapse-submenu-mobile #main-header .et_mobile_menu li.menu-item-has-children>a:before,
    body.dipi-collapse-submenu-mobile .et-l--header .et_mobile_menu li.menu-item-has-children>a:after,
    body.dipi-collapse-submenu-mobile #main-header .et_mobile_menu li.menu-item-has-children>a:after  {
        font-size: 18px;
        margin-right: 10px;
        display: inline-block;
        position: absolute;
        right: 5px;
        z-index: 10;
        cursor: pointer;
        font-family: "ETmodules";
        transition-timing-function: ease-in-out;
        transition-property: all;
        transition-duration: .4s;
        width: 1.6rem;
        height: 1.6rem;
        line-height: 1.6rem;
        text-align: center;
        vertical-align: middle;
    }

    /* Submenu closed */
    body.dipi-collapse-submenu-mobile .et-l--header .et_mobile_menu li.menu-item-has-children>a:before,
    body.dipi-collapse-submenu-mobile #main-header .et_mobile_menu li.menu-item-has-children>a:before {
        content: '<?php
            // phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped 
            echo htmlspecialchars_decode($mobile_submenu_icon_on_collapse);
            // phpcs:enable
            ?>';
        color: <?php echo esc_html($mobile_submenu_icon_on_collapse_color) ?>;
        background-color: <?php echo esc_html($mobile_submenu_icon_on_collapse_background_color) ?>;
        border-radius: <?php echo esc_html($mobile_submenu_icon_on_collapse_border_radius); ?>%;
    }


    body.dipi-collapse-submenu-mobile .et-l--header .et_mobile_menu li.menu-item-has-children>a:after,
    body.dipi-collapse-submenu-mobile #main-header .et_mobile_menu li.menu-item-has-children>a:after{
        content: '<?php echo esc_html($mobile_submenu_icon_on_expand) ?>';
        color: <?php echo esc_html($mobile_submenu_icon_on_expand_color) ?>;
        background-color: <?php echo esc_html($mobile_submenu_icon_on_expand_background_color) ?>;
        border-radius: <?php echo esc_html($mobile_submenu_icon_on_expand_border_radius); ?>%;
        transform: rotate(-90deg);
        opacity: 0;
    }

    /* Submenu opened */
    body.dipi-collapse-submenu-mobile .et-l--header .et_mobile_menu li.menu-item-has-children>a.dipi-collapse-menu:before,
    body.dipi-collapse-submenu-mobile #main-header .et_mobile_menu li.menu-item-has-children>a.dipi-collapse-menu:before {
        transform: rotate(90deg);
        opacity: 0;
    }
    body.dipi-collapse-submenu-mobile .et-l--header .et_mobile_menu li.menu-item-has-children>a.dipi-collapse-menu:after,
    body.dipi-collapse-submenu-mobile #main-header .et_mobile_menu li.menu-item-has-children>a.dipi-collapse-menu:after {
        transform: rotate(0deg);
        opacity: 1;
    }

    /* body.dipi-collapse-submenu-mobile .et-l--header .et_mobile_menu li.menu-item-has-children>a:before,
    body.dipi-collapse-submenu-mobile #main-header .et_mobile_menu li.menu-item-has-children>a:before */


}
</style>

<script type="text/javascript" id="mobile-menu-collapse-submenu-js">
jQuery(document).ready(function($) {

    let collapse_submenu_prevent_parent_opening = '<?php echo esc_html($collapse_submenu_prevent_parent_opening); ?>';


    function setupMobileMenuCollapseSubMenu() {
        $('#main-header .mobile_menu_bar, .et-l--header .mobile_menu_bar').click(function() {
            $("#main-header .et_mobile_menu li ul").removeClass('dipi-collapse-opened');
            $("#main-header .et_mobile_menu li ul").addClass('dipi-collapse-closed');
            $("#main-header .et_mobile_menu li ul").prev("a").removeClass('dipi-collapse-menu')

            $(".et-l--header .et_mobile_menu li ul").removeClass('dipi-collapse-opened');
            $(".et-l--header .et_mobile_menu li ul").addClass('dipi-collapse-closed');
            $(".et-l--header .et_mobile_menu li ul").prev("a").removeClass('dipi-collapse-menu')
        });

        // Setup the default Divi header for collapsed submenus
        $("#main-header .et_mobile_menu li ul").prev("a").off('click');
        document.addEventListener('click', function(e){
            if (e.target.matches('#main-header .et_mobile_menu li.menu-item-has-children > a')) {
                $('#main-header .et_mobile_menu').attr('style', "display: block !important");
                // e.preventDefault() // If we use this code, parent link is not working
                handle_event(e, $(e.target))
            }
            
        },true);   
    }

    setupMobileMenuCollapseSubMenu();


    // Since the theme builder will take some time to setup the header and the menu inside it, we need to work around that fact
    // and delay our own setup until Divi has finished. Otherwise our custom functionality won't work
    function setupThemeBuilderMenu(){
        // if there is no theme builder header used or there is no menu in the header, we don't have to setup anything
        if($(".et-l--header").length < 1){
            return;
        }
        
        // If there is no menu module in the header, we don't have to setup anything
        if($(".et-l--header .et_pb_menu").length < 1 && $(".et-l--header .et_pb_menu__menu").length < 1) {
            return;
        }

        // If Divi hasn't finished setting up the mobile menu, we'll try again later
        if($(".et-l--header .et_mobile_menu").length < 1){
            setTimeout(function(){
                setupThemeBuilderMenu()
            }, 100);
        }

        // Setup the click handlers for handling collapsed submenus
        $(".et-l--header .et_mobile_menu li ul").prev("a").off('click').on('click', function(e) {
            $('.et-l--header .et_mobile_menu').attr('style', "display: block !important");
            handle_event(e, $(this))
        });    
    }
    setupThemeBuilderMenu();

    function handle_event(e, $el){
        //If the option to prevent parent pages from opening is enabled, we can skip further calculations
        //and directly pretend that the pseudo element to toggle the submenu was clicked
        if(collapse_submenu_prevent_parent_opening){
            e.preventDefault();
            animate_submenu($el);
            return;
        }
        //Calculate how wide the largest before or after pseudo element is
        let before = window.getComputedStyle(e.target, ':before');
        let after = window.getComputedStyle(e.target, ':after');
        let right = Math.max(parseInt(before.right), parseInt(after.right));
        let width = Math.max(parseInt(before.width), parseInt(after.width));
        let marginRight = Math.max(parseInt(before.marginRight), parseInt(after.marginRight));
        let totalWidth = Math.min(marginRight*2 + width + right, 50);

        //Get the rect of the anchor and calculate where inside it the user clicked
        var rect = e.target.getBoundingClientRect();
        var x = e.clientX - rect.left;

        //If the click was on one of the pseudo elements, the x position will be within the rects rightmost part, which we can
        //determine using the previously calculated width of the widest pseudo element.
        if(x > rect.width - totalWidth){
            e.preventDefault();
            animate_submenu($el);
        }
    }

    function animate_submenu($el){
        $el.toggleClass('dipi-collapse-menu');
        $submenu = $el.next('ul')

        if($submenu.hasClass('dipi-collapse-closed')){
            $submenu.removeClass('dipi-collapse-closed').addClass('dipi-collapse-animating');
            setTimeout(() => {
                $submenu.addClass('dipi-collapse-opened');
            }, 0);

            setTimeout(() => {
                $submenu.removeClass('dipi-collapse-animating');
            }, 800);
        } else {
            $submenu.removeClass('dipi-collapse-opened').addClass('dipi-collapse-animating');
            setTimeout(() => {
                $submenu.addClass('dipi-collapse-closed');
            }, 0);
            setTimeout(() => {
                $submenu.removeClass('dipi-collapse-animating');
            }, 800);
        }
    }
});
</script>