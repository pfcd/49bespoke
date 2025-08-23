<?php

namespace Barn2\Plugin\WC_Product_Table;

use Barn2\Plugin\WC_Product_Table\Admin\Admin_Controller;
use Barn2\Plugin\WC_Product_Table\Admin\Table_Generator\Table_Generator;
use Barn2\Plugin\WC_Product_Table\Widgets\Active_Filters_Widget;
use Barn2\Plugin\WC_Product_Table\Widgets\Attribute_Filter_Widget;
use Barn2\Plugin\WC_Product_Table\Widgets\Price_Filter_Widget;
use Barn2\Plugin\WC_Product_Table\Widgets\Rating_Filter_Widget;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Plugin\Premium_Plugin;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Service;
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Database\Table;

/**
 * The main plugin class. Responsible for setting up the core plugin services.
 *
 * @package   Barn2\woocommerce-product-table
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Plugin extends Premium_Plugin {

	const NAME    = 'WooCommerce Product Table';
	const ITEM_ID = 12913;

	/**
	 * Constructor.
	 *
	 * @param string $file    The main plugin file (__FILE__). This is the file WordPress loads in the plugin root folder.
	 * @param string $version The plugin version string, e.g. '1.2.1'
	 */
	public function __construct( $file, $version = '1.0' ) {
		parent::__construct(
			[
				'id'                 => self::ITEM_ID,
				'name'               => self::NAME,
				'version'            => $version,
				'file'               => $file,
				'is_woocommerce'     => true,
				'is_hpos_compatible' => true,
				'settings_path'      => 'edit.php?post_type=product&page=tables&tab=settings',
				'design_path'      	 => 'edit.php?post_type=product&page=tables&tab=design',
				'documentation_path' => 'kb-categories/woocommerce-product-table-kb',
				'legacy_db_prefix'   => 'wcpt',
			]
		);

		$this->add_service( 'plugin_setup', new Plugin_Setup( $this ), true );
	}

	/**
	 * Registers the plugin hooks (add_action/add_filter).
	 *
	 * @return void
	 */
	public function register() {
		parent::register();

		add_action( 'init', [ $this, 'setup_updates' ], 10, 0 );
		add_action( 'init', [ $this, 'load_template_functions' ] );
	}

	/**
	 * Setup the updates service.
	 *
	 * @todo Move this to the add_services method once we've refactored the updates service to use the new Service class.
	 * @return void
	 */
	public function setup_updates() {
		$this->add_service( 'updates', new Updates( $this ) );
	}

	/**
	 * Get the list of services that the plugin requires.
	 *
	 * @return Service[] The list of services.
	 */
	public function add_services() {
		add_action( 'widgets_init', [ $this, 'register_widgets' ] );

		$this->add_service( 'admin', new Admin_Controller( $this ) );
		$this->add_service( 'table_generator', new Table_Generator( $this ) );

		$table = new Table( 'wpt' );
		$table->maybe_upgrade();

		if ( $this->has_valid_license() ) {
			$this->add_service( 'shortcode', new Table_Shortcode() );
			$this->add_service( 'scripts', new Frontend_Scripts( $this->get_version() ) );
			$this->add_service( 'cart_handler', new Cart_Handler() );
			$this->add_service( 'ajax_handler', new Ajax_Handler() );
			$this->add_service( 'template_handler', new Template_Handler() );
			$this->add_service( 'theme_compat', new Integration\Theme_Integration() );
			$this->add_service( 'searchwp', new Integration\SearchWP() );
			$this->add_service( 'product_addons', new Integration\Product_Addons() );
			$this->add_service( 'quick_view_pro', new Integration\Quick_View_Pro() );
			$this->add_service( 'lead_time', new Integration\Lead_Time() );
			$this->add_service( 'variation_swatches', new Integration\Variation_Swatches() );
			$this->add_service( 'yith_request_quote', new Integration\YITH_Request_Quote() );
			$this->add_service( 'woocommerce_wholesale_pro', new Integration\WooCommerce_Wholesale_Pro() );
		}
	}

	/**
	 * Load the plugin template functions file.
	 *
	 * @return void
	 */
	public function load_template_functions() {
		include_once $this->get_dir_path() . 'src/template-functions.php';
	}

	/**
	 * Register the plugin's widgets.
	 *
	 * @return void
	 */
	public function register_widgets() {
		if ( ! $this->get_license()->is_valid() ) {
			return;
		}

		$widget_classes = [
			Active_Filters_Widget::class,
			Attribute_Filter_Widget::class,
			Price_Filter_Widget::class,
			Rating_Filter_Widget::class,
		];

		// Register the product table widgets
		array_map( 'register_widget', array_filter( $widget_classes, 'class_exists' ) );
	}
}
