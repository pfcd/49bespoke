<?php
class DIPI_TileScroll extends DIPI_Builder_Module
{

    public $slug = 'dipi_tile_scroll';
    public $vb_support = 'on';
    // Module item's slug
    public $child_slug = 'dipi_tile_scroll_item';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/tile-scroll',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function get_custom_css_fields_config() {
        $fields = [];
      
        
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
    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__('Pixel Tile Scroll', 'dipi-tile-scroll-module-for-divi');
        $this->settings_modal_toggles = array(
            'general' => array(
                'toggles' => array(
                    'content' => esc_html__('Content', 'dipi-divi-pixel'),
                    'settings' => esc_html__('Settings', 'dipi-divi-pixel'),
                    'overlay' => esc_html__('Overlay', 'dipi-divi-pixel'),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'scroll_container'  => esc_html__('Scroll Container', 'dipi-divi-pixel'),
                    'content_container' => esc_html__('Content Container', 'dipi-divi-pixel'),
                    'content_image_icon' => esc_html__('Content Image & Icon', 'dipi-divi-pixel'),
                    'content_text' => [
                        'sub_toggles' => [
                            'title' => [
                                'name' => 'Title',
                            ],
                            'desc' => [
                                'name' => 'Description',
                            ],
                        ],
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__('Content Text', 'dipi-divi-pixel'),
                      ],
                ),
            ),
        );
    }
    public function get_advanced_fields_config()
    {
        $advanced_fields = [];
        $content_container_class = '%%order_class%% .dipi-tile-scroll-content-wrapper';
        $container_hover_class = '%%order_class%% .dipi-tile-scroll-content-wrapper:hover';
        $content_icon_selector = '%%order_class%%  .dipi-tile-scroll-content-wrapper .dipi-content-image-icon-wrap .et-pb-icon';
        $content_image_icon_selector = '%%order_class%% .dipi_tile_scroll_container .dipi-content-image, %%order_class%% .dipi_tile_scroll_container .dipi-icon-wrap .et-pb-icon';
        $content_image_icon_hover_selector = '%%order_class%% .dipi-tile-scroll-content-wrapper:hover .dipi-content-image, %%order_class%% .dipi-tile-scroll-content-wrapper:hover .dipi-icon-wrap .et-pb-icon';
        $content_image_icon_size_selector = '%%order_class%% .dipi_tile_scroll_container .dipi-content-image img, %%order_class%% .dipi_tile_scroll_container .dipi-icon-wrap .et-pb-icon';
        $content_title_selector = '%%order_class%% .dipi-content-text .dipi-content-heading';
        $content_desc_selector = '%%order_class%% .dipi-content-text .dipi-desc';
        $advanced_fields["text"] = false;
        $advanced_fields["text_shadow"] = false;
        $advanced_fields["borders"]["default"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%%",
                    'border_styles' => "%%order_class%%",
                ],
            ],
          ];
        $advanced_fields['borders']['content_container'] = [
            'css' => [
                'main' => [
                    'border_radii' => $content_container_class,
                    'border_radii_hover' => $container_hover_class,
                    'border_styles' => $content_container_class,
                    'border_styles_hover' => $container_hover_class,
                ],
            ],
            'label_prefix' => et_builder_i18n( '' ),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_container',
            'hover'           => 'tabs',
        ];
        $advanced_fields['box_shadow']['content_container'] = [
            'label' => esc_html__('Box Shadow', 'dipi-divi-pixel'),
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'css' => [
                'main' => $content_container_class,
                'overlay' => 'inset',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_container',
            'hover'           => 'tabs',
        ];
       
        $advanced_fields["image_icon"]["image_icon"] = [
            'margin_padding'  => [
              'css' => [
                'important' => 'all',
              ],
            ],
            'option_category' => 'layout',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_image_icon',
            'label'           => et_builder_i18n( 'Image & Icon' ),
            'css'             => [
              'main'    => $content_image_icon_selector,
              'hover' => $content_image_icon_hover_selector,
            ],
        ];
        $advanced_fields["icon_settings"] = [ /* Need this setting to apply filter */
            'css' => [
              'main' => $content_image_icon_selector,
            ]
        ];
        $advanced_fields["filters"]['child_filters_target'] = [
            'tab_slug'        => 'advanced',
            'toggle_slug'     => 'content_image_icon',
            'label'           => esc_html__( 'Image & Icon', 'dipi-divi-pixel' ),
            'css'             => array(
              'main'        => $content_image_icon_selector,
            ),
        ];
        $advanced_fields["fonts"]["content_title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => $content_title_selector,
            ],
            'important' => 'all',
            'hide_text_align' => false,
            'toggle_slug' => 'content_text',
            'sub_toggle' => 'title',
            'header_level' => [
                'default' => 'h2',
            ],
            'line_height' => [
                'range_settings' => [
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ],
            ],
          ];
      
          $advanced_fields["fonts"]["content_desc"] = [
              'label' => esc_html__('Description', 'dipi-divi-pixel'),
              'css' => [
                  'main' => $content_desc_selector,
              ],
              'important' => 'all',
              'hide_text_align' => false,
              'toggle_slug' => 'content_text',
              'sub_toggle' => 'desc',
              'line_height' => [
                  'range_settings' => [
                      'min' => '1',
                      'max' => '3',
                      'step' => '0.1',
                  ],
              ],
        ];
        
        $advanced_fields['button']["content_button"] = [
            'label' => esc_html__('Content Button', 'dipi-divi-pixel'),
            'use_alignment' => true,
            'font_size' => array(
              'default' => '14px',
           ),
            'css' => [
                'main' => "%%order_class%% .dipi_content_button.et_pb_button",
                'important' => true,
            ],
            'box_shadow'  => [
                'css' => [
                    'main' => "%%order_class%% .dipi_content_button.et_pb_button",
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'margin' => "%%order_class%% .dipi-button-wrapper",
                    'padding' => "%%order_class%% .dipi_content_button.et_pb_button",
                    'important' => 'all'
                ],
            ],
        ];
        /* Content Image & Icon */
        $advanced_fields['borders']['content_image'] = [
            'css' => [
                'main' => [
                    'border_radii' => $content_image_icon_selector,
                    'border_radii_hover' => $content_image_icon_hover_selector,
                    'border_styles' => $content_image_icon_selector,
                    'border_styles_hover' => $content_image_icon_hover_selector,
                ],
            ],
            'label_prefix' => et_builder_i18n( 'Image & Icon' ),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_image_icon',
            'hover'           => 'tabs',
        ];
        return $advanced_fields;
    }
    public function get_fields()
    {
        $et_accent_color = et_builder_accent_color();
        $fields = [];
        $fields["use_content_icon"] = [
            'label' => esc_html__('Use Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default'     => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on'  => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'content',
            'option_category' => 'basic_option',
        ];
        $fields["content_icon"] = [
            'label'       => esc_html__('Icon', 'dipi-divi-pixel'),
            'type'        => 'select_icon',
            'class'       => ['et-pb-font-icon'],
            'default'     => '1',
            'show_if' => [
                'use_content_icon' => 'on'
            ],
            'toggle_slug' => 'content',
            'option_category' => 'basic_option',
        ];
        $fields['content_image'] = [
            'type'               => 'upload',
            'hide_metadata'      => true,
            'choose_text'        => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text'        => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'description'        => esc_html__('Upload an info image to show in the content.', 'dipi-divi-pixel'),
            'show_if' => [
                'use_content_icon' => 'off'
            ],
            'toggle_slug'        => 'content',
            'option_category' => 'basic_option',
        ];
        $fields["content_img_alt"] = [
            'label' => esc_html__('Image Alt Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'description' => esc_html__('Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
            'show_if' => [
                'use_content_icon' => 'off',
            ],
            'toggle_slug' => 'content',
            'dynamic_content' => 'text',
            'option_category' => 'basic_option',
        ];
        $fields['content_icon'] = [
            'label' => esc_html__('Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'class'       => ['et-pb-font-icon'],
            'default' => '5',
            'show_if' => ['use_content_icon' => 'on'],
            'toggle_slug' => 'content',
            'option_category' => 'basic_option',
        ];


        $fields["content_title"] = [
            'label'       => esc_html__('Title', 'dipi-divi-pixel'),
            'type'        => 'text',
            'toggle_slug' => 'content',
            'dynamic_content' => 'text',
            'option_category' => 'basic_option',
        ];
      
        $fields["content_description"] = [
            'label'           => esc_html__('Description', 'dipi-divi-pixel'),
            'type'            => 'tiny_mce',
            'toggle_slug'     => 'content',
            'dynamic_content' => 'text',
            'option_category' => 'basic_option',
        ];

        $fields['show_content_button'] = [
            'label' => esc_html__('Show Button', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'content',
            'option_category' => 'basic_option',
        ];

        $fields["content_button_text"] = [
            'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => esc_html__('Click Here', 'dipi-divi-pixel'),
            'show_if' => ['show_content_button' => 'on'],
            'toggle_slug' => 'content',
            'dynamic_content' => 'text',
            'option_category' => 'basic_option',
        ];

        $fields["content_button_link"] = [
            'label' => esc_html__('Button Link', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => '#',
            'show_if' => ['show_content_button' => 'on'],
            'toggle_slug' => 'content',
            'dynamic_content' => 'text',
            'option_category' => 'basic_option',
        ];

        $fields["content_button_link_target"] = [
            'label' => esc_html__('Button Link Target', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'layout',
            'default' => 'same_window',
            'default_on_child' => true,
            'options' => [
                'off' => esc_html__('Same Window', 'dipi-divi-pixel'),
                'on' => esc_html__('New Window', 'dipi-divi-pixel'),
            ],
            'show_if' => ['show_content_button' => 'on'],
            'toggle_slug' => 'content',
        ];
        
        $fields['anim_direction'] = [
            'label' => esc_html__('Animation Direction', 'dipi-divi-pixel'),
            'type'  => 'select',
            'option_category' => 'configuration',
            'default' => 'row',
            'options' => [
                'row' => esc_html__('Row', 'dipi-divi-pixel'),
                'column' => esc_html__('Column', 'dipi-divi-pixel'),
            ],
            'toggle_slug'       => 'settings',
        ];
        $fields['start_row_direction'] = [
            'label' => esc_html__('Start Row Direction', 'dipi-divi-pixel'),
            'type'  => 'select',
            'option_category' => 'configuration',
            'default' => 'left',
            'options' => [
                'letf' => esc_html__('Left', 'dipi-divi-pixel'),
                'right' => esc_html__('Right', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'anim_direction' => 'row'
            ],
            'toggle_slug'       => 'settings',
        ];
        $fields['start_col_direction'] = [
            'label' => esc_html__('Start Column Direction', 'dipi-divi-pixel'),
            'type'  => 'select',
            'option_category' => 'configuration',
            'default' => 'top',
            'options' => [
                'top' => esc_html__('Top', 'dipi-divi-pixel'),
                'bottom' => esc_html__('Bottom', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'anim_direction' => 'column'
            ],
            'toggle_slug'       => 'settings',
        ];
        $fields['rotate_angle'] = [
            'label' => esc_html__('Rotate Angle(deg)', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '0',
            'default_on_front' => '0',
            'range_settings' => [
                'min' => '0',
                'max' => '360',
                'step' => '1',
            ],
            'validate_unit' => true,
            'toggle_slug' => 'settings',
        ];
        $fields['scroll_container_width'] = [
            'label' => esc_html('Scroll Container Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => 'auto',
            'default_unit' => 'px',
            'range_settings' => [
                'min'  => '1',
                'max'  => '100',
                'step' => '1'
            ],
            'allowed_units'     => array( 'px', 'vw', '%' ),
            'mobile_options' => true,
            'toggle_slug' => 'settings'
        ];
        $fields['scroll_container_height'] = [
            'label' => esc_html('Scroll Container Height', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => 'auto',
            'default_unit' => 'px',
            'range_settings' => [
                'min'  => '1',
                'max'  => '2000',
                'step' => '1'
            ],
            'allowed_units'     => array( 'px', 'vh' ),
            'mobile_options' => true,
            'toggle_slug' => 'settings'
        ];
 
        $fields['move_amount'] = [
            'label' => esc_html__('Move Amount', 'dipi-divi-pixel'),
            'description'     => esc_html__( 'Here you can define pixel amount to move line while scrolling one screen', 'dipi-divi-pixel' ),
            'type' => 'range',
            'default' => '10',
            'default_on_front' => '100',
            'default_unit' => '',
            'range_settings' => [
                'min' => '0',
                'max' => '500',
                'step' => '10',
            ],
            'validate_unit' => true,
            'toggle_slug' => 'settings',
        ];
        $fields['space_lines'] = [
            'label' => esc_html__('Space between Lines', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '20px',
            'default_on_front' => '20px',
            'default_unit' => 'px',
            'range_settings' => [
                'min' => '0',
                'max' => '300',
                'step' => '10',
            ],
            'validate_unit' => true,
            'responsive' => true,
            'mobile_options' => true,
            'toggle_slug' => 'settings',
        ];
        $fields['space_items'] = [
            'label' => esc_html__('Space between Items', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '20',
            'default_on_front' => '20px',
            'default_unit' => 'px',
            'range_settings' => [
                'min' => '0',
                'max' => '300',
                'step' => '10',
            ],
            'validate_unit' => true,
            'responsive' => true,
            'mobile_options' => true,
            'toggle_slug' => 'settings',
        ];
        /*$fields["auto_play"] = [
            'label' => esc_html__('Auto Play', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'settings',
        ];*/

        $fields['use_overlay'] = [
            'label' => esc_html__('Use Overlay', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'overlay',
            'affects' => [
                'overlay_bg_color'
            ]
        ];
       
        $fields['container_margin'] = [
            'label' => esc_html('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_container',
        ];
        $fields['container_padding'] = [
            'label' => esc_html('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'default' => '30px|30px|30px|30px',
            'mobile_options' => true,
            'responsive' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_container',
        ];
        $fields['content_width'] = [
            'label' => esc_html('Content Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => 'auto',
            'default_unit' => '%',
            'range_settings' => [
                'min'  => '1',
                'max'  => '100',
                'step' => '1'
            ],
            'validate_unit' => true,
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_container'
        ];
        $fields['content_height'] = [
            'label' => esc_html('Content Height', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => 'auto',
            'default_unit' => '%',
            'range_settings' => [
                'min'  => '1',
                'max'  => '100',
                'step' => '1'
            ],
            'validate_unit' => true,
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_container'
        ];

        $fields['cotent_bg_blur'] = [
            'label' => esc_html__('Background Blur', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '0',
            'default_on_front' => '0',
            'range_settings' => [
                'min' => '0',
                'max' => '30',
                'step' => '1',
            ],
            'default_unit' => 'px',
            'validate_unit' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_container',
        ];
        /* Content Image & Icon */
        $fields['content_icon_color'] = [
            'default'         => $et_accent_color,
            'label'           => esc_html__( 'Icon Color', 'dipi-divi-pixel' ),
            'type'            => 'color-alpha',
            'description'     => esc_html__( 'Here you can define a custom color for your icon.', 'dipi-divi-pixel' ),
            'show_if' => ['use_content_icon' => 'on'],
            'tab_slug'        => 'advanced',
            'hover'           => 'tabs',
            'mobile_options'  => true,
            'sticky'          => true,
            'toggle_slug'  => 'content_image_icon',
        ];
        $fields["content_circle_icon"] = [
            'label' => esc_html__('Circle Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'default' => 'off',
            'options' => array(
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ),
            'show_if' => ['use_content_icon' => 'on'],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_image_icon',
        ];

       
        $fields['content_image_icon_background_color'] = [
            'label'          => esc_html__( 'Image & Icon Background Color', 'dipi-divi-pixel' ),
            'type'           => 'color-alpha',
            'description'    => esc_html__( 'Here you can define a custom background color.', 'dipi-divi-pixel' ),
            'default'        => 'transparent',
            'tab_slug'       => 'advanced',
            'hover'          => 'tabs',
            'mobile_options' => true,
            'sticky'         => true,
            'toggle_slug'  => 'content_image_icon',
        ];

        $fields['content_image_icon_size'] = [
            'label'                  => esc_html__( 'Image & Icon Size', 'dipi-divi-pixel' ),
            'toggle_slug'  => 'content_image_icon',
            'description'            => esc_html__( 'Here you can choose icon/img Size.', 'dipi-divi-pixel' ),
            'type'                   => 'range',
            'range_settings'         => [
            'min'  => '1',
            'max'  => '200',
            'step' => '1',
            ],
            'option_category'        => 'layout',
            'tab_slug'               => 'advanced',
            'hover'           => 'tabs',
            'validate_unit'          => true,
            'allowed_units'          => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
            'responsive'             => true,
            'mobile_options'         => true,
            'sticky'                 => true,
            'default' => '96px'
        ];
        $fields['icon_alignment'] = [
            'label' => esc_html__('Image & Icon Alignment', 'dipi-divi-pixel'),
            'description' => esc_html__('Align image/icon to the left, right or center.', 'dipi-divi-pixel'),
            'type' => 'align',
            'option_category' => 'layout',
            'options' => et_builder_get_text_orientation_options(array('justified')),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_image_icon',
            'default' => 'center',
            'mobile_options' => true,
            'sticky' => true,
        ];
        /* Content Title Spacing */
        $fields['content_title_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of Title.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_text',
            'sub_toggle' => 'title',
            'default' => '0px|0px|0px|0px',
            
            'mobile_options' => true,
        ];
        $fields['content_title_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Title.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_text',
            'sub_toggle' => 'title',
            'default' => '0px|0px|10px|0px',
            'mobile_options' => true,
        ];
        $fields['content_desc_margin'] = [
            'label' => __('Margin', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Margin of Description.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_text',
            'sub_toggle' => 'desc',
            'default' => '0px|0px|0px|0px',
            'mobile_options' => true,
        ];
        $fields['content_desc_padding'] = [
            'label' => __('Padding', 'dipi-divi-pixel'),
            'type' => 'custom_margin',
            'description' => __('Set Padding of Description.', 'dipi-divi-pixel'),
            'tab_slug' => 'advanced',
            'toggle_slug' => 'content_text',
            'sub_toggle' => 'desc',
            'default' => '0px|0px|10px|0px',
            'mobile_options' => true,
        ];
        $additional_options = [];
        $additional_options['overlay_bg_color'] = [
            'label' => esc_html__('Overlay Background', 'dipi-divi-pixel'),
            'type' => 'background-field',
            'base_name' => "overlay_bg",
            'context' => "overlay_bg",
            'option_category' => 'layout',
            'custom_color' => true,
            'default' => ET_Global_Settings::get_value('all_buttons_bg_color'),
            'toggle_slug' => "overlay",
            'background_fields' => array_merge(
                ET_Builder_Element::generate_background_options('overlay_bg', 'gradient', "advanced", "overlay_background", "overlay_bg_gradient"),
                ET_Builder_Element::generate_background_options("overlay_bg", "color", "advanced", "overlay_background", "overlay_bg_color"),
                ET_Builder_Element::generate_background_options("overlay_bg", "image", "advanced", "overlay_background", "overlay_bg_image")
            ),
        ];
        $additional_options['content_bg_color'] = [
            'label' => esc_html__('Background', 'dipi-divi-pixel'),
            'type' => 'background-field',
            'base_name' => "content_bg",
            'context' => "content_bg",
            'option_category' => 'layout',
            'custom_color' => true,
            'default' => ET_Global_Settings::get_value('all_buttons_bg_color'),
            'tab_slug' => 'advanced',
            'toggle_slug' => "content_container",
            'background_fields' => array_merge(
                ET_Builder_Element::generate_background_options('content_bg', 'gradient', "advanced", "content_background", "content_bg_gradient"),
                ET_Builder_Element::generate_background_options("content_bg", "color", "advanced", "content_background", "content_bg_color"),
                ET_Builder_Element::generate_background_options("content_bg", "image", "advanced", "content_background", "content_bg_image")
            ),
        ];

        $additional_options = array_merge($additional_options, $this->generate_background_options("content_bg", 'skip', "advanced", "content_background", "content_bg_gradient"));
        $additional_options = array_merge($additional_options, $this->generate_background_options("content_bg", 'skip', "advanced", "content_background", "content_bg_color"));
        $additional_options = array_merge($additional_options, $this->generate_background_options("content_bg", 'skip', "advanced", "content_background", "content_bg_image"));
        $additional_options = array_merge($additional_options, $this->generate_background_options("overlay_bg", 'skip', "advanced", "overlay_background", "overlay_bg_gradient"));
        $additional_options = array_merge($additional_options, $this->generate_background_options("overlay_bg", 'skip', "advanced", "overlay_background", "overlay_bg_color"));
        $additional_options = array_merge($additional_options, $this->generate_background_options("overlay_bg", 'skip', "advanced", "overlay_background", "overlay_bg_image"));
        return array_merge($fields, $additional_options);

        return $fields;
    }
    public function get_transition_fields_css_props()
    {
        $fields = parent::get_transition_fields_css_props();
        

        return $fields;
    }
   
    /**
     * Custom CSS
     */
    public function _dipi_apply_css($render_slug)
    {
        global $child_items_count;
        $scroll_container_class = '%%order_class%% .dipi_tile_scroll_container';
        $content_container_class = '%%order_class%% .dipi-tile-scroll-content-wrapper';
        $container_hover_class = '%%order_class%%:hover .dipi-tile-scroll-content-wrapper';
        $overlay_class = '%%order_class%% .dipi-tile-scroll-overlay';
        $overlay_hover_class = '%%order_class%%:hover .dipi-tile-scroll-overlay';
        
        $content_image_icon_wrapper_selector = '%%order_class%% .dipi-tile-scroll-content-wrapper .dipi-content-image-icon-wrap';
        $content_icon_selector = '%%order_class%% .dipi-content-image-icon-wrap .et-pb-icon';
        $content_image_icon_selector = '%%order_class%% .dipi_tile_scroll_container .dipi-content-image, %%order_class%% .dipi_tile_scroll_container .dipi-icon-wrap .et-pb-icon';
        $content_image_icon_hover_selector = '%%order_class%% .dipi-tile-scroll-content-wrapper:hover .dipi-content-image, %%order_class%% .dipi-tile-scroll-content-wrapper:hover .dipi-icon-wrap .et-pb-icon';
        $content_image_icon_size_selector = '%%order_class%% .dipi_tile_scroll_container .dipi-content-image img';
        $content_title_selector = '%%order_class%% .dipi-content-text .dipi-content-heading';
        $content_desc_selector = '%%order_class%% .dipi-content-text .dipi-desc';
        $content_button_selector = '%%order_class%% .dipi-tile-scroll-content .dipi-button-wrapper';
        $content_circle_icon = $this->props['content_circle_icon'];
        $rotate_angle = $this->props['rotate_angle'];
        // Images: Add CSS Filters and Mix Blend Mode rules (if set)
        $generate_css_image_filters = '';
        if ( array_key_exists( 'icon_settings', $this->advanced_fields ) && array_key_exists( 'css', $this->advanced_fields['icon_settings'] ) ) {
            $generate_css_image_filters = $this->generate_css_filters(
                $render_slug,
                'child_',
                self::$data_utils->array_get( $this->advanced_fields['icon_settings']['css'], 'main', '%%order_class%%' )
            );
        }

        
        $this->generate_styles(
            array(
            'base_attr_name' => 'space_lines',
            'selector'       => "%%order_class%% .dipi-tile-scroll-items",
            'css_property'   => 'gap',
            'render_slug'    => $render_slug,
            'type'           => 'range',
            )
        );

        $this->generate_styles(
            array(
            'base_attr_name' => 'space_items',
            'selector'       => "%%order_class%% .dipi-tile-scroll-items .dipi_tile_scroll_item_container",
            'css_property'   => 'gap',
            'render_slug'    => $render_slug,
            'type'           => 'range',
            )
        );

        /* Content Container */
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'container_margin',
            'css_property'   => 'margin',
            'selector'       => $content_container_class,
            'hover_selector' => $container_hover_class
        ]);
        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'container_padding',
            'css_property'   => 'padding',
            'selector'       => $content_container_class,
            'hover_selector' => $container_hover_class
        ]);
        $this->set_background_css(
            $render_slug,
            $content_container_class,
            $container_hover_class,
            'content_bg', 
            'content_bg_color'
        );
        if('on' === $this->props['use_overlay']) {
            $this->set_background_css(
                $render_slug,
                $overlay_class,
                $overlay_hover_class,
                'overlay_bg', 
                'overlay_bg_color'
            );
        }
        $this->apply_custom_style(
            $this->slug,
            'cotent_bg_blur',
            'backdrop-filter',
            $content_container_class,
            false,
            1,
            'px',
            'blur'
        );
        $this->apply_custom_style(
            $this->slug,
            'cotent_bg_blur',
            '-webkit-backdrop-filter',
            $content_container_class,
            false,
            1,
            'px',
            'blur'
        );
        /* Content Image & Icon */
        $this->generate_styles(
            array(
            'base_attr_name' => 'content_icon_color',
            'selector'       => $content_icon_selector,
            'css_property'   => 'color',
            'render_slug'    => $render_slug,
            'type'           => 'color',
            )
        );
      
        $this->generate_styles(
            array(
            'base_attr_name' => 'content_image_icon_background_color',
            'selector'       => $content_image_icon_selector,
            'css_property'   => 'background-color',
            'render_slug'    => $render_slug,
            'type'           => 'color',
            )
        );
    
        $this->generate_styles(
            array(
            'base_attr_name' => 'content_image_icon_size',
            'selector'       => $content_icon_selector,
            'css_property'   => 'font-size',
            'render_slug'    => $render_slug,
            'type'           => 'range',
            )
        );
    
        $this->generate_styles(
            array(
            'base_attr_name' => 'content_image_icon_size',
            'selector'       => $content_image_icon_size_selector,
            'css_property'   => 'width',
            'render_slug'    => $render_slug,
            'type'           => 'range',
            )
        );
        $this->generate_styles(
            array(
            'base_attr_name' => 'content_image_icon_size',
            'selector'       => $content_image_icon_size_selector,
            'css_property'   => 'height',
            'render_slug'    => $render_slug,
            'type'           => 'range',
            )
        );

        $this->generate_styles(
            array(
            'base_attr_name' => 'scroll_container_height',
            'selector'       => $scroll_container_class,
            'css_property'   => 'height',
            'render_slug'    => $render_slug,
            'type'           => 'range',
            )
        );
        $this->generate_styles(
            array(
            'base_attr_name' => 'scroll_container_width',
            'selector'       => $scroll_container_class,
            'css_property'   => 'width',
            'render_slug'    => $render_slug,
            'type'           => 'range',
            )
        );
        $this->generate_styles(
            array(
            'base_attr_name' => 'content_height',
            'selector'       => $content_container_class,
            'css_property'   => 'height',
            'render_slug'    => $render_slug,
            'type'           => 'range',
            )
        );
        $this->generate_styles(
            array(
            'base_attr_name' => 'content_width',
            'selector'       => $content_container_class,
            'css_property'   => 'width',
            'render_slug'    => $render_slug,
            'type'           => 'range',
            )
        );
        // Image/Icon Alignment
        $this->generate_styles(
            array(
            'base_attr_name' => 'icon_alignment',
            'selector'       => $content_image_icon_wrapper_selector,
            'css_property'   => 'text-align',
            'render_slug'    => $render_slug,
            'type'           => 'align',
            )
        );
        
        
        /* Content Title */

        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'content_title_margin',
            'css_property'   => 'margin',
            'selector'       => $content_title_selector ,
        ]);

        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'content_title_padding',
            'css_property'   => 'padding',
            'selector'       => $content_title_selector ,
        ]);
        /* Content Description */

        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'content_desc_margin',
            'css_property'   => 'margin',
            'selector'       => $content_desc_selector ,
        ]);

        $this->dipi_process_spacing_field([
            'render_slug'    => $render_slug,
            'slug'           => 'content_desc_padding',
            'css_property'   => 'padding',
            'selector'       => $content_desc_selector ,
        ]);
        /* Content Button */
        $btn_margin = $this->dipi_get_responsive_prop('content_button_custom_margin' );
        // $this->set_responsive_spacing_css($render_slug, "%%order_class%%.dipi_expanding_cta .dipi_content_button.et_pb_button", 'margin', $btn_margin, true );
        $btn_padding = $this->dipi_get_responsive_prop('content_button_custom_margin' );
        //$this->set_responsive_spacing_css($render_slug, "%%order_class%%.dipi_expanding_cta .dipi_content_button.et_pb_button", 'padding', $btn_padding, true );
        $this->generate_styles(
            array(
            'base_attr_name' => 'content_button_alignment',
            'selector'       => $content_button_selector,
            'css_property'   => 'text-align',
            'render_slug'    => $render_slug,
            'type'           => 'align',
            )
        );

 
    }
    public function before_render()
    {
        global $child_items_count;
        $child_items_count = 0;
    }
 
    public function _render_content($render_slug)
    {
        $parallax_image_background = $this->get_parallax_image_background();
        $content_circle_icon = $this->props['content_circle_icon'];
        $content_image_icon = '';
        $content_image_icon_classes[] = '';
        if ('on' === $content_circle_icon) {
            $content_image_icon_classes[] = 'content-ico-circle';
        }
        $content_icon_selector = '%%order_class%% .dipi-tile-scroll-content-wrapper .dipi-content-image-icon-wrap .et-pb-icon';
        if ('on' == $this->props['use_content_icon']) {
            $icon = ($this->props['content_icon'] === '%&quot;%%' || $this->props['content_icon'] === '%"%%') ? '%%22%%' : $this->props['content_icon'];
            $content_icon = et_pb_process_font_icon($icon);
            $content_image_icon = sprintf(
                '<div class="dipi-content-image-icon-wrap dipi-icon-wrap">
                    <span class="et-pb-icon et-pb-font-icon dipi-content-icon %2$s">%1$s</span>
                </div>',
                esc_attr($content_icon),
                implode(' ', $content_image_icon_classes)
            );
  
            $this->dipi_generate_font_icon_styles($render_slug, 'content_icon', $content_icon_selector);
        } else if ('on' !== $this->props['use_content_icon'] && $this->props['content_image'] !== '') {
            $content_image_icon = sprintf(
                '<div class="dipi-content-image-icon-wrap dipi-image-wrapper">
                    <div class="dipi-content-image">
                        <img src="%1$s" alt="%2$s">
                    </div>
                </div>',
                esc_attr($this->props['content_image']),
                $this->_esc_attr('content_img_alt')
            );
        }
  
        $content_title_level = $this->props['content_title_level'] ? $this->props['content_title_level'] : 'h2';
        $content_title = '';
        if (isset($this->props['content_title']) && '' !== $this->props['content_title']) {
            $content_title = sprintf(
                '<%2$s class="dipi-content-heading">
                    %1$s
                </%2$s>',
                esc_attr($this->props['content_title']),
                esc_attr($content_title_level)
            );
        }
  
        $content_description = '';
        if (isset($this->props['content_description']) && !empty($this->props['content_description'])) {
            $content_description = sprintf(
                '<div class="dipi-desc">%1$s</div>',
                $this->process_content($this->props['content_description'])
            );
        }
  
        $show_content_button        = $this->props['show_content_button'];
        $content_button_text        = $this->props['content_button_text'];
        $content_button_link        = $this->props['content_button_link'];
        $content_button_rel         = $this->props['content_button_rel'];
        $content_button_icon        = $this->props['content_button_icon'];
        $content_button_link_target = $this->props['content_button_link_target'];
        $content_button_custom      = $this->props['custom_content_button'];
  
        $content_button = $this->render_button([
            'button_classname' => ["dipi_content_button", "dipi-ig-button"],
            'button_custom'    => $content_button_custom,
            'button_rel'       => $content_button_rel,
            'button_text'      => $content_button_text,
            'button_url'       => $content_button_link,
            'custom_icon'      => $content_button_icon,
            'url_new_window'   => $content_button_link_target,
            'has_wrapper'      => false
        ]);
        $content_html = '';
        if ($content_image_icon || $content_title || $content_description || $show_content_button === 'on') {
            $content_html = sprintf(
            '%1$s
            <div class="dipi-content-text">
                %2$s
                %3$s
            </div>
            <div class="dipi-button-wrapper">
                %4$s
            </div>
            ',
            $content_image_icon,
            $content_title,
            $content_description,
            ($show_content_button === 'on') ? $content_button : ''
            );
            $content_html = sprintf(
            '<div
                class="dipi-tile-scroll-content-wrapper">
                %1$s
            </div>',
            $content_html
            );
    
            $content_html = sprintf(
                '<div class="dipi-tile-scroll-content">
                    %1$s
                    %2$s
                </div>',
                $parallax_image_background,
                $content_html
            );
        }
        return $content_html;
    }

    public function render($attrs, $content, $render_slug)
    {
        global $child_items_count;
        wp_enqueue_script('dipi_tile_scroll_public');
        wp_enqueue_style('dipi_animate');
        $anim_direction = ($this->props['anim_direction']) ? $this->props['anim_direction'] : 'row';
        $start_row_direction = ($this->props['start_row_direction']) ? $this->props['start_row_direction'] : 'left';
        $start_col_direction = ($this->props['start_col_direction']) ? $this->props['start_col_direction'] : 'top';
        $rotate_angle = ($this->props['rotate_angle']) ? $this->props['rotate_angle'] : '0';
        $move_amount = ($this->props['move_amount']) ? $this->props['move_amount'] : '20px';
        $use_overlay = ($this->props['use_overlay']) ? $this->props['use_overlay'] : 'off';
        $this->_dipi_apply_css($render_slug);
        $module_custom_classes = '';
       
        $config = [
            'items_count' => $child_items_count,
            'anim_direction' => $anim_direction,
            'start_row_direction' => $start_row_direction,
            'start_col_direction' => $start_col_direction,
            'move_amount' => $move_amount,
            'rotate_angle'=> $rotate_angle,
        ];
       
        $module_custom_classes = '';
        $module_custom_classes .= " anim_direct_{$anim_direction}";
        $start_direction = '';
        if ($anim_direction === 'row') {
            $start_direction = $start_row_direction;
        } else {
            $start_direction = $start_col_direction;
        }
        $module_custom_classes .= " anim_start_{$start_direction}";
        $overlay_html = $use_overlay === "on" ? '<div class="dipi-tile-scroll-overlay"></div>' : '';
        return sprintf(
            '<div class="dipi_tile_scroll_container %2$s" data-config="%3$s">
                <div class="dipi-tile-scroll-items">%1$s</div>    
                %5$s
                %4$s
            </div>
            ',
            $this->props['content'],
            $module_custom_classes,
            esc_attr(htmlspecialchars(json_encode($config), ENT_QUOTES, 'UTF-8')),
            $this->_render_content($render_slug),
            $overlay_html #5
        );
    }
}

new DIPI_TileScroll;
