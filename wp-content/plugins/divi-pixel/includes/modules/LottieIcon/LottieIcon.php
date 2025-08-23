<?php

class DIPI_LottieIcon extends DIPI_Builder_Module
{

    public $slug = 'dipi_lottie_icon';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/lnottie-icon',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__('Pixel Lottie Icon', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%.dipi_lottie_icon';
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
                    'lottie' => esc_html__('Lottie', 'dipi-divi-pixel'),
                    'lottie_text' => [
                        'sub_toggles' => [
                            'title' => [
                                'name' => 'Title',
                            ],
                            'desc' => [
                                'name' => 'Description',
                            ],
                        ],
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__('Text', 'dipi-divi-pixel'),
                    ],
                ],
            ],
        ];
    }

    public function get_custom_css_fields_config()
    {

        $fields = [];



        return $fields;
    }

    public function get_fields()
    {

        $fields = [];

        $fields['json_file'] = [
            'label' => esc_html__('JSON File', 'dipi-divi-pixel'),
            'type' => 'upload',
            'option_category'    => 'basic_option',
            'toggle_slug' => 'content',
            'upload_button_text' => esc_attr__('Upload a JSON', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose a JSON', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As JSON', 'dipi-divi-pixel'),
            'data_type'   => '',
            ];

        $fields['lottie_title'] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'content',
        ];

        $fields['lottie_content'] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'type' => 'tiny_mce',
            'toggle_slug' => 'content',
        ];

        $fields['use_lottie_button'] = [
            'label' => esc_html__('Use Button', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'content',
        ];

        $fields["lottie_button_text"] = [
            'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => esc_html__('Click Here', 'dipi-divi-pixel'),
            'toggle_slug' => 'content',
            'show_if' => [
                'use_lottie_button' => 'on'
            ]
        ];

        $fields["lottie_button_link"] = [
            'label' => esc_html__('Button Link', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => '#',
            'toggle_slug' => 'content',
            'show_if' => [
                'use_lottie_button' => 'on'
            ]
        ];

        $fields["lottie_button_link_target"] = [
            'label' => esc_html__('Button Link Target', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('Same Window', 'dipi-divi-pixel'),
                'on' => esc_html__('New Window', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'content',
            'show_if' => [
                'use_lottie_button' => 'on'
            ]
        ];
        $fields["animate_on_scroll"] = [
            'label'            => esc_html__( 'Animate on Scroll', 'dipi-divi-pixel' ),
            'type'             => 'yes_no_button',
            'default_on_front' => 'off',
            'options'          => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' )
            ],
            'toggle_slug' => 'settings'
        ];
        $fields["visibility_start"] = [
            'label'            => esc_html__( 'Viewport Start', 'dipi-divi-pixel' ),
            'type'             => 'range',
            'default_on_front' => '0%',
            'validate_unit'    => true,
            'default_unit'      => '%',
            'range_settings'   => array(
                'min'  => '0',
                'max'  => '100',
                'step' => '1',
            ),
            'toggle_slug' => 'settings',
            'show_if' => [
                'animate_on_scroll' => 'on'
            ],
        ];
        $fields["visibility_end"] = [
            'label'            => esc_html__( 'Viewport End', 'dipi-divi-pixel' ),
            'type'             => 'range',
            'default_on_front' => '100%',
            'validate_unit'    => true,
            'default_unit'      => '%',
            'range_settings'   => array(
                'min'  => '0',
                'max'  => '100',
                'step' => '1',
            ),
            'toggle_slug' => 'settings',
            'show_if' => [
                'animate_on_scroll' => 'on'
            ],
        ];
        $fields["frame_start"] = [
            'label'            => esc_html__( 'Start Frame', 'dipi-divi-pixel' ),
            'type'             => 'range',
            'default_on_front' => '0',
            'validate_unit'    => false,
            'unitless'         => true,
            'range_settings'   => array(
                'min'  => '0',
                'max'  => '100',
                'step' => '1',
            ),
            'toggle_slug' => 'settings',
            'show_if' => [
                'animate_on_scroll' => 'on'
            ],
        ];
        $fields["frame_end"] = [
            'label'            => esc_html__( 'End Frame', 'dipi-divi-pixel' ),
            'type'             => 'range',
            'default_on_front' => '100',
            'validate_unit'    => false,
            'unitless'         => true,
            'range_settings'   => array(
                'min'  => '0',
                'max'  => '300',
                'step' => '1',
            ),
            'toggle_slug' => 'settings',
            'show_if' => [
                'animate_on_scroll' => 'on'
            ],
        ];
        $fields["loop"] = [
            'label'            => esc_html__( 'Loop', 'dipi-divi-pixel' ),
            'type'             => 'yes_no_button',
            'default_on_front' => 'on',
            'options'          => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' )
            ],
            'toggle_slug' => 'settings',
            'show_if' => [
                'animate_on_scroll' => 'off'
            ]
        ];

        $fields["autoplay"] = [
            'label'            => esc_html__( 'Autoplay', 'dipi-divi-pixel' ),
            'type'             => 'yes_no_button',
            'default_on_front' => 'on',
            'options'          => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' )
            ],
            'toggle_slug' => 'settings',
            'show_if' => [
                'animate_on_scroll' => 'off'
            ]
        ];
        $fields['anim_delay'] = [
			'label'           => esc_html__( 'Delay Before Autoplay', 'dipi-divi-pixel' ),
			'type'            => 'range',
			'toggle_slug'         => 'settings',
			'range_settings'  => [
				'min'  => 0,
				'max'  => 10000,
				'step' => 100,
			],
			'default'             => '0',
			'description'         => esc_html__( 'If you would like to add a delay before your animation runs you can designate that delay here in milliseconds.' ),
			'validate_unit'       => true,
			'fixed_unit'          => 'ms',
			'fixed_range'         => true,
            'show_if' => [
                'autoplay' => 'on',
                'animate_on_scroll' => 'off'
            ],
		];
        $fields['anim_start'] = [
            'label' => esc_html__('Animation Start Function', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'autostart',
            'options' => [
                'autostart' => esc_html__('Auto Start', 'dipi-divi-pixel'),
                'inViewport' => esc_html__('In Viewport', 'dipi-divi-pixel'),
            ],
            'description' => esc_html__('Here you can choose animation start function.', 'dipi-divi-pixel'),
            'toggle_slug' => 'settings',
            'show_if' => [
                'autoplay' => 'on',
                'animate_on_scroll' => 'off'
            ],
        ];
        $fields['anim_start_viewport'] = [
			'label'           => esc_html__( 'View Port', 'dipi-divi-pixel' ),
			'type'            => 'range',
			'toggle_slug'         => 'settings',
			'range_settings'  => [
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			],
			'default'             => '75%',
			'validate_unit'       => true,
			'fixed_unit'          => '%',
			'fixed_range'         => true,
			'reset_animation'     => true,
			'show_if'	=> [
                'autoplay' => 'on',
				'anim_start' => 'inViewport',
                'animate_on_scroll' => 'off'
			]
		];

        $fields["start_frame"] = [
            'label'            => esc_html__( 'Start Frame', 'dipi-divi-pixel' ),
            'type'             => 'range',
            'default_on_front' => '1',
            'validate_unit'    => false,
            'unitless'         => true,
            'range_settings'   => array(
                'min'  => '1',
                'max'  => '100',
                'step' => '1',
            ),
            'toggle_slug' => 'settings',
            'show_if' => [
                'autoplay' => 'off',
                'animate_on_scroll' => 'off'
            ],
        ];

        $fields["play_on_hover"] = [
            'label'            => esc_html__( 'Play on Hover', 'dipi-divi-pixel' ),
            'type'             => 'yes_no_button',
            'default_on_front' => 'on',
            'options'          => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' )
            ],
            'show_if' => [
                'autoplay' => 'off',
                'animate_on_scroll' => 'off'
            ],
            'toggle_slug' => 'settings'
        ];

        $fields["stop_on_hover"] = [
            'label'            => esc_html__( 'Stop on Hover', 'dipi-divi-pixel' ),
            'type'             => 'yes_no_button',
            'default_on_front' => 'on',
            'options'          => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' )
            ],
            'show_if' => [
                'autoplay' => 'on',
                'animate_on_scroll' => 'off'
            ],
            'toggle_slug' => 'settings'
        ];

        $fields["speed"] = [
            'label'            => esc_html__( 'Speed', 'dipi-divi-pixel' ),
            'type'             => 'range',
            'default_on_front' => '1',
            'validate_unit'    => false,
            'unitless'         => true,
            'range_settings'   => array(
                'min'  => '0.1',
                'max'  => '3.5',
                'step' => '0.1',
            ),
            'toggle_slug' => 'settings',
            'show_if' => [
                'animate_on_scroll' => 'off'
            ],
        ];

        $fields["direction"] = [
            'label'            => esc_html__( 'Direction', 'dipi-divi-pixel' ),
            'type'             => 'select',
            'options'          => [
                '1'  => esc_html__( 'Normal', 'dipi-divi-pixel' ),
                '-1' => esc_html__( 'Reverse', 'dipi-divi-pixel' )
            ],
            'default_on_front' => '1',
            'toggle_slug' => 'settings',
            'show_if' => [
                'animate_on_scroll' => 'off'
            ],
        ];

        $fields["box_alignment"] = [
            'label' => esc_html__('Alignment', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'center',
            'options' => [
                'left' => esc_html__('Left', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'right' => esc_html__('Right', 'dipi-divi-pixel')
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'lottie',
        ];

        $fields["lottie_width"] = [
            'label' => esc_html__('Lottie Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'validate_unit' => true,
            'default' => '100%',
            'default_on_front' => '100%',
            'range_settings' => [
                'min' => '0',
                'max' => '100',
                'step' => '1'
            ],
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'lottie',
        ];

        return $fields;
    }

    public function get_advanced_fields_config()
    {

        $advanced_fields = [];

        $advanced_fields['fonts'] = [];
        $advanced_fields['text'] = false;
        $advanced_fields['text_shadow'] = false;

        $advanced_fields['margin_padding'] = [
            'css' => [
                'margin' => '%%order_class%%',
                'padding' => '%%order_class%%',
                'important' => 'all',
            ],
        ];

        $advanced_fields["borders"]["default"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%%",
                    'border_styles' => "%%order_class%%",
                ],
            ],
        ];

        $advanced_fields["box_shadow"]["default"] = [
            'css' => [
                'main' => "%%order_class%%",
            ],
        ];

        $advanced_fields["fonts"]["lottie_title"] = [
            'label' => __('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-lottie-title",
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'lottie_text',
            'sub_toggle' => 'title',
            'header_level' => [
                'default' => 'h2',
            ],
            'line_height' => [
                'range_settings' => [
                    'min' => '1',
                    'max' => '3',
                    'step' => '.1',
                ],
            ],
        ];

        $advanced_fields["fonts"]["lottie_desc"] = [
            'label' => __('Description', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-lottie-desc",
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'lottie_text',
            'sub_toggle' => 'desc',
            'line_height' => [
                'range_settings' => [
                    'min' => '1',
                    'max' => '3',
                    'step' => '.1',
                ],
            ],
        ];

        $advanced_fields['button']["lottie_button"] = [
            'label' => __('Button', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-lottie-button",
                'important' => true,
            ],
            'use_alignment' => false,
            'box_shadow' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-lottie-button",
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-lottie-button",
                    'important' => 'all',
                ],
            ],
        ];

        return $advanced_fields;
    }

    public function render($attrs, $content, $render_slug)
    {
        
        wp_enqueue_script('dipi_lottie_interactivity');
        wp_enqueue_script('dipi_lottie_player');
        wp_enqueue_script('dipi_lottie_icon_public');
        $this->apply_css($render_slug);

        $path = $this->props['json_file'];
        $loop = $this->props['loop'];
        $autoplay = $this->props['autoplay'];
        $anim_delay = $this->props['anim_delay'];
        $anim_start = $this->props['anim_start'];
        $anim_start_viewport = $this->props['anim_start_viewport'];
        $direction = $this->props['direction'];
        $speed = $this->props['speed'];
        $play_on_hover = $this->props['play_on_hover'];
        $stop_on_hover = $this->props['stop_on_hover'];
        $start_frame = $this->props['start_frame'];
        //Animate on scroll
        $animate_on_scroll = $this->props['animate_on_scroll'];
        $visibility_start = $this->props['visibility_start'];
        $visibility_end = $this->props['visibility_end'];
        $frame_start = $this->props['frame_start'];
        $frame_end = $this->props['frame_end'];

        $lottie_title_level = $this->props['lottie_title_level'];
        $lottie_title = '';
        if ('' !== $this->props['lottie_title']) {
            $lottie_title = sprintf(
                '<%2$s class="dipi-lottie-title">%1$s</%2$s>',
                esc_attr($this->props['lottie_title']),
                esc_attr($lottie_title_level)
            );
        }

        $lottie_content = '';
        if ('' !== $this->props['lottie_content']) {
            $lottie_content = sprintf(
                '<div class="dipi-lottie-desc">%1$s</div>',
                $this->process_content($this->props['lottie_content'])
            );
        }

        $lottie_button = '';
        if ('on' === $this->props['use_lottie_button']) {

            $lottie_button_rel = $this->props['lottie_button_rel'];
            $lottie_button_text = $this->props['lottie_button_text'];
            $lottie_button_link = $this->props['lottie_button_link'];
            $lottie_button_icon = $this->props['lottie_button_icon'];
            $lottie_button_target = $this->props['lottie_button_link_target'] == 'on' ? true : false;
            $lottie_button_custom = $this->props['custom_lottie_button'];

            $lottie_button = $this->render_button([
                'button_classname' => [" dipi-lottie-button"],
                'button_custom' => $lottie_button_custom,
                'button_rel' => $lottie_button_rel,
                'button_text' => $lottie_button_text,
                'button_url' => $lottie_button_link,
                'custom_icon' => $lottie_button_icon,
                'has_wrapper' => false,
                'url_new_window' => $lottie_button_target,
            ]);
        }

        $options = [];

        $options['path'] = esc_attr($path);
        $options['loop'] = $loop === 'on' ? true : false;
        $options['autoplay'] = $autoplay === 'on' ? true : false;
        $options['anim_delay'] = $anim_delay;
        $options['anim_start'] = $anim_start;
        $options['anim_start_viewport'] = $anim_start_viewport;
        $options['start_frame'] = $start_frame;

        $options['speed'] = esc_attr($speed);
        $options['direction'] = esc_attr($direction);
        $options['play_on_hover'] = esc_attr($play_on_hover);
        $options['stop_on_hover'] = esc_attr($stop_on_hover);

        $options['animate_on_scroll'] = esc_attr($animate_on_scroll);
        $options['visibility_start'] = esc_attr($visibility_start);
        $options['visibility_end'] = esc_attr($visibility_end);
        $options['frame_start'] = esc_attr($frame_start);
        $options['frame_end'] = esc_attr($frame_end);

        $lottie_icon = '';

        if ($animate_on_scroll == 'on') {
            $lottie_icon = sprintf( 
                '<lottie-player src="%2$s"  class="dipi-lottie-icon" data-options="%1$s"></lottie-player>
                ', 
                esc_attr(wp_json_encode($options)),
                $options['path']
            );
    
        } else {
            $lottie_icon = sprintf( 
                '<div class="dipi-lottie-icon" data-options="%1$s"></div>
                ', 
                esc_attr(wp_json_encode($options))
            );
        }

        $output = '';

        if( $lottie_button != '' || $lottie_content != '' || $lottie_title != '' ) {

            $output = sprintf(
                '<div class="dipi-lottie-wrapper">
                    %1$s
                    <div class="dipi-lottie-content">
                        %2$s
                        %3$s
                        %4$s
                    </div>
                </div>',
                $lottie_icon,
                $lottie_title,
                $lottie_content,
                $lottie_button
            );

        } else {
            $output = sprintf(
                '<div class="dipi-lottie-wrapper">
                    %1$s
                </div>',
                $lottie_icon
            );
        }


        return $output;
    }

    public function apply_css($render_slug)
    {
        $this->dipi_lottie_width_css($render_slug);

        $box_alignment = $this->props['box_alignment'];
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-lottie-wrapper',
            'declaration' => "justify-content: {$box_alignment}; text-align:{$box_alignment};",
        ]);

        if($box_alignment == 'left') {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-lottie-wrapper',
                'declaration' => "align-items: flex-start;",
            ]);
        } else if($box_alignment == 'center') {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-lottie-wrapper',
                'declaration' => "align-items: center;",
            ]);
        } else {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-lottie-wrapper',
                'declaration' => "align-items: flex-end;",
            ]);
            }
    }

    private function dipi_lottie_width_css($render_slug)
    {
        $lottie_width = $this->dipi_get_responsive_prop('lottie_width');

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-lottie-icon",
            'declaration' => sprintf('width: %1$s !important;', $lottie_width['desktop']),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-lottie-icon",
            'declaration' => sprintf('width: %1$s !important;', $lottie_width['tablet']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-lottie-icon",
            'declaration' => sprintf('width: %1$s !important;', $lottie_width['phone']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767')
        ));

    }

}

new DIPI_LottieIcon;
