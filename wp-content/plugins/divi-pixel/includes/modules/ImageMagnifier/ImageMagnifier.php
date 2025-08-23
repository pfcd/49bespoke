<?php
class DIPI_ImageMagnifier extends DIPI_Builder_Module {

   protected $module_credits = array(
		'module_uri' => 'https://divi-pixel.com/modules/image-magnifier',
		'author' => 'Divi Pixel',
		'author_uri' => 'https://divi-pixel.com',
	);

	public function init() {

		$this->slug = 'dipi_image_magnifier';
		$this->vb_support = 'on';
		$this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
		$this->name = esc_html__('Pixel Image Magnifier', 'dipi-divi-pixel');
		$this->main_css_element = '%%order_class%%.dipi_image_magnifier';
	}

	public function get_settings_modal_toggles() 
	{
		return [
			'general' => [
				'toggles' => [
					'image' => esc_html__('Image', 'dipi-divi-pixel'),
                    'magnifier' => esc_html__('Settings', 'dipi-divi-pixel'),
				],
			],
			'advanced' => [
				'toggles' => [
                    'lens' => esc_html__('Lens Style', 'dipi-divi-pixel')
                ],
			],
		];
	}

	public function get_custom_css_fields_config() {

        $fields = [];

        $fields['magnifier_img'] = [
            'label'    => esc_html__('Image Magnifier', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-image-magnifier img',
        ];

        return $fields;
    }

	public function get_fields() 
	{

		$fields = [];

        $fields['main_image'] = [
            'label'              => esc_html__('Image', 'dipi-divi-pixel'),
            'type'               => 'upload',
            'hide_metadata'      => true,
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text'        => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text'        => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'description'        => esc_html__('Upload an image to display in the module.', 'dipi-divi-pixel'),
            'toggle_slug'        => 'image',
            'dynamic_content'    => 'image'
        ];

        $fields['img_alt'] = [
			'label'       => esc_html__('Alt Text', 'dipi-divi-pixel'),
			'type'        => 'text',
			'toggle_slug' => 'image',
            'dynamic_content'    => 'text'
        ];

        $fields['speed'] = [
            'label' => esc_html('Lens Speed', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '300',
            'unitless' => true,
            'range_settings' => [
                'min' => '0',
                'max' => '2000',
                'step' => '100',
            ],
            'toggle_slug' => 'magnifier',
        ];

        $fields['lens_size'] = [
            'label' => esc_html('Magnifying Glass/Lens Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '200',
            'unitless' => true,
            'mobile_options' => true,
            'responsive' => true,
            'range_settings' => [
                'min' => '0',
                'max' => '500',
                'step' => '10',
            ],
            'toggle_slug' => 'magnifier',
        ];

        $fields['lens_border_size'] = [
            'label' => esc_html('Lens Border Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '7',
            'unitless' => true,
            'range_settings' => [
                'min' => '0',
                'max' => '50',
                'step' => '1',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'lens',
        ];

        $fields["lens_border_color"] = [
            'label' => esc_html__( 'Lens Border Color', 'dipi-divi-pixel' ),
            'type' => 'color-alpha',
            'default' => '#fff',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'lens',
        ];

        $fields['use_inset_shadow'] = [
            'label' => esc_html__('Lens Inner Shadow', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'lens'
        ];

        $fields['inset_shadow_size'] = [
            'label' => esc_html('Lens Inner Shadow Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '40',
            'unitless' => true,
            'range_settings' => [
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ],
            'show_if' => [
                'use_inset_shadow' => 'on'
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'lens',
        ];

        $fields["inset_shadow_color"] = [
            'label' => esc_html__( 'Lens Inner Shadow Color', 'dipi-divi-pixel' ),
            'type' => 'color-alpha',
            'default' => '#fff',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'lens',
            'show_if' => [
                'use_inset_shadow' => 'on'
            ]
        ];

		return $fields;
	}

	public function get_advanced_fields_config() 
	{

		$advanced_fields = [];

		$advanced_fields['fonts'] = false;
		$advanced_fields['text'] = false;
		$advanced_fields['text_shadow'] = false;
        $advanced_fields['link_options'] = false;

		$advanced_fields['margin_padding'] = [
		  'css' => [
			'margin' => '%%order_class%%',
			'padding' => '%%order_class%%',
			'important' => 'all',
		  ],
        ];
        
        $advanced_fields['borders']['default'] = [
            'css' => [
                'main' => [
                    'border_radii'  => "%%order_class%% img",
                    'border_styles' => "%%order_class%% img",
                ],
            ],
            'tab_slug' => 'advanced',
        ];

        $advanced_fields['box_shadow']['default'] = [
            'css' => [
                'main' => '%%order_class%% img',
                'overlay'     => 'inset',
            ]
        ];
		
		return $advanced_fields;
	}

	public function render($attrs, $content, $render_slug) {

        wp_enqueue_script('dipi_image_magnifier_public');
        wp_enqueue_style('dipi_magnify');

		$this->_apply_css($render_slug);

        if(!isset($this->props['main_image']) || '' === $this->props['main_image']){
            return '';
        }

		$speed = $this->props['speed'];
		
		$options = [];		
		$options['data-speed'] = esc_attr($speed);

        $options = implode(
            " ", 
            array_map(
                function($k, $v){
                    return "{$k}='{$v}'";
                }, 
                array_keys($options),
                $options
            )
        );

		if ($this->props["main_image"]) {
            $attachment_id = attachment_url_to_postid($this->props["main_image"]);
            $image_title = get_the_title($attachment_id);
            $srcset = wp_get_attachment_image_srcset($attachment_id, 'full');
            return sprintf(
                '<div class="dipi-image-magnifier" %5$s>
                    <img data-magnify-src="%1$s" src="%1$s" srcset="%2$s" alt="%3$s" title="%4$s"/>
                </div>',
                esc_attr( $this->props['main_image']),
                esc_attr($srcset),
                esc_attr( $this->props['img_alt'] ),
                $image_title,
                $options
            );
        } else {
            return "";
        }
    }
    
     
	private function _apply_css($render_slug)
    {
        $lens_size = $this->dipi_get_responsive_prop('lens_size');
        $lens_border_size = $this->props['lens_border_size'];
        $lens_border_color = $this->props['lens_border_color'];
        $use_inset_shadow = $this->props['use_inset_shadow'];
        $inset_shadow_size = $this->props['inset_shadow_size'];
        $inset_shadow_color = $this->props['inset_shadow_color'];

        if( $use_inset_shadow !== 'on' ) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .magnify .magnify-lens",
                'declaration' => sprintf(
                    'box-shadow: 0 0 0 %1$spx %2$s, 0 0 %1$spx %1$spx rgba(0, 0, 0, 0.25), inset 0 0 0px 0px transparent;',
                    $lens_border_size,
                    $lens_border_color
                )
            ));
        } else {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .magnify .magnify-lens",
                'declaration' => sprintf(
                    'box-shadow: 0 0 0 %1$spx %2$s, 0 0 %1$spx %1$spx rgba(0, 0, 0, 0.25), inset 0 0 %3$spx 2px %4$s;',
                    $lens_border_size,
                    $lens_border_color,
                    $inset_shadow_size,
                    $inset_shadow_color
                )
            ));
        }
        
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .magnify > .magnify-lens",
            'declaration' => sprintf('width: %1$spx !important; height: %1$spx !important;', $lens_size['desktop']),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .magnify > .magnify-lens",
            'declaration' => sprintf('width: %1$spx !important; height: %1$spx !important;', $lens_size['tablet']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi.magnify > .magnify-lens",
            'declaration' => sprintf('width: %1$spx !important; height: %1$spx !important;', $lens_size['phone']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767')
        ));

        if(!isset($this->props['border_style_all']) || empty($this->props['border_style_all'])) {
			ET_Builder_Element::set_style($render_slug, [
					'selector' => '%%order_class%% .magnify > img',
					'declaration' => "border-style: solid"
			]);
		}
    }
}

new DIPI_ImageMagnifier;
