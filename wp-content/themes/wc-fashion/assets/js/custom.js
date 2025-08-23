(function ($) {
  $(document).ready(function () {
    const parent = $(".banner-cover");
    const movingImage = $(".banner-background-image");

    parent.on("mousemove", function (e) {
      const mouseX = e.clientX - parent.offset().left;
      const mouseY = e.clientY - parent.offset().top;

      const moveX = (mouseX / parent.width() - 0.5) * 80; // Adjust the factor for the amount of movement
      const moveY = (mouseY / parent.height() - 0.5) * 80; // Adjust the factor for the amount of movement

      movingImage.css("transform", `translate(${moveX}px, ${moveY}px)`);
    });

    parent.on("mouseleave", function () {
      movingImage.css("transform", "translate(0, 0)");
    });


  });

  $(window).on('load', function () {
    $("#loader-wrapper").fadeOut();
    $("#loaded").delay(1000).fadeOut("slow");
  });

  /*------------------------------------------------
              DECLARATIONS
    ------------------------------------------------*/
    var scroll = $(window).scrollTop();
    var scrollup = $('.wc-fashion-scroll-to-top');
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


})(jQuery);