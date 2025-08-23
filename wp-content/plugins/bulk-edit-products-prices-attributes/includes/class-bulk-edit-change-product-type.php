<?php
/**
 *
 * Bulk Edit Change Product Type.
 *
 * @package ELEX Bulk Edit Products, Prices & Attributes for Woocommerce
 */

/** Change product type.
 *
 * @param array $ids_array ids array.
 * @param any   $product_type product type.
 */
function elex_bep_change_product_type( $ids_array, $product_type ) {
	global $wpdb;
	$prefix        = $wpdb->prefix;
	$product_type  = strtolower( $product_type );
	$ids_array     = implode( ',', $ids_array );
	$term_id_query = "SELECT * FROM {$prefix}terms WHERE slug IN ('simple','variable','external')";
	$term_id_array = $wpdb->get_results( ( $wpdb->prepare( '%1s', $term_id_query ) ? stripslashes( $wpdb->prepare( '%1s', $term_id_query ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );
	if ( ! empty( $term_id_array ) ) {
		$term_id_from = array();
		$term_id_to   = 0;
		foreach ( $term_id_array as $key => $value ) {
			if ( 'simple' === $product_type ) {
				if ( 'simple' === $value['slug'] ) {
					$term_id_to = $value['term_id'];
				} elseif ( 'variable' === $value['slug'] ) {
					$term_id_from[] = $value['term_id'];
				} elseif ( 'external' === $value['slug'] ) {
					$term_id_from[] = $value['term_id'];
				}
			} elseif ( 'variable' === $product_type ) {
				if ( 'variable' === $value['slug'] ) {
					$term_id_to = $value['term_id'];
				} elseif ( 'simple' === $value['slug'] ) {
					$term_id_from[] = $value['term_id'];
				} elseif ( 'external' === $value['slug'] ) {
					$term_id_from[] = $value['term_id'];
				}
			} elseif ( 'external' === $product_type ) {
				if ( 'external' === $value['slug'] ) {
					$term_id_to = $value['term_id'];
				} elseif ( 'simple' === $value['slug'] ) {
					$term_id_from[] = $value['term_id'];
				} elseif ( 'variable' === $value['slug'] ) {
					$term_id_from[] = $value['term_id'];
				}
			}
		}
		if ( empty( $term_id_from ) || ( ! $term_id_to ) ) {
			return false;
		}
	} else {
		return false;
	}
	$term_id_from          = implode( ',', $term_id_from );
	$sql_query_change_type = "UPDATE {$prefix}term_relationships SET term_taxonomy_id = '{$term_id_to}' WHERE {$prefix}term_relationships.object_id IN ({$ids_array}) AND {$prefix}term_relationships.term_taxonomy_id IN ({$term_id_from})";
	$result                = $wpdb->get_results( ( $wpdb->prepare( '%1s', $sql_query_change_type ) ? stripslashes( $wpdb->prepare( '%1s', $sql_query_change_type ) ) : $wpdb->prepare( '%s', '' ) ), ARRAY_A );
}

/** Collect product type.
 *
 * @param array $product_data product data.
 */
function elex_bep_collect_product_type_array( $product_data ) {
	$simple_product_array   = array();
	$variable_product_array = array();
	$external_product_array = array();

	foreach ( $product_data as $key => $value ) {
		if ( 'simple' === $value['product_type_status'] ) {
			array_push( $simple_product_array, $value['id'] );
		} elseif ( 'variable' === $value['product_type_status'] ) {
			array_push( $variable_product_array, $value['id'] );
		} elseif ( 'external' === $value['product_type_status'] ) {
			array_push( $external_product_array, $value['id'] );
		}
	}


	if ( ! empty( $simple_product_array ) ) {
		elex_bep_change_product_type( $simple_product_array, 'simple' );
	}
	if ( ! empty( $variable_product_array ) ) {
		elex_bep_change_product_type( $variable_product_array, 'variable' );
	}
	if ( ! empty( $external_product_array ) ) {
		elex_bep_change_product_type( $external_product_array, 'external' );
	}
}
