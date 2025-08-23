<?php

if (!class_exists('DIPI_Builder_Module')) {
    abstract class DIPI_Builder_Module extends ET_Builder_Module
    {
        public function __construct() {
            parent::__construct();
            if (strpos(get_class($this), 'DS_') !== 0) {
                require_once plugin_dir_path(__FILE__) . '../../utils/migrations/Migration.php';
                DIPI_Builder_Module_Settings_Migration::init();
            }
        }

        protected $responsive_views = [
            'desktop' => '',
            'tablet' => '980',
            'phone' => '767',
        ];

        protected function get_divi_layouts() {
            global $wpdb;
            
            $layouts = $wpdb->get_results($wpdb->prepare(
                "SELECT ID,post_title FROM $wpdb->posts
                WHERE post_type=%s",
                sanitize_text_field('et_pb_layout')
            ));
            
            $layouts_list = [
                '0' => __('Select A Layout', 'dipi-divi-pixel')
            ];
            
            if ( count($layouts) ) {
                foreach ( $layouts as $layout ){
                    $layouts_list[$layout->ID] = $layout->post_title;
                }
            }
            
            return $layouts_list;
        }

        protected function dipi_get_responsive_prop($property, $default = '', $default_if_empty = true, $base_name = '')
        {
            $responsive_prop = [];
            $responsive_enabled = isset($this->props["{$property}_last_edited"]) ? et_pb_get_responsive_status($this->props["{$property}_last_edited"]) : false;

            if (!empty($base_name)) {
                $responsive_enabled = isset($this->props["{$base_name}_last_edited"]) ? et_pb_get_responsive_status($this->props["{$base_name}_last_edited"]) : false;
            }

            if (!isset($this->props[$property]) || ($default_if_empty && '' === $this->props[$property])) {
                $responsive_prop["desktop"] = $default;
            } else {
                $responsive_prop["desktop"] = $this->props[$property];
            }

            if (!$responsive_enabled || !isset($this->props["{$property}_tablet"]) || '' === $this->props["{$property}_tablet"]) {
                $responsive_prop["tablet"] = $responsive_prop["desktop"];
            } else {
                $responsive_prop["tablet"] = $this->props["{$property}_tablet"];
            }

            if (!$responsive_enabled || !isset($this->props["{$property}_phone"]) || '' === $this->props["{$property}_phone"]) {
                $responsive_prop["phone"] = $responsive_prop["tablet"];
            } else {
                $responsive_prop["phone"] = $this->props["{$property}_phone"];
            }

            return $responsive_prop;
        }

        /**
         * FIXME: this function seems duplicte with dipi_get_responsive_prop
         */
        protected function dipi_get_responsive_value($property, $default, $responsive_status)
        {
            if (!$responsive_status) {
                return $default;
            }
    
            if (!isset($this->props[$property])) {
                return $default;
            }
    
            if ('' === $this->props[$property]) {
                return $default;
            }
    
            return $this->props[$property];
    
        }

        protected function sanitize_content($content)
        {
            return preg_replace('/^<\/p>(.*)<p>/s', '$1', $content);
        }

        protected function process_content($content)
        {
            $content = $this->sanitize_content($content);
            $content = str_replace(["&#91;", "&#93;"], ["[", "]"], $content);
            $content = do_shortcode($content);
            $content = str_replace(
                ["<p><div", "</div></p>", "</div> <!-- .et_pb_section --></p>"],
                ["<div", "</div>", "</div>"],
                $content
            );
            return $content;
        }

        protected function startsWith($string, $startString)
        {
            // if(!$string || strlen($string) < strlen($startString)){
            //     return false;
            // }

            $len = strlen($startString);
            return (substr($string, 0, $len) === $startString);
        }

        /**
         * Utility function to generate font icon styles which is necessary since Divi 4.13.
         * For backwardscompatibility, we only take action if the process_extended_icon is
         * available, which isn't the case in Divi 4.12. There is a copy of this function in
         * classes which are based on the ET_Builder_Module_Type_PostBased so if there is a
         * change made here, also make it there (e. g. BlogSlider)
         *
         * @param String $render_slug The modules render slug
         * @param String $property_name The name of the icon property
         * @param String $selector The selector of the element containing the font icon
         * @since 2.5.3
         */
        protected function dipi_generate_font_icon_styles($render_slug, $property_name, $selector)
        {
            if (method_exists('ET_Builder_Module_Helper_Style_Processor', 'process_extended_icon')) {
                
                $this->generate_styles(
                    array(
                        'utility_arg' => 'icon_font_family',
                        'render_slug' => $render_slug,
                        'base_attr_name' => $property_name,
                        'important' => true,
                        'selector' => $selector,
                        'processor' => array(
                            'ET_Builder_Module_Helper_Style_Processor',
                            'process_extended_icon',
                        ),
                    )
                );

                $font_icon = $this->props[$property_name];
                add_filter('et_late_global_assets_list', function ($assets, $assets_args, $et_dynamic_assets) use ($font_icon) {
                    if (isset($assets['et_icons_fa'])) {
                        return $assets;
                    }
                    
                    if (strpos($font_icon, '|fa|') !== false) {
                        $assets_prefix = et_get_dynamic_assets_path();
                        $assets['et_icons_fa'] = array(
                            'css' => "{$assets_prefix}/css/icons_fa_all.css",
                        );
                    }
                    
                    return $assets;
                }, 100, 3);
            }
        }

        protected static function render_library_layout($layoutId)
        {

            $module_slugs = ET_Builder_Element::get_module_slugs_by_post_type();
            $uuid = uniqid();
            // TODO: This array could be cached as it never changes (unlike the replacements which need the uuid)
            $map_to_regex = function ($value) {return '/' . $value . '_(\d+)(_tb_footer|)(,|\.|:| |")/';};
            $regex = array_map($map_to_regex, $module_slugs);

            $map_to_replacements = function ($value) use ($uuid) {return 'dipi_' . $uuid . '_' . $value . '_${1}${2}${3}';};
            $replacements = array_map($map_to_replacements, $module_slugs);

            $divi_library_shortcode = do_shortcode('[et_pb_section global_module="' . $layoutId . '"][/et_pb_section]');
            $divi_library_shortcode .= '<style type="text/css">' . str_replace(
                '.et-db #et-boc .et-l', '',
                ET_Builder_Element::get_style()) . '</style>';
            ET_Builder_Element::clean_internal_modules_styles(false);
            return is_admin() || dipi_is_vb() ? preg_replace($regex, $replacements, $divi_library_shortcode) : $divi_library_shortcode;
        }

        public function set_responsive_css($render_slug, $selector, $property, $values, $is_important = false)
        {
            $important = ($is_important) ? ' !important' : '';

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $selector,
                'declaration' => sprintf('%1$s: %2$s%3$s;', $property, $values['desktop'], $important),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $selector,
                'declaration' => sprintf('%1$s: %2$s%3$s;', $property, $values['tablet'], $important),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $selector,
                'declaration' => sprintf('%1$s: %2$s%3$s;', $property, $values['phone'], $important),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }
                
        /**
         * Utility function to generate spaceing field style like padding and margin
         *
         * @param  mixed $options
         * @return void
         */
        protected function dipi_process_spacing_field ($options) {
            $default = array(
                'render_slug'    => '',
                'slug'           => '',
                'css_property'   => '',
                'selector'       => '',
                'hover_selector' => '',
                'unit'           => 'px',
                'important'  => true,
                'negative'   => false,
                'fixed_unit' => ''
            );
            $options = wp_parse_args( $options, $default );
            
            extract($options); // phpcs:ignore WordPress.PHP.DontExtract
            $default_value = (isset($options['default_value']) && !empty($options['default_value']))? $options['default_value'] : '0px|0px|0px|0px';
            $important = ($important) ? ' !important' : '';
            $values = $this->dipi_get_responsive_prop($slug, $default_value, false);
            $spacing = $values['desktop'];
            $spacing_tablet = $values['tablet'];
            $spacing_phone = $values['phone'];
            
            if(isset($spacing) && !empty($spacing)) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $selector,
                    'declaration' => et_builder_get_element_style_css($spacing, $css_property, $important)
                ));
            }
            if(isset($spacing_tablet) && !empty($spacing_tablet)) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $selector,
                    'declaration' => et_builder_get_element_style_css($spacing_tablet, $css_property, $important),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980')
                ));
            }
            if(isset($spacing_phone) && !empty($spacing_phone)) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $selector,
                    'declaration' => et_builder_get_element_style_css($spacing_phone, $css_property, $important),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767')
                ));
            }
            
            if (et_builder_is_hover_enabled( $slug, $this->props ) && isset($this->props[$slug.'__hover']) && $hover_selector !== '') {
                $hover_value = $this->props[$slug.'__hover'];
                if(isset($hover_value) && !empty($hover_value)) {
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector' => $hover_selector,
                        'declaration' => et_builder_get_element_style_css($hover_value, $css_property, $important)
                    ));
                } 
            }
        }
         
        protected function dipi_add_bg_field($fields, $bg_options){
            $default_options = [
                'label'          => esc_html__( 'Setting',  'dipi-divi-pixel'),
                'description'    => esc_html__( 'Adjust the background style', 'dipi-divi-pixel' ),
                'default'        => 'white',
                'hover'          => 'tabs',
                'mobile_options' => true,
                'sticky'         => true,
                'has_gradient'   => true,
                'has_image'      => false 
            ];
            $options = array_merge($default_options, $bg_options);

            $background_fields = ET_Builder_Element::generate_background_options( "{$options['name']}_bg", "color", $options['tab_slug'], $options['toggle_slug'], "{$options['name']}_bg_color");
            $background_fields = $options['has_gradient'] === true ? 
                array_merge(
                    $background_fields,
                    ET_Builder_Element::generate_background_options( "{$options['name']}_bg", 'gradient', $options['tab_slug'], $options['toggle_slug'] , "{$options['name']}_bg_gradient")
                ) : $background_fields;
                

            $background_fields = $options['has_image'] === true ? 
            array_merge(
                $background_fields,
                ET_Builder_Element::generate_background_options( "{$options['name']}_bg", "image", $options['tab_slug'], $options['toggle_slug'], "{$options['name']}_bg_image")
            ) : $background_fields;
 

            $fields[ "{$options['name']}_bg_color" ] = array(
				'label'             => sprintf( esc_html__( '%1$s Background', 'dipi-divi-pixel' ), $options['label'] ),
				'description'       => $options['description'],
				'type'              => 'background-field',
				'base_name'         => "{$options['name']}_bg",
				'context'           => "{$options['name']}_bg",
				'option_category'   => 'layout',
				'custom_color'      => true,
				'default'           => $options['default'],
				'toggle_slug'       => $options['toggle_slug'],
                'tab_slug'          => $options['tab_slug'],
				'background_fields' => $background_fields, 
				'hover'             => $options['hover'],
				'mobile_options'    => $options['mobile_options'],
				'sticky'            => $options['sticky']
			);
            if(isset($options['show_if']))
                $fields[ "{$options['name']}_bg_color" ]['show_if'] = $options['show_if'];
                
            
            if(isset($options['sub_toggle']))
                $fields[ "{$options['name']}_bg_color" ]['sub_toggle'] = $options['sub_toggle'];
            $fields = array_merge(
                $fields,
                $this->generate_background_options( "{$options['name']}_bg", 'skip', $options['tab_slug'],  $options['toggle_slug'], "{$options['name']}_bg_color" ) 
            );

            $fields = $options['has_gradient'] === true ? array_merge(
                $fields,
                $this->generate_background_options( "{$options['name']}_bg", 'skip', $options['tab_slug'],  $options['toggle_slug'], "{$options['name']}_bg_gradient" ) 
            ) : $fields;

            $fields = $options['has_image'] === true ? array_merge(
                $fields,
                $this->generate_background_options( "{$options['name']}_bg", 'skip', $options['tab_slug'],  $options['toggle_slug'], "{$options['name']}_bg_image" ) 
            ) : $fields;
  
            return $fields;
        }
        protected function set_background_css($render_slug, $selector, $selector_hover, $base_name, $option_name, $important = true)
        {
            $important = $important ? '!important' : '';

            if (empty($option_name) || empty($selector)) {
                return;
            }

            $rs_image = [];
            $rs_style = ['desktop' => '', 'tablet' => '', 'phone' => ''];
            $rs_color = $this->dipi_get_responsive_prop($option_name);
            $use_stops = isset($this->props[$option_name . "_gradient_stops"]) ? true : false;
            
            $rs_gradient_start = $rs_gradient_end = $rs_gradient_start_position = $rs_gradient_end_position = $gradient_stops = null;           

            $rs_use_gradient = $this->dipi_get_responsive_prop($base_name . "_use_color_gradient", '', true, $option_name);
            $rs_gradient_type = $this->dipi_get_responsive_prop($option_name . "_gradient_type", '', true, $option_name);
            $rs_gradient_direction = $this->dipi_get_responsive_prop($option_name . "_gradient_direction", '', true, $option_name);
            $rs_direction_radial = $this->dipi_get_responsive_prop($option_name . "_gradient_direction_radial", '', true, $option_name);

            if($use_stops) {
                $gradient_stops  = $this->dipi_get_responsive_prop($option_name . "_gradient_stops", '', true, $option_name);
                
            } else {
                $rs_gradient_start = $this->dipi_get_responsive_prop($option_name . "_gradient_start", '', true, $option_name);
                $rs_gradient_end = $this->dipi_get_responsive_prop($option_name . "_gradient_end", '', true, $option_name);
                $rs_gradient_start_position = $this->dipi_get_responsive_prop($option_name . "_gradient_start_position", '', true, $option_name);
                $rs_gradient_end_position = $this->dipi_get_responsive_prop($option_name . "_gradient_end_position", '', true, $option_name);
            }
           
            $rs_gradient_overlays_image = $this->dipi_get_responsive_prop($option_name . "_gradient_overlays_image", '', true, $option_name);
            
            $rs_bg_image = $this->dipi_get_responsive_prop($base_name . "_image", '', true, $base_name);
            $rs_bg_parallax = $this->dipi_get_responsive_prop($base_name . "_parallax", 'off', false, $base_name);
            
            $background_style = [];
            $rs_gradient = [];
            foreach ($this->responsive_views as $view => $size) {

                // Process Gredient
                if ('on' === $rs_use_gradient[$view]) {
                    if($rs_gradient_type[$view] === 'circular' || $rs_gradient_type[$view] === 'radial'){
                        $rs_gradient_direction[$view] = "circle at {$rs_direction_radial[$view]}";
                    }else if($rs_gradient_type[$view] === 'elliptical'){
                        $rs_gradient_direction[$view] = "ellipse at {$rs_direction_radial[$view]}";
                    }else if($rs_gradient_type[$view] === 'conic'){
                        $rs_gradient_direction[$view] = "from {$rs_gradient_direction[$view]} at {$rs_direction_radial[$view]}";
                    }
        
                    if($rs_gradient_type[$view] === 'linear' || $rs_gradient_type[$view] === 'conic'){
                        $rs_gradient[$view] = "{$rs_gradient_type[$view]}-gradient({$rs_gradient_direction[$view]},";
                    } else if($rs_gradient_type[$view] === 'circular' || $rs_gradient_type[$view] === 'elliptical' || $rs_gradient_type[$view] === 'radial') {
                        $rs_gradient[$view] = "radial-gradient({$rs_gradient_direction[$view]},";
                    }  

                    if($use_stops) {
                        $rs_gradient[$view] .= str_replace('|', ',', $gradient_stops[$view]);
                    } else {
                        $rs_gradient_start_position[$view] = et_sanitize_input_unit($rs_gradient_start_position[$view], false, '%');
                        $rs_gradient_end_position[$view] = et_sanitize_input_unit($rs_gradient_end_position[$view], false, '%');
                        $rs_gradient[$view] .= "{$rs_gradient_start[$view]} {$rs_gradient_start_position[$view]},{$rs_gradient_end[$view]} {$rs_gradient_end_position[$view]}";
                    }
                    
                    $rs_gradient[$view] .= ")";
                    if (!empty($rs_gradient[$view])) {
                        $rs_image[$view][] = $rs_gradient[$view];
                    }
                }

                // Process Image BG
                $is_bg_image_active = '' !== $rs_bg_image[$view] && 'on' !== $rs_bg_parallax[$view];
                $bg_prop_view = ($view !== 'desktop') ? '_' . $view : '';
                $background_style[$view] = '';

                if ($is_bg_image_active) {
                    $has_bg_image = true;
                    $bg_size = $this->props["{$base_name}_size{$bg_prop_view}"];
                    if ('' !== $bg_size) {
                        $background_style[$view] .= sprintf(
                            'background-size: %1$s %2$s;',
                            esc_html($bg_size),
                            $important
                        );
                    }

                    $bg_position = $this->props["{$base_name}_position{$bg_prop_view}"];
                    if ('' !== $bg_position) {
                        $background_style[$view] .= sprintf(
                            'background-position: %1$s %2$s; ',
                            esc_html(str_replace('_', ' ', $bg_position)),
                            $important
                        );
                    }

                    $bg_repeat = $this->props["{$base_name}_repeat{$bg_prop_view}"];
                    if ('' !== $bg_repeat) {
                        $background_style[$view] .= sprintf(
                            'background-repeat: %1$s  %2$s; ',
                            esc_html($bg_repeat),
                            $important
                        );
                    }

                    $bg_blend = $this->props["{$base_name}_blend{$bg_prop_view}"];
                    if ('' !== $bg_blend) {
                        $background_style[$view] .= sprintf(
                            'background-blend-mode: %1$s %2$s;',
                            esc_html($bg_blend),
                            $important
                        );
                    }
                    $rs_image[$view][] = sprintf('url(%1$s)', esc_html($rs_bg_image[$view]));
                }

                if (!empty($rs_image[$view])) {
                    if ('on' !== $rs_gradient_overlays_image[$view]) {
                        $rs_image[$view] = array_reverse($rs_image[$view]);
                    }

                    $rs_style[$view] .= sprintf(
                            'background-image: %1$s %3$s;%2$s',
                                esc_html(join(', ', $rs_image[$view])),
                                $background_style[$view],
                                $important
                        );
                }
                // Solid Color Style
                if ('' !== $rs_color[$view]) {
                    $rs_style[$view] .= sprintf('background-color: %1$s %2$s; ',
                                    esc_html($rs_color[$view]),
                                    $important
                                );
                }

                // Push the actual style
                if ('' !== $rs_style[$view]) {
                    $style_arr = [
                        'selector' => $selector,
                        'declaration' => rtrim($rs_style[$view]),
                    ];

                    if ($view !== 'desktop') {
                        $style_arr['media_query'] = ET_Builder_Element::get_media_query('max_width_' . $size);
                    }

                    ET_Builder_Element::set_style($render_slug, $style_arr);
                }
            }

            // Background Hover
            //TODO: Make it responsive.
            if (et_builder_is_hover_enabled($option_name, $this->props)) {

                $ob_image_hover = [];
                $ob_style_hover = '';

                if (isset($this->props[$base_name . "_use_color_gradient__hover"]) && 'on' === $this->props[$base_name . "_use_color_gradient__hover"]) {

                    $use_stops = isset($this->props[$option_name . "_gradient_stops__hover"]) ? true : false;
                    $gradient_start = $gradient_end = $gradient_start_position = $gradient_end_position = $gradient_stops = null;   

                    $ob_type_hover = isset($this->props[$option_name . "_gradient_type__hover"]) ? $this->props[$option_name . "_gradient_type__hover"] : 'linear';
                    $ob_direction_hover = isset($this->props[$option_name . "_gradient_direction__hover"]) ? $this->props[$option_name . "_gradient_direction__hover"] : '180deg';
                    $ob_direction_radial_hover = isset($this->props[$option_name . "_gradient_direction_radial__hover"]) ? $this->props[$option_name . "_gradient_direction_radial__hover"] : 'circle';
                    $ob_start_hover = isset($this->props[$option_name . "_gradient_start__hover"]) ? $this->props[$option_name . "_gradient_start__hover"] : '#2b87da';
                    $ob_end_hover = isset($this->props[$option_name . "_gradient_end__hover"]) ? $this->props[$option_name . "_gradient_end__hover"] : '#29c4a9';
                    $ob_start_position_hover = isset($this->props[$option_name . "_gradient_start_position__hover"]) ? $this->props[$option_name . "_gradient_start_position__hover"] : '0%';
                    $ob_end_position_hover = isset($this->props[$option_name . "_gradient_end_position__hover"]) ? $this->props[$option_name . "_gradient_end_position__hover"] : '100%';
                    $ob_overlays_image_hover = isset($this->props[$option_name . "_gradient_overlays_image__hover"]) ? $this->props[$option_name . "_gradient_overlays_image__hover"] : 'off';

                    if($use_stops) {
                        $gradient_stops  = $this->props[$option_name . "_gradient_stops__hover"];
                    } 

                    $overlay_direction_hover = $ob_type_hover === 'linear' ? $ob_direction_hover : "circle at {$ob_direction_radial_hover}";
                    $overlay_start_position_hover = et_sanitize_input_unit($ob_start_position_hover, false, '%');
                    $overlay_end_position_hover = et_sanitize_input_unit($ob_end_position_hover, false, '%');

                    if($use_stops) {
                        $gradient_bg_hover = "
                        {$ob_type_hover}-gradient($overlay_direction_hover," . str_replace('|', ',', $gradient_stops) . ")";
                    }else {
                        $gradient_bg_hover = "
                        {$ob_type_hover}-gradient($overlay_direction_hover,
                        {$ob_start_hover}
                        {$overlay_start_position_hover},
                        {$ob_end_hover}
                        {$overlay_end_position_hover}
                    )";
                    }
      
                    if (!empty($gradient_bg_hover)) {
                        $ob_image_hover[] = $gradient_bg_hover;
                    }

                }

                if (!empty($ob_image_hover)) {
                    if ('on' !== $ob_overlays_image_hover) {
                        $ob_image_hover = array_reverse($ob_image_hover);
                    }

                    $ob_style_hover .= sprintf(
                        'background-image: %1$s %2$s;',
                        esc_html(join(', ', $ob_image_hover)),
                        $important
                    );
                }

                $ob_color_hover = (isset($this->props[$base_name . "_color__hover"]) && !empty($this->props[$base_name . "_color__hover"]))?$this->props[$base_name . "_color__hover"]:'';

                if ('' !== $ob_color_hover) {
                    $ob_style_hover .= sprintf(
                        'background-color: %1$s %2$s;',
                        esc_html($ob_color_hover),
                        $important
                    );
                }

                if ('' !== $ob_style_hover) {
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector' => $selector_hover,
                        'declaration' => rtrim($ob_style_hover),
                    ));
                }
            }
        }

        /**
        * Parallax Image Background
        */
        protected function process_parallax_image_bg($base_name)
        {
            $bg_image = $this->props["{$base_name}_image"];
            $parallax = $this->props["{$base_name}_parallax"];
            $parallax_method = $this->props["{$base_name}_parallax_method"];
            $parallax_classname = [];

            if ('' !== $bg_image && 'on' === $parallax) {
                $parallax_classname[] = 'et_parallax_bg';
                if ('off' === $parallax_method) {
                    $parallax_classname[] = 'et_pb_parallax_css';
                }
            }

            return sprintf(
                '<span class="et_parallax_bg_wrap"><span
                class="%1$s"
                style="background-image: url(%2$s);"
            ></span></span>',
                esc_attr(implode(' ', $parallax_classname)),
                esc_url($bg_image)
            );
        }
        protected function process_range_field_css( $options = array() ) {
          
            $default = array(
                'render_slug'       => '',
                'slug'              => '',
                'type'              => '',
                'selector'          => '',
                'unit'              => '%',
                'hover'             => '',
                'important'         => true,
                'default'           => '14',
                'negative'          => false,
                'fixed_unit'        => ''
            );
            $options        = wp_parse_args( $options, $default );
            extract($options); // phpcs:ignore WordPress.PHP.DontExtract

            $important_text = $important !== false ? '!important' : '';
            $ng_value = $negative === true ? '-' : '';

            $desktop = isset($this->props[$slug]) && $this->props[$slug] !== '' ?
            $this->props[$slug] : $default;
            $tablet = isset($this->props[$slug . '_tablet']) && $this->props[$slug . '_tablet'] !== '' ?
                $this->props[$slug . '_tablet'] : $desktop;
            $phone = isset($this->props[$slug . '_phone']) && $this->props[$slug . '_phone'] !== '' ?
                $this->props[$slug . '_phone'] : $tablet;

            if(!empty($fixed_unit)) {
                $desktop = $desktop === 'auto'? 'auto' : intval($desktop) . $fixed_unit;
                $tablet = $tablet === 'auto'? 'auto' : intval($tablet) . $fixed_unit;
                $phone = $phone === 'auto'? 'auto' : intval($phone) . $fixed_unit;
            }

            if($desktop !== 'auto') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $selector,
                    'declaration' => sprintf('%1$s:%4$s%2$s%3$s;', $type, $desktop, $important_text,$ng_value),
                ));
            }
            if($tablet !== 'auto') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $selector,
                    'declaration' => sprintf('%1$s:%4$s%2$s%3$s;', $type, $tablet,$important_text,$ng_value),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                ));
            }
            if($phone !== 'auto') {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $selector,
                    'declaration' => sprintf('%1$s:%4$s%2$s%3$s;', $type, $phone,$important_text,$ng_value),
                    'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                ));
            }
            
            
            if (et_builder_is_hover_enabled( $slug, $this->props ) && isset($this->props[$slug.'__hover']) && $hover !== '') {
                $hover_value = $this->props[$slug.'__hover'];
                if ( !empty($hover_value)) {
                    if($hover_value !== 'auto') {
                        ET_Builder_Element::set_style($render_slug, array(
                            'selector' => $hover,
                            'declaration' => sprintf('%1$s:%4$s%2$s %3$s;', $type, $hover_value, $important_text,$ng_value),
                        ));
                    }
                } 
            }
        }
        protected function process_color_field_css( $options = array() ) {
           
            $default = array(
                'module'            => '',
                'render_slug'       => '',
                'slug'              => '',
                'type'              => '',
                'selector'          => '',
                'hover'             => '',
                'important'         => true
            );
            $options        = wp_parse_args( $options, $default );
            extract($options); // phpcs:ignore WordPress.PHP.DontExtract
            $module = $this;
            $key = isset($module->props[$slug]) ? $module->props[$slug] : '';
            $important_text = true === $important ? '!important' : '';
            
            if ('' !== $key) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $selector,
                    'declaration' => sprintf('%2$s: %1$s %3$s;', $key, $type, $important_text),
                ));
            }
            if ( et_builder_is_hover_enabled( $slug, $module->props ) && isset($module->props[$slug . '__hover']) ) {
                $slug_hover = $module->props[$slug . '__hover'];
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => $hover,
                    'declaration' => sprintf('%2$s: %1$s %3$s;', $slug_hover, $type, $important_text),
                ));
            }
            if (empty($this->props[$slug . '_tablet'])) {
                $this->props[$slug . '_tablet'] = $this->props[$slug];
            }
            if (empty($this->props[$slug . '_phone'])) {
                $this->props[$slug . '_phone'] = $this->props[$slug . '_tablet'];
            }
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $selector,
                'declaration' => sprintf('%2$s: %1$s %3$s;', $this->props[$slug . '_tablet'], $type, $important_text),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $selector,
                'declaration' => sprintf('%2$s: %1$s %3$s;', $this->props[$slug . '_phone'], $type, $important_text),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));

        }
        protected function dipi_get_custom_style($slug_value, $type, $important)
        {
                return sprintf('%1$s: %2$s%3$s;', $type, $slug_value, $important ? ' !important' : '');
        }

        protected function dipi_apply_custom_style_for_phone(
                $function_name,
                $slug,
                $type,
                $class,
                $important = false,
                $zoom = '',
                $unit = '',
                $wrap_func = '' /* traslate, clac ... */
        ) {
                if (empty($this->props[$slug . '_tablet'])) {
                        $this->props[$slug . '_tablet'] = $this->props[$slug];
                }
                if (empty($this->props[$slug . '_phone'])) {
                        $this->props[$slug . '_phone'] = $this->props[$slug . '_tablet'];
                }
                if ($zoom === '') {
                        $slug_value = $this->props[$slug] . $unit;
                        $slug_value_tablet = $this->props[$slug . '_tablet'] . $unit;
                        $slug_value_phone = $this->props[$slug . '_phone'] . $unit;
                } else {
                        $slug_value = ((float) $this->props[$slug] * $zoom) . $unit;
                        $slug_value_tablet = ((float) $this->props[$slug . '_tablet'] * $zoom) . $unit;
                        $slug_value_phone = ((float) $this->props[$slug . '_phone'] * $zoom) . $unit;
                }
                if ($wrap_func !== '') {
                        $slug_value = "$wrap_func($slug_value)";
                        $slug_value_tablet = "$wrap_func($slug_value_tablet)";
                        $slug_value_phone = "$wrap_func($slug_value_phone)";
                }

                if (isset($slug_value_phone)
                        && !empty($slug_value_phone)) {
                        ET_Builder_Element::set_style($function_name, array(
                                'selector' => $class,
                                'declaration' => $this->dipi_get_custom_style($slug_value_phone, $type, $important),
                                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                        ));
                }
        }

        protected function dipi_apply_custom_style_for_tablet(
                $function_name,
                $slug,
                $type,
                $class,
                $important = false,
                $zoom = '',
                $unit = '',
                $wrap_func = '' /* traslate, clac ... */
        ) {
                if (empty($this->props[$slug . '_tablet'])) {
                        $this->props[$slug . '_tablet'] = $this->props[$slug];
                }
                if ($zoom === '') {
                        $slug_value = $this->props[$slug] . $unit;
                        $slug_value_tablet = $this->props[$slug . '_tablet'] . $unit;
                        $slug_value_phone = $this->props[$slug . '_phone'] . $unit;
                } else {
                        $slug_value = ((float) $this->props[$slug] * $zoom) . $unit;
                        $slug_value_tablet = ((float) $this->props[$slug . '_tablet'] * $zoom) . $unit;
                        $slug_value_phone = ((float) $this->props[$slug . '_phone'] * $zoom) . $unit;
                }
                if ($wrap_func !== '') {
                        $slug_value = "$wrap_func($slug_value)";
                        $slug_value_tablet = "$wrap_func($slug_value_tablet)";
                        $slug_value_phone = "$wrap_func($slug_value_phone)";
                }

                if (isset($slug_value_tablet)
                        && !empty($slug_value_tablet)) {
                        ET_Builder_Element::set_style($function_name, array(
                                'selector' => $class,
                                'declaration' => $this->dipi_get_custom_style($slug_value_tablet, $type, $important),
                                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                        ));
                }
        }

        protected function dipi_apply_custom_style_for_desktop(
                $function_name,
                $slug,
                $type,
                $class,
                $important = false,
                $zoom = '',
                $unit = '',
                $wrap_func = '' /* traslate, clac ... */
        ) {
                if ($zoom === '') {
                        $slug_value = $this->props[$slug] . $unit;
                        $slug_value_tablet = $this->props[$slug . '_tablet'] . $unit;
                        $slug_value_phone = $this->props[$slug . '_phone'] . $unit;
                } else {
                        $slug_value = ((float) $this->props[$slug] * $zoom) . $unit;
                        $slug_value_tablet = ((float) $this->props[$slug . '_tablet'] * $zoom) . $unit;
                        $slug_value_phone = ((float) $this->props[$slug . '_phone'] * $zoom) . $unit;
                }
                if ($wrap_func !== '') {
                        $slug_value = "$wrap_func($slug_value)";
                        $slug_value_tablet = "$wrap_func($slug_value_tablet)";
                        $slug_value_phone = "$wrap_func($slug_value_phone)";
                }

                if (isset($slug_value) && !empty($slug_value)) {
                        ET_Builder_Element::set_style($function_name, array(
                                'selector' => $class,
                                'declaration' => $this->dipi_get_custom_style($slug_value, $type, $important),
                        ));
                }
        }

        protected function dipi_apply_custom_style_for_hover(
                $function_name,
                $slug,
                $type,
                $class,
                $important = false
        ) {

                $slug_hover_enabled = isset($this->props[$slug . '__hover_enabled']) ? substr($this->props[$slug . '__hover_enabled'], 0, 2) === "on" : false;
                $slug_hover_value = isset($this->props[$slug . '__hover']) ? $this->props[$slug . '__hover'] : '';
                if (isset($slug_hover_value)
                        && !empty($slug_hover_value)
                        && $slug_hover_enabled) {
                        ET_Builder_Element::set_style($function_name, array(
                                'selector' => $class,
                                'declaration' => $this->dipi_get_custom_style($slug_hover_value, $type, $important),
                        ));
                }
        }

        protected function dipi_apply_custom_style(
            $function_name,
            $slug,
            $type,
            $class,
            $important = false,
            $zoom = '',
            $unit = '',
            $wrap_func = '' /* traslate, clac ... */
        ) {
            $slug_value_responsive_active = isset($this->props[$slug . '_last_edited']) ? et_pb_get_responsive_status($this->props[$slug . '_last_edited']) : false;                    
            if ($zoom == '') {
                $slug_value = $this->props[$slug] . $unit;
            } else {
                $slug_value = ((float) $this->props[$slug] * $zoom) . $unit;
            }
            if ($wrap_func !== '') {
                $slug_value = "$wrap_func($slug_value)";
            }
            if (isset($slug_value) && !empty($slug_value)) {
                ET_Builder_Element::set_style($function_name, array(
                    'selector' => $class,
                    'declaration' => $this->dipi_get_custom_style($slug_value, $type, $important),
                ));
            }
            if ($slug_value_responsive_active) {
                if ($zoom == '') {
                    $slug_value_tablet = $this->props[$slug . '_tablet'] . $unit;
                    $slug_value_phone = $this->props[$slug . '_phone'] . $unit;
                } else {
                    $slug_value_tablet = ((float) $this->props[$slug . '_tablet'] * $zoom) . $unit;
                    $slug_value_phone = ((float) $this->props[$slug . '_phone'] * $zoom) . $unit;
                }
                if ($wrap_func !== '') {
                    $slug_value_tablet = "$wrap_func($slug_value_tablet)";
                    $slug_value_phone = "$wrap_func($slug_value_phone)";
                }
                if (isset($slug_value_tablet)
                    && !empty($slug_value_tablet)
                ) {
                    ET_Builder_Element::set_style($function_name, array(
                        'selector' => $class,
                        'declaration' => $this->dipi_get_custom_style($slug_value_tablet, $type, $important),
                        'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                    ));
                }

                if (isset($slug_value_phone)
                    && !empty($slug_value_phone)
                ) {
                    ET_Builder_Element::set_style($function_name, array(
                        'selector' => $class,
                        'declaration' => $this->dipi_get_custom_style($slug_value_phone, $type, $important),
                        'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                    ));
                }
            }

             $this->dipi_apply_custom_style_for_hover(
                $function_name,
                $slug,
                $type,
                "$class:hover",
                $important
            );
            
        }
        public function dipi_apply_custom_margin_padding($function_name, $slug, $type, $class, $important = true)
        {
            $slug_value = $this->props[$slug];
            $slug_value_responsive_active = isset($this->props[$slug . '_last_edited']) ? et_pb_get_responsive_status($this->props[$slug . '_last_edited']) : false;

            if (isset($slug_value) && !empty($slug_value)) {
                    ET_Builder_Element::set_style($function_name, array(
                            'selector' => $class,
                            'declaration' => et_builder_get_element_style_css($slug_value, $type, $important),
                    ));
            }

            if ($slug_value_responsive_active) {
                $slug_value_tablet = $this->props[$slug . '_tablet'];
                $slug_value_phone = $this->props[$slug . '_phone'];
                if(isset($slug_value_tablet) && !empty($slug_value_tablet)) {
                    ET_Builder_Element::set_style($function_name, array(
                            'selector' => $class,
                            'declaration' => et_builder_get_element_style_css($slug_value_tablet, $type, $important),
                            'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
                    ));
                }
                if (isset($slug_value_phone) && !empty($slug_value_phone)) {
                    ET_Builder_Element::set_style($function_name, array(
                            'selector' => $class,
                            'declaration' => et_builder_get_element_style_css($slug_value_phone, $type, $important),
                            'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
                    ));
                }
            } 
        }
        private static function dipi_file_get_contents($src)
        {
            if ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443)) {
                $options = ["ssl" => [
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ]];

                $svg_content = file_get_contents($src, false, stream_context_create($options));
            } else {
                $svg_content = file_get_contents($src);
            }
            if (!$svg_content) {
                $svg_content = self::dipi_curl_get_contents($src);
            }
            return $svg_content;
        }
        private static function dipi_curl_get_contents($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
            $html = curl_exec($ch);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
        private static function dipi_curl_file_get_contents($src)
        {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_URL, $src);
            $contents = curl_exec($curl);
            curl_close($curl);

            if ($contents) {
                return $contents;
            } else {
                return FALSE;
            } 
        }
        public static function dipi_get_url_content($src) {
            if (!$src) {
                return '';
            }
            $url_content = '';
            if (ini_get('allow_url_fopen')) {
                $url_content = self::dipi_file_get_contents($src);
            } else {
                // $svg_content = '<p>' . esc_html__('Your server has disabled \'allow_url_fopen\'. You must use SVG from your media library or paste link from same domain as - ', 'dipi-divi-pixel') . $_SERVER['HTTP_HOST'] . '</p>';
                $url_content = self::dipi_curl_file_get_contents($src);
            }
            return $url_content;
        }
    }
}
