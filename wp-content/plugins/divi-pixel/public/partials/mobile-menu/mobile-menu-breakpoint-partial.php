<?php
namespace DiviPixel;
$breakpoint_mobile = DIPI_Settings::get_mobile_menu_breakpoint();

/* If mobile breakpoint is larger than Divis default, we need to apply
 * Divi core styles from Divi/style.dev.css */
if($breakpoint_mobile > 980){
	include plugin_dir_path(__FILE__) . '/mobile-menu-breakpoint-divi-core-partial.php';
}
?>
<style type="text/css" id="mobile-menu-breakpoint-css">
body.dipi-menu-custom-breakpoint #et_mobile_nav_menu {
	display: none !important;
}

body.dipi-menu-custom-breakpoint #top-menu {
	display: block !important;
	white-space: nowrap; /* Fix cta wrapping  */
}
body.dipi-menu-custom-breakpoint #top-menu > * {
	white-space: normal;
}
/* .et_header_style_centered body.dipi-menu-custom-breakpoint #top-menu {
	display: flex;
	align-items: center;
} */

@media (max-width: <?php echo esc_html($breakpoint_mobile); ?>px) {

	body.dipi-menu-custom-breakpoint #top-menu,
	body.dipi-menu-custom-breakpoint #menu-main {
		display: none !important;
	}

	body.dipi-menu-custom-breakpoint #et_mobile_nav_menu {
		display: block !important;
	}

	.et_header_style_split #et_top_search {
    	display: none!important;
	}

	.et_header_style_split .et_menu_container .mobile_menu_bar {
		position: absolute;
		right: 5px;
		top: 2px;
	}

	.et_header_style_centered #main-header .container,
	.et_header_style_split #main-header .container {
		height: auto;
	}

	.et_header_style_centered #et_mobile_nav_menu,
	.et_header_style_split #et_mobile_nav_menu {
		float: none;
		position: relative;
		margin-top: 20px;
		display: block;
	}
	
	.et_header_style_split #main-header {
		padding: 20px 0;
	}

	.et_header_style_split .dipi_logo_container span.logo_helper,
	.et_header_style_split .dipi_logo_container #dipi_logo {
		display: inline-block;
	}

	.et_header_style_split.et_header_style_split #et-top-navigation, 
	.et_header_style_split.et_header_style_split .et-fixed-header #et-top-navigation {
		padding-top: 0;
	}

	.et_header_style_split .logo_container {
		display: none;
	}

	#et-top-navigation #et_top_search {
		margin: 0 35px 0 0;
    	float: left;
	}
	#et-top-navigation #et_top_search #et_search_icon:before {
		top: 7px;
	}

	.et_header_style_fullscreen #main-header #et-top-navigation #et_mobile_nav_menu,
	.et_header_style_slide #main-header #et-top-navigation #et_mobile_nav_menu {
		display: none !important;
	}
}

@media (min-width: <?php echo esc_html($breakpoint_mobile + 1); ?>px) {
	.et_header_style_centered nav#top-menu-nav#top-menu-nav,
	.et_header_style_split nav#top-menu-nav#top-menu-nav {
		display: inline-block;
	}

	.dipi_logo_container {
		display: none;
	}
}	
</style>

<script id="mobile-menu-breakpoint-js">
jQuery(document).ready(function($) {
	let $body = $("body");
	if($body.hasClass("et_header_style_split")){
		let $dipi_logo_container = $(".logo_container").clone();
		
		$dipi_logo_container.removeClass("logo_container")
			.addClass("dipi_logo_container")
			.prependTo(".et_menu_container");

		$dipi_logo_container.find("#logo").attr("id","dipi_logo");
	}
});
</script>