<?php
/**
 * Easy Digital Downloads Theme Updater
 * This file contains modified code from and/or based on the Software Licensing addon by Easy Digital Downloads
 * Licensed under the GNU General Public License v2.0 or higher; see license.txt in theme root
 *
 */


if (!defined('ABSPATH')) exit;

function ds_woo_carousel_activate_license($license) {
    // data to send in our API request
    $api_params = array(
        'edd_action' => 'activate_license',
        'license'    => $license,
        'item_name'  => urlencode(DS_Woo_Carousel::PLUGIN_NAME), // the name of our product in EDD
        'url'        => home_url()
    );

    // Call the custom API.
    $response = wp_remote_post(DS_Woo_Carousel::PLUGIN_STORE_URL, array('timeout' => 15, 'sslverify' => false, 'body' => $api_params));

    // make sure the response came back okay
    if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {

        if (is_wp_error($response)) {
            $message = $response->get_error_message();
        } else {
            $message = esc_html__('An error occurred, please try again.', 'aspengrove-updater');
        }

    } else {

        $license_data = json_decode(wp_remote_retrieve_body($response));

        if (false === $license_data->success) {

            switch ($license_data->error) {

                case 'expired' :

                    $message = sprintf(
	                    esc_html__('Your license key expired on %s.', 'aspengrove-updater'),
                        date_i18n(get_option('date_format'), strtotime($license_data->expires, current_time('timestamp')))
                    );
                    break;

                case 'revoked' :

                    $message = esc_html__('Your license key has been disabled.', 'aspengrove-updater');
                    break;

                case 'missing' :

                    $message = esc_html__('Invalid license key.', 'aspengrove-updater');
                    break;

                case 'invalid' :
                case 'site_inactive' :

                    $message = esc_html__('Your license key is not active for this URL.', 'aspengrove-updater');
                    break;

                case 'item_name_mismatch' :

                    $message = sprintf(esc_html__('This appears to be an invalid license key for %s.', 'aspengrove-updater'),
                        DS_Woo_Carousel::PLUGIN_NAME);
                    break;

                case 'no_activations_left':

                    $message = esc_html__('Your license key has reached its activation limit. Please deactivate the key on one of your other sites before activating it on this site.', 'aspengrove-updater');
                    break;

                default :

                    $message = esc_html__('An error occurred, please try again.', 'aspengrove-updater');
                    break;
            }

        }

    }

    // Check if anything passed on a message constituting a failure
    if (!empty($message)) {
        delete_option('ds_woo_carousel_license_key');

        $base_url = admin_url(DS_Woo_Carousel::PLUGIN_PAGE);
        $redirect = add_query_arg(array('sl_activation' => 'false', 'sl_message' => urlencode($message), 'license_key' => $license), $base_url);

        wp_redirect($redirect);
        exit;
    }

    // $license_data->license will be either "valid" or "invalid"

    define('ds_woo_carousel_LICENSE_KEY_VALIDATED', true);
    update_option('ds_woo_carousel_license_status', $license_data->license);
    update_option('ds_woo_carousel_license_key', $license);

    wp_redirect(admin_url(DS_Woo_Carousel::PLUGIN_PAGE));
    exit;
}

function ds_woo_carousel_deactivate_license() {

    // run a quick security check
    if (!check_admin_referer('ds_woo_carousel_license_key_deactivate', 'ds_woo_carousel_license_key_deactivate'))
        return; // get out if we didn't click the Activate button

    // retrieve the license from the database
    $license = trim(get_option('ds_woo_carousel_license_key'));

    // data to send in our API request
    $api_params = array(
        'edd_action' => 'deactivate_license',
        'license'    => $license,
        'item_name'  => urlencode(DS_Woo_Carousel::PLUGIN_NAME), // the name of our product in EDD
        'url'        => home_url()
    );

    // Call the custom API.
    $response = wp_remote_post(DS_Woo_Carousel::PLUGIN_STORE_URL, array('timeout' => 15, 'sslverify' => false, 'body' =>
        $api_params));

    // make sure the response came back okay
    if (is_wp_error($response)) {
        return sprintf(
            esc_html__('An error occurred during license key deactivation: %s. Please try again or %scontact support%s.', 'aspengrove-updater'),
            esc_html($response->get_error_message()),
            '<a href="' . esc_url(DS_Woo_Carousel::PLUGIN_STORE_URL) . '" target="_blank">',
            '</a>'
        );
    } else if (200 !== wp_remote_retrieve_response_code($response)) {
        return sprintf(
            esc_html__('An error occurred during license key deactivation. Please try again or %scontact support%s.', 'aspengrove-updater'),
            '<a href="' . esc_url(DS_Woo_Carousel::PLUGIN_STORE_URL) . '" target="_blank">',
            '</a>'
        );
    }

    // decode the license data
    $license_data = json_decode(wp_remote_retrieve_body($response));

    // $license_data->license will be either "deactivated" or "failed"
    delete_option('ds_woo_carousel_license_status');
    delete_option('ds_woo_carousel_license_key');
    if ($license_data->license != 'deactivated') {
        return esc_html__('An error occurred during license key deactivation (your license key may be expired). Your license key has been removed from this site, but it may not have been properly deactivated on our server.', 'aspengrove-updater');
    }

    return true;
}
