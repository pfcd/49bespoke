<?php
namespace DiviPixel;

class DIPI_Plugin
{
    private $admin;
    private $public;

    public function __construct()
    {
        $this->load_dependencies();

        $this->admin = new DIPI_Admin();
        $this->public = new DIPI_Public();

        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('divi_extensions_init', [$this, 'divi_extensions_init']);
        add_action('et_head_meta', [$this, 'wp_head']);
        add_action('manage_dipi_testimonial_posts_custom_column', [$this, 'custom_dipi_testimonial_column'], 5, 2);

        add_filter('manage_dipi_testimonial_posts_columns', [$this, 'set_custom_edit_dipi_testimonial_columns'], 5);
        add_filter('wp_prepare_attachment_for_js', [$this, 'prepare_attachment_for_js'], 10, 3);

        register_activation_hook(DIPI_PLUGIN_FILE, [$this, 'dipi_plugin_activate']);
        register_deactivation_hook(DIPI_PLUGIN_FILE, [$this, 'dipi_plugin_deactivate']);

        add_action('plugins_loaded', [$this, 'plugins_loaded']);
    }

    public function prepare_attachment_for_js($response, $attachment, $meta)
    {
        if ($response['mime'] == 'image/svg+xml') {
            $dimensions = $this->svg_dimensions(get_attached_file($attachment->ID));

            if ($dimensions) {
                $response = array_merge($response, $dimensions);
            }

            $possible_sizes = apply_filters('image_size_names_choose', array(
                'full' => __('Full Size'),
                'thumbnail' => __('Thumbnail'),
                'medium' => __('Medium'),
                'large' => __('Large'),
            ));

            $sizes = array();

            foreach ($possible_sizes as $size => $label) {
                $default_height = 2000;
                $default_width = 2000;

                if ('full' === $size && $dimensions) {
                    $default_height = $dimensions['height'];
                    $default_width = $dimensions['width'];
                }

                $sizes[$size] = array(
                    'height' => get_option("{$size}_size_w", $default_height),
                    'width' => get_option("{$size}_size_h", $default_width),
                    'url' => $response['url'],
                    'orientation' => 'portrait',
                );
            }

            $response['sizes'] = $sizes;
            $response['icon'] = $response['url'];
        }

        return $response;
    }

    private function svg_dimensions($svg)
    {
        $svg = @simplexml_load_file($svg);
        $width = 0;
        $height = 0;
        if ($svg) {
            $attributes = $svg->attributes();
            if (isset($attributes->width, $attributes->height) && is_numeric($attributes->width) && is_numeric($attributes->height)) {
                $width = floatval($attributes->width);
                $height = floatval($attributes->height);
            } elseif (isset($attributes->viewBox)) {
                $sizes = explode(' ', $attributes->viewBox);
                if (isset($sizes[2], $sizes[3])) {
                    $width = floatval($sizes[2]);
                    $height = floatval($sizes[3]);
                }
            } else {
                return false;
            }
        }

        return array(
            'width' => $width,
            'height' => $height,
            'orientation' => ($width > $height) ? 'landscape' : 'portrait',
        );
    }

    public function divi_extensions_init()
    {
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/divi-extension.php';
    }

    public function dipi_plugin_activate()
    {
        // if (!wp_next_scheduled('dipi_save_google_reviews_hook')) {
        //     wp_schedule_event(time(), 'twicedaily', 'dipi_save_google_reviews_hook');
        // }

        // if (!wp_next_scheduled('dipi_save_facebook_reviews_hook')) {
        //     wp_schedule_event(time(), 'twicedaily', 'dipi_save_facebook_reviews_hook');
        // }

        if (!wp_next_scheduled('dipi_check_license_status')) {
            wp_schedule_event(time(), 'twicedaily', 'dipi_check_license_status', [true]);
        }

        flush_rewrite_rules();
    }

    public function dipi_plugin_deactivate()
    {
        // wp_clear_scheduled_hook('dipi_save_google_reviews_hook');
        // wp_clear_scheduled_hook('dipi_save_facebook_reviews_hook');
        wp_clear_scheduled_hook('dipi_testimonial_google_review_callback');
        wp_clear_scheduled_hook('dipi_testimonial_facebook_review_callback');
        wp_clear_scheduled_hook('dipi_check_license_status');
        flush_rewrite_rules();
    }

    public function plugins_loaded()
    {
        //FIXME: Re-implement when instagram modules are release, check if backticks are problematic in sql: https://codex.wordpress.org/Creating_Tables_with_Plugins
        // $this->create_instagram_tables();
    }

    private function create_instagram_tables()
    {
        $version = DIPI_Settings::get_option('instagram_db_version');
        if ($version < 1) {
            global $wpdb;
            $table_name = $wpdb->prefix . "dipi_instagram_media";
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE $table_name (
                    media_id BIGINT NOT NULL,
                    account_id BIGINT NOT NULL,
                    parent_id BIGINT,
                    `timestamp` datetime NOT NULL,
                    caption TEXT,
                    media_type TEXT NOT NULL,
                    permalink TEXT NOT NULL,
                    media_url TEXT NOT NULL,
                    children_count INT DEFAULT 0,
                    PRIMARY KEY  (media_id,account_id)
                ) $charset_collate;";

            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
            dbDelta($sql);
            DIPI_Settings::update_option('instagram_db_version', 1);
        }
    }

    private function load_dependencies()
    {
        // Load the logging "framework" ;)
        require_once plugin_dir_path(__FILE__) . 'utils/logging.php';

        // Load Settings API so we can use it in admin.php as well as on the frontend
        require_once plugin_dir_path(__FILE__) . 'options/settings.php';
        require_once plugin_dir_path(__FILE__) . 'options/customizer.php';

        // Load admin and public areas
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/admin.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/public.php';

        if (!DIPI_Settings::get_option('disable_conditional_module_display')) {
            require_once plugin_dir_path(__FILE__) . 'partials/conditional-module-display.php';
        }

        // TODO: This is a backend only function, isn't it? If so, move to admin.php as we don't want to load that unnecessarily on the frontend
        if (!DIPI_Settings::get_option('md_faq')) {
            require_once plugin_dir_path(__FILE__) . 'modules/FAQ/cpt.php';
        }

        if (!DIPI_Settings::get_option('md_testimonial')) {
            require_once plugin_dir_path(__FILE__) . 'modules/Testimonial/hooks.php';
        }

        if (!DIPI_Settings::get_option('md_popup_maker')) {
            require_once plugin_dir_path(__FILE__) . 'modules/PopupMaker/includes/PopupMaker.php';
        }
        if (!DIPI_Settings::get_option('md_filterable_grid')) {
            require_once plugin_dir_path(__FILE__) . 'modules/FilterableGrid/CPTCategory.php';
        }
        if (!DIPI_Settings::get_option('md_filterable_gallery')) {
            require_once plugin_dir_path(__FILE__) . 'modules/FilterableGallery/MediaLibrary.php';
        }

        if (!DIPI_Settings::get_option('md_gravity_styler')) {
            require_once plugin_dir_path(__FILE__) . 'modules/GravityFormsStyler/utils.php';
            require_once plugin_dir_path(__FILE__) . 'modules/GravityFormsStyler/gf_buttons_hook.php';
        }

    }

    public function wp_head()
    {
        if (DIPI_Settings::get_option('hamburger_animation')) {
            include plugin_dir_path(dirname(__FILE__)) . 'includes/partials/global-hamburger-styles-partial.php';
        }

    }

    public function enqueue_scripts()
    {
        //TODO: Wenn die Option für custom hamburger an ist, hamburger script und style enqueuen
        if (DIPI_Settings::get_option('hamburger_animation')) {
            wp_enqueue_style("dipi_hamburgers_css", plugins_url('dist/vendor/css/hamburgers.min.css', constant('DIPI_PLUGIN_FILE')), [], "1.1.3", 'all');
            wp_enqueue_script("dipi_hamburgers_js");
            add_action('wp_footer', [$this, 'add_hamburger']);
        }

        //FIXME: Improve this to only load those scripts and styles on pages where Divi Builder is active. maybe there is a
        //way to check if vb is currently showing, either as VB on frontend or BB on backend
        if (is_admin() || dipi_is_vb()) {
            wp_enqueue_script('dipi_builder_utils');

            //Scripts which are used by modules in the Divi Builder also need to be enqueued in frontend (VB) and backend (Builder)
            wp_enqueue_script('easypiechart'); //For counter module, FIXME: should be automatically enqueued by counter script dependency
            wp_enqueue_script('dipi_masonry_gallery_public');
            wp_enqueue_script('dipi_filterable_grid_public');
            wp_enqueue_script('dipi_filterable_gallery_public');
            wp_enqueue_script('dipi_counter_public');
            wp_enqueue_script('dipi_timeline_public');
            wp_enqueue_script('dipi_countdown_public');
            wp_enqueue_script('dipi_text_highlighter_public');
            wp_enqueue_script('dipi_expanding_cta_public');
            wp_enqueue_script('dipi_jquery_magnify'); //for image magnify module
            wp_enqueue_script('dipi_morphext'); //for typing text module
            wp_enqueue_script('dipi_faq_public');
            wp_enqueue_script('dipi_swiper_module');
            wp_enqueue_script('dipi_advanced_tabs');
            wp_enqueue_script('dipi_lottie_icon_public');
            wp_enqueue_script('dipi_tile_scroll_public');
            wp_enqueue_script('dipi_selector_hook_public');
            wp_enqueue_script('dipi_parallax'); //for Parallax Images
            wp_enqueue_script('dipi_image_rotator_public');
            wp_enqueue_script('dipi_content_slider_public'); // for Content Slider
            wp_enqueue_script('dipi_table_maker_public'); // For Table Maker
            
            // Module styles which are needed in the Divi Builder
            wp_enqueue_style('dipi_pannellum'); //for panorama module
            wp_enqueue_style('dipi_swiper_module');

            wp_enqueue_style('dipi_swiper');
            wp_enqueue_style('dipi_videojs'); //for panorama module
            wp_enqueue_style('dipi_animate');
            wp_enqueue_style('dipi_magnify'); //for image maginfy module
            if (!DIPI_Settings::get_option('md_gravity_styler')) {
                //Shouldn't include dipi_gf_basic in Gravity Form Editor page of wp-admin.
                if (!(is_admin() && isset($_GET['page']) && $_GET['page'] === 'gf_edit_forms')) { // phpcs:ignore
                    wp_enqueue_style('dipi_gf_theme'); // for Gravity Forms Styler
                    wp_enqueue_style('dipi_gf_basic'); // for Gravity Forms Styler 
                    // GF theme styles
                    if ('orbital' == get_option( 'rg_gforms_default_theme' ) ) {
                        wp_enqueue_style('dipi_gf_theme_reset');
                        wp_enqueue_style('dipi_gf_theme_foundation');
                        wp_enqueue_style('dipi_gf_theme_framework');
                        wp_enqueue_style('dipi_gf_orbital_theme');
                    }
                    
                }
            }
        }
    }

    public function add_hamburger()
    {
        include plugin_dir_path(dirname(__FILE__)) . 'includes/partials/hamburger-styles-partial.php';
    }

    public function set_custom_edit_dipi_testimonial_columns($columns)
    {

        $columns['testimonial_name'] = esc_html__('Name', 'dipi-divi-pixel');
        $columns['testimonial_type'] = esc_html__('Type', 'dipi-divi-pixel');
        $columns['company_name'] = esc_html__('Company', 'dipi-divi-pixel');
        $columns['testimonial_star'] = esc_html__('Rating', 'dipi-divi-pixel');

        return $columns;

    }

    public function custom_dipi_testimonial_column($column, $post_id)
    {
        switch ($column) {
            case 'testimonial_name':
                echo esc_html(get_post_meta($post_id, 'testimonial_name', true));
                break;

            case 'testimonial_type':
                echo esc_html(get_post_meta($post_id, 'testimonial_type', true));
                break;

            case 'company_name':
                echo esc_html(get_post_meta($post_id, 'company_name', true));
                break;

            case 'testimonial_star':
                echo esc_html(get_post_meta($post_id, 'testimonial_star', true));
                break;
        }
    }

}

new DIPI_Plugin();
