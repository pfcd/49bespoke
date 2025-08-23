<?php

class DIPI_FloatingMultiImagesChild extends DIPI_Builder_Module
{

    public function init()
    {

        $this->name = esc_html__('Floating Image', 'dipi-divi-pixel');
        $this->plural = esc_html__('Floating Images', 'dipi-divi-pixel');
        $this->slug = 'dipi_floating_multi_images_child';
        $this->vb_support = 'on';
        $this->type = 'child';
        $this->child_title_var = 'item_label';
        $this->advanced_setting_title_text = esc_html__('New Image', 'dipi-divi-pixel');
        $this->settings_text = esc_html__('Image Settings', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%';

        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'main_content' => esc_html__('Image', 'dipi-divi-pixel'),
                    'position' => esc_html__('Image Position', 'dipi-divi-pixel'),
                    'animation' => esc_html__('Animation', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'borders' => esc_html__('Border', 'dipi-divi-pixel'),
                ],
            ],
        ];

    }

    public function get_fields()
    {   
        $accent_color = et_builder_accent_color();
		$fields = [];
		
		$fields["item_label"] = [
			'label' => esc_html__('Admin Label', 'dipi-divi-pixel'),
			'description' => esc_html__('The label is used in the parent module to identify this item.', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'main_content',
            'option_category' => 'basic_option',
        ];

        // toggle use icon  
        $fields['use_icon'] = [
            'label' => esc_html__('Use Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel')
            ],
            'toggle_slug' => 'main_content',
            'option_category' => 'basic_option'
        ];
        // icon field show if use icon is on
        $fields['icon'] = [
            'label' => esc_html__('Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'default' => '&#x21;||divi||400',
            'option_category' => 'basic_option',
            'show_if' => [
                'use_icon' => 'on'
            ],
            'toggle_slug' => 'main_content',
        ];

        // icons size   
        $fields['icon_size'] = [
            'label' => esc_html__('Icon Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'layout',
            'default' => '32px',
            'default_unit' => 'px',
            'mobile_options' => true,
            'range_settings' => [
                'min' => '1',
                'max' => '256',
                'step' => '1',
            ],
            'toggle_slug' => 'main_content',
            'show_if' => [
                'use_icon' => 'on'
            ]
        ];

        // icons color
        $fields['icon_color'] = [
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'mobile_options' => true,
            'default' => $accent_color,
            'toggle_slug' => 'main_content',
            'show_if' => [
                'use_icon' => 'on'
            ]
        ];


        $fields['img_src'] = [
            'type' => 'upload',
            'hide_metadata' => true,
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'toggle_slug' => 'main_content',
            'option_category' => 'basic_option',
            'dynamic_content' => 'image',
            'show_if' => [
                'use_icon' => 'off'
            ]
        ];

        $fields["img_alt"] = [
            'label' => esc_html__('Image Alt Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => '',
            'description' => esc_html__('Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
            'toggle_slug' => 'main_content',
            'option_category' => 'basic_option',
            'dynamic_content' => 'text',
            'show_if' => [
                'use_icon' => 'off'
            ]
        ];

        $fields['use_img_link'] = [
            'label' => esc_html__('Add Image Link', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel')
            ],
            'toggle_slug' => 'main_content',
            'option_category' => 'configuration'
        ];
        
        $fields["img_link"] = [
            'label' => esc_html__('Image Link', 'dipi-divi-pixel'),
            'type' => 'text',
            'show_if' => [
                'use_img_link' => 'on'
            ],
            'toggle_slug' => 'main_content',
            'option_category' => 'configuration',
            'dynamic_content' => 'text'
        ];
        
        $fields["img_link_target"] = [
            'label' => esc_html__('Image Link Target', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Same Window', 'dipi-divi-pixel'),
                'on' => esc_html__('New Window', 'dipi-divi-pixel'),
            ),
            'show_if' => [
                'use_img_link' => 'on'
            ],
            'toggle_slug' => 'main_content',
            'option_category' => 'configuration',
        ];

        $fields['horizontal_position'] = [
            'label' => esc_attr__('Horizontal Position', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'layout',
            'mobile_options' => true,
            'validate_unit' => true,
            'default' => '0%',
            'default_unit' => '%',
            'range_settings' => [
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ],
            'responsive' => true,
            'toggle_slug' => 'position',
        ];

        $fields['vertical_position'] = [
            'label' => esc_attr__('Vertical Position', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'layout',
            'mobile_options' => true,
            'validate_unit' => true,
            'default' => '0%',
            'default_unit' => '%',
            'range_settings' => [
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ],
            'responsive' => true,
            'toggle_slug' => 'position',
        ];

        $fields['fmi_effect'] = [
            'label' => esc_html__('Effect', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'configuration',
            'default' => 'updown',
            'options' => [
                'updown' => esc_html__('Up Down', 'dipi-divi-pixel'),
                'leftright' => esc_html__('Left Right', 'dipi-divi-pixel'),
                'topleftright' => esc_html__('Top Left Bottom Right', 'dipi-divi-pixel'),
                'toprightleft' => esc_html__('Top Right Bottom Left', 'dipi-divi-pixel'),
                'rotate' => esc_html__('Rotate', 'dipi-divi-pixel'),
                'zoom' => esc_html__('Zoom', 'dipi-divi-pixel'),
                'zoomtop' => esc_html__('Zoom Top', 'dipi-divi-pixel'),
                'zoombottom' => esc_html__('Zoom Bottom', 'dipi-divi-pixel'),
                'zoomleft' => esc_html__('Zoom Left', 'dipi-divi-pixel'),
                'zoomright' => esc_html__('Zoom Right', 'dipi-divi-pixel'),
                'zoomrotate' => esc_html__('Zoom & Rotate', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'animation',
        ];

        $fields['fmi_delay'] = [
            'label' => esc_html__('Interval Delay', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'default' => '0ms',
            'default_on_front' => '0ms',
            'default_unit' => 'ms',
            'range_settings' => [
                'min' => '-21000',
                'max' => '0',
                'step' => '100',
            ],
            'toggle_slug' => 'animation',
        ];

        $fields['fmi_speed'] = [
            'label' => esc_html__('Speed', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'default' => '5000ms',
            'default_on_front' => '5000ms',
            'default_unit' => 'ms',
            'range_settings' => [
                'min' => '0',
                'max' => '10000',
                'step' => '50',
            ],
            'toggle_slug' => 'animation',
        ];

        return $fields;

    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = [];
        $advanced_fields['fonts'] = false;
        $advanced_fields['text'] = false;
        $advanced_fields['button'] = false;
        $advanced_fields['link_optons'] = false;

        $advanced_fields['background'] = [
            'css' => [
                'main' => "%%order_class%% img, %%order_class%% .et-pb-icon.dipi-fi-icon",
                'hover' => "%%order_class%% img, %%order_class%% .et-pb-icon.dipi-fi-icon"
            ]
        ];

        $advanced_fields["borders"]["item"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% img, %%order_class%% .et-pb-icon.dipi-fi-icon",
                    'border_styles' => "%%order_class%% img, %%order_class%% .et-pb-icon.dipi-fi-icon",
                ],
            ],
            'toggle_slug' => 'borders',
        ];

        $advanced_fields['box_shadow']["default"] = [
            'css' => [
                'main' => '%%order_class%% img, %%order_class%% .et-pb-icon.dipi-fi-icon',
            ],
        ];
        $advanced_fields['height'] = [
            'css' => [
                'main' => "$this->main_css_element img, %%order_class%% .et-pb-icon.dipi-fi-icon",
            ],
        ];
        $advanced_fields['transform'] = [
            'css' => [
                'main' => "$this->main_css_element img, %%order_class%% .et-pb-icon.dipi-fi-icon",
            ],
        ];

        $advanced_fields['margin_padding'] = array(
            'css'   => array(
                'main'      => "$this->main_css_element .dipi-fi-img, %%order_class%% .et-pb-icon.dipi-fi-icon",
                'important' => 'all'
            )
        );
        return $advanced_fields;
    }

    public function render($attrs, $content, $render_slug)
    {

        $img_src = $this->props['img_src'];
        $img_alt = $this->props['img_alt'];

        $img_pathinfo = pathinfo($img_src);
        $is_img_svg = isset($img_pathinfo['extension']) ? 'svg' === $img_pathinfo['extension'] : false;
        if ($is_img_svg):
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%',
                'declaration' => 'width: 100%;',
            ));
        endif;

        // Image horizontal positioning
        $horizontal_position = $this->props['horizontal_position'];
        $horizontal_position_tablet = $this->props['horizontal_position_tablet'];
        $horizontal_position_phone = $this->props['horizontal_position_phone'];
        $horizontal_position_last_edited = $this->props['horizontal_position_last_edited'];
        $horizontal_position_responsive_status = et_pb_get_responsive_status($horizontal_position_last_edited);

        if ('' !== $horizontal_position) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%',
                'declaration' => sprintf('left: %1$s !important;', $horizontal_position),
            ));
        }

        if ('' !== $horizontal_position_tablet && $horizontal_position_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%',
                'declaration' => sprintf('left: %1$s !important;', $horizontal_position_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if ('' !== $horizontal_position_phone && $horizontal_position_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%',
                'declaration' => sprintf('left: %1$s !important;', $horizontal_position_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        // Image vertical positioning
        $vertical_position = $this->props['vertical_position'];
        $vertical_position_tablet = $this->props['vertical_position_tablet'];
        $vertical_position_phone = $this->props['vertical_position_phone'];
        $vertical_position_last_edited = $this->props['vertical_position_last_edited'];
        $vertical_position_responsive_status = et_pb_get_responsive_status($vertical_position_last_edited);

        if ('' !== $vertical_position) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%',
                'declaration' => sprintf('top: %1$s !important;', $vertical_position),
            ));
        }

        if ('' !== $vertical_position_tablet && $vertical_position_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%',
                'declaration' => sprintf('top: %1$s !important;', $vertical_position_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if ('' !== $vertical_position_phone && $vertical_position_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%%',
                'declaration' => sprintf('top: %1$s !important;', $vertical_position_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%',
            'declaration' => "position: absolute !important;",
        ));

        // Animation Name
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%',
            'declaration' => sprintf(
                'animation-name: dipi-%1$s-effect !important;',
                esc_html($this->props['fmi_effect'])
            ),
        ));

        // Animation Duration
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%%',
            'declaration' => sprintf(
                'animation-duration: %1$s !important;',
                esc_html($this->props['fmi_speed'])
            ),
        ));

        // Animation Delay
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%%",
            'declaration' => sprintf(
                'animation-delay: %1$s !important;',
                esc_html($this->props['fmi_delay'])
            ),
        ));

        if($this->props['use_icon'] === 'on'){

            $this->process_range_field_css( array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_size',
                'type'              => 'font-size',
                'fixed_unit'          => 'px',
                'default' => '32px',
                'selector'          => '%%order_class%% .et-pb-icon.dipi-fi-icon',
                'important'         => false
            ) );
            $this->process_color_field_css(array(
                'render_slug'       => $render_slug,
                'slug'              => 'icon_color',
                'type'              => 'color',
                'selector'          => '%%order_class%% .et-pb-icon.dipi-fi-icon',
                'hover'             => '%%order_class%% .et-pb-icon.dipi-fi-icon:hover',
                'important'         => true
            )) ;
        }

        $use_img_link    = $this->props['use_img_link'];
        $img_link        = $this->props['img_link'];
        $img_link_target = $this->props['img_link_target']  === 'on' ? '_blank' : '_self';

        $start_link_wrap = 'on' == $use_img_link ? sprintf(
            '<a href="%1$s" target="%2$s">', 
            $img_link, 
            $img_link_target
        ) : '';
        
        $end_link_wrap = 'on' == $use_img_link ? '</a>' : '';

        $content = '';
      
        if($this->props['use_icon'] === 'on'){
            $this->dipi_generate_font_icon_styles($render_slug, 'icon', '%%order_class%% .et-pb-icon.dipi-fi-icon');
            $content = sprintf(
                '<span class="et-pb-icon dipi-fi-icon">
                    %1$s
                </span>',
                et_pb_process_font_icon($this->props['icon'])
            );
        } else {
            $content = sprintf(
                '<div class="dipi-fi-img"><img src="%1$s" alt="%2$s"/></img></div>',
                esc_attr($img_src),
                esc_attr($img_alt)
            );
        }
        
        return sprintf(
            '%2$s
                %1$s
            %3$s',
            $content,
            $start_link_wrap,
            $end_link_wrap
        );
    }
}

new DIPI_FloatingMultiImagesChild;

