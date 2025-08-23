<?php
class DIPI_ParallaxImagesItem extends DIPI_Builder_Module {

    public $child_title_fallback_var = 'content_type';
    public $child_title_var = 'admin_label';

    public function init() {
  
        $this->name = esc_html__('Pixel Parallax Images Item', 'dipi-divi-pixel');
        $this->plural = esc_html__('Pixel Parallax Images Items', 'dipi-divi-pixel');
        $this->slug = 'dipi_parallax_images_item';
        $this->vb_support = 'on';
        $this->type = 'child';
      
        
        $this->advanced_setting_title_text = esc_html__('New Item', 'dipi-divi-pixel');
        $this->settings_text = esc_html__('Item Settings', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%';
    }

    public function get_settings_modal_toggles() {
        return [
            'general' => [
                'toggles' => [
                    'main_content' => esc_html__('Content', 'dipi-divi-pixel'),
                    'parallax_settings' => esc_html__('Settings', 'dipi-divi-pixel'),
                ],
            ],
            'custom_css' => [
                'toggles' => [
                    'classes' => esc_html__('CSS ID & Classes', 'dipi-divi-pixel'),
                ],
            ],
        ];
    }
  
    public function get_fields() {
        $fields = [];

        $fields['admin_label'] = [
            'label'            => esc_html__( 'Admin Label', 'dipi-divi-pixel' ),
            'type'             => 'text',
            'option_category'  => 'basic_option',
            'toggle_slug'      => 'admin_label',
            'tab_slug'         => 'general'
        ];


        $fields['content_type'] = [
            'label'             => esc_html__('Content Type', 'dipi-divi-pixel'),
            'type'              => 'select',
            'default'           => 'Image',
            'options'           => array(
                'Image'         => esc_html__('Image', 'dipi-divi-pixel'),
                'Text'          => esc_html__('Text', 'dipi-divi-pixel')
            ),
            'toggle_slug'       => 'main_content',
        ];
        $fields['image'] = [
            'type'               => 'upload',
            'hide_metadata'      => true,
            'label'              => esc_html__( 'Image',  'dipi-divi-pixel'),
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text'        => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text'        => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'description'        => esc_html__('Upload an image to display in the module.', 'dipi-divi-pixel'),
            'toggle_slug'        => 'main_content',
            'dynamic_content'    => 'image',
            'hover'              => 'tabs',
            'show_if'               => array(
                'content_type' => 'Image'
            )
        ];

        $fields['alt'] = array (
            'label'                 => esc_html__( 'Alt Text', 'dipi-divi-pixel' ),
            'type'                  => 'text',
            'toggle_slug'           => 'main_content',
            'dynamic_content'       => 'text',
            'show_if'               => array(
                'content_type' => 'Image'
            )
        );

        $fields['text_content']        = [
            'label'           => esc_html__('Text Content', 'dipi-divi-pixel'),
            'type'            => 'tiny_mce',
            'toggle_slug'     => 'main_content',
            'tab_slug'        => 'general',
            'dynamic_content' => 'text',
            'show_if'               => array(
                'content_type' => 'Text'
            )
        ];

        // use button field
		$fields['use_button'] = [
            'label'           => esc_html__( 'Use Button', 'dipi-divi-pixel' ),
            'type'            => 'yes_no_button',
            'option_category' => 'basic_option',
            'options'         => array(
                'off' => esc_html__( 'No', 'dipi-divi-pixel' ),
                'on'  => esc_html__( 'Yes', 'dipi-divi-pixel' ),
            ),
            'default'     => 'off',
            'toggle_slug' => 'main_content',
            'tab_slug'    => 'general',
            'show_if'     => [
                'content_type' => 'Text'
            ]
        ];

		// button text field
		$fields['button_text'] = [
			'label'           => esc_html__( 'Button Text', 'dipi-divi-pixel' ),
			'type'            => 'text',
			'option_category' => 'basic_option',
			'toggle_slug'     => 'main_content',
			'tab_slug'        => 'general',
			'dynamic_content' => 'text',
			'show_if'         => [
				'use_button' => 'on'
			]
		];

		// button url field
		$fields['button_url'] = [
			'label'           => esc_html__( 'Button URL', 'dipi-divi-pixel' ),
			'type'            => 'text',
			'option_category' => 'basic_option',
			'toggle_slug'     => 'main_content',
			'tab_slug'        => 'general',
			'dynamic_content' => 'url',
			'show_if'         => [
				'use_button' => 'on'
			]
		];

		// button url new tab field
		$fields['button_url_new_tab'] = [
			'label'           => esc_html__( 'Button URL Opens', 'dipi-divi-pixel' ),
			'type'            => 'select',
			'option_category' => 'configuration',
			'options'         => [
				'off' => esc_html__( 'In The Same Window', 'dipi-divi-pixel' ),
				'on'  => esc_html__( 'In The New Tab', 'dipi-divi-pixel' ),
			],
			'default'         => 'off',
			'toggle_slug'     => 'main_content',
			'tab_slug'        => 'general',
			'show_if'         => [
				'use_button' => 'on'
			]
		];


        $fields['depth_x'] = [
            'label'             => esc_html__( 'Parallax Depth X', 'dipi-divi-pixel' ),
				'type'              => 'range',
				'tab_slug'          => 'general',
				'toggle_slug'       => 'parallax_settings',
				'default'           => '0.1',
                'unitless'          => true,
                'mobile_options'    => true,
                'responsive'        => true,
				'range_settings' => array(
					'min'  => '-1',
					'max'  => '1',
					'step' => '0.01',
                )
        ];

        $fields['depth_y'] = [
            'label'             => esc_html__( 'Parallax Depth Y', 'dipi-divi-pixel' ),
				'type'              => 'range',
				'tab_slug'          => 'general',
				'toggle_slug'       => 'parallax_settings',
				'default'           => '0.1',
                'unitless'          => true,
                'mobile_options'    => true,
                'responsive'        => true,
				'range_settings' => array(
					'min'  => '-1',
					'max'  => '1',
					'step' => '0.01',
                )
        ];

        // range field for layer postion x
        $fields['position_x'] = [
            'label'             => esc_html__( 'Horizontal Position', 'dipi-divi-pixel' ),
            'type'              => 'range',
            'tab_slug'          => 'general',
            'toggle_slug'       => 'parallax_settings',
            'default'           => '0%',
            'default_unit'      => '%',
            'mobile_options'    => true,
            'responsive'        => true,
            'range_settings' => array(
                'min'  => '-100',
                'max'  => '100',
                'step' => '.1',
            )
        ];
        $fields['position_y'] = [
            'label'             => esc_html__( 'Vertical Position', 'dipi-divi-pixel' ),
            'type'              => 'range',
            'tab_slug'          => 'general',
            'toggle_slug'       => 'parallax_settings',
            'default'           => '0%',
            'default_unit'      => '%',
            'mobile_options'    => true,
            'responsive'        => true,
            'range_settings' => array(
                'min'  => '-100',
                'max'  => '100',
                'step' => '.1',
            )
        ];
        $fields['layer_max_width'] = [
            'label'             => esc_html__( 'Layer Width', 'dipi-divi-pixel' ),
            'type'              => 'range',
            'tab_slug'          => 'general',
            'toggle_slug'       => 'parallax_settings',
            'default'           => '100%',
            'default_unit'      => '%',
            'mobile_options'    => true,
            'responsive'        => true,
            'range_settings' => array(
                'min'  => '0',
                'max'  => '100',
                'step' => '1',
            )
        ];

        return $fields;
    }
    public function get_advanced_fields_config()
    {
        $advanced_fields = [];

        $advanced_fields['text'] = [
            'css' => [
                'text_orientation' => "%%order_class%% .dipi-pi-content-text",
                'important' => 'all',
            ] 
        ];
        $advanced_fields['background'] = [
            'css' => [
                'main'        => "%%order_class%% .dipi-pi-item-image",
                'hover'        => "%%order_class%% .dipi-pi-item-image:hover"
            ]
        ];
        $advanced_fields["box_shadow"]["default"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-pi-item-image",
            ]
        ];
        $advanced_fields["borders"]["default"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-pi-item-image",
                    'border_styles' => "%%order_class%% .dipi-pi-item-image",
                ],
            ],
        ];
        $advanced_fields["transform"]  = [
            'css' => [
                'main' => "%%order_class%% .dipi-pi-item-image",
            ],
        ];

        $advanced_fields['button']["content_button"] = [
            'label' => esc_html__('Button', 'dipi-divi-pixel'),
            'use_alignment' => false,
			
            'font_size' => array(
              'default' => '14px',
           ),
            'css' => [
                'main' => "%%order_class%% .dipi-pi-button.et_pb_button",
                'important' => true,
            ],
            'box_shadow'  => [
                'css' => [
                    'main' => "%%order_class%% .dipi-pi-button.et_pb_button",
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'margin' => "%%order_class%% .dipi-pi-button.et_pb_button",
                    'padding' => "%%order_class%% .dipi-pi-button.et_pb_button",
                    'important' => 'all'
                ],
            ],
        ];
         

        return $advanced_fields;
	}
    public function apply_css($render_slug) {
      
        // layer_max_width
        // layer_max_width

        $this->process_range_field_css( array(
            'render_slug'       => $render_slug,
            'slug'              => 'layer_max_width',
            'type'              => 'max-width',
            'selector'          => '%%order_class%%.et_pb_module.dipi_parallax_images_item',
            'important'         => true
        ) );
        $this->process_range_field_css( array(
            'render_slug'       => $render_slug,
            'slug'              => 'position_x',
            'type'              => 'left',
            'selector'          => '%%order_class%%.et_pb_module.dipi_parallax_images_item',
            'important'         => true
        ) );
        $this->process_range_field_css( array(
            'render_slug'       => $render_slug,
            'slug'              => 'position_y',
            'type'              => 'top',
            'selector'          => '%%order_class%%.et_pb_module.dipi_parallax_images_item',
            'important'         => true
        ) );

        // $this->module_alignment($render_slug);
    }

    public function module_alignment($render_slug) {
        $module_align = $this->props["module_alignment"];
        $module_align_tablet = $this->props["module_alignment_tablet"];
        $module_align_phone = $this->props["module_alignment_phone"];

        
        $module_align = (isset($module_align) && !empty($module_align)) ? $module_align : 'left';
        $module_align_tablet = (isset($module_align_tablet) && !empty($module_align_tablet)) ? $module_align_tablet : $module_align;
        $module_align_phone = (isset($module_align_phone) && !empty($module_align_phone)) ? $module_align_phone : $module_align_tablet;
        $m_align = [
            'desktop' => $module_align,
            'tablet' => $module_align_tablet,
            'phone' => $module_align_phone
        ];

        foreach($m_align as $view => $value) {
            $css = '';
            if($value === 'left') {
                $css = '';
            }
            if($value === 'center') {
                $css = sprintf('left:50%%;translate: -50%%;' );
            }

            if($value === 'right') {
                $css = sprintf('left:auto;right:0;' );
            }
          
            $styles = array(
                'selector' => '%%order_class%%',
                'declaration' => sprintf('%1$s', $css),
            );
           
            if($view === 'tablet') {
                $styles['media_query'] = ET_Builder_Element::get_media_query('max_width_980');
            }
            if($view === 'phone') {
                $styles['media_query'] = ET_Builder_Element::get_media_query('max_width_767');
            }
            ET_Builder_Element::set_style($render_slug, $styles);

        }
    }

    public function render( $attrs, $content, $render_slug ) {
        $this->apply_css( $render_slug );
      
        $content_type = $this->props["content_type"];
        $content = '';
        $extra_class = "";
        if($content_type === 'Image') {
            $content = sprintf('<img src="%1$s" alt="%2$s" />', $this->props['image'], $this->props['alt']);
        }
        if($content_type === 'Text') {
            $use_button = $this->props['use_button'];
            $content_button_text        = $this->props['button_text'];
            $content_button_link        = $this->props['button_url'];
            $content_button_rel         = $this->props['content_button_rel'];
            $content_button_icon        = $this->props['content_button_icon'];
            $content_button_link_target = $this->props['button_url_new_tab'];
            $content_button_custom      = $this->props['custom_content_button'];

            /** render button */
            $content_button = $use_button === 'on' ? $this->render_button([
                'button_classname' => ["dipi-pi-button"],
                'button_custom'    => $content_button_custom,
                'button_rel'       => $content_button_rel,
                'button_text'      => $content_button_text,
                'button_url'       => $content_button_link,
                'custom_icon'      => $content_button_icon,
                'url_new_window'   => $content_button_link_target,
                'has_wrapper'      => false
            ]) : '';

             
            $content = sprintf('<div class="dipi-pi-content-text">%1$s%2$s</div>',
            $this->process_content($this->props['text_content']),
             $content_button);
        }
        
        $depth_x = ((isset($this->props["depth_x"]) && !empty($this->props["depth_x"])) || intval($this->props["depth_x"]) === 0 ) ? $this->props["depth_x"] : 0.2;
        $depth_x_tablet = (isset($this->props["depth_x_tablet"]) && !empty($this->props["depth_x_tablet"])) ? $this->props["depth_x_tablet"] : $depth_x;
        $depth_x_phone = (isset($this->props["depth_x_phone"]) && !empty($this->props["depth_x_phone"])) ? $this->props["depth_x_phone"] : $depth_x_tablet;

        $depth_y = ((isset($this->props["depth_y"]) && !empty($this->props["depth_y"])) || intval($this->props["depth_y"]) === 0) ? $this->props["depth_y"] : 0.2;
        $depth_y_tablet = (isset($this->props["depth_y_tablet"]) && !empty($this->props["depth_y_tablet"])) ? $this->props["depth_y_tablet"] : $depth_y;
        $depth_y_phone = (isset($this->props["depth_y_phone"]) && !empty($this->props["depth_y_phone"] )) ? $this->props["depth_y_phone"] : $depth_y_tablet;

    
		return  sprintf('
            <div class="dipi-pi-item-image" 
                data-depth-x="%2$s" data-depth-x-tablet="%3$s" data-depth-x-phone="%4$s"
                data-depth-y="%5$s" data-depth-y-tablet="%6$s" data-depth-y-phone="%7$s"
            >
                %1$s
            </div>', 
            $content,
            $depth_x,
            $depth_x_tablet,
            $depth_x_phone,
            $depth_y,
            $depth_y_tablet,
            $depth_y_phone
        );
    }
}
new DIPI_ParallaxImagesItem;