<?php

class DIPI_StarRating extends DIPI_Builder_Module
{

    public $slug = 'dipi_star_rating';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/star-rating',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__('Pixel Star Rating', 'dipi-divi-pixel');

        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'rating' => esc_html__('Rating', 'dipi-divi-pixel'),

                ],
            ],
            'advanced' => [
                'toggles' => [
                    'text' => [
                        'title' => esc_html__('Text', 'dipi-divi-pixel'),
                        'tabbed_subtoggles' => true,
                        'sub_toggles' => [
                            'title' => array(
                                'name' => esc_html__('Title', 'dipi-divi-pixel'),
                            ),
                            'description' => array(
                                'name' => esc_html__('Desc', 'dipi-divi-pixel'),
                            ),
                        ],
                    ],
                    'star' => esc_html__('Star', 'dipi-divi-pixel'),

                ],
            ],
        ];

        $this->custom_css_fields = array(
            'title' => array(
                'label' => esc_html__('Title', 'dipi-divi-pixel'),
                'selector' => '%%order_class%% .dipi-wrapper .dipi-title',
            ),
            'description' => array(
                'label' => esc_html__('Description', 'dipi-divi-pixel'),
                'selector' => '%%order_class%% .dipi-wrapper .dipi-description',
            ),
            'active_star' => array(
                'label' => esc_html__('Active Star', 'dipi-divi-pixel'),
                'selector' => '%%order_class%% .dipi-wrapper .dipi-star-full',
            ),
            'active_star_before' => array(
                'label' => esc_html__('Active Star Before', 'dipi-divi-pixel'),
                'selector' => '%%order_class%% .dipi-wrapper .dipi-star-full:before',
            ),
            'inactive_star' => array(
                'label' => esc_html__('Inactive Star', 'dipi-divi-pixel'),
                'selector' => '%%order_class%% .dipi-wrapper .dipi-star-empty',
            ),
            'rating_number' => array(
                'label' => esc_html__('Rating Number', 'dipi-divi-pixel'),
                'selector' => '%%order_class%% .dipi-wrapper .dipi-star-rating-number',
            ),
        );
    }

    public function get_fields()
    {

        $fields = [];

        $fields['title'] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'type' => 'text',
            'option_category' => 'basic_option',
            'toggle_slug' => 'rating',
            'description' => esc_html__('Title of the Star Rating', 'dipi-divi-pixel'),
            'dynamic_content' => 'text',
        ];

        $fields['description'] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'type' => 'textarea',
            'option_category' => 'basic_option',
            'toggle_slug' => 'rating',
            'description' => esc_html__('Description of the Star Rating', 'dipi-divi-pixel'),
            'dynamic_content' => 'text',
        ];

        $fields['rating_scale'] = [
            'label' => 'Rating scale',
            'type' => 'text',
            'option_category' => 'basic_option',
            'toggle_slug' => 'rating',
            'value_type' => 'float',
            'value_min' => 0,
            'value_type' => 100,
            'default_on_front' => 5,
            'description' => esc_html__('Enter rating scale or total number of star that you want to display', 'dipi-divi-pixel'),
            'dynamic_content' => 'text',
            'number_validation' => true,
        ];

        $fields['rating'] = [
            'label' => 'Rating',
            'type' => 'text',
            'option_category' => 'basic_option',
            'toggle_slug' => 'rating',
            'value_type' => 'float',
            'value_min' => 0,
            'value_type' => 100,
            'default_on_front' => 3,
            'description' => esc_html__('Enter current rating', 'dipi-divi-pixel'),
            'dynamic_content' => 'text',
            'number_validation' => true,

        ];

        $fields['display_type'] = [
            'label' => 'Display Type',
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'block',
            'options' => array(
                'inline' => esc_html__('Inline', 'dipi-divi-pixel'),
                'block' => esc_html__('Block', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'rating',
        ];

        $fields['show_rating_number'] = [
            'label' => esc_html__('Show Rating Number', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'on',
            'options' => array(
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'rating',
        ];

        $fields['alignment'] = [
            'label' => 'Alignment',
            'type' => 'select',
            'option_category' => 'basic_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'star',
            'default' => 'left',
            'options' => array(
                'left' => esc_html__('Left', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'right' => esc_html__('Right', 'dipi-divi-pixel'),
            ),
        ];

        $fields['star_rating_icon_size'] = [
            'label' => esc_html__('Star Rating Icon Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'star',
            'default' => '22px',
            'validate_unit' => true,
            'range_settings' => [
                'step' => 1,
                'min' => 5,
                'max' => 50,
            ],
        ];

        $fields['star_rating_icon_spacing'] = [
            'label' => esc_html__('Star Rating Icon Spacing', 'dipi-divi-pixel'),
            'type' => 'range',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'star',
            'default' => '0px',
            'validate_unit' => true,
            'range_settings' => [
                'step' => 1,
                'min' => 0,
                'max' => 50,
            ],
        ];

        $fields['active_rating_icon_color'] = [
            'label' => esc_html__('Active Rating Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'option_category' => 'basic_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'star',
            'default' => '#f0ad4e',
            'description' => esc_html__('Select active star rating icon color', 'dipi-divi-pixel'),
        ];

        $fields['inactive_rating_icon_color'] = [
            'label' => esc_html__('Inactive Rating Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'option_category' => 'basic_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'star',
            'default' => '#f0ad4e',
            'description' => esc_html__('Select inactive star rating icon color', 'dipi-divi-pixel'),
        ];

        $fields['star_rating_number_color'] = [
            'label' => esc_html__('Star Rating Number Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'option_category' => 'basic_option',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'star',
            'default' => '#000000',
            'description' => esc_html__('Select star rating number color', 'dipi-divi-pixel'),
        ];

        $fields['star_rating_number_size'] = [
            'label' => esc_html__('Star Rating Number Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'star',
            'default' => '18px',
            'validate_unit' => true,
            'range_settings' => [
                'step' => 1,
                'min' => 5,
                'max' => 50,
            ],
        ];

        return $fields;
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = [];
        $advanced_fields['text_shadow'] = false;
        $advanced_fields['fonts']['title'] = [

            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'toggle_slug' => 'text',
            'sub_toggle' => 'title',
            'css' => array(
                'main' => "%%order_class%% .dipi-title",
            ),
        ];

        $advanced_fields['fonts']['description'] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'toggle_slug' => 'text',
            'sub_toggle' => 'description',
            'css' => array(
                'main' => "%%order_class%% .dipi-description",
            ),
        ];

        $advanced_fields['link_options'] = false;
        $advanced_fields['box_shadow'] = false;
        $advanced_fields['borders'] = false;
        $advanced_fields['transform'] = false;

        return $advanced_fields;

    }

    public function render($attrs, $content, $render_slug)
    {

        ET_Builder_Element::set_style($render_slug, [
            'selector' => "%%order_class%% .dipi-wrapper .dipi-star-rating",
            'declaration' => "text-align: {$this->props['alignment']}; font-size: {$this->props['star_rating_icon_size']}",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => "%%order_class%% .dipi-wrapper .dipi-star-rating span:not(:last-of-type)",
            'declaration' => "margin-right: {$this->props['star_rating_icon_spacing']};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => "%%order_class%% .dipi-wrapper .dipi-star-rating span.dipi-star-full:before",
            'declaration' => "color: {$this->props['active_rating_icon_color']};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => "%%order_class%% .dipi-wrapper span.dipi-star-full",
            'declaration' => "color: {$this->props['active_rating_icon_color']};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => "%%order_class%% .dipi-wrapper .dipi-star-rating span.dipi-star-empty",
            'declaration' => "color: {$this->props['inactive_rating_icon_color']};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => "%%order_class%% .dipi-wrapper .dipi-star-rating .dipi-star-rating-number",
            'declaration' => "color: {$this->props['star_rating_number_color']}; font-size: {$this->props['star_rating_number_size']}",
        ]);

        $rating_scale = $this->props['rating_scale'];
        $rating = $this->props['rating'];
        $display_type = $this->props['display_type'];
        $show_rating_number = $this->props['show_rating_number'];

        $display_type_class = '';
        if ($display_type == 'block') {
            $display_type_class = ' display-type-block';
        } else {
            $display_type_class = ' display-type-inline';
        }

        $stars = '';
        $star_rating_class = '';
        $fraction = explode('.', $rating);
        for ($i = 1; $i <= $rating_scale; $i++) {
            if ($i <= $fraction[0]) {
                $star_rating_class = 'dipi-star-full';
            } else if ($i == (int)$fraction[0] + 1 && isset($fraction[1]) && $fraction[1] != '' && $fraction[1] != 0) {
                $star_rating_class = 'dipi-star-full dipi-star-' . $fraction[1];
            } else {
                $star_rating_class = 'dipi-star-empty';
            }
            $stars .= '<span class="' . $star_rating_class . '">☆</span>';
        }

        $rating_number = '';
        if ($show_rating_number === 'on') {
            $rating_number = '<span class="dipi-star-rating-number">(' . $rating . '/' . $rating_scale . ')</span>';
        }

        return sprintf(
            '<div class="dipi-wrapper%1$s">
                <h4 class="dipi-title">%2$s</h4>
                <div class="dipi-star-rating">
                    %3$s
                    %4$s
                </div>
                <p class="dipi-description">%5$s</p>
            </div>',
            $display_type_class,
            $this->props['title'],
            $stars,
            $rating_number,
            $this->props['description']
        );
    }
}

new DIPI_StarRating;
