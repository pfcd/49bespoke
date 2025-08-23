<?php
class DIPI_HoverGallery extends DIPI_Builder_Module {

	protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/price-list',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

	function init() {
		$this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
		$this->name = esc_html__( 'Pixel Hover Gallery', 'et_builder' );
		$this->slug = 'dipi_hover_gallery';
		$this->fb_support = true;
		$this->vb_support = 'on';
		$this->child_slug      = 'dipi_hover_gallery_item';
		$this->child_item_text = esc_html__( 'Pixel Hover Grid Item', 'et_builder' );
        /**
		 * Filter generated module selector
		 *
		 * @param string $selector Generated selector.
		 * @param string $module   Module name.
		 *
		 * @return string Custom selector.
		 */
		add_filter( 'et_pb_set_style_selector', function ( $selector, $module ) {
			// Bail early if current module is not Hover Gallery.
            
			if ( 'dipi_hover_gallery' !== $module && 'dipi_hover_gallery_item' !== $module ) {
				return $selector;
			}
            $new_selector =
                str_replace('.et-db ', '',
                    str_replace(
                        '#et-boc .et-l ', '',
                        str_replace( 
                            '.et-db #et-boc .et-l ', '', 
                            str_replace( 'body #page-container ', '', $selector ) 
                        )
                    )
                );
            return ".et-db #et-boc .et-l ". str_replace(
                ',', ', .et-db #et-boc .et-l ',
                $new_selector). ", $new_selector";
        }, 10, 2 ); 
	}

    public function get_custom_css_fields_config() {
        $custom_css_fields = [];
        $custom_css_fields['active_image'] = [
            'label' => esc_html__('Active Image', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-hg__images .dipi-hg-image.active div',
        ];

		return $custom_css_fields;
    }
	public function get_settings_modal_toggles()
    {
        return [
            'general' => [
                'toggles' => [
                    'content' => esc_html__('Content', 'dipi-divi-pixel'),
                    'settings' => esc_html__('Grid Settings', 'dipi-divi-pixel')
                ],
            ],
			'advanced' => [
				'toggles' => [
					
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
                        'title' => esc_html__('Content Text', 'dipi-divi-pixel')
                    ],
					'content_text_active' => [
                        'sub_toggles' => [
                            'title' => [
                                'name' => 'Title',
                            ],
                            'desc' => [
                                'name' => 'Description',
                            ],
                        ],
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__('Content Text Active', 'dipi-divi-pixel'),
                         
                    ],
					'content_icon_image' => esc_html__('Content Image & Icon', 'dipi-divi-pixel'),
					'content_icon_image_active' => esc_html__('Content Image & Icon Active', 'dipi-divi-pixel'),
					'item_style' => esc_html__('Item Style', 'dipi-divi-pixel'),
					'active_style' => esc_html__('Active Item Style', 'dipi-divi-pixel')
				],
			],
		];
	}
		 
	
	function get_advanced_fields_config() {
		// disable text settings
		$advanced_fields = [];
		$advanced_fields['text'] = false;
		$advanced_fields['height'] = [
            'use_height' => true,
			
			'css' => [
                'main' => "%%order_class%%, %%order_class%%>.et_pb_module_inner",
                'important' => true,
            ],
            'options' => [
                'height' => [
                    'default' => '800px',
                ],
            ],
        ];

		$advanced_fields['button']["content_button"] = [
            'label' => esc_html__('Button', 'dipi-divi-pixel'),
            'use_alignment' => false,
			
            'font_size' => array(
              'default' => '14px',
           ),
            'css' => [
                'main' => "%%order_class%% .dipi_hover_gallery_item .dipi-hg-button.et_pb_button",
                'important' => true,
            ],
            'box_shadow'  => [
                'css' => [
                    'main' => "%%order_class%% .dipi_hover_gallery_item .dipi-hg-button.et_pb_button",
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'margin' => "%%order_class%% .dipi_hover_gallery_item .dipi-hg-button.et_pb_button",
                    'padding' => "%%order_class%% .dipi_hover_gallery_item .dipi-hg-button.et_pb_button",
                    'important' => 'all'
                ],
            ],
        ];

		$advanced_fields['button']["content_button_active"] = [
            'label' => esc_html__('Active Button', 'dipi-divi-pixel'),
            'use_alignment' => false,
			
            'font_size' => array(
              'default' => '14px',
           ),
            'css' => [
                'main' => "%%order_class%% .dipi_hover_gallery_item.active .dipi-hg-button.et_pb_button",
                'important' => true,
            ],
            'box_shadow'  => [
                'css' => [
                    'main' => "%%order_class%% .dipi_hover_gallery_item.active .dipi-hg-button.et_pb_button",
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'margin' => "%%order_class%% .dipi_hover_gallery_item.active .dipi-hg-button.et_pb_button",
                    'padding' => "%%order_class%% .dipi_hover_gallery_item.active .dipi-hg-button.et_pb_button",
                    'important' => 'all'
                ],
            ],
        ];


		$advanced_fields['background'] = [
			'options' => [
				'background_color' => [
					'default' => '#eee',
				]
			],
		];

		$advanced_fields["fonts"]["content_title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi_hover_gallery_item  .dipi-hg-title",
            ],
            'important' => 'all',
            'hide_text_align' => false,
            'toggle_slug' => 'content_text',
            'sub_toggle' => 'title',
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
                'main' => "%%order_class%% .dipi_hover_gallery_item .dipi-hg__item__content",
            ],
            'important' => 'all',
            'hide_text_align' => false,
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
        $advanced_fields["fonts"]["content_title_active"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi_hover_gallery_item.active .dipi-hg-title",
            ],
            'important' => 'all',
            'hide_text_align' => false,
            'toggle_slug' => 'content_text_active',
            'sub_toggle' => 'title',
            'line_height' => [
                'range_settings' => [
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ],
            ],
        ];
		$advanced_fields["fonts"]["content_desc_active"] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi_hover_gallery_item.active .dipi-hg__item__content",
            ],
            'important' => 'all',
            'hide_text_align' => false,
            'toggle_slug' => 'content_text_active',
            'sub_toggle' => 'desc',
            'line_height' => [
                'range_settings' => [
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ],
            ],
        ];

		$advanced_fields['borders']['default'] =  [];

		$advanced_fields['borders']['item'] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi_hover_gallery_item",
                    'border_styles' => "%%order_class%% .dipi_hover_gallery_item",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'item_style'
        ];
		$advanced_fields['borders']['active_item'] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi_hover_gallery_item.active",
                    'border_styles' => "%%order_class%% .dipi_hover_gallery_item.active",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'active_style'
        ];


		$advanced_fields['borders']['content_image'] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi_hover_gallery_item .dipi-image-wrap img, %%order_class%% .dipi_hover_gallery_item .dipi-icon-wrap .dipi-hover-box-content-icon",
                    'border_styles' => "%%order_class%% .dipi_hover_gallery_item .dipi-image-wrap img, %%order_class%% .dipi_hover_gallery_item .dipi-icon-wrap .dipi-hover-box-content-icon",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image'
        ];
		$advanced_fields['borders']['content_image_active'] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi_hover_gallery_item.active .dipi-image-wrap img, %%order_class%% .dipi_hover_gallery_item.active .dipi-icon-wrap .dipi-hover-box-content-icon",
                    'border_styles' => "%%order_class%% .dipi_hover_gallery_item.active .dipi-image-wrap img, %%order_class%% .dipi_hover_gallery_item.active .dipi-icon-wrap .dipi-hover-box-content-icon",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image_active',
			'show_if' => ['use_icon_active_style' => 'on'],
            'depends_show_if' => 'on',
            'depends_on' => ['use_icon_active_style'],
        ];
	 
		$advanced_fields['box_shadow']['default'] = [];

		$advanced_fields['box_shadow']['item'] = array(
			'css' => array(
				'main' => "%%order_class%% .dipi_hover_gallery_item",
				'hover' => "%%order_class%% .dipi_hover_gallery_item:hover",
			),
			'tab_slug'    => 'advanced',
			'toggle_slug' => 'item_style',
			'sub_toggle'  => 'normal' 
				
		);
		$advanced_fields['box_shadow']['active_item'] = array(
			'css' => array(
				'main' => "%%order_class%% .dipi_hover_gallery_item.active",
				'hover' => "%%order_class%% .dipi_hover_gallery_item.active:hover",
			),
			'tab_slug'    => 'advanced',
			'toggle_slug' => 'active_style',
			'sub_toggle'  => 'normal' 
				
		);
		$advanced_fields['box_shadow']['content_image'] = [
            'label' => esc_html__('Image Box Shadow', 'dipi-divi-pixel'),
             
            'css' => [
                'main' => '%%order_class%% .dipi_hover_gallery_item .dipi-image-wrap img, %%order_class%% .dipi_hover_gallery_item .dipi-icon-wrap .dipi-hover-box-content-icon',
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image',
        ];
        $advanced_fields['box_shadow']['content_image_active'] = [
            'label' => esc_html__('Image Box Shadow', 'dipi-divi-pixel'),
        
            'css' => [
                'main' => '%%order_class%% .dipi_hover_gallery_item.active .dipi-image-wrap img, %%order_class%% .dipi_hover_gallery_item.active .dipi-icon-wrap .dipi-hover-box-content-icon',
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image_active',
			'show_if' => ['use_icon_active_style' => 'on'],
            'depends_show_if' => 'on',
            'depends_on' => ['use_icon_active_style'],
        ];


		return $advanced_fields;
	}


	function get_fields() {
		$fields = [];

		$fields['use_icon_active_style'] = [
            'label' => esc_html__('Enable Active Icon/Image Style', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'content_icon_image_active',
            'tab_slug' => 'advanced',
        ];

		$fields['icon_image_padding'] = [
            'label' => esc_html__('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '10px|10px|10px|10px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'content_icon_image',
            'tab_slug'          => 'advanced'
        ];
        $fields['icon_image_margin'] = [
            'label' => esc_html__('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'content_icon_image',
            'tab_slug'          => 'advanced'
        ];

        $fields['icon_image_padding_active'] = [
            'label' => esc_html__('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '10px|10px|10px|10px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'content_icon_image_active',
            'tab_slug'          => 'advanced',
			'show_if' => [
				'use_icon_active_style' => 'on'
			]
        ];
        $fields['icon_image_margin_active'] = [
            'label' => esc_html__('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'content_icon_image_active',
            'tab_slug'          => 'advanced',
			'show_if' => [
				'use_icon_active_style' => 'on'
			]
        ];
		$fields["content_icon_color"] = [
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#7EBEC5',
            
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image',
        ];
        $fields["content_circle_color"] = [
            'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            
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
            
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image',
        ];

        $fields["content_icon_color_active"] = [
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#7EBEC5',
            
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image_active',
			'show_if' => ['use_icon_active_style' => 'on']
        ];
        $fields["content_circle_color_active"] = [
            'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image_active',
			'show_if' => ['use_icon_active_style' => 'on']
        ];
        $fields["content_icon_size_active"] = [
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
            
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image_active',
			'show_if' => ['use_icon_active_style' => 'on']
        ];

		

		$fields = $this->dipi_add_bg_field($fields, [ // content_container {old name}
            'name' => 'active_item',
            'label' => esc_html__('Card', 'dipi-divi-pixel'),
            'toggle_slug'           => 'active_style',
			'default' => '#ffffff',
            'tab_slug'              => 'advanced',
			'has_image' => true
        ]);
		$fields = $this->dipi_add_bg_field($fields, [ // content_container {old name}
            'name' => 'item',
            'label' => esc_html__('Card', 'dipi-divi-pixel'),
            'toggle_slug' => 'item_style',
			'default'  => 'rgba(255,255,255,0.7)',
            'tab_slug' => 'advanced',
			'has_image' => true
        ]);

		// range field for number of columns
		$fields['columns'] = [
			'label' => esc_html__('Columns', 'dipi-divi-pixel'),
			'type' => 'range',
			'option_category' => 'basic_option',
			'toggle_slug' => 'settings',
			'default' => '3',
			'default_unit' => '',
			'responsive'             => true,
            'mobile_options'         => true,
			'range_settings' => [
				'min' => '1',
				'max' => '6',
				'step' => '1',
			],
			'description' => esc_html__('Define the number of columns', 'dipi-divi-pixel'),
		];

		// range field grid gap
		$fields['grid_gap'] = [
			'label' => esc_html__('Grid Gap', 'dipi-divi-pixel'),
			'type' => 'range',
			'option_category' => 'basic_option',
			'toggle_slug' => 'settings',
			'default' => '20',
			'default_unit' => 'px',
			'responsive'             => true,
            'mobile_options'         => true,
			'range_settings' => [
				'min' => '0',
				'max' => '100',
				'step' => '1',
			],
			'description' => esc_html__('Define the grid gap', 'dipi-divi-pixel'),
		];

		// range field grid width in presentage default 80%
		$fields['grid_width'] = [
			'label' => esc_html__('Grid Width', 'dipi-divi-pixel'),
			'type' => 'range',
			'option_category' => 'basic_option',
			'toggle_slug' => 'settings',
			'default' => '80',
			'default_unit' => '%',
			'responsive'             => true,
            'mobile_options'         => true,
			'range_settings' => [
				'min' => '0',
				'max' => '100',
				'step' => '1',
			],
			'description' => esc_html__('Define the grid width in percentage', 'dipi-divi-pixel'),
		];

		// yes/no field for grid full height
		$fields['grid_full_height'] = [
			'label' => esc_html__('Grid Full Height', 'dipi-divi-pixel'),
			'type' => 'yes_no_button',
			'option_category' => 'basic_option',
			'toggle_slug' => 'settings',
			'default' => 'off',
			'responsive'             => true,
            'mobile_options'         => true,
			'options' => [
				'off' => esc_html__('No', 'dipi-divi-pixel'),
				'on' => esc_html__('Yes', 'dipi-divi-pixel'),
			],
			'description' => esc_html__('Define if the grid should be full height', 'dipi-divi-pixel'),
		];

		$fields['activate_on_click'] = [
			'label' => esc_html__('Activate on click', 'dipi-divi-pixel'),
			'type' => 'yes_no_button',
			'option_category' => 'basic_option',
			'toggle_slug' => 'settings',
			'default' => 'off',
			'options' => [
				'off' => esc_html__('No', 'dipi-divi-pixel'),
				'on' => esc_html__('Yes', 'dipi-divi-pixel'),
			],
			'description' => esc_html__('Define if the item activated by click.', 'dipi-divi-pixel'),
		];


		// select field grid alignment (topleft, topcenter, topright, centerleft, center, centerright, bottomleft, bottomcenter, bottomright)
		$fields['grid_alignment'] = [
			'label' => esc_html__('Grid Alignment', 'dipi-divi-pixel'),
			'type' => 'select',
			'option_category' => 'basic_option',
			'toggle_slug' => 'settings',
			'default' => 'center-center',
			'responsive'             => true,
            'mobile_options'         => true,
			'options' => [
				'top-left' => esc_html__('Top Left', 'dipi-divi-pixel'),
				'top-center' => esc_html__('Top Center', 'dipi-divi-pixel'),
				'top-right' => esc_html__('Top Right', 'dipi-divi-pixel'),
				'center-left' => esc_html__('Center Left', 'dipi-divi-pixel'),
				'center-center' => esc_html__('Center', 'dipi-divi-pixel'),
				'center-right' => esc_html__('Center Right', 'dipi-divi-pixel'),
				'bottom-left' => esc_html__('Bottom Left', 'dipi-divi-pixel'),
				'bottom-center' => esc_html__('Bottom Center', 'dipi-divi-pixel'),
				'bottom-right' => esc_html__('Bottom Right', 'dipi-divi-pixel'),
			],
			'description' => esc_html__('Define the grid alignment', 'dipi-divi-pixel'),
		];
		$fields['gallery_animation'] = [
			'label' => esc_html__('Gallery Animation', 'dipi-divi-pixel'),
			'type' => 'select',
			'option_category' => 'basic_option',
			'toggle_slug' => 'settings',
			'default' => 'FadeIn',
			'options' => [
				'FadeIn' => esc_html__('FadeIn', 'dipi-divi-pixel'),
				'FadeUp' => esc_html__('FadeUp', 'dipi-divi-pixel'),
				'FadeDown' => esc_html__('FadeDown', 'dipi-divi-pixel'),
				'FadeRight' => esc_html__('FadeRight', 'dipi-divi-pixel'),
				'FadeLeft' => esc_html__('FadeLeft', 'dipi-divi-pixel'),
				'ZoomIn' => esc_html__('ZoomIn', 'dipi-divi-pixel'),
				'ZoomInZoomOut' => esc_html__('ZoomInZoomOut', 'dipi-divi-pixel'),
				'SliceAnim' => esc_html__('Slice', 'dipi-divi-pixel'),
			],
			'description' => esc_html__('Define the gallery image animation', 'dipi-divi-pixel'),
		];

		// animation speed
		$fields['animation_speed'] = [
			'label' => esc_html__('Animation Speed', 'dipi-divi-pixel'),
			'type' => 'range',
			'option_category' => 'basic_option',
			'toggle_slug' => 'settings',
			'default' => '1.5',
			'default_unit' => 's',
			'responsive'             => true,
			'mobile_options'         => true,
			'range_settings' => [
				'min' => '0',
				'max' => '5',
				'step' => '0.1',
			],
			'description' => esc_html__('Define the animation speed', 'dipi-divi-pixel'),
		];
        // yes_no toggle for autoplay
        $fields['autoplay'] = [
            'label' => esc_html__('Autoplay', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'toggle_slug' => 'settings',
            'default' => 'off',
            'responsive'             => true,
            'mobile_options'         => true,
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'description' => esc_html__('Define if the gallery should autoplay', 'dipi-divi-pixel'),
        ];
		$fields['autoplay_speed'] = [
			'label' => esc_html__('Autoplay Speed', 'dipi-divi-pixel'),
			'type' => 'range',
			'option_category' => 'basic_option',
			'toggle_slug' => 'settings',
			'default' => '3',
			'default_unit' => 's',
			'responsive'             => true,
			'mobile_options'         => true,
			'range_settings' => [
				'min' => '0',
				'max' => '10',
				'step' => '0.1',
			],
			'show_if' => [
                'autoplay' => 'on',
            ],
		];

		$fields['grid_padding'] = [
            'label' => esc_html__('Grid Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'margin_padding',
            'tab_slug'          => 'advanced',
        ];

		return $fields;
	}

	public function before_render() {
        global $dipi_hg_items;
        $dipi_hg_items = [];
    }

	private function alignmentToStyleValues($alignment) {
		// center-center
		$alignment_map = [
			'center'=>'center',
			'left'=>'flex-start',
			'right'=>'flex-end',
			'top'=>'flex-start',
			'bottom'=>'flex-end'
		];

		$alignments = explode('-', $alignment); 
		return [
			'align-items' => $alignment_map[$alignments[0]],
			'justify-content' => $alignment_map[$alignments[1]]
		];
	}

	private function alignmentToStyle($alignment) {
		$alignments = $this->alignmentToStyleValues($alignment); 
		return sprintf("align-items: %s; justify-content: %s;", $alignments['align-items'], $alignments['justify-content']);
	}

	public function _apply_css($render_slug) {
		$columns = $this->dipi_get_responsive_prop('columns', 3);
		$content_icon_size_active = isset($this->props['content_icon_size_active']) && !empty($this->props['content_icon_size_active']) ? $this->props['content_icon_size_active'] : '40px';

		$this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'icon_image_padding',
            'css_property'   => 'padding',
            'selector'       => "%%order_class%% .dipi_hover_gallery_item .dipi-image-wrap img, %%order_class%% .dipi_hover_gallery_item .dipi-icon-wrap .dipi-hover-box-content-icon"
        ]);
        
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'icon_image_margin',
            'css_property'   => 'margin',
            'selector'       => "%%order_class%% .dipi_hover_gallery_item .dipi-image-wrap img, %%order_class%% .dipi_hover_gallery_item .dipi-icon-wrap .dipi-hover-box-content-icon"
        ]);
		$content_icon_color = $this->props['content_icon_color'];
        $content_circle_color = $this->props['content_circle_color'];
        $content_icon_size = $this->props['content_icon_size'];
		
       
		ET_Builder_Element::set_style($render_slug, [
			'selector' => '%%order_class%% .dipi_hover_gallery_item .dipi-hover-box-content-icon',
			'declaration' => "color: {$content_icon_color} !important;",
		]);
		ET_Builder_Element::set_style($render_slug, [
			'selector' => '%%order_class%% .dipi_hover_gallery_item .dipi-hover-box-content-icon',
			'declaration' => "background-color: {$content_circle_color} !important;",
		]);
		ET_Builder_Element::set_style($render_slug, [
			'selector' => '%%order_class%% .dipi_hover_gallery_item .dipi-hover-box-content-icon',
			'declaration' => "font-size: {$content_icon_size_active} !important;",
		]);

		if($this->props["use_icon_active_style"] === "on") {

			 $this->dipi_process_spacing_field([
				'render_slug'    => $render_slug,
				'slug'           => 'icon_image_padding_active',
				'css_property'   => 'padding',
				'selector'       => "%%order_class%% .dipi_hover_gallery_item.active .dipi-image-wrap img, %%order_class%% .dipi_hover_gallery_item.active .dipi-icon-wrap .dipi-hover-box-content-icon"
			]);
			$this->dipi_process_spacing_field([
				'render_slug'    => $render_slug,
				'slug'           => 'icon_image_margin_active',
				'css_property'   => 'margin',
				'selector'       => "%%order_class%% .dipi_hover_gallery_item.active .dipi-image-wrap img, %%order_class%% .dipi_hover_gallery_item.active .dipi-icon-wrap .dipi-hover-box-content-icon"
			]);

			$content_icon_color_active = $this->props['content_icon_color_active'];
			$content_circle_color_active = $this->props['content_circle_color_active'];
            
            

			ET_Builder_Element::set_style($render_slug, [
				'selector' => '%%order_class%% .dipi_hover_gallery_item.active .dipi-hover-box-content-icon',
				'declaration' => "color: {$content_icon_color_active} !important;",
			]);
			ET_Builder_Element::set_style($render_slug, [
				'selector' => '%%order_class%% .dipi_hover_gallery_item.active .dipi-hover-box-content-icon',
				'declaration' => "background-color: {$content_circle_color_active} !important;",
			]);
			ET_Builder_Element::set_style($render_slug, [
				'selector' => '%%order_class%% .dipi_hover_gallery_item.active .dipi-hover-box-content-icon',
				'declaration' => "font-size: {$content_icon_size_active} !important;",
			]);
		}

       


		
		

		$this->set_background_css(
            $render_slug,
            '%%order_class%% .dipi_hover_gallery_item.active',
            '%%order_class%% .dipi_hover_gallery_item.active:hover',
            'active_item_bg',
            'active_item_bg_color'
        );
		$this->set_background_css(
            $render_slug,
            '%%order_class%% .dipi_hover_gallery_item',
            '%%order_class%% .dipi_hover_gallery_item:hover',
            'item_bg',
            'item_bg_color'
        );

		$this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'grid_padding',
            'css_property'   => 'padding',
            'selector'       => '%%order_class%% .dipi-hg__items',
            'hover_selector' => '%%order_class%% .dipi-hg__items:hover'
        ]);

		// required for default height
		$this->generate_styles(
            array(
                'base_attr_name' => 'height',
                'selector'       => "%%order_class%%",
                'css_property'   => 'height',
                'render_slug'    => $render_slug,
                'type'           => 'range'
            )
        );
	 
		ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hg__items',
            'declaration' =>   sprintf( 'grid-template-columns: repeat(%1$s, 1fr);', $columns['desktop'])
        ]);
		ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hg__items',
			'declaration' =>   sprintf( 'grid-template-columns: repeat(%1$s, 1fr);', $columns['tablet']),
			'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ]);

		ET_Builder_Element::set_style($render_slug, [
			'selector' => '%%order_class%% .dipi-hg__items',
			'declaration' =>   sprintf( 'grid-template-columns: repeat(%1$s, 1fr);', $columns['phone']),
			'media_query' => ET_Builder_Element::get_media_query('max_width_767')
		]);

		$grid_alignment = $this->dipi_get_responsive_prop('grid_alignment', 'center-center');
		$this->process_range_field_css( array(
			'render_slug'       => $render_slug,
			'slug'              => 'grid_gap',
			'type'              => 'grid-column-gap',
			'selector'          => '%%order_class%% .dipi-hover-gallery .dipi-hg__items',
			'important'         => false
		) );
		$this->process_range_field_css( array(
			'render_slug'       => $render_slug,
			'slug'              => 'grid_gap',
			'type'              => 'grid-row-gap',
			'selector'          => '%%order_class%% .dipi-hover-gallery .dipi-hg__items',
			'important'         => false
		) );
		$this->process_range_field_css( array(
			'render_slug'       => $render_slug,
			'slug'              => 'grid_width',
			'type'              => 'width',
			'selector'          => '%%order_class%% .dipi-hover-gallery .dipi-hg__items',
			'important'         => false
		) );
		 
		$grid_full_height = $this->dipi_get_responsive_prop('grid_full_height', 'off');
		ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hover-gallery',
            'declaration' =>  ($grid_full_height['desktop'] === 'on') ? 'align-items: stretch !important;' :  'align-items: ' . $this->alignmentToStyleValues($grid_alignment['desktop'])['align-items'] . ' !important;'
        ]);
		ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hover-gallery',
            'declaration' => ($grid_full_height['tablet'] === 'on') ? 'align-items: stretch !important;' : 'align-items: ' .$this->alignmentToStyleValues($grid_alignment['tablet'])['align-items'] . ' !important;',
			'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
		]);
       
		ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hover-gallery',
            'declaration' => ($grid_full_height['phone'] === 'on') ? 'align-items: stretch !important;' : 'align-items: ' .$this->alignmentToStyleValues($grid_alignment['phone'])['align-items'] . ' !important;',
			'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);


		ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hover-gallery',
            'declaration' => $this->alignmentToStyle($grid_alignment['desktop'] )
        ]);
		ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hover-gallery',
            'declaration' => $this->alignmentToStyle($grid_alignment['tablet'] ),
			'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
		]);
       
		ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hover-gallery',
            'declaration' => $this->alignmentToStyle($grid_alignment['phone'] ),
			'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);
	}
    // 

	public function render_images(){
		global $dipi_hg_items;
		$images = '';
		$index = 1;
		$gallery_animation = (isset($this->props['gallery_animation']) && !empty($this->props['gallery_animation'])) ? $this->props['gallery_animation'] : "FadeIn";

        
            
		foreach($dipi_hg_items as $classname => $item){

			$modulename = ($index === 1) ? 'dipi-hg-image active': 'dipi-hg-image';
            $imageHtml = sprintf('<div style="background-image: url(%1$s);"></div>', esc_url($item['image']));
            if($gallery_animation === 'SliceAnim'){
                $imageHtml = sprintf(' <div class="dipi-hg-slice-clones">
                <div class="dipi-hg-slice" >
                    <img src="%1$s"  />
                </div>
                <div class="dipi-hg-slice"  >
                    <img src="%1$s"/>
                </div>
                <div class="dipi-hg-slice" >
                    <img src="%1$s"/>
                </div>
                <div class="dipi-hg-slice" >
                    <img src="%1$s"  />
                </div>
                <div class="dipi-hg-slice" >
                    <img src="%1$s"  />
                </div>
                
            </div>', esc_url($item['image']));
            }
			 $images .= sprintf(
				'<div class="%4$s dipi-hg-%5$s" data-item="%1$s">
					%2$s
				</div>',
				esc_attr($classname),
				$imageHtml ,
				esc_attr($item['image_alt']),
				esc_attr($modulename),
				$gallery_animation
				
				
			);
			$index++;
		}
		return $images;
	}

	public function render($attrs, $content, $render_slug) {
		wp_enqueue_script('dipi_hover_gallery');
		$this->_apply_css($render_slug);
        $gallery_animation = (isset($this->props['gallery_animation']) && !empty($this->props['gallery_animation'])) ? $this->props['gallery_animation'] : "FadeIn";
		$activate_on_click = $this->props['activate_on_click'] === 'on' ? 'data-activate-on-click="on"': ''	 ;
		$animation_speed = (isset($this->props['animation_speed']) && $this->props['animation_speed'] !== '') ? $this->props['animation_speed'] : 1.5;
		
        $autoplay = $this->props['autoplay'] === 'on' ? 'data-autoplay="on"': 'data-autoplay="off"';
        $autoplay_speed = (isset($this->props['autoplay_speed']) && $this->props['autoplay_speed'] !== '') ? $this->props['autoplay_speed'] : 3;

		$output = sprintf(
			'<div class="dipi-hover-gallery" data-animation="%5$s" data-animation-speed="%3$s" style="--dipi-hg-animation-speed: %3$ss;" %4$s %6$s data-autoplay-speed="%7$s" >
				<div class="dipi-hg__images">
					%1$s
				</div>
				<div class="dipi-hg__items">
					%2$s
				</div>
			</div>',
			$this->render_images(),
			et_core_sanitized_previously($this->content),
			floatval($animation_speed),
			$activate_on_click,
            $gallery_animation,
            $autoplay,
            $autoplay_speed
		);

		return $output;
	}

}
new DIPI_HoverGallery;