<?php
/**
 * Contact Form 7 functions
 *
 * @package YITH\CatalogMode\Integrations\Forms\ContactForm7
 * @author  YITH <plugins@yithemes.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'ywctm_contact_form_7_active' ) ) {

	/**
	 * Check if Contact Form 7 is active
	 *
	 * @return boolean
	 * @since   2.1.0
	 */
	function ywctm_contact_form_7_active() {
		return class_exists( 'WPCF7_ContactForm' );
	}
}

if ( ! function_exists( 'ywctm_contact_form_7_get_contact_forms' ) ) {

	/**
	 * Get list of forms by Contact Form 7 plugin
	 *
	 * @return  array|string
	 * @since   2.0.0
	 */
	function ywctm_contact_form_7_get_contact_forms() {

		if ( ! ywctm_contact_form_7_active() ) {
			return 'inactive';
		}

		$active_forms = array();
		$forms        = WPCF7_ContactForm::find();

		if ( $forms ) {
			foreach ( $forms as $form ) {
				$active_forms[ $form->id() ] = $form->title();
			}
		}

		if ( array() === $active_forms ) {
			return 'no-forms';
		}

		return $active_forms;
	}
}

if ( ! function_exists( 'ywctm_contact_form_7_message' ) ) {

	/**
	 * Append Product page permalink to mail body (WPCF7)
	 *
	 * @param array             $components   Form data.
	 * @param WPCF7_ContactForm $contact_form Form Object.
	 *
	 * @return  array
	 * @since   2.0.0
	 */
	function ywctm_contact_form_7_message( $components, $contact_form ) {

		$request = $_REQUEST; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $request['ywctm-product-id'] ) ) {

			$product_id     = $request['ywctm-product-id'];
			$params         = explode( ',', $request['ywctm-params'] );
			$contact_form_7 = ywctm_get_localized_form( 'contact-form-7', $product_id );

			if ( $contact_form->id() === (int) $contact_form_7 && apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_inquiry_product_permalink' ), $product_id, 'ywctm_inquiry_product_permalink' ) === 'yes' ) {

				$form_atts   = $contact_form->get_properties();
				$field_label = esc_html__( 'Product', 'yith-woocommerce-catalog-mode' );

				if ( ! $form_atts['mail']['use_html'] ) {
					$field_data = $field_label . ': ' . ywctm_get_product_link( $product_id, $params, false ) . "\n\n";
				} else {
					ob_start();
					?>
					<p>
						<?php echo esc_attr( $field_label ); ?>
						: <?php echo wp_kses_post( ywctm_get_product_link( $product_id, $params ) ); ?>
					</p>
					<?php
					$field_data = ob_get_clean();
				}

				$components['body'] = $field_data . $components['body'];

			}
		}

		return $components;
	}

	add_filter( 'wpcf7_mail_components', 'ywctm_contact_form_7_message', 10, 2 );

}
