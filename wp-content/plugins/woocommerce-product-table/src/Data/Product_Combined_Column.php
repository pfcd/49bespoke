<?php

namespace Barn2\Plugin\WC_Product_Table\Data;

use Barn2\Plugin\WC_Product_Table\Util\Columns;

/**
 * Gets data for the combined column.
 *
 * @package   Barn2\woocommerce-product-table
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Product_Combined_Column extends Abstract_Product_Data {

	private $combined_columns;
	private $args;

	/**
	 * Constructor.
	 *
	 * @param WC_Product $product          The product object
	 * @param string     $combined_columns The columns shortcode argument
	 * @param string     $args             The shortcode arguments
	 */
	public function __construct( $product, $combined_columns, $args ) {
		parent::__construct( $product );

		$this->combined_columns = $combined_columns;
		$this->args             = $args;
	}

	/**
	 * Get the product combined column data.
	 *
	 * @return string
	 */
	public function get_data() {
		$combined_column = '';

		$data_factory = new Data_Factory( $this->args );

		$combined_columns_blocks = explode( ';', $this->combined_columns );

		foreach ( $combined_columns_blocks as $key => $column_blocks ) {

			$combined_columns = explode( ',', $column_blocks );

			foreach ( $combined_columns as $key2 => $column ) {

				$column_name = Columns::get_column_slug( $column );

				if ( $data_obj = $data_factory->create( $column_name, $this->product ) ) {

					if ( $data = $data_obj->get_data() ) {

						if ( $key2 == 0 ) {
							$combined_column .= '<div class="combined-column-block">';
						}

						$column_label = '';
						$prefix       = strtok( $column, ':' );
						if ( in_array( $prefix, [ 'cf', 'tax', 'att' ] ) ) {
							$prefix       = strtok( ':' );
							$column_label = strtok( '' );
						} else {
							$column_label = strtok( '' );
						}
						if ( $column_label ) {
							$column_label = str_replace( '{comma}', ',', str_replace( '{semicolon}', ';', $column_label ) );
							$column_label = '<span class="combined-column-label">' . wp_kses_post( $column_label ) . ':</span>';
						}

						$combined_column .= '<span class="combined-column combined-column-' . esc_attr( $column_name ) . '">' . ( $column_label ? wp_kses_post( $column_label ) . ' ' : '' ) . $data . '</span>';

						if ( $key2 == count( $combined_columns ) - 1 ) {
							$combined_column .= '</div>';
						}
					}
				}
			}
		}

		/**
		 * Filter the combined column data for the product table.
		 *
		 * This filter allows modification of the combined column data before it is returned.
		 *
		 * @param string $combined_column The combined column data.
		 * @param WC_Product $product The product object.
		 * @param array $combined_columns The array of combined columns.
		 * @param array $args Additional arguments.
		 */
		return apply_filters( 'wc_product_table_data_combined_column', $combined_column, $this->product, $this->combined_columns, $this->args );
	}
}
