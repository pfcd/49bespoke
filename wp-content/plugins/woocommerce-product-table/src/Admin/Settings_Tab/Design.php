<?php

namespace Barn2\Plugin\WC_Product_Table\Admin\Settings_Tab;

use Barn2\Plugin\WC_Product_Table\Util\Util;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Conditional;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Registerable;
use Barn2\Plugin\WC_Product_Table\Util\Settings as Settings_Util;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Admin\Plugin_Promo;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Plugin\Licensed_Plugin;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Admin\Settings_API_Helper;

/**
 * The global design tab.
 *
 * @package   Barn2\woocommerce-product-table
 * @author    Barn2 Plugins <info@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Design implements Registerable, Conditional {

	const TAB_ID       = 'design';
	const OPTION_GROUP = 'wc_product_table_design';
	const MENU_SLUG    = 'wpt_design';

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
		$this->id              = 'design';

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
		$this->title = __( 'Design', 'woocommerce-product-table' );
	}

	public function is_required() {
		return isset( $_GET['tab'] ) && $_GET['tab'] === 'design' || strpos( $_SERVER['REQUEST_URI'], '/options.php' ) !== false;
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
			Settings_Util::OPTION_TABLE_STYLING,
			[
				'type'        => 'string',
				'description' => 'WooCommerce Product Table styling settings',
			]
		);
	}

	public function add_settings_sections() {

		// Table design.
		Settings_API_Helper::add_settings_section(
			'product_table_settings_design',
			self::MENU_SLUG,
			__( 'Design', 'woocommerce-product-table' ),
			[ $this, 'display_table_design_description' ],
			$this->get_table_design_settings()
		);
	}

	public function display_table_design_description() {
		echo __( 'Choose whether to use the default design, select a template or customize it to suit your requirements.', 'woocommerce-product-table' );
	}

	private function get_table_design_settings() {
		$fields = [];
		$fields = array_merge( $fields, $this->get_template_field() );
		$fields = array_merge( $fields, $this->get_border_style_fields() );
		$fields = array_merge( $fields, $this->get_table_background_fields() );
		$fields = array_merge( $fields, $this->get_font_style_fields() );
		$fields = array_merge( $fields, $this->get_button_background_fields() );
		$fields = array_merge( $fields, $this->get_text_fields() );
		$fields = array_merge( $fields, $this->get_dropdowns_fields() );
		$fields = array_merge( $fields, $this->get_checkboxes_fields() );
		$fields = array_merge( $fields, $this->get_row_and_cell_fields() );

		return $fields;
	}

	private function get_template_field() {
		return [
			[
				'title'           => __( 'Templates', 'woocommerce-product-table' ),
				'desc'            => __( 'Choose a template and/or customize the styles below. Any settings you leave blank will default to your theme styles.', 'woocommerce-product-table' ),
				'type'            => 'radio_image',
				'id'              => Settings_Util::OPTION_TABLE_STYLING . '[use_theme]',
				'options'         => [
					'theme'    => __( 'Default', 'woocommerce-product-table' ),
					'minimal'  => __( 'Minimal', 'woocommerce-product-table' ),
					'dark'     => __( 'Dark', 'woocommerce-product-table' ),
					'neutral'  => __( 'Neutral', 'woocommerce-product-table' ),
					'rounded'  => __( 'Rounded', 'woocommerce-product-table' ),
					'delicate' => __( 'Delicate', 'woocommerce-product-table' ),
					'nature'   => __( 'Nature', 'woocommerce-product-table' ),
				],
				'images'          => [
					'theme'    => Util::get_asset_url( 'images/templates/default.png' ),
					'minimal'  => Util::get_asset_url( 'images/templates/minimal.png' ),
					'dark'     => Util::get_asset_url( 'images/templates/dark.png' ),
					'neutral'  => Util::get_asset_url( 'images/templates/neutral.png' ),
					'rounded'  => Util::get_asset_url( 'images/templates/rounded.png' ),
					'delicate' => Util::get_asset_url( 'images/templates/delicate.png' ),
					'nature'   => Util::get_asset_url( 'images/templates/nature.png' ),
				],
				'lightbox_images' => [
					'theme'    => Util::get_asset_url( 'images/templates/default-large.png' ),
					'minimal'  => Util::get_asset_url( 'images/templates/minimal-large.png' ),
					'dark'     => Util::get_asset_url( 'images/templates/dark-large.png' ),
					'neutral'  => Util::get_asset_url( 'images/templates/neutral-large.png' ),
					'rounded'  => Util::get_asset_url( 'images/templates/rounded-large.png' ),
					'delicate' => Util::get_asset_url( 'images/templates/delicate-large.png' ),
					'nature'   => Util::get_asset_url( 'images/templates/nature-large.png' ),
				],
				'magnify_image'   => Util::get_asset_url( 'images/magnify-icon.png' ),
				'default'         => 'theme',
				'field_class'     => 'design-templates-group',
				'class'           => 'design_templates',
			],
		];
	}

	private function get_border_style_fields() {
		return [
			[
				'title'       => __( 'Borders', 'woocommerce-product-table' ),
				'type'        => 'color_size',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[border_outer]',
				'desc'        => self::get_icon( 'external-border.svg', __( 'External border icon', 'woocommerce-product-table' ) ) . __( 'External', 'woocommerce-product-table' ),
				'desc_tip'    => __( 'The border for the outer edges of the table.', 'woocommerce-product-table' ),
				'placeholder' => __( 'Size', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-size-field',
				'field_class' => 'option-group-start',
			],
			[
				'type'        => 'color_size',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[border_header]',
				/* translators: 'Header' in this context refers to the heading row of a table. */
				'desc'        => self::get_icon( 'header-border.svg', __( 'Header border icon', 'woocommerce-product-table' ) ) . __( 'Header', 'woocommerce-product-table' ),
				'desc_tip'    => __( 'The border for the bottom of the header row.', 'woocommerce-product-table' ),
				'placeholder' => __( 'Size', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-size-field',
			],
			[
				'type'        => 'color_size',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[border_horizontal_cell]',
				/* translators: 'Cell' in this context refers to a cell in a table or spreadsheet. */
				'desc'        => self::get_icon( 'horizontal-cell.svg', __( 'Horizontal cell border icon', 'woocommerce-product-table' ) ) . __( 'Horizontal cell', 'woocommerce-product-table' ),
				'desc_tip'    => __( 'The border between cells in your table.', 'woocommerce-product-table' ),
				'placeholder' => __( 'Size', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-size-field',
			],
			[
				'type'        => 'color_size',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[border_vertical_cell]',
				/* translators: 'Cell' in this context refers to a cell in a table or spreadsheet. */
				'desc'        => self::get_icon( 'vertical-cell.svg', __( 'Vertical cell border icon', 'woocommerce-product-table' ) ) . __( 'Vertical cell', 'woocommerce-product-table' ),
				'desc_tip'    => __( 'The border between cells in your table.', 'woocommerce-product-table' ),
				'placeholder' => __( 'Size', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-size-field',
			],
			[
				'type'        => 'color_size',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[border_bottom]',
				/* translators: 'Cell' in this context refers to a cell in a table or spreadsheet. */
				'desc'        => self::get_icon( 'button-border.svg', __( 'Button border icon', 'woocommerce-product-table' ) ) . __( 'Bottom', 'woocommerce-product-table' ),
				'desc_tip'    => __( 'The border between cells in your table.', 'woocommerce-product-table' ),
				'placeholder' => __( 'Size', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-size-field',
			],
		];
	}

	private function get_table_background_fields() {
		return [
			[
				'title'       => __( 'Header background color', 'woocommerce-product-table' ),
				'type'        => 'color',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[header_bg]',
				'desc'        => __( 'Header', 'woocommerce-product-table' ),
				'placeholder' => __( 'Color', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-field',
				'field_class' => 'option-group-start',
			],
			[
				'type'        => 'color',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[cell_bg]',
				'desc'        => __( 'Cell', 'woocommerce-product-table' ),
				'placeholder' => __( 'Color', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-field',
				'class'       => 'custom-style',
			],
		];
	}

	private function get_font_style_fields() {
		return [
			[
				'title'       => __( 'Fonts', 'woocommerce-product-table' ),
				'type'        => 'color_size',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[header_font]',
				'desc'        => __( 'Header', 'woocommerce-product-table' ),
				'desc_tip'    => __( 'The border for the outer edges of the table.', 'woocommerce-product-table' ),
				'placeholder' => __( 'Size', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-size-field',
				'field_class' => 'option-group-start',
			],
			[
				'type'        => 'color_size',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[cell_font]',
				/* translators: 'Header' in this context refers to the heading row of a table. */
				'desc'        => __( 'Cell', 'woocommerce-product-table' ),
				'desc_tip'    => __( 'The border for the bottom of the header row.', 'woocommerce-product-table' ),
				'placeholder' => __( 'Size', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-size-field',
			],
			[
				'type'        => 'color_size',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[hyperlink_font]',
				/* translators: 'Cell' in this context refers to a cell in a table or spreadsheet. */
				'desc'        => __( 'Hyperlink', 'woocommerce-product-table' ),
				'desc_tip'    => __( 'The border between cells in your table.', 'woocommerce-product-table' ),
				'placeholder' => __( 'Size', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-size-field',
			],
			[
				'type'        => 'color_size',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[button_font]',
				/* translators: 'Cell' in this context refers to a cell in a table or spreadsheet. */
				'desc'        => __( 'Main button font', 'woocommerce-product-table' ),
				'desc_tip'    => __( 'The border between cells in your table.', 'woocommerce-product-table' ),
				'placeholder' => __( 'Size', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-size-field',
			],
			[
				'type'        => 'color_size',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[disabled_button_font]',
				/* translators: 'Cell' in this context refers to a cell in a table or spreadsheet. */
				'desc'        => __( 'Disable button font', 'woocommerce-product-table' ),
				'desc_tip'    => __( 'The border between cells in your table.', 'woocommerce-product-table' ),
				'placeholder' => __( 'Size', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-size-field',
			],
			[
				'type'        => 'color_size',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[quantity_font]',
				/* translators: 'Cell' in this context refers to a cell in a table or spreadsheet. */
				'desc'        => __( 'Quantity', 'woocommerce-product-table' ),
				'desc_tip'    => __( 'The border between cells in your table.', 'woocommerce-product-table' ),
				'placeholder' => __( 'Size', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-size-field',
			],
		];
	}

	private function get_button_background_fields() {
		return [
			[
				'title'       => __( 'Button backgrounds', 'woocommerce-product-table' ),
				'type'        => 'color',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[button_bg]',
				'desc'        => __( 'Main button', 'woocommerce-product-table' ),
				'placeholder' => __( 'Color', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-field',
				'field_class' => 'option-group-start',
			],
			[
				'type'        => 'color',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[button_bg_hover]',
				'desc'        => __( 'Main button hover', 'woocommerce-product-table' ),
				'placeholder' => __( 'Color', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-field',
			],
			[
				'type'        => 'color',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[button_disabled_bg]',
				'desc'        => __( 'Disable button', 'woocommerce-product-table' ),
				'placeholder' => __( 'Color', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-field',
			],
			[
				'type'        => 'color',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[button_quantity_bg]',
				'desc'        => __( 'Quantity', 'woocommerce-product-table' ),
				'placeholder' => __( 'Color', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-field',
			],
		];
	}

	private function get_text_fields() {
		return [
			[
				'title'       => __( 'Search', 'woocommerce-product-table' ),
				'type'        => 'color',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[text_background]',
				'desc'        => __( 'Background', 'woocommerce-product-table' ),
				'placeholder' => __( 'Color', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-field',
				'field_class' => 'option-group-start',
			],
			[
				'type'        => 'color',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[text_font]',
				'desc'        => __( 'Font', 'woocommerce-product-table' ),
				'placeholder' => __( 'Color', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-field',
			],
			[
				'type'        => 'color_size',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[text_border]',
				'desc'        => __( 'Border', 'woocommerce-product-table' ),
				'placeholder' => __( 'Size', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-size-field',
			],
		];
	}

	private function get_dropdowns_fields() {
		return [
			[
				'title'       => __( 'Dropdowns', 'woocommerce-product-table' ),
				'type'        => 'color',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[dropdown_background]',
				'desc'        => __( 'Background', 'woocommerce-product-table' ),
				'placeholder' => __( 'Color', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-field',
				'field_class' => 'option-group-start',
			],
			[
				'type'        => 'color',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[dropdown_font]',
				'desc'        => __( 'Font', 'woocommerce-product-table' ),
				'placeholder' => __( 'Color', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-field',
			],
			[
				'type'        => 'color_size',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[dropdown_border]',
				'desc'        => __( 'Border', 'woocommerce-product-table' ),
				'placeholder' => __( 'Size', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-size-field',
			],
		];
	}

	private function get_checkboxes_fields() {
		return [
			[
				'title'       => __( 'Checkboxes', 'woocommerce-product-table' ),
				'type'        => 'color',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[checkboxes_border]',
				'placeholder' => __( 'Color', 'woocommerce-product-table' ),
				'class'       => 'wpt-custom-color-field',
				'field_class' => 'option-group-start',
			],
		];
	}

	private function get_row_and_cell_fields() {
		return [
			[
				'title'       => __( 'Cell backgrounds', 'woocommerce-product-table' ),
				'type'        => 'radio',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[cell_backgrounds]',
				'options'     => [
					'no-alternate'      => __( 'No alternate', 'woocommerce-product-table' ),
					'alternate-rows'    => __( 'Alternate rows', 'woocommerce-product-table' ),
					'alternate-columns' => __( 'Alternate columns', 'woocommerce-product-table' ),
				],
				'default'     => 'no-alternate',
				'class'       => 'wpt_cell_backgrounds_field',
				'field_class' => 'option-group-start',
			],
			[
				'title'       => __( 'Corner style', 'woocommerce-product-table' ),
				'type'        => 'radio',
				'id'          => Settings_Util::OPTION_TABLE_STYLING . '[corner_style]',
				'options'     => [
					'theme-default'   => __( 'Theme default', 'woocommerce-product-table' ),
					'square-corners'  => __( 'Square corners', 'woocommerce-product-table' ),
					'rounded-corners' => __( 'Rounded corners', 'woocommerce-product-table' ),
					'fully-rounded'   => __( 'Fully rounded corners', 'woocommerce-product-table' ),
				],
				'default'     => 'theme-default',
				'class'       => 'wpt_corner_style_field',
				'field_class' => 'option-group-start',
			],
		];
	}

	/**
	 * Get an icon for the plugin's settings.
	 *
	 * @param  string $icon
	 * @param  string $alt_text
	 * @return string
	 */
	private static function get_icon( $icon, $alt_text = '' ) {
		return sprintf(
			'<img src="%1$s" alt="%2$s" width="22" height="22" />',
			Util::get_asset_url( 'images/' . ltrim( $icon, '/' ) ),
			$alt_text
		);
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
