<?php
/**
 * Filed to specify image sizes.
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

<tr valign="top">
	<th scope="row">
		<label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_attr( $name ); ?></label>
	</th>
	<td class="forminp forminp-image-size">
		<div class="image-size-container">
			<input type="number" id="<?php echo esc_attr( $id ); ?>_width" class="yith_wcbr_image_size_width" name="<?php echo esc_attr( $id ); ?>[width]" value="<?php echo esc_attr( $image_size['width'] ); ?>"  style="max-width: 53px;"/><span class="yith_wcbr_single_product_brands_item_align"><?php esc_html_e( 'x', 'yith-woocommerce-brands-add-on' ); ?></span>
			<input type="number" id="<?php echo esc_attr( $id ); ?>_height" class="yith_wcbr_image_size_height" name="<?php echo esc_attr( $id ); ?>[height]" value="<?php echo esc_attr( $image_size['height'] ); ?>" style="max-width: 53px;" /><span class="yith_wcbr_single_product_brands_item_align"><?php esc_html_e( 'px', 'yith-woocommerce-brands-add-on' ); ?></span>
			<input type="checkbox" id="<?php echo esc_attr( $id ); ?>_crop" class="yith_wcbr_image_size_crop" name="<?php echo esc_attr( $id ); ?>[crop]" value="1" <?php echo checked( isset( $image_size['crop'] ) && $image_size['crop'] ); ?> /><span class="yith_wcbr_single_product_brands_item_align"><?php esc_html_e( 'Hard crop?', 'yith-woocommerce-brands-add-on' ); ?></span>
		</div>
		<span class="description" style="margin-top:5px;">
			<?php echo wp_kses_post( $field['desc'] ); ?>
		</span>
		<?php if ( ! empty( $desc ) ) : ?>
			<span class="description"><?php echo esc_html( $desc ); ?></span>
		<?php endif; ?>
	</td>
</tr>
