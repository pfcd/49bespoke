<?php


namespace Barn2\Plugin\WC_Product_Table\Admin\Settings_Tab;

use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Admin\Settings_API_Helper;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Plugin\Licensed_Plugin;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Registerable;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Conditional;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Admin\Plugin_Promo;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Util as Lib_Util;
use Barn2\Plugin\WC_Product_Table\Admin\Settings_List;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Service\Standard_Service;
use Barn2\Plugin\WC_Product_Table\Util\Defaults;
use Barn2\Plugin\WC_Product_Table\Util\Settings as Settings_Util;
use Barn2\Plugin\WC_Product_Table\Util\Util;

/**
 * The General settings tab.
 *
 * @package   Barn2\woocommerce-product-table
 * @author    Barn2 Plugins <info@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Settings implements Registerable, Conditional, Standard_Service {

	const TAB_ID       = 'settings';
	const OPTION_GROUP = 'wc_product_table_settings';
	const MENU_SLUG    = 'wpt_settings';

	private $license_setting;
	private $title;
	private $id;
	private $plugin;
	private $services;

	/**
	 * Get things started.
	 *
	 * @param Licensed_Plugin $plugin
	 */
	public function __construct( Licensed_Plugin $plugin ) {
		$this->plugin          = $plugin;
		$this->license_setting = $plugin->get_license_setting();
		$this->id              = 'settings';

		$this->services = [
			new Plugin_Promo( $this->plugin ),
		];

		add_action( 'admin_init', [ $this, 'setup' ] );
	}

	/**
	 * Temporary setup method to initialize the title.
	 *
	 * @todo Refactor this into a more robust initialization system in future versions
	 * @return void
	 */
	public function setup() {
		$this->title = __( 'Settings', 'woocommerce-product-table' );
	}

	public function is_required() {
		return isset( $_GET['tab'] ) && $_GET['tab'] === 'settings' || strpos( $_SERVER['REQUEST_URI'], '/options.php' ) !== false;
	}

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public function register() {
		add_action( 'admin_enqueue_scripts', [ $this, 'register_scripts' ] );
		add_action( 'admin_init', [ $this, 'register_settings' ] );
		add_action( 'admin_init', [ $this, 'add_settings_sections' ], 11 );
		Lib_Util::register_services( $this->services );
	}

	public function register_scripts() {
		wp_register_style( 'barn2-wc-settings', $this->plugin->get_dir_url() . 'dependencies/barn2/barn2-lib/build/css/wc-settings-styles.css', [], $this->plugin->get_version() );
		wp_register_script( 'barn2-wc-settings', $this->plugin->get_dir_url() . 'dependencies/barn2/barn2-lib/build/js/admin/wc-settings.js', [ 'jquery' ], $this->plugin->get_version() );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_style( 'barn2-wc-settings' );
		wp_enqueue_script( 'barn2-wc-settings' );
	}

	/**
	 * Register the settings.
	 */
	public function register_settings() {
		register_setting(
			self::OPTION_GROUP,
			Settings_Util::OPTION_MISC,
			[
				'type'              => 'string',
				'description'       => 'WooCommerce Product Table miscellaneous settings',
				'sanitize_callback' => [ $this, 'sanitize_misc_settings' ],
			]
		);

		register_setting(
			self::OPTION_GROUP,
			Settings_Util::OPTION_TABLE_DEFAULTS,
			[
				'type'              => 'string',
				'description'       => 'WooCommerce Product Table defaults settings',
				'sanitize_callback' => [ $this, 'sanitize_shortcode_settings' ],
			]
		);
	}

	public function add_settings_sections() {

		// Licence key.
		Settings_API_Helper::add_settings_section(
			'product_table_settings_license',
			self::MENU_SLUG,
			'',
			'',
			[
				$this->plugin->get_license_setting()->get_license_key_setting(),
				$this->plugin->get_license_setting()->get_license_override_setting(),
			]
		);

		// Add to cart.
		Settings_API_Helper::add_settings_section(
			'product_table_settings_cart',
			self::MENU_SLUG,
			__( 'Add to cart', 'woocommerce-product-table' ),
			// [ $this, 'display_add_to_cart_description' ],
			'',
			$this->get_add_to_cart_settings()
		);

		// Table content.
		Settings_API_Helper::add_settings_section(
			'product_table_settings_content',
			self::MENU_SLUG,
			__( 'Table content', 'woocommerce-product-table' ),
			'',
			$this->get_table_content_settings()
		);

		// Search and filter.
		Settings_API_Helper::add_settings_section(
			'product_table_settings_search',
			self::MENU_SLUG,
			__( 'Product search', 'woocommerce-product-table' ),
			'',
			$this->get_search_and_filter_settings()
		);

		// Pagination.
		Settings_API_Helper::add_settings_section(
			'product_table_settings_pagination',
			self::MENU_SLUG,
			__( 'Pagination', 'woocommerce-product-table' ),
			'',
			$this->get_pagination_settings()
		);

		// Responsive options.
		Settings_API_Helper::add_settings_section(
			'product_table_settings_responsive_options',
			self::MENU_SLUG,
			__( 'Responsive options', 'woocommerce-product-table' ),
			'',
			$this->get_responsive_options_settings()
		);

		// Advanced.
		Settings_API_Helper::add_settings_section(
			'product_table_settings_advanced',
			self::MENU_SLUG,
			__( 'Advanced', 'woocommerce-product-table' ),
			'',
			$this->get_advanced_settings()
		);

		// Uninstall section.
		Settings_API_Helper::add_settings_section(
			'wcf_uninstall',
			self::MENU_SLUG,
			esc_html__( 'Uninstalling WooCommerce Product Table', 'woocommerce-product-table' ),
			null,
			$this->get_uninstall_settings()
		);
	}

	/**
	 * Table content.
	 */
	public function display_table_content_description() {
		echo '<p>' . sprintf(
		// translators: 1: help link open tag, 2: help link close tag.
			__( 'You can override any of the settings below for individual tables by %1$sadding options%2$s to the shortcode or block.', 'woocommerce-product-table' ),
			Lib_Util::format_barn2_link_open( 'kb/product-table-options', true ),
			'</a>'
		) . '</p>';
	}

	private function get_table_content_settings() {
		$defaults = Defaults::get_table_defaults();
		$misc     = Defaults::get_misc_defaults();

		return [
			[
				'title'             => __( 'Description length', 'woocommerce-product-table' ),
				'type'              => 'number',
				'id'                => Settings_Util::OPTION_TABLE_DEFAULTS . '[description_length]',
				'suffix'            => __( 'words', 'woocommerce-product-table' ),
				'desc_tip'          => __( 'Enter -1 to show the full product description including formatting.', 'woocommerce-product-table' ),
				'default'           => $defaults['description_length'],
				'class'             => 'with-suffix',
				'custom_attributes' => [
					'min'   => -1,
					'style' => 'width:75px',
				],
			],
			[
				'title'   => __( 'Show hidden products', 'woocommerce-product-table' ),
				'type'    => 'checkbox',
				'id'      => Settings_Util::OPTION_MISC . '[include_hidden]',
				'label'   => __( 'Include hidden products in the table', 'woocommerce-product-table' ),
				'default' => $misc['include_hidden'],
			],
			[
				'title'    => __( 'Show sticky header', 'woocommerce-product-table' ),
				'type'     => 'checkbox',
				'id'       => Settings_Util::OPTION_TABLE_DEFAULTS . '[sticky_header]',
				'label'    => __( 'Show sticky header in the table', 'woocommerce-product-table' ),
				'default'  => isset( $defaults['sticky_header'] ) ? $defaults['sticky_header'] : false,
				'desc_tip' => __( 'If the sticky header option in your theme is conflicting with the sticky header in the product table, then use the Scroll Offset option to fix this.', 'woocommerce-product-table' ),
			],
			[
				'title'   => __( 'Hide table header', 'woocommerce-product-table' ),
				'type'    => 'checkbox',
				'id'      => Settings_Util::OPTION_TABLE_DEFAULTS . '[hide_header]',
				'label'   => __( 'Hide column headings at the top of the table', 'woocommerce-product-table' ),
				'default' => $defaults['hide_header'],
			],
			[
				'title'   => __( 'Show table footer', 'woocommerce-product-table' ),
				'type'    => 'checkbox',
				'id'      => Settings_Util::OPTION_TABLE_DEFAULTS . '[show_footer]',
				'label'   => __( 'Show column headings at the bottom of the table as well as the top', 'woocommerce-product-table' ),
				'default' => $defaults['show_footer'],
			],
			[
				'title'    => __( 'Scroll offset', 'woocommerce-product-table' ),
				'type'     => 'number',
				'id'       => Settings_Util::OPTION_TABLE_DEFAULTS . '[scroll_offset]',
				'default'  => $defaults['scroll_offset'],
				'desc_tip' => __( 'Change the height that the page scrolls to when you move between pages in the product table.', 'woocommerce-product-table' ),
			],
		];
	}

	private function get_search_and_filter_settings() {
		$defaults = Defaults::get_table_defaults();

		return [
			[
				'title'   => __( 'Search box', 'woocommerce-product-table' ),
				'type'    => 'checkbox',
				'id'      => Settings_Util::OPTION_TABLE_DEFAULTS . '[search_box]',
				'label'   => __( 'Display a search box above your product tables', 'woocommerce-product-table' ),
				'default' => $defaults['search_box'],
			],
			[
				'title'   => __( 'Number of products found', 'woocommerce-product-table' ),
				'type'    => 'select',
				'id'      => Settings_Util::OPTION_TABLE_DEFAULTS . '[totals]',
				'options' => [
					'top'    => __( 'Above table', 'woocommerce-product-table' ),
					'bottom' => __( 'Below table', 'woocommerce-product-table' ),
					'both'   => __( 'Above and below table', 'woocommerce-product-table' ),
					'false'  => __( 'Hidden', 'woocommerce-product-table' ),
				],
				'default' => $defaults['totals'],
				'class'   => 'wc-enhanced-select',
			],
			[
				'type' => 'sectionend',
				'id'   => 'product_table_settings_search',
			],
		];
	}

	private function get_add_to_cart_settings() {
		$defaults = Defaults::get_table_defaults();

		return [
			[
				'title'   => __( 'Add to cart button', 'woocommerce-product-table' ),
				'type'    => 'text',
				'id'      => Settings_Util::OPTION_MISC . '[add_to_cart_text]',
				'default' => Defaults::add_selected_to_cart_default_text(),
			],
			[
				'title'   => __( 'Multi add to cart button', 'woocommerce-product-table' ),
				'type'    => 'text',
				'id'      => Settings_Util::OPTION_MISC . '[add_selected_text]',
				'default' => Defaults::add_selected_to_cart_default_text(),
			],
			[
				'title'        => __( 'Multi add to cart button - products selected', 'woocommerce-product-table' ),
				'type'         => 'double_text',
				'id'           => Settings_Util::OPTION_MISC . '[add_selected_text_placeholder]',
				'desc'         => __( 'Use the placeholder {items} for the number of selected items, {total} for the selected total, and {total_rounded} for the selected total rounded up or down.', 'woocommerce-product-table' ),
				'class'        => 'regular-text half-width',
				'input_fields' => [
					[
						'title'   => __( 'Singular Text', 'woocommerce-product-table' ),
						'id'      => Settings_Util::OPTION_MISC . '[add_selected_text_singular_placeholder]',
						'type'    => 'text',
						'default' => Defaults::add_selected_to_cart_singular_placeholder_default_text(),
					],
					[
						'title'   => __( 'Plural Text', 'woocommerce-product-table' ),
						'id'      => Settings_Util::OPTION_MISC . '[add_selected_text_plural_placeholder]',
						'type'    => 'text',
						'default' => Defaults::add_selected_to_cart_plural_placeholder_default_text(),
					],
				],
			],
			[
				'title'   => __( 'Multi add to cart location', 'woocommerce-product-table' ),
				'type'    => 'select',
				'id'      => Settings_Util::OPTION_TABLE_DEFAULTS . '[add_selected_button]',
				'options' => [
					'top'    => __( 'Above table', 'woocommerce-product-table' ),
					'bottom' => __( 'Below table', 'woocommerce-product-table' ),
					'both'   => __( 'Above and below table', 'woocommerce-product-table' ),
				],
				'desc'    => __( 'The location of the cart button when ordering multiple products at once.', 'woocommerce-product-table' ),
				'default' => $defaults['add_selected_button'],
				'class'   => 'wc-enhanced-select',
			],
			[
				'title'   => __( 'Select all', 'woocommerce-product-table' ),
				'type'    => 'checkbox',
				'id'      => Settings_Util::OPTION_TABLE_DEFAULTS . '[display_select_all_link]',
				'label'   => __( 'Display a link to select all products in the table header', 'woocommerce-product-table' ),
				'default' => $defaults['display_select_all_link'],
				'class'   => 'wc-enhanced-select',
			],
			[
				'type' => 'sectionend',
				'id'   => 'product_table_settings_cart',
			],
		];
	}


	private function get_pagination_settings() {
		$defaults = Defaults::get_table_defaults();

		return [
			[
				'title'             => __( 'Products per page', 'woocommerce-product-table' ),
				'type'              => 'number',
				'id'                => Settings_Util::OPTION_TABLE_DEFAULTS . '[rows_per_page]',
				'desc'              => __( 'The number of products per page of results.', 'woocommerce-product-table' ),
				'desc_tip'          => __( 'Enter -1 to show all products on a single page.', 'woocommerce-product-table' ),
				'default'           => $defaults['rows_per_page'],
				'custom_attributes' => [
					'min'   => -1,
					'style' => 'width:75px',
				],
			],
			[
				'title'   => __( 'Products per page control', 'woocommerce-product-table' ),
				'type'    => 'select',
				'id'      => Settings_Util::OPTION_TABLE_DEFAULTS . '[page_length]',
				'desc'    => __( 'Allow customers to adjust the number of products per page.', 'woocommerce-product-table' ),
				'options' => [
					'top'    => __( 'Above table', 'woocommerce-product-table' ),
					'bottom' => __( 'Below table', 'woocommerce-product-table' ),
					'both'   => __( 'Above and below table', 'woocommerce-product-table' ),
					'false'  => __( 'Hidden', 'woocommerce-product-table' ),
				],
				'default' => $defaults['page_length'],
				'class'   => 'wc-enhanced-select',
			],
			[
				'title'   => __( 'Pagination buttons', 'woocommerce-product-table' ),
				'type'    => 'select',
				'id'      => Settings_Util::OPTION_TABLE_DEFAULTS . '[pagination]',
				'options' => [
					'top'    => __( 'Above table', 'woocommerce-product-table' ),
					'bottom' => __( 'Below table', 'woocommerce-product-table' ),
					'both'   => __( 'Above and below table', 'woocommerce-product-table' ),
					'false'  => __( 'Hidden', 'woocommerce-product-table' ),
				],
				'default' => $defaults['pagination'],
				'class'   => 'wc-enhanced-select',
			],
			[
				'title'   => __( 'Pagination type', 'woocommerce-product-table' ),
				'type'    => 'select',
				'id'      => Settings_Util::OPTION_TABLE_DEFAULTS . '[paging_type]',
				'options' => [
					'numbers'        => __( 'Page numbers', 'woocommerce-product-table' ),
					'simple'         => __( 'Prev - Next', 'woocommerce-product-table' ),
					'simple_numbers' => __( 'Prev - Page numbers - Next', 'woocommerce-product-table' ),
					'full'           => __( 'First - Prev - Next - Last', 'woocommerce-product-table' ),
					'full_numbers'   => __( 'First - Prev - Page numbers - Next - Last', 'woocommerce-product-table' ),
				],
				'default' => $defaults['paging_type'],
				'class'   => 'wc-enhanced-select',
			],
			[
				'type' => 'sectionend',
				'id'   => 'product_table_settings_pagination',
			],
		];
	}

	/**
	 * Responsive options.
	 */
	private function get_responsive_options_settings() {
		$defaults = Defaults::get_table_defaults();
		return [
			[
				'title'   => __( 'Responsive display', 'woocommerce-product-table' ),
				'type'    => 'radio',
				'id'      => Settings_Util::OPTION_TABLE_DEFAULTS . '[responsive_display]',
				'options' => [
					'child_row'         => __( 'Click a plus icon to display a child row', 'woocommerce-product-table' ),
					'child_row_visible' => __( 'Expand all child rows automatically', 'woocommerce-product-table' ),
					'modal'             => __( 'Click a plus icon to open a modal window', 'woocommerce-product-table' ),
				],
				'default' => $defaults['responsive_display'],
				'desc'    => __( 'How extra data is displayed when there are too many columns to fit in the table.', 'woocommerce-product-table' ),
			],
			[
				'type' => 'sectionend',
				'id'   => 'product_table_settings_responsive_options',
			],
		];
	}

	/**
	 * Advanced settings.
	 */
	private function get_advanced_settings() {
		$defaults = Defaults::get_table_defaults();

		// Filter before advanced settings.
		$plugin_settings = apply_filters( 'wc_product_table_plugin_settings_before_advanced', [] );

		$plugin_settings = array_merge(
			$plugin_settings,
			[
				[
					'title'   => __( 'AJAX', 'woocommerce-product-table' ),
					'type'    => 'checkbox',
					'id'      => Settings_Util::OPTION_TABLE_DEFAULTS . '[ajax_cart]',
					'label'   => __( 'Use AJAX when adding to the cart', 'woocommerce-product-table' ),
					'default' => $defaults['ajax_cart'],
				],
				[
					'title'   => __( 'Shortcodes', 'woocommerce-product-table' ),
					'type'    => 'checkbox',
					'id'      => Settings_Util::OPTION_TABLE_DEFAULTS . '[shortcodes]',
					'label'   => __( 'Show shortcodes, HTML and other formatting in the table', 'woocommerce-product-table' ),
					'default' => $defaults['shortcodes'],
				],
				[
					'title'             => __( 'Caching', 'woocommerce-product-table' ),
					'type'              => 'checkbox',
					'id'                => Settings_Util::OPTION_TABLE_DEFAULTS . '[cache]',
					'label'             => __( 'Cache table contents to improve load times', 'woocommerce-product-table' ),
					'default'           => $defaults['cache'],
					'class'             => 'toggle-parent cache-toggle',
					'custom_attributes' => [
						'data-child-class' => 'toggle-cache',
					],
				],
				[
					'title'             => __( 'Cache expiration', 'woocommerce-product-table' ),
					'type'              => 'number',
					'id'                => Settings_Util::OPTION_MISC . '[cache_expiry]',
					'suffix'            => __( 'hours', 'woocommerce-product-table' ),
					'desc'              => __( 'Your data will be refreshed after this length of time.', 'woocommerce-product-table' ),
					'default'           => 6,
					'class'             => 'toggle-cache with-suffix',
					'custom_attributes' => [
						'min'   => 1,
						'max'   => 9999,
						'style' => 'width:75px;',
					],
				],
				[
					'title'   => __( 'Date format', 'woocommerce-product-table' ),
					'type'    => 'text',
					'id'      => Settings_Util::OPTION_TABLE_DEFAULTS . '[date_format]',
					'default' => $defaults['date_format'],
				],
				[
					'title'   => __( 'No products message', 'woocommerce-product-table' ),
					'type'    => 'text',
					'id'      => Settings_Util::OPTION_TABLE_DEFAULTS . '[no_products_message]',
					'default' => $defaults['no_products_message'],
				],
				[
					'title'   => __( 'No products filtered message', 'woocommerce-product-table' ),
					'type'    => 'text',
					'id'      => Settings_Util::OPTION_TABLE_DEFAULTS . '[no_products_filtered_message]',
					'default' => $defaults['no_products_filtered_message'],
				],
				[
					'type' => 'sectionend',
					'id'   => 'product_table_settings_advanced',
				],

			]
		);

		return $plugin_settings;
	}

	public function get_uninstall_settings() {
		return [
			[
				'title' => esc_html__( 'Delete data on uninstall', 'woocommerce-product-table' ),
				'type'  => 'checkbox',
				'id'    => Settings_Util::OPTION_TABLE_DEFAULTS . '[delete_data]',
				'label' => esc_html__( 'Permanently delete all WooCommerce Product Table settings and data when uninstalling the plugin', 'woocommerce-product-table' ),
			],
		];
	}

	/**
	 * Sanitize the shortcode setting depending on the setting tab.
	 *
	 * @param  mixed $args
	 * @return array
	 */
	public function sanitize_shortcode_settings( $args ) {

		// Checkboxes
		foreach ( [ 'lazy_load', 'search_box', 'reset_button', 'display_select_all_link', 'search_on_click', 'quantities', 'ajax_cart', 'shortcodes', 'lightbox', 'cache', 'include_hidden' ] as $arg ) {
			if ( ! isset( $args[ $arg ] ) ) {
				$args[ $arg ] = false;
			}
			$args[ $arg ] = filter_var( $args[ $arg ], FILTER_VALIDATE_BOOLEAN );
		}

		return $args;
	}

	/**
	 * Sanitize the misc setting.
	 *
	 * @param  mixed $args
	 * @return array
	 */
	public function sanitize_misc_settings( $args ) {

		// Checkboxes
		foreach ( [ 'include_hidden' ] as $arg ) {
			if ( ! isset( $args[ $arg ] ) ) {
				$args[ $arg ] = false;
			}
			$args[ $arg ] = filter_var( $args[ $arg ], FILTER_VALIDATE_BOOLEAN );
		}

		return $args;
	}

	/**
	 * Get the tab title.
	 *
	 * @return string
	 */
	public function get_title() {
		return $this->title;
	}

	/**
	 * Get the tab ID.
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->id;
	}
}
