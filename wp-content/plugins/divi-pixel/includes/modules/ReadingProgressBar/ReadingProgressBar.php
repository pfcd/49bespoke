<?php
class DIPI_ReadingProgressBar extends DIPI_Builder_Module
{

    public $slug = 'dipi_reading_progress_bar';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/reading-progress-bar',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->vb_support = 'on';
        $this->name = esc_html__('Pixel Reading Progress Bar', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%.dipi_reading_progress_bar';
        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'general' => esc_html__('General', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'bar' => esc_html__('Bar', 'dipi-divi-pixel')
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

        $fields['bar_position'] = [
            'label' => esc_html__('Bar Display Position', 'dipi-divi-pixel'),
            'type'  => 'select',
            'default' => 'top',
            'options' => [
                'top' => esc_html__('Top of Page', 'dipi-divi-pixel'),
                'main' => esc_html__('Below Main Menu', 'dipi-divi-pixel'),
                'bottom' => esc_html__('Bottom of Page', 'dipi-divi-pixel')
            ],
            'toggle_slug'       => 'general'
        ];

        $fields['bar_animation'] = [
            'label' => esc_html__('Animation', 'dipi-divi-pixel'),
            'type'  => 'select',
            'default' => 'top',
            'options' => [
                'no' => esc_html__('No Animation', 'dipi-divi-pixel'),
                'striped' => esc_html__('Striped', 'dipi-divi-pixel'),
            ],
            'toggle_slug'       => 'general'
        ];

        $fields["bar_bg_color"] = [
            'label'             => esc_html__('Bar Background Color', 'dipi-divi-pixel'),
            'type'              => 'color-alpha',
            'default'           => '#fcfcfc',
            'tab_slug'        => 'advanced',
            'toggle_slug'       => 'bar'
        ];

        $fields["bar_color"] = [
            'label'             => esc_html__('Bar Color', 'dipi-divi-pixel'),
            'type'              => 'color-alpha',
            'default'           => '#7cda24',
            'tab_slug'        => 'advanced',
            'toggle_slug'       => 'bar'
        ];

        $fields["bar_striped_color"] = [
            'label'             => esc_html__('Bar Striped Color', 'dipi-divi-pixel'),
            'type'              => 'color-alpha',
            'default'           => '#edf000',
            'tab_slug'        => 'advanced',
            'toggle_slug'       => 'bar'
        ];

        $fields['bar_size'] = [
            'label' => esc_html('Bar Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '5px',
            'default_unit' => 'px',
            'range_settings' => [
                'min'  => '1',
                'max'  => '100',
                'step' => '1'
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'bar'
        ];

        return $fields;
    }

    public function get_advanced_fields_config()
    {

        $advanced_fields = [];
        $advanced_fields["text"] = false;
        $advanced_fields["text_shadow"] = false;
        $advanced_fields["fonts"] = false;
        $advanced_fields["link_options"] = false;
        $advanced_fields['margin_padding'] = false;

        $advanced_fields["box_shadow"]["default"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-reading-progress",
            ],
            'tab_slug' => 'advanced',
        ];

        $advanced_fields["borders"] = false;

        return $advanced_fields;
    }

    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_reading_progress_bar_public');
        $bar_position = $this->props['bar_position'];
        $bar_color = $this->props['bar_color'];
        $bar_bg_color = $this->props['bar_bg_color'];
        $module_classname = $this->module_classname( $render_slug );
        $bar_size = $this->props['bar_size'];
        $bar_animation = $this->props['bar_animation'];
        $bar_striped_color = $this->props['bar_striped_color'];

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-reading-progress, %%order_class%% .dipi-reading-progress-fill',
            'declaration' => "height: {$bar_size}!important;"
        ]);


        $striped_classes = '';
        if( 'striped' === $bar_animation ) {

            $stripe_bg = "linear-gradient(135deg, {$bar_striped_color} 25%, transparent 25%, transparent 50%, {$bar_striped_color} 50%, {$bar_striped_color} 75%, transparent 75%, transparent)";

            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .dipi-striped-color',
                'declaration' => "background-image: {$stripe_bg}; "
            ]);

            $striped_classes = 'dipi-progress-striped dipi-striped-color';

        }

        $output = sprintf(
            '<div class="%4$s dipi-reading-progress-wrap" data-position="%1$s" data-color="%2$s" data-bgcolor="%3$s">
                <div class="dipi-reading-progress dipi-reading-progress-%1$s">
                    <div class="dipi-reading-progress-fill %5$s"></div>
                </div>
            </div>',
            $bar_position,
            $bar_color,
            $bar_bg_color,
            $module_classname,
            $striped_classes
        );

        return $output;

	}
}

new DIPI_ReadingProgressBar;
