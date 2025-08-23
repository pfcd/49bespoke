<?php

class PlaceholderModule extends ET_Builder_Module {
	public $vb_support = 'on', $icon, $advanced_fields = false;
	protected $icon_path;

	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function __construct($name, $slug, $icon) {
		$this->name      = $name;
		$this->slug      = $slug;
		parent::__construct();
		if (strlen($icon) == 1) {
			$this->icon = $icon;
		} else {
			$this->icon_path = $icon;
		}
	}
	
	public function get_fields() {
		return [
			'pro' => [
				'type'        => 'ags_wc_warning-DSB',
				'toggleVar'   => 'ETBuilderBackend',
				'className'   => 'ags_divi_wc_proModuleNotice',
				'warningText' => __( 'This module is only available in the Pro version of Divi Shop Builder.', 'divi-shop-builder' )
			]
		];
	}
	
	// public function render() { }
}

new PlaceholderModule( esc_html__( 'Account Content', 'divi-shop-builder' ), 'ags_woo_account_content', __DIR__.'/WooAccountContent/icon.svg' );
new PlaceholderModule( esc_html__( 'Account Navigation', 'divi-shop-builder' ), 'ags_woo_account_navigation', __DIR__.'/WooAccountNav/icon.svg' );
new PlaceholderModule( esc_html__( 'Account User Image', 'divi-shop-builder' ), 'ags_woo_account_user_image', __DIR__.'/WooAccountUserImage/icon.svg' );
new PlaceholderModule( esc_html__( 'Account User Name', 'divi-shop-builder' ), 'ags_woo_account_user_name', __DIR__.'/WooAccountUserName/icon.svg' );
new PlaceholderModule( esc_html__( 'Cart List', 'divi-shop-builder' ), 'ags_woo_cart_list', __DIR__.'/WooCartList/icon.svg' );
new PlaceholderModule( esc_html__( 'Cart Totals', 'divi-shop-builder' ), 'ags_woo_cart_totals', __DIR__.'/WooCartTotals/icon.svg' );
new PlaceholderModule( esc_html__( 'Checkout Billing', 'divi-shop-builder' ), 'ags_woo_checkout_billing_info', __DIR__.'/WooCheckoutBillingInfo/icon.svg' );
new PlaceholderModule( esc_html__( 'Checkout Coupon', 'divi-shop-builder' ), 'ags_woo_checkout_coupon', __DIR__.'/WooCheckoutCoupon/icon.svg' );
new PlaceholderModule( esc_html__( 'Checkout Order', 'divi-shop-builder' ), 'ags_woo_checkout_order_review', __DIR__.'/WooCheckoutOrderReview/icon.svg' );
new PlaceholderModule( esc_html__( 'Checkout Shipping', 'divi-shop-builder' ), 'ags_woo_checkout_shipping_info', __DIR__.'/WooCheckoutShippingInfo/icon.svg' );
new PlaceholderModule( esc_html__( 'Login Form', 'divi-shop-builder' ), 'ags_woo_login_form', '/' );
new PlaceholderModule( esc_html__( 'Mini Cart', 'divi-shop-builder' ), 'ags_woo_mini_cart', __DIR__.'/WooMiniCart/icon.svg' );
new PlaceholderModule( esc_html__( 'Woo Multi-Step Checkout (BETA)', 'divi-shop-builder' ), 'ags_woo_multi_step_checkout', __DIR__.'/WooMultiStepCheckout/icon.svg' );
new PlaceholderModule( esc_html__( 'Woo Products Filters', 'divi-shop-builder' ), 'ags_woo_products_filters', __DIR__.'/WooProductsFilters/icon.svg' );
new PlaceholderModule( esc_html__( 'Register Form', 'divi-shop-builder' ), 'ags_woo_register_form', '/' );
new PlaceholderModule( esc_html__( 'Thank You', 'divi-shop-builder' ), 'ags_woo_thank_you', __DIR__.'/WooThankYou/icon.svg' );