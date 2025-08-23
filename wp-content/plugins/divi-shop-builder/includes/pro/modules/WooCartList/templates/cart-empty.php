<?php

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_cart_is_empty' );

if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
	<p class="return-to-shop">
		<a class="button wc-backward <?php echo !empty( $this->props['button_empty_cart_icon'] ) ? 'button_empty_cart_icon' : ''; ?>"
			href="<?php echo esc_url( $this->props['empty_cart_button_url'] ); ?>"
			<?php echo !empty( $this->props['button_empty_cart_icon'] ) ? 'data-icon="'.esc_attr(et_pb_process_font_icon( $this->props['button_empty_cart_icon'] )).'"' : '' ?>
		>
			<?php
				echo esc_html( $this->props['empty_cart_button_text'] );
			?>
		</a>
	</p>
<?php endif; ?>
