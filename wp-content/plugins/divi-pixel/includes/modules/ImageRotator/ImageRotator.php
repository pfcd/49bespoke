<?php
class DIPI_ImageRotator extends DIPI_Builder_Module {

   protected $module_credits = array(
		'module_uri' => 'https://divi-pixel.com/modules/image-rotator',
		'author' => 'Divi Pixel',
		'author_uri' => 'https://divi-pixel.com',
	);

	public function init() {

		$this->slug = 'dipi_image_rotator';
		$this->vb_support = 'on';
		$this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
		$this->name = esc_html__('Pixel Image Rotator', 'dipi-divi-pixel');
		$this->main_css_element = '%%order_class%%.dipi_image_rotator';
	}
    public function dipi_get_image_sizes()
    {
        global $_wp_additional_image_sizes;
        $sizes = array();
        $get_intermediate_image_sizes = get_intermediate_image_sizes();
        foreach ($get_intermediate_image_sizes as $_size) {
            if (in_array($_size, array('thumbnail', 'medium', 'large'))) {
                $sizes[$_size]['width'] = get_option($_size . '_size_w');
                $sizes[$_size]['height'] = get_option($_size . '_size_h');
                $sizes[$_size]['crop'] = (bool) get_option($_size . '_crop');
            } elseif (isset($_wp_additional_image_sizes[$_size])) {
                $sizes[$_size] = array(
                    'width' => $_wp_additional_image_sizes[$_size]['width'],
                    'height' => $_wp_additional_image_sizes[$_size]['height'],
                    'crop' => $_wp_additional_image_sizes[$_size]['crop'],
                );
            }
        }

        $image_sizes = array(
            'full' => esc_html__('Full Size', 'dipi-divi-pixel'),
        );
        foreach ($sizes as $sizeKey => $sizeValue) {
            $image_sizes[$sizeKey] = sprintf(
                '%1$s (%2$s x %3$s,%4$s cropped)',
                $sizeKey,
                $sizeValue["width"],
                $sizeValue["height"],
                ($sizeValue["crop"] == false ? ' not' : '')

            );
        }

        return $image_sizes;
    }
	public function get_settings_modal_toggles() 
	{
		return [
			'general' => [
				'toggles' => [
                    'images' => esc_html__('Images', 'dipi-divi-pixel'),
					'settings' => esc_html__('Settings', 'dipi-divi-pixel'),
                    'control_buttons' => esc_html__('Play/Pause Buttons', 'dipi-divi-pixel'),
				],
			],
			'advanced' => [
				'toggles' => [
                    'play_pause_btn' => esc_html__('Play Pause Buttons', 'dipi-divi-pixel'),
                    'preload' => esc_html__('Preloader', 'dipi-divi-pixel')
                ],
			],
		];
	}

	public function get_custom_css_fields_config() {

        $fields = [];


        return $fields;
    }
    private function get_indicator_icon_url(){
        $mockups_path = __DIR__ . '/360-icon.png';
        if(file_exists($mockups_path)) { // return whatever requested size if exists.
            return plugins_url('/360-icon.png', __FILE__);
        }
        
        return false;
    }
	public function get_fields() 
	{
		$fields = [];
        $fields['module_base_url'] = [
            'type' => 'hidden',
            'option_category' => 'basic_option',
            'toggle_slug' => 'images',
            'tab_slug' => 'general',
            'default' => plugins_url('/', __FILE__),
            'default_on_front' => plugins_url('/', __FILE__),
        ];
        $fields["images"] = [
            'label' => esc_html__('Images', 'dipi-divi-pixel'),
            'type' => 'hidden',
            'option_category' => 'basic_option',
            'toggle_slug' => 'images',
            'computed_affects' => array(
                '__ir__gallery',
            ),
        ];
        $fields["gallery_ids"] = [
            'label' => esc_html__('Gallery Images', 'dipi-divi-pixel'),
            'type' => 'upload-gallery',
            'option_category' => 'basic_option',
            'toggle_slug' => 'images',
            'computed_affects' => array(
                '__ir__gallery',
            ),
        ];
        
        $fields['gallery_orderby'] = array(
            'label' => esc_html__('Order By', 'dipi-divi-pixel'),
            'type' => $this->is_loading_bb_data() ? 'hidden' : 'select',
            'default' => 'none',
            'options' => array(
                'none' => esc_html__('None', 'dipi-divi-pixel'),
                'date_asc' => esc_html__('Date ASC', 'dipi-divi-pixel'),
                'date_desc' => esc_html__('Date DESC', 'dipi-divi-pixel'),
                'title_asc' => esc_html__('Title ASC', 'dipi-divi-pixel'),
                'title_desc' => esc_html__('Title DESC', 'dipi-divi-pixel'),
            ),
            'class' => array('et-pb-gallery-ids-field'),
            'computed_affects' => array(
                '__ir__gallery',
            ),
            'toggle_slug' => 'images',
        );
        $fields["__ir__gallery"] = [
            'type' => 'computed',
            'computed_callback' => array('DIPI_ImageRotator', 'render_images'),
            'computed_depends_on' => array(
                'images',
                'gallery_orderby',
                'autoplay',
                'gallery_ids',
                'play_speed',
                'invert_play',
                'rotate_on_wheel',
                'show_playpause_buttons'
            ),
            'computed_minimum' => array(
                'gallery_ids',
            ),
        ];
        $fields['use_thumbnails'] = [
            'label' => esc_html__('Use Responsive Thumbnails', 'dipi-divi-pixel'),
            'description' => esc_html__('Whether or not to use custom sized thumbnails on different devices. If this option is disabled, the full size image will be used as thumbnail.', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'toggle_slug' => 'images',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
        ];
        $fields['image_size_desktop'] = [
            'label' => esc_html__('Image Size (Desktop)', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'full',
            'options' => $this->dipi_get_image_sizes(),
            'toggle_slug' => 'images',
            'description' => 'Here you can choose the image size to use. If you are using very large images, consider using a thumbnail size to speed up page loading time.',
            'show_if' => [
                'use_thumbnails' => 'on',
            ],
        ];

        $fields['image_size_tablet'] = [
            'label' => esc_html__('Image Size (Tablet)', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'full',
            'options' => $this->dipi_get_image_sizes(),
            'toggle_slug' => 'images',
            'description' => 'Here you can choose the image size to use. If you are using very large images, consider using a thumbnail size to speed up page loading time.',
            'show_if' => [
                'use_thumbnails' => 'on',
            ],
        ];

        $fields['image_size_phone'] = [
            'label' => esc_html__('Image Size (Phone)', 'dipi-divi-pixel'),
            'type' => 'select',
            'option_category' => 'basic_option',
            'default' => 'full',
            'options' => $this->dipi_get_image_sizes(),
            'toggle_slug' => 'images',
            'description' => 'Here you can choose the image size to use. If you are using very large images, consider using a thumbnail size to speed up page loading time.',
            'show_if' => [
                'use_thumbnails' => 'on',
            ],
        ];
        
        $fields['autoplay'] = [
            'label' => esc_html__('Autoplay', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'configuration',
            'options' => [
                'off' => esc_html__('No', 'dipi-divi-pixel'),
                'on' => esc_html__('Yes', 'dipi-divi-pixel'),
            ],
            'default' => 'off',
            'toggle_slug' => 'settings',
            'computed_affects' => array(
                '__ir__gallery',
            ),
        ];
        $fields['play_speed'] = [
            'label' => esc_html__('Autoplay Speed (ms)', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'configuration',
            'range_settings' => array(
                'min' => '10',
                'max' => '1000',
                'step' => '10',
            ),
            'default' => '120',
            'unitless' => true,
            'toggle_slug' => 'settings',
            'computed_affects' => array(
                '__ir__gallery',
            ),
        ];
        $fields['invert_play'] = [
            'label' => esc_html__('Invert Play', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'toggle_slug' => 'settings',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'computed_affects' => array(
                '__ir__gallery',
            ),
        ];        
        $fields['rotate_on_drag'] = [
            'label' => esc_html__('Rotate On Drag', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'toggle_slug' => 'settings',
            'default' => 'on',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
        ];
        $fields['drag_direction'] = [
            'label' => esc_html__('Drag Direction', 'dipi-divi-pixel'),
            'type' => 'select',
            'options' => array(
                esc_html__('Horizontal', 'dipi-divi-pixel'),
                esc_html__('Vertical', 'dipi-divi-pixel'),
            ),
            'default' => 'Horizontal',
            'option_category' => 'basic_option',
            'toggle_slug' => 'settings',
            'show_if' => [
                'rotate_on_drag' => 'on'
            ]
        ];
        $fields['rotate_on_wheel'] = [
            'label' => esc_html__('Rotate On Scroll', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'toggle_slug' => 'settings',
            'default' => 'on',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'computed_affects' => array(
                '__ir__gallery',
            ),
        ];
        $fields['show_playpause_buttons'] = [
            'label' => esc_html__('Show Play/Pause Buttons', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'toggle_slug' => 'control_buttons',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'computed_affects' => array(
                '__ir__gallery',
            ),
        ];

        $fields["play_button_text"] = [
            'label' => esc_html__('Play Button Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => esc_html__('Play', 'dipi-divi-pixel'),
            'option_category' => 'basic_option',
            'toggle_slug' => 'control_buttons',
            'dynamic_content' => 'text',
            'show_if' => [
                'show_playpause_buttons' => 'on'
            ]
        ];
        $fields["pause_button_text"] = [
            'label' => esc_html__('Pause Button Text', 'dipi-divi-pixel'),
            'type' => 'text',
            'default' => esc_html__('Pause', 'dipi-divi-pixel'),
            'option_category' => 'basic_option',
            'toggle_slug' => 'control_buttons',
            'dynamic_content' => 'text',
            'show_if' => [
                'show_playpause_buttons' => 'on'
            ]
        ];
        $fields["button_h_alignment"] = [
            'label' => esc_html__('Button Horizontal Alignment', 'dipi-divi-pixel'),
            'type' => 'text_align',
            'option_category'  => 'configuration',
            'options' => et_builder_get_text_orientation_options(['justified']),
            'options_icon' => 'module_align',
            'toggle_slug' => 'control_buttons',
            'sticky' => true,
            'show_if' => [
                'show_playpause_buttons' => 'on'
            ]
        ];
        $fields['button_v_alignment'] =  [
            'label'       => esc_html__('Button Vertical Position', 'dipi-divi-pixel'),
            'type'        => 'select',
            'options'     => [
                'top' => esc_html__('Top', 'dipi-divi-pixel'),
                'bottom' => esc_html__('Bottom', 'dipi-divi-pixel'),
            ],
            'default'     => 'top',
            'toggle_slug'     => 'control_buttons',
			'show_if' => [
                'show_playpause_buttons' => 'on'
            ]
        ];
        // yes_no field for use preload
        $fields['use_preload'] = [
            'label' => esc_html__('Use Preload', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'toggle_slug' => 'preload',
            'tab_slug' => 'advanced',
            'default' => 'on',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            )
        ];
       
        $fields['use_custom_preload_image'] = [
            'label' => esc_html__('Use Custom Preloader Image', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'toggle_slug' => 'preload',
            'tab_slug' => 'advanced',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'show_if' => [
                'use_preload' => 'on'
            ]
        ];

        $fields['preload_svg_color'] = [
            'label' => esc_html__('Preloader Icon Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'option_category' => 'basic_option',
            'toggle_slug' => 'preload',
            'tab_slug' => 'advanced',
            'mobile_options'    => true,
            'default' => '#202020',
            'show_if' => [
                'use_preload' => 'on',
                'use_custom_preload_image' => 'off'
            ]
        ];

        $fields['preview_loader'] = [
            'label' => esc_html__('Preview Preloader in Builder', 'dipi-divi-pixel'),
            'type' => 'yes_no_button',
            'option_category' => 'basic_option',
            'toggle_slug' => 'preload',
            'tab_slug' => 'advanced',
            'default' => 'off',
            'options' => array(
                'off' => esc_html__('Off', 'dipi-divi-pixel'),
                'on' => esc_html__('On', 'dipi-divi-pixel'),
            ),
            'show_if' => [
                'use_preload' => 'on'
            ]
        ];
        // image field for custom preload image
        $fields['custom_preload_image'] = [
            'label' => esc_html__('Custom Preloader Image', 'dipi-divi-pixel'),
            'type' => 'upload',
            'upload_button_text' => esc_attr__('Upload an image', 'dipi-divi-pixel'),
            'choose_text' => esc_attr__('Choose an Image', 'dipi-divi-pixel'),
            'update_text' => esc_attr__('Set As Image', 'dipi-divi-pixel'),
            'option_category' => 'basic_option',
            'toggle_slug' => 'preload',
            'tab_slug' => 'advanced',
            'show_if' => [
                'use_preload' => 'on',
                'use_custom_preload_image' => 'on'
            ]
        ];
        // range field for preload size
        $fields['preload_size'] = [
            'label' => esc_html__('Preloader Size', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'basic_option',
            'toggle_slug' => 'preload',
            'tab_slug' => 'advanced',
            'default' => '50',
            'mobile_options'    => true,
            'range_settings' => [
                'min' => '0',
                'max' => '100',
                'step' => '1',
            ],
            'show_if' => [
                'use_preload' => 'on'
            ]
        ];
        $fields['preload_height'] = [
            'label' => esc_html__('Preloader Min Height', 'dipi-divi-pixel'),
            'type' => 'range',
            'option_category' => 'basic_option',
            'toggle_slug' => 'preload',
            'tab_slug' => 'advanced',
            'default' => '200',
            'mobile_options'    => true,
            'range_settings' => [
                'min' => '0',
                'max' => '500',
                'step' => '1',
            ],
            'show_if' => [
                'use_preload' => 'on'
            ]
        ];
        $fields['preload_background_color'] = [
            'label' => esc_html__('Preloader Background Color', 'dipi-divi-pixel'),
            'type' => 'color-alpha',
            'custom_color' => true,
            'option_category' => 'basic_option',
            'toggle_slug' => 'preload',
            'tab_slug' => 'advanced',
            'mobile_options'    => true,
            'default' => 'rgba(255,255,255,0.8)',
            'show_if' => [
                'use_preload' => 'on'
            ]
        ];
		return $fields;
	}

	public function get_advanced_fields_config() 
	{

		$advanced_fields = [];
        $advanced_fields["text"] = false;
        $advanced_fields["module_text"] = false;
        $advanced_fields["fonts"] = false;
        $advanced_fields["text_shadow"] = false;
		$advanced_fields['button']["play_button"] = [
            'label' => esc_html__('Play Button', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-img-rotator-play",
                'important' => true,
            ],
            'use_alignment' => false,
            'box_shadow' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-img-rotator-play",
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-img-rotator-play",
                    'important' => 'all',
                ],
            ],
        ];

        $advanced_fields['button']["pause_button"] = [
            'label' => esc_html__('Pause Button', 'dipi-divi-pixel'),
            'css' => [
                'main' => "%%order_class%% .dipi-img-rotator-pause",
                'important' => 'all',
            ],
            'use_alignment' => false,
            'box_shadow' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-img-rotator-pause",
                    'important' => true,
                ],
            ],
            'borders' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-img-rotator-pause",
                    'important' => true,
                ],
            ],
            'margin_padding' => [
                'css' => [
                    'main' => "%%order_class%% .dipi-img-rotator-pause",
                    'important' => 'all',
                ],
            ],
        ];
		return $advanced_fields;
	}

    private static function get_attachment_image($attachment_id, $image_size, $fallback_url)
    {
        $attachment = wp_get_attachment_image_src($attachment_id, $image_size);
        if ($attachment) {
            return $attachment[0];
        } else {
            return $fallback_url;
        }
    }

    public static function render_images($args = array(), $conditional_tags = array(), $current_page = array())
    {
        $defaults = [
            'images' => '',
            'gallery_ids' => '',
            'autoplay' => false,
        ];

        $args = wp_parse_args($args, $defaults);
        
  

        $attachment_ids = explode(",", $args["gallery_ids"]);
        $items = [];
        $att_ids = [];
        $gallery_orderby = explode('_', $args['gallery_orderby']);
        if($gallery_orderby[0] === 'none') {
            $att_ids = $attachment_ids;
        }
        if($gallery_orderby[0] !== 'none') {
            $query_args = array( 
                'post_type'      => 'attachment',
                'post_mime_type' => 'image',
                'post__in' =>  $attachment_ids,
                'posts_per_page' => '-1'
            );
            
            $query_args['orderby'] = $gallery_orderby[0];
            
            if(count($gallery_orderby) > 1) {
                $query_args['order'] = strtoupper($gallery_orderby[1]);
            }  
            
            $attachments_posts = get_posts($query_args);
            if ($attachments_posts) {
                foreach ( $attachments_posts as $attachment ) { 
                    $att_ids[] =  $attachment->ID;
                }
            }  
        }

        foreach ($att_ids as $index=>$attachment_id) {
            $attachment = wp_get_attachment_image_src($attachment_id, "full");
            if (!$attachment) {
                continue;
            }

            $image = $attachment[0];

            $image_desktop_url = (isset($args['image_size_desktop']) && !empty($args['image_size_desktop']))? DIPI_ImageRotator::get_attachment_image($attachment_id, $args['image_size_desktop'], $image) : $image;
            $image_tablet_url = (isset($args['image_size_tablet']) && !empty($args['image_size_tablet']))? DIPI_ImageRotator::get_attachment_image($attachment_id, $args['image_size_tablet'], $image): $image_desktop_url;
            $image_phone_url = (isset($args['image_size_phone']) && !empty($args['image_size_phone']))?DIPI_ImageRotator::get_attachment_image($attachment_id, $args['image_size_phone'], $image): $image_tablet_url;

            $image_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
            $image_title = get_the_title($attachment_id);


            $item_class = '';
            if ($index > 0) {
                $item_class = 'hidden';
            }
 
            $items[] = sprintf('
                <img src="%1$s"
                    data-index="%6$s"
                    decoding="sync"
                    srcset="%2$s 768w, %3$s 980w, %4$s 1024w"
                    sizes="(max-width: 768px) 768px, (max-width: 980px) 980px, 1024px"
                    class="dipi-img-rotator-item dipi-img-rotator-item-%6$s %5$s"
                />',
                $image,
                $image_phone_url,
                $image_tablet_url,
                $image_desktop_url,
                $item_class, #5
                $index
            );
        }
        return implode("", $items);
    }
    
    public function render_preload($render_slug) {
        if($this->props['use_preload'] !== 'on') return '';
        $preload_svg_color = $this->props['preload_svg_color']? $this->props['preload_svg_color'] : '#202020';
        $preload_image = '<svg enable-background="new 0 0 0 0" version="1.1" viewBox="0 0 100 100" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="m73 50c0-12.7-10.3-23-23-23s-23 10.3-23 23m3.9 0c0-10.5 8.5-19.1 19.1-19.1s19.1 8.6 19.1 19.1" fill="'.$preload_svg_color.'"><animateTransform attributeName="transform" attributeType="XML" dur="1s" from="0 50 50" repeatCount="indefinite" to="360 50 50" type="rotate"/>  </path></svg>';
        if($this->props['use_custom_preload_image'] === 'on' && !empty($this->props['custom_preload_image'])){
            $preload_image = simplexml_load_file($this->props['custom_preload_image']);
            if($preload_image) {
                $preload_image = $preload_image->asXML();
            }else{
                $preload_image = '<img src="'.$this->props['custom_preload_image'].'" />';
            }
        }
        return sprintf('<div class="dipi-image-rotator-preload">
                            %1$s
                        </div>',
                        $preload_image
                    );
    }

	public function render($attrs, $content, $render_slug) {

        wp_enqueue_script('dipi_image_rotator_public');
        $items = DIPI_ImageRotator::render_images($this->props);
        $rotate_on_drag = $this->props['rotate_on_drag'];
        $rotate_on_wheel = $this->props['rotate_on_wheel'];
        $show_playpause_buttons = $this->props['show_playpause_buttons'];
        $button_v_alignment = $this->props['button_v_alignment'];
		$this->_apply_css($render_slug);
        $playpause_btn_html = "";
        if( $show_playpause_buttons === 'on') {
            $play_button_text = $this->props['play_button_text'];
            $play_button_icon = $this->props['play_button_icon'];
            $play_button_custom = $this->props['custom_play_button'];
            $play_button = $this->render_button([
                'button_classname' => ["dipi-img-rotator-play"],
                'button_text' => $play_button_text,
                'button_custom' => $play_button_custom,
                'button_url' => false,
                'custom_icon' => $play_button_icon,
                'has_wrapper' => false,
            ]);
            $pause_button_text = $this->props['pause_button_text'];
            $pause_button_icon = $this->props['pause_button_icon'];
            $pause_button_custom = $this->props['custom_pause_button'];
            $pause_button = $this->render_button([
                'button_classname' => ["dipi-img-rotator-pause"],
                'button_text' => $pause_button_text,
                'button_custom' => $pause_button_custom,
                'button_url' => false,
                'custom_icon' => $pause_button_icon,
                'has_wrapper' => false,
            ]);
            $playpause_btn_html = sprintf('
                <div class="dipi-image-rotator-playpause-buttons">
                    %1$s
                    %2$s
                </div>',
                $play_button,
                $pause_button
            );
        }
        $config = [
            "autoplay" => $this->props["autoplay"],
            "play_speed" => $this->props["play_speed"],
            "rotate_on_drag" => $rotate_on_drag,
            "drag_direction" => $this->props["drag_direction"],
            "rotate_on_wheel" => $this->props["rotate_on_wheel"],
            "invert_play" => $this->props["invert_play"],
        ];
        $module_classes = [];
        $module_classes[] = "button-pos-$button_v_alignment";
        if ($rotate_on_drag === "on") {
            $module_classes[] = "rotate_on_drag";
        }
        if ($rotate_on_wheel === "on") {
            $module_classes[] ="rotate_on_wheel";
        }
        
        $preload = $this->render_preload($render_slug);
        
        return sprintf(
            '<div class="dipi-image-rotator %5$s" data-config="%3$s">
                <img class="indicator-icon" src="%4$s" />    
                <div class="dipi-image-rotator-inner">
                    %2$s
                    %6$s    
                    <div class="dipi-image-rotator-images" draggable="true" data-active-id="0">
                        %1$s
                    </div>
                </div>
            </div>',
            $items,
            $playpause_btn_html,
            esc_attr(htmlspecialchars(json_encode($config), ENT_QUOTES, 'UTF-8')), #5
            $this->get_indicator_icon_url(),
            implode(" ", $module_classes),
            $preload
        );
    }
    
     
	private function _apply_css($render_slug)
    {
        $buttons_container_selector = "%%order_class%% .dipi-image-rotator-playpause-buttons";
        $this->generate_styles(
            array(
                'base_attr_name' => 'button_h_alignment',
                'selector' => $buttons_container_selector,
                'css_property' => 'text-align',
                'render_slug' => $render_slug,
                'type' => 'align',
            )
        );

        if($this->props['use_preload'] === 'on') {
            $this->process_color_field_css(array(
                'render_slug'       => $render_slug,
                'slug'              => 'preload_background_color',
                'type'              => 'background-color',
                'selector'          => '%%order_class%% .dipi-image-rotator-preload',
                'hover'             => '%%order_class%% .dipi-image-rotator-preload:hover'
            ));
            $this->process_range_field_css( array(
                'render_slug' => $render_slug,
                'slug'        => 'preload_height',
                'type'        => 'min-height',
                'fixed_unit'  => 'px',
                'selector'    => '%%order_class%% .dipi-image-rotator-preload'
            ) );
            $this->process_range_field_css( array(
                'render_slug' => $render_slug,
                'slug'        => 'preload_size',
                'type'        => 'width',
                'fixed_unit'  => 'px',
                'selector'    => '%%order_class%% .dipi-image-rotator-preload img,%%order_class%% .dipi-image-rotator-preload svg',
                'hover'       => '%%order_class%% .dipi-image-rotator-preload:hover img,%%order_class%% .dipi-image-rotator-preload:hover svg'
            ) );
        }
    }
}

new DIPI_ImageRotator;

