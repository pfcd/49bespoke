<?php
/*
Plugin Name: Product Carousel for Divi and WooCommerce
Plugin URI: https://wpzone.co/product/product-carousel-for-divi-and-woocommerce/
Version: 1.0.15
Description: Plugin that adds an extra module “Woo Carousel” to Divi Builder (compatible with Divi Theme, Divi Builder Plugin, Extra Theme) that will display products carousel
Author: WP Zone
Author URI: https://wpzone.co/
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html
Text Domain: woocommerce-carousel-for-divi
GitLab Plugin URI: https://gitlab.com/aspengrovestudios/woocommerce-carousel-for-divi/
Domain Path: /languages
AGS Info: ids.aspengrove 819168 ids.divispace 819168 legacy.key ds_woo_carousel_license_key legacy.status ds_woo_carousel_license_status adminPage admin.php?page=ds-woo-carousel docs https://wpzone.co/docs/product-carousel-for-divi-and-woocommerce/

Despite the following, this project is licensed exclusively
under GNU General Public License (GPL) version 3 (no future versions).
This statement modifies the following text.

Product Carousel for Divi and WooCommerce plugin
Copyright (C) 2023  WP Zone

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <https://www.gnu.org/licenses/>.


============

For the text of the GNU General Public License version 3, and licensing/copyright
information for third-party code used in this product, see ./license.txt.

*/
update_option ('ds_woo_carousel_license_status', 'valid');
update_option ('ds_woo_carousel_license_key', '*********');

define( 'DSWC_URL', plugins_url( '', __FILE__ ) );
add_action( 'divi_extensions_init', array('DS_Woo_Carousel', 'initialize_extension') );
add_filter( 'et_fb_get_asset_definitions', array('DS_Woo_Carousel', 'get_asset_definitions'), 11 );
// wp-layouts\ags-layouts.php
add_action('admin_menu', array('DS_Woo_Carousel', 'registerAdminPage'), 11);
// wp-layouts\ags-layouts.php
add_action('admin_enqueue_scripts', array('DS_Woo_Carousel', 'adminScripts'));

add_action('before_woocommerce_init', ['DS_Woo_Carousel', 'onBeforeWoocommerceInit']);


require_once(__DIR__.'/updater/updater.php');


class DS_Woo_Carousel {
	
	const	PLUGIN_NAME			= 'Product Carousel for Divi and WooCommerce',
			PLUGIN_AUTHOR		= 'WP Zone',
			PLUGIN_VERSION		= '1.0.15',
			PLUGIN_STORE_URL	= 'https://wpzone.co/',
			PLUGIN_PAGE			= 'admin.php?page=ds-woo-carousel',
			PLUGIN_FILE			= __FILE__,
			PLUGIN_SLUG			= 'woocommerce-carousel-for-divi';

	// wp-layouts\ags-layouts.php
	public static function registerAdminPage() {
		/* Admin Pages */
        add_submenu_page('et_divi_options', esc_html__( 'Product Carousel', 'woocommerce-carousel-for-divi'), esc_html__( 'Product Carousel', 'woocommerce-carousel-for-divi'), 'manage_options', 'ds-woo-carousel', array(__CLASS__, 'adminPage'));
	}
	
	// wp-layouts\ags-layouts.php
	public static function adminScripts() {
		
		// phpcs:ignore WordPress.Security.NonceVerification -- just checking which page we are on
		if ( isset($_GET['page']) && $_GET['page'] == 'ds-woo-carousel' ) {
			// wp-layouts\ags-layouts.php
			wp_enqueue_style('ags-layouts-admin', DSWC_URL.'/styles/admin.css', array(), self::PLUGIN_VERSION);
			wp_enqueue_style('ags-addons-admin', DSWC_URL.'/includes/addons/css/admin.css', array(), self::PLUGIN_VERSION);
		}
		
	}
	
	// hm-product-sales-report-pro\hm-product-sales-report.php
	public static function onBeforeWoocommerceInit() {
		class_exists('Automattic\WooCommerce\Utilities\FeaturesUtil') && Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__);
	}
	
	public static function adminPage() {
		
        if (ds_woo_carousel_has_license_key()) {
        
            ?>

            <div id="ds_woo_carousel-settings-container">
            <div id="ds_woo_carousel-settings">

                <div id="ds_woo_carousel-settings-header">
                    <div class="ds_woo_carousel-settings-logo">
                        <h2><?php esc_html_e('Product Carousel for Divi and WooCommerce', 'woocommerce-carousel-for-divi'); ?></h2>
                    </div>
                    <div id="ds_woo_carousel-settings-header-links">
                        <a id="ds_woo_carousel-settings-header-link-support"
                           href="https://wpzone.co/docs/product-carousel-for-divi-and-woocommerce/"
                           target="_blank"><?php esc_html_e('Documentation', 'woocommerce-carousel-for-divi'); ?></a>
                    </div>
                </div>

                <ul id="ds_woo_carousel-settings-tabs">
                    <li class="ds_woo_carousel-settings-active">
                        <a href="#about"><?php esc_html_e('About', 'woocommerce-carousel-for-divi'); ?></a>
                    </li>
                    <li><a href="#addons"><?php esc_html_e('Addons', 'woocommerce-carousel-for-divi') ?></a></li>
                    
                    <li><a href="#license"><?php esc_html_e('License Key', 'woocommerce-carousel-for-divi'); ?></a></li>
                    
                </ul>

                <div id="ds_woo_carousel-settings-tabs-content">
                    <div id="ds_woo_carousel-settings-about" class="ds_woo_carousel-settings-active">

                        <h2><?php esc_html_e('Product Carousel for Divi and WooCommerce', 'woocommerce-carousel-for-divi') ?></h2>
                        <?php esc_html_e('Beautiful, simple, and totally customizable product sliders and carousels for your WooCommerce shop. Add product carousels anywhere you use the Divi builder and customize every element with the drag-and-drop editor.', 'woocommerce-carousel-for-divi') ?>

                        <h3><?php esc_html_e('Main features', 'woocommerce-carousel-for-divi') ?>:</h3>
                        <ul>
                            <li><?php esc_html_e('Choose elements and display order – titles, images, ratings, price, and buttons', 'woocommerce-carousel-for-divi') ?> </li>
                            <li><?php esc_html_e('Dynamic product sorting – set what products show base on publish date, category, rating, price, availability, and more', 'woocommerce-carousel-for-divi') ?></li>
                            <li><?php esc_html_e('Set products count – choose how many items your carousel includes', 'woocommerce-carousel-for-divi') ?></li>
                            <li><?php esc_html_e('Easy style controls – set the space, size, and padding around each item', 'woocommerce-carousel-for-divi') ?></li>
                            <li><?php esc_html_e('Autoplay and user-controlled scroll options – set to rotate automatically and icon or paginate click-to-advance controls', 'woocommerce-carousel-for-divi') ?></li>
                            <li><?php esc_html_e('“Buy Now” button – allow users to purchase products right from the carousel', 'woocommerce-carousel-for-divi') ?></li>
                            <li><?php esc_html_e('Sales badges built-in – customize your sales bandages', 'woocommerce-carousel-for-divi') ?></li>
                            <li><?php esc_html_e('Include star ratings – Customers rely on reviews, display highly rated product ratings', 'woocommerce-carousel-for-divi') ?></li>
                            <li><?php esc_html_e('Animations and hover effects – animated slide and scroll-over overlays', 'woocommerce-carousel-for-divi') ?></li>
                            <li><?php esc_html_e('Divi integrated – Divi default plus all the expanded module settings', 'woocommerce-carousel-for-divi') ?></li>
                        </ul>
                        <a href="https://wpzone.co/product/product-carousel-for-divi-and-woocommerce/" target="_blank"><?php esc_html_e ('Read More about plugin features', 'woocommerce-carousel-for-divi') ?>.</a>

                        <h3><?php esc_html_e('Product documentation', 'woocommerce-carousel-for-divi') ?></h3>
	                    <?php printf( esc_html__ ('Get started your adventure with Product Carousel for Divi with a %splugin documentation%s that covers the basics ', 'woocommerce-carousel-for-divi'), '<a href="https://wpzone.co/docs/product-carousel-for-divi-and-woocommerce/" target="_blank">', '</a>'  ); ?>

                        <h3><?php esc_html_e('Premade layouts', 'woocommerce-carousel-for-divi') ?></h3>
	                    <?php printf( esc_html__ ('Product Carousel ships great premade layouts that you can use to jumpstart your design. %sLearn how to import layouts to your site%s. ', 'woocommerce-carousel-for-divi'), '<a href="https://wpzone.co/docs/product-carousel-for-divi-and-woocommerce/#docs-10" target="_blank">', '</a>'  ); ?>


                    </div>

                    <div id="ds_woo_carousel-settings-addons" >
		                <?php
		                define('AGS_PRODUCT_CAROUSEL_ADDONS_URL', 'https://wpzone.co/wp-content/uploads/product-addons/product-carousel.json');
		                require_once(dirname(__FILE__) . '/includes/addons/addons.php');
		                AGS_Product_Carousel_Addons::outputList();
		                ?>
                    </div>


                    
                    <div id="ds_woo_carousel-settings-license">
                        <?php ds_woo_carousel_license_key_box(); ?>
                    </div>
                    
                </div>
            </div>

            <script>
                var ds_woo_carousel_tabs_navigate = function () {
                    jQuery('#ds_woo_carousel-settings-tabs-content > div, #ds_woo_carousel-settings-tabs > li').removeClass('ds_woo_carousel-settings-active');
                    jQuery('#ds_woo_carousel-settings-' + location.hash.substr(1)).addClass('ds_woo_carousel-settings-active');
                    jQuery('#ds_woo_carousel-settings-tabs > li:has(a[href="' + location.hash + '"])').addClass('ds_woo_carousel-settings-active');
                };

                if (location.hash) {
                    ds_woo_carousel_tabs_navigate();
                }

                jQuery(window).on('hashchange', ds_woo_carousel_tabs_navigate);
            </script>

            <?php
        
        } else {
           ds_woo_carousel_activate_page();
        }
		
    }


	
	
	static function initialize_extension() {
		if ( function_exists('WC') ) {
			
		    if (ds_woo_carousel_has_license_key()) {
            
				require_once plugin_dir_path( __FILE__ ) . 'includes/WoocommerceCarouselForDivi.php';
            
			}
			

		}
	}
	
	static function get_products( $post ) {

		$options = array(
			'limit'  => isset( $post['product_count'] ) ? (int) $post['product_count'] : 3,
			'status' => 'publish',
			'visibility' => 'catalog'
		);
		
		if ( isset( $post['out_of_stock'] ) && $post['out_of_stock'] == 'off' ) {
			$options['stock_status'] = 'instock';
		}

		if ( isset( $post['sort_by'] ) ) {
			/*
			$orderby            = isset( $options['orderby'] ) && is_array( $options['orderby'] ) ? $options['orderby'] : array();
			$options['orderby'] = array_merge( $options['orderby'], array( sanitize_text_field( $post['sort_by'] ) => 'DESC' ) );
			*/
			
			$sortDir = isset( $post['sort_dir'] ) && $post['sort_dir'] == 'ASC' ? 'ASC' : 'DESC';
			
			switch ( $post['sort_by'] ) {
				case 'rand':
					$options = array_merge(
						$options,
						array(
							'orderby' => 'rand',
						)
					);
					break;
				case 'price':
					$options = array_merge(
						$options,
						array(
							'meta_key' => '_price', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
							'orderby'  => array( 'meta_value_num' => $sortDir ),
						)
					);
					break;
				case 'stock':
					$options = array_merge(
						$options,
						array(
							'meta_key' => '_stock', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
							'orderby'  => array( 'meta_value_num' => $sortDir ),
						)
					);
					break;
				default:
					$options = array_merge(
						$options,
						array(
							'orderby' => 'date',
							'order'   => $sortDir,
						)
					);

			}
		}

		if ( isset( $post['product_view_type'] ) ) {
			$viewType = sanitize_text_field( $post['product_view_type'] );
			switch ($viewType) {
				case 'recent_products':
					$options = array_merge(
						$options,
						array(
							'orderby' => 'date',
							'order'   => 'DESC',
						)
					);
					break;
				case 'best_selling_products':
					$options = array_merge(
						$options,
						array(
							'meta_key' => 'total_sales', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
							'orderby'  => array( 'meta_value_num' => 'DESC' ),
						)
					);
					break;
				case 'top_rated_products':
					$options = array_merge(
						$options,
						array(
							'meta_key' => '_wc_average_rating', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
							'orderby'  => array( 'meta_value_num' => 'DESC' ),
						)
					);
					break;
				case 'featured_products':
					$options = array_merge( $options, array( 'featured' => true ) );
					break;
				case 'products_category':
				case 'products_tag':
					if ( isset( $post[$viewType] ) ) {
						$products_category = explode( ',', sanitize_text_field( $post[$viewType] ) );
						if ( ! in_array( 'all', $products_category ) ) {
							$taxonomy = ($viewType == 'products_tag') ? 'product_tag' : 'product_cat';
							$terms = array();
							foreach ( $products_category as $cat ) {
								if ( get_term_by( 'id', $cat, $taxonomy ) ) {
									$terms[] = get_term_by( 'id', $cat, $taxonomy )->slug;
								}
							}

							$options = array_merge( $options, array( ($viewType == 'products_tag' ? 'tag' : 'category') => $terms ) );
						}
					}
					break;
				default:
			}
		}

		// Remove query filters that may have been set by the main shop page query
		WooCommerce::instance()->query->remove_product_query_filters(null);

		$products_query = wc_get_products( $options );
		$products       = array();
		foreach ( $products_query as $key => $product ) {
			$products[ $key ]              = $product->get_data();
			$products[ $key ]['price_html'] = $product->get_price_html();
			$products[ $key ]['rating_html'] = wc_get_rating_html( $product->get_average_rating() );
			$products[ $key ]['image_html'] = $product->get_image('large');
			$products[ $key ]['sale'] = $product->is_on_sale() ? 1 : 0;
		}

		return $products;
	}
	
		
	// Divi\includes\builder\functions.php
	static function get_asset_definitions( $defs ) {
		
		if ( class_exists('DSWC_WoocommerceCarousel_Child') ) {
			
			$shortcodes = '';
			foreach ( DSWC_WoocommerceCarousel_Child::$TYPES as $type => $label ) {
				$shortcodes .= '[dswc_woocommerce_carousel_child item="' . $type . '" item_title="' . $label . '" /]';
			}

			return $defs . sprintf(
				'; window.DSWCWoocommerceCarouselBackend=%s;',
				et_fb_remove_site_url_protocol(
					wp_json_encode(
						array(
							// Divi\includes\builder\functions.php
							'defaultContent' => et_fb_process_shortcode( $shortcodes ),
						),
						ET_BUILDER_JSON_ENCODE_OPTIONS
					)
				)
			);
		}
		
		return $defs;
		
		
	}
}


