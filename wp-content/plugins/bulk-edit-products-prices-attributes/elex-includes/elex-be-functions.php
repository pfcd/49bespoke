<?php
// to check whether accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//check class dependencies exist or not
if ( ! class_exists( 'ELEX_BE_Premium_Dependencies' ) ) {
	require_once  'elex-be-dependencies.php' ;
}

//check woocommerce is active function exist
if ( ! function_exists( 'elex_be_premium_is_woocommerce_active' ) ) {

	function elex_be_premium_is_woocommerce_active() {
		return ELEX_BE_Premium_Dependencies::woocommerce_active_check();
	}
}
