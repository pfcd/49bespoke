<script type="text/javascript">
jQuery(document).ready(function($){

    function dipi_fixed_footer() {

        var $adminBar = $("body:not(.et-fb) #wpadminbar");
        var $main = $("body:not(.et-fb) #et-main-area");

        var $header = $("body:not(.et-fb) #main-header");
        var $footer = $("body:not(.et-fb) #main-footer");

        var $header_g = $("body:not(.et-fb) .et-l--header");
        var $header_g_height = ($("header.et-l").hasClass('et-l--header')) ? $header_g : $header;
        var $footer_g = $("body:not(.et-fb) .et-l--footer");
        $footer_g.removeClass('fixed-footer');
        var $body_height = $('body').height();
        var $window_height = $(window).height();

        $window_height = ($window_height+32);

        if (typeof $footer === 'undefined') return 0;
        if (typeof $footer_g === 'undefined') return 0;
        
        if ($("footer.et-l").hasClass('et-l--footer')) {
            if ( $body_height <= $window_height ) {
                /*$main.css({
                    height: $(window).height() - ($header_g_height.height() + $adminBar.outerHeight())
                });*/

                $footer_g.addClass('fixed-footer');
            } else {
                /*$main.css({
                    height: ""
                });*/
                
            }

        } else {
            if ( $body_height <= $window_height ) {
                /*$main.css({
                    height: $(window).height() - ( $header.outerHeight() + $adminBar.outerHeight() )
                });*/
                jQuery('#main-footer').addClass('fixed-footer');
            } else {
                /*$main.css({
                    height: ""
                });*/
            }
        }
    }

    $(document).ready(function() {

        dipi_fixed_footer();

        $(window).scroll(function() {
            dipi_fixed_footer()
        });

        $(window).resize(function() {
            dipi_fixed_footer()
        });

    });

});
</script>
