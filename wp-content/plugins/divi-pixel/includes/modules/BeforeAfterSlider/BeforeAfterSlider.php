<?php

class DIPI_BeforeAfterSlider extends DIPI_Builder_Module
{

    public $slug = 'dipi_before_after_slider';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/before-after',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__('Pixel Before After Slider', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%.dipi_before_after_slider';
    }

    public function get_settings_modal_toggles()
    {
        return [
            'general' => [
                'toggles' => [
                    'image' => esc_html__('Images', 'dipi-divi-pixel'),
                    'slider' => esc_html__('Slider', 'dipi-divi-pixel'),
                    'handle' => esc_html__('Handle', 'dipi-divi-pixel'),
                    'labels' => esc_html__('Labels', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'slider' => esc_html__('Slider Line', 'dipi-divi-pixel'),
                    'handle' => esc_html__('Handle', 'dipi-divi-pixel'),
                    'labels' => esc_html__('Labels', 'dipi-divi-pixel'),
                    'overlay' => esc_html__('Overlay', 'dipi-divi-pixel'),
                ],
            ],
        ];
    }

    public function get_fields()
    {
        return array(
            'before_image' => array(
                'label' => esc_html__('Before Image', 'dipi-divi-pixel'),
                'type' => 'upload',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
                'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
                'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
                'description' => esc_html__('Upload an image to display in the module.', 'dipi-divi-pixel'),
                'toggle_slug' => 'image',
                'dynamic_content' => 'image'
            ),

            'before_image_alt' => array(
                'label' => esc_html__('Before Image Alt Text', 'dipi-divi-pixel'),
                'type' => 'text',
                'description' => esc_html__('Define the HTML ALT text for the image.', 'dipi-divi-pixel'),
                'toggle_slug' => 'image',
                'dynamic_content' => 'text'
            ),

            'after_image' => array(
                'label' => esc_html__('After Image', 'dipi-divi-pixel'),
                'type' => 'upload',
                'option_category' => 'basic_option',
                'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
                'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
                'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
                'description' => esc_html__('Upload an image to display in the module.', 'dipi-divi-pixel'),
                'toggle_slug' => 'image',
                'dynamic_content' => 'image'
            ),

            'after_image_alt' => array(
                'label' => esc_html__('After Image Alt Text', 'dipi-divi-pixel'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'description' => esc_html__('Define the HTML ALT text for the image.', 'dipi-divi-pixel'),
                'toggle_slug' => 'image',
                'dynamic_content' => 'text'
            ),

            /* Slider Settings Labels */
            'direction' => array(
                'label' => esc_html__('Slider Direction', 'dipi-divi-pixel'),
                'type' => 'select',
                'option_category' => 'basic_option',
                'options' => array(
                    'horizontal' => 'Horizontal',
                    'vertical' => 'Vertical',
                ),
                'toggle_slug' => 'slider',
                'default' => 'horizontal',
                'description' => esc_html__('The direction of the slider.', 'dipi-divi-pixel'),
            ),
            'move_slider' => array(
                'label' => esc_html__('Move Slider', 'dipi-divi-pixel'),
                'type' => 'select',
                'option_category' => 'basic_option',
                'options' => array(
                    'with_handle' => 'With Only Handle',
                    'on_click' => 'On Click',
                    'on_hover' => 'On Hover',
                ),
                'toggle_slug' => 'slider',
                'default' => 'on_click',
            ),
            'handle_icon' => array(
                'label' => esc_html__('Handle Icon', 'dipi-divi-pixel'),
                'type' => 'select',
                'option_category' => 'basic_option',
                'options' => array(
                    'triangle' => 'Triangle',
                    'arrow' => 'Arrow',
                ),
                'toggle_slug' => 'handle',
                'default' => 'triangle',
            ),
            'before_label' => array(
                'label' => esc_html__('Before Label', 'dipi-divi-pixel'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'toggle_slug' => 'labels',
                'description' => esc_html__('The label for the before image.', 'dipi-divi-pixel'),
                'default' => esc_html__('Before', 'dipi-divi-pixel'),
                'dynamic_content' => 'text'
            ),

            'after_label' => array(
                'label' => esc_html__('After Label', 'dipi-divi-pixel'),
                'type' => 'text',
                'option_category' => 'basic_option',
                'toggle_slug' => 'labels',
                'description' => esc_html__('The label for the after image.', 'dipi-divi-pixel'),
                'default' => esc_html__('After', 'dipi-divi-pixel'),
                'dynamic_content' => 'text'
            ),

            'always_show_labels' => array(
                'label' => esc_html__('Always Show Label', 'dipi-divi-pixel'),
                'type' => 'yes_no_button',
                'option_category' => 'basic_option',
                'toggle_slug' => 'labels',
                'default' => 'off',
                'options'           => array(
                    'off' => esc_html__( 'Off', 'dipi-divi-pixel' ),
                    'on'  => esc_html__( 'On', 'dipi-divi-pixel' ),
                  ),
                'description' => esc_html__('Whether to always show the labels or only show them on hover.', 'dipi-divi-pixel'),
            ),

            //TODO: Label BG, Label Padding, Label Border Radius

            'before_label_bg_color' => [
                'label' => esc_html__('Before Label Bg Color', 'dipi-divi-pixel'),
                'type' => 'color-alpha',
                'default' => "rgba(255, 255, 255, 0.2)",
                'toggle_slug' => 'labels',
                'tab_slug' => 'advanced',
            ],

            'after_label_bg_color' => [
                'label' => esc_html__('After Label Bg Color', 'dipi-divi-pixel'),
                'type' => 'color-alpha',
                'default' => "rgba(255, 255, 255, 0.2)",
                'toggle_slug' => 'labels',
                'tab_slug' => 'advanced',
            ],

            /* Slider Settings Overlay */
            'enable_overlay' => array(
                'label' => esc_html__('Enable Overlay', 'dipi-divi-pixel'),
                'type' => 'yes_no_button',
                'toggle_slug' => 'overlay',
                'tab_slug' => 'advanced',
                'default' => 'on',
                'options'           => array(
                    'off' => esc_html__( 'Off', 'dipi-divi-pixel' ),
                    'on'  => esc_html__( 'On', 'dipi-divi-pixel' ),
                  ),
                'description' => esc_html__('Whether or not to show the overlay on hover.', 'dipi-divi-pixel'),
            ),

            'overlay_color' => [
                'label' => esc_html__('Overlay  Color', 'dipi-divi-pixel'),
                'type' => 'color-alpha',
                'default' => "rgba(0, 0, 0, 0.5)",
                'toggle_slug' => 'overlay',
                'tab_slug' => 'advanced',
            ],
            'overlay_visibility' => [
                'label' => esc_html__('Overlay Visibility', 'dipi-divi-pixel'),
                'type' => 'select',
                'option_category' => 'layout',
                'options' => array(
                    'show_on_hover' => 'Show on Hover',
                    'hide_on_hover' => 'Hide on Hover',
                ),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'overlay',
                'default' => 'show_on_hover',
                'show_if' => [
                    'enable_overlay' => 'on',
                ],
            ],
            /* Slider Settings General */
            'offset' => array(
                'label' => esc_html__('Slider Start Offset', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'layout',
                'default' => '50',
                'toggle_slug' => 'slider',
                'tab_slug' => 'advanced',
                'unitless' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'description' => esc_html__('The initial offset of the slider in percent.', 'dipi-divi-pixel'),
            ),
            
            'slider_color' => [
                'label' => esc_html__('Slider Line Color', 'dipi-divi-pixel'),
                'type' => 'color-alpha',
                'default' => "#ffffff",
                'toggle_slug' => 'slider',
                'tab_slug' => 'advanced',
            ],
            'slider_width' => [
                'label' => esc_html__('Slider Line Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'default' => '4px',
                'default_unit' => 'px',
                'allowed_units' => ['px'],
                'range_settings' => [
                    'min' => '1',
                    'max' => '100',
                    'step' => '1',
                ],
                'mobile_options' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider',
            ],
            
            /* Handle Settings */
            'slider_handle_icon_color' => [
                'label' => esc_html__('Handle Icon Color', 'dipi-divi-pixel'),
                'type' => 'color-alpha',
                'toggle_slug' => 'handle',
                'tab_slug' => 'advanced',
                'default' => "#ffffff",
            ],
            'handle_container_bg_blur' => [
                'label' => esc_html__('Handle Background Blur', 'dipi-divi-pixel'),
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
                'toggle_slug' => 'handle',
            ],
            'handle_use_circle' => [
				'label' => esc_html__('Circle Border', 'dipi-divi-pixel'),
				'type' => 'yes_no_button',
				'option_category' => 'configuration',
				'options' => array(
						'off' => esc_html__('No', 'dipi-divi-pixel'),
						'on' => esc_html__('Yes', 'dipi-divi-pixel'),
				),
				'tab_slug' => 'advanced',
				'toggle_slug' => 'handle',
				'description' => esc_html__('Here you can choose whether icon set above should display within a circle.', 'dipi-divi-pixel'),
				'default' => 'on',
            ],
            'slider_handle_color' => [
                'default' => '#fff',
                'label' => esc_html__('Handle Circle Border Color', 'dipi-divi-pixel'),
                'type' => 'color-alpha',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'handle',
                'hover' => 'tabs',
                'mobile_options' => true,
                'sticky' => true,
                'show_if' => [
                    'handle_use_circle' => 'on',
                ],
            ],
            'slider_handle_bg_color' => [
                'label' => esc_html__('Handle Background Color', 'dipi-divi-pixel'),
                'type' => 'color-alpha',
                'toggle_slug' => 'handle',
                'tab_slug' => 'advanced',
                'show_if' => [
                    'handle_use_circle' => 'on',
                ],
            ],
            'handle_circle_size' => [
                'label' => esc_html__('Handle Circle Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'configuration',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'handle',
                'default' => '38px',
                'default_unit' => 'px',
                'default_on_front' => '38px',
                'allowed_units' => array('px'),
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'sticky' => true,
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => [
                    'handle_use_circle' => 'on',
                ],
            ],
            'handle_circle_border_width' => [
                'label' => esc_html__('Handle Circle Border Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'configuration',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'handle',
                'default' => '4px',
                'default_unit' => 'px',
                'default_on_front' => '4px',
                'allowed_units' => array('em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'range_settings' => array(
                    'min' => '0',
                    'max' => '50',
                    'step' => '1',
                ),
                'sticky' => true,
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => [
                    'handle_use_circle' => 'on',
                ],
            ],
            'handle_circle_border_style' => [
                'label' => esc_html__('Handle Circle Border Style', 'dipi-divi-pixel'),
                'type' => 'select',
                'option_category' => 'layout',
                'options' => et_builder_get_border_styles(),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'handle',
                'default' => 'solid',
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => [
                    'handle_use_circle' => 'on',
                ],
            ],
            'handle_icon_size' => [
                'label' => esc_html__('Handle Icon Size', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'configuration',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'handle',
                'default' => '6px',
                'default_unit' => 'px',
                'default_on_front' => '6px',
                'allowed_units' => array('px'),
                'range_settings' => array(
                    'min' => '0',
                    'max' => '50',
                    'step' => '1',
                ),
                'sticky' => true,
                'mobile_options' => true,
                'hover' => 'tabs',
            ],
            'handle_icon_arrow_width' => [
                'label' => esc_html__('Handle Arrow Icon Width', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'configuration',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'handle',
                'default' => '3px',
                'default_unit' => 'px',
                'default_on_front' => '3px',
                'allowed_units' => array('px'),
                'range_settings' => array(
                    'min' => '0',
                    'max' => '50',
                    'step' => '1',
                ),
                'sticky' => true,
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => [
                    'handle_icon' => 'arrow'
                ]
            ],
            'handle_icon_gap' => array(
                'label' => esc_html__('Handle Icon Gap', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'layout',
                'default' => '6px',
                'default_unit' => 'px',
                'default_on_front' => '6px',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'handle',
                'unitless' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
            ),
            'handle_hover_icon_gap' => array(
                'label' => esc_html__('Handle Icon Gap on Hover', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'layout',
                'default' => '6px',
                'default_unit' => 'px',
                'default_on_front' => '6px',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'handle',
                'unitless' => true,
                'range_settings' => array(
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ),
                'mobile_options' => true,
            ),

            

        );
    }

    public function get_advanced_fields_config()
    {
        return [

            'fonts' => false,
            'text' => false,
            'text_shadow' => false,

            'fonts' => [
                'labels' => [
                    'label' => esc_html__('Title', 'dipi-divi-pixel'),
                    'css' => [
                        'main' => "{$this->main_css_element} .dipi_before_after_slider_after_label_span,{$this->main_css_element} .dipi_before_after_slider_before_label_span",
                    ],
                    'important' => 'all',
                    'toggle_slug' => 'labels',
                    'hide_text_align' => true
                ],
            ],
            'borders' => [
                'slider_line' => [
                    'label_prefix' => esc_html__('Slider Line', 'dipi-divi-pixel'),
                    'css' => [
                        'main' => [
                            'border_radii' => "%%order_class%% .dipi_before_after_slider_vertical .dipi_before_after_slider_handle:before, %%order_class%% .dipi_before_after_slider_vertical .dipi_before_after_slider_handle:after, %%order_class%% .dipi_before_after_slider_horizontal .dipi_before_after_slider_handle:before, %%order_class%% .dipi_before_after_slider_horizontal .dipi_before_after_slider_handle:after",
                            'border_styles' => "%%order_class%% .dipi_before_after_slider_vertical .dipi_before_after_slider_handle:before, %%order_class%% .dipi_before_after_slider_vertical .dipi_before_after_slider_handle:after, %%order_class%% .dipi_before_after_slider_horizontal .dipi_before_after_slider_handle:before, %%order_class%% .dipi_before_after_slider_horizontal .dipi_before_after_slider_handle:after",
                        ],
                    ],
                    'defaults' => [
                        'border_radii' => 'on|0px|0px|0px|0px',
                        'border_styles' => array(
                            'width' => '0px',
                            'style' => 'solid'
                        )
                    ],
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'slider',
                ]
            ]

        ];
    }

    public function get_custom_css_fields_config(){
        return [
            'dss_image_before' => [
                'label' => 'Before Image',
                'selector' => '%%order_class%% .dipi_before_after_slider_before',
            ],
            'dss_image_after' => [
                'label' => 'After Image',
                'selector' => '%%order_class%% .dipi_before_after_slider_after',
            ],
            'dss_label_before' => [
                'label' => 'Before Label',
                'selector' => '%%order_class%% .dipi_before_after_slider_overlay .dipi_before_after_slider_before_label_span',
            ],
            'dss_label_after' => [
                'label' => 'After Label',
                'selector' => '%%order_class%% .dipi_before_after_slider_overlay .dipi_before_after_slider_after_label_span',
            ],
            'slider_line' => [
                'label' => 'Slider Line',
                'selector' => '%%order_class%% .dipi_before_after_slider_vertical .dipi_before_after_slider_handle:before, %%order_class%% .dipi_before_after_slider_vertical .dipi_before_after_slider_handle:after, %%order_class%% .dipi_before_after_slider_horizontal .dipi_before_after_slider_handle:before, %%order_class%% .dipi_before_after_slider_horizontal .dipi_before_after_slider_handle:after',
            ],
            'h_slider_line' => [
                'label' => 'Horizontal Slider Line',
                'selector' => '%%order_class%% .dipi_before_after_slider_horizontal .dipi_before_after_slider_handle:before, %%order_class%% .dipi_before_after_slider_horizontal .dipi_before_after_slider_handle:after',
            ],
            'v_slider_line' => [
                'label' => 'Vertical Slider Line',
                'selector' => '%%order_class%% .dipi_before_after_slider_vertical .dipi_before_after_slider_handle:before, %%order_class%% .dipi_before_after_slider_vertical .dipi_before_after_slider_handle:after',
            ],
            'handle_container' => [
                'label' => 'Handle Container',
                'selector' => '%%order_class%% .dipi_before_after_slider_handle',
            ],
            'dss_overlay' => [
                'label' => 'Overlay',
                'selector' => '%%order_class%% .dipi_before_after_slider_overlay',
            ],
        ];
    }

    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_before_after_slider_public');
        $options = htmlspecialchars(json_encode($this->dipi_before_after_slider()), ENT_QUOTES, 'UTF-8');
        $handle_icon = $this->props['handle_icon'];
        $handle_use_circle = $this->props['handle_use_circle'];
        $move_slider = $this->props['move_slider'];
        $overlay_visibility = $this->props['overlay_visibility'];
        $extra_classes[] = '';
        $extra_classes[] = "{$handle_icon}-handle_icon";
        if($handle_use_circle === 'off') {
            $extra_classes[] = 'no_circle_handle';
        }
        if ($move_slider === 'with_handle') {
            $extra_classes[] = 'move_with_handle';
        }
        $extra_classes[] = "$overlay_visibility-overlay";
        $this->render_css($render_slug);

        return sprintf(
            '<div class="dipi_before_after_slider_container %2$s" data-options="%1$s">
            </div>',
            $options,
            implode(' ', $extra_classes)
        );
    }

    public function dipi_before_after_slider()
    {
        return [
            "before_image"     => $this->props["before_image"],
            "before_image_alt" => $this->props["before_image_alt"],
            "before_label"     => $this->props["before_label"],
            "after_image"      => $this->props["after_image"],
            "after_image_alt"  => $this->props["after_image_alt"],
            "after_label"      => $this->props["after_label"],
            "offset"           => $this->props["offset"],
            "direction"        => $this->props["direction"],
            "move_slider"   => $this->props["move_slider"]
        ];
    }

    public function render_css($render_slug){
        $slider_selector = "%%order_class%% .dipi_before_after_slider_handle:before, %%order_class%%  .dipi_before_after_slider_handle:after";
        $before_slider_selector = "%%order_class%% .dipi_before_after_slider_handle:before";
        $after_slider_selector = "%%order_class%%  .dipi_before_after_slider_handle:after";
        $h_slider_selector = "%%order_class%% .dipi_before_after_slider_horizontal .dipi_before_after_slider_handle:before, %%order_class%% .dipi_before_after_slider_horizontal .dipi_before_after_slider_handle:after";
        $h_slider_before_selector = "%%order_class%% .dipi_before_after_slider_horizontal .dipi_before_after_slider_handle:before";
        $h_slider_after_selector = "%%order_class%%  .dipi_before_after_slider_horizontal .dipi_before_after_slider_handle:after";
        $v_slider_selector = "%%order_class%% .dipi_before_after_slider_vertical .dipi_before_after_slider_handle:before, %%order_class%% .dipi_before_after_slider_vertical .dipi_before_after_slider_handle:after";
        $v_slider_before_selector = "%%order_class%% .dipi_before_after_slider_vertical .dipi_before_after_slider_handle:before";
        $v_slider_after_selector = "%%order_class%%  .dipi_before_after_slider_vertical .dipi_before_after_slider_handle:after";
        $handle_selector = "%%order_class%% .dipi_before_after_slider_handle";
        $handle_arrow_selector = "%%order_class%%  .dipi_before_after_slider_left_arrow, 
            %%order_class%%  .dipi_before_after_slider_right_arrow,
            %%order_class%%  .dipi_before_after_slider_down_arrow,
            %%order_class%%  .dipi_before_after_slider_up_arrow
            ";
        $handle_arrow_arrow_selector = "%%order_class%% .arrow-handle_icon .dipi_before_after_slider_left_arrow, 
            %%order_class%% .arrow-handle_icon .dipi_before_after_slider_right_arrow,
            %%order_class%% .arrow-handle_icon .dipi_before_after_slider_down_arrow,
            %%order_class%% .arrow-handle_icon .dipi_before_after_slider_up_arrow
            ";
        $handle_left_arrow_selector = "%%order_class%% .dipi_before_after_slider_handle .dipi_before_after_slider_left_arrow";
        $handle_right_arrow_selector = "%%order_class%% .dipi_before_after_slider_handle .dipi_before_after_slider_right_arrow";
        $handle_up_arrow_selector = "%%order_class%% .dipi_before_after_slider_handle .dipi_before_after_slider_up_arrow";
        $handle_down_arrow_selector = "%%order_class%% .dipi_before_after_slider_handle .dipi_before_after_slider_down_arrow";
        $handle_hover_left_arrow_selector = "%%order_class%% .dipi_before_after_slider_container:not(.move_with_handle):hover .dipi_before_after_slider_left_arrow,
            %%order_class%% .dipi_before_after_slider_handle:hover .dipi_before_after_slider_left_arrow";
        $handle_hover_right_arrow_selector = "%%order_class%% .dipi_before_after_slider_container:not(.move_with_handle):hover .dipi_before_after_slider_right_arrow,
            %%order_class%% .dipi_before_after_slider_handle:hover .dipi_before_after_slider_right_arrow";
        $handle_hover_up_arrow_selector = "%%order_class%% .dipi_before_after_slider_container:not(.move_with_handle):hover .dipi_before_after_slider_up_arrow,
            %%order_class%% .dipi_before_after_slider_handle:hover .dipi_before_after_slider_up_arrow";
        $handle_hover_down_arrow_selector = "%%order_class%% .dipi_before_after_slider_container:not(.move_with_handle):hover .dipi_before_after_slider_down_arrow,
            %%order_class%% .dipi_before_after_slider_handle:hover .dipi_before_after_slider_down_arrow";
        if("on" === $this->props["always_show_labels"]) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => "%%order_class%% .dipi_before_after_slider_overlay .dipi_before_after_slider_after_label_span, %%order_class%% .dipi_before_after_slider_overlay .dipi_before_after_slider_before_label_span",
                'declaration' => "opacity: 1 !important;",
            ]);
        }

        ET_Builder_Element::set_style($render_slug, [
            'selector' => "%%order_class%% .dipi_before_after_slider_overlay .dipi_before_after_slider_before_label_span",
            'declaration' => "background: {$this->props['before_label_bg_color']};",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => "%%order_class%% .dipi_before_after_slider_overlay .dipi_before_after_slider_after_label_span",
            'declaration' => "background: {$this->props['after_label_bg_color']};",
        ]);
        
        if("on" ===$this->props["enable_overlay"]) {            
            ET_Builder_Element::set_style($render_slug, [
                'selector' => "%%order_class%% .dipi_before_after_slider_container:not(.hide_on_hover-overlay) .dipi_before_after_slider_overlay:hover,
                    %%order_class%% .hide_on_hover-overlay .dipi_before_after_slider_handle:not(:hover) ~ .dipi_before_after_slider_overlay:not(:hover)
                    ",
                'declaration' => "background: {$this->props['overlay_color']};",
            ]);
        }

        //Slider handle color
        ET_Builder_Element::set_style($render_slug, [
            'selector' => "%%order_class%% .dipi_before_after_slider_handle:before, %%order_class%%  .dipi_before_after_slider_handle:after",
            'declaration' => "background: {$this->props['slider_color']};"
        ]);
        // Horizontal
        $this->generate_styles(
            array(
                'base_attr_name' => 'slider_width',
                'selector' => $h_slider_selector,
                'css_property' => 'width',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        $this->dipi_apply_custom_style(
            $this->slug,
            'slider_width',
            'margin-left',
            $h_slider_selector,
            true,
            -0.5,
            'px'
        );
        // Vertical
        $this->generate_styles(
            array(
                'base_attr_name' => 'slider_width',
                'selector' => $v_slider_selector,
                'css_property' => 'height',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        $this->dipi_apply_custom_style(
            $this->slug,
            'slider_width',
            'margin-top',
            $v_slider_selector,
            true,
            -0.5,
            'px'
        );


        ET_Builder_Element::set_style($render_slug, [
            'selector' => "%%order_class%% .dipi_before_after_slider_handle",
            'declaration' => "border-color: {$this->props['slider_handle_color']};"
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => "%%order_class%% .dipi_before_after_slider_handle",
            'declaration' => "background: {$this->props['slider_handle_bg_color']};"
        ]);

        //Arrow of handle
        ET_Builder_Element::set_style($render_slug, [
            'selector' => "%%order_class%% .dipi_before_after_slider_left_arrow",
            'declaration' => "border-right-color: {$this->props['slider_handle_icon_color']};"
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => "%%order_class%% .dipi_before_after_slider_right_arrow",
            'declaration' => "border-left-color: {$this->props['slider_handle_icon_color']};"
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => "%%order_class%% .dipi_before_after_slider_up_arrow",
            'declaration' => "border-bottom-color: {$this->props['slider_handle_icon_color']};"
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => "%%order_class%% .dipi_before_after_slider_down_arrow",
            'declaration' => "border-top-color: {$this->props['slider_handle_icon_color']};"
        ]);
        $this->generate_styles(
            array(
                'base_attr_name' => 'slider_handle_icon_color',
                'selector' => $handle_arrow_arrow_selector,
                'css_property' => 'border-color',
                'render_slug' => $render_slug,
                'type' => 'color',
            )
        );
        $this->dipi_apply_custom_style(
            $this->slug,
            'handle_container_bg_blur',
            'backdrop-filter',
            $handle_selector,
            false,
            1,
            'px',
            'blur'
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'handle_icon_size',
                'selector' => $handle_arrow_selector,
                'css_property' => 'border-width',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'handle_icon_arrow_width',
                'selector' => $handle_arrow_arrow_selector,
                'css_property' => 'border-width',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        
        $this->generate_styles(
            array(
                'base_attr_name' => 'handle_icon_size',
                'selector' => $handle_arrow_arrow_selector,
                'css_property' => 'width',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'handle_icon_size',
                'selector' => $handle_arrow_arrow_selector,
                'css_property' => 'height',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        
        $handle_icon_gap_last_edited  = $this->props['handle_icon_gap_last_edited'];
        $handle_icon_gap_responsive_status = et_pb_get_responsive_status($handle_icon_gap_last_edited);
        $handle_icon_gap = $this->props['handle_icon_gap'];
        
        
        if('' !== $handle_icon_gap) {
            $handle_icon_gap_int = intval($handle_icon_gap);
            $handle_icon_gap_int_1 = intval($handle_icon_gap) - 1;
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $handle_left_arrow_selector,
                'declaration' => "left: calc(50% - {$handle_icon_gap_int_1}px);",
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $handle_right_arrow_selector,
                'declaration' => "right: calc(50% - {$handle_icon_gap_int}px);",
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $handle_up_arrow_selector,
                'declaration' => "top: calc(50% - {$handle_icon_gap_int}px);",
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $handle_down_arrow_selector,
                'declaration' => "bottom: calc(50% - {$handle_icon_gap_int}px);",
            ));
            
        }

        if ($handle_icon_gap_responsive_status) {
            $handle_icon_gap_tablet = ($this->props['handle_icon_gap_tablet']) ? $this->props['handle_icon_gap_tablet'] : $handle_icon_gap;
            $handle_icon_gap_phone = ($this->props['handle_icon_gap_phone']) ? $this->props['handle_icon_gap_phone'] : $handle_icon_gap_tablet;
            if($handle_icon_gap_tablet) {
                $handle_icon_gap_tablet_int = intval($handle_icon_gap_tablet);
                $handle_icon_gap_tablet_int_1 = intval($handle_icon_gap_tablet) - 1;
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector' => $handle_left_arrow_selector,
                    'declaration' => "left: calc(50% - {$handle_icon_gap_tablet_int_1}px);",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980')
                ));
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector' => $handle_right_arrow_selector,
                    'declaration' => "right: calc(50% - {$handle_icon_gap_tablet_int}px);",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980')
                ));
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector' => $handle_up_arrow_selector,
                    'declaration' => "top: calc(50% - {$handle_icon_gap_tablet_int}px);",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980')
                ));
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector' => $handle_down_arrow_selector,
                    'declaration' => "bottom: calc(50% - {$handle_icon_gap_tablet_int}px);",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980')
                ));
            }
            if($handle_icon_gap_phone !== '') {
                $handle_icon_gap_phone_int = intval($handle_icon_gap_phone);
                $handle_icon_gap_phone_int_1 = intval($handle_icon_gap_phone) - 1;
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector' => $handle_left_arrow_selector,
                    'declaration' => "left: calc(50% - {$handle_icon_gap_phone_int_1}px);",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767')
                ));
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector' => $handle_right_arrow_selector,
                    'declaration' => "right: calc(50% - {$handle_icon_gap_phone_int}px);",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767')
                ));
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector' => $handle_up_arrow_selector,
                    'declaration' => "top: calc(50% - {$handle_icon_gap_phone_int}px);",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767')
                ));
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector' => $handle_down_arrow_selector,
                    'declaration' => "bottom: calc(50% - {$handle_icon_gap_phone_int}px);",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767')
                ));
            }
        }

        $handle_hover_icon_gap_last_edited  = $this->props['handle_hover_icon_gap_last_edited'];
        $handle_hover_icon_gap_responsive_status = et_pb_get_responsive_status($handle_hover_icon_gap_last_edited);
        $handle_hover_icon_gap = $this->props['handle_hover_icon_gap'];
        
        
        if('' !== $handle_hover_icon_gap) {
            $handle_hover_icon_gap_int = intval($handle_hover_icon_gap);
            $handle_hover_icon_gap_int_1 = intval($handle_hover_icon_gap) - 1;
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $handle_hover_left_arrow_selector,
                'declaration' => "left: calc(50% - {$handle_hover_icon_gap_int_1}px);",
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $handle_hover_right_arrow_selector,
                'declaration' => "right: calc(50% - {$handle_hover_icon_gap_int}px);",
            ));

            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $handle_hover_up_arrow_selector,
                'declaration' => "top: calc(50% - {$handle_hover_icon_gap_int}px);",
            ));
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $handle_hover_down_arrow_selector,
                'declaration' => "bottom: calc(50% - {$handle_hover_icon_gap_int}px);",
            ));
            
        }

        if ($handle_hover_icon_gap_responsive_status) {
            $handle_hover_icon_gap_tablet = ($this->props['handle_hover_icon_gap_tablet']) ? $this->props['handle_hover_icon_gap_tablet'] : $handle_hover_icon_gap;
            $handle_hover_icon_gap_phone = ($this->props['handle_hover_icon_gap_phone']) ? $this->props['handle_hover_icon_gap_phone'] : $handle_hover_icon_gap_tablet;
            if($handle_hover_icon_gap_tablet) {
                $handle_hover_icon_gap_tablet_int = intval($handle_hover_icon_gap_tablet);
                $handle_hover_icon_gap_tablet_int_1 = intval($handle_hover_icon_gap_tablet) - 1;
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector' => $handle_hover_left_arrow_selector,
                    'declaration' => "left: calc(50% - {$handle_hover_icon_gap_tablet_int_1}px);",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980')
                ));
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector' => $handle_hover_right_arrow_selector,
                    'declaration' => "right: calc(50% - {$handle_hover_icon_gap_tablet_int}px);",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980')
                ));
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector' => $handle_hover_up_arrow_selector,
                    'declaration' => "top: calc(50% - {$handle_hover_icon_gap_tablet_int}px);",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980')
                ));
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector' => $handle_hover_down_arrow_selector,
                    'declaration' => "bottom: calc(50% - {$handle_hover_icon_gap_tablet_int}px);",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980')
                ));
            }
            if($handle_hover_icon_gap_phone !== '') {
                $handle_hover_icon_gap_phone_int = intval($handle_hover_icon_gap_phone);
                $handle_hover_icon_gap_phone_int_1 = intval($handle_hover_icon_gap_phone) - 1;
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector' => $handle_hover_left_arrow_selector,
                    'declaration' => "left: calc(50% - {$handle_hover_icon_gap_phone_int_1}px);",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767')
                ));
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector' => $handle_hover_right_arrow_selector,
                    'declaration' => "right: calc(50% - {$handle_hover_icon_gap_phone_int}px);",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767')
                ));
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector' => $handle_hover_up_arrow_selector,
                    'declaration' => "top: calc(50% - {$handle_hover_icon_gap_phone_int}px);",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980')
                ));
                ET_Builder_Element::set_style( $render_slug, array(
                    'selector' => $handle_hover_down_arrow_selector,
                    'declaration' => "bottom: calc(50% - {$handle_hover_icon_gap_phone_int}px);",
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980')
                ));
            }
        }
        $this->generate_styles(
            array(
                'base_attr_name' => 'handle_circle_size',
                'selector' => $handle_selector,
                'css_property' => 'width',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'handle_circle_size',
                'selector' => $handle_selector,
                'css_property' => 'height',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'handle_circle_border_width',
                'selector' => $handle_selector,
                'css_property' => 'border-width',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        // Horizontal Handle
        $this->dipi_apply_custom_style(
            $this->slug,
            'handle_circle_size',
            'transform',
            $h_slider_before_selector,
            false,
            -0.5,
            'px',
            'translateY'
        );
        $this->dipi_apply_custom_style(
            $this->slug,
            'handle_circle_size',
            'transform',
            $h_slider_after_selector,
            false,
            0.5,
            'px',
            'translateY'
        );

        $this->generate_styles(
            array(
                'base_attr_name' => 'handle_circle_border_width',
                'selector' => $h_slider_before_selector,
                'css_property' => 'margin-bottom',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'handle_circle_border_width',
                'selector' => $h_slider_after_selector,
                'css_property' => 'margin-top',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );

        // Vertical Handle
        $this->dipi_apply_custom_style(
            $this->slug,
            'handle_circle_size',
            'transform',
            $v_slider_before_selector,
            false,
            0.5,
            'px',
            'translateX'
        );
        $this->dipi_apply_custom_style(
            $this->slug,
            'handle_circle_size',
            'transform',
            $v_slider_after_selector,
            false,
            -0.5,
            'px',
            'translateX'
        );

        $this->generate_styles(
            array(
                'base_attr_name' => 'handle_circle_border_width',
                'selector' => $v_slider_before_selector,
                'css_property' => 'margin-left',
                'render_slug' => $render_slug,
                'type' => 'range',
            )
        );

        $handle_circle_border_width = $this->props['handle_circle_border_width'];
        $handle_circle_border_width_tablet = ($this->props['handle_circle_border_width_tablet']) ? $this->props['handle_circle_border_width_tablet'] : $handle_circle_border_width;
        $handle_circle_border_width_phone = ($this->props['handle_circle_border_width_phone']) ? $this->props['handle_circle_border_width_phone'] : $handle_circle_border_width_tablet;
        $handle_circle_border_width_last_edited  = $this->props['handle_circle_border_width_last_edited'];
        $handle_circle_border_width_responsive_status = et_pb_get_responsive_status($handle_circle_border_width_last_edited);
        
        if('' !== $handle_circle_border_width) {
            $handle_circle_border_width_int = intval($handle_circle_border_width) - 1;
             ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $v_slider_after_selector,
                'declaration' => "margin-right: {$handle_circle_border_width_int}px;",
            ));
            
        }

        if($handle_circle_border_width_tablet !== ''  && $handle_circle_border_width_responsive_status) {
            $handle_circle_border_width_tablet_int = intval($handle_circle_border_width_tablet) - 1;
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $v_slider_after_selector,
                'declaration' => "margin-right: {$handle_circle_border_width_tablet_int}px;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
        }

        if($handle_circle_border_width_phone !== '' && $handle_circle_border_width_responsive_status) {
            $handle_circle_border_width_phone_int = intval($handle_circle_border_width_phone) - 1;
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $v_slider_after_selector,
                'declaration' => "margin-right: {$handle_circle_border_width_phone_int}px;",
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }
        $this->generate_styles(
            array(
                'base_attr_name' => 'handle_circle_border_style',
                'selector' => $handle_selector,
                'css_property' => 'border-style',
                'render_slug' => $render_slug,
                'type' => 'select',
            )
        );
        $this->generate_styles(
            array(
                'base_attr_name' => 'slider_handle_color',
                'selector' => $handle_selector,
                'css_property' => 'border-color',
                'render_slug' => $render_slug,
                'type' => 'color',
            )
        );
        
    }
}

new DIPI_BeforeAfterSlider;
