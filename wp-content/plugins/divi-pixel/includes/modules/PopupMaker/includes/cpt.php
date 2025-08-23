<?php
// Register the Custom Popup Maker Post Type
function register_cpt_dipi_popup_maker() {
 
    $labels = array(
        'name' => _x( 'Popup Maker', 'dipi_popup_maker' ),
        'singular_name' => _x( 'Popup Maker', 'dipi_popup_maker' ),
        'add_new' => _x( 'Add New', 'dipi_popup_maker' ),
        'add_new_item' => _x( 'Add New Popup Maker', 'dipi_popup_maker' ),
        'edit_item' => _x( 'Edit Popup Maker', 'dipi_popup_maker' ),
        'new_item' => _x( 'New Popup Maker', 'dipi_popup_maker' ),
        'view_item' => _x( 'View Popup Maker', 'dipi_popup_maker' ),
        'search_items' => _x( 'Search Popup Maker', 'dipi_popup_maker' ),
        'not_found' => _x( 'No Popup Maker found', 'dipi_popup_maker' ),
        'not_found_in_trash' => _x( 'No Popups found in Trash', 'dipi_popup_maker' ),
        'parent_item_colon' => _x( 'Parent Popup Maker:', 'dipi_popup_maker' ),
        'menu_name' => _x( 'Popup Maker', 'dipi_popup_maker' ),
    );
 
    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        //'description' => 'Popup Maker Description',
        'supports' => array( 'title', 'editor', 'author' ),
        //'taxonomies' => array( 'genres' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-admin-page',
        'show_in_nav_menus' => true,
        'exclude_from_search' => true,
        'has_archive' => false,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
 
    register_post_type( 'dipi_popup_maker', $args );
}
 
add_action( 'init', 'register_cpt_dipi_popup_maker' );


add_action( 'do_meta_boxes', 'remove_default_custom_fields_meta_box', 1, 3 );
function remove_default_custom_fields_meta_box( $post_type, $context, $post ) {
    remove_meta_box( 'postcustom', 'dipi_popup_maker', $context );
}

/* Add custom column in post type */
add_filter(
	'manage_edit-dipi_popup_maker_columns',
	'my_edit_dipi_popup_maker_columns'
) ;

function my_edit_dipi_popup_maker_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Title' ),
		'preview_column' => __( 'Preview' ),
		'unique_indentifier' => __( 'CSS ID' ),
		'active_status' => __( 'Status' ),
		'triggering_setting' => __( 'Triggering' ),
		'author' => __( 'Author' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

add_action(
	'manage_dipi_popup_maker_posts_custom_column',
	'my_manage_dipi_popup_maker_columns',
	10,
	2
);


function my_manage_dipi_popup_maker_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {
		case 'preview_column': 
			
			echo sprintf(
				'<a href="%1$s" target="_blank">
					<span class="dashicons dashicons-visibility"></span>
				</a>',
				esc_url(wp_nonce_url(
					sprintf('%1$s/?dipi_popup_preview&dipi_popup_id=%2$s#dipipopup-%2$s', 
						get_site_url(),
						esc_attr($post->ID)
				), 'dipi_popup_nonce', 'dipi_popup_nonce'))
			);
		break;
		/* If displaying the 'unique-indentifier' column. */
		case 'unique_indentifier' :

			/* Get the post meta. */
			$post_slug = "dipi_popup_id_$post->ID";
			echo esc_html($post_slug);
			break;
		case 'active_status' :

			/* Get the post meta. */
			$dipi_popup_active = get_post_meta(
				$post->ID, 'dipi_popup-active', true
			);
			if (empty($dipi_popup_active)) {
				$dipi_popup_active = 'true';
			}
			if ($dipi_popup_active == 'true') {
				echo '<span class="active">Active</span>';
			} else {
				echo '<span class="inactive">Inactive</span>';
			}
		
			break;
		case 'triggering_setting' :
			$pm_sub_setting_name_selected = get_post_meta(
				$post->ID, 'pm_sub_setting_triggering_settings', true
			);
			$pm_sub_setting_options = array(
				'trigger_none'   => esc_html__( 'None', 'dipi-divi-pixel' ),
				'trigger_on_load'   => esc_html__( 'On Load', 'dipi-divi-pixel' ),
				'trigger_on_scroll'   => esc_html__( 'On Scroll', 'dipi-divi-pixel' ),
				'trigger_on_exit'   => esc_html__( 'On Exit', 'dipi-divi-pixel' ),
				'trigger_on_inactivity'   => esc_html__( 'On Inactivity', 'dipi-divi-pixel' ),
			);
			echo sprintf(
				'<span class="%1$s">%2$s</span>',
				esc_attr($pm_sub_setting_name_selected),
				esc_html($pm_sub_setting_options[$pm_sub_setting_name_selected])
			);
			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}
/* Custom column End here */

// Quick Edit
function dipi_popup_maker_custom_edit_box_pt( $column_name, $post_type, $taxonomy ) {
    global $post;

    switch ( $post_type ) {
        case 'dipi_popup_maker':
			if( $column_name === 'active_status' ): // same column title as defined in previous step
			?>
				<?php  
					$dipi_popup_active = get_post_meta(
						$post->ID, 'dipi_popup-active', true
					);
					if (empty($dipi_popup_active)) {
						$dipi_popup_active = 'true';
					}
				?>
				<fieldset class="inline-edit-col-left" id="#edit-">
					<div class="inline-edit-col">
						<label class="alignleft">
							<input type="checkbox" name="dipi_popup-active-checkbox">
							<span class="checkbox-title">Active</span>
						</label>
					</div>
				</fieldset>
				<?php
			endif;
            // echo 'custom page field';
            break;
        
        default:
            break;
    }
}
add_action( 'quick_edit_custom_box', 'dipi_popup_maker_custom_edit_box_pt', 10, 3 );

/* Save quick edit */
function dipi_popup_maker_update_custom_quickedit_box() {
	 
	if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['et_fb_save_nonce'])){
	 	if(!wp_verify_nonce( sanitize_text_field( $_POST['et_fb_save_nonce'] ), 'et_fb_save_nonce' )){
			wp_send_json_error();
		}
	}

	if ( isset($_POST['post_ID']) && isset( $_POST['dipi_popup-active-checkbox'] ) ) { 
		update_post_meta(
			sanitize_text_field($_POST['post_ID']),
			'dipi_popup-active',
			sanitize_text_field( $_POST['dipi_popup-active-checkbox'] )  
		);
	} else if(isset($_POST['post_ID'])){
		update_post_meta(
			sanitize_text_field($_POST['post_ID']),
			'dipi_popup-active',
			"false" 
		);
	}
}
add_action( 'save_post_dipi_popup_maker', 'dipi_popup_maker_update_custom_quickedit_box' );

// Add 'Activate/Deactivate' into "Edit | Quick Edit | Trash | View | Edit in Visual Builder" actions.
function dipi_popup_preview_link($actions, $post)
{
	if ($post->post_type === 'dipi_popup_maker') {
		$dipi_popup_active = get_post_meta(
			$post->ID, 'dipi_popup-active', true
		);
		if (empty($dipi_popup_active)) {
			$dipi_popup_active = 'true';
		}
		$url = add_query_arg(
            array(
              'post_id' => $post->ID,
              'dipi_popup_action' => $dipi_popup_active,
			  'dipi_popup_nonce' => wp_create_nonce('dipi_popup_nonce')
            )
        );


		if ($dipi_popup_active == 'true') {
			$actions['active_status'] = '<a href="'.esc_url($url).'" target="_self">Deactivate</a>';
		} else {
			$actions['active_status'] = '<a href="'.esc_url($url).'" target="_self">Activate</a>';
		}
	}
    return $actions;
}
add_filter('post_row_actions', 'dipi_popup_preview_link', 10, 2);

// Change active status by Get param
function dipi_popup_change_active_func(){
  if(!isset($_GET['dipi_popup_nonce']) || !wp_verify_nonce( sanitize_key($_GET['dipi_popup_nonce']), 'dipi_popup_nonce' )){
	return;
  }
  if ( isset($_REQUEST['post_id']) && isset( $_REQUEST['dipi_popup_action'] ) ) {
	update_post_meta(
		sanitize_text_field($_REQUEST['post_id']),
		'dipi_popup-active',
		sanitize_text_field($_REQUEST['dipi_popup_action']) === 'true' ? 'false' : 'true'
	);

	$redirect_url = remove_query_arg(
		array(
			'post_id',
			'dipi_popup_action'
		)
	);
	
	header('Location: '.$redirect_url);
    exit;
  }
}
add_action( 'admin_init', 'dipi_popup_change_active_func' );

/**
 * Populate the custom field values at the quick edit box using Javascript
 */
if (!function_exists('dipi_popup_maker_quick_edit_js')) {
    function dipi_popup_maker_quick_edit_js()
    {
        // # check the current screen
        // https://developer.wordpress.org/reference/functions/get_current_screen/
        $current_screen = get_current_screen();

        if ($current_screen->id != 'edit-dipi_popup_maker' || $current_screen->post_type !== 'dipi_popup_maker')
            return;

        // # Make sure jQuery library is loaded because we will use jQuery for populate our custom field value.
        wp_enqueue_script('jquery');
        ?>


        <!-- add JS script -->
        <script type="text/javascript">
            jQuery(function($) {

                // we create a copy of the WP inline edit post function
                var $dipi_popup_maker_inline_editor = inlineEditPost.edit;

                // Note: Hooking inlineEditPost.edit must be done in a JS script, loaded after wp-admin/js/inline-edit-post.js
                // then we overwrite the inlineEditPost.edit function with our own code
                inlineEditPost.edit = function(id) {

                    // call the original WP edit function 
                    $dipi_popup_maker_inline_editor.apply(this, arguments);


                    // ### start: add our custom functionality below  ###

                    // get the post ID
                    var $post_id = 0;
                    if (typeof(id) == 'object') {
                        $post_id = parseInt(this.getId(id));
                    }

                    // if we have our post
                    if ($post_id != 0) {
                        // tips: use the inspecttion tool to help you see the HTML structure on the edit page.

                        // explanation: 
                        // On the posts management page, all posts will render inside the <tbody> along with "the-list" id.
                        // Then each post will render on each <tr> along with "post-176" which 176 is my post ID. Your will be difference.
                        // When the quick edit menu is clicked on the "post-176", the <tr> will be set as hide(display:none)
                        // and the new <tr> along with "edit-176" id will be appended after <tr> which is hidden.
                        // What we will do, we will use the jQuery to find the website value from the hidden <tr>. 
                        // Get that value and assign to the website input field on the quick edit box.
                        // 
                        // The concept is the same when you create the inline editor by jQuery manually.

                        // define the edit row
                        var $edit_row = $('#edit-' + $post_id);
                        var $post_row = $('#post-' + $post_id);

                        // get the data
                        var $active_status = $('.column-active_status span', $post_row).text();
                        // populate the data
						if ($active_status === "Active") {
							$(':input[name="dipi_popup-active-checkbox"]', $edit_row).prop('checked', true);
							$(':input[name="dipi_popup-active-checkbox"]', $edit_row).val("true")
						} else {
							$(':input[name="dipi_popup-active-checkbox"]', $edit_row).val("false")
						}
						$(':input[name="dipi_popup-active-checkbox"]', $edit_row).change(
							function(){
								if ($(this).is(':checked')) {
									$(this).val("true")
								} else {
									$(this).val("false")
								}
						});
                    }

                    // ### end: add our custom functionality below  ###
                }

            });
        </script>
<?php
    }

    // https://developer.wordpress.org/reference/hooks/admin_print_footer_scripts-hook_suffix/
    add_action('admin_print_footer_scripts-edit.php', 'dipi_popup_maker_quick_edit_js');
}


// Add Divi Theme Builder
add_filter('et_builder_post_types','dipi_popup_makers_enable_builder');

function dipi_popup_makers_enable_builder($post_types){
	$post_types[] = 'dipi_popup_maker';
	return $post_types;
}

// Meta boxes for Popup Maker //
function et_add_dipi_popup_maker_meta_box() {
	
	$screen = get_current_screen();
	
	if ( $screen->post_type == 'dipi_popup_maker' ) {
		add_meta_box(
			'dipi_popup_maker_settings_meta_box',
			esc_html__( 'Popup Settings', 'dipi-divi-pixel' ),
			'dipi_display_popup_settings_callback',
			'dipi_popup_maker'
		);
  }
}
add_action( 'add_meta_boxes', 'et_add_dipi_popup_maker_meta_box' );

if ( ! function_exists( 'dipi_display_popup_settings_callback' ) ) :
    function dipi_display_popup_settings_callback( $post ) {
        $screen = get_current_screen();
		include_once( 'metabox/popup-maker-meta-box.php' );
	}
endif;

/*===================================================================*/
add_filter(
	'is_protected_meta',
	'dipi_pm_removefields_from_customfieldsmetabox',
	10,
	2
);
function dipi_pm_removefields_from_customfieldsmetabox( $protected, $meta_key ) {
	
	if ( function_exists( 'get_current_screen' ) ) {
		
		$screen = get_current_screen();
		
		$remove = $protected;
		
		if ( $screen !== null && $screen->post_type != 'dipi_popup_maker' ) {
		
			if ( $meta_key == 'xxx'
				) {
					
				$remove = true;
			}
		}

		return $remove;
	}
}

// Save Meta Box Value //
function et_dipi_popup_maker_settings_save_details( $post_id, $post ){
    global $pagenow;
	if ( 'post.php' != $pagenow ) return $post_id;
	
	if('dipi_popup_maker' !== get_post_type()) return $post_id;

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return $post_id;

    $post_type = get_post_type_object( $post->post_type );
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
	
	$post_value = '';
	/* General Settings */
	if ( isset( $_POST['dipi_popup-active'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'dipi_popup-active',
			sanitize_text_field( $_POST['dipi_popup-active'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'dipi_popup-active');
	}
    /* Triggering settings */
    if ( isset( $_POST['pm_sub_setting_triggering_settings'] ) ) { // phpcs:ignore
		update_post_meta(
			$post_id,
			'pm_sub_setting_triggering_settings',
			sanitize_text_field( $_POST['pm_sub_setting_triggering_settings'] )// phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'pm_sub_setting_triggering_settings' );
	}
    /* -- Triggering settings -> Manual */
    if ( isset( $_POST['trigger_manual-custom_css_selector'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'trigger_manual-custom_css_selector',
			sanitize_text_field( $_POST['trigger_manual-custom_css_selector'] ) // phpcs:ignore
		);
	}

	if ( isset( $_POST['trigger-closing_css_selector'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'trigger-closing_css_selector',
			sanitize_text_field( $_POST['trigger-closing_css_selector'] ) // phpcs:ignore
		);
	}

    /* -- Triggering settings -> On load */
    if ( isset( $_POST['trigger_on_load-delay-start'] ) ) {// phpcs:ignore
			update_post_meta( $post_id, 'trigger_on_load-delay-start',
			sanitize_text_field( $_POST['trigger_on_load-delay-start'] ) // phpcs:ignore
		);
	}
    if ( isset( $_POST['trigger_on_load-delay-end'] ) ) {// phpcs:ignore
			update_post_meta( $post_id, 'trigger_on_load-delay-end',
			sanitize_text_field( $_POST['trigger_on_load-delay-end'] ) // phpcs:ignore
		);
	}

    /* -- Triggering settings -> On Scroll */
    if ( isset( $_POST['trigger_on_scroll-offset'] ) ) {// phpcs:ignore
		update_post_meta( 
			$post_id,
			'trigger_on_scroll-offset',
			sanitize_text_field( $_POST['trigger_on_scroll-offset'] ) // phpcs:ignore
		);
	}
    if ( isset( $_POST['trigger_autotrigger-offset_units'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'trigger_autotrigger-offset_units',
			sanitize_text_field( $_POST['trigger_autotrigger-offset_units'] ) // phpcs:ignore
		);
	}

    /* -- Triggering settings -> On Inactivity */
    if ( isset( $_POST['trigger_on_inactivity-delay'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'trigger_on_inactivity-delay',
			sanitize_text_field( $_POST['trigger_on_inactivity-delay'] ) // phpcs:ignore
		);
	}

    /* --Auto triger settings-- */
    if ( isset( $_POST['trigger_autotrigger-periodicity'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'trigger_autotrigger-periodicity',
			sanitize_text_field( $_POST['trigger_autotrigger-periodicity'] ) // phpcs:ignore
		);
	}
    if ( isset( $_POST['trigger_autotrigger-periodicity-hours'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'trigger_autotrigger-periodicity-hours',
			sanitize_text_field( $_POST['trigger_autotrigger-periodicity-hours'] ) // phpcs:ignore
		);
	}
    if ( isset( $_POST['trigger_autotrigger-activity'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'trigger_autotrigger-activity',
			sanitize_text_field( $_POST['trigger_autotrigger-activity'] ) // phpcs:ignore
		);
	}
    if ( isset( $_POST['trigger_auto-activ-certain_period-from'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'trigger_auto-activ-certain_period-from',
			sanitize_text_field( $_POST['trigger_auto-activ-certain_period-from']) // phpcs:ignore
		);
	}
    if ( isset( $_POST['trigger_auto-activ-certain_period-to'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'trigger_auto-activ-certain_period-to',
			sanitize_text_field( $_POST['trigger_auto-activ-certain_period-to'] ) // phpcs:ignore
		);
	}
    if ( isset( $_POST['trigger-auto-resp_disable_phone'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'trigger-auto-resp_disable_phone',
			sanitize_text_field( $_POST['trigger-auto-resp_disable_phone'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'trigger-auto-resp_disable_phone' );
	}
	if ( isset( $_POST['trigger-auto-resp_disable_tablet'] ) ) {// phpcs:ignore
		update_post_meta( 
			$post_id,
		 'trigger-auto-resp_disable_tablet',
		 sanitize_text_field( $_POST['trigger-auto-resp_disable_tablet'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'trigger-auto-resp_disable_tablet' );
	}
	if ( isset( $_POST['trigger-auto-resp_disable_desktop'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'trigger-auto-resp_disable_desktop',
			sanitize_text_field( $_POST['trigger-auto-resp_disable_desktop'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'trigger-auto-resp_disable_desktop');
	}
    /* --Common Setting --*/
	if ( isset( $_POST['trigger-remove_link'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'trigger-remove_link',
			sanitize_text_field( $_POST['trigger-remove_link'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'trigger-remove_link');
	}
	if ( isset( $_POST['trigger-close_on_bg'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'trigger-close_on_bg',
			sanitize_text_field( $_POST['trigger-close_on_bg'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'trigger-close_on_bg');
	}
	if ( isset( $_POST['trigger-hide_popup_slug'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'trigger-hide_popup_slug',
			sanitize_text_field( $_POST['trigger-hide_popup_slug'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'trigger-hide_popup_slug');
	}
	if ( isset( $_POST['trigger-close_by_back_btn'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'trigger-close_by_back_btn',
			sanitize_text_field( $_POST['trigger-close_by_back_btn'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'trigger-close_by_back_btn');
	}
    if ( isset( $_POST['trigger-prev_page_scrolling'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'trigger-prev_page_scrolling',
			sanitize_text_field( $_POST['trigger-prev_page_scrolling'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'trigger-prev_page_scrolling');
	}

	/* Popup Locations Settings */
	/*-- User Roles */
	//global $wp_roles;
    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles();
	foreach ($wp_roles->role_names as $wp_role_key=> $wp_role_value) {
		if ( isset( $_POST["locations_user_roles_$wp_role_key"] ) ) {// phpcs:ignore
			update_post_meta(
				$post_id,
				"locations_user_roles_$wp_role_key",
				sanitize_text_field( $_POST["locations_user_roles_$wp_role_key"] ) // phpcs:ignore
			);
		} else {
			delete_post_meta( $post_id, "locations_user_roles_$wp_role_key");
		}
	}
	if ( isset( $_POST["locations_user_roles-all"] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			"locations_user_roles-all",
			sanitize_text_field( $_POST["locations_user_roles-all"] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, "locations_user_roles-all");
	}
	if ( isset( $_POST["locations_user_roles_guest"] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			"locations_user_roles_guest",
			sanitize_text_field( $_POST["locations_user_roles_guest"] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, "locations_user_roles_guest");
	}
	/* -- Site Area */
	if ( isset( $_POST['pm_sub_set_loc_sitearea_settings'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'pm_sub_set_loc_sitearea_settings',
			sanitize_text_field( $_POST['pm_sub_set_loc_sitearea_settings'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'pm_sub_set_loc_sitearea_settings');
	}
	/* tax, category, tags */
	$_post_type = $_POST['pm_sub_set_loc_sitearea_settings'];// phpcs:ignore
  $taxonomies = get_object_taxonomies($_post_type, 'object');

	foreach ($taxonomies as $key => $taxonomy) {
		if (!$taxonomy->public) continue;
		if ($key == 'post_format') continue;
		$terms = get_terms($key, array('hide_empty' => false));
		$all_term_name = "locations_site_area-all-$_post_type-$key";
		if ( isset( $_POST[$all_term_name] ) ) {// phpcs:ignore
			update_post_meta(
				$post_id,
				$all_term_name,
				sanitize_text_field( $_POST[$all_term_name] ) // phpcs:ignore
			);
		} else {
			delete_post_meta( $post_id, $all_term_name);
		}
		foreach ($terms as $term) {
			$term_name =  "locations_site_area-$_post_type-$key-$term->slug";
			$term_value = $_POST[$term_name];// phpcs:ignore
			if ( isset( $term_value ) ) {
				update_post_meta(
					$post_id, $term_name,
					sanitize_text_field( $term_value ) // phpcs:ignore
				);
			} else {
				delete_post_meta( $post_id, $term_name);
			}
		}
	}
	/* Customization */
	if ( isset( $_POST['post_dipi_popup_bg_color'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'post_dipi_popup_bg_color',
			sanitize_text_field( $_POST['post_dipi_popup_bg_color'] )// phpcs:ignore 
		);
	} else {
		delete_post_meta( $post_id, 'post_dipi_popup_bg_color' );
	}

	if ( isset( $_POST['popup_anim_name'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'popup_anim_name',
			sanitize_text_field( $_POST['popup_anim_name'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'popup_anim_name' );
	}
	if ( isset( $_POST['popup_pos_location_name'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'popup_pos_location_name',
			sanitize_text_field( $_POST['popup_pos_location_name'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'popup_pos_location_name' );
	}

	if ( isset( $_POST['close_btn_bg_color'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id, 'close_btn_bg_color',
			sanitize_text_field( $_POST['close_btn_bg_color'] ) );// phpcs:ignore
	} else {
		delete_post_meta( $post_id, 'close_btn_bg_color' );
	}
	if ( isset( $_POST['dipi_popup_enable_blur'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'dipi_popup_enable_blur',
			sanitize_text_field( $_POST['dipi_popup_enable_blur'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'dipi_popup_enable_blur' );
	}
	if ( isset( $_POST['dipi_custom_overlay_z_index'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'dipi_custom_overlay_z_index',
			sanitize_text_field( $_POST['dipi_custom_overlay_z_index'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'dipi_custom_overlay_z_index' );
	}
	if ( isset( $_POST['dipi_custom_desktop_popup_width'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'dipi_custom_desktop_popup_width',
			sanitize_text_field( $_POST['dipi_custom_desktop_popup_width'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'dipi_custom_desktop_popup_width' );
	}

	if ( isset( $_POST['dipi_custom_desktop_popup_unit'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'dipi_custom_desktop_popup_unit',
			sanitize_text_field( $_POST['dipi_custom_desktop_popup_unit'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'dipi_custom_desktop_popup_unit' );
	}

	if ( isset( $_POST['dipi_custom_tablet_popup_width'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'dipi_custom_tablet_popup_width',
			sanitize_text_field( $_POST['dipi_custom_tablet_popup_width'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'dipi_custom_tablet_popup_width' );
	}

	if ( isset( $_POST['dipi_custom_tablet_popup_unit'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'dipi_custom_tablet_popup_unit',
			sanitize_text_field( $_POST['dipi_custom_tablet_popup_unit'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'dipi_custom_tablet_popup_unit' );
	}

	if ( isset( $_POST['dipi_custom_mobile_popup_width'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'dipi_custom_mobile_popup_width',
			sanitize_text_field( $_POST['dipi_custom_mobile_popup_width'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'dipi_custom_mobile_popup_width' );
	}

	if ( isset( $_POST['dipi_custom_mobile_popup_unit'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'dipi_custom_mobile_popup_unit',
			sanitize_text_field( $_POST['dipi_custom_mobile_popup_unit'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'dipi_custom_mobile_popup_unit' );
	}
	
	if ( isset( $_POST['dipi_custom_min_popup_width'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'dipi_custom_min_popup_width',
			sanitize_text_field( $_POST['dipi_custom_min_popup_width'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'dipi_custom_min_popup_width' );
	}

	if ( isset( $_POST['dipi_custom_min_popup_unit'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'dipi_custom_min_popup_unit',
			sanitize_text_field( $_POST['dipi_custom_min_popup_unit'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'dipi_custom_min_popup_unit' );
	}

	if ( isset( $_POST['dipi_custom_clickable_under_overlay'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'dipi_custom_clickable_under_overlay',
			sanitize_text_field( $_POST['dipi_custom_clickable_under_overlay'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'dipi_custom_clickable_under_overlay' );
	}
	if ( isset( $_POST['dipi_custom_hide_close_btn'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'dipi_custom_hide_close_btn',
			sanitize_text_field( $_POST['dipi_custom_hide_close_btn'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'dipi_custom_hide_close_btn' );
	}

	if ( isset( $_POST['dipi_custom_show_close_btn_within_popup_phone'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'dipi_custom_show_close_btn_within_popup_phone',
			sanitize_text_field( $_POST['dipi_custom_show_close_btn_within_popup_phone'] )// phpcs:ignore 
		);
	} else {
		delete_post_meta( $post_id, 'dipi_custom_show_close_btn_within_popup_phone' );
	}
	if ( isset( $_POST['dipi_custom_show_close_btn_within_popup_tablet'] ) ) {// phpcs:ignore
		update_post_meta( 
			$post_id,
		 'dipi_custom_show_close_btn_within_popup_tablet',
		 sanitize_text_field( $_POST['dipi_custom_show_close_btn_within_popup_tablet'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'dipi_custom_show_close_btn_within_popup_tablet' );
	}
	if ( isset( $_POST['dipi_custom_show_close_btn_within_popup_desktop'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'dipi_custom_show_close_btn_within_popup_desktop',
			sanitize_text_field( $_POST['dipi_custom_show_close_btn_within_popup_desktop'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'dipi_custom_show_close_btn_within_popup_desktop');
	}

	if ( isset( $_POST['close_btn_icon_color'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'close_btn_icon_color',
			sanitize_text_field( $_POST['close_btn_icon_color'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'close_btn_icon_color' );
	}
	if ( isset( $_POST['dipi_custom_close_btn_icon_size'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'dipi_custom_close_btn_icon_size',
			sanitize_text_field( $_POST['dipi_custom_close_btn_icon_size'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'dipi_custom_close_btn_icon_size' );
	}
	if ( isset( $_POST['dipi_custom_close_btn_padding'] ) ) {// phpcs:ignore
		update_post_meta( 
			$post_id,
			'dipi_custom_close_btn_padding',
		 	sanitize_text_field( $_POST['dipi_custom_close_btn_padding'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'dipi_custom_close_btn_padding' );
	}
	if ( isset( $_POST['dipi_custom_close_btn_margin'] ) ) {// phpcs:ignore
		update_post_meta( 
			$post_id,
			'dipi_custom_close_btn_margin',
		 	sanitize_text_field( $_POST['dipi_custom_close_btn_margin'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'dipi_custom_close_btn_margin' );
	}
	if ( isset( $_POST['dipi_custom_close_btn_border_radius'] ) ) {// phpcs:ignore
		update_post_meta(
			$post_id,
			'dipi_custom_close_btn_border_radius',
			sanitize_text_field( $_POST['dipi_custom_close_btn_border_radius'] ) // phpcs:ignore
		);
	} else {
		delete_post_meta( $post_id, 'dipi_custom_close_btn_border_radius' );
	}

	if ( isset( $_POST['post_at_pages'] ) ) {// phpcs:ignore
		
		$post_value = sanitize_text_field( $_POST['post_at_pages'] );// phpcs:ignore
		update_post_meta( $post_id, 'dipi_at_pages', $post_value );// phpcs:ignore
	}

	if ( $post_value == 'specific' ) {// phpcs:ignore
		
		if ( isset( $_POST['dipi_at_pages_selected'] ) ) {// phpcs:ignore
			update_post_meta(
				$post_id,
				'dipi_at_pages_selected',
				$_POST['dipi_at_pages_selected']// phpcs:ignore
			);
		}
	}
	else {
		
		update_post_meta( $post_id, 'dipi_at_pages_selected', '' );
	}
		
	if ( isset( $_POST['dipi_at_exception_selected'] ) ) {// phpcs:ignore
	
		update_post_meta(
			$post_id,
			'dipi_at_exception_selected',
			$_POST['dipi_at_exception_selected'] // phpcs:ignore
		);
	} else {
		update_post_meta( $post_id, 'dipi_at_exception_selected', '' );
	}
	
}
add_action( 'save_post', 'et_dipi_popup_maker_settings_save_details', 10, 2 );

function dipi_datetime_string($_datetime) {
    $dt = (string)$_datetime;
    if (strlen($dt) != 12) return '';
    return substr($dt, 0, 4).'-'.substr($dt, 4, 2).'-'.substr($dt, 6, 2).' '.substr($dt, 8, 2).':'.substr($dt, 10, 2);
}
