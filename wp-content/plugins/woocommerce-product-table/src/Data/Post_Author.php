<?php

namespace Barn2\Plugin\WC_Product_Table\Data;

use WC_Product;

/**
 * Gets data for the post author column.
 *
 * @package   Barn2\woocommerce-product-table
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Post_Author extends Abstract_Product_Data {

	/**
	 * Create a new Post_Author object.
	 *
	 * @param WC_Product $product          The product.
	 */
	public function __construct( WC_Product $product, $links ) {
		parent::__construct( $product, $links );
	}

	public function get_data() {
		if ( array_intersect( [ 'all', 'author' ], $this->links ) ) {
			$author = get_the_author_posts_link();
		} else {
			$author = get_the_author();
		}

		return apply_filters( 'wc_product_table_data_author', $author, $this->product );
	}

}