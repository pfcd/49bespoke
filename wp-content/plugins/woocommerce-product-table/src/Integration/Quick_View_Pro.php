<?php

namespace Barn2\Plugin\WC_Product_Table\Integration;

use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Table_Generator;
use Barn2\Plugin\WC_Product_Table\Util\Settings;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Registerable;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Service\Standard_Service;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Util as Lib_Util;

/**
 * Handles the WooCommerce Quick View Pro integration.
 *
 * @package   Barn2\woocommerce-product-table
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Quick_View_Pro implements Standard_Service, Registerable {

	/**
	 * Register the integrations for Quick View Pro.
	 */
	public function register() {
		if ( ! Lib_Util::is_barn2_plugin_active( '\Barn2\Plugin\WC_Quick_View_Pro\wqv' ) ) {
			return;
		}

		// Plugin settings.
		add_filter( 'wc_product_table_plugin_settings_before_advanced', [ $this, 'add_plugin_settings' ], 50 );
		add_action( 'barn2_table_generator_pre_boot', [ $this, 'register_custom_columns' ] );
	}

	/**
	 * Register custom columns for Quick View Pro integration.
	 *
	 * @param Table_Generator $generator The table generator instance.
	 * @return void
	 */
	public function register_custom_columns( $generator ) {

		$generator->register_custom_column(
			'quick_view',
			[
				'heading' => esc_html__( 'Quick View', 'woocommerce-product-table' ),
			]
		);
	}

	/**
	 * Open product table links with Quick View Pro?
	 *
	 * @return bool true to open with QVP.
	 */
	public static function open_links_in_quick_view() {
		if ( Lib_Util::is_barn2_plugin_active( '\Barn2\Plugin\WC_Quick_View_Pro\wqv' ) ) {
			$misc_settings = Settings::get_setting_misc();

			return ! empty( $misc_settings['quick_view_links'] );
		}

		return false;
	}

	/**
	 * Add the Quick View Pro plugin settings.
	 *
	 * @param  array $settings The list of settings.
	 * @return array The list of settings.
	 */
	public function add_plugin_settings( $settings ) {
		return array_merge(
			$settings,
			[
				[
					'title' => __( 'Quick View Pro', 'woocommerce-product-table' ),
					'type'  => 'title',
					'desc'  => __( 'These options control the Quick View Pro extension.', 'woocommerce-product-table' ),
					'id'    => 'product_table_settings_quick_view',
				],
				[
					'title'   => __( 'Product links', 'woocommerce-product-table' ),
					'type'    => 'checkbox',
					'id'      => Settings::OPTION_MISC . '[quick_view_links]',
					'label'   => __( 'Replace links to the product page with quick view.', 'woocommerce-product-table' ),
					'desc'    => __( 'Control what happens when clicking on a link to a product. ', 'woocommerce-product-table' ) . sprintf(
						'<a href="%s" target="_blank">%s</a>',
						Lib_Util::barn2_url( 'kb/product-table-quick-view/' ),
						__( 'Read more', 'woocommerce-product-table' )
					),
					'default' => 'no',
				],
				[
					'type' => 'sectionend',
					'id'   => 'product_table_settings_quick_view',
				],
			]
		);
	}
}
