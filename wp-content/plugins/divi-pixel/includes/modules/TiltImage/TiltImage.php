<?php
class DIPI_TiltImage extends DIPI_Builder_Module
{

    public $slug = 'dipi_tilt_image';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/tilt_image',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->vb_support = 'on';
        $this->name = esc_html__('Pixel Tilt Image', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%.dipi_tilt_image';
        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'general' => esc_html__('General', 'dipi-divi-pixel'),
                    'tilt_settings' => esc_html__('Tilt Settings', 'dipi-divi-pixel'),
                    'overlay_content' => esc_html__('Overlay Content', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'overlay' => esc_html__('Overlay', 'dipi-divi-pixel'),
                    'tilt_icon_image' => esc_html__('Image & Icon', 'dipi-divi-pixel'),
                    'alignment' => esc_html__('Alignment', 'dipi-divi-pixel'),
                    'tilt_text' => array(
                        'sub_toggles' => array(
                            'title' => array(
                                'name' => 'Title',
                            ),
                            'description' => array(
                                'name' => 'Desc',
                            ),
                        ),
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__('Tilt Text', 'dipi-divi-pixel'),
                    ),
                ],
            ],
        ];

        add_filter('et_fb_backend_helpers', [$this, 'default_helpers'], 100, 1);
    }

    public function default_helpers ($helpers) {
		$helpers['defaults']['dipi_tilt_image'] = [
			'image' => ET_BUILDER_PLACEHOLDER_LANDSCAPE_IMAGE_DATA
		];
		return $helpers;
	}

    public function get_custom_css_fields_config()
    {

        $fields = [];

        $fields['dipi_icon'] = [
            'label' => esc_html__('Icon', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-tilt-overlay-icon',
        ];

        $fields['dipi_title'] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-tilt-overlay-title',
        ];

        $fields['dipi_description'] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-tilt-overlay-desc',
        ];

        $fields['dipi_button'] = [
            'label' => esc_html__('Button', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-overlay-button',
        ];

        return $fields;
    }

    public function get_fields()
    {

        $fields = [];

        $fields["image"] = [
            'label' => esc_html__('Image', 'dipi-divi-pixel'),
            'type' => 'upload',
            'option_category' => 'basic_option',
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'description' => esc_html__('Upload an image to display as before image', 'dipi-divi-pixel'),
            'hide_metadata' => true,
            'toggle_slug' => 'general',
            'dynamic_content' => 'image',
        ];

        $fields["image_alt"] = [
            'label' => esc_html__('Image Alt Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'description' => esc_html__('Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
            'toggle_slug' => 'general',
            'dynamic_content' => 'image',
        ];

        $fields["titl_image_box_height"] = [
            'label' => esc_html__('Tilt Image Box Height', 'dipi-divi-pixel'),
            'type' => 'range',
            'validate_unit' => true,
            'default' => '380px',
            'default_on_front' => '380px',
            'default_unit' => 'px',
            'range_settings' => [
                'min' => '0',
                'max' => '1000',
                'step' => '1',
            ],
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug' => 'general',
        ];

        $fields["tilt_max"] = [
            'label' => esc_html__('Max Tilt Rotation', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '15',
            'unitless' => true,
            'range_settings' => [
                'min' => '0',
                'max' => '60',
                'step' => '1',
            ],
            'toggle_slug' => 'tilt_settings',
        ];

        $fields["tilt_speed"] = [
            'label' => esc_html__('Tilt Speed', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '600',
            'unitless' => true,
            'range_settings' => [
                'min' => '0',
                'max' => '2000',
                'step' => '100',
            ],
            'toggle_slug' => 'tilt_settings',
        ];

        $fields["tilt_perspective"] = [
            'label' => esc_html__('Tilt Perspective', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '1000',
            'unitless' => true,
            'range_settings' => [
                'min' => '0',
                'max' => '2000',
                'step' => '10',
            ],
            'toggle_slug' => 'tilt_settings',
        ];

        $fields["tilt_scale"] = [
            'label' => esc_html__('Tilt Scale', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '1',
            'unitless' => true,
            'range_settings' => [
                'min' => '0',
                'max' => '2',
                'step' => '.01',
            ],
            'toggle_slug' => 'tilt_settings',
        ];

        $fields["tilt_reverse"] = [
            'label' => esc_html__('Reverse Direction', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'default_on_front' => 'on',
            'toggle_slug' => 'tilt_settings',
        ];

        $fields["use_tilt_glare"]    = [
            'label' => esc_html__('Use Glare Effect', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category'  => 'configuration',
            'options' => [
                'on'  => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'default_on_front' => 'off',
            'toggle_slug'         => 'tilt_settings'
        ];

        $fields["tilt_glare"] = [
            'label' => esc_html__('Glare Effect', 'dipi-divi-pixel'),
            'type' => 'range',
            'unitless' => true,
            'validate_unit' => true,
            'default' => '1',
            'default_unit' => '',
            'default_on_front' => '1',
            'range_settings' => [
                'min' => '0.1',
                'max' => '1',
                'step' => '0.1',
            ],
            'show_if' => ['use_tilt_glare' => 'on'],
            'toggle_slug' => 'tilt_settings'
        ];

        $fields["tilt_parallax"] = [
            'label' => esc_html__('Parallax/3D Pop Out Effect', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'default' => 'on',
            'toggle_slug' => 'tilt_settings',
            'affects' => [
                'tilt_parallax_value',
            ],
        ];

        $fields["tilt_parallax_value"] = [
            'label' => esc_html__('Parallax/3D Pop Out', 'dipi-divi-pixel'),
            'type' => 'range',
            'validate_unit' => true,
            'default' => '48px',
            'default_on_front' => '48px',
            'default_unit' => 'px',
            'range_settings' => [
                'min' => '0',
                'max' => '150',
                'step' => '1',
            ],
            'depends_show_if' => 'on',
            'toggle_slug' => 'tilt_settings',
        ];

        /**
         * Overlay Content
         */
        $fields["tilt_overlay_icon"] = [
            'label' => esc_html__('Show Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'overlay_content',
            'affects' => [
                'tilt_overlay_font_icon',
                'tilt_overlay_icon_size',
                'tilt_overlay_icon_color',
                'tilt_overlay_circle_icon',
                'tilt_overlay_circle_color',
                'tilt_overlay_circle_border',
                'tilt_overlay_circle_border_color',
            ],
        ];

        $fields["tilt_overlay_image"] = [
            'label' => esc_html__('Image', 'dipi-divi-pixel'),
            'type' => 'upload',
            'option_category' => 'basic_option',
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'hide_metadata' => true,
            'toggle_slug' => 'overlay_content',
            'show_if' => ['tilt_overlay_icon' => 'off'],
            'dynamic_content' => 'image',
        ];

        $fields["img_alt"] = [
            'label' => esc_html__('Image Alt Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'description' => esc_html__('Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
            'toggle_slug' => 'overlay_content',
            'show_if' => ['tilt_overlay_icon' => 'off'],
        ];

        $fields["tilt_overlay_image_width"] = [
            'label' => esc_html__('Image Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '100%',
            'default_unit' => '%',
            'validate_unit' => true,
            'range_settings' => [
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ],
            'show_if' => ['tilt_overlay_icon' => 'off'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'width',
        ];

        $fields["tilt_overlay_font_icon"] = [
            'label' => esc_html__('Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'option_category' => 'basic_option',
            'class' => array('et-pb-font-icon'),
            'toggle_slug' => 'overlay_content',
            'depends_show_if' => 'on',
        ];

        
        $fields['icon_image_padding'] = [
            'label' => esc_html__('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '10px|10px|10px|10px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'tilt_icon_image',
            'tab_slug'          => 'advanced',
            'show_if' => ['tilt_overlay_icon' => 'on']
        ];

        $fields['icon_image_margin'] = [
            'label' => esc_html__('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'tilt_icon_image',
            'tab_slug'          => 'advanced',
            'show_if' => ['tilt_overlay_icon' => 'on']
        ];

        $fields["tilt_overlay_icon_color"] = [
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#7EBEC5',
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tilt_icon_image',
        ];

        $fields["tilt_overlay_circle_icon"] = [
            'label' => esc_html__('Circle Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'default' => 'off',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tilt_icon_image',
        ];

        $fields["tilt_overlay_circle_color"] = [
            'label' => esc_html__('Circle Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'show_if' => array(
                'tilt_overlay_circle_icon' => 'on',
            ),
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tilt_icon_image',
        ];

        $fields["tilt_overlay_circle_border"] = [
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
            'toggle_slug' => 'tilt_icon_image',
        ];

        $fields["tilt_overlay_circle_border_color"] = [
            'label' => esc_html__('Circle Border Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'show_if' => [
                'tilt_overlay_circle_border' => 'on',
            ],
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tilt_icon_image',
        ];

        $fields["tilt_overlay_icon_size"] = [
            'label' => esc_html__('Icon Font Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'validate_unit' => true,
            'default' => '60px',
            'default_unit' => 'px',
            'range_settings' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tilt_icon_image',
        ];

        $fields["tilt_overlay_color"] = [
            'label' => esc_html__('Overlay Color', 'et_builder'),
            'type' => 'color-alpha',
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'overlay',
        ];

        $fields["tilt_overlay_title"] = [
            'label' => esc_html__('Show Title', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'default' => 'off',
            'toggle_slug' => 'overlay_content',
            'affects' => [
                'tilt_overlay_title_text',
            ],
        ];

        $fields["tilt_overlay_title_text"] = [
            'label' => esc_html__('Overlay Title', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'depends_show_if' => 'on',
            'toggle_slug' => 'overlay_content',
        ];

        $fields["tilt_overlay_desc"] = [
            'label' => esc_html__('Show Description', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'default' => 'off',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'overlay_content',
            'affects' => [
                'tilt_overlay_desc_text',
            ],
        ];

        $fields["tilt_overlay_desc_text"] = [
            'label' => esc_html__('Overlay Description', 'dipi-divi-pixel'),
            'type' => 'tiny_mce',
            'toggle_slug' => 'overlay_content',
            'option_category' => 'basic_option',
            'depends_show_if' => 'on',
            'dynamic_content' => 'text',
            'mobile_options' => true,
        ];

        $fields["tilt_overlay_btn"] = [
            'label' => esc_html__('Show Button', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'default' => 'off',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'overlay_content',
        ];

        $fields["tilt_overlay_btn_text"] = [
            'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'default' => esc_html__('Click Here', 'dipi-divi-pixel'),
            'toggle_slug' => 'overlay_content',
            'depends_show_if' => 'on',
            'depends_on' => [
                'tilt_overlay_btn',
            ],
        ];

        $fields["tilt_overlay_btn_link"] = [
            'label' => esc_html__('Button Link', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'depends_show_if' => 'on',
            'depends_on' => [
                'tilt_overlay_btn',
            ],
            'toggle_slug' => 'overlay_content',
        ];

        $fields["tilt_overlay_btn_link_target"] = [
            'label' => esc_html__('Button Link Target', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'in_same_window',
            'options' => array(
                'off' => esc_html__('Same Window', 'dipi-divi-pixel'),
                'on' => esc_html__('New Window', 'dipi-divi-pixel'),
            ),
            'depends_show_if' => 'on',
            'depends_on' => [
                'tilt_overlay_btn',
            ],
            'toggle_slug' => 'overlay_content',
        ];

        $fields["tilt_overlay_align_vertical"] = [
            'label' => esc_html__('Content Align Vertical', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'middle',
            'options' => array(
                'top' => esc_html__('Top', 'dipi-divi-pixel'),
                'middle' => esc_html__('Middle', 'dipi-divi-pixel'),
                'bottom' => esc_html__('Bottom', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'alignment',
            'tab_slug' => 'advanced',
        ];

        $fields["tilt_overlay_align_horizontal"] = [
            'label' => esc_html__('Content Align Horizontal', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'center',
            'options' => array(
                'left' => esc_html__('Left', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'right' => esc_html__('Right', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'alignment',
            'tab_slug' => 'advanced',
        ];

        $fields["tilt_center_mobile"] = [
            'label' => esc_html__('Always Center Image On Mobile', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'default' => 'on',
            'toggle_slug' => 'alignment',
            'tab_slug' => 'advanced',
        ];

        return $fields;
    }

    public function get_advanced_fields_config()
    {

        $advanced_fields = [];
        $advanced_fields["text"] = false;
        $advanced_fields["text_shadow"] = false;
        $advanced_fields["fonts"] = [];

        $advanced_fields['margin_padding'] = [
            'css' => [
                'margin' => '%%order_class%%',
                'padding' => '%%order_class%%',
                'important' => 'all',
            ],
        ];

        $advanced_fields['background'] = [
            'css' => [
                'main' => '%%order_class%% .dipi-tilt-image',
                'important' => 'all',
            ],
        ];

        $advanced_fields['borders']['image'] = [
            'label' => esc_html__('Image Box Border', 'dipi-divi-pixel'),
            'depends_on' => ['tilt_overlay_icon'],
            'depends_show_if' => 'off',
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-tilt-overlay-image-icon-wrap img",
                    'border_styles' => "%%order_class%% .dipi-tilt-overlay-image-icon-wrap img",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tilt_icon_image',
        ];

        $advanced_fields['box_shadow']['image'] = [
            'label' => esc_html__('Image Box Shadow', 'dipi-divi-pixel'),
            'css' => [
                'main' => '%%order_class%% .dipi-tilt-overlay-image-icon-wrap img',
                'overlay' => 'inset',
            ],
            'show_if' => ['tilt_overlay_icon' => 'off'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tilt_icon_image',
        ];

        $advanced_fields["box_shadow"]["default"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-tilt-image",
            ],
            'tab_slug' => 'advanced',
        ];

        $advanced_fields["borders"]["default"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-tilt-image",
                    'border_styles' => "%%order_class%% .dipi-tilt-image",
                ],
            ],
            'tab_slug' => 'advanced',
        ];

        $advanced_fields["fonts"]["title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => "{$this->main_css_element} h1.dipi-tilt-overlay-title, {$this->main_css_element} h2.dipi-tilt-overlay-title, {$this->main_css_element} h3.dipi-tilt-overlay-title, {$this->main_css_element} h4.dipi-tilt-overlay-title, {$this->main_css_element} h5.dipi-tilt-overlay-title, {$this->main_css_element} h6.dipi-tilt-overlay-title",
            ],
            // 'font_size' => [
            //     'default' => '26px',
            // ],
            'line_height' => [
                'default' => '1',
                'range_settings' => [
                    'min' => '0',
                    'max' => '3',
                    'step' => '.1',
                ],
            ],
            'header_level' => [
                'default' => 'h2',
            ],
            // 'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'tilt_text',
            'sub_toggle' => 'title',
        ];

        $advanced_fields["fonts"]["desc"] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-tilt-overlay-desc",
            ],
            // 'font_size' => [
            //     'default' => '15px',
            // ],
            // 'line_height' => [
            //     'range_settings' => [
            //         'min'  => '1',
            //         'max'  => '3',
            //         'step' => '.1'
            //     ],
            // ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'tilt_text',
            'sub_toggle' => 'description',
        ];

        $advanced_fields['button']["tilt_button"] = [
            'label' => esc_html__('Button', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-overlay-button",
                'alignment' => "%%order_class%% .dipi-tilt-image-wrap",
            ],
            'use_alignment' => false,
            'box_shadow' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-overlay-button",
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'margin' => "%%order_class%% .dipi-tilt-overlay-btn",
                    'padding' => "%%order_class%% .dipi-overlay-button",
                    'important' => 'all',
                ],
            ],
        ];

        return $advanced_fields;
    }

    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_vanilla_tilt');
        $tilt_max = $this->props['tilt_max'];
        $tilt_speed = $this->props['tilt_speed'];
        $tilt_perspective = $this->props['tilt_perspective'];
        $tilt_scale = $this->props['tilt_scale'];

        $use_tilt_glare = $this->props['use_tilt_glare'];
        $tilt_glare_value = $this->props['tilt_glare'];
        $tilt_parallax = $this->props['tilt_parallax'];
        $tilt_parallax_value = $this->props['tilt_parallax_value'];

        $tilt_overlay_icon = $this->props['tilt_overlay_icon'];
        $tilt_overlay_font_icon = $this->props['tilt_overlay_font_icon'];
        $tilt_overlay_icon_color = $this->props['tilt_overlay_icon_color'];
        $tilt_overlay_circle_icon = $this->props['tilt_overlay_circle_icon'];
        $tilt_overlay_circle_color = $this->props['tilt_overlay_circle_color'];
        $tilt_overlay_circle_border = $this->props['tilt_overlay_circle_border'];
        $tilt_overlay_circle_border_color = $this->props['tilt_overlay_circle_border_color'];
        $tilt_overlay_color = $this->props['tilt_overlay_color'];
        $tilt_overlay_icon_size = $this->props['tilt_overlay_icon_size'];
        $tilt_overlay_title = $this->props['tilt_overlay_title'];
        $tilt_overlay_title_text = $this->props['tilt_overlay_title_text'];
        $tilt_overlay_desc = $this->props['tilt_overlay_desc'];
        $tilt_overlay_desc_text = $this->process_content($this->props['tilt_overlay_desc_text']);

        $tilt_center_mobile = $this->props['tilt_center_mobile'];
        $tilt_overlay_align_vertical = $this->props['tilt_overlay_align_vertical'];
        $tilt_overlay_align_horizontal = $this->props['tilt_overlay_align_horizontal'];
        $tilt_overlay_image_width = $this->props['tilt_overlay_image_width'];

        $titl_image_box_height = $this->props['titl_image_box_height'];
        $titl_image_box_height_tablet = $this->props['titl_image_box_height_tablet'] ? $this->props['titl_image_box_height_tablet'] : $titl_image_box_height;
        $titl_image_box_height_phone = $this->props['titl_image_box_height_phone'] ? $this->props['titl_image_box_height_phone'] : $titl_image_box_height_tablet;
        $titl_image_box_height_last_edited = $this->props['titl_image_box_height_last_edited'];
        $titl_image_box_height_responsive_status = et_pb_get_responsive_status($titl_image_box_height_last_edited);

        if($this->props['tilt_overlay_icon'] === 'on') {
            $this->dipi_process_spacing_field([
                'render_slug'    => $render_slug,
                'slug'           => 'icon_image_padding',
                'css_property'   => 'padding',
                'selector'       => "%%order_class%% .dipi-tilt-overlay-icon-circle"
            ]);
            
            $this->dipi_process_spacing_field([
                'render_slug'    => $render_slug,
                'slug'           => 'icon_image_margin',
                'css_property'   => 'margin',
                'selector'       => "%%order_class%% .dipi-tilt-overlay-icon-circle"
            ]);
        }
        
        if ('' !== $titl_image_box_height) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tilt-image-wrap, %%order_class%% .dipi-tilt-image-overlay',
                'declaration' => "height: {$titl_image_box_height}!important;",
            ]);
        }

        if ('' !== $titl_image_box_height_tablet && $titl_image_box_height_responsive_status) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tilt-image-wrap, %%order_class%% .dipi-tilt-image-overlay',
                'declaration' => "height: {$titl_image_box_height_tablet} !important;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ]);
        }

        if ('' !== $titl_image_box_height_phone && $titl_image_box_height_responsive_status) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tilt-image-wrap, %%order_class%% .dipi-tilt-image-overlay',
                'declaration' => "height: {$titl_image_box_height_phone} !important;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ]);
        }

        /**
         * Vertical Align
         */
        if ('top' == $tilt_overlay_align_vertical) {

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tilt-overlay',
                'declaration' => "align-items: flex-start;",
            ]);

        } elseif ('middle' == $tilt_overlay_align_vertical) {

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tilt-overlay',
                'declaration' => "align-items: center;",
            ]);

        } elseif ('bottom' == $tilt_overlay_align_vertical) {

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tilt-overlay',
                'declaration' => "align-items: flex-end;",
            ]);

        }

        /**
         * Horizontal Align
         */
        if ('left' == $tilt_overlay_align_horizontal) {

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tilt-overlay',
                'declaration' => "text-align: left;",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tilt-overlay-image-icon-wrap',
                'declaration' => "margin-left: 0 !important; margin-right: auto !important;",
            ]);

        } elseif ('center' == $tilt_overlay_align_horizontal) {

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tilt-overlay',
                'declaration' => "text-align: center;",
            ]);

        } elseif ('right' == $tilt_overlay_align_horizontal) {

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tilt-overlay',
                'declaration' => "text-align: right;",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tilt-overlay-image-icon-wrap',
                'declaration' => "margin-right: 0 !important; margin-left: auto !important;",
            ]);

        }

        /**
         * Prallax
         */
        if ('on' == $tilt_parallax) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tilt-image',
                'declaration' => "transform-style: preserve-3d !important;",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tilt-overlay',
                'declaration' => "transform: translateZ({$tilt_parallax_value});",
            ]);
        }

        /**
         * Mobile Always Align Center
         */
        if ('on' == $tilt_center_mobile) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tilt-overlay',
                'declaration' => "text-align: center !important; align-items: center  !important;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ]);
        }

        /**
         * Mix Styles
         */
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-tilt-image-overlay',
            'declaration' => "background-color: {$tilt_overlay_color};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-tilt-overlay-icon',
            'declaration' => "color: {$tilt_overlay_icon_color};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-tilt-overlay-icon',
            'declaration' => "font-size: {$tilt_overlay_icon_size};",
        ]);

        if ('on' == $tilt_overlay_circle_icon) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tilt-overlay-icon-circle',
                'declaration' => "background-color: {$tilt_overlay_circle_color};",
            ]);
        }

        if ('on' == $tilt_overlay_circle_border) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tilt-overlay-icon-border',
                'declaration' => "border-color: {$tilt_overlay_circle_border_color};",
            ]);
        }

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-tilt-overlay-image-icon-wrap',
            'declaration' => "max-width: {$tilt_overlay_image_width}!important;",
        ]);

        $tilt_reverse = 'off' !== $this->props['tilt_reverse'] ? 'data-tilt-reverse=true' : 'data-tilt-reverse=false';
        $tilt_glare = 'off' !== $use_tilt_glare ? esc_attr("data-tilt-glare=true data-tilt-max-glare=$tilt_glare_value") : '';

        /**
         * Data options
         */
        $data_tilt_options = sprintf(
            'data-tilt-max="%1$s"
            data-tilt-speed="%2$s"
            data-tilt-perspective="%3$s"
            data-tilt-scale="%4$s"
            %5$s %6$s',
            esc_attr($tilt_max),
            esc_attr($tilt_speed),
            esc_attr($tilt_perspective),
            esc_attr($tilt_scale),
            esc_attr($tilt_reverse),
            esc_attr( $tilt_glare )
        );
        // die();

        /**
         * Overlay Icon
         */
        $tilt_overlay_icon_render = '';

        if ('on' === $tilt_overlay_icon && '' !== $tilt_overlay_font_icon) {
            $circle_icon_class = ('on' === $tilt_overlay_circle_icon) ? 'dipi-tilt-overlay-icon-circle' : '';
            $border_icon_class = ('on' === $tilt_overlay_circle_border) ? 'dipi-tilt-overlay-icon-border' : '';

            $tilt_overlay_icon_render = sprintf(
                '<span class="et-pb-icon dipi-tilt-overlay-icon dipi-tilt-overlay-image-icon-wrap %2$s %3$s">
                    %1$s
                </span>',
                esc_attr(et_pb_process_font_icon($tilt_overlay_font_icon)),
                esc_attr($circle_icon_class),
                esc_attr($border_icon_class)
            );
            $this->dipi_generate_font_icon_styles($render_slug, 'tilt_overlay_font_icon', '%%order_class%% .dipi-tilt-overlay-icon');

        } else if ('on' !== $tilt_overlay_icon && '' !== $this->props['tilt_overlay_image']) {
            $img_alt = $this->props['img_alt'];
            $tilt_overlay_icon_render = sprintf(
                '<div class="dipi-tilt-overlay-image-icon-wrap"><img src="%1$s" alt="%2$s"></div>',
                esc_attr($this->props['tilt_overlay_image']),
                esc_attr($img_alt)
            );
        }

        /**
         * Overlay Title
         */
        if ('on' === $tilt_overlay_title) {
            $title_level = $this->props['title_level'];
            $tilt_overlay_title_render = ('' !== $tilt_overlay_title_text) ? sprintf(
                '<%2$s class="dipi-tilt-overlay-title">
                    <span>%1$s</span>
                </%2$s>',
                esc_attr($tilt_overlay_title_text),
                esc_attr($title_level)
            ) : '';
        } else {
            $tilt_overlay_title_render = '';
        }

        /**
         * Overlay Hover Description
         */
        $tilt_overlay_desc_render = '';
        if ('on' === $tilt_overlay_desc && '' !== $tilt_overlay_desc_text) {
            $tilt_overlay_desc_render = sprintf(
                '<div class="dipi-tilt-overlay-desc">%1$s</div>',
                $tilt_overlay_desc_text
            );
        }

        /**
         * Overlay Button
         */
        $tilt_overlay_btn_render = '';
        if ('on' === $this->props['tilt_overlay_btn']) {

            $tilt_overlay_btn_text = $this->props['tilt_overlay_btn_text'];
            $tilt_overlay_btn_link = $this->props['tilt_overlay_btn_link'];
            $open_new_window = $this->props['tilt_overlay_btn_link_target'];
            $button_custom = $this->props['custom_tilt_button'];
            $tilt_button_rel = $this->props['tilt_button_rel'];
            $tilt_overlay_btn_icon = $this->props['tilt_button_icon'];

            $tilt_overlay_btn_render = $this->render_button([
                'button_classname' => ["dipi-overlay-button"],
                'button_rel' => $tilt_button_rel,
                'button_text' => $tilt_overlay_btn_text,
                'button_url' => $tilt_overlay_btn_link,
                'custom_icon' => $tilt_overlay_btn_icon,
                'has_wrapper' => false,
                'url_new_window' => $open_new_window,
                'button_custom' => $button_custom,
            ]);
        }

        /**
         * Data Content
         */
        $tilt_overlay_content_render = sprintf(
            '<div class="dipi-tilt-overlay">
              <div class="dipi-tilt-overlay-wrap">
                %1$s
                %2$s
                %3$s
                %4$s
              </div>
            </div>',
            $tilt_overlay_icon_render,
            $tilt_overlay_title_render,
            $tilt_overlay_desc_render,
            $tilt_overlay_btn_render
        );

        if (isset($this->props['image']) && '' !== $this->props['image']) {
            $image = sprintf(
                '<img src="%1$s" alt="%2$s">',
                esc_attr($this->props['image']),
                esc_attr($this->props['image_alt'])

            );
        } else {
            $image = '';
        }

        return sprintf(
            '<div class="dipi-tilt-image" data-tilt="" %1$s>
                <div class="dipi-tilt-image-wrap">
                    %2$s
                    <div class="dipi-tilt-image-overlay"></div>
                    %3$s
                </div>
            </div>',
            $data_tilt_options,
            $image,
            $tilt_overlay_content_render
        );
    }
}

new DIPI_TiltImage;
