<?php

class DIPI_Countdown extends DIPI_Builder_Module
{

    public $slug = 'dipi_countdown';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->name = esc_html__('Pixel Countdown', 'dipi-divi-pixel');
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
    }

    // public function get_settings_modal_tabs();
    public function get_settings_modal_toggles()
    {
        $toggles = [];

        $toggles['general'] = [
            'toggles' => [
                'date' => esc_html__('Date', 'dipi-divi-pixel'),
                'style' => esc_html__('Style', 'dipi-divi-pixel'),
                'text' => esc_html__('Text', 'dipi-divi-pixel'),
                'events' => esc_html__('Events', 'dipi-divi-pixel'),
            ],
        ];

        $toggles['advanced'] = [
            'toggles' => [
                'clock_text' => [
                    'title' => esc_html__('Clock Text', 'dipi-divi-pixel'),
                    'tabbed_subtoggles' => true,
                    'sub_toggles' => [
                        'clock' => ['name' => esc_html__('Clock', 'dipi-divi-pixel')],
                        'labels' => ['name' => esc_html__('Labels', 'dipi-divi-pixel')],
                    ],
                ],
                'clock_face' => esc_html__('Clock', 'dipi-divi-pixel'),
            ],
        ];

        return $toggles;
    }

    public function get_custom_css_fields_config()
    {
        $fields = [];

        // Flip Clock Faces
        $fields['dipi_countdown_flip_clock_count'] = [
            'label' => 'Flip Clock Count',
            'selector' => '%%order_class%% .flip_clock .count',
        ];
        $fields['dipi_countdown_flip_clock_curr_top'] = [
            'label' => 'Flip Clock Current Top',
            'selector' => '%%order_class%% .flip_clock .count.curr.top',
        ];
        $fields['dipi_countdown_flip_clock_next_top'] = [
            'label' => 'Flip Clock Next Top',
            'selector' => '%%order_class%% .flip_clock .count.next.top',
        ];
        $fields['dipi_countdown_flip_clock_curr_bot'] = [
            'label' => 'Flip Clock Current Bottom',
            'selector' => '%%order_class%% .flip_clock .count.curr.bottom',
        ];
        $fields['dipi_countdown_flip_clock_next_bot'] = [
            'label' => 'Flip Clock Next Bottom',
            'selector' => '%%order_class%% .flip_clock .count.next.bottom',
        ];

        // Labels
        $fields['dipi_countdown_flip_clock_label'] = [
            'label' => 'Flip/Block Clock Label',
            'selector' => '%%order_class%% .flip_clock .label, %%order_class%% .block_clock .label',
        ];

        // Clock Time
        $fields['dipi_countdown_flip_clock_time'] = [
            'label' => 'Flip/Block Clock Time',
            'selector' => '%%order_class%% .flip_clock .time,%%order_class%% .block_clock .time',
        ];
        $fields['dipi_countdown_flip_clock_weeks'] = [
            'label' => 'Flip/Block Clock Weeks',
            'selector' => '%%order_class%% .flip_clock .time.weeks, %%order_class%% .block_clock .time.weeks',
        ];
        $fields['dipi_countdown_flip_clock_days'] = [
            'label' => 'Flip/Block Clock Days',
            'selector' => '%%order_class%% .flip_clock .time.days, %%order_class%% .block_clock .time.days',
        ];
        $fields['dipi_countdown_flip_clock_hours'] = [
            'label' => 'Flip/Block Clock Hours',
            'selector' => '%%order_class%% .flip_clock .time.hours, %%order_class%% .block_clock .time.hours',
        ];
        $fields['dipi_countdown_flip_clock_mins'] = [
            'label' => 'Flip/Block Clock Minutes',
            'selector' => '%%order_class%% .flip_clock .time.minutes, %%order_class%% .block_clock .time.minutes',
        ];
        $fields['dipi_countdown_flip_clock_secs'] = [
            'label' => 'Flip/Block Clock Seconds',
            'selector' => '%%order_class%% .flip_clock .time.seconds, %%order_class%% .block_clock .time.seconds',
        ];

        // Clock Faces
        $fields['dipi_countdown_flip_clock_weeks'] = [
            'label' => 'Flip/Block Clock Face Weeks',
            'selector' => '%%order_class%% .flip_clock .face_weeks .count, %%order_class%% .block_clock .face_weeks',
        ];
        $fields['dipi_countdown_flip_clock_days'] = [
            'label' => 'Flip/Block Clock Face Days',
            'selector' => '%%order_class%% .flip_clock .face_days .count, %%order_class%% .block_clock .face_days',
        ];
        $fields['dipi_countdown_flip_clock_hours'] = [
            'label' => 'Flip/Block Clock Face Hours',
            'selector' => '%%order_class%% .flip_clock .face_hours .count, %%order_class%% .block_clock .face_hours',
        ];
        $fields['dipi_countdown_flip_clock_mins'] = [
            'label' => 'Flip/Block Clock Face Minutes',
            'selector' => '%%order_class%% .flip_clock .face_minutes .count, %%order_class%% .block_clock .face_minutes',
        ];
        $fields['dipi_countdown_flip_clock_secs'] = [
            'label' => 'Flip/Block Clock Face Seconds',
            'selector' => '%%order_class%% .flip_clock .face_seconds .count, %%order_class%% .block_clock .face_seconds',
        ];

        return $fields;
    }

    public function get_fields()
    {
        $fields = [];

        $fields['no_date_configured'] = [
            'type' => 'hidden',
            'option_category' => 'basic_option',
            'toggle_slug' => 'date',
            'tab_slug' => 'general',
            'default' => esc_html__('No Date Configured', 'dipi-divi-pixel'),
            'default_on_front' => esc_html__('No Date Configured', 'dipi-divi-pixel'),
        ];

        $fields['date_type'] = [
            'label' => esc_html__('Type of Date', 'dipi-divi-pixel'),
            'description' => esc_html__('Choose how you want to select the date. With the date picker, you can simply select a date. With manual selection, you can either enter a datetime as text or pull the data from a custom post field.', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'toggle_slug' => 'date',
            'tab_slug' => 'general',
            'default' => 'picker',
            'options' => [
                'picker' => esc_html__('Date Picker', 'dipi-divi-pixel'),
                'text' => esc_html__('Text', 'dipi-divi-pixel'),
                'current_time' => esc_html__('Current Time + Offset', 'dipi-divi-pixel'),
            ],
        ];

        $fields['date_time_picker'] = [
            'label' => esc_html__('Date/Time', 'dipi-divi-pixel'),
            'type' => 'date_picker',
            'option_category' => 'basic_option',
            'toggle_slug' => 'date',
            'tab_slug' => 'general',
            'show_if' => ['date_type' => 'picker'],
        ];

        $fields['date_time_text'] = [
            'label' => esc_html__('Date/Time', 'dipi-divi-pixel'),
            'description' => esc_html__('Provide the date in the format "yyyy-MM-dd HH:mm:ss". You can either enter it directly or use the dynamic content feature to pull it from a custom post field.', 'dipi-divi-pixel'),
            'type' => 'text',
            'dynamic_content' => 'text',
            'option_category' => 'basic_option',
            'toggle_slug' => 'date',
            'tab_slug' => 'general',
            'show_if' => ['date_type' => 'text'],
        ];

        $fields['date_time_offset'] = [
            'label' => esc_html__('Time Offset', 'dipi-divi-pixel'),
            'description' => esc_html__('Provide the offset of the current time in seconds, e. g. 600 for 10 minutes.', 'dipi-divi-pixel'),
            'type' => 'text',
            'dynamic_content' => 'text',
            'option_category' => 'basic_option',
            'toggle_slug' => 'date',
            'tab_slug' => 'general',
            'show_if' => ['date_type' => 'current_time'],
        ];

        $fields['use_cookie'] = [
            'label' => esc_html__('Store Date as Cookie', 'dipi-divi-pixel'),
            'description' => esc_html__('When activated, the date when the user visits the page for the first time will be stored as a cookie so that refreshing the page won\'t restart the timer.', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'toggle_slug' => 'date',
            'tab_slug' => 'general',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'show_if' => ['date_type' => 'current_time'],
        ];

        $fields['cookie_id'] = [
            'label' => esc_html__('Cookie ID', 'dipi-divi-pixel'),
            'description' => esc_html__('Provide an ID to be used for the cookie. If you use multiple Sensei Countdown modules on your website, modules with the same ID will share the same cookie. In some situations this might be wanted but in most cases you should provide a unique ID per module.', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => 'dipi_countdown',
            'option_category' => 'basic_option',
            'toggle_slug' => 'date',
            'tab_slug' => 'general',
            'show_if' => [
                'date_type' => 'current_time',
                'use_cookie' => 'on',
            ],
        ];

        $fields['finish_countdown'] = [
            'label' => esc_html__('On Countdown Finish', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'toggle_slug' => 'events',
            'tab_slug' => 'general',
            'default' => 'continue',
            'options' => [
                'continue' => esc_html__('Continue', 'dipi-divi-pixel'),
                'stop' => esc_html__('Stop Clock', 'dipi-divi-pixel'),
                'forward' => esc_html__('Forward to URL', 'dipi-divi-pixel'),
                'script' => esc_html__('Stop and execute JavaScript', 'dipi-divi-pixel'),
                'html' => esc_html__('Stop and replace with HTML', 'dipi-divi-pixel'),
            ],
        ];

        $fields['forwarding_url'] = [
            'label' => esc_html__('URL', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'toggle_slug' => 'events',
            'tab_slug' => 'general',
            'show_if' => ['finish_countdown' => 'forward'],
        ];

        $fields['script'] = [
            'label' => esc_html__('Script', 'dipi-divi-pixel'),
            'type' => 'textarea',
            'option_category' => 'basic_option',
            'toggle_slug' => 'events',
            'tab_slug' => 'general',
            'show_if' => ['finish_countdown' => 'script'],
        ];

        $fields['html'] = [
            'label' => esc_html__('HTML', 'dipi-divi-pixel'),
            'type' => 'textarea',
            'option_category' => 'basic_option',
            'toggle_slug' => 'events',
            'tab_slug' => 'general',
            'show_if' => ['finish_countdown' => 'html'],
        ];

        $fields['style'] = [
            'label' => esc_html__('Style', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'layout',
            'toggle_slug' => 'style',
            'tab_slug' => 'general',
            'default' => 'flip_clock',
            'options' => [
                'flip_clock' => esc_html__('Flip Clock', 'dipi-divi-pixel'),
                'block_clock' => esc_html__('Block Clock', 'dipi-divi-pixel'),
                'custom_format' => esc_html__('Custom Format', 'dipi-divi-pixel'),
            ],
        ];

        $default_custom_format = sprintf(
            '%%w %%!w:%1$s,%2$s; %%d %%!d:%3$s,%4$s; %%H %%!H:%5$s,%6$s; %%M %%!M:%7$s,%8$s; %%S %%!S:%9$s,%10$s;',
            esc_html__('Week', 'dipi-divi-pixel'),
            esc_html__('Weeks', 'dipi-divi-pixel'),
            esc_html__('Day', 'dipi-divi-pixel'),
            esc_html__('Days', 'dipi-divi-pixel'),
            esc_html__('Hour', 'dipi-divi-pixel'),
            esc_html__('Hours', 'dipi-divi-pixel'),
            esc_html__('Minute', 'dipi-divi-pixel'),
            esc_html__('Minutes', 'dipi-divi-pixel'),
            esc_html__('Second', 'dipi-divi-pixel'),
            esc_html__('Seconds', 'dipi-divi-pixel')
        );

        $fields['custom_format'] = [
            'label' => esc_html__('Custom Format', 'dipi-divi-pixel'),
            'description' => sprintf(
                'A detailed description of how to use the format can be found %1$s. You can also use HTML inside the format.',
                sprintf('<a href="http://hilios.github.io/jQuery.countdown/documentation.html#formatter">%1$s</a>', esc_html__('here', 'dipi-divi-pixel'))
            ),
            'type' => 'textarea',
            'option_category' => 'basic_option',
            'toggle_slug' => 'style',
            'tab_slug' => 'general',
            'show_if' => ['style' => 'custom_format'],
            'default' => $default_custom_format,
        ];

        $fields['label_weeks'] = [
            'label' => esc_html__('Label Weeks', 'dipi-divi-pixel'),
            'description' => esc_html__('Enter a label to be used for weeks. You can use pluralization by comma separating the singular and the plural, e. g. "Week,Weeks"', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_text',
            'sub_toggle' => 'labels',
            'default' => esc_html__('Week,Weeks', 'dipi-divi-pixel'),
        ];

        $fields['label_days'] = [
            'label' => esc_html__('Label Days', 'dipi-divi-pixel'),
            'description' => esc_html__('Enter a label to be used for days. You can use pluralization by comma separating the singular and the plural, e. g. "Day,Days"', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_text',
            'sub_toggle' => 'labels',
            'default' => esc_html__('Day,Days', 'dipi-divi-pixel'),
        ];

        $fields['label_hours'] = [
            'label' => esc_html__('Label Hours', 'dipi-divi-pixel'),
            'description' => esc_html__('Enter a label to be used for hours. You can use pluralization by comma separating the singular and the plural, e. g. "Hour,Hours"', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_text',
            'sub_toggle' => 'labels',
            'default' => esc_html__('Hour,Hours', 'dipi-divi-pixel'),
        ];

        $fields['label_minutes'] = [
            'label' => esc_html__('Label Minutes', 'dipi-divi-pixel'),
            'description' => esc_html__('Enter a label to be used for minutes. You can use pluralization by comma separating the singular and the plural, e. g. "Minute,Minutes"', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_text',
            'sub_toggle' => 'labels',
            'default' => esc_html__('Min,Mins', 'dipi-divi-pixel'),
        ];

        $fields['label_seconds'] = [
            'label' => esc_html__('Label Seconds', 'dipi-divi-pixel'),
            'description' => esc_html__('Enter a label to be used for seconds. You can use pluralization by comma separating the singular and the plural, e. g. "Second,Seconds"', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_text',
            'sub_toggle' => 'labels',
            'default' => esc_html__('Sec,Secs', 'dipi-divi-pixel'),
        ];

        $fields['clock_label_position'] = [
            'label' => esc_html__('Labels Position', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_face',
            'default' => 'below',
            'options' => [
                'above' => esc_html__('Above', 'dipi-divi-pixel'),
                'below' => esc_html__('Below', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'style' => ['flip_clock', 'block_clock'],
            ],
        ];

        $fields['show_weeks'] = [
            'label' => esc_html__('Show Weeks', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_face',
            'default' => 'on',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'show_if' => [
                'style' => ['flip_clock', 'block_clock'],
            ],
        ];

        $fields['show_days'] = [
            'label' => esc_html__('Show Days', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_face',
            'default' => 'on',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'show_if' => [
                'style' => ['flip_clock', 'block_clock'],
                'show_weeks' => 'off',
            ],
        ];

        $fields['show_hours'] = [
            'label' => esc_html__('Show Hours', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_face',
            'default' => 'on',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'show_if' => [
                'style' => ['flip_clock', 'block_clock'],
                'show_weeks' => 'off',
                'show_days' => 'off',
            ],
        ];

        $fields['show_minutes'] = [
            'label' => esc_html__('Show Minutes', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_face',
            'default' => 'on',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'show_if' => [
                'style' => ['flip_clock', 'block_clock'],
                'show_weeks' => 'off',
                'show_days' => 'off',
                'show_hours' => 'off',
            ],
        ];

        $fields['show_seconds'] = [
            'label' => esc_html__('Show Seconds', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_face',
            'default' => 'on',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'show_if' => [
                'style' => ['flip_clock', 'block_clock'],
                'show_minutes' => 'on',
            ],
        ];

        $fields['clock_background'] = [
            'label' => esc_html__('Face Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_face',
            'default' => '#202020',
            'show_if' => [
                'style' => ['flip_clock', 'block_clock'],
            ],
        ];

        $fields['flip_clock_top_border'] = [
            'label' => esc_html__('Top Face Top Border Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_face',
            'default' => 'rgba(255, 255, 255, 0.2)',
            'show_if' => [
                'style' => ['flip_clock'],
            ],
        ];

        $fields['flip_clock_separator_top_border'] = [
            'label' => esc_html__('Top Face Bottom Border Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_face',
            'default' => 'rgba(255, 255, 255, 0.1)',
            'show_if' => [
                'style' => ['flip_clock'],
            ],
        ];

        $fields['flip_clock_separator_bottom_border'] = [
            'label' => esc_html__('Bottom Face Top Border Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_face',
            'default' => '#000000',
            'show_if' => [
                'style' => ['flip_clock'],
            ],
        ];

        $fields['flip_clock_bottom_border'] = [
            'label' => esc_html__('Bottom Face Bottom Border Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_face',
            'default' => '#000000',
            'show_if' => [
                'style' => ['flip_clock'],
            ],
        ];

        $fields['clock_face_width'] = [
            'label' => esc_html__('Face Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_face',
            'mobile_options' => true,
            'default' => '',
            'validate_unit' => true,
            'default_unit' => 'px',
            'range_settings' => array(
                'min' => '0',
                'max' => '200',
                'step' => '1',
            ),
            'show_if' => [
                'style' => ['flip_clock'],
            ],
        ];

        $fields['clock_face_height'] = [
            'label' => esc_html__('Face Height', 'dipi-divi-pixel'),
            'type' => 'range',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_face',
            'mobile_options' => true,
            'default' => '',
            'validate_unit' => true,
            'default_unit' => 'px',
            'range_settings' => array(
                'min' => '0',
                'max' => '200',
                'step' => '1',
            ),
            'show_if' => [
                'style' => ['flip_clock'],
            ],
        ];

        $fields['clock_face_margin'] = [
            'label' => esc_html__('Face Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_face',
            'mobile_options' => true,
            'show_if' => [
                'style' => ['flip_clock', 'block_clock'],
            ],
        ];

        $fields['clock_face_padding'] = [
            'label' => esc_html__('Face Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_face',
            'mobile_options' => true,
            'show_if' => [
                'style' => ['block_clock'],
            ],
        ];

        $fields['block_clock_equalize_width'] = [
            'label' => esc_html__('Equalized Face Width', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_face',
            'default' => 'on',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'show_if' => [
                'style' => ['block_clock'],
            ],
        ];

        $fields['block_clock_face_alignment'] = [
            'label' => esc_html__('Block Alignment', 'dipi-divi-pixel'),
            'description' => esc_html__('Choose how you want to align the face blocks in their wrapper.', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'clock_face',
            'default' => 'center',
            'options' => [
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'flex-start' => esc_html__('Start', 'dipi-divi-pixel'),
                'flex-end' => esc_html__('End', 'dipi-divi-pixel'),
                'space-between' => esc_html__('Space Between', 'dipi-divi-pixel'),
                'space-around' => esc_html__('Space Around', 'dipi-divi-pixel'),
                'space-evenly' => esc_html__('Space Evenly', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'style' => ['block_clock'],
            ],
        ];

        return $fields;
    }

    public function get_advanced_fields_config()
    {
        $fields = [];

        //Disable Text settings because we add our own
        $fields["text"] = false;
        $fields["text_shadow"] = false;

        $fields['fonts']['clock'] = [
            'label' => esc_html__('Clock Face', 'dipi-divi-pixel'),
            'toggle_slug' => 'clock_text',
            'sub_toggle' => 'clock',
            'css' => [
                'main' => '%%order_class%% .flip_clock div.time span.count, %%order_class%% .block_clock div.time',
            ],
        ];

        $fields['fonts']['labels'] = [
            'label' => esc_html__('Labels', 'dipi-divi-pixel'),
            'toggle_slug' => 'clock_text',
            'sub_toggle' => 'labels',
            'css' => [
                'main' => '%%order_class%% .flip_clock div.label, %%order_class%% .block_clock div.label',
            ],
        ];

        return $fields;
    }

    public function apply_css($render_slug)
    {

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .flip_clock div.time span.count, %%order_class%% .block_clock div.face',
            'declaration' => "background: {$this->props['clock_background']};",
        ]);

        if ('flip_clock' === $this->props["style"]) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .flip_clock div.time span.count.top',
                'declaration' => "border-top-color: {$this->props['flip_clock_top_border']};",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .flip_clock div.time span.count.top',
                'declaration' => "border-bottom-color: {$this->props['flip_clock_separator_top_border']};",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .flip_clock div.time span.count.bottom',
                'declaration' => "border-top-color: {$this->props['flip_clock_separator_bottom_border']};",
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .flip_clock div.time span.count.bottom',
                'declaration' => "border-bottom-color: {$this->props['flip_clock_bottom_border']};",
            ]);

            $this->dipi_set_responsive_style($render_slug, $this->props, "clock_face_width", "%%order_class%% .flip_clock .face .time", "width");
            $this->dipi_set_responsive_style($render_slug, $this->props, "clock_face_height", "%%order_class%% .flip_clock .face .time", "height");
            $this->dipi_set_responsive_style($render_slug, $this->props, "clock_face_margin", "%%order_class%% .flip_clock .face", "margin");
        } else if ('block_clock' === $this->props["style"]) {
            $this->dipi_set_responsive_style($render_slug, $this->props, "clock_face_margin", "%%order_class%% .block_clock .face", "margin");
            $this->dipi_set_responsive_style($render_slug, $this->props, "clock_face_padding", "%%order_class%% .block_clock .face", "padding");

            if ('on' === $this->props['block_clock_equalize_width']) {
                ET_Builder_Element::set_style($render_slug, [
                    'selector' => '%%order_class%% .block_clock .face',
                    'declaration' => "flex: 1;",
                ]);
            } else {
                ET_Builder_Element::set_style($render_slug, [
                    'selector' => '%%order_class%% .block_clock .face_wrapper.face_wrapper',
                    'declaration' => "justify-content: {$this->props['block_clock_face_alignment']};",
                ]);
            }
        }
    }

    private function dateNotConfigured()
    {
        return sprintf('<div>%1$s</div>', $this->props['no_date_configured']);
    }

    private function isValidDate($date)
    {
        return preg_match("/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/", trim($date));
    }

    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_countdown_public');
        $this->apply_css($render_slug);

        $config = [
            "style" => $this->props["style"],
            "finish_countdown" => $this->props["finish_countdown"],
            "label_weeks" => $this->props["label_weeks"],
            "label_days" => $this->props["label_days"],
            "label_hours" => $this->props["label_hours"],
            "label_minutes" => $this->props["label_minutes"],
            "label_seconds" => $this->props["label_seconds"],
        ];

        if ($this->props['date_type'] === 'text') {
            $date_time_text = $this->props['date_time_text'];
            if (!$this->isValidDate($date_time_text)) {
                return $this->dateNotConfigured();
            } else {
                $config["date"] = trim($date_time_text);
            }
        } else if ($this->props['date_type'] === 'picker') {
            if (!$this->props["date_time_picker"] || '' === $this->props["date_time_picker"]) {
                return $this->dateNotConfigured();
            } else {
                $config["date"] = $this->props['date_time_picker'];
            }
        } else if ($this->props['date_type'] === 'current_time') {
            $config["date"] = "now";
            $config["offset"] = isset($this->props['date_time_offset']) && '' !== $this->props['date_time_offset'] ? $this->props['date_time_offset'] : 0;
            if ('on' === $this->props['use_cookie']) {
                $config["use_cookie"] = true;
                $config["cookie_id"] = $this->props['cookie_id'];
            }
        } else {
            return $this->dateNotConfigured();
        }

        if ('custom_format' === $this->props["style"]) {
            $config["custom_format"] = $this->props["custom_format"];
        }

        if ('script' === $this->props["finish_countdown"]) {
            $config["script"] = $this->props["script"];
        }

        if ('html' === $this->props["finish_countdown"]) {
            $config["html"] = $this->props["html"];
        }

        if ('forward' === $this->props["finish_countdown"]) {
            $config["forwarding_url"] = $this->props["forwarding_url"];
        }

        if (in_array($this->props["style"], ['flip_clock', 'block_clock'])) {
            $config["show_weeks"] = 'on' === $this->props["show_weeks"];
            $config["show_days"] = 'on' === $this->props["show_days"];
            $config["show_hours"] = 'on' === $this->props["show_hours"];
            $config["show_minutes"] = 'on' === $this->props["show_minutes"];
            $config["show_seconds"] = 'on' === $this->props["show_seconds"] || 'on' !== $this->props["show_minutes"];
            $config["clock_label_position"] = $this->props["clock_label_position"];
        }

        return sprintf(
            '<div class="clock %1$s" data-config="%2$s"></div>',
            esc_attr($this->props["style"]),
            esc_attr(htmlspecialchars(json_encode($config), ENT_QUOTES, 'UTF-8'))
        );
    }

    private function dipi_set_responsive_style($render_slug, $props, $property, $css_selector, $css_property, $important = false)
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

        ET_Builder_Element::set_style($render_slug, [
            'selector' => $css_selector,
            'declaration' => $declaration_desktop,
        ]);

        if (!empty($props[$property . "_tablet"]) && $responsive_active) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $css_selector,
                'declaration' => $declaration_tablet,
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ]);
        }

        if (!empty($props[$property . "_phone"]) && $responsive_active) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $css_selector,
                'declaration' => $declaration_phone,
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ]);
        }

    }
}

new DIPI_Countdown;
