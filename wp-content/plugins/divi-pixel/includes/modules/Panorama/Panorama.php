<?php
class DIPI_Panorama extends DIPI_Builder_Module
{

    public $slug = 'dipi_panorama';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => 'https://divi-pixel.com/modules/masonry-gallery',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
    );

    public function init()
    {
        $this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
        $this->name = esc_html__('Pixel Panorama', 'dipi-divi-pixel');

        $this->settings_modal_toggles = [
            'general' => [
                'toggles' => [
                    'main_content' => esc_html__('Panorama Settings', 'dipi-divi-pixel'),
                    'background' => esc_html__('Overlay', 'dipi-divi-pixel'),
                ],
            ],
        ];
    }

    public function get_settings_modal_toggles()
    {
        $toggles = [
            'general' => [],
        ];
        $toggles['general']['toggles'] = [
            'main_content' => array(
                'title' => esc_html__('Panorama Settings', 'dipi-divi-pixel'),
            ),
            'background' => array(
                'title' => esc_html__('Overlay Background', 'dipi-divi-pixel'),
            ),
            'layer-one' => array(
                'title' => esc_html__('Layer 1', 'dipi-divi-pixel'),
            ),
        ];
        return $toggles;
    }
    public function get_fields()
    {
        return array(
            // 'content' => array(
            //     'label'           => esc_html__( 'Content', 'dipi-divi-pixel' ),
            //     'type'            => 'tiny_mce',
            //     'option_category' => 'basic_option',
            //     'description'     => esc_html__( 'Content entered here will appear inside the module.', 'dipi-divi-pixel' ),
            //     'toggle_slug'     => 'main_content',
            // ),
            'type' => array(
                'label' => esc_html__('Panorama Type', 'dipi-divi-pixel'),
                'type' => 'select',
                'options' => array(
                    esc_html__('2D Image', 'dipi-divi-pixel'),
                    esc_html__('Equirectangular', 'dipi-divi-pixel'),
                    esc_html__('Cube Map', 'dipi-divi-pixel'),
                    esc_html__('Video', 'dipi-divi-pixel'),
                    // esc_html__( 'Multires', 'dipi-divi-pixel' ),
                ),
                'default' => 'Equirectangular',
                'option_category' => 'basic_option',
                'toggle_slug' => 'main_content',
                'data_type' => '',
            ),
            'image2d' => array(
                'label' => esc_html__('Panorama Image', 'dipi-divi-pixel'),
                'type' => 'upload',
                'upload_button_text' => esc_attr__('Upload Panorama Image', 'dipi-divi-pixel'),
                'choose_text' => esc_attr__('Chose Panorama Image', 'dipi-divi-pixel'),
                'update_text' => esc_attr__('Update Panorama Image', 'dipi-divi-pixel'),
                'hide_metadata' => true,
                'option_category' => 'basic_option',
                'toggle_slug' => 'main_content',
                'dynamic_content' => 'image',
                'show_if' => array(
                    'type' => '2D Image',
                ),
            ),
            'direction' => array(
                'label' => esc_html__('Scroll Direction', 'dipi-divi-pixel'),
                'type' => 'select',
                'options' => array(
                    esc_html__('Horizontal', 'dipi-divi-pixel'),
                    esc_html__('Vertical', 'dipi-divi-pixel'),
                    esc_html__('Both', 'dipi-divi-pixel'),
                ),
                'default' => 'Both',
                'option_category' => 'basic_option',
                'toggle_slug' => 'main_content',
                'data_type' => '',
                'show_if' => array(
                    'type' => '2D Image',
                ),
            ),
            'repeat' => array(
                'label' => esc_html__('Repeat', 'dipi-divi-pixel'),
                'type' => 'select',
                'options' => array(
                    esc_html__('None', 'dipi-divi-pixel'),
                    esc_html__('Horizontal', 'dipi-divi-pixel'),
                    esc_html__('Vertical', 'dipi-divi-pixel'),
                    esc_html__('Both', 'dipi-divi-pixel'),
                ),
                'default' => 'None',
                'option_category' => 'basic_option',
                'toggle_slug' => 'main_content',
                'data_type' => '',
                'show_if' => array(
                    'type' => '2D Image',
                ),
            ),
            'image' => array(
                'label' => esc_html__('Panorama Image', 'dipi-divi-pixel'),
                'type' => 'upload',
                'upload_button_text' => esc_attr__('Upload Panorama Image', 'dipi-divi-pixel'),
                'choose_text' => esc_attr__('Chose Panorama Image', 'dipi-divi-pixel'),
                'update_text' => esc_attr__('Update Panorama Image', 'dipi-divi-pixel'),
                'hide_metadata' => true,
                'option_category' => 'basic_option',
                'toggle_slug' => 'main_content',
                'dynamic_content' => 'image',
                'show_if' => array(
                    'type' => 'Equirectangular',
                ),
            ),
            'is_autoload' => [
                'label' => esc_html__('Auto load', 'dipi-divi-pixel'),
                'type' => 'yes_no_button',
                'options' => [
                    'off' => esc_html__('No', 'et_builder'),
                    'on' => esc_html__('Yes', 'et_builder'),
                ],
                'option_category' => 'basic_option',
                'toggle_slug' => 'main_content',
                'show_if' => array(
                    'type' => ['Equirectangular', 'Cube Map'],
                ),
            ],
            'image0' => array(
                'label' => esc_html__('Cube Map Image 1', 'dipi-divi-pixel'),
                'type' => 'upload',
                'upload_button_text' => esc_attr__('Upload Cube Map Image', 'dipi-divi-pixel'),
                'choose_text' => esc_attr__('Chose Cube Map Image', 'dipi-divi-pixel'),
                'update_text' => esc_attr__('Update Cube Map Image', 'dipi-divi-pixel'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'main_content',
                'dynamic_content' => 'image',
                'hide_metadata' => true,
                'show_if' => array(
                    'type' => 'Cube Map',
                ),
            ),
            'image1' => array(
                'label' => esc_html__('Cube Map Image 2', 'dipi-divi-pixel'),
                'type' => 'upload',
                'upload_button_text' => esc_attr__('Upload Cube Map Image', 'dipi-divi-pixel'),
                'choose_text' => esc_attr__('Chose Cube Map Image', 'dipi-divi-pixel'),
                'update_text' => esc_attr__('Update Cube Map Image', 'dipi-divi-pixel'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'main_content',
                'dynamic_content' => 'image',
                'hide_metadata' => true,
                'show_if' => array(
                    'type' => 'Cube Map',
                ),
            ),
            'image2' => array(
                'label' => esc_html__('Cube Map Image 3', 'dipi-divi-pixel'),
                'type' => 'upload',
                'upload_button_text' => esc_attr__('Upload Cube Map Image', 'dipi-divi-pixel'),
                'choose_text' => esc_attr__('Chose Cube Map Image', 'dipi-divi-pixel'),
                'update_text' => esc_attr__('Update Cube Map Image', 'dipi-divi-pixel'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'main_content',
                'dynamic_content' => 'image',
                'hide_metadata' => true,
                'show_if' => array(
                    'type' => 'Cube Map',
                ),
            ),
            'image3' => array(
                'label' => esc_html__('Cube Map Image 4', 'dipi-divi-pixel'),
                'type' => 'upload',
                'upload_button_text' => esc_attr__('Upload Cube Map Image', 'dipi-divi-pixel'),
                'choose_text' => esc_attr__('Chose Cube Map Image', 'dipi-divi-pixel'),
                'update_text' => esc_attr__('Update Cube Map Image', 'dipi-divi-pixel'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'main_content',
                'dynamic_content' => 'image',
                'hide_metadata' => true,
                'show_if' => array(
                    'type' => 'Cube Map',
                ),
            ),
            'image4' => array(
                'label' => esc_html__('Cube Map Image 5', 'dipi-divi-pixel'),
                'type' => 'upload',
                'upload_button_text' => esc_attr__('Upload Cube Map Image', 'dipi-divi-pixel'),
                'choose_text' => esc_attr__('Chose Cube Map Image', 'dipi-divi-pixel'),
                'update_text' => esc_attr__('Update Cube Map Image', 'dipi-divi-pixel'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'main_content',
                'dynamic_content' => 'image',
                'hide_metadata' => true,
                'show_if' => array(
                    'type' => 'Cube Map',
                ),
            ),
            'image5' => array(
                'label' => esc_html__('Cube Map Image 6', 'dipi-divi-pixel'),
                'type' => 'upload',
                'upload_button_text' => esc_attr__('Upload Cube Map Image', 'dipi-divi-pixel'),
                'choose_text' => esc_attr__('Chose Cube Map Image', 'dipi-divi-pixel'),
                'update_text' => esc_attr__('Update Cube Map Image', 'dipi-divi-pixel'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'main_content',
                'dynamic_content' => 'image',
                'hide_metadata' => true,
                'show_if' => array(
                    'type' => 'Cube Map',
                ),
            ),
            'poster' => array(
                'label' => esc_html__('Panorama Video Poster', 'dipi-divi-pixel'),
                'type' => 'upload',
                'upload_button_text' => esc_attr__('Upload Panorama Poster', 'dipi-divi-pixel'),
                'choose_text' => esc_attr__('Chose Panorama Poster', 'dipi-divi-pixel'),
                'update_text' => esc_attr__('Update Panorama Poster', 'dipi-divi-pixel'),
                'option_category' => 'basic_option',
                'toggle_slug' => 'main_content',
                'dynamic_content' => 'image',
                'hide_metadata' => true,
                'show_if' => array(
                    'type' => 'Video',
                ),
            ),
            'videomp4' => array(
                'label' => esc_html__('Video MP4 File Or Youtube URL', 'et_builder'),
                'type' => 'upload',
                'option_category' => 'basic_option',
                'data_type' => 'video',
                'upload_button_text' => esc_attr__('Upload a video', 'et_builder'),
                'choose_text' => esc_attr__('Choose a Video MP4 File', 'et_builder'),
                'update_text' => esc_attr__('Set As Video', 'et_builder'),
                'description' => esc_html__('Upload your desired video in .MP4 format, or type in the URL to the video you would like to display', 'et_builder'),
                'toggle_slug' => 'main_content',
                'computed_affects' => array(
                    '__video',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => array(
                    'type' => 'Video',
                ),
            ),
            'videowebm' => array(
                'label' => esc_html__('Video WEBM File Or Youtube URL', 'et_builder'),
                'type' => 'upload',
                'option_category' => 'basic_option',
                'data_type' => 'video',
                'upload_button_text' => esc_attr__('Upload a video', 'et_builder'),
                'choose_text' => esc_attr__('Choose a Video WEBM File', 'et_builder'),
                'update_text' => esc_attr__('Set As Video', 'et_builder'),
                'description' => esc_html__('Upload your desired video in .WEBM format, or type in the URL to the video you would like to display', 'et_builder'),
                'toggle_slug' => 'main_content',
                'computed_affects' => array(
                    '__video',
                ),
                'mobile_options' => true,
                'hover' => 'tabs',
                'show_if' => array(
                    'type' => 'Video',
                ),
            ),
        );
    }

    public function get_advanced_fields_config()
    {
        $advanced_fields = [];

        $advanced_fields['borders'] = array(
            'default' => array(
                'css' => array(
                    'main' => array(
                        'border_radii' => "%%order_class%% .wrapper",
                        'border_styles' => "%%order_class%% .wrapper",
                    ),
                ),
            ),
        );

        $advanced_fields['box_shadow'] = array(
            'default' => array(
                'css' => array(
                    'main' => "%%order_class%% .wrapper",
                ),
            ),
        );

        $advanced_fields['margin_padding'] = array(
            'css' => array(
                'margin' => "%%order_class%% .dipi-panorma-wrapper",
                'padding' => "%%order_class%% .dipi-panorma-wrapper",
                'important' => 'all',
            ),
        );

        $advanced_fields['background'] = [
            'css' => [
                'main' => '%%order_class%% .dipi-panorama-overlay',
                'important' => true,
            ],
            'hover' => false,
            'hover_enabled' => 'off',
            'background__hover_enabled' => 'off',
            'use_background_video' => false,
        ];
        $advanced_fields['link_options'] = false;
        $advanced_fields['link_options'] = false;
        $advanced_fields['text'] = false;
        $advanced_fields['fonts'] = false;

        $advanced_fields['max_width'] = [
            'use_max_width' => false,
            'use_min_height' => false,
            'use_module_alignment' => true,
            'options' => [
                'module_alignment' => [
                    'default' => 'center',
                ],
            ],
        ];
        $advanced_fields['height'] = [
            'use_height' => true,
            'use_min_height' => false,
            'use_max_height' => false,
            'options' => [
                'height' => [
                    'default' => '500px',
                ],
            ],
        ];
        return $advanced_fields;
    }
    public function isYoutube($url)
    {
        if (strpos($url, 'youtube') > 0) {
            return true;
        }

        return false;
    }
    public function getYoutubeID($url)
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        return $match[1];
    }
    public function render_panorama_video($attrs, $content, $render_slug)
    {

        if ($this->isYoutube($this->props['videomp4'])) {
            return sprintf('
				<div class="dipi-panorma-wrapper wrapper" style="height:100%%">
					<div class="dipi-panorama-overlay">
						<div class="dipi-panorama-overlay-content">
							<div class="dipi-panorama-icon dipi-scroll-icon"></div><br />
							<div class="dipi-panorama-icon dipi-hand-icon"></div>
						</div>
					</div>
					<iframe height="100%%" width="100%%" src="https://www.youtube.com/embed/%1$s?controls=0" frameBorder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowFullScreen></iframe>
				</div>',
                $this->getYoutubeID($this->props['videomp4']),
                $this->props['width'],
                $this->props['height']
            );
        }

        $videomp4 = '';
        if (!empty($this->props['videomp4'])) {
            $videomp4 = sprintf('<source src="%1$s" type="video/mp4"/>', $this->props['videomp4']);
        }

        $videowebm = '';
        if (!empty($this->props['videowebm'])) {
            $videowebm = sprintf('<source src="%1$s" type="video/webm"/>', $this->props['videowebm']);
        }

        return sprintf('
			<div class="dipi-panorma-wrapper wrapper" style="height:100%%">
				<div class="dipi-panorama-overlay">
					<div class="dipi-panorama-overlay-content">
						<div class="dipi-panorama-icon dipi-scroll-icon"></div><br />
						<div class="dipi-panorama-icon dipi-hand-icon"></div>
					</div>
				</div>
				<video class="dipi-panorama-video video-js vjs-default-skin vjs-big-play-centered"
					controls
					preload="none"
					style="width:100%%;height:100%%"
					poster="%3$s"
					data-is-autoload="%6$s"
					crossOrigin="anonymous">
					%4$s
					%5$s
					<p class="vjs-no-js">
						To view this video please enable JavaScript, and consider upgrading to
						a web browser that supports HTML5 video
					</p>
				</video>
			</div>',
            $this->props['width'], // #1
            $this->props['height'], // #2
            $this->props['poster'], // #3
            $videomp4, // #4
            $videowebm, // #5
            $this->props['is_autoload']// #6
        );
    }
    public function render_panorama_image($attrs, $content, $render_slug)
    {
        $images = '';
        if ($this->props['type'] == 'Equirectangular') {
            $images = sprintf('data-image="%1$s"', $this->props['image']);
        } else if ($this->props['type'] == 'Cube Map') {
            $images = sprintf('data-image0="%1$s"
								data-image1="%2$s"
								data-image2="%3$s"
								data-image3="%4$s"
								data-image4="%5$s"
								data-image5="%6$s"',
                $this->props['image0'],
                $this->props['image1'],
                $this->props['image2'],
                $this->props['image3'],
                $this->props['image4'],
                $this->props['image5']
            );
        }
        return sprintf(
            '<div class="dipi-panorma-wrapper wrapper" style="height:100%%">
				<div class="dipi-panorama-overlay">
					<div class="dipi-panorama-overlay-content">
						<div class="dipi-panorama-icon dipi-scroll-icon"></div><br />
						<div class="dipi-panorama-icon dipi-hand-icon"></div>
					</div>
				</div>
				<div id="%6$s" class="dipi-panorama"
				data-type="%1$s"
				data-is-autoload="%7$s"
				%2$s
				style="width:%3$s; height: %4$s"></div>
			</div>',
            $this->props['type'], // #1
            $images, // #2
            '100%', // #3
            $this->props['height'], // #4
            $this->module_classname($render_slug), // #5
            $this->module_id(), // #6
            $this->props['is_autoload']// #7
        );
    }

    public function render_panorama_image2d($attrs, $content, $render_slug)
    {

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-panorma-image2d',
            'declaration' => "overflow: hidden;position: relative;",
        ]);

        $img_src = $this->props['image2d'];
        $img_size = getimagesize($this->props['image2d']);

        $width = ($this->props['repeat'] === 'Horizontal' || $this->props['repeat'] === 'Both') ? $img_size[0] * 3 . 'px' : $img_size[0] . 'px';
        $height = ($this->props['repeat'] === 'Vertical' || $this->props['repeat'] === 'Both') ? $img_size[1] * 3 . 'px' : $img_size[1] . 'px';
        // $height = $this->props['height'];
        $rs_height = $this->dipi_get_responsive_prop('height');
        
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-panorma-image2d .dipi-img-drag',
            'declaration' => "position: absolute;background-image:url($img_src);width:$width; height:$height;transform: translate(-50%,-50%);z-index:1;cursor: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAodJREFUeNq0Vz2IGkEUnjPXCqYyWG2njWChkO6MVTpzYJFCyKW08mzsJBe0P9MIaSQBm1RqZxo1hZXCHdholassBIlok8583/JW9sy57u7tPvjYH4b53pv35nszZ8qBxePxBB5pIAQ8AJ3pdLpWLuzMJiGJ2kJ6aJ9BfuOU+IVN0gHwmhECBeA78AvQgPfhcDi0XC5/OiEO2BhzC3CJS4wOKAKfhPQSuAeu4WDaCfG5jTHvZHJGe8f8RiIRtVgsSHQh5L+BD8DQk4ilmLjUXXEgVK/XVa/XU5lMRknO1+KY5vVSG0YHDEIVjUaN/wk3VW1JjGq9l4iyJ+bRZHt5muNvwNUJB196GrFMWnIzsRcRn7IBilDJUl9Kevwn5tZiwXW7XW273bbhxFByToGpH5PUZxPXajWVTCb191arRcKrYDCo4IS+z+HIF6n8jnk1Al7ljGS0crmsRqOReZ+3Renu4MS1JTEGaCIeji0Wiz3a59lsVjWbTeP7VrT/MTHJgIFIID38Y/bSjZGYqTCExxCc8ycaQpqDWTQomBA0mV5eHAoEI0ilUvvIDr/5PplMzApnqc27XC63M2yz2eyKxeKO/w24tUajYcyRfirHnfl8riqVyr5g2BRYMH4LyEfuQSyxnodqtar/zOfz+tKNx2PPiAMH8sjN/oZtDuT7yI0c0gFfiE+Re2mBI43Bd/KARVfyi3xt5yDgGTl3i+lwYasfP5scIqT6/b6SA6O9czUNZ+a/ODv/wOtbeP6KE5kk0NLQpVShUFCr1YqfBcz1YJvYLTnHkFSWmb35q6MrzJGbRYJ6Tl2nuJhtNpvpZEyNGElLju9ORxy4kVtFyGLYUO5W/x30/wkwAGYcYOCgmyR/AAAAAElFTkSuQmCC), auto;",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-panorma-image2d .dipi-img-drag img',
            'declaration' => "display:block;max-width:inherit",
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-panorama-overlay',
            'declaration' => "display: flex;align-items: center;justify-content: center;text-align: center;position: absolute;width:100%;height:100%;z-index:2;transition:visibility 0.3s linear,opacity 0.3s linear;visibility:visible;opacity:1;",
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-panorama-overlay.light',
            'declaration' => "color:#fff",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-panorama-overlay.dark',
            'declaration' => "color:#000",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%%:hover .dipi-panorama-overlay',
            'declaration' => "visibility:hidden;opacity:0;",
        ]);
        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-hand-icon',
            'declaration' => "width: 25px;height: 30px;background-size: 100% 100%;	background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyMy4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCINCgkgdmlld0JveD0iMCAwIDM5Ni41IDQ2OS4zIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAzOTYuNSA0NjkuMzsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHN0eWxlIHR5cGU9InRleHQvY3NzIj4NCgkuc3Qwe2ZpbGw6I0ZGRkZGRjtzdHJva2U6IzAwMDAwMDtzdHJva2UtbWl0ZXJsaW1pdDoxMDt9DQo8L3N0eWxlPg0KPGc+DQoJPGc+DQoJCTxwb2x5Z29uIGNsYXNzPSJzdDAiIHBvaW50cz0iMTMsMjc0LjggMTg2LjgsNDQ4LjYgMjkzLjksNDQ4LjYgMzQwLjUsNDQ4LjYgMzYyLjMsNDI2LjggMzgxLjMsMzg0LjYgMzg1LjYsMjk2LjIgMzg1LjYsMjI0LjkgDQoJCQkzNTguNSwyMDYuOSAzMjIuNCwyMDQgMjk3LjIsMTgxLjIgMjY2LjMsMTg1LjUgMjMyLjEsMTY0LjYgMTk4LjIsMTYxLjcgMTkwLjMsNzIuNCAxNTgsNTUuMiAxMzAuNCw3MC45IDEzMS40LDEzNC42IDEyOSwxODQgDQoJCQkxMjkuOSwyMTUuNCAxMjkuNSwyMzQuNiAxMjcuNiwyNTguNyAxMjYuMSwyNzcuNyA0OS42LDI0MC4xIDE4LjcsMjQ1LjMgCQkiLz4NCgkJPHBhdGggZD0iTTM1My44LDE5MmMtOC44LDAtMTYuOSwyLjctMjMuNyw3LjJjLTUuOC0xNi42LTIxLjctMjguNS00MC4zLTI4LjVjLTguOCwwLTE2LjksMi43LTIzLjcsNy4yDQoJCQljLTUuOC0xNi42LTIxLjctMjguNS00MC4zLTI4LjVjLTcuOCwwLTE1LjEsMi4xLTIxLjMsNS43Vjg1LjNjMC0yMy41LTE5LjEtNDIuNy00Mi43LTQyLjdzLTQyLjcsMTkuMS00Mi43LDQyLjd2MTgxLjNMODIsMjM4LjgNCgkJCWMtMjItMTYuNS01My4zLTE0LjMtNzIuNyw1LjJjLTEyLjUsMTIuNS0xMi41LDMyLjgsMCw0NS4ybDE1MS45LDE1MS45YzE4LjEsMTguMSw0Mi4yLDI4LjEsNjcuOSwyOC4xaDUwDQoJCQljNjQuNywwLDExNy4zLTUyLjYsMTE3LjMtMTE3LjNWMjM0LjdDMzk2LjUsMjExLjEsMzc3LjQsMTkyLDM1My44LDE5MnogTTM3NS4yLDM1MmMwLDUyLjktNDMuMSw5Ni05Niw5NmgtNTANCgkJCWMtMTkuOSwwLTM4LjctNy44LTUyLjgtMjEuOUwyNC41LDI3NC4yYy00LjItNC4yLTQuMi0xMC45LDAtMTUuMWM2LjYtNi42LDE1LjQtMTAsMjQuMy0xMGM3LjIsMCwxNC40LDIuMiwyMC41LDYuOGw1NC4xLDQwLjYNCgkJCWMzLjIsMi40LDcuNiwyLjgsMTEuMiwxczUuOS01LjUsNS45LTkuNVY4NS4zYzAtMTEuOCw5LjYtMjEuMywyMS4zLTIxLjNjMTEuOCwwLDIxLjMsOS42LDIxLjMsMjEuM3YxNjBjMCw1LjksNC44LDEwLjcsMTAuNywxMC43DQoJCQlzMTAuNy00LjgsMTAuNy0xMC43VjE5MmMwLTExLjgsOS42LTIxLjMsMjEuMy0yMS4zYzExLjgsMCwyMS4zLDkuNiwyMS4zLDIxLjN2NTMuM2MwLDUuOSw0LjgsMTAuNywxMC43LDEwLjcNCgkJCWM1LjksMCwxMC43LTQuOCwxMC43LTEwLjd2LTMyYzAtMTEuOCw5LjYtMjEuMywyMS4zLTIxLjNzMjEuMyw5LjYsMjEuMywyMS4zdjMyYzAsNS45LDQuOCwxMC43LDEwLjcsMTAuN3MxMC43LTQuOCwxMC43LTEwLjcNCgkJCXYtMTAuN2MwLTExLjgsOS42LTIxLjMsMjEuMy0yMS4zczIxLjMsOS42LDIxLjMsMjEuM0wzNzUuMiwzNTJMMzc1LjIsMzUyeiIvPg0KCTwvZz4NCjwvZz4NCjxnPg0KCTxnPg0KCQk8cGF0aCBkPSJNMTYxLjgsMGMtNDcuMSwwLTg1LjMsMzguMy04NS4zLDg1LjNjMCwxNC4yLDMuNywyOC4xLDExLDQxLjNjMiwzLjUsNS42LDUuNSw5LjMsNS41YzEuNywwLDMuNS0wLjQsNS4yLTEuMw0KCQkJYzUuMS0yLjksNy05LjQsNC4xLTE0LjVjLTUuNS05LjktOC4zLTIwLjQtOC4zLTMwLjljMC0zNS4zLDI4LjctNjQsNjQtNjRzNjQsMjguNyw2NCw2NGMwLDUuMS0wLjgsMTAuNC0yLjUsMTYuNw0KCQkJYy0xLjYsNS43LDEuOCwxMS41LDcuNSwxMy4xYzUuNiwxLjYsMTEuNS0xLjgsMTMuMS03LjVjMi4yLTguMiwzLjMtMTUuMywzLjMtMjIuNEMyNDcuMiwzOC4zLDIwOC45LDAsMTYxLjgsMHoiLz4NCgk8L2c+DQo8L2c+DQo8L3N2Zz4NCg==')",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-scroll-icon',
            'declaration' => "background-size: 100% 100%;      margin-right: 8px!important; width: 30px;height: 40px;	background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyMy4xLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCINCgkgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+DQoJLnN0MHtmaWxsOiNGRkZGRkY7fQ0KPC9zdHlsZT4NCjxlbGxpcHNlIGNsYXNzPSJzdDAiIGN4PSIyNTUuNiIgY3k9IjI1NC45IiByeD0iMTY3LjUiIHJ5PSIyMzYiLz4NCjxnPg0KCTxnPg0KCQk8cGF0aCBkPSJNMjU2LDBDMTU2LjYsMCw3NS43LDgyLjEsNzUuNywxODMuMXYxNDUuOGMwLDEwMSw4MC45LDE4My4xLDE4MC4zLDE4My4xYzk5LjQsMCwxODAuMy04MS45LDE4MC4zLTE4Mi41VjE4My4xDQoJCQlDNDM2LjMsODIuMSwzNTUuNCwwLDI1NiwweiBNNDAyLjQsMzI5LjVjMCw4Mi02NS43LDE0OC42LTE0Ni40LDE0OC42Yy04MC43LDAtMTQ2LjQtNjYuOS0xNDYuNC0xNDkuMlYxODMuMQ0KCQkJYzAtODIuMyw2NS43LTE0OS4yLDE0Ni40LTE0OS4yYzgwLjcsMCwxNDYuNCw2Ni45LDE0Ni40LDE0OS4yVjMyOS41eiIvPg0KCTwvZz4NCjwvZz4NCjxnPg0KCTxnPg0KCQk8cGF0aCBkPSJNMjU2LDE0MC4xYy05LjQsMC0xNyw3LjYtMTcsMTd2NTkuM2MwLDkuNCw3LjYsMTcsMTcsMTdjOS40LDAsMTctNy42LDE3LTE3di01OS4zQzI3MywxNDcuNywyNjUuNCwxNDAuMSwyNTYsMTQwLjF6Ii8+DQoJPC9nPg0KPC9nPg0KPC9zdmc+DQo=')",
        ]);

        ET_Builder_Element::set_style($render_slug, [
            'selector' => '%%order_class%% .dipi-panorama-icon',
            'declaration' => "display: inline-block;vertical-align: middle;margin: 5px;",
        ]);
       
         
        return sprintf(
            '<div class="dipi-panorma-wrapper wrapper loaded dipi-panorma-image2d" style="height:100%%;">
				<div class="dipi-panorama-overlay">
					<div class="dipi-panorama-overlay-content">
 						<div class="dipi-panorama-icon dipi-scroll-icon"></div><br />
						<div class="dipi-panorama-icon dipi-hand-icon"></div>
					</div>
				</div>
				<div class="dipi-img-drag" data-direction="%3$s" data-repeat="%4$s" 
                    data-module-height="%2$s" 
                    data-module-height-tablet="%7$s" 
                    data-module-height-phone="%8$s" 
                    data-image-width="%5$s" 
                    data-image-height="%6$s">
				</div>
			</div>',
            $this->props['image2d'], // #1
            $this->props['height'], // #2
            $this->props['direction'], // #3
            $this->props['repeat'], // #4
            $img_size[0], // #5
            $img_size[1], // #6
            $rs_height['tablet'], // #7
            $rs_height['phone'] // #8
        );
    }
    public function render($attrs, $content, $render_slug)
    {
        wp_enqueue_script('dipi_panorama_public');
        wp_enqueue_style('dipi_pannellum');

        if (!isset($this->props['border_style_all']) || empty($this->props['border_style_all'])) {
            ET_Builder_Element::set_style($render_slug, [
                'selector' => '%%order_class%% .wrapper',
                'declaration' => "border-style: solid;",
            ]);
        }
        $this->process_range_field_css( array(
            'render_slug'       => $render_slug,
            'slug'              => 'height',
            'type'              => 'height',
            'selector'          => '%%order_class%%',
            'important'         => false
        ) );

        if ($this->props['type'] == 'Video') {
            wp_enqueue_script('dipi_videojs_pannellum_plugin');
            wp_enqueue_style('dipi_videojs');
            return $this->render_panorama_video($attrs, $content, $render_slug);
        } else if ($this->props['type'] == '2D Image') {
            return $this->render_panorama_image2d($attrs, $content, $render_slug);
        } else {
            return $this->render_panorama_image($attrs, $content, $render_slug);
        }
    }
}

new DIPI_Panorama;
