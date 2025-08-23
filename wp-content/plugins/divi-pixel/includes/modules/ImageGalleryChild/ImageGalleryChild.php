<?php

class DIPI_ImageGalleryChild extends DIPI_Builder_Module
{
    public function init()
    {
        $this->name = esc_html__('Gallery Item', 'dipi-divi-pixel');
        $this->plural = esc_html__('Pixel Gallery Items', 'dipi-divi-pixel');
        $this->slug = 'dipi_image_gallery_child';
        $this->vb_support = 'on';
        $this->type = 'child';
        $this->child_title_var = 'label';
        $this->advanced_setting_title_text = esc_html__('New Item', 'dipi-divi-pixel');
        $this->settings_text = esc_html__('Item Settings', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%';

    }
    public function get_settings_modal_toggles()
    {
        return [
            'general' => [
                'toggles' => [
                    'main_content' => esc_html__('Slide Image', 'dipi-divi-pixel'),
                    'thumb_content' => esc_html__('Thumb Image', 'dipi-divi-pixel'),
                    'overlay_content' => esc_html__('Content', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'content_text' => [
                        'sub_toggles' => [
                            'title' => [
                                'name' => 'Title',
                            ],
                            'body' => [
                                'name' => 'Body',
                            ],
                        ],
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__('Content Text', 'dipi-divi-pixel'),
                    ],
                    'header' => [
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
                    ],
                    'content_sizing' => ['title' => esc_html__('Content Sizing & Spacing', 'dipi-divi-pixel')],
                    'image_overlay' => ['title' => esc_html__('Image Overlay', 'dipi-divi-pixel')],
                ],
            ],
        ];
    }
    public function get_advanced_fields_config()
    {
        $advanced_fields = [];
        $advanced_fields['margin_padding'] = false;
        $advanced_fields['link_options'] = false;
        $advanced_fields['max_width'] = false;
        $advanced_fields['fonts'] = [];
        $advanced_fields['text'] = [
            'use_background_layout' => true,
            'options' => [
                'background_layout' => [
                    'default' => 'light',
                    'default_on_front' => 'light',
                ],
                'text_orientation' => [
                    'default' => 'center',
                    'default_on_front' => 'center',
                ],
            ],
            'css' => [
                'text_orientation' => "%%order_class%% .dipi-ig-main-content .dipi-ig-animation-container",
                'important' => 'all',
            ],
        ];
        $advanced_fields['fonts']['header'] = [
            'label' => esc_html__('Content Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-ig-main-content--title *",
                'important' => 'all',
            ],
            'header_level' => [
                'default' => 'h3',
            ],
            'toggle_slug' => 'content_text',
            'sub_toggle' => 'title',
        ];

        $advanced_fields['fonts']['body'] = [
            'label' => esc_html__('Content Body', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-ig-main-content--description",
                'color' => "%%order_class%% .dipi-ig-main-content--description *, %%order_class%% .dipi-ig-main-content--description",
                'line_height' => "%%order_class%% .dipi-ig-main-content--description p",
                'important' => 'all',
            ],
            'toggle_slug' => 'content_text',
            'sub_toggle' => 'body',
        ];
        $advanced_fields["fonts"]["header_1"] = [
            'label' => esc_html__('Heading', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%% .dipi-ig-main-content--description h1",
            ),
            'font_size' => array(
                'default' => absint(et_get_option('body_header_size', '30')) . 'px',
            ),
            'toggle_slug' => 'header',
            'sub_toggle' => 'h1',
        ];
        $advanced_fields["fonts"]["header_2"] = [
            'label' => esc_html__('Heading 2', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%% .dipi-ig-main-content--description h2",
            ),
            'font_size' => array(
                'default' => '26px',
            ),
            'line_height' => array(
                'default' => '1em',
            ),
            'toggle_slug' => 'header',
            'sub_toggle' => 'h2',
        ];
        $advanced_fields["fonts"]["header_3"] = [
            'label' => esc_html__('Heading 3', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%% .dipi-ig-main-content--description h3",
            ),
            'font_size' => array(
                'default' => '22px',
            ),
            'line_height' => array(
                'default' => '1em',
            ),
            'toggle_slug' => 'header',
            'sub_toggle' => 'h3',
        ];
        $advanced_fields["fonts"]["header_4"] = [
            'label' => esc_html__('Heading 4', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%% .dipi-ig-main-content--description h4",
            ),
            'font_size' => array(
                'default' => '18px',
            ),
            'line_height' => array(
                'default' => '1em',
            ),
            'toggle_slug' => 'header',
            'sub_toggle' => 'h4',
        ];
        $advanced_fields["fonts"]["header_5"] = [
            'label' => esc_html__('Heading 5', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%% .dipi-ig-main-content--description h5",
            ),
            'font_size' => array(
                'default' => '16px',
            ),
            'line_height' => array(
                'default' => '1em',
            ),
            'toggle_slug' => 'header',
            'sub_toggle' => 'h5',
        ];
        $advanced_fields["fonts"]["header_6"] = [
            'label' => esc_html__('Heading 6', 'dipi-divi-pixel'),
            'css' => array(
                'main' => "%%order_class%% .dipi-ig-main-content--description h6",
            ),
            'font_size' => array(
                'default' => '14px',
            ),
            'line_height' => array(
                'default' => '1em',
            ),
            'toggle_slug' => 'header',
            'sub_toggle' => 'h6',
        ];
        $advanced_fields['transform'] = false;
        $advanced_fields['background'] = false;
        // $advanced_fields['background'] = [
        //     'css' => [
        //         'main' => "{$this->main_css_element} .dipi-ig-overlay",
        //         'important' => true
        //     ]
        // ];

        $advanced_fields['button']["content_button"] = [
            'label' => esc_html__('Content Button', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-ig-button",
                'important' => true,
            ],
            'use_alignment' => false,
            'box_shadow' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-ig-button",
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-ig-button.et_pb_button",
                    'important' => 'all',
                ],
            ],
        ];

        return $advanced_fields;
    }
    public function get_fields()
    {
        $fields = [];
        $fields['item_image'] = [
            'type' => 'upload',
            'dynamic_content' => 'image',
            'hide_metadata' => true,
            'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'description' => esc_html__('Upload an image to display in the module.', 'dipi-divi-pixel'),
            'toggle_slug' => 'main_content',
        ];
        $fields["img_alt"] = [
            'label' => esc_html__('Image Alt Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'description' => esc_html__('Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
            'toggle_slug' => 'main_content',
        ];
        $fields['main_bg_placement'] = [
            'label' => esc_html__('Main Image Position', 'dipi-divi-pixel'),
            'description' => esc_html__('Choose thumbnails alignment', 'dipi-divi-pixel'),
            'type' => 'select',
            'mobile_options' => true,
            'responsive' => true,
            'toggle_slug' => 'main_content',
            'default' => 'center center',
            'options' => [
                'top left' => esc_html__('Top Left', 'dipi-divi-pixel'),
                'top center' => esc_html__('Top Center', 'dipi-divi-pixel'),
                'top right' => esc_html__('Top Right', 'dipi-divi-pixel'),
                'center center' => esc_html__('Center Center', 'dipi-divi-pixel'),
                'bottom left' => esc_html__('Bottom Left', 'dipi-divi-pixel'),
                'bottom center' => esc_html__('Bottom Center', 'dipi-divi-pixel'),
                'bottom right' => esc_html__('Bottom Right', 'dipi-divi-pixel'),
            ],
        ];

        $fields['use_thumb_image'] = [
            'label' => esc_html__('Use Custom Thumbnail Image', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'thumb_content',
            'default' => 'off',
        ];
        $fields['item_thumb_image'] = [
            'type' => 'upload',
            'dynamic_content' => 'image',
            'hide_metadata' => true,
            'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'description' => esc_html__('Upload an image to display in the module.', 'dipi-divi-pixel'),
            'toggle_slug' => 'thumb_content',
            'show_if' => ['use_thumb_image' => 'on'],
        ];

        $fields["thumb_img_alt"] = [
            'label' => esc_html__('Thumb Image Alt Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'description' => esc_html__('Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
            'toggle_slug' => 'thumb_content',
            'show_if' => ['use_thumb_image' => 'on'],
        ];

        $fields["label"] = [
            'label' => esc_html__('Admin Label', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'admin_label',
        ];

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

        $fields['main_carousel_show_content'] = [
            'label' => esc_html__('Show Content', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'overlay_content',
            'default' => 'off',
        ];
        $fields["image_title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'overlay_content',
            'show_if' => ['main_carousel_show_content' => 'on'],
        ];
        $fields["image_description"] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'type' => 'tiny_mce',
            'option_category' => 'basic_option',
			'dynamic_content' => 'text',
            'toggle_slug' => 'overlay_content',
            'show_if' => ['main_carousel_show_content' => 'on'],
        ];

        $fields["c_hz_placement"] = [
            'label' => esc_html__('Content Horizontal Placement', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'center',
            'mobile_options' => true,
            'responsive' => true,
            'options' => [
                'right' => esc_html__('Right', 'dipi-divi-pixel'),
                'left' => esc_html__('Left', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
            ],
            'tab_slug' => 'general',
            'toggle_slug' => 'overlay_content',
            'show_if' => ['main_carousel_show_content' => 'on'],
        ];

        $fields["c_vr_placement"] = [
            'label' => esc_html__('Content Vertical Placement', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'center',
            'mobile_options' => true,
            'responsive' => true,
            'options' => [
                'top' => esc_html__('Top', 'dipi-divi-pixel'),
                'bottom' => esc_html__('Bottom', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'overlay_content',
            'show_if' => ['main_carousel_show_content' => 'on'],
        ];

        $fields['use_button'] = [
            'label' => esc_html__('Show Button', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'overlay_content',
            'show_if' => ['main_carousel_show_content' => 'on'],
        ];

        $fields["button_text"] = [
            'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => esc_html__('Click Here', 'dipi-divi-pixel'),
            'option_category' => 'basic_option',
            'toggle_slug' => 'overlay_content',
            'show_if' => ['use_button' => 'on'],
        ];

        $fields["button_link"] = [
            'label' => esc_html__('Button Link', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => '#',
            'option_category' => 'basic_option',
            'toggle_slug' => 'overlay_content',
            'show_if' => ['use_button' => 'on'],
        ];

        $fields["button_link_target"] = [
            'label' => esc_html__('Button Link Target', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'layout',
            'default' => 'same_window',
            'default_on_child' => true,
            'options' => [
                'off' => esc_html__('Same Window', 'dipi-divi-pixel'),
                'on' => esc_html__('New Window', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'overlay_content',
            'show_if' => ['use_button' => 'on'],
        ];

        $fields['show_content_overlay'] = [
            'label' => esc_html__('Show Overlay', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'overlay_content',
            'default' => 'off',
        ];
        $fields['use_content_animation'] = [
            'label' => esc_html__('Use Content Animation', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'overlay_content',
            'show_if' => ['main_carousel_show_content' => 'on'],
        ];

        $fields["content_animation"] = [
            'label' => esc_html__('Content Animations', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'fadeIn',
            'options' => [
                'fadeIn' => esc_html__('Fade In', 'dipi-divi-pixel'),
                'fadeInLeftShort' => esc_html__('FadeIn Left', 'dipi-divi-pixel'),
                'fadeInRightShort' => esc_html__('FadeIn Right', 'dipi-divi-pixel'),
                'fadeInUpShort' => esc_html__('FadeIn Up', 'dipi-divi-pixel'),
                'fadeInDownShort' => esc_html__('FadeIn Down', 'dipi-divi-pixel'),
                'zoomInShort' => esc_html__('Grow', 'dipi-divi-pixel'),
                'bounceInShort' => esc_html__('BounceIn', 'dipi-divi-pixel'),
                'bounceInLeftShort' => esc_html__('BounceIn Left', 'dipi-divi-pixel'),
                'bounceInRightShort' => esc_html__('BounceIn Right', 'dipi-divi-pixel'),
                'bounceInUpShort' => esc_html__('BounceIn Up', 'dipi-divi-pixel'),
                'bounceInDownShort' => esc_html__('BounceIn Down', 'dipi-divi-pixel'),
                'flipInXShort' => esc_html__('FlipInX', 'dipi-divi-pixel'),
                'flipInYShort' => esc_html__('FlipInY', 'dipi-divi-pixel'),
                'jackInTheBoxShort' => esc_html__('JackInTheBox', 'dipi-divi-pixel'),
                'rotateInShort' => esc_html__('RotateIn', 'dipi-divi-pixel'),
                'rotateInDownLeftShort' => esc_html__('RotateIn DownLeft', 'dipi-divi-pixel'),
                'rotateInUpLeftShort' => esc_html__('RotateIn UpLeft', 'dipi-divi-pixel'),
                'rotateInDownRightShort' => esc_html__('RotateIn DownRight', 'dipi-divi-pixel'),
                'rotateInUpRightShort' => esc_html__('RotateIn UpRight', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'overlay_content',
            'show_if' => ['use_content_animation' => 'on'],
        ];

        $fields['content_container_padding'] = [
            'label' => esc_html__('Content Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '20px|40px|20px|40px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_sizing',
        ];
        $fields["content_width"] = [
            'label' => esc_html__('Content Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '1000px',
            'default_unit' => 'px',
            'default_on_front' => '1000px',
            'allowed_units' => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
            'range_settings' => [
                'min' => '1',
                'max' => '1200',
                'step' => '1',
            ],
            'mobile_options' => true,
            'responsive' => true,
            'validate_unit' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_sizing',
        ];
        $fields["content_max_width"] = [
            'label' => esc_html__('Content Max Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '100%',
            'default_unit' => '%',
            'default_on_front' => '100%',
            'allowed_units' => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
            'range_settings' => [
                'min' => '1',
                'max' => '100',
                'step' => '1',
            ],
            'mobile_options' => true,
            'responsive' => true,
            'validate_unit' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_sizing',
        ];

        $fields['overlay_bg_color'] = [
            'label' => esc_html__('Overlay', 'dipi-divi-pixel'),
            'type' => 'background-field',
            'base_name' => "overlay_bg",
            'context' => "overlay_bg",
            'custom_color' => true,
            'default' => ET_Global_Settings::get_value('all_buttons_bg_color'),
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => "image_overlay",
            'background_fields' => array_merge(
                ET_Builder_Element::generate_background_options(
                    'overlay_bg',
                    'gradient',
                    "advanced",
                    "overlay",
                    "overlay_bg_gradient"
                ),
                ET_Builder_Element::generate_background_options(
                    "overlay_bg",
                    "color",
                    "advanced",
                    "overlay",
                    "overlay_bg_color"
                )
            ),
        ];

        $fields = array_merge(
            $fields,
            $this->generate_background_options(
                "overlay_bg",
                'skip',
                "advanced",
                "image_overlay",
                "overlay_bg_gradient"
            )
        );

        $fields = array_merge(
            $fields,
            $this->generate_background_options(
                "overlay_bg",
                'skip',
                "advanced",
                "image_overlay",
                "overlay_bg_color"
            )
        );
        return $fields;
    }

    public function get_custom_css_fields_config()
    {
        $fields = [];
        $fields['content_container'] = [
            'label' => esc_html__('Content Container Style', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-ig-main-content',
        ];
        $fields['content_title'] = [
            'label' => esc_html__('Content Title Style', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-ig-main-content--title *',
        ];
        $fields['content_body'] = [
            'label' => esc_html__('Content Body Style', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-ig-main-content--description *',
        ];
        return $fields;
    }

    public function apply_css($render_slug)
    {
        $content_selector = $this->main_css_element . ' .dipi-ig-main-content';

        if ($this->props['main_carousel_show_content'] === 'on') {
            $content_position_styles = [
                'top-left' => 'top:0;bottom:auto;left:0;right:auto;transform:none;',
                'center-left' => 'top:50%;transform: translateY(-50%);left:0;right:auto;',
                'bottom-left' => 'top:auto;bottom:0;left:0;right:auto;transform:none;',
                'top-center' => 'top:0;bottom:auto;left:50%;transform: translateX(-50%);',
                'center-center' => 'top:50%;left:50%;transform: translate(-50%, -50%);',
                'bottom-center' => 'top:auto;bottom:0;left:50%;transform: translateX(-50%);',
                'top-right' => 'top:0;bottom:auto;left:auto;right:0;transform:none;',
                'center-right' => 'top:50%;transform: translateY(-50%);left:auto;right:0;',
                'bottom-right' => 'top:auto;bottom:0;left:auto;right:0;transform:none;',
            ];

            $rs_c_hz_placement = $this->dipi_get_responsive_prop('c_hz_placement', 'center');
            $rs_c_vr_placement = $this->dipi_get_responsive_prop('c_vr_placement', 'center');
            $rs_c_placement = [
                'desktop' => $rs_c_vr_placement['desktop'] . '-' . $rs_c_hz_placement['desktop'],
                'tablet' => $rs_c_vr_placement['tablet'] . '-' . $rs_c_hz_placement['tablet'],
                'phone' => $rs_c_vr_placement['phone'] . '-' . $rs_c_hz_placement['phone'],
            ];

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $content_selector,
                'declaration' => $content_position_styles[$rs_c_placement['desktop']],
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $content_selector,
                'declaration' => $content_position_styles[$rs_c_placement['tablet']],
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $content_selector,
                'declaration' => $content_position_styles[$rs_c_placement['phone']],
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

            $content_selector_active_slide = $this->main_css_element . '.swiper-slide-active .dipi-ig-main-content';
            $content_position_styles_active_slide = [
                'top-left' => 'top:0; bottom:auto;left:0;right:auto;transform:translateZ(10px);',
                'center-left' => 'top:50%;transform: translateY(-50%) translateZ(10px);left:0;right:auto;',
                'bottom-left' => 'top:auto;bottom:0;left:0;right:auto;transform:translateZ(10px);',
                'top-center' => 'top:0;bottom:auto;left:50%;transform: translateX(-50%) translateZ(10px);',
                'center-center' => 'top:50%;left:50%;transform: translate(-50%, -50%) translateZ(10px);',
                'bottom-center' => 'top:auto;bottom:0;left:50%;transform: translateX(-50%) translateZ(10px);',
                'top-right' => 'top:0;bottom:auto;left:auto;right:0;transform:translateZ(10px);',
                'center-right' => 'top:50%;transform: translateY(-50%) translateZ(10px);left:auto;right:0;',
                'bottom-right' => 'top:auto;bottom:0;left:auto;right:0;transform:translateZ(10px);',
            ];

            $rs_c_hz_placement = $this->dipi_get_responsive_prop('c_hz_placement', 'center');
            $rs_c_vr_placement = $this->dipi_get_responsive_prop('c_vr_placement', 'center');
            $rs_c_placement = [
                'desktop' => $rs_c_vr_placement['desktop'] . '-' . $rs_c_hz_placement['desktop'],
                'tablet' => $rs_c_vr_placement['tablet'] . '-' . $rs_c_hz_placement['tablet'],
                'phone' => $rs_c_vr_placement['phone'] . '-' . $rs_c_hz_placement['phone'],
            ];

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $content_selector_active_slide,
                'declaration' => $content_position_styles_active_slide[$rs_c_placement['desktop']],
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $content_selector_active_slide,
                'declaration' => $content_position_styles_active_slide[$rs_c_placement['tablet']],
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $content_selector_active_slide,
                'declaration' => $content_position_styles_active_slide[$rs_c_placement['phone']],
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        $content_button_text_size = $this->props['content_button_text_size'];
        if (empty($content_button_text_size)) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-ig-button',
                'declaration' => 'font-size: 16px !important;',
            ));
        }

        $responsive_content_width = $this->dipi_get_responsive_prop('content_width');
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $content_selector,
            'declaration' => sprintf('width: %1$s;', $responsive_content_width['desktop']),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $content_selector,
            'declaration' => sprintf('width: %1$s;', $responsive_content_width['tablet']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $content_selector,
            'declaration' => sprintf('width: %1$s;', $responsive_content_width['phone']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));

        $responsive_max_content_width = $this->dipi_get_responsive_prop('content_max_width');
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $content_selector,
            'declaration' => sprintf('max-width: %1$s;', $responsive_max_content_width['desktop']),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $content_selector,
            'declaration' => sprintf('max-width: %1$s;', $responsive_max_content_width['tablet']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $content_selector,
            'declaration' => sprintf('max-width: %1$s;', $responsive_max_content_width['phone']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));

        $image_selector = $this->main_css_element . ' .swiper-slide-container';
        $rs_main_bg_placement = $this->dipi_get_responsive_prop('main_bg_placement');
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $image_selector,
            'declaration' => sprintf('background-position: %1$s;', $rs_main_bg_placement['desktop']),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $image_selector,
            'declaration' => sprintf('background-position: %1$s;', $rs_main_bg_placement['tablet']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $image_selector,
            'declaration' => sprintf('background-position: %1$s;', $rs_main_bg_placement['phone']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));

        $responsive_text_orientation = $this->dipi_get_responsive_prop('text_orientation');
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $content_selector,
            'declaration' => sprintf('text-align: %1$s !important;', $responsive_text_orientation['desktop']),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $content_selector,
            'declaration' => sprintf('text-align: %1$s !important;', $responsive_text_orientation['tablet']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $content_selector,
            'declaration' => sprintf('text-align: %1$s !important;', $responsive_text_orientation['phone']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));

        $responsive_content_padding = $this->dipi_get_responsive_prop('content_container_padding');
        $content_padding = explode('|', $responsive_content_padding['desktop']);
        $content_padding_tablet = explode('|', $responsive_content_padding['tablet']);
        $content_padding_phone = explode('|', $responsive_content_padding['phone']);

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $content_selector,
            'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $content_padding[0], $content_padding[1], $content_padding[2], $content_padding[3]),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $content_selector,
            'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $content_padding_tablet[0], $content_padding_tablet[1], $content_padding_tablet[2], $content_padding_tablet[3]),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $content_selector,
            'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $content_padding_phone[0], $content_padding_phone[1], $content_padding_phone[2], $content_padding_phone[3]),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));
        if ($this->props['show_content_overlay'] === 'on') {
            $this->set_background_css($render_slug, "%%order_class%% .dipi-ig-overlay", "%%order_class%%:hover .dipi-ig-overlay", 'overlay_bg', 'overlay_bg_color');
        }

    }

    public function render($attrs, $content, $render_slug)
    {
        $multi_view = et_pb_multi_view_options( $this );
        global $dipi_image_slider_thumbs;
        // extract($this->props);
        $use_thumb_image = $this->props['use_thumb_image'];
        $header_level = (isset($this->props['header_level']) && !empty($this->props['header_level'])) ? $this->props['header_level'] : 'h3' ;
        $use_content_animation = $this->props['use_content_animation'];
        $content_animation = $this->props['content_animation'];
        $image_title = $this->props['image_title'];
        $use_button  = $this->props['use_button'];
        $main_carousel_show_content  = $this->props['main_carousel_show_content'];
        $show_content_overlay   = $this->props['show_content_overlay'];
        $item_image = $this->props['item_image'];
        $item_thumb_image = $this->props['item_thumb_image'];
        
        $slider_child = [];
        if(isset( $use_thumb_image) &&  $use_thumb_image === 'on'){
            $slider_child['url'] = $item_thumb_image;
        }else{
            $slider_child['url'] = $item_image;
        }
        $slider_child['alt'] = isset($tthumb_img_alt)? $thumb_img_alt: '';
        $slider_child['size'] =  'cover';
        $dipi_image_slider_thumbs[] = $slider_child;

        $this->add_classname(['swiper-slide']);
        $this->apply_css($render_slug);
        $image_src = $this->props['item_image'];
        $image_alt = $this->props['img_alt'] ? sprintf('aria-labelledby="%1$s"', $this->props['img_alt']) : '';

        $content_button = '';
        if ('on' === $use_button) {
            $content_button_rel = $this->props['content_button_rel'];
            $content_button_text = $this->props['button_text'];
            $content_button_link = $this->props['button_link'];
            $content_button_icon = $this->props['content_button_icon'];
            $content_button_target = $this->props['button_link_target'];
            $content_button_custom = $this->props['custom_content_button'];

            $content_button = $this->render_button([
                'button_classname' => [" dipi-ig-button"],
                'button_custom' => $content_button_custom,
                'button_rel' => $content_button_rel,
                'button_text' => $content_button_text,
                'button_url' => $content_button_link,
                'custom_icon' => $content_button_icon,
                'has_wrapper' => false,
                'url_new_window' => $content_button_target,
            ]);
        }

        $slide_content = '';
        
        $animation = '';
        $animation_class = '';
        if ($use_content_animation === 'on') {
            $animation_class = ' dipi-animated';
            $animation = sprintf('data-animation="%s"', $content_animation);
        }
        
        $content = $multi_view->render_element(
			array(
				'tag'     => 'div',
				'content' => '{{image_description}}'
			)
		);
        if ($main_carousel_show_content === 'on') {
            $text_orientation_classname = $this->get_text_orientation_classname();
            $background_layout_class_names = et_pb_background_layout_options()->get_background_layout_class($this->props);
            $background_layout_class_names = " " . implode(" ", $background_layout_class_names);
            $data_background_layout = et_pb_background_layout_options()->get_background_layout_attrs($this->props);
            $slide_content = sprintf('<div class="dipi-ig-main-content">
                <div class="dipi-ig-animation-container %5$s %7$s%8$s%9$s" %6$s>
                    <div class="dipi-ig-main-content--title"><%3$s>%1$s</%3$s></div>
                    <div class="dipi-ig-main-content--description">%2$s</div>
                    %4$s
                </div>
            </div>',
                $image_title,
                $content,
                $header_level,
                $content_button,
                $animation_class, // #5
                $animation,
                $background_layout_class_names,
                et_core_esc_previously($data_background_layout),
                $text_orientation_classname
            );
        }

        $overlay = '';
        if ($show_content_overlay === 'on') {
            $overlay = '<div class="dipi-ig-overlay"></div>';
        }
        $image_render = sprintf(
            '<div href="%1$s" class="swiper-slide-container %4$s" role="figure" %2$s style="background-image:url(%1$s);background-size:cover;background-repeat: no-repeat;">
                %3$s
                %5$s
            </div>',
            esc_attr($image_src),
            $image_alt,
            $slide_content,
            '',
            $overlay
        );
        return $image_render;
    }
    public function multi_view_filter_value( $raw_value, $args, $multi_view ) {
        $name = isset( $args['name'] ) ? $args['name'] : '';
        $raw_value = str_replace( array( '%22', '%92', '%91', '%93' ), array( '"', '\\', '&#91;', '&#93;' ), $raw_value );

			// Cleaning up invalid starting <\p> tag.
			$cleaned_value = preg_replace( '/(^<\/p>)(.*)/ius', '$2', $raw_value );

			// Cleaning up invalid ending <p> tag.
			$cleaned_value = preg_replace( '/(.*)(<p>$)/ius', '$1', $cleaned_value );

			// Override the raw value.
			if ( $raw_value !== $cleaned_value ) {
				$raw_value = trim( $cleaned_value, "\n" );

				if ( 'raw_content' !== $name ) {
					$raw_value = force_balance_tags( $raw_value );
				}
			}

			// Try to process shortcode.
			if ( false !== strpos( $raw_value, '&#91;' ) && false !== strpos( $raw_value, '&#93;' ) ) {
				$raw_value = do_shortcode( et_pb_fix_shortcodes( str_replace( array( '&#91;', '&#93;' ), array( '[', ']' ), $raw_value ), true ) );
			}
		return $raw_value;
	}
}

new DIPI_ImageGalleryChild;
