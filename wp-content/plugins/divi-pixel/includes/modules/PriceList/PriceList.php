<?php

class DIPI_PriceList extends DIPI_Builder_Module
{

    public $slug = 'dipi_price_list';
    public $vb_support = 'on';
    public $child_slug = 'dipi_price_list_item';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/price-list',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__('Pixel Price List', 'dipi-divi-pixel');
    }

    public function get_settings_modal_toggles()
    {
        $toggles = [];

        $toggles['general'] = [
            'toggles' => [
                'title' => esc_html__('Title', 'dipi-divi-pixel'),
                'price' => esc_html__('Price', 'dipi-divi-pixel'),
                'description' => esc_html__('Desription', 'dipi-divi-pixel'),
            ],
        ];

        $toggles['advanced'] = [
            'toggles' => [
                'layout' => esc_html__('Layout', 'dipi-divi-pixel'),
                'image' => esc_html__('Image', 'dipi-divi-pixel'),
                'separator' => esc_html__('Separator', 'dipi-divi-pixel'),
                'text' => array(
                    'title' => esc_html__('Text', 'et_builder'),
                    // 'priority' => 48,
                    'tabbed_subtoggles' => true,
                    'sub_toggles' => array(
                        'title' => array(
                            'name' => 'Title',
                            'icon' => 'title',
                        ),
                        'price' => array(
                            'name' => 'Price',
                            'icon' => 'price',
                        ),
                        'description' => array(
                            'name' => 'Description',
                            'icon' => 'description',
                        ),
                    ),
                ),
            ],
        ];

        return $toggles;
    }

    public function get_custom_css_fields_config()
    {
        $fields = [];

        $fields['price_list_item'] = [
            'label' => esc_html__('Price List Items', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_price_list_item',
        ];

        $fields['img_wrap'] = [
            'label' => esc_html__('Image Wrapper', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_price_list_image_wrapper',
        ];

        $fields['img'] = [
            'label' => esc_html__('Image', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_price_list_image_wrapper img',
        ];

        $fields['txt_wrap'] = [
            'label' => esc_html__('Text Wrapper', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_price_list_text_wrapper',
        ];

        $fields['title'] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_price_list_title',
        ];

        $fields['price'] = [
            'label' => esc_html__('Price', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_price_list_price',
        ];

        $fields['separator'] = [
            'label' => esc_html__('Separator', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_price_list_separator',
        ];

        $fields['description'] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_price_list_content',
        ];

        $fields['dipi_price_list_prefix_price'] = [
            'label'    => esc_html__('Price Prefix', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_price_list_prefix_price',
        ];
        $fields['dipi_price_list_suffix_price'] = [
            'label'    => esc_html__('Price Suffix', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_price_list_suffix_price',
        ];

        return $fields;
    }

    public function get_fields()
    {

        $fields = [];

        $fields['list_item_flex_direction'] = [
            'label' => esc_html__('Layout', 'dipi-divi-pixel'),
            'description' => esc_html__('Show image and content in row or column', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => [
                'row' => 'Row',
                'column' => 'Column',
            ],
            'default' => 'row',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'layout',
            'mobile_options'     => true,
        ];

        $fields['image_flex_align_items'] = [
            'label' => esc_html__('Image Alignment', 'dipi-divi-pixel'),
            'description' => esc_html__('How the image is aligned inside each item.', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => [
                'flex-start' => 'Start',
                'center' => 'Center',
                'flex-end' => 'End',
                'baseline' => 'Baseline',
            ],
            'default' => 'flex-start',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'layout',
            'mobile_options'     => true,
        ];

        $fields['header_flex_align_items'] = [
            'label' => esc_html__('Header Alignment', 'dipi-divi-pixel'),
            'description' => esc_html__('How the title, separator and price is vertically aligned inside the header.', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => [
                'flex-start' => 'Top',
                'center' => 'Center',
                'flex-end' => 'Bottom',
                'baseline' => 'Baseline',
            ],
            'default' => 'baseline',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'layout',
        ];

        $fields['item_spacing'] = [
            'label' => esc_html__('Item Spacing', 'dipi-divi-pixel'),
            'description' => esc_html__('The vertical spacing between each item.', 'dipi-divi-pixel'),
            'type' => 'range',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'margin_padding',
            'range_settings' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'mobile_options' => true,
            'default_unit' => 'px',
            'default' => '',
        ];

        $fields["item_padding"] = [
            'label' => esc_html__('Item Padding', 'dipi-divi-pixel'),
            'description' => esc_html__('The padding inside each item.', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'mobile_options' => true,
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'margin_padding',
        ];

        $fields["item_text_padding"] = [
            'label' => esc_html__('Item Text Wrapper Padding', 'dipi-divi-pixel'),
            'description' => esc_html__('The padding of the text container.', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'mobile_options' => true,
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'margin_padding',
        ];

        $fields["show_lightbox"] = [
            'label' => esc_html__('Open Image in Lightbox', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'on',
            'options' => array(
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'image',
            'description' => esc_html__('Whether or not to show lightbox.', 'dipi-divi-pixel'),
            'mobile_options' => true,
        ];
        $fields['use_thumbnails'] = [
            'label' => esc_html__('Use Responsive Thumbnails', 'dipi-divi-pixel'),
            'description' => esc_html__('Whether or not to use custom sized thumbnails on different devices. If this option is disabled, the full size image will be used as thumbnail.', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'image',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
        ];

        $fields['image_size_desktop'] = [
            'label' => esc_html__('Image Size (Desktop)', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'full',
            'options' => $this->dipi_get_image_sizes(),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'image',
            'description' => 'Here you can choose the image size to use. If you are using very large images, consider using a thumbnail size to speed up page loading time.',
            'show_if' => [
                'use_thumbnails' => 'on',
            ],
        ];
        $fields['image_size_tablet'] = [
            'label' => esc_html__('Image Size (Tablet)', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'full',
            'options' => $this->dipi_get_image_sizes(),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'image',
            'description' => 'Here you can choose the image size to use. If you are using very large images, consider using a thumbnail size to speed up page loading time.',
            'show_if' => [
                'use_thumbnails' => 'on',
            ],
        ];

        $fields['image_size_phone'] = [
            'label' => esc_html__('Image Size (Phone)', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'full',
            'options' => $this->dipi_get_image_sizes(),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'image',
            'description' => 'Here you can choose the image size to use. If you are using very large images, consider using a thumbnail size to speed up page loading time.',
            'show_if' => [
                'use_thumbnails' => 'on',
            ],
        ];
        $fields['image_spacing'] = [
            'label' => esc_html__('Image Spacing', 'dipi-divi-pixel'),
            'description' => esc_html__('The spacing between the image and the text container.', 'dipi-divi-pixel'),
            'type' => 'range',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'image',
            'default' => '0px',
            'range_settings' => array(
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ),
            'mobile_options' => true,
			'default_unit' => 'px',
            'default' => '',
        ];

        $fields['image_width'] = [
            'label' => esc_html__('Image Width', 'dipi-divi-pixel'),
            'description' => esc_html__('The width of the image of each item.', 'dipi-divi-pixel'),
            'type' => 'range',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'image',
            'range_settings' => array(
                'min' => '1',
                'max' => '100',
                'step' => '1',
            ),
            'mobile_options' => true,
            'default' => '25%',
        ];
        $fields['image_min_width'] = [
            'label' => esc_html__('Image Min Width', 'dipi-divi-pixel'),
            'description' => esc_html__('The Min width of the image of each item.', 'dipi-divi-pixel'),
            'type' => 'range',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'image',
            'range_settings' => array(
                'min' => '1',
                'max' => '100',
                'step' => '1',
            ),
            'mobile_options' => true,
            'default' => '0',
            'default_unit' => 'px',
        ];
        $fields['separator_style'] = [
            'label' => esc_html__('Separator Style', 'dipi-divi-pixel'),
            'description' => esc_html__('The CSS border-style used for the separator.', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => [
                'none' => 'none',
                'dotted' => 'dotted',
                'dashed' => 'dashed',
                'double' => 'double',
                'groove' => 'groove',
                'hidden' => 'hidden',
                'inherit' => 'inherit',
                'initial' => 'initial',
                'inset' => 'inset',
                'outset' => 'outset',
                'ridge' => 'ridge',
                'solid' => 'solid',
                'unset' => 'unset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'separator',
            'default' => 'dotted',
            'mobile_options' => true,

        ];

        $fields['separator_weight'] = [
            'label' => esc_html__('Separator Height', 'dipi-divi-pixel'),
            'description' => esc_html__('The CSS border-width used for the separator.', 'dipi-divi-pixel'),
            'type' => 'range',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'image',
            'default' => '2px',
            'range_settings' => array(
                'min' => '1',
                'max' => '100',
                'step' => '1',
            ),
            'toggle_slug' => 'separator',
            'mobile_options' => true,
            'validate_unit' => true,
        ];

        $fields['separator_color'] = [
            'label' => esc_html__('Separator Color', 'dipi-divi-pixel'),
            'description' => esc_html__('The CSS border-color used for the separator.', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'default' => et_builder_accent_color(),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'separator',
        ];

        $fields['separator_spacing'] = [
            'label' => esc_html__('Separator Spacing', 'dipi-divi-pixel'),
            'description' => esc_html__('The spacing between the title/price and the separator.', 'dipi-divi-pixel'),
            'type' => 'range',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'separator',
            'default' => '5px',
            'range_settings' => array(
                'min' => '1',
                'max' => '100',
                'step' => '1',
            ),
            'mobile_options' => true,
        ];
        return $fields;
    }
    public function dipi_get_image_sizes()
    {
        global $_wp_additional_image_sizes;
        $sizes = array();
        $get_intermediate_image_sizes = get_intermediate_image_sizes();
        foreach ($get_intermediate_image_sizes as $_size) {
            if (in_array($_size, array('thumbnail', 'medium', 'large'))) {
                $sizes[$_size]['width'] = get_option($_size . '_size_w');
                $sizes[$_size]['height'] = get_option($_size . '_size_h');
                $sizes[$_size]['crop'] = (bool) get_option($_size . '_crop');
            } elseif (isset($_wp_additional_image_sizes[$_size])) {
                $sizes[$_size] = array(
                    'width' => $_wp_additional_image_sizes[$_size]['width'],
                    'height' => $_wp_additional_image_sizes[$_size]['height'],
                    'crop' => $_wp_additional_image_sizes[$_size]['crop'],
                );
            }
        }

        $image_sizes = array(
            'full' => esc_html__('Full Size', 'dipi-divi-pixel'),
        );
        foreach ($sizes as $sizeKey => $sizeValue) {
            $image_sizes[$sizeKey] = sprintf(
                '%1$s (%2$s x %3$s,%4$s cropped)',
                $sizeKey,
                $sizeValue["width"],
                $sizeValue["height"],
                ($sizeValue["crop"] == false ? ' not' : '')

            );
        }

        return $image_sizes;
    }
    public function get_advanced_fields_config()
    {
        $advanced_fields = [];
        $advanced_fields['fonts'] = [];
        $advanced_fields['text'] = false;
        $advanced_fields['text_shadow'] = false;

        $advanced_fields['fonts']['title'] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'toggle_slug' => 'text',
            'sub_toggle' => 'title',
            'line_height' => array(
                'default' => '1em',
                'range_settings' => array(
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ),
            ),
            'font_size' => array(
                'range_settings' => array(
                    'default' => '22px',
                    'min' => '1',
                    'max' => '100',
                    'step' => '1',
                ),
            ),
            'css' => array(
                'main' => '%%order_class%% .dipi_price_list_item .dipi_price_list_title',
            ),
        ];

        $advanced_fields['fonts']['price'] = [
            'label' => esc_html__('Price', 'dipi-divi-pixel'),
            'toggle_slug' => 'text',
            'sub_toggle' => 'price',
            'line_height' => array(
                'range_settings' => array(
                    'default' => '1em',
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ),
            ),
            'font_size' => array(
                'default' => '24px',
                'range_settings' => array(
                    'min' => '1',
                    'max' => '100',
                    'step' => '1',
                ),
            ),
            'css' => array(
                'main' => '%%order_class%% .dipi_price_list_item .dipi_price_list_price',
            ),
        ];

        $advanced_fields['fonts']['description'] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'toggle_slug' => 'text',
            'sub_toggle' => 'description',
            'line_height' => array(
                'default' => '1em',
                'range_settings' => array(
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ),
            ),
            'font_size' => array(
                'default' => '16px',
                'range_settings' => array(
                    'min' => '1',
                    'max' => '100',
                    'step' => '1',
                ),
            ),
            'css' => array(
                'main' => '%%order_class%% .dipi_price_list_item .dipi_price_list_content',
            ),
        ];

        $advanced_fields["box_shadow"]["default"] = [];
        $advanced_fields["box_shadow"]["images"] = [
            'label' => esc_html__('Image Box Shadow', 'dipi-divi-pixel'),
            'toggle_slug' => 'image',
            'tab_slug' => 'advanced',
            'css' => [
                'main' => "%%order_class%% .dipi_price_list_item .dipi_price_list_image_wrapper img",
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

        $advanced_fields["borders"]["images"] = [
            'label_prefix' => esc_html__('Image', 'dipi-divi-pixel'),
            'toggle_slug' => 'image',
            'tab_slug' => 'advanced',
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi_price_list_item .dipi_price_list_image_wrapper img",
                    'border_styles' => "%%order_class%% .dipi_price_list_item .dipi_price_list_image_wrapper img",
                ],
            ],
        ];

        return $advanced_fields;
    }

    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_price_list_public');
        wp_enqueue_style('magnific-popup');
        
        $this->dipi_apply_css($render_slug);

        $show_lightbox               = $this->props['show_lightbox'];
        $show_lightbox_values        = et_pb_responsive_options()->get_property_values( $this->props, 'show_lightbox' );
        
        $show_lightbox_tablet        = isset( $show_lightbox_values['tablet'] ) && !empty( $show_lightbox_values['tablet'] )? $show_lightbox_values['tablet'] : $show_lightbox;
        $show_lightbox_phone         = isset( $show_lightbox_values['phone'] ) && !empty( $show_lightbox_values['phone'] )? $show_lightbox_values['phone'] : $show_lightbox_tablet;

        $show_lightboxclasses = ($show_lightbox === 'on') ? 'show_lightbox' : 'hide_lightbox';
        if (!empty($show_lightbox_tablet)) {
            $show_lightboxclasses .= ($show_lightbox_tablet === 'on') ? ' show_lightbox_tablet' : ' hide_lightbox_tablet';
        }
        if (!empty($show_lightbox_phone)) {
            $show_lightboxclasses .= ($show_lightbox_phone === 'on') ? ' show_lightbox_phone' : ' hide_lightbox_phone';
        }

        return sprintf('
			<div class="dipi_price_list-main %2$s">
				%1$s
			</div>',
            $this->props['content'],
            $show_lightboxclasses
        );

    }

    public function dipi_apply_css($render_slug)
    {
        $this->dipi_apply_image_css($render_slug);
        $this->dipi_apply_item_spacing_css($render_slug);
        $this->dipi_apply_item_padding_css($render_slug);
        $this->dipi_apply_item_text_padding_css($render_slug);

        //Layout

        $list_item_flex_direction = $this->dipi_get_responsive_prop('list_item_flex_direction');

		ET_Builder_Element::set_style($render_slug, array(
			'selector' => "%%order_class%% .dipi_price_list_item_wrapper",
			'declaration' => "flex-direction: {$list_item_flex_direction['desktop']};",
		));

		ET_Builder_Element::set_style($render_slug, array(
			'selector' => "%%order_class%% .dipi_price_list_item_wrapper",
			'declaration' => "flex-direction: {$list_item_flex_direction['tablet']};",
			'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
		));

		ET_Builder_Element::set_style($render_slug, array(
			'selector' => "%%order_class%% .dipi_price_list_item_wrapper",
			'declaration' => "flex-direction: {$list_item_flex_direction['phone']};",
			'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));

		// Image Alignment

        $image_flex_align_items = $this->dipi_get_responsive_prop('image_flex_align_items');

		ET_Builder_Element::set_style($render_slug, array(
			'selector' => '%%order_class%% .dipi_price_list_item_wrapper',
            'declaration' => "align-items: {$image_flex_align_items['desktop']};",
		));

		ET_Builder_Element::set_style($render_slug, array(
			'selector' => '%%order_class%% .dipi_price_list_item_wrapper',
			'declaration' => "align-items: {$image_flex_align_items['tablet']};",
			'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
		));

		ET_Builder_Element::set_style($render_slug, array(
			'selector' => '%%order_class%% .dipi_price_list_item_wrapper',
			'declaration' => "align-items: {$image_flex_align_items['phone']};",
			'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));

		// Header Alignment
		$header_flex_align_items = $this->props['header_flex_align_items'];
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi_price_list_header',
            'declaration' => "align-items: {$header_flex_align_items};",
        ]);

		// Separator
		$separator_style = $this->props['separator_style'];
        $separator_weight = $this->props['separator_weight'];
        $separator_color = $this->props['separator_color'];
        $separator_spacing = $this->props['separator_spacing'];
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi_price_list_separator',
            'declaration' => "
            	border-bottom-style: {$separator_style};
            	border-bottom-width: {$separator_weight};
            	border-bottom-color: {$separator_color};
            	margin-left: {$separator_spacing};
            	margin-right: {$separator_spacing};
            ",
        ]);

    }

    private function dipi_apply_item_spacing_css($render_slug)
    {
        if (!isset($this->props['item_spacing']) || '' === $this->props['item_spacing']) {
            return;
        }

        $item_spacing = $this->dipi_get_responsive_prop('item_spacing');
        
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi_price_list_item:not(:last-child)',
            'declaration' => "margin-bottom: {$item_spacing['desktop']};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi_price_list_item:not(:last-child)',
            'declaration' => "margin-bottom: {$item_spacing['tablet']};",
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi_price_list_item:not(:last-child)',
            'declaration' => "margin-bottom: {$item_spacing['phone']};",
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);
    }

    private function dipi_apply_item_padding_css($render_slug)
    {
        if (!isset($this->props['item_padding']) || '' === $this->props['item_padding']) {
            return;
        }

        $item_padding = $this->dipi_get_responsive_prop('item_padding');
        $item_padding_desktop = explode("|", $item_padding['desktop']);
        $item_padding_tablet = explode("|", $item_padding['tablet']);
        $item_padding_phone = explode("|", $item_padding['phone']);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi_price_list_item',
            'declaration' => "padding-top: {$item_padding_desktop[0]};
							  padding-right: {$item_padding_desktop[1]};
							  padding-bottom: {$item_padding_desktop[2]};
							  padding-left: {$item_padding_desktop[3]};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi_price_list_item',
            'declaration' => "padding-top: {$item_padding_tablet[0]};
							  padding-right: {$item_padding_tablet[1]};
							  padding-bottom: {$item_padding_tablet[2]};
							  padding-left: {$item_padding_tablet[3]};",
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi_price_list_item',
            'declaration' => "padding-top: {$item_padding_phone[0]};
							  padding-right: {$item_padding_phone[1]};
							  padding-bottom: {$item_padding_phone[2]};
							  padding-left: {$item_padding_phone[3]};",
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);
    }

    private function dipi_apply_item_text_padding_css($render_slug)
    {
		if (!isset($this->props['item_text_padding']) || '' === $this->props['item_text_padding']) {
            return;
        }

        $item_text_padding = $this->dipi_get_responsive_prop('item_text_padding');
		$item_text_padding_desktop = explode("|", $item_text_padding['desktop']);
		$item_text_padding_tablet = explode("|", $item_text_padding['tablet']);
		$item_text_padding_phone = explode("|", $item_text_padding['phone']);


        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi_price_list_item .dipi_price_list_text_wrapper',
			'declaration' => "padding-top: {$item_text_padding_desktop[0]};
							  padding-right: {$item_text_padding_desktop[1]};
							  padding-bottom: {$item_text_padding_desktop[2]};
							  padding-left: {$item_text_padding_desktop[3]};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi_price_list_item .dipi_price_list_text_wrapper',
            'declaration' => "padding-top: {$item_text_padding_tablet[0]};
							  padding-right: {$item_text_padding_tablet[1]};
							  padding-bottom: {$item_text_padding_tablet[2]};
							  padding-left: {$item_text_padding_tablet[3]};",
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi_price_list_item .dipi_price_list_text_wrapper',
            'declaration' => "padding-top: {$item_text_padding_phone[0]};
							  padding-right: {$item_text_padding_phone[1]};
							  padding-bottom: {$item_text_padding_phone[2]};
							  padding-left: {$item_text_padding_phone[3]};",
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);
    }

	private function dipi_apply_image_css($render_slug){


        $image_width = $this->dipi_get_responsive_prop('image_width');
        $image_min_width = $this->dipi_get_responsive_prop('image_min_width');
        $image_spacing = $this->dipi_get_responsive_prop('image_spacing');

		ET_Builder_Element::set_style($render_slug, array(
			'selector' => "%%order_class%% .dipi_price_list_image_wrapper",
			'declaration' => "width: {$image_width['desktop']}; min-width: {$image_min_width['desktop']};margin-right: {$image_spacing['desktop']};",
		));

		ET_Builder_Element::set_style($render_slug, array(
			'selector' => "%%order_class%% .dipi_price_list_image_wrapper",
			'declaration' => "width: {$image_width['tablet']}; min-width: {$image_min_width['tablet']}; margin-right: {$image_spacing['tablet']};",
			'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
		));

		ET_Builder_Element::set_style($render_slug, array(
			'selector' => "%%order_class%% .dipi_price_list_image_wrapper",
			'declaration' => "width: {$image_width['phone']}; min-width: {$image_min_width['phone']}; margin-right: {$image_spacing['phone']};",
			'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
		));
	}
}

new DIPI_PriceList;
