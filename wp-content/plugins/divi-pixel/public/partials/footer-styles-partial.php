<?php
namespace DiviPixel;

// Footer Menu
$footer_menu_font_select = DIPI_Customizer::get_option('footer_menu_font_select');
$footer_menu_font_weight = DIPI_Customizer::get_option('footer_menu_font_weight');
$footer_menu_spacing = DIPI_Customizer::get_option('footer_menu_spacing');
$footer_menu_underline = DIPI_Customizer::get_option('footer_menu_underline');  //FIXME: Default was false
$footer_menu_underline_color = DIPI_Customizer::get_option('footer_menu_underline_color');
$footer_menu_hover_text_color = DIPI_Customizer::get_option('footer_menu_hover_text_color');
$footer_menu_center = DIPI_Customizer::get_option('footer_menu_center');
$footer_menu_shadow = DIPI_Customizer::get_option('footer_menu_shadow');  //FIXME: Default was false
$footer_menu_shadow_color = DIPI_Customizer::get_option('footer_menu_shadow_color');
$footer_menu_shadow_offset = DIPI_Customizer::get_option('footer_menu_shadow_offset');
$footer_menu_shadow_blur = DIPI_Customizer::get_option('footer_menu_shadow_blur');
?>

<style type="text/css" id="dipi-footer-styles">

  <?php if ($footer_menu_shadow): ?>
	#et-footer-nav {
		box-shadow: 0px <?php echo esc_html($footer_menu_shadow_offset); ?>px <?php echo esc_html($footer_menu_shadow_blur); ?>px <?php echo esc_html($footer_menu_shadow_color); ?>;
	}
  <?php endif;?>

  <?php if ($footer_menu_center): ?>
	.bottom-nav {
		text-align: center;
	}
  <?php endif;?>

	.bottom-nav li {
		<?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($footer_menu_font_select)), 'html'); ?>
		font-weight: <?php echo esc_html($footer_menu_font_weight); ?>;
    	padding-right: <?php echo esc_html($footer_menu_spacing); ?>px;
  	}

  	.bottom-nav li:last-child{
    	padding-right: 0px;
	}

	.dipi-hover-underline-animation::after {
		background-color: <?php echo esc_html($footer_menu_underline_color); ?>;
	}

	.bottom-nav a:hover {
		color: <?php echo esc_html($footer_menu_hover_text_color); ?>;
	}
</style>
<?php
// Footer Bottom Bar
$footer_bottom_center = DIPI_Customizer::get_option('footer_bottom_center');

$footer_bar_font_select = DIPI_Customizer::get_option('footer_bar_font_select');
$footer_bar_font_weight = DIPI_Customizer::get_option('footer_bar_font_weight');
$footer_bar_text_spacing = DIPI_Customizer::get_option('footer_bar_text_spacing');
$footer_bar_link_color = DIPI_Customizer::get_option('footer_bar_link_color');
$footer_bar_hover_link_color = DIPI_Customizer::get_option('footer_bar_hover_link_color');
$footer_bar_padding_top_bottom = DIPI_Customizer::get_option('footer_bar_padding_top_bottom');


if (DIPI_Settings::get_option('hide_bottom_bar') !== 1):
?>
<style type="text/css" id="dipi-footer-dont-hide-bottom-bar-styles">
	#footer-bottom {
		padding-top: <?php echo esc_html($footer_bar_padding_top_bottom); ?>px;
		padding-bottom: <?php echo esc_html($footer_bar_padding_top_bottom); ?>px;
	}

	#footer-info {
		<?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($footer_bar_font_select)), 'html'); ?>
		letter-spacing: <?php echo esc_html($footer_bar_text_spacing); ?>px;
		font-weight: <?php echo esc_html($footer_bar_font_weight); ?>;
	}

	#footer-info a {
    color: <?php echo esc_html($footer_bar_link_color); ?>;
  }

  #footer-info a:hover {
    color: <?php echo esc_html($footer_bar_hover_link_color); ?>;
  }

	<?php

   if ($footer_bottom_center): ?>

		#footer-bottom > .container{
		display:flex;
		flex-direction: column;
		}
		.et-social-icons {
			float: none !important;
			text-align: center !important;
			margin-bottom: 10px;
		}

		#footer-info {
		  	float: none !important;
		  	text-align: center !important;
        	order: 2;
		}

		#main-footer .dipi-footer-menu-social-icons {
			justify-content: center !important;
			order:1;
        }

	<?php else: ?>
		@media (min-width: 981px) {
			#footer-info {
				display: flex;
				align-items: center;
				padding-bottom: 0;
			}
		}
	<?php endif;?>
</style>
<?php
endif;
