<?php
namespace DiviPixel;

$mobile_menu_hide_bar = DIPI_Customizer::get_option('mobile_menu_hide_bar'); //FIXME: Default was true
$mobile_menu_full_width = DIPI_Customizer::get_option('mobile_menu_full_width');
$mobile_menu_header_height = DIPI_Customizer::get_option('mobile_menu_header_height');
$mobile_menu_logo_size = DIPI_Customizer::get_option('mobile_menu_logo_size'); //FIXME: Default was '60'
$mobile_menu_logo_width = DIPI_Customizer::get_option('mobile_menu_logo_width'); 
$mobile_menu_bar_color = DIPI_Customizer::get_option('mobile_menu_bar_color');
$mobile_menu_shadow = DIPI_Customizer::get_option('mobile_menu_shadow');
$mobile_menu_shadow_color = DIPI_Customizer::get_option('mobile_menu_shadow_color');
$mobile_menu_shadow_offset = DIPI_Customizer::get_option('mobile_menu_shadow_offset');
$mobile_menu_shadow_blur = DIPI_Customizer::get_option('mobile_menu_shadow_blur');
$mobile_menu_font = DIPI_Customizer::get_option('mobile_menu_font');
$mobile_menu_font_weight = DIPI_Customizer::get_option('mobile_menu_font_weight');
$mobile_menu_text_size = DIPI_Customizer::get_option('mobile_menu_text_size');
$mobile_menu_letter_spacing = DIPI_Customizer::get_option('mobile_menu_letter_spacing');
$mobile_menu_link_paddings = DIPI_Customizer::get_option('mobile_menu_link_paddings');
$mobile_menu_text_color = DIPI_Customizer::get_option('mobile_menu_text_color');
$mobile_menu_dropdown_background = DIPI_Customizer::get_option('mobile_menu_dropdown_background');
$mobile_menu_text_align = DIPI_Customizer::get_option('mobile_menu_text_align');
$mobile_menu_text_bottom_margin = DIPI_Customizer::get_option('mobile_menu_text_bottom_margin');
$mobile_menu_border_size = DIPI_Customizer::get_option('mobile_menu_border_size');
$mobile_menu_border_color = DIPI_Customizer::get_option('mobile_menu_border_color');
$mobile_menu_item_background = DIPI_Customizer::get_option('mobile_menu_item_background');
$mobile_menu_border_radii = DIPI_Customizer::get_option('mobile_menu_border_radii');
$mobile_menu_padding = DIPI_Customizer::get_option('mobile_menu_padding');
$mobile_menu_item_shadow = DIPI_Customizer::get_option('mobile_menu_item_shadow');
$mobile_menu_item_shadow_color = DIPI_Customizer::get_option('mobile_menu_item_shadow_color');
$mobile_menu_item_shadow_offset = DIPI_Customizer::get_option('mobile_menu_item_shadow_offset');
$mobile_menu_item_shadow_blur = DIPI_Customizer::get_option('mobile_menu_item_shadow_blur');
$breakpoint_mobile = DIPI_Settings::get_mobile_menu_breakpoint();

//Sub Menu item shadow
$mobile_submenu_item_shadow = DIPI_Customizer::get_option('mobile_submenu_item_shadow');
$mobile_submenu_item_shadow_color = DIPI_Customizer::get_option('mobile_submenu_item_shadow_color');
$mobile_submenu_item_shadow_offset = DIPI_Customizer::get_option('mobile_submenu_item_shadow_offset');
$mobile_submenu_item_shadow_blur = DIPI_Customizer::get_option('mobile_submenu_item_shadow_blur');

?>

<style type="text/css" id="mobile-menu-styles-css">

@media screen and (max-width: <?php echo esc_html(intval($breakpoint_mobile)); ?>px) {

	#main-header {
		display: flex;
		flex-direction: column;
		align-items: center;
		height: <?php echo esc_html($mobile_menu_header_height); ?>px !important;
		background: <?php echo esc_html($mobile_menu_bar_color); ?> !important;
		<?php if ($mobile_menu_shadow): ?>
		box-shadow: 0px <?php echo esc_html($mobile_menu_shadow_offset); ?>px <?php echo esc_html($mobile_menu_shadow_blur); ?>px <?php echo esc_html($mobile_menu_shadow_color); ?> !important;
		<?php endif;?>
	}

	.et_header_style_left .et-fixed-header #et-top-navigation, .et_header_style_left #et-top-navigation,
	.et_header_style_fullscreen #et-top-navigation, .et_header_style_fullscreen #et-top-navigation {
		padding-top:0 !important;
	}
	.et_header_style_split #et-top-navigation .mobile_menu_bar, .et_header_style_left #et-top-navigation .mobile_menu_bar,
	.et_header_style_fullscreen #et-top-navigation, .et_header_style_fullscreen #et-top-navigation {
		padding-bottom:0 !important;
	}

	#main-header #et_top_search {
		margin: 0 35px 0 0;
	}

	#main-header #et_top_search #et_search_icon:before {
		top: 7px;
	}

	#top-header .container #et-info {
		width: 100% !important;
    	text-align: center;
	}

	.et-l--header {
		height: <?php echo esc_html($mobile_menu_header_height); ?>px !important;
		background: <?php echo esc_html($mobile_menu_bar_color); ?> !important;
		<?php if ($mobile_menu_shadow): ?>
		box-shadow: 0px <?php echo esc_html($mobile_menu_shadow_offset); ?>px <?php echo esc_html($mobile_menu_shadow_blur); ?>px <?php echo esc_html($mobile_menu_shadow_color); ?> !important;
		<?php endif;?>
	}

	<?php if (isset($mobile_menu_logo_size)): ?>
	.et_header_style_left #logo {
		max-height: <?php echo esc_html($mobile_menu_logo_size); ?>px !important;
		height: auto !important;
	}

	.et_header_style_split header#main-header #dipi_logo,
	.et_header_style_centered header#main-header #logo {
		max-height: <?php echo esc_html($mobile_menu_logo_size); ?>px !important;
		height: auto !important;
		margin: 0 auto !important;
		width: auto;
	}
	<?php endif?>
	<?php if (isset($mobile_menu_logo_width)): ?>
	.et_header_style_left #logo,
	.et_header_style_split header#main-header #dipi_logo,
	.et_header_style_centered header#main-header #logo
	{
		width: <?php echo esc_html($mobile_menu_logo_width); ?>px !important;
	}
	<?php endif?>
	body.dipi-mobile-menu-fullscreen #mobile_menu,
	body.dipi-mobile-menu-fullscreen .et-l--header .et_mobile_nav_menu .et_mobile_menu,
	header .et_mobile_menu {
		background: <?php echo esc_html($mobile_menu_dropdown_background); ?> !important;
		/*padding-top: 0px !important;*/
		padding-right: <?php echo esc_html($mobile_menu_padding[1]) ?>px !important;
		/*padding-bottom: 0px !important;*/
		padding-left: <?php echo esc_html($mobile_menu_padding[3]) ?>px !important;
	}
	body.dipi-mobile-menu-fullscreen #mobile_menu:before,
	body.dipi-mobile-menu-fullscreen .et-l--header .et_mobile_nav_menu .et_mobile_menu:before,
	header .et_mobile_menu:before {
		content:'';
		display: block;
		height: <?php echo esc_html($mobile_menu_padding[0]) ?>px !important;
		<?php // echo $mobile_menu_padding[2]; ?>
	}
	body.dipi-mobile-menu-fullscreen #mobile_menu:after,
	body.dipi-mobile-menu-fullscreen .et-l--header .et_mobile_nav_menu .et_mobile_menu:after,
	header .et_mobile_menu:after {
		content:'';display:block;
		height: <?php echo esc_html($mobile_menu_padding[2]) ?>px !important;
	}

	header .et_mobile_menu li:not(:last-child) a{
		margin-bottom: <?php echo esc_html($mobile_menu_text_bottom_margin); ?>px !important;
	}

	header .et_mobile_menu li > a + ul {
		/* margin-top: <?php echo esc_html($mobile_menu_text_bottom_margin); ?>px !important; */
	}

	header .et_mobile_menu > li > a{
		text-align: <?php echo esc_html($mobile_menu_text_align); ?> !important;
	}

	header .et-menu li {
		margin-bottom: <?php echo esc_html($mobile_menu_text_bottom_margin); ?>px !important;
		text-align: <?php echo esc_html($mobile_menu_text_align); ?> !important;
	}

	header .et_mobile_menu > li > a,
	header .et-menu > li > a {
		<?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($mobile_menu_font)), 'html'); ?>
		<?php echo esc_html(DIPI_Customizer::print_font_style_option("mobile_menu_font_style")); ?>
		background-color: <?php echo esc_html($mobile_menu_item_background); ?> !important;
		padding-top: <?php echo esc_html($mobile_menu_link_paddings[0]) ?>px !important;
        padding-right: <?php echo esc_html($mobile_menu_link_paddings[1]) ?>px !important;
        padding-bottom: <?php echo esc_html($mobile_menu_link_paddings[2]) ?>px !important;
        padding-left: <?php echo esc_html($mobile_menu_link_paddings[3]) ?>px !important;
		font-size:<?php echo esc_html($mobile_menu_text_size); ?>px !important;
		color:<?php echo esc_html($mobile_menu_text_color); ?> !important;
		letter-spacing: <?php echo esc_html($mobile_menu_letter_spacing); ?>px !important;
		font-weight: <?php echo esc_html($mobile_menu_font_weight); ?>;
		border-top-left-radius:<?php echo esc_html($mobile_menu_border_radii[0]); ?>px;
		border-top-right-radius:<?php echo esc_html($mobile_menu_border_radii[1]); ?>px;
		border-bottom-left-radius:<?php echo esc_html($mobile_menu_border_radii[2]); ?>px;
		border-bottom-right-radius:<?php echo esc_html($mobile_menu_border_radii[3]); ?>px;
		border-width: <?php echo esc_html($mobile_menu_border_size); ?>px !important;
		border-style: solid !important;
		border-color: <?php echo esc_html($mobile_menu_border_color); ?> !important;
		<?php if ($mobile_menu_item_shadow): ?>
			box-shadow: 0px <?php echo esc_html($mobile_menu_item_shadow_offset); ?>px <?php echo esc_html($mobile_menu_item_shadow_blur); ?>px <?php echo esc_html($mobile_menu_item_shadow_color); ?> !important;
		<?php endif;?>
	}

	.et-l--header .et_mobile_menu li > ul.sub-menu > li > a,
	header .et_mobile_menu li > ul.sub-menu > li > a {
		<?php if ($mobile_submenu_item_shadow): ?>
			box-shadow: 0px <?php echo esc_html($mobile_submenu_item_shadow_offset); ?>px <?php echo esc_html($mobile_submenu_item_shadow_blur); ?>px <?php echo esc_html($mobile_submenu_item_shadow_color); ?> !important;
		<?php endif;?>
	}

	header .et_mobile_menu li.menu-item-has-children > a,
	header .et-menu li.menu-item-has-children > a {
		font-weight: <?php echo esc_html($mobile_menu_font_weight); ?> !important;
	}

	<?php if ($mobile_menu_hide_bar): ?>
	div#top-header {
		display: none !important;
	}
	<?php endif;?>

	<?php if ($mobile_menu_full_width): ?>
	.et_menu_container, .et-l--header .et_pb_row {
		width: 95% !important;
	}
	<?php endif;?>

	.et_header_style_centered header#main-header.et-fixed-header .logo_container.logo_container {
		height: auto !important;
	}

	#main-header .et_mobile_menu li li,
	#main-header .et_mobile_menu li ul.sub-menu {
		padding-left: 0;
	}
}
</style>