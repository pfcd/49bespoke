<?php

class DIPI_DualHeading extends DIPI_Builder_Module {
    public $slug = 'dipi_dual_heading';
    public $vb_support = 'on';

    protected $default_settings = [
        'background_text_font_size'     => '60px',
        'first_heading_line_height'     => '1.6em',
        'second_heading_line_height'    => '1.6em',
        'first_heading_font_size'       => '18px',
        'second_heading_font_size'      => '18px',
        'background_text_text_color'    => "#eeeeee"
    ];

    public $fh_selector = "%%order_class%% .dipi-dual-heading .dipi-dh-first-heading";
    public $sh_selector = "%%order_class%% .dipi-dual-heading .dipi-dh-second-heading";
    public $bt_selector = "%%order_class%% .dipi-dual-heading .dipi-dh-main::before";
    public $main_selector = "%%order_class%% .dipi-dual-heading .dipi-dh-main";

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/dual-heading',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init() {
        $this->icon_path = plugin_dir_path(__FILE__) . "dp-dual-heading.svg";
        $this->name = esc_html__('Pixel Dual Heading', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%.dipi_dual_heading';
        $this->settings_modal_toggles = [];

        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'main_content' => esc_html__('Content', 'dipi-divi-pixel'),
                ]
            ],
            'advanced' => [
                'toggles' => [
                    'typography' => [
                        'sub_toggles' => [
                            'first_heading' => [
                                'name' => 'First Heading',
                            ],
                            'second_heading' => [
                                'name' => 'Last Heading',
                            ],
                            'background' => [
                                'name' => 'Background Text',
                            ]
                        ],
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__('Typography', 'dipi-divi-pixel'),
                    ],
                    'first_heading_style' => esc_html__('First Heading Style', 'dipi-divi-pixel'),
                    'second_heading_style' => esc_html__('Second Heading Style', 'dipi-divi-pixel'),
                    'background_text_style' => esc_html__('Background Text Style', 'dipi-divi-pixel'),
                    'reveal_effect_style' =>  [
                        'sub_toggles' => [
                            'first_heading' => [
                                'name' => 'First Heading',
                            ],
                            'second_heading' => [
                                'name' => 'Second Heading',
                            ],
                        ],
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__('Reveal Effect Style', 'dipi-divi-pixel'),
                    ]
                ]
            ]
        ];

        add_filter('et_fb_backend_helpers', [$this, 'default_helpers'], 100, 1);
    }

    public function default_helpers ($helpers) {
		$helpers['defaults']['dipi_dual_heading'] = [
			'first_heading' => 'First',
			'second_heading' => 'Second'
		];
		return $helpers;
	}


    public function get_custom_css_fields_config() {
        $fields = [];
        return $fields;
    }

    public function get_fields() {
        $fields = [];
        $fields['first_heading'] = [
            'label' => esc_html__('First Heading', 'dipi-divi-pixel'),
            'type' => 'text',
            'tab_slug'      => 'general',
            'toggle_slug' => 'main_content',
            'dynamic_content' => 'text'
        ];
        $fields['second_heading'] = [
            'label' => esc_html__('Second Heading', 'dipi-divi-pixel'),
            'type' => 'text',
            'tab_slug'      => 'general',
            'toggle_slug' => 'main_content',
            'dynamic_content' => 'text'
        ];
        $fields['heading_tag'] = [
            'label'         => esc_html__('Heading Tag', 'dipi-divi-pixel'),
            'description'   => esc_html__('Choose Heading HTML Tag', 'dipi-divi-pixel'),
            'type'          => 'select',
            'tab_slug'      => 'general',
            'toggle_slug' => 'main_content',
            'default'       => 'h2',
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
        ];

        $fields['heading_display'] = [
            'label'         => esc_html__('Heading Display', 'dipi-divi-pixel'),
            'description'   => esc_html__('Choose How Heading Will be displayed', 'dipi-divi-pixel'),
            'mobile_options' => true,
            'responsive' => true,
            'type'          => 'select',
            'tab_slug'      => 'general',
            'toggle_slug' => 'main_content',
            'default'       => 'row',
            'options' => [
                'row'   => esc_html__('Row', 'dipi-divi-pixel'),
                'column'   => esc_html__('Column', 'dipi-divi-pixel')
            ]
        ];

        $fields['use_background_text'] = [
            'label' =>  esc_html__( 'Use Background Text', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'tab_slug'      => 'general',
            'toggle_slug' => 'main_content',
            'default' => 'off'
        ];

        $fields['background_text'] = [
            'label' => esc_html__('Background Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => esc_html__('Background Text', 'dipi-divi-pixel'),
            'tab_slug'      => 'general',
            'toggle_slug' => 'main_content',
            'show_if'   => ['use_background_text' => 'on'],
            'dynamic_content' => 'text'
        ];

        $fields['use_reveal_effect'] = [
            'label' =>  esc_html__( 'Use Reveal Effect', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'tab_slug'      => 'general',
            'toggle_slug' => 'main_content',
            'default' => 'off'
        ];

        /* First Heading Style */ 
        $fields['fh_style'] = [
            'label'         => esc_html__('First Heading Style', 'dipi-divi-pixel'),
            'type'          => 'select',
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'first_heading_style',
            'default'       => 'none',
            'options' => [
                'none'   => esc_html__('None', 'dipi-divi-pixel'),
                'stroke'   => esc_html__('Stroke', 'dipi-divi-pixel'),
                'background'   => esc_html__('Background', 'dipi-divi-pixel'),
            ]
        ];

        $fields['fh_stroke_color'] = array(
            'default'         => 'rgba(255,255,255)',
            'label'           => esc_html__( 'Stroke Color', 'dipi-divi-pixel' ),
            'type'            => 'color-alpha',
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'first_heading_style',
            'hover'           => 'tabs',
            'show_if'      => ['fh_style' => 'stroke']
        );

        $fields['fh_stroke_fill'] = array(
            'default'         => 'rgba(0,0,0)',
            'label'           => esc_html__( 'Stroke Fill', 'dipi-divi-pixel' ),
            'type'            => 'color-alpha',
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'first_heading_style',
            'hover'           => 'tabs',
            'show_if'      => ['fh_style' => 'stroke']
        );

        $fields["fh_stroke_width"] = [
            'label' => esc_html__( 'Stroke Width', 'dipi-divi-pixel' ),
            'type' => 'range',
            'unitless' => true,
            'default' => '1',
            'range_settings' => [
                'min'  => '1',
                'max'  => '10',
                'step' => '1',
            ],
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'first_heading_style',
            'hover'           => 'tabs',
            'show_if'      => ['fh_style' => 'stroke']
        ];

        $fields['fh_background_animation'] = [
            'label' =>  esc_html__( 'Use Background Animation', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'first_heading_style',
            'default' => 'off',
            'show_if'      => ['fh_style' => 'background']
        ];

        $fields["fh_background_animation_speed"] = [
            'label' => esc_html__( 'Animation Speed (in sec)', 'dipi-divi-pixel' ),
            'type' => 'range',
            'unitless' => true,
            'default' => '30',
                'range_settings' => [
                'min'  => '1',
                'max'  => '100',
                'step' => '1',
            ],
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'first_heading_style',
            'show_if'      => [
                'fh_style' => 'background',
                'fh_background_animation' => 'on'
            ]
        ];

        $fields['fh_background_animation_direction'] = [
            'label'         => esc_html__('Animation Direction', 'dipi-divi-pixel'),
            'type'          => 'select',
            'default'       => 'dipiBGLeftToRight',
            'options' => [
                'dipiBGLeftToRight'   => esc_html__('Left To Right (Loop)', 'dipi-divi-pixel'),
                'dipiBGRightToLeft'   => esc_html__('Right To Left (Loop)', 'dipi-divi-pixel'),
                'dipiBGTopToBottom'   => esc_html__('Top To Bottom (Loop)', 'dipi-divi-pixel'),
                'dipiBGBottomToTop'   => esc_html__('Bottom To Top (Loop)', 'dipi-divi-pixel'),
                'dipiBGHorizontal'   => esc_html__('Horizontal (Back and Forth)', 'dipi-divi-pixel'),
                'dipiBGVertical'   => esc_html__('Vertical (Back and Forth)', 'dipi-divi-pixel')
            ],
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'first_heading_style',
            'show_if'      => [
                'fh_style'                => 'background',
                'fh_background_animation' => 'on'
            ]
        ];

        $fields['fh_background_animation_function'] = [
            'label'         => esc_html__('Animation Function', 'dipi-divi-pixel'),
            'type'          => 'select',
            'default'       => 'linear',
            'options' => [
                'linear'   => esc_html__('Linear', 'dipi-divi-pixel'),
                'ease'   => esc_html__('Ease', 'dipi-divi-pixel'),
                'ease-in'   => esc_html__('Ease-In', 'dipi-divi-pixel'),
                'ease-out'   => esc_html__('Ease-Out', 'dipi-divi-pixel'),
                'ease-in-out'   => esc_html__('Ease-In-Out', 'dipi-divi-pixel')
            ],
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'first_heading_style',
            'show_if'      => [
                'fh_style'                => 'background',
                'fh_background_animation' => 'on'
            ]
        ];

        $fields['fh_background_style'] = [
            'label'         => esc_html__('Background Style', 'dipi-divi-pixel'),
            'type'          => 'select',
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'first_heading_style',
            'default'       => 'none',
            'options' => [
                'normal'   => esc_html__('Normal', 'dipi-divi-pixel'),
                'clipped'  => esc_html__('Clipped', 'dipi-divi-pixel'),
            ],
            'show_if'      => ['fh_style' => 'background']
        ];

        $fb_bg_image_options = ET_Builder_Element::generate_background_options(
            "first_heading",
            "image",
            "advanced",
            "first_heading_style",
            "first_heading_image"
        );

        $fb_bg_image_options['first_heading_parallax'] = false;
        $fb_bg_image_options['first_heading_parallax_method'] = false;
        $fb_bg_image_options['first_heading_blend'] = false;
        $fb_bg_image_options['first_heading_size']['options']['percentage'] = esc_html__('Percentage', 'dipi-divi-pixel');

        $fields['first_heading_color'] = [
            'label'           => esc_html__('Background', 'dipi-divi-pixel'),
            'type'            => 'background-field',
            'base_name'       => "first_heading",
            
            'context'         => "first_heading",
            'custom_color'    => true,
            'default'         => ET_Global_Settings::get_value('all_buttons_bg_color'),
            'tab_slug'        => 'advanced',
            'toggle_slug'     => "first_heading_style",
            'show_if'         => ['fh_style' => 'background'],
            'background_fields' => array_merge(
                ET_Builder_Element::generate_background_options(
                    'first_heading',
                    'gradient',
                    "advanced",
                    "first_heading_style",
                    "first_heading_gradient"
                ),
                ET_Builder_Element::generate_background_options(
                    "first_heading",
                    "color",
                    "advanced",
                    "first_heading_style",
                    "first_heading_color"
                ),
                $fb_bg_image_options 
                
            ),
        ];

        $fields = array_merge(
            $fields,
             $this->generate_background_options("first_heading",'skip',"advanced", "first_heading_style", "first_heading_gradient")
        );

        $fields = array_merge(
            $fields,
            $this->generate_background_options( "first_heading", 'skip', "advanced", "first_heading_style", "first_heading_color")
        );

        $fields = array_merge(
            $fields,
            $this->generate_background_options( "first_heading", 'skip', "advanced", "first_heading_style", "first_heading_image")
        );
      
        $fields["first_heading_imagesize_x"] = [
            'label' => esc_html__( 'Background Size X', 'dipi-divi-pixel' ),
            'type' => 'range',
            'default' => '150%',
            'default_unit' => '%px',
            'default_on_front'=> '150%',
            'allowed_units' => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
            'range_settings' => [
                    'min'  => '0',
                    'max'  => '300',
                    'step' => '10',
            ],
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'first_heading_style' ,
            'background_tab' => 'image',
            'priority' => 350,
            'context' => 'first_heading_image',
            'depends_show_if' =>  'percentage',
            'depends_on'      => ['first_heading_size']
        ];

        $fields["first_heading_imagesize_y"] = [
            'label' => esc_html__( 'Background Size Y', 'dipi-divi-pixel' ),
            'type' => 'range',
            'default' => '150%',
            'default_unit' => '%px',
            'default_on_front'=> '150%',
            'allowed_units' => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
            'range_settings' => [
                    'min'  => '0',
                    'max'  => '300',
                    'step' => '10',
            ],
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'first_heading_style' ,
            'background_tab' => 'image',
            'priority' => 350,
            'context' => 'first_heading_image',
            'depends_show_if' =>  'percentage',
            'depends_on'      => ['first_heading_size']
        ];

        $fields['fh_padding'] = [
            'label' => esc_html__('First heading Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|3px|0px|3px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'first_heading_style',
        ];

        $fields['fh_margin'] = [
            'label' => esc_html__('First heading Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'first_heading_style',
        ];
 
        /* Second Heading Style */ 
        $fields['sh_style'] = [
            'label'         => esc_html__('Second Heading Style', 'dipi-divi-pixel'),
            'type'          => 'select',
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'second_heading_style',
            'default'       => 'none',
            'options' => [
                'none'   => esc_html__('None', 'dipi-divi-pixel'),
                'stroke'   => esc_html__('Stroke', 'dipi-divi-pixel'),
                'background'   => esc_html__('Background', 'dipi-divi-pixel'),
            ]
        ];

        $fields['sh_stroke_color'] = array(
            'default'         => 'rgba(255,255,255)',
            'label'           => esc_html__( 'Stroke Color', 'dipi-divi-pixel' ),
            'type'            => 'color-alpha',
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'second_heading_style',
            'hover'           => 'tabs',
            'show_if'      => ['sh_style' => 'stroke']
        );

        $fields['sh_stroke_fill'] = array(
            'default'         => 'rgba(0,0,0)',
            'label'           => esc_html__( 'Stroke Fill', 'dipi-divi-pixel' ),
            'type'            => 'color-alpha',
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'second_heading_style',
            'hover'           => 'tabs',
            'show_if'      => ['sh_style' => 'stroke']
        );

        $fields["sh_stroke_width"] = [
            'label' => esc_html__( 'Stroke Width', 'dipi-divi-pixel' ),
            'type' => 'range',
            'unitless' => true,
            'default' => '1',
                
                'range_settings' => [
                'min'  => '1',
                'max'  => '10',
                'step' => '1',
            ],
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'second_heading_style',
            'hover'           => 'tabs',
            'show_if'      => ['sh_style' => 'stroke']
        ];

        $fields['sh_background_animation'] = [
            'label' =>  esc_html__( 'Use Background Animation', 'dipi-divi-pixel'),
            'type' =>  'yes_no_button',
            'options' => [
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ],
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'second_heading_style',
            'default' => 'off',
            'show_if'      => ['sh_style' => 'background']
        ];

        $fields["sh_background_animation_speed"] = [
            'label' => esc_html__( 'Animation Speed (in sec)', 'dipi-divi-pixel' ),
            'type' => 'range',
            'unitless' => true,
            'default' => '30',
                'range_settings' => [
                'min'  => '1',
                'max'  => '100',
                'step' => '1',
            ],
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'second_heading_style',
            'show_if'      => [
                'sh_style' => 'background',
                'sh_background_animation' => 'on'
                ]
        ];
        
        $fields['sh_background_animation_direction'] = [
            'label'         => esc_html__('Animation Function', 'dipi-divi-pixel'),
            'type'          => 'select',
            'default'       => 'dipiBGLeftToRight',
            'options' => [
                'dipiBGLeftToRight'   => esc_html__('Left To Right (Loop)', 'dipi-divi-pixel'),
                'dipiBGRightToLeft'   => esc_html__('Right To Left (Loop)', 'dipi-divi-pixel'),
                'dipiBGTopToBottom'   => esc_html__('Top To Bottom (Loop)', 'dipi-divi-pixel'),
                'dipiBGBottomToTop'   => esc_html__('Bottom To Top (Loop)', 'dipi-divi-pixel'),
                'dipiBGHorizontal'   => esc_html__('Horizontal (Back and Forth)', 'dipi-divi-pixel'),
                'dipiBGVertical'   => esc_html__('Vertical (Back and Forth)', 'dipi-divi-pixel')
            ],
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'second_heading_style',
            'show_if'      => [
                'sh_style' => 'background',
                'sh_background_animation' => 'on'
                ]
        ];

        $fields['sh_background_animation_function'] = [
            'label'         => esc_html__('Animation Direction', 'dipi-divi-pixel'),
            'type'          => 'select',
            'default'       => 'linear',
            'options' => [
                'linear'   => esc_html__('Linear', 'dipi-divi-pixel'),
                'ease'   => esc_html__('Ease', 'dipi-divi-pixel'),
                'ease-in'   => esc_html__('Ease-In', 'dipi-divi-pixel'),
                'ease-out'   => esc_html__('Ease-Out', 'dipi-divi-pixel'),
                'ease-in-out'   => esc_html__('Ease-In-Out', 'dipi-divi-pixel')
            ],
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'second_heading_style',
            'show_if'      => [
                'sh_style' => 'background',
                'sh_background_animation' => 'on'
                ]
        ];

        $fields['sh_background_style'] = [
            'label'         => esc_html__('Background Style', 'dipi-divi-pixel'),
            'type'          => 'select',
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'second_heading_style',
            'default'       => 'none',
            'options' => [
                'normal'   => esc_html__('Normal', 'dipi-divi-pixel'),
                'clipped'  => esc_html__('Clipped', 'dipi-divi-pixel'),
            ],
            'show_if'      => ['sh_style' => 'background']
        ];

        $sh_bg_image_options = ET_Builder_Element::generate_background_options(
            "second_heading",
            "image",
            "advanced",
            "second_heading_style",
            "second_heading_image"
        );
        $sh_bg_image_options['second_heading_parallax'] = false;
        $sh_bg_image_options['second_heading_parallax_method'] = false;
        $sh_bg_image_options['second_heading_blend'] = false;
        $sh_bg_image_options['second_heading_size']['options']['percentage'] = esc_html__('Percentage', 'dipi-divi-pixel');

        $fields['second_heading_color'] = [
            'label'           => esc_html__('Background', 'dipi-divi-pixel'),
            'type'            => 'background-field',
            'base_name'       => "second_heading",
            'context'         => "second_heading",
            'custom_color'    => true,
            'default'         => ET_Global_Settings::get_value('all_buttons_bg_color'),
            'tab_slug'        => 'advanced',
            'toggle_slug'     => "second_heading_style",
            'show_if'         => ['sh_style' => 'background'],
            'background_fields' => array_merge(
                ET_Builder_Element::generate_background_options(
                    'second_heading',
                    'gradient',
                    "advanced",
                    "second_heading_style",
                    "second_heading_gradient"
                ),
                ET_Builder_Element::generate_background_options(
                    "second_heading",
                    "color",
                    "advanced",
                    "second_heading_style",
                    "second_heading_color"
                ),
                $sh_bg_image_options
            ),
        ];

        $fields = array_merge(
            $fields,
            $this->generate_background_options("second_heading", 'skip', "advanced", "second_heading_style", "second_heading_gradient"            )
        );
        $fields = array_merge(
            $fields,
            $this->generate_background_options( "second_heading", 'skip', "advanced", "second_heading_style", "second_heading_color")
        );
        $fields = array_merge(
            $fields,
            $this->generate_background_options( "second_heading", 'skip', "advanced", "second_heading_style", "second_heading_image")
        );

        $fields["second_heading_imagesize_x"] = [
            'label' => esc_html__( 'Background Size X', 'dipi-divi-pixel' ),
            'type' => 'range',
            'default' => '150%',
            'default_unit' => '%px',
            'default_on_front'=> '150%',
            'allowed_units' => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
            'range_settings' => [
                    'min'  => '0',
                    'max'  => '300',
                    'step' => '10',
            ],
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'second_heading_style' ,
            'priority' => 350,
            'context' => 'second_heading_image',
            'depends_show_if' =>  'percentage',
            'depends_on'      => ['second_heading_size']
        ];
        $fields["second_heading_imagesize_y"] = [
            'label' => esc_html__( 'Background Size Y', 'dipi-divi-pixel' ),
            'type' => 'range',
            'default' => '150%',
            'default_unit' => '%px',
            'default_on_front'=> '150%',
            'allowed_units' => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
            'range_settings' => [
                    'min'  => '0',
                    'max'  => '300',
                    'step' => '10',
            ],
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'second_heading_style' ,
            'priority' => 350,
            'context' => 'second_heading_image',
            'depends_show_if' =>  'percentage',
            'depends_on'      => ['second_heading_size']
        ];
        $fields['sh_padding'] = [
            'label' => esc_html__('Second Heading Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|3px|0px|3px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'second_heading_style',
        ];

        $fields['sh_margin'] = [
            'label' => esc_html__('Second Heading Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'second_heading_style',
        ];


         /* Background Text Style */ 

         $fields["bt_position_vertical"] = [
            'label' => esc_html__( 'Background Text Vertical Position', 'dipi-divi-pixel' ),
            'type' => 'range',
            'default' => '50%',
            'default_unit' => '%',
            'default_on_front'=> '50%',
            'allowed_units' => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
            'mobile_options' => true,
            'responsive' => true,
             'range_settings' => [
                'min'  => '0',
                'max'  => '100',
                'step' => '1',
            ],
           'tab_slug'      => 'advanced',
           'toggle_slug'   => 'background_text_style',
           'show_if'   => ['use_background_text' => 'on']
        ];

        $fields["bt_position_horizontal"] = [
            'label' => esc_html__( 'Background Text Horizontal Position', 'dipi-divi-pixel' ),
            'type' => 'range',
            'default' => '50%',
            'default_unit' => '%',
            'default_on_front'=> '50%',
            'allowed_units' => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
            'mobile_options' => true,
            'responsive' => true,
             'range_settings' => [
                'min'  => '0',
                'max'  => '100',
                'step' => '1',
            ],
           'tab_slug'      => 'advanced',
           'toggle_slug'   => 'background_text_style',
           'show_if'   => ['use_background_text' => 'on']
        ];

         $fields['bt_style'] = [
            'label'         => esc_html__('Background Text Style', 'dipi-divi-pixel'),
            'type'          => 'select',
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'background_text_style',
            'default'       => 'none',
            'options' => [
                'none'   => esc_html__('None', 'dipi-divi-pixel'),
                'stroke'   => esc_html__('Stroke', 'dipi-divi-pixel'),
                'background'   => esc_html__('Background', 'dipi-divi-pixel'),
            ]
        ];

        $fields['bt_stroke_color'] = array(
            'default'         => 'rgba(255,255,255)',
            'label'           => esc_html__( 'Stroke Color', 'dipi-divi-pixel' ),
            'type'            => 'color-alpha',
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'background_text_style',
            'show_if'      => ['bt_style' => 'stroke'],
            'hover'           => 'tabs'
        );

        $fields['bt_stroke_fill'] = array(
            'default'         => 'rgba(0,0,0)',
            'label'           => esc_html__( 'Stroke Fill', 'dipi-divi-pixel' ),
            'type'            => 'color-alpha',
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'background_text_style',
            'hover'           => 'tabs',
            'show_if'      => ['bt_style' => 'stroke']
        );

        $fields["bt_stroke_width"] = [
            'label' => esc_html__( 'Stroke Width', 'dipi-divi-pixel' ),
            'type' => 'range',
            'unitless' => true,
            'default' => '1',
                'range_settings' => [
                'min'  => '1',
                'max'  => '10',
                'step' => '1',
            ],
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'background_text_style',
            'hover'           => 'tabs',
            'show_if'      => ['bt_style' => 'stroke']
        ];

        $fields['bt_background_style'] = [
            'label'         => esc_html__('Background Style', 'dipi-divi-pixel'),
            'type'          => 'select',
            'tab_slug'      => 'advanced',
            'toggle_slug'   => 'background_text_style',
            'default'       => 'none',
            'options' => [
                'normal'   => esc_html__('Normal', 'dipi-divi-pixel'),
                'clipped'  => esc_html__('Clipped', 'dipi-divi-pixel'),
            ],
            'show_if'      => ['bt_style' => 'background']
        ];

        $fields['background_text_color'] = [
            'label'           => esc_html__('Background', 'dipi-divi-pixel'),
            'type'            => 'background-field',
            'base_name'       => "background_text",
            'context'         => "background_text",
            'custom_color'    => true,
            'default'         => ET_Global_Settings::get_value('all_buttons_bg_color'),
            'tab_slug'        => 'advanced',
            'toggle_slug'     => "background_text_style",
            'show_if'         => ['bt_style' => 'background'],
            'background_fields' => array_merge(
                ET_Builder_Element::generate_background_options(
                    'background_text',
                    'gradient',
                    "advanced",
                    "background_text_style",
                    "background_text_gradient"
                ),
                ET_Builder_Element::generate_background_options(
                    "background_text",
                    "color",
                    "advanced",
                    "background_text_style",
                    "background_text_color"
                )
            ),
        ];

        $fields = array_merge(
            $fields,
            $this->generate_background_options(
                "background_text",
                'skip',
                "advanced",
                "background_text_style",
                "background_text_gradient"
            )
        );

        $fields = array_merge(
            $fields,
            $this->generate_background_options(
                "background_text",
                'skip',
                "advanced",
                "background_text_style",
                "background_text_color"
            )
        );
        
        $fields['bt_padding'] = [
            'label' => esc_html__('Background Text Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'background_text_style',
        ];

        $fields['bt_margin'] = [
            'label' => esc_html__('Background Text Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'background_text_style',
        ];


        /* Reveal Effect */
     
        $fields['fh_reveal_effect_color'] = [
            'label'           => esc_html__('Background', 'dipi-divi-pixel'),
            'type'            => 'background-field',
            'base_name'       => "fh_reveal_effect",
            'context'         => "fh_reveal_effect",
            'custom_color'    => true,
            'default'         => ET_Global_Settings::get_value('all_buttons_bg_color'),
            'tab_slug'        => 'advanced',
            'toggle_slug'     => "reveal_effect_style",
            'sub_toggle'     => "first_heading", 
            'show_if'         => ['use_reveal_effect' => 'on'],
            'background_fields' => array_merge(
                ET_Builder_Element::generate_background_options(
                    'fh_reveal_effect',
                    'gradient',
                    "advanced",
                    "reveal_effect_style",
                    "fh_reveal_effect_gradient"
                ),
                ET_Builder_Element::generate_background_options(
                    "fh_reveal_effect",
                    "color",
                    "advanced",
                    "reveal_effect_style",
                    "fh_reveal_effect_color"
                ) 
                
            ),
        ];

        $fields = array_merge(
            $fields,
             $this->generate_background_options("fh_reveal_effect",'skip',"advanced", "reveal_effect_style", "fh_reveal_effect_gradient")
        );

        $fields = array_merge(
            $fields,
            $this->generate_background_options( "fh_reveal_effect", 'skip', "advanced", "reveal_effect_style", "fh_reveal_effect_color")
        );
 
        $fields['fh_reveal_effect_animation'] = [
            'label'         => esc_html__('Reveal Effect Animation', 'dipi-divi-pixel'),
            'description'   => esc_html__('Reveal effect animation style', 'dipi-divi-pixel'),
            'type'          => 'select',
            'tab_slug'        => 'advanced',
            'toggle_slug'     => "reveal_effect_style",
            'sub_toggle'     => "first_heading", 
             
            'show_if'         => ['use_reveal_effect' => 'on'],
            'default'       => 'dipiDHFadeOut',
            'options' => [
                'dipiDHFadeOut'   => esc_html__('Fade Out', 'dipi-divi-pixel'),
                'dipiDHSlideLeft'   => esc_html__('Slide Left', 'dipi-divi-pixel'),
                'dipiDHSlideRight'   => esc_html__('Slide Right', 'dipi-divi-pixel'),
                'dipiDHSlideUp'   => esc_html__('Slide Up', 'dipi-divi-pixel'),
                'dipiDHSlideDown'   => esc_html__('Slide Down', 'dipi-divi-pixel')
            ]
        ];

        $fields["fh_reveal_effect_animation_speed"] = [
            'label' => esc_html__( 'Animation Speed', 'dipi-divi-pixel' ),
            'type' => 'range',
            'unitless' => true,
            'default' => '0.6',
            'range_settings' => [
                'min'  => '0.2',
                'max'  => '2',
                'step' => '0.1',
            ],
            'tab_slug'        => 'advanced',
            'toggle_slug'     => "reveal_effect_style",
            'sub_toggle'     => "first_heading", 
            'show_if'         => ['use_reveal_effect' => 'on']
        ];

        $fields["fh_reveal_effect_animation_delay"] = [
            'label' => esc_html__( 'Animation Delay', 'dipi-divi-pixel' ),
            'type' => 'range',
            'unitless' => true,
            'default' => '0.2',
            'range_settings' => [
                'min'  => '0',
                'max'  => '2',
                'step' => '0.1',
            ],
            'tab_slug'        => 'advanced',
            'toggle_slug'     => "reveal_effect_style",
            'sub_toggle'     => "first_heading", 
            'show_if'         => ['use_reveal_effect' => 'on']
        ];
 
        $fields['sh_reveal_effect_color'] = [
            'label'           => esc_html__('Background', 'dipi-divi-pixel'),
            'type'            => 'background-field',
            'base_name'       => "sh_reveal_effect",
            'context'         => "sh_reveal_effect",
            'custom_color'    => true,
            'default'         => ET_Global_Settings::get_value('all_buttons_bg_color'),
            'tab_slug'        => 'advanced',
            'toggle_slug'     => "reveal_effect_style",
            'sub_toggle'     => "second_heading", 
            'show_if'         => ['use_reveal_effect' => 'on'],
          
            'background_fields' => array_merge(
                ET_Builder_Element::generate_background_options(
                    'sh_reveal_effect',
                    'gradient',
                    "advanced",
                    "reveal_effect_style",
                    "sh_reveal_effect_gradient"
                ),
                ET_Builder_Element::generate_background_options(
                    "sh_reveal_effect",
                    "color",
                    "advanced",
                    "reveal_effect_style",
                    "sh_reveal_effect_color"
                ) 
                
            ),
        ];

        $fields = array_merge($fields, $this->generate_background_options("sh_reveal_effect", 'skip', "advanced", "reveal_effect_style", "sh_reveal_effect_gradient"));

        $fields = array_merge( $fields, $this->generate_background_options( "sh_reveal_effect", 'skip', "advanced", "reveal_effect_style", "sh_reveal_effect_color"));
 
        $fields['sh_reveal_effect_animation'] = [
            'label'         => esc_html__('Reveal Effect Animation', 'dipi-divi-pixel'),
            'description'   => esc_html__('Reveal effect animation style', 'dipi-divi-pixel'),
            'type'          => 'select',
            'tab_slug'        => 'advanced',
            'toggle_slug'     => "reveal_effect_style",
            'sub_toggle'     => "second_heading", 
            'show_if'         => ['use_reveal_effect' => 'on'],
            'default'       => 'dipiDHFadeOut',
            'options' => [
                'dipiDHFadeOut'   => esc_html__('Fade Out', 'dipi-divi-pixel'),
                'dipiDHSlideLeft'   => esc_html__('Slide Left', 'dipi-divi-pixel'),
                'dipiDHSlideRight'   => esc_html__('Slide Right', 'dipi-divi-pixel'),
                'dipiDHSlideUp'   => esc_html__('Slide Up', 'dipi-divi-pixel'),
                'dipiDHSlideDown'   => esc_html__('Slide Down', 'dipi-divi-pixel')
            ]
        ];

        $fields["sh_reveal_effect_animation_speed"] = [
            'label' => esc_html__( 'Animation Speed', 'dipi-divi-pixel' ),
            'type' => 'range',
            'unitless' => true,
            'default' => '0.6',
            'range_settings' => [
                'min'  => '0.2',
                'max'  => '2',
                'step' => '0.1',
            ],
            'tab_slug'        => 'advanced',
            'toggle_slug'     => "reveal_effect_style",
            'sub_toggle'     => "second_heading", 
            'show_if'         => ['use_reveal_effect' => 'on']
        ];

        $fields["sh_reveal_effect_animation_delay"] = [
            'label' => esc_html__( 'Animation Delay', 'dipi-divi-pixel' ),
            'type' => 'range',
            'unitless' => true,
            'default' => '0.4',
            'range_settings' => [
                'min'  => '0',
                'max'  => '2',
                'step' => '0.1',
            ],
            'tab_slug'       => 'advanced',
            'toggle_slug'     => "reveal_effect_style",
            'sub_toggle'     => "second_heading", 
            'show_if'        => ['use_reveal_effect' => 'on']
        ];

        return $fields;
    }

    public function get_advanced_fields_config() {
        $advanced_fields = [];

        $advanced_fields['text'] = [
            'use_background_layout' => true,
            'options' => [
                'text_orientation' => [
                    'default' => 'center',
                    'default_on_front' => 'center'
                    ]
            ] 
        ];

        $advanced_fields['fonts']['first_heading'] = [
            'label' => esc_html__('First Heading', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-dh-first-heading",
                'font' => "%%order_class%% .dipi-dh-first-heading",
                'color' => "%%order_class%% .dipi-dh-first-heading",
                'hover' => "%%order_class%% .dipi-dh-first-heading:hover, %%order_class%% .dipi-dh-first-heading:hover",
                'color_hover' => "%%order_class%% .dipi-dh-first-heading:hover a",
                'important' => 'all',
            ],
            'text_align' => false,
            'font_size' => ['default' => '18px'],
            'line_height' => ['default' => '1.6em'],
            'tab_slug'      => 'advanced',
            'toggle_slug' => 'typography',
            'sub_toggle' => 'first_heading'
        ];

        $advanced_fields['fonts']['second_heading'] = [
            'label' => esc_html__('Second Heading', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-dh-second-heading",
                'font' => "%%order_class%% .dipi-dh-second-heading",
                'color' => "%%order_class%% .dipi-dh-second-heading",
                'hover' => "%%order_class%% .dipi-dh-second-heading:hover",
                'color_hover' => "%%order_class%% .dipi-dh-second-heading:hover a",
                'important' => 'all',
            ],
            'text_align' => false,
            'font_size' => ['default' => '18px'],
            'line_height' => ['default' => '1.6em'],
           
            'tab_slug'      => 'advanced',
            'toggle_slug' => 'typography',
            'sub_toggle' => 'second_heading'
        ];

        $advanced_fields['fonts']['background_text'] = [
            'label' => esc_html__('Background Text', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-dual-heading .dipi-dh-main::before",
                'font' => "%%order_class%% .dipi-dual-heading .dipi-dh-main::before",
                'color' => "%%order_class%% .dipi-dual-heading .dipi-dh-main::before",
                'hover' => "%%order_class%% .dipi-dual-heading .dipi-dh-main::before:hover",
                'color_hover' => "%%order_class%% .dipi-dual-heading .dipi-dh-main::before:hover",
                'important' => 'all'
            ],
            'text_align' => false,
            'font_size' => ['default' => '60px'],
            'line_height' => ['default' => '1.6em'],
            'text_color' => ['default' => '#eeeeee'],
            
            'tab_slug'      => 'advanced',
            'toggle_slug' => 'typography',
            'sub_toggle' => 'background',
            'show_if'   => ['use_background_text' => 'on']
        ];


        $advanced_fields['borders']['default'] = [];
        $advanced_fields['borders']['fh_border'] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-dual-heading .dipi-dh-first-heading",
                    'border_styles' => "%%order_class%% .dipi-dual-heading .dipi-dh-first-heading",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'first_heading_style'
        ];

        $advanced_fields['borders']['sh_border'] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-dual-heading .dipi-dh-second-heading",
                    'border_styles' => "%%order_class%% .dipi-dual-heading .dipi-dh-second-heading",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'second_heading_style'
        ];

        $advanced_fields['borders']['bt_border'] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-dh-main::before",
                    'border_styles' => "%%order_class%% .dipi-dh-main::before",
                ],
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'background_text_style'
        ];
        $advanced_fields['margin_padding'] = [
            'css' => array(
                'important' => 'all',
            )
        ];
        

        return $advanced_fields;
    }

    public function apply_css($render_slug) {
        $fh_style            = $this->props['fh_style'];
        $fh_background_style = $this->props['fh_background_style'];
        $use_reveal_effect   = $this->props['use_reveal_effect'];
        $sh_style            = $this->props['sh_style'];
        $sh_background_style = $this->props['sh_background_style'];
        $use_background_text = $this->props['use_background_text'];
        $first_heading_image = $this->props['first_heading_image'];
        $first_heading_size  = $this->props['first_heading_size'];
        $second_heading_image = $this->props['second_heading_image'];
        $second_heading_size  = $this->props['second_heading_size'];
        $fh_reveal_effect_animation       = $this->props['fh_reveal_effect_animation'];
        $fh_reveal_effect_animation_speed = $this->props['fh_reveal_effect_animation_speed'];
        $fh_reveal_effect_animation_delay = $this->props['fh_reveal_effect_animation_delay'];
        $sh_reveal_effect_animation       = $this->props['sh_reveal_effect_animation'];
        $sh_reveal_effect_animation_speed = $this->props['sh_reveal_effect_animation_speed'];
        $sh_reveal_effect_animation_delay = $this->props['sh_reveal_effect_animation_delay'];
        $fh_stroke_color = $this->props['fh_stroke_color'];
        $fh_stroke_fill  = $this->props['fh_stroke_fill'];
        $fh_stroke_width = $this->props['fh_stroke_width'];
        $sh_stroke_color = $this->props['sh_stroke_color'];
        $sh_stroke_fill  = $this->props['sh_stroke_fill'];
        $sh_stroke_width = $this->props['sh_stroke_width'];
        $first_heading_imagesize_x  = $this->props['first_heading_imagesize_x'];
        $first_heading_imagesize_y  = $this->props['first_heading_imagesize_y'];
        $first_heading_position     = $this->props['first_heading_position'];
        $second_heading_imagesize_x = $this->props['second_heading_imagesize_x'];
        $second_heading_imagesize_y = $this->props['second_heading_imagesize_y'];
        $second_heading_position    = $this->props['second_heading_position'];
        $background_text        = $this->props['background_text'];
        $bt_style = $this->props['bt_style'];
        $bt_position_horizontal = $this->props['bt_position_horizontal'];
        $bt_position_vertical   = $this->props['bt_position_vertical'];
        $bt_stroke_color = isset($this->props['bt_stroke_color']) ? $this->props['bt_stroke_color'] : '';
        $bt_stroke_fill  = $this->props['bt_stroke_fill'];
        $bt_stroke_width = $this->props['bt_stroke_width'];
      
    
        wp_enqueue_script('dipi_dual_heading_public');
        $this->appy_default_css($render_slug);
    
        $fh_selector = "%%order_class%% .dipi-dual-heading .dipi-dh-first-heading";
        $sh_selector = "%%order_class%% .dipi-dual-heading .dipi-dh-second-heading";
    
        if($fh_style === 'background'){
            $this->set_background_css($render_slug, $fh_selector . ' .dipi-dh-bg-container', $fh_selector . ':hover', 'first_heading', 'first_heading_color', false);
            if(!empty($first_heading_image) ){
                if($first_heading_size === 'percentage'){
                    $first_heading_size = $first_heading_imagesize_x . ' ' . $first_heading_imagesize_y;
                    $first_heading_position = '0% 0%';
                } else{
                    $first_heading_position = ($first_heading_position !== 'center')? implode(' ',  explode('_', $first_heading_position)): 'center';
                }
            }
        }
    
        if($fh_background_style == 'clipped'){
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $fh_selector . ' .dipi-dh-bg-container',
                'declaration' => "background-clip: text;-webkit-background-clip: text;color: transparent !important;"
            ]);
        }
    
        if($use_reveal_effect === 'on') {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $fh_selector . '::before, ' . $sh_selector . '::before',
                'declaration' => "content:'';"
            ]);
            
    
            $this->set_background_css($render_slug, $fh_selector . '::before' , $fh_selector . ':hover::before', 'fh_reveal_effect', 'fh_reveal_effect_color', false);
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-dual-heading.dipi-go-animation .dipi-dh-first-heading:before',
                'declaration' => sprintf(
                    'animation-name: %1$s;
                    animation-duration: %2$ss;
                    animation-delay: %3$ss;', 
                        $fh_reveal_effect_animation,
                        $fh_reveal_effect_animation_speed,
                        $fh_reveal_effect_animation_delay
                    )
            ]);
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-dual-heading.dipi-go-animation.dipi-dh-waypoint .dipi-dh-first-heading .dipi-dh-animation-container',
                'declaration' => sprintf(
                    'animation-name:dipiDHreveal;
                    animation-duration: %1$ss;
                    animation-delay: %2$ss;', 
                        $fh_reveal_effect_animation_speed / 2,
                        $fh_reveal_effect_animation_delay 
                    )
            ]);
    
            $this->set_background_css( $render_slug, $sh_selector . '::before', $sh_selector . ':hover::before', 'sh_reveal_effect', 'sh_reveal_effect_color', false);
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-dual-heading.dipi-go-animation .dipi-dh-second-heading:before',
                'declaration' => sprintf('animation-name: %1$s;animation-duration: %2$ss;animation-delay: %3$ss;', 
                        $sh_reveal_effect_animation,
                        $sh_reveal_effect_animation_speed,
                        $sh_reveal_effect_animation_delay
                    )
            ]);
    
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-dual-heading.dipi-go-animation.dipi-dh-waypoint .dipi-dh-second-heading .dipi-dh-animation-container',
                'declaration' => sprintf(
                    'animation-name:dipiDHreveal;
                    animation-duration: %1$ss;
                    animation-delay: %2$ss;', 
                        $sh_reveal_effect_animation_speed / 2,
                        $sh_reveal_effect_animation_delay 
                    )
            ]);
        }
    
        $rs_text_orientation = $this->dipi_get_responsive_prop('text_orientation');
        $rs_text_orientation_flex = [];
        foreach($rs_text_orientation as $view => $value){
            $rs_text_orientation_flex[$view] = $rs_text_orientation[$view];
            if($rs_text_orientation_flex[$view] === 'left') $rs_text_orientation_flex[$view] = 'flex-start';
            if($rs_text_orientation_flex[$view] === 'right') $rs_text_orientation_flex[$view] = 'flex-end';
        }
        $this->set_responsive_css($render_slug, '%%order_class%% .dipi-dh-main', 'justify-content', $rs_text_orientation_flex );
        $this->set_responsive_css($render_slug, '%%order_class%% .dipi-dh-main', 'text-align', $rs_text_orientation );
        $this->set_responsive_css($render_slug, '%%order_class%% .dipi-dh-main', 'align-items', $rs_text_orientation_flex );
    
        $rs_heading_display = $this->dipi_get_responsive_prop('heading_display');
        $this->set_responsive_css($render_slug, '%%order_class%% .dipi-dh-main', 'flex-direction', $rs_heading_display );
        
    
        // First Heading Style
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'fh_padding',
            'css_property'   => 'padding',
            'selector'       => $fh_selector . ' .dipi-dh-bg-container'
        ]);
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'fh_margin',
            'css_property'   => 'margin',
            'selector'       => $fh_selector  
        ]);

        if($fh_style == 'stroke'){
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $fh_selector,
                'declaration' => 
                sprintf('-webkit-text-stroke-color: %1$s;
                -webkit-text-fill-color: %2$s;
                -webkit-text-stroke-width: %3$spx;
                paint-order: stroke fill;', $fh_stroke_color, $fh_stroke_fill, $fh_stroke_width )
            ]);
        }
    
        // Second Heading Style
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'sh_padding',
            'css_property'   => 'padding',
            'selector'       => $sh_selector . ' .dipi-dh-bg-container'
        ]);
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'sh_margin',
            'css_property'   => 'margin',
            'selector'       => $sh_selector
        ]);
        
    
        if($sh_style == 'stroke'){
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $sh_selector,
                'declaration' => 
                sprintf('-webkit-text-stroke-color: %1$s;
                -webkit-text-fill-color: %2$s;
                -webkit-text-stroke-width: %3$spx;
                paint-order: stroke fill;', $sh_stroke_color, $sh_stroke_fill, $sh_stroke_width )
            ]);
        }
    
        if($sh_background_style == 'clipped'){
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $sh_selector . ' .dipi-dh-bg-container',
                'declaration' => "background-clip: text;-webkit-background-clip: text;color: transparent !important;"
            ]);
        }
    
        if($sh_style === 'background'){
            $this->set_background_css($render_slug, $sh_selector . ' .dipi-dh-bg-container', $sh_selector . ' span:hover', 'second_heading', 'second_heading_color', false);
            if(!empty($second_heading_image) ){
                if($second_heading_size === 'percentage'){
                    $second_heading_size = $second_heading_imagesize_x . ' ' . $second_heading_imagesize_y;
                    $second_heading_position = '0% 0%';
                } else{
                    $second_heading_position = ($second_heading_position !== 'center')? implode(' ',  explode('_', $second_heading_position)): 'center';
                }
            }
        }
    
        // Background Text Style
        if($use_background_text === 'on'){
            ET_Builder_Element::set_style($render_slug, [
                'selector' => "%%order_class%% .dipi-dh-main::before",
                'declaration' => sprintf('content: "%1$s";left:%2$s;top:%3$s;',
                    $background_text,
                    $bt_position_horizontal,
                    $bt_position_vertical
                 )
            ]);
            $rs_bt_position_horizontal = $this->dipi_get_responsive_prop('bt_position_horizontal');
            $rs_bt_position_vertical = $this->dipi_get_responsive_prop('bt_position_vertical');
            $this->set_responsive_css($render_slug, "%%order_class%% .dipi-dh-main::before", 'left', $rs_bt_position_horizontal );
            $this->set_responsive_css($render_slug, "%%order_class%% .dipi-dh-main::before", 'top', $rs_bt_position_vertical );
    
            if($bt_style == 'stroke'){
                ET_Builder_Element::set_style($render_slug, [
                    'selector' => $this->bt_selector,
                    'declaration' => 
                    sprintf('-webkit-text-stroke-color: %1$s;
                    -webkit-text-fill-color: %2$s;
                    -webkit-text-stroke-width: %3$spx;
                    paint-order: stroke fill;', $bt_stroke_color, $bt_stroke_fill, $bt_stroke_width )
                ]);
            }
        }
        $this->apply_common_styles ($render_slug, 'fh_', $fh_selector. ' .dipi-dh-bg-container');
        $this->apply_common_styles ($render_slug, 'sh_', $sh_selector. ' .dipi-dh-bg-container');
    
       
    }

    public function apply_common_styles ($render_slug, $prefix, $selector) {
        $style = $this->props[$prefix . 'style'];
        $background_animation = $this->props[$prefix . 'background_animation'];
        $animation_speed = $this->props[$prefix . 'background_animation_speed'];
        $animation_direction = $this->props[$prefix . 'background_animation_direction'];
        $animation_function = $this->props[$prefix . 'background_animation_function'];
     
        if($style == 'background' && $background_animation == 'on') {
            $declartion = sprintf('
                background-repeat:repeat !important;
                animation-name: %1$s;
                animation-duration: %2$ss;
                animation-iteration-count: infinite;
                animation-timing-function: %3$s;', 
            $animation_direction,
            $animation_speed,
            $animation_function );

            ET_Builder_Element::set_style($render_slug, [
                'selector' => $selector,
                'declaration' => $declartion 
            ]);
        }
    }

    public function appy_default_css($render_slug){
        $first_heading_font_size = $this->props['first_heading_font_size'];
        $first_heading_line_height = $this->props['first_heading_line_height'];
        $second_heading_font_size = $this->props['second_heading_font_size'];
        $second_heading_line_height = $this->props['second_heading_line_height'];
        $background_text_font_size = $this->props['background_text_font_size'];

        // First Heading
        if(!$first_heading_font_size || $first_heading_font_size === $this->default_settings['first_heading_font_size']){
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $this->fh_selector,
                'declaration' => sprintf('font-size: %1$s;', $this->default_settings['first_heading_font_size'])
            ]);
        }
        if(!isset($this->props['border_style_all_fh_border']) || empty($this->props['border_style_all_fh_border'])) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $this->fh_selector,
                'declaration' => "border-style: solid;"
            ]);
        }
        if(!$first_heading_line_height || $first_heading_line_height === $this->default_settings['first_heading_line_height']){
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $this->fh_selector,
                'declaration' => sprintf('line-height: %1$s;', $this->default_settings['first_heading_line_height'])
            ]);
        }
       
        // Second Heading
        if(!$second_heading_font_size || $second_heading_font_size === $this->default_settings['second_heading_font_size']){
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $this->sh_selector,
                'declaration' => sprintf('font-size: %1$s;', $this->default_settings['second_heading_font_size'])
            ]);
        }
        if(!isset($this->props['border_style_all_sh_border']) || empty($this->props['border_style_all_sh_border'])) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $this->sh_selector,
                'declaration' => "border-style: solid;"
            ]);
        }
        if(!$second_heading_line_height || $second_heading_line_height === $this->default_settings['second_heading_line_height']){
            ET_Builder_Element::set_style($render_slug, [
                'selector' => $this->sh_selector,
                'declaration' => sprintf('line-height: %1$s;', $this->default_settings['second_heading_line_height'])
            ]);
        }

        // Background Text
        if(!$background_text_font_size || $background_text_font_size === $this->default_settings['background_text_font_size']){
            ET_Builder_Element::set_style($render_slug, [
                'selector' => "%%order_class%% .dipi-dual-heading .dipi-dh-main, $this->bt_selector",
                'declaration' => sprintf('font-size: %1$s;', $this->default_settings['background_text_font_size'])
            ]);
        }
    }

    public function render($attrs, $content, $render_slug) {
        $this->apply_css($render_slug);
        $heading_tag = $this->props['heading_tag'];
        $use_reveal_effect = $this->props['use_reveal_effect'];
        $start_tag = '<' . $heading_tag . ' class="dipi-dh-main">';
        $end_tag = '</' . $heading_tag . '>';

        $extra_classes = '';
        if($use_reveal_effect === 'on') {
            $extra_classes .= 'dipi-dh-waypoint';
        }
        $output = sprintf('
                <div class="dipi-dual-heading %5$s">
                    %3$s
                        <span class="dipi-dh-first-heading">
                            <span class="dipi-dh-animation-container">
                                <span class="dipi-dh-bg-container">
                                    %1$s
                                </span>
                            </span>
                        </span>
                        <span class="dipi-dh-second-heading">
                            <span class="dipi-dh-animation-container">
                                <span class="dipi-dh-bg-container">
                                    %2$s
                                </span>
                            </span>
                        </span>
                    %4$s
                </div>',
            $this->props['first_heading'],
            $this->props['second_heading'],
            $start_tag,
            $end_tag,
            $extra_classes );
        return $output;
    }
}

new DIPI_DualHeading;