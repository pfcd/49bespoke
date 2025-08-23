<?php
add_filter('et_builder_get_parent_modules', function($modules){
    foreach ($modules as $module_slug => $module) {
        if($module_slug === 'et_pb_video' && isset($module->fields_unprocessed)){
            $module->fields_unprocessed['src']['dynamic_content'] = 'url';
        }
    }
    return $modules;
});

add_filter('et_builder_get_parent_modules', 'dipi_conditional_module_display_et_builder_get_parent_modules');
function dipi_conditional_module_display_et_builder_get_parent_modules($modules)
{

    static $is_applied = false;
    if ($is_applied) {
        return $modules;
    }

    if (empty($modules)) {
        return $modules;
    }

    foreach ($modules as $module_slug => $module) {
        if (!isset($module->settings_modal_toggles) || !isset($module->fields_unprocessed)) {
            continue;
        }

        $toggles_list = $module->settings_modal_toggles;
        if (isset($toggles_list['custom_css']) && !empty($toggles_list['custom_css']['toggles'])) {
            $toggles_list['custom_css']['toggles']['dipi_conditional_module_display'] = array(
                'title' => esc_html__('Conditional Display', 'dipi-divi-pixel'),
                'priority' => 400,
            );
            $modules[$module_slug]->settings_modal_toggles = $toggles_list;
        }

        $fields = $module->fields_unprocessed;
        if (!empty($fields)) {
            $fields['dipi_enable_conditional_display'] = [
                'label' => esc_html__('Enable Conditional Display', 'dipi-divi-pixel'),
                'description' => esc_html__('If enabled, you can choose to show or hide this module based on the settings below.', 'dipi-divi-pixel'),
                'type' => 'yes_no_button',
                'option_category' => 'configuration',
                'default' => 'off',
                'default_on_front' => 'off',
                'tab_slug' => 'custom_css',
                'toggle_slug' => 'dipi_conditional_module_display',
                'options' => array(
                    'off' => esc_html__('Off', 'dipi-divi-pixel'),
                    'on' => esc_html__('On', 'dipi-divi-pixel'),
                ),
            ];

            $fields['dipi_conditional_display_type'] = [
                'label' => esc_html__('Show Module by', 'dipi-divi-pixel'),
                'description' => esc_html__('Based on the option you choose, a different type of conditional display logic can be used to decide whether or not to show this module.', 'dipi-divi-pixel'),
                'type' => 'select',
                'tab_slug' => 'custom_css',
                'toggle_slug' => 'dipi_conditional_module_display',
                'default' => 'login_status',
                'default_on_front' => 'login_status',
                'options' => array(
                    'login_status' => esc_html__('User Login Status', 'dipi-divi-pixel'),
                    'user_role' => esc_html__('User Role', 'dipi-divi-pixel'),
                ),
                'show_if' => [
                    'dipi_enable_conditional_display' => 'on',
                ],
            ];

            $fields['dipi_conditional_display_login_status'] = [
                'label' => esc_html__('Login Status', 'dipi-divi-pixel'),
                'description' => esc_html__('Based on the option you choose, this module will only be shown to logged in users or to users who are not logged in.', 'dipi-divi-pixel'),
                'type' => 'dipi_multiselect',
                'subtype' => 'radio',
                'tab_slug' => 'custom_css',
                'toggle_slug' => 'dipi_conditional_module_display',
                'options' => array(
                    'logged_in' => esc_html__('User is logged in', 'dipi-divi-pixel'),
                    'logged_out' => esc_html__('User is logged out', 'dipi-divi-pixel'),
                ),
                'show_if' => [
                    'dipi_enable_conditional_display' => 'on',
                    'dipi_conditional_display_type' => 'login_status',
                ],
            ];

            $fields['dipi_conditional_display_user_role'] = [
                'label' => esc_html__('User Role', 'dipi-divi-pixel'),
                'description' => esc_html__('Based on the option you choose, this module will only be shown to logged in users who have one of the selected roles assigned.', 'dipi-divi-pixel'),
                'type' => 'dipi_multiselect',
                'tab_slug' => 'custom_css',
                'toggle_slug' => 'dipi_conditional_module_display',
                'options' => dipi_conditional_display_get_user_role_options(),
                'show_if' => [
                    'dipi_enable_conditional_display' => 'on',
                    'dipi_conditional_display_type' => 'user_role',
                ],
            ];

            $modules[$module_slug]->fields_unprocessed = $fields;
        }
    }
    $is_applied = true;
    return $modules;
}

add_filter('et_module_shortcode_output', 'dipi_conditional_module_display_et_module_shortcode_output', 10, 3);
function dipi_conditional_module_display_et_module_shortcode_output($output, $render_slug, $module)
{
    if (function_exists('et_core_is_fb_enabled') && et_core_is_fb_enabled()) {
        return $output;
    }

    if ('et_pb_column' === $render_slug) {
        return $output;
    }

    if (!isset($module->props['dipi_enable_conditional_display']) || 'on' !== $module->props['dipi_enable_conditional_display']) {
        return $output;
    }

    if (!isset($module->props['dipi_conditional_display_type']) || '' === $module->props['dipi_conditional_display_type'] || 'login_status' === $module->props['dipi_conditional_display_type']) {

        //Make sure that one of the two options is actually checked. If not, we don't hide anything
        if (isset($module->props['dipi_conditional_display_login_status']) && '' !== $module->props['dipi_conditional_display_login_status']) {
            $login_status = str_replace('%22', '"', $module->props['dipi_conditional_display_login_status']);
            $login_status = json_decode($login_status, true);

            if (isset($login_status['logged_in']) && $login_status['logged_in'] === true) {
                return is_user_logged_in() ? $output : '';
            }

            if (isset($login_status['logged_out']) && $login_status['logged_out'] === true) {
                return !is_user_logged_in() ? $output : '';
            }
        }

    } else if (isset($module->props['dipi_conditional_display_type']) && 'user_role' === $module->props['dipi_conditional_display_type']) {

        //Make sure at least one of the roles is actually checked. If not, we don't hide anything
        if (isset($module->props['dipi_conditional_display_user_role']) && '' !== $module->props['dipi_conditional_display_user_role']) {
            
            $user_roles = str_replace('%22', '"', $module->props['dipi_conditional_display_user_role']);
            $user_roles = json_decode($user_roles, true);
            $user_roles = array_filter($user_roles, function ($value) {
                return $value;
            });

            if (!empty($user_roles)) {
                $user = wp_get_current_user();
                $has_role = false;

                foreach ($user_roles as $role => $enabled) {
                    if (in_array($role, (array) $user->roles)) {
                        $has_role = true;
                    }
                }

                return $has_role ? $output : '';
            }
        }

    }

    return $output;
}

add_filter('et_pb_module_shortcode_attributes', 'dipi_conditional_module_display_et_pb_module_shortcode_attributes', 10, 3);
function dipi_conditional_module_display_et_pb_module_shortcode_attributes($props, $attrs, $render_slug)
{
    if (!isset($props['dipi_enable_conditional_display']) && isset($attrs['dipi_enable_conditional_display'])) {
        $props['dipi_enable_conditional_display'] = $attrs['dipi_enable_conditional_display'];
    }
    if (!isset($props['dipi_conditional_display_type']) && isset($attrs['dipi_conditional_display_type'])) {
        $props['dipi_conditional_display_type'] = $attrs['dipi_conditional_display_type'];
    }
    if (!isset($props['dipi_conditional_display_login_status']) && isset($attrs['dipi_conditional_display_login_status'])) {
        $props['dipi_conditional_display_login_status'] = $attrs['dipi_conditional_display_login_status'];
    }
    if (!isset($props['dipi_conditional_display_user_role']) && isset($attrs['dipi_conditional_display_user_role'])) {
        $props['dipi_conditional_display_user_role'] = $attrs['dipi_conditional_display_user_role'];
    }
    return $props;
}

function dipi_conditional_display_get_user_role_options()
{
    global $wp_roles;
    $options = [];
    foreach ($wp_roles->roles as $key => $value) {
        $options[$key] = $value['name'];
    }
    return $options;
}