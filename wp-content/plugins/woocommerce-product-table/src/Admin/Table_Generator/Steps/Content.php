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
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Util as Table_Generator_Util;
use Barn2\Plugin\WC_Product_Table\Util\Util;
use Barn2\Plugin\WC_Product_Table\Util\Settings as Settings_Util;

/**
 * Handles generation of the include and exclude parameters.
 */
class Content extends Step {

	public $id = 'refine';

	/**
	 * Get things started.
	 */
	public function init() {
		$this->set_id( 'refine' );
		$this->set_name( __( 'Content', 'woocommerce-product-table' ) );
		$this->set_title( __( 'Select your products', 'woocommerce-product-table' ) );
		$this->set_fields( $this->get_fields_list() );
		$this->set_extra_data(
			[
				'name_manual'           => __( 'Content', 'woocommerce-product-table' ),
				'title_manual'          => __( 'Select your products', 'woocommerce-product-table' ),
				'name_shop_page'        => __( 'Location', 'woocommerce-product-table' ),
				'title_shop_page'       => __( 'Location', 'woocommerce-product-table' ),
				'description_shop_page' => __( 'Select the shop templates where you want to display this table.', 'woocommerce-product-table' ),
			]
		);

		add_filter( 'barn2_table_generator_api_response_data', [ $this, 'remove_product_visibility_options' ], 10, 3 );
		add_filter( 'barn2_table_generator_table_settings', [ $this, 'remove_templates_options_on_shortcode_table' ], 10 );
	}

	/**
	 * Define list of fields.
	 *
	 * @return array
	 */
	public function get_fields_list() {

		$edit_url = admin_url( 'edit.php?post_type=product&page=tables#/edit/' );

		// Get all already selected templates.
		$shop_templates_tables = Util::get_shop_templates_tables();

		$checkbox_conditions = [
			'table_display' => [
				'op'    => 'eq',
				'value' => 'shop_page',
			],
		];

		$fields = [
			[
				'label'      => __( 'Which products?', 'woocommerce-product-table' ),
				'name'       => 'refine',
				'type'       => 'refine',
				'value'      => '',
				'conditions' => [
					'table_display' => [
						'op'    => 'eq',
						'value' => 'manual',
					],
				],
			],
			[
				'title'      => isset( $_GET['add-new'] ) ? __( 'Select templates', 'woocommerce-product-table' ) : __( 'Templates', 'woocommerce-product-table' ),
				'label'      => __( 'Shop page', 'woocommerce-product-table' ) . ( in_array( 'shop_override', array_keys( $shop_templates_tables ), true ) ? '<span class="barn2-checkbox-control__label-description"><i>Selected on: <a href="' . $edit_url . $shop_templates_tables['shop_override']['id'] . '" target="_blank">' . $shop_templates_tables['shop_override']['title'] . '</a></i></span>' : '' ),
				'name'       => 'shop_override',
				'type'       => 'checkbox',
				'border'     => false,
				'classes'    => [
					'first-checkbox td-pad' . ( in_array( 'shop_override', array_keys( $shop_templates_tables ), true ) ? ' disabled' : '' ),
				],
				'value'      => '',
				'disabled'   => in_array( 'shop_override', array_keys( $shop_templates_tables ), true ),
				'conditions' => $checkbox_conditions,
			],
			[
				'label'      => __( 'Product search results', 'woocommerce-product-table' ) . ( in_array( 'search_override', array_keys( $shop_templates_tables ), true ) ? '<span class="barn2-checkbox-control__label-description"><i>Selected on: <a href="' . $edit_url . $shop_templates_tables['search_override']['id'] . '" target="_blank">' . $shop_templates_tables['search_override']['title'] . '</a></i></span>' : '' ),
				'name'       => 'search_override',
				'type'       => 'checkbox',
				'border'     => false,
				'classes'    => [
					'no-top-pad' . ( in_array( 'search_override', array_keys( $shop_templates_tables ), true ) ? ' disabled' : '' ),
				],
				'class'      => 'no-top-pad',
				'value'      => '',
				'disabled'   => in_array( 'search_override', array_keys( $shop_templates_tables ), true ),
				'conditions' => $checkbox_conditions,
			],
			[
				'label'      => __( 'Product categories', 'woocommerce-product-table' ) . ( in_array( 'archive_override', array_keys( $shop_templates_tables ), true ) ? '<span class="barn2-checkbox-control__label-description"><i>Selected on: <a href="' . $edit_url . $shop_templates_tables['archive_override']['id'] . '" target="_blank">' . $shop_templates_tables['archive_override']['title'] . '</a></i></span>' : '' ),
				'name'       => 'archive_override',
				'type'       => 'checkbox',
				'border'     => false,
				'classes'    => [
					'no-top-pad' . ( in_array( 'archive_override', array_keys( $shop_templates_tables ), true ) ? ' disabled' : '' ),
				],
				'value'      => '',
				'disabled'   => in_array( 'archive_override', array_keys( $shop_templates_tables ), true ),
				'conditions' => $checkbox_conditions,
			],
			[
				'label'      => __( 'Product tags', 'woocommerce-product-table' ) . ( in_array( 'product_tag_override', array_keys( $shop_templates_tables ), true ) ? '<span class="barn2-checkbox-control__label-description"><i>Selected on: <a href="' . $edit_url . $shop_templates_tables['product_tag_override']['id'] . '" target="_blank">' . $shop_templates_tables['product_tag_override']['title'] . '</a></i></span>' : '' ),
				'name'       => 'product_tag_override',
				'type'       => 'checkbox',
				'border'     => false,
				'classes'    => [
					'no-top-pad' . ( in_array( 'product_tag_override', array_keys( $shop_templates_tables ), true ) ? ' disabled' : '' ),
				],
				'checked'    => false,
				'disabled'   => in_array( 'product_tag_override', array_keys( $shop_templates_tables ), true ),
				'conditions' => $checkbox_conditions,
			],
			[
				'label'      => __( 'Product attributes', 'woocommerce-product-table' ) . ( in_array( 'attribute_override', array_keys( $shop_templates_tables ), true ) ? '<span class="barn2-checkbox-control__label-description"><i>Selected on: <a href="' . $edit_url . $shop_templates_tables['attribute_override']['id'] . '" target="_blank">' . $shop_templates_tables['attribute_override']['title'] . '</a></i></span>' : '' ),
				'name'       => 'attribute_override',
				'type'       => 'checkbox',
				'border'     => false,
				'classes'    => [
					'no-top-pad' . ( in_array( 'attribute_override', array_keys( $shop_templates_tables ), true ) ? ' disabled' : '' ),
				],
				'value'      => '',
				'disabled'   => in_array( 'attribute_override', array_keys( $shop_templates_tables ), true ),
				'conditions' => $checkbox_conditions,
			],
		];

		// Custom taxonomies.
		$settings                  = [];
		$custom_product_taxonomies = Util::get_custom_product_taxonomies();
		foreach ( $custom_product_taxonomies as $taxonomy_name => $taxonomy_label ) {
			$settings[] = [
				'label'      => ucfirst( $taxonomy_label ) . ' - <code>' . $taxonomy_name . '</code>' . ( in_array( $taxonomy_name . '_override', array_keys( $shop_templates_tables ), true ) ? '<span class="barn2-checkbox-control__label-description"><i>Selected on: <a href="' . $edit_url . $shop_templates_tables[ $taxonomy_name . '_override' ]['id'] . '" target="_blank">' . $shop_templates_tables[ $taxonomy_name . '_override' ]['title'] . '</a></i></span>' : '' ),
				'name'       => $taxonomy_name . '_override',
				'type'       => 'checkbox',
				'border'     => false,
				'classes'    => [
					'no-top-pad' . ( in_array( $taxonomy_name . '_override', array_keys( $shop_templates_tables ), true ) ? ' disabled' : '' ),
				],
				'value'      => '',
				'disabled'   => in_array( $taxonomy_name . '_override', array_keys( $shop_templates_tables ), true ),
				'conditions' => $checkbox_conditions,
			];
		}
		$fields = array_merge( $fields, $settings );

		$fields[ count( $fields ) - 1 ]['classes'] = [ $fields[ count( $fields ) - 1 ]['classes'][0] . ' bottom-pad' ];

		if ( ! isset( $_GET['add-new'] ) ) {
			$fields = array_map(
				function ( $item ) {
					if ( isset( $item['label'] ) ) {
							$item['desc']  = $item['label'];
							$item['label'] = '';
					}
					if ( isset( $item['title'] ) ) {
							$item['label'] = $item['title'];
							unset( $item['title'] );
					}
					return $item;
				},
				$fields
			);

			$fields[0]['label'] = $fields[0]['desc'];
			unset( $fields[0]['desc'] );
		}

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

			$refine = $table->get_setting( 'refine', [] );

			$values = [
				'refine'               => $refine['refinements'] ?? [],
				'refine_mode'          => $table->get_setting( 'refine_mode', 'all' ),
				'shop_override'        => $table->get_setting( 'shop_override', false ),
				'search_override'      => $table->get_setting( 'search_override', false ),
				'archive_override'     => $table->get_setting( 'archive_override', false ),
				'product_tag_override' => $table->get_setting( 'product_tag_override', false ),
				'attribute_override'   => $table->get_setting( 'attribute_override', false ),
			];

			// Custom taxonomies
			$custom_product_taxonomies = Util::get_custom_product_taxonomies();
			foreach ( $custom_product_taxonomies as $taxonomy_name => $taxonomy_label ) {
				$values[ $taxonomy_name . '_override' ] = $table->get_setting( $taxonomy_name . '_override', false );
			}

			return $this->send_success_response(
				[
					'table_id' => $table_id,
					'values'   => $values,
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

		// Default taxonomies.
		$default_taxonomies = [ 'shop', 'search', 'archive', 'product_tag', 'attribute', 'wholesale_store' ];

		// Custom taxonomies.
		$custom_product_taxonomies = array_keys( Util::get_custom_product_taxonomies() );

		// All taxonomies.
		$taxonomies = array_merge( $default_taxonomies, $custom_product_taxonomies );

		/**
	* @var Content_Table $table
*/
		$table          = ( new Query( $this->get_generator()->get_database_prefix() ) )->get_item( $table_id );
		$table_settings = $table->get_settings();

		$taxonomies_values = [];
		foreach ( $taxonomies as $taxonomy_name ) {
			unset( $table_settings[ $taxonomy_name . '_override' ] );
			if ( isset( $values[ $taxonomy_name . '_override' ] ) && $values[ $taxonomy_name . '_override' ] ) {
				$taxonomies_values[ $taxonomy_name . '_override' ] = $values[ $taxonomy_name . '_override' ];
			}
		}

		if ( $values['table_display'] === 'shop_page' && empty( $taxonomies_values ) ) {
			return $this->send_error_response(
				[
					'message' => __( 'Please select one or more templates.', 'woocommerce-product-table' ),
				]
			);
		}

		$refine_mode = $values['refine']['mode'] ? $values['refine']['mode'] : 'all';
		$formatted   = $this->prepare_parameters( $values['refine']['refinements'] );

		$table_settings['refine']      = [
			'mode'        => $refine_mode,
			'refinements' => $formatted,
		];
		$table_settings['refine_mode'] = $refine_mode;

		$table_settings = array_merge( $table_settings, $taxonomies_values );

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

	/**
	 * Loop through parameters and format each and every one of them.
	 *
	 * @param  array $parameters
	 * @return array
	 */
	public static function prepare_parameters( $parameters ) {

		$formatted = [];

		foreach ( $parameters as $parameter_key => $parameter_config ) {
			// Skip empty or false parameters or _data parameters.
			if ( empty( $parameter_config ) || Table_Generator_Util::string_ends_with( $parameter_key, '_data' ) ) {
				continue;
			}

			$data = isset( $parameters[ "{$parameter_key}_data" ] ) ? $parameters[ "{$parameter_key}_data" ] : [];

			if ( empty( $data ) ) {
				continue;
			}

			$is_taxonomy = isset( $data['terms'] );
			$is_cf       = $parameter_key === 'cf';
			$is_stati    = $parameter_key === 'status';
			$is_author   = $parameter_key === 'author';
			$is_include  = $parameter_key === 'include';
			$is_mime     = $parameter_key === 'mime';

			if ( $is_taxonomy ) {
				$data = self::format_terms( $data );
			} elseif ( $is_cf ) {
				$data = self::format_cf( $data );
			} elseif ( $is_stati ) {
				$data = self::format_stati( $data );
			} elseif ( $is_author || $is_include ) {
				$data = self::unset_name( $data );
			} elseif ( $is_mime ) {
				$data = array_filter( array_map( 'trim', explode( ',', $data ) ) );
			}

			if ( $data instanceof \WP_Error || empty( $data ) ) {
				continue;
			}

			$formatted[ $parameter_key ] = $data;
		}

		return $formatted;
	}

	/**
	 * Format terms data.
	 *
	 * Basically we just remove the "name" property here
	 * and then check the value of the "match" property.
	 *
	 * @param  array $data
	 * @return array
	 */
	public static function format_terms( $data ) {

		$terms = Table_Generator_Util::array_unset_recursive( $data['terms'], 'name' );
		$match = isset( $data['match'] ) && ! empty( $data['match'] );

		return [
			'terms' => $terms,
			'match' => $match,
		];
	}

	/**
	 * Format custom fields - validate that all inputs are filled.
	 *
	 * @param  array $data
	 * @return array|\WP_Error
	 */
	public static function format_cf( $data ) {

		foreach ( $data as $field ) {

			$name  = isset( $field['name'] ) ? $field['name'] : false;
			$value = isset( $field['value'] ) ? $field['value'] : false;

			if ( empty( $name ) || empty( $value ) ) {
				return new \WP_Error( 'barn2-generator-cf-empty', __( 'Custom field must contain both the name and value.', 'woocommerce-product-table' ) );
			}
		}

		return $data;
	}

	/**
	 * Format status data.
	 *
	 * Basically we just remove the "label" property here
	 * and then check the value of the "match" property.
	 *
	 * @param  array $data
	 * @return array
	 */
	public static function format_stati( $data ) {
		$stati = Table_Generator_Util::array_unset_recursive( $data['stati'], 'label' );
		$match = isset( $data['match'] ) && ! empty( $data['match'] );

		return [
			'stati' => $stati,
			'match' => $match,
		];
	}

	/**
	 * Format author data.
	 * Basically we just remove the "name" and "label" property here.
	 *
	 * @param  array $data
	 * @return array
	 */
	public static function unset_name( $data ) {
		$data = Table_Generator_Util::array_unset_recursive( $data, 'name' );
		$data = Table_Generator_Util::array_unset_recursive( $data, 'label' );
		return $data;
	}

	/**
	 * Remove product visibility options.
	 *
	 * @param  array  $data
	 * @param  string $class_function
	 * @param  string $response_type
	 * @return array
	 */
	public function remove_product_visibility_options( $data, $class_function, $response_type ) {
		if ( isset( $class_function['class'] ) && basename( str_replace( '\\', '/', $class_function['class'] ) ) === 'Terms' && isset( $data['terms'][0]->taxonomy ) && $data['terms'][0]->taxonomy === 'product_visibility' ) {
			foreach ( $data['terms'] as $key => $term ) {
				$data['terms'][ $key ]->name = str_replace( '-', ' ', $term->name );
				if ( in_array( $term->slug, [ 'rated-1', 'rated-2', 'rated-3', 'rated-4', 'rated-5', 'outofstock' ], true ) ) {
					unset( $data['terms'][ $key ] );
				}
			}
			return $data;
		}
		return $data;
	}

	/**
	 * Removes all templates options if table is shown using a shortcode.
	 *
	 * @param  array $settings
	 * @return array
	 */
	public function remove_templates_options_on_shortcode_table( $settings ) {
		if ( $settings['table_display'] === 'manual' ) {
			$settings = array_filter(
				$settings,
				function ( $k ) {
					return strpos( $k, '_override' ) === false;
				},
				ARRAY_FILTER_USE_KEY
			);
		}
		return $settings;
	}
}
