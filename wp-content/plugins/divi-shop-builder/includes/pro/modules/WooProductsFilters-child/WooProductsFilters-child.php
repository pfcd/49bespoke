<?php

/**
 * Child module / module item (module which appears inside parent module) with FULL builder support
 * This module appears on Visual Builder and requires react component to be provided
 * Due to full builder support, all advanced options (except button options) are added by default
 *
 * @since 1.0.0
 */
require_once __DIR__.'/../../modules5/WooProductsFilters-child/traits/FilterHtmlTrait.php';

class DSWCP_WooProductsFilters_child extends ET_Builder_Module {
	static $TYPES;
	use DSWCP_Module;
	use WPZone\DiviShopBuilder\Modules\WooProductsFiltersChildModule\Traits\FilterHtmlTrait;

	public $slug       = 'ags_woo_products_filters_child';
	public $vb_support = 'on';
	protected $accent_color;

	const STAR_EMPTY = '&#xe031;', STAR = '&#xe033;';

	//public $type                     = 'child';
	//public $child_title_var          = 'title';
	//public $child_title_fallback_var = 'subtitle';

	private function getIconSvg($svg) {
		global $wp_filesystem;
		if (empty($wp_filesystem)) {
			WP_Filesystem();
		}
		return $wp_filesystem->get_contents( AGS_divi_wc::$plugin_directory . 'includes/media/icons/' . $svg . '.svg' );
	}

	function init() {
		$this->name             = esc_html__('Filter Settings', 'divi-shop-builder');
		$this->type             = 'child';
		$this->child_title_var  = 'choose_filter_title';
		$this->accent_color     = '#2ea3f2';
		$this->main_css_element = '.et_pb_module.ags_woo_products_filters %%order_class%%.et_pb_module';

		//$this->advanced_setting_title_text = esc_html__( 'filter_title_text', 'et_builder' );
		//$this->settings_text = esc_html__( 'CTA Item Settings', 'et_builder' );

		// Toggle settings
		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'advanced_filter_settings' => esc_html__('Advanced Filter Settings', 'divi-shop-builder'),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'filter_container'       => array(
						'title'             => esc_html__('Single Filter', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'          => array(
								'name'     => 'p',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/typography_text.svg'),
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/padding_margins.svg'),
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/border.svg'),
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/background_colors.svg'),
							),
						),
					),
					'filter_title'           => array(
						'title'             => esc_html__('Filter Title', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'h2'           => array(
								'name'     => 'h2',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/typography_heading.svg'),
							),
							'spacing'      => array(
								'name'     => 'spacing',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/padding_margins.svg'),
							),
							'border'       => array(
								'name'     => 'border',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/border.svg'),
							),
							'background'   => array(
								'name'     => 'background',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/background_colors.svg'),
							),
							'toggle_arrow' => array(
								'name'     => esc_html__('Filter Toggle Arrow', 'divi-shop-builder'),
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/arrow_down.svg'),
							),
						),
					),
					'filter_inner'           => array(
						'title'             => esc_html__('Filter Inner', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/padding_margins.svg'),
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/border.svg'),
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/background_colors.svg'),
							),
						),
					),
					'filter_radio_list'      => array(
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
					'filter_checkbox_list'   => array(
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
					'form_field_select'      => esc_html__('Select Field', 'divi-shop-builder'),
					'filter_select_dropdown' => array(
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
					'form_field_search'      => array(
						'title' => esc_html__('Search Field', 'divi-shop-builder'),
					),
					'filter_search'          => array(
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
					'form_field_number'      => esc_html__('Price Filter Number Field', 'divi-shop-builder'),
					'filter_price'           => esc_html__('Price Filter Range Slider', 'divi-shop-builder'),
					'filter_tagcloud'        => array(
						'title'             => esc_html__('Tag Cloud', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'          => array(
								'name'     => 'p',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/typography_text.svg'),
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/padding_margins.svg'),
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/border.svg'),
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/background_colors.svg'),
							),
						),
					),
					'filter_rating'          => esc_html__('Rating', 'divi-shop-builder'),
					'products_number'        => array(
						'title'             => esc_html__('Number of Products', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'          => array(
								'name'     => 'p',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/typography_text.svg'),
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/padding_margins.svg'),
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/border.svg'),
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/background_colors.svg'),
							),
						),
					),
					'color_image_select'        => array(
						'title'             => esc_html__('Color/Image Select', 'divi-shop-builder'),
					),
					'color_swatches_products_number'        => array(
						'title'             => esc_html__('Color Swatches - Number Of Products', 'divi-shop-builder'),
					),
					'tooltip'        => array(
						'title'             => esc_html__('Tooltip', 'divi-shop-builder'),
					),

					//'visibility'      => esc_html__('Visibility', 'divi-shop-builder'),
				),
			),
		);

		/**
		 * Advanced tab custom css fields
		 */
		$this->custom_css_fields = array(
			'filter_title'       => array(
				'label'    => esc_html__('Filter Title', 'divi-shop-builder'),
				'selector' => "{$this->main_css_element} ags-wc-filters-section-title",
			),
			'filter_title_arrow' => array(
				'label'    => esc_html__('Filter Toggle Arrow', 'divi-shop-builder'),
				'selector' => "{$this->main_css_element} .ags-wc-filters-section-toggle:after",
			),
			'filter_inner'       => array(
				'label'    => esc_html__('Filter Inner', 'divi-shop-builder'),
				'selector' => "{$this->main_css_element} .ags-wc-filters-section-inner",
			),
		);

		self::$TYPES = array(
			'category'     => esc_html__('Category', 'divi-shop-builder'),
			'tag'          => esc_html__('Tag', 'divi-shop-builder'),
			'attribute'    => esc_html__('Attribute', 'divi-shop-builder'),
			'taxonomy'    => esc_html__('Custom Taxonomy', 'divi-shop-builder'),
			'search'       => esc_html__('Search', 'divi-shop-builder'),
			'rating'       => esc_html__('Rating', 'divi-shop-builder'),
			'price'        => esc_html__('Price', 'divi-shop-builder'),
			'stock_status' => esc_html__('Stock Status', 'divi-shop-builder'),
			'sale'         => esc_html__('Sale', 'divi-shop-builder'),
			'sorting'      => esc_html__('Sorting', 'divi-shop-builder')
		);
	}

	/**
	 * Module's specific fields
	 *
	 * @return array
	 * @since 1.0.0
	 *
	 */
	function get_fields() {

		// Based on woocommerce\includes\admin\meta-boxes\views\html-product-data-attributes.php
		$productAttributes = [];

		// Array of defined attribute taxonomies.
		$attribute_taxonomies = wc_get_attribute_taxonomies();
		
		if ( ! empty($attribute_taxonomies) ) {
			foreach ( $attribute_taxonomies as $tax ) {
				$attribute_taxonomy_name                       = wc_attribute_taxonomy_name($tax->attribute_name);
				$label                                         = $tax->attribute_label ? $tax->attribute_label : $tax->attribute_name;
				$productAttributes[ $attribute_taxonomy_name ] = $label;
			}
		}

		$custom_taxonomies = array_diff(dswcp_get_product_taxonomies(), array_keys($productAttributes), ['product_cat', 'product_tag']);
		
		$fields = array(
			'parent_layout'              => array(
				'type'             => 'WPZParentSettingReflector-DSB',
				'option_category'  => 'basic_option',
				'source'           => 'layout',
				'default'          => 'vertical'
			),
			'choose_filter'              => array(
				'label'            => esc_html__('Choose Filter', 'divi-shop-builder'),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => array_merge(array('none' => '-'), self::$TYPES),
				'description'      => esc_html__('Choose the filter type you would like to add.', 'divi-shop-builder'),
				'default'          => 'none',
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'attribute'                  => array(
				'label'            => esc_html__('Choose Attribute', 'divi-shop-builder'),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => array_merge(array('none' => '-'), $productAttributes),
				'description'      => esc_html__('Choose Attribute type for this filter.', 'divi-shop-builder'),
				'default'          => 'none',
				'show_if'          => array(
					'choose_filter' => 'attribute',
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'taxonomy'                  => array(
				'label'            => esc_html__('Choose Taxonomy', 'divi-shop-builder'),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => array_merge(array('none' => '-'), array_map('esc_html', array_combine($custom_taxonomies, $custom_taxonomies))),
				'description'      => esc_html__('Choose a taxonomy for this filter.', 'divi-shop-builder'),
				'default'          => 'none',
				'show_if'          => array(
					'choose_filter' => 'taxonomy',
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'choose_filter_title'        => array(
				'label'       => '',
				'type'        => 'ags_divi_wc_value_mapper-DSB',
				'sourceField' => 'choose_filter',
				'valueMap'    => self::$TYPES,
			),
			'condition'       => array(
				'label'            => esc_html__('Show Filter', 'divi-shop-builder'),
				'description'      => esc_html__('Choose when to show this filter.', 'divi-shop-builder'),
				'type'             => 'select',
				'options'          => array(
					'always'  => esc_html__('Always', 'divi-shop-builder'),
					'notempty'  => esc_html__('When at least one value applies to the displayed products', 'divi-shop-builder'),
					'category'  => esc_html__('When one or more of these categories are selected for filtering:', 'divi-shop-builder'),
				),
				'show_if_not' => ['choose_filter' => 'sorting'],
				'option_category'  => 'basic_option',
				'default'          => 'always'
			),
			'condition_categories'  => array(
				'label'            => esc_html__( 'Show Filter for Categories', 'divi-shop-builder' ),
				'type'             => 'categories',
				'renderer_options' => array(
					'use_terms' => true,
					'term_name' => 'product_cat',
				),
				'description'      => esc_html__( 'Show this filter when one or more of these categories are selected for filtering.', 'divi-shop-builder' ),
				'taxonomy_name'    => 'product_cat',
				'show_if'          => [
					'condition' => 'category'
				]
			),
			'display_filter_title'       => array(
				'label'            => esc_html__('Display Filter Title', 'divi-shop-builder'),
				'description'      => esc_html__('Choose to show or hide the Display Filters Title.', 'divi-shop-builder'),
				'type'             => 'yes_no_button',
				'options'          => array(
					'on'  => esc_html__('Yes', 'divi-shop-builder'),
					'off' => esc_html__('No', 'divi-shop-builder'),
				),
				'option_category'  => 'basic_option',
				'default'          => 'on',
				'show_if'          => [
					'parent_layout' => 'vertical'
				],
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'filter_title_text'          => array(
				'label'            => esc_html__('Filter Title Text', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Text entered here will appear as Filter Title Text.', 'divi-shop-builder'),
				'default'          => __('Filter Name', 'divi-shop-builder'),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'filter_clear'       => array(
				'label'           => esc_html__('Show Clear Link in Each Filter', 'divi-shop-builder'),
				'type'            => 'yes_no_button',
				'options'         => array(
					'on'  => esc_html__('Yes', 'divi-shop-builder'),
					'off' => esc_html__('No', 'divi-shop-builder'),
				),
				'option_category' => 'basic_option',
				'description'     => esc_html__('Show a Clear link in each filter.', 'divi-shop-builder'),
				'default'         => 'off',
				'show_if'         => [
					'display_filter_title' => 'on'
				],
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'filter_clear_text'  => array(
				'label'           => esc_html__('Filter Clear Link Text', 'divi-shop-builder'),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__('Text entered here will appear as the per-filter clear link.', 'divi-shop-builder'),
				'default'         => esc_html__('Clear', 'divi-shop-builder'),
				'show_if'         => [
					'display_filter_title' => 'on',
					'filter_clear' => 'on'
				],
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'show_children'              => array(
				'label'            => esc_html__('Show:', 'divi-shop-builder'),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => array(
					'hide'            => esc_html__('Parent Categories Only', 'divi-shop-builder'),
					'nonhierarchical' => esc_html__('Parent Categories And Subcategories Nonhierarchical', 'divi-shop-builder'),
					'hierarchical'    => esc_html__('Parent Categories And Subcategories Hierarchical', 'divi-shop-builder'),
				),
				'description'      => esc_html__('Choose category/subcategory type to display.', 'divi-shop-builder'),
				'default'          => 'hide',
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter' => 'category',
				),
				'show_if_not'      => [
					'display_as' => 'images'
				],
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'expand_hierarchy'        => array(
				'label'           => esc_html__('Show Subcategories After Clicking On Parent Category', 'divi-shop-builder'),
				'type'            => 'yes_no_button',
				'options'         => array(
					'on'  => esc_html__('Yes', 'divi-shop-builder'),
					'off' => esc_html__('No', 'divi-shop-builder'),
				),
				'option_category' => 'basic_option',
				'description'     => esc_html__('If enabled, only parent categories are shown by default, and subcategories are listed after clicking on a parent category.', 'divi-shop-builder'),
				'default'         => 'off',
				'show_if'      => array(
					'choose_filter' => 'category',
					'show_children' => 'hierarchical'
				),
				'show_if_not' => [
					'display_as' => [
						'dropdown_single_select',
						'dropdown_multi_select',
						'tagcloud',
						'images'
					]
				],
				'computed_affects' => array(
					'__woofilters',
				),
				'toggle_slug'      => 'advanced_filter_settings',
			),
			'display_as'                 => array(
				'label'            => esc_html__('Display As:', 'divi-shop-builder'),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => array(
					'checkboxes_list'        => esc_html__('Checkboxes List', 'divi-shop-builder'),
					'radio_buttons_list'     => esc_html__('Radio Buttons List', 'divi-shop-builder'),
					'dropdown_single_select' => esc_html__('Dropdown Single Select', 'divi-shop-builder'),
					'dropdown_multi_select'  => esc_html__('Dropdown Multi Select', 'divi-shop-builder'),
					'tagcloud'               => esc_html__('Tag Cloud', 'divi-shop-builder'),
					'images'                 => esc_html__('Images (category filter only)', 'divi-shop-builder'),
				),
				'description'      => esc_html__('Choose the selector style.', 'divi-shop-builder'),
				'default'          => 'sidebar',
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if_not'      => array(
					'choose_filter' => ['search', 'rating', 'price', 'sale', 'attribute', 'sorting']
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'display_as_attribute'                 => array(
				'label'            => esc_html__('Display As:', 'divi-shop-builder'),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => array(
					'checkboxes_list'        => esc_html__('Checkboxes List', 'divi-shop-builder'),
					'radio_buttons_list'     => esc_html__('Radio Buttons List', 'divi-shop-builder'),
					'dropdown_single_select' => esc_html__('Dropdown Single Select', 'divi-shop-builder'),
					'dropdown_multi_select'  => esc_html__('Dropdown Multi Select', 'divi-shop-builder'),
					'tagcloud'               => esc_html__('Tag Cloud', 'divi-shop-builder'),
					'numeric_slider'         => esc_html__('Numeric Range - Slider', 'divi-shop-builder'),
					'numeric_inputs'         => esc_html__('Numeric Range - Inputs', 'divi-shop-builder'),
					'numeric_slider_inputs'  => esc_html__('Numeric Range - Slider and Inputs', 'divi-shop-builder'),
					'colors'                 => esc_html__('Colors - Swatches', 'divi-shop-builder'),
					'images'                 => esc_html__('Images', 'divi-shop-builder'),
				),
				'description'      => esc_html__('Choose the selector style.', 'divi-shop-builder'),
				'default'          => 'sidebar',
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'      => array(
					'choose_filter' => 'attribute'
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'hide_labels'        => array(
				'label'           => esc_html__('Hide Option Labels', 'divi-shop-builder'),
				'type'            => 'yes_no_button',
				'options'         => array(
					'on'  => esc_html__('Yes', 'divi-shop-builder'),
					'off' => esc_html__('No', 'divi-shop-builder'),
				),
				'option_category' => 'basic_option',
				'description'     => esc_html__('Hide a text label for each option in the attribute filter.', 'divi-shop-builder'),
				'default'         => 'on',
				'show_if'      => array(
					'choose_filter' => array('attribute','category'),
					//  Here we should have OR, but it's not supported
					// 'display_as_attribute' => ['colors', 'images'],
					// 'display_as' => 'images'
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'range_min_attribute'                  => array(
				'label'            => esc_html__('Default Minimum Value:', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Choose the default minimum attribute value.', 'divi-shop-builder'),
				'default'          => '0',
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter' => 'attribute',
					'display_as_attribute' => ['numeric_slider', 'numeric_inputs', 'numeric_slider_inputs']
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'range_max_attribute'                  => array(
				'label'            => esc_html__('Default Maximum Value:', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Choose the default maximum attribute value.', 'divi-shop-builder'),
				'default'          => '1000',
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter' => 'attribute',
					'display_as_attribute' => ['numeric_slider', 'numeric_inputs', 'numeric_slider_inputs']
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'display_as_rating'          => array(
				'label'            => esc_html__('Display As:', 'divi-shop-builder'),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => array(
					'stars'            => esc_html__('Single Line Stars (selected rating and up)', 'divi-shop-builder'),
					'stars_only'       => esc_html__('Single Line Stars (only selected rating)', 'divi-shop-builder'),
					'radio_stars'      => esc_html__('Radio Buttons Stars', 'divi-shop-builder'),
					'radio_text'       => esc_html__('Radio Buttons Text', 'divi-shop-builder'),
					'checkboxes_stars' => esc_html__('Checkboxes Stars', 'divi-shop-builder'),
					'checkboxes_text'  => esc_html__('Checkboxes Text', 'divi-shop-builder'),
					'dropdown_stars'   => esc_html__('Dropdown Stars', 'divi-shop-builder'),
					'dropdown_text'    => esc_html__('Dropdown Text', 'divi-shop-builder'),
				),
				'description'      => esc_html__('Choose the Rating select style.', 'divi-shop-builder'),
				'default'          => 'stars',
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter' => 'rating',
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'show_range'                 => array(
				'label'            => esc_html__('Show:', 'divi-shop-builder'),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => array(
					'slider'        => esc_html__('From - To Slider', 'divi-shop-builder'),
					'inputs'        => esc_html__('From - To Number Inputs', 'divi-shop-builder'),
					'slider_inputs' => esc_html__('From - To Slider And Number Inputs', 'divi-shop-builder'),
				),
				'description'      => esc_html__('Choose the Price Range selector style.', 'divi-shop-builder'),
				'default'          => 'slider',
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter' => 'price',
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'range_min'                  => array(
				'label'            => esc_html__('Default Minimum Amount:', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Choose the Default Minumum Price Amount.', 'divi-shop-builder'),
				'default'          => '0',
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter' => 'price',
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'range_min_mode'                 => array(
				'label'            => esc_html__('Use the default minimum amount:', 'divi-shop-builder'),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => array(
					'fallback'        => esc_html__('As a fallback only', 'divi-shop-builder'),
					'always'        => esc_html__('As a fixed minimum amount', 'divi-shop-builder'),
					'max' => esc_html__('Unless the lowest price among currently filtered products is less', 'divi-shop-builder'),
					'min' => esc_html__('Unless the lowest price among currently filtered products is greater', 'divi-shop-builder'),
				),
				'description'      => esc_html__('Choose how to apply the default minimum amount.', 'divi-shop-builder'),
				'default'          => 'fallback',
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter' => 'price',
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'range_max'                  => array(
				'label'            => esc_html__('Default Maximum Amount:', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Choose the Default Maximum Price Amount.', 'divi-shop-builder'),
				'default'          => '1000',
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter' => 'price',
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'range_max_mode'                 => array(
				'label'            => esc_html__('Use the default maximum amount:', 'divi-shop-builder'),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => array(
					'fallback'        => esc_html__('As a fallback only', 'divi-shop-builder'),
					'always'        => esc_html__('As a fixed maximum amount', 'divi-shop-builder'),
					'max' => esc_html__('Unless the highest price among currently filtered products is less', 'divi-shop-builder'),
					'min' => esc_html__('Unless the highest price among currently filtered products is greater', 'divi-shop-builder'),
				),
				'description'      => esc_html__('Choose how to apply the default maximum amount.', 'divi-shop-builder'),
				'default'          => 'fallback',
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter' => 'price',
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'display_as_toggle'          => array(
				'label'            => esc_html__('Display As Toggle', 'divi-shop-builder'),
				'description'      => esc_html__('Make the filter title a toggle that can be used to show or hide the corresponding filtering settings. This setting will work only for vertical layout.', 'divi-shop-builder'),
				'type'             => 'yes_no_button',
				'options'          => array(
					'on'  => esc_html__('On', 'divi-shop-builder'),
					'off' => esc_html__('Off', 'divi-shop-builder'),
				),
				'option_category'  => 'basic_option',
				'default'          => 'on',
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'display_filter_title' => 'on',
//					'parent_layout' => 'vertical'
				)
			),
			'toggle_default'          => array(
				'label'            => esc_html__('Default Toggle State', 'divi-shop-builder'),
				'description'      => esc_html__('Set whether the toggle should be open or closed by default', 'divi-shop-builder'),
				'type'             => 'select',
				'options'          => array(
					'1'  => __('Open', 'divi-shop-builder'),
					'0' => __('Closed', 'divi-shop-builder'),
				),
				'option_category'  => 'basic_option',
				'default'          => '1',
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'display_filter_title' => 'on',
					'display_as_toggle' => 'on',
					'parent_layout' => 'vertical'
				)
			),
			'show_number_of_products'    => array(
				'label'            => esc_html__('Show Number Of Products', 'divi-shop-builder'),
				'description'      => esc_html__('Choose to show or hide the Number of Products.', 'divi-shop-builder'),
				'type'             => 'yes_no_button',
				'options'          => array(
					'on'  => esc_html__('On', 'divi-shop-builder'),
					'off' => esc_html__('Off', 'divi-shop-builder'),
				),
				'option_category'  => 'basic_option',
				'default'          => 'off',
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if_not'      => array(
					'choose_filter' => ['search', 'rating', 'price', 'sale', 'sorting'],
					'display_as_attribute' => ['numeric_slider', 'numeric_inputs', 'numeric_slider_inputs']
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'dynamic_product_counts'     => array(
				'label'            => esc_html__('Dynamic Product Counts', 'divi-shop-builder'),
				'description'      => esc_html__('Choose to display Dynamic Product Counts.', 'divi-shop-builder'),
				'type'             => 'yes_no_button',
				'options'          => array(
					'on'  => esc_html__('On', 'divi-shop-builder'),
					'off' => esc_html__('Off', 'divi-shop-builder'),
				),
				'option_category'  => 'basic_option',
				'default'          => 'on',
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'show_number_of_products' => 'on',
				),
				'show_if_not'      => array(
					'choose_filter' => ['search', 'rating', 'price', 'sale']
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'hide_zero_count'     => array(
				'label'            => esc_html__('Hide Options with Zero Product Count', 'divi-shop-builder'),
				'description'      => esc_html__('Filtering options with a current product count of zero will be hidden if this setting is enabled.', 'divi-shop-builder'),
				'type'             => 'yes_no_button',
				'options'          => array(
					'on'  => esc_html__('On', 'divi-shop-builder'),
					'off' => esc_html__('Off', 'divi-shop-builder'),
				),
				'option_category'  => 'basic_option',
				'default'          => 'on',
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if_not'      => array(
					'choose_filter' => ['search', 'rating', 'price', 'sale', 'sorting']
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'search_suggestions'         => array(
				'label'            => esc_html__('Show Suggestions When Typing', 'divi-shop-builder'),
				'description'      => esc_html__('Choose to enable or disable Suggestions While Typing', 'divi-shop-builder'),
				'type'             => 'yes_no_button',
				'options'          => array(
					'on'  => esc_html__('On', 'divi-shop-builder'),
					'off' => esc_html__('Off', 'divi-shop-builder'),
				),
				'option_category'  => 'basic_option',
				'default'          => 'on',
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter' => 'search',
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'search_icon'                => array(
				'label'            => esc_html__('Show Search Icon', 'divi-shop-builder'),
				'description'      => esc_html__('Choose to show or hide the Search Icon.', 'divi-shop-builder'),
				'type'             => 'yes_no_button',
				'options'          => array(
					'on'  => esc_html__('On', 'divi-shop-builder'),
					'off' => esc_html__('Off', 'divi-shop-builder'),
				),
				'option_category'  => 'basic_option',
				'default'          => 'on',
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter' => 'search',
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'search_placeholder'         => array(
				'label'            => esc_html__('Display Placeholder', 'divi-shop-builder'),
				'description'      => esc_html__('Choose to display the Search Placeholder text.', 'divi-shop-builder'),
				'type'             => 'yes_no_button',
				'options'          => array(
					'on'  => esc_html__('On', 'divi-shop-builder'),
					'off' => esc_html__('Off', 'divi-shop-builder'),
				),
				'option_category'  => 'basic_option',
				'default'          => 'on',
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter' => 'search',
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'search_placeholder_text'    => array(
				'label'            => esc_html__('Placeholder Text', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Text entered here will display as Search Placeholder.', 'divi-shop-builder'),
				'default'          => __('Search...', 'divi-shop-builder'),
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter'      => 'search',
					'search_placeholder' => 'on',
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'all_categories_option_text' => array(
				'label'            => esc_html__('"All" Option Text', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Text entered here will appear as All.', 'divi-shop-builder'),
				'toggle_slug'      => 'advanced_filter_settings',
				'default'          => __('All', 'divi-shop-builder'),
				'show_if'          => array(
					'display_as' => array('radio_buttons_list', 'dropdown_single_select'),
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'show_option_all'         => array(
				'label'            => esc_html__('Show "All" Option', 'divi-shop-builder'),
				'description'      => esc_html__('Choose whether to display an option for All items.', 'divi-shop-builder'),
				'type'             => 'yes_no_button',
				'options'          => array(
					'on'  => esc_html__('On', 'divi-shop-builder'),
					'off' => esc_html__('Off', 'divi-shop-builder'),
				),
				'option_category'  => 'basic_option',
				'default'          => 'on',
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'display_as' => array('radio_buttons_list', 'tagcloud'),
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'select_placeholder_text'    => array(
				'label'            => esc_html__('"Please Select" Text', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Text entered here will appear when no selection has been made.', 'divi-shop-builder'),
				'toggle_slug'      => 'advanced_filter_settings',
				'default'          => __('Please select', 'divi-shop-builder'),
				'show_if'          => array(
					'display_as' => 'dropdown_multi_select',
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'rating_text_only'           => array(
				'label'            => esc_html__('"Only" text', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Text to be displayed for options to display products with a specific star rating. Use ***** (5 asterisks) to indicate where the stars should be inserted.', 'divi-shop-builder'),
				'default'          => __('***** only', 'divi-shop-builder'),
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter'     => 'rating',
					'display_as_rating' => ['stars_only', 'radio_stars', 'dropdown_stars']
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'rating_text_and_up'         => array(
				'label'            => esc_html__('"And up" text', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Text to be displayed for options to display products with at least the specified star rating. Use ***** (5 asterisks) to indicate where the stars should be inserted.', 'divi-shop-builder'),
				'default'          => __('***** and up', 'divi-shop-builder'),
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter'     => 'rating',
					'display_as_rating' => ['stars', 'radio_stars', 'dropdown_stars']
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'rating_text_all'            => array(
				'label'            => esc_html__('"All" text', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Text to be displayed for the option to show products with all ratings.', 'divi-shop-builder'),
				'default'          => __('All', 'divi-shop-builder'),
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter'     => 'rating',
					'display_as_rating' => ['radio_stars', 'dropdown_stars', 'radio_text', 'dropdown_text']
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'rating_text_1_up'           => array(
				'label'            => esc_html__('"1 star and up" text', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Text to be displayed for the option to show products with a rating of 1 star or more.', 'divi-shop-builder'),
				'default'          => __('1 star and up', 'divi-shop-builder'),
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter'     => 'rating',
					'display_as_rating' => ['radio_text', 'dropdown_text']
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'rating_text_2_up'           => array(
				'label'            => esc_html__('"2 stars and up" text', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Text to be displayed for the option to show products with a rating of 2 stars or more.', 'divi-shop-builder'),
				'default'          => __('2 stars and up', 'divi-shop-builder'),
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter'     => 'rating',
					'display_as_rating' => ['radio_text', 'dropdown_text']
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'rating_text_3_up'           => array(
				'label'            => esc_html__('"3 stars and up" text', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Text to be displayed for the option to show products with a rating of 3 stars or more.', 'divi-shop-builder'),
				'default'          => __('3 stars and up', 'divi-shop-builder'),
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter'     => 'rating',
					'display_as_rating' => ['radio_text', 'dropdown_text']
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'rating_text_4_up'           => array(
				'label'            => esc_html__('"4 stars and up" text', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Text to be displayed for the option to show products with a rating of 4 stars or more.', 'divi-shop-builder'),
				'default'          => __('4 stars and up', 'divi-shop-builder'),
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter'     => 'rating',
					'display_as_rating' => ['radio_text', 'dropdown_text']
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'rating_text_1'              => array(
				'label'            => esc_html__('"1 star" text', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Text to be displayed for the option to show products with a rating of 1 star.', 'divi-shop-builder'),
				'default'          => __('1 star', 'divi-shop-builder'),
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter'     => 'rating',
					'display_as_rating' => 'checkboxes_text'
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'rating_text_2'              => array(
				'label'            => esc_html__('"2 stars" text', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Text to be displayed for the option to show products with a rating of 2 stars.', 'divi-shop-builder'),
				'default'          => __('2 stars', 'divi-shop-builder'),
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter'     => 'rating',
					'display_as_rating' => 'checkboxes_text'
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'rating_text_3'              => array(
				'label'            => esc_html__('"3 stars" text', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Text to be displayed for the option to show products with a rating of 3 stars.', 'divi-shop-builder'),
				'default'          => __('3 stars', 'divi-shop-builder'),
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter'     => 'rating',
					'display_as_rating' => 'checkboxes_text'
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'rating_text_4'              => array(
				'label'            => esc_html__('"4 stars" text', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Text to be displayed for the option to show products with a rating of 4 stars.', 'divi-shop-builder'),
				'default'          => __('4 stars', 'divi-shop-builder'),
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter'     => 'rating',
					'display_as_rating' => 'checkboxes_text'
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'rating_text_5'              => array(
				'label'            => esc_html__('"5 stars" text', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Text to be displayed for the option to show products with a rating of 5 stars.', 'divi-shop-builder'),
				'default'          => __('5 stars', 'divi-shop-builder'),
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter'     => 'rating',
					'display_as_rating' => ['checkboxes_text', 'radio_text', 'dropdown_text']
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'sale_text'                  => array(
				'label'            => esc_html__('"On sale" text', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Text to be displayed for the option to show products that are on sale.', 'divi-shop-builder'),
				'default'          => __('On sale', 'divi-shop-builder'),
				'toggle_slug'      => 'advanced_filter_settings',
				'show_if'          => array(
					'choose_filter' => 'sale'
				),
				'computed_affects' => array(
					'__woofilters',
				),
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
			'filter_title_margin'             => array(
				'label'           => esc_html__('Margin', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_title',
				'sub_toggle'      => 'spacing',
			),
			'filter_title_padding'            => array(
				'label'           => esc_html__('Padding', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_title',
				'sub_toggle'      => 'spacing',
			),
			'filter_inner_bg_color'           => array(
				'label'       => esc_html__('Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_inner',
				'sub_toggle'  => 'background',
			),
			'filter_inner_margin'             => array(
				'label'           => esc_html__('Margin', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_inner',
				'sub_toggle'      => 'spacing',
			),
			'filter_inner_padding'            => array(
				'label'           => esc_html__('Padding', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_inner',
				'sub_toggle'      => 'spacing',
			),
			'filter_title_toggle_arrow_color' => array(
				'label'       => esc_html__('Toogled Title Arrow Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_title',
				'sub_toggle'  => 'toggle_arrow',
			),
			'filter_title_toggle_arrow_size'  => array(
				'label'          => esc_html__('Toogled Title Arrow Size', 'divi-shop-builder'),
				'description'    => esc_html__('Adjust the size of arrow. Allowed units px.', 'divi-shop-builder'),
				'type'           => 'range',
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
				'default'         => 'off',
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
				'default'         => 'off',
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
				'show_if'        => array(
					'filter_search_dropdown_arrow_enable' => 'on'
				),
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
				'multi_selection' => false,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_search',
				'sub_toggle'      => 'dropdown',
				'show_if'         => array(
					'filter_search_dropdown_arrow_enable' => 'on'
				),
			),
			'filter_search_dropdown_arrow_offset'    => array(
				'label'          => esc_html__('Search Dropdown Arrow Offset', 'divi-shop-builder'),
				'description'    => esc_html__('Define the horizontal arrow\'s offset distance from the right or left edge of the dropdown. Allowed units px.', 'divi-shop-builder'),
				'type'           => 'range',
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
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_price',
			),
			'filter_price_range_slider_color'            => array(
				'label'       => esc_html__('Range Slider Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_price',
			),
			'filter_price_range_slider_radius'           => array(
				'label'          => esc_html__('Range Slider Border Radius', 'divi-shop-builder'),
				'description'    => esc_html__('Adjust the border radius of range slider. Allowed units px and %.', 'divi-shop-builder'),
				'type'           => 'range',
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
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_price',
			),
			'filter_price_range_slider_pointer_radius'   => array(
				'label'          => esc_html__('Range Slider Pointer Border Radius', 'divi-shop-builder'),
				'description'    => esc_html__('Adjust the border radius of range slider pointer. Allowed units px and %.', 'divi-shop-builder'),
				'type'           => 'range',
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
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_price',
			),
			'filter_price_range_slider_tooltip_color'    => array(
				'label'       => esc_html__('Range Slider Tooltip Text Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_price',
			),
			'filter_price_range_slider_tooltip_radius'   => array(
				'label'          => esc_html__('Range Slider Tooltip Border Radius', 'divi-shop-builder'),
				'description'    => esc_html__('Adjust the border radius of range slider tooltip. Allowed units px.', 'divi-shop-builder'),
				'type'           => 'range',
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
			// Tag Cloud
			// -----------------------------------------------------

			'filter_tagcloud_tag_bg_color'            => array(
				'label'       => esc_html__('Tag Background', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_tagcloud',
				'sub_toggle'  => 'background',
			),
			'filter_tagcloud_tag_active_bg_color'     => array(
				'label'       => esc_html__('Active Tag Background', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'hover'       => 'tabs',
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
			'filter_tagcloud_tag_margin'              => array(
				'label'           => esc_html__('Margin', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_tagcloud',
				'sub_toggle'      => 'spacing',
			),
			'filter_tagcloud_tag_padding'             => array(
				'label'           => esc_html__('Padding', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'filter_tagcloud',
				'sub_toggle'      => 'spacing',
			),

			// -----------------------------------------------------
			// Rating
			// -----------------------------------------------------

			'filter_rating_star_color'             => array(
				'label'       => esc_html__('Star Rating Color', 'divi-shop-builder'),
				'description' => esc_html__('Here you can define a custom color for active rating icons.', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_rating',
			),
			'filter_rating_star_placeholder_color' => array(
				'label'       => esc_html__('Non-Active Star Rating Color', 'divi-shop-builder'),
				'description' => esc_html__('Here you can define a custom color for the placeholder star rating icon.', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_rating',
			),
			'filter_rating_star_hover_color'       => array(
				'label'       => esc_html__('Hover Star Color', 'divi-shop-builder'),
				'description' => esc_html__('Here you can define a custom color for rating icons on hover.', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'filter_rating',
			),
			'filter_rating_size'                   => array(
				'label'          => esc_html__('Star Rating Size', 'divi-shop-builder'),
				'description'    => esc_html__('Increase or decrease the size of the star rating icon. ', 'divi-shop-builder'),
				'type'           => 'range',
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
			'products_number_margin'   => array(
				'label'           => esc_html__('Margin', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'products_number',
				'sub_toggle'      => 'spacing',
			),
			'products_number_padding'  => array(
				'label'           => esc_html__('Padding', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'products_number',
				'sub_toggle'      => 'spacing',
			),
			'disabled_on'  => array(
				'label'           => esc_html__('Disable On', 'divi-shop-builder'),
				'type'            => 'multiple_checkboxes',
				'options' => [
					'phone' => esc_html__('Phone', 'divi-shop-builder'),
					'tablet' => esc_html__('Tablet', 'divi-shop-builder'),
					'desktop' => esc_html__('Desktop', 'divi-shop-builder'),
				],
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'toggle_slug'     => 'visibility',
			),

			// -----------------------------------------------------
			// Attributes - Colors, Images
			// -----------------------------------------------------

			'display_inline'        => array(
				'label'           => esc_html__('Display Inline', 'divi-shop-builder'),
				'option_category' => 'basic_option',
				'type'            => 'yes_no_button',
				'options'         => array(
					'on'  => esc_html__('Yes', 'divi-shop-builder'),
					'off' => esc_html__('No', 'divi-shop-builder'),
				),
				'description'     => esc_html__('Show inputs inline or each in a new row.', 'divi-shop-builder'),
				'default'         => 'on',
				'show_if'      => array(
					'choose_filter' => array('attribute','category'),
//                  Here we should have OR, but it's not supported
//                  'display_as_attribute' => ['images'],
//					'display_as' => 'images'
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'color_image_select',
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'attr_image_flex_basis'  => array(
				'label'          => esc_html__('Image Select Flex Basis', 'divi-shop-builder'),
				'description' =>  esc_html__('You can set a specific size for the select using a length value (e.g., pixels, percentage) .This means that, initially, the item will have a size of X pixels or X % along the main axis. However, this size can be adjusted later based on the available space and the flex-grow and flex-shrink properties of the item.', 'divi-shop-builder'),
				'type'           => 'range',
				'allowed_units'  => array('px', '%'),
				'validate_unit'  => true,
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '400',
					'step' => '1',
				),
				'mobile_options' => true,
				'sticky'         => true,
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'color_image_select',
				'show_if'      => array(
					'choose_filter' => array('attribute','category'),
					'display_inline' => 'on',
//                   Here we should have OR, but it's not supported
//					'display_as_attribute' => ['images'],
//					'display_as' => 'images'
				),
			),

			'attribute_border_color' => array(
				'label'       => esc_html__('Border Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'color_image_select',
				'show_if'      => array(
					'choose_filter' => array('attribute','category'),
//                   Here we should have OR, but it's not supported
//					'display_as_attribute' => ['images'],
//					'display_as' => 'images'
				),
			),
			'attribute_selected_accent' => array(
				'label'       => esc_html__('Selected Border Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'color_image_select',
				'default' => et_builder_accent_color(),
				'show_if'      => array(
					'choose_filter' => array('attribute','category'),
//                   Here we should have OR, but it's not supported
//					'display_as_attribute' => ['colors', 'images'],
//					'display_as' => 'images'
				),
			),
			'attribute_bg_accent' => array(
				'label'       => esc_html__('Image Container Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'color_image_select',
				'show_if'      => array(
					'choose_filter' => array('attribute','category'),
//                   Here we should have OR, but it's not supported
//					'display_as_attribute' => ['images'],
//					'display_as' => 'images'
				),
			),
			'attribute_selected_bg_accent' => array(
				'label'       => esc_html__('Selected Image Container Background Color ', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'color_image_select',
				'default' => '#fafafa',
				'show_if'      => array(
					'choose_filter' => array('attribute','category'),
//                   Here we should have OR, but it's not supported
//					'display_as_attribute' => ['images'],
//					'display_as' => 'images'
				),
			),
			'attribute_selected_text_color' => array(
				'label'       => esc_html__('Selected Label Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'color_image_select',
				'show_if'      => array(
					'choose_filter' => array('attribute','category'),
//					'display_as_attribute' => ['images', 'colors']
				),
			),

			'attr_select_style'          => array(
				'label'           => esc_html__( 'Select Style', 'divi-shop-builder' ),
				'type'            => 'DSLayoutMultiselect-DSB',
				'option_category' => 'basic_option',
				'options'         => array(
					'1' => array(
						'title'   => __( 'Icon 1', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('swatches/1' )
					),
					'2' => array(
						'title'   => __( 'Icon 2', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('swatches/2' )
					),
					'3' => array(
						'title'   => __( 'Icon 3', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('swatches/3' )
					),
					'4' => array(
						'title'   => __( 'Icon 3', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('swatches/4' )
					),
					'5' => array(
						'title'   => __( 'Icon 3', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('swatches/5' )
					),
					'6' => array(
						'title'   => __( 'Icon 3', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('swatches/6' )
					)
				),
				'default'         => '1',
				'customClass'     => 'dswcp-mini-cart-icon-select',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'color_image_select',
				'show_if'      => array(
					'choose_filter' => array('attribute','category'),
					//  Here we should have OR, but it's not supported
					// 'display_as_attribute' => ['colors' , 'images']
				),
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'attr_spacing'                => array(
				'label'          => esc_html__('Swatches / Images Spacing', 'divi-shop-builder'),
				'description'    => esc_html__('Increase or decrease the spacing between the color swatches. Use px units.', 'divi-shop-builder'),
				'type'           => 'range',
				'allowed_units'  => array('px'),
				'validate_unit'  => true,
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'mobile_options' => true,
				'sticky'         => true,
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'color_image_select',
				'show_if'      => array(
					'choose_filter' => array('attribute','category'),
					//  Here we should have OR, but it's not supported
					// 'display_as_attribute' => ['colors', 'images']
				),
			),
			'attr_image_width'                => array(
				'label'          => esc_html__('Image Max Width', 'divi-shop-builder'),
				'type'           => 'range',
				'allowed_units'  => array('px'),
				'validate_unit'  => true,
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'mobile_options' => true,
				'sticky'         => true,
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'color_image_select',
				'show_if'      => array(
					'choose_filter' => array('attribute','category'),
					//  Here we should have OR, but it's not supported
					// 'display_as_attribute' => ['images']
				),
			),
			'attr_image_height'                => array(
				'label'          => esc_html__('Image Max Height', 'divi-shop-builder'),
				'type'           => 'range',
				'allowed_units'  => array('px'),
				'validate_unit'  => true,
				'default_unit'   => 'px',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'mobile_options' => true,
				'sticky'         => true,
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'color_image_select',
				'show_if'      => array(
					'choose_filter' => array('attribute','category'),
					//  Here we should have OR, but it's not supported
					// 'display_as_attribute' => ['images']
				),
			),
			'attr_image_border_radius'                => array(
				'label'          => esc_html__('Image Select Border Radius', 'divi-shop-builder'),
				'type'           => 'range',
				'allowed_units'  => array('px'),
				'validate_unit'  => true,
				'default_unit'   => 'px',
				'default'   => '0px',
				'range_settings' => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'mobile_options' => true,
				'sticky'         => true,
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'color_image_select',
				'show_if'      => array(
					'choose_filter' => array('attribute','category'),
					//  Here we should have OR, but it's not supported
					// 'display_as_attribute' => ['images']
				),
			),
			'color_swatches_size'                => array(
				'label'          => esc_html__('Color Swatches Size', 'divi-shop-builder'),
				'description'    => esc_html__('Increase or decrease the color swatches. Use px units.', 'divi-shop-builder'),
				'type'           => 'range',
				'allowed_units'  => array('px'),
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
				'toggle_slug' => 'color_image_select',
				'show_if'      => array(
					'choose_filter' => 'attribute',
					'display_as_attribute' => ['colors']
				),
			),
			'attr_image_position'          => array(
				'label'           => esc_html__( 'Image Position', 'divi-shop-builder' ),
				'type'            => 'DSLayoutMultiselect-DSB',
				'option_category' => 'basic_option',
				'options'         => array(
					'above' => array(
						'title'   => __( 'above', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('position/above' )
					),
					'left' => array(
						'title'   => __( 'left', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('position/left' )
					)
				),
				'default'         => 'above',
				'customClass'     => 'col-small',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'color_image_select',
				'show_if'      => array(
					'choose_filter' => array('attribute','category'),
					//  Here we should have OR, but it's not supported
					// 'display_as_attribute' => ['images']
				)
			),
			'attr_image_margin'              => array(
				'label'           => esc_html__('Image Margin', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'color_image_select',
				'show_if'      => array(
					'choose_filter' => array('attribute','category'),
					//  Here we should have OR, but it's not supported
					// 'display_as_attribute' => ['images']
				),
			),
			'attr_select_margin'              => array(
				'label'           => esc_html__('Image Select Margin', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'color_image_select',
				'show_if'      => array(
					'choose_filter' => array('attribute','category'),
					//  Here we should have OR, but it's not supported
					// 'display_as_attribute' => ['images']
				),
			),
			'attr_select_padding'             => array(
				'label'           => esc_html__('Image Select Padding', 'divi-shop-builder'),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'color_image_select',
				'show_if'      => array(
					'choose_filter' => array('attribute','category'),
					//  Here we should have OR, but it's not supported
					//'display_as_attribute' => ['images']
				),
			),

			'hide_tooltip'        => array(
				'label'           => esc_html__('Hide Tooltip', 'divi-shop-builder'),
				'option_category' => 'basic_option',
				'type'            => 'yes_no_button',
				'options'         => array(
					'on'  => esc_html__('Yes', 'divi-shop-builder'),
					'off' => esc_html__('No', 'divi-shop-builder'),
				),
				'description'     => esc_html__('Hide tooltip on input hover.', 'divi-shop-builder'),
				'default'         => 'off',
				'show_if'      => array(
					'choose_filter' => array('attribute','category'),
					//  Here we should have OR, but it's not supported
					// 'display_as_attribute' => ['colors', 'images'],
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tooltip',
				'computed_affects' => array(
					'__woofilters',
				),
			),
			'tooltip_bg_color' => array(
				'label'       => esc_html__('Tooltip Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tooltip',
				'show_if'      => array(
					'choose_filter' => array('attribute','category'),
					//  Here we should have OR, but it's not supported
					// 'display_as_attribute' => ['images', 'colors'],
					'hide_tooltip' => 'off'
				),
			),

			'attr_color_products_number_color' => array(
				'label'       => esc_html__('Product Number Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'color_swatches_products_number',
				'show_if'      => array(
					'choose_filter' => 'attribute',
					'display_as_attribute' => [ 'colors'],
				),
			),
			'attr_color_products_number_bg_color' => array(
				'label'       => esc_html__('Product Number Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'color_swatches_products_number',
				'show_if'      => array(
					'choose_filter' => 'attribute',
					'display_as_attribute' => ['colors'],
				),
			),

		);

		$fields['__woofilters'] = [
			'type'                => 'computed',
			'computed_callback'   => array(__CLASS__, 'get_woofilters_html'),
			'computed_depends_on' => array_values(array_diff( array_keys($fields), ['attr_image_flex_basis', 'attribute_selected_text_color', 'attr_select_padding', 'attr_select_margin','attr_image_margin','attr_image_position','parent_layout', 'tooltip_bg_color','color_swatches_size', 'attr_color_products_number_bg_color', 'attr_color_products_number_color', 'disabled_on', 'attribute_selected_accent','attribute_border_color', 'attribute_bg_accent','attribute_selected_bg_accent', 'attr_spacing','attr_image_width', 'attr_image_height', 'attr_image_border_radius', 'checkbox_checked_color', 'checkbox_checked_background_color', 'checkbox_background_color', 'filter_checkbox_list_item_bg_color','filter_checkbox_list_item_color', 'filter_checkbox_list_item_margin', 'filter_checkbox_list_item_padding', 'filter_select_dropdown_bg_color', 'filter_select_dropdown_margin',  'filter_select_dropdown_padding', 'filter_select_dropdown_arrow_enable', 'filter_select_dropdown_arrow_size', 'filter_select_dropdown_arrow_alignment', 'filter_select_dropdown_arrow_offset' , 'filter_select_dropdown_item_bg_color' , 'filter_select_dropdown_item_color' , 'filter_select_dropdown_item_selected_bg_color','filter_select_dropdown_item_selected_color',  'filter_select_dropdown_item_selected_check_color',  'filter_select_dropdown_item_margin' , 'filter_select_dropdown_item_padding', 'filter_search_icon_color',  'filter_search_focus_icon_color', 'filter_search_icon_size', 'filter_search_icon_position', 'filter_search_dropdown_bg_color', 'filter_search_dropdown_margin' , 'filter_search_dropdown_padding',  'filter_search_dropdown_arrow_enable','filter_search_dropdown_arrow_size', 'filter_search_dropdown_arrow_alignment', 'filter_search_dropdown_arrow_offset', 'filter_search_dropdown_item_bg_color',  'filter_search_dropdown_item_color', 'filter_search_dropdown_item_margin' , 'filter_search_dropdown_item_padding', 'filter_price_range_slider_bg_color', 'filter_price_range_slider_color',  'filter_price_range_slider_radius','filter_price_range_slider_pointer_color', 'filter_price_range_slider_pointer_radius', 'filter_price_range_slider_tooltip_bg_color' , 'filter_price_range_slider_tooltip_color', 'filter_price_range_slider_tooltip_radius',  'filter_tagcloud_tag_bg_color', 'filter_tagcloud_tag_active_bg_color','filter_tagcloud_tag_text_color','filter_tagcloud_tag_active_text_color','filter_tagcloud_tag_active_border_color', 'filter_tagcloud_tag_margin', 'filter_tagcloud_tag_padding',
			'filter_rating_star_color','filter_rating_star_placeholder_color','filter_rating_star_hover_color','filter_rating_size','filter_rating_spacing','products_number_bg_color','products_number_margin','products_number_padding','display_as_toggle','toggle_default'
				]
			))
		];

		return $fields;
	}

	/**
	 * Module's advanced fields configuration
	 *
	 * @return array
	 * @since 1.0.0
	 *
	 */
	function get_advanced_fields_config() {
		return array(
			'fonts'          => array(
				'filter_text'                      => array(
					'label'       => esc_html__('Filter Text', 'divi-shop-builder'),
					'css'         => array(
						'main'      => "{$this->main_css_element}",
						'important' => 'all',
					),
					'toggle_slug' => 'filter_container',
					'sub_toggle'  => 'p',
				),
				'filter_title'                     => array(
					'label'       => esc_html__('Filter Title', 'divi-shop-builder'),
					'css'         => array(
						'main'      => "{$this->main_css_element} .ags-wc-filters-section-title h4",
						'important' => true,
					),
					'toggle_slug' => 'filter_title',
					'sub_toggle'  => 'h2',
				),
				'filter_radio_list'                => array(
					'label'           => esc_html__('List Item Text', 'divi-shop-builder'),
					'hide_text_align' => true,
					'hide_text_color' => true,
					'css'             => array(
						'main'      => "{$this->main_css_element} .ags-wc-filters-radio-button-list li label",
						'important' => 'all',
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
						'main'      => "{$this->main_css_element} .ags-wc-filters-checkbox-list li label",
						'important' => 'all',
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
						'main'      => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a",
						'important' => 'all',
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
						'main'      => "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a",
						'important' => 'all',
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
						'main'      => "{$this->main_css_element} .ags-wc-filters-tagcloud label",
						'important' => 'all',
					),
					'toggle_slug'     => 'filter_tagcloud',
					'sub_toggle'      => 'p',
				),
				'products_number'                  => array(
					'label'           => esc_html__('Products Number Text', 'divi-shop-builder'),
					'hide_text_align' => true,
					'css'             => array(
						'main'      => "{$this->main_css_element} .ags-wc-filters-product-count",
						'important' => 'all',
					),
					'toggle_slug'     => 'products_number',
					'sub_toggle'      => 'p',
				),
				'tooltip'                  => array(
					'label'           => esc_html__('Tooltip Text', 'divi-shop-builder'),
					'hide_text_align' => true,
					'css'             => array(
						'main'      => "{$this->main_css_element} .ags_wc_filters_tooltip > span",
						'important' => 'all',
					),
					'toggle_slug'     => 'tooltip'
				),
				'color_swatches_products_number'                  => array(
					'label'           => esc_html__('Products Number In Right Corner', 'divi-shop-builder'),
					'hide_text_align' => true,
					'css'             => array(
						'main'      => "{$this->main_css_element} .ags-wc-filters-colors.ags-wc-filters-labels-hide label > .ags-wc-filters-product-count",
						'important' => 'all',
					),
					'toggle_slug'     => 'color_swatches_products_number'
				),
			),
			'box_shadow'     => array(
				'filter_container_shadow'       => array(
					'css'         => array(
						'main' => "{$this->main_css_element}",
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_container',
					'sub_toggle'  => 'background',
				),
				'filter_title_shadow'           => array(
					'css'         => array(
						'main' => "{$this->main_css_element} .ags-wc-filters-section-title",
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_title',
					'sub_toggle'  => 'background',
				),
				'filter_inner_shadow'           => array(
					'css'         => array(
						'main' => "{$this->main_css_element} .ags-wc-filters-section-inner",
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_inner',
					'sub_toggle'  => 'background',
				),
				'filter_select_dropdown_shadow' => array(
					'css'         => array(
						'main' => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options",
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_select_dropdown',
					'sub_toggle'  => 'dropdown',
				),
				'filter_search_dropdown_shadow' => array(
					'css'         => array(
						'main' => "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container",
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_search',
					'sub_toggle'  => 'dropdown',
					'priority'    => 60,
				),
				'filter_tagcloud_shadow'        => array(
					'css'         => array(
						'main' => "{$this->main_css_element} .ags-wc-filters-tagcloud li label",
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_tagcloud',
					'sub_toggle'  => 'background',
				),
				'products_number_shadow'        => array(
					'css'         => array(
						'main' => "{$this->main_css_element} .ags-wc-filters-product-count",
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'products_number',
					'sub_toggle'  => 'background',
				),
				'tooltip'        => array(
					'css'         => array(
						'main' => "{$this->main_css_element} .ags_wc_filters_tooltip",
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'tooltip'
				),
				'color_swatches_products_number'        => array(
					'css'         => array(
						'main' => "{$this->main_css_element} .ags-wc-filters-colors.ags-wc-filters-labels-hide label > .ags-wc-filters-product-count",
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'color_swatches_products_number'
				),
			),
			'borders'        => array(
				'default'                            => false,
				'filter_container_border'            => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => "{$this->main_css_element}",
							'border_styles' => "{$this->main_css_element}",
						)
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_container',
					'sub_toggle'  => 'border',
				),
				'filter_title_border'                => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => "{$this->main_css_element} .ags-wc-filters-section-title",
							'border_styles' => "{$this->main_css_element} .ags-wc-filters-section-title",
						)
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_title',
					'sub_toggle'  => 'border',
				),
				'filter_inner_border'                => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => "{$this->main_css_element} .ags-wc-filters-section-inner",
							'border_styles' => "{$this->main_css_element} .ags-wc-filters-section-inner",
						)
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_inner',
					'sub_toggle'  => 'border',
				),
				'filter_radio_list_item_border'      => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => "{$this->main_css_element} .ags-wc-filters-radio-button-list li",
							'border_styles' => "{$this->main_css_element} .ags-wc-filters-radio-button-list li",
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
							'border_radii'  => "{$this->main_css_element} .ags-wc-filters-checkbox-list li",
							'border_styles' => "{$this->main_css_element} .ags-wc-filters-checkbox-list li",
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
							'border_radii'  => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options",
							'border_styles' => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options",
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
							'border_radii'  => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a",
							'border_styles' => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a",
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
							'border_radii'  => "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container",
							'border_styles' => "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container",
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
							'border_radii'  => "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a",
							'border_styles' => "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a",
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
							'border_radii'  => "{$this->main_css_element} .ags-wc-filters-tagcloud li label",
							'border_styles' => "{$this->main_css_element} .ags-wc-filters-tagcloud li label",
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
							'border_radii'  => "{$this->main_css_element} .ags-wc-filters-product-count",
							'border_styles' => "{$this->main_css_element} .ags-wc-filters-product-count",
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'products_number',
					'sub_toggle'  => 'border',
				),
				'color_swatches_products_number'             => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => "{$this->main_css_element} .ags-wc-filters-colors.ags-wc-filters-labels-hide label > .ags-wc-filters-product-count",
							'border_styles' => "{$this->main_css_element} .ags-wc-filters-colors.ags-wc-filters-labels-hide label > .ags-wc-filters-product-count",
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'color_swatches_products_number',
				),
			),
			'form_field'     => array(
				'form_field_select' => array(
					'label'          => esc_html__('Select Field', 'divi-shop-builder'),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'form_field_select',
					'css'            => array(
						'background_color'       => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span",
						'main'                   => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span",
						'background_color_hover' => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:hover, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:hover",
						'focus_background_color' => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:focus, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:focus",
						'form_text_color'        => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span",
						'form_text_color_hover'  => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:hover, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:hover",
						'focus_text_color'       => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:focus, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:focus",
						'placeholder_focus'      => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:focus::-webkit-input-placeholder, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:focus::-webkit-input-placeholder, {$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:focus::-moz-placeholder, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:focus::-moz-placeholder, {$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:focus:-ms-input-placeholder, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:focus:-ms-input-placeholder",
						'padding'                => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span",
						'margin'                 => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span",
						'important'              => array(
							'background_color',
							'background_color_hover',
							'focus_background_color',
							'form_text_color',
							'form_text_color_hover',
							'text_color',
							'focus_text_color',
							'padding',
							'margin',
						),
					),
					'box_shadow'     => false,
					'border_styles'  => array(
						'form_field_select'       => array(
							'name'         => 'form_field_select',
							'css'          => array(
								'main'      => array(
									'border_radii'  => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span",
									'border_styles' => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span",
								),
								'important' => 'all',
							),
							'label_prefix' => esc_html__('Fields', 'divi-shop-builder'),
						),
						'form_field_select_focus' => array(
							'name'         => 'form_field_select_focus',
							'css'          => array(
								'main'      => array(
									'border_radii'  => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:focus, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:focus",
									'border_styles' => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:focus, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:focus",
								),
								'important' => 'all',
							),
							'label_prefix' => esc_html__('Fields On Focus', 'divi-shop-builder'),
						),
					),
					'font_field'     => array(
						'css' => array(
							'main'      => array(
								"{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span",
							),
							'hover'     => array(
								"{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:hover, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:hover",
								"{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:focus::-webkit-input-placeholder, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:focus::-webkit-input-placeholder",
								"{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:focus::-moz-placeholder, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:focus::-moz-placeholder",
								"{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a:focus:-ms-input-placeholder, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span:focus:-ms-input-placeholder",
							),
							'important' => 'all',
						),
					),
					'margin_padding' => array(
						'css' => array(
							'main'      => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span",
							'padding'   => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span",
							'margin'    => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-active > a, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-active>span",
							'important' => 'all'
						),
					)
				),
				'form_field_search' => array(
					'label'          => esc_html__('Search Field', 'divi-shop-builder'),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'form_field_search',
					'css'            => array(
						'background_color'       => "{$this->main_css_element} .ags-wc-filters-search-input-wrapper",
						'main'                   => "{$this->main_css_element} input[type=search]",
						'background_color_hover' => "{$this->main_css_element} .ags-wc-filters-search-input-wrapper:hover",
						'focus_background_color' => "{$this->main_css_element} .ags-wc-filters-search-input-wrapper:focus-within",
						'form_text_color'        => "{$this->main_css_element} input[type=search], {$this->main_css_element} input[type=search]::-webkit-input-placeholder, {$this->main_css_element} input[type=search]::-moz-placeholder, {$this->main_css_element} input[type=search]:-ms-input-placeholder",
						'form_text_color_hover'  => "{$this->main_css_element} input[type=search]:hover, {$this->main_css_element} input[type=search]:hover::-webkit-input-placeholder, {$this->main_css_element} input[type=search]:hover::-moz-placeholder, {$this->main_css_element} input[type=search]:hover:-ms-input-placeholder",
						'focus_text_color'       => "{$this->main_css_element} input[type=search]:focus",
						'placeholder_focus'      => "{$this->main_css_element} input[type=search]:focus::-webkit-input-placeholder, {$this->main_css_element} input[type=search]:focus::-moz-placeholder, {$this->main_css_element} input[type=search]:focus:-ms-input-placeholder",
						'padding'                => "{$this->main_css_element} input[type=search]",
						'margin'                 => "{$this->main_css_element} .ags-wc-filters-search-input-wrapper",
						'important'              => array(
							'background_color',
							'background_color_hover',
							'focus_background_color',
							'form_text_color',
							'form_text_color_hover',
							'text_color',
							'focus_text_color',
							'padding',
							'margin',
						),
					),
					'box_shadow'     => false,
					'border_styles'  => array(
						'form_field_search'       => array(
							'name'         => 'form_field_search',
							'css'          => array(
								'main'      => array(
									'border_radii'  => "{$this->main_css_element} .ags-wc-filters-search-input-wrapper",
									'border_styles' => "{$this->main_css_element} .ags-wc-filters-search-input-wrapper",
								),
								'important' => 'all',
							),
							'label_prefix' => esc_html__('Fields', 'divi-shop-builder'),
						),
						'form_field_search_focus' => array(
							'name'         => 'form_field_search_focus',
							'css'          => array(
								'main'      => array(
									'border_radii'  => "{$this->main_css_element} .ags-wc-filters-search-input-wrapper:focus-within",
									'border_styles' => "{$this->main_css_element} .ags-wc-filters-search-input-wrapper:focus-within",
								),
								'important' => 'all',
							),
							'label_prefix' => esc_html__('Fields On Focus', 'divi-shop-builder'),
						),
					),
					'font_field'     => array(
						'css' => array(
							'main'      => array(
								"{$this->main_css_element} input[type=search]",
							),
							'hover'     => array(
								"{$this->main_css_element} input[type=search]:hover",
								"{$this->main_css_element} input[type=search]:focus::-webkit-input-placeholder",
								"{$this->main_css_element} input[type=search]:focus::-moz-placeholder",
								"{$this->main_css_element} input[type=search]:focus:-ms-input-placeholder",
							),
							'important' => 'all',
						),
					),
					'margin_padding' => array(
						'css' => array(
							'main'      => "{$this->main_css_element} input[type=search]",
							'padding'   => "{$this->main_css_element} input[type=search]",
							'margin'    => "{$this->main_css_element} .ags-wc-filters-search-input-wrapper",
							'important' => 'all'
						),
					)
				),
				'form_field_number' => array(
					'label'          => esc_html__('Number Field', 'divi-shop-builder'),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'form_field_number',
					'css'            => array(
						'background_color'       => "{$this->main_css_element} input[type=number]",
						'main'                   => "{$this->main_css_element} input[type=number]",
						'background_color_hover' => "{$this->main_css_element} input[type=number]:hover",
						'focus_background_color' => "{$this->main_css_element} input[type=number]:focus",
						'form_text_color'        => "{$this->main_css_element} input[type=number]",
						'form_text_color_hover'  => "{$this->main_css_element} input[type=number]:hover",
						'focus_text_color'       => "{$this->main_css_element} input[type=number]:focus",
						'placeholder_focus'      => "{$this->main_css_element} input[type=number]:focus::-webkit-input-placeholder, {$this->main_css_element} input[type=number]:focus::-moz-placeholder, {$this->main_css_element} input[type=number]:focus:-ms-input-placeholder",
						'padding'                => "{$this->main_css_element} input[type=number]",
						'margin'                 => "{$this->main_css_element} input[type=number]",
						'important'              => array(
							'background_color',
							'background_color_hover',
							'focus_background_color',
							'form_text_color',
							'form_text_color_hover',
							'text_color',
							'focus_text_color',
							'padding',
							'margin',
						),
					),
					'box_shadow'     => false,
					'border_styles'  => array(
						'form_field_number'       => array(
							'name'         => 'form_field_number',
							'css'          => array(
								'main'      => array(
									'border_radii'  => "{$this->main_css_element} input[type=number]",
									'border_styles' => "{$this->main_css_element} input[type=number]",
								),
								'important' => 'all',
							),
							'label_prefix' => esc_html__('Fields', 'divi-shop-builder'),
						),
						'form_field_number_focus' => array(
							'name'         => 'form_field_number_focus',
							'css'          => array(
								'main'      => array(
									'border_radii'  => "{$this->main_css_element} input[type=number]:focus",
									'border_styles' => "{$this->main_css_element} input[type=number]:focus",
								),
								'important' => 'all',
							),
							'label_prefix' => esc_html__('Fields On Focus', 'divi-shop-builder'),
						),
					),
					'font_field'     => array(
						'css' => array(
							'main'      => array(
								"{$this->main_css_element} input[type=number]",
							),
							'hover'     => array(
								"{$this->main_css_element} input[type=number]:hover",
								"{$this->main_css_element} input[type=number]:focus::-webkit-input-placeholder",
								"{$this->main_css_element} input[type=number]:focus::-moz-placeholder",
								"{$this->main_css_element} input[type=number]:focus:-ms-input-placeholder",
							),
							'important' => 'all',
						),
					),
					'margin_padding' => array(
						'css' => array(
							'main'      => "{$this->main_css_element} input[type=number]",
							'padding'   => "{$this->main_css_element} input[type=number]",
							'margin'    => "{$this->main_css_element} input[type=number]",
							'important' => 'all'
						),
					)
				),
			),
			'margin_padding' => false,
			'background'     => false,
			'button'         => false,
			'link_options'   => false,
			'text'           => false,
		);
	}

	/**
	 *  Used to generate responsive module CSS
	 *  Custom margin is based on update_styles() function.
	 *  Divi/includes/builder/module/field/MarginPadding.php
	 *
	 */
	private function apply_responsive($value, $selector, $css, $render_slug, $type, $default = null, $important = false) {

		$dstc_last_edited       = isset( $this->props[ $value . '_last_edited' ] ) ? $this->props[ $value . '_last_edited' ] : null;
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
				$dstc_tablet = isset( $this->props[ $value . '_tablet' ] ) ? trim(str_replace($re, ' ', $this->props[ $value . '_tablet' ])) : '';
				$dstc_phone  = isset(  $this->props[ $value . '_phone' ] ) ? trim(str_replace($re, ' ', $this->props[ $value . '_phone' ])) : '';

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

		// - Single Filter
		$this->apply_responsive('filter_container_padding', "{$this->main_css_element}", 'padding', $render_slug, 'custom_margin');
		$this->apply_responsive('filter_container_margin', "{$this->main_css_element}", 'margin', $render_slug, 'custom_margin', '', true);

		// - Filter Title
		$this->apply_responsive('filter_title_padding', "{$this->main_css_element} .ags-wc-filters-section-title", 'padding', $render_slug, 'custom_margin');
		$this->apply_responsive('filter_title_margin', "{$this->main_css_element} .ags-wc-filters-section-title", 'margin', $render_slug, 'custom_margin');

		// - Filter Inner
		$this->apply_responsive('filter_inner_padding', "{$this->main_css_element} .ags-wc-filters-section-inner", 'padding', $render_slug, 'custom_margin');
		$this->apply_responsive('filter_inner_margin', "{$this->main_css_element} .ags-wc-filters-section-inner", 'margin', $render_slug, 'custom_margin');

		// - Radio List Item
		$this->apply_responsive('filter_radio_list_item_padding', "{$this->main_css_element} .ags-wc-filters-radio-button-list li", 'padding', $render_slug, 'custom_margin');
		$this->apply_responsive('filter_radio_list_item_margin', "{$this->main_css_element} .ags-wc-filters-radio-button-list li", 'margin', $render_slug, 'custom_margin');

		// - Checkbox List Item
		$this->apply_responsive('filter_checkbox_list_item_padding', "{$this->main_css_element} .ags-wc-filters-checkbox-list li", 'padding', $render_slug, 'custom_margin');
		$this->apply_responsive('filter_checkbox_list_item_margin', "{$this->main_css_element} .ags-wc-filters-checkbox-list li", 'margin', $render_slug, 'custom_margin');

		// Image Select
		$this->apply_responsive('attr_select_padding', "{$this->main_css_element} .ags-wc-filters-images li label", 'padding', $render_slug, 'custom_margin');
		$this->apply_responsive('attr_select_margin', "{$this->main_css_element} .ags-wc-filters-images li label", 'margin', $render_slug, 'custom_margin', '', true);
		$this->apply_responsive('attr_image_margin', "{$this->main_css_element} .ags-wc-filters-images li label img", 'margin', $render_slug, 'custom_margin', '', true);

		// - Select Dropdown
		$this->apply_responsive('filter_select_dropdown_padding', "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options", 'padding', $render_slug, 'custom_margin');
		$this->apply_responsive('filter_select_dropdown_margin', "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options", 'margin', $render_slug, 'custom_margin', '', true);

		// - Select Dropdown Item
		$this->apply_responsive('filter_select_dropdown_item_padding', "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a label", 'padding', $render_slug, 'custom_margin', '10px|12px|10px|12px');
		$this->apply_responsive('filter_select_dropdown_item_margin', "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a label", 'margin', $render_slug, 'custom_margin');

		// - Search Dropdown
		$this->apply_responsive('filter_search_dropdown_padding', "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container", 'padding', $render_slug, 'custom_margin', '15px|0|15px|0');
		$this->apply_responsive('filter_search_dropdown_margin', "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container", 'margin', $render_slug, 'custom_margin', '', true);

		// - Search Dropdown Item
		$this->apply_responsive('filter_search_dropdown_item_padding', "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a", 'padding', $render_slug, 'custom_margin', '10px|12px|10px|12px');
		$this->apply_responsive('filter_search_dropdown_item_margin', "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a", 'margin', $render_slug, 'custom_margin');

		// - Tagcloud
		$this->apply_responsive('filter_tagcloud_tag_padding', "{$this->main_css_element} .ags-wc-filters-tagcloud li label", 'padding', $render_slug, 'custom_margin');
		$this->apply_responsive('filter_tagcloud_tag_margin', "{$this->main_css_element} .ags-wc-filters-tagcloud li label", 'margin', $render_slug, 'custom_margin');

		// - Product Count
		$this->apply_responsive('products_number_padding', "{$this->main_css_element} .ags-wc-filters-product-count", 'padding', $render_slug, 'custom_margin');
		$this->apply_responsive('products_number_margin', "{$this->main_css_element} .ags-wc-filters-product-count", 'margin', $render_slug, 'custom_margin');

		// Search Icon
		$this->apply_responsive('filter_search_icon_size', '{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-icon .ags-wc-filters-search-input-wrapper:after', 'font-size', $render_slug, 'default', '');

		// Toggled Title Arrow
		$this->apply_responsive('filter_title_toggle_arrow_size', "{$this->main_css_element} .ags-wc-filters-section-title.ags-wc-filters-section-toggle::after", 'font-size', $render_slug, 'default', '');

		// Rating
		$this->apply_responsive('filter_rating_spacing', "{$this->main_css_element} .ags-wc-filters-stars", 'letter-spacing', $render_slug, 'default');
		$this->apply_responsive('filter_rating_size', "{$this->main_css_element} .ags-wc-filters-stars", 'font-size', $render_slug, 'default', '');

		// Color Swatches
		$this->apply_responsive('color_swatches_size', "{$this->main_css_element} .ags-wc-filters-colors label .ags_wc_filters_color_wrap", 'font-size', $render_slug, 'default');

		$this->apply_responsive('attr_spacing', "{$this->main_css_element} .ags-wc-filters-colors li:not(:last-of-type),{$this->main_css_element} .ags-wc-filters-images li", 'padding-right', $render_slug, 'default');

		$this->apply_responsive('attr_spacing', "{$this->main_css_element} .ags-wc-filters-colors li:not(:last-of-type),{$this->main_css_element} .ags-wc-filters-images li", 'padding-bottom', $render_slug, 'default');


		$this->apply_responsive( 'attr_image_width', "{$this->main_css_element} .ags-wc-filters-images li label img", 'max-width', $render_slug, 'default' );

		if ( '50px' !== $props['attr_image_height'] ) {
			$this->apply_responsive( 'attr_image_height', "{$this->main_css_element} .ags-wc-filters-images li label img", 'max-height', $render_slug, 'default' );
		}

		if ( '' !== $props['attr_image_flex_basis'] ) {
			$this->apply_responsive( 'attr_image_flex_basis', "{$this->main_css_element} .ags-wc-filters-images li", 'flex-basis', $render_slug, 'default' );
		}

		if ( '0px' !== $props['attr_image_border_radius'] ) {
			$this->apply_responsive( 'attr_image_border_radius', "{$this->main_css_element} .ags-wc-filters-images li label", 'border-radius:', $render_slug, 'default' );
		}

		// -----------------------------------------------------
		// CSS
		// -----------------------------------------------------

		if ( '' !== $props['filter_container_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => "{$this->main_css_element}",
					'declaration' => sprintf('background-color:%s;', esc_attr($props['filter_container_bg_color'])),
				)
			);
		}
		if ( '' !== $props['filter_title_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-section-title",
					'declaration' => sprintf('background-color:%s;', esc_attr($props['filter_title_bg_color'])),
				)
			);
		}
		if ( '' !== $props['filter_inner_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-section-inner",
					'declaration' => sprintf('background-color:%s;', esc_attr($props['filter_inner_bg_color'])),
				)
			);
		}
		if ( '' !== $props['filter_select_dropdown_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options",
					'declaration' => sprintf('background-color:%s !important;', esc_attr($props['filter_select_dropdown_bg_color'])),
				)
			);
		}
		if ( '' !== $props['filter_search_dropdown_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container",
					'declaration' => sprintf('background-color:%s !important;', esc_attr($props['filter_search_dropdown_bg_color'])),
				)
			);
		}
		if ( '' !== $props['filter_search_icon_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-icon .ags-wc-filters-search-input-wrapper:after",
					'declaration' => sprintf('color:%s;', esc_attr($props['filter_search_icon_color'])),
				)
			);
		}
		if ( '' !== $props['filter_search_focus_icon_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-icon .ags-wc-filters-search-input-wrapper:focus-within:after",
					'declaration' => sprintf('color:%s;', esc_attr($props['filter_search_focus_icon_color'])),
				)
			);
		}
		if ( '' !== $props['filter_price_range_slider_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-number-range-container .rs-container .rs-selected",
					'declaration' => sprintf('background-color:%s;', esc_attr($props['filter_price_range_slider_color'])),
				)
			);
		}
		if ( '' !== $props['filter_price_range_slider_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-number-range-container .rs-container .rs-bg",
					'declaration' => sprintf('background-color:%s;', esc_attr($props['filter_price_range_slider_bg_color'])),
				)
			);
		}
		if ( '' !== $props['filter_price_range_slider_radius'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-number-range-container .rs-container .rs-selected, {$this->main_css_element} .ags-wc-filters-number-range-container .rs-container .rs-bg",
					'declaration' => sprintf('border-radius:%s;', esc_attr($props['filter_price_range_slider_radius'])),
				)
			);
		}
		if ( '' !== $props['filter_price_range_slider_pointer_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-number-range-container .rs-container .rs-pointer",
					'declaration' => sprintf('background-color:%s;', esc_attr($props['filter_price_range_slider_pointer_color'])),
				)
			);
		}
		if ( '' !== $props['filter_price_range_slider_pointer_radius'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-number-range-container .rs-container .rs-pointer",
					'declaration' => sprintf('border-radius:%s;', esc_attr($props['filter_price_range_slider_pointer_radius'])),
				)
			);
		}
		if ( '' !== $props['filter_price_range_slider_tooltip_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-number-range-container .rs-container .rs-tooltip",
					'declaration' => sprintf('color:%s;', esc_attr($props['filter_price_range_slider_tooltip_color'])),
				)
			);
		}
		if ( '' !== $props['filter_price_range_slider_tooltip_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-number-range-container .rs-container .rs-tooltip",
					'declaration' => sprintf('background-color:%s;', esc_attr($props['filter_price_range_slider_tooltip_bg_color'])),
				)
			);
		}
		if ( '' !== $props['filter_price_range_slider_tooltip_radius'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-number-range-container .rs-container .rs-tooltip",
					'declaration' => sprintf('border-radius:%s;', esc_attr($props['filter_price_range_slider_tooltip_radius'])),
				)
			);
		}
		if ( '' !== $props['filter_rating_star_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-stars .ags-wc-filters-star-filled",
					'declaration' => sprintf('color:%s;', esc_attr($props['filter_rating_star_color'])),
				)
			);
		}
		if ( '' !== $props['filter_rating_star_placeholder_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-stars .ags-wc-filters-star-empty",
					'declaration' => sprintf('color:%s;', esc_attr($props['filter_rating_star_placeholder_color'])),
				)
			);
		}
		if ( '' !== $props['filter_rating_star_hover_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-stars .ags-wc-filters-star-hover",
					'declaration' => sprintf('color:%s;', esc_attr($props['filter_rating_star_hover_color'])),
				)
			);
		}

		// Toggled Title Arrow Color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_title_toggle_arrow_color',
				'selector'       => "{$this->main_css_element} .ags-wc-filters-section-title.ags-wc-filters-section-toggle::after",
				'hover_selector' => "{$this->main_css_element} .ags-wc-filters-section-title.ags-wc-filters-section-toggle:hover::after",
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Radio buttons
		if ( 'on' === $this->props['filter_radio_style_enable'] ) {
			$css_prop = array(
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-radio-button-list li label",
					'declaration' => 'display : inline-flex; flex-wrap : wrap; align-items : center; padding-left : 24px !important; min-height : 18px; min-width : 18px;',
				),
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-radio-button-list li label:before, {$this->main_css_element} .ags-wc-filters-radio-button-list li label:after",
					'declaration' => 'content : "";  position : absolute; top : 50%; left : 0;  -webkit-transform : translateY(-50%); transform : translateY(-50%); width : 18px; height : 18px; border-radius : 50%;',
				),
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-radio-button-list li input[type=radio]",
					'declaration' => 'padding : 0;  margin  : 0; height : 0; width : 0;display : none; position : absolute; -webkit-appearance : none;',
				),
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-radio-button-list li label:after",
					'declaration' => 'display : none;',
				),
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-radio-button-list li input[type=radio]:checked ~ label:after, {$this->main_css_element} .ags-wc-filters-radio-button-list li label:before",
					'declaration' => 'display : block;',
				)
			);

			$css_props = array_merge($css_props, $css_prop);

			if ( '' !== $props['radio_background_color'] ) {
				self::set_style_esc(
					$render_slug,
					array(
						'selector'    => "{$this->main_css_element} .ags-wc-filters-radio-button-list li label:before",
						'declaration' => sprintf('background-color:%s;', esc_attr($props['radio_background_color'])),
					)
				);
			}
			if ( '' !== $props['radio_checked_background_color'] ) {
				self::set_style_esc(
					$render_slug,
					array(
						'selector'    => "{$this->main_css_element} .ags-wc-filters-radio-button-list li label:after",
						'declaration' => sprintf('box-shadow : inset 0 0 0 4px %s;', esc_attr($props['radio_checked_background_color'])),
					)
				);
			}
		}

		// Radio buttons list item background
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_radio_list_item_bg_color',
				'selector'       => "{$this->main_css_element} .ags-wc-filters-radio-button-list li",
				'hover_selector' => "{$this->main_css_element} .ags-wc-filters-radio-button-list li:hover",
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Radio buttons list item text color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_radio_list_item_color',
				'selector'       => "{$this->main_css_element} .ags-wc-filters-radio-button-list li",
				'hover_selector' => "{$this->main_css_element} .ags-wc-filters-radio-button-list li:hover",
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Checkboxes
		if ( 'on' === $this->props['filter_checkbox_style_enable'] ) {
			$css_prop = array(
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-checkbox-list li label",
					'declaration' => 'display : inline-flex; flex-wrap : wrap; align-items : center; padding-left : 24px !important; min-height : 18px; min-width : 18px;',
				),
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-checkbox-list li label:before, {$this->main_css_element} .ags-wc-filters-checkbox-list li label:after",
					'declaration' => 'content : "";  position : absolute; top : 50%; left : 0; -webkit-transform : translateY(-50%); transform : translateY(-50%); width : 18px; height : 18px; display : block; -webkit-appearance : none;',
				),
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-checkbox-list li input[type=checkbox]",
					'declaration' => 'padding : 0; margin : 0; height : 0; width : 0;display : none; position : absolute; -webkit-appearance : none;',
				),
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-checkbox-list li input:checked + label:after",
					'declaration' => 'content : "\e803"; font-family : "Divi Shop Builder"; line-height : 18px; font-weight : normal; height : 18px; width : 18px; font-size : 19px; text-indent: -2px; text-align : center;',
				)
			);

			$css_props = array_merge($css_props, $css_prop);

			if ( '' !== $props['checkbox_background_color'] ) {
				self::set_style_esc(
					$render_slug,
					array(
						'selector'    => "{$this->main_css_element} .ags-wc-filters-checkbox-list li label:before",
						'declaration' => sprintf('background-color:%s;', esc_attr($props['checkbox_background_color'])),
					)
				);
			}

			if ( '' !== $props['checkbox_checked_color'] ) {
				self::set_style_esc(
					$render_slug,
					array(
						'selector'    => "{$this->main_css_element} .ags-wc-filters-checkbox-list li input:checked + label:after",
						'declaration' => sprintf('color :%s;', esc_attr($props['checkbox_checked_color'])),
					)
				);
			}

			if ( '' !== $props['checkbox_checked_background_color'] ) {
				self::set_style_esc(
					$render_slug,
					array(
						'selector'    => "{$this->main_css_element} .ags-wc-filters-checkbox-list li input:checked + label:before",
						'declaration' => sprintf('background-color:%s;', esc_attr($props['checkbox_checked_background_color'])),
					)
				);
			}
		}

		// Checkbox list item background
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_checkbox_list_item_bg_color',
				'selector'       => "{$this->main_css_element} .ags-wc-filters-checkbox-list li",
				'hover_selector' => "{$this->main_css_element} .ags-wc-filters-checkbox-list li:hover",
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Checkbox list item text color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_checkbox_list_item_color',
				'selector'       => "{$this->main_css_element} .ags-wc-filters-checkbox-list li",
				'hover_selector' => "{$this->main_css_element} .ags-wc-filters-checkbox-list li:hover",
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
						'selector'    => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-toggle:before, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-toggle:before",
						'declaration' => sprintf('left :%s;', esc_attr($props['filter_select_dropdown_arrow_offset'])),
					)
				);
			} elseif ( 'right' === $arrow_alignment ) {
				$css_prop_alignment = array(
					array(
						'selector'    => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-toggle:before, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-toggle:before",
						'declaration' => sprintf('right :%s;', esc_attr($props['filter_select_dropdown_arrow_offset'])),
					)
				);
			} else {
				$css_prop_alignment = array(
					array(
						'selector'    => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-toggle:before, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-toggle:before",
						'declaration' => 'right : 50%; transform : translate(50%, 0);',
					)
				);
			}

			$css_prop = array(
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-toggle, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-toggle",
					'declaration' => 'position : absolute; width : 100%; top: 0;',
				),
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-toggle:before, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-toggle:before",
					'declaration' => sprintf('content : ""; top : -%1$s; border-left : %1$s solid transparent; border-right : %1$s solid transparent; border-bottom-style : solid; border-bottom-width : %1$s; border-bottom-color : %2$s; display: block !important; position : absolute; width : 0; height : 0; z-index : 1;',
					                         $arrow_size,
					                         esc_attr($props['filter_select_dropdown_bg_color'])),
				),
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options",
					'declaration' => sprintf('margin-top:%s; overflow: visible;', $arrow_size),
				)
			);

			$css_props = array_merge($css_props, $css_prop, $css_prop_alignment);
		}

		// Select Dropdown Item background
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_select_dropdown_item_bg_color',
				'selector'       => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a,{$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a",
				'hover_selector' => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a:hover, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a:hover",
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Dropdown Item Text Color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_select_dropdown_item_color',
				'selector'       => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a",
				'hover_selector' => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a:hover, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li a:hover",
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Dropdown Item Selected Background Color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_select_dropdown_item_selected_bg_color',
				'selector'       => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a.ags-wc-filters-active, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li.ags-wc-filters-active a",
				'hover_selector' => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a.ags-wc-filters-active:hover, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li.ags-wc-filters-active a:hover",
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Dropdown Item Selected Text Color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_select_dropdown_item_selected_color',
				'selector'       => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a.ags-wc-filters-active > span, 
									{$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li.ags-wc-filters-active a",
				'hover_selector' => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a.ags-wc-filters-active:hover > span, 
									{$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options li.ags-wc-filters-active a:hover",
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Dropdown Item Selected Check Color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_select_dropdown_item_selected_check_color',
				'selector'       => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a.ags-wc-filters-active > span:after, {$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options input:checked + label:after",
				'hover_selector' => "{$this->main_css_element} .ags-wc-filters-dropdown-single .ags-wc-filters-dropdown-single-options li a.ags-wc-filters-active:hover > span:after,{$this->main_css_element} .ags-wc-filters-dropdown-multi .ags-wc-filters-dropdown-multi-options a:hover input:checked + label:after",
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
						'selector'    => "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-dropdown-toggle:before",
						'declaration' => sprintf('left :%s;', esc_attr($props['filter_search_dropdown_arrow_offset'])),
					)
				);
			} elseif ( 'right' === $search_arrow_alignment ) {
				$css_prop_alignment = array(
					array(
						'selector'    => "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-dropdown-toggle:before",
						'declaration' => sprintf('right :%s;', esc_attr($props['filter_search_dropdown_arrow_offset'])),
					)
				);
			} else {
				$css_prop_alignment = array(
					array(
						'selector'    => "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-dropdown-toggle:before",
						'declaration' => 'right : 50%; transform : translate(50%, 0);',
					)
				);
			}

			$css_prop = array(
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-dropdown-toggle",
					'declaration' => 'position : absolute; width : 100%; top: 0;',
				),
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-dropdown-toggle:before",
					'declaration' => sprintf('content : ""; top : -%1$s; border-left : %1$s solid transparent; border-right : %1$s solid transparent; border-bottom-style : solid; border-bottom-width : %1$s; border-bottom-color : %2$s; display: block !important; position : absolute; width : 0; height : 0; z-index : 1;',
					                         $search_arrow_size,
					                         esc_attr($props['filter_search_dropdown_bg_color'])),
				),
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container",
					'declaration' => sprintf('margin-top:%s; overflow: visible;', $search_arrow_size),
				)
			);

			$css_props = array_merge($css_props, $css_prop, $css_prop_alignment);
		}

		// Search Dropdown Item background
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_search_dropdown_item_bg_color',
				'selector'       => "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a",
				'hover_selector' => "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a:hover",
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Search Dropdown Item Text Color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_search_dropdown_item_color',
				'selector'       => "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a",
				'hover_selector' => "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-suggestions .ags-wc-filters-search-suggestions-container li a:hover",
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Search Icon Position
		if ( 'left' === $this->props['filter_search_icon_position'] ) {
			$css_prop = array(
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-search-container.ags-wc-filters-search-with-icon .ags-wc-filters-search-input-wrapper",
					'declaration' => 'flex-direction: row-reverse;',
				)
			);

			$css_props = array_merge($css_props, $css_prop);
		}

		// Tagcloud Tag background
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_tagcloud_tag_bg_color',
				'selector'       => "{$this->main_css_element} .ags-wc-filters-tagcloud li label",
				'hover_selector' => "{$this->main_css_element} .ags-wc-filters-tagcloud li label:hover",
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Tagcloud Tag color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_tagcloud_tag_text_color',
				'selector'       => "{$this->main_css_element} .ags-wc-filters-tagcloud li label",
				'hover_selector' => "{$this->main_css_element} .ags-wc-filters-tagcloud li label:hover",
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Tagcloud Tag Active background
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_tagcloud_tag_active_bg_color',
				'selector'       => "{$this->main_css_element} .ags-wc-filters-tagcloud li input[type=radio]:checked + label",
				'hover_selector' => "{$this->main_css_element} .ags-wc-filters-tagcloud li input[type=radio]:checked + label:hover",
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Tagcloud Tag Active color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_tagcloud_tag_active_text_color',
				'selector'       => "{$this->main_css_element} .ags-wc-filters-tagcloud li input[type=radio]:checked + label",
				'hover_selector' => "{$this->main_css_element} .ags-wc-filters-tagcloud li input[type=radio]:checked + label:hover",
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Tagcloud Tag Active border color
		$this->generate_styles(
			array(
				'base_attr_name' => 'filter_tagcloud_tag_active_border_color',
				'selector'       => "{$this->main_css_element} .ags-wc-filters-tagcloud li input[type=radio]:checked + label",
				'hover_selector' => "{$this->main_css_element} .ags-wc-filters-tagcloud li input[type=radio]:checked + label:hover",
				'css_property'   => 'border-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		// Products number background
		$this->generate_styles(
			array(
				'base_attr_name' => 'products_number_bg_color',
				'selector'       => "{$this->main_css_element} .ags-wc-filters-product-count",
				'hover_selector' => "{$this->main_css_element} .ags-wc-filters-product-count:hover",
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

		if ( ($this->props['choose_filter'] === 'attribute' || $this->props['choose_filter'] === 'category') && ($this->props['display_as_attribute'] === 'images' || $this->props['display_as_attribute'] === 'colors' || $this->props['display_as'] === 'images' ) ) {
			// Color Swatches, Images Select
			$this->generate_styles(
				array(
					'base_attr_name' => 'attribute_border_color',
					'selector'       => "{$this->main_css_element} .ags-wc-filters-images",
					'css_property'   => '--ags-wc-attr-img-border-color',
					'render_slug'    => $render_slug,
					'type'           => 'color',
				)
			);
			$this->generate_styles(
				array(
					'base_attr_name' => 'attribute_selected_accent',
					'selector'       => "{$this->main_css_element}",
					'css_property'   => '--ags-wc-attr-selected-color',
					'render_slug'    => $render_slug,
					'type'           => 'color',
					'default'        => et_builder_accent_color()
				)
			);
		}

		if ( 'above' === $this->props['attr_image_position'] ) {
			$css_prop = array(
				array(
					'selector'    => "{$this->main_css_element} .ags-wc-filters-images .ags-wc-filters-product-att-label",
					'declaration' => 'flex-basis: 100%;text-align: center;',
				)
			);

			$css_props = array_merge($css_props, $css_prop);
		}


		if ( 'left' === $this->props['attr_image_position'] ) {
			$css_prop = array(
				array(
					'selector'    => "{$this->main_css_element} img",
					'declaration' => 'margin-right: 5px;',
				)
			);

			$css_props = array_merge($css_props, $css_prop);
		}

		$this->generate_styles(
			array(
				'base_attr_name' => 'attribute_bg_accent',
				'selector'       => "{$this->main_css_element}",
				'css_property'   => '--ags-wc-attr-bg-color',
				'render_slug'    => $render_slug,
				'type'           => 'color'
			)
		);
		$this->generate_styles(
			array(
				'base_attr_name' => 'attribute_selected_bg_accent',
				'selector'       => "{$this->main_css_element}",
				'css_property'   => '--ags-wc-attr-selected-bg-color',
				'render_slug'    => $render_slug,
				'type'           => 'color',
				'default'=> '#fafafa'
			)
		);
		$this->generate_styles(
			array(
				'base_attr_name' => 'attribute_selected_text_color',
				'selector'       => "{$this->main_css_element} li input:checked + label",
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color'
			)
		);
		$this->generate_styles(
			array(
				'base_attr_name' => 'tooltip_bg_color',
				'selector'       => "{$this->main_css_element} .ags_wc_filters_tooltip",
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color'
			)
		);
		$this->generate_styles(
			array(
				'base_attr_name' => 'attr_color_products_number_color',
				'selector'       => "{$this->main_css_element} .ags-wc-filters-colors.ags-wc-filters-labels-hide label > .ags-wc-filters-product-count",
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'type'           => 'color'
			)
		);
		$this->generate_styles(
			array(
				'base_attr_name' => 'attr_color_products_number_bg_color',
				'selector'       => "{$this->main_css_element} .ags-wc-filters-colors.ags-wc-filters-labels-hide label > .ags-wc-filters-product-count",
				'css_property'   => 'background-color',
				'render_slug'    => $render_slug,
				'type'           => 'color'
			)
		);

		foreach ( $css_props as $css_prop ) {
			self::set_style_esc($render_slug, $css_prop);
		}
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
		return $this->get_filter_html($this->props);
	}

	static function get_woofilters_html($args = array()) {
		$woofilters = new self();
		foreach ( $woofilters->get_fields() as $fieldId => $field ) {
			if ( ! isset($args[ $fieldId ]) ) {
				$args[ $fieldId ] = isset($field['default']) ? $field['default'] : '';
			}
		}
		$woofilters->props = $args;

		return $woofilters->render([]);
	}



	/**
	 * Override parent method to setup conditional text shadow fields
	 * {@see parent::_set_fields_unprocessed}
	 *
	 * @param Array fields array
	 */
	protected function _set_fields_unprocessed($fields) {

		if ( ! is_array($fields) ) {
			return;
		}

		$template            = ET_Builder_Module_Helper_OptionTemplate::instance();
		$newFields           = [];

		foreach ( $fields as $field => $definition ) {
			if ( ($definition === 'text_shadow' || $definition === 'box_shadow') && $template->is_enabled() && $template->has( $definition ) ) {

				$data    = $template->get_data($field);
				$setting = end($data);

				$settingWithShowIf = self::setFieldShowIf($setting);
				$new_definition    = $settingWithShowIf ? ET_Builder_Module_Fields_Factory::get($definition === 'box_shadow' ? 'BoxShadow' : 'TextShadow')->get_fields($settingWithShowIf) : null;

				if ( $new_definition ) {
					$field      = array_keys($new_definition)[0];
					$definition = array_values($new_definition)[0];
				}

			} else {
				$definitionWithShowIf = self::setFieldShowIf($definition);
				$definition           = $definitionWithShowIf ? $definitionWithShowIf : $definition;
			}

			$newFields[ $field ] = $definition;
		}

		return parent::_set_fields_unprocessed($newFields);
	}

	public static function setFieldShowIf($field) {
		// Add condition for register form
		if ( isset($field['toggle_slug']) ) {

			if ( empty($field['show_if']) ) {
				$field['show_if'] = [];
			}

			switch ( $field['toggle_slug'] ) {
				case 'filter_title':
					$field['show_if']['display_filter_title'] = 'on';
					break;
				case 'filter_radio_list':
					$field['show_if']['display_as'] = 'radio_buttons_list';
					break;
				case 'form_field_select':
				case 'filter_select_dropdown':
					$field['show_if']['display_as'] = ['dropdown_single_select', 'dropdown_multi_select'];
					break;
				case 'color_swatches_products_number':
					$field['show_if']['display_as_attribute'] = ['colors'];
					$field['show_if']['show_number_of_products'] = ['on'];
					$field['show_if']['hide_labels'] = ['on'];
					break;
				case 'tooltip':
					$field['show_if']['choose_filter'] = ['search', 'attribute', 'category'];
					break;
				case 'form_field_search':
				case 'filter_search':
					$field['show_if']['choose_filter'] = 'search';
					break;
				case 'filter_price':
				case 'form_field_number':
					$field['show_if']['choose_filter'] = 'price';
					break;
				case 'filter_tagcloud':
					$field['show_if']['display_as'] = 'tagcloud';
					break;
				case 'filter_rating':
					$field['show_if']['choose_filter'] = 'rating';
					break;
				case 'products_number':
					$field['show_if']['show_number_of_products'] = 'on';
					break;
			}

			return $field;
		}

		return null;
	}

	// Borders fields may not support show_if when using the option template

	protected function _add_borders_fields() {
		add_filter('et_builder_option_template_is_active', [__CLASS__, '_false']);
		parent::_add_borders_fields();
		remove_filter('et_builder_option_template_is_active', [__CLASS__, '_false']);
	}


	public static function _false() {
		return false;
	}

	/*
		private function woocommerce_subcats_from_parentcat_by_ID($parent_cat_ID){

			  if(!empty($subcats)){

				  if($this->props['display_as'] == 'radio_buttons_list'){

					echo '<ul class="ags-wc-filters-category-list ags-wc-filters-radio-button-list ags-wc-filters-category-list-child">';

						  foreach ($subcats as $sc) {
							$link = get_term_link( $sc->slug, $sc->taxonomy );
							  echo '<li><input type="radio" id="ags_wc_filters_'.((int) $renderCount).'_category_'.((int) $sc->term_id).'" name="ags_wc_filters_category" value="'.((int) $sc->term_id).'" data-label="'.esc_attr($sc->name).'"><label for="ags_wc_filters_'.((int) $renderCount).'_category_'.((int) $sc->term_id).'">'.esc_html($sc->name).(($this->props['show_number_of_products'] == 'on')? '<span>&nbsp;'.((int) $sc->count).'</span>' : "").'</label>';

							  $this->woocommerce_subcats_from_parentcat_by_ID($sc->term_id);

							  echo '</li>';
						  }

					echo '</ul>';

				} elseif($this->props['display_as'] == 'dropdown_single_select'){

					echo '<ul class="ags-wc-filters-category-list ags-wc-filters-category-list-child" style="display:none">';
						foreach ($subcats as $sc) {
							  echo '<li><a data-id="'.((int) $sc->term_id).'" data-label="'.esc_attr($sc->name).'"><span>'.esc_html($sc->name).(($this->props['show_number_of_products'] == 'on')? '<span>&nbsp;'.((int) $sc->count).'</span>' : "").'</span></a>';

							  $this->woocommerce_subcats_from_parentcat_by_ID($sc->term_id);

							  echo '</li>';
						  }

					echo '</ul>';

				} elseif($this->props['display_as'] == 'dropdown_multi_select'){

					echo '<ul class="ags-wc-filters-category-list ags-wc-filters-category-list-child" style="display:none">';

						  foreach ($subcats as $sc) {
							$link = get_term_link( $sc->slug, $sc->taxonomy );
							  echo '<li><a><input type="checkbox" id="ags_wc_filters_'.((int) $renderCount).'_category_'.((int) $sc->term_id).'" value="'.((int) $sc->term_id).'" data-label="'.esc_attr($sc->name).'"><label for="ags_wc_filters_'.((int) $renderCount).'_category_'.((int) $sc->term_id).'">'.esc_html($sc->name).(($this->props['show_number_of_products'] == 'on')? '<span>&nbsp;'.((int) $sc->count).'</span>' : "").'</label></a>';

							  $this->woocommerce_subcats_from_parentcat_by_ID($sc->term_id);

							  echo '</li>';
						  }

					echo '</ul>';

				} else{

					echo '<ul class="ags-wc-filters-category-list ags-wc-filters-checkbox-list ags-wc-filters-category-list-child">';

						  foreach ($subcats as $sc) {
							$link = get_term_link( $sc->slug, $sc->taxonomy );
							  echo '<li><input type="checkbox" id="ags_wc_filters_'.((int) $renderCount).'_category_'.((int) $sc->term_id).'" value="'.((int) $sc->term_id).'" data-label="'.esc_attr($sc->name).'"><label for="ags_wc_filters_'.((int) $renderCount).'_category_'.((int) $sc->term_id).'">'.esc_html($sc->name).(($this->props['show_number_of_products'] == 'on')? '<span>&nbsp;'.((int) $sc->count).'</span>' : "").'</label>';

							  $this->woocommerce_subcats_from_parentcat_by_ID($sc->term_id);

							  echo '</li>';
						  }

					echo '</ul>';

				}
			}
		}

	*/

}

new DSWCP_WooProductsFilters_child();
