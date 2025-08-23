<?php

class DIPI_FAQ extends DIPI_Builder_Module
{

    public $slug = 'dipi_faq';
    
    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/faq',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__('Pixel FAQ', 'dipi-faq');
        $this->vb_support = 'on';
    }

    public function get_custom_css_fields_config()
    {
        $custom_css_fields = [];

        // Wrapper for entries
        $custom_css_fields['wrapper'] = [
            'label' => esc_html__('Wrapper around Entries', 'dipi-faq'),
            'selector' => '.dipi-faq-wrapper',
        ];

        // Entry
        $custom_css_fields['entry'] = [
            'label' => esc_html__('Entries', 'dipi-faq'),
            'selector' => '.dipi-faq-entry',
        ];

        $custom_css_fields['entry_closed'] = [
            'label' => esc_html__('Entries (Closed)', 'dipi-faq'),
            'selector' => '.dipi-faq-entry.closed',
        ];

        $custom_css_fields['entry_open'] = [
            'label' => esc_html__('Entries (Open)', 'dipi-faq'),
            'selector' => '.dipi-faq-entry.open',
        ];

        // Title
        $custom_css_fields['title'] = [
            'label' => esc_html__('Title', 'dipi-faq'),
            'selector' => '.dipi-faq-title',
        ];

        $custom_css_fields['title_closed'] = [
            'label' => esc_html__('Title (Closed)', 'dipi-faq'),
            'selector' => '.closed .dipi-faq-title',
        ];

        $custom_css_fields['title_open'] = [
            'label' => esc_html__('Title (Open)', 'dipi-faq'),
            'selector' => '.open .dipi-faq-title',
        ];

        // Content
        $custom_css_fields['content'] = [
            'label' => esc_html__('Content', 'dipi-faq'),
            'selector' => '.dipi-faq-content',
        ];

        $custom_css_fields['content_closed'] = [
            'label' => esc_html__('Content (Closed)', 'dipi-faq'),
            'selector' => '.closed .dipi-faq-content',
        ];

        $custom_css_fields['content_open'] = [
            'label' => esc_html__('Content (Open)', 'dipi-faq'),
            'selector' => '.open .dipi-faq-content',
        ];

        return $custom_css_fields;
    }

    public function get_settings_modal_toggles()
    {
        return [
            'general' => [
                'toggles' => [
                    'content' => esc_html__('Content', 'dipi-faq'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'layout' => esc_html__('Layout', 'dipi-faq'),

                    'faq_icon' => [
                        'title' => esc_html__('Icon', 'dipi-faq'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => [
                            'closed' => [
                                'name' => esc_html__('Closed', 'dipi-faq'),
                            ],
                            'open' => [
                                'name' => esc_html__('Open', 'dipi-faq'),
                            ],
                        ],
                    ],

                    'faq_entry' => [
                        'title' => esc_html__('Entry', 'dipi-faq'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => [
                            'closed' => [
                                'name' => esc_html__('Closed', 'dipi-faq'),
                            ],
                            'open' => [
                                'name' => esc_html__('Open', 'dipi-faq'),
                            ],
                        ],
                    ],
                    'faq_entry_closed' => esc_html__('Closed Entry Styles', 'dipi-faq'),
                    'faq_entry_open' => esc_html__('Open Entry Styles', 'dipi-faq'),

                    'faq_title' => [
                        'title' => esc_html__('Title', 'dipi-faq'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => [
                            'closed' => [
                                'name' => esc_html__('Closed', 'dipi-faq'),
                            ],
                            'open' => [
                                'name' => esc_html__('Open', 'dipi-faq'),
                            ],
                        ],
                    ],
                    'faq_title_border_closed' => esc_html__('Closed Title Border', 'dipi-faq'),
                    'faq_title_border_open' => esc_html__('Open Title Border', 'dipi-faq'),

                    'faq_content' => [
                        'title' => esc_html__('Content', 'dipi-faq'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => [
                            'closed' => [
                                'name' => esc_html__('Closed', 'dipi-faq'),
                            ],
                            'open' => [
                                'name' => esc_html__('Open', 'dipi-faq'),
                            ],
                            'link' => [
                                'name' => esc_html__('Link', 'dipi-faq'),
                            ],
                        ],
                    ],
                    'faq_content_border_closed' => esc_html__('Closed Content Border', 'dipi-faq'),
                    'faq_content_border_open' => esc_html__('Open Content Border', 'dipi-faq'),

                ],
            ],
        ];
    }

    public function get_fields()
    {
        $fields = [];

        $this->ds_add_content_fields($fields);
        $this->ds_add_advanced_layout_fields($fields);
        $this->ds_add_advanced_icon_fields($fields);
        $this->ds_add_advanced_entry_fields($fields);
        $this->ds_add_advanced_title_fields($fields);
        $this->ds_add_advanced_content_fields($fields);

        return $fields;
    }

    private function ds_add_content_fields(&$fields)
    {
        $fields['show_all'] = [
            'label' => esc_html__('Show All FAQ', 'dipi-faq'),
            'description' => esc_html__('Activate this option to show all FAQ entries, even those without a category. You can still exclude a FAQ using the exclude option below.', 'dipi-faq'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'off',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-faq'),
                'off' => esc_html__('No', 'dipi-faq'),
            ),
            'toggle_slug' => 'content',
            'computed_affects' => ['__output'],
        ];

        $fields['show_uncategorized'] = [
            'label' => esc_html__('Show Uncategorized FAQ', 'dipi-faq'),
            'description' => esc_html__('Activate this option to show uncategorized FAQ.', 'dipi-faq'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'off',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-faq'),
                'off' => esc_html__('No', 'dipi-faq'),
            ),
            'toggle_slug' => 'content',
            'computed_affects' => ['__output'],
            'show_if' => [
                'show_all' => 'off',
            ],
        ];

        $fields['faq_categories'] = [
            'label' => esc_html__('Categories', 'dipi-faq'),
            'description' => esc_html__('Choose the FAQ categories to display.', 'dipi-faq'),
            'type' => 'categories',
            'option_category' => 'basic_option',
            'renderer_options' => [
                'use_terms' => true,
                'term_name' => 'dipi_faq_category',
            ],
            'toggle_slug' => 'content',
            'computed_affects' => ['__output'],
            'show_if' => [
                'show_all' => 'off',
            ],
        ];

        $fields['excluded_post_ids'] = [
            'label' => esc_html__('Exclude FAQ', 'dipi-faq'),
            'description' => esc_html__('A comma separated list of FAQ IDs to exclude.', 'dipi-faq'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'toggle_slug' => 'content',
            'computed_affects' => ['__output'],
        ];

        $fields['included_post_ids'] = [
            'label' => esc_html__('Include FAQ', 'dipi-faq'),
            'description' => esc_html__('A comma separated list of FAQ IDs to include on top of the ones from the selected categories.', 'dipi-faq'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'toggle_slug' => 'content',
            'computed_affects' => ['__output'],
            'show_if' => [
                'show_all' => 'off',
            ],
        ];

        $fields['faq_order_by'] = array(
            'label' => esc_html__('Order By', 'dipi-faq'),
            'description' => esc_html__('How the FAQ will be sorted.', 'dipi-faq'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'toggle_slug' => 'content',
            'default' => 'title',
            'options' => [
                'title' => esc_html__('Title', 'dipi-faq'),
                'menu_order' => esc_html__('Menu Order', 'dipi-faq'),
                'ID' => esc_html__('FAQ ID', 'dipi-faq'),
                'name' => esc_html__('FAQ Slug', 'dipi-faq'),
                'date' => esc_html__('Creation Date', 'dipi-faq'),
                'modified' => esc_html__('Modification Date', 'dipi-faq'),
                'rand' => esc_html__('Random', 'dipi-faq'),
            ],
            'computed_affects' => ['__output'],
        );

        $fields['faq_order'] = array(
            'label' => esc_html__('Order', 'dipi-faq'),
            'description' => esc_html__('The sort order the FAQ will be displayed with.', 'dipi-faq'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'toggle_slug' => 'content',
            'default' => 'ASC',
            'show_if' => [
                'faq_order_by' => [
                    'title',
                    'menu_order',
                    'ID',
                    'name',
                    'date',
                    'modified',
                ],
            ],
            'options' => [
                'ASC' => esc_html__('Ascending', 'dipi-faq'),
                'DESC' => esc_html__('Descending', 'dipi-faq'),
            ],
            'computed_affects' => ['__output'],
        );


        $fields['output_json'] = [
            'label' => esc_html__('Output Structured Data', 'dipi-faq'),
            'description' => esc_html__('Activate this option to output the structured ld+json data for SEO purposes.', 'dipi-faq'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'on',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-faq'),
                'off' => esc_html__('No', 'dipi-faq'),
            ),
            'toggle_slug' => 'content',
            'computed_affects' => ['__output'],
        ];

        $fields['output_html'] = [
            'label' => esc_html__('Output HTML', 'dipi-faq'),
            'description' => esc_html__('Activate this option to output the HTML of this module. If you only want to output the ld+json data for SEO purposes, deactivate this option. Make sure that in this case the questions and answers from this module are actually somewhere visible on your site.', 'dipi-faq'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'on',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-faq'),
                'off' => esc_html__('No', 'dipi-faq'),
            ),
            'toggle_slug' => 'content',
            'computed_affects' => ['__output'],
        ];
        
        $fields['heading_tag'] = [
            'label'         => esc_html__('Title Heading Tag', 'dipi-divi-pixel'),
            'description'   => esc_html__('Choose Heading HTML Tag', 'dipi-divi-pixel'),
            'type'          => 'select',
            'tab_slug'      => 'general',
            'toggle_slug' => 'content',
            'default'       => 'span',
            'options' => [
                'h1'   => esc_html__('H1', 'dipi-divi-pixel'),
                'h2'   => esc_html__('H2', 'dipi-divi-pixel'),
                'h3'   => esc_html__('H3', 'dipi-divi-pixel'),
                'h4'   => esc_html__('H4', 'dipi-divi-pixel'),
                'h5'   => esc_html__('H5', 'dipi-divi-pixel'),
                'h6'   => esc_html__('H6', 'dipi-divi-pixel'),
                'span'   => esc_html__('Span', 'dipi-divi-pixel'),
                'p'   => esc_html__('P', 'dipi-divi-pixel'),
            ],
            'computed_affects' => ['__output']
        ];

        $fields['__output'] = [
            'type' => 'computed',
            'computed_callback' => ['DIPI_FAQ', 'ds_get_output'],
            'computed_depends_on' => [
                'show_all',
                'show_uncategorized',
                'faq_categories',
                'excluded_post_ids',
                'included_post_ids',
                'faq_order_by',
                'faq_order',
                'output_json',
                'output_html',
                'icon_closed',
                'icon_open',
                'heading_tag'
            ],
        ];
    }

    private function ds_add_advanced_layout_fields(&$fields)
    {
        $fields['faq_layout'] = array(
            'label' => esc_html__('Layout', 'dipi-faq'),
            'description' => esc_html__('How to display the questions and answers.', 'dipi-faq'),
            'type' => 'select',
            'option_category' => 'layout',
            'toggle_slug' => 'layout',
            'tab_slug' => 'advanced',
            'default' => 'toggles',
            'options' => [
                'toggles' => esc_html__('Individual Toggles', 'dipi-faq'),
                'accordion' => esc_html__('Accordion', 'dipi-faq'),
                'plain' => esc_html__('Plain Text', 'dipi-faq'),
            ],
        );

        $fields['accordion_open_first'] = [
            'label' => esc_html__('Open First FAQ', 'dipi-faq'),
            'description' => esc_html__('Activate this option to open the first FAQ', 'dipi-faq'),
            'type' => 'yes_no_button',
            'option_category' => 'layout',
            'toggle_slug' => 'layout',
            'tab_slug' => 'advanced',
            'default' => 'off',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-faq'),
                'off' => esc_html__('No', 'dipi-faq'),
            ),
            'show_if' => [
                'faq_layout' => 'accordion',
            ],
        ];

        $fields['accordion_close_all'] = [
            'label' => esc_html__('Allow Close All FAQ', 'dipi-faq'),
            'description' => esc_html__('Activate this option to allow the closing of all FAQ', 'dipi-faq'),
            'type' => 'yes_no_button',
            'option_category' => 'layout',
            'toggle_slug' => 'layout',
            'tab_slug' => 'advanced',
            'default' => 'off',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-faq'),
                'off' => esc_html__('No', 'dipi-faq'),
            ),
            'show_if' => [
                'faq_layout' => 'accordion',
            ],
        ];


        $fields['icon_animate'] = [
            'label' => esc_html__('Animate Toggle Icons', 'dipi-faq'),
            'description' => esc_html__('Activate this option to add a nice transition animation to the toggle icons.', 'dipi-faq'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'off',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-faq'),
                'off' => esc_html__('No', 'dipi-faq'),
            ),
            'toggle_slug' => 'layout',
            'tab_slug' => 'advanced',
            'show_if' => [
                'faq_layout' => [
                    'toggles',
                    'accordion',
                ],
            ]
        ];
  
        $fields['icon_animate_delay'] = [
            'label' => esc_html__('Delay Icon Animation', 'dipi-faq'),
            'description' => esc_html__('Activate this option to delay the icon animation until the toggle finishe opening or closing.', 'dipi-faq'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'off',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-faq'),
                'off' => esc_html__('No', 'dipi-faq'),
            ),
            'toggle_slug' => 'layout',
            'tab_slug' => 'advanced',
            'show_if' => [
                'faq_layout' => [
                    'toggles',
                    'accordion',
                ],
                'icon_animate' => 'on'
            ]
        ];
    }
    
    private function ds_add_advanced_icon_fields(&$fields)
    {
        $fields['icon_closed'] = array(
            'label' => esc_html__('Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'option_category' => 'configuration',
            'class' => array('et-pb-font-icon'),
            'default' => ';',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_icon',
            'sub_toggle' => 'closed',
            'computed_affects' => ['__output']
        );

        $fields['icon_open'] = array(
            'label' => esc_html__('Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'option_category' => 'configuration',
            'class' => array('et-pb-font-icon'),
            'default' => ':',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_icon',
            'sub_toggle' => 'open',
            'computed_affects' => ['__output']
        );

        $fields['icon_open_color'] = [
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'option_category' => 'color_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_icon',
            'sub_toggle' => 'open',
            'default' => '#ccc',
        ];

        $fields['icon_closed_color'] = [
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'option_category' => 'color_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_icon',
            'sub_toggle' => 'closed',
            'default' => '#ccc',
        ];

        // Icon Background Color
        $fields['icon_open_bg_color'] = [
            'label' => esc_html__('Icon Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'option_category' => 'color_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_icon',
            'sub_toggle' => 'open',
        ];

        $fields['icon_closed_bg_color'] = [
            'label' => esc_html__('Icon Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'option_category' => 'color_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_icon',
            'sub_toggle' => 'closed',
        ];

        //Icon Size
        $fields['icon_open_font_size'] = [
            'label' => esc_html__('Size', 'dipi-faq'),
            'type' => 'range',
            'mobile_options' => true,
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_icon',
            'sub_toggle' => 'open',
            'default' => "16px",
            'range_settings' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
        ];
        
        $fields['icon_closed_font_size'] = [
            'label' => esc_html__('Size', 'dipi-faq'),
            'type' => 'range',
            'mobile_options' => true,
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_icon',
            'sub_toggle' => 'closed',
            'default' => "16px",
            'range_settings' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
        ];


        //Icon Border Radius
        $fields['icon_open_border_radius'] = [
            'label' => esc_html__('Border Radius', 'dipi-faq'),
            'type' => 'range',
            'mobile_options' => true,
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_icon',
            'sub_toggle' => 'open',
            'default' => "0px",
            'range_settings' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
        ];
        
        $fields['icon_closed_border_radius'] = [
            'label' => esc_html__('Border Radius', 'dipi-faq'),
            'type' => 'range',
            'mobile_options' => true,
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_icon',
            'sub_toggle' => 'closed',
            'default' => "0px",
            'range_settings' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
        ];
        
        // Icon Padding
        $fields["icon_open_padding"] = [
            'label' => esc_html__('Icon Padding', 'dipi-faq'),
            'type' => 'custom_margin',
            'mobile_options' => true,
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_icon',
            'sub_toggle' => 'open',
        ];

        $fields["icon_closed_padding"] = [
            'label' => esc_html__('Icon Padding', 'dipi-faq'),
            'type' => 'custom_margin',
            'mobile_options' => true,
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_icon',
            'sub_toggle' => 'closed',
        ];
    }

    private function ds_add_advanced_entry_fields(&$fields)
    {
        $fields['entry_background_closed'] = [
            'label' => esc_html__('Closed Entry Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'option_category' => 'color_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_entry',
            'sub_toggle' => 'closed',
            'default' => '#f4f4f4',
        ];

        $fields['entry_background_open'] = [
            'label' => esc_html__('Open Entry Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'option_category' => 'color_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_entry',
            'sub_toggle' => 'open',
            'default' => '#fff',
        ];

        $fields["entry_margin_closed"] = [
            'label' => esc_html__('Closed Entry Margin', 'dipi-faq'),
            'type' => 'custom_margin',
            'mobile_options' => true,
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_entry',
            'default' => '||30px|',
            'sub_toggle' => 'closed',
        ];

        $fields["entry_padding_closed"] = [
            'label' => esc_html__('Closed Entry Padding', 'dipi-faq'),
            'type' => 'custom_margin',
            'mobile_options' => true,
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_entry',
            'sub_toggle' => 'closed',
        ];

        $fields["entry_margin_open"] = [
            'label' => esc_html__('Open Entry Margin', 'dipi-faq'),
            'type' => 'custom_margin',
            'mobile_options' => true,
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_entry',
            'sub_toggle' => 'open',
        ];

        $fields["entry_padding_open"] = [
            'label' => esc_html__('Open Entry Padding', 'dipi-faq'),
            'type' => 'custom_margin',
            'mobile_options' => true,
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_entry',
            'sub_toggle' => 'open',
        ];
    }

    private function ds_add_advanced_title_fields(&$fields)
    {
        $fields['title_background_closed'] = [
            'label' => esc_html__('Closed Title Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'option_category' => 'color_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_title',
            'sub_toggle' => 'closed',
        ];

        $fields['title_background_open'] = [
            'label' => esc_html__('Open Title Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'option_category' => 'color_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_title',
            'sub_toggle' => 'open',
        ];

        $fields["title_padding_closed"] = [
            'label' => esc_html__('Closed Title Padding', 'dipi-faq'),
            'type' => 'custom_margin',
            'mobile_options' => true,
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_title',
            'sub_toggle' => 'closed',
            'default' => '20px|50px|20px|20px',
        ];

        $fields["title_padding_open"] = [
            'label' => esc_html__('Open Title Padding', 'dipi-faq'),
            'type' => 'custom_margin',
            'mobile_options' => true,
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_title',
            'sub_toggle' => 'open',
        ];
    }

    private function ds_add_advanced_content_fields(&$fields)
    {
        $fields['content_background_closed'] = [
            'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'option_category' => 'color_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_content',
            'sub_toggle' => 'closed',
        ];

        $fields['content_background_open'] = [
            'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'option_category' => 'color_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_content',
            'sub_toggle' => 'open',
        ];

        $fields["content_padding_closed"] = [
            'label' => esc_html__('Content Padding', 'dipi-faq'),
            'type' => 'custom_margin',
            'mobile_options' => true,
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_content',
            'sub_toggle' => 'closed',
            'default' => '|20px|20px|20px',
        ];

        $fields["content_padding_open"] = [
            'label' => esc_html__('Content Padding', 'dipi-faq'),
            'type' => 'custom_margin',
            'mobile_options' => true,
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'faq_content',
            'sub_toggle' => 'open',
        ];
    }

    public function get_advanced_fields_config()
    {
        $fields = [];

        //Disable Text settings because we add our own
        $fields["text"] = false;
        $fields["text_shadow"] = false;

        $fields['fonts']['title_closed'] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'toggle_slug' => 'faq_title',
            'sub_toggle' => 'closed',
            'css' => [
                'main' => '%%order_class%% .dipi-faq-entry .dipi-faq-title h1,%%order_class%% .dipi-faq-entry .dipi-faq-title h2,%%order_class%% .dipi-faq-entry .dipi-faq-title h3,%%order_class%% .dipi-faq-entry .dipi-faq-title h4,%%order_class%% .dipi-faq-entry .dipi-faq-title h5,%%order_class%% .dipi-faq-entry .dipi-faq-title h6,%%order_class%% .dipi-faq-entry .dipi-faq-title p,%%order_class%% .dipi-faq-entry .dipi-faq-title span',
            ],
            'font_size' => [
                'default' => '16px',
            ],
        ];

        $fields['fonts']['title_open'] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'toggle_slug' => 'faq_title',
            'sub_toggle' => 'open',
            'css' => [
                'main' => '%%order_class%% .dipi-faq-entry.open .dipi-faq-title h1,%%order_class%% .dipi-faq-entry.open .dipi-faq-title h2,%%order_class%% .dipi-faq-entry.open .dipi-faq-title h3,%%order_class%% .dipi-faq-entry.open .dipi-faq-title h4,%%order_class%% .dipi-faq-entry.open .dipi-faq-title h5,%%order_class%% .dipi-faq-entry.open .dipi-faq-title h6,%%order_class%% .dipi-faq-entry.open .dipi-faq-title p,%%order_class%% .dipi-faq-entry.open .dipi-faq-title span',
            ],
        ];

        $fields['fonts']['content_closed'] = [
            'label' => esc_html__('Content', 'dipi-divi-pixel'),
            'toggle_slug' => 'faq_content',
            'sub_toggle' => 'closed',
            'css' => [
                'main' => '%%order_class%% .dipi-faq-entry .dipi-faq-content',
            ],
        ];

        $fields['fonts']['content_open'] = [
            'label' => esc_html__('Content', 'dipi-divi-pixel'),
            'toggle_slug' => 'faq_content',
            'sub_toggle' => 'open',
            'css' => [
                'main' => '%%order_class%% .dipi-faq-entry.open .dipi-faq-content',
            ],
        ];
        $fields['fonts']['content_link'] = [
            'label' => esc_html__('Content Link', 'dipi-divi-pixel'),
            'toggle_slug' => 'faq_content',
            'sub_toggle' => 'link',
            'hide_text_align' => true,
            'css' => [
                'main' => '%%order_class%% .dipi-faq-entry .dipi-faq-content a',
            ],
        ];

        /***********
         * Borders *
         ***********/

        $fields["borders"]["default"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%%",
                    'border_styles' => "%%order_class%%",
                ],
            ],
        ];

        // Entry
        $fields["borders"]["entries_closed"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-faq-entry",
                    'border_styles' => "%%order_class%% .dipi-faq-entry",
                ],
            ],
            'toggle_slug' => 'faq_entry_closed',
        ];

        $fields["borders"]["entries_open"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-faq-entry.open",
                    'border_styles' => "%%order_class%% .dipi-faq-entry.open",
                ],
            ],
            'toggle_slug' => 'faq_entry_open',
        ];

        // Title
        $fields["borders"]["title_closed"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-faq-entry .dipi-faq-title",
                    'border_styles' => "%%order_class%% .dipi-faq-entry .dipi-faq-title",
                ],
            ],
            'toggle_slug' => 'faq_title_border_closed',
        ];

        $fields["borders"]["title_open"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-faq-entry.open .dipi-faq-title",
                    'border_styles' => "%%order_class%% .dipi-faq-entry.open .dipi-faq-title",
                ],
            ],
            'toggle_slug' => 'faq_title_border_open',
        ];

        // Content
        $fields["borders"]["content_closed"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-faq-entry .dipi-faq-content",
                    'border_styles' => "%%order_class%% .dipi-faq-entry .dipi-faq-content",
                ],
            ],
            'toggle_slug' => 'faq_content_border_closed',
        ];

        $fields["borders"]["content_open"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-faq-entry.open .dipi-faq-content",
                    'border_styles' => "%%order_class%% .dipi-faq-entry.open .dipi-faq-content",
                ],
            ],
            'toggle_slug' => 'faq_content_border_open',
        ];


        /**
         * Box Shadow
         */

        $fields["box_shadow"]["default"] = [
            'css' => [
                'main' => "%%order_class%%",
            ],
        ];

        $fields["box_shadow"]["entries_closed"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-faq-entry",
            ],
            'toggle_slug' => 'faq_entry_closed',
        ];

        $fields["box_shadow"]["entries_open"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-faq-entry.open",
            ],
            'toggle_slug' => 'faq_entry_open',
        ];

        return $fields;
    }

    public static function ds_get_output($args = [], $conditional_tags = [], $current_page = [])
    {
        $defaults = [
            'show_all' => 'off',
            'show_uncategorized' => 'off',
            'faq_categories' => '',
            'excluded_post_ids' => '',
            'included_post_ids' => '',
            'faq_order_by' => 'title',
            'faq_order' => 'ASC',
            'output_json' => 'on',
            'output_html' => 'on',
        ];

        $args = wp_parse_args($args, $defaults);

        // Build the args for WP_Query
        $query_args = [
            'post_type' => 'dipi_faq',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'fields' => 'ids',
        ];

        if ('off' === $args['show_all']) {
            $query_args['tax_query'] = [
                'relation' => 'OR',
            ];

            $query_args['tax_query'][] = [
                'taxonomy' => 'dipi_faq_category',
                'field' => 'term_id',
                'terms' => explode(",", $args['faq_categories']),
            ];

            if ('off' !== $args['show_uncategorized']) {
                $get_terms = get_terms('dipi_faq_category', ['fields' => 'ids']);
                if(is_array($get_terms) && !empty($get_terms)){
                    $query_args['tax_query'][] = [
                        'taxonomy' => 'dipi_faq_category',
                        'field' => 'term_id',
                        'operator' => 'NOT IN',
                        'terms' => get_terms('dipi_faq_category', ['fields' => 'ids']),
                    ];
                } else {
                    $query_args['tax_query'] = null;
                }
            }
        }

        if ('' !== $args['excluded_post_ids']) {
            $query_args['post__not_in'] = explode(",", $args['excluded_post_ids']);
        }

        $query = new WP_Query($query_args);
        $all_ids = array_merge($query->posts, explode(",", $args['included_post_ids']));
        $query = new WP_Query([
            'post_type' => 'dipi_faq',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'post__in' => $all_ids,
            'orderby' => $args['faq_order_by'],
            'order' => $args['faq_order'],
        ]);

        $schema = [
            "@context" => "https://schema.org",
            "@type" => "FAQPage",
            "@id" => get_permalink(),
            "mainEntity" => [],
        ];
        $html = "";

        $entry_number = 0;
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                $id = get_the_ID();
                $title = get_the_title();
                $content = apply_filters("the_content", get_the_content());

                $schema['mainEntity'][] = [
                    "@type" => "Question",
                    "name" => $title,
                    "acceptedAnswer" => [
                        "@type" => "Answer",
                        "text" => $content,
                    ],
                ];

                $icons = '';

                $icons = sprintf('<i class="dipi-faq-icon-open">%1$s</i>
                                    <i class="dipi-faq-icon-closed">%2$s</i>', 
                                    esc_attr(et_pb_process_font_icon($args['icon_open'])),
                                    esc_attr(et_pb_process_font_icon($args['icon_closed']))
                                );

                                    
                $html .= sprintf(
                    '<div class="dipi-faq-entry" data-entry-number="%4$s">
                        <div class="dipi-faq-title">%5$s<%6$s>%2$s</%6$s></div>
                        <div class="dipi-faq-content">%3$s</div>
                    </div>',
                    $id,
                    $title,
                    $content,
                    $entry_number,
                    $icons,
                    $args['heading_tag']
                );
                $entry_number++;
            }
        }

        $schema_script = '';
        if('on' === $args['output_json']){
            $schema_script = sprintf('<script type="application/ld+json">%1$s</script>', json_encode($schema));
        }

        $html_code = '';
        if('on' === $args['output_html']){
            $html_code = $html;
        }

        $output = sprintf(
            '%1$s%2$s',
            $schema_script,
            $html_code
        );

        if('' === $output){
            $output = esc_html__('Both, ld+json and HTML are disabled. This module has no output.', 'dipi-faq');
        }

        return $output;
    }

    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_faq_public');

        $this->ds_apply_css($render_slug);

        $config = [
            "layout" => $this->props['faq_layout'],
        ];

        if ('on' === $this->props['accordion_open_first']) {
            $config["open_first"] = true;
        }

        if ('on' === $this->props['accordion_close_all']) {
            $config["close_all"] = true;
        }

        $accordion_not_closable = '';
        if('accordion' === $this->props['faq_layout'] && 'on' !== $this->props['accordion_close_all']){
            $accordion_not_closable = "dipi-faq-accordion-not-closable";
        }

        return sprintf(
            '<div class="dipi-faq-wrapper dipi-faq-%4$s loading %3$s" style="display: none;" data-config="%2$s">
				%1$s
			</div>',
            self::ds_get_output($this->props),
            esc_attr(htmlspecialchars(json_encode($config), ENT_QUOTES, 'UTF-8')),
            $accordion_not_closable,
            $this->props['faq_layout']
        );
    }

    private function ds_apply_css($render_slug)
    {
        // Apply Icons only when using toggle styles

        if('plain' !== $this->props['faq_layout']){
            
            $this->dipi_generate_font_icon_styles($render_slug, 'icon_open', '%%order_class%% .dipi-faq-icon-open');
            $this->dipi_generate_font_icon_styles($render_slug, 'icon_closed', '%%order_class%% .dipi-faq-icon-closed');
            
            $icon_closed_color = $this->props['icon_closed_color'];
            $icon_closed_bg_color = $this->props['icon_closed_bg_color'];
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-faq-title .dipi-faq-icon-closed',
                'declaration' => "content: attr(data-icon);
                                  color: {$icon_closed_color};
                                  background: {$icon_closed_bg_color};",
            ]);
            $this->ds_set_responsive_style($render_slug, $this->props, "icon_closed_padding", "%%order_class%% .dipi-faq-title .dipi-faq-icon-closed", "padding");
            $this->ds_set_responsive_style($render_slug, $this->props, "icon_closed_font_size", "%%order_class%% .dipi-faq-title .dipi-faq-icon-closed", "font-size");
            $this->ds_set_responsive_style($render_slug, $this->props, "icon_closed_border_radius", "%%order_class%% .dipi-faq-title .dipi-faq-icon-closed", "border-radius");

            $icon_open_color = $this->props['icon_open_color'];
            $icon_open_bg_color = $this->props['icon_open_bg_color'];
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-faq-title .dipi-faq-icon-open',
                'declaration' => "content: attr(data-icon);
                                  color: {$icon_open_color};
                                  background: {$icon_open_bg_color};",
            ]);     
            $this->ds_set_responsive_style($render_slug, $this->props, "icon_open_padding", "%%order_class%% .dipi-faq-title .dipi-faq-icon-open", "padding");
            $this->ds_set_responsive_style($render_slug, $this->props, "icon_open_font_size", "%%order_class%% .dipi-faq-title .dipi-faq-icon-open", "font-size");
            $this->ds_set_responsive_style($render_slug, $this->props, "icon_open_border_radius", "%%order_class%% .dipi-faq-title .dipi-faq-icon-open", "border-radius");


            if('on' === $this->props['icon_animate']) {
                ET_Builder_Element::set_style($render_slug, [
                    'selector' => '%%order_class%% .open .dipi-faq-title .dipi-faq-icon-closed',
                    'declaration' => "transform: rotate(90deg);",
                ]); 
                ET_Builder_Element::set_style($render_slug, [
                    'selector' => '%%order_class%% .closed .dipi-faq-title .dipi-faq-icon-open',
                    'declaration' => "transform: rotate(-90deg);",
                ]); 

                if('on' === $this->props['icon_animate_delay']){
                    ET_Builder_Element::set_style($render_slug, [
                        'selector' => '%%order_class%% .dipi-faq-title .dipi-faq-icon-open, %%order_class%% .dipi-faq-title .dipi-faq-icon-closed',
                        'declaration' => "transition-delay: 0.3s;",
                    ]); 
                }
            }
        }



        /**
         * Entry Wrapper Options
         */
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-faq-entry',
            'declaration' => "background-color: {$this->props['entry_background_closed']};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-faq-entry.open',
            'declaration' => "background-color: {$this->props['entry_background_open']};",
        ]);

        $this->ds_set_responsive_style($render_slug, $this->props, "entry_padding_closed", "%%order_class%% .dipi-faq-entry", "padding");
        $this->ds_set_responsive_style($render_slug, $this->props, "entry_padding_open", "%%order_class%% .dipi-faq-entry.open", "padding");
        $this->ds_set_responsive_style($render_slug, $this->props, "entry_margin_closed", "%%order_class%% .dipi-faq-entry", "margin");
        $this->ds_set_responsive_style($render_slug, $this->props, "entry_margin_open", "%%order_class%% .dipi-faq-entry.open", "margin");

        /**
         * Title Options
         */

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-faq-entry .dipi-faq-title',
            'declaration' => "background-color: {$this->props['title_background_closed']};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-faq-entry.open .dipi-faq-title',
            'declaration' => "background-color: {$this->props['title_background_open']};",
        ]);

        $this->ds_set_responsive_style($render_slug, $this->props, "title_padding_closed", "%%order_class%% .dipi-faq-entry .dipi-faq-title", "padding");
        $this->ds_set_responsive_style($render_slug, $this->props, "title_padding_open", "%%order_class%% .dipi-faq-entry.open .dipi-faq-title", "padding");

        $this->ds_set_responsive_style($render_slug, $this->props, "title_closed_text_align", "%%order_class%% .dipi-faq-entry .dipi-faq-title span", "justify-content");
        $this->ds_set_responsive_style($render_slug, $this->props, "title_open_text_align", "%%order_class%% .dipi-faq-entry.open .dipi-faq-title span", "justify-content");


        /**
         * Content Options
         */
        $this->ds_set_responsive_style($render_slug, $this->props, "content_padding_closed", "%%order_class%% .dipi-faq-entry .dipi-faq-content", "padding");
        $this->ds_set_responsive_style($render_slug, $this->props, "content_padding_open", "%%order_class%% .dipi-faq-entry.open .dipi-faq-content", "padding");

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-faq-entry .dipi-faq-content',
            'declaration' => "background-color: {$this->props['content_background_closed']};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-faq-entry.open .dipi-faq-content',
            'declaration' => "background-color: {$this->props['content_background_open']};",
        ]);
    }

    private function ds_set_responsive_style($render_slug, $props, $property, $css_selector, $css_property, $important = false)
    {

        $responsive_active = !empty($props[$property . "_last_edited"]) && et_pb_get_responsive_status($props[$property . "_last_edited"]);

        $declaration_desktop = "";
        $declaration_tablet = "";
        $declaration_phone = "";

        switch ($css_property) {
            case "margin":
            case "padding":
                if (!empty($props[$property])) {
                    $values = explode("|", $props[$property]);
                    $declaration_desktop = "{$css_property}-top: {$values[0]};
                                           {$css_property}-right: {$values[1]};
                                           {$css_property}-bottom: {$values[2]};
                                           {$css_property}-left: {$values[3]};";
                }

                if ($responsive_active && !empty($props[$property . "_tablet"])) {
                    $values = explode("|", $props[$property . "_tablet"]);
                    $declaration_tablet = "{$css_property}-top: {$values[0]};
                                          {$css_property}-right: {$values[1]};
                                          {$css_property}-bottom: {$values[2]};
                                          {$css_property}-left: {$values[3]};";
                }

                if ($responsive_active && !empty($props[$property . "_phone"])) {
                    $values = explode("|", $props[$property . "_phone"]);
                    $declaration_phone = "{$css_property}-top: {$values[0]};
                                         {$css_property}-right: {$values[1]};
                                         {$css_property}-bottom: {$values[2]};
                                         {$css_property}-left: {$values[3]};";
                }
                break;
            default: //Default is applied for values like height, color etc.
                if (!empty($props[$property])) {
                    $declaration_desktop = "{$css_property}: {$props[$property]};";
                }
                if ($responsive_active && !empty($props[$property . "_tablet"])) {
                    $declaration_tablet = "{$css_property}: {$props[$property . "_tablet"]};";
                }
                if ($responsive_active && !empty($props[$property . "_phone"])) {
                    $declaration_phone = "{$css_property}: {$props[$property . "_phone"]};";
                }
        }

        \ET_Builder_Element::set_style($render_slug, [
            'selector' => $css_selector,
            'declaration' => $declaration_desktop,
        ]);

        if (!empty($props[$property . "_tablet"]) && $responsive_active) {
            \ET_Builder_Element::set_style($render_slug, [
                'selector' => $css_selector,
                'declaration' => $declaration_tablet,
                'media_query' => \ET_Builder_Element::get_media_query('max_width_980'),
            ]);
        }

        if (!empty($props[$property . "_phone"]) && $responsive_active) {
            \ET_Builder_Element::set_style($render_slug, [
                'selector' => $css_selector,
                'declaration' => $declaration_phone,
                'media_query' => \ET_Builder_Element::get_media_query('max_width_767'),
            ]);
        }
    }
}

new DIPI_FAQ;
