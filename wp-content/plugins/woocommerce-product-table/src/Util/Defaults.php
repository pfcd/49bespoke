<?php

namespace Barn2\Plugin\WC_Product_Table\Util;

/**
 * Manages default settings and configuration values for WooCommerce Product Tables.
 *
 * This class provides default values for table settings, design templates, and miscellaneous
 * configuration options used throughout the plugin.
 */
class Defaults {

	/**
	 * Default settings for product table configuration.
	 *
	 * @var array
	 */
	private static $table_defaults = [
		'columns'                      => 'image,name,summary,price,buy',
		'widths'                       => '',
		'auto_width'                   => true,
		'priorities'                   => '',
		'column_breakpoints'           => '',
		'responsive_control'           => 'inline',
		'responsive_display'           => 'child_row',
		'wrap'                         => true,
		'hide_header'                  => false,
		'show_footer'                  => false,
		'search_on_click'              => true,
		'filters'                      => true,
		'quantities'                   => true,
		'variations'                   => 'dropdown',
		'variation_name_format'        => 'full',
		'cart_button'                  => 'button',
		'ajax_cart'                    => true,
		'scroll_offset'                => 0,
		'description_length'           => 15,
		'links'                        => 'all',
		'lazy_load'                    => false,
		'cache'                        => false,
		'image_size'                   => '70x70',
		'lightbox'                     => true,
		'shortcodes'                   => false,
		'button_text'                  => '',
		'date_format'                  => '',
		'column_type'                  => '',
		'no_products_message'          => '',
		'no_products_filtered_message' => '',
		'paging_type'                  => 'numbers',
		'page_length'                  => 'bottom',
		'search_box'                   => true,
		'totals'                       => 'bottom',
		'pagination'                   => 'bottom',
		'reset_button'                 => false,
		'add_selected_button'          => 'top',
		'display_select_all_link'      => true,
		'user_products'                => false,
		'rows_per_page'                => 25,
		'product_limit'                => 500,
		'sort_by'                      => 'menu_order',
		'sort_order'                   => '',
		'status'                       => 'publish',
		'category'                     => '',
		'exclude_category'             => '',
		'tag'                          => '',
		'term'                         => '',
		'numeric_terms'                => false,
		'cf'                           => '',
		'year'                         => '',
		'month'                        => '',
		'day'                          => '',
		'exclude'                      => '',
		'include'                      => '',
		'search_term'                  => '',
		'stock'                        => '',
		'show_hidden_columns'          => false,
		'sticky_header'                => false,
		'custom_class'                 => '',
		'date_columns'                 => '',
	];

	/**
	 * Gets the default text for the "Add to cart" button.
	 *
	 * @return string Translated "Add to cart" text
	 */
	public static function add_selected_to_cart_default_text() {
		return __( 'Add to cart', 'woocommerce-product-table' );
	}

	/**
	 * Gets the default text template for single item selection.
	 *
	 * @return string Translated text with {total} placeholder
	 */
	public static function add_selected_to_cart_singular_placeholder_default_text() {
		return __( 'Add 1 item for {total}', 'woocommerce-product-table' );
	}

	/**
	 * Gets the default text template for multiple item selection.
	 *
	 * @return string Translated text with {items} and {total} placeholders
	 */
	public static function add_selected_to_cart_plural_placeholder_default_text() {
		return __( 'Add {items} items for {total}', 'woocommerce-product-table' );
	}

	/**
	 * Gets the default design settings.
	 *
	 * @return array Default design configuration
	 */
	public static function get_design_defaults() {
		return [ 'use_theme' => 'theme' ];
	}

	/**
	 * Gets the default design templates for different table styles.
	 *
	 * Includes templates for:
	 * - Theme
	 * - Minimal
	 * - Dark
	 * - Neutral
	 * - Rounded
	 * - Delicate
	 * - Nature
	 *
	 * Each template defines colors, borders, fonts, and other styling properties.
	 *
	 * @return array Array of design templates and their settings
	 */
	public static function get_design_defaults_for_templates() {
		return [
			'theme'    => [
				'border_outer'           => [
					'color' => '',
					'size'  => '',
				],
				'border_header'          => [
					'color' => '',
					'size'  => '',
				],
				'border_horizontal_cell' => [
					'color' => '',
					'size'  => '',
				],
				'border_vertical_cell'   => [
					'color' => '',
					'size'  => '',
				],
				'border_bottom'          => [
					'color' => '#ADADAD',
					'size'  => 1,
				],
				'header_bg'              => '#F8F8F8',
				'cell_bg'                => '#fbfbfb',
				'header_font'            => [
					'color' => '',
					'size'  => '',
				],
				'cell_font'              => [
					'color' => '',
					'size'  => '',
				],
				'hyperlink_font'         => [
					'color' => '',
					'size'  => '',
				],
				'button_font'            => [
					'color' => '',
					'size'  => '',
				],
				'disabled_button_font'   => [
					'color' => '#FFFFFF',
					'size'  => 1,
				],
				'quantity_font'          => [
					'color' => '#000000',
					'size'  => 1,
				],
				'button_bg'              => '',
				'button_bg_hover'        => '',
				'button_disabled_bg'     => '#949598',
				'button_quantity_bg'     => '#F2F2F2',
				'text_background'        => '',
				'text_font'              => '',
				'text_border'            => [
					'color' => '',
					'size'  => '',
				],
				'dropdown_background'    => '',
				'dropdown_font'          => '',
				'dropdown_border'        => [
					'color' => '',
					'size'  => '',
				],
				'checkboxes_border'      => '',
				'cell_backgrounds'       => 'alternate-rows',
				'corner_style'           => 'theme-default',
			],
			'minimal'  => [
				'border_outer'           => [
					'color' => '',
					'size'  => '',
				],
				'border_header'          => [
					'color' => '#D9D9D9',
					'size'  => 1,
				],
				'border_horizontal_cell' => [
					'color' => '',
					'size'  => '',
				],
				'border_vertical_cell'   => [
					'color' => '',
					'size'  => '',
				],
				'border_bottom'          => [
					'color' => '#D9D9D9',
					'size'  => 1,
				],
				'header_bg'              => '#FFFFFF',
				'cell_bg'                => '#FFFFFF',
				'header_font'            => [
					'color' => '#424242',
					'size'  => 1,
				],
				'cell_font'              => [
					'color' => '#424242',
					'size'  => 1,
				],
				'hyperlink_font'         => [
					'color' => '#424242',
					'size'  => 1,
				],
				'button_font'            => [
					'color' => '#FFFFFF',
					'size'  => 1,
				],
				'disabled_button_font'   => [
					'color' => '#FFFFFF',
					'size'  => 1,
				],
				'quantity_font'          => [
					'color' => '#424242',
					'size'  => 1,
				],
				'button_bg'              => '#424242',
				'button_bg_hover'        => '#000000',
				'button_disabled_bg'     => '#D9D9D9',
				'button_quantity_bg'     => '#F2F2F2',
				'text_background'        => '',
				'text_font'              => '',
				'text_border'            => [
					'color' => '',
					'size'  => '',
				],
				'dropdown_background'    => '',
				'dropdown_font'          => '',
				'dropdown_border'        => [
					'color' => '',
					'size'  => '',
				],
				'checkboxes_border'      => '#424242',
				'cell_backgrounds'       => 'no-alternate',
				'corner_style'           => 'theme-default',
			],
			'dark'     => [
				'border_outer'           => [
					'color' => '',
					'size'  => '',
				],
				'border_header'          => [
					'color' => '',
					'size'  => '',
				],
				'border_horizontal_cell' => [
					'color' => '',
					'size'  => '',
				],
				'border_vertical_cell'   => [
					'color' => '',
					'size'  => '',
				],
				'border_bottom'          => [
					'color' => '',
					'size'  => '',
				],
				'header_bg'              => '#252525',
				'cell_bg'                => '#252525',
				'header_font'            => [
					'color' => '#FFFFFF',
					'size'  => 1,
				],
				'cell_font'              => [
					'color' => '#FFFFFF',
					'size'  => 1,
				],
				'hyperlink_font'         => [
					'color' => '#FFFFFF',
					'size'  => 1,
				],
				'button_font'            => [
					'color' => '#FFFFFF',
					'size'  => 1,
				],
				'disabled_button_font'   => [
					'color' => '#8c8c8c',
					'size'  => 1,
				],
				'quantity_font'          => [
					'color' => '#FFFFFF',
					'size'  => 1,
				],
				'button_bg'              => '#575757',
				'button_bg_hover'        => '#CCCCCC',
				'button_disabled_bg'     => '#343434',
				'button_quantity_bg'     => '#575757',
				'text_background'        => '#575757',
				'text_font'              => '#FFFFFF',
				'text_border'            => [
					'color' => '',
					'size'  => '',
				],
				'dropdown_background'    => '#000000',
				'dropdown_font'          => '#FFFFFF',
				'dropdown_border'        => [
					'color' => '#FFFFFF',
					'size'  => 1,
				],
				'checkboxes_border'      => '#424242',
				'cell_backgrounds'       => 'alternate-rows',
				'corner_style'           => 'theme-default',
			],
			'neutral'  => [
				'border_outer'           => [
					'color' => '',
					'size'  => '',
				],
				'border_header'          => [
					'color' => '',
					'size'  => '',
				],
				'border_horizontal_cell' => [
					'color' => '#E6D6C8',
					'size'  => 1,
				],
				'border_vertical_cell'   => [
					'color' => '',
					'size'  => '',
				],
				'border_bottom'          => [
					'color' => '#E6D6C8',
					'size'  => 1,
				],
				'header_bg'              => '#E6D6C8',
				'cell_bg'                => '#F9F7F4',
				'header_font'            => [
					'color' => '#4E3E2C',
					'size'  => 1,
				],
				'cell_font'              => [
					'color' => '#4E3E2C',
					'size'  => 1,
				],
				'hyperlink_font'         => [
					'color' => '#4E3E2C',
					'size'  => 1,
				],
				'button_font'            => [
					'color' => '#4E3E2C',
					'size'  => 1,
				],
				'disabled_button_font'   => [
					'color' => '#b2a9a0',
					'size'  => 1,
				],
				'quantity_font'          => [
					'color' => '#4E3E2C',
					'size'  => 1,
				],
				'button_bg'              => '#E6D6C8',
				'button_bg_hover'        => '#CDC1B5',
				'button_disabled_bg'     => '#f5efe9',
				'button_quantity_bg'     => '#E6D6C8',
				'text_background'        => '',
				'text_font'              => '',
				'text_border'            => [
					'color' => '',
					'size'  => '',
				],
				'dropdown_background'    => '',
				'dropdown_font'          => '',
				'dropdown_border'        => [
					'color' => '',
					'size'  => '',
				],
				'checkboxes_border'      => '#4E3E2C',
				'cell_backgrounds'       => 'alternate-columns',
				'corner_style'           => 'fully-rounded',
			],
			'rounded'  => [
				'border_outer'           => [
					'color' => '',
					'size'  => '',
				],
				'border_header'          => [
					'color' => '',
					'size'  => '',
				],
				'border_horizontal_cell' => [
					'color' => '',
					'size'  => '',
				],
				'border_vertical_cell'   => [
					'color' => '',
					'size'  => '',
				],
				'border_bottom'          => [
					'color' => '#134BCD',
					'size'  => 1,
				],
				'header_bg'              => '#134BCD',
				'cell_bg'                => '#F4F7FD',
				'header_font'            => [
					'color' => '#FFFFFF',
					'size'  => 1,
				],
				'cell_font'              => [
					'color' => '#134BCD',
					'size'  => 1,
				],
				'hyperlink_font'         => [
					'color' => '#134BCD',
					'size'  => 1,
				],
				'button_font'            => [
					'color' => '#FFFFFF',
					'size'  => 1,
				],
				'disabled_button_font'   => [
					'color' => '#FFFFFF',
					'size'  => 1,
				],
				'quantity_font'          => [
					'color' => '#134BCD',
					'size'  => 1,
				],
				'button_bg'              => '#134BCD',
				'button_bg_hover'        => '#15388B',
				'button_disabled_bg'     => '#BBC9ED',
				'button_quantity_bg'     => '#F2F2F2',
				'text_background'        => '',
				'text_font'              => '',
				'text_border'            => [
					'color' => '',
					'size'  => '',
				],
				'dropdown_background'    => '',
				'dropdown_font'          => '#134BCD',
				'dropdown_border'        => [
					'color' => '#134BCD',
					'size'  => 1,
				],
				'checkboxes_border'      => '#124bcd',
				'cell_backgrounds'       => 'alternate-rows',
				'corner_style'           => 'fully-rounded',
			],
			'delicate' => [
				'border_outer'           => [
					'color' => '#F3ECFF',
					'size'  => 1,
				],
				'border_header'          => [
					'color' => '',
					'size'  => '',
				],
				'border_horizontal_cell' => [
					'color' => '',
					'size'  => '',
				],
				'border_vertical_cell'   => [
					'color' => '#F3ECFF',
					'size'  => 1,
				],
				'border_bottom'          => [
					'color' => '',
					'size'  => '',
				],
				'header_bg'              => '#F3ECFF',
				'cell_bg'                => '',
				'header_font'            => [
					'color' => '#42478F',
					'size'  => 1,
				],
				'cell_font'              => [
					'color' => '#42478F',
					'size'  => 1,
				],
				'hyperlink_font'         => [
					'color' => '#42478F',
					'size'  => 1,
				],
				'button_font'            => [
					'color' => '#42478F',
					'size'  => 1,
				],
				'disabled_button_font'   => [
					'color' => '#BDBFD2',
					'size'  => 1,
				],
				'quantity_font'          => [
					'color' => '#42478F',
					'size'  => 1,
				],
				'button_bg'              => '#FEEBE6',
				'button_bg_hover'        => '#F3ECFF',
				'button_disabled_bg'     => '#F2F2F2',
				'button_quantity_bg'     => '#F2F2F2',
				'text_background'        => '',
				'text_font'              => '',
				'text_border'            => [
					'color' => '',
					'size'  => '',
				],
				'dropdown_background'    => '',
				'dropdown_font'          => '#42478F',
				'dropdown_border'        => [
					'color' => '#42478F',
					'size'  => '1',
				],
				'checkboxes_border'      => '#42478F',
				'cell_backgrounds'       => 'no-alternate',
				'corner_style'           => 'rounded-corners',
			],
			'nature'   => [
				'border_outer'           => [
					'color' => '#1C4955',
					'size'  => 1,
				],
				'border_header'          => [
					'color' => '',
					'size'  => '',
				],
				'border_horizontal_cell' => [
					'color' => '',
					'size'  => '',
				],
				'border_vertical_cell'   => [
					'color' => '#1C4955',
					'size'  => 1,
				],
				'border_bottom'          => [
					'color' => '',
					'size'  => '',
				],
				'header_bg'              => '#3B5E59',
				'cell_bg'                => '',
				'header_font'            => [
					'color' => '#FFFFFF',
					'size'  => 1,
				],
				'cell_font'              => [
					'color' => '#1C4955',
					'size'  => 1,
				],
				'hyperlink_font'         => [
					'color' => '#1C4955',
					'size'  => 1,
				],
				'button_font'            => [
					'color' => '#1C4955',
					'size'  => 1,
				],
				'disabled_button_font'   => [
					'color' => '#9BA9AE',
					'size'  => 1,
				],
				'quantity_font'          => [
					'color' => '#1C4955',
					'size'  => 1,
				],
				'button_bg'              => '#D2EAEB',
				'button_bg_hover'        => '#C7D9DB',
				'button_disabled_bg'     => '#EBEBEB',
				'button_quantity_bg'     => '#EBEBEB',
				'text_background'        => '',
				'text_font'              => '',
				'text_border'            => [
					'color' => '',
					'size'  => '',
				],
				'dropdown_background'    => '',
				'dropdown_font'          => '',
				'dropdown_border'        => [
					'color' => '',
					'size'  => '',
				],
				'checkboxes_border'      => '#1C4955',
				'cell_backgrounds'       => 'no-alternate',
				'corner_style'           => 'rounded-corners',
			],
		];
	}

	/**
	 * Gets default values for miscellaneous plugin settings.
	 *
	 * Includes settings for:
	 * - Cache expiration
	 * - Add to cart button text
	 * - Quick view functionality
	 * - WooCommerce add-ons layout
	 * - Shop page overrides
	 * - Archive settings
	 *
	 * @return array Miscellaneous default settings
	 */
	public static function get_misc_defaults() {
		return [
			'cache_expiry'                           => 6,
			'add_selected_text'                      => self::add_selected_to_cart_default_text(),
			'add_selected_text_singular_placeholder' => self::add_selected_to_cart_singular_placeholder_default_text(),
			'add_selected_text_plural_placeholder'   => self::add_selected_to_cart_plural_placeholder_default_text(),
			'quick_view_links'                       => false,
			'addons_layout'                          => 'block',
			'addons_option_layout'                   => 'block',
			'shop_override'                          => false,
			'search_override'                        => false,
			'archive_override'                       => false,
			'product_tag_override'                   => false,
			'attribute_override'                     => false,
			'include_hidden'                         => false,
			'sticky_header'                          => false,
			'custom_class'                           => '',
		];
	}

	/**
	 * Gets the default table settings with optional filter modifications.
	 *
	 * @return array Filtered table default settings
	 */
	public static function get_table_defaults() {
		/**
		 * Filters the default table arguments.
		 *
		 * @param array $table_defaults The default table arguments. See $table_defaults property for list of defaults.
		 * @return array The filtered default arguments.
		 */
		return apply_filters( 'wc_product_table_default_args', self::$table_defaults );
	}
}
