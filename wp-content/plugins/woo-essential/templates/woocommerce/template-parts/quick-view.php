<?php

/**
 * The template for displaying product content in the quickview-product.php template
 *
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $product;
$post_thumbnail_id = $product->get_image_id();
$attachment_ids = $product->get_gallery_image_ids();
$dnwoo_nonce      = wp_create_nonce('dnwoo-essential-nonce');
$orderclass       = isset($_POST['orderclass']) || wp_verify_nonce(sanitize_key($dnwoo_nonce), 'quick_view_popup') ? sanitize_text_field(wp_unslash($_POST['orderclass'])) : '';

?>
<div class="dnwoo-modal-row dnwoo-mb-n30 dnwoo_product_filter_wrapper_inner_mgpop <?php esc_attr_e($orderclass); ?>">
    <!-- Product Images Start -->
    <div class="dnwoo-modal-col dnwoo-mb-30 dnwoo-grid-slider-container">
        <div class="product-images">
            <div class="product-gallery-slider swiper-container dnwoo-quick-view-slide">
                <div class="swiper-wrapper">

                    <?php $html = wc_get_gallery_image_html($post_thumbnail_id, true); ?>
                    <div class="swiper-slide">
                        <?php
                        echo wp_kses_post(apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id));
                        ?>
                    </div>
                    <?php
                    if ($attachment_ids) {
                        foreach ($attachment_ids as $attachment_id) {
                    ?>
                            <div class="swiper-slide">
                                <?php
                                $html = wc_get_gallery_image_html($attachment_id, true);
                                echo wp_kses_post(apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $attachment_id));
                                ?>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <!--                <div class="swiper-pagination"></div>-->
                <!--                <div class="swiper-button-prev" data-icon="4"></div>-->
                <!--                <div class="swiper-button-next" data-icon="5"></div>-->
            </div>
        </div>
        <div thumbsSlider="" class="swiper dnwoo-quick-view-thumbnails">
            <div class="swiper-wrapper">
                <?php if ($product->get_image_id()) : ?>
                    <div class="swiper-slide">
                        <?php
                        $thumbnail_src = wp_get_attachment_image_src($post_thumbnail_id, 'woocommerce_gallery_thumbnail');
                        echo '<img src=" ' . esc_url($thumbnail_src[0]) . ' " alt="' . esc_attr(get_the_title()) . '">';
                        ?>
                    </div>
                <?php endif; ?>
                <!--                --><?php
                                        //                    if ( $attachment_ids && $product->get_image_id() ) {
                                        //                        foreach ( $attachment_ids as $attachment_id ) {
                                        //                            
                                        ?>
                <!--                <div class="swiper-slide">-->
                <!--                    --><?php
                                            //                                    $thumbnail_src = wp_get_attachment_image_src( $attachment_id, 'woocommerce_gallery_thumbnail' );
                                            //                                    echo '<img src=" '.esc_url( $thumbnail_src[0] ).' " alt="'.esc_attr( get_the_title() ).'">';
                                            //                                
                                            ?>
                <!--                </div>-->
                <!--                --><?php
                                        //                        }
                                        //                    }
                                        //                
                                        ?>
            </div>
        </div>
    </div>
    <!-- Product Images End -->

    <!-- Product Summery Start -->
    <div class="dnwoo-modal-col dnwoo-mb-30 grid-product-details-container">
        <?php do_action('dnwoo_quickview_before_summary'); ?>
        <div class="dnwoo-product-summery dnwoo-custom-scroll">
            <h3 class="product-title"><?php esc_html_e($product->get_title()); ?></h3>
            <?php echo wc_get_rating_html($product->get_average_rating(), $product->get_rating_count()); //phpcs:ignore 
            ?>
            <div class="product-price">
                <?php echo wp_kses_post($product->get_price_html()); ?>
            </div>
            <div class="product-description">
                <?php _e($product->get_short_description()); //phpcs:ignore 
                ?>
            </div>
            <div class="product-buttons dnwoo-quick-cart">
                <?php woocommerce_template_single_add_to_cart(); ?>
            </div>

            <?php

            woocommerce_template_single_meta();

            ?>


        </div> <!-- Product Summery End -->
        <?php do_action('dnwoo_quickview_after_summary'); ?>
    </div>
    <script>
        jQuery(document).ready(function($) {
            const products_data = $('form.variations_form.cart').data('product_variations');
            var product_price = '<?php echo wp_kses_post($product->get_price_html()); ?>';

            $('.single_add_to_cart_button').on('click', function(e) {

                e.preventDefault();
                if (!checkAttributesAndDisableButton()) {
                    alert('Please select all attributes');
                    return;
                }

                var $thisbutton = $(this),
                    $form = $thisbutton.closest('form.cart'),
                    id = $thisbutton.val(),
                    product_qty = $form.find('input[name=quantity]').val() || 1,
                    product_id = $form.find('input[name=product_id]').val() || id,
                    variation_id = $form.find('input[name=variation_id]').val(),
                    attributes = {}; // Declare attributes here

                // Collect attributes
                $form.find('select[name^=attribute]').each(function() {
                    var attribute_name = $(this).attr('name');
                    attributes[attribute_name] = $(this).val();
                });

                var data = {
                    action: 'dnwoo_ajax_add_to_cart',
                    product_id: product_id,
                    product_sku: '',
                    quantity: product_qty,
                    variation_id: variation_id, // We're not using variation_id anymore
                    attributes: attributes // We're sending selected attributes instead
                };

                $(document.body).trigger('adding_to_cart', [$thisbutton, data]);

                $.ajax({
                    type: 'post',
                    url: wc_add_to_cart_params.ajax_url,
                    data: data,
                    beforeSend: function(response) {
                        $thisbutton.removeClass('added').addClass('loading');
                    },
                    complete: function(response) {
                        $thisbutton.addClass('added').removeClass('loading');
                    },
                    success: function(response) {
                        if (response.error & response.product_url) {
                            window.location = response.product_url;
                            return;
                        } else {
                            $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
                        }
                    },
                });
            });


            function checkAttributesAndDisableButton() {

                // Assuming your attributes are select elements with class 'attribute'
                var allAttributesSelected = true;
                var filtered_products_data = [];
                attributes = [];
                // Collect attributes
                $('form').find('select[name^=attribute]').each(function() {
                    var attribute_name = $(this).attr('name');
                    attributes[attribute_name] = $(this).val();
                });

                if (products_data?.length > 0) {

                    filtered_products_data = products_data.filter(function(el) {
                        var match = true;
                        for (var key in attributes) {
                            if (attributes.hasOwnProperty(key) && el.attributes[key].length > 0) {
                                if (attributes[key] != el.attributes[key]) {
                                    match = false;
                                }
                            }
                        }
                        return match;
                    });
                }

                if (filtered_products_data.length > 0) {
                    console.log(filtered_products_data[0])
                    document.querySelector('.swiper-slide img').src = filtered_products_data[0].image.src
                    //let symbol = '<?php //echo esc_html(get_woocommerce_currency_symbol()); ?>//';

                    if(filtered_products_data[0].availability_html.length == 0){

                        $(".single_variation").html(filtered_products_data[0].price_html);
                        $('.woocommerce-variation-add-to-cart').find("input[name=product_id]").val(filtered_products_data[0].variation_id);
                        $('.woocommerce-variation-add-to-cart').find("input[name=add-to-cart]").val(filtered_products_data[0].variation_id);
                        $('.woocommerce-variation-add-to-cart').find("input[name=variation_id]").val(filtered_products_data[0].variation_id);

                    }else{
                        $(".single_variation").html(filtered_products_data[0].availability_html);
                    }
                }

                // arrtribute name object  length
                var attributesLength = Object.keys(attributes).length;
                if (attributesLength > 0) {

                    // check if all attributes are selected or not
                    $('.single_add_to_cart_button').removeClass('disabled');
                    //  attributes is an object so we need to foreach loop
                    for (var key in attributes) {
                        if (attributes.hasOwnProperty(key)) {
                            if (attributes[key] == '') {
                                $('.single_add_to_cart_button').addClass('disabled');
                                $(".single_variation").html('');
                                allAttributesSelected = false;
                            }
                        }
                    }
                } else {
                    allAttributesSelected = true;
                    $('.single_add_to_cart_button').removeClass('disabled');
                }
console.log(allAttributesSelected);
                return allAttributesSelected; // return the value of attribute selected or not

            } // end of checkAttributesAndDisableButton function
            checkAttributesAndDisableButton(); // first time run only when page load

            $('form').find('select[name^=attribute]').on('change', function() {
                checkAttributesAndDisableButton();
            });

            function reset() {
                $('.single_variation').html('');
                $('.product-price').html(product_price);
                document.querySelector('.swiper-slide img').src = '<?php echo esc_url(wp_get_attachment_image_src($post_thumbnail_id, 'woocommerce_gallery_thumbnail')[0]); ?>';
            }
        });
    </script>