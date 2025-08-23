<?php

class DIPI_HoverGalleryItem extends DIPI_Builder_Module {

	protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/price-list',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

	function init() {
		$this->name = esc_html__( 'Pixel Hover Grid Item', 'et_builder' );
		$this->slug = 'dipi_hover_gallery_item';
		$this->fb_support = true;
		$this->vb_support = 'on';
		$this->type = 'child';
        $this->child_title_var = 'admin_label';
		$this->child_item_text = esc_html__( 'Pixel Hover Grid Item', 'et_builder' );
        add_filter('et_fb_backend_helpers', [$this, 'default_helpers'], 100, 1);
	}

    public function default_helpers ($helpers) {
		$helpers['defaults']['dipi_hover_gallery_item'] = [
			'image' => ET_BUILDER_PLACEHOLDER_LANDSCAPE_IMAGE_DATA
		];
		return $helpers;
	}

	public function get_custom_css_fields_config() {

		$custom_css_fields = [];

		$custom_css_fields['content_title'] = [
			'label' => esc_html__('Title', 'dipi-divi-pixel'),
			'selector' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-hg-title',
		];
		$custom_css_fields['content_desc'] = [
			'label' => esc_html__('Description', 'dipi-divi-pixel'),
			'selector' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-hg__item__content',
		];
		$custom_css_fields['content_button'] = [
			'label' => esc_html__('Button', 'dipi-divi-pixel'),
			'selector' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-hg-button.et_pb_button',
		];
		$custom_css_fields['content_image_icon'] = [
            'label' => esc_html__('Image/Icon container', 'dipi-divi-pixel'),
            'selector' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-content-image-icon-wrap',
        ];
		$custom_css_fields['thumbe_image'] = [
            'label' => esc_html__('Thumbnail Image', 'dipi-divi-pixel'),
            'selector' => '.dipi_hover_gallery %%order_class%% .dipi-content-image-icon-wrap.dipi-image-wrap img',
        ];
		$custom_css_fields['active_thumbe_image'] = [
            'label' => esc_html__('Active Thumbnail Image', 'dipi-divi-pixel'),
            'selector' => '.dipi_hover_gallery %%order_class%%.active .dipi-content-image-icon-wrap.dipi-image-wrap img',
        ]; 
		$custom_css_fields['thumbe_icon'] = [
            'label' => esc_html__('Thumbnail Icon', 'dipi-divi-pixel'),
            'selector' => '.dipi_hover_gallery %%order_class%% .dipi-content-image-icon-wrap.dipi-icon-wrap .et-pb-icon',
        ]; 
		$custom_css_fields['active_thumbe_icon'] = [
            'label' => esc_html__('Active Thumbnail Icon', 'dipi-divi-pixel'),
            'selector' => '.dipi_hover_gallery %%order_class%%.active .dipi-content-image-icon-wrap.dipi-icon-wrap .et-pb-icon',
        ]; 

		return $custom_css_fields;
	}

	public function get_settings_modal_toggles() {
        return [
            'general' => [
                'toggles' => [
                    'image' => esc_html__('Image', 'dipi-divi-pixel'),
                    'content' => esc_html__('Content', 'dipi-divi-pixel'),
                    'alignment' => esc_html__('Alignment', 'dipi-divi-pixel')
                ],
            ],
			'advanced' => [
				'toggles' => [
					'content_text_tab' => [
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
					'item_style_active' => esc_html__('Item Style Active', 'dipi-divi-pixel')
                ]
			]
		];
    }

	public function get_advanced_fields_config() {
		
		$advanced_fields = [];
		$advanced_fields['text'] = [
            'css' => [
                'main' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item",
                'important' => 'all',
            ]
        ];


		$advanced_fields['button']["content_button"] = [
            'label' => esc_html__('Button', 'dipi-divi-pixel'),
            'use_alignment' => false,
			
            'font_size' => array(
              'default' => '14px',
           ),
            'css' => [
                'main' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-hg-button.et_pb_button",
                'important' => true,
            ],
            'box_shadow'  => [
                'css' => [
                    'main' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-hg-button.et_pb_button",
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'margin' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-hg-button.et_pb_button",
                    'padding' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-hg-button.et_pb_button",
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
                'main' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active .dipi-hg-button.et_pb_button",
                'important' => true,
            ],
            'box_shadow'  => [
                'css' => [
                    'main' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active .dipi-hg-button.et_pb_button",
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'margin' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active .dipi-hg-button.et_pb_button",
                    'padding' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active .dipi-hg-button.et_pb_button",
                    'important' => 'all'
                ],
            ],
        ];
        
        $advanced_fields["fonts"] = [];
        $advanced_fields["fonts"]["content_title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item  .dipi-hg-title",
            ],
            'important' => 'all',
            'hide_text_align' => false,
            'toggle_slug' => 'content_text_tab',
            'sub_toggle' => 'title',
            'tab_slug' => 'advanced',
            'header_level' => [
                'default' => 'h2'
            ],
            'line_height' => [
                'range_settings' => [
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ],
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_text_style']
            ],
            'font' => [
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_text_style']
            ],
            'text_color' => [
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_text_style']
            ],
            'font_size' => [
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_text_style']
            ],
            'letter_spacing' => [
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_text_style']
            ],
            'text_align' => [
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_text_style']
            ],
            'text_shadow' => [
                'show_if' => [
                    'use_content_text_style' => 'on',
                ],
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_text_style']
            ]
        ];
		$advanced_fields["fonts"]["content_desc"] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'css' => [
                'main' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-hg__item__content",
            ],
            'important' => 'all',
            'hide_text_align' => false,
            'toggle_slug' => 'content_text_tab',
            'sub_toggle' => 'desc',
            'tab_slug' => 'advanced',
            'line_height' => [
                'range_settings' => [
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ],
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_desc_style']
            ],
            'font' => [
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_desc_style']
            ],
            'text_color' => [
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_desc_style']
            ],
            'font_size' => [
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_desc_style']
            ],
            'letter_spacing' => [
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_desc_style']
            ],
            'text_align' => [
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_desc_style']
            ],
            'text_shadow' => [
                'show_if' => [
                    'use_content_desc_style' => 'on',
                ],
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_desc_style']
            ]
        ];
        $advanced_fields["fonts"]["content_title_active"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active .dipi-hg-title",
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
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_text_style_active']
            ],
            'font' => [
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_text_style_active']
            ],
            'text_color' => [
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_text_style_active']
            ],
            'font_size' => [
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_text_style_active']
            ],
            'letter_spacing' => [
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_text_style_active']
            ],
            'text_align' => [
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_text_style_active']
            ],
            'text_shadow' => [
                'show_if' => [
                    'use_content_text_style_active' => 'on',
                ],
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_text_style_active']
            ]
        ];
		$advanced_fields["fonts"]["content_desc_active"] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'css' => [
                'main' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active .dipi-hg__item__content",
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
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_desc_style_active']
            ],
            'font' => [
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_desc_style_active']
            ],
            'text_color' => [
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_desc_style_active']
            ],
            'font_size' => [
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_desc_style_active']
            ],
            'letter_spacing' => [
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_desc_style_active']
            ],
            'text_align' => [
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_desc_style_active']
            ],
            'text_shadow' => [
                'show_if' => [
                    'use_content_desc_style_active' => 'on',
                ],
                'depends_show_if' => 'on',
                'depends_on' => ['use_content_desc_style_active']
            ]
        ];


        $advanced_fields['borders']['default'] = false;
		$advanced_fields['borders']['content_image'] = [
            'css' => [
                'main' => [
                    'border_radii' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-image-wrap img, .dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-icon-wrap .dipi-hover-box-content-icon",
                    'border_styles' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-image-wrap img, .dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-icon-wrap .dipi-hover-box-content-icon",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image',
            'show_if' => ['use_icon_style' => 'on'],
            'depends_show_if' => 'on',
            'depends_on' => ['use_icon_style'],
        ];
		$advanced_fields['borders']['content_image_active'] = [
            'css' => [
                'main' => [
                    'border_radii' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active .dipi-image-wrap img, .dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active .dipi-icon-wrap .dipi-hover-box-content-icon",
                    'border_styles' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active .dipi-image-wrap img, .dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active .dipi-icon-wrap .dipi-hover-box-content-icon",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image_active',
            'show_if' => ['use_icon_active_style' => 'on'],
            'depends_show_if' => 'on',
            'depends_on' => ['use_icon_active_style'],
        ];
        $advanced_fields['borders']['item_border'] = [
            'css' => [
                'main' => [
                    'border_radii' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item",
                    'border_styles' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item",
                ],
            ],
            'show_if' => [
                'use_item_style' => 'on'
            ],
            'depends_show_if' => 'on',
            'depends_on' => ['use_item_style'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'item_style'
        ];
        $advanced_fields['borders']['item_border_active'] = [
            'css' => [
                'main' => [
                    'border_radii' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active",
                    'border_styles' => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'item_style_active',
            'show_if' => ['use_item_active_style' => 'on'],
            'depends_show_if' => 'on',
            'depends_on' => ['use_item_active_style'],
        ];


        $advanced_fields['box_shadow']['default'] = false;
        $advanced_fields['box_shadow']['content_image'] = [
            'label' => esc_html__('Image Box Shadow', 'dipi-divi-pixel'),
             
            'css' => [
                'main' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-image-wrap img, .dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-icon-wrap .dipi-hover-box-content-icon',
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image',
            'show_if' => ['use_icon_style' => 'on'],
            'depends_show_if' => 'on',
            'depends_on' => ['use_icon_style']
        ];
        $advanced_fields['box_shadow']['content_image_active'] = [
            'label' => esc_html__('Image Box Shadow', 'dipi-divi-pixel'),
        
            'css' => [
                'main' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active .dipi-image-wrap img, .dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active .dipi-icon-wrap .dipi-hover-box-content-icon',
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image_active',
            'show_if' => ['use_icon_active_style' => 'on'],
            'depends_show_if' => 'on',
            'depends_on' => ['use_icon_active_style'],
        ];
        $advanced_fields['box_shadow']['item_shadow'] = [
            'label' => esc_html__('Item Box Shadow', 'dipi-divi-pixel'),
            'css' => [
                'main' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item',
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'item_style','show_if' => [
                'use_item_style' => 'on'
            ],
            
        ];
        $advanced_fields['box_shadow']['item_shadow_active'] = [
            'label' => esc_html__('Item Box Shadow', 'dipi-divi-pixel'),
            'css' => [
                'main' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active',
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'item_style_active',
            'show_if' => [
                'use_item_active_style' => 'on'
            ],
            'depends_show_if' => 'on',
            'depends_on' => ['use_item_active_style'],
        ];
        
       


        $advanced_fields['background'] = false;
        
		return $advanced_fields;
	}

	public function get_fields() {
		$fields = [];


        $fields['use_content_text_style'] = [
            'label' => esc_html__('Use Custom Styles For Title', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'content_text_tab',
            'sub_toggle' => 'title',
            'tab_slug' => 'advanced'
        ];
        $fields['use_content_desc_style'] = [
            'label' => esc_html__('Use Custom Styles For Description', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'content_text_tab',
            'sub_toggle' => 'desc',
            'tab_slug' => 'advanced'
        ];
        $fields['use_content_text_style_active'] = [
            'label' => esc_html__('Use Custom Styles For Title', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'content_text_active',
            'sub_toggle' => 'title',
            'tab_slug' => 'advanced'
        ];
        $fields['use_content_desc_style_active'] = [
            'label' => esc_html__('Use Custom Styles For Description', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'content_text_active',
            'sub_toggle' => 'desc',
            'tab_slug' => 'advanced'
        ];
 

        $fields['use_icon_style'] = [
            'label' => esc_html__('Use Custom Styles For Image & Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'content_icon_image',
            'tab_slug' => 'advanced',
        ];

        $fields['use_icon_active_style'] = [
            'label' => esc_html__('Use Custom Styles For Active Image & Icon', 'dipi-divi-pixel'),
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
            'tab_slug'          => 'advanced',
            'show_if' => ['use_icon_style' => 'on'],
        ];

        $fields['icon_image_margin'] = [
            'label' => esc_html__('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'content_icon_image',
            'tab_slug'          => 'advanced',
            'show_if' => ['use_icon_style' => 'on'],
        ];

        $fields['icon_image_padding_active'] = [
            'label' => esc_html__('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '10px|10px|10px|10px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'content_icon_image_active',
            'tab_slug'          => 'advanced',
            'show_if' => ['use_icon_active_style' => 'on']
        ];

        $fields['icon_image_margin_active'] = [
            'label' => esc_html__('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'content_icon_image_active',
            'tab_slug'          => 'advanced',
            'show_if' => ['use_icon_active_style' => 'on']
        ];

        $fields['use_item_style'] = [
            'label' => esc_html__('Use Custom Styles For Grid Item', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'item_style',
            'tab_slug' => 'advanced',
        ];

        $fields['use_item_active_style'] = [
            'label' => esc_html__('Use Custom Styles For Active Grid Item', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'item_style_active',
            'tab_slug' => 'advanced',
        ];
        

        $fields = $this->dipi_add_bg_field($fields, [  
            'name' => 'item',
            'label' => esc_html__('Item', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'item_style',
			'default' => '#ffffff',
			'has_image' => true,
            'show_if' => [
                'use_item_style' => 'on'
            ]
        ]);

        $fields = $this->dipi_add_bg_field($fields, [ 
            'name' => 'item_active',
            'label' => esc_html__('Card', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'item_style_active',
			'default' => '#ffffff',
			'has_image' => true,
            'show_if' => [
                'use_item_active_style' => 'on'
            ]
        ]);
        
		// Content Settings
		$fields['image'] = [
			'label' => esc_html__('Image', 'dipi-divi-pixel'),
			'type' => 'upload',
			'option_category' => 'basic_option',
			'toggle_slug' => 'image',
			'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
			'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
			'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
			'description' => esc_html__('Upload your desired image', 'dipi-divi-pixel'),
			'dynamic_content' => 'image'
		];

		// Image alt field
		$fields['image_alt'] = [
			'label' => esc_html__('Image Alt Text', 'dipi-divi-pixel'),
			'type' => 'text',
			'option_category' => 'basic_option',
			'toggle_slug' => 'image',
			'description' => esc_html__('Define the HTML ALT text for the image', 'dipi-divi-pixel'),
			'dynamic_content' => 'text'
		];

		// Title field
		$fields['title'] = [
			'label' => esc_html__('Title', 'dipi-divi-pixel'),
			'type' => 'text',
			'option_category' => 'basic_option',
			'toggle_slug' => 'content',
			'description' => esc_html__('Define the title', 'dipi-divi-pixel'),
			'dynamic_content' => 'text'
		];

		$fields['use_content_icon'] = [
            'label' => esc_html__('Use Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'content',
        ];

        $fields["content_image"] = [
            'label' => esc_html__('Thumb', 'dipi-divi-pixel'),
            'type' => 'upload',
            'option_category' => 'basic_option',
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'hide_metadata' => true,
            'show_if' => ['use_content_icon' => 'off'],
            'toggle_slug' => 'content',
            'dynamic_content' => 'image'
        ];

        $fields["content_image_alt"] = [
            'label' => esc_html__('Thumb Alt Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'description' => esc_html__('Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
            'show_if' => ['use_content_icon' => 'off'],
            'toggle_slug' => 'content',
            'dynamic_content'    => 'text'
        ];

        $fields["content_image_width"] = [
            'label' => esc_html__('Image Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'validate_unit' => true,
            'default' => '100%',
            'default_unit' => '%',
            'show_if' => ['use_content_icon' => 'off'],
            'range_settings' => [
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'width',
        ];

        $fields['content_icon'] = [
            'label' => esc_html__('Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'default' => '5',
            'show_if' => ['use_content_icon' => 'on'],
            'toggle_slug' => 'content',
        ];

        $fields["content_icon_color"] = [
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#7EBEC5',
            'show_if' => [
                'use_content_icon' => 'on',
                'use_icon_style' => 'on'
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image',
        ];
        $fields["content_circle_color"] = [
            'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'show_if' => [
                'use_content_icon' => 'on',
                'use_icon_style' => 'on'
            ],
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
            'show_if' => [
                'use_content_icon' => 'on',
                'use_icon_style' => 'on'
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image',
        ];

        $fields["content_icon_color_active"] = [
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#7EBEC5',
            'show_if' => [
                'use_content_icon' => 'on',
                'use_icon_active_style' => 'on'
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image_active',
            
        ];
        $fields["content_circle_color_active"] = [
            'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'show_if' => [
                'use_content_icon' => 'on',
                'use_icon_active_style' => 'on'
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image_active',
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
            'show_if' => [
                'use_content_icon' => 'on',
                'use_icon_active_style' => 'on'
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_icon_image_active',
        ];

		// Content field
		$fields['content_text'] = [
            'label' => esc_html__('Body Text', 'dipi-divi-pixel'),
            'type' => 'tiny_mce',
            'toggle_slug' => 'content',
            'dynamic_content' => 'text'
        ];

		// use button field
		$fields['use_button'] = [
            'label'           => esc_html__( 'Use Button', 'dipi-divi-pixel' ),
            'type'            => 'yes_no_button',
            'option_category' => 'basic_option',
            'options'         => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'default'     => 'off',
            'toggle_slug' => 'content',
            'tab_slug'    => 'general'
        ];

		// button text field
		$fields['button_text'] = [
			'label'           => esc_html__( 'Button Text', 'dipi-divi-pixel' ),
			'type'            => 'text',
			'option_category' => 'basic_option',
			'toggle_slug'     => 'content',
			'tab_slug'        => 'general',
			'dynamic_content' => 'text',
			'show_if'         => [
				'use_button' => 'on'
			]
		];

		// button url field
		$fields['button_url'] = [
			'label'           => esc_html__( 'Button URL', 'dipi-divi-pixel' ),
			'type'            => 'text',
			'option_category' => 'basic_option',
			'toggle_slug'     => 'content',
			'tab_slug'        => 'general',
			'dynamic_content' => 'url',
			'show_if'         => [
				'use_button' => 'on'
			]
		];

		// button url new tab field
		$fields['button_url_new_tab'] = [
			'label'           => esc_html__( 'Button URL Opens', 'dipi-divi-pixel' ),
			'type'            => 'select',
			'option_category' => 'configuration',
			'options'         => [
				'off' => esc_html__( 'In The Same Window', 'dipi-divi-pixel' ),
				'on'  => esc_html__( 'In The New Tab', 'dipi-divi-pixel' ),
			],
			'default'         => 'off',
			'toggle_slug'     => 'content',
			'tab_slug'        => 'general',
			'show_if'         => [
				'use_button' => 'on'
			]
		];

        $fields['content_alignment'] =  [
            'label'       => esc_html__('Alignment', 'dipi-divi-pixel'),
            'type'        => 'text_align',
            'options'     => et_builder_get_text_orientation_options(['justified']),
            'default'     => 'left',
            'mobile_options'    => true,
            'responsive'        => true,
            'toggle_slug'     => 'alignment',
			'tab_slug'        => 'general'
        ];

        $fields['content_v_alignment'] =  [
            'label'       => esc_html__('Vertical Alignment', 'dipi-divi-pixel'),
            'type'        => 'select',
            'options'     => [
                'top' => esc_html__('Top', 'dipi-divi-pixel'),
                'center' => esc_html__('Middle', 'dipi-divi-pixel'),
                'bottom' => esc_html__('Bottom', 'dipi-divi-pixel'),
                'spacebetween' => esc_html__('Space Between', 'dipi-divi-pixel'),
                'spacearound' => esc_html__('Space Around', 'dipi-divi-pixel')
            ],
            'default'     => 'center',
            'mobile_options'    => true,
            'responsive'        => true,
            'toggle_slug'     => 'alignment',
			'tab_slug'        => 'general'
        ];

        $fields['admin_label'] = [
            'label'            => esc_html__( 'Admin Label', 'dipi-divi-pixel' ),
            'type'             => 'text',
            'option_category'  => 'basic_option',
            'toggle_slug'      => 'admin_label',
            'tab_slug'         => 'general',
            'default_on_front' => 'Grid Item'
        ];

		return $fields;
	}

	public function _render_image($render_slug) {
		$content_icon_image = '';

        if ('on' == $this->props['use_content_icon']) {
            $icon = ($this->props['content_icon'] === '%&quot;%%' || $this->props['content_icon'] === '%"%%') ? '%%22%%' : $this->props['content_icon'];
            $content_icon = et_pb_process_font_icon($icon);
            $content_icon_image = sprintf(
                '<div class="dipi-content-image-icon-wrap dipi-icon-wrap">
                    <span class="et-pb-icon et-pb-font-icon dipi-hover-box-content-icon">%1$s</span>
                </div>',
                esc_attr($content_icon)
            );

            $this->dipi_generate_font_icon_styles($render_slug, 'content_icon', '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-content-image-icon-wrap .dipi-hover-box-content-icon');
        } else if ('on' !== $this->props['use_content_icon'] && $this->props['content_image'] !== '') {
            $content_icon_image = sprintf(
                '<div class="dipi-content-image-icon-wrap dipi-image-wrap">
                    <img src="%1$s" alt="%2$s">
                </div>',
                esc_attr($this->props['content_image']),
                $this->_esc_attr('content_image_alt')
            );
        }

		return $content_icon_image;
	}

    private function alignmentToStyleValues($alignment) {
		// center-center
		$alignment_map = [
			'center'=>'center',
			'left'=>'flex-start',
			'right'=>'flex-end',
			'top'=>'flex-start',
			'bottom'=>'flex-end',
            'spacebetween'=>'space-between',
            'spacearound'=>'space-around'
		];

		$alignments = explode('-', $alignment); 
		return [
			'align-items' => $alignment_map[$alignments[0]],
			'justify-content' => $alignment_map[$alignments[1]]
		];
	}

	private function alignmentToStyle($alignment) {
		$alignments = $this->alignmentToStyleValues($alignment); 
		return sprintf('align-items: %1$s; justify-content: %2$s;', $alignments['align-items'], $alignments['justify-content']);
	}

	public function _dipi_apply_css($render_slug) {
        $content_alignment  = $this->dipi_get_responsive_prop('content_alignment', 'center');
        $content_v_alignment  = $this->dipi_get_responsive_prop('content_v_alignment', 'center');
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-hg__item',
            'declaration' =>  $this->alignmentToStyle($content_alignment['desktop'] . '-' . $content_v_alignment['desktop'])
        ]);

		ET_Builder_Element::set_style($render_slug, [
            'selector' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-hg__item',
            'declaration' => $this->alignmentToStyle($content_alignment['tablet'] . '-' . $content_v_alignment['tablet']),
			'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
		]);
       
		ET_Builder_Element::set_style($render_slug, [
            'selector' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-hg__item',
            'declaration' => $this->alignmentToStyle($content_alignment['phone'] . '-' . $content_v_alignment['phone']),
			'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-hg-button',
            'declaration' =>  sprintf('align-self: %1$s;', $this->alignmentToStyleValues($content_alignment['desktop'] . '-' . $content_v_alignment['desktop'])['align-items'])
        ]);

		ET_Builder_Element::set_style($render_slug, [
            'selector' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-hg-button',
            'declaration' => sprintf('align-self: %1$s;', $this->alignmentToStyleValues($content_alignment['tablet'] . '-' . $content_v_alignment['tablet'])['align-items']),
			'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
		]);
       
		ET_Builder_Element::set_style($render_slug, [
            'selector' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-hg-button',
            'declaration' => sprintf('align-self: %1$s;', $this->alignmentToStyleValues($content_alignment['phone'] . '-' . $content_v_alignment['phone'])['align-items']),
			'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);

        if($this->props["use_icon_style"] === 'on'){
            $content_icon_color = $this->props['content_icon_color'];
            $content_circle_color = $this->props['content_circle_color'];
            $content_icon_size = $this->props['content_icon_size'];
            
            $content_icon_color_active = $this->props['content_icon_color_active'];
            $content_circle_color_active = $this->props['content_circle_color_active'];
            $content_icon_size_active = isset($this->props['content_icon_size_active']) && $this->props['content_icon_size_active'] !== '' ? $this->props['content_icon_size_active'] : '40px';

            if ('on' == $this->props['use_content_icon']):
                ET_Builder_Element::set_style($render_slug, [
                    'selector' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-hover-box-content-icon',
                    'declaration' => "color: {$content_icon_color} !important;",
                ]);
                ET_Builder_Element::set_style($render_slug, [
                    'selector' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-hover-box-content-icon',
                    'declaration' => "background-color: {$content_circle_color} !important;",
                ]);
                ET_Builder_Element::set_style($render_slug, [
                    'selector' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-hover-box-content-icon',
                    'declaration' => "font-size: {$content_icon_size} !important;",
                ]);
                
            endif;


            $this->dipi_process_spacing_field([
                'render_slug'    => $render_slug,
                'slug'           => 'icon_image_padding',
                'css_property'   => 'padding',
                'selector'       => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-image-wrap img, .dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-icon-wrap .dipi-hover-box-content-icon"
            ]);
            
            $this->dipi_process_spacing_field([
                'render_slug'    => $render_slug,
                'slug'           => 'icon_image_margin',
                'css_property'   => 'margin',
                'selector'       => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-image-wrap img, .dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-icon-wrap .dipi-hover-box-content-icon"
            ]);
    
            

        }

        if($this->props["use_icon_active_style"] === 'on'){
            if ('on' == $this->props['use_content_icon']):
                ET_Builder_Element::set_style($render_slug, [
                    'selector' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active .dipi-hover-box-content-icon',
                    'declaration' => "color: {$content_icon_color_active} !important;",
                ]);
                ET_Builder_Element::set_style($render_slug, [
                    'selector' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active .dipi-hover-box-content-icon',
                    'declaration' => "background-color: {$content_circle_color_active} !important;",
                ]);
                ET_Builder_Element::set_style($render_slug, [
                    'selector' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active .dipi-hover-box-content-icon',
                    'declaration' => "font-size: {$content_icon_size_active} !important;",
                ]);
            endif;
            $this->dipi_process_spacing_field([
                'render_slug'    => $render_slug,
                'slug'           => 'icon_image_padding_active',
                'css_property'   => 'padding',
                'selector'       => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active .dipi-image-wrap img, .dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active .dipi-icon-wrap .dipi-hover-box-content-icon"
            ]);
            $this->dipi_process_spacing_field([
                'render_slug'    => $render_slug,
                'slug'           => 'icon_image_margin_active',
                'css_property'   => 'margin',
                'selector'       => ".dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active .dipi-image-wrap img, .dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active .dipi-icon-wrap .dipi-hover-box-content-icon"
            ]);
        }

		


        $content_image_width = $this->props['content_image_width'];

        // text orientation
        if (isset($this->props['text_orientation']) && !empty($this->props['text_orientation'])) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item',
                'declaration' => "text-align: {$this->props['text_orientation']};",
            ]);
        }

		

        

      

        

		ET_Builder_Element::set_style($render_slug, [
            'selector' => '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item .dipi-image-wrap',
            'declaration' => "max-width: {$content_image_width} !important;",
        ]);

       




        if($this->props['use_item_style'] === 'on') {
            $this->set_background_css(
                $render_slug,
                '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item',
                '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item:hover',
                'item_bg',
                'item_bg_color'
            );
        }

        
        if($this->props['use_item_active_style'] === 'on') {
            $this->set_background_css(
                $render_slug,
                '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active',
                '.dipi_hover_gallery %%order_class%%.dipi_hover_gallery_item.active:hover',
                'item_active_bg',
                'item_active_bg_color'
            );
        }

	}

	public function render($attrs, $content, $render_slug) {

        $this->_dipi_apply_css($render_slug);
		global $dipi_hg_items;
		$module_order_class = ET_Builder_Element::get_module_order_class( $render_slug );
		$dipi_hg_items[$module_order_class]['image'] = esc_url($this->props['image']);
		$dipi_hg_items[$module_order_class]['image_alt'] = esc_attr($this->props['image_alt']);
		$title = $this->props['title'];
		$content = $this->props['content_text'];

		$header_lvl = (isset($this->props['content_title_level']) && !empty($this->props['content_title_level'])) ? $this->props['content_title_level'] : 'h3';
		$title = (!empty($title)) ? sprintf('<%1$s class="dipi-hg-title">%2$s</%1$s>', esc_attr($header_lvl), esc_attr($title)) : '';
	
		$image = $this->_render_image($render_slug);

		$content = sprintf(
			'<div class="dipi-hg__item__content">%1$s</div>',
			$content
		);

		$use_button = $this->props['use_button'];
        $content_button_text        = $this->props['button_text'];
        $content_button_link        = $this->props['button_url'];
        $content_button_rel         = $this->props['content_button_rel'];
        $content_button_icon        = $this->props['content_button_icon'];
        $content_button_link_target = $this->props['button_url_new_tab'];
        $content_button_custom      = $this->props['custom_content_button'];

		/** render button */
		$content_button = $use_button === 'on' ? $this->render_button([
            'button_classname' => ["dipi-hg-button"],
            'button_custom'    => $content_button_custom,
            'button_rel'       => $content_button_rel,
            'button_text'      => $content_button_text,
            'button_url'       => $content_button_link,
            'custom_icon'      => $content_button_icon,
            'url_new_window'   => $content_button_link_target,
            'has_wrapper'      => false
        ]) : '';

		/** render module */
		$output = sprintf(
			'<div class="dipi-hg__item" data-item="%4$s">
				%5$s
				%1$s
				%2$s
				%3$s
			</div>',
			 
			$title,
			$content,
			$content_button,
			$module_order_class,
			$image
		);
		return $output;
	}
}
new DIPI_HoverGalleryItem;