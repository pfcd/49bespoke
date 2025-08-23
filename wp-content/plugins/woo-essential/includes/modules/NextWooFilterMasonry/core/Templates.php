<?php
/**
 * Return template parts
 */
namespace DNWoo_Essential\Includes\Modules\NextWooFilterMasonry;

defined( 'ABSPATH' ) || die();

class Templates {

	/**
	 * Pagination
	 *
	 * @param mixed $pages
	 * @return string
	 */
	public function pagination( $args ) {
		extract( $args );// phpcs:ignore
		$html = '';
		if ( ($pages == 0) || ($pages == 1) ) {
			return $html = '';
		}

		$page 		= $offset;
		$totalPages = $pages;
		if ( $template == 'numbers' ) {
			ob_start();
			if ( file_exists(plugin_dir_path( __FILE__ ) . '/pagination.php') ) {
				include __DIR__ . '/pagination.php';
			}
			$html = ob_get_clean();
		}
		if ( $template == 'loadmore' ) {
			$loadmore = !empty($loadmore_text) ? $loadmore_text : esc_html__( 'Load More', 'dnwooe' );
			if ( $offset < $pages ) {
				$html = '<ul class="pagination '. $alingment_class .'">
				<li
				class="loadmore"
				data-id=' . intval( $offset + 1 ) .
				'>'
				. $loadmore . '</li></ul>';
			}
		}

		return $html;
	}

	/**
	 * Pagination
	 *
	 * @param mixed $pages
	 * @return string
	 */
	public function products_html( $products, $query ) {
		extract( $query );// phpcs:ignore
		$single = '';
		foreach ( $products as $key => $value ) {
			$product_ratting        = ( 0 < $value->get_rating_count ? '<div class="dnwoo_product_ratting"><div class="star-rating"><span style="width:0%">' . esc_html__( 'Rated', 'dnwooe' ) . ' <strong class="rating">' . esc_html__( '0', 'dnwooe' ) . '</strong> ' . esc_html__( 'out of 5', 'dnwooe' ) . '</span>' . $value->product_rating . '</div></div>' : '' );
			$price_html             = sprintf( '<div class="dnwoo_product_filter_price_wrapper"><div class="dnwoo_product_filter_price">%1$s</div></div>', $value->get_price_html );
			$image                  = sprintf( '<img src="%1$s" alt="Woo Product" />', $value->thumbnail ? $value->thumbnail : dnxte_demo_image() );
			$percentage_text        = ! empty( $dnwoo_badge_percentage ) ? esc_html( $dnwoo_badge_percentage ) : '';
			$percentage             = '' !== $value->percentage ? sprintf( '<div class="dnwoo_product_filter_onsale percent">%1$s %2$s</div>', esc_html( $value->percentage ), $percentage_text ) : '';
			$sale_text 				= '' !== $dnwoo_badge_sale ? sprintf( '<div class="dnwoo_product_filter_onsale">%1$s</div>', esc_html( $dnwoo_badge_sale ) ) : '<div class="dnwoo_product_filter_onsale">' . apply_filters( 'dnwoo_sale_filter', __( 'Sale', 'dnwooe' ) ) . '</div>';
			$on_sale_badge          = ( 'percentage' == $show_badge && $value->is_on_sale ) ? $percentage : ( ( 'sale' == $show_badge && $value->is_on_sale ) ? $sale_text : '' );
			$out_of_stock_badge     = 'outofstock' == $value->stock_status && 'off' == $hide_out_of_stock ? sprintf( '<div class="dnwoo_product_filter_stockout">%1$s</div>', esc_html( $dnwoo_badge_outofstock ) ) : '';
			$value_slug             = implode( ' ', $value->striped_category );
			$chooseSelectOptionIcon = '<span class="icon_menu icon_menu_btn et_pb_icon" data-icon="a"></span>';
			$dataIcon               = '<span class="icon_cart icon_cart_btn et_pb_icon" data-icon=""></span>';
			$product_variant_icon   = $this->_add_to_cart( $value->ID, $value->get_type, $value->permalink, $show_add_to_cart, $dnwoo_show_add_to_cart_text, $select_option_text, $chooseSelectOptionIcon, $dataIcon );
				$featured_badge         = $value->is_featured && 'outofstock' != $value->stock_status && 'on' == $show_featured_product ? sprintf( '<div class="dnwoo_product_filter_featured">%1$s</div>', esc_html( $dnwoo_badge_featured ) ) : '';
			$wishlist_button        = 'on' === $show_wishlist_button ? $this->_add_to_wishlist_icon( $value, $wishlist_text ) : '';
			$compare_button         = 'on' === $show_compare_button ? $this->_product_compare_icon( $value->ID, $compare_text ) : '';
			$quickview_icon         = 'on' === $show_quickview_button ? sprintf(
				'<a href="#" class="dnwoo_product_filter_quick_button dnwoo-quick-btn dnwoo-quickview icon_quickview" data-icon="" data-quickid="%1$s" data-orderclass="%2$s">&nbsp;%3$s</a>',
				$value->ID,
				$order_class,
				$quickview_text
			) : '';

			$single .= sprintf(
				'<div class="dnwoo_product_filter_item product_type_%12$s woocommerce %5$s">
							<div class="dnwoo_product_filter_item_child">
								<a href="%9$s" class="image_link">
									%1$s
									%2$s
									%3$s
									%10$s
								</a>
								<div class="dnwoo_product_filter_badge_btn">
									%4$s
									%13$s
									%14$s
									%15$s
								</div>
							</div>
							<div class="dnwoo_product_filter_bottom_content">
								<a href="%9$s"><%11$s class="dnwoo_product_filter_title">%6$s</%11$s></a>
									%7$s
									%8$s
							</div>
						</div>',
				$image,
				$on_sale_badge,
				$out_of_stock_badge,
				'on' === $show_add_to_cart ? $product_variant_icon : '',
				urldecode( $value_slug ), // 5
				$value->post_title,
				$price_html,
				$product_ratting,
				$value->permalink, // 9
				$featured_badge,
				$tag,
				$value->get_type,
				$wishlist_button,
				$compare_button,
				$quickview_icon
			);
		}

		return $single;
	}

	/*
	* _product_btn function
	*
	*   @param int $product_id ex: 5
	*   @param string $product_type ex: 'variable'
	*   @param string $permalink ex: 'https://www.sitename.com/products/hoodies
	*   @param string $show_add_to_cart
	*   @param string $add_to_cart_text
	*   @param string $select_option_text
	*   @param string $chooseOptionIcon
	*   @param string $cartIcon
	*/
	public function _add_to_cart( $product_id, $product_type, $permalink, $show_add_to_cart, $add_to_cart_text, $select_option_text, $chooseOptionIcon, $cartIcon ) {

		if ( 'variable' === $product_type ) {
			sprintf(
				'<a href="%1$s" class="dnwoo_product_filter_btn product_type_variable dnwoo_choose_variable_option">%3$s %2$s</a>',
				$permalink,
				$select_option_text,
				$chooseOptionIcon
			);
		}
		return sprintf(
			'<a href="%1$s" data-quantity="1" class="dnwoo_product_filter_btn product_type_%3$s dnwoo_product_addtocart add_to_cart_button ajax_add_to_cart dnwoo_cart_text_button" data-product_id="%2$s">%5$s %4$s</a>',
			sprintf( '?add-to-cart=%1$s', $product_id ),
			$product_id,
			$product_type,
			'on' === $show_add_to_cart ? $add_to_cart_text : '',
			$cartIcon
		);
	}
	public function _add_to_wishlist_icon( $product, $wishlist_text, $normalicon = '<span data-icon="" class="icon_heart"></span>', $addedicon = '<span data-icon="" class="icon_heart_alt"></span>' ) {
		global $yith_wcwl;

		if ( ! class_exists( 'YITH_WCWL' ) || empty( get_option( 'yith_wcwl_wishlist_page_id' ) ) ) {
			return '';
		}

		$url          = YITH_WCWL()->get_wishlist_url();
		$product_type = $product->get_type;
		$exists       = $yith_wcwl->is_product_in_wishlist( $product->ID );
		$classes      = 'class="add_to_wishlist dnwoo-filter-wishlist-btn"';
		$add          = get_option( 'yith_wcwl_add_to_wishlist_text' );
		$browse       = get_option( 'yith_wcwl_browse_wishlist_text' );
		$added        = get_option( 'yith_wcwl_product_added_text' );

		$wishlist_text = isset( $wishlist_text ) ? '&nbsp;' . $wishlist_text : '';

		$output = '';

		$output .= '<div class="wishlist button-default yith-wcwl-add-to-wishlist add-to-wishlist-' . esc_attr( $product->ID ) . '">';
		$output .= '<div class="yith-wcwl-add-button';
		$output .= $exists ? ' hide" style="display:none;"' : ' show"';
		$output .= '><a href="' . esc_url( htmlspecialchars( YITH_WCWL()->get_wishlist_url() ) ) . '" data-product-id="' . esc_attr( $product->ID ) . '" data-product-type="' . esc_attr( $product_type ) . '" ' . $classes . ' >' . $normalicon . $wishlist_text . '</a>';
		$output .= '<i class="fa fa-spinner fa-pulse ajax-loading" style="visibility:hidden"></i>';
		$output .= '</div>';

		$output .= '<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;"><a class="dnwoo-filter-wishlist-btn" href="' . esc_url( $url ) . '">' . $addedicon . $wishlist_text . '</a></div>';
		$output .= '<div class="yith-wcwl-wishlistexistsbrowse ' . ( $exists ? 'show' : 'hide' ) . '" style="display:' . ( $exists ? 'block' : 'none' ) . '"><a href="' . esc_url( $url ) . '" class="dnwoo-filter-wishlist-btn dnwoo-product-action-btn">' . $addedicon . $wishlist_text . '</a></div>';
		$output .= '</div>';
		return $output;
	}

	public function _product_compare_icon( $product_id, $compare_text ) {
		if ( ! class_exists( 'YITH_Woocompare' ) ) {
			return '';
		}

		$comp_link    = home_url() . '?action=yith-woocompare-add-product';
		$comp_link    = add_query_arg( 'id', $product_id, $comp_link );
		$compare_text = isset( $compare_text ) ? $compare_text : '';

		$output = '';

		$output .= '<div class="woocommerce product compare-button">';
		$output .= '<a href="' . esc_url( $comp_link ) . '" class="dnwoo-product-compare-btn compare icon_compare"  data-product_id="' . esc_attr( $product_id ) . '" rel="nofollow">' . $compare_text . '</a></div>';
		$output .= '</div">';

		return $output;
	}
}
