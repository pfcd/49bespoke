<?php

class DIPI_ImageHotspot extends DIPI_Builder_Module {

	public $slug = 'dipi_image_hotspot';
	public $vb_support = 'on';

   protected $module_credits = array(
		'module_uri' => 'https://divi-pixel.com/modules/image-hotspot',
		'author' => 'Divi Pixel',
		'author_uri' => 'https://divi-pixel.com',
	);

	public function init() {
		$this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
		$this->name = esc_html__('Pixel Image Hotspot', 'dipi-divi-pixel');
		$this->child_slug = 'dipi_image_hotspot_child';
		$this->main_css_element = '%%order_class%%.dipi_image_hotspot';

		add_filter('et_fb_backend_helpers', [$this, 'default_helpers'], 100, 1);
	}

	public function default_helpers ($helpers) {
		$helpers['defaults']['dipi_image_hotspot'] = [
			'img_src' => ET_BUILDER_PLACEHOLDER_LANDSCAPE_IMAGE_DATA
		];
		return $helpers;
	}

	public function get_settings_modal_toggles() 
	{
		return [
			'general' => [
				'toggles' => [
					'image' => esc_html__('Image', 'dipi-divi-pixel'),
					'tooltip' => esc_html__('Tooltip', 'dipi-divi-pixel'),
				],
			],
			'advanced' => [
				'toggles' => [],
			],
		];
	}

	public function get_custom_css_fields_config() {

        $fields = [];

        $fields['hotspot_img'] = [
            'label'    => esc_html__('Hotspot Image', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-hotspot-image',
        ];

        $fields['hotspot_icon'] = [
            'label'    => esc_html__('Hotspot Icon', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-hotspot-icon',
        ];

        $fields['tooltip_img'] = [
            'label'    => esc_html__('Tooltip Image', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-tooltip-image',
        ];

        $fields['tooltip_icon'] = [
            'label'    => esc_html__('Tooltip Icon', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-tooltip-icon',
        ];
        
        $fields['title'] = [
            'label'    => esc_html__('Tooltip Title', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-tooltip-title',
        ];

        $fields['description'] = [
            'label'    => esc_html__('Tooltip Desc', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-tooltip-desc',
        ];

        $fields['button'] = [
            'label'    => esc_html__('Tooltip Button', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-tooltip-button',
		];
		
        return $fields;
    }

	public function get_fields() {

		$fields = [];

		$fields['img_src'] = [
            'type'               => 'upload',
            'option_category'    => 'basic_option',
			'hide_metadata'      => true,
			'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'description' => esc_html__('Upload an image to display in the module.', 'dipi-divi-pixel'),
            'dynamic_content'    => 'image',
            'toggle_slug'        => 'image'
        ];

        $fields["img_alt"] = [
			'label'       => esc_html__( 'Image Alt Text', 'dipi-divi-pixel' ),
			'type'        => 'text',
			'description' => esc_html__( 'Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
			'toggle_slug' => 'image',
			'dynamic_content' => 'text'
		];
        $fields["hide_tooltip"] = [
            'label'   => esc_html__('Hide Tooltip', 'dipi-divi-pixel'),
            'description' => esc_html__('Hide Tooltip', 'dipi-divi-pixel'),
            'type'    => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'tooltip',
		];
        $fields["trigger_on_click"] = [
            'label'   => esc_html__('Trigger on Click', 'dipi-divi-pixel'),
            'description' => esc_html__('Allowing you to hover over and click inside them.', 'dipi-divi-pixel'),
            'type'    => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
			'toggle_slug' => 'tooltip',
			'show_if'	=> [
				'hide_tooltip' => 'off'
			]
		];
        $fields["tooltip_animation"] = [
            'label'            => esc_html__('Tooltip Animations', 'dipi-divi-pixel'),
            'type'             => 'select',
            'default'          => 'fadeIn',
			'options' => [
                'fadeIn'  => esc_html__('Fade In', 'dipi-divi-pixel'),
                'fadeInLeftShort'  => esc_html__('Fade In Left', 'dipi-divi-pixel'),
                'fadeInRightShort' => esc_html__('Fade In Right', 'dipi-divi-pixel'),
                'fadeInUpShort'    => esc_html__('Fade In Up', 'dipi-divi-pixel'),
                'fadeInDownShort'  => esc_html__('Fade In Down', 'dipi-divi-pixel'),
                'zoomInShort'       => esc_html__('Grow', 'dipi-divi-pixel')
            ],
			'description' => esc_html__("Tooltip animation type will only work on front-end", 'dipi-divi-pixel'),
			'toggle_slug' => 'tooltip',
			'show_if'	=> [
				'hide_tooltip' => 'off'
			]
		];
		$fields['tooltip_animation_speed'] = [
			'label' => esc_html__('Tooltip Animation Speed', 'dipi-divi-pixel'),
			'type' => 'range',
			'option_category' => 'configuration',
			'default' => '800ms',
			'default_on_front' => '800ms',
			'default_unit' => 'ms',
			'range_settings' => [
				'min' => '0',
				'max' => '3000',
				'step' => '100',
			],
			'validate_unit' => true,
			'toggle_slug' => 'tooltip',
			'show_if'	=> [
				'hide_tooltip' => 'off'
			],
			'mobile_options'  => true,
		];
		$fields['tooltip_z_index'] = [
			'label'         => esc_html__('Z-index of Tooltip', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '9999',
            'unitless' => true,
            'range_settings' => [
                'min' => '0',
                'max' => '100000',
                'step' => '9999',
            ],
            'mobile_options' => true,
            'toggle_slug' => 'tooltip',
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
								'border_radii'  => "%%order_class%%.dipi_image_hotspot .dipi-image-hotspot > img, %%order_class%%.dipi_image_hotspot .dipi-image-hotspot > picture > img",
								'border_styles' => "%%order_class%%.dipi_image_hotspot .dipi-image-hotspot > img, %%order_class%%.dipi_image_hotspot .dipi-image-hotspot > picture > img"
						],
				]
		];
		$advanced_fields['box_shadow']['default'] = [
			'css' => [
					'main' => "%%order_class%%.dipi_image_hotspot .dipi-image-hotspot > img, %%order_class%%.dipi_image_hotspot .dipi-image-hotspot > picture > img",
					'overlay' => 'inset',
			]
		];
				
		return $advanced_fields;
	}
	private function dipi_tooltip_z_index_css($render_slug, $order_number)
    {
        $tooltip_z_index = $this->props['tooltip_z_index'];
        $tooltip_z_index_last_edited = $this->props['tooltip_z_index_last_edited'];
        $imagehotspot_tooltip_selector =".dipi-image-hotspot-on-top[class*='dipi-image-hotspot-zindex-$order_number-']";
        if (!isset($tooltip_z_index) || '' === $tooltip_z_index) {
            return;
        }

        $tooltip_z_index_responsive_status = et_pb_get_responsive_status($tooltip_z_index_last_edited);

        $tooltip_z_index_tablet = $this->dipi_get_responsive_value(
            'tooltip_z_index_tablet',
            $tooltip_z_index,
            $tooltip_z_index_responsive_status
        );
	
        $tooltip_z_index_phone = $this->dipi_get_responsive_value(
            'tooltip_z_index_phone',
            $tooltip_z_index_tablet,
            $tooltip_z_index_responsive_status
        );

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $imagehotspot_tooltip_selector,
            'declaration' => sprintf('z-index: %1$s !important;', $tooltip_z_index),
        ));
        if ($tooltip_z_index_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $imagehotspot_tooltip_selector,
                'declaration' => sprintf('z-index: %1$s !important;', $tooltip_z_index_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $imagehotspot_tooltip_selector,
                'declaration' => sprintf('z-index: %1$s !important;', $tooltip_z_index_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }
    }
	public function dipi_apply_css($render_slug, $order_number) {
		$this->generate_styles(
			array(
				'base_attr_name' => 'tooltip_animation_speed',
				'selector'       => "%%order_class%%.dipi_image_hotspot .dipi-tooltip-wrap.animated",
				'css_property'   => 'animation-duration',
				'render_slug'    => $render_slug,
				'type'           => 'range',
			)
		);
		$this->dipi_tooltip_z_index_css($render_slug, $order_number);
	}
	public function render($attrs, $content, $render_slug) {
		wp_enqueue_script('dipi_image_hotspot_public');

        if(!isset($this->props['img_src']) || '' === $this->props['img_src']){
            return '';
		}
		
		$trigger_on_click = $this->props['trigger_on_click'];		
		$order_class = self::get_module_order_class($render_slug);
        $order_number = preg_replace('/[^0-9]/', '', $order_class);
		$this->dipi_apply_css($render_slug, $order_number);
		$output = sprintf('
			<div class="dipi-image-hotspot dipi-trigger_on_click-%4$s" data-order-number="%5$s">
				<img src="%2$s" class="dipi-hotspot-bg-image-main" alt="%3$s">
				%1$s
			</div>',
			$this->content,
			esc_attr($this->props['img_src']),
			esc_attr($this->props['img_alt']),
			$trigger_on_click,
			$order_number #5
		);

		return $output;
	}
}

new DIPI_ImageHotspot;
