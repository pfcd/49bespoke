<?php

class DIPI_TableMakerChild extends DIPI_Builder_Module
{
    public function init()
    {
      $this->name = esc_html__('Pixel Table Maker Item', 'dipi-divi-pixel');
      $this->plural = esc_html__('Pixel Table Maker Items', 'dipi-divi-pixel');
      $this->slug = 'dipi_table_maker_child';
      $this->vb_support = 'on';
      $this->type = 'child';
      $this->child_title_var = 'admin_label';
      $this->child_title_fallback_var = 'content_title';
      //$this->advanced_setting_title_text = esc_html__('New Cell', 'dipi-divi-pixel');
      $this->settings_text = esc_html__('Cell Settings', 'dipi-divi-pixel');
      $this->main_css_element = '%%order_class%%';
      //$this->custom_css_tab  = false;
    }
    public function get_settings_modal_toggles()
    {
      return [
        'general' => [
          'toggles' => [
              'content' => esc_html__('Content', 'dipi-divi-pixel'),
              'settings' => esc_html__('Settings', 'dipi-divi-pixel'),
          ],
        ],
        'advanced' => [
          'toggles' => [
            'content_image_icon' => esc_html__('Image & Icon', 'dipi-divi-pixel'),
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
                'title' => esc_html__('Cell Text', 'dipi-divi-pixel'),
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
      //$advanced_fields['link_options'] = false;
      $advanced_fields['max_width'] = true;
      $advanced_fields['text'] = false;
      //$advanced_fields['borders'] = false;
      //$advanced_fields['box_shadow'] = false;
      //$advanced_fields['filters'] = false;
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
      // $advanced_fields['image_icon'] = false;
      $advanced_fields['dividers'] = false;
      $advanced_fields['text_shadow'] = false;
      $advanced_fields['image'] = false;
      $advanced_fields['icon_settings'] = false;
      $advanced_fields['child_filters'] = false;
      $advanced_fields['transition'] = false;

      $main_selector = ".dipi_table_maker %%order_class%%.dipi_table_maker_child.dipi-cell";
      $content_selector = ".dipi_table_maker %%order_class%%.dipi_table_maker_child.dipi-cell .dipi_table_item-content-wrapper .dipi_table_item-content";
      $content_icon_selector = ".dipi_table_maker %%order_class%%.dipi_table_maker_child.dipi-cell .dipi-content-image-icon-wrap .et-pb-icon";
      $content_image_icon_selector = ".dipi_table_maker %%order_class%%.dipi_table_maker_child.dipi-cell  .dipi-content-image-icon-wrap";
      $content_image_icon_hover_selector = ".dipi_table_maker %%order_class%%.dipi_table_maker_child.dipi-cell:hover .dipi-content-image-icon-wrap";
      $content_image_icon_width_selector = ".dipi_table_maker %%order_class%%.dipi_table_maker_child.dipi-cell .dipi-content-image-icon-wrap.dipi-image-wrapper";
      $content_title_selector = ".dipi_table_maker %%order_class%%.dipi_table_maker_child.dipi-cell .dipi-content-heading";
      $content_desc_selector = ".dipi_table_maker %%order_class%%.dipi_table_maker_child.dipi-cell .dipi-desc";

      $advanced_fields["box_shadow"]["default"] = [
        'css' => [
            'main' => $main_selector,
        ],
      ];
      $advanced_fields["borders"]["default"] = [
        'css' => [
            'main' => [
                'border_radii' => $main_selector,
                'border_styles' => $main_selector,
            ],

        ],
      ];
      $advanced_fields["background"] = [
        'css' => [
            'main' => $main_selector,
            'pattern' => $main_selector . ' .et_pb_background_pattern',
            'mask' => $main_selector . ' .et_pb_background_mask',
        ],
      ];
      $advanced_fields["margin_padding"] = [
        'css' => [
            'padding' => $main_selector,
            'margin' => $main_selector,
            'important' => 'all',
        ],
      ];
      $advanced_fields["fonts"]["content_title"] = [
        'label' => esc_html__('Title', 'dipi-divi-pixel'),
        'css' => [
            'main' => $content_title_selector,
        ],
        'important' => 'all',
        'hide_text_align' => false,
        'toggle_slug' => 'content_text',
        'sub_toggle' => 'title',
        'header_level' => [
            'default' => 'h2',
        ],
        'font' => [
            'default' => '||||||||'
        ],
        'letter_spacing' => [
            'default' => '',
        ],
        'line_height' => [
            'default' => '',
            'range_settings' => [
                'default' => '',
                'min' => '1',
                'max' => '3',
                'step' => '0.1',
            ],
        ],
      ];
      $advanced_fields["fonts"]["header"] = [
        'label' => esc_html__('Heading', 'dipi-divi-pixel'),
        'css' => array(
            'main' => "%%order_class%%.dipi_table_maker_child h1",
        ),
        'font_size' => array(
            'default' => absint(et_get_option('body_header_size', '30')) . 'px',
        ),
        'toggle_slug' => 'header',
        'sub_toggle' => 'h1',
      ];
      $advanced_fields["fonts"]["header_2"] = [
        'label' => esc_html__('Heading 2', 'dipi-divi-pixel'),
        'css' => array(
            'main' => "%%order_class%%.dipi_table_maker_child h2",
        ),
        'font_size' => array(
            'default' => '26px',
        ),
        'line_height' => array(
            'default' => '1em',
        ),
        'toggle_slug' => 'header',
        'sub_toggle' => 'h2',
      ];
      $advanced_fields["fonts"]["header_3"] = [
        'label' => esc_html__('Heading 3', 'dipi-divi-pixel'),
        'css' => array(
            'main' => "%%order_class%%.dipi_table_maker_child h3",
        ),
        'font_size' => array(
            'default' => '22px',
        ),
        'line_height' => array(
            'default' => '1em',
        ),
        'toggle_slug' => 'header',
        'sub_toggle' => 'h3',
      ];
      $advanced_fields["fonts"]["header_4"] = [
        'label' => esc_html__('Heading 4', 'dipi-divi-pixel'),
        'css' => array(
            'main' => "%%order_class%%.dipi_table_maker_child h4",
        ),
        'font_size' => array(
            'default' => '18px',
        ),
        'line_height' => array(
            'default' => '1em',
        ),
        'toggle_slug' => 'header',
        'sub_toggle' => 'h4',
      ];
      $advanced_fields["fonts"]["header_5"] = [
        'label' => esc_html__('Heading 5', 'dipi-divi-pixel'),
        'css' => array(
            'main' => "%%order_class%%.dipi_table_maker_child h5",
        ),
        'font_size' => array(
            'default' => '16px',
        ),
        'line_height' => array(
            'default' => '1em',
        ),
        'toggle_slug' => 'header',
        'sub_toggle' => 'h5',
      ];
      $advanced_fields["fonts"]["header_6"] = [
        'label' => esc_html__('Heading 6', 'dipi-divi-pixel'),
        'css' => array(
            'main' => "%%order_class%%.dipi_table_maker_child h6",
        ),
        'font_size' => array(
            'default' => '14px',
        ),
        'line_height' => array(
            'default' => '1em',
        ),
        'toggle_slug' => 'header',
        'sub_toggle' => 'h6',
      ];
      $advanced_fields["fonts"]["content_desc"] = [
        'label' => esc_html__('Description', 'dipi-divi-pixel'),
        'css' => [
            'main' => $content_desc_selector,
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
      $advanced_fields['button']["content_button"] = [
        'label' => esc_html__('Content Button', 'dipi-divi-pixel'),
        'use_alignment' => true,
        'font_size' => array(
            'default' => '14px',
        ),
        'css' => [
            'main' => "%%order_class%%.dipi_table_maker_child .dipi_content_button.et_pb_button",
            'important' => true,
        ],
        'box_shadow' => [
            'css' => [
                'main' => "%%order_class%%.dipi_table_maker_child .dipi_content_button.et_pb_button",
                'important' => true,
            ],
        ],
        'margin_padding' => [
            'css' => [
                'margin' => "%%order_class%%.dipi_table_maker_child .dipi_content_button.et_pb_button",
                'padding' => "%%order_class%%.dipi_table_maker_child .dipi_content_button.et_pb_button",
                'important' => 'all',
            ],
        ],
      ];
      /* Content Image & Icon */
      $advanced_fields['borders']['content_image'] = [
        'css' => [
            'main' => [
                'border_radii' => $content_image_icon_selector,
                'border_radii_hover' => $content_image_icon_hover_selector,
                'border_styles' => $content_image_icon_selector,
                'border_styles_hover' => $content_image_icon_hover_selector,
            ],
        ],
        'label_prefix' => et_builder_i18n('Image & Icon'),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'content_image_icon',
        'hover' => 'tabs',
      ];

      $advanced_fields['box_shadow']['content_image'] = [
        'label' => esc_html__('Image Box Shadow', 'dipi-divi-pixel'),
        'option_category' => 'layout',
        'tab_slug' => 'advanced',
        'css' => [
            'main' => $content_image_icon_selector,
            'overlay' => 'inset',
        ],
        'tab_slug' => 'advanced',
        'toggle_slug' => 'content_image_icon',
        'hover' => 'tabs',
      ];

      $advanced_fields["image_icon"]["image_icon"] = [
        'margin_padding' => [
            'css' => [
                'important' => 'all',
            ],
        ],
        'option_category' => 'layout',
        'tab_slug' => 'advanced',
        'toggle_slug' => 'content_image_icon',
        'label' => et_builder_i18n('Image & Icon'),
        'css' => [
            'main' => $content_image_icon_selector,
            'hover' => $content_image_icon_hover_selector,
            'important' => 'all',
        ],
      ];
      $advanced_fields["icon_settings"] = [/* Need this setting to apply filter */
        'css' => [
            'main' => $content_image_icon_selector,
        ],
      ];

      $advanced_fields['max_width'] = [
        'css' => [
            'main' => $main_selector,
        ],
        'use_height' => true,
        'use_max_height' => true,
        'use_module_alignment' => true,
    ];
    $advanced_fields['height'] = [
        'css' => [
            'main' => $main_selector,
        ],
        'use_height' => true,
        'use_max_height' => true,
        'options' => [
            'height' => [
                'default' => '',
            ],
            'max_height' => [
              'default' => '',
            ],
            'min_height' => [
              'default' => '',
            ]
          ],
    ];
      $advanced_fields["filters"]['child_filters_target'] = [
        'tab_slug' => 'advanced',
        'toggle_slug' => 'content_image_icon',
        'label' => esc_html__('Image & Icon', 'dipi-divi-pixel'),
        'css' => array(
            'main' => $content_image_icon_selector,
        ),
      ];

      return $advanced_fields;
    }
    public function get_custom_css_fields_config() {
      $custom_css_fields = [];
      
      return $custom_css_fields;
    }
    public function get_fields()
    {
      $et_accent_color = et_builder_accent_color();
      $image_icon_placement = array(
        'parent' => esc_html__('Parent Setting', 'dipi-divi-pixel'),
        'top' => esc_html__('Top', 'dipi-divi-pixel'),
      );
  
      if (!is_rtl()) {
        $image_icon_placement['left'] = esc_html__('Left', 'dipi-divi-pixel');
      } else {
        $image_icon_placement['right'] = esc_html__('Right', 'dipi-divi-pixel');
      }
      $fields = [];
      $fields['admin_label'] = [
        'label'            => esc_html__( 'Admin Label', 'dipi-divi-pixel' ),
        'type'             => 'text',
        'option_category'  => 'basic_option',
        'toggle_slug'      => 'admin_label',
        'tab_slug'         => 'general',
        'default_on_front' => ''
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
      $fields["use_content_icon"] = [
        'label' => esc_html__('Use Icon', 'dipi-divi-pixel'),
        'type' => 'yes_no_button',
        'default' => 'off',
        'options' => [
            'off' => esc_html__('No', 'dipi-divi-pixel'),
            'on' => esc_html__('Yes', 'dipi-divi-pixel'),
        ],
        'toggle_slug' => 'content',
      ];

      $fields['content_image'] = [
        'type' => 'upload',
        'hide_metadata' => true,
        'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
        'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
        'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
        'description' => esc_html__('Upload an info image to show in the content.', 'dipi-divi-pixel'),
        'show_if' => [
            'use_content_icon' => 'off',
        ],
        'toggle_slug' => 'content',
        'dynamic_content' => 'image'
      ];

      $fields['content_icon'] = [
        'label' => esc_html__('Icon', 'dipi-divi-pixel'),
        'type' => 'select_icon',
        'class' => ['et-pb-font-icon'],
        'default' => '5',
        'show_if' => ['use_content_icon' => 'on'],
        'toggle_slug' => 'content',
      ];

      $fields["content_title"] = [
        'label' => esc_html__('Title', 'dipi-divi-pixel'),
        'type' => 'text',
        'toggle_slug' => 'content',
        'dynamic_content' => 'text',
        'mobile_options'  => true,
      ];

      $fields["content"] = [
        'label' => esc_html__('Description', 'dipi-divi-pixel'),
        'type' => 'tiny_mce',
        'toggle_slug' => 'content',
        'dynamic_content' => 'text',
        'mobile_options'  => true,
        'responsive'   => true,
        'hover' => 'tabs',
      ];

      $fields['show_content_button'] = [
        'label' => esc_html__('Show Button', 'dipi-divi-pixel'),
        'type' => 'yes_no_button',
        'default' => 'off',
        'options' => [
            'off' => esc_html__('No', 'dipi-divi-pixel'),
            'on' => esc_html__('Yes', 'dipi-divi-pixel'),
        ],
        'toggle_slug' => 'content',
      ];

      $fields["content_button_text"] = [
        'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
        'type' => 'text',
        'default' => esc_html__('Click Here', 'dipi-divi-pixel'),
        'show_if' => ['show_content_button' => 'on'],
        'toggle_slug' => 'content',
        'dynamic_content' => 'text',
      ];

      $fields["content_button_link"] = [
        'label' => esc_html__('Button Link', 'dipi-divi-pixel'),
        'type' => 'text',
        'default' => '#',
        'show_if' => ['show_content_button' => 'on'],
        'toggle_slug' => 'content',
        'dynamic_content' => 'url',
      ];

      $fields["content_button_link_target"] = [
        'label' => esc_html__('Button Link Target', 'dipi-divi-pixel'),
        'type' => 'select',
        'option_category' => 'layout',
        'default' => 'same_window',
        'default_on_child' => true,
        'options' => [
            'off' => esc_html__('Same Window', 'dipi-divi-pixel'),
            'on' => esc_html__('New Window', 'dipi-divi-pixel'),
        ],
        'show_if' => ['show_content_button' => 'on'],
        'toggle_slug' => 'content',
      ];

      $fields["is_new_row"] = [
        'label' => esc_html__('Is New Row', 'dipi-divi-pixel'),
        'type' => 'yes_no_button',
        'default' => 'off',
        'options' => [
            'off' => esc_html__('No', 'dipi-divi-pixel'),
            'on' => esc_html__('Yes', 'dipi-divi-pixel'),
        ],
        'toggle_slug' => 'settings',
      ];
      $fields['col_span'] = [
        'label' => esc_html__('Col Span', 'dipi-divi-pixel'),
        'type' => 'select',
        'option_category' => 'layout',
        'options' => [
          'full' =>  esc_html__('Full', 'dipi-divi-pixel'),
          'number' => esc_html__('Number', 'dipi-divi-pixel'),
        ],
        'toggle_slug' => 'settings',
        'default_on_front' => 'number',
    ];
      $fields['col_span_num'] = [
        'label' => esc_html__('Col Span', 'dipi-divi-pixel'),
        'toggle_slug' => 'settings',
        'type' => 'range',
        'range_settings' => [
            'min' => '1',
            'max' => '100',
            'step' => '1',
        ],
        'option_category' => 'layout',
        'unitless' => true,
        'sticky' => true,
        'default' => '1',
        'show_if' => [
          'col_span' => 'number'
        ]
      ];
      
      /* Content Image & Icon */
      $fields['content_icon_color'] = [
        'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
        'type' => 'color-alpha',
        'description' => esc_html__('Here you can define a custom color for your icon.', 'dipi-divi-pixel'),
        'depends_show_if' => 'on',
        'tab_slug' => 'advanced',
        'hover' => 'tabs',
        'mobile_options' => true,
        'sticky' => true,
        'toggle_slug' => 'content_image_icon',
    ];
    $fields['content_image_icon_background_color'] = [
        'label' => esc_html__('Image & Icon Background Color', 'dipi-divi-pixel'),
        'type' => 'color-alpha',
        'description' => esc_html__('Here you can define a custom background color.', 'dipi-divi-pixel'),
        'default' => '',
        'tab_slug' => 'advanced',
        'hover' => 'tabs',
        'mobile_options' => true,
        'sticky' => true,
        'toggle_slug' => 'content_image_icon',
    ];
    $fields['content_image_icon_width'] = [
        'label' => esc_html__('Image & Icon Size', 'dipi-divi-pixel'),
        'toggle_slug' => 'content_image_icon',
        'description' => esc_html__('Here you can choose icon/img Size.', 'dipi-divi-pixel'),
        'type' => 'range',
        'range_settings' => [
            'min' => '1',
            'max' => '200',
            'step' => '1',
        ],
        'option_category' => 'layout',
        'tab_slug' => 'advanced',
        'hover' => 'tabs',
        'validate_unit' => true,
        'allowed_units' => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
        'responsive' => true,
        'mobile_options' => true,
        'sticky' => true,
    ];
    $fields['icon_placement'] = [
        'label' => esc_html__('Image/Icon Placement', 'dipi-divi-pixel'),
        'type' => 'select',
        'option_category' => 'layout',
        'options' => $image_icon_placement,
        'tab_slug' => 'advanced',
        'toggle_slug' => 'content_image_icon',
        'description' => esc_html__('Here you can choose where to place the icon.', 'dipi-divi-pixel'),
        'default_on_front' => 'parent',
        'mobile_options' => true,
    ];
        
    $fields['content_vertical_alignment'] = [
      'label' => esc_html__('Vertical Alignment', 'dipi-divi-pixel'),
      'description' => esc_html__('This setting will work only when Image/Icon placement is Left.', 'dipi-divi-pixel'),
      'type' => 'select',
      'option_category' => 'configuration',
      'default' => 'parent',
      'options' => [
        '' => esc_html__('Parent', 'dipi-divi-pixel'),  
        'flex-start' => esc_html__('Top', 'dipi-divi-pixel'),  
        'center' => esc_html__('Center', 'dipi-divi-pixel'),
        'flex-end' => esc_html__('Bottom', 'dipi-divi-pixel'),
      ],
      'mobile_options' => true,
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_cells',
    ];
    $fields['content_horizontal_alignment'] = [
        'label' => esc_html__('Horizontal Alignment', 'dipi-divi-pixel'),
        'description' => esc_html__('This setting will work only when Image/Icon placement is Left.', 'dipi-divi-pixel'),
        'type' => 'select',
        'option_category' => 'configuration',
        'default' => '',
        'options' => [
            '' => esc_html__('Parent', 'dipi-divi-pixel'),  
          'flex-start' => esc_html__('Left', 'dipi-divi-pixel'),  
          'center' => esc_html__('Center', 'dipi-divi-pixel'),
          'flex-end' => esc_html__('Right', 'dipi-divi-pixel'),
        ],
        'mobile_options' => true,
        'tab_slug' => 'advanced',
        'toggle_slug' => 'table_cells',
      ];
    $fields['icon_alignment'] = [
        'label' => esc_html__('Image/Icon Alignment', 'dipi-divi-pixel'),
        'description' => esc_html__('Align image/icon to the left, right or center.', 'dipi-divi-pixel'),
        'type' => 'align',
        'option_category' => 'layout',
        'options' => et_builder_get_text_orientation_options(array('justified')),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'content_image_icon',
        'mobile_options' => true,
        'sticky' => true,
    ];
    /* Content Title Spacing */
    $fields['content_title_margin'] = [
        'label' => __('Margin', 'dipi-divi-pixel'),
        'type' => 'custom_margin',
        'description' => __('Set Margin of Title.', 'dipi-divi-pixel'),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'content_text',
        'sub_toggle' => 'title',
        'default' => '|||',
        'mobile_options' => true,
    ];
    $fields['content_title_padding'] = [
        'label' => __('Padding', 'dipi-divi-pixel'),
        'type' => 'custom_margin',
        'description' => __('Set Padding of Title.', 'dipi-divi-pixel'),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'content_text',
        'sub_toggle' => 'title',
        'default' => '',
        'mobile_options' => true,
    ];
    $fields['content_desc_margin'] = [
        'label' => __('Margin', 'dipi-divi-pixel'),
        'type' => 'custom_margin',
        'description' => __('Set Margin of Description.', 'dipi-divi-pixel'),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'content_text',
        'sub_toggle' => 'desc',
        'default' => '|||',
        'mobile_options' => true,
    ];
    $fields['content_desc_padding'] = [
        'label' => __('Padding', 'dipi-divi-pixel'),
        'type' => 'custom_margin',
        'description' => __('Set Padding of Description.', 'dipi-divi-pixel'),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'content_text',
        'sub_toggle' => 'desc',
        'default' => '',
        'mobile_options' => true,
    ];


    $fields['content_width'] = [
        'label' => esc_html('Content Width', 'dipi-divi-pixel'),
        'type' => 'range',
        'default' => '100%',
        'default_unit' => '%',
        'range_settings' => [
            'min' => '1',
            'max' => '100',
            'step' => '1',
        ],
        'validate_unit' => true,
        'mobile_options' => true,
        'tab_slug' => 'advanced',
        'toggle_slug' => 'width',
    ];
    $fields["content_alignment"] = [
        'label' => esc_html__('Content Alignment', 'dipi-divi-pixel'),
        'type' => 'text_align',
        'options_icon' => 'module_align',
        'default' => 'center',
        'options' => [
            'left' => esc_html__('Left', 'dipi-divi-pixel'),
            'center' => esc_html__('Center', 'dipi-divi-pixel'),
            'right' => esc_html__('Right', 'dipi-divi-pixel'),
        ],
        'mobile_options' => true,
        'tab_slug' => 'advanced',
        'toggle_slug' => 'width',
    ];
      return $fields;
    }


    public function dipi_apply_css($render_slug)
    {
      $container_class = "%%order_class%%.dipi_table_maker_child .dipi_table_item-content-wrapper";
      $content_selector = "%%order_class%%.dipi_table_maker_child .dipi_table_item-content-wrapper .dipi_table_item-content";
      $container_hover_class = "%%order_class%%.dipi_table_maker_child .dipi_table_item-content-wrapper:hover";
      $overlay_class = "%%order_class%%.dipi_table_maker_child .dipi_extending_cta-overlay";
      $overlay_hover_class = "%%order_class%%.dipi_table_maker_child .dipi_extending_cta-overlay:hover";

      $content_icon_selector = '%%order_class%%.dipi_table_maker_child .dipi_table_item-content-wrapper .dipi-content-image-icon-wrap .et-pb-icon';
      $content_top_image_icon_selector = '.dipi-table-maker %%order_class%%.dipi_table_maker_child.icon_image_place_top .dipi_table_item-content-wrapper .dipi-content-image-icon-wrap';
      $content_image_icon_selector = '%%order_class%%.dipi_table_maker_child .dipi_table_item-content-wrapper .dipi-content-image-icon-wrap';
      $content_image_icon_hover_selector = '%%order_class%%:hover .dipi_table_item-content-wrapper .dipi-content-image-icon-wrap';
      $content_image_icon_width_selector = '%%order_class%%.dipi_table_maker_child .dipi_table_item-content-wrapper .dipi-content-image-icon-wrap.dipi-image-wrapper';
      $content_title_selector = '%%order_class%%.dipi_table_maker_child .dipi-content-text .dipi-content-heading';
      $content_desc_selector = '%%order_class%%.dipi_table_maker_child .dipi-content-text .dipi-desc';
      $content_button_selector = '%%order_class%%.dipi_table_maker_child .dipi_table_item-content-wrapper .dipi-button-wrapper';

      // Images: Add CSS Filters and Mix Blend Mode rules (if set)
      $generate_css_image_filters = '';
      if (array_key_exists('icon_settings', $this->advanced_fields) && array_key_exists('css', $this->advanced_fields['icon_settings'])) {
          $generate_css_image_filters = $this->generate_css_filters(
              $render_slug,
              'child_',
              self::$data_utils->array_get($this->advanced_fields['icon_settings']['css'], 'main', '%%order_class%%')
          );
      }

      /* Content Image & Icon */
      $this->generate_styles(
          array(
              'base_attr_name' => 'content_icon_color',
              'selector' => $content_icon_selector,
              'css_property' => 'color',
              'render_slug' => $render_slug,
              'type' => 'color',
          )
      );
      $this->generate_styles(
        array(
            'base_attr_name' => 'content_vertical_alignment',
            'selector' => $content_selector,
            'css_property' => 'align-items',
            'render_slug' => $render_slug,
            'type' => 'select',
        )
      );

      $this->generate_styles(
        array(
            'base_attr_name' => 'content_horizontal_alignment',
            'selector' => $content_selector,
            'css_property' => 'justify-content',
            'render_slug' => $render_slug,
            'type' => 'select',
        )
      );

      $this->generate_styles(
          array(
              'base_attr_name' => 'content_image_icon_background_color',
              'selector' => $content_image_icon_selector,
              'css_property' => 'background-color',
              'render_slug' => $render_slug,
              'type' => 'color',
          )
      );

      $this->generate_styles(
          array(
              'base_attr_name' => 'content_image_icon_width',
              'selector' => $content_icon_selector,
              'css_property' => 'font-size',
              'render_slug' => $render_slug,
              'type' => 'range',
          )
      );

      $this->generate_styles(
          array(
              'base_attr_name' => 'content_image_icon_width',
              'selector' => $content_image_icon_width_selector,
              'css_property' => 'width',
              'render_slug' => $render_slug,
              'type' => 'range',
          )
      );
      $this->generate_styles(
          array(
              'base_attr_name' => 'content_image_icon_width',
              'selector' => $content_image_icon_width_selector,
              'css_property' => 'height',
              'render_slug' => $render_slug,
              'type' => 'range',
          )
      );
      $this->generate_styles(
        array(
            'base_attr_name' => 'content_width',
            'selector' => $content_selector,
            'css_property' => 'width',
            'render_slug' => $render_slug,
            'type' => 'range',
        )
    );
     
      $content_alignment = $this->props['content_alignment'];
      $content_alignment_values = et_pb_responsive_options()->get_property_values($this->props, 'content_alignment');
      $content_alignment_last_edited = $this->props['content_alignment_last_edited'];
      $content_alignment_margins = array(
        'left' => '0 auto 0 0',
        'center' => '0px auto 0px',
        'right' => '0px 0 0px auto',
      );

      if (et_pb_get_responsive_status($content_alignment_last_edited) && '' !== implode('', $content_alignment_values)) {
          $content_alignment_values = array();

          foreach ($content_alignment_values as $breakpoint => $alignment) {
              $content_alignment_values[$breakpoint] = et_()->array_get(
                  $content_alignment_margins,
                  $alignment,
                  ''
              );
          }
          et_pb_responsive_options()->generate_responsive_css(
              $content_alignment_values,
              $content_selector,
              'margin',
              $render_slug,
              '',
              'align'
          );
      } else {
          $el_style = array(
              'selector' => $content_selector,
              'declaration' => sprintf(
                  'margin: %1$s;',
                  esc_html(et_()->array_get($content_alignment_margins, $content_alignment, ''))
              ),
          );
          ET_Builder_Element::set_style($render_slug, $el_style);
      }
      // Image/Icon Alignment
      $icon_alignment = $this->props['icon_alignment'];
      $icon_alignment_values = et_pb_responsive_options()->get_property_values($this->props, 'icon_alignment');
      $icon_alignment_last_edited = $this->props['icon_alignment_last_edited'];
      $icon_alignment_margins = array(
        'left' => '10px auto 10px 0',
        'center' => '10px auto 10px',
        'right' => '10px 0 10px auto',
      );

      if (et_pb_get_responsive_status($icon_alignment_last_edited) && '' !== implode('', $icon_alignment_values)) {
          $image_alignment_values = array();

          foreach ($icon_alignment_values as $breakpoint => $alignment) {
              $image_alignment_values[$breakpoint] = et_()->array_get(
                  $icon_alignment_margins,
                  $alignment,
                  ''
              );
          }
          et_pb_responsive_options()->generate_responsive_css(
              $image_alignment_values,
              $content_top_image_icon_selector,
              'margin',
              $render_slug,
              '',
              'align'
          );
      } else {
          $el_style = array(
              'selector' => $content_top_image_icon_selector,
              'declaration' => sprintf(
                  'margin: %1$s;',
                  esc_html(et_()->array_get($icon_alignment_margins, $icon_alignment, ''))
              ),
          );
          ET_Builder_Element::set_style($render_slug, $el_style);
      }

      /* Content Title */
      $this->dipi_apply_custom_margin_padding(
          $render_slug,
          'content_title_margin',
          'margin',
          $content_title_selector
      );
      $this->dipi_apply_custom_margin_padding(
          $render_slug,
          'content_title_padding',
          'padding',
          $content_title_selector
      );

      /* Content Description */
      $this->dipi_apply_custom_margin_padding(
          $render_slug,
          'content_desc_margin',
          'margin',
          $content_desc_selector
      );
      $this->dipi_apply_custom_margin_padding(
          $render_slug,
          'content_desc_padding',
          'padding',
          $content_desc_selector
      );
      /* Content Button */
      $btn_margin = $this->dipi_get_responsive_prop('content_button_custom_margin');
      // $this->set_responsive_spacing_css($render_slug, "%%order_class%%.dipi_table_maker_child .dipi_content_button.et_pb_button", 'margin', $btn_margin, true );
      $btn_padding = $this->dipi_get_responsive_prop('content_button_custom_margin');
      //$this->set_responsive_spacing_css($render_slug, "%%order_class%%.dipi_table_maker_child .dipi_content_button.et_pb_button", 'padding', $btn_padding, true );
      $this->generate_styles(
          array(
              'base_attr_name' => 'content_button_alignment',
              'selector' => $content_button_selector,
              'css_property' => 'text-align',
              'render_slug' => $render_slug,
              'type' => 'align',
          )
      );

      $this->set_background_css(
          $render_slug,
          $container_class,
          $container_hover_class,
          'content_bg',
          'content_bg_color'
      );
    }
    public function _render_content($render_slug)
    {
        $multi_view                    = et_pb_multi_view_options( $this );
        $link_option_url = $this->props['link_option_url'];
        $link_option_url_new_window = $this->props['link_option_url_new_window'];
        $link_taget = ($link_option_url_new_window === 'on') ? 'target="blank"':'';
        $link_start = (!empty($link_option_url)) ? sprintf('<a href="%1$s" %2$s>', $link_option_url, $link_taget): '';
        $link_end = (!empty($link_option_url)) ? sprintf('</a>'):'';
        $parallax_image_background = $this->get_parallax_image_background();
        $content_image_icon = '';
        $content_icon_selector = '%%order_class%%.dipi_table_maker_child .dipi_table_item-content-wrapper .dipi-content-image-icon-wrap .et-pb-icon';
        if ('on' == $this->props['use_content_icon']) {
            $icon = ($this->props['content_icon'] === '%&quot;%%' || $this->props['content_icon'] === '%"%%') ? '%%22%%' : $this->props['content_icon'];
            $content_icon = et_pb_process_font_icon($icon);
            $content_image_icon = sprintf(
                '<div class="dipi-content-image-icon-wrap dipi-icon-wrap">
                    <span class="et-pb-icon et-pb-font-icon dipi-content-icon">%1$s</span>
                </div>',
                esc_attr($content_icon)
            );

            $this->dipi_generate_font_icon_styles($render_slug, 'content_icon', $content_icon_selector);
        } else if ('on' !== $this->props['use_content_icon'] && $this->props['content_image'] !== '') {
            $content_image_icon = sprintf(
                '<div class="dipi-content-image-icon-wrap dipi-image-wrapper" href="%1$s" data-title="%3$s">
                    <img src="%1$s" class="dipi-content-image" alt="%2$s">
                </div>',
                esc_attr($this->props['content_image']),
                $this->_esc_attr('content_image_alt'),
                esc_attr($this->props['content_title'])
            );
        }

        $content_title_level = $this->props['content_title_level'];
        $content_title = '';
        if (isset($this->props['content_title']) && '' !== $this->props['content_title']) {
          $title_tag = 'span';  
          $title_attrs = array();
          $content_title =  $multi_view->render_element(
            array(
              'tag'     => $title_tag,
              'content' => '{{content_title}}',
              'attrs'   => $title_attrs,
            )
          );
          $content_title = sprintf(
              '<%2$s class="dipi-content-heading">
                  %1$s
              </%2$s>',
              et_core_esc_previously($content_title),
              et_pb_process_header_level( $content_title_level, 'h2' )
          );
        }

        $content_description = '';
        if (isset($this->props['content']) && !empty($this->props['content'])) {
          $content_tag = 'div';  
          $content_attrs = array();
          $content_description =  $multi_view->render_element(
            array(
              'tag'     => $content_tag,
              'content' => '{{content}}',
              'attrs'   => [
                'class' => 'dipi-desc',
              ]
            )
          );
        }

        $show_content_button = $this->props['show_content_button'];
        $content_button_text = $this->props['content_button_text'];
        $content_button_link = $this->props['content_button_link'];
        $content_button_rel = $this->props['content_button_rel'];
        $content_button_icon = $this->props['content_button_icon'];
        $content_button_link_target = $this->props['content_button_link_target'];
        $content_button_custom = $this->props['custom_content_button'];

        $content_button = $this->render_button([
            'button_classname' => ["dipi_content_button"],
            'button_custom' => $content_button_custom,
            'button_rel' => $content_button_rel,
            'button_text' => $content_button_text,
            'button_url' => $content_button_link,
            'custom_icon' => $content_button_icon,
            'url_new_window' => $content_button_link_target,
            'has_wrapper' => false,
        ]);
        $content_button_html = "";
        if ($content_button) {
          $content_button_html = sprintf(
            '<div class="dipi-button-wrapper">
              %1$s
            </div>',
            $content_button
          );
        }
        $content_html = sprintf(
            '%1$s
            <div class="dipi-content-wrapper">
              <div class="dipi-content-text">
                  %2$s
                  %3$s
              </div>
              %4$s
            </div>
          ',
            $content_image_icon,
            $content_title,
            $content_description,
            ($show_content_button === 'on') ? $content_button_html : ''

        );
       
        $content_html = sprintf(
            '<div
          class="dipi_table_item-content">
          %1$s
        </div>',
            $content_html
        );
        $content_html = sprintf(
            '%1$s
            <div class="dipi_table_item-content-wrapper">
                %3$s
                    %2$s
                %4$s
            </div>
            ',
            $parallax_image_background,
            $content_html,
            $link_start,
            $link_end
        );

        return $content_html;
    }
    public function render($attrs, $content, $render_slug)
    {
        global $dipi_table_cells;
        $order_class = self::get_module_order_class($render_slug);
        $this->dipi_apply_css($render_slug);
        $icon_placement = $this->props['icon_placement'];
        $icon_placement_values = et_pb_responsive_options()->get_property_values($this->props, 'icon_placement');
        $icon_placement_tablet = !!empty($icon_placement_values['tablet']) ? $icon_placement_values['tablet'] : $icon_placement;
        $icon_placement_phone = !empty($icon_placement_values['phone']) ? $icon_placement_values['phone'] : $icon_placement_tablet;

        $dipi_table_cells[] = [
          'order_class' => $order_class,
          'content' => $this->_render_content($render_slug),
          'is_new_row' => $this->props['is_new_row'] === 'on' ? true : false,
          'icon_placement' => $icon_placement,
          'icon_placement_tablet' => $icon_placement_tablet,
          'icon_placement_phone' => $icon_placement_phone,
          'col_span' => $this->props['col_span'],
          'col_span_num' => $this->props['col_span_num'],
          'module_class' => $this->props['module_class'],
          'module_id' => $this->props['module_id'],
          /*'row_span' => $this->props['row_span'],*/
        ];
        return '';
    }
    
	
    /**
     * Filter multi view value.
     *
     * @since 3.27.1
     *
     * @see ET_Builder_Module_Helper_MultiViewOptions::filter_value
     *
     * @param mixed                                     $raw_value Props raw value.
     * @param array                                     $args {
     *                                         Context data.
     *
     *     @type string $context      Context param: content, attrs, visibility, classes.
     *     @type string $name         Module options props name.
     *     @type string $mode         Current data mode: desktop, hover, tablet, phone.
     *     @type string $attr_key     Attribute key for attrs context data. Example: src, class, etc.
     *     @type string $attr_sub_key Attribute sub key that availabe when passing attrs value as array such as styes. Example: padding-top, margin-botton, etc.
     * }
     * @param ET_Builder_Module_Helper_MultiViewOptions $multi_view Multiview object instance.
     *
     * @return mixed
     */
    public function multi_view_filter_value($raw_value, $args, $multi_view)
    {
        $name = isset($args['name']) ? $args['name'] : '';
        $mode = isset($args['mode']) ? $args['mode'] : '';

        if ($raw_value && ('font_icon' === $name || 'timeline_icon' === $name )) {
            $processed_value = html_entity_decode(et_pb_process_font_icon($raw_value));
            if ('%%1%%' === $raw_value) {
                $processed_value = '"';
            }

            return $processed_value;
        }

        $fields_need_escape = array(
            'button_text',
        );

        if ($raw_value && in_array($name, $fields_need_escape, true)) {
            return $this->_esc_attr($multi_view->get_name_by_mode($name, $mode), 'none', $raw_value);
        }

        return $raw_value;
    }
}

new DIPI_TableMakerChild;
