<?php
namespace DiviPixel;
// TODO: Maybe we should position the <ul> element in fullscreen menus fixed and use JS to calculate the top padding
// so that the first menu item appears under the hamburger button but the list in general is still scrollable all 
// the way to the top.
$mobile_menu_animation = DIPI_Customizer::get_option('mobile_menu_animation');
$mobile_menu_dropdown_background = DIPI_Customizer::get_option('mobile_menu_dropdown_background');
$mobile_menu_background_animation = DIPI_Customizer::get_option('mobile_menu_background_animation');

$breakpoint_mobile = DIPI_Settings::get_mobile_menu_breakpoint();

$slide_menu_class = '';

if ('grow' == $mobile_menu_animation):
    $slide_menu_class = 'dipi-menu-animation-grow';
elseif ('slide_left' == $mobile_menu_animation):
    $slide_menu_class = 'dipi-menu-animation-slide-left';
elseif ('slide_right' == $mobile_menu_animation):
    $slide_menu_class = 'dipi-menu-animation-slide-right';
elseif ('slide_bottom' == $mobile_menu_animation):
    $slide_menu_class = 'dipi-menu-animation-slide-bottom';
elseif ('slide_top' == $mobile_menu_animation):
    $slide_menu_class = 'dipi-menu-animation-slide-top';
elseif ('fade' == $mobile_menu_animation):
    $slide_menu_class = 'dipi-menu-animation-fade';
endif;

$mobile_menu_background_animation_class = '';

if ('grow' == $mobile_menu_background_animation):
    $mobile_menu_background_animation_class = 'dipi-menu-background-animation-grow';
elseif ('slide_left' == $mobile_menu_background_animation):
    $mobile_menu_background_animation_class = 'dipi-menu-background-animation-slide-left';
elseif ('slide_right' == $mobile_menu_background_animation):
    $mobile_menu_background_animation_class = 'dipi-menu-background-animation-slide-right';
elseif ('slide_bottom' == $mobile_menu_background_animation):
    $mobile_menu_background_animation_class = 'dipi-menu-background-animation-slide-bottom';
elseif ('slide_top' == $mobile_menu_background_animation):
    $mobile_menu_background_animation_class = 'dipi-menu-background-animation-slide-top';
elseif ('fade' == $mobile_menu_background_animation):
	$mobile_menu_background_animation_class = 'dipi-menu-background-animation-fade';
elseif ('circle' == $mobile_menu_background_animation):
		$mobile_menu_background_animation_class = 'dipi-menu-background-animation-circle';
endif;
?>

<style type="text/css" id="mobile-menu-fullscreen-css">
@media all and (max-width: <?php echo intval($breakpoint_mobile); ?>px){

	body.dipi-mobile-menu-fullscreen .mobile_nav.opened:before {
		visibility: visible;
		background: <?php echo esc_html($mobile_menu_dropdown_background); ?> !important;
		opacity: 1;
	}

	body.dipi-mobile-menu-fullscreen .mobile_nav.closed:before {
		visibility: hidden;
		background: transparent !important;
		opacity: 0;
	}

	body.dipi-mobile-menu-fullscreen .mobile_nav.opened ul.et_mobile_menu {
		opacity: 1;
		transition: all 1s;
		transition-timing-function: cubic-bezier(.79,.14,.15,.86);
	}
	body.dipi-mobile-menu-fullscreen.et-db #et-boc .et-l .mobile_nav.closed ul.et_mobile_menu,
	body.dipi-mobile-menu-fullscreen .mobile_nav.closed ul.et_mobile_menu {
		opacity: 0;
	}

	body.dipi-mobile-menu-fullscreen .mobile_nav:before {
		content: '';
		position: fixed;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		z-index: 99;
		display: block;
		transition: all 1s !important;
		transition-timing-function: cubic-bezier(.79,.14,.15,.86) !important;
		opacity: 0;
		visibility: hidden;
		height: 120vh;
    	top: -20vh;
		
	}

	/* Not working mobile menu when use sticky header & scroll down
		@since 20231204
	*/
	body.dipi-mobile-menu-fullscreen .et_pb_sticky_placeholder .mobile_nav {
		pointer-events: none;
	}

	body.dipi-mobile-menu-fullscreen .mobile_nav.dipi-menu-background-animation-circle:before{
		position: absolute;
		top: calc(20px - 50vh);
    	right: calc(20px - 50vh);
		bottom:auto;left: auto;
		height: 100vh;
    	width: 100vh;
		transform-origin: 50% 50%;
		border-radius:50%;
		background: <?php echo esc_html($mobile_menu_dropdown_background); ?> !important;
		transition-property: transform;
	}
	body.dipi-mobile-menu-fullscreen .mobile_nav.dipi-menu-background-animation-circle.closed:before{
		opacity:0;
		visibility:visible;
		transform: scale(0);
		will-change: transform;
    }
	body.dipi-mobile-menu-fullscreen .mobile_nav.dipi-menu-background-animation-circle.closed.animate:before{
		opacity:1;
	}
	body.dipi-mobile-menu-fullscreen .mobile_nav.dipi-menu-background-animation-circle.opened:before{
		transform: scale(4.8);
		position:fixed;
	}

/* Animation Slide Left */
	.dipi-menu-animation-slide-left.closed #mobile_menu,
	.et-l--header .dipi-menu-animation-slide-left.closed ul.et_mobile_menu {
		transform: translateX(-120%);
	}

	.dipi-menu-animation-slide-left.opened #mobile_menu,
	.et-l--header .dipi-menu-animation-slide-left.opened ul.et_mobile_menu {
		transform: translateX(0);

	}

	.dipi-menu-background-animation-slide-left.closed:before {
		transform: translateX(-100%);
	}

	.dipi-menu-background-animation-slide-left.opened:before {
		transform: translateX(0);
	}

/* Animation Slide Right */
	.dipi-menu-animation-slide-right.closed #mobile_menu ,
	.et-l--header .dipi-menu-animation-slide-right.closed ul.et_mobile_menu {
		transform: translateX(120%);
	}

	.dipi-menu-animation-slide-right.opened #mobile_menu,
	.et-l--header .dipi-menu-animation-slide-right.opened ul.et_mobile_menu {
		transform: translateX(0);
	}

	.dipi-menu-background-animation-slide-right.closed:before {
		transform: translateX(100%);
	}

	.dipi-menu-background-animation-slide-right.opened:before {
		transform: translateX(0);
	}

/* Animation Slide Bottom */
	.dipi-menu-animation-slide-bottom.closed #mobile_menu,
	.et-l--header .dipi-menu-animation-slide-bottom.closed ul.et_mobile_menu {
		transform: translateY(120%);
	}

	.dipi-menu-background-animation-slide-bottom.closed:before {
		transform: translateY(100%);
	}

	.dipi-menu-animation-slide-bottom.opened #mobile_menu,
	.et-l--header .dipi-menu-animation-slide-bottom.opened ul.et_mobile_menu,
	.dipi-menu-background-animation-slide-bottom.opened:before{
		transform: translateY(0);
	}

/* Animation Slide Bottom */

	.dipi-menu-animation-slide-top.closed #mobile_menu,
	.et-l--header .dipi-menu-animation-slide-top.closed ul.et_mobile_menu{
		transform: translateY(-120%);
	}

	.dipi-menu-animation-slide-top.opened #mobile_menu,
	.et-l--header .dipi-menu-animation-slide-top.opened ul.et_mobile_menu,
	.dipi-menu-background-animation-slide-top.opened:before{
		transform: translateY(0);
	}

	.dipi-menu-background-animation-slide-top.closed:before {
		transform: translateY(-100%);
	}

	/* Animation Grow */
	.et-db #et-boc .et-l .dipi-menu-animation-grow.closed .et_mobile_menu,
	.dipi-menu-animation-grow.closed #mobile_menu,
	.et-l--header .dipi-menu-animation-grow.closed ul.et_mobile_menu,
	.dipi-menu-background-animation-grow.closed:before {
		transform: scale(.5);
		opacity: 0;
		visibility: hidden;
	}

	.et-db #et-boc .et-l .et_pb_module .dipi-menu-animation-grow .mobile_menu_bar:before{content:none;}
	
	#main-header .mobile_nav.closed .et_mobile_menu li ul,
	.et_pb_fullwidth_menu .mobile_nav.closed .et_mobile_menu li ul,
	.et_pb_menu .mobile_nav.closed .et_mobile_menu li ul{
		visibility: hidden !important;
	}

	.dipi-menu-animation-grow.opened #mobile_menu,
	.et-l--header .dipi-menu-animation-grow.opened ul.et_mobile_menu,
	.dipi-menu-background-animation-grow.opened:before {
		transform: scale(1);
		opacity: 1;
		visibility: visible;
	}

/* Animation Fade In */
	.dipi-menu-animation-fade.closed #mobile_menu,
	.et-db #et-boc .et-l--header .dipi-menu-animation-fade.closed ul.et_mobile_menu,
	.et-l--header .dipi-menu-animation-fade.closed ul.et_mobile_menu,
	.dipi-menu-background-animation-fade.closed:before {
		opacity: 0;
		visibility: hidden;
	}

	.dipi-menu-animation-fade.opened #mobile_menu,
	.et-db #et-boc .et-l--header .dipi-menu-animation-fade.opened .et_mobile_menu,
	.et-l--header .dipi-menu-animation-fade.opened .et_mobile_menu,
	.dipi-menu-background-animation-fade.opened:before {
		opacity: 1;
		visibility: visible;
	}

/* Overlay Background */
	body.dipi-mobile-menu-fullscreen .mobile_nav.closed:before {
		transition-duration: .7s !important;
		transition-delay: .2s;
		transition-timing-function: cubic-bezier(.79,.14,.15,.86);
	}
	
	body.dipi-mobile-menu-fullscreen .mobile_nav.opened:before {
		transition-duration: .7s !important;
		transition-timing-function: cubic-bezier(.79,.14,.15,.86);
	}
	
	body.dipi-mobile-menu-fullscreen .mobile_nav.dipi-menu-background-animation-circle.opened:before {
		transition-duration: .8s !important;
	}
	body.dipi-mobile-menu-fullscreen .mobile_nav.dipi-menu-background-animation-circle.closed:before {
		transition-duration: .5s !important;
	}

	/* Menu Links */
	.mobile_nav.closed #mobile_menu,
	.et-l--header .mobile_nav.closed ul.et_mobile_menu {
		transition-duration: .5s;
	}

	.mobile_nav.opened #mobile_menu,
	.et-l--header .mobile_nav.opened ul.et_mobile_menu {
		transition-duration: .5s;
		transition-delay: .2s !important;
	}

	#mobile_menu,
	.et-l--header .mobile_nav .et_mobile_menu {
		display: block !important;
		position: absolute;
		z-index: 9998;
		width: 100%;
	}

	body.dipi-mobile-menu-fullscreen #mobile_menu,
	body.dipi-mobile-menu-fullscreen .et-l--header .et_mobile_nav_menu .et_mobile_menu {
		top: 0;
		min-height: 100vh;
		background: transparent !important;
		border-top: none !important;
		box-shadow: none !important;
		list-style: none;
	}

	#main-header .mobile_menu_bar,
	.et-l--header .mobile_menu_bar {
		z-index: 10001;
	}
}
</style>

<script type="text/javascript" id="mobile-menu-fullscreen-js">
jQuery(document).ready(function($){
	$(".mobile_nav").addClass("<?php echo esc_attr($slide_menu_class); ?>");
	$(".mobile_nav").addClass("<?php echo esc_attr($mobile_menu_background_animation_class); ?>");
	$(".mobile_menu_bar_toggle").on('click', function(){
		$(".mobile_nav").addClass('animate')
		setTimeout(() => {
			$(".mobile_nav").removeClass('animate')
		}, 700);
	})

});
</script>