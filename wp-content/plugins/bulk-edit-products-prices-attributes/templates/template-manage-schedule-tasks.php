<?php
/**
 *
 * Manage Scheduled Tasks.
 *
 * @package ELEX Bulk Edit Products, Prices & Attributes for Woocommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$upload_dir  = wp_upload_dir();
$base        = $upload_dir['basedir'];
$folder_path = $base . '/elex-bulk-edit-products/';
$files       = array();
global $wpdb;
$prefix = $wpdb->prefix;
if ( file_exists( $folder_path ) ) {
	$files = array_diff( scandir( $folder_path ), array( '..', '.' ) );
}
$dir_url = $upload_dir['baseurl'] . '/elex-bulk-edit-products/';
?>
<div class='wrap postbox table-box table-box-main' id="manage_schedule_tasks" style='padding:5px 20px;'>
	<h2>
		<?php esc_html_e( 'Scheduled Tasks ', 'eh_bulk_edit' ); ?>
	</h2>
	<table class='elex-bep-manage-schedule'>
		<tr>
			<th class='elex-bep-manage-schedule-left'>
				<?php esc_html_e( 'Name', 'eh_bulk_edit' ); ?>
			</th>
			<th class="elex-bep-manage-schedule-middle">
				<?php esc_html_e( 'Chosen Fields', 'eh_bulk_edit' ); ?>
			</th>
			<th class="elex-bep-manage-schedule-sch">
				<?php esc_html_e( 'Schedule (y-m-d)', 'eh_bulk_edit' ); ?>
			</th>
			<th class='elex-bep-manage-schedule-right'>
				<?php esc_html_e( 'Actions', 'eh_bulk_edit' ); ?>
			</th>
		</tr>
		<tr></tr>
		<?php
		$saved_jobs = wpFluent()->table('elex_bep_jobs')->select('*')->get();
		
		if ( ! empty( $saved_jobs ) ) {
			$saved_jobs = array_reverse( $saved_jobs );
			foreach ( $saved_jobs as $key => $val ) {
				$val = (array) $val;
				if ( isset( $val['job_name'] ) ) {
					$file_name = '';
					foreach ( $files as $file ) {
						if ( isset( $val['job_name'] ) && ( ( str_replace( ' ', '_', $val['job_name'] ) . '.txt' ) === $file ) ) {
							$file_name = $file;
							break;
						}
					}
					if ( '1' === $val['is_reversible']) {
						$revert_class = 'elex-bep-icon-revert';
						$rev_onclick  = $val['job_name'];
					} else {
						$revert_class = 'elex-bep-icon-revert';
						$revert_class = 'elex-bep-icon-revert-disable';
						$rev_onclick  = '';
					}
					if ( true == $val['create_log_file'] && ( ( ! isset( $val['schedule_opn'] ) ) || null === $val['schedule_opn'] ) ) {
						$log_class = 'elex-bep-icon-log';
					} else {
						$log_class = 'elex-bep-icon-log-disable';
					}
					if ( ( null != $val['schedule_on'] ) || ( null !=  $val['revert_on'] ) ) {
						$cancel_schedule = 'elex-bep-icon-cancel';
						$cancel_job_name = $val['job_name'];
					} else {
						$cancel_schedule = 'elex-bep-icon-cancel-disable';
						$cancel_job_name = '';
					}
					?>

					<tr id="<?php echo filter_var( $val['job_name'] ); ?>">
						<td>
							<?php echo filter_var( $val['job_name'] ); ?>
						</td>
						<td>
							<?php
							$val['param_to_save'] = maybe_unserialize($val['filter_data']);
							$chosen_fields        = '';
							if ( isset( $val['param_to_save']['custom_attribute_action'] ) && '' !== $val['param_to_save']['custom_attribute_action'] ) {
								$chosen_fields .= 'Custom Attribute, ';
							}
							if ( isset( $val['param_to_save']['vari_attribute'] ) && '' !== $val['param_to_save']['vari_attribute'] ) {
								$chosen_fields .= 'Interchange Global Attribute, ';
							}
							if ( isset( $val['param_to_save']['title_select'] ) && '' !== $val['param_to_save']['title_select'] ) {
								$chosen_fields .= 'Title, ';
							}
							if ( isset( $val['param_to_save']['tax_status_action'] ) && '' !== $val['param_to_save']['tax_status_action'] ) {
								$chosen_fields .= 'Tax Status, ';
							}
							if ( isset( $val['param_to_save']['tax_class_action'] ) && '' !== $val['param_to_save']['tax_class_action'] ) {
								$chosen_fields .= 'Tax Class, ';
							}
							if ( isset( $val['param_to_save']['sku_select'] ) && '' !== $val['param_to_save']['sku_select'] ) {
								$chosen_fields .= 'SKU, ';
							}
							if ( isset( $val['param_to_save']['catalog_select'] ) && '' !== $val['param_to_save']['catalog_select'] ) {
								$chosen_fields .= 'Product Visiblity, ';
							}
							if ( isset( $val['param_to_save']['is_product_type'] ) && '' !== $val['param_to_save']['is_product_type'] ) {
								$chosen_fields .= 'Product Type, ';
							}
							if ( isset( $val['param_to_save']['description_action'] ) && '' !== $val['param_to_save']['description_action'] ) {
								$chosen_fields .= 'Description, ';
							}
							if ( isset( $val['param_to_save']['short_description_action'] ) && '' !== $val['param_to_save']['short_description_action'] ) {
								$chosen_fields .= 'Short Description, ';
							}
							if ( isset( $val['param_to_save']['main_image'] ) && '' !== $val['param_to_save']['main_image'] ) {
								$chosen_fields .= 'Main Image, ';
							}
							if ( isset( $val['param_to_save']['gallery_images_action'] ) && '' !== $val['param_to_save']['gallery_images_action'] ) {
								$chosen_fields .= 'Gallery Images, ';
							}
							if ( isset( $val['param_to_save']['is_featured'] ) && '' !== $val['param_to_save']['is_featured'] ) {
								$chosen_fields .= 'Featured, ';
							}
							if ( isset( $val['param_to_save']['product_visibility_action'] ) && '' !== $val['param_to_save']['product_visibility_action'] ) {
								$chosen_fields .= 'Product Visibility Status, ';
							}
							if ( isset( $val['param_to_save']['shipping_select'] ) && '' !== $val['param_to_save']['shipping_select'] ) {
								$chosen_fields .= 'Shipping Class, ';
							}
							if ( isset( $val['param_to_save']['regular_select'] ) && '' !== $val['param_to_save']['regular_select'] ) {
								$chosen_fields .= 'Regular Price, ';
							}
							if ( isset( $val['param_to_save']['sale_select'] ) && '' !== $val['param_to_save']['sale_select'] ) {
								$chosen_fields .= 'Sale Price, ';
							}
							// Schedule Sale Price Customization.
							if ( isset( $val['param_to_save']['schedule_sale_price'] ) && 'false' !== $val['param_to_save']['schedule_sale_price'] ) {
								$chosen_fields .= 'Schedule Sale Price Action, ';
							}
							// Cancel Schedule Sale Price.
							if ( isset( $val['param_to_save']['cancel_schedule_sale_price'] ) && 'false' !== $val['param_to_save']['cancel_schedule_sale_price'] ) {
								$chosen_fields .= 'Cancel Schedule Sale Price Action, ';
							}
							if ( isset( $val['param_to_save']['stock_manage_select'] ) && '' !== $val['param_to_save']['stock_manage_select'] ) {
								$chosen_fields .= 'Manage Stock, ';
							}
							if ( isset( $val['param_to_save']['quantity_select'] ) && '' !== $val['param_to_save']['quantity_select'] ) {
								$chosen_fields .= 'Stock Quantity, ';
							}
							if ( isset( $val['param_to_save']['backorder_select'] ) && '' !== $val['param_to_save']['backorder_select'] ) {
								$chosen_fields .= 'Allow Backorders, ';
							}
							if ( isset( $val['param_to_save']['stock_status_select'] ) && '' !== $val['param_to_save']['stock_status_select'] ) {
								$chosen_fields .= 'Stock Status, ';
							}
							if ( isset( $val['param_to_save']['length_select'] ) && '' !== $val['param_to_save']['length_select'] ) {
								$chosen_fields .= 'Length, ';
							}
							if ( isset( $val['param_to_save']['width_select'] ) && '' !== $val['param_to_save']['width_select'] ) {
								$chosen_fields .= 'Width, ';
							}
							if ( isset( $val['param_to_save']['height_select'] ) && '' !== $val['param_to_save']['height_select'] ) {
								$chosen_fields .= 'Height, ';
							}
							if ( isset( $val['param_to_save']['weight_select'] ) && '' !== $val['param_to_save']['weight_select'] ) {
								$chosen_fields .= 'Weight, ';
							}
							if ( isset( $val['param_to_save']['attribute_action'] ) && '' !== $val['param_to_save']['attribute_action'] ) {
								$chosen_fields .= 'Attribute Actions, ';
							}
							if ( isset( $val['param_to_save']['create_variations'] ) && 'true' == $val['param_to_save']['create_variations'] ) {
								$chosen_fields .= 'Create Variation Action, ';
							}
							if ( isset( $val['param_to_save']['tag_action'] ) && '' !== $val['param_to_save']['tag_action'] ) {
								$chosen_fields .= 'Tag, ';
							}
							if ( isset( $val['param_to_save']['category_update_option'] ) && 'cat_none' !== $val['param_to_save']['category_update_option'] ) {
								$chosen_fields .= 'Category Actions, ';
							}
							if ( isset( $val['param_to_save']['delete_product_action'] ) && '' !== $val['param_to_save']['delete_product_action'] ) {
								$chosen_fields .= 'Delete Actions, ';
							}
							//Bundle product
							if ( isset( $val['param_to_save']['bundle_layout'] ) && '' !== $val['param_to_save']['bundle_layout'] ) {
								$chosen_fields .= 'Bundle Layout Actions, ';
							}
							if ( isset( $val['param_to_save']['bundle_from_location'] ) && '' !== $val['param_to_save']['bundle_from_location'] ) {
								$chosen_fields .= 'Bundle Form Location Actions, ';
							}
							if ( isset( $val['param_to_save']['bundle_item_grouping'] ) && '' !== $val['param_to_save']['bundle_item_grouping'] ) {
								$chosen_fields .= 'Bundle Item Grouping Actions, ';
							}
							if ( isset( $val['param_to_save']['bundle_min_size'] ) && '' !== $val['param_to_save']['bundle_min_size'] ) {
								$chosen_fields .= 'Bundle Mininum Size, ';
							}
							if ( isset( $val['param_to_save']['bundle_max_size'] ) && '' !== $val['param_to_save']['bundle_max_size'] ) {
								$chosen_fields .= 'Bundle Maximum Size, ';
							}
							if ( isset( $val['param_to_save']['bundle_edit_cart'] ) && '' !== $val['param_to_save']['bundle_edit_cart'] ) {
								$chosen_fields .= 'Bundle Edit Cart, ';
							}
							if ( isset( $val['param_to_save']['bundle_min_qty'] ) && '' !== $val['param_to_save']['bundle_min_qty'] ) {
								$chosen_fields .= 'Bundle Minimum Quantity, ';
							}
							if ( isset( $val['param_to_save']['bundle_max_qty'] ) && '' !== $val['param_to_save']['bundle_max_qty'] ) {
								$chosen_fields .= 'Bundle Maximum Quantity, ';
							}
							if ( isset( $val['param_to_save']['bundle_default_qty'] ) && '' !== $val['param_to_save']['bundle_default_qty'] ) {
								$chosen_fields .= 'Bundle Default Quantity, ';
							}
							if ( isset( $val['param_to_save']['bundle_optional'] ) && '' !== $val['param_to_save']['bundle_optional'] ) {
								$chosen_fields .= 'Bundle Optional, ';
							}

							if ( isset( $val['param_to_save']['bundle_ship_indi'] ) && '' !== $val['param_to_save']['bundle_ship_indi'] ) {
								$chosen_fields .= 'Bundle Shipped Individually, ';
							}
							if ( isset( $val['param_to_save']['bundle_price_individual'] ) && 'false' !== $val['param_to_save']['bundle_price_individual'] ) {
								$chosen_fields .= 'Bundle Priced Individually, ';
							}
							if ( isset( $val['param_to_save']['elex_bundle_discount'] ) && '' !== $val['param_to_save']['elex_bundle_discount'] ) {
								$chosen_fields .= 'Bundle Discount, ';
							}
							if ( isset( $val['param_to_save']['bundle_product_details'] ) && '' !== $val['param_to_save']['bundle_product_details'] ) {
								$chosen_fields .= 'Bundle Product Details, ';
							}
							if ( isset( $val['param_to_save']['bundle_override_title'] ) && '' !== $val['param_to_save']['bundle_override_title'] ) {
								$chosen_fields .= 'Bundle Override Title, ';
							}
							if ( isset( $val['param_to_save']['bundle_override_short_desc'] ) && '' !== $val['param_to_save']['bundle_override_short_desc'] ) {
								$chosen_fields .= 'Bundle Override Short Description, ';
							}
							if ( isset( $val['param_to_save']['bundle_hidetumb'] ) && '' !== $val['param_to_save']['bundle_hidetumb'] ) {
								$chosen_fields .= 'Bundle Hide Thumbnail, ';
							}
							if ( isset( $val['param_to_save']['bundle_cart_checkout'] ) && '' !== $val['param_to_save']['bundle_cart_checkout'] ) {
								$chosen_fields .= 'Bundle Cart/checkout, ';
							}
							if ( isset( $val['param_to_save']['bundle_order_details'] ) && '' !== $val['param_to_save']['bundle_order_details'] ) {
								$chosen_fields .= 'Bundle Order details, ';
							}
							if ( isset( $val['param_to_save']['meta_fields'] ) && is_array( $val['param_to_save']['meta_fields'] ) ) {
								foreach ( $val['param_to_save']['meta_fields'] as $index => $meta ) {
									if ( '' !== $val['param_to_save']['custom_meta'][ $index ] ) {
										$chosen_fields .= $meta . ', ';
									}
								}
							}
							$chosen_fields = substr( $chosen_fields, 0, -2 );
							echo filter_var( $chosen_fields );
							?>
						</td>
						<td>
							<?php
							$schedule_details = '';
							if ( ! empty( $val['schedule_on'] ) ) {
								$schedule_details .= esc_html('Scheduled time: ', 'eh_bulk_edit' ) . $val['schedule_on'] ;
								if ( ! empty( $val['revert_on'] ) ) {
									$schedule_details .= sprintf( wp_kses_post( '%sRevert time:  ', 'eh_bulk_edit' ), '<br>' ) . $val['revert_on'];
								}
								echo filter_var( $schedule_details );
							}
							?>
						</td>
						<td>
							<span class="elex-bep-icon-edit"  title="Edit" onclick="elex_bep_edit_copy_job('<?php echo filter_var( htmlspecialchars( $val['job_name'] ) ); ?>','edit')"  style="display: inline-block;"></span>
							<span class="elex-bep-icon-copy"  title="Copy" onclick="elex_bep_edit_copy_job('<?php echo filter_var( htmlspecialchars( $val['job_name'] ) ); ?>','copy')"  style="display: inline-block;"></span>
							<span class="elex-bep-icon-run"  title="Run Now" onclick="elex_bep_run_now('<?php echo filter_var( htmlspecialchars( $val['job_name'] ) ); ?>')"  style="display: inline-block; margin: 0px 2px 1px;"></span>
							<?php
							if ( 'elex-bep-icon-revert-disable' === $revert_class && '' === $rev_onclick ) {
								?>
									<span class="<?php echo filter_var( $revert_class ); ?>"  title="Revert Now"  style="display: inline-block; margin: 0px 2px 1px;"></span>
								<?php
							} else {
								?>
									<span class="<?php echo filter_var( $revert_class ); ?>"  title="Revert Now" onclick="elex_bep_revert_now('<?php echo filter_var( htmlspecialchars( $rev_onclick ) ); ?>')"  style="display: inline-block; margin: 0px 2px 1px;"></span>
								<?php
							}
							?>
							<span class="elex-bep-icon-delete"  title="Delete" onclick="elex_bep_delete_job('<?php echo filter_var( htmlspecialchars( $val['job_name'] ) ); ?>')"  style="display: inline-block; margin: 0px 2px 1px;"></span>
							<span class="<?php echo filter_var( $cancel_schedule ); ?>"  title="Cancel Schedule" onclick="elex_bep_cancel_job('<?php echo filter_var( htmlspecialchars( $cancel_job_name ) ); ?>')" style="display: inline-block; margin: 0px 2px 1px;"></span>
							<a href="<?php echo esc_url_raw($dir_url . $file_name); ?>" download="<?php echo esc_attr($file_name); ?>" id="<?php echo esc_attr($file_name); ?>" style="display: none;"></a>
							<span class="<?php echo esc_attr($log_class); ?>" title="Log File" onclick="downloadFile('<?php echo esc_js($file_name); ?>');" style="display: inline-block; margin: 2px 3px 1px;"></span>
							<!--function for logfile popup -->
							<script>
							function downloadFile(file_name) {
								var link = document.getElementById(file_name);
								if (link) {
									link.click();
								} else {
									alert('Log file is not available for this job.');
								}
							}
							</script>
						</td>
					</tr>
					<?php
				}
			}
		}
		?>
	</table>
</div>
