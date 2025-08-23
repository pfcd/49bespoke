<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"
    class="checkout-button button alt wc-forward <?php echo !empty( $this->props['button_checkout_icon'] ) ? 'et_pb_custom_button_icon' : ''; ?>"
    <?php echo et_core_intentionally_unescaped($multi_view->render_attrs( array( 'content' => '{{checkout_button_text}}' ) ), 'html'); ?>
    <?php echo !empty( $this->props['button_checkout_icon'] ) ? 'data-icon="'.esc_attr(et_pb_process_font_icon( $this->props['button_checkout_icon'] )).'"' : '' ?>
>
    <?php echo esc_html( $this->props['checkout_button_text'] ); ?>
</a>