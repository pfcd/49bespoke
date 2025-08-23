<?php
require_once 'insert_functions.php';
require_once 'ajax-apifunctions.php';
/**
 * Inserting values into "insert_into_sub_job_schedule" table.
 */
function process_job_schedule ( $id ) {
	global $wpdb;
	$prefix = $wpdb->prefix;
	$job_id = wpFluent()->table('elex_bep_bulk_edit_job_schedule')->where('ID', '=', $id)->select('job_id')->first();
	$job_id = $job_id->job_id;
	$job    = wpFluent()->table('elex_bep_jobs')->where( 'job_id', '=', $job_id)->select( '*' )->first();
	$job    = (array) $job;

  $filter_data   = maybe_unserialize($job['filter_data']); 
  $product_count = count($filter_data['pid']);
  $chunk_no      = ceil( $product_count/100 );
	for ( $i=0; $i < $chunk_no; $i++) {
		  $values = [
			'schedule_job_id'  => $id,
			'job_id'           => $job_id,
			'chunk_no'         => $i,
			'sub_job_time'     => wp_date('Y-m-d H:i:s'),
			'job_status'       => 0
		  ];
		insert_into_sub_job_schedule( $values );
	}
	wpFluent()->table('elex_bep_bulk_edit_job_schedule')->where('ID', '=', $id)->update( array( 'job_status' => 1 )  );
	//frequency check.
	 $next_schedule = $job['schedule_on'];
	 $next_schedule = date_create( $next_schedule );
	if ( null != $job['schedule_frequency']) {
		//daily
		if ( 'daily' === $job['schedule_frequency']) {
		   $next_schedule->modify('+1 day');
		}
		//weekly
		if ( 'weekly' === $job['schedule_frequency']) {
			if ( !empty($filter_data['schedule_weekly_days']) ) {
				$week_days        = $filter_data['schedule_weekly_days'];
				$num_current_date =  wp_date('w', strtotime(wp_date('Y-m-d H:i:s')));
				$diff_days        = -1;
				foreach ($week_days as $key => $val) {
					if ( $val > $num_current_date ) {
						$diff_days = $val - $num_current_date;
						break;
					}
				}
				if (-1 == $diff_days) {
				  $diff_days = 6 - $num_current_date + min( $week_days) + 1;
				}
				$next_schedule->modify($diff_days . 'days');
			
			} else {
				$next_schedule->modify('+1 week');	
			}
		}
		//monthly
		if ( 'monthly' === $job['schedule_frequency']) {
			if ( !empty($filter_data['schedule_monthly_days']) ) {
				$month_days       = $filter_data['schedule_monthly_days'];
				$num_current_date =  wp_date('d', strtotime(wp_date('Y-m-d H:i:s')));
				$diff_days        = -1;
				foreach ( $month_days as $key => $val ) {
					if ( $val > $num_current_date) {
						$diff_days = $val - $num_current_date;
						break;
					   
					}
				}
				if ( -1 == $diff_days ) {
					$diff_days = wp_date('t') - $num_current_date + min( $month_days ) + 1;
				}
				$next_schedule->modify($diff_days . 'days');
			} else {
				$next_schedule->modify('+1 month');
			}
		}
		//Comparing next schedule and stop schedule 
		if ($next_schedule->format('U') > strtotime($job['stop_schedule'])) {
			$next_schedule = $next_schedule->format('Y-m-d H:i:s');
			wpFluent()->table('elex_bep_jobs')->where('job_id', '=', $job_id)->update( array( 'is_scheduled_job_complete' => true ));
			wpFluent()->table('elex_bep_jobs')->where('job_id', '=', $job_id)->update( array( 'schedule_on' => $next_schedule ));
			wpFluent()->table('elex_bep_bulk_edit_job_schedule')->insert(
			array(
				'job_id'        => $job_id,
				'batch_no'      => 2,
				'schedule_date' => $next_schedule,
				'job_status'    => 0
			)
			);
		} else {
		  wpFluent()->table('elex_bep_jobs')->where('job_id', '=', $job_id)->update( array( 'is_scheduled_job_complete' => false ) );
		}
	
	} else {
		wpFluent()->table('elex_bep_jobs')->where('job_id', '=', $job_id)->update( array( 'is_scheduled_job_complete' => true ) );
	}

}
/**
 * Schedule job update once schedule_date reaches the current date.
 */
function process_chunk_job_schedule( $id ) {
	global $wpdb;
	$prefix  = $wpdb->prefix;
	$sub_job = wpFluent()->table('elex_bep_bulk_edit_subjob_schedule')->where('ID', '=', $id)->select('job_id', 'chunk_no', 'schedule_job_id')->first();
	$sub_job = (array) $sub_job;
	$job_id  = $sub_job['job_id'] ;
	$job     = wpFluent()->table('elex_bep_jobs')->where('job_id', '=', $job_id)->select('*')->first();
	$job     = (array) $job;


	$job['filter_data'] = unserialize($job['filter_data']);
	$chunked            = array_chunk($job['filter_data']['pid'], 100);
	
	$job['filter_data']['pid'] =  $chunked[$sub_job['chunk_no']];
	require_once 'ajax-apifunctions.php';
	eh_bep_update_product_callback( $job ); 

	wpFluent()->table('elex_bep_bulk_edit_subjob_schedule')->where('ID', '=', $id)->update( array( 'sub_job_status' => 2 )  );

   $count =  wpFluent()->table('elex_bep_bulk_edit_subjob_schedule')
		->where('schedule_job_id', '=', $sub_job['schedule_job_id'])
		->where('sub_job_status', '<>', 2)
		->count();
	if ( 0 === $count ) {
		wpFluent()->table('elex_bep_bulk_edit_job_schedule')
		->where('ID', '=', $sub_job['schedule_job_id'] )
		->update( array( 'job_status' => 2 )  );
	}
	
}

add_action('elex_bep_process_job_schedule', 'process_job_schedule');
add_action('elex_bep_process_chunk_job_schedule', 'process_chunk_job_schedule');
add_action('elex_bep_revert_job_schedule', 'update_revert_data_check');
/**
 * Revert job update.
 */
function update_revert_data_check( $job_id ) {

	$revert_data = wpFluent()->table('elex_bep_job_undo_products')->where('job_id', '=', $job_id)->select('undo_product_data')->get();

	$job         = wpFluent()->table('elex_bep_jobs')->where('job_id', '=', $job_id)->select('*')->first();
	$job         = (array) $job;
	$revert_data = array_map(function( $revert_item) {
		return maybe_unserialize($revert_item->undo_product_data);
	}, $revert_data);
	eh_bep_undo_update_callback( $revert_data );
	$filter_data = maybe_unserialize($job['filter_data']); 
	//Frequency check
	$next_revert = $job['revert_on'];
	$next_revert = date_create( $next_revert );
	if ( null !== $job['schedule_frequency']) {
	//Daily
		if ( 'daily' === $job['schedule_frequency']) {
		   $next_revert->modify('+1 day');
		}
	//Weekly
		if ( 'weekly' === $job['schedule_frequency']) {
			if ( !empty($filter_data['schedule_weekly_days']) ) {
				$week_days        = $filter_data['schedule_weekly_days'];
				$num_current_date =  wp_date('w', strtotime(wp_date('Y-m-d H:i:s')));
				$diff_days        = -1;
				foreach ($week_days as $key => $val) {
					if ( $val > $num_current_date ) {
						$diff_days = $val - $num_current_date;
						break;
					}
				}
				if (-1 === $diff_days) {
				  $diff_days = 6 - $num_current_date + min( $week_days) + 1;
				}
				$next_revert->modify($diff_days . 'days');
			
			} else {
				$next_revert->modify('+1 week');	
			}
		}
		//Monthly
		if ( 'monthly' === $job['schedule_frequency']) {
			if ( !empty($filter_data['schedule_monthly_days']) ) {
				$month_days       = $filter_data['schedule_monthly_days'];
				$num_current_date =  wp_date('d', strtotime(wp_date('Y-m-d H:i:s')));
				$diff_days        = -1;
				foreach ( $month_days as $key => $val ) {
					if ( $val > $num_current_date) {
						$diff_days = $val - $num_current_date;
						break;
					   
					}
				}
				if ( -1 === $diff_days ) {
					$diff_days = wp_date('t') - $num_current_date + min( $month_days ) + 1;
				}
				$next_schedule->modify($diff_days . 'days');
			} else {
				$next_schedule->modify('+1 month');
			}
		}
		//Comparing next revert and stop schedule
		if ($next_revert->format('U') > strtotime($job['stop_schedule'])) {
			$next_revert = $next_revert->format('Y-m-d H:i:s');
			wpFluent()->table('elex_bep_jobs')->where('job_id', '=', $job_id)->update( array( 'is_revert_job_complete' => false ) );
			wpFluent()->table('elex_bep_jobs')->where('job_id', '=', $job_id)->update( array( 'revert_on' => $next_revert ));
		} else {
		  wpFluent()->table('elex_bep_jobs')->where('job_id', '=', $job_id)->update( array( 'is_revert_job_complete' => true ) );
		}
	
	} else {
		wpFluent()->table('elex_bep_jobs')->where('job_id', '=', $job_id)->update( array( 'is_revert_job_complete' => true ) );
	}

	

} 

/**Schedule jobs */

add_action('admin_init', function () {
	global $wpdb;
	$prefix         = $wpdb->prefix;
	$scheduled_jobs = wpFluent()->table( 'elex_bep_bulk_edit_job_schedule' )->where( 'job_status', '=', 0)->select( '*' )->get();

	foreach ($scheduled_jobs as $key => $scheduled_job) {
	 $time = get_gmt_from_date( $scheduled_job->schedule_date );
		wp_schedule_single_event( strtotime($time), 'elex_bep_process_job_schedule', array($scheduled_job->ID));
	}
	$subjobs   = wpFluent()->table( 'elex_bep_bulk_edit_subjob_schedule' )->where( 'sub_job_status', '=', 0)->select( '*' )->get();
	$date_time = time();

	foreach ($subjobs as $key => $subjob) {
		wp_schedule_single_event( $date_time, 'elex_bep_process_chunk_job_schedule', array($subjob->ID));
	}

});
	
/**
 * Revert job cron.
 */

add_action('admin_init', function () {
	global $wpdb;
	$prefix      = $wpdb->prefix;
	$revert_jobs = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT * FROM {$wpdb->prefix}elex_bep_jobs WHERE revert_on IS NOT NULL AND is_revert_job_complete = %d",
			0
		)
	);
	foreach ($revert_jobs as $key => $revert_job) {
		$revert_time = get_gmt_from_date( $revert_job->revert_on );
		wp_schedule_single_event( strtotime($revert_time), 'elex_bep_revert_job_schedule', array($revert_job->job_id)); 
	}
});


 /**
  * Migration.
  * Migration has to run only once.other wise for every refresh it will update same jobs in database.
  * For that I used get_option and update_option. I stored key in $option_key_mig.
  * For the first time it will empty, once function runs at the end it will update as 5.
  * And I given if condtion like if (get_option($option_key_mig) != 5 ), now function execute only one time.
  */
$option_key_mig = 'elex_bep_migration_jobs';
//Getting updated data and comparing. 
if (get_option($option_key_mig) != 5 ) {
	   add_action('admin_init', function () {
		$scheduled_jobs = get_option( 'elex_bep_scheduled_jobs' );
		if ($scheduled_jobs) {
			foreach ( $scheduled_jobs as $key => $val ) {
						   global $wpdb;
						   $prefix                 = $wpdb->prefix;
						   $job_name               = $val['job_name'];
						   $stop_schedule          = null;
						   $schedule_on            = null;
						   $revert_on              = null;
						   $filter_data            = $val['param_to_save'];
						   $filter_data_serialized = maybe_serialize($filter_data);
				if ( 'schedule_later' === $val['param_to_save']['scheduled_action'] ) {
				  $schedule_on_date      = $val['param_to_save']['schedule_date'];
				  $schedule_on_time_hour = $val['param_to_save']['scheduled_hour'];
				  $schedule_on_time_min  = $val['param_to_save']['scheduled_min'];
				  $revert_date           = $val['param_to_save']['revert_date'];
				  $revert_time_hour      = $val['param_to_save']['revert_hour'];
				  $revert_time_min       = $val['param_to_save']['revert_min']; 
				  $stop_date             = $val['param_to_save']['stop_schedule_date'];
				  $stop_hr               = $val['param_to_save']['stop_hr'];
				  $stop_min              = $val['param_to_save']['stop_min'];
				  $stop_date             = $val['param_to_save']['stop_schedule_date'];
				  $stop_hr               = $val['param_to_save']['stop_hr'];
				  $stop_min              = $val['param_to_save']['stop_min'];
					if ( $revert_date ) {
						   $revert_on = date_create($revert_date);
						if ( $revert_time_hour && $revert_time_min ) {
						  $revert_on = date_create($revert_date);
						  $revert_on->setTime( $revert_time_hour, $revert_time_min);
						}
						   $revert_on = $revert_on->format('Y-m-d H:i:s');
					}
					if ( $schedule_on_date ) {
						 $schedule_on = date_create($schedule_on_date);
						if ( $schedule_on_time_hour && $schedule_on_time_min ) {
							$schedule_on->setTime( $schedule_on_time_hour, $schedule_on_time_min);
						}
						 $schedule_on = $schedule_on->format('Y-m-d H:i:s');
					}
					if ( $stop_date ) {
						$stop_schedule = date_create($stop_date);
						if ( $stop_hr && $stop_min ) {
							$stop_schedule->setTime( $stop_hr, $stop_min);
						}
						$stop_schedule = $stop_schedule->format('Y-m-d H:i:s');
					}
					  $values = [
					  'job_name'          => $val['job_name'],
					  'filter_data'       => $filter_data_serialized,
					  'created_at'        => wp_date('Y-m-d H:i:s'), 
					  'create_log_file'   => $val['param_to_save']['create_log_file'],
					  'is_reversible'     => $val['param_to_save']['undo_update_op'],
					  'schedule_frequency'=> $val['param_to_save']['schedule_frequency_action'],
					  'stop_schedule'     => $stop_schedule,
					  'schedule_on'       => $schedule_on,
					  'revert_on'         => $revert_on
						 ];

						 $job_id = insert_migration_schedulelater_data_into_database( $values );

						 $job_values = [
						  'job_id'        => $job_id,
						  'batch_no'      => 1,
						  'schedule_date' => $schedule_on,
						  'job_status'    => 0

							];
							insert_job_schedule( $job_values );
				}

				if ('bulk_update_now' === $val['param_to_save']['scheduled_action']) {
				   $edit_data            = $val['edit_data'];
				   $edit_data_serialized = maybe_serialize($edit_data);
				   $values               = [
					   'job_name'          => $val['job_name'],
					   'filter_data'       => $filter_data_serialized,
					   'edit_data'         => $edit_data_serialized,
					   'created_at'        => wp_date('Y-m-d H:i:s'), 
					   'create_log_file'   => $val['param_to_save']['create_log_file'],
					   'is_reversible'     => $val['param_to_save']['undo_update_op']
					   ];
					  $job_id            = insert_migration_bulkeditnow_data_into_database( $values );

					foreach ( $val['revert_data'] as $key => $value) {
						$revert_data_serialized = maybe_serialize($value);
						$revert_data_values     =[
						'job_id'             => $job_id,
						'product_id'         => $value['id'],
						'undo_product_data'  => $revert_data_serialized
						];
						revert_data_into_database( $revert_data_values );
					} 
				}
			}
		}
			
	   }, 2);
//Updating 5 for $option_key_mig key.
	update_option($option_key_mig, 5 );

}
