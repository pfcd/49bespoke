<?php
namespace DiviPixel;

$use_social_icons_menu = DIPI_Settings::get_option('social_icons_menu');
$use_individual_location = DIPI_Settings::get_option('social_icons_individual_location');
$enable_menu_button = DIPI_Settings::get_option('menu_button');

$menu_height = absint( et_get_option( 'menu_height', '66' ) );
$fixed_menu_height = absint( et_get_option( 'minimized_menu_height', '40' ) );

$breakpoint_mobile = DIPI_Settings::get_mobile_menu_breakpoint();

$social_icon_size = DIPI_Customizer::get_option('social_icon_size');
$social_icon_hover_effect = DIPI_Customizer::get_option('social_icon_hover_effect');
$social_icon_color = DIPI_Customizer::get_option('social_icon_color');
$social_icon_hover_color = DIPI_Customizer::get_option('social_icon_hover_color');
$social_icon_box_style = DIPI_Customizer::get_option('social_icon_box_style');
$social_icon_box_radius = DIPI_Customizer::get_option('social_icon_box_radius');
$social_icon_box_background = DIPI_Customizer::get_option('social_icon_box_background');
$social_icon_box_background_hover = DIPI_Customizer::get_option('social_icon_box_background_hover');
$social_icon_shadow = DIPI_Customizer::get_option('social_icon_shadow');
$social_icon_shadow_color = DIPI_Customizer::get_option('social_icon_shadow_color');
$social_icon_shadow_offset = DIPI_Customizer::get_option('social_icon_shadow_offset');
$social_icon_shadow_blur = DIPI_Customizer::get_option('social_icon_shadow_blur');
$social_icon_shadow_hover = DIPI_Customizer::get_option('social_icon_shadow_hover');
$social_icon_shadow_color_hover = DIPI_Customizer::get_option('social_icon_shadow_color_hover');
$social_icon_shadow_offset_hover = DIPI_Customizer::get_option('social_icon_shadow_offset_hover');
$social_icon_shadow_blur_hover = DIPI_Customizer::get_option('social_icon_shadow_blur_hover');
$social_icon_box_padding = DIPI_Customizer::get_option('social_icon_box_padding'); 
$footer_social_icon_color = DIPI_Customizer::get_option('footer_social_icon_color');
$footer_social_icon_hover_color = DIPI_Customizer::get_option('footer_social_icon_hover_color');
$footer_social_icon_size = DIPI_Customizer::get_option('footer_social_icon_size');
$footer_social_icon_padding = DIPI_Customizer::get_option('footer_social_icon_padding');
$footer_social_icon_box_radius = DIPI_Customizer::get_option('footer_social_icon_box_radius');
$footer_social_icon_box_background = DIPI_Customizer::get_option('footer_social_icon_box_background');
$footer_social_icon_box_background_hover = DIPI_Customizer::get_option('footer_social_icon_box_background_hover');
$footer_social_icon_shadow = DIPI_Customizer::get_option('footer_social_icon_shadow');
$footer_social_icon_shadow_color = DIPI_Customizer::get_option('footer_social_icon_shadow_color');
$footer_social_icon_shadow_offset = DIPI_Customizer::get_option('footer_social_icon_shadow_offset');
$footer_social_icon_shadow_blur = DIPI_Customizer::get_option('footer_social_icon_shadow_blur');
$footer_social_icon_shadow_hover = DIPI_Customizer::get_option('footer_social_icon_shadow_hover');
$footer_social_icon_shadow_color_hover = DIPI_Customizer::get_option('footer_social_icon_shadow_color_hover');
$footer_social_icon_shadow_offset_hover = DIPI_Customizer::get_option('footer_social_icon_shadow_offset_hover');
$footer_social_icon_shadow_blur_hover = DIPI_Customizer::get_option('footer_social_icon_shadow_blur_hover');
$footer_social_icon_spacing = DIPI_Customizer::get_option('footer_social_icon_spacing');
$mobile_social_icon_color = DIPI_Customizer::get_option('mobile_social_icon_color'); 
$mobile_social_icon_hover_color = DIPI_Customizer::get_option('mobile_social_icon_hover_color'); 
$mobile_social_icon_size = DIPI_Customizer::get_option('mobile_social_icon_size'); 
$mobile_social_icon_box_style = DIPI_Customizer::get_option('mobile_social_icon_box_style'); 
$mobile_social_icon_box_padding = DIPI_Customizer::get_option('mobile_social_icon_box_padding'); 
$mobile_social_icon_box_radius = DIPI_Customizer::get_option('mobile_social_icon_box_radius'); 
$mobile_social_icon_box_background = DIPI_Customizer::get_option('mobile_social_icon_box_background'); 
$mobile_social_icon_box_background_hover = DIPI_Customizer::get_option('mobile_social_icon_box_background_hover'); 
$mobile_social_icon_box_shadow = DIPI_Customizer::get_option('mobile_social_icon_box_shadow'); 
$mobile_social_icon_shadow_color = DIPI_Customizer::get_option('mobile_social_icon_shadow_color'); 
$mobile_social_icon_shadow_offset = DIPI_Customizer::get_option('mobile_social_icon_shadow_offset'); 
$mobile_social_icon_shadow_blur = DIPI_Customizer::get_option('mobile_social_icon_shadow_blur');
$mobile_social_icon_alignment = DIPI_Customizer::get_option('mobile_social_icon_alignment');
?>

<style type="text/css" id="social-icon-css">

	#et-top-navigation {
		display: flex;
	}
	
	.dipi-social-icons {
		display: flex;
		margin: 0 0 0 22px;
		position: relative;
		align-items: center;
		justify-content: flex-end;
	}

	.et_header_style_fullscreen .dipi-social-icons,
	.et_header_style_slide .dipi-social-icons {
		margin: 0 10px;
		justify-content: center;
	}

	.et_header_style_fullscreen #main-header #et-top-navigation .dipi-social-icons,
	.et_header_style_slide #main-header #et-top-navigation .dipi-social-icons {
		display: none !important;
	}

	
	.et_header_style_left #main-header #et-top-navigation .dipi-social-icons {
		<?php if($enable_menu_button == '1'):  ?>
			margin: 5px 0 0 22px;
		<?php else: ?>
			margin: -0.6em 0 0 22px;
		<?php endif; ?>
		
	}

	.et_vertical_nav #main-header #et-top-navigation .dipi-social-icons {
    	margin: 15px 0;
    	float: left;
    }

	.et_header_style_split #main-header #et-top-navigation .dipi-social-icons,
	.et_header_style_centered #main-header #et-top-navigation .dipi-social-icons {
		align-items: baseline;
		margin: 5px 0 0 22px;
	}

	.dipi-social-icon:not(:last-child) {
	    margin: 0 10px 0 0;
	}

	.dipi-social-icons a {
		opacity: 1 !important;
	}
	
	.et_pb_menu_visible .dipi-primary-menu-social-icons {
		z-index: 99;
		opacity: 1;
		-webkit-animation: fadeInBottom 1s 1 cubic-bezier(.77,0,.175,1);
		-moz-animation: fadeInBottom 1s 1 cubic-bezier(.77,0,.175,1);
		-o-animation: fadeInBottom 1s 1 cubic-bezier(.77,0,.175,1);
		animation: fadeInBottom 1s 1 cubic-bezier(.77,0,.175,1);
	}
	
	.et_pb_menu_hidden .dipi-primary-menu-social-icons {
		opacity: 0;
	    -webkit-animation: fadeOutBottom 1s 1 cubic-bezier(.77,0,.175,1);
	    -moz-animation: fadeOutBottom 1s 1 cubic-bezier(.77,0,.175,1);
	    -o-animation: fadeOutBottom 1s 1 cubic-bezier(.77,0,.175,1);
	    animation: fadeOutBottom 1s 1 cubic-bezier(.77,0,.175,1);
	}

	.dipi-secondary-menu-social-icons {
		margin: 0 0 5px 10px;
	}

	.dipi-primary-menu-social-icons .dipi-social-icon,
	.dipi-secondary-menu-social-icons .dipi-social-icon {
		display: flex;
  		box-sizing: content-box;
	}

	
	.dipi-primary-menu-social-icons .dipi-social-icon > a > span,
	.dipi-secondary-menu-social-icons .dipi-social-icon > a > span:nth-of-type(1){
		width: <?php echo esc_html($social_icon_size); ?>px;
    	height: <?php echo esc_html($social_icon_size); ?>px;
	}
	

	.dipi-primary-menu-social-icons a .dipi-icon svg, 
	.dipi-secondary-menu-social-icons a .dipi-icon svg {
		fill: <?php echo esc_html($social_icon_color); ?>;
		transition: all .4s ease-in-out;
	}
	
	.dipi-primary-menu-social-icons a .dipi-icon, 
	.dipi-secondary-menu-social-icons a .dipi-icon {
		width: 100%;
		height: 100%;
		overflow: hidden;
		display: grid;
	}

	.dipi-primary-menu-social-icons a, 
	.dipi-secondary-menu-social-icons a {
		/* padding: 0 !important; */
		border-bottom: 0 !important;
		width: 100%;
		height: 100%;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.dipi-primary-menu-social-icons .dipi-social-icon:hover .dipi-icon svg,
	.dipi-secondary-menu-social-icons .dipi-social-icon:hover .dipi-icon svg {
		fill: <?php echo esc_html($social_icon_hover_color); ?>;
		transition: all .4s ease-in-out;
	}

	.dipi-primary-menu-social-icons .dipi-social-icon-box-style a,
	.dipi-secondary-menu-social-icons .dipi-social-icon-box-style {
    	padding: <?php echo esc_html($social_icon_box_padding); ?>px;
  		box-sizing: content-box !important;
    	border-radius: <?php echo esc_html($social_icon_box_radius); ?>px;
		background-color: <?php echo esc_html($social_icon_box_background); ?>;
		<?php if($social_icon_shadow) : ?>
		box-shadow: 0 <?php echo esc_html($social_icon_shadow_offset); ?>px <?php echo esc_html($social_icon_shadow_blur); ?>px <?php echo esc_html($social_icon_shadow_color); ?>;
		<?php endif; ?>
		transition: all .4s ease-in-out;
	}

	.dipi-primary-menu-social-icons .dipi-social-icon.dipi-social-icon-box-style:hover a,
	.dipi-secondary-menu-social-icons .dipi-social-icon.dipi-social-icon-box-style:hover  {
		background-color: <?php echo esc_html($social_icon_box_background_hover); ?>;
		<?php if($social_icon_shadow_hover) : ?>
		box-shadow: 0 <?php echo esc_html($social_icon_shadow_offset_hover); ?>px <?php echo esc_html($social_icon_shadow_blur_hover); ?>px <?php echo esc_html($social_icon_shadow_color_hover); ?>;
		<?php endif; ?>
		transition: all .4s ease-in-out;
	}
	
	@media screen and (min-width: <?php echo intval($breakpoint_mobile) + 1; ?>px) {

		<?php if('primary' == $use_social_icons_menu && 'on' !== $use_individual_location) : ?>

			
			
			.et_header_style_centered #top-menu>li>a,

			.et_header_style_split #et-top-navigation,
			.et_header_style_centered #main-header div#et-top-navigation {
				justify-content: center !important;
				align-items: center;
			}

			.et_header_style_split .dipi-social-icons {
				margin: 0 0 5px 22px !important;
				display: inline-flex;
			}
			
			.et_header_style_centered #et-top-navigation .dipi-social-icons {
				margin: 0 0 10px 22px !important;
			}

			#et_search_icon#et_search_icon:before {
				position: relative;
        		top: 0;
			}

		<?php elseif ('on' == $use_individual_location || is_customize_preview()) : ?>
			
			.et_header_style_split #et-top-navigation,
			.et_header_style_left #et-top-navigation {
				display: flex;
	        	align-items: center;
	        	padding-top: <?php echo esc_html($menu_height/2); ?>px !important;
	        	padding-bottom: <?php echo esc_html($menu_height/2); ?>px !important;
			}
			
			.et_header_style_left #et-top-navigation nav > ul > li > a,
			.et_header_style_split #et-top-navigation nav > ul > li > a{
	        	padding-bottom: 0px !important;
	    	}

			.et_header_style_split #et-top-navigation,
			.et_header_style_centered #main-header div#et-top-navigation {
				justify-content: center !important;
			}

			/*.et_header_style_split .dipi-social-icons,
			.et_header_style_centered .dipi-social-icons {
				margin: 0 !important;
			}*/

			#et_top_search {
				margin-top: 0 !important;
			}

			#et_search_icon:before {
				position: relative;
        		top: 0;
			}
		<?php endif; ?>

	}

	/**
	 * Footer social
	 */
	.dipi-footer-menu-social-icons {
		display: flex !important;
		justify-content: flex-end !important;
		margin: 0;
		/* margin-top: <?php echo esc_html($footer_social_icon_spacing); ?>px !important; */
		margin-bottom: <?php echo esc_html($footer_social_icon_spacing); ?>px !important;
	}

	.dipi-footer-menu-social-icons .dipi-social-icon {
  		box-sizing: content-box !important;
		width: <?php echo esc_html($footer_social_icon_size); ?>px;
    	height: <?php echo esc_html($footer_social_icon_size); ?>px;
    	padding: <?php echo esc_html($footer_social_icon_padding); ?>px;
	}

	.dipi-footer-menu-social-icons a .dipi-icon svg {
		fill: <?php echo esc_html($footer_social_icon_color); ?>;
		transition: all .4s ease-in-out;
	}

	.dipi-footer-menu-social-icons a .dipi-icon {
		width: 100%;
		height: 100%;
		overflow: hidden;
		display: grid;
	}

	.dipi-footer-menu-social-icons .dipi-social-icon:hover .dipi-icon svg {
		fill: <?php echo esc_html($footer_social_icon_hover_color); ?>;
		transition: all .4s ease-in-out;
	}

	.dipi-footer-menu-social-icons .dipi-social-icon-box-style {
  		box-sizing: content-box !important;
    	border-radius: <?php echo esc_html($footer_social_icon_box_radius); ?>px;
		background-color: <?php echo esc_html($footer_social_icon_box_background); ?>;
		<?php if($footer_social_icon_shadow) : ?>
		box-shadow: 0 <?php echo esc_html($footer_social_icon_shadow_offset); ?>px <?php echo esc_html($footer_social_icon_shadow_blur); ?>px <?php echo esc_html($footer_social_icon_shadow_color); ?>;
		<?php endif; ?>
		transition: all .4s ease-in-out;
	}

	.dipi-footer-menu-social-icons .dipi-social-icon.dipi-social-icon-box-style:hover {
		background-color: <?php echo esc_html($footer_social_icon_box_background_hover); ?>;
		<?php if($footer_social_icon_shadow_hover) : ?>
		box-shadow: 0 <?php echo esc_html($footer_social_icon_shadow_offset_hover); ?>px <?php echo esc_html($footer_social_icon_shadow_blur_hover); ?>px <?php echo esc_html($footer_social_icon_shadow_color_hover); ?>;
		<?php endif; ?>
		transition: all .4s ease-in-out;
	}

	/**
	 * mobile social
	 */

	#dipi-mobile-menu-social-icons-id{
		display: none;
	}
	
	@media all and (max-width: <?php echo esc_attr(intval($breakpoint_mobile)); ?>px) {

		#dipi-primary-menu-social-icons-id,
		#dipi-secondary-menu-social-icons-id {
			display: none !important;
		}

		#dipi-mobile-menu-social-icons-id {
			display: flex;
      		overflow: inherit;
		}

		<?php if('center' == $mobile_social_icon_alignment) : ?>
		#dipi-mobile-menu-social-icons-id { justify-content: center; }
		<?php elseif('right' == $mobile_social_icon_alignment) : ?>
		#dipi-mobile-menu-social-icons-id { justify-content: flex-end; }
		<?php else : ?>
		#dipi-mobile-menu-social-icons-id { justify-content: flex-start; }
		<?php endif; ?>

		.dipi-mobile-menu-social-icons {
        	display: inline-flex !important;
			margin: 20px 0 !important;
		}

		.dipi-social-icons {
        	justify-content: unset;
		}

		.dipi-mobile-menu-social-icons .dipi-social-icon {
  			box-sizing: content-box !important;
			width: <?php echo esc_html($mobile_social_icon_size); ?>px;
			height: <?php echo esc_html($mobile_social_icon_size); ?>px;
			padding: <?php echo esc_html($mobile_social_icon_box_padding); ?>px;
		}

		.dipi-mobile-menu-social-icons a .dipi-icon svg {
			fill: <?php echo esc_html($mobile_social_icon_color); ?>;
			transition: all .4s ease-in-out;
		}

		.dipi-mobile-menu-social-icons a .dipi-icon {
        	width: 100%;
        	height: 100%;
	        overflow: hidden;
	        display: grid;
		}

		.dipi-mobile-menu-social-icons .dipi-social-icon:hover .dipi-icon svg {
			fill: <?php echo esc_html($mobile_social_icon_hover_color); ?>;
			transition: all .4s ease-in-out;
		}

		.dipi-mobile-menu-social-icons .dipi-social-icon {
			border-radius: <?php echo esc_html($mobile_social_icon_box_radius); ?>px;
			<?php if($mobile_social_icon_box_style) : ?>
			background-color: <?php echo esc_html($mobile_social_icon_box_background); ?>;
			<?php endif; ?>
			<?php if($mobile_social_icon_box_shadow) : ?>
			box-shadow: 0 <?php echo esc_html($mobile_social_icon_shadow_offset); ?>px <?php echo esc_html($mobile_social_icon_shadow_blur); ?>px <?php echo esc_html($mobile_social_icon_shadow_color); ?>;
			<?php endif; ?>
			transition: all .4s ease-in-out;
		}

		.dipi-mobile-menu-social-icons a {
			padding: 0 !important;
			border-bottom: 0 !important;
			width: 100% !important;
			height: 100% !important;
			display: flex !important;
			justify-content: center !important;
			align-items: center !important;
		}

		.dipi-mobile-menu-social-icons .dipi-social-icon:hover  {
			<?php if($mobile_social_icon_box_style) : ?>
			background-color: <?php echo esc_html($mobile_social_icon_box_background_hover); ?>;
			<?php endif; ?>
			transition: all .4s ease-in-out;
		}

	}

</style>

<script type="text/javascript" id="dipi-social-icons-js">
// FIXME: If secondary menu is not enabled, we shouldn't force it just to display icons to it
jQuery(document).ready(function($) {
	<?php if('secondary' == $use_social_icons_menu && 'on' !== $use_individual_location) : ?>
		if (!$('body').hasClass("et_secondary_nav_enabled")) {
			$("body").addClass('dipi_secondary_nav_enabled');
		}
		<?php if(!is_customize_preview()) : ?>
			if ($('body').hasClass("dipi_secondary_nav_enabled")) {
				$('<div id="top-header"><div class="container clearfix"><div id="et-secondary-menu"></div></div></div>').prependTo('#page-container');
			}
		<?php endif; ?>

		<?php elseif ('on' == $use_individual_location) : ?>
		if (!$('body').hasClass("et_secondary_nav_enabled")) {
			$("body").addClass('dipi_secondary_nav_enabled');
		}

		<?php if(!is_customize_preview()) : ?>
			if ($('body').hasClass("dipi_secondary_nav_enabled")) {
				$('<div id="top-header"><div class="container clearfix"><div id="et-secondary-menu"></div></div></div>').prependTo('#page-container');
			}
		<?php endif; ?>
	<?php endif; ?>

	<?php if(is_customize_preview()) : ?>
 
		$("#main-header #top-menu #dipi-primary-menu-social-icons-id").detach().insertAfter("#top-menu-nav");
    	// $(".et-l--header #dipi-primary-menu-social-icons-id").detach().insertAfter("#et-menu-nav");

	<?php else : ?>
		
		$("#main-header #top-menu #dipi-primary-menu-social-icons-id").insertAfter("#top-menu-nav");
		$(".et-l--header #top-menu #dipi-primary-menu-social-icons-id").insertAfter("#et-menu-nav");
    
	<?php endif; ?>

});

</script>
