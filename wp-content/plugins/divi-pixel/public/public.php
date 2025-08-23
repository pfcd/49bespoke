<?php

namespace DiviPixel;

class DIPI_Public
{
    public function __construct()
    {
        add_action('init', [$this, 'init']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('login_enqueue_scripts', [$this, 'add_custom_login_page']);
        add_action('template_redirect', [$this, 'coming_soon_page'], 10);
        add_action( 'admin_bar_menu', [$this, 'admin_bar_menu'] , 999 );
        add_action('et_theme_builder_template_before_page_wrappers', [$this, 'et_theme_builder_template_before_page_wrappers']);
        add_filter('et_html_main_header', [$this, 'et_html_main_header']);
        add_action('wp_head', [$this, 'wp_head']);
        add_action('et_before_main_content', [$this, 'header_top_content']);
        add_action('et_after_main_content', [$this, 'after_main_content']);
        add_action('et_after_post', [$this, 'after_single_content']);
        add_action('et_theme_builder_template_after_body', [$this, 'after_single_content_builder_template']);
        add_filter('login_headerurl', [$this, 'custom_loginlogo_url']);
        add_action('admin_head', [$this, 'add_custom_admin_login_page']);
        add_action('wp_footer', [$this, 'hide_admin_bar']);
        add_action('body_class', [$this, 'body_class'], 5);
        add_filter('template_include', [$this, 'template_include']);
        add_action('wp_footer', [$this, 'back_to_top'], 999);
        add_action('wp_footer', [$this, 'wp_footer'], 999);

        if (!DIPI_Settings::get_option('md_masonry_gallery') || !DIPI_Settings::get_option('md_filterable_gallery')) {
            add_filter( 'attachment_fields_to_edit', [$this, 'custom_media_add_media_custom_field'], null, 2 );
            add_action( 'edit_attachment', [$this,'custom_media_save_attachment'] );
        }
    }
    //function to add custom media field
    function custom_media_add_media_custom_field( $form_fields, $post ) {
        $media_link_url = get_post_meta( $post->ID, 'media_link_url', true );
        $form_fields['media_link_url'] = array(
            'value' => $media_link_url ? $media_link_url : '',
            'label' => __( 'Divi Pixel Image Link' ),
            'helps' => __( 'When clicked on the image of Masonry Gallery or Filterable Gallery, will link to this URL.' ),
            'input'  => 'text'
        );
        
        // Set up options
        $media_link_target = get_post_meta( $post->ID, 'media_link_target', true );
        $options = array( '0' => 'In The Same Window', '1' => 'In The New Tab' );
        // If no selected value, default to 'No'
        if( !isset( $media_link_target ) ) 
            $media_link_target = '0';
        // Display each option	
        foreach ( $options as $value => $label ) {
            $checked = '';
            $css_id = 'media-link-target-option-' . $value;
            if ( $media_link_target == $value ) {
                $checked = " checked='checked'";
            }

            $html = "<div><input type='radio' name='attachments[$post->ID][media_link_target]' id='{$css_id}' value='{$value}'$checked />";

            $html .= "<label for='{$css_id}'>$label</label>";

            $html .= '</div>';

            $out[] = $html;
        }            
        $form_fields['media_link_target'] = array(
            'label' => __( 'Divi Pixel Image Link Target' ),
            'helps' => __( 'Choose whether or not your link opens in a new window' ),
            'html'  => join("\n", $out),
            'input'  => 'html'
        );
        return $form_fields;
    }

    //save your custom media field
    function custom_media_save_attachment( $attachment_id ) {
        // phpcs:disable
        if ( isset( $_REQUEST['attachments'][ $attachment_id ]['media_link_url'] ))  {
            $media_link_url = sanitize_url($_REQUEST['attachments'][ $attachment_id ]['media_link_url']);
            update_post_meta( $attachment_id, 'media_link_url', $media_link_url );
        }
        if ( isset( $_REQUEST['attachments'][ $attachment_id ]['media_link_target'] ) ) {
            $media_link_target = sanitize_text_field($_REQUEST['attachments'][ $attachment_id ]['media_link_target']);
            update_post_meta( $attachment_id, 'media_link_target', $media_link_target );
        }
        // phpcs:enable
    }


    public function init() {
        $this->register_scripts();
        $this->register_styles();
        $this->new_nav_menu_items(); //FIXME: Is this the right location to do this or is there a more suitable hook?
        $this->add_mobile_social_icons();
        $this->add_primary_social_icons();
    }

    private function register_scripts(){
        /**
         * 3rd Party Scripts
         */
        wp_register_script('magnific-popup', plugins_url('dist/vendor/js/magnific-popup.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));
        wp_register_script('easypiechart', plugins_url('dist/vendor/js/easypiechart.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));
        wp_register_script('circliful', plugins_url('dist/vendor/js/circliful.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));
        wp_register_script('dipi_imagesloaded', plugins_url('dist/vendor/js/imagesloaded.pkgd.min.js', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_script('dipi_jquery_countdown', plugins_url('dist/vendor/js/jquery.countdown.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));
        wp_register_script('dipi_jquery_event_move', plugins_url('dist/vendor/js/jquery.event.move.2.0.0.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));
        wp_register_script('dipi_jquery_throttle_debounce', plugins_url('dist/vendor/js/jquery.throttle.debounce.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));
        wp_register_script('dipi_lottie_player', plugins_url('dist/vendor/js/lottie-player.min.js', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_script('dipi_lottie_interactivity', plugins_url('dist/vendor/js/lottie-interactivity.min.js', constant('DIPI_PLUGIN_FILE')), ['dipi_lottie_player'], constant('DIPI_VERSION'));
        wp_register_script('dipi_lottie', plugins_url('dist/vendor/js/lottie.min.js', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_script('dipi_masonry', plugins_url('dist/vendor/js/masonry.pkgd.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'magnific-popup'], constant('DIPI_VERSION'));
        wp_register_script('dipi_numeric', plugins_url('dist/vendor/js/numeric.min.js', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_script('dipi_pannellum', plugins_url('dist/vendor/js/pannellum.2.5.6.min.js', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_script('dipi_popper', plugins_url('dist/vendor/js/popper.min.js', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_script('dipi_resize_sensor', plugins_url('dist/vendor/js/ResizeSensor.js', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_script('dipi_swiper', plugins_url('dist/vendor/js/swiper.5.3.8.min.js', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_script('dipi_tippy', plugins_url('dist/vendor/js/tippy.min.js', constant('DIPI_PLUGIN_FILE')), ['dipi_popper'], constant('DIPI_VERSION'));
        wp_register_script('dipi_typed', plugins_url('dist/vendor/js/typed.2.0.11.min.js', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_script('dipi_vanilla_tilt', plugins_url('dist/vendor/js/vanilla-tilt.min.js', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'), true);
        wp_register_script('dipi_videojs', plugins_url('dist/vendor/js/video.7.0.3.min.js', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_script('dipi_vivus', plugins_url('dist/vendor/js/vivus.min.js', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_script('dipi_sticky', plugins_url('dist/vendor/js/hc-sticky.js', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_script('dipi_parallax', plugins_url('dist/vendor/js/parallax.min.js', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));

        
        /**
         * Divi Pixel Scripts
         */ 
        wp_register_script('dipi_hamburgers_js', plugins_url('dist/public/js/hamburger.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));
        
        /**
         * Divi Pixel Module Scripts
         */ 
        wp_register_script('dipi_balloon_public', plugins_url('dist/public/js/Balloon.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_tippy'], constant('DIPI_VERSION'));
        wp_register_script('dipi_before_after_slider_public', plugins_url('dist/public/js/BeforeAfterSlider.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_jquery_event_move'], constant('DIPI_VERSION'));
        wp_register_script('dipi_blog_slider_public', plugins_url('dist/public/js/BlogSlider.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_swiper'], constant('DIPI_VERSION'));
        wp_register_script('dipi_carousel_public', plugins_url('dist/public/js/Carousel.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_swiper', 'magnific-popup'], constant('DIPI_VERSION'));
        wp_register_script('dipi_content_toggle_public', plugins_url('dist/public/js/ContentToggle.min.js', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_script('dipi_countdown_public', plugins_url('dist/public/js/Countdown.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_jquery_countdown'], constant('DIPI_VERSION'));
        wp_register_script('dipi_counter_public', plugins_url('dist/public/js/Counter.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'easypiechart', 'dipi_resize_sensor', 'circliful'], constant('DIPI_VERSION'));
        wp_register_script('dipi_reveal_public', plugins_url('dist/public/js/Reveal.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));
        wp_register_script('dipi_reading_progress_bar_public', plugins_url('dist/public/js/ReadingProgressBar.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));
        wp_register_script('dipi_dual_heading_public', plugins_url('dist/public/js/DualHeading.min.js', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_script('dipi_fancy_text_public', plugins_url('dist/public/js/FancyText.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_morphext'], constant('DIPI_VERSION'));
        wp_register_script('dipi_faq_public', plugins_url('dist/public/js/FAQ.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));
        wp_register_script('dipi_flip_box_public', plugins_url('dist/public/js/FlipBox.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_resize_sensor'], constant('DIPI_VERSION'));
        wp_register_script('dipi_hover_box_public', plugins_url('dist/public/js/HoverBox.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_resize_sensor'], constant('DIPI_VERSION'));
        wp_register_script('dipi_image_accordion_public', plugins_url('dist/public/js/ImageAccordion.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_carousel_public'], constant('DIPI_VERSION'));
        wp_register_script('dipi_image_gallery_public', plugins_url('dist/public/js/ImageGallery.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_swiper', 'magnific-popup'], constant('DIPI_VERSION'));
        wp_register_script('dipi_image_hotspot_public', plugins_url('dist/public/js/ImageHotspot.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_masonry', 'dipi_imagesloaded', 'dipi_jquery_throttle_debounce' ], constant('DIPI_VERSION'));
        wp_register_script('dipi_image_magnifier_public', plugins_url('dist/public/js/ImageMagnifier.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_jquery_magnify'], constant('DIPI_VERSION'));
        wp_register_script('dipi_image_rotator_public', plugins_url('dist/public/js/ImageRotator.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_jquery_throttle_debounce', 'dipi_imagesloaded'], constant('DIPI_VERSION'));
        wp_register_script('dipi_image_showcase_public', plugins_url('dist/public/js/ImageShowcase.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_swiper', 'dipi_numeric'], constant('DIPI_VERSION'));
        wp_register_script('dipi_image_showcase_public', plugins_url('dist/public/js/ImageShowcase.min.js', constant('DIPI_PLUGIN_FILE')), ['dipi_swiper', 'dipi_numeric'], constant('DIPI_VERSION'));
        wp_register_script('dipi_instagram_grid_public', plugins_url('dist/public/js/InstagramGrid.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_masonry_gallery', 'magnific-popup'], constant('DIPI_VERSION'));
        wp_register_script('dipi_instagram_slider_public', plugins_url('dist/public/js/InstagramSlider.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'magnific-popup'], constant('DIPI_VERSION'));
        wp_register_script('dipi_lottie_icon_public', plugins_url('dist/public/js/LottieIcon.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_lottie', 'dipi_lottie_interactivity'], constant('DIPI_VERSION'));
        wp_register_script('dipi_masonry_gallery_public', plugins_url('dist/public/js/MasonryGallery.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_masonry', 'dipi_imagesloaded', 'dipi_jquery_throttle_debounce' ], constant('DIPI_VERSION'));
        wp_register_script('dipi_filterable_gallery_public', plugins_url('dist/public/js/FilterableGallery.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_masonry', 'dipi_imagesloaded', 'dipi_jquery_throttle_debounce' ], constant('DIPI_VERSION'));
        wp_register_script('dipi_panorama_public', plugins_url('dist/public/js/Panorama.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_pannellum'], constant('DIPI_VERSION'));
        wp_register_script('dipi_filterable_grid_public', plugins_url('dist/public/js/FilterableGrid.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_masonry', 'dipi_imagesloaded', 'dipi_jquery_throttle_debounce' ], constant('DIPI_VERSION'));
        wp_register_script('dipi_price_list_public', plugins_url('dist/public/js/PriceList.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'magnific-popup'], constant('DIPI_VERSION'));
        wp_register_script('dipi_scroll_image_public', plugins_url('dist/public/js/ScrollImage.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));
        wp_register_script('dipi_swiper_module_public', plugins_url('dist/public/js/SwiperModule.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_swiper'], constant('DIPI_VERSION'));
        wp_register_script('dipi_testimonial_public', plugins_url('dist/public/js/Testimonial.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_swiper', 'magnific-popup'], constant('DIPI_VERSION'));
        wp_register_script('dipi_timeline_public', plugins_url('dist/public/js/Timeline.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'magnific-popup'], constant('DIPI_VERSION'));
        wp_register_script('dipi_typing_text_public', plugins_url('dist/public/js/TypingText.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_typed'], constant('DIPI_VERSION'));
        wp_register_script('dipi_svg_animator_public', plugins_url('dist/public/js/SVGAnimator.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_vivus'], constant('DIPI_VERSION'));
        wp_register_script('dipi_advanced_tabs', plugins_url('dist/public/js/AdvancedTabs.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_sticky'], constant('DIPI_VERSION'));
        wp_register_script('dipi_pricing_table', plugins_url('dist/public/js/PricingTable.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));
        wp_register_script('dipi_info_circle_public', plugins_url('dist/public/js/InfoCircle.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));
        wp_register_script('dipi_text_highlighter_public', plugins_url('dist/public/js/TextHighlighter.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_vivus'], constant('DIPI_VERSION'));
        wp_register_script('dipi_expanding_cta_public', plugins_url('dist/public/js/ExpandingCTA.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_jquery_throttle_debounce'], constant('DIPI_VERSION'));
        wp_register_script('dipi_horizontal_timeline_public', plugins_url('dist/public/js/HorizontalTimeline.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_swiper', 'magnific-popup'], constant('DIPI_VERSION'));
        wp_register_script('dipi_tile_scroll_public', plugins_url('dist/public/js/TileScroll.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));
        wp_register_script('dipi_selector_hook_public', plugins_url('dist/public/js/SelectorHook.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));
        wp_register_script('dipi_gravity_forms_styler_public', plugins_url('dist/public/js/GravityFormsStyler.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));
        wp_register_script('dipi_hover_gallery', plugins_url('dist/public/js/HoverGallery.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));
        wp_register_script('dipi_divider', plugins_url('dist/public/js/Divider.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));

        wp_register_script('dipi_parallax_images', plugins_url('dist/public/js/ParallaxImages.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));
        wp_register_script('dipi_toc', plugins_url('dist/public/js/TableOfContent.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));
        wp_register_script('dipi_content_slider_public', plugins_url('dist/public/js/ContentSlider.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'dipi_jquery_throttle_debounce'], constant('DIPI_VERSION'));
        wp_register_script('dipi_table_maker_public', plugins_url('dist/public/js/TableMaker.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery', 'magnific-popup'], constant('DIPI_VERSION'));
        
        /**
         * Uncompressed or modified vendor scripts
         */
        wp_register_script('dipi_morphext', plugins_url('dist/public/js/morphext.min.js', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_script('dipi_jquery_magnify', plugins_url('dist/public/js/jquery.magnify.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'));
        wp_register_script('dipi_videojs_pannellum_plugin', plugins_url('dist/public/js/videojs-pannellum-plugin.min.js', constant('DIPI_PLUGIN_FILE')), ['dipi_videojs'], constant('DIPI_VERSION'));    
       

        //Scripts which should always load on frontend
        wp_enqueue_script("dipi_public_js", plugins_url('dist/public/js/public.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'), false);
    }

    private function register_styles(){
        /**
         * 3rd Party Styles
         */
        wp_register_style('magnific-popup', plugins_url('dist/vendor/css/magnific-popup.css', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_style('dipi_pannellum', plugins_url('dist/vendor/css/pannellum.2.5.6.min.css', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_style('dipi_swiper', plugins_url('dist/vendor/css/swiper.5.3.8.min.css', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_style('dipi_videojs', plugins_url('dist/vendor/css/video-js.7.0.3.min.css', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_style('dipi_animate', plugins_url('dist/vendor/css/animate.min.css', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        if (file_exists(WP_PLUGIN_DIR  . '/gravityforms')) {
            $gf_base_url = "../gravityforms/assets/css/dist";
            wp_register_style('dipi_gf_theme', plugins_url("{$gf_base_url}/theme.min.css", constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
            wp_register_style('dipi_gf_basic', plugins_url("{$gf_base_url}/basic.min.css", constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
            
            //register_theme_styles of GF plugin
            if ( 'orbital' == get_option( 'rg_gforms_default_theme' ) ) {
                wp_register_style( 'dipi_gf_theme_reset', plugins_url("{$gf_base_url}/gravity-forms-theme-reset.min.css", constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
                wp_register_style('dipi_gf_theme_foundation', plugins_url("{$gf_base_url}/gravity-forms-theme-foundation.min.css", constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
                wp_register_style(
                    'dipi_gf_theme_framework',
                    plugins_url("{$gf_base_url}/gravity-forms-theme-framework.min.css", constant('DIPI_PLUGIN_FILE')),
                    array(
                        'dipi_gf_theme_reset',
                        'dipi_gf_theme_foundation',
                    ),
                    constant('DIPI_VERSION')
                );
                wp_register_style( 'dipi_gf_orbital_theme', plugins_url("{$gf_base_url}/assets/css/dist/gravity-forms-orbital-theme.min.css", constant('DIPI_PLUGIN_FILE')),
                    array( 'dipi_gf_theme_framework' ), constant('DIPI_PLUGIN_FILE') );
            }
        }
        /**
         * Divi Pixel Styles
         */
        wp_register_style('dipi_general', plugins_url('dist/public/css/general.min.css', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_style('dipi_magnify', plugins_url('dist/public/css/magnify.min.css', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_style('dipi_preloader', plugins_url('dist/public/css/preloader.min.css', constant('DIPI_PLUGIN_FILE')), [], constant('DIPI_VERSION'));
        wp_register_style('dipi_swiper_module_public', plugins_url('dist/public/css/SwiperModule.min.css', constant('DIPI_PLUGIN_FILE')), ['dipi_swiper'], constant('DIPI_VERSION'));

    }

    public function custom_loginlogo_url($url)
    {
        return get_option('dipi_login_page_link');
    }

    public function get_specific_default_font($font_family){
        if(dipi_is_theme('Divi') && function_exists('et_pb_get_specific_default_font') ){
            return et_pb_get_specific_default_font($font_family);
        } else {
            return $font_family;
        }
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style("dipi_font", plugins_url('dist/admin/css/dipi-font.min.css', constant('DIPI_PLUGIN_FILE')), [], "1.0.0", 'all');
        wp_enqueue_style('dipi_general');
        $enqueue_fonts = [];
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('mobile_menu_font') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('mobile_submenu_font') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('mobile_button_font') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('lp_form_field_font') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('lp_form_btn_font') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('btt_font') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('top_bar_font') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('dropdown_font_select') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('menu_btn_font_select') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('footer_menu_font_select') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('footer_bar_font_select') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('blog_archives_title_font_select') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('blog_archives_meta_font_select') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('blog_archives_excerpt_font_select') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('blog_archives_btn_font_select') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('archive_sidebar_font_select') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('blog_author_name_font_select') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('blog_author_desc_font_select') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('blog_nav_btn_select') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('blog_related_section_font_select') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('blog_related_font_select') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('blog_comments_font_select') ) );
        $enqueue_fonts[] = sanitize_text_field( $this->get_specific_default_font( DIPI_Customizer::get_option('blog_comments_btn_font_select') ) );
        
        $done_enqueue_fonts = [];
        if ( count( $enqueue_fonts ) && function_exists( 'et_builder_enqueue_font' ) ) {
            foreach ( $enqueue_fonts as $single_font ) {
                if(! in_array($single_font, $done_enqueue_fonts) ) {
                    $done_enqueue_fonts[] = $single_font;
                    et_builder_enqueue_font( $single_font );
                }
            }
        }

        if (DIPI_Settings::get_option('back_to_top')) {
            
            wp_enqueue_script("dipi_scroll_top_js", plugins_url('dist/public/js/scroll-top.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'), true);
            wp_localize_script('dipi_scroll_top_js', 'dipi_scroll_top_vars', [
                'use_btt_custom_link' => DIPI_Settings::get_option('btt_custom_link'),
                'btt_link' => DIPI_Settings::get_option('btt_link'),
                'btt_custom_text' => DIPI_Customizer::get_option('btt_custom_text'),
                'btt_button_style' => DIPI_Settings::get_option('btt_button_style'),
                'btt_text_placement' => DIPI_Customizer::get_option('btt_text_placement'),
                'btt_hover_anim' => DIPI_Customizer::get_option('btt_hover_anim'),
            ]);
        }
    }

    public function wp_footer() {
        if (DIPI_Settings::get_option('menu_styles') && DIPI_Settings::get_option('enable_menu_hover_styles')) {
            include plugin_dir_path(__FILE__) . 'partials/menu-hover-styles-partial.php';
        }
    }

    public function wp_head()
    {
        include plugin_dir_path(__FILE__) . 'partials/logo-partial.php';
        if (DIPI_Settings::get_option('footer_customization')) {
            include plugin_dir_path(__FILE__) . 'partials/footer-styles-partial.php';
        }

        if (DIPI_Settings::get_option('use_dipi_social_icons')) {
            include plugin_dir_path(__FILE__) . 'partials/social-icons-partial-styles.php';
            include plugin_dir_path(__FILE__) . 'partials/social-icons-footer-styles-partial.php';
        }

        if (DIPI_Settings::get_option('enable_custom_comments')) {
            include plugin_dir_path(__FILE__) . 'partials/comments-section-partial.php';
        }

        if (DIPI_Settings::get_option('related_articles')) {
            include plugin_dir_path(__FILE__) . 'partials/related-articles-styles-partial.php';
        }

        if (DIPI_Settings::get_option('fixed_footer')) {
            include plugin_dir_path(__FILE__) . 'partials/fixed-footer-partial.php';
        }

        if (DIPI_Settings::get_option('reveal_footer') && !is_admin() && !dipi_is_vb()) {
            include plugin_dir_path(__FILE__) . 'partials/reveal-footer-partial.php';
        }

        if (DIPI_Settings::get_option('browser_scrollbar')) {
            include plugin_dir_path(__FILE__) . 'partials/scrollbar-partial.php';
        }

        if (DIPI_Settings::get_option('menu_button')) {
            include plugin_dir_path(__FILE__) . 'partials/cta-button-styles-partial.php';
        }

        include plugin_dir_path(__FILE__) . 'partials/primary-menu-position-styles-partial.php';
        
        if (DIPI_Settings::get_option('menu_styles')) {
            include plugin_dir_path(__FILE__) . 'partials/top-header-bar-partial.php';
        }

        if (DIPI_Settings::get_option('menu_styles')) {
            include plugin_dir_path(__FILE__) . 'partials/main-header-bar-partial.php';
            include plugin_dir_path(__FILE__) . 'partials/primary-menu-styles-partial.php';
        }

        if (DIPI_Settings::get_option('author_box')) {
            include plugin_dir_path(__FILE__) . 'partials/author-box-styles-partial.php';
        }

        if (DIPI_Settings::get_option('blog_meta_icons')) {
            include plugin_dir_path(__FILE__) . 'partials/post-meta-icon-partial.php';
        }

        if (DIPI_Settings::get_option('add_read_more_archive')) {
            include plugin_dir_path(__FILE__) . 'partials/read-more-button-partial.php';
            include plugin_dir_path(__FILE__) . 'partials/read-more-button-styles-partial.php';
        }

        if (DIPI_Settings::get_option('hide_excerpt_text')) {
            include plugin_dir_path(__FILE__) . 'partials/hide-excerpt-text-partial.php';
        }

        if (DIPI_Settings::get_option('custom_archive_page')) {
            include plugin_dir_path(__FILE__) . 'partials/custom-archive-styles-partial.php';
        }

        if (DIPI_Settings::get_option('blog_nav')) {
            include plugin_dir_path(__FILE__) . 'partials/blog-navigation-styles-partial.php';
        }

        if (DIPI_Settings::get_option('custom_dropdown')) {
            include plugin_dir_path(__FILE__) . 'partials/dropdown-menu-styles-partial.php';
        }

        if (DIPI_Settings::get_option('error_page') && is_404()) {
            include plugin_dir_path(__FILE__) . 'partials/custom-404-page-styles.php';
        }


        /******************************
         * Mobile Menu Customizations *
         ******************************/

        include plugin_dir_path(__FILE__) . 'partials/mobile-menu/mobile-options-partial.php';

        if (DIPI_Settings::get_option('custom_breakpoints')) {
            include plugin_dir_path(__FILE__) . 'partials/mobile-menu/mobile-menu-breakpoint-partial.php';
        }

        if (DIPI_Settings::get_option('fixed_mobile_header')) {
            include plugin_dir_path(__FILE__) . 'partials/mobile-menu/mobile-menu-fixed-header-partial.php';
        }

        if (DIPI_Settings::get_option('hamburger_animation')) {
            include plugin_dir_path(__FILE__) . 'partials/mobile-menu/mobile-menu-hamburger-partial.php';
        }

        if (DIPI_Settings::get_option('collapse_submenu')) {
            include plugin_dir_path(__FILE__) . 'partials/mobile-menu/mobile-menu-collapse-submenu-partial.php';
        }

        if (DIPI_Settings::get_option('mobile_menu_style')) {

            include plugin_dir_path(__FILE__) . 'partials/mobile-menu/mobile-menu-styles-partial.php';
            include plugin_dir_path(__FILE__) . 'partials/mobile-menu/mobile-submenu-styles-partial.php';

            if (DIPI_Settings::get_option('mobile_menu_fullscreen')) {
                include plugin_dir_path(__FILE__) . 'partials/mobile-menu/mobile-menu-fullscreen-partial.php';
            }
        }

        /******************************
         * Sidebar Customization *
         ******************************/
        if (DIPI_Settings::get_option('sidebar_customization') && !DIPI_Settings::get_option('remove_sidebar')) {
            include plugin_dir_path(__FILE__) . 'partials/sidebar-style-partial.php';
        }
    }

    public function back_to_top()
    {
        if (DIPI_Settings::get_option('back_to_top')) {
            include_once plugin_dir_path(__FILE__) . 'partials/scroll-top-partial.php';
        }
    }

    public function header_top_content()
    {
        $this->add_secondary_social_icons();
    }

    public function after_main_content()
    {
        $this->add_preloader();
        $this->particles_background();
        $this->add_footer_social_icons();
        $this->add_footer_layout();
        $this->add_header_layout_inject();
        $this->add_single_layout_inject();
        $this->add_archive_layout_inject();
        $this->add_category_layout_inject();
        $this->add_search_layout_inject();
        $this->add_footer_layout_inject();
    }

    public function add_header_layout_inject()
    {
        include plugin_dir_path(__FILE__) . 'partials/layout-inject-header-partial.php';
    }

    public function add_single_layout_inject()
    {
        include plugin_dir_path(__FILE__) . 'partials/layout-inject-single-partial.php';
    }

    public function add_archive_layout_inject()
    {
        include plugin_dir_path(__FILE__) . 'partials/layout-inject-archives-partial.php';
    }

    public function add_category_layout_inject()
    {
        include plugin_dir_path(__FILE__) . 'partials/layout-inject-category-partial.php';
    }

    public function add_search_layout_inject()
    {
        include plugin_dir_path(__FILE__) . 'partials/layout-inject-search-partial.php';
    }

    public function template_include($template)
    {

        if (is_404() && DIPI_Settings::get_option('error_page')) {
            return plugin_dir_path(__FILE__) . 'partials/custom-404-page-partial.php';
        }

        return $template;
    }

    public function add_footer_layout_inject()
    {
        include plugin_dir_path(__FILE__) . 'partials/layout-inject-footer-partial.php';
    }

    public function add_author_box()
    {
        if (!is_singular('post') || !DIPI_Settings::get_option('author_box')) {
            return;
        }

        include plugin_dir_path(__FILE__) . 'partials/author-box-partial.php';
    }

    public function after_single_content()
    {
        $this->add_blog_nav();
        $this->add_author_box();
        $this->add_related_articles();
    }

    public function after_single_content_builder_template()
    {
        // phpcs:disable
        $page = isset($_GET['et_tb']);

        if (is_single() && $page != 1) {
            $this->add_blog_nav();
            $this->add_author_box();
            $this->add_related_articles();
        }
        // phpcs:enable
    }

    public function add_footer_layout()
    {
        if (!DIPI_Settings::get_option('footer_layout')) {
            return;
        }

        include plugin_dir_path(__FILE__) . 'partials/footer-layout-injection-partial.php';
    }

    public function add_blog_nav()
    {
        if (!is_singular('post') || !DIPI_Settings::get_option('blog_nav')) {
            return;
        }

        include plugin_dir_path(__FILE__) . 'partials/blog-navigation-partial.php';
    }

    public function add_preloader()
    {
        if (dipi_is_vb()) {
            return;
        }

        if (!DIPI_Settings::get_option('custom_preloader')) {
            return;
        }

        if (DIPI_Settings::get_option('custom_preloader_homepage') && !is_front_page()) {
            return;
        }

        include plugin_dir_path(__FILE__) . 'partials/preloader-partial.php';
        wp_enqueue_style("dipi_loaders_css", plugins_url('dist/vendor/css/loaders.min.css', constant('DIPI_PLUGIN_FILE')), [], "1.0.0", 'all');
        wp_enqueue_style("dipi_preloader_css", plugins_url('dist/public/css/preloader.min.css', constant('DIPI_PLUGIN_FILE')), [], "1.0.0", 'all');
        wp_enqueue_script("dipi_preloader_js", plugins_url('dist/public/js/preloader.min.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'), false);
        wp_localize_script('dipi_preloader_js', 'dipi_preloader_vars', [
            'preloader_reveal_duration' => DIPI_Customizer::get_option('preloader_reveal_duration'),
            'preloader_reveal_delay' => DIPI_Customizer::get_option('preloader_reveal_delay'),
        ]);
    }
    public function particles_background() {
        if (dipi_is_vb()) {
            return;
        }

        if (!DIPI_Settings::get_option('use_particles')) {
            return;
        }

        wp_enqueue_script("dipi_particles_js", plugins_url('dist/vendor/js/particles.js', constant('DIPI_PLUGIN_FILE')), ['jquery'], constant('DIPI_VERSION'), false);
        wp_localize_script('dipi_particles_js', 'dipi_particles_vars', [
            'particles_count' => DIPI_Customizer::get_option('particles_count'),
            'particles_color' => DIPI_Customizer::get_option('particles_color'),
            'particle_shape' => DIPI_Customizer::get_option('particle_shape'),
            'particles_size' => DIPI_Customizer::get_option('particles_size'),
            'particles_speed' => DIPI_Customizer::get_option('particles_speed'),
            'particles_width' => DIPI_Customizer::get_option('particles_width'),
            'particle_move_direction' => DIPI_Customizer::get_option('particle_move_direction'),
            'link_color' => DIPI_Customizer::get_option('link_color'),
            'link_distance' => DIPI_Customizer::get_option('link_distance'),
            'particle_interactivity' => DIPI_Customizer::get_option('particle_interactivity'),

            'particles_count_2' => DIPI_Customizer::get_option('particles_count_2'),
            'particles_color_2' => DIPI_Customizer::get_option('particles_color_2'),
            'particle_shape_2' => DIPI_Customizer::get_option('particle_shape_2'),
            'particles_size_2' => DIPI_Customizer::get_option('particles_size_2'),
            'particles_speed_2' => DIPI_Customizer::get_option('particles_speed_2'),
            'particles_width_2' => DIPI_Customizer::get_option('particles_width_2'),
            'particle_move_direction_2' => DIPI_Customizer::get_option('particle_move_direction_2'),
            'link_color_2' => DIPI_Customizer::get_option('link_color_2'),
            'link_distance_2' => DIPI_Customizer::get_option('link_distance_2'),
            'particle_interactivity_2' => DIPI_Customizer::get_option('particle_interactivity_2')
        ]);
    }
    public function et_html_main_header($content)
    {
        ob_start();
        $this->add_preloader();
        $this->particles_background();
        $preloader = ob_get_clean();
        return $preloader . $content;
    }

    public function et_theme_builder_template_before_page_wrappers()
    {
        $this->add_preloader();
        $this->particles_background();
        $this->add_header_layout_inject();
        $this->add_single_layout_inject();
        $this->add_archive_layout_inject();
        $this->add_category_layout_inject();
        $this->add_search_layout_inject();
        $this->add_footer_layout_inject();
    }

    public function hide_admin_bar()
    {
        if (!DIPI_Settings::get_option('hide_admin_bar') || dipi_is_vb()) {
            return;
        }

        include plugin_dir_path(__FILE__) . 'partials/hide-admin-bar-partial.php';
    }

    public function new_nav_menu_items()
    {
        if (!DIPI_Settings::get_option('menu_button')) {
            return;
        }

        include plugin_dir_path(__FILE__) . 'partials/cta-button-partial.php';
    }

    public function body_class($classes)
    {
        $classes = $this->header_underline($classes);
        $classes = $this->hide_footer_bottom_bar($classes);
        $classes = $this->remove_sidebar($classes);
        $classes = $this->remove_sidebar_line($classes);
        $classes = $this->zoom_logo($classes);
        $classes = $this->shrink_header($classes);
        $classes = $this->add_menu_styles_class($classes);
        $classes = $this->enabled_fixed_footer($classes);
        $classes = $this->enabled_reveal_footer($classes);
        $classes = $this->custom_archive_page($classes);
        $classes = $this->hide_search_icon_mobile($classes);
        $classes = $this->mobile_menu_fullscreen($classes);
        $classes = $this->collapse_submenu_mobile($classes);
        $classes = $this->menu_custom_breakpoint($classes);
        $classes = $this->mobile_cta_button($classes);
        $classes = $this->anim_preload($classes);
        return $classes;
    }

    public function anim_preload($classes)
    {
        if (!dipi_is_vb()) {
            $classes[] = 'dipi-anim-preload';
        }
        return $classes;
    }

    public function hide_footer_bottom_bar($classes)
    {
        if (DIPI_Settings::get_option('hide_bottom_bar')) {
            $classes[] = 'dipi-hide-bottom-bar';
        }

        return $classes;
    }

    public function mobile_cta_button($classes)
    {
        if (DIPI_Settings::get_option('menu_button') ) {
            $classes[] = 'dipi-cta-button';
            if(!DIPI_Settings::get_option('mobile_cta_btn')){
                $classes[] = 'dipi-mobile-cta-button';
            }
        }

        return $classes;
    }

    public function menu_custom_breakpoint($classes)
    {
        if (DIPI_Settings::get_option('custom_breakpoints')) {
            $classes[] = 'dipi-menu-custom-breakpoint';
        }

        return $classes;
    }

    public function mobile_menu_fullscreen($classes)
    {
        if (DIPI_Settings::get_option('mobile_menu_fullscreen')) {
            $classes[] = 'dipi-mobile-menu-fullscreen';
        }

        return $classes;
    }

    public function collapse_submenu_mobile($classes)
    {
        if (DIPI_Settings::get_option('collapse_submenu')) {
            $classes[] = 'dipi-collapse-submenu-mobile';
        }

        return $classes;
    }

    public function hide_search_icon_mobile($classes)
    {
        if (DIPI_Settings::get_option('search_icon_mobile')) {
            $classes[] = 'dipi-hide-search-icon';
        } else {
            $classes[] = 'dipi-fix-search-icon';
        }
        return $classes;
    }

    public function custom_archive_page($classes)
    {
        // if (is_home() || is_archive()) {
        //     $classes[] = 'dipi-custom-archive-page dipi-archive-' . DIPI_Settings::get_option('custom_archive_styles');
        // } else if (DIPI_Settings::get_option('custom_archive_page')) {
            $classes[] = 'dipi-custom-archive-page dipi-archive-' . DIPI_Settings::get_option('custom_archive_styles');
        // }
        return $classes;
    }

    public function add_menu_styles_class($classes)
    {
        if (DIPI_Settings::get_option('menu_styles') && DIPI_Settings::get_option('enable_menu_hover_styles')) {
            $classes[] = DIPI_Settings::get_option('menu_hover_styles');
        }
        return $classes;
    }

    public function enabled_fixed_footer($classes)
    {
        if (!dipi_is_vb() && DIPI_Settings::get_option('fixed_footer')) {
            $classes[] = 'dipi-fixed-footer';
        }
        return $classes;
    }

    public function enabled_reveal_footer($classes)
    {
        if(dipi_is_vb()){
            return $classes;
        }
        
        global $post;

        if (!isset($post) || !is_object($post) || !isset($post->ID)) {
            return $classes;
        }

        if (DIPI_Settings::get_option('footer_reveal_posts_type')) {
            if (is_singular('post')) {
                return $classes;
            }

        }

        if (DIPI_Settings::get_option('footer_reveal_pages_type')) {
            if (is_singular('page')) {
                return $classes;
            }

        }

        if (DIPI_Settings::get_option('footer_reveal_projects_type')) {
            if (is_singular('project')) {
                return $classes;
            }

        }

        if (DIPI_Settings::get_option('footer_reveal_testimonials_type')) {
            if (is_singular('dipi_testimonial')) {
                return $classes;
            }

        }

        $desktop = !DIPI_Settings::get_option('reveal_desktop');
        $tablet = !DIPI_Settings::get_option('reveal_tablet');
        $phone = !DIPI_Settings::get_option('reveal_phone');

        $post_desktop = get_post_meta($post->ID, 'dipi_revealing_footer_enable_desktop', true);
        $post_tablet = get_post_meta($post->ID, 'dipi_revealing_footer_enable_tablet', true);
        $post_phone = get_post_meta($post->ID, 'dipi_revealing_footer_enable_phone', true);

        if (!empty($post_desktop) && $post_desktop !== "default") {
            $desktop = $post_desktop !== "no";
        }

        if (!empty($post_tablet) && $post_tablet !== "default") {
            $tablet = $post_tablet !== "no";
        }

        if (!empty($post_phone) && $post_phone !== "default") {
            $phone = $post_phone !== "no";
        }

        if (DIPI_Settings::get_option('reveal_footer')) {

            if ($desktop) {
                $classes[] = 'dipi_revealing_footer_desktop';
            }

            if ($tablet) {
                $classes[] = 'dipi_revealing_footer_tablet';
            }

            if ($phone) {
                $classes[] = 'dipi_revealing_footer_phone';
            }

        }

        return $classes;
    }

    public function header_underline($classes)
    {
        if (DIPI_Settings::get_option('header_underline')) {
            $classes[] = 'dipi-header-underline';
        }
        return $classes;
    }

    public function remove_sidebar($classes)
    {
        if (DIPI_Settings::get_option('remove_sidebar')) {
            $classes[] = 'dipi-remove-sidebar';
        }
        return $classes;
    }

    public function remove_sidebar_line($classes)
    {
        if (DIPI_Settings::get_option('remove_sidebar_line') && !DIPI_Settings::get_option('remove_sidebar')) {
            $classes[] = 'dipi-remove-sidebar-line';
        }
        return $classes;
    }

    public function zoom_logo($classes)
    {
        if (DIPI_Settings::get_option('zoom_logo')) {
            $classes[] = 'dipi-zoom-logo';
        }
        return $classes;
    }

    public function shrink_header($classes)
    {
        if (DIPI_Settings::get_option('shrink_header')) {
            $classes[] = 'dipi-shrink-header';
        }
        return $classes;
    }

    public function add_primary_social_icons()
    {
        if (!DIPI_Settings::get_option('use_dipi_social_icons')) {
            return;
        } 

        $use_social_icons_menu = DIPI_Settings::get_option('social_icons_menu');
        $use_individual_location = DIPI_Settings::get_option('social_icons_individual_location');

        if ('primary' == $use_social_icons_menu || $use_individual_location) {
            include plugin_dir_path(__FILE__) . 'partials/social-icons-primary-menu-partial.php';
        }
    }

    public function add_secondary_social_icons()
    {
        
        if (!DIPI_Settings::get_option('use_dipi_social_icons')) {
            return;
        }

        $use_social_icons_menu = DIPI_Settings::get_option('social_icons_menu');
        $use_individual_location = DIPI_Settings::get_option('social_icons_individual_location');

        if ('secondary' == $use_social_icons_menu || $use_individual_location) {
            include plugin_dir_path(__FILE__) . 'partials/social-icons-secondary-menu-partial.php';
        }
    }

    public function add_footer_social_icons()
    {
        if (!DIPI_Settings::get_option('use_dipi_social_icons')) {
            return;
        }

        $use_social_icons_footer = DIPI_Settings::get_option('social_icons_footer');
        $use_individual_location = DIPI_Settings::get_option('social_icons_individual_location');

        if ($use_social_icons_footer || $use_individual_location) {
            include plugin_dir_path(__FILE__) . 'partials/social-icons-footer-menu-partial.php';
        }
    }

    public function add_mobile_social_icons()
    {
        if (!DIPI_Settings::get_option('use_dipi_social_icons')) {
            return;
        }

        $use_social_icons_mobile_menu = DIPI_Settings::get_option('social_icons_mobile_menu');
        $use_individual_location = DIPI_Settings::get_option('social_icons_individual_location');

        if ($use_social_icons_mobile_menu || $use_individual_location) {
            include plugin_dir_path(__FILE__) . 'partials/social-icons-mobile-menu-partial.php';
        }
    }

    public function add_custom_login_page()
    {
        if (!DIPI_Settings::get_option('login_page')) {
            return;
        }

        include plugin_dir_path(__FILE__) . 'partials/custom-login-page-partial.php';
    }
    public function admin_bar_menu ($wp_admin_bar) {
        if (!DIPI_Settings::get_option('use_coming_soon')) {
            return;
        }
        
        $wp_admin_bar->add_menu(
            array(
                'id'     => 'dipi_admin_bar',
                'href'   => admin_url() . 'admin.php?page=divi_pixel_options',
                'parent' => 'top-secondary',
                'title'  => 'Maintenance Mode Active',
                'meta'   => array( 'class' => 'divi-comingsoon-mode' ),
            )
        );
    }
    public function coming_soon_page () {
        if (!DIPI_Settings::get_option('use_coming_soon')) {
            return;
        }

        include plugin_dir_path(__FILE__) . 'partials/coming-soon.php';
    }

    public function add_custom_admin_login_page()
    {
        if (!DIPI_Settings::get_option('login_page')) {
            return;
        }

        include plugin_dir_path(__FILE__) . 'partials/custom-admin-login-page.php';
    }

    public function add_related_articles()
    {
        if (!is_singular('post') || !DIPI_Settings::get_option('related_articles')) {
            return;
        }

        include plugin_dir_path(__FILE__) . 'partials/related-articles-partial.php';
    }

}
