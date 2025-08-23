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

/**
 * First step of the wizard.
 */
class Create extends Step {

	public $id = 'create';

	/**
	 * Get things started.
	 */
	public function init() {
		$this->set_id( 'create' );
		$this->set_name( __( 'Create', 'woocommerce-product-table' ) );
		$this->set_title( __( 'Create a table', 'woocommerce-product-table' ) );
		$this->set_fields( $this->get_fields_list() );
	}

	/**
	 * Define list of fields.
	 *
	 * @return array
	 */
	public function get_fields_list() {

		// $registered_types = [ '' => __( 'Select a content type' ) ];
		// $registered_types = array_merge( $registered_types, Util::get_registered_post_types() );

		// $registered_types_options = Util::parse_array_for_dropdown( $registered_types );
		// $registered_types_options[0]['disabled'] = 'disabled';

		$fields = [
			[
				'type'        => 'text',
				'label'       => __( 'Table name', 'woocommerce-product-table' ),
				'name'        => 'name',
				'description' => __( 'Give your table a name to help you identify it later (e.g. “Products in the Clothing category”)', 'woocommerce-product-table' ),
				'value'       => '',
				'placeholder' => __( 'Name', 'woocommerce-product-table' ),
			],
			/*
			[
			'type'        => 'select',
			'label'       => __( 'How do you want to add the table to your store?' ),
			'name'        => 'content_type',
			'value'       => '',
			'placeholder' => __( 'Name' ),
			'options'     => $registered_types_options,
			],
			*/
			[
				'type'    => 'radio',
				'label'   => isset( $_GET['add-new'] ) ? __( 'How do you want to add the table to your store?', 'woocommerce-product-table' ) : __( 'Display', 'woocommerce-product-table' ),
				'name'    => 'table_display',
				'value'   => '',
				'options' => [
					[
						'value' => 'manual',
						'label' => __( 'Add to a page using a block or shortcode', 'woocommerce-product-table' ),
					],
					[
						'value' => 'shop_page',
						'label' => __( 'Display on a shop page (e.g. main storefront, category page, etc.)', 'woocommerce-product-table' ),
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

		if ( ! empty( $table_id ) ) {
			/**
		* @var Content_Table $table
*/
			$table = ( new Query( $this->get_generator()->get_database_prefix() ) )->get_item( $table_id );

			if ( $table instanceof Content_Table ) {
				return $this->send_success_response(
					[
						'table_id' => $table_id,
						'values'   => [
							'name'          => $table->get_title(),
							'content_type'  => 'product',
							'table_display' => $table->get_setting( 'table_display', 'manual' ),
						],
					]
				);
			}
		}

		$default_options = $this->get_generator()->get_default_options();

		return $this->send_success_response(
			[
				'values' => [
					'name'          => '',
					'content_type'  => 'product',
					'table_display' => isset( $default_options['table_display'] ) ? $default_options['table_display'] : 'manual',
				],
			]
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function save_data( $request ) {
		$values = $this->get_submitted_values( $request );

		$name          = $values['name'] ?? false;
		$content_type  = 'product';
		$table_display = $values['table_display'] ?? false;

		// A table ID might be sent through when editing an existing table.
		$table_id = $request->get_param( 'table_id' );

		if ( empty( $name ) || empty( $table_display ) ) {
			return $this->send_error_response(
				[
					'message' => __( 'Please enter a name for the table.', 'woocommerce-product-table' ),
				]
			);
		}

		$query = new Query( $this->get_generator()->get_database_prefix() );

		// Maybe update existing table or create a new one.
		if ( ! empty( $table_id ) ) {
			$existing_table = $query->get_item( $table_id );

			if ( $existing_table instanceof Content_Table ) {

				$settings                  = $existing_table->get_settings();
				$settings['content_type']  = $content_type;
				$settings['table_display'] = $table_display;

				$query->update_item(
					$table_id,
					[
						'title'    => stripslashes( $name ),
						'settings' => wp_json_encode( $settings ),
					]
				);

			}
		} else {
			$table_id = $query->add_item(
				[
					'title'    => stripslashes( $name ),
					'settings' => wp_json_encode(
						[
							'content_type'  => $content_type,
							'table_display' => $table_display,
						]
					),
				]
			);
		}

		return $this->send_success_response(
			[
				'table_id' => $table_id,
			]
		);
	}
}
