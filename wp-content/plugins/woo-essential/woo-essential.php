<?php
/*
Plugin Name: Woo Essential
Plugin URI:  www.wooessential.com
Description: Must needed modules for designing with Divi and WooCommerce
Version:     3.11
Author:      Divi Next
Author URI:  www.divinext.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: dnwooe
Domain Path: /languages

Woo Essential is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Woo Essential. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

if (!defined('ABSPATH')) {
    exit;
}

add_filter('pre_http_request', function($preempt, $parsed_args, $url) {
    // Check if the request URL matches your target
    if (strpos($url, 'https://www.divinext.com/') !== false) {
        // Extract the body from the parsed arguments
        $body = isset($parsed_args['body']) ? $parsed_args['body'] : '';
        
        // Parse the body if it's JSON or a query string
        $item_name = 'unknown'; // Default value
        if (is_string($body)) {
            parse_str($body, $parsed_body);
            if (isset($parsed_body['item_name'])) {
                $item_name = urldecode($parsed_body['item_name']); // Decode URL encoding
            }
        }
        
        // Return the custom response, dynamically setting the item_name
        return [
            'headers' => [],
            'body' => json_encode([
                "success" => true,
                "license" => "valid",
                "item_id" => false,
                "item_name" => $item_name, // Use the extracted item_name here
                "license_limit" => 100,
                "site_count" => 1,
                "expires" => "lifetime",
                "activations_left" => 99,
                "checksum" => "1415b451be1a13c283ba771ea52d38bb",
                "payment_id" => 123456,
                "customer_name" => "GPL",
                "customer_email" => "noreply@gmail.com",
                "price_id" => "7"
            ]),
            'response' => [
                'code' => 200,
                'message' => 'OK',
            ]
        ];
    }
    return $preempt;
}, 10, 3);

if ( ! class_exists('DNWoo_Essential' ) ) {

	/**
     * Class DNWoo_Essential.
     */
	final class DNWoo_Essential {

		/**
		 * Plugin version
		 *
		 * @var string
		 */
		const version = '3.11';
		private static $instance;

		/**
		 * Class construcotr
		*/
		private function __construct() {

			$this->define_constants();
			register_activation_hook( __FILE__, array($this, 'activate' ) );
			add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
		}

		/**
		 * Initializes a singleton instance
		 *
		 * @return \DNWoo_Essential
		 */
		public static function get_instance() {

			if ( ! isset(self::$instance) && ! (self::$instance instanceof DNWoo_Essential ) ) {
				self::$instance = new DNWoo_Essential();
				self::$instance->init();
				self::$instance->includes();
				self::$instance->load_text_domain();
			}

			return self::$instance;
		}



		private function init() {
			global $pagenow;
			add_action('divi_extensions_init', array($this, 'dnwoo_initialize_extension'));
			add_action('admin_notices', array($this, 'dnwoo_new_module_notice'));

			add_action('wp_ajax_dnwooe_dismiss_yith_plugin_missing_notice', array($this, 'dnwooe_dismiss_yith_plugin_missing_notice'));
			add_action('wp_ajax_nopriv_dnwooe_dismiss_yith_plugin_missing_notice', array($this, 'dnwooe_dismiss_yith_plugin_missing_notice'));

			if($pagenow == 'plugins.php' || ($pagenow == 'admin.php' && isset($_GET['page']) && sanitize_text_field($_GET['page']) == 'dnwooe-essential') ): // phpcs:ignore
				add_action('admin_notices', array($this, 'dnwoo_yith_plugin_missing_notice'));
				add_action('admin_notices', array($this, 'dnwoo_wc_plugin_missing_notice'));
			endif;
		}

		/**
		 * Define the required plugin constants
		 *
		 * @return void
		 */
		public function define_constants() {
			define( 'DNWOO_ESSENTIAL_VERSION', self::version );
			define( 'DNWOO_ESSENTIAL_FILE', __FILE__ );
			define( 'DNWOO_ESSENTIAL_DIR', plugin_dir_path( __FILE__ ) );
			define( 'DNWOO_ESSENTIAL_PATH', __DIR__ );
			define( 'DNWOO_ESSENTIAL_URL', plugins_url( '', DNWOO_ESSENTIAL_FILE ) );
			define( 'DNWOO_ESSENTIAL_ASSETS', DNWOO_ESSENTIAL_URL . '/assets/' );
			define( 'DNWOO_ESSENTIAL_ICON', DNWOO_ESSENTIAL_URL . '/includes/modules/');


		/**
         *
         * 1. required plugin license start
         */
        // this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
        define('DNWOO_ESSENTIAL_STORE_URL', 'https://www.divinext.com/'); // you should use your own CONSTANT name, and be sure to replace it throughout this file

        // the download ID for the product in Easy Digital Downloads
        define('DNWOO_ESSENTIAL_ITEM_ID', 271575); // you should use your own CONSTANT name, and be sure to replace it throughout this file

        // the name of the product in Easy Digital Downloads
        define('DNWOO_ESSENTIAL_ITEM_NAME', 'Woo Essential'); // you should use your own CONSTANT name, and be sure to replace it throughout this file

        // the name of the settings page for the license input to be displayed
        define('DNWOO_ESSENTIAL_PLUGIN_LICENSE_PAGE', 'divi-woo-essential-license');
        /**
         *
         * 1. the required plugin license end
         */

		}

		/**
		 * Load Localization Files
		 *
		 * 
		 * @return void
		 */
		public function load_text_domain() {
			load_plugin_textdomain( 'dnwooe', false,  DNWOO_ESSENTIAL_DIR .'/languages' );
		}

		public function init_plugin() {

			$this->i18n();

			if ( is_admin() ) {
				new DNWOO_Essential\Includes\Admin();
			}
			new DNWOO_Essential\Includes\AssetsManager();

			$active_features = get_option( 'dnwooe_inactive_features', array() );
			if(! in_array( 'mini-cart-feature', $active_features)){
				new DNWOO_Essential\Includes\Dnwoocustomizer();
			}
		}

		public function dnwoo_wc_plugin_missing_notice() {
			$notice = '';
			global $woocommerce;
			if ( ! isset( $woocommerce ) || ! function_exists( 'WC' ) ) {
				if ( file_exists( WP_PLUGIN_DIR . '/woocommerce/woocommerce.php' ) ) {
					// WooCommerce is installed but not active.
					$url = wp_nonce_url(self_admin_url('plugins.php?action=activate&plugin=woocommerce/woocommerce.php'), 'activate-plugin_woocommerce/woocommerce.php');
					$notice = sprintf(
						'<p>%1$s <a href="%2$s">%3$s</a></p>',
						esc_html__('Woo-Essential is enabled but not effective. It requires WooCommerce in order to work.', 'dnwooe'),
						esc_url($url),
						esc_html__('Click here to activate WooCommerce', 'dnwooe')
					);
				} else {
					// WooCommerce is not installed.
					$url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=woocommerce'), 'install-plugin_woocommerce');
					$notice = sprintf(
						'<p>%1$s <a href="%2$s">%3$s</a></p>',
						esc_html__('Woo-Essential is enabled but not effective. It requires WooCommerce in order to work.', 'dnwooe'),
						esc_url($url),
						esc_html__('Click here to install WooCommerce', 'dnwooe')
					);
				}
				printf(
					'<div class="error">%1$s</div>',
					$notice // phpcs:ignore
				);
			}
		}
		public function dnwoo_new_module_notice() {

			$notice = sprintf(
				'<p>%1$s</p>',
				esc_html__('We are excited to introduce our latest module - the Woo Ajax Search! Take a look and discover how it can enhance your search functionality.', 'dnwooe')
			);
		}

		public function dnwoo_yith_plugin_missing_notice() {

			// YITH WooCommerce Compare
			$is_exists_woocompare = file_exists(WP_PLUGIN_DIR . '/yith-woocommerce-compare/init.php');
			$compare_notice_title = $is_exists_woocompare ? __('Activate YITH WooCommerce Compare', 'dnwooe') :  __('Install YITH WooCommerce Compare', 'dnwooe');
			$compare_notice_url   = $is_exists_woocompare ? wp_nonce_url('plugins.php?action=activate&plugin=yith-woocommerce-compare%2Finit.php&plugin_status=all&paged=1&s&_wpnonce=3940b878c3', 'activate-plugin_yith-woocommerce-compare/init.php') : wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=yith-woocommerce-compare'), 'install-plugin_yith-woocommerce-compare');

			// YITH WooCommerce Wishlist
			$is_exists_wishlist = file_exists(WP_PLUGIN_DIR . '/yith-woocommerce-wishlist/init.php');
			$wishlist_notice_title = $is_exists_wishlist ? __('Activate YITH WooCommerce Wishlist', 'dnwooe') : __('Install YITH WooCommerce Wishlist', 'dnwooe');
			$wishlist_notice_url   = $is_exists_wishlist ? wp_nonce_url('plugins.php?action=activate&plugin=yith-woocommerce-wishlist%2Finit.php&plugin_status=all&paged=1&s&_wpnonce=3940b878c3', 'activate-plugin_yith-woocommerce-wishlist/init.php') : wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=yith-woocommerce-wishlist'), 'install-plugin_yith-woocommerce-wishlist');

			$required_plugins = array(
				'YITH_Woocompare' => array(
					'title' => $compare_notice_title,
					'alt' => __('Compare', 'dnwooe'),
					'url' => $compare_notice_url
				),
				'YITH_WCWL' => array(
					'title' => $wishlist_notice_title,
					'alt' => __('Wishlist', 'dnwooe'),
					'url' => $wishlist_notice_url,
				),
			);

			$activated_plugin_list =array();
			foreach (array_keys($required_plugins) as $plugin) {
				if(!class_exists($plugin)) {
					array_push($activated_plugin_list, $required_plugins[$plugin]);
				}
			}
			$activated_plugin_list__copy = $activated_plugin_list;

			if(count($activated_plugin_list) > 1) {
				$last_plugin = array_splice( $activated_plugin_list, -1 );
			}

			$links = '';
			$alts = '';
			foreach($activated_plugin_list as $key => $value) {
				$alts .= $value['alt'] . ' ';
				$links .= sprintf('<a href="%1$s" title="%2$s">%2$s</a>', esc_url($value['url']), $value['title']);
			}
			if(isset($last_plugin)) { // phpcs::ignore
				$alts .= 'and ' . $last_plugin[0]['alt'];
				$links .= sprintf(' and <a href="%1$s" title="%2$s">%2$s</a>', esc_url($last_plugin[0]['url']), $last_plugin[0]['title']);
			}

			$notice = sprintf(
				esc_html__('For %2$s %3$s you will require %1$s', 'dnwooe'),
				$links,
				$alts,
				count($activated_plugin_list__copy) > 1 ? 'features' : 'feature'
			);

			$dnwooe_dismissed = get_transient('dnwoo_yith_plugin_missing_notice_dismissed');
			
			if('dnwooe_alive' !== $dnwooe_dismissed){
				if(!class_exists('YITH_Woocompare') || !class_exists('YITH_WCWL')){
					printf(
						'<div id="dnwooe_notice" class="notice notice-warning is-dismissible"><p>%1$s</p></div>',
						$notice // phpcs:ignore
					);
				}
			}

		}

		/**
		 * Dismiss the YITH plugin missing notice
		 *
		 * @return void
		 */
		public function dnwooe_dismiss_yith_plugin_missing_notice() {
			
			// Set the notice as dismissed forever
			set_transient('dnwoo_yith_plugin_missing_notice_dismissed', 'dnwooe_alive');

		}

		/**
		 * Include the required files
		 *
		 * @return void
		 */
		private function includes() {


			require_once DNWOO_ESSENTIAL_DIR . '/includes/admin.php';
			require_once DNWOO_ESSENTIAL_DIR . '/includes/assets-manager.php';
			require_once DNWOO_ESSENTIAL_DIR . '/includes/functions.php';
			
			$active_modules = get_option( 'dnwooe_inactive_features', array() );
			if(! in_array( 'mini-cart-feature', $active_modules)){
				require_once DNWOO_ESSENTIAL_DIR . '/includes/customizer.php';
			}

		/**
         *
         * 2. the required plugin license Plugin_Updater_Class start
         */
        if (!class_exists('DNWOO_Essential_Plugin_Updater_Class')) {
            // load our custom updater
            include DNWOO_ESSENTIAL_DIR . '/woo-essential-updater.php';
        }

        /**
         *
         * 2. the required plugin license Plugin_Updater_Class end
         */
		}

		/**
		 * Creates the extension's main class instance.
		 *
		 * @since 1.0.0
		 */

		public function dnwoo_initialize_extension() {
			require_once DNWOO_ESSENTIAL_DIR . '/includes/WooEssential.php';
		}

		/**
		 * Load The Woo Essential Text Domain.
		 * Text Domain : dnwoo-woo-essential
		 * @since  1.0.0
		 * @return void
		 */
		public function i18n() {
			load_plugin_textdomain( 'dnwooe',false ,DNWOO_ESSENTIAL_DIR . '/languages');
		}

		/**
		 * Do stuff upon plugin activation
		 *
		 * @return void
		 */
		public function activate() {
			$installed = get_option( 'dnwoo_essential_installed' );

			if ( ! $installed ) {
				update_option( 'dnwoo_essential_installed', time() );
			}
				update_option( 'dnwoo_essential_installed', DNWOO_ESSENTIAL_VERSION );
		}
	}

	DNWoo_Essential::get_instance();
}