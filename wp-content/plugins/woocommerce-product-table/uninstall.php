<?php
/**
 * Uninstall WooCommerce Product Table
 *
 * @package   WooCommerce Product Table
 * @author    Barn2 Plugins <support@barn2.com>
 * @license   GPL-3.0
 * @copyright Barn2 Media Ltd
 */

// If uninstall not called from WordPress, then exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$settings = get_option( 'wcpt_shortcode_defaults' );

if ( ! isset( $settings['delete_data'] ) || ! $settings['delete_data'] ) {
	return;
}

// Delete plugin options
$options_to_delete = [
	'wcpt_shortcode_defaults',
	'wcpt_misc_settings',
	'wcpt_table_styling',
	'barn2_plugin_license_12913',
	'barn2_plugin_promo_12913',
	'barn2_plugin_review_banner_12913',
];

foreach ( $options_to_delete as $option ) {
	delete_option( $option );
}

// Drop custom database table
global $wpdb;

// Drop the main tables table
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}wpt_tables" );

// Clean up any remaining transients
$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '%_wpt_%'" );

// Delete the database version option
delete_option( 'wpdb_wpt_tables_version' );

// Clear any cached data
wp_cache_flush();
