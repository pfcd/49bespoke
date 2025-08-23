<?php
namespace DiviPixel;

add_filter('wp_nav_menu_items', 'DiviPixel\dipi_nav_menu_items', 10, 2);
function dipi_nav_menu_items($items, $args) {
	$menu_id = DIPI_Settings::get_option('menu_cta_menu');
	$menu_btn_icon_display = DIPI_Customizer::get_option('menu_btn_icon_display');
	$menu_btn_hover_effect = DIPI_Customizer::get_option('menu_btn_hover_effect');
	$menu_button_text = DIPI_Settings::get_option('menu_button_text');
	$cta_btn_new_tab = DIPI_Settings::get_option('cta_btn_new_tab');
	$menu_button_placement = DIPI_Settings::get_option('menu_button_placement');
	
	$url = DIPI_Settings::get_option('menu_button_url');
	$classname = DIPI_Settings::get_option('menu_button_classname');
	$hide_mobile_cta_class = DIPI_Settings::get_option('mobile_cta_btn') ? 'dipi-hide-cta-button-mobile' : '';
	$extra_attributes = '';
	if($cta_btn_new_tab == 'on'){
		$extra_attributes = 'target="_blank"';
	}
	$add_cta = false;
	
	$add_cta = dipi_is_cta_enabled($args, $menu_id);

	if( $add_cta ){

		$cta = sprintf(
			'<li class="menu-item dipi-cta-button-menu-item %1$s">
				<a href="%2$s" class="et_pb_button dipi-cta-button dipi-cta-button-icon-%3$s dipi-cta-button-effect-%4$s %6$s" %5$s>
					<span>'.$menu_button_text.'</span>
				</a>
			</li>',
			$hide_mobile_cta_class,
			$url,
			$menu_btn_icon_display,
			$menu_btn_hover_effect,
			$extra_attributes,
			$classname
		);
		$items = ($menu_button_placement == 'a') ? $items . $cta : $cta . $items;
	}

	return $items;
}
 
function dipi_is_cta_enabled($args,  $menu_id){

	$current_menu_id = null;
	if(gettype($args->menu) == 'integer' ){
		$current_menu_id = $args->menu;
	}elseif(gettype($args->menu) == 'object' ){
		$current_menu_id = $args->menu->term_id;
	}
	if(is_null($current_menu_id)) return false;
	if(is_array($menu_id)){
		$integerIDs = array_map('intval', $menu_id);
		if(in_array(intval($current_menu_id), $integerIDs, true)){
			return true;
		}
	} else {
		if(intval($current_menu_id) === intval($menu_id))
		return true;
	}
	return false;
}
