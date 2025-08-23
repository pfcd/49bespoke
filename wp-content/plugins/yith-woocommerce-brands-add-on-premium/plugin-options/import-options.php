<?php
/**
 * Import tab
 *
 * @author  YITH <plugins@yithemes.com>
 * @package YITH\Brands\PluginOptions
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

$import_options = array(
	'import' => array(
		'import_brands_section'     => array(
			'name' => __( 'Import brands', 'yith-woocommerce-brands-add-on' ),
			'type' => 'title',
		),
		'import_brands'             => array(
			'id'        => 'ywbr_import_csv',
			'type'      => 'yith-field',
			'yith-type' => 'custom',
			'action'    => 'yith_ywbr_import_brands',
		),
		'import_brands_section_end' => array(
			'type' => 'sectionend',
		),
	),
);

return $import_options;
