<?php

namespace Barn2\Plugin\WC_Product_Table\Integration;

use Barn2\Plugin\WC_Product_Table\Util\Settings;
use Barn2\Plugin\WC_Product_Table\Util\Util;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Registerable;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Util as Lib_Util;
use Barn2\Plugin\WC_Product_Table\Admin\Table_Generator\Table_Generator;
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Database\Query;
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Traits\Generator_Aware;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Service\Standard_Service;

/**
 * Handles the WooCommerce Wholesale Pro integration.
 *
 * @package   Barn2\woocommerce-product-table
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class WooCommerce_Wholesale_Pro implements Standard_Service, Registerable {

	use Generator_Aware;

	/**
	 * Instance of the table generator class.
	 *
	 * @var Table_Generator
	 */
	public $generator;

	/**
	 * Register the integrations for WooCommerce Wholesale Pro.
	 */
	public function register() {

		// Checks if WooCommerce Wholesale Pro is active.
		if ( ! Lib_Util::is_barn2_plugin_active( '\Barn2\Plugin\WC_Wholesale_Pro\woocommerce_wholesale_pro' ) && ! in_array( 'wholesale_store_override', array_keys( Util::get_shop_templates_tables() ) ) ) {
			return;
		}

		// Add wholesale fileds to table builder wizard.
		add_filter( 'barn2_table_generator_set_fields', [ $this, 'add_wholesale_field' ], 10, 2 );

		// Update WWP layout options when creating or deleting a table.
		add_filter( 'barn2_table_generator_api_response_data', [ $this, 'wizard_list_update_wwp_layout' ], 10, 3 );

		// Update WWP layout options when editing a table.
		add_filter( 'barn2_table_generator_table_settings', [ $this, 'edit_update_wwp_layout' ], 10, 2 );
	}

	/**
	 * Add wholesale fileds to table builder wizard.
	 *
	 * @param  mixed $fields Wizard fields.
	 * @param  mixed $id     Id of the wizard step.
	 * @return mixed Wizard fields.
	 */
	public function add_wholesale_field( $fields, $id ) {

		if ( $id === 'refine' ) {

			$edit_url = admin_url( 'edit.php?post_type=product&page=tables#/edit/' );

			// Get all already selected templates.
			$shop_templates_tables = Util::get_shop_templates_tables();

			$checkbox_conditions = [
				'table_display' => [
					'op'    => 'eq',
					'value' => 'shop_page',
				],
			];

			if ( isset( $fields[ count( $fields ) - 1 ]['classes'][0] ) ) {
				$fields[ count( $fields ) - 1 ]['classes'][0] = str_replace( ' bottom-pad', '', $fields[ count( $fields ) - 1 ]['classes'][0] );
			}

			$fields = array_merge(
				$fields,
				[
					[
						'label'      => isset( $_GET['add-new'] ) ? __( 'Wholesale store', 'woocommerce-product-table' ) . ( in_array( 'wholesale_store_override', array_keys( $shop_templates_tables ), true ) ? '<span class="barn2-checkbox-control__label-description"><i>Selected on: <a href="' . $edit_url . $shop_templates_tables['wholesale_store_override']['id'] . '" target="_blank">' . $shop_templates_tables['wholesale_store_override']['title'] . '</a></i></span>' : '' ) : '',
						'desc'       => ! isset( $_GET['add-new'] ) ? __( 'Wholesale store', 'woocommerce-product-table' ) . ( in_array( 'wholesale_store_override', array_keys( $shop_templates_tables ), true ) ? '<span class="barn2-checkbox-control__label-description"><i>Selected on: <a href="' . $edit_url . $shop_templates_tables['wholesale_store_override']['id'] . '" target="_blank">' . $shop_templates_tables['wholesale_store_override']['title'] . '</a></i></span>' : '' ) : '',
						'name'       => 'wholesale_store_override',
						'type'       => 'checkbox',
						'border'     => false,
						'classes'    => [
							'no-top-pad' . ( in_array( 'wholesale_store_override', array_keys( $shop_templates_tables ), true ) ? ' disabled' : '' ),
						],
						'value'      => '',
						'disabled'   => in_array( 'wholesale_store_override', array_keys( $shop_templates_tables ), true ),
						'conditions' => $checkbox_conditions,
					],
				]
			);
		}

		return $fields;
	}

	/**
	 * Update WWP layout options when creating or deleting a table.
	 *
	 * @param  mixed $data
	 * @param  mixed $class_function
	 * @param  mixed $type
	 * @return mixed
	 */
	public function wizard_list_update_wwp_layout( $data, $class_function, $type ) {

		$tables = Util::get_shop_templates_tables();

		// While creating a table in the Wizard.
		if ( $type === 'success' && isset( $class_function['class'] ) && basename( str_replace( '\\', '/', $class_function['class'] ) ) === 'Tables' && $class_function['function'] === 'set_table_completed' ) {
			if ( isset( $tables['wholesale_store_override'] ) ) {
				update_option( 'wcwp_layout_store_page', 'product_table' );
				update_option( 'wcwp_layout_taxonomy_pages', 'product_table' );
				self::delete_previous_wholesale_reference();
			}
		}

		// When deleting a table.
		if ( $type === 'success' && isset( $class_function['class'] ) && basename( str_replace( '\\', '/', $class_function['class'] ) ) === 'Tables' && $class_function['function'] === 'delete_table' ) {
			if ( ! isset( $tables['wholesale_store_override'] ) ) {
				update_option( 'wcwp_layout_store_page', 'default' );
				update_option( 'wcwp_layout_taxonomy_pages', 'default' );
				self::delete_previous_wholesale_reference();
			}
		}

		return $data;
	}

	/**
	 * Update WWP layout options when editing a table.
	 *
	 * @param  mixed $settings
	 * @param  mixed $table_id
	 * @return mixed
	 */
	public function edit_update_wwp_layout( $settings, $table_id ) {

		$tables = Util::get_shop_templates_tables();

		if ( isset( $settings['wholesale_store_override'] ) && $settings['wholesale_store_override'] === true && get_option( 'wcwp_layout_store_page', 'default' ) === 'default' && get_option( 'wcwp_layout_taxonomy_pages', 'default' ) === 'default' ) {
			update_option( 'wcwp_layout_store_page', 'product_table' );
			update_option( 'wcwp_layout_taxonomy_pages', 'product_table' );
		} elseif ( isset( $tables['wholesale_store_override'] ) && $tables['wholesale_store_override']['id'] === (int) $table_id
			&& ( ! isset( $settings['wholesale_store_override'] ) || $settings['wholesale_store_override'] === false )
			&& ( get_option( 'wcwp_layout_store_page', 'default' ) === 'product_table' || get_option( 'wcwp_layout_taxonomy_pages', 'default' ) === 'product_table' )
		) {
			update_option( 'wcwp_layout_store_page', 'default' );
			update_option( 'wcwp_layout_taxonomy_pages', 'default' );

			self::delete_previous_wholesale_reference();

			// Sets the previous wholesale store table as the current table.
			$settings['previous_wholesale_store_override'] = true;
		}
		return $settings;
	}

	/**
	 * Checks if wholesale store option can be checked or if a new wholesale table should be created.
	 *
	 * @return void
	 */
	public static function maybe_create_wholesale_table() {
		$tables = Util::get_shop_templates_tables();

		if ( ( ! isset( $tables['wholesale_store_override'] ) || ! $tables['wholesale_store_override'] ) ) {

			// If there is a previous wholesale store defined.
			if ( isset( $tables['previous_wholesale_store_override'] ) ) {

				$table_id = $tables['previous_wholesale_store_override']['id'];

				$query          = new Query( 'wpt' );
				$table          = $query->get_item( $table_id );
				$table_settings = $table->get_settings();

				$table_settings['wholesale_store_override'] = true;
				$table_settings['table_display']            = 'shop_page';

				$query->update_item(
					$table_id,
					[
						'settings' => wp_json_encode( $table_settings ),
					]
				);

			} else {
				self::create_wholesale_table();
			}
		}
	}

	/**
	 * Creates the wholesale database table.
	 *
	 * @return void
	 */
	public static function create_wholesale_table() {

		self::delete_previous_wholesale_reference();

		$title    = __( 'Wholesale order form', 'woocommerce-product-table' );
		$settings = [
			'table_display'            => 'shop_page',
			'wholesale_store_override' => true,
		];

		$misc = Settings::get_setting_misc();

		foreach ( $misc as $k => $v ) {
			if ( substr( $k, -9 ) === '_override' ) {
				$settings[ $k ] = false;
			}
		}

		Table_Generator::create_table( $title, $settings );
	}

	/**
	 * Checks if wholesale store option can be unchecked or if the table should be converted to manual.
	 */
	public static function maybe_remove_wholesale_table() {
		$tables = Util::get_shop_templates_tables();

		if ( ! isset( $tables['wholesale_store_override'] ) ) {
			return;
		}

		$table_id = $tables['wholesale_store_override']['id'];

		$query = new Query( 'wpt' );

		$table          = $query->get_item( $table_id );
		$table_settings = $table->get_settings();

		// Deselects the wholesale store option.
		unset( $table_settings['wholesale_store_override'] );

		// If the wholesale store option is the only selected, then change the display to shortcode.
		$table_settings['table_display'] = 'manual';
		foreach ( $table_settings as $key => $value ) {
			if ( substr( $key, -9 ) === '_override' && $key !== 'previous_wholesale_store_override' && $value === true ) {
				$table_settings['table_display'] = 'shop_page';
				break;
			}
		}

		$table_settings['previous_wholesale_store_override'] = true;

		$query->update_item(
			$table_id,
			[
				'settings' => wp_json_encode( $table_settings ),
			]
		);
	}

	/**
	 * Deletes the previous wholesale store override table reference.
	 */
	public static function delete_previous_wholesale_reference() {

		$tables = Util::get_shop_templates_tables();

		if ( isset( $tables['previous_wholesale_store_override'] ) ) {

			$table_id = $tables['previous_wholesale_store_override']['id'];

			$query          = new Query( 'wpt' );
			$table          = $query->get_item( $table_id );
			$table_settings = $table->get_settings();

			unset( $table_settings['previous_wholesale_store_override'] );

			$query->update_item(
				$table_id,
				[
					'settings' => wp_json_encode( $table_settings ),
				]
			);
		}
	}
}
