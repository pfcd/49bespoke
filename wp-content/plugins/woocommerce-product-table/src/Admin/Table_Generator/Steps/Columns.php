<?php

namespace Barn2\Plugin\WC_Product_Table\Admin\Table_Generator\Steps;

use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Database\Query;
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Step;
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Util;
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Content_Table;
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Traits\Columns_Aware;
use Barn2\Plugin\WC_Product_Table\Util\Settings as Settings_Util;
use Barn2\Plugin\WC_Product_Table\Util\Columns as Columns_Util;

/**
 * The columns step handles the setup of columns of the table.
 */
class Columns extends Step {

	public $id = 'columns';

	use Columns_Aware;

	/**
	 * Get things started.
	 */
	public function init() {
		$this->set_id( 'columns' );
		$this->set_name( __( 'Columns', 'woocommerce-product-table' ) );
		$this->set_title( __( 'Table columns', 'woocommerce-product-table' ) );
		$this->set_description( __( 'Next, choose which columns to display in the table.', 'woocommerce-product-table' ) );
		$this->set_fields( $this->get_fields_list() );
	}

	/**
	 * List of fields for the step.
	 *
	 * @return array
	 */
	public function get_fields_list() {

		$fields = [
			[
				'type'  => 'columns',
				'label' => __( 'Columns', 'woocommerce-product-table' ),
				'name'  => 'columns',
				'value' => '',
				'props' => [
					/* translators: %s: Link to the responsive visibility documentation */
					'columnBreakpointsDescription'  => wp_kses_post( sprintf( __( 'Control which devices the column appears on. <a href="%s" target="_blank">Read more</a>', 'woocommerce-product-table' ), 'https://barn2.com/kb/responsive-options/#responsive-visibility' ) ),

					/* translators: %s: Link to the responsive priority documentation */
					'responsivePriorityDescription' => wp_kses_post( sprintf( __( 'Control the order in which columns are \'collapsed\' on smaller screens. <a href="%s" target="_blank">Read more</a>', 'woocommerce-product-table' ), 'https://barn2.com/kb/responsive-options/#priority' ) ),
				],
			],
		];

		return $fields;
	}

	/**
	 * {@inheritdoc}
	 */
	public function get_data( $request ) {

		$table_id = $request->get_param( 'table_id' );

		if ( ! empty( $table_id ) ) {
			/**
		* @var Content_Table $table
*/
			$table = ( new Query( $this->get_generator()->get_database_prefix() ) )->get_item( $table_id );

			return $this->send_success_response(
				[
					'table_id' => $table_id,
					'values'   => [
						'columns' => $table->get_setting( 'columns', $this->get_default_columns( $table->get_content_type() ) ),
					],
				]
			);
		}

		return $this->send_success_response(
			[
				'values' => [
					'columns' => $this->get_default_columns( $this->get_generator()->get_default_options()['content_type'] ?? 'post' ),
				],
			]
		);
	}

	/**
	 * Get a formatted list of default columns for the react component.
	 *
	 * @param  boolean|string $content_type
	 * @return array
	 */
	private function get_default_columns( $content_type = false ) {

		$supported_columns = $this->get_columns_list( $content_type );
		$default_options   = Settings_Util::get_setting_table_defaults();
		$default_columns   = isset( $default_options['columns'] ) ? $default_options['columns'] : false;
		$links             = isset( $default_options['links'] ) ? explode( ',', $default_options['links'] ) : [];
		$columns           = [];

		if ( empty( $default_columns ) ) {
			return $columns;
		}

		$parsable = explode( ',', $default_columns );

		foreach ( $parsable as $key => $column ) {

			if ( $column === 'categories' ) {
				$column = 'tax:product_cat';
			} elseif ( $column === 'tags' ) {
				$column = 'tax:product_tag';
			} elseif ( Columns_Util::is_product_attribute( $column ) ) {
				$column = 'tax:pa_' . Columns_Util::get_product_attribute( $column );
			}

			$i = 0;
			if ( ! isset( $supported_columns[ $column ] ) ) {
				++$i;
				continue;
			}

			$columns[] = [
				'name'     => $supported_columns[ $column ],
				'slug'     => $column,
				'settings' => [
					'input'      => $supported_columns[ $column ],
					'visibility' => 'true',
				],
			];

			if ( in_array( $column, [ 'id', 'sku', 'image', 'name', 'tax:product_cat', 'tax:product_tag' ] ) || Columns_Util::is_custom_taxonomy( $column ) || Columns_Util::is_product_attribute( $column ) ) {
				if ( in_array( $column, $links ) || in_array( 'all', $links ) || Columns_Util::is_custom_taxonomy( $column ) && in_array( 'terms', $links ) || Columns_Util::is_product_attribute( $column ) && in_array( 'attributes', $links ) ) {
					$columns[ $key - $i ]['settings']['links'] = 'true';
				} else {
					$columns[ $key - $i ]['settings']['links'] = 'false';
				}
			}

			if ( $column === 'image' ) {
				$columns[ $key - $i ]['settings']['lightbox'] = 'true';
			}

			if ( in_array( $column, [ 'tax:product_cat', 'tax:product_tag' ] ) || Columns_Util::is_custom_taxonomy( $column ) || Columns_Util::is_product_attribute( $column ) ) {
				$columns[ $key - $i ]['settings']['search_on_click'] = 'true';
			}
		}

		return $columns;
	}

	/**
	 * {@inheritdoc}
	 */
	public function save_data( $request ) {

		$values   = $this->get_submitted_values( $request );
		$columns  = $values['columns'] ?? [];
		$table_id = $request->get_param( 'table_id' );

		if ( empty( $table_id ) ) {
			return $this->send_error_response(
				[
					'message' => __( 'The table_id parameter is missing.', 'woocommerce-product-table' ),
				]
			);
		}

		// Cannot save empty columns.
		if ( empty( $columns ) ) {
			return $this->send_error_response(
				[
					'message' => __( 'You must add at least one column.', 'woocommerce-product-table' ),
				]
			);
		}

		$columns = Util::array_unset_recursive( $columns, 'priority' );
		$columns = Util::array_unset_recursive( $columns, 'id' );

		/**
	* @var Content_Table $table
*/
		$table                     = ( new Query( $this->get_generator()->get_database_prefix() ) )->get_item( $table_id );
		$table_settings            = $table->get_settings();
		$table_settings['columns'] = $columns;

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
