<?php

if ( ! class_exists( 'ET_Builder_Element' ) || ! class_exists( 'WooCommerce' ) ) {
	return;
}

function dnwooe_register_modules() {
	$active_modules = get_option( 'dnwooe_inactive_modules', array() );
	require_once DNWOO_ESSENTIAL_PATH . '/includes/modules/base/WooCommon.php';
	require_once DNWOO_ESSENTIAL_PATH . '/includes/modules/base/WooCommonSettings.php';

	if ( ! in_array( 'dnwooe-woo-carousel', $active_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextWooCarousel/NextWooCarousel.php';
	}

	if ( ! in_array( 'dnwooe-woo-grid', $active_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextWooGrid/NextWooGrid.php';
	}

	if ( ! in_array( 'dnwooe-woo-cat-carousel', $active_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextWooCatCarousel/NextWooCatCarousel.php';
	}

	if ( ! in_array( 'dnwooe-woo-cat-grid', $active_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextWooCatGrid/NextWooCatGrid.php';
	}

	if ( ! in_array( 'dnwooe-woo-cat-masonry', $active_modules )) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextWooCatMasonry/NextWooCatMasonry.php';
	}

	if ( ! in_array( 'dnwooe-woo-cat-accordion', $active_modules )) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextWooCatAccordion/NextWooCatAccordion.php';
	}

	if ( ! in_array( 'dnwooe-woo-accordion', $active_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextWooProductAccordion/NextWooProductAccordion.php';
	}

	if ( ! in_array( 'dnwooe-woo-filter-masonry', $active_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextWooFilterMasonry/NextWooFilterMasonry.php';
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextWooFilterMasonryChild/NextWooFilterMasonryChild.php';
	}
	
	if ( ! in_array( 'dnwooe-woo-mini-cart', $active_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextWooMiniCart/NextWooMiniCart.php';
	}

	if ( ! in_array( 'dnwooe-woo-ajax-search', $active_modules ) ) {
		require_once plugin_dir_path( __FILE__ ) . 'modules/NextWooAjaxSearch/NextWooAjaxSearch.php';
	}
}

dnwooe_register_modules();