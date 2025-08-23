<?php

/**
 * Parent module (module which has module item / child module) with FULL builder support
 * This module appears on Visual Builder and requires react component to be provided
 * Due to full builder support, all advanced options (except button options) are added by default
 *
 * @since 1.0.0
 */
class DSWCP_WooProductsFilters extends ET_Builder_Module {

	use DSWCP_Module;

	public $slug       = 'ags_woo_products_filters';
	public $vb_support = 'on';
	public $child_slug = 'ags_woo_products_filters_child';
	protected $accent_color;
	protected $icon_path;

	/**
	 * Based on this array margin and padding fields will be added
	 * set 'toggle_slug' as a key
	 * Update also in WooProductsFilters.jsx
	 *
	 */
	private static $margin_padding_elements = array(
		'filter_title'               => array(
			'selector'        => '%%order_class%% .ags_woo_products_filters_child .ags-wc-filters-section-title',
			'sub_toggle'      => 'spacing',
			'default_padding' => '15px|25px|15px|25px',
		),
		'filter_inner'               => array(
			'selector'        => '%%order_class%% .ags_woo_products_filters_child .ags-wc-filters-section-inner',
			'sub_toggle'      => 'spacing',
			'default_padding' => '20px|30px|20px|30px',
		),
		'filter_tagcloud'            => array(
			'selector'        => '%%order_class%% .ags-wc-filters-tagcloud li label',
			'sub_toggle'      => 'spacing',
			'default_padding' => '3px|15px|3px|15px',
			'default_margin'  => '0|10px|10px|0',
		),
		'products_number'            => array(
			'selector'        => '%%order_class%% .ags-wc-filters-product-count',
			'sub_toggle'      => 'spacing',
			'default_padding' => '',
			'default_margin'  => '|||5px',
		),
		'filters_buttons_container'  => array(
			'selector'        => '%%order_class%% .ags-wc-filters-buttons',
			'sub_toggle'      => 'spacing',
			'default_padding' => '20px|30px|20px|30px',
		),
		'selected_filters_container' => array(
			'selector'   => '%%order_class%% .ags-wc-filters-selected-main',
			'sub_toggle' => 'spacing',
		),
		'selected_filters_title'     => array(
			'selector'        => '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-section-title',
			'sub_toggle'      => 'spacing',
			'default_padding' => '15px|25px|15px|25px',
		),
		'selected_filters_inner'     => array(
			'selector'        => '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-body',
			'sub_toggle'      => 'spacing',
			'default_padding' => '20px|30px|20px|30px',
		),
		'selected_filter'            => array(
			'selector'        => '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-inner',
			'sub_toggle'      => 'spacing',
			'default_padding' => '10px|10px|10px|10px',
			'default_margin'  => '0|10px|10px|0',
		),
	);


	function init() {
		$this->name             = esc_html__('Woo Products Filters', 'divi-shop-builder');
		$this->icon_path        = plugin_dir_path(__FILE__) . 'icon.svg';
		$this->main_css_element = '%%order_class%%';
		$this->accent_color     = '#2ea3f2';

		$iconSvgs = [
			'typography_text'    => '',
			'padding_margins'    => '',
			'border'             => '',
			'background_colors'  => '',
			'typography_heading' => '',
			'arrow_down'         => '',
			'error'              => ''
		];

		array_walk(
			$iconSvgs,
			function(&$value, $key) {
				$value = file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/' . $key . '.svg');
			}
		);

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content' => esc_html__('Filters Settings', 'divi-shop-builder')
				),
			),
			'advanced' => array(
				'toggles' => array(
					'filter_container'           => array(
						'title'             => esc_html__('Single Filter', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'          => array(
								'name'     => 'p',
								'icon_svg' => $iconSvgs['typography_text'],
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $iconSvgs['background_colors'],
							),
						),
					),
					'filter_title'               => array(
						'title'             => esc_html__('Filter Title', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'h2'           => array(
								'name'     => 'h2',
								'icon_svg' => $iconSvgs['typography_heading'],
							),
							'spacing'      => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
							'border'       => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'background'   => array(
								'name'     => 'background',
								'icon_svg' => $iconSvgs['background_colors'],
							),
							'toggle_arrow' => array(
								'name'     => esc_html__('Filter Toggle Arrow', 'divi-shop-builder'),
								'icon_svg' => $iconSvgs['arrow_down'],
							),
							'clear_filter_text' => array(
								'name'     => esc_html__('Clear Filter Text', 'divi-shop-builder'),
								'icon_svg' => $iconSvgs['error'],
							),
						),
					),
					'filter_inner'               => array(
						'title'             => esc_html__('Filter Inner', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $iconSvgs['background_colors'],
							),
						),
					),
					'filter_radio_list'          => array(
						'title'             => esc_html__('Radio Buttons List', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'sub_toggles'       => array(
							'radio' => array(
								'name' => esc_html__('Radio', 'divi-shop-builder'),
							),
							'list'  => array(
								'name' => esc_html__('List', 'divi-shop-builder'),
							),
						),
					),
					'filter_checkbox_list'       => array(
						'title'             => esc_html__('Checkboxes List', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'sub_toggles'       => array(
							'checkbox' => array(
								'name' => esc_html__('Checkbox', 'divi-shop-builder'),
							),
							'list'     => array(
								'name' => esc_html__('List', 'divi-shop-builder'),
							),
						),
					),
					'form_fields'                => esc_html__('Input, Search & Select', 'divi-shop-builder'),
					'filter_select_dropdown'     => array(
						'title'             => esc_html__('Dropdown Select', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'sub_toggles'       => array(
							'dropdown'      => array(
								'name' => esc_html__('Dropdown', 'divi-shop-builder'),
							),
							'dropdown_item' => array(
								'name' => esc_html__('Dropdown Item', 'divi-shop-builder'),
							),
						),
					),
					'filter_search'              => array(
						'title'             => esc_html__('Search Filter', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'sub_toggles'       => array(
							'icon'          => array(
								'name' => esc_html__('Search Icon', 'divi-shop-builder'),
							),
							'dropdown'      => array(
								'name' => esc_html__('Dropdown', 'divi-shop-builder'),
							),
							'dropdown_item' => array(
								'name' => esc_html__('Dropdown Item', 'divi-shop-builder'),
							),
						),
					),
					'filter_price'               => esc_html__('Price Filter Range Slider', 'divi-shop-builder'),
					'filter_tagcloud'            => array(
						'title'             => esc_html__('Tagcloud', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'          => array(
								'name'     => 'p',
								'icon_svg' => $iconSvgs['typography_text'],
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $iconSvgs['background_colors'],
							),
						),
					),
					'filter_rating'              => esc_html__('Rating', 'divi-shop-builder'),
					'products_number'            => array(
						'title'             => esc_html__('Number of Products', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'          => array(
								'name'     => 'p',
								'icon_svg' => $iconSvgs['typography_text'],
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $iconSvgs['background_colors'],
							),
						),
					),
					'filters_buttons_container'  => array(
						'title'             => esc_html__('Buttons Container', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'general'    => array(
								'name' => esc_html__('General', 'divi-shop-builder'),
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $iconSvgs['background_colors'],
							),
						),
					),
					'apply_filters_button'       => esc_html__('Apply Button', 'divi-shop-builder'),
					'clear_filters_button'       => esc_html__('Clear Button', 'divi-shop-builder'),
					'selected_filters_container' => array(
						'title'             => esc_html__('Selected Filters Container', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'general'    => array(
								'name' => esc_html__('General', 'divi-shop-builder'),
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $iconSvgs['background_colors'],
							),
						),
					),
					'selected_filters_title'     => array(
						'title'             => esc_html__('Selected Filters Title', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'h2'         => array(
								'name'     => 'h2',
								'icon_svg' => $iconSvgs['typography_heading'],
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $iconSvgs['background_colors'],
							),
						),
					),
					'selected_filters_inner'     => array(
						'title'             => esc_html__('Selected Filters Inner', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $iconSvgs['background_colors'],
							),
						),
					),
					'selected_filter'            => array(
						'title'             => esc_html__('Selected Filter', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'          => array(
								'name'     => 'p',
								'icon_svg' => $iconSvgs['typography_text'],
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $iconSvgs['background_colors'],
							),
							'remove'     => array(
								'name'     => 'remove',
								'icon_svg' => $iconSvgs['error'],
							),
						),
					),
				),
			),
		);

		$this->advanced_fields = array(
			'fonts'          => array(
				'filter_text'                      => array(
					'label'       => esc_html__('Filter Text', 'divi-shop-builder'),
					'css'         => array(
						'main' => '%%order_class%% .ags_woo_products_filters_child',
					),
					'toggle_slug' => 'filter_container',
					'sub_toggle'  => 'p',
				),
				'filter_title'                     => array(
					'label'       => esc_html__('Filter Title', 'divi-shop-builder'),
					'css'         => array(
						'main' => '%%order_class%% .ags_woo_products_filters_child .ags-wc-filters-section-title h4',
					),
					'font'        => array(
						'default' => '|600|||||||',
					),
					'font_size'   => array(
						'default' => '16px',
					),
					'line_height' => array(
						'default' => '1.2em',
					),
					'toggle_slug' => 'filter_title',
					'sub_toggle'  => 'h2',
				),
				'clear_filter_text'                     => array(
					'label'       => esc_html__('Clear Filter Text', 'divi-shop-builder'),
					'css'         => array(
						'main' => '%%order_class%% .ags_woo_products_filters_child .ags-wc-filters-section-title .ags-wc-filters-filter-clear',
					),
					'font'        => array(
						'default' => '||||||||',
					),
					'font_size'   => array(
						'default' => '0.9em',
					),
					'line_height' => array(
						'default' => '1.7em',
					),
					'toggle_slug' => 'filter_title',
					'sub_toggle'  => 'clear_filter_text',
				),
				'filter_radio_list'                => array(
					'label'           => esc_html__('List Item Text', 'divi-shop-builder'),
					'hide_text_align' => true,
					'hide_text_color' => true,
					'css'             => array(
						'main' => '%%order_class%% .ags-wc-filters-radio-button-list li label',
					),
					'toggle_slug'     => 'filter_radio_list',
					'sub_toggle'      => 'list',
					'priority'        => 10,
				),
				'filter_checkbox_list'             => array(
					'label'           => esc_html__('List Item Text', 'divi-shop-builder'),
					'hide_text_align' => true,
					'hide_text_color' => true,
					'css'             => array(
						'main' => '%%order_class%% .ags-wc-filters-checkbox-list li label',
					),
					'toggle_slug'     => 'filter_checkbox_list',
					'sub_toggle'      => 'list',
					'priority'        => 10,
				),
				'filter_select_dropdown_item_text' => array(
					'label'           => esc_html__('Dropdown Item Text', 'divi-shop-builder'),
					'hide_text_align' => true,
					'hide_text_color' => true,
					'css'             => array(
						'main' => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a',
					),
					'font_size'       => array(
						'default' => '14px',
					),
					'toggle_slug'     => 'filter_select_dropdown',
					'sub_toggle'      => 'dropdown_item',
					'priority'        => 10,
				),
				'filter_search_dropdown_item_text' => array(
					'label'           => esc_html__('Dropdown Item Text', 'divi-shop-builder'),
					'hide_text_align' => true,
					'hide_text_color' => true,
					'css'             => array(
						'main' => '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a',
					),
					'font_size'       => array(
						'default' => '14px',
					),
					'toggle_slug'     => 'filter_search',
					'sub_toggle'      => 'dropdown_item',
					'priority'        => 10,
				),
				'filter_tagcloud'                  => array(
					'label'           => esc_html__('Tag Text', 'divi-shop-builder'),
					'hide_text_align' => true,
					'hide_text_color' => true,
					'css'             => array(
						'main' => '%%order_class%% .ags-wc-filters-tagcloud label',
					),
					'font_size'       => array(
						'default' => '13px',
					),
					'toggle_slug'     => 'filter_tagcloud',
					'sub_toggle'      => 'p',
				),
				'products_number'                  => array(
					'label'           => esc_html__('Products Number Text', 'divi-shop-builder'),
					'hide_text_align' => true,
					'css'             => array(
						'main' => '%%order_class%% .ags-wc-filters-product-count',
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'toggle_slug'     => 'products_number',
					'sub_toggle'      => 'p',
				),
				'selected_filters_title'           => array(
					'label'       => esc_html__('Selected Filters Title', 'divi-shop-builder'),
					'css'         => array(
						'main' => '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-section-title h4',
					),
					'font'        => array(
						'default' => '|600|||||||',
					),
					'font_size'   => array(
						'default' => '16px',
					),
					'line_height' => array(
						'default' => '1.2em',
					),
					'toggle_slug' => 'selected_filters_title',
					'sub_toggle'  => 'h2',
				),
				'selected_filter'                  => array(
					'label'           => esc_html__('Selected Filter', 'divi-shop-builder'),
					'hide_text_align' => true,
					'css'             => array(
						'main' => '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-inner',
					),
					'font_size'       => array(
						'default' => '14px',
					),
					'line_height'     => array(
						'default' => '1.4em',
					),
					'toggle_slug'     => 'selected_filter',
					'sub_toggle'      => 'p',
				),
			),
			'button'         => array(
				'apply_filters_button' => array(
					'label'          => esc_html__('Apply Button', 'divi-shop-builder'),
					'css'            => array(
						'main'      => '%%order_class%% .ags-wc-filters-button-apply',
						'important' => 'all',
					),
					'box_shadow'     => array(
						'label' => esc_html__('Apply Button Box Shadow', 'divi-shop-builder'),
						'css'   => array(
							'main'      => '%%order_class%% .ags-wc-filters-button-apply',
							'important' => true,
						)
					),
					'use_alignment'  => false,
					'margin_padding' => array(
						'css'           => array(
							'main'      => '%%order_class%% .ags-wc-filters-button-apply',
							'important' => 'all'
						),
						'custom_margin' => array(
							'default' => '5px|7px|5px|7px|false|false',
						),
					),
					'icon'           => array(
						'css' => array(
							'main'      => '%%order_class%% .ags-wc-filters-button-apply::after',
							'important' => 'all'
						)
					),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'apply_filters_button',
				),
				'clear_filters_button' => array(
					'label'          => esc_html__('Clear Button', 'divi-shop-builder'),
					'css'            => array(
						'main'      => '%%order_class%% .ags-wc-filters-button-clear',
						'important' => 'all',
					),
					'box_shadow'     => array(
						'label' => esc_html__('Clear Button Box Shadow', 'divi-shop-builder'),
						'css'   => array(
							'main'      => '%%order_class%% .ags-wc-filters-button-clear',
							'important' => true,
						)
					),
					'use_alignment'  => false,
					'margin_padding' => array(
						'css'           => array(
							'main'      => '%%order_class%% .ags-wc-filters-button-clear',
							'important' => 'all'
						),
						'custom_margin' => array(
							'default' => '5px|7px|5px|7px|false|false',
						),
					),
					'icon'           => array(
						'css' => array(
							'main'      => '%%order_class%% .ags-wc-filters-button-clear::after',
							'important' => 'all'
						)
					),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'clear_filters_button',
				),
			),
			'form_field'     => array(
				'form_fields' => array(
					'label'          => esc_html__('Form Fields', 'divi-shop-builder'),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'form_fields',
					'css'            => array(
						'background_color'       => '%%order_class%% input[type=number], %%order_class%% .ags-wc-filters-search-input-wrapper, %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span',
						'main'                   => '%%order_class%% input[type=number], %%order_class%% input[type=search], %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span',
						'background_color_hover' => '%%order_class%% input[type=number]:hover, %%order_class%% .ags-wc-filters-search-input-wrapper:hover, %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:hover, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:hover',
						'focus_background_color' => '%%order_class%% input[type=number]:focus, %%order_class%% .ags-wc-filters-search-input-wrapper:focus-within, %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:focus, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:focus',
						'form_text_color'        => '%%order_class%% input[type=number], %%order_class%% input[type=search], %%order_class%% input[type=search]::-webkit-input-placeholder, %%order_class%% input[type=search]::-moz-placeholder, %%order_class%% input[type=search]:-ms-input-placeholder, %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span',
						'form_text_color_hover'  => '%%order_class%% input[type=number]:hover, %%order_class%% input[type=search]:hover, %%order_class%% input[type=search]:hover::-webkit-input-placeholder, %%order_class%% input[type=search]:hover::-moz-placeholder, %%order_class%% input[type=search]:hover:-ms-input-placeholder, %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:hover, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:hover',
						'focus_text_color'       => '%%order_class%% input[type=number]:focus, %%order_class%% input[type=search]:focus, %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:focus, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:focus',
						'placeholder_focus'      => '%%order_class%% input[type=number]:focus::-webkit-input-placeholder, %%order_class%% input[type=search]:focus::-webkit-input-placeholder, %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:focus::-webkit-input-placeholder, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:focus::-webkit-input-placeholder, %%order_class%% input[type=number]:focus::-moz-placeholder, %%order_class%% input[type=search]:focus::-moz-placeholder, %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:focus::-moz-placeholder, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:focus::-moz-placeholder, %%order_class%% input[type=number]:focus:-ms-input-placeholder,  %%order_class%% input[type=search]:focus:-ms-input-placeholder, %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:focus:-ms-input-placeholder, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:focus:-ms-input-placeholder',
						'padding'                => '%%order_class%% input[type=number], %%order_class%% input[type=search], %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span',
						'margin'                 => '%%order_class%% input[type=number], %%order_class%% .ags-wc-filters-search-input-wrapper, %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span',
					),
					'box_shadow'     => false,
					'border_styles'  => array(
						'form_fields'       => array(
							'name'         => 'form_fields',
							'css'          => array(
								'main' => array(
									'border_radii'  => '%%order_class%% input[type=number], %%order_class%% .ags-wc-filters-search-input-wrapper, %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span',
									'border_styles' => '%%order_class%% input[type=number], %%order_class%% .ags-wc-filters-search-input-wrapper, %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span',
								),
							),
							'defaults'     => array(
								'border_radii'  => 'on|0|0|0x|0',
								'border_styles' => array(
									'width' => '0px',
									'style' => 'solid',
									'color' => '#EEE'
								),
							),
							'label_prefix' => esc_html__('Fields', 'divi-shop-builder'),
						),
						'form_fields_focus' => array(
							'name'         => 'form_fields_focus',
							'css'          => array(
								'main' => array(
									'border_radii'  => '%%order_class%% input[type=number]:focus, %%order_class%% .ags-wc-filters-search-input-wrapper:focus-within, %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:focus, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:focus',
									'border_styles' => '%%order_class%% input[type=number]:focus, %%order_class%% .ags-wc-filters-search-input-wrapper:focus-within, %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:focus, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:focus',
								),
							),
							'label_prefix' => esc_html__('Fields On Focus', 'divi-shop-builder'),
						),
					),
					'font_field'     => array(
						'css'         => array(
							'main'  => array(
								'%%order_class%% input[type=number], %%order_class%% input[type=search], %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span',
							),
							'hover' => array(
								'%%order_class%% input[type=number]:hover, %%order_class%% input[type=search]:hover, %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:hover, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:hover',
								'%%order_class%% input[type=number]:focus::-webkit-input-placeholder, %%order_class%% input[type=search]:focus::-webkit-input-placeholder, %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:focus::-webkit-input-placeholder, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:focus::-webkit-input-placeholder',
								'%%order_class%% input[type=number]:focus::-moz-placeholder, %%order_class%% input[type=search]:focus::-moz-placeholder, %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:focus::-moz-placeholder, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:focus::-moz-placeholder',
								'%%order_class%% input[type=number]:focus:-ms-input-placeholder, %%order_class%% input[type=search]:focus:-ms-input-placeholder, %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:focus:-ms-input-placeholder, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:focus:-ms-input-placeholder',
							),
						),
						'font_size'   => array(
							'default' => '14px',
						),
						'line_height' => array(
							'default' => 'normal',
						),
					),
					'margin_padding' => array(
						'css'            => array(
							'main'    => '%%order_class%% input[type=number], %%order_class%% input[type=search], %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span',
							'padding' => '%%order_class%% input[type=number], %%order_class%% input[type=search], %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span',
							'margin'  => '%%order_class%% input[type=number], %%order_class%% .ags-wc-filters-search-input-wrapper, %%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span',
						),
						'custom_padding' => array(
							'default' => '16px|16px|16px|16px|true|true',
						),
						'custom_margin'  => array(
							'default' => '0|0|0|0|false|false',
						),
					)
				),
			),
			'box_shadow'     => array(
				'default'                           => array(
					'css' => array(
						'main' => '%%order_class%%',
					)
				),
				'filter_container_shadow'           => array(
					'css'         => array(
						'main' => '%%order_class%% .ags_woo_products_filters_child',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_container',
					'sub_toggle'  => 'background',
				),
				'filter_title_shadow'               => array(
					'css'         => array(
						'main' => "%%order_class%% .ags_woo_products_filters_child .ags-wc-filters-section-title",
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_title',
					'sub_toggle'  => 'background',
				),
				'filter_inner_shadow'               => array(
					'css'         => array(
						'main' => "%%order_class%% .ags_woo_products_filters_child .ags-wc-filters-section-inner",
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_inner',
					'sub_toggle'  => 'background',
				),
				'filter_select_dropdown_shadow'     => array(
					'css'         => array(
						'main' => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_select_dropdown',
					'sub_toggle'  => 'dropdown',
				),
				'filter_search_dropdown_shadow'     => array(
					'css'         => array(
						'main' => '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_search',
					'sub_toggle'  => 'dropdown',
					'priority'    => 60,
				),
				'filter_tagcloud_shadow'            => array(
					'css'         => array(
						'main' => '%%order_class%% .ags-wc-filters-tagcloud li label',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_tagcloud',
					'sub_toggle'  => 'background',
				),
				'products_number_shadow'            => array(
					'css'         => array(
						'main' => '%%order_class%% .ags-wc-filters-product-count',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'products_number',
					'sub_toggle'  => 'background',
				),
				'filters_buttons_container_shadow'  => array(
					'css'         => array(
						'main' => '%%order_class%% .ags-wc-filters-buttons',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filters_buttons_container',
					'sub_toggle'  => 'background',
				),
				'selected_filters_container_shadow' => array(
					'css'         => array(
						'main' => '%%order_class%% .ags-wc-filters-selected-main',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'selected_filters_container',
					'sub_toggle'  => 'background',
				),
				'selected_filters_title_shadow'     => array(
					'css'         => array(
						'main' => '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-section-title',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'selected_filters_title',
					'sub_toggle'  => 'background',
				),
				'selected_filters_inner_shadow'     => array(
					'css'         => array(
						'main' => '%%order_class%% .ags-wc-filters-selected-body',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'selected_filters_inner',
					'sub_toggle'  => 'background',
				),
				'selected_filter_shadow'            => array(
					'css'         => array(
						'main' => '%%order_class%% .ags-wc-filters-selected .ags-wc-filters-selected-inner',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'selected_filter',
					'sub_toggle'  => 'background',
				),
			),
			'borders'        => array(
				'default'                            => array(),
				'filter_container_border'            => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .ags_woo_products_filters_child',
							'border_styles' => '%%order_class%% .ags_woo_products_filters_child',
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_container',
					'sub_toggle'  => 'border',
				),
				'filter_title_border'                => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => "%%order_class%% .ags_woo_products_filters_child .ags-wc-filters-section-title",
							'border_styles' => "%%order_class%% .ags_woo_products_filters_child .ags-wc-filters-section-title",
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_title',
					'sub_toggle'  => 'border',
				),
				'filter_inner_border'                => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => "%%order_class%% .ags_woo_products_filters_child .ags-wc-filters-section-inner",
							'border_styles' => "%%order_class%% .ags_woo_products_filters_child .ags-wc-filters-section-inner",
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_inner',
					'sub_toggle'  => 'border',
				),
				'filter_radio_list_item_border'      => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .ags-wc-filters-radio-button-list li',
							'border_styles' => '%%order_class%% .ags-wc-filters-radio-button-list li',
						),
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_radio_list',
					'sub_toggle'  => 'list',
					'priority'    => 70,
				),
				'filter_checkbox_list_item_border'   => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .ags-wc-filters-checkbox-list li',
							'border_styles' => '%%order_class%% .ags-wc-filters-checkbox-list li',
						),
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_checkbox_list',
					'sub_toggle'  => 'list',
					'priority'    => 70,
				),
				'filter_select_dropdown_border'      => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options',
							'border_styles' => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options',
						),
					),
					'defaults'    => array(
						'border_radii'  => 'on|3px|3px|3px|3px',
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_select_dropdown',
					'sub_toggle'  => 'dropdown',
					'priority'    => 70,
				),
				'filter_select_dropdown_item_border' => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a',
							'border_styles' => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a',
						),
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_select_dropdown',
					'sub_toggle'  => 'dropdown_item',
					'priority'    => 70,
				),
				'filter_search_dropdown_border'      => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container',
							'border_styles' => '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container',
						),
					),
					'defaults'    => array(
						'border_radii'  => 'on|3px|3px|3px|3px',
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_search',
					'sub_toggle'  => 'dropdown',
					'priority'    => 70,
				),
				'filter_search_dropdown_item_border' => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a',
							'border_styles' => '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a',
						),
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_search',
					'sub_toggle'  => 'dropdown_item',
					'priority'    => 70,
				),
				'filter_tagcloud_border'             => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .ags-wc-filters-tagcloud li label',
							'border_styles' => '%%order_class%% .ags-wc-filters-tagcloud li label',
						),
					),
					'defaults'    => array(
						'border_radii'  => 'on|3px|3px|3px|3px',
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_tagcloud',
					'sub_toggle'  => 'border',
					'priority'    => 10,
				),
				'products_number_border'             => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .ags-wc-filters-product-count',
							'border_styles' => '%%order_class%% .ags-wc-filters-product-count',
						),
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'products_number',
					'sub_toggle'  => 'border',
				),
				'filters_buttons_container_border'   => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .ags-wc-filters-buttons',
							'border_styles' => '%%order_class%% .ags-wc-filters-buttons',
						),
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filters_buttons_container',
					'sub_toggle'  => 'border',
				),
				'selected_filters_container_border'  => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .ags-wc-filters-selected-main',
							'border_styles' => '%%order_class%% .ags-wc-filters-selected-main',
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'selected_filters_container',
					'sub_toggle'  => 'border',
				),
				'selected_filters_title_border'      => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-section-title',
							'border_styles' => '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-section-title',
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'color' => '#dadada',
							'style' => 'none',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'selected_filters_title',
					'sub_toggle'  => 'border',
				),
				'selected_filters_inner_border'      => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .ags-wc-filters-selected-body',
							'border_styles' => '%%order_class%% .ags-wc-filters-selected-body',
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'selected_filters_inner',
					'sub_toggle'  => 'border',
				),
				'selected_filter_border'             => array(
					'css'         => array(
						'main'      => array(
							'border_radii'  => '%%order_class%% .ags-wc-filters-selected .ags-wc-filters-selected-inner',
							'border_styles' => '%%order_class%% .ags-wc-filters-selected .ags-wc-filters-selected-inner',
						),
						'important' => true,
					),
					'defaults'    => array(
						'border_radii'  => 'on|3px|3px|3px|3px',
						'border_styles' => array(
							'width' => '1px',
							'color' => '#dadada',
							'style' => 'solid',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'selected_filter',
					'sub_toggle'  => 'border',
				),
			),
			'background'     => array(
				'label'                => esc_html__('Background Color', 'divi-shop-builder'),
				'use_background_color' => true,
				'options'              => array(
					'background_color'     => array(
						'depends_show_if' => 'on',
						'default'         => '#fff',
					),
					'use_background_color' => array(
						'default' => 'on',
					),
				),
				'css'                  => array(
					'main' => '%%order_class%%',
				),
			),
			'margin_padding' => array(
				'css' => array(
					'important' => false,
					'main'      => '%%order_class%%',
				),
			),
			'max_width'      => array(
				'css' => array(
					'main' => '%%order_class%%',
				),
			),
			'link_options'   => false,
			'text'           => false,
		);

		/**
		 * Advanced tab custom css fields
		 */
		$this->custom_css_fields = array(
			'filter'                    => array(
				'label'    => esc_html__('Filter', 'divi-shop-builder'),
				'selector' => '%%order_class%% .ags_woo_products_filters_child',
			),
			'filter_title'              => array(
				'label'    => esc_html__('Filter Title', 'divi-shop-builder'),
				'selector' => '%%order_class%% .ags_woo_products_filters_child .ags-wc-filters-section-title',
			),
			'filter_title_arrow'        => array(
				'label'    => esc_html__('Filter Toggle Arrow', 'divi-shop-builder'),
				'selector' => '%%order_class%% .ags_woo_products_filters_child .ags-wc-filters-section-toggle:after',
			),
			'filter_inner'              => array(
				'label'    => esc_html__('Filter Inner', 'divi-shop-builder'),
				'selector' => '%%order_class%% .ags_woo_products_filters_child .ags-wc-filters-section-inner',
			),
			'filters_buttons_container' => array(
				'label'    => esc_html__('Buttons Container', 'divi-shop-builder'),
				'selector' => '%%order_class%% .ags-wc-filters-buttons',
			),
			'apply_filters_button'      => array(
				'label'    => esc_html__('Apply Button', 'divi-shop-builder'),
				'selector' => '%%order_class%% .ags-wc-filters-button-apply',
			),
			'clear_filters_button'      => array(
				'label'    => esc_html__('Clear Button', 'divi-shop-builder'),
				'selector' => '%%order_class%% .ags-wc-filters-button-clear',
			),
			'selected_filters'          => array(
				'label'    => esc_html__('Selected Filters', 'divi-shop-builder'),
				'selector' => '%%order_class%% .ags-wc-filters-selected-main',
			),
			'selected_filters_title'    => array(
				'label'    => esc_html__('Selected Filters Title', 'divi-shop-builder'),
				'selector' => '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-section-title',
			),
			'selected_filters_inner'    => array(
				'label'    => esc_html__('Selected Filters Inner', 'divi-shop-builder'),
				'selector' => '%%order_class%% .ags-wc-filters-selected-body',
			),
			'selected_filter'           => array(
				'label'    => esc_html__('Selected Filter', 'divi-shop-builder'),
				'selector' => '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-inner',
			),
		);
	}

	function get_fields() {
		$fields = array(
			/*'view' => array(
				'label'            => esc_html__( 'View', 'divi-shop-builder' ),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => array(
					'sidebar' 		   => esc_html__( 'Sidebar', 'divi-shop-builder' ),
					'dropdown' 		   => esc_html__( 'Dropdown', 'divi-shop-builder' )
				),
				'description'      => esc_html__( 'Choose icon placement in navigation items.', 'divi-shop-builder' ),
				'default'		   => 'sidebar',
				'toggle_slug'	   => 'main_content'
			),*/
			'no_shop_module_warning'         => [
				'type'            => 'ags_wc_warning-DSB',
				'warningText'     => __('This module will not function properly on the front end of your website because there is no Woo Shop+ module with filtering enabled on the page.', 'divi-shop-builder'),
				'className'       => 'ags-wc-filters-no-shop-module-warning',
				'toggleVar'       => 'ags_wc_filters_noShopFilteringModule',
				'option_category' => 'basic_option',
				'toggle_slug'     => 'main_content'
			],
			'layout'               => array(
				'label'           => esc_html__('Layout', 'divi-shop-builder'),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => array(
					'vertical'    => esc_html__('Vertical (Column)', 'divi-shop-builder'),
					'horizontal' => esc_html__('Horizontal (Row)', 'divi-shop-builder')
				),
				'description'     => esc_html__('Choose the layout of the filters.', 'divi-shop-builder'),
				'default'         => 'vertical',
				'toggle_slug'     => 'main_content'
			),
			'horizontal_draggable'               => array(
				'label'           => esc_html__('Enable Horizontal Scroll for Filters', 'divi-shop-builder'),
				'description'     => esc_html__('This setting enables users on smaller devices to horizontally scroll through filter options that extend beyond the screen\'s viewable area, enhancing navigation and conserving space by providing easy access to all filters.', 'divi-shop-builder'),
				'type'            => 'yes_no_button',
				'options'         => array(
					'on'  => esc_html__('Yes', 'divi-shop-builder'),
					'off' => esc_html__('No', 'divi-shop-builder'),
				),
				'option_category' => 'basic_option',
				'default'         => 'on',
				'show_if' => array (
					'layout' => 'horizontal'
				),
				'toggle_slug'     => 'main_content'
			),
			'active_count' => array(
				'label'           => esc_html__('Show Active Filters Count', 'divi-shop-builder'),
				'description'     => esc_html__('Show the number of active filtering options in each filter heading.', 'divi-shop-builder'),
				'type'            => 'yes_no_button',
				'options'         => array(
					'on'  => esc_html__('Yes', 'divi-shop-builder'),
					'off' => esc_html__('No', 'divi-shop-builder'),
				),
				'option_category' => 'basic_option',
				'default'         => 'off',
				'toggle_slug'     => 'main_content'
			),
			'selected_filters'               => array(
				'label'           => esc_html__('Selected Filters', 'divi-shop-builder'),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => array(
					'top'    => esc_html__('Display at Top', 'divi-shop-builder'),
					'bottom' => esc_html__('Display at Bottom', 'divi-shop-builder'),
					'hide'   => esc_html__('Hide', 'divi-shop-builder')
				),
				'description'     => esc_html__('Choose position of selected filters.', 'divi-shop-builder'),
				'default'         => 'hide',
				'toggle_slug'     => 'main_content'
			),
			'display_selected_filters_title' => array(
				'label'           => esc_html__('Display Selected Filters Title', 'divi-shop-builder'),
				'description'     => esc_html__('Choose to show or hide the filters title.', 'divi-shop-builder'),
				'type'            => 'yes_no_button',
				'options'         => array(
					'on'  => esc_html__('Yes', 'divi-shop-builder'),
					'off' => esc_html__('No', 'divi-shop-builder'),
				),
				'option_category' => 'basic_option',
				'default'         => 'on',
				'toggle_slug'     => 'main_content',
				'show_if'         => array(
					'selected_filters' => array('top', 'bottom'),
				),
			),
			'selected_filters_title_text'    => array(
				'label'           => esc_html__('Selected Filters Title Text', 'divi-shop-builder'),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__('Text entered here will display as title.', 'divi-shop-builder'),
				'toggle_slug'     => 'main_content',
				'depends_on'      => array('display_selected_filters_title'),
				'depends_show_if' => 'on',
				'default'         => 'Selected',
			),
			'range_text_min_max'    => array(
				'label'           => esc_html__('Selected Range Filter Text (Min to Max)', 'divi-shop-builder'),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__('This text will display in the selected filters area for numeric range filters with minimum and maximum values specified. %filter% is replaced by the filter name, %min% by the minimum value, and %max% by the maximum value.', 'divi-shop-builder'),
				'toggle_slug'     => 'main_content',
				'show_if'         => ['display_selected_filters_title' => 'on'],
				// translators: default text for selected range filter min to max (%filter%, %min%, and %max% are placeholders)
				'default'         => esc_html__('%filter% from %min% to %max%', 'divi-shop-builder')
			),
			'range_text_min'    => array(
				'label'           => esc_html__('Selected Range Filter Text (Min)', 'divi-shop-builder'),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__('This text will display in the selected filters area for numeric range filters with only a minimum value specified. %filter% is replaced by the filter name and %min% by the minimum value.', 'divi-shop-builder'),
				'toggle_slug'     => 'main_content',
				'show_if'         => ['display_selected_filters_title' => 'on'],
				// translators: default text for selected range filter min to max (%filter%, %min%, and %max% are placeholders)
				'default'         => esc_html__('%filter% at least %min%', 'divi-shop-builder')
			),
			'range_text_max'    => array(
				'label'           => esc_html__('Selected Range Filter Text (Max)', 'divi-shop-builder'),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__('This text will display in the selected filters area for numeric range filters with only a maximum value specified. %filter% is replaced by the filter name and %max% by the maximum value.', 'divi-shop-builder'),
				'toggle_slug'     => 'main_content',
				'show_if'         => ['display_selected_filters_title' => 'on'],
				// translators: default text for selected range filter min to max (%filter%, %min%, and %max% are placeholders)
				'default'         => esc_html__('%filter% at most %max%', 'divi-shop-builder')
			),
			'apply_filters_button'           => array(
				'label'           => esc_html__('Apply Filters Button', 'divi-shop-builder'),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => array(
					'top'    => esc_html__('Display Before Filters', 'divi-shop-builder'),
					'bottom' => esc_html__('Display After Filters', 'divi-shop-builder'),
					'hide'   => esc_html__('Hide', 'divi-shop-builder')
				),
				'description'     => esc_html__('Choose position of Apply Filters Button.', 'divi-shop-builder'),
				'default'         => 'bottom',
				'toggle_slug'     => 'main_content'
			),
			'apply_filters_button_text'      => array(
				'label'           => esc_html__('Apply Filters Button Text', 'divi-shop-builder'),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__('Text entered here will appear within the button.', 'divi-shop-builder'),
				'toggle_slug'     => 'main_content',
				'default'         => esc_html__('Apply', 'divi-shop-builder')
			),
			'clear_all_filters_button'       => array(
				'label'           => esc_html__('Clear All Filters Button', 'divi-shop-builder'),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => array(
					'top'              => esc_html__('Display Before Filters', 'divi-shop-builder'),
					'bottom'           => esc_html__('Display After Filters', 'divi-shop-builder'),
					'selected_filters' => esc_html__('Display In The Selected Filters Section', 'divi-shop-builder'),
					'hide'             => esc_html__('Hide', 'divi-shop-builder')
				),
				'description'     => esc_html__('Choose position of Clear All Filters Button.', 'divi-shop-builder'),
				'default'         => 'bottom',
				'toggle_slug'     => 'main_content'
			),
			'clear_all_filters_button_text'  => array(
				'label'           => esc_html__('Clear All Filters Button Text', 'divi-shop-builder'),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__('Text entered here will appear within the button', 'divi-shop-builder'),
				'toggle_slug'     => 'main_content',
				'default'         => esc_html__('Clear All', 'divi-shop-builder')
			),
			'no_options_text'  => array(
				'label'           => esc_html__('No Filtering Options Available', 'divi-shop-builder'),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__('Text to show if there are no filtering options to display for a filter. %s is replaced by the filter title.', 'divi-shop-builder'),
				'toggle_slug'     => 'main_content',
				'default'         => esc_html__('There are no %s filtering options available for these products.', 'divi-shop-builder')
			),

			// ======================================================================
			// DESIGN TAB SETTINGS
			// ======================================================================

			// -----------------------------------------------------
			// Filter Settings
			// -----------------------------------------------------

			'filter_container_bg_color'       => array(
				'label'       => esc_html__('Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_container',
				'sub_toggle'  => 'background',
			),
			'filter_container_margin'         => array(
				'label'           => esc_html__('Margin', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => '||15px|',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_container',
				'sub_toggle'      => 'spacing',
			),
			'filter_container_padding'        => array(
				'label'           => esc_html__('Padding', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_container',
				'sub_toggle'      => 'spacing',
			),
			'filter_title_bg_color'           => array(
				'label'       => esc_html__('Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_title',
				'sub_toggle'  => 'background',
			),
			'filter_title_toggle_arrow_color' => array(
				'label'       => esc_html__('Toggled Title Arrow Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_title',
				'sub_toggle'  => 'toggle_arrow',
			),
			'filter_title_toggle_arrow_size'  => array(
				'label'          => esc_html__('Toggled Title Arrow Size', 'divi-shop-builder'),
				'description'    => esc_html__('Adjust the size of arrow. Allowed units px.', 'divi-shop-builder'),
				'type'           => 'range',
				'default'        => '20px',
				'mobile_options' => true,
				'default_unit'   => 'px',
				'validate_unit'  => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '50',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'filter_title',
				'sub_toggle'     => 'toggle_arrow',
			),
			'filter_inner_bg_color'           => array(
				'label'       => esc_html__('Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_inner',
				'sub_toggle'  => 'background',
			),

			// -----------------------------------------------------
			// Radio Settings
			// -----------------------------------------------------

			'filter_radio_style_enable'       => array(
				'label'           => esc_html__('Custom Radio Styles', 'divi-shop-builder'),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => array(
					'off' => esc_html__('No', 'divi-shop-builder'),
					'on'  => esc_html__('Yes', 'divi-shop-builder'),
				),
				'default'         => 'on',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_radio_list',
				'sub_toggle'      => 'radio',
			),
			'radio_checked_background_color'  => array(
				'label'        => esc_html__('Checked Background Color', 'divi-shop-builder'),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'default'      => $this->accent_color,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'filter_radio_list',
				'sub_toggle'   => 'radio',
				'show_if'      => array(
					'filter_radio_style_enable' => 'on',
				),
			),
			'radio_background_color'          => array(
				'label'        => esc_html__('Background Color', 'divi-shop-builder'),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'default'      => '#eeeeee',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'filter_radio_list',
				'sub_toggle'   => 'radio',
				'show_if'      => array(
					'filter_radio_style_enable' => 'on',
				),
			),
			'filter_radio_list_item_bg_color' => array(
				'label'       => esc_html__('List Item Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_radio_list',
				'sub_toggle'  => 'list',
			),
			'filter_radio_list_item_color'    => array(
				'label'       => esc_html__('List Item Text Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_radio_list',
				'sub_toggle'  => 'list',
			),
			'filter_radio_list_item_margin'   => array(
				'label'           => esc_html__('List Item Margin', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => '4px|0|4px|0',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_radio_list',
				'sub_toggle'      => 'list',
			),
			'filter_radio_list_item_padding'  => array(
				'label'           => esc_html__('List Item Padding', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => '',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_radio_list',
				'sub_toggle'      => 'list',
			),

			// -----------------------------------------------------
			// Checkbox Settings
			// -----------------------------------------------------

			'filter_checkbox_style_enable'       => array(
				'label'           => esc_html__('Custom Checkbox Styles', 'divi-shop-builder'),
				'type'            => 'yes_no_button',
				'option_category' => 'basic_option',
				'options'         => array(
					'off' => esc_html__('No', 'divi-shop-builder'),
					'on'  => esc_html__('Yes', 'divi-shop-builder'),
				),
				'default'         => 'on',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_checkbox_list',
				'sub_toggle'      => 'checkbox',
			),
			'checkbox_checked_color'             => array(
				'label'        => esc_html__('Checked Color', 'divi-shop-builder'),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'default'      => $this->accent_color,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'filter_checkbox_list',
				'sub_toggle'   => 'checkbox',
				'show_if'      => array(
					'filter_checkbox_style_enable' => 'on',
				),
			),
			'checkbox_checked_background_color'  => array(
				'label'        => esc_html__('Checked Background Color', 'divi-shop-builder'),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'default'      => '#eeeeee',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'filter_checkbox_list',
				'sub_toggle'   => 'checkbox',
				'show_if'      => array(
					'filter_checkbox_style_enable' => 'on',
				),
			),
			'checkbox_background_color'          => array(
				'label'        => esc_html__('Background Color', 'divi-shop-builder'),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'default'      => '#eeeeee',
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'filter_checkbox_list',
				'sub_toggle'   => 'checkbox',
				'show_if'      => array(
					'filter_checkbox_style_enable' => 'on',
				),
			),
			'filter_checkbox_list_item_bg_color' => array(
				'label'       => esc_html__('List Item Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_checkbox_list',
				'sub_toggle'  => 'list',
			),
			'filter_checkbox_list_item_color'    => array(
				'label'       => esc_html__('List Item Text Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_checkbox_list',
				'sub_toggle'  => 'list',
			),
			'filter_checkbox_list_item_margin'   => array(
				'label'           => esc_html__('List Item Margin', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => '4px|0|4px|0',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_checkbox_list',
				'sub_toggle'      => 'list',
			),
			'filter_checkbox_list_item_padding'  => array(
				'label'           => esc_html__('List Item Padding', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => '',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_checkbox_list',
				'sub_toggle'      => 'list',
			),

			// -----------------------------------------------------
			// Select Dropdown
			// -----------------------------------------------------

			'filter_select_dropdown_bg_color'        => array(
				'label'       => esc_html__('Select Dropdown Background', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_select_dropdown',
				'sub_toggle'  => 'dropdown',
			),
			'filter_select_dropdown_margin'          => array(
				'label'           => esc_html__('Dropdown Margin', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => '',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_select_dropdown',
				'sub_toggle'      => 'dropdown',
			),
			'filter_select_dropdown_padding'         => array(
				'label'           => esc_html__('Dropdown Padding', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => '15px|0|15px|0',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_select_dropdown',
				'sub_toggle'      => 'dropdown',
			),
			'filter_select_dropdown_arrow_enable'    => array(
				'label'           => esc_html__('Use Dropdown Arrow', 'divi-shop-builder'),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__('No', 'divi-shop-builder'),
					'on'  => esc_html__('Yes', 'divi-shop-builder'),
				),
				'default'         => 'off',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_select_dropdown',
				'sub_toggle'      => 'dropdown',
			),
			'filter_select_dropdown_arrow_size'      => array(
				'label'          => esc_html__('Dropdown Arrow Size', 'divi-shop-builder'),
				'description'    => esc_html__('Adjust the size of dropdown arrow. Allowed units px.', 'divi-shop-builder'),
				'type'           => 'range',
				'default'        => '15px',
				'mobile_options' => true,
				'default_unit'   => 'px',
				'validate_unit'  => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '50',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'filter_select_dropdown',
				'sub_toggle'     => 'dropdown',
				'show_if'        => array('filter_select_dropdown_arrow_enable' => 'on'),
			),
			'filter_select_dropdown_arrow_alignment' => array(
				'label'           => esc_html__('Dropdown Arrow Alignment', 'divi-shop-builder'),
				'description'     => esc_html__('Align the dropdown arrow to the left, center or right.', 'divi-shop-builder'),
				'type'            => 'multiple_buttons',
				'options'         => array(
					'left'   => array(
						'title' => esc_html__('Left', 'divi-shop-builder'),
						'icon'  => 'align-left',
					),
					'center' => array(
						'title' => esc_html__('Center', 'divi-shop-builder'),
						'icon'  => 'align-center',
					),
					'right'  => array(
						'title' => esc_html__('Right', 'divi-shop-builder'),
						'icon'  => 'align-right',
					),
				),
				'default'         => 'right',
				'multi_selection' => false,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_select_dropdown',
				'sub_toggle'      => 'dropdown',
				'show_if'         => array('filter_select_dropdown_arrow_enable' => 'on'),
			),
			'filter_select_dropdown_arrow_offset'    => array(
				'label'          => esc_html__('Dropdown Arrow Offset', 'divi-shop-builder'),
				'description'    => esc_html__('Define the horizontal arrow\'s offset distance from the right or left edge of the dropdown. Allowed units px.', 'divi-shop-builder'),
				'type'           => 'range',
				'default'        => '25px',
				'default_unit'   => 'px',
				'validate_unit'  => true,
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'filter_select_dropdown',
				'sub_toggle'     => 'dropdown',
				'show_if'        => array(
					'filter_select_dropdown_arrow_alignment' => array('left', 'right'),
					'filter_select_dropdown_arrow_enable'    => 'on',
				),
			),

			// -----------------------------------------------------
			// Select Dropdown Item
			// -----------------------------------------------------

			'filter_select_dropdown_item_bg_color'             => array(
				'label'       => esc_html__('Dropdown Item Background', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_select_dropdown',
				'sub_toggle'  => 'dropdown_item',
			),
			'filter_select_dropdown_item_color'                => array(
				'label'       => esc_html__('Dropdown Item Text Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_select_dropdown',
				'sub_toggle'  => 'dropdown_item',
			),
			'filter_select_dropdown_item_selected_bg_color'    => array(
				'label'       => esc_html__('Selected Dropdown Item Background', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_select_dropdown',
				'sub_toggle'  => 'dropdown_item',
			),
			'filter_select_dropdown_item_selected_color'       => array(
				'label'       => esc_html__('Selected Dropdown Item Text Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_select_dropdown',
				'sub_toggle'  => 'dropdown_item',
			),
			'filter_select_dropdown_item_selected_check_color' => array(
				'label'       => esc_html__('Selected Item Check Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'default'     => $this->accent_color,
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_select_dropdown',
				'sub_toggle'  => 'dropdown_item',
			),
			'filter_select_dropdown_item_margin'               => array(
				'label'           => esc_html__('Dropdown Item Margin', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => '',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_select_dropdown',
				'sub_toggle'      => 'dropdown_item',
			),
			'filter_select_dropdown_item_padding'              => array(
				'label'           => esc_html__('Dropdown Item Padding', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => '10px|12px|10px|12px',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_select_dropdown',
				'sub_toggle'      => 'dropdown_item',
			),

			// -----------------------------------------------------
			// Search Filter
			// -----------------------------------------------------

			'filter_search_icon_color'       => array(
				'label'       => esc_html__('Search Icon Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_search',
				'sub_toggle'  => 'icon',
			),
			'filter_search_focus_icon_color' => array(
				'label'       => esc_html__('Search Field Focus Icon Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_search',
				'sub_toggle'  => 'icon',
			),
			'filter_search_icon_size'        => array(
				'label'          => esc_html__('Search Icon Size', 'divi-shop-builder'),
				'description'    => esc_html__('Increase or decrease the size of the search icon. ', 'divi-shop-builder'),
				'type'           => 'range',
				'default'        => '18px',
				'mobile_options' => true,
				'default_unit'   => 'px',
				'validate_unit'  => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'filter_search',
				'sub_toggle'     => 'icon',
			),
			'filter_search_icon_position'    => array(
				'label'       => esc_html__('Search Icon Position', 'divi-shop-builder'),
				'type'        => 'select',
				'default'     => 'right',
				'options'     => array(
					'left'  => esc_html__('Left', 'divi-shop-builder'),
					'right' => esc_html__('Right', 'divi-shop-builder'),
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_search',
				'sub_toggle'  => 'icon',
			),

			'filter_search_dropdown_bg_color'        => array(
				'label'       => esc_html__('Search Dropdown Background', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_search',
				'sub_toggle'  => 'dropdown',
			),
			'filter_search_dropdown_margin'          => array(
				'label'           => esc_html__('Dropdown Margin', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => '',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_search',
				'sub_toggle'      => 'dropdown',
			),
			'filter_search_dropdown_padding'         => array(
				'label'           => esc_html__('Dropdown Padding', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => '15px|0|15px|0',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_search',
				'sub_toggle'      => 'dropdown',
			),
			'filter_search_dropdown_arrow_enable'    => array(
				'label'           => esc_html__('Use Search Dropdown Arrow', 'divi-shop-builder'),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__('No', 'divi-shop-builder'),
					'on'  => esc_html__('Yes', 'divi-shop-builder'),
				),
				'default'         => 'off',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_search',
				'sub_toggle'      => 'dropdown',
			),
			'filter_search_dropdown_arrow_size'      => array(
				'label'          => esc_html__('Search Dropdown Arrow Size', 'divi-shop-builder'),
				'description'    => esc_html__('Adjust the size of dropdown arrow. Allowed units px.', 'divi-shop-builder'),
				'type'           => 'range',
				'default'        => '15px',
				'mobile_options' => true,
				'default_unit'   => 'px',
				'validate_unit'  => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '50',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'filter_search',
				'sub_toggle'     => 'dropdown',
				'show_if'        => array('filter_search_dropdown_arrow_enable' => 'on'),
			),
			'filter_search_dropdown_arrow_alignment' => array(
				'label'           => esc_html__('Search Dropdown Arrow Alignment', 'divi-shop-builder'),
				'description'     => esc_html__('Align the dropdown arrow to the left, center or right.', 'divi-shop-builder'),
				'type'            => 'multiple_buttons',
				'options'         => array(
					'left'   => array(
						'title' => esc_html__('Left', 'divi-shop-builder'),
						'icon'  => 'align-left',
					),
					'center' => array(
						'title' => esc_html__('Center', 'divi-shop-builder'),
						'icon'  => 'align-center',
					),
					'right'  => array(
						'title' => esc_html__('Right', 'divi-shop-builder'),
						'icon'  => 'align-right',
					),
				),
				'default'         => 'right',
				'multi_selection' => false,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_search',
				'sub_toggle'      => 'dropdown',
				'show_if'         => array('filter_search_dropdown_arrow_enable' => 'on'),
			),
			'filter_search_dropdown_arrow_offset'    => array(
				'label'          => esc_html__('Search Dropdown Arrow Offset', 'divi-shop-builder'),
				'description'    => esc_html__('Define the horizontal arrow\'s offset distance from the right or left edge of the dropdown. Allowed units px.', 'divi-shop-builder'),
				'type'           => 'range',
				'default'        => '25px',
				'default_unit'   => 'px',
				'validate_unit'  => true,
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'filter_search',
				'sub_toggle'     => 'dropdown',
				'show_if'        => array(
					'filter_search_dropdown_arrow_alignment' => array('left', 'right'),
					'filter_search_dropdown_arrow_enable'    => 'on',
				),
			),

			'filter_search_dropdown_item_bg_color' => array(
				'label'       => esc_html__('Dropdown Item Background', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_search',
				'sub_toggle'  => 'dropdown_item',
			),
			'filter_search_dropdown_item_color'    => array(
				'label'       => esc_html__('Dropdown Item Text Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_search',
				'sub_toggle'  => 'dropdown_item',
			),
			'filter_search_dropdown_item_margin'   => array(
				'label'           => esc_html__('Dropdown Item Margin', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => '',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_search',
				'sub_toggle'      => 'dropdown_item',
			),
			'filter_search_dropdown_item_padding'  => array(
				'label'           => esc_html__('Dropdown Item Padding', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => '10px|12px|10px|12px',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_search',
				'sub_toggle'      => 'dropdown_item',
			),

			// -----------------------------------------------------
			// Price Filter
			// -----------------------------------------------------

			'filter_price_range_slider_bg_color'         => array(
				'label'       => esc_html__('Range Slider Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '#EEE',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_price',
			),
			'filter_price_range_slider_color'            => array(
				'label'       => esc_html__('Range Slider Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => $this->accent_color,
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_price',
			),
			'filter_price_range_slider_radius'           => array(
				'label'          => esc_html__('Range Slider Border Radius', 'divi-shop-builder'),
				'description'    => esc_html__('Adjust the border radius of range slider. Allowed units px and %.', 'divi-shop-builder'),
				'type'           => 'range',
				'default'        => '3px',
				'default_unit'   => 'px, %',
				'validate_unit'  => true,
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'filter_price',
			),
			'filter_price_range_slider_pointer_color'    => array(
				'label'       => esc_html__('Range Slider Pointer Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => $this->accent_color,
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_price',
			),
			'filter_price_range_slider_pointer_radius'   => array(
				'label'          => esc_html__('Range Slider Pointer Border Radius', 'divi-shop-builder'),
				'description'    => esc_html__('Adjust the border radius of range slider pointer. Allowed units px and %.', 'divi-shop-builder'),
				'type'           => 'range',
				'default'        => '50%',
				'default_unit'   => 'px, %',
				'validate_unit'  => true,
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'filter_price',
			),
			'filter_price_range_slider_tooltip_bg_color' => array(
				'label'       => esc_html__('Range Slider Tooltip Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '#4e4e4e',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_price',
			),
			'filter_price_range_slider_tooltip_color'    => array(
				'label'       => esc_html__('Range Slider Tooltip Text Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '#fff',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_price',
			),
			'filter_price_range_slider_tooltip_radius'   => array(
				'label'          => esc_html__('Range Slider Tooltip Border Radius', 'divi-shop-builder'),
				'description'    => esc_html__('Adjust the border radius of range slider tooltip. Allowed units px.', 'divi-shop-builder'),
				'type'           => 'range',
				'default'        => '3px',
				'default_unit'   => 'px',
				'validate_unit'  => true,
				'range_settings' => array(
					'min'  => '0',
					'max'  => '50',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'filter_price',
			),

			// -----------------------------------------------------
			// Tagcloud
			// -----------------------------------------------------

			'filter_tagcloud_tag_bg_color'            => array(
				'label'       => esc_html__('Tag Background', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '#f9f9f9',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_tagcloud',
				'sub_toggle'  => 'background',
			),
			'filter_tagcloud_tag_active_bg_color'     => array(
				'label'       => esc_html__('Active Tag Background', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'default'     => $this->accent_color,
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_tagcloud',
				'sub_toggle'  => 'background',
			),
			'filter_tagcloud_tag_text_color'          => array(
				'label'       => esc_html__('Tag Text Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_tagcloud',
				'sub_toggle'  => 'p',
			),
			'filter_tagcloud_tag_active_text_color'   => array(
				'label'       => esc_html__('Active Tag Text Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'default'     => '#fff',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_tagcloud',
				'sub_toggle'  => 'p',
			),
			'filter_tagcloud_tag_active_border_color' => array(
				'label'       => esc_html__('Active Tag Border Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_tagcloud',
				'sub_toggle'  => 'border',
				'priority'    => 100,
			),

			// -----------------------------------------------------
			// Rating
			// -----------------------------------------------------

			'filter_rating_star_color'             => array(
				'label'       => esc_html__('Star Rating Color', 'divi-shop-builder'),
				'description' => esc_html__('Here you can define a custom color for active rating icons.', 'divi-shop-builder'),
				'default'     => $this->accent_color,
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_rating',
			),
			'filter_rating_star_placeholder_color' => array(
				'label'       => esc_html__('Non-Active Star Rating Color', 'divi-shop-builder'),
				'description' => esc_html__('Here you can define a custom color for the placeholder star rating icon.', 'divi-shop-builder'),
				'default'     => '#ccc',
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_rating',
			),
			'filter_rating_star_hover_color'       => array(
				'label'       => esc_html__('Hover Star Color', 'divi-shop-builder'),
				'description' => esc_html__('Here you can define a custom color for rating icons on hover.', 'divi-shop-builder'),
				'default'     => '#2e86c5',
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_rating',
			),
			'filter_rating_size'                   => array(
				'label'          => esc_html__('Star Rating Size', 'divi-shop-builder'),
				'description'    => esc_html__('Increase or decrease the size of the star rating icon. ', 'divi-shop-builder'),
				'type'           => 'range',
				'default'        => '16px',
				'mobile_options' => true,
				'default_unit'   => 'px',
				'validate_unit'  => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'filter_rating',
			),
			'filter_rating_spacing'                => array(
				'label'          => esc_html__('Star Rating Letter Spacing', 'divi-shop-builder'),
				'description'    => esc_html__('Increase or decrease the spacing between the icons in the star rating. Use em, rem, px units.', 'divi-shop-builder'),
				'type'           => 'range',
				'default'        => '2px',
				'allowed_units'  => array('em', 'rem', 'px'),
				'validate_unit'  => true,
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'mobile_options' => true,
				'sticky'         => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'filter_rating',
			),

			// -----------------------------------------------------
			// Products Number
			// -----------------------------------------------------

			'products_number_bg_color' => array(
				'label'       => esc_html__('Products Number Background', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'products_number',
				'sub_toggle'  => 'background',
			),

			// -----------------------------------------------------
			// Filters Buttons
			// -----------------------------------------------------

			'filters_buttons_alignment'          => array(
				'label'           => esc_html__('Buttons Alignment', 'divi-shop-builder'),
				'description'     => esc_html__('Align the buttons to the left, center or right.', 'divi-shop-builder'),
				'type'            => 'multiple_buttons',
				'options'         => array(
					'flex-start' => array(
						'title' => esc_html__('Left', 'divi-shop-builder'),
						'icon'  => 'align-left',
					),
					'center'     => array(
						'title' => esc_html__('Center', 'divi-shop-builder'),
						'icon'  => 'align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__('Right', 'divi-shop-builder'),
						'icon'  => 'align-right',
					),
				),
				'default'         => 'center',
				'mobile_options'  => true,
				'responsive'      => true,
				'toggleable'      => true,
				'multi_selection' => false,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filters_buttons_container',
				'sub_toggle'      => 'general',
			),
			'filters_buttons_container_bg_color' => array(
				'label'       => esc_html__('Buttons Container Background', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filters_buttons_container',
				'sub_toggle'  => 'background',
			),

			// -----------------------------------------------------
			// Selected Filters Settings
			// -----------------------------------------------------

			'selected_filters_alignment'              => array(
				'label'           => esc_html__('Selected Filters Alignment', 'divi-shop-builder'),
				'description'     => esc_html__('Align the selected filters to the left, center or right.', 'divi-shop-builder'),
				'type'            => 'multiple_buttons',
				'options'         => array(
					'flex-start' => array(
						'title' => esc_html__('Left', 'divi-shop-builder'),
						'icon'  => 'align-left',
					),
					'center'     => array(
						'title' => esc_html__('Center', 'divi-shop-builder'),
						'icon'  => 'align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__('Right', 'divi-shop-builder'),
						'icon'  => 'align-right',
					),
				),
				'default'         => 'flex-start',
				'mobile_options'  => true,
				'responsive'      => true,
				'toggleable'      => true,
				'multi_selection' => false,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'selected_filters_container',
				'sub_toggle'      => 'general',
			),
			'selected_filters_clear_button_alignment' => array(
				'label'           => esc_html__('Clear Button Alignment', 'divi-shop-builder'),
				'type'            => 'multiple_buttons',
				'options'         => array(
					'flex-start' => array(
						'title' => esc_html__('Left', 'divi-shop-builder'),
						'icon'  => 'align-left',
					),
					'center'     => array(
						'title' => esc_html__('Center', 'divi-shop-builder'),
						'icon'  => 'align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__('Right', 'divi-shop-builder'),
						'icon'  => 'align-right',
					),
				),
				'default'         => 'flex-start',
				'mobile_options'  => true,
				'responsive'      => true,
				'toggleable'      => true,
				'multi_selection' => false,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'selected_filters_container',
				'sub_toggle'      => 'general',
			),
			'selected_filters_container_bg_color'     => array(
				'label'       => esc_html__('Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'selected_filters_container',
				'sub_toggle'  => 'background',
			),
			'selected_filters_title_bg_color'         => array(
				'label'       => esc_html__('Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'selected_filters_title',
				'sub_toggle'  => 'background',
			),
			'selected_filters_inner_bg_color'         => array(
				'label'       => esc_html__('Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'selected_filters_inner',
				'sub_toggle'  => 'background',
			),

			// -----------------------------------------------------
			// Selected Filter Settings
			// -----------------------------------------------------

			'selected_filter_bg_color'            => array(
				'label'       => esc_html__('Selected Filter Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'selected_filter',
				'sub_toggle'  => 'background',
			),
			'selected_filter_clear_icon_color'    => array(
				'label'       => esc_html__('Clear Filter Icon Color', 'divi-shop-builder'),
				'description' => esc_html__('Here you can define a custom color for clear filter icon.', 'divi-shop-builder'),
				'hover'       => 'tabs',
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'selected_filter',
				'sub_toggle'  => 'remove',
			),
			'selected_filter_clear_icon_size'     => array(
				'label'          => esc_html__('Clear Filter Icon Size', 'divi-shop-builder'),
				'description'    => esc_html__('Increase or decrease the size of the clear filter icon. ', 'divi-shop-builder'),
				'type'           => 'range',
				'default'        => '20px',
				'mobile_options' => true,
				'default_unit'   => 'px',
				'validate_unit'  => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'selected_filter',
				'sub_toggle'     => 'remove',
			),
			'selected_filter_clear_icon_spacing'  => array(
				'label'          => esc_html__('Clear Filter Icon Spacing', 'divi-shop-builder'),
				'description'    => esc_html__('Adjust the spacing of clear filter icon. Allowed units px.', 'divi-shop-builder'),
				'type'           => 'range',
				'default'        => '5px',
				'default_unit'   => 'px',
				'validate_unit'  => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '50',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'selected_filter',
				'sub_toggle'     => 'remove',
			),
			'selected_filter_clear_icon_position' => array(
				'label'       => esc_html__('Clear Filter Icon Position', 'divi-shop-builder'),
				'description' => esc_html__('Select the position for the clear filter icon. Choose to display before or after text.', 'divi-shop-builder'),
				'type'        => 'select',
				'default'     => 'before',
				'options'     => array(
					'before' => esc_html__('Before Text', 'divi-shop-builder'),
					'after'  => esc_html__('After Text', 'divi-shop-builder'),
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'selected_filter',
				'sub_toggle'  => 'remove',
			),
		);

		// Paddings, Margins Fields
		foreach ( self::$margin_padding_elements as $elementId => $params ) {

			$default_margin  = isset($params['default_margin']) ? $params['default_margin'] : '';
			$default_padding = isset($params['default_padding']) ? $params['default_padding'] : '';

			$fields[ $elementId . '_padding' ] = array(
				'label'           => esc_html__('Padding', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => $default_padding,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => $elementId,
				'sub_toggle'      => $params['sub_toggle'],
			);
			$fields[ $elementId . '_margin' ]  = array(
				'label'           => esc_html__('Margin', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => $default_margin,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => $elementId,
				'sub_toggle'      => $params['sub_toggle'],
			);
		}

		return $fields;
	}

	/**
	 *  Used to generate responsive module CSS
	 *  Custom margin is based on update_styles() function.
	 *  Divi/includes/builder/module/field/MarginPadding.php
	 *
	 */
	private function apply_responsive($value, $selector, $css, $render_slug, $type, $default = null, $important = false) {

		$dstc_last_edited       = $this->props[ $value . '_last_edited' ];
		$dstc_responsive_active = et_pb_get_responsive_status($dstc_last_edited);

		switch ( $type ) {
			case 'custom_margin':

				$all_values = $this->props;
				$responsive = ET_Builder_Module_Helper_ResponsiveOptions::instance();

				// Responsive.
				$is_responsive = $responsive->is_responsive_enabled($all_values, $value);

				$margin_desktop = $responsive->get_any_value($all_values, $value);
				$margin_tablet  = $is_responsive ? $responsive->get_any_value($all_values, "{$value}_tablet") : '';
				$margin_phone   = $is_responsive ? $responsive->get_any_value($all_values, "{$value}_phone") : '';

				$styles = array(
					'desktop' => '' !== $margin_desktop ? rtrim(et_builder_get_element_style_css($margin_desktop, $css, $important)) : '',
					'tablet'  => '' !== $margin_tablet ? rtrim(et_builder_get_element_style_css($margin_tablet, $css, $important)) : '',
					'phone'   => '' !== $margin_phone ? rtrim(et_builder_get_element_style_css($margin_phone, $css, $important)) : '',
				);

				$responsive->declare_responsive_css($styles, $selector, $render_slug, $important);

				break;
			case 'alignment':
				$align        = esc_html($this->get_alignment());
				$align_tablet = esc_html($this->get_alignment('tablet'));
				$align_phone  = esc_html($this->get_alignment('phone'));

				// Responsive Image Alignment.
				// Set CSS properties and values for the image alignment.
				// 1. Text Align is necessary, just set it from current image alignment value.
				// 2. Margin {Side} is optional. Used to pull the image to right/left side.
				// 3. Margin Left and Right are optional. Used by Center to reset custom margin of point 2.
				$dstc_array = array(
					'desktop' => array(
						'text-align'    => $align,
						'margin-left'   => 'left' !== $align ? 'auto' : '',
						'margin-right'  => 'left' !== $align ? 'auto' : '',
						"margin-$align" => ! empty($align) && 'center' !== $align ? '0' : '',
					),
				);

				if ( ! empty($align_tablet) ) {
					$dstc_array['tablet'] = array(
						'text-align'           => $align_tablet,
						'margin-left'          => 'left' !== $align_tablet ? 'auto' : '',
						'margin-right'         => 'left' !== $align_tablet ? 'auto' : '',
						"margin-$align_tablet" => ! empty($align_tablet) && 'center' !== $align_tablet ? '0' : '',
					);
				}

				if ( ! empty($align_phone) ) {
					$dstc_array['phone'] = array(
						'text-align'          => $align_phone,
						'margin-left'         => 'left' !== $align_phone ? 'auto' : '',
						'margin-right'        => 'left' !== $align_phone ? 'auto' : '',
						"margin-$align_phone" => ! empty($align_phone) && 'center' !== $align_phone ? '0' : '',
					);
				}
				et_pb_responsive_options()->generate_responsive_css($dstc_array, $selector, $css, $render_slug, $important ? '!important' : '', $type);
				break;

			default:
				$re          = array('|', 'true', 'false');
				$dstc        = trim(str_replace($re, ' ', $this->props[ $value ]));
				$dstc_tablet = trim(str_replace($re, ' ', $this->props[ $value . '_tablet' ]));
				$dstc_phone  = trim(str_replace($re, ' ', $this->props[ $value . '_phone' ]));

				$dstc_array = array(
					'desktop' => esc_html($dstc),
					'tablet'  => $dstc_responsive_active ? esc_html($dstc_tablet) : '',
					'phone'   => $dstc_responsive_active ? esc_html($dstc_phone) : '',
				);
				et_pb_responsive_options()->generate_responsive_css($dstc_array, $selector, $css, $render_slug, $important ? '!important' : '', $type);
		}

	}

	/**
	 * @since
	 */
	private function css($render_slug) {

		$props     = $this->props;
		$css_props = [];

		// -----------------------------------------------------
		// Responsive CSS
		// -----------------------------------------------------

		// Paddings and Margins
		foreach ( self::$margin_padding_elements as $elementId => $params ) {
			$this->apply_responsive($elementId . '_padding', $params['selector'], 'padding', $render_slug, 'custom_margin', isset($params['default_padding']) ? $params['default_padding'] : '');
			$this->apply_responsive($elementId . '_margin', $params['selector'], 'margin', $render_slug, 'custom_margin', isset($params['default_margin']) ? $params['default_margin'] : '');
		}

		// - Single Filter
		$this->apply_responsive('filter_container_padding', '%%order_class%% .ags_woo_products_filters_child', 'padding', $render_slug, 'custom_margin');
		$this->apply_responsive('filter_container_margin', '%%order_class%% .ags_woo_products_filters_child', 'margin', $render_slug, 'custom_margin', '||15px|', true);

		// - Radio List Item
		$this->apply_responsive('filter_radio_list_item_padding', '%%order_class%% .ags-wc-filters-radio-button-list li', 'padding', $render_slug, 'custom_margin');
		$this->apply_responsive('filter_radio_list_item_margin', '%%order_class%% .ags-wc-filters-radio-button-list li', 'margin', $render_slug, 'custom_margin', '4px|0|4px|0');

		// - Checkbox List Item
		$this->apply_responsive('filter_checkbox_list_item_padding', '%%order_class%% .ags-wc-filters-checkbox-list li', 'padding', $render_slug, 'custom_margin');
		$this->apply_responsive('filter_checkbox_list_item_margin', '%%order_class%% .ags-wc-filters-checkbox-list li', 'margin', $render_slug, 'custom_margin', '4px|0|4px|0');

		// - Select Dropdown
		$this->apply_responsive('filter_select_dropdown_padding', '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options', 'padding', $render_slug, 'custom_margin', '15px|0|15px|0');
		$this->apply_responsive('filter_select_dropdown_margin', '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options', 'margin', $render_slug, 'custom_margin', '', true);

		// - Select Dropdown Item
		$this->apply_responsive('filter_select_dropdown_item_padding', '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a label', 'padding', $render_slug, 'custom_margin', '10px|12px|10px|12px');
		$this->apply_responsive('filter_select_dropdown_item_margin', '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a label', 'margin', $render_slug, 'custom_margin');

		// - Search Dropdown
		$this->apply_responsive('filter_search_dropdown_padding', '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container', 'padding', $render_slug, 'custom_margin', '15px|0|15px|0');
		$this->apply_responsive('filter_search_dropdown_margin', '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container', 'margin', $render_slug, 'custom_margin', '', true);

		// - Search Dropdown Item
		$this->apply_responsive('filter_search_dropdown_item_padding', '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a', 'padding', $render_slug, 'custom_margin', '10px|12px|10px|12px');
		$this->apply_responsive('filter_search_dropdown_item_margin', '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a', 'margin', $render_slug, 'custom_margin');

		// Search Icon
		$this->apply_responsive('filter_search_icon_size', '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-icon .ags-wc-filters-search-input-wrapper:after', 'font-size', $render_slug, 'default', '18px');

		// Toggled Title Arrow
		$this->apply_responsive('filter_title_toggle_arrow_size', '%%order_class%% .ags-wc-filters-section-title.ags-wc-filters-section-toggle::after', 'font-size', $render_slug, 'default', '20px');

		// Rating
		$this->apply_responsive('filter_rating_spacing', '%%order_class%% .ags-wc-filters-stars', 'letter-spacing', $render_slug, 'default', '2px');
		$this->apply_responsive('filter_rating_size', '%%order_class%% .ags-wc-filters-stars', 'font-size', $render_slug, 'default', '16px');

		// Buttons Alignment
		$this->apply_responsive('filters_buttons_alignment', '%%order_class%% .ags-wc-filters-buttons', 'justify-content', $render_slug, 'default', 'center');

		// Selected Filters
		$this->apply_responsive('selected_filters_alignment', '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected', 'justify-content', $render_slug, 'default', 'flex-start');
		$this->apply_responsive('selected_filters_clear_button_alignment', '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-body', 'justify-content', $render_slug, 'default', 'flex-start');
		$this->apply_responsive('selected_filter_clear_icon_size', '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-inner .ags-wc-filters-remove:before', 'font-size', $render_slug, 'default', '20px');

		// -----------------------------------------------------
		// CSS
		// -----------------------------------------------------

		if ( '' !== $props['filter_container_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags_woo_products_filters_child',
					'declaration' => sprintf('background-color:%s;', esc_attr($props['filter_container_bg_color'])),
				)
			);
		}
		if ( '' !== $props['filter_title_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags_woo_products_filters_child .ags-wc-filters-section-title',
					'declaration' => sprintf('background-color:%s;', esc_attr($props['filter_title_bg_color'])),
				)
			);
		}
		if ( '' !== $props['filter_inner_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags_woo_products_filters_child .ags-wc-filters-section-inner',
					'declaration' => sprintf('background-color:%s;', esc_attr($props['filter_inner_bg_color'])),
				)
			);
		}
		if ( '' !== $props['filter_select_dropdown_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options',
					'declaration' => sprintf('background-color:%s !important;', esc_attr($props['filter_select_dropdown_bg_color'])),
				)
			);
		}
		if ( '' !== $props['filter_search_dropdown_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container',
					'declaration' => sprintf('background-color:%s !important;', esc_attr($props['filter_search_dropdown_bg_color'])),
				)
			);
		}
		if ( '' !== $props['filter_search_icon_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-icon .ags-wc-filters-search-input-wrapper:after',
					'declaration' => sprintf('color:%s;', esc_attr($props['filter_search_icon_color'])),
				)
			);
		}
		if ( '' !== $props['filter_search_focus_icon_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-icon .ags-wc-filters-search-input-wrapper:focus-within:after',
					'declaration' => sprintf('color:%s;', esc_attr($props['filter_search_focus_icon_color'])),
				)
			);
		}
		if ( '' !== $props['filter_price_range_slider_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-number-range-container .rs-container .rs-selected',
					'declaration' => sprintf('background-color:%s;', esc_attr($props['filter_price_range_slider_color'])),
				)
			);
		}
		if ( '' !== $props['filter_price_range_slider_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-number-range-container .rs-container .rs-bg',
					'declaration' => sprintf('background-color:%s;', esc_attr($props['filter_price_range_slider_bg_color'])),
				)
			);
		}
		if ( '' !== $props['filter_price_range_slider_radius'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-number-range-container .rs-container .rs-selected, %%order_class%% .ags-wc-filters-number-range-container .rs-container .rs-bg',
					'declaration' => sprintf('border-radius:%s;', esc_attr($props['filter_price_range_slider_radius'])),
				)
			);
		}
		if ( '' !== $props['filter_price_range_slider_pointer_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-number-range-container .rs-container .rs-pointer',
					'declaration' => sprintf('background-color:%s;', esc_attr($props['filter_price_range_slider_pointer_color'])),
				)
			);
		}
		if ( '' !== $props['filter_price_range_slider_pointer_radius'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-number-range-container .rs-container .rs-pointer',
					'declaration' => sprintf('border-radius:%s;', esc_attr($props['filter_price_range_slider_pointer_radius'])),
				)
			);
		}
		if ( '' !== $props['filter_price_range_slider_tooltip_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-number-range-container .rs-container .rs-tooltip',
					'declaration' => sprintf('color:%s;', esc_attr($props['filter_price_range_slider_tooltip_color'])),
				)
			);
		}
		if ( '' !== $props['filter_price_range_slider_tooltip_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-number-range-container .rs-container .rs-tooltip',
					'declaration' => sprintf('background-color:%s;', esc_attr($props['filter_price_range_slider_tooltip_bg_color'])),
				)
			);
		}
		if ( '' !== $props['filter_price_range_slider_tooltip_radius'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-number-range-container .rs-container .rs-tooltip',
					'declaration' => sprintf('border-radius:%s;', esc_attr($props['filter_price_range_slider_tooltip_radius'])),
				)
			);
		}
		if ( '' !== $props['filter_rating_star_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-stars .ags-wc-filters-star-filled',
					'declaration' => sprintf('color:%s;', esc_attr($props['filter_rating_star_color'])),
				)
			);
		}
		if ( '' !== $props['filter_rating_star_placeholder_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-stars .ags-wc-filters-star-empty',
					'declaration' => sprintf('color:%s;', esc_attr($props['filter_rating_star_placeholder_color'])),
				)
			);
		}
		if ( '' !== $props['filter_rating_star_hover_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-stars .ags-wc-filters-star-hover',
					'declaration' => sprintf('color:%s;', esc_attr($props['filter_rating_star_hover_color'])),
				)
			);
		}
		if ( '' !== $props['filters_buttons_container_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-buttons',
					'declaration' => sprintf('background-color:%s;', esc_attr($props['filters_buttons_container_bg_color'])),
				)
			);
		}
		if ( '' !== $props['selected_filters_container_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-selected-main',
					'declaration' => sprintf('background-color:%s;', esc_attr($props['selected_filters_container_bg_color'])),
				)
			);
		}
		if ( '' !== $props['selected_filters_title_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-section-title',
					'declaration' => sprintf('background-color:%s;', esc_attr($props['selected_filters_title_bg_color'])),
				)
			);
		}
		if ( '' !== $props['selected_filters_inner_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-body',
					'declaration' => sprintf('background-color:%s;', esc_attr($props['selected_filters_inner_bg_color'])),
				)
			);
		}

		// Toggled Title Arrow Color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_title_toggle_arrow_color',
				'selector'       => '%%order_class%% .ags-wc-filters-section-title.ags-wc-filters-section-toggle::after',
				'hover_selector' => '%%order_class%% .ags-wc-filters-section-title.ags-wc-filters-section-toggle:hover::after',
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Radio buttons
		if ( 'on' === $this->props['filter_radio_style_enable'] ) {
			$css_prop = array(
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-radio-button-list li label',
					'declaration' => 'display : inline-flex; flex-wrap : wrap; align-items : center; padding-left : 24px !important; min-height : 18px; min-width : 18px;',
				),
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-radio-button-list li label:before, %%order_class%% .ags-wc-filters-radio-button-list li label:after',
					'declaration' => 'content : "";  position : absolute; top : 50%; left : 0;  -webkit-transform : translateY(-50%); transform : translateY(-50%); width : 18px; height : 18px; border-radius : 50%;',
				),
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-radio-button-list li input[type=radio]',
					'declaration' => 'padding : 0;  margin  : 0; height : 0; width : 0;display : none; position : absolute; -webkit-appearance : none;',
				),
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-radio-button-list li label:after',
					'declaration' => 'display : none;',
				),
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-radio-button-list li input[type=radio]:checked ~ label:after, %%order_class%% .ags-wc-filters-radio-button-list li label:before',
					'declaration' => 'display : block;',
				)
			);

			$css_props = array_merge($css_props, $css_prop);

			if ( '' !== $props['radio_background_color'] ) {
				self::set_style_esc(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .ags-wc-filters-radio-button-list li label:before',
						'declaration' => sprintf('background-color:%s;', esc_attr($props['radio_background_color'])),
					)
				);
			}
			if ( '' !== $props['radio_checked_background_color'] ) {
				self::set_style_esc(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .ags-wc-filters-radio-button-list li label:after',
						'declaration' => sprintf('box-shadow : inset 0 0 0 4px %s;', esc_attr($props['radio_checked_background_color'])),
					)
				);
			}
		}

		// Radio buttons list item background
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_radio_list_item_bg_color',
				'selector'       => '%%order_class%% .ags-wc-filters-radio-button-list li',
				'hover_selector' => '%%order_class%% .ags-wc-filters-radio-button-list li:hover',
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Radio buttons list item text color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_radio_list_item_color',
				'selector'       => '%%order_class%% .ags-wc-filters-radio-button-list li',
				'hover_selector' => '%%order_class%% .ags-wc-filters-radio-button-list li:hover',
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Checkboxes
		if ( 'on' === $this->props['filter_checkbox_style_enable'] ) {
			$css_prop = array(
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-checkbox-list li label',
					'declaration' => 'display : inline-flex; flex-wrap : wrap; align-items : center; padding-left : 24px !important; min-height : 18px; min-width : 18px;',
				),
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-checkbox-list li label:before, %%order_class%% .ags-wc-filters-checkbox-list li label:after',
					'declaration' => 'content : "";  position : absolute; top : 50%; left : 0; -webkit-transform : translateY(-50%); transform : translateY(-50%); width : 18px; height : 18px; display : block; -webkit-appearance : none;',
				),
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-checkbox-list li input[type=checkbox]',
					'declaration' => 'padding : 0; margin : 0; height : 0; width : 0;display : none; position : absolute; -webkit-appearance : none;',
				),
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-checkbox-list li input:checked + label:after',
					'declaration' => 'content : "\e803"; font-family : "Divi Shop Builder"; line-height : 18px; font-weight : normal; height : 18px; width : 18px; font-size : 19px; text-indent: -2px; text-align : center;',
				)
			);

			$css_props = array_merge($css_props, $css_prop);

			if ( '' !== $props['checkbox_background_color'] ) {
				self::set_style_esc(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .ags-wc-filters-checkbox-list li label:before',
						'declaration' => sprintf('background-color:%s;', esc_attr($props['checkbox_background_color'])),
					)
				);
			}

			if ( '' !== $props['checkbox_checked_color'] ) {
				self::set_style_esc(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .ags-wc-filters-checkbox-list li input:checked + label:after',
						'declaration' => sprintf('color :%s;', esc_attr($props['checkbox_checked_color'])),
					)
				);
			}

			if ( '' !== $props['checkbox_checked_background_color'] ) {
				self::set_style_esc(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .ags-wc-filters-checkbox-list li input:checked + label:before',
						'declaration' => sprintf('background-color:%s;', esc_attr($props['checkbox_checked_background_color'])),
					)
				);
			}
		}

		// Checkbox list item background
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_checkbox_list_item_bg_color',
				'selector'       => '%%order_class%% .ags-wc-filters-checkbox-list li',
				'hover_selector' => '%%order_class%% .ags-wc-filters-checkbox-list li:hover',
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Checkbox list item text color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_checkbox_list_item_color',
				'selector'       => '%%order_class%% .ags-wc-filters-checkbox-list li',
				'hover_selector' => '%%order_class%% .ags-wc-filters-checkbox-list li:hover',
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Select Dropdown Arrow
		if ( 'on' === $this->props['filter_select_dropdown_arrow_enable'] ) {
			$arrow_size      = esc_attr($props['filter_select_dropdown_arrow_size']);
			$arrow_alignment = $props['filter_select_dropdown_arrow_alignment'];

			if ( 'left' === $arrow_alignment ) {
				$css_prop_alignment = array(
					array(
						'selector'    => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-toggle:before, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-toggle:before',
						'declaration' => sprintf('left :%s;', esc_attr($props['filter_select_dropdown_arrow_offset'])),
					)
				);
			} elseif ( 'right' === $arrow_alignment ) {
				$css_prop_alignment = array(
					array(
						'selector'    => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-toggle:before, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-toggle:before',
						'declaration' => sprintf('right :%s;', esc_attr($props['filter_select_dropdown_arrow_offset'])),
					)
				);
			} else {
				$css_prop_alignment = array(
					array(
						'selector'    => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-toggle:before, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-toggle:before',
						'declaration' => 'right : 50%; transform : translate(50%, 0);',
					)
				);
			}

			$css_prop = array(
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-toggle,%%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-toggle',
					'declaration' => 'position : absolute; width : 100%; top: 0;',
				),
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-toggle:before, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-toggle:before',
					'declaration' => sprintf('content : ""; top : -%1$s; border-left : %1$s solid transparent; border-right : %1$s solid transparent; border-bottom-style : solid; border-bottom-width : %1$s; border-bottom-color : %2$s; display: block !important; position : absolute; width : 0; height : 0; z-index : 1;',
					                         $arrow_size,
					                         esc_attr($props['filter_select_dropdown_bg_color'])),
				),
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options',
					'declaration' => sprintf('margin-top:%s; overflow: visible;', $arrow_size),
				)
			);

			$css_props = array_merge($css_props, $css_prop, $css_prop_alignment);
		}

		// Select Dropdown Item background
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_select_dropdown_item_bg_color',
				'selector'       => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, 
									%%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a',
				'hover_selector' => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a:hover, 
									%%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a:hover',
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Dropdown Item Text Color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_select_dropdown_item_color',
				'selector'       => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, 
									%%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a',
				'hover_selector' => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a:hover, 
									%%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a:hover',
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Dropdown Item Selected Background Color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_select_dropdown_item_selected_bg_color',
				'selector'       => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a.ags-wc-filters-active, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li.ags-wc-filters-active a',
				'hover_selector' => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a.ags-wc-filters-active:hover, %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li.ags-wc-filters-active a:hover',
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Dropdown Item Selected Text Color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_select_dropdown_item_selected_color',
				'selector'       => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a.ags-wc-filters-active > span, 
									%%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li.ags-wc-filters-active a',
				'hover_selector' => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a.ags-wc-filters-active:hover > span,
									%%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li.ags-wc-filters-active a:hover',
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Dropdown Item Selected Check Color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_select_dropdown_item_selected_check_color',
				'selector'       => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a.ags-wc-filters-active > span:after,
				                    %%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options input:checked + label:after',
				'hover_selector' => '%%order_class%% .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a.ags-wc-filters-active:hover > span:after,
									%%order_class%% .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options a:hover input:checked + label:after',
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Search Dropdown Arrow
		if ( 'on' === $this->props['filter_search_dropdown_arrow_enable'] ) {
			$search_arrow_size      = esc_attr($props['filter_search_dropdown_arrow_size']);
			$search_arrow_alignment = $props['filter_search_dropdown_arrow_alignment'];

			if ( 'left' === $search_arrow_alignment ) {
				$css_prop_alignment = array(
					array(
						'selector'    => '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-dropdown-toggle:before',
						'declaration' => sprintf('left :%s;', esc_attr($props['filter_search_dropdown_arrow_offset'])),
					)
				);
			} elseif ( 'right' === $search_arrow_alignment ) {
				$css_prop_alignment = array(
					array(
						'selector'    => '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-dropdown-toggle:before',
						'declaration' => sprintf('right :%s;', esc_attr($props['filter_search_dropdown_arrow_offset'])),
					)
				);
			} else {
				$css_prop_alignment = array(
					array(
						'selector'    => '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-dropdown-toggle:before',
						'declaration' => 'right : 50%; transform : translate(50%, 0);',
					)
				);
			}

			$css_prop = array(
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-dropdown-toggle',
					'declaration' => 'position : absolute; width : 100%; top: 0;',
				),
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-dropdown-toggle:before',
					'declaration' => sprintf('content : ""; top : -%1$s; border-left : %1$s solid transparent; border-right : %1$s solid transparent; border-bottom-style : solid; border-bottom-width : %1$s; border-bottom-color : %2$s; display: block !important; position : absolute; width : 0; height : 0; z-index : 1;',
					                         $search_arrow_size,
					                         esc_attr($props['filter_search_dropdown_bg_color'])),
				),
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container',
					'declaration' => sprintf('margin-top:%s; overflow: visible;', $search_arrow_size),
				)
			);

			$css_props = array_merge($css_props, $css_prop, $css_prop_alignment);
		}

		// Search Dropdown Item background
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_search_dropdown_item_bg_color',
				'selector'       => '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a',
				'hover_selector' => '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a:hover',
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Search Dropdown Item Text Color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_search_dropdown_item_color',
				'selector'       => '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a',
				'hover_selector' => '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a:hover',
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Search Icon Position
		if ( 'left' === $this->props['filter_search_icon_position'] ) {
			$css_prop = array(
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-search-container.ags-wc-filters-search-with-icon .ags-wc-filters-search-input-wrapper',
					'declaration' => 'flex-direction: row-reverse;',
				)
			);

			$css_props = array_merge($css_props, $css_prop);
		}

		// Tagcloud Tag background
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_tagcloud_tag_bg_color',
				'selector'       => '%%order_class%% .ags-wc-filters-tagcloud li label',
				'hover_selector' => '%%order_class%% .ags-wc-filters-tagcloud li label:hover',
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Tagcloud Tag color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_tagcloud_tag_text_color',
				'selector'       => '%%order_class%% .ags-wc-filters-tagcloud li label',
				'hover_selector' => '%%order_class%% .ags-wc-filters-tagcloud li label:hover',
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Tagcloud Tag Active background
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_tagcloud_tag_active_bg_color',
				'selector'       => '%%order_class%% .ags-wc-filters-tagcloud li input[type=radio]:checked + label',
				'hover_selector' => '%%order_class%% .ags-wc-filters-tagcloud li input[type=radio]:checked + label:hover',
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Tagcloud Tag Active color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_tagcloud_tag_active_text_color',
				'selector'       => '%%order_class%% .ags-wc-filters-tagcloud li input[type=radio]:checked + label',
				'hover_selector' => '%%order_class%% .ags-wc-filters-tagcloud li input[type=radio]:checked + label:hover',
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Tagcloud Tag Active border color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_tagcloud_tag_active_border_color',
				'selector'       => '%%order_class%% .ags-wc-filters-tagcloud li input[type=radio]:checked + label',
				'hover_selector' => '%%order_class%% .ags-wc-filters-tagcloud li input[type=radio]:checked + label:hover',
				'css_property'   => 'border-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Products number background
		$this->generate_styles(
			array(
				'base_attr_name' => 'products_number_bg_color',
				'selector'       => '%%order_class%% .ags-wc-filters-product-count',
				'hover_selector' => '%%order_class%% .ags-wc-filters-product-count:hover',
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Selected Filter Background
		$this->generate_styles(
			array(
				'base_attr_name' => 'selected_filter_bg_color',
				'selector'       => '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-inner',
				'hover_selector' => '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-inner:hover',
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Selected Filter Clear Icon Posiition & Spacing
		if ( 'before' === $this->props['selected_filter_clear_icon_position'] ) {
			if ( '' !== $props['selected_filter_clear_icon_spacing'] ) {
				self::set_style_esc(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-inner .ags-wc-filters-remove',
						'declaration' => sprintf('margin-right: %s;', esc_attr($props['selected_filter_clear_icon_spacing'])),
					)
				);
			}
		}

		if ( 'after' === $this->props['selected_filter_clear_icon_position'] ) {
			$css_prop = array(
				array(
					'selector'    => '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-inner',
					'declaration' => 'flex-direction: row-reverse;',
				)
			);

			$css_props = array_merge($css_props, $css_prop);

			if ( '' !== $props['selected_filter_clear_icon_spacing'] ) {
				self::set_style_esc(
					$render_slug,
					array(
						'selector'    => '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-inner .ags-wc-filters-remove',
						'declaration' => sprintf('margin-left: %s;', esc_attr($props['selected_filter_clear_icon_spacing'])),
					)
				);
			}
		}

		// Selected Filter Clear Icon Color
		$this->generate_styles(
			array(
				'base_attr_name' => 'selected_filter_clear_icon_color',
				'selector'       => '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-inner .ags-wc-filters-remove:before',
				'hover_selector' => '%%order_class%% .ags-wc-filters-selected-main .ags-wc-filters-selected-inner .ags-wc-filters-remove:hover:before',
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Clear Button Icon
		$clear_filters_button_use_icon = ! empty($this->props['clear_filters_button_use_icon']) ? $this->props['clear_filters_button_use_icon'] : 'off';

		if ( $clear_filters_button_use_icon === 'on' && ! empty($this->props['clear_filters_button_icon']) ) {
			$icon     = dswcp_decoded_et_icon(et_pb_process_font_icon($this->props['clear_filters_button_icon']));
			$position = $this->props['clear_filters_button_icon_placement'] === 'left' ? 'before' : 'after';
			self::set_style_esc($this->slug, array(
				'selector'    => "%%order_class%% .ags-wc-filters-button-clear::{$position}",
				'declaration' => "content: '{$icon}' !important; font-family: 'ETmodules' !important;"
			));
		}

		// Apply Button Icon
		$apply_filters_button_use_icon = ! empty($this->props['apply_filters_button_use_icon']) ? $this->props['apply_filters_button_use_icon'] : 'off';

		if ( $apply_filters_button_use_icon === 'on' && ! empty($this->props['apply_filters_button_icon']) ) {
			$icon     = dswcp_decoded_et_icon(et_pb_process_font_icon($this->props['apply_filters_button_icon']));
			$position = $this->props['apply_filters_button_icon_placement'] === 'left' ? 'before' : 'after';
			self::set_style_esc($this->slug, array(
				'selector'    => "%%order_class%% .ags-wc-filters-button-apply::{$position}",
				'declaration' => "content: '{$icon}' !important; font-family: 'ETmodules' !important;"
			));
		}

		// horizontal_draggable

		if ($this->props['layout'] === 'horizontal' && $this->props['horizontal_draggable'] === 'on' ) {
			self::set_style_esc($this->slug, array(
				'selector'    => "%%order_class%% .ags-wc-filters-row .ags-wc-filters-sections",
				'declaration' => "flex-wrap: nowrap; overflow: visible;"
			));
			self::set_style_esc($this->slug, array(
				'selector'    => ".et_pb_column:has(%%order_class%% .ags-wc-filters-row)",
				'declaration' => "overflow-x: hidden;"
			));
			self::set_style_esc($this->slug, array(
				'selector'    => "%%order_class%% .ags-wc-filters-section-title h4",
				'declaration' => "white-space: nowrap;"
			));
		}

		foreach ( $css_props as $css_prop ) {
			self::set_style_esc($render_slug, $css_prop);
		}
	}
	
	function before_render() {
		global $dswcp_filters_layout, $dswcp_filters_active_count;
		$dswcp_filters_layout = $this->props['layout'];
		$dswcp_filters_active_count = ($this->props['active_count'] == 'on');
	}

	/**
	 * Render module output
	 *
	 * @param array $attrs List of unprocessed attributes
	 * @param string $content Content being processed
	 * @param string $render_slug Slug of module that is used for rendering output
	 *
	 * @return string module's rendered output
	 * @since 1.0.0
	 *
	 */
	function render($attrs, $content = null, $render_slug = null) {
		$this->css($render_slug);
		
		$classNames = [];

		$horizontal = $this->props['layout'] === 'horizontal';
		
		if ( $horizontal ) {
			$classNames[] = 'ags-wc-filters-row';
		} else {
			$classNames[] = 'ags-wc-filters-sidebar';
		}

		ob_start();

		echo(
			'<div class="'.esc_attr(implode(' ', $classNames)).'" data-no-options-text="'.esc_attr($this->props['no_options_text']).'"'
				.($this->props['selected_filters'] == 'hide' ? '' : ' data-range-text-min-max="'.esc_attr($this->props['range_text_min_max']).'" data-range-text-min="'.esc_attr($this->props['range_text_min']).'" data-range-text-max="'.esc_attr($this->props['range_text_max']).'"').'>'

			. (($this->props['clear_all_filters_button'] == 'top' || $this->props['apply_filters_button'] == 'top') ?
				'<div class="ags-wc-filters-buttons">'
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- false positive, user input is escaped
				. ($this->props['clear_all_filters_button'] == 'top' ? '<button class="ags-wc-filters-button ags-wc-filters-button-clear et_pb_button">' . esc_html($this->props['clear_all_filters_button_text']) . '</button>' : '')
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- false positive, user input is escaped
				. ($this->props['apply_filters_button'] == 'top' ? '<button class="ags-wc-filters-button ags-wc-filters-button-apply et_pb_button">' . esc_html($this->props['apply_filters_button_text']) . '</button>' : '')
				. '</div>' : ''
			)
		);

		if ( $this->props['selected_filters'] == 'top' ) {
			$this->render_selected_filters();
		}

		echo('<div class="ags-wc-filters-sections">' . et_core_intentionally_unescaped($this->props['content'], 'html') . '</div>');


		if ( $horizontal && ($this->props['clear_all_filters_button'] != 'bottom' && $this->props['apply_filters_button'] != 'bottom')) {
			echo ('<div class="ags-wc-filters-break"></div>');
		}

		if ( $this->props['selected_filters'] == 'bottom' && ! $horizontal ) {
			$this->render_selected_filters();
		}

		echo(
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- false positive
			( ($this->props['clear_all_filters_button'] == 'bottom' || $this->props['apply_filters_button'] == 'bottom') ?
				'<div class="ags-wc-filters-buttons">'
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- false positive, user input is escaped
				. ($this->props['clear_all_filters_button'] == 'bottom' ? '<button class="ags-wc-filters-button ags-wc-filters-button-clear et_pb_button">' . esc_html($this->props['clear_all_filters_button_text']) . '</button>' : '')
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- false positive, user input is escaped
				. ($this->props['apply_filters_button'] == 'bottom' ? '<button class="ags-wc-filters-button ags-wc-filters-button-apply et_pb_button">' . esc_html($this->props['apply_filters_button_text']) . '</button>' : '')
				. '</div>' : ''
			)
		);

		if ( $horizontal && ($this->props['clear_all_filters_button'] == 'bottom' || $this->props['apply_filters_button'] == 'bottom')) {
			echo ('<div class="ags-wc-filters-break"></div>');
		}

		if ( $this->props['selected_filters'] == 'bottom' && $horizontal ) {
			$this->render_selected_filters();
		}
		
		echo('</div>');

		return ob_get_clean();
	}

	function render_selected_filters() {
		echo '<div class="ags-wc-filters-selected-main ags-wc-filters-selected-display-' . esc_attr($this->props['selected_filters']) . '">
				  <div class="ags-wc-filters-selected-outer">'
		     // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- false positive, user input is escaped
		     . ($this->props['display_selected_filters_title'] == 'on' ? '<span class="ags-wc-filters-section-title"><h4>' . esc_html($this->props['selected_filters_title_text']) . '</h4></span>' : '')
		     . '<div class="ags-wc-filters-selected-body">
				<div class="ags-wc-filters-selected"></div>'
		     // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- false positive, user input is escaped
		     . ($this->props['clear_all_filters_button'] == 'selected_filters' ? '<button class="ags-wc-filters-button ags-wc-filters-button-clear et_pb_button">' . esc_html($this->props['clear_all_filters_button_text']) . '</button>' : '')
		     . '</div>
				</div>
			</div>';
	}

}

new DSWCP_WooProductsFilters;
