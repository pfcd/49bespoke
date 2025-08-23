<?php

class DIPI_HorizontalTimeline_Item extends DIPI_Builder_Module
{
	// Module item's attribute that will be used for module item label on modal
	public $child_title_var = 'admin_label';

	public function init()
	{
		$this->name = esc_html__('Horizontal Timeline Item', 'dipi-divi-pixel');
		$this->plural = esc_html__('Horizontal Timeline Items', 'dipi-divi-pixel');
		$this->slug = 'dipi_horizontal_timeline_item';
		$this->vb_support = 'on';
		$this->main_css_element = '.dipi_horizontal_timeline %%order_class%%.dipi_horizontal_timeline_item';
		$this->type = 'child';
		// attributes are empty, this default text will be used instead as item label
		$this->advanced_setting_title_text = esc_html__('Timeline Item', 'dipi-divi-pixel');
		$this->settings_modal_toggles = array(
			'general' => array(
				'toggles' => array(
					'main_content' => esc_html__('Card Text', 'dipi-divi-pixel'),
					'image' => esc_html__('Card Image & Icon', 'dipi-divi-pixel'),
					'timeline_icon' => esc_html__('Timeline Icon', 'dipi-divi-pixel'),
				),
			),
			'advanced' => array(
				'toggles' => array(
					'timeline_icon_settings' => esc_html__('Timeline Icon', 'dipi-divi-pixel'),
					'ribbon_text_settings' => esc_html__('Ribbon', 'dipi-divi-pixel'),
					'card_settings' => esc_html__('Card Style', 'dipi-divi-pixel'),
					'card_arrow_settings' => esc_html__('Card Arrow', 'dipi-divi-pixel'),
					'icon_settings' => esc_html__('Image & Icon', 'dipi-divi-pixel'),
					'text_group' => array(
						'title' => esc_html__('Text', 'dipi-divi-pixel'),
						'tabbed_subtoggles' => true,
						'sub_toggles' => [
							'title' => [
									'name' => 'Title',
							],
							'desc' => [
									'name' => 'Desc',
							],
							'ribbon' => [
									'name' => 'Ribbon',
							],
						],
					),
					'button' => array(
						'title' => esc_html__('Button', 'dipi-divi-pixel'),
						'priority' => 55,
					),
					'width' => array(
						'title' => esc_html__('Sizing', 'dipi-divi-pixel'),
						'priority' => 65,
					),
				),
			),
			'custom_css' => array(
				'toggles' => array(
					'classes' => esc_html__('CSS ID & Classes', 'dipi-divi-pixel'),
					'attributes' => array(
						'title' => esc_html__('Attributes', 'dipi-divi-pixel'),
						'priority' => 95,
					),
				),
			),
		);

		$this->custom_css_fields = array(
			'card_item' => array(
        'label' => esc_html__('Card Item', 'dipi-divi-pixel'),
        'selector' => '.dipi_htl_item_card',
			),
			'timeline_item_image' => array(
				'label' => esc_html__('Timeline Item Image', 'dipi-divi-pixel'),
				'selector' => '.dipi_htl_item_image',
			),
			'timeline_item_title' => array(
				'label' => esc_html__('Timeline Item Title', 'dipi-divi-pixel'),
				'selector' => '.dipi_htl_item_header',
			),
			'timeline_item_content' => array(
				'label' => esc_html__('Timeline Item Content', 'dipi-divi-pixel'),
				'selector' => '.dipi_htl_item_content',
			),
			'timeline_item_button' => array(
				'label' => esc_html__('Timeline Item Button', 'dipi-divi-pixel'),
				'selector' => '.et_pb_button_wrapper .et_pb_button.dipi_htl_item_button',
				'no_space_before_selector' => false,
			),
			'timeline_item_ribbon_text' => array(
				'label' => esc_html__('Timeline Item Ribbon Text', 'dipi-divi-pixel'),
				'selector' => '.dipi_timeline_ribbon .dipi_timeline_ribbon_text',
			),
			'timeline_item_icon' => array(
				'label' => esc_html__('Timeline Icon', 'dipi-divi-pixel'),
				'selector' => '.ribbon-ico',
			),

		);

		$this->help_videos = array(
			array(
				'id' => 'XW7HR86lp8U',
				'name' => esc_html__('An introduction to the Timeline Item module', 'dipi-divi-pixel'),
			),
		);
	}
	public function get_advanced_fields_config()
  {
		$advanced_fields = [];
		$advanced_fields['height'] = false;
		$advanced_fields['text'] = false;

		$advanced_fields['fonts']['header'] = [
			'label' => esc_html__('Title', 'dipi-divi-pixel'),
			'css' => [
				'main' => "{$this->main_css_element} .dipi_htl_item_header, {$this->main_css_element} .dipi_htl_item_header",
				'hover' => "{$this->main_css_element}:hover .dipi_htl_item_header, {$this->main_css_element}:hover .dipi_htl_item_header",
			],
			'header_level' => [
				'default' => 'h4',
			],
			'toggle_slug' => 'text_group',
			'sub_toggle' => 'title',
		];
		$advanced_fields['fonts']['body'] = [
			'label' => esc_html__('Description', 'dipi-divi-pixel'),
			'css' => [
				'main' => "{$this->main_css_element} .dipi_htl_item_description",
				'line_height' => "{$this->main_css_element} .dipi_htl_item_description p",
				'text_align' => "{$this->main_css_element} .dipi_htl_item_description",
				'text_shadow' => "{$this->main_css_element} .dipi_htl_item_description",
			],
			/* 'block_elements' => array(
			'tabbed_subtoggles' => true,
			'bb_icons_support'  => true,
			'css'               => array(
			'main' => "{$this->main_css_element} .dipi_htl_item_description",
			),
			), */
			'toggle_slug' => 'text_group',
			'sub_toggle' => 'desc',
		];
		$advanced_fields['fonts']['ribbon_text'] = [
			'label' => esc_html__('Ribbon Text', 'dipi-divi-pixel'),
			'css' => [
				'main' => "{$this->main_css_element} .dipi_timeline_ribbon_text",
				'line_height' => "{$this->main_css_element} span.dipi_timeline_ribbon_text",
				'text_align' => "{$this->main_css_element} .dipi_timeline_ribbon_text",
				'text_shadow' => "{$this->main_css_element} .dipi_timeline_ribbon_text",
				'important' => 'all',
			],
			'tab_slug' => 'advanced',
			'toggle_slug' => 'text_group',
			'sub_toggle' => 'ribbon',
			'hide_text_align' => true,
		];
		$advanced_fields['background'] = [
			'settings' => [
				'color' => 'alpha',
			],
			'css' => [
					'main' => '.dipi_horizontal_timeline %%order_class%%.dipi_horizontal_timeline_item .dipi_htl_item_card',
					'pattern' => '.dipi_horizontal_timeline %%order_class%%.dipi_horizontal_timeline_item .dipi_htl_item_card-wrap .dipi_htl_item_card .et_pb_background_pattern',
					'mask' => '.dipi_horizontal_timeline %%order_class%%.dipi_horizontal_timeline_item .dipi_htl_item_card-wrap .dipi_htl_item_card .et_pb_background_mask',
			],
			'default' => 'F2F3F3',
		];
		$advanced_fields['button']['button'] = [
			'label' => esc_html__('Button', 'dipi-divi-pixel'),
			'css' => [
				'main' => "{$this->main_css_element} .dipi_htl_item_button.et_pb_button",
				'limited_main' => "{$this->main_css_element} .dipi_htl_item_button.et_pb_button",
				'alignment' => "{$this->main_css_element} .et_pb_button_wrapper",
			],
			'use_alignment' => true,
			'box_shadow' => [
				'css' => [
					'main' => '.dipi_horizontal_timeline %%order_class%%.dipi_horizontal_timeline_item .et_pb_button',
				],
			],
			'margin_padding' => [
				'css' => [
					'main' => "{$this->main_css_element} .et_pb_button_wrapper .dipi_htl_item_button.et_pb_button",
					'margin' => "{$this->main_css_element} .et_pb_button_wrapper",
					'important' => 'all',
					'default' => '20px|||',
				],
			],
		];
		$advanced_fields['borders']['default'] = [
			'css' => [
				'main' => [
					'border_radii' => '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_card',
					'border_radii_hover' => '.dipi_horizontal_timeline %%order_class%%:hover .dipi_htl_item_card',
					'border_styles' => '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_card',
					'border_styles_hover' => '.dipi_horizontal_timeline %%order_class%%:hover .dipi_htl_item_card',
				],
			],
			'label_prefix' => esc_html__('Card', 'dipi-divi-pixel'),
			'tab_slug' => 'advanced',
			'toggle_slug' => 'card_settings',
			'defaults' => [
				'border_radii' => 'on|0px|0px|0px|0px',
				'border_styles' => [
						'width' => '0px',
						'color' => '#333333',
						'style' => 'solid'
				]
			]
		];
		$advanced_fields['borders']['image'] = [
			'css' => [
				'main' => [
					'border_radii' => '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_image .et_pb_image_wrap',
					'border_radii_hover' => '.dipi_horizontal_timeline %%order_class%%:hover .dipi_htl_item_image .et_pb_image_wrap',
					'border_styles' => '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_image .et_pb_image_wrap',
					'border_styles_hover' => '.dipi_horizontal_timeline %%order_class%%:hover .dipi_htl_item_image .et_pb_image_wrap',
				],
			],
			'label_prefix' => esc_html__('Image', 'dipi-divi-pixel'),
			'tab_slug' => 'advanced',
			'toggle_slug' => 'icon_settings',
			'show_if' => [
				'use_icon' => 'off',
			],
		];
		$advanced_fields['borders']['ribbon_text'] = [
			'css' => [
				'main' => [
					'border_radii' => '.dipi_horizontal_timeline %%order_class%% .dipi_timeline_ribbon .dipi_timeline_ribbon_text',
					'border_radii_hover' => '.dipi_horizontal_timeline %%order_class%%:hover .dipi_timeline_ribbon .dipi_timeline_ribbon_text',
					'border_styles' => '.dipi_horizontal_timeline %%order_class%% .dipi_timeline_ribbon .dipi_timeline_ribbon_text',
					'border_styles_hover' => '.dipi_horizontal_timeline %%order_class%%:hover .dipi_timeline_ribbon .dipi_timeline_ribbon_text',
				],
			],
			'label_prefix' => esc_html__('Ribbon Text', 'dipi-divi-pixel'),
			'tab_slug' => 'advanced',
			'toggle_slug' => 'ribbon_text_settings',
			
		];
		$advanced_fields['box_shadow']['default'] = [
			'label' => esc_html__('Card Box Shadow', 'dipi-divi-pixel'),
			'option_category' => 'layout',
			'tab_slug' => 'advanced',
			'toggle_slug' => 'card_settings',
			'css' => [
				'main' => '.dipi_horizontal_timeline %%order_class%%.dipi_horizontal_timeline_item .dipi_htl_item_card-wrap .dipi_htl_item_card',
				'hover' => '.dipi_horizontal_timeline %%order_class%%.dipi_horizontal_timeline_item:hover .dipi_htl_item_card-wrap .dipi_htl_item_card',
				'overlay' => 'inset',
			],
			'default_on_fronts' => [
				'color' => '',
				'position' => '',
			],
		];
		$advanced_fields['box_shadow']['image'] = [
			'label' => esc_html__('Image Box Shadow', 'dipi-divi-pixel'),
			'option_category' => 'layout',
			'tab_slug' => 'advanced',
			'toggle_slug' => 'icon_settings',
			'show_if' => [
				'use_icon' => 'off',
			],
			'css' => [
				'main' => '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_image .et_pb_image_wrap',
				'hover' => '.dipi_horizontal_timeline %%order_class%%:hover .dipi_htl_item_image .et_pb_image_wrap',
				'show_if_not' => [
					'use_icon' => 'on',
				],
				'overlay' => 'inset',
			],
			'default_on_fronts' => [
				'color' => '',
				'position' => '',
			],
		];
		$advanced_fields['box_shadow']['ribbon_text'] = [
			'label' => esc_html__('Ribbon Text', 'dipi-divi-pixel'),
			'option_category' => 'layout',
			'tab_slug' => 'advanced',
			'toggle_slug' => 'ribbon_text_settings',
			'css' => [
				'main' => '.dipi_horizontal_timeline %%order_class%% .dipi_timeline_ribbon .dipi_timeline_ribbon_text',
				'hover' => '.dipi_horizontal_timeline %%order_class%%:hover .dipi_timeline_ribbon .dipi_timeline_ribbon_text',
				'overlay' => 'inset',
			],
			'default_on_fronts' => [
				'color' => '',
				'position' => '',
			],
		];
		$advanced_fields['margin_padding'] = [
			'css' => array(
				'important' => 'all',
			),
		];
		$advanced_fields['max_width'] = [
			'css' => [
				'main' => $this->main_css_element,
				'module_alignment' => '.dipi_horizontal_timeline %%order_class%%.dipi_horizontal_timeline_item.et_pb_module',
				'important' => 'all',
			],
		];
		
		$advanced_fields['filters']['child_filters_target'] = [
			'tab_slug' => 'advanced',
			'toggle_slug' => 'icon_settings',
			'depends_show_if' => 'off',
			'css' => [
				'main' => '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_image',
				'hover' => '.dipi_horizontal_timeline %%order_class%%:hover .dipi_htl_item_image',
			],
		];
		$advanced_fields['icon_settings'] = [
			'css' => [
				'main' => '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_image',
			],
		];


		return $advanced_fields;
	}
	public function get_fields()
	{
		$et_accent_color = et_builder_accent_color();

		$image_icon_placement = array(
			'top' => esc_html__('Top', 'dipi-divi-pixel'),
		);

		if (!is_rtl()) {
			$image_icon_placement['left'] = esc_html__('Left', 'dipi-divi-pixel');
		} else {
			$image_icon_placement['right'] = esc_html__('Right', 'dipi-divi-pixel');
		}

		$fields = array(
			'admin_label' => array(
				'label' => esc_html__('Admin Label', 'dipi-divi-pixel'),
				'type' => 'text',
				'toggle_slug' => 'admin_label',
				'description' => esc_html__('This will change the label of the module in the builder for easy identification.', 'dipi-divi-pixel'),
			),
			'ribbon' => array(
				'label' => esc_html__('Ribbon', 'dipi-divi-pixel'),
				'type' => 'text',
				'option_category' => 'basic_option',
				'description' => esc_html__('The ribbon of your timeline item.', 'dipi-divi-pixel'),
				'toggle_slug' => 'main_content',
				'dynamic_content' => 'text',
				'mobile_options' => true,
				'hover' => 'tabs',
			),
			'title' => array(
				'label' => esc_html__('Title', 'dipi-divi-pixel'),
				'type' => 'text',
				'option_category' => 'basic_option',
				'description' => esc_html__('The title of your timeline item will appear in bold below your timeline item image.', 'dipi-divi-pixel'),
				'toggle_slug' => 'main_content',
				'dynamic_content' => 'text',
				'mobile_options' => true,
				'hover' => 'tabs',
			),
			'content' => array(
				'label' => esc_html__('Description', 'dipi-divi-pixel'),
				'type' => 'tiny_mce',
				'option_category' => 'basic_option',
				'description' => esc_html__('Input the main text content for your module here.', 'dipi-divi-pixel'),
				'toggle_slug' => 'main_content',
				'dynamic_content' => 'text',
				'mobile_options' => true,
				'hover' => 'tabs',
			),
			'show_button' => array(
				'label' => esc_html__('Show Button', 'dipi-divi-pixel'),
				'type' => 'yes_no_button',
				'option_category' => 'layout',
				'options' => array(
					'off' => esc_html__('No', 'dipi-divi-pixel'),
					'on' => esc_html__('Yes', 'dipi-divi-pixel'),
				),
				'description' => esc_html__('Show or hide button in card.', 'dipi-divi-pixel'),
				'toggle_slug' => 'main_content',
				'default_on_front' => 'off',
			),
			'button_text' => array(
				'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
				'type' => 'text',
				'option_category' => 'basic_option',
				'description' => esc_html__('Input your desired button text, or leave blank for no button.', 'dipi-divi-pixel'),
				'toggle_slug' => 'main_content',
				'dynamic_content' => 'text',
				'mobile_options' => true,
				'hover' => 'tabs',
				'show_if' => array(
					'show_button' => 'on',
				),
			),
			'button_url' => array(
				'label' => esc_html__('Button Link URL', 'dipi-divi-pixel'),
				'type' => 'text',
				'option_category' => 'basic_option',
				'description' => esc_html__('Input the destination URL for your button.', 'dipi-divi-pixel'),
				'toggle_slug' => 'main_content',
				'dynamic_content' => 'url',
				'show_if' => array(
					'show_button' => 'on',
				),
			),
			'button_url_new_window' => array(
				'label' => esc_html__('Button Link Target', 'dipi-divi-pixel'),
				'type' => 'select',
				'option_category' => 'configuration',
				'options' => array(
					'off' => esc_html__('In The Same Window', 'dipi-divi-pixel'),
					'on' => esc_html__('In The New Tab', 'dipi-divi-pixel'),
				),
				'toggle_slug' => 'main_content',
				'description' => esc_html__('Here you can choose whether or not your link opens in a new window', 'dipi-divi-pixel'),
				'default_on_front' => 'off',
				'show_if' => array(
					'show_button' => 'on',
				),
			),
			'url' => array(
				'label' => esc_html__('Title Link URL', 'dipi-divi-pixel'),
				'type' => 'text',
				'option_category' => 'basic_option',
				'description' => esc_html__('If you would like to make your timeline item a link, input your destination URL here.', 'dipi-divi-pixel'),
				'toggle_slug' => 'link_options',
				'dynamic_content' => 'url',
			),
			'url_new_window' => array(
				'label' => esc_html__('Title Link Target', 'dipi-divi-pixel'),
				'type' => 'select',
				'option_category' => 'configuration',
				'options' => array(
						'off' => esc_html__('In The Same Window', 'dipi-divi-pixel'),
						'on' => esc_html__('In The New Tab', 'dipi-divi-pixel'),
				),
				'toggle_slug' => 'link_options',
				'description' => esc_html__('Here you can choose whether or not your link opens in a new window', 'dipi-divi-pixel'),
				'default_on_front' => 'off',
			),
			'timeline_icon' => array(
				'label' => esc_html__('Timeline Icon', 'dipi-divi-pixel'),
				'type' => 'select_icon',
				'option_category' => 'basic_option',
				'class' => array('et-pb-font-icon'),
				'toggle_slug' => 'timeline_icon',
				'description' => esc_html__('Choose an icon to display with your timeline Ribbon.', 'dipi-divi-pixel'),
				'mobile_options' => true,
				'hover' => 'tabs',
				'default' => '%%43%%',
			),
			'timeline_icon_color' => array(
				'default' => $et_accent_color,
				'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
				'type' => 'color-alpha',
				'description' => esc_html__('Here you can define a custom color for your icon.', 'dipi-divi-pixel'),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'timeline_icon_settings',
				'hover' => 'tabs',
				'mobile_options' => true,
				'sticky' => true,
				'default' => '#2C3D49',
			),
			'ribbon_use_circle' => array(
				'label' => esc_html__('Circle Icon', 'dipi-divi-pixel'),
				'type' => 'yes_no_button',
				'option_category' => 'configuration',
				'options' => array(
						'off' => esc_html__('No', 'dipi-divi-pixel'),
						'on' => esc_html__('Yes', 'dipi-divi-pixel'),
				),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'timeline_icon_settings',
				'description' => esc_html__('Here you can choose whether icon set above should display within a circle.', 'dipi-divi-pixel'),
				'default' => 'on',
			),
			'ribbon_circle_color' => array(
				'default' => $et_accent_color,
				'label' => esc_html__('Circle Color', 'dipi-divi-pixel'),
				'type' => 'color-alpha',
				'description' => esc_html__('Here you can define a custom color for the icon circle.', 'dipi-divi-pixel'),
				'show_if' => array(
						'ribbon_use_circle' => 'on',
				),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'timeline_icon_settings',
				'hover' => 'tabs',
				'mobile_options' => true,
				'sticky' => true,
				'default' => '#F2F3F3',
			),
			'ribbon_use_circle_border' => array(
				'label' => esc_html__('Show Circle Border', 'dipi-divi-pixel'),
				'type' => 'yes_no_button',
				'option_category' => 'layout',
				'options' => array(
					'off' => esc_html__('No', 'dipi-divi-pixel'),
					'on' => esc_html__('Yes', 'dipi-divi-pixel'),
				),
				'description' => esc_html__('Here you can choose whether if the icon circle border should display.', 'dipi-divi-pixel'),
				'show_if' => array(
						'ribbon_use_circle' => 'on',
				),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'timeline_icon_settings',
				'default_on_front' => 'off',
			),
			'ribbon_circle_border_color' => array(
				'default' => $et_accent_color,
				'label' => esc_html__('Circle Border Color', 'dipi-divi-pixel'),
				'type' => 'color-alpha',
				'description' => esc_html__('Here you can define a custom color for the icon circle border.', 'dipi-divi-pixel'),
				'show_if' => array(
					'ribbon_use_circle_border' => 'on',
				),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'timeline_icon_settings',
				'hover' => 'tabs',
				'mobile_options' => true,
				'sticky' => true,
				'default' => '#000',
			),
			'ribbon_use_icon_font_size' => array(
				'label' => esc_html__('Use Icon Font Size', 'dipi-divi-pixel'),
				'description' => esc_html__('If you would like to control the size of the icon, you must first enable this option.', 'dipi-divi-pixel'),
				'type' => 'yes_no_button',
				'option_category' => 'font_option',
				'options' => array(
					'off' => esc_html__('No', 'dipi-divi-pixel'),
					'on' => esc_html__('Yes', 'dipi-divi-pixel'),
				),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'timeline_icon_settings',
				'default_on_front' => 'off',
			),
			'timeline_icon_font_size' => array(
				'label' => esc_html__('Icon Font Size', 'dipi-divi-pixel'),
				'description' => esc_html__('Control the size of the icon by increasing or decreasing the font size.', 'dipi-divi-pixel'),
				'type' => 'range',
				'option_category' => 'font_option',
				'tab_slug' => 'advanced',
				'toggle_slug' => 'timeline_icon_settings',
				'default' => '96px',
				'default_unit' => 'px',
				'default_on_front' => '',
				'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
				'range_settings' => array(
					'min' => '1',
					'max' => '120',
					'step' => '1',
				),
				'show_if' => array(
					'ribbon_use_icon_font_size' => 'on',
				),
				'mobile_options' => true,
				'sticky' => true,
				'responsive' => true,
				'hover' => 'tabs',
			),
			'timeline_icon_margin' => array(
				'label' => __('Margin', 'et_builder'),
				'type' => 'custom_margin',
				'description' => __('Set Margin of Timeline Icon.', 'et_builder'),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'timeline_icon_settings',
				'mobile_options' => true,
			),
			'timeline_icon_padding' => array(
				'label' => __('Padding', 'et_builder'),
				'type' => 'custom_margin',
				'description' => __('Set Padding of Timeline Icon.', 'et_builder'),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'timeline_icon_settings',
				'default' => '15px|15px|15px|15px',
				'mobile_options' => true,
			),
			'ribbon_text_bgcolor' => array(
				'label' => esc_html__('Background Color of Ribbon Text', 'dipi-divi-pixel'),
				'type' => 'color-alpha',
				'description' => esc_html__('Here you can define a custom color for the Ribbon Text.', 'dipi-divi-pixel'),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'ribbon_text_settings',
				'hover' => 'tabs',
				'mobile_options' => true,
				'sticky' => true,
				'default' => 'transparent',
			),
			'use_icon' => array(
				'label' => esc_html__('Use Icon', 'dipi-divi-pixel'),
				'type' => 'yes_no_button',
				'option_category' => 'basic_option',
				'options' => array(
					'off' => esc_html__('No', 'dipi-divi-pixel'),
					'on' => esc_html__('Yes', 'dipi-divi-pixel'),
				),
				'toggle_slug' => 'image',
				'affects' => array(
					'border_radii_image',
					'border_styles_image',
					'child_filter_hue_rotate',
					'child_filter_saturate',
					'child_filter_brightness',
					'child_filter_contrast',
					'child_filter_invert',
					'child_filter_sepia',
					'child_filter_opacity',
					'child_filter_blur',
					'child_mix_blend_mode',
				),
				'description' => esc_html__('Here you can choose whether icon set below should be used.', 'dipi-divi-pixel'),
				'default_on_front' => 'off',
			),
			'font_icon' => array(
				'label' => esc_html__('Icon', 'dipi-divi-pixel'),
				'type' => 'select_icon',
				'option_category' => 'basic_option',
				'class' => array('et-pb-font-icon'),
				'toggle_slug' => 'image',
				'description' => esc_html__('Choose an icon to display with your timeline item.', 'dipi-divi-pixel'),
				'show_if' => array(
					'use_icon' => 'on',
				),
				'mobile_options' => true,
				'hover' => 'tabs',
			),
			'icon_color' => array(
				'default' => $et_accent_color,
				'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
				'type' => 'color-alpha',
				'description' => esc_html__('Here you can define a custom color for your icon.', 'dipi-divi-pixel'),
				'show_if' => array(
					'use_icon' => 'on',
				),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'icon_settings',
				'hover' => 'tabs',
				'mobile_options' => true,
				'sticky' => true,
				'default' => '#000',
			),
			'use_circle' => array(
				'label' => esc_html__('Circle Icon', 'dipi-divi-pixel'),
				'type' => 'yes_no_button',
				'option_category' => 'configuration',
				'options' => array(
					'off' => esc_html__('No', 'dipi-divi-pixel'),
					'on' => esc_html__('Yes', 'dipi-divi-pixel'),
				),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'icon_settings',
				'description' => esc_html__('Here you can choose whether icon set above should display within a circle.', 'dipi-divi-pixel'),
				'show_if' => array(
					'use_icon' => 'on',
				),
				'default_on_front' => 'off',
			),
			'circle_color' => array(
				'default' => $et_accent_color,
				'label' => esc_html__('Circle Color', 'dipi-divi-pixel'),
				'type' => 'color-alpha',
				'description' => esc_html__('Here you can define a custom color for the icon circle.', 'dipi-divi-pixel'),
				'show_if' => array(
					'use_icon' => 'on',
					'use_circle' => 'on',
				),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'icon_settings',
				'hover' => 'tabs',
				'mobile_options' => true,
				'sticky' => true,
				'default' => '#eee',
			),
			'use_circle_border' => array(
				'label' => esc_html__('Show Circle Border', 'dipi-divi-pixel'),
				'type' => 'yes_no_button',
				'option_category' => 'layout',
				'options' => array(
					'off' => esc_html__('No', 'dipi-divi-pixel'),
					'on' => esc_html__('Yes', 'dipi-divi-pixel'),
				),
				'description' => esc_html__('Here you can choose whether if the icon circle border should display.', 'dipi-divi-pixel'),
				'show_if' => array(
					'use_icon' => 'on',
					'use_circle' => 'on',
				),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'icon_settings',
				'default_on_front' => 'off',
			),
			'circle_border_color' => array(
				'default' => $et_accent_color,
				'label' => esc_html__('Circle Border Color', 'dipi-divi-pixel'),
				'type' => 'color-alpha',
				'description' => esc_html__('Here you can define a custom color for the icon circle border.', 'dipi-divi-pixel'),
				'show_if' => array(
					'use_icon' => 'on',
					'use_circle_border' => 'on',
				),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'icon_settings',
				'hover' => 'tabs',
				'mobile_options' => true,
				'sticky' => true,
				'default' => '#000',
			),
			'image' => array(
				'label' => esc_html__('Image', 'dipi-divi-pixel'),
				'type' => 'upload',
				'option_category' => 'basic_option',
				'upload_button_text' => esc_html__('Upload an image', 'dipi-divi-pixel'),
				'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
				'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
				'show_if' => array(
						'use_icon' => 'off',
				),
				'description' => esc_html__('Upload an image to display at the top of your timeline item.', 'dipi-divi-pixel'),
				'toggle_slug' => 'image',
				'dynamic_content' => 'image',
				'mobile_options' => true,
				'hover' => 'tabs',
			),
			'alt' => array(
				'label' => esc_html__('Image Alt Text', 'dipi-divi-pixel'),
				'type' => 'text',
				'option_category' => 'basic_option',
				'description' => esc_html__('Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
				'show_if' => array(
						'use_icon' => 'off',
				),
				'toggle_slug' => 'image',
				'dynamic_content' => 'text',
			),
			'icon_placement' => array(
				'label' => esc_html__('Image/Icon Placement', 'dipi-divi-pixel'),
				'type' => 'select',
				'option_category' => 'layout',
				'options' => $image_icon_placement,
				'tab_slug' => 'advanced',
				'toggle_slug' => 'icon_settings',
				'description' => esc_html__('Here you can choose where to place the icon.', 'dipi-divi-pixel'),
				'default_on_front' => 'top',
				'mobile_options' => true,
			),
			'icon_img_alignment' => array(
				'label' => esc_html__('Image/Icon Alignment', 'dipi-divi-pixel'),
				'description' => esc_html__('Align image/icon to the left, right or center.', 'dipi-divi-pixel'),
				'type' => 'align',
				'option_category' => 'layout',
				'options' => et_builder_get_text_orientation_options(array('justified')),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'icon_settings',
				'default' => 'center',
				'mobile_options' => true,
				'sticky' => true,
			),
			'image_max_width' => array(
				'label' => esc_html__('Image Width', 'dipi-divi-pixel'),
				'description' => esc_html__('Adjust the width of the image within the timeline item.', 'dipi-divi-pixel'),
				'type' => 'range',
				'option_category' => 'layout',
				'tab_slug' => 'advanced',
				'toggle_slug' => 'width',
				'mobile_options' => true,
				'validate_unit' => true,
				'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
				'default' => '100%',
				'default_unit' => '%',
				'default_on_front' => '',
				'allow_empty' => true,
				'range_settings' => array(
					'min' => '0',
					'max' => '100',
					'step' => '1',
				),
				'responsive' => true,
				'sticky' => true,
			),
			'use_icon_font_size' => array(
				'label' => esc_html__('Use Icon Font Size', 'dipi-divi-pixel'),
				'description' => esc_html__('If you would like to control the size of the icon, you must first enable this option.', 'dipi-divi-pixel'),
				'type' => 'yes_no_button',
				'option_category' => 'font_option',
				'options' => array(
					'off' => esc_html__('No', 'dipi-divi-pixel'),
					'on' => esc_html__('Yes', 'dipi-divi-pixel'),
				),
				'show_if' => array(
					'use_icon' => 'on',
				),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'icon_settings',
				'default_on_front' => 'off',
			),
			'icon_font_size' => array(
				'label' => esc_html__('Icon Font Size', 'dipi-divi-pixel'),
				'description' => esc_html__('Control the size of the icon by increasing or decreasing the font size.', 'dipi-divi-pixel'),
				'type' => 'range',
				'option_category' => 'font_option',
				'tab_slug' => 'advanced',
				'toggle_slug' => 'icon_settings',
				'default' => '96px',
				'default_unit' => 'px',
				'default_on_front' => '',
				'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
				'range_settings' => array(
					'min' => '1',
					'max' => '120',
					'step' => '1',
				),
				'mobile_options' => true,
				'sticky' => true,
				'show_if' => array(
					'use_icon_font_size' => 'on',
				),
				'responsive' => true,
				'hover' => 'tabs',
			),
			'icon_image_margin' => array(
				'label' => __('Margin', 'et_builder'),
				'type' => 'custom_margin',
				'description' => __('Set Margin of Icon & Image.', 'et_builder'),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'icon_settings',
				'default' => '0px|0px|30px|0px',
				'mobile_options' => true,
			),
			'icon_image_padding' => array(
				'label' => __('Padding', 'et_builder'),
				'type' => 'custom_margin',
				'description' => __('Set Padding of Icon & Image.', 'et_builder'),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'icon_settings',
				'default' => '0px|0px|0px|0px',
				'mobile_options' => true,
			),
			'circle_icon_padding' => array(
				'label' => __('Circle Icon Padding', 'et_builder'),
				'type' => 'custom_margin',
				'description' => __('Set Padding of Icon & Image.', 'et_builder'),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'icon_settings',
				'default' => '0px|0px|0px|0px',
				'mobile_options' => true,
				'show_if' => array(
					'use_icon' => 'on',
					'use_circle' => 'on',
				),
			),
			'custom_card_arrow' => array(
				'label' => esc_html__('Use Custom Styling for Card Arrow', 'dipi-divi-pixel'),
				'description' => esc_html__('Use different styling from parent setting for Card Arrow', 'dipi-divi-pixel'),
				'type' => 'yes_no_button',
				'options' => array(
					'off' => esc_html__('No', 'dipi-divi-pixel'),
					'on' => esc_html__('Yes', 'dipi-divi-pixel'),
				),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'card_arrow_settings',
				'default_on_front' => 'off',
			),
			'card_arrow_size' => array(
				'label' => esc_html__('Card Arrow Size', 'dipi-divi-pixel'),
				'description' => esc_html__('Card Arrow Size', 'dipi-divi-pixel'),
				'type' => 'range',
				'option_category' => 'configuration',
				'tab_slug' => 'advanced',
				'toggle_slug' => 'card_arrow_settings',
				'default' => '12px',
				'default_unit' => '12x',
				'default_on_front' => '12px',
				'allowed_units' => array('em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
				'range_settings' => array(
					'min' => '0',
					'max' => '500',
					'step' => '1',
				),
				'mobile_options' => true,
				'sticky' => true,
				'hover' => 'tabs',
				'show_if' => array(
					'custom_card_arrow' => 'on',
				),
			),
			'card_arrow_color' => array(
				'default' => $et_accent_color,
				'label' => esc_html__('Card Arrow Color', 'dipi-divi-pixel'),
				'type' => 'color-alpha',
				'description' => esc_html__('Here you can define a custom color for card arrow.', 'dipi-divi-pixel'),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'card_arrow_settings',
				'default' => '#eaebec',
				'hover' => 'tabs',
				'mobile_options' => true,
				'sticky' => true,
				'show_if' => array(
					'custom_card_arrow' => 'on',
				),
			),
			// Card Design Settings
			'card_width' => array(
				'label' => esc_html__('Card Width', 'dipi-divi-pixel'),
				'type' => 'range',
				'option_category' => 'layout',
				'tab_slug' => 'advanced',
				'toggle_slug' => 'width',
				'validate_unit' => true,
				'default' => '100%',
				'default_unit' => '%',
				'allow_empty' => true,
				'responsive' => true,
				'mobile_options' => true,
			),
			'card_max_width' => array(
				'label' => esc_html__('Card Max Width', 'dipi-divi-pixel'),
				'description' => esc_html__('Adjust the width of the card within the timeline item.', 'dipi-divi-pixel'),
				'type' => 'range',
				'option_category' => 'layout',
				'tab_slug' => 'advanced',
				'toggle_slug' => 'width',
				'mobile_options' => true,
				'validate_unit' => true,
				'default' => '550px',
				'default_unit' => 'px',
				'default_on_front' => '',
				'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
				'allow_empty' => true,
				'range_settings' => array(
					'min' => '0',
					'max' => '1100',
					'step' => '1',
				),
				'responsive' => true,
				'sticky' => true,
			),
			'card_margin' => array(
				'label' => __('Card Margin', 'et_builder'),
				'type' => 'custom_margin',
				'description' => __('Set Margin of Card.', 'et_builder'),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'margin_padding',
				'mobile_options' => true,
			),
			'card_padding' => array(
				'label' => __('Card Padding', 'et_builder'),
				'type' => 'custom_margin',
				'description' => __('Set Padding of Card.', 'et_builder'),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'margin_padding',
				'default' => '30px|30px|30px|30px',
				'mobile_options' => true,
			),
			'card_content_padding' => array(
				'label' => __('Card Content Padding', 'et_builder'),
				'type' => 'custom_margin',
				'description' => __('Set Padding of Card Content.', 'et_builder'),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'margin_padding',
				'mobile_options' => true,
			),
			'ribbon_text_margin' => array(
				'label' => __('Ribbon Text Margin', 'et_builder'),
				'type' => 'custom_margin',
				'description' => __('Set Margin of Ribbon Text.', 'et_builder'),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'ribbon_text_settings',
				'mobile_options' => true,
			),
			'ribbon_text_padding' => array(
				'label' => __('Ribbon Text Padding', 'et_builder'),
				'type' => 'custom_margin',
				'description' => __('Set Padding of Ribbon Text.', 'et_builder'),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'ribbon_text_settings',
				'mobile_options' => true,
			),
		);
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
		return $fields;
	}

	public function get_transition_fields_css_props()
	{
			$fields = parent::get_transition_fields_css_props();
			$fields['icon_color'] = array(
					'color' => '.dipi_horizontal_timeline %%order_class%% .et-pb-icon',
			);

			$fields['circle_color'] = array(
					'background-color' => '.dipi_horizontal_timeline %%order_class%% .et-pb-icon',
			);

			$fields['circle_border_color'] = array(
					'border-color' => '.dipi_horizontal_timeline %%order_class%% .et-pb-icon',
			);

			$fields['icon_font_size'] = array(
					'font-size' => '.dipi_horizontal_timeline %%order_class%% .et-pb-icon',
			);

			$fields['timeline_icon_color'] = array(
					'color' => '.dipi_horizontal_timeline %%order_class%% .ribbon-ico-wrap .ribbon-ico',
			);

			$fields['ribbon_circle_color'] = array(
					'background-color' => '.dipi_horizontal_timeline %%order_class%% .ribbon-ico-wrap .ribbon-ico.ribbon-ico-circle',
			);

			$fields['ribbon_circle_border_color'] = array(
					'border-color' => '.dipi_horizontal_timeline %%order_class%% .ribbon-ico-wrap .ribbon-ico.ribbon-ico-circle-border',
			);

			$fields['timeline_icon_font_size'] = array(
					'font-size' => '.dipi_horizontal_timeline %%order_class%% .ribbon-ico',
			);

			$fields['body_text_color'] = array(
					'color' => '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_description',
			);

			$fields['image_max_width'] = array(
					'width' => '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_image,.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_image .et_pb_image_wrap',
					'max-width' => '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_image,.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_image .et_pb_image_wrap',
			);

			$fields['card_max_width'] = array(
					'max-width' => '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_card',
			);

			return $fields;
	}

	public function get_custom_style($slug_value, $type, $important)
	{
			return sprintf('%1$s: %2$s%3$s;', $type, $slug_value, $important ? ' !important' : '');
	}
	public function get_changed_prop_value($slug, $conv_matrix)
	{
			if (array_key_exists($this->props[$slug], $conv_matrix)) {
					$this->props[$slug] = $conv_matrix[$this->props[$slug]];
			}

	}
	public function apply_custom_style_for_phone(
			$function_name,
			$slug,
			$type,
			$class,
			$important = false,
			$zoom = '',
			$unit = '',
			$wrap_func = '' /* traslate, clac ... */
	) {
			if (empty($this->props[$slug . '_tablet'])) {
					$this->props[$slug . '_tablet'] = $this->props[$slug];
			}
			if (empty($this->props[$slug . '_phone'])) {
					$this->props[$slug . '_phone'] = $this->props[$slug . '_tablet'];
			}
			if ($zoom === '') {
					$slug_value = $this->props[$slug] . $unit;
					$slug_value_tablet = $this->props[$slug . '_tablet'] . $unit;
					$slug_value_phone = $this->props[$slug . '_phone'] . $unit;
			} else {
					$slug_value = ((float) $this->props[$slug] * $zoom) . $unit;
					$slug_value_tablet = ((float) $this->props[$slug . '_tablet'] * $zoom) . $unit;
					$slug_value_phone = ((float) $this->props[$slug . '_phone'] * $zoom) . $unit;
			}
			if ($wrap_func !== '') {
					$slug_value = "$wrap_func($slug_value)";
					$slug_value_tablet = "$wrap_func($slug_value_tablet)";
					$slug_value_phone = "$wrap_func($slug_value_phone)";
			}

			if (isset($slug_value_phone)
					&& !empty($slug_value_phone)) {
					ET_Builder_Element::set_style($function_name, array(
							'selector' => $class,
							'declaration' => $this->get_custom_style($slug_value_phone, $type, $important),
							'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
					));
			}
	}

	public function apply_custom_style_for_tablet(
			$function_name,
			$slug,
			$type,
			$class,
			$important = false,
			$zoom = '',
			$unit = '',
			$wrap_func = '' /* traslate, clac ... */
	) {
			if (empty($this->props[$slug . '_tablet'])) {
					$this->props[$slug . '_tablet'] = $this->props[$slug];
			}
			if ($zoom === '') {
					$slug_value = $this->props[$slug] . $unit;
					$slug_value_tablet = $this->props[$slug . '_tablet'] . $unit;
					$slug_value_phone = $this->props[$slug . '_phone'] . $unit;
			} else {
					$slug_value = ((float) $this->props[$slug] * $zoom) . $unit;
					$slug_value_tablet = ((float) $this->props[$slug . '_tablet'] * $zoom) . $unit;
					$slug_value_phone = ((float) $this->props[$slug . '_phone'] * $zoom) . $unit;
			}
			if ($wrap_func !== '') {
					$slug_value = "$wrap_func($slug_value)";
					$slug_value_tablet = "$wrap_func($slug_value_tablet)";
					$slug_value_phone = "$wrap_func($slug_value_phone)";
			}

			if (isset($slug_value_tablet)
					&& !empty($slug_value_tablet)) {
					ET_Builder_Element::set_style($function_name, array(
							'selector' => $class,
							'declaration' => $this->get_custom_style($slug_value_tablet, $type, $important),
							'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
					));
			}
	}

	public function apply_custom_style_for_desktop(
			$function_name,
			$slug,
			$type,
			$class,
			$important = false,
			$zoom = '',
			$unit = '',
			$wrap_func = '' /* traslate, clac ... */
	) {
			if ($zoom === '') {
					$slug_value = $this->props[$slug] . $unit;
					$slug_value_tablet = $this->props[$slug . '_tablet'] . $unit;
					$slug_value_phone = $this->props[$slug . '_phone'] . $unit;
			} else {
					$slug_value = ((float) $this->props[$slug] * $zoom) . $unit;
					$slug_value_tablet = ((float) $this->props[$slug . '_tablet'] * $zoom) . $unit;
					$slug_value_phone = ((float) $this->props[$slug . '_phone'] * $zoom) . $unit;
			}
			if ($wrap_func !== '') {
					$slug_value = "$wrap_func($slug_value)";
					$slug_value_tablet = "$wrap_func($slug_value_tablet)";
					$slug_value_phone = "$wrap_func($slug_value_phone)";
			}

			if (isset($slug_value) && !empty($slug_value)) {
					ET_Builder_Element::set_style($function_name, array(
							'selector' => $class,
							'declaration' => $this->get_custom_style($slug_value, $type, $important),
					));
			}
	}

	public function apply_custom_style_for_hover(
			$function_name,
			$slug,
			$type,
			$class,
			$important = false
	) {

			$slug_hover_enabled = isset($this->props[$slug . '__hover_enabled']) ? substr($this->props[$slug . '__hover_enabled'], 0, 2) === "on" : false;
			$slug_hover_value = isset($this->props[$slug . '__hover']) ? $this->props[$slug . '__hover'] : '';
			if (isset($slug_hover_value)
					&& !empty($slug_hover_value)
					&& $slug_hover_enabled) {
					ET_Builder_Element::set_style($function_name, array(
							'selector' => $class,
							'declaration' => $this->get_custom_style($slug_hover_value, $type, $important),
					));
			}
	}

	public function apply_custom_style(
			$function_name,
			$slug,
			$type,
			$class,
			$important = false,
			$zoom = '',
			$unit = '') {
			if ($zoom == '') {
					$slug_value = $this->props[$slug] . $unit;
					$slug_value_tablet = $this->props[$slug . '_tablet'] . $unit;
					$slug_value_phone = $this->props[$slug . '_phone'] . $unit;
			} else {
					$slug_value = ((float) $this->props[$slug] * $zoom) . $unit;
					$slug_value_tablet = ((float) $this->props[$slug . '_tablet'] * $zoom) . $unit;
					$slug_value_phone = ((float) $this->props[$slug . '_phone'] * $zoom) . $unit;
			}

			$slug_value_last_edited = $this->props[$slug . '_last_edited'];
			$slug_value_responsive_active = et_pb_get_responsive_status($slug_value_last_edited);

			if (isset($slug_value) && !empty($slug_value)) {
					ET_Builder_Element::set_style($function_name, array(
							'selector' => $class,
							'declaration' => $this->get_custom_style($slug_value, $type, $important),
					));
			}

			if (isset($slug_value_tablet)
					&& !empty($slug_value_tablet)
					&& $slug_value_responsive_active) {
					ET_Builder_Element::set_style($function_name, array(
							'selector' => $class,
							'declaration' => $this->get_custom_style($slug_value_tablet, $type, $important),
							'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
					));
			}

			if (isset($slug_value_phone)
					&& !empty($slug_value_phone)
					&& $slug_value_responsive_active) {
					ET_Builder_Element::set_style($function_name, array(
							'selector' => $class,
							'declaration' => $this->get_custom_style($slug_value_phone, $type, $important),
							'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
					));
			}
	}
	public function apply_custom_margin_padding($function_name, $slug, $type, $class, $important = true)
	{
			$slug_value = $this->props[$slug];
			$slug_value_tablet = $this->props[$slug . '_tablet'];
			$slug_value_phone = $this->props[$slug . '_phone'];
			$slug_value_last_edited = $this->props[$slug . '_last_edited'];
			$slug_value_responsive_active = et_pb_get_responsive_status($slug_value_last_edited);

			if (isset($slug_value) && !empty($slug_value)) {
					ET_Builder_Element::set_style($function_name, array(
							'selector' => $class,
							'declaration' => et_builder_get_element_style_css($slug_value, $type, $important),
					));
			}

			if (isset($slug_value_tablet) && !empty($slug_value_tablet) && $slug_value_responsive_active) {
					ET_Builder_Element::set_style($function_name, array(
							'selector' => $class,
							'declaration' => et_builder_get_element_style_css($slug_value_tablet, $type, $important),
							'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
					));
			}

			if (isset($slug_value_phone) && !empty($slug_value_phone) && $slug_value_responsive_active) {
					ET_Builder_Element::set_style($function_name, array(
							'selector' => $class,
							'declaration' => et_builder_get_element_style_css($slug_value_phone, $type, $important),
							'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
					));
			}
	}
	private function replaceEmptyWith($array, $replaceValue)
	{
			foreach ($array as $key => $value) {
					if (empty($value)) {
							$array[$key] = $replaceValue;
					}
			}
			return $array;
	}
	public function render($attrs, $content, $render_slug)
	{
			$multi_view = et_pb_multi_view_options($this);
			$sticky = et_pb_sticky_options();
			$is_sticky_module = $sticky->is_sticky_module($this->props);
			$url = $this->props['url'];
			$image = $image_src = $this->props['image'];
			$url_new_window = $this->props['url_new_window'];

			$button_url = $this->props['button_url'];
			$button_rel = $this->props['button_rel'];
			$button_text = $this->_esc_attr('button_text', 'limited');
			$button_url_new_window = $this->props['button_url_new_window'];
			$button_custom = $this->props['custom_button'];
			$custom_icon_values = et_pb_responsive_options()->get_property_values($this->props, 'button_icon');
			$custom_icon = isset($custom_icon_values['desktop']) ? $custom_icon_values['desktop'] : '';
			$custom_icon_tablet = isset($custom_icon_values['tablet']) ? $custom_icon_values['tablet'] : '';
			$custom_icon_phone = isset($custom_icon_values['phone']) ? $custom_icon_values['phone'] : '';
			$button_url = trim($button_url);

			$alt = $this->_esc_attr('alt');
			$font_icon = $this->props['font_icon'];
			$timeline_icon = $this->props['timeline_icon'];
			$use_icon = $this->props['use_icon'];
			$use_circle = $this->props['use_circle'];
			$use_circle_border = $this->props['use_circle_border'];
			$use_icon_font_size = $this->props['use_icon_font_size'];
			$ribbon_use_circle = $this->props['ribbon_use_circle'];
			$ribbon_use_circle_border = $this->props['ribbon_use_circle_border'];
			$ribbon_use_icon_font_size = $this->props['ribbon_use_icon_font_size'];
			$header_level = $this->props['header_level'];
			$icon_font_size_last_edited = $this->props['icon_font_size_last_edited'];
			$timeline_icon_font_size_last_edited = $this->props['timeline_icon_font_size_last_edited'];
			$image_max_width = $this->props['image_max_width'];
			$image_max_width_sticky = $sticky->get_value('image_max_width', $this->props, '');
			$image_max_width_tablet = $this->props['image_max_width_tablet'];
			$image_max_width_phone = $this->props['image_max_width_phone'];
			$image_max_width_last_edited = $this->props['image_max_width_last_edited'];
			$card_max_width = $this->props['card_max_width'];
			$card_max_width_sticky = $sticky->get_value('card_max_width', $this->props, '');
			$card_max_width_tablet = $this->props['card_max_width_tablet'];
			$card_max_width_phone = $this->props['card_max_width_phone'];
			$card_max_width_last_edited = $this->props['card_max_width_last_edited'];
			$custom_card_arrow = $this->props['custom_card_arrow'];

			$icon_placement = $this->props['icon_placement'];
			$icon_placement_values = et_pb_responsive_options()->get_property_values($this->props, 'icon_placement');
			$icon_placement_tablet = isset($icon_placement_values['tablet']) ? $icon_placement_values['tablet'] : '';
			$icon_placement_phone = isset($icon_placement_values['phone']) ? $icon_placement_values['phone'] : '';

			/* $animation        = $this->props['animation'];
			$animation_values = et_pb_responsive_options()->get_property_values( $this->props, 'animation' );
			$animation_tablet = isset( $animation_values['tablet'] ) ? $animation_values['tablet'] : '';
			$animation_phone  = isset( $animation_values['phone'] ) ? $animation_values['phone'] : ''; */

			$image_pathinfo = pathinfo($image);
			$is_image_svg = isset($image_pathinfo['extension']) ? 'svg' === $image_pathinfo['extension'] : false;

			$img_wrapper_selector = '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_image .et_pb_image_wrap';
			$icon_selector = '.dipi_horizontal_timeline %%order_class%% .et-pb-icon';
			$timeline_icon_selector = '.dipi_horizontal_timeline %%order_class%% .ribbon-ico';
			$timeline_icon_hover_selector = '.dipi_horizontal_timeline %%order_class%%:hover .ribbon-ico,.dipi_horizontal_timeline %%order_class%% .ribbon-ico.active';
			$timeline_icon_circle_selector = '.dipi_horizontal_timeline %%order_class%% .ribbon-ico.ribbon-ico-circle';
			$timeline_icon_circle_hover_selector = '.dipi_horizontal_timeline %%order_class%%:hover .ribbon-ico.ribbon-ico-circle,.dipi_horizontal_timeline %%order_class%% .ribbon-ico.ribbon-ico-circle.active';

			$card_margin_responsive_status = et_pb_get_responsive_status($this->props['card_margin_last_edited']);
			$card_margin = ($this->props['card_margin']) ? $this->props['card_margin'] : '';
			$card_margin_tablet = ($card_margin_responsive_status && isset($this->props['card_margin_tablet']) && $this->props['card_margin_tablet'] !== '') ? $this->props['card_margin_tablet'] : $card_margin;
			$card_margin_phone = ($card_margin_responsive_status && isset($this->props['card_margin_phone']) && $this->props['card_margin_phone'] !== '') ? $this->props['card_margin_phone'] : $card_margin_tablet;

			$card_margin = explode("|", $card_margin);
			$card_margin_tablet = explode("|", $card_margin_tablet);
			$card_margin_phone = explode("|", $card_margin_phone);

			$card_margin = $this->replaceEmptyWith($card_margin, "0");
			$card_margin_tablet = $this->replaceEmptyWith($card_margin_tablet, "0");
			$card_margin_phone = $this->replaceEmptyWith($card_margin_phone, "0");

			//apply custom css to Card
			$this->apply_custom_margin_padding(
					$this->slug,
					'card_margin',
					'margin',
					'.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_card'
			);
			$this->apply_custom_margin_padding(
					$this->slug,
					'card_padding',
					'padding',
					'.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_card'
			);
			$this->apply_custom_style($this->slug,
					'card_width',
					'width',
					'.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_card'
			);
			$this->apply_custom_margin_padding(
					$this->slug,
					'card_content_padding',
					'padding',
					'.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_card .dipi_htl_item_content'
			);
			$this->apply_custom_margin_padding(
					$this->slug,
					'ribbon_text_margin',
					'margin',
					'.dipi_horizontal_timeline %%order_class%% .dipi_timeline_ribbon .dipi_timeline_ribbon_text'
			);
			$this->apply_custom_margin_padding(
					$this->slug,
					'ribbon_text_padding',
					'padding',
					'.dipi_horizontal_timeline %%order_class%% .dipi_timeline_ribbon .dipi_timeline_ribbon_text'
			);

			/* Icon/Image alignment */
			$is_icon = 'on' === $use_icon;
			$icon_img_alignment = $this->props['icon_img_alignment'];
			$icon_img_alignment_values = et_pb_responsive_options()->get_property_values($this->props, 'icon_img_alignment');
			$icon_img_alignment_last_edited = $this->props['icon_img_alignment_last_edited'];
			$icon_img_alignment_justify = array(
					'left' => 'start',
					'center' => 'center',
					'right' => 'end',
			);

			$icon_img_alignment_selector = '.dipi_horizontal_timeline %%order_class%%.dipi_horizontal_timeline_item .dipi_htl_item_image';

			if (et_pb_get_responsive_status($icon_img_alignment_last_edited) && '' !== implode('', $icon_img_alignment_values)) {

				$image_alignment_values = array();

				foreach ($icon_img_alignment_values as $breakpoint => $alignment) {
						$image_alignment_values[$breakpoint] = et_()->array_get(
								$icon_img_alignment_justify,
								$alignment,
								''
						);
				}

				// Image alignment style
				et_pb_responsive_options()->generate_responsive_css(
						$image_alignment_values,
						$icon_img_alignment_selector,
						'justify-content',
						$render_slug,
						'',
						'align'
				);
			} else {
					// Let default css handle the alignment if it isn't left or right
					if (in_array($icon_img_alignment, array('left', 'right'))) {
								$el_style = array(
										'selector' => $icon_img_alignment_selector,
										'declaration' => sprintf(
												'justify-content: %1$s;',
												esc_html(et_()->array_get($icon_img_alignment_justify, $icon_img_alignment, ''))
										),
								);
								ET_Builder_Element::set_style($render_slug, $el_style);
					}
			}

			if ('off' !== $use_icon_font_size) {
					$this->generate_styles(
							array(
									'base_attr_name' => 'icon_font_size',
									'selector' => $icon_selector,
									'css_property' => 'font-size',
									'render_slug' => $render_slug,
									'type' => 'range',
									'important' => true,
							)
					);
			}

			if ('' !== $image_max_width_tablet || '' !== $image_max_width_phone || '' !== $image_max_width || '' !== $image_max_width_sticky || $is_image_svg) {
					$is_size_px = false;

					// If size is given in px, we want to override parent width
					if (
							false !== strpos($image_max_width, 'px') ||
							false !== strpos($image_max_width_tablet, 'px') ||
							false !== strpos($image_max_width_phone, 'px')
					) {
							$is_size_px = true;
					}
					// SVG image overwrite. SVG image needs its value to be explicit
					if ('' === $image_max_width && $is_image_svg) {
							$image_max_width = '100%';
					}

					// Image max width selector.
					$image_max_width_selectors = array();
					$image_max_width_reset_selectors = array();
					$image_max_width_reset_values = array();

					$image_max_width_selector = $icon_placement === 'top' && $is_image_svg ? '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_image' : '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_image .et_pb_image_wrap';

					foreach (array('tablet', 'phone') as $device) {
							$device_icon_placement = 'tablet' === $device ? $icon_placement_tablet : $icon_placement_phone;
							if (empty($device_icon_placement)) {
									continue;
							}

							$image_max_width_selectors[$device] = 'top' === $device_icon_placement && $is_image_svg ? '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_image' : '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_image .et_pb_image_wrap';

							$prev_icon_placement = 'tablet' === $device ? $icon_placement : $icon_placement_tablet;
							if (empty($prev_icon_placement) || $prev_icon_placement === $device_icon_placement || !$is_image_svg) {
									continue;
							}

							// Image/icon placement setting is related to image width setting. In some cases,
							// user uses different image/icon placement settings for each devices. We need to
							// reset previous device image width styles to make it works with current style.
							$image_max_width_reset_selectors[$device] = '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_image';
							$image_max_width_reset_values[$device] = array('width' => '32px');

							if ('top' === $device_icon_placement) {
									$image_max_width_reset_selectors[$device] = '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_image .et_pb_image_wrap';
									$image_max_width_reset_values[$device] = array('width' => 'auto');
							}
					}

					// Add image max width desktop selector if user sets different image/icon placement setting.
					if (!empty($image_max_width_selectors)) {
							$image_max_width_selectors['desktop'] = $image_max_width_selector;
					}

					$image_max_width_property = ($is_image_svg || $is_size_px) ? 'width' : 'max-width';

					$image_max_width_responsive_active = et_pb_get_responsive_status($image_max_width_last_edited);

					$image_max_width_values = array(
							'desktop' => $image_max_width,
							'tablet' => $image_max_width_responsive_active ? $image_max_width_tablet : '',
							'phone' => $image_max_width_responsive_active ? $image_max_width_phone : '',
					);

					$main_image_max_width_selector = $image_max_width_selector;

					// Overwrite image max width if there are image max width selectors for different devices.
					if (!empty($image_max_width_selectors)) {
							$main_image_max_width_selector = $image_max_width_selectors;

							if (!empty($image_max_width_selectors['tablet']) && empty($image_max_width_values['tablet'])) {
									$image_max_width_values['tablet'] = $image_max_width_responsive_active ? esc_attr(et_pb_responsive_options()->get_any_value($this->props, 'image_max_width_tablet', '100%', true)) : esc_attr($image_max_width);
							}

							if (!empty($image_max_width_selectors['phone']) && empty($image_max_width_values['phone'])) {
									$image_max_width_values['phone'] = $image_max_width_responsive_active ? esc_attr(et_pb_responsive_options()->get_any_value($this->props, 'image_max_width_phone', '100%', true)) : esc_attr($image_max_width);
							}
					}

					et_pb_responsive_options()->generate_responsive_css($image_max_width_values, $main_image_max_width_selector, $image_max_width_property, $render_slug);

					// Reset custom image max width styles.
					if (!empty($image_max_width_selectors) && !empty($image_max_width_reset_selectors)) {
							et_pb_responsive_options()->generate_responsive_css($image_max_width_reset_values, $image_max_width_reset_selectors, $image_max_width_property, $render_slug, '', 'input');
					}

					// Sticky styles.
					if (!empty($image_max_width_sticky)) {
							$sticky_main_image_max_width_selector = array();
							$sticky_image_max_width_reset_selectors = array();
							$sticky_image_max_width_property = ($is_image_svg || false !== strpos($image_max_width_sticky, 'px')) ? 'width' : 'max-width';

							if (is_array($main_image_max_width_selector)) {
									foreach ($main_image_max_width_selector as $device => $selector) {
											$sticky_main_image_max_width_selector[$device] = $sticky->add_sticky_to_selectors($selector, $is_sticky_module);
									}
							} else {
									$sticky_main_image_max_width_selector = $sticky->add_sticky_to_selectors($main_image_max_width_selector, $is_sticky_module);
							}

							if (!empty($image_max_width_reset_selectors)) {
									foreach ($image_max_width_reset_selectors as $device => $selector) {
											$sticky_image_max_width_reset_selectors[$device] = $sticky->add_sticky_to_selectors($selector, $is_sticky_module);
									}
							}

							et_pb_responsive_options()->generate_responsive_css(array_fill_keys(array('desktop', 'phone', 'tablet'), $image_max_width_sticky), $sticky_main_image_max_width_selector, $sticky_image_max_width_property, $render_slug);

							if (!empty($image_max_width_reset_values) && !empty($sticky_image_max_width_reset_selectors)) {
									et_pb_responsive_options()->generate_responsive_css($image_max_width_reset_values, $sticky_image_max_width_reset_selectors, $sticky_image_max_width_property, $render_slug, '', 'input');
							}
					}
			}

			if ('' !== $card_max_width_tablet || '' !== $card_max_width_phone || '' !== $card_max_width) {
					$card_max_width_responsive_active = et_pb_get_responsive_status($card_max_width_last_edited);

					$card_max_width_values = array(
							'desktop' => $card_max_width,
							'tablet' => $card_max_width_responsive_active ? $card_max_width_tablet : '',
							'phone' => $card_max_width_responsive_active ? $card_max_width_phone : '',
					);

					et_pb_responsive_options()->generate_responsive_css($card_max_width_values, '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_card', 'max-width', $render_slug);
			}

			// Sticky Content Width.
			if (!empty($card_max_width_sticky)) {
					ET_Builder_Element::set_style(
							$render_slug,
							array(
									'selector' => $sticky->add_sticky_to_selectors('.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_card', $is_sticky_module),
									'declaration' => sprintf(
											'max-width: %1$s;',
											esc_html($card_max_width_sticky)
									),
							)
					);
			}

			if (is_rtl() && 'left' === $icon_placement) {
					$icon_placement = 'right';
			}

			if (is_rtl() && 'left' === $icon_placement_tablet) {
					$icon_placement_tablet = 'right';
			}

			if (is_rtl() && 'left' === $icon_placement_phone) {
					$icon_placement_phone = 'right';
			}

			$ribbon_tag = 'span';
			$ribbon_attrs = array();
			$ribbon_attrs['class'] = "dipi_timeline_ribbon_text";
			$ribbon = $multi_view->render_element(
					array(
							'tag' => $ribbon_tag,
							'content' => '{{ribbon}}',
							'attrs' => $ribbon_attrs,
					)
			);

			$ribbon = sprintf(
					'<div class="dipi_htl_ribbon-wrapper">
						<div class="dipi_timeline_ribbon">%1$s</div>
					</div>',
					et_core_esc_previously($ribbon)
			);

			$title_tag = '' !== $url ? 'a' : 'span';
			$title_attrs = array();

			if ('a' === $title_tag) {
					$title_attrs['href'] = $url;

					if ('on' === $url_new_window) {
							$title_attrs['target'] = '_blank';
					}
			}

			$title = $multi_view->render_element(
					array(
							'tag' => $title_tag,
							'content' => '{{title}}',
							'attrs' => $title_attrs,
					)
			);

			if ('' !== $title) {
					$title = sprintf(
							'<%1$s class="dipi_htl_item_header">%2$s</%1$s>',
							et_pb_process_header_level($header_level, 'h4'),
							et_core_esc_previously($title)
					);
			}

			// Added for backward compatibility
			$image_classes = array();

			$image_attachment_class = et_pb_media_options()->get_image_attachment_class($this->props, 'image');

			if (!empty($image_attachment_class)) {
					$image_classes[] = esc_attr($image_attachment_class);
			}

			if ('off' === $use_icon) {
					$image = $multi_view->render_element(
							array(
									'tag' => 'img',
									'attrs' => array(
											'src' => '{{image}}',
											'class' => implode(' ', $image_classes),
											'alt' => $alt,
									),
									'required' => 'image',
							)
					);
			} else {
					$this->generate_styles(
							array(
									'base_attr_name' => 'icon_color',
									'selector' => $icon_selector,
									'css_property' => 'color',
									'render_slug' => $render_slug,
									'type' => 'color',
							)
					);

					if ('on' === $use_circle) {
							$this->generate_styles(
									array(
											'base_attr_name' => 'circle_color',
											'selector' => $icon_selector,
											'css_property' => 'background-color',
											'render_slug' => $render_slug,
											'type' => 'color',
									)
							);

							if ('on' === $use_circle_border) {
									$this->generate_styles(
											array(
													'base_attr_name' => 'circle_border_color',
													'selector' => $icon_selector,
													'css_property' => 'border-color',
													'render_slug' => $render_slug,
													'type' => 'color',
											)
									);
							}
					}

					$image_classes[] = 'dipi_timeline_font_icon';
					$image_classes[] = 'et-pb-icon';

					if ('on' === $use_circle) {
							$image_classes[] = 'et-pb-icon-circle';
					}

					if ('on' === $use_circle && 'on' === $use_circle_border) {
							$image_classes[] = 'et-pb-icon-circle-border';
					}

					$image = $multi_view->render_element(
							array(
									'content' => '{{font_icon}}',
									'attrs' => array(
											'class' => implode(' ', $image_classes),
									),
							)
					);

					$this->dipi_generate_font_icon_styles($render_slug, 'font_icon', '.dipi_horizontal_timeline %%order_class%% .dipi_timeline_font_icon');
			}

			// Ribbon Text
			$this->generate_styles(
					array(
							'base_attr_name' => 'ribbon_text_bgcolor',
							'selector' => '.dipi_horizontal_timeline %%order_class%% .dipi_timeline_ribbon .dipi_timeline_ribbon_text ',
							'css_property' => 'background-color',
							'render_slug' => $render_slug,
							'type' => 'color',
					)
			);
			// Images: Add CSS Filters and Mix Blend Mode rules (if set)
			$generate_css_image_filters = '';
			if ($image && array_key_exists('icon_settings', $this->advanced_fields) && array_key_exists('css', $this->advanced_fields['icon_settings'])) {
					$generate_css_image_filters = $this->generate_css_filters(
							$render_slug,
							'child_',
							self::$data_utils->array_get($this->advanced_fields['icon_settings']['css'], 'main', '.dipi_horizontal_timeline %%order_class%%')
					);
			}
			if ('off' === $use_icon) { 
				$image = $image ? sprintf('<span class="et_pb_image_wrap dipi_htl_item_image_popup" href="%2$s">%1$s</span>', $image, $image_src) : '';
			} else {
				$image = $image ? sprintf('<span class="et_pb_image_wrap">%1$s</span>', $image) : '';
			}
			
			$image = $image ? sprintf(
					'<div class="dipi_htl_item_image%2$s">%1$s</div>',
					('' !== $url
							? sprintf(
									'<a href="%1$s"%3$s>%2$s</a>',
									esc_attr($url),
									$image,
									('on' === $url_new_window ? ' target="_blank"' : '')
							)
							: $image
					),
					esc_attr($generate_css_image_filters)
			) : '';

			// Timeline Icon
			if ('off' !== $ribbon_use_icon_font_size) {
					$this->generate_styles(
							array(
									'base_attr_name' => 'timeline_icon_font_size',
									'selector' => $timeline_icon_selector,
									'css_property' => 'font-size',
									'render_slug' => $render_slug,
									'type' => 'range',
							)
					);
			}
			$this->generate_styles(
					array(
							'base_attr_name' => 'timeline_icon_color',
							'selector' => $timeline_icon_selector,
							'css_property' => 'color',
							'render_slug' => $render_slug,
							'type' => 'color',
					)
			);
			$this->apply_custom_style_for_hover(
					$this->slug,
					'timeline_icon_color',
					'color',
					$timeline_icon_hover_selector
			);

			if ('on' === $ribbon_use_circle) {
					$this->generate_styles(
							array(
									'base_attr_name' => 'ribbon_circle_color',
									'selector' => $timeline_icon_circle_selector,
									'css_property' => 'background-color',
									'render_slug' => $render_slug,
									'type' => 'color',
							)
					);
					$this->apply_custom_style_for_hover(
							$this->slug,
							'ribbon_circle_color',
							'background-color',
							$timeline_icon_circle_hover_selector
					);

					if ('on' === $ribbon_use_circle_border) {
							$this->generate_styles(
									array(
											'base_attr_name' => 'ribbon_circle_border_color',
											'selector' => $timeline_icon_circle_selector,
											'css_property' => 'border-color',
											'render_slug' => $render_slug,
											'type' => 'color',
									)
							);
							$this->apply_custom_style_for_hover(
									$this->slug,
									'ribbon_circle_border_color',
									'border-color',
									$timeline_icon_circle_hover_selector
							);
					}
			}

			$timeline_icon_classes[] = 'ribbon-ico';

			if ('on' === $ribbon_use_circle) {
					$timeline_icon_classes[] = 'ribbon-ico-circle';
			}

			if ('on' === $ribbon_use_circle && 'on' === $ribbon_use_circle_border) {
					$timeline_icon_classes[] = 'ribbon-ico-circle-border';
			}

			$timeline_icon = $multi_view->render_element(
					array(
							'content' => '',
							'attrs' => array(
									'data-icon' => esc_attr(et_pb_process_font_icon($timeline_icon)),
									'class' => implode(' ', $timeline_icon_classes),
							),
					)
			);
			
			$this->dipi_generate_font_icon_styles($render_slug, 'timeline_icon', '.dipi_horizontal_timeline %%order_class%% .ribbon-ico:after');
				
			$this->apply_custom_margin_padding(
				$this->slug,
				'timeline_icon_margin',
				'margin',
				$timeline_icon_selector
			);
			$this->apply_custom_margin_padding(
					$this->slug,
					'timeline_icon_padding',
					'padding',
					$timeline_icon_selector
			);
			$this->apply_custom_margin_padding(
				$this->slug,
				'icon_image_margin',
				'margin',
				$img_wrapper_selector
			);

			$this->apply_custom_margin_padding(
				$this->slug,
				'icon_image_padding',
				'padding',
				$img_wrapper_selector
			);
			$this->apply_custom_margin_padding(
				$this->slug,
				'circle_icon_padding',
				'padding',
				$icon_selector
			);

			$timeline_icon = $timeline_icon ? sprintf('<div class="et_pb_image_wrap ribbon-ico-wrap">%1$s</div>', $timeline_icon) : '';
			$video_background = $this->video_background();
			$parallax_image_background = $this->get_parallax_image_background();

			// Module classnames
			$module_custom_classes = ' dipi_htl_item_custom_classes';

			$module_custom_classes .= $this->get_text_orientation_classname();

			$module_custom_classes .= sprintf(' dipi_htl_item_position_%1$s', esc_attr($icon_placement));

			// Background layout class names.
			$background_layout_class_names = et_pb_background_layout_options()->get_background_layout_class($this->props);

			$module_custom_classes .= " " . implode(" ", $background_layout_class_names);

			if (!empty($icon_placement_tablet)) {
					$module_custom_classes .= " dipi_htl_item_position_{$icon_placement_tablet}_tablet";
			}

			if (!empty($icon_placement_phone)) {
					$module_custom_classes .= " dipi_htl_item_position_{$icon_placement_phone}_phone";
			}

			if ($custom_card_arrow == 'on') {
					$module_custom_classes .= " dipi_htl_item_custom-card-arrow";
			}

			// Render button
			$button = $this->render_button(
					array(
							'button_classname' => array('dipi_htl_item_button'),
							'button_custom' => $button_custom,
							'button_rel' => $button_rel,
							'button_text' => $button_text,
							'button_text_escaped' => true,
							'button_url' => $button_url,
							'custom_icon' => $custom_icon,
							'custom_icon_tablet' => $custom_icon_tablet,
							'custom_icon_phone' => $custom_icon_phone,
							'url_new_window' => $button_url_new_window,
							'display_button' => ('' !== $button_url && $multi_view->has_value('button_text')),
							'multi_view_data' => $multi_view->render_attrs(
									array(
											'content' => '{{button_text}}',
											'visibility' => array(
													'button_text' => '__not_empty',
													'button_url' => '__not_empty',
											),
									)
							),
					)
			);

			// Background layout data attributes.
			$data_background_layout = et_pb_background_layout_options()->get_background_layout_attrs($this->props);

			$content = $multi_view->render_element(
					array(
							'tag' => 'div',
							'content' => '{{content}}',
							'attrs' => array(
									'class' => 'dipi_htl_item_description',
							),
					)
			);

			/* Card Arrow */
			$this->generate_styles(
					array(
							'base_attr_name' => 'card_arrow_color',
							'selector' => '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_custom-card-arrow .dipi_htl_item_card-wrap:after',
							'css_property' => 'border-bottom-color',
							'render_slug' => $render_slug,
							'type' => 'color',
					)
			);
			$this->generate_styles(
					array(
							'base_attr_name' => 'card_arrow_color',
							'selector' => '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_custom-card-arrow .dipi_htl_item_card-wrap:after',
							'css_property' => 'border-top-color',
							'render_slug' => $render_slug,
							'type' => 'color',
					)
			);
			$this->generate_styles(
					array(
							'base_attr_name' => 'card_arrow_size',
							'selector' => '.dipi_horizontal_timeline %%order_class%% .dipi_htl_item_custom-card-arrow .dipi_htl_item_card-wrap:after',
							'css_property' => 'border-width',
							'render_slug' => $render_slug,
							'type' => 'range',
							'important' => true,
					)
			);
			$this->apply_custom_style_for_desktop(
					$this->slug,
					'card_arrow_size',
					'top',
					'.dipi_htl_layout_bottom .dipi_htl_container %%order_class%%.dipi_horizontal_timeline_item .dipi_htl_item_custom-card-arrow  .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
			.dipi_htl_layout_mixed.startpos-bottom .dipi_htl_container %%order_class%%.dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_custom-card-arrow .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
			.dipi_htl_layout_mixed.startpos-top .dipi_htl_container %%order_class%%.dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_custom-card-arrow .dipi_htl_item_container .dipi_htl_item_card-wrap:after
		',
					true,
					-1,
					'px'
			);

			$this->apply_custom_style_for_tablet(
					$this->slug,
					'card_arrow_size',
					'top',
					'.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_bottom_tablet .dipi_htl_container .dipi-htl-items:nth-child(odd) %%order_class%%.dipi_horizontal_timeline_item .dipi_htl_item_custom-card-arrow  .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
		.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_bottom_tablet .dipi_htl_container .dipi-htl-items:nth-child(even) %%order_class%%.dipi_horizontal_timeline_item .dipi_htl_item_custom-card-arrow  .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
		.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_mixed_tablet.startpos-bottom .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_custom-card-arrow .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
		.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_mixed_tablet.startpos-top .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_custom-card-arrow .dipi_htl_item_container .dipi_htl_item_card-wrap:after
		',
		true,
					-1,
					'px'
			);
			$this->apply_custom_style_for_phone(
					$this->slug,
					'card_arrow_size',
					'top',
					'div.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_bottom_phone .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_custom-card-arrow .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
		div.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_bottom_phone .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_custom-card-arrow .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
		div.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_mixed_phone.startpos-bottom .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_custom-card-arrow .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
		div.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_mixed_phone.startpos-top .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_custom-card-arrow .dipi_htl_item_container .dipi_htl_item_card-wrap:after
		',
		true,
					-1,
					'px'
			);
			if (isset($card_margin) && count($card_margin) >= 4) {
					ET_Builder_Element::set_style($this->slug, array(
							'selector' => '.dipi_htl_layout_bottom.dipi_timeline_show-card-arrow .dipi_htl_container  %%order_class%%.dipi_horizontal_timeline_item .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
			.dipi_htl_layout_mixed.startpos-bottom.dipi_timeline_show-card-arrow .dipi_htl_container  %%order_class%%.dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
			.dipi_htl_layout_mixed.startpos-top.dipi_timeline_show-card-arrow .dipi_htl_container %%order_class%%.dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_container .dipi_htl_item_card-wrap:after
			',
							'declaration' => "transform: translate($card_margin[3], -50%);",
					));
			}
			if (isset($card_margin_tablet) && count($card_margin_tablet) >= 4) {
					ET_Builder_Element::set_style($this->slug, array(
							'selector' => '.dipi_horizontal_timeline .dipi_htl_layout_bottom_tablet.dipi_timeline_show-card-arrow .dipi_htl_container .dipi-htl-items:nth-child(odd) %%order_class%%.dipi_horizontal_timeline_item .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
			.dipi_horizontal_timeline .dipi_htl_layout_bottom_tablet.dipi_timeline_show-card-arrow .dipi_htl_container .dipi-htl-items:nth-child(even) %%order_class%%.dipi_horizontal_timeline_item .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
			.dipi_horizontal_timeline .dipi_htl_layout_mixed_tablet.startpos-bottom.dipi_timeline_show-card-arrow .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
			.dipi_horizontal_timeline .dipi_htl_layout_mixed_tablet.startpos-top.dipi_timeline_show-card-arrow .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_container .dipi_htl_item_card-wrap:after
				',
							'declaration' => "transform: translate($card_margin_tablet[3], -50%);",
							'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
					));
			}
			if (isset($card_margin_phone) && count($card_margin_phone) >= 4) {
					ET_Builder_Element::set_style($this->slug, array(
							'selector' => 'div.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_bottom_phone.dipi_timeline_show-card-arrow .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
			div.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_bottom_phone.dipi_timeline_show-card-arrow .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
			div.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_mixed_phone.dipi_timeline_show-card-arrow.startpos-bottom .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
			div.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_mixed_phone.dipi_timeline_show-card-arrow.startpos-top .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_container .dipi_htl_item_card-wrap:after
				',
							'declaration' => "transform: translate($card_margin_phone[3], -50%);",
							'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
					));
			}

			$this->apply_custom_style_for_desktop(
					$this->slug,
					'card_arrow_size',
					'bottom',
					'.dipi_htl_layout_top .dipi_htl_container %%order_class%%.dipi_horizontal_timeline_item .dipi_htl_item_custom-card-arrow .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
		.dipi_htl_layout_mixed.startpos-bottom .dipi_htl_container %%order_class%%.dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_custom-card-arrow .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
		.dipi_htl_layout_mixed.startpos-top .dipi_htl_container %%order_class%%.dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_custom-card-arrow .dipi_htl_item_container .dipi_htl_item_card-wrap:after
		',
					true,
					-1,
					'px'
			);

			$this->apply_custom_style_for_tablet(
					$this->slug,
					'card_arrow_size',
					'bottom',
					'.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_top_tablet .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_custom-card-arrow .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
		.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_top_tablet .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_custom-card-arrow .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
		.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_mixed_tablet.startpos-bottom .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_custom-card-arrow .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
		.dipi_horizontal_timeline.et_pb_module .dipi_htl_layout_mixed_tablet.startpos-top .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_custom-card-arrow .dipi_htl_item_container .dipi_htl_item_card-wrap:after
		',
		true,
					-1,
					'px'
			);
			$this->apply_custom_style_for_phone(
					$this->slug,
					'card_arrow_size',
					'bottom',
					'div.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_top_phone .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_custom-card-arrow .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
		div.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_top_phone .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_custom-card-arrow .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
		div.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_mixed_phone.startpos-bottom .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_custom-card-arrow .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
		div.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_mixed_phone.startpos-top .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_custom-card-arrow .dipi_htl_item_container .dipi_htl_item_card-wrap:after
		',
		true,
					-1,
					'px'
			);

			if (isset($card_margin) && count($card_margin) >= 4) {
					ET_Builder_Element::set_style($this->slug, array(
							'selector' => '.dipi_htl_layout_top.dipi_timeline_show-card-arrow .dipi_htl_container  %%order_class%%.dipi_horizontal_timeline_item .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
			.dipi_htl_layout_mixed.startpos-bottom.dipi_timeline_show-card-arrow .dipi_htl_container  %%order_class%%.dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
			.dipi_htl_layout_mixed.startpos-top.dipi_timeline_show-card-arrow .dipi_htl_container %%order_class%%.dipi_horizontal_timeline_item:nth-child(odd)  .dipi_htl_item_container .dipi_htl_item_card-wrap:after
				',
							'declaration' => "transform: translate(-$card_margin[1], -50%);",
					));
			}
			if (isset($card_margin_tablet) && count($card_margin_tablet) >= 4) {
					ET_Builder_Element::set_style($this->slug, array(
							'selector' => '.dipi_horizontal_timeline .dipi_htl_layout_top_tablet.dipi_timeline_show-card-arrow .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
			.dipi_horizontal_timeline .dipi_htl_layout_top_tablet.dipi_timeline_show-card-arrow .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
			.dipi_horizontal_timeline .dipi_htl_layout_mixed_tablet.startpos-bottom.dipi_timeline_show-card-arrow .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
			.dipi_horizontal_timeline .dipi_htl_layout_mixed_tablet.startpos-top.dipi_timeline_show-card-arrow .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_container .dipi_htl_item_card-wrap:after
				',
							'declaration' => "transform: translate(-$card_margin_tablet[1], -50%);",
							'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
					));
			}
			if (isset($card_margin_phone) && count($card_margin_phone) >= 4) {
					ET_Builder_Element::set_style($this->slug, array(
							'selector' => 'div.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_top_phone.dipi_timeline_show-card-arrow .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
			div.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_top_phone.dipi_timeline_show-card-arrow .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
			div.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_mixed_phone.startpos-bottom.dipi_timeline_show-card-arrow .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(even) .dipi_htl_item_container .dipi_htl_item_card-wrap:after,
			div.et_pb_module.dipi_horizontal_timeline .dipi_htl_layout_mixed_phone.startpos-top.dipi_timeline_show-card-arrow .dipi_htl_container .dipi-htl-items %%order_class%%.dipi_horizontal_timeline_item:nth-child(odd) .dipi_htl_item_container .dipi_htl_item_card-wrap:after
				',
					'declaration' => "transform: translate(-$card_margin_phone[1], -50%);",
					'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
				));
			}

			// Modify wrapper and inner wrapper settings
			// This is rarely needed and not recommended to be modified. However, these are configurable
			// if changing them is needed to achieve particular visual output
			//$this->wrapper_settings = array(
			// 'parallax_background'     => '',
			// 'video_background'        => '',
			// 'attrs'                   => array(),
			//'inner_attrs'             => array(
			//  'class' => 'dipi_htl_item_container',
			//),
			//);
			$output = sprintf(
				'<div class="%12$s">
					<div class="dipi_htl_item_container">
						%9$s
						%11$s
						<div class="dipi_htl_item_card-wrap">
							<div class="dipi_htl_item_card">
								%7$s
								<span class="et_pb_background_pattern"></span>
								<span class="et_pb_background_mask"></span>
								%6$s
								%2$s
								<div class="dipi_htl_item_content">
									<div class="dipi_htl_item_content_text">
										%3$s
										%1$s
									</div>
									%10$s
								</div> <!-- .dipi_htl_item_content -->
							</div> <!-- .dipi_htl_item_card -->
						</div>
					</div>
				</div>
			',
			$content,
			et_core_esc_previously($image),
			et_core_esc_previously($title),
			$this->module_classname($render_slug),
			'', // #5
			$video_background,
			$parallax_image_background,
			et_core_esc_previously($data_background_layout),
			et_core_esc_previously($ribbon),
			$button, //#10
			et_core_esc_previously($timeline_icon),
			$module_custom_classes
		);

		return $output;
	}
	/**
     * Filter multi view value.
     *
     * @since 3.27.1
     *
     * @see ET_Builder_Module_Helper_MultiViewOptions::filter_value
     *
     * @param mixed                                     $raw_value Props raw value.
     * @param array                                     $args {
     *                                         Context data.
     *
     *     @type string $context      Context param: content, attrs, visibility, classes.
     *     @type string $name         Module options props name.
     *     @type string $mode         Current data mode: desktop, hover, tablet, phone.
     *     @type string $attr_key     Attribute key for attrs context data. Example: src, class, etc.
     *     @type string $attr_sub_key Attribute sub key that availabe when passing attrs value as array such as styes. Example: padding-top, margin-botton, etc.
     * }
     * @param ET_Builder_Module_Helper_MultiViewOptions $multi_view Multiview object instance.
     *
     * @return mixed
     */
    public function multi_view_filter_value($raw_value, $args, $multi_view)
    {
        $name = isset($args['name']) ? $args['name'] : '';
        $mode = isset($args['mode']) ? $args['mode'] : '';

        if ($raw_value && 'font_icon' === $name) {
            $processed_value = html_entity_decode(et_pb_process_font_icon($raw_value));
            if ('%%1%%' === $raw_value) {
                $processed_value = '"';
            }

            return $processed_value;
        }

        $fields_need_escape = array(
            'button_text',
        );

        if ($raw_value && in_array($name, $fields_need_escape, true)) {
            return $this->_esc_attr($multi_view->get_name_by_mode($name, $mode), 'none', $raw_value);
        }

        return $raw_value;
    }

}

new DIPI_HorizontalTimeline_Item();
