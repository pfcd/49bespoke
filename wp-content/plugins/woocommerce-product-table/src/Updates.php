<?php

namespace Barn2\Plugin\WC_Product_Table;

use Barn2\Plugin\WC_Product_Table\Admin\Table_Generator\Table_Generator;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Service\Updater;
use Barn2\Plugin\WC_Product_Table\Integration\WooCommerce_Wholesale_Pro;
use Barn2\Plugin\WC_Product_Table\Util\Settings as Util_Settings;

/**
 * Update functions to be used on plugin updates.
 *
 * @package   Barn2\woocommerce-product-table
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
final class Updates extends Updater {

	/**
	 * Callbacks functions that are called on a plugin update.
	 *
	 * Please note that these functions are invoked when a plugin is updated from a previous version,
	 * but NOT when the plugin is newly installed.
	 *
	 * The array keys should contain the version number, and it MUST be sorted from low to high.
	 *
	 * Example:
	 *
	 * '1.11.0' => [
	 *         'update_1_11_0_do_something',
	 *         'update_1_11_0_do_something_else',
	 *     ],
	 *     '1.23.0' => [
	 *         'update_1_23_0_do_something',
	 *     ],
	 *
	 * @var array
	 */
	public static $updates = [
		'4.0.0' => [
			'update_4_0_0_backup_old_settings',
			'update_4_0_0_migrate_settings_to_table_builder',
			'update_4_0_0_migrate_wwp_layout_options',
			'update_4_0_0_migrate_checkbox_settings',
			'update_4_0_0_delete_unused_settings',
		],
	];

	/**
	 * {@inheritdoc}
	 */
	public function __construct( Plugin $plugin, $args = null ) {
		$this->plugin = $plugin;

		$this->set_options(
			[
				'needs_update_db_notice' => [
					'buttons' => [
						'learn-more' => [
							'value' => __( 'Learn more about this important update', 'woocommerce-product-table' ),
							'href'  => 'https://barn2.com/kb/updating-to-wpt-4-0/',
						],
					],
				],
			]
		);

		return $this;
	}

	/**
	 * Condition to verify if it's a new plugin installation and not an update.
	 *
	 * @return bool
	 */
	public function is_new_install(): bool {
		return $this->get_current_database_version() === true && get_option( Util_Settings::OPTION_TABLE_DEFAULTS ) === false;
	}

	/**
	 * Migrate old settings into the new table settings.
	 */
	public static function update_4_0_0_backup_old_settings() {
		update_option( Util_Settings::OPTION_TABLE_STYLING . '_backup', get_option( Util_Settings::OPTION_TABLE_STYLING ) );
		update_option( Util_Settings::OPTION_TABLE_DEFAULTS . '_backup', get_option( Util_Settings::OPTION_TABLE_DEFAULTS ) );
		update_option( Util_Settings::OPTION_MISC . '_backup', get_option( Util_Settings::OPTION_MISC ) );
	}

	/**
	 * Migrate old settings into the new table settings.
	 */
	public static function update_4_0_0_migrate_settings_to_table_builder() {
		$query = new \Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Database\Query( 'wpt' );
		$query->query(
			[
				'search'         => '"table_display":"manual"',
				'search_columns' => [ 'settings' ],
				'count'          => true,
				'number'         => 1,
				'is_completed'   => true,
			]
		);
		$total = $query->found_items;

		// if ( ! $total ) {
		Table_Generator::create_table( __( 'Default table', 'woocommerce-product-table' ) );

		// If there was an override template options previously selected.
		$misc = \Barn2\Plugin\WC_Product_Table\Util\Settings::get_setting_misc();
		$misc = array_filter(
			$misc,
			function ( $v, $k ) {
				return substr( $k, -9 ) === '_override' && $v === true;
			},
			ARRAY_FILTER_USE_BOTH
		);

		if ( count( $misc ) > 0 ) {
			Table_Generator::create_table(
				__( 'Shop templates', 'woocommerce-product-table' ),
				[
					'table_display' => 'shop_page',
				]
			);
		}
		// }
	}

	/**
	 * Migrate WWP layout options.
	 *
	 * Must run before update_4_0_0_delete_unused_settings so that it uses the old settings and not the default plugin ones.
	 */
	public static function update_4_0_0_migrate_wwp_layout_options() {
		if ( get_option( 'wcwp_layout_store_page', 'default' ) === 'product_table' || get_option( 'wcwp_layout_taxonomy_pages', 'default' ) === 'product_table' ) {
			WooCommerce_Wholesale_Pro::maybe_create_wholesale_table();
		}
	}

	/**
	 * Update checkbox settings with the new compatible values.
	 */
	public static function update_4_0_0_migrate_checkbox_settings() {

		// Updates shortcode defaults options.
		$table_defaults = get_option( Util_Settings::OPTION_TABLE_DEFAULTS, [] );

		$table_defaults['reset_button'] = $table_defaults['reset_button'] === 'yes' ? true : false;
		$table_defaults['quantities']   = $table_defaults['quantities'] === 'yes' ? true : false;
		$table_defaults['ajax_cart']    = $table_defaults['ajax_cart'] === 'yes' ? true : false;
		$table_defaults['shortcodes']   = $table_defaults['shortcodes'] === 'yes' ? true : false;
		$table_defaults['cache']        = $table_defaults['cache'] === 'yes' ? true : false;

		update_option( Util_Settings::OPTION_TABLE_DEFAULTS, $table_defaults );

		// Updates misc defaults options.
		$misc = get_option( Util_Settings::OPTION_MISC, [] );

		$misc['include_hidden'] = $misc['include_hidden'] === 'yes' ? true : false;

		update_option( Util_Settings::OPTION_MISC, $misc );
	}

	/**
	 * Deletes unused old settings that were transfered to the table builder.
	 */
	public static function update_4_0_0_delete_unused_settings() {

		// Deletes shortcode defaults options.
		$shortcode_defaults = get_option( Util_Settings::OPTION_TABLE_DEFAULTS, [] );

		unset( $shortcode_defaults['columns'] );
		unset( $shortcode_defaults['links'] );
		unset( $shortcode_defaults['lightbox'] );
		unset( $shortcode_defaults['image_size'] );
		unset( $shortcode_defaults['product_limit'] );
		unset( $shortcode_defaults['sort_by'] );
		unset( $shortcode_defaults['sort_by_custom'] );
		unset( $shortcode_defaults['sort_order'] );
		unset( $shortcode_defaults['filters'] );
		unset( $shortcode_defaults['filters_custom'] );
		unset( $shortcode_defaults['cart_button'] );
		unset( $shortcode_defaults['variations'] );

		update_option( Util_Settings::OPTION_TABLE_DEFAULTS, $shortcode_defaults );

		// Deletes misc options.
		$misc = get_option( Util_Settings::OPTION_MISC, [] );

		foreach ( $misc as $key => $setting ) {
			if ( substr( $key, -9 ) === '_override' ) {
				unset( $misc[ $key ] );
			}
		}
		unset( $misc['variation_name_format'] );

		update_option( Util_Settings::OPTION_MISC, $misc );
	}
}