<?php
/**
 * Taxonomy edit form.
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

<tr class="form-field">
	<?php wp_nonce_field( 'product_brand_banner', 'product_brand_banner_nonce' ); ?>
	<?php
	/**
	 * APPLY_FILTERS: yith_wcbr_banner_label
	 *
	 * Filter the label for the field to select the brand banner.
	 *
	 * @param string $label Field label
	 *
	 * @return string
	 */
	?>
	<th scope="row" valign="top">
		<label><?php echo esc_html( apply_filters( 'yith_wcbr_banner_label', __( 'Banner', 'yith-woocommerce-brands-add-on' ) ) ); ?></label>
	</th>
	<td>
		<div id="product_brand_banner" style="float:left;margin-right:10px;">
			<img alt="<?php esc_html_e( 'Product brand banner', 'yith-woocommerce-brands-add-on' ); ?>" src="<?php echo esc_html( $banner ); ?>" width="60px" height="60px" />
		</div>
		<div style="line-height:60px;">
			<input type="hidden" id="product_brand_banner_id" class="yith_wcbr_upload_image_id" name="product_brand_banner_id" value="<?php echo esc_html( $banner_id ); ?>" />
			<button id="product_brand_banner_upload" type="submit" class="yith_wcbr_upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'yith-woocommerce-brands-add-on' ); ?></button>
			<button id="product_brand_banner_remove" type="submit" class="yith_wcbr_remove_image_button button"><?php esc_html_e( 'Remove image', 'yith-woocommerce-brands-add-on' ); ?></button>
		</div>
		<div class="clear"></div>
	</td>
</tr>
<tr class="form-field">
	<th scope="row" valign="top"><label><?php esc_html_e( 'Custom URL', 'yith-woocommerce-brands-add-on' ); ?></label></th>
	<td>
		<input type="text" id="product_brand_custom_url" name="product_brand_custom_url" value="<?php echo esc_html( $custom_url ); ?>" />
		<p class="description"><?php esc_html_e( 'Set a custom URL for the redirect. Default redirect is to the archive page.', 'yith-woocommerce-brands-add-on' ); ?></p>
		<div class="clear"></div>
	</td>
</tr>
