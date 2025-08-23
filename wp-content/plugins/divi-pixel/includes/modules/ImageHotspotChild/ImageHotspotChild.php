<?php

class DIPI_ImageHotspotChild extends DIPI_Builder_Module
{

    public function init()
    {
        $this->name = esc_html__('Hotspot', 'dipi-divi-pixel');
        $this->plural = esc_html__('Hotspots', 'dipi-divi-pixel');
        $this->slug = 'dipi_image_hotspot_child';
        $this->vb_support = 'on';
        $this->type = 'child';
        $this->child_title_var = 'title';
        $this->advanced_setting_tooltip_title = esc_html__('New Hotspot', 'dipi-divi-pixel');
        $this->settings_text = esc_html__('Hotspot', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%';
    }

    public function get_settings_modal_toggles()
    {
        return [
            'general' => [
                'toggles' => [
                    'hotspot' => esc_html__('Hotspot Image/Icon', 'dipi-divi-pixel'),
                    'tooltip' => esc_html__('Tooltip', 'dipi-divi-pixel'),
                    'settings' => esc_html__('Settings', 'dipi-divi-pixel'),
                    'link_settings' => esc_html__('Link', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'hotspot_icon_image' => esc_html__('Hotspot', 'dipi-divi-pixel'),
                    'hotspot_ripple_effect' => esc_html__('Hotspot Ripple Effect', 'dipi-divi-pixel'),
                    'tooltip_styles' => esc_html__('Tooltip Image/Icon', 'dipi-divi-pixel'),
                    'tooltip_text' => [
                        'sub_toggles' => [
                            'title' => [
                                'name' => 'Title',
                            ],
                            'desc' => [
                                'name' => 'Description',
                            ],
                        ],
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__('Tooltip Text', 'dipi-divi-pixel'),
                        'priority' => 49,
                    ],
                    'tooltip_box' => esc_html__('Tooltip Box', 'dipi-divi-pixel'),
                ],
            ],
        ];
    }

    public function get_fields()
    {

        $fields = [];

        $fields["module_id"] = [
            'label' => esc_html__('CSS ID', 'dipi-divi-pixel'),
            'type' => 'text',
            'tab_slug' => 'custom_css',
            'toggle_slug' => 'classes',
        ];

        $fields["module_class"] = [
            'label' => esc_html__('CSS Class', 'dipi-divi-pixel'),
            'type' => 'text',
            'tab_slug' => 'custom_css',
            'toggle_slug' => 'classes',
        ];
        
        $fields["title"] = [
            'label' => esc_html__('Admin Label', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => 'Hotspot',
            'toggle_slug' => 'hotspot',
        ];

        $fields['use_hotspot_icon'] = [
            'label' => esc_html__('Use Custom Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'hotspot',
            'affects' => [
                'hotspot_icon',
                'hotspot_icon_color',
                'hotspot_circle_icon',
                'hotspot_circle_color',
                'hotspot_circle_border',
                'hotspot_circle_border_color',
                'use_hotspot_icon_font_size',
                'hotspot_icon_size',
                'hotspot_image',
                'img_alt',
                'hotspot_image_width',
            ],
        ];

        $fields["hotspot_image"] = [
            'label' => esc_html__('Image', 'dipi-divi-pixel'),
            'type' => 'upload',
            'option_category' => 'basic_option',
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'hide_metadata' => true,
            'depends_show_if' => 'off',
            'toggle_slug' => 'hotspot',
            'dynamic_content' => 'image'
        ];

        $fields["img_alt"] = [
            'label' => esc_html__('Image Alt Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'description' => esc_html__('Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
            'depends_show_if' => 'off',
            'toggle_slug' => 'hotspot',
            'dynamic_content' => 'text'
        ];

        $fields["hotspot_image_width"] = [
            'label' => esc_html__('Hotspot Image Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'validate_unit' => true,
            'default' => '100px',
            'default_unit' => 'px',
            'default_on_front' => '100px',
            'allowed_units' => ['px'],
            'depends_show_if' => 'off',
            'range_settings' => [
                'min' => '0',
                'max' => '1000',
                'step' => '10',
            ],
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'hotspot_icon_image',
        ];

        $fields['hotspot_icon'] = [
            'label' => esc_html__('Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'option_category' => 'basic_option',
            'default' => '5',
            'depends_show_if' => 'on',
            'toggle_slug' => 'hotspot',
        ];

        $fields["hotspot_icon_color"] = [
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#7EBEC5',
            'depends_show_if' => 'on',
            'hover' => 'tabs',
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'hotspot_icon_image',
        ];
        $fields['hotspot_icon_padding'] = [
            'label'   => esc_html__('Icon Padding', 'dipi-divi-pixel'),
            'type'    => 'custom_margin',
            'hover'   => 'tabs',
            'default' => '15px|15px|15px|15px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'hotspot_icon_image',
            'show_if' => array(
                'use_hotspot_icon' => 'on',
            ),
        ];
        $fields["hotspot_circle_icon"] = [
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
            'toggle_slug' => 'hotspot_icon_image',
        ];

        $fields["hotspot_circle_color"] = [
            'label' => esc_html__('Circle Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'hover' => 'tabs',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'hotspot_icon_image',
            'show_if' => array(
                'hotspot_circle_icon' => 'on',
            ),
        ];

        $fields["hotspot_circle_border"] = [
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
            'toggle_slug' => 'hotspot_icon_image',
            'show_if' => array(
                'hotspot_circle_icon' => 'on',
            ),
        ];

        $fields["hotspot_circle_border_color"] = [
            'label' => esc_html__('Circle Border Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'hover' => 'tabs',
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'hotspot_icon_image',
            'show_if' => array(
                'hotspot_circle_icon' => 'on',
                'hotspot_circle_border' => 'on',
            ),
        ];

        $fields["use_hotspot_icon_font_size"] = [
            'label' => esc_html__('Use Icon Font Size', 'et_builder'),
            'type' => 'yes_no_button',
            'option_category' => 'font_option',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default_on_front' => 'off',
            'depends_show_if' => 'on',
            'hover' => 'tabs',
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'hotspot_icon_image',
        ];

        $fields["hotspot_icon_size"] = [
            'label' => esc_html__('Icon Font Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '24px',
            'default_on_front' => '24px',
            'default_unit' => 'px',
            'range_settings' => [
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ],
            'depends_show_if' => 'on',
            'validate_unit' => true,
            'hover' => 'tabs',
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'hotspot_icon_image',
            'show_if' => array(
                'use_hotspot_icon_font_size' => 'on',
            ),
        ];

        $fields["hotspot_ripple_effect"] = [
            'label' => esc_html__('Hotspot Ripple Effect', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'hotspot_ripple_effect',
        ];

        $fields["hotspot_ripple_effect_style"] = [
            'label' => esc_html__('Ripple Effect Style', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'style-1',
            'options' => [
                'style-1' => esc_html__('Style 1', 'dipi-divi-pixel'),
                'style-2' => esc_html__('Style 2', 'dipi-divi-pixel'),
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'hotspot_ripple_effect',
            'show_if' => ['hotspot_ripple_effect' => 'on'],
        ];

        $fields["hotspot_ripple_effect_color"] = [
            'label' => esc_html__('Hotspot Ripple Effect Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'hotspot_ripple_effect',
            'show_if' => [
                'hotspot_ripple_effect' => 'on',
            ],
        ];

        $fields["hotspot_ripple_effect_size"] = [
            'label' => esc_html__('Hotspot Ripple Effect Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '100px',
            'default_unit' => 'px',
            'range_settings' => [
                'min' => '0',
                'max' => '200',
                'step' => '1',
            ],
            'tab_slug' => 'advanced',
            'mobile_options' => true,
            'toggle_slug' => 'hotspot_ripple_effect',
            'show_if' => [
                'hotspot_ripple_effect' => 'on',
                'hotspot_ripple_effect_style' => 'style-2',
            ],
        ];

        $fields["hotspot_ripple_effect_speed"] = [
            'label' => esc_html__('Hotspot Ripple Effect Speed', 'dipi-divi-pixel'),
            'type' => 'range',
            'unitless' => true,
            'default' => '2.5',
            'range_settings' => [
                'min' => '1',
                'max' => '5',
                'step' => '0.1',
            ],
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'hotspot_ripple_effect',
            'show_if' => [
                'hotspot_ripple_effect' => 'on',
                'hotspot_ripple_effect_style' => 'style-2',
            ],
        ];

        $fields["hotspot_position_vertical"] = [
            'label' => esc_html__('Hotspot Position Vertical', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '10%',
            'default_unit' => '%',
            'range_settings' => [
                'min' => '0',
                'max' => '100',
                'step' => '.1',
            ],
            'validate_unit' => true,
            'toggle_slug' => 'settings',
            'mobile_options' => true,
        ];

        $fields["hotspot_position_horizontal"] = [
            'label' => esc_html__('Hotspot Position Horizontal', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '10%',
            'default_unit' => '%',
            'range_settings' => [
                'min' => '0',
                'max' => '100',
                'step' => '.1',
            ],
            'validate_unit' => true,
            'toggle_slug' => 'settings',
            'mobile_options' => true,
        ];

        $fields["type"] = [
            'label' => esc_html__('Content Type', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => [
                'default' => esc_html__('Default', 'dipi-divi-pixel'),
                'library' => esc_html__('Divi Library', 'dipi-divi-pixel'),
            ],
            'default' => 'default',
            'toggle_slug' => 'tooltip',
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
        ];

        $fields["library_id"] = [
            'label' => esc_html__('Divi Library', 'dipi-divi-pixel'),
            'options' => $this->get_divi_layouts(),
            'type' => 'select',
            'computed_affects' => [
                '__gethtmllibary',
            ],
            'toggle_slug' => 'tooltip',
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
            'show_if' => [
                'type' => 'library',
            ],
        ];

        $fields["use_tooltip_icon"] = [
            'label' => esc_html__('Use Tooltip Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default_on_front' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'tooltip',
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
            'show_if' => [
                'type' => 'default',
            ],
        ];

        $fields["tooltip_icon"] = [
            'label' => esc_html__('Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'option_category' => 'basic_option',
            'toggle_slug' => 'tooltip',
            'class' => ['et-pb-font-icon'],
            'default' => '1',
            'hover' => 'tabs',
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
            'show_if' => [
                'type' => 'default',
                'use_tooltip_icon' => 'on',
            ],
        ];

        $fields["tooltip_icon_color"] = [
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tooltip_styles',
            'hover' => 'tabs',
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
            'show_if' => [
                'type' => 'default',
                'use_tooltip_icon' => 'on',
            ],
        ];

        $fields["use_tooltip_icon_circle"] = [
            'label' => esc_html__('Show as Circle Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tooltip_styles',
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
            'show_if' => [
                'type' => 'default',
                'use_tooltip_icon' => 'on',
            ],
            'default_on_front' => 'off',
        ];

        $fields["tooltip_icon_circle_color"] = [
            'label' => esc_html__('Circle Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'show_if' => [
                'type' => 'default',
                'use_tooltip_icon' => 'on',
                'use_tooltip_icon_circle' => 'on',
            ],
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
            'validate_unit' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tooltip_styles',
            'hover' => 'tabs',
        ];

        $fields["use_tooltip_icon_circle_border"] = [
            'label' => esc_html__('Show Circle Border', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default_on_front' => 'off',
            'show_if' => [
                'type' => 'default',
                'use_tooltip_icon' => 'on',
                'use_tooltip_icon_circle' => 'on',
            ],
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tooltip_styles',
        ];

        $fields["tooltip_icon_circle_border_color"] = [
            'label' => esc_html__('Circle Border Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'show_if' => [
                'type' => 'default',
                'use_tooltip_icon' => 'on',
                'use_tooltip_icon_circle' => 'on',
                'use_tooltip_icon_circle_border' => 'on',
            ],
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
            'validate_unit' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tooltip_styles',
            'hover' => 'tabs',
        ];
        $fields['tooltip_icon_padding'] = [
            'label'   => esc_html__('Tooltip Icon Padding', 'dipi-divi-pixel'),
            'type'    => 'custom_margin',
            'hover'   => 'tabs',
            'default' => '25px|25px|25px|25px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tooltip_styles',
            'show_if' => [
                'type' => 'default',
                'use_tooltip_icon' => 'on',
            ],
        ];
        $fields["use_tooltip_icon_font_size"] = [
            'label' => esc_html__('Use Icon Font Size', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'font_option',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default_on_front' => 'off',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tooltip_styles',
            'show_if' => [
                'type' => 'default',
                'use_tooltip_icon' => 'on',
            ],
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
        ];

        $fields["tooltip_icon_font_size"] = [
            'label' => esc_html__('Icon Font Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '40px',
            'default_unit' => 'px',
            'default_on_front' => '40px',
            'allowed_units' => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
            'show_if' => [
                'type' => 'default',
                'use_tooltip_icon' => 'on',
                'use_tooltip_icon_font_size' => 'on',
            ],
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
            'range_settings' => [
                'min' => '1',
                'max' => '150',
                'step' => '1',
            ],
            'hover' => 'tabs',
            'validate_unit' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tooltip_styles',
        ];

        $fields['tooltip_img_src'] = [
            'type' => 'upload',
            'option_category' => 'basic_option',
            'hide_metadata' => true,
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'description' => esc_html__('Upload an image to display in the module.', 'dipi-divi-pixel'),
            'toggle_slug' => 'tooltip',
            'dynamic_content' => 'image',
            'show_if' => [
                'type' => 'default',
                'use_tooltip_icon' => 'off',
            ],
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
        ];

        $fields["tooltip_img_alt"] = [
            'label' => esc_html__('Image Alt Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'description' => esc_html__('Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
            'toggle_slug' => 'tooltip',
            'show_if' => [
                'type' => 'default',
                'use_tooltip_icon' => 'off',
            ],
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
            'dynamic_content' => 'text'
        ];

        $fields['tooltip_image_width'] = [
            'label' => esc_html('Tooltip Image Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '100px',
            'default_unit' => 'px',
            'default_on_front' => '100px',
            'allowed_units' => ['px'],
            'range_settings' => [
                'min' => '1',
                'max' => '1000',
                'step' => '10',
            ],
            'show_if' => [
                'type' => 'default',
                'use_tooltip_icon' => 'off',
            ],
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tooltip_styles',
        ];

        $fields["tooltip_bg"] = [
            'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tooltip_box',
        ];

        $fields["tooltip_title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'depends_show_if' => 'default',
            'toggle_slug' => 'tooltip',
            'show_if' => [
                'type' => 'default',
            ],
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
            'dynamic_content' => 'text'
        ];

        $fields["tooltip_desc"] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'type' => 'tiny_mce',
            'option_category' => 'basic_option',
            'depends_show_if' => 'on',
            'dynamic_content' => 'text',
            'depends_show_if' => 'default',
            'toggle_slug' => 'tooltip',
            'show_if' => [
                'type' => 'default',
            ],
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
            'dynamic_content' => 'text'
        ];

        $fields["show_tooltip_button"] = [
            'default' => 'off',
            'label' => esc_html__('Show Button', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'tooltip',
            'show_if' => [
                'type' => 'default',
            ],
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
        ];

        $fields["tooltip_button_text"] = [
            'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
            'default' => esc_html__('Click Here', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'tooltip',
            'show_if' => [
                'type' => 'default',
                'show_tooltip_button' => 'on',
            ],
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
            'dynamic_content' => 'text'
        ];

        $fields["tooltip_button_link"] = [
            'label' => esc_html__('Button Link', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'tooltip',
            'show_if' => [
                'type' => 'default',
                'show_tooltip_button' => 'on',
            ],
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
            'dynamic_content' => 'text'
        ];

        $fields["tooltip_button_link_target"] = [
            'label' => esc_html__('Button Link Target', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'same_window',
            'options' => [
                'off' => esc_html__('Same Window', 'dipi-divi-pixel'),
                'on' => esc_html__('New Window', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'tooltip',
            'show_if' => [
                'type' => 'default',
                'show_tooltip_button' => 'on',
            ],
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
        ];

        $fields["tooltip_position"] = [
            'label' => esc_html__('Tooltip Position', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => [
                'left' => esc_html__('Left', 'dipi-divi-pixel'),
                'right' => esc_html__('Right', 'dipi-divi-pixel'),
                'top' => esc_html__('Top', 'dipi-divi-pixel'),
                'bottom' => esc_html__('Bottom', 'dipi-divi-pixel'),
            ],
            'default' => 'left',
            'default_on_child' => true,
            'toggle_slug' => 'settings',
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
        ];

        $fields["tooltip_width"] = [
            'label' => esc_html__('Tooltip Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '300px',
            'default_unit' => 'px',
            'default_on_child' => true,
            'mobile_options' => true,
            'range_settings' => [
                'min' => '0',
                'max' => '500',
                'step' => '1',
            ],
            'validate_unit' => true,
            'toggle_slug' => 'settings',
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
        ];

        $fields["tooltip_content_align"] = [
            'label' => esc_html__('Tooltip Content Align', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'options' => [
                'left' => esc_html__('Left', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'right' => esc_html__('Right', 'dipi-divi-pixel'),
            ],
            'default' => 'left',
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
            'toggle_slug' => 'settings',
        ];
        $fields["hotspot_link"] = [
            'label' => esc_html__('Hotspot Link', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'link_settings',
        ];

        $fields["hotspot_link_target"] = [
            'label' => esc_html__('Hotspot Link Target', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'same_window',
            'options' => [
                'same_window' => esc_html__('Same Window', 'dipi-divi-pixel'),
                'new_window' => esc_html__('New Window', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'link_settings',
        ];
        $fields['use_tooltip_arrow'] = [
            'label' => esc_html__('Use Tooltip Arrow', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'settings',
            'affects' => [
                'arrow_color',
            ],
            'show_if_not' => [
                'parentModule:hide_tooltip' => 'on', // I want this field to be dependent
            ],
        ];

        $fields["arrow_color"] = [
            'label' => esc_html__('Arrow Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#000',
            'depends_show_if' => 'on',
            'toggle_slug' => 'settings',
        ];

        $fields['tooltip_padding'] = [
            'label' => esc_html('Tooltip Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '10px|10px|10px|10px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tooltip_box',
        ];

        $fields["__gethtmllibary"] = [
            'type' => 'computed',
            'computed_callback' => ['DIPI_ImageHotspotChild', 'get_html_libary'],
            'computed_depends_on' => [
                'library_id',
            ],
        ];
        return $fields;
    }

    public function get_advanced_fields_config()
    {

        $advanced_fields = [];

        $advanced_fields['fonts'] = [];
        $advanced_fields['text'] = false;
        $advanced_fields['text_shadow'] = false;
        $advanced_fields['link_options'] = false;

        $advanced_fields["fonts"]["tooltip_title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-tooltip-title",
            ],
            'hide_text_align' => true,
            'toggle_slug' => 'tooltip_text',
            'sub_toggle' => 'title',
            'line_height' => [
                'range_settings' => [
                    'default' => '1em',
                    'min' => '1',
                    'max' => '3',
                    'step' => '.1',
                ],
            ],
            'header_level' => [
                'default' => 'h2',
            ],
            'font_size' => [
                'default' => '18px',
            ],
            'important' => 'all',
        ];

        $advanced_fields["fonts"]["tooltip_desc"] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-tooltip-desc",
            ],
            'hide_text_align' => true,
            'toggle_slug' => 'tooltip_text',
            'sub_toggle' => 'desc',
            'line_height' => [
                'range_settings' => [
                    'default' => '1em',
                    'min' => '1',
                    'max' => '3',
                    'step' => '.1',
                ],
            ],
            'font_size' => [
                'default' => absint(et_get_option('body_font_size', '14')) . 'px', //FIXME: Default values in font settings can sometimes cause issue. check if this is ok
            ],
            'important' => 'all',
        ];

        $advanced_fields['button']["tooltip_button"] = [
            'label' => esc_html__('Tooltip Button', 'dipi-divi-pixel'),
            'use_alignment' => false,
            'css' => [
                'main' => "%%order_class%% .dipi-tooltip-button",
                'important' => true,
            ],
            'box_shadow' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-tooltip-button",
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-tooltip-button.et_pb_button",
                    'important' => 'all',
                ],
            ],
        ];

        $advanced_fields['borders']['hotspot_img'] = [
            'label_prefix' => esc_html__('Hotspot Image', 'dipi-divi-pixel'),
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-hotspot .dipi-hotspot-image",
                    'border_styles' => "%%order_class%% .dipi-hotspot .dipi-hotspot-image",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'hotspot_icon_image',
            'depends_on' => ['use_hotspot_icon'],
            'depends_show_if' => 'off',
        ];

        $advanced_fields['box_shadow']['hotspot_img'] = [
            'label_prefix' => esc_html__('Hotspot Image', 'dipi-divi-pixel'),
            'css' => [
                'main' => '%%order_class%% .dipi-hotspot .dipi-hotspot-image',
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'hotspot_icon_image',
            'show_if' => ['use_hotspot_icon' => 'off'],
        ];

        $advanced_fields['borders']['tooltip_img'] = [
            'label_prefix' => esc_html__('Tooltip Image', 'dipi-divi-pixel'),
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-tooltip-image",
                    'border_styles' => "%%order_class%% .dipi-tooltip-image",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tooltip_styles',
            'depends_on' => ['use_tooltip_icon'],
            'depends_show_if' => 'off',
        ];

        $advanced_fields['box_shadow']['tooltip_img'] = [
            'label' => esc_html__('Tooltip Image', 'dipi-divi-pixel'),
            'css' => [
                'main' => '%%order_class%% .dipi-tooltip-image',
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tooltip_styles',
            'show_if' => ['use_tooltip_icon' => 'off'],
        ];

        $advanced_fields['borders']['tooltip_box'] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-tooltip-wrap",
                    'border_styles' => "%%order_class%% .dipi-tooltip-wrap",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tooltip_box',
        ];

        $advanced_fields['box_shadow']['tooltip_box'] = [
            'css' => [
                'main' => '%%order_class%% .dipi-tooltip-wrap',
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tooltip_box',
        ];

        $advanced_fields['margin_padding'] = [
            'css' => [
                'margin' => '%%order_class%%',
                'padding' => '%%order_class%%',
                'important' => 'all',
            ],
        ];

        return $advanced_fields;
    }

    public static function get_html_libary($args = [])
    {
        $id = isset($args['library_id']) ? $args['library_id'] : '';
        return DIPI_Builder_Module::render_library_layout($id);
    }

    private function hex2RGB($color, $opacity = false)
    {

        if ($color[0] == '#') {
            $color = substr($color, 1);
        }

        if (strlen($color) == 6) {
            $hex = [$color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]];
        } elseif (strlen($color) == 3) {
            $hex = [$color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]];
        }

        $rgb = array_map('hexdec', $hex);

        $output = 'rgba( ' . implode(",", $rgb) . ',' . $opacity . ' )';

        return $output;
    }

    private function rgb_split($color, $alpha = true)
    {

        $pattern = '~^rgba?\((25[0-5]|2[0-4]\d|1\d{2}|\d\d?)\s*,\s*(25[0-5]|2[0-4]\d|1\d{2}|\d\d?)\s*,\s*(25[0-5]|2[0-4]\d|1\d{2}|\d\d?)\s*(?:,\s*([01]\.?\d*?))?\)$~';

        if (!preg_match($pattern, $color, $matches)) {
            return [];
        }

        return array_slice($matches, 1, $alpha ? 4 : 3);
    }
 
    public function render($attrs, $content, $render_slug)
    {
        $this->render_css($render_slug);

        /* Parent module setting */
        $parent_module = self::get_parent_modules('page')['dipi_image_hotspot'];
        $tooltip_animation = $parent_module->props['tooltip_animation'];
        $hide_tooltip = $parent_module->props['hide_tooltip'];
        /**
         * Hotspot element
         */
        $hotspot_image = $this->props['hotspot_image'];
        $use_hotspot_icon = $this->props['use_hotspot_icon'];
        $hotspot_icon = $this->props['hotspot_icon'];

        // Hotspot ripple effect
        $hotspot_ripple_effect = $this->props['hotspot_ripple_effect'];
        $hotspot_ripple_effect_style = $this->props['hotspot_ripple_effect_style'];
        $hotspot_ripple_effect_color = $this->props['hotspot_ripple_effect_color'];

        $hotspot_link = $this->props['hotspot_link'];
        $hotspot_link_target = $this->props['hotspot_link_target'] === 'new_window' ? '_blank' : '_self';

        $start_link_wrap = !empty($hotspot_link) ? sprintf(
            '<a href="%1$s" target="%2$s">',
            $hotspot_link,
            $hotspot_link_target
        ) : '';

        $end_link_wrap = !empty($hotspot_link) ? '</a>' : '';
        $key_uuid = 'key' . rand();

        $color1 = "rgba(0,0,0, .3)";
        $color2 = "rgba(0,0,0, .3)";
        $color3 = "rgba(0,0,0, 0)";
        $color4 = "rgba(0,0,0, .5)";
        $color5 = "rgba(0,0,0, 0)";
        $color6 = "rgba(0,0,0, 0)";
        $color7 = "rgba(0,0,0, 0)";
        $color8 = "rgba(0,0,0, 0)";

        if ($hotspot_ripple_effect_color !== 'undefined') {

            if ($this->startsWith($hotspot_ripple_effect_color, "#")) {

                $color1 = $this->hex2RGB($hotspot_ripple_effect_color, 0.3);
                $color2 = $this->hex2RGB($hotspot_ripple_effect_color, 0.3);
                $color3 = $this->hex2RGB($hotspot_ripple_effect_color, 0.0);
                $color4 = $this->hex2RGB($hotspot_ripple_effect_color, 0.5);
                $color5 = $this->hex2RGB($hotspot_ripple_effect_color, 0.0);
                $color6 = $this->hex2RGB($hotspot_ripple_effect_color, 0.0);
                $color7 = $this->hex2RGB($hotspot_ripple_effect_color, 0.0);
                $color8 = $this->hex2RGB($hotspot_ripple_effect_color, 0.0);
            } else {

                $rgbaColor = $hotspot_ripple_effect_color;
                $rgba_arr = $this->rgb_split($rgbaColor);

                $red = isset($rgba_arr[0]) ? $rgba_arr[0] : '';
                $green = isset($rgba_arr[1]) ? $rgba_arr[1] : '';
                $blue = isset($rgba_arr[2]) ? $rgba_arr[2] : '';

                $color1 = "rgba($red, $green, $blue, .3)";
                $color2 = "rgba($red, $green, $blue, .3)";
                $color3 = "rgba($red, $green, $blue, 0)";
                $color4 = "rgba($red, $green, $blue, .5)";
                $color5 = "rgba($red, $green, $blue, 0)";
                $color6 = "rgba($red, $green, $blue, 0)";
                $color7 = "rgba($red, $green, $blue, 0)";
                $color8 = "rgba($red, $green, $blue, 0)";
            }
        }

        // Keyframes
        $keyframes = ('on' === $hotspot_ripple_effect && $hotspot_ripple_effect_style === 'style-1') ? "<style>@keyframes pulse-$key_uuid {
            0% {box-shadow: 0 0 0 0 $color1, 0 0 0 0 $color2;}
            33% {box-shadow: 0 0 0 15px $color3, 0 0 0 0 $color4;}
            66% {box-shadow: 0 0 0 10px $color5, 0 0 0 10px $color6;}
            100% {box-shadow: 0 0 0 0 $color7, 0 0 0 15px $color8;}
            }</style>" : "";

        // Pulse style
        $pulse_style = ('on' === $hotspot_ripple_effect && $hotspot_ripple_effect_style === 'style-1') ? 'style="animation: pulse-' . $key_uuid . ' 3s linear infinite;"' : '';
        // Hotspot icon
        $hotspot_icon = sprintf(
            '
            <span %2$s class="et-pb-icon et-pb-font-icon dipi-hotspot-icon">
                %1$s
            </span>',
            esc_attr(et_pb_process_font_icon($hotspot_icon)),
            $pulse_style
        );

        if('on' === $this->props['use_hotspot_icon']){
            $this->dipi_generate_font_icon_styles($render_slug, 'hotspot_icon', '%%order_class%% .dipi-hotspot-icon');
        }

        if('on' === $hotspot_ripple_effect && $hotspot_ripple_effect_style === 'style-2') {
            
            $this->dipi_generate_ripple_effect_styles($render_slug, 'hotspot_ripple_effect_color', '%%order_class%% .dipi-hotspot-image');
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-sonar-circle',
                'declaration' => "border-color: $hotspot_ripple_effect_color;"
            ]);
        }
        
        $img_alt = $this->props['img_alt'];
        // Hotspot image
        $hotspot_image = sprintf(
            '<img style="animation: pulse-%2$s 3s linear infinite;" src="%1$s" class="dipi-hotspot-image" alt="%3$s">',
            $hotspot_image,
            $key_uuid,
            $img_alt

        );

        $ripple_element = $this->sonar_animation();

        $hotspot_img_icon = $use_hotspot_icon === 'on' ? $hotspot_icon : $hotspot_image;

        // Hotspot output
        $hotspot = sprintf(
            '
            <div class="dipi-hotspot">
                %3$s
                    %1$s
                    %2$s
                    %5$s
                %4$s
            </div>',
            $hotspot_img_icon,
            $keyframes,
            $start_link_wrap,
            $end_link_wrap,
            $ripple_element
        );

        // Tooltip icon
        $tooltip_icon = sprintf(
            '
            <div class="dipi-tooltip-image-icon">
                <span class="et-pb-icon et-pb-font-icon dipi-tooltip-icon">
                    %1$s
                </span>
            </div>',
            esc_attr(et_pb_process_font_icon($this->props['tooltip_icon']))
        );

        if('on' === $this->props['use_tooltip_icon']){
            $this->dipi_generate_font_icon_styles($render_slug, 'tooltip_icon', '%%order_class%% .dipi-tooltip-icon');
        }

        $tooltip_img_alt = $this->props['tooltip_img_alt'];
        // Tooltip Image
        $tooltip_image = '';
        if (!empty($this->props['tooltip_img_src'])) {
            $tooltip_image = sprintf(
                '
                <div class="dipi-tooltip-image-icon">
                    <img src="%1$s" class="dipi-tooltip-image" alt="%2$s">
                </div>',
                $this->props['tooltip_img_src'],
                $tooltip_img_alt
            );
        }
        // Tooltip title
        $tooltip_title_level = $this->props['tooltip_title_level'] ? $this->props['tooltip_title_level'] : 'h2';
        $tooltip_title = $this->props['tooltip_title'] !== '' ? sprintf(
            '
            <%2$s class="dipi-tooltip-title">
                %1$s
            </%2$s>',
            $this->props['tooltip_title'],
            esc_attr($tooltip_title_level)
        ) : '';

        // Tooltip Description
        $tooltip_desc = $this->props['tooltip_desc'] !== '' ? sprintf(
            '
            <div class="dipi-tooltip-desc">
                %1$s
            </div>',
            $this->process_content($this->props['tooltip_desc'])
        ) : '';

        $show_tooltip_button = $this->props['show_tooltip_button'];
        $tooltip_button_text = $this->props['tooltip_button_text'];
        $tooltip_button_link = $this->props['tooltip_button_link'];
        $tooltip_button_rel = $this->props['tooltip_button_rel'];
        $tooltip_button_icon = $this->props['tooltip_button_icon'];
        $tooltip_button_link_target = $this->props['tooltip_button_link_target'];
        $tooltip_button_custom = $this->props['custom_tooltip_button'];

        $tooltip_button = $this->render_button([
            'button_classname' => ["dipi-tooltip-button"],
            'button_custom' => $tooltip_button_custom,
            'button_rel' => $tooltip_button_rel,
            'button_text' => $tooltip_button_text,
            'button_url' => $tooltip_button_link,
            'custom_icon' => $tooltip_button_icon,
            'has_wrapper' => false,
            'url_new_window' => $tooltip_button_link_target,
        ]);

        // Tooltip Icon/Image
        $tooltip_img_icon = 'on' === $this->props['use_tooltip_icon'] ? $tooltip_icon : $tooltip_image;

        // Tooltip button
        $tooltip_button = 'on' === $show_tooltip_button ? sprintf('<div class="dipi-tooltip-button-wrap">%1$s</div>', $tooltip_button) : '';

        // Tooltip Divi Libary Shortcode
        $tooltip_shortcode = do_shortcode('[et_pb_section global_module="' . $this->props['library_id'] . '"][/et_pb_section]');

        // Tooltip Arrow
        $tooltip_arrow = 'on' === $this->props['use_tooltip_arrow'] ? 'dipi-tooltip-arrow dipi-tooltip-arrow-' . $this->props['tooltip_position'] : '';

        // Tooltip Position
        $tooltip_position_class = "dipi-tooltip-position-{$this->props['tooltip_position']}";
        
        // Child Order Class
        $order_class = self::get_module_order_class($render_slug);
        $order_number = preg_replace('/[^0-9]/', '', $order_class);

        // Tooltip element
        $tooltip = '';
        if ($hide_tooltip === 'off') {
            if ($this->props['type'] === 'library') {

                $tooltip = sprintf(
                    '
                    <div
                        class="dipi-tooltip-wrap %2$s %3$s animated %4$s"
                        data-order-number="%5$s"
                    >
                        %1$s
                    </div>',
                    $tooltip_shortcode,
                    $tooltip_position_class,
                    $tooltip_arrow,
                    $tooltip_animation,
                    $order_number #5

                );
            } else {

                $tooltip = sprintf(
                    '
                    <div
                        class="dipi-tooltip-wrap %5$s %6$s animated %7$s"
                        data-order-number="%8$s"
                    >
                        %1$s
                        %2$s
                        %3$s
                        %4$s
                    </div>',
                    $tooltip_img_icon,
                    $tooltip_title,
                    $tooltip_desc,
                    $tooltip_button,
                    $tooltip_position_class, #5
                    $tooltip_arrow,
                    $tooltip_animation,
                    $order_number
                );
            }
        }

        /**
         * Tooltip Output
         */
        $output = sprintf(
            '
            <div class="dipi-image-hotspot-child">
                %1$s
                %2$s
            </div>',
            $tooltip,
            $hotspot
        );

        return $output;
    }

    private function sonar_animation()
    {
        if ($this->props['hotspot_ripple_effect_style'] !== 'style-2') {
            return '';
        }
        return sprintf(
            '<div class="dipi-svg-sonar-container" style="width:%2$s;height:%2$s;">
                <div class="dipi-sonar-circle"></div>
                <div class="dipi-sonar-circle"></div>
                <div class="dipi-sonar-circle"></div>
                <div class="dipi-sonar-circle"></div>
            </div>',
            $this->props['hotspot_ripple_effect_color'],
            $this->props['hotspot_ripple_effect_size']
        );
    }

    private function sonar_animation_css($render_slug)
    {
        if ('on' !== $this->props['hotspot_ripple_effect'] || $this->props['hotspot_ripple_effect_style'] !== 'style-2') {
            return;
        }

        $hotspot_ripple_effect_speed = ($this->props['hotspot_ripple_effect_speed']) ? $this->props['hotspot_ripple_effect_speed'] : 1.8;
        $hotspot_ripple_effect_speed_tablet = ($this->props['hotspot_ripple_effect_speed_tablet']) ? $this->props['hotspot_ripple_effect_speed_tablet'] : $hotspot_ripple_effect_speed;
        $hotspot_ripple_effect_speed_phone = ($this->props['hotspot_ripple_effect_speed_phone']) ? $this->props['hotspot_ripple_effect_speed_phone'] : $hotspot_ripple_effect_speed;

        $hotspot_ripple_effect_size = intval($this->props['hotspot_ripple_effect_size']);
        $hotspot_ripple_effect_size_tablet = $this->props['hotspot_ripple_effect_size_tablet']? intval($this->props['hotspot_ripple_effect_size_tablet']): $hotspot_ripple_effect_size;
        $hotspot_ripple_effect_size_phone = $this->props['hotspot_ripple_effect_size_phone']? intval($this->props['hotspot_ripple_effect_size_phone']): $hotspot_ripple_effect_size_tablet;

        

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-sonar-circle',
            'declaration' => sprintf('animation-duration: %1$ss;width:%2$spx;height:%2$spx;',
                $hotspot_ripple_effect_speed,
                $hotspot_ripple_effect_size / 3
            )
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-sonar-circle',
            'declaration' => sprintf('animation-duration: %1$ss;width:%2$spx;height:%2$spx;',
                $hotspot_ripple_effect_speed_tablet,
                $hotspot_ripple_effect_size_tablet / 3
        ),
        'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-sonar-circle',
            'declaration' => sprintf('animation-duration: %1$ss;width:%2$spx;height:%2$spx;',
                $hotspot_ripple_effect_speed_phone,
                $hotspot_ripple_effect_size_phone / 3
            ),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);

        





        $animation_part_speed = floatval($hotspot_ripple_effect_speed) / 3;
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-sonar-circle:nth-child(2)',
            'declaration' => sprintf('animation-delay: %1$ss;', $animation_part_speed),
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-sonar-circle:nth-child(3)',
            'declaration' => sprintf('animation-delay: %1$ss;', $animation_part_speed * 2),
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-sonar-circle:nth-child(4)',
            'declaration' => sprintf('animation-delay: %1$ss;', $animation_part_speed * 3),
        ]);

        // $this->process_range_field_css( array(
        //     'render_slug'       => $render_slug,
        //     'slug'              => 'hotspot_ripple_effect_size',
        //     'type'              => 'width',
        //     'selector'          => '%%order_class%% .dipi-sonar-circle',
        //     'important'         => false
        // ) );
        // $this->process_range_field_css( array(
        //     'render_slug'       => $render_slug,
        //     'slug'              => 'hotspot_ripple_effect_size',
        //     'type'              => 'height',
        //     'selector'          => '%%order_class%% .dipi-sonar-circle',
        //     'important'         => false
        // ) );
    }

    private function dipi_tooltip_content_align_css($render_slug)
    {

        $tooltip_content_align = $this->props['tooltip_content_align'];

        if ('left' == $tooltip_content_align):

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tooltip-wrap, %%order_class%% .dipi-tooltip-button-wrap',
                'declaration' => "text-align: left !important;",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tooltip-image-icon',
                'declaration' => "margin-left: 0 !important; margin-right: auto !important;",
            ]);

        elseif ('center' == $tooltip_content_align):

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tooltip-wrap, %%order_class%% .dipi-tooltip-button-wrap',
                'declaration' => "text-align: center !important;",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tooltip-image-icon',
                'declaration' => "margin-left: auto !important; margin-right: auto !important;",
            ]);

        elseif ('right' == $tooltip_content_align):

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tooltip-wrap, %%order_class%% .dipi-tooltip-button-wrap',
                'declaration' => "text-align: right !important;",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tooltip-image-icon',
                'declaration' => "margin-right: 0 !important; margin-left: auto !important;",
            ]);

        endif;
    }

    private function dipi_image_width_css($render_slug)
    {
        $hotspot_image_width = $this->dipi_get_responsive_prop('hotspot_image_width');

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-hotspot .dipi-hotspot-image ",
            'declaration' => sprintf('width: %1$s !important;', $hotspot_image_width['desktop']),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-hotspot .dipi-hotspot-image",
            'declaration' => sprintf('width: %1$s !important;', $hotspot_image_width['tablet']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-hotspot .dipi-hotspot-image",
            'declaration' => sprintf('width: %1$s !important;', $hotspot_image_width['phone']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));

        $tooltip_image_width = $this->dipi_get_responsive_prop('tooltip_image_width');

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-tooltip-image-icon img",
            'declaration' => sprintf('width: %1$s !important;', $tooltip_image_width['desktop']),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-tooltip-image-icon img",
            'declaration' => sprintf('width: %1$s !important;', $tooltip_image_width['tablet']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-tooltip-image-icon img",
            'declaration' => sprintf('width: %1$s !important;', $tooltip_image_width['phone']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));
    }

    private function dipi_hotspot_icon_css($render_slug)
    {
        $hotspot_icon_color = $this->dipi_get_responsive_prop('hotspot_icon_color');
        $hotspot_icon_color_hover = $this->get_hover_value('hotspot_icon_color');

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hotspot-icon',
            'declaration' => "color: {$hotspot_icon_color['desktop']} !important;",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hotspot-icon',
            'declaration' => "color: {$hotspot_icon_color['tablet']} !important;",
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hotspot-icon',
            'declaration' => "color: {$hotspot_icon_color['phone']} !important;",
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hotspot-icon:hover',
            'declaration' => "color: {$hotspot_icon_color_hover} !important;",
        ]);

        $hotspot_circle_icon = $this->props['hotspot_circle_icon'];
        $hotspot_circle_color = $this->props['hotspot_circle_color'];
        $hotspot_circle_color_hover = $this->get_hover_value('hotspot_circle_color');

        if ('on' === $hotspot_circle_icon):

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-hotspot-icon',
                'declaration' => "padding: 15px; border-radius: 100%; background-color: {$hotspot_circle_color};",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-hotspot-icon:hover',
                'declaration' => "background-color: {$hotspot_circle_color_hover};",
            ]);

        endif;

        $hotspot_circle_border = $this->props['hotspot_circle_border'];
        $hotspot_circle_border_color = $this->props['hotspot_circle_border_color'];
        $hotspot_circle_border_color_hover = $this->get_hover_value('hotspot_circle_border_color');

        if ('on' === $hotspot_circle_border):

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-hotspot-icon',
                'declaration' => "border: 3px solid {$hotspot_circle_border_color};",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-hotspot-icon:hover',
                'declaration' => "border-color: {$hotspot_circle_border_color_hover};",
            ]);
        endif;
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'hotspot_icon_padding',
            'padding',
            '%%order_class%% .dipi-hotspot-icon'
        );
        $use_hotspot_icon_font_size = $this->props['use_hotspot_icon_font_size'];
        if ('on' === $use_hotspot_icon_font_size):
            $this->process_range_field_css( array(
                'render_slug'       => $render_slug,
                'slug'              => 'hotspot_icon_size',
                'type'              => 'font-size',
                'selector'          => '%%order_class%% .dipi-hotspot-icon',
                'hover'          => '%%order_class%% .dipi-hotspot:hover .dipi-hotspot-icon',
                'important'         => false
            ) );

        endif;
    }

    private function dipi_tooltip_icon_css($render_slug)
    {

        $tooltip_icon_color = $this->props['tooltip_icon_color'];
        $tooltip_icon_color_hover = $this->get_hover_value('tooltip_icon_color');

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-tooltip-icon',
            'declaration' => "color: {$tooltip_icon_color} !important;"
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-tooltip-icon:hover',
            'declaration' => "color: {$tooltip_icon_color_hover} !important;"
        ]);

        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'tooltip_icon_padding',
            'padding',
            '%%order_class%% .dipi-tooltip-icon'
        );

        $use_tooltip_icon_circle = $this->props['use_tooltip_icon_circle'];
        $tooltip_icon_circle_color = $this->props['tooltip_icon_circle_color'];
        $tooltip_icon_circle_color_hover = $this->get_hover_value('tooltip_icon_circle_color');

        if ('on' == $use_tooltip_icon_circle):

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tooltip-icon',
                'declaration' => "padding: 25px; border-radius: 100%; background-color: {$tooltip_icon_circle_color} !important;",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tooltip-icon:hover',
                'declaration' => "background-color: {$tooltip_icon_circle_color_hover} !important;",
            ]);

        endif;

        $use_tooltip_icon_circle_border = $this->props['use_tooltip_icon_circle_border'];
        $tooltip_icon_circle_border_color = $this->props['tooltip_icon_circle_border_color'];
        $tooltip_icon_circle_border_color_hover = $this->get_hover_value('tooltip_icon_circle_border_color');

        if ('on' === $use_tooltip_icon_circle_border):

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tooltip-icon',
                'declaration' => "border: 3px solid {$tooltip_icon_circle_border_color};",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tooltip-icon:hover',
                'declaration' => "border-color: {$tooltip_icon_circle_border_color_hover};",
            ]);

        endif;

        $use_tooltip_icon_font_size = $this->props['use_tooltip_icon_font_size'];
        $tooltip_icon_font_size = $this->props['tooltip_icon_font_size'];
        $tooltip_icon_font_size_hover = $this->get_hover_value('tooltip_icon_font_size');

        if ('on' == $use_tooltip_icon_font_size):

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-tooltip-icon',
                'declaration' => "font-size: {$tooltip_icon_font_size} !important;",
            ]);

            if ('' === $tooltip_icon_font_size_hover):

                ET_Builder_Element::set_style($render_slug, [
                    'selector' => '%%order_class%% .dipi-tooltip-icon:hover',
                    'declaration' => "font-size: {$tooltip_icon_font_size_hover} !important;",
                ]);

            endif;

        endif;
    }

    private function dipi_tooltip_padding_css($render_slug)
    {

        if (!isset($this->props['tooltip_padding']) || '' === $this->props['tooltip_padding']) {
            return;
        }

        $tooltip_padding = $this->dipi_get_responsive_prop('tooltip_padding');
        $tooltip_padding_desktop = explode('|', $tooltip_padding['desktop']);
        $tooltip_padding_tablet = explode('|', $tooltip_padding['tablet']);
        $tooltip_padding_phone = explode('|', $tooltip_padding['phone']);

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-tooltip-wrap",
            'declaration' => sprintf(
                'padding-top: %1$s !important;
                padding-right:%2$s !important;
                padding-bottom:%3$s !important;
                padding-left:%4$s !important;',
                $tooltip_padding_desktop[0],
                $tooltip_padding_desktop[1],
                $tooltip_padding_desktop[2],
                $tooltip_padding_desktop[3]
            ),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-tooltip-wrap",
            'declaration' => sprintf(
                'padding-top: %1$s !important;
                padding-right:%2$s !important;
                padding-bottom:%3$s !important;
                padding-left:%4$s !important;',
                $tooltip_padding_tablet[0],
                $tooltip_padding_tablet[1],
                $tooltip_padding_tablet[2],
                $tooltip_padding_tablet[3]
            ),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-tooltip-wrap",
            'declaration' => sprintf(
                '
                padding-top: %1$s !important;
                padding-right:%2$s !important;
                padding-bottom:%3$s !important;
                padding-left:%4$s !important;
                ',
                $tooltip_padding_phone[0],
                $tooltip_padding_phone[1],
                $tooltip_padding_phone[2],
                $tooltip_padding_phone[3]
            ),

            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));
    }

    private function dipi_tooltip_arrow_css($render_slug)
    {

        $arrow_color = $this->props['arrow_color'];
        $border_width_all_tooltip_box = $this->props['border_width_all_tooltip_box'];


        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-tooltip-arrow-left::before',
            'declaration' => "border-left-color: {$arrow_color} !important;",
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-tooltip-arrow-left::before',
            'declaration' => "right: -{$border_width_all_tooltip_box} !important;",
        ]);


        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-tooltip-arrow-right::before',
            'declaration' => "border-right-color: {$arrow_color} !important;",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-tooltip-arrow-right::before',
            'declaration' => "left: -{$border_width_all_tooltip_box} !important;",
        ]);


        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-tooltip-arrow-top::before',
            'declaration' => "border-top-color: {$arrow_color} !important;",
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-tooltip-arrow-top::before',
            'declaration' => "bottom: -{$border_width_all_tooltip_box} !important;",
        ]);


        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-tooltip-arrow-bottom::before',
            'declaration' => "border-bottom-color: {$arrow_color} !important;",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-tooltip-arrow-bottom::before',
            'declaration' => "top: -{$border_width_all_tooltip_box} !important;",
        ]);

    }

    private function dipi_tooltip_width_css($render_slug)
    {

        if (!isset($this->props['tooltip_width']) || '' === $this->props['tooltip_width']) {
            return;
        }

        $tooltip_width = $this->dipi_get_responsive_prop('tooltip_width');

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-tooltip-wrap",
            'declaration' => sprintf('width: %1$s !important;', $tooltip_width['desktop']),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-tooltip-wrap",
            'declaration' => sprintf('width: %1$s !important;', $tooltip_width['tablet']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-tooltip-wrap",
            'declaration' => sprintf('width: %1$s !important;', $tooltip_width['phone']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));
    }

    private function render_css($render_slug)
    {

        $this->dipi_image_width_css($render_slug);
        $this->dipi_tooltip_width_css($render_slug);
        $this->dipi_tooltip_content_align_css($render_slug);
        $this->dipi_hotspot_icon_css($render_slug);
        $this->dipi_tooltip_icon_css($render_slug);
        $this->dipi_tooltip_padding_css($render_slug);
        $this->dipi_tooltip_arrow_css($render_slug);
        $this->sonar_animation_css($render_slug);

        $hotspot_position_vertical = $this->props['hotspot_position_vertical'];
        $hotspot_position_horizontal = $this->props['hotspot_position_horizontal'];
        $tooltip_bg = $this->props['tooltip_bg'];

        $this->generate_styles(
            array(
                'base_attr_name' => 'hotspot_position_vertical',
                'selector' => '%%order_class%%',
                'css_property' => 'top',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-tooltip-wrap.dipi-tooltip-wrap',
            'declaration' => "top: {$hotspot_position_vertical};",
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);

        /*ET_Builder_Element::set_style($render_slug, [
        'selector' => '%%order_class%%',
        'declaration' => "left: {$hotspot_position_horizontal};"
        ]);*/
        $this->generate_styles(
            array(
                'base_attr_name' => 'hotspot_position_horizontal',
                'selector' => '%%order_class%%',
                'css_property' => 'left',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-tooltip-wrap',
            'declaration' => "background-color: {$tooltip_bg} !important;",
        ]);
    }
}

new DIPI_ImageHotspotChild;
