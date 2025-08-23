<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>

	<div class="dnwoo-mini-cart-item">
		<ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">
			<?php
			do_action( 'woocommerce_before_mini_cart_contents' );

			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
					$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
						<?php
						echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							'woocommerce_cart_item_remove_link',
							sprintf(
								'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								esc_attr__( 'Remove this item', 'dnwooe' ),
								esc_attr( $product_id ),
								esc_attr( $cart_item_key ),
								esc_attr( $_product->get_sku() )
							),
							$cart_item_key
						);
						?>
						<?php if ( empty( $product_permalink ) ) : ?>
							<?php echo $thumbnail . wp_kses_post( $product_name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php else : ?>
							<a href="<?php echo esc_url( $product_permalink ); ?>">
								<?php echo $thumbnail . wp_kses_post( $product_name ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</a>
						<?php endif; ?>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</li>
					<?php
				}
			}

			do_action( 'woocommerce_mini_cart_contents' );
			?>
		</ul>
	</div>
	<div class="dnwoo-mini-cart-footer">
	<p class="woocommerce-mini-cart__total total">
		<?php
		/**
		 * Hook: woocommerce_widget_shopping_cart_total.
		 *
		 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
		 */
		do_action( 'woocommerce_widget_shopping_cart_total' );
		?>
	</p>
		<?php 
 			$show_coupon_box = get_option('dnwooe_show_coupon_code', '');

			if ( '1' == $show_coupon_box ) : ?>
		<div class="dnwooe-mini-cart-coupon-box">
			<div class="coupon-wrapper">
				<div class="show-coupon cart-header" for="minicart-coupon">
					<?php $coupon_code_text = get_option('dnwoo_coupon_code_text', __('Coupon Code', 'dnwooe')); esc_html_e( $coupon_code_text ); 
					
					?>
				</div>
					<div class="coupon-from-wrapper">
						<input id="minicart-coupon" class="input-text minicart-coupon-field" type="text" name="coupon_code" placeholder="<?php $placeholder_text = get_option('dnwoo_coupon_placeholder_text', __('Enter Coupon Code', 'dnwooe')); esc_html_e( $placeholder_text ); ?>"/>
						<button type="submit" id="minicart-apply-button" name="apply_coupon" value="<?php $apply_btn_text = get_option('dnwoo_apply_button_text', __('Apply', 'dnwooe')); esc_html_e( $apply_btn_text ); ?>"><?php $apply_btn_text = get_option('dnwoo_apply_button_text', __('Apply', 'dnwooe')); esc_html_e( $apply_btn_text ); ?></button>
					</div>
			</div>

			<div id="coupon-messeage"></div>
			<div id="remove-message"></div>
			<div class="fees-item">
				<?php 
					$applied_coupons = WC()->cart->get_applied_coupons(); 
					if ( ! empty( $applied_coupons ) ) : 
				?>
				<div id="widget-shopping-cart-remove-coupon" class="quicker-coupon mini_cart_coupon">

					<div class="dnwooe-coupon-label">
						<label><?php $discount_text = get_option('dnwoo_discount_text', __('Discount', 'dnwooe')); esc_html_e( $discount_text ); ?></label>
					</div>
					<div class="applied_coupon_code">
						<?php foreach ( $applied_coupons as $code ) : ?>
							<span data-code="<?php echo esc_attr( $code ); ?>" id="remove-coupon"><?php echo esc_html( $code .' x'); ?></span>
						<?php endforeach; ?>
						<span class="discount-symbol"><?php echo esc_html('-'); ?></span>
						<span class="discount-price"><?php echo wp_kses_post(wc_price(WC()->cart->get_cart_discount_total() + WC()->cart->get_cart_discount_tax_total())); ?></span>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>
		<?php 
 			$show_shipping_fee = get_option('dnwooe_show_shipping_fee', '');

			if ( '1' === $show_shipping_fee  ) : ?>
		<div class="dnwooe-shipping-fee">
			<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>

			<?php $shipping_fee = get_option('dnwoo_shipping_fee_text', __('Shipping Fee ', 'dnwooe')); esc_html_e( $shipping_fee ); echo wp_kses_post(WC()->cart->get_cart_shipping_total()); ?>

			<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>
		</div>
		<?php endif; ?>
		<?php 
 			$show_tax_fee = get_option('dnwooe_show_tax_fee', '');
			if ( '1' === $show_tax_fee  ) : 
		?>
			<div class="dnwooe-tax-fee">
			<label><?php 
			$tax_fee = get_option('dnwoo_tax_fee_text', __('Tax', 'dnwooe')); esc_html_e( $tax_fee ); ?></label> 
			<?php echo wp_kses_post(WC()->cart->get_cart_tax()); ?>
			</div>
		<?php endif; ?>
		<?php 
 			$show_total_price = get_option('dnwooe_show_total_price', '');
			if ('1' ===  $show_total_price  ) : 
		?>
			<div class="dnwooe-order-total">
				<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>
				
					<label><?php $total_price = get_option('dnwoo_total_price_text', __('Total', 'dnwooe')); esc_html_e( $total_price ); ?></label>
					<span data-title="<?php esc_attr_e( 'Total', 'dnwooe' ); ?>"><?php wc_cart_totals_order_total_html(); ?></span>
				
				<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>
			</div>
		<?php endif; ?>
		
	
	
	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<p class="woocommerce-mini-cart__buttons buttons"><?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?></p>

	<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>
	</div>
<?php else : ?>
	
	<p class="woocommerce-mini-cart__empty-message"><?php $emptycart_text = get_option('dnwoo_empty_cart_text', __('No products in the cart.', 'dnwooe')); esc_html_e( $emptycart_text ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
