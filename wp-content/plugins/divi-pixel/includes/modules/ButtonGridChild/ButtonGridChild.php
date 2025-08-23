<?php

class DIPI_ButtonGridChild extends DIPI_Builder_Module
{

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->slug = 'dipi_button_grid_child';
        $this->vb_support = 'on';
        $this->type = 'child';
        $this->name = esc_html__('Button Grid', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%.dipi_button_grid_child';
        $this->child_title_var = 'button_id';
        $this->advanced_setting_title_text = esc_html__('New Button', 'dipi-divi-pixel');
        $this->settings_text = esc_html__('Button Settings', 'dipi-divi-pixel');
    }

    public function get_settings_modal_toggles()
    {
        return [
            'general' => [
                'toggles' => [
                    'general' => esc_html__('General', 'dipi-divi-pixel'),
                    'button_info' => esc_html__('Button Settings', 'dipi-divi-pixel'),
                    'text_info' => esc_html__('Text Settings', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'text_style' => esc_html__('Text Style', 'dipi-divi-pixel')
                ]
            ],
            'custom_css' => [
                'toggles' => [
                    'classes' => esc_html__('CSS ID & Classes', 'dipi-divi-pixel'),
                ],
            ]
        ];
    }

    public function get_custom_css_fields_config()
    {
        $fields = [];

        $fields['button_type'] = array(
            'label' => esc_html__('Button Style', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-button-wrap',
        );

        $fields['text_type'] = array(
            'label' => esc_html__('Text Style', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-text-wrap',
        );

        return $fields;
    }

    public function get_fields()
    {
        $fields = [];

        $fields["button_id"] = [
            'label' => esc_html__('Admin Label', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'toggle_slug' => 'general'
        ];

        $fields['button_type'] = [
            'label' => esc_html__('Button Type', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'configuration',
            'options' => [
                '' => esc_html__('Select Type', 'dipi-divi-pixel'),
                'dp_button' => esc_html__('Button', 'dipi-divi-pixel'),
                'text'   => esc_html__('Text', 'dipi-divi-pixel'),
            ],
            'default' => 'button',
            'toggle_slug' => 'general'
        ];

        $fields["button_text"] = [
            'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'show_if_not' => [
                'button_type' => ['text', ''],
            ],
            'toggle_slug' => 'button_info',
            'dynamic_content' => 'text'
        ];

        $fields["button_link"] = [
            'label' => esc_html__('Button Link', 'dipi-divi-pixel'),
            'type' => 'text',
            'dynamic_content' => 'url',
            'option_category' => 'basic_option',
            'show_if_not' => [
                'button_type' => ['text', ''],
            ],
            'toggle_slug' => 'button_info',
        ];

        $fields["button_link_target"] = [
            'label'           => esc_html__('Button Link Target', 'dipi-divi-pixel'),
            'type'            => 'select',
            'option_category' => 'basic_option',
            'options'         => [
                'off'    => esc_html__('Same Window', 'dipi-divi-pixel'),
                'on'  => esc_html__('New Window', 'dipi-divi-pixel'),
            ],
            'show_if_not' => [
                'button_type' => ['text', ''],
            ],
            'toggle_slug' => 'button_info',
        ];

        $fields["text_info"] = [
            'label' => esc_html__('Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'depends_show_if' => 'text',
            'depends_on' => [
                'button_type'
            ],
            'toggle_slug' => 'text_info',
            'dynamic_content' => 'text'
        ];
        
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

        return $fields;
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = [];
        $advanced_fields["text"] = false;
        $advanced_fields["text_shadow"] = false;
        $advanced_fields["link_options"] = false;

        $advanced_fields['margin_padding'] = [
            'css' => [
                'margin' => '%%order_class%%',
                'padding' => '%%order_class%%',
                'important' => 'all',
            ],
        ];

        $advanced_fields['fonts']['text_style'] = [
            'css' => [
                'main' => "%%order_class%% .dipi-text-wrap",
                'important' => 'all',
            ],
            'text_align' => [
                'default' => 'center',
            ],
            'font_size' => [
                'default' => '16px',
                'range_settings' => [
                    'min' => '1',
                    'max' => '50',
                    'step' => '1',
                ],
            ],
            'line_height' => [
                'default' => '1em',
                'range_settings' => [
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ],
            ],
            'toggle_slug' => 'text_style',
        ];

        $advanced_fields['button']["button"] = [
            'label'    => esc_html__('Button Style', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-button-wrap",
                'limited_main' => "%%order_class%% .dipi-button-wrap",
                'important' => true,
            ],
            'box_shadow'  => [
                'css' => [
                    'main' => "%%order_class%% .dipi-button-wrap",
                    'important' => true,
                ],
            ],
            'use_alignment' => false,
            'margin_padding' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-button-wrap",
                    'important' => 'all',
                ],
            ]

        ];

        return $advanced_fields;
    }

    public function render($attrs, $content, $render_slug)
    {
        
        if ('button' === $this->props['button_type'] || 'dp_button' === $this->props['button_type']) {
            $button_custom = $this->props['custom_button'];
            $button_text   = isset($this->props['button_text']) ? $this->props['button_text'] : 'Click Here';
            $button_link   = isset($this->props['button_link']) ? $this->props['button_link'] : '#';
            $button_link_target = $this->props['button_link_target'];
            $button_rel    = $this->props['button_rel'];


            $custom_icon_values = et_pb_responsive_options()->get_property_values( $this->props, 'button_icon' );
            $custom_icon        = isset( $custom_icon_values['desktop'] ) ? $custom_icon_values['desktop'] : '';
            $custom_icon_tablet = isset( $custom_icon_values['tablet'] ) ? $custom_icon_values['tablet'] : '';
            $custom_icon_phone  = isset( $custom_icon_values['phone'] ) ? $custom_icon_values['phone'] : '';


            $button_link = trim($button_link);


            $multi_view     = et_pb_multi_view_options( $this );
            $button_output = $this->render_button([
                'button_classname' => ["dipi-button-grid", "dipi-button-wrap"],
                'button_custom' => $button_custom,
                'button_rel' => $button_rel,
                'button_text' => $button_text ? $button_text : 'Click Here',
                'button_url' => $button_link ? $button_link : '#',
                'url_new_window' => $button_link_target,
                'custom_icon'         => $custom_icon,
                'custom_icon_tablet'  => $custom_icon_tablet,
                'custom_icon_phone'   => $custom_icon_phone,
                'has_wrapper' => false,
            ]);
        } else {
            $text_info = $this->props['text_info'];
            $button_output = sprintf('<div class="dipi-text-grid dipi-text-wrap">%1$s</div>', esc_attr($text_info));
        }


        return $button_output;
    }
}

new DIPI_ButtonGridChild();
