<?php
/**
 * The Template for displaying empty wishlist.
 *
 *
 * @version             2.5.2
 * @package           TInvWishlist\Template
 *
 * Contains code copied from and/or based on TI WooCommerce Wishlist
 * See the ../license.txt file in the root directory for more information and licenses
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<div class="tinv-wishlist woocommerce tinv-wishlist-clear">
	<?php do_action( 'tinvwl_before_wishlist', $wishlist ); ?>
	<?php if ( function_exists( 'wc_print_notices' ) && isset( WC()->session ) ) {
		wc_print_notices();
	} ?>

	<?php
	$image = function () {
		if (!empty(get_theme_mod('dsdep_empty_wishlist_image'))) {
			$img_path = get_theme_mod('dsdep_empty_wishlist_image');
		} else {
			$img_path = get_stylesheet_directory_uri() . '/images/wishlist.png';
		}
		echo esc_url($img_path);
	};
	?>
    <img src="<?php $image(); ?>" class="empty-wishlist-image"
         alt="<?php esc_html_e('Wishlist is currently empty.', 'divi-ecommerce-pro'); ?>">

    <p class="cart-empty">
		<?php if (get_current_user_id() === $wishlist['author']) { ?>
			<?php esc_html_e('Your Wishlist is currently empty.', 'divi-ecommerce-pro'); ?>
		<?php } else { ?>
			<?php esc_html_e('Wishlist is currently empty.', 'divi-ecommerce-pro'); ?>
		<?php } ?>
    </p>

	<?php do_action( 'tinvwl_wishlist_is_empty' ); ?>

    <p class="return-to-shop">
        <a class="button wc-backward dsdep-button-outline"
           href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"><?php echo esc_html( apply_filters( 'woocommerce_return_to_shop_text', __( 'Return To Shop', 'divi-ecommerce-pro' ) ) ); ?></a>
    </p>
</div>
