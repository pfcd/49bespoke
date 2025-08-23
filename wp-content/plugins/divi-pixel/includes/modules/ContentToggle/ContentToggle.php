<?php
class DIPI_ContentToggle extends DIPI_Builder_Module {

    public $slug       = 'dipi_content_toggle';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/contenttoggle',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );
    public function init() {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__( 'Pixel Content Toggle', 'dipi-divi-pixel' );
        $this->main_css_element = '%%order_class%%.dipi_content_toggle';

        $this->custom_css_fields = [
            'toggle_button_container' => array(
                'label' => esc_html__('Toggle Container', 'dipi-divi-pixel'),
                'selector' => '.dipi-content-toggle__button-container',
            ),
            'toggle_button_slider' => array(
                'label' => esc_html__('Toggle Button Container', 'dipi-divi-pixel'),
                'selector' => '.dipi-content-toggle__button-container .dipi-content-toggle__slider',
            ),
            'toggle_button_inner_slider' => array(
                'label' => esc_html__('Toggle Button', 'dipi-divi-pixel'),
                'selector' => '.dipi-content-toggle__button-container .dipi-content-toggle__slider:before',
            ),
        ];
    }
    
    public static function get_divi_library_shortcode( $args = [] )
    {
        $id = isset($args['first_divi_library']) && $args['first_divi_library'] !== '0'? 
            $args['first_divi_library'] :
            (isset($args['second_divi_library']) && $args['second_divi_library'] !== '0' ? $args['second_divi_library'] : '');
        
        return DIPI_Builder_Module::render_library_layout($id);
    }    
    public function get_settings_modal_toggles() {
		$toggles['general']['toggles'] = [
            'toggle_setting'  => esc_html__('Toggle Setting', 'dipi-divi-pixel'),
            'content_animation' => [
                'title' => esc_html__( 'Content Animation', 'dipi-divi-pixel'),
                'sub_toggles' => [
                    'first' => [
                        'name' => 'First',
                    ],
                    'second' => [
                        'name' => 'Second',
                    ]
                ],
                'tabbed_subtoggles' => true,
            ],
            'content_lazyload' => [
                'title' => esc_html__( 'Content Lazyload', 'dipi-divi-pixel'),
                'sub_toggles' => [
                    'first' => [
                        'name' => 'First',
                    ],
                    'second' => [
                        'name' => 'Second',
                    ]
                ],
                'tabbed_subtoggles' => true,
            ]
        ];
        $toggles['advanced']['toggles'] = [
            'toggle_setting' => [
                'title' => esc_html__( 'Toggle Setting', 'dipi-divi-pixel'),
            ],
            'toggle_text' => [
                'title' => esc_html__( 'Toggle Text', 'dipi-divi-pixel'),
                'sub_toggles' => [
                    'first' => [
                        'name' => 'First',
                    ],
                    'second' => [
                        'name' => 'Second',
                    ]
                ],
                'tabbed_subtoggles' => true,
            ],
            'toggle_button' => [
                'title' => esc_html__( 'Toggle Button', 'dipi-divi-pixel'),
                'sub_toggles' => [
                    'first' => [
                        'name' => 'First',
                    ],
                    'second' => [
                        'name' => 'Second',
                    ]
                ],
                'tabbed_subtoggles' => true,
            ]
        ];
		return $toggles;
	}

	public function get_fields() {
    $fields = [];

    $fields['first_text'] = [
        'label' => esc_html__('First Text', 'dipi-divi-pixel'),
        'type' => 'text',
        'option_category' => 'basic_option',
        'description' => esc_html__('First text of content Toggle.', 'dipi-divi-pixel'),
        'toggle_slug' => 'toggle_setting',
        'dynamic_content' => 'text',
        'hover' => 'tabs',
    ];
    $fields["first_divi_library"] = [
        'label'            => esc_html__('First Divi Library', 'dipi-divi-pixel'),
        'options'          => $this->get_divi_layouts(),
        'type'             => 'select',
        'computed_affects' => [
            '__FirstlibraryShortcodeHtml',
        ],
        'toggle_slug' => 'toggle_setting',
    ];
    $fields['second_text'] = [
        'label' => esc_html__('Second Text', 'dipi-divi-pixel'),
        'type' => 'text',
        'option_category' => 'basic_option',
        'description' => esc_html__('Second text of content Toggle.', 'dipi-divi-pixel'),
        'toggle_slug' => 'toggle_setting',
        'dynamic_content' => 'text',
        'hover' => 'tabs',
    ];
    $fields["second_divi_library"] = [
        'label'            => esc_html__('Second Divi Library', 'dipi-divi-pixel'),
        'options'          => $this->get_divi_layouts(),
        'type'             => 'select',
        'computed_affects' => [
            '__SecondlibraryShortcodeHtml',
        ],
        'toggle_slug' => 'toggle_setting',
    ];      
    $fields["__FirstlibraryShortcodeHtml"] = [
        'type' => 'computed',
        'computed_callback' => ['DIPI_ContentToggle', 'get_divi_library_shortcode'],
        'computed_depends_on' => [
            'first_divi_library'
        ]
    ];
    $fields["__SecondlibraryShortcodeHtml"] = [
        'type' => 'computed',
        'computed_callback' => ['DIPI_ContentToggle', 'get_divi_library_shortcode'],
        'computed_depends_on' => [
            'second_divi_library'
        ]
    ];
    $fields["toggle_alignment"] = [
        'label' => esc_html__('Toggle Alignment', 'dipi-divi-pixel'),
        'type' => 'text_align',
        'tab_slug' => 'advanced',
        'option_category'  => 'configuration',
        'options' => et_builder_get_text_orientation_options(['justified']),
        'options_icon' => 'module_align',
        'toggle_slug' => 'toggle_setting',
        'sticky' => true,
    ];
    $fields["toggle_size"] = [
        'label' => esc_html__('Toggle Size', 'dipi-divi-pixel'),
        'type' => 'range',
        'tab_slug' => 'advanced',
        'toggle_slug' => 'toggle_setting',
        'default'         => '14px',
		'default_unit'    => 'px',
        'sticky' => true,
        'mobile_options'  => true,
    ];
    $fields["first_btn_color"] = [
        'label' => esc_html__('Button Color', 'dipi-divi-pixel'),
        'type' => 'color-alpha',
        'description' => esc_html__('Here you can define a custom color for your First Toggle button.', 'dipi-divi-pixel'),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'toggle_button',
        'sub_toggle'  => 'first',
        'hover' => 'tabs',
        'sticky' => true,
        'default' => '#fff'
    ];
    $fields["first_bg_color"] = [
        'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
        'type' => 'color-alpha',
        'description' => esc_html__('Here you can define a custom background color for your First Toggle button.', 'dipi-divi-pixel'),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'toggle_button',
        'sub_toggle'  => 'first',
        'hover' => 'tabs',
        'sticky' => true,
        'default' => '#d3d3d3'
    ];
    $fields["second_btn_color"] = [
        'label' => esc_html__('Button Color', 'dipi-divi-pixel'),
        'type' => 'color-alpha',
        'description' => esc_html__('Here you can define a color for your First Toggle button.', 'dipi-divi-pixel'),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'toggle_button',
        'sub_toggle'  => 'second',
        'hover' => 'tabs',
        'sticky' => true,
        'default' => '#fff'
    ];
    $fields["second_bg_color"] = [
        'label' => esc_html__('Background Color', 'dipi-divi-pixel'),
        'type' => 'color-alpha',
        'description' => esc_html__('Here you can define a custom background color for your First Toggle button.', 'dipi-divi-pixel'),
        'tab_slug' => 'advanced',
        'toggle_slug' => 'toggle_button',
        'sub_toggle'  => 'second',
        'hover' => 'tabs',
        'sticky' => true,
        'default' => '#ff4200'
    ];
    $fields["first_content_animation"] = [
        'label'            => esc_html__('Content Animations', 'dipi-divi-pixel'),
        'type'             => 'select',
        'default'          => 'fadeIn',
        'options' => [
            'fadeIn'  => esc_html__('Fade In', 'dipi-divi-pixel'),
                'fadeInLeftShort'  => esc_html__('FadeIn Left', 'dipi-divi-pixel'),
                'fadeInRightShort' => esc_html__('FadeIn Right', 'dipi-divi-pixel'),
                'fadeInUpShort'    => esc_html__('FadeIn Up', 'dipi-divi-pixel'),
                'fadeInDownShort'  => esc_html__('FadeIn Down', 'dipi-divi-pixel'),
                'zoomInShort'       => esc_html__('Grow', 'dipi-divi-pixel'),
                'bounceInShort' => esc_html__('BounceIn', 'dipi-divi-pixel'),
                'bounceInLeftShort' => esc_html__('BounceIn Left', 'dipi-divi-pixel'),
                'bounceInRightShort' => esc_html__('BounceIn Right', 'dipi-divi-pixel'),
                'bounceInUpShort' => esc_html__('BounceIn Up', 'dipi-divi-pixel'),
                'bounceInDownShort' => esc_html__('BounceIn Down', 'dipi-divi-pixel'),
                'flipInXShort' => esc_html__('FlipInX', 'dipi-divi-pixel'),
                'flipInYShort' => esc_html__('FlipInY', 'dipi-divi-pixel'),
                'jackInTheBoxShort' => esc_html__('JackInTheBox', 'dipi-divi-pixel'),
                'rotateInShort'  => esc_html__('RotateIn', 'dipi-divi-pixel'),
                'rotateInDownLeftShort' => esc_html__('RotateIn DownLeft', 'dipi-divi-pixel'),
                'rotateInUpLeftShort' => esc_html__('RotateIn UpLeft', 'dipi-divi-pixel'),
                'rotateInDownRightShort' => esc_html__('RotateIn DownRight', 'dipi-divi-pixel'),
                'rotateInUpRightShort' => esc_html__('RotateIn UpRight', 'dipi-divi-pixel'),
        ],
        'toggle_slug' => 'content_animation',
        'sub_toggle'  => 'first',
    ];
    $fields['first_content_delay'] = [
        'label' => esc_html__('Interval Delay', 'dipi-divi-pixel'),
        'type' => 'range',
        'option_category' => 'configuration',
        'default' => '100ms',
        'default_on_front' => '100ms',
        'default_unit' => 'ms',
        'range_settings' => [
            'min' => '0',
            'max' => '3000',
            'step' => '100',
        ],
        'validate_unit' => true,
        'toggle_slug' => 'content_animation',
        'sub_toggle'  => 'first', 
         
    ];

    $fields['first_content_speed'] = [
        'label' => esc_html__('Speed', 'dipi-divi-pixel'),
        'type' => 'range',
        'option_category' => 'configuration',
        'default' => '600ms',
        'default_on_front' => '600ms',
        'default_unit' => 'ms',
        'range_settings' => [
            'min' => '0',
            'max' => '2000',
            'step' => '100',
        ],
        'validate_unit' => true,
        'toggle_slug' => 'content_animation',
        'sub_toggle'  => 'first',
        
    ];
    $fields["second_content_animation"] = [
        'label'            => esc_html__('Content Animations', 'dipi-divi-pixel'),
        'type'             => 'select',
        'default'          => 'fadeIn',
        'options' => [
            'fadeIn'  => esc_html__('Fade In', 'dipi-divi-pixel'),
                'fadeInLeftShort'  => esc_html__('FadeIn Left', 'dipi-divi-pixel'),
                'fadeInRightShort' => esc_html__('FadeIn Right', 'dipi-divi-pixel'),
                'fadeInUpShort'    => esc_html__('FadeIn Up', 'dipi-divi-pixel'),
                'fadeInDownShort'  => esc_html__('FadeIn Down', 'dipi-divi-pixel'),
                'zoomInShort'       => esc_html__('Grow', 'dipi-divi-pixel'),
                'bounceInShort' => esc_html__('BounceIn', 'dipi-divi-pixel'),
                'bounceInLeftShort' => esc_html__('BounceIn Left', 'dipi-divi-pixel'),
                'bounceInRightShort' => esc_html__('BounceIn Right', 'dipi-divi-pixel'),
                'bounceInUpShort' => esc_html__('BounceIn Up', 'dipi-divi-pixel'),
                'bounceInDownShort' => esc_html__('BounceIn Down', 'dipi-divi-pixel'),
                'flipInXShort' => esc_html__('FlipInX', 'dipi-divi-pixel'),
                'flipInYShort' => esc_html__('FlipInY', 'dipi-divi-pixel'),
                'jackInTheBoxShort' => esc_html__('JackInTheBox', 'dipi-divi-pixel'),
                'rotateInShort'  => esc_html__('RotateIn', 'dipi-divi-pixel'),
                'rotateInDownLeftShort' => esc_html__('RotateIn DownLeft', 'dipi-divi-pixel'),
                'rotateInUpLeftShort' => esc_html__('RotateIn UpLeft', 'dipi-divi-pixel'),
                'rotateInDownRightShort' => esc_html__('RotateIn DownRight', 'dipi-divi-pixel'),
                'rotateInUpRightShort' => esc_html__('RotateIn UpRight', 'dipi-divi-pixel'),
        ],
        'toggle_slug' => 'content_animation',
        'sub_toggle'  => 'second',
    ];
    $fields['second_content_delay'] = [
        'label' => esc_html__('Interval Delay', 'dipi-divi-pixel'),
        'type' => 'range',
        'option_category' => 'configuration',
        'default' => '100ms',
        'default_on_front' => '100ms',
        'default_unit' => 'ms',
        'range_settings' => [
            'min' => '0',
            'max' => '3000',
            'step' => '100',
        ],
        'validate_unit' => true,
        'toggle_slug' => 'content_animation',
        'sub_toggle'  => 'second', 
         
    ];

    $fields['second_content_speed'] = [
        'label' => esc_html__('Speed', 'dipi-divi-pixel'),
        'type' => 'range',
        'option_category' => 'configuration',
        'default' => '600ms',
        'default_on_front' => '600ms',
        'default_unit' => 'ms',
        'range_settings' => [
            'min' => '0',
            'max' => '2000',
            'step' => '100',
        ],
        'validate_unit' => true,
        'toggle_slug' => 'content_animation',
        'sub_toggle'  => 'second',
        
    ];
    $fields['first_disable_browser_lazyload'] = [
        'label' => esc_html__('Disable Browser Lazyload', 'dipi-divi-pixel'),
        'type' => 'yes_no_button',
        'option_category' => 'configuration',
        'options' => array(
            'off' => esc_html__('No', 'dipi-divi-pixel'),
            'on' => esc_html__('Yes', 'dipi-divi-pixel'),
        ),
        'toggle_slug' => 'content_lazyload',
        'sub_toggle'  => 'first',
        'description' => esc_html__('Will remove loading="lazy" attribute from img tag', 'dipi-divi-pixel'),
        'default_on_front' => 'off',
    ];
    $fields['first_disable_wprocket_lazyload'] = [
        'label' => esc_html__('Disable WP Rocket Lazyload', 'dipi-divi-pixel'),
        'type' => 'yes_no_button',
        'option_category' => 'configuration',
        'options' => array(
            'off' => esc_html__('No', 'dipi-divi-pixel'),
            'on' => esc_html__('Yes', 'dipi-divi-pixel'),
        ),
        'toggle_slug' => 'content_lazyload',
        'sub_toggle'  => 'first',
        'description' => esc_html__('Will add class "skip-lazy" into img tag', 'dipi-divi-pixel'),
        'default_on_front' => 'off',
    ];    
    $fields['second_disable_browser_lazyload'] = [
        'label' => esc_html__('Disable Browser Lazyload', 'dipi-divi-pixel'),
        'type' => 'yes_no_button',
        'option_category' => 'configuration',
        'options' => array(
            'off' => esc_html__('No', 'dipi-divi-pixel'),
            'on' => esc_html__('Yes', 'dipi-divi-pixel'),
        ),
        'toggle_slug' => 'content_lazyload',
        'sub_toggle'  => 'second',
        'description' => esc_html__('Will remove loading="lazy" attribute from img tag', 'dipi-divi-pixel'),
        'default_on_front' => 'off',
    ];
    $fields['second_disable_wprocket_lazyload'] = [
        'label' => esc_html__('Disable WP Rocket Lazyload', 'dipi-divi-pixel'),
        'type' => 'yes_no_button',
        'option_category' => 'configuration',
        'options' => array(
            'off' => esc_html__('No', 'dipi-divi-pixel'),
            'on' => esc_html__('Yes', 'dipi-divi-pixel'),
        ),
        'toggle_slug' => 'content_lazyload',
        'sub_toggle'  => 'second',
        'description' => esc_html__('Will add class "skip-lazy" into img tag', 'dipi-divi-pixel'),
        'default_on_front' => 'off',
    ];       
    return $fields;
  }

  public function get_advanced_fields_config() {
    $advanced_fields = [
        'text' => false,
        'text_shadow' => false,
    ];

    $advanced_fields['fonts']['first'] = [
        'label' => esc_html__('Title', 'dipi-divi-pixel'),
        'css' => array(
            'main' => "{$this->main_css_element} .dipi-content-toggle__button-container .dipi-content-toggle__first-text h1,
            {$this->main_css_element} .dipi-content-toggle__button-container .dipi-content-toggle__first-text h2,
            {$this->main_css_element} .dipi-content-toggle__button-container .dipi-content-toggle__first-text h3,
            {$this->main_css_element} .dipi-content-toggle__button-container .dipi-content-toggle__first-text h4,
            {$this->main_css_element} .dipi-content-toggle__button-container .dipi-content-toggle__first-text h5,
            {$this->main_css_element} .dipi-content-toggle__button-container .dipi-content-toggle__first-text h6
            ",
            'hover' => "{$this->main_css_element}:hover .dipi-content-toggle__button-container .dipi-content-toggle__first-text h1,
            {$this->main_css_element}:hover .dipi-content-toggle__button-container .dipi-content-toggle__first-text h2,
            {$this->main_css_element}:hover .dipi-content-toggle__button-container .dipi-content-toggle__first-text h3,
            {$this->main_css_element}:hover .dipi-content-toggle__button-container .dipi-content-toggle__first-text h4,
            {$this->main_css_element}:hover .dipi-content-toggle__button-container .dipi-content-toggle__first-text h5,
            {$this->main_css_element}:hover .dipi-content-toggle__button-container .dipi-content-toggle__first-text h6
            ",
        ),
        'header_level' => array(
            'default' => 'h5',
        ),
        'toggle_slug' => 'toggle_text',
        'sub_toggle' => 'first',
    ];
    $advanced_fields['fonts']['second'] = [
        'label' => esc_html__('Title', 'dipi-divi-pixel'),
        'css' => array(
            'main' => "{$this->main_css_element} .dipi-content-toggle__button-container .dipi-content-toggle_second-text h1,
            {$this->main_css_element} .dipi-content-toggle__button-container .dipi-content-toggle_second-text h2,
            {$this->main_css_element} .dipi-content-toggle__button-container .dipi-content-toggle_second-text h3,
            {$this->main_css_element} .dipi-content-toggle__button-container .dipi-content-toggle_second-text h4,
            {$this->main_css_element} .dipi-content-toggle__button-container .dipi-content-toggle_second-text h5,
            {$this->main_css_element} .dipi-content-toggle__button-container .dipi-content-toggle_second-text h6
            ",
            'hover' => "{$this->main_css_element}:hover .dipi-content-toggle__button-container .dipi-content-toggle_second-text h1,
            {$this->main_css_element}:hover .dipi-content-toggle__button-container .dipi-content-toggle_second-text h2,
            {$this->main_css_element}:hover .dipi-content-toggle__button-container .dipi-content-toggle_second-text h3,
            {$this->main_css_element}:hover .dipi-content-toggle__button-container .dipi-content-toggle_second-text h4,
            {$this->main_css_element}:hover .dipi-content-toggle__button-container .dipi-content-toggle_second-text h5,
            {$this->main_css_element}:hover .dipi-content-toggle__button-container .dipi-content-toggle_second-text h6

            ",
        ),
        'header_level' => array(
            'default' => 'h5',
        ),
        'toggle_slug' => 'toggle_text',
        'sub_toggle' => 'second',
    ];
    return $advanced_fields;
  }

  public function render( $attrs, $content, $render_slug ) {
    wp_enqueue_script('dipi_content_toggle_public');
    wp_enqueue_style('dipi_animate');
    $first_text = $this->props['first_text'];
    $second_text = $this->props['second_text'];
    $first_divi_library           = $this->props['first_divi_library'];
    $first_divi_library_shortcode = self::get_divi_library_shortcode([ 'first_divi_library' => $first_divi_library ]); //FIXME: Can this cause duplicated css or other issues? Maybe here we shiould only do do_shortcode like in carousel nad imagehotspot
    $second_divi_library           = $this->props['second_divi_library'];
    $second_divi_library_shortcode = self::get_divi_library_shortcode([ 'second_divi_library' => $second_divi_library ]); //FIXME: Can this cause duplicated css or other issues? Maybe here we shiould only do do_shortcode like in carousel nad imagehotspot
    $first_content_animation = $this->props['first_content_animation'];
    $first_content_delay = $this->props['first_content_delay'];
    $first_content_speed = $this->props['first_content_speed'];
    $second_content_animation = $this->props['second_content_animation'];
    $second_content_delay = $this->props['second_content_delay'];
    $second_content_speed = $this->props['second_content_speed'];
    $first_disable_browser_lazyload = $this->props['first_disable_browser_lazyload'] === 'on' ? 'disable_browser_lazyload' : '';
    $second_disable_browser_lazyload = $this->props['second_disable_browser_lazyload'] === 'on' ? 'disable_browser_lazyload' : '';
    $first_disable_wprocket_lazyload = $this->props['first_disable_wprocket_lazyload'] === 'on' ? 'disable_wprocket_lazyload' : '';;
    $second_disable_wprocket_lazyload = $this->props['second_disable_wprocket_lazyload'] === 'on' ? 'disable_wprocket_lazyload' : '';;

    $first_btn_selector = '%%order_class%% .dipi-content-toggle__button .dipi-content-toggle__slider:before';
    $first_bg_selector = '%%order_class%% .dipi-content-toggle__slider';
    $second_btn_selector = '%%order_class%% input.dipi-content-toggle__switch:checked + .dipi-content-toggle__slider:before';
    $second_bg_selector = '%%order_class%% input.dipi-content-toggle__switch:checked + .dipi-content-toggle__slider';
    $first_content_selector = '%%order_class%% .dipi-content-toggle__first-layout';
    $second_content_selector = '%%order_class%% .dipi-content-toggle__second-layout';
    $toggle_alignment = $this->props['toggle_alignment'];
    $toggle_alignment = $toggle_alignment === 'left' ? 'flex-start' :
        ($toggle_alignment === 'right' ? 'flex-end' : 'center');
    $first_level = $this->props['first_level'];
    $second_level = $this->props['second_level'];
    ET_Builder_Element::set_style($this->slug, array(
        'selector' => '%%order_class%% .dipi-content-toggle__button-container',
        'declaration' => "justify-content: $toggle_alignment;"
    ));

    $this->generate_styles(
        array(
            'base_attr_name' => 'toggle_size',
            'selector' => '%%order_class%% .dipi-content-toggle__button',
            'css_property' => 'font-size',
            'render_slug' => $render_slug,
            'type' => 'range',
        )
    );
    $this->generate_styles(
        array(
            'base_attr_name' => 'first_btn_color',
            'selector' => $first_btn_selector,
            'css_property' => 'background-color',
            'render_slug' => $render_slug,
            'type' => 'color',
        )
    );
    $this->generate_styles(
        array(
            'base_attr_name' => 'first_bg_color',
            'selector' => $first_bg_selector,
            'css_property' => 'background-color',
            'render_slug' => $render_slug,
            'type' => 'color',
        )
    );
    
    $this->generate_styles(
        array(
            'base_attr_name' => 'second_btn_color',
            'selector' => $second_btn_selector,
            'css_property' => 'background-color',
            'render_slug' => $render_slug,
            'type' => 'color',
        )
    );
    $this->generate_styles(
        array(
            'base_attr_name' => 'second_bg_color',
            'selector' => $second_bg_selector,
            'css_property' => 'background-color',
            'render_slug' => $render_slug,
            'type' => 'color',
        )
    );
    ET_Builder_Element::set_style($render_slug, [
        'selector' => $first_content_selector,
        'declaration' => "animation-duration: {$first_content_speed} !important;",
    ]);
    ET_Builder_Element::set_style($render_slug, [
        'selector' => $first_content_selector,
        'declaration' => "animation-delay: {$first_content_delay} !important;",
    ]);
    ET_Builder_Element::set_style($render_slug, [
        'selector' => $second_content_selector,
        'declaration' => "animation-duration: {$second_content_speed} !important;",
    ]);
    ET_Builder_Element::set_style($render_slug, [
        'selector' => $second_content_selector,
        'declaration' => "animation-delay: {$second_content_delay} !important;",
    ]);
    return sprintf('
        <div class="dipi_content_toggle dipi-content-toggle-container">
            <div class="dipi-content-toggle__button-container">
                <div class="dipi-content-toggle__text dipi-content-toggle__first-text">
                    <%11$s>%1$s</%11$s>
                </div>
                <div class="dipi-content-toggle__button">
                    <input class="dipi-content-toggle__switch" type="checkbox">
                    <div class="dipi-content-toggle__slider"></div>
                </div>
                <div class="dipi-content-toggle__text dipi-content-toggle_second-text">
                    <%12$s>%2$s</%12$s>
                </div>
            </div>
            <div class="dipi-content-toggle__content dipi-content-toggle__first-layout animated %5$s %7$s %9$s">
                %3$s
            </div>
            <div class="dipi-content-toggle__content dipi-content-toggle__second-layout animated %6$s %8$s $10$s">
                %4$s
            </div>
        </div>
        ',
        $first_text,
        $second_text,
        $first_divi_library_shortcode,
        $second_divi_library_shortcode,
        $first_content_animation, #5
        $second_content_animation,
        $first_disable_browser_lazyload,
        $second_disable_browser_lazyload,
        $first_disable_wprocket_lazyload,
        $second_disable_wprocket_lazyload, #10
        et_pb_process_header_level($first_level, 'h5'),
        et_pb_process_header_level($second_level, 'h5')
    );
  }


}
new DIPI_ContentToggle;
