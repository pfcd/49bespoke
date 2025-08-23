<?php
    $_post_type = $pm_sub_setting_option_value;
    $taxonomies = get_object_taxonomies($_post_type, 'object');

    foreach ($taxonomies as $key => $onetaxonomy) {
        if (!$onetaxonomy->public) continue;
		if ($key == 'post_format') continue;
        $selected_terms = array();
        $selected = false;
        $terms = get_terms($key, array('hide_empty' => false));

        $all_term_name = "locations_site_area-all-$_post_type-$key";
        $all_term_value = get_post_meta( $post->ID, $all_term_name, true);
        $term_selected = false;
        foreach ($terms as $oneterm) {
            $term_name =  "locations_site_area-$_post_type-$key-$oneterm->slug";
            if ( get_post_meta( $post->ID, $term_name , true ) === "on") {
                $term_selected = true;
                break;
            }
        }
        if (empty($all_term_value) && !$term_selected) {
            $all_term_value = 'on';
        }
?>
        <div class="dipi_popup-sub">
            <label for="locations_site_area" class="dipi_popup-sub-lbl">
                <?php echo esc_html($onetaxonomy->label) ?>
            </label>
            <div class="dipi_popup-sub-val-container" >
                <div class="dipi_popup-sub-val-radio-grp tag-style">
                    <div
                        class="dipi_popup-sub-val-radio-container<?php if ( $all_term_value === "on" ) { ?> allchecked<?php } ?>">
                        <input
                            type="checkbox"
                            class="allcheckbox"
                            name="<?php echo esc_attr($all_term_name)?>"
                            <?php if ( $all_term_value === "on" ) { ?> checked<?php } ?>
                        >
                        <label for="<?php echo esc_attr($all_term_name)?>"><?php echo esc_html($onetaxonomy->labels->all_items) ?></label>
                    </div>
<?php
                    foreach ($terms as $oneterm) {
                        $term_name =  "locations_site_area-$_post_type-$key-$oneterm->slug";
                        $term_value = get_post_meta( $post->ID, $term_name, true);
?>                      
                        <div class="dipi_popup-sub-val-radio-container">                        
                            <input
                                type="checkbox"
                                name="<?php echo esc_attr($term_name);?>" 
                                <?php if ( $term_value === "on" ) { ?> checked<?php } ?>
                            />
                            <label for="<?php echo esc_attr($term_name)?>" ><?php echo esc_html($oneterm->name) ?></label>
                       </div>
<?php                        
                    }
?>                    
                </div>
            </div>
        </div>
<?php
    }
 
?>
