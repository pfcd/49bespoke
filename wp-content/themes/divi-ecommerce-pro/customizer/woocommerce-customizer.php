<?php
/*
 * Contains code copied from and/or based on Divi, WooCommerce and WooCommerce Product Archive Customizer
 * See the license.txt file in the root directory for more information and licenses
 *
 */

/**
 * DSDEP_THEME_WC class
 */
if (!class_exists('DSDEP_THEME_WC')) {

    /**
     * The Product Archive Customiser class
     */
    class DSDEP_THEME_WC {

        /**
         * The version number.
         *
         * @var     string
         * @access  public
         */
        public $version;

        /**
         * The constructor!
         */
        public function __construct() {
            $this->version = AGS_THEME_VERSION; // Child Theme  Version

            add_action('init', array($this, 'dsdep_woocommerce_setup'));
            add_action('wp', array($this, 'dsdep_woocommerce_fire_customisations'));
            add_action('wp_enqueue_scripts', array($this, 'divi_ecommerce_pro_custom_styles'));
        }

        /**
         * Product Archive Customiser setup
         *
         * @return void
         */
        public function dsdep_woocommerce_setup() {
            add_action('customize_register', array($this, 'dsdep_woocommerce_customize_register'));
        }

        /**
         * Add settings to the Customizer
         *
         * @param array $wp_customize the Customiser settings object.
         * @return void
         */
        public function dsdep_woocommerce_customize_register($wp_customize) {
            $wp_customize->add_section('dsdep_woocommerce', array(
                'title'    => esc_html__('Woocommerce Settings', 'divi-ecommerce-pro'),
                'priority' => 7,
                'panel'    => 'dsdep_child_theme_customizer',
            ));

            // --------------------------------------------------------------------------------------- //
            //                                     Badges
            // --------------------------------------------------------------------------------------- //

            $wp_customize->add_setting('dsdep_woo_flash_sales', array(
                'default'           => true,
                'transport'         => 'refresh',
                'sanitize_callback' => array($this, 'dsdep_woocommerce_sanitize_checkbox'),
            ));

            $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'dsdep_woo_flash_sales', array(
                'label'       => esc_html__('Enable Flash Sale Badges', 'divi-ecommerce-pro'),
                'section'     => 'dsdep_woocommerce',
                'settings'    => 'dsdep_woo_flash_sales',
                'type'        => 'checkbox',
                'description' => esc_html__('Replace "Sale" badges with % discount.', 'divi-ecommerce-pro'),
            )));

            $wp_customize->add_setting('dsdep_woocommerce_badge_new', array(
                'default'           => true,
                'transport'         => 'refresh',
                'sanitize_callback' => array($this, 'dsdep_woocommerce_sanitize_checkbox'),
            ));

            $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'dsdep_woocommerce_badge_new', array(
                'label'       => esc_html__('Display "New" badge', 'divi-ecommerce-pro'),
                'section'     => 'dsdep_woocommerce',
                'settings'    => 'dsdep_woocommerce_badge_new',
                'type'        => 'checkbox',
                'description' => esc_html__('Adds a new badge to product entry for any product added in the last X days.', 'divi-ecommerce-pro'),
            )));

            /**
             * Display - product overlay text
             */
            $wp_customize->add_setting('dsdep_woocommerce_badge_new_days', array(
                'default'           => 30,
                'transport'         => 'refresh',
                'sanitize_callback' => 'wp_filter_nohtml_kses',
            ));

            $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'dsdep_woocommerce_badge_new_days', array(
                'label'           => esc_html__('Number of days', 'divi-ecommerce-pro'),
                'section'         => 'dsdep_woocommerce',
                'settings'        => 'dsdep_woocommerce_badge_new_days',
                'type'            => 'number',
                'active_callback' => array($this, 'is_dsdep_woocommerce_badge_new_enabled'),
            )));

            // --------------------------------------------------------------------------------------- //
            //                                     Overlay
            // --------------------------------------------------------------------------------------- //

            /**
             * Display - product overlay
             */
            $wp_customize->add_setting('dsdep_woocommerce_product_overlay', array(
                'default'           => true,
                'transport'         => 'refresh',
                'sanitize_callback' => array($this, 'dsdep_woocommerce_sanitize_checkbox'),
            ));

            $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'dsdep_woocommerce_product_overlay', array(
                'label'       => esc_html__('Display custom product overlay', 'divi-ecommerce-pro'),
                'section'     => 'dsdep_woocommerce',
                'settings'    => 'dsdep_woocommerce_product_overlay',
                'type'        => 'checkbox',
                'description' => esc_html__('Enables a product overlay with the custom text. The product overlay is displayed on the shop page, archive product pages and product category pages upon hovering the product image.', 'divi-ecommerce-pro'),

            )));

            /**
             * Display - product overlay text
             */
            $wp_customize->add_setting('dsdep_woocommerce_product_overlay_text', array(
                'default'           => 'Shop now',
                'transport'         => 'refresh',
                'sanitize_callback' => 'wp_filter_nohtml_kses',
            ));

            $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'dsdep_woocommerce_product_overlay_text', array(
                'label'           => esc_html__('Product overlay text', 'divi-ecommerce-pro'),
                'section'         => 'dsdep_woocommerce',
                'settings'        => 'dsdep_woocommerce_product_overlay_text',
                'type'            => 'text ',
                'active_callback' => array($this, 'is_dsdep_product_overlay_enabled'),
                'description'     => esc_html__('Changes the text displayed on the product overlay. "Display custom product overlay" needs to be enabled in order this feature to work.', 'divi-ecommerce-pro'),

            )));

            // --------------------------------------------------------------------------------------- //
            //                                     Images
            // --------------------------------------------------------------------------------------- //

            // Empty Cart
            $wp_customize->add_setting('dsdep_empty_cart_image', array(
                'default'           => get_bloginfo('stylesheet_directory') . '/images/cart.png',
                'sanitize_callback' => 'esc_url_raw' //cleans URL from all invalid characters
            ));
            $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'dsdep_empty_cart_image', array(
                'label'       => esc_html__('Empty cart image', 'divi-ecommerce-pro'),
                'section'     => 'dsdep_woocommerce',
                'settings'    => 'dsdep_empty_cart_image',
                'description' => esc_html__('Choose empty cart image', 'divi-ecommerce-pro'),
            )));

            // Empty wishlist
            $wp_customize->add_setting('dsdep_empty_wishlist_image', array(
                'default'           => get_bloginfo('stylesheet_directory') . '/images/wishlist.png',
                'sanitize_callback' => 'esc_url_raw' //cleans URL from all invalid characters
            ));
            $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'dsdep_empty_wishlist_image', array(
                'label'       => esc_html__('Empty wishlist image', 'divi-ecommerce-pro'),
                'section'     => 'dsdep_woocommerce',
                'settings'    => 'dsdep_empty_wishlist_image',
                'description' => esc_html__('Choose empty wishlist image', 'divi-ecommerce-pro'),
            )));
        }

        /**
         * Checkbox sanitization callback.
         *
         * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
         * as a boolean value, either TRUE or FALSE.
         *
         * @param bool $checked Whether the checkbox is checked.
         * @return bool Whether the checkbox is checked.
         */
        public function dsdep_woocommerce_sanitize_checkbox($checked) {
            return ((isset($checked) && true == $checked) ? true : false);
        }

        /**
         * Sanitizes choices (selects / radios)
         * Checks that the input matches one of the available choices
         *
         * @param array $input the available choices.
         * @param array $setting the setting object.
         */
        public function dsdep_woocommerce_sanitize_choices($input, $setting) {
            // Ensure input is a slug.
            $input = sanitize_key($input);

            // Get list of choices from the control associated with the setting.
            $choices = $setting->manager->get_control($setting->id)->choices;

            // If the input is a valid key, return it; otherwise, return the default.
            return (array_key_exists($input, $choices) ? $input : $setting->default);
        }

        /**
         * New overlay callback
         *
         * @param array $control the Customizer controls.
         * @return bool
         */
        public function is_dsdep_product_overlay_enabled($control) {
            return $control->manager->get_setting('dsdep_woocommerce_product_overlay')->value() === true ? true : false;
        }

        /**
         * News badge callback
         *
         * @param array $control the Customizer controls.
         * @return bool
         */
        public function is_dsdep_woocommerce_badge_new_enabled($control) {
            return $control->manager->get_setting('dsdep_woocommerce_badge_new')->value() === true ? true : false;
        }

        /**
         * Action our customisations
         *
         * @return void
         */
        function dsdep_woocommerce_fire_customisations() {

            // Flash Sales
            if (get_theme_mod('dsdep_woo_flash_sales', true) == true) {
                add_filter('woocommerce_sale_flash', 'ds_replace_sale_text');
            }

            // New badge
            if (get_theme_mod('dsdep_woocommerce_badge_new', true) == true) {
                add_action('woocommerce_before_shop_loop_item_title', 'divi_ecommerce_pro_new_badge_shop_page', 1);
            }
        }

        /* "Shop now" woo product hover effect */
        public function divi_ecommerce_pro_custom_styles() {
            wp_enqueue_style('woocommerce-style', get_stylesheet_directory_uri() . '/customizer/woocommerce.css');
            $custom_css = '';
            if (get_theme_mod('dsdep_woocommerce_product_overlay', true) === true) {
                $text = esc_html(get_theme_mod('dsdep_woocommerce_product_overlay_text', 'Shop Now'));
                $custom_css = ".et_shop_image .et_overlay:before {
                        position: absolute;
                        top: 55%;
                        left: 50%;
                        margin: -16px 0 0 -16px;
                        content: \"\\e050\";
                        -webkit-transition: all .4s;
                        -moz-transition: all .4s;
                        transition: all .4s;
                    }

                    .et_shop_image:hover .et_overlay {
                        z-index: 3;
                        opacity: 1;
                    }

                    .et_shop_image .et_overlay {
                        display: block;
                        z-index: -1;
                        -webkit-box-sizing: border-box;
                        -moz-box-sizing: border-box;
                        box-sizing: border-box;
                        opacity: 0;
                        -webkit-transition: all .3s;
                        -moz-transition: all .3s;
                        transition: all .3s;
                        -webkit-transform: translate3d(0, 0, 0);
                        -webkit-backface-visibility: hidden;
                        -moz-backface-visibility: hidden;
                        backface-visibility: hidden;
                        pointer-events: none;
                        position: absolute;
                        width: 100%;
                        height: 100%;
                        top: 0;
                        left: 0;
                    }

                    .et-db #et-boc .et_shop_image .et_overlay,
                    .et_shop_image .et_overlay {
                        background: transparent;
                        border: none;
                    }

                    .et-db #et-boc .et_shop_image .et_overlay:before,
                    .et_shop_image .et_overlay:before {
                        font-family: 'Montserrat', Helvetica, Arial, Lucida, sans-serif !important;
                        text-transform: uppercase;
                        background: #fff;
                        padding: 10px 25px;
                        color: #111 !important;
                        border-radius: 30px;
                        display: block;
                        text-align: center;
                        margin: -20px 0 0 -60px !important;
                        top: 50% !important;
                        font-size: 14px;
                        font-weight: 600;
                        line-height: 1.3;
                        border: none !important;
                        -webkit-box-shadow: 0 0 30px 3px rgba(0, 0, 0, 0.15);
                        -moz-box-shadow: 0 0 30px 3px rgba(0, 0, 0, 0.15);
                        box-shadow: 0 0 30px 3px rgba(0, 0, 0, 0.15);
                    }

                    .woocommerce.et-db #et-boc .et-l .et_shop_image .et_overlay:before,
                    .et-db #et-boc .et_shop_image .et_overlay:before,
                    .et_shop_image .et_overlay:before {
                        content: '$text' !important;
                    }";
            }
            wp_add_inline_style('woocommerce-style', $custom_css);
        }
    }

    $DSDEP_THEME_wc = new DSDEP_THEME_WC();
}
