<?php

namespace DiviPixel;

class DIPI_Settings_Page
{

    private $settings;
    private $library_layouts;

    public function __construct()
    {
        $this->settings = DIPI_Settings::instance();
        add_action('dipi_check_license_status', [$this, 'check_license_status'], 10, 1);
    }

    public function admin_menu()
    {
        if (dipi_is_theme('Divi')) {
            $dipi_divi = add_submenu_page(
                'et_divi_options',
                'Divi Pixel Options',
                'Divi Pixel',
                'manage_options',
                'divi_pixel_options',
                [$this, 'render_divi_pixel_options_page']
            );
            add_action('load-' . $dipi_divi, [$this, 'load_admin_scripts']);
        }
        
        if(dipi_is_theme('Extra')){
            $dipi_extra = add_submenu_page(
                'et_extra_options',
                'Divi Pixel Options',
                'Divi Pixel',
                'manage_options',
                'divi_pixel_options',
                [$this, 'render_divi_pixel_options_page']
            );   
            add_action('load-' . $dipi_extra, [$this, 'load_admin_scripts']);
        }
    }

    public function load_admin_scripts()
    {
        // TODO: Clean up scripts and apply proper depenceny tree
        wp_enqueue_media(); //Used for file uploads
        
        wp_enqueue_style("dipi_settings_page_styles", plugins_url('dist/admin/css/settings-page.min.css', constant('DIPI_PLUGIN_FILE')), [], "1.0.0", 'all');
        wp_enqueue_style("dipi_settings_page_menu_styles", plugins_url('dist/admin/css/menu-styles.min.css', constant('DIPI_PLUGIN_FILE')), [], "1.0.0", 'all');
        wp_enqueue_style("dipi_font", plugins_url('dist/admin/css/dipi-font.min.css', constant('DIPI_PLUGIN_FILE')), [], "1.0.0", 'all');
        wp_enqueue_style("dipi_preloaders", plugins_url('dist/vendor/css/loaders.min.css', constant('DIPI_PLUGIN_FILE')), [], "1.0.0", 'all');
        

        wp_enqueue_script("dipi_settings_page_js", plugins_url('dist/admin/js/settings-page.min.js', constant('DIPI_PLUGIN_FILE')), ["jquery", "dipi_hurkan_switch_js", "dipi_sticky_js"], "1.0.0", false);
        wp_enqueue_script("dipi_hurkan_switch_js", plugins_url('dist/vendor/js/hurkanSwitch.js', constant('DIPI_PLUGIN_FILE')), ["jquery"], "1.0.0", false);
        wp_enqueue_script("dipi_resizesensor_js", plugins_url('dist/vendor/js/ResizeSensor.js', constant('DIPI_PLUGIN_FILE')), ["jquery"], "3.2.0", false);
        
        wp_enqueue_script("dipi_sticky_js", plugins_url('dist/vendor/js/jquery.sticky-sidebar.min.js', constant('DIPI_PLUGIN_FILE')), ["jquery", "dipi_resizesensor_js"], "3.2.0", false);
        wp_enqueue_script("dipi_popper_js", plugins_url('dist/vendor/js/popper.min.js', constant('DIPI_PLUGIN_FILE')), [], "2.4.4", false);
        wp_enqueue_script("dipi_tippy_js", plugins_url('dist/vendor/js/tippy-bundle.umd.min.js', constant('DIPI_PLUGIN_FILE')), [], "6.2.6", false);
        $screen = get_current_screen();
        if ($screen->base == "divi_page_divi_pixel_options") {
            wp_enqueue_style("dipi_select2", plugins_url('dist/vendor/css/select2.min.css', constant('DIPI_PLUGIN_FILE')), [], "1.0.0", 'all');
            wp_enqueue_script("dipi_select2_js", plugins_url('dist/vendor/js/select2.min.js', constant('DIPI_PLUGIN_FILE')), ["jquery"], "4.0.12", false);
        }
        wp_localize_script("dipi_settings_page_js", 'dipi_settings', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonces' => [
                'reset_settings' => wp_create_nonce('dipi_reset_settings'),
                'reset_customizer_settings' => wp_create_nonce('dipi_reset_customizer_settings'),
                'activate_license' => wp_create_nonce('dipi_activate_license'),
                'deactivate_license' => wp_create_nonce('dipi_deactivate_license'),
                'export_settings' => wp_create_nonce('dipi_export_settings'),
                'import_settings' => wp_create_nonce('dipi_import_settings'),
                'dipi_layout_importer_activate' => wp_create_nonce('dipi_layout_importer_activate'),
                'dipi_layout_importer_delete' => wp_create_nonce('dipi_layout_importer_delete')
            ],
            'i18n' => [
                'confirm_reset_settings' => esc_html__('Are you sure you want to reset all settings to their default state?', 'dipi-divi-pixel'),
                'confirm_remove_insta_account' => esc_html__('Are you sure you want to remove this account?', 'dipi-divi-pixel'),
                'error_remove_insta_account' => esc_html__('Something went wrong. Please reload the page and try again.', 'dipi-divi-pixel'),
                'confirm_reset_customizer_settings' => esc_html__('Are you sure you want to reset all customizer settings to their default state?', 'dipi-divi-pixel'),
                'call_in_progress' => esc_html__('Another call is already in progress. Please wait till all background tasks have finished running before starting another task.', 'dipi-divi-pixel'),
            ],
        ]);
    }

    public function get_settings_section_id($tab, $section, $toggle)
    {
        $prefix = DIPI_Settings::settings_prefix();
        return "{$prefix}{$tab}_{$section}_{$toggle}";
    }

    public function register_settings()
    {
        //Register the WordPress settings section
        foreach ($this->settings->get_toggles() as $toggle_id => $toggle) {
            add_settings_section(
                $this->get_settings_section_id($toggle["tab"], $toggle["section"], $toggle_id),
                null,
                null,
                "divi_pixel_options"
            );
        }

        //Register all the settings fields
        foreach ($this->settings->get_fields() as $field_id => $field) {
            if (!isset($field['type']) || $field['type'] === 'skip') {
                continue;
            }

            $section = isset($field["section"]) ? $field["section"] : "";
            $toggle = isset($field["toggle"]) ? $field["toggle"] : "";
            add_settings_field(
                DIPI_Settings::settings_prefix() . $field_id,
                $field["label"],
                null,
                "divi_pixel_options",
                $this->get_settings_section_id($field["tab"], $section, $toggle),
                array_merge(["id" => $field_id], $field)
            );

            if (isset($field["sanitize_callback"]) && !empty($field["sanitize_callback"])) {
                register_setting(
                    "divi_pixel_options",
                    DIPI_Settings::settings_prefix() . $field_id,
                    ['sanitize_callback' => $field["sanitize_callback"]]
                );
            } else if ('checkbox' === $field['type']) {
                register_setting(
                    "divi_pixel_options",
                    DIPI_Settings::settings_prefix() . $field_id,
                    ['sanitize_callback' => [$this->settings, 'sanitize_checkbox']]
                );
            } else {
                register_setting(
                    "divi_pixel_options",
                    DIPI_Settings::settings_prefix() . $field_id
                );
            }
        }
    }

    public function render_divi_pixel_options_page()
    {
        $settings_page = $this;
        include plugin_dir_path(__FILE__) . 'partials/settings-page-instagram-api-callback.php';
        include plugin_dir_path(__FILE__) . 'partials/settings-page-partial.php';
    }

    public function reset_settings()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_key($_POST['nonce']), 'dipi_reset_settings')) {
            wp_send_json_error([
                "error" => esc_html__("Reset failed due to an invalid nonce. Please reload the page and try again.", 'dipi-divi-pixel'),
            ]);
        }

        if (!current_user_can('manage_options')) {
            wp_send_json_error([
                "error" => esc_html__("Reset failed due to insufficient user rights. Please contact your administrator.", 'dipi-divi-pixel'),
            ]);
        }

        $data = [
            'success_message' => esc_html__("The settings were resetted. We will now reload the page.", 'dipi-divi-pixel'),
        ];

        foreach (DIPI_Settings::instance()->get_fields() as $field_id => $field) {
            if ($field_id === 'license' || $field_id === 'license_status') {
                continue;
            }
            $data[DIPI_Settings::settings_prefix() . $field_id] = delete_option(DIPI_Settings::settings_prefix() . $field_id);
        }

        wp_send_json_success($data);
    }

    public function reset_customizer_settings()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_key($_POST['nonce']), 'dipi_reset_customizer_settings')) {
            wp_send_json_error([
                "error" => esc_html__("Reset failed due to an invalid nonce. Please reload the page and try again.", 'dipi-divi-pixel'),
            ]);
        }

        if (!current_user_can('manage_options')) {
            wp_send_json_error([
                "error" => esc_html__("Reset failed due to insufficient user rights. Please contact your administrator.", 'dipi-divi-pixel'),
            ]);
        }

        $data = [
            'success_message' => esc_html__("The customizer settings were resetted. Please reload the customizer to see the changes.", 'dipi-divi-pixel'),
        ];

        $fields = DIPI_Customizer::instance()->get_fields(); //.create_fields();
        $prefix = DIPI_Customizer::settings_prefix();

        foreach ($fields as $field_id => $field) {
            switch ($field['type']) {
                case 'border_radii':
                case 'padding':
                case 'margin':
                    //TODO: Maybe put this in function in Customizer_Quad_Control
                    $data["{$prefix}{$field_id}_1"] = delete_option("{$prefix}{$field_id}_1");
                    $data["{$prefix}{$field_id}_2"] = delete_option("{$prefix}{$field_id}_2");
                    $data["{$prefix}{$field_id}_3"] = delete_option("{$prefix}{$field_id}_3");
                    $data["{$prefix}{$field_id}_4"] = delete_option("{$prefix}{$field_id}_4");
                    break;
                default:
                    $data["{$prefix}{$field_id}"] = delete_option("{$prefix}{$field_id}");
            }
        }

        wp_send_json_success($data);
    }

    public function activate_license($is_scheduled = false)
    {
        if (!$is_scheduled && (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_key($_POST['nonce']), 'dipi_activate_license'))) {
            wp_send_json_error([
                "error" => esc_html__("Activation failed due to an invalid nonce. Please reload the page and try again.", 'dipi-divi-pixel'),
            ]);
        }

        if (!$is_scheduled && !current_user_can('manage_options')) {
            wp_send_json_error([
                "error" => esc_html__("Activation failed due to insufficient user rights. Please contact your administrator.", 'dipi-divi-pixel'),
            ]);
        }

        // Try to use just freshly entered license if possible, otherwise use the one from the settings
        if (isset($_POST['license']) && !empty($_POST['license']) && $_POST['license'] !== constant("DIPI_PASSWORD_MASK")) {
            $license = sanitize_key($_POST['license']);
        } else {
            $license = trim(DIPI_Settings::get_option('license'));
        }

        // Call the store api
        $response = wp_remote_post(
            constant('DIPI_STORE_URL'),
            [
                'timeout' => 15,
                'sslverify' => false,
                'body' => [
                    'edd_action' => 'activate_license',
                    'license' => $license,
                    'item_id' => constant('DIPI_ITEM_ID'),
                    'url' => home_url(),
                ],
            ]
        );

        if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {
            $message = is_wp_error($response) && !empty($response->get_error_message()) ?
            $response->get_error_message() :
            esc_html__('An error occurred, please try again.', 'dipi-divi-pixel');

            wp_send_json_error([
                "error" => $message,
            ]);
        }

        $license_data = json_decode(wp_remote_retrieve_body($response));

        $status = $license_data->license;
        if (false === $license_data->success && 'expired' === $license_data->error) {
            $status = 'expired';
        }

        DIPI_Settings::update_option('license', $license);
        DIPI_Settings::update_option('license_status', $status);
        DIPI_Settings::update_option('license_limit', $license_data->license_limit);
        DIPI_Settings::update_option('license_site_count', $license_data->site_count);

        switch ($status) {
            case 'valid':
                $message = esc_html__('License activated.', 'dipi-divi-pixel');
                break;
            case 'invalid':
                $message = esc_html__('License invalid.', 'dipi-divi-pixel');
                break;
            case 'expired':
                $message = esc_html__('License expired.', 'dipi-divi-pixel');
                break;
        }

        $data['license_status'] = $status;
        $data['success_message'] = $message;

        wp_send_json_success($data);
    }

    public function deactivate_license()
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_key($_POST['nonce']), 'dipi_deactivate_license')) {
            wp_send_json_error([
                "error" => esc_html__("Deactivation failed due to an invalid nonce. Please reload the page and try again.", 'dipi-divi-pixel'),
            ]);
        }

        if (!current_user_can('manage_options')) {
            wp_send_json_error([
                "error" => esc_html__("Deactivation failed due to insufficient user rights. Please contact your administrator.", 'dipi-divi-pixel'),
            ]);
        }

        // Try to use just freshly entered license if possible
        if (isset($_POST['license']) && !empty($_POST['license']) && $_POST['license'] !== constant("DIPI_PASSWORD_MASK")) {
            $license = sanitize_key($_POST['license']);
        } else {
            $license = trim(DIPI_Settings::get_option('license'));
        }

        // Call the store api
        $response = wp_remote_post(
            constant('DIPI_STORE_URL'),
            [
                'timeout' => 15,
                'sslverify' => false,
                'body' => [
                    'edd_action' => 'deactivate_license',
                    'license' => $license,
                    'item_id' => constant('DIPI_ITEM_ID'),
                    'url' => home_url(),
                ],
            ]
        );

        if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {
            $message = is_wp_error($response) && !empty($response->get_error_message()) ?
            $response->get_error_message() :
            esc_html__('An error occurred, please try again.', 'dipi-divi-pixel');

            wp_send_json_error([
                "error" => $message,
            ]);
        }

        DIPI_Settings::update_option('license', $license);
        DIPI_Settings::update_option('license_status', 'invalid');
        DIPI_Settings::update_option('license_limit', $license_data->license_limit);
        DIPI_Settings::update_option('license_site_count', $license_data->site_count);

        $data = [];
        $data['license_status'] = 'invalid';
        $data['success_message'] = esc_html__('License deactivated.', 'dipi-divi-pixel');
        wp_send_json_success($data);
    }

    public function check_license_status(){
        $license_status = DIPI_Settings::get_option('license_status');
        if($license_status !== 'valid'){
            dipi_info('Not checking license because of status: ' . $license_status);
            return;
        }

        $license = trim(DIPI_Settings::get_option('license'));

        // Call the store api
        $response = wp_remote_post(
            constant('DIPI_STORE_URL'),
            [
                'timeout' => 15,
                'sslverify' => false,
                'body' => [
                    'edd_action' => 'check_license',
                    'license' => $license,
                    'item_id' => constant('DIPI_ITEM_ID'),
                    'url' => home_url(),
                ],
            ]
        );

        if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {
            dipi_err("Failed to check license status");
            return;
        }

        $license_data = json_decode(wp_remote_retrieve_body($response));

        $status = $license_data->license;
        if (false === $license_data->success && 'expired' === $license_data->error) {
            $status = 'expired';
        }

        DIPI_Settings::update_option('license', $license);
        DIPI_Settings::update_option('license_status', $status);
        DIPI_Settings::update_option('license_limit', $license_data->license_limit);
        DIPI_Settings::update_option('license_site_count', $license_data->site_count);
    }

    public function export_settings()
    {
        if (empty($_POST['action']) || 'dipi_export_settings' != $_POST['action']) {
            return;
        }

        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_key($_POST['nonce']), 'dipi_export_settings')) {
            return;
        }

        if (!current_user_can('manage_options')) {
            return;
        }

        $settings = [];
        global $wpdb;

        $settings_prefix = DIPI_Settings::settings_prefix();
        $customizer_prefix = DIPI_Customizer::settings_prefix();

        if (isset($_POST['export_settings']) && 'on' === $_POST['export_settings']) {
            $results = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT o.option_name, o.option_value
                    FROM {$wpdb->prefix}options o
                    WHERE o.option_name LIKE %s
                    AND o.option_name NOT LIKE %s",
                    $settings_prefix . '%',
                    $customizer_prefix . '%'
                 ),
                 OBJECT
            );
            
            if ($results) {
                foreach ($results as $result) {
                    if ($settings_prefix . 'license' === $result->option_name || $settings_prefix . 'license_status' === $result->option_name) {
                        continue;
                    }
                    $settings[$result->option_name] = $result->option_value;
                }
            }
        }

        if (isset($_POST['export_customizer']) && 'on' === $_POST['export_customizer']) {
            $results = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT o.option_name, o.option_value
                    FROM {$wpdb->prefix}options o
                    WHERE o.option_name LIKE %s",
                    $customizer_prefix . '%'
                ),
                OBJECT
            );
            if ($results) {
                foreach ($results as $result) {
                    $settings[$result->option_name] = $result->option_value;
                }
            }
        }

        ignore_user_abort(true);
        nocache_headers();
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Disposition: attachment; filename=divi-pixel-settings-export-' . gmdate('m-d-Y') . '.json');
        header("Expires: 0");
        echo wp_json_encode($settings);
        exit;
    }

    public function import_settings()
    {
        if (empty($_POST['action']) || 'dipi_import_settings' != $_POST['action']) {
            return;
        }

        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_key($_POST['nonce']), 'dipi_import_settings')) {
            return;
        }

        if (!current_user_can('manage_options')) {
            return;
        }
        $exploded = isset($_FILES['dipi_import_file']['name']) ? explode('.', sanitize_file_name($_FILES['dipi_import_file']['name'])): '';
        $extension = end($exploded);

        if ($extension != 'json') {
            wp_die(esc_html__('Please upload a valid .json file', 'dipi-divi-pixel'));
        }

        // phpcs:ignore ET.Sniffs.ValidatedSanitizedInput -- This is file input.
        $import_file = isset($_FILES['dipi_import_file']['tmp_name'])? realpath($_FILES['dipi_import_file']['tmp_name']) : '';

        if (empty($import_file)) {
            wp_die(esc_html__('Please upload a file to import', 'dipi-divi-pixel'));
        }

        // Retrieve the settings from the file and convert the json object to an array.
        $settings = (array) json_decode(file_get_contents($import_file));

        foreach ($settings as $key => $value) {
            if (substr($key, 0, 5) !== "dipi_") {
                continue;
            }
            update_option($key, $value);
        }

        wp_safe_redirect(admin_url('admin.php?page=divi_pixel_options'));
        exit;
    }

    public function activate_layout_importer() {

        if (empty($_POST['action']) || 'dipi_layout_importer_activate' != $_POST['action']) {
            return;
        }

        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_key($_POST['nonce']), 'dipi_layout_importer_activate')) {
            return;
        }
       
        if(file_exists(WP_PLUGIN_DIR  . '/divi-pixel-layout-importer/dipi-layout-importer.php')) { 
            $this->activate_plugin('divi-pixel-layout-importer/dipi-layout-importer.php');
           
            return;
        } 
        
        global $wp_filesystem;
        WP_Filesystem();
        $wp_upload_dir = wp_upload_dir();
        if($wp_filesystem->is_dir($wp_upload_dir['basedir'] . '/divi-pixel-layout-importer')){
            $wp_filesystem->delete( $wp_upload_dir['basedir'] . '/divi-pixel-layout-importer' );
        }

        include_once( ABSPATH . 'wp-admin/includes/file.php' );
        include_once( ABSPATH . 'wp-admin/includes/misc.php' );
 
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
        $plugin_url = "https://www.divi-pixel.com/downloads/dp-layout-packs/divi-pixel-layout-importer.zip";
        $skin     = new \WP_Ajax_Upgrader_Skin();
        $upgrader = new \Plugin_Upgrader( $skin );
        $result   = $upgrader->install( $plugin_url );
        
        if($result === true){
            $this->activate_plugin('divi-pixel-layout-importer/dipi-layout-importer.php');
            wp_redirect(site_url('wp-admin/admin.php?page=divi_pixel_Layouts'));
        }
    }

    private function activate_plugin( $plugin ) {
        $current = get_option( 'active_plugins' );
        $plugin = plugin_basename( trim( $plugin ) );
   
        if ( !in_array( $plugin, $current ) ) {
            $current[] = $plugin;
            sort( $current );
            do_action( 'activate_plugin', trim( $plugin ) );
            update_option( 'active_plugins', $current );
            do_action( 'activate_' . trim( $plugin ) );
            do_action( 'activated_plugin', trim( $plugin) );
        }
    }
    
    public function remove_layout_importer() {
      
        if (empty($_POST['action']) || 'dipi_layout_importer_delete' != $_POST['action']) {
            return;
        }  
        if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_key($_POST['nonce']), 'dipi_layout_importer_delete')) {
            return;
        } 
        global $wp_filesystem;
        WP_Filesystem();
        if(file_exists(WP_PLUGIN_DIR  . '/divi-pixel-layout-importer/dipi-layout-importer.php') ) {
            $importer_dir = WP_PLUGIN_DIR  . '/divi-pixel-layout-importer';
            if ( $wp_filesystem->is_dir( $importer_dir ) ) {
                $wp_filesystem->delete( $importer_dir, true );
            }
        }
        $upload_dir = wp_upload_dir();
        if($wp_filesystem->is_dir($upload_dir['basedir'] . '/divi-pixel-layout-importer')){
            $wp_filesystem->delete( $upload_dir['basedir'] . '/divi-pixel-layout-importer' );
        }
    }

    public function render_ribbon($field) {
        if (isset($field["new"]) && $field["new"]) {
            echo sprintf('<div class="dipi_settings_option_ribbon dipi_settings_option_ribbon_new">%1$s</div>', esc_html__("New"));
        } else if (isset($field["coming_soon"]) && $field["coming_soon"]) {
            echo sprintf('<div class="dipi_settings_option_ribbon dipi_settings_option_ribbon_coming_soon">%1$s</div>', esc_html__("Coming Soon"));
        }
    }
    public function render_field($field_id, $field)
    {
        $id = DIPI_Settings::settings_prefix() . $field_id;

        //FIXME: this variable can be used in the different renderers to apply the default value.
        // But why should that matter now that DIPI_Settings::get_option always returns something
        // meaningful? Remove it and improve the renderers
        $default = false;
        if (isset($field['default'])) {
            $default = $field['default'];
        }

        $value = DIPI_Settings::get_option($field_id);

        $ribbon = "";
        if (isset($field["new"]) && $field["new"]) {
            $ribbon .= sprintf('<div class="dipi_settings_option_ribbon dipi_settings_option_ribbon_new">%1$s</div>', esc_html__("New"));
        } else if (isset($field["coming_soon"]) && $field["coming_soon"]) {
            $ribbon .= sprintf('<div class="dipi_settings_option_ribbon dipi_settings_option_ribbon_coming_soon">%1$s</div>', esc_html__("Coming Soon"));
        }

        //output the options wrapper with show_if attributes
        echo sprintf('<div class="dipi_settings_option visible" %1$s>', esc_attr($this->show_if_data_attrs($field_id, $field)));

        switch ($field['type']) {
            case 'text':
                include plugin_dir_path(dirname(__FILE__)) . 'admin/partials/setting-text-partial.php';
                break;
            case 'password':
                include plugin_dir_path(dirname(__FILE__)) . 'admin/partials/setting-password-partial.php';
                break;
            case 'license':
                include plugin_dir_path(dirname(__FILE__)) . 'admin/partials/setting-license-partial.php';
                break;
            case 'callback':
                include plugin_dir_path(dirname(__FILE__)) . 'admin/partials/setting-callback-partial.php';
                break;
            case 'checkbox':
                include plugin_dir_path(dirname(__FILE__)) . 'admin/partials/setting-checkbox-partial.php';
                break;
            case 'library_layout':
                include plugin_dir_path(dirname(__FILE__)) . 'admin/partials/setting-library-layout-partial.php';
                break;
            case 'multiple_buttons':
                include plugin_dir_path(dirname(__FILE__)) . 'admin/partials/setting-multiple-buttons-partial.php';
                break;
            case 'theme_customizer':
                include plugin_dir_path(dirname(__FILE__)) . 'admin/partials/setting-theme-customizer-partial.php';
                break;
            case 'select':
                include plugin_dir_path(dirname(__FILE__)) . 'admin/partials/setting-select-partial.php';
                break;
            case 'select2':
                include plugin_dir_path(dirname(__FILE__)) . 'admin/partials/setting-select2-partial.php';
                break;
            case 'preloaders':
                include plugin_dir_path(dirname(__FILE__)) . 'admin/partials/setting-preloaders-partial.php';
                break;
            case 'menu_styles':
                include plugin_dir_path(dirname(__FILE__)) . 'admin/partials/setting-menu-styles-partial.php';
                break;
            case 'button':
                include plugin_dir_path(dirname(__FILE__)) . 'admin/partials/setting-sync-button-partial.php';
                break;

            case 'file_upload':
                if (isset($field['file_type'])) {
                    switch ($field['file_type']) {
                        case 'image':
                            include plugin_dir_path(dirname(__FILE__)) . 'admin/partials/setting-image-upload-partial.php';
                            break;
                        default:
                            include plugin_dir_path(dirname(__FILE__)) . 'admin/partials/setting-image-upload-partial.php';
                            break;
                    }
                } else {
                    include plugin_dir_path(dirname(__FILE__)) . 'admin/partials/setting-image-upload-partial.php';
                }
                break;
        }

        //Close the options wrapper after including the actual options
        echo '</div><!-- .dipi_settings_option.dipi_row -->';
    }

    private function show_if_data_attrs($field_id, $field)
    {
        $data = [];
        $data[] = "data-field-id=$field_id";
        if (isset($field["show_if"])) {
            $dependsOn = [];
            foreach ($field["show_if"] as $key => $value) {
                $dependsOnValue = is_array($value) ? implode(",", $value) : $value;
                $data[] = "data-depends-on-$key=$dependsOnValue";
                $dependsOn[] = $key;
            }
            $dependsOn = implode(",", $dependsOn);
            $data[] = "data-depends-on=$dependsOn";
        }
        return implode(" ", $data);
    }

    public function get_library_layouts()
    {

        if (is_null($this->library_layouts)) {
            $this->library_layouts = [];

            global $wpdb;
            $results = $wpdb->get_results(
                "SELECT posts.ID as post_id, posts.post_title as post_title, terms.name as term_name
                FROM {$wpdb->prefix}term_taxonomy term_taxonomy
                JOIN {$wpdb->prefix}terms terms ON term_taxonomy.term_id = terms.term_id
                JOIN {$wpdb->prefix}term_relationships term_relationships ON term_taxonomy.term_taxonomy_id = term_relationships.term_taxonomy_id
                JOIN {$wpdb->prefix}posts posts ON term_relationships.object_id = posts.ID
                WHERE posts.post_type = 'et_pb_layout' AND term_taxonomy.taxonomy = 'layout_type'
                ORDER BY posts.post_title",
                OBJECT
            );

            foreach ($results as $result) {
                $this->library_layouts[$result->post_id] = [
                    'title' => $result->post_title,
                    'layout_type' => $result->term_name,
                ];
            }
        }

        return $this->library_layouts;
    }

    public function connect_insta_account_basic()
    {

        if (!isset($_REQUEST['nonce']) || !wp_verify_nonce(sanitize_key($_REQUEST['nonce']), "dipi_connect_insta_account_basic")) {
            wp_send_json_error(["error" => esc_html__("Invalid request. Please reload the page and try again.", 'dipi-divi-pixel')]);
        }

        //Load App ID
        $appId = DIPI_Settings::get_option('instagram_basic_app_id');
        if(!isset($appId) || empty($appId)){
            wp_send_json_error(["error" => esc_html__("App ID is missing. Please enter and save your App ID.", 'dipi-divi-pixel')]);
        }
        
        //Load App Secret
        $appSecret = DIPI_Settings::get_option('instagram_basic_app_secret');
        if(!isset($appSecret) || empty($appSecret)){
            wp_send_json_error(["error" => esc_html__("App Secret is missing. Please enter and save your App Secret.", 'dipi-divi-pixel')]);
        }

        //Load the URL to return to once we finished everything and got the token
        $returnUrl = admin_url('admin.php?page=divi_pixel_options');
        $returnUrl .= urlencode('&dipi_tab=settings&dipi_section=third_party_providers&dipi_toggle=settings_instagram_api_basic');

        //Build the state object we use on auth.divi-pixel.com        
        $state = wp_json_encode([
            'step' => 1,
            'returnUrl' => $returnUrl,
            'authType' => DIPI_INSTAGRAM_AUTH_TYPE_BASIC,
        ]);
        
        $url = sprintf(
            'https://api.instagram.com/oauth/authorize?client_id=%1$s&redirect_uri=%2$s&state=%3$s&scope=user_profile,user_media&response_type=code',
            $appId,
            DIPI_INSTAGRAM_REDIRECT_URL,
            urlencode($state)
        );

        //Return everything to JS
        wp_send_json_success([
            'url' => $url,
        ]);

    }
    public function connect_insta_account_graph()
    {

        if (!isset($_REQUEST['nonce']) || !wp_verify_nonce(sanitize_key($_REQUEST['nonce']), "dipi_connect_insta_account_graph")) {
            wp_send_json_error(["error" => esc_html__("Invalid request. Please reload the page and try again.", 'dipi-divi-pixel')]);
        }

        //Load App ID
        $appId = DIPI_Settings::get_option('instagram_graph_app_id');
        if(!isset($appId) || empty($appId)){
            wp_send_json_error(["error" => esc_html__("App ID is missing. Please enter and save your App ID.", 'dipi-divi-pixel')]);
        }
        
        //Load App Secret
        $appSecret = DIPI_Settings::get_option('instagram_graph_app_secret');
        if(!isset($appSecret) || empty($appSecret)){
            wp_send_json_error(["error" => esc_html__("App Secret is missing. Please enter and save your App Secret.", 'dipi-divi-pixel')]);
        }

        //Load the URL to return to once we finished everything and got the token
        $returnUrl = admin_url('admin.php?page=divi_pixel_options');
        $returnUrl .= urlencode('&dipi_tab=settings&dipi_section=third_party_providers&dipi_toggle=settings_instagram_api_graph');

        //Build the state object we use on auth.divi-pixel.com  
        $state = wp_json_encode([
            'step' => 1,
            'returnUrl' => $returnUrl,
            'authType' => DIPI_INSTAGRAM_AUTH_TYPE_GRAPH,
        ]);

        $url = sprintf(
            'https://www.facebook.com/v11.0/dialog/oauth?client_id=%1$s&redirect_uri=%2$s&state=%3$s&scope=pages_show_list,instagram_basic,instagram_manage_insights,instagram_manage_comments',
            $appId,
            DIPI_INSTAGRAM_REDIRECT_URL,
            urlencode($state)
        );
        //Return everything to JS
        wp_send_json_success([
            'url' => $url,
        ]);

    }

    public function delete_insta_account()
    {

        if (!isset($_REQUEST['nonce']) || !wp_verify_nonce(sanitize_key($_REQUEST['nonce']), "dipi_delete_insta_nonce")) {
            wp_send_json_error(["error" => esc_html__("Invalid nonce. Please reload the page and try again.", 'dipi-divi-pixel')]);
        }

        if (!isset($_REQUEST['account_id']) || empty($_REQUEST['account_id'])) {
            wp_send_json_error(["error" => esc_html__("Account does not exist.", 'dipi-divi-pixel')]);
        }

        $account_id = isset($_REQUEST['account_id'])? sanitize_key($_REQUEST['account_id']) : '';
        $account_type = isset($_REQUEST['account_type'])? sanitize_text_field($_REQUEST['account_type']) : '';

        if ($account_type == 'BASIC') {
            //TODO: Account aus DIPI Settings löschen
            //TODO: Datenbank Cache Tabelle leeren (oder über scheduler?)
            //TODO: Gecachte Bilder löschen (oder über Scheduler?)
            $instagram_accounts = DIPI_Settings::get_option('instagram_accounts');
            if(!isset($instagram_accounts[$account_id])) {
                wp_send_json_error(["error" => esc_html__("Account does not exist.", 'dipi-divi-pixel')]);
            }

            unset($instagram_accounts[$account_id]);
            DIPI_Settings::update_option('instagram_accounts', $instagram_accounts);

        } if ($account_type == 'GRAPH') {
            $facebook_accounts = DIPI_Settings::get_option('facebook_accounts');
            if(!isset($facebook_accounts[$account_id])) {
                wp_send_json_error(["error" => esc_html__("Account does not exist.", 'dipi-divi-pixel')]);
            }

            unset($facebook_accounts[$account_id]);
            DIPI_Settings::update_option('facebook_accounts', $facebook_accounts);
        } else {
            wp_send_json_error(["error" => sprintf(esc_html__("Unknown Account Type: %s.", 'dipi-divi-pixel'), $account_type)]);
        }
        
        wp_send_json_success([]);
        exit;
    }
}
