<?php

class DIPI_AdvancedTabs extends DIPI_Builder_Module
{
    protected $module_credits = [
        'module_uri' => 'https://divi-pixel.com/modules/advanced-tabs',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    ];

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->slug = 'dipi_advanced_tabs';
        $this->child_slug = 'dipi_advanced_tabs_item';
        $this->vb_support = 'on';
        $this->name = esc_html__('Pixel Advanced Tabs', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%.dipi_advanced_tabs';
    }

    public function get_custom_css_fields_config()
    {

        $fields = [];

        
        $fields['tabs_container'] = [
            'label' => esc_html__('Tabs Container', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-at-tabs-container',
        ];

        $fields['content_container'] = [
            'label' => esc_html__('Content Container', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-at-panels',
        ];

        $fields['normal_tab'] = [
            'label' => esc_html__('Normal Tab', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-at-tabs-container .dipi-at-tabs .dipi-at-tab:not(.dipi-at-panel--active)'
        ];
        $fields['active_tab'] = [
            'label' => esc_html__('Active Tab', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-at-tabs-container .dipi-at-tabs .dipi-at-tab.dipi-at-panel--active'
        ];
        
        
        return $fields;
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'tabs_settings'         => esc_html__('Tabs Settings', 'dipi-divi-pixel'),
                    'tabs_background'        => esc_html__('Tabs Container Background', 'dipi-divi-pixel'),
                    'content_background'    => esc_html__('Content Container Background', 'dipi-divi-pixel'),
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                     
                    'tabs_items'      => esc_html__('Tabs Container Settings', 'dipi-divi-pixel'),
                    'content_wrapper' => esc_html__('Content Area Settings', 'dipi-divi-pixel'),
                    'at_item'         => [
                        'title'             => esc_html__('Tabs Item', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => array(
							'normal'     => array(
								'name' => esc_html__('Normal', 'dipi-divi-pixel')
							),
							'active'     => array(
								'name' => esc_html__('Active', 'dipi-divi-pixel')
							)
						)
                    ],  
                    'tabs_text'       => array(
                        'title'             => esc_html__('Tabs Item Text', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => array(
							'title'     => array(
								'name' => 'Title'
							),
							'subtitle'     => array(
								'name' => 'Description'
							)
						)
                    ),
                    'tabs_text_active'      => array(
                        'title'             => esc_html__('Tabs Item Text Active', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => array(
							'title'     => array(
								'name' => 'Title'
							),
							'subtitle'     => array(
								'name' => 'Description'
							)
						)
                    ),
                    'tabs_active_arrow'      => esc_html__('Tabs Active Arrow', 'dipi-divi-pixel'),
                    
					'header' => array(
						'title'             => esc_html__( 'Heading Text', 'et_builder' ),
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
						),
                    ),
                   
                    'custom_spacing'        => array(
                        'title'             => esc_html__('Custom Spacing', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => array(
                            'wrapper'   => array(
                                'name' => 'Wrapper',
                            ),
                            'content'     => array(
                                'name' => 'Content',
                            )
                        )
                    ),
                    'navigation' => esc_html__('Tabs Slider Nav', 'dipi-divi-pixel'),
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
        $advanced_fields = array();
        $advanced_fields['link_options'] = false;
        $advanced_fields['text'] = false;
        $advanced_fields['background'] = [
            'css' => [
                'main'        => "%%order_class%%.dipi_advanced_tabs",
                'hover'        => "%%order_class%%.dipi_advanced_tabs:hover"
            ]
        ];
        $advanced_fields['fonts']  = array(
          
            'title'     => array(
                'label'           => et_builder_i18n( 'Title' ),
                'css'             => array(
                    'main'        => "%%order_class%% .dipi-at-tabs .dipi-at-tab .dipi-at-tab-title",
                    'hover'        => "%%order_class%% .dipi-at-tabs .dipi-at-tab:hover .dipi-at-tab-title"
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => '16px',
                ),
                'toggle_slug'     => 'tabs_text',
                'sub_toggle'      => 'title'
            ),
            'title_active'     => array(
                'label'           => et_builder_i18n( 'Title' ),
                'css'             => array(
                    'main'        => "%%order_class%% .dipi-at-tabs .dipi-at-tab.dipi-at-tab--active .dipi-at-tab-title",
                    'hover'        => "%%order_class%% .dipi-at-tabs .dipi-at-tab.dipi-at-tab--active:hover .dipi-at-tab-title"
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => '16px',
                ),
                'toggle_slug'     => 'tabs_text_active',
                'sub_toggle'      => 'title'
            ),
            'subtitle'     => array(
                'label'           => et_builder_i18n( 'Description' ),
                'css'             => array(
                    'main'        => "%%order_class%% .dipi-at-tabs .dipi-at-tab .dipi-at-tab-subtitle",
                    'hover'        => "%%order_class%% .dipi-at-tabs .dipi-at-tab:hover .dipi-at-tab-subtitle"
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
                ),
                'toggle_slug'     => 'tabs_text',
                'sub_toggle'      => 'subtitle'
            ),
            'subtitle_active'     => array(
                'label'           => et_builder_i18n( 'Description' ),
                'css'             => array(
                    'main'        => "%%order_class%% .dipi-at-tabs .dipi-at-tab.dipi-at-tab--active .dipi-at-tab-subtitle",
                    'hover'        => "%%order_class%% .dipi-at-tabs .dipi-at-tab.dipi-at-tab--active:hover .dipi-at-tab-subtitle"
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
                ),
                'toggle_slug'     => 'tabs_text_active',
                'sub_toggle'      => 'subtitle'
            ),
            'body'       => array(
                'label'          => et_builder_i18n( 'Body' ),
                 
                'css'            => array(
                    'main'         => "{$this->main_css_element} .dipi-at-panel, %%order_class%%.et_pb_bg_layout_light .et_pb_post .dipi-at-panel p, %%order_class%%.et_pb_bg_layout_dark .et_pb_post .dipi-at-panel p",
                    'color'        => "{$this->main_css_element} .dipi-at-panel ",
                    'line_height'  => "{$this->main_css_element} .dipi-at-panel p",
                    'limited_main' => "{$this->main_css_element} .dipi-at-panel, %%order_class%%.et_pb_bg_layout_light .et_pb_post .dipi-at-panel p, %%order_class%%.et_pb_bg_layout_dark .et_pb_post .dipi-at-panel p, %%order_class%%.et_pb_bg_layout_light .et_pb_post a.more-link, %%order_class%%.et_pb_bg_layout_dark .et_pb_post a.more-link",
                    'hover'        => "{$this->main_css_element} .dipi-at-panel:hover, %%order_class%%.et_pb_bg_layout_light:hover .et_pb_post .dipi-at-panel p, %%order_class%%.et_pb_bg_layout_dark:hover .et_pb_post .dipi-at-panel p",
                    'color_hover'  => "{$this->main_css_element} .dipi-at-panel:hover ",
                ),
                'block_elements' => array(
                    'tabbed_subtoggles' => true,
                    'bb_icons_support'  => true,
                    'css'               => array(
                        'link'           => "{$this->main_css_element} .dipi-at-panel a, %%order_class%%.et_pb_bg_layout_light .et_pb_post .dipi-at-panel a, %%order_class%%.et_pb_bg_layout_dark .et_pb_post .dipi-at-panel a",
                        'ul'             => "{$this->main_css_element} .dipi-at-panel ul li, %%order_class%%.et_pb_bg_layout_light .et_pb_post .dipi-at-panel ul li, %%order_class%%.et_pb_bg_layout_dark .et_pb_post .dipi-at-panel ul li",
                        'ul_item_indent' => "{$this->main_css_element} .dipi-at-panel ul, %%order_class%%.et_pb_bg_layout_light .et_pb_post .dipi-at-panel ul, %%order_class%%.et_pb_bg_layout_dark .et_pb_post .dipi-at-panel ul",
                        'ol'             => "{$this->main_css_element} .dipi-at-panel ol li, %%order_class%%.et_pb_bg_layout_light .et_pb_post .dipi-at-panel ol li, %%order_class%%.et_pb_bg_layout_dark .et_pb_post .dipi-at-panel ol li",
                        'ol_item_indent' => "{$this->main_css_element} .dipi-at-panel ol, %%order_class%%.et_pb_bg_layout_light .et_pb_post .dipi-at-panel ol, %%order_class%%.et_pb_bg_layout_dark .et_pb_post .dipi-at-panel ol",
                        'quote'          => "{$this->main_css_element} .dipi-at-panel blockquote, %%order_class%%.et_pb_bg_layout_light .et_pb_post .dipi-at-panel blockquote, %%order_class%%.et_pb_bg_layout_dark .et_pb_post .dipi-at-panel blockquote",
                    ),
                ),
            ),
           
            'header'   => array(
                'label'       => esc_html__( 'Heading', 'et_builder' ),
                'css'         => array(
                    'main' => "%%order_class%% .dipi-at-panel h1",
                ),
                'font_size'   => array(
                    'default' => absint( et_get_option( 'body_header_size', '30' ) ) . 'px',
                ),
                'toggle_slug' => 'header',
                'sub_toggle'  => 'h1',
            ),
            'header_2' => array(
                'label'       => esc_html__( 'Heading 2', 'et_builder' ),
                'css'         => array(
                    'main' => "%%order_class%% .dipi-at-panel h2",
                ),
                'font_size'   => array(
                    'default' => '26px',
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'toggle_slug' => 'header',
                'sub_toggle'  => 'h2',
            ),
            'header_3' => array(
                'label'       => esc_html__( 'Heading 3', 'et_builder' ),
                'css'         => array(
                    'main' => "%%order_class%% .dipi-at-panel h3",
                ),
                'font_size'   => array(
                    'default' => '22px',
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'toggle_slug' => 'header',
                'sub_toggle'  => 'h3',
            ),
            'header_4' => array(
                'label'       => esc_html__( 'Heading 4', 'et_builder' ),
                'css'         => array(
                    'main' => "%%order_class%% .dipi-at-panel h4",
                ),
                'font_size'   => array(
                    'default' => '18px',
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'toggle_slug' => 'header',
                'sub_toggle'  => 'h4',
            ),
            'header_5' => array(
                'label'       => esc_html__( 'Heading 5', 'et_builder' ),
                'css'         => array(
                    'main' => "%%order_class%% .dipi-at-panel h5",
                ),
                'font_size'   => array(
                    'default' => '16px',
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'toggle_slug' => 'header',
                'sub_toggle'  => 'h5',
            ),
            'header_6' => array(
                'label'       => esc_html__( 'Heading 6', 'et_builder' ),
                'css'         => array(
                    'main' => "%%order_class%% .dipi-at-panel h6",
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'toggle_slug' => 'header',
                'sub_toggle'  => 'h6',
            ) 
        );
        $advanced_fields['borders'] = array(
            'default'   => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => "%%order_class%%",
                        'border_radii_hover'  => "%%order_class%%:hover",
                        'border_styles' => "%%order_class%%",
                        'border_styles_hover' => "%%order_class%%:hover",
                    ),
                ),
                'defaults' => array(
                    'border_radii' => 'on|0px|0px|0px|0px',
                    'border_styles' => array(
                        'width' => '1px',
                        'color' => '#333333',
                        'style' => 'solid'
                    )
                )
            ),
            'content_wrapper'              => array(
                'css' => array(
                    'main' => array(
                        'border_radii' => "%%order_class%% .dipi-at-panels",
                        'border_radii_hover' => "%%order_class%% .dipi-at-panels:hover",
                        'border_styles' => "%%order_class%% .dipi-at-panels",
                        'border_styles_hover' => "%%order_class%% .dipi-at-panels:hover",
                    )
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'content_wrapper',
                'label_prefix'      => esc_html__("Content Area", 'dipi-divi-pixel')
            ),
            'tabs_wrapper'         => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => "%%order_class%% .dipi-at-tabs",
                        'border_radii_hover'  => "%%order_class%% .dipi-at-tabs:hover",
                        'border_styles' => "%%order_class%% .dipi-at-tabs",
                        'border_styles_hover' => "%%order_class%% .dipi-at-tabs:hover",
                    )
                ),
                'defaults' => array(
                    'border_radii' => 'on|0px|0px|0px|0px',
                    'border_styles' => array(
                        'width' => '1px',
                        'color' => '#333333',
                        'style' => 'solid'
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'tabs_items'
            ),
            'tabs_item'         => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => "%%order_class%% .dipi-at-tabs .dipi-at-tab",
                        'border_radii_hover'  => "%%order_class%% .dipi-at-tabs .dipi-at-tab:hover",
                        'border_styles' => "%%order_class%% .dipi-at-tabs .dipi-at-tab",
                        'border_styles_hover' => "%%order_class%% .dipi-at-tabs .dipi-at-tab:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'at_item',
                'sub_toggle'        => 'normal',
                'label_prefix'      => esc_html__("Tabs Item", 'dipi-divi-pixel')
            ),
            
            'tabs_item_active'         => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => "%%order_class%% .dipi-at-tabs .dipi-at-tab.dipi-at-tab--active",
                        'border_radii_hover'  => "%%order_class%% .dipi-at-tabs .dipi-at-tab.dipi-at-tab--active:hover",
                        'border_styles' => "%%order_class%% .dipi-at-tabs .dipi-at-tab.dipi-at-tab--active",
                        'border_styles_hover' => "%%order_class%% .dipi-at-tabs .dipi-at-tab.dipi-at-tab--active:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'at_item',
                'sub_toggle'        => 'active',
                'label_prefix'      => esc_html__("Active Tabs Item", 'dipi-divi-pixel')
            )
        );
        $advanced_fields['box_shadow'] = array(
            'default'   => array(),
            'tabs_item'              => array(
                'css' => array(
                    'main' => "%%order_class%% .dipi-at-tabs .dipi-at-tab:not(.dipi-at-tab--active)",
                    'hover' => "%%order_class%% .dipi-at-tabs .dipi-at-tab:not(.dipi-at-tab--active):hover",
                ),
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'at_item',
                'sub_toggle'  => 'normal' 
                 
            ),
            'tabs_item_active'              => array(
                'css' => array(
                    'main' => "%%order_class%% .dipi-at-tabs .dipi-at-tab.dipi-at-tab--active",
                    'hover' => "%%order_class%% .dipi-at-tabs .dipi-at-tab.dipi-at-tab--active:hover",
                ),
                'tab_slug'    => 'advanced',
                'toggle_slug' => 'at_item',
                'sub_toggle'  => 'active' 
            ),
            'tabs_wrapper'              => array(
                'css' => array(
                    'main' => "%%order_class%% .dipi-at-tabs",
                    'hover' => "%%order_class%% .dipi-at-tabs:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'tabs_items'
               
            ),
            'content_wrapper'              => array(
                'css' => array(
                    'main' => "%%order_class%% .dipi-at-panels",
                    'hover' => "%%order_class%% .dipi-at-panels:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'content_wrapper'
            )
        );

        $advanced_fields['button']["button"] = [
            'label' => esc_html__('Button Style', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-at-btn",
                'important' => 'all',
            ],
            'hide_icon' => false,
            'use_alignment' => false,
            'box_shadow' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-at-btn",
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-at-btn",
                    'important' => 'all',
                ],
            ],
        ];
    
        return $advanced_fields;
    }

    public function get_fields() {
        
        $fields = [];
        $fields["module_id"] = [
            'label' => esc_html__('CSS ID', 'dipi-divi-pixel'),
            'type' => 'text',
            'tab_slug' => 'custom_css',
            'toggle_slug' => 'classes',
        ];

        // Tabs Animations
        $fields['tab_animation'] = [
            'label'                     => esc_html__('Tab Reveal Animation', 'dipi-divi-pixel'),
            'type'                      => 'select',
            'default'                   => 'none',
            
            'options'                   => array(
                'none'                  => esc_html__('None', 'dipi-divi-pixel'),
                'fadeIn'                => esc_html__('Fade In', 'dipi-divi-pixel'),
                'fadeInLeftShort'       => esc_html__('FadeIn Left', 'dipi-divi-pixel'),
                'fadeInRightShort'      => esc_html__('FadeIn Right', 'dipi-divi-pixel'),
                'fadeInUpShort'         => esc_html__('FadeIn Up', 'dipi-divi-pixel'),
                'fadeInDownShort'       => esc_html__('FadeIn Down', 'dipi-divi-pixel'),
                'zoomInShort'           => esc_html__('Grow', 'dipi-divi-pixel'),
                'bounceInShort'         => esc_html__('BounceIn', 'dipi-divi-pixel'),
                'bounceInLeftShort'     => esc_html__('BounceIn Left', 'dipi-divi-pixel'),
                'bounceInRightShort'    => esc_html__('BounceIn Right', 'dipi-divi-pixel'),
                'bounceInUpShort'       => esc_html__('BounceIn Up', 'dipi-divi-pixel'),
                'bounceInDownShort'     => esc_html__('BounceIn Down', 'dipi-divi-pixel'),
                'flipInXShort'          => esc_html__('FlipInX', 'dipi-divi-pixel'),
                'flipInYShort'          => esc_html__('FlipInY', 'dipi-divi-pixel'),
                'jackInTheBoxShort'     => esc_html__('JackInTheBox', 'dipi-divi-pixel'),
                'rotateInShort'         => esc_html__('RotateIn', 'dipi-divi-pixel'),
                'rotateInDownLeftShort' => esc_html__('RotateIn DownLeft', 'dipi-divi-pixel'),
                'rotateInUpLeftShort'   => esc_html__('RotateIn UpLeft', 'dipi-divi-pixel'),
                'rotateInDownRightShort' => esc_html__('RotateIn DownRight', 'dipi-divi-pixel'),
                'rotateInUpRightShort'  => esc_html__('RotateIn UpRight', 'dipi-divi-pixel')
            ),
            'toggle_slug'            => 'tabs_settings',
            'tab_slug'               => 'general'
        ];
        $fields['dipi_animation_duration'] = [
            'label'                 => esc_html__( 'Animation Duration', 'dipi-divi-pixel' ),
				'type'              => 'range',
				'tab_slug'          => 'general',
				'toggle_slug'       => 'tabs_settings',
				'default'           => '300',
                'unitless'          => true,
				'range_settings'    => array(
					'min'  => '0',
					'max'  => '3000',
					'step' => '100',
                ),
				'mobile_options'    => true,
				'depends_show_if'   => 'on',
                'responsive'        => true
        ];
        // End of Tabs Animations

        $fields['activate_on_hover'] = [
            'label'           => esc_html__( 'Activate On Hover', 'dipi-divi-pixel' ),
            'type'            => 'yes_no_button',
            'option_category' => 'basic_option',
            'default'         => 'off',
            'options'         => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'tab_slug'          => 'general',
				'toggle_slug'       => 'tabs_settings'
        ];

        $fields['activate_first_tab_as_placeholder'] = [
            'label'           => esc_html__( 'Activate First Tab as Placeholder', 'dipi-divi-pixel' ),
            'description'           => esc_html__('Active first tab when \'Active on Load\' is not set in any tab item.', 'dipi-divi-pixel'),
            'type'            => 'yes_no_button',
            'option_category' => 'basic_option',
            'default'         => 'on',
            'options'         => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'tab_slug'          => 'general',
				'toggle_slug'       => 'tabs_settings'
        ];
        
   
        // Tabs Settings
        $fields['use_sticky_tabs'] = [
            'label'                 => esc_html__( 'Sticky Tabs', 'dipi-divi-pixel' ),
            'type'                  => 'yes_no_button',
            'option_category'       => 'basic_option',
            'options'               => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'toggle_slug'           => 'tabs_items',
            'tab_slug'              => 'advanced'
        ];
        $fields['turn_off_sticky'] = [
            'label'                 => esc_html__('Turn Off Sticky On', 'dipi-divi-pixel'),
            'type'                  => 'select',
            'default'               => 'none',
            'options'               => array(
                'none'              => esc_html__('None', 'dipi-divi-pixel'),
                'tablet_phone'      => esc_html__('Tablet & Mobile', 'dipi-divi-pixel'),
                'phone'             => esc_html__('Mobile', 'dipi-divi-pixel')
            ),
            'toggle_slug'            => 'tabs_items',
            'tab_slug'               => 'advanced',
            'show_if'               => array(
                'use_sticky_tabs' => 'on'
            )
        ];
        $fields['sticky_tabs_distance']  = [
            'label'             => esc_html__( 'Sticky Top Offset', 'dipi-divi-pixel' ),
            'type'              => 'range',
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'tabs_items',
            'default'           => '55px',
            'default_unit'      => 'px',
            'validate_unit'    => true,
            'allowed_units'    => array( 'px' ),
            'range_settings' => array(
                'min'  => '1',
                'max'  => '300',
                'step' => '1',
            ),
            'mobile_options'    => true,
            'depends_show_if'   => 'on',
            'responsive'        => true,
            'show_if'           => array(
                'use_sticky_tabs'    => 'on'
            )
        ];

        // create enable_tabs_slider as yes_no_button field
        $fields['enable_tabs_slider'] = [
            'label'                 => esc_html__( 'Tabs Slider', 'dipi-divi-pixel' ),
            'type'                  => 'yes_no_button',
            'option_category'       => 'basic_option',
            'default' => 'off',
            'options'               => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'toggle_slug'           => 'tabs_items',
            'tab_slug'              => 'advanced'
        ];

        // create tabs_slider composition field
        $fields['tabs_slider'] = [
            'label'             => esc_html__( 'Select Device', 'dipi-divi-pixel' ),
            'type'              => 'composite',
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'tabs_items',
            'composite_type'    => 'default',
            'composite_structure' => array(
                'desktop' => array(
                    'icon'     => 'desktop',
                    'controls' =>  [
                        // enable tabs slider 
                        'enable_ts_on_wide' => [
                            'label'                 => esc_html__( 'Enable on desktops', 'dipi-divi-pixel' ),
                            'type'                  => 'yes_no_button',
                             
                            'options'               => array(
                                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
                            ),
                            'toggle_slug'           => 'tabs_items',
                            'tab_slug'              => 'advanced'
                        ],
                        // // ranged field for tabs per view
                        'tabs_per_view_wide' => [
                            'label'             => esc_html__( 'Tabs Per View', 'dipi-divi-pixel' ),
                            'type'              => 'range',
                            'tab_slug'          => 'advanced',
                            'toggle_slug'       => 'tabs_items',
                            'default'           => '2',
                            'default_on_front' => '2',
                            'range_settings' => array(
                                'min'  => '1',
                                'max'  => '10',
                                'step' => '1',
                            ),
                            'show_if'           => array(
                                'enable_ts_on_wide'    => 'on'
                            )
                        ],
                        // yse_no_button field for navigation
                        'ts_navigation_wide' => [
                            'label'                 => esc_html__( 'Use Nav', 'dipi-divi-pixel' ),
                            'type'                  => 'yes_no_button',
                            'option_category'       => 'basic_option',
                            'options'               => array(
                                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
                            ),
                            'toggle_slug'           => 'tabs_items',
                            'tab_slug'              => 'advanced',
                            'show_if'           => array(
                                'enable_ts_on_wide'    => 'on'
                            )
                        ],
                        // ranged field for navigation vertical position       
                        'ts_navigation_vertical_position_wide' => [
                            'label'             => esc_html__( 'Nav Vertical Position', 'dipi-divi-pixel' ),
                            'type'              => 'range',
                            'tab_slug'          => 'advanced',
                            'toggle_slug'       => 'tabs_items',
                            'default'           => '50',
                            'range_settings' => array(
                                'min'  => '0',
                                'max'  => '100',
                                'step' => '1',
                            ),
                            'show_if'           => array(
                                'enable_ts_on_wide'    => 'on',
                                'ts_navigation_wide'              => 'on'
                            )
                        ],
                        // ranged field for navigation horizontal position
                        'ts_navigation_horizontal_position_wide' => [
                            'label'             => esc_html__( 'Nav Horizontal Position', 'dipi-divi-pixel' ),
                            'type'              => 'range',
                            'tab_slug'          => 'advanced',
                            'toggle_slug'       => 'tabs_items',
                            'default'           => '0',
                            'range_settings' => array(
                                'min'  => '-100',
                                'max'  => '100',
                                'step' => '1',
                            ),
                            'show_if'           => array(
                                'enable_ts_on_wide'    => 'on',
                                'ts_navigation_wide'              => 'on'
                            )
                        ],
                    ],
                ),
                'tablet' => array(
                    'icon'     => 'tablet',
                    'controls' =>  [
                        // enable tabs slider 
                        'enable_ts_on_tab' => [
                            'label'                 => esc_html__( 'Enable on tablets', 'dipi-divi-pixel' ),
                            'type'                  => 'yes_no_button',
                            'option_category'       => 'basic_option',
                            'options'               => array(
                                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
                            ),
                            'toggle_slug'           => 'tabs_items',
                            'tab_slug'              => 'advanced'
                        ],
                        // ranged field for tabs per view
                        'tabs_per_view_tab' => [
                            'label'             => esc_html__( 'Tabs Per View', 'dipi-divi-pixel' ),
                            'type'              => 'range',
                            'tab_slug'          => 'advanced',
                            'toggle_slug'       => 'tabs_items',
                            'default'           => '2',
                            'range_settings' => array(
                                'min'  => '1',
                                'max'  => '10',
                                'step' => '1',
                            ),
                            'show_if'           => array(
                                'enable_ts_on_tab'    => 'on'
                            )
                        ],
                        // yse_no_button field for navigation
                        'ts_navigation_tab' => [
                            'label'                 => esc_html__( 'Use Nav', 'dipi-divi-pixel' ),
                            'type'                  => 'yes_no_button',
                            'option_category'       => 'basic_option',
                            'options'               => array(
                                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
                            ),
                            'toggle_slug'           => 'tabs_items',
                            'tab_slug'              => 'advanced',
                            'show_if'           => array(
                                'enable_ts_on_tab'    => 'on'
                            )
                        ],
                        // ranged field for navigation vertical position       
                        'ts_navigation_vertical_position_tab' => [
                            'label'             => esc_html__( 'Nav Vertical Position', 'dipi-divi-pixel' ),
                            'type'              => 'range',
                            'tab_slug'          => 'advanced',
                            'toggle_slug'       => 'tabs_items',
                            'default'           => '50',
                            'range_settings' => array(
                                'min'  => '0',
                                'max'  => '100',
                                'step' => '1',
                            ),
                            'show_if'           => array(
                                'enable_ts_on_tab'    => 'on',
                                'ts_navigation_tab'              => 'on'
                            )
                        ],
                        // ranged field for navigation horizontal position
                        'ts_navigation_horizontal_position_tab' => [
                            'label'             => esc_html__( 'Nav Horizontal Position', 'dipi-divi-pixel' ),
                            'type'              => 'range',
                            'tab_slug'          => 'advanced',
                            'toggle_slug'       => 'tabs_items',
                            'default'           => '0',
                            'range_settings' => array(
                                'min'  => '-100',
                                'max'  => '100',
                                'step' => '1',
                            ),
                            'show_if'           => array(
                                'enable_ts_on_tab'    => 'on',
                                'ts_navigation_tab'              => 'on'
                            )
                        ],
                    ],
                ),
                'phone' => array(
                    'icon'     => 'phone',
                    'controls' =>  [
                        // enable tabs slider 
                        'enable_ts_on_pho' => [
                            'label'                 => esc_html__( 'Enable on mobiles', 'dipi-divi-pixel' ),
                            'type'                  => 'yes_no_button',
                            'option_category'       => 'basic_option',
                            'options'               => array(
                                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
                            ),
                            'toggle_slug'           => 'tabs_items',
                            'tab_slug'              => 'advanced'
                        ],
                        // ranged field for tabs per view
                        'tabs_per_view_pho' => [
                            'label'             => esc_html__( 'Tabs Per View', 'dipi-divi-pixel' ),
                            'type'              => 'range',
                            'tab_slug'          => 'advanced',
                            'toggle_slug'       => 'tabs_items',
                            'default'           => '1',
                            'range_settings' => array(
                                'min'  => '1',
                                'max'  => '10',
                                'step' => '1',
                            ),
                            'show_if'           => array(
                                'enable_ts_on_pho'    => 'on'
                            )
                        ],
                        // yse_no_button field for navigation
                        'ts_navigation_pho' => [
                            'label'                 => esc_html__( 'Use Nav', 'dipi-divi-pixel' ),
                            'type'                  => 'yes_no_button',
                            'option_category'       => 'basic_option',
                            'options'               => array(
                                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
                            ),
                            'toggle_slug'           => 'tabs_items',
                            'tab_slug'              => 'advanced',
                            'show_if'           => array(
                                'enable_ts_on_pho'    => 'on'
                            )
                        ],
                        // ranged field for navigation vertical position       
                        'ts_navigation_vertical_position_pho' => [
                            'label'             => esc_html__( 'Nav Vertical Position', 'dipi-divi-pixel' ),
                            'type'              => 'range',
                            'tab_slug'          => 'advanced',
                            'toggle_slug'       => 'tabs_items',
                            'default'           => '50',
                            'range_settings' => array(
                                'min'  => '0',
                                'max'  => '100',
                                'step' => '1',
                            ),
                            'show_if'           => array(
                                'enable_ts_on_pho'    => 'on',
                                'ts_navigation_pho'   => 'on'
                            )
                        ],
                        // ranged field for navigation horizontal position
                        'ts_navigation_horizontal_position_pho' => [
                            'label'             => esc_html__( 'Nav Horizontal Position', 'dipi-divi-pixel' ),
                            'type'              => 'range',
                            'tab_slug'          => 'advanced',
                            'toggle_slug'       => 'tabs_items',
                            'default'           => '0',
                            'range_settings' => array(
                                'min'  => '-100',
                                'max'  => '100',
                                'step' => '1',
                            ),
                            'show_if'           => array(
                                'enable_ts_on_pho'    => 'on',
                                'ts_navigation_pho'            => 'on'
                            )
                        ],
                    ],
                ),
            ),
            'show_if' => array(
                'enable_tabs_slider' => 'on'
            )
        ];

        $fields['tabs_width'] = [
            'label'             => esc_html__( 'Tabs Item width', 'dipi-divi-pixel' ),
            'type'              => 'composite',
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'tabs_items',
            'composite_type'    => 'default',
            'composite_structure' => array(
                'desktop' => array(
                    'icon'     => 'desktop',
                    'controls' => array(
                        'use_tabs_fullwidth' => [
                            'label'                 => esc_html__( 'Use Fullwidth tabs', 'dipi-divi-pixel' ),
                            'type'                  => 'yes_no_button',
                            'option_category'       => 'basic_option',
                            'default' => 'on',
                            'default_on_front' => 'on',
                            'options'               => array(
                                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
                            ) 
                        ],
                      
                        'tabs_min_width' => [
                            'label'             => esc_html__( 'Tabs Item Min Width', 'dipi-divi-pixel' ),
                            'type'              => 'range',
                            'option_category'   => 'font_option',
                            'default'           => '100px',
                            'default_unit'      => 'px',
                            'range_settings' => array(
                                'min'  => '1',
                                'max'  => '300',
                                'step' => '1',
                            ),
                            'show_if'           => [ 'use_tabs_fullwidth' => 'off'] 
                        ],
                        'tabs_max_width' => [
                            'label'             => esc_html__( 'Tabs Item Max Width', 'dipi-divi-pixel' ),
                            'type'              => 'range',
                            'option_category'   => 'font_option',
                            'default'           => '200px',
                            'default_unit'      => 'px',
                            'range_settings' => array(
                                'min'  => '1',
                                'max'  => '500',
                                'step' => '1',
                            ),
                            'show_if' => [ 'use_tabs_fullwidth' => 'off'] 
                        ]
                    ),
                ),
                'tablet' => array(
                    'icon'  => 'tablet',
                    'controls' => array(
                        'use_tabs_fullwidth_tablet' => [
                            'label'                 => esc_html__( 'Use Fullwidth tabs', 'dipi-divi-pixel' ),
                            'type'                  => 'yes_no_button',
                            'option_category'       => 'basic_option',
                            'default' => 'on',
                            'options'               => array(
                                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
                            ) 
                        ],
                        'tabs_min_width_tablet' => [
                            'label'             => esc_html__( 'Tabs Item Min Width', 'dipi-divi-pixel' ),
                            'type'              => 'range',
                            'option_category'   => 'font_option',
                            'default'           => '100px',
                            'default_unit'      => 'px',
                            'range_settings' => array(
                                'min'  => '1',
                                'max'  => '300',
                                'step' => '1',
                            ),
                            'show_if'           => [ 'use_tabs_fullwidth_tablet' => 'off'] 
                        ],
                        'tabs_max_width_tablet' => [
                            'label'             => esc_html__( 'Tabs Item Max Width', 'dipi-divi-pixel' ),
                            'type'              => 'range',
                            'option_category'   => 'font_option',
                            'default'           => '200px',
                            'default_unit'      => 'px',
                            'range_settings' => array(
                                'min'  => '1',
                                'max'  => '500',
                                'step' => '1',
                            ),
                            'show_if' => [ 'use_tabs_fullwidth_tablet' => 'off'] 
                        ]
                         
                    ),
                ),
                'phone' => array(
                    'icon'  => 'phone',
                    'controls' => array(
                        'use_tabs_fullwidth_phone' => [
                            'label'                 => esc_html__( 'Use Fullwidth tabs', 'dipi-divi-pixel' ),
                            'type'                  => 'yes_no_button',
                            'option_category'       => 'basic_option',
                            'default' => 'on',
                            'options'               => array(
                                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
                            ) 
                        ],
                        'tabs_min_width_phone' => [
                            'label'             => esc_html__( 'Tabs Item Min Width', 'dipi-divi-pixel' ),
                            'type'              => 'range',
                            'option_category'   => 'font_option',
                            'default'           => '100px',
                            'default_unit'      => 'px',
                            'range_settings' => array(
                                'min'  => '1',
                                'max'  => '300',
                                'step' => '1',
                            ),
                            'show_if'           => [ 'use_tabs_fullwidth_phone' => 'off'] 
                        ],
                        'tabs_max_width_phone' => [
                            'label'             => esc_html__( 'Tabs Item Max Width', 'dipi-divi-pixel' ),
                            'type'              => 'range',
                            'option_category'   => 'font_option',
                            'default'           => '200px',
                            'default_unit'      => 'px',
                            'range_settings' => array(
                                'min'  => '1',
                                'max'  => '500',
                                'step' => '1',
                            ),
                            'show_if' => [ 'use_tabs_fullwidth_phone' => 'off'] 
                        ]
                         
                    ),
                ),
            ),
        ];

        
         
        $fields['tabs_place'] = [
            'label'             => esc_html__( 'Tabs Placement', 'dipi-divi-pixel' ),
            'type'              => 'composite',
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'tabs_items',
            'composite_type'    => 'default',
            'composite_structure' => array(
                'desktop' => array(
                    'icon'     => 'desktop',
                    'controls' => array(
                        'tabs_placement' => array(
                            'label'                 => esc_html__('Tabs Placement Desktop', 'dipi-divi-pixel'),
                            'type'                  => 'select',
                            'default'               => 'column',
                            'options'               => array(
                                'column'       => esc_html__('Default', 'dipi-divi-pixel'),
                                'column-reverse'    => esc_html__('Bottom', 'dipi-divi-pixel'),
                                'row'      => esc_html__('Left', 'dipi-divi-pixel'),
                                'row-reverse'     => esc_html__('Right', 'dipi-divi-pixel')
                            ),
                            'toggle_slug'            => 'tabs_items',
                            'tab_slug'               => 'advanced'
                        ),
                        'tabs_container_width'   => array(
                            'label'             => esc_html__( 'Tabs Container Width Desktop', 'dipi-divi-pixel' ),
                            'type'              => 'range',
                            'toggle_slug'       => 'tabs_items',
                            'tab_slug'          => 'advanced',
                            'default'           => '20%',
                            'default_unit'      => '%',
                            'default_on_front'  => '20%',
                            'range_settings'    => array(
                                'min'  => '1',
                                'max'  => '100',
                                'step' => '1',
                            ),
                            'show_if'           => array(
                                'tabs_placement' => array('row', 'row-reverse')
                            )
                        )
                    ),
                ),
                'tablet' => array(
                    'icon'  => 'tablet',
                    'controls' => array(
                        'tabs_placement_tablet' => array(
                            'label'                 => esc_html__('Tabs Placement Tablet', 'dipi-divi-pixel'),
                            'type'                  => 'select',
                            'default'               => 'column',
                            'options'               => array(
                                'column'       => esc_html__('Default', 'dipi-divi-pixel'),
                                'column-reverse'    => esc_html__('Bottom', 'dipi-divi-pixel'),
                                'row'      => esc_html__('Left', 'dipi-divi-pixel'),
                                'row-reverse'     => esc_html__('Right', 'dipi-divi-pixel')
                            ),
                            'toggle_slug'            => 'tabs_items',
                            'tab_slug'               => 'advanced',
                        ),
                        'tabs_container_width_tablet'   => array(
                            'label'             => esc_html__( 'Tabs Container Width Tablet', 'dipi-divi-pixel' ),
                            'type'              => 'range',
                            'toggle_slug'       => 'tabs_items',
                            'tab_slug'          => 'advanced',
                            'default'           => '50%',
                            'default_unit'      => '%',
                            'default_on_front'  => '50%',
                            'range_settings'    => array(
                                'min'  => '1',
                                'max'  => '100',
                                'step' => '1',
                            ),
                            'show_if'           => array(
                                'tabs_placement_tablet' => array('flex_left', 'flex_right')
                            )
                        )
                    ),
                ),
                'phone' => array(
                    'icon'  => 'phone',
                    'controls' => array(
                        'tabs_placement_phone' => array(
                            'label'                 => esc_html__('Tabs Placement Mobile', 'dipi-divi-pixel'),
                            'type'                  => 'select',
                            'default'               => 'column',
                            'options'               => array(
                                'column'       => esc_html__('Default', 'dipi-divi-pixel'),
                                'column-reverse'    => esc_html__('Bottom', 'dipi-divi-pixel'),
                                'row'      => esc_html__('Left', 'dipi-divi-pixel'),
                                'row-reverse'     => esc_html__('Right', 'dipi-divi-pixel')
                            ),
                            'toggle_slug'            => 'tabs_items',
                            'tab_slug'               => 'advanced',
                        ),
                        'tabs_container_width_phone'   => array(
                            'label'             => esc_html__( 'Tabs Container Width Mobile', 'dipi-divi-pixel' ),
                            'type'              => 'range',
                            'toggle_slug'       => 'tabs_items',
                            'tab_slug'          => 'advanced',
                            'default'           => '50%',
                            'default_unit'      => '%',
                            'default_on_front'  => '50%',
                            'range_settings'    => array(
                                'min'  => '1',
                                'max'  => '100',
                                'step' => '1',
                            ),
                            'show_if'           => array(
                                'tabs_placement_phone' => array('flex_left', 'flex_right')
                            )
                        )
                    ),
                ),
            ),
        ];
        $fields['tabs_align'] = [
            'label'             => esc_html__('Tabs Items Alignment', 'dipi-divi-pixel'),
            'type'              => 'select',
            'default'           => 'flex-start',
            'options'           => array(
                'flex-start'        => esc_html__('Start', 'dipi-divi-pixel'),
                'center'       => esc_html__('Center', 'dipi-divi-pixel'),
                'flex-end'          => esc_html__('End', 'dipi-divi-pixel')
            ),
            'toggle_slug'       => 'tabs_items',
            'tab_slug'          => 'advanced',
            'mobile_options'    => true,
            'responsive'        => true
        ];

        $fields['tabs_container_padding'] = [
            'label' => esc_html__('Tabs Container Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '10px|10px|10px|10px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'tabs_items',
            'tab_slug'          => 'advanced',
        ];
        $fields['tabs_container_margin'] = [
            'label' => esc_html__('Tabs Container Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '10px|10px|10px|10px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'tabs_items',
            'tab_slug'          => 'advanced',
        ];

        $fields['tabs_item_padding'] = [
            'label' => esc_html__('Tabs Item Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '10px|10px|10px|10px',
            'hover'             => 'tabs',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'at_item',
            'tab_slug'          => 'advanced',
            'sub_toggle'        => 'normal'
        ];
        $fields['tabs_item_margin'] = [
            'label'          => esc_html__('Tabs Item Margin', 'dipi-divi-pixel'),
            'type'           => 'custom_margin',
            'hover'          => 'tabs',
            'default'        => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive'     => true,
            'toggle_slug'    => 'at_item',
            'tab_slug'       => 'advanced',
            'sub_toggle'     => 'normal'
        ];
         //End of Tabs Settings

        //Tabs active Item Settings
        $fields['tabs_active_item_padding'] = [
            'label'          => esc_html__('Tabs Active Item Padding', 'dipi-divi-pixel'),
            'type'           => 'custom_margin',
            'hover'             => 'tabs',
            'default'        => '10px|10px|10px|10px',
            'mobile_options' => true,
            'responsive'     => true,
            'toggle_slug'    => 'at_item',
            'sub_toggle'     => 'active',
            'tab_slug'       => 'advanced'
        ];
        $fields['tabs_active_item_margin'] = [     
            'label'          => esc_html__('Tabs Active Item Margin', 'dipi-divi-pixel'),
            'type'           => 'custom_margin',
            'hover'             => 'tabs',
            'default'        => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive'     => true,
            'toggle_slug'    => 'at_item',
            'sub_toggle'     => 'active',
            'tab_slug'       => 'advanced'
        ];
        //End of Tabs active Item Settings

        // Scroll to content Settings
        $fields['use_scroll_to_content'] = [
            'label'                 => esc_html__( 'Scroll to Content', 'dipi-divi-pixel' ),
            'type'                  => 'yes_no_button',
            'description'           => esc_html__('If enabled the window will scroll to content area in tablet and mobile device.', 'dipi-divi-pixel'),
            'option_category'       => 'basic_option',
            'options'               => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'toggle_slug'           => 'content_wrapper',
            'tab_slug'              => 'advanced',
            'mobile_options'    => true,
            'responsive'        => true
            
        ];
        // ranged field for scroll to content offset
        $fields['scroll_to_content_offset'] = [
            'label'             => esc_html__( 'Scroll to Content Offset', 'dipi-divi-pixel' ),
            'type'              => 'range',
            'default_unit'      => 'px',
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'content_wrapper',
            'default'           => '0px',
            'mobile_options'    => true,
            'range_settings' => array(
                'min'  => '0',
                'max'  => '500',
                'step' => '1',
            )
        ];
        $fields['content_vertical_align'] = [
            'label'             => esc_html__('Content Vertical Align', 'dipi-divi-pixel'),
            'description'       => esc_html__('It will only work when the tabs placement is left or right.', 'dipi-divi-pixel'),
            'type'              => 'select',
            'default'           => 'flex-start',
            'options'           => array(
                'flex-start'        => esc_html__('Top', 'dipi-divi-pixel'),
                'center'       => esc_html__('Center', 'dipi-divi-pixel'),
                'flex-end'          => esc_html__('Bottom', 'dipi-divi-pixel')
            ),
            'toggle_slug'       => 'content_wrapper',
            'tab_slug'          => 'advanced',
            'mobile_options'    => true,
            'responsive'        => true
        ];
        $fields['content_padding'] = [
            'label' => esc_html__('Content Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '10px|10px|10px|10px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'content_wrapper',
            'tab_slug'          => 'advanced'
        ];
        $fields['content_margin'] = [
            'label' => esc_html__('Content Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '10px|10px|10px|10px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'content_wrapper',
            'tab_slug'          => 'advanced'
        ];
        //End of Scroll to content Settings
        
        $fields['tabs_text_padding'] = [
            'label'   => esc_html__('Tabs Item Text Padding', 'dipi-divi-pixel'),
            'type'    => 'custom_margin',
            'hover'   => 'tabs',
            'default' => '5px|5px|5px|5px',
            'mobile_options' => true,
            'responsive'  => true,
            'toggle_slug' => 'at_item',
            'sub_toggle'  => 'normal',
            'tab_slug'    => 'advanced'
        ];
        $fields['tabs_text_margin'] = [
            'label'   => esc_html__('Tabs Item Text Margin', 'dipi-divi-pixel'),
            'type'    => 'custom_margin',
            'hover'   => 'tabs',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug' => 'at_item',
            'sub_toggle'  => 'normal',
            'tab_slug'    => 'advanced'
        ];
        $fields['tabs_icon_padding'] = [
            'label'   => esc_html__('Tabs Item Media Padding', 'dipi-divi-pixel'),
            'type'    => 'custom_margin',
            'hover'   => 'tabs',
            'default' => '5px|5px|5px|5px',
            'mobile_options' => true,
            'responsive'  => true,
            'toggle_slug' => 'at_item',
            'sub_toggle'  => 'normal',
            'tab_slug'    => 'advanced'
        ];
        $fields['tabs_icon_margin'] = [
            'label'   => esc_html__('Tabs Item Media Margin', 'dipi-divi-pixel'),
            'type'    => 'custom_margin',
            'hover'   => 'tabs',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug' => 'at_item',
            'sub_toggle'  => 'normal',
            'tab_slug'    => 'advanced'
        ];
        
        $fields['tabs_text_padding_active'] = [
            'label'   => esc_html__('Tabs Item Text Padding', 'dipi-divi-pixel'),
            'type'    => 'custom_margin',
            'hover'   => 'tabs',
            'default' => '5px|5px|5px|5px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug' => 'at_item',
            'sub_toggle'  => 'active',
            'tab_slug'    => 'advanced',
        ];
        $fields['tabs_text_margin_active'] = [
            'label'   => esc_html__('Tabs Item Text Margin', 'dipi-divi-pixel'),
            'type'    => 'custom_margin',
            'hover'   => 'tabs',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug' => 'at_item',
            'sub_toggle'  => 'active',
            'tab_slug'    => 'advanced'
        ];
        $fields['tabs_icon_padding_active'] = [
            'label'   => esc_html__('Tabs Item Media Padding', 'dipi-divi-pixel'),
            'type'    => 'custom_margin',
            'hover'   => 'tabs',
            'default' => '5px|5px|5px|5px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug' => 'at_item',
            'sub_toggle'  => 'active',
            'tab_slug'    => 'advanced',
        ];
        $fields['tabs_icon_margin_active'] = [
            'label'   => esc_html__('Tabs Item Media Margin', 'dipi-divi-pixel'),
            'type'    => 'custom_margin',
            'hover'   => 'tabs',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug' => 'at_item',
            'sub_toggle'  => 'active',
            'tab_slug'    => 'advanced'
        ];
        //End of Icon Settings
 
        // Active Arrow Settings
        $fields['use_active_arrow'] = [
            'label'                 => esc_html__( 'Use Active Arrow', 'dipi-divi-pixel' ),
            'type'                  => 'yes_no_button',
            'option_category'       => 'basic_option',
            'options'               => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'default' => "use_balloon_icon",
            'toggle_slug'           => 'tabs_active_arrow',
            'tab_slug'              => 'advanced',
            'affects'               => array(
                'active_arrow_color',
                'active_arrow_size',
                'arrow_align'
            )
        ];
        $fields['active_arrow_color'] = [
            'default'           => "#eaeaea",
            'label'             => esc_html__( 'Active Arrow Color', 'dipi-divi-pixel' ),
            'type'              => 'color-alpha',
            'depends_show_if'   => 'on',
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'tabs_active_arrow',
            'hover'             => 'tabs'
        ];
        $fields['active_arrow_size'] = [
            'label'             => esc_html__( 'Arrow Size', 'dipi-divi-pixel' ),
            'type'              => 'range',
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'tabs_active_arrow',
            'default'           => '30px',
            'default_unit'      => 'px',
            'validate_unit'     => true,
            'allowed_units'     => array( 'px' ),
            'range_settings'    => array(
                'min'  => '1',
                'max'  => '100',
                'step' => '1',
            ),
            'depends_show_if'   => 'on',
        ];
        $fields['arrow_align'] = [
            'label'             => esc_html__('Arrow Alignment', 'dipi-divi-pixel'),
            'type'              => 'select',
            'default'           => 'start',
            'options'           => array(
                'start'        => esc_html__('Start', 'dipi-divi-pixel'),
                'center'       => esc_html__('Center', 'dipi-divi-pixel'),
                'end'          => esc_html__('End', 'dipi-divi-pixel')
            ),
            'toggle_slug'       => 'tabs_active_arrow',
            'tab_slug'          => 'advanced',
            'depends_show_if'   => 'on',
        ];
        // End of Active Arrow Settings

        /* Content Background */
        $fields = $this->dipi_add_bg_field($fields, [ // content_container {old name}
            'name' => 'content',
            'label' => esc_html__('Content Background', 'dipi-divi-pixel'),
            'toggle_slug'           => 'content_background',
            'tab_slug'              => 'general'
        ]);
        /* End of Content Background */

        /* Tabs Background */
        $fields = $this->dipi_add_bg_field($fields, [ 
            'name' => 'tabs',
            'label' => esc_html__('Tabs', 'dipi-divi-pixel'),
            'toggle_slug'           => 'tabs_background',
            'tab_slug'              => 'general',
        ]);
        /* End of Tabs Background */

        $fields = $this->dipi_add_bg_field($fields, [ 
            'name'        => 'tabs_item',
            'label'       => esc_html__('Tabs Item', 'dipi-divi-pixel'),
            'toggle_slug' => 'at_item',
            'sub_toggle'        => 'normal',
            'tab_slug'    => 'advanced',
            'sub_toggle'        => 'normal',
            'default'    => '#eeeeee'
        ]);


        $fields = $this->dipi_add_bg_field($fields, [ 
            'name'        => 'tabs_item_active',
            'label'       => esc_html__('Tabs Active Item', 'dipi-divi-pixel'),
            'toggle_slug' => 'at_item',
            'sub_toggle'  => 'active',
            'tab_slug'    => 'advanced',
            'default'     => '#ffffff'
        ]);



        $fields['navigation_prev_icon_yn'] = [
            'label' => esc_html__('Prev Nav Custom Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
        ];

        $fields['navigation_prev_icon'] = [
            'label' => esc_html__('Select Previous Nav icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'class' => array('et-pb-font-icon'),
            'default' => '8',
            'show_if' => ['navigation_prev_icon_yn' => 'on'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
        ];

        $fields['navigation_next_icon_yn'] = [
            'label' => esc_html__('Next Nav Custom Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => array(
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ),
            'default' => 'off',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
        ];

        $fields['navigation_next_icon'] = [
            'label' => esc_html__('Select Next Nav icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'class' => array('et-pb-font-icon'),
            'default' => '9',
            'show_if' => ['navigation_next_icon_yn' => 'on'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
        ];

        $fields['navigation_size'] = [
            'label' => esc_html__('Icon Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'range_settings' => array(
                'min' => '1',
                'max' => '100',
                'step' => '1',
            ),
            'default' => 30,
            'validate_unit' => false,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
            'mobile_options' => true,
        ];

        $fields['navigation_padding'] = [
            'label' => esc_html__('Icon Padding', 'dipi-divi-pixel'),
            'type' => 'range',
            'range_settings' => [
                'min' => '1',
                'max' => '100',
                'step' => '1',
            ],
            'default' => 30,
            'validate_unit' => false,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
            'mobile_options' => true,
        ];

        $fields['navigation_color'] = [
            'label' => esc_html('Arrow Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => et_builder_accent_color(),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
            'hover' => 'tabs',
        ];

        $fields['navigation_bg_color'] = [
            'label' => esc_html('Arrow Background', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
            'hover' => 'tabs',
        ];

        $fields['navigation_circle'] = [
            'label' => esc_html__('Circle Arrow', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => array(
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ),
            'default' => 'off',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'navigation',
        ];

        // $fields['navigation_position_left'] = [
        //     'label' => esc_html('Left Navigation Postion', 'dipi-divi-pixel'),
        //     'type' => 'range',
        //     'default' => '-66px',
        //     'default_on_front' => '-66px',
        //     'default_unit' => 'px',
        //     'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
        //     'range_settings' => [
        //         'min' => '-200',
        //         'max' => '200',
        //         'step' => '1',
        //     ],
        //     'mobile_options' => true,
        //     'responsive' => true,
        //     'tab_slug' => 'advanced',
        //     'toggle_slug' => 'navigation',
        // ];

        // $fields['navigation_position_right'] = [
        //     'label' => esc_html('Right Navigation Postion', 'dipi-divi-pixel'),
        //     'type' => 'range',
        //     'default' => '-66px',
        //     'default_on_front' => '-66px',
        //     'default_unit' => 'px',
        //     'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
        //     'range_settings' => [
        //         'min' => '-200',
        //         'max' => '200',
        //         'step' => '1',
        //     ],
        //     'mobile_options' => true,
        //     'responsive' => true,
        //     'tab_slug' => 'advanced',
        //     'toggle_slug' => 'navigation',
        // ];

        return $fields;
    }
 
    public function _apply_css($render_slug) {
        $this->_tabs_style($render_slug);
        $this->_content_style($render_slug);
        $this->_tabs_item_style($render_slug);
        $this->_tabs_item_active_style($render_slug);
        $this->_active_arrow_style($render_slug);
        $this->_tabs_slider_style($render_slug);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '.dipi-tab-media.dipi-tab-media--normal',
            'declaration' => 'display: block;'
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '.dipi-tab-media.dipi-tab-media--active',
            'declaration' => 'display: none;'
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '.dipi-at-tab.dipi-at-tab--active .dipi-tab-media.dipi-tab-media--active',
            'declaration' => 'display: block;'
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '.dipi-at-tab.dipi-at-tab--active .dipi-tab-media.dipi-tab-media--normal',
            'declaration' => 'display: none;'
        ]);  
    }

    public function _tabs_style($render_slug) {
        $devices = ['desktop', 'tablet', 'phone'];
        foreach($devices as $device) {
            $pros_suffix = ($device !== "desktop") ? '_' . $device : '';
            if($this->props["use_tabs_fullwidth{$pros_suffix}"] === 'off') {
                $tabs_settings = array(
                    'selector' => '%%order_class%% .dipi-at-tabs',
                    'declaration' => 'flex-wrap: wrap;'
                );

                $tab_min_width = (isset($this->props["tabs_min_width{$pros_suffix}"]) && !empty($this->props["tabs_min_width{$pros_suffix}"]))? $this->props["tabs_min_width{$pros_suffix}"] : '100px';
                $tab_max_width = (isset($this->props["tabs_max_width{$pros_suffix}"]) && !empty($this->props["tabs_max_width{$pros_suffix}"]))? $this->props["tabs_max_width{$pros_suffix}"] : '200px';
                $single_tab_settings = [
                    'selector' => '%%order_class%% .dipi-at-tab',
                    'declaration' => sprintf('min-width:%1$s; max-width:%1$s;', $tab_min_width, $tab_max_width )
                ];
                
                switch($device){
                    case 'tablet':
                    $tabs_settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_980');
                    $single_tab_settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_980');
                    break;
                    case 'phone':
                    $tabs_settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_767');
                    $single_tab_settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_767');
                    break;
                }

                ET_Builder_Element::set_style($render_slug, $tabs_settings);
                ET_Builder_Element::set_style($render_slug, $single_tab_settings);
                
            }else{
                $tabs_settings = array(
                    'selector' => '%%order_class%% .dipi-at-tabs',
                    'declaration' => 'flex-wrap: nowrap;'
                );
                $single_tab_settings = [
                    'selector' => '%%order_class%% .dipi-at-tab',
                    'declaration' => 'width:100%;'
                ];

                switch($device){
                    case 'tablet':
                    $tabs_settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_980');
                    $single_tab_settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_980');
                    break;
                    case 'phone':
                    $tabs_settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_767');
                    $single_tab_settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_767');
                    break;
                }

                ET_Builder_Element::set_style($render_slug, $tabs_settings);
                ET_Builder_Element::set_style($render_slug, $single_tab_settings);
            }
        }
        if($this->props['use_tabs_fullwidth'] === 'off') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-at-tabs',
                'declaration' => 'flex-wrap: wrap;'
            ));

            $this->process_range_field_css( array(
                'render_slug'       => $render_slug,
                'slug'              => 'tabs_min_width',
                'type'              => 'min-width',
                'selector'          => '%%order_class%% .dipi-at-tab',
                'important'         => false
            ) );

            $this->process_range_field_css( array(
                'render_slug'       => $render_slug,
                'slug'              => 'tabs_max_width',
                'type'              => 'max-width',
                'selector'          => '%%order_class%% .dipi-at-tab',
                'important'         => false
            ) );

        }

        // Tabs placement
        $tabs_placement = (isset($this->props['tabs_placement']) && !empty($this->props['tabs_placement']) )? $this->props['tabs_placement'] :'column'  ;
        $tabs_placement_tablet = (isset($this->props['tabs_placement_tablet']) && !empty($this->props['tabs_placement_tablet']) )? $this->props['tabs_placement_tablet'] :'column'  ;
        $tabs_placement_phone = (isset($this->props['tabs_placement_phone']) && !empty($this->props['tabs_placement_phone']) )? $this->props['tabs_placement_phone'] :'column'  ;
      
        $tabs_placement_rs = [
            'desktop' => $tabs_placement,
            'tablet' => $tabs_placement_tablet,
            'phone' => $tabs_placement_phone,
        ];
        
        foreach($tabs_placement_rs as $device => $value){
            $value = (isset($value) && !empty($value))? $value : 'column';
            $settings = [
                'selector' => '%%order_class%% .dipi-at-container',
                'declaration' => sprintf('flex-direction:%1$s;',$value)
            ];
            switch($device){
                case 'tablet':
                    $settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_980');
                    break;
                case 'phone':
                    $settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_767');
                    break;
            }
            ET_Builder_Element::set_style($render_slug, $settings);
        }
      
        // Tabs Items Placement, Alignment and width
        $tabs_container_width = (isset($this->props['tabs_container_width']) && !empty($this->props['tabs_container_width']) )? $this->props['tabs_container_width'] :'20%'  ;
        $tabs_container_width_tablet = (isset($this->props['tabs_container_width_tablet']) && !empty($this->props['tabs_container_width_tablet']) )? $this->props['tabs_container_width_tablet'] :'50%'  ;
        $tabs_container_width_phone = (isset($this->props['tabs_container_width_phone']) && !empty($this->props['tabs_container_width_phone']) )? $this->props['tabs_container_width_phone'] :'50%'  ;
      
        $tabs_container_width_rs = [
            'desktop' => $tabs_container_width,
            'tablet' => $tabs_container_width_tablet,
            'phone' => $tabs_container_width_phone,
        ];

         
        
        $tabs_align = (isset($this->props['tabs_align']) && !empty($this->props['tabs_align']))?$this->props['tabs_align']:'flex-start';
        $tabs_align_tablet = (isset($this->props['tabs_align_tablet']) && !empty($this->props['tabs_align_tablet']))?$this->props['tabs_align_tablet']:$tabs_align;
        $tabs_align_phone = (isset($this->props['tabs_align_phone']) && !empty($this->props['tabs_align_phone']))?$this->props['tabs_align_phone']:$tabs_align_tablet;
        $tabs_align_rs = [
            'desktop' => $tabs_align,
            'tablet' => $tabs_align_tablet,
            'phone' => $tabs_align_phone
        ];
        foreach($tabs_placement_rs as $device => $value){
          
            if ($value === 'row' || $value === 'row-reverse') {
                $tabs_container_width_rs[$device] = ('' !== $tabs_container_width_rs[$device]) ? $tabs_container_width_rs[$device]: '20%';
                $placement_settings = [
                    'selector' => '%%order_class%% .dipi-at-tabs',
                    'declaration' => 'flex-direction: column;'
                ];
                $width_settings = [
                    'selector' => '%%order_class%% .dipi-at-tabs-container .dipi-at-tabs',
                    'declaration' => "align-self:{$tabs_align_rs[$device]};justify-content:{$tabs_align_rs[$device]};width:{$tabs_container_width_rs[$device]};",
                ];
                $content_width = [
                    'selector' => '%%order_class%% .dipi-at-panels',
                    'declaration' => "width:calc(100% - {$tabs_container_width_rs[$device]});",
                ];
                switch($device){
                    case 'tablet':
                        $placement_settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_980');
                        $width_settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_980');
                        $content_width['media_query'] =  ET_Builder_Element::get_media_query('max_width_980');
                        break;
                    case 'phone':
                        $placement_settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_767');
                        $width_settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_767');
                        $content_width['media_query'] =  ET_Builder_Element::get_media_query('max_width_767');
                        break;
                }
                ET_Builder_Element::set_style($render_slug, $placement_settings);
                ET_Builder_Element::set_style($render_slug, $width_settings);
                ET_Builder_Element::set_style($render_slug, $content_width);
            }else{
                $placement_settings = [
                    'selector' => '%%order_class%% .dipi-at-tabs',
                    'declaration' => 'flex-direction: row;'
                ];
                $width_settings = [
                    'selector' => '%%order_class%% .dipi-at-tabs-container .dipi-at-tabs',
                    'declaration' => "align-self:{$tabs_align_rs[$device]};justify-content:{$tabs_align_rs[$device]};width:100%;",
                ];
                $content_width = [
                    'selector' => '%%order_class%% .dipi-at-panels',
                    'declaration' => "width:100%;",
                ];
                switch($device){
                    case 'tablet':
                        $width_settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_980');
                        $content_width['media_query'] =  ET_Builder_Element::get_media_query('max_width_980');
                        $placement_settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_980');
                        break;
                    case 'phone':
                        $width_settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_767');
                        $content_width['media_query'] =  ET_Builder_Element::get_media_query('max_width_767');
                        $placement_settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_767');
                        break;
                }
                ET_Builder_Element::set_style($render_slug, $placement_settings);
                ET_Builder_Element::set_style($render_slug, $width_settings);
                ET_Builder_Element::set_style($render_slug, $content_width);
            }
        }
        // End of Tabs Items Placement, Alignment and width

        $this->set_background_css(
            $render_slug,
            '%%order_class%% .dipi-at-tabs',
            '%%order_class%% .dipi-at-tabs:hover',
            'tabs_bg',
            'tabs_bg_color'
        );

        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'tabs_container_padding',
            'css_property'   => 'padding',
            'selector'       => '%%order_class%% .dipi-at-tabs',
            'hover_selector' => '%%order_class%% .dipi-at-tabs:hover'
        ]);

        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'tabs_container_margin',
            'css_property'   => 'margin',
            'selector'       => '%%order_class%% .dipi-at-tabs',
            'hover_selector' => '%%order_class%% .dipi-at-tabs:hover'
        ]);
    }

    public function _content_style($render_slug) {
        $content_vertical_align_rs = $this->dipi_get_responsive_prop('content_vertical_align');
        foreach($content_vertical_align_rs as $device => $value){
            $settings = [
                'selector' => "%%order_class%% .dipi-at-panel-content[data-imgplacement-$device*='row']",
                'declaration' => sprintf('align-items:%1$s;',$value)
            ];

            switch($device){
                case 'tablet':
                    $settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_980');break;
                case 'phone':
                    $settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_767');break;
            }
            ET_Builder_Element::set_style($render_slug, $settings);


            $settings = [
                'selector' => "%%order_class%% .dipi-at-panel-content[data-imgplacement-$device*='col']",
                'declaration' => sprintf('justify-content:%1$s;',$value)
            ];
            switch($device){
                case 'tablet':
                    $settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_980');break;
                case 'phone':
                    $settings['media_query'] =  ET_Builder_Element::get_media_query('max_width_767');break;
            }
            ET_Builder_Element::set_style($render_slug, $settings);
        }

        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'content_padding',
            'css_property'   => 'padding',
            'selector'       => '%%order_class%% .dipi-at-panels',
            'hover_selector' => '%%order_class%% .dipi-at-panels:hover'
        ]);

        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'content_margin',
            'css_property'   => 'margin',
            'selector'       => '%%order_class%% .dipi-at-panels',
            'hover_selector' => '%%order_class%% .dipi-at-panels:hover'
        ]);
        $this->set_background_css(
            $render_slug,
            '%%order_class%% .dipi-at-panels',
            '%%order_class%% .dipi-at-panels:hover',
            'content_bg',
            'content_bg_color'
        );
    }

    public function _tabs_item_style($render_slug) {
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'tabs_item_padding',
            'css_property'   => 'padding',
            'selector'       => '%%order_class%% .dipi-at-tabs .dipi-at-tab:not(.dipi-at-tab--active)',
            'hover_selector' => '%%order_class%% .dipi-at-tabs .dipi-at-tab:hover:not(.dipi-at-tab--active)'
        ]);

        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'tabs_item_margin',
            'css_property'   => 'margin',
            'selector'       => '%%order_class%% .dipi-at-tabs .dipi-at-tab:not(.dipi-at-tab--active)',
            'hover_selector' => '%%order_class%% .dipi-at-tabs .dipi-at-tab:hover:not(.dipi-at-tab--active)'
        ]);
 
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'tabs_icon_padding',
            'css_property'   => 'padding',
            'selector'       => '%%order_class%% .dipi-at-tabs .dipi-at-tab .dipi-tab-media--normal',
            'hover_selector' => '%%order_class%% .dipi-at-tabs .dipi-at-tab .dipi-tab-media--normal:hover'
        ]);

        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'tabs_icon_margin',
            'css_property'   => 'margin',
            'selector'       => '%%order_class%% .dipi-at-tabs .dipi-at-tab .dipi-tab-media--normal',
            'hover_selector' => '%%order_class%% .dipi-at-tabs .dipi-at-tab .dipi-tab-media--normal:hover'
        ]);
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'tabs_text_padding',
            'css_property'   => 'padding',
            'selector'       => '%%order_class%% .dipi-at-tabs .dipi-at-tab:not(.dipi-at-tab--active) .dipi-at-tab-container',
            'hover_selector' => '%%order_class%% .dipi-at-tabs .dipi-at-tab:not(.dipi-at-tab--active) .dipi-at-tab-container:hover'
        ]);
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'tabs_text_margin',
            'css_property'   => 'margin',
            'selector'       => '%%order_class%% .dipi-at-tabs .dipi-at-tab:not(.dipi-at-tab--active) .dipi-at-tab-container',
            'hover_selector' => '%%order_class%% .dipi-at-tabs .dipi-at-tab:not(.dipi-at-tab--active) .dipi-at-tab-container:hover'
        ]);

        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'tabs_text_padding_active',
            'css_property'   => 'padding',
            'selector'       => '%%order_class%% .dipi-at-tabs .dipi-at-tab.dipi-at-tab--active .dipi-at-tab-container',
            'hover_selector' => '%%order_class%% .dipi-at-tabs .dipi-at-tab.dipi-at-tab--active .dipi-at-tab-container:hover'
        ]);
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'tabs_text_margin_active',
            'css_property'   => 'margin',
            'selector'       => '%%order_class%% .dipi-at-tabs .dipi-at-tab.dipi-at-tab--active .dipi-at-tab-container',
            'hover_selector' => '%%order_class%% .dipi-at-tabs .dipi-at-tab.dipi-at-tab--active .dipi-at-tab-container:hover'
        ]);


        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'tabs_icon_padding_active',
            'css_property'   => 'padding',
            'selector'       => '%%order_class%% .dipi-at-tabs .dipi-at-tab .dipi-tab-media--active',
            'hover_selector' => '%%order_class%% .dipi-at-tabs .dipi-at-tab .dipi-tab-media--active:hover'
        ]);

        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'tabs_icon_margin_active',
            'css_property'   => 'margin',
            'selector'       => '%%order_class%% .dipi-at-tabs .dipi-at-tab .dipi-tab-media--active',
            'hover_selector' => '%%order_class%% .dipi-at-tabs .dipi-at-tab .dipi-tab-media--active:hover'
        ]);

        $this->set_background_css(
            $render_slug,
            '%%order_class%% .dipi-at-tabs .dipi-at-tab:not(.dipi-at-tab--active)',
            '%%order_class%% .dipi-at-tabs .dipi-at-tab:hover:not(.dipi-at-tab--active)',
            'tabs_item_bg',
            'tabs_item_bg_color'
        );
    }

    public function _active_arrow_style($render_slug) {
        
        if($this->props['use_active_arrow'] !== 'on') return;
        ET_Builder_Element::set_style($render_slug, [
            'selector' => "%%order_class%% .dipi-at-tabs .dipi-at-tab svg",
            'declaration' => sprintf('fill: %1$s;', esc_attr($this->props['active_arrow_color']))
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => "%%order_class%% .dipi-at-tabs.has-arrow, %%order_class%% .dipi-at-tabs.has-arrow .dipi-at-tab.dipi-at-tab--active",
            'declaration' => 'overflow:visible'
        ]);

        if ($this->props['tabs_placement'] === 'row' || $this->props['tabs_placement'] === 'row-reverse') {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-at-tabs .dipi-at-tab svg',
                'declaration' => sprintf('height: %1$s !important; width: auto;', esc_attr($this->props['active_arrow_size']))
            ));
        } else {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-at-tabs .dipi-at-tab svg',
                'declaration' => sprintf('width: %1$s; height: auto;', esc_attr($this->props['active_arrow_size']))
            ));
        }
    }
     
    public function _tabs_item_active_style($render_slug) {
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'tabs_active_item_padding',
            'css_property'   => 'padding',
            'selector'       => '%%order_class%% .dipi-at-tabs .dipi-at-tab.dipi-at-tab--active',
            'hover_selector' => '%%order_class%% .dipi-at-tabs .dipi-at-tab.dipi-at-tab--active:hover'
        ]);
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'tabs_active_item_margin',
            'css_property'   => 'margin',
            'selector'       => '%%order_class%% .dipi-at-tabs .dipi-at-tab.dipi-at-tab--active',
            'hover_selector' => '%%order_class%% .dipi-at-tabs .dipi-at-tab.dipi-at-tab--active:hover'
        ]);
        $this->set_background_css(
            $render_slug,
            '%%order_class%% .dipi-at-tabs .dipi-at-tab.dipi-at-tab--active',
            '%%order_class%% .dipi-at-tabs .dipi-at-tab.dipi-at-tab--active:hover',
            'tabs_item_active_bg',
            'tabs_item_active_bg_color'
        );
    }

    public function _tabs_slider_style($render_slug) {

        if($this->props['enable_tabs_slider'] !== 'on') return;
        
        $slider_settings = [
            'enable_ts_on_wide' => ($this->props['enable_ts_on_wide']) ? $this->props['enable_ts_on_wide'] : 'off',
            'tabs_per_view_wide' => ($this->props['tabs_per_view_wide']) ? $this->props['tabs_per_view_wide'] : 2,
            'ts_navigation_wide' => ($this->props['ts_navigation_wide'])? $this->props['ts_navigation_wide'] : 'off',
            'ts_navigation_vertical_position_wide' => ($this->props['ts_navigation_vertical_position_wide'])? $this->props['ts_navigation_vertical_position_wide'] : '50',
            'ts_navigation_horizontal_position_wide' => ($this->props['ts_navigation_horizontal_position_wide']) ? $this->props['ts_navigation_horizontal_position_wide'] : '0',
            
            'enable_ts_on_tab' => ($this->props['enable_ts_on_tab']) ? $this->props['enable_ts_on_tab'] : 'off',
            'tabs_per_view_tab' => ($this->props['tabs_per_view_tab']) ? $this->props['tabs_per_view_tab'] : 2,
            'ts_navigation_tab' => ($this->props['ts_navigation_tab'])? $this->props['ts_navigation_tab'] : 'off',
            'ts_navigation_vertical_position_tab' => ($this->props['ts_navigation_vertical_position_tab'])? $this->props['ts_navigation_vertical_position_tab'] : '50',
            'ts_navigation_horizontal_position_tab' => ($this->props['ts_navigation_horizontal_position_tab']) ? $this->props['ts_navigation_horizontal_position_tab'] : '0',
            
            'enable_ts_on_pho' => ($this->props['enable_ts_on_pho']) ? $this->props['enable_ts_on_pho'] : 'off',
            'tabs_per_view_pho' => ($this->props['tabs_per_view_pho']) ? $this->props['tabs_per_view_pho'] : 2,
            'ts_navigation_pho' => ($this->props['ts_navigation_pho'])? $this->props['ts_navigation_pho'] : 'off',
            'ts_navigation_vertical_position_pho' => ($this->props['ts_navigation_vertical_position_pho'])? $this->props['ts_navigation_vertical_position_pho'] : '50',
            'ts_navigation_horizontal_position_pho' => ($this->props['ts_navigation_horizontal_position_pho']) ? $this->props['ts_navigation_horizontal_position_pho'] : '0',
        ];
        $views =['wide', 'tab', 'pho'];

        foreach($views as $view) {
            if($slider_settings['enable_ts_on_'.$view] === 'on') {
                $v_position = array(
                    'selector' => "
                        %%order_class%% .dipi-at-tabs-prev:not(.sticky),
                        %%order_class%% .dipi-at-tabs-next:not(.sticky)",
                        'declaration' => sprintf('top: %1$s !important;', $slider_settings['ts_navigation_vertical_position_'.$view].'px'),
                );
                if($view === 'tab') {
                    $v_position['media_query'] = ET_Builder_Element::get_media_query('max_width_980');
                } else if($view === 'pho') {
                    $v_position['media_query'] = ET_Builder_Element::get_media_query('max_width_767');
                }
                ET_Builder_Element::set_style($render_slug, $v_position);
                $h_pos_prev = array(
                    'selector' => "%%order_class%% .dipi-at-tabs-prev:not(.sticky)",
                    'declaration' => sprintf('left: %1$s !important;', esc_attr($slider_settings['ts_navigation_horizontal_position_'.$view]).'px'),
                );
                if($view === 'tab') {
                    $h_pos_prev['media_query'] = ET_Builder_Element::get_media_query('max_width_980');
                } else if($view === 'pho') {
                    $h_pos_prev['media_query'] = ET_Builder_Element::get_media_query('max_width_767');
                }
                ET_Builder_Element::set_style($render_slug, $h_pos_prev);
                $h_pos_next = array(
                    'selector' => "%%order_class%% .dipi-at-tabs-next",
                    'declaration' => sprintf('right: %1$s !important;', esc_attr($slider_settings['ts_navigation_horizontal_position_'.$view]).'px'),
                );

                if($view === 'tab') {
                    $h_pos_next['media_query'] = ET_Builder_Element::get_media_query('max_width_980');
                } else if($view === 'pho') {
                    $h_pos_next['media_query'] = ET_Builder_Element::get_media_query('max_width_767');
                }
                ET_Builder_Element::set_style($render_slug, $h_pos_next);


                 
            }
        }

        if ('on' === $this->props['navigation_next_icon_yn']) {
            $this->dipi_generate_font_icon_styles($render_slug, 'navigation_next_icon', '%%order_class%% .dipi-at-tabs-next:after');
        }

        if ('on' === $this->props['navigation_prev_icon_yn']) {
            $this->dipi_generate_font_icon_styles($render_slug, 'navigation_prev_icon', '%%order_class%% .dipi-at-tabs-prev:after');
        }


        $this->process_range_field_css( array(
            'render_slug'       => $render_slug,
            'slug'              => 'navigation_size',
            'type'              => 'font-size',
            'fixed_unit'            => 'px',
            'selector'          => '%%order_class%% .dipi-at-tabs-prev, %%order_class%% .dipi-at-tabs-next',
            'important'         => true
        ) );
        
        $this->process_range_field_css( array(
            'render_slug'       => $render_slug,
            'slug'              => 'navigation_padding',
            'type'              => 'padding',
            'fixed_unit'            => 'px',  
            'selector'          => '%%order_class%% .dipi-at-tabs-prev, %%order_class%% .dipi-at-tabs-next',
            'important'         => true
        ) );

        $this->process_color_field_css(array(
            'render_slug'       => $render_slug,
            'slug'              => 'navigation_color',
            'type'              => 'color',
            'selector'          => '%%order_class%% .dipi-at-tabs-prev, %%order_class%% .dipi-at-tabs-next',
            'hover'             => '%%order_class%% .dipi-at-tabs-prev:hover, %%order_class%% .dipi-at-tabs-next:hover',
            'important'         => true
        ));
        
        $this->process_color_field_css(array(
            'render_slug'       => $render_slug,
            'slug'              => 'navigation_bg_color',
            'type'              => 'background-color',
            'selector'          => '%%order_class%% .dipi-at-tabs-prev, %%order_class%% .dipi-at-tabs-next',
            'hover'             => '%%order_class%% .dipi-at-tabs-prev:hover, %%order_class%% .dipi-at-tabs-next:hover',
            'important'         => true
        ));
    
        if ('on' == $this->props['navigation_circle']) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-at-tabs-prev, %%order_class%% .dipi-at-tabs-next',
                'declaration' => 'border-radius: 50% !important;',
            ));
        }
    }

    public function before_render() {
        global $dipi_at_tabs;
        $dipi_at_tabs = [];
    }

    public function _render_tabs() {
        global $dipi_at_tabs;
        $tabs_placement = $this->props['tabs_placement'] !== '' ? $this->props['tabs_placement'] : 'column';
        $arrows = array(
            'column'         => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 255 127.5" width="30px"><g><polygon points="0 0 127.5 127.5 255 0 0 0"/></g></svg>',
            'column-reverse' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 255 127.5" width="30px"><g><polygon points="255 127.5 127.5 0 0 127.5 255 127.5"/></g></svg>',
            'row'            => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 127.5 255" height="30px"><g><polygon points="0 255 127.5 127.5 0 0 0 255"/></g></svg>',
            'row-reverse'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 127.5 255" height="30px"><g><polygon points="127.5 0 0 127.5 127.5 255 127.5 0"/></g></svg>'
        );
        $arrow = $this->props['use_active_arrow'] === 'on' ? $arrows[$tabs_placement] : '';
        
        
        $tabs_html = '';
        
        foreach($dipi_at_tabs as $classname => $tab){
            $tab_text = '';
            $media = '';
            $extra_class = '';
            if(!empty($tab['title']) || !empty($tab['subtitle'])){
                $title_html = sprintf('<div class="dipi-at-tab-title">%1$s</div>', $tab['title']);
                $subtitle_html = sprintf('<div class="dipi-at-tab-subtitle">%1$s</div>', $tab['subtitle']);
                $tab_text = sprintf('<div class="dipi-at-tab-container">%1$s %2$s</div>', $title_html, $subtitle_html);
            }

            if(isset($tab['tab_media']) && $tab['tab_media'] === 'icon') {
                $icon_class = '';
                $font_icon_code = ($tab['font_icon'] === '%&quot;%%' || $tab['font_icon'] === '%"%%') ? '%%22%%' : $tab['font_icon'];
                $font_icon = et_pb_process_font_icon($font_icon_code);
                $font_icon_active_code = (isset($tab['font_icon_active']) && !empty($tab['font_icon_active']) && isset($tab['use_active_tab_icon']) && $tab['use_active_tab_icon'] === 'on') ? $tab['font_icon_active'] : $font_icon_code;
                $font_icon_active_code = ($font_icon_active_code === '%&quot;%%' || $font_icon_active_code === '%"%%') ? '%%22%%' : $font_icon_active_code;
                $font_icon_active = et_pb_process_font_icon($font_icon_active_code);
                $media = sprintf('<span class="at-media-wrap %3$s">
                    <span class="et-pb-icon dipi-tab-media dipi-tab-media--normal">%1$s</span>
                    <span class="et-pb-icon dipi-tab-media dipi-tab-media--active">%2$s</span>
                    </span>', 
                    $font_icon,
                    $font_icon_active,
                    $icon_class
                );
             
            }

            if(isset($tab['tab_media']) && $tab['tab_media'] === 'image') {
                $icon_class = '';
                $image_alignment = [];
                $image_extra_class = '';
                switch($tab['tab_image_placement']):
                    case "top":
                        $image_alignment['desktop'] = $tab['tab_image_alignment_horz1'];
                        $image_alignment['tablet'] = $tab['tab_image_alignment_horz1_tablet'];
                        $image_alignment['phone'] = $tab['tab_image_alignment_horz1_phone'];
                        break;
                    case "bottom":
                        $image_alignment['desktop'] = $tab['tab_image_alignment_horz2'];
                        $image_alignment['tablet'] = $tab['tab_image_alignment_horz2_tablet'];
                        $image_alignment['phone'] = $tab['tab_image_alignment_horz2_phone'];
                       break;
                endswitch;

                 
                

                $tab_image = (isset( $tab['tab_image']) && !empty( $tab['tab_image'])) ?  $tab['tab_image'] : '';
                $tab_image_active = (isset( $tab['tab_image_active']) && !empty( $tab['tab_image_active']) && $tab['use_active_tab_image'] === 'on') ?  $tab['tab_image_active'] : $tab_image;
                $media = sprintf('
                    <span class="at-media-wrap ">
                        <span class=" dipi-tab-media dipi-tab-media--normal">
                            <img src="%1$s"   />
                        </span>
                        <span class=" dipi-tab-media dipi-tab-media--active">
                            <img src="%2$s"   />
                        </span>
                    </span>', 
                    $tab_image,
                    $tab_image_active 
                    
                );
                if($tab['tab_image_placement'] === 'left' || $tab['tab_image_placement'] === 'right'){
                    $extra_class .= ' dipi-at-horz-media';
                }
            }
            
            $activate_selector = $tab['activate_tab_selector'];
            $scroll_tab_offset = $tab['scroll_tab_offset'];
             
            $activate_selector_data = (isset($activate_selector) && !empty($activate_selector)) ? sprintf('data-activate-selector="%1$s"', $activate_selector) : '';
            $scroll_tab_offset_data = (isset($scroll_tab_offset) && !empty($scroll_tab_offset)) ? sprintf('data-tab-scroll-off="%1$s"', $scroll_tab_offset) : '';
            
                 $tabs_html .= sprintf('<div class="dipi-at-tab %3$s %6$s" data-panel="%3$s" %7$s %8$s> 
                    %4$s   
                    %1$s
                    %5$s
                </div>',
                    $tab_text, // #1
                    '',  // #2
                    esc_attr($classname), // #3 
                    $media, // #4
                    $arrow, // #5
                    $extra_class,
                    $activate_selector_data,
                    $scroll_tab_offset_data
                    
                );
          
            
        }
        return $tabs_html;
    }

    public function render($attrs, $content, $render_slug) {
        
        $tb_slider = '';
        $json_slider_settings = '';
        $next_icon_render = '';
        $prev_icon_render = '';

        if($this->props['enable_tabs_slider'] === 'on') {
            $tb_slider = 'dipi-at-slider';
            $slider_settings = [
                'enable_ts_on_wide' => ($this->props['enable_ts_on_wide']) ? $this->props['enable_ts_on_wide'] : 'off',
                'tabs_per_view_wide' => ($this->props['tabs_per_view_wide']) ? $this->props['tabs_per_view_wide'] : 2,
                'ts_navigation_wide' => ($this->props['ts_navigation_wide'])? $this->props['ts_navigation_wide'] : 'off',
               
                'enable_ts_on_tab' => ($this->props['enable_ts_on_tab']) ? $this->props['enable_ts_on_tab'] : 'off',
                'tabs_per_view_tab' => ($this->props['tabs_per_view_tab']) ? $this->props['tabs_per_view_tab'] : 2,
                'ts_navigation_tab' => ($this->props['ts_navigation_tab'])? $this->props['ts_navigation_tab'] : 'off',
                 // 'ts_navigation_horizontal_position_tablet' => ($this->props['ts_navigation_horizontal_position_tablet']) ? $this->props['ts_navigation_horizontal_position_tablet'] : '0',
                
                'enable_ts_on_pho' => ($this->props['enable_ts_on_pho']) ? $this->props['enable_ts_on_pho'] : 'off',
                'tabs_per_view_pho' => ($this->props['tabs_per_view_pho']) ? $this->props['tabs_per_view_pho'] : 2,
                'ts_navigation_pho' => ($this->props['ts_navigation_pho'])? $this->props['ts_navigation_pho'] : 'off',
             ];
            $json_slider_settings = wp_json_encode($slider_settings);

            $data_next_icon = $this->props['navigation_next_icon'];
            $data_prev_icon = $this->props['navigation_prev_icon'];
            $next_icon_render = 'data-next-icon="9"';
            if ('on' === $this->props['navigation_next_icon_yn']) {
                $next_icon_render = sprintf('data-next-icon="%1$s"', esc_attr(et_pb_process_font_icon($data_next_icon)));
            }

            $prev_icon_render = 'data-prev-icon="8"';
            if ('on' === $this->props['navigation_prev_icon_yn']) {
                $prev_icon_render = sprintf('data-prev-icon="%1$s"', esc_attr(et_pb_process_font_icon($data_prev_icon)));
            }
        }


        $order_class = self::get_module_order_class($render_slug);
        $contents =  et_core_sanitized_previously($this->content);
        wp_enqueue_style('dipi_animate');
        wp_enqueue_script('dipi_sticky');
        wp_enqueue_script('dipi_advanced_tabs');
        $this->_apply_css($render_slug);
        $placement = array(
            'column'         => 'top',
            'column-reverse' => 'bottom',
            'row'            => 'left',
            'row-reverse'    => 'right'
        );
        $tabs_placement = $this->props['tabs_placement'] !== '' ? $this->props['tabs_placement'] : 'column';
        $arrow_class = 'has-arrow arrow-place-' . $placement[$tabs_placement];
        $arrow_align = $this->props['arrow_align'];
        $arrow_class .= " arrow-allign-" . $arrow_align;
        $tabs_html = $this->_render_tabs();

        $sticky_distance = isset($this->props['sticky_tabs_distance']) ? 
            $this->props['sticky_tabs_distance'] : '55px';
        $sticky_distance_tablet = isset($this->props['sticky_tabs_distance_tablet']) && $this->props['sticky_tabs_distance_tablet'] !== '' ? 
            $this->props['sticky_tabs_distance_tablet'] : $sticky_distance;
        $sticky_distance_phone = isset($this->props['sticky_tabs_distance_phone']) ? 
            $this->props['sticky_tabs_distance_phone'] : $sticky_distance_tablet;

        global $dipi_at_tabs;
        $default_tab = 0;
        $index = 1;
        foreach($dipi_at_tabs as $classname => $tab) {
            if($tab['is_default_tab'] === 'on' ){
                $default_tab = $index;
                break;
            }
            $index++;
        }
        $ts_navigation_vertical_position_wide = $this->props['ts_navigation_vertical_position_wide']? $this->props['ts_navigation_vertical_position_wide'] : '50';
        $ts_navigation_vertical_position_tab = $this->props['ts_navigation_vertical_position_tab']? $this->props['ts_navigation_vertical_position_tab'] : $ts_navigation_vertical_position_wide;
        $ts_navigation_vertical_position_pho = $this->props['ts_navigation_vertical_position_pho']? $this->props['ts_navigation_vertical_position_pho'] : $ts_navigation_vertical_position_tab;
        $ts_navigation_horizontal_position_wide = $this->props['ts_navigation_horizontal_position_wide']? $this->props['ts_navigation_horizontal_position_wide'] : '0';
        $ts_navigation_horizontal_position_tab = $this->props['ts_navigation_horizontal_position_tab']? $this->props['ts_navigation_horizontal_position_tab'] : $ts_navigation_horizontal_position_wide;
        $ts_navigation_horizontal_position_pho = $this->props['ts_navigation_horizontal_position_pho']? $this->props['ts_navigation_horizontal_position_pho'] : $ts_navigation_horizontal_position_tab;
        $data = [
            'tab_animation' => $this->props['tab_animation'],
            'animation_duration' => $this->props['dipi_animation_duration'],
            'activate_on_hover' => $this->props['activate_on_hover'],
            'activate_first_tab_as_placeholder' => $this->props['activate_first_tab_as_placeholder'],
            'use_sticky_tabs'        => $this->props['use_sticky_tabs'],
            'use_scroll_to_content'  => htmlspecialchars(json_encode($this->dipi_get_responsive_prop('use_scroll_to_content')), ENT_QUOTES, 'UTF-8'),
            'scroll_to_content_offset'  => htmlspecialchars(json_encode($this->dipi_get_responsive_prop('scroll_to_content_offset')), ENT_QUOTES, 'UTF-8'),
            'ts_navigation_vertical_position'  => htmlspecialchars(json_encode([
                'desktop' => $ts_navigation_vertical_position_wide,
                'tablet' => $ts_navigation_vertical_position_tab,
                'phone' => $ts_navigation_vertical_position_pho
            ]), ENT_QUOTES, 'UTF-8'),
            'ts_navigation_horizontal_position'  => htmlspecialchars(json_encode([
                    'desktop' => $ts_navigation_horizontal_position_wide,
                    'tablet' => $ts_navigation_horizontal_position_tab,
                    'phone' => $ts_navigation_horizontal_position_pho
                ]), ENT_QUOTES, 'UTF-8'),
            // esc_attr(json_encode()), // $this->props[''],
            'sticky_distance'        => $sticky_distance,
            'sticky_distance_tablet' => $sticky_distance_tablet,
            'sticky_distance_phone'  => $sticky_distance_phone,
            'admin_bar_space'        => is_admin_bar_showing() ? true : false,
            'turn_off_sticky'        => $this->props['turn_off_sticky'],
            'module_class'           => $order_class,
            'default_tab'           => $default_tab
        ];
        $dataset = '';
        foreach($data as $key => $value){
            $dataset .= ' data-'.$key.'="'.$value.'"';
        }
        $output = sprintf(
                '<div class="dipi-advanced-tabs dipi-at-container dipi-advanced-tabs-front" %4$s>
                    <div class="dipi-at-tabs-container %5$s" data-slider=\'%6$s\' %7$s %8$s >
                        <div class="dipi-at-tabs %3$s">%2$s</div>
                    </div>
                    <div class="dipi-at-panels">%1$s</div>
                </div>',
            $contents,
            $tabs_html,
            $arrow_class,
            $dataset,
            $tb_slider, // #5
            $json_slider_settings,
            $next_icon_render,
            $prev_icon_render
        );
        return $output;
    }
}    
new DIPI_AdvancedTabs();