<?php
/**
 * Easy Digital Downloads Theme Updater
 * This file contains modified code from and/or based on the Software Licensing addon by Easy Digital Downloads
 * Licensed under the GNU General Public License v2.0 or higher; see license.txt in theme root
 *
 */


if (!defined('ABSPATH')) exit;

if (!class_exists('ds_woo_carousel_Plugin_Updater')) {
    // load our custom updater
    include(dirname(__FILE__) . '/EDD_SL_Plugin_Updater.php');
}

// Load translations
load_plugin_textdomain('aspengrove-updater', false, plugin_basename(dirname(__FILE__) . '/lang'));

function ds_woo_carousel_updater() {

    // retrieve our license key from the DB
    $license_key = trim(get_option('ds_woo_carousel_license_key'));

    // setup the updater
    new ds_woo_carousel_Plugin_Updater(DS_Woo_Carousel::PLUGIN_STORE_URL, DS_Woo_Carousel::PLUGIN_FILE, array(
            'version'   => DS_Woo_Carousel::PLUGIN_VERSION, // current version number
            'license'   => $license_key, // license key (used get_option above to retrieve from DB)
            'item_name' => DS_Woo_Carousel::PLUGIN_NAME, // name of this plugin
            'author'    => DS_Woo_Carousel::PLUGIN_AUTHOR, // author of this plugin
            'beta'      => false
        )
    );

    // creates our settings in the options table
    register_setting('ds_woo_carousel_license', 'ds_woo_carousel_license_key', 'ds_woo_carousel_sanitize_license');
	
	// phpcs:disable WordPress.Security.NonceVerification -- nonce verification occurs in the ds_woo_carousel_deactivate_license() function
    if (isset($_POST['ds_woo_carousel_license_key_deactivate'])) {
        require_once(dirname(__FILE__) . '/license-key-activation.php');
        $result = ds_woo_carousel_deactivate_license();
        if ($result !== true) {
            define('ds_woo_carousel_DEACTIVATE_ERROR', empty($result) ? esc_html_e('An unknown error has occurred. Please try again.', 'aspengrove-updater') : $result);
        }
        unset($_POST['ds_woo_carousel_license_key_deactivate']);
    }
	// phpcs:enable WordPress.Security.NonceVerification
	
}

add_action('admin_init', 'ds_woo_carousel_updater', 0);


function ds_woo_carousel_has_license_key() {
    return (get_option('ds_woo_carousel_license_status') === 'valid');
}

function ds_woo_carousel_activate_page() {
    $license = get_option('ds_woo_carousel_license_key');
    $status = get_option('ds_woo_carousel_license_status');
    ?>
    <div class="wrap" id="ds_woo_carousel_license_key_activation_page">
        <form method="post" action="options.php" id="ds_woo_carousel_license_form">
            <div id="ds_woo_carousel_license_form_header">
                <a href="" target="_blank">
                    <img src="<?php echo(esc_url(plugins_url('wp_zone_logo.png', __FILE__))); ?>"
                         alt="<?php echo(esc_attr(DS_Woo_Carousel::PLUGIN_AUTHOR)); ?>"/>
                </a>
            </div>

            <div id="ds_woo_carousel_license_form_body">
                <h3 id="ds_woo_carousel_license_form_title">
                    <?php echo(esc_html(DS_Woo_Carousel::PLUGIN_NAME)); ?>
                    <small>v<?php echo(esc_html(DS_Woo_Carousel::PLUGIN_VERSION)); ?></small>
                </h3>

                <p>
                    <?php
                    printf(
                        esc_html__('Thank you for purchasing %s. %s Please enter your license key below.', 'aspengrove-updater'),
                        esc_html(DS_Woo_Carousel::PLUGIN_NAME), '<br />');
                    ?>
                </p>


                <?php settings_fields('ds_woo_carousel_license'); ?>

                <label>
                    <span><?php esc_html_e('License Key:', 'aspengrove-updater'); ?></span>
                    <input name="ds_woo_carousel_license_key" type="text" class="regular-text"<?php
						// phpcs:ignore WordPress.Security.NonceVerification -- $_GET variable used for display only
						if (!empty ($_GET['license_key'])) { ?> value="<?php echo(esc_attr(sanitize_text_field($_GET['license_key']))); ?>"<?php } else if (!empty($license)) { ?> value="<?php echo(esc_attr($license)); ?>"<?php } ?> />
                </label>

                <?php
				// phpcs:ignore WordPress.Security.NonceVerification -- just testing a flag
                if (isset($_GET['sl_activation']) && $_GET['sl_activation'] == 'false') {
					// phpcs:ignore WordPress.Security.NonceVerification -- $_GET variable used for display only
                    echo('<p id="ds_woo_carousel_license_form_error">' . (empty($_GET['sl_message']) ? esc_html__('An unknown error has occurred. Please try again.', 'aspengrove-updater') : esc_html(sanitize_text_field($_GET['sl_message']))) . '</p>');
                } else if (defined('ds_woo_carousel_DEACTIVATE_ERROR')) {
                    // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ds_woo_carousel_DEACTIVATE_ERROR is already HTML escaped
                    echo('<p id="ds_woo_carousel_license_form_error">' . ds_woo_carousel_DEACTIVATE_ERROR . '</p>');
                }

                submit_button(esc_html__('Continue', 'aspengrove-updater'));
                ?>
            </div>
        </form>
    </div>
    <?php
}

function ds_woo_carousel_license_key_box() {
    $status = get_option('ds_woo_carousel_license_status');
    $accepted_license = get_option('ds_woo_carousel_license_key');
    $display_license = str_repeat('*', strlen($accepted_license) - 4) . substr($accepted_license, -4);

    ?>
    <div id="ds_woo_carousel_license_box">
        <form method="post" action="<?php echo(esc_url(DS_Woo_Carousel::PLUGIN_PAGE)); ?>"
              id="ds_woo_carousel_license_form">
            <div id="ds_woo_carousel_license_form_header">
                <a href="" target="_blank">
                    <img src="<?php echo(esc_url(plugins_url('wp_zone_logo.png', __FILE__))); ?>"
                         alt="<?php echo(esc_html(DS_Woo_Carousel::PLUGIN_AUTHOR)); ?>"/>
                </a>
            </div>

            <div id="ds_woo_carousel_license_form_body">
                <h3 id="ds_woo_carousel_license_form_title">
                    <?php echo(esc_html(DS_Woo_Carousel::PLUGIN_NAME)); ?>
                    <small>v<?php echo(esc_html(DS_Woo_Carousel::PLUGIN_VERSION)); ?></small>
                </h3>

                <label>
                    <span><?php esc_html_e('License Key:', 'aspengrove-updater'); ?></span>
                    <input type="text" readonly="readonly" value="<?php echo(esc_html($display_license)); ?>"/>
                </label>

                <?php
                if (defined('ds_woo_carousel_DEACTIVATE_ERROR')) {
					// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- ds_woo_carousel_DEACTIVATE_ERROR is already HTML escaped
                    echo('<p id="ds_woo_carousel_license_form_error">' . ds_woo_carousel_DEACTIVATE_ERROR . '</p>');
                }
                wp_nonce_field('ds_woo_carousel_license_key_deactivate', 'ds_woo_carousel_license_key_deactivate');
                submit_button(esc_html__('Deactivate License Key', 'aspengrove-updater'), '');
                ?>
            </div>
        </form>
    </div>
    <?php
}

function ds_woo_carousel_sanitize_license($new) {
    if (defined('ds_woo_carousel_LICENSE_KEY_VALIDATED')) {
        return $new;
    }
    $old = get_option('ds_woo_carousel_license_key');
    if ($old && $old != $new) {
        delete_option('ds_woo_carousel_license_status'); // new license has been entered, so must reactivate
    }

    // Need to activate license here, only if submitted
    require_once(dirname(__FILE__) . '/license-key-activation.php');
    ds_woo_carousel_activate_license($new); // Always redirects
}