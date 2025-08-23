<?php
/**
 *
 * Bulk Edit Password Protect.
 *
 * @package ELEX Bulk Edit Products, Prices & Attributes for Woocommerce
 */

require_once 'class-bulk-edit-log.php';

/** Set product password.
 *
 * @param string $password password.
 * @param array  $product_array product array.
 * @param string $visibility_action visibility action.
 */
function elex_bep_set_password_for_product( $password, $product_array, $visibility_action ) {
	global $wpdb;
	$prefix = $wpdb->prefix;
	$ids    = implode( ',', $product_array );
	Bulk_Edit_Log::log_update( $ids, 'Array IDS ' );
	if ( 'public' === $visibility_action ) {
		$sql_query    = "UPDATE {$prefix}posts SET post_password ='', post_status = 'publish'  WHERE ID IN ({$ids})";
		$resulted_ids = $wpdb->get_results( ( $wpdb->prepare( '%1s', $sql_query ) ? stripslashes( $wpdb->prepare( '%1s', $sql_query ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );
	} elseif ( 'password protected' === $visibility_action ) {
		$sql_query    = "UPDATE {$prefix}posts SET post_password = '{$password}',post_status = 'publish' WHERE ID IN ({$ids})";
		$resulted_ids = $wpdb->get_results( ( $wpdb->prepare( '%1s', $sql_query ) ? stripslashes( $wpdb->prepare( '%1s', $sql_query ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );
	} elseif ( 'private' === $visibility_action ) {
		$sql_query    = "UPDATE {$prefix}posts SET post_password ='', post_status = 'private'  WHERE ID IN ({$ids})";
		$resulted_ids = $wpdb->get_results( ( $wpdb->prepare( '%1s', $sql_query ) ? stripslashes( $wpdb->prepare( '%1s', $sql_query ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );
	}
	Bulk_Edit_Log::log_update( $resulted_ids, 'Resulted IDS' );
}

/** Get product password.
 *
 * @param any $post_id post id.
 */
function elex_bep_get_password( $post_id ) {
	global $wpdb;
	$prefix            = $wpdb->prefix;
	$sql_query         = "SELECT post_password FROM {$prefix}posts  WHERE ID = {$post_id}";
	$resulted_password = $wpdb->get_results( ( $wpdb->prepare( '%1s', $sql_query ) ? stripslashes( $wpdb->prepare( '%1s', $sql_query ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );
	return $resulted_password[0]['post_password'];
}


/** Set password for single product.
 *
 * @param any    $product_id product id.
 * @param string $password password.
 */
function elex_bep_set_password_for_single_product( $product_id, $password, $visibility_action ) {
	global $wpdb;
	$prefix = $wpdb->prefix;
	if ( empty( $password ) ) {
		$sql_query = "UPDATE {$prefix}posts SET post_password ='{$password}', post_status = '{$visibility_action}'   WHERE ID = {$product_id}";
	} else {
		$sql_query = "UPDATE {$prefix}posts SET post_password ={$password}, post_status = '{$visibility_action}'  WHERE ID = {$product_id}";
	}
	$resulted_ids = $wpdb->get_results( ( $wpdb->prepare( '%1s', $sql_query ) ? stripslashes( $wpdb->prepare( '%1s', $sql_query ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );
}
