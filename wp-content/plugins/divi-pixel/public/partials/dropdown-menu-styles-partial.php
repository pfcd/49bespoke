<?php
namespace DiviPixel;

$dropdown_font_select           = DIPI_Customizer::get_option('dropdown_font_select');
$dropdown_font_weight           = DIPI_Customizer::get_option('dropdown_font_weight');
$dropdown_text_size             = DIPI_Customizer::get_option('dropdown_text_size');
$dropdown_letter_spacing        = DIPI_Customizer::get_option('dropdown_letter_spacing');
$dropdown_menu_text_color       = DIPI_Customizer::get_option('dropdown_menu_text_color');

$dropdown_hover_letter_spacing  = DIPI_Customizer::get_option('dropdown_hover_letter_spacing');
$dropdown_menu_text_color_hover = DIPI_Customizer::get_option('dropdown_menu_text_color_hover');
$dropdown_menu_text_box_hover   = DIPI_Customizer::get_option('dropdown_menu_text_box_hover');
$dropdown_hover_link_animation  = DIPI_Customizer::get_option('dropdown_hover_link_animation');

$dropdown_box_background        = DIPI_Customizer::get_option('dropdown_box_background');
$dropdowns_box_radius           = DIPI_Customizer::get_option('dropdowns_box_radius');

$dropdowns_shadow               = DIPI_Customizer::get_option('dropdowns_shadow');
$dropdowns_shadow_color         = DIPI_Customizer::get_option('dropdowns_shadow_color');
$dropdowns_shadow_offset        = DIPI_Customizer::get_option('dropdowns_shadow_offset');
$dropdowns_shadow_blur          = DIPI_Customizer::get_option('dropdowns_shadow_blur');

$dropdowns_arrow         		= DIPI_Customizer::get_option('dropdowns_arrow');
$primary_nav_dropdown_bg = et_get_option( 'primary_nav_dropdown_bg', '#fff' );

?> 

<style type="text/css" id="dropdown-menu-styles-css">
	
	header.et-l--header .nav li ul,
	.nav li ul {
		background: <?php echo esc_html($dropdown_box_background); ?> !important;
		border-radius: <?php echo esc_html($dropdowns_box_radius); ?>px !important;
		<?php if($dropdowns_shadow == 1) : ?>
        box-shadow: 0 <?php echo esc_html($dropdowns_shadow_offset); ?>px <?php echo esc_html($dropdowns_shadow_blur); ?>px <?php echo esc_html($dropdowns_shadow_color); ?> !important;
        <?php endif; ?>
	}

	#top-menu.nav li ul li.current-menu-item a,
	#top-menu.nav li ul a,
	.et-menu-nav ul.et-menu ul.sub-menu li a {
		<?php echo et_core_intentionally_unescaped(stripslashes(et_builder_get_font_family($dropdown_font_select)), 'html'); ?>
    	<?php echo esc_html(DIPI_Customizer::print_font_style_option("dropdown_font_style")); ?>
    	font-weight: <?php echo esc_html($dropdown_font_weight); ?> !important;
		font-size: <?php echo esc_html($dropdown_text_size); ?>px !important;
		letter-spacing: <?php echo esc_html($dropdown_letter_spacing); ?>px !important;
		color: <?php echo esc_html($dropdown_menu_text_color); ?> !important;
		transition: all .2s ease-in-out !important;
    }
	#top-menu.nav li ul li.current-menu-item a:hover,
	#top-menu.nav li ul a:hover,
	.et-menu-nav ul.et-menu ul.sub-menu li a:hover {
		color: <?php echo esc_html($dropdown_menu_text_color_hover); ?> !important;
		letter-spacing: <?php echo esc_html($dropdown_hover_letter_spacing); ?>px !important;
		background: <?php echo esc_html($dropdown_menu_text_box_hover); ?> !important;
		transition: all .2s ease-in-out;
	}

	<?php if('grow' == $dropdown_hover_link_animation) : ?>
		.nav li ul a:hover {
			transform: scale(1.1) !important;
		}
	<?php elseif('slide_right' == $dropdown_hover_link_animation) : ?>
		.nav li ul a:hover {
			margin-left: 5px !important;
		}
	<?php elseif('slide_left' == $dropdown_hover_link_animation) : ?>
		.nav li ul a:hover {
			margin-left: -5px !important;
		}
	<?php elseif('move_up' == $dropdown_hover_link_animation) : ?>
		.nav li ul a:hover {
			margin-top: -5px !important;
		}
	<?php endif; ?>

	<?php if($dropdowns_arrow == 'on'): ?>
		@media (min-width: 980px) {
		.dipi-dropdown-arrow .nav li:not(.mega-menu) ul.sub-menu:after {
				content: '';
				display: block;
				position: absolute;
				left: 20%;
				top: -20px;
				width: 0;
				height: 0;
				border-top: 10px solid transparent;
				border-right: 10px solid transparent;
				border-bottom: 10px solid #fff;
				border-left: 10px solid transparent;
				border-bottom-color: <?php echo esc_html($primary_nav_dropdown_bg) ?>;
				transform: translateY(100%);
				opacity: 0;
				transition: all 1s;
				
			}
			.dipi-dropdown-arrow .nav > li.et-hover > ul.sub-menu:after{
				transform: translateY(0); opacity: 1;
			}
			.dipi-dropdown-arrow .nav li ul.sub-menu{
				border-top: 0;
			}
			
			 
		}
	<?php endif; ?>
</style>
<?php if($dropdowns_arrow == 'on'): ?>
<script>
	document.addEventListener("DOMContentLoaded", function() {
		document.body.classList.add('dipi-dropdown-arrow');
	});
</script>
<?php endif; ?>