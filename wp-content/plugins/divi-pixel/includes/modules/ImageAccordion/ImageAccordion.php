<?php

class DIPI_ImageAccordion extends DIPI_Builder_Module
{

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/image-accordion',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->slug = 'dipi_image_accordion';
        $this->child_slug = 'dipi_image_accordion_child';
        $this->vb_support = 'on';
        $this->name = esc_html__('Pixel Image Accordion', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%';
    }

    public function get_settings_modal_toggles()
    {
        return [
            'general' => [
                'toggles' => [
                    'settings' => __('Settings', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [],
            ],
        ];
    }

    public function get_custom_css_fields_config()
    {
        $fields = [];

        $fields['accordion_container'] = [
            'label' => esc_html__('Accordion Container', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi_image_accordion_wrapper',
        ];

        $fields['accordion_image_icon'] = [
            'label' => esc_html__('Accordion Image/Icon', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-accordion-image-icon',
        ];

        $fields['accordion_title'] = [
            'label' => esc_html__('Content Title', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-accordion-title',
        ];

        $fields['accordion_description'] = [
            'label' => esc_html__('Content Description', 'dipi-divi-pixel'),
            'selector' => '%%order_class%% .dipi-accordion-description',
        ];

        return $fields;
    }

    public function get_fields()
    {
        $fields = [];

        $fields["accordion_style"] = [
            'label' => esc_html__('Accordion Style', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'on_hover',
            'options' => [
                'on_hover' => esc_html__('On Hover', 'dipi-divi-pixel'),
                'on_click' => esc_html__('On Click', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'settings',
        ];

        $fields["accordion_direction"] = [
            'label' => esc_html__('Accordion Direction', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'horizontal',
            'mobile_options' => true,
            'options' => [
                'horizontal' => esc_html__('Horizontal', 'dipi-divi-pixel'),
                'vertical' => esc_html__('Vertical', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'settings',
        ];

        $fields['accordion_height'] = [
            'label' => esc_html('Accordion Height', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '400px',
            'default_unit' => 'px',
            'range_settings' => [
                'min' => '1',
                'max' => '1200',
                'step' => '10',
            ],
            'validate_unit' => true,
            'mobile_options' => true,
            'toggle_slug' => 'settings',
        ];

        $fields['active_image_relative_width'] = [
            'label' => esc_html('Active Image Size', 'dipi-divi-pixel'),
            'description' => esc_html('Control how wide or high the active image will be in relation to the other images of the accordion.', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '5',
            'unitless' => true,
            'range_settings' => [
                'min' => '1',
                'max' => '10',
                'step' => '1',
            ],
            'validate_unit' => true,
            'mobile_options' => true,
            'toggle_slug' => 'settings',
        ];

        $fields["always_visible"] = [
            'label' => esc_html__('Always Visible', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'default' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'mobile_options' => true,
            'toggle_slug' => 'settings',
        ];
        $fields["always_visible_fields"] = [
            'label' => esc_html__('Always Visible Fields', 'dipi-divi-pixel'),
            'type' => 'multiple_checkboxes',
            'option_category' => 'configuration',
            'options' => [
                'icon_image' => esc_html__('Icon/Image', 'dipi-divi-pixel'),
                'title' => esc_html__('Title', 'dipi-divi-pixel'),
                'description' => esc_html__('Description', 'dipi-divi-pixel'),
                'button' => esc_html__('Button', 'dipi-divi-pixel'),
                
            ],
            'description'     => esc_html__( 'Choose what data (if any) to show always.', 'et_builder' ),
            'mobile_options' => true,
            'toggle_slug' => 'settings',
            'default' => 'on|on|on|off',
            'show_if' => [
                'always_visible' => 'on'
            ],
        ];

        return $fields;
    }

    public function get_advanced_fields_config()
    {

        $advanced_fields = [];
        $advanced_fields["text"] = false;
        $advanced_fields["text_shadow"] = false;
        $advanced_fields["fonts"] = false;

        return $advanced_fields;
    }

    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_image_accordion_public');
        
        $this->_dipi_apply_css($render_slug);

        return sprintf(
            '<div class="dipi_image_accordion_wrapper" data-accordion-type="%2$s">
                %1$s
            </div>',
            et_core_sanitized_previously($this->content),
            $this->props['accordion_style']
        );
    }

    public function _dipi_apply_css($render_slug)
    {
        $this->_dipi_accordion_height_css($render_slug);

        $accordion_direction = $this->dipi_get_responsive_prop('accordion_direction');
        $accordion_direction_desktop = $accordion_direction['desktop'];
        $accordion_direction_tablet = $accordion_direction['tablet'];
        $accordion_direction_phone = $accordion_direction['phone'];

        $active_image_relative_width_responsive_active = isset($this->props["active_image_relative_width_last_edited"]) ? et_pb_get_responsive_status($this->props["active_image_relative_width_last_edited"]) : false;
        $active_image_relative_width = (isset($this->props["active_image_relative_width"])) ? $this->props["active_image_relative_width"] : '';
        $active_image_relative_width_tablet = ($active_image_relative_width_responsive_active && isset($this->props["active_image_relative_width_tablet"])) ? $this->props["active_image_relative_width_tablet"] : $active_image_relative_width;
        $active_image_relative_width_phone = ($active_image_relative_width_responsive_active && isset($this->props["active_image_relative_width_phone"])) ? $this->props["active_image_relative_width_phone"]: $active_image_relative_width_tablet;
    
        $always_visible = $this->dipi_get_responsive_prop('always_visible');
        $always_visible_desktop = $always_visible['desktop'];
        $always_visible_tablet = $always_visible['tablet'];
        $always_visible_phone = $always_visible['phone'];
        $always_visible_fields = explode('|', $this->props['always_visible_fields']);
        $always_visible_fields_icon_image = $always_visible_fields[0];
        $always_visible_fields_title = $always_visible_fields[1];
        $always_visible_fields_description = $always_visible_fields[2];
        $always_visible_fields_button = $always_visible_fields[3];


        if ('vertical' == $accordion_direction_desktop):

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi_image_accordion_wrapper',
                'declaration' => "flex-direction: column;",
            ));

        elseif ('horizontal' == $accordion_direction_desktop):

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi_image_accordion_wrapper',
                'declaration' => "flex-direction: row;",
            ));

        endif;

        if ('vertical' == $accordion_direction_tablet):

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi_image_accordion_wrapper',
                'declaration' => "flex-direction: column;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

        elseif ('horizontal' == $accordion_direction_tablet):

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi_image_accordion_wrapper',
                'declaration' => "flex-direction: row;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));

        endif;

        if ('vertical' == $accordion_direction_phone):

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi_image_accordion_wrapper',
                'declaration' => "flex-direction: column;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

        elseif ('horizontal' == $accordion_direction_phone):

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi_image_accordion_wrapper',
                'declaration' => "flex-direction: row;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));

        endif;

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => '%%order_class%% .dipi-active',
            'declaration' => sprintf('flex: %1$s 0 auto !important;', $active_image_relative_width )
        ));
        if ( isset( $this->props['active_image_relative_width_tablet'] )) {
			ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-active',
                'declaration' => sprintf('flex: %1$s 0 auto !important;', $active_image_relative_width_tablet ),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
		}
		if ( isset( $this->props['active_image_relative_width_phone'] )) {
			ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-active',
                'declaration' => sprintf('flex: %1$s 0 auto !important;', $active_image_relative_width_phone ),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        if ( isset($always_visible_desktop) && $always_visible_desktop === "on") {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi_image_accordion_child .dipi-accordion-content',
                'declaration' => 'opacity: 1;',
            ));
            if ($always_visible_fields_icon_image === "on") {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dipi_image_accordion_child .dipi-accordion-image-icon',
                    'declaration' => 'opacity: 1;',
                ));
            }
            if ($always_visible_fields_title === "on") {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dipi_image_accordion_child .dipi-accordion-title',
                    'declaration' => 'opacity: 1;',
                ));
            }
            if ($always_visible_fields_description === "on") {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dipi_image_accordion_child .dipi-accordion-description',
                    'declaration' => 'opacity: 1;',
                ));
            }
            if ($always_visible_fields_button === "on") {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dipi_image_accordion_child .dipi-accordion-button-wrap',
                    'declaration' => 'opacity: 1;',
                ));
            }
        }
        if ( isset($always_visible_tablet) && $always_visible_tablet === "on") {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi_image_accordion_child .dipi-accordion-content',
                'declaration' => 'opacity: 1;',
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
            if ($always_visible_fields_icon_image === "on") {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dipi_image_accordion_child .dipi-accordion-image-icon',
                    'declaration' => 'opacity: 1;',
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                ));
            }
            if ($always_visible_fields_title === "on") {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dipi_image_accordion_child .dipi-accordion-title',
                    'declaration' => 'opacity: 1;',
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                ));
            }
            if ($always_visible_fields_description === "on") {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dipi_image_accordion_child .dipi-accordion-description',
                    'declaration' => 'opacity: 1;',
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                ));
            }
            if ($always_visible_fields_button === "on") {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dipi_image_accordion_child .dipi-accordion-button-wrap',
                    'declaration' => 'opacity: 1;',
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                ));
            }
        }
        if ( isset($always_visible_phone) && $always_visible_phone === "on") {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi_image_accordion_child .dipi-accordion-content',
                'declaration' => 'opacity: 1;',
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
            if ($always_visible_fields_icon_image === "on") {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dipi_image_accordion_child .dipi-accordion-image-icon',
                    'declaration' => 'opacity: 1;',
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ));
            }
            if ($always_visible_fields_title === "on") {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dipi_image_accordion_child .dipi-accordion-title',
                    'declaration' => 'opacity: 1;',
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ));
            }
            if ($always_visible_fields_description === "on") {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dipi_image_accordion_child .dipi-accordion-description',
                    'declaration' => 'opacity: 1;',
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ));
            }
            if ($always_visible_fields_button === "on") {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .dipi_image_accordion_child .dipi-accordion-button-wrap',
                    'declaration' => 'opacity: 1;',
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ));
            }
        }

    }

    private function _dipi_accordion_height_css($render_slug)
    {

        $height = $this->dipi_get_responsive_prop('accordion_height');

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi_image_accordion_wrapper",
            'declaration' => sprintf('height: %1$s !important;', $height['desktop']),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi_image_accordion_wrapper",
            'declaration' => sprintf('height: %1$s !important;', $height['tablet']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi_image_accordion_wrapper",
            'declaration' => sprintf('height: %1$s !important;', $height['phone']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));
    }
}

new DIPI_ImageAccordion;
