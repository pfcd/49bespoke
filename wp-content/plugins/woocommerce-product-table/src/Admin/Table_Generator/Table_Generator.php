<?php
namespace Barn2\Plugin\WC_Product_Table\Admin\Table_Generator;

use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Block;
use Barn2\Plugin\WC_Product_Table\Admin\Table_Generator\Steps\Columns;
use Barn2\Plugin\WC_Product_Table\Admin\Table_Generator\Steps\Create;
use Barn2\Plugin\WC_Product_Table\Admin\Table_Generator\Steps\Filters;
use Barn2\Plugin\WC_Product_Table\Admin\Table_Generator\Steps\Performance;
use Barn2\Plugin\WC_Product_Table\Admin\Table_Generator\Steps\Content;
use Barn2\Plugin\WC_Product_Table\Admin\Table_Generator\Steps\AddToCart;
use Barn2\Plugin\WC_Product_Table\Admin\Table_Generator\Steps\Welcome;
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Table_Generator as Generator_Library;
use Barn2\Plugin\WC_Product_Table\Dependencies\Barn2\Table_Generator\Database\Query;
use Barn2\Plugin\WC_Product_Table\Util\Columns as Columns_Util;
use Barn2\Plugin\WC_Product_Table\Util\Settings;
use Barn2\Plugin\WC_Product_Table\Util\Util;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Plugin\Plugin;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Registerable;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Service\Standard_Service;

/**
 * This class handles the registration of the table generator library.
 *
 * @package   Barn2\posts-table-pro
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Table_Generator implements Registerable, Standard_Service {

	/**
	 * Instance of the plugin.
	 *
	 * @var Plugin
	 */
	protected $plugin;

	/**
	 * Get things started.
	 *
	 * @param Plugin $plugin
	 */
	public function __construct( Plugin $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Hook into WP.
	 *
	 * @return void
	 */
	public function register() {
		add_action( 'init', [ $this, 'init' ], 200 );
	}

	/**
	 * Init the table generator library.
	 *
	 * @return void
	 */
	public function init() {

		// Init library and steps.
		$generator = new Generator_Library(
			$this->plugin,
			'wpt',
			new Welcome(),
			new Create(),
			new Content(),
			new Columns(),
			new AddToCart(),
			new Performance(),
			new Filters(),
		);

		// Setup paths to the library.
		$generator->set_library_path( plugin_dir_path( $this->plugin->get_file() ) . 'dependencies/barn2/table-generator/' );
		$generator->set_library_url( plugin_dir_url( $this->plugin->get_file() ) . 'dependencies/barn2/table-generator/' );

		// Grab options from the plugin.
		$generator->set_options_key( 'wcpt_shortcode_defaults' );

		// Map certain options to different keys.
		$generator->set_options_mapping(
			[
				'content_type' => 'post_type',
				'lazyload'     => 'lazy_load',
				'cache'        => 'cache',
				'search_box'   => 'search_box',
				'sortby'       => 'sort_by',
				'sort_order'   => 'sort_order',
			]
		);

		// Setup certain fields to use the datastore of the react app.
		$generator->add_datastore_field( 'refine' );
		$generator->add_datastore_field( 'columns' );
		$generator->add_datastore_field( 'filters' );
		$generator->add_datastore_field( 'filter_mode' );
		$generator->add_datastore_field( 'sortby' );
		$generator->add_datastore_field( 'table_display' );

		// Set the shortcode slug.
		$generator->set_shortcode( 'product_table' );

		// Set the shortcode resolver.
		$generator->set_shortcode_resolver( \Barn2\Plugin\WC_Product_Table\Table_Shortcode::class );

		// Configure settings of the react app.
		$generator->config(
			[
				'utm_id'                 => 'wpt',
				'pluginInstallerPage'    => admin_url( 'admin.php?page=easy-post-types-fields-setup-wizard&action=add' ),
				'settingsPage'           => admin_url( 'edit.php?post_type=product&page=tables&tab=settings' ),
				'licenseStepTitle'       => sprintf( __( 'Welcome to %s', 'woocommerce-product-table' ), $this->plugin->get_name() ),
				'licenseStepDescription' => __( 'Create and display beautiful tables of your website content.', 'woocommerce-product-table' ),
				'indexTitle'             => __( 'Product Tables', 'woocommerce-product-table' ),
				'indexDescription'       => __( 'Create and manage your product tables on this page. Display them using the Product Table block or shortcode.', 'woocommerce-product-table' ),
				'isPluginInstalled'      => 'active_update',
				'pageHeaderLinks'        => [
					'wizard' => [
						'url' => admin_url( 'edit.php?post_type=product&page=tables&add-new&wizard=1' ),
					],
				],
				'addPageURL'             => admin_url( 'edit.php?post_type=product&page=tables&add-new' ),
				'listPageURL'            => admin_url( 'edit.php?post_type=product&page=tables' ),
				'settingsPageURL'        => admin_url( 'edit.php?post_type=product&page=tables&tab=settings' ),
				'designPageURL'          => admin_url( 'edit.php?post_type=product&page=tables&tab=design' ),
				'advancedOptionsPageURL' => 'https://barn2.com/kb/product-table-options/',
				'gutenbergBlock'         => 'Product Table',
				'shopURL'                => function_exists( 'wc_get_page_id' ) ? get_permalink( wc_get_page_id( 'shop' ) ) : '',
				'pageHeader'             => false,
				'pagesWrapperID'         => 'b2-inner-pages-wrapper',
				'shopTemplatesNames'     => array_merge(
					[
						'shop_override'            => __( 'Shop page', 'woocommerce-product-table' ),
						'search_override'          => __( 'Product search results', 'woocommerce-product-table' ),
						'archive_override'         => __( 'Product categories', 'woocommerce-product-table' ),
						'product_tag_override'     => __( 'Product tags', 'woocommerce-product-table' ),
						'attribute_override'       => __( 'Product attributes', 'woocommerce-product-table' ),
						'wholesale_store_override' => __( 'Wholesale store', 'woocommerce-product-table' ),
					],
					Util::get_custom_product_taxonomies( '_override' )
				),
			]
		);

		// Grab default columns.
		$generator->set_default_columns( Columns_Util::column_defaults() );

		// Setup how to resolve arguments for the tables.
		$generator->set_args_resolver( \Barn2\Plugin\WC_Product_Table\Table_Args::class );

		// Setup extra fields for the edit page.
		$generator->set_extra_fields( Table_Generator_Extras::class );

		// Boot library.
		$generator->boot();

		// Initialize the Gutenberg block.
		$gutenberg_block = new Block( $generator );

		// Configure the block.
		$gutenberg_block->set_label( 'Product Table' );
		$gutenberg_block->set_instructions( __( 'Select a pre-saved product table. Go to Products > Tables to create or edit your tables.', 'woocommerce-product-table' ) );
		$gutenberg_block->set_description( __( 'An interactive product table.', 'woocommerce-product-table' ) );
		$gutenberg_block->set_options_doc_url( 'https://barn2.com/kb/product-table-options/' );

		// Boot the block.
		$gutenberg_block->boot();
	}

	/**
	 * @param  mixed $title
	 * @param  mixed $settings
	 * @return void
	 */
	public static function create_table( $title, $settings = [], $is_completed = 1 ) {

		$defaults = Settings::get_setting_table_defaults();
		$misc     = Settings::get_setting_misc();

		$defaults_columns = [];
		$columns          = explode( ',', $defaults['columns'] );
		$links            = explode( ',', $defaults['links'] );

		if ( in_array( 'categories', $links ) ) {
			$links[] = 'tax:product_cat';
		}
		if ( in_array( 'tags', $links ) ) {
			$links[] = 'tax:product_tag';
		}

		foreach ( $columns as $key => $column ) {
			$column_name = Columns_Util::get_column_heading( $column );
			$column_slug = Columns_Util::get_column_slug( $column );

			$defaults_columns[ $key ] = [
				'name'     => ucfirst( $column_name ),
				// "label"    => ucfirst( $column_slug ),
				'slug'     => $column_slug,
				'settings' => [
					'input'              => '',
					'visibility'         => 'true',
					'column_type'        => '',
					'widths'             => '',
					'priorities'         => '',
					'column_breakpoints' => 'default',
				],
			];

			if ( in_array( $column_slug, [ 'id', 'sku', 'image', 'name', 'tax:product_cat', 'tax:product_tag' ] ) || Columns_Util::is_custom_taxonomy( $column ) || Columns_Util::is_product_attribute( $column ) ) {
				if ( in_array( $column_slug, $links ) || in_array( 'all', $links ) || Columns_Util::is_custom_taxonomy( $column ) && in_array( 'terms', $links ) && $column_slug !== 'tax:product_cat' && $column_slug !== 'tax:product_tag' || Columns_Util::is_product_attribute( $column ) && in_array( 'attributes', $links ) ) {
					$defaults_columns[ $key ]['settings']['links'] = 'true';
				} else {
					$defaults_columns[ $key ]['settings']['links'] = 'false';
				}
			}

			if ( $column_slug === 'image' ) {
				$defaults_columns[ $key ]['settings']['lightbox'] = in_array( [ 'image' ], $links ) || $defaults_columns[ $key ]['settings']['links'] === 'false' ? 'false' : $defaults['lightbox'];
			}

			if ( in_array( $column_slug, [ 'tax:product_cat', 'tax:product_tag' ] ) || Columns_Util::is_custom_taxonomy( $column ) || Columns_Util::is_product_attribute( $column ) ) {
				$defaults_columns[ $key ]['settings']['search_on_click'] = $defaults['search_on_click'];
			}

			$column_names[ $column_slug ] = $column_name;
		}

		$filter_mode = true;
		$filters     = [];

		if ( $defaults['filters'] === 'false' ) {
			$filter_mode = false;
		} elseif ( $defaults['filters'] === 'custom' && trim( $defaults['filters_custom'] ) ) {

			$filters_custom = explode( ',', $defaults['filters_custom'] );

			foreach ( $filters_custom as $filter ) {
				$taxonomy_slug          = Columns_Util::get_column_slug( $filter );
				$tax_obj                = $taxonomy_slug ? get_taxonomy( $taxonomy_slug ) : false;
				$unprefixed_filter      = Columns_Util::unprefix_column( $filter );
				$unprefixed_filter_name = Columns_Util::unprefix_column( $unprefixed_filter );

				if ( strpos( $unprefixed_filter, ':' ) !== false ) {
					if ( trim( $unprefixed_filter_name ) !== '' ) {
						$filter_name = ucfirst( $unprefixed_filter_name );
					} else {
						$filter_name = str_replace( ':', '', ucfirst( $unprefixed_filter ) );
					}
				} elseif ( $tax_obj ) {
					$filter_name = $tax_obj->labels->singular_name;
				} else {
					$filter_name = ucfirst( $unprefixed_filter );
				}

				if ( trim( $filter_name ) === 'blank' ) {
					$filter_name = '';
				}

				$taxonomy_slug = str_replace( 'tax:', '', $taxonomy_slug );

				$filters[] = [
					'name' => $filter_name,
					'slug' => 'tax:' . $taxonomy_slug,
				];
			}
		}

		$defaults_settings = [
			'content_type'          => 'product',
			'table_display'         => isset( $settings['table_display'] ) && $settings['table_display'] === 'shop_page' ? 'shop_page' : 'manual',
			'refine'                => [
				'mode'        => 'all',
				'refinements' => [],
			],
			'refine_mode'           => 'all',
			'columns'               => $defaults_columns,
			'cart_button'           => $defaults['cart_button'] ?? '',
			'quantities'            => $defaults['quantities'] ?? '',
			'variations'            => $defaults['variations'] ?? '',
			'variation_name_format' => $misc['variation_name_format'] ?? '',
			'filter_mode'           => $filter_mode,
			'filters'               => $filters,
			'sortby'                => $defaults['sort_by'] ?? '',
			'sort_order'            => $defaults['sort_order'] ?? '',
			'lazyload'              => $defaults['lazy_load'] ?? '',
			'product_limit'         => $defaults['product_limit'] ?? '',
			'image_size'            => $defaults['image_size'] ?? '',
		];

		if ( $defaults_settings['table_display'] === 'shop_page' ) {
			$misc = array_filter(
				$misc,
				function ( $v, $k ) {
					return substr( $k, -9 ) === '_override' && $v === true;
				},
				ARRAY_FILTER_USE_BOTH
			);

			$defaults_settings = array_merge( $defaults_settings, $misc );
		}

		$settings = array_merge( $defaults_settings, $settings );

		$query = new Query( 'wpt' );
		$query->add_item(
			[
				'title'        => stripslashes( $title ),
				'settings'     => wp_json_encode( $settings ),
				'is_completed' => $is_completed,
			]
		);
	}
}
