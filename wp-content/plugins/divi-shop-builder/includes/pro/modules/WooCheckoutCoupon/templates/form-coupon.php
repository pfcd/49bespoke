<?php

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) {
	return;
}

$props 		= $this->props;
$multi_view = et_pb_multi_view_options( $this );

?>

<div class="woocommerce-form-coupon-toggle"
	<?php echo et_core_intentionally_unescaped($multi_view->render_attrs( array( 'visibility' => array( "coupon_toggle_model" => 'on' ) ) ), 'html'); ?>
>
	<?php
		wc_print_notice(
			apply_filters(
				'woocommerce_checkout_coupon_message',
				sprintf(
					'<span %1$s>%2$s </span><a href="#" class="showcoupon" %3$s>%4$s</a>',
					$multi_view->render_attrs( array( 'content' => '{{coupon_toggle_title}}' ) ),
					$props['coupon_toggle_title'],
					$multi_view->render_attrs( array( 'content' => '{{coupon_toggle_text}}' ) ),
					$props['coupon_toggle_text']
				)
			),
			'notice'
		);
	?>
</div>

<form class="checkout_coupon woocommerce-form-coupon" method="post"
	<?php echo $props['coupon_toggle_model'] === 'on' ? 'style="display:none"' : ''; ?> >

	<p <?php echo et_core_intentionally_unescaped($multi_view->render_attrs( array( 'content' => '{{coupon_content_text}}' ) ), 'html') ?>><?php echo esc_html( $props['coupon_content_text'] ); ?></p>

	<p class="form-row form-row-first">
		<input type="text" name="coupon_code" class="input-text" placeholder="<?php echo esc_attr( $props['coupon_input_placeholder'] ); ?>" id="coupon_code" value=""
		<?php echo et_core_intentionally_unescaped($multi_view->render_attrs( array( 'attrs' => array( 'placeholder' => '{{coupon_input_placeholder}}' ) ) ), 'html'); ?>
		/>
	</p>

	<p class="form-row form-row-last">
		<button type="submit" class="button <?php echo !empty( $this->props['apply_coupon_button_icon'] ) ? 'et_pb_custom_button_icon' : ''; ?>" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"
			<?php echo et_core_intentionally_unescaped($multi_view->render_attrs( array( 'content' => '{{coupon_button_text}}' ) ), 'html') ?>
			<?php echo !empty( $this->props['apply_coupon_button_icon'] ) ? 'data-icon="'.esc_attr(et_pb_process_font_icon( $this->props['apply_coupon_button_icon'] )).'"' : '' ?>
		>
			<?php echo esc_html( $props['coupon_button_text'] ); ?>
		</button>
	</p>

	<div class="clear"></div>
</form>