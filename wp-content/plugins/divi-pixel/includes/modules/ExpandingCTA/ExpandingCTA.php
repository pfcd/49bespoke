<?php

class DIPI_ExpandingCTA extends DIPI_Builder_Module
{
    public $slug = 'dipi_expanding_cta';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/expanding-cta',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . "icon.svg";
        $this->name = esc_html__('Pixel Expanding CTA', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%.dipi_expanding_cta';
        $this->settings_modal_toggles = [];

        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'content' => esc_html__('Content', 'dipi-divi-pixel'),
                    'settings' => esc_html__('Expand & Overlay Settings', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'container' => esc_html__('Expanding CTA', 'dipi-divi-pixel'),
                    'content_image_icon' => esc_html__('Image & Icon', 'dipi-divi-pixel'),
                    'content_text' => [
                        'sub_toggles' => [
                            'title' => [
                                'name' => 'Title',
                            ],
                            'desc' => [
                                'name' => 'Description',
                            ],
                        ],
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__('Text', 'dipi-divi-pixel'),
                    ],
                ],
            ],
        ];

        add_filter('et_fb_backend_helpers', [$this, 'default_helpers'], 100, 1);
    }

    public function default_helpers($helpers)
    {
        $helpers['defaults']['dipi_expanding_cta'] = [
            'first_heading' => 'First',
            'second_heading' => 'Second',
        ];
        return $helpers;
    }

    public function get_custom_css_fields_config()
    {
        $fields = [];
        $fields['expanding_cta_container'] = [
            'label' => esc_html__('Container', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_expanding_cta_container ',
        ];
        $fields['expanding_cta_container_bg'] = [
            'label' => esc_html__('Container Background', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_expanding_cta_container .dipi_expanding_cta_container-background',
        ];
        $fields['expanding_cta_content'] = [
            'label' => esc_html__('Content Wrapper', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_expanding_cta_container .dipi_expanding_cta-content-wrapper',
        ];
        $fields['expanding_cta_content_sel'] = [
            'label' => esc_html__('Content', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_expanding_cta_container .dipi_expanding_cta-content-wrapper  .dipi_expanding_cta-content',
        ];
        $fields['image_icon'] = [
            'label' => esc_html__('Image/Icon', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_expanding_cta_container .dipi-content-image-icon-wrap',
        ];
        $fields['title'] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_expanding_cta_container .dipi-content-heading',
        ];
        $fields['description'] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_expanding_cta_container .dipi-desc',
        ];
        $fields['button_wrapper'] = [
            'label' => esc_html__('Button Wrapper', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_expanding_cta_container .dipi-button-wrapper',
        ];
        $fields['button'] = [
            'label' => esc_html__('Button', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_expanding_cta_container .dipi-button-wrapper .dipi_content_button',
        ];
        return $fields;
    }

    public function get_fields()
    {
        $et_accent_color = et_builder_accent_color();
        $fields = [];
        $fields["use_content_icon"] = [
            'label' => esc_html__('Use Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'content',
        ];
        $fields["content_icon"] = [
            'label' => esc_html__('Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'class' => ['et-pb-font-icon'],
            'default' => '1',
            'show_if' => [
                'use_content_icon' => 'on',
            ],
            'toggle_slug' => 'content',
        ];
        $fields['content_image'] = [
            'type' => 'upload',
            'hide_metadata' => true,
            'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'description' => esc_html__('Upload an info image to show in the content.', 'dipi-divi-pixel'),
            'show_if' => [
                'use_content_icon' => 'off',
            ],
            'toggle_slug' => 'content',
        ];
        // add alt field
        $fields['content_image_alt'] = [
            'label' => esc_html__('Image Alt Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'description' => esc_html__('If you would like to add alt text to your image enter it here.', 'dipi-divi-pixel'),
            'show_if' => [
                'use_content_icon' => 'off',
            ],
            'toggle_slug' => 'content',
        ];

        $fields['content_icon'] = [
            'label' => esc_html__('Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'class' => ['et-pb-font-icon'],
            'default' => '5',
            'show_if' => ['use_content_icon' => 'on'],
            'toggle_slug' => 'content',
        ];

        $fields["content_title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'content',
            'dynamic_content' => 'text',
        ];

        $fields["content_description"] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'type' => 'tiny_mce',
            'toggle_slug' => 'content',
            'dynamic_content' => 'text',
        ];

        $fields['show_content_button'] = [
            'label' => esc_html__('Show Button', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'content',
        ];

        $fields["content_button_text"] = [
            'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => esc_html__('Click Here', 'dipi-divi-pixel'),
            'show_if' => ['show_content_button' => 'on'],
            'toggle_slug' => 'content',
            'dynamic_content' => 'text',
        ];

        $fields["content_button_link"] = [
            'label' => esc_html__('Button Link', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => '#',
            'show_if' => ['show_content_button' => 'on'],
            'toggle_slug' => 'content',
            'dynamic_content' => 'url',
        ];

        $fields["content_button_link_target"] = [
            'label' => esc_html__('Button Link Target', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'layout',
            'default' => 'same_window',
            'default_on_child' => true,
            'options' => [
                'off' => esc_html__('Same Window', 'dipi-divi-pixel'),
                'on' => esc_html__('New Window', 'dipi-divi-pixel'),
            ],
            'show_if' => ['show_content_button' => 'on'],
            'toggle_slug' => 'content',
        ];

        $fields['show_content_button'] = [
            'label' => esc_html__('Show Button', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'content',
        ];

        $fields["content_button_text"] = [
            'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => esc_html__('Click Here', 'dipi-divi-pixel'),
            'show_if' => ['show_content_button' => 'on'],
            'toggle_slug' => 'content',
            'dynamic_content' => 'text',
        ];

        $fields["content_button_link"] = [
            'label' => esc_html__('Button Link', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => '#',
            'show_if' => ['show_content_button' => 'on'],
            'toggle_slug' => 'content',
            'dynamic_content' => 'url',
        ];

        $fields["content_button_link_target"] = [
            'label' => esc_html__('Button Link Target', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'layout',
            'default' => 'same_window',
            'default_on_child' => true,
            'options' => [
                'off' => esc_html__('Same Window', 'dipi-divi-pixel'),
                'on' => esc_html__('New Window', 'dipi-divi-pixel'),
            ],
            'show_if' => ['show_content_button' => 'on'],
            'toggle_slug' => 'content',
        ];

        /* Second Button */
        $fields['show_second_button'] = [
            'label' => esc_html__('Show Second Button', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'content',
        ];

        $fields["second_button_text"] = [
            'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => esc_html__('Click Here', 'dipi-divi-pixel'),
            'show_if' => ['show_second_button' => 'on'],
            'toggle_slug' => 'content',
            'dynamic_content' => 'text',
        ];

        $fields["second_button_link"] = [
            'label' => esc_html__('Button Link', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => '#',
            'show_if' => ['show_second_button' => 'on'],
            'toggle_slug' => 'content',
            'dynamic_content' => 'url',
        ];

        $fields["second_button_link_target"] = [
            'label' => esc_html__('Button Link Target', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'layout',
            'default' => 'same_window',
            'default_on_child' => true,
            'options' => [
                'off' => esc_html__('Same Window', 'dipi-divi-pixel'),
                'on' => esc_html__('New Window', 'dipi-divi-pixel'),
            ],
            'show_if' => ['show_second_button' => 'on'],
            'toggle_slug' => 'content',
        ];
        /*$fields['blur_in_expanding'] = [
        'label'                  => esc_html__( 'Blur in Expanding', 'dipi-divi-pixel' ),
        'toggle_slug'  => 'settings',
        'type'                   => 'range',
        'range_settings'         => [
        'min'  => '0',
        'max'  => '100',
        'step' => '0.1',
        ],
        'option_category'        => 'layout',
        'hover'           => 'tabs',
        'validate_unit'          => true,
        'responsive'             => true,
        'mobile_options'         => true,
        'sticky'                 => true,
        'default' => '1.2'
        ];*/
        $fields['zoom_in_expanding'] = [
            'label' => esc_html__('Zoom in Expanding', 'dipi-divi-pixel'),
            'toggle_slug' => 'settings',
            'type' => 'range',
            'range_settings' => [
                'min' => '0.5',
                'max' => '3',
                'step' => '0.1',
            ],
            'option_category' => 'layout',
            'hover' => 'tabs',
            'validate_unit' => true,
            'responsive' => true,
            'mobile_options' => true,
            'sticky' => true,
            'default' => '1.2',
        ];
        $fields["hide_header"] = [
            'label' => esc_html__('Hide Header', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'settings',
        ];
        $fields["hide_backtotop"] = [
            'label' => esc_html__('Hide Back To Top Button', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'settings',
        ];
        $fields["overlay_above_background"] = [
            'label' => esc_html__('Place Overlay Above Background', 'dipi-divi-pixel'),
            'description' => esc_html__('If this setting is on, overlay will over the background of module. If this setting is off, overlay will be under the background of module.', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'settings',
        ];

        $fields['url'] = [
            'label' => esc_html__('Content Link URL', 'et_builder'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'description' => esc_html__('If you would like to make your blurb a link, input your destination URL here.', 'et_builder'),
            'toggle_slug' => 'link_options',
            'dynamic_content' => 'url',
        ];
        $fields['url_new_window'] = [
            'label' => esc_html__('Content Link Target', 'et_builder'),
            'type' => 'select',
            'option_category' => 'configuration',
            'options' => array(
                'off' => esc_html__('In The Same Window', 'et_builder'),
                'on' => esc_html__('In The New Tab', 'et_builder'),
            ),
            'toggle_slug' => 'link_options',
            'description' => esc_html__('Here you can choose whether or not your link opens in a new window', 'et_builder'),
            'default_on_front' => 'off',
        ];
        /* Container */

        /* Content Image & Icon */
        $fields['content_icon_color'] = [
            'default' => $et_accent_color,
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'description' => esc_html__('Here you can define a custom color for your icon.', 'dipi-divi-pixel'),
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'hover' => 'tabs',
            'mobile_options' => true,
            'sticky' => true,
            'toggle_slug' => 'content_image_icon',
        ];
        $fields['content_image_icon_background_color'] = [
            'label' => esc_html__('Image & Icon Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'description' => esc_html__('Here you can define a custom background color.', 'dipi-divi-pixel'),
            'default' => 'transparent',
            'tab_slug' => 'advanced',
            'hover' => 'tabs',
            'mobile_options' => true,
            'sticky' => true,
            'toggle_slug' => 'content_image_icon',
        ];
        $fields['content_image_icon_width'] = [
            'label' => esc_html__('Image & Icon Size', 'dipi-divi-pixel'),
            'toggle_slug' => 'content_image_icon',
            'description' => esc_html__('Here you can choose icon/img Size.', 'dipi-divi-pixel'),
            'type' => 'range',
            'range_settings' => [
                'min' => '1',
                'max' => '200',
                'step' => '1',
            ],
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'hover' => 'tabs',
            'validate_unit' => true,
            'allowed_units' => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
            'responsive' => true,
            'mobile_options' => true,
            'sticky' => true,
            'default' => '96px',
        ];
        $fields['icon_alignment'] = [
            'label' => esc_html__('Image/Icon Alignment', 'dipi-divi-pixel'),
            'description' => esc_html__('Align image/icon to the left, right or center.', 'dipi-divi-pixel'),
            'type' => 'align',
            'option_category' => 'layout',
            'options' => et_builder_get_text_orientation_options(array('justified')),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_image_icon',
            'default' => 'center',
            'mobile_options' => true,
            'sticky' => true,
        ];
        /* Content Title Spacing */
        $fields['content_title_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of Title.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_text',
            'sub_toggle' => 'title',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
        ];
        $fields['content_title_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Title.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_text',
            'sub_toggle' => 'title',
            'default' => '0px|0px|10px|0px',
            'mobile_options' => true,
        ];
        $fields['content_desc_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of Description.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_text',
            'sub_toggle' => 'desc',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
        ];
        $fields['content_desc_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Description.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_text',
            'sub_toggle' => 'desc',
            'default' => '0px|0px|10px|0px',
            'mobile_options' => true,
        ];

        $fields['container_padding'] = [
            'label' => esc_html('Container Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '30px|30px|30px|30px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'margin_padding',
        ];
        $fields['content_width'] = [
            'label' => esc_html('Content Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '100%',
            'default_unit' => '%',
            'range_settings' => [
                'min' => '1',
                'max' => '100',
                'step' => '1',
            ],
            'validate_unit' => true,
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'width',
        ];
        $fields["content_alignment"] = [
            'label' => esc_html__('Content Alignment', 'dipi-divi-pixel'),
            'type' => 'text_align',
            'options_icon' => 'module_align',
            'default' => 'center',
            'options' => [
                'left' => esc_html__('Left', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'right' => esc_html__('Right', 'dipi-divi-pixel'),
            ],
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'width',
        ];
        $additional_options = [];
        $additional_options['overlay_bg_color'] = [
            'label' => esc_html__('Overlay Background', 'dipi-divi-pixel'),
            'type' => 'background-field',
            'base_name' => "overlay_bg",
            'context' => "overlay_bg",
            'option_category' => 'layout',
            'custom_color' => true,
            'default' => ET_Global_Settings::get_value('all_buttons_bg_color'),
            'toggle_slug' => "settings",
            'background_fields' => array_merge(
                ET_Builder_Element::generate_background_options('overlay_bg', 'gradient', "advanced", "overlay_background", "overlay_bg_gradient"),
                ET_Builder_Element::generate_background_options("overlay_bg", "color", "advanced", "overlay_background", "overlay_bg_color"),
                ET_Builder_Element::generate_background_options("overlay_bg", "image", "advanced", "overlay_background", "overlay_bg_image")
            ),
        ];
        $additional_options['content_bg_color'] = [
            'label' => esc_html__('Background', 'dipi-divi-pixel'),
            'type' => 'background-field',
            'base_name' => "content_bg",
            'context' => "content_bg",
            'option_category' => 'layout',
            'custom_color' => true,
            'default' => ET_Global_Settings::get_value('all_buttons_bg_color'),
            'tab_slug' => 'advanced',
            'toggle_slug' => "container",
            'background_fields' => array_merge(
                ET_Builder_Element::generate_background_options('content_bg', 'gradient', "advanced", "content_background", "content_bg_gradient"),
                ET_Builder_Element::generate_background_options("content_bg", "color", "advanced", "content_background", "content_bg_color"),
                ET_Builder_Element::generate_background_options("content_bg", "image", "advanced", "content_background", "content_bg_image")
            ),
        ];

        $additional_options = array_merge($additional_options, $this->generate_background_options("content_bg", 'skip', "advanced", "content_background", "content_bg_gradient"));
        $additional_options = array_merge($additional_options, $this->generate_background_options("content_bg", 'skip', "advanced", "content_background", "content_bg_color"));
        $additional_options = array_merge($additional_options, $this->generate_background_options("content_bg", 'skip', "advanced", "content_background", "content_bg_image"));
        $additional_options = array_merge($additional_options, $this->generate_background_options("overlay_bg", 'skip', "advanced", "overlay_background", "overlay_bg_gradient"));
        $additional_options = array_merge($additional_options, $this->generate_background_options("overlay_bg", 'skip', "advanced", "overlay_background", "overlay_bg_color"));
        $additional_options = array_merge($additional_options, $this->generate_background_options("overlay_bg", 'skip', "advanced", "overlay_background", "overlay_bg_image"));
        return array_merge($fields, $additional_options);
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = [];
        $advanced_fields["text"] = false;
        $advanced_fields["text_shadow"] = false;
        $advanced_fields["fonts"] = [];
        $advanced_fields["box_shadow"] = [];
        $advanced_fields["transform"] = false;
        $advanced_fields["filters"] = [];
        $advanced_fields['link_options'] = false;

        $main_selector = "%%order_class%%.dipi_expanding_cta .dipi_expanding_cta_container";
        $main_bg_selector = "%%order_class%%.dipi_expanding_cta .dipi_expanding_cta_container .dipi_expanding_cta_container-background";
        $expanded_main_bg_selector = "%%order_class%%.dipi-expanded-cta .dipi_expanding_cta_container .dipi_expanding_cta_container-background";
        $content_wrapper_selector = "%%order_class%%.dipi_expanding_cta .dipi_expanding_cta_container .dipi_expanding_cta-content-wrapper";
        $expanded_content_wrapper_selector = "%%order_class%%.dipi_expanding_cta.dipi-expanded-cta .dipi_expanding_cta_container .dipi_expanding_cta-content-wrapper";
        $content_selector = "%%order_class%%.dipi_expanding_cta .dipi_expanding_cta_container .dipi_expanding_cta-content-wrapper .dipi_expanding_cta-content";
        $content_icon_selector = '%%order_class%%.dipi_expanding_cta .dipi_expanding_cta_container .dipi_expanding_cta-content-wrapper .dipi-content-image-icon-wrap .et-pb-icon';
        $content_image_icon_selector = '%%order_class%%.dipi_expanding_cta .dipi_expanding_cta_container .dipi_expanding_cta-content-wrapper .dipi-content-image-icon-wrap';
        $content_image_icon_hover_selector = '%%order_class%%:hover .dipi_expanding_cta_container .dipi_expanding_cta-content-wrapper .dipi-content-image-icon-wrap';
        $content_image_icon_width_selector = '%%order_class%%.dipi_expanding_cta .dipi_expanding_cta_container .dipi_expanding_cta-content-wrapper .dipi-content-image-icon-wrap.dipi-image-wrapper';

        $content_title_selector = '%%order_class%%.dipi_expanding_cta .dipi-content-text .dipi-content-heading';
        $content_desc_selector = '%%order_class%%.dipi_expanding_cta .dipi-content-text .dipi-desc';

        $advanced_fields["box_shadow"]["default"] = [
            'css' => [
                'main' => $main_bg_selector,
                'hover' => $expanded_main_bg_selector,
            ],
        ];
        $advanced_fields["box_shadow"]["container"] = [
            'css' => [
                'main' => $content_wrapper_selector,
                'hover' => $expanded_content_wrapper_selector,
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'container',
        ];
        $advanced_fields["borders"]["default"] = [
            'css' => [
                'main' => [
                    'border_radii' => $main_bg_selector,
                    'border_styles' => $main_bg_selector,
                ],

            ],
        ];
        $advanced_fields["borders"]["container"] = [
            'css' => [
                'main' => [
                    'border_radii' => $content_wrapper_selector,
                    'border_styles' => $content_wrapper_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'container',
        ];
        $advanced_fields["background"] = [
            'css' => [
                'main' => $main_bg_selector,
                'pattern' => $main_bg_selector . ' .et_pb_background_pattern',
                'mask' => $main_bg_selector . ' .et_pb_background_mask',
            ],
        ];

        $advanced_fields["margin_padding"] = [
            'css' => [
                'padding' => $main_selector,
                'margin' => $main_selector,
            ],
        ];
        $advanced_fields['max_width'] = [
            'css' => [
                'main' => $main_selector,
            ],
            'use_height' => true,
            'use_max_height' => true,
            'use_module_alignment' => true,
        ];
        $advanced_fields['height'] = [
            'css' => [
                'main' => $main_selector,
            ],
            'use_height' => true,
            'use_max_height' => true,
        ];
        $advanced_fields["fonts"]["content_title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => $content_title_selector,
            ],
            'important' => 'all',
            'hide_text_align' => false,
            'toggle_slug' => 'content_text',
            'sub_toggle' => 'title',
            'header_level' => [
                'default' => 'h2',
            ],
            'line_height' => [
                'range_settings' => [
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ],
            ],
        ];
        $advanced_fields["fonts"]["header"] = [
            'label' => esc_html__('Heading', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%%.dipi_expanding_cta h1",
            ),
            'font_size' => array(
                'default' => absint(et_get_option('body_header_size', '30')) . 'px',
            ),
            'toggle_slug' => 'header',
            'sub_toggle' => 'h1',
        ];
        $advanced_fields["fonts"]["header_2"] = [
            'label' => esc_html__('Heading 2', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%%.dipi_expanding_cta h2",
            ),
            'font_size' => array(
                'default' => '26px',
            ),
            'line_height' => array(
                'default' => '1em',
            ),
            'toggle_slug' => 'header',
            'sub_toggle' => 'h2',
        ];
        $advanced_fields["fonts"]["header_3"] = [
            'label' => esc_html__('Heading 3', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%%.dipi_expanding_cta h3",
            ),
            'font_size' => array(
                'default' => '22px',
            ),
            'line_height' => array(
                'default' => '1em',
            ),
            'toggle_slug' => 'header',
            'sub_toggle' => 'h3',
        ];
        $advanced_fields["fonts"]["header_4"] = [
            'label' => esc_html__('Heading 4', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%%.dipi_expanding_cta h4",
            ),
            'font_size' => array(
                'default' => '18px',
            ),
            'line_height' => array(
                'default' => '1em',
            ),
            'toggle_slug' => 'header',
            'sub_toggle' => 'h4',
        ];
        $advanced_fields["fonts"]["header_5"] = [
            'label' => esc_html__('Heading 5', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%%.dipi_expanding_cta h5",
            ),
            'font_size' => array(
                'default' => '16px',
            ),
            'line_height' => array(
                'default' => '1em',
            ),
            'toggle_slug' => 'header',
            'sub_toggle' => 'h5',
        ];
        $advanced_fields["fonts"]["header_6"] = [
            'label' => esc_html__('Heading 6', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%%.dipi_expanding_cta h6",
            ),
            'font_size' => array(
                'default' => '14px',
            ),
            'line_height' => array(
                'default' => '1em',
            ),
            'toggle_slug' => 'header',
            'sub_toggle' => 'h6',
        ];
        $advanced_fields["fonts"]["content_desc"] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'css' => [
                'main' => $content_desc_selector,
            ],
            'important' => 'all',
            'hide_text_align' => false,
            'toggle_slug' => 'content_text',
            'sub_toggle' => 'desc',
            'line_height' => [
                'range_settings' => [
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ],
            ],
        ];
        $advanced_fields['button']["content_button"] = [
            'label' => esc_html__('Button One', 'dipi-divi-pixel'),
            'use_alignment' => true,
            'font_size' => array(
                'default' => '14px',
            ),
            'css' => [
                'main' => "%%order_class%%.dipi_expanding_cta .dipi_content_button.et_pb_button",
                'important' => true,
            ],
            'box_shadow' => [
                'css' => [
                    'main' => "%%order_class%%.dipi_expanding_cta .dipi_content_button.et_pb_button",
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'margin' => "%%order_class%%.dipi_expanding_cta .dipi_content_button.et_pb_button",
                    'padding' => "%%order_class%%.dipi_expanding_cta .dipi_content_button.et_pb_button",
                    'important' => 'all',
                ],
            ],
        ];

        $advanced_fields['button']["second_button"] = [
            'label' => esc_html__('Button Two', 'dipi-divi-pixel'),
            'use_alignment' => true,
            'font_size' => array(
                'default' => '14px',
            ),
            'css' => [
                'main' => "%%order_class%%.dipi_expanding_cta .dipi_second_button.et_pb_button",
                'important' => true,
            ],
            'box_shadow' => [
                'css' => [
                    'main' => "%%order_class%%.dipi_expanding_cta .dipi_second_button.et_pb_button",
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'margin' => "%%order_class%%.dipi_expanding_cta .dipi_second_button.et_pb_button",
                    'padding' => "%%order_class%%.dipi_expanding_cta .dipi_second_button.et_pb_button",
                    'important' => 'all',
                ],
            ],
        ];
        /* Content Image & Icon */
        $advanced_fields['borders']['content_image'] = [
            'css' => [
                'main' => [
                    'border_radii' => $content_image_icon_selector,
                    'border_radii_hover' => $content_image_icon_hover_selector,
                    'border_styles' => $content_image_icon_selector,
                    'border_styles_hover' => $content_image_icon_hover_selector,
                ],
            ],
            'label_prefix' => et_builder_i18n('Image & Icon'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_image_icon',
            'hover' => 'tabs',
        ];

        $advanced_fields['box_shadow']['content_image'] = [
            'label' => esc_html__('Image Box Shadow', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'css' => [
                'main' => $content_image_icon_selector,
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_image_icon',
            'hover' => 'tabs',
        ];

        $advanced_fields["image_icon"]["image_icon"] = [
            'margin_padding' => [
                'css' => [
                    'important' => 'all',
                ],
            ],
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_image_icon',
            'label' => et_builder_i18n('Image & Icon'),
            'css' => [
                'main' => $content_image_icon_selector,
                'hover' => $content_image_icon_hover_selector,
            ],
        ];
        $advanced_fields["icon_settings"] = [/* Need this setting to apply filter */
            'css' => [
                'main' => $content_image_icon_selector,
            ],
        ];
        $advanced_fields["filters"]['child_filters_target'] = [
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_image_icon',
            'label' => esc_html__('Image & Icon', 'dipi-divi-pixel'),
            'css' => array(
                'main' => $content_image_icon_selector,
            ),
        ];
        return $advanced_fields;
    }

    public function _dipi_apply_css($render_slug)
    {
        $container_class = "%%order_class%%.dipi_expanding_cta .dipi_expanding_cta_container .dipi_expanding_cta-content-wrapper";
        $content_selector = "%%order_class%%.dipi_expanding_cta .dipi_expanding_cta_container .dipi_expanding_cta-content-wrapper .dipi_expanding_cta-content";
        $container_hover_class = "%%order_class%%.dipi_expanding_cta .dipi_expanding_cta_container .dipi_expanding_cta-content-wrapper:hover";
        $overlay_class = "%%order_class%%.dipi_expanding_cta .dipi_extending_cta-overlay";
        $overlay_hover_class = "%%order_class%%.dipi_expanding_cta .dipi_extending_cta-overlay:hover";

        $container_padding = explode('|', $this->props['container_padding']);
        $container_padding_tablet = explode('|', $this->props['container_padding_tablet']);
        $container_padding_phone = explode('|', $this->props['container_padding_phone']);

        $container_padding_last_edited = $this->props['container_padding_last_edited'];
        $container_padding_responsive_status = et_pb_get_responsive_status($container_padding_last_edited);
        $content_icon_selector = '%%order_class%%.dipi_expanding_cta .dipi_expanding_cta_container .dipi_expanding_cta-content-wrapper .dipi-content-image-icon-wrap .et-pb-icon';
        $content_image_icon_selector = '%%order_class%%.dipi_expanding_cta .dipi_expanding_cta_container .dipi_expanding_cta-content-wrapper .dipi-content-image-icon-wrap';
        $content_image_icon_hover_selector = '%%order_class%%:hover .dipi_expanding_cta_container .dipi_expanding_cta-content-wrapper .dipi-content-image-icon-wrap';
        $content_image_icon_width_selector = '%%order_class%%.dipi_expanding_cta .dipi_expanding_cta_container .dipi_expanding_cta-content-wrapper .dipi-content-image-icon-wrap.dipi-image-wrapper';

        $content_title_selector = '%%order_class%%.dipi_expanding_cta .dipi-content-text .dipi-content-heading';
        $content_desc_selector = '%%order_class%%.dipi_expanding_cta .dipi-content-text .dipi-desc';
        $content_button_selector = '%%order_class%%.dipi_expanding_cta .dipi_expanding_cta-content-wrapper .dipi-button-wrapper';

        // Images: Add CSS Filters and Mix Blend Mode rules (if set)
        $generate_css_image_filters = '';
        if (array_key_exists('icon_settings', $this->advanced_fields) && array_key_exists('css', $this->advanced_fields['icon_settings'])) {
            $generate_css_image_filters = $this->generate_css_filters(
                $render_slug,
                'child_',
                self::$data_utils->array_get($this->advanced_fields['icon_settings']['css'], 'main', '%%order_class%%')
            );
        }

        if ('' !== $container_padding) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $container_class,
                'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $container_padding[0], $container_padding[1], $container_padding[2], $container_padding[3]),
            ));
        }

        if (count($container_padding_tablet) >= 4 && $container_padding_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $container_class,
                'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $container_padding_tablet[0], $container_padding_tablet[1], $container_padding_tablet[2], $container_padding_tablet[3]),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if (count($container_padding_phone) >=4 && $container_padding_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $container_class,
                'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $container_padding_phone[0], $container_padding_phone[1], $container_padding_phone[2], $container_padding_phone[3]),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        /* Content Image & Icon */
        $this->generate_styles(
            array(
                'base_attr_name' => 'content_icon_color',
                'selector' => $content_icon_selector,
                'css_property' => 'color',
                'render_slug' => $render_slug,
                'type' => 'color',
            )
        );

        $this->generate_styles(
            array(
                'base_attr_name' => 'content_image_icon_background_color',
                'selector' => $content_image_icon_selector,
                'css_property' => 'background-color',
                'render_slug' => $render_slug,
                'type' => 'color',
            )
        );

        $this->generate_styles(
            array(
                'base_attr_name' => 'content_image_icon_width',
                'selector' => $content_icon_selector,
                'css_property' => 'font-size',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );

        $this->generate_styles(
            array(
                'base_attr_name' => 'content_image_icon_width',
                'selector' => $content_image_icon_width_selector,
                'css_property' => 'width',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'content_image_icon_width',
                'selector' => $content_image_icon_width_selector,
                'css_property' => 'height',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'content_width',
                'selector' => $content_selector,
                'css_property' => 'max-width',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        $content_alignment = $this->props['content_alignment'];
        $content_alignment_values = et_pb_responsive_options()->get_property_values($this->props, 'content_alignment');
        $content_alignment_last_edited = $this->props['content_alignment_last_edited'];
        $content_alignment_margins = array(
            'left' => 'auto auto auto 0',
            'center' => 'auto',
            'right' => 'auto 0 auto auto',
        );

        if (et_pb_get_responsive_status($content_alignment_last_edited) && '' !== implode('', $content_alignment_values)) {
            $content_alignment_values = array();

            foreach ($content_alignment_values as $breakpoint => $alignment) {
                $content_alignment_values[$breakpoint] = et_()->array_get(
                    $content_alignment_margins,
                    $alignment,
                    ''
                );
            }
            et_pb_responsive_options()->generate_responsive_css(
                $content_alignment_values,
                $content_selector,
                'margin',
                $render_slug,
                '',
                'align'
            );
        } else {
            $el_style = array(
                'selector' => $content_selector,
                'declaration' => sprintf(
                    'margin: %1$s;',
                    esc_html(et_()->array_get($content_alignment_margins, $content_alignment, ''))
                ),
            );
            ET_Builder_Element::set_style($render_slug, $el_style);
        }
        // Image/Icon Alignment
        $icon_alignment = $this->props['icon_alignment'];
        $icon_alignment_values = et_pb_responsive_options()->get_property_values($this->props, 'icon_alignment');
        $icon_alignment_last_edited = $this->props['icon_alignment_last_edited'];
        $icon_alignment_margins = array(
            'left' => 'auto auto auto 0',
            'center' => 'auto',
            'right' => 'auto 0 auto auto',
        );

        if (et_pb_get_responsive_status($icon_alignment_last_edited) && '' !== implode('', $icon_alignment_values)) {
            $image_alignment_values = array();

            foreach ($icon_alignment_values as $breakpoint => $alignment) {
                $image_alignment_values[$breakpoint] = et_()->array_get(
                    $icon_alignment_margins,
                    $alignment,
                    ''
                );
            }
            et_pb_responsive_options()->generate_responsive_css(
                $image_alignment_values,
                $content_image_icon_selector,
                'margin',
                $render_slug,
                '',
                'align'
            );
        } else {
            $el_style = array(
                'selector' => $content_image_icon_selector,
                'declaration' => sprintf(
                    'margin: %1$s;',
                    esc_html(et_()->array_get($icon_alignment_margins, $icon_alignment, ''))
                ),
            );
            ET_Builder_Element::set_style($render_slug, $el_style);
        }

        /* Content Title */
        $this->apply_custom_margin_padding(
            $render_slug,
            'content_title_margin',
            'margin',
            $content_title_selector
        );
        $this->apply_custom_margin_padding(
            $render_slug,
            'content_title_padding',
            'padding',
            $content_title_selector
        );

        /* Content Description */
        $this->apply_custom_margin_padding(
            $render_slug,
            'content_desc_margin',
            'margin',
            $content_desc_selector
        );
        $this->apply_custom_margin_padding(
            $render_slug,
            'content_desc_padding',
            'padding',
            $content_desc_selector
        );
        /* Content Button */
        $btn_margin = $this->dipi_get_responsive_prop('content_button_custom_margin');
        // $this->set_responsive_spacing_css($render_slug, "%%order_class%%.dipi_expanding_cta .dipi_content_button.et_pb_button", 'margin', $btn_margin, true );
        $btn_padding = $this->dipi_get_responsive_prop('content_button_custom_margin');
        //$this->set_responsive_spacing_css($render_slug, "%%order_class%%.dipi_expanding_cta .dipi_content_button.et_pb_button", 'padding', $btn_padding, true );
        $this->generate_styles(
            array(
                'base_attr_name' => 'content_button_alignment',
                'selector' => $content_button_selector,
                'css_property' => 'text-align',
                'render_slug' => $render_slug,
                'type' => 'align',
            )
        );

        $this->set_background_css(
            $render_slug,
            $container_class,
            $container_hover_class,
            'content_bg',
            'content_bg_color'
        );
        $this->set_background_css(
            $render_slug,
            $overlay_class,
            $overlay_hover_class,
            'overlay_bg',
            'overlay_bg_color'
        );
        $this->apply_custom_style(
            $this->slug,
            'zoom_in_expanding',
            'transform',
            '%%order_class%%.dipi_expanding_cta.dipi-expanded-cta .dipi_expanding_cta_container .dipi_expanding_cta_container-background,
            %%order_class%%.dipi_expanding_cta.dipi-expanded-cta .dipi_expanding_cta_container .dipi_expanding_cta-content-wrapper,
            %%order_class%%.dipi_expanding_cta.dipi-expanded-cta .dipi_expanding_cta_container > .et_parallax_bg_wrap
            ',
            false,
            1,
            '',
            'scale'
        );
        /*$this->apply_custom_style(
    $this->slug,
    'blur_in_expanding',
    'backdrop-filter',
    '%%order_class%%.dipi_expanding_cta.dipi-expanded-cta .dipi_extending_cta-overlay',
    false,
    1,
    'px',
    'blur'
    );*/
    }

    public function get_custom_style($slug_value, $type, $important)
    {
        return sprintf('%1$s: %2$s%3$s;', $type, $slug_value, $important ? ' !important' : '');
    }
    public function get_changed_prop_value($slug, $conv_matrix)
    {
        if (array_key_exists($this->props[$slug], $conv_matrix)) {
            $this->props[$slug] = $conv_matrix[$this->props[$slug]];
        }

    }
    public function apply_custom_style_for_phone(
        $function_name,
        $slug,
        $type,
        $class,
        $important = false,
        $zoom = '',
        $unit = '',
        $wrap_func = '' /* traslate, clac ... */
    ) {
        if (empty($this->props[$slug . '_tablet'])) {
            $this->props[$slug . '_tablet'] = $this->props[$slug];
        }
        if (empty($this->props[$slug . '_phone'])) {
            $this->props[$slug . '_phone'] = $this->props[$slug . '_tablet'];
        }
        if ($zoom === '') {
            $slug_value = $this->props[$slug] . $unit;
            $slug_value_tablet = $this->props[$slug . '_tablet'] . $unit;
            $slug_value_phone = $this->props[$slug . '_phone'] . $unit;
        } else {
            $slug_value = ((float) $this->props[$slug] * $zoom) . $unit;
            $slug_value_tablet = ((float) $this->props[$slug . '_tablet'] * $zoom) . $unit;
            $slug_value_phone = ((float) $this->props[$slug . '_phone'] * $zoom) . $unit;
        }
        if ($wrap_func !== '') {
            $slug_value = "$wrap_func($slug_value)";
            $slug_value_tablet = "$wrap_func($slug_value_tablet)";
            $slug_value_phone = "$wrap_func($slug_value_phone)";
        }

        if (isset($slug_value_phone)
            && !empty($slug_value_phone)) {
            ET_Builder_Element::set_style($function_name, array(
                'selector' => $class,
                'declaration' => $this->get_custom_style($slug_value_phone, $type, $important),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }
    }

    public function apply_custom_style_for_tablet(
        $function_name,
        $slug,
        $type,
        $class,
        $important = false,
        $zoom = '',
        $unit = '',
        $wrap_func = '' /* traslate, clac ... */
    ) {
        if (empty($this->props[$slug . '_tablet'])) {
            $this->props[$slug . '_tablet'] = $this->props[$slug];
        }
        if ($zoom === '') {
            $slug_value = $this->props[$slug] . $unit;
            $slug_value_tablet = $this->props[$slug . '_tablet'] . $unit;
            $slug_value_phone = $this->props[$slug . '_phone'] . $unit;
        } else {
            $slug_value = ((float) $this->props[$slug] * $zoom) . $unit;
            $slug_value_tablet = ((float) $this->props[$slug . '_tablet'] * $zoom) . $unit;
            $slug_value_phone = ((float) $this->props[$slug . '_phone'] * $zoom) . $unit;
        }
        if ($wrap_func !== '') {
            $slug_value = "$wrap_func($slug_value)";
            $slug_value_tablet = "$wrap_func($slug_value_tablet)";
            $slug_value_phone = "$wrap_func($slug_value_phone)";
        }

        if (isset($slug_value_tablet)
            && !empty($slug_value_tablet)) {
            ET_Builder_Element::set_style($function_name, array(
                'selector' => $class,
                'declaration' => $this->get_custom_style($slug_value_tablet, $type, $important),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }
    }

    public function apply_custom_style_for_desktop(
        $function_name,
        $slug,
        $type,
        $class,
        $important = false,
        $zoom = '',
        $unit = '',
        $wrap_func = '' /* traslate, clac ... */
    ) {
        if ($zoom === '') {
            $slug_value = $this->props[$slug] . $unit;
            $slug_value_tablet = $this->props[$slug . '_tablet'] . $unit;
            $slug_value_phone = $this->props[$slug . '_phone'] . $unit;
        } else {
            $slug_value = ((float) $this->props[$slug] * $zoom) . $unit;
            $slug_value_tablet = ((float) $this->props[$slug . '_tablet'] * $zoom) . $unit;
            $slug_value_phone = ((float) $this->props[$slug . '_phone'] * $zoom) . $unit;
        }
        if ($wrap_func !== '') {
            $slug_value = "$wrap_func($slug_value)";
            $slug_value_tablet = "$wrap_func($slug_value_tablet)";
            $slug_value_phone = "$wrap_func($slug_value_phone)";
        }

        if (isset($slug_value) && !empty($slug_value)) {
            ET_Builder_Element::set_style($function_name, array(
                'selector' => $class,
                'declaration' => $this->get_custom_style($slug_value, $type, $important),
            ));
        }
    }

    public function apply_custom_style_for_hover(
        $function_name,
        $slug,
        $type,
        $class,
        $important = false
    ) {

        $slug_hover_enabled = isset($this->props[$slug . '__hover_enabled']) ? substr($this->props[$slug . '__hover_enabled'], 0, 2) === "on" : false;
        $slug_hover_value = isset($this->props[$slug . '__hover']) ? $this->props[$slug . '__hover'] : '';
        if (isset($slug_hover_value)
            && !empty($slug_hover_value)
            && $slug_hover_enabled) {
            ET_Builder_Element::set_style($function_name, array(
                'selector' => $class,
                'declaration' => $this->get_custom_style($slug_hover_value, $type, $important),
            ));
        }
    }

    public function apply_custom_style(
        $function_name,
        $slug,
        $type,
        $class,
        $important = false,
        $zoom = '',
        $unit = '',
        $wrap_func = '' /* traslate, clac ... */
    ) {
        $slug_value_responsive_active = isset($this->props[$slug . "_last_edited"]) ? et_pb_get_responsive_status($this->props[$slug . "_last_edited"]) : false;
        $slug_value = (isset($this->props[$slug])) ? $this->props[$slug] : '';
        $slug_value_tablet = ($slug_value_responsive_active && isset($this->props[$slug . "_tablet"])) ? $this->props[$slug . "_tablet"] : $slug_value;
        $slug_value_phone = ($slug_value_responsive_active && isset($this->props[$slug . "_phone"])) ? $this->props[$slug . "_phone"] : $slug_value_tablet;

        if ($zoom === '') {
            $slug_value = $slug_value . $unit;
            $slug_value_tablet = $slug_value_tablet . $unit;
            $slug_value_phone = $slug_value_phone . $unit;
        } else {
            $slug_value = ((float) $slug_value * $zoom) . $unit;
            $slug_value_tablet = ((float) $slug_value_tablet * $zoom) . $unit;
            $slug_value_phone = ((float) $slug_value_phone * $zoom) . $unit;
        }
        if ($wrap_func !== '') {
            $slug_value = "$wrap_func($slug_value)";
            $slug_value_tablet = "$wrap_func($slug_value_tablet)";
            $slug_value_phone = "$wrap_func($slug_value_phone)";
        }

        if (isset($slug_value) && !empty($slug_value)) {
            ET_Builder_Element::set_style($function_name, array(
                'selector' => $class,
                'declaration' => $this->get_custom_style($slug_value, $type, $important),
            ));
        }

        if (isset($slug_value_tablet)
            && !empty($slug_value_tablet)
            && $slug_value_responsive_active) {
            ET_Builder_Element::set_style($function_name, array(
                'selector' => $class,
                'declaration' => $this->get_custom_style($slug_value_tablet, $type, $important),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if (isset($slug_value_phone)
            && !empty($slug_value_phone)
            && $slug_value_responsive_active) {
            ET_Builder_Element::set_style($function_name, array(
                'selector' => $class,
                'declaration' => $this->get_custom_style($slug_value_phone, $type, $important),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }
    }
    public function apply_custom_margin_padding($function_name, $slug, $type, $class, $important = true)
    {
        $slug_value = $this->props[$slug];
        $slug_value_tablet = $this->props[$slug . '_tablet'];
        $slug_value_phone = $this->props[$slug . '_phone'];
        $slug_value_last_edited = $this->props[$slug . '_last_edited'];
        $slug_value_responsive_active = et_pb_get_responsive_status($slug_value_last_edited);

        if (isset($slug_value) && !empty($slug_value)) {
            ET_Builder_Element::set_style($function_name, array(
                'selector' => $class,
                'declaration' => et_builder_get_element_style_css($slug_value, $type, $important),
            ));
        }

        if (isset($slug_value_tablet) && !empty($slug_value_tablet) && $slug_value_responsive_active) {
            ET_Builder_Element::set_style($function_name, array(
                'selector' => $class,
                'declaration' => et_builder_get_element_style_css($slug_value_tablet, $type, $important),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if (isset($slug_value_phone) && !empty($slug_value_phone) && $slug_value_responsive_active) {
            ET_Builder_Element::set_style($function_name, array(
                'selector' => $class,
                'declaration' => et_builder_get_element_style_css($slug_value_phone, $type, $important),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }
    }
    private function replaceEmptyWith($array, $replaceValue)
    {
        foreach ($array as $key => $value) {
            if (empty($value)) {
                $array[$key] = $replaceValue;
            }
        }
        return $array;
    }
    public function _render_content($render_slug)
    {
        $url = $this->props['url'];
        $url_new_window = $this->props['url_new_window'];
        $parallax_image_background = $this->get_parallax_image_background();
        $content_image_icon = '';
        $content_icon_selector = '%%order_class%%.dipi_expanding_cta .dipi_expanding_cta_container .dipi_expanding_cta-content-wrapper .dipi-content-image-icon-wrap .et-pb-icon';
        if ('on' == $this->props['use_content_icon']) {
            $icon = ($this->props['content_icon'] === '%&quot;%%' || $this->props['content_icon'] === '%"%%') ? '%%22%%' : $this->props['content_icon'];
            $content_icon = et_pb_process_font_icon($icon);
            $content_image_icon = sprintf(
                '<div class="dipi-content-image-icon-wrap dipi-icon-wrap">
                    <span class="et-pb-icon et-pb-font-icon dipi-content-icon">%1$s</span>
                </div>',
                esc_attr($content_icon)
            );

            $this->dipi_generate_font_icon_styles($render_slug, 'content_icon', $content_icon_selector);
        } else if ('on' !== $this->props['use_content_icon'] && $this->props['content_image'] !== '') {
            $content_image_icon = sprintf(
                '<div class="dipi-content-image-icon-wrap dipi-image-wrapper">
                    <img src="%1$s" class="dipi-content-image" alt="%2$s">
                </div>',
                esc_attr($this->props['content_image']),
                $this->_esc_attr('content_image_alt')
            );
        }

        $content_title_level = $this->props['content_title_level'] ? $this->props['content_title_level'] : 'h2';
        $content_title = '';
        if (isset($this->props['content_title']) && '' !== $this->props['content_title']) {
            $content_title = sprintf(
                '<%2$s class="dipi-content-heading">
                    %1$s
                </%2$s>',
                esc_attr($this->props['content_title']),
                esc_attr($content_title_level)
            );
        }

        $content_description = '';
        if (isset($this->props['content_description'])) {
            $content_description = sprintf(
                '<div class="dipi-desc">%1$s</div>',
                $this->process_content($this->props['content_description'])
            );
        }

        $show_content_button = $this->props['show_content_button'];
        $content_button_text = $this->props['content_button_text'];
        $content_button_link = $this->props['content_button_link'];
        $content_button_rel = $this->props['content_button_rel'];
        $content_button_icon = $this->props['content_button_icon'];
        $content_button_link_target = $this->props['content_button_link_target'];
        $content_button_custom = $this->props['custom_content_button'];

        $content_button = $this->render_button([
            'button_classname' => ["dipi_content_button"],
            'button_custom' => $content_button_custom,
            'button_rel' => $content_button_rel,
            'button_text' => $content_button_text,
            'button_url' => $content_button_link,
            'custom_icon' => $content_button_icon,
            'url_new_window' => $content_button_link_target,
            'has_wrapper' => false,
        ]);

        $show_second_button = $this->props['show_second_button'];
        $second_button_text = $this->props['second_button_text'];
        $second_button_link = $this->props['second_button_link'];
        $second_button_rel = $this->props['second_button_rel'];
        $second_button_icon = $this->props['second_button_icon'];
        $second_button_link_target = $this->props['second_button_link_target'];
        $second_button_custom = $this->props['custom_second_button'];

        $second_button = $this->render_button([
            'button_classname' => ["dipi_second_button"],
            'button_custom' => $second_button_custom,
            'button_rel' => $second_button_rel,
            'button_text' => $second_button_text,
            'button_url' => $second_button_link,
            'custom_icon' => $second_button_icon,
            'url_new_window' => $second_button_link_target,
            'has_wrapper' => false,
        ]);

        $content_html = sprintf(
            '%1$s
            <div class="dipi-content-text">
                %2$s
                %3$s
            </div>
            <div class="dipi-button-wrapper">
                %4$s %5$s
            </div>
          ',
            $content_image_icon,
            $content_title,
            $content_description,
            ($show_content_button === 'on') ? $content_button : '',
            ($show_second_button === 'on') ? $second_button : ''
        );
        if (!empty($url)) {
            $target = ('on' === $url_new_window) ? 'target="_blank"' : '';
            $content_html = sprintf(
                '<a href="%1$s" %2$s
              class="content_link dipi_expanding_cta-content">
              %3$s
            </a>',
                esc_url($url),
                et_core_intentionally_unescaped($target, 'fixed_string'),
                et_core_esc_previously($content_html)
            );
        } else {
            $content_html = sprintf(
                '<div
              class="dipi_expanding_cta-content">
              %1$s
            </div>',
                $content_html
            );
        }
        $content_html = sprintf(
            '%1$s
            <div class="dipi_expanding_cta-content-wrapper">
                %2$s
            </div>
            ',
            $parallax_image_background,
            $content_html
        );

        return $content_html;
    }
    public function _render_overlay($render_slug)
    {
        $overlay_parallax_bg = '';
        if ('on' == $this->props["overlay_bg_parallax"]) {
            $overlay_parallax_bg = $this->process_parallax_image_bg("overlay_bg");
        }

        $overlay_html = sprintf(
            '<div class="dipi_extending_cta-overlay">
            %1$s
            </div>
            '
            ,
            $overlay_parallax_bg
        );
        return $overlay_html;
    }
    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_expanding_cta_public');
        $this->_dipi_apply_css($render_slug);
        $hide_header = $this->props['hide_header'];
        $hide_backtotop = $this->props['hide_backtotop'];
        $order_class = self::get_module_order_class($render_slug);
        $order_number = preg_replace('/[^0-9]/', '', $order_class);
        $config = [
            'hide_header' => $hide_header,
            'hide_backtotop' => $hide_backtotop,
            'dipi_expanding_cta_class' => $order_class,
            'dipi_expanding_cta_order_number' => $order_number,
        ];

        $overlay_above_background = $this->props['overlay_above_background'];
        $overlay_html = $this->_render_overlay($render_slug);
        $module_custom_classes = '';
        $output = sprintf(
            '<div class="dipi_expanding_cta_container %1$s"
                data-config="%5$s"
            >
                <div class="dipi_expanding_cta_container-background">
                    <span class="et_pb_background_pattern"></span>
					<span class="et_pb_background_mask"></span>
                </div>
                %2$s
                %3$s
            </div>
            %4$s
            ',
            $module_custom_classes,
            $this->_render_content($render_slug),
            $overlay_above_background === 'on' ? $overlay_html : '',
            $overlay_above_background === 'on' ? '' : $overlay_html,
            esc_attr(htmlspecialchars(json_encode($config), ENT_QUOTES, 'UTF-8')) #5
        );
        return $output;
    }
}

new DIPI_ExpandingCTA;
