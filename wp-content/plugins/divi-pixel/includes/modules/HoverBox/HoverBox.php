<?php
class DIPI_HoverBox extends DIPI_Builder_Module
{

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/hover-box',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->slug = 'dipi_hover_box';
        $this->vb_support = 'on';
        $this->name = esc_html__('Pixel Hover Box', 'dipi-divi-pixel');
        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'content' => esc_html__('Content ', 'dipi-divi-pixel'),
                    'content_hover' => esc_html__('Hover Content', 'dipi-divi-pixel'),
                    'settings' => esc_html__('Settings', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'content_background' => esc_html__('Content Background', 'dipi-divi-pixel'),
                    'content_hover_background' => esc_html__('Hover Background', 'dipi-divi-pixel'),
                    'content_icon_image' => esc_html__('Content Image & Icon', 'dipi-divi-pixel'),
                    'content_hover_icon_image' => esc_html__('Hover Image & Icon', 'dipi-divi-pixel'),
                    'header' => array(
                        'title' => esc_html__('Heading Text', 'dipi-divi-pixel'),
                        'priority' => 49,
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'h1' => array(
                                'name' => 'H1',
                                'icon' => 'text-h1',
                            ),
                            'h2' => array(
                                'name' => 'H2',
                                'icon' => 'text-h2',
                            ),
                            'h3' => array(
                                'name' => 'H3',
                                'icon' => 'text-h3',
                            ),
                            'h4' => array(
                                'name' => 'H4',
                                'icon' => 'text-h4',
                            ),
                            'h5' => array(
                                'name' => 'H5',
                                'icon' => 'text-h5',
                            ),
                            'h6' => array(
                                'name' => 'H6',
                                'icon' => 'text-h6',
                            ),
                        ),
                    ),
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
                        'title' => esc_html__('Content Text', 'dipi-divi-pixel'),
                        'priority' => 49,
                    ],
                    'content_hover_text' => [
                        'sub_toggles' => [
                            'title' => [
                                'name' => 'Title',
                            ],
                            'desc' => [
                                'name' => 'Description',
                            ],
                        ],
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__('Hover Text', 'dipi-divi-pixel'),
                        'priority' => 49,
                    ],
                ],
            ],
        ];
    }

    public function get_custom_css_fields_config()
    {

        $fields = [];

        $fields['content_card_container'] = [
            'label' => esc_html__('Content Card Container', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-hover-box-content',
        ];

        $fields['content_image_icon'] = [
            'label' => esc_html__('Image/Icon', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-content-image-icon-wrap',
        ];

        $fields['content_title'] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-hover-box-content .dipi-hover-box-heading',
        ];

        $fields['content_description'] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-hover-box-content .dipi-desc',
        ];

        $fields['content_button'] = [
            'label' => esc_html__('Button', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-content-button',
        ];

        $fields['content_hover_card_container'] = [
            'label' => esc_html__('Hover Card Container', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-hover-box-hover',
        ];

        $fields['content_hover_image_icon'] = [
            'label' => esc_html__('Hover Image/Icon', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-hover-image-icon-wrap',
        ];

        $fields['content_hover_title'] = [
            'label' => esc_html__('Hover Title', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-hover-box-hover .dipi-hover-box-heading',
        ];

        $fields['content_hover_description'] = [
            'label' => esc_html__('Hover Description', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-hover-box-hover .dipi-desc',
        ];

        $fields['content_hover_button'] = [
            'label' => esc_html__('Hover Button', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-hover-button',
        ];

        return $fields;
    }

    public function get_fields()
    {
        $fields = [];

        $fields['content_title'] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'content',
            'dynamic_content' => 'text'
        ];

        $fields['use_content_icon'] = [
            'label' => esc_html__('Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'content',
        ];

        $fields["content_image"] = [
            'label' => esc_html__('Image', 'dipi-divi-pixel'),
            'type' => 'upload',
            'option_category' => 'basic_option',
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'hide_metadata' => true,
            'show_if' => ['use_content_icon' => 'off'],
            'toggle_slug' => 'content',
            'dynamic_content' => 'image'
        ];

        $fields["content_image_alt"] = [
            'label' => esc_html__('Image Alt Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'description' => esc_html__('Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
            'show_if' => ['use_content_icon' => 'off'],
            'toggle_slug' => 'content',
            'dynamic_content'    => 'text'
        ];

        $fields["content_image_width"] = [
            'label' => esc_html__('Image Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'validate_unit' => true,
            'default' => '100%',
            'default_unit' => '%',
            'show_if' => ['use_content_icon' => 'off'],
            'range_settings' => [
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'width',
        ];

        $fields['content_icon'] = [
            'label' => esc_html__('Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'default' => '5',
            'show_if' => ['use_content_icon' => 'on'],
            'toggle_slug' => 'content',
        ];

        $fields["content_icon_color"] = [
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#7EBEC5',
            'show_if' => ['use_content_icon' => 'on'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image',
        ];

        $fields["content_circle_icon"] = [
            'label' => esc_html__('Circle Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'default' => 'off',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'show_if' => ['use_content_icon' => 'on'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image',
        ];

        $fields["content_circle_color"] = [
            'label' => esc_html__('Circle Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'show_if' => array(
                'content_circle_icon' => 'on',
            ),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image',
        ];

        $fields["content_circle_border"] = [
            'label' => esc_html__('Show Circle Border', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'default' => 'off',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'show_if' => ['content_circle_icon' => 'on'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image',
        ];

        $fields["content_circle_border_color"] = [
            'label' => esc_html__('Circle Border Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'show_if' => [
                'content_circle_border' => 'on',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image',
        ];

        $fields["content_icon_size"] = [
            'label' => esc_html__('Icon Font Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'validate_unit' => true,
            'default' => '40px',
            'default_unit' => 'px',
            'range_settings' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'show_if' => ['use_content_icon' => 'on'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image',
        ];

        $fields['body_text'] = [
            'label' => esc_html__('Body Text', 'dipi-divi-pixel'),
            'type' => 'tiny_mce',
            'toggle_slug' => 'content',
            'dynamic_content' => 'text'
        ];

        // Hover side
        $fields['content_hover_title'] = [
            'label' => esc_html__('Hover Title', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'content_hover',
            'dynamic_content' => 'text'
        ];

        $fields['use_content_hover_icon'] = [
            'label' => esc_html__('Hover Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'content_hover',
        ];

        $fields["content_hover_image"] = [
            'label' => esc_html__('Hover Image', 'dipi-divi-pixel'),
            'type' => 'upload',
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'description' => esc_html__('Upload an image to display as before image', 'dipi-divi-pixel'),
            'hide_metadata' => true,
            'show_if' => ['use_content_hover_icon' => 'off'],
            'toggle_slug' => 'content_hover',
            'dynamic_content' => 'image',
        ];

        $fields["content_hover_image_alt"] = [
            'label' => esc_html__('Hover Image Alt Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'description' => esc_html__('Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
            'show_if' => ['use_content_hover_icon' => 'off'],
            'toggle_slug' => 'content_hover',
            'dynamic_content' => 'text',
        ];

        $fields["content_hover_image_width"] = [
            'label' => esc_html__('Hover Image Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'validate_unit' => true,
            'default' => '100%',
            'default_unit' => '%',
            'show_if' => ['use_content_hover_icon' => 'off'],
            'range_settings' => [
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'width',
        ];

        $fields['content_hover_icon'] = [
            'label' => esc_html__('Hover Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'default' => '5',
            'show_if' => ['use_content_hover_icon' => 'on'],
            'toggle_slug' => 'content_hover',
        ];

        $fields["content_hover_icon_color"] = [
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#7EBEC5',
            'show_if' => ['use_content_hover_icon' => 'on'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_hover_icon_image',
        ];

        $fields["content_hover_circle_icon"] = [
            'label' => esc_html__('Circle Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'show_if' => ['use_content_hover_icon' => 'on'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_hover_icon_image',
        ];

        $fields["content_hover_circle_color"] = [
            'label' => esc_html__('Circle Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'show_if' => array(
                'content_hover_circle_icon' => 'on',
            ),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_hover_icon_image',
        ];

        $fields["content_hover_circle_border"] = [
            'label' => esc_html__('Show Circle Border', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'show_if' => ['use_content_hover_icon' => 'on'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_hover_icon_image',
        ];

        $fields["content_hover_circle_border_color"] = [
            'label' => esc_html__('Circle Border Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'show_if' => [
                'content_hover_circle_border' => 'on',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_hover_icon_image',
        ];

        $fields["content_hover_icon_size"] = [
            'label' => esc_html__('Icon Font Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'validate_unit' => true,
            'default' => '40px',
            'default_unit' => 'px',
            'range_settings' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'show_if' => ['use_content_hover_icon' => 'on'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_hover_icon_image',
        ];

        $fields['content_hover_content'] = [
            'label' => esc_html__('Body Text', 'dipi-divi-pixel'),
            'type' => 'tiny_mce',
            'toggle_slug' => 'content_hover',
            'dynamic_content' => 'text'
        ];

        $fields['use_content_hover_button'] = [
            'label' => esc_html__('Show Hover Side Button', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'content_hover',
        ];

        $fields["content_hover_button_text"] = [
            'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => esc_html__('Click Here', 'dipi-divi-pixel'),
            'show_if' => ['use_content_hover_button' => 'on'],
            'toggle_slug' => 'content_hover',
            'dynamic_content' => 'text'
        ];

        $fields["content_hover_button_link"] = [
            'label' => esc_html__('Button Link', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => '#',
            'show_if' => ['use_content_hover_button' => 'on'],
            'toggle_slug' => 'content_hover',
            'dynamic_content' => 'url'
        ];

        $fields["content_hover_button_link_target"] = [
            'label' => esc_html__('Button Link Target', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'layout',
            'default' => 'same_window',
            'default_on_child' => true,
            'options' => [
                'off' => esc_html__('Same Window', 'dipi-divi-pixel'),
                'on' => esc_html__('New Window', 'dipi-divi-pixel'),
            ],
            'show_if' => ['use_content_hover_button' => 'on'],
            'toggle_slug' => 'content_hover',
        ];

        $fields["hover_type"] = [
            'label' => esc_html__('Hover Type', 'dipi-divi-pixel'),
            'type' => 'select',
            'toggle_slug' => 'settings',
            'default' => 'slide',
            'options' => [
                'slide' => esc_html__('Slide', 'dipi-divi-pixel'),
                'fade' => esc_html__('Fade', 'dipi-divi-pixel'),
                'zoom' => esc_html__('Zoom', 'dipi-divi-pixel'),
            ],
        ];

        $fields["hover_direction"] = [
            'label' => esc_html__('Direction', 'dipi-divi-pixel'),
            'type' => 'select',
            'toggle_slug' => 'settings',
            'default' => 'top',
            'options' => [
                'top' => esc_html__('Bottom to Top', 'dipi-divi-pixel'),
                'bottom' => esc_html__('Top to Bottom', 'dipi-divi-pixel'),
                'left' => esc_html__('Left to Right', 'dipi-divi-pixel'),
                'right' => esc_html__('Right to Left', 'dipi-divi-pixel'),
            ],
            'show_if_not' => [
                'hover_type' => ['zoom', 'fade'],
            ],
        ];

        $fields["animation_speed"] = [
            'label' => esc_html__('Animation Speed', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'basic_option',
            'default' => '600ms',
            'fixed_unit' => 'ms',
            'range_settings' => [
                'min' => 100,
                'max' => 3000,
                'step' => 100,
            ],
            'toggle_slug' => 'settings',
        ];

        $fields["hover_box_align_front"] = [
            'label' => esc_html__('Content Align', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'center',
            'toggle_slug' => 'settings',
            'options' => [
                'top_left' => esc_html__('Top Left', 'dipi-divi-pixel'),
                'top' => esc_html__('Center Top', 'dipi-divi-pixel'),
                'top_right' => esc_html__('Top Right', 'dipi-divi-pixel'),
                'left' => esc_html__('Left', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'right' => esc_html__('Right', 'dipi-divi-pixel'),
                'bottom_left' => esc_html__('Bottom Left', 'dipi-divi-pixel'),
                'bottom' => esc_html__('Center Bottom', 'dipi-divi-pixel'),
                'bottom_right' => esc_html__('Bottom Right', 'dipi-divi-pixel'),
            ],
        ];

        $fields["hover_box_align_back"] = [
            'label' => esc_html__('Hover Content Align', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'center',
            'toggle_slug' => 'settings',
            'options' => [
                'top_left' => esc_html__('Top Left', 'dipi-divi-pixel'),
                'top' => esc_html__('Center Top', 'dipi-divi-pixel'),
                'top_right' => esc_html__('Top Right', 'dipi-divi-pixel'),
                'left' => esc_html__('Left', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'right' => esc_html__('Right', 'dipi-divi-pixel'),
                'bottom_left' => esc_html__('Bottom Left', 'dipi-divi-pixel'),
                'bottom' => esc_html__('Center Bottom', 'dipi-divi-pixel'),
                'bottom_right' => esc_html__('Bottom Right', 'dipi-divi-pixel'),
            ],
        ];

        $fields['use_force_square'] = [
            'label' => esc_html__('Force Module to be a Square', 'dipi-divi-pixel'),
            'description' => esc_html__('When enabeld, the module will always be a perfect square. The height will automatically be set to the width of the module.', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'settings',
        ];

        $fields["box_height"] = [
            'label' => esc_html__('Box Height', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'basic_option',
            'default' => '400px',
            'range_settings' => [
                'min' => 1,
                'max' => 1000,
                'step' => 1,
            ],
            'toggle_slug' => 'settings',
            'mobile_options' => true,
            'show_if' => [
                'use_force_square' => 'off',
            ],
        ];

        $additional_options = [];

        $additional_options['content_bg_color'] = [
            'label' => esc_html__('Background', 'dipi-divi-pixel'),
            'type' => 'background-field',
            'base_name' => "content_bg",
            'context' => "content_bg",
            'option_category' => 'layout',
            'custom_color' => true,
            'default' => ET_Global_Settings::get_value('all_buttons_bg_color'),
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => "content_background",
            'background_fields' => array_merge(
                ET_Builder_Element::generate_background_options('content_bg', 'gradient', "advanced", "content_background", "content_bg_gradient"),
                ET_Builder_Element::generate_background_options("content_bg", "color", "advanced", "content_background", "content_bg_color"),
                ET_Builder_Element::generate_background_options("content_bg", "image", "advanced", "content_background", "content_bg_image")
            ),
        ];

        $additional_options['content_hover_bg_color'] = [
            'label' => esc_html__('Hover Background', 'dipi-divi-pixel'),
            'type' => 'background-field',
            'base_name' => "content_hover_bg",
            'context' => "content_hover_bg",
            'option_category' => 'layout',
            'custom_color' => true,
            'default' => ET_Global_Settings::get_value('all_buttons_bg_color'),
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => "content_hover_background",
            'background_fields' => array_merge(
                ET_Builder_Element::generate_background_options('content_hover_bg', 'gradient', "advanced", "content_hover_background", "content_hover_bg_gradient"),
                ET_Builder_Element::generate_background_options("content_hover_bg", "color", "advanced", "content_hover_background", "content_hover_bg_color"),
                ET_Builder_Element::generate_background_options("content_hover_bg", "image", "advanced", "content_hover_background", "content_hover_bg_image")
            ),
        ];

        $additional_options = array_merge($additional_options, $this->generate_background_options("content_bg", 'skip', "advanced", "content_background", "content_bg_gradient"));
        $additional_options = array_merge($additional_options, $this->generate_background_options("content_bg", 'skip', "advanced", "content_background", "content_bg_color"));
        $additional_options = array_merge($additional_options, $this->generate_background_options("content_bg", 'skip', "advanced", "content_background", "content_bg_image"));
        $additional_options = array_merge($additional_options, $this->generate_background_options("content_hover_bg", 'skip', "advanced", "content_hover_background", "content_hover_bg_gradient"));
        $additional_options = array_merge($additional_options, $this->generate_background_options("content_hover_bg", 'skip', "advanced", "content_hover_background", "content_hover_bg_color"));
        $additional_options = array_merge($additional_options, $this->generate_background_options("content_hover_bg", 'skip', "advanced", "content_hover_background", "content_hover_bg_image"));

        return array_merge($fields, $additional_options);
    }

    public function get_advanced_fields_config()
    {

        $advanced_fields = [];

        $advanced_fields["text"] = false;
        $advanced_fields["text_shadow"] = false;
        $advanced_fields["fonts"] = [];

        $advanced_fields["borders"]["default"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%%,
                                       %%order_class%% .dipi-hover-box-container,
                                       %%order_class%% .dipi-hover-box-content,
                                       %%order_class%% .dipi-hover-box-hover",
                    'border_styles' => "%%order_class%% .dipi-hover-box-container",
                ],
            ],
        ];
        $advanced_fields["fonts"]["header"] = [
            'label' => esc_html__('Heading', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%% h1",
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
                'main' => "%%order_class%% h2",
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
                'main' => "%%order_class%% h3",
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
                'main' => "%%order_class%% h4",
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
                'main' => "%%order_class%% h5",
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
                'main' => "%%order_class%% h6",
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
        $advanced_fields["fonts"]["content_title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-hover-box-content .dipi-hover-box-heading",
            ],
            'important' => 'all',
            'hide_text_align' => true,
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

        $advanced_fields["fonts"]["content_desc"] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-hover-box-content .dipi-desc",
            ],
            'important' => 'all',
            'hide_text_align' => true,
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

        $advanced_fields["fonts"]["content_hover_title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-hover-box-hover .dipi-hover-box-heading",
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'content_hover_text',
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

        $advanced_fields["fonts"]["content_hover_desc"] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-hover-box-hover .dipi-desc",
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'content_hover_text',
            'sub_toggle' => 'desc',
            'line_height' => [
                'range_settings' => [
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ],
            ],
        ];

        $advanced_fields["box_shadow"]["default"] = [
            'label' => esc_html__('Box Shadow', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-hover-box-container",
            ],
        ];

        $advanced_fields['margin_padding'] = [
            'css' => [
                'margin' => "%%order_class%% .dipi-hover-box-content, %%order_class%% .dipi-hover-box-hover",
                'padding' => "%%order_class%% .dipi-hover-box-content-innner, %%order_class%% .dipi-hover-box-hover-innner",
                'important' => 'all',
            ],
        ];

        $advanced_fields['button']["content_hover_button"] = [
            'label' => esc_html__('Hover Button', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-hover-button",
                'important' => 'all',
            ],
            'use_alignment' => false,
            'box_shadow' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-hover-button",
                    'important' => true,
                ],
            ],
            'borders' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-hover-button",
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-hover-button.et_pb_button",
                    'important' => true,
                ],
            ],
        ];

        $advanced_fields['borders']['content_image'] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-hover-box-content .dipi-image-wrap img",
                    'border_styles' => "%%order_class%% .dipi-hover-box-content .dipi-image-wrap img",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image',
            'depends_on' => ['use_content_icon'],
            'depends_show_if' => 'off',
        ];

        $advanced_fields['box_shadow']['content_image'] = [
            'label' => esc_html__('Image Box Shadow', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'show_if' => ['use_content_icon' => 'off'],
            'css' => [
                'main' => '%%order_class%% .dipi-hover-box-content .dipi-image-wrap img',
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image',
        ];

        $advanced_fields['borders']['content_hover_image'] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-hover-box-hover .dipi-image-wrap img",
                    'border_styles' => "%%order_class%% .dipi-hover-box-hover .dipi-image-wrap img",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_hover_icon_image',
            'depends_on' => ['use_content_hover_icon'],
            'depends_show_if' => 'off',
        ];

        $advanced_fields['box_shadow']['content_hover_icon_image'] = [
            'label' => esc_html__('Hover Image Box Shadow', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'show_if' => ['use_content_hover_icon' => 'off'],
            'css' => [
                'main' => '%%order_class%% .dipi-hover-box-hover .dipi-image-wrap img',
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_hover_icon_image',
        ];

        return $advanced_fields;
    }

    public function _render_content($render_slug)
    {

        $content_icon_image = '';

        if ('on' == $this->props['use_content_icon']) {

            $content_circle_icon_class = ('on' === $this->props['content_circle_icon']) ? ' dipi-content-icon-circle' : '';
            $content_border_icon_class = ('on' === $this->props['content_circle_border']) ? ' dipi-content-icon-border' : '';
            $icon = ($this->props['content_icon'] === '%&quot;%%' || $this->props['content_icon'] === '%"%%') ? '%%22%%' : $this->props['content_icon'];
            $content_icon = et_pb_process_font_icon($icon);
            $content_icon_image = sprintf(
                '<div class="dipi-content-image-icon-wrap dipi-icon-wrap">
                    <span class="et-pb-icon et-pb-font-icon dipi-hover-box-content-icon%2$s%3$s">%1$s</span>
                </div>',
                esc_attr($content_icon),
                $content_circle_icon_class,
                $content_border_icon_class
            );

            $this->dipi_generate_font_icon_styles($render_slug, 'content_icon', '%%order_class%% .dipi-hover-box-content .dipi-hover-box-content-icon');
        } else if ('on' !== $this->props['use_content_icon'] && $this->props['content_image'] !== '') {
            $content_icon_image = sprintf(
                '<div class="dipi-content-image-icon-wrap dipi-image-wrap">
                    <img src="%1$s" alt="%2$s">
                </div>',
                esc_attr($this->props['content_image']),
                $this->_esc_attr('content_image_alt')
            );
        }

        $content_title_level = $this->props['content_title_level'];
        $content_title = '';
        if (isset($this->props['content_title']) && '' !== $this->props['content_title']) {
            $content_title = sprintf(
                '<%2$s class="dipi-hover-box-heading">
                    %1$s
                </%2$s>',
                esc_attr($this->props['content_title']),
                esc_attr($content_title_level)
            );
        }

        $body_text = '';
        if (isset($this->props['body_text'])) {
            $body_text = sprintf(
                '<div class="dipi-desc">%1$s</div>',
                $this->process_content($this->props['body_text'])
            );
        }

        $content_parallax_bg = '';
        if ('on' == $this->props["content_bg_parallax"]) {
            $content_parallax_bg = $this->process_parallax_image_bg("content_bg");
        }

        return sprintf(
            '<div class="dipi-hover-box-content">
              %1$s
              <div class="dipi-hover-box-content-innner">
                    %2$s
                    <div class="dipi-text">
                        %3$s
                        %4$s
                    </div>
              </div>
            </div>
            ',
            $content_parallax_bg,
            $content_icon_image,
            $content_title,
            $body_text
        );
    }

    /**
     * Render function for back Flipbox
     */
    public function _render_content_hover($render_slug)
    {

        $content_hover_icon_image = '';

        if ('on' == $this->props['use_content_hover_icon']) {

            $hover_circle_icon_class = ('on' === $this->props['content_hover_circle_icon']) ? ' dipi-hover-icon-circle' : '';
            $hover_border_icon_class = ('on' === $this->props['content_hover_circle_border']) ? ' dipi-hover-icon-border' : '';
            $icon_hover = ($this->props['content_hover_icon'] === '%&quot;%%' || $this->props['content_hover_icon'] === '%"%%') ? '%%22%%' : $this->props['content_hover_icon'];
            $content_hover_icon = et_pb_process_font_icon($icon_hover);

            $content_hover_icon_image = sprintf(
                '<div class="dipi-hover-image-icon-wrap dipi-icon-wrap">
                    <span class="et-pb-icon et-pb-font-icon dipi-hover-box-hover-icon %2$s%3$s">
                        %1$s
                    </span>
                </div>',
                esc_attr($content_hover_icon),
                $hover_circle_icon_class,
                $hover_border_icon_class
            );

            // Font Icon Styles since Divi 4.13
            $this->dipi_generate_font_icon_styles($render_slug, 'content_hover_icon', '%%order_class%% .dipi-hover-box-hover .dipi-hover-box-hover-icon');
        } else if ('on' !== $this->props['use_content_hover_icon'] && $this->props['content_hover_image'] !== '') {
            $content_hover_icon_image = sprintf(
                '<div class="dipi-hover-image-icon-wrap dipi-image-wrap">
                    <img class="dipi-hover-box-hover-imge" src="%1$s" alt="%2$s">
                </div>',
                $this->props['content_hover_image'],
                $this->_esc_attr('content_hover_image_alt')
            );
        }

        $content_hover_title_level = $this->props['content_hover_title_level'];
        $content_hover_title = '';
        if (isset($this->props['content_hover_title']) && '' !== $this->props['content_hover_title']) {

            $content_hover_title = sprintf(
                '<%2$s class="dipi-hover-box-heading">
                    %1$s
                </%2$s>',
                esc_attr($this->props['content_hover_title']),
                esc_attr($content_hover_title_level)

            );
        }

        $content_hover_content = '';

        if (isset($this->props['content_hover_content'])) {
            $content_hover_content = sprintf(
                '<div class="dipi-desc">
                    %1$s
                </div>',
                $this->process_content($this->props['content_hover_content'])
            );
        }

        $content_hover_button_rel = $this->props['content_hover_button_rel'];
        $use_content_hover_button = $this->props['use_content_hover_button'];
        $content_hover_button_text = $this->props['content_hover_button_text'];
        $content_hover_button_link = $this->props['content_hover_button_link'];
        $content_hover_button_link_target = $this->props['content_hover_button_link_target'];
        $content_hover_button_icon = $this->props['content_hover_button_icon'];
        $content_hover_button_custom = $this->props['custom_content_hover_button'];

        $content_hover_button = 'on' == $use_content_hover_button ? $this->render_button([
            'button_classname' => ["dipi-hover-button"],
            'button_custom' => $content_hover_button_custom,
            'button_rel' => $content_hover_button_rel,
            'button_text' => $content_hover_button_text,
            'button_url' => $content_hover_button_link,
            'custom_icon' => $content_hover_button_icon,
            'has_wrapper' => false,
            'url_new_window' => $content_hover_button_link_target,
        ]) : '';

        $content_hover_parallax_bg = 'on' == $this->props["content_hover_bg_parallax"] ? $this->process_parallax_image_bg("content_hover_bg") : '';

        return sprintf(
            '<div class="dipi-hover-box-hover">
                %1$s
                <div class="dipi-hover-box-hover-innner">
                    %2$s
                    <div class="dipi-text">
                        %3$s
                        %4$s
                    </div>
                    %5$s
                </div>
            </div>',
            $content_hover_parallax_bg,
            $content_hover_icon_image,
            $content_hover_title,
            $content_hover_content,
            $content_hover_button
        );
    }
 

    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_hover_box_public');
        $this->_dipi_apply_css($render_slug);

        $hover_box_animation = 'dipi-hover-box-slide-top';
        if ('slide' === $this->props['hover_type']) {
            $hover_box_animation = "dipi-hover-box-slide-{$this->props['hover_direction']}";
        } else if ('fade' === $this->props['hover_type']) {
            $hover_box_animation = 'dipi-hover-box-fade';
        } else if ('zoom' === $this->props['hover_type']) {
            $hover_box_animation = 'dipi-hover-box-zoom';
        }

        $hover_box_align_front_class = sprintf(
            'hover_box_align_front_%1$s',
            $this->props['hover_box_align_front']
        );

        $hover_box_align_back_class = sprintf(
            'hover_box_align_back_%1$s',
            $this->props['hover_box_align_back']
        );

        return sprintf(
            '<div class="dipi-hover-box-container %3$s %4$s %5$s" data-force_square="%6$s">
                <div class="dipi-hover-box-inner-wrapper">
                    %1$s
                    %2$s
                </div>
            </div>',
            $this->_render_content($render_slug),
            $this->_render_content_hover($render_slug),
            $hover_box_animation,
            $hover_box_align_front_class,
            $hover_box_align_back_class,
            $this->props['use_force_square']
        );
    }

    private function _dipi_apply_css($render_slug)
    {
        $content_icon_color = $this->props['content_icon_color'];
        $content_circle_icon = $this->props['content_circle_icon'];
        $content_circle_color = $this->props['content_circle_color'];
        $content_circle_border = $this->props['content_circle_border'];
        $content_circle_border_color = $this->props['content_circle_border_color'];
        $content_icon_size = $this->props['content_icon_size'];
        $content_image_width = $this->props['content_image_width'];
        $content_hover_icon_color = $this->props['content_hover_icon_color'];
        $content_hover_circle_icon = $this->props['content_hover_circle_icon'];
        $content_hover_circle_color = $this->props['content_hover_circle_color'];
        $content_hover_circle_border = $this->props['content_hover_circle_border'];
        $content_hover_circle_border_color = $this->props['content_hover_circle_border_color'];
        $content_hover_icon_size = $this->props['content_hover_icon_size'];
        $content_hover_image_width = $this->props['content_hover_image_width'];

        if ('on' !== $this->props['use_force_square']) {
            $this->_dipi_box_height($render_slug);
        }

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hover-box-content .dipi-hover-box-content-icon',
            'declaration' => "color: {$content_icon_color} !important;",
        ]);

        if ('on' == $content_circle_icon):
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-hover-box-content .dipi-content-icon-circle',
                'declaration' => "background-color: {$content_circle_color} !important;",
            ]);
        endif;

        if ('on' == $content_circle_border):
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-hover-box-content .dipi-content-icon-border',
                'declaration' => "border-color: {$content_circle_border_color} !important;",
            ]);
        endif;

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hover-box-content .dipi-hover-box-content-icon',
            'declaration' => "font-size: {$content_icon_size} !important;",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hover-box-hover .dipi-hover-box-hover-icon',
            'declaration' => "color: {$content_hover_icon_color} !important;",
        ]);

        if ('on' == $content_hover_circle_icon):
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-hover-box-hover .dipi-hover-icon-circle',
                'declaration' => "background-color: {$content_hover_circle_color} !important;",
            ]);
        endif;

        if ('on' == $content_hover_circle_border):
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-hover-box-hover .dipi-hover-icon-border',
                'declaration' => "border-color: {$content_hover_circle_border_color} !important;",
            ]);
        endif;

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hover-box-hover .dipi-hover-box-hover-icon',
            'declaration' => "font-size: {$content_hover_icon_size} !important;",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hover-box-content .dipi-image-wrap',
            'declaration' => "max-width: {$content_image_width} !important;",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hover-box-hover .dipi-image-wrap',
            'declaration' => "max-width: {$content_hover_image_width} !important;",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hover-box-container .dipi-hover-box-content, %%order_class%% .dipi-hover-box-container .dipi-hover-box-hover',
            'declaration' => "transition-duration: {$this->props['animation_speed']} !important;",
        ]);

        $this->set_background_css(
            $render_slug,
            "%%order_class%% .dipi-hover-box-content",
            "%%order_class%% .dipi-hover-box-content:hover",
            'content_bg', 
            'content_bg_color'
        );
        $this->set_background_css(
            $render_slug,
            "%%order_class%% .dipi-hover-box-hover",
            "%%order_class%% .dipi-hover-box-hover:hover",
            'content_hover_bg', 
            'content_hover_bg_color'
        );
    }

    private function _dipi_box_height($render_slug)
    {

        $box_height = $this->props['box_height'];
        $box_height_tablet = $this->props['box_height_tablet'] ? $this->props['box_height_tablet'] : $box_height;
        $box_height_phone = $this->props['box_height_phone'] ? $this->props['box_height_phone'] : $box_height_tablet;
        $box_height_last_edited = $this->props['box_height_last_edited'];
        $box_height_responsive_status = et_pb_get_responsive_status($box_height_last_edited);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hover-box-content, %%order_class%% .dipi-hover-box-hover, %%order_class%% .dipi-hover-box-container',
            'declaration' => "height: {$box_height};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hover-box-container, %%order_class%% .dipi-hover-box-content, %%order_class%% .dipi-hover-box-hover',
            'declaration' => "min-height: {$box_height};",
        ]);

        if ('' !== $box_height_tablet && $box_height_responsive_status) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-hover-box-content, %%order_class%% .dipi-hover-box-hover, %%order_class%% .dipi-hover-box-container',
                'declaration' => "height: {$box_height_tablet};",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-hover-box-container, %%order_class%% .dipi-hover-box-content, %%order_class%% .dipi-hover-box-hover',
                'declaration' => "min-height: {$box_height_tablet}; ",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ]);
        }

        if ('' !== $box_height_phone && $box_height_responsive_status) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-hover-box-content, %%order_class%% .dipi-hover-box-hover, %%order_class%% .dipi-hover-box-container',
                'declaration' => "height: {$box_height_phone};",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-hover-box-container, %%order_class%% .dipi-hover-box-content, %%order_class%% .dipi-hover-box-hover',
                'declaration' => "min-height: {$box_height_phone};",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ]);
        }
    }
}

new DIPI_HoverBox;
