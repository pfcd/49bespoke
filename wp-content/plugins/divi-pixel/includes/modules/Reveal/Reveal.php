<?php

//TODO:
//-Option to fade in reveal when scrolling (like original reveal)
//-Setting to exclude taxonomies from counting posts
//TODO: Y/N switch to activate continous counting (so counting seconds makes sense)



//TODO: count_number_decimal_separator location based on user or localeconv()['decimal_point']
//TODO: count_to_post_exclude_terms implementieren

class DIPI_Reveal extends DIPI_Builder_Module
{
    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/reveal',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->slug = 'dipi_reveal';
        $this->vb_support = 'on';
        $this->name = esc_html__('Pixel Reveal', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%';
    }

    public function get_settings_modal_toggles()
    {
        return [
            'general' => [
                'toggles' => [
                    'settings' => esc_html__('Settings', 'dipi-divi-pixel'),
                    'show_less_more' => [
                        'sub_toggles' => array(
                            'less'        => array(
                                'name' => esc_html__('Less', 'dipi-divi-pixel'),
                            ),
                            'more'        => array(
                                'name' => esc_html__('More', 'dipi-divi-pixel'),
                            ),
                        ),
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__('Show Less/More', 'dipi-divi-pixel'),
                    ],
                    'overlay' => esc_html__('Overlay on Collapsed', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'less_button' => esc_html__('Show Less Button', 'dipi-divi-pixel'),
                    'more_button' => esc_html__('Show More Button', 'dipi-divi-pixel'),
                    'overlay' => esc_html__('Overlay on Collapsed', 'dipi-divi-pixel'),
                ]
            ]
        ];
    }

    public function get_custom_css_fields_config()
    {
        $fields = [];

        return $fields;
    }

    public function get_fields()
    {
        $et_builder_accent_color = et_builder_accent_color();

        $fields = [];

        $fields['container_selector'] = [
            'label' => esc_html__('Container Selector', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'configuration',
            'toggle_slug' => 'settings',
            'description' => esc_html__('CSS Selector of container to show/hide'),
        ];
        $fields['default_show_status'] = [
            'label'                 => esc_html__('Default Show Status', 'dipi-divi-pixel'),
            'type'                  => 'select',
            'default'               => 'collapsed',
            'options'               => array(
                'collapsed'      => esc_html__('Collapsed', 'dipi-divi-pixel'),
                'expanded'             => esc_html__('Expanded', 'dipi-divi-pixel')
            ),
            'toggle_slug' => 'settings',
        ];
        $fields['reveal_button_align'] = [
            'label' => esc_html__('Button Alignment', 'dipi-divi-pixel'),
            'type' => 'text_align',
            'options' => et_builder_get_text_orientation_options(['justified']),
            'options_icon' => 'module_align',
            'toggle_slug' => 'settings',
            'default' => 'center',
            'mobile_options' => true,
        ];
        $fields["less_button_text"] = [
            'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'dynamic_content' => 'text',
            'toggle_slug' => 'show_less_more',
            'sub_toggle' => 'less',
            'default' => 'Show Less',
        ];
        $fields['less_container_height'] = [
            'label' => esc_html__('Collapsed Container Height', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'toggle_slug' => 'show_less_more',
            'sub_toggle' => 'less',
            'type' => 'range',
            'range_settings' => array(
                'min' => '0',
                'max' => '1000',
                'step' => '1',
            ),
            'default_unit' => 'px',
            'default' => '100px',
            'mobile_options'      => true,
             /*'show_if' => [
                'show_gradations' => 'on'
            ]*/
        ];
        $fields['less_v_offset'] = [
            'label' => esc_html__('Vertical Offset', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'toggle_slug' => 'show_less_more',
            'sub_toggle' => 'less',
            'type' => 'range',
            'range_settings' => array(
                'min' => '-500',
                'max' => '500',
                'step' => '1',
            ),
            'default_unit' => 'px',
            'default' => '0px',
            'allowed_units' => ['px'],
            'validate_unit' => true,
            'mobile_options'      => true,
             /*'show_if' => [
                'show_gradations' => 'on'
            ]*/
        ];
        $fields['less_animation_time'] = [
			'label'           => esc_html__( 'Animation Time to Show Less', 'dipi-divi-pixel' ),
			'type'            => 'range',
            'toggle_slug' => 'show_less_more',
            'sub_toggle' => 'less',
			'range_settings'  => [
				'min'  => 100,
				'max'  => 10000,
				'step' => 100,
			],
			'default'             => '800ms',
			'description'         => esc_html__( 'If you would like to add a duration of your animation while showing less, you can define the amount here in milliseconds. ' ),
			'validate_unit'       => true,
			'fixed_unit'          => 'ms',
			'fixed_range'         => true,
			'reset_animation'     => true,
			'mobile_options'      => true,
		];

        $fields["more_button_text"] = [
            'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'dynamic_content' => 'text',
            'toggle_slug' => 'show_less_more',
            'sub_toggle' => 'more',
            'default' => 'Show More'
        ];
        $fields['more_v_offset'] = [
            'label' => esc_html__('Vertical Offset', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'toggle_slug' => 'show_less_more',
            'sub_toggle' => 'more',
            'type' => 'range',
            'range_settings' => array(
                'min' => '-500',
                'max' => '500',
                'step' => '1',
            ),
            'default_unit' => 'px',
            'default' => '-100px',
            'allowed_units' => ['px'],
            'validate_unit' => true,
            'mobile_options'      => true,
             /*'show_if' => [
                'show_gradations' => 'on'
            ]*/
        ];
        $fields['more_animation_time'] = [
			'label'           => esc_html__( 'Animation Time to Show More', 'dipi-divi-pixel' ),
			'type'            => 'range',
            'toggle_slug' => 'show_less_more',
            'sub_toggle' => 'more',
			'range_settings'  => [
				'min'  => 100,
				'max'  => 10000,
				'step' => 100,
			],
			'default'             => '800ms',
			'description'         => esc_html__( 'If you would like to add a duration of your animation while showing more, you can define the amount here in milliseconds. ' ),
			'validate_unit'       => true,
			'fixed_unit'          => 'ms',
			'fixed_range'         => true,
			'reset_animation'     => true,
			'mobile_options'      => true,
		];
        $fields["use_overlay"] = [
            'label' => esc_html__('Use Overlay', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'description' => esc_html__('show overlay when container is showing less'),
            'toggle_slug' => 'overlay',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'mobile_options' => true,
        ];
        $fields["overlay_as"] = [
            'label' => esc_html__('Overlay As', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'css',
            'description' => esc_html__('Use \'HTML\' when \'Container Selector\' is using :after css', 'dipi-divi-pixel'),
            'options' => [
                'html' => esc_html__('HTML', 'dipi-divi-pixel'),
                'css' => esc_html__('CSS', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'overlay',
        ];
        $fields["append_to"] = [
            'label' => esc_html__('Append To', 'dipi-divi-pixel'),
            'description' => esc_html__('The element to append the overlay to. Overlay HTML will be add dynamically into this element.', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'element',
            'options' => [
                'parent' => esc_html__('Parent of Selector', 'dipi-divi-pixel'),
                'element' => esc_html__('Selector', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'overlay',
            'show_if' => [
                'overlay_as' => 'html'
            ]
        ];
        $fields['overlay_z_index'] = [
			'label'         => esc_html__('Z-index of Overlay', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '0',
            'unitless' => true,
            'range_settings' => [
                'min' => '0',
                'max' => '10000',
                'step' => '1',
            ],
            'mobile_options' => true,
            'toggle_slug' => 'overlay',
		];
        $fields["overlay_bg_color"] = [
            'label' => esc_html__('Overlay Color', 'dipi-divi-pixel'),
            'type' => 'background-field',
            'base_name' => "overlay_bg",
            'context' => "overlay_bg",
            'custom_color' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'overlay',
            'hover' => 'tabs',
            'mobile_options' => true,
            'responsive' => true,
            'background_fields' => array_merge(
                ET_Builder_Element::generate_background_options(
                    'overlay_bg',
                    'gradient',
                    "advanced",
                    "overlay",
                    "overlay_bg_gradient"
                ),

                ET_Builder_Element::generate_background_options(
                    "overlay_bg",
                    "color",
                    "advanced",
                    "overlay",
                    "overlay_bg_color"
                )
            ),
            'show_if' => [
                'use_overlay' => 'on',
            ],
        ];
        $fields = array_merge(
            $fields,
            $this->generate_background_options(
                "overlay_bg",
                'skip',
                "advanced",
                "image",
                "overlay_bg_gradient"
            )
        );
        $fields = array_merge(
            $fields,
            $this->generate_background_options(
                "overlay_bg",
                'skip',
                "advanced",
                "image",
                "overlay_bg_color"
            )
        );
        return $fields;
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = [];

        $advanced_fields["text"] = false;
        $advanced_fields['fonts'] = false;
        $advanced_fields["text_shadow"] = false;
        $advanced_fields["box_shadow"] = false;
        $advanced_fields["borders"] = false;

        $advanced_fields['button']["show_less_button"] = [
            'label'    => esc_html__('Show Less Button', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-less-button",
                'limited_main' => "%%order_class%% .dipi-less-button",
                'important' => true,
            ],
            'box_shadow'  => [
                'css' => [
                    'main' => "%%order_class%% .dipi-less-button",
                    'important' => true,
                ],
            ],
            'use_alignment' => false,
            'margin_padding' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-less-button",
                    'important' => 'all',
                ],
            ]

        ];
        $advanced_fields['button']["show_more_button"] = [
            'label'    => esc_html__('Show More Button', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-more-button",
                'limited_main' => "%%order_class%% .dipi-more-button",
                'important' => true,
            ],
            'box_shadow'  => [
                'css' => [
                    'main' => "%%order_class%% .dipi-more-button",
                    'important' => true,
                ],
            ],
            'use_alignment' => false,
            'margin_padding' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-more-button",
                    'important' => 'all',
                ],
            ]

        ];
        return $advanced_fields;
    }
    public function dipi_apply_css($render_slug) {
        $order_class = self::get_module_order_class($render_slug);
        $order_number = preg_replace('/[^0-9]/', '', $order_class);
        $container_selector = $this->props['container_selector'];
        $container_overlay_selector = "$container_selector.dipi-reveal-oa-html ~ .dipi-reveal-overlay, $container_selector.dipi-reveal-oa-html .dipi-reveal-overlay, $container_selector.dipi-reveal-oa-css:after";
        $container_overlay_hover_selector = "$container_selector.dipi-reveal-oa-html ~ .dipi-reveal-overlay:hover, $container_selector.dipi-reveal-oa-html .dipi-reveal-overlay:hover, $container_selector.dipi-reveal-oa-css:hover:after";

        $use_overlay = $this->props["use_overlay"];
        $use_overlay_responsive_active = isset($this->props["use_overlay_last_edited"]) && et_pb_get_responsive_status($this->props["use_overlay_last_edited"]);
        $use_overlay_tablet = $use_overlay_responsive_active && $this->props["use_overlay_tablet"] ? $this->props["use_overlay_tablet"] : $use_overlay;
        $use_overlay_phone = $use_overlay_responsive_active && $this->props["use_overlay_phone"] ? $this->props["use_overlay_phone"] : $use_overlay_tablet;
       
        $collapsed_container_selector = ".dipi-reveal-container-collapsed";
        $expanded_container_selector = ".dipi-reveal-container-expanded";
        $dipi_reveal_container_selector = ".dipi-reveal-container-$order_number";
        $collapsed_module_selector = "%%order_class%% .dipi-reveal.collapsed";
        $expanded_module_selector = "%%order_class%% .dipi-reveal.expanded";
        $show_more_btn_selector = "%%order_class%% .dipi-more-button";
        $show_less_btn_selector = "%%order_class%% .dipi-less-button";

        $this->dipi_apply_custom_style(
            $render_slug,
            'reveal_button_align',
            'text-align',
            "%%order_class%% .dipi-reveal"
        );


        $this->dipi_apply_custom_style(
            $render_slug,
            'more_v_offset',
            'margin-top',
            $collapsed_module_selector,
            false,
            false,
            ''
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'more_v_offset',
            'margin-bottom',
            $collapsed_module_selector,
            false,
            -1,
            'px'
        );
        /*$this->dipi_apply_custom_style(
            $render_slug,
            'less_v_offset',
            'margin-bottom',
            $expanded_module_selector,
            false,
            0,
            'px',
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'less_v_offset',
            'margin-bottom',
            $expanded_module_selector,
            false,
            0,
            'px',
        );*/
        $this->dipi_apply_custom_style(
            $render_slug,
            'less_animation_time',
            'transition-duration',
            $dipi_reveal_container_selector.$collapsed_container_selector
        );
        $this->dipi_apply_custom_style(
            $render_slug,
            'more_animation_time',
            'transition-duration',
            $dipi_reveal_container_selector.$expanded_container_selector
        );
            
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $container_overlay_selector,
            'declaration' => sprintf('content:'. ($use_overlay === "on" ? '"";' : 'none;')),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $container_overlay_selector,
            'declaration' => sprintf('content:'. ($use_overlay_tablet === "on" ? '"";' : 'none;')),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $container_overlay_selector,
            'declaration' => sprintf('content:'. ($use_overlay_phone === "on" ? '"";' : 'none;')),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));
        $this->dipi_apply_custom_style(
            $render_slug,
            'overlay_z_index',
            'z-index',
            $container_overlay_selector
        );
        
        $this->set_background_css(
            $render_slug,
            $container_overlay_selector,
            $container_overlay_hover_selector,
            'overlay_bg',
            'overlay_bg_color'
        );
    }
    public function render($attrs, $content , $render_slug)
    {        
        
        wp_enqueue_script('dipi_reveal_public');
        $this->dipi_apply_css($render_slug);
        $default_show_status = $this->props['default_show_status'];
        $container_selector = $this->props['container_selector'];
        $use_overlay = $this->props["use_overlay"];
        $overlay_as = $this->props['overlay_as'];
        $append_to = $this->props['append_to'];
        $order_class = self::get_module_order_class($render_slug);
        $order_number = preg_replace('/[^0-9]/', '', $order_class);

        $less_container_height = $this->props["less_container_height"];
        $less_container_height_responsive_active = isset($this->props["less_container_height_last_edited"]) && et_pb_get_responsive_status($this->props["less_container_height_last_edited"]);
        $less_container_height_tablet = $less_container_height_responsive_active && $this->props["less_container_height_tablet"] ? $this->props["less_container_height_tablet"] : $less_container_height;
        $less_container_height_phone = $less_container_height_responsive_active && $this->props["less_container_height_phone"] ? $this->props["less_container_height_phone"] : $less_container_height_tablet;
        $show_less_button_custom = $this->props['custom_show_less_button'];
        $show_less_button_text   = $this->props['less_button_text'];
        $show_less_button_custom_icon_values = et_pb_responsive_options()->get_property_values( $this->props, 'show_less_button_icon' );
        $show_less_button_custom_icon        = isset( $show_less_button_custom_icon_values['desktop'] ) ? $show_less_button_custom_icon_values['desktop'] : '';
        $show_less_button_custom_icon_tablet = isset( $show_less_button_custom_icon_values['tablet'] ) ? $show_less_button_custom_icon_values['tablet'] : $show_less_button_custom_icon;
        $show_less_button_custom_icon_phone  = isset( $show_less_button_custom_icon_values['phone'] ) ? $show_less_button_custom_icon_values['phone'] : $show_less_button_custom_icon_tablet;
        $multi_view     = et_pb_multi_view_options( $this );
        $show_less_button_output = $this->render_button([
            'button_classname' => ["dipi-less-button", "dipi-reveal-button"],
            'button_custom' => $show_less_button_custom,
            'button_text' => $show_less_button_text,
            'custom_icon'         => $show_less_button_custom_icon,
            'custom_icon_tablet'  => $show_less_button_custom_icon_tablet,
            'custom_icon_phone'   => $show_less_button_custom_icon_phone,
            'has_wrapper' => false,
        ]);
        $show_less_button_output = preg_replace('/<a([^>]*\s+)?href=["\'][^"\']*["\']([^>]*)>/', '<a$1$2>', $show_less_button_output);

        $show_more_button_custom = $this->props['custom_show_more_button'];
        $show_more_button_text   = $this->props['more_button_text'];

        $show_more_button_custom_icon_values = et_pb_responsive_options()->get_property_values( $this->props, 'show_more_button_icon' );
        $show_more_button_custom_icon        = isset( $show_more_button_custom_icon_values['desktop'] ) ? $show_more_button_custom_icon_values['desktop'] : '';
        $show_more_button_custom_icon_tablet = isset( $show_more_button_custom_icon_values['tablet'] ) ? $show_more_button_custom_icon_values['tablet'] : $show_more_button_custom_icon;
        $show_more_button_custom_icon_phone  = isset( $show_more_button_custom_icon_values['phone'] ) ? $show_more_button_custom_icon_values['phone'] : $show_more_button_custom_icon_tablet;
        $multi_view     = et_pb_multi_view_options( $this );
        $show_more_button_output = $this->render_button([
            'button_classname' => ["dipi-more-button", "dipi-reveal-button"],
            'button_custom' => $show_more_button_custom,
            'button_text' => $show_more_button_text,
            'custom_icon'         => $show_more_button_custom_icon,
            'custom_icon_tablet'  => $show_more_button_custom_icon_tablet,
            'custom_icon_phone'   => $show_more_button_custom_icon_phone,
            'has_wrapper' => false,
        ]);

        $show_more_button_output = preg_replace('/<a([^>]*\s+)?href=["\'][^"\']*["\']([^>]*)>/', '<a$1$2>', $show_more_button_output);

        $button_output = $default_show_status === "collapsed" ? $show_more_button_output : $show_less_button_output;
        
        $config = [
            'container_selector' => $container_selector,
            'default_show_status' => $default_show_status,
            'order_number' => $order_number,
            'use_overlay' => $use_overlay,
            'show_less_button_text' => $show_less_button_text,
            'show_more_button_text' => $show_more_button_text,
            'less_container_height' => $less_container_height,
            'less_container_height_tablet' => $less_container_height_tablet,
            'less_container_height_phone' => $less_container_height_phone,
            'overlay_as' => $overlay_as,
            'append_to' => $append_to,

        ];

        return sprintf(
            '<div
                class="dipi-reveal"
                data-config="%1$s"
                data-less-icon="%3$s"
                data-less-icon-tablet="%4$s"
                data-less-icon-phone="%5$s"
                data-more-icon="%6$s"
                data-more-icon-tablet="%7$s"
                data-more-icon-phone="%8$s"
            >
                %2$s
            </div>',
            esc_attr(htmlspecialchars(json_encode($config), ENT_QUOTES, 'UTF-8')) ,
            $button_output,
            $show_less_button_custom === "on" ? et_pb_process_font_icon($show_less_button_custom_icon) : "5",
            $show_less_button_custom === "on" ? et_pb_process_font_icon($show_less_button_custom_icon_tablet) : "5",
            $show_less_button_custom === "on" ? et_pb_process_font_icon($show_less_button_custom_icon_phone) : "5",
            $show_more_button_custom === "on" ? et_pb_process_font_icon($show_more_button_custom_icon) : "5",
            $show_more_button_custom === "on" ? et_pb_process_font_icon($show_more_button_custom_icon_tablet) : "5",
            $show_more_button_custom === "on" ? et_pb_process_font_icon($show_more_button_custom_icon_phone) : "5"
        );
        return '';
    }

}

new DIPI_Reveal();
