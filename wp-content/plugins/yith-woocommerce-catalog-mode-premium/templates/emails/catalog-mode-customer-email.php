<?php
/**
 * Customer email HTML body
 *
 * @package YITH\CatalogMode\Templates\Emails
 * @var $email_heading string The email header.
 * @var $email         WC_Email The email object.
 * @var $mail_body     string The email body.
 * @var $form_data     array The data from the form.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_email_header', $email_heading, $email );

echo wp_kses_post( wpautop( wptexturize( $mail_body ) ) );

?>
	<div style="font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; margin-bottom: 40px;">
		<ul>
			<?php foreach ( $form_data as $key => $field ) : ?>

				<?php
				if ( ! isset( $field['label'] ) || ! $field['value'] ) {
					continue;
				}
				?>

				<?php if ( 'product' === $key ) : ?>
					<li><strong><?php echo wp_kses_post( $field['label'] ); ?>:</strong> <?php echo wp_kses_post( ywctm_get_product_link( $field['value']['id'], $field['value']['params'] ) ); ?></li>
				<?php else : ?>
					<li><strong><?php echo wp_kses_post( $field['label'] ); ?>:</strong> <span class="text"><?php echo wp_kses_post( $field['value'] ); ?></span></li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</div>
<?php

do_action( 'woocommerce_email_footer', $email );
