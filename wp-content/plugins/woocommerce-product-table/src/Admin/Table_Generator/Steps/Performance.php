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
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Content_Table;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Util as Lib_Util;
use Barn2\Plugin\WC_Product_Table\Util\Defaults;

/**
 * The performance step handles caching options for the table.
 */
class Performance extends Step {

	public $id = 'performance';

	/**
	 * Get things started.
	 */
	public function init() {
		$this->set_id( 'performance' );
		$this->set_name( __( 'Performance', 'woocommerce-product-table' ) );
		$this->set_title( __( 'Performance', 'woocommerce-product-table' ) );
		$this->set_description( __( 'Optimize your table load times.', 'woocommerce-product-table' ) );
		$this->set_fields( $this->get_fields_list() );

		add_filter( 'barn2_table_generator_table_settings', [ $this, 'disable_lazyload_if_variation_selected' ], 10 );
	}

	/**
	 * List of fields for this step.
	 *
	 * @return array
	 */
	public function get_fields_list() {

		$fields = [
			[
				'type'  => 'th',
				'label' => __( 'Performance', 'woocommerce-product-table' ),
				'tag'   => 'h2',
			],
			[
				'type'  => 'heading',
				'label' => __( 'Lazy load', 'woocommerce-product-table' ),
				'tag'   => 'h2',
			],
			[
				'type'        => 'checkbox',
				'label'       => isset( $_GET['add-new'] ) ? __( 'Load table one page at a time', 'woocommerce-product-table' ) : __( 'Lazy load', 'woocommerce-product-table' ),
				'name'        => 'lazyload',
				'desc'        => __( 'Load table one page at a time', 'woocommerce-product-table' ),
				'description' => '<span id="lazyload-description-1">' . __( 'Enable this if you have many products or experience slow page load times.', 'woocommerce-product-table' ) . '<br/>' .
										sprintf(
											/* translators: 1: Help link open tag, 2: help link close tag */
											__( 'Lazy load has %1$ssome limitations%2$s for the search, sorting and filters.', 'woocommerce-product-table' ),
											Lib_Util::format_barn2_link_open( 'kb/lazy-load', true ),
											'</a>'
										) . '</span>' .
										'<span id="lazyload-description-2" style="display: none;">' . __( 'Lazy load is not compatible with "Show one variation per row" for variations. Standard loading will be used.', 'woocommerce-product-table' ) . '<br/>' .
										'</span>',
				'disabled'    => false,
			],
			[
				'type'        => 'number',
				'label'       => __( 'Product limit', 'woocommerce-product-table' ),
				'name'        => 'product_limit',
				'description' => __( 'The maximum number of products in one table.', 'woocommerce-product-table' ),
				'desc_tip'    => __( 'Enter -1 to show all products.', 'woocommerce-product-table' ),
				'classes'     => 'input-text-small',
				'conditions'  => [
					'lazyload' => [
						'op'    => 'eq',
						'value' => false,
					],
				],
				'style'       => [
					'width'    => '75px',
					'maxWidth' => '100%',
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

			$default_options = Defaults::get_table_defaults();
			$default_misc    = Defaults::get_misc_defaults();

			return $this->send_success_response(
				[
					'table_id' => $table_id,
					'values'   => [
						'lazyload'      => $table->get_setting( 'lazyload', $default_options['lazy_load'] ),
						'product_limit' => $table->get_setting( 'product_limit', $default_options['product_limit'] ),
						'variations'    => $table->get_setting( 'variations', $default_options['variations'] ),
					],
				]
			);
		}

		return $this->send_success_response();
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

		/**
	* @var Content_Table $table
*/
		$table          = ( new Query( $this->get_generator()->get_database_prefix() ) )->get_item( $table_id );
		$table_settings = $table->get_settings();

		$table_settings['lazyload']      = $values['lazyload'];
		$table_settings['product_limit'] = $values['product_limit'];

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

	public function disable_lazyload_if_variation_selected( $settings ) {
		if ( $settings['variations'] === 'separate' ) {
			$settings['lazyload'] = false;
		}
		return $settings;
	}
}
