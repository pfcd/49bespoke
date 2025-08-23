<?php

class DIPI_PricingTableItem extends DIPI_Builder_Module {

    public $slug = 'dipi_pricing_table_item';
    public $vb_support = 'on';
    public $type = 'child';
    public $child_title_var = 'admin_label';
    public $child_title_fallback_var = 'item_type';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/price-list',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->name = esc_html__('Pixel Pricing Table', 'dipi-divi-pixel');
    }

    public function get_fields() {
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

        
        $fields['admin_label'] = [
            'label'            => esc_html__( 'Admin Label', 'dipi-divi-pixel' ),
            'type'             => 'text',
            'option_category'  => 'basic_option',
            'toggle_slug'      => 'admin_label',
            'tab_slug'         => 'general'
        ];
        $fields['item_type'] = [
            'label'   => esc_html__('Item Type', 'dipi-divi-pixel'),
            'type'    => 'select',
            'default' => 'Text',
            'options' => [
                'Text'    => esc_html__('Text', 'dipi-divi-pixel'),
                'Image'   => esc_html__('Image', 'dipi-divi-pixel'),
                'Icon'    => esc_html__('Icon', 'dipi-divi-pixel'),
                'Price'   => esc_html__('Price', 'dipi-divi-pixel'),
                'Feature' => esc_html__('Feature', 'dipi-divi-pixel'),
                'Ribbon' => esc_html__('Ribbon', 'dipi-divi-pixel'),
                'Button'  => esc_html__('Button', 'dipi-divi-pixel')
            ],
            'tab_slug'    => 'general',
            'toggle_slug' => 'main_content'
        ];

        $fields['text_content']        = [
            'label'           => esc_html__('Text Content', 'dipi-divi-pixel'),
            'type'            => 'tiny_mce',
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'dynamic_content' => 'text',
            'show_if'         => ['item_type' => 'Text']
        ];

        $fields['item_image'] = array (
            'label'              => esc_html__( 'Image', 'dipi-divi-pixel' ),
            'type'               => 'upload',
            'upload_button_text' => esc_attr__( 'Upload an image', 'dipi-divi-pixel' ),
            'choose_text'        => esc_attr__( 'Choose an Image', 'dipi-divi-pixel' ),
            'update_text'        => esc_attr__( 'Set As Image', 'dipi-divi-pixel' ),
            'toggle_slug'        => 'main_content',
            'tab_slug'           => 'general',
            'dynamic_content'    => 'image',
            'show_if'            => ['item_type' => 'Image']
        );
        $fields['item_image_alt'] = [
            'label'           => esc_html__( 'Image alt', 'dipi-divi-pixel' ),
            'type'            => 'text',
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'dynamic_content' => 'text',
            'show_if'         => ['item_type' => 'Image']
        ];

        $fields['use_lightbox'] = [
            'label'           => esc_html__( 'Use Lightbox', 'dipi-divi-pixel' ),
            'type'            => 'yes_no_button',
            'option_category' => 'basic_option',
            'options'               => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'show_if'         => ['item_type' => 'Image']
            
        ];
        
        $fields['gallery_ids'] = [
            'label' => esc_html__('Gallery Images For Lightbox', 'dipi-divi-pixel'),
            'type' => 'upload-gallery',
            'option_category' => 'basic_option',
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'show_if'         => [
                'item_type' => 'Image',
                'use_lightbox' => 'on']
        ];

        $fields['item_icon'] = array (
            'label'           => esc_html__( 'Icon', 'dipi-divi-pixel' ),
            'type'            => 'select_icon',
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'dynamic_content' => 'image',
            'show_if'         => ['item_type' => 'Icon']
        );
 

        $fields['price'] = [
            'label'           => esc_html__( 'Price', 'dipi-divi-pixel' ),
            'type'            => 'text',
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'dynamic_content' => 'text',
            'show_if'         => ['item_type' => 'Price']
        ];
        $fields['price_prefix'] = [
            'label'           => esc_html__( 'Price Prefix', 'dipi-divi-pixel' ),
            'type'            => 'text',
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'dynamic_content' => 'text',
            'show_if'         => ['item_type' => 'Price']
        ];
        $fields['price_prefix_placement'] = [
            'default'         => 'top',
            'default_on_front'=> 'top',
            'label'           => esc_html__( 'Prefix Placement', 'dipi-divi-pixel' ),
            'type'            => 'select',
            'option_category' => 'configuration',
            'options'         => array(
                'top' => esc_html__( 'Top', 'dipi-divi-pixel' ),
                'middle'  => esc_html__( 'Middle', 'dipi-divi-pixel' ),
                'bottom'  => esc_html__( 'Bottom', 'dipi-divi-pixel' ) 
            ),
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'show_if'         => ['item_type' => 'Price']
        ];
        $fields['price_suffix'] = [
            'label'           => esc_html__( 'Price Suffix', 'dipi-divi-pixel' ),
            'type'            => 'text',
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'dynamic_content' => 'text',
            'show_if'         => ['item_type' => 'Price']
        ];
        $fields['price_suffix_placement'] = [
            'default'         => 'bottom',
            'default_on_front'=> 'bottom',
            'label'           => esc_html__( 'Suffix Placement', 'dipi-divi-pixel' ),
            'type'            => 'select',
            'option_category' => 'configuration',
            'options'         => array(
                'top' => esc_html__( 'Top', 'dipi-divi-pixel' ),
                'middle'  => esc_html__( 'Middle', 'dipi-divi-pixel' ),
                'bottom'  => esc_html__( 'Bottom', 'dipi-divi-pixel' ) 
            ),
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'show_if'         => ['item_type' => 'Price']
        ];
        $fields['feature_text'] = [
            'label'           => esc_html__( 'Feature Text', 'dipi-divi-pixel' ),
            'type'            => 'text',
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'dynamic_content' => 'text',
            'show_if'         => ['item_type' => 'Feature']
        ];

        $fields['feature_text_tag'] = array(
            'label' => esc_html__('Feature Text Tag', 'dipi-divi-pixel'),
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
            'default' => 'span',
            'toggle_slug' => 'main_content',
            'show_if'         => ['item_type' => 'Feature']
        );

        
         
        $fields['feature_icon'] = array (
            'label'           => esc_html__( 'Feature Icon', 'dipi-divi-pixel' ),
            'type'            => 'select_icon',
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'dynamic_content' => 'image',
            'show_if'         => ['item_type' => 'Feature']
        );        

        $fields['feature_icon_placement'] = [
            'default'         => 'left',
            'default_on_front'=> 'left',
            'label'           => esc_html__( 'Icon Placement', 'dipi-divi-pixel' ),
            'type'            => 'select',
            'option_category' => 'configuration',
            'options'         => array(
                'top' => esc_html__( 'Top', 'dipi-divi-pixel' ),
                'bottom'  => esc_html__( 'Bottom', 'dipi-divi-pixel' ),
                'left'  => esc_html__( 'Left', 'dipi-divi-pixel' ),
                'right'  => esc_html__( 'Right', 'dipi-divi-pixel' ),
            ),
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'show_if'         => ['item_type' => 'Feature']
        ];

        $fields['button_text'] = [
            'label'           => esc_html__( 'Button Text', 'dipi-divi-pixel' ),
            'type'            => 'text',
            'default'         => esc_html__( 'Click Here', 'dipi-divi-pixel' ),
            'option_category' => 'basic_option',
            'description'     => esc_html__( 'Input your desired button text, or leave blank for no button.', 'dipi-divi-pixel' ),
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'dynamic_content' => 'text',
            'show_if'         => ['item_type' => 'Button']
        ];
        $fields['button_url'] = [
            'label'           => esc_html__( 'Button URL', 'dipi-divi-pixel' ),
            'type'            => 'text',
            'dynamic_content' => 'text',
            'option_category' => 'basic_option',
            'description'     => esc_html__( 'Input URL for your button.', 'dipi-divi-pixel' ),
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'show_if'         => ['item_type' => 'Button']
        ];
        $fields['button_url_new_window'] = [
            'default'         => 'off',
            'default_on_front'=> true,
            'label'           => esc_html__( 'Button Link Target', 'dipi-divi-pixel' ),
            'type'            => 'select',
            
            'option_category' => 'configuration',
            'options'         => array(
                'off' => esc_html__( 'In The Same Window', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'In The New Tab', 'dipi-divi-pixel' ),
            ),
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'show_if'         => ['item_type' => 'Button']
        ];

        $fields['ribbon_type'] = [
            'label'   => esc_html__( 'Ribbon Type', 'dipi-divi-pixel' ),
            'default' => 'text',
            'type'    => 'select',
            'options' => [
                'text'  => esc_html__('Text', 'dipi-divi-pixel'),
                'image' => esc_html__('Image', 'dipi-divi-pixel')
            ],
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'dynamic_content' => 'text',
            'show_if'         => ['item_type' => 'Ribbon']
        ];
        $fields['ribbon_text'] = [
            'label'           => esc_html__( 'Ribbon Text', 'dipi-divi-pixel' ),
            'type'            => 'text',
            'default'         => 'text',
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'dynamic_content' => 'text',
            'show_if'         => [
                'item_type'   => 'Ribbon',
                'ribbon_type' => 'text'
            ]
        ];
        $fields['ribbon_image'] = array (
            'label'              => esc_html__( 'Ribbon Image', 'dipi-divi-pixel' ),
            'type'               => 'upload',
            'upload_button_text' => esc_attr__( 'Upload an image', 'dipi-divi-pixel' ),
            'choose_text'        => esc_attr__( 'Choose an Image', 'dipi-divi-pixel' ),
            'update_text'        => esc_attr__( 'Set As Image', 'dipi-divi-pixel' ),
            'toggle_slug'        => 'main_content',
            'tab_slug'           => 'general',
            'dynamic_content'    => 'image',
            'show_if'         => [
                'item_type' => 'Ribbon',
                'ribbon_type' => 'Image'
            ]
        );
        $fields['ribbon_position'] = [
            'label'           => esc_html__( 'Ribbon Position', 'dipi-divi-pixel' ),
            'type'            => 'select',
            'options' => [
                'top_left'    => esc_html__('Top Left', 'dipi-divi-pixel'),
                'top_right'   => esc_html__('Top Right', 'dipi-divi-pixel'),
                'bottom_left'   => esc_html__('Bottom Left', 'dipi-divi-pixel'),
                'bottom_right'   => esc_html__('Bottom Right', 'dipi-divi-pixel')
            ],
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'show_if'         => ['item_type' => 'Ribbon']
        ];

        $fields['ribbon_transform_x'] = [
            'label'             => esc_html__( 'Ribbon Transfrom Horizontal', 'dipi-divi-pixel' ),
            'type'              => 'range',
            'default'           => '0%',
            'default_unit'      => '%',
            'range_settings' => array(
                'min'  => '-100',
                'max'  => '100',
                'step' => '1',
            ),
            'mobile_options'    => true,
            'responsive'        => true,
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'show_if'         => ['item_type' => 'Ribbon']
        ];
        $fields['ribbon_transform_y'] = [
            'label'             => esc_html__( 'Ribbon Transfrom Vertically', 'dipi-divi-pixel' ),
            'type'              => 'range',
            'default'           => '0%',
            'default_unit'      => '%',
            'range_settings' => array(
                'min'  => '-100',
                'max'  => '100',
                'step' => '1',
            ),
            'mobile_options'    => true,
            'responsive'        => true,
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'show_if'         => ['item_type' => 'Ribbon']
        ];
        


        $fields['feature_icon_size'] = [
            'label'             => esc_html__( 'Icon Size', 'dipi-divi-pixel' ),
            'type'              => 'range',
            'default'           => '16px',
            'default_unit'      => 'px',
            'range_settings' => array(
                'min'  => '0',
                'max'  => '200',
                'step' => '1',
            ),
            'mobile_options'    => true,
            'responsive'        => true,
            'toggle_slug'     => 'feature_icon_style',
            'tab_slug'        => 'advanced',
            'show_if'         => ['item_type' => 'Feature']
        ];

        $fields['feature_icon_color'] = [
            
            'label'             => esc_html__( 'Icon Color', 'dipi-divi-pixel' ),
            'type'              => 'color-alpha',
            'mobile_options'    => true,
            'responsive'        => true,
            'toggle_slug'     => 'feature_icon_style',
            'tab_slug'        => 'advanced',
            'show_if'         => ['item_type' => 'Feature']
        ];
        $fields['feature_icon_bg'] = [
            
            'label'             => esc_html__( 'Icon Background Color', 'dipi-divi-pixel' ),
            'type'              => 'color-alpha',
            'mobile_options'    => true,
            'responsive'        => true,
            'toggle_slug'     => 'feature_icon_style',
            'tab_slug'        => 'advanced',
            'show_if'         => ['item_type' => 'Feature']
        ];
        $fields['feature_icon_padding'] = [
            'label' => esc_html__('Feature Icon Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'     => 'feature_icon_style',
            'tab_slug'        => 'advanced'
        ];
        $fields['feature_icon_margin'] = [
            'label' => esc_html__('Feature Icon Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|5px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'     => 'feature_icon_style',
            'tab_slug'        => 'advanced'
        ];
        

        $et_accent_color = et_builder_accent_color();
        $fields['icon_color'] =  array(
            'default'         => $et_accent_color,
            'label'           => esc_html__( 'Icon Color', 'et_builder' ),
            'type'            => 'color-alpha',
            'description'     => esc_html__( 'Here you can define a custom color for your icon.', 'et_builder' ),
            'depends_show_if' => 'on',
            'tab_slug'        => 'advanced',
            'toggle_slug'     => 'icon_settings',
            'hover'           => 'tabs',
            'mobile_options'  => true,
            'sticky'          => true,
        );
        $fields['image_icon_background_color'] = array(
            'label'          => esc_html__( 'Image/Icon Background Color', 'et_builder' ),
            'type'           => 'color-alpha',
            'description'    => esc_html__( 'Here you can define a custom background color.', 'et_builder' ),
            'tab_slug'       => 'advanced',
            'toggle_slug'    => 'icon_settings',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
        );
       
	 
        $fields['image_icon_width'] = array(
            'label'                  => esc_html__( 'Image/Icon Width', 'et_builder' ),
            'toggle_slug'            => 'icon_settings',
            'description'            => esc_html__( 'Here you can choose icon/img width.', 'et_builder' ),
            'type'                   => 'range',
            'range_settings'         => array(
                'min'  => '1',
                'max'  => '200',
                'step' => '1',
            ),
            'option_category'        => 'layout',
            'tab_slug'               => 'advanced',
            'mobile_options'         => true,
            'validate_unit'          => true,
            'allowed_units'          => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
            'responsive'             => true,
            'mobile_options'         => true,
            'sticky'                 => true,
            'default_value_depends'  => array( 'use_icon' ),
            'default_values_mapping' => array(
                'on'  => '96px',
                'off' => '100%',
            ),
        );

        $fields['icon_alignment'] = array(
            'label'           => esc_html__( 'Image/Icon Alignment', 'et_builder' ),
            'description'     => esc_html__( 'Align image/icon to the left, right or center.', 'et_builder' ),
            'type'            => 'align',
            'option_category' => 'layout',
            'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
            'tab_slug'        => 'advanced',
            'toggle_slug'     => 'icon_settings',
            'default'         => 'center',
            'mobile_options'  => true,
            'sticky'          => true
        );
      

        return $fields;
    }

    public function get_transition_fields_css_props(){
        
        $fields = parent::get_transition_fields_css_props();

        $fields['image_icon_width'] = array(
			'font-size' => '%%order_class%% .dipi-pt-image .et_pb_image_wrap',
		);
 
		return $fields;
    }

    public function get_settings_modal_toggles() {
        $toggles = [];
        $toggles['general'] = [
            'toggles' => [
                'main_content' => esc_html__('Item Content', 'dipi-divi-pixel')
            ]
        ];
        $toggles['advanced'] = [
            'toggles' => [
                'price_style' => esc_html__('Price Style', 'dipi-divi-pixel'),
                'feature_icon_style' => esc_html__('Feature Icon Style', 'dipi-divi-pixel'),
                'icon_settings' => esc_html__( 'Image & Icon', 'dipi-divi-pixel' ),
                'heading' => array(
                    'title' => esc_html__('Heading Text', 'dipi-divi-pixel'),
                    'priority' => 49,
                    'tabbed_subtoggles' => true,
                    'sub_toggles' => array(
                        'h1' => array(
                            'name' => 'H1',
                            'icon' => 'text-h1',
                        ),
                        'h2' => array(
                            'name' => 'H2',
                            'icon' => 'text-h2',
                        ),
                        'h3' => array(
                            'name' => 'H3',
                            'icon' => 'text-h3',
                        ),
                        'h4' => array(
                            'name' => 'H4',
                            'icon' => 'text-h4',
                        ),
                        'h5' => array(
                            'name' => 'H5',
                            'icon' => 'text-h5',
                        ),
                        'h6' => array(
                            'name' => 'H6',
                            'icon' => 'text-h6',
                        ),
                    ),
                )
            ]
        ];

       
        $toggles['custom_css'] = [
                'toggles' => [
                    'classes' => esc_html__('CSS ID & Classes', 'dipi-divi-pixel'),
                ]
            ];
         
        
        return $toggles;
    }

    public function get_custom_css_fields_config() {
        $fields = [];
 
        
        return $fields;
    }
  
    public function get_advanced_fields_config() {
        $advanced_fields['text'] = [
            'label' => esc_html__('Text', 'dipi-divi-pixel'),
            'options' => [
                'text_orientation' => [
                    'default' => '',
                    'default_on_front' => ''
                    ]
                ],
            'css'   => array(
                'main'  => "%%order_class%% .et_pb_module_inner .dipi-pt-text, %%order_class%% .dipi-pt-feature .dipi-pt-feature-text, %%order_class%% .dipi-pt-price-container",
                'text_orientation'  => "%%order_class%% .et_pb_module_inner .dipi-pt-text, %%order_class%% .dipi-pt-feature .dipi-pt-feature-text,%%order_class%% .dipi-pt-price-container"
            ) 
        ];
        $advanced_fields['fonts']["default"] = [
            'label' => esc_html__('Module', 'dipi-divi-pixel'),
            'css'   => array(
                'main'  => "%%order_class%% .dipi-pt-text, %%order_class%% .dipi-pt-price, %%order_class%% .dipi-pt-ribbon-txt, %%order_class%% .dipi-pt-icon, 
                %%order_class%% .dipi-pt-feature .dipi-pt-feature-text",
                'hover' => "%%order_class%% .dipi-pt-text:hover, %%order_class%% .dipi-pt-price:hover, %%order_class%%:hover .dipi-pt-ribbon-txt, %%order_class%% .dipi-pt-icon:hover, %%order_class%% .dipi-pt-feature .dipi-pt-feature-text:hover",
                'important' => true
            ) 
        ];

        $advanced_fields["fonts"]["header"] = [
            'label' => esc_html__('Heading', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%% .dipi-pt-text h1",
            ),
            'font_size' => array(
                'default' => absint(et_get_option('body_header_size', '30')) . 'px',
            ),
            'toggle_slug' => 'heading',
            'sub_toggle' => 'h1',
        ];
        $advanced_fields["fonts"]["header_2"] = [
            'label' => esc_html__('Heading 2', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%% .dipi-pt-text h2",
            ),
            'font_size' => array(
                'default' => '26px',
            ),
            'line_height' => array(
                'default' => '1em',
            ),
            'toggle_slug' => 'heading',
            'sub_toggle' => 'h2',
        ];
        $advanced_fields["fonts"]["header_3"] = [
            'label' => esc_html__('Heading 3', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%% .dipi-pt-text h3",
            ),
            'font_size' => array(
                'default' => '22px',
            ),
            'line_height' => array(
                'default' => '1em',
            ),
            'toggle_slug' => 'heading',
            'sub_toggle' => 'h3',
        ];
        $advanced_fields["fonts"]["header_4"] = [
            'label' => esc_html__('Heading 4', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%% .dipi-pt-text h4",
            ),
            'font_size' => array(
                'default' => '18px',
            ),
            'line_height' => array(
                'default' => '1em',
            ),
            'toggle_slug' => 'heading',
            'sub_toggle' => 'h4',
        ];
        $advanced_fields["fonts"]["header_5"] = [
            'label' => esc_html__('Heading 5', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%% .dipi-pt-text h5",
            ),
            'font_size' => array(
                'default' => '16px',
            ),
            'line_height' => array(
                'default' => '1em',
            ),
            'toggle_slug' => 'heading',
            'sub_toggle' => 'h5',
        ];
        $advanced_fields["fonts"]["header_6"] = [
            'label' => esc_html__('Heading 6', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%% .dipi-pt-text h6",
            ),
            'font_size' => array(
                'default' => '14px',
            ),
            'line_height' => array(
                'default' => '1em',
            ),
            'toggle_slug' => 'heading',
            'sub_toggle' => 'h6',
        ];
        $advanced_fields["fonts"]["content_title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-hover-box-content .dipi-hover-box-heading",
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'content_text',
            'sub_toggle' => 'title',
            'header_level' => [
                'default' => 'h2',
            ],
            'line_height' => [
                'range_settings' => [
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ],
            ],
        ];
        
        $advanced_fields['fonts']["prefix"] = [
            'label' => esc_html__('Prefix', 'dipi-divi-pixel'),
            'css'   => array(
                'main'  => "%%order_class%% .dipi-pt-price-prefix",
                'hover' => "%%order_class%% .dipi-pt-price-prefix:hover"
            ) 
        ];
        $advanced_fields['fonts']["suffix"] = [
            'label' => esc_html__('Suffix', 'dipi-divi-pixel'),
            'css'   => array(
                'main'  => "%%order_class%% .dipi-pt-price-suffix",
                'hover' => "%%order_class%% .dipi-pt-price-suffix:hover"
            ) 
        ];
        $advanced_fields['button']["button"] = [
            'label'    => esc_html__('Button', 'dipi-divi-pixel'),
            
            'css' => [
                'main' => "%%order_class%% .dipi-pt-btn",
                'alignment' => "%%order_class%% .dipi-pt-btn-wrap",
                'limited_main' => "%%order_class%% .dipi-pt-btn",
                'important' => true,
            ],
            'box_shadow'  => [
                'css' => [
                    'main' => "%%order_class%% .dipi-pt-btn",
                    'important' => true,
                ],
            ],
            'use_alignment' => true,
            'margin_padding' => [
                'css' => [
                    'main' => "%%order_class%% .et_pb_button.dipi-pt-btn",
                    'important' => 'all',
                ],
            ],
            'show_if' => ['item_type' => 'Button']
        ];

        $advanced_fields['borders']['default'] =[
            'css'               => array(
                'main' => array(
                    'border_radii' => "%%order_class%%",
                    'border_radii_hover'  => "%%order_class%%:hover",
                    'border_styles' => "%%order_class%%",
                    'border_styles_hover' => "%%order_class%%:hover",
                ),
            )
        ];
          
        $advanced_fields['borders']['feature_icon'] = [
            'css' => array(
                'main' => array(
                    'border_radii' => "%%order_class%% .dipi-pt-feature-icon",
                    'border_radii_hover' => "%%order_class%% .dipi-pt-feature-icon:hover",
                    'border_styles' => "%%order_class%% .dipi-pt-feature-icon",
                    'border_styles_hover' => "%%order_class%% .dipi-pt-feature-icon:hover",
                )
            ),
            'tab_slug'        => 'advanced',
            'toggle_slug'     => 'feature_icon_style',
            'label_prefix'      => esc_html__("Feature Icon", 'dipi-divi-pixel')
        ];

        $advanced_fields['borders']['image'] = array(
            'css'          => array(
                'main' => array(
                    'border_radii'        => '%%order_class%% .dipi-pt-image .et_pb_image_wrap, %%order_class%% .dipi-pt-icon .et_pb_image_wrap',
                    'border_radii_hover'  => '%%order_class%%:hover .dipi-pt-image .et_pb_image_wrap, %%order_class%%:hover .dipi-pt-icon .et_pb_image_wrap',
                    'border_styles'       => '%%order_class%% .dipi-pt-image .et_pb_image_wrap, %%order_class%% .dipi-pt-icon .et_pb_image_wrap',
                    'border_styles_hover' => '%%order_class%%:hover .dipi-pt-image .et_pb_image_wrap, %%order_class%%:hover .dipi-pt-icon .et_pb_image_wrap',
                ),
            ),
            'label_prefix' => et_builder_i18n( 'Image/Icon' ),
            'tab_slug'     => 'advanced',
            'toggle_slug'  => 'icon_settings',
        );

        

        $advanced_fields['image_icon'] =   array(
            'image_icon' => array(
                'margin_padding'  => array(
                    'css' => array(
                        'important' => 'all',
                    ),
                ),
                'option_category' => 'layout',
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'icon_settings',
                'label'           => et_builder_i18n( 'Image/Icon' ),
                'css'             => array(
                    'padding' => '%%order_class%% .dipi-pt-image .et_pb_image_wrap, %%order_class%% .dipi-pt-icon .et_pb_image_wrap',
                    'margin'  => '%%order_class%% .dipi-pt-image .et_pb_image_wrap, %%order_class%% .dipi-pt-icon .et_pb_image_wrap',
                    'main'    => '%%order_class%% .dipi-pt-image .et_pb_image_wrap, %%order_class%% .dipi-pt-icon .et_pb_image_wrap',
                ),
            ),
        );

        $advanced_fields['box_shadow'] = [
            'default'   => [],
            'feature_icon' => [
                'css' => array(
                    'main' => "%%order_class%% .dipi-pt-feature-icon",
                    'hover' => "%%order_class%% .dipi-pt-feature-icon:hover",
                ),
                'tab_slug'    => 'advanced',
                'toggle_slug'     => 'feature_icon_style' 
            ],
            'image'   => array(
                'label'             => esc_html__( 'Image Box Shadow', 'et_builder' ),
                'option_category'   => 'layout',
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'icon_settings',
                'css'               => array(
                    'main'        => '%%order_class%% .dipi-pt-image .et_pb_image_wrap,%%order_class%% .dipi-pt-icon .et_pb_image_wrap',
                    'hover'       => '%%order_class%%:hover .dipi-pt-image .et_pb_image_wrap,%%order_class%% .dipi-pt-icon .et_pb_image_wrap',
                    'show_if_not' => array(
                        'use_icon' => 'on',
                    ),
                    'overlay'     => 'inset',
                ),
                'default_on_fronts' => array(
                    'color'    => '',
                    'position' => '',
                ),
            ),
        ];
        $advanced_fields['margin_padding'] = [
            'css' => [
                'margin'  => '.et_pb_section div.et_pb_row .et_pb_column .dipi_pricing_table %%order_class%%.et_pb_module.dipi_pricing_table_item, .dipi_pricing_table %%order_class%%.et_pb_module.dipi_pricing_table_item',
                'padding' => '.et_pb_section div.et_pb_row .et_pb_column .dipi_pricing_table %%order_class%%.et_pb_module.dipi_pricing_table_item, .dipi_pricing_table %%order_class%%.et_pb_module.dipi_pricing_table_item',
                'important' => 'all',   
            ]
        ];
        return $advanced_fields;
    }

    public function render_text() {
        
        return sprintf('
            <div class="dipi-pt-text">%1$s</div>',
            $this->process_content($this->props['text_content'])
        );
    }

    public function render_price() {
        return sprintf('
        <div class="dipi-pt-price-container">
        <span class="dipi-pt-price-prefix">%1$s</span>
        <span class="dipi-pt-price">%2$s</span><span class="dipi-pt-price-suffix">%3$s</span>
        </div>',
            $this->props['price_prefix'],
            $this->props['price'],
            $this->props['price_suffix']
        );
    }

    public function render_gallery_items() {
        $items = [];
        $attachment_ids = explode(",", $this->props["gallery_ids"]);
       
        //Check which image sizes to use
        
        foreach ($attachment_ids as $attachment_id) {
            $attachment = wp_get_attachment_image_src($attachment_id, "full");
            if(!$attachment){
                continue;
            }
         
            $image = $attachment[0];
            $image_title = get_the_title($attachment_id);

            $items[] = sprintf(
                '<div class="dipi-pt-gallery-item" href="%1$s" %2$s%3$s ></div>',
                $image,
                " data-title='$image_title'" ,
                " data-caption='" . htmlspecialchars(wp_get_attachment_caption($attachment_id)) . "'"
            );
            
        }
        return implode("", $items);
    }

    public function render_item_image($render_slug) {
        
        $alt = isset($this->props['item_image_alt']) ? $this->props['item_image_alt'] : '';

        $multi_view = et_pb_multi_view_options( $this );
        $image_url = $this->props['item_image'];

        $image = $multi_view->render_element(
            array(
                'tag'      => 'img',
                'attrs'    => array(
                    'src'   => '{{item_image}}',
                    'class' => '',
                    'alt'   => $alt,
                ),
                'required' => 'item_image',
            )
        );
        if(isset($this->props['use_lightbox']) && $this->props['use_lightbox'] === 'on') {
            $gallery_items = $this->render_gallery_items();
            return sprintf('
                <div class="dipi-pt-image">
                    <div class="et_pb_image_wrap dipi-pt-gallery-item" href="%2$s">%1$s</div>
                    <div class="dipi-pt-gallery">
                        %3$s
                    </div>
                </div>',
                $image,
                $image_url,
                $gallery_items
            );
        } else {
            return sprintf('
                <div class="dipi-pt-image">
                    <span class="et_pb_image_wrap">%1$s</span>
                </div>',
                $image 
            );
        }
    }

    public function render_feature() {
        $icon_placement = $this->props['feature_icon_placement'];
        $feature_icon_code = $this->props['feature_icon'];
        $feature_icon = et_pb_process_font_icon($feature_icon_code);

        $icon_render = sprintf('<span class="et-pb-icon dipi-pt-feature-icon">%1$s</span>', $feature_icon);
        $output = sprintf('<div class="dipi-pt-feature">');
        if($icon_placement === 'top' || $icon_placement === 'left'){
            $output .= $icon_render;     
        }
        $feature_text_tag = $this->props['feature_text_tag'] ? $this->props['feature_text_tag'] : 'span';

        $output .= sprintf('<%2$s class="dipi-pt-feature-text">%1$s</%2$s>', $this->props['feature_text'], $feature_text_tag);     
        if($icon_placement === 'bottom' || $icon_placement === 'right'){
            $output .= $icon_render;     
        }
        $output .= sprintf('</div>');
        return $output;   
    }

    public function render_icon($render_slug) {
        
        $icon_code = $this->props['item_icon'];
        $icon = et_pb_process_font_icon($icon_code);
        $this->dipi_generate_font_icon_styles(
            $render_slug,
            'item_icon',
            '%%order_class%% .dipi-pt-icon .et_pb_image_wrap .et-pb-icon'
        );
       
        return sprintf('
            <div class="dipi-pt-icon">
                <div class="et_pb_image_wrap">
                    <span class="et-pb-icon">%1$s</span>
                </div>
            </div>' , 
            $icon 
        );   
    }

    public function render_ribbon() {
         
        $ribbon_text = $this->props['ribbon_text'];
        return sprintf('<div class="dipi-pt-ribbon-txt">%1$s</div>' , 
            $ribbon_text
        );
    }

    public function render_item_button () {
        $button_text = $this->props['button_text'];
        $button_target = 'new_window' === $this->props['button_url_new_window'] ? 'on' : 'off';
        $button_icon = $this->props['button_icon'];
        $button_link = $this->props['button_url'];
        $button_rel = $this->props['button_rel'];

        $custom_icon_values = et_pb_responsive_options()->get_property_values( $this->props, 'button_icon' );
        $custom_icon        = isset( $custom_icon_values['desktop'] ) ? $custom_icon_values['desktop'] : '';
        $custom_icon_tablet = isset( $custom_icon_values['tablet'] ) ? $custom_icon_values['tablet'] : '';
        $custom_icon_phone  = isset( $custom_icon_values['phone'] ) ? $custom_icon_values['phone'] : '';
        
       $output = '<div class="dipi-pt-btn-wrap">';
       $output .= $this->render_button([
            'button_classname' => ["dipi-pt-btn"],
            'button_custom' => $this->props['custom_button'],
            'button_rel' => $button_rel,
            'button_text' => $button_text,
            'button_url' => $button_link,
            'custom_icon' => $custom_icon,
            'custom_icon_tablet' => $custom_icon_tablet,
            'custom_icon_phone' => $custom_icon_phone,
            'has_wrapper' => false,
            'url_new_window' => $button_target,
        ]);
        $output .= '</div>';
        return $output;
    }

    public function _icon_style ($render_slug) {
        $icon_selector = '%%order_class%% .dipi-pt-icon .et_pb_image_wrap';
        $this->generate_styles(
            array(
                'base_attr_name' => 'icon_color',
                'selector'       => $icon_selector,
                'css_property'   => 'color',
                'render_slug'    => $render_slug,
                'type'           => 'color',
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'image_icon_background_color',
                'selector'       => $icon_selector,
                'css_property'   => 'background-color',
                'render_slug'    => $render_slug,
                'type'           => 'color',
            )
        );

        $this->process_range_field_css( array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_icon_width',
            'type'              => 'font-size',
            'selector'          => $icon_selector . ' .et-pb-icon',
            'important'         => true
        ) );

        $icon_alignment_values = $this->dipi_get_responsive_prop('icon_alignment', 'center');
        $flex_alignments = [
            'left'   => 'flex-start',
            'center' => 'center',
            'right'  => 'flex-end'
        ];
        foreach($icon_alignment_values as $key => $value) {
            $icon_alignment_values[$key] = $flex_alignments[$value];
        }
      
        $this->set_responsive_css($render_slug, '%%order_class%% .dipi-pt-icon', 'justify-content', $icon_alignment_values);
         
      
  

      
    }
    public function _image_style ($render_slug) {
        $this->process_range_field_css( array(
            'render_slug'       => $render_slug,
            'slug'              => 'image_icon_width',
            'type'              => 'width',
            'selector'          => '%%order_class%% .dipi-pt-image .et_pb_image_wrap',
            'important'         => true
        ) );
        $icon_alignment_values = $this->dipi_get_responsive_prop('icon_alignment',  'center');
        $flex_alignments = [
            'left'   => 'flex-start',
            'center' => 'center',
            'right'  => 'flex-end'
        ];
        foreach($icon_alignment_values as $key => $value) {
            $icon_alignment_values[$key] = $flex_alignments[$value];
        }
      
        $this->set_responsive_css($render_slug, '%%order_class%% .dipi-pt-image', 'justify-content', $icon_alignment_values);
         
      
    }

    public function _feature_style($render_slug) {

        $this->process_range_field_css( array(
            'render_slug'       => $render_slug,
            'slug'              => 'feature_icon_size',
            'type'              => 'font-size',
            'selector'          => '%%order_class%% .dipi-pt-feature .dipi-pt-feature-icon',
            'important'         => true
        ) );

        $this->dipi_generate_font_icon_styles(
            $render_slug,
            'feature_icon',
            "%%order_class%% .dipi-pt-feature .dipi-pt-feature-icon"
        );
        $icon_placement = isset($this->props['feature_icon_placement']) && !empty ($this->props['feature_icon_placement']) ? $this->props['feature_icon_placement'] : 'left';
        $flex_direction = [
            'top' => 'column',
            'bottom' => 'column',
            'left' => 'row',
            'right' => 'row'
        ];
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .dipi-pt-feature',
            'declaration' => sprintf('flex-direction: %1$s;align-items: center;', $flex_direction[$icon_placement])
        ));

        $orientation = [
            'left' => 'flex-start',
            'center' => 'center',
            'right' => 'flex-end'
        ];
        $text_orientation = (isset($this->props['text_orientation']) && !empty($this->props['text_orientation'])) ? $this->props['text_orientation'] : 'center';
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .dipi-pt-feature',
            'declaration' => sprintf('justify-content: %1$s;', $orientation[$text_orientation])
        ));

        $this->process_color_field_css(array(
            'render_slug'       => $render_slug,
            'slug'              => 'feature_icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .dipi-pt-feature-icon',
            'hover'             => '%%order_class%% .dipi-pt-feature-icon:hohver',
            'important'         => true
        ));

        $this->process_color_field_css(array(
            'render_slug'       => $render_slug,
            'slug'              => 'feature_icon_bg',
            'type'              => 'background-color',
            'selector'          => '%%order_class%% .dipi-pt-feature-icon',
            'hover'             => '%%order_class%% .dipi-pt-feature-icon:hover',
            'important'         => true
        ));

        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'feature_icon_padding',
            'css_property'   => 'padding',
            'selector'       => '%%order_class%% .dipi-pt-feature-icon',
            'hover_selector' => '%%order_class%% .dipi-pt-feature-icon:hover'
        ]);

        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'feature_icon_margin',
            'css_property'   => 'margin',
            'selector'       => '%%order_class%% .dipi-pt-feature-icon',
            'hover_selector' => '%%order_class%% .dipi-pt-feature-icon:hover'
        ]);
        
    }

    public function _ribbon_style($render_slug) {
        $ribbon_transform_x = (isset($this->props['ribbon_transform_x']) && !empty($this->props['ribbon_transform_x']))? $this->props['ribbon_transform_x'] : '0%'; 
        $ribbon_transform_x_tablet = (isset($this->props['ribbon_transform_x_tablet']) && !empty($this->props['ribbon_transform_x_tablet']))? $this->props['ribbon_transform_x_tablet'] : $ribbon_transform_x; 
        $ribbon_transform_x_phone = (isset($this->props['ribbon_transform_x_phone']) && !empty($this->props['ribbon_transform_x_phone']))? $this->props['ribbon_transform_x_phone'] : $ribbon_transform_x_tablet; 
        $ribbon_transform_y = (isset($this->props['ribbon_transform_y']) && !empty($this->props['ribbon_transform_y']))? $this->props['ribbon_transform_y'] : '0%'; 
        $ribbon_transform_y_tablet = (isset($this->props['ribbon_transform_y_tablet']) && !empty($this->props['ribbon_transform_y_tablet']))? $this->props['ribbon_transform_y_tablet'] : $ribbon_transform_y; 
        $ribbon_transform_y_phone = (isset($this->props['ribbon_transform_y_phone']) && !empty($this->props['ribbon_transform_y_phone']))? $this->props['ribbon_transform_y_phone'] : $ribbon_transform_y_tablet; 
    
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%',
            'declaration' => sprintf('position: absolute !important;transform: translate(%1$s, %2$s) !important;', $ribbon_transform_x, $ribbon_transform_y)
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%',
            'declaration' => sprintf('transform: translate(%1$s, %2$s) !important;', $ribbon_transform_x_tablet, $ribbon_transform_y_tablet),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%',
            'declaration' => sprintf('transform: translate(%1$s, %2$s) !important;', $ribbon_transform_x_phone, $ribbon_transform_y_phone),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767')
        ));

        $ribbon_position = $this->props['ribbon_position'];
        $postion_styles = [
            'top_left'     => 'top:0;left:0;bottom:auto;right:auto;',
            'top_right'    => 'top:0;right:0;bottom:auto;left:auto;',
            'bottom_left'  => 'bottom:0;left:0;top:auto;right:auto;',
            'bottom_right' => 'bottom:0;right:0;top:auto;left:auto;'
        ];
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%',
            'declaration' => $postion_styles[$ribbon_position]
        ));
    }

    public function _price_style($render_slug) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .dipi-pt-price-prefix',
            'declaration' => sprintf('vertical-align: %1$s;', $this->props['price_prefix_placement']),
        ));
    }

    public function _apply_css($render_slug) {
       
        $item_type = $this->props['item_type'];
         
        switch ($item_type) {
            case 'Text':
                 
                break;
            case 'Price':
                $this->_price_style($render_slug);
                break;
            case 'Image':
                $this->_image_style ($render_slug);
                break;
            case 'Feature':
                $this->_feature_style($render_slug);
                break;
            case 'Icon':
                $this->_icon_style ($render_slug);
                break;
            case 'Ribbon':
                $this->_ribbon_style($render_slug);
                break;
            case 'Button':
                
                break;
            default:
            break;
        }

       
    }

    public function render($attrs, $content, $render_slug) {
        $use_lightbox = (isset($this->props['use_lightbox']) && !empty($this->props['use_lightbox'])) ? $this->props['use_lightbox'] : 'off';
        if( $use_lightbox === 'on' ) {
            wp_enqueue_script('dipi_pricing_table');
        }
        $this->_apply_css($render_slug);
        wp_enqueue_style('dipi_animate');
        $item_type = $this->props['item_type'];
        $content = '';
        switch ($item_type) {
            case 'Text':
                $content = $this->render_text();
                break;
            case 'Price':
                $content = $this->render_price();
                break;
            case 'Image':
                $content = $this->render_item_image($render_slug);
                break;
            case 'Feature':
                $content = $this->render_feature();
                break;
            case 'Icon':
                $content = $this->render_icon($render_slug);
                break;
            case 'Ribbon':
                $content = $this->render_ribbon();
                break;
            case 'Button':
                $content = $this->render_item_button();
                break;
            default:
            break;
        }

        
        return $content;

    }
   
}

new DIPI_PricingTableItem;
