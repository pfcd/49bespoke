<?php

class DIPI_ContentSliderChild extends DIPI_Builder_Module
{
    public function init()
    {
        $this->name = esc_html__('Pixel Content Slider Item', 'dipi-divi-pixel');
        $this->plural = esc_html__('Pixel Content Slider Items', 'dipi-divi-pixel');
        $this->slug = 'dipi_content_slider_child';
        $this->vb_support = 'on';
        $this->type = 'child';
        $this->child_title_var = 'label';
        $this->advanced_setting_title_text = esc_html__('New Slider', 'dipi-divi-pixel');
        $this->settings_text = esc_html__('Item Settings', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%';
        //$this->custom_css_tab  = false;
        add_filter('et_pb_all_fields_unprocessed_dipi_content_slider_child', function ($fields) {
            unset($fields['hover_transition_duration']);
            unset($fields['hover_transition_delay']);
            unset($fields['hover_transition_speed_curve']);
            unset($fields['hover_transition_duration_tablet']);
            unset($fields['hover_transition_delay_tablet']);
            unset($fields['hover_transition_speed_curve_tablet']);
            unset($fields['hover_transition_duration_phone']);
            unset($fields['hover_transition_delay_phone']);
            unset($fields['hover_transition_speed_curve_phone']);
            unset($fields['hover_transition_duration_last_edited']);
            unset($fields['hover_transition_delay_last_edited']);
            unset($fields['hover_transition_speed_curve_last_edited']);
            unset($this->settings_modal_toggles['custom_css']['toggles']['hover_transitions'] );
            //unset($this->settings_modal_toggles['custom_css']);
            return $fields;
        });
        
        
    }
    public function get_settings_modal_toggles()
    {
        return [
            'general' => [
                'toggles' => [
                    'content' => esc_html__('Content', 'dipi-divi-pixel'),
                    'tab_selector' => esc_html__('Slide Selector', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
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
                    'slider_pin' =>  [
                        'title' => esc_html__('Slider Pin', 'dipi-divi-pixel'),
                    ],
                ]
            ]
        ];
    }
    
    public function get_advanced_fields_config()
    {
        $advanced_fields = [];
        $advanced_fields['background'] = false;
        // Design Tab
        $advanced_fields['margin_padding'] = false;
        $advanced_fields['link_options'] = false;
        $advanced_fields['max_width'] = false;
        $advanced_fields['text'] = false;
        //$advanced_fields['borders'] = false;
        //$advanced_fields['box_shadow'] = false;
        $advanced_fields['filters'] = false;
        $advanced_fields['transform'] = false;
        // Advanced Tab
        $advanced_fields['scroll_effects'] = false;
        $advanced_fields['position_fields'] = false;
        $advanced_fields['z_index'] = false;
        $advanced_fields['sticky'] = false;
        $advanced_fields['overflow'] = false;
        $advanced_fields['display_conditions'] = false;
        $advanced_fields['form_field'] = false;
        //$advanced_fields['animation'] = false;
        //$advanced_fields['transition_fields'] = false;
        $advanced_fields['image_icon'] = false;
        $advanced_fields['dividers'] = false;
        $advanced_fields['text_shadow'] = false;
        $advanced_fields['image'] = false;
        $advanced_fields['icon_settings'] = false;
        $advanced_fields['child_filters'] = false;
        $advanced_fields['transition'] = false;
        $advanced_fields['link_options'] = false;

        $label_selector = '%%order_class%% .content-slider-label';
        $active_label_selector = '%%order_class%% .content-slider-item.active .content-slider-label';
        $desc_selector = '%%order_class%% .content-slider-desc';
        $active_desc_selector = '%%order_class%% .content-slider-item.active .content-slider-desc';
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
        // Active Label
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
            'desc_prefix' => esc_html__('Description', 'dipi-divi-pixel'),
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
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'css' => [
                'main' =>  $desc_selector,
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'desc',
            'sub_toggle' => 'normal'
        ];
        // Active desc
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
        return $advanced_fields;
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
        $fields["label"] = [
            'label' => esc_html__('Label', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'content',
            'dynamic_content' => 'text'
        ];
        $fields["show_description"] = [
            'label' => esc_html__('Show Description', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'content',
            /*'show_if' => ['parentModule:show_description' => 'on']*/
        ];
        $fields['desc_text']        = [
            'label'           => esc_html__('Description', 'dipi-divi-pixel'),
            'type'            => 'tiny_mce',
            'toggle_slug'     => 'content',
            'dynamic_content' => 'text',
            'option_category' 	=> 'basic_option',
            'show_if'   => ['show_description' => 'on']
            /*'show_if'         => ['parentModule:show_description' => 'on']*/
        ];
        $fields["selector"] = [
            'label' => esc_html__('Selector', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'content',
        ];
        $fields["active_item"] = [
            'label' => esc_html__('Active Item', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'content',
        ];
        $fields['activate_tab_selector'] = [
            'label'             => esc_html__( 'Slide Selector', 'dipi-divi-pixel' ),
            'type'              => 'text',
            'description'       => esc_html__( 'Enter the element Selector that will open this Slide on click (e.g. “services”)', 'dipi-divi-pixel' ),
            'toggle_slug'     => 'tab_selector',
            'tab_slug'        => 'general',
        ];

        $fields['scroll_tab_offset'] = [
            'label'             => esc_html__( 'Scroll To Slider Offset', 'dipi-divi-pixel' ),
            'type'              => 'range',
            'toggle_slug'     => 'tab_selector',
            'tab_slug'        => 'general',
            'default'           => '100px',
            'default_unit'      => 'px',
            'range_settings' => array(
                'min'  => '0',
                'max'  => '500',
                'step' => '1',
            )
        ];
        /* Design Settings */
        //Slider Pin
        $fields['circle_size'] = [
            'label' => esc_html__('Circle Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'slider_pin',
            'default_unit' => 'px',
            'allowed_units' => array('px'),
            'range_settings' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'sticky' => true,
        ];
        $fields['circle_border_color'] = [
            'label' => esc_html__('Circle Border Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'slider_pin',
            'sticky' => true,

        ];
        $fields['circle_bg_color'] = [
            'label' => esc_html__('Circle Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'toggle_slug' => 'slider_pin',
            'tab_slug' => 'advanced',
        ];

        $fields['circle_border_width'] = [
            'label' => esc_html__('Circle Border Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'slider_pin',
            'default_unit' => 'px',
            'allowed_units' => array('em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
            'range_settings' => array(
                'min' => '0',
                'max' => '50',
                'step' => '1',
            ),
            'sticky' => true,

        ];
        $fields['circle_border_style'] = [
            'label' => esc_html__('Circle Border Style', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'layout',
            'options' => et_builder_get_border_styles(),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'slider_pin',
        ];

        //Label
        $fields['label_bg_color'] = [
            'label' => esc_html__('Label Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'toggle_slug' => 'label',
            'sub_toggle'  => 'normal',
            'tab_slug' => 'advanced',

        ];
        $fields['label_margin'] = [
            'label' => esc_html__('Label Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '|||',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'label',
            'sub_toggle'  => 'normal',
        ];
        $fields['label_padding'] = [
            'label' => esc_html__('Label Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '|||',
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

        ];
        $fields['active_label_margin'] = [
            'label' => esc_html__('Active Label Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '|||',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'label',
            'sub_toggle'  => 'active',
        ];
        $fields['active_label_padding'] = [
            'label' => esc_html__('Active Label Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '|||',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'label',
            'sub_toggle'  => 'active',
        ];
        //desc
        $fields['desc_bg_color'] = [
            'label' => esc_html__('Description Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'toggle_slug' => 'desc',
            'sub_toggle'  => 'normal',
            'tab_slug' => 'advanced',

        ];
        $fields['desc_margin'] = [
            'label' => esc_html__('Description Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '|||',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'desc',
            'sub_toggle'  => 'normal',
        ];
        $fields['desc_padding'] = [
            'label' => esc_html__('Description Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '|||',
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

        ];
        $fields['active_desc_margin'] = [
            'label' => esc_html__('Active Description Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '|||',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'desc',
            'sub_toggle'  => 'active',
        ];
        $fields['active_desc_padding'] = [
            'label' => esc_html__('Active Description Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '|||',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'desc',
            'sub_toggle'  => 'active',
        ];
        return $fields;
    }


    public function dipi_apply_css($render_slug)
    {
        $order_class = self::get_module_order_class($render_slug);
        $order_number = preg_replace('/[^0-9]/', '', $order_class);
        $label_selector = '%%order_class%%.dipi_content_slider_child  .content-slider-label';
        $active_label_selector = '%%order_class%%.dipi_content_slider_child  .content-slider-item.active .content-slider-label';
        $desc_selector = '%%order_class%%.dipi_content_slider_child  .content-slider-desc';
        $active_desc_selector = '%%order_class%%.dipi_content_slider_child  .content-slider-item.active .content-slider-desc';
        $slider_pin_selector = ".dipi-content-slider[data-active-order-num='$order_number'] .dipi-progress-line .dipi-slider-pin";
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

        // Label
        $this->generate_styles(
            array(
                'base_attr_name' => 'label_bg_color',
                'selector' => $label_selector,
                'css_property' => 'background',
                'render_slug' => $render_slug,
                'type' => 'color',
            )
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
        $this->generate_styles(
            array(
                'base_attr_name' => 'active_label_bg_color',
                'selector' => $active_label_selector,
                'css_property' => 'background',
                'render_slug' => $render_slug,
                'type' => 'color',
            )
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
        // Description
        $this->generate_styles(
            array(
                'base_attr_name' => 'desc_bg_color',
                'selector' => $desc_selector,
                'css_property' => 'background',
                'render_slug' => $render_slug,
                'type' => 'color',
            )
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
        $this->generate_styles(
            array(
                'base_attr_name' => 'active_desc_bg_color',
                'selector' => $active_desc_selector,
                'css_property' => 'background',
                'render_slug' => $render_slug,
                'type' => 'color',
            )
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

    public function render($attrs, $content, $render_slug)
    {
        global $dipi_cs_selectors, $dipi_active_id, $dipi_active_order_num;
        
        $this->dipi_apply_css($render_slug);
        $label = $this->props['label'];
        $desc_text = $this->props['desc_text'];
        $selector = $this->props['selector'];
        $active_item = $this->props['active_item'];
        $activate_tab_selector = $this->props['activate_tab_selector'];
        $scroll_tab_offset = $this->props['scroll_tab_offset'];
        $order_class = self::get_module_order_class($render_slug);
        $order_number = preg_replace('/[^0-9]/', '', $order_class);
        $show_description = $this->props['show_description'];
        $module_classes = [];
        $module_id = count($dipi_cs_selectors);
        if ($dipi_active_id < 0 && $active_item === 'on') {
            $dipi_active_id = $module_id;
            $dipi_active_order_num = $order_number;
            $module_classes[] = "active";
        }
        $dipi_cs_selectors[] = str_replace(";", "", $selector);
        $description_html = "";
        if ($show_description === 'on') {
            $description_html = sprintf('<div class="content-slider-desc">%1$s</div>',
                $this->process_content($desc_text)
            );
        }
        $output = sprintf(
            '<div class="content-slider-item %2$s" data-id="%3$s" data-order-num="%4$s" data-activate-selector="%6$s" data-tab-scroll-off="%7$s">
                <div class="content-slider-gradations-wrapper">
                    <span class="content-slider-gradations"></span>
                </div>
                <span class="content-slider-label">%1$s</span>
                %5$s
            </div>',
            $label,
            implode(" ", $module_classes),
            $module_id,
            $order_number,
            $description_html, #5
            $activate_tab_selector,
            $scroll_tab_offset
        );
        return $output;
    }
}

new DIPI_ContentSliderChild;
