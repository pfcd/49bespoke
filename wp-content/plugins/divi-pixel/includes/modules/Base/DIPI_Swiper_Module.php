<?php

/**
 * TODO:
 * -custom css fields
 * -clean all settings so we don't use options which don't exist
 */

if (!class_exists('DIPI_Swiper_Module')) {
    abstract class DIPI_Swiper_Module extends DIPI_Builder_Module
    {
        public function get_settings_modal_toggles()
        {
            return [
                'advanced' => [
                    'toggles' => [
                        'slider_layout' => esc_html__('Slider Layout', 'dipi-divi-pixel'),
                        'slider_options' => esc_html__('Slider Options', 'dipi-divi-pixel'),
                        'slider_navigation' => esc_html__('Slider Navigation', 'dipi-divi-pixel'),
                        'slider_pagination' => esc_html__('Slider Pagination', 'dipi-divi-pixel'),
                    ],
                ],
            ];
        }
        public function get_fields()
        {
            $fields = [];
            $this->get_dipi_slider_layout_fields($fields);
            $this->get_dipi_slider_options_fields($fields);
            $this->get_dipi_slider_navigation_fields($fields);
            $this->get_dipi_slider_pagination_fields($fields);
            return $fields;
        }

        private function get_dipi_slider_layout_fields(&$fields)
        {
            $fields['columns'] = [
                'label' => esc_html('Number of Columns', 'dipi-divi-pixel'),
                'description' => esc_html__('The number of colums you want to show at the same time. Also known as "slides per view".', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'layout',
                'default' => '4',
                'range_settings' => [
                    'min' => '1',
                    'max' => '12',
                    'step' => '1',
                ],
                'unitless' => true,
                'mobile_options' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_layout',
            ];

            $fields['space_between'] = [
                'label' => esc_html('Item Spacing', 'dipi-divi-pixel'),
                'description' => esc_html__('Spacing between each slide.', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'layout',
                'default' => '30',
                'range_settings' => [
                    'min' => '5',
                    'max' => '100',
                    'step' => '1',
                ],
                'unitless' => true,
                'mobile_options' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_layout',
            ];

            $fields['container_padding'] = [
                'label' => esc_html('Container Padding', 'dipi-divi-pixel'),
                'description' => esc_html__('Padding of the container wich contains the slides.', 'dipi-divi-pixel'),
                'type' => 'custom_margin',
                'option_category' => 'layout',
                'mobile_options' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_layout',
            ];

            $fields['centered'] = [
                'label' => esc_html__('Centered', 'dipi-divi-pixel'),
                'description' => esc_html__('If enabled, then active slide will be centered, not always on the left side.', 'dipi-divi-pixel'),
                'type' => 'yes_no_button',
                'option_category' => 'layout',
                'default' => 'off',
                'options' => array(
                    'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                    'off' => esc_html__('No', 'dipi-divi-pixel'),
                ),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_layout',
            ];

            $fields['effect'] = [
                'label' => esc_html__('Effect', 'dipi-divi-pixel'),
                'description' => esc_html__('The transition effect / style of the slider.', 'dipi-divi-pixel'),
                'type' => 'select',
                'option_category' => 'layout',
                'options' => [
                    'slide' => esc_html__('Slide', 'dipi-divi-pixel'),
                    'coverflow' => esc_html__('Coverflow', 'dipi-divi-pixel'),
                ],
                'default' => 'slide',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_layout',
            ];

            $fields['cfe_depth'] = [
                'label' => esc_html('Depth', 'dipi-divi-pixel'),
                'description' => esc_html__('Depth offset in px (slides translate in Z axis).', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'layout',
                'range_settings ' => [
                    'min' => '0',
                    'max' => '500',
                    'step' => '1',
                ],
                'default' => '100',
                'unitless' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_layout',
                'show_if' => [
                    'effect' => 'coverflow',
                ],
            ];

            $fields['cfe_modifier'] = [
                'label' => esc_html('Modifier', 'dipi-divi-pixel'),
                'description' => esc_html__('Effect multiplier.', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'layout',
                'range_settings ' => [
                    'min' => '0',
                    'max' => '10',
                    'step' => '1',
                ],
                'default' => '1',
                'unitless' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_layout',
                'show_if' => [
                    'effect' => 'coverflow',
                ],
            ];

            $fields['cfe_rotate'] = [
                'label' => esc_html('Rotate', 'dipi-divi-pixel'),
                'description' => esc_html__('Slide rotate in degrees.', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'layout',
                'range_settings ' => [
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ],
                'default' => '50',
                'unitless' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_layout',
                'show_if' => [
                    'effect' => 'coverflow',
                ],
            ];

            $fields['cfe_slide_shadows'] = [
                'label' => esc_html__('Slide Shadows', 'dipi-divi-pixel'),
                'description' => esc_html__('Enables slides shadows.', 'dipi-divi-pixel'),
                'type' => 'yes_no_button',
                'option_category' => 'layout',
                'options' => [
                    'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                    'off' => esc_html__('No', 'dipi-divi-pixel'),
                ],
                'default' => 'on',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_layout',
                'show_if' => [
                    'effect' => 'coverflow',
                ],
            ];

            $fields["cfe_shadow_color"] = [
                'label' => esc_html__('Shadow Color', 'dipi-divi-pixel'),
                'description' => esc_html__('Color of the slides shadows.', 'dipi-divi-pixel'),
                'type' => 'color-alpha',
                'option_category' => 'color_option',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_layout',
                'show_if' => [
                    'effect' => 'coverflow',
                    'cfe_slide_shadows' => 'on',
                ],
            ];

            $fields['cfe_stretch'] = [
                'label' => esc_html('Stretch', 'dipi-divi-pixel'),
                'description' => esc_html('Stretch space between slides (in px).', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'layout',
                'range_settings ' => [
                    'min' => '0',
                    'max' => '100',
                    'step' => '1',
                ],
                'default' => '50',
                'unitless' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_layout',
                'show_if' => [
                    'effect' => 'coverflow',
                ],
            ];
        }

        private function get_dipi_slider_options_fields(&$fields)
        {
            $fields['speed'] = [
                'label' => esc_html__('Transition Duration', 'dipi-divi-pixel'),
                'description' => esc_html__('The time it takes to transition from one slide to another.', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'configuration',
                'range_settings' => [
                    'min' => '100',
                    'max' => '5000',
                    'step' => '100',
                ],
                'default' => '500',
                'validate_unit' => false,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_options',
            ];

            $fields['loop'] = [
                'label' => esc_html__('Loop', 'dipi-divi-pixel'),
                'description' => esc_html__('Enables infinite looping of the slides.', 'dipi-divi-pixel'),
                'type' => 'yes_no_button',
                'option_category' => 'configuration',
                'options' => [
                    'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                    'off' => esc_html__('No', 'dipi-divi-pixel'),
                ],
                'default' => 'off',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_options',
            ];

            $fields['autoplay'] = [
                'label' => esc_html__('Autoplay', 'dipi-divi-pixel'),
                'description' => esc_html__('Eables automati transitions.', 'dipi-divi-pixel'),
                'type' => 'yes_no_button',
                'option_category' => 'configuration',
                'options' => [
                    'off' => esc_html__('No', 'dipi-divi-pixel'),
                    'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                ],
                'default' => 'off',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_options',
            ];

            $fields['pause_on_hover'] = [
                'label' => esc_html__('Pause on Hover', 'dipi-divi-pixel'),
                'description' => esc_html__('Pause automatic transitions if hoverig over the module.', 'dipi-divi-pixel'),
                'type' => 'yes_no_button',
                'option_category' => 'configuration',
                'default' => 'on',
                'options' => [
                    'off' => esc_html__('No', 'dipi-divi-pixel'),
                    'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                ],
                'show_if' => [
                    'autoplay' => 'on',
                ],
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_options',
            ];

            $fields['autoplay_speed'] = [
                'label' => esc_html__('Autoplay Speed (ms)', 'dipi-divi-pixel'),
                'description' => esc_html__('The time a slide is shown before transitioning to the next slide.', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'configuration',
                'range_settings' => array(
                    'min' => '500',
                    'max' => '10000',
                    'step' => '100',
                ),
                'default' => '2500',
                'unitless' => true,
                'show_if' => [
                    'autoplay' => 'on',
                ],
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_options',
            ];

            $fields['autoplay_reverse'] = [
                'label' => esc_html__('Reverse the autoplay direction.', 'dipi-divi-pixel'),
                'description' => esc_html__('', 'dipi-divi-pixel'),
                'type' => 'yes_no_button',
                'option_category' => 'configuration',
                'default' => 'off',
                'options' => [
                    'off' => esc_html__('No', 'dipi-divi-pixel'),
                    'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                ],
                'show_if' => [
                    'autoplay' => 'on',
                ],
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_options',
            ];
        }

        private function get_dipi_slider_navigation_fields(&$fields)
        {
            $fields['navigation'] = [
                'label' => esc_html__('Navigation', 'dipi-divi-pixel'),
                'description' => esc_html__('Enables navigation elements.', 'dipi-divi-pixel'),
                'type' => 'yes_no_button',
                'option_category' => 'layout',
                'options' => [
                    'off' => esc_html__('No', 'dipi-divi-pixel'),
                    'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                ],
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_navigation',
                'default' => 'off',
            ];

            $fields['navigation_on_hover'] = [
                'label' => esc_html__('Show Navigation on Hover', 'dipi-divi-pixel'),
                'description' => esc_html__('Only show navigation elements if hovering over the module.', 'dipi-divi-pixel'),
                'type' => 'yes_no_button',
                'option_category' => 'layout',
                'options' => [
                    'off' => esc_html__('No', 'dipi-divi-pixel'),
                    'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                ],
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_navigation',
                'show_if' => [
                    'navigation' => 'on',
                ],
                'default' => 'off',
            ];

            $fields['navigation_prev_icon_yn'] = [
                'label' => esc_html__('Custom Previous Icon', 'dipi-divi-pixel'),
                'description' => esc_html__('Enables custom previous icon.', 'dipi-divi-pixel'),
                'type' => 'yes_no_button',
                'option_category' => 'layout',
                'options' => [
                    'off' => esc_html__('No', 'dipi-divi-pixel'),
                    'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                ],
                'default' => 'off',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_navigation',
                'show_if' => [
                    'navigation' => 'on',
                ],
            ];

            $fields['navigation_prev_icon'] = [
                'label' => esc_html__('Select Previous Icon', 'dipi-divi-pixel'),
                'description' => esc_html__('The custom previous icon.', 'dipi-divi-pixel'),
                'type' => 'select_icon',
                'option_category' => 'layout',
                'default' => '8',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_navigation',
                'show_if' => [
                    'navigation' => 'on',
                    'navigation_prev_icon_yn' => 'on',
                ],
            ];

            $fields['navigation_next_icon_yn'] = [
                'label' => esc_html__('Custom Next Icon', 'dipi-divi-pixel'),
                'description' => esc_html__('Enables custom next icon.', 'dipi-divi-pixel'),
                'type' => 'yes_no_button',
                'option_category' => 'layout',
                'options' => array(
                    'off' => esc_html__('No', 'dipi-divi-pixel'),
                    'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                ),
                'default' => 'off',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_navigation',
                'show_if' => [
                    'navigation' => 'on',
                ],
            ];
            $fields['navigation_next_icon'] = [
                'label' => esc_html__('Select Next Icon', 'dipi-divi-pixel'),
                'description' => esc_html__('The custom next icon.', 'dipi-divi-pixel'),
                'type' => 'select_icon',
                'option_category' => 'layout',
                'default' => '9',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_navigation',
                'show_if' => [
                    'navigation' => 'on',
                    'navigation_next_icon_yn' => 'on',
                ],
            ];

            $fields['navigation_size'] = [
                'label' => esc_html__('Icon Size', 'dipi-divi-pixel'),
                'description' => esc_html__('The size of the navigation icons.', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'layout',
                'range_settings' => array(
                    'min' => '1',
                    'max' => '100',
                    'step' => '1',
                ),
                'default' => '30px',
                'default_unit' => 'px',
                'allowed_units' => array('px'),
                'mobile_options' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_navigation',
                'show_if' => [
                    'navigation' => 'on',
                ],
            ];

            $fields['navigation_padding'] = [
                'label' => esc_html__('Icon Padding', 'dipi-divi-pixel'),
                'description' => esc_html__('The padding around the navigation icons.', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'layout',
                'range_settings' => [
                    'min' => '1',
                    'max' => '100',
                    'step' => '1',
                ],
                'default' => '30px',
                'default_unit' => 'px',
                'allowed_units' => array('px'),
                'mobile_options' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_navigation',
                'show_if' => [
                    'navigation' => 'on',
                ],
            ];

            $fields['navigation_color'] = [
                'label' => esc_html('Icon Color', 'dipi-divi-pixel'),
                'description' => esc_html__('The color of the navigation icons.', 'dipi-divi-pixel'),
                'type' => 'color-alpha',
                'option_category' => 'color_option',
                'default' => et_builder_accent_color(),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_navigation',
                'show_if' => [
                    'navigation' => 'on',
                ],
                'hover' => 'tabs',
            ];

            $fields['navigation_bg_color'] = [
                'label' => esc_html('Icon Background Color', 'dipi-divi-pixel'),
                'description' => esc_html__('The background color of the navigation icons.', 'dipi-divi-pixel'),
                'type' => 'color-alpha',
                'option_category' => 'color_option',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_navigation',
                'show_if' => [
                    'navigation' => 'on',
                ],
                'hover' => 'tabs',
            ];

            $fields['navigation_circle'] = [
                'label' => esc_html__('Circle Icon', 'dipi-divi-pixel'),
                'description' => esc_html__('Enables a circular background on the navigation elements.', 'dipi-divi-pixel'),
                'type' => 'yes_no_button',
                'option_category' => 'layout',
                'options' => array(
                    'off' => esc_html__('No', 'dipi-divi-pixel'),
                    'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                ),
                'default' => 'off',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_navigation',
                'show_if' => [
                    'navigation' => 'on',
                ],
            ];

            $fields['navigation_position_left'] = [
                'label' => esc_html('Left Icon Postion', 'dipi-divi-pixel'),
                'description' => esc_html__('Position of the left navigation element.', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'layout',
                'default' => '-66px',
                'default_on_front' => '-66px',
                'default_unit' => 'px',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'range_settings' => [
                    'min' => '-200',
                    'max' => '200',
                    'step' => '1',
                ],
                'mobile_options' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_navigation',
                'show_if' => [
                    'navigation' => 'on',
                ],
            ];

            $fields['navigation_position_right'] = [
                'label' => esc_html('Right Icon Postion', 'dipi-divi-pixel'),
                'description' => esc_html__('Position of the right navigation element.', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'layout',
                'default' => '-66px',
                'default_on_front' => '-66px',
                'default_unit' => 'px',
                'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
                'range_settings' => [
                    'min' => '-200',
                    'max' => '200',
                    'step' => '1',
                ],
                'mobile_options' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_navigation',
                'show_if' => [
                    'navigation' => 'on',
                ],
            ];
        }

        private function get_dipi_slider_pagination_fields(&$fields)
        {
            $fields['pagination'] = [
                'label' => esc_html__('Pagination', 'dipi-divi-pixel'),
                'description' => esc_html__('Enables pagination elements.', 'dipi-divi-pixel'),
                'type' => 'yes_no_button',
                'option_category' => 'layout',
                'options' => [
                    'off' => esc_html__('No', 'dipi-divi-pixel'),
                    'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                ],
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_pagination',
                'default' => 'off',
            ];

            $fields['dynamic_bullets'] = [
                'label' => esc_html__('Dynamic Bullets', 'dipi-divi-pixel'),
                'description' => esc_html__('If enabled, not one bullet per slide but a dynamic number of bullets is shown in the pagination element.', 'dipi-divi-pixel'),
                'type' => 'yes_no_button',
                'option_category' => 'layout',
                'default' => 'off',
                'options' => [
                    'off' => esc_html__('No', 'dipi-divi-pixel'),
                    'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                ],
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_pagination',
                'show_if' => [
                    'pagination' => 'on',
                ],
            ];

            $fields['dynamic_main_bullets'] = [
                'label' => esc_html('Main Bullets Count', 'dipi-divi-pixel'),
                'description' => esc_html__('The number of dynamic bullets in full size.', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'layout',
                'default' => '3',
                'range_settings' => [
                    'min' => '1',
                    'max' => '10',
                    'step' => '1',
                ],
                'unitless' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_pagination',
                'show_if' => [
                    'pagination' => 'on',
                ],
            ];

            $fields['pagination_position'] = [
                'label' => esc_html('Pagination Postion', 'dipi-divi-pixel'),
                'description' => esc_html__('The vertical position of the pagination elements.', 'dipi-divi-pixel'),
                'type' => 'range',
                'option_category' => 'layout',
                'default' => '-40px',
                'range_settings' => [
                    'min' => '-200',
                    'max' => '200',
                    'step' => '1',
                ],
                'default_unit' => 'px',
                'allowed_units' => array('px'),
                'mobile_options' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_pagination',
                'show_if' => [
                    'pagination' => 'on',
                ],
            ];

            $fields['pagination_color'] = [
                'label' => esc_html('Pagination Color', 'dipi-divi-pixel'),
                'description' => esc_html__('The color of the pagination bullet points.', 'dipi-divi-pixel'),
                'type' => 'color-alpha',
                'option_category' => 'color_option',
                'default' => '#d8d8d8',
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_pagination',
                'show_if' => [
                    'pagination' => 'on',
                ],
            ];

            $fields['pagination_active_color'] = [
                'label' => esc_html('Pagination Active Color', 'dipi-divi-pixel'),
                'description' => esc_html__('The color of the active pagination bullet.', 'dipi-divi-pixel'),
                'type' => 'color-alpha',
                'option_category' => 'color_option',
                'default' => et_builder_accent_color(),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'slider_pagination',
                'show_if' => [
                    'pagination' => 'on',
                ],
            ];
        }

        /**
         * Render the swiper HTML using $slides as the content for the slider.
         * This function will return the whole HTML structure including the
         * navigation controls (if active) and a wrapper with the required
         * data attributes so a generic script can handle the setup and ini-
         * tialization of the Swiper. Since all Swipers are basically (and
         * should be) the same, the only difference is the content of the
         * slides.
         */
        protected function render_swiper_container($slides, $render_slug, $additional_config = [])
        {
            return sprintf(
                '<div class="swiper-container dipi_swiper_container" data-config="%4$s">
                <div class="swiper-wrapper">
                    %1$s
                </div>
            </div>
            %2$s
            %3$s',
                $slides,
                self::dipi_get_swiper_navigation(),
                self::dipi_get_swiper_pagination(),
                esc_attr(self::dipi_get_swiper_config($render_slug, $additional_config))
            );

        }

        /**
         * Return the Swiper pagination, if enabled
         */
        protected function dipi_get_swiper_pagination()
        {
            if ($this->props['pagination'] !== 'on') {
                return '';
            }

            return '<div class="swiper-container-horizontal"><div class="swiper-pagination"></div></div>';
        }

        /**
         * Return the Swiper navigation, if enabled
         */
        protected function dipi_get_swiper_navigation()
        {
            if ($this->props['navigation'] !== 'on') {
                return '';
            }

            $next_icon = 'on' === $this->props['navigation_next_icon_yn'] ? sprintf('data-icon="%1$s"', esc_attr(et_pb_process_font_icon($this->props['navigation_next_icon']))) : 'data-icon="9"';
            $prev_icon = 'on' === $this->props['navigation_prev_icon_yn'] ? sprintf('data-icon="%1$s"', esc_attr(et_pb_process_font_icon($this->props['navigation_prev_icon']))) : 'data-icon="8"';


            $this->dipi_generate_font_icon_styles($render_slug, 'navigation_next_icon', '%%order_class%% .swiper-button-next');
            $this->dipi_generate_font_icon_styles($render_slug, 'navigation_prev_icon',  '%%order_class%% .swiper-button-prev');

            return sprintf(
                '<div class="swiper-button-next swiper-arrow-button %3$s" %1$s></div>
                <div class="swiper-button-prev swiper-arrow-button %3$s" %2$s></div>',
                $next_icon,
                $prev_icon,
                ($this->props['navigation_on_hover'] === "on" ? esc_attr("show_on_hover") : "")
            );
        }

        /**
         * Return all the Swiper related option
         */
        protected function dipi_get_swiper_config($render_slug, $additional_config = [])
        {
            $columns = $this->dipi_get_responsive_prop('columns');
            $space_between = $this->dipi_get_responsive_prop('space_between');
            $order_class = self::get_module_order_class($render_slug);

            $config = [
                //Layout
                'columns_desktop' => $columns['desktop'],
                'columns_tablet' => $columns['tablet'],
                'columns_phone' => $columns['phone'],
                'space_between_desktop' => $space_between['desktop'],
                'space_between_tablet' => $space_between['tablet'],
                'space_between_phone' => $space_between['phone'],
                'centered' => $this->props['centered'],
                'effect' => $this->props['effect'],
                'cfe_depth' => $this->props['cfe_depth'],
                'cfe_modifier' => $this->props['cfe_modifier'],
                'cfe_rotate' => $this->props['cfe_rotate'],
                'cfe_slide_shadows' => $this->props['cfe_slide_shadows'],
                'cfe_shadow_color' => $this->props['cfe_shadow_color'],
                'cfe_stretch' => $this->props['cfe_stretch'],

                //Options
                'speed' => $this->props['speed'],
                'loop' => $this->props['loop'],
                'autoplay' => $this->props['autoplay'],
                'pause_on_hover' => $this->props['pause_on_hover'],
                'autoplay_speed' => $this->props['autoplay_speed'],
                'autoplay_reverse' => $this->props['autoplay_reverse'],

                //Navigation
                'navigation' => $this->props['navigation'],
                'navigation_on_hover' => $this->props['navigation_on_hover'],

                //Pagination
                'pagination' => $this->props['pagination'],
                'dynamic_bullets' => $this->props['dynamic_bullets'],
                'dynamic_main_bullets' => $this->props['dynamic_main_bullets'],
                'pagination_position' => $this->props['pagination_position'],
                'pagination_color' => $this->props['pagination_color'],
                'pagination_active_color' => $this->props['pagination_active_color'],

                //Generic options
                'order_class' => $order_class,

            ];

            $config = array_merge($config, $additional_config);
            return json_encode($config);
        }

        public function render($attrs, $content, $render_slug)
        {
            wp_enqueue_script('dipi_swiper_module_public');
            wp_enqueue_style('dipi_swiper_module_public');

            $this->dipi_apply_swiper_css($render_slug);
            $this->dipi_apply_swiper_navigation_css($render_slug);
            $this->dipi_apply_swiper_pagination_css($render_slug);

            return '';
        }
        private function dipi_apply_swiper_css($render_slug)
        {
            if (isset($this->props['container_padding']) && $this->props['container_padding'] != '') {
                $container_class = "%%order_class%% .swiper-container";
                $responsive_container_padding = $this->dipi_get_responsive_prop('container_padding');
                $container_padding = explode('|', $responsive_container_padding['desktop']);
                $container_padding_tablet = explode('|', $responsive_container_padding['tablet']);
                $container_padding_phone = explode('|', $responsive_container_padding['phone']);

                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $container_class,
                    'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $container_padding[0], $container_padding[1], $container_padding[2], $container_padding[3]),
                ));
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $container_class,
                    'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $container_padding_tablet[0], $container_padding_tablet[1], $container_padding_tablet[2], $container_padding_tablet[3]),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                ));
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $container_class,
                    'declaration' => sprintf('padding-top: %1$s !important; padding-right:%2$s !important; padding-bottom:%3$s !important; padding-left:%4$s !important;', $container_padding_phone[0], $container_padding_phone[1], $container_padding_phone[2], $container_padding_phone[3]),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ));
            }
        }

        private function dipi_apply_swiper_navigation_css($render_slug)
        {
            if ($this->props['navigation'] !== 'on') {
                return;
            }

            $navigation_position_left = $this->dipi_get_responsive_prop('navigation_position_left');
            et_pb_responsive_options()->generate_responsive_css($navigation_position_left, '%%order_class%% .swiper-button-prev', 'left', $render_slug);

            $navigation_position_right = $this->dipi_get_responsive_prop('navigation_position_right');
            et_pb_responsive_options()->generate_responsive_css($navigation_position_right, '%%order_class%% .swiper-button-next', 'right', $render_slug);

            $navigation_color = $this->props['navigation_color'];
            if ('' !== $navigation_color) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .swiper-arrow-button:after',
                    'declaration' => "color: {$navigation_color}!important;",
                ));

                $navigation_color_hover = $this->get_hover_value('navigation_color');
                if ($navigation_color_hover !== '') {
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector' => '%%order_class%% .swiper-arrow-button:hover:after',
                        'declaration' => "color: {$navigation_color_hover}!important;",
                    ));
                }
            }

            $navigation_bg_color = $this->props['navigation_bg_color'];
            if ('' !== $navigation_bg_color) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .swiper-button-next, %%order_class%% .swiper-button-prev',
                    'declaration' => "background: {$navigation_bg_color} !important;",
                ));

                $navigation_bg_color_hover = $this->get_hover_value('navigation_bg_color');
                if ($navigation_bg_color_hover !== '') {
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector' => '%%order_class%% .swiper-button-next:hover, %%order_class%% .swiper-button-prev:hover',
                        'declaration' => "background: {$navigation_bg_color_hover}!important;",
                    ));
                }
            }

            if ('' !== $this->props['navigation_size']) {
                $navigation_size = $this->dipi_get_responsive_prop('navigation_size');

                et_pb_responsive_options()->generate_responsive_css(
                    $navigation_size,
                    '%%order_class%% .swiper-arrow-button',
                    'width',
                    $render_slug
                );

                et_pb_responsive_options()->generate_responsive_css(
                    $navigation_size,
                    '%%order_class%% .swiper-arrow-button',
                    'height',
                    $render_slug
                );

                et_pb_responsive_options()->generate_responsive_css(
                    $navigation_size,
                    '%%order_class%% .swiper-button-next:after, %%order_class%% .swiper-button-next:before, %%order_class%% .swiper-button-prev:after, %%order_class%% .swiper-button-prev:before',
                    'font-size',
                    $render_slug
                );
            }

            if ('' !== $this->props['navigation_padding']) {
                et_pb_responsive_options()->generate_responsive_css(
                    $this->dipi_get_responsive_prop('navigation_padding'),
                    '%%order_class%% .swiper-arrow-button',
                    'padding',
                    $render_slug
                );
            }

            if ('on' == $this->props['navigation_circle']) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .swiper-arrow-button',
                    'declaration' => 'border-radius: 50%;',
                ));
            }
        }

        private function dipi_apply_swiper_pagination_css($render_slug)
        {
            if ($this->props['pagination'] !== 'on') {
                return;
            }

            $pagination_color = $this->props['pagination_color'];
            if ('' !== $pagination_color) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .swiper-pagination-bullet',
                    'declaration' => "background: {$pagination_color};",
                ));
            }
            $pagination_active_color = $this->props['pagination_active_color'];
            if ('' !== $pagination_active_color) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => '%%order_class%% .swiper-pagination-bullet.swiper-pagination-bullet-active',
                    'declaration' => "background: {$pagination_active_color}",
                ));
            }

            if ('' !== $this->props['pagination_position']) {
                et_pb_responsive_options()->generate_responsive_css(
                    $this->dipi_get_responsive_prop('pagination_position'),
                    '%%order_class%% .swiper-container-horizontal > .swiper-pagination-bullets, %%order_class%% .swiper-pagination-fraction, %%order_class%% .swiper-pagination-custom',
                    'bottom',
                    $render_slug
                );
            }
        }
    }
}
