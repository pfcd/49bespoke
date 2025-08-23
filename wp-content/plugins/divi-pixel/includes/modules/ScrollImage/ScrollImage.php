<?php
class DIPI_ScrollImage extends DIPI_Builder_Module
{

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/scroll-image',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->slug = 'dipi_scroll_image';
        $this->vb_support = 'on';
        $this->name = esc_html__('Pixel Scroll Image', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%.dipi_scroll_image';
    }

    public function get_settings_modal_toggles()
    {
        return [
            'general' => [
                'toggles' => [
                    'image' => esc_html__('Scroll Image', 'dipi-divi-pixel'),
                    'settings' => esc_html__('Settings', 'dipi-divi-pixel'),
                    'overlay' => esc_html__('Overlay', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'direction_icon' => esc_html__('Direction Icon', 'dipi-divi-pixel'),
                    'overlay' => esc_html__('Overlay', 'dipi-divi-pixel'),
                ],
            ],
        ];
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = [];
        $advanced_fields["text"] = false;
        $advanced_fields["text_shadow"] = false;
        $advanced_fields["fonts"] = false;

        $advanced_fields['box_shadow']['default'] = [
            'css' => [
                'main' => '%%order_class%%',
            ],
        ];

        $advanced_fields['borders']['default'] = [
            'css' => [
                'main' => [
                    'border_radii'  => "%%order_class%%",
                    'border_styles' => "%%order_class%%",
                ],
            ],
        ];

        $advanced_fields['borders']['direction_img'] = [
            'label_prefix' => esc_html__('Direction Image', 'dipi-divi-pixel'),
            'css' => [
                'main' => [
                    'border_radii'  => "%%order_class%% .dipi-image-scroll-content img",
                    'border_styles' => "%%order_class%% .dipi-image-scroll-content img",
                ],
            ],
            'depends_on'      => ['use_image'],
            'depends_show_if' => 'on',
            'tab_slug'        => 'advanced',
            'toggle_slug'     => 'direction_icon',
        ];

        $advanced_fields['box_shadow']['direction_img'] = [
            'label_prefix' => esc_html__('Direction Image', 'dipi-divi-pixel'),
            'css' => [
                'main' => '%%order_class%% .dipi-image-scroll-content img',
                'overlay' => 'inset',
            ],
            'tab_slug'    => 'advanced',
            'toggle_slug' => 'direction_icon',
            'show_if'     => ['use_image' => 'on'],
        ];

        return $advanced_fields;
    }

    public function get_custom_css_fields_config()
    {
        $fields = [];

        $fields['image'] = [
            'label' => esc_html__('Image', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-image-scroll-image img',
        ];

        $fields['image_container'] = [
            'label' => esc_html__('Image Container', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-image-scroll-container',
        ];

        $fields['image_overlay'] = [
            'label' => esc_html__('Image Overlay', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-image-scroll-overlay',
        ];

        $fields['icon'] = [
            'label' => esc_html__('Direction Icon', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-image-scroll-icon',
        ];

        $fields['icon_img'] = [
            'label' => esc_html__('Direction Icon Img', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-image-scroll-content img',
        ];

        return $fields;
    }

    public function get_fields()
    {
        $fields = [];

        $fields["scroll_image"] = [
            'label'              => esc_html__('Image', 'dipi-divi-pixel'),
            'type'               => 'upload',
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text'        => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text'        => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'hide_metadata'      => true,
            'dynamic_content' => 'image',
            'toggle_slug'        => 'image',
        ];

        $fields["img_alt"] = [
            'label'       => esc_html__( 'Image Alt Text', 'dipi-divi-pixel' ),
            'type'        => 'text',
            'description' => esc_html__( 'Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
            'toggle_slug' => 'image'
        ];

       $fields['scroll_image_height'] = [
            'label'          => esc_html('Image Height', 'dipi-divi-pixel'),
            'type'           => 'range',
            'default'        => '400px',
            'default_unit'   => 'px',
            'allowed_units'  => ['%', 'px', 'em'],
            'range_settings' => [
                'min'  => '1',
                'max'  => '1200',
                'step' => '1'
            ],
            'validate_unit'  => true,
            'mobile_options' => true,
            'toggle_slug'    => 'image',
        ];
        $fields['use_overlay'] = [
            'label' => esc_html__('Show Overlay', 'dipi-divi-pixel'),
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
        $fields["overlay_direction"] = [
            'label' => esc_html__('Reveal Direction', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'reveal_fade',
            'options' => [
                'reveal_fade' => esc_html__('None', 'dipi-divi-pixel'),
                'reveal_top' => esc_html__('Top', 'dipi-divi-pixel'),
                'reveal_bottom' => esc_html__('Bottom', 'dipi-divi-pixel'),
                'reveal_left' => esc_html__('Left', 'dipi-divi-pixel'),
                'reveal_right' => esc_html__('Right', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'overlay',
            'show_if' => [
                'use_overlay' => 'on'
            ],
        ];
        $fields["scroll_type"] = [
            'label' => esc_html__('Scroll Type', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'on_hover',
            'options' => [
                'on_hover' => esc_html__('On Hover Scroll', 'dipi-divi-pixel'),
                'on_mouse' => esc_html__('On Mouse Scroll', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'settings',
        ];

        $fields["scroll_direction"] = [
            'label'   => esc_html__('Scroll Direction', 'dipi-divi-pixel'),
            'type'    => 'select',
            'default' => 'vertical',
            'options' => [
                'vertical'   => esc_html__('Vertical', 'dipi-divi-pixel'),
                'horizontal' => esc_html__('Horizontal', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'settings',
        ];

        $fields['reverse'] = [
            'label' => esc_html__('Reverse Direction', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'scroll_type' => 'on_hover'
            ],
            'toggle_slug' => 'settings'
        ];

        $fields['scroll_speed'] = [
            'label'          => esc_html('Hover Scroll Speed', 'dipi-divi-pixel'),
            'type'           => 'range',
            'default'        => 10,
            'unitless'       => true,
            'range_settings' => [
                'min'  => '1',
                'max'  => '50',
                'step' => '1'
            ],
            'toggle_slug' => 'settings',
            'mobile_options' => true,
        ];

        $fields['back_scroll_speed'] = [
            'label'          => esc_html('Back Scroll Speed', 'dipi-divi-pixel'),
            'type'           => 'range',
            'unitless'       => true,
            'default'        => 5,
            'range_settings' => [
                'min'  => '1',
                'max'  => '50',
                'step' => '1'
            ],
            'toggle_slug' => 'settings',
            'mobile_options' => true,
        ];

        

        $fields['use_direction_icon'] = [
            'label' => esc_html__('Show Direction Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'settings'
        ];

        $fields['use_image'] = [
            'label' => esc_html__('Use Image Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'use_direction_icon' => 'on',
            ],
            'toggle_slug' => 'settings'
        ];

        $fields['direction_icon'] = [
            'label' => esc_html__('Select Direction Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'default' => '4',
            'show_if' => [
                'use_direction_icon' => 'on',
                'use_image' => 'off',
            ],
            'toggle_slug' => 'settings',
        ];

        $fields["direction_image"] = [
            'label'              => esc_html__('Select Direction Image', 'dipi-divi-pixel'),
            'type'               => 'upload',
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text'        => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text'        => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'hide_metadata'      => true,
            'show_if' => [
                'use_direction_icon' => 'on',
                'use_image' => 'on',
            ],
            'toggle_slug'        => 'settings',
        ];

        $fields['use_icon_animation'] = [
            'label' => esc_html__('Animate Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'use_direction_icon' => 'on'
            ],
            'toggle_slug' => 'settings',
        ];

        $fields['direction_image_width'] = [
            'label' => esc_html('Direction Image Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '70px',
            'default_unit' => 'px',
            'allowed_units' => ['px'],
            'range_settings' => [
                'min'  => '1',
                'max'  => '150',
                'step' => '1'
            ],
            'show_if' => [
                'use_direction_icon' => 'on',
                'use_image' => 'on',
            ],
            'validate_unit'  => true,
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'width',
        ];

         $fields["direction_img_alt"] = [
            'label'       => esc_html__( 'Direction Image Alt Text', 'dipi-divi-pixel' ),
            'type'        => 'text',
            'description' => esc_html__( 'Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
            'toggle_slug' => 'settings',
            'show_if'     => [
                'use_direction_icon' => 'off',
                'use_image' => 'on',
            ],
        ];

        $fields["icon_color"] = [
            'label'           => esc_html__( 'Icon Color', 'dipi-divi-pixel' ),
            'type'            => 'color-alpha',
            'validate_unit'   => true,
            'show_if' => [
                'use_direction_icon' => 'on',
                'use_image' => 'off',
            ],
            'hover'    => 'tabs',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'direction_icon',
        ];

        $fields["use_icon_circle"] = [
            'label'            => esc_html__('Show as Circle Icon', 'dipi-divi-pixel'),
            'type'             => 'yes_no_button',
            'options'          => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'use_direction_icon' => 'on',
                'use_image'          => 'off',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'direction_icon',
        ];

        $fields["icon_circle_color"] = [
            'label'         => esc_html__('Circle Color', 'dipi-divi-pixel'),
            'type'          => 'color-alpha',
            'validate_unit' => true,
            'show_if' => [
                'use_direction_icon' => 'on',
                'use_image'          => 'off',
                'use_icon_circle'    => 'on'
            ],
            'hover'       => 'tabs',
            'tab_slug'    => 'advanced',
            'toggle_slug' => 'direction_icon',
        ];

        $fields["use_icon_circle_border"] = [
            'label'           => esc_html__('Show Circle Border', 'dipi-divi-pixel'),
            'type'            => 'yes_no_button',
            'options'         => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on'  => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'use_direction_icon' => 'on',
                'use_image'          => 'off',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'direction_icon',
        ];

        $fields["icon_border_color"] = [
            'label'           => esc_html__('Circle Border Color', 'dipi-divi-pixel'),
            'type'            => 'color-alpha',
            'show_if' => [
                'use_direction_icon'     => 'on',
                'use_image'              => 'off',
                'use_icon_circle_border' => 'on'
            ],
            'hover'       => 'tabs',
            'tab_slug'    => 'advanced',
            'toggle_slug' => 'direction_icon',
        ];

        $fields['icon_size'] = [
            'label'          => esc_html('Icon Size', 'dipi-divi-pixel'),
            'type'           => 'range',
            'default'        => '50px',
            'default_unit'   => 'px',
            'range_settings' => [
                'min'  => '1',
                'max'  => '120',
                'step' => '1'
            ],
            'show_if' => [
                'use_direction_icon' => 'on',
                'use_image' => 'off',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'direction_icon',
        ];

        $additional_options['overlay_bg_color'] = [
            'label'           => esc_html__('Overlay', 'dipi-divi-pixel'),
            'type'            => 'background-field',
            'base_name'       => "overlay_bg",
            'context'         => "overlay_bg",
            'custom_color'    => true,
            'default'         => ET_Global_Settings::get_value('all_buttons_bg_color'),
            'depends_show_if' => 'on',
            'toggle_slug'     => "overlay",
            'hover'           => 'tabs',
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
                ),
                ET_Builder_Element::generate_background_options(
                    "overlay_bg",
                    "image",
                    "advanced",
                    "overlay",
                    "overlay_bg_color"
                )
            ),
        ];

        $additional_options = array_merge(
            $additional_options,
            $this->generate_background_options(
                "overlay_bg",
                'skip',
                "advanced",
                "overlay",
                "overlay_bg_gradient"
            )
        );

        $additional_options = array_merge(
            $additional_options,
            $this->generate_background_options(
                "overlay_bg",
                'skip',
                "advanced",
                "overlay",
                "overlay_bg_color"
            )
        );

        return array_merge($fields, $additional_options);
    }

    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_scroll_image_public');
        $this->_render_css($render_slug);

        $scroll_image       = $this->props['scroll_image'];
        $img_alt            = $this->props['img_alt'];
        $scroll_type        = $this->props['scroll_type'];
        $scroll_direction   = $this->props['scroll_direction'];
        $reverse            = $this->props['reverse'];
        $use_direction_icon = $this->props['use_direction_icon'];
        $use_image          = $this->props['use_image'];
        $direction_image    = $this->props['direction_image'];
        $direction_img_alt  = $this->props['direction_img_alt'];
        $direction_icon     = et_pb_process_font_icon($this->props['direction_icon']);
        $overlay_direction  = $this->props['overlay_direction'];
        if('on' === $use_direction_icon){
            $this->dipi_generate_font_icon_styles($render_slug, 'direction_icon', '%%order_class%% .dipi-image-scroll-icon');
        }

        $content_icon = 'on' == $use_direction_icon && 'off' ==  $use_image ? sprintf('
            <div class="dipi-image-scroll-content">
                <span class="et-pb-icon et-pb-font-icon dipi-image-scroll-icon">%1$s</span>
            </div>',
            esc_attr($direction_icon)

        ) : sprintf('
            <div class="dipi-image-scroll-content">
                <img src="%1$s" alt="%2$s">
            </div>',
            esc_attr($direction_image),
            esc_attr($direction_img_alt)
        );

        $container_class = '';
        if( $scroll_type === "on_mouse") {
            $container_class = "dipi-image-container-scroll";
        }

        $vertical_class = '';
        if( $scroll_direction === "vertical") {
            $vertical_class = 'dipi-image-scroll-vertical-active';
        }

        $icon_animation_class = "on" === $this->props['use_icon_animation'] ? 'dipi-icon-animate' : '';
        $scroll_direction_class = "vertical" === $scroll_direction ? 'dipi-image-scroll-vertical' : 'dipi-image-scroll-horizontal';
        
        $reverse_reset_class = "on" === $reverse ? 'dipi-container-scroll-anim-reset' : '';
        

        return sprintf(
            '<div class="dipi-scroll-image %10$s %11$s" data-type="%3$s" data-direction="%4$s" data-reverse="%9$s">
                <div class="dipi-image-scroll-container %6$s %12$s">
                    %5$s
                    <div class="dipi-image-scroll-image dipi-image-scroll-%1$s %7$s">
                        <div class="dipi-image-scroll-overlay reveal %13$s"></div>
                        <img src="%2$s" alt="%8$s">
                    </div>
                </div>
            </div>',
            $scroll_direction,
            $scroll_image,
            $scroll_type,
            $scroll_direction,
            $content_icon, #5
            $container_class,
            $vertical_class,
            $img_alt,
            $reverse,
            $icon_animation_class, #10
            $scroll_direction_class,
            $reverse_reset_class,
            $overlay_direction
        );
    }

    public function _render_css($render_slug)
    {

        $this->_dipi_direction_icon_css($render_slug);
        $this->_dipi_scroll_image_height_css($render_slug);
        $this->_dipi_direction_image_width_css($render_slug);

        $back_scroll_speed = $this->props['back_scroll_speed'];


        $scroll_speed_class = "%%order_class%%:hover .dipi-image-scroll-image img";
        $scroll_speed = $this->props['scroll_speed'];
        $scroll_speed_tablet = $this->props['scroll_speed_tablet'];
        $scroll_speed_phone = $this->props['scroll_speed_phone'];
        $scroll_speed_last_edited = $this->props['scroll_speed_last_edited'];
        $scroll_speed_responsive_status = et_pb_get_responsive_status($scroll_speed_last_edited);

        if('' !== $scroll_speed ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $scroll_speed_class,
                'declaration' => sprintf( 'transition: all %1$ss !important;', $scroll_speed ),
            ) );
        }

        if('' !== $scroll_speed_tablet && $scroll_speed_responsive_status) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $scroll_speed_class,
                'declaration' => sprintf( 'transition: all %1$ss !important;', $scroll_speed_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
        }

        if('' !== $scroll_speed_phone && $scroll_speed_responsive_status) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $scroll_speed_class,
                'declaration' => sprintf( 'transition: all %1$ss !important;', $scroll_speed_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }

  
        $back_scroll_speed_class = "%%order_class%% .dipi-image-scroll-image img";
        $back_scroll_speed = $this->props['back_scroll_speed'];
        $back_scroll_speed_tablet = $this->props['back_scroll_speed_tablet'];
        $back_scroll_speed_phone = $this->props['back_scroll_speed_phone'];
        $back_scroll_speed_last_edited = $this->props['back_scroll_speed_last_edited'];
        $back_scroll_speed_responsive_status = et_pb_get_responsive_status($back_scroll_speed_last_edited);

        if('' !== $back_scroll_speed ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $back_scroll_speed_class,
                'declaration' => sprintf('transition: all %1$ss !important;', $back_scroll_speed),
            ) );
        }

        if('' !== $back_scroll_speed_tablet && $back_scroll_speed_responsive_status) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $back_scroll_speed_class,
                'declaration' => sprintf( 'transition: all %1$ss !important;', $back_scroll_speed_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
        }

        if('' !== $back_scroll_speed_phone && $back_scroll_speed_responsive_status) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $back_scroll_speed_class,
                'declaration' => sprintf( 'transition: all %1$ss !important;', $back_scroll_speed_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }
        
        if('on' === $this->props['use_overlay']) {
            $this->set_background_css(
                $render_slug,
                '%%order_class%% .dipi-image-scroll-overlay',
                '%%order_class%% .dipi-image-scroll-overlay:hover',
                'overlay_bg',
                'overlay_bg_color'
            );
        }
    }

    private function _dipi_direction_image_width_css($render_slug)
    {
        $direction_image_width = $this->dipi_get_responsive_prop('direction_image_width');
        
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-image-scroll-content > img",
            'declaration' => sprintf('width: %1$s !important;', $direction_image_width['desktop']),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-image-scroll-content > img",
            'declaration' => sprintf('width: %1$s !important;', $direction_image_width['tablet']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-image-scroll-content > img",
            'declaration' => sprintf('width: %1$s !important;', $direction_image_width['phone']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767')
        ));
    }


    private function _dipi_direction_icon_css($render_slug)
    {

        $icon_color              = $this->props['icon_color'];
        $icon_color_hover        = isset($this->props['icon_color__hover']) ? $this->props['icon_color__hover'] : $icon_color;
        $icon_size               = $this->props['icon_size'];
        
        $use_icon_circle         = $this->props['use_icon_circle'];
        $icon_circle_color       = $this->props['icon_circle_color'];
        $icon_circle_color_hover = isset($this->props['icon_circle_color__hover']) ? $this->props['icon_circle_color__hover'] : $icon_circle_color;
        
        $use_icon_circle_border  = $this->props['use_icon_circle_border'];
        $icon_border_color       = $this->props['icon_border_color'];
        $icon_border_color_hover = isset($this->props['icon_border_color__hover']) ? $this->props['icon_border_color__hover'] : $icon_border_color;

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-image-scroll-icon',
            'declaration' => "color: {$icon_color} !important;"
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%%:hover .dipi-image-scroll-icon',
            'declaration' => "color: {$icon_color_hover} !important;"
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-image-scroll-icon',
            'declaration' => "font-size: {$icon_size} !important;"
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-image-scroll-icon',
            'declaration' => "color: {$icon_color} !important;"
        ]);

        if ('on' == $use_icon_circle) :
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-image-scroll-icon',
                'declaration' => "padding: 25px; border-radius: 100%; background-color: {$icon_circle_color} !important;"
            ]);


            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%%:hover .dipi-image-scroll-icon',
                'declaration' => "background-color: {$icon_circle_color_hover} !important;"
            ]);
        endif;

        if ('on' === $use_icon_circle_border) :
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-image-scroll-icon',
                'declaration' => "border: 3px solid {$icon_border_color};"
            ]);

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%%:hover .dipi-image-scroll-icon',
                'declaration' => "border-color: {$icon_border_color_hover} !important;"
            ]);
        endif;

    }

    private function _dipi_scroll_image_height_css( $render_slug )
    {

        $scroll_image_height = $this->props['scroll_image_height'];
        $scroll_image_height_responsive_status = et_pb_get_responsive_status($this->props['scroll_image_height_last_edited']);
        $scroll_image_height_tablet = $this->dipi_get_responsive_value('scroll_image_height_tablet', $scroll_image_height, $scroll_image_height_responsive_status);
        $scroll_image_height_phone = $this->dipi_get_responsive_value('scroll_image_height_phone', $scroll_image_height_tablet, $scroll_image_height_responsive_status);

        ET_Builder_Element::set_style( $render_slug, array(
            'selector' => "%%order_class%% .dipi-image-scroll-container",
            'declaration' => sprintf( 'height: %1$s !important;', $scroll_image_height),
        ));

        ET_Builder_Element::set_style( $render_slug, array(
            'selector' => "%%order_class%% .dipi-image-scroll-container",
            'declaration' => sprintf( 'height: %1$s !important;', $scroll_image_height_tablet),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ));

        ET_Builder_Element::set_style( $render_slug, array(
            'selector' => "%%order_class%% .dipi-image-scroll-container",
            'declaration' => sprintf( 'height: %1$s !important;', $scroll_image_height_phone),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767')
        ));
    }
 
}

new DIPI_ScrollImage;
