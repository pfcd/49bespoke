<?php
/**
 * Exclusion items tab
 *
 * @package YITH\CatalogMode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

return array(
	'exclusions-items' => array(
		'exclusions-items-tab' => array(
			'type'           => 'custom_tab',
			'action'         => 'ywctm_exclusions_items',
			'show_container' => true,
		),
	),
);
