<?php

namespace DNWoo_Essential\Includes;

defined('ABSPATH') || die();

class Admin
{

    /**
     * Member Variable
     *
     * @var instance
     */
    private static $instance;

    /**
     *  Initiator
     */
    public static function get_instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    const MODULES_NONCE = 'dnwooe_save_admin';
    const SAVE_MODULE_ACTION = 'save_modules_data';
    const SAVE_FEATURES_ACTION = 'save_features_data';

    public function __construct()
    {
        add_action('admin_menu', array(__CLASS__, 'add_menu'), 21);
        add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueue_scripts'), 21);
        add_action('wp_ajax_' . self::SAVE_MODULE_ACTION, array(__CLASS__, 'save_modules_data'));
        add_action('wp_ajax_' . self::SAVE_FEATURES_ACTION, array(__CLASS__, 'save_features_data'));

        /**
         *
         * 3. the required plugin license action_hook start
         */
        add_action('admin_init', array(__CLASS__, 'dnwoo_essential_plugin_updater'), 0);
        add_action('admin_init', array(__CLASS__, 'dnwoo_essential_register_option'));
        add_action('admin_init', array(__CLASS__, 'dnwoo_essential_activate_license'));
        add_action('admin_init', array(__CLASS__, 'dnwoo_essential_deactivate_license'));
        add_action('admin_notices', array(__CLASS__, 'dnwoo_essential_admin_notices'));
        /**
         *
         * 3. the required plugin license action_hook end
         */
    }

    public static function add_menu()
    {

        add_menu_page(
            __('Woo Essential', 'dnwooe'),
            __('Woo Essential', 'dnwooe'),
            'manage_options',
            'dnwooe-essential',
            array(__CLASS__, 'render_main'),
            dnwoo_svg_icon(),
            111
        );

        /**
         *
         * 4. The required plugin license submenu start
         */
        add_submenu_page(
            'dnwooe-essential',
            __('Woo Essential License', 'dnwooe'),
            __('Woo Essential License', 'dnwooe'),
            'manage_options',
            DNWOO_ESSENTIAL_PLUGIN_LICENSE_PAGE,
            array(__CLASS__, 'render_license_page')
        );

        /**
         *
         * 4. The required plugin license submenu END
         */
    }

    public static function enqueue_scripts()
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        global $pagenow;

        if ('admin.php' == $pagenow && (isset($_GET['page']) && 'dnwooe-essential' === $_GET['page'])) {// phpcs:ignore WordPress.Security.NonceVerification.Recommended
            wp_enqueue_style(
                'dnwooe-admin',
                DNWOO_ESSENTIAL_ASSETS . 'admin/css/admin.css'
            );
        }

        wp_enqueue_script(
            'dnwooe-admin-js',
            DNWOO_ESSENTIAL_ASSETS . 'admin/js/admin.js',
            array('jquery'),
            DNWOO_ESSENTIAL_VERSION,
            true
        );

        wp_localize_script(
            'dnwooe-admin-js',
            'DNWoo_Essential',
            array(
                'ajaxurl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce(self::MODULES_NONCE),
                'action' => self::MODULES_NONCE,
            )
        );
    }

    public static function save_data($posted_data)
    {
        if (!current_user_can('manage_options')) {
            return;
        }
        if (!check_ajax_referer(self::MODULES_NONCE, 'nonce')) {
            wp_send_json_error();
        }
        $posted_data = isset($posted_data) ? filter_var(wp_unslash($posted_data), FILTER_SANITIZE_STRING) : '';
        $data = array();
        parse_str($posted_data, $data);
        return $data;
    }
    public static function save_features_data()
    {
        $features_data = isset($_POST['data']) ? $_POST['data'] : '';// phpcs:ignore 

        $data = self::save_data($features_data);

        $features = !empty($data['features']) ? $data['features'] : array();

        $inactive_features = array_values(array_diff(array_keys(self::get_features_map()), $features));

        self::save_inactive('features', $inactive_features);

        wp_send_json_success();
    }

    public static function save_modules_data()
    {
        $modules_data = isset($_POST['data']) ? $_POST['data'] : '';// phpcs:ignore 

        $data = self::save_data($modules_data);

        $modules = !empty($data['modules']) ? $data['modules'] : array();

        $inactive_modules = array_values(array_diff(array_keys(self::get_modules_map()), $modules));

        self::save_inactive('modules', $inactive_modules);
        wp_send_json_success();
    }

    public static function get_inactive($field)
    {
        return get_option('dnwooe_inactive_' . $field, array());
    }

    public static function save_inactive($field, $modules = array())
    {
        update_option('dnwooe_inactive_' . $field, $modules);
    }

    private static function get_free_modules_map()
    {

        return array(
            'dnwooe-woo-carousel' => array(
                'title' => __('Woo Product Carousel', 'dnwooe'),
                'desc' => __('Woo Product Carousel', 'dnwooe'),
                'demo' => 'https://www.wooessential.com/divi-woocommerce-product-carousel-module/',
                'icon' => DNWOO_ESSENTIAL_ICON . 'NextWooCarousel/icon.svg',
            ),
            'dnwooe-woo-grid' => array(
                'title' => __('Woo Product Grid', 'dnwooe'),
                'demo' => 'https://www.wooessential.com/divi-woocommerce-product-grid-module/',
                'icon' => DNWOO_ESSENTIAL_ICON . 'NextWooGrid/icon.svg',
            ),
            'dnwooe-woo-cat-carousel' => array(
                'title' => __('Woo Category Carousel', 'dnwooe'),
                'demo' => 'https://www.wooessential.com/divi-woocommerce-product-category-carousel-module/',
                'icon' => DNWOO_ESSENTIAL_ICON . 'NextWooCatCarousel/icon.svg',
            ),
            'dnwooe-woo-cat-grid' => array(
                'title' => __('Woo Category Grid', 'dnwooe'),
                'demo' => 'https://wooessential.com/divi-woocommerce-product-category-grid-module/',
                'icon' => DNWOO_ESSENTIAL_ICON . 'NextWooCatGrid/icon.svg',
            ),
            'dnwooe-woo-cat-masonry' => array(
                'title' => __('Woo Category Masonry', 'dnwooe'),
                'demo' => 'https://www.wooessential.com/divi-woocommerce-product-category-masonry-module/',
                'icon' => DNWOO_ESSENTIAL_ICON . 'NextWooCatMasonry/icon.svg',
            ),
            'dnwooe-woo-cat-accordion' => array(
                'title' => __('Woo Category Accordion', 'dnwooe'),
                'demo' => 'https://wooessential.com/divi-woocommerce-product-category-accordion-module/',
                'icon' => DNWOO_ESSENTIAL_ICON . 'NextWooCatAccordion/icon.svg',
            ),
            'dnwooe-woo-accordion' => array(
                'title' => __('Woo Product Accordion', 'dnwooe'),
                'demo' => 'https://www.wooessential.com/divi-woocommerce-product-accordion-module/',
                'icon' => DNWOO_ESSENTIAL_ICON . 'NextWooProductAccordion/icon.svg',
            ),
            'dnwooe-woo-filter-masonry' => array(
                'title' => __('Woo Product Filter Masonry', 'dnwooe'),
                'demo' => 'https://wooessential.com/divi-woocommerce-product-filter-module/',
                'icon' => DNWOO_ESSENTIAL_ICON . 'NextWooFilterMasonry/icon.svg',
            ),
            'dnwooe-woo-mini-cart' => array(
                'title' => __('Woo Mini Cart', 'dnwooe'),
                'demo' => 'https://wooessential.com/mini-cart-module/',
                'icon' => DNWOO_ESSENTIAL_ICON . 'NextWooMiniCart/icon.svg',
            ),
            'dnwooe-woo-ajax-search' => array(
                'title' => __('Woo Ajax Search', 'dnwooe'),
                'demo' => 'https://wooessential.com/divi-woocommerce-ajax-search/',
                'icon' => DNWOO_ESSENTIAL_ICON . 'NextWooAjaxSearch/icon.svg',
            ),
        );
    }

    private static function get_pro_modules_map()
    {
        return array();
    }

    public static function get_modules_map()
    {

        $active_modules_map = self::get_pro_modules_map();
        $modules_map = array_merge($active_modules_map, self::get_free_modules_map());

        uksort($modules_map, array(__CLASS__, 'sort_widgets'));

        return $modules_map;
    }
    public static function get_features_map()
    {
        $modules_map = array(
            'mini-cart-feature' => array(
                'title' => __('Woo Mini Cart', 'dnwooe'),
                'demo' => 'https://wooessential.com/mini-cart/',
                'icon' => DNWOO_ESSENTIAL_ASSETS . 'images/mini-cart.svg',
            ),
        );

        uksort($modules_map, array(__CLASS__, 'sort_widgets'));

        return $modules_map;
    }

    public static function sort_widgets($k1, $k2)
    {
        return strcasecmp($k1, $k2);
    }

    public static function get_tabs()
    {

        $icon_url = DNWOO_ESSENTIAL_ASSETS . 'images/admin/';

        $tabs = array(
            'home' => array(
                'title' => esc_html__('Home', 'dnwooe'),
                'icon' => '',
                'renderer' => array(__CLASS__, 'render_home'),
            ),
            'modules' => array(
                'title' => esc_html__('Modules', 'dnwooe'),
                'icon' => '',
                'renderer' => array(__CLASS__, 'render_modules'),
            ),
            'featuers' => array(
                'title' => esc_html__('Featuers', 'dnwooe'),
                'icon' => '',
                'renderer' => array(__CLASS__, 'render_features'),
            ),
        );

        return $tabs;
    }

    private static function load_template($template)
    {
        $file = DNWOO_ESSENTIAL_DIR . 'includes/admin/view/admin-' . $template . '.php';
        if (is_readable($file)) {
            include $file;
        }
    }

    public static function render_main()
    {
        self::load_template('main');
    }

    public static function render_home()
    {
        self::load_template('home');
    }

    public static function render_modules()
    {
        self::load_template('modules');
    }
    public static function render_features()
    {
        self::load_template('features');
    }

    /**
     *
     * 5. the required plugin license function start
     */
    public static function dnwoo_essential_plugin_updater()
    {

        // retrieve our license key from the DB
        $license_key = trim(get_option('dnwoo_essential_license_key') ?? ''); // phpcs:ignore

        // setup the updater
        $edd_updater = new \DNWOO_Essential_Plugin_Updater_Class(DNWOO_ESSENTIAL_STORE_URL, DNWOO_ESSENTIAL_FILE,
            array(
                'version' => DNWOO_ESSENTIAL_VERSION, // current version number
                'license' => $license_key, // license key (used get_option above to retrieve from DB)
                'item_id' => DNWOO_ESSENTIAL_ITEM_ID, // ID of the product
                'author' => 'Divi Next', // author of this plugin
                'beta' => false,
            )
        );
    }

    public static function render_license_page()
    {
        $license = get_option('dnwoo_essential_license_key');
        $status = get_option('dnwoo_essential_license_status');
        ?>
<div class="wrap">
    <h2><?php esc_html_e('Woo Essential License Options', 'dnwooe');?></h2>
    <form method="post" action="options.php">
        <?php settings_fields('dnwoo_essential_license');?>
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row" valign="top">
                        <?php esc_html_e('License Key', 'dnwooe');?>
                    </th>
                    <td>
                        <input id="dnwoo_essential_license_key" name="dnwoo_essential_license_key" type="password"
                            class="regular-text" value="<?php esc_attr_e($license);?>" />
                        <label class="description"
                            for="dnwoo_essential_license_key"><?php esc_html_e('Enter your license key', 'dnwooe');?></label>
                    </td>
                </tr>
                <?php if (false !== $license) {?>
                <tr valign="top">
                    <th scope="row" valign="top">
                        <?php esc_html_e('Activate License', 'dnwooe');?>
                    </th>
                    <td>
                        <?php if (false !== $status && 'valid' == $status) {?>
                        <span style="color:green;"><?php esc_html_e('is_active', 'dnwooe');?></span>
                        <?php wp_nonce_field('dnwoo_essential_nonce', 'dnwoo_essential_nonce');?>
                        <input type="submit" class="button-secondary" name="dnwoo_essential_plugin_license_deactivate"
                            value="<?php esc_attr_e('Deactivate License', 'dnwooe');?>" />
                        <?php } else {
            wp_nonce_field('dnwoo_essential_nonce', 'dnwoo_essential_nonce');?>
                        <input type="submit" class="button-secondary" name="dnwoo_essential_plugin_license_activate"
                            value="<?php esc_attr_e('Activate License', 'dnwooe');?>" />
                        <?php }?>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
        <?php submit_button();?>
    </form>
    <?php
}

    public static function dnwoo_essential_register_option()
    {
        // creates our settings in the options table
        register_setting('dnwoo_essential_license', 'dnwoo_essential_license_key', 'dnwoo_essential_sanitize_license');
    }

    public static function dnwoo_essential_sanitize_license($new)
    {
        $old = get_option('dnwoo_essential_license_key');
        if ($old && $old != $new) {
            delete_option('dnwoo_essential_license_status'); // new license has been entered, so must reactivate
        }
        return $new;
    }

    public static function dnwoo_essential_activate_license()
    {

        // listen for our activate button to be clicked
        if (isset($_POST['dnwoo_essential_plugin_license_activate'])) {

            // run a quick security check
            if (!check_admin_referer('dnwoo_essential_nonce', 'dnwoo_essential_nonce')) {
                return;
            }
            // get out if we didn't click the Activate button

            // retrieve the license from the database
            $license = trim(get_option('dnwoo_essential_license_key') ?? ''); // phpcs:ignore

            // data to send in our API request
            $api_params = array(
                'edd_action' => 'activate_license',
                'license' => $license,
                'item_name' => rawurlencode(DNWOO_ESSENTIAL_ITEM_NAME), // the name of our product in EDD
                'url' => home_url(),
            );

            // Call the custom API.
            $response = wp_remote_post(DNWOO_ESSENTIAL_STORE_URL, array('timeout' => 15, 'sslverify' => false, 'body' => $api_params));

            // make sure the response came back okay
            if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {

                if (is_wp_error($response)) {
                    $message = $response->get_error_message();
                } else {
                    $message = __('An error occurred, please try again.', 'dnwooe');
                }

            } else {

                $license_data = json_decode(wp_remote_retrieve_body($response));

                if (false === $license_data->success) {

                    switch ($license_data->error) {

                        case 'expired':

                            $message = sprintf(
                                __('Your license key expired on %s.', 'dnwooe'),
                                date_i18n(get_option('date_format'), strtotime($license_data->expires, current_time('mysql')))
                            );
                            break;

                        case 'disabled':
                        case 'revoked':

                            $message = __('Your license key has been disabled.', 'dnwooe');
                            break;

                        case 'missing':

                            $message = __('Invalid license.', 'dnwooe');
                            break;

                        case 'invalid':
                        case 'site_inactive':

                            $message = __('Your license is not active for this URL.', 'dnwooe');
                            break;

                        case 'item_name_mismatch':

                            $message = sprintf(__('This appears to be an invalid license key for %s.', 'dnwooe'), DNWOO_ESSENTIAL_ITEM_NAME);
                            break;

                        case 'no_activations_left':

                            $message = __('Your license key has reached its activation limit.', 'dnwooe');
                            break;

                        default:

                            $message = __('An error occurred, please try again.', 'dnwooe');
                            break;
                    }

                }

            }

            // Check if anything passed on a message constituting a failure
            if (!empty($message)) {
                $base_url = admin_url('admin.php?page=' . DNWOO_ESSENTIAL_PLUGIN_LICENSE_PAGE);
                $redirect = add_query_arg(array('sl_activation' => 'false', 'message' => rawurlencode($message)), $base_url);

                wp_safe_redirect($redirect);
                exit();
            }

            // $license_data->license will be either "valid" or "invalid"

            update_option('dnwoo_essential_license_status', $license_data->license);
            wp_safe_redirect(admin_url('admin.php?page=' . DNWOO_ESSENTIAL_PLUGIN_LICENSE_PAGE));
            exit();
        }
    }

    public static function dnwoo_essential_deactivate_license()
    {

        // listen for our activate button to be clicked
        if (isset($_POST['dnwoo_essential_plugin_license_deactivate'])) {

            // run a quick security check
            if (!check_admin_referer('dnwoo_essential_nonce', 'dnwoo_essential_nonce')) {
                return;
            }
            // get out if we didn't click the Activate button

            // retrieve the license from the database
            $license = trim(get_option('dnwoo_essential_license_key') ?? ''); // phpcs:ignore

            // data to send in our API request
            $api_params = array(
                'edd_action' => 'deactivate_license',
                'license' => $license,
                'item_name' => rawurlencode(DNWOO_ESSENTIAL_ITEM_NAME), // the name of our product in EDD
                'url' => home_url(),
            );

            // Call the custom API.
            $response = wp_remote_post(DNWOO_ESSENTIAL_STORE_URL, array('timeout' => 15, 'sslverify' => false, 'body' => $api_params));

            // make sure the response came back okay
            if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {

                if (is_wp_error($response)) {
                    $message = $response->get_error_message();
                } else {
                    $message = __('An error occurred, please try again.', 'dnwooe');
                }

                $base_url = admin_url('admin.php?page=' . DNWOO_ESSENTIAL_PLUGIN_LICENSE_PAGE);
                $redirect = add_query_arg(array('sl_activation' => 'false', 'message' => rawurlencode($message)), $base_url);

                wp_safe_redirect($redirect);
                exit();
            }

            // decode the license data
            $license_data = json_decode(wp_remote_retrieve_body($response));

            // $license_data->license will be either "deactivated" or "failed"
            if ('deactivated' == $license_data->license) {
                delete_option('dnwoo_essential_license_status');
            }

            wp_safe_redirect(admin_url('admin.php?page=' . DNWOO_ESSENTIAL_PLUGIN_LICENSE_PAGE));
            exit();

        }
    }

    public function dnwoo_essential_check_license()
    {

        global $wp_version;

        $license = trim(get_option('dnwoo_essential_license_key') ?? ''); // phpcs:ignore

        $api_params = array(
            'edd_action' => 'check_license',
            'license' => $license,
            'item_name' => rawurlencode(DNWOO_ESSENTIAL_ITEM_NAME),
            'url' => home_url(),
        );

        // Call the custom API.
        $response = wp_remote_post(DNWOO_ESSENTIAL_STORE_URL, array('timeout' => 15, 'sslverify' => false, 'body' => $api_params));

        if (is_wp_error($response)) {
            return false;
        }

        $license_data = json_decode(wp_remote_retrieve_body($response));

        if ('valid' == $license_data->license) {
            echo 'valid';exit;
            // this license is still valid
        } else {
            echo 'invalid';exit;
            // this license is no longer valid
        }
    }

    public static function dnwoo_essential_admin_notices()
    {
        if (isset($_GET['sl_activation']) && !empty($_GET['message'])) {// phpcs:ignore WordPress.Security.NonceVerification.Recommended

            switch ($_GET['sl_activation']) {// phpcs:ignore WordPress.Security.NonceVerification.Recommended

                case 'false':
                    $message = urldecode(sanitize_text_field($_GET['message']));// phpcs:ignore WordPress.Security.NonceVerification.Recommended
                    ?>
    <div class="error">
        <p><?php echo $message;// phpcs:ignore WordPress.Security.EscapeOutput ?></p>
    </div>
    <?php
break;

                case 'true':
                default:
                    // Developers can put a custom success message here for when activation is successful if they way.
                    break;

            }
        }
    }

    /**
     *
     * 5. the required plugin license function END
     */

}
Admin::get_instance();