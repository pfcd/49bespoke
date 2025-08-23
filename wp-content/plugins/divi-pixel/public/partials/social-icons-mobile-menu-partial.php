<?php
namespace DiviPixel;

add_filter('wp_nav_menu_items', 'DiviPixel\dipi_mobile_menu_social_icons', 10, 2);

function dipi_mobile_menu_social_icons($items, $args) {

	include plugin_dir_path(__FILE__) . 'social-icons-partial.php';

	$social_links_new_tab = DIPI_Settings::get_option('social_links_new_tab') ? 'target="_blank"' : '';
	$mobile_social_icon_box_class = DIPI_Customizer::get_option('mobile_social_icon_box_style') ? 'dipi-social-icon-box-style ' : '';
	$mobile_social_icon_placement = DIPI_Customizer::get_option('mobile_social_icon_placement'); 
	
	
	// $mobile_social_icon_hover_effect = DIPI_Customizer::get_option('mobile_social_icon_hover_effect'); // FIXME: This option doesn't exist. We probably should add it
	$dipi_hover_effect_class = '';
	// if($mobile_social_icon_hover_effect == 'zoom') {
	// 	$dipi_hover_effect_class = 'dipi-social-icon-zoom ';
	// } else if($mobile_social_icon_hover_effect == 'slide_up') {
	// 	$dipi_hover_effect_class = 'dipi-social-icon-slideup ';
	// } else if($mobile_social_icon_hover_effect == 'rotate') {
	// 	$dipi_hover_effect_class = 'dipi-social-icon-rotate ';
	// }

	ob_start();

	?>
	<div id="dipi-mobile-menu-social-icons-id">
		<div class="dipi-social-icons dipi-mobile-menu-social-icons">
		<?php foreach($mobile_menu_social_icons as $mobile_menu_social_icon_value) : ?>
			<div class="dipi-social-icon <?php echo esc_attr($dipi_hover_effect_class); echo esc_attr($mobile_social_icon_box_class); ?>dipi-social-<?php echo esc_attr($mobile_menu_social_icon_value['title']); ?>">
				<a href="<?php echo esc_url($mobile_menu_social_icon_value['url']); ?>" <?php echo esc_attr($social_links_new_tab); ?>>
					<span class="dipi-icon">
						<?php include DIPI_DIR . "public/assets/" . $mobile_menu_social_icon_value['icon']; ?>
					</span>
				</a>
			</div>
			<?php endforeach; ?>
		</div>
	</div>

<?php

	$output = ob_get_clean();

	if($mobile_social_icon_placement == 'top') {
		if( empty($args->theme_location) || $args->theme_location == 'primary-menu' ){
			$items = $output . $items;
		}
		return $items;
	} else {
		if( empty($args->theme_location) || $args->theme_location == 'primary-menu' ){
			$items .= $output;
		}
		return $items;
	}

}

?>