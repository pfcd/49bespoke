<?php

class DIPI_ImageAccordionChild extends DIPI_Builder_Module
{

    public function init()
    {
        $this->name                        = esc_html__('Pixel Image Accordion', 'dipi-divi-pixel');
        $this->plural                      = esc_html__('Pixel Image Accordion', 'dipi-divi-pixel');
        $this->slug                        = 'dipi_image_accordion_child';
        $this->vb_support                  = 'on';
        $this->type                        = 'child';
        $this->child_title_var             = 'title';
        $this->advanced_setting_title_text = esc_html__('New Image', 'dipi-divi-pixel');
        $this->settings_text               = esc_html__('Image Settings', 'dipi-divi-pixel');
        $this->main_css_element            = '%%order_class%%';
    }

    public function get_settings_modal_toggles()
    {
        return [
            'general' => [
                'toggles' => [
                    'accordion_bg' => esc_html__('Image', 'dipi-divi-pixel'),
                    'accordion' => esc_html__('Accordion', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'image' => esc_html__('Image Overlay', 'dipi-divi-pixel'),
                    'accordion_image_icon' => esc_html__('Accordion Image/Icon', 'dipi-divi-pixel'),
                    'accordion_text' => [
                        'sub_toggles' => [
                            'title' => [
                                'name' => 'Title',
                            ],
                            'desc' => [
                                'name' => 'Description',
                            ]
                        ],
                        'tabbed_subtoggles'    => true,
                        'title' => esc_html__('Accordion Text', 'dipi-divi-pixel'),
                        'priority' => 49,
                    ],
                ],
            ],
            'custom_css' => [
                'toggles' => [
                    'classes' => esc_html__('CSS ID & Classes', 'dipi-divi-pixel'),
                ],
            ],
        ];
    }

    public function get_custom_css_fields_config(){
        return [
            'dipi_accordion_content_wrapper' => [
                'label' => esc_html__('Content Wrapper', 'dipi-divi-pixel'),
                'selector' => '%%order_class%% .dipi_image_accordion_child_content_wrapper',
            ],
            'dipi_accordion_content' => [
                'label' => esc_html__('Content', 'dipi-divi-pixel'),
                'selector' => '%%order_class%% .dipi-accordion-content',
            ],
            'dipi_accordion_title' => [
                'label' => esc_html__('Title', 'dipi-divi-pixel'),
                'selector' => '%%order_class%% .dipi-accordion-title',
            ],
            'dipi_accordion_description' => [
                'label' => esc_html__('Description', 'dipi-divi-pixel'),
                'selector' => '%%order_class%% .dipi-accordion-description',
            ],
            'dipi_accordion_button_wrap' => [
                'label' => esc_html__('Button Wrapper', 'dipi-divi-pixel'),
                'selector' => '%%order_class%% .dipi-accordion-button-wrap',
            ],
            'dipi_accordion_button' => [
                'label' => esc_html__('Button', 'dipi-divi-pixel'),
                'selector' => '%%order_class%% .et_pb_button.dipi_accordion_button',
            ],
        ];
    }

    public function get_fields()
    {
        $fields = [];

        $fields['title'] = [
            'label'       => esc_html__('Admin Label', 'dipi-divi-pixel'),
            'description' => esc_html__('The label used to identify this item in the parent module.', 'dipi-divi-pixel'),
            'type'        => 'text',
            'toggle_slug' => 'accordion_bg'
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
        $fields['bg_img'] = [
            'type'               => 'upload',
            'hide_metadata'      => true,
            'choose_text'        => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text'        => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'description'        => esc_html__('Upload an image to display in the module.', 'dipi-divi-pixel'),
            'toggle_slug'        => 'accordion_bg',
            'dynamic_content' => 'image'
        ];

        $fields["use_onload_active"] = [
            'label' => esc_html__('Onload Active', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on'  => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'accordion',
            'mobile_options' => true,
        ];

        $fields["use_accordion_icon"] = [
            'label' => esc_html__('Use Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on'  => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'accordion',
        ];

        $fields["accordion_icon"] = [
            'label'       => esc_html__('Icon', 'dipi-divi-pixel'),
            'type'        => 'select_icon',
            'class'       => ['et-pb-font-icon'],
            'default'     => '1',
            'show_if' => [
                'use_accordion_icon' => 'on'
            ],
            'toggle_slug' => 'accordion',
        ];

        $fields['accordion_image'] = [
            'type'               => 'upload',
            'hide_metadata'      => true,
            'choose_text'        => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text'        => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'description'        => esc_html__('Upload an image to display in the module.', 'dipi-divi-pixel'),
            'show_if' => [
                'use_accordion_icon' => 'off'
            ],
            'toggle_slug'        => 'accordion',
            'dynamic_content' => 'image'
        ];

        $fields["img_alt"] = [
            'label'       => esc_html__( 'Image Alt Text', 'dipi-divi-pixel' ),
            'type'        => 'text',
            'description' => esc_html__( 'Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
            'show_if' => [
                'use_accordion_icon' => 'off'
            ],
            'toggle_slug'        => 'accordion',
            'dynamic_content' => 'text'
        ];

        $fields['accordion_image_width'] = [
            'label' => esc_html('Image Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '100px',
            'default_unit' => 'px',
            'default_on_front' => '100px',
            'allowed_units' => ['px'],
            'range_settings' => [
                'min'  => '1',
                'max'  => '1000',
                'step' => '10'
            ],
            'validate_unit' => true,
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'accordion_image_icon'
        ];

        $fields["accordion_title"] = [
            'label'       => esc_html__('Title', 'dipi-divi-pixel'),
            'type'        => 'text',
            'toggle_slug' => 'accordion',
            'dynamic_content' => 'text'
        ];

        $fields["accordion_description"] = [
            'label'           => esc_html__('Description', 'dipi-divi-pixel'),
            'type'            => 'tiny_mce',
            'toggle_slug'     => 'accordion',
            'dynamic_content' => 'text'
        ];

        $fields["show_accordion_button"] = [
            'default' => 'off',
            'label' => esc_html__('Show Button', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'accordion',
            'affects' => [
                'accordion_button_text',
                'accordion_button_link',
                'accordion_button_link_target'
            ],
        ];

        $fields["accordion_button_text"] = [
            'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
            'default' => esc_html__('Click Here', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'accordion',
            'dynamic_content' => 'text'
        ];

        $fields["accordion_button_link"] = [
            'label' => esc_html__('Button Link', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'accordion',
            'dynamic_content' => 'text'
        ];

        $fields["accordion_button_link_target"] = [
            'label' => esc_html__('Button Link Target', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'same_window',
            'options' => [
                'off' => esc_html__('Same Window', 'dipi-divi-pixel'),
                'on' => esc_html__('New Window', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'accordion',
        ];

        $fields["accordion_align_horizontal"] = [
            'label' => esc_html__('Horizontal Align', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'center',
            'options' => array(
                'left' => esc_html__('Left', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'right' => esc_html__('Right', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'accordion'
        ];

        $fields["accordion_align_vertical"] = [
            'label' => esc_html__('Vertical Align', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'center',
            'options' => array(
                'top' => esc_html__('Top', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'bottom' => esc_html__('Bottom', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'accordion'
        ];

        $fields["accordion_icon_color"] = [
            'label'           => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type'            => 'color-alpha',
            'tab_slug'        => 'advanced',
            'show_if' => [
                'use_accordion_icon' => 'on'
            ],
            'toggle_slug'     => 'accordion_image_icon'
        ];

        $fields["use_accordion_icon_circle"] = [
            'label'            => esc_html__('Show as Circle Icon', 'dipi-divi-pixel'),
            'type'             => 'yes_no_button',
            'options'          => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'use_accordion_icon' => 'on'
            ],
            'tab_slug'         => 'advanced',
            'toggle_slug'      => 'accordion_image_icon',
        ];

        $fields["accordion_icon_circle_color"] = [
            'label'           => esc_html__('Circle Color', 'dipi-divi-pixel'),
            'type'            => 'color-alpha',
            'validate_unit'   => true,
            'show_if' => [
                'use_accordion_icon' => 'on',
                'use_accordion_icon_circle' => 'on'
            ],
            'tab_slug'        => 'advanced',
            'toggle_slug'     => 'accordion_image_icon'
        ];

        $fields["use_accordion_icon_circle_border"] = [
            'label'           => esc_html__('Show Circle Border', 'dipi-divi-pixel'),
            'type'            => 'yes_no_button',
            'options'         => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on'  => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'use_accordion_icon' => 'on',
                'use_accordion_icon_circle' => 'on',
            ],
            'toggle_slug'       => 'accordion_image_icon',
            'tab_slug'          => 'advanced',
        ];

        $fields["accordion_icon_circle_border_color"] = [
            'label'           => esc_html__('Circle Border Color', 'dipi-divi-pixel'),
            'type'            => 'color-alpha',
            'show_if' => [
                'use_accordion_icon' => 'on',
                'use_accordion_icon_circle' => 'on',
                'use_accordion_icon_circle_border' => 'on',
            ],
            'tab_slug'        => 'advanced',
            'toggle_slug'     => 'accordion_image_icon',
        ];

        $fields["use_accordion_icon_font_size"] = [
            'label'           => esc_html__('Use Icon Font Size', 'dipi-divi-pixel'),
            'type'            => 'yes_no_button',
            'options'         => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on'  => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'use_accordion_icon' => 'on',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'accordion_image_icon',
        ];

        $fields["accordion_icon_font_size"] = [
            'label' => esc_html__('Icon Font Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '40px',
            'default_unit' => 'px',
            'default_on_front' => '40px',
            'allowed_units' => ['%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'],
            'show_if' => [
                'use_accordion_icon' => 'on',
                'use_accordion_icon_font_size' => 'on'
            ],
            'range_settings' => [
                'min'  => '1',
                'max'  => '150',
                'step' => '1',
            ],
            'validate_unit' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'accordion_image_icon'
        ];

        $fields['content_width'] = [
            'label' => esc_html('Content Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '100%',
            'default_unit' => '%',
            'range_settings' => [
                'min'  => '1',
                'max'  => '100',
                'step' => '1'
            ],
            'validate_unit' => true,
            'mobile_options' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'width'
        ];

        $additional_options = [];

        $additional_options['image_bg_color'] = [
            'label'             => esc_html__('Image Overlay', 'dipi-divi-pixel'),
            'type'              => 'background-field',
            'base_name'         => "image_bg",
            'context'           => "image_bg",
            'option_category'   => 'layout',
            'custom_color'      => true,
            'default'           => ET_Global_Settings::get_value('all_buttons_bg_color'),
            'tab_slug'          => 'advanced',
            'toggle_slug'       => "image",
            'hover'             => 'tabs',
            'background_fields' => array_merge(
                $this->generate_background_options(
                    'image_bg',
                    'gradient',
                    "advanced",
                    "image",
                    "image_bg_gradient"
                ),
                $this->generate_background_options(
                    "image_bg",
                    "color",
                    "advanced",
                    "image",
                    "image_bg_color"
                )
            )
        ];

        $additional_options = array_merge(
            $additional_options,
            $this->generate_background_options(
                "image_bg",
                'skip',
                "advanced",
                "image",
                "image_bg_gradient"
            )
        );

        $additional_options = array_merge(
            $additional_options,
            $this->generate_background_options(
                "image_bg",
                'skip',
                "advanced",
                "image",
                "image_bg_color"
            )
        );

        return array_merge($fields, $additional_options);
    }

    public function get_advanced_fields_config()
    {

        $advanced_fields = [];
        $advanced_fields["text"] = false;
        $advanced_fields["text_shadow"] = false;
        $advanced_fields["fonts"] = [];

        $advanced_fields['margin_padding'] = [
            'css' => [
              'margin' => '%%order_class%%',
              'padding' => '%%order_class%% .dipi_image_accordion_child_content_wrapper',
              'important' => 'all',
            ],
          ];

        $advanced_fields["fonts"]["accordion_title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-accordion-title",
            ],
            'hide_text_align' => true,
            'toggle_slug' => 'accordion_text',
            'sub_toggle'  => 'title',
            'line_height' => [
                'default' => '1em',
                'range_settings' => [
                    'min'  => '1',
                    'max'  => '3',
                    'step' => '0.1'
                ],
            ],
            'header_level' => [
                'default' => 'h3',
            ],
            'important' => 'all',
        ];

        $advanced_fields["fonts"]["accordion_desc"] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-accordion-description",
            ],
            'hide_text_align' => true,
            'line_height' => [
                'default' => '1em',
                'range_settings' => [
                    'min'  => '1',
                    'max'  => '3',
                    'step' => '0.1'
                ],
            ],
            'toggle_slug' => 'accordion_text',
            'sub_toggle'  => 'desc',
        ];

        $advanced_fields['borders']['accordion_img'] = [
            'label_prefix' => esc_html__('Accordion Image', 'dipi-divi-pixel'),
            'css' => [
                'main' => [
                    'border_radii'  => "%%order_class%% .dipi-accordion-image",
                    'border_styles' => "%%order_class%% .dipi-accordion-image",
                ],
            ],
            'depends_on'      => ['use_accordion_icon'],
            'depends_show_if' => 'off',
            'tab_slug'        => 'advanced',
            'toggle_slug'     => 'accordion_image_icon'
        ];

        $advanced_fields['box_shadow']['accordion_img'] = [
            'label' => esc_html__('Accordion Image', 'dipi-divi-pixel'),
            'css' => [
                'main' => '%%order_class%% .dipi-Accordion-image',
                'overlay' => 'inset',
            ],
            'show_if' => [
                'use_accordion_icon' => 'off',
                'content_type' => 'manual'
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'accordion_image_icon'
        ];

        $advanced_fields['button']["accordion_button"] = [
            'label' => esc_html__('Button', 'dipi-divi-pixel'),
            'use_alignment' => false,
            'css' => [
                'main' => "%%order_class%% .dipi_accordion_button",
                'important' => true,
            ],
            'box_shadow'  => [
                'css' => [
                    'main' => "%%order_class%% .dipi_accordion_button",
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'main' => "%%order_class%% .dipi_accordion_button.et_pb_button",
                    'important' => 'all',
                ],
            ],
        ];

        $advanced_fields['borders']['default'] = [
            'css' => [
                'main' => [
                    'border_radii'  => "%%order_class%%.dipi_image_accordion_child",
                    'border_styles' => "%%order_class%%.dipi_image_accordion_child"
                ],
            ]
        ];

        $advanced_fields['box_shadow']['default'] = [
            'css' => [
                'main' => '%%order_class%%'
            ]
        ];

        return $advanced_fields;
    }

    public function render($attrs, $content, $render_slug)
    {
        $this->_dipi_apply_css($render_slug);

        // Props
        $use_accordion_icon    = $this->props['use_accordion_icon'];
        $accordion_icon        = et_pb_process_font_icon($this->props['accordion_icon']);
        $accordion_image       = $this->props['accordion_image'];
        $img_alt               = $this->props['img_alt'];
        $accordion_title       = $this->props['accordion_title'];
        $accordion_description = $this->process_content($this->props['accordion_description']);
        $use_onload_active     = $this->props['use_onload_active'];
        $use_onload_active_tablet     = $this->props['use_onload_active_tablet'];
        $use_onload_active_phone     = $this->props['use_onload_active_phone'];
        $use_onload_active_responsive_status = $this->props['use_onload_active_last_edited'] && substr($this->props['use_onload_active_last_edited'], 0, 2) === "on";
        if (!$use_onload_active_responsive_status) {
            $use_onload_active_tablet     = $use_onload_active;
            $use_onload_active_phone     = $use_onload_active;
        }
        // Icon
        $accordion_icon = $accordion_icon !== '' ? sprintf(
            '<div class="dipi-accordion-image-icon">
                <span class="et-pb-icon et-pb-font-icon dipi-accordion-icon">
                    %1$s
                </span>
            </div>',
            esc_attr($accordion_icon)
        ) : '';

        if('on' === $use_accordion_icon){
            $this->dipi_generate_font_icon_styles($render_slug, 'accordion_icon', '%%order_class%% .dipi-accordion-icon');
        }

        // Imgae
        $accordion_image = $accordion_image !== '' ? sprintf(
            '<div class="dipi-accordion-image-icon">
                <img src="%1$s" class="dipi-accordion-image" alt="%2$s">
            </div>',
            $accordion_image,
            $img_alt
        ) : '';

        //Condition checking for icon and image
        $accordion_image_icon = 'on' === $use_accordion_icon ? $accordion_icon : $accordion_image;

        // Title
        $accordion_title_level = $this->props['accordion_title_level'] ? $this->props['accordion_title_level'] : 'h3';
        $accordion_title = $accordion_title !== '' ? sprintf(
            '<%2$s class="dipi-accordion-title">
                %1$s
            </%2$s>',
            $accordion_title,
            esc_attr($accordion_title_level)
        ) : '';

        // Description
        $accordion_description = $accordion_description !== '' ? sprintf(
            '<div class="dipi-accordion-description">
                %1$s
            </div>',
            $accordion_description
        ) : '';

        $show_accordion_button        = $this->props['show_accordion_button'];
        $accordion_button_text        = $this->props['accordion_button_text'];
        $accordion_button_link        = $this->props['accordion_button_link'];
        $accordion_button_rel         = $this->props['accordion_button_rel'];
        $accordion_button_icon        = $this->props['accordion_button_icon'];
        $accordion_button_link_target = $this->props['accordion_button_link_target'];
        $accordion_button_custom      = $this->props['custom_accordion_button'];

        $accordion_button = $this->render_button([
            'button_classname' => ["dipi_accordion_button"],
            'button_custom'    => $accordion_button_custom,
            'button_rel'       => $accordion_button_rel,
            'button_text'      => $accordion_button_text,
            'button_url'       => $accordion_button_link,
            'custom_icon'      => $accordion_button_icon,
            'url_new_window'   => $accordion_button_link_target,
            'has_wrapper'      => false,
        ]);

        $accordion_button  = 'on' === $show_accordion_button ? sprintf(
            '<div class="dipi-accordion-button-wrap">%1$s</div>',
            $accordion_button
        ) : '';

        return sprintf(
            '<div class="dipi-ia-image-bg">
                <div class="dipi_image_accordion_bg %8$s"></div>
                <div class="dipi_image_accordion_bg_hover"></div>
                <div class="dipi_image_accordion_child_content_wrapper dipi-align-horizontal-%6$s dipi-align-vertical-%7$s">
                    <div class="dipi-accordion-content" data-active-on-load="%5$s" data-active-on-load-tablet="%9$s" data-active-on-load-phone="%10$s">
                        %1$s
                        %2$s
                        %3$s
                        %4$s
                    </div>
                </div>
            </div>',
            $accordion_image_icon,
            $accordion_title,
            $accordion_description,
            $accordion_button,
            ('on' === $use_onload_active), //#5
            $this->props['accordion_align_horizontal'],
            $this->props['accordion_align_vertical'],
            isset($this->props['image_bg_color__hover_enabled']) && $this->startsWith($this->props['image_bg_color__hover_enabled'], 'on') ? 'dipi_hide_on_hover' : '',
            ('on' === $use_onload_active_tablet), 
            ('on' === $use_onload_active_phone) //#10
        );
    }


    public function _dipi_apply_css($render_slug)
    {
        $this->_dipi_image_width_css($render_slug);
        $this->_dipi_content_width_css($render_slug);
        $this->_dipi_accordion_icon_css($render_slug);
        $this->set_background_css(
            $render_slug,
            "%%order_class%% .dipi_image_accordion_bg",
            "%%order_class%% .dipi_image_accordion_bg_hover",
            'image_bg', 
            'image_bg_color'
        );

        ET_Builder_Element::set_style($render_slug, array(
            'selector'    => '%%order_class%% .dipi-ia-image-bg',
            'declaration' => "background-image: url({$this->props['bg_img']});"
        ));
    }

    private function _dipi_image_width_css($render_slug)
    {
        $accordion_image_width = $this->dipi_get_responsive_prop('accordion_image_width');
        
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-accordion-image",
            'declaration' => sprintf('width: %1$s !important;', $accordion_image_width['desktop']),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-accordion-image",
            'declaration' => sprintf('width: %1$s !important;', $accordion_image_width['tablet']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-accordion-image",
            'declaration' => sprintf('width: %1$s !important;', $accordion_image_width['phone']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767')
        ));
    }

    private function _dipi_content_width_css($render_slug)
    {
        $content_width = $this->dipi_get_responsive_prop('content_width');
        
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-accordion-content",
            'declaration' => sprintf('max-width: %1$s !important;', $content_width['desktop']),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-accordion-content",
            'declaration' => sprintf('max-width: %1$s !important;', $content_width['tablet']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980')
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-accordion-content",
            'declaration' => sprintf('max-width: %1$s !important;', $content_width['phone']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767')
        ));
    }

    private function _dipi_accordion_icon_css($render_slug)
    {

        $accordion_icon_color               = $this->props['accordion_icon_color'];
        $use_accordion_icon_circle          = $this->props['use_accordion_icon_circle'];
        $accordion_icon_circle_color        = $this->props['accordion_icon_circle_color'];
        $use_accordion_icon_circle_border   = $this->props['use_accordion_icon_circle_border'];
        $accordion_icon_circle_border_color = $this->props['accordion_icon_circle_border_color'];
        $use_accordion_icon_font_size       = $this->props['use_accordion_icon_font_size'];
        $accordion_icon_font_size           = $this->props['accordion_icon_font_size'];

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-accordion-icon',
            'declaration' => "color: {$accordion_icon_color} !important;"
        ]);

        if ('on' == $use_accordion_icon_circle) :
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-accordion-icon',
                'declaration' => "padding: 25px; border-radius: 100%; background-color: {$accordion_icon_circle_color} !important;"
            ]);
            if ('on' === $use_accordion_icon_circle_border) :
                ET_Builder_Element::set_style($render_slug, [
                    'selector' => '%%order_class%% .dipi-accordion-icon',
                    'declaration' => "border: 3px solid {$accordion_icon_circle_border_color};"
                ]);
            endif;
        endif;

        if ('on' == $use_accordion_icon_font_size) :
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-accordion-icon',
                'declaration' => "font-size: {$accordion_icon_font_size} !important;"
            ]);
        endif;
    }

    // FIXME: Re-implement this function the same way as in the jsx file. Not only is it hard to read, it's adding unnecessary overhead
    private function _dipi_accordion_image_bg_color_css($render_slug)
    {

        $image_bg_image            = [];
        $image_bg_style            = '';
        $use_image_bg_gradient     = $this->props["image_bg_use_color_gradient"];
        $image_bg_type             = $this->props["image_bg_color_gradient_type"];
        $image_bg_direction        = $this->props["image_bg_color_gradient_direction"];
        $image_bg_direction_radial = $this->props["image_bg_color_gradient_direction_radial"];
        $image_bg_start            = $this->props["image_bg_color_gradient_start"];
        $image_bg_end              = $this->props["image_bg_color_gradient_end"];
        $image_bg_start_position   = $this->props["image_bg_color_gradient_start_position"];
        $image_bg_end_position     = $this->props["image_bg_color_gradient_end_position"];
        $image_bg_colors_image     = $this->props["image_bg_color_gradient_overlays_image"];

        if ('on' === $use_image_bg_gradient) {

            $overlay_direction = $image_bg_type === 'linear' ? $image_bg_direction : "circle at $image_bg_direction_radial";
            $overlay_start_position = et_sanitize_input_unit($image_bg_start_position, false, '%');
            $overlay_end_position = et_sanitize_input_unit($image_bg_end_position, false, '%');
            $overlay_gradient_bg = "{$image_bg_type}-gradient($overlay_direction, {$image_bg_start} {$overlay_start_position},{$image_bg_end} {$overlay_end_position})";

            if (!empty($overlay_gradient_bg)) {
                $image_bg_image[] = $overlay_gradient_bg;
            }
        }

        if (!empty($image_bg_image)) {
            if ('on' !== $image_bg_colors_image) {
                $image_bg_image = array_reverse($image_bg_image);
            }

            $image_bg_style .= sprintf(
                'background-image: %1$s !important;',
                esc_html(join(', ', $image_bg_image))
            );
        }

        $image_bg_color = $this->props["image_bg_color"];
        if ('' !== $image_bg_color) {
            $image_bg_style .= sprintf(
                'background-color: %1$s !important; ',
                esc_html($image_bg_color)
            );
        }

        if ('' !== $image_bg_style) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dipi_image_accordion_bg",
                'declaration' => rtrim($image_bg_style),
            ));
        }
        


        // Overlay Hover        
        if ( et_builder_is_hover_enabled("image_bg_color", $this->props)) {

            $ob_image_hover = [];
            $ob_style_hover = '';

            if (isset($this->props["image_bg_use_color_gradient__hover"]) && 'on' === $this->props["image_bg_use_color_gradient__hover"]) {

                $ob_type_hover             = isset($this->props["image_bg_color_gradient_type__hover"]) ? $this->props["image_bg_color_gradient_type__hover"] : 'linear';
                $ob_direction_hover        = isset($this->props["image_bg_color_gradient_direction__hover"]) ? $this->props["image_bg_color_gradient_direction__hover"] : '180deg';
                $ob_direction_radial_hover = isset($this->props["image_bg_color_gradient_direction_radial__hover"]) ? $this->props["image_bg_color_gradient_direction_radial__hover"] : 'circle';
                $ob_start_hover            = isset($this->props["image_bg_color_gradient_start__hover"]) ? $this->props["image_bg_color_gradient_start__hover"] : '#2b87da';
                $ob_end_hover              = isset($this->props["image_bg_color_gradient_end__hover"]) ? $this->props["image_bg_color_gradient_end__hover"] : '#29c4a9';
                $ob_start_position_hover   = isset($this->props["image_bg_color_gradient_start_position__hover"]) ? $this->props["image_bg_color_gradient_start_position__hover"] : '0%';
                $ob_end_position_hover     = isset($this->props["image_bg_color_gradient_end_position__hover"]) ? $this->props["image_bg_color_gradient_end_position__hover"] : '100%';
                $ob_overlays_image_hover   = isset($this->props["image_bg_color_gradient_overlays_image__hover"]) ? $this->props["image_bg_color_gradient_overlays_image__hover"] : 'off';
                $overlay_direction_hover      = $ob_type_hover === 'linear' ? $ob_direction_hover : "circle at {$ob_direction_radial_hover}";
                $overlay_start_position_hover = et_sanitize_input_unit($ob_start_position_hover, false, '%');
                $overlay_end_position_hover   = et_sanitize_input_unit($ob_end_position_hover, false, '%');

                $overlay_gradient_bg_hover = "
                    {$ob_type_hover}-gradient($overlay_direction_hover,
                    {$ob_start_hover}
                    {$overlay_start_position_hover},
                    {$ob_end_hover}
                    {$overlay_end_position_hover}
                )";

                if (!empty($overlay_gradient_bg_hover)) {
                    $ob_image_hover[] = $overlay_gradient_bg_hover;
                }
            }

            if (!empty($ob_image_hover)) {
                if ('on' !== $ob_overlays_image_hover) {
                    $ob_image_hover = array_reverse($ob_image_hover);
                }
                $ob_style_hover .= sprintf(
                    'background-image: %1$s !important;',
                    esc_html(join(', ', $ob_image_hover))
                );
            }

            $ob_color_hover = isset($this->props["image_bg_color__hover"]) ? $this->props["image_bg_color__hover"] : '';
            if ('' !== $ob_color_hover) {
                $ob_style_hover .= sprintf(
                    'background-color: %1$s !important; ',
                    esc_html($ob_color_hover)
                );
            }

            if ('' !== $ob_style_hover) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dipi_image_accordion_bg_hover',
                    'declaration' => rtrim($ob_style_hover),
                ));
            }
        }

    }
}

new DIPI_ImageAccordionChild;
