<?php
/**
 * Multi Vendor compatibility class
 *
 * @package YITH\CatalogMode\Integrations
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'YWCTM_Multi_Vendor' ) ) {

	/**
	 * Implements compatibility with YITH WooCommerce Multi Vendor
	 *
	 * @class   YWCTM_Multi_Vendor
	 * @since   2.0.0
	 * @author  YITH <plugins@yithemes.com>
	 * @package YITH\CatalogMode\Integrations
	 */
	class YWCTM_Multi_Vendor {

		/**
		 *  Yith WooCommerce Catalog Mode vendor panel page
		 *
		 * @var string
		 */
		protected $panel_page = 'yith_vendor_ctm_settings';

		/**
		 * Panel object
		 *
		 * @since   2.0.0
		 * @var     /Yit_Plugin_Panel object
		 * @see     plugin-fw/lib/yit-plugin-panel.php
		 */
		protected $vendor_panel = null;

		/**
		 * Constructor
		 *
		 * @return  void
		 * @since   2.0.0
		 */
		public function __construct() {

			$vendor = yith_wcmv_get_vendor( 'current', 'user' );

			if ( $vendor->is_valid() && $vendor->has_limited_access() && ywctm_is_multivendor_integration_active() && $this->admin_override_check( $vendor ) ) {
				add_action( 'admin_menu', array( $this, 'add_ywctm_vendor' ), 5 );
				add_filter( 'yith_wcmv_admin_vendor_menu_items', array( $this, 'add_menu_item' ) );
			}

			add_action( 'woocommerce_screen_ids', array( $this, 'add_screen_ids' ) );
			add_action( 'yith_plugin_fw_wc_panel_screen_ids_for_assets', array( $this, 'add_screen_ids' ) );
			add_filter( 'ywctm_get_vendor_option', array( $this, 'get_vendor_option' ), 10, 3 );
			add_filter( 'ywctm_get_vendor_postmeta', array( $this, 'get_vendor_postmeta' ), 10, 3 );
			add_filter( 'ywctm_get_vendor_termmeta', array( $this, 'get_vendor_termmeta' ), 10, 4 );
			add_filter( 'ywctm_filled_form_fields', array( $this, 'add_vendor_emails_cc' ), 10, 2 );
		}

		/**
		 * Enable menu item in Multi Vendor 4.0
		 *
		 * @param array $items The menu items.
		 *
		 * @return array
		 * @since  2.11.0
		 */
		public function add_menu_item( $items ) {
			$items[] = 'yith_vendor_ctm_settings';

			return $items;
		}

		/**
		 * Add custom post type screen to YITH Plugin list
		 *
		 * @param array $screen_ids Screen IDs array.
		 *
		 * @return  array
		 * @since   2.0.0
		 */
		public function add_screen_ids( $screen_ids ) {

			$screen_ids[] = 'toplevel_page_yith_vendor_ctm_settings';

			return $screen_ids;
		}

		/**
		 * Add Catalog Mode panel for vendors
		 *
		 * @return  void
		 * @since   2.0.0
		 */
		public function add_ywctm_vendor() {

			if ( ! empty( $this->vendor_panel ) ) {
				return;
			}

			$tabs = array(
				'premium-settings' => array(
					'title'       => esc_html_x( 'Settings', 'general settings tab name', 'yith-woocommerce-catalog-mode' ),
					'icon'        => 'settings',
					'description' => esc_html_x( 'Configure the plugin\'s general settings.', 'general settings tab description', 'yith-woocommerce-catalog-mode' ),
				),
				'exclusions'       => array(
					'title' => esc_html_x( 'Exclusion List', 'exclusion settings tab name', 'yith-woocommerce-catalog-mode' ),
					'icon'  => '<svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path></svg>',
				),
				'inquiry-form'     => array(
					'title'       => esc_html_x( 'Inquiry Form', 'inquiry form settings tab name', 'yith-woocommerce-catalog-mode' ),
					'icon'        => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" /></svg>',
					'description' => esc_html_x( 'Configure the inquiry form settings.', 'inquiry form settings tab description', 'yith-woocommerce-catalog-mode' ),
				),
				'buttons-labels'   => array(
					'title'       => esc_html_x( 'Buttons & Labels', 'buttons & labels settings tab name', 'yith-woocommerce-catalog-mode' ),
					'icon'        => '<svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 11.25l1.5 1.5.75-.75V8.758l2.276-.61a3 3 0 10-3.675-3.675l-.61 2.277H12l-.75.75 1.5 1.5M15 11.25l-8.47 8.47c-.34.34-.8.53-1.28.53s-.94.19-1.28.53l-.97.97-.75-.75.97-.97c.34-.34.53-.8.53-1.28s.19-.94.53-1.28L12.75 9M15 11.25L12.75 9"></path></svg>',
					'description' => esc_html_x( 'Create buttons and labels to use with the plugin features.', 'buttons & labels settings tab description', 'yith-woocommerce-catalog-mode' ),
				),
			);

			$args = array(
				'ui_version'       => 2,
				'create_menu_page' => false,
				'parent_slug'      => '',
				'page_title'       => 'YITH WooCommerce Catalog Mode',
				'menu_title'       => 'Catalog Mode',
				'capability'       => 'manage_vendor_store',
				'parent'           => '',
				'parent_page'      => '',
				'page'             => $this->panel_page,
				'admin-tabs'       => $tabs,
				'options-path'     => YWCTM_DIR . 'plugin-options/',
				'icon_url'         => 'dashicons-admin-settings',
				'position'         => 99,
				'class'            => yith_set_wrapper_class(),
			);

			$this->vendor_panel = new YIT_Plugin_Panel_WooCommerce( $args );
		}

		/**
		 * Check if vendors options can be loaded
		 *
		 * @param YITH_Vendor $vendor The current Vendor.
		 *
		 * @return  boolean
		 * @since   2.0.0
		 */
		public function admin_override_check( $vendor ) {

			if ( 'yes' === get_option( 'ywctm_admin_override', 'no' ) ) {

				$admin_override = get_option( 'ywctm_admin_override_settings' );
				$behavior       = $admin_override['action'];
				$target         = $admin_override['target'];

				if ( 'disable' === $behavior && 'all' === $target ) {
					return true;
				} elseif ( 'enable' === $behavior && 'all' === $target ) {
					return false;
				} else {

					$has_exclusion = 'yes' === get_term_meta( $vendor->get_id(), '_ywctm_vendor_override_exclusion', true );

					if ( ( 'disable' === $behavior && $has_exclusion ) || ( 'enable' === $behavior && ! $has_exclusion ) ) {
						return true;
					} elseif ( ( 'enable' === $behavior && $has_exclusion ) || ( 'disable' === $behavior && ! $has_exclusion ) ) {
						return false;
					}
				}
			}

			return true;
		}

		/**
		 * Get vendor options
		 *
		 * @param mixed   $value      The option value.
		 * @param integer $product_id The Product ID.
		 * @param string  $option     The option name.
		 *
		 * @return  mixed
		 * @since   2.0.0
		 */
		public function get_vendor_option( $value, $product_id, $option ) {

			$vendor = yith_wcmv_get_vendor( $product_id, 'product' );

			if ( $vendor->is_valid() && $this->admin_override_check( $vendor ) ) {
				$opt_val = get_option( $option . '_' . $vendor->get_id() );
				$value   = ( '' !== $opt_val ) ? $opt_val : $value;
			}

			return $value;
		}

		/**
		 * Get vendor postmeta
		 *
		 * @param mixed   $value      The option value.
		 * @param integer $product_id The Product ID.
		 * @param string  $option     The option name.
		 *
		 * @return  mixed
		 * @since   2.0.0
		 */
		public function get_vendor_postmeta( $value, $product_id, $option ) {

			$vendor = yith_wcmv_get_vendor( $product_id, 'product' );

			if ( $vendor->is_valid() && $this->admin_override_check( $vendor ) ) {
				$product = wc_get_product( $product_id );
				$opt_val = $product->get_meta( $option . '_' . $vendor->get_id() );
				$value   = ( '' !== $opt_val ) ? $opt_val : $value;
			}

			return $value;
		}

		/**
		 * Get vendor termmeta
		 *
		 * @param mixed   $value      The option value.
		 * @param integer $product_id The Product ID.
		 * @param integer $term_id    The term ID.
		 * @param string  $option     The option name.
		 *
		 * @return  mixed
		 * @since   2.0.0
		 */
		public function get_vendor_termmeta( $value, $product_id, $term_id, $option ) {

			$vendor = yith_wcmv_get_vendor( $product_id, 'product' );

			if ( $vendor->is_valid() && $this->admin_override_check( $vendor ) ) {
				$opt_val = get_term_meta( $term_id, $option . '_' . $vendor->get_id(), true );
				$value   = ( '' !== $opt_val ) ? $opt_val : $value;
			}

			return $value;
		}

		/**
		 * Get vendor admin emails
		 *
		 * @param array $filled_form_fields The form filled forms.
		 * @param array $posted             The posted fields.
		 *
		 * @return  array
		 * @since   2.1.0
		 */
		public function add_vendor_emails_cc( $filled_form_fields, $posted ) {

			if ( 0 !== (int) $posted['ywctm-vendor-id'] ) {

				$vendor        = yith_wcmv_get_vendor( $posted['ywctm-vendor-id'], 'vendor' );
				$vendor_admins = $vendor->get_admins();
				$vendor_emails = array();

				foreach ( $vendor_admins as $vendor_admin ) {
					$vendor_emails[] = get_userdata( $vendor_admin )->user_email;
				}

				$filled_form_fields['cc_emails'] = $vendor_emails;

			}

			return $filled_form_fields;
		}
	}

	new YWCTM_Multi_Vendor();

}
