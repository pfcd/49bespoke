<?php

class DIPI_ContentSlider extends DIPI_Builder_Module {
    public $slug = 'dipi_content_slider';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/image-slider',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init() {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__('Pixel Content Slider', 'dipi-divi-pixel');
        $this->child_slug = 'dipi_content_slider_child';
        $this->main_css_element = '%%order_class%%.dipi_content_slider';

        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'settings' => esc_html__('Settings', 'dipi-divi-pixel'),
                    'nav_setting' => esc_html__('Navigation', 'dipi-divi-pixel'),
                    'content_animation' => esc_html__('Content Animation', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'navigation' => esc_html__('Navigation', 'dipi-divi-pixel'),
                    'progress_line' => [
                        'title' => esc_html__('Progress Line', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'normal' => array(
                                'name' => esc_html__('Normal', 'dipi-divi-pixel'),
                            ),
                            'active'        => array(
                                'name' => esc_html__('Active', 'dipi-divi-pixel'),
                            ),
                        ),
                    ],
                    'gradations' => [
                        'title' => esc_html__('Gradations', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'normal' => array(
                                'name' => esc_html__('Normal', 'dipi-divi-pixel'),
                            ),
                            'active'        => array(
                                'name' => esc_html__('Active', 'dipi-divi-pixel'),
                            ),
                        ),
                    ],
                    'slider_pin' =>  [
                        'title' => esc_html__('Slider Pin', 'dipi-divi-pixel'),
                    ],
                    'label' => [
                        'title' => esc_html__('Label', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'normal' => array(
                                'name' => esc_html__('Normal', 'dipi-divi-pixel'),
                            ),
                            'active'        => array(
                                'name' => esc_html__('Active', 'dipi-divi-pixel'),
                            ),
                        ),
                    ],
                    'desc' => [
                        'title' => esc_html__('Description', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'normal' => array(
                                'name' => esc_html__('Normal', 'dipi-divi-pixel'),
                            ),
                            'active'        => array(
                                'name' => esc_html__('Active', 'dipi-divi-pixel'),
                            ),
                        ),
                    ],
                    
                ]
            ]
        ];
    }
    
    public function get_custom_css_fields_config() {
        $custom_css_fields = [];
        $custom_css_fields['label'] = [
            'label' => esc_html__('Label', 'dipi-divi-pixel'),
            'selector' => '.content-slider-label',
        ];
        $custom_css_fields['active_label'] = [
            'label' => esc_html__('Active Label', 'dipi-divi-pixel'),
            'selector' => '.content-slider-item.active .content-slider-label',
        ];
        $custom_css_fields['description'] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'selector' => '.content-slider-desc',
        ];
        $custom_css_fields['active_description'] = [
            'label' => esc_html__('Active Description', 'dipi-divi-pixel'),
            'selector' => '.content-slider-item.active .content-slider-description',
        ];
        $custom_css_fields['slider_pin'] = [
            'label' => esc_html__('Slider Pin', 'dipi-divi-pixel'),
            'selector' => '.dipi-slider-pin',
        ];
        $custom_css_fields['progress_line'] = [
            'label' => esc_html__('Progress Line', 'dipi-divi-pixel'),
            'selector' => '.dipi-content-slider .dipi-progress-line',
        ];
        $custom_css_fields['active_progress_line'] = [
            'label' => esc_html__('Active Progress Line', 'dipi-divi-pixel'),
            'selector' => '.dipi-content-slider .dipi-progress-line-active',
        ];
        $custom_css_fields['gradations'] = [
            'label' => esc_html__('Gradations', 'dipi-divi-pixel'),
            'selector' => '.content-slider-gradations',
        ];
        $custom_css_fields['active_gradations'] = [
            'label' => esc_html__('Active Gradations', 'dipi-divi-pixel'),
            'selector' => '.content-slider-item.active .content-slider-gradations',
        ];
        $custom_css_fields['gradations_wrapper'] = [
            'label' => esc_html__('Gradations Wrapper', 'dipi-divi-pixel'),
            'selector' => '.content-slider-gradations-wrapper',
        ];
        $custom_css_fields['active_gradations_wrapper'] = [
            'label' => esc_html__('Active Gradations Wrapper', 'dipi-divi-pixel'),
            'selector' => '.content-slider-item.active .content-slider-gradations-wrapper',
        ];
        return $custom_css_fields;
    }

    public function get_fields() 
    {
        $fields = [];
        /* Content Settings */
        $fields["show_active_selector_only_builder"] = [
            'label' => esc_html__('Show Active Selector Only in Visual Builder', 'dipi-divi-pixel'),
            'description'      => esc_html__( 'Show All Selectors in Builder or Show only selector of Active Item.\n This setting is only for Builder.', 'et_builder' ),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'settings',
        ];
        $fields["label_position"] = [
            'label' => esc_html__('Label Position', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'bottom',
            'options' => [
                'top' => esc_html__('Top', 'dipi-divi-pixel'),
                'bottom' => esc_html__('Bottom', 'dipi-divi-pixel'),
                /*'Top and Bottom' => esc_html__('Top and Bottom', 'dipi-divi-pixel'),*/
            ],
            'toggle_slug' => 'settings',
            'mobile_options' => true,
        ];
        $fields['navigation'] = [
            'label' => esc_html__('Navigation', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'nav_setting',
            'mobile_options' => true,
            'default' => 'off',
        ];
        $fields['navigation_on_hover'] = [
            'label' => esc_html__('Show Navigation on Hover', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'nav_setting',
            'show_if' => ['navigation' => 'on'],
            'default' => 'off',
        ];
        $fields['navigation_prev_icon_yn'] = [
            'label' => esc_html__('Prev Nav Custom Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
        ];

        $fields['navigation_prev_icon'] = [
            'label' => esc_html__('Select Previous Nav icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'class' => array('et-pb-font-icon'),
            'default' => '8',
            'show_if' => ['navigation_prev_icon_yn' => 'on'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
        ];

        $fields['navigation_next_icon_yn'] = [
            'label' => esc_html__('Next Nav Custom Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => array(
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ),
            'default' => 'off',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
        ];

        $fields['navigation_next_icon'] = [
            'label' => esc_html__('Select Next Nav icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'class' => array('et-pb-font-icon'),
            'default' => '9',
            'show_if' => ['navigation_next_icon_yn' => 'on'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
        ];

        $fields['navigation_size'] = [
            'label' => esc_html__('Icon Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'range_settings' => array(
                'min' => '1',
                'max' => '100',
                'step' => '1',
            ),
            'default' => 30,
            'validate_unit' => false,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
            'mobile_options' => true,
        ];

        $fields['navigation_padding'] = [
            'label' => esc_html__('Icon Padding', 'dipi-divi-pixel'),
            'type' => 'range',
            'range_settings' => [
                'min' => '1',
                'max' => '100',
                'step' => '1',
            ],
            'default' => 30,
            'validate_unit' => false,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
            'mobile_options' => true,
        ];

        $fields['navigation_color'] = [
            'label' => esc_html('Arrow Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => et_builder_accent_color(),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
            'hover' => 'tabs',
        ];

        $fields['navigation_bg_color'] = [
            'label' => esc_html('Arrow Background', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
            'hover' => 'tabs',
        ];

        $fields['navigation_circle'] = [
            'label' => esc_html__('Circle Arrow', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => array(
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ),
            'default' => 'off',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
        ];

        $fields['navigation_position_left'] = [
            'label' => esc_html('Left Navigation Position', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '0px',
            'default_on_front' => '0px',
            'default_unit' => 'px',
            'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
            'range_settings' => [
                'min' => '-200',
                'max' => '200',
                'step' => '1',
            ],
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
        ];

        $fields['navigation_position_right'] = [
            'label' => esc_html('Right Navigation Position', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '0px',
            'default_on_front' => '0px',
            'default_unit' => 'px',
            'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
            'range_settings' => [
                'min' => '-200',
                'max' => '200',
                'step' => '1',
            ],
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
        ];
        $fields['navigation_position_vertical'] = [
            'label' => esc_html('Vertical Navigation Position', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '0px',
            'default_on_front' => '0px',
            'default_unit' => 'px',
            'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
            'range_settings' => [
                'min' => '-200',
                'max' => '200',
                'step' => '1',
            ],
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
        ];
        /*
        $fields["show_gradations"] = [
            'label' => esc_html__('Show Gradations', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'on',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'settings',
        ];*/
        /*$fields["show_description"] = [
            'label' => esc_html__('Show Description', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'settings',
        ];*/

        $fields["move_slider_with_pin"] = [
            'label' => esc_html__('Move Slider with Pin', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'on',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'settings',
        ];
        $fields["move_slider_with_progress_line"] = [
            'label' => esc_html__('Move Slider with Progress Line', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'options' => array(
                'disable' => 'Disable',
                'on_click' => 'On Click',
                'on_hover' => 'On Hover',
            ),
            'default' => 'on_click',
            'toggle_slug' => 'settings',
        ];
        $fields["move_slider_with_label"] = [
            'label' => esc_html__('Move Slider with Label', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'options' => array(
                'disable' => 'Disable',
                'on_click' => 'On Click',
                'on_hover' => 'On Hover',
            ),
            'default' => 'on_click',
            'toggle_slug' => 'settings',
        ];
        $fields["content_animation"] = [
            'label' => esc_html__('Animation Type', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'none',
            'options' => [
                'none' => esc_html__('None', 'dipi-divi-pixel'),
                'fadeIn' => esc_html__('Fade In', 'dipi-divi-pixel'),
                'fadeInLeftShort' => esc_html__('FadeIn Left', 'dipi-divi-pixel'),
                'fadeInRightShort' => esc_html__('FadeIn Right', 'dipi-divi-pixel'),
                'fadeInUpShort' => esc_html__('FadeIn Up', 'dipi-divi-pixel'),
                'fadeInDownShort' => esc_html__('FadeIn Down', 'dipi-divi-pixel'),
                'zoomInShort' => esc_html__('Grow', 'dipi-divi-pixel'),
                'bounceInShort' => esc_html__('BounceIn', 'dipi-divi-pixel'),
                'bounceInLeftShort' => esc_html__('BounceIn Left', 'dipi-divi-pixel'),
                'bounceInRightShort' => esc_html__('BounceIn Right', 'dipi-divi-pixel'),
                'bounceInUpShort' => esc_html__('BounceIn Up', 'dipi-divi-pixel'),
                'bounceInDownShort' => esc_html__('BounceIn Down', 'dipi-divi-pixel'),
                'flipInXShort' => esc_html__('FlipInX', 'dipi-divi-pixel'),
                'flipInYShort' => esc_html__('FlipInY', 'dipi-divi-pixel'),
                'jackInTheBoxShort' => esc_html__('JackInTheBox', 'dipi-divi-pixel'),
                'rotateInShort' => esc_html__('RotateIn', 'dipi-divi-pixel'),
                'rotateInDownLeftShort' => esc_html__('RotateIn DownLeft', 'dipi-divi-pixel'),
                'rotateInUpLeftShort' => esc_html__('RotateIn UpLeft', 'dipi-divi-pixel'),
                'rotateInDownRightShort' => esc_html__('RotateIn DownRight', 'dipi-divi-pixel'),
                'rotateInUpRightShort' => esc_html__('RotateIn UpRight', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'content_animation',
        ];
        $fields['content_delay'] = [
            'label' => esc_html__('Interval Delay', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'default' => '100ms',
            'default_on_front' => '100ms',
            'default_unit' => 'ms',
            'range_settings' => [
                'min' => '0',
                'max' => '3000',
                'step' => '100',
            ],
            'validate_unit' => true,
            'toggle_slug' => 'content_animation',
            'show_if_not'=> [
                'content_animation' => 'none'
            ]
        ];
    
        $fields['content_speed'] = [
            'label' => esc_html__('Speed', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'default' => '600ms',
            'default_on_front' => '600ms',
            'default_unit' => 'ms',
            'range_settings' => [
                'min' => '0',
                'max' => '2000',
                'step' => '100',
            ],
            'validate_unit' => true,
            'toggle_slug' => 'content_animation',
            'show_if_not'=> [
                'content_animation' => 'none'
            ]
        ]; 
        /* Design Settings */
        // Progress Line
        $fields['progress_line_color'] = [
            'label' => esc_html('Line Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'progress_line',
            'sub_toggle'  => 'normal',
            'default' => '#d8d8d8',
        ];

        
        $fields['progress_line_weight'] = [
            'label' => esc_html__('Line Weight', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'progress_line',
            'sub_toggle'  => 'normal',
            'type' => 'range',
            'range_settings' => array(
                'min' => '0',
                'max' => '50',
                'step' => '1',
            ),
            'default' => '7px',
            'allowed_units' => ['px'],
        ];
        $fields['progress_line_margin'] = [
            'label' => esc_html__('Line Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'progress_line',
            'sub_toggle'  => 'normal',
        ];
        // Active Progress Line
        $fields['progress_active_line_color'] = [
            'label' => esc_html('Active Line Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'progress_line',
            'sub_toggle'  => 'active',
            'default'   => '#FF4200'
        ];

        
        $fields['progress_active_line_weight'] = [
            'label' => esc_html__('Active Line Weight', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'progress_line',
            'sub_toggle'  => 'active',
            'type' => 'range',
            'range_settings' => array(
                'min' => '0',
                'max' => '50',
                'step' => '1',
            ),
            'allowed_units' => ['px'],
        ];
        $fields['progress_active_line_margin'] = [
            'label' => esc_html__('Active Line Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'progress_line',
            'sub_toggle'  => 'active',
        ];

        // Gradations
        $fields['gradations_width'] = [
            'label' => esc_html__('Width', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'gradations',
            'sub_toggle'  => 'normal',
            'type' => 'range',
            'range_settings' => array(
                'min' => '0',
                'max' => '50',
                'step' => '1',
            ),
            'default_unit' => 'px',
            'default' => '1px',
            /*'show_if' => [
                'show_gradations' => 'on'
            ]*/
        ];
	    $fields['gradations_height'] = [
            'label' => esc_html__('Height', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'gradations',
            'sub_toggle'  => 'normal',
            'type' => 'range',
            'range_settings' => array(
                'min' => '0',
                'max' => '50',
                'step' => '1',
            ),
            'default_unit' => 'px',
            'default' => '10px',
             /*'show_if' => [
                'show_gradations' => 'on'
            ]*/
        ];
        $fields['gradations_color'] = [
            'label' => esc_html('Gradations Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'gradations',
            'sub_toggle'  => 'normal',
            'default'   => '#FF4200',
             /*'show_if' => [
                'show_gradations' => 'on'
            ]*/
        ];
        $fields['gradations_margin'] = [
            'label' => esc_html__('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'gradations',
            'sub_toggle'  => 'normal',
             /*'show_if' => [
                'show_gradations' => 'on'
            ]*/
        ];

        // Active Gradations
        $fields['active_gradations_width'] = [
            'label' => esc_html__('Width', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'gradations',
            'sub_toggle'  => 'active',
            'type' => 'range',
            'range_settings' => array(
                'min' => '0',
                'max' => '50',
                'step' => '1',
            ),
            'default' => '1px',
            'default_unit' => 'px',
             /*'show_if' => [
                'show_gradations' => 'on'
            ]*/
        ];
	    $fields['active_gradations_height'] = [
            'label' => esc_html__('Height', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'gradations',
            'sub_toggle'  => 'active',
            'type' => 'range',
            'range_settings' => array(
                'min' => '0',
                'max' => '50',
                'step' => '1',
            ),
            'default_unit' => 'px',
            'default' => '10px',
             /*'show_if' => [
                'show_gradations' => 'on'
            ]*/
        ];
        $fields['active_gradations_color'] = [
            'label' => esc_html('Gradations Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'gradations',
            'sub_toggle'  => 'active',
            'default'   => '#FF4200',
             /*'show_if' => [
                'show_gradations' => 'on'
            ]*/
        ];
        $fields['active_gradations_margin'] = [
            'label' => esc_html__('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'gradations',
            'sub_toggle'  => 'active',
             /*'show_if' => [
                'show_gradations' => 'on'
            ]*/
        ];

        // Slider Pin
        $fields['circle_size'] = [
            'label' => esc_html__('Circle Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'slider_pin',
            'default' => '20px',
            'default_unit' => 'px',
            'default_on_front' => '20px',
            'allowed_units' => array('px'),
            'range_settings' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'sticky' => true,
            'mobile_options' => true,
            'hover' => 'tabs',
        ];
        $fields['circle_border_color'] = [
            'default' => '#FF4200',
            'label' => esc_html__('Circle Border Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'slider_pin',
            'hover' => 'tabs',
            'mobile_options' => true,
            'sticky' => true,

        ];
        $fields['circle_bg_color'] = [
            'label' => esc_html__('Circle Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'toggle_slug' => 'slider_pin',
            'tab_slug' => 'advanced',
            'default' => 'white',

        ];

        $fields['circle_border_width'] = [
            'label' => esc_html__('Circle Border Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'slider_pin',
            'default' => '7px',
            'default_unit' => 'px',
            'default_on_front' => '7px',
            'allowed_units' => array('em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
            'range_settings' => array(
                'min' => '0',
                'max' => '50',
                'step' => '1',
            ),
            'sticky' => true,
            'mobile_options' => true,
            'hover' => 'tabs',

        ];
        $fields['circle_border_style'] = [
            'label' => esc_html__('Circle Border Style', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'layout',
            'options' => et_builder_get_border_styles(),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'slider_pin',
            'default' => 'solid',
            'mobile_options' => true,
            'hover' => 'tabs',

        ];

        //Label
        $fields['label_bg_color'] = [
            'label' => esc_html__('Label Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'toggle_slug' => 'label',
            'sub_toggle'  => 'normal',
            'tab_slug' => 'advanced',
            'hover' => 'tabs',

        ];
        $fields['label_margin'] = [
            'label' => esc_html__('Label Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'label',
            'sub_toggle'  => 'normal',
        ];
        $fields['label_padding'] = [
            'label' => esc_html__('Label Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '4px|8px|4px|8px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'label',
            'sub_toggle'  => 'normal',
        ];
        //Active Label
        $fields['active_label_bg_color'] = [
            'label' => esc_html__('Active Label Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'toggle_slug' => 'label',
            'sub_toggle'  => 'active',
            'tab_slug' => 'advanced',
            'hover' => 'tabs',
        ];
        $fields['active_label_margin'] = [
            'label' => esc_html__('Active Label Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'label',
            'sub_toggle'  => 'active',
        ];
        $fields['active_label_padding'] = [
            'label' => esc_html__('Active Label Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'label',
            'sub_toggle'  => 'active',
        ];
        //Description
        $fields['desc_bg_color'] = [
            'label' => esc_html__('Description Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'toggle_slug' => 'desc',
            'sub_toggle'  => 'normal',
            'tab_slug' => 'advanced',
            'hover' => 'tabs',

        ];
        $fields['desc_margin'] = [
            'label' => esc_html__('Description Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'desc',
            'sub_toggle'  => 'normal',
        ];
        $fields['desc_padding'] = [
            'label' => esc_html__('Description Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '4px|8px|4px|8px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'desc',
            'sub_toggle'  => 'normal',
        ];
        //Active desc
        $fields['active_desc_bg_color'] = [
            'label' => esc_html__('Active Description Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'toggle_slug' => 'desc',
            'sub_toggle'  => 'active',
            'tab_slug' => 'advanced',
            'hover' => 'tabs',
        ];
        $fields['active_desc_margin'] = [
            'label' => esc_html__('Active Description Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'desc',
            'sub_toggle'  => 'active',
        ];
        $fields['active_desc_padding'] = [
            'label' => esc_html__('Active Description Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'desc',
            'sub_toggle'  => 'active',
        ];
        return $fields;
    }


    public function get_advanced_fields_config() 
    {

        $advanced_fields = [];
        $advanced_fields['text'] = false;

        $label_selector = '%%order_class%% .content-slider-label';
        $active_label_selector = '%%order_class%% .content-slider-item.active .content-slider-label';
        $desc_selector = '%%order_class%% .content-slider-desc';
        $active_desc_selector = '%%order_class%% .content-slider-item.active .content-slider-desc';
        $progress_line_selector = '%%order_class%% .dipi-content-slider .dipi-progress-line';
        $progress_active_line_selector = '%%order_class%% .dipi-content-slider .dipi-progress-line-active';
        $progress_all_line_selector = "$progress_line_selector, $progress_active_line_selector";
        /* Label */
        $advanced_fields['fonts']['label'] = [
            'label' => esc_html__('Label', 'dipi-divi-pixel'),
            'css' => [
                'main' => $label_selector,
                'color' => $label_selector,
            ],
            'toggle_slug' => 'label',
            'sub_toggle' => 'normal',
        ];
        $advanced_fields['borders']['default'] = [
			'css' => [
				'main' => [
					'border_radii' => '%%order_class%%',
					'border_radii_hover' => '%%order_class%%:hover',
					'border_styles' => '%%order_class%%',
					'border_styles_hover' => '%%order_class%%:hover',
				],
			],
		];
        $advanced_fields['borders']['label'] = [
            'label_prefix' => esc_html__('Label', 'dipi-divi-pixel'),
            'css' => [
                'main' => [
                    'border_radii' => $label_selector,
                    'border_styles' => $label_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'label',
            'sub_toggle' => 'normal'
        ];
        $advanced_fields['box_shadow']['default'] = [
            'css' => [
                'main' => '%%order_class%%'
            ]
        ];
        $advanced_fields['box_shadow']['label'] = [
            'label' => esc_html__('Label', 'dipi-divi-pixel'),
            'css' => [
                'main' =>  $label_selector,
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'label',
            'sub_toggle' => 'normal'
        ];
         /* Active Label */
         $advanced_fields['fonts']['active_label'] = [
            'label' => esc_html__('Active Label', 'dipi-divi-pixel'),
            'css' => [
                'main' => $active_label_selector,
                'color' => $active_label_selector,
            ],
            'toggle_slug' => 'label',
            'sub_toggle' => 'active',
        ];
        $advanced_fields['borders']['active_label'] = [
            'label_prefix' => esc_html__('Active Label', 'dipi-divi-pixel'),
            'css' => [
                'main' => [
                    'border_radii' => $active_label_selector,
                    'border_styles' => $active_label_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'label',
            'sub_toggle' => 'active'
        ];
        $advanced_fields['box_shadow']['active_label'] = [
            'label' => esc_html__('Active Label', 'dipi-divi-pixel'),
            'css' => [
                'main' =>  $active_label_selector,
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'label',
            'sub_toggle' => 'active'
        ];
        /* Description */
        $advanced_fields['fonts']['desc'] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'css' => [
                'main' => $desc_selector,
                'color' => $desc_selector,
            ],
            'toggle_slug' => 'desc',
            'sub_toggle' => 'normal',
        ];
       
        $advanced_fields['borders']['desc'] = [
            'desc_prefix' => esc_html__('desc', 'dipi-divi-pixel'),
            'css' => [
                'main' => [
                    'border_radii' => $desc_selector,
                    'border_styles' => $desc_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'desc',
            'sub_toggle' => 'normal'
        ];

        $advanced_fields['box_shadow']['desc'] = [
            'label' => esc_html__('desc', 'dipi-divi-pixel'),
            'css' => [
                'main' =>  $desc_selector,
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'desc',
            'sub_toggle' => 'normal'
        ];
         /* Active desc */
         $advanced_fields['fonts']['active_desc'] = [
            'label' => esc_html__('Active desc', 'dipi-divi-pixel'),
            'css' => [
                'main' => $active_desc_selector,
                'color' => $active_desc_selector,
            ],
            'toggle_slug' => 'desc',
            'sub_toggle' => 'active',
        ];
        $advanced_fields['borders']['active_desc'] = [
            'desc_prefix' => esc_html__('Active desc', 'dipi-divi-pixel'),
            'css' => [
                'main' => [
                    'border_radii' => $active_desc_selector,
                    'border_styles' => $active_desc_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'desc',
            'sub_toggle' => 'active'
        ];
        $advanced_fields['box_shadow']['active_desc'] = [
            'label' => esc_html__('Active desc', 'dipi-divi-pixel'),
            'css' => [
                'main' =>  $active_desc_selector,
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'desc',
            'sub_toggle' => 'active'
        ];
        /* Progress Line */
        $advanced_fields['borders']['progress_line'] = [
            'label_prefix' => esc_html__('Line', 'dipi-divi-pixel'),
            'css' => [
                'main' => [
                    'border_radii' => $progress_line_selector,
                    'border_styles' => $progress_line_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'progress_line',
            'sub_toggle' => 'normal'
        ];


        $advanced_fields['box_shadow']['progress_line'] = [
            'label' => esc_html__('Line Box shadow', 'dipi-divi-pixel'),
            'css' => [
                'main' =>  $progress_line_selector,
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'progress_line',
            'sub_toggle' => 'normal'
        ];
        /* Active Progress Line */
        $advanced_fields['borders']['progress_active_line'] = [
            'label_prefix' => esc_html__('Active Line', 'dipi-divi-pixel'),
            'css' => [
                'main' => [
                    'border_radii' => $progress_active_line_selector,
                    'border_styles' => $progress_active_line_selector,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'progress_line',
            'sub_toggle' => 'active'
        ];

        $advanced_fields['box_shadow']['progress_active_line'] = [
            'label' => esc_html__('Active Line Box Shadow', 'dipi-divi-pixel'),
            'css' => [
                'main' =>  $progress_active_line_selector,
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'progress_line',
            'sub_toggle' => 'active'
        ];
        
        return $advanced_fields;
    }

    public function dipi_apply_css($render_slug) {

        $label_selector = '%%order_class%% .content-slider-label';
        $label_hover_selector = '%%order_class%% .content-slider-label:hover';
        $active_label_selector = '%%order_class%% .content-slider-item.active .content-slider-label';
        $active_label_hover_selector = '%%order_class%% .content-slider-item.active .content-slider-label:hover';
        $desc_selector = '%%order_class%% .content-slider-desc';
        $desc_hover_selector = '%%order_class%% .content-slider-desc:hover';
        $active_desc_selector = '%%order_class%% .content-slider-item.active .content-slider-desc';
        $active_desc_hover_selector = '%%order_class%% .content-slider-item.active .content-slider-desc:hover';
        $progress_line_selector = '%%order_class%%  .dipi-content-slider .dipi-progress-line';
        $progress_active_line_selector = '%%order_class%%  .dipi-content-slider .dipi-progress-line-active';
        $progress_all_line_selector = "$progress_line_selector, $progress_active_line_selector";
        $gradations_selector = "%%order_class%% .content-slider-gradations";
        $gradations_wrapper_selector = "%%order_class%% .content-slider-gradations-wrapper";
        $gradations_active_selector = "%%order_class%% .content-slider-item.active .content-slider-gradations";
        $gradations_active_wrapper_selector = "%%order_class%% .content-slider-item.active .content-slider-gradations-wrapper";
        $slider_pin_selector = "%%order_class%%.dipi_content_slider .dipi-slider-pin";
        $navigation_container_class = "%%order_class%% .dipi-navigation";
        $navigation_class = "%%order_class%%  .dipi-nav-button";
        $navigation_position_left_class = "%%order_class%% .dipi-prev-button, %%order_class%%:hover .dipi-prev-button.dipi-nav-button.show_on_hover";
        $navigation_position_right_class = "%%order_class%% .dipi-next-button, %%order_class%%:hover .dipi-next-button.dipi-nav-button.show_on_hover";
        $navigation_position_left_area_class = "%%order_class%% .dipi-prev-button.dipi-nav-button.show_on_hover:before";
        $navigation_position_right_area_class = "%%order_class%% .dipi-next-button.dipi-nav-button.show_on_hover:before";
        $navigation_hover_selector = '%%order_class%% .dipi-nav-button:hover:after';
        $navigation_hover_bg_selector = '%%order_class%% .dipi-nav-button:hover';
        // Navigation
        $this->apply_custom_style_for_hover(
            $render_slug,
            'navigation_color',
            'color',
            $navigation_hover_selector,
            true
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'navigation_bg_color',
                'selector' => $navigation_class,
                'css_property' => 'background',
                'render_slug' => $render_slug,
                'type' => 'color',
                'important' => true
            )
        );

        $this->apply_custom_style_for_hover(
            $render_slug,
            'navigation_bg_color',
            'background',
            $navigation_hover_bg_selector,
            true
        );

        $this->generate_styles(
            array(
                'base_attr_name' => 'navigation_size',
                'selector' => $navigation_class,
                'css_property' => 'width',
                'render_slug' => $render_slug,
                'type' => 'range',
                'important' => true
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'navigation_size',
                'selector' => $navigation_class,
                'css_property' => 'height',
                'render_slug' => $render_slug,
                'type' => 'range',
                'important' => true
            )
        );

        $this->generate_styles(
            array(
                'base_attr_name' => 'navigation_size',
                'selector' => '%%order_class%% .dipi-next-button:after, %%order_class%% .dipi-next-button:before, %%order_class%% .dipi-prev-button:after, %%order_class%% .dipi-prev-button:before',
                'css_property' => 'font-size',
                'render_slug' => $render_slug,
                'type' => 'range',
                'important' => true
            )
        );

        $this->generate_styles(
            array(
                'base_attr_name' => 'navigation_padding',
                'selector' => '%%order_class%% .dipi-next-button, %%order_class%% .dipi-prev-button',
                'css_property' => 'padding',
                'render_slug' => $render_slug,
                'type' => 'range',
                'important' => true
            )
        );

        if ('on' == $this->props['navigation_circle']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-next-button, %%order_class%% .dipi-prev-button',
                'declaration' => 'border-radius: 50% !important;',
            ));
        }

  
        $this->generate_styles(
            array(
                'base_attr_name' => 'navigation_position_left',
                'selector' => $navigation_position_left_class,
                'css_property' => 'left',
                'render_slug' => $render_slug,
                'type' => 'range',
                'important' => true
            )
        );



        /* Left navigation area */
        $navigation_position_left = $this->props['navigation_position_left'];
        $navigation_position_left_tablet = $this->props['navigation_position_left_tablet'];
        $navigation_position_left_phone = $this->props['navigation_position_left_phone'];
        $navigation_position_left_last_edited = $this->props['navigation_position_left_last_edited'];
        $navigation_position_left_responsive_status = et_pb_get_responsive_status($navigation_position_left_last_edited);

        if ('' !== $navigation_position_left && $navigation_position_left < 0) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_left_area_class,
                'declaration' => sprintf('width: %1$spx !important;', -(int) $navigation_position_left),
            ));
        }

        if ('' !== $navigation_position_left_tablet && $navigation_position_left_responsive_status && $navigation_position_left_tablet < 0) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_left_area_class,
                'declaration' => sprintf('width: %1$spx !important;', -(int) $navigation_position_left_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if ('' !== $navigation_position_left_phone && $navigation_position_left_responsive_status && $navigation_position_left_phone < 0) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_left_area_class,
                'declaration' => sprintf('width: %1$spx !important;', -(int) $navigation_position_left_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }


        $this->generate_styles(
            array(
                'base_attr_name' => 'navigation_position_right',
                'selector' => $navigation_position_right_class,
                'css_property' => 'right',
                'render_slug' => $render_slug,
                'type' => 'range',
                'important' => true
            )
        );
        
        $navigation_position_right = $this->props['navigation_position_right'];
        $navigation_position_right_tablet = $this->props['navigation_position_right_tablet'];
        $navigation_position_right_phone = $this->props['navigation_position_right_phone'];
        $navigation_position_right_last_edited = $this->props['navigation_position_right_last_edited'];
        $navigation_position_right_responsive_status = et_pb_get_responsive_status($navigation_position_right_last_edited);
        if ('' !== $navigation_position_right && $navigation_position_right < 0) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_right_area_class,
                'declaration' => sprintf('width: %1$spx !important;', -(int) $navigation_position_right),
            ));
        }

        if ('' !== $navigation_position_right_tablet && $navigation_position_right_responsive_status && $navigation_position_right_tablet < 0) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_right_area_class,
                'declaration' => sprintf('width: %1$spx !important;', -(int) $navigation_position_right_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if ('' !== $navigation_position_right_phone && $navigation_position_right_responsive_status && $navigation_position_right_phone < 0) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_right_area_class,
                'declaration' => sprintf('width: %1$spx !important;', -(int) $navigation_position_right_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }
        $this->generate_styles(
            array(
                'base_attr_name' => 'navigation_position_vertical',
                'selector' => $navigation_container_class,
                'css_property' => 'top',
                'render_slug' => $render_slug,
                'type' => 'range',
                'important' => true
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'navigation_color',
                'selector' => '%%order_class%% .dipi-next-button:after, %%order_class%% .dipi-next-button:before, %%order_class%% .dipi-prev-button:after, %%order_class%% .dipi-prev-button:before',
                'css_property' => 'color',
                'render_slug' => $render_slug,
                'type' => 'color',
                'important' => true
            )
        );


        $navigation = $this->props['navigation'];
        $navigation_tablet = $this->props['navigation_tablet'];
        $navigation_phone = $this->props['navigation_phone'];
        $navigation_last_edited = $this->props['navigation_last_edited'];
        $navigation_responsive_status = et_pb_get_responsive_status($navigation_last_edited);

        if ('' !== $navigation) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_class,
                'declaration' => sprintf(
                    'display: %1$s !important;', 
                    $navigation === "on" ? "flex" : "none"
                ),
            ));
        }

        if ('' !== $navigation_tablet && $navigation_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_class,
                'declaration' => sprintf(
                    'display: %1$s !important;', 
                    $navigation_tablet === "on" ? "flex" : "none"
                ),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if ('' !== $navigation_phone && $navigation_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_class,
                'declaration' => sprintf(
                    'display: %1$s !important;',
                    $navigation_phone=== "on" ? "flex" : "none")
                ,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }
        
        // Progress Line
        $this->generate_styles(
            array(
                'base_attr_name' => 'progress_line_color',
                'selector' => $progress_line_selector,
                'css_property' => 'background',
                'render_slug' => $render_slug,
                'type' => 'color',
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'progress_line_weight',
                'selector' => $progress_line_selector,
                'css_property' => 'height',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'progress_line_margin',
            'margin',
            $progress_line_selector
        );
        //Active Progress Line
        $this->generate_styles(
            array(
                'base_attr_name' => 'progress_active_line_color',
                'selector' => $progress_active_line_selector,
                'css_property' => 'background',
                'render_slug' => $render_slug,
                'type' => 'color',
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'progress_active_line_weight',
                'selector' => $progress_active_line_selector,
                'css_property' => 'height',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'progress_active_line_margin',
            'margin',
            $progress_active_line_selector
        );
        // Gradations   
        $this->generate_styles(
            array(
                'base_attr_name' => 'gradations_width',
                'selector' => $gradations_selector,
                'css_property' => 'width',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'gradations_height',
                'selector' => $gradations_selector,
                'css_property' => 'height',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'gradations_color',
                'selector' => $gradations_selector,
                'css_property' => 'background',
                'render_slug' => $render_slug,
                'type' => 'color',
            )
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'gradations_margin',
            'margin',
            $gradations_wrapper_selector
        );

        // Active Gradations
        $this->generate_styles(
            array(
                'base_attr_name' => 'active_gradations_width',
                'selector' => $gradations_active_selector,
                'css_property' => 'width',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'active_gradations_height',
                'selector' => $gradations_active_selector,
                'css_property' => 'height',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'active_gradations_color',
                'selector' => $gradations_active_selector,
                'css_property' => 'background',
                'render_slug' => $render_slug,
                'type' => 'color',
            )
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'active_gradations_margin',
            'margin',
            $gradations_active_wrapper_selector
        );

        // Slider Pin
        $this->generate_styles(
            array(
                'base_attr_name' => 'circle_size',
                'selector' => $slider_pin_selector,
                'css_property' => 'width',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'circle_size',
                'selector' => $slider_pin_selector,
                'css_property' => 'height',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'circle_border_color',
                'selector' => $slider_pin_selector,
                'css_property' => 'border-color',
                'render_slug' => $render_slug,
                'type' => 'color',
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'circle_bg_color',
                'selector' => $slider_pin_selector,
                'css_property' => 'background',
                'render_slug' => $render_slug,
                'type' => 'color',
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'circle_border_width',
                'selector' => $slider_pin_selector,
                'css_property' => 'border-width',
                'render_slug' => $render_slug,
                'type' => 'color',
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'circle_border_style',
                'selector' => $slider_pin_selector,
                'css_property' => 'border-style',
                'render_slug' => $render_slug,
                'type' => 'color',
            )
        );
        //Label
        $this->dipi_apply_custom_style(
            $render_slug,
            'label_bg_color',
            'background',
            $label_selector
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'label_margin',
            'margin',
            $label_selector
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'label_padding',
            'padding',
            $label_selector
        );
        //Active Label
        
        $this->dipi_apply_custom_style(
            $render_slug,
            'active_label_bg_color',
            'background',
            $active_label_selector
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'active_label_margin',
            'margin',
            $active_label_selector
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'active_label_padding',
            'padding',
            $active_label_selector
        );
        //Description
        $this->dipi_apply_custom_style(
            $render_slug,
            'desc_bg_color',
            'background',
            $desc_selector
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'desc_margin',
            'margin',
            $desc_selector
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'desc_padding',
            'padding',
            $desc_selector
        );
        //Active Description
        
        $this->dipi_apply_custom_style(
            $render_slug,
            'active_desc_bg_color',
            'background',
            $active_desc_selector
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'active_desc_margin',
            'margin',
            $active_desc_selector
        );
        $this->dipi_apply_custom_margin_padding(
            $render_slug,
            'active_desc_padding',
            'padding',
            $active_desc_selector
        );
    }


    public function before_render() {
        global $dipi_cs_selectors, $dipi_active_id;
        $dipi_cs_selectors = [];
        $dipi_active_id = -1;
    }

    public function render($attrs, $content, $render_slug) {
        global $dipi_cs_selectors, $dipi_active_id, $dipi_active_order_num;
        wp_enqueue_script('dipi_content_slider_public');
        wp_enqueue_style('dipi_animate');
        $label_position = $this->props['label_position'];
        $show_active_selector_only_builder = $this->props['show_active_selector_only_builder'];
        $content_animation = $this->props['content_animation'];
        $move_slider_with_pin = $this->props['move_slider_with_pin'];
        $move_slider_with_progress_line = $this->props['move_slider_with_progress_line'];
        $move_slider_with_label = $this->props['move_slider_with_label'];
        $dipi_cs_selectors_string = implode(",", array_filter($dipi_cs_selectors, function($var) { return $var && strlen(trim($var)); }));
        $navigation = $this->props['navigation'];
        $navigation_values = et_pb_responsive_options()->get_property_values($this->props, 'navigation');
        $navigation_tablet = !empty($navigation_values['tablet']) ? $navigation_values['tablet'] : $navigation;
        $navigation_phone = !empty($navigation_values['phone']) ? $navigation_values['phone'] : $navigation_tablet;
        $data_next_icon = $this->props['navigation_next_icon'];
        $data_prev_icon = $this->props['navigation_prev_icon'];
        $navigation_on_hover = $this->props['navigation_on_hover'];
        $next_icon_render = 'data-icon="9"';
        if ('on' === $this->props['navigation_next_icon_yn']) {
            $next_icon_render = sprintf('data-icon="%1$s"', esc_attr(et_pb_process_font_icon($data_next_icon)));
            $this->dipi_generate_font_icon_styles($render_slug, 'navigation_next_icon', '%%order_class%% .dipi-next-button:after');
        }

        $prev_icon_render = 'data-icon="8"';
        if ('on' === $this->props['navigation_prev_icon_yn']) {
            $prev_icon_render = sprintf('data-icon="%1$s"', esc_attr(et_pb_process_font_icon($data_prev_icon)));
            $this->dipi_generate_font_icon_styles($render_slug, 'navigation_prev_icon', '%%order_class%% .dipi-prev-button:after');
        }
        
        $navigation = sprintf(
            '<div class="dipi-navigation">
                <div class="dipi-nav-button dipi-prev-button  %3$s" %1$s></div>
                <div class="dipi-nav-button dipi-next-button  %3$s" %2$s></div>
            </div>
                ',
            $prev_icon_render,
            $next_icon_render,
            $navigation_on_hover === "on" ? "show_on_hover" : ""
        );


        $this->dipi_apply_custom_style(
            $render_slug,
            'content_delay',
            'animation-delay',
            $dipi_cs_selectors_string
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'content_speed',
            'animation-duration',
            $dipi_cs_selectors_string
        );

        $config = [
            'selectors' => implode(";", $dipi_cs_selectors),
            'child_count' => count($dipi_cs_selectors),
            'active_id' => $dipi_active_id,
            'active_order_num' => $dipi_active_order_num,
            'show_only_active' => "on",
            'content_animation' => $content_animation,
            'move_slider_with_pin' => $move_slider_with_pin,
            'move_slider_with_progress_line' => $move_slider_with_progress_line,
            'move_slider_with_label' => $move_slider_with_label
        ];
        $this->dipi_apply_css($render_slug);
        $extra_classes = "";
        if ($move_slider_with_pin === "on") {
            $extra_classes .= " slider_with_pin";
        }
        if ($move_slider_with_progress_line !== "disable") {
            $extra_classes .= " slider_with_line";
        }
        if ($move_slider_with_label !== "disable") {
            $extra_classes .= " slider_with_label";
        }
        if ($label_position !== "bottom") {
            $extra_classes .= " label-$label_position";
        }
        $output = sprintf(
            '<div class="dipi-content-slider %5$s" data-config="%2$s" data-active-id="%3$s" data-active-order-num="%4$s">
                <div class="dipi-progress-line">
                    <div class="dipi-progress-line-active"></div>
                    <div class="dipi-progress-line-event-placeholder"></div>
                    <span class="dipi-slider-pin"></span>
                </div>
                %6$s
                <div class="dipi-content-slider-items">%1$s</div>
            </div>',
            $this->props['content'],
            esc_attr(htmlspecialchars(json_encode($config), ENT_QUOTES, 'UTF-8')) ,
            $dipi_active_id,
            $dipi_active_order_num,
            $extra_classes, #5,
            $navigation
        );
        
        
        return $output;
    }
}

new DIPI_ContentSlider;