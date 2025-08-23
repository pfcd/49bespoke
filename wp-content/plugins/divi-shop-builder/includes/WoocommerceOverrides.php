<?php

defined( 'ABSPATH' ) || exit;

use simplehtmldom\HtmlDocument;

/**
 * Override/Setup woocommerce cart and checkout
 *
 */
class DSWCP_WoocomemrceOverrides {

	const WRAP_BY_SECTION = 'section';
	const WRAP_BY_ROW 	  = 'row';

	protected $cart_modules 	= [
		'ags_woo_cart_list' // modules/WooCartList
	];

	protected $checkout_modules = [
		'ags_woo_checkout_coupon', 	   	 // modules/WooCheckoutCoupon
		'ags_woo_checkout_billing_info', // modules/WooCheckoutBillingInfo
		'ags_woo_checkout_shipping_info',// modules/WooCheckoutBillingInfo
		'ags_woo_checkout_order_review'  // modules/WooCheckoutOrderReview
	];

	public function __construct() {

		$this->init_hooks();
	}

	public function init_hooks(){
		add_filter( 'body_class', array( $this, 'body_classes' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 99 );
		add_filter( 'et_builder_inner_content_class', array( $this, 'inner_content_woocommrece_class' ) );
		add_filter( 'the_content', array( $this, 'checkout_output' ), 99, 1 );
		add_filter( 'et_builder_render_layout', array( $this, 'checkout_output' ), 99, 1 );
		add_action( 'template_redirect', array( $this, 'thankyou_page_redirect' ), 1); // has to validate if this is correct way
		
		add_filter('woocommerce_update_order_review_fragments', [$this, 'filterOrderReviewFragments']);
	}
	
	public function filterOrderReviewFragments($fragments) {
		$excludeSelectors = [
			'#zdelivery-options' => false
		]; // these selectors are not overridden
		
		$checkoutPageId = get_option('woocommerce_checkout_page_id');
		if ( $checkoutPageId && get_post_meta($checkoutPageId, '_et_pb_use_builder' == 'on') ) {
			preg_match( '/'.get_shortcode_regex(['ags_woo_checkout_order_review']).'/', get_post($checkoutPageId)->post_content, $foundShortcode );
			if ($foundShortcode) {
				$orderReviewHtml = new HtmlDocument( do_shortcode($foundShortcode[0]) );
				foreach (array_diff_key($fragments, $excludeSelectors) as $selector => &$content) {
					$newContent = $orderReviewHtml->find($selector, 0);
					if ($newContent) {
						$content = $newContent->outertext;
					}
				}
			}
		}
		return $fragments;
	}

	public function body_classes( $classes ){

		if( $this->has_shortcode( $this->cart_modules ) ){
			$classes[] = 'woocommerce-cart';
			$classes[] = 'woocommerce-page';
		}

		if( $this->has_shortcode( $this->checkout_modules ) ){
			$classes[] = 'woocommerce-checkout';
			$classes[] = 'woocommerce-page';
		}

		return $classes;
	}

	public function enqueue_scripts(){

		global $dswcp;

		$is_fb_active = function_exists( 'et_fb_is_enabled' ) && et_fb_is_enabled();

		if( $this->has_shortcode( $this->cart_modules ) || $is_fb_active ){
			wp_enqueue_script( 'wc-cart' );
		}

		if( $this->has_shortcode( $this->checkout_modules ) || $is_fb_active ){
			wp_enqueue_style('select2');

			wp_enqueue_script( 'selectWoo' );
			wp_enqueue_script( 'wc-checkout' );
		}

		if( $this->has_shortcode( $this->checkout_modules ) && wp_script_is( 'wc-address-i18n' ) ){
			wp_deregister_script( 'wc-address-i18n' );
			wp_dequeue_script( 'wc-address-i18n' );
			wp_enqueue_script( 'wc-address-i18n', $dswcp->plugin_dir_url . 'includes/js/wc-override/address-i18n.js', array( 'jquery', 'wc-country-select' ), WC_VERSION, true );
		}

		// woo quick view plugin conflict
		if( et_fb_is_enabled() ){
			wp_dequeue_script( 'wc-add-to-cart-variation' );
		}

		wp_enqueue_script( 'woofilters', $dswcp->plugin_dir_url . 'includes/js/woo-products-filters'.(SCRIPT_DEBUG ? '' : '.min').'.js', array( 'jquery', 'wp-i18n' ), AGS_divi_wc::PLUGIN_VERSION, true );
		wp_set_script_translations('woofilters', 'divi-shop-builder', $dswcp->plugin_dir_url . 'languages');

	}

	private function has_shortcode( $shortcodes ){

		$available = array_filter( $shortcodes, function( $shortcode ){
			return has_shortcode( get_the_content(), $shortcode );
		});

		return count( $available ) > 0;
	}


	public function inner_content_woocommrece_class( $classes ){

		if( et_fb_is_enabled() ){
			return $classes;
		}

		if( $this->has_shortcode( $this->cart_modules ) || $this->has_shortcode( $this->checkout_modules ) ){
			$classes[] = "woocommerce";
		}

		return $classes;
	}

	public function has_checkout_module_class($html) {
		foreach ($this->checkout_modules as $module) {
			if (strpos($html, $module.' ') !== false || strpos($html, ' '.$module) !== false) {
				return true;
			}
		}
		return false;
	}


	/**
	 * Process content of woocommerce checkout
	 *
	 */
	public function checkout_output( $content ){

		global $wp;

		if( !$this->has_shortcode( $this->checkout_modules ) ){
			return $content;
		}
		
		// Extra safeguard - shouldn't be necessary
		if (!$this->has_checkout_module_class($content)) {
			return $content;
		}

		if ( is_null( WC()->cart ) ) {
			return;
		}
		
		// phpcs:disable WordPress.Security.NonceVerification.Recommended -- just testing flags
		$is_woo_checkout = ( isset( $_GET['order'] ) && isset( $_GET['key'] ) ) || ! empty( $wp->query_vars['order-pay'] ) || isset( $wp->query_vars['order-received'] );

		/**
		 * if order-pay or order-received url
		 * process woocommerce checkout shortcode
		 *
		 */
		if( $is_woo_checkout ){
			return do_shortcode( '[et_pb_section][et_pb_row][et_pb_column][et_pb_text][woocommerce_checkout][/et_pb_text][/et_pb_column][/et_pb_row][/et_pb_section]' );
		}

		return $this->inject_checkout_form_wrapper( $content );
	}


	/**
	 * Wrap checkout modules with forms
	 *
	 * @return HTML
	 */
	protected function inject_checkout_form_wrapper( $content ){

		$dom 		  = new HtmlDocument();
		$content_html = $dom->load( $content );

		$modules_selector =  '.' . implode( ', .', array_slice( $this->checkout_modules, 1 ) );
		$modules 		  = $content_html->find( $modules_selector );

		// bail out if no modules found in content
		if( !count( $modules ) ){
			return $content;
		}

		$first_index = $last_index = $first_row_index = $last_row_index = null;
		$wrap_by 	 = self::WRAP_BY_SECTION;
		$new_content = '';

		foreach( $content_html->find( '.et_pb_section' ) as $index => $section  ){
			
			if ( $first_index === null && !$section->find( $modules_selector ) ) {
				// We haven't found a section with the relevant modules yet, and this ain't it
				continue;
			}
			
			if ( $first_index === null ) {
				// We have found an instance of the relevant modules, and this is the first section where we've found them
				$first_index = $index;
				
				// Check if this section has rows with forms from modules other than the relevant modules, in which case we
				// need to wrap by row instead of wrapping the entire section
				foreach ( $section->find( '.et_pb_row' ) as $r_index => $row ) {

					if( $row->find( $modules_selector) ) {
						
						if( $first_row_index === null ){
							// This is the first row where we've seen one of the relevant modules
							$first_row_index = $r_index;
						}
						
						// Expand the outer row boundary
						$last_row_index = $r_index;
						
					} else if ($row->find('form')) {
						// There is a row with a form not belonging to one of our relevant modules, so we need to wrap
						// by row
						$wrap_by = self::WRAP_BY_ROW;
						
						if ($first_row_index !== null) {
							// That's it, stop our wrapper here because we've already encountered one of our relevant
							// modules and another module has a form
							break;
						}
						
						// Otherwise, we keep looping because we haven't encountered one of our relevant modules yet
					}

				}
				
				if ($wrap_by == self::WRAP_BY_ROW) {
					// We are wrapping this section by row, so quit the section loop
					break;
				}

			}
			
			// Expand the outer section boundary
			$last_index = $index;
			
			if ($section->find('form') && !$section->find( $modules_selector)) {
				// There is a section with a form not belonging to one of our relevant modules, time to stop the wrapper
				break;
			}
		}

		// new content based on wrapper type
		$new_content = $wrap_by === self::WRAP_BY_SECTION ?
			$this->get_form_wrapped_content( $content_html, $first_index, $last_index ) :
			$this->get_form_wrapped_content( $content_html, $first_row_index, $last_row_index, $wrap_by, $first_index );

		return !empty( $new_content ) ? $new_content : $content;
	}


	/**
	 * Checkout form tag to be wrapped by sections or rows
	 *
	 * @return HTML
	 */
	public function get_form_wrapped_content( $html, $index, $index_last, $wrap_by = self::WRAP_BY_SECTION , $parent_index = null ){

		// bail out if no section or row found
		if( $index < 0 || $index_last < 0 || ( !is_null( $parent_index ) && $parent_index < 0 )  ){
			return false;
		}

		$sections = $html->find( '.et_pb_section' );

		if( $wrap_by === self::WRAP_BY_ROW ){

			$rows 						  = $sections[$parent_index]->find( '.et_pb_row' );

			$rows[$index]->outertext 	  = $this->get_wrapper_start() . $rows[$index]->outertext;
			$rows[$index_last]->outertext = $rows[$index_last]->outertext . $this->get_wrapper_end();
		}else{

			$sections[$index]->outertext 	  = $this->get_wrapper_start() . $sections[$index]->outertext;
			$sections[$index_last]->outertext = $sections[$index_last]->outertext . $this->get_wrapper_end();
		}

		return $html->outertext;
	}

	/**
	 * Form wrapper start
	 *
	 */
	private function get_wrapper_start(){
		ob_start();
		echo '<form name="checkout" method="post" class="checkout woocommerce-checkout" action="'. esc_url( wc_get_checkout_url() ) .'" enctype="multipart/form-data">';
		return ob_get_clean();
	}

	/**
	 * Form wrapper end
	 *
	 */
	private function get_wrapper_end(){
		ob_start();
		echo '</form>';
		do_action( 'woocommerce_after_checkout_form', WC()->checkout() );
		return ob_get_clean();
	}


	public function thankyou_page_redirect(){
		global $wp;

		$page_id  = wc_get_page_id('thankyou');
		$order_id = get_query_var( 'order-received' );

		if( intval( $page_id ) > 0 && !empty( $order_id ) && !empty( $_GET['key'] ) ){

			$url = add_query_arg( array(
				'order_id' => $order_id,
				'key'	   => sanitize_text_field($_GET['key'])
			), get_permalink( $page_id ) );

			wp_safe_redirect( $url );
			die();
		}
	}

}
new DSWCP_WoocomemrceOverrides;