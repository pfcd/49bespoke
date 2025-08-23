/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to files in the scripts/ directory, the license.txt file is located at ../license.txt.
*/

// This script is loaded both on the frontend page and in the Visual Builder.

import qs from 'qs'
import Cookies from 'js-cookie'

jQuery(function($) {

    $( document.body ).on( 'change', 'li.product .qty', function(){
        var addToCartBtn = $(this).parents('.product').find( '.add_to_cart_button' );
        var qty          = parseFloat( $(this).val() );

        if( !qty || qty < parseFloat( $(this).attr('min') ) ){
            $(this).val( $(this).attr('min') ).change();
            return;
        }

        if( addToCartBtn.length ){
            addToCartBtn.attr('data-quantity', parseFloat($(this).val()))
        }
    }).on( 'updated_wc_div', function(){

      $( '.ags_woo_cart_list' ).each(function(){
        var forms = $(this).find('.woocommerce-cart-form');
        if( forms.length > 1 ){
          $(forms[1]).remove();
        }
      });

    });

	// submodule-builder\scripts\frontend\scripts.js
      $('.ags_woo_shop_plus').each(function() {
        let $this_el    = $(this);
        let icon        = $this_el.data('icon') || '';
        let icon_tablet = $this_el.data('icon-tablet') || '';
        let icon_phone  = $this_el.data('icon-phone') || '';
        let icon_sticky = $this_el.data('icon-sticky') || '';
        let $overlay    = $this_el.find('.et_overlay');

        // Set data icon and inline icon class.
        if (icon !== '') {
          $overlay.attr('data-icon', icon).addClass('et_pb_inline_icon');
        }

        if (icon_tablet !== '') {
          $overlay.attr('data-icon-tablet', icon_tablet).addClass('et_pb_inline_icon_tablet');
        }

        if (icon_phone !== '') {
          $overlay.attr('data-icon-phone', icon_phone).addClass('et_pb_inline_icon_phone');
        }

        if (icon_sticky !== '') {
          $overlay.attr('data-icon-sticky', icon_sticky).addClass('et_pb_inline_icon_sticky');
        }

        /*if ($this_el.hasClass('et_pb_shop')) {
          const $shopItems = $this_el.find('li.product');
          const shop_index = $this_el.attr('data-shortcode_index');
          const itemClass  = `et_pb_shop_item_${shop_index}`;

          if ($shopItems.length > 0) {
            $shopItems.each((idx, $item) => {
              $($item).addClass(`${itemClass}_${idx}`);
            });
          }
        }*/
      });

      if( $( '.ags_woo_notices' ).length && $( '.ags_woo_checkout_coupon' ).length ){

        $( document.body ).on( 'applied_coupon_in_checkout', function(){

          var notices = $( '.ags_woo_notices' );
          notices.find( '.woocommerce-notices-wrapper' ).html( '' );

          $( '.ags_woo_checkout_coupon' )
            .find( '.woocommerce-error, .woocommerce-info, .woocommerce-message' )
            .each( function(){
              if( $(this).parents( '.woocommerce-form-coupon-toggle' ).length ){
                return;
              }

              $(this).appendTo( notices.find( '.woocommerce-notices-wrapper' ) );
            });

        })

      }

      if( $( 'form .ags_woo_checkout_billing_info' ).length ){
        $( document.body ).on( 'updated_checkout checkout_error', function(){

          var notices = $( '.ags_woo_notices' );
          if( notices.length ){
            notices.find( '.woocommerce-notices-wrapper' ).html( '' );
            notices.append( $( '.woocommerce-NoticeGroup-checkout' ) );
          }else{
            $( '.woocommerce-NoticeGroup-checkout' ).prependTo( $( 'form.checkout' ).find( '.et_pb_row' ).first() );
          }
        });
      }

      $('.ags_woo_shop_plus')
        .on( 'click', 'a.page-numbers', function(){
          var itemName = 'ags_woo_shop_plus_' + et_pb_custom.page_id;
          var value    = $(this).parents('.ags_woo_shop_plus').data('shortcode_index');
          localStorage.setItem( itemName, value );
        })
        .on( 'click', '.ags_woo_shop_plus_multiview button', function(){
          var view      = $(this).hasClass('grid-view') ? 'grid' : 'list';
          var index     = $(this).parents('.ags_woo_shop_plus').data('shortcode_index');
          var item_name = 'ags_woo_shop_plus_' + et_pb_custom.page_id + '_' + index;
          Cookies.set( item_name, view, { expires: 7 } ); //save for 7 days
        });

      if( $('.ags_woo_shop_plus').length ){

        var queries  = qs.parse( window.location.search, { ignoreQueryPrefix: true, plainObjects: true, parseArrays: false } );
        var itemName = 'ags_woo_shop_plus_' + et_pb_custom.page_id;
        var value    = localStorage.getItem( itemName );

        if( value !== '' && queries['dsb-product-page'] && queries['dsb-product-page'][value]  ){
            et_pb_smooth_scroll( $( '.ags_woo_shop_plus_' + value ) );
        }

        localStorage.removeItem( itemName );
      }


      if( $('.ags_woo_checkout_order_review').length && $('.ags_woo_checkout_order_review').hasClass('et_pb_sticky_module') ){

        setInterval(function(){
          $('.ags_woo_checkout_order_review:not(.et_pb_sticky_placeholder) .payment_box:visible').each(function(){
            $(this).closest('.wc_payment_methods').find('.wc_payment_method').not($(this).parent()).removeClass('active');
            $(this).parent().addClass('active');

            var radio = $(this).parent().find('.input-radio');
            if( !radio.prop('checked') ){
              radio.prop('checked', true).change();
            }
          });
        }, 100);

      }

      $(document.body).on('wc_cart_button_updated', function(e, button){
        var addedToCartBtn = button.next('.added_to_cart');
        var parentEl       = button.closest('.ags_woo_shop_plus');
        if( addedToCartBtn.length && parentEl.length ){
          addedToCartBtn.attr( 'data-icon', button.data('view_cart_icon') );
        }
      });

	  $(document.body).on('click', '.ags_woo_shop_plus_multiview button', function() {
		  var $this = $(this);
		  
			 if( $this.hasClass('active') ){
				return;
			  }
			  
			var views = $this.closest('.ags_woo_shop_plus').find('.ags-divi-wc-layout-grid, .ags-divi-wc-layout-list');

			  $this.siblings().removeClass('active');
			 $this.addClass('active');

			  var newView = $this.hasClass('grid-view') ? 'grid' : 'list';
			  views.fadeOut(200);
			  views.filter('.ags-divi-wc-layout-' + newView).fadeIn(200);
	  });

});
