<?php

class DIPI_InfoCircle_Item extends DIPI_Builder_Module
{
  // Module item's attribute that will be used for module item label on modal
  public $child_title_var = 'admin_label';

  public function init()
  {
      $this->name = esc_html__('Info Circle Item', 'dipi-divi-pixel');
      $this->plural = esc_html__('Info Circle Items', 'dipi-divi-pixel');
      $this->slug = 'dipi_info_circle_item';
      $this->vb_support = 'on';
      $this->main_css_element = '%%order_class%%.dipi_info_circle_item';
      $this->type = 'child';
      $this->defaults = [
        'normal_icon_color' => '#2C3D49',
        'normal_icon_bg' => '#F8F8F8',
        'normal_icon_color_hover' => '#ffffff',
        'normal_icon_bg_hover' => '#2C3D49',
        'active_icon_color' => '#ffffff',
        'active_icon_bg' => '#2C3D49',
        'normal_icon_size' => '25px',
        'active_icon_size' => '30px',
        'normal_icon_padding' => '15px|15px|15px|15px'
      ];
      // attributes are empty, this default text will be used instead as item label
      $this->advanced_setting_title_text = esc_html__('Info Circle Item', 'dipi-divi-pixel');

      $this->settings_modal_toggles = array(
          'general' => array(
            'toggles' => array(
              'info_image_icon_content' => esc_html__('Info Image & Icon', 'dipi-divi-pixel'),
              'content' => esc_html__('Content', 'dipi-divi-pixel'),
            ),
          ),
          'advanced' => array(
            'toggles' => [
              'info_image_icon' => [
                'title' => esc_html__('Info Image & Icon', 'dipi-divi-pixel'),
                'tabbed_subtoggles' => true,
                'sub_toggles' => [
                  'normal' => [
                      'name' => 'Normal',
                  ],
                  'hover' => [
                      'name' => 'Hover',
                  ],
                  'active' => [
                      'name' => 'Active',
                  ],
                ],
              ],
              'content_image_icon' => esc_html__('Content Image & Icon', 'dipi-divi-pixel'),
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
                'title' => esc_html__('Content Text', 'dipi-divi-pixel'),
              ],
            ],
          ),
          'custom_css' => array(
              'toggles' => array(
              ),
          ),
      );

      $this->custom_css_fields = array(

      );

      $this->help_videos = array(
          array(
              'id' => 'XW7HR86lp8U',
              'name' => esc_html__('An introduction to the Info Circle Item module', 'dipi-divi-pixel'),
          ),
      );
  }

  public function get_fields()
  {
    $et_accent_color = et_builder_accent_color();

    $fields = [];
    $fields['admin_label'] =[
      'label' => esc_html__('Admin Label', 'dipi-divi-pixel'),
      'type' => 'text',
      'toggle_slug' => 'admin_label',
      'description' => esc_html__('This will change the label of the module in the builder for easy identification.', 'dipi-divi-pixel'),
    ];
    $fields["use_info_icon"] = [
      'label' => esc_html__('Use Icon', 'dipi-divi-pixel'),
      'type' => 'yes_no_button',
      'default'     => 'off',
      'options' => [
          'off' => esc_html__('No', 'dipi-divi-pixel'),
          'on'  => esc_html__('Yes', 'dipi-divi-pixel'),
      ],
      'toggle_slug' => 'info_image_icon_content',
    ];
    $fields["info_icon"] = [
      'label'       => esc_html__('Icon', 'dipi-divi-pixel'),
      'type'        => 'select_icon',
      'class'       => ['et-pb-font-icon'],
      'default'     => '1',
      'show_if' => [
          'use_info_icon' => 'on'
      ],
      'toggle_slug' => 'info_image_icon_content',
    ];
    $fields['info_image'] = [
      'type'               => 'upload',
      'hide_metadata'      => true,
      'choose_text'        => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
      'update_text'        => esc_attr__('Set As Image', 'dipi-divi-pixel'),
      'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
      'description'        => esc_html__('Upload an info image to show in circle.', 'dipi-divi-pixel'),
      'show_if' => [
          'use_info_icon' => 'off'
      ],
      'toggle_slug'        => 'info_image_icon_content',
      'dynamic_content'    => 'image'
    ];
    $fields['info_image_alt'] = array(
      'label'           => esc_html__( 'Image Alt Text', 'et_builder' ),
      'type'            => 'text',
      'option_category' => 'basic_option',
      'description'     => esc_html__( 'Input alternative text for your image here. This text will be used by screen readers, search engines, or when the image cannot be loaded.', 'dipi-divi-pixel' ),
      'toggle_slug'     => 'info_image_icon_content',
      'dynamic_content' => 'text',
      'show_if' => [
        'use_info_icon' => 'off'
      ],
    );

    

    $fields["use_content_icon"] = [
      'label' => esc_html__('Use Icon', 'dipi-divi-pixel'),
      'type' => 'yes_no_button',
      'default'     => 'off',
      'options' => [
          'off' => esc_html__('No', 'dipi-divi-pixel'),
          'on'  => esc_html__('Yes', 'dipi-divi-pixel'),
      ],
      'toggle_slug' => 'content',
    ];
    $fields["content_icon"] = [
      'label'       => esc_html__('Icon', 'dipi-divi-pixel'),
      'type'        => 'select_icon',
      'class'       => ['et-pb-font-icon'],
      'default'     => '1',
      'show_if' => [
          'use_content_icon' => 'on'
      ],
      'toggle_slug' => 'content',
    ];
    $fields['content_image'] = [
      'type'               => 'upload',
      'hide_metadata'      => true,
      'choose_text'        => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
      'update_text'        => esc_attr__('Set As Image', 'dipi-divi-pixel'),
      'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
      'description'        => esc_html__('Upload an info image to show in the content.', 'dipi-divi-pixel'),
      'show_if' => [
          'use_content_icon' => 'off'
      ],
      'toggle_slug'        => 'content',
      'dynamic_content'    => 'image'
    ];
    $fields['content_image_alt'] = array(
      'label'           => esc_html__( 'Image Alt Text', 'et_builder' ),
      'type'            => 'text',
      'option_category' => 'basic_option',
      'description'     => esc_html__( 'Input alternative text for your image here. This text will be used by screen readers, search engines, or when the image cannot be loaded.', 'dipi-divi-pixel' ),
      'toggle_slug'     => 'content',
      'dynamic_content' => 'text',
      'show_if' => [
        'use_content_icon' => 'off'
      ],
    );

    $fields["content_title"] = [
      'label'       => esc_html__('Title', 'dipi-divi-pixel'),
      'type'        => 'text',
      'toggle_slug' => 'content',
      'dynamic_content'    => 'text'
    ];

    $fields["content_description"] = [
        'label'           => esc_html__('Description', 'dipi-divi-pixel'),
        'type'            => 'tiny_mce',
        'toggle_slug'     => 'content',
        'dynamic_content'    => 'text'
    ];

    $fields["show_content_button"] = [
        'default' => 'off',
        'label' => esc_html__('Show Button', 'dipi-divi-pixel'),
        'type' => 'yes_no_button',
        'options' => [
            'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            'off' => esc_html__('No', 'dipi-divi-pixel'),
        ],
        'toggle_slug' => 'content',
    ];

    $fields["content_button_text"] = [
        'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
        'default' => esc_html__('Click Here', 'dipi-divi-pixel'),
        'type' => 'text',
        'show_if' => [
          'show_content_button' => 'on'
        ],          
        'toggle_slug' => 'content',
        'dynamic_content'    => 'text'
    ];

    $fields["content_button_link"] = [
        'label' => esc_html__('Button Link', 'dipi-divi-pixel'),
        'type' => 'text',
        'show_if' => [
          'show_content_button' => 'on'
        ],          
        'toggle_slug' => 'content',
        'dynamic_content'    => 'url'
    ];

    $fields["content_button_link_target"] = [
        'label' => esc_html__('Button Link Target', 'dipi-divi-pixel'),
        'type' => 'select',
        'default' => 'same_window',
        'options' => [
            'off' => esc_html__('Same Window', 'dipi-divi-pixel'),
            'on' => esc_html__('New Window', 'dipi-divi-pixel'),
        ],
        'show_if' => [
          'show_content_button' => 'on'
        ],
        'toggle_slug' => 'content',
    ];
    $fields['url'] = [
      'label'           => esc_html__( 'Content Link URL', 'et_builder' ),
      'type'            => 'text',
      'option_category' => 'basic_option',
      'description'     => esc_html__( 'If you would like to make your blurb a link, input your destination URL here.', 'et_builder' ),
      'toggle_slug'     => 'link_options',
      'dynamic_content' => 'url',
    ];
    $fields['url_new_window'] = [
      'label'            => esc_html__( 'Content Link Target', 'et_builder' ),
      'type'             => 'select',
      'option_category'  => 'configuration',
      'options'          => array(
        'off' => esc_html__( 'In The Same Window', 'et_builder' ),
        'on'  => esc_html__( 'In The New Tab', 'et_builder' ),
      ),
      'toggle_slug'      => 'link_options',
      'description'      => esc_html__( 'Here you can choose whether or not your link opens in a new window', 'et_builder' ),
      'default_on_front' => 'off',
    ];
    /* Info Image & Icon */
    // Normal
    $fields['info_icon_color'] = [
      'label'           => esc_html__( 'Icon Color', 'dipi-divi-pixel' ),
      'type'            => 'color-alpha',
      'default'          => $this->defaults['normal_icon_color'],
      'description'     => esc_html__( 'Here you can define a custom color for your icon.', 'dipi-divi-pixel' ),
      'depends_show_if' => 'on',
      'tab_slug'        => 'advanced',
      'sticky'          => true,
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'normal',
      'mobile_options'  => true,
      'show_if' => [
        'use_info_icon' => 'on'
      ]
    ];
    $fields['info_image_icon_background_color'] = [
      'label'          => esc_html__( 'Image & Icon Background Color', 'dipi-divi-pixel' ),
      'type'           => 'color-alpha',
      'default'          => $this->defaults['normal_icon_bg'],
      'description'    => esc_html__( 'Here you can define a custom background color.', 'dipi-divi-pixel' ),
      'tab_slug'       => 'advanced',
      'sticky'         => true,
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'normal',
      'mobile_options'  => true,
    ];
    $fields['info_image_icon_width'] = [
      'label'                  => esc_html__( 'Image & Icon Size', 'dipi-divi-pixel' ),
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'normal',
      'mobile_options'  => true,
      'description'            => esc_html__( 'Here you can choose icon/img Size.', 'dipi-divi-pixel' ),
      'type'                   => 'range',
      'range_settings'         => [
        'min'  => '1',
        'max'  => '200',
        'step' => '1',
      ],
      'default' => $this->defaults['normal_icon_size'],
      'option_category'        => 'layout',
      'tab_slug'               => 'advanced',
      'validate_unit'          => true,
      'allowed_units'          => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
      'sticky'                 => true,
    ];
    $fields['info_image_icon_margin'] = [
      'label' => __('Image & Icon Margin', 'dipi-divi-pixel'),
      'type' => 'custom_margin',
      'description' => __('Set Margin of Info Image & Icon.', 'dipi-divi-pixel'),
      'tab_slug' => 'advanced',
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'normal',
      'mobile_options'  => true,
    ];
    $fields['info_image_icon_padding'] = [
      'label' => __('Image & Icon Padding', 'dipi-divi-pixel'),
      'type' => 'custom_margin',
      'default' => $this->defaults['normal_icon_padding'],
      'description' => __('Set Padding of Info Image & Icon.', 'dipi-divi-pixel'),
      'tab_slug' => 'advanced',
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'normal',
      'mobile_options'  => true,
    ];

    // Hover Info Image & Icon
    $fields['info_icon_hover_color'] = [
      'label'   => esc_html__( 'Icon Color', 'dipi-divi-pixel' ),
      'type'    => 'color-alpha',
      'default' => '',
      'default_on_front' => '', //$this->defaults['normal_icon_color_hover'],
      'description'     => esc_html__( 'Here you can define a custom color for your icon.', 'dipi-divi-pixel' ),
      'depends_show_if' => 'on',
      'tab_slug'        => 'advanced',
      'sticky'          => true,
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'hover',
      'mobile_options'  => true,
      'show_if' => [
        'use_info_icon' => 'on'
      ]
    ];
    $fields['info_image_icon_hover_background_color'] = [
      'label'          => esc_html__( 'Image & Icon Background Color', 'dipi-divi-pixel' ),
      'type'           => 'color-alpha',
      'default' => '',
      'default_on_front' => '', //$this->defaults['normal_icon_bg_hover'],
      'description'    => esc_html__( 'Here you can define a custom background color.', 'dipi-divi-pixel' ),
      'tab_slug'       => 'advanced',
      'sticky'         => true,
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'hover',
      'mobile_options'  => true,
    ];
    $fields['info_image_icon_hover_width'] = [
      'label'                  => esc_html__( 'Image & Icon Size', 'dipi-divi-pixel' ),
      'description'            => esc_html__( 'Here you can choose icon/img Size.', 'dipi-divi-pixel' ),
      'type'                   => 'range',
      'range_settings'         => [
        'min'  => '1',
        'max'  => '200',
        'step' => '1',
      ],
      'option_category'        => 'layout',
      'tab_slug'               => 'advanced',
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'hover',
      'mobile_options'  => true,
      'validate_unit'          => true,
      'allowed_units'          => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
      'sticky'                 => true,
    ];
    $fields['info_image_icon_hover_margin'] = [
      'label' => __('Image & Icon Margin', 'dipi-divi-pixel'),
      'type' => 'custom_margin',
      'description' => __('Set Margin of Info Image & Icon.', 'dipi-divi-pixel'),
      'tab_slug' => 'advanced',
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'hover',
      'mobile_options'  => true,
    ];
    $fields['info_image_icon_hover_padding'] = [
      'label' => __('Image & Icon Padding', 'dipi-divi-pixel'),
      'type' => 'custom_margin',
      'description' => __('Set Padding of Info Image & Icon.', 'dipi-divi-pixel'),
      'tab_slug' => 'advanced',
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'hover',
      'mobile_options'  => true,
    ];

    // Active
    $fields['info_icon_active_color'] = [
      'label'           => esc_html__( 'Icon Color', 'dipi-divi-pixel'),
      'type'            => 'color-alpha',
      'default'         => $this->defaults['active_icon_color'],
      'description'     => esc_html__( 'Here you can define a custom color for your icon.', 'dipi-divi-pixel' ),
      'depends_show_if' => 'on',
      'tab_slug'        => 'advanced',
      'sticky'          => true,
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'active',
      'mobile_options'  => true,
      'show_if' => [
        'use_info_icon' => 'on'
      ]
    ];
    $fields['info_image_icon_active_background_color'] = [
      'label'          => esc_html__( 'Image & Icon Background Color', 'dipi-divi-pixel' ),
      'type'           => 'color-alpha',
      'default'         => $this->defaults['active_icon_bg'],
      'description'    => esc_html__( 'Here you can define a custom background color.', 'dipi-divi-pixel' ),
      'tab_slug'       => 'advanced',
      'sticky'         => true,
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'active',
      'mobile_options'  => true,
    ];
    $fields['info_image_icon_active_width'] = [
      'label'                  => esc_html__( 'Image & Icon Size', 'dipi-divi-pixel' ),
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'active',
      'description'            => esc_html__( 'Here you can choose icon/img Size.', 'dipi-divi-pixel' ),
      'type'                   => 'range',
      'default'         => $this->defaults['active_icon_size'],
      'range_settings'         => [
        'min'  => '1',
        'max'  => '200',
        'step' => '1',
      ],
      'option_category'        => 'layout',
      'tab_slug'               => 'advanced',
      'validate_unit'          => true,
      'allowed_units'          => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
      'sticky'                 => true,
      'mobile_options'  => true,
    ];
    $fields['info_image_icon_active_margin'] = [
      'label' => __('Image & Icon Margin', 'dipi-divi-pixel'),
      'type' => 'custom_margin',
      'description' => __('Set Margin of Info Image & Icon.', 'dipi-divi-pixel'),
      'tab_slug' => 'advanced',
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'active',
      'mobile_options'  => true,
    ];
    $fields['info_image_icon_active_padding'] = [
      'label' => __('Image & Icon Padding', 'dipi-divi-pixel'),
      'type' => 'custom_margin',
      'description' => __('Set Padding of Info Image & Icon.', 'dipi-divi-pixel'),
      'tab_slug' => 'advanced',
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'active',
      'mobile_options'  => true,
    ];

    /* Content Image & Icon */
    $fields['content_icon_color'] = [
      'default'         => $et_accent_color,
      'label'           => esc_html__( 'Icon Color', 'dipi-divi-pixel' ),
      'type'            => 'color-alpha',
      'description'     => esc_html__( 'Here you can define a custom color for your icon.', 'dipi-divi-pixel' ),
      'depends_show_if' => 'on',
      'tab_slug'        => 'advanced',
      'hover'           => 'tabs',
      'mobile_options'  => true,
      'sticky'          => true,
      'toggle_slug'  => 'content_image_icon',
    ];
    $fields['content_image_icon_background_color'] = [
      'label'          => esc_html__( 'Image & Icon Background Color', 'dipi-divi-pixel' ),
      'type'           => 'color-alpha',
      'description'    => esc_html__( 'Here you can define a custom background color.', 'dipi-divi-pixel' ),
      'default'        => 'transparent',
      'tab_slug'       => 'advanced',
      'hover'          => 'tabs',
      'mobile_options' => true,
      'sticky'         => true,
      'toggle_slug'  => 'content_image_icon',
    ];
    $fields['content_image_icon_width'] = [
      'label'                  => esc_html__( 'Image & Icon Size', 'dipi-divi-pixel' ),
      'toggle_slug'  => 'content_image_icon',
      'description'            => esc_html__( 'Here you can choose icon/img Size.', 'dipi-divi-pixel' ),
      'type'                   => 'range',
      'range_settings'         => [
        'min'  => '1',
        'max'  => '200',
        'step' => '1',
      ],
      'option_category'        => 'layout',
      'tab_slug'               => 'advanced',
      'hover'           => 'tabs',
      'validate_unit'          => true,
      'allowed_units'          => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
      'responsive'             => true,
      'mobile_options'         => true,
      'sticky'                 => true,
      'default' => '96px'
    ];


    /* Content Title Spacing */
    $fields['content_title_margin'] = [
      'label' => __('Margin', 'dipi-divi-pixel'),
      'type' => 'custom_margin',
      'description' => __('Set Margin of Title.', 'dipi-divi-pixel'),
      'tab_slug' => 'advanced',
      'toggle_slug' => 'content_text',
      'sub_toggle' => 'title',
      'default' => '0px|0px|0px|0px',
      'mobile_options' => true,
    ];
    $fields['content_title_padding'] = [
      'label' => __('Padding', 'dipi-divi-pixel'),
      'type' => 'custom_margin',
      'description' => __('Set Padding of Title.', 'dipi-divi-pixel'),
      'tab_slug' => 'advanced',
      'toggle_slug' => 'content_text',
      'sub_toggle' => 'title',
      'default' => '0px|0px|10px|0px',
      'mobile_options' => true,
    ];
    $fields['content_desc_margin'] = [
      'label' => __('Margin', 'dipi-divi-pixel'),
      'type' => 'custom_margin',
      'description' => __('Set Margin of Description.', 'dipi-divi-pixel'),
      'tab_slug' => 'advanced',
      'toggle_slug' => 'content_text',
      'sub_toggle' => 'desc',
      'default' => '0px|0px|0px|0px',
      'mobile_options' => true,
    ];
    $fields['content_desc_padding'] = [
      'label' => __('Padding', 'dipi-divi-pixel'),
      'type' => 'custom_margin',
      'description' => __('Set Padding of Description.', 'dipi-divi-pixel'),
      'tab_slug' => 'advanced',
      'toggle_slug' => 'content_text',
      'sub_toggle' => 'desc',
      'default' => '0px|0px|10px|0px',
      'mobile_options' => true,
    ];
    return $fields;
  }

  public function get_transition_fields_css_props()
  {
      $fields = parent::get_transition_fields_css_props();
  
      return $fields;
  }

  public function get_custom_style($slug_value, $type, $important)
  {
      return sprintf('%1$s: %2$s%3$s;', $type, $slug_value, $important ? ' !important' : '');
  }
  public function get_changed_prop_value($slug, $conv_matrix)
  {
      if (array_key_exists($this->props[$slug], $conv_matrix)) {
          $this->props[$slug] = $conv_matrix[$this->props[$slug]];
      }

  }
  public function apply_custom_style_for_phone(
      $function_name,
      $slug,
      $type,
      $class,
      $important = false,
      $zoom = '',
      $unit = '',
      $wrap_func = '' /* traslate, clac ... */
  ) {
      if (empty($this->props[$slug . '_tablet'])) {
          $this->props[$slug . '_tablet'] = $this->props[$slug];
      }
      if (empty($this->props[$slug . '_phone'])) {
          $this->props[$slug . '_phone'] = $this->props[$slug . '_tablet'];
      }
      if ($zoom === '') {
          $slug_value = $this->props[$slug] . $unit;
          $slug_value_tablet = $this->props[$slug . '_tablet'] . $unit;
          $slug_value_phone = $this->props[$slug . '_phone'] . $unit;
      } else {
          $slug_value = ((float) $this->props[$slug] * $zoom) . $unit;
          $slug_value_tablet = ((float) $this->props[$slug . '_tablet'] * $zoom) . $unit;
          $slug_value_phone = ((float) $this->props[$slug . '_phone'] * $zoom) . $unit;
      }
      if ($wrap_func !== '') {
          $slug_value = "$wrap_func($slug_value)";
          $slug_value_tablet = "$wrap_func($slug_value_tablet)";
          $slug_value_phone = "$wrap_func($slug_value_phone)";
      }

      if (isset($slug_value_phone)
          && !empty($slug_value_phone)) {
          ET_Builder_Element::set_style($function_name, array(
              'selector' => $class,
              'declaration' => $this->get_custom_style($slug_value_phone, $type, $important),
              'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
          ));
      }
  }

  public function apply_custom_style_for_tablet(
      $function_name,
      $slug,
      $type,
      $class,
      $important = false,
      $zoom = '',
      $unit = '',
      $wrap_func = '' /* traslate, clac ... */
  ) {
      if (empty($this->props[$slug . '_tablet'])) {
          $this->props[$slug . '_tablet'] = $this->props[$slug];
      }
      if ($zoom === '') {
          $slug_value = $this->props[$slug] . $unit;
          $slug_value_tablet = $this->props[$slug . '_tablet'] . $unit;
          $slug_value_phone = $this->props[$slug . '_phone'] . $unit;
      } else {
          $slug_value = ((float) $this->props[$slug] * $zoom) . $unit;
          $slug_value_tablet = ((float) $this->props[$slug . '_tablet'] * $zoom) . $unit;
          $slug_value_phone = ((float) $this->props[$slug . '_phone'] * $zoom) . $unit;
      }
      if ($wrap_func !== '') {
          $slug_value = "$wrap_func($slug_value)";
          $slug_value_tablet = "$wrap_func($slug_value_tablet)";
          $slug_value_phone = "$wrap_func($slug_value_phone)";
      }

      if (isset($slug_value_tablet)
          && !empty($slug_value_tablet)) {
          ET_Builder_Element::set_style($function_name, array(
              'selector' => $class,
              'declaration' => $this->get_custom_style($slug_value_tablet, $type, $important),
              'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
          ));
      }
  }

  public function apply_custom_style_for_desktop(
      $function_name,
      $slug,
      $type,
      $class,
      $important = false,
      $zoom = '',
      $unit = '',
      $wrap_func = '' /* traslate, clac ... */
  ) {
      if ($zoom === '') {
          $slug_value = $this->props[$slug] . $unit;
          $slug_value_tablet = $this->props[$slug . '_tablet'] . $unit;
          $slug_value_phone = $this->props[$slug . '_phone'] . $unit;
      } else {
          $slug_value = ((float) $this->props[$slug] * $zoom) . $unit;
          $slug_value_tablet = ((float) $this->props[$slug . '_tablet'] * $zoom) . $unit;
          $slug_value_phone = ((float) $this->props[$slug . '_phone'] * $zoom) . $unit;
      }
      if ($wrap_func !== '') {
          $slug_value = "$wrap_func($slug_value)";
          $slug_value_tablet = "$wrap_func($slug_value_tablet)";
          $slug_value_phone = "$wrap_func($slug_value_phone)";
      }

      if (isset($slug_value) && !empty($slug_value)) {
          ET_Builder_Element::set_style($function_name, array(
              'selector' => $class,
              'declaration' => $this->get_custom_style($slug_value, $type, $important),
          ));
      }
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

  public function apply_custom_style(
      $function_name,
      $slug,
      $type,
      $class,
      $important = false,
      $zoom = '',
      $unit = '') {
      if ($zoom == '') {
          $slug_value = $this->props[$slug] . $unit;
          $slug_value_tablet = $this->props[$slug . '_tablet'] . $unit;
          $slug_value_phone = $this->props[$slug . '_phone'] . $unit;
      } else {
          $slug_value = ((float) $this->props[$slug] * $zoom) . $unit;
          $slug_value_tablet = ((float) $this->props[$slug . '_tablet'] * $zoom) . $unit;
          $slug_value_phone = ((float) $this->props[$slug . '_phone'] * $zoom) . $unit;
      }

      $slug_value_last_edited = $this->props[$slug . '_last_edited'];
      $slug_value_responsive_active = et_pb_get_responsive_status($slug_value_last_edited);

      if (isset($slug_value) && !empty($slug_value)) {
          ET_Builder_Element::set_style($function_name, array(
              'selector' => $class,
              'declaration' => $this->get_custom_style($slug_value, $type, $important),
          ));
      }

      if (isset($slug_value_tablet)
          && !empty($slug_value_tablet)
          && $slug_value_responsive_active) {
          ET_Builder_Element::set_style($function_name, array(
              'selector' => $class,
              'declaration' => $this->get_custom_style($slug_value_tablet, $type, $important),
              'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
          ));
      }

      if (isset($slug_value_phone)
          && !empty($slug_value_phone)
          && $slug_value_responsive_active) {
          ET_Builder_Element::set_style($function_name, array(
              'selector' => $class,
              'declaration' => $this->get_custom_style($slug_value_phone, $type, $important),
              'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
          ));
      }
  }
  public function apply_custom_margin_padding($function_name, $slug, $type, $class, $important = true)
  {
      $slug_value = $this->props[$slug];
      $slug_value_tablet = $this->props[$slug . '_tablet'];
      $slug_value_phone = $this->props[$slug . '_phone'];
      $slug_value_last_edited = $this->props[$slug . '_last_edited'];
      $slug_value_responsive_active = et_pb_get_responsive_status($slug_value_last_edited);

      if (isset($slug_value) && !empty($slug_value)) {
          ET_Builder_Element::set_style($function_name, array(
              'selector' => $class,
              'declaration' => et_builder_get_element_style_css($slug_value, $type, $important),
          ));
      }

      if (isset($slug_value_tablet) && !empty($slug_value_tablet) && $slug_value_responsive_active) {
          ET_Builder_Element::set_style($function_name, array(
              'selector' => $class,
              'declaration' => et_builder_get_element_style_css($slug_value_tablet, $type, $important),
              'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
          ));
      }

      if (isset($slug_value_phone) && !empty($slug_value_phone) && $slug_value_responsive_active) {
          ET_Builder_Element::set_style($function_name, array(
              'selector' => $class,
              'declaration' => et_builder_get_element_style_css($slug_value_phone, $type, $important),
              'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
          ));
      }
  }
  private function replaceEmptyWith($array, $replaceValue)
  {
      foreach ($array as $key => $value) {
          if (empty($value)) {
              $array[$key] = $replaceValue;
          }
      }
      return $array;
  }
  public function get_custom_css_fields_config() {
    $fields = [];
    $fields['image_icon_css'] = [
        'label'    => esc_html__('Image/Icon', 'dipi-divi-pixel'),
        'selector' => '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi_info_circle-small .dipi-info-image-icon-wrap .et-pb-icon'
    ];
    $fields['circle_heading'] = [
        'label'    => esc_html__('Title', 'dipi-divi-pixel'),
        'selector' => '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi-content-heading'
    ];
    $fields['circle_description'] = [
        'label'    => esc_html__('Description', 'dipi-divi-pixel'),
        'selector' => '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi-desc'
    ];
    $fields['circle_button'] = [
      'label'    => esc_html__('Button', 'dipi-divi-pixel'),
      'selector' => '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi_content_button'
   ];
    return $fields;
}
  public function get_advanced_fields_config()
  {
    $advanced_fields = [];
    $advanced_fields["text"] = false;
    $advanced_fields["text_shadow"] = false;
    $advanced_fields["fonts"] = [];
    $advanced_fields["box_shadow"] = [];
    $advanced_fields["transform"] = false;
    $advanced_fields["filters"] = [];
    $advanced_fields['link_options'] = false;

    $content_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle-in';
    $content_wrapper_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle-in .dipi_info_circle_item-content-wrapper';
    
    $info_icon_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi_info_circle-small .dipi-info-image-icon-wrap .et-pb-icon';
    $info_icon_hover_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container  .dipi_info_circle-small:hover .dipi-info-image-icon-wrap .et-pb-icon'
                              .',%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container.active  .dipi_info_circle-small:hover .dipi-info-image-icon-wrap .et-pb-icon';
    $info_icon_active_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container.active .dipi_info_circle-small .dipi-info-image-icon-wrap .et-pb-icon';
    
    $info_image_icon_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi-info-circle.dipi_info_circle-small';
    $info_image_icon_hover_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi-info-circle.dipi_info_circle-small:hover'
                                    .',%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container.active .dipi-info-circle.dipi_info_circle-small:hover';
    $info_image_icon_active_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container.active .dipi-info-circle.dipi_info_circle-small';
    
    $info_image_icon_width_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi-info-image-icon-wrap.dipi-image-wrapper';
    $info_image_icon_hover_width_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi-info-image-icon-wrap.dipi-image-wrapper:hover'
                                          .',%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container.active .dipi-info-image-icon-wrap.dipi-image-wrapper:hover';
    $info_image_icon_active_width_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container.active .dipi-info-image-icon-wrap.dipi-image-wrapper';
   
    $content_icon_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi_info_circle_item-content-wrapper .dipi-content-image-icon-wrap .et-pb-icon';
    $content_image_icon_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi_info_circle_item-content-wrapper .dipi-content-image-icon-wrap';
    $content_image_icon_hover_selector = '%%order_class%%.dipi_info_circle_item:hover .dipi_info_circle_item_container .dipi_info_circle_item-content-wrapper .dipi-content-image-icon-wrap';
    $content_image_icon_width_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi_info_circle_item-content-wrapper .dipi-content-image-icon-wrap.dipi-image-wrapper';

    $content_title_selector = '%%order_class%%.dipi_info_circle_item .dipi-content-text .dipi-content-heading';
    $content_desc_selector = '%%order_class%%.dipi_info_circle_item .dipi-content-text .dipi-desc';
    
    $advanced_fields["box_shadow"]["default"] = [
      'css' => [
          'main' => $content_selector,
      ],
    ];
    $advanced_fields["borders"]["default"] = [
      'css' => [
          'main' => [
              'border_radii' => $content_selector,
              'border_styles' => $content_selector,
          ],
      ],
    ];
    $advanced_fields["background"] = [
      'css' => [
          'main' => $content_selector,
      ],
    ];

    $advanced_fields["margin_padding"] = [
      'css' => [
        'padding' => $content_selector,
        'margin' => $content_selector,
      ],
    ];
    $advanced_fields['max_width'] = [
      'css' => [
        'main' => $content_selector,
      ],
      'use_height' => true,
      'use_max_height' => true,
      'use_module_alignment' => false,
      'options' => [
        'width' => [
            'default' => '80%',
        ],
      ],
    ];
    $advanced_fields['height'] = [
      'css' => [
        'main' => $content_selector,
      ],
      'use_height' => true,
      'use_max_height' => true,
      'options' => [
        'height' => [
            'default' => '80%',
            'default_unit' => '%',
            'range_settings' => [
              'min' => '0',
              'max' => '100',
              'step' => '1',
          ],
        ],
      ],
    ];

    $advanced_fields["fonts"]["header"] = [
      'label' => esc_html__('Heading', 'dipi-divi-pixel'),
      'css' => array(
          'main' => "%%order_class%% h1",
      ),
      'font_size' => array(
          'default' => absint(et_get_option('body_header_size', '30')) . 'px',
      ),
      'toggle_slug' => 'header',
      'sub_toggle' => 'h1',
    ];
    
    $advanced_fields["fonts"]["content_title"] = [
      'label' => esc_html__('Title', 'dipi-divi-pixel'),
      'css' => [
          'main' => $content_title_selector,
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

    $advanced_fields["fonts"]["content_desc"] = [
        'label' => esc_html__('Description', 'dipi-divi-pixel'),
        'css' => [
            'main' => $content_desc_selector,
        ],
        'important' => 'all',
        'hide_text_align' => true,
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

    $advanced_fields["fonts"]["header_2"] = [
        'label' => esc_html__('Heading 2', 'dipi-divi-pixel'),
        'css' => array(
            'main' => "%%order_class%% h2",
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
            'main' => "%%order_class%% h3",
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
            'main' => "%%order_class%% h4",
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
            'main' => "%%order_class%% h5",
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
            'main' => "%%order_class%% h6",
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
    
    $advanced_fields['button']["content_button"] = [
      'label' => esc_html__('Content Button', 'dipi-divi-pixel'),
      'use_alignment' => false,
      'font_size' => array(
        'default' => '14px',
     ),
      'css' => [
          'main' => "%%order_class%% .dipi_content_button.et_pb_button",
          'important' => true,
      ],
      'box_shadow'  => [
          'css' => [
              'important' => true,
          ],
      ],
      'margin_padding' => [
          'css' => [
              'important' => 'all'
          ],
      ],
    ];

    /* Info Image & Icon */
    // Normal
    $advanced_fields['borders']['info_image_icon'] = [
      'css' => [
        'main' => [
          'border_radii'        => $info_image_icon_selector,
          'border_radii_hover'  => $info_image_icon_hover_selector,
          'border_styles'       => $info_image_icon_selector,
          'border_styles_hover' => $info_image_icon_hover_selector,
        ]
      ],
      'defaults' => [
        'border_radii' => 'on | 50% | 50% | 50% | 50%'
      ],
      'label_prefix' => et_builder_i18n( 'Image & Icon' ),
      'tab_slug'     => 'advanced',
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'normal',
    ];
    $advanced_fields["box_shadow"]['info_image_icon'] = [
      'label'             => esc_html__( 'Image Box Shadow', 'dipi-divi-pixel' ),
      'option_category'   => 'layout',
      'tab_slug'          => 'advanced',
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'normal',
      'css'               => [
        'main'        => $info_image_icon_selector,
        'hover'       => $info_image_icon_hover_selector,
        'overlay'     => 'inset',
      ],
      'default_on_fronts' => [
        'color'    => '',
        'position' => '',
      ],
    ];
    // Hover
    $advanced_fields['borders']['info_image_icon_hover'] = [
      'css' => [
        'main' => [
          'border_radii'        => $info_image_icon_hover_selector,
          'border_radii_hover'  => $info_image_icon_hover_selector,
          'border_styles'       => $info_image_icon_hover_selector,
          'border_styles_hover' => $info_image_icon_hover_selector,
        ]
      ],
      'defaults' => [
        'border_radii' => 'on | 50% | 50% | 50% | 50%'
      ],
      'label_prefix' => et_builder_i18n( 'Image & Icon' ),
      'tab_slug'     => 'advanced',
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'hover',
    ];
    $advanced_fields["box_shadow"]['info_image_icon_hover'] = [
      'label'             => esc_html__( 'Image Box Shadow', 'dipi-divi-pixel' ),
      'option_category'   => 'layout',
      'tab_slug'          => 'advanced',
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'hover',
      'css'               => [
        'main'        => $info_image_icon_hover_selector,
        'hover'       => $info_image_icon_hover_selector,
        'overlay'     => 'inset',
      ],
      'default_on_fronts' => [
        'color'    => '',
        'position' => '',
      ],
    ];
    // Active
    $advanced_fields['borders']['info_image_icon_active'] = [
      'css' => [
        'main' => [
          'border_radii'        => $info_image_icon_active_selector,
          'border_radii_hover'  => $info_image_icon_active_selector,
          'border_styles'       => $info_image_icon_active_selector,
          'border_styles_hover' => $info_image_icon_active_selector,
        ]
      ],
      'defaults' => [
        'border_radii' => 'on | 50% | 50% | 50% | 50%'
      ],
      'label_prefix' => et_builder_i18n( 'Image & Icon' ),
      'tab_slug'     => 'advanced',
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'active',
    ];
    $advanced_fields["box_shadow"]['info_image_icon_active'] = [
      'label'             => esc_html__( 'Image Box Shadow', 'dipi-divi-pixel' ),
      'option_category'   => 'layout',
      'tab_slug'          => 'advanced',
      'toggle_slug'  => 'info_image_icon',
      'sub_toggle' => 'active',
      'css'               => [
        'main'        => $info_image_icon_active_selector,
        'hover'       => $info_image_icon_active_selector,
        'overlay'     => 'inset',
      ],
      'default_on_fronts' => [
        'color'    => '',
        'position' => '',
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
      'label_prefix' => et_builder_i18n( 'Image & Icon' ),
      'tab_slug' => 'advanced',
      'toggle_slug' => 'content_image_icon',
      'hover'           => 'tabs',
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
        'hover'           => 'tabs',
    ];

    $advanced_fields["image_icon"]["image_icon"] = [
      'margin_padding'  => [
        'css' => [
          'important' => 'all',
        ],
      ],
      'option_category' => 'layout',
      'tab_slug' => 'advanced',
      'toggle_slug' => 'content_image_icon',
      'label'           => et_builder_i18n( 'Image & Icon' ),
      'css'             => [
        'main'    => $content_image_icon_selector,
        'hover' => $content_image_icon_hover_selector,
      ],
    ];
    $advanced_fields["icon_settings"] = [ /* Need this setting to apply filter */
      'css' => [
        'main' => $content_image_icon_selector,
      ]
    ];
    $advanced_fields["filters"]['child_filters_target'] = [
      'tab_slug'        => 'advanced',
      'toggle_slug'     => 'content_image_icon',
      'label'           => esc_html__( 'Image & Icon', 'dipi-divi-pixel' ),
      'css'             => array(
        'main'        => $content_image_icon_selector,
      ),
    ];
    return $advanced_fields;
  }
  private function _dipi_apply_css($render_slug)
  {
    $info_icon_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi_info_circle-small .dipi-info-image-icon-wrap .et-pb-icon';
    $info_icon_hover_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container  .dipi_info_circle-small:hover .dipi-info-image-icon-wrap .et-pb-icon'
                              .',%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container.active  .dipi_info_circle-small:hover .dipi-info-image-icon-wrap .et-pb-icon';
    $info_icon_active_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container.active .dipi_info_circle-small .dipi-info-image-icon-wrap .et-pb-icon';
    
    $info_image_icon_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi-info-circle.dipi_info_circle-small';
    $info_image_icon_hover_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi-info-circle.dipi_info_circle-small:hover'
                                    .',%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container.active .dipi-info-circle.dipi_info_circle-small:hover';
    $info_image_icon_active_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container.active .dipi-info-circle.dipi_info_circle-small';
    
    $info_image_icon_width_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi-info-image-icon-wrap.dipi-image-wrapper';
    $info_image_icon_hover_width_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi-info-image-icon-wrap.dipi-image-wrapper:hover'
                                          .',%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container.active .dipi-info-image-icon-wrap.dipi-image-wrapper:hover';
    $info_image_icon_active_width_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container.active .dipi-info-image-icon-wrap.dipi-image-wrapper';
   
    $content_icon_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi_info_circle_item-content-wrapper .dipi-content-image-icon-wrap .et-pb-icon';
    $content_image_icon_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi_info_circle_item-content-wrapper .dipi-content-image-icon-wrap';
    $content_image_icon_hover_selector = '%%order_class%%.dipi_info_circle_item:hover .dipi_info_circle_item_container .dipi_info_circle_item-content-wrapper .dipi-content-image-icon-wrap';
    $content_image_icon_width_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi_info_circle_item-content-wrapper .dipi-content-image-icon-wrap.dipi-image-wrapper';

    $content_title_selector = '%%order_class%%.dipi_info_circle_item .dipi-content-text .dipi-content-heading';
    $content_desc_selector = '%%order_class%%.dipi_info_circle_item .dipi-content-text .dipi-desc';

    $image_icon_width              = isset( $this->props['image_icon_width'] ) ? $this->props['image_icon_width'] : '';
    $image_icon_width_tablet       = isset( $this->props['image_icon_width_tablet'] ) ? $this->props['image_icon_width_tablet'] : '';
    $image_icon_width_phone        = isset( $this->props['image_icon_width_phone'] ) ? $this->props['image_icon_width_phone'] : '';
    $image_icon_width_last_edited  = isset( $this->props['image_icon_width_last_edited'] ) ? $this->props['image_icon_width_last_edited'] : '';
    // Images: Add CSS Filters and Mix Blend Mode rules (if set)
    $generate_css_image_filters = '';
    if ( array_key_exists( 'icon_settings', $this->advanced_fields ) && array_key_exists( 'css', $this->advanced_fields['icon_settings'] ) ) {
      $generate_css_image_filters = $this->generate_css_filters(
        $render_slug,
        'child_',
        self::$data_utils->array_get( $this->advanced_fields['icon_settings']['css'], 'main', '%%order_class%%' )
      );
    }
    /* Info Image & Icon */
    // Normal
    $this->generate_styles(
      array(
        'base_attr_name' => 'info_icon_color',
        'selector'       => $info_icon_selector,
        'css_property'   => 'color',
        'render_slug'    => $render_slug,
        'type'           => 'color',
      )
    );
    
    $this->generate_styles(
      array(
        'base_attr_name' => 'info_image_icon_background_color',
        'selector'       => $info_image_icon_selector,
        'css_property'   => 'background-color',
        'render_slug'    => $render_slug,
        'type'           => 'color',
      )
    );

    $this->generate_styles(
      array(
        'base_attr_name' => 'info_image_icon_width',
        'selector'       => $info_icon_selector,
        'css_property'   => 'font-size',
        'render_slug'    => $render_slug,
        'type'           => 'range',
      )
    );

    $this->generate_styles(
      array(
        'base_attr_name' => 'info_image_icon_width',
        'selector'       => $info_image_icon_width_selector,
        'css_property'   => 'width',
        'render_slug'    => $render_slug,
        'type'           => 'range',
      )
    );
    $this->generate_styles(
      array(
        'base_attr_name' => 'info_image_icon_width',
        'selector'       => $info_image_icon_width_selector,
        'css_property'   => 'height',
        'render_slug'    => $render_slug,
        'type'           => 'range',
      )
    );

    $this->apply_custom_margin_padding(
      $render_slug,
      'info_image_icon_margin',
      'margin',
      $info_image_icon_selector 
    );
    $this->apply_custom_margin_padding(
      $render_slug,
      'info_image_icon_padding',
      'padding',
      $info_image_icon_selector 
    );

    // Hover
    $this->apply_custom_style(
      $this->slug,
      'info_icon_hover_color',
      'color',
      $info_icon_hover_selector,
      true
    );
    $this->apply_custom_style(
      $this->slug,
      'info_image_icon_hover_background_color',
      'background-color',
      $info_image_icon_hover_selector,
      true
    );

    $this->generate_styles(
      array(
        'base_attr_name' => 'info_image_icon_hover_width',
        'selector'       => $info_icon_hover_selector,
        'css_property'   => 'font-size',
        'render_slug'    => $render_slug,
        'type'           => 'range',
      )
    );

    $this->generate_styles(
      array(
        'base_attr_name' => 'info_image_icon_hover_width',
        'selector'       => $info_image_icon_hover_width_selector,
        'css_property'   => 'width',
        'render_slug'    => $render_slug,
        'type'           => 'range',
      )
    );
    $this->generate_styles(
      array(
        'base_attr_name' => 'info_image_icon_hover_width',
        'selector'       => $info_image_icon_hover_width_selector,
        'css_property'   => 'height',
        'render_slug'    => $render_slug,
        'type'           => 'range',
      )
    );

    $this->apply_custom_margin_padding(
      $render_slug,
      'info_image_icon_hover_margin',
      'margin',
      $info_image_icon_hover_selector 
    );
    $this->apply_custom_margin_padding(
      $render_slug,
      'info_image_icon_hover_padding',
      'padding',
      $info_image_icon_hover_selector 
    );

    // Active
    $this->generate_styles(
      array(
        'base_attr_name' => 'info_icon_active_color',
        'selector'       => $info_icon_active_selector,
        'css_property'   => 'color',
        'render_slug'    => $render_slug,
        'type'           => 'color',
      )
    );

    $this->generate_styles(
      array(
        'base_attr_name' => 'info_image_icon_active_background_color',
        'selector'       => $info_image_icon_active_selector,
        'css_property'   => 'background-color',
        'render_slug'    => $render_slug,
        'type'           => 'color',
      )
    );

    $this->generate_styles(
      array(
        'base_attr_name' => 'info_image_icon_active_width',
        'selector'       => $info_icon_active_selector,
        'css_property'   => 'font-size',
        'render_slug'    => $render_slug,
        'type'           => 'range',
      )
    );

    $this->generate_styles(
      array(
        'base_attr_name' => 'info_image_icon_active_width',
        'selector'       => $info_image_icon_active_width_selector,
        'css_property'   => 'width',
        'render_slug'    => $render_slug,
        'type'           => 'range',
      )
    );
    $this->generate_styles(
      array(
        'base_attr_name' => 'info_image_icon_active_width',
        'selector'       => $info_image_icon_active_width_selector,
        'css_property'   => 'height',
        'render_slug'    => $render_slug,
        'type'           => 'range',
      )
    );
    $this->apply_custom_margin_padding(
      $render_slug,
      'info_image_icon_active_margin',
      'margin',
      $info_image_icon_active_selector 
    );
    $this->apply_custom_margin_padding(
      $render_slug,
      'info_image_icon_active_padding',
      'padding',
      $info_image_icon_active_selector 
    );

    /* Content Image & Icon */
    $this->generate_styles(
      array(
        'base_attr_name' => 'content_icon_color',
        'selector'       => $content_icon_selector,
        'css_property'   => 'color',
        'render_slug'    => $render_slug,
        'type'           => 'color',
      )
    );
    
    $this->generate_styles(
      array(
        'base_attr_name' => 'content_image_icon_background_color',
        'selector'       => $content_image_icon_selector,
        'css_property'   => 'background-color',
        'render_slug'    => $render_slug,
        'type'           => 'color',
      )
    );

    $this->generate_styles(
      array(
        'base_attr_name' => 'content_image_icon_width',
        'selector'       => $content_icon_selector,
        'css_property'   => 'font-size',
        'render_slug'    => $render_slug,
        'type'           => 'range',
      )
    );

    $this->generate_styles(
      array(
        'base_attr_name' => 'content_image_icon_width',
        'selector'       => $content_image_icon_width_selector,
        'css_property'   => 'width',
        'render_slug'    => $render_slug,
        'type'           => 'range',
      )
    );
    $this->generate_styles(
      array(
        'base_attr_name' => 'content_image_icon_width',
        'selector'       => $content_image_icon_width_selector,
        'css_property'   => 'height',
        'render_slug'    => $render_slug,
        'type'           => 'range',
      )
    );

    /* Content Title */
    $this->apply_custom_margin_padding(
      $render_slug,
      'content_title_margin',
      'margin',
      $content_title_selector 
    );
    $this->apply_custom_margin_padding(
      $render_slug,
      'content_title_padding',
      'padding',
      $content_title_selector 
    );

    /* Content Description */
    $this->apply_custom_margin_padding(
      $render_slug,
      'content_desc_margin',
      'margin',
      $content_desc_selector 
    );
    $this->apply_custom_margin_padding(
      $render_slug,
      'content_desc_padding',
      'padding',
      $content_desc_selector 
    ); 

    $this->dipi_process_spacing_field(
      $render_slug, 
      'content_button_custom_margin',
      'margin',
      "%%order_class%% .dipi_content_button.et_pb_button"
    );
    $this->dipi_process_spacing_field(
      $render_slug, 
      'content_button_custom_padding',
      'padding',
      "%%order_class%% .dipi_content_button.et_pb_button"
    );
  }
  public function _render_info_image_icon($render_slug)
  {
      $info_image_icon = '';
      $info_icon_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi_info_circle-small .dipi-info-image-icon-wrap .et-pb-icon';
      $parallax_image_background = $this->get_parallax_image_background();

      if ('on' == $this->props['use_info_icon']) {
        $icon = ($this->props['info_icon'] === '%&quot;%%' || $this->props['info_icon'] === '%"%%') ? '%%22%%' : $this->props['info_icon'];
        $info_icon = et_pb_process_font_icon($icon);
        $info_image_icon = sprintf(
            '<div class="dipi-info-image-icon-wrap dipi-icon-wrapper">
                <span class="et-pb-icon et-pb-font-icon dipi-info-icon">%1$s</span>
            </div>',
            esc_attr($info_icon)
        );

        $this->dipi_generate_font_icon_styles($render_slug, 'info_icon', $info_icon_selector);
      } else if ('on' !== $this->props['use_info_icon'] && $this->props['info_image'] !== '') {
          $info_image_icon = sprintf(
              '<div class="dipi-info-image-icon-wrap dipi-image-wrapper">
                  <img src="%1$s" class="dipi-info-image" alt="%2$s">
              </div>',
              esc_attr($this->props['info_image']),
              $this->_esc_attr('info_image_alt')
          );
      }
      return sprintf(
        '<div class="dipi_info_circle_item-info_image_icon-wrapper">
          %1$s
        </div>
        ',
        $info_image_icon
      );
      return $info_image_icon;
  }
  public function _render_content($render_slug)
  {
      $url                           = $this->props['url'];
      $url_new_window                = $this->props['url_new_window'];
      $parallax_image_background = $this->get_parallax_image_background();
      $content_image_icon = '';
      $content_icon_selector = '%%order_class%%.dipi_info_circle_item .dipi_info_circle_item_container .dipi_info_circle_item-content-wrapper .dipi-content-image-icon-wrap .et-pb-icon';
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
              '<div class="dipi-content-image-icon-wrap dipi-image-wrapper">
                  <img src="%1$s" class="dipi-content-image" alt="%2$s">
              </div>',
              esc_attr($this->props['content_image']),
              $this->_esc_attr('content_image_alt')
          );
      }

      $content_title_level = $this->props['content_title_level'] ? $this->props['content_title_level'] : 'h2';
      $content_title = '';
      if (isset($this->props['content_title']) && '' !== $this->props['content_title']) {
          $content_title = sprintf(
              '<%2$s class="dipi-content-heading">
                  %1$s
              </%2$s>',
              esc_attr($this->props['content_title']),
              esc_attr($content_title_level)
          );
      }

      $content_description = '';
      if (isset($this->props['content_description'])) {
          $content_description = sprintf(
              '<div class="dipi-desc">%1$s</div>',
              $this->process_content($this->props['content_description'])
          );
      }

      $show_content_button        = $this->props['show_content_button'];
      $content_button_text        = $this->props['content_button_text'];
      $content_button_link        = $this->props['content_button_link'];
      $content_button_rel         = $this->props['content_button_rel'];
      $content_button_icon        = $this->props['content_button_icon'];
      $content_button_link_target = $this->props['content_button_link_target'];
      $content_button_custom      = $this->props['custom_content_button'];

      $content_button = $this->render_button([
          'button_classname' => ["dipi_content_button"],
          'button_custom'    => $content_button_custom,
          'button_rel'       => $content_button_rel,
          'button_text'      => $content_button_text,
          'button_url'       => $content_button_link,
          'custom_icon'      => $content_button_icon,
          'url_new_window'   => $content_button_link_target,
          'has_wrapper'      => false
      ]);
      $content_html = sprintf(
        '%1$s
        <div class="dipi-content-text">
          %2$s
          %3$s
        </div>
        ',
        $content_image_icon,
        $content_title,
        $content_description
       
      );
      if ( ! empty( $url ) ) {
        $target = ( 'on' === $url_new_window ) ? 'target="_blank"' : '';
        $content_html = sprintf(
          '<a href="%1$s" %2$s>
            %3$s
          </a>',
          esc_url( $url ),
          et_core_intentionally_unescaped( $target, 'fixed_string' ),
          et_core_esc_previously( $content_html )
        );
      }
      if ($show_content_button === 'on') {
        $content_html = sprintf(
          '%1$s
          %2$s
          ',
          et_core_esc_previously( $content_html ),
          $content_button
        );
      }

      $content_html = sprintf(
          '%1$s
          <div
            class="dipi_info_circle_item-content-wrapper animated">
            %2$s
          </div>
          ',
          $parallax_image_background,
          $content_html
      );

      return $content_html;
  }
  public function render($attrs, $content, $render_slug)
  {
    global $child_items_count;

    $this->_dipi_apply_css($render_slug);
    
    
    $module_custom_classes = '';
    $output = sprintf(
      '<div class="dipi_info_circle_item_container  %1$s dipi_info_circle_item-%4$s %5$s" data-index="%4$s">
        <div class="dipi-info-circle dipi_info_circle-small animated">
          %2$s
        </div>
        <div class="dipi-info-circle dipi_info_circle-in">
          %3$s
        </div>
      </div>
      ',
      $module_custom_classes,
      $this->_render_info_image_icon($render_slug),
      $this->_render_content($render_slug),
      $child_items_count,
      $child_items_count === 0 ? ' active' : ''
    );
    $child_items_count ++;
    return $output;
  }
}

new DIPI_InfoCircle_Item();
