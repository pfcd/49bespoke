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
 * This step handles setup of sort for a table.
 */
class AddToCart extends Step {

	public $id = 'add_to_cart';

	/**
	 * Get things started.
	 */
	public function init() {
		$this->set_id( 'add_to_cart' );
		$this->set_name( __( 'Add to Cart', 'woocommerce-product-table' ) );
		$this->set_title( __( 'Add to Cart', 'woocommerce-product-table' ) );
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
				'label' => __( 'Add to cart', 'woocommerce-product-table' ),
				'tag'   => 'h2',
			],
			[
				'type'    => 'select',
				'label'   => __( 'Add to cart method', 'woocommerce-product-table' ),
				'name'    => 'cart_button',
				'options' => Util::parse_array_for_dropdown(
					[
						'button'          => __( 'Cart buttons', 'woocommerce-product-table' ),
						'checkbox'        => __( 'Checkboxes', 'woocommerce-product-table' ),
						'button_checkbox' => __( 'Cart buttons and checkboxes', 'woocommerce-product-table' ),
					]
				),
				'value'   => '',
			],
			[
				'type'  => 'heading',
				'label' => __( 'Quantities', 'woocommerce-product-table' ),
				'tag'   => 'h2',
			],
			[
				'type'    => 'checkbox',
				'label'   => isset( $_GET['add-new'] ) ? __( 'Show a quantity picker for each product', 'woocommerce-product-table' ) : __( 'Quantities', 'woocommerce-product-table' ),
				'name'    => 'quantities',
				'desc'    => __( 'Show a quantity picker for each product', 'woocommerce-product-table' ),
				'checked' => true,
			],
			[
				'type'        => 'select',
				'label'       => __( 'Variations', 'woocommerce-product-table' ),
				'name'        => 'variations',
				'options'     => Util::parse_array_for_dropdown(
					[
						'dropdown' => __( 'Show as dropdown lists', 'woocommerce-product-table' ),
						'separate' => __( 'Show one variation per row', 'woocommerce-product-table' ),
						'false'    => __( 'Read More button linking to the product page', 'woocommerce-product-table' ),
					]
				),
				'value'       => '',
				'description' => __( 'How to display the options for variable products.', 'woocommerce-product-table' ) . ' ' . Lib_Util::barn2_link( 'kb/product-variations', false, true ),
			// 'desc'              => __( 'How to display the options for variable products.', 'woocommerce-product-table' ) . ' ' . Lib_Util::barn2_link( 'kb/product-variations', false, true ),
			// 'default'           => $defaults['variations'],
			// 'class'             => 'toggle-parent wc-enhanced-select',
			// 'custom_attributes' => [
			// 'data-child-class' => 'variation-name-format',
			// 'data-toggle-val'  => 'separate'
			// ]
			],
			[
				'type'       => 'select',
				'label'      => __( 'Variation name format', 'woocommerce-product-table' ),
				'name'       => 'variation_name_format',
				'options'    => Util::parse_array_for_dropdown(
					[
						'full'       => __( 'Full (product name + attributes)', 'woocommerce-product-table' ),
						'attributes' => __( 'Attributes only', 'woocommerce-product-table' ),
						'parent'     => __( 'Product name only', 'woocommerce-product-table' ),
					]
				),
				'default'    => 'full',
				'conditions' => [
					'variations' => [
						'op'    => 'eq',
						'value' => 'separate',
					],
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

		$default_options = $this->get_generator()->get_default_options();

		$default_cart_button           = $default_options['cart_button'] ?? '';
		$default_quantities            = $default_options['quantities'] ?? '';
		$default_variations            = $default_options['variations'] ?? '';
		$default_variation_name_format = $default_options['variation_name_format'] ?? '';

		if ( ! empty( $table_id ) ) {
			/**
		* @var Content_Table $table
*/
			$table = ( new Query( $this->get_generator()->get_database_prefix() ) )->get_item( $table_id );

			return $this->send_success_response(
				[
					'table_id' => $table_id,
					'values'   => [
						'cart_button'           => $table->get_setting( 'cart_button', $default_cart_button ),
						'quantities'            => $table->get_setting( 'quantities', $default_quantities ),
						'variations'            => $table->get_setting( 'variations', $default_variations ),
						'variation_name_format' => $table->get_setting( 'variation_name_format', $default_variation_name_format ),
					],
				]
			);
		}

		return $this->send_success_response(
			[
				'values' => [
					'cart_button'           => $default_cart_button,
					'quantities'            => $default_quantities,
					'variations'            => $default_variations,
					'variation_name_format' => $default_variation_name_format,
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

		$cart_button           = isset( $values['cart_button'] ) ? $values['cart_button'] : 'title';
		$quantities            = isset( $values['quantities'] ) ? $values['quantities'] : '';
		$variations            = isset( $values['variations'] ) ? $values['variations'] : '';
		$variation_name_format = isset( $values['variation_name_format'] ) ? $values['variation_name_format'] : '';

		/**
	* @var Content_Table $table
*/
		$table          = ( new Query( $this->get_generator()->get_database_prefix() ) )->get_item( $table_id );
		$table_settings = $table->get_settings();

		$table_settings['cart_button']           = $cart_button;
		$table_settings['quantities']            = $quantities;
		$table_settings['variations']            = $variations;
		$table_settings['variation_name_format'] = $variation_name_format;

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
