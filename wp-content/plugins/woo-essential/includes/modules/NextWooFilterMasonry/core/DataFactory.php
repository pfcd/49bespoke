<?php
/**
 * Return data for rendering into template
 */
namespace DNWoo_Essential\Includes\Modules\NextWooFilterMasonry;

defined( 'ABSPATH' ) || die();

class DataFactory {
	public function get_settings_data( $args ) {

		$data = array(
			'show_sub_categories'   => 'off',
			'products_number'       => 10,
			'order'                 => '',
			'orderby'               => '',
			'offset'                => '',
			'type'                  => '',
			'include_categories'    => '',
			'hide_out_of_stock'     => '',
			'thumbnail_size'        => '',
			'show_rating'           => '',
			'show_price_text'       => '',
			'show_add_to_cart'      => '',
			'show_badge'            => '',
			'show_featured_product' => '',
			'show_wishlist_button'  => '',
			'show_compare_button'   => '',
			'show_quickview_button' => '',
			'show_rating_filter'    => 'off',
			'show_all_clear'    	=> 'off',
			'show_pagination'       => 'numbers',
			'loadmore_text'       	=> esc_html__('Load More', 'dnwooe' )
		);

		if ( empty( $args ) ) {
			return $data;
		}

		$data['show_badge']            = $args['show_badge'];
		$data['hide_out_of_stock']     = $args['hide_out_of_stock'];
		$data['include_categories']    = $args['include_categories'];
		$data['offset']                = $args['offset'];
		$data['type']                  = $args['type'];
		$data['orderby']               = $args['orderby'];
		$data['order']                 = $args['order'];
		$data['products_number']       = $args['products_number'];
		$data['show_sub_categories']   = $args['show_sub_categories'];
		$data['thumbnail_size']        = $args['thumbnail_size'];
		$data['show_rating']           = $args['show_rating'];
		$data['loadmore_text']         = $args['loadmore_text'];
		$data['show_price_text']       = $args['show_price_text'];
		$data['show_add_to_cart']      = $args['show_add_to_cart'];
		$data['show_featured_product'] = $args['show_featured_product'];
		$data['show_wishlist_button']  = $args['show_wishlist_button'];
		$data['show_compare_button']   = $args['show_compare_button'];
		$data['show_quickview_button'] = $args['show_quickview_button'];
		$data['show_pagination']       = $args['show_pagination'];
		// divi
		$data['header_level']                = $args['header_level'];
		$data['tag']                         = et_pb_process_header_level( $args['header_level'], 'h3' ); // if you add tag change option. header_level parent name array must header.
		$data['dnwoo_badge_outofstock']      = $args['dnwoo_badge_outofstock'];
		$data['dnwoo_show_add_to_cart_text'] = $args['dnwoo_show_add_to_cart_text'];
		$data['dnwoo_badge_sale']            = $args['dnwoo_badge_sale'];
		$data['dnwoo_badge_percentage']      = $args['dnwoo_badge_percentage'];
		$data['dnwoo_badge_featured']        = $args['dnwoo_badge_featured'];
		$data['show_filter_menu']            = $args['show_filter_menu'];
		$data['wishlist_text']               = $args['dnwoo_wishlist_text'];
		$data['compare_text']                = $args['dnwoo_compare_text'];
		$data['quickview_text']              = $args['dnwoo_quickview_text'];
		$data['show_rating_filter']          = $args['show_rating_filter'];
		$data['show_all_clear']          	 = $args['show_all_clear'];

		return $data;
	}
}
