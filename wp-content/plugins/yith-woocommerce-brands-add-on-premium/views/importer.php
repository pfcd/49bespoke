<?php
/**
 * Brands CSV Importer template
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Brands\Views
 * @version 2.0
 */

if ( ! defined( 'YITH_WCBR' ) ) {
	exit;
} // Exit if accessed directly.

$delimiter_field = array(
	'id'          => 'delimiter',
	'name'        => 'delimiter',
	'title'       => __( 'Delimiter', 'yith-woocommerce-brands-add-on' ),
	'description' => __( 'Choose the delimiter type.', 'yith-woocommerce-brands-add-on' ),
	'type'        => 'text',
	'class'       => 'ywcbr-import-delimiter',
	'value'       => ',',
);

?>

<div class="ywcbr-import-brands-container">
	<div class="ywcbr-import-brands-container-description">
		<p><?php esc_html_e( 'Upload a CSV file containing brands to import the contents into your shop.', 'yith-woocommerce-brands-add-on' ); ?>
			<a href="<?php echo esc_url( YITH_WCBR_ASSETS_URL . '/example.csv' ); ?>"><?php esc_html_e( 'Click here to download a sample CSV file.', 'yith-woocommerce-brands-add-on' ); ?></a>
		</p>
	</div>
	<table>
		<tbody>
			<tr valign="top" class="yith-ywcbr-import-button-row">
				<th scope="row" class="titledesc">
					<label><?php esc_html_e( 'Import brands', 'yith-woocommerce-brands-add-on' ); ?></label>
				</th>
				<td class="forminp forminp-upload">
					<button id="yith-ywcbr-import-button" class="yith-plugin-fw__button--secondary yith-plugin-fw__button--xl"><?php esc_html_e( 'Upload CSV file', 'yith-woocommerce-brands-add-on' ); ?></button>
					<span class="yith-ywcbr-file-name"></span>
					<input type="file" id="yith-ywcbr-import-csv" name="file_import_csv" style="display: none" accept=".csv">
					<span class="description"><?php esc_html_e( 'Import brands by uploading a CSV file.', 'yith-woocommerce-brands-add-on' ); ?></span>
				</td>
			</tr>
			<tr valign="top" class="yith-plugin-fw-panel-wc-row <?php echo esc_attr( $delimiter_field['type'] ); ?>">
				<?php if ( isset( $delimiter_field['title'] ) ) : ?>
					<th scope="row" class="titledesc">
						<label for="<?php echo esc_attr( $delimiter_field['name'] ); ?>"><?php echo esc_html( $delimiter_field['title'] ); ?></label>
					</th>
				<?php endif; ?>
				<td class="forminp forminp-<?php echo esc_attr( $delimiter_field['type'] ); ?>">
					<?php yith_plugin_fw_get_field( $delimiter_field, true ); ?>
					<?php if ( isset( $delimiter_field['description'] ) ) : ?>
						<span class="description"><?php echo wp_kses_post( $delimiter_field['description'] ); ?></span>
					<?php endif; ?>
				</td>
			</tr>
		</tbody>
	</table>
	<input type="hidden" class="ywcbr-safe-submit-field" name="ywcbr_safe_submit_field" value="" data-std="">
	<button class="yith-plugin-fw__button--primary ywcbr-import-brands"><?php esc_html_e( 'Import brands', 'yith-woocommerce-brands-add-on' ); ?></button>
</div>
