<?php

class DIPI_AdvancedTabsItem extends DIPI_Builder_Module
{
    public function init()
    {
        $this->name = esc_html__('Pixel Advanced Tabs Item', 'dipi-divi-pixel');
        $this->plural = esc_html__('Pixel Advanced Tabs Item', 'dipi-divi-pixel');
        $this->slug = 'dipi_advanced_tabs_item';
        $this->vb_support = 'on';
        $this->type = 'child';
        $this->child_title_var = 'admin_label';
        $this->advanced_setting_title_text = esc_html__('New Item', 'dipi-divi-pixel');
        $this->settings_text = esc_html__('Item Settings', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%.dipi_advanced_tabs_item';
    }
    public function get_custom_css_fields_config()
    {
        $fields = [];
        $fields['normal_tab'] = [
            'label' => esc_html__('Normal Tab', 'dipi-divi-pixel'),
            'selector' => '.dipi_advanced_tabs .dipi-at-tabs %%order_class%%.dipi-at-tab:not(.dipi-at-tab--active)',
        ];

        $fields['active_tab'] = [
            'label' => esc_html__('Active Tab', 'dipi-divi-pixel'),
            'selector' => '.dipi_advanced_tabs .dipi-at-tabs %%order_class%%.dipi-at-tab.dipi-at-tab--active',
        ];

        $fields['nomral_tab_image'] = [
            'label' => esc_html__('Normal Tab Image', 'dipi-divi-pixel'),
            'selector' => '.dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--normal img'
        ];
        $fields['active_tab_image'] = [
            'label' => esc_html__('Active Tab Image', 'dipi-divi-pixel'),
            'selector' => '.dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--active img'
        ];
        $fields['nomral_tab_icon'] = [
            'label' => esc_html__('Normal Tab Icon', 'dipi-divi-pixel'),
            'selector' => '.dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--normal.et-pb-icon'
        ];
        $fields['active_tab_icon'] = [
            'label' => esc_html__('Active Tab Icon', 'dipi-divi-pixel'),
            'selector' => '.dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--active.et-pb-icon'
        ];
        $fields['dipi_button'] = [
            'label' => esc_html__('Button', 'dipi-divi-pixel'),
            'selector' => '.dipi_advanced_tabs %%order_class%%.dipi_advanced_tabs_item .et_pb_button.dipi-at-btn'
        ];

        
        return $fields;
    }

    public function get_settings_modal_toggles(){
        return array(
            'general'   => array(
                'toggles'      => array(
                    'content' => esc_html__('Content', 'dipi-divi-pixel'),
                    'image' => esc_html__('Content Image', 'dipi-divi-pixel'),
                    'image_icon' => esc_html__("Tab Image/Icon", 'dipi-divi-pixel'),
                    'tab_selector' => esc_html__('Tab Selector', 'dipi-divi-pixel'),
                    'background' => esc_html__('Content Background', 'dipi-divi-pixel'),
                    'tab_background' =>[
                        'title' => esc_html__('Tab Background', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => array(
							'normal'     => array(
								'name' => 'Normal'
							),
							'active'     => array(
								'name' => 'Active'
							)
						)
                    ],
                    'at_button' => esc_html__('Button', 'dipi-divi-pixel'),
                    'text_area' => esc_html__('Text Area Background', 'dipi-divi-pixel'),
                ),
            ),
            'advanced'   => array(
                'toggles'   => array(
                    'tabs_text'      => array(
                        'title'             => esc_html__('Tab Text', 'dipi-divi-pixel'),
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
                    'tab_icon'      => array(
                        'title'     => esc_html__('Tab Icon', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => array(
							'normal'     => array(
								'name' => 'Normal'
							),
							'active'     => array(
								'name' => 'Active'
							)
						)
                    ),
                    'tab_image'   =>[
                        'title' => esc_html__('Tab Image Style', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles'       => array(
							'normal'     => array(
								'name' => 'Normal'
							),
							'active'     => array(
								'name' => 'Active'
							)
						)
                    ], 
                    'image'   => esc_html__('Image Style', 'dipi-divi-pixel'),
                    'text'   => array(
						'title'             => esc_html__('Text', 'dipi-divi-pixel'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'     => array(
								'name' => 'P',
								'icon' => 'text-left',
							),
							'a'     => array(
								'name' => 'A',
								'icon' => 'text-link',
							),
							'ul'    => array(
								'name' => 'UL',
								'icon' => 'list',
							),
							'ol'    => array(
								'name' => 'OL',
								'icon' => 'numbered-list',
							),
							'quote' => array(
								'name' => 'QUOTE',
								'icon' => 'text-quote',
							),
						),
					),
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
                    'at_button'     => esc_html__('Button', 'dipi-divi-pixel')
                )
            ),
        );
    }

    public function get_advanced_fields_config() {
       
        $advanced_fields = array();
        $advanced_fields['fonts']  = array(
            'title'     => array(
                'label'           => et_builder_i18n( 'Title' ),
                'css'             => array(
                    'main'        => ".dipi_advanced_tabs .dipi-at-tabs %%order_class%%.dipi-at-tab .dipi-at-tab-title"
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
            'subtitle'     => array(
                'label'           => et_builder_i18n( 'Sub Title' ),
                'css'             => array(
                    'main'        => ".dipi_advanced_tabs .dipi-at-tabs %%order_class%%.dipi-at-tab .dipi-at-tab-subtitle"
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
            'text'     => array(
                'label'           => et_builder_i18n( 'Text' ),
                'css'             => array(
                    'main'        => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content",
                    'line_height' => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content",
                    'color'       => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content",
                ),
                'line_height'     => array(
                    'default' => floatval( et_get_option( 'body_font_height', '1.7' ) ) . 'em',
                ),
                'font_size'       => array(
                    'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
                ),
                'toggle_slug'     => 'text',
                'sub_toggle'      => 'p',
                // 'hide_text_align' => true,
            ),
            'link'     => array(
                'label'       => et_builder_i18n( 'Link' ),
                'css'         => array(
                    'main'  => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content a",
                    'color' => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content a",
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size'   => array(
                    'default' => absint( et_get_option( 'body_font_size', '14' ) ) . 'px',
                ),
                'hide_text_align' => true,
                'toggle_slug' => 'text',
                'sub_toggle'  => 'a',
            ),
            'ul'       => array(
                'label'       => esc_html__( 'Unordered List', 'et_builder' ),
                'css'         => array(
                    'main'        => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content ul li",
                    'color'       => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content ul li",
                    'line_height' => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content ul li",
                    'item_indent' => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content ul",
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'toggle_slug' => 'text',
                'sub_toggle'  => 'ul',
            ),
            'ol'       => array(
                'label'       => esc_html__( 'Ordered List', 'et_builder' ),
                'css'         => array(
                    'main'        => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content ol li",
                    'color'       => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content ol li",
                    'line_height' => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content ol li",
                    'item_indent' => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content ol",
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'toggle_slug' => 'text',
                'sub_toggle'  => 'ol',
            ),
            'quote'    => array(
                'label'       => esc_html__( 'Blockquote', 'et_builder' ),
                'css'         => array(
                    'main'  => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content blockquote",
                    'color' => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content blockquote",
                ),
                'line_height' => array(
                    'default' => '1em',
                ),
                'font_size'   => array(
                    'default' => '14px',
                ),
                'toggle_slug' => 'text',
                'sub_toggle'  => 'quote',
            ),
            'header'   => array(
                'label'       => esc_html__( 'Heading', 'et_builder' ),
                'css'         => array(
                    'main' => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content h1",
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
                    'main' => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content h2",
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
                    'main' => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content h3",
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
                    'main' => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content h4",
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
                    'main' => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content h5",
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
                    'main' => ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content h6",
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
                'css'       => array(
                    'main'  => array(
                        'border_radii' => ".dipi_at_all_tabs {$this->main_css_element}",
                        'border_radii_hover'  => ".dipi_at_all_tabs {$this->main_css_element}:hover",
                        'border_styles' => ".dipi_at_all_tabs {$this->main_css_element}",
                        'border_styles_hover' => ".dipi_at_all_tabs {$this->main_css_element}:hover",
                    )
                )
            ),
            'image'                => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".dipi_advanced_tabs {$this->main_css_element} .dipi-at-panel-content .dipi-at-panel-image",
                        'border_radii_hover'  => ".dipi_advanced_tabs {$this->main_css_element} .dipi-at-panel-content .dipi-at-panel-image:hover",
                        'border_styles' => ".dipi_advanced_tabs {$this->main_css_element} .dipi-at-panel-content .dipi-at-panel-image",
                        'border_styles_hover' => ".dipi_advanced_tabs {$this->main_css_element} .dipi-at-panel-content .dipi-at-panel-image:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'image'
            ),
            'tab_image'                => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--normal img",
                        'border_radii_hover'  => ".dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--normal img:hover",
                        'border_styles' => ".dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--normal img",
                        'border_styles_hover' => ".dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--normal img:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'tab_image',
                'sub_toggle'  => 'normal',
                'show_if' => ['tab_media' => 'image']
            ),
            'tab_image_active'                => array(
                'css'               => array(
                    'main' => array(
                        'border_radii' => ".dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--active img",
                        'border_radii_hover'  => ".dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--active img:hover",
                        'border_styles' => ".dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--active img",
                        'border_styles_hover' => ".dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--active img:hover",
                    )
                ),
                'tab_slug'          => 'advanced',
                'toggle_slug'       => 'tab_image',
                'sub_toggle'  => 'active',
                'show_if' => ['tab_media' => 'image']
            ),
        );
        $advanced_fields['box_shadow'] = array(
            'image'              => array(
                'css' => array(
                    'main' => ".dipi_advanced_tabs {$this->main_css_element} .dipi-at-panel-content .dipi-at-panel-image",
                    'hover' => ".dipi_advanced_tabs {$this->main_css_element} .dipi-at-panel-content .dipi-at-panel-image:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'image'
            ),
            'tab_image'              => array(
                'css' => array(
                    'main' => ".dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--normal img",
                    'hover' => ".dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--normal img:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'tab_image',
                'sub_toggle'  => 'normal',
                'show_if' => ['tab_media' => 'image']
                 
            ),
            'tab_image_active'              => array(
                'css' => array(
                    'main' => ".dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--active img",
                    'hover' => ".dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--active img:hover",
                ),
                'tab_slug'        => 'advanced',
                'toggle_slug'     => 'tab_image',
                'sub_toggle'  => 'active',
                'show_if' => ['tab_media' => 'image']
            )
        );
        $advanced_fields["filters"] = array(
			'child_filters_target' => array(
				'tab_slug' => 'advanced',
				'toggle_slug' => 'image',
				'css' => array(
					'main' => '%%order_class%% img'
				),
			),
        );
        
        $advanced_fields['image'] = array(
			'css' => array(
				'main' => array(
					'%%order_class%% img',
				)
			),
        );
        $advanced_fields['transform'] = false;
        $advanced_fields['background'] = array(
            'css' => array(
                'main' => "{$this->main_css_element}.et_pb_module"
            )
        );
        $advanced_fields['max_width'] = array(
            'css'   => array(
                'main'      => "{$this->main_css_element}.et_pb_module"
            )
        );
        $advanced_fields['margin_padding'] = array(
            'css'   => array(
                'main'      => "{$this->main_css_element}.et_pb_module",
                'important' => 'all'
            )
        );
        $advanced_fields['link_options'] = false;
    
        $advanced_fields['button']["button"] = [
            'label'    => esc_html__('Button', 'dipi-divi-pixel'),
            'css' => [
                'main' => ".dipi-at-panels %%order_class%% .dipi-at-btn",
                'limited_main' => "%%order_class%% .dipi-at-btn",
                'important' => true,
            ],
            'box_shadow'  => [
                'css' => [
                    'main' => ".dipi-at-panels %%order_class%% .dipi-at-btn",
                    'important' => true,
                ],
            ],
            'use_alignment' => true,
            'margin_padding' => [
                'css' => [
                    'main' => ".dipi-at-panels %%order_class%% .dipi-at-btn",
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
        $fields["module_class"] = [
            'label' => esc_html__('CSS Class', 'dipi-divi-pixel'),
            'type' => 'text',
            'tab_slug' => 'custom_css',
            'toggle_slug' => 'classes',
        ];

        $fields['tab_normal_image_padding'] = [
            'label' => esc_html__('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tab_image',
            'sub_toggle' => 'normal',
            'show_if' => ['tab_media' => 'image']
        ];

        $fields['tab_active_image_padding'] = [
            'label' => esc_html__('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tab_image',
            'sub_toggle' => 'active',
            'show_if' => ['tab_media' => 'image']
        ];
        $fields['tab_normal_image_margin'] = [
            'label' => esc_html__('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tab_image',
            'sub_toggle' => 'normal',
            'show_if' => ['tab_media' => 'image']
        ];

        $fields['tab_active_image_margin'] = [
            'label' => esc_html__('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tab_image',
            'sub_toggle' => 'active',
            'show_if' => ['tab_media' => 'image']
        ];

        $fields['tab_normal_icon_padding'] = [
            'label' => esc_html__('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '10px|10px|10px|10px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tab_icon',
            'sub_toggle' => 'normal',
            'show_if' => ['tab_media' => 'icon']
        ];

        $fields['tab_active_icon_padding'] = [
            'label' => esc_html__('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '10px|10px|10px|10px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tab_icon',
            'sub_toggle' => 'active',
            'show_if' => ['tab_media' => 'icon']
        ];
        $fields['tab_normal_icon_margin'] = [
            'label' => esc_html__('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tab_icon',
            'sub_toggle' => 'normal',
            'show_if' => ['tab_media' => 'icon']
        ];

        $fields['tab_active_icon_margin'] = [
            'label' => esc_html__('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'tab_icon',
            'sub_toggle' => 'active',
            'show_if' => ['tab_media' => 'icon']
        ];


        
        // Start of General Fields
        $fields['title'] = [
            'label'                 => esc_html__( 'Tab Title', 'dipi-divi-pixel' ),
            'type'                  => 'text',
            'toggle_slug'           => 'content',
            'tab_slug'              => 'general',
            'dynamic_content'       => 'text'
        ];
        $fields['subtitle'] = [
            'label'                 => esc_html__( 'Tab Subtitle', 'dipi-divi-pixel' ),
            'type'                  => 'textarea',
            'toggle_slug'           => 'content',
            'tab_slug'              => 'general',
            'dynamic_content'       => 'text'
        ];
 
        $fields['is_default_tab'] = [
            'label'           => esc_html__( 'Active on Load', 'dipi-divi-pixel' ),
            'type'            => 'yes_no_button',
            'option_category' => 'basic_option',
            'options'         => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'default'     => 'off',
            'toggle_slug' => 'content',
            'tab_slug'    => 'general',
        ];
        $fields['use_library_content'] = [
            'label'           => esc_html__( 'Use Library Content', 'dipi-divi-pixel' ),
            'type'            => 'yes_no_button',
            'option_category' => 'basic_option',
            'options'         => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'default'     => 'off',
            'toggle_slug' => 'content',
            'tab_slug'    => 'general',
        ];

        $fields['content']        = [
            'label'           => esc_html__('Body', 'dipi-divi-pixel'),
            'type'            => 'tiny_mce',
            'toggle_slug'     => 'content',
            'tab_slug'        => 'general',
            'dynamic_content' => 'text',
            'show_if'         => ['use_library_content' => 'off']
        ];
        $fields['ul_type'] = [
            'label'            => esc_html__( 'Unordered List Style Type', 'et_builder' ),
            'description'      => esc_html__( 'This setting adjusts the shape of the bullet point that begins each list item.', 'et_builder' ),
            'type'             => 'select',
            'option_category'  => 'configuration',
            'options'          => array(
                'disc'   => et_builder_i18n( 'Disc' ),
                'circle' => et_builder_i18n( 'Circle' ),
                'square' => et_builder_i18n( 'Square' ),
                'none'   => et_builder_i18n( 'None' ),
            ),
            'priority'         => 80,
            'default'          => 'disc',
            'default_on_front' => '',
            'tab_slug'         => 'advanced',
            'toggle_slug'      => 'text',
            'sub_toggle'       => 'ul',
            'mobile_options'   => true,
        ];
        $fields['ul_position'] = [
            'label'            => esc_html__( 'Unordered List Style Position', 'et_builder' ),
            'description'      => esc_html__( 'The bullet point that begins each list item can be placed either inside or outside the parent list wrapper. Placing list items inside will indent them further within the list.', 'et_builder' ),
            'type'             => 'select',
            'option_category'  => 'configuration',
            'options'          => array(
                'outside' => et_builder_i18n( 'Outside' ),
                'inside'  => et_builder_i18n( 'Inside' ),
            ),
            'priority'         => 85,
            'default'          => 'outside',
            'default_on_front' => '',
            'tab_slug'         => 'advanced',
            'toggle_slug'      => 'text',
            'sub_toggle'       => 'ul',
            'mobile_options'   => true,
        ];
        $fields['ul_item_indent'] = [
            'label'            => esc_html__( 'Unordered List Item Indent', 'et_builder' ),
            'description'      => esc_html__( 'Increasing indentation will push list items further towards the center of the text content, giving the list more visible separation from the the rest of the text.', 'et_builder' ),
            'type'             => 'range',
            'option_category'  => 'configuration',
            'tab_slug'         => 'advanced',
            'toggle_slug'      => 'text',
            'sub_toggle'       => 'ul',
            'priority'         => 90,
            'default'          => '0px',
            'default_unit'     => 'px',
            'default_on_front' => '',
            'allowed_units'    => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
            'range_settings'   => array(
                'min'  => '0',
                'max'  => '100',
                'step' => '1',
            ),
            'mobile_options'   => true,
        ];
        $fields['ol_type'] = [
            'label'            => esc_html__( 'Ordered List Style Type', 'et_builder' ),
            'description'      => esc_html__( 'Here you can choose which types of characters are used to distinguish between each item in the ordered list.', 'et_builder' ),
            'type'             => 'select',
            'option_category'  => 'configuration',
            'options'          => array(
                'decimal'              => 'decimal',
                'armenian'             => 'armenian',
                'cjk-ideographic'      => 'cjk-ideographic',
                'decimal-leading-zero' => 'decimal-leading-zero',
                'georgian'             => 'georgian',
                'hebrew'               => 'hebrew',
                'hiragana'             => 'hiragana',
                'hiragana-iroha'       => 'hiragana-iroha',
                'katakana'             => 'katakana',
                'katakana-iroha'       => 'katakana-iroha',
                'lower-alpha'          => 'lower-alpha',
                'lower-greek'          => 'lower-greek',
                'lower-latin'          => 'lower-latin',
                'lower-roman'          => 'lower-roman',
                'upper-alpha'          => 'upper-alpha',
                'upper-greek'          => 'upper-greek',
                'upper-latin'          => 'upper-latin',
                'upper-roman'          => 'upper-roman',
                'none'                 => 'none',
            ),
            'priority'         => 80,
            'default'          => 'decimal',
            'default_on_front' => '',
            'tab_slug'         => 'advanced',
            'toggle_slug'      => 'text',
            'sub_toggle'       => 'ol',
            'mobile_options'   => true,
        ];
        $fields['ol_position'] = [
            'label'            => esc_html__( 'Ordered List Style Position', 'et_builder' ),
            'description'      => esc_html__( 'The characters that begins each list item can be placed either inside or outside the parent list wrapper. Placing list items inside will indent them further within the list.', 'et_builder' ),
            'type'             => 'select',
            'option_category'  => 'configuration',
            'options'          => array(
                'inside'  => et_builder_i18n( 'Inside' ),
                'outside' => et_builder_i18n( 'Outside' ),
            ),
            'priority'         => 85,
            'default'          => 'inside',
            'default_on_front' => '',
            'tab_slug'         => 'advanced',
            'toggle_slug'      => 'text',
            'sub_toggle'       => 'ol',
            'mobile_options'   => true,
        ];
        $fields['ol_item_indent'] = [
            'label'            => esc_html__( 'Ordered List Item Indent', 'et_builder' ),
            'description'      => esc_html__( 'Increasing indentation will push list items further towards the center of the text content, giving the list more visible separation from the the rest of the text.', 'et_builder' ),
            'type'             => 'range',
            'option_category'  => 'configuration',
            'tab_slug'         => 'advanced',
            'toggle_slug'      => 'text',
            'sub_toggle'       => 'ol',
            'priority'         => 90,
            'default'          => '0px',
            'default_unit'     => 'px',
            'default_on_front' => '',
            'allowed_units'    => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
            'range_settings'   => array(
                'min'  => '0',
                'max'  => '100',
                'step' => '1',
            ),
            'mobile_options'   => true,
        ];        
        $fields["divi_library"] = [
            'label'            => esc_html__('Divi Library', 'dipi-divi-pixel'),
            'options'          => $this->get_divi_layouts(),
            'type'             => 'select',
            'computed_affects' => [
                '__libraryShortcodeHtml',
            ],
            'toggle_slug'     => 'content',
            'tab_slug'        => 'general',
            'show_if'     => ['use_library_content' => 'on']
        ];
        $fields["__libraryShortcodeHtml"] = [
            'type'                => 'computed',
            'computed_callback'   => ['DIPI_AdvancedTabsItem', 'get_divi_library_shortcode'],
            'computed_depends_on' => [
                'divi_library'
            ]
        ];
        $fields['admin_label'] = [
            'label'            => esc_html__( 'Admin Label', 'dipi-divi-pixel' ),
            'type'             => 'text',
            'option_category'  => 'basic_option',
            'toggle_slug'      => 'admin_label',
            'tab_slug'         => 'general',
            'default_on_front' => 'Tab Item'
        ];
        // End of General Fields
 

        $fields['image'] = array (
            'label'                 => esc_html__( 'Image', 'dipi-divi-pixel' ),
            'type'                  => 'upload',
            'upload_button_text'    => esc_attr__( 'Upload an image', 'dipi-divi-pixel' ),
            'choose_text'           => esc_attr__( 'Choose an Image', 'dipi-divi-pixel' ),
            'update_text'           => esc_attr__( 'Set As Image', 'dipi-divi-pixel' ),
            'toggle_slug'           => 'image',
            'dynamic_content'       => 'image',
            // 'show_if_not'           => array('use_library_item' => 'on')
        );
        $fields['alt'] = array (
            'label'                 => esc_html__( 'Alt Text', 'dipi-divi-pixel' ),
            'type'                  => 'text',
            'toggle_slug'           => 'image',
            'dynamic_content'       => 'text',
           
        );
        $fields['image_link_yes'] = array (
            'label'                 => esc_html__( 'Use Image Link', 'dipi-divi-pixel' ),
            'type'                  => 'yes_no_button',
            'option_category'       => 'configuration',
            'options'               => array(
                'off'                   => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'                    => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'toggle_slug'           => 'image',
            'default'               => 'off',
            'description'           => esc_html__( 'Enable this option to add a link to the image.', 'dipi-divi-pixel' ),
        );
        $fields['image_link'] = array (
            'label'                 => esc_html__( 'Link', 'dipi-divi-pixel' ),
            'type'                  => 'text',
            'toggle_slug'           => 'image',
            'dynamic_content'       => 'url',
            'show_if' => array('image_link_yes' => 'on')
        );
        $fields['image_link_target'] = array (
            'label'                 => esc_html__( 'Link Target', 'dipi-divi-pixel' ),
            'type'                  => 'select',
            'options'               => array(
                'self'                  => esc_html__( 'Same Window', 'dipi-divi-pixel' ),
                'blank'                 => esc_html__( 'New Window', 'dipi-divi-pixel' ),
            ),
            'toggle_slug'           => 'image',
            'dynamic_content'       => 'choice',
            'show_if' => array('image_link_yes' => 'on')
        );

        $fields['iamge_place'] = array (
            'label'             => esc_html__( 'Image Placement', 'dipi-divi-pixel' ),
				'type'              => 'composite',
				'tab_slug'          => 'general',
                'toggle_slug'       => 'image',
                'composite_type'    => 'default',
                // 'show_if_not'       => array('use_library_item' => 'on'),
                'composite_structure' => array(
					'desktop' => array(
                        'icon'     => 'desktop',
						'controls' => array(
							'img_placement' => array(
                                'label'                 => esc_html__('Image Placement Desktop', 'dipi-divi-pixel'),
                                'type'                  => 'select',
                                'default'               => 'column',
                                'options'               => array(
                                    'column'         => esc_html__('Default', 'dipi-divi-pixel'),
                                    'column-reverse' => esc_html__('Bottom', 'dipi-divi-pixel'),
                                    'row'            => esc_html__('Left', 'dipi-divi-pixel'),
                                    'row-reverse'    => esc_html__('Right', 'dipi-divi-pixel')
                                ),
                                'toggle_slug'            => 'image',
                                'tab_slug'               => 'general'
                            ),
                            'img_container_width'   => array(
                                'label'             => esc_html__( 'Content Image Width Desktop', 'dipi-divi-pixel' ),
                                'type'              => 'range',
                                'toggle_slug'       => 'image',
                                'tab_slug'          => 'general',
                                'default'           => '50%',
                                'default_unit'      => '%',
                                'default_on_front'  => '50%',
                                'range_settings'    => array(
                                    'min'  => '1',
                                    'max'  => '100',
                                    'step' => '1',
                                ),
                                'show_if'           => array(
                                    'img_placement' => array('row', 'row-reverse')
                                )
                            ),
                            'img_container_max_width'   => array(
                                'label'             => esc_html__( 'Content Image Max Width Desktop', 'dipi-divi-pixel' ),
                                'type'              => 'range',
                                'toggle_slug'       => 'image',
                                'tab_slug'          => 'general',
                                'default'           => '100%',
                                'default_unit'      => '%',
                                'default_on_front'  => '100%',
                                'range_settings'    => array(
                                    'min'  => '1',
                                    'max'  => '100',
                                    'step' => '1',
                                ),
                            ),
                            'content_image_align' => [
                                'label' => esc_html__('Image Alignment', 'dipi-divi-pixel'),
                                'type'             => 'select',
                                'options' => [
                                    'start' => esc_html__('Left', 'dipi-divi-pixel'),
                                    'center' => esc_html__('Center', 'dipi-divi-pixel'),
                                    'end' => esc_html__('Right', 'dipi-divi-pixel'),
                                ],
                                'toggle_slug'       => 'image',
                                'tab_slug'          => 'general',
                                'default'           => 'center',
                                'show_if_not'           => array(
                                    'img_placement' => array('row', 'row-reverse')
                                )
                            ]
						),
					),
					'tablet' => array(
                        'icon'  => 'tablet',
						'controls' => array(
							'img_placement_tablet' => array(
                                'label'                 => esc_html__('Image Placement Tablet', 'dipi-divi-pixel'),
                                'type'                  => 'select',
                                'default'               => 'top',
                                'options'               => array(
                                    'column'         => esc_html__('Default', 'dipi-divi-pixel'),
                                    'column-reverse' => esc_html__('Bottom', 'dipi-divi-pixel'),
                                    'row'            => esc_html__('Left', 'dipi-divi-pixel'),
                                    'row-reverse'    => esc_html__('Right', 'dipi-divi-pixel')
                                ),
                                'toggle_slug'            => 'image',
                                'tab_slug'               => 'general',
                            ),
                            'img_container_width_tablet'   => array(
                                'label'             => esc_html__( 'Content Image Width Tablet', 'dipi-divi-pixel' ),
                                'type'              => 'range',
                                'toggle_slug'       => 'image',
                                'tab_slug'          => 'general',
                                'default'           => '50%',
                                'default_unit'      => '%',
                                'default_on_front'  => '50%',
                                'range_settings'    => array(
                                    'min'  => '1',
                                    'max'  => '100',
                                    'step' => '1',
                                ),
                                'show_if'           => array(
                                    'img_placement_tablet' => array('row', 'row-reverse')
                                )
                            ),
                            'img_container_max_width_tablet'   => array(
                                'label'             => esc_html__( 'Content Image Max Width Tablet', 'dipi-divi-pixel' ),
                                'type'              => 'range',
                                'toggle_slug'       => 'image',
                                'tab_slug'          => 'general',
                                'default'           => '100%',
                                'default_unit'      => '%',
                                'default_on_front'  => '100%',
                                'range_settings'    => array(
                                    'min'  => '1',
                                    'max'  => '100',
                                    'step' => '1',
                                ),
                            ),
                            'content_image_align_tablet' => [
                                'label' => esc_html__('Image Alignment', 'dipi-divi-pixel'),
                                'type'             => 'select',
                                'options' => [
                                    'start' => esc_html__('Left', 'dipi-divi-pixel'),
                                    'center' => esc_html__('Center', 'dipi-divi-pixel'),
                                    'end' => esc_html__('Right', 'dipi-divi-pixel'),
                                ],
                                'options_icon' => 'module_align',
                                'toggle_slug'       => 'image',
                                'tab_slug'          => 'general',
                                'default'           => 'center',
                                'show_if_not'           => array(
                                    'img_placement_tablet' => array('row', 'row-reverse')
                                )
                            ]
						),
					),
					'phone' => array(
                        'icon'  => 'phone',
						'controls' => array(
							'img_placement_phone' => array(
                                'label'                 => esc_html__('Image Placement Mobile', 'dipi-divi-pixel'),
                                'type'                  => 'select',
                                'default'               => 'column',
                                'options'               => array(
                                    'column'         => esc_html__('Default', 'dipi-divi-pixel'),
                                    'column-reverse' => esc_html__('Bottom', 'dipi-divi-pixel'),
                                    'row'            => esc_html__('Left', 'dipi-divi-pixel'),
                                    'row-reverse'    => esc_html__('Right', 'dipi-divi-pixel')
                                ),
                                'toggle_slug'            => 'image',
                                'tab_slug'               => 'general',
                            ),
                            'img_container_width_phone'   => array(
                                'label'             => esc_html__( 'Content Image Width Mobile', 'dipi-divi-pixel' ),
                                'type'              => 'range',
                                'toggle_slug'       => 'image',
                                'tab_slug'          => 'general',
                                'default'           => '50%',
                                'default_unit'      => '%',
                                'default_on_front'  => '50%',
                                'range_settings'    => array(
                                    'min'  => '1',
                                    'max'  => '100',
                                    'step' => '1',
                                ),
                                'show_if'           => array(
                                    'img_placement_phone' => array('row', 'row-reverse')
                                )
                            ),
                            'img_container_max_width_phone'   => array(
                                'label'             => esc_html__( 'Content Image Max Width Mobile', 'dipi-divi-pixel' ),
                                'type'              => 'range',
                                'toggle_slug'       => 'image',
                                'tab_slug'          => 'general',
                                'default'           => '100%',
                                'default_unit'      => '%',
                                'default_on_front'  => '100%',
                                'range_settings'    => array(
                                    'min'  => '1',
                                    'max'  => '100',
                                    'step' => '1',
                                ),
                            ),
                            'content_image_align_phone' => [
                                'label' => esc_html__('Image Alignment', 'dipi-divi-pixel'),
                                'type'             => 'select',
                                'options' => [
                                    'start' => esc_html__('Left', 'dipi-divi-pixel'),
                                    'center' => esc_html__('Center', 'dipi-divi-pixel'),
                                    'end' => esc_html__('Right', 'dipi-divi-pixel'),
                                ],
                                'toggle_slug'       => 'image',
                                'tab_slug'          => 'general',
                                'default'           => 'center',
                                'show_if_not'           => array(
                                    'img_placement_phone' => array('row', 'row-reverse')
                                )
                            ]
						),
					),
				)
           
        );

        $fields['image_padding'] = [
            'label' => esc_html__('Image Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'image',
            'tab_slug'          => 'advanced'
        ];

        $fields['image_margin'] = [
            'label' => esc_html__('Image Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '10px|10px|10px|10px',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug'       => 'image',
            'tab_slug'          => 'advanced'
        ];

        // Icon
        

        
        $fields['icon_color'] = [
            'label'             => esc_html__( 'Icon Color', 'dipi-divi-pixel' ),
            'type'              => 'color-alpha',
            'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'dipi-divi-pixel' ),
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'tab_icon',
            'mobile_options'    => true,
            'responsive'        => true,
            'sub_toggle' => 'normal',
            'hover'             => 'tabs',
            'show_if'         => ['tab_media' => 'icon']
        ];
        $fields['icon_size'] = [
            'label'           => esc_html__( 'Icon Size', 'dipi-divi-pixel' ),
            'type'            => 'range',
            'option_category' => 'font_option',
            'tab_slug'        => 'advanced',
            'toggle_slug'     => 'tab_icon',
            'sub_toggle' => 'normal',
            'default'         => '20px',
            'default_unit'    => 'px',
            'range_settings' => array(
                'min'  => '1',
                'max'  => '120',
                'step' => '1',
            ),
            'mobile_options'    => true,
            'responsive'        => true,
            'show_if'         => ['tab_media' => 'icon']
        ];
        
        

        
        $fields['icon_color_active'] = [
            'label'             => esc_html__( 'Icon Color', 'dipi-divi-pixel' ),
            'type'              => 'color-alpha',
            'description'       => esc_html__( 'Here you can define a custom color for your icon.', 'dipi-divi-pixel' ),
            'tab_slug'          => 'advanced',
            'toggle_slug'       => 'tab_icon',
            'mobile_options'    => true,
            'responsive'        => true,
            'sub_toggle' => 'active',
            'hover'             => 'tabs',
            'show_if'         => ['tab_media' => 'icon']
        ];
        $fields['icon_size_active'] = [
            'label'           => esc_html__( 'Icon Size', 'dipi-divi-pixel' ),
            'type'            => 'range',
            'option_category' => 'font_option',
            'tab_slug'        => 'advanced',
            'toggle_slug'     => 'tab_icon',
            'sub_toggle' => 'active',
            'default'         => '20px',
            'default_unit'    => 'px',
            'range_settings' => array(
                'min'  => '1',
                'max'  => '120',
                'step' => '1',
            ),
            'mobile_options'    => true,
            'responsive'        => true,
            'show_if'         => ['tab_media' => 'icon']
        ];

        //Image
        
 
        // Button Settings
        $fields['use_button'] = [
            'label'           => esc_html__( 'Use Button', 'dipi-divi-pixel' ),
            'type'            => 'yes_no_button',
            'option_category' => 'basic_option',
            'options'         => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'default'     => 'off',
            'toggle_slug' => 'content',
            'tab_slug'    => 'general',
            'show_if' => ['use_library_content' => 'off']
        ];
        $fields['at_button_text'] = [
            'label'           => esc_html__( 'Button Text', 'dipi-divi-pixel' ),
            'type'            => 'text',
            'default'         => esc_html__( 'Click Here', 'dipi-divi-pixel' ),
            'option_category' => 'basic_option',
            'description'     => esc_html__( 'Input your desired button text, or leave blank for no button.', 'dipi-divi-pixel' ),
            'toggle_slug'     => 'content',
            'tab_slug'        => 'general',
            'dynamic_content' => 'text',
            'show_if'         => [
                'use_button' => 'on',
                'use_library_content' => 'off'
            ]
        ];
        $fields['at_button_url'] = [
            'label'           => esc_html__( 'Button URL', 'dipi-divi-pixel' ),
            'type'            => 'text',
            'option_category' => 'basic_option',
            'description'     => esc_html__( 'Input URL for your button.', 'dipi-divi-pixel' ),
            'toggle_slug'     => 'content',
            'tab_slug'        => 'general',
            'dynamic_content' => 'url',
            'show_if'         => [
                'use_button' => 'on',
                'use_library_content' => 'off'
            ]
        ];
        $fields['at_button_url_new_window'] = [
            'default'         => 'off',
            'default_on_front'=> true,
            'label'           => esc_html__( 'Button Link Target', 'dipi-divi-pixel' ),
            'type'            => 'select',
            'option_category' => 'configuration',
            'options'         => array(
                'off' => esc_html__( 'In The Same Window', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'In The New Tab', 'dipi-divi-pixel' ),
            ),
            'toggle_slug'     => 'content',
            'tab_slug'        => 'general',
            'show_if'         => [
                'use_button' => 'on',
                'use_library_content' => 'off'
            ]
        ];
        // End of Button Settings

        $fields["tab_media"] = [
            'label'            => esc_html__('Tab Media', 'dipi-divi-pixel'),
            'options'          => $this->get_divi_layouts(),
            'type'             => 'select',
            'options' => [
                'none' => 'None',
                'icon' => 'Icon',
                'image' => 'Image'
            ],
            'toggle_slug'     => 'image_icon',
            'tab_slug'        => 'general'
        ];
        
        $fields['tab_icon_tabs'] = array (
            'label'             => esc_html__( 'Tab Image', 'dipi-divi-pixel' ),
				'type'              => 'composite',
                'toggle_slug'     => 'image_icon',
                'tab_slug'        => 'general',
                'composite_type'    => 'default',
                'show_if'       => array('tab_media' => 'icon'),
                'composite_structure' => array(
					'normal' => array(
                        'label'  => esc_html__('Normal', 'dipi-divi-pixel'),
						'controls' => array(
                            'font_icon' => [
                                'label'           => esc_html__( 'Tab Icon', 'dipi-divi-pixel' ),
                                'type'            => 'select_icon',
                                'default' => '5',
                                'option_category' => 'basic_option',
                                'class'           => array( 'et-pb-font-icon' ),
                            ]
						),
					),
                    'active' => array(
                        'label'  => esc_html__('Active', 'dipi-divi-pixel'),
						'controls' => array(
                            'use_active_tab_icon' => [
                                'label'           => esc_html__( 'Use Diffrent Active Icon', 'dipi-divi-pixel' ),
                                'type'            => 'yes_no_button',
                                'option_category' => 'basic_option',
                                'options'         => array(
                                    'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                                    'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
                                ),
                                'default'     => 'off'
                            ],
                            'font_icon_active' => [
                                'label'           => esc_html__( 'Active Tab Icon', 'dipi-divi-pixel' ),
                                'type'            => 'select_icon',
                                'default' => '5',
                                'option_category' => 'basic_option',
                                'show_if' => ['use_active_tab_icon' => 'on']
                            ]
						),
					),
				)
           
        );

        $fields['icon_placement_align'] = [
            'label'          => esc_html__( 'Icon Placement/Alignment', 'dipi-divi-pixel' ),
            'type'           => 'composite',
            'toggle_slug'    => 'image_icon',
            'tab_slug'       => 'general',
            'composite_type' => 'default',
            'show_if' => [
                'tab_media' => 'icon'
            ],
            'composite_structure' => array(
                'desktop' => array(
                    'icon'     => 'desktop',
                    'controls' =>[
                       'tab_icon_placement' => [
                            'label'   => esc_html__('Placement', 'dipi-divi-pixel'),
                            'type'    => 'select',
                            
                            'options' => [
                                'left'   => esc_html__('Left', 'dipi-divi-pixel'),
                                'right'  => esc_html__('Right', 'dipi-divi-pixel'),
                                'top'    => esc_html__('Top', 'dipi-divi-pixel'),
                                'bottom' => esc_html__('Bottom', 'dipi-divi-pixel'),
                                
                            ]
                        ],
                        'tab_icon_alignment_horz1' => [
                            'label'       => esc_html__('Alignment', 'dipi-divi-pixel'),
                            'type'        => 'text_align',
                            'options'     => et_builder_get_text_orientation_options(['justified']),
                            'default'     => 'center',
                            'show_if'     => [ 'tab_icon_placement' => 'top']
                        ],
                        'tab_icon_alignment_horz2' => [
                            'label'       => esc_html__('Alignment', 'dipi-divi-pixel'),
                            'type'        => 'text_align',
                            'options'     => et_builder_get_text_orientation_options(['justified']),
                            'default'     => 'center',
                            'show_if'     => [ 'tab_icon_placement' => 'bottom']
                        ]
                    ],
                ),
                'tablet' => array(
                    'icon'  => 'tablet',
                    'controls' => array(
                        'tab_icon_placement_tablet' => [
                                 'label'                 => esc_html__('Placement', 'dipi-divi-pixel'),
                                 'type'                  => 'select',
                                 'default'               => 'top',
                                  
                                 'options'               => array(
                                    'left'   => esc_html__('Left', 'dipi-divi-pixel'),
                                     'right'  => esc_html__('Right', 'dipi-divi-pixel'),
                                     'top'    => esc_html__('Top', 'dipi-divi-pixel'),
                                     'bottom' => esc_html__('Bottom', 'dipi-divi-pixel')
                                     
                                 ),
                                 'toggle_slug'     => 'content',
                                 'tab_slug'        => 'general',
                                
                         ],
                         'tab_icon_alignment_horz1_tablet' => [
                             'label'       => esc_html__('Alignment', 'dipi-divi-pixel'),
                             'type'        => 'text_align',
                             'options'     => et_builder_get_text_orientation_options(['justified']),
                             'default'     => 'center',
                             'toggle_slug'     => 'content',
                             'tab_slug'        => 'general',
                             'show_if'     => [ 'tab_icon_placement_tablet' => 'top' ]
                         ],
                         'tab_icon_alignment_horz2_tablet' => [
                            'label'       => esc_html__('Alignment', 'dipi-divi-pixel'),
                            'type'        => 'text_align',
                            'options'     => et_builder_get_text_orientation_options(['justified']),
                            'default'     => 'center',
                            'toggle_slug'     => 'content',
                            'tab_slug'        => 'general',
                            'show_if'     => [ 'tab_icon_placement_tablet' => 'bottom' ]
                         ]
                     ),
                ),
                'phone' => array(
                    'icon'  => 'phone',
                    'controls' => array(
                        'tab_icon_placement_phone' => [
                                 'label'                 => esc_html__('Icon Placement', 'dipi-divi-pixel'),
                                 'type'                  => 'select',
                                 'default'               => 'top',
                                 'options'               => array(
                                    'left'   => esc_html__('Left', 'dipi-divi-pixel'),
                                    'right'  => esc_html__('Right', 'dipi-divi-pixel'),
                                     'top'    => esc_html__('Top', 'dipi-divi-pixel'),
                                     'bottom' => esc_html__('Bottom', 'dipi-divi-pixel')
                                 ),
                                 'toggle_slug'     => 'content',
                                 'tab_slug'        => 'general',
                                 
                         ],
                         'tab_icon_alignment_horz1_phone' => [
                            'label'       => esc_html__('Icon Alignment', 'dipi-divi-pixel'),
                            'type'        => 'text_align',
                            'options'     => et_builder_get_text_orientation_options(['justified']),
                            'default'     => 'center',
                            
                            'show_if'     => [ 'tab_icon_placement_phone' => 'top' ]
                         ],
                         'tab_icon_alignment_horz2_phone' => [
                             'label'       => esc_html__('Icon Alignment', 'dipi-divi-pixel'),
                             'type'        => 'text_align',
                             'options'     => et_builder_get_text_orientation_options(['justified']),
                             'default'     => 'center',
                             'show_if'     => [ 'tab_icon_placement_phone' => 'bottom' ]
                         ]
                     ),
                ),
            ),
        ];

        $fields['tab_image_tabs'] = array (
            'label'             => esc_html__( 'Tab Image', 'dipi-divi-pixel' ),
				'type'              => 'composite',
                'toggle_slug'     => 'image_icon',
                'tab_slug'        => 'general',
                'composite_type'    => 'default',
                'show_if'       => array('tab_media' => 'image'),
                'composite_structure' => array(
					'normal' => array(
                        'label'  => esc_html__('Normal', 'dipi-divi-pixel'),
						'controls' => array(
                            'tab_image' => array (
                                'label'                 => esc_html__( 'Tab Image', 'dipi-divi-pixel' ),
                                'type'                  => 'upload',
                                'upload_button_text'    => esc_attr__( 'Upload an image', 'dipi-divi-pixel' ),
                                'choose_text'           => esc_attr__( 'Choose an Image', 'dipi-divi-pixel' ),
                                'update_text'           => esc_attr__( 'Set As Image', 'dipi-divi-pixel' ),
                                'dynamic_content'       => 'image'
                                
                            )
						),
					),
                    'active' => array(
                        'label'  => esc_html__('Active', 'dipi-divi-pixel'),
						'controls' => array(
                            'use_active_tab_image' => [
                                'label'           => esc_html__( 'Use Diffrent Active Image', 'dipi-divi-pixel' ),
                                'type'            => 'yes_no_button',
                                'option_category' => 'basic_option',
                                'options'         => array(
                                    'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                                    'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
                                ),
                                'default'     => 'off'
                            ],
                            'tab_image_active' => array (
                                'label'                 => esc_html__( 'Active Tab Image', 'dipi-divi-pixel' ),
                                'type'                  => 'upload',
                                'upload_button_text'    => esc_attr__( 'Upload an image', 'dipi-divi-pixel' ),
                                'choose_text'           => esc_attr__( 'Choose an Image', 'dipi-divi-pixel' ),
                                'update_text'           => esc_attr__( 'Set As Image', 'dipi-divi-pixel' ),
                                'dynamic_content'       => 'image',
                                'show_if' => ['use_active_tab_image' => 'on']
                                
                            )
						),
					),
				)
           
        );

        $fields['image_placement_align'] = [
            'label'          => esc_html__( 'Image Placement/Alignment', 'dipi-divi-pixel' ),
            'type'           => 'composite',
            'toggle_slug'    => 'image_icon',
            'tab_slug'       => 'general',
            'composite_type' => 'default',
            'show_if' => [
                'tab_media' => 'image'
            ],
            'composite_structure' => array(
                'desktop' => array(
                    'icon'     => 'desktop',
                    'controls' =>[
                       'tab_image_placement' => [
                            'label'   => esc_html__('Placement', 'dipi-divi-pixel'),
                            'type'    => 'select',
                            
                            'options' => [
                                'left'   => esc_html__('Left', 'dipi-divi-pixel'),
                                'right'  => esc_html__('Right', 'dipi-divi-pixel'),
                                'top'    => esc_html__('Top', 'dipi-divi-pixel'),
                                'bottom' => esc_html__('Bottom', 'dipi-divi-pixel'),
                                
                            ]
                        ],
                        'tab_image_alignment_horz1' => [
                            'label'       => esc_html__('Alignment', 'dipi-divi-pixel'),
                            'type'        => 'text_align',
                            'options'     => et_builder_get_text_orientation_options(['justified']),
                            'default'     => 'center',
                            'show_if'     => [ 'tab_image_placement' => 'top']
                        ],
                        'tab_image_alignment_horz2' => [
                            'label'       => esc_html__('Alignment', 'dipi-divi-pixel'),
                            'type'        => 'text_align',
                            'options'     => et_builder_get_text_orientation_options(['justified']),
                            'default'     => 'center',
                            'show_if'     => [ 'tab_image_placement' => 'bottom']
                        ]
                    ],
                ),
                'tablet' => array(
                    'icon'  => 'tablet',
                    'controls' => array(
                        'tab_image_placement_tablet' => [
                                 'label'                 => esc_html__('Placement', 'dipi-divi-pixel'),
                                 'type'                  => 'select',
                                 'default'               => 'top',
                                  
                                 'options'               => array(
                                    'left'   => esc_html__('Left', 'dipi-divi-pixel'),
                                     'right'  => esc_html__('Right', 'dipi-divi-pixel'),
                                     'top'    => esc_html__('Top', 'dipi-divi-pixel'),
                                     'bottom' => esc_html__('Bottom', 'dipi-divi-pixel')
                                     
                                 ),
                                 'toggle_slug'     => 'content',
                                 'tab_slug'        => 'general',
                                
                         ],
                         'tab_image_alignment_horz1_tablet' => [
                             'label'       => esc_html__('Alignment', 'dipi-divi-pixel'),
                             'type'        => 'text_align',
                             'options'     => et_builder_get_text_orientation_options(['justified']),
                             'default'     => 'center',
                             'toggle_slug'     => 'content',
                             'tab_slug'        => 'general',
                             'show_if'     => [ 'tab_image_placement_tablet' => 'top' ]
                         ],
                         'tab_image_alignment_horz2_tablet' => [
                            'label'       => esc_html__('Alignment', 'dipi-divi-pixel'),
                            'type'        => 'text_align',
                            'options'     => et_builder_get_text_orientation_options(['justified']),
                            'default'     => 'center',
                            'toggle_slug'     => 'content',
                            'tab_slug'        => 'general',
                            'show_if'     => [ 'tab_image_placement_tablet' => 'bottom' ]
                         ]
                     ),
                ),
                'phone' => array(
                    'icon'  => 'phone',
                    'controls' => array(
                        'tab_image_placement_phone' => [
                                 'label'                 => esc_html__('Placement', 'dipi-divi-pixel'),
                                 'type'                  => 'select',
                                 'default'               => 'top',
                                 'options'               => array(
                                    'left'   => esc_html__('Left', 'dipi-divi-pixel'),
                                    'right'  => esc_html__('Right', 'dipi-divi-pixel'),
                                     'top'    => esc_html__('Top', 'dipi-divi-pixel'),
                                     'bottom' => esc_html__('Bottom', 'dipi-divi-pixel')
                                 ),
                                 'toggle_slug'     => 'content',
                                 'tab_slug'        => 'general',
                                 
                         ],
                         'tab_image_alignment_horz1_phone' => [
                            'label'       => esc_html__('Icon Alignment', 'dipi-divi-pixel'),
                            'type'        => 'text_align',
                            'options'     => et_builder_get_text_orientation_options(['justified']),
                            'default'     => 'center',
                            
                            'show_if'     => [ 'tab_image_placement_phone' => 'top' ]
                         ],
                         'tab_image_alignment_horz2_phone' => [
                             'label'       => esc_html__('Icon Alignment', 'dipi-divi-pixel'),
                             'type'        => 'text_align',
                             'options'     => et_builder_get_text_orientation_options(['justified']),
                             'default'     => 'center',
                             'show_if'     => [ 'tab_image_placement_phone' => 'bottom' ]
                         ]
                     ),
                ),
            ),
        ];
        
        $fields['tab_image_size'] = [
            'label'             => esc_html__( 'Tab Image Size', 'dipi-divi-pixel' ),
            'type'              => 'range',
            'toggle_slug'     => 'image_icon',
            'tab_slug'        => 'general',
            'default'           => '50px',
            'default_unit'      => 'px',
            'range_settings' => array(
                'min'  => '0',
                'max'  => '1000',
                'step' => '1',
            ),
            'mobile_options'    => true,
            'responsive'        => true,
            'show_if'     => [
                'tab_media' => 'image' 
            ]
        ];

        $fields['activate_tab_selector'] = [
            'label'             => esc_html__( 'Tab Selector', 'dipi-divi-pixel' ),
            'type'              => 'text',
            'description'       => esc_html__( 'Enter the element selector that will open this tab on click (e.g. “services”)', 'dipi-divi-pixel' ),
            'toggle_slug'     => 'tab_selector',
            'tab_slug'        => 'general',
        ];

        $fields['scroll_tab_offset'] = [
            'label'             => esc_html__( 'Scroll To Tab Offset', 'dipi-divi-pixel' ),
            'type'              => 'range',
            'toggle_slug'     => 'tab_selector',
            'tab_slug'        => 'general',
            'default'           => '100px',
            'default_unit'      => 'px',
            'range_settings' => array(
                'min'  => '0',
                'max'  => '500',
                'step' => '1',
            )
        ];




        return $fields;
    }
    public static function get_divi_library_shortcode( $args = [] )
    {
        $id = isset($args['divi_library']) && $args['divi_library'] !== '0'? $args['divi_library'] : '';
        return DIPI_Builder_Module::render_library_layout($id);
    }    
     
 
    public function _apply_css($render_slug)
    {
        $this->_tab_css($render_slug);
        $ul_type_values                  = et_pb_responsive_options()->get_property_values( $this->props, 'ul_type' );
		$ul_position_values              = et_pb_responsive_options()->get_property_values( $this->props, 'ul_position' );
		$ul_item_indent_values           = et_pb_responsive_options()->get_property_values( $this->props, 'ul_item_indent' );
		$ol_type_values                  = et_pb_responsive_options()->get_property_values( $this->props, 'ol_type' );
		$ol_position_values              = et_pb_responsive_options()->get_property_values( $this->props, 'ol_position' );
		$ol_item_indent_values           = et_pb_responsive_options()->get_property_values( $this->props, 'ol_item_indent' );
        $at_item_content_selector = ".dipi_advanced_tabs .dipi-at-panels %%order_class%% .dipi-at-panel-content";
        // UL.
        et_pb_responsive_options()->generate_responsive_css( $ul_type_values, "$at_item_content_selector ul", 'list-style-type', $render_slug, ' !important;', 'type' );
        et_pb_responsive_options()->generate_responsive_css( $ul_position_values, "$at_item_content_selector ul", 'list-style-position', $render_slug, '', 'type' );
        et_pb_responsive_options()->generate_responsive_css( $ul_item_indent_values, "$at_item_content_selector ul", 'padding-left', $render_slug, ' !important;' );

        // OL.
        et_pb_responsive_options()->generate_responsive_css( $ol_type_values, "$at_item_content_selector ol", 'list-style-type', $render_slug, ' !important;', 'type' );
        et_pb_responsive_options()->generate_responsive_css( $ol_position_values, "$at_item_content_selector ol", 'list-style-position', $render_slug, ' !important;', 'type' );
        et_pb_responsive_options()->generate_responsive_css( $ol_item_indent_values, "$at_item_content_selector ol", 'padding-left', $render_slug, ' !important;' );

        $this->dipi_generate_font_icon_styles($render_slug, 'font_icon', "%%order_class%%.dipi-at-tab .dipi-tab-media--normal");
        ($this->props['use_active_tab_icon'] === 'on') ?
            $this->dipi_generate_font_icon_styles($render_slug, 'font_icon_active', "%%order_class%%.dipi-at-tab .dipi-tab-media--active") :
            $this->dipi_generate_font_icon_styles($render_slug, 'font_icon', "%%order_class%%.dipi-at-tab .dipi-tab-media--active");

        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'image_padding',
            'css_property'   => 'padding',
            'selector'       => '%%order_class%% .dipi-at-panel-content .dipi-at-panel-image',
            'hover_selector' => '%%order_class%% .dipi-at-panel-content .dipi-at-panel-image:hover'
        ]);

        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'image_margin',
            'css_property'   => 'margin',
            'selector'       => '%%order_class%% .dipi-at-panel-content .dipi-at-panel-image',
            'hover_selector' => '%%order_class%% .dipi-at-panel-content .dipi-at-panel-image:hover'
        ]);

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .et_pb_button[data-icon]:not([data-icon=""]):after',
            'declaration' => 'content: attr(data-icon);',
        ));
        $button_alignment = $this->props['button_alignment'];
        if ('on' === $this->props['use_button']) {
            if($button_alignment ==='center'){
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dipi-at-btn-wrap',
                    'declaration' => 'justify-content: center;',
                ));
            }
            if($button_alignment ==='left'){
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dipi-at-btn-wrap',
                    'declaration' => 'justify-content: flex-start;',
                ));
            }
            if($button_alignment ==='right'){
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dipi-at-btn-wrap',
                    'declaration' => 'justify-content: flex-end;',
                ));
            }
        }
        
        if(isset($this->props['icon_color']) && $this->props['icon_size'] !== '') {
            $this->process_color_field_css(array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_color',
                'type'              => 'color',
                'selector'          => '%%order_class%%.dipi-at-tab .et-pb-icon',
                'hover'             => '%%order_class%%.dipi-at-tab:hover .et-pb-icon',
                'important'         => true
            ));
        }
        $this->process_range_field_css( array(
            'render_slug'       => $render_slug,
            'slug'              => 'tab_image_size',
            'type'              => 'width',
            'selector'          => '%%order_class%%.dipi-at-tab img',
            'important'         => true
        ) );

        if(isset($this->props['icon_size']) && $this->props['icon_size'] !== '') {
            $this->process_range_field_css( array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_size',
                'type'              => 'font-size',
                'selector'          => '%%order_class%%.dipi-at-tab .et-pb-icon',
                'important'         => true
            ) );
        }

         
        
         

        if(isset($this->props['icon_color_active']) && $this->props['icon_color_active'] !== '') {
            $this->process_color_field_css(array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_color_active',
                'type'              => 'color',
                'selector'          => '%%order_class%%.dipi-at-tab.dipi-at-tab--active .et-pb-icon.dipi-tab-media--active',
                'hover'             => '%%order_class%%.dipi-at-tab.dipi-at-tab--active:hover .et-pb-icon.dipi-tab-media--active',
                'important'         => true
            ));
        }
        if(isset($this->props['icon_size_active']) && $this->props['icon_size_active'] !== '') {
            $this->process_range_field_css( array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_size_active',
                'type'              => 'font-size',
                'selector'          => '%%order_class%%.dipi-at-tab.dipi-at-tab--active .et-pb-icon.dipi-tab-media--active',
                'important'         => true
            ) );
        }
        // image_margin
        $imaeg_margin_r = $this->dipi_get_responsive_prop('image_margin');
         
        if($this->props['use_library_content'] !== 'on') {
             foreach($this->responsive_views as $device => $width) {
                $prop_ext = ($device === 'tablet' || $device === 'phone') ? '_' . $device : '';
                $img_placement = (isset($this->props["img_placement{$prop_ext}"]) && !empty($this->props["img_placement{$prop_ext}"]))? $this->props["img_placement{$prop_ext}"] : 'column';
                $direction_settings = array(
                    'selector' => '%%order_class%% .dipi-at-panel-content',
                    'declaration' => sprintf('flex-direction: %1$s;', $img_placement)
                );
                if($device === 'tablet'){
                    $direction_settings['media_query'] = ET_Builder_Element::get_media_query('max_width_980');
                }
                if($device === 'phone'){
                    $direction_settings['media_query'] = ET_Builder_Element::get_media_query('max_width_767');
                }
                ET_Builder_Element::set_style($render_slug, $direction_settings);
                if (isset($this->props['image']) && !empty($this->props['image'])) {
                    if($img_placement === 'row' || $img_placement === 'row-reverse') {
                        $img_container_width = (isset($this->props["img_container_width{$prop_ext}"]) && !empty($this->props["img_container_width{$prop_ext}"]))? $this->props["img_container_width{$prop_ext}"]:'50%';
                    
                        $width_settings = array(
                            'selector' => '%%order_class%% .dipi-at-panel-content .dipi-at-panel-image',
                            'declaration' => sprintf('width: %1$s;', esc_attr($img_container_width))
                        );
                        if($device === 'tablet'){
                            $width_settings['media_query'] = ET_Builder_Element::get_media_query('max_width_980');
                        }
                        if($device === 'phone'){
                            $width_settings['media_query'] = ET_Builder_Element::get_media_query('max_width_767');
                        }
                        ET_Builder_Element::set_style($render_slug, $width_settings);

                        $width_settings = array(
                            'selector' => '%%order_class%% .dipi-at-panel-content .dipi-at-panel-text',
                            'declaration' => sprintf('width:calc(100%% - %1$s);', $img_container_width)
                        );
                        if($device === 'tablet'){
                            $width_settings['media_query'] = ET_Builder_Element::get_media_query('max_width_980');
                        }
                        if($device === 'phone'){
                            $width_settings['media_query'] = ET_Builder_Element::get_media_query('max_width_767');
                        }
                        ET_Builder_Element::set_style($render_slug, $width_settings);
                    }else{
                        $imaeg_margin_r_elements =  explode('|', $imaeg_margin_r[$device]);
                    
                        $right_margin = (isset( $imaeg_margin_r_elements[1]) && !empty( $imaeg_margin_r_elements[1]) &&  $imaeg_margin_r_elements[1] !== false)?  $imaeg_margin_r_elements[1] : '0px';
                        $left_margin = (isset( $imaeg_margin_r_elements[3]) && !empty( $imaeg_margin_r_elements[3]) &&  $imaeg_margin_r_elements[3] !== false)?  $imaeg_margin_r_elements[3] : '0px';
                        $width = 'width: calc(100% - ( ' . $right_margin . ' + ' . $left_margin . ' ));';
                        
                        $width_settings = array(
                            'selector' => '%%order_class%% .dipi-at-panel-content .dipi-at-panel-image,%%order_class%% .dipi-at-panel-content .dipi-at-panel-text',
                            'declaration' => $width
                        );
                        if($device === 'tablet'){
                            $width_settings['media_query'] = ET_Builder_Element::get_media_query('max_width_980');
                        }
                        if($device === 'phone'){
                            $width_settings['media_query'] = ET_Builder_Element::get_media_query('max_width_767');
                        }
                        ET_Builder_Element::set_style($render_slug, $width_settings);

                        $content_image_align = (isset($this->props["content_image_align{$prop_ext}"]) && !empty($this->props["content_image_align{$prop_ext}"]))? $this->props["content_image_align{$prop_ext}"]:'center';
                    
                        $content_image_align_settings = array(
                            'selector' => '%%order_class%% .dipi-at-panel-content .dipi-at-panel-image',
                            'declaration' => sprintf('align-self: %1$s;', $content_image_align)
                        );
                        if($device === 'tablet'){
                            $content_image_align_settings['media_query'] = ET_Builder_Element::get_media_query('max_width_980');
                        }
                        if($device === 'phone'){
                            $content_image_align_settings['media_query'] = ET_Builder_Element::get_media_query('max_width_767');
                        }
                        ET_Builder_Element::set_style($render_slug, $content_image_align_settings);
                    }
                }
                $img_container_max_width = (isset($this->props["img_container_max_width{$prop_ext}"]) && !empty($this->props["img_container_max_width{$prop_ext}"]))? $this->props["img_container_max_width{$prop_ext}"]:'100%';
                
                $max_width_settings = array(
                    'selector' => '%%order_class%% .dipi-at-panel-content .dipi-at-panel-image',
                    'declaration' => sprintf('max-width: %1$s;', $img_container_max_width)
                );
                if($device === 'tablet'){
                    $max_width_settings['media_query'] = ET_Builder_Element::get_media_query('max_width_980');
                }
                if($device === 'phone'){
                    $max_width_settings['media_query'] = ET_Builder_Element::get_media_query('max_width_767');
                }
                ET_Builder_Element::set_style($render_slug, $max_width_settings);
             }
        }


       
        if($this->props['tab_media'] === 'image') {
            $this->dipi_process_spacing_field([
                'render_slug'    => $render_slug,
                'slug'           => 'tab_normal_image_padding',
                'css_property'   => 'padding',
                'selector'       => '.dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--normal img',
                'hover_selector' => '.dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--normal img:hover'
            ]);
            $this->dipi_process_spacing_field([
                'render_slug'    => $render_slug,
                'slug'           => 'tab_active_image_padding',
                'css_property'   => 'padding',
                'selector'       => '.dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--active img',
                'hover_selector' => '.dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--active img:hover'
            ]);
            $this->dipi_process_spacing_field([
                'render_slug'    => $render_slug,
                'slug'           => 'tab_normal_image_margin',
                'css_property'   => 'margin',
                'selector'       => '.dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--normal img',
                'hover_selector' => '.dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--normal img:hover'
            ]);
            $this->dipi_process_spacing_field([
                'render_slug'    => $render_slug,
                'slug'           => 'tab_active_image_margin',
                'css_property'   => 'margin',
                'selector'       => '.dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--active img',
                'hover_selector' => '.dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--active img:hover'
            ]);
        } elseif($this->props['tab_media'] === 'icon') {
            $this->dipi_process_spacing_field([
                'render_slug'    => $render_slug,
                'slug'           => 'tab_normal_icon_padding',
                'css_property'   => 'padding',
                'selector'       => '.dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--normal.et-pb-icon.dipi-tab-media',
                'hover_selector' => '.dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--normal.et-pb-icon.dipi-tab-media:hover'
            ]);
            $this->dipi_process_spacing_field([
                'render_slug'    => $render_slug,
                'slug'           => 'tab_active_icon_padding',
                'css_property'   => 'padding',
                'selector'       => '.dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--active.et-pb-icon.dipi-tab-media',
                'hover_selector' => '.dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--active.et-pb-icon.dipi-tab-media:hover'
            ]);
            $this->dipi_process_spacing_field([
                'render_slug'    => $render_slug,
                'slug'           => 'tab_normal_icon_margin',
                'css_property'   => 'margin',
                'selector'       => '.dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--normal.et-pb-icon.dipi-tab-media',
                'hover_selector' => '.dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--normal.et-pb-icon.dipi-tab-media:hover'
            ]);
            $this->dipi_process_spacing_field([
                'render_slug'    => $render_slug,
                'slug'           => 'tab_active_icon_margin',
                'css_property'   => 'margin',
                'selector'       => '.dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--active.et-pb-icon.dipi-tab-media',
                'hover_selector' => '.dipi_advanced_tabs %%order_class%%.dipi-at-tab .dipi-tab-media--active.et-pb-icon.dipi-tab-media:hover'
            ]);
        }
        
    }
   
    public function _tab_css($render_slug) {
        if($this->props['tab_icon_placement'] === 'left' || $this->props['tab_icon_placement'] === 'right'){
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%.dipi-at-ta',
                'declaration' => 'flex-direction: row;',
            ));
        }

        $media_type = $this->props['tab_media'] === 'image' ? 'tab_image' : 'tab_icon'; 


        $tab_icon_placement = (isset($this->props[$media_type . '_placement']) && !empty($this->props[$media_type . '_placement']) ) ? $this->props[$media_type . '_placement'] : 'left';
        $tab_icon_placement_tablet = (isset($this->props[$media_type . '_placement_tablet']) && !empty($this->props[$media_type . '_placement_tablet'])) ? $this->props[$media_type . '_placement_tablet'] : $tab_icon_placement;
        $tab_icon_placement_phone = (isset($this->props[$media_type . '_placement_phone']) && !empty($this->props[$media_type . '_placement_phone'])) ? $this->props[$media_type . '_placement_phone'] : $tab_icon_placement_tablet;
        $tab_icon_placement = [
            'desktop' => $tab_icon_placement,
            'tablet'  => $tab_icon_placement_tablet,
            'phone'   => $tab_icon_placement_phone
        ];
        
        $tab_icon_alignment_horz1 = (isset($this->props[$media_type . '_alignment_horz1']) && !empty($this->props[$media_type .'_alignment_horz1'])) ? $this->props[$media_type .'_alignment_horz1'] : 'center';
        $tab_icon_alignment_horz1_tablet = (isset($this->props[$media_type . '_alignment_horz1_tablet']) && !empty($this->props[$media_type . '_alignment_horz1_tablet'])) ? $this->props[$media_type .'_alignment_horz1_tablet'] : $tab_icon_alignment_horz1;
        $tab_icon_alignment_horz1_phone = (isset($this->props[$media_type . '_alignment_horz1_phone']) && !empty($this->props[$media_type . '_alignment_horz1_phone'])) ? $this->props[$media_type .'_alignment_horz1_phone'] : $tab_icon_alignment_horz1_tablet;
        
        $tab_icon_alignment_horz1 = [
            'desktop' => $tab_icon_alignment_horz1,
            'tablet'  => $tab_icon_alignment_horz1_tablet,
            'phone'   => $tab_icon_alignment_horz1_phone
        ];
 
        $tab_icon_alignment_horz2 = (isset($this->props[$media_type . '_alignment_horz2']) && !empty($this->props[$media_type . '_alignment_horz2'])) ? $this->props[$media_type . '_alignment_horz2'] : 'center';
        $tab_icon_alignment_horz2_tablet = (isset($this->props[$media_type . '_alignment_horz2_tablet']) && !empty($this->props[$media_type . '_alignment_horz2_tablet'])) ? $this->props[$media_type . '_alignment_horz2_tablet'] : $tab_icon_alignment_horz2;
        $tab_icon_alignment_horz2_phone = (isset($this->props[$media_type . '_alignment_horz2_phone']) && !empty($this->props[$media_type . '_alignment_horz2_phone'])) ? $this->props[$media_type . '_alignment_horz2_phone'] : $tab_icon_alignment_horz2_tablet;
        
        $tab_icon_alignment_horz2 = [
            'desktop' => $tab_icon_alignment_horz2, 
            'tablet' => $tab_icon_alignment_horz2_tablet, 
            'phone' => $tab_icon_alignment_horz2_phone
        ];
      
         
        $css_op = [];
        $align_css = [];

        foreach(['desktop', 'tablet', 'phone'] as $d) {
            $device = ($d !== 'desktop') ? '_' .$d : '';
            switch ( $tab_icon_placement[$d] ) {
                case 'top':
                    $css_op = [
                        'selector' => '%%order_class%%.dipi-at-tab',
                        'declaration' => 'flex-direction: column;'
                    ];                     
                    
                    $align_css = [
                        'selector' => '%%order_class%%.dipi-at-tab .at-media-wrap',
                        'declaration' => sprintf('text-align:%1$s;', $tab_icon_alignment_horz1[$d]) 
                    ];
                break;
                case 'bottom':
                    $css_op = [
                        'selector' => '%%order_class%%.dipi-at-tab',
                        'declaration' => 'flex-direction: column-reverse;'
                    ];                     
                    
                    $align_css = [
                        'selector' => '%%order_class%%.dipi-at-tab .at-media-wrap',
                        'declaration' => sprintf('text-align:%1$s;', $tab_icon_alignment_horz2[$d]) 
                    ];
                    
                break;
                case 'right':
                    $css_op = [
                        'selector' => '%%order_class%%.dipi-at-tab',
                        'declaration' => 'flex-direction: row-reverse;'
                    ];  
                    
                break;
                default:
                    $css_op = [
                        'selector' => '%%order_class%%.dipi-at-tab',
                        'declaration' => 'flex-direction: row;'
                    ];  
                break;
            } 
            if($d === 'tablet') $css_op['media_query'] = ET_Builder_Element::get_media_query('max_width_980');
            if($d === 'phone') $css_op['media_query'] = ET_Builder_Element::get_media_query('max_width_767');
          
            ET_Builder_Element::set_style($render_slug, $css_op);
            if($tab_icon_placement[$d] === 'top' || $tab_icon_placement[$d] === 'bottom') {
                if($d === 'tablet') $align_css['media_query'] = ET_Builder_Element::get_media_query('max_width_980');
                if($d === 'phone') $align_css['media_query'] = ET_Builder_Element::get_media_query('max_width_767');
                ET_Builder_Element::set_style($render_slug, $align_css);
            }
        }
    }
    protected function render_content_button ($render_slug) {
        // Balloon CTA
        $button = '';
        if ('on' === $this->props['use_button']) {
            $button_text = $this->props['at_button_text'];
            $button_target = isset($this->props['at_button_url_new_window']) ? $this->props['at_button_url_new_window'] : 'off';
            $button_icon = $this->props['button_icon'];
            $button_link = $this->props['at_button_url'];
            $button_rel = $this->props['button_rel'];

            $custom_icon_values = et_pb_responsive_options()->get_property_values( $this->props, 'button_icon' );
            $custom_icon        = isset( $custom_icon_values['desktop'] ) ? $custom_icon_values['desktop'] : '';
            $custom_icon_tablet = isset( $custom_icon_values['tablet'] ) ? $custom_icon_values['tablet'] : '';
            $custom_icon_phone  = isset( $custom_icon_values['phone'] ) ? $custom_icon_values['phone'] : '';
            

            if($this->props['button_on_hover'] === 'on') {
                ET_Builder_Element::set_style($render_slug, [
                    'selector' => 'body #page-container .et_pb_section .dipi_advanced_tabs_0 .dipi-at-btn-wrap:hover .dipi-at-btn:after',
                    'declaration' => 'display:inline-block !important;'
                ]);  
            } else {
                ET_Builder_Element::set_style($render_slug, [
                    'selector' => 'body #page-container .et_pb_section .dipi_advanced_tabs_0 .dipi-at-btn:after',
                    'declaration' => 'display:inline-block;'
                ]);
            }
            $multi_view     = et_pb_multi_view_options( $this );
            $button = $this->render_button(
                array(
                    'button_id'           => $this->module_id( false ),
                    'button_classname'    => ["dipi-at-btn"],
                    'button_custom'       => $this->props['custom_button'],
                    'button_rel'          => $button_rel,
                    'button_text'         => $button_text,
                    'button_text_escaped' => true,
                    'button_url'          => $button_link,
                    'custom_icon'         => $custom_icon,
                    'custom_icon_tablet'  => $custom_icon_tablet,
                    'custom_icon_phone'   => $custom_icon_phone,
                    'has_wrapper'         => false,
                    'url_new_window'      => $button_target,
                    'multi_view_data'     => $multi_view->render_attrs(
                        array(
                            'content'        => '{{button_text}}',
                            'hover_selector' => '%%order_class%%.et_pb_button',
                            'visibility'     => array(
                                'button_text' => '__not_empty',
                            ),
                        )
                    ),
                )
            );
        }

        if ('' !== $button) {
            $button = sprintf('
                <div class="dipi-at-btn-wrap">
                    %1$s
                </div>',
                $button
            );
        }
        return $button;
    }

    public function render($attrs, $content, $render_slug)
    {
        global $dipi_at_tabs;
        $module_order_class = ET_Builder_Element::get_module_order_class( $render_slug );
        $dipi_at_tabs[$module_order_class]['title'] = esc_html($this->props['title']);
        $dipi_at_tabs[$module_order_class]['subtitle'] = esc_html($this->props['subtitle']);
        $dipi_at_tabs[$module_order_class]['tab_media'] = esc_html($this->props['tab_media']);
        $dipi_at_tabs[$module_order_class]['font_icon'] = esc_attr(et_pb_process_font_icon( $this->props['font_icon'] ));
        $dipi_at_tabs[$module_order_class]['font_icon_active'] = esc_attr(et_pb_process_font_icon( $this->props['font_icon_active'] ));
        $dipi_at_tabs[$module_order_class]['tab_image'] = $this->props['tab_image'];
        $dipi_at_tabs[$module_order_class]['use_active_tab_image'] = $this->props['use_active_tab_image'];
        $dipi_at_tabs[$module_order_class]['tab_image_active'] = $this->props['tab_image_active'];
        $dipi_at_tabs[$module_order_class]['tab_image_placement'] = $this->props['tab_image_placement'];
        $dipi_at_tabs[$module_order_class]['tab_icon_placement'] = $this->props['tab_icon_placement'];
        $dipi_at_tabs[$module_order_class]['tab_icon_placement_tablet'] = $this->props['tab_icon_placement_tablet'];
        $dipi_at_tabs[$module_order_class]['tab_icon_placement_phone'] = $this->props['tab_icon_placement_phone'];
        $dipi_at_tabs[$module_order_class]['tab_icon_alignment_horz1'] = $this->props['tab_icon_alignment_horz1'];
        $dipi_at_tabs[$module_order_class]['tab_icon_alignment_horz1_tablet'] = (isset($this->props['tab_icon_alignment_horz1_tablet']) && !empty($this->props['tab_icon_alignment_horz1_tablet']))? $this->props['tab_icon_alignment_horz1_tablet'] : $dipi_at_tabs[$module_order_class]['tab_icon_alignment_horz1'];
        $dipi_at_tabs[$module_order_class]['tab_icon_alignment_horz1_phone'] = (isset($this->props['tab_icon_alignment_horz1_phone']) && !empty($this->props['tab_icon_alignment_horz1_phone']))? $this->props['tab_icon_alignment_horz1_phone'] : $dipi_at_tabs[$module_order_class]['tab_icon_alignment_horz1_tablet'];
        $dipi_at_tabs[$module_order_class]['tab_icon_alignment_horz2'] = $this->props['tab_icon_alignment_horz2'];
        $dipi_at_tabs[$module_order_class]['tab_icon_alignment_horz2_tablet'] = (isset($this->props['tab_icon_alignment_horz2_tablet']) && !empty($this->props['tab_icon_alignment_horz2_tablet']))? $this->props['tab_icon_alignment_horz2_tablet'] : $dipi_at_tabs[$module_order_class]['tab_icon_alignment_horz2'];
        $dipi_at_tabs[$module_order_class]['tab_icon_alignment_horz2_phone']  = (isset($this->props['tab_icon_alignment_horz2_phone']) && !empty($this->props['tab_icon_alignment_horz2_phone']))? $this->props['tab_icon_alignment_horz2_phone'] : $dipi_at_tabs[$module_order_class]['tab_icon_alignment_horz2_tablet'];
        $dipi_at_tabs[$module_order_class]['tab_image_alignment_horz1'] = $this->props['tab_image_alignment_horz1'];
        $dipi_at_tabs[$module_order_class]['tab_image_alignment_horz1_tablet'] = (isset($this->props['tab_image_alignment_horz1_tablet']) && !empty($this->props['tab_image_alignment_horz1_tablet']))? $this->props['tab_image_alignment_horz1_tablet'] : $dipi_at_tabs[$module_order_class]['tab_image_alignment_horz1'];
        $dipi_at_tabs[$module_order_class]['tab_image_alignment_horz1_phone'] = (isset($this->props['tab_image_alignment_horz1_phone']) && !empty($this->props['tab_image_alignment_horz1_phone']))? $this->props['tab_image_alignment_horz1_phone'] : $dipi_at_tabs[$module_order_class]['tab_image_alignment_horz1_tablet'];
        $dipi_at_tabs[$module_order_class]['tab_image_alignment_horz2'] = $this->props['tab_image_alignment_horz2'];
        $dipi_at_tabs[$module_order_class]['tab_image_alignment_horz2_tablet'] = (isset($this->props['tab_image_alignment_horz2_tablet']) && !empty($this->props['tab_image_alignment_horz2_tablet']))? $this->props['tab_image_alignment_horz2_tablet'] : $dipi_at_tabs[$module_order_class]['tab_image_alignment_horz2'];
        $dipi_at_tabs[$module_order_class]['tab_image_alignment_horz2_phone']  = (isset($this->props['tab_image_alignment_horz2_phone']) && !empty($this->props['tab_image_alignment_horz2_phone']))? $this->props['tab_image_alignment_horz2_phone'] : $dipi_at_tabs[$module_order_class]['tab_image_alignment_horz2_tablet'];
        $dipi_at_tabs[$module_order_class]['use_active_tab_icon']  = (isset($this->props['use_active_tab_icon']) && !empty($this->props['use_active_tab_icon']))? $this->props['use_active_tab_icon'] : 'off';
       
        $dipi_at_tabs[$module_order_class]['is_default_tab']  = (isset($this->props['is_default_tab']) && !empty($this->props['is_default_tab']))? $this->props['is_default_tab'] : 'off';
        $dipi_at_tabs[$module_order_class]['activate_tab_selector']  = (isset($this->props['activate_tab_selector']) && !empty($this->props['activate_tab_selector']))? $this->props['activate_tab_selector'] : '';
        $dipi_at_tabs[$module_order_class]['scroll_tab_offset']  = (isset($this->props['scroll_tab_offset']) && !empty($this->props['scroll_tab_offset']))? $this->props['scroll_tab_offset'] : '';
        
        
        $this->_apply_css($render_slug);
        $content = '';
        if($this->props['use_library_content'] === 'on') {
            $divi_library           = $this->props['divi_library'];
            $divi_library_shortcode = self::get_divi_library_shortcode([ 'divi_library' => $divi_library ]);
            $content = sprintf('<div class="dipi-at-panel-content dipi-at-panel-content--lib">%1$s</div>', $divi_library_shortcode);
        } else {
            $button = $this->render_content_button($render_slug);
            
            $image_link_target = $this->props['image_link_target'] === 'blank' ? 'target="_blank"' : '';
            $image = '';
            if($this->props['image'] !== '' && $this->props['image'] !== '') {
                if($this->props['image_link_yes'] === 'on'){
                    $image = sprintf('<a href="%1$s" class="dipi-at-panel-image-link dipi-at-panel-image" %2$s>
                        <img src="%3$s" alt="%4$s" />
                    </a>', 
                    $this->props['image_link'],
                    $image_link_target,
                    $this->props['image'],
                    $this->props['alt']);
                }else{
                    $image = sprintf('<img class="dipi-at-panel-image" src="%1$s" alt="%2$s" />', 
                    $this->props['image'],
                    $this->props['alt']);
                }
                
            
            } else if($this->props['image'] !== ''){
                $image = sprintf('<img class="dipi-at-panel-image" src="%1$s" alt="%2$s" />', $this->props['image'], $this->props['alt']);
            }
            $content = isset($this->props['content']) && $this->props['content'] !== '' ? $this->props['content'] : '';
            $prop_ext = '';
            $img_placement = (isset($this->props["img_placement{$prop_ext}"]) && !empty($this->props["img_placement{$prop_ext}"]))? $this->props["img_placement{$prop_ext}"] : 'column';
            $prop_ext = '_tablet';
            $img_placement_tablet = (isset($this->props["img_placement{$prop_ext}"]) && !empty($this->props["img_placement{$prop_ext}"]))? $this->props["img_placement{$prop_ext}"] : 'column';
            $prop_ext = '_phone';
            $img_placement_phone = (isset($this->props["img_placement{$prop_ext}"]) && !empty($this->props["img_placement{$prop_ext}"]))? $this->props["img_placement{$prop_ext}"] : 'column';

            $content = sprintf('<div class="dipi-at-panel-content" data-imgplacement-desktop="%4$s" data-imgplacement-tablet="%5$s" data-imgplacement-phone="%6$s">
                    %1$s
                    <div class="dipi-at-panel-text">
                    %2$s %3$s
                    </div>
                </div>', 
                $image,
                $this->props['content'],
                $button,
                $img_placement,
                $img_placement_tablet,
                $img_placement_phone
            );
        }
            
        return sprintf('<div class="dipi-at-panel">%1$s</div>', $content);
    }

}    

new DIPI_AdvancedTabsItem();
