<?php

class DIPI_ImageGallery extends DIPI_Builder_Module {
    public $slug = 'dipi_image_gallery';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/image-slider',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init() {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__('Pixel Image Slider', 'dipi-divi-pixel');
        $this->child_slug = 'dipi_image_gallery_child';
        $this->main_css_element = '%%order_class%%.dipi_image_gallery';

        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'thumbs_carousel' => esc_html__('Thumbs Carousel', 'dipi-divi-pixel'),
                    'main_carousel' => esc_html__('Main Carousel', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'thumbs_style_toggle' => [
                        'title' => esc_html__('Thumbs Style', 'dipi-divi-pixel'),
                        'priority' => 95,
                    ],
                     
                    'thumbs_navigation' => esc_html__('Thumbs Navigation', 'dipi-divi-pixel'),
                    'main_navigation' => esc_html__('Main Image Navigation', 'dipi-divi-pixel'),
                ]
            ]
        ];
    }
    
    public function get_custom_css_fields_config() {
        $fields = [];
        $fields['next_main_navigation'] = [
            'label'    => esc_html__('Next Main Navigation', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .swiper-button-next.dipi-ig-top-nav',
        ];
        $fields['prev_main_navigation'] = [
            'label'    => esc_html__('Prev Main Navigation', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .swiper-button-prev.dipi-ig-top-nav',
        ];
        $fields['next_thumbs_navigation'] = [
            'label'    => esc_html__('Next Thumbs Navigation', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .swiper-button-next.dipi-ig-thumbs-nav',
        ];
        $fields['prev_thumbs_navigation'] = [
            'label'    => esc_html__('Prev Thumbs Navigation', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .swiper-button-prev.dipi-ig-thumbs-nav',
        ];
        $fields['thumbs_slide'] = [
            'label'    => esc_html__('Thumbnails', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-image-gallery-thumbs .swiper-slide .swiper-slide-container',
        ];
        $fields['active_thumb_slide'] = [
            'label'    => esc_html__('Active Thumbnail', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-image-gallery-thumbs .swiper-slide.swiper-slide-active .swiper-slide-container',
        ];

        return $fields;
    }

    public function get_fields() 
    {
        $fields = [];
        
        $fields['thumbs_alignment'] = [
            'label'         => esc_html__('Thumbs Alignment', 'dipi-divi-pixel'),
            'description'   => esc_html__('Choose thumbnails alignment', 'dipi-divi-pixel'),
            'type'          => 'select',
            'tab_slug'      => 'general',
            'toggle_slug' => 'thumbs_carousel',
            'default'       => 'horizontal',
            'options' => [
                'horizontal'   => esc_html__('Horizontal', 'dipi-divi-pixel'),
                'vertical'     => esc_html__('Vertical', 'dipi-divi-pixel'),
            ],
        ];
        
        $fields['thumbs_position_horizontal'] = [
            'label'         => esc_html__('Thumbs Position', 'dipi-divi-pixel'),
            'description'   => esc_html__('', 'dipi-divi-pixel'),
            'type'          => 'select',
            'tab_slug'      => 'general',
            'toggle_slug' => 'thumbs_carousel',
            'default'       => 'bottom',
            'options' => [
                'top'       => esc_html__('Top', 'dipi-divi-pixel'),
                'bottom'    => esc_html__('Bottom', 'dipi-divi-pixel'),
            ],
            'show_if'   => [
                'thumbs_alignment' => 'horizontal',
                'use_float_thumbs' => 'off'
            ],
        ];
        
        $fields['thumbs_position_vertical'] = [
            'label'         => esc_html__('Thumbs Position', 'dipi-divi-pixel'),
            'description'   => esc_html__('', 'dipi-divi-pixel'),
            'type'          => 'select',
            'tab_slug'      => 'general',
            'toggle_slug' => 'thumbs_carousel',
            'default'       => 'left',
            'options' => [
                'left'       => esc_html__('Left', 'dipi-divi-pixel'),
                'right'    => esc_html__('Right', 'dipi-divi-pixel'),
            ],
            'show_if'   => [
                'thumbs_alignment' => 'vertical',
                'use_float_thumbs' => 'off'
            ]
        ];
       
        $fields["thumbs_count"] = [
            'label' => esc_html__( 'Thumbs Count', 'dipi-divi-pixel' ),
            'type' => 'range',
            'unitless' => true,
            'default' => '4',
            'mobile_options' => true,
            'responsive' => true,
             'range_settings' => [
                'min'  => '1',
                'max'  => '10',
                'step' => '1',
            ],
           'tab_slug' => 'general',
           'toggle_slug' => 'thumbs_carousel'
        ];

        $fields["thumbs_space_between"] = [
            'label' => esc_html__( 'Space Between Thumbs', 'dipi-divi-pixel' ),
            'type' => 'range',
            'unitless' => true,
            'default' => '10',
            'mobile_options' => true,
            'responsive' => true,
            'range_settings' => [
                'min'  => '1',
                'max'  => '100',
                'step' => '1',
            ],
           'tab_slug' => 'general',
           'toggle_slug' => 'thumbs_carousel'
        ];

        $fields["thumb_width"] = [
            'label' => esc_html__( 'Thumbs Width', 'dipi-divi-pixel' ),
            'type' => 'range',
            'default' => '100px',
            'default_unit' => 'px',
            'default_on_front'=> '100px',
            'allowed_units' => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
            'show_if'   => ['thumbs_alignment' => 'vertical'],
            'range_settings' => [
                'min'  => '1',
                'max'  => '500',
                'step' => '1',
            ],
            'mobile_options' => true,
            'responsive' => true,
            'validate_unit' => true,
            'tab_slug' => 'general',
            'toggle_slug' => 'thumbs_carousel'
        ];
        

        $fields["thumb_height"] = [
            'label' => esc_html__( 'Thumbs Height', 'dipi-divi-pixel' ),
            'type' => 'range',
            'default' => '100px',
            'default_unit' => 'px',
            'default_on_front'=> '100px',
            'allowed_units' => [ 'px'],
            'show_if'   => ['thumbs_alignment' => 'horizontal'],
            'mobile_options' => true,
            'responsive' => true,
            'range_settings' => [
                'min'  => '1',
                'max'  => '500',
                'step' => '1',
            ],
            'validate_unit' => true,
            'tab_slug' => 'general',
            'toggle_slug' => 'thumbs_carousel'
        ];

        $fields["thumb_horizontal_width"] = [
            'label' => esc_html__( 'Thumbs Width', 'dipi-divi-pixel' ),
            'type' => 'range',
            'default' => '100%',
            'default_unit' => '%',
            'default_on_front'=> '100%',
            'allowed_units' => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
            'show_if'   => ['thumbs_alignment' => 'horizontal'],
            'mobile_options' => true,
            'responsive' => true,
            'range_settings' => [
                'min'  => '1',
                'max'  => '100',
                'step' => '1',
            ],
            'validate_unit' => true,
            'tab_slug' => 'general',
            'toggle_slug' => 'thumbs_carousel'
        ];
        $fields["thumb_horizontal_placement"] = [
            'label'            => esc_html__('Thumbs Horizontal Placement', 'dipi-divi-pixel'),
            'type'             => 'select',
            'default'          => 'center',
            'show_if'   => ['thumbs_alignment' => 'horizontal'],
            'options' => [
                'flex-end'  => esc_html__('Right', 'dipi-divi-pixel'),
                'flex-start'   => esc_html__('Left', 'dipi-divi-pixel'),
                'center'   => esc_html__('Center', 'dipi-divi-pixel'),
            ],
            'tab_slug' => 'general',
            'toggle_slug' => 'thumbs_carousel',
            'mobile_options'   => true
        ];
 
        $fields["thumb_vertical_height"] = [
            'label' => esc_html__( 'Thumbs Height', 'dipi-divi-pixel' ),
            'type' => 'range',
            'default' => '100%',
            'default_unit' => '%',
            'default_on_front'=> '100%',
            'allowed_units' => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
            'show_if'   => ['thumbs_alignment' => 'vertical'],
            'mobile_options' => true,
            'responsive' => true,
            'range_settings' => [
                'min'  => '1',
                'max'  => '100',
                'step' => '1',
            ],
            'validate_unit' => true,
            'tab_slug' => 'general',
            'toggle_slug' => 'thumbs_carousel'
        ];

        $fields["thumb_vertical_placement"] = [
            'label'            => esc_html__('Thumbs Vertical Placement', 'dipi-divi-pixel'),
            'type'             => 'select',
            'default'          => 'center',
            'options' => [
                'flex-start'  => esc_html__('Top', 'dipi-divi-pixel'),
                'flex-end'   => esc_html__('Bottom', 'dipi-divi-pixel'),
                'center'   => esc_html__('Center', 'dipi-divi-pixel'),
            ],
            'show_if'   => ['thumbs_alignment' => 'vertical'],
            'tab_slug' => 'general',
            'toggle_slug' => 'thumbs_carousel',
            'mobile_options'   => true
        ];

        $fields['use_float_thumbs'] = [
            'label' =>  esc_html__( 'Float Thumbs Over Main Image', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'tab_slug' => 'general',
            'toggle_slug' => 'thumbs_carousel',
            'default' => 'off'
        ];

        // create tabs_slider composition field
        $fields['float_thumbs_res'] = [
            'label'          => esc_html__( 'Select Device', 'dipi-divi-pixel' ),
            'type'           => 'composite',
            'tab_slug'       => 'general',
            'toggle_slug'    => 'thumbs_carousel',
            'composite_type' => 'default',
            'show_if'        => ['use_float_thumbs'=>'on'],
            'composite_structure' => array(
                'desktop' => array(
                    'icon'     => 'desktop',
                    'controls' =>  [
                        'float_wide' => [
                            'label' =>  esc_html__( 'Enable on desktop', 'dipi-divi-pixel'),
                            'type' =>  'yes_no_button',
                            'mobile_options' => false,
                            'default' => 'off',
                            'options' => [
                                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
                            ]
                            ],
                        "float_hz_placement_wide" => [
                            'label'            => esc_html__('Float Thumbs Horizontal Placement', 'dipi-divi-pixel'),
                            'type'             => 'select',
                            'default'          => 'center',
                            'mobile_options' => false,
                            'options' => [
                                'right'  => esc_html__('Right', 'dipi-divi-pixel'),
                                'left'   => esc_html__('Left', 'dipi-divi-pixel'),
                                'center'   => esc_html__('Center', 'dipi-divi-pixel'),
                            ]
                        ],
                        "float_vr_placement_wide" => [
                            'label'            => esc_html__('Float Thumbs Vertical Placement', 'dipi-divi-pixel'),
                            'type'             => 'select',
                            'default'          => 'bottom',
                            'mobile_options' => false,
                            'options' => [
                                'top'  => esc_html__('Top', 'dipi-divi-pixel'),
                                'bottom'   => esc_html__('Bottom', 'dipi-divi-pixel'),
                                'center'   => esc_html__('Center', 'dipi-divi-pixel'),
                            ]
                        ]
                    ]
                ),
                'tablet' => array(
                    'icon'     => 'tablet',
                    'controls' =>  [
                        'float_tab' => [
                            'label' =>  esc_html__( 'Enable on tablet', 'dipi-divi-pixel'),
                            'type' =>  'yes_no_button',
                            'default' => 'off',
                            'mobile_options' => false,
                            'options' => [
                                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
                            ]
                            ],
                        "float_hz_placement_tab" => [
                            'label'            => esc_html__('Float Thumbs Horizontal Placement', 'dipi-divi-pixel'),
                            'type'             => 'select',
                            'default'          => 'center',
                            'mobile_options' => false,
                            'options' => [
                                'right'  => esc_html__('Right', 'dipi-divi-pixel'),
                                'left'   => esc_html__('Left', 'dipi-divi-pixel'),
                                'center'   => esc_html__('Center', 'dipi-divi-pixel'),
                            ]
                        ],
                        "float_vr_placement_tab" => [
                            'label'            => esc_html__('Float Thumbs Vertical Placement', 'dipi-divi-pixel'),
                            'type'             => 'select',
                            'default'          => 'bottom',
                            'mobile_options' => false,
                            'options' => [
                                'top'  => esc_html__('Top', 'dipi-divi-pixel'),
                                'bottom'   => esc_html__('Bottom', 'dipi-divi-pixel'),
                                'center'   => esc_html__('Center', 'dipi-divi-pixel'),
                            ]
                        ]
                    ]
                ),
                'phone' => array(
                    'icon'     => 'phone',
                    'controls' =>  [
                        'float_pho' => [
                            'label' =>  esc_html__( 'Enable on phone', 'dipi-divi-pixel'),
                            'type' =>  'yes_no_button',
                            'mobile_options' => false,
                            'default' => 'off',
                            
                            'options' => [
                                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
                            ]
                            ],
                        "float_hz_placement_pho" => [
                            'label'            => esc_html__('Float Thumbs Horizontal Placement', 'dipi-divi-pixel'),
                            'type'             => 'select',
                            'default'          => 'center',
                            'mobile_options' => false,
                            'options' => [
                                'right'  => esc_html__('Right', 'dipi-divi-pixel'),
                                'left'   => esc_html__('Left', 'dipi-divi-pixel'),
                                'center'   => esc_html__('Center', 'dipi-divi-pixel'),
                            ]
                        ],
                        "float_vr_placement_pho" => [
                            'label'            => esc_html__('Float Thumbs Vertical Placement', 'dipi-divi-pixel'),
                            'type'             => 'select',
                            'default'          => 'bottom',
                            'mobile_options' => false,
                            'options' => [
                                'top'  => esc_html__('Top', 'dipi-divi-pixel'),
                                'bottom'   => esc_html__('Bottom', 'dipi-divi-pixel'),
                                'center'   => esc_html__('Center', 'dipi-divi-pixel'),
                            ]
                        ]
                    ]
                ),
            ),
        ];         
        
        $fields = array_merge($fields, $this->thumbs_navigations_fields());
        $fields = array_merge($fields, $this->main_navigations_fields());
        $fields['thumbs_centered'] = [
            'label' => esc_html__( 'Centered', 'dipi-divi-pixel' ),
            'type' => 'yes_no_button',
            'option_category'  => 'configuration',
            'options' => array(
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
            ),
            'default'          => 'on',
            'tab_slug' => 'general',
            'toggle_slug' => 'thumbs_carousel'
        ];
        $fields['thumbs_loop'] = [
            'label' => esc_html__( 'Loop', 'dipi-divi-pixel' ),
            'type' => 'yes_no_button',
            'option_category'  => 'configuration',
            'options' => array(
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
            ),
            'default'          => 'on',
            'tab_slug' => 'general',
            'toggle_slug' => 'thumbs_carousel'
        ];

        $fields['thumbs_container_padding'] = [
            'label' => esc_html__('Thumbs Container Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '10px|10px|10px|10px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'margin_padding',
        ];

        $fields['thumbs_container_margin'] = [
            'label' => esc_html__('Thumbs Container Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'margin_padding',
        ];


         // Main Carousel 
         $fields['enable_popup'] = [
            'label' =>  esc_html__( 'Open in Lightbox', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'tab_slug' => 'general',
            'toggle_slug' => 'main_carousel',
            'default' => 'off'
        ];

        // select field for popup animation
        $fields['popup_animation'] = [
            'label'            => esc_html__('Lightbox Animation', 'dipi-divi-pixel'),
            'type'             => 'select',
            'default'          => 'none',
            'options' => [
                'none'  => esc_html__('None', 'dipi-divi-pixel'),
                'fade'  => esc_html__('Fade', 'dipi-divi-pixel'),
                'zoom'   => esc_html__('Zoom', 'dipi-divi-pixel')
            ],
            'tab_slug' => 'general',
            'toggle_slug' => 'main_carousel',
            'mobile_options'   => true,
            'show_if'   => ['enable_popup'=>'on']
        ];

        // range field for popup animation duration
        $fields['popup_animation_duration'] = [
            'label' => esc_html__('Popup Animation Duration', 'dipi-divi-pixel' ),
            'type' => 'range',
            'range_settings'  => array(
                'min'  => '100',
                'max'  => '2000',
                'step' => '100'
            ),
            'default' => '500',
            'tab_slug' => 'general',
            'toggle_slug' => 'main_carousel',
            'mobile_options'   => true,
            'show_if'   => ['enable_popup' => 'on'],
            'show_if_not'   => ['popup_animation' => 'none']
        ];

         $fields['main_autoplay'] = [
            'label' =>  esc_html__( 'Enable Autoplay', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'tab_slug' => 'general',
            'toggle_slug' => 'main_carousel',
            'default' => 'off'
        ];
        $fields['autoplay_delay'] = [
            'label' => esc_html__('Autoplay Delay', 'dipi-divi-pixel' ),
            'type' => 'range',
            'range_settings'  => array(
                'min'  => '500',
                'max'  => '20000',
                'step' => '500'
            ),
            'mobile_options' => true,
            'default' => 5000,
            'validate_unit' => false,
            'tab_slug' => 'general',
            'toggle_slug' => 'main_carousel',
            'show_if'   => ['main_autoplay'=>'on']
        ];
        $fields['pause_on_hover'] = [
            'label' =>  esc_html__( 'Pause on Hover', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'tab_slug' => 'general',
            'toggle_slug' => 'main_carousel',
            'default' => 'off',
            'show_if'   => ['main_autoplay'=>'on']
        ];
         $fields['main_navigation'] = [
            'label' =>  esc_html__( 'Enable Navigation on Main Image', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'tab_slug' => 'general',
            'toggle_slug' => 'main_carousel',
            'default' => 'off'
        ];
        $fields['main_navigation_on_hover'] = [
            'label' =>  esc_html__( 'Show Navigation on Hover', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'toggle_slug' => 'carousel',
            'tab_slug' => 'general',
            'toggle_slug' => 'main_carousel',
            'show_if'   => ['main_navigation'=>'on'],
            'default' => 'off'
        ];
        $fields['main_slider_animation'] = [
            'label'         => esc_html__('Animation', 'dipi-divi-pixel'),
            'description'   => esc_html__('Choose Main Slider Animation', 'dipi-divi-pixel'),
            'type'          => 'select',
            'tab_slug'      => 'general',
            'toggle_slug' => 'main_carousel',
            'default'       => 'slide',
            'options' => [
                'slide'     => esc_html__('Slide', 'dipi-divi-pixel'),
                'fade'     => esc_html__('Fade', 'dipi-divi-pixel'),
                'flip'     => esc_html__('Flip', 'dipi-divi-pixel'),
                'cube'     => esc_html__('Cube', 'dipi-divi-pixel'),
            ]
        ];
        return $fields;
    }

    public function thumbs_navigations_fields(){
        $fields = [];

        $fields['thumbs_navigation'] = [
            'label' =>  esc_html__( 'Navigation', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'tab_slug' => 'general',
            'toggle_slug' => 'thumbs_carousel',
            'default' => 'off'
        ];
        $fields['thumbs_navigation_on_hover'] = [
            'label' =>  esc_html__( 'Show Navigation on Hover', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'toggle_slug' => 'carousel',
            'tab_slug' => 'general',
            'toggle_slug' => 'thumbs_carousel',
            'show_if'   => ['thumbs_navigation'=>'on'],
            'default' => 'off'
        ];
        $fields['thumbs_navigation_prev_icon_yn'] = [
            'label' =>  esc_html__('Prev Nav Custom Icon', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'default' => 'off',
            'tab_slug'  => 'advanced',
            'toggle_slug'   => 'thumbs_navigation'
        ];
        $fields['thumbs_navigation_prev_icon'] = [
            'label' => esc_html__( 'Select Previous Nav Icon', 'dipi-divi-pixel' ),
            'type'  => 'select_icon',
            'class' => array('et-pb-font-icon'),
            'default' => '8',
            'show_if' => ['thumbs_navigation_prev_icon_yn' => 'on'],
            'tab_slug'  => 'advanced',
            'toggle_slug' => 'thumbs_navigation'
        ];
        $fields['thumbs_navigation_next_icon_yn'] = [
            'label' =>  esc_html__('Next Nav Custom Icon', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'default'   => 'off',
            'tab_slug'  => 'advanced',
            'toggle_slug'   => 'thumbs_navigation'
        ];
        $fields['thumbs_navigation_next_icon'] = [
            'label' => esc_html__( 'Select Next Nav Icon', 'dipi-divi-pixel' ),
            'type' => 'select_icon',
            'class' => array('et-pb-font-icon'),
            'default' => '9',
            'show_if' =>['thumbs_navigation_next_icon_yn' => 'on'],
            'tab_slug'  => 'advanced',
            'toggle_slug'   => 'thumbs_navigation'
        ];
        $fields['thumbs_navigation_size'] = [
            'label' => esc_html__('Icon Size', 'dipi-divi-pixel' ),
            'type' => 'range',
            'range_settings'  => array(
                'min'  => '1',
                'max'  => '100',
                'step' => '1'
            ),
            'mobile_options' => true,
            'responsive' => true,
            'default' => 15,
            'validate_unit' => false,
            'tab_slug'  => 'advanced',
            'toggle_slug' => 'thumbs_navigation'
        ];
        $fields['thumbs_navigation_padding'] = [
            'label' => esc_html__( 'Icon Padding', 'dipi-divi-pixel' ),
            'type' => 'range',
            'range_settings'  => [
                'min'  => '1',
                'max'  => '100',
                'step' => '1'
            ],
            'mobile_options' => true,
            'responsive' => true,
            'default' => 15,
            'validate_unit' => false,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'thumbs_navigation'
        ];
        $fields['thumbs_navigation_color'] = [
                'label' => esc_html__( 'Arrow Color', 'dipi-divi-pixel' ),
                'type'  =>  'color-alpha',
                'default'   => et_builder_accent_color(),
                'tab_slug'  => 'advanced',
                'toggle_slug'   => 'thumbs_navigation',
                'hover' => 'tabs',
        ];

        $fields['thumbs_navigation_bg_color'] = [
            'label' => esc_html__( 'Arrow Background', 'dipi-divi-pixel' ),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'thumbs_navigation',
            'hover' => 'tabs',
        ];

        $fields['thumbs_navigation_circle'] = [
            'label' => esc_html__( 'Circle Arrow', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'default' => 'off',
            'tab_slug'  => 'advanced',
            'toggle_slug' => 'thumbs_navigation'
        ];

        $fields['thumbs_navigation_position_horizontal'] = [
            'label' => esc_html__('Horizontal Navigation Postion', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '25px',
            'default_on_front'=> '25px',
            'default_unit' => 'px',
            'allowed_units' => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
            'range_settings' => [
                'min'  => '-200',
                'max'  => '200',
                'step' => '1'
            ],
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'thumbs_navigation'
        ];

        $fields['thumbs_navigation_position_vertical'] = [
            'label' => esc_html__('Vertical Navigation Postion', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '50%',
            'default_on_front'=> '50%',
            'default_unit' => '%',
            'allowed_units' => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
            'range_settings' => [
                'min'  => '0',
                'max'  => '100',
                'step' => '1'
            ],
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'thumbs_navigation'
        ];

        return $fields;
    }

    public function main_navigations_fields(){
        $fields = [];
 
        $fields['main_navigation_prev_icon_yn'] = [
            'label' =>  esc_html__('Prev Nav Custom Icon', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'default' => 'off',
            'tab_slug'  => 'advanced',
            'toggle_slug'   => 'main_navigation'
        ];
        $fields['main_navigation_prev_icon'] = [
            'label' => esc_html__( 'Select Previous Nav Icon', 'dipi-divi-pixel' ),
            'type'  => 'select_icon',
            'class' => array('et-pb-font-icon'),
            'default' => '8',
            'show_if' => ['main_navigation_prev_icon_yn' => 'on'],
            'tab_slug'  => 'advanced',
            'toggle_slug' => 'main_navigation'
        ];
        $fields['main_navigation_next_icon_yn'] = [
            'label' =>  esc_html__('Next Nav Custom Icon', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'default'   => 'off',
            'tab_slug'  => 'advanced',
            'toggle_slug'   => 'main_navigation'
        ];
        $fields['main_navigation_next_icon'] = [
            'label' => esc_html__( 'Select Next Nav Icon', 'dipi-divi-pixel' ),
            'type' => 'select_icon',
            'class' => array('et-pb-font-icon'),
            'default' => '9',
            'show_if' =>['main_navigation_next_icon_yn' => 'on'],
            'tab_slug'  => 'advanced',
            'toggle_slug'   => 'main_navigation'
        ];
        $fields['main_navigation_size'] = [
            'label' => esc_html__('Icon Size', 'dipi-divi-pixel' ),
            'type' => 'range',
            'range_settings'  => array(
                'min'  => '1',
                'max'  => '100',
                'step' => '1'
            ),
            'mobile_options' => true,
            'responsive' => true,
            'default' => 15,
            'validate_unit' => false,
            'tab_slug'  => 'advanced',
            'toggle_slug' => 'main_navigation'
        ];
        $fields['main_navigation_padding'] = [
            'label' => esc_html__( 'Icon Padding', 'dipi-divi-pixel' ),
            'type' => 'range',
            'range_settings'  => [
                'min'  => '1',
                'max'  => '100',
                'step' => '1'
            ],
            'mobile_options' => true,
            'responsive' => true,
            'default' => 15,
            'validate_unit' => false,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'main_navigation'
        ];
        $fields['main_navigation_color'] = [
                'label' => esc_html__( 'Arrow Color', 'dipi-divi-pixel' ),
                'type'  =>  'color-alpha',
                'default'   => et_builder_accent_color(),
                'tab_slug'  => 'advanced',
                'toggle_slug'   => 'main_navigation',
                'hover' => 'tabs',
        ];
    
        $fields['main_navigation_bg_color'] = [
            'label' => esc_html__( 'Arrow Background', 'dipi-divi-pixel' ),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'main_navigation',
            'hover' => 'tabs',
        ];
    
        $fields['main_navigation_circle'] = [
            'label' => esc_html__( 'Circle Arrow', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'default' => 'off',
            'tab_slug'  => 'advanced',
            'toggle_slug' => 'main_navigation'
        ];
    
        $fields['main_navigation_position_horizontal'] = [
            'label' => esc_html__('Horizontal Navigation Postion', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '25px',
            'default_on_front'=> '25px',
            'default_unit' => 'px',
            'allowed_units' => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
            'range_settings' => [
                'min'  => '-200',
                'max'  => '200',
                'step' => '1'
            ],
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'main_navigation'
        ];
    
        $fields['main_navigation_position_vertical'] = [
            'label' => esc_html__('Vertical Navigation Postion', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '50%',
            'default_on_front'=> '50%',
            'default_unit' => '%',
            'allowed_units' => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
            'range_settings' => [
                'min'  => '-200',
                'max'  => '200',
                'step' => '1'
            ],
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'main_navigation'
        ];
    
        return $fields;
    }

    public function get_advanced_fields_config() 
    {
        $advanced_fields = [];
        $advanced_fields['fonts'] = false;
        $advanced_fields['text'] = false;
        $advanced_fields['borders']['default'] = [];
        $advanced_fields['borders']['thumbs_border_style'] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-image-gallery-thumbs .dipi_image_gallery_child .swiper-slide-container",
                    'border_styles' => "%%order_class%% .dipi-image-gallery-thumbs .dipi_image_gallery_child .swiper-slide-container",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'thumbs_style_toggle'
        ];

        $advanced_fields['box_shadow']['default'] = [];
        $advanced_fields['box_shadow']['thumbs_box_shadow_style'] = [
            'css' => [
                'main' => "%%order_class%% .dipi-image-gallery-thumbs .dipi_image_gallery_child .swiper-slide-container"
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'thumbs_style_toggle'
        ];

        return $advanced_fields;
    }

    public function apply_css($render_slug) {
        
        $thumbs_alignment = $this->props['thumbs_alignment'];
        $height = ($this->props['height'] === 'auto') ? '500px' : $this->props['height'];

        if(!isset($this->props['border_style_all_thumbs_border_style']) || empty($this->props['border_style_all_thumbs_border_style'])) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-image-gallery-thumbs .dipi_image_gallery_child .swiper-slide-container',
                'declaration' => "border-style: solid;"
            ]);
        }

        $responsive_height = $this->dipi_get_responsive_prop('height');
        $responsive_height['desktop'] = ($responsive_height['desktop'] === 'auto') ? '500px': $responsive_height['desktop'];
        $responsive_height['tablet'] = ($responsive_height['tablet'] === 'auto') ? '500px': $responsive_height['tablet'];
        $responsive_height['phone'] = ($responsive_height['phone'] === 'auto') ? '500px': $responsive_height['phone'];
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $this->main_css_element,
            'declaration' => sprintf('height: %1$s !important;', $responsive_height['desktop']),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $this->main_css_element,
            'declaration' => sprintf('height: %1$s !important;', $responsive_height['tablet']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $this->main_css_element,
            'declaration' => sprintf('height: %1$s !important;', $responsive_height['phone']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));
        

        $responsive_thumb_height = $this->dipi_get_responsive_prop('thumb_height');
        $responsive_thumb_width = $this->dipi_get_responsive_prop('thumb_width');

        $responsive_thumb_horizontal_width = $this->dipi_get_responsive_prop('thumb_horizontal_width');
        $responsive_thumb_horizontal_placement = $this->dipi_get_responsive_prop('thumb_horizontal_placement');

        $responsive_thumb_vertical_height = $this->dipi_get_responsive_prop('thumb_vertical_height');
        $responsive_thumb_vertical_placement = $this->dipi_get_responsive_prop('thumb_vertical_placement');
        

        if($thumbs_alignment == 'horizontal'){
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $this->main_css_element. ' .dipi-image-gallery-thumbs',
                'declaration' => sprintf( 'height: %1$s;width: %2$s;align-self:%3$s;', 
                            $responsive_thumb_height['desktop'],
                            $responsive_thumb_horizontal_width['desktop'],
                            $responsive_thumb_horizontal_placement['desktop']
                        )
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $this->main_css_element. ' .dipi-image-gallery-thumbs',
                'declaration' => sprintf( 'height: %1$s;width: %2$s;align-self:%3$s;', 
                            $responsive_thumb_height['tablet'],
                            $responsive_thumb_horizontal_width['tablet'],
                            $responsive_thumb_horizontal_placement['tablet']
                ),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $this->main_css_element. ' .dipi-image-gallery-thumbs',
                'declaration' => sprintf( 'height: %1$s;width: %2$s;align-self:%3$s;', 
                            $responsive_thumb_height['phone'],
                            $responsive_thumb_horizontal_width['phone'],
                            $responsive_thumb_horizontal_placement['phone']
                ),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }else{

            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $this->main_css_element. ' .dipi-image-gallery-thumbs',
                'declaration' => sprintf( 'height: %1$s;width: %2$s;align-self:%3$s;', 
                            $responsive_thumb_vertical_height['desktop'],
                            $responsive_thumb_width['desktop'],
                            $responsive_thumb_vertical_placement['desktop']
                        )
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $this->main_css_element. ' .dipi-image-gallery-thumbs',
                'declaration' => sprintf( 'height: %1$s;width: %2$s;align-self:%3$s;', 
                            $responsive_thumb_vertical_height['tablet'],
                            $responsive_thumb_width['tablet'],
                            $responsive_thumb_vertical_placement['tablet']
                ),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $this->main_css_element. ' .dipi-image-gallery-thumbs',
                'declaration' => sprintf( 'height: %1$s;width: %2$s;align-self:%3$s;', 
                            $responsive_thumb_vertical_height['phone'],
                            $responsive_thumb_width['phone'],
                            $responsive_thumb_vertical_placement['phone']
                ),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }

        $container_margin_class = "%%order_class%% .dipi-image-gallery-thumbs";
        $rs_container_margin= $this->dipi_get_responsive_prop('thumbs_container_margin');
        $container_margin = explode('|', $rs_container_margin['desktop']);
        $container_margin_tablet = explode('|', $rs_container_margin['tablet']);
        $container_margin_phone = explode('|', $rs_container_margin['phone']);

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $container_margin_class,
            'declaration' => sprintf('margin-top: %1$s !important; margin-right:%2$s !important; margin-bottom:%3$s !important; margin-left:%4$s !important;', $container_margin[0], $container_margin[1], $container_margin[2], $container_margin[3]),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $container_margin_class,
            'declaration' => sprintf('margin-top: %1$s !important; margin-right:%2$s !important; margin-bottom:%3$s !important; margin-left:%4$s !important;', $container_margin_tablet[0], $container_margin_tablet[1], $container_margin_tablet[2], $container_margin_tablet[3]),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $container_margin_class,
            'declaration' => sprintf('margin-top: %1$s !important; margin-right:%2$s !important; margin-bottom:%3$s !important; margin-left:%4$s !important;', $container_margin_phone[0], $container_margin_phone[1], $container_margin_phone[2], $container_margin_phone[3]),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));

        $container_class = "%%order_class%% .dipi-image-gallery-thumbs .swiper-container";
        $responsive_container_padding = $this->dipi_get_responsive_prop('thumbs_container_padding');
        $container_padding = explode('|', $responsive_container_padding['desktop']);
        $container_padding_tablet = explode('|', $responsive_container_padding['tablet']);
        $container_padding_phone = explode('|', $responsive_container_padding['phone']);

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $container_class,
            'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $container_padding[0], $container_padding[1], $container_padding[2], $container_padding[3]),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $container_class,
            'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $container_padding_tablet[0], $container_padding_tablet[1], $container_padding_tablet[2], $container_padding_tablet[3]),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $container_class,
            'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $container_padding_phone[0], $container_padding_phone[1], $container_padding_phone[2], $container_padding_phone[3]),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));
        
        $this->apply_thumbs_nav_css($render_slug);
        $this->apply_main_nav_css($render_slug);

        $float_thumbs = isset($this->props['use_float_thumbs']) ? $this->props['use_float_thumbs'] : 'off';
        
        if($float_thumbs === 'on'){
            $views = ['wide', 'tab', 'pho'];
            
            // loop through views
            foreach ($views as $view) {
                $float_view = isset($this->props['float_'. $view]) ? $this->props['float_'. $view] : 'off';
                $float_hz_placement_view = isset($this->props['float_hz_placement_'. $view]) && !empty($this->props['float_hz_placement_'. $view]) ? $this->props['float_hz_placement_'. $view] : 'center';
                $float_vr_placement_view = isset($this->props['float_vr_placement_'. $view]) && !empty($this->props['float_vr_placement_'. $view]) ? $this->props['float_vr_placement_'. $view] : 'bottom';
                $float_align_style = '';
                if($float_hz_placement_view === 'center' && $float_vr_placement_view === 'center')  
                    $float_align_style .= 'left:50%;top:50%;transform: translate(-50%, -50%);right:auto;bottom:auto;';
                else if($float_hz_placement_view === 'center' && $float_vr_placement_view === 'top')
                    $float_align_style .= 'left:50%;top:0;transform: translateX(-50%);right:auto;bottom:auto;';
                else if($float_hz_placement_view === 'center' && $float_vr_placement_view === 'bottom')
                    $float_align_style .= 'left:50%;bottom:0;transform: translateX(-50%);right:auto;top:auto;';
                else if($float_hz_placement_view === 'left' && $float_vr_placement_view === 'center')
                    $float_align_style .= 'left:0;top:50%;transform: translateY(-50%);right:auto;bottom:auto;';
                else if($float_hz_placement_view === 'right' && $float_vr_placement_view === 'center')
                    $float_align_style .= 'right:0;top:50%;transform: translateY(-50%);left:auto;bottom:auto;';
                else if($float_hz_placement_view === 'left' && $float_vr_placement_view === 'top')
                    $float_align_style .= 'left:0;top:0;transform:none;right:auto;bottom:auto;';
                else if($float_hz_placement_view === 'left' && $float_vr_placement_view === 'bottom')
                    $float_align_style .= 'left:0;bottom:0;transform:none;';
                else if($float_hz_placement_view === 'right' && $float_vr_placement_view === 'top')
                    $float_align_style .= 'right:0;top:0;transform:none;left:auto;bottom:auto;';
                else if($float_hz_placement_view === 'right' && $float_vr_placement_view === 'bottom')
                    $float_align_style .= 'right:0;bottom:0;transform:none;left:auto;top:auto;';
                else
                    $float_align_style .= 'left:0;top:0;';
       
               
                $float_style = [
                    'selector' => "%%order_class%% .dipi-image-gallery-thumbs",
                    'declaration' => 'z-index: 10;position: absolute;' . $float_align_style, 
                ];
                
                if($float_view !== 'on' ) {
                    $float_style['declaration'] = 'z-index: 10;position: relative; left: auto; right: auto; top: auto; bottom: auto; transform: none;';
                }
               
                
                if($view === 'tab') {
                    $float_style['media_query'] = ET_Builder_Element::get_media_query('max_width_980');
                }
                if($view === 'pho') {
                    $float_style['media_query'] = ET_Builder_Element::get_media_query('max_width_767');
                }
                 

                ET_Builder_Element::set_style($render_slug, $float_style);
            }
        }

    }

    public function apply_thumbs_nav_css($render_slug){
        $thumbs_navigation_size  = isset($this->props['thumbs_navigation_size']) ? $this->props['thumbs_navigation_size'] : '';
        $thumbs_navigation_padding  = isset($this->props['thumbs_navigation_padding']) ? $this->props['thumbs_navigation_padding'] : '';
        $thumbs_navigation_circle  = isset($this->props['thumbs_navigation_circle']) ? $this->props['thumbs_navigation_circle'] : '';
        $thumbs_navigation_color  = isset($this->props['thumbs_navigation_color']) ? $this->props['thumbs_navigation_color'] : '';
        $thumbs_navigation_bg_color  = isset($this->props['thumbs_navigation_bg_color']) ? $this->props['thumbs_navigation_bg_color'] : '';
        $thumbs_navigation_position_horizontal   = isset($this->props['thumbs_navigation_position_horizontal']) ? $this->props['thumbs_navigation_position_horizontal'] : '';
        $thumbs_navigation_position_vertical  = isset($this->props['thumbs_navigation_position_vertical']) ? $this->props['thumbs_navigation_position_vertical'] : '';

        if( '' !== $thumbs_navigation_size ) {
            $responsive_thumbs_navigation_size = $this->dipi_get_responsive_prop('thumbs_navigation_size');
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dipi-image-gallery-thumbs .swiper-button-next, %%order_class%% .dipi-image-gallery-thumbs .swiper-button-prev',
                'declaration' => sprintf('width: %1$spx !important; height: %1$spx !important;', $responsive_thumbs_navigation_size['desktop']),
            ) );
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dipi-image-gallery-thumbs .swiper-button-next, %%order_class%% .dipi-image-gallery-thumbs .swiper-button-prev',
                'declaration' => sprintf('width: %1$spx !important; height: %1$spx !important;', $responsive_thumbs_navigation_size['tablet']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dipi-image-gallery-thumbs .swiper-button-next, %%order_class%% .dipi-image-gallery-thumbs .swiper-button-prev',
                'declaration' => sprintf('width: %1$spx !important; height: %1$spx !important;', $responsive_thumbs_navigation_size['phone']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));

            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => '%%order_class%% .dipi-image-gallery-thumbs .swiper-button-next:after, %%order_class%% .dipi-image-gallery-thumbs .swiper-button-next:before, %%order_class%% .dipi-image-gallery-thumbs .swiper-button-prev:after, %%order_class%% .dipi-image-gallery-thumbs .swiper-button-prev:before',
                'declaration' => sprintf('font-size: %1$spx !important;', $responsive_thumbs_navigation_size['desktop']),
            ) );
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => '%%order_class%% .dipi-image-gallery-thumbs .swiper-button-next:after, %%order_class%% .dipi-image-gallery-thumbs .swiper-button-next:before, %%order_class%% .dipi-image-gallery-thumbs .swiper-button-prev:after, %%order_class%% .dipi-image-gallery-thumbs .swiper-button-prev:before',
                'declaration' => sprintf('font-size: %1$spx !important;', $responsive_thumbs_navigation_size['tablet']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => '%%order_class%% .dipi-image-gallery-thumbs .swiper-button-next:after, %%order_class%% .dipi-image-gallery-thumbs .swiper-button-next:before, %%order_class%% .dipi-image-gallery-thumbs .swiper-button-prev:after, %%order_class%% .dipi-image-gallery-thumbs .swiper-button-prev:before',
                'declaration' => sprintf('font-size: %1$spx !important;', $responsive_thumbs_navigation_size['phone']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }

        if( '' !== $thumbs_navigation_padding ) {
            $responsive_thumbs_navigation_padding = $this->dipi_get_responsive_prop('thumbs_navigation_padding');
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dipi-image-gallery-thumbs .swiper-button-next, %%order_class%% .dipi-image-gallery-thumbs .swiper-button-prev',
                'declaration' => sprintf('padding: %1$spx !important;', $responsive_thumbs_navigation_padding['desktop']),
            ) );
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dipi-image-gallery-thumbs .swiper-button-next, %%order_class%% .dipi-image-gallery-thumbs .swiper-button-prev',
                'declaration' => sprintf('padding: %1$spx !important;', $responsive_thumbs_navigation_padding['tablet']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dipi-image-gallery-thumbs .swiper-button-next, %%order_class%% .dipi-image-gallery-thumbs .swiper-button-prev',
                'declaration' => sprintf('padding: %1$spx !important;', $responsive_thumbs_navigation_padding['phone']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }

        if( 'on' == $thumbs_navigation_circle ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dipi-image-gallery-thumbs .swiper-button-next, %%order_class%% .dipi-image-gallery-thumbs .swiper-button-prev',
                'declaration' => 'border-radius: 50% !important;',
            ) );
        }
        if( '' !== $thumbs_navigation_color ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dipi-image-gallery-thumbs .swiper-button-next:after, %%order_class%% .dipi-image-gallery-thumbs .swiper-button-next:before, %%order_class%% .dipi-image-gallery-thumbs .swiper-button-prev:after, %%order_class%% .dipi-image-gallery-thumbs .swiper-button-prev:before',
                'declaration' => sprintf('color: %1$s!important;', $thumbs_navigation_color),
            ) );
        }
        $this->apply_custom_style_for_hover(
            $render_slug,
            'thumbs_navigation_color',
            'color',
            '%%order_class%% .dipi-image-gallery-thumbs .swiper-button-next:hover:after,
            %%order_class%% .dipi-image-gallery-thumbs .swiper-button-next:hover:before,
            %%order_class%% .dipi-image-gallery-thumbs .swiper-button-prev:hover:after,
            %%order_class%% .dipi-image-gallery-thumbs .swiper-button-prev:hover:before',
            true
        );
        if( '' !== $thumbs_navigation_bg_color ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dipi-image-gallery-thumbs .swiper-button-next,
                    %%order_class%% .dipi-image-gallery-thumbs .swiper-button-prev',
                'declaration' => sprintf('background: %1$s!important;', $thumbs_navigation_bg_color),
            ) );
        }
        $this->apply_custom_style_for_hover(
            $render_slug,
            'thumbs_navigation_bg_color',
            'background',
            '%%order_class%% .dipi-image-gallery-thumbs .swiper-button-next:hover,
            %%order_class%% .dipi-image-gallery-thumbs .swiper-button-prev:hover',
            true
        );

        $thumbs_navigation_position_left_class      = "%%order_class%% .dipi-image-gallery-thumbs .swiper-button-prev, %%order_class%%:hover .dipi-image-gallery-thumbs .swiper-button-prev.swiper-arrow-button.show_on_hover";
        $thumbs_navigation_position_right_class     = "%%order_class%% .dipi-image-gallery-thumbs .swiper-button-next, %%order_class%%:hover .dipi-image-gallery-thumbs .swiper-button-next.swiper-arrow-button.show_on_hover";
        
        $rs_thumbs_navigation_position_horizontal = $this->dipi_get_responsive_prop('thumbs_navigation_position_horizontal');

        if('' !== $thumbs_navigation_position_horizontal ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $thumbs_navigation_position_left_class,
                'declaration' => sprintf('left: %1$s;', $rs_thumbs_navigation_position_horizontal['desktop']),
            ) );
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $thumbs_navigation_position_left_class,
                'declaration' => sprintf( 'left: %1$s;', $rs_thumbs_navigation_position_horizontal['tablet']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $thumbs_navigation_position_left_class,
                'declaration' => sprintf( 'left: %1$s;', $rs_thumbs_navigation_position_horizontal['phone']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $thumbs_navigation_position_right_class,
                'declaration' => sprintf('right: %1$s;', $rs_thumbs_navigation_position_horizontal['desktop']),
            ) );
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $thumbs_navigation_position_right_class,
                'declaration' => sprintf( 'right: %1$s;', $rs_thumbs_navigation_position_horizontal['tablet']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $thumbs_navigation_position_right_class,
                'declaration' => sprintf( 'right: %1$s;', $rs_thumbs_navigation_position_horizontal['phone']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }

        $rs_thumbs_navigation_position_vertical = $this->dipi_get_responsive_prop('thumbs_navigation_position_vertical');
        if('' !== $thumbs_navigation_position_vertical ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $thumbs_navigation_position_right_class . ', ' . $thumbs_navigation_position_left_class,
                'declaration' => sprintf('top: %1$s;', $rs_thumbs_navigation_position_vertical['desktop']),
            ) );
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $thumbs_navigation_position_right_class . ', ' . $thumbs_navigation_position_left_class,
                'declaration' => sprintf( 'top: %1$s;', $rs_thumbs_navigation_position_vertical['tablet']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $thumbs_navigation_position_right_class . ', ' . $thumbs_navigation_position_left_class,
                'declaration' => sprintf( 'top: %1$s;', $rs_thumbs_navigation_position_vertical['phone']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }
  
    }
   
    public function apply_main_nav_css($render_slug){
        $main_navigation_padding = $this->props['main_navigation_padding'];
        $main_navigation_circle = $this->props['main_navigation_circle'];
        $main_navigation_color = $this->props['main_navigation_color'];
        $main_navigation_size = $this->props['main_navigation_size'];
        $main_navigation_bg_color = $this->props['main_navigation_bg_color'];
        $main_navigation_position_horizontal = $this->props['main_navigation_position_horizontal'];
        $main_navigation_position_vertical = $this->props['main_navigation_position_vertical'];

       if( '' !== $main_navigation_size ) {
            $responsive_main_navigation_size = $this->dipi_get_responsive_prop('main_navigation_size');
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dipi-image-gallery-top .swiper-button-next, %%order_class%% .dipi-image-gallery-top .swiper-button-prev',
                'declaration' => sprintf('width: %1$spx !important; height: %1$spx !important;', $responsive_main_navigation_size['desktop']),
            ) );
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dipi-image-gallery-top .swiper-button-next, %%order_class%% .dipi-image-gallery-top .swiper-button-prev',
                'declaration' => sprintf('width: %1$spx !important; height: %1$spx !important;', $responsive_main_navigation_size['tablet']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dipi-image-gallery-top .swiper-button-next, %%order_class%% .dipi-image-gallery-top .swiper-button-prev',
                'declaration' => sprintf('width: %1$spx !important; height: %1$spx !important;', $responsive_main_navigation_size['phone']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));

            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => '%%order_class%% .dipi-image-gallery-top .swiper-button-next:after, %%order_class%% .dipi-image-gallery-top .swiper-button-next:before, %%order_class%% .dipi-image-gallery-top .swiper-button-prev:after, %%order_class%% .dipi-image-gallery-top .swiper-button-prev:before',
                'declaration' => sprintf('font-size: %1$spx !important;', $responsive_main_navigation_size['desktop']),
            ) );
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => '%%order_class%% .dipi-image-gallery-top .swiper-button-next:after, %%order_class%% .dipi-image-gallery-top .swiper-button-next:before, %%order_class%% .dipi-image-gallery-top .swiper-button-prev:after, %%order_class%% .dipi-image-gallery-top .swiper-button-prev:before',
                'declaration' => sprintf('font-size: %1$spx !important;', $responsive_main_navigation_size['tablet']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => '%%order_class%% .dipi-image-gallery-top .swiper-button-next:after, %%order_class%% .dipi-image-gallery-top .swiper-button-next:before, %%order_class%% .dipi-image-gallery-top .swiper-button-prev:after, %%order_class%% .dipi-image-gallery-top .swiper-button-prev:before',
                'declaration' => sprintf('font-size: %1$spx !important;', $responsive_main_navigation_size['phone']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }

        if( '' !== $main_navigation_padding ) {
            $responsive_main_navigation_padding = $this->dipi_get_responsive_prop('main_navigation_padding');
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dipi-image-gallery-top .swiper-button-next, %%order_class%% .dipi-image-gallery-top .swiper-button-prev',
                'declaration' => sprintf('padding: %1$spx !important;', $responsive_main_navigation_padding['desktop']),
            ) );
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dipi-image-gallery-top .swiper-button-next, %%order_class%% .dipi-image-gallery-top .swiper-button-prev',
                'declaration' => sprintf('padding: %1$spx !important;', $responsive_main_navigation_padding['tablet']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dipi-image-gallery-top .swiper-button-next, %%order_class%% .dipi-image-gallery-top .swiper-button-prev',
                'declaration' => sprintf('padding: %1$spx !important;', $responsive_main_navigation_padding['phone']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }



        if( 'on' == $main_navigation_circle ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dipi-image-gallery-top .swiper-button-next, %%order_class%% .dipi-image-gallery-top .swiper-button-prev',
                'declaration' => 'border-radius: 50% !important;',
            ) );
        }

        if( '' !== $main_navigation_color ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dipi-image-gallery-top .swiper-button-next:after, %%order_class%% .dipi-image-gallery-top .swiper-button-next:before, %%order_class%% .dipi-image-gallery-top .swiper-button-prev:after, %%order_class%% .dipi-image-gallery-top .swiper-button-prev:before',
                'declaration' => sprintf('color: %1$s!important;', $main_navigation_color),
            ) );
        }
        $this->apply_custom_style_for_hover(
            $render_slug,
            'main_navigation_color',
            'color',
            '%%order_class%% .dipi-image-gallery-top .swiper-button-next:hover:after, %%order_class%% .dipi-image-gallery-top .swiper-button-next:hover:before, %%order_class%% .dipi-image-gallery-top .swiper-button-prev:hover:after, %%order_class%% .dipi-image-gallery-top .swiper-button-prev:hover:before',
            true
        );
        if( '' !== $main_navigation_bg_color ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector'    => '%%order_class%% .dipi-image-gallery-top .swiper-button-next, %%order_class%% .dipi-image-gallery-top .swiper-button-prev',
                'declaration' => sprintf('background: %1$s!important;', $main_navigation_bg_color),
            ) );
        }
        $this->apply_custom_style_for_hover(
            $render_slug,
            'main_navigation_bg_color',
            'background',
            '%%order_class%% .dipi-image-gallery-top .swiper-button-next:hover, %%order_class%% .dipi-image-gallery-top .swiper-button-prev:hover',
            true
        );

        $main_navigation_position_left_class      = "%%order_class%% .dipi-image-gallery-top .swiper-button-prev, %%order_class%%:hover .dipi-image-gallery-top .swiper-button-prev.swiper-arrow-button.show_on_hover";
        $main_navigation_position_right_class     = "%%order_class%% .dipi-image-gallery-top .swiper-button-next, %%order_class%%:hover .dipi-image-gallery-top .swiper-button-next.swiper-arrow-button.show_on_hover";
        $rs_main_navigation_position_horizontal = $this->dipi_get_responsive_prop('main_navigation_position_horizontal');

        if('' !== $main_navigation_position_horizontal ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $main_navigation_position_left_class,
                'declaration' => sprintf('left: %1$s;', $rs_main_navigation_position_horizontal['desktop']),
            ) );
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $main_navigation_position_left_class,
                'declaration' => sprintf( 'left: %1$s;', $rs_main_navigation_position_horizontal['tablet']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $main_navigation_position_left_class,
                'declaration' => sprintf( 'left: %1$s;', $rs_main_navigation_position_horizontal['phone']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $main_navigation_position_right_class,
                'declaration' => sprintf('right: %1$s;', $rs_main_navigation_position_horizontal['desktop']),
            ) );
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $main_navigation_position_right_class,
                'declaration' => sprintf( 'right: %1$s;', $rs_main_navigation_position_horizontal['tablet']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $main_navigation_position_right_class,
                'declaration' => sprintf( 'right: %1$s;', $rs_main_navigation_position_horizontal['phone']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }

    

        $rs_main_navigation_position_vertical = $this->dipi_get_responsive_prop('main_navigation_position_vertical');

        if('' !== $main_navigation_position_vertical ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $main_navigation_position_left_class . ', ' . $main_navigation_position_right_class,
                'declaration' => sprintf('top: %1$s;', $rs_main_navigation_position_vertical['desktop']),
            ) );
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $main_navigation_position_left_class,
                'declaration' => sprintf( 'top: %1$s;', $rs_main_navigation_position_vertical['tablet']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $main_navigation_position_left_class,
                'declaration' => sprintf( 'top: %1$s;', $rs_main_navigation_position_vertical['phone']),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }

       
    }

    static function inject_style($render_slug, $selector, $declration, $screen = 'desktop'){
        $config = [
            'selector' => $selector,
            'declaration' => $declration
        ];
        if($screen === 'tablet') $config['media_query'] = ET_Builder_Element::get_media_query('max_width_980');
        if($screen === 'phone') $config['media_query'] = ET_Builder_Element::get_media_query('max_width_767');
        ET_Builder_Element::set_style( $render_slug, $config);
    }
 
    public function get_thumbs_html() {
        global $dipi_image_slider_thumbs;
        $thumbs_html = '';
        if(count($dipi_image_slider_thumbs) > 0){
            foreach($dipi_image_slider_thumbs as $image) {
                $thumbs_html .= sprintf('
                <div class="dipi_image_gallery_child swiper-slide">
                    <div class="swiper-slide-container" role="figure" aria-labelledby="%2$s" style="background-image:url(%1$s);background-size:%3$s;    background-repeat: no-repeat;"></div>
                </div>', 
                $image['url'],
                $image['alt'],
                $image['size']
                );
            }
        } else {
            $thumbs_html .= sprintf('
                <div class="dipi_image_gallery_child swiper-slide"><div class="swiper-slide-container" style="background-color: rgba(240, 240, 240, 0.8)"></div></div>
                <div class="dipi_image_gallery_child swiper-slide"><div class="swiper-slide-container" style="background-color: rgba(240, 240, 240, 0.8)"></div></div>
            ');
        }
        return $thumbs_html;
    }
    public function before_render() {
        global $dipi_image_slider_thumbs;
        $dipi_image_slider_thumbs = [];
    }

    public function render($attrs, $content, $render_slug) {
       
        wp_enqueue_script('dipi_image_gallery_public');
        wp_enqueue_style('dipi_swiper');
        wp_enqueue_style('dipi_animate');
        
        $enable_popup = isset($this->props['enable_popup']) ? $this->props['enable_popup'] : 'off';
        $popup_animataion_speed = $this->props['popup_animation_duration']? $this->props['popup_animation_duration'] : '500';
        if($enable_popup === 'on') {
            wp_enqueue_style('magnific-popup');
            wp_enqueue_script('magnific-popup');
        }
        
        $thumbs_alignment = isset($this->props['thumbs_alignment']) ? $this->props['thumbs_alignment'] : '';
        $thumbs_position_horizontal = isset($this->props['thumbs_position_horizontal']) ? $this->props['thumbs_position_horizontal'] : '';
        $thumbs_alignment = isset($this->props['thumbs_alignment']) ? $this->props['thumbs_alignment'] : '';
        $main_navigation = isset($this->props['main_navigation']) ? $this->props['main_navigation'] : '';
        $main_slider_animation = isset($this->props['main_slider_animation']) ? $this->props['main_slider_animation'] : '';
        $main_autoplay = isset($this->props['main_autoplay']) ? $this->props['main_autoplay'] : '';
        $pause_on_hover = isset($this->props['pause_on_hover']) ? $this->props['pause_on_hover'] : '';
        $autoplay_delay = isset($this->props['autoplay_delay']) ? $this->props['autoplay_delay'] : '';
        $main_navigation_on_hover = isset($this->props['main_navigation_on_hover']) ? $this->props['main_navigation_on_hover'] : '';
        $main_navigation_next_icon_yn = isset($this->props['main_navigation_next_icon_yn']) ? $this->props['main_navigation_next_icon_yn'] : '';
        $main_navigation_prev_icon_yn = isset($this->props['main_navigation_prev_icon_yn']) ? $this->props['main_navigation_prev_icon_yn'] : '';
        $main_navigation_next_icon = isset($this->props['main_navigation_next_icon']) ? $this->props['main_navigation_next_icon'] : '9';
        $main_navigation_prev_icon = isset($this->props['main_navigation_prev_icon']) ? $this->props['main_navigation_prev_icon'] : '8';
        $main_navigation = isset($this->props['main_navigation']) ? $this->props['main_navigation'] : '';
        $thumbs_alignment = isset($this->props['thumbs_alignment']) ? $this->props['thumbs_alignment'] : '';
        $thumbs_centered = isset($this->props['thumbs_centered']) ? $this->props['thumbs_centered'] : '';
        $thumbs_loop = isset($this->props['thumbs_loop']) ? $this->props['thumbs_loop'] : 'on';
        $thumbs_navigation = isset($this->props['thumbs_navigation']) ? $this->props['thumbs_navigation'] : '';
        $thumbs_navigation_on_hover  = isset($this->props['thumbs_navigation_on_hover']) ? $this->props['thumbs_navigation_on_hover'] : '';
        $thumbs_navigation_next_icon_yn = isset($this->props['thumbs_navigation_next_icon_yn']) ? $this->props['thumbs_navigation_next_icon_yn'] : '';
        $thumbs_navigation_prev_icon_yn = isset($this->props['thumbs_navigation_prev_icon_yn']) ? $this->props['thumbs_navigation_prev_icon_yn'] : '';
        $thumbs_navigation_next_icon = isset($this->props['thumbs_navigation_next_icon']) ? $this->props['thumbs_navigation_next_icon'] : '9';
        $thumbs_navigation_prev_icon = isset($this->props['thumbs_navigation_prev_icon']) ? $this->props['thumbs_navigation_prev_icon'] : '8';
        $thumbs_navigation = isset($this->props['thumbs_navigation']) ? $this->props['thumbs_navigation'] : '';
        $thumbs_alignment = isset($this->props['thumbs_alignment']) ? $this->props['thumbs_alignment'] : '';
        $thumbs_alignment = isset($this->props['thumbs_alignment']) ? $this->props['thumbs_alignment'] : '';
        $thumbs_position_vertical = isset($this->props['thumbs_position_vertical']) ? $this->props['thumbs_position_vertical'] : 'left';
        $thumbs_position_horizontal = isset($this->props['thumbs_position_horizontal']) ? $this->props['thumbs_position_horizontal'] : 'bottom';
        
        
        $order_class = self::get_module_order_class($render_slug);
        $order_number = str_replace('_', '', str_replace($this->slug, '', $order_class));
        $is_tb_body = preg_match("/tb_body/i", $order_class) ? 'on' : 'off';
        
        $this->apply_css($render_slug);

        global $dipi_image_slider_thumbs;
        $extra_classes = '';
        $gallery_extra_classes = 'dipi-image-gallery-top_' . $order_number;
        $thumbs_extra_classes = 'dipi-image-gallery-thumbs_' . $order_number;
        if($thumbs_alignment == 'vertical' ){
            $extra_classes = 'dipi-ig-vertical';
            $thumbs_extra_classes .= ' dipi-thumbs-vertical';
            $thumbs_extra_classes .= ' dipi-img-thumbs-' . $thumbs_position_vertical;
        }else{
            $extra_classes = 'dipi-ig-horizontal';
            $thumbs_extra_classes .= ' dipi-thumbs-horizontal';
            $thumbs_extra_classes .= ' dipi-img-thumbs-' . $thumbs_position_horizontal;
        }

        
            
        if($this->props['enable_popup'] === 'on'){
            $extra_classes .= ' dipi-ig-popup';
        }
        $images_html = '';
        $thumbs_html = '';
        if(count($dipi_image_slider_thumbs) > 0){
            $images_html .= et_core_sanitized_previously($this->content);
            
        } else {
            $images_html .= sprintf('<div class="dipi_image_gallery_child swiper-slide"><div class="swiper-slide-container" style="background-color: rgba(240, 240, 240, 0.8)"></div></div>');
        }
        $thumbs_html = $this->get_thumbs_html();

        $gallery_dataset_arr = [
            'direction' => $thumbs_alignment,
            'navigation' => $main_navigation,
            'ordernumber' => $order_number,
            'animation' => $main_slider_animation,
            'autoplay' => $main_autoplay,
            'pause_on_hover' => $pause_on_hover,
            'autoplay_delay' => $autoplay_delay,
            'enable_popup' => $enable_popup,
            'popup_animation' => $this->props['popup_animation']? $this->props['popup_animation'] : 'none',
            'popup_animation_duration' => $this->props['popup_animation_duration']? $this->props['popup_animation_duration'] : '500'
        ];
        $gallery_dataset = '';
        foreach($gallery_dataset_arr as $key => $value){
            $gallery_dataset .= ' data-'.$key.'="'.$value.'"';
        }

        $main_next_icon_render = 'data-icon="9"';
        if('on' === $main_navigation_next_icon_yn) {
            $main_next_icon_render = sprintf( 'data-icon="%1$s"', esc_attr( et_pb_process_font_icon( $main_navigation_next_icon ) ) );
            $this->dipi_generate_font_icon_styles($render_slug, 'main_navigation_next_icon', '%%order_class%% .dipi-ig-top-nav.swiper-button-next:after');
        }
        
        $main_prev_icon_render = 'data-icon="8"';
        if('on' === $main_navigation_prev_icon_yn) {
            $main_prev_icon_render = sprintf( 'data-icon="%1$s"', esc_attr( et_pb_process_font_icon( $main_navigation_prev_icon ) ) );
            $this->dipi_generate_font_icon_styles($render_slug, 'main_navigation_prev_icon', '%%order_class%% .dipi-ig-top-nav.swiper-button-prev:after');

        }

        $main_navigation_html = '';
        if( $main_navigation == 'on' ) {
            $main_navigation_html = sprintf(
                '<div class="swiper-button-next swiper-arrow-button dipi-sbn%1$s dipi-ig-top-nav %4$s" %2$s></div> 
                 <div class="swiper-button-prev swiper-arrow-button dipi-sbp%1$s dipi-ig-top-nav %4$s" %3$s></div>',
                $order_number,
                $main_next_icon_render,
                $main_prev_icon_render,
                $main_navigation_on_hover === "on" ? "show_on_hover" : ""
            );
        }

        
        $gallery_top = sprintf('
            <div class="dipi-image-gallery-top">
                <div class=" swiper-container %3$s"  %2$s>
                            <div class="swiper-wrapper">
                                %1$s
                            </div>  
                        </div>
                        %4$s
                </div>', 
                $images_html,
                $gallery_dataset,
                $gallery_extra_classes,
                $main_navigation_html,
                $popup_animataion_speed
                );
                        
        $responsive_thumbs_count = $this->dipi_get_responsive_prop('thumbs_count');
        $responsive_thumbs_space_between = $this->dipi_get_responsive_prop('thumbs_space_between');
        $thumbs_dataset_arr = [
            'direction' => $thumbs_alignment,
            'columnsdesktop' => $responsive_thumbs_count['desktop'],
            'columnstablet' => $responsive_thumbs_count['tablet'],
            'columnsphone' => $responsive_thumbs_count['phone'],
            'spacebetween' => $responsive_thumbs_space_between['desktop'],
            'spacebetween_tablet' => $responsive_thumbs_space_between['tablet'],
            'spacebetween_phone' => $responsive_thumbs_space_between['phone'],
            'centered' => $thumbs_centered,
            'thumbs_loop' => $thumbs_loop,
            'ordernumber' => $order_number,
            'navigation' => $thumbs_navigation,
            'is_tb_body' => $is_tb_body
        ];
        
        $thumbs_dataset = '';
        foreach($thumbs_dataset_arr as $key => $value){
            $thumbs_dataset .= ' data-'.$key.'="'.$value.'"';
        }

         
        $thumbs_next_icon_render = 'data-icon="9"';
        if('on' === $thumbs_navigation_next_icon_yn) {
            $thumbs_next_icon_render = sprintf( 'data-icon="%1$s"', esc_attr( et_pb_process_font_icon( $thumbs_navigation_next_icon ) ) );
            $this->dipi_generate_font_icon_styles($render_slug, 'thumbs_navigation_next_icon', '%%order_class%% .dipi-ig-thumbs-nav.swiper-button-next:after');
        }
        
        $thumbs_prev_icon_render = 'data-icon="8"';
        if('on' === $thumbs_navigation_prev_icon_yn) {
            $thumbs_prev_icon_render = sprintf( 'data-icon="%1$s"', esc_attr( et_pb_process_font_icon( $thumbs_navigation_prev_icon ) ) );
            $this->dipi_generate_font_icon_styles($render_slug, 'thumbs_navigation_prev_icon', '%%order_class%% .dipi-ig-thumbs-nav.swiper-button-prev:after');
        }
        $thumbs_navigation_html = '';
        if( $thumbs_navigation == 'on' ) {
            $thumbs_navigation_html = sprintf(
                '<div class="swiper-button-next swiper-arrow-button dipi-sbn%1$s dipi-ig-thumbs-nav  %4$s" %2$s></div> 
                 <div class="swiper-button-prev swiper-arrow-button dipi-sbp%1$s dipi-ig-thumbs-nav  %4$s" %3$s></div>',
                $order_number,
                $thumbs_next_icon_render,
                $thumbs_prev_icon_render,
                $thumbs_navigation_on_hover === "on" ? "show_on_hover" : ""
            );
        }
         
        $gallery_thumbs = sprintf('
        <div class="dipi-image-gallery-thumbs">
            <div class="swiper-container %2$s" %3$s>
                <div class="swiper-wrapper">
                    %1$s
                </div>
            </div>%4$s
        </div>',
            $thumbs_html,
            $thumbs_extra_classes,
            $thumbs_dataset,
            $thumbs_navigation_html
        );
      
        if( ($thumbs_alignment == 'horizontal' && $thumbs_position_horizontal == 'top') || 
            ($thumbs_alignment == 'vertical' && $thumbs_position_vertical == 'left')){
            $gallery_content = sprintf('%1$s %2$s', $gallery_thumbs, $gallery_top);
        } else {
            $gallery_content = sprintf('%2$s %1$s', $gallery_thumbs, $gallery_top);
        }

        $output = sprintf('<div class="dipi-image-gallery %2$s" style="height:100%%">%1$s</div>', 
            $gallery_content,
            $extra_classes);
        
        
        return $output;
    }
    public function get_custom_style($slug_value, $type, $important)
    {
        return sprintf('%1$s: %2$s%3$s;', $type, $slug_value, $important ? ' !important' : '');
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
}

new DIPI_ImageGallery;