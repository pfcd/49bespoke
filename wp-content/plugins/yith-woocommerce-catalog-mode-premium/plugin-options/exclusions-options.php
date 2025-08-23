<?php
/**
 * Exclusion options tab
 *
 * @package YITH\CatalogMode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$show_multi_vendor_tab = ywctm_is_multivendor_active() && ywctm_is_multivendor_integration_active() && '' === ywctm_get_vendor_id( true );

if ( $show_multi_vendor_tab ) {
	$plugin_tabs = array(
		'exclusions' => array(
			'exclusions-options' => array(
				'type'       => 'multi_tab',
				'nav-layout' => 'horizontal',
				'sub-tabs'   => array(
					'exclusions-items'   => array(
						'title'       => esc_html__( 'List of excluded items', 'yith-woocommerce-catalog-mode' ),
						'description' => esc_html__( 'Add products, categories, or tags to the Exclusion List to define the products where the plugin features are used.', 'yith-woocommerce-catalog-mode' ),
					),
					'exclusions-vendors' => array(
						'title'       => esc_html__( 'List of vendors', 'yith-woocommerce-catalog-mode' ),
						'description' => esc_html__( 'Configure the exclusion list for the vendors.', 'yith-woocommerce-catalog-mode' ),
					),
				),
			),
		),
	);
} else {
	$plugin_tabs = array(
		'exclusions' => array(
			'exclusions-tab' => array(
				'type'           => 'custom_tab',
				'action'         => 'ywctm_exclusions_items',
				'show_container' => true,
				'description'    => __( 'Add products, categories, or tags to the Exclusion List to define the products where the plugin features are used.', 'yith-woocommerce-catalog-mode' ),
			),
		),
	);
}

return $plugin_tabs;
