<?php
 

class DIPI_CarouselChild extends DIPI_Builder_Module
{

    public function init()
    {
        $this->name = esc_html__('Carousel Slide', 'dipi-divi-pixel');
        $this->plural = esc_html__('Carousel Slides', 'dipi-divi-pixel');
        $this->slug = 'dipi_carousel_child';
        $this->vb_support = 'on';
        $this->type = 'child';
        $this->child_title_var = 'label';
        $this->advanced_setting_title_text = esc_html__('New Slide', 'dipi-divi-pixel');
        $this->settings_text = esc_html__('Slide Settings', 'dipi-divi-pixel');
        $this->main_css_element = '%%order_class%%';

    }

    public function get_settings_modal_toggles()
    {
        return [
            'general' => [
                'toggles' => [
                    'main_content' => esc_html__('Content', 'dipi-divi-pixel'),
                ],
            ],
            'advanced' => [
                'toggles' => [
                    'icon_settings' => esc_html__('Icon', 'dipi-divi-pixel'),
                    'img_settings' => esc_html__('Image', 'dipi-divi-pixel'),
                    'carousel_text' => [
                        'sub_toggles' => [
                            'title' => ['name' => 'Title'],
                            'desc' => ['name' => 'Desc'],
                        ],
                        'tabbed_subtoggles' => true,
                        'title' => esc_html__('Carousel Text', 'dipi-divi-pixel'),
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

    public function get_fields()
    {

        $fields = [];

        $fields["label"] = [
            'label' => esc_html__('Admin Label', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'main_content',
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

        $fields["type"] = [
            'label' => esc_html__('Content Type', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'default',
            'options' => [
                'default' => esc_html__('Default', 'dipi-divi-pixel'),
                'divi_library' => esc_html__('Divi Library', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'main_content',
            'affects' => [
                'use_icon',
                'img_src',
                'img_alt',
                'title_text',
                'desc_text',
                'show_button',
                'divi_library_id',
            ],
        ];

        $fields["divi_library_id"] = [
            'label' => esc_html__('Divi Library', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'options' => $this->get_divi_layouts(),
            'depends_show_if' => 'divi_library',
            'computed_affects' => [
                '__divilibrary',
            ],
            'toggle_slug' => 'main_content',
        ];

        $fields["use_icon"] = [
            'label' => esc_html__('Use Carousel Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'default_on_front' => 'off',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'toggle_slug' => 'main_content',
            'depends_show_if' => 'default',
            'affects' => array(
                'carousel_icon_align',
                'carousel_icon',
                'use_icon_font_size',
                'use_icon_circle',
                'icon_color',
                'img_src',
            ),
        ];

        $fields["carousel_icon"] = [
            'label' => esc_html__('Icon', 'dipi-divi-pixel'),
            'type' => 'select_icon',
            'toggle_slug' => 'main_content',
            'class' => array('et-pb-font-icon'),
            'default' => '1',
            'depends_show_if' => 'on',
            'hover' => 'tabs',
        ];

        $fields["carousel_icon_align"] = [
            'label' => esc_html__('Carousel Icon Alignment', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'center',
            'options' => [
                'left' => esc_html__('Left', 'dipi-divi-pixel'),
                'center' => esc_html__('Center', 'dipi-divi-pixel'),
                'right' => esc_html__('Right', 'dipi-divi-pixel'),
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'icon_settings',
        ];

        $fields["icon_color"] = [
            'label' => esc_html__('Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'icon_settings',
            'hover' => 'tabs',
        ];

        $fields["use_icon_circle"] = [
            'label' => esc_html__('Show as Circle Icon', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => array(
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ),
            'affects' => [
                'use_icon_circle_border',
                'icon_circle_color',
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'icon_settings',
            'depends_show_if' => 'on',
            'default_on_front' => 'off',
        ];

        $fields["icon_circle_color"] = [
            'label' => esc_html__('Circle Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'icon_settings',
            'hover' => 'tabs',
        ];

        $fields["use_icon_circle_border"] = [
            'label' => esc_html__('Show Circle Border', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'affects' => array(
                'icon_circle_border_color',
            ),
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'icon_settings',
            'default_on_front' => 'off',
        ];

        $fields["icon_circle_border_color"] = [
            'label' => esc_html__('Circle Border Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'icon_settings',
            'hover' => 'tabs',
        ];

        $fields["use_icon_font_size"] = [
            'label' => esc_html__('Use Icon Font Size', 'et_builder'),
            'type' => 'yes_no_button',
            'options' => array(
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ),
            'affects' => array(
                'icon_font_size',
            ),
            'depends_show_if' => 'on',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'icon_settings',
            'default_on_front' => 'off',
        ];

        $fields["icon_font_size"] = [
            'label' => esc_html__('Icon Font Size', 'et_builder'),
            'type' => 'range',
            'option_category' => 'font_option',
            'default' => '96px',
            'default_unit' => 'px',
            'default_on_front' => '',
            'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
            'range_settings' => array(
                'min' => '1',
                'max' => '120',
                'step' => '1',
            ),
            'hover' => 'tabs',
            'tab_slug' => 'advanced',
            'toggle_slug' => 'icon_settings',
            'depends_show_if' => 'on',
        ];

        $fields['img_src'] = [
            'type' => 'upload',
            'hide_metadata' => true,
            'label'          => esc_html__( 'Image',  'dipi-divi-pixel'),
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'description' => esc_html__('Upload an image to display in the module.', 'dipi-divi-pixel'),
            'depends_show_if' => 'off',
            'toggle_slug' => 'main_content',
            'dynamic_content' => 'image',
            'hover'          => 'tabs',
        ];

        $fields["img_alt"] = [
            'label' => esc_html__('Image Alt Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'description' => esc_html__('Define the HTML ALT text for your image here.', 'dipi-divi-pixel'),
            'show_if' => [
                'use_icon' => 'off',
                'type' => 'default',
            ],
            'toggle_slug' => 'main_content',
            'dynamic_content' => 'text'
        ];

        $fields["title_text"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'type' => 'text',
            'depends_show_if' => 'default',
            'toggle_slug' => 'main_content',
            'dynamic_content' => 'text'
        ];

        $fields["desc_text"] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'type' => 'tiny_mce',
            'option_category' => 'basic_option',
            'depends_show_if' => 'on',
            'dynamic_content' => 'text',
            'mobile_options' => true,
            'depends_show_if' => 'default',
            'toggle_slug' => 'main_content',
        ];

        $fields["show_button"] = [
            'default' => 'off',
            'label' => esc_html__('Show Button', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => [
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
                'off' => esc_html__('No', 'dipi-divi-pixel'),
            ],
            'depends_show_if' => 'default',
            'toggle_slug' => 'main_content',
        ];

        $fields["carousel_button_text"] = [
            'label' => esc_html__('Button Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'main_content',
            'default' => esc_html__('Click Here', 'dipi-divi-pixel'),
            'show_if' => [
                'show_button' => 'on',
                'type' => 'default',
            ],
            'dynamic_content' => 'text'
        ];

        $fields["button_link"] = [
            'label' => esc_html__('Button Link', 'dipi-divi-pixel'),
            'type' => 'text',
            'toggle_slug' => 'main_content',
            'show_if' => [
                'show_button' => 'on',
                'type' => 'default',
            ],
            'dynamic_content' => 'url'
        ];

        $fields["button_link_target"] = [
            'label' => esc_html__('Button Link Target', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'same_window',
            'options' => array(
                'off' => esc_html__('Same Window', 'dipi-divi-pixel'),
                'on' => esc_html__('New Window', 'dipi-divi-pixel'),
            ),
            'show_if' => [
                'show_button' => 'on',
                'type' => 'default',
            ],
            'toggle_slug' => 'main_content',
        ];

        $fields['image_animation'] = [
            'label' => esc_html__('Image Animation', 'dipi-divi-pixel'),
            'type' => 'select',
            'default' => 'none',
            'options' => [
                'none' => esc_html__('None', 'dipi-divi-pixel'),
                'zoomin' => esc_html__('Zoom In', 'dipi-divi-pixel'),
                'zoomout' => esc_html__('Zoom Out', 'dipi-divi-pixel'),
                'rotate' => esc_html__('Rotate', 'dipi-divi-pixel'),
                'move-up' => esc_html('Move Up', 'dipi-divi-pixel'),
                'move-down' => esc_html('Move Down', 'dipi-divi-pixel'),
                'move-left' => esc_html('Move Left', 'dipi-divi-pixel'),
                'move-right' => esc_html('Move Right', 'dipi-divi-pixel'),
            ],
            'tab_slug' => 'advanced',
            'toggle_slug' => 'img_settings',
            'computed_affects' => ['__blogposts']
        ];

        $fields['img_width'] = [
            'label' => esc_html('Image Width', 'dipi-divi-pixel'),
            'type' => 'range',
            'default' => '100',
            'default_unit' => '%',
            'default_on_front' => '',
            'allowed_units' => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
            'range_settings' => [
                'min' => '1',
                'max' => '100',
                'step' => '1',
            ],
            'mobile_options' => true,
            'responsive' => true,
            'validate_unit' => true,
            'tab_slug' => 'advanced',
            'toggle_slug' => 'img_settings'
        ];



        $fields["__divilibrary"] = [
            'type' => 'computed',
            'computed_callback' => ['DIPI_CarouselChild', 'get_divi_library'],
            'computed_depends_on' => [
                'divi_library_id',
                'dipi_uuid',
            ],
        ];
        
        return $fields;
    }

    public function get_advanced_fields_config()
    {

        $advanced_fields = [];

        $advanced_fields['fonts'] = [];
        $advanced_fields['text'] = false;
        $advanced_fields['text_shadow'] = false;

        $advanced_fields['margin_padding'] = [
            'css' => [
                'margin' => '%%order_class%%:not(.ui-sortable)',
                'padding' => '%%order_class%%:not(.ui-sortable)',
                'important' => 'all',
            ],
        ];

        $advanced_fields["fonts"]["title"] = [
            'label' => esc_html__('Title', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-carousel-item-title",
            ],
            'font_size' => [
                'default' => '18px',
            ],
            'line_height' => [
                'range_settings' => [
                    'default' => '1em',
                    'min' => '1',
                    'max' => '3',
                    'step' => '.1',
                ],
            ],
            'header_level' => [
                'default' => 'h2',
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'carousel_text',
            'sub_toggle' => 'title',
        ];

        $advanced_fields["fonts"]["desc"] = [
            'label' => esc_html__('Description', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-carousel-item-desc, %%order_class%% .dipi-carousel-item-desc p",
                'color' => "%%order_class%% .dipi-carousel-item-desc, %%order_class%% .dipi-carousel-item-desc *",
                'line_height' => "%%order_class%% .dipi-carousel-item-desc p",
            ],
            'font_size' => [
                'default' => '15px',
            ],
            'line_height' => [
                'range_settings' => [
                    'default' => '1em',
                    'min' => '1',
                    'max' => '3',
                    'step' => '.1',
                ],
            ],
            'important' => 'all',
            'hide_text_align' => true,
            'toggle_slug' => 'carousel_text',
            'sub_toggle' => 'desc',
        ];

        $advanced_fields['button']["carousel_button"] = [
            'label' => esc_html__('Button', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-carousel-button",
                'alignment' => "%%order_class%% .dipi-carousel-button-wrapper",
            ],
            'use_alignment' => false,
            'box_shadow' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-carousel-button",
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-carousel-button",
                ],
            ],
        ];

        $advanced_fields["borders"]["default"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%%:not(.ui-sortable)",
                    'border_styles' => "%%order_class%%:not(.ui-sortable)",
                ],
            ],
        ];

        $advanced_fields["borders"]["img"] = [
            'css' => [
                'main' => [
                    'border_radii' => "%%order_class%% .dipi-carousel-image",
                    'border_styles' => "%%order_class%% .dipi-carousel-image",
                ],
            ],
            'toggle_slug' => 'img_settings',
        ];

        $advanced_fields["box_shadow"]["default"] = [
            'css' => [
                'main' => ".dipi_carousel %%order_class%%.dipi_carousel_child:not(.ui-sortable)",
                'hover' => ".dipi_carousel %%order_class%%.dipi_carousel_child:hover:not(.ui-sortable)",
            ],
        ];

        $advanced_fields["box_shadow"]["img"] = [
            'css' => [
                'main' => "%%order_class%% .dipi-carousel-image ",
                'hover' => "%%order_class%% .dipi-carousel-image:hover",
            ],
            'toggle_slug' => 'img_settings',
        ];

        return $advanced_fields;
    }

    public static function get_divi_library($args = array())
    {
        $id = isset($args['divi_library_id']) ? $args['divi_library_id'] : '';
        return DIPI_Builder_Module::render_library_layout($id);
    }

    public function render($attrs, $content, $render_slug)
    {
        $multi_view                    = et_pb_multi_view_options( $this );
        $img_src = $this->props['img_src'];
        $img_alt = $this->props['img_alt'];
        $carousel_icon = $this->props['carousel_icon'];
        $use_icon = $this->props['use_icon'];
        $carousel_icon_align = $this->props['carousel_icon_align'];
        $use_icon_circle = $this->props['use_icon_circle'];
        $use_icon_circle_border = $this->props['use_icon_circle_border'];
        $use_icon_font_size = $this->props['use_icon_font_size'];
        $icon_font_size = $this->props['icon_font_size'];
        $icon_font_size_hover = $this->get_hover_value('icon_font_size');
        $icon_color = $this->props['icon_color'];
        $icon_circle_color = $this->props['icon_circle_color'];
        $icon_circle_border_color = $this->props['icon_circle_border_color'];
        $icon_color_hover = $this->get_hover_value('icon_color');
        $icon_circle_color_hover = $this->get_hover_value('icon_circle_color');
        $icon_circle_border_color_hover = $this->get_hover_value('icon_circle_border_color');
        $title_text = $this->props['title_text'];
        $desc_text = $this->props['desc_text'];
        $show_button = $this->props['show_button'];

        $carousel_button_text = $this->props['carousel_button_text'];
        $button_link = $this->props['button_link'];
        $button_rel = $this->props['carousel_button_rel'];
        $button_icon = $this->props['carousel_button_icon'];
        $button_custom = $this->props['custom_carousel_button'];
        $button_link_target = $this->props['button_link_target'];

        $image_class = "%%order_class%% .dipi-carousel-image";
        $img_width = $this->props['img_width'];
        $img_width_tablet = ($this->props['img_width_tablet']) ? $this->props['img_width_tablet'] : $img_width;
        $img_width_phone = ($this->props['img_width_phone']) ? $this->props['img_width_phone'] : $img_width_tablet;
        $img_width_last_edited = $this->props['img_width_last_edited'];
        $img_width_responsive_status = et_pb_get_responsive_status($img_width_last_edited);

        $img_animation = $this->props['image_animation'];
        $parent_module = self::get_parent_modules('page')['dipi_carousel'];
        $show_light_box = $parent_module->props['show_lightbox'];
        $title_in_lightbox = $parent_module->props['title_in_lightbox'];
        $desc_in_lightbox = $parent_module->props['desc_in_lightbox'];
        if ('' !== $img_width) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $image_class,
                'declaration' => sprintf('max-width: %1$s !important;', $img_width),
            ));
        }

        if ('' !== $img_width_tablet && $img_width_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $image_class,
                'declaration' => sprintf('max-width: %1$s !important;', $img_width_tablet),
                'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
            ));
        }

        if ('' !== $img_width_phone && $img_width_responsive_status) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => $image_class,
                'declaration' => sprintf('max-width: %1$s !important;', $img_width_phone),
                'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
            ));
        }

        $button_render = '';

        if ('on' === $show_button) {

            $button_render = $this->render_button([
                'button_classname' => ["dipi-carousel-button"],
                'button_rel' => $button_rel,
                'button_text' => $carousel_button_text,
                'button_url' => $button_link,
                'custom_icon' => $button_icon,
                'has_wrapper' => false,
                'url_new_window' => $button_link_target,
                'button_custom' => $button_custom,
            ]);

            $button_render = sprintf('<div class="dipi-carousel-button-wrapper">%1$s</div>', $button_render);
        }

        $carousel_icon_style_hover = '';
        if ('off' === $use_icon) {

            $image_animation = (!empty($img_animation) && $img_animation !== 'none' ) ? 'dipi-' . $img_animation : '';
            $image_attachment_class = et_pb_media_options()->get_image_attachment_class( $this->props, 'img_src' );
            $image_classes = [];
            if ( ! empty( $image_attachment_class ) ) {
                $image_classes[] = esc_attr( $image_attachment_class );
            }
            // $image = $multi_view->render_element(
			// 	array(
			// 		'tag'      => 'img',
			// 		'attrs'    => array(
			// 			'src'   => '{{img_src}}',
			// 			'class' => $image_classes ? implode( ' ', $image_classes ) : '',
			// 			'alt'   => $img_alt,
			// 		),
			// 		'required' => 'img_src',
            //         'hover_selector' => '%%order_class%% .dipi-image-wrap img:hover',
			// 	)
			// );
            if(!empty($this->props['img_src'])){
                $image = sprintf('<img src="%1$s" alt="%2$s" class="%3$s" />',
                    $this->props['img_src'],
                    $img_alt,
                    ($image_classes ? implode( ' ', $image_classes ) : '') . ' dipi-c-img'
                );
                $image_hover = (isset($this->props['img_src__hover_enabled']) && $this->props['img_src__hover_enabled'] === 'on|hover')? sprintf('<img src="%1$s" alt="%2$s" class="%3$s" />',
                    $this->props['img_src__hover'],
                    $img_alt,
                    ($image_classes ? implode( ' ', $image_classes ) : '') . ' dipi-c-hover-img'
                ) : '';
                $image_extra_classes = (isset($this->props['img_src__hover_enabled']) && $this->props['img_src__hover_enabled'] === 'on|hover')? ' dipi-c-has-hover': '';
                $img_href = "";
                if ($show_light_box != "off") {
                    $img_href = sprintf('href="%1$s"', 
                        esc_attr($img_src)
                );
                }
                $image_render = sprintf(
                    '<span class="dipi-carousel-image %3$s %5$s" %1$s %6$s %7$s>
                        %2$s
                        %4$s
                    </span>',
                    $img_href,
                    $image,
                    $image_animation,
                    $image_hover,
                    $image_extra_classes, #5
                    'on' === $title_in_lightbox ? " data-title='$title_text'" : '',
                    'on' === $desc_in_lightbox ? " data-caption='" . $desc_text . "'" : ''
                    
                );
            } else {
                $image_render = '';
            }
            

        } else {
            $carousel_icon_style = sprintf('color: %1$s;', esc_attr($icon_color));

            if (et_builder_is_hover_enabled('icon_color', $this->props)) {
                $carousel_icon_style_hover = sprintf('color: %1$s;', esc_attr($icon_color_hover));
            }

            // Use cirlce
            if ('on' === $use_icon_circle) {
                $carousel_icon_style .= sprintf(' background-color: %1$s;', esc_attr($icon_circle_color));
                if (et_builder_is_hover_enabled('icon_circle_color', $this->props)) {
                    $carousel_icon_style_hover .= sprintf(' background-color: %1$s;', esc_attr($icon_circle_color_hover));
                }

                if ('on' === $use_icon_circle_border) {
                    $carousel_icon_style .= sprintf(' border-color: %1$s;', esc_attr($icon_circle_border_color));
                    if (et_builder_is_hover_enabled('icon_circle_border_color', $this->props)) {
                        $carousel_icon_style_hover .= sprintf(' border-color: %1$s;', esc_attr($icon_circle_border_color_hover));
                    }
                }
            }

            $carousel_icon_classes[] = 'et-pb-icon dipi-carousel-icon';

            if ('on' === $use_icon_circle) {
                $carousel_icon_classes[] = 'dipi-carousel-icon-circle';
            }

            if ('on' === $use_icon_circle && 'on' === $use_icon_circle_border) {
                $carousel_icon_classes[] = 'dipi-carousel-icon-circle-border';
            }

            $this->remove_classname('et_pb_module');
            $this->generate_styles(
				array(
					'utility_arg'    => 'icon_font_family',
					'render_slug'    => $render_slug,
					'base_attr_name' => 'carousel_icon',
					'important'      => true,
					'selector'       => '%%order_class%% .dipi-carousel-icon',
					'processor'      => array(
						'ET_Builder_Module_Helper_Style_Processor',
						'process_extended_icon',
					),
				)
			);
            $image_render = $multi_view->render_element(
				array(
					'content' => '{{carousel_icon}}',
					'attrs'   => array(
						'class' => implode( ' ', $carousel_icon_classes ),
					),
                    'hover_selector' => '%%order_class%% .dipi-image-wrap .dipi-carousel-icon',
				)
			);

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dipi-carousel-icon",
                'declaration' => $carousel_icon_style,
            ));

            ET_Builder_Element::set_style($render_slug, array(
                'selector' => "%%order_class%% .dipi-image-wrap",
                'declaration' => sprintf('text-align: %1$s!important;', $carousel_icon_align),
            ));

            if ('' !== $carousel_icon_style_hover) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%%.dipi_carousel_child:hover .dipi-carousel-icon",
                    'declaration' => $carousel_icon_style_hover,
                ));
            }
            
            if ('off' !== $use_icon_font_size) {
                ET_Builder_Element::set_style($render_slug, array(
                    'selector' => "%%order_class%% .dipi-carousel-icon",
                    'declaration' => sprintf(
                        'font-size: %1$s;',
                        esc_html($icon_font_size)
                    ),
                ));

                if (et_builder_is_hover_enabled('icon_font_size', $this->props)) {
                    ET_Builder_Element::set_style($render_slug, array(
                        'selector' => "%%order_class%%.dipi_carousel_child:hover .dipi-carousel-icon",
                        'declaration' => sprintf(
                            'font-size: %1$s;',
                            esc_html($icon_font_size_hover)
                        ),
                    ));
                }
            }
        }

        $carousel_button_text_size = $this->props['carousel_button_text_size'];
        if (empty($carousel_button_text_size)) {
            ET_Builder_Element::set_style($render_slug, array(
                'selector' => '%%order_class%% .dipi-carousel-button',
                'declaration' => 'font-size: 20px;',
            ));
        }

        $title_level = $this->props['title_level'] ? $this->props['title_level'] : 'h2';
        $image_render = $image_render ? sprintf('<div class="dipi-image-wrap">%1$s</div>', $image_render) : '';
        $title_text = !empty($title_text) ? sprintf('<%2$s class="dipi-carousel-item-title">%1$s</%2$s>', $title_text, esc_attr($title_level)) : '';

        $desc_text = !empty($desc_text) ? sprintf(
            '<div class="dipi-carousel-item-desc">%1$s</div>',
            $this->process_content($desc_text)
        ) : '';

        $link_option_url = $this->props['link_option_url'];
        $link_option_url_new_window = $this->props['link_option_url_new_window'];
        $link_taget = ($link_option_url_new_window === 'on') ? 'target="blank"':'';
        $link_start = (!empty($link_option_url)) ? sprintf('<a href="%1$s" %2$s>', $link_option_url, $link_taget): '';
        $link_end = (!empty($link_option_url)) ? sprintf('</a>'):'';
        $content_start_wrapper = '';
        $content_end_wrapper = '';
        if (strlen(trim($title_text)) || strlen(trim($desc_text)) || strlen(trim($button_render))) {
            $content_start_wrapper = '<div class="dipi-carousel-item-content">';
            $content_end_wrapper = '</div>';
        }
        $default_output = sprintf('
            <div class="dipi-carousel-child-wrapper">
                %5$s
                %1$s
                %6$s
                %7$s
                    %5$s
                    %2$s
                    %3$s
                    %6$s
                    %4$s
                %8$s
            </div>',
            $image_render,
            $title_text,
            $desc_text,
            $button_render,
            $link_start, #5
            $link_end,
            $content_start_wrapper,
            $content_end_wrapper
        );

        $libraryId = $this->props['divi_library_id'];
        $shortcode = do_shortcode('[et_pb_section global_module="' . $libraryId . '"][/et_pb_section]');
        $this->add_classname('swiper-slide');
        $divi_library_output = sprintf('
            <div class="%2$s">
                %1$s
            </div>
            ',
            $shortcode,
            'dipi-carousel-child-wrapper'
        );

        return ($this->props['type'] == 'divi_library') ? $divi_library_output : $default_output;
    }
/**
	 * Filter multi view value.
	 *
	 * @since 3.27.1
	 *
	 * @see ET_Builder_Module_Helper_MultiViewOptions::filter_value
	 *
	 * @param mixed                                     $raw_value Props raw value.
	 * @param array                                     $args {
	 *                                         Context data.
	 *
	 *     @type string $context      Context param: content, attrs, visibility, classes.
	 *     @type string $name         Module options props name.
	 *     @type string $mode         Current data mode: desktop, hover, tablet, phone.
	 *     @type string $attr_key     Attribute key for attrs context data. Example: src, class, etc.
	 *     @type string $attr_sub_key Attribute sub key that availabe when passing attrs value as array such as styes. Example: padding-top, margin-botton, etc.
	 * }
	 * @param ET_Builder_Module_Helper_MultiViewOptions $multi_view Multiview object instance.
	 *
	 * @return mixed
	 */
	public function multi_view_filter_value( $raw_value, $args, $multi_view ) {
		$name = isset( $args['name'] ) ? $args['name'] : '';
		$mode = isset( $args['mode'] ) ? $args['mode'] : '';

		if ( $raw_value && 'carousel_icon' === $name ) {
			return et_pb_get_extended_font_icon_value( $raw_value, true );
		}

		$fields_need_escape = array(
			'button_text',
		);

		if ( $raw_value && in_array( $name, $fields_need_escape, true ) ) {
			return $this->_esc_attr( $multi_view->get_name_by_mode( $name, $mode ), 'none', $raw_value );
		}

		return $raw_value;
	}
}

new DIPI_CarouselChild;
