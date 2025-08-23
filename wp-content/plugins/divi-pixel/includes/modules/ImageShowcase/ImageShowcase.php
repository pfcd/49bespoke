<?php
function rocket_lazyload_exclude_dipi_imageshowcase_class( array $attributes  ) {

    $attributes[] = 'class="div-pixel-mockup-img';

    return $attributes;
}
add_filter( 'rocket_lazyload_excluded_attributes', 'rocket_lazyload_exclude_dipi_imageshowcase_class' );
class DIPI_ImageShowcase extends DIPI_Builder_Module
{

    public $slug = 'dipi_image_showcase';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/image-showcase',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__('Pixel Image Showcase', 'dipi-divi-pixel');
        $this->child_slug = 'dipi_image_showcase_child';
        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'main_content' => esc_html__('Image Showcase Settings', 'dipi-divi-pixel'),
                    'carousel' => esc_html__('Carousel Settings', 'dipi-divi-pixel')
                ],
            ],
        ];
    }

    public function get_fields()
    {
        $fields = [];

        $fields['mockup_base_url'] = [
            'type' => 'hidden',
            'option_category' => 'basic_option',
            'toggle_slug' => 'main_content',
            'tab_slug' => 'general',
            'default' => plugins_url('/', __FILE__),
            'default_on_front' => plugins_url('/', __FILE__),
        ];

        $fields['mockup'] = [
            'label' => esc_html__('Showcase Mockup', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => array(
                esc_html__('iMac Front', 'dipi-divi-pixel'),
                esc_html__('iMac Left', 'dipi-divi-pixel'),
                esc_html__('iMac Right', 'dipi-divi-pixel'),
                esc_html__('iMac White Front', 'dipi-divi-pixel'),
                esc_html__('iMac White Left', 'dipi-divi-pixel'),
                esc_html__('iMac White Right', 'dipi-divi-pixel'),
                esc_html__('iPad Front', 'dipi-divi-pixel'),
                esc_html__('iPad Left', 'dipi-divi-pixel'),
                esc_html__('iPad Right', 'dipi-divi-pixel'),
                esc_html__('MacBook Front', 'dipi-divi-pixel'),
                esc_html__('MacBook Right', 'dipi-divi-pixel'),
                esc_html__('MacBook Left', 'dipi-divi-pixel'),
                esc_html__('MacBook White Front', 'dipi-divi-pixel'),
                esc_html__('MacBook White Right', 'dipi-divi-pixel'),
                esc_html__('MacBook White Left', 'dipi-divi-pixel'),
                esc_html__('MacBook Floating White Left', 'dipi-divi-pixel'),
                esc_html__('MacBook Floating White Right', 'dipi-divi-pixel'),
                esc_html__('iPhone Front', 'dipi-divi-pixel'),
                esc_html__('iPhone Right', 'dipi-divi-pixel'),
                esc_html__('iPhone Left', 'dipi-divi-pixel'),
                esc_html__('iPhone Front White', 'dipi-divi-pixel'),
                esc_html__('iPhone Right White', 'dipi-divi-pixel'),
                esc_html__('iPhone Left White', 'dipi-divi-pixel'),
                esc_html__('iPhone Pro Front', 'dipi-divi-pixel'),
                esc_html__('iPhone Pro Right', 'dipi-divi-pixel'),
                esc_html__('iPhone Pro Left', 'dipi-divi-pixel')
            ),
            'default' => 'iMac Front',
            'option_category' => 'basic_option',
            'toggle_slug' => 'main_content',
            'data_type' => '',
        ];
        $fields['mockup_size'] = [
            'label' => esc_html__('Showcase Mockup Size', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => array(
                esc_html__('Large', 'dipi-divi-pixel'),
                esc_html__('Medium', 'dipi-divi-pixel'),
                esc_html__('Small', 'dipi-divi-pixel')
            ),
            'default' => 'Large',
            'option_category' => 'basic_option',
            'toggle_slug' => 'main_content',
            'data_type' => ''
        ];

       
        
        $fields['enable_vertical_scroll'] = [
            'label' => esc_html__('Enable Vertical Scroll', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'main_content',
            'description' => esc_html__('Enable this option to allow users to scroll your image vertically when mouseover.', 'dipi-divi-pixel')
           
        ];


        $fields['scroll_speed'] = [
            'label'          => esc_html('Hover Scroll Speed', 'dipi-divi-pixel'),
            'type'           => 'range',
            'default'        => 10,
            'unitless'       => true,
            'range_settings' => [
                'min'  => '1',
                'max'  => '50',
                'step' => '1'
            ],
            'toggle_slug' => 'main_content',
            'mobile_options' => true,
            'show_if' => [
                'enable_vertical_scroll' => 'on'
            ]
        ];

        $fields['back_scroll_speed'] = [
            'label'          => esc_html('Back Scroll Speed', 'dipi-divi-pixel'),
            'type'           => 'range',
            'unitless'       => true,
            'default'        => 5,
            'range_settings' => [
                'min'  => '1',
                'max'  => '50',
                'step' => '1'
            ],
            'toggle_slug' => 'main_content',
            'mobile_options' => true,
            'show_if' => [
                'enable_vertical_scroll' => 'on'
            ]
        ];

        $fields['effect'] = [
            'label' => esc_html__('Effect', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'layout',
            'options' => [
                'coverflow' => esc_html__('Coverflow', 'dipi-divi-pixel'),
                'slide' => esc_html__('Slide', 'dipi-divi-pixel'),
                'fade' => esc_html__('Fade', 'dipi-divi-pixel'),
            ],
            'default' => 'slide',
            'toggle_slug' => 'carousel',
        ];
        $fields['rotate'] = [
            'label' => esc_html('Rotate', 'dipi-divi-pixel'),
            'type' => 'range',
            'range_settings ' => [
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ],
            'default' => '50',
            'show_if' => [
                'effect' => 'coverflow',
            ],
            'validate_unit' => false,
            'toggle_slug' => 'carousel',
        ];
        $fields['speed'] = [
            'label' => esc_html__('Transition Duration', 'dipi-divi-pixel'),
            'type' => 'range',
            'range_settings' => [
                'min' => '1',
                'max' => '5000',
                'step' => '100',
            ],
            'default' => 500,
            'validate_unit' => false,
            'toggle_slug' => 'carousel',
        ];

        $fields['loop'] = [
            'label' => esc_html__('Loop', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'carousel',
        ];

        $fields['autoplay'] = [
            'label' => esc_html__('Autoplay', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'carousel',
        ];

        $fields['pause_on_hover'] = [
            'label' => esc_html__('Pause on Hover', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'show_if' => [
                'autoplay' => 'on',
            ],
            'toggle_slug' => 'carousel',
            'default' => 'on',
        ];

        $fields['autoplay_speed'] = [
            'label' => esc_html__('Autoplay Speed', 'dipi-divi-pixel'),
            'type' => 'range',
            'range_settings' => array(
                'min' => '1',
                'max' => '10000',
                'step' => '500',
            ),
            'default' => 5000,
            'validate_unit' => false,
            'show_if' => array(
                'autoplay' => 'on',
            ),
            'toggle_slug' => 'carousel',
        ];

        return $fields;
    }

    public function get_plugin_url($args = array(), $conditional_tags = array(), $current_page = array())
    {
        return DIPI_URI;
    }
    public function get_advanced_fields_config()
    {
        $advanced_fields = [
            'text' => false,
            'text_shadow' => false,
            'fonts' => false,
        ];

        return $advanced_fields;
    }
    public function get_carousel_content()
    {
        return $this->content;
    }

    private function get_mockup_url($mockup_name, $size = ''){
        $size_part = (!empty($size)) ? '-' . $size : ''; 
        $mockups_path = __DIR__ . '/' . sprintf('/mockups/%1$s%2$s.png', $mockup_name ,$size_part);
        if(file_exists($mockups_path)) { // return whatever requested size if exists.
            return plugins_url(sprintf('/mockups/%1$s%2$s.png', $mockup_name ,$size_part), __FILE__);
        }
        // at this point requested mockup size not exist
        if($size === 's'){ // If small size is requested try to get medium ( s -> m)
            return $this->get_mockup_url($mockup_name, 'm');
        }
        if($size === 'm') { // If medium size is requested try to get small, if small not exist get Larte (m -> s -> l)
            $mockups_path = __DIR__ . '/' . sprintf('/mockups/%1$s%2$s.png', $mockup_name ,'-s');
            if(file_exists($mockups_path)) {
                return plugins_url(sprintf('/mockups/%1$s%2$s.png', $mockup_name ,'-s'), __FILE__);
            } else {
                return $this->get_mockup_url($mockup_name);
            }
        }
        return false;
    }

    public function vertical_scroll_style($render_slug) {
        $back_scroll_speed = $this->props['back_scroll_speed'];


        $scroll_speed_class = "%%order_class%%:hover .divi-pixel-mockup-vs .dipi_image_showcase_child>.et_pb_module_inner img";
        $scroll_speed = $this->props['scroll_speed'];
        $scroll_speed_tablet = $this->props['scroll_speed_tablet'];
        $scroll_speed_phone = $this->props['scroll_speed_phone'];
        $scroll_speed_last_edited = $this->props['scroll_speed_last_edited'];
        $scroll_speed_responsive_status = et_pb_get_responsive_status($scroll_speed_last_edited);

        if('' !== $scroll_speed ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $scroll_speed_class,
                'declaration' => sprintf( 'transition: all %1$ss !important;', $scroll_speed ),
            ) );
        }

        if('' !== $scroll_speed_tablet && $scroll_speed_responsive_status) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $scroll_speed_class,
                'declaration' => sprintf( 'transition: all %1$ss !important;', $scroll_speed_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
        }

        if('' !== $scroll_speed_phone && $scroll_speed_responsive_status) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $scroll_speed_class,
                'declaration' => sprintf( 'transition: all %1$ss !important;', $scroll_speed_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }

  
        $back_scroll_speed_class = "%%order_class%% .divi-pixel-mockup-vs .dipi_image_showcase_child>.et_pb_module_inner img";
        $back_scroll_speed = $this->props['back_scroll_speed'];
        $back_scroll_speed_tablet = $this->props['back_scroll_speed_tablet'];
        $back_scroll_speed_phone = $this->props['back_scroll_speed_phone'];
        $back_scroll_speed_last_edited = $this->props['back_scroll_speed_last_edited'];
        $back_scroll_speed_responsive_status = et_pb_get_responsive_status($back_scroll_speed_last_edited);

        if('' !== $back_scroll_speed ) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $back_scroll_speed_class,
                'declaration' => sprintf('transition: all %1$ss !important;', $back_scroll_speed),
            ) );
        }

        if('' !== $back_scroll_speed_tablet && $back_scroll_speed_responsive_status) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $back_scroll_speed_class,
                'declaration' => sprintf( 'transition: all %1$ss !important;', $back_scroll_speed_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980')
            ));
        }

        if('' !== $back_scroll_speed_phone && $back_scroll_speed_responsive_status) {
            ET_Builder_Element::set_style( $render_slug, array(
                'selector' => $back_scroll_speed_class,
                'declaration' => sprintf( 'transition: all %1$ss !important;', $back_scroll_speed_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767')
            ));
        }
    }

    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_image_showcase_public');
        wp_enqueue_style('dipi_swiper');

        

        $get_carousel_content = $this->get_carousel_content();

        $speed = $this->props['speed'];
        $loop = $this->props['loop'];
        $autoplay = $this->props['autoplay'];
        $autoplay_speed = $this->props['autoplay_speed'];
        $pause_on_hover = $this->props['pause_on_hover'];
        $enable_vertical_scroll = $this->props['enable_vertical_scroll']? $this->props['enable_vertical_scroll'] : 'off';

        $effect = $this->props['effect'];
        $rotate = $this->props['rotate'];
        $options['data-columnsdesktop'] = esc_attr(1);

        $options['data-loop'] = esc_attr($loop);
        $options['data-speed'] = esc_attr($speed);
        $options['data-navigation'] = esc_attr('false');
        $options['data-pagination'] = esc_attr('false');
        $options['data-autoplay'] = esc_attr($autoplay);
        $options['data-autoplayspeed'] = esc_attr($autoplay_speed);
        $options['data-pauseonhover'] = esc_attr($pause_on_hover);
        $options['data-effect'] = esc_attr($effect);
        $options['data-rotate'] = esc_attr($rotate);
        $options['data-enableVerticalScroll'] = esc_attr($enable_vertical_scroll);

        $options = implode(
            " ",
            array_map(
                function ($k, $v) {
                    return "{$k}='{$v}'";
                },
                array_keys($options),
                $options
            )
        );

        $mockup_name = str_replace(' ', '-', strtolower($this->props['mockup']));        
        $mockup_url = $this->get_mockup_url( $mockup_name );
        $mockup_url_m = $this->get_mockup_url( $mockup_name, 'm' );
        $mockup_url_s = $this->get_mockup_url( $mockup_name, 's' );
        
        if($this->props['mockup_size'] === 'Small'){
            $mockup_url = $mockup_url_m = $mockup_url_s;
        }
        if($this->props['mockup_size'] === 'Medium'){
            $mockup_url = $mockup_url_m;
        }
        
        $mockup_img = sprintf('<picture>
                        <source media="(max-width: 768px)" srcset="%4$s">
                        <source media="(max-width: 980px)" srcset="%3$s">
                        <img class="dipi-mockup" src="%1$s" alt="%2$s">
                    </picture>',
                    $mockup_url,
                    $mockup_name,
                    $mockup_url_m,
                    $mockup_url_s
                );
                          
                
       
        

        $extra_class = '';
        if($enable_vertical_scroll === 'on'){
            $this->vertical_scroll_style($render_slug);
            $extra_class = 'divi-pixel-mockup-vs';
        }

        $output = sprintf(
            '<div class="divi-pixel-mockup %5$s" data-mockup="%4$s">
                <div class="div-pixel-mockup-screen %4$s" %2$s>
                    <div class="dipi-image-showcase-wrapper swiper-wrapper">
                        %1$s
                    </div>
                </div>
                %3$s
            </div>',
            $get_carousel_content,
            $options, 
            $mockup_img,
            $mockup_name,
            $extra_class
        );

        return $output;
    }
}
new DIPI_ImageShowcase;
