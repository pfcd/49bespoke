<?php
/**
 * Easy Digital Downloads Theme Updater
 * This file contains modified code from the Software Licensing addon by Easy Digital Downloads
 * Licensed under the GNU General Public License v2.0 or higher; see license.txt in theme root
 *
 */

// Loads the updater classes
global $AGS_THEME_updater;
$AGS_THEME_updater = new AGS_THEME_Updater_Admin(

// Config settings
    array(
        'remote_api_url'         => 'https://wpzone.co/', // Site where EDD is hosted
        'download_id'            => 812518, // Optional, used for generating a license renewal link
        'item_name'              => 'Divi Ecommerce Pro', // Name of theme
        'theme_slug'             => get_stylesheet(), // Use get_stylesheet() for a child theme or get_template() for a parent theme
        'theme_admin_page'       => 'admin.php?page=AGS_child_theme', // The theme's main settings admin page
        'theme_license_key_page' => 'admin.php?page=AGS_child_theme#license', // The admin page containing the theme's license key box with the license key deactivation button
        'version'                => AGS_THEME_VERSION, // The current version of this theme
        'author'                 => 'WP Zone', // The author of this theme
        'renew_url'              => '', // Optional, allows for a custom license renewal link
        'beta'                   => false // Optional, set to true to opt into beta versions
    ),

    // Strings
    array(
        'theme-license'             => __( 'Theme License', 'divi-ecommerce-pro' ),
        'enter-key'                 => __( 'Enter your theme license key.', 'divi-ecommerce-pro' ),
        'license-key'               => __( 'License Key', 'divi-ecommerce-pro' ),
        'license-action'            => __( 'License Action', 'divi-ecommerce-pro' ),
        'deactivate-license'        => __( 'Deactivate License', 'divi-ecommerce-pro' ),
        'activate-license'          => __( 'Activate License', 'divi-ecommerce-pro' ),
        'status-unknown'            => __( 'License status is unknown.', 'divi-ecommerce-pro' ),
        'renew'                     => __( 'Renew?', 'divi-ecommerce-pro' ),
        'unlimited'                 => __( 'unlimited', 'divi-ecommerce-pro' ),
        'license-key-is-active'     => __( 'License key is active.', 'divi-ecommerce-pro' ),
        'expires%s'                 => __( 'Expires %s.', 'divi-ecommerce-pro' ),
        'expires-never'             => __( 'Lifetime License.', 'divi-ecommerce-pro' ),
        '%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'divi-ecommerce-pro' ),
        'license-key-expired-%s'    => __( 'License key expired %s.', 'divi-ecommerce-pro' ),
        'license-key-expired'       => __( 'License key has expired.', 'divi-ecommerce-pro' ),
        'license-keys-do-not-match' => __( 'License keys do not match.', 'divi-ecommerce-pro' ),
        'license-is-inactive'       => __( 'License is inactive.', 'divi-ecommerce-pro' ),
        'license-key-is-disabled'   => __( 'License key is disabled.', 'divi-ecommerce-pro' ),
        'site-is-inactive'          => __( 'Site is inactive.', 'divi-ecommerce-pro' ),
        'license-status-unknown'    => __( 'License status is unknown.', 'divi-ecommerce-pro' ),
        'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'divi-ecommerce-pro' ),
        'update-available'          => __('%1$s is available. %2$sCheck out what\'s new%3$s or %4$supdate now%5$s.', 'divi-ecommerce-pro' ),
        'update-available-expired-license-key' => __('%1$s is available. %2$sRenew your license key%3$s to update.', 'divi-ecommerce-pro' )
    )
);

// Load translations
load_theme_textdomain('divi-ecommerce-pro', dirname(__FILE__).'/lang');


/**
 * Theme updater admin page and functions.
 *
 */
class AGS_THEME_Updater_Admin {

    /**
     * Variables required for the theme updater
     *
     * @since 1.0.0
     * @type string
     */
    protected $remote_api_url = null;
    protected $theme_slug = null;
    protected $theme_admin_page = null;
    protected $theme_license_key_page = null;
    protected $item_name = null;
    protected $version = null;
    protected $author = null;
    protected $download_id = null;
    protected $renew_url = null;
    protected $strings = null;

    /**
     * Initialize the class.
     *
     * @since 1.0.0
     */
    function __construct($config = array(), $strings = array()) {

        $config = wp_parse_args($config, array(
            'remote_api_url'         => '',
            'theme_slug'             => '',
            'theme_admin_page'       => '',
            'theme_license_key_page' => '',
            'item_name'              => '',
            'license'                => '',
            'version'                => '',
            'author'                 => '',
            'download_id'            => '',
            'renew_url'              => '',
            'beta'                   => false,
        ));

        // Set config arguments
        $this->remote_api_url = $config['remote_api_url'];
        $this->item_name = $config['item_name'];
        $this->theme_slug = $config['theme_slug']; //sanitize_key( $config['theme_slug'] );
        $this->theme_admin_page = $config['theme_admin_page'];
        $this->theme_license_key_page = $config['theme_license_key_page'];
        $this->version = $config['version'];
        $this->author = $config['author'];
        $this->download_id = $config['download_id'];
        $this->renew_url = $config['renew_url'];
        $this->beta = $config['beta'];

        // Populate version fallback
        if ('' == $config['version']) {
            $theme = wp_get_theme($this->theme_slug);
            $this->version = $theme->get('Version');
        }

        // Strings passed in from the updater config
        $this->strings = $strings;

        add_action('init', array($this, 'updater'));
        add_action('admin_init', array($this, 'register_option'));
        add_action('admin_init', array($this, 'license_action'));
        add_action('update_option_agstheme_' . $this->theme_slug . '_license_key', array($this, 'activate_license'), 10, 2);
        add_filter('http_request_args', array($this, 'disable_wporg_request'), 5, 2);

    }

    /**
     * Creates the updater class.
     *
     * since 1.0.0
     */
    function updater() {
        if (!current_user_can('manage_options')) {
            return;
        }

        /* If there is no valid license key status, don't allow updates. */
		/*
        if (get_option('agstheme_' . $this->theme_slug . '_license_key_status', false) != 'valid') {
            return;
        }
		*/

        new AGS_THEME_Updater(
            array(
                'remote_api_url' => $this->remote_api_url,
                'version'        => $this->version,
                'license'        => trim(get_option('agstheme_' . $this->theme_slug . '_license_key')),
                'item_name'      => $this->item_name,
                'theme_slug'     => $this->theme_slug,
                'author'         => $this->author,
                'beta'           => $this->beta
            ),
            $this->strings
        );
    }

    /**
     * Outputs the markup used on the theme activation page.
     *
     * since 1.0.0
     */
    function activate_page() {
        $license = get_option('agstheme_' . $this->theme_slug . '_license_key', false);
        ?>

        <div class="wrap" id="AGS_THEME_license_key_activation_page">
            <form method="post" action="options.php" id="AGS_THEME_license_form">
                <div id="AGS_THEME_license_form_header">
                    <a href="https://wpzone.co/" target="_blank">
                        <img src="<?php echo(get_theme_root_uri() . '/' . $this->theme_slug . '/admin/updater/wp_zone_logo.png'); ?>"
                             alt="WP Zone"/>
                    </a>
                </div>

                <div id="AGS_THEME_license_form_body">
                    <h3>
                        <?php echo($this->item_name); ?>
                        <small>v<?php echo($this->version); ?></small>
                    </h3>

                    <p>
                        <?php
                        printf(
                            __('Thank you for purchasing %s. <br />Please enter your license key below.', 'divi-ecommerce-pro'),
                            $this->item_name);
                        ?>
                    </p>

                    <?php settings_fields('agstheme_' . $this->theme_slug . '-license'); ?>

                    <label>
                        <span><?php _e('License Key:', 'ags-child-text-domain'); ?></span>
                        <input name="<?php echo('agstheme_' . $this->theme_slug); ?>_license_key" type="text"
                               class="regular-text"<?php if (!empty($_GET['license_key'])) { ?> value="<?php echo(esc_attr($_GET['license_key'])); ?>"<?php } else if (!empty($license)) { ?> value="<?php echo(esc_attr($license)); ?>"<?php } ?> />
                    </label>
                    <?php wp_nonce_field('agstheme_' . $this->theme_slug . '_license_activate', 'agstheme_' . $this->theme_slug . '_license_activate');
                    if (isset($_GET['sl_theme_activation']) && $_GET['sl_theme_activation'] == 'false') {
                        echo('<p id="AGS_THEME_license_form_error">' . (empty($_GET['sl_message']) ? esc_html__('An unknown error has occurred. Please try again.', 'ags-child-text-domain') : esc_html($_GET['sl_message'])) . '</p>');
                    }
                    submit_button(__('Continue', 'divi-ecommerce-pro'));
                    ?>
                </div>
            </form>
        </div>
        <?php
    }

    /**
     * Registers the option used to store the license key in the options table.
     *
     * since 1.0.0
     */
    function register_option() {
        register_setting(
            'agstheme_' . $this->theme_slug . '-license',
            'agstheme_' . $this->theme_slug . '_license_key',
            array($this, 'sanitize_license')
        );
    }

    /**
     * Sanitizes the license key.
     *
     * since 1.0.0
     *
     * @param string $new License key that was submitted.
     * @return string $new Sanitized license key.
     */
    function sanitize_license($new) {

        $old = get_option('agstheme_' . $this->theme_slug . '_license_key');

        if ($old && $old != $new) {
            // New license has been entered, so must reactivate
            delete_option('agstheme_' . $this->theme_slug . '_license_key_status');
            delete_option('agstheme_' . $this->theme_slug . '_license_key_expiry');
            delete_transient('agstheme_' . $this->theme_slug . '_license_message');
        }

        return $new;
    }

    /**
     * Makes a call to the API.
     *
     * @since 1.0.0
     *
     * @param array $api_params to be used for wp_remote_get.
     * @return array $response decoded JSON response.
     */
    function get_api_response($api_params) {

        // Call the custom API.
        $response = wp_remote_post($this->remote_api_url, array('timeout' => 15, 'sslverify' => false, 'body' => $api_params));

        // Make sure the response came back okay.
        if (is_wp_error($response)) {
            wp_die($response->get_error_message(), __('Error', 'ags-child-text-domain') . $response->get_error_code());
        }

        return $response;
    }

    /**
     * Activates the license key.
     *
     * @since 1.0.0
     */
    function activate_license() {

        $license = get_option('agstheme_' . $this->theme_slug . '_license_key');

        // Data to send in our API request.
        $api_params = array(
            'edd_action' => 'activate_license',
            'license'    => $license,
            'item_name'  => urlencode($this->item_name),
            'url'        => home_url()
        );

        $response = $this->get_api_response($api_params);

        // make sure the response came back okay
        if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {

            if (is_wp_error($response)) {
                $message = $response->get_error_message();
            } else {
                $message = __('An error occurred, please try again.', 'ags-child-text-domain');
            }

        } else {
            $license_data = json_decode(wp_remote_retrieve_body($response));

            if (false === $license_data->success) {

                switch ($license_data->error) {

                    case 'expired' :

                        $message = sprintf(
                            __('Your license key expired on %1$s. Please visit our website to renew.', 'ags-child-text-domain'),
                            date_i18n(get_option('date_format'), strtotime($license_data->expires, current_time('timestamp')))
                        );
                        break;

                    case 'revoked' :

                        $message = __('Your license key has been disabled.', 'ags-child-text-domain');
                        break;

                    case 'missing' :

                        $message = __('Invalid license key.', 'ags-child-text-domain');
                        break;

                    case 'invalid' :
                    case 'site_inactive' :

                        $message = __('Your license is not active for this URL.', 'ags-child-text-domain');
                        break;

                    case 'item_name_mismatch' :

                        $message = sprintf(__('This appears to be an invalid license key for %s.', 'ags-child-text-domain'), $args['name']);
                        break;

                    case 'no_activations_left':

                        $message = __('Your license key has reached its activation limit. Please deactivate the key on one of your other sites before activating it on this site.', 'ags-child-text-domain');
                        break;

                    default :

                        $message = __('An error occurred, please try again.', 'ags-child-text-domain');
                        break;
                }

                if (!empty($message)) {
                    delete_option('agstheme_' . $this->theme_slug . '_license_key');

                    $base_url = admin_url($this->theme_admin_page);
                    $redirect = add_query_arg(array('sl_theme_activation' => 'false', 'sl_message' => urlencode($message)), $base_url);

                    wp_redirect($redirect);
                    exit();
                }
            }
        }

        // $response->license will be either "valid" or "inactive"
        if ($license_data && isset($license_data->license)) {

            delete_transient('agstheme_' . $this->theme_slug . '_license_message');

            if ($license_data->license !== 'valid') {
                delete_option('agstheme_' . $this->theme_slug . '_license_key');

                $base_url = admin_url($this->theme_admin_page);
                $redirect = add_query_arg(array('sl_theme_activation' => 'false', 'sl_message' => urlencode($message)), $base_url);

                wp_redirect($redirect);
                exit();
            }

            update_option('agstheme_' . $this->theme_slug . '_license_key_status', 'valid');
            update_option('agstheme_' . $this->theme_slug . '_license_key_expiry', ($license_data->expires == 'lifetime' ? 'lifetime' : strtotime($license_data->expires)), false);
        }

        wp_redirect($this->theme_admin_page);
        exit();
    }

    /**
     * Deactivates the license key.
     *
     * @since 1.0.0
     */
    function deactivate_license() {

        // Retrieve the license from the database.
        $license = get_option('agstheme_' . $this->theme_slug . '_license_key');

        // Data to send in our API request.
        $api_params = array(
            'edd_action' => 'deactivate_license',
            'license'    => $license,
            'item_name'  => urlencode($this->item_name),
            'url'        => home_url()
        );

        $response = $this->get_api_response($api_params);

        // make sure the response came back okay
        if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {

            if (is_wp_error($response)) {
                $message = $response->get_error_message();
            } else {
                $message = __('An error occurred, please try again.', 'ags-child-text-domain');
            }

        } else {

            $license_data = json_decode(wp_remote_retrieve_body($response));

            // $license_data->license will be either "deactivated" or "failed"
            if ($license_data && ($license_data->license == 'deactivated')) {
                delete_transient('agstheme_' . $this->theme_slug . '_license_message');
            } else {
                $message = __('An error occurred while deactivating your license key.', 'ags-child-text-domain');
            }

            delete_option('agstheme_' . $this->theme_slug . '_license_key');
            delete_option('agstheme_' . $this->theme_slug . '_license_key_status');
            delete_option('agstheme_' . $this->theme_slug . '_license_key_expiry');
        }

        if (!empty($message)) {
            $base_url = admin_url($this->theme_license_key_page);
            $redirect = add_query_arg(array('sl_theme_activation' => 'false', 'sl_message' => urlencode($message)), $base_url);

            wp_redirect($redirect);
            exit();
        }

        wp_redirect($this->theme_admin_page);
        exit;
    }

    /**
     * Constructs a renewal link
     *
     * @since 1.0.0
     */
    function get_renewal_link() {

        // If a renewal link was passed in the config, use that
        if ('' != $this->renew_url) {
            return $this->renew_url;
        }

        // If download_id was passed in the config, a renewal link can be constructed
        $license_key = get_option('agstheme_' . $this->theme_slug . '_license_key', false);
        if ('' != $this->download_id && $license_key) {
            $url = esc_url($this->remote_api_url);
            $url .= '/checkout/?edd_license_key=' . $license_key . '&download_id=' . $this->download_id;
            return $url;
        }

        // Otherwise return the remote_api_url
        return $this->remote_api_url;
    }

    /**
     * Checks if a license action was submitted.
     *
     * @since 1.0.0
     */
    function license_action() {

        if (isset($_POST['agstheme_' . $this->theme_slug . '_license_activate']) && isset($_POST['agstheme_' . $this->theme_slug . '_license_key'])) {
            if (check_admin_referer('agstheme_' . $this->theme_slug . '_license_activate', 'agstheme_' . $this->theme_slug . '_license_activate')) {
                update_option('agstheme_' . $this->theme_slug . '_license_key', trim($_POST['agstheme_' . $this->theme_slug . '_license_key']), false);
                $this->activate_license();
            }
        }

        if (isset($_POST['agstheme_' . $this->theme_slug . '_license_deactivate'])) {
            if (check_admin_referer('agstheme_' . $this->theme_slug . '_license_deactivate', 'agstheme_' . $this->theme_slug . '_license_deactivate')) {
                $this->deactivate_license();
            }
        }
    }

    /**
     * Disable requests to wp.org repository for this theme.
     *
     * @since 1.0.0
     */
    function disable_wporg_request($r, $url) {

        // If it's not a theme update request, bail.
        if (0 !== strpos($url, 'https://api.wordpress.org/themes/update-check/1.1/')) {
            return $r;
        }

        // Decode the JSON response
        $themes = json_decode($r['body']['themes']);

        // Remove the active parent and child themes from the check
        $parent = get_option('template');
        $child = get_option('stylesheet');
        unset($themes->themes->$parent);
        unset($themes->themes->$child);

        // Encode the updated JSON response
        $r['body']['themes'] = json_encode($themes);

        return $r;
    }

    /**
     * Checks if license is valid and gets expire date.
     *
     * @since 1.0.0
     *
     * @return string $message License status message.
     */
    function check_license_renewed($savedExpiry) {
        $license = get_option('agstheme_' . $this->theme_slug . '_license_key');

        $api_params = array(
            'edd_action' => 'check_license',
            'license'    => $license,
            'item_name'  => urlencode($this->item_name),
            'url'        => home_url()
        );

        $response = $this->get_api_response($api_params);

        // make sure the response came back okay
        if (!is_wp_error($response) && 200 === wp_remote_retrieve_response_code($response)) {

            $license_data = json_decode(wp_remote_retrieve_body($response));

            // If response doesn't include license data, return
            if (isset($license_data->license) && $license_data->license == 'valid'
                && isset($license_data->expires) && (
                    $license_data->expires == 'lifetime'
                    || ($expiry = strtotime($license_data->expires)) > time()
                )) {
                update_option('agstheme_' . $this->theme_slug . '_license_key_expiry', ($license_data->expires == 'lifetime' ? 'lifetime' : $expiry));
                return ($license_data->expires == 'lifetime' ? 'lifetime' : $expiry);
            }
        }
        return false;
    }

    function has_license_key() {
        return (get_option('agstheme_' . $this->theme_slug . '_license_key_status', false) === 'valid');
    }

    function license_key_box() {
        $licenseKeyExpiry = get_option('agstheme_' . $this->theme_slug . '_license_key_expiry');
        $display_license = str_repeat('*', strlen(esc_html(get_option('agstheme_' . $this->theme_slug . '_license_key'))) - 4) . substr(esc_html(get_option('agstheme_' . $this->theme_slug . '_license_key')), -4);

        ?>

        <form method="post" id="AGS_THEME_license_form">
            <div id="AGS_THEME_license_form_header">
                <a href="https://wpzone.co/" target="_blank">
                    <img src="<?php echo(get_theme_root_uri() . '/' . $this->theme_slug . '/admin/updater/wp_zone_logo.png'); ?>"
                         alt="WP Zone"/>
                </a>
            </div>

            <div id="AGS_THEME_license_form_body">
                <h3>
                    <?php echo($this->item_name); ?>
                    <small>v<?php echo($this->version); ?></small>
                </h3>

                <label>
                    <span><?php _e('License Key:', 'ags-child-text-domain'); ?></span>
                    <input type="text" readonly="readonly" value="<?php echo(esc_html($display_license)); ?>"/>
                </label>

                <p class="description">
                    <?php
                    if ($licenseKeyExpiry != 'lifetime'
                        && ($isExpired = (time() > $licenseKeyExpiry))
                        && (($newExpiry = $this->check_license_renewed($licenseKeyExpiry)) !== false)) {
                        $licenseKeyExpiry = $newExpiry;
                        $isExpired = false;
                    }
                    if ($licenseKeyExpiry == 'lifetime') {
                        esc_html_e('This license key does not expire.', 'ags-child-text-domain');
                    } else if ($isExpired) {
                        printf(esc_html__('Expired on %1$s. %2$sRenew now%3$s to continue receiving updates and support.', 'ags-child-text-domain'),
                            date_i18n(get_option('date_format'), $licenseKeyExpiry + (get_option('gmt_offset') * 3600)),
                            '<a href="' . esc_attr($this->get_renewal_link()) . '" target="_blank">',
                            '</a>');
                    } else {
                        printf(esc_html__('Expires on %1$s. %2$sClick here%3$s to renew.', 'ags-child-text-domain'),
                            date_i18n(get_option('date_format'), $licenseKeyExpiry + (get_option('gmt_offset') * 3600)),
                            '<a href="' . esc_attr($this->get_renewal_link()) . '" target="_blank">',
                            '</a>');
                    }
                    ?>
                </p>
                <?php wp_nonce_field('agstheme_' . $this->theme_slug . '_license_deactivate', 'agstheme_' . $this->theme_slug . '_license_deactivate');
                if (isset($_GET['sl_theme_activation']) && $_GET['sl_theme_activation'] == 'false') {
                    echo('<p id="AGS_THEME_license_form_error">' . (empty($_GET['sl_message']) ? esc_html__('An unknown error has occurred. Please try again.', 'ags-child-text-domain') : esc_html($_GET['sl_message'])) . '</p>');
                }
                submit_button(__('Deactivate License Key', 'ags-child-text-domain'), '');
                ?>
            </div>
        </form>

        <?php
    }
}


/**
 * Theme updater class.
 *
 * @version 1.0.3
 */
class AGS_THEME_Updater {

    private $remote_api_url;
    private $request_data;
    private $response_key;
    private $theme_slug;
    private $license_key;
    private $version;
    private $author;
    protected $strings = null;


    /**
     * Initiate the Theme updater
     *
     * @param array $args Array of arguments from the theme requesting an update check
     * @param array $strings Strings for the update process
     */
    function __construct($args = array(), $strings = array()) {
        $defaults = array(
            'remote_api_url' => 'http://easydigitaldownloads.com',
            'request_data'   => array(),
            'theme_slug'     => get_template(),
            'item_name'      => '',
            'license'        => '',
            'version'        => '',
            'author'         => '',
            'beta'           => false,
        );

        $args = wp_parse_args($args, $defaults);

        $this->license = $args['license'];
        $this->item_name = $args['item_name'];
        $this->version = $args['version'];
        $this->theme_slug = $args['theme_slug']; //sanitize_key( $args['theme_slug'] );
        $this->author = $args['author'];
        $this->beta = $args['beta'];
        $this->remote_api_url = $args['remote_api_url'];
        $this->response_key = $this->theme_slug . '-' . $this->beta . '-update-response';
        $this->strings = $strings;

        add_filter('site_transient_update_themes', array($this, 'theme_update_transient'));
        add_filter('delete_site_transient_update_themes', array($this, 'delete_theme_update_transient'));
        add_action('load-update-core.php', array($this, 'delete_theme_update_transient'));
        add_action('load-themes.php', array($this, 'delete_theme_update_transient'));
        add_action('load-update-core.php', array($this, 'load_update_core_screen'));
        add_action('load-themes.php', array($this, 'load_themes_screen'));
		
    }

    /**
     * Show the update notification when necessary
     *
     * @return void
     */
    function load_themes_screen() {
        add_thickbox();
        add_action('admin_notices', array($this, 'update_nag'));
		
        add_action('admin_footer-themes.php', array($this, 'maybe_output_themes_page_notice_js'));
		add_filter('wp_prepare_themes_for_js', array($this, 'maybe_add_notice_to_themes_js'));
		
    }

    /**
     * Show the update notification when the license key has expired
     *
     * @return void
     */
    function load_update_core_screen() {
        $expiry = get_option('agstheme_' . $this->theme_slug . '_license_key_expiry');
        if ($expiry != 'lifetime' && $expiry < time() && $GLOBALS['AGS_THEME_updater']->check_license_renewed($expiry) === false) {
            add_action('admin_notices', array($this, 'update_nag'));
        }
		
        add_action('core_upgrade_preamble', array($this, 'maybe_output_updates_page_notice_js'));
    }

    /**
     * Display the update notifications
     *
     * @return void
     */
    function update_nag() {

        $strings = $this->strings;
        $theme = wp_get_theme($this->theme_slug);
        $api_response = get_transient($this->response_key);

        if (false === $api_response) {
            return;
        }

        $update_url = wp_nonce_url('update.php?action=upgrade-theme&amp;theme=' . urlencode($this->theme_slug), 'upgrade-theme_' . $this->theme_slug);
        $update_onclick = ' onclick="if ( confirm(\'' . esc_js($strings['update-notice']) . '\') ) {return true;}return false;"';

        if (version_compare($this->version, $api_response->new_version, '<')) {
            $expiry = get_option('agstheme_' . $this->theme_slug . '_license_key_expiry');
            echo '<div id="update-nag">';

            if ($expiry != 'lifetime' && $expiry < time() && $GLOBALS['AGS_THEME_updater']->check_license_renewed($expiry) === false) {
                printf(
                    esc_html($strings['update-available-expired-license-key']),
                    '<strong>' . esc_html($theme->get('Name') . ' ' . $api_response->new_version) . '</strong>',
                    '<a href="' . esc_attr($GLOBALS['AGS_THEME_updater']->get_renewal_link()) . '" target="_blank">',
                    '</a>'
                );
            } else {
                $themeName = $theme->get('Name');
                printf(
                    esc_html($strings['update-available']),
                    '<strong>' . esc_html($themeName . ' ' . $api_response->new_version) . '</strong>',
                    '<a href="#TB_inline?width=640&amp;inlineId=' . $this->theme_slug . '_changelog" class="thickbox" title="' . esc_attr($themeName) . '">',
                    '</a>',
                    '<a href="' . esc_attr($update_url) . '"' . $update_onclick . '>',
                    '</a>'
                );
            }
            echo '</div>';
            echo '<div id="' . $this->theme_slug . '_' . 'changelog" style="display:none;">';
            echo wpautop($api_response->sections['changelog']);
            echo '</div>';
        }
    }

    /**
     * Update the theme update transient with the response from the version check
     *
     * @param array $value The default update values.
     * @return array|boolean  If an update is available, returns the update parameters, if no update is needed returns false, if
     *                        the request fails returns false.
     */
    function theme_update_transient($value) {
        $update_data = $this->check_for_update();
        if ($update_data) {
	        if ( ! is_object( $value ) ) {
		        $value = new stdClass;
	        }
            $value->response[$this->theme_slug] = $update_data;
        }
        return $value;
    }

    /**
     * Remove the update data for the theme
     *
     * @return void
     */
    function delete_theme_update_transient() {
        delete_transient($this->response_key);
    }

    /**
     * Call the EDD SL API (using the URL in the construct) to get the latest version information
     *
     * @return array|boolean  If an update is available, returns the update parameters, if no update is needed returns false, if
     *                        the request fails returns false.
     */
    function check_for_update() {

        $update_data = get_transient($this->response_key);

        if (false === $update_data) {
            $failed = false;

            $api_params = array(
                'edd_action' => 'get_version',
                'license'    => $this->license,
                'name'       => $this->item_name,
                'slug'       => $this->theme_slug,
                'version'    => $this->version,
                'author'     => $this->author,
                'beta'       => $this->beta
            );

            $response = wp_remote_post($this->remote_api_url, array('timeout' => 15, 'body' => $api_params));

            // Make sure the response was successful
            if (is_wp_error($response) || 200 != wp_remote_retrieve_response_code($response)) {
                $failed = true;
            }

            $update_data = json_decode(wp_remote_retrieve_body($response));

            if (!is_object($update_data)) {
                $failed = true;
            }

            // If the response failed, try again in 30 minutes
            if ($failed) {
                $data = new stdClass;
                $data->new_version = $this->version;
                set_transient($this->response_key, $data, strtotime('+30 minutes', current_time('timestamp')));
                return false;
            }

            // If the status is 'ok', return the update arguments
            if (!$failed) {
                $update_data->sections = maybe_unserialize($update_data->sections);
				set_transient($this->response_key, $update_data, strtotime('+12 hours', current_time('timestamp')));
            }
				
        }

        if (version_compare($this->version, $update_data->new_version, '>=')) {
            return false;
        }

        return (array)$update_data;
    }
	
	function maybe_output_updates_page_notice_js() {
		$updateInfo = $this->check_for_update();
		
		if ( !empty($updateInfo['ags_update_notices']) ) {
?>
			<script>
				jQuery(document).ready(function($) {
					$(<?php echo(wp_json_encode('#update-themes-table .check-column [value="'.$this->theme_slug.'"]')); ?>)
						.closest('tr')
						.children('.plugin-title:first')
						.append(
							$('<div>')
								.addClass('clear ags-update-notice ags-update-notice-theme')
								.css('padding-top', '15px')
								.append(
									$('<div>')
										.addClass('notice notice-error notice-alt inline')
										.append(
											<?php echo(wp_json_encode($updateInfo['ags_update_notices'])); ?>.map(function(val) {
												return $('<p>').text(val);
											})
										)
								)
					);
				});
			</script>
<?php
		}
	}
	
	function maybe_output_themes_page_notice_js() {
		$updateInfo = $this->check_for_update();
		
		if ( !empty($updateInfo['ags_update_notices']) ) {
?>
			<script>
				jQuery(document).ready(function($) {
					
					function addNotice() {
						$('.themes .theme.active .update-message p')
							.append('<strong>Important:</strong> Before updating, click to read the update notice(s).');
					}
					
					wp.themes.Run.themes.bind('themes:update', addNotice);
					
					addNotice();
				});
			</script>
<?php
		}
	}
	
	function maybe_add_notice_to_themes_js($themesForJs) {
		$updateInfo = $this->check_for_update();
		
		if ( !empty($updateInfo['ags_update_notices']) && !empty($themesForJs[$this->theme_slug]['update']) ) {
			$themesForJs[$this->theme_slug]['update'] .= '<div class="notice notice-error notice-alt inline ags-update-notice ags-update-notice-theme">';
			foreach ( $updateInfo['ags_update_notices'] as $notice ) {
				$themesForJs[$this->theme_slug]['update'] .= '<p>'.esc_html($notice).'</p>';
			}
			
			$themesForJs[$this->theme_slug]['update'] .= '</div>';
		}
		
		return $themesForJs;
	}
}
