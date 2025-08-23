function divi_ecommerce_pro_update_cart_link_text() {
    jQuery.post(
        divi_ecommerce_pro.ajaxurl,
        {action: 'divi_ecommerce_pro_get_cart_link_text'},
        function (response) {
            jQuery('.dsdep-cart-contents .number').text(response);
        },
        'text'
    );
}