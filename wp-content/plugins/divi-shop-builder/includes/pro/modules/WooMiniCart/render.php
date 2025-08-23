<?php
defined('ABSPATH') || die();

$shouldRenderContents = ($props['ajax_only'] ?? 'off') != 'on' || wp_doing_ajax();

if ($shouldRenderContents) {
	$cart = WC()->cart;
	$cartCount = empty($cart) ? 0 : $cart->get_cart_contents_count();
	if ($cartCount) {
		$cartContents = $cart->get_cart_contents();
	}
	$cartSubtotal = empty($cart) ? 0 : $cart->get_subtotal() + ($cart->display_prices_including_tax() ? $cart->get_subtotal_tax() : 0);
} else {
	$cartCount = 0;
}

if (!function_exists('dswcp_get_icon_classes')) {
	function dswcp_get_icon_classes($icon) {
		$classes = 'et-pb-icon';
		if (function_exists('et_pb_maybe_fa_font_icon') && et_pb_maybe_fa_font_icon($icon)) {
			$classes .= ' et-pb-fa-icon';
		}
		return $classes;
	}
}


?>
<a href="<?php if ($props['action_click'] == 'cartpage' || (isset($props['action_click_mobile']) && $props['action_click_mobile'] == 'cartpage')) echo(esc_url(wc_get_cart_url())); else echo('#'); ?>" title="<?php echo(esc_attr($props['label'])); ?>"  class="dswcp-cart-link<?php if (!$cartCount) { ?> dswcp-cart-empty<?php if (!$shouldRenderContents) { ?> dswcp-needs-update<?php } ?><?php } ?>">
	<?php if ($shouldRenderContents && $props['show_amount'] == 'on' && $props['amount_position'] == 'before') { ?>

    <?php  if($props['show_quantity_label'] === 'on' && $props['quantity_label_position'] == 'before' && ($cartCount || $props['show_count_zero'] === 'on')) {?>
        <span class="dswcp-count-label"><?php echo(esc_attr(str_replace('%d', $cartCount, $props['count_title_plural']))); ?></span>
    <?php } ?>

    <span class="dswcp-amount">
        <?php echo(et_core_intentionally_unescaped(wc_price($cartSubtotal), 'html')); ?>
	</span>
	<?php } ?>

    <span class="dswcp-cart-icon-wrapper">

        <span class="dswcp-mini-cart-icon dswcp-cart-icon icon-cart_icon_<?php echo((int)($props['icon']))?>">
        </span>

        <span class="dswcp-label">
            <?php echo(esc_attr($props['label'])); ?>
        </span>
        <?php if ($shouldRenderContents && $props['show_count'] === 'on' && ($cartCount || $props['show_count_zero'] === 'on')) { ?>
            <span class="dswcp-count" title="<?php echo(esc_attr(str_replace('%d', $cartCount, $props['count_title_plural']))); ?>">
                <?php echo((float) $cartCount); ?>
            </span>
            <?php
         } ?>
    </span>

    <?php  if($shouldRenderContents && $props['show_quantity_label'] === 'on' && $props['quantity_label_position'] == 'after' && ($cartCount || $props['show_count_zero'] === 'on')) {?>
    <span class="dswcp-count-label"><?php echo(esc_attr(str_replace('%d', $cartCount, $props['count_title_plural']))); ?></span>
    <?php } ?>

		
	<?php if ($shouldRenderContents && $props['show_amount'] == 'on' && $props['amount_position'] == 'after') { ?>
	<span class="dswcp-amount">
		<?php echo(et_core_intentionally_unescaped(wc_price($cartSubtotal), 'html')); ?>
	</span>
	<?php } ?>
	
</a>

<?php if ($props['action_hover'] == 'dropdowncart' || $props['action_click'] == 'dropdowncart') { ?>

<div class="dswcp-dropdown-cart-container">
<div class="dswcp-dropdown-cart">
    <div class="dswcp-dropdown-cart-header">
        <?php if ($props['display_cart_title'] === 'on') { ?>
            <h2><?php echo(esc_attr($props['cart_title'])); ?></h2>
        <?php } ?>
	    <?php if ($props['action_click'] === 'dropdowncart') { ?>
		<button class="dswcp-close <?php echo(esc_attr(dswcp_get_icon_classes($props['close_icon']))); ?>" title="<?php echo(esc_attr($props['close_title'])); ?>">
			<?php echo(esc_html(et_pb_process_font_icon($props['close_icon']))); ?>
		</button>
	    <?php } ?>
    </div>
	<?php if ($cartCount) { ?>
	<div class="dswcp-dropdown-cart-items">
		<?php foreach ($cartContents as $cartItem) { ?>
		
		<div class="dswcp-dropdown-cart-item" data-cart-item-key="<?php echo(esc_attr($cartItem['key'])); ?>">
			<div>
				<button class="dswcp-remove <?php echo(esc_attr(dswcp_get_icon_classes($props['remove_icon']))); ?>" title="<?php echo(esc_attr($props['remove_title'])); ?>">
					<?php echo(esc_html(et_pb_process_font_icon($props['remove_icon']))); ?>
				</button>
			</div>
			<?php if ($props['show_images'] == 'on') { ?>
                    <div class="dswcp-image-container">
                <?php echo(et_core_intentionally_unescaped($cartItem['data']->get_image(), 'html')); ?>
                    </div>
           <?php } ?>
			<div>
				<h3 class="dswcp-product-name">
					<a href="<?php echo(esc_url($cartItem['data']->get_permalink())); ?>">
						<?php echo(esc_html($cartItem['data']->get_title())); ?>
						<?php if ($props['show_product_quantity'] === 'after_title') { ?>
                            <span class="dswcp-product-quantity"> &times; <?php echo((float)$cartItem['quantity']); ?></span>
						<?php } ?>
					</a>
				</h3>
				<div>
						<span class="dswcp-product-price"><?php echo(et_core_intentionally_unescaped($cart->get_product_price($cartItem['data']), 'html')); ?></span>
					    <?php if ($props['show_product_quantity'] === 'after_price') { ?>
                            <span class="dswcp-quantity"> &times; <?php echo((float) $cartItem['quantity']); ?>  </span>
                        <?php } ?>

                        <?php if ($props['show_product_subtotal'] == 'on' && $cartItem['quantity'] > 1) { ?>
                            <div class="dswcp-item-subtotal" >
                                <span class="dswcp-subtotal-text"><?php echo(esc_html($props['product_subtotal_text'])); ?></span>
                                <span class="dswcp-subtotal-value"><?php echo(et_core_intentionally_unescaped($cart->get_product_subtotal( $cartItem['data'], $cartItem['quantity'] ), 'html')); ?></span>
                            </div>
                        <?php } ?>

				</div>
			</div>
		</div>
		<?php } ?>
	</div>
	<?php } else { ?>
	<div class="dswcp-dropdown-cart-empty dswcp-cart-empty">
        <?php if ($props['show_empty_icon'] === 'on') { ?>
		    <div class="dswcp-cart-empty-icon <?php echo(esc_attr(dswcp_get_icon_classes($props['empty_icon']))); ?>"><?php echo(esc_html(et_pb_process_font_icon($props['empty_icon']))); ?></div>
        <?php } else { ?>
            <span class="dswcp-cart-empty-icon dswcp-cart-icon icon-cart_icon_<?php echo((int)($props['empty_custom_icon']))?>"></span>
        <?php }  ?>
		<p><?php echo(esc_html($props['empty_text'])); ?></p>
	</div>
	<?php } ?>
	<div class="dswcp-dropdown-cart-footer">
		<?php if ($cartCount) { ?>
		<div class="dswcp-subtotal">
			<label class="dswcp-subtotal-text"><?php echo(esc_html($props['subtotal_text'])); ?></label>
			<span class="dswcp-subtotal-value"><?php echo(et_core_intentionally_unescaped(wc_price($cartSubtotal), 'html')); ?></span>
		</div>
		<?php if ($props['footer_info_text']) { ?><p class="dswcp-info"><?php echo(esc_html($props['footer_info_text'])); ?></p><?php } ?>
		<?php } ?>
		<div class="dswcp-buttons">
			<?php if ($cartCount) { ?>
				<a href="<?php echo(esc_url(wc_get_cart_url())); ?>" class="dswcp-btn-cart et_pb_button"><?php echo(esc_html($props['cart_btn_text'])); ?></a>
				<a href="<?php echo(esc_url(wc_get_checkout_url())); ?>" class="dswcp-btn-checkout et_pb_button"><?php echo(esc_html($props['checkout_btn_text'])); ?></a>
			<?php } else { ?>
				<a href="<?php echo(esc_url(wc_get_page_permalink('shop'))); ?>" class="dswcp-btn-shop et_pb_button"><?php echo(esc_html($props['shop_btn_text'])); ?></a>
			<?php } ?>
		</div>
	</div>
</div>
</div>

<?php } ?>

<?php if ($props['action_click'] == 'sidecart') { ?>

<div id="<?php echo(esc_attr($sideCartId)); ?>" class="dswcp-side-cart <?php echo(esc_attr(substr($sideCartId, 0, -11))); ?>">
	<div class="dswcp-side-cart-header">
		<?php if ($props['display_cart_title'] === 'on') { ?>
            <h2><?php echo(esc_html($props['cart_title'])); ?></h2>
        <?php } ?>
		<button class="dswcp-close <?php echo(esc_attr(dswcp_get_icon_classes($props['close_icon']))); ?>" title="<?php echo(esc_attr($props['close_title'])); ?>">
			<?php echo(esc_html(et_pb_process_font_icon($props['close_icon']))); ?>
		</button>
	</div>
	<?php if ($cartCount) { ?>
	<div class="dswcp-side-cart-items">
	
		<?php foreach ($cartContents as $cartItem) { ?>
		
		<div class="dswcp-side-cart-item" data-cart-item-key="<?php echo(esc_attr($cartItem['key'])); ?>">
			<div>
				<button class="dswcp-remove <?php echo(esc_attr(dswcp_get_icon_classes($props['remove_icon']))); ?>" title="<?php echo(esc_attr($props['remove_title'])); ?>">
					<?php echo(esc_html(et_pb_process_font_icon($props['remove_icon']))); ?>
				</button>
			</div>
			<?php if ($props['show_images'] == 'on') { ?>
                <div class="dswcp-image-container">
					 <?php echo(et_core_intentionally_unescaped($cartItem['data']->get_image(), 'html')); ?>
                </div>
			<?php } ?>
			<div class="dswcp-item-main">
				<h3 class="dswcp-product-name">
					<a href="<?php echo(esc_url($cartItem['data']->get_permalink())); ?>">
						<?php echo(esc_html($cartItem['data']->get_title())); ?>
					</a>
					<?php if ($props['show_product_quantity'] === 'after_title') { ?>
                        <span class="dswcp-product-quantity">&times; <?php echo((float)$cartItem['quantity']); ?></span>
					<?php } ?>
				</h3>
				<div class="dswcp-product-price">
					<span><?php echo(et_core_intentionally_unescaped($cart->get_product_price($cartItem['data']), 'html')); ?></span>
                    <?php if ($props['show_product_quantity'] === 'after_price') { ?>
					    <span class="dswcp-product-quantity">&times; <?php echo((float)$cartItem['quantity']); ?></span>
                     <?php } ?>
				</div>
				<?php if ($props['show_product_subtotal'] == 'on' && $cartItem['quantity'] > 1) { ?>
                    <div class="dswcp-item-subtotal" >
						<span class="dswcp-subtotal-text"><?php echo(esc_html($props['product_subtotal_text'])); ?></span>
						<span class="dswcp-subtotal-value"><?php echo(et_core_intentionally_unescaped($cart->get_product_subtotal( $cartItem['data'], $cartItem['quantity'] ), 'html')); ?></span>
                    </div>
				<?php } ?>
			</div>

            <div>
				<?php if ($props['show_quantity'] == 'on') { ?>
                    <label class="dswcp-quantity-label">
                        <span><?php echo(esc_html($props['quantity_label'])); ?></span>
                        <input class="dswcp-quantity" type="number" value="<?php echo((float) $cartItem['quantity']); ?>">
                    </label>
				<?php } ?>
            </div>
		</div>
		<?php } ?>
	</div>
	<?php } else { ?>
	
	<div class="dswcp-side-cart-empty dswcp-cart-empty">
		<?php if ($props['show_empty_icon'] === 'on') { ?>
            <div class="dswcp-cart-empty-icon <?php echo(esc_attr(dswcp_get_icon_classes($props['empty_icon']))); ?>"><?php echo(esc_html(et_pb_process_font_icon($props['empty_icon']))); ?></div>
		<?php } else { ?>
            <span class="dswcp-cart-empty-icon dswcp-cart-icon icon-cart_icon_<?php echo((int)($props['empty_custom_icon']))?>"></span>
		<?php }  ?>
        <p><?php echo(esc_html($props['empty_text'])); ?></p>
	</div>
	
	<?php } ?>
	<div class="dswcp-side-cart-footer">
		<?php if ($cartCount) { ?>
		<div class="dswcp-subtotal">
			<label class="dswcp-subtotal-text"><?php echo(esc_html($props['subtotal_text'])); ?></label>
			<span class="dswcp-subtotal-value"><?php echo(et_core_intentionally_unescaped(wc_price($cartSubtotal), 'html')); ?></span>
		</div>
		<?php if ($props['footer_info_text']) { ?><p class="dswcp-info"><?php echo(esc_html($props['footer_info_text'])); ?></p><?php } ?>
		<?php } ?>
		<div class="dswcp-buttons">
			<?php if ($cartCount) { ?>
				<a href="<?php echo(esc_url(wc_get_cart_url())); ?>" class="dswcp-btn-cart et_pb_button"><?php echo(esc_html($props['cart_btn_text'])); ?></a>
				<a href="<?php echo(esc_url(wc_get_checkout_url())); ?>" class="dswcp-btn-checkout et_pb_button"><?php echo(esc_html($props['checkout_btn_text'])); ?></a>
			<?php } else { ?>
				<a href="<?php echo(esc_url(wc_get_page_permalink('shop'))); ?>" class="dswcp-btn-shop et_pb_button"><?php echo(esc_html($props['shop_btn_text'])); ?></a>
			<?php } ?>
		</div>
	</div>
</div>

<?php if (!empty($sideCartId)) { ?>
<script>document.body.appendChild(document.getElementById("<?php echo(esc_html($sideCartId)); ?>"));</script>
<?php } ?>

<?php } ?>