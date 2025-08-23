<?php

class DIPI_Carousel extends DIPI_Builder_Module
{

    public $slug = 'dipi_carousel';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/carousel',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__('Pixel Carousel', 'dipi-divi-pixel');
        $this->child_slug = 'dipi_carousel_child';
        $this->main_css_element = '%%order_class%%.dipi_carousel';
    }

    public function get_settings_modal_toggles()
    {
        return [
            'general' => [
                'toggles' => [
                    'carousel' => esc_html__('Carousel Settings', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'overlay' => esc_html__('Slide Shadow', 'dipi-divi-pixel'),
                    'alignment' => esc_html__('Alignment', 'dipi-divi-pixel'),
                    'carousel_text' => [
                        'sub_toggles' => [
                            'title' => array(
                                'name' => 'Title',
                            ),
                            'desc' => array(
                                'name' => 'Desc',
                            ),
                        ],
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__('Carousel Text', 'dipi-divi-pixel'),
                    ],
                    'carousel_item' => esc_html__('Carousel Item', 'dipi-divi-pixel'),
                    'navigation' => esc_html__('Navigation', 'dipi-divi-pixel'),
                    'pagination' => esc_html__('Pagination', 'dipi-divi-pixel'),
                ],
            ],
        ];
    }

    public function get_custom_css_fields_config()
    {

        $fields = [];

        $fields['img'] = [
            'label' => esc_html__('Image', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-carousel-image',
        ];

        $fields['icon'] = [
            'label' => esc_html__('Icon', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-carousel-icon',
        ];

        $fields['title'] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-carousel-item-title',
        ];

        $fields['description'] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-carousel-item-desc',
        ];

        $fields['button'] = [
            'label' => esc_html__('Button', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-carousel-button',
        ];

        $fields['navigation'] = [
            'label' => esc_html__('Navigation', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .swiper-arrow-button',
        ];
        
        $fields['prev_main_navigation'] = [
            'label'    => esc_html__('Prev Main Navigation', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .swiper-arrow-button.swiper-button-prev',
        ];
        $fields['next_thumbs_navigation'] = [
            'label'    => esc_html__('Next Main Navigation', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .swiper-arrow-button.swiper-button-next',
        ];

        $fields['pagination'] = [
            'label' => esc_html__('Pagination', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .swiper-pagination',
        ];

        $fields['active_slide'] = [
            'label' => esc_html__('Active Slide', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .swiper-slide-active',
        ];

        $fields['not_active_slide'] = [
            'label' => esc_html__('Not Active Slides', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_carousel_child:not(.swiper-slide-active)',
        ];

        return $fields;
    }

    public function get_fields()
    {

        $fields = [];

        $fields['columns'] = [
            'label' => esc_html('Number of Columns', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '4',
            'range_settings' => [
                'min' => '1',
                'max' => '12',
                'step' => '1',
            ],
            'unitless' => true,
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug' => 'carousel',
        ];

        $fields['space_between'] = [
            'label' => esc_html('Spacing', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '30',
            'range_settings' => [
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ],
            'unitless' => true,
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug' => 'carousel',
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

        $fields['effect'] = [
            'label' => esc_html__('Effect', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'layout',
            'options' => [
                'coverflow' => esc_html__('Coverflow', 'dipi-divi-pixel'),
                'slide' => esc_html__('Slide', 'dipi-divi-pixel'),
            ],
            'default' => 'slide',
            'toggle_slug' => 'carousel',
        ];

        $fields['slide_shadows'] = [
            'label' => esc_html__('Slide Shadow', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'default' => 'on',
            'show_if' => [
                'effect' => 'coverflow',
            ],
            'toggle_slug' => 'carousel',
        ];

        $fields["shadow_overlay_color"] = [
            'label' => esc_html__('Side Item Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'show_if' => [
                'effect' => 'coverflow',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'overlay',
        ];

        $fields['rotate'] = [
            'label' => esc_html('Rotate', 'dipi-divi-pixel'),
            'type' => 'range',
            'range_settings ' => [
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ],
            'default' => '50',
            'show_if' => [
                'effect' => 'coverflow',
            ],
            'validate_unit' => true,
            'toggle_slug' => 'carousel',
        ];

        $fields['speed'] = [
            'label' => esc_html__('Transition Duration', 'dipi-divi-pixel'),
            'type' => 'range',
            'range_settings' => [
                'min' => '1',
                'max' => '5000',
                'step' => '100',
            ],
            'default' => 500,
            'mobile_options' => true,
            'validate_unit' => false,
            'toggle_slug' => 'carousel',
        ];

     


        $fields['autoplay'] = [
            'label'             => esc_html__( 'Loop & Autoplay ', 'dipi-divi-pixel' ),
            'type'              => 'composite',
            'toggle_slug'       => 'carousel',
            'composite_type'    => 'default',
            'composite_structure' => array(
                'desktop' => array(
                    'icon'     => 'desktop',
                    'controls' =>  [
                        // enable tabs slider 
                        'loop_wide' => [
                            'label' => esc_html__('Loop', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'option_category' => 'configuration',
                            'options' => [
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off'
                        ],
                        'autoplay_wide' => [
                            'label' => esc_html__('Autoplay', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off',
                        ],
                        'continues_wide' => [
                            'label' => esc_html__('Continuous Slide', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off',
                            'default_on_front' => 'off',
                            'toggle_slug' => 'carousel',
                            'show_if' => [
                                'loop_wide' => 'on',
                                'autoplay_wide' => 'on'
                            ]
                        ],
                        'autoplay_reverse_wide' => [
                            'label' => esc_html__('Reverse Slide', 'dipi-divi-pixel'),
                            'description' => esc_html__('Reverse the slide direction (Works only in frontend)', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off',
                            'show_if' => [
                                'autoplay_wide' => 'on',
                            ],
                        ],
                        'pause_on_hover_wide' => [
                            'label' => esc_html__('Pause on Hover', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                            ],
                            'show_if' => [
                                'autoplay_wide' => 'on',
                            ],
                        ],
                        'autoplay_speed_wide' => [
                            'label' => esc_html__('Autoplay Speed', 'dipi-divi-pixel'),
                            'type' => 'range',
                            'range_settings' => array(
                                'min' => '1',
                                'max' => '10000',
                                'step' => '500',
                            ),
                            'default' => 5000,
                            'validate_unit' => false,
                            'show_if' => array(
                                'autoplay_wide' => 'on',
                            )
                        ]
                        
                    ],
                ),
                'tablet' => array(
                    'icon'     => 'tablet',
                    'controls' =>  [
                        'loop_mid' => [
                            'label' => esc_html__('Loop', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'option_category' => 'configuration',
                            'options' => [
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off'
                        ],
                        'autoplay_mid' => [
                            'label' => esc_html__('Autoplay', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off',
                        ],
                        'continues_mid' => [
                            'label' => esc_html__('Continuous Slide', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off',
                            'default_on_front' => 'off',
                            'toggle_slug' => 'carousel',
                            'show_if' => [
                                'loop_mid' => 'on',
                                'autoplay_mid' => 'on'
                            ]
                        ],
                        'autoplay_reverse_mid' => [
                            'label' => esc_html__('Reverse Slide', 'dipi-divi-pixel'),
                            'description' => esc_html__('Reverse the slide direction (Works only in frontend)', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off',
                            'show_if' => [
                                'autoplay_mid' => 'on',
                            ],
                        ],
                        'pause_on_hover_mid' => [
                            'label' => esc_html__('Pause on Hover', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                            ],
                            'show_if' => [
                                'autoplay_mid' => 'on',
                            ]
                        ],
                        'autoplay_speed_mid' => [
                            'label' => esc_html__('Autoplay Speed', 'dipi-divi-pixel'),
                            'type' => 'range',
                            'range_settings' => array(
                                'min' => '1',
                                'max' => '10000',
                                'step' => '500',
                            ),
                            'default' => 5000,
                            'validate_unit' => false,
                            'show_if' => array(
                                'autoplay_mid' => 'on',
                            )
                        ]

                    ],
                ),
                'phone' => array(
                    'icon'     => 'phone',
                    'controls' =>  [
                        'loop_small' => [
                            'label' => esc_html__('Loop', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'option_category' => 'configuration',
                            'options' => [
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off'
                        ],
                        'autoplay_small' => [
                            'label' => esc_html__('Autoplay', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off',
                        ],
                        'continues_small' => [
                            'label' => esc_html__('Continuous Slide', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off',
                            'default_on_front' => 'off',
                            'toggle_slug' => 'carousel',
                            'show_if' => [
                                'loop_small' => 'on',
                                'autoplay_small' => 'on'
                            ]
                        ],
                        'autoplay_reverse_small' => [
                            'label' => esc_html__('Reverse Slide', 'dipi-divi-pixel'),
                            'description' => esc_html__('Reverse the slide direction (Works only in frontend)', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off',
                            'show_if' => [
                                'autoplay_small' => 'on',
                            ],
                        ],
                        'pause_on_hover_small' => [
                            'label' => esc_html__('Pause on Hover', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                            ],
                            'show_if' => [
                                'autoplay_small' => 'on',
                            ]
                        ],
                        'autoplay_speed_small' => [
                            'label' => esc_html__('Autoplay Speed', 'dipi-divi-pixel'),
                            'type' => 'range',
                            'range_settings' => array(
                                'min' => '1',
                                'max' => '10000',
                                'step' => '500',
                            ),
                            'default' => 5000,
                            'validate_unit' => false,
                            'show_if' => array(
                                'autoplay_small' => 'on',
                            )
                        ]
                    ],
                ),
            ),
        ];

        $fields["show_lightbox"] = [
            'label' => esc_html__('Open Image in Lightbox', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'on',
            'options' => array(
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'carousel',
            'description' => esc_html__('Whether or not to show lightbox.', 'dipi-divi-pixel'),
            'mobile_options' => true,
        ];
        $fields["title_in_lightbox"] = [
            'label' => esc_html__('Show Title in Lightbox', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'carousel',
            'description' => esc_html__('Whether or not to show the title in the lightbox. The title is automatically loaded from the media library.', 'dipi-divi-pixel'),
            'show_if' => [
                'show_lightbox' => 'on',
            ],
        ];
        $fields["desc_in_lightbox"] = [
            'label' => esc_html__('Show Description in Lightbox', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'carousel',
            'description' => esc_html__('Whether or not to show the description in the lightbox. The caption is automatically loaded from the media library.', 'dipi-divi-pixel'),
            'show_if' => [
                'show_lightbox' => 'on',
            ],
        ];
        $fields['navigation'] = [
            'label' => esc_html__('Navigation', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'carousel',
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
            'toggle_slug' => 'carousel',
            'show_if' => ['navigation' => 'on'],
            'default' => 'off',
        ];
        $fields['pagination'] = [
            'label' => esc_html__('Pagination', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'carousel',
            'mobile_options' => true,
            'default' => 'off',
        ];

        $fields['dynamic_bullets'] = [
            'label' => esc_html__('Dynamic Bullets', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'carousel',
            'default' => 'on',
        ];

        $fields['centered'] = [
            'label' => esc_html__('Centered', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'default' => 'off',
            'toggle_slug' => 'carousel',
        ];

        $fields['use_thumbnail_height'] = [
            'label' => esc_html__('Set Image Height', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'carousel',
        ];

        $fields['thumbnail_height'] = [
            'label' => esc_html__('Image Height', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '400px',
            'default_unit' => 'px',
            'mobile_options' => true,
            'show_if' => [
                'use_thumbnail_height' => 'on',
            ],
            'range_settings' => [
                'min' => '0',
                'max' => '600',
                'step' => '10',
            ],
            'toggle_slug' => 'carousel',
        ];

        $fields['thumbnail_fit'] = [
            'label' => esc_html__('Image Fit', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'layout',
            'options' => [
                'contain' => 'Contain',
                'cover' => 'Cover',
                'fill' => 'fill',
                'none' => 'none',
                'scale-down' => 'Scale Down',
            ],
            'default' => 'cover',
            'toggle_slug' => 'carousel',
            'mobile_options' => true,
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
            'label' => esc_html('Left Navigation Postion', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '-66px',
            'default_on_front' => '-66px',
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
            'label' => esc_html('Right Navigation Postion', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '-66px',
            'default_on_front' => '-66px',
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

        $fields['pagination_position'] = [
            'label' => esc_html('Pagination Postion', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '-40',
            'range_settings' => [
                'min' => '-200',
                'max' => '200',
                'step' => '1',
            ],
            'unitless' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'pagination',
        ];

        $fields['pagination_color'] = [
            'label' => esc_html('Pagination Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#d8d8d8',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'pagination',
        ];

        $fields['pagination_active_color'] = [
            'label' => esc_html('Pagination Active Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => et_builder_accent_color(),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'pagination',
        ];

        return $fields;
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = [];
        // $advanced_fields['fonts'] = false;
        // $advanced_fields['text'] = false;
        $advanced_fields['text_shadow'] = false;

        $advanced_fields['margin_padding'] = [
            'css' => [
                'margin' => '%%order_class%%',
                'padding' => '%%order_class%%',
                'important' => 'all',
            ],
        ];

        $advanced_fields["fonts"]["title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi_carousel_child .dipi-carousel-item-title",
            ],
            'font_size' => [
                'default' => '22px',
            ],
            'line_height' => [
                'range_settings' => [
                    'default' => '1em',
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ],
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'carousel_text',
            'sub_toggle' => 'title',
        ];

        $advanced_fields["fonts"]["desc"] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi_carousel_child .dipi-carousel-item-desc",
            ],
            'font_size' => [
                'default' => '15px',
            ],
            'line_height' => [
                'range_settings' => [
                    'default' => '1em',
                    'min' => '1',
                    'max' => '3',
                    'step' => '.1',
                ],
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'carousel_text',
            'sub_toggle' => 'desc',
        ];

        $advanced_fields['button']["button"] = [
            'label' => esc_html__('Button', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-carousel-button",
                'alignment' => "%%order_class%% .dipi-carousel-button-wrap",
            ],
            'use_alignment' => false,
            'hide_icon' => true,
            'box_shadow' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-carousel-button",
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-carousel-button",
                    'important' => 'all',
                ],
            ],
        ];

        $advanced_fields["borders"]["default"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%%:not(.ui-sortable)",
                    'border_styles' => "%%order_class%%:not(.ui-sortable)",
                ],
            ],
        ];

        $advanced_fields["borders"]["item"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi_carousel_child.swiper-slide:not(.ui-sortable)",
                    'border_styles' => "%%order_class%% .dipi_carousel_child.swiper-slide:not(.ui-sortable)",
                ],
            ],
            'toggle_slug' => 'carousel_item',
        ];

        $advanced_fields["box_shadow"]["default"] = [
            'css' => [
                'main' => "%%order_class%% .dipi_carousel_child.swiper-slide",
                'hover' => '%%order_class%% .dipi_carousel_child.swiper-slide:hover',
            ],
            'toggle_slug' => 'carousel_item',
        ];

        return $advanced_fields;
    }

    public function get_carousel_content()
    {
        return $this->content;
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
    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_carousel_public');
        wp_enqueue_style('dipi_swiper');
        wp_enqueue_style('magnific-popup');
        
        $this->apply_css($render_slug);

        $get_carousel_content = $this->get_carousel_content();
        $speed_values = et_pb_responsive_options()->get_property_values($this->props, 'speed');
        $speed_desktop = $speed_values['desktop'];
        $speed_tablet = !empty($speed_values['tablet']) ? $speed_values['tablet'] : $speed_desktop;
        $speed_phone = !empty($speed_values['phone']) ? $speed_values['phone'] : $speed_tablet;

        $centered = $this->props['centered'];
        
        $navigation = $this->props['navigation'];
        $navigation_values = et_pb_responsive_options()->get_property_values($this->props, 'navigation');
        $navigation_tablet = !empty($navigation_values['tablet']) ? $navigation_values['tablet'] : $navigation;
        $navigation_phone = !empty($navigation_values['phone']) ? $navigation_values['phone'] : $navigation_tablet;
        $navigation_on_hover = $this->props['navigation_on_hover'];
        $pagination = $this->props['pagination'];
        $pagination_values = et_pb_responsive_options()->get_property_values($this->props, 'pagination');
        $pagination_tablet = !empty($pagination_values['tablet']) ? $pagination_values['tablet'] : $pagination;
        $pagination_phone = !empty($pagination_values['phone']) ? $pagination_values['phone'] : $pagination_tablet;
        $effect = $this->props['effect'];
        $rotate = $this->props['rotate'];
        $dynamic_bullets = $this->props['dynamic_bullets'];
        $order_class = self::get_module_order_class($render_slug);
        $order_number = str_replace('_', '', str_replace($this->slug, '', $order_class));
        $slideShadows = $this->props['slide_shadows'];
        $continues = isset($this->props['continues'])? $this->props['continues']: 'off';

        $data_next_icon = $this->props['navigation_next_icon'];
        $data_prev_icon = $this->props['navigation_prev_icon'];

        $show_lightbox = $this->props['show_lightbox'];
        $show_lightbox_values = et_pb_responsive_options()->get_property_values($this->props, 'show_lightbox');

        $show_lightbox_tablet = isset($show_lightbox_values['tablet']) && !empty($show_lightbox_values['tablet']) ? $show_lightbox_values['tablet'] : $show_lightbox;
        $show_lightbox_phone = isset($show_lightbox_values['phone']) && !empty($show_lightbox_values['phone']) ? $show_lightbox_values['phone'] : $show_lightbox_tablet;

        $show_lightboxclasses = ($show_lightbox === 'on') ? 'show_lightbox' : 'hide_lightbox';
        if (!empty($show_lightbox_tablet)) {
            $show_lightboxclasses .= ($show_lightbox_tablet === 'on') ? ' show_lightbox_tablet' : ' hide_lightbox_tablet';
        }
        if (!empty($show_lightbox_phone)) {
            $show_lightboxclasses .= ($show_lightbox_phone === 'on') ? ' show_lightbox_phone' : ' hide_lightbox_phone';
        }

        $options = [];

        $columns = $this->dipi_get_responsive_prop('columns');
        if ($columns['desktop'] === "4" && $columns['tablet'] === "4" && $columns['phone'] === "4") {
            $columns['tablet'] = "2";
            $columns['phone'] = "1";
        }
        $options['data-columnsdesktop'] = esc_attr($columns['desktop']);
        $options['data-columnstablet'] = esc_attr($columns['tablet']);
        $options['data-columnsphone'] = esc_attr($columns['phone']);

        $space_between = $this->dipi_get_responsive_prop('space_between');
        $options['data-spacebetween'] = esc_attr($space_between['desktop']);
        $options['data-spacebetween_tablet'] = esc_attr($space_between['tablet']);
        $options['data-spacebetween_phone'] = esc_attr($space_between['phone']);
        $options['data-speed'] = esc_attr($speed_desktop.'|'.$speed_tablet.'|'.$speed_phone);
        $options['data-navigation'] = esc_attr($navigation);
        $options['data-navigation_t'] = esc_attr($navigation_tablet);
        $options['data-navigation_m'] = esc_attr($navigation_phone);
        $options['data-pagination'] = esc_attr($pagination);
        $options['data-pagination_t'] = esc_attr($pagination_tablet);
        $options['data-pagination_m'] = esc_attr($pagination_phone);
 
        $autoplay_settigns = [];
        $autoplay_settigns['loop_default'] = 'off';
        $autoplay_settigns['autoplay_default'] = 'off';
        $autoplay_settigns['continues_default'] = 'off';
        $autoplay_settigns['autoplay_reverse_default'] = 'off';
        $autoplay_settigns['pause_on_hover_default'] = 'on';
        $autoplay_settigns['autoplay_speed_default'] = 5000;
        $views = ['wide', 'mid', 'small'];
        $last_view = 'default';

        foreach ($views as $view) {
            $autoplay_settigns['loop_' . $view] = $this->props['loop_' . $view]? $this->props['loop_' . $view] : 'off';
            $autoplay_settigns['autoplay_' . $view] = $this->props['autoplay_' . $view]? $this->props['autoplay_' . $view] : 'off';
            $autoplay_settigns['continues_' . $view] = $this->props['continues_' . $view]? $this->props['continues_' . $view] : 'off';
            $autoplay_settigns['autoplay_reverse_' . $view] = $this->props['autoplay_reverse_' . $view]? $this->props['autoplay_reverse_' . $view] : 'off';
            $autoplay_settigns['pause_on_hover_' . $view] = $this->props['pause_on_hover_' . $view]? $this->props['pause_on_hover_' . $view] : 'off';
            $autoplay_settigns['autoplay_speed_' . $view] = $this->props['autoplay_speed_' . $view]? $this->props['autoplay_speed_' . $view] : '5000';  
            $last_view = $view;
        }
        
        unset($autoplay_settigns['loop_default']);
        unset($autoplay_settigns['autoplay_default']);
        unset($autoplay_settigns['continues_default']);
        unset($autoplay_settigns['autoplay_reverse_default']);
        unset($autoplay_settigns['pause_on_hover_default']);
        unset($autoplay_settigns['autoplay_speed_default']);

        $options['data-autoplay_settigns'] = json_encode($autoplay_settigns);
        $options['data-effect'] = esc_attr($effect);
        $options['data-rotate'] = esc_attr($rotate);
        $options['data-dynamicbullets'] = esc_attr($dynamic_bullets);
        $options['data-ordernumber'] = esc_attr($order_number);
        $options['data-centered'] = esc_attr($centered);
        $options['data-shadow'] = esc_attr($slideShadows);
        $options['data-continues'] = esc_attr($continues);

        $options = implode(
            " ",
            array_map(
                function ($k, $v) {
                    return "{$k}='{$v}'";
                },
                array_keys($options),
                $options
            )
        );

        $next_icon_render = 'data-icon="9"';
        if ('on' === $this->props['navigation_next_icon_yn']) {
            $next_icon_render = sprintf('data-icon="%1$s"', esc_attr(et_pb_process_font_icon($data_next_icon)));
            $this->dipi_generate_font_icon_styles($render_slug, 'navigation_next_icon', '%%order_class%% .swiper-button-next:after');
        }

        $prev_icon_render = 'data-icon="8"';
        if ('on' === $this->props['navigation_prev_icon_yn']) {
            $prev_icon_render = sprintf('data-icon="%1$s"', esc_attr(et_pb_process_font_icon($data_prev_icon)));
            $this->dipi_generate_font_icon_styles($render_slug, 'navigation_prev_icon', '%%order_class%% .swiper-button-prev:after');
        }

        $navigation = sprintf(
            '<div class="swiper-button-next swiper-arrow-button dipi-sbn%1$s %4$s" %2$s></div>
                <div class="swiper-button-prev swiper-arrow-button dipi-sbp%1$s %4$s" %3$s></div>
                ',
            $order_number,
            $next_icon_render,
            $prev_icon_render,
            $navigation_on_hover === "on" ? "show_on_hover" : ""
        );

        $pagination = sprintf(
            '<div class="swiper-pagination dipi-sp%1$s"></div>',
            $order_number
        );
    

        $output = sprintf('
            <div class="dipi-carousel-main dipi_loading %5$s" %2$s style="display:none;">
                <div class="swiper-container">
                    <div class="dipi-carousel-wrapper">
                        %1$s
                    </div>
                </div>
                %3$s
                <div class="swiper-container-horizontal">
                    %4$s
                </div>
            </div>',
            $get_carousel_content,
            $options,
            $navigation,
            $pagination,
            $show_lightboxclasses
        );

        return $output;
    }

    public function apply_css($render_slug)
    {

        $container_class = "%%order_class%% .swiper-container";
        $navigation_position_left_class = "%%order_class%% .swiper-button-prev, %%order_class%%:hover .swiper-button-prev.swiper-arrow-button.show_on_hover";
        $navigation_position_right_class = "%%order_class%% .swiper-button-next, %%order_class%%:hover .swiper-button-next.swiper-arrow-button.show_on_hover";
        $navigation_position_left_area_class = "%%order_class%% .swiper-button-prev.swiper-arrow-button.show_on_hover:before";
        $navigation_position_right_area_class = "%%order_class%% .swiper-button-next.swiper-arrow-button.show_on_hover:before";

        $important = false;

        $container_padding = explode('|', $this->props['container_padding']);
        $container_padding_tablet = explode('|', $this->props['container_padding_tablet']);
        $container_padding_phone = explode('|', $this->props['container_padding_phone']);

        $container_padding_last_edited = $this->props['container_padding_last_edited'];
        $container_padding_responsive_status = et_pb_get_responsive_status($container_padding_last_edited);
        $navigation_hover_selector = '%%order_class%% .swiper-arrow-button:hover:after';
        $navigation_hover_bg_selector = '%%order_class%% .swiper-arrow-button:hover';
        $use_thumbnail_height = $this->props['use_thumbnail_height'];
        if(!isset($this->props['border_style_all_item']) || empty($this->props['border_style_all_item'])) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => "%%order_class%% .dipi_carousel_child",
                'declaration' => "border-style: solid;"
            ]);
        }

        if ('' !== $container_padding) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $container_class,
                'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $container_padding[0], $container_padding[1], $container_padding[2], $container_padding[3]),
            ));
        }

        if(is_array($container_padding_tablet)){
            foreach($container_padding as $key => $value){
                if(!isset($container_padding_tablet[$key])){
                    $container_padding_tablet[$key] = $container_padding[$key];
                }
            }
        }
 
        if ('' !== $container_padding_tablet && $container_padding_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $container_class,
                'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', 
                $container_padding_tablet[0], $container_padding_tablet[1], $container_padding_tablet[2], $container_padding_tablet[3]),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if ('' !== $this->props['container_padding_phone'] && $container_padding_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $container_class,
                'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $container_padding_phone[0], $container_padding_phone[1], $container_padding_phone[2], $container_padding_phone[3]),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        $navigation_position_left = $this->props['navigation_position_left'];
        $navigation_position_left_tablet = $this->props['navigation_position_left_tablet'];
        $navigation_position_left_phone = $this->props['navigation_position_left_phone'];
        $navigation_position_left_last_edited = $this->props['navigation_position_left_last_edited'];
        $navigation_position_left_responsive_status = et_pb_get_responsive_status($navigation_position_left_last_edited);

        if ('' !== $navigation_position_left) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_left_class,
                'declaration' => sprintf('left: %1$s !important;', $navigation_position_left),
            ));
        }

        if ('' !== $navigation_position_left_tablet && $navigation_position_left_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_left_class,
                'declaration' => sprintf('left: %1$s !important;', $navigation_position_left_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if ('' !== $navigation_position_left_phone && $navigation_position_left_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_left_class,
                'declaration' => sprintf('left: %1$s !important;', $navigation_position_left_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        /* Left navigation area */
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

        $navigation_position_right = $this->props['navigation_position_right'];
        $navigation_position_right_tablet = $this->props['navigation_position_right_tablet'];
        $navigation_position_right_phone = $this->props['navigation_position_right_phone'];
        $navigation_position_right_last_edited = $this->props['navigation_position_right_last_edited'];
        $navigation_position_right_responsive_status = et_pb_get_responsive_status($navigation_position_right_last_edited);

        if ('' !== $navigation_position_right) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_right_class,
                'declaration' => sprintf('right: %1$s !important;', $navigation_position_right),
            ));
        }

        if ('' !== $navigation_position_right_tablet && $navigation_position_right_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_right_class,
                'declaration' => sprintf('right: %1$s !important;', $navigation_position_right_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if ('' !== $navigation_position_right_phone && $navigation_position_right_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $navigation_position_right_class,
                'declaration' => sprintf('right: %1$s !important;', $navigation_position_right_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

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

        if ('' !== $this->props['navigation_color']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-button-next:after, %%order_class%% .swiper-button-next:before, %%order_class%% .swiper-button-prev:after, %%order_class%% .swiper-button-prev:before',
                'declaration' => sprintf('color: %1$s!important;', $this->props['navigation_color']),
            ));
        }

        $navigation_class = "%%order_class%%  .swiper-arrow-button";
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

        $pagination_class = "%%order_class%%  .swiper-pagination";
        $pagination = $this->props['pagination'];
        $pagination_tablet = $this->props['pagination_tablet'];
        $pagination_phone = $this->props['pagination_phone'];
        $pagination_last_edited = $this->props['pagination_last_edited'];
        $pagination_responsive_status = et_pb_get_responsive_status($pagination_last_edited);

        if ('' !== $pagination) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $pagination_class,
                'declaration' => sprintf(
                    'display: %1$s !important;', 
                    $pagination === "on" ? "block" : "none"
                ),
            ));
        }

        if ('' !== $pagination_tablet && $pagination_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $pagination_class,
                'declaration' => sprintf(
                    'display: %1$s !important;', 
                    $pagination_tablet === "on" ? "block" : "none"
                ),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if ('' !== $pagination_phone && $pagination_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $pagination_class,
                'declaration' => sprintf(
                    'display: %1$s !important;',
                    $pagination_phone=== "on" ? "block" : "none")
                ,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        $this->apply_custom_style_for_hover(
            $render_slug,
            'navigation_color',
            'color',
            $navigation_hover_selector,
            true
        );
        if ('' !== $this->props['navigation_bg_color']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
                'declaration' => sprintf('background: %1$s!important;', $this->props['navigation_bg_color']),
            ));
        }

        $this->apply_custom_style_for_hover(
            $render_slug,
            'navigation_bg_color',
            'background',
            $navigation_hover_bg_selector,
            true
        );
        $navigation_size = $this->props['navigation_size'];
        $navigation_size_last_edited  = $this->props['navigation_size_last_edited'];
        $navigation_size_responsive_status = et_pb_get_responsive_status($navigation_size_last_edited);

        $navigation_size_tablet = $this->dipi_get_responsive_value(
            'navigation_size_tablet', 
            $navigation_size, 
            $navigation_size_responsive_status
        );

        $navigation_size_phone = $this->dipi_get_responsive_value(
            'navigation_size_phone',
            $navigation_size_tablet,
            $navigation_size_responsive_status
        );
        if( '' !== $this->props['navigation_size'] ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
                'declaration' => sprintf('width: %1$spx !important; height: %1$spx !important;', $navigation_size),
            ) );
        }
        ET_Builder_Element::set_style( $render_slug, array(
            'selector' => '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
            'declaration' => sprintf( 'width: %1$spx !important; height: %1$spx !important;', $navigation_size_tablet),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980' )
        ));

        ET_Builder_Element::set_style( $render_slug, array(
            'selector' => '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
            'declaration' => sprintf( 'width: %1$spx !important; height: %1$spx !important;', $navigation_size_phone),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767' )
        ));
        $this->generate_styles(
            array(
                'base_attr_name' => 'navigation_size',
                'selector' => '%%order_class%% .swiper-button-next:after, %%order_class%% .swiper-button-next:before, %%order_class%% .swiper-button-prev:after, %%order_class%% .swiper-button-prev:before',
                'css_property' => 'font-size',
                'render_slug' => $render_slug,
                'type' => 'range',
                'important' => true
            )
        );

        $this->generate_styles(
            array(
                'base_attr_name' => 'navigation_padding',
                'selector' => '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
                'css_property' => 'padding',
                'render_slug' => $render_slug,
                'type' => 'range',
                'important' => true
            )
        );
        // Height of Image
        if ($use_thumbnail_height === "on") {
            $this->generate_styles(
                array(
                    'base_attr_name' => 'thumbnail_height',
                    'selector' => "%%order_class%% .dipi-carousel-image img",
                    'css_property' => 'height',
                    'render_slug' => $render_slug,
                    'type' => 'range',
                )
            );
            $this->generate_styles(
                array(
                    'base_attr_name' => 'thumbnail_fit',
                    'selector' => "%%order_class%% .dipi-carousel-image img",
                    'css_property' => 'object-fit',
                    'render_slug' => $render_slug,
                    'type' => 'select',
                )
            );
            
        }
        if ('on' == $this->props['navigation_circle']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
                'declaration' => 'border-radius: 50% !important;',
            ));
        }

        if ('' !== $this->props['pagination_color']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-pagination-bullet',
                'declaration' => sprintf(
                    'background: %1$s!important;', $this->props['pagination_color']),
            ));
        }

        if ('' !== $this->props['pagination_active_color']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-pagination-bullet.swiper-pagination-bullet-active',
                'declaration' => sprintf(
                    'background: %1$s!important;', $this->props['pagination_active_color']),
            ));
        }

        if ('' !== $this->props['pagination_position']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .swiper-container-horizontal > .swiper-pagination-bullets, %%order_class%% .swiper-pagination-fraction, %%order_class%% .swiper-pagination-custom',
                'declaration' => sprintf(
                    'bottom: %1$spx !important;',
                    $this->props['pagination_position']),
            ));
        }

        $shadow_overlay_color = $this->props['shadow_overlay_color'];

        if ($this->props['slide_shadows'] == 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-carousel-main .swiper-container-3d .swiper-slide-shadow-left',
                'declaration' => 'background-image: -webkit-gradient(linear, right top, left top, from(' . $shadow_overlay_color . '), to(rgba(0, 0, 0, 0))); background-image: -webkit-linear-gradient(right, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0)); background-image: -o-linear-gradient(right, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0)); background-image: linear-gradient(to left, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0));',
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-carousel-main .swiper-container-3d .swiper-slide-shadow-right',
                'declaration' => 'background-image: -webkit-gradient(linear, left top, right top, from(' . $shadow_overlay_color . '), to(rgba(0, 0, 0, 0))); background-image: -webkit-linear-gradient(left, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0));background-image: -o-linear-gradient(left, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0)); background-image: linear-gradient(to right, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0));',
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-carousel-main .swiper-container-3d .swiper-slide-shadow-top',
                'declaration' => 'background-image: -webkit-gradient(linear, left bottom, left top, from(' . $shadow_overlay_color . '), to(rgba(0, 0, 0, 0))); background-image: -webkit-linear-gradient(bottom, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0)); background-image: -o-linear-gradient(bottom, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0)); background-image: linear-gradient(to top, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0));',
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-carousel-main .swiper-container-3d .swiper-slide-shadow-bottom',
                'declaration' => ' background-image: -webkit-gradient(linear, left top, left bottom, from(' . $shadow_overlay_color . '), to(rgba(0, 0, 0, 0))); background-image: -webkit-linear-gradient(top, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0)); background-image: -o-linear-gradient(top, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0));background-image: linear-gradient(to bottom, ' . $shadow_overlay_color . ', rgba(0, 0, 0, 0));',
            ));
        } else {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-carousel-main .swiper-container-3d .swiper-slide-shadow-left',
                'declaration' => 'background-image: none',
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-carousel-main .swiper-container-3d .swiper-slide-shadow-right',
                'declaration' => 'background-image: none',
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-carousel-main .swiper-container-3d .swiper-slide-shadow-top',
                'declaration' => 'background-image: none',
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-carousel-main .swiper-container-3d .swiper-slide-shadow-bottom',
                'declaration' => 'background-image: none',
            ));
        }
        $continues_wide = isset($this->props['continues_wide']) ? $this->props['continues_wide'] : 'off';
        $continues_mid = isset($this->props['continues_mid']) ? $this->props['continues_mid'] : $continues_wide;
        $continues_small = isset($this->props['continues_small']) ? $this->props['continues_small'] : $continues_mid;

        if($continues_wide === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-carousel-wrapper',
                'declaration' => 'transition-timing-function : linear;'
            ));
        }
        if($continues_mid === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-carousel-wrapper',
                'declaration' => 'transition-timing-function : linear;',
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
        }
        if($continues_small === 'on') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-carousel-wrapper',
                'declaration' => 'transition-timing-function : linear;',
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }
    }
}

new DIPI_Carousel;
