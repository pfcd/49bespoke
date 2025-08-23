// Admin Notice
jQuery(document).ready(function ($) {
    $('#divi-shop-builder-notice .notice-dismiss'
    ).on('click', function () {
        jQuery.post(ajaxurl, {action: 'ds_divi_shop_builder_notice_hide'})
    });
});