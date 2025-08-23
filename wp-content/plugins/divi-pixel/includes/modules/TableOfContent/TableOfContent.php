<?php
class DIPI_TableOfContent extends DIPI_Builder_Module {

    public $slug = 'dipi_table_of_content';
    public $vb_support = 'on';
 

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/table-of-content',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__('Pixel Table Of Contents', 'dipi-divi-pixel');
        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'main_content' => esc_html__('Content', 'dipi-divi-pixel'),
                    'header_settings' => esc_html__('Header Settings', 'dipi-divi-pixel'),
                    'content_list_settings' => esc_html__('Content Settings', 'dipi-divi-pixel')
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'header_icon_style' => esc_html__('Header Icon Style', 'dipi-divi-pixel'),
                    'table_title_style' => esc_html__('Table Title', 'dipi-divi-pixel'),
                   
                    
                    'heading_font'         => [
                        'title'             => esc_html__('Font Style', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => array(
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
						)
                    ],
                    'content_list_style' => esc_html__('Content List Style', 'dipi-divi-pixel'),
                    'sub_list'         => [
                        'title'             => esc_html__('Sub List Style', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => array(
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
						)
                    ]
                ],
            ],
        ];
        $this->multi_view = et_pb_multi_view_options( $this );
        $font_icon = 'item_bullet';
        add_filter('et_required_module_assets', [$this, 'assets_filter'], 100, 1);
    }
    public function assets_filter($modules ) {
        $modules[] = 'et_pb_icon';
        return $modules;
    }
 

    public function get_fields() {
        $accent_color = et_builder_accent_color();
        $fields = [];
    
        $fields['show_table_title'] = [
            'label' => esc_html__('Show Table Title', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'default' => 'on',
            'toggle_slug' => 'header_settings',
            'mobile_options' => true,
            'responsive' => true,
        ];
        
        $fields['table_title'] = [
            'label' => esc_html__('Table Title', 'dipi-divi-pixel'),
            'dynamic_content' => 'text',
            'type' => 'text',
            'default' => esc_html__('Table Of Content', 'dipi-divi-pixel'),
            'toggle_slug' => 'header_settings',
            'show_if' => [
                'show_table_title' => 'on',
            ],
        ];

        $fields['use_header_icon'] = [
            'label' => esc_html__('Use Header Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'default' => 'on',
            'toggle_slug' => 'header_settings',
        ];

        $fields['header_icon'] = [
            'label' => esc_html__('Header Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'default' => '&#x69;||divi||400',
            'toggle_slug' => 'header_settings',
            'show_if' => [
                'use_header_icon' => 'on',
            ],
        ];

        $fields['header_icon_closed'] = [
            'label' => esc_html__('Header Icon Closed', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'default' => '3||divi||400',
            'toggle_slug' => 'header_settings',
            'show_if' => [
                'use_header_icon' => 'on',
                'collapsible_table' => 'on'
            ],
        ];

        $fields['header_icon_color'] = [
            'label' => esc_html__('Header Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'default' => '#fff',
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'header_icon_style',
            'show_if' => [
                'use_header_icon' => 'on',
            ],
        ];
        $fields['header_icon_background'] = [
            'label' => esc_html__('Header Icon Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'default' => 'transparent',
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'header_icon_style',
            'show_if' => [
                'use_header_icon' => 'on',
            ],
        ];
        $fields['header_icon_size'] = [
            'label' => esc_html__('Header Icon Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '20px',
            'default_unit' => 'px',
            'range_settings' => [
                'min' => '10',
                'max' => '100',
                'step' => '1',
            ],
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'header_icon_style',
            'show_if' => [
                'use_header_icon' => 'on',
            ],
        ];
        
        $fields['header_icon_margin'] = [
            'label' => esc_html__('Header Icon Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|10px|0px|0px',
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'header_icon_style',
            'show_if' => [
                'use_header_icon' => 'on',
            ],
        ];
        
        $fields['header_icon_padding'] = [
            'label' => esc_html__('Header Icon Padding', 'dipi-divi-pixel'),
            'type' => 'custom_padding',
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'header_icon_style',
            'show_if' => [
                'use_header_icon' => 'on',
            ],
        ];
        

        // select field for header icon position
        $fields['header_icon_position'] = [
            'label' => esc_html__('Header Icon Position', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => [
                'left' => esc_html__('Left', 'dipi-divi-pixel'),
                'right' => esc_html__('Right', 'dipi-divi-pixel'),
            ],
            'default' => 'left',
            'toggle_slug' => 'header_settings',
            'show_if' => [
                'use_header_icon' => 'on',
            ],
        ];



        // multi-checkboxes field for heading tags
        $fields['heading_tags'] = [
            'label' => esc_html__('Heading Tags', 'dipi-divi-pixel'),
            'type' => 'multiple_checkboxes',
            'options' => [
                'h1' => esc_html__('H1', 'dipi-divi-pixel'),
                'h2' => esc_html__('H2', 'dipi-divi-pixel'),
                'h3' => esc_html__('H3', 'dipi-divi-pixel'),
                'h4' => esc_html__('H4', 'dipi-divi-pixel'),
                'h5' => esc_html__('H5', 'dipi-divi-pixel'),
                'h6' => esc_html__('H6', 'dipi-divi-pixel'),
            ],

            'default' => 'on|on|on|on|on|on',
            'toggle_slug' => 'main_content',
        ];

        $fields['exclude_selector'] = [
            'label' => esc_html__('Exclude Selector', 'dipi-divi-pixel'),
            'description' => 'Add CSS selector ID or Class with comma separated If you want to exclude heading elements from the table.',
            'type' => 'text',
            'default' => '',
            'toggle_slug' => 'main_content',
        ];

        $fields['container_exclude_selector'] = [
            'label' => esc_html__('Container Exclude Selector', 'dipi-divi-pixel'),
            'description' => 'Add CSS selector ID or Class with comma separated If you want to exclude section from the table.',
            'type' => 'text',
            'default' => '',
            'toggle_slug' => 'main_content',
        ];
        
        $fields['generate_for_whole_page'] = [
            'label' => esc_html__('Generate For Whole Page', 'dipi-divi-pixel'),
            'description' => 'If you select yes, the table will be generated for the whole page. If you select no, you can specify the section selector.',
            'type' => 'yes_no_button',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'default' => 'on',
            'toggle_slug' => 'main_content',
        ];

        $fields['section_selector'] = [
            'label' => esc_html__('Section Selector', 'dipi-divi-pixel'),
            'description' => 'Add CSS selector ID or Class for a section to generate table from that section.',
            'type' => 'text',
            'default' => '',
            'toggle_slug' => 'main_content',
            'show_if' => [
                'generate_for_whole_page' => 'off',
            ],
        ];

        $fields['collapsible_table'] = [
            'label' => esc_html__('Collapsible Table', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'main_content',
        ];

         // create tabs_slider composition field
         $fields['collapsible_table_res'] = [
            'label'             => esc_html__( 'Select Device', 'dipi-divi-pixel' ),
            'type'              => 'composite',
            'toggle_slug'       => 'main_content',
            'composite_type'    => 'default',
            'show_if'           => [
                'collapsible_table' => 'on',
            ],
            'composite_structure' => array(
                'desktop' => array(
                    'icon'     => 'desktop',
                    'controls' =>  [
                        'collapsible_table_d' =>  [
                            'label' => esc_html__('Enable on desktop', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off',
                            'toggle_slug' => 'main_content',
                        ],
                        'closed_default_d' =>  [
                            'label' => esc_html__('Collapsed by default', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off',
                            'toggle_slug' => 'main_content',
                            'show_if'           => ['collapsible_table_d' => 'on']
                        ],
                        'close_on_click_d' =>  [
                            'label' => esc_html__('Collapse on click', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off',
                            'toggle_slug' => 'main_content',
                            'show_if'           => ['collapsible_table_d' => 'on']
                        ],
                    ],
                ),
                'tablet' => array(
                    'icon'     => 'tablet',
                    'controls' =>  [
                        'collapsible_table_t' =>  [
                            'label' => esc_html__('Enable on tablet', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off',
                            'toggle_slug' => 'main_content',
                        ],
                        'closed_default_t' =>  [
                            'label' => esc_html__('Collapsed by default', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off',
                            'toggle_slug' => 'main_content',
                            'show_if'           => ['collapsible_table_t' => 'on']
                        ],
                        'close_on_click_t' =>  [
                            'label' => esc_html__('Collapse on click', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off',
                            'toggle_slug' => 'main_content',
                            'show_if'           => ['collapsible_table_t' => 'on']
                        ],
                    ],
                ),
                'phone' => array(
                    'icon'     => 'phone',
                    'controls' =>  [
                        'collapsible_table_p' =>  [
                            'label' => esc_html__('Enable on mobile', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off',
                            'toggle_slug' => 'main_content',
                        ],
                        'closed_default_p' =>  [
                            'label' => esc_html__('Collapsed by default', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off',
                            'toggle_slug' => 'main_content',
                            'show_if'           => ['collapsible_table_p' => 'on']
                        ],
                        'close_on_click_p' =>  [
                            'label' => esc_html__('Collapse on click', 'dipi-divi-pixel'),
                            'type' => 'yes_no_button',
                            'options' => [
                                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                                'off' => esc_html__('No', 'dipi-divi-pixel'),
                            ],
                            'default' => 'off',
                            'toggle_slug' => 'main_content',
                            'show_if'           => ['collapsible_table_p' => 'on']
                        ],
                    ],
                ),
            ),
           
        ];




        $fields['scroll_offset'] = [
            'label' => esc_html__('Scroll Offset', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '100',
            'mobile_options'    => true,
            'range_settings' => [
                'min' => '0',
                'max' => '1000',
                'step' => '1',
            ],
            'toggle_slug' => 'main_content',
        ];

        $fields['show_list_numbers'] = [
            'label' => esc_html__('Show List Numeric Order', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'default' => 'on',
            'toggle_slug' => 'content_list_settings',
        ];

        $fields['show_list_bullets'] = [
            'label' => esc_html__('Show List Bullets', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'content_list_settings',
        ];
        
        $fields['item_bullet'] = [
            'label' => esc_html__('Icon For Bullet', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'toggle_slug' => 'content_list_settings',
            'show_if' => [
                'show_list_bullets' => 'on',
            ],
        ];
        
        $fields['bullet_size'] = [
            'label' => esc_html__('Bullet Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '10px',
            'toggle_slug' => 'content_list_settings',
            'show_if' => [
                'show_list_bullets' => 'on',
            ],
            'range_settings' => [
                'min' => '5',
                'max' => '50',
                'step' => '1',
                'default_unit' => 'px',
            ],
        ];
        
        $fields['bullet_spacing'] = [
            'label' => esc_html__('Bullet Spacing', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '5px',
            'toggle_slug' => 'content_list_settings',
            'show_if' => [
                'show_list_bullets' => 'on',
            ],
            'range_settings' => [
                'min' => '1',
                'max' => '50',
                'step' => '1',
                'default_unit' => 'px',
            ],
        ];



        $fields["table_title_background"] = [
            'label' => esc_html__('Title Background', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => $accent_color,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'table_title_style',
        ];

        $fields['title_padding'] = [
            'label' => esc_html__('Title Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '20px|20px|20px|20px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'table_title_style',
            'tab_slug'          => 'advanced',
        ];
        
        $fields['title_margin'] = [
            'label' => esc_html__('Title Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'table_title_style',
            'tab_slug'          => 'advanced',
        ];
       
        $fields["content_background"] = [
            'label' => esc_html__('Content Background', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#f1f1f1',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_list_style',
        ];

        $fields['content_padding'] = [
            'label' => esc_html__('Content Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '10px|10px|10px|10px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'content_list_style',
            'tab_slug'          => 'advanced',
        ];
        
        $fields['content_margin'] = [
            'label' => esc_html__('Content Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'content_list_style',
            'tab_slug'          => 'advanced',
        ];

        for ($i = 1; $i <= 6; $i++) {
            $fields['list_custom_margin_' . $i] = [
                'label' => esc_html__('Custom Margin', 'dipi-divi-pixel') . ' h' . $i . ' ' . esc_html__('List', 'dipi-divi-pixel'),
                'type' => 'custom_margin',
                'default' => '0px|0px|0px|0px',
                'mobile_options' => true,
                'responsive' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'sub_list',
                'sub_toggle' => 'h' . $i
            ];
            $default_padding = $i === 0? '0px|0px|0px|0px' : '0px|0px|0px|20px';
            $fields['list_custom_padding_' . $i] = [
                'label' => esc_html__('Custom Padding', 'dipi-divi-pixel') . ' h' . $i . ' ' . esc_html__('List', 'dipi-divi-pixel'),
                'type' => 'custom_margin',
                'default' => $default_padding,
                'mobile_options' => true,
                'responsive' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'sub_list',
                'sub_toggle' => 'h' . $i
            ];
             // range field space between list items
            $fields['list_space_between_' . $i] = [
                'label' => esc_html__('Space Between List Items', 'dipi-divi-pixel') . ' h' . $i . ' ' . esc_html__('List', 'dipi-divi-pixel'),
                'type' => 'range',
                'default' => '5px',
                'toggle_slug' => 'sub_list',
                'sub_toggle' => 'h' . $i,
                'range_settings' => [
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                    'default_unit' => 'px',
                ],
                'tab_slug' => 'advanced',
            ];
            $fields['list_bg_h'. $i] = [
                'label' => esc_html__('List Background Color', 'dipi-divi-pixel'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'default' => 'transparent',
                'mobile_options' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'sub_list',
                'sub_toggle' => 'h' . $i
            ];
        }
        
        return $fields;
    }
 
    public function get_custom_css_fields_config()
    {
        $fields = [];
        $fields['active_item_link'] = [
            'label' => esc_html__('Active Item', 'dipi-divi-pixel'),
            'selector' => '.dipi-toc__list li.active a.dipi-toc-link',
        ];
        $fields['h1_item_link'] = [
            'label' => esc_html__('H1 item link', 'dipi-divi-pixel'),
            'selector' => '.dipi-toc-link.dipi-toc__item--lvl-1',
        ];
        $fields['h2_item_link'] = [
            'label' => esc_html__('H2 item link', 'dipi-divi-pixel'),
            'selector' => '.dipi-toc-link.dipi-toc__item--lvl-2',
        ];
        $fields['h3_item_link'] = [
            'label' => esc_html__('H3 item link', 'dipi-divi-pixel'),
            'selector' => '.dipi-toc-link.dipi-toc__item--lvl-3',
        ];
        $fields['h4_item_link'] = [
            'label' => esc_html__('H4 item link', 'dipi-divi-pixel'),
            'selector' => '.dipi-toc-link.dipi-toc__item--lvl-4',
        ];
        $fields['h5_item_link'] = [
            'label' => esc_html__('H5 item link', 'dipi-divi-pixel'),
            'selector' => '.dipi-toc-link.dipi-toc__item--lvl-5',
        ];
        $fields['h6_item_link'] = [
            'label' => esc_html__('H6 item link', 'dipi-divi-pixel'),
            'selector' => '.dipi-toc-link.dipi-toc__item--lvl-6',
        ];

        $fields['h1_list'] = [
            'label' => esc_html__('H1 List', 'dipi-divi-pixel'),
            'selector' => '.dipi-toc__sublist.dipi-toc__sublist--lvl-1',
        ];
        $fields['h2_list'] = [
            'label' => esc_html__('H2 List', 'dipi-divi-pixel'),
            'selector' => '.dipi-toc__sublist.dipi-toc__sublist--lvl-2',
        ];
        $fields['h3_list'] = [
            'label' => esc_html__('H3 List', 'dipi-divi-pixel'),
            'selector' => '.dipi-toc__sublist.dipi-toc__sublist--lvl-3',
        ];
        $fields['h4_list'] = [
            'label' => esc_html__('H4 List', 'dipi-divi-pixel'),
            'selector' => '.dipi-toc__sublist.dipi-toc__sublist--lvl-4',
        ];
        $fields['h5_list'] = [
            'label' => esc_html__('H5 List', 'dipi-divi-pixel'),
            'selector' => '.dipi-toc__sublist.dipi-toc__sublist--lvl-5',
        ];
        $fields['h6_list'] = [
            'label' => esc_html__('H6 List', 'dipi-divi-pixel'),
            'selector' => '.dipi-toc__sublist.dipi-toc__sublist--lvl-6',
        ];
        
 
        return $fields;
    }
  
    public function get_advanced_fields_config()
    {
        $accent_color = et_builder_accent_color();
        $advanced_fields = [];
        
        $advanced_fields['box_shadow']['default'] = array();
        $advanced_fields["fonts"]["tabel_title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main'  => "%%order_class%% .dipi-toc__title h1, %%order_class%% .dipi-toc__title h2,%%order_class%% .dipi-toc__title h3,%%order_class%% .dipi-toc__title h4, %%order_class%% .dipi-toc__title h5,%%order_class%% .dipi-toc__title h6",
                'hover' => "%%order_class%% .dipi-toc__title:hover h1, %%order_class%% .dipi-toc__title:hover h2,%%order_class%% .dipi-toc__title:hover h3,%%order_class%% .dipi-toc__title:hover h4, %%order_class%% .dipi-toc__title:hover h5,%%order_class%% .dipi-toc__title:hover h6"
            ],
            'important' => 'all',
            'hide_text_align' => false,
            'toggle_slug' => 'table_title_style',
            'text_color' => [
                'default' => '#ffffff',
            ],
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

        $advanced_fields['borders']['default'] = array();
        $advanced_fields['borders']['tabel_title'] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-toc__title",
                    'border_styles' => "%%order_class%% .dipi-toc__title",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'table_title_style',
           
        ];

        $advanced_fields['box_shadow']['tabel_title'] = [
            'label' => esc_html__('Table Title Shadow', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'css' => [
                'main' => '%%order_class%% .dipi-toc__title',
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'table_title_style',
        ];

		$advanced_fields["fonts"]["content_list"] = [
            'label' => esc_html__('Content List Items', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-toc__list li a",
                'hover' => "%%order_class%% .dipi-toc__list li a:hover",
            ],
            'text_color' => [
                'default' => '#000',
                'default_on_hover' => $accent_color,
            ],
            'important' => 'all',
            'hide_text_align' => false,
            'toggle_slug' => 'content_list_style',
            'line_height' => [
                'range_settings' => [
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ],
            ],
        ];

        for ($i = 1; $i <= 6; $i++) {
            $advanced_fields["fonts"]["h$i"] = [
                'label' => esc_html__('Content List Items', 'dipi-divi-pixel'),
                'css' => [
                    'main' => "%%order_class%% .dipi-toc__list li a.dipi-toc__item--lvl-$i",
                    'hover' => "%%order_class%% .dipi-toc__list li a.dipi-toc__item--lvl-$i:hover",
                ],
                'text_color' => [
                    'default' => '#000',
                    'default_on_hover' => $accent_color,
                ],
                'important' => 'all',
                'hide_text_align' => false,
                'toggle_slug' => 'heading_font',
                'sub_toggle' => 'h' . $i
            ];
        }

        $advanced_fields['borders']['content'] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-toc__collapse",
                    'border_styles' => "%%order_class%% .dipi-toc__collapse",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_list_style',
           
        ];

        $advanced_fields['box_shadow']['content'] = [
            'label' => esc_html__('Content Shadow', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'css' => [
                'main' => '%%order_class%% .dipi-toc__collapse',
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_list_style',
        ];

        $advanced_fields['borders']['header_icon'] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-toc_header-icon",
                    'border_styles' => "%%order_class%% .dipi-toc_header-icon",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'header_icon_style',
           
        ];

        $advanced_fields['box_shadow']['header_icon'] = [
            'label' => esc_html__('Content Shadow', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'css' => [
                'main' => '%%order_class%% .dipi-toc_header-icon',
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'header_icon_style',
        ];

        for ($i = 1; $i <= 6; $i++) {
            $advanced_fields['borders']['h' . $i] = [
                'css' => [
                    'main' => [
                        'border_radii' => "%%order_class%% .dipi-toc__sublist--lvl-$i",
                        'border_styles' => "%%order_class%% .dipi-toc__sublist--lvl-$i",
                    ],
                ],
                'tab_slug' => 'advanced',
                'toggle_slug' => 'sub_list',
                'sub_toggle' => 'h' . $i
            ];

            $advanced_fields['box_shadow']['h' . $i] = [
                'label' => esc_html__('Sub List Shadow', 'dipi-divi-pixel'),
                'option_category' => 'layout',
                'css' => [
                    'main' => "%%order_class%% .dipi-toc__sublist--lvl-$i",
                    'overlay' => 'inset',
                ],
                'tab_slug' => 'advanced',
                'toggle_slug' => 'sub_list',
                'sub_toggle' => 'h' . $i
            ];
        }

        return $advanced_fields;
    }

    public function apply_style($render_slug) {
        $show_table_title_class = "%%order_class%% .dipi-toc__title";
        $show_table_title = $this->props['show_table_title'];
        $show_table_title_tablet = $this->props['show_table_title_tablet'];
        $show_table_title_phone = $this->props['show_table_title_phone'];
        $show_table_title_last_edited = $this->props['show_table_title_last_edited'];
        $show_table_title_responsive_status = et_pb_get_responsive_status($show_table_title_last_edited);

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $show_table_title_class,
            'declaration' => sprintf('display: %1$s;', $show_table_title === "on" ? "block" : "none"),
        ));


        if ('' !== $show_table_title_tablet && $show_table_title_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $show_table_title_class,
                'declaration' => sprintf('display: %1$s;',  $show_table_title_tablet === "on" ? "block" : "none"),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if ('' !== $show_table_title_phone && $show_table_title_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $show_table_title_class,
                'declaration' => sprintf('display: %1$s;',  $show_table_title_phone === "on" ? "block" : "none"),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        $this->dipi_generate_font_icon_styles($render_slug, 'item_bullet', "%%order_class%% .dipi-toc__icon");
        // $this->process_range_field_css($render_slug, 'bullet_size', "%%order_class%% .dipi-toc__icon", 'font-size');
        $this->process_range_field_css( array(
            'render_slug'       => $render_slug,
            'slug'              => 'bullet_size',
            'type'              => 'font-size',
            'fixed_unit'          => 'px',
            'default' => '10px',
            'selector'          => '%%order_class%% .dipi-toc__icon',
            'important'         => false
        ) );
        $this->process_range_field_css( array(
            'render_slug'       => $render_slug,
            'slug'              => 'bullet_spacing',
            'type'              => 'padding-right',
            'fixed_unit'          => 'px',
            'default' => '5px',
            'selector'          => '%%order_class%% .dipi-toc__icon',
            'important'         => false
        ) );
        $this->process_color_field_css(array(
            'render_slug'       => $render_slug,
            'slug'              => 'table_title_background',
            'type'              => 'background-color',
            'selector'          => '%%order_class%% .dipi-toc__title',
            'hover'             => '%%order_class%% .dipi-toc__title:hover',
            'important'         => true
        )) ;
        $this->process_color_field_css(array(
            'render_slug'       => $render_slug,
            'slug'              => 'content_background',
            'type'              => 'background-color',
            'selector'          => '%%order_class%% .dipi-toc__collapse',
            'hover'             => '%%order_class%% .dipi-toc__collapse:hover',
            'important'         => true
        )) ;
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'content_padding',
            'css_property'   => 'padding',
            'selector'       => '%%order_class%% .dipi-toc__list',
            'hover_selector' => '%%order_class%% .dipi-toc__collapse:hover .dipi-toc__list'
        ]);
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'content_margin',
            'css_property'   => 'margin',
            'selector'       => '%%order_class%% .dipi-toc__collapse',
            'hover_selector' => '%%order_class%% .dipi-toc__collapse:hover'
        ]);
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'title_padding',
            'css_property'   => 'padding',
            'selector'       => '%%order_class%% .dipi-toc__title',
            'hover_selector' => '%%order_class%% .dipi-toc__title:hover'
        ]);
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'title_margin',
            'css_property'   => 'margin',
            'selector'       => '%%order_class%% .dipi-toc__title',
            'hover_selector' => '%%order_class%% .dipi-toc__title:hover'
        ]);
        //Header Icon Style
        $this->process_color_field_css(array(
            'render_slug'       => $render_slug,
            'slug'              => 'header_icon_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .dipi-toc_header-icon',
            'hover'             => '%%order_class%% .dipi-toc_header-icon:hover',
            'important'         => true
        )) ;
        $this->process_color_field_css(array(
            'render_slug'       => $render_slug,
            'slug'              => 'header_icon_background',
            'type'              => 'background-color',
            'selector'          => '%%order_class%% .dipi-toc_header-icon',
            'hover'             => '%%order_class%% .dipi-toc_header-icon:hover',
            'important'         => true
        )) ;
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'header_icon_padding',
            'css_property'   => 'padding',
            'selector'       => '%%order_class%% .dipi-toc_header-icon',
            'hover_selector' => '%%order_class%% .dipi-toc_header-icon:hover'
        ]);
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'header_icon_margin',
            'css_property'   => 'margin',
            'selector'       => '%%order_class%% .dipi-toc_header-icon',
            'hover_selector' => '%%order_class%% .dipi-toc_header-icon:hover'
        ]);
        $this->process_range_field_css( array(
            'render_slug'       => $render_slug,
            'slug'              => 'header_icon_size',
            'type'              => 'font-size',
            'fixed_unit'          => 'px',
            'default' => '20px',
            'selector'          => '%%order_class%% .dipi-toc_header-icon',
            'important'         => false
        ) );
        for ($i = 1; $i <= 6; $i++) {
            $this->process_color_field_css(array(
                'render_slug'       => $render_slug,
                'slug'              => 'list_bg_h' . $i,
                'type'              => 'background-color',
                'selector'          => "%%order_class%% .dipi-toc__sublist--lvl-$i",
                'hover'             => "%%order_class%% .dipi-toc__sublist--lvl-$i:hover",
                'important'         => true
            )) ;
            $this->dipi_process_spacing_field([
                'render_slug'    => $render_slug,
                'slug'           => "list_custom_padding_$i",
                'css_property'   => 'padding',
                'selector'       => "%%order_class%% .dipi-toc__sublist--lvl-$i",
                'hover_selector' => "%%order_class%% .dipi-toc__sublist--lvl-$i:hover"
            ]);
            $this->dipi_process_spacing_field([
                'render_slug'    => $render_slug,
                'slug'           => "list_custom_margin_$i",
                'css_property'   => 'margin',
                'selector'       => "%%order_class%% .dipi-toc__sublist--lvl-$i",
                'hover_selector' => "%%order_class%% .dipi-toc__sublist--lvl-$i:hover"
            ]);
            $this->process_range_field_css([
                'render_slug'    => $render_slug,
                'slug'           => "list_space_between_$i",
                'type'   => 'margin-top',
                'selector'       => "%%order_class%% .dipi-toc__sublist--lvl-$i li",
                'hover_selector' => "%%order_class%% .dipi-toc__sublist--lvl-$i:hover li"
            ]);
            
        }
    }

    public function render($attrs, $content, $render_slug) {
        wp_enqueue_script('dipi_toc');
        $this->apply_style($render_slug);
        $show_table_title = $this->props['show_table_title'];
        $table_title = $this->props['table_title'];
        $heading_tags = $this->props['heading_tags'];
        $exclude_selector = $this->props['exclude_selector'];
        $container_exclude_selector = $this->props['container_exclude_selector'];
        $generate_for_whole_page = $this->props['generate_for_whole_page'];
        $section_selector = $this->props['section_selector'];
        $collapsible_table = $this->props['collapsible_table'];
        $show_list_numbers = isset($this->props['show_list_numbers'])? $this->props['show_list_numbers'] : 'off';
        $icon_code = isset($this->props['item_bullet']) ? $this->props['item_bullet'] : '';
        $icon = et_pb_process_font_icon($icon_code);
        $scroll_offset = isset($this->props['scroll_offset']) ? $this->props['scroll_offset'] : '100';
        $scroll_offset_tablet = isset($this->props['scroll_offset_tablet']) && !empty($this->props['scroll_offset_tablet']) ? $this->props['scroll_offset_tablet'] : $scroll_offset;
        $scroll_offset_phone = isset($this->props['scroll_offset_phone']) && !empty($this->props['scroll_offset_phone'])? $this->props['scroll_offset_phone'] : $scroll_offset_tablet;
        $data = [
            'headingTags' => $heading_tags,
            'generateForWholePage' => $generate_for_whole_page,
            'exclude_selector' => $exclude_selector,
            'container_exclude_selector' => $container_exclude_selector,
            'sectionSelector' => $section_selector,
            'show_list_numbers' => $show_list_numbers,
            'scroll_offset' => $scroll_offset . '|'. $scroll_offset_tablet . '|' . $scroll_offset_phone, 
        ];

        if($collapsible_table === 'on') {
            $data['collapsible'] = 'on';

            $collapsible_table = isset($this->props['collapsible_table_d']) ? $this->props['collapsible_table_d'] : 'off';
            $collapsible_table_tablet = isset($this->props['collapsible_table_t']) ? $this->props['collapsible_table_t'] : 'off';
            $collapsible_table_phone = isset($this->props['collapsible_table_p']) ? $this->props['collapsible_table_p'] : 'off';
            $data['collapsible_table'] = $collapsible_table . '|' . $collapsible_table_tablet . '|' . $collapsible_table_phone;

            $closed_default = isset($this->props['closed_default_d']) ? $this->props['closed_default_d'] : 'off';
            $closed_default_tablet = isset($this->props['closed_default_t']) ? $this->props['closed_default_t'] : 'off';
            $closed_default_phone = isset($this->props['closed_default_p']) ? $this->props['closed_default_p'] : 'off';
            $data['closed_default'] = $closed_default . '|' . $closed_default_tablet . '|' . $closed_default_phone;

            $close_on_click = isset($this->props['close_on_click_d']) ? $this->props['close_on_click_d'] : 'off';
            $close_on_click_tablet = isset($this->props['close_on_click_t']) ? $this->props['close_on_click_t'] : 'off';
            $close_on_click_phone = isset($this->props['close_on_click_p']) ? $this->props['close_on_click_p'] : 'off';
            $data['close_on_click'] = $close_on_click . '|' . $close_on_click_tablet . '|' . $close_on_click_phone;

            
            $collapsible_table = $this->props['collapsible_table'];
        }else {
            $data['collapsible'] = 'off';
        }

        if(isset($icon)) {
            $data['icon'] = $icon;
        }
        // add data attribute to the module
        $data_attr =  'data-dipi-toc=' . base64_encode(json_encode($data));
        $title = '';
        $icon_class = $this->props['header_icon_position'] === 'right' ? 'dipi-toc_header-icon dip-content_header-icon-right' : 'dipi-toc_header-icon';
        $header_icon = '';
        if($this->props['use_header_icon'] === 'on') {
            $header_icon_code = $this->props['header_icon'];
            $header_icon_code = et_pb_get_extended_font_icon_value( $header_icon_code, true );
            $header_icon_closed = $this->props['header_icon_closed'];
            $header_icon_closed = et_pb_get_extended_font_icon_value( $header_icon_closed, true );
            $this->generate_styles([
                'utility_arg'    => 'icon_font_family',
                'render_slug'    => $render_slug,
                'base_attr_name' => 'header_icon',
                'important'      => true,
                'selector'       => '%%order_class%% .dipi-toc-header-icon-open',
                'processor'      => array(
                    'ET_Builder_Module_Helper_Style_Processor',
                    'process_extended_icon',
                )
            ]);
            $this->generate_styles([
                'utility_arg'    => 'icon_font_family',
                'render_slug'    => $render_slug,
                'base_attr_name' => 'header_icon_closed',
                'important'      => true,
                'selector'       => '%%order_class%% .dipi-toc-header-icon-closed',
                'processor'      => array(
                    'ET_Builder_Module_Helper_Style_Processor',
                    'process_extended_icon',
                )
            ]);

            $header_icon = sprintf('
                <span class="%1$s">
                    <span class="dipi-toc-header-icon-open">%2$s</span>
                    <span class="dipi-toc-header-icon-closed">%3$s</span>
                </span>', 
                esc_attr($icon_class),
                $header_icon_code,
                $header_icon_closed
            );
        }
        $title_header_level = $this->props['tabel_title_level'];
        $title = sprintf(
            '<div class="dipi-toc__title">
                <%1$s>
                    %3$s
                    <span class="dipi-toc_header-content">%2$s</span>
                </%1$s>
            </div>',
            et_pb_process_header_level( $title_header_level, 'h2' ),
            et_core_esc_previously( $table_title ),
            $header_icon
        );
        return sprintf('
                <div class="dipi-toc open" %2$s>
                    %1$s
                    <div class="dipi-toc__collapse">
                        <div class="dipi-toc__list"></div>
                    </div>
                </div>',
                $title,
                $data_attr
        );
    }
}
new DIPI_TableOfContent;