<?php
/**
 * Add Custom Admin Bar Menu Link
 *
 * @param $admin_bar
 *
 * @return void
 */
if (!function_exists('dipi_csc_maybe_admin_bar_link')):
    function dipi_csc_maybe_admin_bar_link($admin_bar)
    {
        $admin_bar->add_menu([
            'id' => 'dipi_csc',
            'title' => '<span class="ab-icon"></span><span class="ab-label">Clear Divi Cache</span>',
            'href' => '',
            'meta' => [
                'title' => '',
            ],
        ]);
        $admin_bar->add_menu([
            'id' => 'dipi_clear_static_css',
            'parent' => 'dipi_csc',
            'title' => sprintf('<span data-wpnonce="%1$s">%2$s</span>', wp_create_nonce('dipi_clear_static_css'), esc_html('Clear Static CSS File Generation')),
            'href' => 'javascript:void(0)',
        ]);
        $admin_bar->add_menu([
            'id' => 'dipi_csc_clear_local_storage',
            'parent' => 'dipi_csc',
            'title' => esc_html('Clear Local Storage'),
            'href' => 'javascript:void(0)',
        ]);
    }

    add_action('admin_bar_menu', 'dipi_csc_maybe_admin_bar_link', 999);
endif;
/**
 * Add Javascript In Admin Footer
 *
 * @return void
 */
if (!function_exists('dipi_csc_maybe_admin_scripts')):
    function dipi_csc_maybe_admin_scripts()
    {
        ?>
        <script>
            jQuery(document).ready(function () {
                var adminAaxURL = '<?php echo esc_url(admin_url('admin-ajax.php')); ?>';
                var isAdmin = '<?php echo esc_html(is_admin()); ?>';
                // Clear Static CSS
                jQuery("#wp-admin-bar-dipi_clear_static_css").click(function (e) {
                    e.preventDefault();
                    jQuery.ajax({
                        type: 'post',
                        dataType: 'json',
                        url: adminAaxURL,
                        data: {
                            'action': 'dipi_clear_static_css',
                            '_wpnonce': jQuery(this).find('span').data('wpnonce')
                        },
                        success: function (response) {
                            if (response.success) {
                                let successData = response.data;
                                if (isAdmin) {
                                    let messageHTML = '<div class="notice notice-success pac-misc-message"><p>' + successData + '</p></div>';
                                    if (jQuery('body .wrap h1').length > 0) {
                                        jQuery('body .wrap h1').after(messageHTML);
                                    } else {
                                        jQuery('body #wpbody-content').prepend(messageHTML);
                                    }
                                    setTimeout(function () {
                                        jQuery(".pac-misc-message").remove();
                                    }, 3500);
                                } else {
                                    alert(successData);
                                }
                            }
                        },
                    });
                });
                // Clear Local Storage
                jQuery("#wp-admin-bar-dipi_csc_clear_local_storage").click(function (e) {
                    e.preventDefault();
                    let msgText = 'The local storage has been cleared!';
                    window.localStorage.clear();
                    if (isAdmin) {
                        let messageHTML = '<div class="notice notice-success pac-misc-message"><p>' + msgText + '</p></div>';
                        if (jQuery('body .wrap h1').length > 0) {
                            jQuery('body .wrap h1').after(messageHTML);
                        } else {
                            jQuery('body #wpbody-content').prepend(messageHTML);
                        }
                        setTimeout(function () {
                            jQuery(".pac-misc-message").remove();
                        }, 3500);
                    } else {
                        alert(msgText);
                    }
                });
            });
        </script>
        <?php
    }

    add_action('admin_footer', 'dipi_csc_maybe_admin_scripts');
    add_action('wp_footer', 'dipi_csc_maybe_admin_scripts');
endif;
/**
 * Process Ajax Request
 *
 * @return void
 */
if (!function_exists('dipi_csc_maybe_ajax_request')):
    function dipi_csc_maybe_ajax_request()
    {
        if (isset($_POST['_wpnonce']) &&
            !empty(isset($_POST['_wpnonce'])) &&
            wp_verify_nonce( sanitize_text_field($_POST['_wpnonce']), 'dipi_clear_static_css' ) &&
            isset( $_POST['action'] ) &&
            'dipi_clear_static_css' === sanitize_text_field( $_POST['action'] ) ) {
            // Check the nonce with check_admin_referer() for improved security
            if ( check_admin_referer( 'dipi_clear_static_css', '_wpnonce' ) ) {
                // Nonce verification succeeded; process the action
                ET_Core_PageResource::remove_static_resources( 'all', 'all' );
                wp_send_json_success( esc_html( 'The static CSS file generation has been cleared!' ), 200 );
            } else {
                // Nonce verification failed; handle the error
                wp_send_json_error( esc_html( 'Invalid nonce.' ), 403 );
            }
        }
    }

    add_action('wp_ajax_dipi_clear_static_css', 'dipi_csc_maybe_ajax_request');
endif;