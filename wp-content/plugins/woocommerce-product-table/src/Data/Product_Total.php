<?php

namespace Barn2\Plugin\WC_Product_Table\Data;

use Barn2\Plugin\WC_Product_Table\Util\Util;
use WC_Product;

/**
 * Gets data for the name column.
 *
 * @package   Barn2\woocommerce-product-table
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Product_Total extends Abstract_Product_Data {


	private $variation_format;

	/**
	 * Create a new Product_Name object.
	 *
	 * @param WC_Product $product The product.
	 */
	public function __construct( WC_Product $product ) {
		parent::__construct( $product );
	}

	public function get_data() {
		$price_format               = get_woocommerce_price_format();
		$currency_symbol            = get_woocommerce_currency_symbol();
		$price_format_with_currency = sprintf( $price_format, $currency_symbol, 0 );

		return apply_filters( 'wc_product_table_product_default_price', $price_format_with_currency );
	}
}
