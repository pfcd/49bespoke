<?php
    global $wp_roles; // phpcs:ignore
    if ( ! isset( $wp_roles ) )
        $wp_roles = new WP_Roles(); // phpcs:ignore
    $user_role_selected = false;
    $locations_user_roles_all = get_post_meta(
        $post->ID, "locations_user_roles-all", true
    );
    $locations_user_roles_guest = get_post_meta(
        $post->ID, "locations_user_roles_guest", true
    );
    if ($locations_user_roles_guest === "on") {
        $user_role_selected = true;
    } else {
        foreach ($wp_roles->role_names as $wp_role_key=> $wp_role_value) {
            if ( get_post_meta($post->ID,"locations_user_roles_$wp_role_key", true ) === "on" ) {
                $user_role_selected = true;
                break;
            }
        }
    }
            
    if (empty($locations_user_roles_all) && !$user_role_selected) {
        $locations_user_roles_all = 'on';
    }
?>
<div class="dipi_popup-sub">
    <label for="locations_user_roles" class="dipi_popup-sub-lbl">
        User roles
    </label>    
    <div class="dipi_popup-sub-val-container" >
        <div class="dipi_popup-sub-val-radio-grp tag-style">
            <div
                class="dipi_popup-sub-val-radio-container<?php if ( $locations_user_roles_all === "on" ) { ?> allchecked<?php } ?>">
                <input
                    type="checkbox"
                    class="allcheckbox"
                    name="locations_user_roles-all"
                    <?php if ( $locations_user_roles_all === "on" ) { ?> checked<?php } ?>
                >
                <label>All user roles</label>
            </div>
            <div
                class="dipi_popup-sub-val-radio-container">
                <input
                    type="checkbox"
                    class="guestcheckbox"
                    name="locations_user_roles_guest"
                    <?php if ( get_post_meta( $post->ID, "locations_user_roles_guest", true ) === "on" ) { ?> checked<?php } ?>
                >
                <label>Guest</label>
            </div>
            <?php
                foreach ($wp_roles->role_names as $wp_role_key=> $wp_role_value) {
            ?>
                <div class="dipi_popup-sub-val-radio-container">
                    <input
                        type="checkbox"
                        name="locations_user_roles_<?php echo esc_attr($wp_role_key)?>"
                        <?php if ( get_post_meta( $post->ID, "locations_user_roles_$wp_role_key", true ) === "on" ) { ?> checked<?php } ?>
                    >
                    <label><?php echo esc_attr($wp_role_value)?></label>
                </div>
            <?php
                }
            ?>
        </div>
    </div>
</div>
