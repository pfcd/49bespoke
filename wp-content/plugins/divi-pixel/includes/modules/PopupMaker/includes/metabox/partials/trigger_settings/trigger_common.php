<?php
    $trigger_prevent_page_scrolling = get_post_meta(
        $post->ID, 'trigger-prev_page_scrolling', true
    );
    if (empty($trigger_prevent_page_scrolling)) {
        $trigger_prevent_page_scrolling = 'false';
    }
    $trigger_closing_css_selector = get_post_meta(
        $post->ID, 'trigger-closing_css_selector', true
    );
    $trigger_remove_link = get_post_meta(
        $post->ID, 'trigger-remove_link', true
    );
    if (empty($trigger_remove_link)) {
        $trigger_remove_link = 'true';
    }
    $trigger_close_on_bg = get_post_meta(
        $post->ID, 'trigger-close_on_bg', true
    );
    if (empty($trigger_close_on_bg)) {
        $trigger_close_on_bg = 'true';
    }
    $dipi_custom_clickable_under_overlay =  get_post_meta(
        $popup_post_id, 'dipi_custom_clickable_under_overlay', true
    );
    if (empty($dipi_custom_clickable_under_overlay)) {
        $dipi_custom_clickable_under_overlay = 'false';
    }

    $trigger_hide_popup_slug = get_post_meta(
        $post->ID, 'trigger-hide_popup_slug', true
    );
    if (empty($trigger_hide_popup_slug)) {
        $trigger_hide_popup_slug = 'false';
    }
    $trigger_close_by_back_btn = get_post_meta(
        $post->ID, 'trigger-close_by_back_btn', true
    );
    if (empty($trigger_close_by_back_btn)) {
        $trigger_close_by_back_btn = 'true';
    }
?>
<div id="trigger_common_settings">
<?php 
    if ( 'add' != $screen->action ) {
?>
    <div class="dipi_popup-sub">
        <label
            for="trigger_manual-manual-trigger"
            class="dipi_popup-sub-lbl"
        >
            Manual Trigger
        </label>
        <div class="dipi_popup-sub-val-container" >
            <label class="dipi_popup-sub-val readonly"
                name="trigger_manual-manual-trigger"
            >
                dipi_popup_id_<?php print esc_attr($post->ID) ?>
            </label>
            <p class="dipi_popup-sub-descr">CSS ID</p>
        </div>
    </div> 
    <?php
        }
    ?>
    <?php
        $trigger_manual_custom_css_selector = get_post_meta(
            $post->ID, 'trigger_manual-custom_css_selector', true
        );
    ?>
    <div class="dipi_popup-sub">
        <label
            for="trigger_manual-custom_css_selector"
            class="dipi_popup-sub-lbl"
        >
            Custom CSS Selector
        </label>
        <div class="dipi_popup-sub-val-container" >
            <input class="dipi_popup-sub-val" 
                type="text"
                name="trigger_manual-custom_css_selector"
                value="<?php echo esc_attr($trigger_manual_custom_css_selector); ?>"
            />
            <p class="dipi_popup-sub-descr">CSS selector trigger</p>
        </div>
    </div>
    <div class="dipi_popup-sub">
        <label
            for="trigger-closing_css_selector"
            class="dipi_popup-sub-lbl"
        >
            Closing CSS Selector
        </label>
        <div class="dipi_popup-sub-val-container" >
            <input class="dipi_popup-sub-val" 
                type="text"
                name="trigger-closing_css_selector"
                value="<?php echo esc_attr($trigger_closing_css_selector); ?>"
            />
            <p class="dipi_popup-sub-descr">CSS selector to close popup</p>
        </div>
    </div>
    <div class="dipi_popup-sub">
        <label
            for="trigger-remove_link"
            class="dipi_popup-sub-lbl"
        >
            Remove Link
        </label>
        <div class="dipi_popup-sub-val-container raido" >
            <div class="dipi-popup-toggle__button">
                <input
                    type="hidden"
                    name="trigger-remove_link"
                    value = "false"
                >
                <input
                    class="dipi-popup-toggle__switch"
                    type="checkbox"
                    name="trigger-remove_link"
                    value = "true"
                    <?php if ( $trigger_remove_link  === 'true') { ?> checked<?php } ?>
                >
                <div class="dipi-popup-toggle__slider"></div>
                <label class="for-checked">Yes</label>  
                <label class="for-unchecked">No</label>
            </div>
            <p class="dipi_popup-sub-descr">Remove link from element with selector</p>
        </div>
    </div>
    <div class="dipi_popup-sub">
        <label
            for="trigger-close_on_bg"
            class="dipi_popup-sub-lbl"
        >
            Close on Overlay Click
        </label>
        <div class="dipi_popup-sub-val-container raido" >
            <div class="dipi-popup-toggle__button">
                <input
                    type="hidden"
                    name="trigger-close_on_bg"
                    value = "false"
                >
                <input
                    class="dipi-popup-toggle__switch"
                    type="checkbox"
                    name="trigger-close_on_bg"
                    value = "true"
                    <?php if ( $trigger_close_on_bg  === 'true') { ?> checked<?php } ?>
                >
                <div class="dipi-popup-toggle__slider"></div>
                <label class="for-checked">Yes</label>  
                <label class="for-unchecked">No</label>
            </div>
            <p class="dipi_popup-sub-descr">Close popup when user click the background overlay</p>
        </div>
    </div>
    <div class="dipi_popup-sub">
        <label for="dipi_custom_hide_close_btn" class="dipi_popup-sub-lbl">
            Clickable Under Overlay
        </label>
        <div class="dipi_popup-sub-val-container raido" >
            <!--div class="dipi_popup-sub-val-radio-grp">
                <div class="dipi_popup-sub-val-radio-container">
                    <input
                        type="radio"
                        name="dipi_custom_clickable_under_overlay"
                        value="true"
                        <?php if ( $dipi_custom_clickable_under_overlay == 'true' ) { ?> checked<?php } ?>
                    >
                    <label>Yes</label>      
                </div>
                <div class="dipi_popup-sub-val-radio-container">
                    <input type="radio"
                        name="dipi_custom_clickable_under_overlay"
                        value="false"
                        <?php if ( $dipi_custom_clickable_under_overlay == 'false' ) { ?> checked<?php } ?>
                    >
                    <label>No</label>
                </div>
            </div-->
            <div class="dipi-popup-toggle__button">
                <input
                    type="hidden"
                    name="dipi_custom_clickable_under_overlay"
                    value = "false"
                >
                <input
                    class="dipi-popup-toggle__switch"
                    type="checkbox"
                    name="dipi_custom_clickable_under_overlay"
                    value = "true"
                    <?php if ( $dipi_custom_clickable_under_overlay  === 'true') { ?> checked<?php } ?>
                >
                <div class="dipi-popup-toggle__slider"></div>
                <label class="for-checked">Yes</label>  
                <label class="for-unchecked">No</label>
            </div>
            <p class="dipi_popup-sub-descr">Make website elements clickable when popup is opened</p>
        </div>
    </div>
    <div class="dipi_popup-sub">
        <label
            for="trigger-hide_popup_slug"
            class="dipi_popup-sub-lbl"
        >
            Hide Popup Slug in URL
        </label>
        <div class="dipi_popup-sub-val-container raido" >
            <div class="dipi-popup-toggle__button">
                <input
                    type="hidden"
                    name="trigger-hide_popup_slug"
                    value = "false"
                >
                <input
                    class="dipi-popup-toggle__switch"
                    type="checkbox"
                    name="trigger-hide_popup_slug"
                    value = "true"
                    <?php if ( $trigger_hide_popup_slug  === 'true') { ?> checked<?php } ?>
                >
                <div class="dipi-popup-toggle__slider"></div>
                <label class="for-checked">Yes</label>  
                <label class="for-unchecked">No</label>
            </div>
            <p class="dipi_popup-sub-descr">Hide popup slug in URL when popup is opened</p>
        </div>
    </div>
    <div class="dipi_popup-sub">
        <label
            for="trigger-close_by_back_btn"
            class="dipi_popup-sub-lbl"
        >
            Close by Clicking Back Button
        </label>
        <div class="dipi_popup-sub-val-container raido" >
            <div class="dipi-popup-toggle__button">
                <input
                    type="hidden"
                    name="trigger-close_by_back_btn"
                    value = "false"
                >
                <input
                    class="dipi-popup-toggle__switch"
                    type="checkbox"
                    name="trigger-close_by_back_btn"
                    value = "true"
                    <?php if ( $trigger_close_by_back_btn  === 'true') { ?> checked<?php } ?>
                >
                <div class="dipi-popup-toggle__slider"></div>
                <label class="for-checked">Yes</label>  
                <label class="for-unchecked">No</label>
            </div>
            <p class="dipi_popup-sub-descr">Close popup when browser or mobile back button is clicked. <br/>
                Note: Hide Popup Slug in URL option must be disabled.
            </p>
        </div>
    </div>
    <div class="dipi_popup-sub">
        <label
            for="trigger-prev_page_scrolling"
            class="dipi_popup-sub-lbl"
        >
            Prevent Page Scrolling
        </label>
        <div class="dipi_popup-sub-val-container raido" >
            <!--div class="dipi_popup-sub-val-radio-grp">
                <div class="dipi_popup-sub-val-radio-container">
                    <input
                        type="radio"
                        name="trigger-prev_page_scrolling"
                        value="true"
                        <?php if ( $trigger_prevent_page_scrolling === 'true' ) { ?> checked<?php } ?>
                    >
                    <label>Yes</label>      
                </div>
                <div class="dipi_popup-sub-val-radio-container">
                    <input type="radio"
                        name="trigger-prev_page_scrolling"
                        value="false"
                        <?php if ( $trigger_prevent_page_scrolling === 'false' ) { ?> checked<?php } ?>
                    >
                    <label>No</label>
                </div>
            </div-->
            <div class="dipi-popup-toggle__button">
                <input
                    type="hidden"
                    name="trigger-prev_page_scrolling"
                    value = "false"
                >
                <input
                    class="dipi-popup-toggle__switch"
                    type="checkbox"
                    name="trigger-prev_page_scrolling"
                    value = "true"
                    <?php if ( $trigger_prevent_page_scrolling  === 'true') { ?> checked<?php } ?>
                >
                <div class="dipi-popup-toggle__slider"></div>
                <label class="for-checked">Yes</label>  
                <label class="for-unchecked">No</label>
            </div>
            <p class="dipi_popup-sub-descr">Prevent Page Scrolling</p>
        </div>
    </div>
</div>