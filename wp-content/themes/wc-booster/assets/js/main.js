jQuery(document).ready(function($) {

 /*------------------------------------------------
              DECLARATIONS
  ------------------------------------------------*/
  var scroll = $(window).scrollTop();
  var scrollup = $('.wc-scroll-to-top');
  /*------------------------------------------------
              BACK TO TOP
  ------------------------------------------------*/
  scrollup.click(function () {
    $('html, body').animate({
      scrollTop: '0px'
    }, 800);
    return false;
  });

  $(window).scroll(function () {
    var scroll = $(window).scrollTop();
    
    if (scroll >= 200) {
      scrollup.fadeIn();
    } else {
      scrollup.fadeOut();
    }
  });

/*------------------------------------------------
                END JQUERY
------------------------------------------------*/



/*------------------------------------------------
            Match Height
------------------------------------------------*/

$('.woocommerce-loop-product__title').matchHeight();
$('.wp-block-post-title').matchHeight();
$('.blog-description-section').matchHeight();
});