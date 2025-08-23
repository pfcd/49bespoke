<?php
/**
 * Buttons & Labels options tab
 *
 * @package YITH\CatalogMode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

return array(
	'buttons-labels' => array(
		'buttons-labels_list_table' => array(
			'type'          => 'post_type',
			'post_type'     => 'ywctm-button-label',
			'wp-list-style' => 'classic',
		),
	),
);
