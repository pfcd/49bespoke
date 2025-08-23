<?php
namespace DiviPixel;

include plugin_dir_path(__FILE__) . 'social-icons-partial.php';

$social_links_new_tab = DIPI_Settings::get_option('social_links_new_tab') ? 'target="_blank"' : '';
$social_icon_hover_effect = DIPI_Customizer::get_option('social_icon_hover_effect');
$social_icon_box_style_class = (DIPI_Customizer::get_option('social_icon_box_style')) ? 'dipi-social-icon-box-style ' : '';

$dipi_hover_effect_class = '';
if($social_icon_hover_effect == 'zoom') :
	$dipi_hover_effect_class = 'dipi-social-icon-zoom ';
elseif($social_icon_hover_effect == 'slide_up') :
	$dipi_hover_effect_class = 'dipi-social-icon-slideup ';
elseif($social_icon_hover_effect == 'rotate') :
	$dipi_hover_effect_class = 'dipi-social-icon-rotate ';
endif;

?>

<div id="dipi-secondary-menu-social-icons-id" class="dipi-social-icons dipi-secondary-menu-social-icons">
<?php foreach($secondary_menu_social_icons as $secondary_menu_social_icon_value) : ?>
	<div class="dipi-social-icon <?php echo esc_attr($dipi_hover_effect_class); echo esc_attr($social_icon_box_style_class); ?>dipi-social-<?php echo esc_attr($secondary_menu_social_icon_value['title']); ?>">
		<a href="<?php echo esc_url($secondary_menu_social_icon_value['url']); ?>" <?php echo esc_attr($social_links_new_tab); ?>>
			<span class="dipi-icon">		
				<?php include DIPI_DIR . "public/assets/" . $secondary_menu_social_icon_value['icon']; ?>
			</span>
			<span></span>
		</a>
	</div>
	<?php endforeach; ?>
</div>

<script type="text/javascript" id="dipi-secondary-menu-social-icons-js">
	jQuery(document).ready(function() {	
		jQuery("#dipi-secondary-menu-social-icons-id").appendTo("#et-secondary-menu");
		if(typeof window.dipi_apply_hide_top_bar !== 'undefined')
			window.dipi_apply_hide_top_bar()
	});
</script>

<style type="text/css" id="social-icons-secondary-menu-styles">

	#et-secondary-menu {
		display: flex;
    	align-items: center;
		justify-content: flex-end;
	}

	<?php if('secondary' == $use_social_icons_menu && 'on' !== $use_individual_location) : ?>
		#top-header {
			display: block !important;
		}
		<?php if(is_404() && DIPI_Settings::get_option('error_page_header')) : ?>
			#top-header {
			display: none !important;
		}
		<?php endif; ?>
	<?php elseif ('on' == $use_individual_location || is_customize_preview()) : ?>
		#top-header {
			display: block !important;
		}
		<?php if(is_404() && DIPI_Settings::get_option('error_page_header')) : ?>
			#top-header {
			display: none !important;
		}
		<?php endif; ?>
	<?php endif; ?>
	
	@media screen and (min-width: 768px) {
		#top-header .container {
			display: flex;
			align-items: center;
	  		justify-content: flex-end;
		}
		
		#top-header .container #et-info,
		#top-header .container #et-secondary-menu {
			width: 50%;
		}
		body.dipi_secondary_nav_enabled #top-header .container {
			justify-content: flex-end;
		}
		body.dipi_secondary_nav_enabled #top-header .container #et-secondary-menu {
			width: 100%;
		}
	}

</style>