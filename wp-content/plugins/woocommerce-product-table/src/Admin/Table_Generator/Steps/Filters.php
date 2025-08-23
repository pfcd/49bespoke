<?php
/**
 * @package   Barn2\table-generator
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */

namespace Barn2\Plugin\WC_Product_Table\Admin\Table_Generator\Steps;

use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Database\Query;
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Step;
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Util;
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Content_Table;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Util as Lib_Util;

/**
 * This step handles setup of filters for a table.
 */
class Filters extends Step {

	public $id = 'filters';

	/**
	 * Get things started.
	 */
	public function init() {
		$this->set_id( 'filters' );
		$this->set_name( __( 'Search & Sort', 'woocommerce-product-table' ) );
		$this->set_title( __( 'Search & Sort', 'woocommerce-product-table' ) );
		$this->set_fields( $this->get_fields_list() );
	}

	/**
	 * List of fields for this spte.
	 *
	 * @return array
	 */
	public function get_fields_list() {

		$fields = [
			[
				'type'  => 'th',
				'label' => __( 'Search and sort', 'woocommerce-product-table' ),
				'tag'   => 'h2',
			],
			[
				'type'  => 'heading',
				'label' => __( 'Filters', 'woocommerce-product-table' ),
				'tag'   => 'h2',
			],
			[
				'type'        => 'filters',
				'label'       => isset( $_GET['add-new'] ) ? __( 'Enable filter dropdowns', 'woocommerce-product-table' ) : __( 'Search filters', 'woocommerce-product-table' ),
				'name'        => 'filters',
				'value'       => '',
				'desc'        => __( 'Enable filter dropdowns', 'woocommerce-product-table' ),
				'description' => sprintf( __( 'Filters are displayed above the table, and help users to search and refine the products. You can also add %s to a sidebar.', 'woocommerce-product-table' ), Lib_Util::barn2_link( 'kb/wpt-filters/', __( 'filter widgets', 'woocommerce-product-table' ), true ) ),
			],
			[
				'type'  => 'sortby',
				'label' => __( 'Sort by', 'woocommerce-product-table' ),
				'name'  => 'sortby',
				'value' => '',
			],
			[
				'type'    => 'select',
				'label'   => __( 'Sort direction', 'woocommerce-product-table' ),
				'name'    => 'sort_order',
				'options' => Util::parse_array_for_dropdown(
					[
						''     => __( 'Automatic', 'woocommerce-product-table' ),
						'asc'  => __( 'Ascending (A to Z, old to new)', 'woocommerce-product-table' ),
						'desc' => __( 'Descending (Z to A, new to old)', 'woocommerce-product-table' ),
					]
				),
				'value'   => '',
			],
		];

		return $fields;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_data( $request ) {
		$table_id = $request->get_param( 'table_id' );

		$default_options = $this->get_generator()->get_default_options();

		$default_filters_mode = '';
		$default_filters      = '';
		$default_sort_order   = isset( $default_options['sort_order'] ) ? $default_options['sort_order'] : '';
		$default_sortby       = isset( $default_options['sort_by'] ) ? $default_options['sort_by'] : '';

		if ( ! empty( $table_id ) ) {
			/**
		* @var Content_Table $table
*/
			$table = ( new Query( $this->get_generator()->get_database_prefix() ) )->get_item( $table_id );

			return $this->send_success_response(
				[
					'table_id' => $table_id,
					'values'   => [
						'filter_mode' => $table->get_setting( 'filter_mode', $default_filters_mode ),
						'filters'     => $table->get_setting( 'filters', $default_filters ),
						'sort_order'  => $table->get_setting( 'sort_order', $default_sort_order ),
						'sortby'      => $table->get_setting( 'sortby', $default_sortby ),
					],
				]
			);
		}

		return $this->send_success_response(
			[
				'values' => [
					'filter_mode' => $default_filters_mode,
					'filters'     => $default_filters,
					'sort_order'  => $default_sort_order,
					'sortby'      => $default_sortby,
				],
			]
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function save_data( $request ) {

		$values   = $this->get_submitted_values( $request );
		$table_id = $request->get_param( 'table_id' );

		if ( empty( $table_id ) ) {
			return $this->send_error_response(
				[
					'message' => __( 'The table_id parameter is missing.', 'woocommerce-product-table' ),
				]
			);
		}

		$filters      = isset( $values['filters'] ) ? $values['filters'] : [];
		$filter_mode  = isset( $filters['mode'] ) ? $filters['mode'] : false;
		$filter_items = isset( $filters['items'] ) && $filter_mode === true ? $filters['items'] : [];
		$sortby       = isset( $values['sortby'] ) ? $values['sortby'] : 'title';
		$sort_order   = isset( $values['sort_order'] ) ? $values['sort_order'] : '';

		if ( ! empty( $filter_items ) ) {
			$filter_items = Util::array_unset_recursive( $filter_items, 'id' );
			$filter_items = Util::array_unset_recursive( $filter_items, 'priority' );
		}

		/**
	* @var Content_Table $table
*/
		$table          = ( new Query( $this->get_generator()->get_database_prefix() ) )->get_item( $table_id );
		$table_settings = $table->get_settings();

		$table_settings['filter_mode'] = $filter_mode;
		$table_settings['filters']     = $filter_items;
		$table_settings['sortby']      = $sortby;
		$table_settings['sort_order']  = $sort_order;

		$updated_table = ( new Query( $this->get_generator()->get_database_prefix() ) )->update_item(
			$table_id,
			[
				'settings' => wp_json_encode( $table_settings ),
			]
		);

		return $this->send_success_response(
			[
				'table_id' => $table_id,
			]
		);
	}
}
