<?php
class DIPI_FlipBox extends DIPI_Builder_Module
{

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/flip-box',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->slug = 'dipi_flip_box';
        $this->vb_support = 'on';
        $this->name = esc_html__('Pixel Flip Box', 'dipi-divi-pixel');
        $this->settings_modal_toggles = [

            'general' => [
                'toggles' => [
                    'front_side' => esc_html__('Front Side', 'dipi-divi-pixel'),
                    'back_side' => esc_html__('Back Side', 'dipi-divi-pixel'),
                    'settings' => esc_html__('Settings', 'dipi-divi-pixel'),
                    'flip_animation' => esc_html__('Flip Animation', 'dipi-divi-pixel'),
                ],
            ],

            'advanced' => [
                'toggles' => [
                    'front_side_background' => esc_html__('Front Background', 'dipi-divi-pixel'),
                    'back_side_background' => esc_html__('Back Background', 'dipi-divi-pixel'),
                    'front_icon_image' => esc_html__('Front Image & Icon', 'dipi-divi-pixel'),
                    'back_icon_image' => esc_html__('Back Image & Icon', 'dipi-divi-pixel'),
                    'front_text' => [
                        'sub_toggles' => [
                            'title' => [
                                'name' => 'Title',
                            ],
                            'desc' => [
                                'name' => 'Description',
                            ],
                        ],
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__('Front Text', 'dipi-divi-pixel'),
                        'priority' => 49,
                    ],
                    'back_text' => [
                        'sub_toggles' => [
                            'title' => [
                                'name' => 'Title',
                            ],
                            'desc' => [
                                'name' => 'Description',
                            ],
                        ],
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__('Back Text', 'dipi-divi-pixel'),
                        'priority' => 49,
                    ],
                    'width' => [
                        'title' => esc_html__('Sizing', 'dipi-divi-pixel'),
                        'priority' => 65,
                    ],
                ],
            ],
        ];
    }

    public function get_custom_css_fields_config()
    {

        $fields = [];

        $fields['front_card_container'] = [
            'label' => esc_html__('Front Card Container', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-flip-box-front-side',
        ];

        $fields['front_image_icon'] = [
            'label' => esc_html__('Front Image/Icon', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-front-image-icon-wrap',
        ];

        $fields['front_title'] = [
            'label' => esc_html__('Front Title', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-flip-box-front-side .dipi-flip-box-heading',
        ];

        $fields['front_description'] = [
            'label' => esc_html__('Front Description', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-flip-box-front-side .dipi-desc',
        ];

        $fields['front_button'] = [
            'label' => esc_html__('Front Button', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-front-button',
        ];

        $fields['back_card_container'] = [
            'label' => esc_html__('Back Card Container', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-flip-box-back-side',
        ];

        $fields['back_image_icon'] = [
            'label' => esc_html__('Back Image/Icon', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-back-image-icon-wrap',
        ];

        $fields['back_title'] = [
            'label' => esc_html__('Back Title', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-flip-box-back-side .dipi-flip-box-heading',
        ];

        $fields['back_description'] = [
            'label' => esc_html__('Back Description', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-flip-box-back-side .dipi-desc',
        ];

        $fields['back_button'] = [
            'label' => esc_html__('Back Button', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-back-button',
        ];

        return $fields;
    }

    public function get_fields()
    {

        $fields = [];

        $fields['front_title'] = [
            'label' => esc_html__('Front Title', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'front_side',
            'dynamic_content' => 'text'
        ];

        $fields['use_front_icon'] = [
            'label' => esc_html__('Icon for Front Side', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'front_side',
            'affects' => [
                'front_icon_image',
                'front_icon_color',
                'front_circle_icon',
                'front_circle_color',
                'front_circle_border',
                'front_circle_border_color',
                'front_icon_size',
                'front_icon_image',
            ],
        ];

        $fields["front_image"] = [
            'label' => esc_html__('Image', 'dipi-divi-pixel'),
            'type' => 'upload',
            'option_category' => 'basic_option',
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'hide_metadata' => true,
            'show_if' => ['use_front_icon' => 'off'],
            'toggle_slug' => 'front_side',
            'dynamic_content' => 'image'
        ];

        $fields["front_image_alt"] = [
            'label'       => esc_html__( 'Image Alt Text', 'dipi-divi-pixel' ),
            'type'        => 'text',
            'description' => esc_html__( 'Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
            'show_if' => ['use_front_icon' => 'off'],
            'toggle_slug' => 'front_side',
            'dynamic_content' => 'text'
        ];

        $fields["front_image_width"] = [
            'label' => esc_html__('Front Image Container Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'validate_unit' => true,
            'default' => '100%',
            'default_unit' => '%',
            'show_if' => ['use_front_icon' => 'off'],
            'range_settings' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'width',
        ];

        $fields["front_image_width"] = [
            'label' => esc_html__('Front Image Container Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'validate_unit' => true,
            'mobile_options' => true,
            'default' => '100%',
            'default_unit' => '%',
            'show_if' => ['use_front_icon' => 'off'],
            'range_settings' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'width',
        ];

        $fields['front_icon'] = [
            'label' => esc_html__('Front Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'default' => '5',
            'show_if' => ['use_front_icon' => 'on'],
            'toggle_slug' => 'front_side',
        ];

        $fields["front_icon_color"] = [
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#7EBEC5',
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'front_icon_image',
        ];

        $fields["front_circle_icon"] = [
            'label' => esc_html__('Circle Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'default' => 'off',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'front_icon_image',
        ];

        $fields["front_circle_color"] = [
            'label' => esc_html__('Circle Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'show_if' => array(
                'front_circle_icon' => 'on',
            ),
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'front_icon_image',
        ];

        $fields["front_circle_border"] = [
            'label' => esc_html__('Show Circle Border', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'default' => 'off',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'front_icon_image',
        ];

        $fields["front_circle_border_color"] = [
            'label' => esc_html__('Circle Border Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'show_if' => [
                'front_circle_border' => 'on',
            ],
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'front_icon_image',
        ];

        $fields["front_icon_size"] = [
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
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'front_icon_image',
        ];

        $fields['front_content'] = [
            'label' => esc_html__('Body Text', 'dipi-divi-pixel'),
            'type' => 'tiny_mce',
            'option_category' => 'basic_option',
            'toggle_slug' => 'front_side',
            'dynamic_content' => 'text'
        ];

        $fields['use_front_button'] = [
            'label' => esc_html__('Show Front Side Button', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'affects' => [
                'front_button_text',
                'front_button_link',
                'front_button_link_target',
            ],
            'toggle_slug' => 'front_side',
        ];

        $fields["front_button_text"] = [
            'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => esc_html__('Click Here', 'dipi-divi-pixel'),
            'option_category' => 'basic_option',
            'depends_show_if' => 'on',
            'toggle_slug' => 'front_side',
            'dynamic_content' => 'text'
        ];

        $fields["front_button_link"] = [
            'label' => esc_html__('Button Link', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => '#',
            'option_category' => 'basic_option',
            'depends_show_if' => 'on',
            'toggle_slug' => 'front_side',
            'dynamic_content' => 'link'
        ];

        $fields["front_button_link_target"] = [
            'label' => esc_html__('Button Link Target', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'layout',
            'default' => 'same_window',
            'default_on_child' => true,
            'options' => [
                'off' => esc_html__('Same Window', 'dipi-divi-pixel'),
                'on' => esc_html__('New Window', 'dipi-divi-pixel'),
            ],
            'depends_show_if' => 'on',
            'toggle_slug' => 'front_side',
        ];

        // Back side
        $fields['back_title'] = [
            'label' => esc_html__('Back Title', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'back_side',
            'dynamic_content' => 'text'
        ];

        $fields['use_back_icon'] = [
            'label' => esc_html__('Icon for Back Side', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'back_side',
            'affects' => [
                'back_icon_image',
                'back_icon_color',
                'back_circle_icon',
                'back_circle_color',
                'back_circle_border',
                'back_circle_border_color',
                'back_icon_size',
                'back_icon_image',
            ],
        ];

        $fields["back_image"] = [
            'label' => esc_html__('Image', 'dipi-divi-pixel'),
            'type' => 'upload',
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'description' => esc_html__('Upload an image to display as before image', 'dipi-divi-pixel'),
            'hide_metadata' => true,
            'show_if' => ['use_back_icon' => 'off'],
            'toggle_slug' => 'back_side',
            'dynamic_content' => 'image'
        ];

        $fields["back_image_alt"] = [
            'label'       => esc_html__( 'Image Alt Text', 'dipi-divi-pixel' ),
            'type'        => 'text',
            'description' => esc_html__( 'Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
            'show_if'     => ['use_back_icon' => 'off'],
            'toggle_slug' => 'back_side',
            'dynamic_content' => 'text'
        ];

        $fields["back_image_width"] = [
            'label' => esc_html__('Back Image Container Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'validate_unit' => true,
            'mobile_options' => true,
            'default' => '100%',
            'default_unit' => '%',
            'show_if' => ['use_back_icon' => 'off'],
            'range_settings' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'width',
        ];

        $fields['back_icon'] = [
            'label' => esc_html__('Back Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'option_category' => 'basic_option',
            'default' => '5',
            'show_if' => ['use_back_icon' => 'on'],
            'toggle_slug' => 'back_side',
        ];

        $fields["back_icon_color"] = [
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#7EBEC5',
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'back_icon_image',
        ];

        $fields["back_circle_icon"] = [
            'label' => esc_html__('Circle Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'default' => 'off',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'back_icon_image',
        ];

        $fields["back_circle_color"] = [
            'label' => esc_html__('Circle Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'show_if' => array(
                'back_circle_icon' => 'on',
            ),
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'back_icon_image',
        ];

        $fields["back_circle_border"] = [
            'label' => esc_html__('Show Circle Border', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'default' => 'off',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'back_icon_image',
        ];

        $fields["back_circle_border_color"] = [
            'label' => esc_html__('Circle Border Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'show_if' => [
                'back_circle_border' => 'on',
            ],
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'back_icon_image',
        ];

        $fields["back_icon_size"] = [
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
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'back_icon_image',
        ];

        $fields['back_content'] = [
            'label' => esc_html__('Body Text', 'dipi-divi-pixel'),
            'type' => 'tiny_mce',
            'option_category' => 'basic_option',
            'toggle_slug' => 'back_side',
            'dynamic_content' => 'text'
        ];

        $fields['use_back_button'] = [
            'label' => esc_html__('Show Back Side Button', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'affects' => [
                'back_button_text',
                'back_button_link',
                'back_button_link_target',
            ],
            'toggle_slug' => 'back_side',
        ];

        $fields["back_button_text"] = [
            'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => esc_html__('Click Here', 'dipi-divi-pixel'),
            'option_category' => 'basic_option',
            'depends_show_if' => 'on',
            'toggle_slug' => 'back_side',
            'dynamic_content' => 'text'
        ];

        $fields["back_button_link"] = [
            'label' => esc_html__('Button Link', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => '#',
            'option_category' => 'basic_option',
            'depends_show_if' => 'on',
            'toggle_slug' => 'back_side',
            'dynamic_content' => 'link'
        ];

        $fields["back_button_link_target"] = [
            'label' => esc_html__('Button Link Target', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'layout',
            'default' => 'same_window',
            'default_on_child' => true,
            'options' => [
                'off' => esc_html__('Same Window', 'dipi-divi-pixel'),
                'on' => esc_html__('New Window', 'dipi-divi-pixel'),
            ],
            'depends_show_if' => 'on',
            'toggle_slug' => 'back_side',
        ];

        $fields['use_dynamic_height'] = [
            'label' => esc_html__('Dynamic Height', 'dipi-divi-pixel'),
            'description' => esc_html__('When enabeld, the module will automatically calculate the height based on its content. It will compare the frontside and backside and use the larger element as it it\'s height.', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'settings',
            'show_if' => [
                'use_force_square' => 'off',
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
            'show_if' => [
                'use_dynamic_height' => 'off',
            ],
        ];

        $fields["flip_box_height"] = [
            'label' => esc_html__('Flip Box Height', 'dipi-divi-pixel'),
            'type' => 'range',
            'validate_unit' => true,
            'mobile_options' => true,
            'default' => '250px',
            'default_unit' => 'px',
            'range_settings' => array(
                'min' => '0',
                'max' => '500',
                'step' => '1',
            ),
            'show_if' => [
                'use_dynamic_height' => 'off',
                'use_force_square' => 'off',
            ],
            'toggle_slug' => 'settings',
        ];

        $fields["flip_box_speed"] = [
            'label' => esc_html__('Flip Speed', 'dipi-divi-pixel'),
            'type' => 'range',
            'validate_unit' => true,
            'default' => '600ms',
            'default_unit' => 'ms',
            'range_settings' => array(
                'min' => '0',
                'max' => '2000',
                'step' => '100',
            ),
            'toggle_slug' => 'settings',
        ];

        $fields["flip_box_align_front"] = [
            'label' => esc_html__('Front Horizontal Align', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'center',
            'options' => array(
                'left' => esc_html__('Left', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'right' => esc_html__('Right', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'settings',
        ];
        $fields["flip_box_align_front_vertical"] = [
            'label' => esc_html__('Front Vertical Align', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'center',
            'options' => array(
                'flex-start' => esc_html__('Top', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'flex-end' => esc_html__('Bottom', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'settings',
        ];

        $fields["flip_box_align_back"] = [
            'label' => esc_html__('Back Horizontal Align', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'center',
            'options' => array(
                'left' => esc_html__('Left', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'right' => esc_html__('Right', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'settings',
        ];

        $fields["flip_box_align_back_vertical"] = [
            'label' => esc_html__('Back Vertical Align', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'center',
            'options' => array(
                'flex-start' => esc_html__('Top', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'flex-end' => esc_html__('Bottom', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'settings',
        ];

        $fields["flip_box_animation"] = [
            'label' => esc_html__('Select Flip Animation', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'layout',
            'default' => 'flip_horizontally_ltr',
            'default_on_child' => true,
            'options' => [
                'flip_horizontally_ltr' => esc_html__('Left to Right', 'dipi-divi-pixel'),
                'flip_horizontally_rtl' => esc_html__('Right to Left', 'dipi-divi-pixel'),
                'flip_vertically_ttb' => esc_html__('Top to Bottom', 'dipi-divi-pixel'),
                'flip_vertically_btt' => esc_html__('Bottom to Top', 'dipi-divi-pixel'),
            ],
            'depends_show_if' => 'on',
            'toggle_slug' => 'flip_animation',
        ];

        $fields['use_3d_effect'] = [
            'label' => esc_html__('Use 3D Content Effect', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'flip_animation',
        ];

        $fields['use_3d_flip_box'] = [
            'label' => esc_html__('Use 3D Flip Box', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'flip_animation',
        ];

        $fields["flip_box_3d_flank_color"] = [
            'label' => esc_html__('Flip Box 3D Flank Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'show_if' => [
                'use_3d_flip_box' => 'on',
            ],
            'toggle_slug' => 'flip_animation',
        ];

        $additional_options = [];

        $additional_options['front_side_bg_color'] = [
            'label' => esc_html__('Front Background', 'dipi-divi-pixel'),
            'type' => 'background-field',
            'base_name' => "front_side_bg",
            'context' => "front_side_bg",
            'option_category' => 'layout',
            'custom_color' => true,
            'default' => ET_Global_Settings::get_value('all_buttons_bg_color'),
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => "front_side_background",
            'background_fields' => array_merge(
                $this->generate_background_options('front_side_bg', 'gradient', "advanced", "front_side_background", "front_side_bg_gradient"),
                $this->generate_background_options("front_side_bg", "color", "advanced", "front_side_background", "front_side_bg_color"),
                $this->generate_background_options("front_side_bg", "image", "advanced", "front_side_background", "front_side_bg_image")
            ),
        ];

        $additional_options['back_side_bg_color'] = [
            'label' => esc_html__('Back Background', 'dipi-divi-pixel'),
            'type' => 'background-field',
            'base_name' => "back_side_bg",
            'context' => "back_side_bg",
            'option_category' => 'layout',
            'custom_color' => true,
            'default' => ET_Global_Settings::get_value('all_buttons_bg_color'),
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => "back_side_background",
            'background_fields' => array_merge(
                $this->generate_background_options('back_side_bg', 'gradient', "advanced", "back_side_background", "back_side_bg_gradient"),
                $this->generate_background_options("back_side_bg", "color", "advanced", "back_side_background", "back_side_bg_color"),
                $this->generate_background_options("back_side_bg", "image", "advanced", "back_side_background", "back_side_bg_image")
            ),
        ];

        $additional_options = array_merge($additional_options, $this->generate_background_options("front_side_bg", 'skip', "advanced", "front_side_background", "front_side_bg_gradient"));
        $additional_options = array_merge($additional_options, $this->generate_background_options("front_side_bg", 'skip', "advanced", "front_side_background", "front_side_bg_color"));
        $additional_options = array_merge($additional_options, $this->generate_background_options("front_side_bg", 'skip', "advanced", "front_side_background", "front_side_bg_image"));
        $additional_options = array_merge($additional_options, $this->generate_background_options("back_side_bg", 'skip', "advanced", "back_side_background", "back_side_bg_gradient"));
        $additional_options = array_merge($additional_options, $this->generate_background_options("back_side_bg", 'skip', "advanced", "back_side_background", "back_side_bg_color"));
        $additional_options = array_merge($additional_options, $this->generate_background_options("back_side_bg", 'skip', "advanced", "back_side_background", "back_side_bg_image"));

        return array_merge($fields, $additional_options);
    }

    public function get_advanced_fields_config()
    {

        $advanced_fields = [];

        $advanced_fields["text"] = false;
        $advanced_fields["text_shadow"] = false;
        $advanced_fields["fonts"] = [];
        $advanced_fields["background"] = false;

        $advanced_fields["borders"]["default"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-flip-box-front-side .dipi-flip-box-front-side-wrapper, %%order_class%% .dipi-flip-box-back-side .dipi-flip-box-back-side-wrapper",
                    'border_styles' => "%%order_class%% .dipi-flip-box-front-side .dipi-flip-box-front-side-wrapper, %%order_class%% .dipi-flip-box-back-side .dipi-flip-box-back-side-wrapper",
                ],
            ],
        ];

        $advanced_fields["fonts"]["front_title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-flip-box-front-side .dipi-flip-box-heading",
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'front_text',
            'sub_toggle' => 'title',
            'header_level' => [
                'default' => 'h2',
            ],
            'line_height' => [
                'range_settings' => [
                    'min' => '1',
                    'max' => '3',
                    'step' => '.1',
                ],
            ],
        ];

        $advanced_fields["fonts"]["front_desc"] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-flip-box-front-side .dipi-desc",
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'front_text',
            'sub_toggle' => 'desc',
            'line_height' => [
                'range_settings' => [
                    'min' => '1',
                    'max' => '3',
                    'step' => '.1',
                ],
            ],
        ];

        $advanced_fields["fonts"]["back_title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-flip-box-back-side .dipi-flip-box-heading",
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'back_text',
            'sub_toggle' => 'title',
            'header_level' => [
                'default' => 'h2',
            ],
            'line_height' => [
                'range_settings' => [
                    'min' => '1',
                    'max' => '3',
                    'step' => '.1',
                ],
            ],
        ];

        $advanced_fields["fonts"]["back_desc"] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-flip-box-back-side .dipi-desc",
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'back_text',
            'sub_toggle' => 'desc',
            'line_height' => [
                'range_settings' => [
                    'min' => '1',
                    'max' => '3',
                    'step' => '.1',
                ],
            ],
        ];

        $advanced_fields["box_shadow"]["default"] = [
            'label' => esc_html__('Flip Box Shadow', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-flip-box-front-side .dipi-flip-box-front-side-wrapper, %%order_class%% .dipi-flip-box-back-side .dipi-flip-box-back-side-wrapper",
            ],
        ];

        $advanced_fields['margin_padding'] = [
            'css' => [
                'margin' => "%%order_class%% .dipi-flip-box-front-side, %%order_class%% .dipi-flip-box-back-side",
                'padding' => "%%order_class%% .dipi-flip-box-front-side-innner, %%order_class%% .dipi-flip-box-back-side-innner",
                'important' => 'all',
            ],
        ];

        $advanced_fields['button']["front_button"] = [
            'label' => esc_html__('Front Button', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-front-button",
                'important' => true,
            ],
            'use_alignment' => false,
            'box_shadow' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-front-button",
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-front-button.et_pb_button",
                    'important' => 'all',
                ],
            ],
        ];

        $advanced_fields['button']["back_button"] = [
            'label' => esc_html__('Back Button', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-back-button",
                'important' => 'all',
            ],
            'use_alignment' => false,
            'box_shadow' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-back-button",
                    'important' => true,
                ],
            ],
            'borders' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-back-button",
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-back-button.et_pb_button",
                    'important' => 'all',
                ],
            ],
        ];

        $advanced_fields['borders']['front_image'] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-flip-box-front-side .dipi-image-wrap img",
                    'border_styles' => "%%order_class%% .dipi-flip-box-front-side .dipi-image-wrap img",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'front_icon_image',
            'depends_on' => ['use_front_icon'],
            'depends_show_if' => 'off',
        ];

        $advanced_fields['box_shadow']['front_image'] = [
            'label' => esc_html__('Front Image Box Shadow', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'show_if' => ['use_front_icon' => 'off'],
            'css' => [
                'main' => '%%order_class%% .dipi-flip-box-front-side .dipi-image-wrap img',
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'front_icon_image',
        ];

        $advanced_fields['borders']['back_image'] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-flip-box-back-side .dipi-image-wrap img",
                    'border_styles' => "%%order_class%% .dipi-flip-box-back-side .dipi-image-wrap img",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'back_icon_image',
            'depends_on' => ['use_back_icon'],
            'depends_show_if' => 'off',
        ];

        $advanced_fields['box_shadow']['back_icon_image'] = [
            'label' => esc_html__('Back Image Box Shadow', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'show_if' => ['use_back_icon' => 'off'],
            'css' => [
                'main' => '%%order_class%% .dipi-flip-box-back-side .dipi-image-wrap img',
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'back_icon_image',
        ];

        return $advanced_fields;
    }

    public function _render_front_side($render_slug)
    {
        $front_icon_image = '';
        if ('on' == $this->props['use_front_icon']) {
            $front_icon = et_pb_process_font_icon($this->props['front_icon']);
            $front_circle_icon_class = 'on' === $this->props['front_circle_icon'] ? 'dipi-front-icon-circle' : '';
            $front_border_icon_class = 'on' === $this->props['front_circle_border'] ? 'dipi-front-icon-border' : '';
            $front_icon_image = sprintf(
                '<div class="dipi-front-image-icon-wrap dipi-icon-wrap">
                    <span class="et-pb-icon et-pb-font-icon dipi-flip-box-front-icon %2$s %3$s">
                        %1$s
                    </span>
                </div>',
                esc_attr($front_icon),
                $front_circle_icon_class,
                $front_border_icon_class
            );

            $this->dipi_generate_font_icon_styles($render_slug, 'front_icon', '%%order_class%% .dipi-front-image-icon-wrap .dipi-flip-box-front-icon');

        } else if (isset($this->props['front_image']) && '' !== $this->props['front_image']) {

            $front_image_alt = $this->_esc_attr( 'front_image_alt' );

            $front_icon_image = sprintf(
                '<div class="dipi-front-image-icon-wrap dipi-image-wrap">
                  <img src="%1$s" alt="%2$s">
                </div>',
                esc_attr($this->props['front_image']),
                $front_image_alt
            );
        }

        $front_title_level = $this->props['front_title_level'];
        $front_title = '';
        if ('' !== $this->props['front_title']) {
            $front_title = sprintf(
                '<%2$s class="dipi-flip-box-heading">%1$s</%2$s>',
                esc_attr($this->props['front_title']),
                esc_attr($front_title_level)
            );
        }

        $front_content = '';
        if ('' !== $this->props['front_content']) {
            $front_content = sprintf(
                '<div class="dipi-desc">%1$s</div>',
                $this->process_content($this->props['front_content'])
            );
        }

        $front_button = '';
        if ('on' === $this->props['use_front_button']) {

            $front_button_rel = $this->props['front_button_rel'];
            $front_button_text = $this->props['front_button_text'];
            $front_button_link = $this->props['front_button_link'];
            $front_button_icon = $this->props['front_button_icon'];
            $front_button_target = $this->props['front_button_link_target'];
            $front_button_custom = $this->props['custom_front_button'];

            $front_button = $this->render_button([
                'button_classname' => [" dipi-front-button"],
                'button_custom' => $front_button_custom,
                'button_rel' => $front_button_rel,
                'button_text' => $front_button_text,
                'button_url' => $front_button_link,
                'custom_icon' => $front_button_icon,
                'has_wrapper' => false,
                'url_new_window' => $front_button_target,
            ]);
        }

        $front_parallax_bg = '';
        if ('on' == $this->props["front_side_bg_parallax"]) {
            $front_parallax_bg = $this->process_parallax_image_bg("front_side_bg");
        }

        $front_content_render = '';
        if ('' !== $front_title || '' !== $front_content || '' !== $front_button) {
            $front_content_render = sprintf(
                '<div class="dipi-text">
                    %1$s
                    %2$s
                    %3$s
                </div>',
                $front_title,
                $front_content,
                $front_button
            );
        }

        return sprintf(
            '<div class="dipi-flip-box-front-side">
                <div class="dipi-flip-box-front-side-wrapper">
                    %1$s
                    <div class="dipi-flip-box-front-side-innner">
                        %2$s
                        %3$s
                    </div>
                </div>
            </div>
            ',
            $front_parallax_bg,
            $front_icon_image,
            $front_content_render
        );
    }

    public function _render_back_side($render_slug)
    {
        $back_icon_image = '';
        if ('on' == $this->props['use_back_icon']) {
            $back_icon = et_pb_process_font_icon($this->props['back_icon']);
            $back_circle_icon_class = 'on' === $this->props['back_circle_icon'] ? 'dipi-back-icon-circle' : '';
            $back_border_icon_class = 'on' === $this->props['back_circle_border'] ? 'dipi-back-icon-border' : '';
            $back_icon_image = sprintf(
                '<div class="dipi-back-image-icon-wrap dipi-icon-wrap">
                    <span class="et-pb-icon et-pb-font-icon dipi-flip-box-back-icon %2$s %3$s">%1$s</span>
                </div>',
                esc_attr($back_icon),
                $back_circle_icon_class,
                $back_border_icon_class
            );
            $this->dipi_generate_font_icon_styles($render_slug, 'back_icon', '%%order_class%% .dipi-back-image-icon-wrap .dipi-flip-box-back-icon');
        } else if (isset($this->props['back_image']) && '' !== $this->props['back_image']) {
            $back_image_alt = $this->_esc_attr( 'back_image_alt' );
            $back_icon_image = sprintf(
                '<div class="dipi-back-image-icon-wrap dipi-image-wrap">
                    <img class="dipi-flip-box-back-imge" src="%1$s" alt="%2$s">
                </div>',
                esc_attr($this->props['back_image']),
                $back_image_alt
            );
        }

        $back_title_level = $this->props['back_title_level'];
        $back_title = '';
        if ('' !== $this->props['back_title']) {
            $back_title = sprintf(
                '<%2$s class="dipi-flip-box-heading">
                    %1$s
                </%2$s>',
                esc_attr($this->props['back_title']),
                esc_attr($back_title_level)
            );
        }

        $back_content = '';
        if ('' !== $this->props['back_content']) {
            $back_content = sprintf(
                '<div class="dipi-desc">%1$s</div>',
                $this->process_content($this->props['back_content'])
            );
        }

        $back_button = '';
        if ('on' === $this->props['use_back_button']) {

            $back_button_rel = $this->props['back_button_rel'];
            $back_button_text = $this->props['back_button_text'];
            $back_button_link = $this->props['back_button_link'];
            $back_button_icon = $this->props['back_button_icon'];
            $back_button_target = $this->props['back_button_link_target'];
            $back_button_custom = $this->props['custom_back_button'];
            
            $back_button = $this->render_button([
                'button_classname' => [" dipi-back-button"],
                'button_custom' => $back_button_custom,
                'button_rel' => $back_button_rel,
                'button_text' => $back_button_text,
                'button_url' => $back_button_link,
                'custom_icon' => $back_button_icon,
                'has_wrapper' => false,
                'url_new_window' => $back_button_target,
            ]);
        }

        $back_parallax_bg = '';
        if ('on' == $this->props["back_side_bg_parallax"]) {
            $back_parallax_bg = $this->process_parallax_image_bg("back_side_bg");
        }

        $back_content_render = '';
        if ('' !== $back_title || '' !== $back_content || '' !== $back_button) {
            $back_content_render = sprintf(
                '<div class="dipi-text">
                    %1$s
                    %2$s
                    %3$s
                </div>',
                $back_title,
                $back_content,
                $back_button
            );
        }

        return sprintf(
            '<div class="dipi-flip-box-back-side">
                <div class="dipi-flip-box-back-side-wrapper">
                    %1$s
                    <div class="dipi-flip-box-back-side-innner">
                        %2$s
                        %3$s
                    </div>
                </div>
            </div>',
            $back_parallax_bg,
            $back_icon_image,
            $back_content_render
        );
    }

     /**
     * Render
     */
    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_flip_box_public');
        $this->set_background_css(
            $render_slug,
            "%%order_class%% .dipi-flip-box-front-side .dipi-flip-box-front-side-wrapper",
            "%%order_class%% .dipi-flip-box-front-side .dipi-flip-box-front-side-wrapper:hover",
            'front_side_bg', 
            'front_side_bg_color'
        );
        $this->set_background_css(
            $render_slug,
            "%%order_class%% .dipi-flip-box-back-side .dipi-flip-box-back-side-wrapper",
            "%%order_class%% .dipi-flip-box-back-side .dipi-flip-box-back-side-wrapper:hover",
            'back_side_bg', 
            'back_side_bg_color'
        );
        $this->_dipi_apply_css($render_slug);

        $flip_box_animation = '';

        if ('flip_horizontally_ltr' == $this->props['flip_box_animation'] && 'off' == $this->props['use_3d_flip_box']) {
            $flip_box_animation = 'dipi-flip-left-right';
        } elseif ('flip_horizontally_rtl' == $this->props['flip_box_animation'] && 'off' == $this->props['use_3d_flip_box']) {
            $flip_box_animation = 'dipi-flip-right-left';
        } elseif ('flip_vertically_ttb' == $this->props['flip_box_animation'] && 'off' == $this->props['use_3d_flip_box']) {
            $flip_box_animation = 'dipi-flip-top-bottom';
        } elseif ('flip_vertically_btt' == $this->props['flip_box_animation'] && 'off' == $this->props['use_3d_flip_box']) {
            $flip_box_animation = 'dipi-flip-bottom-top';
        }

        if ('on' == $this->props['use_3d_flip_box']) {
            if ('flip_horizontally_ltr' == $this->props['flip_box_animation']) {
                $flip_box_animation = 'dipi-flip-box-3d-cube dipi-flip-ltr';
            } elseif ('flip_horizontally_rtl' == $this->props['flip_box_animation']) {
                $flip_box_animation = 'dipi-flip-box-3d-cube dipi-flip-rtl';
            } elseif ('flip_vertically_ttb' == $this->props['flip_box_animation']) {
                $flip_box_animation = 'dipi-flip-box-3d-cube dipi-flip-ttb';
            } elseif ('flip_vertically_btt' == $this->props['flip_box_animation']) {
                $flip_box_animation = 'dipi-flip-box-3d-cube dipi-flip-btt';
            }
        }

        $dipi_3d_flank = ('on' == $this->props['use_3d_flip_box']) ? '<div class="dipi-flip-box-3d-flank"></div>' : '';
        $use_3d_effect = ('on' == $this->props['use_3d_effect']) ? 'dipi-3d-flip-box' : '';
        $order_class = self::get_module_order_class($render_slug);

        return sprintf(
            '<div class="dipi-flip-box-container" data-dynamic_height="%6$s" data-force_square="%7$s">
                <div class="dipi-flip-box-inner %3$s %4$s">
                    <div class="dipi-flip-box-inner-wrapper">
                        %1$s
                        %2$s
                        %5$s
                    </div>
                </div>
           </div>',
            $this->_render_front_side($render_slug),
            $this->_render_back_side($render_slug),
            $flip_box_animation,
            $use_3d_effect,
            $dipi_3d_flank,
            $this->props['use_dynamic_height'],
            $this->props['use_force_square']
        );
    }

    /**
     * Custom CSS
     */
    public function _dipi_apply_css($render_slug)
    {
        $this->_dipi_flip_box_height($render_slug);
        $this->_dipi_flip_box_image_width($render_slug);
        $front_icon_color = $this->props['front_icon_color'];
        $front_circle_icon = $this->props['front_circle_icon'];
        $front_circle_color = $this->props['front_circle_color'];
        $front_circle_border = $this->props['front_circle_border'];
        $front_circle_border_color = $this->props['front_circle_border_color'];
        $front_icon_size = $this->props['front_icon_size'];
        $back_icon_color = $this->props['back_icon_color'];
        $back_circle_icon = $this->props['back_circle_icon'];
        $back_circle_color = $this->props['back_circle_color'];
        $back_circle_border = $this->props['back_circle_border'];
        $back_circle_border_color = $this->props['back_circle_border_color'];
        $back_icon_size = $this->props['back_icon_size'];
        $flip_box_speed = $this->props['flip_box_speed'];
        $flip_box_align_front = $this->props['flip_box_align_front'];
        $flip_box_align_back = $this->props['flip_box_align_back'];
        $flip_box_3d_flank_color = $this->props['flip_box_3d_flank_color'];


        $flip_box_align_front_vertical = $this->props['flip_box_align_front_vertical'];
        $flip_box_align_back_vertical = $this->props['flip_box_align_back_vertical'];

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-flip-box-front-side-wrapper',
            'declaration' => "justify-content: {$flip_box_align_front_vertical};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-flip-box-back-side-wrapper',
            'declaration' => "justify-content: {$flip_box_align_back_vertical};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-back-button:after',
            'declaration' => "font-size: inherit !important; line-height: inherit !important;",
        ]);

        if ('on' == $this->props['use_3d_flip_box']) :
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-flip-box-3d-cube',
                'declaration' => "transition-duration: {$flip_box_speed} !important;",
            ]);

        else :

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-flip-box-front-side, %%order_class%% .dipi-flip-box-back-side',
                'declaration' => "transition-duration: {$flip_box_speed} !important;",
            ]);

        endif;

        if ('left' == $flip_box_align_front) :

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-flip-box-front-side-innner',
                'declaration' => "text-align: left !important;",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-front-image-icon-wrap',
                'declaration' => "margin-left: 0 !important; margin-right: auto !important;",
            ]);

        elseif ('center' == $flip_box_align_front) :

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-flip-box-front-side-innner',
                'declaration' => "text-align: center !important;",
            ]);

        elseif ('right' == $flip_box_align_front) :

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-flip-box-front-side-innner',
                'declaration' => "text-align: right !important;",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-front-image-icon-wrap',
                'declaration' => "margin-right: 0 !important; margin-left: auto !important;",
            ]);

        endif;

        if ('left' == $flip_box_align_back) :
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-flip-box-back-side-innner',
                'declaration' => "text-align: left !important;",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-back-image-icon-wrap',
                'declaration' => "margin-right: auto !important; margin-left: 0 !important;",
            ]);

        elseif ('center' == $flip_box_align_back) :

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-flip-box-back-side-innner',
                'declaration' => "text-align: center !important;",
            ]);

        elseif ('right' == $flip_box_align_back) :

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-flip-box-back-side-innner',
                'declaration' => "text-align: right !important;",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-back-image-icon-wrap',
                'declaration' => "margin-right: 0 !important; margin-left: auto !important;",
            ]);

        endif;

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-flip-box-3d-cube .dipi-flip-box-3d-flank',
            'declaration' => "background-color: {$flip_box_3d_flank_color} !important;",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-flip-box-front-side .dipi-flip-box-front-icon',
            'declaration' => "color: {$front_icon_color} !important;",
        ]);

        if ('on' == $front_circle_icon) :
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-flip-box-front-side .dipi-front-icon-circle',
                'declaration' => "background-color: {$front_circle_color} !important;",
            ]);
        endif;

        if ('on' == $front_circle_border) :
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-flip-box-front-side .dipi-front-icon-border',
                'declaration' => "border-color: {$front_circle_border_color} !important;",
            ]);
        endif;

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-flip-box-front-side .dipi-flip-box-front-icon',
            'declaration' => "font-size: {$front_icon_size} !important;",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-flip-box-back-side .dipi-flip-box-back-icon',
            'declaration' => "color: {$back_icon_color} !important;",
        ]);

        if ('on' == $back_circle_icon) :
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-flip-box-back-side .dipi-back-icon-circle',
                'declaration' => "background-color: {$back_circle_color} !important;",
            ]);
        endif;

        if ('on' == $back_circle_border) :
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-flip-box-back-side .dipi-back-icon-border',
                'declaration' => "border-color: {$back_circle_border_color} !important;",
            ]);
        endif;

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-flip-box-back-side .dipi-flip-box-back-icon',
            'declaration' => "font-size: {$back_icon_size} !important;",
        ]);
    }

    private function _dipi_flip_box_height($render_slug)
    {

        $flip_box_height = $this->props['flip_box_height'];
        $flip_box_height_tablet = $this->props['flip_box_height_tablet'] ? $this->props['flip_box_height_tablet'] : $flip_box_height;
        $flip_box_height_phone = $this->props['flip_box_height_phone'] ? $this->props['flip_box_height_phone'] : $flip_box_height_tablet;
        $flip_box_height_last_edited = $this->props['flip_box_height_last_edited'];
        $flip_box_height_responsive_status = et_pb_get_responsive_status($flip_box_height_last_edited);

        if ('off' === $this->props['use_dynamic_height'] && 'off' === $this->props['use_force_square']) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-flip-box-inner-wrapper',
                'declaration' => "height: {$flip_box_height} !important;",
            ]);

            if ('' !== $flip_box_height_tablet && $flip_box_height_responsive_status) {
                ET_Builder_Element::set_style($render_slug, [
                    'selector' => '%%order_class%% .dipi-flip-box-inner-wrapper',
                    'declaration' => "height: {$flip_box_height_tablet} !important;",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                ]);
            }

            if ('' !== $flip_box_height_phone && $flip_box_height_responsive_status) {
                ET_Builder_Element::set_style($render_slug, [
                    'selector' => '%%order_class%% .dipi-flip-box-inner-wrapper',
                    'declaration' => "height: {$flip_box_height_phone} !important;",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ]);
            }
        }
    }

    private function _dipi_flip_box_image_width($render_slug)
    {

        $front_image_width = $this->props['front_image_width'];
        $front_image_width_tablet = $this->props['front_image_width_tablet'] ? $this->props['front_image_width_tablet'] : $front_image_width;
        $front_image_width_phone = $this->props['front_image_width_phone'] ? $this->props['front_image_width_phone'] : $front_image_width_tablet;
        $front_image_width_last_edited = $this->props['front_image_width_last_edited'];
        $front_image_width_responsive_status = et_pb_get_responsive_status($front_image_width_last_edited);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-flip-box-front-side .dipi-image-wrap',
            'declaration' => "max-width: {$front_image_width} !important;",
        ]);

        if ('' !== $front_image_width_tablet && $front_image_width_responsive_status) :
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-flip-box-front-side .dipi-image-wrap',
                'declaration' => "max-width: {$front_image_width_tablet} !important;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ]);
        endif;

        if ('' !== $front_image_width_phone && $front_image_width_responsive_status) :
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-flip-box-front-side .dipi-image-wrap',
                'declaration' => "max-width: {$front_image_width_phone} !important;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ]);
        endif;

        $back_image_width = $this->props['back_image_width'];
        $back_image_width_tablet = $this->props['back_image_width_tablet'] ? $this->props['back_image_width_tablet'] : $back_image_width;
        $back_image_width_phone = $this->props['back_image_width_phone'] ? $this->props['back_image_width_phone'] : $back_image_width_tablet;
        $back_image_width_last_edited = $this->props['back_image_width_last_edited'];
        $back_image_width_responsive_status = et_pb_get_responsive_status($back_image_width_last_edited);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-flip-box-back-side .dipi-image-wrap',
            'declaration' => "max-width: {$back_image_width} !important;",
        ]);

        if ('' !== $back_image_width_tablet && $back_image_width_responsive_status) :
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-flip-box-back-side .dipi-image-wrap',
                'declaration' => "max-width: {$back_image_width_tablet} !important;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ]);
        endif;

        if ('' !== $back_image_width_phone && $back_image_width_responsive_status) :
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-flip-box-back-side .dipi-image-wrap',
                'declaration' => "max-width: {$back_image_width_phone} !important;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ]);
        endif;
    }
}

new DIPI_FlipBox;
