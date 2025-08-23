jQuery( function ($) {
    // Filter shortcode
    $('.yith-wcbr-brand-filter').on('click', '.yith-wcbr-brand-filters a', function (ev) {
        var t = $(this),
            filters = t.parent().find( 'a'),
            toggle = t.data( 'toggle'),
            container = t.closest( '.yith-wcbr-brand-filter' ),
            hasMore = container.data( 'has_more' ) === 'yes',
            brands_ul = t.parents('.yith-wcbr-brand-filters-wrapper').next(),
            brands = brands_ul.find( 'li'),
            brands_to_show = toggle === 'all' ? brands : brands.filter( '[data-heading="' + toggle + '"]' ),
            current_page = window.location.href.match( /.*\/page\/([0-9]+).*/ );

        current_page = ! current_page ? 1 : current_page[1];

        ev.preventDefault();
        filters.removeClass( 'active' );
        t.addClass( 'active' );

        if( hasMore ){
            $.ajax( {
                beforeSend: function(){
                    container.block({
                        message: null,
                        overlayCSS: {
                            background: '#fff',
                            opacity: 0.6
                        }
                    });
                },
                complete: function(){
                    container.unblock();
                },
                data: {
                    action: 'yith_wcbr_brand_filter',
                    filter: toggle,
                    page: ( toggle && toggle !== 'all' ) ? 1 : current_page,
                    shortcode_args: container.data('shortcode_options'),
                    nonce: yith_wcbr.nonce
                },
                method: 'POST',
                success: function( data ){

                    if( $( data ).find( '.yith-wcbr-brands-list' ).find('li').length ) {
                        container.html($(data).html());
                    }
                    else{
                        brands_ul.fadeOut(500, function () {
                            brands.hide();
                            brands_ul.fadeIn(500);
                        });
                        container.find( '.yith-wcbr-brands-pagination' ).remove();
                    }
                },
                url: yith_wcbr.ajax_url
            } );
        }
        else {
            brands_ul.fadeOut(500, function () {
                brands.hide();
                brands_to_show.show();
                brands_ul.fadeIn(500);
            });
        }
    });

    $('.yith-wcbr-brand-filter a.active').trigger('click');

    // Thumbnail carousel shortcode
    var init_thumbnail_carousel = function() {
        var window_width = $(window).outerWidth();

        $('.yith-wcbr-brand-thumbnail-carousel .swiper-container').each(function () {
            var t = $(this),
                dom = t.get(0),
                direction = t.data('direction'),
                slidesPerView = ( window_width < 480 && direction != 'vertical' ) ? yith_wcbr.slides_per_view_mobile : t.data('slidesperview'),
                autoplay = t.data('autoplay'),
                loop = t.data('loop'),
                prev = t.parent().find('.yith-wcbr-button-prev').get(0),
                next = t.parent().find('.yith-wcbr-button-next').get(0),
                pagination = t.parent().find('.yith-wcbr-pagination').get(0);

            if (direction == 'vertical') {
                var wrapper = t.find('ul.swiper-wrapper'),
                    slides = wrapper.find('li'),
                    max_height = 0;

                slides.each(function () {
                    var th = $(this),
                        th_height = th.outerHeight();

                    if (th_height > max_height) {
                        max_height = th_height;
                    }
                });

                wrapper.outerHeight(max_height * slidesPerView + 15);
            }

            new Swiper( dom, {
                // Optional parameters
                slidesPerView: slidesPerView,
                autoplay: autoplay === 'yes' ? {
                    delay: yith_wcbr.thumbnail_carousel_time
                } : false,
                loop: loop === 'yes',
                direction: direction,
                navigation: {
                    nextEl: next,
                    prevEl: prev
                },
                pagination: {
                    el: pagination,
                    clickable: true
                },
                paginationClickable: true,
                watchSlidesVisibility: true,
                breakpoints: {
                    320: {
                        slidesPerView: 2 < slidesPerView ? 2 : slidesPerView
                    },
                    480: {
                        slidesPerView: 3 < slidesPerView ? 3 : slidesPerView
                    },
                    600: {
                        slidesPerView: 4 < slidesPerView ? 4 : slidesPerView
                    },
                    1200: {
                        slidesPerView: slidesPerView
                    }
                },
                on: {
                    init: function () {
                        $( this.slides ).filter('.swiper-slide-visible').removeClass('last').last().addClass('last');
                    },
                    transitionStart: function () {
                        $( this.slides ).filter('.swiper-slide-visible').removeClass('last').last().addClass('last');
                    }
                }
            });
        });
    };

    init_thumbnail_carousel();
    $(window).on( 'resize', init_thumbnail_carousel );

    // Thumbnail carousel shortcode
    var init_product_thumbnail = function(){
        var window_width = $(window).outerWidth();

        $( '.yith-wcbr-product-carousel .swiper-container').each( function() {
            var t = $(this),
                dom = t.get(0),
                direction = t.data('direction'),
                slidesPerView = ( window_width < 480 && direction != 'vertical' ) ? yith_wcbr.slides_per_view_mobile : t.data('slidesperview'),
                autoplay = t.data('autoplay'),
                loop = t.data('loop'),
                prev = t.parent().find( '.yith-wcbr-button-prev'),
                next = t.parent().find( '.yith-wcbr-button-next'),
                pagination = t.parent().find( '.yith-wcbr-pagination' );

            if( direction == 'vertical' ){
                var wrapper = t.find( 'ul.swiper-wrapper'),
                    slides = wrapper.find( 'li'),
                    max_height = 0;

                slides.each( function(){
                    var th = $(this),
                        th_height = th.outerHeight();

                    if( th_height > max_height ){
                        max_height = th_height;
                    }
                } );

                wrapper.outerHeight( max_height * slidesPerView + 15 );
            }

            if( t.find( '.swiper-wrapper' ).parent().is('.yit-wcan-container') ){
                t.find( '.swiper-wrapper' ).unwrap();
            }

            new Swiper( dom, {
                // Optional parameters
                slidesPerView: slidesPerView,
                direction: direction,
                autoplay: autoplay === 'yes' ? {
                    delay: 1500
                } : false,
                loop: loop === 'yes',
                navigation: {
                    nextEl: next,
                    prevEl: prev
                },
                pagination: {
                    el: pagination,
                    clickable: true
                },
                paginationClickable: true,
                watchSlidesVisibility: true,
                breakpoints: {
                    320: {
                        slidesPerView: 2 < slidesPerView ? 2 : slidesPerView
                    },
                    480: {
                        slidesPerView: 3 < slidesPerView ? 3 : slidesPerView
                    },
                    600: {
                        slidesPerView: 4 < slidesPerView ? 4 : slidesPerView
                    },
                    1200: {
                        slidesPerView: slidesPerView
                    }
                },
                onInit: function(swiper){
                    swiper.slides.filter( '.swiper-slide-visible' ).removeClass( 'last' ).last().addClass( 'last' );
                },
                onTransitionStart: function(swiper){
                    swiper.slides.filter( '.swiper-slide-visible' ).removeClass( 'last' ).last().addClass( 'last' );
                }
            });
        });
    };

    init_product_thumbnail();
    $(window).on( 'resize', init_product_thumbnail );
    $(document).on( 'yith-wcan-wrapped', init_product_thumbnail );

    // Brands select shortcode
    $( '.yith-wcbr-brand-select select' ).select2().on( 'change', function(e) {
        var target = $( e.currentTarget),
            val = target.val(),
            option = target.find( 'option[value="' + val + '"]'),
            href = option.data( 'href' );

        if( typeof( href ) != 'undefined' ){
            window.location = href;
        }
    });

    // Brands grid shortcode
    $( '.yith-wcbr-brand-grid select.yith-wcbr-category-dropdown' ).select2().on( 'change', function(e) {
        var t = $(this),
            target = $( e.currentTarget),
            searched_category = target.val(),
            shortcode = t.parents('.yith-wcbr-brand-grid'),
            brands_ul = shortcode.find( '.yith-wcbr-brands-list' ),
            brands = brands_ul.find( 'li');

        brands_ul.fadeOut( 500, function() {
            brands.each(function () {
                var brand = $(this),
                    related_categories = brand.data('categories'),
                    heading_container = brand.parents('.yith-wcbr-same-heading-box'),
                    found = false,
                    reset = false;

                if( searched_category == 0 ){
                    brand.removeClass('hidden').show();
                    reset = true;
                }

                if( ! reset ) {
                    if ( $.inArray( searched_category + "", related_categories) > -1 ) {
                        found = true;
                    }

                    if ( !found ) {
                        brand.addClass('hidden').hide();
                    }
                    else {
                        brand.removeClass('hidden').show();
                    }
                }

                if( heading_container.find( 'li').not('.hidden').length == 0 ){
                    heading_container.hide();
                }
                else{
                    heading_container.show();
                }
            } );

            brands_ul.fadeIn( 500 );
        } );
    }).trigger('change');

    // Filter Brands grid
    $('.yith-wcbr-brand-grid .yith-wcbr-brand-filters').on('click', 'a', function (ev) {
        var t = $(this),
            filters = t.parent().find( 'a'),
            reset = filters.filter( '.reset' ),
            brands_ul = t.parents('.yith-wcbr-brand-grid').find( '.yith-wcbr-brands-list' ),
            brands = brands_ul.find( 'li'),
            searched_categories = [];

        ev.preventDefault();

        if( t.is( '.reset' ) ){
            filters.removeClass( 'active' );
            t.addClass( 'active' );
        }
        else if( t.is( '.active' ) ){
            if( filters.filter( '.active').length != 1 ){
                t.removeClass( 'active' );
            }
            else{
                return;
            }
        }
        else{
            reset.removeClass( 'active' );
            t.addClass( 'active' );
        }

        filters.filter( '.active' ).each( function(){
            var filter = $(this);

            searched_categories.push( filter.data( 'term_id' ) );
        } );

        brands_ul.fadeOut( 500, function() {
            brands.each(function () {
                var brand = $(this),
                    related_categories = brand.data('categories'),
                    heading_container = brand.parents('.yith-wcbr-same-heading-box'),
                    found = false,
                    reset = false;

                if( t.is( '.reset' ) ){
                    brand.removeClass('hidden').show();
                    reset = true;
                }

                if( ! reset ) {
                    for (var i in searched_categories) {
                        if ($.inArray(searched_categories[i] + "", related_categories) > -1) {
                            found = true;
                            break;
                        }
                    }

                    if (!found) {
                        brand.addClass('hidden').hide();
                    }
                    else {
                        brand.removeClass('hidden').show();
                    }
                }

                if( heading_container.find( 'li').not('.hidden').length == 0 ){
                    heading_container.hide();
                }
                else{
                    heading_container.show();
                }
            } );

            brands_ul.fadeIn( 500 );
        } );
    });

    $('.yith-wcbr-brand-grid .yith-wcbr-brand-scroll').on('click', 'a', function(ev){
        var t = $(this),
            heading = t.data('toggle'),
            shortcode = t.parents('.yith-wcbr-brand-grid');

        ev.preventDefault();

        if( shortcode.find( '.yith-wcbr-same-heading-box[data-heading="' + heading + '"]:visible').length > 0 ) {
            $('html, body').animate({scrollTop: shortcode.find('.yith-wcbr-same-heading-box[data-heading="' + heading + '"]:visible').offset().top}, 'slow');
        }
    });

    wp.hooks.addFilter( 'blocks.getBlockAttributes', 'yith/yith-wcbr-brand-filter', legacyGutenbergBlockSupport );
    wp.hooks.addFilter( 'blocks.getBlockAttributes', 'yith/yith-wcbr-brand-thumbnail', legacyGutenbergBlockSupport );
    wp.hooks.addFilter( 'blocks.getBlockAttributes', 'yith/yith-wcbr-brand-thumbnail-carousel', legacyGutenbergBlockSupport );
    wp.hooks.addFilter( 'blocks.getBlockAttributes', 'yith/yith-wcbr-brand-product', legacyGutenbergBlockSupport );
    wp.hooks.addFilter( 'blocks.getBlockAttributes', 'yith/yith-wcbr-brand-product-carousel', legacyGutenbergBlockSupport );
    wp.hooks.addFilter( 'blocks.getBlockAttributes', 'yith/yith-wcbr-brand-select', legacyGutenbergBlockSupport );
    wp.hooks.addFilter( 'blocks.getBlockAttributes', 'yith/yith-wcbr-brand-list', legacyGutenbergBlockSupport );
    wp.hooks.addFilter( 'blocks.getBlockAttributes', 'yith/yith-wcbr-brand-grid', legacyGutenbergBlockSupport );

    function legacyGutenbergBlockSupport( blockAttributes, blockType, innerHTML ){
        var oldArgs = wp.shortcode.attrs( innerHTML );

        if( typeof oldArgs.named.autosense_category !== 'undefined' ){
            if( oldArgs.named.autosense_category === 'yes' ){
                blockAttributes.autosense_category = true;
            }

            else if( oldArgs.named.autosense_category === 'no' ){
                blockAttributes.autosense_category = false;
            }
        }

        if( typeof oldArgs.named.autosense_brand !== 'undefined' ){
            if( oldArgs.named.autosense_brand === 'yes' ){
                blockAttributes.autosense_brand = true;
            }

            else if( oldArgs.named.autosense_brand === 'no' ){
                blockAttributes.autosense_brand = false;
            }
        }

        return blockAttributes;
    }
} );