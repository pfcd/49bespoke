<?php
/**
 *
 * Template Frontend Tables.
 *
 * @package ELEX Bulk Edit Products, Prices & Attributes for Woocommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class='wrap table-box table-box-main' id='wrap_table' style="position:relative;display: none;">
	<?php
	eh_bep_list_table();
	?>
</div>
<div id='undo_update_html' style="padding: 10px 0px;"></div>
<?php
eh_bep_process_edit();

/** List Table. */
function eh_bep_list_table() {
	$obj = new Eh_DataTables();
	$obj->input();
	$obj->prepare_items();
	$obj->search_box( 'search', 'search_id' );
	esc_html_e( 'Items per page:', 'eh_bulk_edit' );
	?>
	<input id="display_count_order" style="width:75px" type="number" min="1" max="9999" maxlength="4" value="
	<?php
	$count = get_option( 'eh_bulk_edit_table_row' );
	if ( $count ) {
		echo filter_var( $count );
	}
	?>
	">
	<button id='save_dislay_count_order'class='button ' style='background-color:#f7f7f7; '><?php esc_html_e( 'Apply', 'eh_bulk_edit' ); ?></button>
	<form id="products-filter" method="get">
		<input type="hidden" name="action" value="all" />
		<input type="hidden" name="page" value="<?php isset( $_REQUEST['page'] ) ? filter_var( wp_unslash( $_REQUEST['page'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification ?>" />
		<br>
		<center><strong><label for="bep_filter_select_unselect_all_products"><input type="checkbox" name="bep_filter_select_unselect_all_products" id="bep_filter_select_unselect_all_products_checkbox" checked="checked"/>Select/Unselect All Products.</label></strong></center>
		<?php $obj->display(); ?>
	</form>
	<button id='preview_back' value='edit_products' style="background-color: gray;color: white; width: 10%; " class='button button-large'><span class="update-text"><?php esc_html_e( 'Back', 'eh_bulk_edit' ); ?></span></button>
	<button id='preview_cancel' value='edit_products' style="background-color: gray;color: white; width: 10%; " class='button button-large'><span class="update-text"><?php esc_html_e( 'Cancel', 'eh_bulk_edit' ); ?></span></button>
	<button id='process_edit' value='edit_products' style="color: white;margin-bottom: 0%; float: right; width: 10%;" class='button button-primary button-large'><span class="update-text"><?php esc_html_e( 'Continue', 'eh_bulk_edit' ); ?></span></button>

	<?php
}
/** Process Edit. */
function eh_bep_process_edit() {
	global $woocommerce;
	$attributes = wc_get_attribute_taxonomies();
	?>
	<div class='wrap postbox table-box table-box-main' id="update_logs" style='padding:0px 20px;display: none'>
		<h1> <?php esc_html_e( 'Updating the products. Do not refresh...', 'eh_bulk_edit' ); ?></h1>
		<div id='logs_val' ></div>
		<div id='logs_loader' ></div><br><br>

		<button id='finish_cancel' value='edit_products' style="background-color: gray; margin-bottom: 1%; color: white; width: 10%;" class='button button-large'><span class="update-text"><?php esc_html_e( 'Cancel', 'eh_bulk_edit' ); ?></span></button>
		<button id='undo_update_finish_page' value='edit_products' style=' background-color: #006799; margin-bottom: 1%; color: white;  width: 10%;height: 37px;' class='button button-large'><span class="update-text"><?php esc_html_e( 'Undo', 'eh_bulk_edit' ); ?></span></button>
		<button id='update_finished' value='edit_products' style=' background-color: #006799; margin-bottom: 1%; color: white; float: right; width: 10%;height: 37px;' class='button button-large'><span class="update-text"><?php esc_html_e( 'Continue', 'eh_bulk_edit' ); ?></span></button>

	</div>
	<div class='wrap postbox table-box table-box-main' id="undo_update_logs" style='padding:0px 20px;display: none'>
		<h1> <?php esc_html_e( 'Undo previous update. Do not refresh...', 'eh_bulk_edit' ); ?></h1>
		<div id='undo_logs_val' ></div>
		<div id='undo_logs_loader' ></div><br><br>
		<button id='undo_cancel' value='edit_products' style="background-color: gray; margin-bottom: 1%; color: white; width: 10%;" class='button button-large'><span class="update-text"><?php esc_html_e( 'Cancel', 'eh_bulk_edit' ); ?></span></button>
	</div>

	<div class='wrap postbox table-box table-box-main' id="edit_product" style='padding:0px 20px;display: none'>
		<h2>
			<?php esc_html_e( 'Update the Products', 'eh_bulk_edit' ); ?>
		</h2>
		<hr>
		<table class='eh-edit-table' id='update_general_table'>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Title', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select a condition to edit the title, and enter the relevant text', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='title_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='set_new'><?php esc_html_e( 'Set New', 'eh_bulk_edit' ); ?></option>
						<option value='append'><?php esc_html_e( 'Append', 'eh_bulk_edit' ); ?></option>
						<option value='prepand'><?php esc_html_e( 'Prepend', 'eh_bulk_edit' ); ?></option>
						<option value='replace'><?php esc_html_e( 'Replace', 'eh_bulk_edit' ); ?></option>
						<option value='regex_replace'><?php esc_html_e( 'RegEx Replace', 'eh_bulk_edit' ); ?></option>
						<option value='sentence_key'><?php esc_html_e( 'Sentence Case', 'eh_bulk_edit' ); ?></option>
					</select>
					<span id='title_text'></span>
				</td>
				<td class='eh-edit-tab-table-right' id='regex_flags_field_title'>
					<span class='select-eh'><select data-placeholder='<?php esc_html_e( 'Select Flags (Optional)', 'eh_bulk_edit' ); ?>' id='regex_flags_values_title' multiple class='category-chosen regex-flags-edit-table' >
							<?php
							{
								echo "<option value='A'>Anchored (A)</option>";
								echo "<option value='D'>Dollors End Only (D)</option>";
								echo "<option value='x'>Extended (x)</option>";
								echo "<option value='X'>Extra (X)</option>";
								echo "<option value='i'>Insensitive (i)</option>";
								echo "<option value='J'>Jchanged (J)</option>";
								echo "<option value='m'>Multi Line (m)</option>";
								echo "<option value='s'>Single Line (s)</option>";
								echo "<option value='u'>Unicode (u)</option>";
								echo "<option value='U'>Ungreedy (U)</option>";
							}
							?>
						</select></span>
				</td>
				<td class='eh-edit-tab-table-help' id='regex_help_link_title'>
					<a href="https://elextensions.com/understanding-regular-expression-regex-pattern-matching-bulk-edit-products-prices-attributes-woocommerce-plugin/" target="_blank">Help</a>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'SKU', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select a condition to edit the SKU and enter the relevant text. When updating a new SKU for multiple products, include padding and delimiter.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='sku_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='set_new'><?php esc_html_e( 'Set New', 'eh_bulk_edit' ); ?></option>
						<option value='append'><?php esc_html_e( 'Append', 'eh_bulk_edit' ); ?></option>
						<option value='prepand'><?php esc_html_e( 'Prepend', 'eh_bulk_edit' ); ?></option>
						<option value='replace'><?php esc_html_e( 'Replace', 'eh_bulk_edit' ); ?></option>
						<option value='regex_replace'><?php esc_html_e( 'RegEx Replace', 'eh_bulk_edit' ); ?></option>
					</select>
					<span id='sku_text'></span>
				</td>
				<td class='eh-edit-tab-table-right' id='regex_flags_field_sku'>
					<span class='select-eh'><select data-placeholder='<?php esc_html_e( 'Select Flags (Optional)', 'eh_bulk_edit' ); ?>' id='regex_flags_values_sku' multiple class='category-chosen regex-flags-edit-table' >
							<?php
							{
								echo "<option value='A'>Anchored (A)</option>";
								echo "<option value='D'>Dollors End Only (D)</option>";
								echo "<option value='x'>Extended (x)</option>";
								echo "<option value='X'>Extra (X)</option>";
								echo "<option value='i'>Insensitive(i)</option>";
								echo "<option value='J'>Jchanged(J)</option>";
								echo "<option value='m'>Multi Line(m)</option>";
								echo "<option value='s'>Single Line(s)</option>";
								echo "<option value='u'>Unicode(u)</option>";
								echo "<option value='U'>Ungreedy(U)</option>";
							}
							?>
						</select></span>
				</td>
				<td class='eh-edit-tab-table-right' id='sku_show' style="height:28px;width:20%;vertical-align:top;padding-top:20px;" >
					<div class="sku_ex text-secondary text-nowrap"><?php esc_html_e( 'Preview : ' ); ?>
				</td>
				<td class='eh-edit-tab-table-help' id='regex_help_link_sku'>
					<a href="https://elextensions.com/understanding-regular-expression-regex-pattern-matching-bulk-edit-products-prices-attributes-woocommerce-plugin/" target="_blank">Help</a>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Product Visibility', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Choose which all shop pages the product will be listed on', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='catalog_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='visible'><?php esc_html_e( 'Shop and Search', 'eh_bulk_edit' ); ?></option>
						<option value='catalog'><?php esc_html_e( 'Shop', 'eh_bulk_edit' ); ?></option>
						<option value='search'><?php esc_html_e( 'Search', 'eh_bulk_edit' ); ?></option>
						<option value='hidden'><?php esc_html_e( 'Hidden', 'eh_bulk_edit' ); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Featured Product', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='

					<?php esc_html_e( 'Select product type(s) to which you want the filtered product(s) to be changed.', 'eh_bulk_edit' ); ?>

			'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='is_featured' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='yes'><?php esc_html_e( 'Yes', 'eh_bulk_edit' ); ?></option>
						<option value='no'><?php esc_html_e( 'No', 'eh_bulk_edit' ); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Change Product Type', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='
				<?php esc_html_e( 'Select an option to change the product(s) Type or not.', 'eh_bulk_edit' ); ?> '></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='is_product_type' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='simple'><?php esc_html_e( 'Simple', 'eh_bulk_edit' ); ?></option>
						<option value='variable'><?php esc_html_e( 'Variable', 'eh_bulk_edit' ); ?></option>
						<option value='external'><?php esc_html_e( 'External', 'eh_bulk_edit' ); ?></option>
					</select>
				</td>
			</tr>

			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Shipping Class', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select a shipping class that will be added to all the filtered products', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='shipping_class_action' style="width: 26%;">
						<?php
						$ship = $woocommerce->shipping->get_shipping_classes();
						if ( count( $ship ) > 0 ) {
							?>
							<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
							<option value='-1'><?php esc_html_e( 'No Shipping Class', 'eh_bulk_edit' ); ?></option>
							<?php
							foreach ( $ship as $key => $value ) {
								echo filter_var( "<option value='" . $value->term_id . "'>" . $value->name . '</option>' );
							}
						} else {
							?>
							<option value=''><?php esc_html_e( '< No Shipping Class >', 'eh_bulk_edit' ); ?></option>
							<?php
						}
						?>
					</select>
					<span id='shipping_class_check_text'></span>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Description Action', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select a condition to edit or add the description, and enter the relevant text.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
				<select id="description_action" style="width: 26%;">
					<option value=""><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></option>
					<option value="append"><?php esc_html_e( 'Append', 'eh_bulk_edit' ); ?></option>
					<option value="prepend"><?php esc_html_e( 'Prepend', 'eh_bulk_edit' ); ?></option>
					<option value="set_new"><?php esc_html_e( 'Set new', 'eh_bulk_edit' ); ?></option>
					<option value="replace"><?php esc_html_e( 'Replace', 'eh_bulk_edit' ); ?></option>
				</select>
				<span id='description_text'></span>
				</td>
			</tr>
			<tr id="description_tr">
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Description', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Prepend - Enter the text you want to add at the beginning of the current description. Append - Enter the text you want to add at the end of the current description. Set new - Enter the text to replace the current description.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<?php wp_editor( '', 'elex_product_description' ); ?>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Short Description Action', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select a condition to edit or add the short description, and enter the relevant text.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
				<select id="short_description_action" style="width: 26%;">
					<option value=""><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></option>
					<option value="append"><?php esc_html_e( 'Append', 'eh_bulk_edit' ); ?></option>
					<option value="prepend"><?php esc_html_e( 'Prepend', 'eh_bulk_edit' ); ?></option>
					<option value="set_new"><?php esc_html_e( 'Set new', 'eh_bulk_edit' ); ?></option>
					<option value="replace"><?php esc_html_e( 'Replace', 'eh_bulk_edit' ); ?></option>
				</select>
				<span id='short_description_text'></span>
				</td>
			</tr>
			<tr id="short_description_tr">
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Short Description', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Prepend - Enter the text you want to add at the beginning of the current short description. Append - Enter the text you want to add at the end of the current short description. Set new - Enter the text to replace the current short description.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<?php wp_editor( '', 'elex_product_short_description' ); ?>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Product Image', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Specify an image url to add or replace the product image.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<input type="text" id="elex_product_main_image" style="width: 26%;"/>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Product Gallery Images Action', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select a condition to modify product gallery images.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id="gallery_image_action" style="width: 26%;">
						<option value=""><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></option>
						<option value="add"><?php esc_html_e( 'Add', 'eh_bulk_edit' ); ?></option>
						<option value="remove"><?php esc_html_e( 'Remove', 'eh_bulk_edit' ); ?></option>
						<option value="replace"><?php esc_html_e( 'Replace', 'eh_bulk_edit' ); ?></option>
					</select>
				</td>
			</tr>
			<tr id="gallery_images_tr">
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Product Gallery Images', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Specify the urls (separated by comma) to add, remove or replace images from product gallery.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<textarea id="elex_product_gallery_images" style="width: 26%;"></textarea>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Product Visibility Status', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Choose "Public" to make the product visible for all visitors of your store. Choose "Password Protect" to make the product accessible only  by entering the right password.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id="category_password_action" style="width: 26%;">
						<option value=""><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></option>
						<option value="public"><?php esc_html_e( 'Public', 'eh_bulk_edit' ); ?></option>
						<option value="private"><?php esc_html_e( 'Private', 'eh_bulk_edit' ); ?></option>
						<option value="password protected"><?php esc_html_e( 'Password Protect', 'eh_bulk_edit' ); ?></option>
					</select>
				</td>
			</tr>
			<tr id="category_password_field" style="display:none;">
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Product Password', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Enter the password required to be entered by the store visitors to access the product page.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<input type="text" id="elex_main_password_field" style="width: 20%;"/>
				</td>
			</tr>
		</table>
		<h2>
			<?php esc_html_e( 'Price', 'eh_bulk_edit' ); ?>
		</h2>
		<hr>
		<table class='eh-edit-table' id="update_price_table">
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Regular Price', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select a condition to adjust the price and enter the value. You can also choose an option to round it to the nearest value', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='regular_price_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='up_percentage'><?php esc_html_e( 'Increase by Percentage ( + %)', 'eh_bulk_edit' ); ?></option>
						<option value='down_percentage'><?php esc_html_e( 'Decrease by Percentage ( - %)', 'eh_bulk_edit' ); ?></option>
						<option value='up_price'><?php esc_html_e( 'Increase by Price ( + $)', 'eh_bulk_edit' ); ?></option>
						<option value='down_price'><?php esc_html_e( 'Decrease by Price ( - $)', 'eh_bulk_edit' ); ?></option>
						<option value='flat_all'><?php esc_html_e( 'Flat Price for All', 'eh_bulk_edit' ); ?></option>

					</select>
					<span id='regular_price_text'></span>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Sale Price', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select a condition to adjust the price and enter the value. You can also choose an option to round it to the nearest value', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='sale_price_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='up_percentage'><?php esc_html_e( 'Increase by Percentage ( + %)', 'eh_bulk_edit' ); ?></option>
						<option value='down_percentage'><?php esc_html_e( 'Decrease by Percentage ( - %)', 'eh_bulk_edit' ); ?></option>
						<option value='up_price'><?php esc_html_e( 'Increase by Price ( + $)', 'eh_bulk_edit' ); ?></option>
						<option value='down_price'><?php esc_html_e( 'Decrease by Price ( - $)', 'eh_bulk_edit' ); ?></option>
						<option value='flat_all'><?php esc_html_e( 'Flat Price for All', 'eh_bulk_edit' ); ?></option>

					</select>
					<span id='sale_price_text'></span>
				</td>
			</tr>
			<tr id="regular_checkbox">
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Use Regular Price to set Sale Price', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Enable this option to set the Sale Price based on the the Regular Price.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<input type="checkbox" id="regular_val_check"><?php esc_html_e( 'Enable.', 'eh_bulk_edit' ); ?>
					<span id='regular_price_text'></span>
				</td>
			</tr>
			 <!-- bundle_product. -->
		</table>
		<?php
		/**
		 * Check if WooCommerce Product Bundles plugin is active.
		 *
		 * This applies the 'active_plugins' filter to get the list of currently active plugins
		 * and checks if the 'woocommerce-product-bundles/woocommerce-product-bundles.php' plugin is active.
		 *
		 * @hook active_plugins
		 * @since 1.0.0
		 */
		if (in_array( 'woocommerce-product-bundles/woocommerce-product-bundles.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true )) {
			?>
		<h2>
			<?php esc_html_e( 'Bundle Product ', 'eh_bulk_edit' ); ?>
		</h2>
		<hr>
		<table class='eh-edit-table' >
			<tr>
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Layout', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select the <strong>Tabular</strong> option to have the thumbnails, descriptions and quantities of bundled products arranged in a table. Recommended for displaying multiple bundled products with configurable quantities.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='bundle_layout_checkbox_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='default'><?php esc_html_e( 'Standard', 'eh_bulk_edit' ); ?></option>
						<option value='tabular'><?php esc_html_e( 'Tabular', 'eh_bulk_edit' ); ?></option>
						<option value='grid'><?php esc_html_e( 'Grid', 'eh_bulk_edit' ); ?></option>
					</select>
					<span id='elex_bundle_layout'></span>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Form Location', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( '<strong>Default</strong> – The add-to-cart form is displayed inside the single-product summary.</br></br><strong>Before Tabs</strong> – The add-to-cart form is displayed before the single-product tabs. Usually allocates the entire page width for displaying form content. Note that some themes may not support this option.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='elex_bundle_from_location_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='default'><?php esc_html_e( 'Default', 'eh_bulk_edit' ); ?></option>
						<option value='after_summary'><?php esc_html_e( 'Before Tabs', 'eh_bulk_edit' ); ?></option>
					</select>
					<span id='elex_bundle_from_location'></span>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Item Grouping', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Controls the grouping of parent/child line items in cart/order templates.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='elex_bundle_item_grouping_checkbox_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='parent'><?php esc_html_e( 'Grouped', 'eh_bulk_edit' ); ?></option>
						<option value='noindent'><?php esc_html_e( 'Flat', 'eh_bulk_edit' ); ?></option>
						<option value='none'><?php esc_html_e( 'None', 'eh_bulk_edit' ); ?></option>

					</select>
					<span id='elex_bundle_item_grouping'></span>
				</td>
			</tr>
			<tr id="elex_bundle_min_bundle_row" style="">
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Min Bundle Size', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Minimum combined quantity of bundled items.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
				<input type="number" id="elex_bundle_min_bundle_size" style="width:26%;" min="0" max="1000" />
				</td>
				<div id="error-message"></div>
			</tr>
			<tr id="elex_bundle_max_row" style="">
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Max Bundle Size', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Maximum combined quantity of bundled items.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
				<input type="number" id="elex_bundle_max_size" style="width:26%;" min="0" max="1000" />
				</td>
				<div id="error-message"></div>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Edit in Cart', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Enable this option to allow changing the configuration of this bundle in the cart. Applicable to bundles with configurable attributes and/or quantities.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='elex_bundle_edit_cart_checkbox' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='yes'><?php esc_html_e( 'Enable', 'eh_bulk_edit' ); ?></option>
						<option value='no'><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></option>
					</select>
					<span id='elex_bundle_edit_cart'></span>
				</td>
			</tr>
		</table>
		<table class='eh-edit-table' id="update_price_table">
			<h4>
			 <?php esc_html_e( 'Basic Settings', 'eh_bulk_edit' ); ?>
			</h4>
			<tr id="elex_bundle_min_quantity_row" style="">
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Min Quantity', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'The minimum quantity of this bundled product.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
				<input type="number" id="elex_bundle_min_quantity" style="width:26%;" min="0" max="1000" />
				<span id="error-message-min"></span>
				</td>
			</tr>
			<tr id="elex_bundle_max_quantity_row" style="">
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Max Quantity', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'The maximum quantity of the bundled product. Leave the field empty for an unlimited maximum quantity.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
				<input type="number" id="elex_bundle_max_quantity" style="width:26%;" min="0" max="1000" />
				<span id="error-message-max"></span>
				</td>
			</tr>
			<tr id="elex_bundle_default_quantity_row" style="">
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Default Quantity', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'The default quantity of this bundled product.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
				<input type="number" id="elex_bundle_default_quantity" style="width:26%;" min="0" max="1000" />
				<span id="error-message-default"></span>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Optional', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Check this option to mark the bundled product as optional.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='bundle_optional_checkbox_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='yes'><?php esc_html_e( 'Enable', 'eh_bulk_edit' ); ?></option>
						<option value='no'><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></option>
					</select>
					<span id='regular_price_text'></span>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Shipped Individually', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Check this option if this bundled item is shipped separately from the bundle.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='bundle_optional_ship_individual_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='yes'><?php esc_html_e( 'Enable', 'eh_bulk_edit' ); ?></option>
						<option value='no'><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></option>
					</select>
					<span id='elex_bundle_ship_individual'></span>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Priced Individually', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Check this option to have the price of this bundled item added to the base price of the bundle.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<input type="checkbox" id="bundle_price_individual_checkbox"><?php esc_html_e( 'Enable', 'eh_bulk_edit' ); ?>
				</td>
			</tr>
			<tr id="bundle_discount_row" style="display:none;">
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Discount %', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Discount applied to the price of this bundled product when Priced Individually is checked. If the bundled product has a Sale Price, the discount is applied on top of the Sale Price.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<input type="text" id="elex_bundle_discount" style="width: 26%;"/>
				</td>
			</tr>
			
		</table>
		<h4>
			 <?php esc_html_e( 'Advanced Settings', 'eh_bulk_edit' ); ?>
		</h4>
		<span style="color: #6c757d; font-size: smaller;"><?php echo esc_html__('Visibility', 'eh_bulk_edit'); ?></span>
		<table class='eh-edit-table'>
			<tr>
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Product details', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Controls the visibility of the bundled item in the single-product template of this bundle.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				
				<td class='eh-edit-tab-table-input-td'>
					<select id='elex_bundle_product_details_checkbox' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='visible'><?php esc_html_e( 'visible', 'eh_bulk_edit' ); ?></option>
						<option value='hidden'><?php esc_html_e( 'hidden', 'eh_bulk_edit' ); ?></option>
					</select>
				</td>
			</tr>
			<tr id="elex_bundle_override_title_checkbox_row" style="display:none;">
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Override Title', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Check this option to override the default product title.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='elex_bundle_override_title_checkbox' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='yes'><?php esc_html_e( 'Enable', 'eh_bulk_edit' ); ?></option>
						<option value='no'><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></option>
					</select>
				</td>
			</tr>
			<tr id="elex_bundle_override_title_row" style="display:none;">
				<td class='eh-edit-tab-table-left'>
				</td>
				<td class='eh-edit-tab-table-middle'>
				</td>
				<td class='eh-edit-tab-table-input-td'>
				 <?php wp_editor( '', 'elex_bundle_override_title' ); ?>
				</td>
			</tr>
			<tr id="elex_bundle_override_short_descrp_checkbox_row" style="display:none;">
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Override Short Description', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Check this option to override the default short product description.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='elex_bundle_override_short_descrp_checkbox' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='yes'><?php esc_html_e( 'Enable', 'eh_bulk_edit' ); ?></option>
						<option value='no'><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></option>
					</select>
				</td>
			</tr>
			<tr id="elex_bundle_override_short_descrp_row" style="display:none;">
				<td class='eh-edit-tab-table-left'>
				</td>
				<td class='eh-edit-tab-table-middle'>
				</td>
				<td class='eh-edit-tab-table-input-td'>
				 <?php wp_editor( '', 'elex_bundle_override_short_descrp' ); ?>
				</td>
			</tr>
			<tr id="elex_bundle_hidetumb_row" style="display:none;">
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Hide Thumbnail', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Check this option to hide the thumbnail image of this bundled product.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='elex_bundle_hidetumb_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='yes'><?php esc_html_e( 'Enable', 'eh_bulk_edit' ); ?></option>
						<option value='no'><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></option>
					</select>
					<span id='elex_bundle_ship_individual'></span>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Cart/checkout', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Controls the visibility of the bundled item in cart/checkout templates.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='elex_bundle_cart_checkout_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='visible'><?php esc_html_e( 'Enable', 'eh_bulk_edit' ); ?></option>
						<option value='hidden'><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></option>
					</select>
					<span id='elex_bundle_cart_checkout'></span>
				</td>
			</tr>	
			<tr>
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Order details', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Controls the visibility of the bundled item in order-details and e-mail templates.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='elex_bundle_order_det_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='visible'><?php esc_html_e( 'Enable', 'eh_bulk_edit' ); ?></option>
						<option value='hidden'><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></option>
					</select>
					<span id='elex_bundle_order_det'></span>
				</td>
			</tr>
			<tr id="elex_bundle_price_visibility" style="display: none;">
				<td>
					<span style="color: #6c757d; font-size: smaller;">
					 <?php echo esc_html__('Price Visibility', 'eh_bulk_edit'); ?>
					</span>
				</td>
			</tr>
			<tr id="bundle_price_visibiliy_prodcut_details_checkbox" style="display:none;">
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Product details', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Controls the visibility of the bundled-item price in the single-product template of this bundle.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='elex_bundle_price_visibili_prod_det' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='visible'><?php esc_html_e( 'Enable', 'eh_bulk_edit' ); ?></option>
						<option value='hidden'><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></option>
					</select>
					<span id='elex_bundle_cart_checkout'></span>
				</td>
			</tr>	
			<tr id="bundle_price_visibiliy_cart_checkout_checkbox" style="display:none;">
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Cart/checkout', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Controls the visibility of the bundled-item price in cart/checkout templates.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='elex_bundle_price_visibili_cart' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='visible'><?php esc_html_e( 'Enable', 'eh_bulk_edit' ); ?></option>
						<option value='hidden'><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></option>
					</select>
					<span id='elex_bundle_cart_checkout'></span>
				</td>
			</tr>	
			<tr id="bundle_price_visibiliy_order_details_checkbox" style="display:none;">
				<td class='eh-edit-tab-table-left'>
				 <?php esc_html_e( 'Order details', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Controls the visibility of the bundled-item price in order-details and e-mail templates.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='elex_bundle_price_visibili_order' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='visible'><?php esc_html_e( 'Enable', 'eh_bulk_edit' ); ?></option>
						<option value='hidden'><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></option>
					</select>
					<span id='elex_bundle_cart_checkout'></span>
				</td>
			</tr>
		</table>
		<?php
		}
		?>
		<h2>
			<?php esc_html_e( 'Schedule', 'eh_bulk_edit' ); ?>
		</h2>
		<table class='eh-edit-table'>
			<!-- Schedule Sale Price Customization. -->
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Schedule Sale Price', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Enable this option to schedule the sale price between two dates.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<input type="checkbox" id="schedule_sale_price_checkbox"><?php esc_html_e( 'Enable', 'eh_bulk_edit' ); ?>
				</td>
			</tr>
			<tr id="schedule_sale_price_row" style="display:none;">
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Sale price date (from)', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Specify the date when the sale price will be applied to the product.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<input type="date" id="sale_price_date_from" style="width: 50%;"/>
				</td>
				<hr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Sale price date (to)', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Specify the date when the sale price will be removed from the product.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<input type="date" id="sale_price_date_to" style="width: 50%;"/>
				</td>
			</tr>
			<!-- Cancel Schedule sale price -->
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Cancel Schedule Sale Price', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Enable this option to cancel scheduled sale price', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<input type="checkbox" id="cancel_schedule_sale_price_checkbox"><?php esc_html_e( 'Enable', 'eh_bulk_edit' ); ?>
			</td>
			</tr>
		</table>
		<h2>
			<?php esc_html_e( 'Stock', 'eh_bulk_edit' ); ?>
		</h2>
		<hr>
		<table class='eh-edit-table' id='update_stock_table'>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Manage Stock', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Enable or Disable manage stock for products or variations', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='manage_stock_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='yes'><?php esc_html_e( 'Enable', 'eh_bulk_edit' ); ?></option>
						<option value='no'><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></option>
					</select>
					<span id='manage_stock_check_text'></span>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Stock Quantity', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Choose an option to update stock quantity and enter the value', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='stock_quantity_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='add'><?php esc_html_e( 'Increase', 'eh_bulk_edit' ); ?></option>
						<option value='sub'><?php esc_html_e( 'Decrease', 'eh_bulk_edit' ); ?></option>
						<option value='replace'><?php esc_html_e( 'Replace', 'eh_bulk_edit' ); ?></option>
					</select>
					<span id='stock_quantity_text'></span>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Allow Backorders', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Choose how you want to handle backorders', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='allow_backorder_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='no'><?php esc_html_e( 'Do not Allow', 'eh_bulk_edit' ); ?></option>
						<option value='notify'><?php esc_html_e( 'Allow, but Notify the Customer', 'eh_bulk_edit' ); ?></option>
						<option value='yes'><?php esc_html_e( 'Allow', 'eh_bulk_edit' ); ?></option>
					</select>
					<span id='backorder_text'></span>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Stock Status', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Choose an option to update  the stock status', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='stock_status_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='instock'><?php esc_html_e( 'In Stock', 'eh_bulk_edit' ); ?></option>
						<option value='outofstock'><?php esc_html_e( 'Out of Stock', 'eh_bulk_edit' ); ?></option>
						<option value='onbackorder'><?php esc_html_e( 'On Backorder', 'eh_bulk_edit' ); ?></option>
					</select>
				</td>
			</tr>
		</table>
		<h2>
			<?php esc_html_e( 'Weight & Dimensions', 'eh_bulk_edit' ); ?>
		</h2>
		<hr>
		<table class='eh-edit-table' id='update_properties_table'>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Length', 'eh_bulk_edit' ); ?>
					<span style="float:right;"><?php echo '(' . filter_var( strtolower( get_option( 'woocommerce_dimension_unit' ) ) ) . ')'; ?></span>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Choose an option to update length and enter the value', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='length_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='add'><?php esc_html_e( 'Increase', 'eh_bulk_edit' ); ?></option>
						<option value='sub'><?php esc_html_e( 'Decrease', 'eh_bulk_edit' ); ?></option>
						<option value='replace'><?php esc_html_e( 'Replace', 'eh_bulk_edit' ); ?></option>
					</select>
					<span id='length_text'></span>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Width', 'eh_bulk_edit' ); ?>
					<span style="float:right;"><?php echo '(' . filter_var( strtolower( get_option( 'woocommerce_dimension_unit' ) ) ) . ')'; ?></span>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Choose an option to update width and enter the value', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='width_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='add'><?php esc_html_e( 'Increase', 'eh_bulk_edit' ); ?></option>
						<option value='sub'><?php esc_html_e( 'Decrease', 'eh_bulk_edit' ); ?></option>
						<option value='replace'><?php esc_html_e( 'Replace', 'eh_bulk_edit' ); ?></option>
					</select>
					<span id='width_text'></span>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Height', 'eh_bulk_edit' ); ?>
					<span style="float:right;"><?php echo '(' . filter_var( strtolower( get_option( 'woocommerce_dimension_unit' ) ) ) . ')'; ?></span>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Choose an option to update height and enter the value', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='height_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='add'><?php esc_html_e( 'Increase', 'eh_bulk_edit' ); ?></option>
						<option value='sub'><?php esc_html_e( 'Decrease', 'eh_bulk_edit' ); ?></option>
						<option value='replace'><?php esc_html_e( 'Replace', 'eh_bulk_edit' ); ?></option>
					</select>
					<span id='height_text'></span>
				</td>
			</tr>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Weight', 'eh_bulk_edit' ); ?>
					<span style="float:right;"><?php echo '(' . filter_var( strtolower( get_option( 'woocommerce_weight_unit' ) ) ) . ')'; ?></span>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Choose an option to update weight and enter the value', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='weight_action' style="width: 26%;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='add'><?php esc_html_e( 'Increase', 'eh_bulk_edit' ); ?></option>
						<option value='sub'><?php esc_html_e( 'Decrease', 'eh_bulk_edit' ); ?></option>
						<option value='replace'><?php esc_html_e( 'Replace', 'eh_bulk_edit' ); ?></option>
					</select>
					<span id='weight_text'></span>
				</td>
			</tr>
		</table>
		<h2>
			<?php esc_html_e( 'Global Attributes', 'eh_bulk_edit' ); ?>
		</h2>
		<hr>
		<table class='eh-edit-table' id='update_attribute_table'>

			<tr id="attr_add_edit">
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Attribute Actions', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select an option to make changes to your attribute values', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='attribute_action' style="width: 210px;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='add'><?php esc_html_e( 'Add New Values', 'eh_bulk_edit' ); ?></option>
						<option value='remove'><?php esc_html_e( 'Remove Existing Values', 'eh_bulk_edit' ); ?></option>
						<option value='replace'><?php esc_html_e( 'Overwrite Existing Values', 'eh_bulk_edit' ); ?></option>
					</select>
				</td>
			</tr>
			<tr id="attr_names" >
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Attributes to Update', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select the attribute(s) for which you want to change the values', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class= 'eh-edit-tab-table-input-td'>
					<?php
					if ( count( $attributes ) > 0 ) {
						foreach ( $attributes as $key => $value ) {
							echo filter_var( "<span id='attribu_name' class='checkbox-eh'><input type='checkbox' name='attribu_name' value='" . $value->attribute_name . "' id='" . $value->attribute_name . "'>" . $value->attribute_label . '</span>' );
						}
					} else {
						echo "<span id='attribu_name' class='checkbox-eh'>No attributes found.</span>";
					}
					?>
				</td>

			</tr>
			<tr id="new_attr">

			</tr>

			<tr id ="variation_select">

			</tr>
		</table>
		<h2>
			<?php esc_html_e( 'Tags', 'eh_bulk_edit' ); ?>
		</h2>
		<hr>
		<table class='eh-edit-table' id='update_tags_table'>

			<tr id="tag_add_edit">
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Tag Actions', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select an option to make changes to your tags values', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='tag_action' style="width: 210px;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='add'><?php esc_html_e( 'Add New Values', 'eh_bulk_edit' ); ?></option>
						<option value='remove'><?php esc_html_e( 'Remove Existing Values', 'eh_bulk_edit' ); ?></option>
						<option value='replace'><?php esc_html_e( 'Overwrite Existing Values', 'eh_bulk_edit' ); ?></option>
					</select>
				</td>
			</tr>
			<tr id="tag_names" >
				<td class='eh-edit-tab-table-left' >
					<?php esc_html_e( 'Tags to Update', 'eh_bulk_edit' ); ?>
				</td>		
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select  tags values', 'eh_bulk_edit' ); ?>'></span>
				</td>	
				<td class='eh-edit-tab-table-input-td' >
					<?php
						$terms = get_terms( array( 
							'hide_empty' => false,
							'taxonomy' => 'product_tag',
						 ) 
						);
					?>
					<select data-placeholder='<?php esc_html_e( 'Select Tags to update', 'eh_bulk_edit' ); ?>' style="width: 210px;" id='elex_select_tag' multiple class='select-tag' >
					<?php
					foreach ( $terms as $index => $term_obj ) {
						echo filter_var( '<option value="' . $term_obj->term_id . '">' . $term_obj->name . '</option>' );
					}
					?>
					</select>
				</td>
			</tr>
		</table>

		<!-- Custom Attributes. -->
		<h2>
			<?php esc_html_e( 'Custom Attributes', 'eh_bulk_edit' ); ?>
		</h2>
		<hr>
		<table class='eh-edit-table' id='update_custom_attribute_table'>

			<tr id="custom_attr_add_edit">
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Attribute Actions', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select an option to make changes to your custom attribute values', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='custom_attribute_action' style="width: 210px;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='remove'><?php esc_html_e( 'Remove Existing Attributes', 'eh_bulk_edit' ); ?></option>
					</select>
				</td>
			</tr>
			<tr id="custom_attr_names" >
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Select Attributes', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select the attribute(s) which you want to remove. Note: Attribute associated variations will also be removed.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class= 'eh-edit-tab-table-input-td'>
					<?php
					global $wpdb;
					// Get custom attributes.
					$products          = $wpdb->get_results("
						SELECT
							postmeta.post_id,
							postmeta.meta_value
						FROM
							{$wpdb->postmeta} AS postmeta
						WHERE
							postmeta.meta_key = '_product_attributes'
							AND COALESCE(postmeta.meta_value, '') != ''
					");
					$custom_attributes = array();
					foreach ( $products as $product ) {
						$product_attributes = maybe_unserialize( $product->meta_value );
						if ( is_array( $product_attributes ) || is_object( $product_attributes ) ) {
							foreach ( $product_attributes as $attribute_slug => $product_attribute ) {
								if ( isset( $product_attribute['is_taxonomy'] ) && 0 === intval( $product_attribute['is_taxonomy'] ) && 'product_shipping_class' !== $attribute_slug ) {
									$values = array_map( 'trim', explode( ' ' . WC_DELIMITER . ' ', $product_attribute['value'] ) );
									foreach ( $values as $value ) {
										$value_slug = $value;
										$custom_attributes[ $attribute_slug ][ $value_slug ] = $value;
									}
								}
							}
						}
					}
					if ( count( $custom_attributes ) > 0 ) {
						foreach ( $custom_attributes as $key => $value ) {
							$decoded = urldecode($key);
							echo filter_var( "<span id='custom_attribu_name' class='checkbox-eh'><input type='checkbox' name='custom_attribu_name' value='" . $decoded . "' id='" . $decoded . "'>" . ucfirst($decoded) . '</span>' );
						}
					} else {
						echo "<span id='custom_attribu_name' class='checkbox-eh'>No attributes found.</span>";
					}
					?>
				</td>
			</tr>
			<tr id="new_custom_attr">
			</tr>
			<tr id ="custom_variation_select">
			</tr>
		</table>

		<h2>
			<?php esc_html_e( 'Tax', 'eh_bulk_edit' ); ?>
		</h2>
		<hr>
		<table class='eh-edit-table' id='update_tax_table'>

			<tr id="tax_status_add_edit">
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Tax status', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select an option to determine whether you want to display the selected attribute on the product page.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select id='tax_status_action' style="width: 210px;">
						<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
						<option value='taxable'><?php esc_html_e( 'Taxable', 'eh_bulk_edit' ); ?></option>
						<option value='shipping'><?php esc_html_e( 'Shipping', 'eh_bulk_edit' ); ?></option>
						<option value='none'><?php esc_html_e( 'None', 'eh_bulk_edit' ); ?></option>
					</select>
				</td>
			</tr>

			<tr id="tax_class_add_edit">
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Tax Class', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select an option to determine whether you want to display the selected attribute on the product page.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>

					<select id='tax_class_action' style="width: 210px;">
						<?php
						$tax_classes              = WC_Tax::get_tax_classes();
						$classes_names            = array();
						$classes_names['default'] = 'Standard';
						if ( ! empty( $tax_classes ) ) {
							foreach ( $tax_classes as $class ) {
								$classes_names[ sanitize_title( $class ) ] = esc_html( $class );
							}
						}
						if ( count( $tax_classes ) > 0 ) {
							?>
							<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
							<?php
							foreach ( $classes_names as $key => $value ) {
								echo "<option value='" . filter_var( $key ) . "'>" . filter_var( $value ) . '</option>';
							}
						} else {
							?>
							<option value=''><?php esc_html_e( '<No change >', 'eh_bulk_edit' ); ?></option>
							<?php
						}
						?>
					</select>
				</td>
			</tr>

		</table>

		<h2>
			<?php esc_html_e( 'Interchange Global Attribute Values in Variations', 'eh_bulk_edit' ); ?>
		</h2>
		<hr>
		<table class='eh-edit-table' id='update_variations_table'>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Interchange Global Attribute Values in Variations', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select the global attribute and specify the global attribute values you want to change in your variations, if these global attribute values are already used to create variations.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class= 'eh-edit-tab-table-input-td'>
					<?php
					if ( count( $attributes ) > 0 ) {
						foreach ( $attributes as $key => $value ) {
							echo filter_var( "<span id='vari_attribu_name' class='checkbox-eh'><input type='checkbox' name='vari_attribu_name' value='" . $value->attribute_name . "' id='" . $value->attribute_name . "'>" . $value->attribute_label . '</span>' );
						}
					} else {
						echo "<span id='attribu_name' class='checkbox-eh'>No attributes found.</span>";
					}
					?>
				</td>
			</tr>
			<tr id="variations_attribute_rows">
			</tr>
		</table>
		<h2>
			<?php esc_html_e( 'Create Variations', 'eh_bulk_edit' ); ?>
		</h2>
		<table class='eh-edit-table' id='generate_variations_checkbox'>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Create variations from all attributes', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Enabling this will create a new variation for each and every possible combination of variation attributes.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<span id='create_variations_from_attributes_checkbox' class='checkbox-eh bep-block bep-pad-top-20'><label for="bep_filter_create_variation_for_variable_products"><input type="checkbox" name="bep_filter_create_variation_for_variable_products" id="bep_filter_create_variation_for_variable_products" /><?php esc_html_e( 'Enable to Create Variations.', 'eh_bulk_edit' ); ?></label></span>
					<span class='bep-block bep-helpertext'><?php esc_html_e( 'Read more about ', 'eh_bulk_edit' ); ?><a target="_blank" href="https://elextensions.com/knowledge-base/create-bulk-variations-elex-wocommerce-bulk-edit-products-plugin/"><?php esc_html_e( 'bulk editing variations', 'eh_bulk_edit' ); ?></a>.</span>
				</td>
			</tr>
			<tr id="regular_sale_variation" style="display:none">
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Variation Regular Price', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Specify the regular price to be set for all the possible combinations of variations.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<input type="number" id="variation_regular_price" min="0" style="width: 30%;"/>
				</td>
				<hr>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Variation Sale Price', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Specify the sale price to be set for all the possible combinations of variations.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<input type="number" id="variation_sale_price" min="0" style="width: 30%;"/>
				</td>
			</tr>
		</table>
		<h2>
			<?php esc_html_e( 'Categories', 'eh_bulk_edit' ); ?>
		</h2>
		<hr>
		<table class='eh-edit-table' id='update_category_table'>
			<tr id="cat_update">
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Category Actions', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip="<?php esc_html_e( "Select an action to re-assign categories. 'Add' will append and 'Remove' will take out categories. 'Overwrite' will remove all the existing categories and assign the selected categories", 'eh_bulk_edit' ); ?>"></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<input type="radio" id="cat_update_none" name="edit_category" value="cat_none" checked /><label >None</label>
					<input type="radio" id="cat_update_add" name="edit_category" value="cat_add" /><label>Add</label>
					<input type="radio" id="cat_update_remove" name="edit_category" value="cat_remove" /><label>Remove</label>
					<input type="radio" id="cat_update_replce" name="edit_category" value="cat_replace" /><label>Overwrite</label>
				</td>
			</tr>
			<tr id="cat_select">
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Select Categories', 'eh_bulk_edit' ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select a category to perform the action you have chosen.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<select data-placeholder='<?php esc_html_e( 'Select Categories', 'eh_bulk_edit' ); ?>' class ="elex-select-categories" id='elex_select_update_categories'  multiple style="width: 210px;"></select>
				</td>

			</tr>
		</table>

		<?php
		/**
		 * Check if the ELEX Catalog Mode, Wholesale & Role Based Pricing plugin is active.
		 *
		 * This applies the 'active_plugins' filter to get the list of currently active plugins
		 * and checks if the 'elex-catmode-rolebased-price/elex-catmode-rolebased-price.php' plugin is active.
		 *
		 * @hook active_plugins
		 * @since 1.0.0
		 */
		if ( in_array( 'elex-catmode-rolebased-price/elex-catmode-rolebased-price.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
			?>
			<h2>
				<?php esc_html_e( 'Role Based Pricing', 'eh_bulk_edit' ); ?>
			</h2>
			<hr>
			<table class='eh-edit-table' id='update_general_table'>
				<tr>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Hide price', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select option to hide price for unregistered users.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<select id='visibility_price'>
							<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
							<option value='no'><?php esc_html_e( 'Show Price', 'eh_bulk_edit' ); ?></option>
							<option value='yes'><?php esc_html_e( 'Hide Price', 'eh_bulk_edit' ); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Hide product price based on user role', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'For selected user role, hide the product price', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<span class='select-eh'>
							<select data-placeholder='<?php esc_html_e( 'User Role', 'eh_bulk_edit' ); ?>' id='hide_price_role_select' multiple class='hide-price-role-select-chosen' >
								<?php
								global $wp_roles;
								$roles = $wp_roles->role_names;
								foreach ( $roles as $key => $value ) {
									echo filter_var( "<option value='" . $key . "'>" . $value . '</option>' );
								}
								?>
							</select>
						</span>
					</td>
				</tr>
				<?php
				$enabled_roles = get_option( 'eh_pricing_discount_product_price_user_role' );
				if ( is_array( $enabled_roles ) ) {
					if ( ! in_array( 'none', $enabled_roles, true ) ) {
						?>
						<tr>
							<td class='eh-edit-tab-table-left'>
								<?php esc_html_e( 'Enforce product price adjustment', 'eh_bulk_edit' ); ?>
							</td>
							<td class='eh-edit-tab-table-middle'>
								<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select option to enforce indvidual price adjustment', 'eh_bulk_edit' ); ?>'></span>
							</td>
							<td class='eh-edit-tab-table-input-td'>
								<select id='price_adjustment_action'>
									<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
									<option value='yes'><?php esc_html_e( 'Enable', 'eh_bulk_edit' ); ?></option>
									<option value='no'><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></option>
								</select>
							</td>
						</tr>
						<?php
					}
				}
				?>
			</table>
			<?php
		}
		/**
		 * Check if the Per Product Addon for WooCommerce Shipping Pro plugin is active.
		 *
		 * This applies the 'active_plugins' filter to get the list of currently active plugins
		 * and checks if the 'per-product-addon-for-woocommerce-shipping-pro/woocommerce-per-product-shipping-addon-for-shipping-pro.php' plugin is active.
		 *
		 * @hook active_plugins
		 * @since 1.0.0
		 */
		if ( in_array( 'per-product-addon-for-woocommerce-shipping-pro/woocommerce-per-product-shipping-addon-for-shipping-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
			?>
			<h2>
				<?php esc_html_e( 'Shipping Pro', 'eh_bulk_edit' ); ?>
			</h2>
			<hr>
			<table class='eh-edit-table' id='update_properties_table'>
				<tr>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Shipping Unit', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Update Shipping Unit', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<select id='shipping_unit_action'>
							<option value=''><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
							<option value='add'><?php esc_html_e( 'Add', 'eh_bulk_edit' ); ?></option>
							<option value='sub'><?php esc_html_e( 'Subtract', 'eh_bulk_edit' ); ?></option>
							<option value='replace'><?php esc_html_e( 'Replace', 'eh_bulk_edit' ); ?></option>
						</select>
						<span id='shipping_unit_text'></span>
					</td>
				</tr>
			</table>
			<?php
		}
			$keys = get_option( 'eh_bulk_edit_meta_values_to_update' );
		if ( ! empty( $keys ) ) {
			?>
		<table class='eh-edit-table' id='update_meta_table'>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<h2>
					<?php esc_html_e( 'Update meta values', 'eh_bulk_edit' ); ?>
					</h2>
					<hr>
				</td>
			</tr>
			<?php
			foreach ( $keys as $metas ) {
				?>
			<tr>
				<td class='eh-edit-tab-table-left'>
					<?php echo filter_var( $metas ); ?>
				</td>
				<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Update meta', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<input type="text" name="meta_keys" placeholder="Enter meta value">
				</td>
			</tr>
				<?php
			}
		}
		?>
		</table>
			<h2>
				<?php esc_html_e( 'Delete Products', 'eh_bulk_edit' ); ?>
			</h2>
			<hr>
			<table class='eh-edit-table' id='delete_products_table'>
				<tr>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Delete Action', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select how you want to delete products.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<select id="delete_product_action">
							<option value=""><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></option>
							<option value="move_to_trash"><?php esc_html_e( 'Move to trash', 'eh_bulk_edit' ); ?></option>
							<option value="delete_permanently"><?php esc_html_e( 'Delete Permanently', 'eh_bulk_edit' ); ?></option>
						</select>
					</td>
				</tr>
			</table>
		<button id='edit_back' value='cancel_update_button' style="margin-bottom: 1%; background-color: gray; color: white; width: 10%; " class='button button-large'><span class="update-text"><?php esc_html_e( 'Back', 'eh_bulk_edit' ); ?></span></button>
		<button id='edit_cancel' value='cancel_update_button' style="margin-bottom: 1%; background-color: gray; color: white; width: 10%; " class='button button-large'><span class="update-text"><?php esc_html_e( 'Cancel', 'eh_bulk_edit' ); ?></span></button>
		<button id='reset_update_button' value='reset_update_button' style="margin-bottom: 1%; background-color: gray; color: white; width: 10%;" class='button button-large'><span class="update-text"><?php esc_html_e( 'Reset Values', 'eh_bulk_edit' ); ?></span></button>
		<button id='update_button' value='update_button' style="margin-bottom: 1%; float: right; color: white; width: 12%;" class='button button-primary button-large'><span class="update-text"><?php esc_html_e( 'Continue', 'eh_bulk_edit' ); ?></span></button>
	</div>  
	<?php
}
add_action( 'admin_footer', 'eh_bep_variation_pop' );
require_once EH_BEP_TEMPLATE_PATH . '/template-frontend-settings-tab-fields.php';
require_once EH_BEP_TEMPLATE_PATH . '/template-manage-schedule-tasks.php';
/** Variation Pop. */
function eh_bep_variation_pop() {
	$page = ( isset( $_GET['page'] ) ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : false; // phpcs:ignore WordPress.Security.NonceVerification
	if ( 'eh-bulk-edit-product-attr' !== $page ) {
		return;
	}
	?>
	<div class="popup" data-popup="popup-1" id='main_var_disp'>
		<div class="popup-inner" >
			<center><h3><?php esc_html_e( 'Product variations', 'eh_bulk_edit' ); ?></h3></center>
			<div id='vari_disp' style="overflow-y: auto; height: 80%; position:relative;">
			</div>
			<span class="popup-close " data-popup-close="popup-1" id='pop_close' style="cursor:pointer;">x</span>
		</div>
	</div>
	<?php
}
