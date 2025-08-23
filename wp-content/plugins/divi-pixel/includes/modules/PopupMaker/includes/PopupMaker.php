<?php
define( 'DIPI_PM_URL', plugin_dir_url( __FILE__ ));
define( 'DIPI_PM_PATH', plugin_dir_path( __FILE__ ));
define( 'DIPI_PM_SERVER_TIMEZONE', 'UTC');
define( 'DIPI_PM_VERSION', '1.0.0' );

/* Register style and script files */
function dipi_popup_maker_config( $hook ) {
	$screen = get_current_screen();
	if ($screen->post_type !== 'dipi_popup_maker') {
		return;
	}
	wp_register_style(
		'dipi-popup-maker-wp-color-picker',
		plugins_url('dist/vendor/css/cs-wp-color-picker.min.css',
		constant('DIPI_PLUGIN_FILE')), array( 'wp-color-picker' ),
		'1.0.0',
		'all' 
	);
	wp_register_script(
		'dipi-popup-maker-wp-color-picker',
		plugins_url('dist/vendor/js/cs-wp-color-picker.min.js',
		constant('DIPI_PLUGIN_FILE')),
		array( 'wp-color-picker' ),
		'1.0.0',
		true
	);

	wp_register_style(
		'dipi-popup-maker-select2',
		plugins_url('dist/vendor/css/select2.min.css',
		constant('DIPI_PLUGIN_FILE')),
		array(), '4.0.6',
		'all' 
	);
	wp_register_script(
		'dipi-popup-maker-select2',
		plugins_url('dist/vendor/js/select2.full.min.js',
		constant('DIPI_PLUGIN_FILE')),
		array('jquery'),
		'4.0.6',
		true
	);
	wp_register_style(
		'dipi-popup-maker-select2-bootstrap',
		plugins_url('dist/vendor/css/select2-bootstrap.min.css',
		constant('DIPI_PLUGIN_FILE')),
		array(),
		'1.0.0',
		'all'
	);

	wp_register_style(
		'dipi-popup-maker-admin',
		plugins_url('dist/admin/css/popup-maker-admin.min.css',
		constant('DIPI_PLUGIN_FILE')),
		array(),
		DIPI_PM_VERSION,
		'all'
	);
	wp_register_script(
		'dipi-popup-maker-admin-functions',
		plugins_url('dist/admin/js/popup-maker-admin.min.js',
		constant('DIPI_PLUGIN_FILE')),
		array( 'jquery' ),
		DIPI_PM_VERSION,
		true
	);
	wp_register_style(
		'airdatepicker',
		plugins_url('dist/vendor/css/airdatepicker.css',
		constant('DIPI_PLUGIN_FILE')),
		array(),
		DIPI_PM_VERSION
	);
	wp_register_script(
		'airdatepicker',
		plugins_url('dist/vendor/js/airdatepicker.js',
		constant('DIPI_PLUGIN_FILE')),
		array('jquery'),
		DIPI_PM_VERSION
	);
}
add_action('admin_enqueue_scripts', 'dipi_popup_maker_config');

/* Enqueue style and script files */
function dipi_popup_maker_high_priority_includes( $hook ) {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style( 'dipi-popup-maker-wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script( 'dipi-popup-maker-wp-color-picker' );
	wp_enqueue_style('dipi-popup-maker-popup-effect');
	wp_enqueue_style( 'dipi-popup-maker-admin' );
	wp_enqueue_script( 'dipi-popup-maker-admin-functions' );
	wp_enqueue_style('airdatepicker');
	wp_enqueue_script('airdatepicker');

	wp_enqueue_style( 'dipi-popup-maker-select2' );
	wp_enqueue_script( 'dipi-popup-maker-select2' );
	wp_enqueue_style('dipi-popup-maker-admin-bootstrap');
	wp_enqueue_style('dipi-popup-maker-select2-bootstrap');
}
add_action('admin_enqueue_scripts', 'dipi_popup_maker_high_priority_includes', '999');

function dipi_popup_maker_scripts() {
	wp_enqueue_script('jquery');
	wp_register_style(
		'dipi-popup-maker-popup-effect',
		plugins_url('dist/public/css/popup_effect.min.css',
		constant('DIPI_PLUGIN_FILE')),
		array(),
		DIPI_PM_VERSION,
		'all'
	);
	wp_enqueue_style('dipi-popup-maker-popup-effect');
	
	wp_register_script(
		'dipi-popup-maker-modernizr',
		plugins_url('dist/vendor/js/modernizr.custom.js',
		constant('DIPI_PLUGIN_FILE')),
		array('jquery'),
		DIPI_PM_VERSION,
		true
	);
	wp_enqueue_script('dipi-popup-maker-modernizr');
	wp_register_script(
		'dipi-popup-maker-popup-effect',
		plugins_url('dist/public/js/popup_effect.min.js',
		constant('DIPI_PLUGIN_FILE')),
		array('dipi-popup-maker-modernizr', 'jquery'),
		DIPI_PM_VERSION,
		true
	);
	wp_enqueue_script('dipi-popup-maker-popup-effect');
}
add_action('wp_enqueue_scripts', 'dipi_popup_maker_scripts');

require_once DIPI_PM_PATH. 'cpt.php';
function render_library_layout($post_data)
{

		/*$module_slugs = ET_Builder_Element::get_module_slugs_by_post_type();
		$uuid = uniqid();
		// TODO: This array could be cached as it never changes (unlike the replacements which need the uuid)
		$map_to_regex = function ($value) {return '/' . $value . '_(\d+)(_tb_footer|)(,|\.|:| |")/';};
		$regex = array_map($map_to_regex, $module_slugs);

		$map_to_replacements = function ($value) use ($uuid) {return 'dipi_' . $uuid . '_' . $value . '_${1}${2}${3}';};
		$replacements = array_map($map_to_replacements, $module_slugs);*/
		
		$divi_library_shortcode = do_shortcode( $post_data->post_content );
		if (class_exists('ET_Builder_Element') && method_exists('ET_Builder_Element', 'set_style' )) {
			$divi_library_shortcode .= '<style type="text/css">' . ET_Builder_Element::get_style() . '</style>';
			ET_Builder_Element::clean_internal_modules_styles(false);
		}

		return str_replace("#page-container", "#dipi-popup-maker-container", $divi_library_shortcode);
}
function showDipiPopup( $popup_maker_id = NULL ) {
	
	ob_start();
	
	if ( !is_numeric( $popup_maker_id ) )
			return NULL;
	
	$popup_maker_id = (int) $popup_maker_id;
		
	$post_data = get_post( $popup_maker_id );
	
	/* Scheduling */
	$pm_sub_setting_triggering_settings = get_post_meta(
		$post_data->ID, 'pm_sub_setting_triggering_settings', true
	);

	if ( $pm_sub_setting_triggering_settings !== 'trigger_none' ) {
		
		$timezone = wp_timezone_string();
		
		/*$dividipi_popups_settings = get_option( 'dipi_pm_settings' );
		
		if (isset($dividipi_popups_settings['dipi_pm_timezone'])) {
			$timezone = $dividipi_popups_settings['dipi_pm_timezone'];
		}*/
		
		$timezone = new DateTimeZone( $timezone );
		
		$date_now = new DateTime( 'now', $timezone );
		$trigger_autotrigger_activity = get_post_meta(
			$post_data->ID, 'trigger_autotrigger-activity', true
		);

		if ($trigger_autotrigger_activity === 'certain_period') {
			// Start & End Time
			$date_start = get_post_meta(
				$post_data->ID,
				'trigger_auto-activ-certain_period-from',
				true
			);
			$date_end = get_post_meta(
				$post_data->ID,
				'trigger_auto-activ-certain_period-to',
				true
			);

			//$date_start = strtotime ( $date_start );
			$date_start = new DateTime( $date_start, $timezone );
			//$date_end = strtotime ( $date_end );
			
			if ( $date_start >= $date_now ) {
				return;
			}
			
			if ( $date_end != '' ) {
				//$date_end = doConvertDateToUserTimezone( $date_end );
				$date_end = new DateTime( $date_end, $timezone );
				if ( $date_end <= $date_now ) {
					return;
				}
			}
		}
		
		// Recurring Scheduling
		/*if ( $enable_scheduling == 2 ) {
			
			$wNum = $date_now->format( 'N' );
			
			$is_today = get_post_meta(
				$post_data->ID,
				'dividipi_popups_scheduling_daysofweek_' . $wNum
			);
			
			if ( isset( $is_today[0] ) && $is_today[0] == 1 ) {
				
				$is_today = $is_today[0];
				
				$time_start = get_post_meta( $post_data->ID, 'do_time_start', true );
				$time_end = get_post_meta( $post_data->ID, 'do_time_end', true );
				$schedule_start = null;
				$schedule_end = null;
				
				if ( $time_start != '' ) {
					
					$time_start_24 = date( 'H:i', strtotime( $time_start ) );
					$time_start_24 = explode( ':', $time_start_24 );
					$time_start_now = new DateTime( 'now', $timezone );
					$schedule_start = $time_start_now->setTime(
						$time_start_24[0], $time_start_24[1], 0 
					);
				}
				
				if ( $time_end != '' ) {
					
					$time_end_24 = date( 'H:i', strtotime( $time_end ) );
					$time_end_24 = explode( ':', $time_end_24 );
					$time_end_now = new DateTime( 'now', $timezone );
					$schedule_end = $time_end_now->setTime( $time_end_24[0], $time_end_24[1], 0 );
				}
				
				if ( ( $time_start != '' && $time_end != '' && $schedule_start >= $date_now && $schedule_end > $date_now )
					|| ( $time_start != '' && $time_end != '' && $schedule_start <= $date_now && $schedule_end < $date_now )
					|| ( $time_start != '' && $time_end == '' && $schedule_start <= $date_now )
					|| ( $time_start == '' && $time_end != '' && $schedule_end < $date_now )
					) {
					
					return;
				}
			} else {
				
				return;
			}
		}*/
	}
	/* End Scheduling */
	
	
	$dipi_popup_effect = get_post_meta($post_data->ID,'_et_pb_dipi_popup_effect',true);
	
	if ( $dipi_popup_effect == '' ) {
		
		$dipi_popup_effect = 'dipi_popup-hugeinc';
	}
	
	global $wp_embed;
	
	$wp_embed->post_ID = $post_data->ID;
	
	// [embed] shortcode
	$wp_embed->run_shortcode( $post_data->post_content );
	
	// plain links on their own line
	$wp_embed->autoembed( $post_data->post_content );
	
	// Enable shortcodes
	$output = dipi_closing_tags(render_library_layout($post_data));//do_shortcode( $post_data->post_content );
	
	//$output = dipi_pm_formatContent( $output );
	$trigger_closing_css_selector = get_post_meta(
        $post_data->ID, 'trigger-closing_css_selector', true
    );
	if ($trigger_closing_css_selector) {
		print "<style>";
		print sprintf('%1$s {cursor: pointer;}', esc_attr($trigger_closing_css_selector)); 
		print "</style>";
		/*ET_Builder_Element::set_style('dipi_popup', [
			'selector' => $trigger_closing_css_selector,
			'declaration' => "cursor: pointer;",
		]);*/
	}
	$bgcolor = get_post_meta( $post_data->ID, 'post_dipi_popup_bg_color', true );
	$fontcolor = get_post_meta( $post_data->ID, 'post_dipi_popup_font_color', true );
	$popup_anim_name = get_post_meta( $post_data->ID, 'popup_anim_name', true );
	$popup_pos_location_name = get_post_meta( $post_data->ID, 'popup_pos_location_name', true );
	if (empty($popup_pos_location_name)) {
		$popup_pos_location_name = "center_center";
	}
	$popup_pos_location_name = explode("_", $popup_pos_location_name);

	$popup_pos_location_x = $popup_pos_location_name[1];
	$popup_pos_location_y = $popup_pos_location_name[0];
	if ($popup_anim_name !== 'none') {
		wp_enqueue_style('dipi_animate');
	}
	$dipi_popup_enable_blur = get_post_meta(
		$post_data->ID, 'dipi_popup_enable_blur', true
	);
	$remove_link = get_post_meta( $post_data->ID, 'trigger-remove_link', true );
	if (empty($remove_link)) {
		$remove_link = 'true';
	}
	$close_on_bg = get_post_meta( $post_data->ID, 'trigger-close_on_bg', true );
	if (empty($close_on_bg)) {
		$close_on_bg = 'true';
	}
	$hide_popup_slug = get_post_meta( $post_data->ID, 'trigger-hide_popup_slug', true );
	if (empty($hide_popup_slug)) {
		$hide_popup_slug = 'false';
	}
	$close_by_back_btn = get_post_meta( $post_data->ID, 'trigger-close_by_back_btn', true );
	if (empty($close_by_back_btn)) {
		$close_by_back_btn = 'true';
	}
	$preventscroll = get_post_meta( $post_data->ID, 'trigger-prev_page_scrolling' );
	if ( isset( $preventscroll[0] ) ) {
		
		$preventscroll = $preventscroll[0];
		
	} else {
		
		$preventscroll = false;
	}
	$clickable_under_overlay = get_post_meta( $post_data->ID, 'dipi_custom_clickable_under_overlay' );
	if ( isset( $clickable_under_overlay[0] ) && $clickable_under_overlay[0]  === 'true' ) {
		
		$clickable_under_overlay = 1;
		
	} else {
		$clickable_under_overlay = 0;
	}
	$hideclosebtn = get_post_meta( $post_data->ID, 'dipi_custom_hide_close_btn' );
	if ( isset( $hideclosebtn[0] ) && $hideclosebtn[0]  === 'true' ) {
		
		$hideclosebtn = 1;
		
	} else {
				$hideclosebtn = 0;
	}
	
	$closebtnWithinPopupDesktop = get_post_meta( $post_data->ID, 'dipi_custom_show_close_btn_within_popup_desktop', true);
	$closebtnWithinPopupTablet = get_post_meta( $post_data->ID, 'dipi_custom_show_close_btn_within_popup_tablet', true);
	$closebtnWithinPopupPhone = get_post_meta( $post_data->ID, 'dipi_custom_show_close_btn_within_popup_phone', true);

	if ( isset( $closebtnWithinPopupDesktop ) && $closebtnWithinPopupDesktop  === 'on' ) {
		$closebtnWithinPopupDesktop = 1;
	} else {
		$closebtnWithinPopupDesktop = 0;
	}
	if ( isset( $closebtnWithinPopupTablet ) && $closebtnWithinPopupTablet  === 'on' ) {
		$closebtnWithinPopupTablet = 1;
	} else {
		$closebtnWithinPopupTablet = 0;
	}
	if ( !empty( $closebtnWithinPopupPhone ) && $closebtnWithinPopupPhone  === 'false' ) {
		$closebtnWithinPopupPhone = 0;
	} else {
		$closebtnWithinPopupPhone = 1;
	}

	$mobile_detect = new DiviPixel\MobileDetect;
	
	$isMobileDevice = $mobile_detect->isMobile();
	$isTabletDevice = $mobile_detect->isTablet();
	$closebtnWithinPopup = 1;
	if (!$closebtnWithinPopupPhone && $isMobileDevice) {
		$closebtnWithinPopup = 0;
	}
	if ( !$closebtnWithinPopupPhone && $isMobileDevice && $isTabletDevice ) {
				
		$closebtnWithinPopup = 1;
	}
	if ( !$closebtnWithinPopupTablet && $isTabletDevice ) {
				
		$closebtnWithinPopup = 0;
	}
	if ( !$closebtnWithinPopupDesktop && !$isMobileDevice && !$isTabletDevice ) {
				
		$closebtnWithinPopup = 0;
	}
	$data_path_to = null;
	$svg = null;
	if ( $dipi_popup_effect == 'dipi_popup-cornershape' ) {
		
		$data_path_to = 'data-path-to = "m 0,0 1439.999975,0 0,805.99999 -1439.999975,0 z"';
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 1440 806" preserveAspectRatio="none">
				<path class="dipi_popup-path" d="m 0,0 1439.999975,0 0,805.99999 0,-805.99999 z"/>
			</svg>';
	}
	if ( $dipi_popup_effect == 'dipi_popup-boxes' ) {
		
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="101%" viewBox="0 0 1440 806" preserveAspectRatio="none">
				<path d="m0.005959,200.364029l207.551124,0l0,204.342453l-207.551124,0l0,-204.342453z"/>
				<path d="m0.005959,400.45401l207.551124,0l0,204.342499l-207.551124,0l0,-204.342499z"/>
				<path d="m0.005959,600.544067l207.551124,0l0,204.342468l-207.551124,0l0,-204.342468z"/>
				<path d="m205.752151,-0.36l207.551163,0l0,204.342437l-207.551163,0l0,-204.342437z"/>
				<path d="m204.744629,200.364029l207.551147,0l0,204.342453l-207.551147,0l0,-204.342453z"/>
				<path d="m204.744629,400.45401l207.551147,0l0,204.342499l-207.551147,0l0,-204.342499z"/>
				<path d="m204.744629,600.544067l207.551147,0l0,204.342468l-207.551147,0l0,-204.342468z"/>
				<path d="m410.416046,-0.36l207.551117,0l0,204.342437l-207.551117,0l0,-204.342437z"/>
				<path d="m410.416046,200.364029l207.551117,0l0,204.342453l-207.551117,0l0,-204.342453z"/>
				<path d="m410.416046,400.45401l207.551117,0l0,204.342499l-207.551117,0l0,-204.342499z"/>
				<path d="m410.416046,600.544067l207.551117,0l0,204.342468l-207.551117,0l0,-204.342468z"/>
				<path d="m616.087402,-0.36l207.551086,0l0,204.342437l-207.551086,0l0,-204.342437z"/>
				<path d="m616.087402,200.364029l207.551086,0l0,204.342453l-207.551086,0l0,-204.342453z"/>
				<path d="m616.087402,400.45401l207.551086,0l0,204.342499l-207.551086,0l0,-204.342499z"/>
				<path d="m616.087402,600.544067l207.551086,0l0,204.342468l-207.551086,0l0,-204.342468z"/>
				<path d="m821.748718,-0.36l207.550964,0l0,204.342437l-207.550964,0l0,-204.342437z"/>
				<path d="m821.748718,200.364029l207.550964,0l0,204.342453l-207.550964,0l0,-204.342453z"/>
				<path d="m821.748718,400.45401l207.550964,0l0,204.342499l-207.550964,0l0,-204.342499z"/>
				<path d="m821.748718,600.544067l207.550964,0l0,204.342468l-207.550964,0l0,-204.342468z"/>
				<path d="m1027.203979,-0.36l207.550903,0l0,204.342437l-207.550903,0l0,-204.342437z"/>
				<path d="m1027.203979,200.364029l207.550903,0l0,204.342453l-207.550903,0l0,-204.342453z"/>
				<path d="m1027.203979,400.45401l207.550903,0l0,204.342499l-207.550903,0l0,-204.342499z"/>
				<path d="m1027.203979,600.544067l207.550903,0l0,204.342468l-207.550903,0l0,-204.342468z"/>
				<path d="m1232.659302,-0.36l207.551147,0l0,204.342437l-207.551147,0l0,-204.342437z"/>
				<path d="m1232.659302,200.364029l207.551147,0l0,204.342453l-207.551147,0l0,-204.342453z"/>
				<path d="m1232.659302,400.45401l207.551147,0l0,204.342499l-207.551147,0l0,-204.342499z"/>
				<path d="m1232.659302,600.544067l207.551147,0l0,204.342468l-207.551147,0l0,-204.342468z"/>
				<path d="m-0.791443,-0.360001l207.551163,0l0,204.342438l-207.551163,0l0,-204.342438z"/>
			</svg>';
	}
	
	if ( $dipi_popup_effect == 'dipi_popup-genie' ) {
		
		$data_path_to = 'data-steps = "m 701.56545,809.01175 35.16718,0 0,19.68384 -35.16718,0 z;m 698.9986,728.03569 41.23353,0 -3.41953,77.8735 -34.98557,0 z;m 687.08153,513.78234 53.1506,0 C 738.0505,683.9161 737.86917,503.34193 737.27015,806 l -35.90067,0 c -7.82727,-276.34892 -2.06916,-72.79261 -14.28795,-292.21766 z;m 403.87105,257.94772 566.31246,2.93091 C 923.38284,513.78233 738.73561,372.23931 737.27015,806 l -35.90067,0 C 701.32034,404.49318 455.17312,480.07689 403.87105,257.94772 z;M 51.871052,165.94772 1362.1835,168.87863 C 1171.3828,653.78233 738.73561,372.23931 737.27015,806 l -35.90067,0 C 701.32034,404.49318 31.173122,513.78234 51.871052,165.94772 z;m 52,26 1364,4 c -12.8007,666.9037 -273.2644,483.78234 -322.7299,776 l -633.90062,0 C 359.32034,432.49318 -6.6979288,733.83462 52,26 z;m 0,0 1439.999975,0 0,805.99999 -1439.999975,0 z"';
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 1440 806" preserveAspectRatio="none">
				<path class="dipi_popup-path" d="m 701.56545,809.01175 35.16718,0 0,19.68384 -35.16718,0 z"/>
			</svg>';
	}
	
	$customizeclosebtn = get_post_meta($post_data->ID, 'post_dipi_customizeclosebtn');
	if( !isset( $customizeclosebtn[0] ) ) {
		$customizeclosebtn[0] = '0';
	}
	$at_type = get_post_meta($post_data->ID,
		'pm_sub_setting_triggering_settings', true 
	);
	$at_periodicity = get_post_meta(
		$post_data->ID, 'trigger_autotrigger-periodicity', true
	);
	$at_period_hours = get_post_meta(
		$post_data->ID, 'trigger_autotrigger-periodicity-hours', true
	);

	if ($at_periodicity === 'once_only') {
		$at_period_hours = 24*365;		
	} else if (!isset( $at_period_hours)) {
		$at_period_hours = 24;
	}
?>
	<div
		id="dipi-popup-container-<?php echo esc_attr($popup_maker_id);?>"
		class="dipi-popup-container"
	>
		<div
			id="dipi_popup-<?php echo esc_attr($post_data->ID);?>"
			class="dipi_popup
				<?php echo esc_attr($dipi_popup_effect);?>
				<?php echo $closebtnWithinPopup ? "closebtn-within-popup" : ""; ?>
				<?php echo $hideclosebtn ? "hide-closebtn" : ""; ?>
				<?php echo $clickable_under_overlay ? "clickable-under-overlay" : ""; ?>
				
			"
			<?php echo esc_attr($data_path_to);?> 
			data-anim="<?php echo esc_attr($popup_anim_name); ?>"
			data-removelink="<?php echo esc_attr($remove_link); ?>"
			data-close-selector = "<?php echo esc_attr($trigger_closing_css_selector); ?>"
			data-close_on_bg="<?php echo esc_attr($close_on_bg); ?>"
			data-close_by_back_btn="<?php echo esc_attr($close_by_back_btn); ?>"
			data-hide_popup_slug="<?php echo esc_attr($hide_popup_slug); ?>"
			data-bgcolor="<?php echo esc_attr($bgcolor);?>"
			data-fontcolor="<?php echo esc_attr($fontcolor);?>"
			data-preventscroll="<?php print esc_attr($preventscroll) ?>" 
			data-scrolltop=""
			data-at_type="<?php print esc_attr($at_type)?>"
			data-periodicity="<?php print esc_attr($at_periodicity)?>"
			data-cookie="<?php print esc_attr($at_period_hours) ?>"
			data-blur="<?php echo esc_attr($dipi_popup_enable_blur); ?>"
		>
			<?php echo esc_html($svg); ?>

			
			<div 
				class="dipi-popup-inner animated" 
				style="align-items:<?php print esc_attr($popup_pos_location_y); ?>;
					justify-content:<?php print esc_attr($popup_pos_location_x);?>;"
			>
				<!-- Need style code for dipi-popup-wrapper to make 'Popup Position setting' working with 'Popup Width' setting -->	
				<div class="dipi-popup-wrapper"
					style="
						display: flex;
						align-items:<?php print esc_attr($popup_pos_location_y); ?>;
						justify-content:<?php print esc_attr($popup_pos_location_x);?>;"
				>
					<?php if ( $hideclosebtn === 0 ) { ?>
						<button
							type="button"
							class="dipi_popup-close dipi_popup-customclose-btn-<?php echo esc_attr($popup_maker_id) ?>"
						>
							<span class="<?php if ( $customizeclosebtn[0] == 1 ) { ?>custom_btn<?php } ?>">
								&times;
							</span>
						</button>
					<?php } ?>
					<?php 
						// is divi theme builder ?
						if (
							'on' === get_post_meta( $post_data->ID, '_et_pb_use_builder', true ) 
						) {
							echo $output; // phpcs:ignore
						} else {
					?>
						<div class="et_pb_section et_section_regular dipi_popup_section">
							<div class="et_pb_row dipi_popup_row">
								<div class="et_pb_column  dipi_popup_column">
									<?php echo  $output; // phpcs:ignore?>
								</div>
							</div>
						</div>
						<?php
						}
					?>
				</div>
			</div>
		</div>
	</div>
<?php
	return ob_get_clean();
}

function dipi_pm_formatContent( $pee, $br = true ) {
	
	$pre_tags = array();

	if ( trim($pee) === '' )
		return '';

	/*
	 * Pre tags shouldn't be touched by autop.
	 * Replace pre tags with placeholders and bring them back after autop.
	 */
	if ( strpos($pee, '<pre') !== false ) {
		$pee_parts = explode( '</pre>', $pee );
		$last_pee = array_pop($pee_parts);
		$pee = '';
		$i = 0;

		foreach ( $pee_parts as $pee_part ) {
			$start = strpos($pee_part, '<pre');

			// Malformed html?
			if ( $start === false ) {
				$pee .= $pee_part;
				continue;
			}

			$name = "<pre wp-pre-tag-$i></pre>";
			$pre_tags[$name] = substr( $pee_part, $start ) . '</pre>';

			$pee .= substr( $pee_part, 0, $start ) . $name;
			$i++;
		}

		$pee .= $last_pee;
	}
	// Change multiple <br>s into two line breaks, which will turn into paragraphs.
	$pee = preg_replace('|<br\s*/?>\s*<br\s*/?>|', "\n\n", $pee);
	
	$pee = str_replace(array("\r\n\r\n", "\r\r"), '<br /><br />', $pee);

	$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary)';

	// Add a double line break above block-level opening tags.
	$pee = preg_replace('!(<' . $allblocks . '[\s/>])!', "\n\n$1", $pee);

	// Add a double line break below block-level closing tags.
	$pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);

	// Standardize newline characters to "\n".
	$pee = str_replace(array("\r\n", "\r"), "\n", $pee);

	// Find newlines in all elements and add placeholders.
	$pee = wp_replace_in_html_tags( $pee, array( "\n" => " <!-- wpnl --> " ) );

	// Collapse line breaks before and after <option> elements so they don't get autop'd.
	if ( strpos( $pee, '<option' ) !== false ) {
		$pee = preg_replace( '|\s*<option|', '<option', $pee );
		$pee = preg_replace( '|</option>\s*|', '</option>', $pee );
	}

	/*
	 * Collapse line breaks inside <object> elements, before <param> and <embed> elements
	 * so they don't get autop'd.
	 */
	if ( strpos( $pee, '</object>' ) !== false ) {
		$pee = preg_replace( '|(<object[^>]*>)\s*|', '$1', $pee );
		$pee = preg_replace( '|\s*</object>|', '</object>', $pee );
		$pee = preg_replace( '%\s*(</?(?:param|embed)[^>]*>)\s*%', '$1', $pee );
	}

	/*
	 * Collapse line breaks inside <audio> and <video> elements,
	 * before and after <source> and <track> elements.
	 */
	if ( strpos( $pee, '<source' ) !== false || strpos( $pee, '<track' ) !== false ) {
		$pee = preg_replace( '%([<\[](?:audio|video)[^>\]]*[>\]])\s*%', '$1', $pee );
		$pee = preg_replace( '%\s*([<\[]/(?:audio|video)[>\]])%', '$1', $pee );
		$pee = preg_replace( '%\s*(<(?:source|track)[^>]*>)\s*%', '$1', $pee );
	}

	// Collapse line breaks before and after <figcaption> elements.
	if ( strpos( $pee, '<figcaption' ) !== false ) {
		$pee = preg_replace( '|\s*(<figcaption[^>]*>)|', '$1', $pee );
		$pee = preg_replace( '|</figcaption>\s*|', '</figcaption>', $pee );
	}

	// Remove more than two contiguous line breaks.
	$pee = preg_replace("/\n\n+/", "\n\n", $pee);

	// Split up the contents into an array of strings, separated by double line breaks.
	$pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);

	// Reset $pee prior to rebuilding.
	$pee = '';

	// Rebuild the content as a string, wrapping every bit with a <p>.
	foreach ( $pees as $tinkle ) {
		$pee .= trim($tinkle, "\n") . "\n";
	}

	// Under certain strange conditions it could create a P of entirely whitespace.
	$pee = preg_replace('|<p>\s*</p>|', '', $pee);

	// Add a closing <p> inside <div>, <address>, or <form> tag if missing.
	$pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);

	// If an opening or closing block element tag is wrapped in a <p>, unwrap it.
	$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);

	// In some cases <li> may get wrapped in <p>, fix them.
	$pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee);

	// If a <blockquote> is wrapped with a <p>, move it inside the <blockquote>.
	$pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
	$pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);

	// If an opening or closing block element tag is preceded by an opening <p> tag, remove it.
	$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);

	// If an opening or closing block element tag is followed by a closing <p> tag, remove it.
	$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);

	// Optionally insert line breaks.
	if ( $br ) {
		// Replace newlines that shouldn't be touched with a placeholder.
		$pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', '_autop_newline_preservation_helper', $pee);

		// Normalize <br>
		$pee = str_replace( array( '<br>', '<br/>' ), '<br />', $pee );
		
		// Replace any new line characters that aren't preceded by a <br /> with a <br />.
		$pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee);

		// Replace newline placeholders with newlines.
		$pee = str_replace('<WPPreserveNewline />', "\n", $pee);
	}
	
	// If a <br /> tag is after an opening or closing block tag, remove it.
	$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
	
	// If 2 <br /><br /> tags are after an opening or closing block tag, remove them.
	$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br /><br />!', "$1", $pee);

	// If a <br /> tag is before a subset of opening or closing block tags, remove it.
	$pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol|span|input|label|fieldset|legend|optgroup|option|select|form|textarea|button|datalist|keygen|output)[^>]*>)!', '$1', $pee);
	
	// If 2 <br /><br /> tags are before a subset of opening or closing block tags, remove them.
	$pee = preg_replace('!<br /><br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol|span|input|label|fieldset|legend|optgroup|option|select|form|textarea|button|datalist|keygen|output)[^>]*>)!', '$1', $pee);
	
	$pee = preg_replace( "|\n</p>$|", '</p>', $pee );

	// Replace placeholder <pre> tags with their original content.
	if ( !empty($pre_tags) )
		$pee = str_replace(array_keys($pre_tags), array_values($pre_tags), $pee);

	// Restore newlines in all elements.
	if ( false !== strpos( $pee, '<!-- wpnl -->' ) ) {
		$pee = str_replace( array( ' <!-- wpnl --> ', '<!-- wpnl -->' ), "\n", $pee );
	}

	return $pee;
}

add_action('wp_footer','dipi_pm_js_function');
function dipi_pm_js_function() {
	// Hide Popup in Builder
	if (function_exists('et_builder_is_frontend') && !et_builder_is_frontend()) {
		return;
	}
	print '<div id="dipi-popup-maker-container">';
	
	/* Search Dipi Popup Maker in current post */
	global $post;
	$post_content = $post ? $post->post_content : '';
	$matches = array();
	$pattern = '/id="(.*?dipi_popup_[0-9]+)"/';
	preg_match_all($pattern, $post_content, $matches);
	
	$dipi_popup_ = $matches[1];
	
	$matches = array();
	$pattern = '/id="(.*?dipi_popup_id_[0-9]+)"/';
	preg_match_all($pattern, $post_content, $matches);
	
	$dipi_popup_id_ = $matches[1];
	
	$matches = array();
	$pattern = '/class="(.*?dipi_popup\-[0-9]+)"/';
	preg_match_all($pattern, $post_content, $matches);
	
	$dipi_popups_class_dipi_popup = $matches[1];
	
	$dipi_popups_in_post = $dipi_popup_ + $dipi_popup_id_ + $dipi_popups_class_dipi_popup;
	
	$dipi_popups_in_post = array_filter( array_map( "dipi_pm_extract_id", $dipi_popups_in_post ) );

	if ( is_array( $dipi_popups_in_post ) && count( $dipi_popups_in_post ) > 0 ) {
		
		$dipi_popups_in_post = array_flip( $dipi_popups_in_post );
		
	}
	
	
	/* Search CSS Triggers in all Dipi Popup Makers */
	global $wp_query;
	
	$args = array(
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key'   => 'trigger_manual-custom_css_selector',
				'value' => '',
				'compare' => '!=',
			),
			array(
				'relation' => 'OR',
				array(
					'key'   => 'dipi_popup-active',
					'compare' => 'NOT EXISTS',
				),
				array(
					'key'   => 'dipi_popup-active',
					'value' => 'true',
					'compare' => '=',
				)
			)
		),
		'post_type' => 'dipi_popup_maker',
		'posts_per_page' => -1,
		'cache_results'  => false
	);
	$query = new WP_Query( $args );
	
	$posts = $query->get_posts();
	
	$dipi_popups_with_css_trigger = array();
	
	if ( isset( $posts[0] ) ) {
		
		print '<script type="text/javascript">var dipi_popups_with_css_trigger = {';
		
		foreach( $posts as $dv_post ) {
			
			$post_id = $dv_post->ID;
			
			$get_css_selector = get_post_meta( $post_id, 'trigger_manual-custom_css_selector' );
				
			$css_selector = $get_css_selector[0];
			
			if ( $css_selector != '' ) {
				
				print '\'' . $post_id . '\': \'' . $css_selector . '\','; // phpcs:ignore
				
				$dipi_popups_with_css_trigger[ $post_id ] = $css_selector;
				
				/*ET_Builder_Element::set_style('dipi_popup', [
					'selector' => $trigger_manual_cssid,
					'declaration' => "cursor: pointer;",
				]);
				ET_Builder_Element::set_style('dipi_popup', [
					'selector' => $css_selector,
					'declaration' => "cursor: pointer;",
				]);*/
			}
		}
		
		print '};</script>';
		print '<style type="text/css">';
		
			foreach( $posts as $dv_post ) {
				
				$post_id = $dv_post->ID;
				
				$trigger_manual_cssid = "#dipi_popup_id_".$post_id;
				print sprintf('%1$s { cursor: pointer; }', esc_attr($trigger_manual_cssid));

				$get_css_selector = get_post_meta( $post_id, 'trigger_manual-custom_css_selector' );
				$css_selector = $get_css_selector[0];
				
				if ( $css_selector != '' ) {
					print sprintf('%1$s { cursor: pointer; }', esc_attr($css_selector));
				}
			}
			
			print '</style>';
	}
	
	
	/* Search URL Triggers in all Dipi Popup Makers */
	$args = array(
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key'   => 'post_enableurltrigger',
				'value' => '1',
				'compare' => '=',
			),
			array(
				'relation' => 'OR',
				array(
					'key'   => 'dipi_popup-active',
					'compare' => 'NOT EXISTS',
				),
				array(
					'key'   => 'dipi_popup-active',
					'value' => 'true',
					'compare' => '=',
				)
			)
		),
		'post_type' => 'dipi_popup_maker',
		'posts_per_page' => -1,
		'cache_results'  => false
	);
	$query = new WP_Query( $args );
	
	$posts = $query->get_posts();
	
	$dipi_popups_with_url_trigger = array();
	
	if ( isset( $posts[0] ) ) {
		
		$display_in_current = false;
		
		foreach( $posts as $dv_post ) {
			
			$post_id = $dv_post->ID;
			
			$dipi_popups_with_url_trigger[ $post_id ] = 1;
		}
	}
	$dipi_popups_with_url_trigger = array_filter( $dipi_popups_with_url_trigger );
	
	
	/* Search Automatic Triggers in all Dipi Popup Makers */
	
	// Server-Side Device Detection with Browscap
    if (!class_exists('DiviPixel\MobileDetect')) {
	    require_once  DIPI_PM_PATH.'library/Mobile_Detect.php';
    }
	$mobile_detect = new DiviPixel\MobileDetect;
	
	$isMobileDevice = $mobile_detect->isMobile();
	$isTabletDevice = $mobile_detect->isTablet();
	
	$dipi_popups_with_automatic_trigger = array();
	
	$args = array(
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key'   => 'pm_sub_setting_triggering_settings',
				'value' => 'trigger_manual',
				'compare' => '!=',
			),
			array(
				'relation' => 'OR',
				array(
					'key'   => 'dipi_popup-active',
					'compare' => 'NOT EXISTS',
				),
				array(
					'key'   => 'dipi_popup-active',
					'value' => 'true',
					'compare' => '=',
				)
			)
		),
		'post_type' => 'dipi_popup_maker',
		'posts_per_page' => -1,
		'cache_results'  => false
	);
	$query = new WP_Query( $args );
	
	$posts = $query->get_posts();
	
	if ( isset( $posts[0] ) ) {
		
		print '<script type="text/javascript">var dipi_popups_with_automatic_trigger = {';

		foreach( $posts as $dv_post ) {
			
			$post_id = $dv_post->ID;
			
			$at_disablemobile = get_post_meta( $post_id, 'trigger-auto-resp_disable_phone' );
			$at_disabletablet = get_post_meta( $post_id, 'trigger-auto-resp_disable_tablet' );
			$at_disabledesktop = get_post_meta( $post_id, 'trigger-auto-resp_disable_desktop' );
			$at_periodicity = get_post_meta( $post_id, 'trigger_autotrigger-periodicity', true );
			$at_period_hours = get_post_meta( $post_id, 'trigger_autotrigger-periodicity-hours', true );
			$at_certain_period_from = get_post_meta( $post_id, 'trigger_auto-activ-certain_period-from', true );
			$at_certain_period_to = get_post_meta( $post_id, 'trigger_auto-activ-certain_period-to', true );
			$at_inactivity_delay = get_post_meta( $post_id, 'trigger_on_inactivity-delay', true );

			if ( !isset( $at_periodicity ) ) {
				$at_periodicity = 'every_time';
			}
			
			if ( isset( $at_disablemobile[0] ) ) {
				
				$at_disablemobile = $at_disablemobile[0];
				
			} else {
				
				$at_disablemobile = 0;
			}
			
			if ( isset( $at_disabletablet[0] ) ) {
				
				$at_disabletablet = $at_disabletablet[0];
				
			} else {
				
				$at_disabletablet = 0;
			}
			
			if ( isset( $at_disabledesktop[0] ) ) {
				
				$at_disabledesktop = $at_disabledesktop[0];
				
			} else {
				
				$at_disabledesktop = 0;
			}
			
			$printSettings = 1;
			if ( $at_disablemobile && $isMobileDevice ) {
				
				$printSettings = 0;
			}
			
			if ( $at_disablemobile && $isMobileDevice && $isTabletDevice ) {
				
				$printSettings = 1;
			}
			
			if ( $at_disabletablet && $isTabletDevice ) {
				
				$printSettings = 0;
			}
			
			if ( $at_disabledesktop && !$isMobileDevice && !$isTabletDevice ) {
				
				$printSettings = 0;
			}

			if ( $printSettings ) {
				
				$at_type = get_post_meta( $post_id, 'pm_sub_setting_triggering_settings', true );
				$at_delay_start = get_post_meta( $post_id, 'trigger_on_load-delay-start', true );
				$at_delay_end = get_post_meta( $post_id, 'trigger_on_load-delay-end', true );
				$at_scroll_offset = get_post_meta( $post_id, 'trigger_on_scroll-offset', true );
				$at_scroll_offset_units = get_post_meta( $post_id, 'trigger_autotrigger-offset_units', true );
				$at_inactivity_delay = get_post_meta( $post_id, 'trigger_on_inactivity-delay', true );
				if ( $at_type != '' ) {
					
					switch ( $at_type ) {
						//case 'trigger_manual':
						//	break;
						case 'trigger_on_load':
							$at_value = $at_delay_start . ':' . $at_delay_end;
						break;
						case 'trigger_on_scroll':
							$at_value = $at_scroll_offset . ':' .$at_scroll_offset_units;
						break;
						//case 'trigger_on_exit':
						//break;
						case 'trigger_on_inactivity':
							$at_value = $at_inactivity_delay ;
						break;
						default:
							$at_value = $at_type;
					}
					
					$at_settings = json_encode( array( 
						'at_type' => $at_type, 
						'at_value' => $at_value, 
						'at_periodicity' => $at_periodicity, 
						'at_periodicity_hours' => $at_period_hours,
						'at_certain_period_from' => $at_certain_period_from,
						'at_certain_period_to' => $at_certain_period_to,
						'at_inactivity_delay' => $at_inactivity_delay
					) );
					
					print '\'' . $post_id . '\': \'' . $at_settings . '\','; // phpcs:ignore
					
					$dipi_popups_with_automatic_trigger[ $post_id ] = $at_type;
				}
			}
		}
		
		print '};</script>';
	}
	$dipi_popups_with_automatic_trigger = array_filter( $dipi_popups_with_automatic_trigger );
	
	
	/* Search Dipi Popup Makers with Custom Close Buttons */
	$args = array(
		'meta_query' => array(
			'relation' => 'OR',
			array(
				'key'   => 'dipi_popup-active',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'   => 'dipi_popup-active',
				'value' => 'true',
				'compare' => '=',
			)
		),
		'post_type' => 'dipi_popup_maker',
		'posts_per_page' => -1,
		'cache_results'  => false
	);
	$query = new WP_Query( $args );
	
	$posts = $query->get_posts();
	
	if ( isset( $posts[0] ) ) {
		
		print '<style type="text/css">';
		
		foreach( $posts as $dv_post ) {
			
			$post_id = $dv_post->ID;
			$dipi_custom_overlay_z_index = get_post_meta( $post_id, 'dipi_custom_overlay_z_index', true );
			$closebtnWithinPopupDesktop = get_post_meta( $post_id, 'dipi_custom_show_close_btn_within_popup_desktop', true);
			$closebtnWithinPopupTablet = get_post_meta( $post_id, 'dipi_custom_show_close_btn_within_popup_tablet', true);
			$closebtnWithinPopupPhone = get_post_meta( $post_id, 'dipi_custom_show_close_btn_within_popup_phone', true);
			
				
			$dipi_custom_desktop_popup_width = get_post_meta(
				$post_id, 'dipi_custom_desktop_popup_width', true
			);
			if (empty($dipi_custom_desktop_popup_width)) {
				if ( !(isset( $closebtnWithinPopupDesktop ) && $closebtnWithinPopupDesktop  === 'on') ) {
					$dipi_custom_desktop_popup_width = '90';
				}
			}
			$dipi_custom_desktop_popup_unit = get_post_meta(
				$post_id, 'dipi_custom_desktop_popup_unit', true 
			);
			if (empty($dipi_custom_desktop_popup_unit)) {
				$dipi_custom_desktop_popup_unit = '%';
			}
		
			$dipi_custom_tablet_popup_width = get_post_meta(
				$post_id, 'dipi_custom_tablet_popup_width', true
			);
			if (empty($dipi_custom_tablet_popup_width)) {
				if ( !(isset( $closebtnWithinPopupTablet ) && $closebtnWithinPopupTablet  === 'on') ) {
					$dipi_custom_tablet_popup_width = '90';
				}
			}
			$dipi_custom_tablet_popup_unit = get_post_meta(
				$post_id, 'dipi_custom_tablet_popup_unit', true 
			);
			if (empty($dipi_custom_tablet_popup_unit)) {
				$dipi_custom_tablet_popup_unit = '%';
			}
			
			$dipi_custom_mobile_popup_width = get_post_meta(
				$post_id, 'dipi_custom_mobile_popup_width', true
			);
			if (empty($dipi_custom_mobile_popup_width)) {
				if ( !empty( $closebtnWithinPopupPhone ) && $closebtnWithinPopupPhone  === 'false' ) {
					$dipi_custom_mobile_popup_width = '80';
				}
			}
			$dipi_custom_mobile_popup_unit = get_post_meta(
				$post_id, 'dipi_custom_mobile_popup_unit', true 
			);
			if (empty($dipi_custom_mobile_popup_unit)) {
				$dipi_custom_mobile_popup_unit = '%';
			}
			$dipi_custom_min_popup_width = get_post_meta(
				$post_id, 'dipi_custom_min_popup_width', true
			);
			if (empty($dipi_custom_min_popup_width)) {
				$dipi_custom_min_popup_width = '300';
			}
			$dipi_custom_min_popup_unit = get_post_meta(
				$post_id, 'dipi_custom_min_popup_unit', true 
			);
			if (empty($dipi_custom_min_popup_unit)) {
				$dipi_custom_min_popup_unit = 'px';
			}
			/*if (!isset($dipi_custom_overlay_z_index)) {
				$dipi_custom_overlay_z_index = "9999999";
			}*/
			if (isset($dipi_custom_overlay_z_index) && !empty($dipi_custom_overlay_z_index)) {
				print sprintf('#dipi_popup-%1$s.dipi_popup.open {z-index: %2$s;}', esc_attr($post_id), esc_attr($dipi_custom_overlay_z_index));
				print sprintf('#dipi_popup-%1$s .dipi_popup-customclose-btn-%1$s.dipi_popup-close {z-index: %2$s0;}', esc_attr($post_id), esc_attr($dipi_custom_overlay_z_index));
			}
			$close_btn_icon_color = get_post_meta( $post_id, 'close_btn_icon_color', true );
			$close_btn_bg_color = get_post_meta( $post_id, 'close_btn_bg_color', true );
			$dipi_custom_close_btn_icon_size = get_post_meta( $post_id, 'dipi_custom_close_btn_icon_size', true );
			$dipi_custom_close_btn_border_radius = get_post_meta( $post_id, 'dipi_custom_close_btn_border_radius', true );
			$dipi_custom_close_btn_padding = get_post_meta( $post_id, 'dipi_custom_close_btn_padding', true );
			$dipi_custom_close_btn_margin = get_post_meta( $post_id, 'dipi_custom_close_btn_margin', true );
			print '
			.dipi_popup-customclose-btn-' . esc_attr($post_id) . ' {
				color:' . esc_attr($close_btn_icon_color) . ' !important;
				background-color:' . esc_attr($close_btn_bg_color) . ' !important;
				font-size:' . esc_attr($dipi_custom_close_btn_icon_size) . 'px !important;
				padding:' . esc_attr($dipi_custom_close_btn_padding) . 'px !important;
				margin:' . esc_attr($dipi_custom_close_btn_margin) . 'px !important;
				-moz-border-radius:' . esc_attr($dipi_custom_close_btn_border_radius) . '% !important;
				-webkit-border-radius:' . esc_attr($dipi_custom_close_btn_border_radius) . '% !important;
				-khtml-border-radius:' . esc_attr($dipi_custom_close_btn_border_radius) . '% !important;
				border-radius:' . esc_attr($dipi_custom_close_btn_border_radius) . '% !important;
			}
			@media (min-width: 981px) {
				.dipi-popup-container#dipi-popup-container-'.esc_attr($post_id).' .dipi_popup .dipi-popup-wrapper {
					width: '.esc_attr($dipi_custom_desktop_popup_width).esc_attr($dipi_custom_desktop_popup_unit === 'none' ? '' : $dipi_custom_desktop_popup_unit).';
				}
			}
			@media(max-width: 767px) {
				.dipi-popup-container#dipi-popup-container-'.esc_attr($post_id).' .dipi_popup .dipi-popup-wrapper {
					width: '.esc_attr($dipi_custom_mobile_popup_width).esc_attr($dipi_custom_mobile_popup_unit === 'none' ? '' : $dipi_custom_mobile_popup_unit).';
				}    
			}
			@media (min-width: 768px) and (max-width: 980px) {
				.dipi-popup-container#dipi-popup-container-'.esc_attr($post_id).'  .dipi_popup .dipi-popup-wrapper {
					width: '.esc_attr($dipi_custom_tablet_popup_width).esc_attr($dipi_custom_tablet_popup_unit === 'none' ? '' : $dipi_custom_tablet_popup_unit).';
				}    
			}
			
			.dipi-popup-container#dipi-popup-container-'.esc_attr($post_id).' .dipi_popup .dipi-popup-wrapper {
				min-width: '.esc_attr($dipi_custom_min_popup_width).esc_attr($dipi_custom_min_popup_unit === 'none' ? '' : $dipi_custom_min_popup_unit).';
			}
			';
			
		}
		
		print '</style>';
	}
	
	
	/* Ignore repeated ids and print dipi_popups, Popup Locations */
	$dipi_popups = $dipi_popups_in_post +  $dipi_popups_with_css_trigger + $dipi_popups_with_url_trigger + $dipi_popups_with_automatic_trigger;
	/* In preview mode, only preview popup will be shown */
	if (isset($_GET['dipi_popup_nonce']) && wp_verify_nonce( sanitize_key($_GET['dipi_popup_nonce']), 'dipi_popup_nonce' ) && isset($_GET["dipi_popup_preview"]) && isset($_GET["dipi_popup_id"]) ) {
		$dipi_popups = [
			$_GET["dipi_popup_id"]=>"trigger_none"
		];
	}
	if ( is_array( $dipi_popups ) && count( $dipi_popups ) > 0 ) {
		
		global $post;
		
		$display_in_current = false;
		
		$current_post_id = (int) get_option( 'page_on_front' );
		
		$is_home = is_home();
		
		if ( !$is_home ) {
			
			$current_post_id = get_the_ID();
		}
		foreach( $dipi_popups as $dipi_popup_id => $idx ) {
			if (isset($_GET["dipi_popup_preview"])) {
				print showDipiPopup( $dipi_popup_id ); // phpcs:ignore
			} else if ( get_post_status ( $dipi_popup_id ) == 'publish' ) {
			
				/* User roles */
				$current_user_role = 'guest';
				$display_in_current = false;

				if (is_user_logged_in()) {
					$current_user = wp_get_current_user();
					$current_user_role = $current_user->roles[0];
				}
				$locations_user_roles_all = get_post_meta( $dipi_popup_id, "locations_user_roles-all", true );
				if ($locations_user_roles_all === 'on') {
					$display_in_current = true;
				} else if (get_post_meta( $dipi_popup_id, "locations_user_roles_$current_user_role", true ) === 'on') {
					$display_in_current = true;
				}

				/* Site area */
				if ($display_in_current) {
					$current_post_type = get_post_type();
					$pm_sub_setting_name = "pm_sub_set_loc_sitearea_settings";
					$pm_sub_setting_name_selected = get_post_meta( $dipi_popup_id, $pm_sub_setting_name, true );
					if ($pm_sub_setting_name_selected === 'sitewide') {
						$display_in_current = true;
					} else if ($pm_sub_setting_name_selected  === $current_post_type) {
						$display_in_current = true;
						/* Categories & Tags */
						$taxonomies = get_object_taxonomies($current_post_type, 'object');
						foreach ($taxonomies as $key => $taxonomy) {
							if (!$taxonomy->public) continue;
							if ($key == 'post_format') continue;
							$all_term_name = "locations_site_area-all-$current_post_type-$key";
							$all_term_value = get_post_meta( $dipi_popup_id, $all_term_name, true);
							$term_selected = false;
							$terms = get_terms($key, array('hide_empty' => false));
							foreach ($terms as $term) {
								$term_name =  "locations_site_area-$current_post_type-$key-$term->slug";
								if ( get_post_meta( $dipi_popup_id, $term_name , true ) === "on") {
									$term_selected = true;
									break;
								}
							}
							if (empty($all_term_value) && !$term_selected) {
								$all_term_value = 'on';
							}
							if ($all_term_value === "on") continue;
							$taxonomy_matched = false;
							$cur_terms = get_the_terms( $post,  $key);
							if ($cur_terms ) {
								foreach ($cur_terms as $term) {
									$term_name =  "locations_site_area-$current_post_type-$key-$term->slug";
									$term_value = get_post_meta( $dipi_popup_id, $term_name, true);
									if ($term_value === 'on') {
										$taxonomy_matched = true;
										break;
									}
								}
								if ($taxonomy_matched === false) {
									$display_in_current = false;
									break;
								}
							} else {
								$display_in_current = false;
							}
						}
					} else {
						$display_in_current = false;
					}
				}
				/* Posts */
				if ($display_in_current) {
					$at_pages = get_post_meta( $dipi_popup_id, 'dipi_at_pages' );
					$display_in_posts = ( !isset( $at_pages[0] ) ) ? 'all' : $at_pages[0];
					if ( $display_in_posts == 'specific' ) {
						
						$display_in_current = false;
						
						$in_posts = get_post_meta( $dipi_popup_id, 'dipi_at_pages_selected' );
						if ( isset ( $in_posts[0] ) && is_array($in_posts[0]) ) {
							foreach( $in_posts[0] as $in_post => $the_id ) {
								
								if ( $the_id == $current_post_id ) {
									
									$display_in_current = true;
									
									break;
								}
							}
						}
					}
					
					if ( $display_in_posts == 'all' ) {
						
						$display_in_current = true;
						
						$except_in_posts = get_post_meta( $dipi_popup_id, 'dipi_at_exception_selected' );
						
						if ( isset ( $except_in_posts[0] ) && is_array($except_in_posts[0])) {
							
							foreach( $except_in_posts[0] as $in_post => $the_id ) {
								
								if ( $the_id == $current_post_id ) {
									
									$display_in_current = false;
									
									break;
								}
							}
						}
					}

				}
				if ( $display_in_current ) {
					print showDipiPopup( $dipi_popup_id ); // phpcs:ignore
				}
			}
		}
	}
	
	print '</div>';
	
	?>
	<script type="text/javascript">
    var ajaxurl = "<?php echo esc_url(admin_url('admin-ajax.php')); ?>";
																					 
    </script>
	<?php
 
 	wp_register_script('exit-intent', plugins_url('dist/vendor/js/jquery.exitintent.min.js', constant('DIPI_PLUGIN_FILE')), array('jquery'), DIPI_PM_VERSION);
	wp_enqueue_script('exit-intent');
	// wp_register_script('divi-custom-js', plugins_url('dipi_popup-effects/js/custom.js', __FILE__), array("jquery"), '', true);
	// wp_register_script('divi-custom-js', plugins_url('dist/public/js/popup_effect.min.js', constant('DIPI_PLUGIN_FILE')), array("jquery"), '', true);
    // wp_enqueue_script('divi-custom-js');
	
}

function dipi_pm_extract_id( $key = NULL )
{
  if ( !$key ) {
        return NULL;
	}
	
	// it is an url with hash dipi_popup?
	if ( strpos( $key, "#" ) !== false ) {
		
		$exploded_url = explode( "#", $key );
		
		if ( isset( $exploded_url[1] ) ) {
			
			$key = str_replace( 'dipi_popup-', '', $exploded_url[1] );
		}
	}
	
	$key = str_replace( 'dipi_popup_', '', $key );
	$key = str_replace( 'popup_maker_', '', $key );
	$key = str_replace( 'unique_id_', '', $key );
	$key = str_replace( 'dipi_popup-', '', $key );
	
    if ( $key == '' ) {
        return NULL;
	}
	
	if ( !dipi_pm_is_published( $key ) ) {
		
		return NULL;
	}
	
	return $key;
}

function dipi_pm_is_published( $key ) {
	
	$post = get_post_status( $key );
	
	if ( $post != 'publish' ) {
		
		return FALSE;
	}
	
	return TRUE;
}


function dipi_pm_OnceMigrateCbcValues() {
	
	if ( get_option( 'dipi_pm_OnceMigrateCbcValues', '0' ) == '1' ) {
			return;
	}
	
	/* Search Dipi Popup Makers with Custom Close Buttons */
	$args = array(
		'post_type' => 'dipi_popup_maker',
		'posts_per_page' => -1,
		'cache_results'  => false
	);
	$query = new WP_Query( $args );
	
	$posts = $query->get_posts();
	
	if ( isset( $posts[0] ) ) {
		
		dipi_pm_migrateCbcValues( $posts );
	}

	// Add or update the wp_option
	update_option( 'dipi_pm_OnceMigrateCbcValues', '1' );
}
add_action( 'init', 'dipi_pm_OnceMigrateCbcValues' );

function dipi_pm_migrateCbcValues( $posts = null ){
	
	if ( is_array( $posts ) ) {
	
		foreach( $posts as $dv_post ) {
			
			$post_id = $dv_post->ID;
			
			dipi_pm_updateCbcValues( $post_id );
		}
	}
}

function dipi_pm_updateCbcValues( $post_id = null ) {
	
	if ( $post_id ) {
	
		$old_cbc_textcolor = get_post_meta( $post_id, 'post_closebtn_text_color', true );
		$old_cbc_bgcolor = get_post_meta( $post_id, 'post_closebtn_bg_color', true );
		$old_cbc_fontsize = get_post_meta( $post_id, 'post_closebtn_fontsize', true );
		$old_cbc_borderradius = get_post_meta( $post_id, 'post_closebtn_borderradius', true );
		$old_cbc_padding = get_post_meta( $post_id, 'post_closebtn_padding', true );
		
		if ( $old_cbc_textcolor != '' ) {
			update_post_meta( $post_id, 'post_doclosebtn_text_color', sanitize_text_field( $old_cbc_textcolor ) );
		}
		
		if ( $old_cbc_bgcolor != '' ) {
			update_post_meta( $post_id, 'post_doclosebtn_bg_color', sanitize_text_field( $old_cbc_bgcolor ) );
		}
		
		if ( $old_cbc_fontsize != '' ) {
			update_post_meta( $post_id, 'post_doclosebtn_fontsize', sanitize_text_field( $old_cbc_fontsize ) );
		}
		
		if ( $old_cbc_borderradius != '' ) {
			update_post_meta( $post_id, 'post_doclosebtn_borderradius', sanitize_text_field( $old_cbc_borderradius ) );
		}
		
		if ( $old_cbc_padding != '' ) {
			update_post_meta( $post_id, 'post_doclosebtn_padding', sanitize_text_field( $old_cbc_padding ) );
		}
		
		// Reset old values
		update_post_meta( $post_id, 'post_closebtn_text_color', '' );
		update_post_meta( $post_id, 'post_closebtn_bg_color', '' );
		update_post_meta( $post_id, 'post_closebtn_fontsize', '' );
		update_post_meta( $post_id, 'post_closebtn_borderradius', '' );
		update_post_meta( $post_id, 'post_closebtn_padding', '' );
	}
}


function dipm_get_wp_posts() {
			
	if ( isset( $_POST['q'] ) ) { // phpcs:ignore
	
		$q = stripslashes( $_POST['q'] );// phpcs:ignore
	
	} else {
		
		return;
	}
	
	
	if ( isset( $_POST['page'] ) ) {// phpcs:ignore
		
		$page = (int) $_POST['page'];// phpcs:ignore
		
	} else {
		
		$page = 1;
	}
	
	
	if ( isset( $_POST['json'] ) ) {// phpcs:ignore
		
		$json = (int) $_POST['json'];// phpcs:ignore
		
	} else {
		
		$json = 0;
	}
	
	$data = null;
	
	$dipi_pm_settings = get_option( 'dipi_pm_settings' );
	
	$sitearea = $_POST['sitearea'];// phpcs:ignore
	$post_types = [];
	if ($sitearea === 'sitewide') {
		$post_types = get_post_types( array( 'public' => true ) );
	} else {
		$post_types = array($sitearea);
	}
	
	
	$excluded_post_types = array( 'attachment', 'revision', 'nav_menu_item', 'custom_css', 'et_pb_layout', 'divi_bars', 'dipi_popup_maker', 'divi_mega_pro', 'customize_changeset' );
	
	$post_types = array_diff( $post_types, $excluded_post_types );
	
	$posts = array();
	
	$total_count = 0;
	
	$args = array(
		's' => $q,
		'post_type' => $post_types,
		'cache_results'  => false,
		'posts_per_page' => 7,
		'paged' => $page,
		'orderby' => 'id',
		'order' => 'DESC'
	);
	$query = new WP_Query( $args );
	
	$get_posts = $query->get_posts();
	
	$posts = array_merge( $posts, $get_posts );
	
	$total_count = (int) $query->found_posts;
	
	$posts = dipm_keysToLower( $posts );
	
	if ( $json ) {
		
		header( 'Content-type: application/json' );
		$data = json_encode(
		
			array(
				'total_count' => $total_count,
				'items' => $posts
			)
		);
		
		die( $data ); // phpcs:ignore
	}
	
	return $posts;
}
add_action( 'wp_ajax_nopriv_ajax_dipm_listposts', 'dipm_get_wp_posts' );
add_action( 'wp_ajax_ajax_dipm_listposts', 'dipm_get_wp_posts' );


function dipm_keysToLower( &$obj )
{
	$type = (int) is_object($obj) - (int) is_array($obj);
	if ($type === 0) return $obj;
	foreach ($obj as $key => &$val)
	{
		$element = dipm_keysToLower($val);
		switch ($type)
		{
		case 1:
			if (!is_int($key) && $key !== ($keyLowercase = strtolower($key)))
			{
				unset($obj->{$key});
				$key = $keyLowercase;
			}
			$obj->{$key} = $element;
			break;
		case -1:
			if (!is_int($key) && $key !== ($keyLowercase = strtolower($key)))
			{
				unset($obj[$key]);
				$key = $keyLowercase;
			}
			$obj[$key] = $element;
			break;
		}
	}
	return $obj;
}
