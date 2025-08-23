<?php
/**
 *
 * Bulk edit log.
 *
 * @package ELEX Bulk Edit Products, Prices & Attributes for Woocommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Bulk Edit Log */
class Bulk_Edit_Log {
	/** Log Heading  */
	public static function init_log() {
		$content = "<------------------- Address Validation Log File  ------------------->\n";
		return $content;
	}

	/**
	 * Function to write Bulk edit log.
	 *
	 * @param array  $msg Log message.
	 *
	 * @param string $title Log title.
	 */
	public static function log_update( $msg, $title ) {

		$log      = new WC_Logger();
		$head     = '<------------------- ( ' . $title . ") ------------------->\n";
		$log_text = $head . print_r( (object) $msg, true );
		$log->add( 'bulk_edit_log', $log_text );
	}
}
