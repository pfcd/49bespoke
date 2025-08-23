<?php
/**
 *
 * AJAX API Functions.
 *
 * @package ELEX Bulk Edit Products, Prices & Attributes for Woocommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'class-bulk-edit-log.php';
global $hook_suffix;
global $wpdb;
$prefix = $wpdb->prefix;
add_action( 'wp_ajax_eh_bep_get_attributes_action', 'eh_bep_get_attributes_action_callback' );
add_action( 'wp_ajax_eh_bep_get_attributes_action_edit', 'eh_bep_get_attributes_action_edit_callback' );
add_action( 'wp_ajax_eh_bep_all_products', 'eh_bep_list_table_all_callback' );
add_action( 'wp_ajax_eh_bep_count_products', 'eh_bep_count_products_callback' );
add_action( 'wp_ajax_eh_bep_clear_products', 'eh_clear_all_callback' );
add_action( 'wp_ajax_eh_bep_update_products', 'eh_bep_update_product_callback' );
add_action( 'wp_ajax_eh_bep_filter_products', 'eh_bep_search_filter_callback' );
add_action( 'wp_ajax_eh_bep_undo_html', 'eh_bep_undo_html_maker' );
add_action( 'wp_ajax_eh_bulk_edit_display_count', 'eh_bulk_edit_display_count_callback' );
add_action( 'wp_ajax_eh_bep_undo_update', 'eh_bep_undo_update_callback' );
add_action( 'wp_ajax_eh_bulk_edit_save_filter_setting_tab', 'eh_bulk_edit_save_filter_setting_tab_callback' );
add_action( 'wp_ajax_elex_bep_edit_job', 'elex_bep_edit_job_callback' );
add_action( 'wp_ajax_elex_bep_run_job', 'elex_bep_run_job_callback' );
add_action( 'wp_ajax_elex_bep_revert_job', 'eh_bep_undo_html_maker' );
add_action( 'wp_ajax_elex_bep_delete_job', 'elex_bep_delete_job_callback' );
add_action( 'wp_ajax_elex_bep_cancel_schedule', 'elex_bep_cancel_schedule_callback' );
add_action( 'wp_ajax_elex_variations_attribute_change', 'elex_variations_attribute_change_callback' );
add_action( 'wp_ajax_elex_bep_update_checked_status', 'elex_bep_update_checked_status_callback' );
// custom atribute filter.
add_action( 'wp_ajax_eh_bep_send_custom_attributes_filter_input_value', 'eh_bep_send_custom_attributes_filter_input_value_callback' );
// Categories filter.
add_action( 'wp_ajax_eh_bep_send_categories_filter_input_value', 'eh_bep_send_categories_filter_input_value_callback' );
// Custom Attribute Value Filter.
add_action( 'wp_ajax_eh_bep_get_custom_attribute_values_action', 'eh_bep_get_custom_attribute_values_action_callback' );
//undo progress
add_action( 'wp_ajax_eh_bep_send_undo_progress', 'eh_bep_undo_progress_callback');

function eh_bep_undo_progress_callback() {
	$p_up  = get_option( 'offset' );
	$p_rem = get_option( 'product_remaining' );
	if ( 0 !== $p_up ) {
	$array = array(
		'product_update'       => $p_up, 
		'product_remaining'    => $p_rem
	);
	wp_send_json_success( $array );
	}
}
/**
 * Schedule Product Sale Price
 *
 * @param int    $product_id Product ID.
 * @param float  $regular_price Regular Price.
 * @param string $sale_price Sale Price.
 * @param string $date_from Date From.
 * @param string $date_to Date To.
 * @return void
 */
function elex_bep_schedule_product_sale_price( $product_id, $regular_price, $sale_price = '', $date_from = '', $date_to = '' ) {
	$product_id    = absint( $product_id );
	$regular_price = wc_format_decimal( $regular_price );
	$sale_price    = '' === $sale_price ? '' : wc_format_decimal( $sale_price );
	$date_from     = wc_clean( $date_from );
	$date_to       = wc_clean( $date_to );
	$date_to       = DateTime::createFromFormat('Y-m-d', $date_to);

	// Set the time part of the DateTime object $date_to to 23:59:59.
	if ( $date_to ) {
		$date_to->setTime(23, 59, 59);
		// Format the date to the desired output format
		$date_to = $date_to->format('d-m-Y H:i:s');
	}


	$product = wc_get_product( $product_id );
	$product->set_regular_price( $regular_price );
	$product->set_sale_price( $sale_price );

	$product->set_date_on_sale_from( $date_from );
	$product->set_date_on_sale_to( $date_to );

	$product->save();
	if ( $date_to && ! $date_from ) {
		$date_from = strtotime( 'NOW', current_time( 'timestamp' ) );
		$product->set_date_on_sale_from( $date_from );
		$product->save();
	}

	// Update price if on sale.
	if ( '' !== $sale_price && '' === $date_to && '' === $date_from ) {
		$product->set_price( $sale_price );
		$product->save();
	} else {
		$product->set_price( $regular_price );
		$product->save();
	}

	if ( '' !== $sale_price && $date_from && strtotime( $date_from ) < strtotime( 'NOW', current_time( 'timestamp' ) ) ) {
		$product->set_price( $sale_price );
		$product->save();
	}

	if ( $date_to && strtotime( $date_to ) < strtotime( 'NOW', current_time( 'timestamp' ) ) ) {
		$product->set_price( $regular_price );
		$product->set_date_on_sale_from( '' );
		$product->set_date_on_sale_to( '' );
		$product->save();
	}
}

/** Filter Checkbox Handler. */
function elex_bep_update_checked_status_callback() {
	check_ajax_referer( 'ajax-eh-bep-nonce', '_ajax_eh_bep_nonce' );
	$received_data = ! empty( $_POST ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST ) ) : array();
	if ( 'update' === $received_data['operation'] ) {
		$filter_checkbox_data = ! empty( get_option( 'elex_bep_filter_checkbox_data' ) ) ? get_option( 'elex_bep_filter_checkbox_data' ) : array();
		if ( 'false' === $received_data['checkbox_status'] ) { // unchecked.
			if ( ! in_array( intval( $received_data['checkbox_id'] ), array_map( 'intval', $filter_checkbox_data ), true ) ) { // don't update if already exists.
				array_push( $filter_checkbox_data, $received_data['checkbox_id'] );
				update_option( 'elex_bep_filter_checkbox_data', $filter_checkbox_data );
			}
		} else { // checked.
			$filter_checkbox_data = array_diff( $filter_checkbox_data, array( $received_data['checkbox_id'] ) );
			update_option( 'elex_bep_filter_checkbox_data', array_values( $filter_checkbox_data ) );
		}
		wp_die();
	} elseif ( 'delete' === $received_data['operation'] ) { // reset.
		delete_option( 'elex_bep_filter_checkbox_data' );
		wp_die();
	} elseif ( 'count' === $received_data['operation'] ) { // return count.
		$filter_checkbox_data = ! empty( get_option( 'elex_bep_filter_checkbox_data' ) ) ? get_option( 'elex_bep_filter_checkbox_data' ) : array();
		$size                 = count( $filter_checkbox_data );
		wp_die( wp_json_encode( $size ) );
	} elseif ( 'unselect_all' === $received_data['operation'] ) { // reset.
		update_option( 'elex_bep_filter_checkbox_data', array_values( get_option( 'bulk_edit_filtered_product_ids_for_select_unselect' ) ) );
		wp_die();
	}
}

/**
 * Categories Filter Search
 *
 * @return array
 */
function eh_bep_send_categories_filter_input_value_callback() {
	global $wpdb;
	check_ajax_referer( 'ajax-eh-bep-nonce', '_ajax_eh_bep_nonce' );
	if ( isset( $_POST['input_text_value_categories'] ) ) {
		$input_text                   = isset( $_POST['input_text_value_categories'] ) ? sanitize_text_field( $_POST['input_text_value_categories'] ) : '';
		$get_categories               = get_terms(
			array(
				'taxonomy'   => 'product_cat',
				'name__like' => $input_text,
				'number'     => 10,
				'hide_empty' => false
			)
		);
		$categories_values            = array();
		$categories_values['results'] = array();
		$cat_group_collection         = array();
		if ( ! empty( $get_categories ) ) {
			foreach ( $get_categories as $key => $cat_object ) {
				$cat_group         = array();
				$cat_group_items   = array();
				$cat_child         = array();
				$get_cat_child     = get_terms(
					array(
						'taxonomy' => 'product_cat',
						'child_of' => $cat_object->term_id,
					)
				);
				$cat_child['id']   = $cat_object->term_id;
				$cat_child['text'] = $cat_object->name;
				$cat_group_items[] = $cat_child;
				if ( ! empty( $get_cat_child ) || is_object( $get_cat_child ) ) {
					foreach ( $get_cat_child as $key => $cat_childs ) {
						$cat_child         = array();
						$cat_child['id']   = $cat_childs->term_id;
						$cat_child['text'] = $cat_childs->name;
						$cat_group_items[] = $cat_child;
					}
				}
				$parent_category = get_term($cat_object->parent, 'product_cat');
				if ( $parent_category->errors ) {
					$cat_group['text'] = $cat_object->name;
				} else {
					$cat_group['text'] = $parent_category->name;
				}
				$cat_group['children']  = $cat_group_items;
				$cat_group_collection[] = $cat_group;
			}
		}
		$categories_values['results']            = $cat_group_collection;
		$categories_values['pagination']['more'] = false;
		wp_die( wp_json_encode( $categories_values ) );
	}
	wp_die();
}
function eh_bep_send_custom_attributes_filter_input_value_callback() {
	global $wpdb;
	$prefix = $wpdb->prefix;
	check_ajax_referer( 'ajax-eh-bep-nonce', '_ajax_eh_bep_nonce' );

	if ( isset( $_POST['input_text_value_sku'] ) ) {
		$input_text              = isset( $_POST['input_text_value_sku'] ) ? sanitize_text_field( $_POST['input_text_value_sku'] ) : '';
		$lowercase_text			 = mb_strtolower($input_text, 'UTF-8');
		$encoded_text            = urlencode($lowercase_text);  
		$input_text				 = strtolower($encoded_text);
		$attributes_cmp          = strtolower( str_replace( ' ', '-', $input_text ) );
		$input_text              = '%"' . $input_text . '%';
		$custom_attributes_query = "SELECT {$prefix}postmeta.post_id,{$prefix}postmeta.meta_value FROM {$prefix}postmeta WHERE {$prefix}postmeta.meta_key = '_product_attributes' AND {$prefix}postmeta.meta_value LIKE '{$input_text}' AND COALESCE({$prefix}postmeta.meta_value, '') != '' limit 10";
		$products                = $wpdb->get_results( ( $wpdb->prepare( '%1s', $custom_attributes_query ) ? stripslashes( $wpdb->prepare( '%1s', $custom_attributes_query ) ) : $wpdb->prepare( '%s', '' ) ) );

		$custom_attribute_values            = array();
		$custom_attribute_values['results'] = array();
		$temp_custom_attr                   = array();
		$count                              = 1;
		foreach ( $products as $product ) {
			$product_attributes = maybe_unserialize( $product->meta_value );
			if ( is_array( $product_attributes ) || is_object( $product_attributes ) ) {
				foreach ( $product_attributes as $attribute_slug => $product_attribute ) {
					$custom_attr = array();
					if ( isset( $product_attribute['is_taxonomy'] ) && 0 === intval( $product_attribute['is_taxonomy'] ) && 'product_shipping_class' !== $attribute_slug && strpos( $attribute_slug, $attributes_cmp ) !== false && ! in_array( $attribute_slug, $temp_custom_attr ) ) {
						$custom_attr['id']                    = urldecode($attribute_slug);
						$custom_attr['text']                  = $product_attribute['name'];
						$custom_attribute_values['results'][] = $custom_attr;
						$temp_custom_attr[]                   = $attribute_slug;
						$count++;
					}
				}
			}
		}
		$custom_attribute_values['pagination']['more'] = false;
		wp_die( wp_json_encode( $custom_attribute_values ) );
	}

	wp_die();
}
/** Attribute change callback. */
function elex_variations_attribute_change_callback() {
	check_ajax_referer( 'ajax-eh-bep-nonce', '_ajax_eh_bep_nonce' );
	$attribute_name     = isset( $_POST['attrib'] ) ? sanitize_text_field( $_POST['attrib'] ) : '';
	$selected_from_attr = '';
	$selected_to_attr   = '';
	if ( isset( $_POST['attr_edit'] ) ) {
		$attr_detail_arr    = explode( ',', $attribute_name );
		$from_attr          = $attr_detail_arr[0];
		$to_attr            = $attr_detail_arr[1];
		$from_attr_arr      = explode( ':', $from_attr );
		$to_attr_arr        = explode( ':', $to_attr );
		$attribute_name     = $to_attr_arr[0];
		$selected_from_attr = $from_attr_arr[1];
		$selected_to_attr   = $to_attr_arr[1];
	}

	
	$attributes = wc_get_attribute_taxonomies();
	foreach ( $attributes as $key => $value ) {
		if ( $attribute_name === $value->attribute_name ) {
			$attribute_name  = $value->attribute_name;
			$attribute_label = $value->attribute_label;
		}
	}
	$attribute_value =  get_terms( array(
		'taxonomy' => 'pa_' . $attribute_name,
		'hide_empty' => false,
	) );
	$return          = "<tr id='vari_attr_change" . $attribute_name . "'><td>$attribute_label</td><td></td>";
	$return         .= "<td style='width:30%;'><select style='width:50%;' id='vari_attr_change_" . $attribute_name . "'>";
	$return         .= "<option value='" . $attribute_name . ":any'> Any " . $attribute_label . '</option>';
	$selected        = '';
	foreach ( $attribute_value as $key => $value ) {
		if ( $selected_from_attr === $value->slug ) {
			$selected = 'selected';
		} else {
			$selected = '';
		}
		$return .= '<option value=' . $attribute_name . ':' . $value->slug . ' $selected>' . $value->name . '</option>';
	}
	$return .= '</select></td> <td>Change to</td> ';
	$return .= "<td style='width:34%;'><select style='width:50%;' id='vari_attr_to_change_" . $attribute_name . "'>";
	$return .= "<option value='" . $attribute_name . ":any'>Any " . $attribute_label . '</option>';
	foreach ( $attribute_value as $key => $value ) {
		if ( $selected_to_attr === $value->slug ) {
			$selected = 'selected';
		} else {
			$selected = '';
		}
		$return .= '<option value=' . $attribute_name . ':' . $value->slug . ' $selected>' . $value->name . '</option>';
	}
	$return .= '</select></td>';
	$return .= '</tr>';
	if ( isset( $_POST['attr_edit'] ) ) {
		$return_array = array(
			'attribute' => $attribute_name,
			'return'    => $return,
		);
		die( wp_json_encode( $return_array ) );
	}
	echo filter_var( $return );
	exit;
}

/** Get Attributes Action Callback. */
function eh_bep_get_attributes_action_callback() {
	global $wpdb;
	$custom_attribute_values = array();
	check_ajax_referer( 'ajax-eh-bep-nonce', '_ajax_eh_bep_nonce' );
	$attribute_name = isset( $_POST['attrib'] ) ? sanitize_text_field( $_POST['attrib'] ) : '';
	// Get custom attributes.
	$products = $wpdb->get_results(
		"
		SELECT
			postmeta.post_id,
			postmeta.meta_value
		FROM
			{$wpdb->postmeta} AS postmeta
		WHERE
			postmeta.meta_key = '_product_attributes'
			AND COALESCE(postmeta.meta_value, '') != ''
	"
	);
	foreach ( $products as $product ) {
		$product_attributes = maybe_unserialize( $product->meta_value );
		if ( is_array( $product_attributes ) || is_object( $product_attributes ) ) {
			foreach ( $product_attributes as $attribute_slug => $product_attribute ) {
				if ( isset( $product_attribute['is_taxonomy'] ) && 0 === intval( $product_attribute['is_taxonomy'] ) && 'product_shipping_class' !== $attribute_slug ) {
					$values = array_map( 'trim', explode( ' ' . WC_DELIMITER . ' ', $product_attribute['value'] ) );
					foreach ( $values as $value ) {
						$value_slug = $value;
						$custom_attribute_values[ $attribute_slug ][ $value_slug ] = $value;
					}
				}
			}
		}
	}
	if ( count( $custom_attribute_values ) > 0 ) {
		foreach ( $custom_attribute_values as $key => $value ) {
			// In order to differentiate global and custom attributes.
			if ( 'custom_' . $key === $attribute_name ) {
				if ( isset( $_POST['attr_and'] ) ) {
					$return = "<optgroup label='" . ucfirst( $key ) . "' id='grp_and_" . $attribute_name . "'>";
				} else {
					$return = "<optgroup label='" . ucfirst( $key ) . "' id='grp_" . $attribute_name . "'>";
				}
				foreach ( $value as $k => $v ) {
					$return .= "<option value=\"'" . $attribute_name . ':custom_' . strtolower( $v ) . "'\">" . $v . '</option>';
				}
				$return .= '</optgroup>';
				echo filter_var( $return );
				exit;
			}
		}
	}
	$attributes = wc_get_attribute_taxonomies();
	foreach ( $attributes as $key => $value ) {
		if ( $attribute_name === $value->attribute_name ) {
			$attribute_name  = $value->attribute_name;
			$attribute_label = $value->attribute_label;
		}
	}
	$attribute_value = get_terms( array(
		'taxonomy' => 'pa_' . $attribute_name,
		'hide_empty' => false,
	) );
	if ( isset( $_POST['attr_and'] ) ) {
		$return = "<optgroup label='" . $attribute_label . "' id='grp_and_" . $attribute_name . "'>";
	} else {
		$return = "<optgroup label='" . $attribute_label . "' id='grp_" . $attribute_name . "'>";
	}
	foreach ( $attribute_value as $key => $value ) {
		$return .= "<option value=\"'pa_" . $attribute_name . ':' . $value->name . "'\">" . $value->name . '</option>';
	}
	if ( $attribute_value ) {
		$any_attribute = 'any_attribute';
		$any           = 'Any ';
		$return       .= "<option value=\"'pa_" . $attribute_name . ':' . $any_attribute . "'\">" . $any . $attribute_name . '</option>';
	}
	$return .= '</optgroup>';
	echo filter_var( $return );
	exit;
}

/** Attributes Action Edit Callback. */
function eh_bep_get_attributes_action_edit_callback() {
	check_ajax_referer( 'ajax-eh-bep-nonce', '_ajax_eh_bep_nonce' );
	$attribute        = '';
	$attributes_array = array();
	$temp_array       = array();
	$array_attr       = isset( $_POST['attributes'] ) ? array_map( 'sanitize_text_field', ( $_POST['attributes'] ) ) : array();
	foreach ( $array_attr as $index => $attributes_val ) {
		$attributes_val = str_replace( "'", '', $attributes_val );
		$attributes_val = stripslashes( stripslashes( $attributes_val ) );
		$attr_val_arr   = explode( ':', $attributes_val );
		$flag_arr       = explode( 'pa_', $attr_val_arr[0] );
		if ( '' === $attribute ) {
			array_push( $temp_array, $attr_val_arr[1] );
			$attribute = $attr_val_arr[0];
		} elseif ( $attr_val_arr[0] !== $attribute ) {
			$temp_flag_arr                         = explode( 'pa_', $attribute );
			$attributes_array[ $temp_flag_arr[1] ] = $temp_array;
			$temp_array                            = array();
			array_push( $temp_array, $attr_val_arr[1] );
			$attribute = $attr_val_arr[0];
		} else {
			array_push( $temp_array, $attr_val_arr[1] );
		}
	}
	$attributes_array[ $flag_arr[1] ] = $temp_array;
	$return                           = '';
	foreach ( $attributes_array as $arr_key => $attr_val ) {
		$attribute_name = $arr_key;
		
		$attributes = wc_get_attribute_taxonomies();
		foreach ( $attributes as $key => $value ) {
			if ( $attribute_name === $value->attribute_name ) {
				$attribute_name  = $value->attribute_name;
				$attribute_label = $value->attribute_label;
			}
		}
		$attribute_value = get_terms( array(
			'taxonomy' => 'pa_' . $attribute_name,
			'hide_empty' => false,
		) );
		if ( isset( $_POST['attr_action'] ) && sanitize_text_field( $_POST['attr_action'] ) === 'or' ) {
			$return .= "<optgroup label='" . $attribute_label . "' id='grp_" . $attribute_name . "'>";
		} else {
			$return .= "<optgroup label='" . $attribute_label . "' id='grp_and_" . $attribute_name . "'>";
		}
		foreach ( $attribute_value as $key => $value ) {
			if ( in_array( $value->name, $attr_val, true ) ) {
				$selected = 'selected';
			} else {
				$selected = '';
			}
			$return .= "<option value=\"'pa_" . $attribute_name . ':' . $value->name . "'\" $selected>" . $value->name . '</option>';
		}
		// This is for any_attribute.because any_attribute doesn't have slug. 
		foreach ( $temp_array as $key => $value ) {
			$selected_any = '';//for selected html.
			if ( 'any_attribute' === $value ) {
				$selected_any = 'selected';
				$return      .= "<option value=\"'pa_{$attribute_name}:any_attribute'\" $selected_any>Any {$attribute_name}</option>";
			} else {
				$return .= "<option value=\"'pa_{$attribute_name}:any_attribute'\" $selected_any>Any {$attribute_name}</option>";
			}		
		}
		$return .= '</optgroup>';
	}
	$return_array = array(
		'attributes'    => array_keys( $attributes_array ),
		'return_select' => $return,
	);
	die( wp_json_encode( $return_array ) );
}

/** Edit Job Callback. */
function elex_bep_edit_job_callback() {
	check_ajax_referer( 'ajax-eh-bep-nonce', '_ajax_eh_bep_nonce' );
	if ( isset( $_POST['file'] ) ) {
		$job_name = sanitize_text_field( $_POST['file'] );
	};
	$val                      = wpFluent()->table( 'elex_bep_jobs' )->where( 'job_name', '=', $job_name)->select( '*' )->first();
		  $val                = (array) $val;
		  $val['filter_data'] = unserialize($val['filter_data']);
		  $val['edit_data']   = unserialize($val['edit_data']);
	if ( isset( $_POST['file'] ) && sanitize_text_field( $_POST['file'] ) === $val['job_name'] ) {
		die( wp_json_encode( $val ) );
	}	
}

/** Run Job Callback. */
function elex_bep_run_job_callback() {
	check_ajax_referer( 'ajax-eh-bep-nonce', '_ajax_eh_bep_nonce' );
	if ( isset( $_POST['file'] ) ) {
		$job_name = sanitize_text_field( $_POST['file'] );
	}
	  $val    = wpFluent()->table( 'elex_bep_jobs' )
				->where( 'job_name', '=', $job_name)
				->select( '*' )
				->first();
		 $val = (array) $val;
		eh_bep_update_product_callback( $val );
}

/** Delete Job Callback. */
function elex_bep_delete_job_callback() {
	global $wpdb;
	$prefix = $wpdb->prefix;
	check_ajax_referer( 'ajax-eh-bep-nonce', '_ajax_eh_bep_nonce' );
	if ( isset( $_POST['file'] ) ) {
		$job_name = sanitize_text_field( $_POST['file'] );
	}
  $job_id            = wpFluent()->table( 'elex_bep_jobs' )->where( 'job_name', '=', $job_name)->select( 'job_id' )->first();
  $cancel_event_jobs = wpFluent()->table( 'elex_bep_bulk_edit_job_schedule' )->where( 'job_id', '=', $job_id->job_id)->where('job_status', '=', 0)->select( 'ID' )->get();
	foreach ( $cancel_event_jobs as $key => $cancel_event_job ) {
		wp_clear_scheduled_hook( 'elex_bep_process_job_schedule', array($cancel_event_job->ID));
	} 
	wpFluent()->table( 'elex_bep_bulk_edit_job_schedule' )->where('job_id', '=', $job_id )->delete();
	wpFluent()->table('elex_bep_job_undo_products')->where('job_id', $job_id)->delete();
	wpFluent()->table( 'elex_bep_jobs' )->where('job_name', '=', $job_name )->delete();

}

/** Cancel Schedule Callback. */
function elex_bep_cancel_schedule_callback() {
	global $wpdb;
	$prefix = $wpdb->prefix;
	check_ajax_referer( 'ajax-eh-bep-nonce', '_ajax_eh_bep_nonce' );
	if ( isset( $_POST['file'] ) ) {
		$job_name = sanitize_text_field( $_POST['file'] );
	}
	$job_id = wpFluent()->table( 'elex_bep_jobs' )->where( 'job_name', '=', $job_name)->select( 'job_id' )->first();
	wpFluent()->table('elex_bep_jobs')->where('job_id', '=', $job_id->job_id)->update(
	array(
		'schedule_on'      => null,
		'revert_on'        => null
		)
		);
	$cancel_event_jobs = wpFluent()->table( 'elex_bep_bulk_edit_job_schedule' )->where( 'job_id', '=', $job_id->job_id)->where('job_status', '=', 0)->select( 'ID' )->get();
	foreach ( $cancel_event_jobs as $key => $cancel_event_job ) {
		wp_clear_scheduled_hook( 'elex_bep_process_job_schedule', array($cancel_event_job->ID));
	} 
	wpFluent()->table( 'elex_bep_bulk_edit_job_schedule' )->where('job_id', '=', $job_id )->delete();
	wpFluent()->table( 'elex_bep_jobs' )->where('job_name', '=', $job_name )->delete();
}



// revert data function.
function update_revert_data( $job_id, $page_no = 1) {
	global $wpdb;
	$prefix            = $wpdb->prefix;
	$limit             = 100;                  
	$offset            = ( $page_no -1 ) * $limit;
	$revert_data       = wpFluent()->table( 'elex_bep_job_undo_products' )->where( 'job_id', '=', $job_id)->offset($offset)->limit($limit)->select( 'undo_product_data' )->get();
	$count             = wpFluent()->table( 'elex_bep_job_undo_products' )->where( 'job_id', '=', $job_id)->count();
	$product_up        = $offset;
	$product_remaining = $count - $product_up;
	if ( 0 !== $offset  ) {
		update_option( 'offset', $product_up );
		update_option( 'product_remaining', $product_remaining );
	}

	$revert_data = array_map(function( $revert_item) {
		return maybe_unserialize($revert_item->undo_product_data);
	}, $revert_data);
	if (count( $revert_data )) {
		eh_bep_undo_update_callback( $revert_data );
		update_revert_data($job_id, ++$page_no);
	} else {
		update_option('offset', 0 );
		update_option( 'product_remaining', 0 );
		wpFluent()->table('elex_bep_jobs')->where('job_id', '=', $job_id)->update( array( 'is_revert_job_complete' => true ) );
	   return false;

	}
} 

/** Display Count. */
function eh_bulk_edit_display_count_callback() {
	check_ajax_referer( 'ajax-eh-bep-nonce', '_ajax_eh_bep_nonce' );
	$value = isset( $_POST['row_count'] ) ? sanitize_text_field( $_POST['row_count'] ) : '';
	update_option( 'eh_bulk_edit_table_row', $value );
	die( 'success' );
}

/** Save Filter Setting Tab. */
function eh_bulk_edit_save_filter_setting_tab_callback() {
	check_ajax_referer( 'ajax-eh-bep-nonce', '_ajax_eh_bep_nonce' );
	$metas_to_save = isset( $_POST['metas_to_save'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['metas_to_save'] ) ) : '';
	update_option( 'eh_bulk_edit_meta_values_to_update', $metas_to_save );
	die();
}

/** Count Products. */
function eh_bep_count_products_callback() {
	check_ajax_referer( 'ajax-eh-bep-nonce', '_ajax_eh_bep_nonce' );
	$filtered_products = xa_bep_get_selected_products();
	die( wp_json_encode( $filtered_products ) );
}


/** Undo Update.
 *
 * @param array $sch_jobs jobs.
 */
function eh_bep_undo_update_callback( $sch_jobs = '' ) {
	set_time_limit( 300 );
	global $wpdb;
	$prefix        = $wpdb->prefix;
	$product_count = 0;
	if ( '' === $sch_jobs ) {
		check_ajax_referer( 'ajax-eh-bep-nonce', '_ajax_eh_bep_nonce' );
		if ( isset( $_POST['file'] ) ) {
			$job_name = sanitize_text_field( $_POST['file'] );
		}
	$job_id = wpFluent()->table( 'elex_bep_jobs' )->where( 'job_name', '=', $job_name)->select( 'job_id' )->first();
	$res    = update_revert_data( $job_id->job_id );
		if ( !$res ) {
			wp_send_json_success('done');
		}
				return;		
	} else {
		$product_data = $sch_jobs;
		$undo_fields  = array();
		foreach ( $sch_jobs as $key => $val ) {
			$undo_fields = array_merge($undo_fields, array_keys($val));
			if ( 'cat_none' === $val['category_opn'] ) {
				unset( $undo_fields['category_opn'] );
				unset( $undo_fields['categories'] );
			}
		}
		$undo_fields = array_unique($undo_fields); 
	}

	include_once 'class-bulk-edit-change-product-type.php';
	include_once 'class-eh-bulk-password-protect.php';
	elex_bep_collect_product_type_array( $product_data );
	foreach ( $product_data as $pid => $product_data ) {
		$product = wc_get_product( $product_data['id'] );
		$pid     = $product_data['id'];

		if ( false === $product ) {
			continue;
		}
		if ( ! empty( $product ) && $product->is_type( 'variation' ) ) {
			$parent_id = ( WC()->version < '2.7.0' ) ? $product->parent->id : $product->get_parent_id();
			$product   = wc_get_product( $product_data['id'] );
		}
		
		if ( eh_bep_in_array_fields_check( 'delete_product', $undo_fields ) && isset( $product_data['delete_product'] ) ) {
			wp_untrash_post( $product_data['delete_product'] );
		}

		//bundle_product undo
		if (is_a($product, 'WC_Product') && $product->is_type('bundle')) {
					
			$bundle        = new WC_Product_Bundle($product->get_id());
			$bundled_items = $bundle->get_bundled_items();
			if ( isset( $product_data['bundle_layout'] ) && ! empty( $product_data['bundle_layout'] ) ) {
				$bundle->set_layout( $product_data['bundle_layout'] );
				$bundle->save();
			}
			if ( isset( $product_data['bundle_from_location'] ) && ! empty( $product_data['bundle_from_location'] ) ) {
				$bundle->set_add_to_cart_form_location( $product_data['bundle_from_location'] );
				$bundle->save();
			}
			if ( isset( $product_data['bundle_item_grouping'] ) && ! empty( $product_data['bundle_item_grouping'] ) ) {
				$bundle->set_group_mode( $product_data['bundle_item_grouping'] );
				$bundle->save();
			}
			if ( isset( $product_data['bundle_min_size'] ) ) {
				$bundle->set_min_bundle_size( $product_data['bundle_min_size'] );
				$bundle->save();
			}
			if ( isset( $product_data['bundle_max_size'] ) ) {
				$bundle->set_max_bundle_size( $product_data['bundle_max_size'] );
				$bundle->save();
			}
			if ( isset( $product_data['bundle_edit_cart'] ) ) {
				$bundle->set_editable_in_cart( $product_data['bundle_edit_cart'] );
				$bundle->save();
			}
			foreach ( $bundled_items as $bundled_item ) {

				$bundled_item_id = $bundled_item->get_id();

				if ( isset( $product_data['bundle_min_qty'] )) {
					elex_update_bundled_item_meta( $bundled_item_id, 'quantity_min', $product_data['bundle_min_qty']);
				}
				if ( isset( $product_data['bundle_max_qty'] )) {
					elex_update_bundled_item_meta( $bundled_item_id, 'quantity_max', $product_data['bundle_max_qty']);
				}
				if ( isset( $product_data['bundle_default_qty'] )) {
					elex_update_bundled_item_meta( $bundled_item_id, 'quantity_default', $product_data['bundle_default_qty']);
				}
				if ( isset( $product_data['bundle_ship_indi'] ) && ! empty( $product_data['bundle_ship_indi'] ) ) {
					elex_update_bundled_item_meta( $bundled_item_id, 'shipped_individually', $product_data['bundle_ship_indi']);
				}	
				if ( isset( $product_data['bundle_optional'] ) && !empty($product_data['bundle_optional']) ) {
					elex_update_bundled_item_meta( $bundled_item_id, 'optional', $product_data['bundle_optional']);
				}
				if ( isset($product_data['bundle_price_individual']) && !empty($product_data['bundle_price_individual']) ) {
					if ('true' == $product_data['bundle_price_individual']) {
						elex_update_bundled_item_meta( $bundled_item_id, 'priced_individually', 'yes');
					} 
				}
				if ( isset($product_data['elex_bundle_discount']) ) {
					elex_update_bundled_item_meta( $bundled_item_id, 'discount', $product_data['elex_bundle_discount']);
				}
					
				// advanced settings
				if ( isset( $product_data['bundle_product_details'] ) && ! empty( $product_data['bundle_product_details'] ) ) {
					if ( 'visible' ==  $product_data['bundle_product_details'] ) {
						elex_update_bundled_item_meta( $bundled_item_id, 'single_product_visibility', $product_data['bundle_product_details'] );

						if ( isset($product_data['bundle_override_title_chkbx']) && !empty($product_data['bundle_override_title_chkbx']) ) {
							elex_update_bundled_item_meta( $bundled_item_id, 'override_title', $product_data['bundle_override_title_chkbx']);

							if ( isset($product_data['bundle_override_title'])  ) {
								elex_update_bundled_item_meta( $bundled_item_id, 'title', $product_data['bundle_override_title']);
							}
						}
						if ( isset($product_data['bundle_override_shortdescr_chkbx']) && !empty($product_data['bundle_override_shortdescr_chkbx']) ) {
							elex_update_bundled_item_meta( $bundled_item_id, 'override_description', $product_data['bundle_override_shortdescr_chkbx']);

							if ( isset($product_data['bundle_override_short_desc']) ) {
								elex_update_bundled_item_meta( $bundled_item_id, 'description', $product_data['bundle_override_short_desc']);
							}
						}
						if ( isset($product_data['bundle_hidetumb']) && !empty($product_data['bundle_hidetumb']) ) {
							elex_update_bundled_item_meta( $bundled_item_id, 'hide_thumbnail', $product_data['bundle_hidetumb']);
						}

					} else {
						elex_update_bundled_item_meta( $bundled_item_id, 'single_product_visibility', $product_data['bundle_product_details'] );
					}
				}
				if ( isset($product_data['bundle_cart_checkout']) && !empty($product_data['bundle_cart_checkout']) ) {
					elex_update_bundled_item_meta( $bundled_item_id, 'cart_visibility', $product_data['bundle_cart_checkout']);
				}
				if ( isset($product_data['bundle_order_details']) && !empty($product_data['bundle_order_details']) ) {
					elex_update_bundled_item_meta( $bundled_item_id, 'order_visibility', $product_data['bundle_order_details']);
				}
				if ( isset($product_data['bundle_price_prod_detail']) && !empty($product_data['bundle_price_prod_detail']) ) {
					elex_update_bundled_item_meta( $bundled_item_id, 'single_product_price_visibility', $product_data['bundle_price_prod_detail']);
				}
				if ( isset($product_data['bundle_price_cart']) && !empty($product_data['bundle_price_cart']) ) {
					elex_update_bundled_item_meta( $bundled_item_id, 'cart_price_visibility', $product_data['bundle_price_cart']);
				}
				if ( isset($product_data['bundle_price_order']) && !empty($product_data['bundle_price_order']) ) {
					elex_update_bundled_item_meta( $bundled_item_id, 'order_price_visibility', $product_data['bundle_price_order']);
				}

			
			}
		}

		// Undo operation for removing created variations.
		if ( eh_bep_in_array_fields_check( 'variation_ids', $undo_fields ) && isset( $product_data['variation_ids'] ) && is_array( $product_data['variation_ids'] ) ) {
			$product_variations = $product->get_children();
			if ( ! empty( $product_variations ) ) {
				// check if there is difference between collected product variations and variations after create variation update.
				$variations_difference = array_diff( $product_variations, $product_data['variation_ids'] );
				// if any differnce found from previous check,delete all those variations from current product.
				foreach ( $variations_difference as $index => $index_id ) {
					$variation = wc_get_product( $index_id );
					$variation->delete( true );
				}
			}
		}

		// Undo Schedule Sale Price Customization.
		$product_type = ( WC()->version < '2.7.0' ) ? $product->product_type : $product->get_type();
		if ( eh_bep_in_array_fields_check( 'sale_price_date_from', $undo_fields ) ) {
			if ( 'variable' !== $product_type ) {
				$regular_price = $product->get_regular_price();
				$sale_price    = $product->get_sale_price();
				if (empty($product_data['sale_price_date_from'] && empty($product_data['sale_price_date_to'] ))) {
					$product->set_date_on_sale_from( '' );
					$product->set_date_on_sale_to( '' );
					$product->save();
				} else {
					elex_bep_schedule_product_sale_price( $product_data['id'], $regular_price, $sale_price, $product_data['sale_price_date_from'], $product_data['sale_price_date_to'] );
				}
				wc_delete_product_transients( $product_data['id'] );
			}
		}

		// Undo Cancel Schedule Sale price 
		if ( eh_bep_in_array_fields_check( 'cancel_schedule_sale_price', $undo_fields ) && isset( $product_data['cancel_schedule_sale_price_from'] ) && isset( $product_data['cancel_schedule_sale_price_to'] ) ) {
			$product_type = $product->get_type();
			if ( 'variable' !== $product_type ) {
				$product->set_date_on_sale_from($product_data['cancel_schedule_sale_price_from']);
				$product->set_date_on_sale_to( $product_data['cancel_schedule_sale_price_to'] );
				$product->save();
			}
		}

		// Undo operation for custom attributes.
		if ( ! empty( $product_data['custom_attribute_action'] ) && 'remove' === $product_data['custom_attribute_action'] ) {
			if ( ! empty( $product_data['removed_custom_attributes_array'] ) ) {
				// Get current product attributes.
				$product_custom_attribute_data = get_post_meta( $pid, '_product_attributes', true );
				// // Merge the deleted custom attributes.
				$undo_custom_attributes_data = array_merge( $product_custom_attribute_data, $product_data['removed_custom_attributes_array'] );
				update_post_meta( $pid, '_product_attributes', $undo_custom_attributes_data );
			}
		}

		if ( eh_bep_in_array_fields_check( 'title', $undo_fields ) && isset( $product_data['title'] ) ) {
			$product->set_name( $product_data['title'] );
			$product->save();

	
		}
		if ( eh_bep_in_array_fields_check( 'sku', $undo_fields ) && isset( $product_data['sku'] ) ) {
			$product->set_sku( $product_data['sku'] );
			$product->save();
		}
		if ( isset( $product_data['catalog'] ) ) {
			if ( WC()->version < '2.7.3' ) {
				$product->set_catalog_visibility( $product_data['catalog'] );
				$product->save();
			} else {
				$options = array_keys( wc_get_product_visibility_options() );
				if ( in_array( $product_data['catalog'], $options, true ) ) {
					$product->set_catalog_visibility( wc_clean( $product_data['catalog'] ) );
					$product->save();
				}
			}
		}
		if ( eh_bep_in_array_fields_check( 'featured', $undo_fields ) && isset( $product_data['featured'] ) ) {
			if ( WC()->version < '2.7.3' ) {
				eh_bep_update_meta_fn( $product_data['id'], '_featured', $product_data['featured'] );
			} else {
					$product->set_featured( wc_clean( $product_data['featured'] ) );
					$product->save();
			}
		}
		if ( eh_bep_in_array_fields_check( 'vari_attribute', $undo_fields ) && isset( $product_data['vari_attribute'] ) ) {
			$product->set_attributes( $product_data['vari_attribute'] );
			$product->save();
		}
		if ( eh_bep_in_array_fields_check( 'main_image', $undo_fields ) && isset( $product_data['main_image'] ) ) {
			if ( empty($product_data['main_image']) ) {
				$product->set_image_id( array() );
				$product->save();
			} else {
				$product->set_image_id( $product_data['main_image'] );
				$product->save();
			}
		}
		if ( eh_bep_in_array_fields_check( 'gallery_images', $undo_fields ) && isset( $product_data['gallery_images'] ) ) {
			if ( empty( $product_data['gallery_images'] )) {
				wpFluent()->table('postmeta')->where('post_id', $product->get_id())->where('meta_key', '_product_image_gallery')->update(['meta_value' => '']); 
			} else {
				$product->set_gallery_image_ids( $product_data['gallery_images'] );
				$product->save();
			}
		}
		if ( isset( $product_data['post_status'] ) ) {
			elex_bep_set_password_for_single_product( $product_data['id'], $product_data['password'], $product_data['post_status'] );
		}
		if ( eh_bep_in_array_fields_check( 'description', $undo_fields ) && isset( $product_data['description'] ) ) {
			$product->set_description( $product_data['description'] );
			$product->save();
		}
		if ( eh_bep_in_array_fields_check( 'short_description', $undo_fields ) && isset( $product_data['short_description'] ) ) {
			$product->set_short_description( $product_data['short_description'] );
			$product->save();
		}
		if ( eh_bep_in_array_fields_check( 'shipping', $undo_fields ) && isset( $product_data['shipping'] ) ) {
			wp_set_object_terms( (int) $product_data['id'], (int) $product_data['shipping'], 'product_shipping_class' );
		}
		if ( eh_bep_in_array_fields_check( 'sale', $undo_fields ) && isset( $product_data['sale'] ) ) {
			$undo_sale_val = $product_data['sale'];
			if ( 0 === intval( $product_data['sale'] ) ) {
				$undo_sale_val = '';
			}
			$product->set_sale_price( $undo_sale_val );
			$product->save();
		}
		if ( eh_bep_in_array_fields_check( 'regular', $undo_fields ) && isset( $product_data['regular'] ) ) {
			if (0 == $product_data['regular'] ) {
				$product->set_regular_price( '' );
				$product->save();
			} else {
				$product->set_regular_price( $product_data['regular'] );
				$product->save();
			}
		}
		if ( $product->get_sale_price() !== '' && $product->get_regular_price() !== '' ) {
			$product->set_price( $product->get_sale_price() );
			$product->save();
		} elseif ( $product->get_sale_price() === '' && $product->get_regular_price() !== '' ) {
			$product->set_price( $product->get_regular_price() );
			$product->save();
		} elseif ( $product->get_sale_price() !== '' && $product->get_regular_price() === '' ) {
			$product->set_price( $product->get_sale_price() );
			$product->save();
		} elseif ( $product->get_sale_price() === '' && $product->get_regular_price() === '' ) {
			$product->set_price( '' );
			$product->save();
		} 
		if ( eh_bep_in_array_fields_check( 'stock_manage', $undo_fields ) && isset( $product_data['stock_manage'] ) ) {
			$product->set_manage_stock( $product_data['stock_manage'] );
			$product->save();
		}
		if ( eh_bep_in_array_fields_check( 'stock_quantity', $undo_fields ) && isset( $product_data['stock_quantity'] ) ) {
			$product->set_stock($product_data['stock_quantity']);
			$product->save();
		}
		if ( eh_bep_in_array_fields_check( 'backorder', $undo_fields ) && isset( $product_data['backorder'] ) ) {
			eh_bep_update_meta_fn( $product_data['id'], '_backorders', $product_data['backorder'] );
		}
		if ( eh_bep_in_array_fields_check( 'stock_status', $undo_fields ) && isset( $product_data['stock_status'] ) ) {
			eh_bep_update_meta_fn( $product_data['id'], '_stock_status', $product_data['stock_status'] );
		}
		if ( eh_bep_in_array_fields_check( 'length', $undo_fields ) && isset( $product_data['length'] ) ) {
			$product->set_length( $product_data['length'] );
			$product->save();
		}
		if ( eh_bep_in_array_fields_check( 'width', $undo_fields ) && isset( $product_data['width'] ) ) {
			$product->set_width( $product_data['width'] );
			$product->save();
		}
		if ( eh_bep_in_array_fields_check( 'height', $undo_fields ) && isset( $product_data['height'] ) ) {
			$product->set_height( $product_data['height'] );
			$product->save();
		}
		if ( eh_bep_in_array_fields_check( 'weight', $undo_fields ) && isset( $product_data['weight'] ) ) {
			$product->set_weight( $product_data['height'] );
			$product->save();
		}
		if ( eh_bep_in_array_fields_check( 'tax_class_action', $undo_fields ) && isset( $product_data['tax_class_action'] ) ) {
			$product->set_tax_class( $product_data['tax_class_action'] );
			$product->save();
		}
		if ( eh_bep_in_array_fields_check( 'tax_status_action', $undo_fields ) && isset( $product_data['tax_status_action'] ) ) {
			$product->set_tax_status( $product_data['tax_status_action'] );
			$product->save();
		}
		if ( eh_bep_in_array_fields_check( 'product_adjustment_hide_price_unregistered', $undo_fields ) && isset( $product_data['product_adjustment_hide_price_unregistered'] ) ) {
			$product->update_meta_data( 'product_adjustment_hide_price_unregistered', $product_data['product_adjustment_hide_price_unregistered'] );
			$product->save();
		}
		if ( eh_bep_in_array_fields_check( 'eh_pricing_adjustment_product_price_user_role', $undo_fields ) && isset( $product_data['eh_pricing_adjustment_product_price_user_role'] ) ) {
			eh_bep_update_meta_fn( $product_data['id'], 'eh_pricing_adjustment_product_price_user_role', $product_data['eh_pricing_adjustment_product_price_user_role'] );
		}
		if ( eh_bep_in_array_fields_check( 'price_adjustment', $undo_fields ) && isset( $product_data['product_based_price_adjustment'] ) ) {
			eh_bep_update_meta_fn( $product_data['id'], 'product_based_price_adjustment', $product_data['product_based_price_adjustment'] );
		}
		if ( eh_bep_in_array_fields_check( 'wf_shipping_unit', $undo_fields ) && isset( $product_data['wf_shipping_unit'] ) ) {
			eh_bep_update_meta_fn( $product_data['id'], '_wf_shipping_unit', $product_data['wf_shipping_unit'] );
		}
		if ( ! empty( $product_data['tag_ids'] ) ) {
			wp_set_object_terms( $product_data['id'], array_map( 'intval', $product_data['tag_ids'] ), 'product_tag' );
		}
		if ( isset( $product_data['custom_meta'] ) ) {
			if ( isset( $_POST['file'] ) && '' !== $_POST['file'] ) {
				$job_name       = sanitize_text_field( $_POST['file'] );
				$scheduled_jobs = wpFluent()->table('elex_bep_jobs')->where('job_name', '=', $job_name)->select('*')->get();

					$scheduled_jobs = reset($scheduled_jobs);
					$scheduled_jobs = (array) $scheduled_jobs;
					$meta_fields    = unserialize( $scheduled_jobs['filter_data']);
					$keys           = $meta_fields['meta_fields'];
			} else {
				$keys = get_option( 'eh_bulk_edit_meta_values_to_update' );
			}
			if ( ! empty( $keys ) ) {
				$key_size = count( $keys );
				for ( $i = 0; $i < $key_size; $i++ ) {
					$product->update_meta_data( $keys[ $i ], $product_data['custom_meta'][ $i ] );
					$product->save();
				}
			}
		}
		if ( eh_bep_in_array_fields_check( 'categories', $undo_fields ) ) {
			wp_set_object_terms( $product_data['id'], $product_data['categories'], 'product_cat' );
		}
		if ( eh_bep_in_array_fields_check( 'attributes', $undo_fields ) && isset( $product_data['attributes'] ) ) {

			if ( ! empty( $product_data['attributes'] ) || '' !== $product_data['attributes'] && 'variation' !== $product_type ) {
				foreach ( $product_data['attributes'] as $attr_name => $attr_details ) {
					$is_vari = $product_data['attributes'][ $attr_name ]['is_variation'];
					$is_visi = $product_data['attributes'][ $attr_name ]['is_visible'];

					$thedata = array(
						$attr_name => array(
							'name'         => $attr_details['name'],
							'is_visible'   => $is_visi,
							'is_taxonomy'  => '0',
							'is_variation' => $is_vari,
						),
					);

					$_product_attr = get_post_meta( $pid, '_product_attributes', true );
					if ( ! empty( $_product_attr ) ) {
						update_post_meta( $pid, '_product_attributes', array_merge( $_product_attr, $thedata ) );
					} else {
						update_post_meta( $pid, '_product_attributes', $thedata );
					}

				}
				
			}
			$_product_attributes = get_post_meta( $pid, '_product_attributes', true );
			foreach ( $_product_attributes as $key => $val ) {
				$_product_attributes[ $key ]['value'] = wc_get_product_terms( $product_data['id'], $key );
			}
			foreach ( $_product_attributes as $key2 => $val2 ) {
				foreach ( $_product_attributes[ $key2 ]['value'] as $k => $v ) {
					wp_remove_object_terms( $product_data['id'], $v->name, $key2 );
				}
			}

			$is_vari = 0;
			$i       = 0;
			if ( empty( $product_data['attributes'] ) ) {
				update_post_meta( $pid, '_product_attributes', array() );
			} else {

				foreach ( $product_data['attributes'] as $attr_name => $attr_details ) {
					$is_vari     = $product_data['attributes'][ $attr_name ]['is_variation'];
					$is_visi     = $product_data['attributes'][ $attr_name ]['is_visible'];
					$is_taxonomy = $product_data['attributes'][ $attr_name ]['is_taxonomy'];
					if ( $is_taxonomy ) {
						foreach ( $product_data['attributes'][ $attr_name ]['value'] as $att_ind => $attr_value ) {
							wp_set_object_terms( $product_data['id'], $attr_value->name, $attr_name, true );
							$thedata = array(
								$attr_name => array(
									'name'         => $attr_name,
									'value'        => $attr_value,
									'is_visible'   => $is_visi,
									'is_taxonomy'  => '1',
									'is_variation' => $is_vari,
								),
							);
							if ( 0 === $i ) {
								update_post_meta( $pid, '_product_attributes', $thedata );
								$i++;
							} else {
								$_product_attr = get_post_meta( $pid, '_product_attributes', true );
								if ( ! empty( $_product_attr ) ) {
									update_post_meta( $pid, '_product_attributes', array_merge( $_product_attr, $thedata ) );
								} else {
								   update_post_meta( $pid, '_product_attributes', $thedata );
								}
							}
						}
					} else {
							wp_set_object_terms( $product_data['id'], $attr_details['name'], $attr_name, true );
							$thedata = array(
								$attr_name => array(
									'name'         => $attr_details['name'],
									'value'        => $attr_details['value'],
									'is_visible'   => $is_visi,
									'is_taxonomy'  => '0',
									'is_variation' => $is_vari,
								),
							);
							if ( 0 === $i ) {
								update_post_meta( $pid, '_product_attributes', $thedata );
								$i++;
							} else {
								$_product_attr = get_post_meta( $pid, '_product_attributes', true );
								if ( ! empty( $_product_attr ) ) {
									update_post_meta( $pid, '_product_attributes', array_merge( $_product_attr, $thedata ) );
								} else {
									update_post_meta( $pid, '_product_attributes', $thedata );
								}
							}
					}
				}
			}
		}

		$product_count++;
		wc_delete_product_transients( $product_data['id'] );
	}
}


/** In Array Check.
 *
 * @param string $key key.
 * @param array  $array array.
 */
function eh_bep_in_array_fields_check( $key, $array ) {
	if ( empty( $array ) ) {
		return;
	}
	if ( in_array( $key, $array, true ) ) {
		return true;
	} else {
		return false;
	}
}

/** Custom rounding.
 *
 * @param number $number number.
 * @param number $significance significance.
 */
function eh_bep_round_ceiling( $number, $significance = 1 ) {
	return ( is_numeric( $number ) && is_numeric( $significance ) ) ? ( ceil( $number / $significance ) * $significance ) : false;
}

/** Update product callback.
 *
 * @param array $sch_jobs jobs.
 */
function eh_bep_update_product_callback( $sch_jobs = '' ) {
	global $wpdb;
	$prefix = $wpdb->prefix;
	set_time_limit( 0 );
	if ( '' === $sch_jobs ) {
		check_ajax_referer( 'ajax-eh-bep-nonce', '_ajax_eh_bep_nonce' );
		$fields_and_values         = array();
		$fields_and_values['type'] = '';
		if ( isset( $_POST['type'] ) && is_array( $_POST['type'] ) ) {
			$fields_and_values['type'] = array_map( 'sanitize_text_field', wp_unslash( $_POST['type'] ) );
		}
		$fields_and_values['custom_attribute'] = '';
		if ( isset( $_POST['custom_attribute'] ) && is_array( $_POST['custom_attribute'] ) ) {
			$fields_and_values['custom_attribute'] = array_map( 'sanitize_text_field', wp_unslash( $_POST['custom_attribute'] ) );
		}

		$fields_and_values['custom_attribute_values'] = '';
		if ( isset( $_POST['custom_attribute_values'] ) && is_array( $_POST['custom_attribute_values'] ) ) {
			$fields_and_values['custom_attribute_values'] = array_map( 'sanitize_text_field', wp_unslash( $_POST['custom_attribute_values'] ) );
		}

		// Custom Attribute.
		if ( isset( $_POST['custom_attribute_to_edit'] ) ) {
			$fields_and_values['custom_attribute_to_edit'] = sanitize_text_field( $_POST['custom_attribute_to_edit'] );
		}
		if ( isset( $_POST['custom_attribute_action'] ) ) {
			$fields_and_values['custom_attribute_action'] = sanitize_text_field( $_POST['custom_attribute_action'] );
		}

		// tags
		$fields_and_values['tag_action'] = '';
		if ( isset( $_POST['tag_action'] ) ) {
			$fields_and_values['tag_action'] = sanitize_text_field( $_POST['tag_action'] );
		}
		$fields_and_values['tag_values'] = '';
		if ( isset( $_POST['tag_values'] ) && is_array( $_POST['tag_values'] ) ) {
			$fields_and_values['tag_values'] = array_map( 'sanitize_text_field', ( $_POST['tag_values'] ) );
			$fields_and_values['tag_values'] = array_map( 'intval', $fields_and_values['tag_values'] );
			$fields_and_values['tag_values'] = array_unique( $fields_and_values['tag_values'] );
		}
		$fields_and_values['pid'] = '';
		// Exclude unchecked products for update.
		$unchecked_product_ids = ! empty( get_option( 'elex_bep_filter_checkbox_data' ) ) ? array_map( 'sanitize_text_field', ( get_option( 'elex_bep_filter_checkbox_data' ) ) ) : array();
		if ( isset( $_POST['pid'] ) && is_array( $_POST['pid'] ) ) {
			$filtered_product_ids     = array_map( 'sanitize_text_field', wp_unslash( $_POST['pid'] ) );
			$fields_and_values['pid'] = array_diff( $filtered_product_ids, $unchecked_product_ids );
		}
		if ( isset( $_POST['index_val'] ) ) {
			$fields_and_values['index_val'] = sanitize_text_field( $_POST['index_val'] );
		}
		if ( isset( $_POST['chunk_length'] ) ) {
			$fields_and_values['chunk_length'] = sanitize_text_field( $_POST['chunk_length'] );
		}
		$fields_and_values['attribute_value'] = '';
		if ( isset( $_POST['attribute_value'] ) && is_array( $_POST['attribute_value'] ) ) {
			$fields_and_values['attribute_value'] = array_map( 'sanitize_text_field', ( $_POST['attribute_value'] ) );
		}
		if ( isset( $_POST['attribute_action'] ) ) {
			$fields_and_values['attribute_action'] = sanitize_text_field( $_POST['attribute_action'] );
		}
		$fields_and_values['new_attribute_values'] = '';
		if ( isset( $_POST['new_attribute_values'] ) && is_array( $_POST['new_attribute_values'] ) ) {
			$fields_and_values['new_attribute_values'] = array_map( 'sanitize_text_field', wp_unslash( $_POST['new_attribute_values'] ) );
		}
		if ( isset( $_POST['attribute_variation'] ) ) {
			$fields_and_values['attribute_variation'] = sanitize_text_field( $_POST['attribute_variation'] );
		}
		$fields_and_values['categories_to_update'] = '';
		if ( isset( $_POST['categories_to_update'] ) && is_array( $_POST['categories_to_update'] ) ) {
			$fields_and_values['categories_to_update'] = array_map( 'sanitize_text_field', wp_unslash( $_POST['categories_to_update'] ) );
		}
		if ( isset( $_POST['category_update_option'] ) ) {
			$fields_and_values['category_update_option'] = sanitize_text_field( $_POST['category_update_option'] );
		}
		if ( isset( $_POST['undo_update_op'] ) ) {
			$fields_and_values['undo_update_op'] = sanitize_text_field( $_POST['undo_update_op'] );
		}
		if ( isset( $_POST['shipping_unit'] ) ) {
			$fields_and_values['shipping_unit'] = sanitize_text_field( $_POST['shipping_unit'] );
		}
		if ( isset( $_POST['shipping_unit_select'] ) ) {
			$fields_and_values['shipping_unit_select'] = sanitize_text_field( $_POST['shipping_unit_select'] );
		}
		if ( isset( $_POST['title_select'] ) ) {
			$fields_and_values['title_select'] = sanitize_text_field( $_POST['title_select'] );
		}
		if ( isset( $_POST['sku_select'] ) ) {
			$fields_and_values['sku_select'] = sanitize_text_field( $_POST['sku_select'] );
		}
		if ( isset( $_POST['catalog_select'] ) ) {
			$fields_and_values['catalog_select'] = sanitize_text_field( $_POST['catalog_select'] );
		}
		if ( isset( $_POST['is_featured'] ) ) {
			$fields_and_values['is_featured'] = sanitize_text_field( $_POST['is_featured'] );
		}
		if ( isset( $_POST['is_product_type'] ) ) {
			$fields_and_values['is_product_type'] = sanitize_text_field( $_POST['is_product_type'] );
		}
		if ( isset( $_POST['shipping_select'] ) ) {
			$fields_and_values['shipping_select'] = sanitize_text_field( $_POST['shipping_select'] );
		}
		if ( isset( $_POST['sale_select'] ) ) {
			$fields_and_values['sale_select'] = sanitize_text_field( $_POST['sale_select'] );
		}
		if ( isset( $_POST['sale_round_select'] ) ) {
			$fields_and_values['sale_round_select'] = sanitize_text_field( $_POST['sale_round_select'] );
		}
		if ( isset( $_POST['regular_check_val'] ) ) {
			$fields_and_values['regular_check_val'] = sanitize_text_field( $_POST['regular_check_val'] );
		}
		if ( isset( $_POST['regular_round_select'] ) ) {
			$fields_and_values['regular_round_select'] = sanitize_text_field( $_POST['regular_round_select'] );
		}
		if ( isset( $_POST['regular_select'] ) ) {
			$fields_and_values['regular_select'] = sanitize_text_field( $_POST['regular_select'] );
		}
		if ( isset( $_POST['stock_manage_select'] ) ) {
			$fields_and_values['stock_manage_select'] = sanitize_text_field( $_POST['stock_manage_select'] );
		}
		if ( isset( $_POST['quantity_select'] ) ) {
			$fields_and_values['quantity_select'] = sanitize_text_field( $_POST['quantity_select'] );
		}
		if ( isset( $_POST['backorder_select'] ) ) {
			$fields_and_values['backorder_select'] = sanitize_text_field( $_POST['backorder_select'] );
		}
		if ( isset( $_POST['stock_status_select'] ) ) {
			$fields_and_values['stock_status_select'] = sanitize_text_field( $_POST['stock_status_select'] );
		}
		if ( isset( $_POST['length_select'] ) ) {
			$fields_and_values['length_select'] = sanitize_text_field( $_POST['length_select'] );
		}
		if ( isset( $_POST['width_select'] ) ) {
			$fields_and_values['width_select'] = sanitize_text_field( $_POST['width_select'] );
		}
		if ( isset( $_POST['height_select'] ) ) {
			$fields_and_values['height_select'] = sanitize_text_field( $_POST['height_select'] );
		}
		if ( isset( $_POST['weight_select'] ) ) {
			$fields_and_values['weight_select'] = sanitize_text_field( $_POST['weight_select'] );
		}
		if ( isset( $_POST['title_text'] ) ) {
			$fields_and_values['title_text'] = sanitize_text_field( $_POST['title_text'] );
		}
		if ( isset( $_POST['replace_title_text'] ) ) {
			$fields_and_values['replace_title_text'] = sanitize_text_field( $_POST['replace_title_text'] );
		}
		if ( isset( $_POST['regex_replace_title_text'] ) ) {
			$fields_and_values['regex_replace_title_text'] = sanitize_text_field( $_POST['regex_replace_title_text'] );
		}
		if ( isset( $_POST['sku_text'] ) ) {
			$fields_and_values['sku_text'] = sanitize_text_field( $_POST['sku_text'] );
		}
		if ( isset( $_POST['sku_delimeter'] ) ) {
			$fields_and_values['sku_delimeter'] = sanitize_text_field( $_POST['sku_delimeter'] );
		}
		if ( isset( $_POST['sku_padding'] ) ) {
			$fields_and_values['sku_padding'] = sanitize_text_field( $_POST['sku_padding'] );
		}
		if ( isset( $_POST['sku_replace_text'] ) ) {
			$fields_and_values['sku_replace_text'] = sanitize_text_field( $_POST['sku_replace_text'] );
		}
		if ( isset( $_POST['regex_sku_replace_text'] ) ) {
			$fields_and_values['regex_sku_replace_text'] = sanitize_text_field( $_POST['regex_sku_replace_text'] );
		}
		if ( isset( $_POST['sale_text'] ) ) {
			$fields_and_values['sale_text'] = sanitize_text_field( $_POST['sale_text'] );
		}
		if ( isset( $_POST['sale_round_text'] ) ) {
			$fields_and_values['sale_round_text'] = sanitize_text_field( $_POST['sale_round_text'] );
		}
		if ( isset( $_POST['regular_round_text'] ) ) {
			$fields_and_values['regular_round_text'] = sanitize_text_field( $_POST['regular_round_text'] );
		}
		if ( isset( $_POST['regular_text'] ) ) {
			$fields_and_values['regular_text'] = sanitize_text_field( $_POST['regular_text'] );
		}
		if ( isset( $_POST['quantity_text'] ) ) {
			$fields_and_values['quantity_text'] = sanitize_text_field( $_POST['quantity_text'] );
		}
		if ( isset( $_POST['length_text'] ) ) {
			$fields_and_values['length_text'] = sanitize_text_field( $_POST['length_text'] );
		}
		if ( isset( $_POST['width_text'] ) ) {
			$fields_and_values['width_text'] = sanitize_text_field( $_POST['width_text'] );
		}
		if ( isset( $_POST['height_text'] ) ) {
			$fields_and_values['height_text'] = sanitize_text_field( $_POST['height_text'] );
		}
		if ( isset( $_POST['weight_text'] ) ) {
			$fields_and_values['weight_text'] = sanitize_text_field( $_POST['weight_text'] );
		}
		if ( isset( $_POST['hide_price'] ) ) {
			$fields_and_values['hide_price'] = sanitize_text_field( $_POST['hide_price'] );
		}
		if ( isset( $_POST['hide_price_role'] ) ) {
			$fields_and_values['hide_price_role'] = array_map( 'sanitize_text_field', $_POST['hide_price_role'] );
		}
		if ( isset( $_POST['price_adjustment'] ) ) {
			$fields_and_values['price_adjustment'] = sanitize_text_field( $_POST['price_adjustment'] );
		}
		if ( isset( $_POST['stock_status'] ) && is_array( $_POST['stock_status'] ) ) {
			$fields_and_values['stock_status'] = array_map( 'sanitize_text_field', wp_unslash( $_POST['stock_status'] ) );
		}
		$fields_and_values['regex_flag_sele_title'] = '';
		if ( isset( $_POST['regex_flag_sele_title'] ) && is_array( $_POST['regex_flag_sele_title'] ) ) {
			$fields_and_values['regex_flag_sele_title'] = array_map( 'sanitize_text_field', wp_unslash( $_POST['regex_flag_sele_title'] ) );
		}
		$fields_and_values['regex_flag_sele_sku'] = '';
		if ( isset( $_POST['regex_flag_sele_sku'] ) && is_array( $_POST['regex_flag_sele_sku'] ) ) {
			$fields_and_values['regex_flag_sele_sku'] = array_map( 'sanitize_text_field', wp_unslash( $_POST['regex_flag_sele_sku'] ) );
		}
		if ( isset( $_POST['scheduled_action'] ) ) {
			$fields_and_values['scheduled_action'] = sanitize_text_field( $_POST['scheduled_action'] );
		}
		if ( isset( $_POST['save_job'] ) ) {
			$fields_and_values['save_job'] = sanitize_text_field( $_POST['save_job'] );
		}
		if ( isset( $_POST['schedule_date'] ) ) {
			$fields_and_values['schedule_date'] = sanitize_text_field( $_POST['schedule_date'] );
		}
		if ( isset( $_POST['revert_date'] ) ) {
			$fields_and_values['revert_date'] = sanitize_text_field( $_POST['revert_date'] );
		}
		if ( isset( $_POST['scheduled_hour'] ) ) {
			$fields_and_values['scheduled_hour'] = sanitize_text_field( $_POST['scheduled_hour'] );
		}
		if ( isset( $_POST['scheduled_min'] ) ) {
			$fields_and_values['scheduled_min'] = sanitize_text_field( $_POST['scheduled_min'] );
		}
		if ( isset( $_POST['revert_hour'] ) ) {
			$fields_and_values['revert_hour'] = sanitize_text_field( $_POST['revert_hour'] );
		}
		if ( isset( $_POST['revert_min'] ) ) {
			$fields_and_values['revert_min'] = sanitize_text_field( $_POST['revert_min'] );
		}
		if ( isset( $_POST['schedule_frequency_action'] ) ) {
			$fields_and_values['schedule_frequency_action'] = sanitize_text_field( $_POST['schedule_frequency_action'] );
		}
		$fields_and_values['schedule_weekly_days'] = '';
		if ( isset( $_POST['schedule_weekly_days'] ) && is_array( $_POST['schedule_weekly_days'] ) ) {
			$fields_and_values['schedule_weekly_days'] = array_map( 'sanitize_text_field', wp_unslash( $_POST['schedule_weekly_days'] ) );
		}
		$fields_and_values['schedule_monthly_days'] = '';
		if ( isset( $_POST['schedule_monthly_days'] ) && is_array( $_POST['schedule_monthly_days'] ) ) {
			$fields_and_values['schedule_monthly_days'] = array_map( 'sanitize_text_field', wp_unslash( $_POST['schedule_monthly_days'] ) );
		}
		if ( isset( $_POST['stop_schedule_date'] ) ) {
			$fields_and_values['stop_schedule_date'] = sanitize_text_field( $_POST['stop_schedule_date'] );
		}
		if ( isset( $_POST['stop_hr'] ) ) {
			$fields_and_values['stop_hr'] = sanitize_text_field( $_POST['stop_hr'] );
		}
		if ( isset( $_POST['stop_min'] ) ) {
			$fields_and_values['stop_min'] = sanitize_text_field( $_POST['stop_min'] );
		}
		if ( isset( $_POST['job_name'] ) ) {
			$fields_and_values['job_name'] = sanitize_text_field( $_POST['job_name'] );
		}
		if ( isset( $_POST['create_log_file'] ) ) {
			$fields_and_values['create_log_file'] = sanitize_text_field( $_POST['create_log_file'] );
		}
		if ( isset( $_POST['is_edit_job'] ) ) {
			$fields_and_values['is_edit_job'] = sanitize_text_field( $_POST['is_edit_job'] );
		}
		$fields_and_values['category_filter'] = '';
		if ( isset( $_POST['category_filter'] ) && is_array( $_POST['category_filter'] ) ) {
			$fields_and_values['category_filter'] = array_map( 'sanitize_text_field', wp_unslash( $_POST['category_filter'] ) );
		}
		$fields_and_values['custom_meta'] = '';
		if ( isset( $_POST['custom_meta'] ) && is_array( $_POST['custom_meta'] ) ) {
			$fields_and_values['custom_meta'] = array_map( 'sanitize_text_field', wp_unslash( $_POST['custom_meta'] ) );
		}
		$fields_and_values['meta_fields'] = '';
		if ( isset( $_POST['meta_fields'] ) && is_array( $_POST['meta_fields'] ) ) {
			$fields_and_values['meta_fields'] = array_map( 'sanitize_text_field', wp_unslash( $_POST['meta_fields'] ) );
		}
		if ( isset( $_POST['sub_category_filter'] ) ) {
			$fields_and_values['sub_category_filter'] = sanitize_text_field( $_POST['sub_category_filter'] );
		}
		if ( isset( $_POST['And_cat_check'] ) ) {
			$fields_and_values['And_cat_check'] = sanitize_text_field( $_POST['And_cat_check'] );
		}
		if ( isset( $_POST['filter_product_image_not_exist'] ) ) {
			$fields_and_values['filter_product_image_not_exist'] = sanitize_text_field( $_POST['filter_product_image_not_exist'] );
		}
		if ( isset( $_POST['attribute'] ) ) {
			$fields_and_values['attribute'] = sanitize_text_field( $_POST['attribute'] );
		}
		if ( isset( $_POST['attribute_variation'] ) ) {
			$fields_and_values['attribute_variation'] = sanitize_text_field( $_POST['attribute_variation'] );
		}
		if ( isset( $_POST['attr_visible_action'] ) ) {
			$fields_and_values['attr_visible_action'] = sanitize_text_field( $_POST['attr_visible_action'] );
		}
		if ( isset( $_POST['product_title_select'] ) ) {
			$fields_and_values['product_title_select'] = sanitize_text_field( $_POST['product_title_select'] );
		}
		if ( isset( $_POST['product_title_text'] ) ) {
			$fields_and_values['product_title_text'] = sanitize_text_field( $_POST['product_title_text'] );
		}
		$fields_and_values['regex_flags'] = '';
		if ( isset( $_POST['regex_flags'] ) && is_array( $_POST['regex_flags'] ) ) {
			$fields_and_values['regex_flags'] = array_map( 'sanitize_text_field', wp_unslash( $_POST['regex_flags'] ) );
		}
		/** SKU Filter */
		if ( isset( $_POST['product_sku_select_filter'] ) ) {
			$fields_and_values['product_sku_select_filter'] = sanitize_text_field( $_POST['product_sku_select_filter'] );
		}
		if ( isset( $_POST['product_sku_text_filter'] ) ) {
			$fields_and_values['product_sku_text_filter'] = sanitize_text_field( $_POST['product_sku_text_filter'] );
		}

		if ( isset( $_POST['product_description_select'] ) ) {
			$fields_and_values['product_description_select'] = sanitize_text_field( $_POST['product_description_select'] );
		}
		if ( isset( $_POST['product_description_text'] ) ) {
			$fields_and_values['product_description_text'] = sanitize_text_field( $_POST['product_description_text'] );
		}
		$fields_and_values['regex_flags_description'] = '';
		if ( isset( $_POST['regex_flags_description'] ) && is_array( $_POST['regex_flags_description'] ) ) {
			$fields_and_values['regex_flags_description'] = array_map( 'sanitize_text_field', wp_unslash( $_POST['regex_flags_description'] ) );
		}

		if ( isset( $_POST['product_short_description_select'] ) ) {
			$fields_and_values['product_short_description_select'] = sanitize_text_field( $_POST['product_short_description_select'] );
		}
		if ( isset( $_POST['product_short_description_text'] ) ) {
			$fields_and_values['product_short_description_text'] = sanitize_text_field( $_POST['product_short_description_text'] );
		}
		$fields_and_values['regex_flags_short_description'] = '';
		if ( isset( $_POST['regex_flags_short_description'] ) && is_array( $_POST['regex_flags_short_description'] ) ) {
			$fields_and_values['regex_flags_short_description'] = array_map( 'sanitize_text_field', wp_unslash( $_POST['regex_flags_short_description'] ) );
		}

		$fields_and_values['attribute_value_filter'] = '';
		if ( isset( $_POST['attribute_value_filter'] ) && is_array( $_POST['attribute_value_filter'] ) ) {
			$fields_and_values['attribute_value_filter'] = array_map( 'sanitize_text_field', ( $_POST['attribute_value_filter'] ) );
		}
		if ( isset( $_POST['attribute_and'] ) ) {
			$fields_and_values['attribute_and'] = sanitize_text_field( $_POST['attribute_and'] );
		}
		$fields_and_values['attribute_value_and_filter'] = '';
		if ( isset( $_POST['attribute_value_and_filter'] ) && is_array( $_POST['attribute_value_and_filter'] ) ) {
			$fields_and_values['attribute_value_and_filter'] = array_map( 'sanitize_text_field', ( $_POST['attribute_value_and_filter'] ) );
		}
		if ( isset( $_POST['range'] ) ) {
			$fields_and_values['range'] = sanitize_text_field( $_POST['range'] );
		}
		if ( isset( $_POST['desired_price'] ) ) {
			$fields_and_values['desired_price'] = sanitize_text_field( $_POST['desired_price'] );
		}
		if ( isset( $_POST['minimum_price'] ) ) {
			$fields_and_values['minimum_price'] = sanitize_text_field( $_POST['minimum_price'] );
		}
		if ( isset( $_POST['maximum_price'] ) ) {
			$fields_and_values['maximum_price'] = sanitize_text_field( $_POST['maximum_price'] );
		}
		if ( isset( $_POST['range_weight_data'] ) ) {
			$fields_and_values['range_weight_data'] = sanitize_text_field( $_POST['range_weight_data'] );
		}
		if ( isset( $_POST['stock_status_data'] ) ) {
			$fields_and_values['stock_status_data'] = sanitize_text_field( $_POST['stock_status_data'] );
		}
		if ( isset( $_POST['desired_weight'] ) ) {
			$fields_and_values['desired_weight'] = sanitize_text_field( $_POST['desired_weight'] );
		}
		if ( isset( $_POST['minimum_weight'] ) ) {
			$fields_and_values['minimum_weight'] = sanitize_text_field( $_POST['minimum_weight'] );
		}
		if ( isset( $_POST['maximum_weight'] ) ) {
			$fields_and_values['maximum_weight'] = sanitize_text_field( $_POST['maximum_weight'] );
		}
		if ( isset( $_POST['attr_visible_action'] ) ) {
			$fields_and_values['attr_visible_action'] = sanitize_text_field( $_POST['attr_visible_action'] );
		}
		$fields_and_values['exclude_ids'] = '';
		if ( isset( $_POST['exclude_ids'] ) && is_array( $_POST['exclude_ids'] ) ) {
			$fields_and_values['exclude_ids'] = array_merge( array_map( 'sanitize_text_field', wp_unslash( $_POST['exclude_ids'] ) ), $unchecked_product_ids );
		} else { // unchecked ids.
			$fields_and_values['exclude_ids'] = $unchecked_product_ids;
		}
		$fields_and_values['exclude_categories'] = '';
		if ( isset( $_POST['exclude_categories'] ) && is_array( $_POST['exclude_categories'] ) ) {
			$fields_and_values['exclude_categories'] = array_map( 'sanitize_text_field', wp_unslash( $_POST['exclude_categories'] ) );
		}
		if ( isset( $_POST['exclude_subcat_check'] ) ) {
			$fields_and_values['exclude_subcat_check'] = sanitize_text_field( $_POST['exclude_subcat_check'] );
		}
		if ( isset( $_POST['enable_exclude_prods'] ) ) {
			$fields_and_values['enable_exclude_prods'] = sanitize_text_field( $_POST['enable_exclude_prods'] );
		}
		if ( isset( $_POST['undo_sch_job'] ) ) {
			$fields_and_values['undo_sch_job'] = sanitize_text_field( $_POST['undo_sch_job'] );
		}
		if ( isset( $_POST['file'] ) ) {
			$fields_and_values['file'] = sanitize_text_field( $_POST['file'] );
		}
		$fields_and_values['prod_tags'] = '';
		if ( isset( $_POST['prod_tags'] ) && is_array( $_POST['prod_tags'] ) ) {
			$fields_and_values['prod_tags'] = array_map( 'sanitize_text_field', wp_unslash( $_POST['prod_tags'] ) );
		}
		$fields_and_values['vari_attribute'] = '';
		if ( isset( $_POST['vari_attribute'] ) && is_array( $_POST['vari_attribute'] ) ) {
			$fields_and_values['vari_attribute'] = array_map( 'sanitize_text_field', wp_unslash( $_POST['vari_attribute'] ) );
		}
		if ( isset( $_POST['description_action'] ) ) {
			$fields_and_values['description_action'] = sanitize_text_field( $_POST['description_action'] );
		}
		if ( isset( $_POST['short_description_action'] ) ) {
			$fields_and_values['short_description_action'] = sanitize_text_field( $_POST['short_description_action'] );
		}
		if ( isset( $_POST['description_text_data'] ) ) {
			$fields_and_values['description_text_data'] = sanitize_text_field( $_POST['description_text_data'] );
		}
		if ( isset( $_POST['replace_description_text_data'] ) ) {
			$fields_and_values['replace_description_text_data'] = sanitize_text_field( $_POST['replace_description_text_data'] );
		}
		if ( isset( $_POST['short_description_text_data'] ) ) {
			$fields_and_values['short_description_text_data'] = sanitize_text_field( $_POST['short_description_text_data'] );
		}
		if ( isset( $_POST['replace_short_description_text_data'] ) ) {
			$fields_and_values['replace_short_description_text_data'] = sanitize_text_field( $_POST['replace_short_description_text_data'] );
		}
		if ( isset( $_POST['description'] ) ) {
			$fields_and_values['description'] = wp_kses_post( $_POST['description'] );
		}
		if ( isset( $_POST['short_description'] ) ) {
			$fields_and_values['short_description'] = wp_kses_post( $_POST['short_description'] );
		}
		if ( isset( $_POST['delete_product_action'] ) ) {
			$fields_and_values['delete_product_action'] = sanitize_text_field( $_POST['delete_product_action'] );
		}
		if ( isset( $_POST['main_image'] ) ) {
			$fields_and_values['main_image'] = sanitize_text_field( $_POST['main_image'] );
		}
		if ( isset( $_POST['gallery_images_action'] ) ) {
			$fields_and_values['gallery_images_action'] = sanitize_text_field( $_POST['gallery_images_action'] );
		}
		$fields_and_values['gallery_images'] = '';
		if ( isset( $_POST['gallery_images'] ) && is_array( $_POST['gallery_images'] ) ) {
			$fields_and_values['gallery_images'] = array_map( 'sanitize_text_field', wp_unslash( $_POST['gallery_images'] ) );
		}
		if ( isset( $_POST['tax_status_action'] ) ) {
			$fields_and_values['tax_status_action'] = sanitize_text_field( $_POST['tax_status_action'] );
		}
		if ( isset( $_POST['tax_class_action'] ) ) {
			$fields_and_values['tax_class_action'] = sanitize_text_field( $_POST['tax_class_action'] );
		}
		if ( isset( $_POST['product_visibility_action'] ) ) {
			$fields_and_values['product_visibility_action'] = sanitize_text_field( $_POST['product_visibility_action'] );
		}

		if ( isset( $_POST['category_password'] ) ) {
			$fields_and_values['category_password'] = sanitize_text_field( $_POST['category_password'] );
		}
		if ( isset( $_POST['create_variations'] ) ) {
			$fields_and_values['create_variations'] = sanitize_text_field( $_POST['create_variations'] );
		}
		if ( isset( $_POST['variation_regular_price'] ) ) {
			$fields_and_values['variation_regular_price'] = sanitize_text_field( $_POST['variation_regular_price'] );
		}
		if ( isset( $_POST['variation_sale_price'] ) ) {
			$fields_and_values['variation_sale_price'] = sanitize_text_field( $_POST['variation_sale_price'] );
		}
		//bundle_product		

		if ( isset( $_POST['bundle_layout'] ) ) {
			$fields_and_values['bundle_layout'] = sanitize_text_field( $_POST['bundle_layout'] );
		}
		if ( isset( $_POST['bundle_from_location'] ) ) {
			$fields_and_values['bundle_from_location'] = sanitize_text_field( $_POST['bundle_from_location'] );
		}
		if ( isset( $_POST['bundle_item_grouping'] ) ) {
			$fields_and_values['bundle_item_grouping'] = sanitize_text_field( $_POST['bundle_item_grouping'] );
		}
		if ( isset( $_POST['bundle_min_size'] ) ) {
			$fields_and_values['bundle_min_size'] = sanitize_text_field( $_POST['bundle_min_size'] );
		}
		if ( isset( $_POST['bundle_max_size'] ) ) {
			$fields_and_values['bundle_max_size'] = sanitize_text_field( $_POST['bundle_max_size'] );
		}
		if ( isset( $_POST['bundle_edit_cart'] ) ) {
			$fields_and_values['bundle_edit_cart'] = sanitize_text_field( $_POST['bundle_edit_cart'] );
		}


		if ( isset( $_POST['bundle_min_qty'] ) ) {
			$fields_and_values['bundle_min_qty'] = sanitize_text_field( $_POST['bundle_min_qty'] );
		}
		if ( isset( $_POST['bundle_max_qty'] ) ) {
			$fields_and_values['bundle_max_qty'] = sanitize_text_field( $_POST['bundle_max_qty'] );
		}
		if ( isset( $_POST['bundle_default_qty'] ) ) {
			$fields_and_values['bundle_default_qty'] = sanitize_text_field( $_POST['bundle_default_qty'] );
		}
		if ( isset( $_POST['bundle_optional'] ) ) {
			$fields_and_values['bundle_optional'] = sanitize_text_field( $_POST['bundle_optional'] );
		}
		if ( isset( $_POST['bundle_ship_indi'] ) ) {
			$fields_and_values['bundle_ship_indi'] = sanitize_text_field( $_POST['bundle_ship_indi'] );
		}
		if ( isset( $_POST['bundle_price_individual'] ) ) {
			$fields_and_values['bundle_price_individual'] = sanitize_text_field( $_POST['bundle_price_individual'] );
		}
		if ( isset( $_POST['elex_bundle_discount'] ) ) {
			$fields_and_values['elex_bundle_discount'] = sanitize_text_field( $_POST['elex_bundle_discount'] );
		}

		if ( isset( $_POST['bundle_product_details'] ) ) {
			$fields_and_values['bundle_product_details'] = sanitize_text_field( $_POST['bundle_product_details'] );
		}
		if ( isset( $_POST['bundle_override_title_chkbx'] ) ) {
			$fields_and_values['bundle_override_title_chkbx'] = sanitize_text_field( $_POST['bundle_override_title_chkbx'] );
		}
		if ( isset( $_POST['bundle_override_title'] ) ) {
			$fields_and_values['bundle_override_title'] = sanitize_text_field( $_POST['bundle_override_title'] );
		}
		if ( isset( $_POST['bundle_override_shortdescr_chkbx'] ) ) {
			$fields_and_values['bundle_override_shortdescr_chkbx'] = sanitize_text_field( $_POST['bundle_override_shortdescr_chkbx'] );
		}
		if ( isset( $_POST['bundle_override_short_desc'] ) ) {
			$fields_and_values['bundle_override_short_desc'] = sanitize_text_field( $_POST['bundle_override_short_desc'] );
		}
		if ( isset( $_POST['bundle_hidetumb'] ) ) {
			$fields_and_values['bundle_hidetumb'] = sanitize_text_field( $_POST['bundle_hidetumb'] );
		}
		if ( isset( $_POST['bundle_cart_checkout'] ) ) {
			$fields_and_values['bundle_cart_checkout'] = sanitize_text_field( $_POST['bundle_cart_checkout'] );
		}
		if ( isset( $_POST['bundle_order_details'] ) ) {
			$fields_and_values['bundle_order_details'] = sanitize_text_field( $_POST['bundle_order_details'] );
		}
		if ( isset( $_POST['bundle_price_prod_detail'] ) ) {
			$fields_and_values['bundle_price_prod_detail'] = sanitize_text_field( $_POST['bundle_price_prod_detail'] );
		}
		if ( isset( $_POST['bundle_price_cart'] ) ) {
			$fields_and_values['bundle_price_cart'] = sanitize_text_field( $_POST['bundle_price_cart'] );
		}
		if ( isset( $_POST['bundle_price_order'] ) ) {
			$fields_and_values['bundle_price_order'] = sanitize_text_field( $_POST['bundle_price_order'] );
		}

		// Schedule Sale Price Customization.
		if ( isset( $_POST['schedule_sale_price'] ) ) {
			$fields_and_values['schedule_sale_price'] = sanitize_text_field( $_POST['schedule_sale_price'] );
		}
		if ( isset( $_POST['sale_price_date_from'] ) ) {
			$fields_and_values['sale_price_date_from'] = sanitize_text_field( $_POST['sale_price_date_from'] );
		}
		if ( isset( $_POST['sale_price_date_to'] ) ) {
			$fields_and_values['sale_price_date_to'] = sanitize_text_field( $_POST['sale_price_date_to'] );
		}
		// Cancel Schedule Sale price.
		if ( isset( $_POST['cancel_schedule_sale_price'] ) ) {
			$fields_and_values['cancel_schedule_sale_price'] = sanitize_text_field( $_POST['cancel_schedule_sale_price'] );
		}
	} else {
		$fields_and_values = maybe_unserialize( $sch_jobs['filter_data']);
		if (isset($sch_jobs['job_id'])) {
			$_POST['job_id'] = $sch_jobs['job_id'];
		}
	}
		include_once 'insert_functions.php';

	if (isset($sch_jobs['job_name'])) {
		$job_name = $sch_jobs['job_name'];
		$job_id   = $sch_jobs['job_id'];
	}
	if ( 'true' === $fields_and_values['is_edit_job'] ) {
		$job_name = $fields_and_values['job_name'];
	$query        = wpFluent()->table('elex_bep_jobs')->where('job_name', '=', $job_name)->select('job_id')->first();
	$job_id       =$query->job_id;
	}

	if (!isset($job_id, $job_name) && 'false' === $fields_and_values['is_edit_job']) {
		if (!isset($_POST['job_id'])) {
			$job_name = $fields_and_values['job_name'];
			if ( '' == $fields_and_values['job_name'] ) {

				$job_count = $wpdb->get_var(
					$wpdb->prepare(
						"SELECT MAX(job_id) FROM {$wpdb->prefix}elex_bep_jobs"
					)
				);
				$count     = ++$job_count;
				$job_name  = 'job_' . $count;
			} else {
				$job_name = $fields_and_values['job_name'];
				$query    = wpFluent()->table('elex_bep_jobs')->where('job_name', '=', $job_name)->select('job_name')->first();
				if ( $query ) {
					$job_count = $wpdb->get_var(
					$wpdb->prepare(
						"SELECT MAX(job_id) FROM {$wpdb->prefix}elex_bep_jobs"
					)
				);
				$count         = ++$job_count;
					$job_name  = $job_name . '_' . $count;
				}

			}

			$job_id = job_name_insert($job_name);
		} else {
			$job_id   = isset($_POST['job_id']) ? sanitize_text_field($_POST['job_id']) : '';
			$query    = wpFluent()->table('elex_bep_jobs')->where('job_id', '=', $job_id)->select('job_name')->first();
			$job_name = $query->job_name;
		}	
	}
	$selected_products                 = $fields_and_values['pid'];
	$undo_product_data                 = array();
	$undo_variation_data               = array();
	$product_data                      = array();
	$edit_data                         = array();
	$undo_update                       = $fields_and_values['undo_update_op'];
	$edit_data['undo_update']          = $undo_update;
	$title_select                      = $fields_and_values['title_select'];
	$edit_data['title_select']         = $title_select;
	$sku_select                        = $fields_and_values['sku_select'];
	$edit_data['sku_select']           = $sku_select;
	$catalog_select                    = $fields_and_values['catalog_select'];
	$edit_data['catalog_select']       = $catalog_select;
	$featured                          = $fields_and_values['is_featured'];
	$edit_data['featured']             = $featured;
	$is_product_type                   = $fields_and_values['is_product_type'];
	$edit_data['is_product_type']      = $is_product_type;
	$shipping_select                   = $fields_and_values['shipping_select'];
	$edit_data['shipping_select']      = $shipping_select;
	$sale_select                       = $fields_and_values['sale_select'];
	$edit_data['sale_select']          = $sale_select;
	$sale_round_select                 = $fields_and_values['sale_round_select'];
	$edit_data['sale_round_select']    = $sale_round_select;
	$regular_select                    = $fields_and_values['regular_select'];
	$edit_data['regular_select']       = $regular_select;
	$regular_round_select              = $fields_and_values['regular_round_select'];
	$edit_data['regular_round_select'] = $regular_round_select;
	$stock_manage_select               = $fields_and_values['stock_manage_select'];
	$edit_data['stock_manage_select']  = $stock_manage_select;
	$quantity_select                   = $fields_and_values['quantity_select'];
	$edit_data['quantity_select']      = $quantity_select;
	$backorder_select                  = $fields_and_values['backorder_select'];
	$edit_data['backorder_select']     = $backorder_select;
	$stock_status_select               = $fields_and_values['stock_status_select'];
	$edit_data['stock_status_select']  = $stock_status_select;
	$attribute_action                  = $fields_and_values['attribute_action'];
	$edit_data['attribute_action']     = $attribute_action;
	$edit_data['tag_values']           = $fields_and_values['tag_values'];
	$edit_data['tag_action']           = $fields_and_values['tag_action'];
	// Custom Attribute.
	$custom_attribute_action                     = $fields_and_values['custom_attribute_action'];
	$edit_data['custom_attribute_action']        = $custom_attribute_action;
	$custom_attribute_to_edit                    = $fields_and_values['custom_attribute_to_edit'];
	$edit_data['custom_attribute_to_edit']       = $custom_attribute_to_edit;
	$tax_status_action                           = $fields_and_values['tax_status_action'];
	$edit_data['tax_status_action']              = $tax_status_action;
	$tax_class_action                            = $fields_and_values['tax_class_action'];
	$edit_data['tax_class_action']               = $tax_class_action;
	$length_select                               = $fields_and_values['length_select'];
	$edit_data['length_select']                  = $length_select;
	$width_select                                = $fields_and_values['width_select'];
	$edit_data['width_select']                   = $width_select;
	$height_select                               = $fields_and_values['height_select'];
	$edit_data['height_select']                  = $height_select;
	$weight_select                               = $fields_and_values['weight_select'];
	$edit_data['weight_select']                  = $weight_select;
	$title_text                                  = $fields_and_values['title_text'];
	$edit_data['title_text']                     = $title_text;
	$and_cat_check                               = $fields_and_values['And_cat_check'];
	$edit_data['And_cat_check']                  = $and_cat_check;
	$filter_product_image_not_exist              = $fields_and_values['filter_product_image_not_exist'];
	$edit_data['filter_product_image_not_exist'] = $filter_product_image_not_exist;
	$replace_title_text                          = sanitize_text_field( $fields_and_values['replace_title_text'] );
	$edit_data['replace_title_text']             = $replace_title_text;
	$regex_replace_title_text                    = sanitize_text_field( $fields_and_values['regex_replace_title_text'] );
	$edit_data['regex_replace_title_text']       = $regex_replace_title_text;
	$sku_text                                    = $fields_and_values['sku_text'];
	$edit_data['sku_text']                       = $sku_text;
	$sku_delimeter                               = $fields_and_values['sku_delimeter'];
	$edit_data['sku_delimeter']                  = $sku_delimeter;
	$sku_padding                                 = $fields_and_values['sku_padding'];
	$edit_data['sku_padding']                    = $sku_padding;
	$sku_replace_text                            = sanitize_text_field( $fields_and_values['sku_replace_text'] );
	$edit_data['sku_replace_text']               = $sku_replace_text;
	$regex_sku_replace_text                      = sanitize_text_field( $fields_and_values['regex_sku_replace_text'] );
	$edit_data['regex_sku_replace_text']         = $regex_sku_replace_text;
	$sale_text                                   = $fields_and_values['sale_text'];
	$edit_data['sale_text']                      = $sale_text;
	$sale_round_text                             = isset( $fields_and_values['sale_round_text'] ) ? $fields_and_values['sale_round_text'] : '';
	$edit_data['sale_round_text']                = $sale_round_text;
	$regular_text                                = $fields_and_values['regular_text'];
	$edit_data['regular_text']                   = $regular_text;
	$regular_round_text                          = isset( $fields_and_values['regular_round_text'] ) ? $fields_and_values['regular_round_text'] : '';
	$edit_data['regular_round_text']             = $regular_round_text;
	$quantity_text                               = $fields_and_values['quantity_text'];
	$edit_data['quantity_text']                  = $quantity_text;
	$length_text                                 = $fields_and_values['length_text'];
	$edit_data['length_text']                    = $length_text;
	$width_text                                  = $fields_and_values['width_text'];
	$edit_data['width_text']                     = $width_text;
	$height_text                                 = $fields_and_values['height_text'];
	$edit_data['height_text']                    = $height_text;
	$weight_text                                 = $fields_and_values['weight_text'];
	$edit_data['weight_text']                    = $weight_text;
	$hide_price                                  = $fields_and_values['hide_price'];
	$edit_data['hide_price']                     = $hide_price;
	$hide_price_role                             = ( ! empty( $fields_and_values['hide_price_role'] ) ) ? $fields_and_values['hide_price_role'] : array();
	$edit_data['hide_price_role']                = $hide_price_role;
	$price_adjustment                            = $fields_and_values['price_adjustment'];
	$edit_data['price_adjustment']               = $price_adjustment;
	$shipping_unit                               = sanitize_text_field( $fields_and_values['shipping_unit'] );
	$edit_data['shipping_unit']                  = $shipping_unit;
	$shipping_unit_select                        = $fields_and_values['shipping_unit_select'];
	$edit_data['shipping_unit_select']           = $shipping_unit_select;
	$edit_data['categories']                     = '';
	$edit_data['category_opn']                   = $fields_and_values['category_update_option'];
	$edit_data['vari_attribute']                 = '';
	$edit_data['gallery_images']                 = '';

	$visibility_action                      = $fields_and_values['product_visibility_action'];
	$edit_data['product_visibility_action'] = $visibility_action;
	$category_password                      = $fields_and_values['category_password'];
	$edit_data['category_password']         = $category_password;
	$create_variations                      = $fields_and_values['create_variations'];
	$edit_data['variations']                = $create_variations;
	$schedule_sale_price                    = $fields_and_values['schedule_sale_price'];
	$edit_data['schedule_sale_price']       = $schedule_sale_price;
	
	/**
	 * Check if the WooCommerce Product Bundles plugin is active.
	 *
	 * This checks if the 'woocommerce-product-bundles/woocommerce-product-bundles.php' plugin
	 * is active by utilizing the 'active_plugins' filter to retrieve the list of currently active plugins.
	 *
	 * @hook active_plugins
	 * @since 1.0.0
	 */
	if (in_array( 'woocommerce-product-bundles/woocommerce-product-bundles.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true )) {
		$edit_data['bundle_layout']                    = isset($fields_and_values['bundle_layout']) ? $fields_and_values['bundle_layout'] : '';
		$edit_data['bundle_from_location']             = isset($fields_and_values['bundle_from_location']) ? $fields_and_values['bundle_from_location'] : '';
		$edit_data['bundle_item_grouping']             = isset($fields_and_values['bundle_item_grouping']) ? $fields_and_values['bundle_item_grouping'] : '';
		$edit_data['bundle_min_size']                  = isset($fields_and_values['bundle_min_size']) ? $fields_and_values['bundle_min_size'] : '';
		$edit_data['bundle_max_size']                  = isset($fields_and_values['bundle_max_size']) ? $fields_and_values['bundle_max_size'] : '';
		$edit_data['bundle_edit_cart']                 = isset($fields_and_values['bundle_edit_cart']) ? $fields_and_values['bundle_edit_cart'] : '';
		$edit_data['bundle_min_qty']                   = isset($fields_and_values['bundle_min_qty']) ? $fields_and_values['bundle_min_qty'] : '';
		$edit_data['bundle_max_qty']                   = isset($fields_and_values['bundle_max_qty']) ? $fields_and_values['bundle_max_qty'] : '';
		$edit_data['bundle_default_qty']               = isset($fields_and_values['bundle_default_qty']) ? $fields_and_values['bundle_default_qty'] : '';
		$edit_data['bundle_ship_indi']                 = isset($fields_and_values['bundle_ship_indi']) ? $fields_and_values['bundle_ship_indi'] : '';
		$edit_data['bundle_product_details']           = isset($fields_and_values['bundle_product_details']) ? $fields_and_values['bundle_product_details'] : '';
		$edit_data['bundle_override_title_chkbx']      = isset($fields_and_values['bundle_override_title_chkbx']) ? $fields_and_values['bundle_override_title_chkbx'] : '';
		$edit_data['bundle_override_title']            = isset($fields_and_values['bundle_override_title']) ? $fields_and_values['bundle_override_title'] : '';
		$edit_data['bundle_override_shortdescr_chkbx'] = isset($fields_and_values['bundle_override_shortdescr_chkbx']) ? $fields_and_values['bundle_override_shortdescr_chkbx'] : '';
		$edit_data['bundle_override_short_desc']       = isset($fields_and_values['bundle_override_short_desc']) ? $fields_and_values['bundle_override_short_desc'] : '';
		$edit_data['bundle_hidetumb']                  = isset($fields_and_values['bundle_hidetumb']) ? $fields_and_values['bundle_hidetumb'] : '';
		$edit_data['bundle_cart_checkout']             = isset($fields_and_values['bundle_cart_checkout']) ? $fields_and_values['bundle_cart_checkout'] : '';
		$edit_data['bundle_order_details']             = isset($fields_and_values['bundle_order_details']) ? $fields_and_values['bundle_order_details'] : '';
		$edit_data['bundle_price_prod_detail']         = isset($fields_and_values['bundle_price_prod_detail']) ? $fields_and_values['bundle_price_prod_detail'] : '';
		$edit_data['bundle_price_cart']                = isset($fields_and_values['bundle_price_cart']) ? $fields_and_values['bundle_price_cart'] : '';
		$edit_data['bundle_price_order']               = isset($fields_and_values['bundle_price_order']) ? $fields_and_values['bundle_price_order'] : '';
		$edit_data['bundle_optional']                  = isset($fields_and_values['bundle_optional']) ? $fields_and_values['bundle_optional'] : '';
		$edit_data['bundle_price_individual']          = isset($fields_and_values['bundle_price_individual']) ? $fields_and_values['bundle_price_individual'] : '';
		$edit_data['elex_bundle_discount']             = isset($fields_and_values['elex_bundle_discount']) ? $fields_and_values['elex_bundle_discount'] : '';
	}



	$sale_warning             = array();
	$product_array_visibility = array();
	$update_product_type      = array();
	$create_log               = true;
	if ( 'false' === $fields_and_values['create_log_file']) {
		$create_log = false;
	}
	if ( '' === $sch_jobs && 'schedule_later' === $fields_and_values['scheduled_action'] ) {
		$pids       = array();
		$param      = array();
		$merged_ids = array();
		if ( intval( $fields_and_values['index_val'] ) === intval( $fields_and_values['chunk_length'] - 1 ) ) {
			$param['param_to_save'] = $fields_and_values;
			if ( 0 !== intval( $fields_and_values['index_val'] ) ) {
				$prev_ids                      = get_option( 'elex_bep_product_ids_to_schedule' );
				$current_ids                   = $fields_and_values['pid'];
				$res_id                        = array_merge( $prev_ids, $current_ids );
				$param['param_to_save']['pid'] = $res_id;
				delete_option( 'elex_bep_product_ids_to_schedule' );
			}
			$param['scheduled_action'] = $fields_and_values['scheduled_action'];
			$param['save_job']         = $fields_and_values['save_job'];
			$param['schedule_date']    = $fields_and_values['schedule_date'];
			$param['revert_date']      = $fields_and_values['revert_date'];
			$param['scheduled_hour']   = $fields_and_values['scheduled_hour'];
			$param['scheduled_min']    = $fields_and_values['scheduled_min'];
			$param['revert_hour']      = $fields_and_values['revert_hour'];
			$param['revert_min']       = $fields_and_values['revert_min'];
			$param['job_name']         = $job_name;
			$param['create_log_file']  = $create_log;
			$param['schedule_opn']     = true;
			$param['edit_data']        = $edit_data;

			if ( '' !== $fields_and_values['revert_date'] ) {
				$param['revert_opn'] = true;
			}
			if ( ( isset( $fields_and_values['is_edit_job'] ) && 'true' == $fields_and_values['is_edit_job'] ) ) {
				$schedule_on_date          = $param['schedule_date'];
					$schedule_on_time_hour = $param['scheduled_hour'];
					$schedule_on_time_min  = $param['scheduled_min'];
					$revert_date           = $param['revert_date'];
					$revert_time_hour      = $param['revert_hour'];
					$revert_time_min       = $param['revert_min'];
					$stop_date             = $fields_and_values['stop_schedule_date'];
					$stop_hr               = $fields_and_values['stop_hr'];
					$stop_min              = $fields_and_values['stop_min'];
					$revert_on             = null;	
				if ( $revert_date ) {
					$revert_on = date_create($revert_date);
					if ( $revert_time_hour && $revert_time_min ) {
						$revert_on = date_create($revert_date);
						$revert_on->setTime( $revert_time_hour, $revert_time_min);
					}
					$revert_on = $revert_on->format('Y-m-d H:i:s');
				}
					$schedule_on = null;
				if ( $schedule_on_date ) {
					$schedule_on = date_create($schedule_on_date);
					if ( $schedule_on_time_hour && $schedule_on_time_min ) {
						$schedule_on->setTime( $schedule_on_time_hour, $schedule_on_time_min);
					}
					$schedule_on = $schedule_on->format('Y-m-d H:i:s');
				}
					$stop_schedule = null;
				if ( $stop_date ) {
					$stop_schedule = date_create($stop_schedule);
					if ( $stop_hr && $stop_min ) {
						$stop_schedule->setTime( $stop_hr, $stop_min);
					}
					$stop_schedule = $stop_schedule->format('Y-m-d H:i:s');
				}	
					$filter_data            = $param['param_to_save'];
					$filter_data_serialized = maybe_serialize($filter_data);
					$edit_data              = $param['edit_data'];
					$edit_data_serialized   = maybe_serialize($edit_data);
					$values                 =  [
						'job_name'           => $param['job_name'],
						'filter_data'        => $filter_data_serialized,
						'edit_data'          => $edit_data_serialized,
						'create_log_file'    => $create_log,
						'schedule_on'        => $schedule_on,
						'revert_on'          => $revert_on,
						'is_reversible'      => true,
						'job_id'             => $job_id,
						'schedule_frequency' => $fields_and_values['schedule_frequency_action'],
						'stop_schedule'      => $stop_schedule
					];
				 insert_data_into_database( $values );
				 $job_values = [
					'job_id'        => $job_id,
					'batch_no'      => 1,
					'schedule_date' => $schedule_on,
					'job_status'    => 0

					 ];
					 insert_job_schedule( $job_values );
			} else {
					$schedule_on_date      = $param['schedule_date'];
					$schedule_on_time_hour = $param['scheduled_hour'];
					$schedule_on_time_min  = $param['scheduled_min'];
					$revert_date           = $param['revert_date'];
					$revert_time_hour      = $param['revert_hour'];
					$revert_time_min       = $param['revert_min'];
					$stop_date             = $fields_and_values['stop_schedule_date'];
					$stop_hr               = $fields_and_values['stop_hr'];
					$stop_min              = $fields_and_values['stop_min'];
					$revert_on             = null;	
				if ( $revert_date ) {
					$revert_on = date_create($revert_date);
					if ( $revert_time_hour && $revert_time_min ) {
						$revert_on = date_create($revert_date);
						$revert_on->setTime( $revert_time_hour, $revert_time_min);
					}
					$revert_on = $revert_on->format('Y-m-d H:i:s');
				}
					$schedule_on = null;
				if ( $schedule_on_date ) {
					$schedule_on = date_create($schedule_on_date);
					if ( $schedule_on_time_hour && $schedule_on_time_min ) {
						$schedule_on->setTime( $schedule_on_time_hour, $schedule_on_time_min);
					}
					$schedule_on = $schedule_on->format('Y-m-d H:i:s');
				}
					$stop_schedule = null;
				if ( $stop_date ) {
					$stop_schedule = date_create($stop_schedule);
					if ( $stop_hr && $stop_min ) {
						$stop_schedule->setTime( $stop_hr, $stop_min);
					}
					$stop_schedule = $stop_schedule->format('Y-m-d H:i:s');
				}	
					$filter_data            = $param['param_to_save'];
					$filter_data_serialized = maybe_serialize($filter_data);
					$edit_data              = $param['edit_data'];
					$edit_data_serialized   = maybe_serialize($edit_data);
					$values                 =  [
						'job_name'           => $param['job_name'],
						'filter_data'        => $filter_data_serialized,
						'edit_data'          => $edit_data_serialized,
						'create_log_file'    => $create_log,
						'schedule_on'        => $schedule_on,
						'revert_on'          => $revert_on,
						'is_reversible'      => true,
						'job_id'             => $job_id,
						'schedule_frequency' => $fields_and_values['schedule_frequency_action'],
						'stop_schedule'      => $stop_schedule
					];
				 insert_data_into_database( $values );
				 $job_values = [
					'job_id'        => $job_id,
					'batch_no'      => 1,
					'schedule_date' => $schedule_on,
					'job_status'    => 0

					 ];
					 insert_job_schedule( $job_values );
			}
			
			wp_send_json( 'scheduled' );
			die();
		} else {
			$saved_pids_ = get_option( 'elex_bep_product_ids_to_schedule', false );
			if ( false === $saved_pids_ ) {
				update_option( 'elex_bep_product_ids_to_schedule', $fields_and_values['pid'] );
			} else {
				$result_ids = array_merge( $saved_pids_, $fields_and_values['pid'] );
				update_option( 'elex_bep_product_ids_to_schedule', $result_ids );
			}
			wp_die( wp_json_encode( array(
				'status' => 'part_scheduled',
				'job_id' => $job_id
			) ) );
		}
	}



	include_once 'class-eh-bulk-password-protect.php';


	foreach ( (array) $selected_products as $pid => $temp ) {

		if ( false === $temp ) {	
			continue;	
		}
		$index = $pid;
		array_push( $update_product_type, $temp );
		$pid                        = $temp;
		$collect_product_data       = array();
		$collect_product_data['id'] = $pid;
		$temp                       = wc_get_product( $temp );

		$collect_product_data['categories']   = '';
		$collect_product_data['category_opn'] = $fields_and_values['category_update_option'];
		
		switch ( $hide_price ) {
			case 'yes':
				$collect_product_data['product_adjustment_hide_price_unregistered'] = $temp->get_meta( 'product_adjustment_hide_price_unregistered' );
				eh_bep_update_meta_fn( $pid, 'product_adjustment_hide_price_unregistered', 'yes' );
				break;
			case 'no':
				$collect_product_data['product_adjustment_hide_price_unregistered'] = $temp->get_meta( 'product_adjustment_hide_price_unregistered' );
				eh_bep_update_meta_fn( $pid, 'product_adjustment_hide_price_unregistered', 'no' );
				break;
		}
		switch ( $price_adjustment ) {
			case 'yes':
				$collect_product_data['product_based_price_adjustment'] = $temp->get_meta( 'product_based_price_adjustment' );
				eh_bep_update_meta_fn( $pid, 'product_based_price_adjustment', 'yes' );
				break;
			case 'no':
				$collect_product_data['product_based_price_adjustment'] = $temp->get_meta( 'product_based_price_adjustment' );
				eh_bep_update_meta_fn( $pid, 'product_based_price_adjustment', 'no' );
				break;
		}
		if ( '' !== $hide_price_role && !empty( $temp )) {
			$collect_product_data['eh_pricing_adjustment_product_price_user_role'] = $temp->get_meta( 'eh_pricing_adjustment_product_price_user_role' );
			eh_bep_update_meta_fn( $pid, 'eh_pricing_adjustment_product_price_user_role', $hide_price_role );
		}
		switch ( $shipping_unit_select ) {
			case 'add':
				$unit                                     = $temp->get_meta( '_wf_shipping_unit' );
				$collect_product_data['wf_shipping_unit'] = $unit;
				$unit_val                                 = number_format( $unit + $shipping_unit, 6, '.', '' );
				eh_bep_update_meta_fn( $pid, '_wf_shipping_unit', $unit_val );
				break;
			case 'sub':
				$unit                                     = $temp->get_meta( '_wf_shipping_unit' );
				$collect_product_data['wf_shipping_unit'] = $unit;
				$unit_val                                 = number_format( $unit - $shipping_unit, 6, '.', '' );
				eh_bep_update_meta_fn( $pid, '_wf_shipping_unit', $unit_val );
				break;
			case 'replace':
				$unit                                     = $temp->get_meta( '_wf_shipping_unit' );
				$collect_product_data['wf_shipping_unit'] = $unit;
				eh_bep_update_meta_fn( $pid, '_wf_shipping_unit', $shipping_unit );
				break;
			default:
				break;
		}
		if ( false === $temp ) {
			continue;
		}
		$parent    = $temp;
		$parent_id = $pid;
		if ( ! empty( $temp ) && $temp->is_type( 'variation' ) ) {
			$parent_id = ( WC()->version < '2.7.0' ) ? $temp->parent->id : $temp->get_parent_id();
			$parent    = wc_get_product( $parent_id );
			if ( false === $parent ) {
				continue;
			}
		}

		$temp_type  = ( WC()->version < '2.7.0' ) ? $temp->product_type : $temp->get_type();
		$temp_title = ( WC()->version < '2.7.0' ) ? $temp->post->post_title : $temp->get_title();

		$collect_product_data['product_type_status'] = $temp_type;
		if ( 'simple' === $temp_type || 'variable' === $temp_type || 'external' === $temp_type || 'bundle' === $temp_type  ) {
			$collect_product_data['password']    = elex_bep_get_password( $pid );
			$collect_product_data['post_status'] = get_post_status( $pid );
			if ( ! in_array( $pid, $product_array_visibility ) ) {
				if ( 'public' === $visibility_action ) {
					array_push( $product_array_visibility, $pid );
				} elseif ( 'password protected' === $visibility_action ) {
					if ( '' !== $category_password ) {
						array_push( $product_array_visibility, $pid );
					}
				}
			}
		}
		if ( 'simple' === $temp_type || 'variation' === $temp_type || 'variable' === $temp_type || 'external' === $temp_type || 'bundle' === $temp_type ) {
			$product_data                      = array();
			$product_data['type']              = 'simple';
			$product_data['title']             = $temp_title;
			$product_data['sku']               = $temp->get_sku();
			$product_data['catalog']           = ( WC()->version < '2.7.3' ) ? $temp->get_meta( '_visibility' ) : $temp->get_catalog_visibility();
			$product_data['featured']          = ( WC()->version < '2.7.3' ) ? $temp->get_meta( '_featured' ) : $temp->get_featured();
			$ship_args                         = array( 'fields' => 'ids' );
			$product_data['shipping']          = current( wp_get_object_terms( $pid, 'product_shipping_class', $ship_args ) );
			$product_data['sale']              = (float) $temp->get_sale_price();
			$product_data['regular']           = (float) $temp->get_regular_price();
			$product_data['stock_manage']      = $temp->get_manage_stock();
			$product_data['tax_status_action'] = $temp->get_tax_status();
			$product_data['tax_class_action']  = $temp->get_tax_class();
			$product_data['stock_quantity']    = (float) $temp->get_stock_quantity();
			$product_data['backorder']         = $temp->get_backorders();
			$product_data['stock_status']      = $temp->get_stock_status();
			$product_data['length']            = (float) $temp->get_length();
			$product_data['width']             = (float) $temp->get_width();
			$product_data['height']            = (float) $temp->get_height();
			$product_data['weight']            = (float) $temp->get_weight();
			$collect_product_data['id']        = $pid;
			$collect_product_data['type']      = $product_data['type'];
		
			// Schedule Sale Price Customization.
			$sale_prices_from = $temp->get_meta( '_sale_price_dates_from');
			$sale_prices_to   = $temp->get_meta('_sale_price_dates_to');
			

			$product_data['sale_price_date_from'] = '' !== $sale_prices_from ? gmdate( 'Y-m-d', strtotime($sale_prices_from) ) : '';
			$product_data['sale_price_date_to']   = '' !== $sale_prices_to ? gmdate( 'Y-m-d', strtotime($sale_prices_to) ) : '';

			switch ( $title_select ) {
				case 'set_new':
					$collect_product_data['title'] = $product_data['title'];
					$temp->set_name( $title_text );
					$temp->save();
					break;
				case 'append':
					$collect_product_data['title'] = $product_data['title'];
					$temp->set_name( $product_data['title'] . $title_text );
					$temp->save();
					break;
				case 'prepand':
					$collect_product_data['title'] = $product_data['title'];
					$temp->set_name( $title_text . $product_data['title'] );
					$temp->save();
					break;
				case 'replace':
					$collect_product_data['title'] = $product_data['title'];
					$temp->set_name( str_replace( $replace_title_text, $title_text, $product_data['title'] ) );
					$temp->save();
					break;
				case 'sentence_key':
					$collect_product_data['title'] = $product_data['title'];
					$prod_name                     = $temp->get_name();
					$prod_name                     = strtolower($prod_name);
					$prod_name                     = ucwords($prod_name);
					$temp->set_name( $prod_name );
					$temp->save();
					break;
				case 'regex_replace':
					if ( @preg_replace( '/' . $regex_replace_title_text . '/', $title_text, $product_data['title'] ) !== false ) {
						$regex_flags = '';
						if ( ! empty( $_REQUEST['regex_flag_sele_title'] ) ) {
							foreach ( array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['regex_flag_sele_title'] ) ) as $reg_val ) {
								$regex_flags .= $reg_val;
							}
						}
						$collect_product_data['title'] = $product_data['title'];
						$temp->set_name( preg_replace( '/' . $regex_replace_title_text . '/' . $regex_flags, $title_text, $product_data['title'] ) );
						$temp->save();
					}
					break;
			}
			switch ( $sku_select ) {
				case 'set_new':
					$collect_product_data['sku'] = $product_data['sku'];
					if ( 0 === $index ) {
						$sku_pad_number = 1;
						if ( empty($sku_padding)) {
							$sku_padding = 1;
						}
						$padded_num = str_pad($sku_padding, $sku_padding, '0', STR_PAD_LEFT);
					}
					$padding_reach = pow(10, $sku_padding-1);
					if ( $sku_pad_number == $padding_reach || $sku_pad_number > $padding_reach ) {
						$num = $sku_pad_number;
					} else {
						$num = preg_replace('/[1-9]/', $sku_pad_number, $padded_num);
					}
					if ( 'space' === $sku_delimeter) {
						$new_sku = $sku_text . ' ' . $num ;
					} else {
						$new_sku = $sku_text . $sku_delimeter . $num ;
					}
					//checking unique sku
					$unique = wc_get_product_id_by_sku($new_sku);
					if ( 0 === $unique ) {
						$temp->set_sku( $new_sku );
						$temp->save();
					}
					$sku_pad_number = $num + 1 ;
					break;
				case 'append':
					$collect_product_data['sku'] = $product_data['sku'];
					$sku_val                     = $product_data['sku'] . $sku_text;
					//checking unique sku
					$unique = wc_get_product_id_by_sku($sku_val);
					if ( 0 === $unique ) {
						$temp->set_sku( $sku_val );
						$temp->save();
					}
					break;
				case 'prepand':
					$collect_product_data['sku'] = $product_data['sku'];
					$sku_val                     = $sku_text . $product_data['sku'];
					//checking unique sku
					$unique = wc_get_product_id_by_sku($sku_val);
					if ( 0 === $unique ) {
						$temp->set_sku( $sku_val );
						$temp->save();
					}
					break;
				case 'replace':
					$collect_product_data['sku'] = $product_data['sku'];
					$sku_val                     = str_replace( $sku_replace_text, $sku_text, $product_data['sku'] );
					$unique                      = wc_get_product_id_by_sku($sku_val);
					if ( 0 === $unique ) {
						$temp->set_sku( $sku_val );
						$temp->save();
					}
					break;
				case 'regex_replace':
					if ( @preg_replace( '/' . $regex_sku_replace_text . '/', $sku_text, $product_data['sku'] ) !== false ) {
						$regex_flags = '';
						if ( ! empty( $_REQUEST['regex_flag_sele_sku'] ) ) {
							foreach ( array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['regex_flag_sele_sku'] ) ) as $reg_val ) {
								$regex_flags .= $reg_val;
							}
						}
						$sku_val = preg_replace( '/' . $regex_sku_replace_text . '/' . $regex_flags, $sku_text, $product_data['sku'] );
						//checking unique sku
						$unique = wc_get_product_id_by_sku($sku_val);
						if ( 0 === $unique ) {
							$temp->set_sku( $new_sku );
							$temp->save();
						}
						$collect_product_data['sku'] = $product_data['sku'];
					}
					break;
			}
			$edit_data['main_image'] = '';
			if ( isset( $fields_and_values['main_image'] ) && $fields_and_values['main_image'] ) {
				$edit_data['main_image']            = $fields_and_values['main_image'];
				$collect_product_data['main_image'] = $temp->get_image_id();
				$image_id                           = attachment_url_to_postid( $fields_and_values['main_image'] );
				$temp->set_image_id( $image_id );
				$temp->save();
			}
			// Product description(Can be set for variations also).
			$product_details                            = $temp->get_data();
			$edit_data['description']                   = '';
			$edit_data['description_action']            = '';
			$edit_data['replace_description_text_data'] = '';
			$edit_data['description_text_data']         = '';
			if ( '' !== $fields_and_values['description_action'] ) {
				$edit_data['description']            = $fields_and_values['description'];
				$edit_data['description_action']     = $fields_and_values['description_action'];
				$collect_product_data['description'] = $product_details['description'];
				if ( 'append' === $fields_and_values['description_action'] && isset( $fields_and_values['description'] ) && '' !== $fields_and_values['description'] ) {
					$desc = $product_details['description'] . $fields_and_values['description'];
				} elseif ( 'prepend' === $fields_and_values['description_action'] && isset( $fields_and_values['description'] ) && '' !== $fields_and_values['description'] ) {
					$desc = $fields_and_values['description'] . $product_details['description'];
				} elseif ( 'replace' === $fields_and_values['description_action'] && isset( $fields_and_values['description_text_data'] ) && isset( $fields_and_values['replace_description_text_data'] ) && '' != $fields_and_values['replace_description_text_data'] ) {
					$edit_data['replace_description_text_data'] = $fields_and_values['replace_description_text_data'];
					$edit_data['description_text_data']         = $fields_and_values['description_text_data'];
					$desc                                       = str_replace( $fields_and_values['replace_description_text_data'], $fields_and_values['description_text_data'], $product_details['description'] );
				} else {
					$desc = $fields_and_values['description'];
				}
				$temp->set_description( $desc );
				$temp->save();
			}
			if ( 'variation' !== $temp_type ) {
				$collect_product_data['catalog'] = $product_data['catalog'];
				if ( WC()->version < '2.7.3' ) {
					eh_bep_update_meta_fn( $pid, '_visibility', $catalog_select );
				} else {
					$options        = array_keys( wc_get_product_visibility_options() );
					$catalog_select = wc_clean( $catalog_select );
					if ( in_array( $catalog_select, $options, true ) ) {
						$parent->set_catalog_visibility( $catalog_select );
						$parent->save();
					}
				}
				// Set featured.
				if ( isset( $fields_and_values['is_featured'] ) && '' != $fields_and_values['is_featured'] ) {
					$collect_product_data['featured'] = $product_data['featured'];
					$parent->set_featured( $featured );
					$parent->save();
				}
				$edit_data['short_description']                   = '';
				$edit_data['short_description_action']            = '';
				$edit_data['replace_short_description_text_data'] = '';
				$edit_data['short_description_text_data']         = '';
				// Product short description.
				if ( '' !== $fields_and_values['short_description_action'] ) {
					$edit_data['short_description']            = $fields_and_values['short_description'];
					$edit_data['short_description_action']     = $fields_and_values['short_description_action'];
					$collect_product_data['short_description'] = $product_details['short_description'];
					if ( 'append' === $fields_and_values['short_description_action'] && isset( $fields_and_values['short_description'] ) && '' !== $fields_and_values['short_description'] ) {
						$short_desc = $product_details['short_description'] . $fields_and_values['short_description'];
					} elseif ( 'prepend' === $fields_and_values['short_description_action'] && isset( $fields_and_values['short_description'] ) && '' !== $fields_and_values['short_description'] ) {
						$short_desc = $fields_and_values['short_description'] . $product_details['short_description'];
					} elseif ( 'replace' === $fields_and_values['short_description_action'] && isset( $fields_and_values['short_description_text_data'] ) && isset( $fields_and_values['replace_short_description_text_data'] ) && '' != $fields_and_values['replace_short_description_text_data'] ) {
						$edit_data['replace_short_description_text_data'] = $fields_and_values['replace_short_description_text_data'];
						$edit_data['short_description_text_data']         = $fields_and_values['short_description_text_data'];
						$short_desc                                       = str_replace( $fields_and_values['replace_short_description_text_data'], $fields_and_values['short_description_text_data'], $product_details['short_description'] );
					} else {
						$short_desc = $fields_and_values['short_description'];
					}
					$temp->set_short_description( $short_desc );
					$temp->save();
				}
				if ( isset( $fields_and_values['gallery_images'] ) && $fields_and_values['gallery_images'] && '' !== $fields_and_values['gallery_images_action'] ) {
					$edit_data['gallery_images']            = $fields_and_values['gallery_images_action'];
					$collect_product_data['gallery_images'] = $temp->get_gallery_image_ids();
					$gallery_image_ids                      = array();
					foreach ( $fields_and_values['gallery_images'] as $image_index => $image_url ) {
						$gallery_image_id = attachment_url_to_postid( $image_url );
						array_push( $gallery_image_ids, $gallery_image_id );
					}
					if ( 'add' === $fields_and_values['gallery_images_action'] ) {
						$gallery_image_ids = array_merge( $gallery_image_ids, $collect_product_data['gallery_images'] );
					} elseif ( 'remove' === $fields_and_values['gallery_images_action'] ) {
						$flag_array = array();
						if ( ! empty( $collect_product_data['gallery_images'] ) ) {
							foreach ( $collect_product_data['gallery_images'] as $key => $i_ids ) {
								if ( ! in_array( $i_ids, $gallery_image_ids, true ) ) {
									array_push( $flag_array, $i_ids );
								}
							}
						}
							$gallery_image_ids = $flag_array;
					}
					$temp->set_gallery_image_ids( $gallery_image_ids );
					$temp->save();
				}
			} else {
				if ( isset( $fields_and_values['vari_attribute'] ) && is_array( $fields_and_values['vari_attribute'] ) ) {
					$existing_attr     = $temp->get_attributes();
					$change_attributes = array();
					foreach ( $fields_and_values['vari_attribute'] as $index => $attribute_details ) {
						$attr_detail_arr = explode( ',', $attribute_details );
						$from_attr       = $attr_detail_arr[0];
						$to_attr         = $attr_detail_arr[1];
						$from_attr_arr   = explode( ':', $from_attr );
						if ( 'any' === $from_attr_arr[1] ) {
							$from_attr_arr[1] = '';
						}
						$to_attr_arr = explode( ':', $to_attr );
						if ( array_key_exists( 'pa_' . $from_attr_arr[0], $existing_attr ) && $existing_attr[ 'pa_' . $from_attr_arr[0] ] === $from_attr_arr[1] ) {
							if ( 'any' === $to_attr_arr[1] ) {
								$to_attr_arr[1] = '';
							}
							$change_attributes[ 'pa_' . $to_attr_arr[0] ] = $to_attr_arr[1];
						}
					}

					$parent_id      = $temp->get_parent_id();
					$parent_product = wc_get_product($parent_id);

					if ( $parent_product ) {
						// Get the attributes of the parent product
						$attributes       = $parent_product->get_attributes();
						$available_values = '';
						foreach ($attributes as $attribute) {
							$attribute_values = $attribute->get_options();
							$attribute_name   = $attribute->get_name();
							$taxonomy         = $attribute->get_taxonomy();
							$mapped_values    = array_map(function( $option_id) use ( $taxonomy) {
								return get_term_by('id', $option_id, $taxonomy)->name;
							}, $attribute_values);
							if ( $available_values ) {
								$available_values = array_merge( $available_values, $mapped_values );
							} else {
								$available_values = $mapped_values;
							}
						}
					} 
					$result_attri_update = array();
					if ( ! empty( $change_attributes ) ) {
						$edit_data['vari_attribute']            = $existing_attr;
						$collect_product_data['vari_attribute'] = $existing_attr;
						$result_attri_update                    = array_merge( $existing_attr, $change_attributes );
						$commonValues                           = array_intersect(array_map('strtolower', $available_values), array_map('strtolower', $result_attri_update));
						if ( $commonValues ) {
							$temp->set_attributes( $result_attri_update );
							$temp->save();
						}
					}
				}
			}
			if ( '' !== $shipping_select ) {
				$collect_product_data['shipping'] = $product_data['shipping'];
				wp_set_object_terms( (int) $pid, (int) $shipping_select, 'product_shipping_class' );
			}
			/**
			 *  $sal_val for comparing with regular price, if $sal_val less than regular then only we are updating.
			 */
			if ( $sale_select ) {
				$sal_val = eh_bep_check_sale_price( $sale_select, $sale_text, $sale_round_text, $sale_round_select, $product_data['sale'], $fields_and_values['regular_check_val'] );
			} else {
				$sal_val = $temp->get_sale_price();
			}
			switch ( $regular_select ) {
				case 'up_percentage':
					if ( '' !== $product_data['regular'] ) {
						$collect_product_data['regular'] = $product_data['regular'];
						$per_val                         = $product_data['regular'] * ( $regular_text / 100 );
						$cal_val                         = $product_data['regular'] + $per_val;
						if ( '' !== $regular_round_select ) {
							if ( '' === $regular_round_text ) {
								$regular_round_text = 1;
							}
							$got_regular = $cal_val;
							switch ( $regular_round_select ) {
								case 'up':
									$cal_val = eh_bep_round_ceiling( $got_regular, $regular_round_text );
									break;
								case 'down':
									$cal_val = eh_bep_round_ceiling( $got_regular, -$regular_round_text );
									break;
							}
						}
						$regular_val = wc_format_decimal( $cal_val, '', true );

						if ( 'variable' !== $temp_type && $sal_val < $regular_val ) {
							$temp->set_regular_price( $regular_val );
							$temp->save();
						} else {

							if ( 'variable' !== $temp_type ) {
								array_push( $sale_warning, 'Regular' );
								array_push( $sale_warning, $temp_type );
							}
						}
					}
					break;
				case 'down_percentage':
					if ( '' !== $product_data['regular'] ) {
						$collect_product_data['regular'] = $product_data['regular'];
						$per_val                         = $product_data['regular'] * ( $regular_text / 100 );
						$cal_val                         = $product_data['regular'] - $per_val;
						if ( '' !== $regular_round_select ) {
							if ( '' === $regular_round_text ) {
								$regular_round_text = 1;
							}
							$got_regular = $cal_val;
							switch ( $regular_round_select ) {
								case 'up':
									$cal_val = eh_bep_round_ceiling( $got_regular, $regular_round_text );
									break;
								case 'down':
									$cal_val = eh_bep_round_ceiling( $got_regular, -$regular_round_text );
									break;
							}
						}
						$regular_val = wc_format_decimal( $cal_val, '', true );
						
						if ( 'variable' !== $temp_type && $sal_val < $regular_val ) {
							$temp->set_regular_price( $regular_val );
							$temp->save();
						} else {
							if ( 'variable' !== $temp_type ) {
								array_push( $sale_warning, 'Regular' );
								array_push( $sale_warning, $temp_type );
							}
						}
					}
					break;
				case 'up_price':
					if ( '' !== $product_data['regular'] ) {
						$collect_product_data['regular'] = $product_data['regular'];
						$cal_val                         = $product_data['regular'] + $regular_text;
						if ( '' !== $regular_round_select ) {
							if ( '' === $regular_round_text ) {
								$regular_round_text = 1;
							}
							$got_regular = $cal_val;
							switch ( $regular_round_select ) {
								case 'up':
									$cal_val = eh_bep_round_ceiling( $got_regular, $regular_round_text );
									break;
								case 'down':
									$cal_val = eh_bep_round_ceiling( $got_regular, -$regular_round_text );
									break;
							}
						}
						$regular_val = wc_format_decimal( $cal_val, '', true );
						
						if ( 'variable' !== $temp_type && $sal_val < $regular_val ) {
							$temp->set_regular_price( $regular_val );
							$temp->save();
						} else {

							if ( 'variable' !== $temp_type ) {
								array_push( $sale_warning, 'Regular' );
								array_push( $sale_warning, $temp_type );
							}
						}
					}
					break;
				case 'down_price':
					if ( '' !== $product_data['regular'] ) {
						$collect_product_data['regular'] = $product_data['regular'];
						$cal_val                         = $product_data['regular'] - $regular_text;
						if ( '' !== $regular_round_select ) {
							if ( '' === $regular_round_text ) {
								$regular_round_text = 1;
							}
							$got_regular = $cal_val;
							switch ( $regular_round_select ) {
								case 'up':
									$cal_val = eh_bep_round_ceiling( $got_regular, $regular_round_text );
									break;
								case 'down':
									$cal_val = eh_bep_round_ceiling( $got_regular, -$regular_round_text );
									break;
							}
						}
						$regular_val = wc_format_decimal( $cal_val, '', true );
						
						if ( 'variable' !== $temp_type && $sal_val < $regular_val ) {
							$temp->set_regular_price( $regular_val );
							$temp->save();
						} else {
							if ( 'variable' !== $temp_type ) {
								array_push( $sale_warning, 'Regular' );
								array_push( $sale_warning, $temp_type );
							}
						}
					}
					break;
				case 'flat_all':
					$collect_product_data['regular'] = $product_data['regular'];
					$regular_val                     = wc_format_decimal( $regular_text, '', true );
					
					if ( 'variable' !== $temp_type && $sal_val < $regular_val ) {
						$temp->set_regular_price( $regular_val );
						$temp->save();
					} else {
						if ( 'variable' !== $temp_type ) {
							array_push( $sale_warning, 'Regular' );
							array_push( $sale_warning, $temp_type );
						}
					}
					break;
			}
			switch ( $sale_select ) {
				case 'up_percentage':
					if ( '' !== $product_data['sale'] ) {
						$collect_product_data['sale'] = $product_data['sale'];
						$sale_val                     = eh_bep_check_sale_price( $sale_select, $sale_text, $sale_round_text, $sale_round_select, $product_data['sale'], $fields_and_values['regular_check_val'] );
						$reg_val                      = $temp->get_regular_price();
						if ( 'variable' !== $temp_type && $sale_val < $reg_val ) {
							$temp->set_sale_price( $sale_val );
							$temp->save();
						} else {

							if ( 'variable' !== $temp_type ) {
								array_push( $sale_warning, 'Sales' );
								array_push( $sale_warning, $temp_type );
							}
							if ( isset( $fields_and_values['regular_select'] ) ) {
								$temp->set_regular_price( $product_data['regular'] );
								$temp->save();
							}
						}
					}
					break;
				case 'down_percentage':
					if ( '' !== $product_data['sale'] || $fields_and_values['regular_check_val'] ) {
						$collect_product_data['sale'] = $product_data['sale'];
						$sale_val                     = eh_bep_check_sale_price( $sale_select, $sale_text, $sale_round_text, $sale_round_select, $product_data['sale'], $fields_and_values['regular_check_val'] );
						$reg_val                      = $temp->get_regular_price();
						if ( $reg_val && $fields_and_values['regular_check_val']) {
							$per_val  = $reg_val - ( $reg_val * ( $sale_text / 100 ) );
							$sale_val = wc_format_decimal( $per_val, '', true );
							// leave sale price blank if sale price decreased by 100%.
							if ( 0 === intval( $sale_val ) || $sale_val < 0 ) {
								$sale_val = '';
							}
						}
						if ( 'variable' !== $temp_type && $sale_val < $reg_val ) {
							$temp->set_sale_price( $sale_val );
							$temp->save();
						} else {
							if ( 'variable' !== $temp_type ) {
								array_push( $sale_warning, 'Sales' );
								array_push( $sale_warning, $temp_type );
							}

							if ( isset( $fields_and_values['regular_select'] ) ) {
								$temp->set_regular_price( $product_data['regular'] );
								$temp->save();
							}
						}
					}
					break;
				case 'up_price':
					if ( '' !== $product_data['sale'] ) {
						$collect_product_data['sale'] = $product_data['sale'];
						$sale_val                     = eh_bep_check_sale_price( $sale_select, $sale_text, $sale_round_text, $sale_round_select, $product_data['sale'], $fields_and_values['regular_check_val'] );
						$reg_val                      = $temp->get_regular_price();
						if ( 'variable' !== $temp_type && $sale_val < $reg_val ) {
							$temp->set_sale_price( $sale_val );
							$temp->save();
						} else {
							if ( 'variable' !== $temp_type ) {
								array_push( $sale_warning, 'Sales' );
								array_push( $sale_warning, $temp_type );
							}

							if ( isset( $fields_and_values['regular_select'] ) ) {
								$temp->set_regular_price( $product_data['regular'] );
								$temp->save();
							}
						}
					}
					break;
				case 'down_price':
					if ( '' !== $product_data['sale'] || $fields_and_values['regular_check_val'] ) {
						$collect_product_data['sale'] = $product_data['sale'];
						$sale_val                     = eh_bep_check_sale_price( $sale_select, $sale_text, $sale_round_text, $sale_round_select, $product_data['sale'], $fields_and_values['regular_check_val'] );
						$reg_val                      = $temp->get_regular_price();
						if ( $reg_val && $fields_and_values['regular_check_val']) {
							$per_val  = $reg_val - $sale_text ;
							$sale_val = wc_format_decimal( $per_val, '', true );
							// leave sale price blank if sale price decreased by 100%.
							if ( 0 === intval( $sale_val ) || $sale_val < 0 ) {
								$sale_val = '';
							}
						}
						if ( 'variable' !== $temp_type && $sale_val < $reg_val ) {
							$temp->set_sale_price( $sale_val );
							$temp->save();
						} else {
							if ( 'variable' !== $temp_type ) {
								array_push( $sale_warning, 'Sales' );
								array_push( $sale_warning, $temp_type );
							}
							if ( isset( $fields_and_values['regular_select'] ) ) {
								$temp->set_regular_price( $product_data['regular'] );
								$temp->save();
							}
						}
					}
					break;
				case 'flat_all':
					$collect_product_data['sale'] = $product_data['sale'];
					$sale_val                     = eh_bep_check_sale_price( $sale_select, $sale_text, $sale_round_text, $sale_round_select, $product_data['sale'], $fields_and_values['regular_check_val'] );
					$reg_val                      = $temp->get_regular_price();
					if ( 'variable' !== $temp_type && $sale_val < $reg_val ) {
						$temp->set_sale_price( $sale_val );
						$temp->save();
					} else {
						if ( 'variable' !== $temp_type ) {
							array_push( $sale_warning, 'Sales' );
							array_push( $sale_warning, $temp_type );
						}

						if ( isset( $fields_and_values['regular_select'] ) ) {
							$temp->set_regular_price( $product_data['regular'] );
							$temp->save();
						}
					}
					break;
			}

			// Cancel Schedule Sale price 
			if ( 'true' === $fields_and_values['cancel_schedule_sale_price'] ) {
				$collect_product_data['cancel_schedule_sale_price']      = $fields_and_values['cancel_schedule_sale_price'];
				$collect_product_data['cancel_schedule_sale_price_from'] = $temp->get_date_on_sale_from();
				$collect_product_data['cancel_schedule_sale_price_to']   = $temp->get_date_on_sale_to();
				if ( 'variable' !== $temp_type ) {
					$sale_price = $temp->get_sale_price();
					$temp->set_date_on_sale_from( '' );
					$temp->set_date_on_sale_to( '' );
					$temp->save();
				}
			}
			// Schedule Sale Price Customization.
			if ( 'true' === $fields_and_values['schedule_sale_price'] ) {
				$collect_product_data['sale_price_date_from'] = $product_data['sale_price_date_from'];
				$collect_product_data['sale_price_date_to']   = $product_data['sale_price_date_to'];
				if ( 'variable' !== $temp_type ) {
					$regular_price = $temp->get_regular_price();
					$sale_price    = $temp->get_sale_price();
					elex_bep_schedule_product_sale_price( $pid, $regular_price, $sale_price, $fields_and_values['sale_price_date_from'], $fields_and_values['sale_price_date_to'] );
				}
			}
			if ( '' !== $regular_select || '' !== $sale_select ) {
				if ( 'variable' !== $temp_type && 'true' != $fields_and_values['schedule_sale_price'] ) {
					if ( $temp->get_sale_price() !== '' && $temp->get_regular_price() !== '' ) {
						$temp->set_price( $temp->get_sale_price() );
						$temp->save();
					} elseif ( $temp->get_sale_price() === '' && $temp->get_regular_price() !== '' ) {
						$temp->set_price( $temp->get_regular_price() );
						$temp->save();
					} elseif ( $temp->get_sale_price() !== '' && $temp->get_regular_price() === '' ) {
						$temp->set_price( $temp->get_sale_price() );
						$temp->save();
					} elseif ( $temp->get_sale_price() === '' && $temp->get_regular_price() === '' ) {
						$temp->set_price( '' );
						$temp->save();
					}
				}
				if ( 'variation' == $temp_type ) {
					$product_variable = new WC_Product_Variable( $parent_id );
					$product_variable->sync( $parent_id );
					wc_delete_product_transients( $parent_id );
					wc_delete_product_transients( $pid );
				}
			}
			switch ( $stock_manage_select ) {
				case 'yes':
					$collect_product_data['stock_manage'] = $product_data['stock_manage'];
					$temp->set_manage_stock( 'yes' );
					$temp->save();
					break;
				case 'no':
					$collect_product_data['stock_manage'] = $product_data['stock_manage'];
					$temp->set_manage_stock( 'no' );
					$temp->save();
					break;
			}
			switch ( $tax_status_action ) {
				case 'taxable':
					$collect_product_data['tax_status_action'] = $product_data['tax_status_action'];
					eh_bep_update_meta_fn( $pid, '_tax_status', $tax_status_action );
					break;
				case 'shipping':
					$collect_product_data['tax_status_action'] = $product_data['tax_status_action'];
					eh_bep_update_meta_fn( $pid, '_tax_status', $tax_status_action );
					break;
				case 'none':
					$collect_product_data['tax_status_action'] = $product_data['tax_status_action'];
					eh_bep_update_meta_fn( $pid, '_tax_status', $tax_status_action );
					break;
			}
			if ( 'default' === $fields_and_values['tax_class_action'] ) {
				$collect_product_data['tax_class_action'] = $product_data['tax_class_action'];
				eh_bep_update_meta_fn( $pid, '_tax_class', '' );
			} elseif ( '' !== $fields_and_values['tax_class_action'] ) {
				$collect_product_data['tax_class_action'] = $product_data['tax_class_action'];
				eh_bep_update_meta_fn( $pid, '_tax_class', $fields_and_values['tax_class_action'] );
			}
			switch ( $quantity_select ) {
				case 'add':
					$collect_product_data['stock_quantity'] = $product_data['stock_quantity'];
					$quantity_val                           = number_format( $product_data['stock_quantity'] + $quantity_text, 6, '.', '' );
					$temp->set_stock( $quantity_val );
					$temp->save();
					break;
				case 'sub':
					$collect_product_data['stock_quantity'] = $product_data['stock_quantity'];
					$quantity_val                           = number_format( $product_data['stock_quantity'] - $quantity_text, 6, '.', '' );
					$temp->set_stock( $quantity_val );
					$temp->save();
					break;
				case 'replace':
					$collect_product_data['stock_quantity'] = $product_data['stock_quantity'];
					$quantity_val                           = number_format( $quantity_text, 6, '.', '' );
					$temp->set_stock( $quantity_val );
					$temp->save();
					break;
			}
			if ( 'external' !== $temp_type  ) {
				switch ( $backorder_select ) {
					case 'no':
						$collect_product_data['backorder'] = $product_data['backorder'];
						eh_bep_update_meta_fn( $pid, '_backorders', 'no' );
						break;
					case 'notify':
						$collect_product_data['backorder'] = $product_data['backorder'];
						eh_bep_update_meta_fn( $pid, '_backorders', 'notify' );
						break;
					case 'yes':
							$collect_product_data['backorder'] = $product_data['backorder'];
							eh_bep_update_meta_fn( $pid, '_backorders', 'yes' );
						break;
				}
			}
			switch ( $stock_status_select ) {
				case 'instock':
					$collect_product_data['stock_status'] = $product_data['stock_status'];
					$temp->set_stock_status('instock');
					$temp->save();
					break;
				case 'outofstock':
					if ( 'external' !== $temp_type  ) {
						$collect_product_data['stock_status'] = $product_data['stock_status'];
						$temp->set_stock_status('outofstock');
						$temp->save();
					}
					break;
				case 'onbackorder':
					if ( 'external' !== $temp_type  ) {
						$collect_product_data['stock_status'] = $product_data['stock_status'];
						$temp->set_stock_status('onbackorder');
						$temp->save();
					}
					break;
			}
			switch ( $length_select ) {
				case 'add':
					$collect_product_data['length'] = $product_data['length'];
					$length_val                     = $product_data['length'] + $length_text;
					$temp->set_length( $length_val );
					$temp->save();
					break;
				case 'sub':
					$collect_product_data['length'] = $product_data['length'];
					$length_val                     = $product_data['length'] - $length_text;
					$temp->set_length( $length_val );
					$temp->save();
					break;
				case 'replace':
					$collect_product_data['length'] = $product_data['length'];
					$length_val                     = $length_text;
					$temp->set_length( $length_val );
					$temp->save();
					break;
			}
			switch ( $width_select ) {
				case 'add':
					$collect_product_data['width'] = $product_data['width'];
					$width_val                     = $product_data['width'] + $width_text;
					$temp->set_width( $width_val );
					$temp->save();
					break;
				case 'sub':
					$collect_product_data['width'] = $product_data['width'];
					$width_val                     = $product_data['width'] - $width_text;
					$temp->set_width( $width_val );
					$temp->save();
					break;
				case 'replace':
					$collect_product_data['width'] = $product_data['width'];
					$width_val                     = $width_text;
					$temp->set_width( $width_val );
					$temp->save();
					break;
			}
			switch ( $height_select ) {
				case 'add':
					$collect_product_data['height'] = $product_data['height'];
					$height_val                     = $product_data['height'] + $height_text;
					$temp->set_height( $height_val );
					$temp->save();
					break;
				case 'sub':
					$collect_product_data['height'] = $product_data['height'];
					$height_val                     = $product_data['height'] - $height_text;
					$temp->set_height( $height_val );
					$temp->save();
					break;
				case 'replace':
					$collect_product_data['height'] = $product_data['height'];
					$height_val                     = $height_text;
					$temp->set_height( $height_val );
					$temp->save();
					break;
			}
			switch ( $weight_select ) {
				case 'add':
					$collect_product_data['weight'] = $product_data['weight'];
					$weight_val                     = $product_data['weight'] + $weight_text;
					$temp->set_weight( $weight_val );
					$temp->save();
					break;
				case 'sub':
					$collect_product_data['weight'] = $product_data['weight'];
					$weight_val                     = $product_data['weight'] - $weight_text;
					$temp->set_weight( $weight_val );
					$temp->save();
					break;
				case 'replace':
					$collect_product_data['weight'] = $product_data['weight'];
					$weight_val                     = $weight_text;
					$temp->set_weight( $weight_val );
					$temp->save();
					break;
			}
			wc_delete_product_transients( $pid );
		}
		//bundle_product
		if (is_a($temp, 'WC_Product') && $temp->is_type('bundle')) {
			
			$bundle = new WC_Product_Bundle( $temp->get_id() );
			if ( isset( $fields_and_values['bundle_layout'] ) && ! empty( $fields_and_values['bundle_layout'] ) ) {
				$collect_product_data['bundle_layout'] = $bundle->get_layout();
				$bundle->set_layout( $fields_and_values['bundle_layout'] );
				$bundle->save();
			}
			if ( isset( $fields_and_values['bundle_from_location'] ) && ! empty( $fields_and_values['bundle_from_location'] ) ) {
				$collect_product_data['bundle_from_location'] = $bundle->get_add_to_cart_form_location();
				$bundle->set_add_to_cart_form_location( $fields_and_values['bundle_from_location'] );
				$bundle->save();
			}
			if ( isset( $fields_and_values['bundle_item_grouping'] ) && ! empty( $fields_and_values['bundle_item_grouping'] ) ) {
				$collect_product_data['bundle_item_grouping'] = $bundle->get_group_mode();
				$bundle->set_group_mode( $fields_and_values['bundle_item_grouping'] );
				$bundle->save();
			}
			if ( isset( $fields_and_values['bundle_min_size'] ) && ! empty( $fields_and_values['bundle_min_size'] ) ) {
				$collect_product_data['bundle_min_size'] = $bundle->get_min_bundle_size();
				$bundle->set_min_bundle_size( $fields_and_values['bundle_min_size'] );
				$bundle->save();
			}
			if ( isset( $fields_and_values['bundle_max_size'] ) && ! empty( $fields_and_values['bundle_max_size'] ) ) {
				$collect_product_data['bundle_max_size'] = $bundle->get_max_bundle_size();
				$bundle->set_max_bundle_size( $fields_and_values['bundle_max_size'] );
				$bundle->save();
			}
			if ( isset( $fields_and_values['bundle_edit_cart'] ) && ! empty( $fields_and_values['bundle_edit_cart'] ) ) {
				$collect_product_data['bundle_edit_cart'] = $bundle->get_editable_in_cart();
				$bundle->set_editable_in_cart( $fields_and_values['bundle_edit_cart'] );
				$bundle->save();
			}
			$bundled_items = $bundle->get_bundled_items();
			foreach ( $bundled_items as $bundled_item ) {
				$bundle_item_data = $bundled_item->item_data;
				$bundled_item_id  = $bundled_item->get_id();
				/**
				 * Updating Bundle product Item data.
				 * Basic Settings.
				 */
				if ( isset( $fields_and_values['bundle_min_qty'] ) && ! empty( $fields_and_values['bundle_min_qty'] ) ) {
					$collect_product_data['bundle_min_qty'] = $bundle_item_data['quantity_min'];
					elex_update_bundled_item_meta( $bundled_item_id, 'quantity_min', $fields_and_values['bundle_min_qty']);
				}
				if ( isset( $fields_and_values['bundle_max_qty'] ) && ! empty( $fields_and_values['bundle_max_qty'] ) ) {
					$collect_product_data['bundle_max_qty'] = $bundle_item_data['quantity_max'];
					elex_update_bundled_item_meta( $bundled_item_id, 'quantity_max', $fields_and_values['bundle_max_qty']);
				}
				if ( isset( $fields_and_values['bundle_default_qty'] ) && ! empty( $fields_and_values['bundle_default_qty'] ) ) {
					$collect_product_data['bundle_default_qty'] = $bundle_item_data['quantity_default'];
					elex_update_bundled_item_meta( $bundled_item_id, 'quantity_default', $fields_and_values['bundle_default_qty']);
				}
				if ( isset( $fields_and_values['bundle_ship_indi'] ) && ! empty( $fields_and_values['bundle_ship_indi'] ) ) {
					$collect_product_data['bundle_ship_indi'] = $bundle_item_data['shipped_individually'];
					elex_update_bundled_item_meta( $bundled_item_id, 'shipped_individually', $fields_and_values['bundle_ship_indi']);
				}				
				if ( isset( $fields_and_values['bundle_optional'] ) && !empty($fields_and_values['bundle_optional']) ) {
					$collect_product_data['bundle_optional'] = $bundle_item_data['optional'];
					elex_update_bundled_item_meta( $bundled_item_id, 'optional', $fields_and_values['bundle_optional']);
				}
				if ( isset($fields_and_values['bundle_price_individual']) && !empty($fields_and_values['bundle_price_individual']) ) {
					$collect_product_data['bundle_price_individual'] = $bundle_item_data['priced_individually'];
					if ('true' == $fields_and_values['bundle_price_individual']) {
						elex_update_bundled_item_meta( $bundled_item_id, 'priced_individually', 'yes');
					} 
				}
				if ( isset($fields_and_values['elex_bundle_discount']) && !empty($fields_and_values['elex_bundle_discount']) ) {
					$collect_product_data['elex_bundle_discount'] = $bundle_item_data['discount'];
					elex_update_bundled_item_meta( $bundled_item_id, 'discount', $fields_and_values['elex_bundle_discount']);
				}

				/**
				 * Updating Bundle product Item data.
				 * Advanced Settings.
				 */
				if ( isset( $fields_and_values['bundle_product_details'] ) && ! empty( $fields_and_values['bundle_product_details'] ) ) {
					if ( 'visible' ==  $fields_and_values['bundle_product_details'] ) {
						$collect_product_data['bundle_product_details'] = $bundle_item_data['single_product_visibility'];
						elex_update_bundled_item_meta( $bundled_item_id, 'single_product_visibility', $fields_and_values['bundle_product_details'] );

						if ( isset($fields_and_values['bundle_override_title_chkbx']) && !empty($fields_and_values['bundle_override_title_chkbx']) ) {
							$collect_product_data['bundle_override_title_chkbx'] = $bundle_item_data['override_title'];
							elex_update_bundled_item_meta( $bundled_item_id, 'override_title', $fields_and_values['bundle_override_title_chkbx']);

							if ( isset($fields_and_values['bundle_override_title']) && !empty($fields_and_values['bundle_override_title']) ) {
								$collect_product_data['bundle_override_title'] = $bundle_item_data['title'];
								elex_update_bundled_item_meta( $bundled_item_id, 'title', $fields_and_values['bundle_override_title']);
							}
						}
						if ( isset($fields_and_values['bundle_override_shortdescr_chkbx']) && !empty($fields_and_values['bundle_override_shortdescr_chkbx']) ) {
							$collect_product_data['bundle_override_shortdescr_chkbx'] = $bundle_item_data['override_description'];
							elex_update_bundled_item_meta( $bundled_item_id, 'override_description', $fields_and_values['bundle_override_shortdescr_chkbx']);

							if ( isset($fields_and_values['bundle_override_short_desc']) && !empty($fields_and_values['bundle_override_short_desc']) ) {
								$collect_product_data['bundle_override_short_desc'] = $bundle_item_data['description'];
								elex_update_bundled_item_meta( $bundled_item_id, 'description', $fields_and_values['bundle_override_short_desc']);
							}
						}
						if ( isset($fields_and_values['bundle_hidetumb']) && !empty($fields_and_values['bundle_hidetumb']) ) {
							$collect_product_data['bundle_hidetumb'] = $bundle_item_data['hide_thumbnail'];
							elex_update_bundled_item_meta( $bundled_item_id, 'hide_thumbnail', $fields_and_values['bundle_hidetumb']);
						}

					} else {
						$collect_product_data['bundle_product_details'] = $bundle_item_data['single_product_visibility'];
						elex_update_bundled_item_meta( $bundled_item_id, 'single_product_visibility', $fields_and_values['bundle_product_details'] );
					}
				}
				if ( isset($fields_and_values['bundle_cart_checkout']) && !empty($fields_and_values['bundle_cart_checkout']) ) {
					$collect_product_data['bundle_cart_checkout'] = $bundle_item_data['cart_visibility'];
					elex_update_bundled_item_meta( $bundled_item_id, 'cart_visibility', $fields_and_values['bundle_cart_checkout']);
				}
				if ( isset($fields_and_values['bundle_order_details']) && !empty($fields_and_values['bundle_order_details']) ) {
					$collect_product_data['bundle_order_details'] = $bundle_item_data['order_visibility'];
					elex_update_bundled_item_meta( $bundled_item_id, 'order_visibility', $fields_and_values['bundle_order_details']);
				}

				if ( isset($fields_and_values['bundle_price_prod_detail']) && !empty($fields_and_values['bundle_price_prod_detail']) ) {
					$collect_product_data['bundle_price_prod_detail'] = $bundle_item_data['single_product_price_visibility'];
					elex_update_bundled_item_meta( $bundled_item_id, 'single_product_price_visibility', $fields_and_values['bundle_price_prod_detail']);
				}
				if ( isset($fields_and_values['bundle_price_cart']) && !empty($fields_and_values['bundle_price_cart']) ) {
					$collect_product_data['bundle_price_cart'] = $bundle_item_data['cart_price_visibility'];
					elex_update_bundled_item_meta( $bundled_item_id, 'cart_price_visibility', $fields_and_values['bundle_price_cart']);
				}
				if ( isset($fields_and_values['bundle_price_order']) && !empty($fields_and_values['bundle_price_order']) ) {
					$collect_product_data['bundle_price_order'] = $bundle_item_data['order_price_visibility'];
					elex_update_bundled_item_meta( $bundled_item_id, 'order_price_visibility', $fields_and_values['bundle_price_order']);
				}
			
			}
		}	
		// Update product type.
		if ( ! empty( $is_product_type ) && '' !== $is_product_type ) {
			include_once 'class-bulk-edit-change-product-type.php';
			elex_bep_change_product_type( $update_product_type, $is_product_type );
		}

		// Edit Attributes.
		if ( 'variation' !== $temp_type && ! empty( $fields_and_values['attribute'] ) ) {
			$i                   = 0;
			$is_variation        = 0;
			$is_visible          = 0;
			$prev_value          = '';
			$_product_attributes = get_post_meta( $pid, '_product_attributes', true );
			$attr_undo           = $_product_attributes;
			if ( ! empty( $attr_undo ) ) {
				foreach ( $attr_undo as $key => $val ) {
					if ( $val['is_taxonomy'] ) {
						$attr_undo[ $key ]['value'] = wc_get_product_terms( $pid, $key );
					} else {
						// Convert pipes to commas and display values.
						$attr_undo[ $key ]['value'] = $val['value'];
					}
				}
			}
			$collect_product_data['attributes'] = $attr_undo;
			if ( 'add' === $fields_and_values['attribute_variation'] ) {
				$is_variation = 1;
			}
			if ( 'remove' === $fields_and_values['attribute_variation'] ) {
				$is_variation = 0;
			}
			if ( 'add' === $fields_and_values['attr_visible_action'] ) {
				$is_visible = 1;
			}
			if ( 'remove' === $fields_and_values['attr_visible_action'] ) {
				$is_visible = 0;
			}

			if ( ! empty( $fields_and_values['attribute_value'] ) ) {
				foreach ( $fields_and_values['attribute_value'] as $key => $value ) {
					$value     = stripslashes( $value );
					$value     = preg_replace( '/\'/', '', $value );
					$att_slugs = explode( ':', $value );
					if ( '' === $fields_and_values['attribute_variation'] && isset( $_product_attributes[ $att_slugs[0] ] ) ) {
						$is_variation = $_product_attributes[ $att_slugs[0] ]['is_variation'];
					}
					if ( $prev_value !== $att_slugs[0] ) {
						$i = 0;
					}
					if ( '' === $fields_and_values['attr_visible_action'] && isset( $_product_attributes[ $att_slugs[0] ] ) ) {
						$is_visible = $_product_attributes[ $att_slugs[0] ]['is_visible'];
					}
					if ( $prev_value !== $att_slugs[0] ) {
						$i = 0;
					}
					$prev_value = $att_slugs[0];
					if ( 'replace' === $fields_and_values['attribute_action'] && 0 === $i ) {
						wp_set_object_terms( $pid, $att_slugs[1], $att_slugs[0] );
						$i++;
					} else {
						wp_set_object_terms( $pid, $att_slugs[1], $att_slugs[0], true );
					}
					$thedata = array(
						$att_slugs[0] => array(
							'name'         => $att_slugs[0],
							'value'        => $att_slugs[1],
							'is_visible'   => $is_visible,
							'is_taxonomy'  => '1',
							'is_variation' => $is_variation,
						),
					);
					if ( 'add' === $fields_and_values['attribute_action'] || 'replace' === $fields_and_values['attribute_action'] ) {
						$_product_attr = get_post_meta( $pid, '_product_attributes', true );
						if ( ! empty( $_product_attr ) ) {
							update_post_meta( $pid, '_product_attributes', array_merge( $_product_attr, $thedata ) );
						} else {
							update_post_meta( $pid, '_product_attributes', $thedata );
						}
						$product = wc_get_product( $pid );           
						if ( class_exists(Automattic\WooCommerce\Internal\ProductAttributesLookup\LookupDataStore::class ) ) {             
							$data_store = new Automattic\WooCommerce\Internal\ProductAttributesLookup\LookupDataStore();          
							$data_store->create_data_for_product( $product );    
						}
					}
					if ( 'remove' === $fields_and_values['attribute_action'] ) {
						wp_remove_object_terms( $pid, $att_slugs[1], $att_slugs[0] );
						$get_attributes_values = get_the_terms( $pid, $att_slugs[0] );
						if ( '' == $get_attributes_values ) {
							$_product_attr = get_post_meta( $pid, '_product_attributes', true );
							if ( ! empty( $_product_attr ) ) {
								unset( $_product_attr[ $att_slugs[0] ] );
								update_post_meta( $pid, '_product_attributes', $_product_attr );
							}
						}
					}
				}
			}
			if ( ! empty( $fields_and_values['attribute'] ) || '' !== $fields_and_values['attribute'] && empty( $fields_and_values['new_attribute_values'] ) && empty( $fields_and_values['attribute_value'] )) {
				$ar1 = explode( ',', $fields_and_values['attribute'] );
				foreach ( $ar1 as $key => $value ) {
					$att_s = 'pa_' . $value;
					if ( '' === $fields_and_values['attribute_variation'] && isset( $_product_attributes[ $att_s ] ) ) {
						$is_variation = $_product_attributes[ $att_s ]['is_variation'];
					}
					$thedata       = array(
						$att_s => array(
							'name'         => $att_s,
							'is_visible'   => $is_visible,
							'is_taxonomy'  => '1',
							'is_variation' => $is_variation,
						),
					);
					$_product_attr = get_post_meta( $pid, '_product_attributes', true );
					if ( ! empty( $_product_attr ) ) {
						if ( array_key_exists( $att_s, $_product_attr ) ) {
							update_post_meta( $pid, '_product_attributes', array_merge( $_product_attr, $thedata ) );
						}
					} else {
						update_post_meta( $pid, '_product_attributes', $thedata );
						
					}
				}
				
			}
			if ( ! empty( $fields_and_values['new_attribute_values'] ) || '' !== $fields_and_values['new_attribute_values'] ) {
				$ar1 = explode( ',', $fields_and_values['attribute'] );
				foreach ( $ar1 as $key => $value ) {
					foreach ( $fields_and_values['new_attribute_values'] as $key_index => $value_slug ) {
						$att_s = 'pa_' . $value;
						if ( $prev_value !== $att_s ) {
							$i = 0;
						}
						if ( '' === $fields_and_values['attribute_variation'] && isset( $_product_attributes[ $att_s ] ) ) {
							$is_variation = $_product_attributes[ $att_s ]['is_variation'];
						}
						$prev_value = $att_s;
						if ( 'replace' === $fields_and_values['attribute_action'] && 0 === $i ) {
							wp_set_object_terms( $pid, $value_slug, $att_s );
							$i++;
						} else {
							wp_set_object_terms( $pid, $value_slug, $att_s, true );
						}
						$thedata = array(
							$att_s => array(
								'name'         => $att_s,
								'value'        => $value_slug,
								'is_visible'   => $is_visible,
								'is_taxonomy'  => '1',
								'is_variation' => $is_variation,
							),
						);
						if ( 'add' === $fields_and_values['attribute_action'] || 'replace' === $fields_and_values['attribute_action'] ) {
							$_product_attr = get_post_meta( $pid, '_product_attributes', true );
							if ( ! empty( $_product_attr ) ) {
								update_post_meta( $pid, '_product_attributes', array_merge( $_product_attr, $thedata ) );
							} else {
								update_post_meta( $pid, '_product_attributes', $thedata );
								
							}
							$product = wc_get_product( $pid );           
							if ( class_exists(Automattic\WooCommerce\Internal\ProductAttributesLookup\LookupDataStore::class ) ) {             
							   $data_store = new Automattic\WooCommerce\Internal\ProductAttributesLookup\LookupDataStore();          
								$data_store->create_data_for_product( $product );    
							}
						}
					}
				}
			}
		}

		// tag.
		$collect_product_data['tag_ids'] = array();
		if ( ! empty( $fields_and_values['tag_values'] && 'variation' !== $temp_type ) ) {

			$tag_ids_list_presents           = get_the_terms( $pid, 'product_tag' );
			$collect_product_data['tag_ids'] = wp_list_pluck( $tag_ids_list_presents, 'term_id' );
			$collect_product_data['tag_ids'] = array_map( 'intval', $collect_product_data['tag_ids'] );
			$collect_product_data['tag_ids'] = array_unique( $collect_product_data['tag_ids'] );
			if ( 'replace' === $fields_and_values['tag_action'] ) {

				wp_set_object_terms( $pid, $fields_and_values['tag_values'], 'product_tag' );

			} elseif ( 'add' === $fields_and_values['tag_action'] ) {

				wp_set_object_terms( $pid, $fields_and_values['tag_values'], 'product_tag', true );

			} elseif ( 'remove' === $fields_and_values['tag_action'] ) {

				wp_remove_object_terms( $pid, $fields_and_values['tag_values'], 'product_tag' );

			}
		}
		$collect_product_data['variation_ids'] = array();
		$variable_product_ids_query            = "SELECT DISTINCT ID FROM {$prefix}posts LEFT JOIN {$prefix}term_relationships on {$prefix}term_relationships.object_id={$prefix}posts.ID LEFT JOIN {$prefix}term_taxonomy on {$prefix}term_taxonomy.term_taxonomy_id  = {$prefix}term_relationships.term_taxonomy_id LEFT JOIN {$prefix}terms on {$prefix}terms.term_id={$prefix}term_taxonomy.term_id LEFT JOIN {$prefix}postmeta on {$prefix}postmeta.post_id={$prefix}posts.ID WHERE taxonomy='product_type'  AND slug  IN ('variable') AND post_status IN ('publish', 'private','draft')";
		$variable_product_ids                  = $wpdb->get_results( ( $wpdb->prepare( '%1s', $variable_product_ids_query ) ? stripslashes( $wpdb->prepare( '%1s', $variable_product_ids_query ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );
		$variable_product_ids_array            = wp_list_pluck( $variable_product_ids, 'ID' );
		if ( in_array( $pid, $variable_product_ids_array ) ) { // Since, woocommerce product cache doesn't get updated on product type update. Get all the variation ids and compare it with the current id.
			// collect product data of current variable product (if any variations it has).
			$current_variation_ids = wc_get_product( $pid )->get_children();
			if ( ! empty( $current_variation_ids ) ) {
				$collect_product_data['variation_ids'] = $current_variation_ids;
			}

			// create variation only if checkbox is true and if there is any variation attribute available to create it.
			$product = new WC_Product_Variable( $pid );
			if ( 'true' == $fields_and_values['create_variations'] && ! empty( $product->get_variation_attributes() ) ) {
				$_regular_price = (float) $fields_and_values['variation_regular_price'];
				$_sale_price    = (float) $fields_and_values['variation_sale_price'];
				$attributes     = wc_list_pluck( array_filter( $product->get_attributes(), 'wc_attributes_array_filter_variation' ), 'get_slugs' );

				// Get existing variations so we don't create duplicates.
				$existing_variations = array_map( 'wc_get_product', $product->get_children() );
				$existing_attributes = array();

				foreach ( $existing_variations as $existing_variation ) {
					$existing_attributes[] = $existing_variation->get_attributes();
				}

				$possible_attributes = array_reverse( wc_array_cartesian( $attributes ) );
				foreach ( $possible_attributes as $possible_attribute ) {
					// Allow any order if key/values -- do not use strict mode.
					if ( ! in_array( $possible_attribute, $existing_attributes ) ) {
						$variation = wc_get_product_object( 'variation' );
						$variation->set_parent_id( $product->get_id() );
						$variation->set_attributes( $possible_attribute );
						$variation->set_regular_price( $_regular_price );
						if ( 0.00 !== $_sale_price ) { // 0.00 instead of 0, as 0 is considered int and $sale_price type is float.
							$variation->set_sale_price( $_sale_price );
						}
						$variation_id = $variation->save();
						/**
						 * Trigger the product variation linked action.
						 *
						 * This action is fired when a product variation is linked, allowing other functions or plugins 
						 * to hook into this action and perform additional tasks whenever a product variation is linked.
						 *
						 * @param int $variation_id The ID of the product variation that has been linked.
						 *
						 * @hook product_variation_linked
						 * @since 1.0.0
						 */
						do_action( 'product_variation_linked', $variation_id );
					}
				}
			}
		}

		// Custom Attribute.
		// Remove Custom Attributes.
		if ( 'variation' != $temp_type && ! empty( $fields_and_values['custom_attribute_to_edit'] ) ) {
			$current_product_attributes = get_post_meta( $pid, '_product_attributes', true );
			if ( 'remove' == $fields_and_values['custom_attribute_action'] && !empty($current_product_attributes)) {
				$custom_attribute_to_edit_array                          = explode( ',', $fields_and_values['custom_attribute_to_edit'] );
				$collect_product_data['removed_custom_attributes_array'] = array();
				// Check if the specified custom attribute exists in that array.
				foreach ( $custom_attribute_to_edit_array as $key => $value ) {
					if ( array_key_exists( $value, $current_product_attributes ) && 0 === intval( $current_product_attributes[ $value ]['is_taxonomy'] ) ) {
						// Remove that custom attribute.
						$collect_product_data['custom_attribute_action']                   = $fields_and_values['custom_attribute_action'];
						$collect_product_data['removed_custom_attributes_array'][ $value ] = $current_product_attributes[ $value ];
						unset( $current_product_attributes[ $value ] );
					}
				}
				update_post_meta( $pid, '_product_attributes', $current_product_attributes );
			}
		}

		$existing_cat = wp_get_object_terms( $pid, 'product_cat' );
		// undo data.
		$undo_cat_data = array();
		foreach ( $existing_cat as $key => $val ) {
			array_push( $undo_cat_data, $val->term_id );
		}
		$collect_product_data['categories'] = $undo_cat_data;

		// category feature.
		if ( 'cat_none' !== $fields_and_values['category_update_option'] && isset( $fields_and_values['categories_to_update'] ) ) {
			$temparr                              = array();
			$edit_data['categories']              = $undo_cat_data;
			$collect_product_data['category_opn'] = $fields_and_values['category_update_option'];
			$edit_data['category_opn']            = $fields_and_values['category_update_option'];

			if ( 'cat_add' === $fields_and_values['category_update_option'] ) {
				$temparr = array();
				foreach ( $existing_cat as $cat_key => $cat_val ) {
					array_push( $temparr, (int) $cat_val->term_id );
				}
				foreach ( $fields_and_values['categories_to_update'] as $key => $value ) {
					if ( ! in_array( (int) $value, $temparr, true ) ) {
						array_push( $temparr, (int) $value );
					}
				}
				wp_set_object_terms( $pid, $temparr, 'product_cat' );
			} elseif ( 'cat_replace' === $fields_and_values['category_update_option'] ) {
				$temparr = array();
				foreach ( $fields_and_values['categories_to_update'] as $key => $val ) {
					array_push( $temparr, (int) $val );
				}
					wp_set_object_terms( $pid, $temparr, 'product_cat' );
			} elseif ( 'cat_remove' === $fields_and_values['category_update_option'] ) {
				$temparr_remove = array();
				foreach ( $existing_cat as $cat_rem_key => $cat_rem_val ) {

					if ( ! in_array( (int) $cat_rem_val->term_id, $fields_and_values['categories_to_update'] ) ) {
						array_push( $temparr_remove, (int) $cat_rem_val->term_id );
					}
				}
				wp_set_object_terms( $pid, $temparr_remove, 'product_cat' );
			}
		}
		// update custom meta with help of code snippet.
		if ( isset( $fields_and_values['custom_meta'] ) && '' !== $fields_and_values['custom_meta'] ) {
			$current_val                         = array();
			$current_val                         = eh_bep_update_custom_meta( $pid, $fields_and_values['custom_meta'] );
			$edit_data['custom_meta']            = $fields_and_values['custom_meta'];
			$collect_product_data['custom_meta'] = $current_val;
		}
		$edit_data['delete_product']            = '';
		$collect_product_data['delete_product'] = '';
		if ( isset( $fields_and_values['delete_product_action'] ) && '' !== $fields_and_values['delete_product_action'] ) {
			if ( 'move_to_trash' === $fields_and_values['delete_product_action'] ) {
				$edit_data['delete_product']            = $pid;
				$collect_product_data['delete_product'] = $pid;
				$temp->delete( false );
			} else {
				$temp->delete( true );
				$undo_update = 'no';
				delete_option( 'eh_bulk_edit_undo_edit_data' );
			}
		}
		$undo_product_data[ $pid ]       = $collect_product_data;
		$collect_product_data_serialized = maybe_serialize($collect_product_data);
		$values                          = [
			'job_id'            => $job_id,
			'product_id'        => $pid,
			'undo_product_data' => $collect_product_data_serialized 
		];
		revert_data_into_database( $values );
		wc_delete_product_transients( $pid );
		$product = wc_get_product( $pid );  
		/**
		 * Trigger the WooCommerce product update action.
		 *
		 * This action is fired when a product is updated in WooCommerce.
		 * It allows other functions or plugins to hook into this action and perform additional tasks 
		 * whenever a product is updated.
		 *
		 * @param int $pid     The ID of the product being updated.
		 * @param WC_Product $product The product object being updated.
		 *
		 * @hook woocommerce_update_product
		 * @since 1.0.0
		 */
		do_action( 'woocommerce_update_product', $pid, $product );
		
	}
	if ( '' !== $visibility_action ) {
		elex_bep_set_password_for_product( $category_password, $update_product_type, $visibility_action );
	}
	if ( 0 === intval( $fields_and_values['index_val'] ) ) {
		update_option( 'eh_temp_product_id', $undo_product_data );
	} else {
		$update_pid = array();
		$update_pid = get_option( 'eh_temp_product_id' );
		$update_pid = array_merge( $update_pid, $undo_product_data );
		update_option( 'eh_temp_product_id', $update_pid );
	}
	$prod_id = get_option( 'eh_temp_product_id' );
	if ( 'true' == $fields_and_values['create_log_file'] ) {
		$upload_dir = wp_upload_dir();
		$base       = $upload_dir['basedir'];
		$log_path   = $base . '/elex-bulk-edit-products/';
		if ( ! file_exists( $log_path ) ) {
			wp_mkdir_p( $log_path );
		}
		$file_name = $job_name;
		if ( '' !== $sch_jobs ) {
			$file_name = $sch_jobs['job_name'];
		}
		$file_name = str_replace( ' ', '_', $file_name );
		$file      = fopen( $log_path . '/' . $file_name . '.txt', 'w' );
		fwrite( $file, print_r( $prod_id, true ) );
		fclose( $file );
	}
	if ( intval( $fields_and_values['index_val'] ) === intval( $fields_and_values['chunk_length'] - 1 ) ) {
		if ( '' === $sch_jobs && 'bulk_update_now' === sanitize_text_field( $_POST['scheduled_action'] ) && 'true' == sanitize_text_field( $_POST['save_job'] ) ) {
			$param                  = array();
			$param['param_to_save'] = $fields_and_values;
			if ( 0 !== intval( sanitize_text_field( $_POST['index_val'] ) ) ) {
				$prev_ids                      = get_option( 'elex_bep_product_ids_to_schedule' );
				$current_ids                   = array_map( 'sanitize_text_field', wp_unslash( $_POST['pid'] ) );
				$res_id                        = array_merge( $prev_ids, $current_ids );
				$param['param_to_save']['pid'] = $res_id;
				delete_option( 'elex_bep_product_ids_to_schedule' );
			}
			$param['job_name']        = $job_name;
			$param['create_log_file'] = sanitize_text_field( $_POST['create_log_file'] );
			if ( 'yes' === $undo_update ) {
				$param['revert_data'] = $prod_id;
				$param['edit_data']   = $edit_data;
			}

			if ( ( isset( $_POST['is_edit_job'] ) && sanitize_text_field( $_POST['is_edit_job'] ) == 'true' ) ) {
				if ( 'schedule_later' === $fields_and_values['scheduled_action'] ) {
					$schedule_on_date      = $param['schedule_date'];
					$schedule_on_time_hour = $param['scheduled_hour'];
					$schedule_on_time_min  = $param['scheduled_min'];
					$revert_date           = $param['revert_date'];
					$revert_time_hour      = $param['revert_hour'];
					$revert_time_min       = $param['revert_min'];
					  
					$revert_on = date_create($revert_date);
					$revert_on->setTime( $revert_time_hour, $revert_time_min);
					$revert_on   = $revert_on->format('Y-m-d H:i:s');
					$schedule_on = date_create( $shedule_date );
					$schedule_on->setTime( $shedule_time_hour, $shedule_time_min);
					$schedule_on = $revert_on->format('Y-m-d H:i:s');
				} else {
					$schedule_on        = null;
					$revert_on          = null; 
					$stop_schedule      = null;
					$schedule_frequency = null;
				}
				 $filter_data            = $param['param_to_save'];
				 $filter_data_serialized = maybe_serialize($filter_data);
				 $edit_data              = $param['edit_data'];
				 $edit_data_serialized   = maybe_serialize($edit_data);
					$values              =  [
						'job_name'        => $param['job_name'],
						'filter_data'     => $filter_data_serialized,
						'edit_data'       => $edit_data_serialized,
						'create_log_file' => $create_log,
						'schedule_on'     => $schedule_on,
						'revert_on'       => $revert_on,
						'is_reversible'   => true,
						'job_id'          => $job_id,
						'stop_schedule'   => $stop_schedule,
						'schedule_frequency'=> $schedule_frequency	
					];
				 $result_job_id          = insert_data_into_database( $values );
					

			} else {
				if ( 'schedule_later' === $fields_and_values['scheduled_action'] ) {
					$schedule_on_date      = $param['schedule_date'];
					$schedule_on_time_hour = $param['scheduled_hour'];
					$schedule_on_time_min  = $param['scheduled_min'];
					$revert_date           = $param['revert_date'];
					$revert_time_hour      = $param['revert_hour'];
					$revert_time_min       = $param['revert_min'];
					  
					$revert_on = date_create($revert_date);
					$revert_on->setTime( $revert_time_hour, $revert_time_min);
					$revert_on   = $revert_on->format('Y-m-d H:i:s');
					$schedule_on = date_create( $shedule_date );
					$schedule_on->setTime( $shedule_time_hour, $shedule_time_min);
					$schedule_on = $revert_on->format('Y-m-d H:i:s');
				} else {
					$schedule_on        = null;
					$revert_on          = null; 
					$stop_schedule      = null;
					$schedule_frequency = null;
				}
				 $filter_data            = $param['param_to_save'];
				 $filter_data_serialized = maybe_serialize($filter_data);
				 $edit_data              = $param['edit_data'];
				 $edit_data_serialized   = maybe_serialize($edit_data);
					$values              =  [
						'job_name'        => $param['job_name'],
						'filter_data'     => $filter_data_serialized,
						'edit_data'       => $edit_data_serialized,
						'create_log_file' => $create_log,
						'schedule_on'     => $schedule_on,
						'revert_on'       => $revert_on,
						'is_reversible'   => true,
						'job_id'          => $job_id,
						'stop_schedule'   => $stop_schedule,
						'schedule_frequency'=> $schedule_frequency	
					];
				 $result_job_id          = insert_data_into_database( $values );
			}
		}
		if ( '' === $sch_jobs ) {
			array_push( $sale_warning, 'done' );
			$array = array(
				'is_completed' => 'done', 
				'job_name'    => $job_name
			);
			die( wp_json_encode( $array ) );
		}
	} else {
		if ( '' === $sch_jobs && 'bulk_update_now' === sanitize_text_field( $_POST['scheduled_action'] ) && 'true' == sanitize_text_field( $_POST['save_job'] ) ) {
			$saved_pids_ = get_option( 'elex_bep_product_ids_to_schedule' );

			if ( empty( $saved_pids_ ) ) {
				update_option( 'elex_bep_product_ids_to_schedule', array_map( 'sanitize_text_field', wp_unslash( $_POST['pid'] ) ) );
			} else {
				$result_ids = array_merge( $saved_pids_, $fields_and_values['pid'] );
				update_option( 'elex_bep_product_ids_to_schedule', $result_ids );
			}
		}
	}
	if ( '' !== $sch_jobs ) {
		return array(
			'edit_data'     => $edit_data,
			'undo_products' => $prod_id,
			'job_id' => $job_id,
		);
	}
	if ( '' === $sch_jobs ) {
		$sale_warning['job_id'] = $job_id;
		die( wp_json_encode( $sale_warning ) );
	}

}

/** Update meta.
 *
 * @param number $id    id.
 * @param string $key   key.
 * @param string $value value.
 */
function eh_bep_update_meta_fn( $id, $key, $value ) {
	$product = wc_get_product( $id );
	$product->update_meta_data( $key, $value );
	$product->save();
}

/** List table. */
function eh_bep_list_table_all_callback() {
	check_ajax_referer( 'ajax-eh-bep-nonce', '_ajax_eh_bep_nonce' );
	$obj = new Eh_DataTables();
	$obj->input();
	$obj->ajax_response( '1' );
}

/** Clear. */
function eh_clear_all_callback() {
	check_ajax_referer( 'ajax-eh-bep-nonce', '_ajax_eh_bep_nonce' );
	update_option( 'eh_bulk_edit_choosed_product_id', eh_bep_get_first_products() );
	$obj = new Eh_DataTables();
	$obj->input();
	$obj->ajax_response();
}

/** Search filter. */
function eh_bep_search_filter_callback() {
	set_time_limit( 300 );
	check_ajax_referer( 'ajax-eh-bep-nonce', '_ajax_eh_bep_nonce' );
	$obj_fil = new Eh_DataTables();
	$obj_fil->input();
	$obj_fil->ajax_response( '1' );
}

/** Undo html. */
function eh_bep_undo_html_maker() {
	global $wpdb;
	$prefix = $wpdb->prefix;
	check_ajax_referer( 'ajax-eh-bep-nonce', '_ajax_eh_bep_nonce' );
	if ( isset( $_POST['file'] ) ) {
			$job_name       = isset($_POST['file']) ? sanitize_file_name($_POST['file']) : '';
			$scheduled_jobs = wpFluent()->table( 'elex_bep_jobs' )->where( 'job_name', '=', $job_name)->select( '*' )->get();
			$scheduled_jobs = reset($scheduled_jobs);
		$scheduled_jobs     = (array) $scheduled_jobs;
		$undo_data          = unserialize( $scheduled_jobs['edit_data']);
	} else {
		$undo_data = get_option( 'eh_bulk_edit_undo_edit_data', array() );
	}
	ob_start();
	if ( ! empty( $undo_data ) ) {
		?>
		<div class='wrap postbox table-box table-box-main' id="undo_update" style='padding:0px 20px;'>
		<input hidden name="filenameTable" id="filenameTable" value="<?php echo esc_attr( $job_name ) ; ?>">
			<h2>
				<?php esc_html_e( 'Undo the Update - Overview', 'eh_bulk_edit' ); ?>
			</h2>
			<hr>
			<table class='eh-edit-table' id='update_general_table'>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['title_select'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='title'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Title', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select a condition to edit the title, and enter the relevant text', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['title_select'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'set_new':
								?>
								<span><?php esc_html_e( 'Set New [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'append':
								?>
								<span><?php esc_html_e( 'Append [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'prepand':
								?>
								<span><?php esc_html_e( 'Prepend [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'replace':
								?>
								<span><?php esc_html_e( 'Replace [ ', 'eh_bulk_edit' ); ?></Span>
								<?php
								break;
							case 'regex_replace':
								?>
								<span><?php esc_html_e( 'RegEx Replace [ ', 'eh_bulk_edit' ); ?></Span>
								<?php
								break;
							case 'sentence_key':
								?>
								<span><?php esc_html_e( 'Sentence key [ ', 'eh_bulk_edit' ); ?></Span>
								<?php
								break;
							default:
								break;
						}
						?>
						<span id='title_text'>
							<?php
							switch ( $undo_data['title_select'] ) {
								case '':
									break;
								case 'replace':
									?>
									<span style="background: whitesmoke">Text to be replaced : <b><?php $undo_data['replace_title_text']; ?></b> -> Replace Text : <b><?php $undo_data['title_text']; ?></b></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
								case 'regex_replace':
									?>
									<span style="background: whitesmoke">Pattern : <b><?php $undo_data['regex_replace_title_text']; ?></b> -> Replacement : <b><?php $undo_data['title_text']; ?></b></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
								default:
									?>
									<span style="background: whitesmoke"><b><?php $undo_data['title_text']; ?></b></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
							}
							?>
						</span>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['sku_select'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='sku'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'SKU', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select a condition to edit the SKU and enter the relevant text. When updating a new SKU for multiple products, include padding and a delimiter.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['sku_select'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'set_new':
								?>
								<span><?php esc_html_e( 'Set New [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'append':
								?>
								<span><?php esc_html_e( 'Append [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'prepand':
								?>
								<span><?php esc_html_e( 'Prepend [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'replace':
								?>
								<span><?php esc_html_e( 'Replace [ ', 'eh_bulk_edit' ); ?></Span>
								<?php
								break;
							case 'regex_replace':
								?>
								<span><?php esc_html_e( 'RegEx_Replace [ ', 'eh_bulk_edit' ); ?></Span>
								<?php
								break;
							default:
								break;
						}
						?>
						<span id='sku_text'>
							<?php
							switch ( $undo_data['sku_select'] ) {
								case '':
									break;
								case 'replace':
									?>
									<span style="background: whitesmoke">Text to be replaced : <b><?php $undo_data['sku_replace_text']; ?></b> -> Replace Text : <b><?php $undo_data['sku_text']; ?></b></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
								case 'regex_replace':
									?>
									<span style="background: whitesmoke">Pattern : <b><?php $undo_data['regex_sku_replace_text']; ?></b> -> Replacement : <b><?php $undo_data['sku_text']; ?></b></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
								default:
									?>
									<span style="background: whitesmoke"><b><?php $undo_data['sku_text']; ?></b></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
							}
							?>
						</span>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['catalog_select'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='catalog'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Product Visiblity', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Choose which all shop pages the product will be listed on', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['catalog_select'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'visible':
								?>
								<span><?php esc_html_e( 'Shop and Search', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'catalog':
								?>
								<span><?php esc_html_e( 'Shop', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'search':
								?>
								<span><?php esc_html_e( 'Search', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'hidden':
								?>
								<span><?php esc_html_e( 'Hidden', 'eh_bulk_edit' ); ?></Span>
								<?php
								break;
							default:
								break;
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['featured'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='featured'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Featured Product', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select an option to make the product(s) Featured or not.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['featured'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'yes':
								?>
								<span><?php esc_html_e( 'Yes', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'no':
								?>
								<span><?php esc_html_e( 'No', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							default:
								break;
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['is_product_type'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='product_type'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Product Type', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select an option to make the product(s) Featured or not.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['is_product_type'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'simple':
								?>
								<span><?php esc_html_e( 'Product type changed to simple', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'variable':
								?>
								<span><?php esc_html_e( 'Product type changed to variable', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							default:
								break;
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['shipping_select'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='shipping'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Shipping Class', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select a shipping class that will be added to all the filtered products', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['shipping_select'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case '-1':
								?>
								<span><?php esc_html_e( 'Shipping Class : No Shipping Class', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							default:
								?>
								<span><?php esc_html_e( 'Shipping Class : ', 'eh_bulk_edit' ) . get_term( $undo_data['shipping_select'] )->name; ?></span>
								<?php
								break;
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if ( isset( $undo_data['description'] )) {
							if ( $undo_data['description'] ) {
								switch ( $undo_data['description'] ) {
									case '':
										break;
									default:
										?>
										<input type="checkbox" name='undo_checkbox_values' checked value='description'>
										<?php
										break;
								}
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Description', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='
						<?php esc_html_e( 'Select a condition to edit or add the description, and enter the relevant text.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if ( isset( $undo_data['description'] )) {
							switch ( $undo_data['description'] ) {
								case '':
									?>
									<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
									<?php
									break;
								default:
									?>
									<span><?php esc_html_e( 'Description updated', 'eh_bulk_edit' ); ?></span>
									<?php
									break;
							}
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if ( isset($undo_data['short_description'] )) {
							switch ( $undo_data['short_description'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='short_description'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Short description', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Short description', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if ( isset($undo_data['short_description'] )) {
							switch ( $undo_data['short_description'] ) {
								case '':
									?>
									<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
									<?php
									break;
								default:
									?>
									<span><?php esc_html_e( 'Short description updated', 'eh_bulk_edit' ); ?></span>
									<?php
									break;
							}
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if ( isset($undo_data['main_image'] )) {
							switch ( $undo_data['main_image'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='main_image'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Product image', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Specify an image url to add or replace the product image.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if ( isset($undo_data['main_image'] )) {
							switch ( $undo_data['main_image'] ) {
								case '':
									?>
									<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
									<?php
									break;
								default:
									?>
									<span><?php esc_html_e( 'Updated product image', 'eh_bulk_edit' ); ?></span>
									<?php
									break;
							}
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['gallery_images'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='gallery_images'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Product gallery images Action', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select a condition to modify product gallery images.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['gallery_images'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'add':
								?>
								<span><?php esc_html_e( 'Added', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'remove':
								?>
								<span><?php esc_html_e( 'Removed', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'replace':
								?>
								<span><?php esc_html_e( 'Replaced', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
						}
						?>
					</td>
				</tr>

				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['product_visibility_action'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='product_visibility'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Product Visibility Status', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select an option to make the product(s) Visible or not.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['product_visibility_action'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							default:
								?>
								<span><?php esc_html_e( 'Product visibility Status updated', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
						}
						?>
					</td>
				</tr>

			</table>
			<h2>
				<?php esc_html_e( 'Price', 'eh_bulk_edit' ); ?>
			</h2>
			<hr>
			<table class='eh-edit-table' id="update_price_table"> 
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['regular_select'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='regular'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Regular Price', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select a condition to adjust the price and enter the value. You can also choose an option to round it to the nearest value', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['regular_select'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'up_percentage':
								?>
								<span><?php esc_html_e( 'Increased by Percentage ( + %) [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'down_percentage':
								?>
								<span><?php esc_html_e( 'Decreased by Percentage ( - %) [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'up_price':
								?>
								<span><?php esc_html_e( 'Increased by Price ( + $) [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'down_price':
								?>
								<span><?php esc_html_e( 'Decreased by Price ( - $) [ ', 'eh_bulk_edit' ); ?></Span>
								<?php
								break;
							case 'flat_all':
								?>
								<span><?php esc_html_e( 'Flat Price for all [ ', 'eh_bulk_edit' ); ?></Span>
								<?php
								break;

							default:
								break;
						}
						?>
						<span id='regular_price_text'>
							<?php
							switch ( $undo_data['regular_select'] ) {
								case '':
									break;
								case 'up_percentage':
									?>
									<span style="background: whitesmoke"><?php esc_html_e( 'Percentage : ', 'eh_bulk_edit' ) . $undo_data['regular_text'] . ' %'; ?></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
								case 'down_percentage':
									?>
									<span style="background: whitesmoke"><?php esc_html_e( 'Percentage : ', 'eh_bulk_edit' ) . $undo_data['regular_text'] . ' %'; ?></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
								case 'up_price':
									?>
									<span style="background: whitesmoke"><?php esc_html_e( 'Amount : ', 'eh_bulk_edit' ) . $undo_data['regular_text'] . ' %'; ?></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
								case 'down_price':
									?>
									<span style="background: whitesmoke"><?php esc_html_e( 'Amount : ', 'eh_bulk_edit' ) . $undo_data['regular_text'] . ' %'; ?></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
								case 'flat_all':
									?>
									<span style="background: whitesmoke"><?php esc_html_e( 'Amount : ', 'eh_bulk_edit' ) . $undo_data['regular_text'] . ' %'; ?></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
								default:
									break;
							}
							?>
						</span>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['sale_select'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='sale'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Sale Price', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select a condition to adjust the price and enter the value. You can also choose an option to round it to the nearest value', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['sale_select'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'up_percentage':
								?>
								<span><?php esc_html_e( 'Increased by Percentage ( + %) [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'down_percentage':
								?>
								<span><?php esc_html_e( 'Decreased by Percentage ( - %) [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'up_price':
								?>
								<span><?php esc_html_e( 'Increased by Price ( + $) [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'down_price':
								?>
								<span><?php esc_html_e( 'Decreased by Price ( - $) [ ', 'eh_bulk_edit' ); ?></Span>
								<?php
								break;
							case 'flat_all':
								?>
								<span><?php esc_html_e( 'Flat Price for all [ ', 'eh_bulk_edit' ); ?></Span>
								<?php
								break;

							default:
								break;
						}
						?>
						<span id='sale_price_text'>
							<?php
							switch ( $undo_data['sale_select'] ) {
								case '':
									break;
								case 'up_percentage':
									?>
									<span style="background: whitesmoke"><?php esc_html_e( 'Percentage : ', 'eh_bulk_edit' ) . $undo_data['sale_text'] . ' %'; ?></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
								case 'down_percentage':
									?>
									<span style="background: whitesmoke"><?php esc_html_e( 'Percentage : ', 'eh_bulk_edit' ) . $undo_data['sale_text'] . ' %'; ?></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
								case 'up_price':
									?>
									<span style="background: whitesmoke"><?php esc_html_e( 'Amount : ', 'eh_bulk_edit' ) . $undo_data['sale_text'] . ' %'; ?></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
								case 'down_price':
									?>
									<span style="background: whitesmoke"><?php esc_html_e( 'Amount : ', 'eh_bulk_edit' ) . $undo_data['sale_text'] . ' %'; ?></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
								case 'flat_all':
									?>
									<span style="background: whitesmoke"><?php esc_html_e( 'Amount : ', 'eh_bulk_edit' ) . $undo_data['sale_text'] . ' %'; ?></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
								default:
									break;
							}
							?>
						</span>
					</td>
				</tr>
			</table>
			<?php
			/**
			 * Check if the WooCommerce Product Bundles plugin is active.
			 *
			 * This checks if the 'woocommerce-product-bundles/woocommerce-product-bundles.php' plugin
			 * is active by utilizing the 'active_plugins' filter to retrieve the list of currently active plugins.
			 *
			 * @hook active_plugins
			 * @since 1.0.0
			 */
			if (in_array( 'woocommerce-product-bundles/woocommerce-product-bundles.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true )) {
				?>
			<h2>
				<?php esc_html_e( 'Bundle Product', 'eh_bulk_edit' ); ?>
			</h2>
			<table class='eh-edit-table'>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_layout'])) {
							switch ( $undo_data['bundle_layout'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_layout'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Layout Action', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select the Tabular option to have the thumbnails, descriptions and quantities of bundled products arranged in a table. Recommended for displaying multiple bundled products with configurable quantities.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_layout'])) {
							switch ( $undo_data['bundle_layout'] ) {
								case 'default':
									?>
										<span><?php esc_html_e( 'Standard', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
								case 'tabular':
									?>
										<span><?php esc_html_e( 'Tabular', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
								case 'grid':
									?>
										<span><?php esc_html_e( 'Grid', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
							}
						} else {
							?>
									<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_from_location'])) {
							switch ( $undo_data['bundle_from_location'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_from_location'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Form Location', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'The add-to-cart form can be displayed either within the single-product summary (default) or before the single-product tabs, the latter typically allowing full page width but may not be supported by all themes.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_from_location'])) {
							switch ( $undo_data['bundle_from_location'] ) {
								case 'default':
									?>
									<span><?php esc_html_e( 'Default', 'eh_bulk_edit' ); ?></span>
									<?php
									break;
								case 'after_summary':
									?>
									<span><?php esc_html_e( 'Before Tabs', 'eh_bulk_edit' ); ?></span>
									<?php
									break;
							}
						} else {
							?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
							<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_item_grouping'])) {
							switch ( $undo_data['bundle_item_grouping'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_layout'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Item Grouping', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Controls the grouping of parent/child line items in cart/order templates.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_item_grouping'])) {
							switch ( $undo_data['bundle_item_grouping'] ) {
								case 'parent':
									?>
									<span><?php esc_html_e( 'Grouped', 'eh_bulk_edit' ); ?></span>
									<?php
									break;
								case 'noindent':
									?>
									<span><?php esc_html_e( 'Flat', 'eh_bulk_edit' ); ?></span>
									<?php
									break;
								case 'none':
									?>
									<span><?php esc_html_e( 'None', 'eh_bulk_edit' ); ?></span>
									<?php
									break;
							}
						} else {
							?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
							<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_min_size'])) {
							switch ( $undo_data['bundle_min_size'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_layout'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Min Bundle Size', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Minimum combined quantity of bundled items.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_min_size'])) { 
							?>
							<span><?php esc_html_e( $undo_data['bundle_min_size'], 'eh_bulk_edit' ); ?></span>
							<?php
						} else {
							?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
							<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_max_size'])) {
							switch ( $undo_data['bundle_max_size'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_max_size'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Max Bundle Size', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Maximum combined quantity of bundled items.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_max_size'])) { 
							?>
							<span><?php esc_html_e( $undo_data['bundle_max_size'], 'eh_bulk_edit' ); ?></span>
							<?php
						} else {
							?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
							<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_edit_cart'])) {
							switch ( $undo_data['bundle_edit_cart'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_edit_cart'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Edit in Cart', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Enable this option to allow changing the configuration of this bundle in the cart. Applicable to bundles with configurable attributes and/or quantities', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_edit_cart'])) {
							switch ( $undo_data['bundle_edit_cart'] ) {
								case 'yes':
									?>
									<span><?php esc_html_e( 'Enable', 'eh_bulk_edit' ); ?></span>
									<?php
									break;
								case 'no':
									?>
									<span><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></span>
									<?php
									break;
								case 'none':
									?>
									<span><?php esc_html_e( 'None', 'eh_bulk_edit' ); ?></span>
									<?php
									break;
							}
						} else {
							?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
							<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_min_qty'])) {
							switch ( $undo_data['bundle_min_qty'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_min_qty'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Min Quantity', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'The minimum quantity of this bundled product.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_min_qty'])) { 
							?>
							<span><?php esc_html_e( $undo_data['bundle_min_qty'], 'eh_bulk_edit' ); ?></span>
							<?php
						} else {
							?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
							<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_max_qty'])) {
							switch ( $undo_data['bundle_max_qty'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_max_qty'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Max Quantity', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'The maximum quantity of the bundled product. Leave the field empty for an unlimited maximum quantity.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_max_qty'])) { 
							?>
							<span><?php esc_html_e( $undo_data['bundle_max_qty'], 'eh_bulk_edit' ); ?></span>
							<?php
						} else {
							?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
							<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_default_qty'])) {
							switch ( $undo_data['bundle_default_qty'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_default_qty'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Default Quantity', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'The default quantity of this bundled product.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_default_qty'])) { 
							?>
							<span><?php esc_html_e( $undo_data['bundle_default_qty'], 'eh_bulk_edit' ); ?></span>
							<?php
						} else {
							?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
							<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_optional'])) {
							switch ( $undo_data['bundle_optional'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_optional'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Optional', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select the Tabular option to have the thumbnails, descriptions and quantities of bundled products arranged in a table. Recommended for displaying multiple bundled products with configurable quantities.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_optional'])) {
							switch ( $undo_data['bundle_optional'] ) {
								case 'yes':
									?>
										<span><?php esc_html_e( 'Enable', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
								case 'no':
									?>
										<span><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
							}
						} else {
							?>
									<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_ship_indi'])) {
							switch ( $undo_data['bundle_ship_indi'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_ship_indi'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Shipped Individually', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select the Tabular option to have the thumbnails, descriptions and quantities of bundled products arranged in a table. Recommended for displaying multiple bundled products with configurable quantities.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_ship_indi'])) {
							switch ( $undo_data['bundle_ship_indi'] ) {
								case 'yes':
									?>
										<span><?php esc_html_e( 'Enable', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
								case 'no':
									?>
										<span><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
								case '':
									?>
										<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
							}
						} else {
							?>
									<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_price_individual'])) {
							switch ( $undo_data['bundle_price_individual'] ) {
								case '':
									break;
								case 'false':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_price_individual'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Priced Individually', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select the Tabular option to have the thumbnails, descriptions and quantities of bundled products arranged in a table. Recommended for displaying multiple bundled products with configurable quantities.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_price_individual'])) {
							if ( 'true' == $undo_data['bundle_price_individual'] ) {
								?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_price_individual'>
									<?php
							}
						} else {
							?>
									<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['elex_bundle_discount'])) {
							switch ( $undo_data['elex_bundle_discount'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='elex_bundle_discount'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Discount %', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Discount applied to the price of this bundled product when Priced Individually is checked. If the bundled product has a Sale Price, the discount is applied on top of the Sale Price.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['elex_bundle_discount'])) { 
							?>
							<span><?php esc_html_e( $undo_data['elex_bundle_discount'], 'eh_bulk_edit' ); ?></span>
							<?php
						} else {
							?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
							<?php
						}
						?>
					</td>
				</tr>


				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_product_details'])) {
							switch ( $undo_data['bundle_product_details'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_product_details'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Product details', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Controls the visibility of the bundled item in the single-product template of this bundle.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_product_details'])) {
							switch ( $undo_data['bundle_product_details'] ) {
								case 'visible':
									?>
										<span><?php esc_html_e( 'Visible', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
								case 'hidden':
									?>
										<span><?php esc_html_e( 'Hidden', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
							}
						} else {
							?>
									<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_override_title_chkbx'])) {
							switch ( $undo_data['bundle_override_title_chkbx'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_override_title_chkbx'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Override Title', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Check this option to override the default product title.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_override_title_chkbx'])) {
							switch ( $undo_data['bundle_override_title_chkbx'] ) {
								case 'yes':
									?>
										<span><?php esc_html_e( 'Visible', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
								case 'no':
									?>
										<span><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
							}
						} else {
							?>
									<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_override_shortdescr_chkbx'])) {
							switch ( $undo_data['bundle_override_shortdescr_chkbx'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_override_shortdescr_chkbx'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Override Short Description', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Check this option to override the default short product description.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_override_shortdescr_chkbx'])) {
							switch ( $undo_data['bundle_override_shortdescr_chkbx'] ) {
								case 'yes':
									?>
										<span><?php esc_html_e( 'Visible', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
								case 'no':
									?>
										<span><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
							}
						} else {
							?>
									<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
						}
						?>
					</td>
				</tr>

				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_hidetumb'])) {
							switch ( $undo_data['bundle_hidetumb'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_hidetumb'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Hide Thumbnail', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Check this option to hide the thumbnail image of this bundled product.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_hidetumb'])) {
							switch ( $undo_data['bundle_hidetumb'] ) {
								case 'yes':
									?>
										<span><?php esc_html_e( 'Visible', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
								case 'no':
									?>
										<span><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
							}
						} else {
							?>
									<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_cart_checkout'])) {
							switch ( $undo_data['bundle_cart_checkout'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_cart_checkout'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Cart/checkout', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Controls the visibility of the bundled item in cart/checkout templates.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_cart_checkout'])) {
							switch ( $undo_data['bundle_cart_checkout'] ) {
								case 'visible':
									?>
										<span><?php esc_html_e( 'Visible', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
								case 'hidden':
									?>
										<span><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
							}
						} else {
							?>
									<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
						}
						?>
					</td>
				</tr>

				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_order_details'])) {
							switch ( $undo_data['bundle_order_details'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_order_details'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Order details', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Controls the visibility of the bundled item in cart/checkout templates.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_order_details'])) {
							switch ( $undo_data['bundle_order_details'] ) {
								case 'visible':
									?>
										<span><?php esc_html_e( 'Visible', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
								case 'hidden':
									?>
										<span><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
							}
						} else {
							?>
									<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_price_prod_detail'])) {
							switch ( $undo_data['bundle_price_prod_detail'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_price_prod_detail'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Product details', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Controls the visibility of the bundled item in cart/checkout templates.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_price_prod_detail'])) {
							switch ( $undo_data['bundle_price_prod_detail'] ) {
								case 'visible':
									?>
										<span><?php esc_html_e( 'Visible', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
								case 'hidden':
									?>
										<span><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
							}
						} else {
							?>
									<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_price_cart'])) {
							switch ( $undo_data['bundle_price_cart'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_price_cart'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Cart/checkout', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Controls the visibility of the bundled-item price in cart/checkout templates.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_price_cart'])) {
							switch ( $undo_data['bundle_price_cart'] ) {
								case 'visible':
									?>
										<span><?php esc_html_e( 'Visible', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
								case 'hidden':
									?>
										<span><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
							}
						} else {
							?>
									<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						if (isset($undo_data['bundle_price_order'])) {
							switch ( $undo_data['bundle_price_order'] ) {
								case '':
									break;
								default:
									?>
									<input type="checkbox" name='undo_checkbox_values' checked value='bundle_price_order'>
									<?php
									break;
							}
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Order details', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Controls the visibility of the bundled-item price in order-details and e-mail templates.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						if (isset($undo_data['bundle_price_order'])) {
							switch ( $undo_data['bundle_price_order'] ) {
								case 'visible':
									?>
										<span><?php esc_html_e( 'Visible', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
								case 'hidden':
									?>
										<span><?php esc_html_e( 'Disable', 'eh_bulk_edit' ); ?></span>
										<?php
									break;
							}
						} else {
							?>
									<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
						}
						?>
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
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						$schedule_sale_price = isset( $undo_data['schedule_sale_price'] ) ? $undo_data['schedule_sale_price'] : 'false';
						switch ( $schedule_sale_price ) {
							case 'true':
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='schedule_sale_price'>
								<?php
								break;
							default:
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Schedule Sale Price', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Enable this option to schedule the sale price between two dates.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
							$schedule_sale_price = isset( $undo_data['schedule_sale_price'] ) ? $undo_data['schedule_sale_price'] : 'false';
						switch ( $schedule_sale_price ) {
							case 'true':
								?>
									<span><?php esc_html_e( 'Enabled', 'eh_bulk_edit' ); ?></span>
									<?php
								break;
							default:
								?>
									<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
									<?php
								break;
						}
						?>
					</td>
				</tr>
			</table>
			<h2>
				<?php esc_html_e( 'Stock', 'eh_bulk_edit' ); ?>
			</h2>
			<hr>
			<table class='eh-edit-table' id='update_stock_table'>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['stock_manage_select'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='manage_stock'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Manage Stock', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Enable or Disable manage stock for products or variations', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['stock_manage_select'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'yes':
								?>
								<span><?php esc_html_e( 'Enabled', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'no':
								?>
								<span><?php esc_html_e( 'Disabled', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							default:
								break;
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['quantity_select'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='quantity'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Stock Quantity', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Choose an option to update stock quantity and enter the value', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['quantity_select'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'add':
								?>
								<span><?php esc_html_e( 'Increased [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'sub':
								?>
								<span><?php esc_html_e( 'Decreased [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'replace':
								?>
								<span><?php esc_html_e( 'Replaced [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							default:
								break;
						}
						?>
						<span id='stock_quantity_text'>
							<?php
							switch ( $undo_data['quantity_select'] ) {
								case '':
									break;
								default:
									?>
									<span style="background: whitesmoke"><?php esc_html_e( 'Quantity : ', 'eh_bulk_edit' ) . $undo_data['quantity_text']; ?></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
							}
							?>
						</span>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['backorder_select'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='backorders'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Allow Backorders', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Choose how you want to handle backorders', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['backorder_select'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'no':
								?>
								<span><?php esc_html_e( 'Do not Allow', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'notify':
								?>
								<span><?php esc_html_e( 'Allow, but Notify the Customer', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'yes':
								?>
								<span><?php esc_html_e( 'Allowed', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							default:
								break;
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['stock_status_select'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='stock_status'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Stock Status', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Choose an option to update  the stock status', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['stock_status_select'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'instock':
								?>
								<span><?php esc_html_e( 'In Stock', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'outofstock':
								?>
								<span><?php esc_html_e( 'Out of Stock', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'onbackorder':
								?>
								<span><?php esc_html_e( 'On Backorder', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							default:
								break;
						}
						?>
					</td>
				</tr>
			</table>
			<h2>
				<?php esc_html_e( 'Weight & Dimensions', 'eh_bulk_edit' ); ?>
			</h2>
			<hr>
			<table class='eh-edit-table' id='update_properties_table'>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['length_select'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='length'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Length', 'eh_bulk_edit' ); ?>
						<span style="float:right;"><?php echo filter_var( strtolower( get_option( 'woocommerce_dimension_unit' ) ) ); ?></span>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Choose an option to update length and enter the value', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['length_select'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'add':
								?>
								<span><?php esc_html_e( 'Increased [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'sub':
								?>
								<span><?php esc_html_e( 'Decreased [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'replace':
								?>
								<span><?php esc_html_e( 'Replaced [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							default:
								break;
						}
						?>
						<span id='length_text'>
							<?php
							switch ( $undo_data['length_select'] ) {
								case '':
									break;
								default:
									?>
									<span style="background: whitesmoke"><?php esc_html_e( 'Dimension : ', 'eh_bulk_edit' ) . $undo_data['length_text']; ?></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
							}
							?>
						</span>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['width_select'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='width'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Width', 'eh_bulk_edit' ); ?>
						<span style="float:right;"><?php echo filter_var( strtolower( get_option( 'woocommerce_dimension_unit' ) ) ); ?></span>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Choose an option to update width and enter the value', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['width_select'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'add':
								?>
								<span><?php esc_html_e( 'Increased [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'sub':
								?>
								<span><?php esc_html_e( 'Decreased [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'replace':
								?>
								<span><?php esc_html_e( 'Replaced [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							default:
								break;
						}
						?>
						<span id='width_text'>
							<?php
							switch ( $undo_data['width_select'] ) {
								case '':
									break;
								default:
									?>
									<span style="background: whitesmoke"><?php esc_html_e( 'Dimension : ', 'eh_bulk_edit' ) . $undo_data['width_text']; ?></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
							}
							?>
						</span>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['height_select'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='height'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Height', 'eh_bulk_edit' ); ?>
						<span style="float:right;"><?php echo filter_var( strtolower( get_option( 'woocommerce_dimension_unit' ) ) ); ?></span>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Choose an option to update height and enter the value', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['height_select'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'add':
								?>
								<span><?php esc_html_e( 'Increased [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'sub':
								?>
								<span><?php esc_html_e( 'Decreased [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'replace':
								?>
								<span><?php esc_html_e( 'Replaced [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							default:
								break;
						}
						?>
						<span id='height_text'>
							<?php
							switch ( $undo_data['height_select'] ) {
								case '':
									break;
								default:
									?>
									<span style="background: whitesmoke"><span><?php esc_html_e( 'Dimension : ', 'eh_bulk_edit' ) . $undo_data['height_text']; ?></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
							}
							?>
							</span>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['weight_select'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='weight'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Weight', 'eh_bulk_edit' ); ?>
						<span style="float:right;"><?php echo filter_var( strtolower( get_option( 'woocommerce_weight_unit' ) ) ); ?></span>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Choose an option to update weight and enter the value', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['weight_select'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'add':
								?>
								<span><?php esc_html_e( 'Increased [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'sub':
								?>
								<span><?php esc_html_e( 'Decreased [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'replace':
								?>
								<span><?php esc_html_e( 'Replaced [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							default:
								break;
						}
						?>
						<span id='weight_text'>
							<?php
							switch ( $undo_data['weight_select'] ) {
								case '':
									break;
								default:
									?>
									<span style="background: whitesmoke"><?php esc_html_e( 'Dimension : ', 'eh_bulk_edit' ) . $undo_data['weight_text']; ?></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
							}
							?>
						</span>
					</td>
				</tr>
			</table>


			</table>
			<h2>
				<?php esc_html_e( 'Global Attributes', 'eh_bulk_edit' ); ?>
			</h2>
			<hr>
			<table class='eh-edit-table' id='update_properties_table'>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
					<?php
					switch ( $undo_data['attribute_action'] ) {
						case '':
							break;
						default:
							?>
							<input type="checkbox" name='undo_checkbox_values' checked value='attributes'>
							<?php
							break;
					}
					?>
				</td>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Attribute Actions', 'eh_bulk_edit' ); ?>

				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select an option to make changes to your attribute values', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<?php
					switch ( $undo_data['attribute_action'] ) {
						case '':
							?>
							<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
							<?php
							break;
						case 'add':
							?>
							<span><?php esc_html_e( 'Added ', 'eh_bulk_edit' ); ?></span>
							<?php
							break;
						case 'remove':
							?>
							<span><?php esc_html_e( 'Removed ', 'eh_bulk_edit' ); ?></span>
							<?php
							break;
						case 'replace':
							?>
							<span><?php esc_html_e( 'Replaced ', 'eh_bulk_edit' ); ?></span>
							<?php
							break;
						default:
							break;
					}
					?>

				</td>
			</tr>
			<tr>
			</table>
			<!-- Tags -->
			<h2>
				<?php esc_html_e( 'Tags', 'eh_bulk_edit' ); ?>
			</h2>
			<hr>
			<table class='eh-edit-table' id='update_properties_table'>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
					<?php
					switch ( $undo_data['tag_action'] ) {
						case '':
							break;
						default:
							?>
							<input type="checkbox" name='undo_checkbox_values' checked value='tag_ids'>
							<?php
							break;
					}
					?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Tag Actions', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select an option to make changes to your tags values', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['tag_action'] ) {
							case '':
								?>
							 <span><?php esc_html_e( '< No Change >', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'add':
								?>
								<span><?php esc_html_e( 'Add New Values', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'remove':
								?>
								<span><?php esc_html_e( 'Remove Existing Values', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'replace':
								?>
								<span><?php esc_html_e( 'Overwrite Existing Values', 'eh_bulk_edit' ); ?></span>
								<?php
								break;

							default:
								break;
						}
						?>

					</td>
				</tr>
			</table>

			<!-- Custom Attributes. -->
			<h2>
				<?php esc_html_e( 'Custom Attributes', 'eh_bulk_edit' ); ?>
			</h2>
			<hr>
			<table class='eh-edit-table' id='update_properties_table'>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
					<?php
					switch ( $undo_data['custom_attribute_action'] ) {
						case '':
							break;
						default:
							?>
							<input type="checkbox" name='undo_checkbox_values' checked value='custom_attributes'>
							<?php
							break;
					}
					?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Attribute Actions', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select an option to make changes to your custom attribute values', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['custom_attribute_action'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'remove':
								?>
								<span><?php esc_html_e( 'Removed ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							default:
								break;
						}
						?>

					</td>
				</tr>
			</table>


			<h2>
				<?php esc_html_e( 'Tax', 'eh_bulk_edit' ); ?>
			</h2>
			<hr>


			<table class='eh-edit-table' id='update_properties_table'>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['tax_status_action'] ) {
							case '':
								break;
							default:
								?>
							<input type="checkbox" name='undo_checkbox_values' checked value='tax_status_action'>
								<?php
								break;
						}
						?>
				</td>


				<td class='eh-edit-tab-table-left'>

				<?php esc_html_e( 'Tax Status', 'eh_bulk_edit' ); ?>

				</td>

				<td class='eh-edit-tab-table-middle'>
				<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select an option to make changes to your Tax Status', 'eh_bulk_edit' ); ?>'></span>
				</td>

				<td class='eh-edit-tab-table-input-td' >
					<?php
					switch ( $undo_data['tax_status_action'] ) {
						case '':
							?>
							<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
							<?php
							break;
						case 'taxable':
							?>
							<span><?php esc_html_e( 'Taxable ', 'eh_bulk_edit' ); ?></span>
							<?php
							break;
						case 'shipping':
							?>
							<span><?php esc_html_e( 'Shipping ', 'eh_bulk_edit' ); ?></span>
							<?php
							break;
						case 'none':
							?>
							<span><?php esc_html_e( 'None ', 'eh_bulk_edit' ); ?></span>
							<?php
							break;
						default:
							break;
					}
					?>
				</td>
			</tr>

			<tr>
				<td class='eh-edit-tab-table-undo-check'>
					<?php
					switch ( $undo_data['tax_class_action'] ) {
						case '':
							break;
						default:
							?>
							<input type="checkbox" name='undo_checkbox_values' checked value='tax_class_action'>
							<?php
							break;
					}
					?>
				</td>

				<td class='eh-edit-tab-table-left'>

				<?php esc_html_e( 'Tax Class', 'eh_bulk_edit' ); ?>

				</td>

				<td class='eh-edit-tab-table-middle'>
				<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select an option to make changes to your Tax Class', 'eh_bulk_edit' ); ?>'></span>
				</td>

				<td class='eh-edit-tab-table-input-td' >
					<?php
					switch ( $undo_data['tax_class_action'] ) {
						case '':
							?>
							<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
							<?php
							break;
						case 'default':
							?>
							<span><?php esc_html_e( 'Standard ', 'eh_bulk_edit' ); ?></span>
							<?php
							break;
						default:
							?>
							<span><?php echo( filter_var( $undo_data['tax_class_action'] ) ); ?></span>
							<?php
							break;
					}
					?>
				</td>
			</tr>
			</table>

		<h2>
			<?php esc_html_e( 'Interchange Global Attribute Values in Variations', 'eh_bulk_edit' ); ?>
		</h2>
		<hr>


		<table class='eh-edit-table'>
			<tr>
				<td class='eh-edit-tab-table-undo-check'>
					<?php
					switch ( $undo_data['vari_attribute'] ) {
						case '':
							break;
						default:
							?>
							<input type="checkbox" name='undo_checkbox_values' checked value='vari_attribute'>
							<?php
							break;
					}
					?>
				</td>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Interchange Global Attribute Values in Variations', 'eh_bulk_edit' ); ?>

				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select the global attribute and specify the global attribute values you want to change in your variations, if these global attribute values are already used to create variations.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<?php
					switch ( $undo_data['vari_attribute'] ) {
						case '':
							?>
							<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
							<?php
							break;
						default:
							?>
							<span><?php esc_html_e( 'Changed', 'eh_bulk_edit' ); ?></span>
							<?php
							break;
					}
					?>
				</td>
			</tr>
			<tr>
		</table>
		<h2>
			<?php esc_html_e( 'Create Variations', 'eh_bulk_edit' ); ?>
		</h2>
		<hr>
		<table class='eh-edit-table' id='update_variations_table'>
			<tr>
				<td class='eh-edit-tab-table-undo-check'>
					<?php
					// variation checkbox enable on undo page.
					switch ( $undo_data['variations'] ) {
						case 'false':
							break;
						default:
							?>
								<input type="checkbox" name='undo_checkbox_values' checked value='variation_ids'>
							<?php
							break;
					}
					?>
				</td>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Create variations from all attributes', 'eh_bulk_edit' ); ?>

				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Enabling this will create a new variation for each and every possible combination of variation attributes.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<?php
					switch ( $undo_data['variations'] ) {
						case 'false':
							?>
							<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
							<?php
							break;
						case 'true':
							?>
							<span><?php esc_html_e( 'Variations Created ', 'eh_bulk_edit' ); ?></span>
							<?php
							break;
						default:
							break;
					}
					?>

				</td>
			</tr>
		</table>
		<h2>
			<?php esc_html_e( 'Categories', 'eh_bulk_edit' ); ?>
		</h2>
		<hr>
		<table class='eh-edit-table' id='update_properties_table'>
			<tr>
				<td class='eh-edit-tab-table-undo-check'>
					<?php
					switch ( $undo_data['categories'] ) {
						case '':
							break;
						default:
							?>
							<input type="checkbox" name='undo_checkbox_values' checked value='categories'>
							<?php
							break;
					}
					?>
				</td>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Categories', 'eh_bulk_edit' ); ?>

				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Category process', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<?php
					switch ( $undo_data['category_opn'] ) {
						case 'cat_none':
							?>
							<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
							<?php
							break;
						case 'cat_add':
							?>
							<span><?php esc_html_e( 'Added ', 'eh_bulk_edit' ); ?></span>
							<?php
							break;
						case 'cat_remove':
							?>
							<span><?php esc_html_e( 'Removed ', 'eh_bulk_edit' ); ?></span>
							<?php
							break;
						case 'cat_replace':
							?>
							<span><?php esc_html_e( 'Replaced ', 'eh_bulk_edit' ); ?></span>
							<?php
							break;
						default:
							break;
					}
					?>

				</td>
			</tr>
		</table>

		<?php
		/**
		 * Check if the ELEX Catalog Mode, Wholesale & Role Based Pricing plugin is active.
		 *
		 * This checks if the 'elex-catmode-rolebased-price/elex-catmode-rolebased-price.php' plugin
		 * is active by using the 'active_plugins' filter to retrieve the list of currently active plugins.
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
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['hide_price'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='hide_price'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Hide price', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select option to hide price for unregistered users.', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['hide_price'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'no':
								?>
								<span><?php esc_html_e( 'Show Price', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'yes':
								?>
								<span><?php esc_html_e( 'Hide Price', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							default:
								break;
						}
						?>
					</td>
				</tr>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						$selected_roles = $undo_data['hide_price_role'];
						switch ( $selected_roles ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='hide_price_role'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Hide product price based on user role', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'For selected user role, hide the product price', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<span class='select-eh'>
							<?php
							global $wp_roles;
							$roles = $wp_roles->role_names;
							$r     = 0;
							foreach ( $roles as $key => $value ) {
								if ( in_array( $key, $selected_roles, true ) ) {
									echo filter_var( $value );
									$r++;
								}
								if ( $r > 0 ) {
									echo ',';
								}
							}
							?>
						</span>
					</td>
				</tr>
				<?php
				$enabled_roles = get_option( 'eh_pricing_discount_product_price_user_role' );
				if ( is_array( $enabled_roles ) ) {
					if ( ! in_array( 'none', $enabled_roles, true ) ) {
						?>
						<tr>
							<td class='eh-edit-tab-table-undo-check'>
								<?php
								switch ( $undo_data['price_adjustment'] ) {
									case '':
										break;
									default:
										?>
										<input type="checkbox" name='undo_checkbox_values' checked value='price_adjustment'>
										<?php
										break;
								}
								?>
							</td>
							<td class='eh-edit-tab-table-left'>
								<?php esc_html_e( 'Enforce product price adjustment', 'eh_bulk_edit' ); ?>
							</td>
							<td class='eh-edit-tab-table-middle'>
								<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select option to enforce indvidual price adjustment', 'eh_bulk_edit' ); ?>'></span>
							</td>
							<td class='eh-edit-tab-table-input-td'>
								<?php
								switch ( $undo_data['price_adjustment'] ) {
									case '':
										?>
										<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
										<?php
										break;
									case 'no':
										?>
										<span><?php esc_html_e( 'Disabled', 'eh_bulk_edit' ); ?></span>
										<?php
										break;
									case 'yes':
										?>
										<span><?php esc_html_e( 'Enabled', 'eh_bulk_edit' ); ?></span>
										<?php
										break;
									default:
										break;
								}
								?>
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
		 * This checks if the 'per-product-addon-for-woocommerce-shipping-pro/woocommerce-per-product-shipping-addon-for-shipping-pro.php' plugin
		 * is active by using the 'active_plugins' filter to retrieve the list of currently active plugins.
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
			<table class='eh-edit-table' id='update_general_table'>
				<tr>
					<td class='eh-edit-tab-table-undo-check'>
						<?php
						switch ( $undo_data['shipping_unit_select'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='wf_shipping_unit'>
								<?php
								break;
						}
						?>
					</td>
					<td class='eh-edit-tab-table-left'>
						<?php esc_html_e( 'Shipping Unit', 'eh_bulk_edit' ); ?>
					</td>
					<td class='eh-edit-tab-table-middle'>
						<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Update Shipping Unit', 'eh_bulk_edit' ); ?>'></span>
					</td>
					<td class='eh-edit-tab-table-input-td'>
						<?php
						switch ( $undo_data['shipping_unit_select'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'add':
								?>
								<span><?php esc_html_e( 'Added [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'sub':
								?>
								<span><?php esc_html_e( 'Subtracted [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							case 'replace':
								?>
								<span><?php esc_html_e( 'Replaced [ ', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							default:
								break;
						}
						?>
						<span id='weight_text'>
							<?php
							switch ( $undo_data['shipping_unit_select'] ) {
								case '':
									break;
								default:
									?>
									<span style="background: whitesmoke"><?php esc_html_e( 'Unit : ', 'eh_bulk_edit' ) . $undo_data['shipping_unit']; ?></span>
									<?php
									esc_html_e( ' ] ', 'eh_bulk_edit' );
									break;
							}
							?>
						</span>
					</td>
				</tr>
			</table>
			<?php
		}
		$keys = array();
		if ( isset( $_POST['file'] ) ) {
			$scheduled_jobs = wpFluent()->table('elex_bep_jobs')->select('*')->get();
			$scheduled_jobs = (array) $scheduled_jobs;
			foreach ( $scheduled_jobs as $key => $val ) {
				if ( isset( $val->job_name ) && sanitize_text_field( $_POST['file'] ) === $val->job_name ) {
				
					$val         = (array) $val;
					$filter_data = unserialize( $val['filter_data']);

					if ( isset( $filter_data['meta_fields'] ) ) {
						$keys = $filter_data['meta_fields'];
					}
					break;
				}
			}
		} else {
			$keys = get_option( 'eh_bulk_edit_meta_values_to_update' );
		}
		if ( ! empty( $keys ) ) {
			?>
			<h2>
				<?php esc_html_e( 'Update meta values', 'eh_bulk_edit' ); ?>
			</h2>
			<hr>
			<table class='eh-edit-table' id='update_meta_table'>
				<?php
				$key_size = count( $keys );
				for ( $i = 0; $i < $key_size; $i++ ) {
					?>
					<tr>
						<td class='eh-edit-tab-table-undo-check'>
							<?php
							if (isset($undo_data['custom_meta'][ $i ])) {
								if ( '' !== $undo_data['custom_meta'][ $i ] ) {
									?>

									<input type="checkbox" name='undo_checkbox_values' checked value=<?php echo filter_var( $keys[ $i ] ); ?>>
									<?php
								}
							}
							?>
						</td>
						<td class='eh-edit-tab-table-left'>
							<?php echo filter_var( $keys[ $i ] ); ?>
						</td>
						<td class='eh-edit-tab-table-middle'>
							<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Update meta', 'eh_bulk_edit' ); ?>'></span>
						</td>
						<td class='eh-edit-tab-table-input-td'>
							<?php
							if ( isset( $undo_data['custom_meta'] ) && '' !== $undo_data['custom_meta'][ $i ] ) {
								?>
								<span><?php echo filter_var( $undo_data['custom_meta'][ $i ] ); ?></span>
								<?php
							} else {
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
							}
							?>
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


		<table class='eh-edit-table'>
			<tr>
				<td class='eh-edit-tab-table-undo-check'>
					<?php
					if (isset($undo_data['delete_product'])) {
						switch ( $undo_data['delete_product'] ) {
							case '':
								break;
							default:
								?>
								<input type="checkbox" name='undo_checkbox_values' checked value='delete_product'>
								<?php
								break;
						}
					}
					?>
				</td>
				<td class='eh-edit-tab-table-left'>
					<?php esc_html_e( 'Delete Action', 'eh_bulk_edit' ); ?>

				</td>
				<td class='eh-edit-tab-table-middle'>
					<span class='woocommerce-help-tip tooltip' data-tooltip='<?php esc_html_e( 'Select how you want to delete products.', 'eh_bulk_edit' ); ?>'></span>
				</td>
				<td class='eh-edit-tab-table-input-td'>
					<?php
					if (isset($undo_data['delete_product'])) {
						switch ( $undo_data['delete_product'] ) {
							case '':
								?>
								<span><?php esc_html_e( 'No Change', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
							default:
								?>
								<span><?php esc_html_e( 'Moved to Trash', 'eh_bulk_edit' ); ?></span>
								<?php
								break;
						}
					}
					?>

				</td>
			</tr>
			<tr>
		</table>

		<button id='undo_cancel_button' style="margin-bottom: 1%; background-color: gray; color: white; width: 10%;" class='button button-large'><span class="update-text"><?php esc_html_e( 'Cancel', 'eh_bulk_edit' ); ?></span></button>
		<button id='undo_update_button' style="margin-bottom: 1%; float: right; color: white; width: 10%;" class='button button-primary button-large'><span class="update-text"><?php esc_html_e( 'Continue', 'eh_bulk_edit' ); ?></span></button>
		</div>
		<?php
	} else {
		?>
		<div class='wrap postbox table-box table-box-main' id="undo_update" style='padding:0px 20px;'>
			<h2>
				<?php esc_html_e( 'Undo the update - Overview', 'eh_bulk_edit' ); ?>
			</h2>
			<hr>
			<div class='eh-edit-table'>
				<?php esc_html_e( 'Oops! No previous update found.', 'eh_bulk_edit' ); ?>
			</div>
			<button id='undo_cancel_button' style="margin-bottom: 1%;  background-color: gray; color: white; width: 10%;" class='button button-large'><span class="update-text"><?php esc_html_e( 'Back', 'eh_bulk_edit' ); ?></span></button>
		</div>
		<?php
	}
	$value = ob_get_clean();
	die( filter_var( $value ) );
}

/** Get selected products.
 *
 * @param object $table_obj table object.
 */
function xa_bep_get_selected_products( $table_obj = null ) {
	$sel_ids = array();
	if ( isset( $_REQUEST['count_products'] ) ) {
		$sel_ids = get_option( 'xa_bulk_selected_ids1' );
		// Get unchecked ids.
		$uc_ids = ! empty( get_option( 'elex_bep_filter_checkbox_data' ) ) ? get_option( 'elex_bep_filter_checkbox_data' ) : array();
		// Get the difference and reindex.
		$final_ids = array_values( array_diff( $sel_ids, $uc_ids ) );
		return $final_ids;
	}
	$page_no           = ! empty( $_REQUEST['paged'] ) ? sanitize_text_field( $_REQUEST['paged'] ) : 1;
	$selected_products = array();
	$per_page          = ( get_option( 'eh_bulk_edit_table_row' ) ) ? get_option( 'eh_bulk_edit_table_row' ) : 20;
	$pid_to_include    = xa_bep_filter_products();

	update_option( 'xa_bulk_selected_ids1', $pid_to_include );
	$sel_chunk = array_chunk( $pid_to_include, $per_page, true );
	if ( ! empty( $sel_chunk ) ) {
		$ids_per_page = $sel_chunk[ $page_no - 1 ];
		foreach ( $ids_per_page as $ids ) {
			$selected_products[ $ids ] = wc_get_product( $ids );
		}
	}

	$total_pages = count( $sel_chunk );
	if ( isset( $_REQUEST['page'] ) && ! empty( $table_obj ) && ( 1 === intval( $total_pages ) ) ) {
		$total_pages++;
	}
	$ele_on_page = count( $pid_to_include );
	if ( ! empty( $table_obj ) ) {
		$table_obj->set_pagination_args(
			array(
				'total_items' => $ele_on_page,
				'per_page'    => $ele_on_page,
				'total_pages' => $total_pages,
			)
		);
	}

	if ( ! empty( $selected_products ) ) {
		return $selected_products;
	}
}

/** Get categories.
 *
 * @param array $categories categories.
 * @param array $subcat     subcategories.
 */
function elex_get_categories( $categories, $subcat ) {
	$filter_categories   = array();
	$selected_categories = $categories;
	$t_arr               = array();
	if ( $subcat ) {

		if ( ! empty( $selected_categories ) ) {
			foreach ( $selected_categories as $key => $selected_category_id ) {
				array_push( $filter_categories, $selected_category_id );
				unset( $selected_categories[ $key ] );
				$t_arr             = xa_subcats_from_parentcat_by_term_id( $selected_category_id );
				$filter_categories = array_merge( $filter_categories, $t_arr );
			}
		}
	} else {
		foreach ( $categories as $category ) {
			array_push( $filter_categories, $category );
		}
	}
	return $filter_categories;
}

/**
 * Get Custom Attributes Values.
 *
 * @return array
 */
function eh_bep_get_custom_attribute_values_action_callback() {
	check_ajax_referer( 'ajax-eh-bep-nonce', '_ajax_eh_bep_nonce' );
	$custom_attribute_name = isset( $_POST['custom_attrib'] ) ? sanitize_text_field( $_POST['custom_attrib'] ) : '';
	global $wpdb;
	// Get custom attributes.
	$products                = $wpdb->get_results("
		SELECT
			postmeta.post_id,
			postmeta.meta_value
		FROM
			{$wpdb->postmeta} AS postmeta
		WHERE
			postmeta.meta_key = '_product_attributes'
			AND COALESCE(postmeta.meta_value, '') != ''
	");
	$custom_attribute_values = array();
	$custom_attribute_label  = '';
	foreach ( $products as $product ) {
		$product_attributes = maybe_unserialize( $product->meta_value );
		if ( is_array( $product_attributes ) || is_object( $product_attributes ) ) {
			foreach ( $product_attributes as $attribute_slug => $product_attribute ) {
				if ( $custom_attribute_name === $attribute_slug ) {
					if ( isset( $product_attribute['is_taxonomy'] ) && '0' == $product_attribute['is_taxonomy'] && 'product_shipping_class' != $attribute_slug ) {
						$values                 = array_map( 'trim', explode( ' ' . WC_DELIMITER . ' ', $product_attribute['value'] ) );
						$custom_attribute_label = $product_attribute['name'];
						foreach ( $values as $value ) {
							array_push( $custom_attribute_values, $value );
						}
					}
				}
			}
		}
	}

	$return = "<optgroup name='" . $custom_attribute_name . "' label='" . $custom_attribute_label . "' id='" . $custom_attribute_name . "'>";
	foreach ( $custom_attribute_values as $key => $value ) {
		$return .= "<option value='" . $custom_attribute_label . ':' . $value . "'>" . $value . '</option>';
	}
	$return .= '</optgroup>';

	echo filter_var( $return );
	exit;
}

/** Filter Products.
 *
 * @param array $data data.
 */
function xa_bep_filter_products( $data = '' ) {
	global $wpdb;
	$prefix = $wpdb->prefix;
	if ( empty( $data ) ) {
		$data_to_filter         = array();
		$data_to_filter['type'] = '';
		if ( isset( $_REQUEST['type'] ) && is_array( $_REQUEST['type'] ) ) {
			$data_to_filter['type'] = array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['type'] ) );
		}

		if ( isset( $_REQUEST['stock_status'] ) && is_array( $_REQUEST['stock_status'] ) ) {
			$data_to_filter['stock_status'] = array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['stock_status'] ) );
		}
		$data_to_filter['custom_attribute'] = '';
		if ( isset( $_REQUEST['custom_attribute'] ) && is_array( $_REQUEST['custom_attribute'] ) ) {
			$data_to_filter['custom_attribute'] = array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['custom_attribute'] ) );
		}
		// Custom Attributes Value Filter.
		$data_to_filter['custom_attribute_values'] = '';
		if ( isset( $_REQUEST['custom_attribute_values'] ) && is_array( $_REQUEST['custom_attribute_values'] ) ) {
			$data_to_filter['custom_attribute_values'] = array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['custom_attribute_values'] ) );
		}
		$data_to_filter['category_filter'] = '';
		if ( isset( $_REQUEST['category_filter'] ) && is_array( $_REQUEST['category_filter'] ) ) {
			$data_to_filter['category_filter'] = array_map( 'wp_kses_post', wp_unslash( $_REQUEST['category_filter'] ) );
		}
		if ( isset( $_REQUEST['sub_category_filter'] ) ) {
			$data_to_filter['sub_category_filter'] = sanitize_text_field( $_REQUEST['sub_category_filter'] );
		}
		if ( isset( $_REQUEST['And_cat_check'] ) ) {
			$data_to_filter['And_cat_check'] = sanitize_text_field( $_REQUEST['And_cat_check'] );
		}
		if ( isset( $_REQUEST['filter_product_image_not_exist'] ) ) {
			$data_to_filter['filter_product_image_not_exist'] = sanitize_text_field( $_REQUEST['filter_product_image_not_exist'] );
		}
		if ( isset( $_REQUEST['attribute'] ) ) {
			$data_to_filter['attribute'] = sanitize_text_field( $_REQUEST['attribute'] );
		}
		if ( isset( $_REQUEST['product_title_select'] ) ) {
			$data_to_filter['product_title_select'] = sanitize_text_field( $_REQUEST['product_title_select'] );
		}
		if ( isset( $_REQUEST['product_title_text'] ) ) {
			$data_to_filter['product_title_text'] = sanitize_text_field( $_REQUEST['product_title_text'] );
		}
		$data_to_filter['regex_flags'] = '';
		if ( isset( $_REQUEST['regex_flags'] ) && is_array( $_REQUEST['regex_flags'] ) ) {
			$data_to_filter['regex_flags'] = array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['regex_flags'] ) );
		}
		/** SKU Filter */
		if ( isset( $_REQUEST['product_sku_select_filter'] ) ) {
			$data_to_filter['product_sku_select_filter'] = sanitize_text_field( $_REQUEST['product_sku_select_filter'] );
		}

		if ( isset( $_REQUEST['product_sku_text_filter'] ) ) {
			$data_to_filter['product_sku_text_filter'] = sanitize_text_field( $_REQUEST['product_sku_text_filter'] );
		}

		if ( isset( $_REQUEST['product_description_select'] ) ) {
			$data_to_filter['product_description_select'] = sanitize_text_field( $_REQUEST['product_description_select'] );
		}
		if ( isset( $_REQUEST['product_description_text'] ) ) {
			$data_to_filter['product_description_text'] = sanitize_text_field( $_REQUEST['product_description_text'] );
		}
		$data_to_filter['regex_flags_description'] = '';
		if ( isset( $_REQUEST['regex_flags_description'] ) && is_array( $_REQUEST['regex_flags_description'] ) ) {
			$data_to_filter['regex_flags_description'] = array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['regex_flags_description'] ) );
		}
		if ( isset( $_REQUEST['product_short_description_select'] ) ) {
			$data_to_filter['product_short_description_select'] = sanitize_text_field( $_REQUEST['product_short_description_select'] );
		}
		if ( isset( $_REQUEST['product_short_description_text'] ) ) {
			$data_to_filter['product_short_description_text'] = sanitize_text_field( $_REQUEST['product_short_description_text'] );
		}
		$data_to_filter['regex_flags_short_description'] = '';
		if ( isset( $_REQUEST['regex_flags_short_description'] ) && is_array( $_REQUEST['regex_flags_short_description'] ) ) {
			$data_to_filter['regex_flags_short_description'] = array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['regex_flags_short_description'] ) );
		}
		$data_to_filter['attribute_value_filter'] = '';
		if ( isset( $_REQUEST['attribute_value_filter'] ) && is_array( $_REQUEST['attribute_value_filter'] ) ) {
			$data_to_filter['attribute_value_filter'] = array_map( 'sanitize_text_field', ( $_REQUEST['attribute_value_filter'] ) );
		}
		if ( isset( $_REQUEST['attribute_and'] ) ) {
			$data_to_filter['attribute_and'] = sanitize_text_field( $_REQUEST['attribute_and'] );
		}
		$data_to_filter['attribute_value_and_filter'] = '';
		if ( isset( $_REQUEST['attribute_value_and_filter'] ) && is_array( $_REQUEST['attribute_value_and_filter'] ) ) {
			$data_to_filter['attribute_value_and_filter'] = array_map( 'sanitize_text_field', ( $_REQUEST['attribute_value_and_filter'] ) );
		}
		if ( isset( $_REQUEST['range'] ) ) {
			$data_to_filter['range'] = sanitize_text_field( $_REQUEST['range'] );
			$data_to_filter['range'] = str_replace( '&lt;', '<', $data_to_filter['range'] );
		}
		if ( isset( $_REQUEST['desired_price'] ) ) {
			$data_to_filter['desired_price'] = sanitize_text_field( $_REQUEST['desired_price'] );
		}
		if ( isset( $_REQUEST['minimum_price'] ) ) {
			$data_to_filter['minimum_price'] = sanitize_text_field( $_REQUEST['minimum_price'] );
		}
		if ( isset( $_REQUEST['maximum_price'] ) ) {
			$data_to_filter['maximum_price'] = sanitize_text_field( $_REQUEST['maximum_price'] );
		}
		if ( isset( $_REQUEST['range_weight_data'] ) ) {
			$data_to_filter['range_weight_data'] = sanitize_text_field( $_REQUEST['range_weight_data'] );
			$data_to_filter['range_weight_data'] = str_replace( '&lt;', '<', $data_to_filter['range_weight_data'] );
		}
		if ( isset( $_REQUEST['desired_weight'] ) ) {
			$data_to_filter['desired_weight'] = sanitize_text_field( $_REQUEST['desired_weight'] );
		}
		if ( isset( $_REQUEST['minimum_weight'] ) ) {
			$data_to_filter['minimum_weight'] = sanitize_text_field( $_REQUEST['minimum_weight'] );
		}
		if ( isset( $_REQUEST['maximum_weight'] ) ) {
			$data_to_filter['maximum_weight'] = sanitize_text_field( $_REQUEST['maximum_weight'] );
		}
		$data_to_filter['exclude_ids'] = '';
		if ( isset( $_REQUEST['exclude_ids'] ) && is_array( $_REQUEST['exclude_ids'] ) ) {
			$data_to_filter['exclude_ids'] = array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['exclude_ids'] ) );
		}
		$data_to_filter['exclude_categories'] = '';
		if ( isset( $_REQUEST['exclude_categories'] ) && is_array( $_REQUEST['exclude_categories'] ) ) {
			$data_to_filter['exclude_categories'] = array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['exclude_categories'] ) );
		}
		if ( isset( $_REQUEST['exclude_subcat_check'] ) ) {
			$data_to_filter['exclude_subcat_check'] = sanitize_text_field( $_REQUEST['exclude_subcat_check'] );
		}
		if ( isset( $_REQUEST['enable_exclude_prods'] ) ) {
			$data_to_filter['enable_exclude_prods'] = sanitize_text_field( $_REQUEST['enable_exclude_prods'] );
		}
		if ( isset( $_REQUEST['undo_sch_job'] ) ) {
			$data_to_filter['undo_sch_job'] = sanitize_text_field( $_REQUEST['undo_sch_job'] );
		}
		if ( isset( $_REQUEST['file'] ) ) {
			$data_to_filter['file'] = sanitize_text_field( $_REQUEST['file'] );
		}
		$data_to_filter['prod_tags'] = '';
		if ( isset( $_REQUEST['prod_tags'] ) && is_array( $_REQUEST['prod_tags'] ) ) {
			$data_to_filter['prod_tags'] = array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['prod_tags'] ) );
		}

		if ( isset( $_REQUEST['paged'] ) ) {
			$data_to_filter['paged'] = sanitize_text_field( $_REQUEST['paged'] );
		}
		//filter by using product status (new feature)
		$data_to_filter['product_status'] = '';
		if ( isset( $_REQUEST['product_status'])) {
		$data_to_filter['product_status'] = array_map( 'sanitize_text_field', wp_unslash( $_REQUEST['product_status'] ) );
		}
	} else {
		$data_to_filter = $data;
	}
	//filter by using product status (new feature)
	if ( isset( $data_to_filter['product_status'] ) && '' !== $data_to_filter['product_status'] ) {
		$results = array();
		foreach ( $data_to_filter['product_status'] as $item ) {
			$results[] = $item;	
		}
		//spliting array values and creating new string separated by comma.
		$values = join( "','", $results );
		$sql    = "SELECT DISTINCT ID FROM {$prefix}posts LEFT JOIN {$prefix}term_relationships on {$prefix}term_relationships.object_id={$prefix}posts.ID LEFT JOIN {$prefix}term_taxonomy on {$prefix}term_taxonomy.term_taxonomy_id  = {$prefix}term_relationships.term_taxonomy_id LEFT JOIN {$prefix}terms on {$prefix}terms.term_id  ={$prefix}term_taxonomy.term_id LEFT JOIN {$prefix}postmeta on {$prefix}postmeta.post_id  ={$prefix}posts.ID WHERE  post_type = 'product' AND post_status IN ('$values')";
	} else {
		$sql = "SELECT DISTINCT ID FROM {$prefix}posts LEFT JOIN {$prefix}term_relationships on {$prefix}term_relationships.object_id={$prefix}posts.ID LEFT JOIN {$prefix}term_taxonomy on {$prefix}term_taxonomy.term_taxonomy_id  = {$prefix}term_relationships.term_taxonomy_id LEFT JOIN {$prefix}terms on {$prefix}terms.term_id  ={$prefix}term_taxonomy.term_id LEFT JOIN {$prefix}postmeta on {$prefix}postmeta.post_id  ={$prefix}posts.ID WHERE  post_type = 'product' AND post_status IN ('publish', 'private','draft')";
	}
	// stock filter.
	$stock_sql_query    = '';
	$ids_stock_filtered = array();
	if ( isset( $data_to_filter['stock_status'] ) && '' !== $data_to_filter['stock_status'] ) {
		$results = array();
		foreach ( $data_to_filter['stock_status'] as $item ) {
			$results[] = $item;
		}

		$ids                 = join( "','", $results );
		$stock_query_for_ids = "SELECT  DISTINCT(ID) from {$prefix}posts LEFT JOIN {$prefix}postmeta on  {$prefix}posts.ID = {$prefix}postmeta.post_id where {$prefix}postmeta.meta_value IN ('$ids')";
		$resulted_ids        = $wpdb->get_results( ( $wpdb->prepare( '%1s', $stock_query_for_ids ) ? stripslashes( $wpdb->prepare( '%1s', $stock_query_for_ids ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );
		$ids_stock_filtered  = wp_list_pluck( $resulted_ids, 'ID' );

		$ids_to_query_for_stock = join( "','", $ids_stock_filtered );
		$stock_query_by_ids     = " AND {$prefix}posts.ID IN ('$ids_to_query_for_stock')";
		$stock_sql_query        = " AND {$prefix}postmeta.meta_key LIKE '_stock_status' AND {$prefix}postmeta.meta_value IN ('$ids')";
	}
	// sku filter.
	$id_sku_filtered = array();
	if ( isset( $data_to_filter['product_sku_select_filter'] ) && 'all' !== $data_to_filter['product_sku_select_filter'] && isset( $data_to_filter['product_sku_text_filter'] ) && '' !== $data_to_filter['product_sku_text_filter'] ) {

		switch ( $data_to_filter['product_sku_select_filter'] ) {
			case 'starts_with':
				$sku_query = " AND {$prefix}postmeta.meta_value LIKE '{$data_to_filter['product_sku_text_filter']}%' ";
				break;
			case 'ends_with':
				$sku_query = " AND {$prefix}postmeta.meta_value LIKE '%{$data_to_filter['product_sku_text_filter']}' ";
				break;
			case 'contains':
				$sku_query = " AND {$prefix}postmeta.meta_value LIKE '%{$data_to_filter['product_sku_text_filter']}%' ";
				break;
			case 'enter_sku':
				$sku_string_raw   = $data_to_filter['product_sku_text_filter'];
				$sku_string_array = explode( ',', $sku_string_raw );
				foreach ( $sku_string_array as $item_sku ) {
						$results_sku[] = $item_sku;
				}
				$ids_sku   = join( "','", $results_sku );
				$sku_query = " AND {$prefix}postmeta.meta_value IN ('$ids_sku') ";
				break;
		}

		$sku_query_for_ids = "SELECT  DISTINCT(ID) from {$prefix}posts LEFT JOIN {$prefix}postmeta on  {$prefix}posts.ID = {$prefix}postmeta.post_id  WHERE {$prefix}postmeta.meta_key LIKE '_sku'" . $sku_query;
		$resulted_ids_sku  = $wpdb->get_results( ( $wpdb->prepare( '%1s', $sku_query_for_ids ) ? stripslashes( $wpdb->prepare( '%1s', $sku_query_for_ids ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );
		$id_sku_filtered   = wp_list_pluck( $resulted_ids_sku, 'ID' );

		$results_var_sku = array();
		foreach ( $id_sku_filtered as $item_sku ) {
			$results_var_sku[] = $item_sku;
		}

		$id_var_sku                 = join( "','", $results_var_sku );
		$sku_query_for_var_ids      = "SELECT  DISTINCT(ID) from {$prefix}posts LEFT JOIN {$prefix}postmeta on  {$prefix}posts.ID = {$prefix}postmeta.post_id  WHERE {$prefix}postmeta.meta_key LIKE '_sku' AND {$prefix}posts.post_parent IN ('$id_var_sku')";
		$resulted_var_ids_sku       = $wpdb->get_results( ( $wpdb->prepare( '%1s', $sku_query_for_var_ids ) ? stripslashes( $wpdb->prepare( '%1s', $sku_query_for_var_ids ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );
		$var_id_sku_filtered_unique = wp_list_pluck( $resulted_var_ids_sku, 'ID' );

		$sku_query_for_var_ids_same = "SELECT  DISTINCT(ID) from {$prefix}posts WHERE  {$prefix}posts.post_parent IN ('$id_var_sku')";
		$resulted_var_ids_sku_same  = $wpdb->get_results( ( $wpdb->prepare( '%1s', $sku_query_for_var_ids_same ) ? stripslashes( $wpdb->prepare( '%1s', $sku_query_for_var_ids_same ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );
		$var_id_sku_filtered_same   = wp_list_pluck( $resulted_var_ids_sku_same, 'ID' );

		if ( ! empty( $id_sku_filtered ) ) {
			$var_id_sku_filtered = array_diff( $var_id_sku_filtered_same, $var_id_sku_filtered_unique );
			$id_sku_filtered     = array_unique( array_merge( $id_sku_filtered, $var_id_sku_filtered ) );
		}
	}

	$title_query = '';
	if ( isset( $data_to_filter['product_title_select'] ) && 'all' !== $data_to_filter['product_title_select'] && '' !== $data_to_filter['product_title_text'] ) {
		switch ( $data_to_filter['product_title_select'] ) {
			case 'starts_with':
				$title_query = " AND post_title LIKE '{$data_to_filter['product_title_text']}%' ";
				break;
			case 'ends_with':
				$title_query = " AND post_title LIKE '%{$data_to_filter['product_title_text']}' ";
				break;
			case 'contains':
				$title_query = " AND post_title LIKE '%{$data_to_filter['product_title_text']}%' ";
				break;
			case 'title_regex':
				$title_query = " AND (post_title REGEXP '{$data_to_filter['product_title_text']}') ";
				break;
		}
	}
	// Description filter.
	$description_query = '';
	if ( isset( $data_to_filter['product_description_select'] ) && 'all' !== $data_to_filter['product_description_select'] && '' !== $data_to_filter['product_description_text'] ) {
		$query_string = '';
		if ( 'starts_with' === $data_to_filter['product_description_select'] ) {
			$query_string = "LIKE '{$data_to_filter['product_description_text']}%' OR post_content LIKE '<%>{$data_to_filter['product_description_text'] }%'";
		} elseif ( 'ends_with' === $data_to_filter['product_description_select'] ) {
			$query_string = "LIKE '%{$data_to_filter['product_description_text']}' OR post_content LIKE '%{$data_to_filter['product_description_text' ] }<%>' ";
		} elseif ( 'contains' === $data_to_filter['product_description_select'] ) {
			$query_string = "LIKE '%{$data_to_filter['product_description_text']}%'";
		} elseif ( 'description_regex' === $data_to_filter['product_description_select'] ) {
			$query_string = "REGEXP '{$data_to_filter['product_description_text']}'";
		}
		if ( ! empty( $query_string ) ) {
			$description_get_ids_query = "SELECT id FROM {$prefix}posts WHERE post_type IN ('product', 'product_variation') AND post_content " . $query_string;
			$description_ids           = $wpdb->get_results( ( $wpdb->prepare( '%1s', $description_get_ids_query ) ? stripslashes( $wpdb->prepare( '%1s', $description_get_ids_query ) ) : $wpdb->prepare( '%s', '' ) ) );
			$description_ids_array     = array();
			if ( ! empty( $description_ids ) ) {
				foreach ( $description_ids as $k => $v ) {
					array_push( $description_ids_array, $v->id );
				}
				$description_query_ids               = ! empty( $description_ids_array ) ? implode( ',', $description_ids_array ) : '';
				$description_get_variation_ids_query = "SELECT id FROM {$prefix}posts WHERE post_type = 'product_variation' AND post_parent in ({$description_query_ids})";
				$description_variation_ids           = $wpdb->get_results( ( $wpdb->prepare( '%1s', $description_get_variation_ids_query ) ? stripslashes( $wpdb->prepare( '%1s', $description_get_variation_ids_query ) ) : $wpdb->prepare( '%s', '' ) ) );
				$description_variation_ids_array     = array();
				if ( ! empty( $description_variation_ids ) ) {
					foreach ( $description_variation_ids as $k => $v ) {
						array_push( $description_variation_ids_array, $v->id );
					}
				}
			$merge = array_merge( $description_variation_ids_array, $description_ids_array );
			} 			
		}
		$query_string_variation = '';
		if ( 'starts_with' === $data_to_filter['product_description_select'] ) {
			$query_string_variation = "LIKE '{$data_to_filter['product_description_text']}%' OR meta_value LIKE '<%>{$data_to_filter['product_description_text'] }%'";
		} elseif ( 'ends_with' === $data_to_filter['product_description_select'] ) {
			$query_string_variation = "LIKE '%{$data_to_filter['product_description_text']}' OR meta_value LIKE '%{$data_to_filter['product_description_text' ] }<%>' ";
		} elseif ( 'contains' === $data_to_filter['product_description_select'] ) {
			$query_string_variation = "LIKE '%{$data_to_filter['product_description_text']}%'";
		} elseif ( 'description_regex' === $data_to_filter['product_description_select'] ) {
			$query_string_variation = "REGEXP '{$data_to_filter['product_description_text']}'";
		}


		if ( ! empty( $query_string_variation ) ) {
			$description_get_ids_query_variation =  "SELECT post_id FROM {$prefix}postmeta WHERE meta_key = '_variation_description' AND meta_value " . $query_string_variation;

			$description_variation_ids        = $wpdb->get_results( ( $wpdb->prepare( '%1s', $description_get_ids_query_variation ) ? stripslashes( $wpdb->prepare( '%1s', $description_get_ids_query_variation ) ) : $wpdb->prepare( '%s', '' ) ) );
			$description_variations_ids_array = array();
			

			if ( ! empty( $description_variation_ids ) ) {
				foreach ( $description_variation_ids as $k => $v ) {
					array_push( $description_variations_ids_array, $v->post_id );
				}
				update_option('description_ids', $description_variations_ids_array);
				$description_var_query_ids             = ! empty( $description_variations_ids_array ) ? implode( ',', $description_variations_ids_array ) : '';
				$description_get_vari_parent_ids_query = "SELECT post_parent FROM {$prefix}posts WHERE post_type = 'product_variation' AND ID in ({$description_var_query_ids})";
				
				$description_variable_ids = $wpdb->get_results( ( $wpdb->prepare( '%1s', $description_get_vari_parent_ids_query ) ? stripslashes( $wpdb->prepare( '%1s', $description_get_vari_parent_ids_query ) ) : $wpdb->prepare( '%s', '' ) ) );
				
				$description_variable_ids_array = array();
				if ( ! empty( $description_variable_ids ) ) {
					foreach ( $description_variable_ids as $k => $v ) {
						array_push( $description_variable_ids_array, $v->post_parent );
					}
				}
				$description_variable_ids_array = array_unique( $description_variable_ids_array );
				$merge1                         = 	array_merge( $description_variable_ids_array, $description_variations_ids_array ) ;
				
			}
			
	
		}

		if ( !empty($merge) && !empty( $merge1 )) {
			$final = array_merge($merge, $merge1);
		} elseif ( !empty($merge)) {
			$final = $merge;
		} elseif ( !empty( $merge1 )) {
			$final = $merge1;
		}
		if ( !empty( $final) ) {
			$description_query = ' AND ID IN (' . implode( ',', array_values( $final ) ) . ')';
		} else {
			$description_query = ' AND ID NOT IN (ID)';
		}

	}
	// Short description filter.
	$short_description_query = '';
	if ( isset( $data_to_filter['product_short_description_select'] ) && 'all' !== $data_to_filter['product_short_description_select'] && '' !== $data_to_filter['product_short_description_text'] ) {
		$query_string = '';
		if ( 'starts_with' === $data_to_filter['product_short_description_select'] ) {
			$query_string = "LIKE '{$data_to_filter['product_short_description_text']}%' OR post_excerpt LIKE '<%>{$data_to_filter['product_short_description_text'] }%'";
		} elseif ( 'ends_with' === $data_to_filter['product_short_description_select'] ) {
			$query_string = "LIKE '%{$data_to_filter['product_short_description_text']}' OR post_excerpt LIKE '%{$data_to_filter['product_short_description_text' ] }<%>' ";
		} elseif ( 'contains' === $data_to_filter['product_short_description_select'] ) {
			$query_string = "LIKE '%{$data_to_filter['product_short_description_text']}%'";
		} elseif ( 'short_description_regex' === $data_to_filter['product_short_description_select'] ) {
			$query_string = "REGEXP '{$data_to_filter['product_short_description_text']}'";
		}
		if ( ! empty( $query_string ) ) {
			$short_description_get_ids_query = "SELECT id FROM {$prefix}posts WHERE post_type IN ('product', 'product_variation') AND post_excerpt " . $query_string;
			$short_description_ids           = $wpdb->get_results( ( $wpdb->prepare( '%1s', $short_description_get_ids_query ) ? stripslashes( $wpdb->prepare( '%1s', $short_description_get_ids_query ) ) : $wpdb->prepare( '%s', '' ) ) );
			$short_description_ids_array     = array();
			if ( ! empty( $short_description_ids ) ) {
				foreach ( $short_description_ids as $k => $v ) {
					array_push( $short_description_ids_array, $v->id );
				}
				$short_description_query_ids               = ! empty( $short_description_ids_array ) ? implode( ',', $short_description_ids_array ) : '';
				$short_description_get_variation_ids_query = "SELECT id FROM {$prefix}posts WHERE post_type = 'product_variation' AND post_parent in ({$short_description_query_ids})";
				$short_description_variation_ids           = $wpdb->get_results( ( $wpdb->prepare( '%1s', $short_description_get_variation_ids_query ) ? stripslashes( $wpdb->prepare( '%1s', $short_description_get_variation_ids_query ) ) : $wpdb->prepare( '%s', '' ) ) );
				$short_description_variation_ids_array     = array();
				if ( ! empty( $short_description_variation_ids ) ) {
					foreach ( $short_description_variation_ids as $k => $v ) {
						array_push( $short_description_variation_ids_array, $v->id );
					}
				}
				$short_description_query = ' AND ID IN (' . implode( ',', array_values( array_merge( $short_description_variation_ids_array, $short_description_ids_array ) ) ) . ')';
			} else {
				$short_description_query = ' AND ID NOT IN (ID)';
			}
		}
	}
	$price_query  = '';
	$filter_range = ! empty( $data_to_filter['range'] ) ? $data_to_filter['range'] : '';
	if ( 'all' !== $filter_range && ! empty( $filter_range ) ) {
		if ( '|' !== $filter_range ) {
			$price_query = " AND meta_key='_regular_price' AND meta_value {$filter_range} {$data_to_filter['desired_price']} ";
		} else {
			$price_query = " AND meta_key='_regular_price' AND (meta_value >= {$data_to_filter['minimum_price']} AND meta_value <= {$data_to_filter['maximum_price']}) ";
		}
	}

	$weight_query        = '';
	$filter_weight_range = ! empty( $data_to_filter['range_weight_data'] ) ? $data_to_filter['range_weight_data'] : '';
	if ( 'all' !== $filter_weight_range && ! empty( $filter_weight_range ) ) {
		if ( '|' !== $filter_weight_range ) {
			$weight_query = " AND meta_key='_weight' AND meta_value {$filter_weight_range} {$data_to_filter['desired_weight']} AND meta_value <> '' AND meta_value IS NOT NULL ";
		} else {
			$weight_query = " AND meta_key='_weight' AND (meta_value >= {$data_to_filter['minimum_weight']} AND meta_value <= {$data_to_filter['maximum_weight']}) AND meta_value <> '' AND meta_value IS NOT NULL ";
		}
	}

	$attr_condition  = '';
	$attribute_value = '';
	if ( ! empty( $data_to_filter['attribute_value_filter'] ) && is_array( $data_to_filter['attribute_value_filter'] ) ) {
		$attribute_value = implode( ',', $data_to_filter['attribute_value_filter'] );
		$attribute_value = stripslashes( $attribute_value );
		update_option('condition', 0);
		//foreach loop for getting parent ids query which is having the attribute.
		foreach ( $data_to_filter['attribute_value_filter'] as $key => $value) {
			$value = stripslashes( $value );
			if ( ! empty( $value ) ) {
				// exploding attribute and value.
				$attr_value = explode(':', $value);
				$taxonamy   = $attr_value[0] . "'";
				$slug       = $attr_value[1];
				if ("any_attribute'" === $slug) {
					$check = get_option('condition');
					if ( 0 == $check) {
						$attr_condition .= " taxonomy=$taxonamy";
						update_option('condition', 1);
					} else {
						$attr_condition .= "OR taxonomy=$taxonamy";
					}
				}
			}
		}
		  update_option('condition', 0);
		if (empty($attr_condition)) {
			$attr_condition = " CONCAT(taxonomy, ':', name) IN ({$attribute_value})";
		}
	}
	$and_attribute_condition = '';
	$and_attribute_ids       = null;
	if ( ! empty( $data_to_filter['attribute_value_and_filter'] ) && is_array( $data_to_filter['attribute_value_and_filter'] ) ) {
		// Create a attribute => values mapping.
		foreach ( $data_to_filter['attribute_value_and_filter'] as $index => $attribute ) {
			$attribute          = stripslashes( $attribute );
			$meta_key_and_value = explode( ':', trim( $attribute, '\'"' ) );
			$meta_key           = $meta_key_and_value[0];
			$meta_value         = $meta_key_and_value[1];
			if ( 'any_attribute' === $meta_value ) {
				$meta_value = '';
			}
			if ( isset( $attributes_meta_keys_and_values[ $meta_key ] ) ) {
				array_push( $attributes_meta_keys_and_values[ $meta_key ], $meta_value );
			} else {
				$attributes_meta_keys_and_values[ $meta_key ] = array( $meta_value );
			}
		}

		// For getting variations.
		$variations_initial_sql   = "SELECT DISTINCT p.ID FROM {$prefix}posts as p ";
		$variations_type_sql      = '';
		$variations_joins_sql     = '';
		$variations_condition_sql = " WHERE p.post_type LIKE 'product_variation' AND p.post_status LIKE 'publish'";

		// For getting other types.
		$initial_sql   = "SELECT DISTINCT p.ID FROM {$prefix}posts as p ";
		$type_sql      = '';
		$joins_sql     = '';
		$condition_sql = " WHERE p.post_type LIKE 'product' AND p.post_status LIKE 'publish'";

		if ( ! empty( $attributes_meta_keys_and_values ) ) {
			$count = 1;
			
			foreach ( $attributes_meta_keys_and_values as $attr_meta_key => $attr_meta_val ) {
				$attr_meta_val_imploded = "'" . implode( "', '", $attr_meta_val ) . "'";

				// Encode the string using rawurlencode becasue of cyrillic lang 
				$attr_meta_val_imploded = mb_strtolower($attr_meta_val_imploded, 'UTF-8');
				$attr_meta_val_imploded = rawurlencode($attr_meta_val_imploded);

				// Decode any encoded single quotes becasue of cyrillic lang 
				$attr_meta_val_imploded = str_replace('%27', "'", $attr_meta_val_imploded);

				$attr_meta_val = mb_strtolower($attr_meta_val[0], 'UTF-8');
				$attr_meta_val = urlencode( $attr_meta_val );
				// Other types.
				$joins_sql .= " INNER JOIN {$prefix}term_relationships as tr{$count} ON p.ID = tr{$count}.object_id INNER JOIN {$prefix}term_taxonomy as tt{$count} ON tr{$count}.term_taxonomy_id = tt{$count}.term_taxonomy_id INNER JOIN {$prefix}terms as t{$count} ON tt{$count}.term_id = t{$count}.term_id";
				$type_sql  .= " AND tt{$count}.taxonomy LIKE '{$attr_meta_key}' ";
				$type_sql  .= " AND t{$count}.slug LIKE '{$attr_meta_val}' ";

				// $attr_meta_key = mb_strtolower($attr_meta_key, 'UTF-8');
				$attr_meta_key = urlencode( $attr_meta_key );
				// Variations.
				$variations_joins_sql .= " INNER JOIN {$prefix}postmeta as pm{$count} ON p.ID = pm{$count}.post_id ";
				$variations_type_sql  .= " AND pm{$count}.meta_key LIKE 'attribute_{$attr_meta_key}' AND pm{$count}.meta_value IN ({$attr_meta_val_imploded}) ";
				$count++;
			}
		}

		$other_ids_sql_query     = $initial_sql . $joins_sql . $type_sql . $condition_sql;
		$variation_ids_sql_query = $variations_initial_sql . $variations_joins_sql . $variations_condition_sql . $variations_type_sql;

		$results_other_ids     = $wpdb->get_results( ( $wpdb->prepare( '%1s', $other_ids_sql_query ) ? stripslashes( $wpdb->prepare( '%1s', $other_ids_sql_query ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );
		$results_variation_ids = $wpdb->get_results( ( $wpdb->prepare( '%1s', $variation_ids_sql_query ) ? stripslashes( $wpdb->prepare( '%1s', $variation_ids_sql_query ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );

		$other_attr_ids     = wp_list_pluck( $results_other_ids, 'ID' );
		$variation_attr_ids = wp_list_pluck( $results_variation_ids, 'ID' );

		$and_attribute_ids = array_merge( $other_attr_ids, $variation_attr_ids );
	}

	// Custom attribute filter.
	$custom_attribute_query = '';
	if ( ! empty( $data_to_filter['custom_attribute'] ) && empty( $data_to_filter['custom_attribute_values'] ) && is_array( $data_to_filter['custom_attribute'] ) ) {
		global $wpdb;
		// Get custom attributes.
		$products_sql = "SELECT postmeta.post_id, postmeta.meta_value FROM {$prefix}postmeta AS postmeta WHERE postmeta.meta_key = '_product_attributes' AND COALESCE(postmeta.meta_value, '') != ''";
		$products     = $wpdb->get_results( ( $wpdb->prepare( '%1s', $products_sql ) ? stripslashes( $wpdb->prepare( '%1s', $products_sql ) ) : $wpdb->prepare( '%s', '' ) ) );
		// Get selected custom attributes.
		$custom_attribute_ids = array();
		foreach ( $products as $product ) {
			$product_attributes = maybe_unserialize( $product->meta_value );
			if ( is_array( $product_attributes ) || is_object( $product_attributes ) ) {
				foreach ( $product_attributes as $attribute_slug => $product_attribute ) {
					if ( isset( $product_attribute['is_taxonomy'] ) && 0 === intval( $product_attribute['is_taxonomy'] ) && 'product_shipping_class' !== $attribute_slug ) {
						$attribute_slug = urldecode($attribute_slug);
						if ( in_array( $attribute_slug, $data_to_filter['custom_attribute'], true ) ) {
							array_push( $custom_attribute_ids, $product->post_id );
						}
					}
				}
			}
		}
		$custom_attribute_query_ids = implode( ',', $custom_attribute_ids );
		// Get variation ids.
		$custom_attribute_variation_ids_sql   = "SELECT DISTINCT ID FROM {$prefix}posts LEFT JOIN {$prefix}term_relationships on {$prefix}term_relationships.object_id={$prefix}posts.ID LEFT JOIN {$prefix}term_taxonomy on {$prefix}term_taxonomy.term_taxonomy_id  = {$prefix}term_relationships.term_taxonomy_id LEFT JOIN {$prefix}terms on {$prefix}terms.term_id  ={$prefix}term_taxonomy.term_id LEFT JOIN {$prefix}postmeta on {$prefix}postmeta.post_id  ={$prefix}posts.ID WHERE  post_type = 'product_variation' AND post_status IN ('publish', 'private','draft') AND post_parent IN ({$custom_attribute_query_ids})";
		$custom_attribute_variation_ids       = $wpdb->get_results( ( $wpdb->prepare( '%1s', $custom_attribute_variation_ids_sql ) ? stripslashes( $wpdb->prepare( '%1s', $custom_attribute_variation_ids_sql ) ) : $wpdb->prepare( '%s', '' ) ) );
		$custom_attribute_variation_ids_array = array();
		if ( ! empty( $custom_attribute_variation_ids ) ) {
			foreach ( $custom_attribute_variation_ids as $k => $v ) {
				array_push( $custom_attribute_variation_ids_array, $v->ID );
			}
		}
		$final_variation_ids = array_merge( $custom_attribute_variation_ids_array, $custom_attribute_ids );
		if ( ! empty( $final_variation_ids ) ) {
			$custom_attribute_ids_in = implode( ',', $final_variation_ids );
			$custom_attribute_query  = " AND ID IN ({$custom_attribute_ids_in})";
		}
	}

	$custom_attribute_values_product_ids = array();
	if ( ! empty( $data_to_filter['custom_attribute_values'] ) && is_array( $data_to_filter['custom_attribute_values'] ) ) {
		global $wpdb;

		$other_ids_array     = array();
		$variation_ids_array = array();

		// Index array.
		$data_to_filter['custom_attribute_values'] = array_values( $data_to_filter['custom_attribute_values'] );

		// Build products query.
		$variations_sql  = "SELECT DISTINCT post_id FROM {$prefix}postmeta WHERE ";
		$other_types_sql = "SELECT DISTINCT post_id FROM {$prefix}postmeta WHERE meta_key = '_product_attributes' AND ";
		foreach ( $data_to_filter['custom_attribute_values'] as $index => $custom_attrval ) {
			$exploded_value = explode( ':', $custom_attrval );
			$key            = $exploded_value[0];
			// To sanitize special characters in attribute slug.
			$lowercase_key = sanitize_title( strtolower( $key ) );
			$value         = $exploded_value[1];
			
			$variations_sql  .= "(meta_key='attribute_{$lowercase_key}' AND meta_value='{$value}'";
			$other_types_sql .= "(meta_value LIKE '%{$key}%{$value}%'";

			// Last index.
			if ( count( $data_to_filter['custom_attribute_values'] ) === $index + 1 ) {
				$variations_sql  .= ')';
				$other_types_sql .= ')';
			} else {
				$variations_sql  .= ') OR ';
				$other_types_sql .= ') OR ';
			}
		}

		// Get variation ids.
		$variations_ids_result = $wpdb->get_results( ( $wpdb->prepare( '%1s', $variations_sql ) ? stripslashes( $wpdb->prepare( '%1s', $variations_sql ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );
		if ( ! empty( $variations_ids_result ) ) {
			$variation_ids_array = wp_list_pluck( $variations_ids_result, 'post_id' );
		}

		// Get other product type ids.
		$other_ids_result = $wpdb->get_results( ( $wpdb->prepare( '%1s', $other_types_sql ) ? stripslashes( $wpdb->prepare( '%1s', $other_types_sql ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );
		if ( ! empty( $other_ids_result ) ) {
			$other_ids_array = wp_list_pluck( $other_ids_result, 'post_id' );
		}

		$all_product_type_ids = array_unique( array_merge( $other_ids_array, $variation_ids_array ) );
		if ( ! empty( $all_product_type_ids ) ) {
			$custom_attribute_values_product_ids = $all_product_type_ids;
		}
	}

	// Tags filter.
	$tags_query = '';
	if ( isset( $data_to_filter['prod_tags'] ) && ! empty( $data_to_filter['prod_tags'] && is_array( $data_to_filter['prod_tags'] ) ) ) {
		$tag_cond = '';
		foreach ( $data_to_filter['prod_tags'] as $key => $tag_slug ) {
			if ( empty( $tag_cond ) ) {
				$tag_cond = "'" . $tag_slug . "'";
			} else {
				$tag_cond .= ",'" . $tag_slug . "'";
			}
		}
		$tags_query = " taxonomy='product_tag' AND slug  in ({$tag_cond})";
	}

	$category_condition = '';
	$filter_categories  = array();
	if ( ! empty( $data_to_filter['category_filter'] ) && is_array( $data_to_filter['category_filter'] ) ) {
		$filter_categories = elex_get_categories( $data_to_filter['category_filter'], $data_to_filter['sub_category_filter'] );
		$cat_cond          = '';
		$cat_count         = 0;

		// WPML Compatibility.
		/**
		 * Retrieve active languages using WPML.
		 *
		 * This retrieves an array of active languages configured in WPML. 
		 * It applies the 'wpml_active_languages' filter to get the current active languages.
		 *
		 * @param array|null $languages An optional array of languages; defaults to null.
		 *
		 * @return array|null An array of active languages or null if none are active.
		 *
		 * @hook wpml_active_languages
		 * @since 1.0.0
		 */
		$languages_array = apply_filters( 'wpml_active_languages', null );
		$language_codes  = array();
		if ( is_array( $languages_array ) ) {
			$language_codes = wp_list_pluck( $languages_array, 'code' );
		}

		// 2. Get the category ids of different languages.
		$wpml_category_ids = array();
		foreach ( $language_codes as $k => $language_code ) {
			foreach ( $filter_categories as $cats ) {
				/**
				 * Get the translated category ID using WPML.
				 *
				 * This retrieves the translated category ID for a given category ID and language code.
				 * It uses the 'wpml_object_id' filter to get the translated object ID.
				 *
				 * @param int|string $cats        The original category ID or array of IDs.
				 * @param string     $language_code The target language code for translation.
				 *
				 * @return int|string Translated category ID or original ID if translation is not available.
				 *
				 * @hook wpml_object_id
				 * @since 1.0.0
				 */
				$translated_category_id = apply_filters( 'wpml_object_id', $cats, 'category', false, $language_code );
				array_push( $wpml_category_ids, $translated_category_id );
			}
		}

		if ( ! empty( $wpml_category_ids ) ) {
			$filter_categories = $wpml_category_ids;
		}

		foreach ( $filter_categories as $cats ) {
			if ( empty( $cat_cond ) ) {
				$cat_cond = "'" . $cats . "'";
			} else {
				$cat_cond .= ",'" . $cats . "'";
			}
			$cat_count++;
		}
		if ( true == $data_to_filter['And_cat_check'] && isset( $data_to_filter['And_cat_check'] ) ) {

			$category_condition = " ID IN (SELECT DISTINCT ID FROM {$prefix}posts LEFT JOIN {$prefix}term_relationships on {$prefix}term_relationships.object_id={$prefix}posts.ID LEFT JOIN {$prefix}term_taxonomy on {$prefix}term_taxonomy.term_taxonomy_id = {$prefix}term_relationships.term_taxonomy_id LEFT JOIN {$prefix}terms on {$prefix}terms.term_id ={$prefix}term_taxonomy.term_id LEFT JOIN {$prefix}postmeta on {$prefix}postmeta.post_id ={$prefix}posts.ID WHERE post_type = 'product' AND post_status IN ('publish', 'private','draft') AND taxonomy='product_cat' AND {$prefix}terms.term_id IN ({$cat_cond}) GROUP BY ID HAVING COUNT( DISTINCT slug) = {$cat_count} )";
		} else {

			$category_condition = " taxonomy='product_cat' AND {$prefix}terms.term_id  in ({$cat_cond}) ";
		}
	}

	$product_image_not_exist_ids_array = array();
	if ( isset( $data_to_filter['filter_product_image_not_exist'] ) && ( 'yes' == $data_to_filter['filter_product_image_not_exist'] || 'true' == $data_to_filter['filter_product_image_not_exist'] ) ) {
		$product_image_not_exist_query  = "SELECT DISTINCT p.ID FROM {$prefix}posts p LEFT JOIN {$prefix}postmeta pm ON pm.post_id = p.ID AND pm.meta_key = '_thumbnail_id' WHERE post_type IN ( 'product', 'product_variation' ) AND (pm.meta_key is null OR pm.meta_value = '0')";
		$product_image_not_exist_result = $wpdb->get_results( ( $wpdb->prepare( '%1s', $product_image_not_exist_query ) ? stripslashes( $wpdb->prepare( '%1s', $product_image_not_exist_query ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );
		$product_image_not_exist_ids    = wp_list_pluck( $product_image_not_exist_result, 'ID' );
		if ( ! empty( $product_image_not_exist_ids ) ) {
			$product_image_not_exist_ids_array = $product_image_not_exist_ids;
		}
	}

	if ( ! empty( $tags_query ) ) {
		if ( ! empty( $category_condition ) ) {
			$category_condition .= " AND ID IN ( SELECT DISTINCT ID FROM {$prefix}posts LEFT JOIN {$prefix}term_relationships on {$prefix}term_relationships.object_id={$prefix}posts.ID LEFT JOIN {$prefix}term_taxonomy on {$prefix}term_taxonomy.term_taxonomy_id  = {$prefix}term_relationships.term_taxonomy_id LEFT JOIN {$prefix}terms on {$prefix}terms.term_id  ={$prefix}term_taxonomy.term_id LEFT JOIN {$prefix}postmeta on {$prefix}postmeta.post_id  ={$prefix}posts.ID WHERE  post_type = 'product' AND post_status IN ('publish', 'private','draft') AND " . $tags_query . ')';
		} else {
			$category_condition = $tags_query;
		}
	}
	$exclude_categories     = array();
	$exclude_categories_ids = array();
	if ( ! empty( $data_to_filter['exclude_categories'] ) && is_array( $data_to_filter['exclude_categories'] ) ) {
		$exclude_categories = elex_get_categories( $data_to_filter['exclude_categories'], $data_to_filter['exclude_subcat_check'] );
		$cat_cond           = '';
		foreach ( $exclude_categories as $cats ) {
			if ( empty( $cat_cond ) ) {
				$cat_cond = "'" . $cats . "'";
			} else {
				$cat_cond .= ",'" . $cats . "'";
			}
		}

		$exclude_categories_sql           = "SELECT ID FROM {$prefix}posts LEFT JOIN {$prefix}term_relationships ON ({$prefix}posts.ID = {$prefix}term_relationships.object_id) WHERE 1=1 AND ( {$prefix}term_relationships.term_taxonomy_id IN ({$cat_cond}) ) AND {$prefix}posts.post_type = 'product' AND ({$prefix}posts.post_status = 'publish') GROUP BY {$prefix}posts.ID";
		$exclude_categories_result        = $wpdb->get_results( ( $wpdb->prepare( '%1s', $exclude_categories_sql ) ? stripslashes( $wpdb->prepare( '%1s', $exclude_categories_sql ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );
		$exclude_categories_ids           = wp_list_pluck( $exclude_categories_result, 'ID' );
		$exclude_categories_parent        = ! empty( $exclude_categories_ids ) ? implode( ',', $exclude_categories_ids ) : '';
		$exclude_categories_variation_sql = "SELECT id FROM {$prefix}posts WHERE post_type = 'product_variation' AND post_parent in ({$exclude_categories_parent})";
		$exclude_categories_variation_res = $wpdb->get_results( ( $wpdb->prepare( '%1s', $exclude_categories_variation_sql ) ? stripslashes( $wpdb->prepare( '%1s', $exclude_categories_variation_sql ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );
		$exclude_categories_variation_ids = wp_list_pluck( $exclude_categories_variation_res, 'id' );
		$exclude_categories_ids           = array_merge( $exclude_categories_ids, $exclude_categories_variation_ids );
	}
	if ( ! empty( $title_query ) ) {
		$sql .= $title_query;
	}

	if ( ! empty( $description_query ) ) {
		$sql .= $description_query;
	}

	if ( ! empty( $short_description_query ) ) {
		$sql .= $short_description_query;
	}

	if ( ! empty( $weight_query ) ) {
		$sql .= $weight_query;
	}
	if ( ! empty( $custom_attribute_query ) ) {
		$sql .= $custom_attribute_query;
	}
	// session_start();
	// $_SESSION['bundle_check'] = 'true';
	// update_option('bundle_check', true);
	$ids_simple_external = array();
	if ( empty( $data_to_filter['type'] ) || in_array( 'simple', $data_to_filter['type'], true ) || in_array( 'external', $data_to_filter['type'], true ) || in_array( 'bundle', $data_to_filter['type'], true )) {
		$sql_simple_ext = $sql;
		if ( ! empty( $price_query ) ) {
			$sql_simple_ext .= $price_query;
		}
		if ( empty( $data_to_filter['type'] ) || ( in_array( 'simple', $data_to_filter['type'], true ) && in_array( 'external', $data_to_filter['type'], true ) && in_array( 'bundle', $data_to_filter['type'], true ) ) ) {
			$product_type_condition = " taxonomy='product_type'  AND slug  in ('simple','external','bundle' ) ";
		} elseif ( in_array( 'simple', $data_to_filter['type'], true ) && in_array( 'bundle', $data_to_filter['type'], true ) ) {

			$product_type_condition = " taxonomy='product_type'  AND slug  in ('simple','bundle') ";
		} elseif ( in_array( 'simple', $data_to_filter['type'], true ) && in_array( 'external', $data_to_filter['type'], true ) ) {

			$product_type_condition = " taxonomy='product_type'  AND slug  in ('simple','external') ";
		} elseif ( in_array( 'bundle', $data_to_filter['type'], true ) && in_array( 'external', $data_to_filter['type'], true ) ) {

			$product_type_condition = " taxonomy='product_type'  AND slug  in ('external','bundle') ";
		} elseif ( in_array( 'simple', $data_to_filter['type'], true ) ) {

			$product_type_condition = " taxonomy='product_type'  AND slug  in ('simple') ";
		} elseif ( in_array( 'bundle', $data_to_filter['type'], true ) ) {

			$product_type_condition = " taxonomy='product_type'  AND slug  in ('bundle') ";
		} elseif ( in_array( 'external', $data_to_filter['type'], true ) ) {

			$product_type_condition = " taxonomy='product_type'  AND slug  in ('external') ";
		}
		if ( ! empty( $attr_condition ) && ! empty( $category_condition ) ) {
			$main_query = $sql_simple_ext . ' AND ' . $attr_condition . ' AND ID IN (' . $sql_simple_ext . ' AND ' . $category_condition . ' AND ID IN (' . $sql_simple_ext . ' AND ' . $product_type_condition . '))';
		} elseif ( ! empty( $attr_condition ) && empty( $category_condition ) ) {
			$main_query = $sql_simple_ext . ' AND ' . $attr_condition . ' AND ID IN (' . $sql_simple_ext . ' AND ' . $product_type_condition . ')';
		} elseif ( ! empty( $category_condition ) && empty( $attr_condition ) ) {
			$main_query = $sql_simple_ext . ' AND ' . $category_condition . ' AND ID IN (' . $sql_simple_ext . ' AND ' . $product_type_condition . ')';
		} else {
			$main_query = $sql_simple_ext . ' AND ' . $product_type_condition;
		}

		$result              = $wpdb->get_results( ( $wpdb->prepare( '%1s', $main_query ) ? stripslashes( $wpdb->prepare( '%1s', $main_query ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );
		$ids_simple_external = wp_list_pluck( $result, 'ID' );
	}
	$ids_variable = array();
	if ( empty( $data_to_filter['type'] ) || in_array( 'variation', $data_to_filter['type'], true ) || in_array( 'variable', $data_to_filter['type'], true ) ) {
		$product_type_condition = " taxonomy='product_type'  AND slug  in ('variable') ";

		if ( ! empty( $attr_condition ) && ! empty( $category_condition ) ) {
			$main_query = $sql . ' AND ' . $attr_condition . ' AND ID IN (' . $sql . ' AND ' . $category_condition . ' AND ID IN (' . $sql . ' AND ' . $product_type_condition . '))';
		} elseif ( ! empty( $attr_condition ) && empty( $category_condition ) ) {
			$main_query = $sql . ' AND ' . $attr_condition . ' AND ID IN (' . $sql . ' AND ' . $product_type_condition . ')';
		} elseif ( ! empty( $category_condition ) && empty( $attr_condition ) ) {
			$main_query = $sql . ' AND ' . $category_condition . ' AND ID IN (' . $sql . ' AND ' . $product_type_condition . ')';
		} else {
			$main_query = $sql . ' AND ' . $product_type_condition;
		}
		$result       = $wpdb->get_results( ( $wpdb->prepare( '%1s', $main_query ) ? stripslashes( $wpdb->prepare( '%1s', $main_query ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );
		$ids_variable = wp_list_pluck( $result, 'ID' );
	}
	$ids_variations = array();
	if ( ! empty( $ids_variable ) && ( empty( $data_to_filter['type'] ) || in_array( 'variation', $data_to_filter['type'], true ) || in_array( 'variable', $data_to_filter['type'], true ) ) ) {
		$temp_ids   = implode( ',', $ids_variable );
		$sql        = "SELECT DISTINCT ID FROM {$prefix}posts LEFT JOIN {$prefix}term_relationships on {$prefix}term_relationships.object_id={$prefix}posts.ID LEFT JOIN {$prefix}term_taxonomy on {$prefix}term_taxonomy.term_taxonomy_id  = {$prefix}term_relationships.term_taxonomy_id LEFT JOIN {$prefix}terms on {$prefix}terms.term_id  ={$prefix}term_taxonomy.term_id LEFT JOIN {$prefix}postmeta on {$prefix}postmeta.post_id  ={$prefix}posts.ID WHERE  post_type = 'product_variation' AND post_status IN ('publish', 'private','draft') AND post_parent IN ({$temp_ids}) ";
		$attr_query = '';
		if ( ! empty( $attribute_value ) ) {
			$tt = explode( ',', $attribute_value );
			foreach ( $tt as $key => $val ) {
				$attr = explode( ':', $val );
				//encoding becasue of cyrillic lang 
				$attr_key = urlencode(mb_strtolower( str_replace( "'", '', $attr[0]  )));
				$attr_val = urlencode(mb_strtolower(str_replace( "'", '', $attr[1] )));
				if ( 'any_attribute' === $attr_val ) {
					$attr_val = '';
				}
				$attr_query .= " (meta_key='attribute_{$attr_key}' AND meta_value = '{$attr_val}') OR";
			}
			$attr_query = substr( $attr_query, 0, -2 );
		}
		$attribute            = '';
		$sub_attribute_array  = array();
		$main_attribute_array = array();
		if ( isset( $data_to_filter['attribute_value_and_filter'] ) && is_array( $data_to_filter['attribute_value_and_filter'] ) ) {
			foreach ( $data_to_filter['attribute_value_and_filter'] as $index => $attr_pair ) {
				$attr_pair     = stripslashes( $attr_pair );
				$attr_pair_arr = explode( ':', $attr_pair );
				if ( $attribute !== $attr_pair_arr[0] && '' !== $attribute ) {
					$main_attribute_array[] = $sub_attribute_array;
					$sub_attribute_array    = array();
				}
				$attribute             = $attr_pair_arr[0];
				$sub_attribute_array[] = $attr_pair;
			}
		}
		if ( ! empty( $sub_attribute_array ) ) {
			$main_attribute_array[] = $sub_attribute_array;
		}
		if ( ! empty( $main_attribute_array ) ) {
			$attr_query = '';
			$counter    = 0;
			foreach ( $main_attribute_array as $key => $unique_attribute_values ) {
				if ( 0 !== $counter ) {
					$attr_query .= ' AND ID IN (' . $sql . 'AND';
				}
				foreach ( $unique_attribute_values as $arr_index => $attribute_key_val ) {
					$attribute_key_val     = trim( $attribute_key_val, "'" );
					$attribute_key_val_arr = explode( ':', $attribute_key_val );
					// encoding becasue of cyrillic lang 					
					$attribute_key_val_arr[0] = mb_strtolower(urlencode( $attribute_key_val_arr[0] ));
					$attribute_key_val_arr[1] = mb_strtolower($attribute_key_val_arr[1]);
					$attribute_key_val_arr[1] = mb_strtolower(urlencode($attribute_key_val_arr[1]));
					if ( 'any_attribute' === $attribute_key_val_arr[1] ) {
						$attribute_key_val_arr[1] = '';
					}
					$attr_query .= " (meta_key='attribute_{$attribute_key_val_arr[0]}' AND meta_value = '{$attribute_key_val_arr[1]}') OR";
				}
				$attr_query = substr( $attr_query, 0, -2 );
				if ( 0 !== $counter ) {
					$attr_query .= ')';
				}
				$counter++;
			}
		}
		$price_sql_query = '';
		if ( ! empty( $price_query ) ) {
			$price_sql_query = 'AND ID IN (' . $sql . $price_query . ')';
		}
		if ( ! empty( $attr_query ) ) {
			$sql .= "AND ({$attr_query})";
		}
		if ( ! empty( $price_sql_query ) ) {
			$sql .= $price_sql_query;
		}
		$result = $wpdb->get_results( ( $wpdb->prepare( '%1s', $sql ) ? stripslashes( $wpdb->prepare( '%1s', $sql ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );

		$ids_variation_by_parent = wp_list_pluck( $result, 'ID' );
		// checking if variations.
		$variations_dsc = get_option('description_ids');
		if ( !empty($variations_dsc) ) {
			$ids_variations = array_intersect( $variations_dsc, $ids_variation_by_parent );
			update_option( 'description_ids', '');
		} else {
			$ids_variations = $ids_variation_by_parent;
		}
	}

	if ( ! empty( $data_to_filter['type'] ) ) {
		// If only product variations are mentioned in the product type filter and not variable, then exclude variable.
		if ( in_array( 'variation', $data_to_filter['type'], true ) && ! in_array( 'variable', $data_to_filter['type'], true ) ) {
			$ids_variable = array();
		} elseif ( in_array( 'variable', $data_to_filter['type'], true ) && ! in_array( 'variation', $data_to_filter['type'], true ) ) { // If only variable products are mentioned in the product type filter and not the variations, then exclude variations.
			$ids_variations = array();
		}
	}
	// added check for variable product incase we have regular price filter set for the filter page.
	if ( ! empty( $price_query ) ) {
		$ids_variable = array();
	}
	$res_id = array_merge( $ids_simple_external, $ids_variable, $ids_variations );
	if ( isset( $data_to_filter['enable_exclude_prods'] ) && $data_to_filter['enable_exclude_prods'] && ! empty( $res_id ) && ! empty( $data_to_filter['exclude_ids'] ) ) {
		foreach ( $res_id as $key => $val ) {
			if ( in_array( $val, $data_to_filter['exclude_ids'], true ) ) {
				unset( $res_id[ $key ] );
			}
		}
		// To reindex array values after unsetting.
		$res_id = array_values( $res_id );
	}
	if ( isset( $data_to_filter['stock_status'] ) && '' !== $data_to_filter['stock_status'] ) {
		$res_id = array_intersect( $ids_stock_filtered, $res_id );
	}

	// For sku filtered.
	if ( ! empty( $id_sku_filtered ) ) {
		$res_id = array_intersect( $id_sku_filtered, $res_id );
	}

	if ( is_array( $and_attribute_ids ) ) {
		$res_id = array_intersect( $and_attribute_ids, $res_id );
	}

	if ( ! empty( $custom_attribute_values_product_ids ) || ( ! empty( $data_to_filter['custom_attribute_values'] ) && is_array( $data_to_filter['custom_attribute_values'] ) ) ) {
		$res_id = array_intersect( $custom_attribute_values_product_ids, $res_id );
	}

	if ( ! empty( $exclude_categories_ids ) ) {
		$res_id = array_values( array_diff( $res_id, $exclude_categories_ids ) );
	}

	if ( ! empty( $product_image_not_exist_ids_array ) ) {
		$res_id = array_intersect( $product_image_not_exist_ids_array, $res_id );
	}
	
	// Reindex results.
	$res_id = array_values( $res_id );

	if ( isset( $data_to_filter['undo_sch_job'] ) && $data_to_filter['undo_sch_job'] ) {
		return $res_id;
	}

	update_option( 'bulk_edit_filtered_product_ids_for_select_unselect', $res_id );
	return $res_id;
}

/** Get Subcategories.
 *
 * @param int $parent_cat_term_id Parent Category Term ID.
 */
function xa_subcats_from_parentcat_by_term_id( $parent_cat_term_id ) {

	$args     = array(
		'hierarchical'     => 1,
		'show_option_none' => '',
		'hide_empty'       => 0,
		'parent'           => $parent_cat_term_id,
		'taxonomy'         => 'product_cat',
	);
	$subcats  = get_categories( $args );
	$temp_arr = array();
	foreach ( $subcats as $sc ) {
		array_push( $temp_arr, $sc->term_id );
		$subher = xa_filter_get_cat_hierarchy( $sc->term_id );
		if ( ! empty( $subher ) ) {
			$temp_arr = array_merge( $temp_arr, $subher );
		}
	}
	return $temp_arr;
}

/** Get Category Hierarchy.
 *
 * @param var $parent parent.
 */
function xa_filter_get_cat_hierarchy( $parent ) {
	$cat_args = array(
		'hide_empty'   => 0,
		'taxonomy'     => 'product_cat',
		'hierarchical' => 1,
		'orderby'      => 'name',
		'parent'       => $parent,
		'order'        => 'ASC',
	);
	$cats     = get_categories( $cat_args );
	$ret      = array();
	if ( ! empty( $cats ) ) {
		foreach ( $cats as $cat ) {
				$id = $cat->cat_ID;
				array_push( $ret, $id );
				$ret = array_merge( $ret, xa_filter_get_cat_hierarchy( $id ) );
		}
	}
	return $ret;
}
/** Update custom meta.
 *
 * @param number $pid pid.
 * @param number $val val.
 */
function eh_bep_update_custom_meta( $pid, $val ) {
	$meta_key      = get_option( 'eh_bulk_edit_meta_values_to_update' );
	$undo_val      = array();
	$meta_key_size = count( $meta_key );
	$product       = wc_get_product( $pid );
	for ( $i = 0; $i < $meta_key_size; $i++ ) {
		$undo_data = $product->get_meta( $meta_key[ $i ] );
		array_push( $undo_val, $undo_data );
		if ( '' !== $val[ $i ] ) {
			$product->update_meta_data( $meta_key[ $i ], $val[ $i ] );
			$product->save();
		}
	}
	return $undo_val;
}
/**
 * Function for check sale price, when we are updating regular price and sale price together.
 */
function eh_bep_check_sale_price( $sale_select, $sale_text, $sale_round_text, $sale_round_select, $product_data_sale, $regular_check_val ) {
	$sale_val = '';
	switch ( $sale_select ) {
		case 'up_percentage':
			if ( '' !== $product_data_sale ) {
				$per_val = $product_data_sale * ( $sale_text / 100 );
				$cal_val = $product_data_sale + $per_val;
				if ( '' !== $sale_round_select ) {
					if ( '' === $sale_round_text ) {
						$sale_round_text = 1;
					}
					$got_sale = $cal_val;
					switch ( $sale_round_select ) {
						case 'up':
							$cal_val = eh_bep_round_ceiling( $got_sale, $sale_round_text );
							break;
						case 'down':
							$cal_val = eh_bep_round_ceiling( $got_sale, -$sale_round_text );
							break;
					}
				}
				$sale_val = wc_format_decimal( $cal_val, '', true );
				// leave sale price blank if sale price increased by -100%.
				if ( 0 == $sale_val ) {
					$sale_val = '';
				}
				
			}
			break;
		case 'down_percentage':
			if (!empty($product_data_sale) && 0 !== $product_data_sale ) {
				$per_val = $product_data_sale * ( $sale_text / 100 );
				$cal_val = $product_data_sale - $per_val;
				if ( '' === $sale_round_text ) {
					$sale_round_text = 1;
				}
					$got_sale = $cal_val;
				switch ( $sale_round_select ) {
					case 'up':
						$cal_val = eh_bep_round_ceiling( $got_sale, $sale_round_text );
						break;
					case 'down':
						$cal_val = eh_bep_round_ceiling( $got_sale, -$sale_round_text );
						break;
				}
				$sale_val = wc_format_decimal( $cal_val, '', true );
				// leave sale price blank if sale price decreased by 100%.
				if ( 0 === intval( $sale_val ) || $sale_val < 0 ) {
					$sale_val = '';
				}
				
			}
			break;
		case 'up_price':
			if ( '' !== $product_data_sale ) {
				$cal_val = $product_data_sale + $sale_text;
				if ( '' !== $sale_round_select ) {
					if ( '' === $sale_round_text ) {
						$sale_round_text = 1;
					}
					$got_sale = $cal_val;
					switch ( $sale_round_select ) {
						case 'up':
							$cal_val = eh_bep_round_ceiling( $got_sale, $sale_round_text );
							break;
						case 'down':
							$cal_val = eh_bep_round_ceiling( $got_sale, -$sale_round_text );
							break;
					}
				}
				$sale_val = wc_format_decimal( $cal_val, '', true );
				if ( $sale_val < 0 || 0 == $sale_val ) {
					$sale_val = '';
				}
				
			}
			break;
		case 'down_price':
			if (!empty($product_data_sale) && 0 !== $product_data_sale ) {
					$cal_val = $product_data_sale - $sale_text;
				if ( '' === $sale_round_text ) {
					$sale_round_text = 1;
				}
					$got_sale = $cal_val;
				switch ( $sale_round_select ) {
					case 'up':
						$cal_val = eh_bep_round_ceiling( $got_sale, $sale_round_text );
						break;
					case 'down':
						$cal_val = eh_bep_round_ceiling( $got_sale, -$sale_round_text );
						break;
				}
				$sale_val = wc_format_decimal( $cal_val, '', true );
			}
			break;
		case 'flat_all':
			$sale_val = wc_format_decimal( $sale_text, '', true );
			break;
	}
	return $sale_val;
}

function elex_update_bundled_item_meta( $bundled_item_id, $meta_key, $new_meta_value) {
	// Use the Fluent Query Builder to update the meta value
	$updated = wpFluent()->table('woocommerce_bundled_itemmeta')
		->where('bundled_item_id', $bundled_item_id)
		->where('meta_key', $meta_key)
		->update(['meta_value' => $new_meta_value]);

}
