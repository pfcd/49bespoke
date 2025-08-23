<?php
class DIPI_TypingText extends DIPI_Builder_Module
{

    public $slug = 'dipi_typing_text';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/typing-text',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com'
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->vb_support = 'on';
        $this->name = esc_html__('Pixel Typing Text', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%.dipi_typing_text';

        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'text' => esc_html__('Text', 'dipi-divi-pixel'),
                    'settings' => esc_html__('Typing Settings', 'dipi-divi-pixel')
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'text_style' => esc_html__('Text Style', 'dipi-divi-pixel'),
                    'prefix_style' => esc_html__('Prefix Style', 'dipi-divi-pixel'),
                    'typing_style' => esc_html__('Typing Style', 'dipi-divi-pixel'),
                    'suffix_style' => esc_html__('Suffix Style', 'dipi-divi-pixel'),
                    'cursor_style' => esc_html__('Cursor Style', 'dipi-divi-pixel'),
                ],
            ],
        ];
    }

    public function get_custom_css_fields_config()
    {
        $fields = [];

        $fields['prefix'] = [
            'label'    => esc_html__('Prefix Text', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-typing-text-prefix',
        ];

        $fields['typing'] = [
            'label'    => esc_html__('Typing Text', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-typing-wrap',
        ];

        $fields['suffix'] = [
            'label'    => esc_html__('Suffix Text', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-typing-text-suffix',
        ];
		
        $fields['cursor'] = [
            'label'    => esc_html__('Cursor', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .typed-cursor',
        ];

        return $fields;
    }

    public function get_fields()
    {

        $fields = [];

        $fields['typing_prefix'] = [
            'label'           => esc_html__('Prefix Text', 'dipi-divi-pixel'),
            'type'            => 'text',
            'option_category' => 'basic_option',
            'toggle_slug'     => 'text',
        ];

        $fields['typing_text'] = [
            'label'           => esc_html__('Text', 'dipi-divi-pixel'),
            'description'     => esc_html__('Separate words with „|” symbol. Sample: Apple|Orange|Pineapple', 'dipi-divi-pixel'),
            'type'            => 'text',
            'default'         => 'Apple|Orange|Pineapple',
            'option_category' => 'basic_option',
            'toggle_slug'     => 'text',
        ];

        $fields['typing_suffix'] = [
            'label'           => esc_html__('Suffix Text', 'dipi-divi-pixel'),
            'type'            => 'text',
            'option_category' => 'basic_option',
            'toggle_slug'     => 'text',
        ];
        $fields['text_wrapper_tag'] = [
			'label'           => esc_html__('Text Wrapper Tag', 'dipi-divi-pixel'),
			'type'            => 'select',
			'description'     => esc_html__('Select the heading tag, which you would like to use', 'dipi-divi-pixel'),
			'option_category' => 'basic_option',
			'toggle_slug'     => 'text',
			'default'         => 'div',
			'options'         => [
				'h1'	  => esc_html__('H1', 'dipi-divi-pixel'),
				'h2'	  => esc_html__('H2', 'dipi-divi-pixel'),
				'h3'	  => esc_html__('H3', 'dipi-divi-pixel'),
				'h4'	  => esc_html__('H4', 'dipi-divi-pixel'),
				'h5'	  => esc_html__('H5', 'dipi-divi-pixel'),
				'h6'	  => esc_html__('H6', 'dipi-divi-pixel'),
				'p'	      => esc_html__('P', 'dipi-divi-pixel'),
				'span'	  => esc_html__('Span', 'dipi-divi-pixel'),
                'div'	      => esc_html__('Div', 'dipi-divi-pixel'),
			],
		];
        $fields['flex_direction'] = [
            'label' => esc_html__('Flex Direction', 'dipi-divi-pixel'),
            'type'  => 'select',
            'option_category' => 'configuration',
            'default' => 'row',
            'options' => [
                'row' => esc_html__('Row', 'dipi-divi-pixel'),
                'column' => esc_html__('Column', 'dipi-divi-pixel'),
            ],
            'mobile_options'  => true,
            'toggle_slug'       => 'text',
        ];

        $fields['flex_wrap']  = [
            'label' => esc_html__('Flex Wrap', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'default' => 'on',
            'options' => [
                'on'  => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'mobile_options'  => true,
            'toggle_slug'       => 'text',
        ];

        $fields['typing_loop'] = [
            'label'           => esc_html__('Loop', 'dipi-divi-pixel'),
            'type'            => 'yes_no_button',
            'option_category' => 'configuration',
            'default'         => 'on',
            'default_on_front' => 'on',
            'options'         => array(
                'off'  => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'settings',
        ];

        $fields['show_cursor'] = [
            'label'           => esc_html__('Show Cursor', 'dipi-divi-pixel'),
            'type'            => 'yes_no_button',
            'option_category' => 'configuration',
            'default'         => 'on',
            'default_on_front' => 'on',
            'options'         => array(
                'off'  => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'settings',
        ];

        $fields['cursor_char']  = [
            'default'           => esc_html__('|', 'dipi-divi-pixel'),
            'label'             => esc_html__('Cursor Text', 'dipi-divi-pixel'),
            'type'              => 'text',
            'option_category'   => 'basic_option',
            'show_if'           => ['show_cursor'  => 'on'],
            'toggle_slug'       => 'settings',
        ];
        $fields['typing_delay'] = [
            'label' => esc_html__('Start Delay', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'layout',
            'default' => '0ms',
            'range_settings' => array(
                'min' => '0',
                'max' => '10000',
                'step' => '100',
            ),
            'toggle_slug' => 'settings',
            'default_unit' => 'ms',
            'description' => esc_html__("The delay in milliseconds before typing starts in milliseconds", 'dipi-divi-pixel'),
        ];
        $fields['typing_speed'] = [
            'label'         => esc_html__('Speed', 'dipi-divi-pixel'),
            'type'          => 'range',
            'option_category'   => 'configuration',
            'default'       => '100ms',
            'default_on_front' => '100ms',
            'default_unit' => 'ms',
            'range_settings'  => array(
                'min'  => '10',
                'max'  => '700',
                'step' => '10',
            ),
            'toggle_slug' => 'settings'
        ];

        $fields['typing_backspeed'] = [
            'label' => esc_html__('Backspeed', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'default'       => '100ms',
            'default_on_front' => '100ms',
            'default_unit' => 'ms',
            'range_settings'  => array(
                'min'  => '10',
                'max'  => '700',
                'step' => '10',
            ),
            'toggle_slug' => 'settings'
        ];

        $fields['typing_backdelay'] = [
            'label'         => esc_html__('Backdelay', 'dipi-divi-pixel'),
            'type'          => 'range',
            'option_category'   => 'configuration',
            'default'       => '100ms',
            'default_on_front' => '100ms',
            'default_unit' => 'ms',
            'range_settings'  => array(
                'min'  => '0',
                'max'  => '3000',
                'step' => '100',
            ),
            'toggle_slug' => 'settings'
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
            'toggle_slug' => 'settings' 
            
        ];
        $fields['anim_start_viewport_offset'] = [
			'label'           => esc_html__( 'View Port Offset', 'dipi-divi-pixel' ),
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
                
				'anim_start' => 'inViewport'
			]
		];

        $fields['typing_prefix_padding'] = [
            'label' => esc_html__('Typing Prefix Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'option_category' => 'basic_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'prefix_style'
        ];

        $fields['typing_padding'] = [
            'label' => esc_html__('Typing Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'option_category' => 'basic_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'typing_style'
        ];

        $fields['typing_suffix_padding'] = [
            'label' => esc_html__('Typing Suffix Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'option_category' => 'basic_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'suffix_style'
        ];

        return $fields;
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = [];
        $advanced_fields["text"] = false;
        $advanced_fields["text_shadow"] = false;
        $advanced_fields["fonts"] = [];
        $advanced_fields["fonts"]["text"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-typing",
            ],
            'font_size' => [
                'default' => '14px',
            ],
            'line_height' => [
                'range_settings' => [
                    'min'  => '1',
                    'max'  => '10',
                    'step' => '.1',
                ],
            ],
            'important' => 'all',
            'toggle_slug' => 'text_style'
        ];
        $advanced_fields["fonts"]["prefix"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-typing .dipi-typing-text-prefix",
            ],
            'font_size' => [
                'default' => '14px',
            ],
            'line_height' => [
                'range_settings' => [
                    'min'  => '1',
                    'max'  => '10',
                    'step' => '.1',
                ],
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'prefix_style'
        ];
        $advanced_fields["fonts"]["typing"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-typing .dipi-typing-wrap",
            ],
            'font_size' => [
                'default' => '14px',
            ],
            'line_height' => [
                'range_settings' => [
                    'min'  => '1',
                    'max'  => '10',
                    'step' => '.1',
                ],
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'typing_style'
        ];
        $advanced_fields["fonts"]["suffix"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-typing .dipi-typing-text-suffix",
            ],
            'font_size' => [
                'default' => '14px',
            ],
            'line_height' => [
                'range_settings' => [
                    'min'  => '1',
                    'max'  => '10',
                    'step' => '.1',
                ],
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'suffix_style'
        ];
        $advanced_fields["fonts"]["cursor"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-typing .typed-cursor",
            ],
            'font_size' => [
                'default' => '14px',
            ],
            'line_height' => [
                'range_settings' => [
                    'min'  => '1',
                    'max'  => '10',
                    'step' => '.1',
                ],
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'hide_letter_spacing' => true,
            'hide_text_align' => true,
            'toggle_slug' => 'cursor_style'
        ];

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
        $advanced_fields["borders"]["prefix"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-typing .dipi-typing-text-prefix",
                    'border_styles' => "%%order_class%% .dipi-typing .dipi-typing-text-prefix",
                ],
            ],
            'toggle_slug' => 'prefix_style'
        ];
        $advanced_fields["borders"]["typing"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-typing .dipi-typing-wrap",
                    'border_styles' => "%%order_class%% .dipi-typing .dipi-typing-wrap",
                ],
            ],
            'toggle_slug' => 'typing_style',
        ];
        $advanced_fields["borders"]["suffix"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-typing .dipi-typing-text-suffix",
                    'border_styles' => "%%order_class%% .dipi-typing .dipi-typing-text-suffix",
                ],
            ],
            'toggle_slug' => 'suffix_style',
        ];
        $advanced_fields["box_shadow"]["default"] = [
            'css' => [
                'main' => "%%order_class%%",
            ],
        ];
        $advanced_fields["box_shadow"]["typing"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-typing .dipi-typing-wrap",
            ],
            'toggle_slug' => 'typing_style'
        ];
        $advanced_fields["box_shadow"]["prefix"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-typing .dipi-typing-text-prefix",
            ],
            'toggle_slug' => 'prefix_style'
        ];
        $advanced_fields["box_shadow"]["suffix"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-typing .dipi-typing-text-suffix",
            ],
            'toggle_slug' => 'suffix_style'
        ];

        return $advanced_fields;
    }

    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_typing_text_public');
        $typing_text = $this->props['typing_text'];
        $typing_text = explode('|', $typing_text);
        $typing_text = wp_json_encode($typing_text);
        $typing_prefix = $this->props['typing_prefix'];
        $typing_suffix = $this->props['typing_suffix'];
        $textWrapperTag  	= 	$this->props['text_wrapper_tag'];

        $typing_loop = ('off' !== $this->props['typing_loop']) ? esc_attr('true') : esc_attr('false');
        $typing_delay = $this->props['typing_delay'];
        $typing_speed = $this->props['typing_speed'];
        $typing_backspeed = $this->props['typing_backspeed'];
        $typing_backdelay = $this->props['typing_backdelay'];
        $typing_prefix_padding = $this->props['typing_prefix_padding'];
        $typing_padding = $this->props['typing_padding'];
        $typing_suffix_padding = $this->props['typing_suffix_padding'];
        $show_cursor = ('off' !== $this->props['show_cursor']) ? esc_attr('true') : esc_attr('false');

        if ('off' !== $this->props['show_cursor']) {
            $cursor_char = ('' != $this->props['cursor_char']) ? $this->props['cursor_char'] : '|';
        } else {
            $cursor_char = '';
        }

        $type = 'padding';
        $important = false;

        if ($this->props['text_text_align'] == 'left') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => '%%order_class%% .dipi-typing',
                'declaration' => 'justify-content: flex-start !important;'
            ));
        }

        if ($this->props['text_text_align'] == 'center') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => '%%order_class%% .dipi-typing',
                'declaration' => 'justify-content: center !important;'
            ));
        }

        if ($this->props['text_text_align'] == 'right') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => '%%order_class%% .dipi-typing',
                'declaration' => 'justify-content: flex-end !important;'
            ));
        }

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-typing .dipi-typing-text-prefix',
            'declaration' => et_builder_get_element_style_css($typing_prefix_padding, $type, $important)
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-typing .dipi-typing-wrap',
            'declaration' => et_builder_get_element_style_css($typing_padding, $type, $important)
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-typing .dipi-typing-text-suffix',
            'declaration' => et_builder_get_element_style_css($typing_suffix_padding, $type, $important)
        ]);


        $flex_direction = $this->dipi_get_responsive_prop('flex_direction');
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => '%%order_class%% .dipi-typing',
            'declaration' => sprintf('flex-direction:%1$s !important;', esc_attr($flex_direction['desktop'])),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => '%%order_class%% .dipi-typing',
            'declaration' => sprintf('flex-direction:%1$s !important;', esc_attr($flex_direction['tablet'])),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => '%%order_class%% .dipi-typing',
            'declaration' => sprintf('flex-direction:%1$s !important;', esc_attr($flex_direction['phone'])),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));

        if ('on' == $this->props['flex_wrap']) :
            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => '%%order_class%% .dipi-typing',
                'declaration' => 'flex-wrap: wrap !important;'
            ));
        endif;

        if ('on' !== $this->props['show_cursor']) :

            $typingPadding = explode('|', $this->props['typing_padding']);
            $typing_text_height = (intval($this->props['typing_font_size']) * intval($this->props['typing_line_height'])) + intval($typingPadding[0]) + intval($typingPadding[2]);

            ET_Builder_Element::set_style($render_slug, array(
                'selector'    => '%%order_class%% .dipi-typing-wrap',
                'declaration' => "height: {$typing_text_height}px !important;"
            ));

        endif;
        // anim_start
        // anim_start_viewport_offset
         
        $inViewport = $this->props['anim_start'] == 'inViewport' ? 'on':'off';
        $viewport_offset = (isset($this->props['anim_start_viewport_offset']) && $this->props['anim_start_viewport_offset'] > 0) ?  $this->props['anim_start_viewport_offset'] : 0;
        $data_options = sprintf(
            'data-dipi-loop="%1$s"
            data-dipi-speed="%2$s"
            data-dipi-backspeed="%3$s"
            data-dipi-backdelay="%4$s"
            data-dipi-show-cursor="%5$s"
            data-dipi-cursor-char="%6$s"
            data-dipi-typing-strings="%7$s"
            data-dipi-typing-strings="%7$s"
            data-dipi-typing-inviewport="%8$s"
            data-dipi-typing-offset="%9$s"
            data-dipi-delay="%10$s"
            ',
            esc_attr($typing_loop),
            esc_attr($typing_speed),
            esc_attr($typing_backspeed),
            esc_attr($typing_backdelay),
            esc_attr($show_cursor), #5
            esc_attr($cursor_char),
            esc_attr(htmlspecialchars($typing_text, ENT_QUOTES, 'UTF-8')),
            esc_attr($inViewport),
            esc_attr($viewport_offset),
            esc_attr($typing_delay) #10
        );

        return sprintf(
            '<%4$s class="dipi-typing">
                <span class="dipi-typing-text-prefix">%1$s</span>
                <span class="dipi-typing-wrap">
                    <span class="dipi-typing-text" %2$s></span>
                </span>
                <span class="dipi-typing-text-suffix">%3$s</span>
            </%4$s>',
            esc_html($typing_prefix),
            et_core_esc_previously($data_options),
            esc_html($typing_suffix),
            esc_html($textWrapperTag)
        );
    }
}

new DIPI_TypingText;
