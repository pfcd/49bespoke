<?php

namespace DiviPixel;

class DIPI_Customizer
{
    private static $instance = null;
    private static $settings_prefix = 'dipi_customizer_option_';

    private $accent_color;
    private $customizer_api;
    private $panels;
    private $sections;
    private $fields;

    /**
     * Settings instance
     *
     * @since 1.6.0
     * @return DIPI_Customizer
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function settings_prefix(){
        return self::$settings_prefix;
    }
    
    public static function get_option($option)
    {
        // Load fields and check if $option exists
        $fields = self::instance()->get_fields();
        if (!isset($fields[$option])) {
            dipi_info("DIPI_Customizer::get_option() - Unknown Setting: " . $option);
            return false;
        }

        // Load value of $option
        $prefix = self::settings_prefix();
        $default =  isset($fields[$option]['default']) ? $fields[$option]['default'] : '0|0|0|0';

        switch ($fields[$option]['type']) {
            case 'padding':
            case 'margin':
            case 'border_radii':
                $options = [];
                $defaults = explode("|", $default);
                switch (count($defaults)) {
                    case 1:
                        $options[] = get_option("{$prefix}{$option}_1", $defaults[0]);
                        $options[] = get_option("{$prefix}{$option}_2", $defaults[0]);
                        $options[] = get_option("{$prefix}{$option}_3", $defaults[0]);
                        $options[] = get_option("{$prefix}{$option}_4", $defaults[0]);
                        return $options;
                    case 2:
                        $options[] = get_option("{$prefix}{$option}_1", $defaults[0]);
                        $options[] = get_option("{$prefix}{$option}_2", $defaults[1]);
                        $options[] = get_option("{$prefix}{$option}_3", $defaults[0]);
                        $options[] = get_option("{$prefix}{$option}_4", $defaults[1]);
                        return $options;
                    case 4:
                        $options[] = get_option("{$prefix}{$option}_1", $defaults[0]);
                        $options[] = get_option("{$prefix}{$option}_2", $defaults[1]);
                        $options[] = get_option("{$prefix}{$option}_3", $defaults[2]);
                        $options[] = get_option("{$prefix}{$option}_4", $defaults[3]);
                        return $options;
                }
                break;
            case 'checkbox': 
                $value = get_option("{$prefix}{$option}");
                // In previous versions of Divi Pixel we migt have stored values like yes or 1 in the database. Now we only store 'on' and 'off' but
                // to make sure that old checkbox values still work as before, this check is necessary. 
                if ($value === 'on' || $value === 'yes' || $value === true || $value === 'true' || $value === 1 || $value === '1') {
                    return true;
                } else if($value === 'off' || $value === 'no') {
                    return false;
                } else if($default !== null) {
                    return 'on' === $default;
                } else {
                    return false;
                }
            default:
                return get_option("{$prefix}{$option}", $default);
        }
    }


    //Demo on how to use border_radii, padding and margin settings in partial file:
    //<style>
    //.et_pb_button{
    // <?php 
    //     DIPI_Customizer::print_border_radii_styles("my_border_radii"); 
    //     DIPI_Customizer::print_padding_styles("my_padding");
    //     DIPI_Customizer::print_margin_styles("my_margin"); 
    // ? >
    // }
    //</style>   
    public static function print_border_radii_styles($field_id)
    {
        self::print_style("{$field_id}_1", "border-top-left-radius");
        self::print_style("{$field_id}_2", "border-top-right-radius");
        self::print_style("{$field_id}_3", "border-bottom-left-radius");
        self::print_style("{$field_id}_4", "border-bottom-right-radius");
    }

    public static function print_padding_styles($field_id)
    {
        self::print_style("{$field_id}_1", "padding-top");
        self::print_style("{$field_id}_2", "padding-right");
        self::print_style("{$field_id}_3", "padding-bottom");
        self::print_style("{$field_id}_4", "padding-left");
    }

    public static function print_margin_styles($field_id)
    {
        self::print_style("{$field_id}_1", "margin-top");
        self::print_style("{$field_id}_2", "margin-right");
        self::print_style("{$field_id}_3", "margin-bottom");
        self::print_style("{$field_id}_4", "margin-left");
    }

    private static function print_style($option_id, $css_property)
    {
        $value = get_option($option_id);
        if (isset($value) && '' !== $value) {
            echo sprintf('%s: %s !important;', esc_attr($css_property), esc_attr($value));
        }
    }

    public static function print_font_style_option($option)
    {
        $optionValue = self::get_option($option);
        $option_values = explode("|", $optionValue);

        $retVal = "";

        if (isset($option_values[0]) && $option_values[0] === 'on') {
            $retVal .= 'font-style: italic !important;';
        }

        if (isset($option_values[1]) && $option_values[1] === 'on') {
            $retVal .= 'text-transform: uppercase !important;';
        }

        if (isset($option_values[2]) && $option_values[2] === 'on') {
            $retVal .= 'font-variant: small-caps !important;';
        }

        if (isset($option_values[3]) && $option_values[3] === 'on') {
            $retVal .= 'text-decoration: underline !important;';
        }

        if (isset($option_values[4]) && $option_values[4] === 'on') {
            $retVal .= 'text-decoration: line-through !important;';
        }

        return $retVal;
    }











    public function get_panels(){
        if(is_null($this->panels)) {
            $this->panels = $this->create_panels();
        }
        return $this->panels;
    }

    public function get_sections(){
        if(is_null($this->sections)) {
            $this->sections = $this->create_sections();
        }
        return $this->sections;
    }

    public function get_fields(){
        if(is_null($this->fields)) {
            $this->fields = $this->create_fields();
        }
        return $this->fields;
    }

    private function create_panels()
    {
        return [
            'general' => [
                'label' => esc_html__("General", 'dipi-divi-pixel'),
                'description' => esc_html__("Settings for the mobile menu", 'dipi-divi-pixel'),
                'priority' => -10,
                'icon' => 'dp-settings',
            ],
            'header' => [
                'label' => esc_html__("Header", 'dipi-divi-pixel'),
                // 'description' => esc_html__("Settings for the header", 'dipi-divi-pixel'),
                'priority' => -9,
                'icon' => 'dp-header',
            ],
            'footer' => [
                'label' => esc_html__("Footer", 'dipi-divi-pixel'),
                // 'description' => esc_html__("Settings for the header", 'dipi-divi-pixel'),
                'priority' => -8,
                'icon' => 'dp-footer',
            ],
            'blog' => [
                'label' => esc_html__("Blog", 'dipi-divi-pixel'),
                // 'description' => esc_html__("Settings for the header", 'dipi-divi-pixel'),
                'priority' => -7,
                'icon' => 'dp-blog',
            ],
            'mobile' => [
                'label' => esc_html__("Mobile", 'dipi-divi-pixel'),
                // 'description' => esc_html__("Settings for the mobile menu", 'dipi-divi-pixel'),
                'priority' => -6,
                'icon' => 'dp-devices',
            ],
        ];
    }

    private function create_sections()
    {
        $format =  esc_html__('This is a description with a %1$s', 'dipi-divi-pixel');
        $link = sprintf('<a href="www.google.com">%1$s</a>', esc_html__("link", 'dipi-divi-pixel'));
        $description = sprintf($format, $link);
        return [
            'browser_scrollbar' => [
                'label' => esc_html__("Custom Browser Scroll Bar", 'dipi-divi-pixel'),
                'panel' => 'general',
                'priority' => 10,
            ],
            'login_page' => [
                'label' => esc_html__("Login Page", 'dipi-divi-pixel'),
                'panel' => 'general',
                'priority' => 20,
            ],
            'preloader' => [
                'label' => esc_html__("Preloader", 'dipi-divi-pixel'),
                'description' => $description,
                'description_hidden' => true,
                'panel' => 'general',
                'priority' => 30,
            ],
            'particles' => [
                'label' => esc_html__("Particles Background", 'dipi-divi-pixel'),
                'description' => $description,
                'description_hidden' => true,
                'panel' => 'general',
                'priority' => 40,
            ],
            'back_to_top' => [
                'label' => esc_html__("Back To Top Button", 'dipi-divi-pixel'),
                'panel' => 'general',
                'priority' => 50,
            ],
            'blog_archives' => [
                'label' => esc_html__("Categories & Archives", 'dipi-divi-pixel'),
                'panel' => 'blog',
                'priority' => 10,
            ],
            'blog_archives_btn' => [
                'label' => esc_html__("Categories & Archives Button", 'dipi-divi-pixel'),
                'panel' => 'blog',
                'priority' => 20,
            ],
            'blog_sidebar' => [
                'label' => esc_html__("Sidebar", 'dipi-divi-pixel'),
                'panel' => 'blog',
                'priority' => 30,
            ],
            'blog_navigation' => [
                'label' => esc_html__("Post Navigation", 'dipi-divi-pixel'),
                'panel' => 'blog',
                'priority' => 40,
            ],
            'blog_author_box' => [
                'label' => esc_html__("Author Box", 'dipi-divi-pixel'),
                'panel' => 'blog',
                'priority' => 50,
            ],
            'blog_related_posts' => [
                'label' => esc_html__("Related Articles", 'dipi-divi-pixel'),
                'panel' => 'blog',
                'priority' => 60,
            ],
            'blog_comments' => [
                'label' => esc_html__("Comments", 'dipi-divi-pixel'),
                'panel' => 'blog',
                'priority' => 70,
            ],
            'mobile_menu_bar' => [
                'label' => esc_html__("Mobile Menu Bar", 'dipi-divi-pixel'),
                'panel' => 'mobile',
                'priority' => 10,
            ],
            'mobile_menu_effects' => [
                'label' => esc_html__("Hamburger Icon", 'dipi-divi-pixel'),
                'panel' => 'mobile',
                'priority' => 20,
            ],
            'mobile_menu_links' => [
                'label' => esc_html__("Mobile Menu", 'dipi-divi-pixel'),
                'panel' => 'mobile',
                'priority' => 30,
            ],
            'mobile_menu_button' => [
                'label' => esc_html__("Mobile Menu CTA Button", 'dipi-divi-pixel'),
                'panel' => 'mobile',
                'priority' => 40,
            ],
            'mobile_social_icons' => [
                'label' => esc_html__("Mobile Menu Social Icons", 'dipi-divi-pixel'),
                'panel' => 'mobile',
                'priority' => 50,
            ],
            'top_bar' => [
                'label' => esc_html__("Top Bar", 'dipi-divi-pixel'),
                'panel' => 'header',
                'priority' => 10,
            ],
            'main_header' => [
                'label' => esc_html__("Main Header Bar", 'dipi-divi-pixel'),
                'panel' => 'header',
                'priority' => 20,
            ],
            'primary_nav' => [
                'label' => esc_html__("Primary Navigation", 'dipi-divi-pixel'),
                'panel' => 'header',
                'priority' => 30,
            ],
            'menu_dropdowns' => [
                'label' => esc_html__("Menu Dropdowns", 'dipi-divi-pixel'),
                'panel' => 'header',
                'priority' => 40,
            ],
            'menu_button' => [
                'label' => esc_html__("Menu CTA Button", 'dipi-divi-pixel'),
                'panel' => 'header',
                'priority' => 50,
            ],
            'menu_social_icons' => [
                'label' => esc_html__("Social Icons", 'dipi-divi-pixel'),
                'panel' => 'header',
                'priority' => 60,
            ],
            'footer_menu' => [
                'label' => esc_html__("Footer Menu", 'dipi-divi-pixel'),
                'panel' => 'footer',
                'priority' => 10,
            ],
            'footer_bottom_bar' => [
                'label' => esc_html__("Footer Bottom Bar", 'dipi-divi-pixel'),
                'panel' => 'footer',
                'priority' => 20,
            ],
            'footer_social_icons' => [
                'label' => esc_html__("Footer Social Icons", 'dipi-divi-pixel'),
                'panel' => 'footer',
                'priority' => 30,
            ],
        ];
    }

    private function create_fields()
    {
        $fields = [];
        $fields += $this->get_general_fields();
        $fields += $this->get_header_fields();
        $fields += $this->get_footer_fields();
        $fields += $this->get_blog_fields();
        $fields += $this->get_mobile_fields();
        return $fields;
    }

    private function get_mobile_fields()
    {
        return [
            'mobile_bar_disabled' => [
                'label' => esc_html__('Mobile Menu Bar', 'dipi-divi-pixel'),
                'description' => esc_html__('To customize Mobile Menu Bar appearance, please aneable this option in the Divi Pixel dashboard under Mobile > Mobile Menu > Custom Mobile Menu Style.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'mobile_menu_bar',
                'panel' => 'mobile',
                'cta' => true,
                'icon' => 'dp-mobile-bar',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'off',
                ]),
            ],
            'mobile_bar_heading' => [
                'label' => esc_html__('Mobile Menu Bar', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Mobile Menu Bar Color, Height and Logo Size', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'mobile_menu_bar',
                'panel' => 'mobile',
                'icon' => 'dp-mobile-bar',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_hide_bar' => [
                'label' => esc_html__('Hide Top Bar', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'mobile_menu_bar',
                'panel' => 'mobile',
                'default' => true,
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_full_width' => [
                'label' => esc_html__('Make Menu Bar Fullwidth', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'mobile_menu_bar',
                'panel' => 'mobile',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_header_height' => [
                'label' => esc_html__('Header Height', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_bar',
                'panel' => 'mobile',
                'default' => 80,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 400,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'fixed_mobile_header_scroll_offset' => [
                'label' => esc_html__('Fixed Mobile Header Scroll Offset', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_bar',
                'panel' => 'mobile',
                'default' => 0,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 5000,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'fixed_mobile_header' => 'on',
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_logo_size' => [
                'label' => esc_html__('Logo Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_bar',
                'panel' => 'mobile',
                'default' => 35,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_logo_width' => [
                'label' => esc_html__('Logo Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_bar',
                'panel' => 'mobile',
                'default' => '',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 400,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on'
                ]),
            ],
            'mobile_menu_bar_color' => [
                'label' => esc_html__('Menu Bar Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_bar',
                'panel' => 'mobile',
                'default' => '#ffffff',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_shadow_heading' => [
                'label' => esc_html__('Menu Bar Shadow', 'dipi-divi-pixel'),
                'description' => esc_html__('Enable/Disable and Customize Mobile Menu Bar Shadow', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'mobile_menu_bar',
                'panel' => 'mobile',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_shadow' => [
                'label' => esc_html__('Add Mobile Menu Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'mobile_menu_bar',
                'panel' => 'mobile',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_shadow_color' => [
                'label' => esc_html__('Menu Bar Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_bar',
                'panel' => 'mobile',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_shadow_offset' => [
                'label' => esc_html__('Menu Bar Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_bar',
                'panel' => 'mobile',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'mobile_menu_shadow_blur' => [
                'label' => esc_html__('Menu Bar Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_bar',
                'panel' => 'mobile',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
                'input_attrs' => [
                    'min' => 0,
                    'max' => 40,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'mobile_menu_effects_disabled' => [
                'label' => esc_html__('Hamburger Icon', 'dipi-divi-pixel'),
                'description' => esc_html__('To customize Hamburger Icon, please enable this option in the Divi Pixel dashboard under Mobile > Mobile Menu > Add Hamburegr Icon Animation', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'mobile_menu_effects',
                'panel' => 'mobile',
                'cta' => true,
                'icon' => 'dp-mobile-menu',
                'active_callback' => $this->show_if_option([
                    'hamburger_animation' => 'off',
                ]),
            ],
            'mobile_menu_hamburger_heading' => [
                'label' => esc_html__('Hamburger Icon', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Mobile Menu Hamburger Icon', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'mobile_menu_effects',
                'panel' => 'mobile',
                'icon' => 'dp-mobile-menu',
                'active_callback' => $this->show_if_option([
                    'hamburger_animation' => 'on',
                ]),
            ],
            'mobile_menu_hamburger_color' => [
                'label' => esc_html__('Hamburger Icon Color', 'dipi-divi-pixel'),
                'description' => esc_html__('Choose the color for the mobile hamburger icon', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_effects',
                'panel' => 'mobile',
                'default' => '#ffffff',
                'active_callback' => $this->show_if_option([
                    'hamburger_animation' => 'on',
                ]),
            ],
            'mobile_menu_hamburger_color_opened' => [
                'label' => esc_html__('Hamburger Icon Color Opened', 'dipi-divi-pixel'),
                'description' => esc_html__('Choose the color for the mobile hamburger icon when opened', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_effects',
                'panel' => 'mobile',
                'default' => '#ffffff',
                'active_callback' => $this->show_if_option([
                    'hamburger_animation' => 'on',
                ]),
            ],
            'mobile_menu_hamburger_boxed' => [
                'label' => esc_html__('Boxed Hamburger Icon', 'dipi-divi-pixel'),
                'description' => esc_html__('Whether or not the mobile hamburger icon shall be boxed', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'mobile_menu_effects',
                'panel' => 'mobile',
                'default' => 'on',
                'active_callback' => $this->show_if_option([
                    'hamburger_animation' => 'on',
                ]),
            ],
            'mobile_menu_hamburger_boxed_bg_color' => [
                'label' => esc_html__('Boxed Hamburger Icon Background', 'dipi-divi-pixel'),
                'description' => esc_html__('The background color of the boxed hamburger icon', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_effects',
                'panel' => 'mobile',
                'default' => '#2c3d49',
                'active_callback' => $this->show_if_option([
                    'hamburger_animation' => 'on',
                ]),
            ],
            'mobile_menu_hamburger_boxed_bg_color_opened' => [
                'label' => esc_html__('Boxed Hamburger Icon Background Opened', 'dipi-divi-pixel'),
                'description' => esc_html__('The background color of the boxed hamburger icon when opened', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_effects',
                'panel' => 'mobile',
                'default' => '#2c3d49',
                'active_callback' => $this->show_if_option([
                    'hamburger_animation' => 'on',
                ]),
            ],
            'mobile_menu_hamburger_boxed_border_radius' => [
                'label' => esc_html__('Boxed Hamburger Icon Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_effects',
                'panel' => 'mobile',
                'default' => '100',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'hamburger_animation' => 'on',
                ]),
            ],
            'mobile_menu_hamburger_boxed_box_padding' => [
                'label' => esc_html__('Boxed Hamburger Icon Box Padding', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_effects',
                'panel' => 'mobile',
                'default' => '10',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'hamburger_animation' => 'on',
                ]),
            ],









            'mobile_menu_effects_heading' => [
                'label' => esc_html__('Mobile Menu Effects', 'dipi-divi-pixel'),
                'description' => esc_html__('Add custom animations to your mobile menu.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                    'mobile_menu_fullscreen' => 'on',
                ]),
            ],
            'mobile_menu_dropdown_background' => [
                'label' => esc_html__('Mobile Menu Background', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => '#ffffff',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_background_animation' => [
                'label' => esc_html__('Overlay Background Animation', 'dipi-divi-pixel'),
                'description' => esc_html__('Select the animation for the mobile menu overlay background.', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 'circle',
                'options' => [
                    'grow' => esc_html__('Grow', 'dipi-divi-pixel'),
                    'slide_left' => esc_html__('Slide Left', 'dipi-divi-pixel'),
                    'slide_right' => esc_html__('Slide Right', 'dipi-divi-pixel'),
                    'slide_bottom' => esc_html__('Slide Bottom', 'dipi-divi-pixel'),
                    'slide_top' => esc_html__('Slide Top', 'dipi-divi-pixel'),
                    'fade' => esc_html__('Fade', 'dipi-divi-pixel'),
                    'circle' => esc_html__('Circle', 'dipi-divi-pixel')
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                    'mobile_menu_fullscreen' => 'on',
                ]),
            ],
            'mobile_menu_animation' => [
                'label' => esc_html__('Menu Links Animation', 'dipi-divi-pixel'),
                'description' => esc_html__('Select the animation for the mobile menu', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 'grow',
                'options' => [
                    'grow' => esc_html__('Grow', 'dipi-divi-pixel'),
                    'slide_left' => esc_html__('Slide Left', 'dipi-divi-pixel'),
                    'slide_right' => esc_html__('Slide Right', 'dipi-divi-pixel'),
                    'slide_bottom' => esc_html__('Slide Bottom', 'dipi-divi-pixel'),
                    'slide_top' => esc_html__('Slide Top', 'dipi-divi-pixel'),
                    'fade' => esc_html__('Fade', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                    'mobile_menu_fullscreen' => 'on',
                ]),
            ],















            'mobile_menu_text_heading' => [
                'label' => esc_html__('Mobile Menu Text Styles', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Mobile Menu Font', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'icon' => 'dp-font',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_text_align' => [
                'label' => esc_html__('Mobile Menu Text Alignment', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 'center',
                'options' => [
                    'left' => esc_html__('Left (Default)', 'dipi-divi-pixel'),
                    'center' => esc_html__('Center', 'dipi-divi-pixel'),
                    'right' => esc_html__('Right', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_font' => [
                'label' => esc_html__('Mobile Menu Font', 'dipi-divi-pixel'),
                'type' => 'font',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 'none',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_font_style' => [
                'label' => esc_html__('Font Style', 'dipi-divi-pixel'),
                'description' => esc_html__('Select a font style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_font_weight' => [
                'label' => esc_html__('Font Weight', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 500,
                'input_attrs' => [
                    'min' => 100,
                    'max' => 900,
                    'step' => 100
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_text_size' => [
                'label' => esc_html__('Mobile Menu Text Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => '16',
                'input_attrs' => [
                    'min' => 10,
                    'max' => 40,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_letter_spacing' => [
                'label' => esc_html__('Mobile Menu Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_text_color' => [
                'label' => esc_html__('Mobile Menu Text Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => '#2c3d49',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            



            'mobile_menu_item_heading' => [
                'label' => esc_html__('Mobile Menu Style', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Mobile Menu Style.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'icon' => 'dp-color',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            
            'mobile_menu_link_paddings' => [
                'label' => esc_html__('Mobile Menu Link Paddings', 'dipi-divi-pixel'),
                'type' => 'padding',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => '15|10|15|10',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_text_bottom_margin' => [
                'label' => esc_html__('Mobile Menu Link Bottom Margin', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => '10',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 30,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_border_size' => [
                'label' => esc_html__('Mobile Menu Item Border Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 0,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_border_radii' => [
                'label' => esc_html__('Mobile Menu Item Border Radius', 'dipi-divi-pixel'),
                'type' => 'border_radii',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => '50|50|50|50',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_border_color' => [
                'label' => esc_html__('Mobile Menu Item Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => $this->accent_color(),
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_item_background' => [
                'label' => esc_html__('Mobile Menu Item Background', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 'rgba(44,61,73,0.03)',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_padding' => [
                'label' => esc_html__('Mobile Menu Padding', 'dipi-divi-pixel'),
                'type' => 'padding',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => '80|0|20|0',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],






            'mobile_menu_item_shadow_heading' => [
                'label' => esc_html__('Menu Item Shadow', 'dipi-divi-pixel'),
                'description' => esc_html__('Add Shadow to Mobile Menu Items.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_item_shadow' => [
                'label' => esc_html__('Add Menu Item Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_item_shadow_color' => [
                'label' => esc_html__('Menu Item Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 'rgba(44,61,73,0.1)',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_item_shadow_offset' => [
                'label' => esc_html__('Mobile Menu Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => '4',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_menu_item_shadow_blur' => [
                'label' => esc_html__('Mobile Menu Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => '10',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],







            'mobile_submenu_text_heading' => [
                'label' => esc_html__('Mobile Submenu Text Styles', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Mobile Submenu Font', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'icon' => 'dp-font',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_text_align' => [
                'label' => esc_html__('Mobile Submenu Text Alignment', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 'center',
                'options' => [
                    'left' => esc_html__('Left (Default)', 'dipi-divi-pixel'),
                    'center' => esc_html__('Center', 'dipi-divi-pixel'),
                    'right' => esc_html__('Right', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_font' => [
                'label' => esc_html__('Mobile Submenu Font', 'dipi-divi-pixel'),
                'type' => 'font',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 'none',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_font_style' => [
                'label' => esc_html__('Font Style', 'dipi-divi-pixel'),
                'description' => esc_html__('Select a font style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_font_weight' => [
                'label' => esc_html__('Font Weight', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 500,
                'input_attrs' => [
                    'min' => 100,
                    'max' => 900,
                    'step' => 100
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_text_size' => [
                'label' => esc_html__('Mobile Submenu Text Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => '16',
                'input_attrs' => [
                    'min' => 10,
                    'max' => 40,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_letter_spacing' => [
                'label' => esc_html__('Mobile Submenu Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 1,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_text_color' => [
                'label' => esc_html__('Mobile Submenu Text Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 'rgba(44,61,73,0.6)',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],

            'mobile_submenu_heading' => [
                'label' => esc_html__('Mobile Submenu Style', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Mobile Submenu Style.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'icon' => 'dp-color',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            
            'mobile_submenu_link_paddings' => [
                'label' => esc_html__('Mobile Submenu Link Paddings', 'dipi-divi-pixel'),
                'type' => 'padding',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => '10|10|10|10',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 40,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_text_bottom_margin' => [
                'label' => esc_html__('Mobile Submenu Bottom Margin', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 5,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 30,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_border_size' => [
                'label' => esc_html__('Mobile Submenu Item Border Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 0,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_border_radii' => [
                'label' => esc_html__('Mobile Submenu Item Border Radius', 'dipi-divi-pixel'),
                'type' => 'border_radii',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => '50|50|50|50',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_border_color' => [
                'label' => esc_html__('Mobile Submenu Item Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => $this->accent_color(),
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_item_background' => [
                'label' => esc_html__('Mobile Submenu Item Background', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 'rgb(255,255,255)',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_padding' => [
                'label' => esc_html__('Mobile Submenu Margins', 'dipi-divi-pixel'),
                'type' => 'padding',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => '10|10|10|10',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],





            'mobile_submenu_item_shadow_heading' => [
                'label' => esc_html__('Submenu Item Shadow', 'dipi-divi-pixel'),
                'description' => esc_html__('Add Shadow to Mobile Submenu Item.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_item_shadow' => [
                'label' => esc_html__('Add Submenu Item Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_item_shadow_color' => [
                'label' => esc_html__('Submenu Item Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 'rgba(44,61,73,0.1)',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_item_shadow_offset' => [
                'label' => esc_html__('Mobile Submenu Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => '4',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_item_shadow_blur' => [
                'label' => esc_html__('Mobile Submenu Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => '10',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            











            



            'mobile_submenu_collapse_icon_heading' => [
                'label' => esc_html__('Mobile Submenu Collapsed Icon Style', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize collapsed submenu icon style.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_icon_on_collapse' => [
                'label' => esc_html__('Collapsed Submenu Icon', 'dipi-divi-pixel'),
                'type' => 'divi_icon',
                'default' => 'L',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            
            'mobile_submenu_icon_on_collapse_border_radius' => [
                'label' => esc_html__('Collapsed Submenu Icon Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 50,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => '%'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_icon_on_collapse_color' => [
                'label' => esc_html__('Collapsed Icon Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 'rgba(44,61,73,0.5)',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_icon_on_collapse_background_color' => [
                'label' => esc_html__('Collapsed Icon Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 'rgba(44,61,73,0.05)',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],

            'mobile_submenu_icon_on_expand' => [
                'label' => esc_html__('Expanded Submenu Icon', 'dipi-divi-pixel'),
                'type' => 'divi_icon',
                'default' => '!',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_icon_on_expand_border_radius' => [
                'label' => esc_html__('Expanded Sumbenu Icon Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 50,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => '%'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_icon_on_expand_color' => [
                'label' => esc_html__('Expanded Submenu Icon Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 'rgba(44,61,73,0.5)',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
            'mobile_submenu_icon_on_expand_background_color' => [
                'label' => esc_html__('Expanded Submenu Icon Box Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_links',
                'panel' => 'mobile',
                'default' => 'rgba(255,255,255,0)',
                'active_callback' => $this->show_if_option([
                    'mobile_menu_style' => 'on',
                ]),
            ],
             
            




            

            'mobile_cta_button_disabled' => [
                'label' => esc_html__('CTA Button Settings', 'dipi-divi-pixel'),
                'description' => esc_html__('To add and customize Mobile Menu Button please enable this option in Divi Pixel settings. This option can be found under Mobile/Mobile/Add CTA Button to Mobile Menu.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'mobile_menu_button',
                'panel' => 'mobile',
                'cta' => true,
                'icon' => 'dp-click',
                'active_callback' => $this->show_if_option([
                    'mobile_cta_btn' => 'on',
                ]),
            ],
            'mobile_cta_button_heading' => [
                'label' => esc_html__('CTA Button Settings', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Mobile Menu Button', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'mobile_menu_button',
                'panel' => 'mobile',
                'icon' => 'dp-click',
                'active_callback' => $this->show_if_option([
                    'mobile_cta_btn' => 'off',
                ]),
            ],
            //'mobile_menu_button' => [
            //    'label' => esc_html__('Display CTA Button on Mobiles', 'dipi-divi-pixel'),
            //    'description' => esc_html__('Enable this option if you want to display CTA button on Mobiles', 'dipi-divi-pixel'),
            //    'type' => 'checkbox',
            //    'section' => 'mobile_menu_button',
            //    'panel' => 'mobile',
            //    'active_callback' => $this->show_if_option([
            //        'mobile_cta_btn' => 'off',
            //    ]),
            //],
            'mobile_button_font' => [
                'label' => esc_html__('Select Button Font', 'dipi-divi-pixel'),
                'type' => 'font',
                'section' => 'mobile_menu_button',
                'panel' => 'mobile',
                'default' => 'none',
                'active_callback' => $this->show_if_option([
                    'mobile_cta_btn' => 'off',
                ]),
            ],
            'mobile_button_font_style' => [
                'label' => esc_html__('Button Font Style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'mobile_menu_button',
                'panel' => 'mobile',
                'active_callback' => $this->show_if_option([
                    'mobile_cta_btn' => 'off',
                ]),
            ],
            'mobile_menu_button_font_weight' => [
                'label' => esc_html__('Button Font Weight', 'dipi-divi-pixel'),
                'type' => 'font_weight',
                'section' => 'mobile_menu_button',
                'panel' => 'mobile',
                'default' => '500',
                'active_callback' => $this->show_if_option([
                    'mobile_cta_btn' => 'off',
                ]),
            ],
            'mobile_button_font_size' => [
                'label' => esc_html__('Button Font Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_button',
                'panel' => 'mobile',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 40,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_cta_btn' => 'off',
                ]),
            ],
            'mobile_button_letter_spacing' => [
                'label' => esc_html__('Button Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_button',
                'panel' => 'mobile',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_cta_btn' => 'off',
                ]),
            ],
            'mobile_menu_button_paddings' => [
                'label' => esc_html__('Button Paddings', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_button',
                'panel' => 'mobile',
                'default' => 12,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 30,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_cta_btn' => 'off',
                ]),
            ],
            'mobile_menu_btn_border_width' => [
                'label' => esc_html__('Border Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_button',
                'panel' => 'mobile',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_cta_btn' => 'off',
                ]),
            ],
            'mobile_menu_btn_border_color' => [
                'label' => esc_html__('Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_button',
                'panel' => 'mobile',
                'active_callback' => $this->show_if_option([
                    'mobile_cta_btn' => 'off',
                ]),
            ],
            'mobile_menu_button_radius' => [
                'label' => esc_html__('Button Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_button',
                'panel' => 'mobile',
                'default' => 100,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_cta_btn' => 'off',
                ]),
            ],
            'mobile_menu_button_background' => [
                'label' => esc_html__('Button Background', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_button',
                'default' => '#ff4200',
                'panel' => 'mobile',
                'active_callback' => $this->show_if_option([
                    'mobile_cta_btn' => 'off',
                ]),
            ],
            'mobile_menu_button_text' => [
                'label' => esc_html__('Button Text Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_button',
                'panel' => 'mobile',
                'default' => '#ffffff',
                'active_callback' => $this->show_if_option([
                    'mobile_cta_btn' => 'off',
                ]),
            ],
            'mobile_menu_btn_shadow_heading' => [
                'label' => esc_html__('Button Shadow', 'dipi-divi-pixel'),
                'description' => esc_html__('Add Shadow to Your Mobile Menu Button', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'mobile_menu_button',
                'panel' => 'mobile',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'mobile_cta_btn' => 'off',
                ]),
            ],
            'mobile_menu_btn_shadow' => [
                'label' => esc_html__('Add Button Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'mobile_menu_button',
                'panel' => 'mobile',
                'active_callback' => $this->show_if_option([
                    'mobile_cta_btn' => 'off',
                ]),
            ],
            'mobile_menu_btn_shadow_color' => [
                'label' => esc_html__('Button Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_menu_button',
                'panel' => 'mobile',
                'default' => 'rgba(0,39,56,0.30)',
                'active_callback' => $this->show_if_option([
                    'mobile_cta_btn' => 'off',
                ]),
            ],
            'mobile_menu_btn_shadow_offset' => [
                'label' => esc_html__('Button Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_button',
                'default' => '5',
                'panel' => 'mobile',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_cta_btn' => 'off',
                ]),
            ],
            'mobile_menu_btn_shadow_blur' => [
                'label' => esc_html__('Button Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_menu_button',
                'panel' => 'mobile',
                'default' => '20',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'mobile_cta_btn' => 'off',
                ]),
            ],
            'mobile_social_icon_disabled' => [
                'label' => esc_html__('Customize Social Icons in Mobile Menu', 'dipi-divi-pixel'),
                'description' => esc_html__('To add and customize Mobile Menu Social Icons appearance, please enable this option in the Divi Pixel dashboard under Social Media > Enable Divi Pixel Social Icons > Show in Mobile Menu.'),
                'type' => 'heading',
                'cta' => true,
                'section' => 'mobile_social_icons',
                'panel' => 'mobile',
                'icon' => 'dp-social',
                'active_callback' => $this->show_if_option([
                    'social_icons_mobile_menu' => 'off',
                    'social_icons_individual_location' => 'off',
                ], "AND"),
            ],
            'mobile_social_icon_heading' => [
                'label' => esc_html__('Mobile Menu Social Icon Style', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'mobile_social_icons',
                'panel' => 'mobile',
                'icon' => 'dp-color',
                'active_callback' => $this->show_if_option([
                    'social_icons_mobile_menu' => 'on',
                    'social_icons_individual_location' => 'on',
                ], "OR"),
            ],
            'mobile_social_icon_placement' => [
                'label' => esc_html__('Mobile Menu Icons Placement', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'mobile_social_icons',
                'panel' => 'mobile',
                'default' => 'bottom',
                'options' => [
                    'top' => esc_html__('Display Above Menu Items', 'dipi-divi-pixel'),
                    'bottom' => esc_html__('Display Below Menu Items', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'social_icons_mobile_menu' => 'on',
                    'social_icons_individual_location' => 'on',
                ], "OR"),
            ],
            'mobile_social_icon_alignment' => [
                'label' => esc_html__('Mobile Menu Icons Alignment', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'mobile_social_icons',
                'panel' => 'mobile',
                'default' => 'center',
                'options' => [
                    'left' => esc_html__('Left', 'dipi-divi-pixel'),
                    'center' => esc_html__('Center', 'dipi-divi-pixel'),
                    'right' => esc_html__('Right', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'social_icons_mobile_menu' => 'on',
                    'social_icons_individual_location' => 'on',
                ], "OR"),
            ],
            'mobile_social_icon_color' => [
                'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_social_icons',
                'panel' => 'mobile',
                'default' => '#2c3d49',
                'active_callback' => $this->show_if_option([
                    'social_icons_mobile_menu' => 'on',
                    'social_icons_individual_location' => 'on',
                ], "OR"),
            ],
            'mobile_social_icon_hover_color' => [
                'label' => esc_html__('Hover Icon Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_social_icons',
                'panel' => 'mobile',
                'default' => '#2c3d49',
                'active_callback' => $this->show_if_option([
                    'social_icons_mobile_menu' => 'on',
                    'social_icons_individual_location' => 'on',
                ], "OR"),
            ],
            'mobile_social_icon_size' => [
                'label' => esc_html__('Icon Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_social_icons',
                'panel' => 'mobile',
                'active_callback' => $this->show_if_option([
                    'social_icons_mobile_menu' => 'on',
                    'social_icons_individual_location' => 'on',
                ], "OR"),
                'default' => '16',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'mobile_social_icon_box_heading' => [
                'label' => esc_html__('Icon Box Style', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'mobile_social_icons',
                'panel' => 'mobile',
                'icon' => 'dp-social',
                'active_callback' => $this->show_if_option([
                    'social_icons_mobile_menu' => 'on',
                    'social_icons_individual_location' => 'on',
                ], "OR"),
            ],
            'mobile_social_icon_box_style' => [
                'label' => esc_html__('Enable Boxed Style', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'mobile_social_icons',
                'panel' => 'mobile',
                'default' => 'on',
                'active_callback' => $this->show_if_option([
                    'social_icons_mobile_menu' => 'on',
                    'social_icons_individual_location' => 'on',
                ], "OR"),
            ],
            'mobile_social_icon_box_padding' => [
                'label' => esc_html__('Box Padding', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_social_icons',
                'panel' => 'mobile',
                'active_callback' => $this->show_if_option([
                    'social_icons_mobile_menu' => 'on',
                    'social_icons_individual_location' => 'on',
                ], "OR"),
                'default' => '10',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'mobile_social_icon_box_radius' => [
                'label' => esc_html__('Box Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_social_icons',
                'panel' => 'mobile',
                'active_callback' => $this->show_if_option([
                    'social_icons_mobile_menu' => 'on',
                    'social_icons_individual_location' => 'on',
                ], "OR"),
                'default' => '100',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'mobile_social_icon_box_background' => [
                'label' => esc_html__('Icon Box Background', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_social_icons',
                'panel' => 'mobile',
                'default' => '#ffffff',
                'active_callback' => $this->show_if_option([
                    'social_icons_mobile_menu' => 'on',
                    'social_icons_individual_location' => 'on',
                ], "OR"),
            ],
            'mobile_social_icon_box_background_hover' => [
                'label' => esc_html__('Hover Icon Box Background', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_social_icons',
                'panel' => 'mobile',
                'default' => 'rgba(44,61,73,0.03)',
                'active_callback' => $this->show_if_option([
                    'social_icons_mobile_menu' => 'on',
                    'social_icons_individual_location' => 'on',
                ], "OR"),
            ],
            'mobile_social_icon_box_shadow_heading' => [
                'label' => esc_html__('Icon Box Shadow', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'mobile_social_icons',
                'panel' => 'mobile',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'social_icons_mobile_menu' => 'on',
                    'social_icons_individual_location' => 'on',
                ], "OR"),
            ],
            'mobile_social_icon_box_shadow' => [
                'label' => esc_html__('Display Icon Box Shadow', 'dipi-divi-pixel'),
                'description' => esc_html__('Enable this option to display Icon Box Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'mobile_social_icons',
                'panel' => 'mobile',
                'default' => 'false',
                'active_callback' => $this->show_if_option([
                    'social_icons_mobile_menu' => 'on',
                    'social_icons_individual_location' => 'on',
                ], "OR"),
            ],
            'mobile_social_icon_shadow_color' => [
                'label' => esc_html__('Icon Box Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'mobile_social_icons',
                'panel' => 'mobile',
                'default' => 'rgba(44,61,73,0.1)',
                'active_callback' => $this->show_if_option([
                    'social_icons_mobile_menu' => 'on',
                    'social_icons_individual_location' => 'on',
                ], "OR"),
            ],
            'mobile_social_icon_shadow_offset' => [
                'label' => esc_html__('Icon Box Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_social_icons',
                'panel' => 'mobile',
                'active_callback' => $this->show_if_option([
                    'social_icons_mobile_menu' => 'on',
                    'social_icons_individual_location' => 'on',
                ], "OR"),
                'default' => '2',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'mobile_social_icon_shadow_blur' => [
                'label' => esc_html__('Icon Box Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'mobile_social_icons',
                'panel' => 'mobile',
                'active_callback' => $this->show_if_option([
                    'social_icons_mobile_menu' => 'on',
                    'social_icons_individual_location' => 'on',
                ], "OR"),
                'default' => '5',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
        ];
    }

    private function get_general_fields()
    {
        return [
            'browser_scrollbar_disabled_notice' => [
                'label' => esc_html__('Custom Browser Scrollbar', 'dipi-divi-pixel'),
                'description' => esc_html__('To customize Browser Scrollbar appearance please enable this option in Divi Pixel Dashboard.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'browser_scrollbar',
                'panel' => 'general',
                'cta' => true,
                'icon' => 'dp-scrollbar',
                'active_callback' => $this->show_if_option([
                    'browser_scrollbar' => 'off',
                ]),
            ],
            'browser_scrollbar_heading' => [
                'label' => esc_html__('Browser Scrollbar Styles', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Browser Scrollbar appearance.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'browser_scrollbar',
                'panel' => 'general',
                'icon' => 'dp-scrollbar',
                'active_callback' => $this->show_if_option([
                    'browser_scrollbar' => 'on',
                ]),
            ],
            'browser_scrollbar_background' => [
                'label' => esc_html__('Browser Scrollbar Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'default' => '#ffffff',
                'section' => 'browser_scrollbar',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'browser_scrollbar' => 'on',
                ]),
            ],
            'browser_scrollbar_color' => [
                'label' => esc_html__('Browser Scrollbar Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'browser_scrollbar',
                'default' => '#f05c12',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'browser_scrollbar' => 'on',
                ]),
            ],
            'browser_scrollbar_width' => [
                'label' => esc_html__('Scrollbar Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'browser_scrollbar',
                'panel' => 'general',
                'default' => 15,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 30,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'browser_scrollbar' => 'on',
                ]),
            ],
            'browser_scrollbar_radius' => [
                'label' => esc_html__('Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'browser_scrollbar',
                'panel' => 'general',
                'default' => 10,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'browser_scrollbar' => 'on',
                ]),
            ],
            'browser_scrollbar_shadow_heading' => [
                'label' => esc_html__('Inside Shadow', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Scrollbar Inside Shadow', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'browser_scrollbar',
                'panel' => 'general',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'browser_scrollbar' => 'on',
                ]),
            ],
            'browser_scrollbar_shadow' => [
                'label' => esc_html__('Browser Scrollbar Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'browser_scrollbar',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'browser_scrollbar' => 'on',
                ]),
            ],
            'browser_scrollbar_shadow_color' => [
                'label' => esc_html__('Browser Scrollbar Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'browser_scrollbar',
                'panel' => 'general',
                'default' => 'grey',
                'active_callback' => $this->show_if_option([
                    'browser_scrollbar' => 'on',
                ]),
            ],
            'browser_scrollbar_shadow_offset' => [
                'label' => esc_html__('Browser Scrollbar Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'browser_scrollbar',
                'panel' => 'general',
                'default' => 0,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'browser_scrollbar' => 'on',
                ]),
            ],
            'browser_scrollbar_shadow_blur' => [
                'label' => esc_html__('Browser Scrollbar Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'browser_scrollbar',
                'panel' => 'general',
                'default' => 6,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'browser_scrollbar' => 'on',
                ]),
            ],

            'lp_disabled_info_bar' => [
                'label' => esc_html__('Custom Login Page', 'dipi-divi-pixel'),
                'description' => esc_html__('To enable Login Page customization go to DiviPixel Plugin Dashboard and enable Custom Login Page option available in General settings.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'login_page',
                'panel' => 'general',
                'cta' => true,
                'icon' => 'dp-login',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'off',
                ]),
            ],
            'lp_logo_heading' => [
                'label' => esc_html__('Page Style and Logo', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Login Page Background and Logo', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'login_page',
                'panel' => 'general',
                'icon' => 'dp-login-logo',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_logo' => [
                'label' => esc_html__('Login Page Logo', 'dipi-divi-pixel'),
                'description' => esc_html__('Select a file', 'dipi-divi-pixel'),
                'type' => 'upload',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_logo_width' => [
                'label' => esc_html__('Logo Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'default' => '84',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'input_attrs' => [
                    'min' => 0,
                    'max' => 600,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'lp_logo_height' => [
                'label' => esc_html__('Logo Height', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'default' => '84',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'input_attrs' => [
                    'min' => 0,
                    'max' => 600,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'lp_logo_margin' => [
                'label' => esc_html__('Logo Bottom Margin', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'default' => '25',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'input_attrs' => [
                    'min' => 0,
                    'max' => 120,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],

            'lp_background_color' => [
                'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'panel' => 'general',
                'default' => '#f2f2f5',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],

            'lp_background_image' => [
                'label' => esc_html__('Background Image', 'dipi-divi-pixel'),
                'description' => esc_html__('Select a file', 'dipi-divi-pixel'),
                'type' => 'upload',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],

            'lp_background_image_size' => [
                'label' => esc_html__('Background Image Size', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'login_page',
                'panel' => 'general',
                'default' => 'cover',
                'options' => [
                    'cover' => esc_html__('Cover ', 'dipi-divi-pixel'),
                    'fit' => esc_html__('Fit', 'dipi-divi-pixel'),
                    'actual' => esc_html__('Actual Size', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],

            'lp_background_image_repeat' => [
                'label' => esc_html__('Background Image Repeat', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'login_page',
                'panel' => 'general',
                'default' => 'repeat',
                'options' => [
                    'repeat' => esc_html__('Repeat', 'dipi-divi-pixel'),
                    'repeat-x' => esc_html__('Repeat X', 'dipi-divi-pixel'),
                    'repeat-y' => esc_html__('Repeat Y', 'dipi-divi-pixel'),
                    'no-repeat' => esc_html__('No Repeat', 'dipi-divi-pixel'),
                    'space' => esc_html__('Space', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],

            'lp_form_style_heading' => [
                'label' => esc_html__('Login Form Style', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Login Page Logo', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'login_page',
                'panel' => 'general',
                'icon' => 'dp-spacing',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_background_image' => [
                'label' => esc_html__('Form Background Image', 'dipi-divi-pixel'),
                'description' => esc_html__('Select a file', 'dipi-divi-pixel'),
                'type' => 'upload',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_background_color' => [
                'label' => esc_html__('Form Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_width' => [
                'label' => esc_html__('Form Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'default' => '450',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 1000,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_height' => [
                'label' => esc_html__('Form Height', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'input_attrs' => [
                    'min' => 0,
                    'max' => 1000,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'lp_form_padding' => [
                'label' => esc_html__('Form Padding', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'default' => '40',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'lp_form_border_width' => [
                'label' => esc_html__('Form Border Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'lp_form_radius' => [
                'label' => esc_html__('Form Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'default' => '10',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'lp_form_border_color' => [
                'label' => esc_html__('Form Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'panel' => 'general',
            ],
            'lp_form_box_shadow' => [
                'label' => esc_html__('Add Form Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'login_page',
                'panel' => 'general',
                'transport' => 'refresh',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_box_shadow_color' => [
                'label' => esc_html__('Form Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'panel' => 'general',
                'default' => '#d5d5e4',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_box_shadow_offset' => [
                'label' => esc_html__('Form Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'default' => '20',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_box_shadow_blur' => [
                'label' => esc_html__('Form Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'default' => '80',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],

            'lp_form_field_style_heading' => [
                'label' => esc_html__('Login Fields Style', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Login Page Input Fields', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'login_page',
                'panel' => 'general',
                'icon' => 'dp-controls',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            
            'lp_form_field_font' => [
                'label' => esc_html__('Select Field Font', 'dipi-divi-pixel'),
                // 'description' => esc_html__('Select a font', 'dipi-divi-pixel'),
                'type' => 'font',
                'section' => 'login_page',
                'panel' => 'general',
                'default' => 'none',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_field_font_size' => [
                'label' => esc_html__('Field Text Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'default' => '16',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 40,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'lp_form_field_letter_spacing' => [
                'label' => esc_html__('Field Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'default' => '1',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'lp_form_field_line_height' => [
                'label' => esc_html__('Field Text Line Height', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'default' => '1.5',
                'input_attrs' => [
                    'min' => 1,
                    'max' => 5,
                    'step' => 0.1
                ],
            ],

            'lp_form_field_margin' => [
                'label' => esc_html__('Field Top/Bottom Margin', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'default' => '15',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'lp_form_field_padding' => [
                'label' => esc_html__('Field Paddings', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'default' => '15',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 30,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'lp_form_password_eye_button_top' => [
                'label' => esc_html__('Password Eye Button Top', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'default' => '30',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'lp_form_field_border_width' => [
                'label' => esc_html__('Field Border Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 5,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'lp_form_field_radius' => [
                'label' => esc_html__('Field Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'default' => '100',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'lp_form_field_border_color' => [
                'label' => esc_html__('Field Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'panel' => 'general',
            ],
            'lp_form_field_border_color_hover' => [
                'label' => esc_html__('Active Field Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'panel' => 'general',
            ],
            'lp_form_field_background' => [
                'label' => esc_html__('Field Background', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'panel' => 'general',
                'default' => '#f2f2f2',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_field_background_active' => [
                'label' => esc_html__('Active Field Background', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_field_label_color' => [
                'label' => esc_html__('Field Label Text Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_field_text_color' => [
                'label' => esc_html__('Input Field Text Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_field_shadow_heading' => [
                'label' => esc_html__('Login Fields Box Shadow', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize login page field shadow.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'login_page',
                'panel' => 'general',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_field_inset_shadow' => [
                'label' => esc_html__('Remove Field Inset Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_field_shadow' => [
                'label' => esc_html__('Add Field Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_field_shadow_color' => [
                'label' => esc_html__('Field Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_field_shadow_offset' => [
                'label' => esc_html__('Field Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_field_shadow_blur' => [
                'label' => esc_html__('Field Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_field_shadow_color_active' => [
                'label' => esc_html__('Active Field Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_field_shadow_offset_active' => [
                'label' => esc_html__('Active Field Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_field_shadow_blur_active' => [
                'label' => esc_html__('Active Field Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],


            'lp_form_btn_heading' => [
                'label' => esc_html__('Login Button', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Login Button', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'login_page',
                'panel' => 'general',
                'icon' => 'dp-click',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_btn_font' => [
                'label' => esc_html__('Select Button Font', 'dipi-divi-pixel'),
                // 'description' => esc_html__('Select a font', 'dipi-divi-pixel'),
                'type' => 'font',
                'section' => 'login_page',
                'panel' => 'general',
                'default' => 'none',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_btn_font_size' => [
                'label' => esc_html__('Button Text Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'default' => '16',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 40,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],

            'lp_form_btn_letter_spacing' => [
                'label' => esc_html__('Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'default' => '1',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],

            'lp_form_btn_padding' => [
                'label' => esc_html__('Button Padding', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'default' => '22',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'input_attrs' => [
                    'min' => 0,
                    'max' => 30,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'lp_form_btn_font_weight' => [
                'label' => esc_html__('Select Button Font Weight', 'dipi-divi-pixel'),
                'type' => 'font_weight',
                'section' => 'login_page',
                'panel' => 'general',
                'default' => 500,
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],

            'lp_form_btn_txt_style' => [
                'label' => esc_html__('Button Font Style', 'dipi-divi-pixel'),
                'description' => esc_html__('Select a font style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_btn_txt_color' => [
                'label' => esc_html__('Button Text Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_btn_text_shadow' => [
                'label' => esc_html__('Remove Text Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_btn_text_hover' => [
                'label' => esc_html__('Hover Button Text Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_btn_background' => [
                'label' => esc_html__('Button Background', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_btn_background_hover' => [
                'label' => esc_html__('Hover Button Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_btn_border_width' => [
                'label' => esc_html__('Button Border Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'input_attrs' => [
                    'min' => 0,
                    'max' => 5,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'lp_form_btn_border_radius' => [
                'label' => esc_html__('Button Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'default' => '100',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'lp_form_btn_border_color' => [
                'label' => esc_html__('Button Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_btn_border_hover' => [
                'label' => esc_html__('Hover Button Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_btn_shadow_heading' => [
                'label' => esc_html__('Button Shadow', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Button Shadow', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'login_page',
                'panel' => 'general',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_btn_box_shadow' => [
                'label' => esc_html__('Add Button Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_btn_box_shadow_color' => [
                'label' => esc_html__('Button Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_btn_box_shadow_offset' => [
                'label' => esc_html__('Button Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_btn_box_shadow_blur' => [
                'label' => esc_html__('Button Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_btn_box_shadow_color_hover' => [
                'label' => esc_html__('Hover Button Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_btn_box_shadow_offset_hover' => [
                'label' => esc_html__('Hover Button Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_btn_box_shadow_blur_hover' => [
                'label' => esc_html__('Hover Button Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],

            'lp_form_link_heading' => [
                'label' => esc_html__('Links Style', 'dipi-divi-pixel'),
                'description' => esc_html__('Style Login Page Links', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'login_page',
                'panel' => 'general',
                'icon' => 'dp-link',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],

            'lp_form_link_font' => [
                'label' => esc_html__('Select Link Font', 'dipi-divi-pixel'),
                // 'description' => esc_html__('Select a font', 'dipi-divi-pixel'),
                'type' => 'font',
                'section' => 'login_page',
                'panel' => 'general',
                'default' => 'none',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],
            'lp_form_link_font_size' => [
                'label' => esc_html__('Link Text Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
                'input_attrs' => [
                    'min' => 0,
                    'max' => 40,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],

            'lp_form_link_txt_color' => [
                'label' => esc_html__('Link Text Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],

            'lp_form_link_txt_color_hover' => [
                'label' => esc_html__('Hover Link Text Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'login_page',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'login_page' => 'on',
                ]),
            ],





            'preloader_disabled_notice' => [
                'label' => esc_html__('Enable Preloader Customization', 'dipi-divi-pixel'),
                'description' => esc_html__('To customize Preloader styles please enable this option in DiviPixel Dashboard.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'preloader',
                'panel' => 'general',
                'cta' => true,
                'icon' => 'dp-preloader',
                'active_callback' => $this->show_if_option([
                    'custom_preloader' => 'off',
                ]),
            ],
            'preloader_heading' => [
                'label' => esc_html__('Preloader Customization', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'preloader',
                'panel' => 'general',
                'icon' => 'dp-preloader',
                'active_callback' => $this->show_if_option([
                    'custom_preloader' => 'on',
                ]),
            ],
            'preloader_color' => [
                'label' => esc_html__('Preloader Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'preloader',
                'panel' => 'general',
                'default' => '#ff4200',
                'active_callback' => $this->show_if_option([
                    'custom_preloader' => 'on',
                    'custom_preloader_image' => 'off',
                ]),
            ],
            'preloader_background_color' => [
                'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'preloader',
                'panel' => 'general',
                'default' => '#fff',
                'active_callback' => $this->show_if_option([
                    'custom_preloader' => 'on',
                ]),
            ],
            'preloader_reveal' => [
                'label' => esc_html__('Reveal Animation', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'preloader',
                'panel' => 'general',
                'default' => 'fade',
                'options' => [
                    'fade' => esc_html__('Fade', 'dipi-divi-pixel'),
                    'slide_up' => esc_html__('Slide Up', 'dipi-divi-pixel'),
                    'slide_down' => esc_html__('Slide Down', 'dipi-divi-pixel'),
                    'slide_left' => esc_html__('Slide Left', 'dipi-divi-pixel'),
                    'slide_right' => esc_html__('Slide Right', 'dipi-divi-pixel'),
                    'zoom' => esc_html__('Zoom', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'custom_preloader' => 'on',
                ]),
            ],
            'preloader_reveal_duration' => [
                'label' => esc_html__('Reveal Duration', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'preloader',
                'panel' => 'general',
                'type' => 'range',
                'section' => 'preloader',
                'panel' => 'general',
                'default' => 300,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 5000,
                    'step' => 100,
                    'suffix' => 'ms'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_preloader' => 'on',
                ]),
            ],
            'preloader_reveal_delay' => [
                'label' => esc_html__('Reveal Delay', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'preloader',
                'panel' => 'general',
                'default' => 300,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 5000,
                    'step' => 100,
                    'suffix' => 'ms'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_preloader' => 'on',
                ]),
            ],

            'particles_disabled_notice' => [
                'label' => esc_html__('Enable Particles Background Customization', 'dipi-divi-pixel'),
                'description' => esc_html__('To customize particles background styles please enable this option in DiviPixel Dashboard.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'particles',
                'panel' => 'general',
                'cta' => true,
                'icon' => 'dp-social',
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'off',
                ]),
            ],
            'particles_heading' => [
                'label' => esc_html__('Particles Background #1', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'particles',
                'panel' => 'general',
                'icon' => 'dp-social',
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on'
                ]),
            ],
            'particles_color' => [
                'label' => esc_html__('Particles Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'panel' => 'general',
                'section' => 'particles',
                'default' => 'rgba(0,0,0,.4)',
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on'
                ]),
            ],
            'link_color' => [
                'label' => esc_html__('Link Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'panel' => 'general',
                'section' => 'particles',
                'default' => 'rgba(0,0,0,.4)',
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on',
                ]),
            ],
            'particle_shape' => [
                'label' => esc_html__('Particles Shape', 'dipi-divi-pixel'),
                'type' => 'select',
                'panel' => 'general',
                'section' => 'particles',
                'default' => 'circle',
            
                'options' => [
                    'circle' => esc_html__('Circle', 'dipi-divi-pixel'),
                    'triangle' => esc_html__('Triangle', 'dipi-divi-pixel'),
                    'edge' => esc_html__('Square', 'dipi-divi-pixel'),
                    'polygon' => esc_html__('Polygon', 'dipi-divi-pixel'),
                    'star' => esc_html__('Star', 'dipi-divi-pixel')
                ],
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on'
                ]),
            ],
            'particle_move_direction' => [
                'label' => esc_html__('Move Direction', 'dipi-divi-pixel'),
                'type' => 'select',
                'panel' => 'general',
                'section' => 'particles',
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'dipi-divi-pixel'),
                    'top' => esc_html__('Top', 'dipi-divi-pixel'),
                    'top-right' => esc_html__('Top Right', 'dipi-divi-pixel'),
                    'right' => esc_html__('Right', 'dipi-divi-pixel'),
                    'bottom-right' => esc_html__('Bottom Right', 'dipi-divi-pixel'),
                    'bottom' => esc_html__('Bottom', 'dipi-divi-pixel'),
                    'bottom-left' => esc_html__('Bottom Left', 'dipi-divi-pixel'),
                    'left' => esc_html__('Left', 'dipi-divi-pixel'),
                    'top-left' => esc_html__('Top Left', 'dipi-divi-pixel')
                ],
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on'
                ]),
            ],
            'particle_interactivity' => [
                'label' => esc_html__('Particles Interactivity', 'dipi-divi-pixel'),
                'type' => 'select',
                'panel' => 'general',
                'section' => 'particles',
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'dipi-divi-pixel'),
                    'grab' => esc_html__('Grab', 'dipi-divi-pixel'),
                    'bubble' => esc_html__('Bubble', 'dipi-divi-pixel'),
                    'repulse' => esc_html__('Repulse', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on'
                ]),
            ],
            'particles_count' => [
                'label' => esc_html__('Particles Count', 'dipi-divi-pixel'),
                'type' => 'range',
                'panel' => 'general',
                'section' => 'particles',
                'default' => 80,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 300,
                    'step' => 1
                ],
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on'
                ]),
            ],
            'particles_size' => [
                'label' => esc_html__('Particles Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'panel' => 'general',
                'section' => 'particles',
                'default' => 3,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1
                ],
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on'
                ]),
            ],
            'particles_speed' => [
                'label' => esc_html__('Particles Speed', 'dipi-divi-pixel'),
                'type' => 'range',
                'panel' => 'general',
                'section' => 'particles',
                'default' => 5,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1
                ],
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on'
                ]),
            ],
            'particles_width' => [
                'label' => esc_html__('Link Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'panel' => 'general',
                'section' => 'particles',
                'default' => 1,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1
                ],
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on'
                ]),
            ],
            
            'link_distance' => [
                'label' => esc_html__('Link Distance', 'dipi-divi-pixel'),
                'type' => 'range',
                'panel' => 'general',
                'section' => 'particles',
                'default' => 150,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 1000,
                    'step' => 1
                ],
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on'
                ]),
            ],
            // Particles Background #2
            'particles_heading_2' => [
                'label' => esc_html__('Particles Background #2', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'particles',
                'panel' => 'general',
                'icon' => 'dp-social',
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on'
                ]),
            ],
            'particles_color_2' => [
                'label' => esc_html__('Particles Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'panel' => 'general',
                'section' => 'particles',
                'default' => 'rgba(0,0,0,.4)',
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on'
                ]),
            ],
            'link_color_2' => [
                'label' => esc_html__('Link Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'panel' => 'general',
                'section' => 'particles',
                'default' => 'rgba(0,0,0,.4)',
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on',
                ]),
            ],
            'particle_shape_2' => [
                'label' => esc_html__('Particles Shape', 'dipi-divi-pixel'),
                'type' => 'select',
                'panel' => 'general',
                'section' => 'particles',
                'default' => 'circle',
                'options' => [
                    'circle' => esc_html__('Circle', 'dipi-divi-pixel'),
                    'triangle' => esc_html__('Triangle', 'dipi-divi-pixel'),
                    'edge' => esc_html__('Square', 'dipi-divi-pixel'),
                    'polygon' => esc_html__('Polygon', 'dipi-divi-pixel'),
                    'star' => esc_html__('Star', 'dipi-divi-pixel')
                ],
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on'
                ]),
            ],
            'particle_move_direction_2' => [
                'label' => esc_html__('Move Direction', 'dipi-divi-pixel'),
                'type' => 'select',
                'panel' => 'general',
                'section' => 'particles',
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'dipi-divi-pixel'),
                    'top' => esc_html__('Top', 'dipi-divi-pixel'),
                    'top-right' => esc_html__('Top Right', 'dipi-divi-pixel'),
                    'right' => esc_html__('Right', 'dipi-divi-pixel'),
                    'bottom-right' => esc_html__('Bottom Right', 'dipi-divi-pixel'),
                    'bottom' => esc_html__('Bottom', 'dipi-divi-pixel'),
                    'bottom-left' => esc_html__('Bottom Left', 'dipi-divi-pixel'),
                    'left' => esc_html__('Left', 'dipi-divi-pixel'),
                    'top-left' => esc_html__('Top Left', 'dipi-divi-pixel')
                ],
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on'
                ]),
            ],
            'particle_interactivity_2' => [
                'label' => esc_html__('Particles Interactivity', 'dipi-divi-pixel'),
                'type' => 'select',
                'panel' => 'general',
                'section' => 'particles',
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'dipi-divi-pixel'),
                    'grab' => esc_html__('Grab', 'dipi-divi-pixel'),
                    'bubble' => esc_html__('Bubble', 'dipi-divi-pixel'),
                    'repulse' => esc_html__('Repulse', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on'
                ]),
            ],
            'particles_count_2' => [
                'label' => esc_html__('Particles Count', 'dipi-divi-pixel'),
                'type' => 'range',
                'panel' => 'general',
                'section' => 'particles',
                'default' => 80,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 300,
                    'step' => 1
                ],
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on'
                ]),
            ],
            'particles_size_2' => [
                'label' => esc_html__('Particles Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'panel' => 'general',
                'section' => 'particles',
                'default' => 3,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1
                ],
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on'
                ]),
            ],
            'particles_speed_2' => [
                'label' => esc_html__('Particles Speed', 'dipi-divi-pixel'),
                'type' => 'range',
                'panel' => 'general',
                'section' => 'particles',
                'default' => 5,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1
                ],
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on'
                ]),
            ],
            'particles_width_2' => [
                'label' => esc_html__('Link Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'panel' => 'general',
                'section' => 'particles',
                'default' => 1,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1
                ],
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on'
                ]),
            ],
            
            'link_distance_2' => [
                'label' => esc_html__('Link Distance', 'dipi-divi-pixel'),
                'type' => 'range',
                'panel' => 'general',
                'section' => 'particles',
                'default' => 150,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 1000,
                    'step' => 1
                ],
                'active_callback' => $this->show_if_option([
                    'use_particles' => 'on'
                ]),
            ],

            'btt_btn_info_bar' => [
                'label' => esc_html__('Customize Back To Top Button', 'dipi-divi-pixel'),
                'description' => esc_html__('To enable Back To Top button customization go to DiviPixel Plugin Dashboard and enable Custom Back To Top option available in General settings.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'back_to_top',
                'cta' => true,
                'panel' => 'general',
                'icon' => 'dp-btt',
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'off',
                ]),
            ],
            'btt_btn_text_heading' => [
                'label' => esc_html__('Button Text Style', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Button Text', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'back_to_top',
                'panel' => 'general',
                'icon' => 'dp-font',
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                    'btt_button_style' => ['display_text', 'display_text_icon',]
                ]),
            ],
            'btt_custom_text' => [
                'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
                'type' => 'text',
                'section' => 'back_to_top',
                'panel' => 'general',
                'default' => 'Top',
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                    'btt_button_style' => ['display_text', 'display_text_icon',]
                ]),
            ],
            'btt_text_placement' => [
                'label' => esc_html__('Display Text', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'back_to_top',
                'panel' => 'general',
                'default' => 'vertically',
                'options' => [
                    'horizontally' => esc_html__('Horizontally', 'dipi-divi-pixel'),
                    'vertically' => esc_html__('Vertically', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                    'btt_button_style' => ['display_text', 'display_text_icon',]
                ]),
            ],
            'btt_font' => [
                'label' => esc_html__('Text Font', 'dipi-divi-pixel'),
                // 'description' => esc_html__('Select a font', 'dipi-divi-pixel'),
                'type' => 'font',
                'section' => 'back_to_top',
                'panel' => 'general',
                'default' => 'none',
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                    'btt_button_style' => ['display_text', 'display_text_icon',]
                ]),
            ],
            'btt_text_size' => [
                'label' => esc_html__('Button Text Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'back_to_top',
                'panel' => 'general',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                    'btt_button_style' => ['display_text', 'display_text_icon',]
                ]),
            ],
            'btt_text_letter_spacing' => [
                'label' => esc_html__('Button Text Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'back_to_top',
                'panel' => 'general',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 5,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                    'btt_button_style' => ['display_text', 'display_text_icon',]
                ]),
            ],
            'btt_font_weight' => [
                'label' => esc_html__('Font Weight', 'dipi-divi-pixel'),
                // 'description' => esc_html__('Select a file', 'dipi-divi-pixel'),
                'type' => 'font_weight',
                'section' => 'back_to_top',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                    'btt_button_style' => ['display_text', 'display_text_icon',]
                ]),
            ],
            'btt_font_style' => [
                'label' => esc_html__('Text Style', 'dipi-divi-pixel'),
                // 'description' => esc_html__('Select a font style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'back_to_top',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                    'btt_button_style' => ['display_text', 'display_text_icon',]
                ]),
            ],
            'btt_btn_icon_heading' => [
                'label' => esc_html__('Button Icon', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Button Icon', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'back_to_top',
                'panel' => 'general',
                'icon' => 'dp-click',
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                    'btt_button_style' => ['display_icon', 'display_text_icon',]
                ]),
            ],
            'btt_icon' => [
                'label' => esc_html__('Back To Top Icon', 'dipi-divi-pixel'),
                'type' => 'divi_icon',
                'section' => 'back_to_top',
                'panel' => 'general',
                'default' => '!',
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                    'btt_button_style' => ['display_icon', 'display_text_icon',]
                ]),
            ],
            'btt_btn_icon_size' => [
                'label' => esc_html__('Icon Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'back_to_top',
                'panel' => 'general',
                'default' => '20',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                    'btt_button_style' => ['display_icon', 'display_text_icon',]
                ]),
            ],
            'btt_btn_style_heading' => [
                'label' => esc_html__('Button Style', 'dipi-divi-pixel'),
                'description' => esc_html__('Edit Button Style.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'back_to_top',
                'panel' => 'general',
                'icon' => 'dp-spacing',
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                ]),
            ],
            'btt_hover_anim' => [
                'label' => esc_html__('Add Hover Animation', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'back_to_top',
                'panel' => 'general',
                'default' => 'zoomup',
                'options' => [
                    'none' => esc_html__('None', 'dipi-divi-pixel'),
                    'zoomin' => esc_html__('Zoom In', 'dipi-divi-pixel'),
                    'zoomout' => esc_html__('Zoom Out', 'dipi-divi-pixel'),
                    'zoomup' => esc_html__('Move Up', 'dipi-divi-pixel'),
                    'zoomdown' => esc_html__('Move Down', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                ]),
            ],

            'btt_btn_border' => [
                'label' => esc_html__('Button Border Radius', 'dipi-divi-pixel'),
                'description' => esc_html__('Setup your border radius', 'dipi-divi-pixel'),
                'type' => 'border_radii',
                'section' => 'back_to_top',
                'panel' => 'general',
                'default' => '4',
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                ]),
            ],
            'btt_btn_padding' => [
                'label' => esc_html__('Padding', 'dipi-divi-pixel'),
                'description' => esc_html__('Setup your padding', 'dipi-divi-pixel'),
                'default' => '20',
                'type' => 'padding',
                'section' => 'back_to_top',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                ]),
            ],
            'btt_btn_right_margin' => [
                'label' => esc_html__('Margin Right', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'back_to_top',
                'panel' => 'general',
                'default' => '20',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                ]),
            ],
            'btt_btn_bottom_margin' => [
                'label' => esc_html__('Margin Bottom', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'back_to_top',
                'panel' => 'general',
                'default' => '20',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                ]),
            ],
            'btt_btn_colors_heading' => [
                'label' => esc_html__('Button Color', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Button Colors', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'back_to_top',
                'panel' => 'general',
                'icon' => 'dp-color',
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                ]),
            ],
            'btt_btn_background' => [
                'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'back_to_top',
                'panel' => 'general',
                'default' => 'rgba(0,0,0,.4)',
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                ]),
            ],
            'btt_btn_color' => [
                'label' => esc_html__('Icon/Text Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'back_to_top',
                'panel' => 'general',
                'default' => '#fff',
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                ]),
            ],
            'btt_btn_background_hover' => [
                'label' => esc_html__('Hover Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'back_to_top',
                'panel' => 'general',
                'default' => '#000',
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                ]),
            ],
            'btt_btn_color_hover' => [
                'label' => esc_html__('Hover Icon/Text Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'back_to_top',
                'panel' => 'general',
                'default' => '#fff',
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                ]),
            ],
            'btt_btn_shadow_heading' => [
                'label' => esc_html__('Add Button Shadow', 'dipi-divi-pixel'),
                'description' => esc_html__('Add Shadow to Back To Top Button', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'back_to_top',
                'panel' => 'general',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                ]),
            ],
            'btt_btn_shadow' => [
                'default' => false,
                'label' => esc_html__('Add Button Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'back_to_top',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                ]),
            ],
            'btt_btn_shadow_color' => [
                'label' => esc_html__('Button Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'back_to_top',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                ]),
            ],
            'btt_btn_shadow_offset' => [
                'label' => esc_html__('Button Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'back_to_top',
                'panel' => 'general',
                'default' => '5',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                ]),
            ],
            'btt_btn_shadow_blur' => [
                'label' => esc_html__('Button Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'back_to_top',
                'panel' => 'general',
                'default' => '5',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                ]),
            ],
            'btt_btn_shadow_color_hover' => [
                'label' => esc_html__('Hover Button Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'back_to_top',
                'panel' => 'general',
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                ]),
            ],
            'btt_btn_shadow_offset_hover' => [
                'label' => esc_html__('Hover Button Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'back_to_top',
                'panel' => 'general',
                'default' => '5',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                ]),
            ],
            'btt_btn_shadow_blur_hover' => [
                'label' => esc_html__('Hover Button Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'back_to_top',
                'panel' => 'general',
                'default' => '5',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'back_to_top' => 'on',
                ]),
            ],
        ];
    }

    private function get_header_fields()
    {
        return [
            'menu_hover_info' => [
                'label' => esc_html__('Hover Animation', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize the main menu item hover animation.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'primary_nav',
                'panel' => 'header',
                'icon' => 'dp-click',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],
            'menu_hover_element_color' => [
                'label' => esc_html__('Animated Element Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'primary_nav',
                'panel' => 'header',
                'default' => $this->accent_color(),
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],
            'menu_hover_element_color_fixed' => [
                'label' => esc_html__('Fixed Animated Element Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'primary_nav',
                'panel' => 'header',
                'default' => $this->accent_color(),
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],

            'menu_hover_element_dot_size' => [
                'label' => esc_html__('Dot Animated Element Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'primary_nav',
                'panel' => 'header',
                'default' => 5,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'menu_hover_styles' => [
                        'three_dots'
                    ]
                ]),
            ],

            // filled_background
            'filled_background_border_size' => [
                'label' => esc_html__('Border Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'primary_nav',
                'panel' => 'header',
                'default' => 2,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'menu_hover_styles' => [
                        'filled_background'
                    ]
                ]),
            ],

            //  'filled_background_border_radii' => [
            //     'label' => esc_html__('Border Width', 'dipi-divi-pixel'),
            //     'type' => 'range',
            //     'section' => 'primary_nav',
            //     'panel' => 'header',
            //     'default' => 2,
            //     'input_attrs' => [
            //         'min' => 0,
            //         'max' => 100,
            //         'step' => 1,
            //         'suffix' => 'px'
            //     ],
            //     'active_callback' => $this->show_if_option([
            //         'menu_styles' => 'on',
            //         'menu_hover_styles' => [
            //             'filled_background'
            //         ]
            //     ]),
            // ],

            'filled_background_border_radii' => [
                'label' => esc_html__('Border Radius', 'dipi-divi-pixel'),
                'type' => 'border_radii',
                'section' => 'primary_nav',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'menu_hover_styles' => [
                        'filled_background'
                    ]
                ]),
            ],

            'filled_background_border_color' => [
                'label' => esc_html__('Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'primary_nav',
                'panel' => 'header',
                'default' => $this->accent_color(),
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'menu_hover_styles' => [
                        'filled_background'
                    ]
                ]),
            ],

            'filled_background_shadow' => [
                'label' => esc_html__('Filled Background Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'primary_nav',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'menu_hover_styles' => [
                        'filled_background'
                    ]
                ]),
            ],
            'filled_background_shadow_color' => [
                'label' => esc_html__('Filled Background Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'primary_nav',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'menu_hover_styles' => [
                        'filled_background'
                    ]
                ]),
            ],
            'filled_background_shadow_offset' => [
                'label' => esc_html__('Filled Background Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'primary_nav',
                'panel' => 'header',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'menu_hover_styles' => [
                        'filled_background'
                    ]
                ]),
            ],
            'filled_background_shadow_blur' => [
                'label' => esc_html__('Filled Background Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'primary_nav',
                'panel' => 'header',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'menu_hover_styles' => [
                        'filled_background'
                    ]
                ]),
            ],

            'menu_hover_element_top_size' => [
                'label' => esc_html__('1st Animated Element Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'primary_nav',
                'panel' => 'header',
                'default' => 2,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'menu_hover_styles' => [
                        'slide_up_below',
                        'slide_down_below',
                        'grow_below_left',
                        'grow_below_center',
                        'grow_below_right',
                        'grow_above_and_below_left',
                        'grow_above_and_below_center',
                        'grow_above_and_below_right',
                    ]
                ]),
            ],
            'menu_hover_element_top_space' => [
                'label' => esc_html__('1st Animated Element Vertical Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'primary_nav',
                'panel' => 'header',
                'default' => 25,
                'input_attrs' => [
                    'min' => -50,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'menu_hover_styles' => [
                        'three_dots',
                        'slide_up_below',
                        'slide_down_below',
                        'grow_below_left',
                        'grow_below_center',
                        'grow_below_right',
                        'grow_above_and_below_left',
                        'grow_above_and_below_center',
                        'grow_above_and_below_right',
                        'bracketed_out',
                        'bracketed_in',
                    ]
                ]),
            ],
            'menu_hover_element_bottom_space' => [
                'label' => esc_html__('2nd Animated Element Vertical Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'primary_nav',
                'panel' => 'header',
                'default' => -5,
                'input_attrs' => [
                    'min' => -50,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'menu_hover_styles' => [
                        'three_dots',
                        'slide_up_below',
                        'slide_down_below',
                        'grow_below_left',
                        'grow_below_center',
                        'grow_below_right',
                        'grow_above_and_below_left',
                        'grow_above_and_below_center',
                        'grow_above_and_below_right',
                        'bracketed_out',
                        'bracketed_in',
                    ]
                ]),
            ],
            'menu_hover_element_top_space_between' => [
                'label' => esc_html__('Dot Horizontal Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'primary_nav',
                'panel' => 'header',
                'default' => 10,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'menu_hover_styles' => [
                        'three_dots',
                    ]
                ]),
            ],
            'menu_hover_element_radius' => [
                'label' => esc_html__('Animated Element Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'primary_nav',
                'panel' => 'header',
                'default' => 0,
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'menu_hover_styles' => [
                        'slide_up_below',
                        'slide_down_below',
                        'grow_below_left',
                        'grow_below_center',
                        'grow_below_right',
                        'grow_above_and_below_left',
                        'grow_above_and_below_center',
                        'grow_above_and_below_right',
                    ]
                ]),
            ],
            'active_menu_item_style' => [
                'label' => esc_html__('Apply Hover Style To Active Menu Item', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'primary_nav',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],

            'active_parent_menu_item_style' => [
                'label' => esc_html__('Apply Hover Style to Parent Menu item when Submenu Page selected', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'primary_nav',
                'panel' => 'header',
                'default' => 'on',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],

            'disable_element_animations' => [
                'label' => esc_html__('Disable Element Animation for Menu Items with Dropdowns', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'primary_nav',
                'panel' => 'header',
                'default' => 'on',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],

            'main_header_styles_disabled_info' => [
                'label' => esc_html__('Customize Main Header Bar', 'dipi-divi-pixel'),
                'description' => esc_html__('To customize Main Header Bar shadows enable Header & Navigation customization and disable Remove Main Header Shadow option in Divi Pixel plugin dashboard.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'main_header',
                'panel' => 'header',
                'cta' => true,
                'icon' => 'dp-header',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'off',
                    'menu_styles' => 'on',
                    'header_underline' => 'on',
                ]),
            ],
            'main_header_shadow_heading' => [
                'label' => esc_html__('Main Header Shadow', 'dipi-divi-pixel'),
                'description' => esc_html__('Enable this option to display Main Header Shadow', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'main_header',
                'panel' => 'header',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'header_underline' => 'off',
                ]),
            ],
            'main_header_shadow' => [
                'label' => esc_html__('Display Main Header Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'main_header',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'header_underline' => 'off',
                ]),
            ],
            'main_header_shadow_color' => [
                'label' => esc_html__('Header Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'main_header',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'header_underline' => 'off',
                ]),
            ],
            'main_header_shadow_offset' => [
                'label' => esc_html__('Header Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'main_header',
                'panel' => 'header',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'header_underline' => 'off',
                ]),
            ],
            'main_header_shadow_blur' => [
                'label' => esc_html__('Header Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'main_header',
                'panel' => 'header',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'header_underline' => 'off',
                ]),
            ],
            'fixed_header_shadow_heading' => [
                'label' => esc_html__('Fixed Header Shadow', 'dipi-divi-pixel'),
                'description' => esc_html__('Enable this option to display Fixed Header Shadow', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'main_header',
                'panel' => 'header',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'header_underline' => 'off',
                ]),
            ],
            'fixed_header_shadow' => [
                'label' => esc_html__('Display Fixed Header Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'main_header',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'header_underline' => 'off',
                ]),
            ],
            'fixed_header_shadow_color' => [
                'label' => esc_html__('Fixed Header Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'main_header',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'header_underline' => 'off',
                ]),
            ],
            'fixed_header_shadow_offset' => [
                'label' => esc_html__('Fixed Header Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'main_header',
                'panel' => 'header',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'header_underline' => 'off',
                ]),
            ],
            'fixed_header_shadow_blur' => [
                'label' => esc_html__('Fixed Header Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'main_header',
                'panel' => 'header',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                    'header_underline' => 'off',
                ]),
            ],
            'top_bar_disabled_info' => [
                'label' => esc_html__('Customize Top Bar Menu', 'dipi-divi-pixel'),
                'description' => esc_html__('To customize Top Bar Menu enable Header & Navigation customization in Divi Pixel plugin dashboard.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'top_bar',
                'panel' => 'header',
                'icon' => 'dp-header',
                'cta' => true,
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'off',
                ]),
            ],
            'hide_top_bar' => [
                'label' => esc_html__('Hide Top Bar on Scroll', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'top_bar',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],
            'top_bar_font_heading' => [
                'label' => esc_html__('Font Customization', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Top Bar Font Styles', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'top_bar',
                'panel' => 'header',
                'icon' => 'dp-font',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],
            'top_bar_text_size' => [
                'label' => esc_html__('Top Bar Font Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'top_bar',
                'panel' => 'header',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],
            'top_bar_letter_spacing' => [
                'label' => esc_html__('Text Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'top_bar',
                'panel' => 'header',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],
            'top_bar_font' => [
                'label' => esc_html__('Top Bar Text Font', 'dipi-divi-pixel'),
                'type' => 'font',
                'section' => 'top_bar',
                'panel' => 'header',
                'default' => 'none',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],
            'top_bar_font_weight' => [
                'label' => esc_html__('Font Weight', 'dipi-divi-pixel'),
                'type' => 'font_weight',
                'section' => 'top_bar',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],
            'top_bar_font_style' => [
                'label' => esc_html__('Text Style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'top_bar',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],
            'top_bar_shadow_heading' => [
                'label' => esc_html__('Top Bar Shadow', 'dipi-divi-pixel'),
                'description' => esc_html__('Enable this option to display Top Bar Shadow', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'top_bar',
                'panel' => 'header',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],
            'top_bar_shadow' => [
                'label' => esc_html__('Display Top Bar Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'top_bar',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],
            'top_bar_shadow_color' => [
                'label' => esc_html__('Top Bar Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'top_bar',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],
            'top_bar_shadow_offset' => [
                'label' => esc_html__('Top Bar Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'top_bar',
                'panel' => 'header',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],
            'top_bar_shadow_blur' => [
                'label' => esc_html__('Top Bar Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'top_bar',
                'panel' => 'header',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],
            'primary_nav_disabled_info' => [
                'label' => esc_html__('Customize Primary Navigation', 'dipi-divi-pixel'),
                'description' => esc_html__('To customize Primary Navigation enable Header & Navigation customization in Divi Pixel plugin dashboard.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'primary_nav',
                'panel' => 'header',
                'icon' => 'dp-header',
                'cta' => true,
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'off',
                ]),
            ],
            'primary_nav_heading' => [
                'label' => esc_html__('Customize Primary Navigation', 'dipi-divi-pixel'),
                // 'description' => esc_html__('To customize Primary Navigation enable Header & Navigation customization in Divi Pixel plugin dashboard.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'primary_nav',
                'panel' => 'header',
                'icon' => 'dp-header',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],
            'primary_nav_font_weight' => [
                'label' => esc_html__('Font Weight', 'dipi-divi-pixel'),
                'type' => 'font_weight',
                'section' => 'primary_nav',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],
            'primary_nav_font_style' => [
                'label' => esc_html__('Text Style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'primary_nav',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],
            'primary_nav_hover_txt_color' => [
                'label' => esc_html__('Hover Text Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'primary_nav',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],
            'fixed_primary_nav_hover_txt_color' => [
                'label' => esc_html__('Fixed Header Hover Text Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'primary_nav',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],
            'primary_nav_spacing' => [
                'label' => esc_html__('Spacing Between Main Menu Items', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'primary_nav',
                'panel' => 'header',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],
            'fixed_nav_spacing' => [
                'label' => esc_html__('Spacing Between Fixed Nav Menu Items', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'primary_nav',
                'panel' => 'header',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_styles' => 'on',
                ]),
            ],



            'dropdown_disabled_info' => [
                'label' => esc_html__('Customize Menu Dropdowns', 'dipi-divi-pixel'),
                'description' => esc_html__('To customize Menu Dropdowns please enable Customize Header and Navigation Styles/Custom Menu Drodown in Divi Pixel dashboard.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'menu_dropdowns',
                'panel' => 'header',
                'cta' => true,
                'icon' => 'dp-dropdown',
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'off',
                    'menu_styles' => 'off',
                ], "OR"),
            ],
            'dropdown_font_heading' => [
                'label' => esc_html__('Font Styles', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Menu Dropdowns Font Styles', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'menu_dropdowns',
                'panel' => 'header',
                'icon' => 'dp-font',
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdown_font_select' => [
                'label' => esc_html__('Select Font', 'dipi-divi-pixel'),
                'type' => 'font',
                'default' => 'none',
                'section' => 'menu_dropdowns',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdown_font_style' => [
                'label' => esc_html__('Menu Font Style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'menu_dropdowns',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdown_font_weight' => [
                'label' => esc_html__('Font Weight', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_dropdowns',
                'panel' => 'header',
                'default' => '700',
                'input_attrs' => [
                    'min' => 100,
                    'max' => 900,
                    'step' => 100
                ],
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdown_text_size' => [
                'label' => esc_html__('Font Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_dropdowns',
                'panel' => 'header',
                'default' => '14',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdown_letter_spacing' => [
                'label' => esc_html__('Text Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_dropdowns',
                'panel' => 'header',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdown_hover_letter_spacing' => [
                'label' => esc_html__('Hover Text Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_dropdowns',
                'panel' => 'header',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdown_menu_text_color' => [
                'label' => esc_html__('Link Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'menu_dropdowns',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdown_menu_text_color_hover' => [
                'label' => esc_html__('Hover Link Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'menu_dropdowns',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdown_menu_text_box_hover' => [
                'label' => esc_html__('Hover Link Box Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'menu_dropdowns',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdowns_animations_heading' => [
                'label' => esc_html__('Dropdown Menu Hover Effect', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Dropdown Menu Hover Effect', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'menu_dropdowns',
                'panel' => 'header',
                'icon' => 'dp-click',
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdown_hover_link_animation' => [
                'label' => esc_html__('Hover Link Animation', 'dipi-divi-pixel'),
                'description' => esc_html__('Select animation for the links on hover.', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'menu_dropdowns',
                'panel' => 'header',
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'dipi-divi-pixel'),
                    'grow' => esc_html__('Grow', 'dipi-divi-pixel'),
                    'slide_right' => esc_html__('Slide Right', 'dipi-divi-pixel'),
                    'slide_left' => esc_html__('Slide Left', 'dipi-divi-pixel'),
                    'move_up' => esc_html__('Move Up', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdowns_arrow' => [
                'label' => esc_html__('Add Dropdown arrow', 'dipi-divi-pixel'),
                'description' => esc_html__('Add small animated arrow to dropdown on open', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'menu_dropdowns',
                'panel' => 'header',
                'default' => true,
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ], 
            'dropdowns_style_heading' => [
                'label' => esc_html__('Dropdown Box Style', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'menu_dropdowns',
                'panel' => 'header',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdown_box_background' => [
                'label' => esc_html__('Dropdown Box Background', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'menu_dropdowns',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdowns_box_radius' => [
                'label' => esc_html__('Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_dropdowns',
                'panel' => 'header',
                'default' => '5',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdowns_vertical_position' => [
                'label' => esc_html__('Dropdowns Vertical Position', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_dropdowns',
                'default' => '100',
                'panel' => 'header',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1
                ],
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdowns_width' => [
                'label' => esc_html__('Dropdowns Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_dropdowns',
                'default' => '240',
                'panel' => 'header',
                'input_attrs' => [
                    'min' => 200,
                    'max' => 1080,
                    'step' => 1
                ],
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdowns_item_width' => [
                'label' => esc_html__('Menu Item Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_dropdowns',
                'default' => '100',
                'panel' => 'header',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => '%'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdowns_shadow' => [
                'label' => esc_html__('Display Dropdown Box Shadow', 'dipi-divi-pixel'),
                'description' => esc_html__('Enable this option to display Menu Dopdowns Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'menu_dropdowns',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdowns_shadow_color' => [
                'label' => esc_html__('Dropdowns Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'menu_dropdowns',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdowns_shadow_offset' => [
                'label' => esc_html__('Dropdowns Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_dropdowns',
                'panel' => 'header',
                'default' => '5',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'dropdowns_shadow_blur' => [
                'label' => esc_html__('Dropdowns Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_dropdowns',
                'default' => '10',
                'panel' => 'header',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_dropdown' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_disabled' => [
                'label' => esc_html__('Customize Menu Button', 'dipi-divi-pixel'),
                'description' => esc_html__('To customize Menu Button styles please enable Header & Navigation Customization/Add CTA Button to Main Menu option available in Divi Pixel dashboard.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'menu_button',
                'panel' => 'header',
                'cta' => true,
                'icon' => 'dp-click',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'off',
                    'menu_styles' => 'off',
                ], "OR"),
            ],
            'menu_btn_heading' => [
                'label' => esc_html__('Menu Button Font', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Menu Button Font Styles', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'menu_button',
                'panel' => 'header',
                'icon' => 'dp-font',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_font_select' => [
                'label' => esc_html__('Select Font', 'dipi-divi-pixel'),
                'type' => 'font',
                'default' => 'none',
                'section' => 'menu_button',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_text_size' => [
                'label' => esc_html__('Font Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => '15',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_letter_spacing' => [
                'label' => esc_html__('Text Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_font_weight' => [
                'label' => esc_html__('Font Weight', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => '700',
                'input_attrs' => [
                    'min' => 100,
                    'max' => 900,
                    'step' => 100
                ],
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_font_style' => [
                'label' => esc_html__('Menu Font Style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'menu_button',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_text_color' => [
                'label' => esc_html__('Text Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => '#ffffff80',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_hover_text_color' => [
                'label' => esc_html__('Hover Text Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => '#ffffff',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'fixed_menu_btn_text_color' => [
                'label' => esc_html__('Fixed Text Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => '#ffffff90',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'fixed_menu_btn_hover_text_color' => [
                'label' => esc_html__('Fixed Hover Text Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'menu_button',
                'default' => '#ffffff',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_icon_heading' => [
                'label' => esc_html__('Button Icon', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Menu Button icon', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'menu_button',
                'panel' => 'header',
                'icon' => 'dp-click',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],

            'menu_btn_icon_display' => [
                'label' => esc_html__('Icon Position', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => 'right',
                'options' => [
                    'none' => esc_html__('None', 'dipi-divi-pixel'),
                    'left' => esc_html__('Left', 'dipi-divi-pixel'),
                    'right' => esc_html__('Right', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_select_icon' => [
                'label' => esc_html__('Select Icon', 'dipi-divi-pixel'),
                'type' => 'divi_icon',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => '$',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_icon_size' => [
                'label' => esc_html__('Icon Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => '15',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_style_heading' => [
                'label' => esc_html__('Button Style', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'menu_button',
                'panel' => 'header',
                'icon' => 'dp-color',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_hover_effect' => [
                'label' => esc_html__('Button Hover Effect', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => 'zoomin',
                'options' => [
                    'none' => esc_html__('None', 'dipi-divi-pixel'),
                    'zoomin' => esc_html__('Zoom In', 'dipi-divi-pixel'),
                    'zoomout' => esc_html__('Zoom Out', 'dipi-divi-pixel'),
                    'moveup' => esc_html__('Move Up', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_padding' => [
                'label' => esc_html__('Button Padding', 'dipi-divi-pixel'),
                'type' => 'padding',
                'default' => '10|20',
                'section' => 'menu_button',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_background' => [
                'label' => esc_html__('Button Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => '#2c3d4990',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_background_hover' => [
                'label' => esc_html__('Hover Button Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => '#2c3d49',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'fixed_menu_btn_background' => [
                'label' => esc_html__('Fixed Button Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => '#2c3d4990',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'fixed_menu_btn_background_hover' => [
                'label' => esc_html__('Fixed Hover Button Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => '#2c3d49',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_border_width' => [
                'label' => esc_html__('Border Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_border_radius' => [
                'label' => esc_html__('Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => '50',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_border_color' => [
                'label' => esc_html__('Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'menu_button',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_hover_border_color' => [
                'label' => esc_html__('Hover Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'menu_button',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'fixed_menu_btn_border_color' => [
                'label' => esc_html__('Fixed Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'menu_button',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'fixed_menu_btn_hover_border_color' => [
                'label' => esc_html__('Fixed Hover Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'menu_button',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_shadow_heading' => [
                'label' => esc_html__('Button Shadow', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'menu_button',
                'panel' => 'header',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_shadow' => [
                'label' => esc_html__('Display Button Shadow', 'dipi-divi-pixel'),
                'description' => esc_html__('Enable this option to display Menu Button Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'menu_button',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_shadow_color' => [
                'label' => esc_html__('Button Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => '#00000010',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_shadow_offset' => [
                'label' => esc_html__('Button Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => '5',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_shadow_blur' => [
                'label' => esc_html__('Button Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => '10',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_hover_shadow' => [
                'label' => esc_html__('Hover Button Shadow', 'dipi-divi-pixel'),
                'description' => esc_html__('Enable this option to customize button shadow on hover.', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'menu_button',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_hover_shadow_color' => [
                'label' => esc_html__('Hover Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'menu_button',
                'default' => '#00000020',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_hover_shadow_offset' => [
                'label' => esc_html__('Hover Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => '5',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],
            'menu_btn_hover_shadow_blur' => [
                'label' => esc_html__('Hover Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_button',
                'panel' => 'header',
                'default' => '20',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 80,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'menu_button' => 'on',
                    'menu_styles' => 'on',
                ], "AND"),
            ],


            /***************************** 
             * Header Social Icon Styles *
             *****************************/
            'social_icon_header_disabled_notice' => [
                'label' => esc_html__('Social Icon Styles', 'dipi-divi-pixel'),
                'description' => esc_html__('To customize the social icon styles, please enable this option in Divi Pixel Dashboard.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'menu_social_icons',
                'panel' => 'header',
                'cta' => true,
                'icon' => 'dp-social',
                'active_callback' => $this->show_if_option([
                    'use_dipi_social_icons' => 'off',
                ]),
            ],
            'social_icon_style_heading' => [
                'label' => esc_html__('Social Icon Style', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Social Media Icons in the Header.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'icon' => 'dp-social',
                'section' => 'menu_social_icons',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'use_dipi_social_icons' => 'on',
                ]),
            ],
            'social_icon_hover_effect' => [
                'label' => esc_html__('Social Icon Hover Effect', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'menu_social_icons',
                'panel' => 'header',
                'default' => 'zoom',
                'options' => [
                    'none' => esc_html__('None', 'dipi-divi-pixel'),
                    'zoom' => esc_html__('Zoom', 'dipi-divi-pixel'),
                    'slide_up' => esc_html__('Slide Up', 'dipi-divi-pixel'),
                    'rotate' => esc_html__('Rotate', 'dipi-divi-pixel'),
                    // 'ripple' => esc_html__('Ripple', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'use_dipi_social_icons' => 'on',
                ]),
            ],
            'social_icon_size' => [
                'label' => esc_html__('Icon Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_social_icons',
                'panel' => 'header',
                'default' => '15',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'use_dipi_social_icons' => 'on',
                ]),
            ],
            'social_icon_color' => [
                'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'default' => '#2c3d49',
                'section' => 'menu_social_icons',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'use_dipi_social_icons' => 'on',
                ]),
            ],
            'social_icon_hover_color' => [
                'label' => esc_html__('Hover Icon Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'default' => '#ffffff',
                'section' => 'menu_social_icons',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'use_dipi_social_icons' => 'on',
                ]),
            ],
            'social_icon_box_heading' => [
                'label' => esc_html__('Icon Box Style', 'dipi-divi-pixel'),
                'description' => esc_html__('Enable this option to customize boxed social media icons.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'icon' => 'dp-spacing',
                'section' => 'menu_social_icons',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'use_dipi_social_icons' => 'on',
                ]),
            ],
            'social_icon_box_style' => [
                'label' => esc_html__('Enable Boxed Style', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'default' => 'on',
                'section' => 'menu_social_icons',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'use_dipi_social_icons' => 'on',
                ]),
            ],
            'social_icon_box_radius' => [
                'label' => esc_html__('Box Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_social_icons',
                'panel' => 'header',
                'default' => '100',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'use_dipi_social_icons' => 'on',
                ]),
            ],
            'social_icon_box_padding' => [
                'label' => esc_html__('Icon Box Padding', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_social_icons',
                'panel' => 'header',
                'default' => '10',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'use_dipi_social_icons' => 'on',
                ]),
            ],
            'social_icon_box_background' => [
                'label' => esc_html__('Icon Box Background', 'dipi-divi-pixel'),
                'type' => 'color',
                'default' => 'rgba(44,61,73,0.1)',
                'section' => 'menu_social_icons',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'use_dipi_social_icons' => 'on',
                ]),
            ],
            'social_icon_box_background_hover' => [
                'label' => esc_html__('Hover Icon Box Background', 'dipi-divi-pixel'),
                'type' => 'color',
                'default' => '#2c3d49',
                'section' => 'menu_social_icons',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'use_dipi_social_icons' => 'on',
                ]),
            ],
            'social_icon_shadow' => [
                'label' => esc_html__('Display Icon Box Shadow', 'dipi-divi-pixel'),
                'description' => esc_html__('Enable this option to display Icon Box Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'menu_social_icons',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'use_dipi_social_icons' => 'on',
                ]),
            ],
            'social_icon_shadow_color' => [
                'label' => esc_html__('Icon Box Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'default' => 'rgba(21,2,42,0.1)',
                'section' => 'menu_social_icons',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'use_dipi_social_icons' => 'on',
                ]),
            ],
            'social_icon_shadow_offset' => [
                'label' => esc_html__('Icon Box Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_social_icons',
                'panel' => 'header',
                'default' => '3',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'use_dipi_social_icons' => 'on',
                ]),
            ],
            'social_icon_shadow_blur' => [
                'label' => esc_html__('Icon Box Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_social_icons',
                'panel' => 'header',
                'default' => '10',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'use_dipi_social_icons' => 'on',
                ]),
            ],
            'social_icon_shadow_hover' => [
                'label' => esc_html__('Hover Icon Box Shadow', 'dipi-divi-pixel'),
                'description' => esc_html__('Enable this option to display Icon Box Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'menu_social_icons',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'use_dipi_social_icons' => 'on',
                ]),
            ],
            'social_icon_shadow_color_hover' => [
                'label' => esc_html__('Hover Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'default' => 'rgba(21,2,42,0.15)',
                'section' => 'menu_social_icons',
                'panel' => 'header',
                'active_callback' => $this->show_if_option([
                    'use_dipi_social_icons' => 'on',
                ]),
            ],
            'social_icon_shadow_offset_hover' => [
                'label' => esc_html__('Hover Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_social_icons',
                'panel' => 'header',
                'default' => '5',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'use_dipi_social_icons' => 'on',
                ]),
            ],
            'social_icon_shadow_blur_hover' => [
                'label' => esc_html__('Hover Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'menu_social_icons',
                'panel' => 'header',
                'default' => '15',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'use_dipi_social_icons' => 'on',
                ]),
            ],
        ];
    }

    private function get_footer_fields()
    {
        return [
            'footer_menu_disabled' => [
                'label' => esc_html__('Customize Footer Menu', 'dipi-divi-pixel'),
                'description' => esc_html__('It seems you have selected to do not custom footer. To enable Footer Customization make sure you have this option enabled in Divi Pixel Dashboard under General > Use Footer Customization
                .', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'footer_menu',
                'panel' => 'footer',
                'cta' => true,
                'icon' => 'dp-sidebar',
                'active_callback' => $this->show_if_option([
                    'footer_customization' => 'off'
                ]),
            ],
            'footer_menu_heading' => [
                'label' => esc_html__('Footer Menu Font', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Footer Menu Font.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'icon' => 'dp-font',
                'section' => 'footer_menu',
                'panel' => 'footer',
                'active_callback' => $this->show_if_option([
                    'footer_customization' => 'on'
                ]),
            ],
            'footer_menu_font_select' => [
                'label' => esc_html__('Select Font', 'dipi-divi-pixel'),
                'type' => 'font',
                'default' => 'none',
                'section' => 'footer_menu',
                'panel' => 'footer',
                'active_callback' => $this->show_if_option([
                    'footer_customization' => 'on'
                ]),
            ],

            'footer_menu_font_weight' => [
                'label' => esc_html__('Font Weight', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'footer_menu',
                'panel' => 'footer',
                'default' => 500,
                'input_attrs' => [
                    'min' => 100,
                    'max' => 900,
                    'step' => 100
                ],
                'active_callback' => $this->show_if_option([
                    'footer_customization' => 'on'
                ]),
            ],

            'footer_menu_spacing' => [
                'label' => esc_html__('Spacing Between Menu Items', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'footer_menu',
                'panel' => 'footer',
                'default' => '20',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'footer_customization' => 'on'
                ]),
            ],
            'footer_menu_underline' => [
                'label' => esc_html__('Add Underline on Hover', 'dipi-divi-pixel'),
                'description' => esc_html__('Enable this option to display animated text underline on hover.', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'footer_menu',
                'panel' => 'footer',
                'active_callback' => $this->show_if_option([
                    'footer_customization' => 'on'
                ]),
            ],
            'footer_menu_underline_color' => [
                'label' => esc_html__('Hover Underline Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'footer_menu',
                'panel' => 'footer',
                'active_callback' => $this->show_if_option([
                    'footer_customization' => 'on'
                ]),
            ],
            'footer_menu_hover_text_color' => [
                'label' => esc_html__('Hover Text Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'footer_menu',
                'panel' => 'footer',
                'active_callback' => $this->show_if_option([
                    'footer_customization' => 'on'
                ]),
            ],


            'footer_menu_box_heading' => [
                'label' => esc_html__('Footer Menu Box Style', 'dipi-divi-pixel'),
                'description' => esc_html__('Enable this option to display Footer Menu Box Shadow.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'icon' => 'dp-layers',
                'section' => 'footer_menu',
                'panel' => 'footer',
                'active_callback' => $this->show_if_option([
                    'footer_customization' => 'on'
                ]),
            ],
            'footer_menu_center' => [
                'label' => esc_html__('Center Footer Links', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'footer_menu',
                'panel' => 'footer',
                'active_callback' => $this->show_if_option([
                    'footer_customization' => 'on'
                ]),
            ],
            'footer_menu_shadow' => [
                'label' => esc_html__('Display Footer Menu Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'footer_menu',
                'panel' => 'footer',
                'active_callback' => $this->show_if_option([
                    'footer_customization' => 'on'
                ]),
            ],
            'footer_menu_shadow_color' => [
                'label' => esc_html__('Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'footer_menu',
                'panel' => 'footer',
                'active_callback' => $this->show_if_option([
                    'footer_customization' => 'on'
                ]),
            ],
            'footer_menu_shadow_offset' => [
                'label' => esc_html__('Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'footer_menu',
                'panel' => 'footer',
                'active_callback' => $this->show_if_option([
                    'footer_customization' => 'on'
                ]),
                'input_attrs' => [
                    'min' => -20,
                    'max' => 20,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],
            'footer_menu_shadow_blur' => [
                'label' => esc_html__('Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'footer_menu',
                'panel' => 'footer',
                'active_callback' => $this->show_if_option([
                    'footer_customization' => 'on'
                ]),
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
            ],

            'footer_bottom_bar_disabled' => [
                'label' => esc_html__('Customize Footer Menu', 'dipi-divi-pixel'),
                'description' => esc_html__('It seems you have selected to do not custom footer. To enable Footer Customization make sure you have this option enabled in Divi Pixel Dashboard under General > Use Footer Customization
                .', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'footer_bottom_bar',
                'panel' => 'footer',
                'cta' => true,
                'icon' => 'dp-sidebar',
                'active_callback' => $this->show_if_option([
                    'footer_customization' => 'off'
                ]),
            ],

            'footer_bar_hidden' => [
                'label' => esc_html__('Customize Footer Bottom Bar', 'dipi-divi-pixel'),
                'description' => esc_html__('It seems you have selected option to hide Footer Bottom Bar. To customize it please disable Hide Bottom Bar option in the Divi Pixel dashboard under General > Footer > Hide Footer Bottom Bar', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'footer_bottom_bar',
                'panel' => 'footer',
                'active_callback' => $this->show_if_option([
                    'footer_customization' => 'on'
                ]),
                'icon' => 'dp-footer',
                'active_callback' => $this->show_if_option([
                    'hide_bottom_bar' => 'on',
                ]),
            ],
            'footer_bar_heading' => [
                'label' => esc_html__('Footer Bottom Bar', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Footer Bottom Bar.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'footer_bottom_bar',
                'panel' => 'footer',
                 
                'icon' => 'dp-footer',
                'active_callback' => $this->show_if_option([
                    'hide_bottom_bar' => 'off',
                    'footer_customization' => 'on'
                ]),
            ],
            'footer_bottom_center' => [
                'label' => esc_html__('Center Bottom Bar Elements', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'footer_bottom_bar',
                'panel' => 'footer',
             
                'active_callback' => $this->show_if_option([
                    'hide_bottom_bar' => 'off',
                    'footer_customization' => 'on'
                ]),
            ],
            'footer_bar_font_select' => [
                'label' => esc_html__('Select Font', 'dipi-divi-pixel'),
                'type' => 'font',
                'default' => 'Open Sans',
                'section' => 'footer_bottom_bar',
                'panel' => 'footer',
                
                'active_callback' => $this->show_if_option([
                    'hide_bottom_bar' => 'off',
                    'footer_customization' => 'on'
                ]),
            ],
            'footer_bar_font_weight' => [
                'label' => esc_html__('Font Weight', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'footer_bottom_bar',
                'panel' => 'footer',
                 
                'default' => 500,
                'input_attrs' => [
                    'min' => 100,
                    'max' => 900,
                    'step' => 100
                ],
                'active_callback' => $this->show_if_option([
                    'hide_bottom_bar' => 'off',
                    'footer_customization' => 'on'
                ]),
            ],

            'footer_bar_text_spacing' => [
                'label' => esc_html__('Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'footer_bottom_bar',
                'panel' => 'footer',
                 
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'hide_bottom_bar' => 'off',
                    'footer_customization' => 'on'
                ]),
            ],
            'footer_bar_link_color' => [
                'label' => esc_html__('Bottom Bar Link Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'footer_bottom_bar',
                'panel' => 'footer',
                 
                'active_callback' => $this->show_if_option([
                    'hide_bottom_bar' => 'off',
                    'footer_customization' => 'on'
                ]),
            ],
            'footer_bar_hover_link_color' => [
                'label' => esc_html__('Bottom Bar Link Color on Hover', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'footer_bottom_bar',
                'panel' => 'footer',
                 
                'active_callback' => $this->show_if_option([
                    'hide_bottom_bar' => 'off',
                    'footer_customization' => 'on'
                ]),
            ],
            'footer_bar_padding_top_bottom' => [
                'label' => esc_html__('Top/Bottom Padding', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'footer_bottom_bar',
                'panel' => 'footer',
                 
                'default' => '15',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'hide_bottom_bar' => 'off',
                    'footer_customization' => 'on'
                ]),
            ],


            /**
             * Footer Social Icon Styles
             */
            'footer_social_icon_style_disabled' => [
                'label' => esc_html__('Customize Footer Social Icons', 'dipi-divi-pixel'),
                'description' => esc_html__('To customize Social Media Icons in the Footer, please enable this option in Divi Pixel settings, under Social Media tab.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'cta' => true,
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'icon' => 'dp-social',
                'active_callback' => $this->show_if_option([
                    'footer_customization' => 'on',
                    'social_icons_individual_location' => 'off',
                    'social_icons_footer' => 'off',
                    'use_dipi_social_icons' => 'on',
                ]),
            ],
            'footer_social_icon_style_heading' => [
                'label' => esc_html__('Social Icon Style', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Social Media Icons in the Header.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'icon' => 'dp-social',
                'active_callback' => $this->footer_social_icons_active_callback(),
            ],
            'footer_social_icon_hover_effect' => [
                'label' => esc_html__('Social Icon Hover Effect', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'default' => 'zoom',
                'options' => [
                    'none' => esc_html__('None', 'dipi-divi-pixel'),
                    'zoom' => esc_html__('Zoom', 'dipi-divi-pixel'),
                    'slide_up' => esc_html__('Slide Up', 'dipi-divi-pixel'),
                    'rotate' => esc_html__('Rotate', 'dipi-divi-pixel'),
                    // 'ripple' => esc_html__('Ripple', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->footer_social_icons_active_callback(),
            ],
            'footer_social_icon_color' => [
                'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'default' => '#2c3d49',
                'active_callback' => $this->footer_social_icons_active_callback(),
            ],
            'footer_social_icon_hover_color' => [
                'label' => esc_html__('Hover Icon Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'default' => '#2c3d49',
                'active_callback' => $this->footer_social_icons_active_callback(),
            ],
            'footer_social_icon_size' => [
                'label' => esc_html__('Icon Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'default' => '15',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->footer_social_icons_active_callback(),
            ],
            'footer_social_icon_padding' => [
                'label' => esc_html__('Icon Padding', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'default' => '15',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->footer_social_icons_active_callback(),
            ],
            'footer_social_icon_spacing' => [
                'label' => esc_html__('Bottom Icon Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'default' => '20',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->footer_social_icons_active_callback(),
            ],
            'footer_social_icon_box_heading' => [
                'label' => esc_html__('Icon Box Style', 'dipi-divi-pixel'),
                'description' => esc_html__('Enable this option to customize boxed social media icons.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'icon' => 'dp-color',
                'active_callback' => $this->footer_social_icons_active_callback(),
            ],
            'footer_social_icon_box_style' => [
                'label' => esc_html__('Enable Boxed Style', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'default' => 'on',
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'active_callback' => $this->footer_social_icons_active_callback(),
            ],
            'footer_social_icon_box_radius' => [
                'label' => esc_html__('Box Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'default' => '100',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->footer_social_icons_active_callback(),
            ],
            'footer_social_icon_box_background' => [
                'label' => esc_html__('Icon Box Background', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'default' => '#ffffff',
                'active_callback' => $this->footer_social_icons_active_callback(),
            ],
            'footer_social_icon_box_background_hover' => [
                'label' => esc_html__('Hover Icon Box Background', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'default' => '#ffffff',
                'active_callback' => $this->footer_social_icons_active_callback(),
            ],
            'footer_social_icon_shadow' => [
                'label' => esc_html__('Display Icon Box Shadow', 'dipi-divi-pixel'),
                'description' => esc_html__('Enable this option to display Icon Box Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'active_callback' => $this->footer_social_icons_active_callback(),
            ],
            'footer_social_icon_shadow_color' => [
                'label' => esc_html__('Icon Box Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'active_callback' => $this->footer_social_icons_active_callback(),
            ],
            'footer_social_icon_shadow_offset' => [
                'label' => esc_html__('Icon Box Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'default' => '4',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->footer_social_icons_active_callback(),
            ],
            'footer_social_icon_shadow_blur' => [
                'label' => esc_html__('Icon Box Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'default' => '10',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 80,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->footer_social_icons_active_callback(),
            ],

            'footer_social_icon_shadow_hover' => [
                'label' => esc_html__('Hover Icon Box Shadow', 'dipi-divi-pixel'),
                'description' => esc_html__('Enable this option to display Icon Box Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'active_callback' => $this->footer_social_icons_active_callback(),
            ],

            'footer_social_icon_shadow_color_hover' => [
                'label' => esc_html__('Hover Icon Box Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'active_callback' => $this->footer_social_icons_active_callback(),
            ],

            'footer_social_icon_shadow_offset_hover' => [
                'label' => esc_html__('Hover Icon Box Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'default' => '4',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->footer_social_icons_active_callback(),
            ],

            'footer_social_icon_shadow_blur_hover' => [
                'label' => esc_html__('Hover Icon Box Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'footer_social_icons',
                'panel' => 'footer',
                'default' => '10',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 80,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->footer_social_icons_active_callback(),
            ],
        ];
    }

    private function get_blog_fields()
    {
        return [
            'blog_archives_disabled_info' => [
                'label' => esc_html__('Customize Category & Archive Pages', 'dipi-divi-pixel'),
                'description' => esc_html__('To customize Category and Archive pages appearance, please enable this option in the Divi Pixel dashboard under Blog > Custom Archive Page Style', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'icon' => 'dp-blog',
                'cta' => true,
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'off',
                ]),
            ],
            'blog_archives_page_heading' => [
                'label' => esc_html__('Page Style', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize Category & Archive Page Background', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'icon' => 'dp-blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_page_background_color' => [
                'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => 'rgba(255,255,255)',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],

            'blog_archives_page_background_image' => [
                'label' => esc_html__('Background Image', 'dipi-divi-pixel'),
                'description' => esc_html__('Select a file', 'dipi-divi-pixel'),
                'type' => 'upload',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],

            'blog_archives_page_background_image_size' => [
                'label' => esc_html__('Background Image Size', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => 'cover',
                'options' => [
                    'cover' => esc_html__('Cover ', 'dipi-divi-pixel'),
                    'fit' => esc_html__('Fit', 'dipi-divi-pixel'),
                    'actual' => esc_html__('Actual Size', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],

            'blog_archives_page_background_image_repeat' => [
                'label' => esc_html__('Background Image Repeat', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => 'repeat',
                'options' => [
                    'repeat' => esc_html__('Repeat', 'dipi-divi-pixel'),
                    'repeat-x' => esc_html__('Repeat X', 'dipi-divi-pixel'),
                    'repeat-y' => esc_html__('Repeat Y', 'dipi-divi-pixel'),
                    'no-repeat' => esc_html__('No Repeat', 'dipi-divi-pixel'),
                    'space' => esc_html__('Space', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_title_font' => [
                'label' => esc_html__('Title Font', 'dipi-divi-pixel'),
                //'description' => esc_html__('custom description', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'icon' => 'dp-font',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_title_font_select' => [
                'label' => esc_html__('Select Font', 'dipi-divi-pixel'),
                'type' => 'font',
                'default' => 'none',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_title_font_size' => [
                'label' => esc_html__('Font Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '24',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_title_text_spacing' => [
                'label' => esc_html__('Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_title_line_height' => [
                'label' => esc_html__('Line Height', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '30',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_title_font_weight' => [
                'label' => esc_html__('Font Weight', 'dipi-divi-pixel'),
                'type' => 'font_weight',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '600',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_title_font_style' => [
                'label' => esc_html__('Text Style', 'dipi-divi-pixel'),
                // 'description' => esc_html__('Select a font style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_title_font_color' => [
                'label' => esc_html__('Font Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_title_font_color_hover' => [
                'label' => esc_html__('Font Color on Hover', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_meta_info' => [
                'label' => esc_html__('Meta Text Styles', 'dipi-divi-pixel'),
                //'description' => esc_html__('custom description', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'icon' => 'dp-font',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_meta_font_select' => [
                'label' => esc_html__('Select Font', 'dipi-divi-pixel'),
                'type' => 'font',
                'default' => 'none',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_meta_font_size' => [
                'label' => esc_html__('Font Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '15',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_meta_text_spacing' => [
                'label' => esc_html__('Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_meta_font_weight' => [
                'label' => esc_html__('Font Weight', 'dipi-divi-pixel'),
                'type' => 'font_weight',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_meta_font_style' => [
                'label' => esc_html__('Text Style', 'dipi-divi-pixel'),
                // 'description' => esc_html__('Select a font style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_meta_font_color' => [
                'label' => esc_html__('Font Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_meta_font_color_hover' => [
                'label' => esc_html__('Font Color on Hover', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_meta_icon_color' => [
                'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                    'blog_meta_icons' => 'on',
                ]),
            ],
            'blog_archives_meta_icon_hover_color' => [
                'label' => esc_html__('Hover Icon Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                    'blog_meta_icons' => 'on',
                ]),
            ],
            'blog_archives_meta_icon_size' => [
                'label' => esc_html__('Icon Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '15',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                    'blog_meta_icons' => 'on',
                ]),
            ],
            'blog_archives_excerpt_info' => [
                'label' => esc_html__('Excerpt Text Styles', 'dipi-divi-pixel'),
                //'description' => esc_html__('custom description', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'icon' => 'dp-font',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                    'hide_excerpt_text' => 'off',
                ], "AND"),
            ],
            'blog_archives_excerpt_font_select' => [
                'label' => esc_html__('Select Font', 'dipi-divi-pixel'),
                'type' => 'font',
                'default' => 'none',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                    'hide_excerpt_text' => 'off',
                ], "AND"),
            ],
            'blog_archives_excerpt_font_weight' => [
                'label' => esc_html__('Font Weight', 'dipi-divi-pixel'),
                'type' => 'font_weight',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                    'hide_excerpt_text' => 'off',
                ], "AND"),
            ],
            'blog_archives_excerpt_font_style' => [
                'label' => esc_html__('Text Style', 'dipi-divi-pixel'),
                // 'description' => esc_html__('Select a font style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                    'hide_excerpt_text' => 'off',
                ], "AND"),
            ],
            'blog_archives_excerpt_font_size' => [
                'label' => esc_html__('Font Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '15',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                    'hide_excerpt_text' => 'off',
                ], "AND"),
            ],
            'blog_archives_excerpt_text_spacing' => [
                'label' => esc_html__('Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                    'hide_excerpt_text' => 'off',
                ], "AND"),
            ],
            'blog_archives_excerpt_line_height' => [
                'label' => esc_html__('Line Height', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '21',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                    'hide_excerpt_text' => 'off',
                ], "AND"),
            ],
            'blog_archives_excerpt_font_color' => [
                'label' => esc_html__('Font Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                    'hide_excerpt_text' => 'off',
                ], "AND"),
            ],
            'blog_archives_box_info' => [
                'label' => esc_html__('Post Box Style', 'dipi-divi-pixel'),
                //'description' => esc_html__('custom description', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'icon' => 'dp-blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_image_height' => [
                'label' => esc_html__('Featured Image Height', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '400',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 2000,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_image_radii' => [
                'label' => esc_html__('Featured Image Border Radius', 'dipi-divi-pixel'),
                'type' => 'border_radii',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '0|0|0|0',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_content_alignment' => [
                'label' => esc_html__('Content Alignment', 'dipi-divi-pixel'),
                //'description' => esc_html__('Select Button Alignement', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => 'left',
                'options' => [
                    'left' => esc_html__('Left (Default)', 'dipi-divi-pixel'),
                    'center' => esc_html__('Center', 'dipi-divi-pixel'),
                    'right' => esc_html__('Right', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_hover_animation' => [
                'label' => esc_html__('Post Box Hover Animation', 'dipi-divi-pixel'),
                'description' => esc_html__('Select hover animation for the single post box.', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => 'zoomin',
                'options' => [
                    'none' => esc_html__('None', 'dipi-divi-pixel'),
                    'zoomin' => esc_html__('Zoom In Image', 'dipi-divi-pixel'),
                    'zoomout' => esc_html__('Zoom Out Image', 'dipi-divi-pixel'),
                    'zoomrotate' => esc_html__('Zoom & Rotate', 'dipi-divi-pixel'),
                    'blacktocolor' => esc_html__('Black To Color', 'dipi-divi-pixel'),
                    'zoombox' => esc_html__('Zoom Post Box', 'dipi-divi-pixel'),
                    'slideupbox' => esc_html__('Move Up Post Box', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'archive_box_overlay' => [
                'label' => esc_html__('Display Image Overlay', 'dipi-divi-pixel'),
                //'description' => esc_html__('Select Button Alignement', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => 'on',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_box_overlay_color' => [
                'label' => esc_html__('Overlay Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_box_overlay_color_hover' => [
                'label' => esc_html__('Hover Overlay Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => 'rgba(0,0,0,0.4)',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'archive_box_icon' => [
                'label' => esc_html__('Display Icon', 'dipi-divi-pixel'),
                //'description' => esc_html__('Select Button Alignement', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => 'onhover',
                'options' => [
                    'none' => esc_html__('None', 'dipi-divi-pixel'),
                    'always' => esc_html__('Always', 'dipi-divi-pixel'),
                    'onhover' => esc_html__('On Hover', 'dipi-divi-pixel'),
                    'hideonhover' => esc_html__('Hide on Hover', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'archive_box_select_icon' => [
                'label' => esc_html__('Select Icon', 'dipi-divi-pixel'),
                'type' => 'divi_icon',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => 'b',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'archive_box_icon_color' => [
                'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'default' => '#fff',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'archives_box_icon_size' => [
                'label' => esc_html__('Icon Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '30',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_box_color' => [
                'label' => esc_html__('Post Box Background', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_box_color_hover' => [
                'label' => esc_html__('Hover Post Box Background', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_box_padding' => [
                'label' => esc_html__('Post Box Padding', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 80,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_box_content_padding' => [
                'label' => esc_html__('Post Box Content Padding', 'dipi-divi-pixel'),
                'type' => 'padding',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '30|50',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_box_radius' => [
                'label' => esc_html__('Post Box Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '5',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'blog_archives_box_border' => [
                'label' => esc_html__('Post Box Border Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'archive_box_border_color' => [
                'label' => esc_html__('Post Box Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'archive_box_border_color_hover' => [
                'label' => esc_html__('Hover Post Box Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'archive_box_shadow_heading' => [
                'label' => esc_html__('Post Box Shadow', 'dipi-divi-pixel'),
                //'description' => esc_html__('custom description', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'archive_box_shadow' => [
                'label' => esc_html__('Add Post Box Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => 'on',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'archive_box_shadow_color' => [
                'label' => esc_html__('Post Box Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => 'rgba(44,61,73,0.05)',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'archive_box_shadow_offset' => [
                'label' => esc_html__('Post Box Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '10',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'archive_box_shadow_blur' => [
                'label' => esc_html__('Post Box Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '30',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'archive_box_shadow_color_hover' => [
                'label' => esc_html__('Hover Post Box Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => 'rgba(44,61,73,0.15)',
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'archive_box_shadow_offset_hover' => [
                'label' => esc_html__('Hover Post Box Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '20',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],
            'archive_box_shadow_blur_hover' => [
                'label' => esc_html__('Hover Post Box Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives',
                'panel' => 'blog',
                'default' => '60',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'custom_archive_page' => 'on',
                ]),
            ],

            'blog_archives_btn_disabled' => [
                'label' => esc_html__('Customize Read More Button', 'dipi-divi-pixel'),
                'description' => esc_html__('To add and customize Read More Button on Archive and Category Pages please enable this option in Divi Pixel Dashboard under Blog > Add Read More Button', 'dipi-divi-pixel'),
                'type' => 'heading',
                'cta' => true,
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'icon' => 'dp-click',
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'off',
                ]),
            ],
            'blog_archives_btn_info' => [
                'label' => esc_html__('Button Icon', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'icon' => 'dp-click',
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                    'read_more_button_style' => ['text_icon', 'only_icon',]
                ]),
            ],
            'archive_btn_enable_icon' => [
                'label' => esc_html__('Display Button Icon', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'default' => 'onhover',
                'options' => [
                    'always' => esc_html__('Always', 'dipi-divi-pixel'),
                    'onhover' => esc_html__('On Hover', 'dipi-divi-pixel'),
                    'hideonhover' => esc_html__('Hide on Hover', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                    'read_more_button_style' => ['text_icon',]
                ]),
            ],
            'archive_btn_icon' => [
                'label' => esc_html__('Button Icon', 'dipi-divi-pixel'),
                'type' => 'divi_icon',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'default' => '$',
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                    'read_more_button_style' => ['text_icon', 'only_icon',]
                ]),
            ],
            'archive_btn_icon_size' => [
                'label' => esc_html__('Icon Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'default' => '16',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                    'read_more_button_style' => ['text_icon', 'only_icon',]
                ]),
            ],




            'blog_archives_btn_font_info' => [
                'label' => esc_html__('Button Text Style', 'dipi-divi-pixel'),
                //'description' => esc_html__('custom description', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'icon' => 'dp-font',
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                    'read_more_button_style' => ['text_icon', 'only_text',]
                ]),
            ],
            'blog_archives_btn_font_select' => [
                'label' => esc_html__('Select Font', 'dipi-divi-pixel'),
                'type' => 'font',
                'default' => 'none',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                    'read_more_button_style' => ['text_icon', 'only_text',]
                ]),
            ],
            'blog_archives_btn_font_size' => [
                'label' => esc_html__('Font Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'default' => '15',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                    'read_more_button_style' => ['text_icon', 'only_text',]
                ]),
            ],
            'blog_archives_btn_font_weight' => [
                'label' => esc_html__('Font Weight', 'dipi-divi-pixel'),
                'type' => 'font_weight',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                    'read_more_button_style' => ['text_icon', 'only_text',]
                ]),
            ],
            'blog_archives_btn_text_spacing' => [
                'label' => esc_html__('Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                    'read_more_button_style' => ['text_icon', 'only_text',]
                ]),
            ],
            'blog_archives_btn_font_style' => [
                'label' => esc_html__('Text Style', 'dipi-divi-pixel'),
                // 'description' => esc_html__('Select a font style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                    'read_more_button_style' => ['text_icon', 'only_text',]
                ]),
            ],
            'blog_archives_btn_font_color' => [
                'label' => esc_html__('Text/Icon Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'default' => '#ffffff',
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                    'read_more_button_style' => ['text_icon', 'only_text', 'only_icon']
                ]),
            ],
            'blog_archives_btn_font_color_hover' => [
                'label' => esc_html__('Hover Text/Icon Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                    'read_more_button_style' => ['text_icon', 'only_text', 'only_icon']
                ]),
            ],

            'archive_btn_spacing' => [
                'label' => esc_html__('Button Style', 'dipi-divi-pixel'),
                'description' => esc_html__('Edit Button Size, Spacing and Style.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'icon' => 'dp-controls',
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                ]),
            ],
            'archive_btn_alignment' => [
                'label' => esc_html__('Button Alignment', 'dipi-divi-pixel'),
                //'description' => esc_html__('Select Button Alignement', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('Left (Default)', 'dipi-divi-pixel'),
                    'center' => esc_html__('Center', 'dipi-divi-pixel'),
                    'right' => esc_html__('Right', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                ]),
            ],
            'archive_btn_hover_effect' => [
                'label' => esc_html__('Button Hover Effect', 'dipi-divi-pixel'),
                //'description' => esc_html__('Select Button Alignement', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'dipi-divi-pixel'),
                    'zoomin' => esc_html__('Zoom In', 'dipi-divi-pixel'),
                    'zoomout' => esc_html__('Zoom Out', 'dipi-divi-pixel'),
                    'moveup' => esc_html__('Move Up', 'dipi-divi-pixel'),
                    // 'ripple' => esc_html__('Ripple', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                ]),
            ],

            'archive_btn_padding' => [
                'label' => esc_html__('Button Padding', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'default' => '20',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                ]),
            ],
            'archive_btn_margin' => [
                'label' => esc_html__('Top/Bottom Margin', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'default' => '15',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                ]),
            ],
            'archive_btn_border_radius' => [
                'label' => esc_html__('Button Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'default' => '100',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                ]),
            ],
            'archive_btn_border_width' => [
                'label' => esc_html__('Button Border Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                ]),
            ],
            'archive_btn_border_color' => [
                'label' => esc_html__('Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                ]),
            ],
            'archive_btn_border_color_hover' => [
                'label' => esc_html__('Hover Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                ]),
            ],
            'archive_btn_background' => [
                'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'default' => '#2c3d49',
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                ]),
            ],
            'archive_btn_background_hover' => [
                'label' => esc_html__('Hover Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                ]),
            ],








            'archive_btn_shadow_heading' => [
                'label' => esc_html__('Add Button Shadow', 'dipi-divi-pixel'),
                'description' => esc_html__('Add Shadow to Back To Top Button', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                ]),
            ],
            'archive_btn_shadow' => [
                'label' => esc_html__('Add Button Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                ]),
            ],
            'archive_btn_shadow' => [
                'label' => esc_html__('Display Button Shadow', 'dipi-divi-pixel'),
                //'description' => esc_html__('Select Button Alignement', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                ]),
            ],
            'archive_btn_shadow_color' => [
                'label' => esc_html__('Button Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                ]),
            ],
            'archive_btn_shadow_offset' => [
                'label' => esc_html__('Button Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                ]),
            ],
            'archive_btn_shadow_blur' => [
                'label' => esc_html__('Button Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                ]),
            ],
            'archive_btn_shadow_color_hover' => [
                'label' => esc_html__('Hover Button Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                ]),
            ],
            'archive_btn_shadow_offset_hover' => [
                'label' => esc_html__('Hover Button Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                ]),
            ],
            'archive_btn_shadow_blur_hover' => [
                'label' => esc_html__('Hover Button Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_archives_btn',
                'panel' => 'blog',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'add_read_more_archive' => 'on',
                ]),
            ],

            'archive_sidebar_disabled' => [
                'label' => esc_html__('Customize Sidebar', 'dipi-divi-pixel'),
                'description' => esc_html__('It seems you have selected to do not display sidebar on your archive pages or Sidebar Customization is disabled. To enable Sidebar Customization make sure you have this option enabled in Divi Pixel Dashboard under Blog > Sidebar Customization.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'cta' => true,
                'icon' => 'dp-sidebar',
                'active_callback' => $this->show_if_option([
                    'sidebar_customization' => 'off'
                ]),
            ],
            'archive_sidebar_font_info' => [
                'label' => esc_html__('Sidebar Font', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize sidebar title font.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'icon' => 'dp-font',
                'active_callback' => $this->show_if_option([
                    
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_font_select' => [
                'label' => esc_html__('Select Title Font', 'dipi-divi-pixel'),
                'type' => 'font',
                'default' => 'none',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                   
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_font_weight' => [
                'label' => esc_html__('Title Font Weight', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'default' => 'regular',
                'options' => [
                    'light' => esc_html__('Light', 'dipi-divi-pixel'),
                    'regular' => esc_html__('Regular', 'dipi-divi-pixel'),
                    'bold' => esc_html__('Bold', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                     
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_font_style' => [
                'label' => esc_html__('Text Style', 'dipi-divi-pixel'),
                // 'description' => esc_html__('Select a font style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_font_size' => [
                'label' => esc_html__('Title Font Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'default' => '15',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_text_spacing' => [
                'label' => esc_html__('Title Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_font_color' => [
                'label' => esc_html__('Title Font Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                     
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_title_background_color' => [
                'label' => esc_html__('Title Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                     
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_widget_title_padding' => [
                'label' => esc_html__('Widget Title Padding', 'dipi-divi-pixel'),
                'type' => 'padding',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'default' => '20|20',
                'active_callback' => $this->show_if_option([
                     
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_widget_title_spacing' => [
                'label' => esc_html__('Widget Title Bottom Margin', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'default' => '20',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                     
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_background_color' => [
                'label' => esc_html__('Widget Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    
                    'sidebar_customization' => 'on'
                ]),
            ],




            'archive_sidebar_style_info' => [
                'label' => esc_html__('Sidebar Widget Style', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize sidebar widget style.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'icon' => 'dp-sidebar',
                'active_callback' => $this->show_if_option([
                   
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_widget_spacing' => [
                'label' => esc_html__('Widget Bottom Margin', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'default' => '20',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_widget_padding' => [
                'label' => esc_html__('Widget Box Padding', 'dipi-divi-pixel'),
                'type' => 'padding',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'default' => '20|20',
                'active_callback' => $this->show_if_option([
                     
                    'sidebar_customization' => 'on'
                ]),
            ],
           
            'archive_sidebar_widget_shadow' => [
                'label' => esc_html__('Add Widget Box Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                     
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_widget_shadow_color' => [
                'label' => esc_html__('Widget Box Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_widget_shadow_offset' => [
                'label' => esc_html__('Widget Box Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_widget_shadow_blur' => [
                'label' => esc_html__('Widget Box Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    
                    'sidebar_customization' => 'on'
                ]),
            ],




            'archive_sidebar_search_info' => [
                'label' => esc_html__('Search Widget Style', 'dipi-divi-pixel'),
                'description' => esc_html__('Customize search widget style.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'icon' => 'dp-search',
                'active_callback' => $this->show_if_option([
                   
                    'sidebar_customization' => 'on'
                ]),
            ],
            
            'archive_sidebar_search_fullwidth' => [
                'label' => esc_html__('Enable Full Width Search Field', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                   
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_search_background' => [
                'label' => esc_html__('Search Field Background', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_search_color' => [
                'label' => esc_html__('Text Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                     
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_search_padding' => [
                'label' => esc_html__('Search Widget Input Padding', 'dipi-divi-pixel'),
                'type' => 'padding',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'default' => '20|20',
                'active_callback' => $this->show_if_option([
                    
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_search_btn_padding' => [
                'label' => esc_html__('Search Widget Button Padding', 'dipi-divi-pixel'),
                'type' => 'padding',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'default' => '10|10',
                'active_callback' => $this->show_if_option([
                    
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_search_btn_width' => [
                'label' => esc_html__('Search Widget Button Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'default' => '80',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                     
                    'sidebar_customization' => 'on'
                ]),
            ],
            
            'archive_sidebar_search_radius' => [
                'label' => esc_html__('Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'default' => '100',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                   
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_search_border_width' => [
                'label' => esc_html__('Border Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'default' => '1',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                     
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_search_border_color' => [
                'label' => esc_html__('Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_search_button_background' => [
                'label' => esc_html__('Button Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                     
                    'sidebar_customization' => 'on'
                ]),
            ],
            'archive_sidebar_search_button_color' => [
                'label' => esc_html__('Button Text Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_sidebar',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                     
                    'sidebar_customization' => 'on'
                ]),
            ],

            'blog_author_box_disabled' => [
                'label' => esc_html__('Customize Author Box', 'dipi-divi-pixel'),
                'description' => esc_html__('To customize author box you must first enable that in Divi Pixel settings under Blog > Add Author Box.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'cta' => true,
                'icon' => 'dp-author',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'off',
                ]),
            ],
            'blog_author_box_title_info' => [
                'label' => esc_html__('Name Font', 'dipi-divi-pixel'),
                //'description' => esc_html__('custom description', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'icon' => 'dp-font',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_name_font_select' => [
                'label' => esc_html__('Select Name Font', 'dipi-divi-pixel'),
                'type' => 'font',
                'default' => 'none',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_name_font_weight' => [
                'label' => esc_html__('Name Font Weight', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => '700',
                'input_attrs' => [
                    'min' => 100,
                    'max' => 900,
                    'step' => 100
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_name_font_style' => [
                'label' => esc_html__('Name Text Style', 'dipi-divi-pixel'),
                // 'description' => esc_html__('Select a font style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_name_font_size' => [
                'label' => esc_html__('Name Font Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => '20',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_name_text_spacing' => [
                'label' => esc_html__('Name Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_name_font_color' => [
                'label' => esc_html__('Name Font Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],

            'blog_author_box_desc_info' => [
                'label' => esc_html__('Description Font', 'dipi-divi-pixel'),
                //'description' => esc_html__('custom description', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'icon' => 'dp-font',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_desc_font_select' => [
                'label' => esc_html__('Description Font', 'dipi-divi-pixel'),
                'type' => 'font',
                'default' => 'none',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_desc_font_weight' => [
                'label' => esc_html__('Description Font Weight', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => '500',
                'input_attrs' => [
                    'min' => 100,
                    'max' => 900,
                    'step' => 100
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_desc_font_style' => [
                'label' => esc_html__('Description Text Style', 'dipi-divi-pixel'),
                // 'description' => esc_html__('Select a font style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_desc_font_size' => [
                'label' => esc_html__('Description Font Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => '14',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_desc_text_spacing' => [
                'label' => esc_html__('Description Text Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_desc_font_color' => [
                'label' => esc_html__('Description Font Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],

            'blog_author_image_info' => [
                'label' => esc_html__('Author Image Style', 'dipi-divi-pixel'),
                //'description' => esc_html__('custom description', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'icon' => 'dp-author',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_image_size' => [
                'label' => esc_html__('Author Image Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => '80',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_image_border_radius' => [
                'label' => esc_html__('Author Image Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => '100',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_image_border_width' => [
                'label' => esc_html__('Author Image Border Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_image_border_color' => [
                'label' => esc_html__('Author Image Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_image_shadow' => [
                'label' => esc_html__('Add Author Image Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_image_shadow_color' => [
                'label' => esc_html__('Author Image Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_image_shadow_offset' => [
                'label' => esc_html__('Author Image Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_image_shadow_blur' => [
                'label' => esc_html__('Author Image Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],




            'blog_author_box_style_info' => [
                'label' => esc_html__('Author Box Style', 'dipi-divi-pixel'),
                //'description' => esc_html__('custom description', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'icon' => 'dp-controls',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],

            'blog_author_box_content_alignment' => [
                'label' => esc_html__('Author Box Content Alignment', 'dipi-divi-pixel'),
                //'description' => esc_html__('Select Button Alignement', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('Left (Default)', 'dipi-divi-pixel'),
                    'center' => esc_html__('Center', 'dipi-divi-pixel'),
                    'right' => esc_html__('Right', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],


            'blog_author_background_color' => [
                'label' => esc_html__('Author Box Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],

            'blog_author_background_image' => [
                'label' => esc_html__('Author Box Background Image', 'dipi-divi-pixel'),
                'description' => esc_html__('Select a file', 'dipi-divi-pixel'),
                'type' => 'upload',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],

            'blog_author_background_image_size' => [
                'label' => esc_html__('Author Box Background Image Size', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => 'cover',
                'options' => [
                    'cover' => esc_html__('Cover ', 'dipi-divi-pixel'),
                    'fit' => esc_html__('Fit', 'dipi-divi-pixel'),
                    'actual' => esc_html__('Actual Size', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_background_image_position' => [
                'label' => esc_html__('Author Box Background Image Position', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => 'center_center',
                'options' => [
                    'top_left' => esc_html__('Top Left', 'dipi-divi-pixel'),
                    'top_center' => esc_html__('Top Center', 'dipi-divi-pixel'),
                    'top_right' => esc_html__('Top Right', 'dipi-divi-pixel'),
                    'center_left' => esc_html__('Center Left', 'dipi-divi-pixel'),
                    'center_center' => esc_html__('Center', 'dipi-divi-pixel'),
                    'center_right' => esc_html__('Center Right', 'dipi-divi-pixel'),
                    'bottom_left' => esc_html__('Bottom Left', 'dipi-divi-pixel'),
                    'bottom_center' => esc_html__('Bottom Center', 'dipi-divi-pixel'),
                    'bottom_right' => esc_html__('Bottom Right', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_background_image_repeat' => [
                'label' => esc_html__('Author Box Background Image Repeat', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => 'repeat',
                'options' => [
                    'repeat' => esc_html__('Repeat', 'dipi-divi-pixel'),
                    'repeat-x' => esc_html__('Repeat X', 'dipi-divi-pixel'),
                    'repeat-y' => esc_html__('Repeat Y', 'dipi-divi-pixel'),
                    'no-repeat' => esc_html__('No Repeat', 'dipi-divi-pixel'),
                    'space' => esc_html__('Space', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],

            'blog_author_box_padding' => [
                'label' => esc_html__('Author Box Padding', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => '40',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_box_border_radius' => [
                'label' => esc_html__('Author Box Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => '10',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_box_border' => [
                'label' => esc_html__('Author Box Border Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_box_border_color' => [
                'label' => esc_html__('Author Box Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],


            'blog_author_section_background_heading' => [
                'label' => esc_html__('Section Background', 'dipi-divi-pixel'),
                'description' => esc_html__('Background of Navigation Section', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'icon' => 'dp-color',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_section_background_color' => [
                'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => 'rgba(255,255,255,0)',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],

            'blog_author_section_background_image' => [
                'label' => esc_html__('Background Image', 'dipi-divi-pixel'),
                'description' => esc_html__('Select a file', 'dipi-divi-pixel'),
                'type' => 'upload',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],

            'blog_author_section_background_image_size' => [
                'label' => esc_html__('Background Image Size', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => 'cover',
                'options' => [
                    'cover' => esc_html__('Cover ', 'dipi-divi-pixel'),
                    'fit' => esc_html__('Fit', 'dipi-divi-pixel'),
                    'actual' => esc_html__('Actual Size', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_section_background_image_position' => [
                'label' => esc_html__('Background Image Position', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => 'center_center',
                'options' => [
                    'top_left' => esc_html__('Top Left', 'dipi-divi-pixel'),
                    'top_center' => esc_html__('Top Center', 'dipi-divi-pixel'),
                    'top_right' => esc_html__('Top Right', 'dipi-divi-pixel'),
                    'center_left' => esc_html__('Center Left', 'dipi-divi-pixel'),
                    'center_center' => esc_html__('Center', 'dipi-divi-pixel'),
                    'center_right' => esc_html__('Center Right', 'dipi-divi-pixel'),
                    'bottom_left' => esc_html__('Bottom Left', 'dipi-divi-pixel'),
                    'bottom_center' => esc_html__('Bottom Center', 'dipi-divi-pixel'),
                    'bottom_right' => esc_html__('Bottom Right', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_section_background_image_repeat' => [
                'label' => esc_html__('Background Image Repeat', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => 'repeat',
                'options' => [
                    'repeat' => esc_html__('Repeat', 'dipi-divi-pixel'),
                    'repeat-x' => esc_html__('Repeat X', 'dipi-divi-pixel'),
                    'repeat-y' => esc_html__('Repeat Y', 'dipi-divi-pixel'),
                    'no-repeat' => esc_html__('No Repeat', 'dipi-divi-pixel'),
                    'space' => esc_html__('Space', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],

            'blog_author_shadow_heading' => [
                'label' => esc_html__('Box Shadow', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_box_shadow' => [
                'label' => esc_html__('Add Author Box Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_box_shadow_color' => [
                'label' => esc_html__('Author Box Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_box_shadow_offset' => [
                'label' => esc_html__('Author Box Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'default' => '25',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],
            'blog_author_box_shadow_blur' => [
                'label' => esc_html__('Author Box Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_author_box',
                'panel' => 'blog',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'author_box' => 'on',
                ]),
            ],



            'blog_navigation_disabled' => [
                'label' => esc_html__('Customize Post Navigation', 'dipi-divi-pixel'),
                'description' => esc_html__('To add and customize Next/Prev post navigation you must first enable that option in Divi Pixel settings under Blog > Add Blog Navigation.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'cta' => true,
                'icon' => 'dp-nav',
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'off',
                ]),
            ],
            'blog_navigation_info' => [
                'label' => esc_html__('Navigation Font', 'dipi-divi-pixel'),
                //'description' => esc_html__('custom description', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'icon' => 'dp-font',
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_btn_select' => [
                'label' => esc_html__('Button Font', 'dipi-divi-pixel'),
                'type' => 'font',
                'default' => 'none',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_btn_size' => [
                'label' => esc_html__('Button Font Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'default' => '15',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_btn_weight' => [
                'label' => esc_html__('Button Font Weight', 'dipi-divi-pixel'),
                'type' => 'font_weight',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_btn_style' => [
                'label' => esc_html__('Button Text Style', 'dipi-divi-pixel'),
                // 'description' => esc_html__('Select a font style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],

            'blog_nav_btn_spacing' => [
                'label' => esc_html__('Button Text Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_btn_icon_size' => [
                'label' => esc_html__('Button Icon Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'default' => '20',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_btn_color' => [
                'label' => esc_html__('Button Text/Icon Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'default' => '#2c3d49',
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_btn_color_hover' => [
                'label' => esc_html__('Hover Button Text/Icon Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'default' => '#ffffff',
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],



            'blog_navigation_style_info' => [
                'label' => esc_html__('Navigation Button Style', 'dipi-divi-pixel'),
                //'description' => esc_html__('custom description', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'icon' => 'dp-click',
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_box_padding' => [
                'label' => esc_html__('Button Padding', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'default' => '10',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_border_radius' => [
                'label' => esc_html__('Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'default' => '50',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_border' => [
                'label' => esc_html__('Border Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_border_color' => [
                'label' => esc_html__('Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_border_color_hover' => [
                'label' => esc_html__('Border Color Hover', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_background_color' => [
                'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'default' => '#f5f5f5',
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_background_color_hover' => [
                'label' => esc_html__('Background Color Hover', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'default' => '#2c3d49',
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],

            
            'blog_nav_section_background_heading' => [
                'label' => esc_html__('Section Background', 'dipi-divi-pixel'),
                'description' => esc_html__('Background of Navigation Section', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'icon' => 'dp-color',
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_section_background_color' => [
                'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'default' => 'rgba(255,255,255,0)',
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],

            'blog_nav_section_background_image' => [
                'label' => esc_html__('Background Image', 'dipi-divi-pixel'),
                'description' => esc_html__('Select a file', 'dipi-divi-pixel'),
                'type' => 'upload',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],

            'blog_nav_section_background_image_size' => [
                'label' => esc_html__('Background Image Size', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'default' => 'cover',
                'options' => [
                    'cover' => esc_html__('Cover ', 'dipi-divi-pixel'),
                    'fit' => esc_html__('Fit', 'dipi-divi-pixel'),
                    'actual' => esc_html__('Actual Size', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],

            'blog_nav_section_background_image_repeat' => [
                'label' => esc_html__('Background Image Repeat', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'default' => 'repeat',
                'options' => [
                    'repeat' => esc_html__('Repeat', 'dipi-divi-pixel'),
                    'repeat-x' => esc_html__('Repeat X', 'dipi-divi-pixel'),
                    'repeat-y' => esc_html__('Repeat Y', 'dipi-divi-pixel'),
                    'no-repeat' => esc_html__('No Repeat', 'dipi-divi-pixel'),
                    'space' => esc_html__('Space', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],

            'blog_navigation_shadow_heading' => [
                'label' => esc_html__('Button Shadow', 'dipi-divi-pixel'),
                //'description' => esc_html__('custom description', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_shadow' => [
                'label' => esc_html__('Add Button Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_shadow_color' => [
                'label' => esc_html__('Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_shadow_offset' => [
                'label' => esc_html__('Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_shadow_blur' => [
                'label' => esc_html__('Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],

            'blog_nav_shadow_color_hover' => [
                'label' => esc_html__('Hover Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_shadow_offset_hover' => [
                'label' => esc_html__('Hover Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],
            'blog_nav_shadow_blur_hover' => [
                'label' => esc_html__('Hover Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_navigation',
                'panel' => 'blog',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'blog_nav' => 'on',
                ]),
            ],

            'blog_related_disabled' => [
                'label' => esc_html__('Customize Related Articles', 'dipi-divi-pixel'),
                'description' => esc_html__('To customize Related Articles section please enable this option in Divi Pixel dashboard under Blog > Related Articles', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'cta' => true,
                'icon' => 'dp-related',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'off',
                ]),
            ],


            'blog_related_section_background_heading' => [
                'label' => esc_html__('Section Background', 'dipi-divi-pixel'),
                'description' => esc_html__('Background of Related Artices', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'icon' => 'dp-color',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_section_background_color' => [
                'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => 'rgba(255,255,255,0)',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],

            'blog_related_section_background_image' => [
                'label' => esc_html__('Background Image', 'dipi-divi-pixel'),
                'description' => esc_html__('Select a file', 'dipi-divi-pixel'),
                'type' => 'upload',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],

            'blog_related_section_background_image_size' => [
                'label' => esc_html__('Background Image Size', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => 'cover',
                'options' => [
                    'cover' => esc_html__('Cover ', 'dipi-divi-pixel'),
                    'fit' => esc_html__('Fit', 'dipi-divi-pixel'),
                    'actual' => esc_html__('Actual Size', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_section_background_image_position' => [
                'label' => esc_html__('Background Image Position', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => 'center_center',
                'options' => [
                    'top_left' => esc_html__('Top Left', 'dipi-divi-pixel'),
                    'top_center' => esc_html__('Top Center', 'dipi-divi-pixel'),
                    'top_right' => esc_html__('Top Right', 'dipi-divi-pixel'),
                    'center_left' => esc_html__('Center Left', 'dipi-divi-pixel'),
                    'center_center' => esc_html__('Center', 'dipi-divi-pixel'),
                    'center_right' => esc_html__('Center Right', 'dipi-divi-pixel'),
                    'bottom_left' => esc_html__('Bottom Left', 'dipi-divi-pixel'),
                    'bottom_center' => esc_html__('Bottom Center', 'dipi-divi-pixel'),
                    'bottom_right' => esc_html__('Bottom Right', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_section_background_image_repeat' => [
                'label' => esc_html__('Background Image Repeat', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => 'repeat',
                'options' => [
                    'repeat' => esc_html__('Repeat', 'dipi-divi-pixel'),
                    'repeat-x' => esc_html__('Repeat X', 'dipi-divi-pixel'),
                    'repeat-y' => esc_html__('Repeat Y', 'dipi-divi-pixel'),
                    'no-repeat' => esc_html__('No Repeat', 'dipi-divi-pixel'),
                    'space' => esc_html__('Space', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_section_font_heading' => [
                'label' => esc_html__('Section Title', 'dipi-divi-pixel'),
                //'description' => esc_html__('custom description', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'icon' => 'dp-font',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_section_font_select' => [
                'label' => esc_html__('Title Font', 'dipi-divi-pixel'),
                'type' => 'font',
                'default' => 'none',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_section_font_weight' => [
                'label' => esc_html__('Title Font Weight', 'dipi-divi-pixel'),
                'type' => 'font_weight',
                'section' => 'blog_related_posts',
                'default' => '600',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_section_font_style' => [
                'label' => esc_html__('Section Title Text Style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_section_font_size' => [
                'label' => esc_html__('Section Title Font Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => '22',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_section_text_spacing' => [
                'label' => esc_html__('Section Title Text Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_section_font_color' => [
                'label' => esc_html__('Section Title Font Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => '#2c3d49',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],

            'blog_related_font_heading' => [
                'label' => esc_html__('Post Title Style', 'dipi-divi-pixel'),
                //'description' => esc_html__('custom description', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'icon' => 'dp-font',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_font_select' => [
                'label' => esc_html__('Post Title Font', 'dipi-divi-pixel'),
                'type' => 'font',
                'default' => 'none',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_font_weight' => [
                'label' => esc_html__('Post Title Font Weight', 'dipi-divi-pixel'),
                'type' => 'font_weight',
                'section' => 'blog_related_posts',
                'default' => '700',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_font_style' => [
                'label' => esc_html__('Post Title Text Style', 'dipi-divi-pixel'),
                // 'description' => esc_html__('Select a font style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_font_size' => [
                'label' => esc_html__('Post Title Font Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => '18',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_font_line_height' => [
                'label' => esc_html__('Post Title Line Height', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => '20',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_text_spacing' => [
                'label' => esc_html__('Post Title Text Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_font_color' => [
                'label' => esc_html__('Post Title Font Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],

            'blog_related_font_color_hover' => [
                'label' => esc_html__('Hover Post Title Font Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],



            'blog_related_icon_heading' => [
                'label' => esc_html__('Post Icon Style', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'icon' => 'dp-click',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_icon_effect' => [
                'label' => esc_html__('Display Icon', 'dipi-divi-pixel'),
                //'description' => esc_html__('Select Button Alignement', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => 'onhover',
                'options' => [
                    'always' => esc_html__('Always', 'dipi-divi-pixel'),
                    'never' => esc_html__('Never', 'dipi-divi-pixel'),
                    'onhover' => esc_html__('On Hover', 'dipi-divi-pixel'),
                    'hideonhover' => esc_html__('Hide On Hover', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_icon_select' => [
                'label' => esc_html__('Select Icon', 'dipi-divi-pixel'),
                'description' => esc_html__('Pick a Divi Icon to be displayed on single blog post.', 'dipi-divi-pixel'),
                'type' => 'divi_icon',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => '$',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_icon_size' => [
                'label' => esc_html__('Icon Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => false,
                'default' => '20',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_icon_color' => [
                'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_icon_color_hover' => [
                'label' => esc_html__('Hover Icon Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],





            'blog_related_box_heading' => [
                'label' => esc_html__('Post Box Style', 'dipi-divi-pixel'),
                //'description' => esc_html__('custom description', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'icon' => 'dp-color',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_title_position' => [
                'label' => esc_html__('Display Title Below Image', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_box_column' => [
                'label' => esc_html__('Display Column', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => '3',
                'options' => [
                    '2' => esc_html__('Column 2', 'dipi-divi-pixel'),
                    '3' => esc_html__('Column 3', 'dipi-divi-pixel'),
                    '4' => esc_html__('Column 4', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_image_height' => [
                'label' => esc_html__('Box Image Height', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => '200',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 1000,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_box_hover_effect' => [
                'label' => esc_html__('Box Hover Effect', 'dipi-divi-pixel'),
                //'description' => esc_html__('Select Button Alignement', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'dipi-divi-pixel'),
                    'zoomin' => esc_html__('Zoom In', 'dipi-divi-pixel'),
                    'zoomout' => esc_html__('Zoom Out', 'dipi-divi-pixel'),
                    'moveup' => esc_html__('Move Up', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_image_hover_effect' => [
                'label' => esc_html__('Image Hover Effect', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => 'zoomin',
                'options' => [
                    'none' => esc_html__('None', 'dipi-divi-pixel'),
                    'zoomin' => esc_html__('Zoom In', 'dipi-divi-pixel'),
                    'zoomout' => esc_html__('Zoom Out', 'dipi-divi-pixel'),
                    'zoomrotate' => esc_html__('Zoom & Rotate', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_image_overlay_color' => [
                'label' => esc_html__('Image Overlay Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_image_overlay_color_hover' => [
                'label' => esc_html__('Hover Image Overlay Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_box_background_color' => [
                'label' => esc_html__('Post Box Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => '#fff',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],

            'blog_related_border_radius' => [
                'label' => esc_html__('Box Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => '10',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_border_width' => [
                'label' => esc_html__('Box Border Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_box_border_color' => [
                'label' => esc_html__('Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_shadow_heading' => [
                'label' => esc_html__('Single Post Box Shadow', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_box_shadow' => [
                'label' => esc_html__('Add Box Shadow', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_box_shadow_color' => [
                'label' => esc_html__('Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_related_posts',
                'default' => '#000',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_box_shadow_offset' => [
                'label' => esc_html__('Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => '5',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_box_shadow_blur' => [
                'label' => esc_html__('Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => '10',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_hover_box_shadow_color' => [
                'label' => esc_html__('Hover Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => '#444',
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_hover_box_shadow_offset' => [
                'label' => esc_html__('Hover Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => '6',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],
            'blog_related_hover_box_shadow_blur' => [
                'label' => esc_html__('Hover Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_related_posts',
                'panel' => 'blog',
                'default' => '12',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'related_articles' => 'on',
                ]),
            ],



            'blog_comments_disabled' => [
                'label' => esc_html__('Customize Comments Form', 'dipi-divi-pixel'),
                'description' => esc_html__('To customize blog comments form please enable this option in Divi Pixel Dashboard unde Blog > Customize Comments Section.', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'cta' => true,
                'icon' => 'dp-comments',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'off',
                ]),
            ],
            'blog_comments_fields_font_heading' => [
                'label' => esc_html__('Fields Style', 'dipi-divi-pixel'),
                //'description' => esc_html__('custom description', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'icon' => 'dp-color',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_font_select' => [
                'label' => esc_html__('Field Font', 'dipi-divi-pixel'),
                'type' => 'font',
                'default' => 'none',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_font_weight' => [
                'label' => esc_html__('Field Font Weight', 'dipi-divi-pixel'),
                'type' => 'font_weight',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_font_style' => [
                'label' => esc_html__('Field Text Style', 'dipi-divi-pixel'),
                // 'description' => esc_html__('Select a font style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_font_size' => [
                'label' => esc_html__('Field Font Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'default' => '15',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_text_spacing' => [
                'label' => esc_html__('Field Text Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_field_padding' => [
                'label' => esc_html__('Field Padding', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'default' => '30',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_field_border_radius' => [
                'label' => esc_html__('Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'default' => '10',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_field_border' => [
                'label' => esc_html__('Border Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_field_color' => [
                'label' => esc_html__('Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_font_color' => [
                'label' => esc_html__('Field Font Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_field_background_color' => [
                'label' => esc_html__('Field Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_field_shadow' => [
                'label' => esc_html__('Display Field Shadow', 'dipi-divi-pixel'),
                //'description' => esc_html__('Select Button Alignement', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_field_shadow_color' => [
                'label' => esc_html__('Field Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_field_shadow_offset' => [
                'label' => esc_html__('Field Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_field_shadow_blur' => [
                'label' => esc_html__('Field Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],






            'blog_comments_submit_heading' => [
                'label' => esc_html__('Submit Button Style', 'dipi-divi-pixel'),
                //'description' => esc_html__('custom description', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'icon' => 'dp-click',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_submit_btn_effect' => [
                'label' => esc_html__('Button Hover Effect', 'dipi-divi-pixel'),
                //'description' => esc_html__('Select Button Alignement', 'dipi-divi-pixel'),
                'type' => 'select',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'dipi-divi-pixel'),
                    'zoomin' => esc_html__('Zoom In', 'dipi-divi-pixel'),
                    'zoomout' => esc_html__('Zoom Out', 'dipi-divi-pixel'),
                    'moveup' => esc_html__('Move Up', 'dipi-divi-pixel'),
                ],
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_font_select' => [
                'label' => esc_html__('Button Font', 'dipi-divi-pixel'),
                'type' => 'font',
                'default' => 'none',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_font_weight' => [
                'label' => esc_html__('Button Font Weight', 'dipi-divi-pixel'),
                'type' => 'font_weight',
                'section' => 'blog_comments',
                'default' => '700',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_font_style' => [
                'label' => esc_html__('Button Text Style', 'dipi-divi-pixel'),
                // 'description' => esc_html__('Select a font style', 'dipi-divi-pixel'),
                'type' => 'font_style',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_font_size' => [
                'label' => esc_html__('Button Font Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'default' => '13',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_text_spacing' => [
                'label' => esc_html__('Button Text Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_text_spacing_hover' => [
                'label' => esc_html__('Hover Button Text Letter Spacing', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_padding' => [
                'label' => esc_html__('Button Padding', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'default' => '15',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_border_radius' => [
                'label' => esc_html__('Button Border Radius', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'default' => '100',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_border' => [
                'label' => esc_html__('Button Border Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'default' => '0',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_color' => [
                'label' => esc_html__('Button Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_font_color' => [
                'label' => esc_html__('Button Font Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_comments',
                'default' => '#ffffff',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_background_color' => [
                'label' => esc_html__('Button Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_comments',
                'default' => '#2c3d49',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_color_hover' => [
                'label' => esc_html__('Hover Button Border Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_font_color_hover' => [
                'label' => esc_html__('Hover Button Font Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_background_color_hover' => [
                'label' => esc_html__('Hover Button Background Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'default' => '#4b5a64',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],




            'blog_comments_btn_shadow_heading' => [
                'label' => esc_html__('Button Shadow', 'dipi-divi-pixel'),
                //'description' => esc_html__('custom description', 'dipi-divi-pixel'),
                'type' => 'heading',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'icon' => 'dp-layers',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_shadow' => [
                'label' => esc_html__('Display Button Shadow', 'dipi-divi-pixel'),
                //'description' => esc_html__('Select Button Alignement', 'dipi-divi-pixel'),
                'type' => 'checkbox',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_shadow_color' => [
                'label' => esc_html__('Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_shadow_offset' => [
                'label' => esc_html__('Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_shadow_blur' => [
                'label' => esc_html__('Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_shadow_color_hover' => [
                'label' => esc_html__('Hover Shadow Color', 'dipi-divi-pixel'),
                'type' => 'color',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_shadow_offset_hover' => [
                'label' => esc_html__('Hover Shadow Offset-Y', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
            'blog_comments_btn_shadow_blur_hover' => [
                'label' => esc_html__('Hover Shadow Blur', 'dipi-divi-pixel'),
                'type' => 'range',
                'section' => 'blog_comments',
                'panel' => 'blog',
                'input_attrs' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                    'suffix' => 'px'
                ],
                'active_callback' => $this->show_if_option([
                    'enable_custom_comments' => 'on',
                ]),
            ],
        ];
    }

    private function footer_social_icons_active_callback(){
        return function ($control) {
            $dipi_social_icons_individual_location = DIPI_Settings::get_option('social_icons_individual_location');
            $dipi_social_icons_footer = DIPI_Settings::get_option('social_icons_footer');
            $dipi_use_dipi_social_icons = DIPI_Settings::get_option('use_dipi_social_icons');
            $dipi_use_footer_customization = DIPI_Settings::get_option('footer_customization');
            
            if(!$dipi_use_dipi_social_icons){
                return false;
            }

            return $dipi_use_footer_customization && ($dipi_social_icons_individual_location || $dipi_social_icons_footer);
        };
    }

    private function accent_color(){
        if(is_null($this->accent_color) && function_exists('et_builder_accent_color')) {
            $this->accent_color = et_builder_accent_color();
        }
        return $this->accent_color;
    }

    // Show If callback for Theme Customizer options
    protected function show_if($field_id, $field_value){
        $prefix = self::settings_prefix();
        return function ($control) use ($field_id, $field_value, $prefix) {
            return $control->manager->get_setting("{$prefix}{$field_id}")->value() == $field_value;
        };
    }

    // Show If callback for Divi Pixel options
    private function show_if_option($options, $operator = "AND"){
        return function ($control) use ($options, $operator) {
            $show = $operator === "AND" ? true : false;
            foreach($options as $key => $value) {
                $compare_to = $value === 'off' ? '' : $value;
                if(!is_array($compare_to)) {
                    $compare_to = [$compare_to];
                }
                $option = DIPI_Settings::get_option($key);
                if($operator === "AND") {
                    $show = $show && in_array($option, $compare_to);
                } else {
                    $show = $show || in_array($option, $compare_to);
                }
            }
            return $show;
        };
    }
}
