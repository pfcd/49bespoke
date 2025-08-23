<?php

class DIPI_SVGAnimator extends DIPI_Builder_Module
{
    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/svg-animator',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->slug = 'dipi_svg_animator';
        $this->vb_support = 'on';
        $this->name = esc_html__('Pixel SVG Animator', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%.dipi_svg_animator';
        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'content' => esc_html__('Content ', 'dipi-divi-pixel'),
                    'settings' => esc_html__('Settings', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                ],
            ],
        ];

        add_filter('et_fb_backend_helpers', [$this, 'default_helpers'], 100, 1);
    }

    public function default_helpers($helpers)
    {
        $helpers['defaults']['dipi_svg_animator'] = [
            'src' => 'data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiAKCXZpZXdCb3g9IjAgMCAxMDgwIDU0MCIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMTA4MCA1NDA7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4KCS5zdDB7ZmlsbC1ydWxlOmV2ZW5vZGQ7Y2xpcC1ydWxlOmV2ZW5vZGQ7ZmlsbDpub25lO3N0cm9rZTojREREREREO3N0cm9rZS13aWR0aDo0O3N0cm9rZS1taXRlcmxpbWl0OjEwO30KCS5zdDF7ZmlsbDpub25lO3N0cm9rZTojREREREREO3N0cm9rZS13aWR0aDo0O3N0cm9rZS1taXRlcmxpbWl0OjEwO30KPC9zdHlsZT4KPHJlY3QgeD0iMy4xIiB5PSIyLjUiIGNsYXNzPSJzdDAiIHdpZHRoPSIxMDczLjQiIGhlaWdodD0iNTM0LjEiLz4KPGNpcmNsZSBjbGFzcz0ic3QwIiBjeD0iMzcwLjYiIGN5PSIxNDMuOCIgcj0iNzkuNSIvPgo8cGF0aCBjbGFzcz0ic3QwIiBkPSJNMy44LDQ0MC43bDE3NS0xNDUuOWMxNi44LTE0LDQxLjMtMTMuNyw1Ny43LDAuN2wxNDUuOCwxMjcuN2MxMy4xLDExLjUsMzIuOSwxMS4xLDQ1LjUtMS4xbDI5My40LTI3NC44CgljMTcuMi0xNi42LDQ0LjUtMTYuNiw2MS43LDBsMjkzLjcsMjgzLjYiLz4KPHBhdGggY2xhc3M9InN0MSIgZD0iTTMuMSw1MDYuNGwxODIuNC0xNTIuMmMxMS45LTkuNiwyOC45LTkuMyw0MC40LDAuNmwxNDQuOSwxMjQuOGMyMC40LDE3LjYsNTAuOSwxNi45LDcwLjQtMS43bDI5MS44LTI3Ni42CgljMTAuMi05LjcsMjYuMy05LjcsMzYuNS0wLjFsMzA2LjgsMjg5LjIiLz4KPC9zdmc+Cg==',
        ];
        return $helpers;
    }

    public function get_fields()
    {
        $fields = [];

        $fields['src'] = [
            'label' => esc_html__('SVG SRC', 'dipi-divi-pixel'),
            'type' => 'upload',
            'option_category' => 'basic_option',
            'upload_button_text' => esc_html__('Upload SVG', 'dipi-divi-pixel'),
            'choose_text' => esc_html__('Choose SVG', 'dipi-divi-pixel'),
            'update_text' => esc_html__('Set SVG', 'dipi-divi-pixel'),
            'description' => esc_html__('Upload your desired SVG, or type in the URL to the SVG you would like to display.', 'dipi-divi-pixel'),
            'toggle_slug' => 'content',
            'computed_affects' => array(
                '__svg_animator',
            ),
        ];

        $fields['svg_color'] = [
            'label' => esc_html__('SVG Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'tab_slug' => 'advanced',
            'description' => esc_html__('Here you can define a custom color for a SVG.', 'dipi-divi-pixel'),
        ];

        $fields['svg_width'] = [
            'label' => esc_html__('SVG Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'tab_slug' => 'advanced',
            'default' => '100%',
            'default_unit' => '%',
            'option_category' => 'basic_option',
            'description' => esc_html__('This defines SVG width. If not set 100%.', 'dipi-divi-pixel'),
            'allowed_units' => ['px', 'em', 'rem', '%'],
            'range_settings' => [
                'min' => '1',
                'max' => '900',
                'step' => '1',
            ],
        ];

        $fields['svg_height'] = [
            'label' => esc_html__('SVG Height', 'dipi-divi-pixel'),
            'type' => 'range',
            'tab_slug' => 'advanced',
            'option_category' => 'basic_option',
            'description' => esc_html__('This defines SVG Height.', 'dipi-divi-pixel'),
            'default' => '100%',
            'default_unit' => '%',
            'allowed_units' => ['px', 'em', 'rem', '%'],
            'range_settings' => [
                'min' => '1',
                'max' => '900',
                'step' => '1',
            ],
        ];

        $fields['svg_weight'] = [
            'label' => esc_html__('SVG Line Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'tab_slug' => 'advanced',
            'default_unit' => 'px',
            'default' => '2px',
            'option_category' => 'basic_option',
            'description' => esc_html__('This defines SVG line width.', 'dipi-divi-pixel'),
            'range_settings' => [
                'min' => '1',
                'max' => '20',
                'step' => '1',
            ],
        ];

        $fields['anim_type'] = [
            'label' => esc_html__('Animation Type', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'options' => [
                'delayed' => esc_html__('Delayed', 'dipi-divi-pixel'),
                'sync' => esc_html__('Sync', 'dipi-divi-pixel'),
                'oneByOne' => esc_html__('One By One', 'dipi-divi-pixel'),
            ],
            'default_on_front' => 'delayed',
            'description' => esc_html__('Here you can choose animation type.', 'dipi-divi-pixel'),
            'toggle_slug' => 'settings',
        ];

        $fields['anim_dur'] = [
            'label' => esc_html__('Animation Duration (in Frames)', 'dipi-divi-pixel'),
            'description' => esc_html__('This defines animation duration in frames.', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '100',
            'range_settings' => [
                'min' => '1',
                'max' => '500',
                'step' => '1',
            ],
            'unitless' => true,
            'option_category' => 'basic_option',
            'toggle_slug' => 'settings',
        ];

        $fields['path_timing_func'] = [
            'label' => esc_html__('Path Timing Function', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'LINEAR',
            'options' => [
                'LINEAR' => esc_html__('Linear', 'dipi-divi-pixel'),
                'EASE' => esc_html__('Ease', 'dipi-divi-pixel'),
                'EASE_IN' => esc_html__('Ease-in', 'dipi-divi-pixel'),
                'EASE_OUT' => esc_html__('Ease-out', 'dipi-divi-pixel'),
                'EASE_OUT_BOUNCE' => esc_html__('Ease-out Bounce', 'dipi-divi-pixel'),
            ],
            'description' => esc_html__('Here you can choose animation path timing function.', 'dipi-divi-pixel'),
            'toggle_slug' => 'settings',
        ];

        $fields['anim_timing_func'] = [
            'label' => esc_html__('Animation Timing Function', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'LINEAR',
            'options' => [
                'LINEAR' => esc_html__('Linear', 'dipi-divi-pixel'),
                'EASE' => esc_html__('Ease', 'dipi-divi-pixel'),
                'EASE_IN' => esc_html__('Ease-in', 'dipi-divi-pixel'),
                'EASE_OUT' => esc_html__('Ease-out', 'dipi-divi-pixel'),
                'EASE_OUT_BOUNCE' => esc_html__('Ease-out Bounce', 'dipi-divi-pixel'),
            ],
            'description' => esc_html__('Here you can choose animation timing function.', 'dipi-divi-pixel'),
            'toggle_slug' => 'settings',
        ];

        $fields['anim_start'] = [
            'label' => esc_html__('Animation Start Function', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'autostart',
            'options' => [
                'autostart' => esc_html__('Auto Start', 'dipi-divi-pixel'),
                'inViewport' => esc_html__('In Viewport', 'dipi-divi-pixel'),
            ],
            'description' => esc_html__('Here you can choose animation start function.', 'dipi-divi-pixel'),
            'toggle_slug' => 'settings',
        ];

        $fields['align'] = [
            'label' => esc_html__('SVG Alignment', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'options' => [
                'flex-start' => esc_html__('Left', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'flex-end' => esc_html__('Right', 'dipi-divi-pixel'),
            ],
            'description' => esc_html__('Here you can choose the image alignment.', 'dipi-divi-pixel'),
            'default' => 'center',
            'toggle_slug' => 'settings',
        ];
        
        $fields['replay_on_click'] = [
            'label' => esc_html__('Replay Animation on Click', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ),
            'toggle_slug' => 'settings',
        ];
        

        $fields["__svg_animator"] = [
            'type' => 'computed',
            'computed_callback' => ['DIPI_SVGAnimator', 'render_svg_animator'],
            'computed_depends_on' => [
                'src'
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


    public static function add_prefix_svg_selector($svg_html, $render_slug)
    {
        $stylecode_count = preg_match_all('/<style (.*?)>(.*?)<\/style>/s', $svg_html, $style_codes);
        $orderClassName=self::get_module_order_class(  $render_slug );
        if (!$orderClassName) {
            $orderClassName="dipi_svg_animator_unknown";
        }
        $prefix = ".".$orderClassName." ";
        if ($stylecode_count) {
            foreach($style_codes[2] as $style_code) {
                $stylecode_prefix = "";
                preg_match_all( '/(?ims)([a-z0-9\s\.\:#_\-@,]+)\{([^\}]*)\}/', $style_code, $arr);
                foreach ($arr[0] as $i => $x){
                    $selector = trim($arr[1][$i]);
                    $rules = trim($arr[2][$i]);
                    
                    $selectors = explode(',', trim($selector));                    
                    $selectors_withprefix = [];
                    foreach ($selectors as $strSel){
                        $selectors_withprefix[] = $prefix.$strSel;
                    }
                    $selector_withprefix = implode(',', $selectors_withprefix);
                    $stylecode_prefix .= $selector_withprefix."{".$rules."}\r\n";
                }
                
                $svg_html = str_replace($style_code, $stylecode_prefix, $svg_html);
            }
        }

        return $svg_html;
    }
    public static function render_svg_animator($args, $render_slug)
    {
        $defaults = [
            'src' => '',
            'svg_color' => '',
            'svg_weight' => '',
            'align' => '',
            'anim_type' => 'delayed',
            'anim_dur' => '100',
            'path_timing_func' => 'LINEAR',
            'anim_timing_func' => 'LINEAR',
            'anim_start' => 'autostart',
            'align' => 'center',
        ];
        $args = wp_parse_args($args, $defaults);

        $src = $args['src'];
        $svg_color = $args['svg_color'];
        $svg_weight = $args['svg_weight'];
        $animation_type = $args['anim_type'];
        $animation_duration = $args['anim_dur'];
        $path_timing_function = $args['path_timing_func'];
        $anim_timing_function = $args['anim_timing_func'];
        $anim_start = $args['anim_start'];
        $replay_on_click = $args['replay_on_click'];

        $sa_svg_id = self::get_module_order_class($render_slug);
        $svg_content = '';
        $config = [];
        if ($animation_type != 'none') {
            $config = [
                "svg_id" => $sa_svg_id,
                "type" => ($animation_type != '' ? $animation_type : 'delayed'),
                "duration" => ($animation_duration != '' ? $animation_duration : '200'),
                "start" => ($anim_start != '' ? $anim_start : 'autostart'),
                "pathTimingFunction" => ($path_timing_function != '' ? $path_timing_function : 'linear'),
                "animTimingFunction" => ($anim_timing_function != '' ? $anim_timing_function : 'linear'),
                "replay_on_click" => ($replay_on_click != '' ? $replay_on_click : 'off'),
            ];
        }
        $svg_color = ($svg_color != '' && $svg_color != '#' ? $svg_color : '#000000');
        if ($src) {
            $svg_content = DIPI_Builder_Module::dipi_get_url_content($src);
            $validators = array(
                '<svg' => '<svg id="svg-' . $sa_svg_id . '"',
                '<ellipse' => '<ellipse fill="none" stroke-width="' . $svg_weight . '" stroke="' . $svg_color . '"',
                '<rect' => '<rect fill="none" stroke-width="' . $svg_weight . '" stroke="' . $svg_color . '"',
                '<circle' => '<circle fill="none" stroke-width="' . $svg_weight . '" stroke="' . $svg_color . '"',
                '<polygon' => '<polygon fill="none" stroke-width="' . $svg_weight . '" stroke="' . $svg_color . '"',
                '<polyline' => '<polyline fill="none" stroke-width="' . $svg_weight . '" stroke="' . $svg_color . '"',
                '<defs' => '<defs fill="none" stroke-width="' . $svg_weight . '" stroke="' . $svg_color . '"',
                '<linearGradient' => '<linearGradient fill="none" stroke-width="' . $svg_weight . '" stroke="' . $svg_color . '"',
                '<path' => '<path fill="none" stroke-width="' . $svg_weight . '" stroke="' . $svg_color . '"',
                'style="' => 'style="fill:none!important;',
            );
            foreach ($validators as $key => $value) {
                $svg_content = str_replace($key, $value, $svg_content);
            }
        } else {
            $svg_content = '';
        }
        $svg_content = DIPI_SVGAnimator::add_prefix_svg_selector($svg_content, $render_slug);
        $svg_animator = sprintf(
            '<div class="dipi-svg-animator-inner-wrapper" data-config="%1$s">
                %2$s
            </div>',
            esc_attr(htmlspecialchars(json_encode($config), ENT_QUOTES, 'UTF-8')),
            $svg_content
        );

        return $svg_animator;
    }

    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_svg_animator_public');
        $this->_dipi_apply_css($render_slug);

        $svg_animator = $this->render_svg_animator($this->props, $render_slug);

        $output = sprintf(
            '<div class="dipi-svg-animator-container preloading" style="opacity: 0;">
                %1$s
            </div>',
            $svg_animator
        );

        return $output;
    }

    private function _dipi_apply_css($render_slug)
    {
        $svg_width = $this->dipi_get_responsive_prop('svg_width');

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-svg-animator-container svg",
            'declaration' => sprintf('width: %1$s !important;', $svg_width['desktop']),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-svg-animator-container svg",
            'declaration' => sprintf('width: %1$s !important;', $svg_width['tablet']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-svg-animator-container svg",
            'declaration' => sprintf('width: %1$s !important;', $svg_width['phone']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));

        $svg_height = $this->dipi_get_responsive_prop('svg_height');

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-svg-animator-container svg",
            'declaration' => sprintf('height: %1$s !important;', $svg_height['desktop']),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-svg-animator-container svg",
            'declaration' => sprintf('height: %1$s !important;', $svg_height['tablet']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-svg-animator-container svg",
            'declaration' => sprintf('height: %1$s !important;', $svg_height['phone']),
            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
        ));

        $svg_color = $this->props['svg_color'];
        $svg_weight = $this->props['svg_weight'];

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-svg-animator-container svg *",
            'declaration' => sprintf('stroke: %1$s !important;', $svg_color),
        ));

        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-svg-animator-container svg *",
            'declaration' => sprintf('stroke-width: %1$s !important;', $svg_weight),
        ));
        $align = $this->props['align'];
        ET_Builder_Element::set_style($render_slug, array(
            'selector' => "%%order_class%% .dipi-svg-animator-inner-wrapper",
            'declaration' => sprintf('justify-content: %1$s !important;', $align),
        ));
    }
}

new DIPI_SVGAnimator;
