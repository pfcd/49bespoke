<?php
/**
 * Ajax handler class
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Brands\Classes
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly.

if ( ! class_exists( 'YITH_WCBR_Ajax_Handler' ) ) {
	/**
	 * YITH_WCBR_Ajax_Handler class
	 *
	 * @since 1.0.0
	 */
	class YITH_WCBR_Ajax_Handler {

		/**
		 * Performs all required add_action.
		 *
		 * @return void
		 */
		public static function init() {
			add_action( 'wp_ajax_yith_wcbr_brand_filter', array( 'YITH_WCBR_Ajax_Handler', 'brand_filter' ) );
			add_action( 'wp_ajax_nopriv_yith_wcbr_brand_filter', array( 'YITH_WCBR_Ajax_Handler', 'brand_filter' ) );
		}

		/**
		 * Performs brand filter.
		 */
		public static function brand_filter() {
			if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'yith_ajax_nonce' ) ) {
				die;
			}

			$shortcode_args = isset( $_POST['shortcode_args'] ) ? (array) $_POST['shortcode_args'] : false; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
			$filter         = isset( $_POST['filter'] ) ? sanitize_text_field( wp_unslash( $_POST['filter'] ) ) : false;
			$current_page   = isset( $_POST['page'] ) ? intval( sanitize_text_field( wp_unslash( $_POST['page'] ) ) ) : false;

			// sanitize shortcode args.
			$sanitized_args = array();

			if ( ! empty( $shortcode_args ) ) {
				foreach ( $shortcode_args as $key => $value ) {
					if ( ! is_string( $value ) ) {
						continue;
					}

					$value = sanitize_text_field( $value );

					$sanitized_args[ $key ] = $value;
				}
			}

			if ( ! empty( $filter ) && 'all' !== $filter ) {
				$sanitized_args['name_like'] = $filter;
			}

			if ( ! empty( $current_page ) ) {
				$sanitized_args['page'] = $current_page;
			}

			// create param in textual form.
			$args_string = '';

			if ( ! empty( $sanitized_args ) ) {
				foreach ( $sanitized_args as $key => $value ) {
					$args_string .= " {$key}=\"{$value}\"";
				}
			}

			$shortcode = "[yith_wcbr_brand_filter {$args_string}]";
			echo do_shortcode( $shortcode );
			die;
		}
	}
}

// init shortcodes.
YITH_WCBR_Ajax_Handler::init();
