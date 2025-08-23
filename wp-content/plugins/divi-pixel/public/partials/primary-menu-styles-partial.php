<?php 

namespace DiviPixel;

$primary_nav_font_weight = DIPI_Customizer::get_option('primary_nav_font_weight');
$primary_nav_hover_txt_color = DIPI_Customizer::get_option('primary_nav_hover_txt_color');
$fixed_primary_nav_hover_txt_color = DIPI_Customizer::get_option('fixed_primary_nav_hover_txt_color');
$primary_nav_spacing = DIPI_Customizer::get_option('primary_nav_spacing');
$fixed_nav_spacing = DIPI_Customizer::get_option('fixed_nav_spacing'); 
?>

<style type="text/css" id="primary-menu-styles-css">

	.et-menu-nav ul.et-menu li,
	#top-menu li {
		padding-right: <?php echo esc_html($primary_nav_spacing); ?>px !important;
	}
	.et-menu-nav ul.et-menu li:hover,
	#top-menu li:hover {
		transition: all .3s ease-in-out;
	}

	.et-fixed-header #top-menu li {
		padding-right: <?php echo esc_html($fixed_nav_spacing); ?>px !important;
		transition: all .3s ease-in-out;
	}
	/*.et-menu-nav ul.et-menu li:last-of-type,
	#top-menu>li:last-of-type {
		padding-right: 0 !important;
	}*/
	.et-menu-nav ul.et-menu li a,
	#top-menu a {
		<?php echo esc_html(DIPI_Customizer::print_font_style_option("primary_nav_font_style")); ?>
		font-weight: <?php echo esc_html($primary_nav_font_weight); ?>;
	}

	.et-menu-nav ul.et-menu li a:hover,
	#top-menu a:hover {
		color: <?php echo esc_html($primary_nav_hover_txt_color); ?> ;
		opacity: 1 !important;
	}

	.et-fixed-header ul#top-menu li a:hover {
		color: <?php echo esc_html($fixed_primary_nav_hover_txt_color); ?> !important;
	}

</style>