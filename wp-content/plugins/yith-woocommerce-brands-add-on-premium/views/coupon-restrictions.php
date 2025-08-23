<?php
/**
 * Coupon edit form.
 *
 * @author  YITH <plugins@yithemes.com>
 *
 * @package YITH\Brands\Views
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly

?>

<div class="options_group">
	<p class="form-field allowed_brands">
		<label for="allowed_brands"><?php esc_html_e( 'Product brands', 'yith-woocommerce-brands-add-on' ); ?></label>
		<select id="allowed_brands" name="allowed_brands[]" style="width: 50%;"  class="wc-enhanced-select" multiple="multiple" data-placeholder="<?php esc_attr_e( 'Any brand', 'yith-woocommerce-brands-add-on' ); ?>">
			<?php
			if ( ! empty( $brands ) ) :
				foreach ( $brands as $brand ) :
					echo '<option value="' . esc_attr( $brand->term_id ) . '"' . esc_html( wc_selected( $brand->term_id, $allowed_brands ) ) . '>' . esc_html( $brand->name ) . '</option>';
					endforeach;
				endif;
			?>
		</select> <?php echo wc_help_tip( __( 'Product brands that the coupon will be applied to, or that need to be in the cart in order for the "Fixed cart discount" to be applied.', 'yith-woocommerce-brands-add-on' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
	</p>
	<p class="form-field excluded_brands">
		<label><?php esc_html_e( 'Excluded brands', 'yith-woocommerce-brands-add-on' ); ?></label>
		<select id="excluded_brands" name="excluded_brands[]" style="width: 50%;"  class="wc-enhanced-select" multiple="multiple" data-placeholder="<?php esc_attr_e( 'No restrictions', 'yith-woocommerce-brands-add-on' ); ?>">
			<?php
			if ( ! empty( $brands ) ) :
				foreach ( $brands as $brand ) :
					echo '<option value="' . esc_attr( $brand->term_id ) . '"' . esc_html( wc_selected( $brand->term_id, $excluded_brands ) ) . '>' . esc_html( $brand->name ) . '</option>';
				endforeach;
			endif;
			?>
		</select> <?php echo wc_help_tip( __( 'Product brands that the coupon will not be applied to, or that cannot be in the cart in order for the "Fixed cart discount" to be applied.', 'yith-woocommerce-brands-add-on' ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
	</p>
</div>
