<?php


global $wpdb;
$prefix = $wpdb->prefix;
/** Function for inserting edit data and filtered data into data base */
function insert_data_into_database( $values ) {
	$values_array = array(
	  'job_name'         => $values['job_name'],
	  'filter_data'      => $values['filter_data'],
	  'edit_data'        => $values['edit_data'],
	  'created_at'       => wp_date('Y-m-d H:i:s'), 
	  'create_log_file'  => $values['create_log_file'],
	  'is_reversible'  => $values['is_reversible']
	  );
	if ($values['schedule_on']) {
	  $values_array['schedule_on'] = $values['schedule_on'];
	}
	if ($values['revert_on']) {
	  $values_array['revert_on'] = $values['revert_on'];
	}
	if ($values['stop_schedule']) {
	  $values_array['stop_schedule'] = $values['stop_schedule'];
	}
	if ($values['schedule_frequency']) {
	  $values_array['schedule_frequency'] = $values['schedule_frequency'];
	}
	$job_idd = $values['job_id'];
	return wpFluent()->table('elex_bep_jobs')->where('job_id', '=', $job_idd)->update(
		 $values_array
		);
		
}
function insert_migration_schedulelater_data_into_database( $values ) {
  $values_array = array(
	'job_name'         => $values['job_name'],
	'filter_data'      => $values['filter_data'],
	'created_at'       => wp_date('Y-m-d H:i:s'), 
	'create_log_file'  => $values['create_log_file'],
	'is_reversible'    => $values['is_reversible'],
	'schedule_frequency'=> $values['schedule_frequency'],
	'stop_schedule'     => $values['stop_schedule']
	);
	if ($values['schedule_on']) {
	  $values_array['schedule_on'] = $values['schedule_on'];
	}
	if ($values['revert_on']) {
	  $values_array['revert_on'] = $values['revert_on'];
	}
	if ($values['stop_schedule']) {
	  $values_array['stop_schedule'] = $values['stop_schedule'];
	}
  return wpFluent()->table('elex_bep_jobs')->insert(
	   $values_array
	  );
	  
}
function insert_migration_bulkeditnow_data_into_database( $values ) {
  $values_array = array(
	'job_name'         => $values['job_name'],
	'filter_data'      => $values['filter_data'],
	'edit_data'        => $values['edit_data'],
	'created_at'       => wp_date('Y-m-d H:i:s'), 
	'create_log_file'  => $values['create_log_file'],
	'is_reversible'    => $values['is_reversible'],
	);
  return wpFluent()->table('elex_bep_jobs')->insert(
	   $values_array
	  );
	  
}
/**Function for inserting previous stage data into database */

function revert_data_into_database( $values ) {
	$revert_data = wpFluent()->table('elex_bep_job_undo_products')->insert(
	array(
	'job_id'             => $values['job_id'],
	'product_id'         => $values['product_id'],
	'undo_product_data'  => $values['undo_product_data']
	)
  );

}

function job_name_insert( $values ) {
	return wpFluent()->table('elex_bep_jobs')->insert(
		array(
			'job_name' => $values
		)
	   );
}

function insert_job_schedule( $job_values ) {
  return wpFluent()->table('elex_bep_bulk_edit_job_schedule')->insert(
	   array(
		   'job_id'        => $job_values['job_id'],
		   'batch_no'      => $job_values['batch_no'],
		   'schedule_date' => $job_values['schedule_date'],
		   'job_status'    => $job_values['job_status']
	   )
	  );
}

function insert_into_sub_job_schedule( $sub_job_values ) {
  return wpFluent()->table('elex_bep_bulk_edit_subjob_schedule')->insert(
	   array(
		   'schedule_job_id'  => $sub_job_values['schedule_job_id'],
		   'job_id'           => $sub_job_values['job_id'],
		   'chunk_no'         => $sub_job_values['chunk_no'],
		   'sub_job_time'     => $sub_job_values['sub_job_time'],
		   'sub_job_status'   => $sub_job_values['job_status']
	   )
	  );
}








