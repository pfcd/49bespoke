<?php

namespace Barn2\Plugin\WC_Product_Table;

use Automattic\Jetpack\Constants;
use Barn2\Plugin\WC_Product_Table\Data\Product_Hidden_Filter;
use Barn2\Plugin\WC_Product_Table\Integration\Quick_View_Pro;
use Barn2\Plugin\WC_Product_Table\Util\Settings;
use Barn2\Plugin\WC_Product_Table\Util\Util;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Conditional;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\CSS_Util;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Registerable;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Service\Standard_Service;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Util as Lib_Util;

/**
 * Handles the registering of the front-end scripts and stylesheets. Also creates the inline CSS (if required) for the product tables.
 *
 * @package   Barn2\woocommerce-product-table
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Frontend_Scripts implements Standard_Service, Registerable, Conditional {

	const SCRIPT_HANDLE      = 'wc-product-table';
	const DATATABLES_VERSION = '1.13.5';

	private $script_version;

	/**
	 * Constructor.
	 *
	 * @param string $script_version The script version for registering product table assets.
	 */
	public function __construct( $script_version ) {
		$this->script_version = $script_version;
	}

	public function is_required() {
		return Lib_Util::is_front_end();
	}

	public function register() {
		// Register front-end styles and scripts
		add_action( 'wp_enqueue_scripts', [ $this, 'register_styles' ], 15 ); // after WooCommerce load_scripts()
		add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ], 15 ); // after WooCommerce load_scripts()
		add_action( 'wp_enqueue_scripts', [ $this, 'load_head_scripts' ], 20 );

		add_action( 'wc_product_table_before_load_table_scripts', [ $this, 'reregister_woocommerce_scripts' ] );
	}

	public function load_scripts() {
		_deprecated_function( __METHOD__, '2.9', 'register' );
		$this->register();
	}

	public function register_styles() {
		$style_options = Settings::get_setting_table_styling();

		wp_register_style( 'jquery-datatables-wpt', Util::get_asset_url( 'js/datatables/datatables.min.css' ), [], self::DATATABLES_VERSION );

		wp_register_style(
			self::SCRIPT_HANDLE,
			Util::get_asset_url( 'css/styles.css' ),
			[ 'jquery-datatables-wpt', 'select2' ],
			$this->script_version
		);

		// Add RTL data - we need suffix to correctly format RTL stylesheet when minified.
		wp_style_add_data( self::SCRIPT_HANDLE, 'rtl', 'replace' );
		wp_style_add_data( self::SCRIPT_HANDLE, 'suffix', '.min' );

		// Add custom styles (if enabled)
		wp_add_inline_style( self::SCRIPT_HANDLE, self::build_custom_styles( $style_options ) );

		// Header styles - we just a dummy handle as we only need inline styles in <head>.
		wp_register_style( 'wc-product-table-head', false, [], '1.0' );

		// Ensure tables don't 'flicker' on page load - visibility is set by JS when table initialised.
		wp_add_inline_style( 'wc-product-table-head', 'table.wc-product-table { visibility: hidden; }' );
	}

	public function register_scripts() {
		$suffix = Lib_Util::get_script_suffix();

		wp_register_script( 'jquery-datatables-wpt', Util::get_asset_url( "js/datatables/datatables{$suffix}.js" ), [ 'jquery' ], self::DATATABLES_VERSION, true );
		wp_register_script( 'fitvids', Util::get_asset_url( 'js/jquery-fitvids/jquery.fitvids.min.js' ), [ 'jquery' ], '1.1', true );
		wp_register_script( 'fixed-header', Util::get_asset_url( "js/fixed-header/datatables.fixedHeader{$suffix}.js" ), [ 'jquery' ], '1.1', true );

		// We need to use a unique handle for our serialize object script to distinguish it from the built-in WordPress version.
		wp_register_script(
			'jquery-serialize-object-wpt',
			Util::get_asset_url( 'js/jquery-serialize-object/jquery.serialize-object.min.js' ),
			[ 'jquery' ],
			'2.5',
			true
		);

		wp_register_script(
			self::SCRIPT_HANDLE,
			Util::get_asset_url( 'js/wc-product-table.js' ),
			[ 'jquery', 'jquery-datatables-wpt', 'jquery-serialize-object-wpt', 'jquery-blockui', 'selectWoo' ],
			$this->script_version,
			true
		);

		$script_params = [
			'ajax_url'                => admin_url( 'admin-ajax.php' ),
			'ajax_nonce'              => wp_create_nonce( self::SCRIPT_HANDLE ),
			'multi_cart_button_class' => esc_attr( apply_filters( 'wc_product_table_multi_cart_class', Util::get_button_class() ) ),
			'enable_select2'          => apply_filters( 'wc_product_table_enable_select2', true ),
			'filter_term_separator'   => Product_Hidden_Filter::get_term_separator(),
			'language'                => apply_filters(
				'wc_product_table_language_defaults',
				[
					'info'                               => __( 'Showing _TOTAL_ products', 'woocommerce-product-table' ),
					'infoEmpty'                          => __( '0 products', 'woocommerce-product-table' ),
					'infoFiltered'                       => __( '(_MAX_ in total)', 'woocommerce-product-table' ),
					'lengthMenu'                         => __( 'Show _MENU_ per page', 'woocommerce-product-table' ),
					'emptyTable'                         => __( 'No matching products', 'woocommerce-product-table' ),
					'zeroRecords'                        => __( 'No matching products', 'woocommerce-product-table' ),
					'search'                             => apply_filters( 'wc_product_table_search_label', __( 'Search:', 'woocommerce-product-table' ) ),
					'paginate'                           => [
						'first'    => __( 'First', 'woocommerce-product-table' ),
						'last'     => __( 'Last', 'woocommerce-product-table' ),
						'next'     => __( 'Next', 'woocommerce-product-table' ),
						'previous' => __( 'Previous', 'woocommerce-product-table' ),
					],
					'thousands'                          => _x( ',', 'thousands separator', 'woocommerce-product-table' ),
					'decimal'                            => _x( '.', 'decimal mark', 'woocommerce-product-table' ),
					'aria'                               => [
						/* translators: ARIA text for sorting column in ascending order */
						'sortAscending'  => __( ': activate to sort column ascending', 'woocommerce-product-table' ),
						/* translators: ARIA text for sorting column in descending order */
						'sortDescending' => __( ': activate to sort column descending', 'woocommerce-product-table' ),
					],
					'filterBy'                           => apply_filters( 'wc_product_table_search_filter_label', '' ),
					'resetButton'                        => apply_filters( 'wc_product_table_reset_button', __( 'Reset', 'woocommerce-product-table' ) ),
					'multiCartButton'                    => esc_attr( apply_filters( 'wc_product_table_multi_cart_button', Settings::get_setting_misc()['add_selected_text'] ?? '' ) ),
					'multiCartButtonSingularPlaceholder' => esc_attr( Settings::get_setting_misc()['add_selected_text_singular_placeholder'] ?? '' ),
					'multiCartButtonPluralPlaceholder'   => esc_attr( Settings::get_setting_misc()['add_selected_text_plural_placeholder'] ?? '' ),
					'multiCartNoSelection'               => __( 'Please select one or more products.', 'woocommerce-product-table' ),
					'selectAll'                          => __( 'Select all', 'woocommerce-product-table' ),
					'clearAll'                           => __( 'Clear all', 'woocommerce-product-table' ),
				]
			),
			'wc_price_format'         => get_woocommerce_price_format(),
			'wc_currency_symbol'      => get_woocommerce_currency_symbol(),
			'wc_price_decimals'       => wc_get_price_decimals(),
			'activeTheme'             => wp_get_theme()->get( 'Name' ),
		];

		if ( Quick_View_Pro::open_links_in_quick_view() ) {
			$script_params['open_links_in_quick_view'] = true;
		}

		wp_add_inline_script(
			self::SCRIPT_HANDLE,
			sprintf( 'const product_table_params = %s;', wp_json_encode( $script_params ) ),
			'before'
		);
	}

	public function load_head_scripts() {
		wp_enqueue_style( 'wc-product-table-head' );
	}

	/**
	 * Some themes take it upon themselves to remove core WC scripts & styles which we require, so re-register them here.
	 *
	 * @return void
	 */
	public function reregister_woocommerce_scripts() {
		$wc_version = Constants::get_constant( 'WC_VERSION' );

		// Register any scripts that we require that may have been dequeued by theme or other plugins.
		$required_styles = [
			'photoswipe'              => [
				'src'     => Util::get_wc_asset_url( 'css/photoswipe/photoswipe.min.css' ),
				'deps'    => [],
				'version' => $wc_version,
			],
			'photoswipe-default-skin' => [
				'src'     => Util::get_wc_asset_url( 'css/photoswipe/default-skin/default-skin.min.css' ),
				'deps'    => [ 'photoswipe' ],
				'version' => $wc_version,
			],
			'select2'                 => [
				'src'     => Util::get_wc_asset_url( 'css/select2.css' ),
				'deps'    => [],
				'version' => $wc_version,
			],
		];

		foreach ( $required_styles as $style => $script_data ) {
			if ( ! wp_style_is( $style, 'registered' ) ) {
				wp_register_style( $style, $script_data['src'], $script_data['deps'], $script_data['version'] );
			}
		}

		// Register any scripts that we require that may have been dequeued by theme or other plugins.
		$required_scripts = [
			'jquery-blockui'        => [
				'src'     => Util::get_wc_asset_url( 'js/jquery-blockui/jquery.blockUI.min.js' ),
				'deps'    => [ 'jquery' ],
				'version' => '2.7.0-wc.' . $wc_version,
			],
			'photoswipe'            => [
				'src'     => Util::get_wc_asset_url( 'js/photoswipe/photoswipe.min.js' ),
				'deps'    => [],
				'version' => '4.1.1-wc.' . $wc_version,
			],
			'photoswipe-ui-default' => [
				'src'     => Util::get_wc_asset_url( 'js/photoswipe/photoswipe-ui-default.min.js' ),
				'deps'    => [],
				'version' => '4.1.1-wc.' . $wc_version,
			],
			'selectWoo'             => [
				'src'     => Util::get_wc_asset_url( 'js/selectWoo/selectWoo.full.min.js' ),
				'deps'    => [ 'jquery' ],
				'version' => '1.0.9-wc.' . $wc_version,
			],
		];

		foreach ( $required_scripts as $script => $script_data ) {
			if ( ! wp_script_is( $script, 'registered' ) ) {
				wp_register_script( $script, $script_data['src'], $script_data['deps'], $script_data['version'], true );
			}
		}
	}

	/**
	 * Register the scripts & styles for an individual product table.
	 *
	 * @param Table_Args $args
	 */
	public static function load_table_scripts( Table_Args $args ) {
		do_action( 'wc_product_table_before_load_table_scripts', $args );

		// Queue the main table styles and scripts.
		wp_enqueue_style( self::SCRIPT_HANDLE );
		wp_enqueue_script( self::SCRIPT_HANDLE );

		// Queue the fixed-header script only when sticky header is enabled
		if ( $args->sticky_header ) {
			wp_enqueue_script( 'fixed-header' );
		}

		// Add fitVids for responsive video if we're displaying shortcodes.
		if ( apply_filters( 'wc_product_table_enable_fitvids', true ) ) {
			wp_enqueue_script( 'fitvids' );
		}

		// Queue media element and playlist scripts/styles.
		wp_enqueue_style( 'wp-mediaelement' );
		wp_enqueue_script( 'wp-mediaelement' );
		wp_enqueue_script( 'wp-playlist' );
		add_action( 'wp_footer', 'wp_underscore_playlist_templates', 0 );

		if ( in_array( 'buy', $args->columns, true ) ) {
			if ( 'dropdown' === $args->variations ) {
				wp_enqueue_script( 'wc-add-to-cart-variation' );
			}

			// Enqueue and localize add to cart script if not queued already.
			if ( $args->ajax_cart ) {
				wp_enqueue_script( 'wc-add-to-cart' );
			}
		}

		// Enqueue Photoswipe for image lightbox.
		if ( in_array( 'image', $args->columns, true ) && $args->lightbox ) {
			wp_enqueue_style( 'photoswipe-default-skin' );
			wp_enqueue_script( 'photoswipe-ui-default' );

			if ( false === has_action( 'wp_footer', 'woocommerce_photoswipe' ) ) {
				add_action( 'wp_footer', [ self::class, 'load_photoswipe_template' ] );
			}
		}

		do_action( 'wc_product_table_load_table_scripts', $args );
	}

	public static function load_photoswipe_template() {
		wc_get_template( 'single-product/photoswipe.php' );
	}

	private static function build_custom_styles( $options ) {
		$styles = [];
		$result = '';

		if ( ! empty( $options['use_theme'] ) && $options['use_theme'] !== 'theme' ) {
			$styles[] = [
				'selector' => 'table.dataTable > thead > tr > th, table.dataTable > thead > tr > td, table.wc-product-table, table.wc-product-table td, table.wc-product-table th',
				'css'      => 'border-width: 0px',
			];
		}
		if ( ! empty( $options['use_theme'] ) && $options['use_theme'] === 'dark' ) {
			$styles[] = [
				'selector' => 'table.wc-product-table tbody td',
				'css'      => 'background-color: #000000',
			];
			$styles[] = [
				'selector' => 'table.wc-product-table tbody td .quantity input.qty',
				'css'      => 'border-width: 0px',
			];
		}
		// Border outer
		if ( ! empty( $options['border_outer'] ) && $options['border_outer']['size'] >= 0 ) {
			$styles[] = [
				'selector' => 'table.wc-product-table.no-footer',
				'css'      => 'border-bottom-width: 0;',
			];
			$styles[] = [
				'selector' => 'table.wc-product-table',
				'css'      => CSS_Util::build_border_style( $options['border_outer'], 'all', true ),
			];
		}
		// Border header
		if ( ! empty( $options['border_header'] ) && $options['border_header']['size'] >= 0 ) {
			$styles[] = [
				'selector' => 'table.wc-product-table thead th',
				'css'      => CSS_Util::build_border_style( $options['border_header'], 'bottom', true ),
			];
			$styles[] = [
				'selector' => 'table.wc-product-table tfoot th',
				'css'      => CSS_Util::build_border_style( $options['border_header'], 'top', true ),
			];
		}
		// Border vertical cell
		if ( ! empty( $options['border_vertical_cell'] ) && $options['border_vertical_cell']['size'] >= 0 ) {
			$cell_left_css   = CSS_Util::build_border_style( $options['border_vertical_cell'], 'left', true );
			$cell_bottom_css = CSS_Util::build_border_style( $options['border_vertical_cell'], 'bottom', true );
			$cell_right_css  = CSS_Util::build_border_style( $options['border_vertical_cell'], 'right', true );

			if ( $cell_left_css ) {
				$styles[] = [
					'selector' => 'table.wc-product-table td, table.wc-product-table th',
					'css'      => 'border-width: 0;',
				];
				$styles[] = [
					'selector' => 'table.wc-product-table td:not(:first-child)',
					'css'      => $cell_left_css,
				];
			}
			$styles[] = [
				'selector' => 'table.wc-product-table.no-footer, table.wc-product-table thead',
				'css'      => 'border-width: 0px',
			];
		}
		// Border horizontal cell
		if ( ! empty( $options['border_horizontal_cell'] ) && $options['border_horizontal_cell']['size'] >= 0 ) {
			$cell_top_css = CSS_Util::build_border_style( $options['border_horizontal_cell'], 'top', true );

			if ( $cell_top_css ) {
				$styles[] = [
					'selector' => 'table.wc-product-table td, table.wc-product-table th',
					'css'      => 'border-width: 0;',
				];
				$styles[] = [
					'selector' => 'table.wc-product-table td',
					'css'      => $cell_top_css,
				];
				$styles[] = [
					'selector' => 'table.wc-product-table tfoot th',
					'css'      => $cell_top_css,
				];
			}
		}
		// Border bottom
		if ( ! empty( $options['border_bottom'] ) && $options['border_bottom']['size'] >= 0 ) {
			$cell_left_css = CSS_Util::build_border_style( $options['border_bottom'], 'bottom', true );

			if ( $cell_left_css ) {
				$styles[] = [
					'selector' => 'table.wc-product-table',
					'css'      => $cell_left_css,
				];
			}
		}
		// Header background
		if ( ! empty( $options['header_bg'] ) ) {
			$styles[] = [
				'selector' => 'table.wc-product-table thead, table.wc-product-table tfoot',
				'css'      => 'background-color: transparent;',
			];
			$styles[] = [
				'selector' => 'table.wc-product-table th',
				'css'      => CSS_Util::build_background_style( $options['header_bg'], true ),
			];
		}
		// Body background
		if ( ! empty( $options['cell_bg'] ) ) {
			$styles[]      = [
				'selector' => 'table.wc-product-table tbody tr',
				'css'      => 'background-color: transparent !important;',
			];
			$body_selector = 'table.wc-product-table tbody td';
			if ( ! empty( $options['cell_backgrounds'] ) && $options['cell_backgrounds'] === 'alternate-rows' ) {
				$body_selector = 'table.wc-product-table tbody tr:nth-child(even) td';
			}
			if ( ! empty( $options['cell_backgrounds'] ) && $options['cell_backgrounds'] === 'alternate-columns' ) {
				$body_selector = 'table.wc-product-table tbody tr td:nth-child(even)';
			}
			$styles[] = [
				'selector' => $body_selector,
				'css'      => CSS_Util::build_background_style( $options['cell_bg'], true ),
			];
		}
		// Header font
		if ( ! empty( $options['header_font'] ) ) {
			$styles[] = [
				'selector' => 'table.wc-product-table th',
				'css'      => CSS_Util::build_font_style( $options['header_font'], true ),
			];
		}
		// Body font
		if ( ! empty( $options['cell_font'] ) ) {
			$styles[] = [
				'selector' => 'table.wc-product-table tbody td, .wc-product-table-controls label, .wc-product-table-below, .wc-product-table-above, .dataTables_wrapper .dataTables_paginate .paginate_button.disabled',
				'css'      => CSS_Util::build_font_style( $options['cell_font'], true ),
			];
			if ( ! empty( $options['cell_font']['color'] ) ) {
				$styles[] = [
					'selector' => '.wc-product-table-wrapper input[type="search"]:focus',
					'css'      => sprintf( 'outline-color: %s;', $options['cell_font']['color'] ),
				];
			}
		}
		// Hyperlink font
		if ( ! empty( $options['hyperlink_font'] ) ) {
			$styles[] = [
				'selector' => 'table.wc-product-table tbody td a, .wc-product-table-reset a',
				'css'      => CSS_Util::build_font_style( $options['hyperlink_font'], true ),
			];
		}
		// Button font
		if ( ! empty( $options['button_font'] ) ) {
			$styles[] = [
				'selector' => 'table.wc-product-table tbody td .button.alt',
				'css'      => CSS_Util::build_font_style( $options['button_font'], true ),
			];
			$styles[] = [
				'selector' => '.wc-product-table-controls .wc-product-table-multi-form input[type=submit], .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button:hover',
				'css'      => CSS_Util::build_font_style( $options['button_font'], true ),
			];
		}
		// Button disabled font
		if ( ! empty( $options['disabled_button_font'] ) ) {
			$styles[] = [
				'selector' => 'table.wc-product-table tbody td .button.disabled.alt',
				'css'      => CSS_Util::build_font_style( $options['disabled_button_font'], true ),
			];
		}
		// Button quantity font
		if ( ! empty( $options['quantity_font'] ) ) {
			$styles[] = [
				'selector' => 'table.wc-product-table tbody td .quantity input.qty',
				'css'      => CSS_Util::build_font_style( $options['quantity_font'], true ),
			];
		}
		// Button background
		if ( ! empty( $options['button_bg'] ) ) {
			$styles[] = [
				'selector' => 'table.wc-product-table tbody td .button.alt',
				'css'      => CSS_Util::build_background_style( $options['button_bg'], true ),
			];
			$styles[] = [
				'selector' => '.wc-product-table-controls .wc-product-table-multi-form input[type=submit], .dataTables_wrapper .dataTables_paginate .paginate_button.current',
				'css'      => CSS_Util::build_background_style( $options['button_bg'], true ),
			];
			$styles[] = [
				'selector' => '.wc-product-table-controls .wc-product-table-multi-form input[type=submit], .dataTables_wrapper .dataTables_paginate .paginate_button.current, table.wc-product-table tbody td .button.alt',
				'css'      => 'border-width: 1px !important;',
			];
			$styles[] = [
				'selector' => '.wc-product-table-controls .wc-product-table-multi-form input[type=submit], table.wc-product-table tbody td .button.alt, .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover',
				'css'      => sprintf( 'border-color: %s !important;', esc_attr( $options['button_bg'] ) ),
			];
		}
		// Button background hover
		if ( ! empty( $options['button_bg_hover'] ) ) {
			$styles[] = [
				'selector' => 'table.wc-product-table tbody td .button.alt:hover',
				'css'      => CSS_Util::build_background_style( $options['button_bg_hover'], true ),
			];
			$styles[] = [
				'selector' => '.wc-product-table-controls .wc-product-table-multi-form input[type=submit]:hover, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover, .dataTables_wrapper .dataTables_paginate .paginate_button:hover',
				'css'      => CSS_Util::build_background_style( $options['button_bg_hover'], true ),
			];
			$styles[] = [
				'selector' => '.wc-product-table-controls .wc-product-table-multi-form input[type=submit]:hover, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover, .dataTables_wrapper .dataTables_paginate .paginate_button:hover, table.wc-product-table tbody td .button.alt:hover',
				'css'      => 'border-width: 1px !important;',
			];
			$styles[] = [
				'selector' => '.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover, .dataTables_wrapper .dataTables_paginate .paginate_button:hover',
				'css'      => sprintf( 'border-color: %s', esc_attr( $options['button_bg_hover'] ) ),
			];
		}
		// Button disabled background
		if ( ! empty( $options['button_disabled_bg'] ) ) {
			$styles[] = [
				'selector' => 'table.wc-product-table tbody td .button.disabled.alt',
				'css'      => CSS_Util::build_background_style( $options['button_disabled_bg'], true ),
			];
			$styles[] = [
				'selector' => 'table.wc-product-table tbody td .button.disabled.alt',
				'css'      => 'opacity: 1 !important;',
			];
			$styles[] = [
				'selector' => 'table.wc-product-table tbody td .button.disabled, .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover',
				'css'      => sprintf( 'border-color: %s !important;', esc_attr( $options['button_disabled_bg'] ) ),
			];
		}
		// Button quantity background
		if ( ! empty( $options['button_quantity_bg'] ) ) {
			$styles[] = [
				'selector' => 'table.wc-product-table tbody td .quantity input.qty',
				'css'      => CSS_Util::build_background_style( $options['button_quantity_bg'], true ),
			];
			$styles[] = [
				'selector' => 'table.wc-product-table tbody td .quantity input.qty',
				'css'      => sprintf( 'border-color: %s;', esc_attr( $options['button_quantity_bg'] ) ),
			];
		}
		// Dropdown background
		if ( ! empty( $options['dropdown_background'] ) ) {
			$styles[] = [
				'selector' => 'table.wc-product-table .wpt_variations_form .variations select, .wc-product-table-controls .select2-container .select2-selection--single',
				'css'      => CSS_Util::build_background_style( $options['dropdown_background'], true ),
			];
		}
		// Text background
		if ( ! empty( $options['text_background'] ) ) {
			$styles[] = [
				'selector' => '.wc-product-table-controls input[type=search]',
				'css'      => CSS_Util::build_background_style( $options['text_background'], true ),
			];
		}
		// Text font
		if ( ! empty( $options['text_font'] ) ) {
			$styles[] = [
				'selector' => '.wc-product-table-controls input[type=search]',
				'css'      => sprintf( 'color: %s !important', esc_attr( $options['text_font'] ) ),
			];
		}
		// Text border
		if ( ! empty( $options['text_border'] ) ) {
			$styles[] = [
				'selector' => '.wc-product-table-controls input[type=search]',
				'css'      => CSS_Util::build_border_style( $options['text_border'], 'all', true ),
			];
		}
		// Dropdown font
		if ( ! empty( $options['dropdown_font'] ) ) {
			$styles[] = [
				'selector' => 'table.wc-product-table .wpt_variations_form .variations select, .select2-container--default .select2-selection--single .select2-selection__rendered',
				'css'      => sprintf( 'color: %s !important', esc_attr( $options['dropdown_font'] ) ),
			];
		}
		// Dropdown border
		if ( ! empty( $options['dropdown_border'] ) ) {
			$styles[] = [
				'selector' => 'table.wc-product-table .wpt_variations_form .variations select, .wc-product-table-controls .select2-container .select2-selection--single',
				'css'      => CSS_Util::build_border_style( $options['dropdown_border'], 'all', true ),
			];
		}
		if ( ! empty( $options['checkboxes_border'] ) ) {
			$styles[] = [
				'selector' => 'table.wc-product-table .multi-cart .multi-cart-check input[type=checkbox]:checked + .wpt-multi-checkbox, table.wc-product-table[data-multicart-enabled=true] th.col-buy .wpt-bulk-select-wrap .wpt-bulk-select:checked + .wpt-multi-checkbox',
				'css'      => CSS_Util::build_background_style( $options['checkboxes_border'], true ),
			];
			$styles[] = [
				'selector' => 'table.wc-product-table .multi-cart .multi-cart-check input[type="checkbox"]:not(:disabled) + .wpt-multi-checkbox, table.wc-product-table[data-multicart-enabled=true] th.col-buy .wpt-bulk-select-wrap .wpt-bulk-select + .wpt-multi-checkbox',
				'css'      => sprintf( 'border-color: %s !important;', $options['checkboxes_border'] ),
			];
			$styles[] = [
				'selector' => 'table.wc-product-table .multi-cart .multi-cart-check input[type=checkbox]:disabled + .wpt-multi-checkbox',
				'css'      => CSS_Util::build_background_style( '#f5efe9', true ),
			];
		}
		if ( ! empty( $options['corner_style'] ) ) {
			if ( $options['corner_style'] === 'square-corners' ) {
				$styles[] = [
					'selector' => 'table.wc-product-table thead th, table.wc-product-table thead td, table.wc-product-table tfoot th, table.wc-product-table tfoot td, table.wc-product-table tbody td, table.wc-product-table tbody td .button.alt, table.wc-product-table .wpt_variations_form .variations select, .wc-product-table-controls .wc-product-table-multi-form input[type=submit], table.wc-product-table tbody td .quantity input.qty, .wc-product-table-controls .select2-container .select2-selection--single, .wc-product-table-controls input[type=search], .wc-product-table-controls .dataTables_paginate .paginate_button',
					'css'      => 'border-radius: 0 !important;',
				];
			}
			if ( $options['corner_style'] === 'fully-rounded' ) {
				$styles[] = [
					'selector' => 'table.wc-product-table thead th:first-child',
					'css'      => 'border-radius: 16px 0 0 0 !important;',
				];
				$styles[] = [
					'selector' => 'table.wc-product-table thead th:not(.dtr-hidden):last-of-type',
					'css'      => 'border-radius: 0 16px 0 0 !important;',
				];
				$styles[] = [
					'selector' => 'table.wc-product-table tfoot th:first-child, table.wc-product-table tbody tr:last-child td:first-child',
					'css'      => 'border-radius: 0 0 0 16px !important;',
				];
				$styles[] = [
					'selector' => 'table.wc-product-table tfoot th:last-child, table.wc-product-table tbody tr:last-child td:last-child',
					'css'      => 'border-radius: 0 0 16px 0 !important;',
				];
				if ( ! empty( $options['border_outer']['size'] ) ) {
					$styles[] = [
						'selector' => 'table.wc-product-table',
						'css'      => 'border-radius: 16px !important;',
					];
				}
				$styles[] = [
					'selector' => 'table.wc-product-table tbody td .button.alt, table.wc-product-table .wpt_variations_form .variations select, .wc-product-table-controls .wc-product-table-multi-form input[type=submit], table.wc-product-table tbody td .quantity input.qty, .wc-product-table-controls .select2-container .select2-selection--single, .wc-product-table-controls input[type=search], .wc-product-table-controls .dataTables_paginate .paginate_button',
					'css'      => 'border-radius: 18px !important;',
				];
			}
			if ( $options['corner_style'] === 'rounded-corners' ) {
				$styles[] = [
					'selector' => 'table.wc-product-table',
					'css'      => 'border-radius: 16px;',
				];
				$styles[] = [
					'selector' => 'table.wc-product-table thead th:first-child',
					'css'      => 'border-radius: 16px 0 0 0',
				];
				$styles[] = [
					'selector' => 'table.wc-product-table thead th:not(.dtr-hidden):last-of-type',
					'css'      => 'border-radius: 0 16px 0 0',
				];
				$styles[] = [
					'selector' => 'table.wc-product-table.no-footer tr:last-child td:first-child',
					'css'      => 'border-radius: 0 0 0 16px',
				];
				$styles[] = [
					'selector' => 'table.wc-product-table.no-footer tr:last-child td:last-child',
					'css'      => 'border-radius: 0 0 16px 0',
				];
				$styles[] = [
					'selector' => 'table.wc-product-table tfoot th:first-child',
					'css'      => 'border-radius: 0 0 0 16px',
				];
				$styles[] = [
					'selector' => 'table.wc-product-table tfoot th:last-child',
					'css'      => 'border-radius: 0 0 16px 0',
				];

				$border_radius_size = 18 + ( ! empty( $options['border_outer']['size'] ) ? $options['border_outer']['size'] : 1 );
				$styles[]           = [
					'selector' => 'table.wc-product-table',
					'css'      => "border-radius: {$border_radius_size}px !important;",
				];
				$styles[]           = [
					'selector' => 'table.wc-product-table tbody td .button.alt, table.wc-product-table .wpt_variations_form .variations select, .wc-product-table-controls .wc-product-table-multi-form input[type=submit], table.wc-product-table tbody td .quantity input.qty, .wc-product-table-controls .select2-container .select2-selection--single, .wc-product-table-controls input[type=search], .wc-product-table-controls .dataTables_paginate .paginate_button',
					'css'      => 'border-radius: 6px',
				];
			}
		}

		// Build the CSS styles
		foreach ( $styles as $style ) {
			if ( ! empty( $style['css'] ) ) {
				$result .= sprintf( '%1$s { %2$s } ', $style['selector'], $style['css'] );
			}
		}

		return trim( $result );
	}
}
