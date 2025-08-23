<?php
/**
 *  Adds admin notices
 *  - Review notice
 *  - License is not active notice (based on the version)
 */

defined( 'ABSPATH' ) || die();


class AGS_Divi_Wc_Notices {

	/**
	 * Display review notice after number of days.
	 *
	 * @used in notice_admin_conditions()
	 */

	const NOTICE_DAYS = 14;

	public static function setup() {


		if ( self::notice_admin_review_conditions() ) {
			add_action( 'admin_notices', [ 'AGS_Divi_Wc_Notices', 'notice_admin_review_content' ] );
			add_action( 'wp_ajax_ds_divi_shop_builder_notice_hide', [ 'AGS_Divi_Wc_Notices', 'notice_admin_review_hide' ] );
			add_action( 'admin_enqueue_scripts', [ 'AGS_Divi_Wc_Notices', 'admin_scripts' ], 11 );
		}

		
		if ( self::notice_admin_license_conditions() ) {
			add_action( 'admin_notices', [ 'AGS_Divi_Wc_Notices', 'notice_admin_license_content' ] );
		}
		

		if ( ! function_exists('WC') ) {
			add_action( 'admin_notices', [ 'AGS_Divi_Wc_Notices', 'notice_admin_woocommerce_inactive_content' ] );
		}
	}

	/**
	 * Enqueue scripts for all admin pages.
	 * Called in setup()
	 *
	 * @since 1.0.0
	 *
	 */
	public static function admin_scripts() {
		wp_enqueue_script( 'ds-divi-shop-builder-notices-admin', plugin_dir_url( __FILE__ ) . 'js/admin.min.js', [ 'jquery' ], AGS_divi_wc::PLUGIN_VERSION, true );
	}

	/**
	 * Review Notice:
	 * Conditions based on which notice is displayed
	 */
	public static function notice_admin_review_conditions() {
		return get_option( 'ds_divi_shop_builder_first_activate' ) && get_option( 'ds_divi_shop_builder_notice_hidden' ) != 1 && time() - get_option( 'ds_divi_shop_builder_first_activate' ) >= ( self::NOTICE_DAYS * 86400 );
	}

	
	/**
	 * Admin License Notice:
	 * Conditions based on which notice is displayed
	 */
	public static function notice_admin_license_conditions() {
		$not_activated = ! ags_divi_wc_has_license_key();

		return $not_activated;
	}
	


	/**
	 * Review Notice:
	 * Content of the notice
	 */
	public static function notice_admin_review_content() {
		
		
		$link = 'https://wpzone.co/product/divi-shop-builder/';
		

		// translators: 1 is the plugin name, 2 and 3 are <a> tags
		$message = sprintf( esc_html__( 'Do you use the %1$s plugin? Please support us by %2$swriting a review%3$s.', 'divi-shop-builder' ),
			'<strong>' . esc_html( AGS_divi_wc::PLUGIN_NAME ) . '</strong>',
			'<a href="' . esc_url( $link ) . '" target="_blank">', '</a>'
		);

		printf( '<div id="%1$s" class="updated notice is-dismissible"><p>%2$s</p></div>',
			esc_attr( AGS_divi_wc::PLUGIN_SLUG ) . '-notice',
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$message
		);
	}

	/**
	 * Review Notice:
	 * Triggered on dismiss notice button click
	 */
	public static function notice_admin_review_hide() {
		update_option( 'ds_divi_shop_builder_notice_hidden', 1 );
	}

	
	/**
	 * Admin License Notice:
	 * Content of the notice
	 */
	public static function notice_admin_license_content() {

		// translators: 1 is the plugin name, 2 and 3 are <a> tags
		$message = sprintf( esc_html__( 'To use %1$s, %2$sactivate%3$s your license key.', 'divi-shop-builder' ),
			'<strong>' . esc_html( AGS_divi_wc::PLUGIN_NAME ) . '</strong>',
			'<a href="' . esc_url( admin_url( AGS_divi_wc::PLUGIN_PAGE ) ) . '">', '</a>'
		);

		printf( '<div id="%1$s" class="notice notice-warning"><p>%2$s</p></div>',
			esc_attr( AGS_divi_wc::PLUGIN_SLUG ) . '-license-notice',
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$message
		);
	}
	

	public static function notice_admin_woocommerce_inactive_content () {

		// translators: 1 is the plugin name, 2 and 3 are <a> tags
		$message = sprintf( esc_html__( 'To use %1$s, install and activate %2$sWooCommerce Plugin%3$s.', 'divi-shop-builder' ),
			'<strong>' . esc_html( AGS_divi_wc::PLUGIN_NAME ) . '</strong>',
			'<a href="https://wordpress.org/plugins/woocommerce/">', '</a>'
		);

		printf( '<div id="%1$s" class="notice notice-warning"><p>%2$s</p></div>',
			esc_attr( AGS_divi_wc::PLUGIN_SLUG ) . '-requirements-notice',
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$message
		);
	}

}

AGS_Divi_Wc_Notices::setup();