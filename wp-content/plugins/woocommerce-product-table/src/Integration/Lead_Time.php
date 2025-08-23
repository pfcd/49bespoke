<?php

namespace Barn2\Plugin\WC_Product_Table\Integration;

use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Registerable;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Service\Standard_Service;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Util as Lib_Util;

/**
 * Handles the WooCommerce Lead Time integration.
 *
 * @package   Barn2\woocommerce-product-table
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Lead_Time implements Standard_Service, Registerable {

	/**
	 * Register the service.
	 *
	 * Checks if WooCommerce Lead Time plugin is active before registering custom columns.
	 *
	 * @return void
	 */
	public function register() {
		if ( ! Lib_Util::is_barn2_plugin_active( '\Barn2\Plugin\WC_Lead_Time\wlt' ) ) {
			return;
		}

		add_action( 'barn2_table_generator_pre_boot', [ $this, 'register_custom_columns' ] );
	}

	/**
	 * Register custom columns for Lead Time integration.
	 *
	 * @param Table_Generator $generator The table generator instance.
	 * @return void
	 */
	public function register_custom_columns( $generator ) {

		$generator->register_custom_column(
			'lead-time',
			[
				'heading' => esc_html__( 'Lead Time', 'woocommerce-product-table' ),
			]
		);
	}
}
