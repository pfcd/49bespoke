<?php

namespace Barn2\Plugin\WC_Product_Table;

use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Conditional;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Registerable;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Service\Standard_Service;
use Barn2\Plugin\WC_Product_Table\Dependencies\Lib\Util as Lib_Util;
use Barn2\Plugin\WC_Product_Table\Util\Util;
use Automattic\WooCommerce\Blocks\Options;

/**
 * This class handles adding the product table to the shop, archive, and product search pages.
 *
 * @package   Barn2\woocommerce-product-table
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */
class Template_Handler implements Standard_Service, Registerable, Conditional {

	public function is_required() {
		return Lib_Util::is_front_end();
	}

	public function register() {
		add_action( 'template_redirect', [ __CLASS__, 'template_shop_override' ] );
	}

	public static function template_shop_override() {
		global $wp_query;

		$shop_templates_tables = Util::get_shop_templates_tables();
		$override              = false;

		if ( is_shop() && isset( $_GET['s'] ) && isset( $shop_templates_tables['search_override'] )
			|| is_shop() && ! isset( $_GET['s'] ) && isset( $shop_templates_tables['shop_override'] )
			|| is_product_category() && isset( $shop_templates_tables['archive_override'] )
			|| is_tax() && taxonomy_is_product_attribute( $wp_query->queried_object->taxonomy ) && isset( $shop_templates_tables['attribute_override'] )
			|| is_tax() && ! taxonomy_is_product_attribute( $wp_query->queried_object->taxonomy ) && isset( $shop_templates_tables[ $wp_query->queried_object->taxonomy . '_override' ] )
		) {
			$override = true;
		}

		$override = apply_filters( 'wc_product_table_use_table_layout', $override );

		if ( $override === true ) {
			add_action( 'woocommerce_before_shop_loop', [ __CLASS__, 'disable_default_woocommerce_loop' ] );
			add_action( 'woocommerce_after_shop_loop', [ __CLASS__, 'add_product_table_after_shop_loop' ] );
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

			// Force WooCommerce to use non blockified templates, so that the initial WooCommerce layout doesn't appear.
			if ( defined( 'Automattic\WooCommerce\Blocks\Options::WC_BLOCK_USE_BLOCKIFIED_PRODUCT_GRID_BLOCK_AS_TEMPLATE' ) ) {
				add_filter(
					'option_' . Options::WC_BLOCK_USE_BLOCKIFIED_PRODUCT_GRID_BLOCK_AS_TEMPLATE,
					function () {
						return 'no';
					}
				);
			}

			$theme    = wp_get_theme();
			$template = $theme->get( 'Template' );
			$name     = $theme->get( 'Name' );

			if ( $template == 'genesis' || $name == 'Genesis' ) {
				// Replace Genesis loop with product table
				remove_action( 'genesis_loop', 'genesis_do_loop' );
				add_action( 'genesis_loop', [ __CLASS__, 'add_product_table_after_shop_loop' ] );
			} elseif ( $name == 'Storefront' ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
				remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
				remove_action( 'woocommerce_before_shop_loop', 'storefront_sorting_wrapper', 9 );
				remove_action( 'woocommerce_before_shop_loop', 'storefront_sorting_wrapper_close', 31 );
				remove_action( 'woocommerce_after_shop_loop', 'storefront_sorting_wrapper', 9 );
				remove_action( 'woocommerce_after_shop_loop', 'storefront_sorting_wrapper_close', 31 );
			} elseif ( $name == 'Avada' ) {
				global $avada_woocommerce;

				if ( ! empty( $avada_woocommerce ) ) {
					remove_action( 'woocommerce_before_shop_loop', [ $avada_woocommerce, 'catalog_ordering' ], 30 );
				}
			} elseif ( $name == 'XStore' ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
				remove_action( 'woocommerce_before_shop_loop', 'etheme_grid_list_switcher', 35 );
				remove_action( 'woocommerce_before_shop_loop', 'etheme_products_per_page_select', 37 );
			}
		}
	}

	public static function disable_default_woocommerce_loop() {
		$GLOBALS['woocommerce_loop']['total'] = false;
	}

	public static function add_product_table_after_shop_loop() {
		if ( is_product_category() && 'subcategories' === woocommerce_get_loop_display_mode() ) {
			return;
		}
		
		$shortcode = '[product_table]';

		$args = shortcode_parse_atts( str_replace( [ '[product_table', ']' ], '', $shortcode ) );

		$args = ! empty( $args ) && is_array( $args ) ? $args : [];

		$shop_templates_tables = Util::get_shop_templates_tables();

		if ( is_shop() && ! get_query_var( 's' ) ) {
			if ( isset( $shop_templates_tables['shop_override'] ) ) {
				$args['id'] = $shop_templates_tables['shop_override']['id'];
			}
		} elseif ( is_product_category() ) {
			// Product category archive
			$args['category'] = get_queried_object_id();

			if ( isset( $shop_templates_tables['archive_override'] ) ) {
				$args['id'] = $shop_templates_tables['archive_override']['id'];
			}
		} elseif ( is_product_tag() ) {
			// Product tag archive
			$args['tag'] = get_queried_object_id();

			if ( isset( $shop_templates_tables['product_tag_override'] ) ) {
				$args['id'] = $shop_templates_tables['product_tag_override']['id'];
			}
		} elseif ( is_product_taxonomy() ) {
			// Other product taxonomy archive
			$term         = get_queried_object();
			$args['term'] = "{$term->taxonomy}:{$term->term_id}";

			if ( isset( $shop_templates_tables[ $term->taxonomy . '_override' ] ) ) {
				$args['id'] = $shop_templates_tables[ $term->taxonomy . '_override' ]['id'];
			}
		} elseif ( is_post_type_archive( 'product' ) && ( $search_term = get_query_var( 's' ) ) ) {
			// Product search results page
			$args['search_term'] = $search_term;

			if ( isset( $shop_templates_tables['search_override'] ) ) {
				$args['id'] = $shop_templates_tables['search_override']['id'];
			}
		}

		// Display the product table
		wc_the_product_table( $args );
	}
}
