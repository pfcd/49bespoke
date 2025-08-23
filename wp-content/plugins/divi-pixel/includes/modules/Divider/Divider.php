<?php
class DIPI_Divider extends DIPI_Builder_Module {

    public $slug = 'dipi_divider';
    public $vb_support = 'on';

    protected $module_classname = 'dipi-pixel-divider';
    protected $classname_first_decoration = 'dipi-td-first';
    protected $classname_second_decoration = 'dipi-td-second';
    protected $classname_content = 'dipi-td-content';

    protected $selector_module = '%%order_class%% .dipi-pixel-divider';
    protected $selector_content = '%%order_class%% .dipi-pixel-divider .dipi-td-content';
    protected $selector_first_decoration = '%%order_class%% .dipi-td-first';
    protected $selector_second_decoration = '%%order_class%% .dipi-td-second';
    protected $strong_selector_second_decoration = '%%order_class%% .dipi-pixel-divider .dipi-td-second';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/pixel-divider/',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );


    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__('Pixel Divider', 'dipi-divi-pixel');
        $this->multi_view = et_pb_multi_view_options( $this );
        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'main_content' => esc_html__('Content', 'dipi-divi-pixel'),
                    'divider_settings' => esc_html__('Divider Settings', 'dipi-divi-pixel'),
                    'first_decoration' => esc_html__('Decoration', 'dipi-divi-pixel'),
                    'second_decoration' => esc_html__('Second Decoration', 'dipi-divi-pixel')
                ]
            ],
            'advanced' => [
                'toggles' => [
                    'content_style' => esc_html__('Content Style', 'dipi-divi-pixel'),
                    'text' => esc_html__('Content Text', 'dipi-divi-pixel'),
                    'first_decoration_style' => esc_html__('Decoration Style', 'dipi-divi-pixel'),
                    'second_decoration_style_toggle' => esc_html__('Second Decoration Style', 'dipi-divi-pixel')
                ]
            ]
        ];
        
        add_filter('et_required_module_assets', [$this, 'assets_filter'], 100, 1);
        add_filter('et_fb_backend_helpers', [$this, 'default_helpers'], 100, 1);
    }

    public function default_helpers ($helpers) {
		$helpers['defaults']['dipi_divider'] = [
			'content_image' => ET_BUILDER_PLACEHOLDER_LANDSCAPE_IMAGE_DATA
		];
		return $helpers;
	}

    public function assets_filter($modules ) {
        $modules[] = 'et_pb_icon';
        return $modules;
    }

    public function get_advanced_fields_config() {
         
        $accent_color = et_builder_accent_color();
        $advanced_fields = [];
        $advanced_fields['margin_padding'] = [
            'css' => [
                'margin' => '%%order_class%%',
                'padding' => '%%order_class%%',
                'important' => 'all',
            ],
        ];
        $advanced_fields['fonts'] = false;
        $advanced_fields['fonts'] = [
            'text' => [
                'label' => esc_html__('', 'dipi-divi-pixel'),
                'toggle_slug' => 'text' ,
                'css' => [
                    'main' => "{$this->selector_content}",
                    'important' => 'all',
                ],
            ]
        ];
        $advanced_fields['text'] = false;
        $advanced_fields['text_shadow'] = false;

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
        $advanced_fields['borders']['divider_content'] = [
            'label' => esc_html__('Divider Content Border', 'dipi-divi-pixel'),
            'css' => [
                'main' => [
                    'border_radii' => $this->selector_content,
                    'border_styles' => $this->selector_content,
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_style',
        ];
         
        $advanced_fields['borders']['first_decoration'] = [
            'label' => esc_html__('Divider Decoration Border', 'dipi-divi-pixel'),
            'css' => [
                'main' => [
                    'border_radii' => "{$this->selector_first_decoration}",
                    'border_styles' => "{$this->selector_first_decoration}"
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'first_decoration_style'
        ];
          
        $advanced_fields['borders']['second_decoration'] = [
            'label' => esc_html__('Divider Decoration Border', 'dipi-divi-pixel'),
            'css' => [
                'main' => [
                    'border_radii' => "{$this->strong_selector_second_decoration}",
                    'border_styles' => "{$this->strong_selector_second_decoration}"
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'second_decoration_style_toggle',
     
        ];
          
        $advanced_fields['box_shadow']['default'] = [
            'css' => [
                'main' => '%%order_class%%'
            ]
        ];
        $advanced_fields['box_shadow']['divider_content'] = [
            'label' => esc_html__('Divider Content Shadow', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'css' => [
                'main' => $this->selector_content,
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_style',
        ];

        // first decoration box shadow
        $advanced_fields['box_shadow']['first_decoration'] = [
            'label' => esc_html__('Decoration Shadow', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'css' => [
                'main' => "{$this->selector_first_decoration}",
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'first_decoration_style',
        ];
        $advanced_fields['box_shadow']['second_decoration'] = [
            'label' => esc_html__('Decoration Shadow', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'css' => [
                'main' => "{$this->strong_selector_second_decoration}",
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'second_decoration_style_toggle',
            
        ];
        return $advanced_fields;
    }
 
    public function get_fields() {
        $accent_color = et_builder_accent_color();
        $fields = [];

        $fields['content_type'] = array(
            'label' => esc_html__('Content Type', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => array(
                'text' => esc_html__('Text', 'dipi-divi-pixel'),
                'image' => esc_html__('Image', 'dipi-divi-pixel'),
                'icon' => esc_html__('Icon', 'dipi-divi-pixel'),
                'lottie' => esc_html__('Lottie', 'dipi-divi-pixel')
            ),
            'default' => 'text',
            'toggle_slug' => 'main_content',
            'description' => esc_html__('Select the content type you want to display.', 'dipi-divi-pixel')
        );
        
        $fields['content_text'] = array(
            'label' => esc_html__('Divider Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => "Title",
            'option_category' => 'basic_option',
            'description' => esc_html__('Enter the text you want to display as a divider.', 'dipi-divi-pixel'),
            'toggle_slug' => 'main_content',
            'dynamic_content' => 'text',
            'show_if' => array('content_type' => 'text')
        );

        $fields['content_image'] = array(
            'label' => esc_html__('Divider Image', 'dipi-divi-pixel'),
            'type' => 'upload',
            'option_category' => 'basic_option',
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'description' => esc_html__('Upload an image to use as a divider.', 'dipi-divi-pixel'),
            'toggle_slug' => 'main_content',
            'dynamic_content' => 'image',
            'show_if' => array('content_type' => 'image')
        );

        $fields['content_lottie'] = [
            'label' => esc_html__('Left Lottie File', 'dipi-divi-pixel'),
            'type' => 'upload',
            'option_category'    => 'basic_option',
            'upload_button_text' => esc_attr__('Upload a JSON', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose a JSON', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As JSON', 'dipi-divi-pixel'),
            'data_type'   => '',
            'toggle_slug' => 'main_content',
            'show_if' => array('content_type' => 'lottie')
        ];

        $fields['content_icon'] = array(
            'label' => esc_html__('Content Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'default' => '2||divi||400',
            'option_category' => 'basic_option',
            'description' => esc_html__('Select an icon to use as a divider.', 'dipi-divi-pixel'),
            'toggle_slug' => 'main_content',
            'show_if' => array('content_type' => 'icon')
        );

        $fields['content_icon_color'] = array(
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'default' => $accent_color,
            'toggle_slug' => 'main_content',
            'description' => esc_html__('Select the color of the icon.', 'dipi-divi-pixel'),
            'show_if' => array('content_type' => 'icon')
        );

        $fields['content_text_tag'] = array(
            'label' => esc_html__('Divider Text Tag', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => array(
                'h1' => esc_html__('H1', 'dipi-divi-pixel'),
                'h2' => esc_html__('H2', 'dipi-divi-pixel'),
                'h3' => esc_html__('H3', 'dipi-divi-pixel'),
                'h4' => esc_html__('H4', 'dipi-divi-pixel'),
                'h5' => esc_html__('H5', 'dipi-divi-pixel'),
                'h6' => esc_html__('H6', 'dipi-divi-pixel'),
                'p' => esc_html__('P', 'dipi-divi-pixel'),
                'span' => esc_html__('Span', 'dipi-divi-pixel'),
                'div' => esc_html__('Div', 'dipi-divi-pixel'),
            ),
            'default' => 'h3',
            'toggle_slug' => 'main_content',
            'show_if' => array('content_type' => 'text')
        );

        $fields['content_width'] = array(
            'label' => esc_html__('Content Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'default_unit' => 'px',
            'allowed_values' => ['auto'],
			'default' => 'auto',
            'mobile_options' => true,
            'range_settings' => array(
                'min' => '1',
                'max' => '500',
                'step' => '1',
            ),
            'toggle_slug' => 'main_content',
            'description' => esc_html__('Select the width of the content whether text, image or icon.', 'dipi-divi-pixel')
        );
        
        /* Divider Settings */ 
        $fields['divider_layout'] = array(
            'label' => esc_html__('Divider Layout', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => array(
                'row' => esc_html__('Row', 'dipi-divi-pixel'),
                'column' => esc_html__('Column', 'dipi-divi-pixel'),
            ),
            'default' => 'row',
            'toggle_slug' => 'divider_settings',
            'description' => esc_html__('Select the layout of the divider.', 'dipi-divi-pixel')
        );

        $fields['items_alignment'] = [
            'label' => esc_html__('Items Alignment', 'dipi-divi-pixel'),
            'description' => esc_html__('Align Items to the left, right or center.', 'dipi-divi-pixel'),
            'type' => 'align',
            'options' => et_builder_get_text_orientation_options(array('justified')),
            'toggle_slug' => 'divider_settings',
            'default' => 'center',
            'mobile_options' => true
        ];

        $fields['hide_first_element'] = array(
            'label' => esc_html__('Hide First Element', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'default' => 'off',
            'toggle_slug' => 'divider_settings',
            'description' => esc_html__('Select whether to hide the left element.', 'dipi-divi-pixel')
         
        );
        $fields['hide_second_element'] = array(
            'label' => esc_html__('Hide Second Element', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'default' => 'off',
            'toggle_slug' => 'divider_settings',
            'description' => esc_html__('Select whether to show the right element.', 'dipi-divi-pixel')
             
        );
        /*End of Divider Settings */ 

        // first decoration style
        $fields['first_decoration_style'] = array(
            'label' => esc_html__('Decoration Style', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => array(
                'line' => esc_html__('Line', 'dipi-divi-pixel'),
                'image' => esc_html__('Image', 'dipi-divi-pixel'),
                'icon' => esc_html__('Icon', 'dipi-divi-pixel'),
                'lottie' => esc_html__('Lottie', 'dipi-divi-pixel'),
                'empty' => esc_html__('Empty Div', 'dipi-divi-pixel'),
            ),
            'default' => 'line',
            'toggle_slug' => 'first_decoration',
            'description' => esc_html__('Select the style of the decoration.', 'dipi-divi-pixel')
        );
        $fields['decoration_first_image'] = array(
            'label' => esc_html__('Decoration Image', 'dipi-divi-pixel'),
            'type' => 'upload',
            'option_category' => 'basic_option',
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'description' => esc_html__('Upload an image to use as a divider.', 'dipi-divi-pixel'),
            'toggle_slug' => 'first_decoration',
            'show_if' => array('first_decoration_style' => 'image')
        );
        $fields['decoration_first_icon'] = array(
            'label' => esc_html__('Divider Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'option_category' => 'basic_option',
            'description' => esc_html__('Select an icon to use as a divider.', 'dipi-divi-pixel'),
            'toggle_slug' => 'first_decoration',
            'show_if' => array('first_decoration_style' => 'icon')
        );
        // color field 
        $fields['first_decoration_icon_color'] = array(
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'default' => $accent_color,
            'toggle_slug' => 'first_decoration',
            'description' => esc_html__('Select the color of the icon.', 'dipi-divi-pixel'),
            'show_if' => array('first_decoration_style' => 'icon')
        );
        $fields['first_decoration_line_style'] = array(
            'label' => esc_html__('Line Style', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => array(
                'solid' => esc_html__('Solid', 'dipi-divi-pixel'),
                'dashed' => esc_html__('Dashed', 'dipi-divi-pixel'),
                'dotted' => esc_html__('Dotted', 'dipi-divi-pixel'),
                'double' => esc_html__('Double', 'dipi-divi-pixel'),
                'groove' => esc_html__('Groove', 'dipi-divi-pixel'),
                'ridge' => esc_html__('Ridge', 'dipi-divi-pixel'),
                'inset' => esc_html__('Inset', 'dipi-divi-pixel'),
                'outset' => esc_html__('Outset', 'dipi-divi-pixel'),
            ),
            'default' => 'solid',
            'toggle_slug' => 'first_decoration',
            'description' => esc_html__('Select the style of the line decoration.', 'dipi-divi-pixel'),
            'show_if' => array('first_decoration_style' => 'line')
        );
        $fields['first_decoration_line_color'] = array(
            'label' => esc_html__('Line Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'default' => $accent_color,
            'toggle_slug' => 'first_decoration',
            'description' => esc_html__('Select the color of the line.', 'dipi-divi-pixel'),
            'show_if' => array('first_decoration_style' => 'line')
        );
        $fields['decoration_first_lottie_file'] = [
            'label' => esc_html__('Left Lottie File', 'dipi-divi-pixel'),
            'type' => 'upload',
            'option_category'    => 'basic_option',
            'upload_button_text' => esc_attr__('Upload a JSON', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose a JSON', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As JSON', 'dipi-divi-pixel'),
            'data_type'   => '',
            'toggle_slug' => 'first_decoration',
            'show_if' => array('first_decoration_style' => 'lottie')
        ];

        
        $fields['first_decoration_icon_size'] = array(
            'label' => esc_html__('Icon Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'default_unit' => 'px',
            'default' => '20px',
            'mobile_options' => true,
            'range_settings' => array(
                'min' => '1',
                'max' => '100',
                'step' => '1',
            ),
            'toggle_slug' => 'first_decoration',
            'description' => esc_html__('Select the size of the icon.', 'dipi-divi-pixel'),
            'show_if' => array('first_decoration_style' => 'icon')
        );
      
        $fields['first_icon_alignment'] = [
            'label' => esc_html__('Icon Alignment', 'dipi-divi-pixel'),
            'description' => esc_html__('Align Icon to the left, right or center.', 'dipi-divi-pixel'),
            'type' => 'align',
            'options' => et_builder_get_text_orientation_options(array('justified')),
            'toggle_slug' => 'first_decoration',
            'default' => 'center',
            'mobile_options' => true,
            'show_if' => array('first_decoration_style' => 'icon')
        ];


        $fields['first_decoration_width'] = array(
            'label' => esc_html__('Decoration width', 'dipi-divi-pixel'),
            'type' => 'range',
            'default_unit' => 'px',
            'allowed_values' => ['auto'],
			'default' => 'auto',
            'mobile_options' => true,
            'range_settings' => array(
                'min' => '1',
                'max' => '500',
                'step' => '1',
            ),
            'toggle_slug' => 'first_decoration',
            'description' => esc_html__('Select the size of the decoration, it will be width in case of border or image, and font size in case of icon.', 'dipi-divi-pixel')
        );
        $fields['first_line_weight'] = array(
            'label' => esc_html__('Decoration Line Weight', 'dipi-divi-pixel'),
            'type' => 'range',
            'default_unit' => 'px',
            'default' => '1px',
            'mobile_options' => true,
            'range_settings' => array(
                'min' => '1',
                'max' => '100',
                'step' => '1',
            ),
            'toggle_slug' => 'first_decoration',
            'description' => esc_html__('Select the weight of the line.', 'dipi-divi-pixel'),
            'show_if' => array('first_decoration_style' => 'line')
        );

        // second decoration style
        $fields['use_custom_second_decoration'] = array(
            'label' => esc_html__('Use Custom Second Decoration', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'default' => 'off',
            'toggle_slug' => 'second_decoration',
            'description' => esc_html__('Select whether to use a custom second decoration, by default it use mirror style.', 'dipi-divi-pixel')
        );

        $fields['second_decoration_style'] = array(
            'label' => esc_html__('Decoration Style', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => array(
                'line' => esc_html__('Line', 'dipi-divi-pixel'),
                'image' => esc_html__('Image', 'dipi-divi-pixel'),
                'icon' => esc_html__('Icon', 'dipi-divi-pixel'),
                'lottie' => esc_html__('Lottie', 'dipi-divi-pixel'),
            ),
            'default' => 'line',
            'toggle_slug' => 'second_decoration',
            'description' => esc_html__('Select the style of the decoration.', 'dipi-divi-pixel'),
            'show_if' => ['use_custom_second_decoration' => 'on']
        );
        $fields['decoration_second_image'] = array(
            'label' => esc_html__('Decoration Image', 'dipi-divi-pixel'),
            'type' => 'upload',
            'option_category' => 'basic_option',
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'description' => esc_html__('Upload an image to use as a divider.', 'dipi-divi-pixel'),
            'toggle_slug' => 'second_decoration',
            'show_if' => [
                'second_decoration_style' => 'image',
                'use_custom_second_decoration' => 'on'
            ]
        );
        $fields['decoration_second_icon'] = array(
            'label' => esc_html__('Decoration Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'option_category' => 'basic_option',
            'description' => esc_html__('Select an icon to use as a divider.', 'dipi-divi-pixel'),
            'toggle_slug' => 'second_decoration',
            'show_if' => array('second_decoration_style' => 'icon',
            'use_custom_second_decoration' => 'on')
        );
        $fields['second_decoration_icon_color'] = array(
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'default' => $accent_color,
            'toggle_slug' => 'second_decoration',
            'description' => esc_html__('Select the color of the icon.', 'dipi-divi-pixel'),
            'show_if' => array('second_decoration_style' => 'icon')
        );
        $fields['second_decoration_line_style'] = array(
            'label' => esc_html__('Line Style', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => array(
                'solid' => esc_html__('Solid', 'dipi-divi-pixel'),
                'dashed' => esc_html__('Dashed', 'dipi-divi-pixel'),
                'dotted' => esc_html__('Dotted', 'dipi-divi-pixel'),
                'double' => esc_html__('Double', 'dipi-divi-pixel'),
                'groove' => esc_html__('Groove', 'dipi-divi-pixel'),
                'ridge' => esc_html__('Ridge', 'dipi-divi-pixel'),
                'inset' => esc_html__('Inset', 'dipi-divi-pixel'),
                'outset' => esc_html__('Outset', 'dipi-divi-pixel'),
            ),
            'default' => 'solid',
            'toggle_slug' => 'second_decoration',
            'description' => esc_html__('Select the style of the line decoration.', 'dipi-divi-pixel'),
            'show_if' => array('second_decoration_style' => 'line',
            'use_custom_second_decoration' => 'on')
        );
        $fields['second_decoration_line_color'] = array(
            'label' => esc_html__('Line Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'default' => $accent_color,
            'toggle_slug' => 'second_decoration',
            'description' => esc_html__('Select the color of the line.', 'dipi-divi-pixel'),
            'show_if' => array(
                'second_decoration_style' => 'line',
                'use_custom_second_decoration' => 'on'
            )
        );
        $fields['second_line_weight'] = array(
            'label' => esc_html__('Decoration Line Weight', 'dipi-divi-pixel'),
            'type' => 'range',
            'default_unit' => 'px',
            'default' => '1px',
            'mobile_options' => true,
            'range_settings' => array(
                'min' => '1',
                'max' => '100',
                'step' => '1',
            ),
            'toggle_slug' => 'second_decoration',
            'description' => esc_html__('Select the weight of the line.', 'dipi-divi-pixel'),
            'show_if' => array(
                'second_decoration_style' => 'line',
                'use_custom_second_decoration' => 'on'
                )
        );
        $fields['decoration_second_lottie_file'] = [
            'label' => esc_html__('Left Lottie File', 'dipi-divi-pixel'),
            'type' => 'upload',
            'option_category'    => 'basic_option',
            'upload_button_text' => esc_attr__('Upload a JSON', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose a JSON', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As JSON', 'dipi-divi-pixel'),
            'data_type'   => '',
            'toggle_slug' => 'second_decoration',
            'show_if' => array('second_decoration_style' => 'lottie',
            'use_custom_second_decoration' => 'on')
        ];

        $fields['second_decoration_icon_size'] = array(
            'label' => esc_html__('Icon Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'default_unit' => 'px',
            'default' => '20px',
            'mobile_options' => true,
            'range_settings' => array(
                'min' => '1',
                'max' => '100',
                'step' => '1',
            ),
            'toggle_slug' => 'second_decoration',
            'description' => esc_html__('Select the size of the icon.', 'dipi-divi-pixel'),
            'show_if' => array('second_decoration_style' => 'icon')
        );
      
        $fields['second_icon_alignment'] = [
            'label' => esc_html__('Icon Alignment', 'dipi-divi-pixel'),
            'description' => esc_html__('Align Icon to the left, right or center.', 'dipi-divi-pixel'),
            'type' => 'align',
            'options' => et_builder_get_text_orientation_options(array('justified')),
            'toggle_slug' => 'second_decoration',
            'default' => 'center',
            'mobile_options' => true,
            'show_if' => array('second_decoration_style' => 'icon')
        ];

        $fields['second_decoration_width'] = array(
            'label' => esc_html__('Decoration width', 'dipi-divi-pixel'),
            'type' => 'range',
            'default_unit' => 'px',
            'allowed_values' => ['auto'],
			'default' => 'auto',
            'mobile_options' => true,
            'range_settings' => array(
                'min' => '1',
                'max' => '500',
                'step' => '1',
            ),
            'toggle_slug' => 'second_decoration',
            'description' => esc_html__('Select the size of the decoration, it will be width in case of border or image, and font size in case of icon.', 'dipi-divi-pixel'),
            'show_if' => ['use_custom_second_decoration' => 'on']

        );

        /* Advanced Fields */
        $fields['content_padding'] = array(
            'label' => esc_html__('Content Padding', 'dipi-divi-pixel'),
            'type' => 'custom_padding',
            'default' => '10px|10px|10px|10px',
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_style',
            'description' => esc_html__('Here you can define the padding of the content.', 'dipi-divi-pixel')
        );

        $fields['content_margin'] = array(
            'label' => esc_html__('Content Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_style',
            'description' => esc_html__('Here you can define the margin of the content.', 'dipi-divi-pixel')
        );

        $fields = $this->dipi_add_bg_field($fields, [ 
            'name' => 'content',
            'label' => esc_html__('Content', 'dipi-divi-pixel'),
            'has_image' => true,
            'default' => 'transparent',
            'tab_slug'              => 'advanced',
            'toggle_slug'           => 'content_style'
        ]);


        // first decoration style
        $fields['first_decoration_padding'] = array(
            'label' => esc_html__('Decoration Padding', 'dipi-divi-pixel'),
            'type' => 'custom_padding',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'first_decoration_style',
            'description' => esc_html__('Here you can define the padding of the decoration.', 'dipi-divi-pixel')
        );
        $fields['first_decoration_margin'] = array(
            'label' => esc_html__('Decoration Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'first_decoration_style',
            'description' => esc_html__('Here you can define the margin of the decoration.', 'dipi-divi-pixel')
        );
        $fields = $this->dipi_add_bg_field($fields, [ 
            'name' => 'first_decoration',
            'label' => esc_html__('Decoration', 'dipi-divi-pixel'),
            'default' => 'transparent',
            'has_image' => true,
            'tab_slug'              => 'advanced',
            'toggle_slug'           => 'first_decoration_style'
        ]);

        $fields['use_custom_second_decoration_advanced_styling'] = array(
            'label' => esc_html__('Use Custom Second Decoration Styling', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'default' => 'off',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'second_decoration_style_toggle',
            'description' => esc_html__('Select whether to use a custom second decoration styling, by default it use mirror style.', 'dipi-divi-pixel')
        );
        $fields['second_decoration_padding'] = array(
            'label' => esc_html__('Decoration Padding', 'dipi-divi-pixel'),
            'type' => 'custom_padding',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'second_decoration_style_toggle',
            'description' => esc_html__('Here you can define the padding of the decoration.', 'dipi-divi-pixel'),
            'show_if' => array('use_custom_second_decoration_advanced_styling' => 'on')
        );
        $fields['second_decoration_margin'] = array(
            'label' => esc_html__('Decoration Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'mobile_options' => true,
            'default' => '0px|0px|0px|0px',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'second_decoration_style_toggle',
            'description' => esc_html__('Here you can define the margin of the decoration.', 'dipi-divi-pixel'),
            'show_if' => array('use_custom_second_decoration_advanced_styling' => 'on')
        );
        $fields = $this->dipi_add_bg_field($fields, [ 
            'name' => 'second_decoration',
            'label' => esc_html__('Decoration Background', 'dipi-divi-pixel'),
            'has_image' => true,
            'tab_slug'              => 'advanced',
            'toggle_slug'           => 'second_decoration_style_toggle',
            'show_if' => array('use_custom_second_decoration_advanced_styling' => 'on')
        ]);


        return $fields;
    }

    public function get_custom_css_fields_config()
    {
        $fields = [];
        return $fields;
    }

    
    public function process_justify_content_css($render_slug, $property, $selector) {
        $property_tablet = $property . '_tablet';
        $property_phone = $property . '_phone';
        $items_alignment = $this->props[$property] ? $this->props[$property] : 'center';
        $items_alignment_tablet = $this->props[$property_tablet] ? $props[$property_tablet] : $items_alignment;
        $items_alignment_phone = $this->props[$property_phone] ? $props[$property_phone] : $items_alignment_tablet;
        $flexAlignemnts = [
            'left' => 'flex-start',
            'center' => 'center',
            'right' => 'flex-end'
        ];
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('justify-content:%1$s;', $flexAlignemnts[$items_alignment])
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('justify-content:%1$s;', $flexAlignemnts[$items_alignment_tablet]),
            'media_query' =>  ET_Builder_Element::get_media_query('max_width_980')
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $selector,
            'declaration' => sprintf('justify-content:%1$s;', $flexAlignemnts[$items_alignment_phone]),
            'media_query' =>  ET_Builder_Element::get_media_query('max_width_767')
        ));
    }

    public function apply_content_style($render_slug) {
        $content_type = $this->props["content_type"];
        $divider_layout = $this->props["divider_layout"];
        $content_width = $this->props['content_width'];
       

        if($content_type !== 'icon') {
            if($divider_layout === 'row') {
                $this->process_range_field_css( array(
                    'render_slug' => $render_slug,
                    'slug'        => 'content_width',
                    'type'        => 'flex-basis',
                    'default'     => '0',
                    'fixed_unit'  => 'px',
                    'selector'    => $this->selector_content,
                    'important'   => true
                ) );
                $this->process_range_field_css( array(
                    'render_slug' => $render_slug,
                    'slug'        => 'content_width',
                    'type'        => 'width',
                    'default'     => '0',
                    'fixed_unit'  => 'px',
                    'selector'    => $this->selector_content,
                    'important'   => true
                ) );
            } else {
                $this->process_range_field_css( array(
                    'render_slug' => $render_slug,
                    'slug'        => 'content_width',
                    'type'        => 'width',
                    'default'     => '0',
                    'fixed_unit'  => 'px',
                    'selector'    => $this->selector_content,
                    'important'   => true
                ) );
            }
        } else {
            $this->process_range_field_css( array(
                'render_slug' => $render_slug,
                'slug'        => 'content_width',
                'type'        => 'font-size',
                'default'     => '0',
                'fixed_unit'  => 'px',
                'selector'    => $this->selector_content . ' .et-pb-icon',
                'important'   => true
            ) );
        }
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'content_padding',
            'css_property'   => 'padding',
            'selector'       => $this->selector_content,
            'hover_selector' => $this->selector_content . ':hover',
            'important'      => true
        ]);
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'content_margin',
            'css_property'   => 'margin',
            'selector'       => $this->selector_content,
            'hover_selector' => $this->selector_content . ':hover'
        ]);
        $this->set_background_css(
            $render_slug,
            $this->selector_content,
            $this->selector_content . ':hover',
            'content_bg',
            'content_bg_color'
        );

        if($content_type === 'icon') {
            $this->process_color_field_css(array(
                'render_slug' => $render_slug,
                'slug'        => 'content_icon_color',
                'type'        => 'color',
                'selector'    => $this->selector_content . ' .et-pb-icon',
                'hover'       => $this->selector_content . ':hover .et-pb-icon',
                'important'   => true
            ));
        }
    }

    public function apply_style($render_slug) {

        $divider_layout = $this->props["divider_layout"];
        $first_decoration_style = $this->props["first_decoration_style"];
        $first_decoration_line_style = $this->props["first_decoration_line_style"];
        $first_decoration_line_color = $this->props["first_decoration_line_color"];
        $first_decoration_width = $this->props['first_decoration_width'];
        $second_decoration_style = $this->props["second_decoration_style"];
        $second_decoration_width = $this->props['second_decoration_width'];
        
   
        $flexAlignemnts = [
            'left'=> 'flex-start',
            'center'=> 'center',
            'right'=> 'flex-end'
        ];
        $items_alignment = $this->props["items_alignment"] ? $this->props["items_alignment"] : 'center';
    $items_alignment_tablet = $this->props["items_alignment_tablet"] ? $props["items_alignment_tablet"] : $items_alignment;
    $items_alignment_phone = $this->props["items_alignment_phone"] ? $props["items_alignment_phone"] : $items_alignment;

    if($divider_layout === 'row') {
        ET_Builder_Element::set_style($render_slug, [
            'selector' => $this->selector_module,
            'declaration' => sprintf('justify-content: %1$s;', $flexAlignemnts[$items_alignment])
    ] );
        ET_Builder_Element::set_style($render_slug, [
            'selector' => $this->selector_module,
            'declaration' => sprintf('justify-content: %1$s;', $flexAlignemnts[$items_alignment_tablet]),
            'media_query' =>  ET_Builder_Element::get_media_query('max_width_980')
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => $this->selector_module,
            'declaration' => sprintf('justify-content: %1$s;', $flexAlignemnts[$items_alignment_phone]),
            'media_query' =>  ET_Builder_Element::get_media_query('max_width_767')
        ]);
    } else {
        ET_Builder_Element::set_style($render_slug, [
            'selector' => $this->selector_module,
            'declaration' => sprintf('align-items: %1$s;', $flexAlignemnts[$items_alignment])
    ] );
        ET_Builder_Element::set_style($render_slug, [
            'selector' => $this->selector_module,
            'declaration' => sprintf('align-items: %1$s;', $flexAlignemnts[$items_alignment_tablet]),
            'media_query' =>  ET_Builder_Element::get_media_query('max_width_980')
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => $this->selector_module,
            'declaration' => sprintf('align-items: %1$s;', $flexAlignemnts[$items_alignment_phone]),
            'media_query' =>  ET_Builder_Element::get_media_query('max_width_767')
        ]);
    }
        


        $use_custom_second_decoration = $this->props["use_custom_second_decoration"];
        $line_selector = $use_custom_second_decoration !== 'on' ? $this->selector_first_decoration . ','. $this->selector_second_decoration : $this->selector_first_decoration;
        $decoration_icon_selector = $use_custom_second_decoration !== 'on' ? 
            $this->selector_first_decoration . ' .et-pb-icon,'. $this->selector_second_decoration . ' .et-pb-icon' : $this->selector_first_decoration . ' .et-pb-icon';


        if($first_decoration_style === 'icon') {
            $this->dipi_generate_font_icon_styles($render_slug, 'decoration_first_icon', $decoration_icon_selector );
        }
        if($use_custom_second_decoration !== 'on' && $second_decoration_style === 'icon') {
            $this->dipi_generate_font_icon_styles($render_slug, 'decoration_second_icon', $this->selector_first_decoration . ' .et-pb-icon' );

        }


        $this->apply_content_style($render_slug);
        $this->process_justify_content_css($render_slug, 'items_alignment', $this->selector_module);
        $this->process_justify_content_css($render_slug, 'first_icon_alignment', $line_selector);

        if($divider_layout === 'column') {

            $this->process_range_field_css( array(
                'render_slug'       => $render_slug,
                'slug'              => 'first_decoration_width',
                'type'              => 'width',
                'fixed_unit'        => 'px',  
                'selector'          => $line_selector
            ) );
            if($use_custom_second_decoration === 'on') { // use custom second decoration width
                $this->process_range_field_css( array(
                    'render_slug'       => $render_slug,
                    'slug'              => 'second_decoration_width',
                    'type'              => 'width',
                    'fixed_unit'        => 'px',  
                    'selector'          => $this->selector_second_decoration
                ) );
            }
        } else { // row layout
            $this->process_range_field_css( array(
                'render_slug' => $render_slug,
                'slug'        => 'first_decoration_width',
                'type'        => 'flex-basis',
                'fixed_unit'  => 'px',
                'selector'    => $line_selector
            ) );

            if($this->props['first_decoration_width'] !== 'auto' && !empty($this->props['first_decoration_width'])) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $line_selector,
                    'declaration' => sprintf('flex-grow:0 !important;'),
                ));
            }
 

          
            if($this->props['first_decoration_width_tablet'] !== 'auto' && !empty($this->props['first_decoration_width_tablet'])) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $line_selector,
                    'declaration' => sprintf('flex-grow:0!important;'),
                    'media_query' =>  ET_Builder_Element::get_media_query('max_width_980')
                ));
            }
            if($this->props['first_decoration_width_phone'] !== 'auto' && !empty($this->props['first_decoration_width_phone'])) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $line_selector,
                    'declaration' => sprintf('flex-grow:0!important;'),
                    'media_query' =>  ET_Builder_Element::get_media_query('max_width_767')
                ));
            }
             


            if($use_custom_second_decoration === 'on') { // use custom second decoration width
                $this->process_range_field_css( array(
                    'render_slug' => $render_slug,
                    'slug'        => 'second_decoration_width',
                    'type'        => 'flex-basis',
                    'fixed_unit'  => 'px',
                    'selector'    => $this->selector_second_decoration
                ) );
               
                if($this->props['second_decoration_width'] !== 'auto' && !empty($this->props['second_decoration_width'])) {
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector' => $this->selector_second_decoration,
                        'declaration' => sprintf('flex-grow:0!important;'),
                    ));
                }

                if($this->props['second_decoration_width_tablet'] !== 'auto' && !empty($this->props['second_decoration_width_tablet'])) {
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector' => $this->selector_second_decoration,
                        'declaration' => sprintf('flex-grow:0!important;'),
                        'media_query' =>  ET_Builder_Element::get_media_query('max_width_980')
                    ));
                }
                if($this->props['second_decoration_width_phone'] !== 'auto' && !empty($this->props['second_decoration_width_phone'])) {
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector' => $this->selector_second_decoration,
                        'declaration' => sprintf('flex-grow:0!important;'),
                        'media_query' =>  ET_Builder_Element::get_media_query('max_width_767')
                    ));
                }
            }
        }
        if($first_decoration_style === 'icon'){
            $this->process_range_field_css( array(
                'render_slug' => $render_slug,
                'slug'        => 'first_decoration_icon_size',
                'type'        => 'font-size',
                'fixed_unit'  => 'px',
                'selector'    => $decoration_icon_selector
            ) );
        }

        if($use_custom_second_decoration === 'on' && $second_decoration_style === 'icon') {

            $this->process_range_field_css( array(
                'render_slug' => $render_slug,
                'slug'        => 'second_decoration_icon_size',
                'type'        => 'font-size',
                'fixed_unit'  => 'px',
                'selector'    => $this->selector_second_decoration . ' .et-pb-icon' 
            ) );

           $this->process_justify_content_css($render_slug, 'second_icon_alignment', $this->selector_second_decoration);
        }

        if($first_decoration_style === 'line'){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $line_selector,
                'declaration' => sprintf('border-top-style:%1$s;border-top-color:%2$s;', $first_decoration_line_style, $first_decoration_line_color),
                
            ));
            $this->process_range_field_css( array(
                'render_slug' => $render_slug,
                'slug'        => 'first_line_weight',
                'type'        => 'border-width',
                'default' => '1',
                'fixed_unit'  => 'px',
                'selector'    => $line_selector 
            ) );
        }

        if($use_custom_second_decoration === 'on' && $second_decoration_style === 'line') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $this->selector_second_decoration,
                'declaration' => sprintf('border-top-style:%1$s;border-top-color:%2$s;', $first_decoration_line_style, $first_decoration_line_color),
                
            ));
            $this->process_range_field_css( array(
                'render_slug' => $render_slug,
                'slug'        => 'second_line_weight',
                'type'        => 'border-width',
                'default' => '1',
                'fixed_unit'  => 'px',
                'selector'    => $this->selector_second_decoration 
            ) );
        }

        if($first_decoration_style === 'icon') {
            $this->process_color_field_css(array(
                'render_slug' => $render_slug,
                'slug'        => 'first_decoration_icon_color',
                'type'        => 'color',
                'selector'    => $decoration_icon_selector
            ));
        }
        if($use_custom_second_decoration === 'on' && $second_decoration_style === 'icon') {
            $this->process_color_field_css(array(
                'render_slug' => $render_slug,
                'slug'        => 'second_decoration_icon_color',
                'type'        => 'color',
                'selector'    => $this->selector_second_decoration . ' .et-pb-icon'
            ));
        }
        $this->dipi_generate_font_icon_styles($render_slug, 'content_icon', $this->selector_content . ' .et-pb-icon');

        $use_custom_second_decoration_advanced_styling = $this->props["use_custom_second_decoration_advanced_styling"];
        $line_selector = $use_custom_second_decoration_advanced_styling !== 'on' ? $this->selector_first_decoration . ','. $this->selector_second_decoration : $this->selector_first_decoration;

        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'first_decoration_padding',
            'css_property'   => 'padding',
            'selector'       => $line_selector
            
        ]);
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'first_decoration_margin',
            'css_property'   => 'margin',
            'selector'       => $line_selector 
            
        ]);
        $this->set_background_css(
            $render_slug,
            $line_selector,
            $line_selector . ':hover',
            'first_decoration_bg',
            'first_decoration_bg_color'
        );
        if($use_custom_second_decoration_advanced_styling === 'on') {
            $this->dipi_process_spacing_field([
                'render_slug'    => $render_slug,
                'slug'           => 'second_decoration_padding',
                'css_property'   => 'padding',
                'selector'       => $this->selector_second_decoration,
                'hover_selector' => $this->selector_second_decoration . ':hover'
            ]);
            $this->dipi_process_spacing_field([
                'render_slug'    => $render_slug,
                'slug'           => 'second_decoration_margin',
                'css_property'   => 'margin',
                'selector'       => $this->selector_second_decoration,
                'hover_selector' => $this->selector_second_decoration . ':hover'
            ]);
            $this->set_background_css(
                $render_slug,
                $this->selector_second_decoration,
                $this->selector_second_decoration . ':hover',
                'second_decoration_bg',
                'second_decoration_bg_color'
            );
        }

    }
  
    public function render_content_text() {
        $content_text_tag = $this->props["content_text_tag"];
        return sprintf('<%1$s class="%2$s">%3$s</%1$s>', $content_text_tag, $this->classname_content, $this->props["content_text"]);
    }

    public function render_content_image() {
        return sprintf('
            <img class="%1$s" src="%2$s" />',
            $this->classname_content,
            $this->props["content_image"]
        );
    }

    public function render_content_icon() {
        $content_icon = $this->props["content_icon"];
        $content_icon = et_pb_process_font_icon($content_icon);
        return sprintf(
            '<div class="%1$s"><span class="et-pb-icon">%2$s</span></div>',
                $this->classname_content,
                $content_icon
        );
    }

    public function render_content_lottie() {
        $lottie_file = $this->props["content_lottie"];
        return sprintf('
        <div class="%1$s">
            <lottie-player autoplay loop mode="normal" src="%2$s" style="width: 100%%">
            </lottie-player>
        </div>',
      $this->classname_content,
      $lottie_file);
    }


    public function render_first_decoration() {
       
        return $this->render_decoration($this->classname_first_decoration, true);
    }

    public function render_second_decoration () {
        $use_custom_second_decoration = $this->props["use_custom_second_decoration"];
        $isFirst = $use_custom_second_decoration !== 'on';
        return $this->render_decoration($this->classname_second_decoration, $isFirst);
    }

    public function render_decoration ($classname, $isFirst) {
        $decoration_style = $isFirst ? $this->props['first_decoration_style'] : $this->props['second_decoration_style'];
 
        $classnames = sprintf('dipi-td-decoration  dipi-td-decoration-%1$s %2$s', $decoration_style, $classname);
        $render = '';
      
        $render .= $decoration_style === 'line' ? $this->render_line_decoration($classnames, $isFirst) : '';
        $render .= $decoration_style === 'image' ? $this->render_image_decoration($classnames, $isFirst) : '';
        $render .= $decoration_style === 'icon' ? $this->render_icon_decoration($classnames, $isFirst) : '';
        $render .= $decoration_style === 'lottie' ? $this->render_lottie_decoration($classnames, $isFirst) : '';
        $render .= $decoration_style === 'empty' ? $this->render_line_decoration($classnames, $isFirst) : '';
       
        return $render;
    }

    public function render_line_decoration($classname, $isFirst = true){
         
        return sprintf('<div class="%1$s"></div>', $classname);
    }
    public function render_image_decoration($classname, $isFirst = true){
        $decoration_image = $isFirst ? $this->props['decoration_first_image'] : $this->props['decoration_second_image'];
        return sprintf('<div class="%1$s"><img src="%2$s" /></div>', $classname, $decoration_image);
    }
    public function render_icon_decoration($classname, $isFirst = true){
        $decoration_icon = $isFirst ? $this->props['decoration_first_icon'] : $this->props['decoration_second_icon'];
        $decoration_icon = et_pb_process_font_icon($decoration_icon);
        
        return sprintf('<div class="%1$s"><span class="et-pb-icon">%2$s</span></div>', $classname, $decoration_icon);
    }
    public function render_lottie_decoration($classname, $isFirst = true){
        $decoration_lottie = $isFirst ? $this->props['decoration_first_lottie_file'] : $this->props['decoration_second_lottie_file'];
        return sprintf('<div class="%1$s">
            <lottie-player autoplay loop mode="normal" src="%2$s" style="width: 100%%">
            </lottie-player>
        </div>', $classname, $decoration_lottie);
    }
   

    public function render($attrs, $content, $render_slug) {
        wp_enqueue_script('dipi_lottie_interactivity');
        wp_enqueue_script('dipi_lottie_player');
        wp_enqueue_script('dipi_divider');        

        $this->apply_style($render_slug);


        $content_type = $this->props["content_type"];
        $hide_first_element = $this->props["hide_first_element"];
        $hide_second_element = $this->props["hide_second_element"];
        $use_custom_second_decoration = $this->props["use_custom_second_decoration"];
        $className = sprintf('dipi-pixel-divider dipi-pixel-divider-%1$s dipi-pixel-divider-%2$s', 
            $this->props["divider_layout"], 
            $content_type
        );   
        $className .= $hide_first_element === 'on' ? ' dipi-pixel-divider-hide-first' : '';
        $className .= $hide_second_element === 'on' ? ' dipi-pixel-divider-hide-second' : '';
        $className .= $use_custom_second_decoration !== 'on' ? ' dipi-pixel-divider-mirror' : '';
        $content  = '';
        $content = ($content_type === 'text') ? $this->render_content_text() : $content;
        $content = ($content_type === 'image') ? $this->render_content_image() : $content;
        $content = ($content_type === 'icon') ? $this->render_content_icon() : $content;
        $content = ($content_type === 'lottie') ? $this->render_content_lottie() : $content;
      
       
        $first_decoration = $hide_first_element !== 'on'? $this->render_first_decoration() : '';
        $second_decoration = $hide_second_element !== 'on'? $this->render_second_decoration() : '';
       
        return sprintf('
            <div class="%1$s">%3$s%2$s%4$s</div>',
                $className,
                $content,
                $first_decoration,
                $second_decoration

        );
        
 
    }
}
new DIPI_Divider;