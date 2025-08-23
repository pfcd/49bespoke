<?php


namespace Barn2\Plugin\WC_Product_Table\Admin\Settings_Tab;

use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Plugin\Licensed_Plugin;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Registerable;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Service\Standard_Service;

/**
 * The Product_Tables settings tab.
 *
 * @package   Barn2\woocommerce-product-table
 * @author    Barn2 Plugins <info@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Tables implements Standard_Service, Registerable {

	const TAB_ID    = 'tables';
	const MENU_SLUG = 'wpt_tables';

	private $id;
	private $title;
	private $plugin;

	/**
	 * Get things started.
	 *
	 * @param Licensed_Plugin $plugin
	 */
	public function __construct( Licensed_Plugin $plugin ) {
		$this->plugin = $plugin;
		$this->id     = 'tables';

		add_action( 'admin_init', [ $this, 'setup' ] );
	}

	/**
	 * Temporary setup method to initialize the title.
	 *
	 * @todo Refactor this into a more robust initialization system in future versions
	 * @return void
	 */
	public function setup() {
		$this->title = __( 'Tables', 'woocommerce-product-table' );
	}

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public function register() {
	}

	public function get_services() {
		// return [
		// 'table_generator' => new Table_Generator( $this->plugin ),
		// ];
	}

	/**
	 * Register the settings.
	 */
	public function output() {
		print( '<div id="b2-table-generator"></div>' );
	}

	/**
	 * Get the tab title.
	 *
	 * @return string
	 */
	public function get_title() {
		return $this->title;
	}

	/**
	 * Get the tab ID.
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->id;
	}
}
