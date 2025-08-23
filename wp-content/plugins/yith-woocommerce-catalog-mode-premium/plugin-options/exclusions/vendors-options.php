<?php
/**
 * Exclusion vendors tab
 *
 * @package YITH\CatalogMode
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

return array(
	'exclusions-vendors' => array(
		'exclusions-vendors-tab' => array(
			'type'           => 'custom_tab',
			'action'         => 'ywctm_exclusions_vendors',
			'show_container' => true,
		),
	),
);
