<?php

class DIPI_Balloon extends DIPI_Builder_Module
{
    protected $module_credits = [
        'module_uri' => 'https://divi-pixel.com/modules/balloon',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    ];

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->slug = 'dipi_balloon';
        $this->vb_support = 'on';
        $this->name = esc_html__('Pixel Balloon', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%.dipi_balloon';
    }

    public function get_settings_modal_toggles()
    {
        return [
            'general' => [
                'toggles' => [
                    'content' => esc_html__('Content Settings', 'dipi-divi-pixel'),
                    'balloon' => esc_html__('Balloon Settings', 'dipi-divi-pixel'),
                    'layout' => esc_html__('Layout Settings', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'balloon_styles' => esc_html__('Balloon Styles', 'dipi-divi-pixel'),
                    'balloon_image_icon' => esc_html__('Balloon Image/Icon', 'dipi-divi-pixel'),
                    'balloon_text' => [
                        'title' => esc_html__('Balloon Text', 'dipi-divi-pixel'),
                        'sub_toggles' => [
                            'title' => [
                                'name' => 'Title',
                            ],
                            'description' => [
                                'name' => 'Description',
                            ],
                        ],
                        'tabbed_subtoggles' => true,
                    ],
                ],
            ],
        ];
    }

    public function get_custom_css_fields_config()
    {

        $fields = [];

        
        $fields['main_element'] = [
            'label' => esc_html__('Main Element', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% + div[id^="tippy-"]',
        ];
        
        $fields['balloon_img'] = [
            'label' => esc_html__('Balloon Image', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-balloon-image',
        ];

        $fields['balloon_icon'] = [
            'label' => esc_html__('Balloon Icon', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-balloon-icon',
        ];

        $fields['title'] = [
            'label' => esc_html__('Balloon Title', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-balloon-title',
        ];

        $fields['description'] = [
            'label' => esc_html__('Balloon Desc', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-balloon-description',
        ];

        $fields['button'] = [
            'label' => esc_html__('Balloon Button', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-balloon-cta',
        ];

        return $fields;
    }

    public function get_fields()
    {
        $fields = [];

        $fields["selector"] = [
            'label' => esc_html__('Selector', 'dipi-divi-pixel'),
            'type' => 'text',
            'description' => esc_html__('E.g. ` #menu-item-0 or .menu-item-0 `', 'dipi-divi-pixel'),
            'toggle_slug' => 'content',
        ];

        $fields["ballon_placement"] = [
            'label' => esc_html__('Balloon Placement', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'top',
            'options' => [
                'top' => esc_html__('Top', 'dipi-divi-pixel'),
                'right' => esc_html__('Right', 'dipi-divi-pixel'),
                'bottom' => esc_html__('Bottom', 'dipi-divi-pixel'),
                'left' => esc_html__('Left', 'dipi-divi-pixel'),
                'auto' => esc_html__('Auto', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'content',
            'mobile_options' => true,
        ];

        $fields["ballon_animation"] = [
            'label' => esc_html__('Balloon Animations', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'fade',
            'options' => [
                'fade' => esc_html__('Fade In', 'dipi-divi-pixel'),
                'fadeInLeft' => esc_html__('Fade In Left', 'dipi-divi-pixel'),
                'fadeInRight' => esc_html__('Fade In Right', 'dipi-divi-pixel'),
                'fadeInUp' => esc_html__('Fade In Up', 'dipi-divi-pixel'),
                'fadeInDown' => esc_html__('Fade In Down', 'dipi-divi-pixel'),
                'scale' => esc_html__('Grow', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'content',
        ];

        $fields["content_type"] = [
            'label' => esc_html__('Content Type', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'manual',
            'options' => [
                'manual' => esc_html__('Manual', 'dipi-divi-pixel'),
                'library' => esc_html__(' Divi Library', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'content',
        ];

        $fields["content_alignment"] = [
            'label' => esc_html__('Content Alignment', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'center',
            'options' => [
                'left' => esc_html__('Left', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'right' => esc_html__('Right', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'content_type' => 'manual',
            ],
            'toggle_slug' => 'content',
        ];

        $fields["use_balloon_icon"] = [
            'label' => esc_html__('Use balloon Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'show_if' => [
                'content_type' => 'manual',
            ],
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'content',
        ];

        $fields["balloon_icon"] = [
            'label' => esc_html__('Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'default' => '1',
            'show_if' => [
                'content_type' => 'manual',
                'use_balloon_icon' => 'on',
            ],
            'toggle_slug' => 'content',
        ];

        $fields["icon_color"] = [
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'show_if' => [
                'use_balloon_icon' => 'on',
                'content_type' => 'manual',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'balloon_image_icon',
            'hover' => 'tabs',
        ];

        $fields["use_icon_circle"] = [
            'label' => esc_html__('Show as Circle Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'use_balloon_icon' => 'on',
                'content_type' => 'manual',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'balloon_image_icon',
        ];

        $fields["icon_circle_color"] = [
            'label' => esc_html__('Circle Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'validate_unit' => true,
            'show_if' => [
                'use_icon_circle' => 'on',
                'content_type' => 'manual',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'balloon_image_icon',
            'hover' => 'tabs',
        ];

        $fields["use_icon_circle_border"] = [
            'label' => esc_html__('Show Circle Border', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'use_icon_circle' => 'on',
                'content_type' => 'manual',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'balloon_image_icon',
        ];

        $fields["icon_circle_border_color"] = [
            'label' => esc_html__('Circle Border Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'validate_unit' => true,
            'show_if' => [
                'use_icon_circle' => 'on',
                'use_icon_circle_border' => 'on',
                'content_type' => 'manual',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'balloon_image_icon',
            'hover' => 'tabs',
        ];

        $fields["use_icon_size"] = [
            'label' => esc_html__('Use Icon Size', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'use_balloon_icon' => 'on',
                'content_type' => 'manual',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'balloon_image_icon',
        ];

        $fields["icon_size"] = [
            'label' => esc_html__('Icon Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '40px',
            'default_unit' => 'px',
            'default_on_front' => '40px',
            'allowed_units' => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
            'show_if' => [
                'use_icon_size' => 'on',
                'content_type' => 'manual',
            ],
            'range_settings' => [
                'min' => '1',
                'max' => '150',
                'step' => '1',
            ],
            'hover' => 'tabs',
            'validate_unit' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'balloon_image_icon',
        ];

        $fields['balloon_img'] = [
            'type' => 'upload',
            'hide_metadata' => true,
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'description' => esc_html__('Upload an image to display in the module.', 'dipi-divi-pixel'),
            'show_if' => [
                'use_balloon_icon' => 'off',
                'content_type' => 'manual',
            ],
            'toggle_slug' => 'content',
            'dynamic_content' => 'image'
        ];

        $fields["img_alt"] = [
            'label' => esc_html__('Image Alt Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'description' => esc_html__('Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
            'show_if' => [
                'use_balloon_icon' => 'off',
                'content_type' => 'manual',
            ],
            'toggle_slug' => 'content',
            'dynamic_content' => 'text'
        ];

        $fields["balloon_image_width"] = [
            'label' => esc_html__('Balloon Image Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'validate_unit' => true,
            'default' => '100px',
            'default_unit' => 'px',
            'allowed_units' => ['px'],
            'range_settings' => [
                'min' => '0',
                'max' => '1000',
                'step' => '10',
            ],
            'mobile_options' => true,
            'show_if' => [
                'use_balloon_icon' => 'off',
                'content_type' => 'manual',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'balloon_image_icon',
        ];

        $fields["balloon_title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'type' => 'text',
            'show_if' => [
                'content_type' => 'manual',
            ],
            'toggle_slug' => 'content',
            'dynamic_content' => 'text'
        ];

        $fields["balloon_description"] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'type' => 'tiny_mce',
            'show_if' => [
                'content_type' => 'manual',
            ],
            'toggle_slug' => 'content',
            'dynamic_content' => 'text'
        ];

        $fields["use_cta"] = [
            'label' => esc_html__('Show Button', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'content_type' => 'manual',
            ],
            'toggle_slug' => 'content',
        ];

        $fields["button_text"] = [
            'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
            'default' => esc_html__('Contact', 'dipi-divi-pixel'),
            'type' => 'text',
            'show_if' => [
                'use_cta' => 'on',
                'content_type' => 'manual',
            ],
            'toggle_slug' => 'content',
            'dynamic_content' => 'dynamic'
        ];

        $fields["button_link"] = [
            'label' => esc_html__('Button Link', 'dipi-divi-pixel'),
            'type' => 'text',
            'show_if' => [
                'use_cta' => 'on',
                'content_type' => 'manual',
            ],
            'toggle_slug' => 'content',
            'dynamic_content' => 'dynamic'
        ];

        $fields["button_target"] = [
            'label' => esc_html__('Link Target', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'same_window',
            'options' => [
                'same_window' => esc_html__('Same Window', 'dipi-divi-pixel'),
                'new_window' => esc_html__('New Window', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'use_cta' => 'on',
                'content_type' => 'manual',
            ],
            'toggle_slug' => 'content',
        ];

        $fields["divi_library"] = [
            'label' => esc_html__('Divi Library', 'dipi-divi-pixel'),
            'options' => $this->get_divi_layouts(),
            'type' => 'select',
            'show_if' => [
                'content_type' => 'library',
            ],
            'computed_affects' => [
                '__libraryShortcodeHtml',
            ],
            'toggle_slug' => 'content',
        ];
        $fields["interactive"] = [
            'label' => esc_html__('Interactive', 'dipi-divi-pixel'),
            'description' => esc_html__('Balloon can be interactive, allowing you to hover over and click inside them.', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'on',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'balloon',
        ];
        $fields["trigger_on_click"] = [
            'label' => esc_html__('Trigger on Click', 'dipi-divi-pixel'),
            'description' => esc_html__('Balloon can be interactive, allowing you to hover over and click inside them.', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'balloon',
        ];
        $fields["append_to"] = [
            'label' => esc_html__('Append To', 'dipi-divi-pixel'),
            'description' => esc_html__('The element to append the balloon to. Balloon HTML will be add dynamically into this element.', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'parent',
            'options' => [
                'parent' => esc_html__('Parent of Selector', 'dipi-divi-pixel'),
                'element' => esc_html__('Selector', 'dipi-divi-pixel'),
                'body' => esc_html__('Body', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'balloon',
        ];

        $fields['use_balloon_arrow'] = [
            'label' => esc_html__('Use Balloon Arrow', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'balloon',
        ];
        $fields['balloon_z_index'] = [
			'label'         => esc_html__('Z-index of Balloon Tooltip', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '9999',
            'unitless' => true,
            'range_settings' => [
                'min' => '0',
                'max' => '100000',
                'step' => '9999',
            ],
            'mobile_options' => true,
            'toggle_slug' => 'balloon',
		];

        $fields["balloon_arrow_color"] = [
            'label' => esc_html__('Balloon Arrow Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => '#000',
            'show_if' => ['use_balloon_arrow' => 'on'],
            'toggle_slug' => 'content',
        ];

        $fields["__libraryShortcodeHtml"] = [
            'type' => 'computed',
            'computed_callback' => ['DIPI_Balloon', 'get_divi_library_shortcode'],
            'computed_depends_on' => [
                'divi_library',
            ],
        ];

        $fields["width"] = [
            'label' => esc_html__('Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '550px',
            'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
            'default_unit' => 'px',
            'range_settings' => [
                'min' => '1',
                'max' => '1000',
                'step' => '1',
            ],
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'width',
        ];

        return $fields;
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = [];
        $advanced_fields["text"] = false;
        $advanced_fields["text_shadow"] = false;
        $advanced_fields["link_options"] = false;

        $advanced_fields["background"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-balloon-wrap",
            ],
        ];

        $advanced_fields["margin_padding"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-balloon-wrap",
            ],
        ];

        $advanced_fields["box_shadow"]["default"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-balloon-wrap",
            ],
        ];

        $advanced_fields["borders"]["default"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-balloon-wrap",
                    'border_styles' => "%%order_class%% .dipi-balloon-wrap",
                ],
            ],
        ];

        $advanced_fields["fonts"]["balloon_title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-balloon-title",
            ],
            'hide_text_align' => true,
            'toggle_slug' => 'balloon_text',
            'sub_toggle' => 'title',
            'header_level' => [
                'default' => 'h2',
            ],
            'line_height' => [
                'range_settings' => [
                    'min' => '1',
                    'max' => '3',
                    'step' => '.1',
                ],
            ],
            'depends_show_if' => 'manual',
            'depends_on' => ['content_type'],
        ];

        $advanced_fields["fonts"]["balloon_description"] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-balloon-description",
            ],
            'hide_text_align' => true,
            'toggle_slug' => 'balloon_text',
            'sub_toggle' => 'description',
            'line_height' => [
                'range_settings' => [
                    'min' => '1',
                    'max' => '3',
                    'step' => '.1',
                ],
            ],
            'important' => 'all',
            'depends_show_if' => 'manual',
            'depends_on' => ['content_type'],
        ];

        $advanced_fields['button']["button"] = [
            'label' => esc_html__('Button', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-balloon-cta",
                'important' => true,
            ],
            'use_alignment' => false,
            'margin_padding' => [
                'css' => [
                    'important' => 'all',
                ],
            ],
            'box_shadow' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-balloon-cta",
                    'important' => true,
                ],
            ],
            'show_if' => [
                'use_balloon_icon' => 'off',
                'content_type' => 'manual',
            ],
            'depends_show_if' => 'manual',
            'depends_on' => ['content_type'],
        ];

        $advanced_fields['borders']['balloon_img'] = [
            'label_prefix' => esc_html__('Balloon Image', 'dipi-divi-pixel'),
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-balloon-image",
                    'border_styles' => "%%order_class%% .dipi-balloon-image",
                ],
            ],
            'show_if' => [
                'use_balloon_icon' => 'off',
                'content_type' => 'manual',
            ],
            'depends_on' => ['content_type'],
            'depends_show_if' => 'manual',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'balloon_image_icon',
        ];

        $advanced_fields['box_shadow']['balloon_img'] = [
            'label' => esc_html__('Balloon Image', 'dipi-divi-pixel'),
            'css' => [
                'main' => '%%order_class%% .dipi-balloon-image',
                'overlay' => 'inset',
            ],
            'show_if' => [
                'use_balloon_icon' => 'off',
                'content_type' => 'manual',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'balloon_image_icon',
        ];

        $advanced_fields['max_width'] = [
            'use_width' => false,
            'use_max_width' => true,
            'use_module_alignment' => false,
        ];

        return $advanced_fields;
    }

    public static function get_divi_library_shortcode($args = [])
    {
        $id = isset($args['divi_library']) ? $args['divi_library'] : '';
        return DIPI_Builder_Module::render_library_layout($id);
    }

    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_balloon_public');


        // Props
        $content_type = $this->props['content_type'];
        $use_balloon_icon = $this->props['use_balloon_icon'];
        $balloon_icon = $this->props['balloon_icon'];
        $balloon_icon = et_pb_process_font_icon($balloon_icon);
        $balloon_img = $this->props['balloon_img'];
        $img_alt = $this->props['img_alt'];
        $balloon_title = $this->props['balloon_title'];
        $balloon_description = $this->props['balloon_description'];
        $divi_library = $this->props['divi_library'];
        $divi_library_shortcode = self::get_divi_library_shortcode(['divi_library' => $divi_library]); //FIXME: Can this cause duplicated css or other issues? Maybe here we shiould only do do_shortcode like in carousel nad imagehotspot
        $interactive = $this->props['interactive'] === 'on' ? 'true' : 'false';
        $trigger = $this->props['trigger_on_click'] === 'on' ? 'click' : 'mouseenter focus';
        $append_to = $this->props['append_to'];
        $use_balloon_arrow = $this->props['use_balloon_arrow'] === 'on' ? 'true' : 'false';
        $balloon_arrow_color = $this->props['balloon_arrow_color'];
        $order_class = self::get_module_order_class($render_slug);
        $is_in_tb_footer = (substr($order_class, -10) === "_tb_footer");
        $order_number = preg_replace('/[^0-9]/', '', $order_class);
        $content_alignment = $this->props['content_alignment'];
        $use_cta = $this->props['use_cta'];

        $width = $this->props['width'];
        $ballon_animation = $this->props['ballon_animation'];
        /* Check if Element is in header/body/footer */
        $layout_id   = ET_Builder_Element::get_layout_id();
        $layout_post = get_post( $layout_id );
        $order_number = "$layout_post->post_type-$order_number";

        $this->_apply_css($render_slug, $order_number);
        // Default animation
        if ($ballon_animation == 'fade') {
            $ballon_animation_animation = $ballon_animation;
        } else {
            $ballon_animation_animation = 'dipi-' . $ballon_animation;
        }

        // Custom animation
        $ballon_animation_class = '';
        if ($ballon_animation == 'fadeInLeft') {
            $ballon_animation_class = 'fadeInLeft';
        } elseif ($ballon_animation == 'fadeInRight') {
            $ballon_animation_class = 'fadeInRight';
        } elseif ($ballon_animation == 'fadeInUp') {
            $ballon_animation_class = 'fadeInUp';
        } elseif ($ballon_animation == 'fadeInDown') {
            $ballon_animation_class = 'fadeInDown';
        }

        // Icon & Image
        $balloon_icon_image = '';
        if ('on' === $use_balloon_icon) {
            $balloon_icon_image = sprintf('
                <div class="dipi-balloon-image-icon">
                    <div class="et-pb-icon dipi-balloon-icon">%1$s</div>
                </div>',
                esc_attr($balloon_icon)
            );
            $this->dipi_generate_font_icon_styles($render_slug, 'balloon_icon', '%%order_class%% .dipi-balloon-image-icon .et-pb-icon.dipi-balloon-icon');
        } else if ($balloon_img !== '') {
            $balloon_icon_image = sprintf('
                <div class="dipi-balloon-image-icon">
                    <img src="%1$s" class="dipi-balloon-image" alt="%2$s">
                </div>',
                $balloon_img,
                $img_alt
            );
        }

        // Balloon Title
        $title = '';
        $balloon_title_level = $this->props['balloon_title_level'];
        if ($balloon_title !== '') {
            $title = sprintf('
                <%2$s class="dipi-balloon-title">
                    %1$s
                </%2$s>',
                $balloon_title,
                esc_attr($balloon_title_level)
            );
        }

        // Balloon Description
        $description = '';
        if ($balloon_description !== '') {
            $description = sprintf('
                <div class="dipi-balloon-description"> %1$s </div>',
                $this->process_content($balloon_description)
            );
        }

        // Balloon CTA
        $button = '';
        if ('on' === $use_cta) {
            $button_text = $this->props['button_text'];
            $button_target = 'new_window' === $this->props['button_target'] ? 'on' : 'off';
            $button_icon = $this->props['button_icon'];
            $button_link = $this->props['button_link'];
            $button_rel = $this->props['button_rel'];

            $button = $this->render_button([
                'button_classname' => ["dipi-balloon-cta"],
                'button_rel' => $button_rel,
                'button_text' => $button_text,
                'button_url' => $button_link,
                'custom_icon' => $button_icon,
                'has_wrapper' => false,
                'url_new_window' => $button_target,
            ]);
        }
        if ('' !== $button) {
            $button = sprintf('
                <div class="dipi-balloon-cta-wrap">
                    %1$s
                </div>',
                $button
            );
        }

        /**
         * Custom settings
         */
        $selector = $this->props['selector'];
        $ballon_placement_last_edited = $this->props['ballon_placement_last_edited'];
        $ballon_placement_responsive_active = et_pb_get_responsive_status($ballon_placement_last_edited);
        $ballon_placement = ($this->props['ballon_placement']) ? $this->props['ballon_placement'] : '';
        $ballon_placement_tablet = ($ballon_placement_responsive_active && isset($this->props['ballon_placement_tablet']) && $this->props['ballon_placement_tablet'] !== '') ? $this->props['ballon_placement_tablet'] : $ballon_placement;
        $ballon_placement_phone = ($ballon_placement_responsive_active && isset($this->props['ballon_placement_phone']) && $this->props['ballon_placement_phone'] !== '') ? $this->props['ballon_placement_phone'] : $ballon_placement_tablet;

        // Outpur render
        $content = '';
        if ('manual' === $content_type) {
            $content = sprintf('
                <div class="%5$s">
                    <div class="dipi-balloon-wrap dipi-alignment-%6$s">
                        %1$s
                        %2$s
                        %3$s
                        %4$s
                    </div>
                </div>',
                $balloon_icon_image,
                $title,
                $description,
                $button,
                $this->module_classname($render_slug),
                $content_alignment
            );
        } else {
            $content = sprintf('
                <div class="%2$s">
                    <div class="dipi-balloon-wrap dipi-alignment-%3$s">
                        %1$s
                    </div>
                </div>
                ',
                $divi_library_shortcode,
                $this->module_classname($render_slug),
                $content_alignment
            );
        }

        $arrow_class = sprintf('.dipi-balloon-open-%1$s .tippy-arrow',
            $order_number
        );
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $arrow_class,
            'declaration' => sprintf('color: %1$s !important;', $balloon_arrow_color),
        ));

        $tippy_box_class = sprintf('.dipi-balloon-open-%1$s .tippy-box',
            $order_number
        );
 
        $this->generate_styles(
            array(
                'base_attr_name' => 'width',
                'selector'       => $tippy_box_class,
                'css_property'   => 'max-width',
                'render_slug'    => $render_slug,
                'type'           => 'range',
            )
        );




        // style="display: none;" will break image mask 
        $output = sprintf('
            <div class="dipi_balloon_inner" style="position:absolute;opacity:0;left:-99999px; top:-9999px;"
            
                data-order_number="%2$s"
                data-selector="%3$s"
                data-animation="%4$s"
                data-append_to="%5$s"
                data-ballon_placement_desktop="%6$s"
                data-ballon_placement_tablet="%7$s"
                data-ballon_placement_phone="%8$s"
                data-interactive="%9$s"
                data-trigger="%10$s"
                data-use_arrow="%11$s"
                data-is_in_tb_footer_class="%12$s"

            >
                <div class="et_pb_section dipi_balloon-inner">
                    %1$s
                </div>
            </div>',
            $content, #1
            esc_attr($order_number), #2
            esc_attr($selector), #3
            esc_attr($ballon_animation_animation), #4
            esc_attr($append_to), #5
            esc_attr($ballon_placement), #6
            esc_attr($ballon_placement_tablet), #7
            esc_attr($ballon_placement_phone), #8
            esc_attr($interactive),#9
            esc_attr($trigger), #10
            esc_attr($use_balloon_arrow), #11
            esc_attr($is_in_tb_footer ? 'et-l' : '') #12
        );

        return $output;

    }

    public function _apply_css($render_slug, $order_number)
    {
        $this->dipi_balloon_width_css($render_slug);
        $this->dipi_balloon_image_width_css($render_slug);
        $this->dipi_balloon_icon_css($render_slug);
        $this->dipi_balloon_z_index_css($render_slug, $order_number);
    }

    private function dipi_balloon_width_css($render_slug)
    {

        $width = $this->props['width'];
        $width_last_edited = $this->props['width_last_edited'];

        if (!isset($width) || '' === $width) {
            return;
        }

        $width_responsive_status = et_pb_get_responsive_status($width_last_edited);

        $width_tablet = $this->dipi_get_responsive_value(
            'width_tablet',
            $width,
            $width_responsive_status
        );

        $width_phone = $this->dipi_get_responsive_value(
            'width_phone',
            $width_tablet,
            $width_responsive_status
        );

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%%",
            'declaration' => sprintf('width: %1$s !important;', $width),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%%",
            'declaration' => sprintf('width: %1$s !important;', $width_tablet),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%%",
            'declaration' => sprintf('width: %1$s !important;', $width_phone),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));
    }
    private function dipi_balloon_z_index_css($render_slug, $order_number)
    {
        $balloon_z_index = $this->props['balloon_z_index'];
        $balloon_z_index_last_edited = $this->props['balloon_z_index_last_edited'];
        $balloon_tooltip_selector =".dipi-ballon-on-top.dipi-balloon-zindex-$order_number";
        if (!isset($balloon_z_index) || '' === $balloon_z_index) {
            return;
        }

        $balloon_z_index_responsive_status = et_pb_get_responsive_status($balloon_z_index_last_edited);

        $balloon_z_index_tablet = $this->dipi_get_responsive_value(
            'balloon_z_index_tablet',
            $balloon_z_index,
            $balloon_z_index_responsive_status
        );
	
        $balloon_z_index_phone = $this->dipi_get_responsive_value(
            'balloon_z_index_phone',
            $balloon_z_index_tablet,
            $balloon_z_index_responsive_status
        );

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => $balloon_tooltip_selector,
            'declaration' => sprintf('z-index: %1$s !important;', $balloon_z_index),
        ));
        if ($balloon_z_index_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $balloon_tooltip_selector,
                'declaration' => sprintf('z-index: %1$s !important;', $balloon_z_index_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $balloon_tooltip_selector,
                'declaration' => sprintf('z-index: %1$s !important;', $balloon_z_index_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }
    }
    private function dipi_balloon_image_width_css($render_slug)
    {

        $balloon_image_width = $this->props['balloon_image_width'];
        $balloon_image_width_last_edited = $this->props['balloon_image_width_last_edited'];

        if (!isset($balloon_image_width) || '' === $balloon_image_width) {
            return;
        }

        $balloon_image_width_responsive_status = et_pb_get_responsive_status($balloon_image_width_last_edited);

        $balloon_image_width_tablet = $this->dipi_get_responsive_value(
            'balloon_image_width_tablet',
            $balloon_image_width,
            $balloon_image_width_responsive_status
        );

        $balloon_image_width_phone = $this->dipi_get_responsive_value(
            'balloon_image_width_phone',
            $balloon_image_width_tablet,
            $balloon_image_width_responsive_status
        );

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-balloon-image",
            'declaration' => sprintf('width: %1$s !important;', $balloon_image_width),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-balloon-image",
            'declaration' => sprintf('width: %1$s !important;', $balloon_image_width_tablet),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-balloon-image",
            'declaration' => sprintf('width: %1$s !important;', $balloon_image_width_phone),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));
    }

    private function dipi_balloon_icon_css($render_slug)
    {

        $balloon_icon_color = $this->props['icon_color'];
        $balloon_icon_color_hover = $this->get_hover_value('icon_color');

        \ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-balloon-icon',
            'declaration' => "color: {$balloon_icon_color} !important;",
        ]);

        \ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-balloon-icon:hover',
            'declaration' => "color: {$balloon_icon_color_hover} !important;",
        ]);

        $use_balloon_icon_circle = $this->props['use_icon_circle'];
        $icon_circle_color = $this->props['icon_circle_color'];
        $icon_circle_color_hover = $this->get_hover_value('icon_circle_color');

        if ('on' == $use_balloon_icon_circle):

            \ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-balloon-icon',
                'declaration' => "padding: 25px; border-radius: 100%; background-color: {$icon_circle_color} !important;",
            ]);

            \ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-balloon-icon:hover',
                'declaration' => "background-color: {$icon_circle_color_hover} !important;",
            ]);

        endif;

        $use_icon_circle_border = $this->props['use_icon_circle_border'];
        $icon_circle_border_color = $this->props['icon_circle_border_color'];
        $icon_circle_border_color_hover = $this->get_hover_value('icon_circle_border_color');

        if ('on' === $use_icon_circle_border):

            \ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-balloon-icon',
                'declaration' => "border: 3px solid {$icon_circle_border_color};",
            ]);

            \ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-balloon-icon:hover',
                'declaration' => "border-color: {$icon_circle_border_color_hover};",
            ]);

        endif;

        $use_icon_size = $this->props['use_icon_size'];
        $icon_size = $this->props['icon_size'];
        $icon_size_hover = $this->get_hover_value('icon_size');

        if ('on' == $use_icon_size):

            \ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-balloon-icon',
                'declaration' => "font-size: {$icon_size} !important;",
            ]);

            if ('' === $icon_size_hover):

                \ET_Builder_Element::set_style($render_slug, [
                    'selector' => '%%order_class%% .dipi-balloon-icon:hover',
                    'declaration' => "font-size: {$icon_size_hover} !important;",
                ]);

            endif;

        endif;

    }
}

new DIPI_Balloon();
