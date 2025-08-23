<?php

defined( 'ABSPATH' ) || exit;

/**
 * Module class of Woo My Account Login
 *
 */
class DSWCP_WooAccountLogin extends DSWCP_WooAccountBase {

	use DSWCP_Module;

	public $slug       		= 'ags_woo_account_login';
	public $vb_support 		= 'on';
	protected $endpoint		= '';
	protected $icon;

	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function init() {
		$this->name = esc_html__( 'Account Login', 'divi-shop-builder' );
		$this->icon  = '/';

		$this->main_css_element = '%%order_class%% .woocommerce-MyAccount-content .login-wrapper';

		add_filter( 'dswcp_builder_js_data', array( $this, 'builder_js_data' ) );
	}

	public function get_fields(){
		return array();
	}

}

new DSWCP_WooAccountLogin;
