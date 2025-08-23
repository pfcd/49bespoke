<?php 
namespace DiviPixel;

$mobile_menu_hamburger_color = DIPI_Customizer::get_option('mobile_menu_hamburger_color');
$mobile_menu_hamburger_color_opened = DIPI_Customizer::get_option('mobile_menu_hamburger_color_opened');
$mobile_menu_hamburger_boxed = DIPI_Customizer::get_option('mobile_menu_hamburger_boxed');
$mobile_menu_hamburger_boxed_bg_color = DIPI_Customizer::get_option('mobile_menu_hamburger_boxed_bg_color');
$mobile_menu_hamburger_boxed_bg_color_opened = DIPI_Customizer::get_option('mobile_menu_hamburger_boxed_bg_color_opened');
$mobile_menu_hamburger_boxed_border_radius = DIPI_Customizer::get_option('mobile_menu_hamburger_boxed_border_radius');
$mobile_menu_hamburger_boxed_box_padding = DIPI_Customizer::get_option('mobile_menu_hamburger_boxed_box_padding');

$breakpoint_mobile = DIPI_Settings::get_mobile_menu_breakpoint();

?>

<style type="text/css" id="mobile-menu-hamburger-css">
<?php if($mobile_menu_hamburger_boxed) : ?>
.dipi_hamburger.hamburger {
	background-color: <?php echo esc_html($mobile_menu_hamburger_boxed_bg_color); ?> !important;
	border-radius: <?php echo esc_html($mobile_menu_hamburger_boxed_border_radius); ?>px !important;
	padding-top: <?php echo esc_html($mobile_menu_hamburger_boxed_box_padding + 2); ?>px !important;
	padding-bottom: <?php echo esc_html($mobile_menu_hamburger_boxed_box_padding + 1); ?>px !important;
	padding-left: <?php echo esc_html($mobile_menu_hamburger_boxed_box_padding); ?>px !important;
	padding-right: <?php echo esc_html($mobile_menu_hamburger_boxed_box_padding); ?>px !important;
}
.dipi_hamburger.hamburger.is-active {
	background-color: <?php echo esc_html($mobile_menu_hamburger_boxed_bg_color_opened); ?> !important;
}

<?php endif; ?>

.dipi_hamburger .hamburger-inner, 
.dipi_hamburger .hamburger-inner:after, 
.dipi_hamburger .hamburger-inner:before {
	background-color: <?php echo esc_html($mobile_menu_hamburger_color); ?> !important;
}

.dipi_hamburger.hamburger.is-active .hamburger-inner, 
.dipi_hamburger.hamburger.is-active .hamburger-inner:after, 
.dipi_hamburger.hamburger.is-active .hamburger-inner:before {
	background-color: <?php echo esc_html($mobile_menu_hamburger_color_opened); ?> !important;
}
.dipi_hamburger.hamburger.hamburger--spring.is-active .hamburger-inner,
.dipi_hamburger.hamburger.hamburger--stand.is-active .hamburger-inner{
	background-color: transparent !important;
}

@media (max-width: <?php echo esc_html($breakpoint_mobile); ?>px) {
	.et_pb_module.et_pb_fullwidth_menu div.et_pb_menu__wrap,
	.et_pb_module.et_pb_menu div.et_pb_menu__wrap {
		margin: 0;
	}

	.et_pb_module.et_pb_fullwidth_menu div.et_pb_menu__wrap .et_mobile_nav_menu,
	.et_pb_module.et_pb_menu div.et_pb_menu__wrap .et_mobile_nav_menu {
		margin-right: 0;
	}

	.et_pb_fullwidth_menu .et_mobile_menu ul, 
	.et_pb_menu .et_mobile_menu ul {
		padding: 0;
	}

	.et_pb_fullwidth_menu .mobile_menu_bar, 
	.et_pb_menu .mobile_menu_bar {
		display: inline;
	}
	@media only screen and (max-width: 980px) {
		.et_header_style_centered:has(.dipi_hamburger) div#et-top-navigation {pointer-events: none;}
		.et_header_style_centered:has(.dipi_hamburger) span.mobile_menu_bar.mobile_menu_bar_toggle {pointer-events: all;}
		.et_header_style_centered:has(.dipi_hamburger) ul#mobile_menu { pointer-events: all;}
	}
}
</style>