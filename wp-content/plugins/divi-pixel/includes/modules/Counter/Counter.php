<?php

//TODO:
//-Option to fade in counter when scrolling (like original counter)
//-Setting to exclude taxonomies from counting posts
//TODO: Y/N switch to activate continous counting (so counting seconds makes sense)



//TODO: count_number_decimal_separator location based on user or localeconv()['decimal_point']
//TODO: count_to_post_exclude_terms implementieren

class DIPI_Counter extends DIPI_Builder_Module
{
    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/counter',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->slug = 'dipi_counter';
        $this->vb_support = 'on';
        $this->name = esc_html__('Pixel Counter', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%.dipi_counter';
    }

    public function get_settings_modal_toggles()
    {
        return [
            'general' => [
                'toggles' => [
                    'counter_text' => esc_html__('Text', 'dipi-divi-pixel'),
                    'counter' => esc_html__('Counter', 'dipi-divi-pixel'),
                    'count_to' => esc_html__('Count To', 'dipi-divi-pixel'),
                    'count_from' => esc_html__('Count From', 'dipi-divi-pixel'),
                    'count_post' => esc_html__('Post Count Settings', 'dipi-divi-pixel'),
                    'counter_halfcircle' => esc_html__('Half Circle Settings', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'counter' => esc_html__('Counter', 'dipi-divi-pixel'),
                    'counter_circle' => esc_html__('Circle', 'dipi-divi-pixel'),
                    'text' => [
                        'sub_toggles' => array(
                            'all' => array(
                                'name' => esc_html__('All', 'dipi-divi-pixel'),
                            ),
                            'prefix'        => array(
                                'name' => esc_html__('Prefix', 'dipi-divi-pixel'),
                            ),
                            'number'        => array(
                                'name' => esc_html__('Number', 'dipi-divi-pixel'),
                            ),
                            'suffix'        => array(
                                'name' => esc_html__('Suffix', 'dipi-divi-pixel'),
                            ),
                        ),
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__('Text', 'dipi-divi-pixel'),
                    ]
                ]
            ]
        ];
    }

    public function get_custom_css_fields_config()
    {
        $fields = [];

        $fields['number_before'] = array(
            'label' => esc_html__('Number Container (Before)', 'dipi-divi-pixel'),
            'selector' => '.dipi_counter_number:before',
        );

        $fields['number'] = array(
            'label' => esc_html__('Number Container', 'dipi-divi-pixel'),
            'selector' => '.dipi_counter_number',
        );

        $fields['number_after'] = array(
            'label' => esc_html__('Number Container (After)', 'dipi-divi-pixel'),
            'selector' => '.dipi_counter_number:after',
        );

        $fields['number_prefix_before'] = array(
            'label' => esc_html__('Number Prefix (Before)', 'dipi-divi-pixel'),
            'selector' => '.dipi_counter_number_prefix:before',
        );

        $fields['number_prefix'] = array(
            'label' => esc_html__('Number Prefix', 'dipi-divi-pixel'),
            'selector' => '.dipi_counter_number_prefix',
        );

        $fields['number_prefix_after'] = array(
            'label' => esc_html__('Number Prefix (After)', 'dipi-divi-pixel'),
            'selector' => '.dipi_counter_number_prefix:after',
        );
        $fields['half_circle'] = array(
            'label' => esc_html__('Half Circle', 'dipi-divi-pixel'),
            'selector' => '.half_circle svg.circle-container',
        );
        $fields['number_number_before'] = array(
            'label' => esc_html__('Number (Before)', 'dipi-divi-pixel'),
            'selector' => '.dipi_counter_number_number:before',
        );

        $fields['number_number'] = array(
            'label' => esc_html__('Number', 'dipi-divi-pixel'),
            'selector' => '.dipi_counter_number_number',
        );

        $fields['number_number_after'] = array(
            'label' => esc_html__('Number (After)', 'dipi-divi-pixel'),
            'selector' => '.dipi_counter_number_number:after',
        );

        $fields['number_suffix_before'] = array(
            'label' => esc_html__('Number Suffix (Before)', 'dipi-divi-pixel'),
            'selector' => '.dipi_counter_number_suffix:before',
        );

        $fields['number_suffix'] = array(
            'label' => esc_html__('Number Suffix', 'dipi-divi-pixel'),
            'selector' => '.dipi_counter_number_suffix',
        );

        $fields['number_suffix_after'] = array(
            'label' => esc_html__('Number Suffix (After)', 'dipi-divi-pixel'),
            'selector' => '.dipi_counter_number_suffix:after',
        );
        $fields['start_label'] = array(
            'label' => esc_html__('Start Label', 'dipi-divi-pixel'),
            'selector' => '.half_circle .dipi_label.dipi_start_label',
        );
        $fields['end_label'] = array(
            'label' => esc_html__('End Label', 'dipi-divi-pixel'),
            'selector' => '.half_circle .dipi_label.dipi_end_label',
        );
        $fields['module_hover'] = array(
            'label' => esc_html__('Main Element (Module Hover)', 'dipi-divi-pixel'),
            'selector' => ':hover',
            'no_space_before_selector' => true,
        );

        $fields['number_module_hover'] = array(
            'label' => esc_html__('Number Container (Module Hover)', 'dipi-divi-pixel'),
            'selector' => ':hover .dipi_counter_number',
            'no_space_before_selector' => true,
        );

        $fields['number_prefix_module_hover'] = array(
            'label' => esc_html__('Number Prefix (Module Hover)', 'dipi-divi-pixel'),
            'selector' => ':hover .dipi_counter_number_prefix',
            'no_space_before_selector' => true,
        );

        $fields['number_number_module_hover'] = array(
            'label' => esc_html__('Number (Module Hover)', 'dipi-divi-pixel'),
            'selector' => ':hover .dipi_counter_number_number',
            'no_space_before_selector' => true,
        );

        $fields['number_suffix_module_hover'] = array(
            'label' => esc_html__('Number Suffix (Module Hover)', 'dipi-divi-pixel'),
            'selector' => ':hover .dipi_counter_number_suffix',
            'no_space_before_selector' => true,
        );

        return $fields;
    }

    public function get_fields()
    {
        $et_builder_accent_color = et_builder_accent_color();

        $fields = [];

        // Text Toggle
        $fields['prefix'] = [
            'label' => esc_html__('Prefix', 'dipi-divi-pixel'),
            'type' => 'text',
            'dynamic_content' => 'text',
            'option_category' => 'configuration',
            'toggle_slug' => 'counter_text',
            'description' => esc_html__('Text to the left of the number. By default uses the same text style as the number.', 'dipi-divi-pixel'),
        ];

        $fields['suffix'] = [
            'label' => esc_html__('Suffix', 'dipi-divi-pixel'),
            'type' => 'text',
            'dynamic_content' => 'text',
            'option_category' => 'configuration',
            'toggle_slug' => 'counter_text',
            'description' => esc_html__('Text to the right of the number. By default uses the same text style as the number.', 'dipi-divi-pixel'),
        ];
		$fields['text_direction'] = [
			'label'           => esc_html__('Prefx/Suffix Direction', 'dipi-divi-pixel'),
			'type'  => 'select',
			'description'     => esc_html__('Select how you would like to display the heading. Either inline or stacked.', 'dipi-divi-pixel'),
			'toggle_slug'     => 'counter_text',
			'options'         => array(
				'inline' => esc_html__('Row', 'dipi-divi-pixel'),
				'block' => esc_html__('Column', 'dipi-divi-pixel'),
			),
			'default'         => 'row',
			'mobile_options'  => true,
		];
        // Counter Toggle 
        $fields['counter_type'] = [
            'label' => esc_html__('Counter Type', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'configuration',
            'default' => 'number',
            'options' => array(
                'number' => esc_html__('Number', 'dipi-divi-pixel'),
                'circle' => esc_html__('Circle', 'dipi-divi-pixel'),
                'half_circle' => esc_html__('Half Circle', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'counter',
            'description' => esc_html__('Choose the type of counter you want to use. Either a plain number counter or a number counter inside a circle.', 'dipi-divi-pixel'),
        ];

        $fields['count_circle_percent'] = [
            'label' => esc_html__('Circle Percent', 'dipi-divi-pixel'),
            'show_if_not' => [
                'counter_type' => 'number',
            ],
            'type' => 'text',
            'default' => '75',
            'option_category' => 'configuration',
            'toggle_slug' => 'counter',
            'dynamic_content' => 'text',
            'description' => esc_html__("Percent value of how much to fill the circle. Use only numbers from 0 to 100", 'dipi-divi-pixel'),
        ];

        $fields['count_to_type'] = [
            'label' => esc_html__('Count', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'configuration',
            'default' => 'number',
            'options' => array(
                'number' => esc_html__('Numbers', 'dipi-divi-pixel'),
                'date' => esc_html__('Dates', 'dipi-divi-pixel'),
                'post' => esc_html__('Posts', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'counter',
            'description' => esc_html__('Choose what you want to count.', 'dipi-divi-pixel'),
        ];

        $fields['counter_force_decimals'] = [
            'label' => esc_html__('Force Decimal Places', 'dipi-divi-pixel'),
            'description' => esc_html__('Force the counter to show decimal places. If enabled, the counter will always show the number of decimal places specified below. If disabled, the counter will automatically determine whether or not and how many decimal places to show.', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'toggle_slug' => 'counter',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
        ];

        $fields['count_number_decimals'] = [
            'label' => esc_html__('Number of Decimal Places', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'unitless' => true,
            'default' => '2',
            'range_settings' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'toggle_slug' => 'counter',
            'description' => esc_html__("How many decimal places to show. Only takes effect if Force Decimal Places is enabled.", 'dipi-divi-pixel'),
            'show_if' => [
                'counter_force_decimals' => 'on'
            ]
        ];

        $fields['count_number_thousands_separator'] = [
            'label' => esc_html__('Thousands Separator', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => '',
            'option_category' => 'configuration',
            'toggle_slug' => 'counter',
            'description' => esc_html__('The separator to be used for separating thousands (e. g. "," to get "1,000" instead of "1000")', 'dipi-divi-pixel'),
        ];

        $fields['count_number_decimal_separator'] = [
            'label' => esc_html__('Decimal Separator', 'dipi-divi-pixel'),
            'type' => 'text',
            // 'default' => localeconv()['decimal_point'],
            'default' => '',
            'option_category' => 'configuration',
            'toggle_slug' => 'counter',
            'description' => esc_html__('The separator to be used for separating decimals (e. g. ":" to get "1:23" instead of "1.23"). Uses "." by default.', 'dipi-divi-pixel'),
        ];
        $fields['halfcircle_label'] = [
            'label' => esc_html__('Half Circle Label', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'configuration',
            'default' => 'none',
            'options' => array(
                'none' => esc_html__('None', 'dipi-divi-pixel'),
                'presuffix' => esc_html__('Prefix/Suffix', 'dipi-divi-pixel'),
                'fromto' => esc_html__('From/To', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'counter_halfcircle',
            'description' => esc_html__('Choose the position what will be shown as the label of Half Circle.', 'dipi-divi-pixel'),
            'show_if' => [
                'counter_type' => 'half_circle',
            ],
        ];
        // Count To Toggle
        $fields['count_to_number'] = [
            'label' => esc_html__('Number', 'dipi-divi-pixel'),
            'show_if' => [
                'count_to_type' => 'number',
            ],
            'dynamic_content' => 'text',
            'type' => 'text',
            'option_category' => 'configuration',
            'toggle_slug' => 'count_to',
            'description' => esc_html__("The number to count to. Leave empty to use 0 as the target number.", 'dipi-divi-pixel'),
        ];

        $fields['count_to_date'] = [
            'label' => esc_html__('Date', 'dipi-divi-pixel'),
            'show_if' => [
                'count_to_type' => 'date',
            ],
            'type' => 'date_picker',
            'option_category' => 'configuration',
            'toggle_slug' => 'count_to',
            'description' => esc_html__('The date the counter is counting to. Leave empty to use the current date.', 'dipi-divi-pixel'),
        ];

        $fields['count_to_include_date'] = [
            'label' => esc_html__('Include Date when counting', 'dipi-divi-pixel'),
            'show_if' => [
                'count_to_type' => 'date',
            ],
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'count_to',
            'description' => esc_html__('When activated, adds one period worth of time to the date before calculating the time difference.', 'dipi-divi-pixel'),
        ];

        $fields['count_date_type'] = [
            'label' => esc_html__('Type', 'dipi-divi-pixel'),
            'show_if' => [
                'count_to_type' => 'date',
            ],
            'type' => 'select',
            'option_category' => 'configuration',
            'toggle_slug' => 'counter',
            'default' => 'days',
            'options' => array(
                'seconds' => esc_html__('Seconds', 'dipi-divi-pixel'),
                'minutes' => esc_html__('Minutes', 'dipi-divi-pixel'),
                'hours' => esc_html__('Hours', 'dipi-divi-pixel'),
                'days' => esc_html__('Days', 'dipi-divi-pixel'),
                'weeks' => esc_html__('Weeks', 'dipi-divi-pixel'),
                'month' => esc_html__('Month', 'dipi-divi-pixel'),
                'years' => esc_html__('Years', 'dipi-divi-pixel'),
            ),
            'description' => esc_html__('The period the counter should count (e. g. days or years).', 'dipi-divi-pixel'),
        ];

        // $fields['count_to_post'] = [
        //     'label' => esc_html__('Post Types to count', 'dipi-divi-pixel'),
        //     'show_if' => [
        //         'count_to_type' => 'post',
        //     ],
        //     'type' => 'multiple_checkboxes',
        //     'options' => DIPI_Counter::get_post_types_to_count(),
        //     'additional_att' => 'disable_on',
        //     'option_category' => 'configuration',
        //     'description' => esc_html__('Choose which post types to count', 'dipi-divi-pixel'),
        //     'toggle_slug' => 'count_to',
        // ];

        // $fields['count_to_post_offset'] = [
        //     'label' => esc_html__('Offset', 'dipi-divi-pixel'),
            // 'show_if' => [
            //     'count_to_type' => 'post',
            // ],
        //     'default' => '0',
        //     'type' => 'text',
        //     'option_category' => 'configuration',
        //     'toggle_slug' => 'count_to',
        //     'description' => esc_html__("Offset to add or subtract to/from the count. Positive numbers will be added, negative numbers will be substracted.", 'dipi-divi-pixel'),
        // ];

        // $fields['count_to_post_exclude_terms'] = [
        //     'label' => esc_html__('Exclude Terms', 'dipi-divi-pixel'),
        //     'show_if' => [
        //         'count_to_type' => 'post',
        //     ],
        //     'default' => '',
        //     'type' => 'text',
        //     'option_category' => 'configuration',
        //     'toggle_slug' => 'count_to',
        //     'description' => esc_html__("Comma separated list of term slugs to exclude. You can find the slug of a term in the corresponding taxonomy screen.", 'dipi-divi-pixel'),
        // ];

        // Count From Toggle
        $fields['count_from_number'] = [
            'label' => esc_html__('Number', 'dipi-divi-pixel'),
            'show_if' => [
                'count_to_type' => 'number',
            ],
            'dynamic_content' => 'text',
            'type' => 'text',
            'option_category' => 'configuration',
            'toggle_slug' => 'count_from',
            'description' => esc_html__("The number to count from. Leave empty to use 0 as the starting number.", 'dipi-divi-pixel'),
        ];

        $fields['count_from_date'] = [
            'label' => esc_html__('Date', 'dipi-divi-pixel'),
            'show_if' => [
                'count_to_type' => 'date',
            ],
            'type' => 'date_picker',
            'option_category' => 'configuration',
            'toggle_slug' => 'count_from',
            'description' => esc_html__('The date the counter is counting from. Leave empty to use the current date.', 'dipi-divi-pixel'),
        ];

        $fields['count_from_include_date'] = [
            'label' => esc_html__('Include Date when counting', 'dipi-divi-pixel'),
            'show_if' => [
                'count_to_type' => 'date',
            ],
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'count_from',
            'description' => esc_html__('When activated, adds one period worth of time to the date before calculating the time difference.', 'dipi-divi-pixel'),
        ];

        // Counter Toggle (Advanced Tab)
        $fields['count_duration'] = [
            'label' => esc_html__('Animation Duration (ms)', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'layout',
            'default' => '2000',
            'range_settings' => array(
                'min' => '100',
                'max' => '10000',
                'step' => '100',
            ),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'counter',
            'unitless' => true,
            'description' => esc_html__("Duration of the count animation in milliseconds.", 'dipi-divi-pixel'),
        ];

        $fields['count_animation_delay'] = [
            'label' => esc_html__('Animation Delay', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'layout',
            'default' => '0',
            'range_settings' => array(
                'min' => '100',
                'max' => '10000',
                'step' => '100',
            ),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'counter',
            'unitless' => true,
            'description' => esc_html__("The delay in milliseconds before the count animation. Normally the animations stars automatically when the counter is visible. If you run additional animations (e. g. fade in) you can postpone the start of the animation with this option.", 'dipi-divi-pixel'),
        ];

        // Counter Circle Toggle (Advanced Tab)
        $fields['circle_bar_color'] = [
            'label' => esc_html__('Bar Color ', 'dipi-divi-pixel'),
            'show_if_not' => [
                'counter_type' => 'number',
            ],
            'toggle_slug' => 'counter_circle',
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'type' => 'color-alpha',
            'default' => $et_builder_accent_color,
            'description' => esc_html__('Color of the counter bar.', 'dipi-divi-pixel'),
        ];

        $fields['circle_track_color'] = [
            'label' => esc_html__('Track Color ', 'dipi-divi-pixel'),
            'show_if_not' => [
                'counter_type' => 'number',
            ],
            'toggle_slug' => 'counter_circle',
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'type' => 'color-alpha',
            'default' => 'rgba(0,0,0,0.1)',
            'description' => esc_html__('Color of the background circle.', 'dipi-divi-pixel'),
        ];

        $fields['circle_line_width'] = [
            'label' => esc_html__('Line Width ', 'dipi-divi-pixel'),
            'show_if_not' => [
                'counter_type' => 'number',
            ],
            'toggle_slug' => 'counter_circle',
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'type' => 'range',
            'default' => '5',
            'range_settings' => array(
                'min' => '1',
                'max' => '100',
                'step' => '1',
            ),
            'unitless' => true,
            'description' => esc_html__('Circle line width. You can create pie charts using line cap "butt" and double the size of the line width.', 'dipi-divi-pixel'),
        ];

        $fields['circle_line_cap'] = [
            'label' => esc_html__('Line Cap ', 'dipi-divi-pixel'),
            'show_if_not' => [
                'counter_type' => 'number',
            ],
            'toggle_slug' => 'counter_circle',
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'type' => 'select',
            'default' => 'round',
            'options' => array(
                'round' => esc_html__('Round', 'dipi-divi-pixel'),
                'square' => esc_html__('Square', 'dipi-divi-pixel'),
                'butt' => esc_html__('Butt', 'dipi-divi-pixel'),
            ),
            'description' => esc_html__('Line cap of the bar.', 'dipi-divi-pixel'),
        ];

        $fields['circle_size'] = [
            'label' => esc_html__('Circle Size', 'dipi-divi-pixel'),
            'show_if_not' => [
                'counter_type' => 'number',
            ],
            'toggle_slug' => 'counter_circle',
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'type' => 'range',
            'range_settings' => array(
                'min' => '10',
                'max' => '500',
                'step' => '1',
            ),
            'unitless' => true,
            'description' => esc_html__('Set to use a fixed size for the circle or leave empty to make the circle size responsive. Divis default circle counter uses a fixed size of 225.', 'dipi-divi-pixel'),
        ];

        $fields['circle_rotate'] = [
            'label' => esc_html__('Circle Rotate', 'dipi-divi-pixel'),
            'show_if' => [
                'counter_type' => 'circle',
            ],
            'toggle_slug' => 'counter_circle',
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'type' => 'range',
            'default' => '0',
            'range_settings' => array(
                'min' => '0',
                'max' => '360',
                'step' => '1',
            ),
            'unitless' => true,
            'description' => esc_html__('Rotate the circle to offset the starting position.', 'dipi-divi-pixel'),
        ];

        $fields['circle_use_scale'] = [
            'label' => esc_html__('Use Scale', 'dipi-divi-pixel'),
            'show_if' => [
                'counter_type' => 'circle',
            ],
            'toggle_slug' => 'counter_circle',
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'affects' => array(
                'circle_scale_length',
                'circle_scale_color',
            ),
            'description' => esc_html__('Whether or not to show scale lines on around the circle.', 'dipi-divi-pixel'),
        ];

        $fields['circle_scale_length'] = [
            'label' => esc_html__('Scale Length', 'dipi-divi-pixel'),
            'show_if' => [
                'counter_type' => 'circle',
                'circle_use_scale' => 'on',
            ],
            'toggle_slug' => 'counter_circle',
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'type' => 'range',
            'default' => '5',
            'range_settings' => array(
                'min' => '1',
                'max' => '20',
                'step' => '1',
            ),
            'unitless' => true,
            'description' => esc_html__('Length of the scale lines.', 'dipi-divi-pixel'),
        ];

        $fields['circle_scale_color'] = [
            'label' => esc_html__('Scale Color', 'dipi-divi-pixel'),
            'show_if' => [
                'counter_type' => 'circle',
                'circle_use_scale' => 'on',
            ],
            'toggle_slug' => 'counter_circle',
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'type' => 'color-alpha',
            'default' => $et_builder_accent_color,
            'description' => esc_html__('Color of the scale lines.', 'dipi-divi-pixel'),
        ];

        $count_post_fields = DIPI_Counter::get_count_posts_settings_fields();

        $fields["__post_count"] = [
            'type' => 'computed',
            'computed_callback' => array('DIPI_Counter', 'count_posts'),
            'computed_depends_on' => array_keys($count_post_fields),
            // array(
            //     //TODO: Alle Settings für count_post und taxonomies 
            //     'count_to_post',
            //     'count_to_post_offset',
            //     // 'count_to_post_exclude_terms',
            // ),
            // 'computed_minimum' => array(
                // 'count_to_post',
            // ),
        ];

        $fields += $count_post_fields;

        return $fields;
    }

    public function get_advanced_fields_config()
    {
        $fields = [];

        $advanced_fields["text"] = false;

        $advanced_fields["text_shadow"] = false;

        $fields['fonts']['all'] = [
            'label' => esc_html__('All', 'dipi-divi-pixel'),
            'toggle_slug' => 'text',
            'sub_toggle'  => 'all',
            'css' => array(
                'main' => "{$this->main_css_element} .dipi_counter_number_wrapper",
                'important' => 'all',
            ),
            'line_height' => array(
                'default' => '1em',
                'range_settings' => array(
                    'min' => '0.1',
                    'max' => '10',
                    'step' => '0.1',
                ),
            ),
            'font_size' => array(
                'default' => '5em',
                'range_settings' => array(
                    'min' => '0.1',
                    'max' => '10',
                    'step' => '0.1',
                ),
            ),
            'text_align' => [
                'default' => 'center',
            ],
            'text_color' => [
                'default' => et_builder_accent_color(),
            ]
        ];

        $fields['fonts']['prefix'] = [
            'label' => esc_html__('Prefix', 'dipi-divi-pixel'),
            'toggle_slug' => 'text',
            'sub_toggle'  => 'prefix',
            'css' => array(
                'main' => "{$this->main_css_element} .dipi_counter_number .dipi_counter_number_prefix,
                {$this->main_css_element} .half_circle .dipi_label.dipi_start_label
                    ",
                'important' => 'all',
            ),
            'line_height' => array(
                'default' => '1em',
                'range_settings' => array(
                    'min' => '0.1',
                    'max' => '10',
                    'step' => '0.1',
                ),
            ),
            'font_size' => array(
                'default' => '1em',
                'range_settings' => array(
                    'min' => '0.1',
                    'max' => '10',
                    'step' => '0.1',
                ),
            ),
            'text_align' => [
                'default' => 'center',
            ],
            'text_color' => [
                'default' => '',
            ]
        ];

        $fields['fonts']['number'] = [
            'label' => esc_html__('Number', 'dipi-divi-pixel'),
            'toggle_slug' => 'text',
            'sub_toggle'  => 'number',
            'css' => array(
                'main' => "{$this->main_css_element} .dipi_counter_number .dipi_counter_number_number",
                'important' => 'all',
            ),
            'line_height' => array(
                'default' => '1em',
                'range_settings' => array(
                    'min' => '0.1',
                    'max' => '10',
                    'step' => '0.1',
                ),
            ),
            'font_size' => array(
                'default' => '1em',
                'range_settings' => array(
                    'min' => '0.1',
                    'max' => '10',
                    'step' => '0.1',
                ),
            ),
            'text_align' => [
                'default' => 'center',
            ],
            'text_color' => [
                'default' => '',
            ]
        ];

        $fields['fonts']['suffix'] = [
            'label' => esc_html__('Suffix', 'dipi-divi-pixel'),
            'toggle_slug' => 'text',
            'sub_toggle'  => 'suffix',
            'css' => array(
                'main' => "{$this->main_css_element} .dipi_counter_number .dipi_counter_number_suffix,
                {$this->main_css_element} .half_circle .dipi_label.dipi_end_label
                    ",
                'important' => 'all',
            ),
            'line_height' => array(
                'default' => '1em',
                'range_settings' => array(
                    'min' => '0.1',
                    'max' => '10',
                    'step' => '0.1',
                ),
            ),
            'font_size' => array(
                'default' => '1em',
                'range_settings' => array(
                    'min' => '0.1',
                    'max' => '10',
                    'step' => '0.1',
                ),
            ),
            'text_align' => [
                'default' => 'center',
            ],
            'text_color' => [
                'default' => '',
            ]
        ];

        return $fields;
    }
    public function dipi_apply_css($render_slug) {
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .dipi_counter_number_wrapper',
            'declaration' => sprintf(
                'color: %1$s;
                font-size: %2$s;
                line-height: %3$s;
                text-align: %4$s;',
                esc_attr($this->props['all_text_color']),
                esc_attr($this->props['all_font_size']),
                esc_attr($this->props['all_line_height']),
                esc_attr($this->props['all_text_align'])
            ),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .dipi_counter_number .dipi_counter_number_prefix',
            'declaration' => sprintf(
                'color: %1$s;
                font-size: %2$s;
                line-height: %3$s;
                text-align: %4$s;',
                esc_attr($this->props['prefix_text_color']),
                esc_attr($this->props['prefix_font_size']),
                esc_attr($this->props['prefix_line_height']),
                esc_attr($this->props['prefix_text_align'])
            ),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .dipi_counter_number .dipi_counter_number_number',
            'declaration' => sprintf(
                'color: %1$s;
                font-size: %2$s;
                line-height: %3$s;
                text-align: %4$s;',
                esc_attr($this->props['number_text_color']),
                esc_attr($this->props['number_font_size']),
                esc_attr($this->props['number_line_height']),
                esc_attr($this->props['number_text_align'])
            ),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .dipi_counter_number .dipi_counter_number_suffix',
            'declaration' => sprintf(
                'color: %1$s;
                font-size: %2$s;
                line-height: %3$s;
                text-align: %4$s;',
                esc_attr($this->props['suffix_text_color']),
                esc_attr($this->props['suffix_font_size']),
                esc_attr($this->props['suffix_line_height']),
                esc_attr($this->props['suffix_text_align'])
            ),
        ));
        $this->generate_styles(
			array(
				'base_attr_name' => 'text_direction',
				'selector'       => "%%order_class%% .dipi_counter_number .dipi_counter_number_prefix",
				'css_property'   => 'display',
				'render_slug'    => $render_slug,
				'type'           => 'select',
			)
		);
	
		$this->generate_styles(
			array(
				'base_attr_name' => 'text_direction',
				'selector'       => "%%order_class%% .dipi_counter_number .dipi_counter_number_suffix",
				'css_property'   => 'display',
				'render_slug'    => $render_slug,
				'type'           => 'select',
			)
		);

        $this->generate_styles(
			array(
				'base_attr_name' => 'circle_track_color',
				'selector'       => "%%order_class%% .half_circle .background-circle",
				'css_property'   => 'stroke',
				'render_slug'    => $render_slug,
				'type'           => 'color',
			)
		);

        $this->generate_styles(
			array(
				'base_attr_name' => 'circle_size',
				'selector'       => "%%order_class%% .dipi_counter_number_wrapper.half_circle",
				'css_property'   => 'width',
				'render_slug'    => $render_slug,
				'type'           => 'range',
			)
		);
        
        $this->generate_styles(
			array(
				'base_attr_name' => 'circle_line_cap',
				'selector'       => "%%order_class%% .half_circle .background-circle",
				'css_property'   => 'stroke-linecap',
				'render_slug'    => $render_slug,
				'type'           => 'select',
			)
		);
        

    }
    public function render($attrs, $content , $render_slug)
    {        
        wp_enqueue_script('dipi_counter_public');
        $this->dipi_apply_css($render_slug);
        $prefix = $this->props['prefix'];
        $suffix = $this->props['suffix'];
        $count_to_type = $this->props['count_to_type'];
        $counter_type = $this->props['counter_type'];
        $order_class = self::get_module_order_class($render_slug);

        // $count_to_number = $this->props['count_to_number'];
        // $count_from_number = $this->props['count_from_number'];
        $count_to_number = $this->_esc_attr('count_to_number');
        $count_from_number = $this->_esc_attr('count_from_number');

        $count_date_type = $this->props['count_date_type'];
        $count_to_date = $this->props['count_to_date'];
        $count_to_include_date = $this->props['count_to_include_date'];
        $count_from_date = $this->props['count_from_date'];
        $count_from_include_date = $this->props['count_from_include_date'];
        $halfcircle_label = $this->props['halfcircle_label'];
        //Calculate the numbers to count
        $count_to_value = 0;
        $count_from_value = 0;

        if ('number' == $count_to_type) {
            $count_to_value = $count_to_number;
            $count_from_value = $count_from_number;
        } else if ('date' == $count_to_type) {

            $count_to_date = '' !== $count_to_date ? strtotime($count_to_date) : current_time('timestamp');
            $count_from_date = '' !== $count_from_date ? strtotime($count_from_date) : current_time('timestamp');

            if ('on' === $count_to_include_date) {
                switch ($count_date_type) {
                    case 'seconds':
                        $count_to_date += 1;
                        break;
                    case 'minutes':
                        $count_to_date += 60;
                        break;
                    case 'hours':
                        $count_to_date += 60 * 60;
                        break;
                    case 'weeks':
                        $count_to_date += 60 * 60 * 24 * 7;
                        break;
                    case 'month':
                        $count_to_date += 60 * 60 * 24 * (365 / 12);
                        break;
                    case 'years':
                        $count_to_date += 60 * 60 * 24 * 365;
                        break;
                    default: //Default is days
                        $count_to_date += 60 * 60 * 24;
                }
            }

            if ('on' === $count_from_include_date) {
                switch ($count_date_type) {
                    case 'seconds':
                        $count_from_date += 1;
                        break;
                    case 'minutes':
                        $count_from_date += 60;
                        break;
                    case 'hours':
                        $count_from_date += 60 * 60;
                        break;
                    case 'weeks':
                        $count_from_date += 60 * 60 * 24 * 7;
                        break;
                    case 'month':
                        $count_from_date += 60 * 60 * 24 * (365 / 12);
                        break;
                    case 'years':
                        $count_from_date += 60 * 60 * 24 * 365;
                        break;
                    default: //Default is days
                        $count_from_date += 60 * 60 * 24;
                }
            }

            $difference_in_seconds = $count_to_date - $count_from_date;

            switch ($count_date_type) {
                case 'seconds':
                    $count_to_value = sprintf('%1$s', floor($difference_in_seconds));
                    break;
                case 'minutes':
                    $count_to_value = sprintf('%1$s', floor($difference_in_seconds / 60));
                    break;
                case 'hours':
                    $count_to_value = sprintf('%1$s', floor($difference_in_seconds / (60 * 60)));
                    break;
                case 'weeks':
                    $count_to_value = sprintf('%1$s', floor($difference_in_seconds / (60 * 60 * 24 * 7)));
                    break;
                case 'month':
                    $count_to_value = sprintf('%1$s', floor($difference_in_seconds / (60 * 60 * 24 * (365 / 12))));
                    break;
                case 'years':
                    $count_to_value = sprintf('%1$s', floor($difference_in_seconds / (60 * 60 * 24 * 365)));
                    break;
                default:
                    $count_to_value = sprintf('%1$s', floor($difference_in_seconds / (60 * 60 * 24)));
            }
        } else if ('post' == $count_to_type) {
            $count_to_value = DIPI_Counter::count_posts($this->props);
        }

        if ('' === $count_from_value) {
            $count_from_value = 0;
        }
        $start_label = "";
        $end_label = "";
        if ($halfcircle_label === 'presuffix') {
            $start_label = sprintf('<span class="dipi_label dipi_start_label">%1$s</span>',
                $prefix
            );
            $end_label = sprintf('<span class="dipi_label dipi_end_label">%1$s</span>',
                $suffix
            );
        } else if ($halfcircle_label === 'fromto') {
            $start_label = sprintf('<span class="dipi_label dipi_start_label">%1$s</span>',
                $count_from_value
            );
            $end_label = sprintf('<span class="dipi_label dipi_end_label">%1$s</span>',
                $count_to_value
            );
        }
        
        
        return sprintf(
            '<div id="%6$s_wrapper" data-id="%6$s_wrapper" class="dipi_counter_number_wrapper %5$s" %1$s>
                %7$s
                <div class="dipi_counter_number">
                    <span class="dipi_counter_number_prefix">%2$s</span><span class="dipi_counter_number_number">%3$s</span><span class="dipi_counter_number_suffix">%4$s</span>
                </div>
                %8$s
            </div>',
            $this->get_easy_pie_chart_data($count_to_value, $count_from_value),
            $prefix,
            $count_from_value,
            $suffix,
            $counter_type, #5
            $order_class,
            $start_label,
            $end_label
        );
    }

    private function get_easy_pie_chart_data($count_to_value, $count_from_value)
    {

        $easy_pie_chart_data = array();
        $easy_pie_chart_data[] = "data-count-to='{$count_to_value}'";
        $easy_pie_chart_data[] = "data-count-from='{$count_from_value}'";

        $count_duration = $this->props['count_duration'];
        $easy_pie_chart_data[] = "data-count-duration='{$count_duration}'";

        $count_animation_delay = $this->props['count_animation_delay'];
        $easy_pie_chart_data[] = "data-count-animation-delay='{$count_animation_delay}'";

        $force_decimal_places = 'on' === $this->props['counter_force_decimals'];
        $easy_pie_chart_data[] = "data-force-decimal-places='{$force_decimal_places}'";
        $count_number_decimals = $this->props['count_number_decimals'];
        $easy_pie_chart_data[] = "data-decimal-places='{$count_number_decimals}'";

        $counter_type = $this->props['counter_type'];
        $easy_pie_chart_data[] = "data-counter-type='{$counter_type}'";

        $count_circle_percent = $this->_esc_attr('count_circle_percent');
        $easy_pie_chart_data[] = "data-circle-percent='{$count_circle_percent}'";

        $circle_bar_color = $this->props['circle_bar_color'];
        $circle_bar_color = isset($circle_bar_color) && '' !== $circle_bar_color ? $circle_bar_color : et_builder_accent_color();
        $easy_pie_chart_data[] = "data-circle-bar-color='{$circle_bar_color}'";

        $circle_track_color = $this->props['circle_track_color'];
        $circle_track_color = isset($circle_track_color) && '' !== $circle_track_color ? $circle_track_color : 'rgba(0,0,0,0.1)';
        $easy_pie_chart_data[] = "data-circle-track-color='{$circle_track_color}'";

        $circle_line_width = $this->props['circle_line_width'];
        $easy_pie_chart_data[] = "data-circle-line-width='{$circle_line_width}'";

        $circle_line_cap = $this->props['circle_line_cap'];
        $easy_pie_chart_data[] = "data-circle-line-cap='{$circle_line_cap}'";

        $circle_size = $this->props['circle_size'];
        if (isset($circle_size) && '' !== $circle_size) {
            $easy_pie_chart_data[] = "data-circle-size='{$circle_size}'";
        }

        $circle_use_scale = $this->props['circle_use_scale'];
        if (isset($circle_use_scale) && 'on' === $circle_use_scale) {

            $circle_scale_length = $this->props['circle_scale_length'];
            $circle_scale_color = $this->props['circle_scale_color'];
            $circle_scale_color = isset($circle_scale_color) && '' !== $circle_scale_color ? $circle_scale_color : 'rgba(0,0,0,0.1)';
            $easy_pie_chart_data[] = "data-circle-use-scale='true'";
            $easy_pie_chart_data[] = "data-circle-scale-color='{$circle_scale_color}'";
            $easy_pie_chart_data[] = "data-circle-scale-length='{$circle_scale_length}'";
        }

        $circle_rotate = $this->props['circle_rotate'];
        $easy_pie_chart_data[] = "data-circle-rotate='{$circle_rotate}'";

        $count_number_thousands_separator = $this->props['count_number_thousands_separator'];
        $easy_pie_chart_data[] = "data-number-separator='{$count_number_thousands_separator}'";

        $count_number_decimal_separator = '' !== $this->props['count_number_decimal_separator'] ? $this->props['count_number_decimal_separator'] : localeconv()['decimal_point'];
        $easy_pie_chart_data[] = "data-number-decimal-separator='{$count_number_decimal_separator}'";

        return implode(' ', $easy_pie_chart_data);
    }

    private function get_count_posts_settings_fields()
    {
        $fields = [];

        $fields['test'] = [
            'label'           => esc_html__( 'test', 'boxx-boxxroom' ),
            'type'            => 'hidden',
            'option_category' => 'basic_option',
            'toggle_slug' => 'counter',
            'default' => 'test',
            'computed_affects' => array(
                '__post_count',
            ),
        ];

        $post_types = DIPI_Counter::get_post_types_to_count();
        foreach ($post_types as $post_type => $post_type_name) {
            $fields["count_{$post_type}"] = [
                'label' => sprintf(esc_html__('Count %1$s', 'dipi-divi-pixel'),  $post_type_name),
                'description' => sprintf(esc_html__('Whether or not to count %1$s.', 'dipi-divi-pixel'), $post_type_name),
                'type' => 'yes_no_button',
                'option_category' => 'basic_option',
                'toggle_slug' => 'count_post',
                'default' => 'off',
                'options' => array(
                    'off' => esc_html__('Off', 'dipi-divi-pixel'),
                    'on' => esc_html__('On', 'dipi-divi-pixel'),
                ),
                'show_if' => [
                    'count_to_type' => 'post',
                ],
                'computed_affects' => array(
                    '__post_count',
                ),
            ];

            $taxonomy_objects = get_object_taxonomies($post_type, 'objects');
            if(isset($taxonomy_objects) && count($taxonomy_objects) > 0){
                foreach($taxonomy_objects as $taxonomy) {
                    if(!$taxonomy->show_ui || !$taxonomy->show_in_menu || !$taxonomy->public){
                        continue;
                    }

                    $fields["count_{$post_type}_{$taxonomy->name}_without_terms"] = [
                        'label' => sprintf(
                            esc_html__('Count %1$s without %2$s', 'dipi-divi-pixel'), 
                            $post_type_name,
                            $taxonomy->label
                        ),
                        'description' => sprintf(
                            esc_html__('Whether or not to count %1$s which have no %2$s assigned.', 'dipi-divi-pixel'),
                            $post_type_name,
                            $taxonomy->label
                        ),
                        'type' => 'yes_no_button',
                        'option_category' => 'basic_option',
                        'toggle_slug' => 'count_post',
                        'default' => 'on',
                        'options' => array(
                            'off' => esc_html__('Off', 'dipi-divi-pixel'),
                            'on' => esc_html__('On', 'dipi-divi-pixel'),
                        ),
                        'show_if' => [
                            'count_to_type' => 'post',
                            "count_{$post_type}" => 'on',
                        ],
                        'computed_affects' => array(
                            '__post_count',
                        ),
                    ];
                    
                    $fields["count_{$post_type}_{$taxonomy->name}_all_terms"] = [
                        'label' => sprintf(
                            esc_html__('Count all %1$s', 'dipi-divi-pixel'), 
                            $taxonomy->label
                        ),
                        'description' => sprintf(
                            esc_html__('Whether or not to count all %1$s which have %2$s assigned.', 'dipi-divi-pixel'),
                            $post_type_name,
                            $taxonomy->label
                        ),
                        'type' => 'yes_no_button',
                        'option_category' => 'basic_option',
                        'toggle_slug' => 'count_post',
                        'default' => 'on',
                        'options' => array(
                            'off' => esc_html__('Off', 'dipi-divi-pixel'),
                            'on' => esc_html__('On', 'dipi-divi-pixel'),
                        ),
                        'show_if' => [
                            'count_to_type' => 'post',
                            "count_{$post_type}" => 'on',
                        ],
                        'computed_affects' => array(
                            '__post_count',
                        ),
                    ];
    
                    $fields["{$post_type}_{$taxonomy->name}"] = [
                        'label' => sprintf(esc_html__('Included %1$s', 'dipi-divi-pixel'), $taxonomy->label),
                        'type' => 'categories',
                        'option_category' => 'basic_option',
                        'toggle_slug' => 'count_post',
                        'description' => sprintf(
                            esc_html__('Choose which %1$s you would like to include.', 'dipi-divi-pixel'),
                            $taxonomy->label
                        ),
                        'renderer_options' => array(
                            'use_terms' => true,
                            'term_name' => $taxonomy->name,
                        ),
                        'show_if' => [
                            'count_to_type' => 'post',
                            "count_{$post_type}" => 'on',
                            "count_{$post_type}_{$taxonomy->name}_all_terms" => 'off',
                        ],
                        'computed_affects' => array(
                            '__post_count',
                        ),
                    ];
                }
            }
        }

        return $fields;
    }

    static function count_posts($args = array(), $conditional_tags = array(), $current_page = array())
    {
        $count = 0;
        foreach (DIPI_Counter::get_post_types_to_count() as $post_type => $post_type_name) {
            //Check if we should count this post type
            if($args["count_{$post_type}"] !== 'on'){
                continue;
            }
          
            //Get all taxonomies for this post type
            $taxnomoy_objects = get_object_taxonomies($post_type, 'objects');

            //If we have taxonomies, we need to count based on them. If there are no taxonomies 
            //on this post type, we simply count all posts of this post type
            if($taxnomoy_objects && count($taxnomoy_objects) > 0) {

                //Build a WP_Query with Tax Query to count based on the selected terms
                $query_args = array(
                    'post_type'     => $post_type, 
                    'post_status'   => 'publish', //TODO: Maybe configurable?
                    'posts_per_page' => -1,
                    'tax_query' => array(
                      'relation' => 'OR',
                    )
                );

                foreach($taxnomoy_objects as $taxonomy) {
                    
                    //Skip taxonomies for which we don't show settings
                    if(!$taxonomy->show_ui || !$taxonomy->show_in_menu || !$taxonomy->public){
                        continue;
                    }

                    if($args["count_{$post_type}_{$taxonomy->name}_all_terms"] === 'on'){
                        $query_args['tax_query'][] = [
                            'taxonomy' => $taxonomy->name,
                            'operator' => 'EXISTS'
                        ];
                    } else {
                        $selected_terms = $args["{$post_type}_{$taxonomy->name}"];
                        if(isset($selected_terms) && '' !== $selected_terms){
                            $term_ids = explode(',', $selected_terms);
                        } else {
                            $term_ids = [];
                        }
                        
                        $query_args['tax_query'][] = [
                            'taxonomy' => $taxonomy->name,
                            'field' => 'id',
                            'terms' => $term_ids
                        ];
                    }

                    if($args["count_{$post_type}_{$taxonomy->name}_without_terms"] === 'on'){
                        $query_args['tax_query'][] = [
                            'taxonomy' => $taxonomy->name,
                            'operator' => 'NOT EXISTS'
                        ];
                    }
                }

                $query = new WP_Query($query_args);
                $count += $query->post_count;
            } else {
                $count += wp_count_posts($post_type)->publish;
            }
        }

        return $count;
    }

    static function get_post_types_to_count()
    {
        global $wp_post_types;
        $post_types = array(
            'post' => $wp_post_types['post']->labels->name,
            'page' => $wp_post_types['page']->labels->name,
        );

        foreach (get_post_types(array('public' => true, '_builtin' => false), 'objects', 'and') as $post_type) {
            $post_types[$post_type->name] = $post_type->labels->name;
        }

        return $post_types;
    }
}

new DIPI_Counter();
