<?php
/**
 *
 * Bulk Edit Datatable.
 *
 * @package ELEX Bulk Edit Products, Prices & Attributes for Woocommerce
 */

function bulk_edit_create_job_tables() {
	$option_key = 'elex_bp_migration_jobs_table';
	
	if (get_option($option_key) == 21) {
		return;
	}
	
	global $wpdb;
	$charset_collate =  $wpdb->get_charset_collate();
	$table_name      =  $wpdb->prefix . 'elex_bep_jobs';


	$bulk_edit_table = "CREATE TABLE if not exists $table_name(
        job_id INT NOT NULL UNIQUE AUTO_INCREMENT,
        job_name VARCHAR(50),
        filter_data LONGTEXT,
        edit_data  BLOB,
        schedule_on DATETIME DEFAULT NULL,
        revert_on DATETIME DEFAULT NULL,
        is_scheduled_job_complete BOOLEAN DEFAULT false,
        is_revert_job_complete BOOLEAN DEFAULT false,
        is_reversible BOOLEAN DEFAULT false,
        created_at DATETIME DEFAULT NULL,
        create_log_file BOOLEAN,
        schedule_frequency varchar(10) DEFAULT NULL,
        stop_schedule DATETIME DEFAULT NULL,
        meta text DEFAULT NULL,
        PRIMARY KEY (job_id)) $charset_collate";
	
	
	$bulk_edit_undo_product_table = $wpdb->prefix . 'elex_bep_job_undo_products';
	$undo_table                   = "CREATE TABLE if not exists $bulk_edit_undo_product_table(
        ID  int NOT NULL UNIQUE AUTO_INCREMENT,
        job_id INT,
        product_id INT,
        undo_product_data BLOB) $charset_collate";
	
	$bulk_edit_job_schedule = $wpdb->prefix . 'elex_bep_bulk_edit_job_schedule';
	$job_schedule           = "CREATE TABLE if not exists $bulk_edit_job_schedule(
        ID  int NOT NULL UNIQUE AUTO_INCREMENT,
        job_id INT,
        batch_no INT,
        schedule_date DATETIME DEFAULT NULL,
        job_status INT) $charset_collate";
	
	$bulk_edit_sub_job_schedule = $wpdb->prefix . 'elex_bep_bulk_edit_subjob_schedule';
	$sub_job_schedule           = "CREATE TABLE if not exists $bulk_edit_sub_job_schedule(
        ID  int NOT NULL UNIQUE AUTO_INCREMENT,
        schedule_job_id INT,
        job_id INT,
        chunk_no INT,
        sub_job_time DATETIME DEFAULT NULL,
        sub_job_status INT) $charset_collate";

require_once ABSPATH . 'wp-admin/includes/upgrade.php';

dbDelta($bulk_edit_table);
dbDelta($undo_table );
dbDelta($job_schedule);
dbDelta($sub_job_schedule );

update_option($option_key, 21 );
}
