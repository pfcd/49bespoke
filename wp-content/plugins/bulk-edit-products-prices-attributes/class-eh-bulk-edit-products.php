<?php
/**
 *
 * Main File for loading classes.
 *
 * @package ELEX Bulk Edit Products, Prices & Attributes for Woocommerce
 */

/*
Plugin Name: Bulk Edit Products, Prices & Attributes for Woocommerce
Plugin URI: https://woo.com/products/bulk-edit-products-prices-and-attributes/
Description: Bulk Edit Products, Prices & Attributes for Woocommerce allows you to edit products prices and attributes as Bulk.
Version: 2.2.0
WC requires at least: 2.6.0
WC tested up to: 9.3
Author: ELEXtensions
Author URI: https://elextensions.com/
Developer: ELEXtensions
Developer URI: https://elextensions.com
Woo: 5712599:27c30b94d3eab8ed87448f123ca288ce
Text Domain: eh_bulk_edit
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! defined( 'EH_BEP_DIR' ) ) {
	define( 'EH_BEP_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'EH_BEP_TEMPLATE_PATH' ) ) {
	define( 'EH_BEP_TEMPLATE_PATH', EH_BEP_DIR . 'templates' );
}
require 'includes/wp-fluent/autoload.php';
require_once ABSPATH . 'wp-admin/includes/plugin.php';

	$elex_bep_basic_plugin_slug       = 'elex-bulk-edit-products-prices-attributes-for-woocommerce-basic/elex-bulk-edit-woocommerce-products-basic.php';
	$elex_bep_premium_plugin_slug     = 'eh-bulk-edit-products/class-eh-bulk-edit-products.php';
	$elex_bep_basic_woomp_plugin_slug = 'eh-bulk-edit-products/class-eh-bulk-edit-products.php';
/**
 * Check if the ELEX Bulk Edit Products Basic plugin is active.
 *
 * This checks if the class 'Eh_Bulk_Edit_Products_Basic' exists or if the plugin is active either
 * in a multisite environment (network-wide) or individually for the site.
 * The 'active_plugins' filter is used to get the list of currently active plugins.
 *
 * @hook active_plugins
 * @since 1.0.0
 */
if ( class_exists( 'Eh_Bulk_Edit_Products_Basic' ) || ( is_multisite() && ( is_plugin_active_for_network( $elex_bep_basic_plugin_slug ) || in_array( $elex_bep_basic_plugin_slug, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) ) ) {
	deactivate_plugins( plugin_basename( __FILE__ ), false, true );
	wp_die(esc_html_e( 'ELEX BASIC Version of this Plugin activated. Please deactivate the BASIC Version before activating Woocommerce Version.', 'eh_bulk_edit' ), '', array('back_link' => 1));
}
/**
 * Check if the ELEX WooMP Bulk Edit Products Basic plugin is active.
 *
 * This checks if the class 'Eh_Woomp_Bulk_Edit_Products_Basic' exists or if the WooMP Bulk Edit Basic plugin is active,
 * either in a multisite environment (network-wide) or individually for the site.
 * It uses the 'active_plugins' filter to get the list of active plugins and checks for network activation in a multisite setup.
 *
 * @hook active_plugins
 * @since 1.0.0
 */
if ( class_exists( 'Eh_Woomp_Bulk_Edit_Products_Basic' ) || ( is_multisite() && ( is_plugin_active_for_network( $elex_bep_basic_woomp_plugin_slug ) || in_array( $elex_bep_basic_woomp_plugin_slug, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) ) ) {
	deactivate_plugins( plugin_basename( __FILE__ ), false, true );
	wp_die(esc_html_e( 'The WooCommerce basic version of this plugin is active. Please deactivate it before activating the WooCommerce premium version.', 'eh_bulk_edit' ), '', array('back_link' => 1));
}
/**
 * Check if the ELEX Bulk Edit Products Premium plugin is active.
 *
 * This checks if the class 'Eh_Bulk_Edit_Products_Premium' exists or if the premium plugin is active,
 * either in a multisite environment (network-wide) or individually for the site.
 * It uses the 'active_plugins' filter to get the list of active plugins and checks for network activation in a multisite setup.
 *
 * @hook active_plugins
 * @since 1.0.0
 */
if ( class_exists( 'Eh_Bulk_Edit_Products_Premium' ) || ( is_multisite() && ( is_plugin_active_for_network( $elex_bep_premium_plugin_slug ) || in_array( $elex_bep_premium_plugin_slug, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) ) ) {
	deactivate_plugins( plugin_basename( __FILE__ ), false, true );
	wp_die(esc_html_e( 'PREMIUM Version of this Plugin Installed. Please deactivate the PREMIUM Version before activating Woocommerce Version.', 'eh_bulk_edit' ), '', array('back_link' => 1));
}
// for Required functions
if ( ! function_exists( 'elex_be_premium_is_woocommerce_active' ) ) {
	require_once  'elex-includes/elex-be-functions.php' ;
}
// to check woocommerce is active
if ( ! ( elex_be_premium_is_woocommerce_active() ) ) {
	add_action( 'admin_notices', 'woocommerce_activation_notice_in_premium' );
	return;
}

function woocommerce_activation_notice_in_premium() {  ?>
	<div id="message" class="error">
		<p>
			<?php echo( esc_attr_e( 'WooCommerce plugin must be active for Bulk Edit Products, Prices & Attributes for Woocommerce plugin to work.', 'eh_bulk_edit' ) ); ?>
		</p>
	</div>
	<?php
}
require_once __DIR__ . '/includes/class_eh_bulkedit_table.php';
add_action( 'admin_init', 'bulk_edit_create_job_tables', 1 );
/**
 * Check if the WooCommerce plugin is active.
 *
 * This checks if the WooCommerce plugin is active either for a single site or network-wide in a multisite environment.
 * It uses the 'active_plugins' filter to get the list of currently active plugins and checks for network activation in a multisite setup.
 *
 * @hook active_plugins
 * @since 1.0.0
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) || ( is_multisite() && is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) ) {

	if ( !class_exists ('Eh_Bulk_Edit_Products_Woocommerce')) {
		/**
		 *  Bulk Product Edit class
		 */
		class Eh_Bulk_Edit_Products_Woocommerce {
				/** Constructor. */
			public function __construct() {
				add_filter(
					'plugin_action_links_' . plugin_basename( __FILE__ ),
					array(
							$this,
							'eh_bep_action_link',
						)
				); // to add settings, doc, etc options to plugins base.
				$this->eh_bep_include_lib();
			}
				/** Include Lib. */
			public function eh_bep_include_lib() {
				include_once 'includes/class-eh-bulk-edit-init.php';
				include_once 'includes/class-schedule-jobs.php';
			}
				/** Action Link.
				 *
				 * @param var $links links.
				 */
			public function eh_bep_action_link( $links ) {
				$plugin_links = array(
						'<a href = "' . admin_url( 'admin.php?page=eh-bulk-edit-product-attr' ) . '">' . __( 'Bulk Edit Products', 'eh_bulk_edit' ) . '</a>',
						'<a href = "https://woo.com/document/bulk-edit-products-prices-and-attributes/" target="_blank">' . __( 'Documentation', 'eh_bulk_edit' ) . '</a>',
						'<a href = "https://elextensions.com/support/" target="_blank">' . __( 'Support', 'eh_bulk_edit' ) . '</a>',
				);
				return array_merge( $plugin_links, $links );
			}
		}
		new Eh_Bulk_Edit_Products_Woocommerce();
	}

}
// High performance order tables compatibility.
add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );
/** Load Plugin Text Domain. */
if ( !function_exists( 'elex_bep_load_plugin_textdomain' ) ) {
	
	function elex_bep_load_plugin_textdomain() {
		load_plugin_textdomain( 'eh_bulk_edit', false, basename( dirname( __FILE__ ) ) . '/lang/' );
	}
}
add_action( 'plugins_loaded', 'elex_bep_load_plugin_textdomain' );

// review component
if ( ! function_exists( 'get_plugin_data' ) ) {
	require_once  ABSPATH . 'wp-admin/includes/plugin.php';
}
require_once __DIR__ . '/review_and_troubleshoot_notify/review-and-troubleshoot-notify-class.php';
	$data                      = get_plugin_data( __FILE__ );
	$data['name']              = $data['Name'];
	$data['basename']          = plugin_basename( __FILE__ );
	$data['documentation_url'] = 'https://woo.com/document/bulk-edit-products-prices-and-attributes/';
	$data['support_url']       = 'https://support.elextensions.com/';
new \Elex_Review_Components( $data );
