<?php
namespace DiviPixel;

$label = $field["label"];
$description = $field["description"];
?>
<div class="dipi_row">
    <div class="dipi_settings_option_description col-md-6">
        <div class="dipi_option_label">
            <?php echo esc_html($label); ?>
        </div>
        <?php if ('' !== $description): ?>
            <div class="dipi_option_description">
                <?php echo esc_html($description); ?>
            </div>
        <?php endif;?>
    </div>
    <div class="col-md-6">
        <?php
        global $dipi_insta_errors_basic;
        if (is_array($dipi_insta_errors_basic)) {
            foreach ($dipi_insta_errors_basic as $dipi_error) {
                echo sprintf(
                    '<div class="dipi_insta_error">
                            %1$s
                        </div>',
                        esc_html($dipi_error)
                );
            }
        }


        $facebook_accounts = DIPI_Settings::get_option('facebook_accounts');
        if (is_array($facebook_accounts) && count($facebook_accounts) > 0) {
            foreach ($facebook_accounts as $facebook_account_id => $facebook_account) {
                if (empty($facebook_account['instagram_accounts'])) {
                    continue;
                }
                ?>
                <div class="dipi_fb_account_wrapper dipi_account_wrapper">
                    <div class="dipi_fb_account">
                        <span class="access_token_indicator access_token_indicator_<?php echo esc_attr($facebook_account['access_token_status']); ?>"></span>
                        <span class="username"><?php echo esc_html($facebook_account['name']); ?></span>
                        <span class="dipi-insta-account-loading" style="display: none;vertical-align: middle;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="margin:auto;background:0 0" width="30" height="25" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" display="block"><circle cx="84" cy="50" r="10" fill="#85a2b6"><animate attributeName="r" repeatCount="indefinite" dur="0.25s" calcMode="spline" keyTimes="0;1" values="10;0" keySplines="0 0.5 0.5 1" begin="0s"/><animate attributeName="fill" repeatCount="indefinite" dur="1s" calcMode="discrete" keyTimes="0;0.25;0.5;0.75;1" values="#85a2b6;#fdfdfd;#dce4eb;#bbcedd;#85a2b6" begin="0s"/></circle><circle cx="16" cy="50" r="10" fill="#85a2b6"><animate attributeName="r" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="0;0;10;10;10" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="0s"/><animate attributeName="cx" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="16;16;16;50;84" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="0s"/></circle><circle cx="50" cy="50" r="10" fill="#bbcedd"><animate attributeName="r" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="0;0;10;10;10" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.25s"/><animate attributeName="cx" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="16;16;16;50;84" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.25s"/></circle><circle cx="84" cy="50" r="10" fill="#dce4eb"><animate attributeName="r" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="0;0;10;10;10" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.5s"/><animate attributeName="cx" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="16;16;16;50;84" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.5s"/></circle><circle cx="16" cy="50" r="10" fill="#fdfdfd"><animate attributeName="r" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="0;0;10;10;10" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.75s"/><animate attributeName="cx" repeatCount="indefinite" dur="1s" calcMode="spline" keyTimes="0;0.25;0.5;0.75;1" values="16;16;16;50;84" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" begin="-0.75s"/></circle></svg>
                        </span>
                        <a  class="dipi-remove-insta-account"
                            href="#"
                            data-nonce="<?php echo esc_attr(wp_create_nonce("dipi_delete_insta_nonce")); ?>"
                            data-id="<?php echo esc_attr($facebook_account_id); ?>"
                            data-type="GRAPH">
                            <?php echo esc_html__('Delete', 'dipi-divi-pixel'); ?>
                        </a>
                    </div>
                    <div class="dipi_fb_insta_account_wrapper">
                        <?php foreach($facebook_account['instagram_accounts'] as $instagram_account_id => $instagram_account): ?>    
                            <div class="dipi_fb_insta_account">
                                <?php echo esc_html($instagram_account['name']);?> (@<?php echo esc_html($instagram_account['username']);?>)
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>           
                <?php
            }
        }
        ?>
    </div>
</div>
