<?php

namespace Barn2\Plugin\WC_Product_Table\Admin;

use Barn2\Plugin\WC_Product_Table\Util\Util;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Registerable;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Conditional;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Plugin\Admin\Admin_Links;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Plugin\Licensed_Plugin;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Util as Lib_Util;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Service\Service_Container;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Service\Standard_Service;
use Barn2\Plugin\WC_Product_Table\Util\Settings as Settings_Util;
use Barn2\Plugin\WC_Product_Table\Util\Defaults;

/**
 * Handles general admin functions, such as adding links to our settings page in the Plugins menu.
 *
 * @package   Barn2\woocommerce-product-table
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Admin_Controller implements Standard_Service, Registerable, Conditional {

	use Service_Container;

	private $plugin;

	public function __construct( Licensed_Plugin $plugin ) {
		$this->plugin = $plugin;

		$this->add_services();
	}

	public function is_required() {
		return Lib_Util::is_admin();
	}

	public function register() {
		$this->register_services();
		$this->start_all_services();
		add_action( 'admin_enqueue_scripts', [ $this, 'register_admin_scripts' ] );
	}

	public function add_services() {
		$this->add_service( 'admin_links', new Admin_Links( $this->plugin ) );
		$this->add_service( 'settings_api_helper', new Settings_Api_Service( $this->plugin ) );
		$this->add_service( 'settings_page', new Settings_Page( $this->plugin ) );
		$this->add_service( 'tiny_mce', new TinyMCE() );
	}

	public function register_admin_scripts( $hook_suffix ) {
		if ( 'product_page_tables' !== $hook_suffix ) {
			return;
		}

		$suffix = Lib_Util::get_script_suffix();

		wp_enqueue_script( 'barn2-tiptip' );
		wp_add_inline_script( 'barn2-tiptip', 'jQuery( function() { jQuery( \'.barn2-help-tip\' ).tipTip( { "attribute": "data-tip" } ); } );' );
		wp_enqueue_style( 'barn2-tooltip' );

		wp_enqueue_style( 'wcpt-admin', Util::get_asset_url( 'css/admin/wc-product-table-admin.css' ), [], $this->plugin->get_version() );
		wp_enqueue_script( 'wcpt-admin', Util::get_asset_url( 'js/admin/wc-product-table-admin.js' ), [ 'jquery', 'barn2-tiptip' ], $this->plugin->get_version(), true );

		$script_params = [
			'ajax_url'                     => admin_url( 'admin-ajax.php' ),
			'ajax_nonce'                   => wp_create_nonce( 'wcpt-admin' ),
			'settings_page_url'            => admin_url( 'edit.php?post_type=product&page=tables&tab=settings' ),
			'design_template_defaults'     => Defaults::get_design_defaults_for_templates(),
			'design_defaults_with_options' => Settings_Util::get_design_template_settings(),
		];

		wp_add_inline_script(
			'wcpt-admin',
			sprintf( 'const product_table_admin_params = %s;', wp_json_encode( $script_params ) ),
			'before'
		);
	}
}
