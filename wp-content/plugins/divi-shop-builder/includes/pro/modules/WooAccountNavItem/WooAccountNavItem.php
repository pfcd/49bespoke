<?php

defined( 'ABSPATH' ) || exit;

/**
 * Module class of Woo My Account Avatar
 *
 */
class DSWCP_WooAccountNavItem extends ET_Builder_Module {

    use DSWCP_Module;

	public $slug       		= 'ags_woo_account_navigation_item';
	public $vb_support 		= 'on';
	public $type 	   		= 'child';
	public $child_title_var = 'item_title';
	public $advanced_fields = false;
	public $custom_css_tab  = false;
	protected $icon;


	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function init() {
		$this->name = esc_html__( 'Account Navigation Item', 'divi-shop-builder' );
		$this->icon  = 'G';


		$this->settings_modal_toggles = array(
			'general'    => array(
				'toggles' => array(
					'main_content' => esc_html__( 'Content', 'divi-shop-builder' ),
				),
			)
		);
	}

	public function get_fields(){
		$menuItems = wc_get_account_menu_items();
		
		return array(
			'item' => array(
				'label'            => esc_html__( 'Menu Item', 'divi-shop-builder' ),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'default'          => key($menuItems),
				'options'          => $menuItems,
				'description'      => esc_html__( 'Choose which type of navigation view you would like to display.', 'divi-shop-builder' ),
				'toggle_slug'	   => 'main_content'
			),
			'item_title' => array(
				'label'        => '',
				'type'         => 'ags_divi_wc_value_mapper-DSB',
				'sourceField'  => 'item',
				'valueMap'     => $menuItems,
				'toggle_slug'  => 'main_content'
			),
			'item_name' => array(
				'label'            => esc_html__( 'Custom Menu Item Name', 'divi-shop-builder' ),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Define a custom name for your menu item', 'divi-shop-builder' ),
				'toggle_slug'	   => 'main_content',
			),
			'icon' => array(
				'label'            => esc_html__( 'Menu Item Icon', 'divi-shop-builder' ),
				'type'             => 'select_icon',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Choose an Icon to set for the menu item', 'divi-shop-builder' ),
				'toggle_slug'	   => 'main_content'
			)
		);
	}

	public function render( $attrs, $content, $render_slug ){
		$item_name = !empty( $this->props['item_name'] ) ? $this->props['item_name'] : $this->props['item_title'];

//		Set default icons for nav items

		 if ( !empty($this->props['icon'])) {
		 	$icon = $this->props['icon'];
		 } else {
			 switch ($this->props['item_title']) {
				 case 'Dashboard':
					 $icon = '&#xe037;';
					 break;
				 case 'Orders':
					 $icon = '&#xe07a;';
					 break;
				 case 'Downloads':
					 $icon = '&#xe092;';
					 break;
				 case 'Addresses':
					 $icon = '&#xe081;';
					 break;
				 case 'Account details':
					 $icon = '&#xe08a;';
					 break;
				 case 'Logout':
					 $icon = '&#xe03e;';
					 break;
				 default:
					 $icon = '&#xe037;';
					 break;
			 }
		 }
		return sprintf(
			'<li class="%s"><a href="%s" data-icon="%s">%s</a></li>',
			wc_get_account_menu_item_classes( $this->props['item'] ),
			esc_url( wc_get_account_endpoint_url( $this->props['item'] ) ),
			esc_attr( et_pb_process_font_icon( $icon ) ),
			$item_name
		);
	}

	protected function _render_module_wrapper( $output = '', $render_slug = '' ) {
		return $output;
	}
}

new DSWCP_WooAccountNavItem;