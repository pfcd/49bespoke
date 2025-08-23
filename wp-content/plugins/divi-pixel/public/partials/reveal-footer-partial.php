<script type="text/javascript" id="reveal-footer-partial-js">
(function ($) {

    $(document).ready(function () {

        var original_content_margin_bottom = get_content_element().css("margin-bottom");
        var original_z_index = get_content_element().css("z-index");
        var original_position = get_content_element().css("position");
        var observer;
        var is_enabled = false;

        function dipi_revealing_footer_remove() {
            if (observer) observer.disconnect();

            var content = get_content_element();
            if (content) {
                content.removeClass("dipi_revealing_footer_content");
            }

            var footer = get_footer_element();
            if (footer) {
                footer.removeClass("dipi_revealing_footer_footer");
            }

            var footer_g = get_footer_global_element();
            if (footer_g) {
                footer_g.removeClass("dipi_revealing_footer_footer");
            }
        }

        function dipi_revealing_footer_apply() {

            if (!is_divi() && !is_extra()) {
                return;
            }

            var footer = get_footer_element();
            var content = get_content_element();
            var footer_g = get_footer_global_element();

            var pageContainer = $("#page-container");

            //Make sure #page-container is not transparent
            let color = pageContainer.css("background-color");
            if (!color || color === '' || color === 'rgba(0, 0, 0, 0)' || color === 'transparent') {
                pageContainer.css("background-color", "inherit");
            }

            set_footer_offset();
            set_footer_global_offset();

            $(window).scroll(function (event) {
                set_footer_offset();
                set_footer_global_offset();
            });

            $(window).resize(function () {
                set_footer_offset();
                set_footer_global_offset();
            });

            setup_mutation_observer();

            setup_footer_css();

            function set_footer_offset() {

                if(!is_enabled) {
                    return;
                }

                
                
                //Get viewport height
                var windowHeight = $(window).outerHeight();   // returns height of browser viewport (how much is currently visible)
                
                //Get obscured are
                var obscured = 0;
                var wpadminbar = $("#wpadminbar");
                if (wpadminbar.length && wpadminbar.css("position") === "fixed") {
                    obscured += wpadminbar.outerHeight();
                }
                
                //Get footer height
                var footerHeight = footer ? footer.outerHeight() : 0;
                
                var fixedHeader = $("#main-header");
                // if (fixedHeader.length && fixedHeader.css("position") === "fixed") {
                //     obscured += fixedHeader.outerHeight();
                //     footerHeight += fixedHeader.outerHeight();
                // }
               
               
                
                //Set bottom margin of main content to footer height
                content.css("margin-bottom", footerHeight + "px");

                if ((windowHeight - obscured) < (content.outerHeight() + footer.outerHeight())) {
                    var offset = (windowHeight - obscured) - footer.outerHeight();

                    var pageHeight = content.outerHeight();
                    if (wpadminbar.length && wpadminbar.css("position") !== "fixed") {
                        pageHeight += wpadminbar.outerHeight();
                    }
                    if (fixedHeader.length && fixedHeader.css("position") !== "fixed") {
                        pageHeight += fixedHeader.outerHeight();
                    }

                    var docScrollTop = $(document).scrollTop();

                    offset -= Math.min((pageHeight - docScrollTop), 0);
                    offset = Math.min(offset, 0);
                    footer.css("bottom", offset + "px");

                } else {

                    var offset = windowHeight - obscured - content.outerHeight() - footer.outerHeight();
                    if (wpadminbar.length && wpadminbar.css("position") !== "fixed") {
                        offset -= wpadminbar.outerHeight();
                    }

                    if (fixedHeader.length && fixedHeader.css("position") !== "fixed") {
                        offset -= fixedHeader.outerHeight();
                    }
 
                    if(footer.hasClass('fixed-footer')) {
                        footer.css('cssText', 'bottom:0px;');
                    } else {
                          footer.css('cssText', 'bottom:'+ offset +'px;');
                    }
                }
            }

            function set_footer_global_offset() {

                if(!is_enabled || !footer_g) {
                    return;
                }

                

                //Get viewport height
                var windowHeight = $(window).outerHeight();   // returns height of browser viewport (how much is currently visible)

                //Get obscured are
                var obscured = 0;
                var wpadminbar = $("#wpadminbar");
                if (wpadminbar.length && wpadminbar.css("position") === "fixed") {
                    obscured += wpadminbar.outerHeight();
                }

                //Get footer_g height
                var footer_gHeight = footer_g ? footer_g.outerHeight() : 0;

                
                var fixedHeader = $("#main-header");
                // if (fixedHeader.length && fixedHeader.css("position") === "fixed") {
                //     obscured += fixedHeader.outerHeight();
                //     footer_gHeight += fixedHeader.outerHeight();
                // }

                //Set bottom margin of main content to footer_g height
                content.css("margin-bottom", footer_gHeight + "px");

                if ((windowHeight - obscured) < (content.outerHeight() + footer_gHeight)) {
                    var offset = (windowHeight - obscured) - footer_gHeight;

                    var pageHeight = content.outerHeight();
                    if (wpadminbar.length && wpadminbar.css("position") !== "fixed") {
                        pageHeight += wpadminbar.outerHeight();
                    }
                    if (fixedHeader.length && fixedHeader.css("position") !== "fixed") {
                        pageHeight += fixedHeader.outerHeight();
                    }

                    var docScrollTop = $(document).scrollTop();

                    offset -= Math.min((pageHeight - docScrollTop), 0);
                    offset = Math.min(offset, 0);
                    footer_g.css("bottom", offset + "px");
                } else {
                    var offset = windowHeight - obscured - content.outerHeight() - footer_gHeight;
                    if (wpadminbar.length && wpadminbar.css("position") !== "fixed") {
                        offset -= wpadminbar.outerHeight();
                    }
                    if (fixedHeader.length && fixedHeader.css("position") !== "fixed") {
                        offset -= fixedHeader.outerHeight();
                    }
                    if(footer_g.hasClass('fixed-footer')) {
                        footer_g.css('cssText', 'bottom:0px;z-index: 2 !important');
                    } else {
                          footer_g.css('cssText', 'bottom:'+ offset +'px;');
                    }
                }
            }

            function setup_mutation_observer() {
                if(!pageContainer || !pageContainer[0]){
                    return;
                }
                if (observer) {
                    observer.disconnect();
                }
                observer = new MutationObserver(function (mutations) {
                    set_footer_offset();
                    set_footer_global_offset();
                });
                var config = { subtree: true, childList: true };
                // observer.observe(get_footer_element()[0], config);
                observer.observe(pageContainer[0], config);
            }

            function setup_footer_css() {
                content.addClass("dipi_revealing_footer_content");
                footer.addClass("dipi_revealing_footer_footer");
                if (footer_g) {
                    footer_g.addClass("dipi_revealing_footer_footer");
                }
                // footer.css("position", "fixed");
                // footer.css("left", "0");
                // footer.css("right", "0");

                // content.css("box-shadow", "0 10px 20px rgba(0, 0, 0, 0.22), 0 14px 56px rgba(0, 0, 0, 0.25)");
                // content.css("z-index", "10 !important");
                // content.css("position", "relative");
            }
        }

        function is_divi() {
            return $("body").hasClass("et_divi_theme");
        }

        function is_extra() {
            return $("body").hasClass("et_extra");
        }

        function get_footer_element() {
            if (is_extra()) {
                return $("#footer");
            } else if (is_divi()) {
                return $("#main-footer");
            } else {
                return null;
            }
        }

        function get_footer_global_element(){

            if (is_divi()) {
                return $(".et-l--footer");
            } else {
                return null;
            }
        }

        function get_content_element() {

            if (is_extra()) {

                if ($("#main-content").length) {
                    return $("#main-content");
                } else {
                    return $("#page-container > div.et_pb_section:last-of-type");
                }

            } else if (is_divi()) {

                return $("#main-content");

            } else {

                return null;

            }
        }

        var desktop = null;
        var tablet = null;
        var phone = null;

        if ($("body").hasClass("dipi_revealing_footer_desktop")) {
            desktop = window.matchMedia("(min-width: 981px)");
            desktop.addListener(dipi_revealing_footer_run);
        }

        if ($("body").hasClass("dipi_revealing_footer_tablet")) {
            tablet = window.matchMedia("(min-width: 768px) and (max-width: 980px)");
            tablet.addListener(dipi_revealing_footer_run);
        }

        if ($("body").hasClass("dipi_revealing_footer_phone")) {
            phone = window.matchMedia("(max-width: 767px)");
            phone.addListener(dipi_revealing_footer_run);
        }


        function dipi_revealing_footer_run() {
            if ((desktop && desktop.matches) || (tablet && tablet.matches) || (phone && phone.matches)) {
                is_enabled = true;
                dipi_revealing_footer_apply();
            } else {
                is_enabled = false;
                dipi_revealing_footer_remove();
            }
        }

        dipi_revealing_footer_run();

    });

})(jQuery);

</script>

<style type="text/css" id="reveal-footer-partial-css">

    #page-container {
        overflow-y: visible !important;
    }

    body.et_pb_pagebuilder_layout div#et-main-area div#main-content {
        background: white;
        background-color: white;
    }

    body.et-fb .dipi_revealing_footer_content.et-fb-app-wrapper--no-z-index,
    .dipi_revealing_footer_content {
        position: relative;
    }

    .et-l--header{position:relative;z-index: 3}
    .dipi_revealing_footer_content{
        z-index:2;
    }
    .dipi_revealing_footer_footer {
        z-index: 1 !important;
        position: fixed;
        left: 0;
        right: 0;
    }

    .dipi_revealing_footer_content {
        background: inherit;
    }
</style>
