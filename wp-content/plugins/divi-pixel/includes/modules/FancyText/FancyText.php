<?php

class DIPI_Fancy_Text extends DIPI_Builder_Module
{

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/fancy-text',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->slug = 'dipi_fancy_text';
        $this->vb_support = 'on';
        $this->name = esc_html__('Pixel Fancy Text', 'dipi-divi-pixel');
        $this->child_slug = 'dipi_fancy_text_child';
        $this->child_item_text = esc_html__('Text Item', 'dipi-divi-pixel');
    }

    public function get_settings_modal_toggles()
    {
        $toggles = [];

        $toggles['general'] = [
            'toggles' => [
                'text' => esc_html__('Text', 'dipi-divi-pixel'),
                'animation' => esc_html__('Animation', 'dipi-divi-pixel'),
            ],
        ];

        $toggles['advanced'] = [
            'toggles' => [
                'animation' => esc_html__('Animation', 'dipi-divi-pixel'),
                'text' => [
                    'title' => esc_html__('Text', 'dipi-divi-pixel'),
                    'priority' => 49,
                    'tabbed_subtoggles' => true,
                    'sub_toggles' => array(
                        'all' => array(
                            'name' => 'All',
                        ),
                        'prefix' => array(
                            'name' => 'Prefix',
                        ),
                        'text' => array(
                            'name' => 'Text',
                        ),
                        'suffix' => array(
                            'name' => 'Suffix',
                        ),
                    ),
                ],
            ],
        ];

        return $toggles;
    }

    public function get_custom_css_fields_config()
    {
        $fields = [];
        return $fields;
    }

    public function get_fields()
    {
        $fields = [];


        $fields['text_spacing'] = [
            'label' => esc_html__('Tabs Container Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '10px|10px|10px|10px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'text',
            'sub_toggle' => 'text'
        ];
         
        $fields['prefix'] = [
            'label' => esc_html__('Prefix', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'text',
            'dynamic_content' => 'text'
        ];

        $fields['suffix'] = [
            'label' => esc_html__('Suffix', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'text',
            'dynamic_content' => 'text'
        ];

        $fields['sp_direction'] = [
            'label' => esc_html__('Prefix/Suffix direction', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => [
                'horizontally' => esc_html__('Horizontally', 'dipi-divi-pixel'),
                'vertically' => esc_html__('Vertically', 'dipi-divi-pixel'),
            ],
            'default' => 'horizontally',
            'toggle_slug' => 'text',
        ];

        $fields['in_animation'] = [
            'label' => esc_html__('In Animation Type', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => [
                'bounce' => esc_html__('bounce', 'dipi-divi-pixel'),
                'flash' => esc_html__('flash', 'dipi-divi-pixel'),
                'pulse' => esc_html__('pulse', 'dipi-divi-pixel'),
                'rubberBand' => esc_html__('rubberBand', 'dipi-divi-pixel'),
                'shake' => esc_html__('shake', 'dipi-divi-pixel'),
                'swing' => esc_html__('swing', 'dipi-divi-pixel'),
                'tada' => esc_html__('tada', 'dipi-divi-pixel'),
                'wobble' => esc_html__('wobble', 'dipi-divi-pixel'),
                'bounceIn' => esc_html__('bounceIn', 'dipi-divi-pixel'),
                'bounceInDown' => esc_html__('bounceInDown', 'dipi-divi-pixel'),
                'bounceInLeft' => esc_html__('bounceInLeft', 'dipi-divi-pixel'),
                'bounceInRight' => esc_html__('bounceInRight', 'dipi-divi-pixel'),
                'bounceInUp' => esc_html__('bounceInUp', 'dipi-divi-pixel'),
                'fadeIn' => esc_html__('fadeIn', 'dipi-divi-pixel'),
                'fadeInDown' => esc_html__('fadeInDown', 'dipi-divi-pixel'),
                'fadeInDownBig' => esc_html__('fadeInDownBig', 'dipi-divi-pixel'),
                'fadeInLeft' => esc_html__('fadeInLeft', 'dipi-divi-pixel'),
                'fadeInLeftBig' => esc_html__('fadeInLeftBig', 'dipi-divi-pixel'),
                'fadeInRight' => esc_html__('fadeInRight', 'dipi-divi-pixel'),
                'fadeInRightBig' => esc_html__('fadeInRightBig', 'dipi-divi-pixel'),
                'fadeInUp' => esc_html__('fadeInUp', 'dipi-divi-pixel'),
                'fadeInUpBig' => esc_html__('fadeInUpBig', 'dipi-divi-pixel'),
                'flip' => esc_html__('flip', 'dipi-divi-pixel'),
                'flipInX' => esc_html__('flipInX', 'dipi-divi-pixel'),
                'flipInY' => esc_html__('flipInY', 'dipi-divi-pixel'),
                'rotateIn' => esc_html__('rotateIn', 'dipi-divi-pixel'),
                'rotateInDownLeft' => esc_html__('rotateInDownLeft', 'dipi-divi-pixel'),
                'rotateInDownRight' => esc_html__('rotateInDownRight', 'dipi-divi-pixel'),
                'rotateInUpLeft' => esc_html__('rotateInUpLeft', 'dipi-divi-pixel'),
                'rotateInUpRight' => esc_html__('rotateInUpRight', 'dipi-divi-pixel'),
                'zoomIn' => esc_html__('zoomIn', 'dipi-divi-pixel'),
                'zoomInDown' => esc_html__('zoomInDown', 'dipi-divi-pixel'),
                'zoomInLeft' => esc_html__('zoomInLeft', 'dipi-divi-pixel'),
                'zoomInRight' => esc_html__('zoomInRight', 'dipi-divi-pixel'),
                'zoomInUp' => esc_html__('zoomInUp', 'dipi-divi-pixel'),
                'lightSpeedIn' => esc_html__('lightSpeedIn', 'dipi-divi-pixel'),
                'rollIn' => esc_html__('rollIn', 'dipi-divi-pixel'),
            ],
            'default' => 'bounceIn',
            'toggle_slug' => 'animation',
            'tab_slug' => 'general',
        ];

        $fields['out_animation'] = [
            'label' => esc_html__('Out Animation Type', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => [
                'bounce' => esc_html__('bounce', 'dipi-divi-pixel'),
                'flash' => esc_html__('flash', 'dipi-divi-pixel'),
                'pulse' => esc_html__('pulse', 'dipi-divi-pixel'),
                'rubberBand' => esc_html__('rubberBand', 'dipi-divi-pixel'),
                'shake' => esc_html__('shake', 'dipi-divi-pixel'),
                'swing' => esc_html__('swing', 'dipi-divi-pixel'),
                'tada' => esc_html__('tada', 'dipi-divi-pixel'),
                'wobble' => esc_html__('wobble', 'dipi-divi-pixel'),
                'bounceOut' => esc_html__('bounceOut', 'dipi-divi-pixel'),
                'bounceOutDown' => esc_html__('bounceOutDown', 'dipi-divi-pixel'),
                'bounceOutLeft' => esc_html__('bounceOutLeft', 'dipi-divi-pixel'),
                'bounceOutRight' => esc_html__('bounceOutRight', 'dipi-divi-pixel'),
                'bounceOutUp' => esc_html__('bounceOutUp', 'dipi-divi-pixel'),
                'fadeOut' => esc_html__('fadeOut', 'dipi-divi-pixel'),
                'fadeOutDown' => esc_html__('fadeOutDown', 'dipi-divi-pixel'),
                'fadeOutDownBig' => esc_html__('fadeOutDownBig', 'dipi-divi-pixel'),
                'fadeOutLeft' => esc_html__('fadeOutLeft', 'dipi-divi-pixel'),
                'fadeOutLeftBig' => esc_html__('fadeOutLeftBig', 'dipi-divi-pixel'),
                'fadeOutRight' => esc_html__('fadeOutRight', 'dipi-divi-pixel'),
                'fadeOutRightBig' => esc_html__('fadeOutRightBig', 'dipi-divi-pixel'),
                'fadeOutUp' => esc_html__('fadeOutUp', 'dipi-divi-pixel'),
                'fadeOutUpBig' => esc_html__('fadeOutUpBig', 'dipi-divi-pixel'),
                'flip' => esc_html__('flip', 'dipi-divi-pixel'),
                'flipOutX' => esc_html__('flipOutX', 'dipi-divi-pixel'),
                'flipOutY' => esc_html__('flipOutY', 'dipi-divi-pixel'),
                'rotateOut' => esc_html__('rotateOut', 'dipi-divi-pixel'),
                'rotateOutDownLeft' => esc_html__('rotateOutDownLeft', 'dipi-divi-pixel'),
                'rotateOutDownRight' => esc_html__('rotateOutDownRight', 'dipi-divi-pixel'),
                'rotateOutUpLeft' => esc_html__('rotateOutUpLeft', 'dipi-divi-pixel'),
                'rotateOutUpRight' => esc_html__('rotateOutUpRight', 'dipi-divi-pixel'),
                'zoomOut' => esc_html__('zoomOut', 'dipi-divi-pixel'),
                'zoomOutDown' => esc_html__('zoomOutDown', 'dipi-divi-pixel'),
                'zoomOutLeft' => esc_html__('zoomOutLeft', 'dipi-divi-pixel'),
                'zoomOutRight' => esc_html__('zoomOutRight', 'dipi-divi-pixel'),
                'zoomOutUp' => esc_html__('zoomOutUp', 'dipi-divi-pixel'),
                'lightSpeedOut' => esc_html__('lightSpeedOut', 'dipi-divi-pixel'),
                'rollOut' => esc_html__('rollOut', 'dipi-divi-pixel'),
            ],
            'default' => 'bounceOut',
            'toggle_slug' => 'animation',
            'tab_slug' => 'general',
        ];
        $fields['highlight_animation_start'] = [
			'label'           => esc_html__('Start Animation', 'dipi-divi-pixel'),
			'type'            => 'select',
			'description'     => esc_html__('Define whenever animation will start', 'dipi-divi-pixel'),
			'option_category' => 'basic_option',
			'toggle_slug'     => 'animation',
			'default'         => 'in_a_viewport',
			'options'         => [
				'in_loading'	  => esc_html__('On page load', 'dipi-divi-pixel'),
				'in_a_viewport'	  => esc_html__('In a viewport', 'dipi-divi-pixel'),
			],
		];
        $fields['highlight_animation_start_viewport'] = [
			'label'           => esc_html__( 'View Port', 'dipi-divi-pixel' ),
			'type'            => 'range',
			'toggle_slug'         => 'animation',
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
				'highlight_animation_start' => 'in_a_viewport'
			]
		];
        $fields['speed'] = [
            'label' => esc_html__('Delay (ms)', 'dipi-divi-pixel'),
            'description' => esc_html__("How long a phrase shall be visible till the next phrase is shown."),
            'type' => 'range',
            'default' => '2500',
            'unitless' => true,
            'range_settings' => [
                'min' => '0',
                'max' => '10000',
                'step' => '100',
            ],
            'toggle_slug' => 'animation',
        ];

        $fields['duration'] = [
            'label' => esc_html__('Duration (ms)', 'dipi-divi-pixel'),
            'description' => esc_html__("How long the in and out animations shall take."),
            'type' => 'range',
            'default' => '500',
            'unitless' => true,
            'range_settings' => array(
                'min' => '0',
                'max' => '3000',
                'step' => '100',
            ),
            'toggle_slug' => 'animation',
        ];

        $fields['animation_only_once'] = [
			'label' => esc_html__('Only Once', 'dipi-divi-pixel'),
			'description' => esc_html__(' Allow you to play the animation only once', 'dipi-divi-pixel'),
			'type' => 'yes_no_button',
			'option_category' => 'configuration',
			'toggle_slug' => 'animation',
			'default' => 'off',
			'options' => array(
					'off' => esc_html__('Off', 'dipi-divi-pixel'),
					'on' => esc_html__('On', 'dipi-divi-pixel'),
			),
		];
        $fields['html_element'] = [
            'label' => esc_html__('HTML Element', 'dipi-divi-pixel'),
            'type' => 'multiple_buttons',
            'options' => [
                'h1' => ['title' => 'H1', 'icon' => 'text-h1'],
                'h2' => ['title' => 'H2', 'icon' => 'text-h2'],
                'h3' => ['title' => 'H3', 'icon' => 'text-h3'],
                'h4' => ['title' => 'H4', 'icon' => 'text-h4'],
                'h5' => ['title' => 'H5', 'icon' => 'text-h5'],
                'h6' => ['title' => 'H6', 'icon' => 'text-h6'],
                'div' => ['title' => 'div'],
            ],
            'default' => 'h3',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'text',
            'sub_toggle' => 'all',
        ];

        return $fields;
    }

    public function get_advanced_fields_config()
    {
        $fields = [];

        $fields["text"] = false;
        $fields["text_shadow"] = false;

        $fields['fonts']['all'] = [
            'label' => esc_html__('All Text', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .fancy-text",
            ],
            'toggle_slug' => 'text',
            'sub_toggle' => 'all',
        ];

        $fields['fonts']['prefix'] = [
            'label' => esc_html__('Prefix', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .fancy-text-prefix",
            ],
            'toggle_slug' => 'text',
            'sub_toggle' => 'prefix',
            'hide_text_align' => true
        ];

        $fields['fonts']['text'] = [
            'label' => esc_html__('Text', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .fancy-text-wrap",
            ],
            'toggle_slug' => 'text',
            'sub_toggle' => 'text',
            'hide_text_align' => true
        ];

        $fields['fonts']['suffix'] = [
            'label' => esc_html__('Suffix', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .fancy-text-suffix",
            ],
            'toggle_slug' => 'text',
            'sub_toggle' => 'suffix',
            'hide_text_align' => true
        ];

        return $fields;
    }

    public function before_render()
    {
        global $text_items;
        $text_items = [];
    }

    /**
     * Render
     */
    public function render($attrs, $content, $render_slug)
    {
        global $text_items;
        wp_enqueue_script('dipi_fancy_text_public');
        wp_enqueue_style('dipi_animate');
        $this->_dipi_apply_css($render_slug);

        $text_level = $this->props['html_element'];
        $prefix = $this->props['prefix'];
        $suffix = $this->props['suffix'];

        $options['data-in-animation'] = esc_attr($this->props['in_animation']);
        $options['data-out-animation'] = esc_attr($this->props['out_animation']);
        $options['data-speed'] = esc_attr($this->props['speed']);
        $options['data-duration'] = esc_attr($this->props['duration']);

        $options = implode(
            " ",
            array_map(
                function ($k, $v) {
                    return "{$k}='{$v}'";
                },
                array_keys($options),
                $options
            )
        );
        $highlight_animation_start = $this->props['highlight_animation_start'];
		$highlight_animation_start_viewport = $this->props['highlight_animation_start_viewport'];
        $animation_only_once = $this->props['animation_only_once'];
        $config = [
			'animation_start' => $highlight_animation_start,
			'animation_start_viewport' => $highlight_animation_start_viewport,
            'animation_only_once' =>$animation_only_once,
            'item_count' => count($text_items)
        ];

        $text = sprintf(
            '<div class="fancy-text-wrap" %2$s>%1$s</div>',
            implode('||', $text_items),
            $options
        );

        return sprintf(
            '<div class="dipi-fancy-text-container" data-config="%5$s">
                <%1$s class="fancy-text">
                    <div class="fancy-text-prefix">%3$s</div>%2$s<div class="fancy-text-suffix">%4$s</div>
                </%1$s>
            </div>',
            $text_level,
            $text,
            $prefix,
            $suffix,
            esc_attr(htmlspecialchars(json_encode($config), ENT_QUOTES, 'UTF-8')) #5
        );
    }
    /**
     * Custom CSS
     */
    public function _dipi_apply_css($render_slug)
    {
        $text_spacing = $this->props['text_spacing'];
        $duration = $this->props['duration'];
        $sp_direction = $this->props['sp_direction'];
       
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .fancy-text-wrap .animated',
            'declaration' => "animation-duration: {$duration}ms !important;",
        ]);


        if(str_contains($text_spacing, "|")) {
            $this->dipi_process_spacing_field([
                'render_slug'    => $render_slug,
                'slug'           => 'text_spacing',
                'css_property'   => 'padding',
                'selector'       => '%%order_class%% .fancy-text-wrap',
                'hover_selector' => '%%order_class%% .fancy-text-wrap:hover'
            ]);
        } else { // old implementation with range field
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .fancy-text-wrap',
                'declaration' => "padding-left: {$text_spacing} !important; padding-right: {$text_spacing} !important;",
            ]);
        }
        

        if( 'vertically' == $sp_direction ) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .fancy-text-suffix, %%order_class%% .fancy-text-wrap, %%order_class%% .fancy-text-prefix',
                'declaration' => "display: block !important;",
            ]);
        } else {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .fancy-text-suffix, %%order_class%% .fancy-text-wrap, %%order_class%% .fancy-text-prefix',
                'declaration' => "display: inline-block !important;",
            ]);
        }

    }

}

new DIPI_Fancy_Text;
