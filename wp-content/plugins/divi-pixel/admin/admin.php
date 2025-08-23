<?php

namespace DiviPixel;

class DIPI_Admin
{
    public static $instance = null;

    public function __construct()
    {
        if (DIPI_Settings::get_option('show_clear_divi_cache_in_adminbar')) {
            require_once plugin_dir_path(__FILE__) . 'features/clear-divi-static-css.php';
        }
        require_once plugin_dir_path(__FILE__) . 'metabox/metabox.php';
        require_once plugin_dir_path(__FILE__) . 'metabox/init.php';

        // Build the settings page and register all required hooks e. g. for ajax callbacks
        require_once plugin_dir_path(__FILE__) . 'settings-page.php';
        $settings_page = new DIPI_Settings_Page();
        add_action('admin_menu', [$settings_page, 'admin_menu'], 11);
        add_action("admin_init", [$settings_page, 'register_settings']);
        add_action('admin_init', [$settings_page, 'export_settings']);
        add_action('admin_init', [$settings_page, 'import_settings']);
        add_action('admin_init', [$settings_page, 'activate_layout_importer']);
        add_action('admin_init', [$settings_page, 'remove_layout_importer']);
        add_action('wp_ajax_dipi_connect_insta_account_basic', [$settings_page, 'connect_insta_account_basic']);
        add_action('wp_ajax_dipi_connect_insta_account_graph', [$settings_page, 'connect_insta_account_graph']);
        add_action('wp_ajax_dipi_delete_insta_account', [$settings_page, 'delete_insta_account']);
        add_action('wp_ajax_dipi_reset_settings', [$settings_page, 'reset_settings']);
        add_action('wp_ajax_dipi_reset_customizer_settings', [$settings_page, 'reset_customizer_settings']);
        add_action('wp_ajax_dipi_activate_license', [$settings_page, 'activate_license']);
        add_action('wp_ajax_dipi_deactivate_license', [$settings_page, 'deactivate_license']);
        add_action('wp_ajax_dipi_svg_attachment_url', [$this, 'wp_ajax_dipi_svg_attachment_url']);
        add_action("update_option_dipi_custom_map_marker", [$this, "update_option_dipi_custom_marker"], 10, 2);
        add_action("update_option_dipi_upload_custom_marker", [$this, "update_option_dipi_custom_marker"], 10, 2);
        add_action("update_option_dipi_custom_map_marker_anchor", [$this, "update_option_dipi_custom_marker"], 10, 2);
        add_action('upgrader_process_complete', [$this, 'update_theme_dipi_custom_marker'], 10, 2);

        if (dipi_is_theme('Divi')) {
            // Buld the Theme customizer UI
            require_once plugin_dir_path(__FILE__) . 'customizer/customizer-api.php';
            $customizer = DIPI_Customizer_API::instance();
            add_action('customize_register', [$customizer, 'customize_register']);
            add_action('customize_controls_enqueue_scripts', [$customizer, 'customizer_controls_enqueue_scripts']);
        }

        // Other Admin hooks
        add_action('init', [$this, 'init']);
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
        add_filter('upload_mimes', [$this, 'upload_mimes'], 9999);
        add_filter('wp_check_filetype_and_ext', [$this, 'wp_check_filetype_and_ext'], 10, 4);
        add_filter('et_pb_supported_font_formats', [$this, 'et_check_filetype_and_ext'], 1);
        add_filter('image_downsize', [$this, 'image_downsize'], 10, 3);
        add_filter('register_post_type_args', [$this, 'register_post_type_args'], 999, 2);
        add_filter('register_taxonomy_args', [$this, 'register_taxonomy_args'], 999, 3);
        add_action('admin_head-edit.php', [$this, 'sync_buttons']);

        // md_testimonial = hide testimonial module so true means hide and not load
        if (!DIPI_Settings::get_option('md_testimonial')) {
            // Ajax callbacks for buttons in post list
            add_action('wp_ajax_dipi_google_review', [$this, 'google_review_callback']);
            add_action('wp_ajax_dipi_facebook_review', [$this, 'facebook_review_callback']);
            // Scheduled Action Hook for wp_cron
            // add_action('dipi_save_google_reviews_hook', [$this, 'google_review_callback']);
            // add_action('dipi_save_facebook_reviews_hook', [$this, 'facebook_review_callback']);
        }

        if (!DIPI_Settings::get_option('hide_library_shortcodes')) {
            add_filter('manage_et_pb_layout_posts_columns', [$this, 'et_pb_layout_columns']);
            add_action('manage_et_pb_layout_posts_custom_column', [$this, 'et_pb_layout_column'], 10, 2);
        }
        add_shortcode('dipi_library_layout', [$this, 'dipi_library_layout']);

        if (!DIPI_Settings::get_option('hide_edit_in_vb')) {
            add_filter('post_row_actions', [$this, 'row_actions_edit_in_vb'], 10, 2);
            add_filter('page_row_actions', [$this, 'row_actions_edit_in_vb'], 10, 2);
        }

        require_once plugin_dir_path(__FILE__) . 'instagram-api.php';
        require_once plugin_dir_path(__FILE__) . 'instagram-basic-api.php';
        require_once plugin_dir_path(__FILE__) . 'instagram-graph-api.php';

        add_action('dipi_refresh_instagram_access_tokens', [$this, 'refresh_instagram_access_tokens']);
        add_action('wp_ajax_dipi_insta_grid', [$this, 'dipi_insta_grid']);
        add_action('wp_ajax_nopriv_dipi_insta_grid', [$this, 'dipi_insta_grid']);
        add_action('wp_ajax_dipi_insta_reset_cache', [$this, 'dipi_insta_reset_cache']);
        add_action('wp_ajax_nopriv_dipi_insta_reset_cache', [$this, 'dipi_insta_reset_cache']);

        if (!wp_next_scheduled('dipi_refresh_instagram_access_tokens')) {
            wp_schedule_event(time(), 'daily', 'dipi_refresh_instagram_access_tokens');
        }
        // if (!DIPI_Settings::get_option('md_instagram')) {
        // } else {
        //     wp_clear_scheduled_hook('dipi_refresh_instagram_access_tokens');
        // }
    }

    public function dipi_insta_grid()
    {
        // phpcs:disable
        //TODO: Check nonce for security
        // $nonce = $_POST['_wpnonce_name'];
        // if ( empty( $_POST ) || ! wp_verify_nonce( $nonce, 'my-nonce' ) ) {
        //     wp_send_json_error(); // sends json_encoded success=false
        // }

        $count = isset($_POST['count']) ? sanitize_text_field($_POST['count']) : '';
        $page = isset($_POST['page']) ? intval($_POST['page']) : '';
        $account_id = isset($_POST['account_id']) ? sanitize_text_field($_POST['account_id']) : '';
        // $media = DIPI_Instagram_Basic_API::instance()->get_media($_POST['account_id'], $count, $page);
        $media = DIPI_Instagram_Graph_API::instance()->get_media($account_id, $count, $page);
        if (!$media) {
            wp_send_json_error([
                'message' => 'Medien konnten nicht geladen werden',
            ]);
        }

        wp_send_json_success([
            'media' => $media,
            'count' => $count,
            'page' => $page,
        ]);
        // phpcs:enable
    }

    public function dipi_insta_reset_cache()
    {
        //TODO: Check nonce for security
        // $nonce = $_POST['_wpnonce_name'];
        // if ( empty( $_POST ) || ! wp_verify_nonce( $nonce, 'my-nonce' ) ) {
        //     wp_send_json_error(); // sends json_encoded success=false
        // }
        $deleted_rows = 0;
        $deleted_rows += DIPI_Instagram_Basic_API::instance()->reset_cache();
        $deleted_rows += DIPI_Instagram_Graph_API::instance()->reset_cache();
        wp_send_json_success([
            'deleted_rows' => $deleted_rows,
        ]);
    }

    public function refresh_instagram_access_tokens()
    {
        DIPI_Instagram_Basic_API::update_accounts();
        DIPI_Instagram_Graph_API::update_accounts();
    }

    public function row_actions_edit_in_vb($actions, $post)
    {

        if (function_exists('et_pb_is_pagebuilder_used') && et_pb_is_pagebuilder_used($post->ID)) {
            if ($post->post_status == 'publish') {
                $actions['edit_in_visual_builder'] = '<a href="' . get_permalink($post->ID) . '?et_fb=1">Edit in Visual Builder</a>';
            } elseif ($post->post_status == 'draft') {
                $actions['edit_in_visual_builder'] = '<a href="' . get_permalink($post->ID) . '&et_fb=1">Edit in Visual Builder</a>';
            }
        }

        return $actions;
    }

    public function dipi_library_layout($atts)
    {
        $atts = shortcode_atts(array('id' => ''), $atts);
        return do_shortcode('[et_pb_section global_module="' . $atts['id'] . '"][/et_pb_section]');
    }

    public function et_pb_layout_columns($columns)
    {
        $columns['shortcode'] = __('Shortcode', 'dipi-divi-pixel');
        return $columns;
    }

    public function et_pb_layout_column($column, $post_id)
    {
        if ($column == 'shortcode') {
            echo '[dipi_library_layout id="' . esc_html($post_id) . '"]';
        }
    }

    public function wp_ajax_dipi_svg_attachment_url()
    {
        // phpcs:disable
        if (isset($_REQUEST['attachmentID'])) {
            $attachmentID = isset($_REQUEST['attachmentID']) ? intval($_REQUEST['attachmentID']) : '';
            echo esc_url(wp_get_attachment_url($attachmentID));
        }
        die();
        // phpcs:enable
    }

    public function google_review_callback()
    {
        $g_api = new DIPI_Google_Review();
        $g_api->run();
        if (wp_doing_ajax()) {
            wp_die();
        }
    }

    public function facebook_review_callback()
    {
        $f_api = new DIPI_Facebook_Review();
        $f_api->run();
        if (wp_doing_ajax()) {
            wp_die();
        }
    }

    public function sync_buttons()
    {
        global $current_screen;

        $google_place_id = DIPI_Settings::get_option('google_place_id');
        $google_api_key = DIPI_Settings::get_option('google_api_key');
        $facebook_page_id = DIPI_Settings::get_option('facebook_page_id');
        $facebook_page_access_token = DIPI_Settings::get_option('facebook_page_access_token');

        if ('dipi_testimonial' != $current_screen->post_type) {
            return;
        }
        ?>
            <script type="text/javascript">
                jQuery(document).ready(function($){
                    jQuery(".wrap .page-title-action").after("<a id='dipi_facebook_button' class='page-title-action dipi-sync-button dipi-facebook-button'><?php echo esc_html__('Fetch Facebook Reviews', 'dipi-divi-pixel'); ?></a>");
                });
            </script>
            <script type="text/javascript">
                jQuery(document).ready(function($){
                    jQuery(".wrap .dipi-sync-button").after("<a id='dipi_google_button' class='page-title-action dipi-sync-button dipi-google-button'><?php echo esc_html__('Fetch Google Reviews', 'dipi-divi-pixel'); ?></a>");
                });
            </script>
            <?php
            if (empty($google_place_id) && empty($google_api_key)):
                    ?>
                        <style type="text/css">
                            #dipi_google_button {
                                display: none;
                            }
                        </style>
                    <?php
            endif;
                    ?>

                    <?php
            if (empty($facebook_page_id) && empty($facebook_page_access_token)):
                    ?>
                        <style type="text/css">
                            #dipi_facebook_button {
                                display: none;
                            }
                        </style>
                    <?php
            endif;
            ?>

            <?php
            if (empty($google_place_id) && empty($google_api_key) && empty($facebook_page_id) && empty($facebook_page_access_token)):
                    ?>
                        <script type="text/javascript">
                            jQuery(document).ready(function($){
                                jQuery(".wp-header-end").after("<div id='message' class='notice dipi-notice'><p>To fetch reviews from Facebook and Google Page, please enter the Facebook and Google APP detail in <a href='<?php echo esc_attr(admin_url('admin.php?page=divi_pixel_options', '')); ?>'>Divi Pixel Plugin Settings</a></p></div>");
                            });
                        </script>
                    <?php
            endif;
            ?>
            <style type="text/css">

                .wrap .dipi-notice {
                    margin-top: 20px;
                    border: 0px;
                    border-left: 4px solid #00a0d2;
                }
                .dipi-sync-button {
                    background: #ff4200 !important; border-color: #ff4200 !important; color: #fff !important;
                    transition: all .3s ease-in-out !important;
                    border-radius: 3px !important;
                }

                .dipi-sync-button:hover {
                    background:#FFF !important; border-color: #ff4200 !important; color: #ff4200 !important;
                    transition: all .3s ease-in-out !important;
                }

                .dipi-sync-disabled,
                .dipi-sync-disabled:hover {
                    cursor: not-allowed;
                    opacity: 0.5;
                    text-decoration: none;
                }
            </style>
        <?php
}

    public function admin_enqueue_scripts()
    {
        wp_enqueue_style("dipi_font", plugins_url('dist/admin/css/dipi-font.min.css', constant('DIPI_PLUGIN_FILE')), [], "1.0.0", 'all');
        wp_enqueue_style("dipi_admin_css", plugins_url('dist/admin/css/admin-styles.min.css', constant('DIPI_PLUGIN_FILE')), [], "1.0.0", 'all');
        wp_enqueue_script("dipi_admin_js", plugins_url('dist/admin/js/admin.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_tippy'], "1.0.0", false);

        wp_localize_script('dipi_admin_js', 'dipi_vars', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'google_nonce' => wp_create_nonce("dipi_google_nonce"),
            'facebook_nonce' => wp_create_nonce("dipi_facebook_nonce"),
        ]);
    }

    public function init()
    {
        $this->unregister_project_post_type();
    }

    public function register_post_type_args($args, $post_type)
    {
        $args = $this->rename_project_post_type($args, $post_type);
        $args = $this->rename_testimonial_post_type($args, $post_type);
        return $args;
    }

    public function register_taxonomy_args($args, $taxonomy, $object_type)
    {
        $args = $this->rename_project_taxonomy_type($args, $taxonomy, $object_type);
        $args = $this->rename_testimonial_taxonomy_type($args, $taxonomy, $object_type);
        return $args;
    }

    public function enqueue_scripts()
    {}

    public function image_downsize($out, $id)
    {
        $image_url = wp_get_attachment_url($id);
        $file_ext = pathinfo($image_url, PATHINFO_EXTENSION);

        if (!is_admin() || 'svg' !== $file_ext) {
            return false;
        }

        return array($image_url, null, null, false);
    }

    public function upload_mimes($mimes)
    {
        if (DIPI_Settings::get_option('ttf_upload')) {
            $mimes['ttf'] = 'font/ttf|application/font-ttf|application/x-font-ttf|application/octet-stream';
            $mimes['otf'] = 'font/otf|application/font-otf|application/x-font-otf|application/octet-stream';
            $mimes['woff'] = 'font/woff|application/font-woff|application/x-font-woff|application/octet-stream';
            $mimes['woff2'] = 'font/woff2|application/font-woff2|application/x-font-woff2|application/octet-stream';
        }

        if (DIPI_Settings::get_option('svg_upload')) {
            $mimes['svg'] = 'image/svg+xml';
        }

        $mimes['json'] = 'application/json';

        return $mimes;
    }
    public function et_check_filetype_and_ext($list) {
        if (DIPI_Settings::get_option('ttf_upload')) {
            return array_merge($list, ['otf', 'ttf', 'woff', 'woff2']);
        }else{
            return $list;
        }
    }

    /**
     * Since SVG can have multiple mimetypes, besides using the upload_mimes filter,
     * we also have to check the file extension in case svg mimetype is not image/svg+xml
     * but something else like image/svg or only svg.
     */
    public function wp_check_filetype_and_ext($checked, $file, $filename, $mimes)
    {
        if (DIPI_Settings::get_option('svg_upload') && !$checked['type']) {
            $wp_filetype = wp_check_filetype($filename, $mimes);
            $ext = $wp_filetype['ext'];
            $type = $wp_filetype['type'];
            $proper_filename = $filename;

            if ($type && 0 === strpos($type, 'image/') && $ext !== 'svg') {
                $ext = $type = false;
            }

            $checked = compact('ext', 'type', 'proper_filename');
        }

        if (true && !$checked['type']) {
            $wp_filetype = wp_check_filetype($filename, $mimes);
            $ext = $wp_filetype['ext'];
            $type = $wp_filetype['type'];
            $proper_filename = $filename;

            if ($type && $ext !== 'json') {
                $ext = $type = false;
            }

            $checked = compact('ext', 'type', 'proper_filename');
        }

        if (DIPI_Settings::get_option('ttf_upload')) {
            if (false !== strpos($filename, '.ttf')) {
                $checked['ext'] = 'ttf';
                $checked['type'] = 'font/ttf|application/font-ttf|application/x-font-ttf|application/octet-stream';
            }

            if (false !== strpos($filename, '.otf')) {
                $checked['ext'] = 'otf';
                $checked['type'] = 'font/otf|application/font-otf|application/x-font-otf|application/octet-stream';
            }

            if (false !== strpos($filename, '.woff')) {
                $checked['ext'] = 'woff';
                $checked['type'] = 'font/woff|application/font-woff|application/x-font-woff|application/octet-stream';
            }
            if (false !== strpos($filename, '.woff2')) {
                $checked['ext'] = 'woff2';
                $checked['type'] = 'font/woff2|application/font-woff2|application/x-font-woff2|application/octet-stream';
            }
        }

        return $checked;
    }

    public function unregister_project_post_type()
    {
        if (DIPI_Settings::get_option('hide_projects')) {
            unregister_post_type('project');
        }
    }

    public function rename_project_post_type($args, $post_type)
    {
        if (!DIPI_Settings::get_option('rename_projects')) {
            return $args;
        }

        $dipi_rename_projects_singular = DIPI_Settings::get_option('rename_projects_singular');
        $dipi_rename_projects_plural = DIPI_Settings::get_option('rename_projects_plural');
        $dipi_rename_projects_icon = DIPI_Settings::get_option('rename_projects_icon');

        $new_singular_name = (!empty($dipi_rename_projects_singular)) ? $dipi_rename_projects_singular : 'Project';
        $new_plural_name = (!empty($dipi_rename_projects_plural)) ? $dipi_rename_projects_plural : 'Projects';

        $new_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower(DIPI_Settings::get_option('rename_projects_slug')));

        if ('project' == $post_type) {
            $args['labels']['name'] = $new_plural_name;
            $args['labels']['singular_name'] = $new_singular_name;
            $args['labels']['menu_name'] = $new_plural_name;
            $args['labels']['name_admin_bar'] = $new_singular_name;
            $args['labels']['add_new_item'] = 'Add New ' . $new_singular_name;
            $args['labels']['edit_item'] = 'Edit ' . $new_singular_name;
            $args['labels']['view_item'] = 'View ' . $new_singular_name;
            $args['labels']['search_items'] = 'Search ' . $new_plural_name;
            $args['labels']['all_items'] = 'All ' . $new_plural_name;
            $args['rewrite']['slug'] = $new_slug;
            if (!empty($dipi_rename_projects_icon)) {
                $args['menu_icon'] = $dipi_rename_projects_icon;
            }
            flush_rewrite_rules();
        }

        return $args;
    }

    public function rename_project_taxonomy_type($args, $taxonomy, $object_type)
    {

        if (!DIPI_Settings::get_option('rename_projects')) {
            return $args;
        }

        $dipi_rename_projects_singular = DIPI_Settings::get_option('rename_projects_singular');
        $dipi_rename_projects_plural = DIPI_Settings::get_option('rename_projects_plural');
        $dipi_rename_projects_cat_slug = DIPI_Settings::get_option('rename_projects_cat_slug');
        $dipi_rename_projects_tag_slug = DIPI_Settings::get_option('rename_projects_tag_slug');

        $new_project_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower(DIPI_Settings::get_option('rename_projects_slug')));
        $new_cat_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower(DIPI_Settings::get_option('rename_projects_cat_slug')));
        $new_tag_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower(DIPI_Settings::get_option('rename_projects_tag_slug')));

        $new_singular_name = (!empty($dipi_rename_projects_singular)) ? $dipi_rename_projects_singular : 'Project';
        $new_plural_name = (!empty($dipi_rename_projects_plural)) ? $dipi_rename_projects_plural : 'Projects';

        if ('project_category' === $taxonomy) {
            if (!empty($new_cat_slug)) {
                $args['rewrite']['slug'] = $new_cat_slug;
            } else {
                $args['rewrite']['slug'] = $new_project_slug . '_category';
            }
            $args['labels']['singular_name'] = $new_singular_name . ' Category';
            $args['labels']['name'] = $new_plural_name . ' Categories';
        }

        if ('project_tag' == $taxonomy) {
            if (!empty($new_tag_slug)) {
                $args['rewrite']['slug'] = $new_tag_slug;
            } else {
                $args['rewrite']['slug'] = $new_project_slug . '_tag';
            }
            $args['labels']['name'] = $new_plural_name . ' Tags';
            $args['labels']['singular_name'] = $new_singular_name . ' Tag';
        }

        return $args;
    }

    public function rename_testimonial_post_type($args, $post_type)
    {

        if (!DIPI_Settings::get_option('rename_testimonials')) {
            return $args;
        }

        $dipi_rename_testimonials_singular = DIPI_Settings::get_option('rename_testimonials_singular');
        $dipi_rename_testimonials_plural = DIPI_Settings::get_option('rename_testimonials_plural');

        $new_singular_name = (!empty($dipi_rename_testimonials_singular)) ? $dipi_rename_testimonials_singular : 'testimonial';
        $new_plural_name = (!empty($dipi_rename_testimonials_plural)) ? $dipi_rename_testimonials_plural : 'testimonials';

        $new_slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower(DIPI_Settings::get_option('rename_testimonials_slug')));

        if ('dipi_testimonial' == $post_type) {
            $args['labels']['name'] = $new_plural_name;
            $args['labels']['singular_name'] = $new_singular_name;
            $args['labels']['menu_name'] = $new_plural_name;
            $args['labels']['name_admin_bar'] = $new_singular_name;
            $args['labels']['add_new_item'] = 'Add New ' . $new_singular_name;
            $args['labels']['edit_item'] = 'Edit ' . $new_singular_name;
            $args['labels']['view_item'] = 'View ' . $new_singular_name;
            $args['labels']['search_items'] = 'Search ' . $new_plural_name;
            $args['labels']['all_items'] = 'All ' . $new_plural_name;
            $args['rewrite']['slug'] = $new_slug;
            flush_rewrite_rules();
        }

        return $args;
    }

    public function rename_testimonial_taxonomy_type($args, $taxonomy, $object_type)
    {

        if (!DIPI_Settings::get_option('rename_testimonials')) {
            return $args;
        }

        $dipi_rename_testimonials_singular = DIPI_Settings::get_option('rename_testimonials_singular');
        $dipi_rename_testimonials_plural = DIPI_Settings::get_option('rename_testimonials_plural');

        $new_singular_name = (!empty($dipi_rename_testimonials_singular)) ? $dipi_rename_testimonials_singular : 'testimonial';
        $new_plural_name = (!empty($dipi_rename_testimonials_plural)) ? $dipi_rename_testimonials_plural : 'testimonials';

        if ('testimonial_category' == $taxonomy) {
            $args['labels']['name'] = $new_plural_name . ' Categories';
            $args['labels']['singular_name'] = $new_singular_name . ' Category';
        }

        if ('testimonial_tag' == $taxonomy) {
            $args['labels']['name'] = $new_plural_name . ' Tags';
            $args['labels']['singular_name'] = $new_singular_name . ' Tag';
        }

        return $args;
    }

    private function load_wp_filesystem()
    {
        include_once ABSPATH . 'wp-admin/includes/file.php';
        if (!function_exists('WP_Filesystem')) {
            dipi_err("WP_Filesystem Filesystem does not exist. Aborting.");
            return;
        }
        WP_filesystem();
    }

    public function update_option_dipi_custom_marker()
    {
        if (DIPI_Settings::get_option('custom_map_marker')) {
            $this->setup_custom_map_marker();
        } else {
            $this->restore_default_map_marker();
        }
    }

    public function update_theme_dipi_custom_marker($upgrader_object, $options)
    {
        if ($options['action'] == 'update' && $options['type'] == 'theme' && DIPI_Settings::get_option('custom_map_marker')) {
            $this->setup_custom_map_marker();
        }
    }

    private function setup_custom_map_marker()
    {
        $image_url = DIPI_Settings::get_option('upload_custom_marker');
        if (!isset($image_url) || '' === $image_url) {
            dipi_info("No image url. Not setting up map marker");
            return;
        }

        $this->copy_map_marker($image_url);
        $image_size = getimagesize($image_url);

        if (!$image_size || !is_array($image_size)) {
            dipi_info("Marker has no size. Aborting. Url was " . $image_url);
            dipi_info($image_size, true);
            return;
        }

        $width = $image_size[0];
        $height = $image_size[1];

        $anchor = DIPI_Settings::get_option('custom_map_marker_anchor', 'bottom_center');

        switch ($anchor) {
            case 'top_left':
                $anchorX = 0;
                $anchorY = 0;
                $anchorPointX = intval($width / 2);
                $anchorPointY = 0;
                break;
            case 'top_center':
                $anchorX = intval($width / 2);
                $anchorY = 0;
                $anchorPointX = 0;
                $anchorPointY = 0;
                break;
            case 'top_right':
                $anchorX = $width;
                $anchorY = 0;
                $anchorPointX = -intval($width / 2);
                $anchorPointY = 0;
                break;
            case 'center_left':
                $anchorX = 0;
                $anchorY = intval($height / 2);
                $anchorPointX = intval($width / 2);
                $anchorPointY = -intval($height / 2);
                break;
            case 'center_center':
                $anchorX = intval($width / 2);
                $anchorY = intval($height / 2);
                $anchorPointX = 0;
                $anchorPointY = -intval($height / 2);
                break;
            case 'center_right':
                $anchorX = $width;
                $anchorY = intval($height / 2);
                $anchorPointX = -intval($width / 2);
                $anchorPointY = -intval($height / 2);
                break;
            case 'bottom_left':
                $anchorX = 0;
                $anchorY = $height;
                $anchorPointX = intval($width / 2);
                $anchorPointY = -$height;
                break;
            case 'bottom_center':
                $anchorX = intval($width / 2);
                $anchorY = $height;
                $anchorPointX = 0;
                $anchorPointY = -$height;
                break;
            case 'bottom_right':
                $anchorX = $width;
                $anchorY = $height;
                $anchorPointX = -intval($width / 2);
                $anchorPointY = -$height;
                break;
            default:
                $anchorX = 0;
                $anchorY = 0;
                $anchorPointX = 0;
                $anchorPointY = 0;
        }

        $this->adjust_marker_size_and_anchor_in_files(
            $width,
            $height,
            $anchorX,
            $anchorY,
            $anchorPointX,
            $anchorPointY
        );
    }

    private function restore_default_map_marker()
    {
        dipi_info("Restoing original marker size");
        $image_url = plugin_dir_path(__FILE__) . 'assets/marker.png';
        $this->copy_map_marker($image_url);

        $width = 46;
        $height = 43;
        $anchorX = 16;
        $anchorY = 43;
        $anchorPointX = 0;
        $anchorPointY = -45;

        $this->adjust_marker_size_and_anchor_in_files(
            $width,
            $height,
            $anchorX,
            $anchorY,
            $anchorPointX,
            $anchorPointY
        );
    }

    private function copy_map_marker($image_url)
    {
        $destination = get_template_directory() . '/includes/builder/images/marker.png';
        $this->load_wp_filesystem();
        global $wp_filesystem;
        if (!$image_url) {
            dipi_err("Invalid Image URl.");
            return;
        }
        if ($wp_filesystem->exists($destination)) {
            $wp_filesystem->delete($destination);
        }
        $wp_filesystem->copy($image_url, $destination);
    }

    private function adjust_marker_size_and_anchor_in_files($width, $height, $anchorX, $anchorY, $anchorPointX, $anchorPointY)
    {
        $scripts = [
            get_template_directory() . '/js/scripts.min.js',
            get_template_directory() . '/js/custom.min.js', //Older Divi versions
            get_template_directory() . '/js/custom.unified.js',
            get_template_directory() . '/includes/builder/scripts/builder.js',
            get_template_directory() . '/includes/builder/scripts/frontend-builder-scripts.js', //Older Divi versions
            get_template_directory() . '/includes/builder/frontend-builder/build/frontend-builder-scripts.js',
        ];

        foreach ($scripts as $script) {
            $this->adjust_marker_size_and_anchor(
                $script,
                $width,
                $height,
                $anchorX,
                $anchorY,
                $anchorPointX,
                $anchorPointY
            );
        }
    }

    private function adjust_marker_size_and_anchor($file_url, $width, $height, $anchorX, $anchorY, $anchorPointX, $anchorPointY)
    {
        $this->load_wp_filesystem();
        global $wp_filesystem;

        //Change the content of customizer.min.js with regex
        $file = $wp_filesystem->get_contents($file_url);

        if (!$file) {
            dipi_err("Failed to read file " . $file_url);
            return;
        }

        $file = preg_replace(
            '/anchor:\s*new google\.maps\.Point\(\s*?-?\d*\s*,\s*-?\d*\s*\)/i',
            'anchor:new google.maps.Point(' . $anchorX . ',' . $anchorY . ')',
            $file
        );

        $file = preg_replace(
            '/size:\s*new google\.maps\.Size\(\s*-?\d*\s*,\s*-?\d*\s*\)/i',
            'size:new google.maps.Size(' . $width . ',' . $height . ')',
            $file
        );

        $file = preg_replace(
            '/shape:\s*\{\s*coord:\s*\[\s*1\s*,\s*1\s*,\s*-?\d*\s*,\s*-?\d*\s*\],\s*type:\s*["\']rect["\']\s*\}/i',
            'shape:{coord:[1,1,' . $width . ',' . $height . '],type:"rect"}',
            $file
        );

        $file = preg_replace(
            '/anchorPoint:\s*new google\.maps\.Point\(\s*-?\d*\s*,\s*-?\d*\s*\)/i',
            'anchorPoint:new google.maps.Point(' . $anchorPointX . ',' . $anchorPointY . ')',
            $file
        );

        if (!$wp_filesystem->put_contents($file_url, $file, FS_CHMOD_FILE)) {
            dipi_err("Failed to write to file " . $file_url);
        }
    }

    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
