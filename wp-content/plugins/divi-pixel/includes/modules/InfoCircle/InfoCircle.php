<?php
class DIPI_InfoCircle extends DIPI_Builder_Module
{

    public $slug = 'dipi_info_circle';
    public $vb_support = 'on';
    // Module item's slug
    public $child_slug = 'dipi_info_circle_item';
    protected $dipi_defaults = [
        'icon_color' => '#2C3D49',
        'icon_bg'    => '#F8F8F8',
        'icon_size' => '25px',
        'icon_padding' => '15px'
    ];
    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/info-circle',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function get_custom_css_fields_config() {
        $fields = [];
        $fields['image_icon_css'] = [
            'label'    => esc_html__('Image/Icon', 'dipi-divi-pixel'),
            'selector' => '%%order_class%%.dipi_info_circle .dipi_info_circle-small .dipi-info-image-icon-wrap .et-pb-icon',
        ];
        $fields['circle_heading'] = [
            'label'    => esc_html__('Title', 'dipi-divi-pixel'),
            'selector' => '%%order_class%%.dipi_info_circle .dipi-content-heading',
        ];
        $fields['circle_description'] = [
            'label'    => esc_html__('Description', 'dipi-divi-pixel'),
            'selector' => '%%order_class%%.dipi_info_circle .dipi-desc',
        ];
        $fields['circle_button'] = [
            'label'    => esc_html__('Button', 'dipi-divi-pixel'),
            'selector' => '%%order_class%%.dipi_info_circle .dipi_content_button',
        ];
        
        return $fields;
    }

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__('Pixel Info Circle', 'dipi-info-circle-module-for-divi');
        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'settings' => esc_html__('Settings', 'dipi-divi-pixel'),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'circle_list' => esc_html__('Circle & List', 'dipi-divi-pixel'),
                    'icon_settings' => esc_html__('Info Image & Icon', 'dipi-divi-pixel'),
                ),
            ),
        );
    }
    public function get_advanced_fields_config()
    {
        $advanced_fields = [];
        $advanced_fields["text"] = false;
        $advanced_fields["text_shadow"] = false;
        $advanced_fields["fonts"] = false;
        $icon_selector = '%%order_class%%.dipi_info_circle .dipi_info_circle-small .dipi-info-image-icon-wrap .et-pb-icon';
        $icon_hover_selector = '%%order_class%%.dipi_info_circle .dipi_info_circle-small:hover .dipi-info-image-icon-wrap .et-pb-icon';
        $image_icon_selector = '%%order_class%%.dipi_info_circle .dipi-info-circle.dipi_info_circle-small';
        $image_icon_hover_selector = '%%order_class%%.dipi_info_circle .dipi-info-circle.dipi_info_circle-small:hover';

        $image_icon_width_selector = '%%order_class%%.dipi_info_circle .dipi-info-image-icon-wrap.dipi-image-wrapper';
        $image_icon_hover_width_selector = '%%order_class%%.dipi_info_circle .dipi_info_circle-small:hover .dipi-info-image-icon-wrap.dipi-image-wrapper';

        $content_selector = '%%order_class%%.dipi_info_circle .dipi_info_circle-in';
        $this->advanced_fields['link_options'] = [
            'class' => '.dipi_info_circle-in',
        ];
        $advanced_fields["borders"]["default"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%%.dipi_info_circle ",
                    'border_styles' => "%%order_class%%.dipi_info_circle ",
                ],
            ],
        ];
        /* $advanced_fields["borders"]['circle'] = [
        'label_prefix' => esc_html__('Circle', 'dipi-divi-pixel'),
        'toggle_slug' => 'circle_list',
        'tab_slug' => 'advanced',
        'css' => [
        'main' => [
        'border_radii' => "",
        'border_styles' => "%%order_class%%.dipi_info_circle .dipi-info-circle-out, %%order_class%%.dipi_info_circle .dipi_info_circle_item_container",
        'border_styles_hover' => "%%order_class%%.dipi_info_circle:hover .dipi-info-circle-out, %%order_class%%.dipi_info_circle .dipi_info_circle_item_container:hover",
        ],
        ],
        ];*/
        $advanced_fields['borders']['image_icon'] = [
            'css' => [
                'main' => [
                    'border_radii' => $image_icon_selector,
                    'border_radii_hover' => $image_icon_hover_selector,
                    'border_styles' => $image_icon_selector,
                    'border_styles_hover' => $image_icon_hover_selector,
                ],
            ],
            'defaults' => [
                'border_radii' => 'on | 50% | 50% | 50% | 50%',
            ],
            'label_prefix' => et_builder_i18n('Image/Icon'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'icon_settings',
        ];
        $advanced_fields["background"] = [
            'css' => [
                'main' => '%%order_class%%.dipi_info_circle',
            ],
        ];

        $advanced_fields["box_shadow"]['default'] = [
            'css' => [
                'main' => '%%order_class%%.dipi_info_circle',
                'hover' => '%%order_class%%.dipi_info_circle:hover',
                'overlay' => 'inset',
            ],
        ];
        $advanced_fields["margin_padding"] = [
            'css' => [
                'main' => "%%order_class%%.dipi_info_circle",
                'important' => 'all',
            ],
        ];
        $advanced_fields["box_shadow"]['circle_list'] = [
            'label' => esc_html__('Circle/List Box Shadow', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'circle_list',
            'css' => [
                'main' => '%%order_class%%.dipi_info_circle .dipi-info-circle-out, %%order_class%%.dipi_info_circle .dipi_info_circle_item_container',
                'hover' => '%%order_class%%.dipi_info_circle:hover .dipi-info-circle-out, %%order_class%%.dipi_info_circle .dipi_info_circle_item_container:hover',
                'overlay' => 'inset',
            ],
            'default_on_fronts' => [
                'color' => '',
                'position' => '',
            ],
        ];
        $advanced_fields["box_shadow"]['image'] = [
            'label' => esc_html__('Image Box Shadow', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'icon_settings',
            'css' => [
                'main' => '%%order_class%%.dipi_info_circle .dipi-info-circle.dipi_info_circle-small',
                'hover' => '%%order_class%%.dipi_info_circle .dipi-info-circle.dipi_info_circle-small:hover',
                'overlay' => 'inset',
            ],
            'default_on_fronts' => [
                'color' => '',
                'position' => '',
            ],
        ];
        $advanced_fields["icon_settings"] = [/* Need this setting to apply filter */
            'css' => [
                'main' => '%%order_class%%.dipi_info_circle .dipi-info-circle.dipi_info_circle-small',
                'hover' => '%%order_class%%.dipi_info_circle .dipi-info-circle.dipi_info_circle-small:hover',
            ],
        ];
        $advanced_fields["filters"]['child_filters_target'] = [
            'tab_slug' => 'advanced',
            'toggle_slug' => 'icon_settings',
            'label' => esc_html__('Image/Icon', 'dipi-divi-pixel'),
            'css' => array(
                'main' => '%%order_class%%.dipi_info_circle .dipi-info-circle.dipi_info_circle-small',
                'hover' => '%%order_class%%.dipi_info_circle .dipi-info-circle.dipi_info_circle-small:hover',
            ),
        ];

        $advanced_fields["image_icon"]["image_icon"] = [
            'margin_padding' => [
                'custom_padding' => [
                    'default' => '15px|15px|15px|15px'
                ],
                'css' => [
                    'important' => 'all',
                ],
            ],
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'icon_settings',
            'label' => et_builder_i18n('Image/Icon'),
            'css' => [
                'main' => '%%order_class%%.dipi_info_circle .dipi-info-circle.dipi_info_circle-small',
                'hover' => '%%order_class%%.dipi_info_circle .dipi-info-circle.dipi_info_circle-small:hover',
            ],
        ];
        return $advanced_fields;
    }
    public function get_fields()
    {
        $et_accent_color = et_builder_accent_color();
        $fields = [];
        $fields['circle_list_size'] = [
            'label' => esc_html__('Circle/List Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '400px',
            'default_unit' => 'px',
            'default_on_front' => '400px',
            'allowed_units' => ['px'],
            'range_settings' => [
                'min' => '1',
                'max' => '2000',
                'step' => '1',
            ],
            'validate_unit' => true,
            'mobile_options' => true,
            'toggle_slug' => 'settings',
        ];
        $fields["icon_area_offset"] = [
            'label' => esc_html__('Icon Area offset', 'dipi-divi-pixel'),
            'type' => 'range',
            'validate_unit' => true,
            'default_unit' => 'px',
            'allowed_units' => ['px'],
            'range_settings' => [
                'min' => '-100',
                'max' => '100',
                'step' => '1',
            ],
            'mobile_options' => true,
            'toggle_slug' => 'settings',
        ];
        $fields["info_image_icon_animation"] = [
            'label' => esc_html__('Icon & Image Animation', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'on',
            'options' => [
                'off' => esc_html__('off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'settings',
        ];
        $fields['content_animation'] = [
            'label' => esc_html__('Content Animation Type', 'dipi-divi-pixel'),
            'type' => 'select',
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
            'default' => 'fadeIn',
            'toggle_slug' => 'settings',
        ];        
        $fields['start_angle'] = [
            'label' => esc_html__('Start Angle(deg)', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '0',
            'default_on_front' => '0',
            'range_settings' => [
                'min' => '0',
                'max' => '360',
                'step' => '1',
            ],
            'validate_unit' => true,
            'mobile_options' => true,
            'toggle_slug' => 'settings',
        ];
        $fields['select_event'] = [
            'label' => esc_html__('Select Event', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'hover',
            'options' => [
                'hover' => esc_html__('Hover', 'dipi-divi-pixel'),
                'click' => esc_html__('Click', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'settings',
        ];

        $fields["auto_mode"] = [
            'label' => esc_html__('Auto Mode', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'settings',
        ];
        $fields['auto_time'] = [
            'label' => esc_html__('Auto Time(ms)', 'dipi-divi-pixel'),
            'type' => 'range',
            'show_if' => [
                'auto_mode' => 'on',
            ],
            'default' => '3000',
            'default_on_front' => '3000',
            'default_unit' => '',
            'range_settings' => [
                'min' => '0',
                'max' => '10000',
                'step' => '100',
            ],
            'validate_unit' => true,
            'toggle_slug' => 'settings',
        ];
        $fields['auto_rotate_mode'] = [
            'label' => esc_html__('Auto Rotate Mode', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'layout',
            'options' => [
                'none' =>  esc_html__('None', 'dipi-divi-pixel'),
                'loop' =>  esc_html__('Loop', 'dipi-divi-pixel'),
                'repeat' =>  esc_html__('Repeat', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'settings',
            'show_if' => [
                'auto_mode' => 'on',
            ],
            'default' => 'loop',
        ];
        $fields['reverse_anim_direction'] = [
            'label' => esc_html__('Reverse Animation Direction', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'settings',
            'show_if' => [
                'auto_mode' => 'on',
             ],
             'show_if_not' => [
                'auto_rotate_mode' => 'none',
             ],
            'default_on_front' => 'on',
        ];
        $fields['auto_rotate_time'] = [
            'label' => esc_html__('Auto Rotate Time(ms)', 'dipi-divi-pixel'),
            'type' => 'range',
            'show_if' => [
                'auto_mode' => 'on',
            ],
            'show_if_not' => [
                'auto_rotate_mode' => 'none'
            ],
            'default' => '500',
            'default_on_front' => '500',
            'default_unit' => '',
            'range_settings' => [
                'min' => '0',
                'max' => '10000',
                'step' => '100',
            ],
            'validate_unit' => true,
            'toggle_slug' => 'settings',
        ];
        $fields['auto_rotate_angle'] = [
            'label' => esc_html__('Auto Rotate Angle(deg)', 'dipi-divi-pixel'),
            'type' => 'range',
            'show_if' => [
                'auto_mode' => 'on',
            ],
            'show_if_not' => [
                'auto_rotate_mode' => 'none'
            ],
            'default' => '30',
            'default_on_front' => '10',
            'range_settings' => [
                'min' => '0',
                'max' => '360',
                'step' => '1',
            ],
            'validate_unit' => true,
            'toggle_slug' => 'settings',
        ];
        $fields["show_as_list"] = [
            'label' => esc_html__('Show as list', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ],
            'mobile_options' => true,
            'toggle_slug' => 'settings',
        ];
        $fields['circle_list_border_width'] = [
            'label' => esc_html__('Circle & List Border Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'circle_list',
            'default' => '0px',
            'default_unit' => 'px',
            'default_on_front' => '0px',
            'allowed_units' => array('em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
            'range_settings' => array(
                'min' => '0',
                'max' => '50',
                'step' => '1',
            ),
            'sticky' => true,
            'mobile_options' => true,
            'hover' => 'tabs',
        ];
        $fields['circle_list_border_style'] = [
            'label' => esc_html__('Circle & List Border Style', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'layout',
            'options' => et_builder_get_border_styles(),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'circle_list',
            'default' => 'solid',
            'mobile_options' => true,
            'hover' => 'tabs',
        ];
        $fields['circle_list_border_color'] = [
            'default' => $et_accent_color,
            'label' => esc_html__('Circle & List Border Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'circle_list',
            'hover' => 'tabs',
            'mobile_options' => true,
            'sticky' => true,
        ];

        $fields['icon_color'] = [
            'default' => $this->dipi_defaults['icon_color'],
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'description' => esc_html__('Here you can define a custom color for your icon.', 'dipi-divi-pixel'),
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'icon_settings',
            'hover' => 'tabs',
            'mobile_options' => true,
            'sticky' => true,
        ];
        $fields['image_icon_background_color'] = [
            'label' => esc_html__('Image/Icon Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'default' => $this->dipi_defaults['icon_bg'],
            'description' => esc_html__('Here you can define a custom background color.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'icon_settings',
            'hover' => 'tabs',
            'mobile_options' => true,
            'sticky' => true,
        ];

        $fields['image_icon_width'] = [
            'label' => esc_html__('Image/Icon Size', 'dipi-divi-pixel'),
            'toggle_slug' => 'icon_settings',
            'description' => esc_html__('Here you can choose icon/img Size.', 'dipi-divi-pixel'),
            'type' => 'range',
            'range_settings' => [
                'min' => '1',
                'max' => '200',
                'step' => '1',
            ],
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'mobile_options' => true,
            'validate_unit' => true,
            'allowed_units' => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
            'responsive' => true,
            'mobile_options' => true,
            'sticky' => true,
            'default' => $this->dipi_defaults['icon_size']
        ];
        return $fields;
    }
    public function get_transition_fields_css_props()
    {
        $fields = parent::get_transition_fields_css_props();
        $fields['icon_color'] = array(
            'color' => '%%order_class%%.dipi_info_circle .dipi_info_circle-small .dipi-info-image-icon-wrap .et-pb-icon',
        );
        $fields['image_icon_background_color'] = array(
            'background-color' => '%%order_class%%.dipi_info_circle .dipi_info_circle-small',
        );

        $fields['image_icon_width'] = array(
            'font-size' => '%%order_class%%.dipi_info_circle .dipi_info_circle-small .dipi-info-image-icon-wrap .et-pb-icon',
            'width' => '%%order_class%%.dipi_info_circle .dipi_info_circle-small .dipi-info-image-icon-wrap img.dipi-info-image',
            'height' => '%%order_class%%.dipi_info_circle .dipi_info_circle-small .dipi-info-image-icon-wrap img.dipi-info-image',
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
        $slug_value_responsive_active = isset($this->props[$slug . "_last_edited"]) ? et_pb_get_responsive_status($this->props[$slug . "_last_edited"]) : false;
        $slug_value = (isset($this->props[$slug])) ? $this->props[$slug] : '';
        $slug_value_tablet = ($slug_value_responsive_active && isset($this->props[$slug . "_tablet"])) ? $this->props[$slug . "_tablet"] : $slug_value;
        $slug_value_phone = ($slug_value_responsive_active && isset($this->props[$slug . "_phone"])) ? $this->props[$slug . "_phone"] : $slug_value_tablet;

        if ($zoom === '') {
            $slug_value = $slug_value . $unit;
            $slug_value_tablet = $slug_value_tablet . $unit;
            $slug_value_phone = $slug_value_phone . $unit;
        } else {
            $slug_value = ((float) $slug_value * $zoom) . $unit;
            $slug_value_tablet = ((float) $slug_value_tablet * $zoom) . $unit;
            $slug_value_phone = ((float) $slug_value_phone * $zoom) . $unit;
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
        $slug_value_responsive_active = isset($this->props[$slug . "_last_edited"]) ? et_pb_get_responsive_status($this->props[$slug . "_last_edited"]) : false;
        $slug_value = (isset($this->props[$slug])) ? $this->props[$slug] : '';
        $slug_value_tablet = ($slug_value_responsive_active && isset($this->props[$slug . "_tablet"])) ? $this->props[$slug . "_tablet"] : $slug_value;
        $slug_value_phone = ($slug_value_responsive_active && isset($this->props[$slug . "_phone"])) ? $this->props[$slug . "_phone"] : $slug_value_tablet;

        if ($zoom === '') {
            $slug_value = $slug_value . $unit;
            $slug_value_tablet = $slug_value_tablet . $unit;
            $slug_value_phone = $slug_value_phone . $unit;
        } else {
            $slug_value = ((float) $slug_value * $zoom) . $unit;
            $slug_value_tablet = ((float) $slug_value_tablet * $zoom) . $unit;
            $slug_value_phone = ((float) $slug_value_phone * $zoom) . $unit;
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

        $slug_value_responsive_active = isset($this->props[$slug . "_last_edited"]) ? et_pb_get_responsive_status($this->props[$slug . "_last_edited"]) : false;
        $slug_value = (isset($this->props[$slug])) ? $this->props[$slug] : '';
        $slug_value_tablet = ($slug_value_responsive_active && isset($this->props[$slug . "_tablet"])) ? $this->props[$slug . "_tablet"] : $slug_value;
        $slug_value_phone = ($slug_value_responsive_active && isset($this->props[$slug . "_phone"])) ? $this->props[$slug . "_phone"] : $slug_value_tablet;

        if ($zoom === '') {
            $slug_value = $slug_value . $unit;
            $slug_value_tablet = $slug_value_tablet . $unit;
            $slug_value_phone = $slug_value_phone . $unit;
        } else {
            $slug_value = ((float) $slug_value * $zoom) . $unit;
            $slug_value_tablet = ((float) $slug_value_tablet * $zoom) . $unit;
            $slug_value_phone = ((float) $slug_value_phone * $zoom) . $unit;
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
        $unit = '',
        $wrap_func = '' /* traslate, clac ... */
    ) {
        $slug_value_responsive_active = isset($this->props[$slug . "_last_edited"]) ? et_pb_get_responsive_status($this->props[$slug . "_last_edited"]) : false;
        $slug_value = (isset($this->props[$slug])) ? $this->props[$slug] : '';
        $slug_value_tablet = ($slug_value_responsive_active && isset($this->props[$slug . "_tablet"])) ? $this->props[$slug . "_tablet"] : $slug_value;
        $slug_value_phone = ($slug_value_responsive_active && isset($this->props[$slug . "_phone"])) ? $this->props[$slug . "_phone"] : $slug_value_tablet;

        if ($zoom === '') {
            $slug_value = $slug_value . $unit;
            $slug_value_tablet = $slug_value_tablet . $unit;
            $slug_value_phone = $slug_value_phone . $unit;
        } else {
            $slug_value = ((float) $slug_value * $zoom) . $unit;
            $slug_value_tablet = ((float) $slug_value_tablet * $zoom) . $unit;
            $slug_value_phone = ((float) $slug_value_phone * $zoom) . $unit;
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
        $slug_value_responsive_active = isset($this->props[$slug . "_last_edited"]) ? et_pb_get_responsive_status($this->props[$slug . "_last_edited"]) : false;
        $slug_value = (isset($this->props[$slug])) ? $this->props[$slug] : '';
        $slug_value_tablet = ($slug_value_responsive_active && isset($this->props[$slug . "_tablet"])) ? $this->props[$slug . "_tablet"] : $slug_value;
        $slug_value_phone = ($slug_value_responsive_active && isset($this->props[$slug . "_phone"])) ? $this->props[$slug . "_phone"] : $slug_value_tablet;

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
    /**
     * Custom CSS
     */
    public function _dipi_apply_css($render_slug)
    {
        global $child_items_count;

        $circle_list_size = $this->props['circle_list_size'];
        $circle_list_size_values = et_pb_responsive_options()->get_property_values($this->props, 'circle_list_size');
        $circle_list_size_tablet = !empty($circle_list_size_values['tablet']) ? $circle_list_size_values['tablet'] : $circle_list_size;
        $circle_list_size_phone = !empty($circle_list_size_values['phone']) ? $circle_list_size_values['phone'] : $circle_list_size_tablet;

        $icon_area_offset = $this->props['icon_area_offset'];
        $icon_area_offset_values = et_pb_responsive_options()->get_property_values($this->props, 'icon_area_offset');
        $icon_area_offset_tablet = !empty($icon_area_offset_values['tablet']) ? $icon_area_offset_values['tablet'] : $icon_area_offset;
        $icon_area_offset_phone = !empty($icon_area_offset_values['phone']) ? $icon_area_offset_values['phone'] : $icon_area_offset_tablet;

        $start_angle = $this->props['start_angle'];
        $start_angle_values = et_pb_responsive_options()->get_property_values($this->props, 'start_angle');
        $start_angle_tablet = !empty($start_angle_values['tablet']) ? $start_angle_values['tablet'] : $start_angle;
        $start_angle_phone = !empty($start_angle_values['phone']) ? $start_angle_values['phone'] : $start_angle_tablet;

        $circle_list_outline_selector = '%%order_class%%.dipi_info_circle .dipi-info-circle-out, %%order_class%%.dipi_info_circle .dipi_info_circle_item_container';
        $circle_list_hover_outline_selector = '%%order_class%%.dipi_info_circle:hover .dipi-info-circle-out, %%order_class%%.dipi_info_circle .dipi_info_circle_item_container:hover';

        $icon_selector = '%%order_class%%.dipi_info_circle .dipi_info_circle-small .dipi-info-image-icon-wrap .et-pb-icon';
        $icon_hover_selector = '%%order_class%%.dipi_info_circle .dipi_info_circle-small:hover .dipi-info-image-icon-wrap .et-pb-icon';
        $image_icon_selector = '%%order_class%%.dipi_info_circle .dipi-info-circle.dipi_info_circle-small';
        $image_icon_hover_selector = '%%order_class%%.dipi_info_circle .dipi-info-circle.dipi_info_circle-small:hover';

        $image_icon_width_selector = '%%order_class%%.dipi_info_circle .dipi-info-image-icon-wrap.dipi-image-wrapper';
        $image_icon_hover_width_selector = '%%order_class%%.dipi_info_circle .dipi_info_circle-small:hover .dipi-info-image-icon-wrap.dipi-image-wrapper';
        $auto_mode = $this->props['auto_mode'];
        $auto_rotate_mode = $this->props['auto_rotate_mode'];
        $reverse_anim_direction = $this->props['reverse_anim_direction'];
        $pai = pi();
        $delta_angle = $child_items_count ? 2 * $pai / $child_items_count : 0;
        $start_angle_rad = $start_angle * $pai / 360;
        $start_angle_rad_tablet = $start_angle_tablet * $pai / 360;
        $start_angle_rad_phone = $start_angle_phone * $pai / 360;
        $r = (float) $circle_list_size / 2 + (float) $icon_area_offset;
        $r_tablet = (float) $circle_list_size_tablet / 2 + (float) $icon_area_offset_tablet;
        $r_phone = (float) $circle_list_size_phone / 2 + (float) $icon_area_offset_phone;

        $x0 = (float) $circle_list_size / 2;
        $y0 = $r;
        $x0_tablet = (float) $circle_list_size_tablet / 2;
        $y0_tablet = $r_tablet;
        $x0_phone = (float) $circle_list_size_phone / 2;
        $y0_phone = $r_phone;
        $x = 0;
        $y = 0;
        $x_tablet = 0;
        $y_tablet = 0;
        $x_phone = 0;
        $y_phone = 0;
        for ($i = 0; $i < $child_items_count; $i++) {
            $direction = ($auto_mode === 'on' 
                && $auto_rotate_mode !== 'none' 
                && $reverse_anim_direction === 'on') ? -1 : 1;
            $angle = $direction * $i * $delta_angle - $pai / 2.0 + $start_angle_rad;
            $angle_tablet = $direction * $i * $delta_angle - $pai / 2.0 + $start_angle_rad_tablet;
            $angle_phone = $direction * $i * $delta_angle - $pai / 2.0 + $start_angle_rad_phone;
            $x = $r * cos($angle) + $x0;
            $y = $r * sin($angle) + $y0;
            $x_tablet = $r_tablet * cos($angle_tablet) + $x0_tablet;
            $y_tablet = $r_tablet * sin($angle_tablet) + $y0_tablet;
            $x_phone = $r_phone * cos($angle_phone) + $x0_phone;
            $y_phone = $r_phone * sin($angle_phone) + $y0_phone;
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%%.dipi_info_circle .dipi_info_circle_item-' . $i . ' .dipi_info_circle-small',
                'declaration' => "left: {$x}px !important;",
            ]);
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%%.dipi_info_circle .dipi_info_circle_item-' . $i . ' .dipi_info_circle-small',
                'declaration' => "top: {$y}px !important;",
            ]);
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%%.dipi_info_circle .dipi_info_circle_item-' . $i . ' .dipi_info_circle-small',
                'declaration' => "left: {$x_tablet}px !important;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ]);
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%%.dipi_info_circle .dipi_info_circle_item-' . $i . ' .dipi_info_circle-small',
                'declaration' => "top: {$y_tablet}px !important;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ]);
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%%.dipi_info_circle .dipi_info_circle_item-' . $i . ' .dipi_info_circle-small',
                'declaration' => "left: {$x_phone}px !important;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ]);
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%%.dipi_info_circle .dipi_info_circle_item-' . $i . ' .dipi_info_circle-small',
                'declaration' => "top: {$y_phone}px !important;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ]);
        }

        $this->apply_custom_style(
            $render_slug,
            'circle_list_border_width',
            'border-width',
            $circle_list_outline_selector
        );
        $this->apply_custom_style_for_hover(
            $render_slug,
            'circle_list_border_width',
            'border-width',
            $circle_list_hover_outline_selector
        );
        $this->apply_custom_style(
            $render_slug,
            'circle_list_border_color',
            'border-color',
            $circle_list_outline_selector
        );
        $this->apply_custom_style_for_hover(
            $render_slug,
            'circle_list_border_color',
            'border-color',
            $circle_list_hover_outline_selector
        );
        $this->apply_custom_style(
            $render_slug,
            'circle_list_border_style',
            'border-style',
            $circle_list_outline_selector
        );
        $this->apply_custom_style_for_hover(
            $render_slug,
            'circle_list_border_style',
            'border-style',
            $circle_list_hover_outline_selector
        );

        // Images: Add CSS Filters and Mix Blend Mode rules (if set)
        $generate_css_image_filters = '';
        if (array_key_exists('icon_settings', $this->advanced_fields) && array_key_exists('css', $this->advanced_fields['icon_settings'])) {
            $generate_css_image_filters = $this->generate_css_filters(
                $render_slug,
                'child_',
                self::$data_utils->array_get($this->advanced_fields['icon_settings']['css'], 'main', '%%order_class%%')
            );
        }

        // Icon color
        $this->apply_custom_style(
            $render_slug,
            'icon_color',
            'color',
            $icon_selector
        );
        $this->apply_custom_style_for_hover(
            $render_slug,
            'icon_color',
            'color',
            $icon_hover_selector,
            true
        );

        $this->apply_custom_style(
            $render_slug,
            'image_icon_background_color',
            'background-color',
            $image_icon_selector
        );

        $this->apply_custom_style_for_hover(
            $render_slug,
            'image_icon_background_color',
            'background-color',
            $image_icon_hover_selector,
            true
        );

        $this->apply_custom_style(
            $render_slug,
            'image_icon_width',
            'font-size',
            $icon_selector
        );
        $this->apply_custom_style_for_hover(
            $render_slug,
            'image_icon_width',
            'font-size',
            $icon_hover_selector
        );

        $this->apply_custom_style(
            $this->slug,
            'image_icon_width',
            'width',
            $image_icon_width_selector
        );
        $this->apply_custom_style_for_hover(
            $this->slug,
            'image_icon_width',
            'width',
            $image_icon_hover_width_selector
        );
        $this->apply_custom_style(
            $this->slug,
            'image_icon_width',
            'height',
            $image_icon_width_selector
        );
        $this->apply_custom_style_for_hover(
            $this->slug,
            'image_icon_width',
            'height',
            $image_icon_hover_width_selector
        );

        /*ET_Builder_Element::set_style($render_slug, [
        'selector' => '%%order_class%%.dipi_info_circle .dipi-info-circle-out',
        'declaration' => "left: calc(50% + ".abs((float)$icon_area_offset)."px) !important;",
        ]);*/
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%%.dipi_info_circle .dipi-info-circle-out',
            'declaration' => "top: calc(50% + " . ((float) $icon_area_offset) . "px) !important;",
        ]);
        /*
        ET_Builder_Element::set_style($render_slug, [
        'selector' => '%%order_class%%.dipi_info_circle .dipi_info_circle-in',
        'declaration' => "left: calc(50% + ".((float)$icon_area_offset)."px) !important;",
        ]);*/
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%%.dipi_info_circle .dipi_info_circle-in',
            'declaration' => "top: calc(50% + " . ((float) $icon_area_offset) . "px) !important;",
        ]);
        /*ET_Builder_Element::set_style($render_slug, [
        'selector' => '%%order_class%%.dipi_info_circle .dipi-info-circle-out',
        'declaration' => "left: calc(50% + ".((float)$icon_area_offset_tablet)."px) !important;",
        'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ]);*/
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%%.dipi_info_circle .dipi-info-circle-out',
            'declaration' => "top: calc(50% + " . ((float) $icon_area_offset_tablet) . "px) !important;",
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ]);
        /*ET_Builder_Element::set_style($render_slug, [
        'selector' => '%%order_class%%.dipi_info_circle .dipi_info_circle-in',
        'declaration' => "left: calc(50% + ".((float)$icon_area_offset_tablet)."px) !important;",
        'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ]);*/
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%%.dipi_info_circle .dipi_info_circle-in',
            'declaration' => "top: calc(50% + " . ((float) $icon_area_offset_tablet) . "px) !important;",
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ]);
        
        /*ET_Builder_Element::set_style($render_slug, [
        'selector' => '%%order_class%%.dipi_info_circle .dipi-info-circle-out',
        'declaration' => "left: calc(50% + ".abs((float)$icon_area_offset_phone)."px) !important;",
        'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);*/
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%%.dipi_info_circle .dipi-info-circle-out',
            'declaration' => "top: calc(50% + " . ((float) $icon_area_offset_phone) . "px) !important;",
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);
        /*ET_Builder_Element::set_style($render_slug, [
        'selector' => '%%order_class%%.dipi_info_circle .dipi_info_circle-in',
        'declaration' => "left: calc(50% + ".((float)$icon_area_offset_phone)."px) !important;",
        'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);*/
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%%.dipi_info_circle .dipi_info_circle-in',
            'declaration' => "top: calc(50% + " . ((float) $icon_area_offset_phone) . "px) !important;",
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);


        $this->generate_styles(
            array(
                'base_attr_name' => 'circle_list_size',
                'selector' => '%%order_class%%.dipi_info_circle .dipi_info_circle_container',
                'css_property' => 'width',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%%.dipi_info_circle .dipi_info_circle_container:not(.dipi_info-circle_list)',
            'declaration' => "height: {$circle_list_size};",
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%%.dipi_info_circle .dipi_info_circle_container.dipi_info-circle_list',
            'declaration' => "height: auto;",
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%%.dipi_info_circle .dipi_info_circle_container:not(.dipi_info-circle_list_tablet)',
            'declaration' => "height: {$circle_list_size_tablet};",
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%%.dipi_info_circle .dipi_info_circle_container.dipi_info-circle_list_tablet',
            'declaration' => "height: auto;",
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%%.dipi_info_circle .dipi_info_circle_container:not(.dipi_info-circle_list_phone)',
            'declaration' => "height: {$circle_list_size_phone};",
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%%.dipi_info_circle .dipi_info_circle_container.dipi_info-circle_list_phone',
            'declaration' => "height: auto;",
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ]);
        /* default styling */
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '.et-db #et-boc .et-l .dipi_info_circle .dipi_info_circle_item .dipi_info_circle_item_container .dipi-info-circle.dipi_info_circle-small:hover,
            .et-db #et-boc .et-l .dipi_info_circle .dipi_info_circle_item .dipi_info_circle_item_container.active .dipi-info-circle.dipi_info_circle-small:hover,
            .dipi_info_circle .dipi_info_circle_item_container .dipi-info-circle.dipi_info_circle-small:hover,
            .dipi_info_circle .dipi_info_circle_item_container.active .dipi-info-circle.dipi_info_circle-small:hover',
            'declaration' => "background-color: #2C3D49;",
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '.et-db #et-boc .et-l .dipi_info_circle .dipi_info_circle_item .dipi_info_circle_item_container .dipi_info_circle-small:hover .dipi-info-image-icon-wrap .et-pb-icon,
            .et-db #et-boc .et-l .dipi_info_circle .dipi_info_circle_item .dipi_info_circle_item_container.active .dipi_info_circle-small:hover .dipi-info-image-icon-wrap .et-pb-icon,
            .dipi_info_circle .dipi_info_circle_item_container .dipi_info_circle-small:hover .dipi-info-image-icon-wrap .et-pb-icon,
            .dipi_info_circle .dipi_info_circle_item_container.active .dipi_info_circle-small:hover .dipi-info-image-icon-wrap .et-pb-icon',
            'declaration' => "color: #ffffff;",
        ]);

    }
    public function before_render()
    {
        global $child_items_count;
        $child_items_count = 0;
    }
    public function render($attrs, $content, $render_slug)
    {
        global $child_items_count;
        wp_enqueue_script('dipi_info_circle_public');
        wp_enqueue_style('dipi_animate');
        $this->_dipi_apply_css($render_slug);
        $module_custom_classes = '';
        $icon_area_offset = $this->props['icon_area_offset'];
        $icon_area_offset_values = et_pb_responsive_options()->get_property_values($this->props, 'icon_area_offset');
        $icon_area_offset_tablet = !empty($icon_area_offset_values['tablet']) ? $icon_area_offset_values['tablet'] : $icon_area_offset;
        $icon_area_offset_phone = !empty($icon_area_offset_values['phone']) ? $icon_area_offset_values['phone'] : $icon_area_offset_tablet;

        $show_as_list = $this->props['show_as_list'];
        $show_as_list_values = et_pb_responsive_options()->get_property_values($this->props, 'show_as_list');
        $show_as_list_tablet = !empty($show_as_list_values['tablet']) ? $show_as_list_values['tablet'] : $show_as_list;
        $show_as_list_phone = !empty($show_as_list_values['phone']) ? $show_as_list_values['phone'] : $show_as_list_tablet;
        
        $start_angle = $this->props['start_angle'];
        $start_angle_values = et_pb_responsive_options()->get_property_values($this->props, 'start_angle');
        $start_angle_tablet = !empty($start_angle_values['tablet']) ? $start_angle_values['tablet'] : $start_angle;
        $start_angle_phone = !empty($start_angle_values['phone']) ? $start_angle_values['phone'] : $start_angle_tablet;

        $info_image_icon_animation = $this->props['info_image_icon_animation'];
        $select_event = $this->props['select_event'];
        $content_animation = $this->props['content_animation'];
        $auto_mode = $this->props['auto_mode'];
        $auto_time = $this->props['auto_time'];
        $auto_rotate_mode = $this->props['auto_rotate_mode'];
        $reverse_anim_direction = $this->props['reverse_anim_direction'];
        $auto_rotate_time = $this->props['auto_rotate_time'];
        $auto_rotate_angle = $this->props['auto_rotate_angle'];

        $config = [
            'animation' => $content_animation,
            'items_count' => $child_items_count,
            'icon_area_offset' => (int)$icon_area_offset,
            'icon_area_offset_tablet' => (int)$icon_area_offset_tablet,
            'icon_area_offset_phone' => (int)$icon_area_offset_phone,
            'start_angle' => $start_angle,
            'start_angle_tablet' => $start_angle_tablet,
            'start_angle_phone' => $start_angle_phone,
        ];
        if ($auto_mode === 'on') {
            $config = array_merge(
                $config,
                [
                    'auto_mode' => $auto_mode,
                    'auto_time' => $auto_time,
                    'auto_rotate_mode' => $auto_rotate_mode,
                    'auto_rotate_time' => $auto_rotate_time,
                    'auto_rotate_angle' => $auto_rotate_angle,
                    'reverse_anim_direction' => $reverse_anim_direction,
                ]
            );
        }
        $module_custom_classes = '';

        if ($select_event == 'click') {
            $module_custom_classes .= " dipi-trigger_on_click";
        }
        if (!empty($show_as_list) && $show_as_list === 'on') {
            $module_custom_classes .= " dipi_info-circle_list";
        }

        if (!empty($show_as_list_tablet) && $show_as_list_tablet === 'on') {
            $module_custom_classes .= " dipi_info-circle_list_tablet";
        }

        if (!empty($show_as_list_phone) && $show_as_list_phone === 'on') {
            $module_custom_classes .= " dipi_info-circle_list_phone";
        }

        if ($info_image_icon_animation === 'on') {
            $module_custom_classes .= ' icon_ani';
        }
        return sprintf(
            '<div class="dipi_info_circle_container %2$s" data-config="%3$s">
                <div class="dipi-info-circle dipi-info-circle-out"></div>
                <div class="dipi-info-circle-items">%1$s</div>
            </div>
            ',
            $this->props['content'],
            $module_custom_classes,
            esc_attr(htmlspecialchars(json_encode($config), ENT_QUOTES, 'UTF-8'))
        );
    }
}

new DIPI_InfoCircle;
