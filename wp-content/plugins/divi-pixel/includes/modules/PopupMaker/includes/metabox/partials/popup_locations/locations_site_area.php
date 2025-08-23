<?php
    $locations_site_area = get_post_meta( $post->ID, 'locations-site_area', true );
    $pm_sub_setting_name = "pm_sub_set_loc_sitearea_settings";
    $pm_sub_setting_name_selected = get_post_meta(
        $post->ID, $pm_sub_setting_name, true 
    );
    $post_types =  get_post_types( 
        array(
            'public'   => true,
            '_builtin' => false
        ),
        'objects'
    );
    $selectable_post_types = array();
    $selectable_post_types['sitewide'] = "Sitewide";
    $selectable_post_types['page'] = "Pages";
    $selectable_post_types['post'] = "Posts";
    foreach ($post_types as $post_type_key=>$post_type_value) {
        $selectable_post_types[$post_type_value->name] = $post_type_value->label;
    }
?>
<div class="dipi_popup-sub">
    <label for=<?php echo esc_attr($pm_sub_setting_name) ?> class="dipi_popup-sub-lbl">
        Site area
    </label>    
    <select
        id=<?php echo esc_attr($pm_sub_setting_name) ?>
        name=<?php echo esc_attr($pm_sub_setting_name) ?>
        class="popup-sub-sel dipi_popup-sub-val"
    >
        <?php
        foreach ( $selectable_post_types as $pm_sub_setting_option_value => $pm_sub_setting_option_name ) {
            printf( '<option value="%2$s"%3$s>%1$s</option>',
                esc_html( $pm_sub_setting_option_name ),
                esc_attr( $pm_sub_setting_option_value ),
                selected( $pm_sub_setting_option_value, $pm_sub_setting_name_selected, false )
            );
        } ?>
    </select>
</div>
<?php
    foreach ( $selectable_post_types as $pm_sub_setting_option_value => $pm_sub_setting_option_name ) {
        printf( '<div id="%1$s" class="%2$s-tabs %1$s">',
        esc_attr($pm_sub_setting_option_value),
        esc_attr($pm_sub_setting_name)
        );
            include( "location_site_area_taxonomies.php" );
        printf('</div>');
    }
    include( "location_site_area_posts.php" );