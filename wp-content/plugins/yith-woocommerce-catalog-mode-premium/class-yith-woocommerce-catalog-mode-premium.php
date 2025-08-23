<?php
/**
 * Premium Class
 *
 * @package YITH\CatalogMode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'YITH_WooCommerce_Catalog_Mode_Premium' ) ) {

	/**
	 * Implements features of YITH WooCommerce Catalog Mode plugin
	 *
	 * @class   YITH_WooCommerce_Catalog_Mode_Premium
	 * @since   1.0.0
	 * @author  YITH <plugins@yithemes.com>
	 * @package YITH\CatalogMode
	 */
	class YITH_WooCommerce_Catalog_Mode_Premium extends YITH_WooCommerce_Catalog_Mode {

		/**
		 * Returns single instance of the class
		 *
		 * @return YITH_WooCommerce_Catalog_Mode_Premium
		 * @since 1.3.0
		 */
		public static function get_instance() {

			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * User geolocation info.
		 *
		 * @var array
		 */
		protected $user_geolocation = null;

		/**
		 * Constructor
		 *
		 * Initialize plugin and registers actions and filters to be used
		 *
		 * @return  void
		 * @since   1.0.0
		 */
		public function __construct() {

			parent::__construct();

			add_action( 'init', array( $this, 'geolocate_user' ) );
			add_action( 'init', array( $this, 'init_multivendor_integration' ), 20 );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_premium_scripts_admin' ), 15 );
			add_action( 'product_cat_edit_form', array( $this, 'write_taxonomy_options' ), 99 );
			add_action( 'product_tag_edit_form', array( $this, 'write_taxonomy_options' ), 99 );
			add_action( 'edited_product_cat', array( $this, 'save_taxonomy_options' ) );
			add_action( 'edited_product_tag', array( $this, 'save_taxonomy_options' ) );

			if ( ! is_admin() || $this->is_quick_view() || wp_doing_ajax() ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_premium_styles' ) );
				add_filter( 'woocommerce_product_tabs', array( $this, 'add_inquiry_form_tab' ) );
				add_filter( 'woocommerce_product_tabs', array( $this, 'disable_reviews_tab' ), 98 );
				add_action( 'wp', array( $this, 'init_template_hooks' ) );
				add_filter( 'ywctm_get_exclusion', array( $this, 'get_exclusion' ), 10, 4 );
				add_filter( 'woocommerce_product_get_price', array( $this, 'show_product_price' ), 10, 2 );
				add_filter( 'woocommerce_get_price_html', array( $this, 'show_product_price' ), 12, 2 );
				add_filter( 'yith_ywraq_hide_price_template', array( $this, 'show_product_price' ), 12, 2 );
				add_filter( 'yith_wcpb_woocommerce_get_price_html', array( $this, 'show_product_price' ), 12, 2 );
				add_filter( 'woocommerce_is_purchasable', array( $this, 'unlock_purchase_if_ywcp_is_enabled' ), 99 );
				add_filter( 'yith_wcpb_ajax_update_price_enabled', array( $this, 'hide_price_bundle' ), 10, 2 );
				add_filter( 'yith_wcpb_show_bundled_items_prices', array( $this, 'hide_price_bundled_items' ), 10, 3 );
				add_filter( 'ywctm_check_price_hidden', array( $this, 'check_price_hidden' ), 10, 2 );
				add_filter( 'woocommerce_product_is_on_sale', array( $this, 'hide_on_sale' ), 10, 2 );
				add_filter( 'ywctm_css_classes', array( $this, 'hide_price_single_page' ) );
				// Remove discount table from product (YITH WooCommerce Dynamic Discount Product).
				add_filter( 'ywdpd_exclude_products_from_discount', array( $this, 'hide_discount_quantity_table' ), 10, 2 );
			}

			// Compatibility with quick view.
			add_action( 'yith_wcqv_product_summary', array( $this, 'check_quick_view' ) );

			add_shortcode( 'ywctm-button', array( $this, 'print_custom_button_shortcode' ) );
			add_shortcode( 'ywctm-inquiry-form', array( $this, 'print_inquiry_form_shortcode' ) );
			add_action( 'after_setup_theme', array( $this, 'themes_integration' ) );
			add_action( 'init', array( $this, 'init_blocks' ) );

			// Register plugin to licence/update system.
			add_action( 'wp_loaded', array( $this, 'register_plugin_for_activation' ), 99 );
			add_action( 'wp_loaded', array( $this, 'register_plugin_for_updates' ), 99 );

			if ( is_admin() ) {
				add_filter( 'yith_plugin_fw_get_field_template_path', array( $this, 'get_yith_panel_custom_template' ), 10, 2 );
				add_filter( 'yith_plugin_fw_wc_panel_field_data', array( $this, 'get_maxmind_license_key' ), 10 );
				add_action( 'woocommerce_admin_settings_sanitize_option_ywctm_maxmind_geolocation_license_key', array( $this, 'set_maxmind_license_key' ) );
			}
		}

		/**
		 * Init hooks for block template
		 *
		 * @return void
		 * @since  2.26.0
		 */
		public function init_template_hooks() {
			if ( yith_plugin_fw_wc_is_using_block_template_in_single_product() ) {

				global $product;

				if ( ! $product instanceof WC_Product ) {
					return;
				}

				$enabled = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_inquiry_form_enabled', 'hidden' ), $product->get_id(), 'ywctm_inquiry_form_enabled' );
				$in_desc = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_inquiry_form_where_show', 'tab' ), $product->get_id(), 'ywctm_inquiry_form_where_show' );

				if ( 'hidden' !== $enabled && 'desc' === $in_desc ) {

					$show_form = apply_filters( 'ywctm_get_exclusion', ( 'exclusion' !== $enabled ), $product->get_id(), 'inquiry_form' );

					if ( ! $show_form ) {
						return;
					}

					switch ( apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_inquiry_form_position', '15' ), $product->get_id(), 'ywctm_inquiry_form_position' ) ) {
						case '25':
							add_filter( 'render_block_core/post-excerpt', array( $this, 'add_inquiry_form_after_block' ), 10, 3 );
							break;
						case '35':
							add_filter( 'render_block_woocommerce/add-to-cart-form', array( $this, 'add_inquiry_form_after_block' ), 10, 3 );
							break;
						default:
							add_filter( 'render_block_woocommerce/product-price', array( $this, 'add_inquiry_form_after_block' ), 10, 3 );
					}
				}
				add_filter( 'render_block_woocommerce/add-to-cart-form', array( $this, 'add_custom_button_after_block' ), 20 );
			} else {
				add_action( 'woocommerce_before_single_product', array( $this, 'add_inquiry_form_page' ), 5 );
				add_action( 'woocommerce_before_single_product', array( $this, 'add_custom_button_page' ), 5 );
				add_action( 'woocommerce_before_single_product', array( $this, 'show_wapo_if_hidden' ), 5 );
			}

			if ( yith_plugin_fw_wc_is_using_block_template_in_product_catalogue() ) {
				add_filter( 'render_block_woocommerce/product-button', array( $this, 'add_custom_button_after_block_shop' ) );
				add_filter( 'ywctm_modify_woocommerce_after_shop_loop_item', '__return_false' );
			} else {
				add_action( 'woocommerce_after_shop_loop_item', array( $this, 'show_custom_button' ), 20 );
			}
		}

		/**
		 * Premium files inclusion
		 *
		 * @return  void
		 * @since   2.0.0
		 */
		public function include_files() {

			parent::include_files();

			include_once 'includes/ywctm-functions-premium.php';
			include_once 'includes/class-ywctm-button-label-post-type.php';
			include_once 'includes/integrations/forms/default/class-ywctm-default-form.php';
			include_once 'includes/integrations/forms/contact-form-7/ywctm-contact-form-7.php';
			include_once 'includes/integrations/forms/default/ywctm-default-form.php';
			include_once 'includes/integrations/forms/formidable-forms/ywctm-formidable-forms.php';
			include_once 'includes/integrations/forms/gravity-forms/ywctm-gravity-forms.php';
			include_once 'includes/integrations/forms/ninja-forms/ywctm-ninja-forms.php';
			include_once 'includes/integrations/forms/wpforms/ywctm-wpforms.php';

			if ( is_admin() ) {

				include_once 'includes/admin/class-yith-ywctm-custom-table.php';
				include_once 'includes/admin/meta-boxes/class-ywctm-product-metabox.php';
				include_once 'includes/admin/tables/class-ywctm-exclusions-table.php';

				if ( ywctm_is_multivendor_active() && ywctm_is_multivendor_integration_active() ) {
					include_once 'includes/admin/tables/class-ywctm-vendors-table.php';
				}
			}
		}

		/**
		 * Gutenberg/Elementor Integration
		 *
		 * @return  void
		 * @since   2.1.0
		 */
		public function init_blocks() {

			$blocks = array(
				'yith-catalog-mode-button'       => array(
					'title'          => esc_html__( 'YITH Catalog Mode Button', 'yith-woocommerce-catalog-mode' ),
					'shortcode_name' => 'ywctm-button',
					'do_shortcode'   => true,
					'section_title'  => esc_html__( 'YITH Catalog Mode Button', 'yith-woocommerce-catalog-mode' ),
					'options'        => array(
						'wc_style_warning1' => array(
							'type'            => 'raw_html',
							/* translators: %1$s: open <b> tag - %2$s: close </b> tag - %3$s: open link tag - %4$s: close link tag */
							'raw'             => sprintf( esc_html__( 'This widget inherits the style from the settings of %1$sYITH Catalog Mode%2$s plugin that you can edit %3$shere%4$s', 'yith-woocommerce-catalog-mode' ), '<b>', '</b>', '[<a target="_blank" href="' . get_admin_url( null, 'edit.php?post_type=ywctm-button-label' ) . '">', '</a>]' ),
							'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
						),
					),
				),
				'yith-catalog-mode-inquiry-form' => array(
					'title'          => esc_html__( 'YITH Catalog Mode Inquiry Form', 'yith-woocommerce-catalog-mode' ),
					'shortcode_name' => 'ywctm-inquiry-form',
					'do_shortcode'   => true,
					'section_title'  => esc_html__( 'YITH Catalog Mode Inquiry Form', 'yith-woocommerce-catalog-mode' ),
					'attributes'     => array(
						'wc_style_warning1' => array(
							'type'            => 'raw_html',
							/* translators: %1$s: open <b> tag - %2$s: close </b> tag - %3$s: open link tag - %4$s: close link tag */
							'raw'             => sprintf( esc_html__( 'This widget inherits the style from the settings of %1$sYITH Catalog Mode%2$s plugin that you can edit %3$shere%4$s', 'yith-woocommerce-catalog-mode' ), '<b>', '</b>', '[<a href="' . get_admin_url( null, 'admin.php?page=yith_wc_catalog_mode_panel&tab=inquiry-form' ) . '">', '</a>]' ),
							'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
						),
					),
				),
			);
			yith_plugin_fw_gutenberg_add_blocks( $blocks );
			yith_plugin_fw_register_elementor_widgets( $blocks, true );
		}

		/**
		 * Check if country has catalog mode active
		 *
		 * @param boolean $apply      Catalog mode apply check.
		 * @param integer $product_id Product ID.
		 *
		 * @return  boolean
		 * @since   1.3.0
		 */
		public function country_check( $apply, $product_id ) {

			$geolocation_enabled = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_enable_geolocation', 'no' ), $product_id, 'ywctm_enable_geolocation' );

			if ( 'yes' === $geolocation_enabled ) {
				$geolocation   = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_geolocation_settings' ), $product_id, 'ywctm_geolocation_settings' );
				$countries     = isset( $geolocation['countries'] ) ? maybe_unserialize( $geolocation['countries'] ) : array();
				$users_match   = 'all' === $geolocation['users'] || ! is_user_logged_in();
				$country_match = in_array( $this->user_geolocation, $countries, true );
				$apply         = $users_match && $country_match;

				if ( 'disable' === $geolocation['action'] ) {
					$apply = ! $apply;
				}
			}

			return $apply;
		}

		/**
		 * Check if there's a timeframe in which the catalog mode needs to be enabled
		 *
		 * @param boolean $apply Catalog mode apply check.
		 *
		 * @return  boolean
		 * @since   2.1.0
		 */
		public function timeframe_check( $apply ) {

			if ( 'yes' === get_option( 'ywctm_disable_shop_timerange' ) ) {

				$apply      = false;
				$timeranges = get_option( 'ywctm_disable_shop_timerange_ranges' );

				try {
					$current_time = new DateTime( 'now', new DateTimeZone( wc_timezone_string() ) );

					foreach ( $timeranges as $timerange ) {
						$start_time = new DateTime( $timerange['start_hour'] . ':' . $timerange['start_minutes'], new DateTimeZone( wc_timezone_string() ) );
						$end_time   = new DateTime( $timerange['end_hour'] . ':' . $timerange['end_minutes'], new DateTimeZone( wc_timezone_string() ) );

						if ( $start_time > $end_time ) {
							// If end time is minor than the start time it's moved to the next day.
							$end_time = new DateTime( $timerange['end_hour'] . ':' . $timerange['end_minutes'] . '+ 1 DAYS', new DateTimeZone( wc_timezone_string() ) );
						}

						$day_of_week = gmdate( 'N', $current_time->getTimestamp() );

						if ( in_array( $day_of_week, $timerange['days'], true ) || in_array( 'all', $timerange['days'], true ) ) {
							if ( $current_time >= $start_time && $current_time <= $end_time ) {
								$apply = true;
								break;
							}
						}
					}
				} catch ( Exception $e ) {
					// Do nothing.
					return $apply;
				}
			}

			return $apply;
		}

		/**
		 * Check if there's a dateframe in which the catalog mode needs to be enabled
		 *
		 * @param boolean $apply Catalog mode apply check.
		 *
		 * @return  boolean
		 * @since   2.1.0
		 */
		public function dateframe_check( $apply ) {

			if ( 'yes' === get_option( 'ywctm_disable_shop_daterange' ) ) {

				$apply      = false;
				$dateranges = get_option( 'ywctm_disable_shop_daterange_ranges' );

				try {
					$current_date = new DateTime( 'today', new DateTimeZone( wc_timezone_string() ) );

					foreach ( $dateranges as $daterange ) {
						$start_date = new DateTime( $daterange['start_date'], new DateTimeZone( wc_timezone_string() ) );
						$end_date   = new DateTime( $daterange['end_date'], new DateTimeZone( wc_timezone_string() ) );

						if ( $current_date >= $start_date && $current_date <= $end_date ) {
							$apply = true;
							break;
						}
					}
				} catch ( Exception $e ) {
					// Do nothing.
					return $apply;
				}
			}

			return $apply;
		}

		/**
		 * Get user country from IP Address
		 *
		 * @return  void
		 * @since   1.3.4
		 */
		public function geolocate_user() {

			if ( 'yes' === get_option( 'ywctm_enable_geolocation', 'no' ) ) {
				$ip_address  = ywctm_get_ip_address();
				$wc_geo_ip   = WC_Geolocation::geolocate_ip( $ip_address );
				$geolocation = $wc_geo_ip['country'];

				if ( '' === $geolocation ) {
					$geolocation = wc_get_base_location()['country'];
				}

				$this->user_geolocation = $geolocation;
			}
		}

		/**
		 * ADMIN FUNCTIONS
		 */

		/**
		 * Multi Vendor integration init function
		 *
		 * @return  void
		 * @since   2.0.0
		 */
		public function init_multivendor_integration() {
			if ( ywctm_is_multivendor_active() ) {
				include_once 'includes/integrations/class-ywctm-multi-vendor.php';
			}
		}

		/**
		 * Enqueue script file
		 *
		 * @return  void
		 * @since   1.0.0
		 */
		public function enqueue_premium_scripts_admin() {

			wp_register_style( 'ywctm-admin-premium', yit_load_css_file( YWCTM_ASSETS_URL . 'css/admin-premium.css' ), array(), YWCTM_VERSION );
			wp_register_script( 'ywctm-admin-premium', yit_load_css_file( YWCTM_ASSETS_URL . 'js/admin-premium.js' ), array( 'jquery', 'jquery-tiptip', 'jquery-ui-dialog' ), YWCTM_VERSION, false );
			$getted = $_GET; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			$args   = array(
				'vendor_id'          => ywctm_get_vendor_id( true ),
				'error_messages'     => array(
					'product'       => esc_html__( 'Select at least one product', 'yith-woocommerce-catalog-mode' ),
					'category'      => esc_html__( 'Select at least one category', 'yith-woocommerce-catalog-mode' ),
					'tag'           => esc_html__( 'Select at least one tag', 'yith-woocommerce-catalog-mode' ),
					/* translators: %1$s start hours value - %2$s end hours value */
					'error_hours'   => sprintf( esc_html__( 'Please only insert a number between %1$s and %2$s', 'yith-woocommerce-catalog-mode' ), '00', '24' ),
					/* translators: %1$s start minutes value - %2$s end minutes value */
					'error_minutes' => sprintf( esc_html__( 'Please only insert a number between %1$s and %2$s', 'yith-woocommerce-catalog-mode' ), '00', '59' ),
				),
				'popup_labels'       => array(
					'title' => esc_html_x( 'Add exclusion in list', 'Exclusion page popup title label ', 'yith-woocommerce-catalog-mode' ),
					'save'  => esc_html_x( 'Add exclusion to list', 'Exclusion page popup save button label ', 'yith-woocommerce-catalog-mode' ),
					'edit'  => esc_html_x( 'Edit exclusion', 'Exclusion page popup edit button label ', 'yith-woocommerce-catalog-mode' ),
				),
				'buttons_custom_url' => ywctm_buttons_id_with_custom_url(),
				'ajax_url'           => admin_url( 'admin-ajax.php' ),
				'bulk_delete'        => array(
					'confirm_title'   => __( 'Confirm delete', 'yith-woocommerce-catalog-mode' ),
					'confirm_message' => __( 'Are you sure you want to delete the selected items?', 'yith-woocommerce-catalog-mode' ) . '<br /><br />' . __( 'This action cannot be undone and you will not be able to recover this data.', 'yith-woocommerce-catalog-mode' ),
					'confirm_button'  => __( 'Yes, delete', 'yith-woocommerce-catalog-mode' ),
					'cancel_button'   => __( 'No', 'yith-woocommerce-catalog-mode' ),
				),
			);
			wp_localize_script( 'ywctm-admin-premium', 'ywctm', $args );

			if ( ! empty( $getted['page'] ) && ( $getted['page'] === $this->panel_page || 'yith_vendor_ctm_settings' === $getted['page'] ) ) {

				wp_enqueue_script( 'ywctm-admin-premium' );
				wp_enqueue_style( 'ywctm-admin-premium' );

				if ( ! ywctm_is_multivendor_active() || ! ywctm_is_multivendor_integration_active() ) {
					$css = '
					.yith-plugin-fw-sub-tabs-nav > h3 > a,
					li.yith-plugin-fw-tab-element a.nav-tab i,
					.yith-plugin-fw-sub-tabs-nav,
					div.nav-subtab-wrap { display: none !important }
					.yith-plugin-ui .yith-plugin-fw-panel-custom-sub-tab-container { border: none; padding: 0; margin: 0; }
					';

					wp_add_inline_style( 'ywctm-admin-premium', $css );
				}
			}

			if ( ! empty( $getted['taxonomy'] ) && ( 'product_cat' === $getted['taxonomy'] || 'product_tag' === $getted['taxonomy'] ) ) {
				wp_enqueue_style( 'yith-plugin-fw-fields' );
				wp_enqueue_script( 'yith-plugin-fw-fields' );
				wp_enqueue_style( 'ywctm-admin-premium' );
				wp_enqueue_script( 'ywctm-admin-premium' );
			}
		}

		/**
		 * Add YWCTM fields in category/tag edit page
		 *
		 * @param WP_Term $taxonomy The Term Object.
		 *
		 * @return  void
		 * @since   1.3.0
		 */
		public function write_taxonomy_options( $taxonomy ) {

			$item          = get_term_meta( $taxonomy->term_id, '_ywctm_exclusion_settings' . ywctm_get_vendor_id(), true );
			$has_exclusion = 'yes';

			if ( ! $item ) {
				$atc_global         = get_option( 'ywctm_hide_add_to_cart_settings' . ywctm_get_vendor_id() );
				$button_global      = get_option( 'ywctm_custom_button_settings' . ywctm_get_vendor_id() );
				$button_loop_global = get_option( 'ywctm_custom_button_settings_loop' . ywctm_get_vendor_id() );
				$price_global       = get_option( 'ywctm_hide_price_settings' . ywctm_get_vendor_id() );
				$label_global       = get_option( 'ywctm_custom_price_text_settings' . ywctm_get_vendor_id() );
				$has_exclusion      = 'no';

				$item = array(
					'enable_inquiry_form'         => 'yes',
					'enable_atc_custom_options'   => 'no',
					'atc_status'                  => $atc_global['action'],
					'custom_button'               => $button_global,
					'custom_button_loop'          => $button_loop_global,
					'enable_price_custom_options' => 'no',
					'price_status'                => $price_global['action'],
					'custom_price_text'           => $label_global,
				);
			}

			$fields  = array_merge(
				array(
					array(
						'id'    => 'ywctm_has_exclusion',
						'name'  => 'ywctm_has_exclusion',
						'type'  => 'onoff',
						'title' => esc_html__( 'Add to exclusion list', 'yith-woocommerce-catalog-mode' ),
						'value' => $has_exclusion,
					),
				),
				ywctm_get_exclusion_fields( $item )
			);
			$enabled = get_option( 'ywctm_inquiry_form_enabled' . ywctm_get_vendor_id(), 'hidden' );

			?>
			<div class="ywctm-taxonomy-panel ywctm-exclusions yith-plugin-ui woocommerce">
				<h2><?php esc_html_e( 'Catalog Mode Options', 'yith-woocommerce-catalog-mode' ); ?></h2>
				<table class="form-table <?php echo( 'hidden' !== $enabled && ywctm_exists_inquiry_forms() ? '' : 'no-active-form' ); ?>">
					<tbody>
					<?php foreach ( $fields as $field ) : ?>
						<tr valign="top" class="yith-plugin-fw-panel-wc-row <?php echo esc_attr( $field['type'] ); ?> <?php echo esc_attr( $field['name'] ); ?>">
							<th scope="row" class="titledesc">
								<label for="<?php echo esc_attr( $field['name'] ); ?>"><?php echo esc_attr( $field['title'] ); ?></label>
							</th>
							<td class="forminp forminp-<?php echo esc_attr( $field['type'] ); ?>">
								<?php yith_plugin_fw_get_field( $field, true ); ?>
								<?php if ( isset( $field['desc'] ) ) : ?>
									<span class="description"><?php echo wp_kses_post( $field['desc'] ); ?></span>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<?php
		}

		/**
		 * Save YWCTM category/tag options
		 *
		 * @param integer $taxonomy_id The term ID.
		 *
		 * @return  void
		 * @since   1.3.0
		 */
		public function save_taxonomy_options( $taxonomy_id ) {

			global $pagenow;

			if ( ! $taxonomy_id || 'edit-tags.php' !== $pagenow ) {
				return;
			}

			$posted = $_POST; // phpcs:ignore WordPress.Security.NonceVerification.Missing

			if ( isset( $posted['ywctm_has_exclusion'] ) ) {

				$exclusion_data = array(
					'enable_inquiry_form'         => isset( $posted['ywctm_enable_inquiry_form'] ) ? 'yes' : 'no',
					'enable_atc_custom_options'   => isset( $posted['ywctm_enable_atc_custom_options'] ) ? 'yes' : 'no',
					'atc_status'                  => $posted['ywctm_atc_status'],
					'custom_button'               => $posted['ywctm_custom_button'],
					'custom_button_url'           => $posted['ywctm_custom_button_url'],
					'custom_button_loop'          => $posted['ywctm_custom_button_loop'],
					'custom_button_loop_url'      => $posted['ywctm_custom_button_loop_url'],
					'enable_price_custom_options' => isset( $posted['ywctm_enable_price_custom_options'] ) ? 'yes' : 'no',
					'price_status'                => $posted['ywctm_price_status'],
					'custom_price_text'           => $posted['ywctm_custom_price_text'],
					'custom_price_text_url'       => $posted['ywctm_custom_price_text_url'],
				);

				update_term_meta( $taxonomy_id, '_ywctm_exclusion_settings' . ywctm_get_vendor_id(), $exclusion_data );
			} else {
				delete_term_meta( $taxonomy_id, '_ywctm_exclusion_settings' . ywctm_get_vendor_id() );
			}
		}

		/**
		 * Add custom panel fields.
		 *
		 * @param string $template Template ID.
		 * @param array  $field    Field options.
		 *
		 * @return string
		 * @since   2.1.0
		 */
		public function get_yith_panel_custom_template( $template, $field ) {
			$custom_option_types = array(
				'ywctm-default-form',
				'ywctm-multiple-times',
				'ywctm-multiple-dates',
			);

			$field_type = $field['type'];

			if ( isset( $field['type'] ) && in_array( $field['type'], $custom_option_types, true ) ) {
				$template = YWCTM_DIR . "views/panel/types/$field_type.php";
			}

			return $template;
		}

		/**
		 * Get MaxMind license key from WooCommerce settings
		 *
		 * @param array $field The options of the field.
		 *
		 * @return array
		 * @since  2.12.0
		 */
		public function get_maxmind_license_key( $field ) {
			if ( 'ywctm_maxmind_geolocation_license_key' === $field['id'] ) {
				if ( isset( WC()->integrations ) ) {
					$integrations = WC()->integrations->get_integrations();
					if ( isset( $integrations['maxmind_geolocation'] ) ) {
						$field['value'] = $integrations['maxmind_geolocation']->get_option( 'license_key' );
					}
				}
			}

			return $field;
		}

		/**
		 * Set MaxMind license key in WooCommerce settings
		 *
		 * @param string $value Option value.
		 *
		 * @return  string
		 * @since   2.12.0
		 */
		public function set_maxmind_license_key( $value ) {

			if ( isset( WC()->integrations ) ) {
				$integrations = WC()->integrations->get_integrations();
				if ( isset( $integrations['maxmind_geolocation'] ) ) {
					$integrations['maxmind_geolocation']->validate_license_key_field( 'license_key', $value );
					$integrations['maxmind_geolocation']->update_option( 'license_key', $value );
				}
			}

			return $value;
		}

		/**
		 * FRONTEND FUNCTIONS
		 */

		/**
		 * Get exclusion
		 *
		 * @param string  $value        The value.
		 * @param integer $product_id   The Product ID.
		 * @param string  $option       The option.
		 * @param string  $global_value THe global value.
		 *
		 * @return  mixed
		 * @since   1.3.0
		 */
		public function get_exclusion( $value, $product_id, $option, $global_value = '' ) {

			$product = wc_get_product( $product_id );

			if ( ! $product ) {
				return $value;
			}

			if ( 'atc' === $option || 'price' === $option ) {
				$product_exclusion = apply_filters( 'ywctm_get_vendor_postmeta', $product->get_meta( '_ywctm_exclusion_settings' ), $product_id, '_ywctm_exclusion_settings' );

				if ( $product_exclusion ) {
					if ( 'yes' === $product_exclusion[ 'enable_' . $option . '_custom_options' ] ) {
						return $product_exclusion[ $option . '_status' ];
					} else {
						return $global_value;
					}
				}

				$product_cats = wp_get_object_terms( $product_id, 'product_cat', array( 'fields' => 'ids' ) );
				foreach ( $product_cats as $cat_id ) {

					$product_exclusion = apply_filters( 'ywctm_get_vendor_termmeta', get_term_meta( $cat_id, '_ywctm_exclusion_settings', true ), $product_id, $cat_id, '_ywctm_exclusion_settings' );
					if ( $product_exclusion ) {
						if ( 'yes' === $product_exclusion[ 'enable_' . $option . '_custom_options' ] ) {
							return $product_exclusion[ $option . '_status' ];
						} else {
							return $global_value;
						}
					}
				}

				$product_tags = wp_get_object_terms( $product_id, 'product_tag', array( 'fields' => 'ids' ) );
				foreach ( $product_tags as $tag_id ) {

					$product_exclusion = apply_filters( 'ywctm_get_vendor_termmeta', get_term_meta( $tag_id, '_ywctm_exclusion_settings', true ), $product_id, $tag_id, '_ywctm_exclusion_settings' );
					if ( $product_exclusion ) {
						if ( 'yes' === $product_exclusion[ 'enable_' . $option . '_custom_options' ] ) {
							return $product_exclusion[ $option . '_status' ];
						} else {
							return $global_value;
						}
					}
				}

				return $value;
			} elseif ( 'inquiry_form' === $option ) {
				$product_exclusion = apply_filters( 'ywctm_get_vendor_postmeta', $product->get_meta( '_ywctm_exclusion_settings' ), $product_id, '_ywctm_exclusion_settings' );

				if ( $product_exclusion ) {
					return 'yes' === $product_exclusion['enable_inquiry_form'];
				}

				$product_cats = wp_get_object_terms( $product_id, 'product_cat', array( 'fields' => 'ids' ) );
				foreach ( $product_cats as $cat_id ) {

					$product_exclusion = apply_filters( 'ywctm_get_vendor_termmeta', get_term_meta( $cat_id, '_ywctm_exclusion_settings', true ), $product_id, $cat_id, '_ywctm_exclusion_settings' );
					if ( $product_exclusion ) {
						return 'yes' === $product_exclusion['enable_inquiry_form'];
					}
				}

				$product_tags = wp_get_object_terms( $product_id, 'product_tag', array( 'fields' => 'ids' ) );
				foreach ( $product_tags as $tag_id ) {

					$product_exclusion = apply_filters( 'ywctm_get_vendor_termmeta', get_term_meta( $tag_id, '_ywctm_exclusion_settings', true ), $product_id, $tag_id, '_ywctm_exclusion_settings' );
					if ( $product_exclusion ) {
						return 'yes' === $product_exclusion['enable_inquiry_form'];
					}
				}

				return $value;
			} elseif ( 'custom_button' === $option || 'custom_button_loop' === $option ) {
				$product_exclusion = apply_filters( 'ywctm_get_vendor_postmeta', $product->get_meta( '_ywctm_exclusion_settings' ), $product_id, '_ywctm_exclusion_settings' );

				if ( $product_exclusion && 'yes' === $product_exclusion['enable_atc_custom_options'] ) {
					return $product_exclusion[ $option ];
				}

				$product_cats = wp_get_object_terms( $product_id, 'product_cat', array( 'fields' => 'ids' ) );
				foreach ( $product_cats as $cat_id ) {

					$product_exclusion = apply_filters( 'ywctm_get_vendor_termmeta', get_term_meta( $cat_id, '_ywctm_exclusion_settings', true ), $product_id, $cat_id, '_ywctm_exclusion_settings' );
					if ( $product_exclusion && 'yes' === $product_exclusion['enable_atc_custom_options'] ) {
						return $product_exclusion[ $option ];
					}
				}

				$product_tags = wp_get_object_terms( $product_id, 'product_tag', array( 'fields' => 'ids' ) );
				foreach ( $product_tags as $tag_id ) {

					$product_exclusion = apply_filters( 'ywctm_get_vendor_termmeta', get_term_meta( $tag_id, '_ywctm_exclusion_settings', true ), $product_id, $tag_id, '_ywctm_exclusion_settings' );
					if ( $product_exclusion && 'yes' === $product_exclusion['enable_atc_custom_options'] ) {
						return $product_exclusion[ $option ];
					}
				}
			} elseif ( 'price_label' === $option ) {
				$product_exclusion = apply_filters( 'ywctm_get_vendor_postmeta', $product->get_meta( '_ywctm_exclusion_settings' ), $product_id, '_ywctm_exclusion_settings' );

				if ( $product_exclusion && 'yes' === $product_exclusion['enable_price_custom_options'] ) {
					return $product_exclusion['custom_price_text'];
				}

				$product_cats = wp_get_object_terms( $product_id, 'product_cat', array( 'fields' => 'ids' ) );
				foreach ( $product_cats as $cat_id ) {

					$product_exclusion = apply_filters( 'ywctm_get_vendor_termmeta', get_term_meta( $cat_id, '_ywctm_exclusion_settings', true ), $product_id, $cat_id, '_ywctm_exclusion_settings' );
					if ( $product_exclusion && 'yes' === $product_exclusion['enable_price_custom_options'] ) {
						return $product_exclusion['custom_price_text'];
					}
				}

				$product_tags = wp_get_object_terms( $product_id, 'product_tag', array( 'fields' => 'ids' ) );
				foreach ( $product_tags as $tag_id ) {

					$product_exclusion = apply_filters( 'ywctm_get_vendor_termmeta', get_term_meta( $tag_id, '_ywctm_exclusion_settings', true ), $product_id, $tag_id, '_ywctm_exclusion_settings' );
					if ( $product_exclusion && 'yes' === $product_exclusion['enable_price_custom_options'] ) {
						return $product_exclusion['custom_price_text'];
					}
				}
			}

			return $value;
		}

		/**
		 * Enqueue css file
		 *
		 * @return  void
		 * @since   1.0.0
		 */
		public function enqueue_premium_styles() {

			if ( is_product() ) {
				$product      = wc_get_product();
				$form_enabled = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_inquiry_form_enabled', 'hidden' ), $product->get_id(), 'ywctm_inquiry_form_enabled' );

				if ( 'hidden' !== $form_enabled && ( ywctm_exists_inquiry_forms() ) ) {

					$form_custom_css = '';
					$form_type       = 'none';

					// Add styles for inquiry form.
					if ( 'hidden' !== $form_enabled ) {

						$in_desc   = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_inquiry_form_where_show', 'tab' ), $product->get_id(), 'ywctm_inquiry_form_where_show' );
						$style     = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_inquiry_form_style', 'classic' ), $product->get_id(), 'ywctm_inquiry_form_style' );
						$form_type = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_inquiry_form_type' ), $product->get_id(), 'ywctm_inquiry_form_type' );

						if ( 'desc' === $in_desc && 'toggle' === $style ) {

							$tg_text_color = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_toggle_button_text_color' ), $product->get_id(), 'ywctm_toggle_button_text_color' );
							$tg_back_color = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_toggle_button_background_color' ), $product->get_id(), 'ywctm_toggle_button_background_color' );

							$form_custom_css .= '.ywctm-inquiry-form-wrapper.has-toggle .ywctm-toggle-button{ color:' . $tg_text_color['default'] . '; background-color:' . $tg_back_color['default'] . ';}';
							$form_custom_css .= '.ywctm-inquiry-form-wrapper.has-toggle .ywctm-toggle-button:hover{ color:' . $tg_text_color['hover'] . '; background-color:' . $tg_back_color['hover'] . ';}';

						}
					}

					wp_enqueue_script( 'ywctm-inquiry-form', yit_load_js_file( YWCTM_ASSETS_URL . 'js/inquiry-form.js' ), array( 'jquery' ), YWCTM_VERSION, false );
					wp_localize_script(
						'ywctm-inquiry-form',
						'ywctm',
						array(
							'form_type'  => $form_type,
							'product_id' => $product->get_id(),
						)
					);

					wp_enqueue_style( 'ywctm-inquiry-form', yit_load_css_file( YWCTM_ASSETS_URL . 'css/inquiry-form.css' ), array(), YWCTM_VERSION );
					wp_add_inline_style( 'ywctm-inquiry-form', $form_custom_css );

				}
			}

			// Add styles for custom button replacing add to cart or price.
			$buttons = ywctm_get_active_buttons_id();

			if ( $buttons ) {

				$button_custom_css = '';
				$icon_sets         = array();
				$embedded_fonts    = array();

				wp_enqueue_style( 'ywctm-button-label', yit_load_css_file( YWCTM_ASSETS_URL . 'css/button-label.css' ), array(), YWCTM_VERSION );
				wp_enqueue_script( 'ywctm-button-label', yit_load_js_file( YWCTM_ASSETS_URL . 'js/button-label-frontend.js' ), array( 'jquery' ), YWCTM_VERSION, false );

				foreach ( $buttons as $button ) {
					if ( 0 === (int) $button ) {
						continue;
					}
					$button_settings = ywctm_get_button_label_settings( $button );
					$used_icons      = get_post_meta( $button, 'ywctm_used_icons', true );
					$icon_sets       = array_unique( array_merge( $icon_sets, ( '' === $used_icons ? array() : $used_icons ) ) );
					$used_fonts      = get_post_meta( $button, 'ywctm_used_fonts', true );
					$embedded_fonts  = array_unique( array_merge( $embedded_fonts, ( '' === $used_fonts ? array() : $used_fonts ) ) );

					if ( $button_settings ) {
						$button_custom_css .= ywctm_set_custom_button_css( $button, $button_settings );

						$button_custom_css = str_replace( array( "\n", "\t", "\r" ), '', $button_custom_css );
					}
				}

				if ( ! empty( $icon_sets ) ) {
					foreach ( $icon_sets as $icon_set ) {
						switch ( $icon_set ) {
							case 'fontawesome':
								wp_enqueue_style( 'font-awesome' );
								break;
							case 'dashicons':
								wp_enqueue_style( 'dashicons' );
								break;
						}
					}
				}

				if ( ! empty( $embedded_fonts ) ) {
					foreach ( $embedded_fonts as $font ) {
						$font_slug = str_replace( ' ', '-', strtolower( $font ) );
						wp_enqueue_style( "yith-gfont-$font_slug", YWCTM_ASSETS_URL . "fonts/$font_slug/style.css", array(), YWCTM_VERSION );
					}
				}

				wp_add_inline_style( 'ywctm-button-label', $button_custom_css );

			}
		}

		/**
		 * Removes reviews tab from single page product
		 *
		 * @param array $tabs Array of tabs.
		 *
		 * @return  array
		 * @since   1.0.0
		 */
		public function disable_reviews_tab( $tabs ) {

			global $product;

			$disable_review = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_disable_review' ), $product->get_id(), 'ywctm_disable_review' );

			if ( 'yes' === $disable_review && ! is_user_logged_in() ) {
				unset( $tabs['reviews'] );
			}

			return $tabs;
		}

		/**
		 * Add inquiry form tab to single product page
		 *
		 * @param array $tabs Array of tabs.
		 *
		 * @return  array
		 * @since   1.0.0
		 */
		public function add_inquiry_form_tab( $tabs ) {

			global $product;

			$enabled = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_inquiry_form_enabled', 'hidden' ), $product->get_id(), 'ywctm_inquiry_form_enabled' );
			$in_tab  = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_inquiry_form_where_show', 'tab' ), $product->get_id(), 'ywctm_inquiry_form_where_show' );

			if ( 'hidden' !== $enabled && 'tab' === $in_tab ) {

				$show_form = apply_filters( 'ywctm_get_exclusion', ( 'exclusion' !== $enabled ), $product->get_id(), 'inquiry_form' );

				if ( ! $show_form ) {
					return $tabs;
				}

				$active_form = $this->get_active_inquiry_form( $product->get_id() );

				if ( ! empty( $active_form ) && '' !== $active_form['form_id'] ) {

					$tab_title = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_inquiry_form_tab_title' ), $product->get_id(), 'ywctm_inquiry_form_tab_title' );

					/**
					 * APPLY_FILTERS: ywctm_inquiry_form_title
					 *
					 * Last chance to change the Form tab title.
					 *
					 * @param string $tab_title The title of the tab.
					 *
					 * @return string
					 */
					$tab_title            = apply_filters( 'ywctm_inquiry_form_title', $tab_title );
					$tabs['inquiry_form'] = array(
						'title'     => $tab_title,
						'priority'  => 40,
						'callback'  => array( $this, 'get_inquiry_form' ),
						'form_type' => $active_form['form_type'],
						'form_id'   => $active_form['form_id'],
					);

				}
			}

			return $tabs;
		}

		/**
		 * Add inquiry form after block
		 *
		 * @param string   $content    Block content.
		 * @param string   $block_data Block attributes (unused).
		 * @param WP_Block $block      Block object.
		 *
		 * @return string
		 * @since  2.26.0
		 */
		public function add_inquiry_form_after_block( $content, $block_data, WP_Block $block ) {
			if ( isset( $block->context['postType'] ) && 'product' === $block->context['postType'] ) {
				return $content;
			}

			$after = $this->print_inquiry_form_shortcode();

			return $content . $after;
		}

		/**
		 * Add custom button after block
		 *
		 * @param string $content Block content.
		 *
		 * @return string
		 * @since  2.26.0
		 */
		public function add_custom_button_after_block( $content ) {

			$after = $this->print_custom_button_shortcode();

			return $content . $after;
		}

		/**
		 * Add custom button after loop block
		 *
		 * @param string $content Block content.
		 *
		 * @return string
		 * @since  2.26.0
		 */
		public function add_custom_button_after_block_shop( $content ) {

			global $product;

			if ( ! $product instanceof WC_Product ) {
				global $post;
				$product = $post instanceof WP_Post ? wc_get_product( $post->ID ) : false;
			}

			if ( ! $product || ! $product instanceof WC_Product || apply_filters( 'ywctm_skip_custom_button', false, $product ) ) {
				return $content;
			}

			$after     = '';
			$button_id = 'none';

			if ( $this->check_hide_add_cart( false, false, true ) ) {
				$button_id = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_custom_button_settings_loop' ), $product->get_id(), 'ywctm_custom_button_settings_loop' );
				$button_id = apply_filters( 'ywctm_get_exclusion', $button_id, $product->get_id(), 'custom_button_loop' );
			}

			if ( ywctm_is_wpml_active() ) {
				$button_id = yit_wpml_object_id( $button_id, 'ywctm-button-label', true, wpml_get_current_language() );
			}

			if ( $this->apply_catalog_mode( $product->get_id() ) && 'none' !== $button_id ) {
				ob_start();
				$this->get_custom_button_template( $button_id, 'atc', true, $product );
				$after = ob_get_clean();
			}

			return $content . $after;
		}

		/**
		 * Get active inquiry form
		 *
		 * @param integer $product_id The Productt ID.
		 *
		 * @return  array
		 * @since   1.5.1
		 */
		public function get_active_inquiry_form( $product_id ) {

			$active_form = array();
			$form_type   = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_inquiry_form_type' ), $product_id, 'ywctm_inquiry_form_type' );

			if ( 'default' !== $form_type && ( ywctm_exists_inquiry_forms() ) ) {
				$active_form = array(
					'form_type' => $form_type,
					'form_id'   => ywctm_get_localized_form( $form_type, $product_id ),
				);
			} elseif ( 'default' === $form_type ) {
				$active_form = array(
					'form_type' => $form_type,
					'form_id'   => 'default',
				);
			}

			return $active_form;
		}

		/**
		 * Check if YITH WooCommerce Add-ons options should be printed
		 *
		 * @return  void
		 * @since   2.0.4
		 */
		public function show_wapo_if_hidden() {

			global $product;

			/**
			 * APPLY_FILTERS: ywctm_raq_disabled_check
			 *
			 * Ensure that Request a Quote is disabled.
			 *
			 * @param boolean $raq_enabled Check if Request a Quote is disabled.
			 *
			 * @return boolean
			 */
			if ( function_exists( 'YITH_WAPO' ) && $this->check_price_hidden( false, $product->get_id() ) && apply_filters( 'ywctm_raq_disabled_check', ! class_exists( 'YITH_YWRAQ_Frontend' ) ) ) {
				$priority = apply_filters( 'ywctm_wapo_position', 15 );
				add_action( 'woocommerce_single_product_summary', array( $this, 'show_wapo_options' ), $priority );
			}
		}

		/**
		 * Print YITH WooCommerce Add-ons options
		 *
		 * @return  void
		 * @since   2.0.4
		 */
		public function show_wapo_options() {

			global $product;

			echo '<form class="cart" action="' . esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ) . '" method="post" enctype="multipart/form-data">';
			echo do_shortcode( '[yith_wapo_show_options]' );
			echo '</form>';
		}

		/**
		 * Add inquiry form directly to single product page
		 *
		 * @return  void
		 * @since   1.5.1
		 */
		public function add_inquiry_form_page() {

			global $product;

			if ( 'woodmart' === ywctm_get_theme_name() ) {
				if ( isset( $GLOBALS['woodmart_loop']['is_quick_view'] ) && 'quick-view' === $GLOBALS['woodmart_loop']['is_quick_view'] ) {
					return;
				}
			}

			$enabled = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_inquiry_form_enabled', 'hidden' ), $product->get_id(), 'ywctm_inquiry_form_enabled' );
			$in_desc = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_inquiry_form_where_show', 'tab' ), $product->get_id(), 'ywctm_inquiry_form_where_show' );

			if ( 'hidden' !== $enabled && 'desc' === $in_desc ) {

				$show_form = apply_filters( 'ywctm_get_exclusion', ( 'exclusion' !== $enabled ), $product->get_id(), 'inquiry_form' );

				if ( ! $show_form ) {
					return;
				}

				$priority = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_inquiry_form_position', '15' ), $product->get_id(), 'ywctm_inquiry_form_position' );
				/**
				 * APPLY_FILTERS: ywctm_inquiry_form_hook
				 *
				 * Hook where print the inquiry form.
				 *
				 * @param string $hook The hook name.
				 *
				 * @return string
				 */
				$hook = apply_filters( 'ywctm_inquiry_form_hook', 'woocommerce_single_product_summary' );
				/**
				 * APPLY_FILTERS: ywctm_inquiry_form_priority
				 *
				 * Priority to apply to the function.
				 *
				 * @param integer $priority The hook priority.
				 *
				 * @return integer
				 */
				$priority = apply_filters( 'ywctm_inquiry_form_priority', $priority );

				if ( $hook ) {
					add_action( $hook, array( $this, 'inquiry_form_shortcode' ), $priority );
				}
			}
		}

		/**
		 * Print Inquiry form on product page
		 *
		 * @return  void
		 * @since   1.5.1
		 */
		public function inquiry_form_shortcode() {

			global $product;

			if ( ! $product ) {
				return;
			}

			$active_form = $this->get_active_inquiry_form( $product->get_id() );

			if ( ! empty( $active_form ) && '' !== $active_form['form_id'] ) {

				$tab_title   = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_inquiry_form_tab_title' ), $product->get_id(), 'ywctm_inquiry_form_tab_title' );
				$button_text = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_toggle_button_text' ), $product->get_id(), 'ywctm_toggle_button_text' );
				$form_style  = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_inquiry_form_style' ), $product->get_id(), 'ywctm_inquiry_form_style' );

				/**
				 * APPLY_FILTERS: ywctm_inquiry_form_title
				 *
				 * Last chance to change the Form tab title.
				 *
				 * @param string $tab_title The title of the form.
				 *
				 * @return string
				 */
				$tab_title = apply_filters( 'ywctm_inquiry_form_title', $tab_title );
				/**
				 * APPLY_FILTERS: ywctm_inquiry_form_title_wrapper
				 *
				 * The wrapper of the form title.
				 *
				 * @param string $title_wrapper The wrapper of the form.
				 *
				 * @return string
				 */
				$title_wrapper = apply_filters( 'ywctm_inquiry_form_title_wrapper', 'h3' );
				?>
				<div class="ywctm-inquiry-form-wrapper <?php echo ( 'toggle' === $form_style ) ? 'has-toggle' : ''; ?>">
					<?php
					if ( 'toggle' === $form_style ) {
						?>
						<div class="ywctm-toggle-button"><?php echo esc_attr( $button_text ); ?></div>
						<?php
					} else {
						echo wp_kses_post( sprintf( '<%1$s class="ywctm-form-title">%2$s</%1$s>', $title_wrapper, $tab_title ) );
					}
					?>
					<div class="ywctm-toggle-content">
						<?php $this->get_inquiry_form( 'inquiry_form', $active_form ); ?>
					</div>
				</div>
				<?php
			}
		}

		/**
		 * Inquiry form tab template
		 *
		 * @param integer $key Tab key.
		 * @param array   $tab Tab options.
		 *
		 * @return  void
		 * @since   1.0.0
		 */
		public function get_inquiry_form( $key, $tab ) {

			if ( 'inquiry_form' !== $key ) {
				return;
			}

			global $product;

			$product_id = $product ? $product->get_id() : 0;

			switch ( $tab['form_type'] ) {
				case 'contact-form-7':
					$shortcode = '[contact-form-7 id="' . $tab['form_id'] . '"]';
					break;
				case 'ninja-forms':
					$shortcode = '[ninja_form id="' . $tab['form_id'] . '"]';
					break;
				case 'formidable-forms':
					$shortcode = '[formidable id="' . $tab['form_id'] . '"]';
					break;
				case 'gravity-forms':
					$shortcode = '[gravityform id="' . $tab['form_id'] . '" ' . apply_filters( 'ywctm_gravity_ajax', ' ajax="true"' ) . ']';
					break;
				case 'wpforms':
					$shortcode = '[wpforms  id=' . $tab['form_id'] . ']';
					break;
				default:
					$shortcode = '[ywctm-default-form]';
			}

			/**
			 * DO_ACTION: ywctm_before_inquiry_form
			 *
			 * Execute code before printing the inquiry form.
			 *
			 * @param WC_Product $product The current Product.
			 */
			do_action( 'ywctm_before_inquiry_form', $product );

			echo wp_kses_post( apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_text_before_form' ), $product_id, 'ywctm_text_before_form' ) );
			echo do_shortcode( $shortcode );

			/**
			 * DO_ACTION: ywctm_after_inquiry_form
			 *
			 * Execute code after printing the inquiry form.
			 *
			 * @param WC_Product $product The current Product.
			 */
			do_action( 'ywctm_after_inquiry_form', $product );
		}

		/**
		 * Add a custom button into a shortcode
		 *
		 * @return  string
		 * @since   2.0.0
		 */
		public function print_custom_button_shortcode() {

			ob_start();
			$this->show_custom_button( true );

			return ob_get_clean();
		}

		/**
		 * Add inquiry form into a shortcode
		 *
		 * @return  string
		 * @since   2.0.0
		 */
		public function print_inquiry_form_shortcode() {

			global $product;

			if ( ! $product instanceof WC_Product ) {
				global $post;
				$product = $post instanceof WP_Post ? wc_get_product( $post->ID ) : false;
			}
			if ( ! $product ) {
				return '';
			}

			$enabled   = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_inquiry_form_enabled', 'hidden' ), $product->get_id(), 'ywctm_inquiry_form_enabled' );
			$show_form = apply_filters( 'ywctm_get_exclusion', ( 'exclusion' !== $enabled ), $product->get_id(), 'inquiry_form' );

			ob_start();
			if ( $show_form && 'hidden' !== $enabled ) {
				$this->inquiry_form_shortcode();
			}

			return ob_get_clean();
		}

		/**
		 * Add custom button to single product page
		 *
		 * @return  void
		 * @since   2.5.0
		 */
		public function add_custom_button_page() {
			/**
			 * APPLY_FILTERS: ywctm_custom_button_hook
			 *
			 * Hook where print the custom button.
			 *
			 * @param string $hook The hook name.
			 *
			 * @return string
			 */
			$hook = apply_filters( 'ywctm_custom_button_hook', 'woocommerce_single_product_summary' );
			/**
			 * APPLY_FILTERS: ywctm_custom_button_priority
			 *
			 * Priority to apply to the function.
			 *
			 * @param integer $priority The hook priority.
			 *
			 * @return integer
			 */
			$priority = apply_filters( 'ywctm_custom_button_priority', 20 );

			if ( $hook ) {
				add_action( $hook, array( $this, 'show_custom_button' ), $priority );
			}
		}

		/**
		 * Add a custom button in product details and shop page
		 *
		 * @param boolean $in_shortcode The button is inside a shortcode.
		 *
		 * @return  void
		 * @since   1.0.0
		 */
		public function show_custom_button( $in_shortcode = false ) {
			global $product;

			if ( ! $product instanceof WC_Product ) {
				global $post;
				$product = $post instanceof WP_Post ? wc_get_product( $post->ID ) : false;
			}

			if ( ! $product || ! $product instanceof WC_Product || apply_filters( 'ywctm_skip_custom_button', false, $product ) ) {
				return;
			}

			/**
			 * APPLY_FILTERS: ywctm_custom_button_hook
			 *
			 * Hook where print the custom button.
			 *
			 * @param string $hook The hook name.
			 *
			 * @return string
			 */
			$hook = apply_filters( 'ywctm_custom_button_hook', 'woocommerce_single_product_summary' );

			/**
			 * APPLY_FILTERS: ywctm_allowed_page_hooks
			 *
			 * Hooks enabled for single product page.
			 *
			 * @param array $page_actions The hooks list.
			 *
			 * @return array
			 */
			$page_actions = apply_filters( 'ywctm_allowed_page_hooks', array( $hook ) );
			/**
			 * APPLY_FILTERS: ywctm_allowed_shop_hooks
			 *
			 * Hooks enabled for shop page.
			 *
			 * @param array $loop_actions The hooks list.
			 *
			 * @return array
			 */
			$loop_actions = apply_filters( 'ywctm_allowed_shop_hooks', array( 'woocommerce_after_shop_loop_item' ) );
			$is_loop      = in_array( current_action(), $loop_actions, true );
			$is_page      = in_array( current_action(), $page_actions, true ) || $in_shortcode;
			$button_id    = 'none';

			if ( $is_page && $this->check_hide_add_cart( true ) ) {
				$button_id = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_custom_button_settings' ), $product->get_id(), 'ywctm_custom_button_settings' );
				$button_id = apply_filters( 'ywctm_get_exclusion', $button_id, $product->get_id(), 'custom_button' );
			}

			if ( $is_loop && $this->check_hide_add_cart( false, false, true ) ) {
				$button_id = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_custom_button_settings_loop' ), $product->get_id(), 'ywctm_custom_button_settings_loop' );
				$button_id = apply_filters( 'ywctm_get_exclusion', $button_id, $product->get_id(), 'custom_button_loop' );
			}

			if ( ywctm_is_wpml_active() ) {
				$button_id = yit_wpml_object_id( $button_id, 'ywctm-button-label', true, wpml_get_current_language() );
			}

			if ( $this->apply_catalog_mode( $product->get_id() ) && 'none' !== $button_id && 'ywctm-button-label' === get_post_type( $button_id ) ) {
				$this->get_custom_button_template( $button_id, 'atc', $is_loop, $product );
			}
		}

		/**
		 * Get custom button template
		 *
		 * @param integer|boolean    $button_id The button ID.
		 * @param string             $replaces  What replaces.
		 * @param boolean            $is_loop   Loop checker.
		 * @param WC_Product|boolean $product   The product.
		 *
		 * @return  void
		 * @since   1.0.4
		 */
		public function get_custom_button_template( $button_id = false, $replaces = 'atc', $is_loop = false, $product = false ) {

			if ( ! $product ) {
				global $product;

				if ( ! $product instanceof WC_Product ) {
					global $post;
					$product = $post instanceof WP_Post ? wc_get_product( $post->ID ) : false;
				}
			}

			if ( ! $product || ( $product && ! $product instanceof WC_Product ) ) {
				return;
			}

			if ( false === $button_id ) {

				if ( 'price' === $replaces ) {
					$button_id = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_custom_price_text_settings' ), $product->get_id(), 'ywctm_custom_price_text_settings' );
				} else {
					$button_id = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_custom_button_settings' ), $product->get_id(), 'ywctm_custom_button_settings' );
				}
			}

			$button_settings = ywctm_get_button_label_settings( $button_id );
			$is_published    = 'publish' === get_post_status( $button_id );

			if ( ! $button_settings || ( ! $is_published && 'legacy' !== $button_id ) || 0 === (int) $button_id ) {
				return;
			}

			/**
			 * APPLY_FILTERS: ywctm_custom_button_additional_classes
			 *
			 * Additional classes for custom button.
			 *
			 * @param string  $custom_classes Additional class.
			 * @param integer $button_id      The button ID.
			 *
			 * @return string
			 */
			$custom_classes = apply_filters( 'ywctm_custom_button_additional_classes', '', $button_id );
			$classes        = array( 'ywctm-custom-button', $custom_classes );

			if ( 'none' !== $button_settings['hover_animation'] ) {
				$classes[] = 'ywctm-hover-effect ywctm-effect-' . $button_settings['hover_animation'];
			}

			switch ( $button_settings['button_url_type'] ) {
				case 'custom':
					$custom_url  = ywctm_get_custom_button_url_override( $product, $replaces, $is_loop );
					$button_type = 'a';
					$button_url  = 'href="' . ( '' === $custom_url ? $button_settings['button_url'] : $custom_url ) . '"';
					break;
				case 'product':
					$button_type = 'a';
					$button_url  = 'href="' . $product->get_permalink() . '"';
					break;
				default:
					$button_type = 'span';
					$button_url  = '';
			}
			/**
			 * APPLY_FILTERS: ywctm_custom_button_open_new_page
			 *
			 * Check if button link opens in new page.
			 *
			 * @param boolean $value     Check if button link should open in new page.
			 * @param integer $button_id The button ID.
			 *
			 * @return boolean
			 */
			if ( apply_filters( 'ywctm_custom_button_open_new_page', false, $button_id ) && 'none' !== $button_settings['button_url_type'] ) {
				$button_url .= ' target="_blank"';
			}

			$button_text = '<span class="ywctm-inquiry-title">' . ywctm_parse_icons( $button_settings['label_text'] ) . '</span>';

			switch ( $button_settings['icon_type'] ) {
				case 'icon':
					$button_icon = '<span class="ywctm-icon-form ' . ywctm_get_icon_class( $button_settings['selected_icon'] ) . '"></span>';
					break;
				case 'custom':
					$button_icon = '<span class="custom-icon"><img src="' . $button_settings['custom_icon'] . '"></span>';
					break;
				default:
					$button_icon = '';
			}

			?>
			<div class="ywctm-custom-button-container ywctm-button-<?php echo esc_attr( $button_id ); ?>" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>">
				<?php echo wp_kses_post( sprintf( '<%1$s class="%2$s" %3$s>%4$s%5$s</%1$s>', $button_type, implode( ' ', $classes ), $button_url, $button_icon, $button_text ) ); ?>
			</div>
			<?php
		}

		/**
		 * Hides product price from single product page
		 *
		 * @param array $classes Classes array.
		 *
		 * @return  array
		 * @since   1.4.4
		 */
		public function hide_price_single_page( $classes ) {

			if ( $this->check_hide_price() ) {

				$args = array(
					'.woocommerce-variation-price',
				);

				if ( function_exists( 'YITH_WAPO' ) && function_exists( 'yith_wapo_get_option_info' ) ) {
					$args[] = '.yith-wapo-option .option-price';
					$args[] = '#wapo-total-price-table';
				}

				/**
				 * APPLY_FILTERS: ywctm_catalog_price_classes
				 *
				 * CSS classes of price element.
				 *
				 * @param array $args The CSS classes array.
				 *
				 * @return array
				 */
				$classes = array_merge( $classes, apply_filters( 'ywctm_catalog_price_classes', $args ) );

			}

			return $classes;
		}

		/**
		 * Hides on-sale badge if price is hidden
		 *
		 * @param boolean    $is_on_sale Check if product is on sale.
		 * @param WC_Product $product    Product object.
		 *
		 * @return  boolean
		 * @since   1.5.5
		 */
		public function hide_on_sale( $is_on_sale, $product ) {

			if ( $this->check_hide_price( $product->get_id() ) ) {
				$is_on_sale = false;
			}

			return $is_on_sale;
		}

		/**
		 * Check if price is hidden
		 *
		 * @param boolean $hide       Hide check.
		 * @param integer $product_id The product ID.
		 *
		 * @return  boolean
		 * @since   1.4.4
		 */
		public function check_price_hidden( $hide, $product_id ) {

			if ( $this->check_hide_price( $product_id ) && $this->apply_catalog_mode( $product_id ) ) {
				$hide = true;
			}

			return $hide;
		}

		/**
		 * Check if price is hidden
		 *
		 * @param integer|boolean $product_id The product ID.
		 *
		 * @return  boolean
		 * @since   2.0.0
		 */
		public function check_hide_price( $product_id = false ) {

			if ( $product_id ) {
				$product = wc_get_product( $product_id );
			} else {
				global $product;
				if ( ! $product instanceof WC_Product ) {
					global $post;
					$product = $post instanceof WP_Post ? wc_get_product( $post->ID ) : false;
				}
			}

			if ( ! $product || ( $product && ! $product instanceof WC_Product ) ) {
				return false;
			}

			if ( ywctm_is_wpml_active() && apply_filters( 'ywctm_wpml_use_default_language_settings', false ) ) {
				$base_product_id = yit_wpml_object_id( $product->get_id(), 'product', true, wpml_get_default_language() );
				$product         = wc_get_product( $base_product_id );

				if ( ! $product ) {
					return false;
				}
			}

			$price_settings_general = apply_filters(
				'ywctm_get_vendor_option',
				get_option(
					'ywctm_hide_price_settings',
					array(
						'action' => 'show',
						'items'  => 'all',
					)
				),
				$product->get_id(),
				'ywctm_hide_price_settings'
			);
			$behavior               = $price_settings_general['action'];

			if ( 'all' !== $price_settings_general['items'] ) {
				$behavior = apply_filters( 'ywctm_get_exclusion', ( 'hide' === $behavior ? 'show' : 'hide' ), $product->get_id(), 'price', $behavior );
			}

			return ( 'hide' === $behavior && $this->apply_catalog_mode( $product->get_id() ) );
		}

		/**
		 * Check for which users will not see the price
		 *
		 * @param string  $price   The product Price.
		 * @param integer $product The Product Object.
		 *
		 * @return  string
		 * @since   1.0.0
		 */
		public function show_product_price( $price, $product ) {

			if ( defined( 'WOOCOMMERCE_CHECKOUT' ) || defined( 'WOOCOMMERCE_CART' ) || apply_filters( 'ywctm_ajax_admin_check', is_admin() && ! wp_doing_ajax(), $product ) || ( apply_filters( 'ywctm_prices_only_on_cart', false ) && ( current_filter() === 'woocommerce_get_price' || current_filter() === 'woocommerce_product_get_price' ) ) ) {
				return $price;
			}

			if ( $product instanceof WC_Product ) {
				$product_id = $product->is_type( 'variation' ) ? $product->get_parent_id() : $product->get_id();
			} else {
				$product_id = $product;
			}

			if ( $this->check_hide_price( $product_id ) && $this->apply_catalog_mode( $product_id ) ) {
				$current_product = $product instanceof WC_Product ? $product : wc_get_product( $product );

				if ( ( current_filter() === 'woocommerce_get_price' || current_filter() === 'woocommerce_product_get_price' ) ) {
					if ( ( class_exists( 'YITH_Request_Quote_Premium' ) && get_option( 'ywraq_show_button_near_add_to_cart' ) === 'yes' ) || is_account_page() || 'yith-composite' === $current_product->get_type() ) {
						$value = 0;
					} else {
						$value = '';
					}

					$price = apply_filters( 'ywctm_hidden_price_meta', $value );

				} elseif ( current_filter() === 'yith_ywraq_hide_price_template' ) {
					$price = '';
				} else {

					$label_id = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_custom_price_text_settings' ), $product_id, 'ywctm_custom_price_text_settings' );
					$label_id = apply_filters( 'ywctm_get_exclusion', $label_id, $product_id, 'price_label' );

					if ( ywctm_is_wpml_active() ) {
						$label_id = yit_wpml_object_id( $label_id, 'ywctm-button-label', true, wpml_get_current_language() );
					}

					if ( 'none' !== $label_id && 'ywctm-button-label' === get_post_type( $label_id ) ) {
						ob_start();
						$this->get_custom_button_template( $label_id, 'price', false, $current_product );
						$price = ob_get_clean();
					} else {
						$price = '';
					}
				}
			}

			return apply_filters( 'ywctm_hide_price_anyway', $price, $product_id );
		}

		/**
		 * Set products as purchasable if YITH Composite Products for WooCommerce is enabled
		 *
		 * @param boolean $value Check if the product is purchasable.
		 *
		 * @return  boolean
		 * @since   2.0.16
		 */
		public function unlock_purchase_if_ywcp_is_enabled( $value ) {
			if ( class_exists( 'YITH_WCP' ) ) {
				$value = true;
			}

			return $value;
		}

		/**
		 * Hide price for bulndle product
		 *
		 * @param boolean    $per_items_pricing Check if bundle has "Per items pricing" enabled.
		 * @param WC_Product $product           Product Object.
		 *
		 * @return boolean
		 * @since   2.0.15
		 */
		public function hide_price_bundle( $per_items_pricing, $product ) {
			if ( $this->check_price_hidden( false, $product->get_id() ) ) {
				$per_items_pricing = false;
			}

			return $per_items_pricing;
		}

		/**
		 * Hide price for bulndle product
		 *
		 * @param boolean    $value        Bundled item price value.
		 * @param mixed      $bundled_item Unused.
		 * @param WC_Product $product      Product Object.
		 *
		 * @return boolean
		 * @since   2.0.15
		 */
		public function hide_price_bundled_items( $value, $bundled_item, $product ) {
			if ( $this->check_price_hidden( false, $product->get_id() ) ) {
				$value = false;
			}

			return $value;
		}

		/**
		 * Hide discount quantity table from YITH WooCommerce Dynamic Pricing Discount id the catalog mode is active
		 *
		 * @param boolean    $value   Unused.
		 * @param WC_Product $product Product Object.
		 *
		 * @return boolean
		 * @since  2.0.0
		 */
		public function hide_discount_quantity_table( $value, $product ) {
			return $product && $this->check_hide_add_cart( true, $product->get_id() );
		}

		/**
		 * Hides product price and add to cart in YITH Quick View
		 *
		 * @return  void
		 * @since   1.0.7
		 */
		public function check_quick_view() {
			if ( $this->is_quick_view() ) {
				$this->hide_add_to_cart_quick_view();
				$this->hide_price_quick_view();
			}
		}

		/**
		 * Hide price for product in quick view
		 *
		 * @return  void
		 * @since   1.0.7
		 */
		public function hide_price_quick_view() {

			if ( $this->check_hide_price() ) {

				$args = array(
					'.single_variation_wrap .single_variation',
					'.yith-quick-view .price',
					'.price-wrapper',
				);

				/**
				 * APPLY_FILTERS: ywctm_catalog_price_classes
				 *
				 * CSS classes of price element.
				 *
				 * @param array $args The CSS classes array.
				 *
				 * @return array
				 */
				$classes = implode( ', ', apply_filters( 'ywctm_catalog_price_classes', $args ) );

				?>
				<style type="text/css">
					.ywctm-void, <?php echo esc_attr( $classes ); ?> {
						display: none !important;
					}
				</style>
				<?php
			}
		}

		/**
		 * Themes Integration
		 *
		 * @return  void
		 * @since   1.0.0
		 */
		public function themes_integration() {

			$theme_name = strtolower( ywctm_get_theme_name() );

			switch ( $theme_name ) {
				case 'flatsome':
					add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'hide_add_to_cart_quick_view' ) );
					add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'hide_price_quick_view' ) );
					add_action( 'woocommerce_single_product_lightbox_summary', array( $this, 'show_custom_button' ), 20 );
					add_filter( 'ywctm_allowed_shop_hooks', array( $this, 'flatsome_support' ) );
					add_filter( 'ywctm_ajax_admin_check', '__return_false' );
					add_filter( 'ywctm_modify_woocommerce_after_shop_loop_item', '__return_false' );

					if ( 'list' === get_theme_mod( 'category_grid_style', 'grid' ) ) {
						remove_action( 'woocommerce_after_shop_loop_item', array( $this, 'show_custom_button' ), 20 );
						add_action( 'flatsome_product_box_after', array( $this, 'show_custom_button' ), 20 );
					}

					if ( 'grid' === get_theme_mod( 'category_grid_style', 'grid' ) ) {
						remove_action( 'woocommerce_after_shop_loop_item', array( $this, 'show_custom_button' ), 20 );
						add_filter( 'woocommerce_loop_add_to_cart_link', array( $this, 'flatsome_grid_shop_page' ), 20 );
						add_action( 'ywctm_flastome_loop_custom_button', array( $this, 'show_custom_button' ), 20 );
					}
					break;
				case 'oceanwp':
					add_action( 'ocean_woo_quick_view_product_content', array( $this, 'hide_add_to_cart_quick_view' ) );
					add_action( 'ocean_woo_quick_view_product_content', array( $this, 'hide_price_quick_view' ) );
					add_filter( 'ywctm_modify_woocommerce_after_shop_loop_item', '__return_false' );
					break;
				case 'astra':
					add_action( 'astra_woo_quick_view_product_summary', array( $this, 'hide_add_to_cart_quick_view' ) );
					add_action( 'astra_woo_quick_view_product_summary', array( $this, 'hide_price_quick_view' ) );
					add_filter( 'ywctm_modify_woocommerce_after_shop_loop_item', '__return_false' );
					break;
				case 'avada':
				case 'electro':
				case 'enfold':
					add_filter( 'ywctm_modify_woocommerce_after_shop_loop_item', '__return_false' );
					break;
				case 'woodmart':
					add_filter( 'ywctm_modify_woocommerce_after_shop_loop_item', '__return_false' );
					add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'hide_add_to_cart_quick_view' ) );
					add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'hide_price_quick_view' ) );
					add_filter( 'ywctm_ajax_admin_check', '__return_false' );
					add_filter( 'ywctm_quick_view_actions', array( $this, 'woodmart_ajax_action' ) );
					break;
				case 'uncode':
					add_filter( 'ywctm_modify_woocommerce_after_shop_loop_item', '__return_false' );
					add_filter( 'ywctm_allowed_shop_hooks', array( $this, 'uncode_support_loop' ) );
					add_filter( 'ywctm_custom_button_additional_classes', array( $this, 'uncode_support_custom_button' ) );
					add_action( 'woocommerce_loop_add_to_cart_link', array( $this, 'show_custom_button' ), 20 );
					add_action( 'wp_enqueue_scripts', array( $this, 'uncode_support_css' ), 99 );
					break;
			}
		}

		/**
		 * Adds support for Uncode theme.
		 *
		 * @return  array
		 * @since   2.13.0
		 */
		public function uncode_support_loop() {
			return array( 'woocommerce_loop_add_to_cart_link' );
		}

		/**
		 * Adds support for Uncode theme.
		 *
		 * @return  string
		 * @since   2.13.0
		 */
		public function uncode_support_custom_button() {
			return 'view-cart';
		}

		/**
		 * Adds support for Uncode theme.
		 *
		 * @return  void
		 * @since   2.13.0
		 */
		public function uncode_support_css() {
			$css = '
			.ywctm-inquiry-title, .ywctm-inquiry-title * {
				color: inherit!important;
			}
			';
			wp_add_inline_style( 'ywctm-button-label', $css );
		}

		/**
		 * Add Woodmart AJAX actions
		 *
		 * @param array $actions The allowed AJAX actions.
		 *
		 * @return array
		 * @since  2.13.0
		 */
		public function woodmart_ajax_action( $actions ) {
			$actions[] = 'woodmart_get_products_shortcode';

			return $actions;
		}

		/**
		 * Adds support for flatsome Quci View
		 *
		 * @param array $hooks The allowed quickview hooks.
		 *
		 * @return  array
		 * @since   2.0.12
		 */
		public function flatsome_support( $hooks ) {
			$hooks[] = 'woocommerce_single_product_lightbox_summary';

			if ( 'list' === get_theme_mod( 'category_grid_style', 'grid' ) ) {
				$hooks[] = 'flatsome_product_box_after';
			}
			if ( 'grid' === get_theme_mod( 'category_grid_style', 'grid' ) ) {
				$hooks[] = 'ywctm_flastome_loop_custom_button';
			}

			return $hooks;
		}

		/**
		 * Add custom button in Flatsme grid layout
		 *
		 * @param string $html The content of the add to cart filter.
		 *
		 * @return string
		 * @since  2.14.0
		 */
		public function flatsome_grid_shop_page( $html ) {
			ob_start();
			do_action( 'ywctm_flastome_loop_custom_button' );
			$button = ob_get_clean();

			return $html . $button;
		}

		/**
		 * Checks if product price needs to be hidden
		 *
		 * @param boolean         $x          Unused.
		 * @param integer|boolean $product_id The Product ID.
		 *
		 * @return  boolean
		 * @since   1.0.2
		 */
		public function check_product_price_single( $x = true, $product_id = false ) {
			return $this->check_hide_price( $product_id );
		}

		/**
		 * YITH FRAMEWORK
		 */

		/**
		 * Register plugins for activation tab
		 *
		 * @return  void
		 * @since   2.0.0
		 */
		public function register_plugin_for_activation() {
			if ( ! class_exists( 'YIT_Plugin_Licence' ) ) {
				require_once 'plugin-fw/licence/lib/yit-licence.php';
				require_once 'plugin-fw/licence/lib/yit-plugin-licence.php';
			}
			YIT_Plugin_Licence()->register( YWCTM_INIT, YWCTM_SECRET_KEY, YWCTM_SLUG );
		}

		/**
		 * Register plugins for update tab
		 *
		 * @return  void
		 * @since   2.0.0
		 */
		public function register_plugin_for_updates() {
			if ( ! class_exists( 'YIT_Upgrade' ) ) {
				require_once 'plugin-fw/lib/yit-upgrade.php';
			}
			YIT_Upgrade()->register( YWCTM_SLUG, YWCTM_INIT );
		}

		/**
		 * Plugin row meta
		 *
		 * Add the action links to plugin admin page
		 *
		 * @param array  $new_row_meta_args Row meta args.
		 * @param array  $plugin_meta       Plugin meta.
		 * @param string $plugin_file       Plugin File.
		 * @param array  $plugin_data       Plugin data.
		 * @param string $status            Status.
		 * @param string $init_file         Init file.
		 *
		 * @return  array
		 * @since   1.0.0
		 * @use     plugin_row_meta
		 */
		public function plugin_row_meta( $new_row_meta_args, $plugin_meta, $plugin_file, $plugin_data, $status, $init_file = 'YWCTM_INIT' ) {
			$new_row_meta_args = parent::plugin_row_meta( $new_row_meta_args, $plugin_meta, $plugin_file, $plugin_data, $status, $init_file );

			if ( defined( $init_file ) && constant( $init_file ) === $plugin_file ) {
				$new_row_meta_args['is_premium'] = true;
			}

			return $new_row_meta_args;
		}

		/**
		 * Action Links
		 *
		 * Add the action links to plugin admin page
		 *
		 * @param array $links links plugin array.
		 *
		 * @return  array
		 * @since   1.0.0
		 * @use     plugin_action_links_{$plugin_file_name}
		 */
		public function action_links( $links ) {
			$links = yith_add_action_links( $links, $this->panel_page, true, YWCTM_SLUG );

			return $links;
		}
	}

}
