<?php
    $at_pages = get_post_meta( $post->ID, 'dipi_at_pages', true );
    $selectedpages = get_post_meta( $post->ID, 'dipi_at_pages_selected' );
	$selectedexceptpages = get_post_meta(
        $post->ID, 'dipi_at_exception_selected'
    );
    if( $at_pages == '' ) {
        $at_pages = 'all';
    }
?>
<div
    class="dipi_popup-sub"
    id="dipi_displocation_meta_box1"
>
    <label
        for=<?php echo esc_attr($pm_sub_setting_name) ?>
        class="dipi_popup-sub-lbl"
    >
        Posts
    </label>    
    <div class="at_pages">
        <select
            name="post_at_pages"
            class="at_pages
                chosen
                do-filter-by-pages
                popup-sub-sel
                dipi_popup-sub-val
            "
            data-dropdownshowhideblock="1"
        >
            <option
                value="all"<?php if ( $at_pages == 'all' ) { ?>
                selected="selected"<?php } ?>
                data-showhideblock=".dipi-list-exceptionpages-container"
            >
                All pages
            </option>
            <option
                value="specific"<?php if ( $at_pages == 'specific' ) { ?>
                selected="selected"<?php } ?>
                data-showhideblock=".dipi-list-pages-container"
            >
                Only specific pages
            </option>
        </select>
        <div
            class="dipi-list-pages-container
                <?php if ( $at_pages == 'specific' ) { ?> do-show<?php } ?>
            "
        >
            <select
                name="dipi_at_pages_selected[]"
                class="dipi-list-pages"
                data-placeholder="Choose posts or pages..."
                multiple tabindex="3"
            >
            <?php
                if ( isset( $selectedpages[0] ) && is_array( $selectedpages[0]) ) {
                    
                    foreach( $selectedpages[0] as $selectedidx => $selectedvalue ) {
                        
                        $post_title = get_the_title( $selectedvalue );
                        
                        print '<option value="' . esc_attr($selectedvalue) . '" selected="selected">' . esc_attr($post_title) . '</option>';
                    }
                }
            ?>
            </select>
        </div>
        <div
            class="dipi-list-exceptionpages-container
                <?php if ( $at_pages == 'all' ) { ?> do-show<?php } ?>
            "
        >
            <h4 class="do-exceptedpages">Add Exceptions:</h4>
            <select
                name="dipi_at_exception_selected[]"
                class="dipi-list-exceptionpages"
                data-placeholder="Choose posts or pages..."
                multiple
                tabindex="3"
            >
            <?php
                if ( isset( $selectedexceptpages[0] ) && !empty($selectedexceptpages[0]) ) {
                    foreach( $selectedexceptpages[0] as $selectedidx => $selectedvalue ) {
                        
                        $post_title = get_the_title( $selectedvalue );
                        
                        print '<option value="' . esc_attr($selectedvalue) . '" selected="selected">' . esc_attr($post_title) . '</option>';
                    }
                }
            ?>
            </select>
        </div>
    </div>
    <div class="clear"></div> 
</div>
