<?php

class DIPI_ButtonGrid extends DIPI_Builder_Module
{
    protected $module_credits = [
        'module_uri' => 'https://divi-pixel.com/modules/button-grid',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    ];

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->slug = 'dipi_button_grid';
        $this->vb_support = 'on';
        $this->child_slug = 'dipi_button_grid_child';
        $this->name = esc_html__('Pixel Button Grid', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%.dipi_button_grid';
    }

    public function get_settings_modal_toggles()
    {
        return [
            'general' => [
                'toggles' => [
                    'flexbox' => esc_html__('Flex Settings', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'text_style' => esc_html__('Text Style', 'dipi-divi-pixel'),
                ],
            ],
        ];
    }

    public function get_custom_css_fields_config()
    {
        $fields = [];
        return $fields;
    }

    public function get_fields()
    {
        $fields = [];

        $fields['flex_direction'] = [
            'label' => esc_html__('Flex Direction', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'configuration',
            'default' => 'column',
            'options' => [
                'column' => esc_html__('Column', 'dipi-divi-pixel'),
                'row' => esc_html__('Row', 'dipi-divi-pixel'),
            ],
            'mobile_options' => true,
            'toggle_slug' => 'flexbox',
        ];

        $fields['flex_wrap'] = [
            'label' => esc_html__('Flex Wrap', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'default' => 'on',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'mobile_options' => true,
            'toggle_slug' => 'flexbox',
        ];

        $fields['justify_content'] = [
            'label' => esc_html__('Justify Content', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'configuration',
            'default' => 'center',
            'options' => [
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'flex-start' => esc_html__('Flex Start', 'dipi-divi-pixel'),
                'flex-end' => esc_html__('Flex End', 'dipi-divi-pixel'),
                'space-around' => esc_html__('Space Around', 'dipi-divi-pixel'),
                'space-between' => esc_html__('Space Between', 'dipi-divi-pixel'),
                'space-evenly' => esc_html__('Space Evenly', 'dipi-divi-pixel'),
            ],
            'mobile_options' => true,
            'toggle_slug' => 'flexbox',
        ];

        $fields['align_items'] = [
            'label' => esc_html__('Align Items', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'configuration',
            'default' => 'baseline',
            'options' => [
                'baseline' => esc_html__('Baseline', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'flex-start' => esc_html__('Flex Start', 'dipi-divi-pixel'),
                'flex-end' => esc_html__('Flex End', 'dipi-divi-pixel'),
            ],
            'mobile_options' => true,
            'toggle_slug' => 'flexbox',
        ];

        return $fields;
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = [];
        $advanced_fields["text"] = false;
        $advanced_fields["text_shadow"] = false;

        $advanced_fields['margin_padding'] = [
            'css' => [
                'margin' => '%%order_class%%',
                'padding' => '%%order_class%%',
                'important' => 'all',
            ],
        ];

        $advanced_fields['fonts']['text_style'] = [
            'css' => [
                'main' => "%%order_class%% .dipi-text-grid",
                'important' => 'all',
            ],
            'text_align' => [
                'default' => 'left',
            ],
            'font_size' => [
                'default' => '16px',
                'range_settings' => [
                    'min' => '1',
                    'max' => '50',
                    'step' => '1',
                ],
            ],
            'line_height' => [
                'default' => '1em',
                'range_settings' => [
                    'min' => '1',
                    'max' => '3',
                    'step' => '0.1',
                ],
            ],
            'toggle_slug' => 'text_style',
        ];

        $advanced_fields['button']["button_grid"] = [
            'label' => esc_html__('Button Style', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-button-grid",
                'important' => 'all',
            ],
            'hide_icon' => true,
            'use_alignment' => false,
            'box_shadow' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-button-grid",
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-button-grid",
                    'important' => 'all',
                ],
            ],
        ];

        return $advanced_fields;
    }

    public function render($attrs, $content, $render_slug)
    {
        $flex_direction = $this->dipi_get_responsive_prop('flex_direction');
        $justify_content = $this->dipi_get_responsive_prop('justify_content');
        $align_items = $this->dipi_get_responsive_prop('align_items');
        $flex_wrap_on = $this->dipi_get_responsive_prop('flex_wrap');

        $css_values = array(
            'desktop' => array(
                'flex-direction' => esc_html($flex_direction['desktop']),
                'justify-content' => esc_html($justify_content['desktop']),
                'align-items' => esc_html($align_items['desktop']),
                'flex-wrap' => esc_html($flex_wrap_on['desktop'] === 'on' ? 'wrap' : 'nowrap'),
            ),
            'tablet' => array(
                'flex-direction' => esc_html($flex_direction['tablet']),
                'justify-content' => esc_html($justify_content['tablet']),
                'align-items' => esc_html($align_items['tablet']),
                'flex-wrap' => esc_html($flex_wrap_on['tablet'] === 'on' ? 'wrap' : 'nowrap'),
            ),
            'phone' => array(
                'flex-direction' => esc_html($flex_direction['phone']),
                'justify-content' => esc_html($justify_content['phone']),
                'align-items' => esc_html($align_items['phone']),
                'flex-wrap' => esc_html($flex_wrap_on['phone'] === 'on' ? 'wrap' : 'nowrap'),
            ),
        );

        et_pb_responsive_options()->generate_responsive_css($css_values, '%%order_class%%  .dipi-button-grid-container', '', $render_slug, '', 'flex');

        $output = sprintf(
            '<div class="dipi-button-grid-container">
                %1$s
            </div>',
            et_core_sanitized_previously($this->content)
        );

        return $output;
    }
}

new DIPI_ButtonGrid();
