<?php

class DIPI_TableMaker extends DIPI_Builder_Module {
  public $slug = 'dipi_table_maker';
  public $vb_support = 'on';

  protected $module_credits = array(
    'module_uri' => 'https://divi-pixel.com/modules/image-slider',
    'author' => 'Divi Pixel',
    'author_uri' => 'https://divi-pixel.com',
  );

  public function init() {
    $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
    $this->name = esc_html__('Pixel Table Maker', 'dipi-divi-pixel');
    $this->child_slug = 'dipi_table_maker_child';
    $this->main_css_element = '%%order_class%%.dipi_table_maker';

    $this->settings_modal_toggles = [
      'general' => [
        'toggles' => [
          'table_title_desc' => esc_html__('Table Title and Description', 'dipi-divi-pixel'),
          'table_settings' => esc_html__('Table Settings', 'dipi-divi-pixel'),
          'table_overflow' => esc_html__('Table Overflow', 'dipi-divi-pixel'),
          'table_corners' => esc_html__('Table Corners', 'dipi-divi-pixel'),
          'table_responsive' => esc_html__('Table Responsive', 'dipi-divi-pixel'),
          'table_border' => esc_html__('Table Border', 'dipi-divi-pixel'),
          'table_strip' => esc_html__('Table Stripe', 'dipi-divi-pixel'),
          'table_hover_effect' => esc_html__('Table Hover Effect', 'dipi-divi-pixel'),
          'advanced_settings' => esc_html__('Advanced Settings', 'dipi-divi-pixel'),
        ],
      ],
      'advanced' => [
        'toggles' => [
          'table_title' => esc_html__('Table Title', 'dipi-divi-pixel'),
          'table_description' => esc_html__('Table Description', 'dipi-divi-pixel'),
          'table_settings' => esc_html__('Table', 'dipi-divi-pixel'),
          'content_image_icon' => esc_html__('Content Image & Icon', 'dipi-divi-pixel'),
          'content_button' => esc_html__('Content Button', 'dipi-divi-pixel'),
          'table_size_overflow' => esc_html__('Table Size & Overflow', 'dipi-divi-pixel'),
          'table_text' =>  [
            'sub_toggles' => [
                'title' => [
                    'name' => 'Title',
                ],
                'desc' => [
                    'name' => 'Description',
                ],
            ],
            'tabbed_subtoggles' => true,
            'title' => esc_html__('Table Cell Text', 'dipi-divi-pixel'),
          ],
          'table_cells' => esc_html__('Table Cells', 'dipi-divi-pixel'),
          'column_header_text' => [
            'sub_toggles' => [
              'title' => [
                  'name' => 'Title',
              ],
              'desc' => [
                  'name' => 'Description',
              ],
            ],
            'tabbed_subtoggles' => true,
            'title' => esc_html__('Column Header Text', 'dipi-divi-pixel'),
          ],
          'column_header_cells' => esc_html__('Column Header Cells', 'dipi-divi-pixel'),
          'row_header_text' => [
            'sub_toggles' => [
              'title' => [
                  'name' => 'Title',
              ],
              'desc' => [
                  'name' => 'Description',
              ],
            ],
            'tabbed_subtoggles' => true,
            'title' => esc_html__('Row Header Text', 'dipi-divi-pixel'),
          ],
          'row_header_cells' => esc_html__('Row Header Cells', 'dipi-divi-pixel'),
          'column_footer_cells' => esc_html__('Column Footer Cells', 'dipi-divi-pixel'),
          'row_footer_cells' => esc_html__('Row Footer Cells', 'dipi-divi-pixel'),
          'table_accordion' => array(
            'title' => esc_html__('Table Accordion', 'dipi-divi-pixel'),
            'tabbed_subtoggles' => true,
            'sub_toggles' => [
                'closed' => [
                    'name' => 'Closed',
                ],
                'opened' => [
                    'name' => 'Opened',
                ],
            ],
        ),
        ]
      ]
    ];
  }
  
  public function get_custom_css_fields_config() {
      $custom_css_fields = [];
      
      return $custom_css_fields;
  }

  public function get_fields() 
  {
    $et_accent_color = et_builder_accent_color();
    $image_icon_placement = array(
      'top' => esc_html__('Top', 'dipi-divi-pixel'),
    );

    if (!is_rtl()) {
      $image_icon_placement['left'] = esc_html__('Left', 'dipi-divi-pixel');
    } else {
      $image_icon_placement['right'] = esc_html__('Right', 'dipi-divi-pixel');
    }
    $fields = [];
    /* Table Title and Description */
    $fields['show_table_title'] = [
      'label' => esc_html__('Show Table Title', 'dipi-divi-pixel'),
      'type' => 'yes_no_button',
      'option_category' => 'configuration',
      'toggle_slug' => 'table_title_desc',
      'default' => 'off',
      'options' => array(
          'off' => esc_html__('Off', 'dipi-divi-pixel'),
          'on' => esc_html__('On', 'dipi-divi-pixel'),
      ),
    ];
    $fields["table_title"] = [
      'label' => esc_html__('Table Title', 'dipi-divi-pixel'),
      'type' => 'text',
      'depends_show_if' => 'default',
      'toggle_slug' => 'table_title_desc',
      'dynamic_content' => 'text',
      'show_if' => [
        'show_table_title' => 'on',
      ],
    ];
    $fields["table_title_position"] = [
      'label' => esc_html__('Table Title Position', 'dipi-divi-pixel'),
      'type' => 'select',
      'default' => 'above',
      'options' => array(
          'above' =>  esc_html__('Above', 'dipi-divi-pixel'),
          'below' =>  esc_html__('Below', 'dipi-divi-pixel'),
          // 'hidden' =>  esc_html__('Hidden', 'dipi-divi-pixel'),
      ),
      'show_if' => [
          'show_table_title' => 'on',
      ],
      'toggle_slug' => 'table_title_desc',
    ];
    /*
    $description = esc_html__(
      'The title will be visible to screen readers only.', 'dipi-divi-pixel');
    $fields['tbl_title_warning']             =   array(
      'message'                       =>  $description,
      'tab_slug'                      => 'general',
      'toggle_slug'                   => 'table_title_desc',
      'type'                          => 'warning',
      'value'                         =>  true,
      'display_if'                    =>  true,
      'show_if'                       =>  array(
          'show_table_title'            => 'on',
          'table_title_position'        => 'hidden',
      ),
    );*/

    $fields['show_table_description'] = [
      'label' => esc_html__('Show Table Description', 'dipi-divi-pixel'),
      'type' => 'yes_no_button',
      'option_category' => 'configuration',
      'toggle_slug' => 'table_title_desc',
      'default' => 'off',
      'options' => array(
          'off' => esc_html__('Off', 'dipi-divi-pixel'),
          'on' => esc_html__('On', 'dipi-divi-pixel'),
      ),
    ];
    $fields["table_description"] = [
      'label' => esc_html__('Table Description', 'dipi-divi-pixel'),
      'type' => 'text',
      'depends_show_if' => 'default',
      'toggle_slug' => 'table_title_desc',
      'dynamic_content' => 'text',
      'show_if' => [
        'show_table_description' => 'on',
      ],
    ];
    $fields["table_description_position"] = [
      'label' => esc_html__('Table Description Position', 'dipi-divi-pixel'),
      'type' => 'select',
      'default' => 'above',
      'options' => array(
          'above' =>  esc_html__('Above', 'dipi-divi-pixel'),
          'below' =>  esc_html__('Below', 'dipi-divi-pixel'),
          //'hidden' =>  esc_html__('Hidden', 'dipi-divi-pixel'),
      ),
      'show_if' => [
          'show_table_description' => 'on',
      ],
      'toggle_slug' => 'table_title_desc',
    ];
    /*
    $description = esc_html__(
      'The description will be visible to screen readers only.', 'dvmd-table-maker');
    $fields['tbl_desc_warning']             =   array(
      'message'                       =>  $description,
      'tab_slug'                      => 'general',
      'toggle_slug'                   => 'table_title_desc',
      'type'                          => 'warning',
      'value'                         =>  true,
      'display_if'                    =>  true,
      'show_if'                       =>  array(
          'show_table_description'            => 'on',
          'table_description_position'        => 'hidden',
      ),
    );*/
    // Table Settings
    /* $fields["display_mode"] = [
      'label' => esc_html__('Display Mode', 'dipi-divi-pixel'),
      'description' => esc_html__('', 'dipi-divi-pixel'),
      'type' => 'select',
      'default' => 'table-row',
      'options' => array(
          'table-row' =>  esc_html__('Table', 'dipi-divi-pixel'),
          'grid' =>  esc_html__('Grid', 'dipi-divi-pixel'),
      ),
      'toggle_slug' => 'table_settings',
    ]; */
    $fields["column_count"] = [
      'label' => esc_html__('Column Count', 'et_builder'),
      'type' => 'range',
      'default' => '1',
      'default_on_front' => '1',
      'unitless' => true,
      'range_settings' => array(
          'min' => '1',
          'max' => '100',
          'step' => '1',
      ),
      'toggle_slug' => 'table_settings',
    ];
    $fields["min_row_count"] = [
      'label' => esc_html__('Min Row Count', 'et_builder'),
      'type' => 'range',
      'default' => '0',
      'default_on_front' => '0',
      'unitless' => true,
      'range_settings' => array(
          'min' => '0',
          'max' => '100',
          'step' => '1',
      ),
      'toggle_slug' => 'table_settings',
    ];
    
    $fields["column_header_count"] = [
      'label' => esc_html__('Column Header Count', 'et_builder'),
      'type' => 'range',
      'default' => '1',
      'default_on_front' => '1',
      'unitless' => true,
      'range_settings' => array(
          'min' => '1',
          'max' => '10',
          'step' => '1',
      ),
      'toggle_slug' => 'table_settings',
    ];
    /*$fields["row_header_count"] = [
      'label' => esc_html__('Row Header Count', 'et_builder'),
      'type' => 'range',
      'default' => '1',
      'default_on_front' => '1',
      'unitless' => true,
      'range_settings' => array(
          'min' => '0',
          'max' => '10',
          'step' => '1',
      ),
      'toggle_slug' => 'table_settings',
    ];*/
    /*
    $fields["column_footer_count"] = [
      'label' => esc_html__('Column Footer Count', 'et_builder'),
      'type' => 'range',
      'default' => '0',
      'default_on_front' => '0',
      'unitless' => true,
      'range_settings' => array(
          'min' => '1',
          'max' => '10',
          'step' => '1',
      ),
      'toggle_slug' => 'table_settings',
    ];
    $fields["row_footer_count"] = [
      'label' => esc_html__('Row Footer Count', 'et_builder'),
      'type' => 'range',
      'default' => '0',
      'default_on_front' => '0',
      'unitless' => true,
      'range_settings' => array(
          'min' => '1',
          'max' => '10',
          'step' => '1',
      ),
      'toggle_slug' => 'table_settings',
    ];
    // Table Overflow 
    $fields["show_scrollbar"] = [
      'default' => 'off',
      'label' => esc_html__('Show Scrollbar', 'dipi-divi-pixel'),
      'type' => 'yes_no_button',
      'option_category' => 'configuration',
      'options' => [
          'on' => esc_html__('Yes', 'dipi-divi-pixel'),
          'off' => esc_html__('No', 'dipi-divi-pixel'),
      ],
      'toggle_slug' => 'table_overflow',
    ];
    $fields["column_headers_sticky"] = [
      'default' => 'on',
      'label' => esc_html__('Column Headers Sticky', 'dipi-divi-pixel'),
      'type' => 'yes_no_button',
      'option_category' => 'configuration',
      'options' => [
          'on' => esc_html__('Yes', 'dipi-divi-pixel'),
          'off' => esc_html__('No', 'dipi-divi-pixel'),
      ],
      'toggle_slug' => 'table_overflow',
    ];
    $fields["row_headers_sticky"] = [
      'default' => 'off',
      'label' => esc_html__('Row Headers Sticky', 'dipi-divi-pixel'),
      'type' => 'yes_no_button',
      'option_category' => 'configuration',
      'options' => [
          'on' => esc_html__('Yes', 'dipi-divi-pixel'),
          'off' => esc_html__('No', 'dipi-divi-pixel'),
      ],
      'toggle_slug' => 'table_overflow',
    ];
    
    // Table Corners 
    $fields["show_top_left_corner"] = [
      'default' => 'off',
      'label' => esc_html__('Show Top-Left Corner', 'dipi-divi-pixel'),
      'type' => 'yes_no_button',
      'option_category' => 'configuration',
      'options' => [
          'on' => esc_html__('Yes', 'dipi-divi-pixel'),
          'off' => esc_html__('No', 'dipi-divi-pixel'),
      ],
      'toggle_slug' => 'table_corners',
    ];
    $fields["top_left_style"] = [
      'label' => esc_html__('Top-Left Style', 'dipi-divi-pixel'),
      'type' => 'select',
      'default' => 'col_header',
      'options' => array(
          'col_header' =>  esc_html__('Col Header', 'dipi-divi-pixel'),
          'row_header' =>  esc_html__('Row Header', 'dipi-divi-pixel'),
      ),
      'show_if' => [
          'show_top_left_corner' => 'on',
      ],
      'toggle_slug' => 'table_corners',
    ];
    $fields["show_top_right_corner"] = [
      'default' => 'off',
      'label' => esc_html__('Show Top-Right Corner', 'dipi-divi-pixel'),
      'type' => 'yes_no_button',
      'option_category' => 'configuration',
      'options' => [
          'on' => esc_html__('Yes', 'dipi-divi-pixel'),
          'off' => esc_html__('No', 'dipi-divi-pixel'),
      ],
      'toggle_slug' => 'table_corners',
    ];
    $fields["top_right_style"] = [
      'label' => esc_html__('Top-Right Style', 'dipi-divi-pixel'),
      'type' => 'select',
      'default' => 'col_header',
      'options' => array(
          'col_header' =>  esc_html__('Col Header', 'dipi-divi-pixel'),
          'row_header' =>  esc_html__('Row Header', 'dipi-divi-pixel'),
      ),
      'show_if' => [
          'show_top_right_corner' => 'on',
      ],
      'toggle_slug' => 'table_corners',
    ];
    $fields["show_bottom_left_corner"] = [
      'default' => 'off',
      'label' => esc_html__('Show Bottom-Left Corner', 'dipi-divi-pixel'),
      'type' => 'yes_no_button',
      'option_category' => 'configuration',
      'options' => [
          'on' => esc_html__('Yes', 'dipi-divi-pixel'),
          'off' => esc_html__('No', 'dipi-divi-pixel'),
      ],
      'toggle_slug' => 'table_corners',
    ];
    $fields["bottom_left_style"] = [
      'label' => esc_html__('Bottom-Left Style', 'dipi-divi-pixel'),
      'type' => 'select',
      'default' => 'row_footer',
      'options' => array(
          'col_footer' =>  esc_html__('Col Footer', 'dipi-divi-pixel'),
          'row_footer' =>  esc_html__('Row Footer', 'dipi-divi-pixel'),
      ),
      'show_if' => [
          'show_bottom_left_corner' => 'on',
      ],
      'toggle_slug' => 'table_corners',
    ];
    $fields["show_bottom_right_corner"] = [
      'default' => 'off',
      'label' => esc_html__('Show Bottom-Right Corner', 'dipi-divi-pixel'),
      'type' => 'yes_no_button',
      'option_category' => 'configuration',
      'options' => [
          'on' => esc_html__('Yes', 'dipi-divi-pixel'),
          'off' => esc_html__('No', 'dipi-divi-pixel'),
      ],
      'toggle_slug' => 'table_corners',
    ];
    $fields["bottom_right_style"] = [
      'label' => esc_html__('Bottom-Right Style', 'dipi-divi-pixel'),
      'type' => 'select',
      'default' => 'row_footer',
      'options' => array(
          'col_footer' =>  esc_html__('Col Footer', 'dipi-divi-pixel'),
          'row_footer' =>  esc_html__('Row Footer', 'dipi-divi-pixel'),
      ),
      'show_if' => [
          'show_bottom_right_corner' => 'on',
      ],
      'toggle_slug' => 'table_corners',
    ]; */
    /* Table Responsive */
    $fields["enable_responsive"] = [
      'default' => 'off',
      'label' => esc_html__('Enable Responsive', 'dipi-divi-pixel'),
      'type' => 'yes_no_button',
      'option_category' => 'configuration',
      'options' => [
          'on' => esc_html__('Yes', 'dipi-divi-pixel'),
          'off' => esc_html__('No', 'dipi-divi-pixel'),
      ],
      'toggle_slug' => 'table_responsive',
    ];
    $fields["responsive_breakpoint"] = [
      'label' => esc_html__('Responsive Breakpoint', 'dipi-divi-pixel'),
      'type' => 'select',
      'default' => 'mobile',
      'options' => array(
          'desktop' =>  esc_html__('Desktop', 'dipi-divi-pixel'),
          'tablet' =>  esc_html__('Tablet', 'dipi-divi-pixel'),
          'mobile' =>  esc_html__('Mobile', 'dipi-divi-pixel'),
      ),
      'show_if' => [
          'enable_responsive' => 'on',
      ],
      'toggle_slug' => 'table_responsive',
    ];
    /*$fields["break_by"] = [
      'label' => esc_html__('Break by', 'dipi-divi-pixel'),
      'type' => 'select',
      'default' => 'row',
      'options' => array(
          'row' =>  esc_html__('Row', 'dipi-divi-pixel'),
          'column' =>  esc_html__('Column', 'dipi-divi-pixel'),
      ),
      'show_if' => [
          'enable_responsive' => 'on',
      ],
      'toggle_slug' => 'table_responsive',
    ];*/
    $fields["display_as"] = [
      'label' => esc_html__('Display As', 'dipi-divi-pixel'),
      'description' => esc_html__('Here you can choose whether the table will display as blocks or accordion.', 'dipi-divi-pixel'),
      'type' => 'select',
      'default' => 'block',
      'options' => array(
          'block' =>  esc_html__('Block', 'dipi-divi-pixel'),
          'accordion' =>  esc_html__('Accordion', 'dipi-divi-pixel'),
      ),
      'show_if' => [
          'enable_responsive' => 'on',
      ],
      'toggle_slug' => 'table_responsive',
    ];
    $fields["opened_toggle_indexes"] = [
      'label' => esc_html__('Opened Toggle Index(es)', 'dipi-divi-pixel'),
      'description' => esc_html__('Here you can set which of the accordion toggles should be opened. Toggles are numbered, starting with number one. Can set multiple Toggle indexes combined with comma.', 'dipi-divi-pixel'),
      'type' => 'text',
      'default' => '1',
      'mobile_options' => true,
      'show_if' => [
        'enable_responsive' => 'on',
        'display_as' => 'accordion',
      ],
      'toggle_slug' => 'table_responsive',
    ];
    $fields["responsive_spacing"] = [
      'label' => esc_html__('Spacing Between Block/Accordion', 'dipi-divi-pixel'),
      'type' => 'range',
      'default' => '10px',
      'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
      'default_unit' => 'px',
      'range_settings' => [
          'min' => '1',
          'max' => '100',
          'step' => '1',
      ],
      'mobile_options' => true,
      'show_if' => [
        'enable_responsive' => 'on',
      ],
      'toggle_slug' => 'table_responsive',
    ];
    /*
    // Table Border
    $fields["table_border"] = [
      'default' => 'on',
      'label' => esc_html__('Table Border', 'dipi-divi-pixel'),
      'type' => 'yes_no_button',
      'option_category' => 'configuration',
      'options' => [
          'on' => esc_html__('Yes', 'dipi-divi-pixel'),
          'off' => esc_html__('No', 'dipi-divi-pixel'),
      ],
      'toggle_slug' => 'table_responsive',
    ];
    $fields["th_border"] = [
      'default' => 'on',
      'label' => esc_html__('Table Header Border', 'dipi-divi-pixel'),
      'type' => 'yes_no_button',
      'option_category' => 'configuration',
      'options' => [
          'on' => esc_html__('Yes', 'dipi-divi-pixel'),
          'off' => esc_html__('No', 'dipi-divi-pixel'),
      ],
      'toggle_slug' => 'table_responsive',
    ];
    $fields["td_border"] = [
      'default' => 'on',
      'label' => esc_html__('Table Cell Border', 'dipi-divi-pixel'),
      'type' => 'yes_no_button',
      'option_category' => 'configuration',
      'options' => [
          'on' => esc_html__('Yes', 'dipi-divi-pixel'),
          'off' => esc_html__('No', 'dipi-divi-pixel'),
      ],
      'toggle_slug' => 'table_responsive',
    ]; */

    /*
    // Table Strip
    $fields["enable_table_stripe"] = [
      'default' => 'off',
      'label' => esc_html__('Enable Table Stripe', 'dipi-divi-pixel'),
      'type' => 'yes_no_button',
      'option_category' => 'configuration',
      'options' => [
          'on' => esc_html__('Yes', 'dipi-divi-pixel'),
          'off' => esc_html__('No', 'dipi-divi-pixel'),
      ],
      'toggle_slug' => 'table_strip',
    ];
    $fields["stripe_direction"] = [
      'label' => esc_html__('Direction', 'dipi-divi-pixel'),
      'type' => 'select',
      'default' => 'row',
      'options' => array(
          'row' =>  esc_html__('Row', 'dipi-divi-pixel'),
          'column' =>  esc_html__('Column', 'dipi-divi-pixel'),
      ),
      'show_if' => [
          'enable_table_stripe' => 'on',
      ],
      'toggle_slug' => 'table_strip',
    ];
    $fields["stripe_start"] = [
      'label' => esc_html__('Start', 'dipi-divi-pixel'),
      'type' => 'select',
      'default' => 'row',
      'options' => array(
          'even' =>  esc_html__('Even', 'dipi-divi-pixel'),
          'odd' =>  esc_html__('Odd', 'dipi-divi-pixel'),
      ),
      'show_if' => [
          'enable_table_stripe' => 'on',
      ],
      'toggle_slug' => 'table_strip',
    ];

    $fields['stripe_color'] = [
      'label' => esc_html('Stripe Color', 'dipi-divi-pixel'),
      'type' => 'color-alpha',
      'default' => et_builder_accent_color(),
      'show_if' => [
        'enable_table_stripe' => 'on',
      ],
      'toggle_slug' => 'table_strip',
    ];

    //  Table Hover
    $fields["enable_table_hover_effect"] = [
      'default' => 'off',
      'label' => esc_html__('Enable Table Hover Effect', 'dipi-divi-pixel'),
      'type' => 'yes_no_button',
      'option_category' => 'configuration',
      'options' => [
          'on' => esc_html__('Yes', 'dipi-divi-pixel'),
          'off' => esc_html__('No', 'dipi-divi-pixel'),
      ],
      'toggle_slug' => 'table_hover_effect',
    ];
    $fields["hover_effect_direction"] = [
      'label' => esc_html__('Direction', 'dipi-divi-pixel'),
      'type' => 'select',
      'default' => 'row',
      'options' => array(
          'row' =>  esc_html__('Row', 'dipi-divi-pixel'),
          'column' =>  esc_html__('Column', 'dipi-divi-pixel'),
      ),
      'show_if' => [
          'enable_table_hover_effect' => 'on',
      ],
      'toggle_slug' => 'table_hover_effect',
    ];
    $fields['hover_effect_color'] = [
      'label' => esc_html('Hover Efect Color', 'dipi-divi-pixel'),
      'type' => 'color-alpha',
      'default' => et_builder_accent_color(),
      'show_if' => [
        'enable_table_stripe' => 'on',
      ],
      'toggle_slug' => 'table_hover_effect',
    ];*/
    $fields['table_border_collapse'] = [
      'label' => esc_html__('Border Collapse', 'dipi-divi-pixel'),
      'type' => 'select',
      'option_category' => 'layout',
      'options' => [
        'collapse' => esc_html__('Collapse', 'dipi-divi-pixel'),
        'separate' => esc_html__('Separate', 'dipi-divi-pixel'),
      ],
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_settings',
      'default_on_front' => 'collapse',
      'mobile_options' => true,
    ];
    /* Content Image & Icon */
    $fields["show_lightbox"] = [
      'label' => esc_html__('Open Image in Lightbox', 'dipi-divi-pixel'),
      'type' => 'yes_no_button',
      'option_category' => 'basic_option',
      'default' => 'on',
      'options' => array(
          'off' => esc_html__('No', 'dipi-divi-pixel'),
          'on' => esc_html__('Yes', 'dipi-divi-pixel'),
      ),
      'tab_slug' => 'advanced',
      'toggle_slug' => 'content_image_icon',
      'description' => esc_html__('Whether or not to show lightbox.', 'dipi-divi-pixel'),
      'mobile_options' => true,
  ];
    $fields['content_icon_color'] = [
      'default' => $et_accent_color,
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
        'default' => 'transparent',
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
        'default' => '96px',
    ];
    $fields['icon_placement'] = [
      'label' => esc_html__('Image/Icon Placement', 'dipi-divi-pixel'),
      'type' => 'select',
      'option_category' => 'layout',
      'options' => $image_icon_placement,
      'tab_slug' => 'advanced',
      'toggle_slug' => 'content_image_icon',
      'description' => esc_html__('Here you can choose where to place the icon.', 'dipi-divi-pixel'),
      'default_on_front' => 'top',
      'mobile_options' => true,
    ];
    


    $fields['icon_alignment'] = [
        'label' => esc_html__('Image/Icon Alignment', 'dipi-divi-pixel'),
        'description' => esc_html__('Align image/icon to the left, right or center.', 'dipi-divi-pixel'),
        'type' => 'align',
        'option_category' => 'layout',
        'options' => et_builder_get_text_orientation_options(array('justified')),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'content_image_icon',
        'default' => 'center',
        'mobile_options' => true,
        'sticky' => true,
    ];
    /* Content Title Spacing */
    $fields['content_title_margin'] = [
      'label' => __('Margin', 'dipi-divi-pixel'),
      'type' => 'custom_margin',
      'description' => __('Set Margin of Title.', 'dipi-divi-pixel'),
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_text',
      'sub_toggle' => 'title',
      'default' => '0px|0px|10px|0px',
      'mobile_options' => true,
    ];
    $fields['content_title_padding'] = [
        'label' => __('Padding', 'dipi-divi-pixel'),
        'type' => 'custom_margin',
        'description' => __('Set Padding of Title.', 'dipi-divi-pixel'),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'table_text',
        'sub_toggle' => 'title',
        'default' => '0px|0px|0px|0px',
        'mobile_options' => true,
    ];
    $fields['content_desc_margin'] = [
        'label' => __('Margin', 'dipi-divi-pixel'),
        'type' => 'custom_margin',
        'description' => __('Set Margin of Description.', 'dipi-divi-pixel'),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'table_text',
        'sub_toggle' => 'desc',
        'default' => '10px|0px|10px|0px',
        'mobile_options' => true,
    ];
    $fields['content_desc_padding'] = [
        'label' => __('Padding', 'dipi-divi-pixel'),
        'type' => 'custom_margin',
        'description' => __('Set Padding of Description.', 'dipi-divi-pixel'),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'table_text',
        'sub_toggle' => 'desc',
        'default' => '0px|0px|0px|0px',
        'mobile_options' => true,
    ];
    // Table Rows
    $fields['cell_height'] = [
      'label' => esc_html__('Cell Height', 'dipi-divi-pixel'),
      'type' => 'range',
      'option_category' => 'configuration',
      'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
      'range_settings' => [
          'min' => '0',
          'max' => '500',
          'step' => '10',
      ],
      'mobile_options' => true,
      'default' => "",
      'default_unit' => 'px',
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_size_overflow',
    ];
    $fields['cell_min_height'] = [
      'label' => esc_html__('Cell Min Height', 'dipi-divi-pixel'),
      'type' => 'range',
      'option_category' => 'configuration',
      'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
      'range_settings' => [
          'min' => '0',
          'max' => '500',
          'step' => '10',
      ],
      'mobile_options' => true,
      'default_unit' => 'px',
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_size_overflow',
    ];
    $fields['cell_max_height'] = [
      'label' => esc_html__('Cell Max Height', 'dipi-divi-pixel'),
      'type' => 'range',
      'option_category' => 'configuration',
      'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
      'range_settings' => [
          'min' => '0',
          'max' => '500',
          'step' => '10',
      ],
      'mobile_options' => true,
      'default_unit' => 'px',
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_size_overflow',
    ];
    
    $fields["set_width_by"] = [
      'label' => esc_html__('Set Width By', 'dipi-divi-pixel'),
      'type' => 'select',
      'default' => 'table',
      'options' => array(
          'table' =>  esc_html__('Table', 'dipi-divi-pixel'),
          'cell' =>  esc_html__('Cell', 'dipi-divi-pixel'),
      ),
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_size_overflow',
    ];
    $fields['table_width'] = [
      'label' => esc_html__('Table Width', 'dipi-divi-pixel'),
      'type' => 'range',
      'option_category' => 'configuration',
      'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
      'range_settings' => [
          'min' => '0',
          'max' => '500',
          'step' => '10',
      ],
      'mobile_options' => true,
      'default' => '100%',
      'default_unit' => '%',
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_size_overflow',
      'show_if' => [
        'set_width_by' => 'table',
      ],
    ];
    $fields['table_min_width'] = [
      'label' => esc_html__('Table Min Width', 'dipi-divi-pixel'),
      'type' => 'range',
      'option_category' => 'configuration',
      'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
      'range_settings' => [
          'min' => '0',
          'max' => '500',
          'step' => '10',
      ],
      'mobile_options' => true,
      'default_unit' => 'px',
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_size_overflow',
      'show_if' => [
        'set_width_by' => 'table',
      ],
    ];
    $fields['table_max_width'] = [
      'label' => esc_html__('Table Max Width', 'dipi-divi-pixel'),
      'type' => 'range',
      'option_category' => 'configuration',
      'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
      'range_settings' => [
          'min' => '0',
          'max' => '500',
          'step' => '10',
      ],
      'mobile_options' => true,
      'default_unit' => 'px',
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_size_overflow',
      'show_if' => [
        'set_width_by' => 'table',
      ],
    ];
    // Table Cell Width
    $fields['cell_width'] = [
      'label' => esc_html__('Cell Width', 'dipi-divi-pixel'),
      'type' => 'range',
      'option_category' => 'configuration',
      'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
      'range_settings' => [
          'min' => '0',
          'max' => '500',
          'step' => '10',
      ],
      'mobile_options' => true,
      'default_unit' => 'px',
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_size_overflow',
      'show_if' => [
        'set_width_by' => 'cell',
      ],
    ];
    $fields['cell_min_width'] = [
      'label' => esc_html__('Cell Min Width', 'dipi-divi-pixel'),
      'type' => 'range',
      'option_category' => 'configuration',
      'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
      'range_settings' => [
          'min' => '0',
          'max' => '500',
          'step' => '10',
      ],
      'mobile_options' => true,
      'default_unit' => 'px',
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_size_overflow',
      'show_if' => [
        'set_width_by' => 'cell',
      ],
    ];
    $fields['cell_max_width'] = [
      'label' => esc_html__('Cell Max Width', 'dipi-divi-pixel'),
      'type' => 'range',
      'option_category' => 'configuration',
      'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
      'range_settings' => [
          'min' => '0',
          'max' => '500',
          'step' => '10',
      ],
      'mobile_options' => true,
      'default_unit' => 'px',
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_size_overflow',
      'show_if' => [
        'set_width_by' => 'cell',
      ],
    ];
    
    $fields["cell_x_overflow"] = [
      'label' => esc_html__('Cell Horizontal Overflow', 'dipi-divi-pixel'),
      'type' => 'select',
      'default' => 'initial',
      'options' => array(
          'initial' =>  esc_html__('Default', 'dipi-divi-pixel'),
          'visible' =>  esc_html__('Visible', 'dipi-divi-pixel'),
          'scroll' =>  esc_html__('Scroll', 'dipi-divi-pixel'),
          'auto' =>  esc_html__('Auto', 'dipi-divi-pixel'),
          'hidden' =>  esc_html__('Hidden', 'dipi-divi-pixel'),
          // 'hidden' =>  esc_html__('Hidden', 'dipi-divi-pixel'),
      ),
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_size_overflow',
    ];
    $fields["cell_y_overflow"] = [
      'label' => esc_html__('Cell Vertical Overflow', 'dipi-divi-pixel'),
      'type' => 'select',
      'default' => 'initial',
      'options' => array(
          'initial' =>  esc_html__('Default', 'dipi-divi-pixel'),
          'visible' =>  esc_html__('Visible', 'dipi-divi-pixel'),
          'scroll' =>  esc_html__('Scroll', 'dipi-divi-pixel'),
          'auto' =>  esc_html__('Auto', 'dipi-divi-pixel'),
          'hidden' =>  esc_html__('Hidden', 'dipi-divi-pixel'),
          // 'hidden' =>  esc_html__('Hidden', 'dipi-divi-pixel'),
      ),
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_size_overflow',
    ];
    $fields['cell_bg_color'] = [
      'label' => esc_html__('Cell Background Color', 'dipi-divi-pixel'),
      'type' => 'color-alpha',
      'toggle_slug' => 'table_cells',
      'tab_slug' => 'advanced',
      'default' => 'transparent',
    ];
    $fields['cell_padding'] = [
      'label' => __('Cell Padding', 'et_builder'),
      'type' => 'custom_margin',
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_cells',
      'default' => '10px|10px|10px|10px',
      'mobile_options' => true,
    ];
    $fields['content_vertical_alignment'] = [
      'label' => esc_html__('Vertical Alignment', 'dipi-divi-pixel'),
      'description' => esc_html__('This setting will work only when Image/Icon placement is Left.', 'dipi-divi-pixel'),
      'type' => 'select',
      'option_category' => 'configuration',
      'default' => 'flex-start',
      'options' => [
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
      'default' => 'flex-start',
      'options' => [
        'flex-start' => esc_html__('Left', 'dipi-divi-pixel'),  
        'center' => esc_html__('Center', 'dipi-divi-pixel'),
        'flex-end' => esc_html__('Right', 'dipi-divi-pixel'),
      ],
      'mobile_options' => true,
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_cells',
    ];
    // Column Header Text
    $fields['column_header_title_margin'] = [
      'label' => __('Margin', 'dipi-divi-pixel'),
      'type' => 'custom_margin',
      'description' => __('Set Margin of Title.', 'dipi-divi-pixel'),
      'tab_slug' => 'advanced',
      'toggle_slug' => 'column_header_text',
      'sub_toggle' => 'title',
      'default' => '0px|0px|10px|0px',
      'mobile_options' => true,
    ];
    $fields['column_header_title_padding'] = [
        'label' => __('Padding', 'dipi-divi-pixel'),
        'type' => 'custom_margin',
        'description' => __('Set Padding of Title.', 'dipi-divi-pixel'),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'column_header_text',
        'sub_toggle' => 'title',
        'default' => '0px|0px|0px|0px',
        'mobile_options' => true,
    ];
    $fields['column_header_desc_margin'] = [
        'label' => __('Margin', 'dipi-divi-pixel'),
        'type' => 'custom_margin',
        'description' => __('Set Margin of Description.', 'dipi-divi-pixel'),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'column_header_text',
        'sub_toggle' => 'desc',
        'default' => '10px|0px|10px|0px',
        'mobile_options' => true,
    ];
    $fields['column_header_desc_padding'] = [
        'label' => __('Padding', 'dipi-divi-pixel'),
        'type' => 'custom_margin',
        'description' => __('Set Padding of Description.', 'dipi-divi-pixel'),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'column_header_text',
        'sub_toggle' => 'desc',
        'default' => '0px|0px|0px|0px',
        'mobile_options' => true,
    ];
    // Column Header Cells
    $fields['column_header_bg_color'] = [
      'label' => esc_html__('Column Header Cell Background Color', 'dipi-divi-pixel'),
      'type' => 'color-alpha',
      'toggle_slug' => 'column_header_cells',
      'tab_slug' => 'advanced',
      'default' => 'transparent',
    ];
    $fields['column_header_padding'] = [
      'label' => __('Column Header Cell Padding', 'et_builder'),
      'type' => 'custom_margin',
      'tab_slug' => 'advanced',
      'toggle_slug' => 'column_header_cells',
      'mobile_options' => true,
    ];
    // Row Header Text
    $fields['row_header_title_margin'] = [
      'label' => __('Margin', 'dipi-divi-pixel'),
      'type' => 'custom_margin',
      'description' => __('Set Margin of Title.', 'dipi-divi-pixel'),
      'tab_slug' => 'advanced',
      'toggle_slug' => 'row_header_text',
      'sub_toggle' => 'title',
      'default' => '0px|0px|10px|0px',
      'mobile_options' => true,
    ];
    $fields['row_header_title_padding'] = [
        'label' => __('Padding', 'dipi-divi-pixel'),
        'type' => 'custom_margin',
        'description' => __('Set Padding of Title.', 'dipi-divi-pixel'),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'row_header_text',
        'sub_toggle' => 'title',
        'default' => '0px|0px|0px|0px',
        'mobile_options' => true,
    ];
    $fields['row_header_desc_margin'] = [
        'label' => __('Margin', 'dipi-divi-pixel'),
        'type' => 'custom_margin',
        'description' => __('Set Margin of Description.', 'dipi-divi-pixel'),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'row_header_text',
        'sub_toggle' => 'desc',
        'default' => '10px|0px|10px|0px',
        'mobile_options' => true,
    ];
    $fields['row_header_desc_padding'] = [
        'label' => __('Padding', 'dipi-divi-pixel'),
        'type' => 'custom_margin',
        'description' => __('Set Padding of Description.', 'dipi-divi-pixel'),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'row_header_text',
        'sub_toggle' => 'desc',
        'default' => '0px|0px|0px|0px',
        'mobile_options' => true,
    ];
    // Row Header Cells
    $fields['row_header_bg_color'] = [
      'label' => esc_html__('Row Header Cell Background Color', 'dipi-divi-pixel'),
      'type' => 'color-alpha',
      'toggle_slug' => 'row_header_cells',
      'tab_slug' => 'advanced',
      'default' => 'transparent',
    ];
    $fields['row_header_padding'] = [
      'label' => __('Row Header Cell Padding', 'et_builder'),
      'type' => 'custom_margin',
      'tab_slug' => 'advanced',
      'toggle_slug' => 'row_header_cells',
      'mobile_options' => true,
    ];
    // Table Accordion Icon
    $fields['accordion_closed_icon'] = [
      'label' => esc_html__('Closed Icon', 'dipi-divi-pixel'),
      'type' => 'select_icon',
      'option_category' => 'basic_option',
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_accordion',
      'sub_toggle' => 'closed',
      'description' => esc_html__('Choose an icon to display when accordion is closed', 'dipi-divi-pixel'),
      'mobile_options' => true,
      'hover' => 'tabs',
      'default'         => 'L||divi||400',
      'show_if' => [
        'enable_responsive' => 'on',
        'display_as' => 'accordion'
      ]
    ];
    $fields['accordion_closed_icon_font_size'] = [
      'label' => esc_html__('Closed Icon Size', 'dipi-divi-pixel'),
      'type' => 'range',
      'option_category' => 'font_option',
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_accordion',
      'sub_toggle' => 'closed',
      'default' => '96px',
      'default_unit' => 'px',
      'default_on_front' => '',
      'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
      'range_settings' => array(
          'min' => '1',
          'max' => '120',
          'step' => '1',
      ),
      'mobile_options' => true,
      'sticky' => true,
      'responsive' => true,
      'hover' => 'tabs',
    ];
    $fields['accordion_closed_icon_margin'] = [
      'label' => __('Closed Icon Margin', 'et_builder'),
      'type' => 'custom_margin',
      'description' => __('Set Margin of Closed AccordionIcon.', 'et_builder'),
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_accordion',
      'sub_toggle' => 'closed',
      'mobile_options' => true,
    ];
    $fields['accordion_closed_icon_padding'] = [
      'label' => __('Closed Icon  Padding', 'et_builder'),
      'type' => 'custom_margin',
      'description' => __('Set Padding of Closed Accordion Icon.', 'et_builder'),
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_accordion',
      'sub_toggle' => 'closed',
      'default' => '15px|15px|15px|15px',
      'mobile_options' => true,
    ];
    $fields['accordion_opened_icon'] = [
      'label' => esc_html__('Opened Icon', 'dipi-divi-pixel'),
      'type' => 'select_icon',
      'option_category' => 'basic_option',
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_accordion',
      'sub_toggle' => 'opened',
      'description' => esc_html__('Choose an icon to display when accordion is opened', 'dipi-divi-pixel'),
      'mobile_options' => true,
      'hover' => 'tabs',
      'default'         => 'L||divi||400',
      'show_if' => [
        'enable_responsive' => 'on',
        'display_as' => 'accordion'
      ]
    ];
    $fields['accordion_opened_icon_font_size'] = [
      'label' => esc_html__('Opened Icon Size', 'dipi-divi-pixel'),
      'type' => 'range',
      'option_category' => 'font_option',
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_accordion',
      'sub_toggle' => 'opened',
      'default' => '96px',
      'default_unit' => 'px',
      'default_on_front' => '',
      'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
      'range_settings' => array(
          'min' => '1',
          'max' => '120',
          'step' => '1',
      ),
      'mobile_options' => true,
      'sticky' => true,
      'responsive' => true,
      'hover' => 'tabs',
    ];
    $fields['accordion_opened_icon_margin']= [
      'label' => __('Opened Icon Margin', 'et_builder'),
      'type' => 'custom_margin',
      'description' => __('Set Margin of Opened AccordionIcon.', 'et_builder'),
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_accordion',
      'sub_toggle' => 'opened',
      'mobile_options' => true,
    ];
    $fields['accordion_opened_icon_padding'] = [
      'label' => __('Opend Icon Padding', 'et_builder'),
      'type' => 'custom_margin',
      'description' => __('Set Padding of Opened ACcordion Icon.', 'et_builder'),
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_accordion',
      'sub_toggle' => 'opened',
      'default' => '15px|15px|15px|15px',
      'mobile_options' => true,
    ];
    return $fields;
  }


  public function get_advanced_fields_config() 
  {
    $advanced_fields = [];
    $cell_selector = "%%order_class%% .dipi-table-maker tr th, %%order_class%% .dipi-table-maker tr td";
    $cell_selector_2 = "%%order_class%% .dipi-col-header, %%order_class%% .dipi-cell";
    $column_header_selector = "%%order_class%% .dipi-table-maker .dipi-col-header, %%order_class%% .dipi-table-maker tr th";
    $column_header_selector_2 = "%%order_class%% .dipi-table-maker .dipi-col-header, %%order_class%% .dipi-table-maker tr th .dipi-cell";
    $row_header_selector = "%%order_class%% tr th.dipi-row-header, %%order_class%% tr td.dipi-row-header";
    $row_header_selector_2 = "%%order_class%% tr td.dipi-row-header .dipi-cell";
    $table_title_selector = "%%order_class%% .dipi-table-title";
    $table_desc_selector = "%%order_class%% .dipi-table-desc";
    $cell_title_selector = "%%order_class%% .dipi-content-heading";
    $cell_desc_selector = "%%order_class%% .dipi-desc";
    $column_header_title_selector = "%%order_class%% thead th .dipi-content-heading, %%order_class%% tbody td .dipi-col-header .dipi-content-heading";
    $column_header_desc_selector = "%%order_class%% thead th .dipi-desc, %%order_class%% tbody td .dipi-col-header .dipi-desc";
    $row_header_title_selector = "%%order_class%% .dipi-row-header .dipi-content-heading";
    $row_header_desc_selector = "%%order_class%% .dipi-row-header .dipi-desc";
    $content_icon_selector = "%%order_class%% .dipi-content-image-icon-wrap .et-pb-icon";
    $content_image_icon_selector = "%%order_class%%  .dipi-content-image-icon-wrap";
    $content_image_icon_hover_selector = "%%order_class%% .dipi_table_maker_child:hover .dipi-content-image-icon-wrap";
    $content_image_icon_width_selector = "%%order_class%% .dipi-content-image-icon-wrap.dipi-image-wrapper";

    $advanced_fields["fonts"]["table_title"] = [
      'label' => esc_html__('Table Title', 'dipi-divi-pixel'),
      'css' => [
          'main' => $table_title_selector,
      ],
      'important' => 'all',
      'toggle_slug' => 'table_title',
    ];
    $advanced_fields["fonts"]["table_desc"] = [
      'label' => esc_html__('Table Description', 'dipi-divi-pixel'),
      'css' => [
          'main' => $table_desc_selector,
      ],
      'important' => 'all',
      'toggle_slug' => 'table_description',
    ];


    $advanced_fields["fonts"]["cell_title"] = [
      'label' => esc_html__('Title', 'dipi-divi-pixel'),
      'css' => [
          'main' => $cell_title_selector,
      ],
      'important' => 'all',
      'hide_text_align' => false,
      'toggle_slug' => 'table_text',
      'sub_toggle' => 'title',
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
      /*'hide_icon' => true,*/
      'font_size' => array(
          'default' => '14px',
      ),
      'css' => [
          'main' => "%%order_class%%  .dipi_content_button.et_pb_button",
          'important' => true,
      ],
      'box_shadow' => [
          'css' => [
              'main' => "%%order_class%%  .dipi_content_button.et_pb_button",
              'important' => true,
          ],
      ],
      'margin_padding' => [
          'css' => [
              'margin' => "%%order_class%%  .dipi_content_button.et_pb_button",
              'padding' => "%%order_class%%  .dipi_content_button.et_pb_button",
              'important' => 'all',
          ],
      ],
      'toggle_slug' => 'content_button',
    ];
    $advanced_fields["fonts"]["cell_desc"] = [
      'label' => esc_html__('Description', 'dipi-divi-pixel'),
      'css' => [
          'main' => $cell_desc_selector,
      ],
      'important' => 'all',
      'hide_text_align' => false,
      'toggle_slug' => 'table_text',
      'sub_toggle' => 'desc',
      'line_height' => [
          'range_settings' => [
              'min' => '1',
              'max' => '3',
              'step' => '0.1',
          ],
      ],
    ];
    $advanced_fields["fonts"]["column_header_title"] = [
      'label' => esc_html__('Title', 'dipi-divi-pixel'),
      'css' => [
          'main' => $column_header_title_selector,
      ],
      'important' => 'all',
      'hide_text_align' => false,
      'toggle_slug' => 'column_header_text',
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
    $advanced_fields["fonts"]["column_header_desc"] = [
      'label' => esc_html__('Description', 'dipi-divi-pixel'),
      'css' => [
          'main' => $column_header_desc_selector,
      ],
      'important' => 'all',
      'hide_text_align' => false,
      'toggle_slug' => 'column_header_text',
      'sub_toggle' => 'desc',
      'line_height' => [
          'range_settings' => [
              'min' => '1',
              'max' => '3',
              'step' => '0.1',
          ],
      ],
    ];
    $advanced_fields["fonts"]["row_header_title"] = [
      'label' => esc_html__('Title', 'dipi-divi-pixel'),
      'css' => [
          'main' => $row_header_title_selector,
      ],
      'important' => 'all',
      'hide_text_align' => false,
      'toggle_slug' => 'row_header_text',
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
    $advanced_fields["fonts"]["row_header_desc"] = [
      'label' => esc_html__('Description', 'dipi-divi-pixel'),
      'css' => [
          'main' => $row_header_desc_selector,
      ],
      'important' => 'all',
      'hide_text_align' => false,
      'toggle_slug' => 'row_header_text',
      'sub_toggle' => 'desc',
      'line_height' => [
          'range_settings' => [
              'min' => '1',
              'max' => '3',
              'step' => '0.1',
          ],
      ],
    ];
    $advanced_fields["box_shadow"]["cells"] = [
      'css' => [
          'main' => $cell_selector ,
      ],
      'toggle_slug' => 'table_cells',
    ];
    $advanced_fields["box_shadow"]["default"] = [
      'css' => [
          'main' => "%%order_class%%",
      ],
    ];
    $advanced_fields["box_shadow"]["table"] = [
      'css' => [
          'main' => "%%order_class%% .dipi-table-maker table",
      ],
      'tab_slug' => 'advanced',
      'toggle_slug' => 'table_settings',
    ];
    
    $advanced_fields["borders"]["default"] = [
      'css' => [
          'main' => [
              'border_radii' => "%%order_class%%",
              'border_styles' => "%%order_class%%",
          ],
      ],
   ];
   $advanced_fields["borders"]["table"] = [
    'css' => [
        'main' => [
            'border_radii' => "%%order_class%% .dipi-table-maker table",
            'border_styles' => "%%order_class%% .dipi-table-maker table",
        ],
    ],
    'tab_slug' => 'advanced',
    'toggle_slug' => 'table_settings',
  ];
    $advanced_fields['borders']['cell'] = [
      'label_prefix' => esc_html__('Cell', 'dipi-divi-pixel'),
      'css' => [
          'main' => [
              'border_radii' => $cell_selector,
              'border_styles' => $cell_selector,
          ],
      ],
      'toggle_slug' => 'table_cells',
    ];
    $advanced_fields["box_shadow"]["column_header"] = [
      'css' => [
          'main' => $column_header_selector ,
      ],
      'toggle_slug' => 'column_header_cells',
    ];
    $advanced_fields['borders']['column_header'] = [
      'label_prefix' => esc_html__('Cell', 'dipi-divi-pixel'),
      'css' => [
          'main' => [
              'border_radii' => $column_header_selector,
              'border_styles' => $column_header_selector,
          ],
      ],
      'defaults' => [
        'border_styles' => [
            'width' => 'unset',
            'color' => 'unset',
            'style' => 'unset'
        ]
      ],
      'toggle_slug' => 'column_header_cells',
    ];
    $advanced_fields["box_shadow"]["row_header"] = [
      'label_prefix' => esc_html__('Row Header Cell', 'dipi-divi-pixel'),
      'css' => [
          'main' => $row_header_selector ,
      ],
      'toggle_slug' => 'row_header_cells',
    ];
    $advanced_fields['borders']['row_header'] = [
      'label_prefix' => esc_html__('Row Header Cell', 'dipi-divi-pixel'),
      'css' => [
          'main' => [
              'border_radii' => $row_header_selector,
              'border_styles' => $row_header_selector,
          ],
      ],
      'defaults' => [
        'border_styles' => [
            'width' => 'unset',
            'color' => 'unset',
            'style' => 'unset'
        ]
      ],
      'toggle_slug' => 'row_header_cells',
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

  public function dipi_apply_css($render_slug) {
//      $display_mode = $this->props['display_mode'];
    $column_count = $this->props['column_count'];
    $table_selector ="%%order_class%% .dipi-table-maker table";
    $row_selector = "%%order_class%% .dipi-table-maker table tr";
    $cell_selector = "%%order_class%% tr th, %%order_class%% tr td";
    $cell_selector_2 = "%%order_class%% .dipi-col-header, %%order_class%% .dipi-cell";
    $column_header_selector = "%%order_class%% .dipi-col-header, %%order_class%% tr th";
    $column_header_selector_2 = "%%order_class%% .dipi-col-header, %%order_class%% tr th .dipi-cell";
    $row_header_selector = "%%order_class%% tr th.dipi-row-header, %%order_class%% tr td.dipi-row-header";
    $row_header_selector_2 = "%%order_class%% tr td.dipi-row-header .dipi-cell";
    
    $table_title_selector = "%%order_class%% .dipi-table-title";
    $table_desc_selector = "%%order_class%% .dipi-table-desc";
    $cell_title_selector = "%%order_class%% .dipi-content-heading";
    $cell_desc_selector = "%%order_class%% .dipi-desc";
    $column_header_title_selector = "%%order_class%% thead th .dipi-content-heading, %%order_class%% tbody td .dipi-col-header .dipi-content-heading";
    $column_header_desc_selector = "%%order_class%% thead th .dipi-desc, %%order_class%% tbody td .dipi-col-header .dipi-desc";
    $row_header_title_selector = "%%order_class%% .dipi-row-header .dipi-content-heading";
    $row_header_desc_selector = "%%order_class%% .dipi-row-header .dipi-desc";
    $tbody_selector = "%%order_class%%.dipi_table_maker .dipi-table-maker table tbody";
    $content_selector = "%%order_class%% .dipi_table_item-content";
    $content_icon_selector = '%%order_class%% .dipi_table_item-content-wrapper .dipi-content-image-icon-wrap .et-pb-icon';
    $content_top_image_icon_selector = '%%order_class%% .dipi-table-maker.icon_image_place_top .dipi_table_item-content-wrapper .dipi-content-image-icon-wrap';
    $content_image_icon_selector = '%%order_class%% .dipi_table_item-content-wrapper .dipi-content-image-icon-wrap';
    $content_image_icon_hover_selector = '%%order_class%% .dipi_table_maker_child:hover .dipi_table_item-content-wrapper .dipi-content-image-icon-wrap';
    $content_image_icon_width_selector = '%%order_class%% .dipi_table_item-content-wrapper .dipi-content-image-icon-wrap.dipi-image-wrapper';
    $content_button_selector = '%%order_class%% .dipi-button-wrapper';
    
    /* $this->generate_styles(
      array(
          'base_attr_name' => 'display_mode',
          'selector' => $row_selector,
          'css_property' => 'display',
          'render_slug' => $render_slug,
          'type' => 'select',
      )
    );

    if ($display_mode === 'grid') {
      ET_Builder_Element::set_style($render_slug, array(
        'selector' => $row_selector ,
        'declaration' => "grid-template-columns: repeat($column_count, 1fr);"
      ));
    }*/
    
    $this->generate_styles(
      array(
          'base_attr_name' => 'table_border_collapse',
          'selector' => $table_selector,
          'css_property' => 'border-collapse',
          'render_slug' => $render_slug,
          'type' => 'select',
      )
    );
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
      $cell_title_selector
    );
    $this->dipi_apply_custom_margin_padding(
        $render_slug,
        'content_title_padding',
        'padding',
        $cell_title_selector
    );

    /* Content Description */
    $this->dipi_apply_custom_margin_padding(
        $render_slug,
        'content_desc_margin',
        'margin',
        $cell_desc_selector
    );
    $this->dipi_apply_custom_margin_padding(
        $render_slug,
        'content_desc_padding',
        'padding',
        $cell_desc_selector
    );
    // Column Header Text
    $this->dipi_apply_custom_margin_padding(
      $render_slug,
      'column_header_title_margin',
      'margin',
      $column_header_title_selector
    );
    $this->dipi_apply_custom_margin_padding(
        $render_slug,
        'column_header_title_padding',
        'padding',
        $column_header_title_selector
    );

    /* Column Header Description */
    $this->dipi_apply_custom_margin_padding(
        $render_slug,
        'column_header_desc_margin',
        'margin',
        $column_header_desc_selector
    );
    $this->dipi_apply_custom_margin_padding(
        $render_slug,
        'column_header_desc_padding',
        'padding',
        $column_header_desc_selector
    );
    // Row Header Text
    $this->dipi_apply_custom_margin_padding(
      $render_slug,
      'row_header_title_margin',
      'margin',
      $row_header_title_selector
    );
    $this->dipi_apply_custom_margin_padding(
        $render_slug,
        'row_header_title_padding',
        'padding',
        $row_header_title_selector
    );

    /* Row Header Description */
    $this->dipi_apply_custom_margin_padding(
        $render_slug,
        'row_header_desc_margin',
        'margin',
        $row_header_desc_selector
    );
    $this->dipi_apply_custom_margin_padding(
        $render_slug,
        'row_header_desc_padding',
        'padding',
        $row_header_desc_selector
    );
    //Table Size
    $this->generate_styles(
      array(
          'base_attr_name' => 'cell_height',
          'selector' => $cell_selector_2,
          'css_property' => 'height',
          'render_slug' => $render_slug,
          'type' => 'range',
      )
    );
    $this->generate_styles(
      array(
          'base_attr_name' => 'cell_max_height',
          'selector' => $cell_selector_2,
          'css_property' => 'max-height',
          'render_slug' => $render_slug,
          'type' => 'range',
      )
    );
    $this->generate_styles(
      array(
          'base_attr_name' => 'cell_min_height',
          'selector' => $cell_selector_2,
          'css_property' => 'min-height',
          'render_slug' => $render_slug,
          'type' => 'range',
      )
    );
    if ($this->props['set_width_by'] === 'table') {
      $this->generate_styles(
        array(
            'base_attr_name' => 'table_width',
            'selector' => $table_selector,
            'css_property' => 'width',
            'render_slug' => $render_slug,
            'type' => 'range',
        )
      );
      $this->generate_styles(
        array(
            'base_attr_name' => 'table_max_width',
            'selector' => $table_selector,
            'css_property' => 'max-width',
            'render_slug' => $render_slug,
            'type' => 'range',
        )
      );
      $this->generate_styles(
        array(
            'base_attr_name' => 'table_min_width',
            'selector' => $table_selector,
            'css_property' => 'min-width',
            'render_slug' => $render_slug,
            'type' => 'range',
        )
      );
    }
    if ($this->props['set_width_by'] === 'cell') {
      $this->generate_styles(
        array(
            'base_attr_name' => 'cell_width',
            'selector' => $cell_selector,
            'css_property' => 'width',
            'render_slug' => $render_slug,
            'type' => 'range',
        )
      );
      $this->generate_styles(
        array(
            'base_attr_name' => 'cell_max_width',
            'selector' => $cell_selector,
            'css_property' => 'max-width',
            'render_slug' => $render_slug,
            'type' => 'range',
        )
      );
      $this->generate_styles(
        array(
            'base_attr_name' => 'cell_min_width',
            'selector' => $cell_selector,
            'css_property' => 'min-width',
            'render_slug' => $render_slug,
            'type' => 'range',
        )
      );
    }
    $this->generate_styles(
      array(
          'base_attr_name' => 'cell_x_overflow',
          'selector' => $cell_selector,
          'css_property' => 'overflow-x',
          'render_slug' => $render_slug,
          'type' => 'select',
      )
    );
    $this->generate_styles(
      array(
          'base_attr_name' => 'cell_y_overflow',
          'selector' => $cell_selector,
          'css_property' => 'overflow-y',
          'render_slug' => $render_slug,
          'type' => 'select',
      )
    );
    
    /* Content Button */
    $btn_margin = $this->dipi_get_responsive_prop('content_button_custom_margin');
    // $this->set_responsive_spacing_css($render_slug, "%%order_class%%.dipi_expanding_cta .dipi_content_button.et_pb_button", 'margin', $btn_margin, true );
    $btn_padding = $this->dipi_get_responsive_prop('content_button_custom_margin');
    //$this->set_responsive_spacing_css($render_slug, "%%order_class%%.dipi_expanding_cta .dipi_content_button.et_pb_button", 'padding', $btn_padding, true );
    $this->generate_styles(
        array(
            'base_attr_name' => 'content_button_alignment',
            'selector' => $content_button_selector,
            'css_property' => 'text-align',
            'render_slug' => $render_slug,
            'type' => 'align',
        )
    );

    $this->dipi_apply_custom_style(
      $render_slug,
      'responsive_spacing',
      'gap',
      $tbody_selector
    );
    $this->generate_styles(
      array(
          'base_attr_name' => 'cell_bg_color',
          'selector' => $cell_selector,
          'css_property' => 'background-color',
          'render_slug' => $render_slug,
          'type' => 'color',
      )
    );
    $this->dipi_apply_custom_margin_padding(
      $render_slug,
      'cell_padding',
      'padding',
      $cell_selector_2
    );

    $this->generate_styles(
      array(
          'base_attr_name' => 'column_header_bg_color',
          'selector' => $column_header_selector,
          'css_property' => 'background-color',
          'render_slug' => $render_slug,
          'type' => 'color',
      )
    );
    $this->dipi_apply_custom_margin_padding(
      $render_slug,
      'column_header_padding',
      'padding',
      $column_header_selector_2
    );
    $this->generate_styles(
      array(
          'base_attr_name' => 'row_header_bg_color',
          'selector' => $row_header_selector,
          'css_property' => 'background-color',
          'render_slug' => $render_slug,
          'type' => 'color',
      )
    );
    $this->dipi_apply_custom_margin_padding(
      $render_slug,
      'row_header_padding',
      'padding',
      $row_header_selector_2
    );
  }


  public function before_render() {
    global $dipi_table_cells;
    $dipi_table_cells = [];
  }

  public function render($attrs, $content, $render_slug) {
    global $dipi_table_cells;
    wp_enqueue_script('dipi_table_maker_public');
    wp_enqueue_style('dipi_animate');
    
    $this->dipi_apply_css($render_slug);
    $show_table_title = $this->props['show_table_title'];
    $table_title = $this->props['table_title'];
    $table_title_position = $this->props['table_title_position'];
    $show_table_description = $this->props['show_table_description'];
    $table_description = $this->props['table_description'];
    $table_description_position = $this->props['table_description_position'];
    $enable_responsive = $this->props['enable_responsive'];
    $responsive_breakpoint = $enable_responsive === "on" ? $this->props['responsive_breakpoint'] : "off";
    $display_as = $enable_responsive === "on" ? $this->props['display_as'] : "off";
    $opened_toggle_indexes = explode(",", $this->props['opened_toggle_indexes']);
    $min_row_count = $this->props['min_row_count'];
    $column_count = $this->props['column_count'];
    $column_header_count = $this->props['column_header_count'];
    $row_header_count = 1; //$this->props['row_header_count'];
    $icon_placement = $this->props['icon_placement'];
    $icon_placement_values = et_pb_responsive_options()->get_property_values($this->props, 'icon_placement');
    $icon_placement_tablet = !empty($icon_placement_values['tablet']) ? $icon_placement_values['tablet'] : $icon_placement;
    $icon_placement_phone = !empty($icon_placement_values['phone']) ? $icon_placement_values['phone'] : $icon_placement_tablet;
    
    if (is_rtl() && 'left' === $icon_placement) {
        $icon_placement = 'right';
    }

    if (is_rtl() && 'left' === $icon_placement_tablet) {
        $icon_placement_tablet = 'right';
    }

    if (is_rtl() && 'left' === $icon_placement_phone) {
        $icon_placement_phone = 'right';
    }
    $module_custom_classes = sprintf('icon_image_place_%1$s', esc_attr($icon_placement));
    if (!empty($icon_placement_tablet)) {
        $module_custom_classes .= " icon_image_place_{$icon_placement_tablet}_tablet";
    }

    if (!empty($icon_placement_phone)) {
        $module_custom_classes .= " icon_image_place_{$icon_placement_phone}_phone";
    }
    $config = [
      'break' => $responsive_breakpoint,
      'display' => $display_as
    ];
    $table_title_html = "";
    if ($show_table_title === "on") {
      $table_title_html = sprintf('<div class="dipi-table-title">%1$s</div>',
        $table_title
      );
    }
    $table_description_html = "";
    if ($show_table_description === "on") {
      $table_description_html = sprintf('<div class="dipi-table-desc">%1$s</div>',
        $table_description
      );
    }
    
    $show_lightbox               = $this->props['show_lightbox'];
    $show_lightbox_values        = et_pb_responsive_options()->get_property_values( $this->props, 'show_lightbox' );
    
    $show_lightbox_tablet        = isset( $show_lightbox_values['tablet'] ) && !empty( $show_lightbox_values['tablet'] )? $show_lightbox_values['tablet'] : $show_lightbox;
    $show_lightbox_phone         = isset( $show_lightbox_values['phone'] ) && !empty( $show_lightbox_values['phone'] )? $show_lightbox_values['phone'] : $show_lightbox_tablet;

    $show_lightboxclasses = ($show_lightbox === 'on') ? 'show_lightbox' : 'hide_lightbox';
    if (!empty($show_lightbox_tablet)) {
        $show_lightboxclasses .= ($show_lightbox_tablet === 'on') ? ' show_lightbox_tablet' : ' hide_lightbox_tablet';
    }
    if (!empty($show_lightbox_phone)) {
        $show_lightboxclasses .= ($show_lightbox_phone === 'on') ? ' show_lightbox_phone' : ' hide_lightbox_phone';
    }
    if ($show_lightbox === 'on' || $show_lightbox_tablet === 'on' || $show_lightbox_phone === 'on' ) {
      wp_enqueue_style('magnific-popup');
      wp_enqueue_script('magnific-popup');
    }
    $table_html = '<table>';
    $tr_html='';
    $row_index = 0;
    $col_index = 0;
    $cell_tag = 'th';
    $thValues = array();
    if(count($dipi_table_cells) > 0) {
      foreach($dipi_table_cells as $table_cell) {
        if ($col_index > 0 && $table_cell['is_new_row']) {
          
          if ($row_index < $column_header_count) { // If row is in column header.
            // If new row before col_index reach to column_count, will add empty <div></div> as header
            for ($col = $col_index; $col < $column_count; $col ++) {
             $thValues[$row_index][$col] = '<div></div>';
            }
          }
          $tr_html .= str_repeat("<$cell_tag></$cell_tag>", $column_count - $col_index) ;
          $tr_html .= "</tr>";
          $col_index = 0;
          $row_index ++;
          $table_html .= $tr_html;
          if ($row_index  >= $column_header_count) {
            $table_html .= "</thead>";
            $cell_tag = 'td';
          }
          $tr_html = "<tr>";
        }
        if ($col_index === 0) {
          //New Row
          if ($column_header_count > 0) {
            if ($row_index === 0) {
              $table_html .= "<thead>";
              $cell_tag = 'th';
            } else if ($row_index === $column_header_count) {
              $table_html .= "<tbody>";
              $cell_tag = 'td';
            }
          } else {
            if ($row_index === 0) {
              $table_html .= "<tbody>";
            }
            $cell_tag = 'td';
          }
          $tr_html = '<tr>';
        }
        $cell_icon_placement =  $table_cell['icon_placement'];
        $cell_icon_placement_tablet =  !empty($table_cell['icon_placement_tablet']) ? $table_cell['icon_placement_tablet'] : $cell_icon_placement;
        $cell_icon_placement_phone =  !empty($table_cell['icon_placement_phone']) ? $table_cell['icon_placement_phone']: $cell_icon_placement_tablet;
        
        if (is_rtl() && 'left' === $cell_icon_placement) {
            $cell_icon_placement = 'right';
        }
  
        if (is_rtl() && 'left' === $cell_icon_placement_tablet) {
            $cell_icon_placement_tablet = 'right';
        }
  
        if (is_rtl() && 'left' === $cell_icon_placement_phone) {
            $cell_icon_placement_phone = 'right';
        }
        $cell_module_custom_classes = sprintf(' icon_image_place_%1$s', esc_attr($cell_icon_placement));
        if (!empty($cell_icon_placement_tablet)) {
            $cell_module_custom_classes .= " icon_image_place_{$cell_icon_placement_tablet}_tablet";
        }
  
        if (!empty($cell_icon_placement_phone)) {
            $cell_module_custom_classes .= " icon_image_place_{$cell_icon_placement_phone}_phone";
        }

        $module_id_html = $table_cell['module_id'] ? "id='".$table_cell['module_id']."' " : "";
        $cell_html = sprintf(
          '<div %5$s class="dipi-cell et_pb_module dipi_table_maker_child  %2$s %3$s %4$s">
            %1$s
          </div>',
          $table_cell['content'],
          $table_cell['order_class'],
          $cell_module_custom_classes,
          $table_cell['module_class'],
          $module_id_html #5
        );


        $cell_css = "";
        if ($col_index < $row_header_count) {
          if ($row_index >= $column_header_count) {
            $cell_css .="dipi-row-header";
          }
          if ($display_as === "accordion") {
            $cell_css .= " js-accordion";
            if (in_array($row_index - $column_header_count + 1, $opened_toggle_indexes)) {
              $cell_css .= " opened";
            }
          }
        }
        $thValueHTML = "";
        if ($row_index < $column_header_count) {
          if ($table_cell['col_span'] === 'full' || (int)$table_cell['col_span_num'] > 1 ) {
            $col_span_num = $table_cell['col_span'] === 'full' ? $column_count - $col_index: (int)$table_cell['col_span_num'];
            for ($col = $col_index; $col < min($column_count, $col_index + $col_span_num); $col ++) {
              $thValues[$row_index][$col] = $cell_html;
            }
          } else {
            $thValues[$row_index][$col_index] = $cell_html;
          }
        } else {
          for ($row = 0; $row < $column_header_count; $row++) {
            $thValueHTML .= $thValues[$row][$col_index];
          }
        }
        $col_span_html = '';
        if ($table_cell['col_span'] === 'full' ) {
          $col_span_html = 'colspan="100%"' ;
          $col_index = 0;
        } else {
          if ((int)$table_cell['col_span_num'] > 1) {
            $col_span_html = "colspan='".$table_cell['col_span_num']."'";
            $col_index = $col_index + (int)$table_cell['col_span_num'];
            if ($col_index>= $column_count) {
              $col_index = 0;
            }
          } else {
            $col_index  = ($col_index + 1) %  $column_count;
          }
        }

        $cell_html = sprintf('
          <%2$s class="%4$s" %5$s>
            <div class="dipi-col-header">%3$s</div>
            %1$s
          </%2$s>
          ', 
          $cell_html,
          $cell_tag,
          $thValueHTML,
          $cell_css,
          $col_span_html
        );
        $tr_html .= $cell_html;
        
        if ($col_index == 0) {
          // Close row tag when col_index reach at column_count.
          $tr_html .= '</tr>';
          $table_html .= $tr_html;
          $row_index ++;
          $col_index = 0;
          // Close thead tag when row_index reach at column_header_count.
          if ($row_index  >= $column_header_count) {
            $table_html .= "</thead>";
            $cell_tag = 'td';
          }
        }
      }
    }
    if ($col_index > 0 ) { // $col_index < $column_count) 
      $tr_html .= str_repeat("<$cell_tag></$cell_tag>", $column_count - $col_index) ;
      $tr_html .= "</tr>";
      $table_html .= $tr_html;
      $row_index ++;
      $col_index = 0;
    }
    if ($row_index === 0 && $min_row_count > 0) {
      if ($column_header_count > 0) {
        $table_html .= "<thead>";
        $cell_tag = 'th';
      } else {
        $table_html .= "<tbody>";
        $cell_tag = 'td';
      }
    }
    
    if ($row_index <= $column_header_count) {
      $remain_one_tr_html ="<tr>".str_repeat("<th></th>", $column_count)."</tr>" ;
      $remain_tr_html = str_repeat($remain_one_tr_html, $column_header_count - $row_index);
      $table_html .= $remain_tr_html;
      $table_html .= "</thead>";
      if ($min_row_count > $column_header_count) {
        $table_html .= "<tbody>";
        $cell_tag = 'td';
      }
      $row_index = $column_header_count;
    } 
    if ( $row_index <= $min_row_count ) {
      $remain_one_tr_html = "<tr>".str_repeat("<$cell_tag></$cell_tag>", $column_count)."</tr>" ;
      $remain_tr_html = str_repeat($remain_one_tr_html, $min_row_count - $row_index);
      $table_html .= $remain_tr_html;
      $table_html .= "</tbody>";
    }
    $table_html .= '</table>';
    /* Parent Button Icon setting */
    $content_button_use_icon = $this->props['content_button_use_icon'];
    $content_button_custom = $this->props['custom_content_button'];
    $content_button_custom_icon_values = et_pb_responsive_options()->get_property_values( $this->props, 'content_button_icon' );
    $content_button_custom_icon        = isset( $content_button_custom_icon_values['desktop'] ) ? $content_button_custom_icon_values['desktop'] : '';
    $content_button_custom_icon_tablet = isset( $content_button_custom_icon_values['tablet'] ) ? $content_button_custom_icon_values['tablet'] : $content_button_custom_icon;
    $content_button_custom_icon_phone  = isset( $content_button_custom_icon_values['phone'] ) ? $content_button_custom_icon_values['phone'] : $content_button_custom_icon_tablet;

    $content_button_custom_icon = $content_button_custom === "on" ? et_pb_process_font_icon($content_button_custom_icon) : "5";
    $content_button_custom_icon_tablet = $content_button_custom === "on" ? et_pb_process_font_icon($content_button_custom_icon_tablet) : "5";
    $content_button_custom_icon_phone = $content_button_custom === "on" ? et_pb_process_font_icon($content_button_custom_icon_phone) : "5";
    
    $content_button_icon_class = "";
    
    if ($content_button_use_icon === 'on') {
      $content_button_icon_class = "dipi_use_parent_button_icon";
    }
    $output = sprintf(
      '<div class="dipi-table-maker %8$s %13$s" data-config="%2$s" data-break="%7$s">
          %3$s
          %4$s
          <div
            class="%9$s"
            data-icon="%10$s"
            data-icon-tablet="%11$s"
            data-icon-phone="%12$s"
          >
            %1$s
          </div>
          %5$s
          %6$s
      </div>',
      $table_html,
      esc_attr(htmlspecialchars(json_encode($config), ENT_QUOTES, 'UTF-8')),
      $table_title_position === "above" ? $table_title_html : "",
      $table_description_position === "above" ? $table_description_html : "",
      $table_title_position === "below" ? $table_title_html : "", #5
      $table_description_position === "below" ? $table_description_html : "",
      $responsive_breakpoint,
      $module_custom_classes,
      $content_button_icon_class,
      $content_button_custom_icon, #10
      $content_button_custom_icon_tablet,
      $content_button_custom_icon_phone,
      $show_lightboxclasses
    );
    
    return $output;
  }
}

new DIPI_TableMaker;