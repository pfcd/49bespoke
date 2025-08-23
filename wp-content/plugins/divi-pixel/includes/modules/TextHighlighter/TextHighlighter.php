<?php
class DIPI_TextHighlighter extends DIPI_Builder_Module
{

	public $slug = 'dipi_text_highlighter';

	protected $module_credits = array(
		'module_uri' => 'https://divi-pixel.com/modules/text-highlighter',
		'author' => 'Divi Pixel',
		'author_uri' => 'https://divi-pixel.com'
	);
	public function get_custom_style($slug_value, $type, $important)
	{
			return sprintf('%1$s: %2$s%3$s;', $type, $slug_value, $important ? ' !important' : '');
	}
	public function get_changed_prop_value($slug, $conv_matrix)
	{
			if (array_key_exists($this->props[$slug], $conv_matrix)) {
					$this->props[$slug] = $conv_matrix[$this->props[$slug]];
			}

	}
	public function apply_custom_margin_padding($function_name, $slug, $type, $class, $important = true)
	{
			$slug_value_responsive_active = isset($this->props[$slug . "_last_edited"]) ? et_pb_get_responsive_status($this->props[$slug . "_last_edited"]) : false;
			$slug_value = (isset($this->props[$slug])) ? $this->props[$slug] : '';
			$slug_value_tablet = ($slug_value_responsive_active && isset($this->props[$slug . "_tablet"])) ? $this->props[$slug . "_tablet"] : $slug_value;
			$slug_value_phone = ($slug_value_responsive_active && isset($this->props[$slug . "_phone"])) ? $this->props[$slug . "_phone"] : $slug_value_tablet;

			if (isset($slug_value) && !empty($slug_value)) {
					ET_Builder_Element::set_style($function_name, array(
							'selector' => $class,
							'declaration' => et_builder_get_element_style_css($slug_value, $type, $important),
					));
			}

			if (isset($slug_value_tablet) && !empty($slug_value_tablet) && $slug_value_responsive_active) {
					ET_Builder_Element::set_style($function_name, array(
							'selector' => $class,
							'declaration' => et_builder_get_element_style_css($slug_value_tablet, $type, $important),
							'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
					));
			}

			if (isset($slug_value_phone) && !empty($slug_value_phone) && $slug_value_responsive_active) {
					ET_Builder_Element::set_style($function_name, array(
							'selector' => $class,
							'declaration' => et_builder_get_element_style_css($slug_value_phone, $type, $important),
							'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
					));
			}
	}
	public function init()
	{
		$this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
		$this->vb_support = 'on';
		$this->name = esc_html__('Pixel Text Highlighter', 'dipi-divi-pixel');
		$this->main_css_element = '%%order_class%%.dipi_text_highlighter';

		$this->settings_modal_toggles = [
				'general' => [
					'toggles' => [
						'content_text'	=> esc_html__( 'Text', 'dipi-divi-pixel' ),
						'content_settings'	=> esc_html__( 'Settings', 'dipi-divi-pixel' ),
						'content_animation'	=> esc_html__( 'Animation', 'dipi-divi-pixel' ),
					],
				],
				'advanced' => [
					'toggles' => [
							//Highlight color
							'design_highlight_shape'	=> [
									'title'		=>	esc_html__( 'Highlight Shape', 'dipi-divi-pixel' ),
									'priority'	=>	1,
							],
							// Highlight font
							'design_text' => [
									'title'             => esc_html__('Text', 'dipi-divi-pixel'),
									'priority'          => 2,
									'sub_toggles'       => [
										'all_text'   => [
												'name' => 'All',
										],
										'prefix_text'   => [
											'name' => 'Pre',
										],
										'highlighted_text'   => [
												'name' => 'Highlighted',
										],
										'suffix_text'   => [
											'name' => 'Suf',
										],
									],
									'tabbed_subtoggles' => true,			
								],
							// Text Alignment
							'dipi_text_alignment'=> [
									'title'             => esc_html__('Text Alignment', 'dipi-divi-pixel'),
									'priority'          => 5,
							],
					],
				],
		];
	}

	public function get_custom_css_fields_config()
	{
		$fields = [];

		$fields['prefix'] = [
			'label'    => esc_html__('Prefix', 'dipi-divi-pixel'),
			'selector' => '%%order_class%% .dipi-highlight-text-wrapper .dipi-highlight-prefix-text',
		];
		$fields['highlighted_text'] = [
			'label'    => esc_html__('Highlighted Text', 'dipi-divi-pixel'),
			'selector' => '%%order_class%% .dipi-highlight-text-wrapper .dipi-text-highlight-text',
		];
		$fields['highlighted_shape'] = [
			'label'    => esc_html__('Highlighted Shape', 'dipi-divi-pixel'),
			'selector' => '%%order_class%% .dipi-text-highlight-wrapper svg',
		];
		$fields['suffix'] = [
			'label'    => esc_html__('Suffix', 'dipi-divi-pixel'),
			'selector' => '%%order_class%% .dipi-highlight-text-wrapper .dipi-highlight-suffix-text',
		];
		
		return $fields;
	}
	
	public function get_fields()
	{

		$fields = [];

		$fields['text_highlighter_prefix' ] = [
			'label'           => esc_html__( 'Prefix', 'dipi-divi-pixel' ),
			'type'            => 'text',
			'dynamic_content' => 'text',
			'option_category' => 'basic_option',
			'description'     => esc_html__( 'Prefix entered here will appear before the highlighted text.', 'dipi-divi-pixel' ),
			'toggle_slug'     => 'content_text',
		];

		$fields['text_highlighter_text'] = [
			'label'           => esc_html__( 'Highlighted Text', 'dipi-divi-pixel' ),
			'type'            => 'text',
			'dynamic_content' => 'text',
			'option_category' => 'basic_option',
			'description'     => esc_html__( 'Hightlighted Text entered here will appear inside the module.', 'dipi-divi-pixel' ),
			'toggle_slug'     => 'content_text',
		];

		$fields['text_highlighter_suffix'] = [
			'label'           => esc_html__( 'Suffix', 'dipi-divi-pixel' ),
			'type'            => 'text',
			'dynamic_content' => 'text',
			'option_category' => 'basic_option',
			'description'     => esc_html__( 'Suffix entered here will appear after highlighted text.', 'dipi-divi-pixel' ),
			'toggle_slug'     => 'content_text',
		];

		$fields['highlight_shape'] = [
			'label'             => esc_html__( 'Highlight Shape', 'dipi-divi-pixel' ),
			'type'              => 'select',
			'option_category'   => 'basic_option',
			'toggle_slug'       => 'content_text',
			'default'           => 'underline',
			'description'       => esc_html__( 'Select highlighted text shape.' ),
			'options'           => [
				'underline'     => esc_html__( 'Underline', 'dipi-divi-pixel' ),
				'dashed'  		=> esc_html__( 'Dashed Underline', 'dipi-divi-pixel' ),
				'multiline'   	=> esc_html__( 'Multiline', 'dipi-divi-pixel' ),
				'square_box'   	=> esc_html__( 'Box', 'dipi-divi-pixel' ),
				'curly-line-1'  => esc_html__( 'Curly Line 1', 'dipi-divi-pixel' ),
				'curly-line-2'  => esc_html__( 'Curly Line 2', 'dipi-divi-pixel' ),
				'delete'        => esc_html__( 'Delete', 'dipi-divi-pixel' ),
				'circle_1'      => esc_html__( 'Circle 1', 'dipi-divi-pixel' ),
				'circle_2'     	=> esc_html__( 'Circle 2', 'dipi-divi-pixel' ),
				'diagonal'      => esc_html__( 'Diagonal', 'dipi-divi-pixel' ),
				'double'      	=> esc_html__( 'Double', 'dipi-divi-pixel' ),
				'double-line'   => esc_html__( 'Double Line', 'dipi-divi-pixel' ),
				'strikethrough' => esc_html__( 'Strikethrough', 'dipi-divi-pixel' ),
				'zigzag' 		=> esc_html__( 'Zigzag', 'dipi-divi-pixel' ),
				'zigzag_line' 	=> esc_html__( 'Zigzag Line', 'dipi-divi-pixel' ),
				'wave_1' 		=> esc_html__( 'Wave 1', 'dipi-divi-pixel' ),
				'wave_2' 		=> esc_html__( 'Wave 2', 'dipi-divi-pixel' ),
				'spiral' 		=> esc_html__( 'Spiral', 'dipi-divi-pixel' ),
				'brush' 		=> esc_html__( 'Brush', 'dipi-divi-pixel' ),
				'splash' 		=> esc_html__( 'Splash', 'dipi-divi-pixel' ),
				'brick-wall' 	=> esc_html__( 'Brick Wall', 'dipi-divi-pixel' ),
				'bracket-1' 	=> esc_html__( 'Bracket 1', 'dipi-divi-pixel' ),
				'bracket-2' 	=> esc_html__( 'Bracket 2', 'dipi-divi-pixel' ),
				'fluid' 		=> esc_html__( 'Fluid', 'dipi-divi-pixel' )
			],				
		];
		$fields['text_wrapper_tag'] = [
			'label'           => esc_html__('Text Wrapper Tag', 'dipi-divi-pixel'),
			'type'            => 'select',
			'description'     => esc_html__('Select the heading tag, which you would like to use', 'dipi-divi-pixel'),
			'option_category' => 'basic_option',
			'toggle_slug'     => 'content_text',
			'default'         => 'h2',
			'options'         => [
				'h1'	  => esc_html__('H1', 'dipi-divi-pixel'),
				'h2'	  => esc_html__('H2', 'dipi-divi-pixel'),
				'h3'	  => esc_html__('H3', 'dipi-divi-pixel'),
				'h4'	  => esc_html__('H4', 'dipi-divi-pixel'),
				'h5'	  => esc_html__('H5', 'dipi-divi-pixel'),
				'h6'	  => esc_html__('H6', 'dipi-divi-pixel'),
				'p'	      => esc_html__('P', 'dipi-divi-pixel'),
				'span'	  => esc_html__('Span', 'dipi-divi-pixel'),
			],
		];
		
		$fields['text_direction'] = [
			'label'           => esc_html__('Prefx/Suffix Direction', 'dipi-divi-pixel'),
			'type'  => 'select',
			'description'     => esc_html__('Select how you would like to display the heading. Either inline or stacked.', 'dipi-divi-pixel'),
			'toggle_slug'     => 'content_settings',
			'options'         => array(
				'inline' => esc_html__('Row', 'dipi-divi-pixel'),
				'block' => esc_html__('Column', 'dipi-divi-pixel'),
			),
			'default'         => 'row',
			'mobile_options'  => true,
		];

		$fields['highlight_z_index'] = [
			'label'           => esc_html__('Z-index of Highlight Shape', 'dipi-divi-pixel'),
			'type'  => 'select',
			'description'     => esc_html__('Select wether Highlight Shape is above or below of text', 'dipi-divi-pixel'),
			'toggle_slug'     => 'content_settings',
			'options'         => array(
				'above' => esc_html__('Above', 'dipi-divi-pixel'),
				'below' => esc_html__('Below', 'dipi-divi-pixel'),
			),
			'default'         => 'below',
			'mobile_options'  => true,
		];

		$fields['highlight_animation_start'] = [
			'label'           => esc_html__('Start Animation', 'dipi-divi-pixel'),
			'type'            => 'select',
			'description'     => esc_html__('Define whenever animation will start', 'dipi-divi-pixel'),
			'option_category' => 'basic_option',
			'toggle_slug'     => 'content_animation',
			'default'         => 'in_a_viewport',
			'options'         => [
				'in_loading'	  => esc_html__('On page load', 'dipi-divi-pixel'),
				'in_a_viewport'	  => esc_html__('In a viewport', 'dipi-divi-pixel'),
			],
		];
		$fields['highlight_animation_start_viewport'] = [
			'label'           => esc_html__( 'View Port', 'dipi-divi-pixel' ),
			'type'            => 'range',
			'toggle_slug'         => 'content_animation',
			'range_settings'  => [
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			],
			'default'             => '75%',
			'validate_unit'       => true,
			'fixed_unit'          => '%',
			'fixed_range'         => true,
			'reset_animation'     => true,
			'show_if'	=> [
				'highlight_animation_start' => 'in_a_viewport'
			]
		];
		$fields['highlight_animation_delay'] = [
			'label'           => esc_html__( 'Animation Delay', 'dipi-divi-pixel' ),
			'type'            => 'range',
			'toggle_slug'         => 'content_animation',
			'range_settings'  => [
				'min'  => 0,
				'max'  => 10000,
				'step' => 100,
			],
			'default'             => '0ms',
			'description'         => esc_html__( 'If you would like to add a delay before your animation runs you can designate that delay here in milliseconds.' ),
			'validate_unit'       => true,
			'fixed_unit'          => 'ms',
			'fixed_range'         => true,
			'reset_animation'     => true,
			'mobile_options'      => true,
		];
		$fields['highlight_animation_duration'] = [
			'label'           => esc_html__( 'Animation Duration', 'dipi-divi-pixel' ),
			'type'            => 'range',
			'toggle_slug'         => 'content_animation',
			'range_settings'  => [
				'min'  => 100,
				'max'  => 10000,
				'step' => 100,
			],
			'default'             => '800ms',
			'description'         => esc_html__( 'If you would like to add a duration of your animation you can define the amount here in milliseconds. ' ),
			'validate_unit'       => true,
			'fixed_unit'          => 'ms',
			'fixed_range'         => true,
			'reset_animation'     => true,
			'mobile_options'      => true,
		];
		$fields['highlight_delay_after_animation'] = [
			'label'           => esc_html__( 'Delay after animation', 'dipi-divi-pixel' ),
			'type'            => 'range',
			'toggle_slug'         => 'content_animation',
			'range_settings'  => [
				'min'  => 0,
				'max'  => 30000,
				'step' => 100,
			],
			'default'             => '3000ms',
			'description'         => esc_html__( 'If you would like to add a duration of your animation you can define the amount here in milliseconds. ' ),
			'validate_unit'       => true,
			'fixed_unit'          => 'ms',
			'fixed_range'         => true,
			'reset_animation'     => true,
			'mobile_options'      => true,
		];
		$fields['highlight_animation_repeat_mode'] = [
			'label'           => esc_html__('Repeat Mode', 'dipi-divi-pixel'),
			'type'            => 'select',
			'description'     => esc_html__('Define whether animation will be repeated or not', 'dipi-divi-pixel'),
			'option_category' => 'basic_option',
			'toggle_slug'     => 'content_animation',
			'default'         => 'infinite',
			'options'         => [
				'no'	  => esc_html__('No Animation', 'dipi-divi-pixel'),
				'definite'	  => esc_html__('Definite', 'dipi-divi-pixel'),
				'infinite'	  => esc_html__('Infinite', 'dipi-divi-pixel'),
			],
			/*'mobile_options'      => true,*/
		];
		$fields['highlight_animation_count_mode'] = [
			'label'           => esc_html__('Count Mode', 'dipi-divi-pixel'),
			'type'            => 'select',
			'description'     => esc_html__('Define how to count the Repeat Counts.
				Every time in Viewport: Repeats animation for Repeat Counts every time in the viewport.
				Cumulative: Repeats animation until the cumulative number of repeated counts in the viewport reached Repeat Counts.', 'dipi-divi-pixel'),
			'option_category' => 'basic_option',
			'toggle_slug'     => 'content_animation',
			'default'         => 'everytime_in_viewport',
			'options'         => [
				'everytime_in_viewport'	  => esc_html__('Every time in Viewport', 'dipi-divi-pixel'),
				'cumulative'	  => esc_html__('Cumulative', 'dipi-divi-pixel'),
			],
			'show_if' => [
				'highlight_animation_repeat_mode' => 'definite',
			],
			/*'mobile_options'      => true,*/
		];
		$fields['highlight_animation_repeat_counts'] = [
			'label'           => esc_html__( 'Repeat Counts', 'dipi-divi-pixel' ),
			'type'            => 'range',
			'toggle_slug'         => 'content_animation',
			'range_settings'  => [
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			],
			'default'             => '3',
			'description'         => esc_html__( 'Define how many times animation will be repeated' ),
			'validate_unit'       => true,
			'fixed_unit'          => '',
			'fixed_range'         => true,
			'reset_animation'     => true,
			'mobile_options'      => true,
			'show_if' => [
				'highlight_animation_repeat_mode' => 'definite',
			],
		];
		$fields['reverse_animation'] = [
			'label' => esc_html__('Reverse Animation', 'dipi-divi-pixel'),
			'description' => esc_html__(' Allow you to reverse the animation so it animates in one direction, then pauses, the animated in the other direction before starting over', 'dipi-divi-pixel'),
			'type' => 'yes_no_button',
			'option_category' => 'configuration',
			'toggle_slug' => 'content_animation',
			'default' => 'off',
			'options' => array(
					'off' => esc_html__('Off', 'dipi-divi-pixel'),
					'on' => esc_html__('On', 'dipi-divi-pixel'),
			),
		];
		// Highlight Color
		$fields['stroke_color'] = [
			'label'          => esc_html__('Select Color', 'dipi-divi-pixel'),
			'type'           => 'color-alpha',
			'description'     => esc_html__( 'Select a suitable color to use as highlight for the text.', 'dipi-divi-pixel' ),
			'tab_slug'       => 'advanced',
			'toggle_slug'    => 'design_highlight_shape',
			'default'        => '#0077FF',
			'hover'			 => 'tabs',
			'mobile_options' => true,
			'responsive'	 => true,
		];

		// Highlight Width
		$fields['stroke_width'] = [
			'label'         => esc_html__('Stroke Width', 'dipi-divi-pixel'),
			'type'			=> 'range',
			'description'     => esc_html__( 'Adjust the width of the stroke added for the highlighted text.', 'dipi-divi-pixel' ),
			'tab_slug'		=> 'advanced',
			'toggle_slug'	=> 'design_highlight_shape',
			'default'		=> '9px',
			'mobile_options'=>	true,
			'responsive'	=>	true,
			'hover'			=>	'tabs',
			'range_settings'  => [
				'min'  => '1',
				'max'  => '100',
				'step' => '1',
			],
			'fixed_unit'      => 'px',
			'validate_unit'   => true,
		];
		$fields['highlight_line_cap'] = [
			'label' => esc_html__('Line Cap ', 'dipi-divi-pixel'),
			'option_category' => 'configuration',
			'tab_slug'		=> 'advanced',
			'toggle_slug'	=> 'design_highlight_shape',
			'type' => 'select',
			'default' => 'round',
			'options' => array(
					'round' => esc_html__('Round', 'dipi-divi-pixel'),
					'square' => esc_html__('Square', 'dipi-divi-pixel'),
					'butt' => esc_html__('Butt', 'dipi-divi-pixel'),
			),
			'description' => esc_html__('Line cap of Highlighted shape.', 'dipi-divi-pixel'),
		];
		$fields['shape_v_offset'] = [
			'label'         => esc_html__('Vertical Offset', 'dipi-divi-pixel'),
			'type'			=> 'range',
			'description'     => esc_html__( 'Adjust the vertical position of highlight shape.', 'dipi-divi-pixel' ),
			'tab_slug'		=> 'advanced',
			'toggle_slug'	=> 'design_highlight_shape',
			'default'		=> '0px',
			'hover'			=>	'tabs',
			'range_settings'  => [
				'min'  => '-100',
				'max'  => '100',
				'step' => '1',
			],
			'fixed_unit'      => 'px',
			'validate_unit'   => true,
			'mobile_options' => true,
		];
		$fields['shape_h_offset'] = [
			'label'         => esc_html__('Horizontal Offset', 'dipi-divi-pixel'),
			'type'			=> 'range',
			'description'     => esc_html__( 'Adjust the vertical position of highlight shape.', 'dipi-divi-pixel' ),
			'tab_slug'		=> 'advanced',
			'toggle_slug'	=> 'design_highlight_shape',
			'default'		=> '0px',
			'hover'			=>	'tabs',
			'range_settings'  => [
				'min'  => '-100',
				'max'  => '100',
				'step' => '1',
			],
			'fixed_unit'      => 'px',
			'validate_unit'   => true,
			'mobile_options' => true,
		];		

		$fields['highlighted_text_margin'] = [
			'label' => esc_html__('Margin', 'dipi-divi-pixel'),
			'type' => 'custom_margin',
			'mobile_options' => true,
			'responsive' => true,
			'tab_slug'          => 'advanced',
			'toggle_slug'       => 'design_text',
			'sub_toggle'  => 'highlighted_text',
		];
		$fields['highlighted_text_padding'] = [
				'label' => esc_html__('Padding', 'dipi-divi-pixel'),
				'type' => 'custom_margin',
				'mobile_options' => true,
				'responsive' => true,
				'tab_slug'          => 'advanced',
				'toggle_slug'       => 'design_text',
				'sub_toggle'  => 'highlighted_text',
		];

		return $fields;
	}

	public function get_advanced_fields_config()
	{
		$advanced_fields = array();
		$advanced_fields['fonts'] 	= [];
		$advanced_fields['text'] 	= false;
		// All Text
		$advanced_fields['fonts']['all_text'] =	[
			'label'       => esc_html__('All Text', 'dipi-divi-pixel'),
			'toggle_slug' => 'design_text',
			'tab_slug'    => 'advanced',
			'sub_toggle'  => 'all_text',
			'line_height' => [
				'default' => '1em'
			],
			'font_size'   => [
					'default' => '26px',
			],
			'css'         => [
					'main' => "%%order_class%% .dipi-highlight-text-wrapper",
			],
		];
		//Prefix Text
		$advanced_fields['fonts']['prefix_text']  =[
			'label'       => esc_html__('Prefix Text', 'dipi-divi-pixel'),
			'toggle_slug' => 'design_text',
			'tab_slug'    => 'advanced',
			'hide_text_align' => true,
			'sub_toggle'  => 'prefix_text',
			'line_height' => array(
				'default' => '1em',
			),
			'font_size'   => array(
				'default' => '26px',
			),
			'css'         => array(
				'main' => "%%order_class%% .dipi-highlight-prefix-text",
			),
		];
		// Highlighted Text
		$advanced_fields['fonts']['highlighted_text']  =[
			'label'       => esc_html__('Highlighted Text', 'dipi-divi-pixel'),
			'toggle_slug' => 'design_text',
			'tab_slug'    => 'advanced',
			'hide_text_align' => true,
			'sub_toggle'  => 'highlighted_text',
			'line_height' => array(
				'default' => '1em',
			),
			'font_size'   => array(
				'default' => '26px',
			),
			'css'         => array(
				'main' => "%%order_class%% .dipi-text-highlight-text",
			),
		];
		// Suffix Text
		$advanced_fields['fonts']['sufix_text']  =[
			'label'       => esc_html__('Suffix Text', 'dipi-divi-pixel'),
			'toggle_slug' => 'design_text',
			'tab_slug'    => 'advanced',
			'hide_text_align' => true,
			'sub_toggle'  => 'suffix_text',
			'line_height' => array(
				'default' => '1em',
			),
			'font_size'   => array(
				'default' => '26px',
			),
			'css'         => array(
				'main' => "%%order_class%% .dipi-highlight-suffix-text",
			),
		];

		return $advanced_fields;
	}
	public function dipi_apply_css($render_slug){
		$shape_v_offset = $this->props['shape_v_offset'];
		$shape_v_offset_values = et_pb_responsive_options()->get_property_values($this->props, 'shape_v_offset');
		$shape_v_offset_tablet = !empty($shape_v_offset_values['tablet']) ? $shape_v_offset_values['tablet'] : $shape_v_offset;
		$shape_v_offset_phone = !empty($shape_v_offset_values['phone']) ? $shape_v_offset_values['phone'] : $shape_v_offset_tablet;

		$shape_h_offset = $this->props['shape_h_offset'];
		$shape_h_offset_values = et_pb_responsive_options()->get_property_values($this->props, 'shape_h_offset');
		$shape_h_offset_tablet = !empty($shape_h_offset_values['tablet']) ? $shape_h_offset_values['tablet'] : $shape_h_offset;
		$shape_h_offset_phone = !empty($shape_h_offset_values['phone']) ? $shape_h_offset_values['phone'] : $shape_h_offset_tablet;
		
		/**
		 * Dispaly Inline or Stacked
		 *
		 */
		$this->generate_styles(
			array(
				'base_attr_name' => 'text_direction',
				'selector'       => "%%order_class%% .dipi-highlight-text-wrapper .dipi-highlight-prefix-text",
				'css_property'   => 'display',
				'render_slug'    => $render_slug,
				'type'           => 'select',
			)
		);
	
		$this->generate_styles(
			array(
				'base_attr_name' => 'text_direction',
				'selector'       => "%%order_class%% .dipi-highlight-text-wrapper .dipi-highlight-suffix-text",
				'css_property'   => 'display',
				'render_slug'    => $render_slug,
				'type'           => 'select',
			)
		);


		$highlight_z_index = $this->dipi_get_responsive_prop('highlight_z_index');

		ET_Builder_Element::set_style($render_slug, array(
				'selector' => "%%order_class%% .dipi-text-highlight-text ~span svg",
				'declaration' => sprintf('z-index: %1$s !important;', $highlight_z_index['desktop'] === 'above' ? '1' : '-1'),
		));

		ET_Builder_Element::set_style($render_slug, array(
				'selector' => "%%order_class%% .dipi-text-highlight-text ~span svg",
				'declaration' => sprintf('z-index: %1$s !important;', $highlight_z_index['tablet'] === 'above' ? '1' : '-1'),
				'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
		));

		ET_Builder_Element::set_style($render_slug, array(
				'selector' => "%%order_class%% .dipi-text-highlight-text ~span svg",
				'declaration' => sprintf('z-index: %1$s !important;', $highlight_z_index['phone'] === 'above' ? '1' : '-1'),
				'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
		));
		
		$this->generate_styles(
			array(
				'base_attr_name' => 'highlight_line_cap',
				'selector'       => "%%order_class%% .dipi-text-highlight-text ~span svg",
				'css_property'   => 'stroke-linecap',
				'render_slug'    => $render_slug,
				'type'           => 'select',
			)
		);
	
		$this->generate_styles(
			array(
				'base_attr_name' => 'stroke_width',
				'selector'       => "%%order_class%% .dipi-text-highlight-wrapper svg path",
				'css_property'   => 'stroke-width',
				'render_slug'    => $render_slug,
				'type'           => 'range',
			)
		);
	

		// Stroke Color

		$this->generate_styles(
			array(
				'base_attr_name' => 'stroke_color',
				'selector'       => "%%order_class%% .dipi-text-highlight-wrapper svg path",
				'css_property'   => 'stroke',
				'render_slug'    => $render_slug,
				'type'           => 'color-alpha',
			)
		);
		
		if ((float) $shape_v_offset > 0) {
			ET_Builder_Element::set_style($render_slug, [
				'selector' => '%%order_class%% .dipi-text-highlight-wrapper svg',
				'declaration' => "top: calc(50% + " . abs((float) $shape_v_offset) . "px) !important;",
			]);
		} else {
			ET_Builder_Element::set_style($render_slug, [
				'selector' => '%%order_class%% .dipi-text-highlight-wrapper svg',
				'declaration' => "top: calc(50% - " . abs((float) $shape_v_offset) . "px) !important;",
			]);
		}
		if ((float) $shape_v_offset_tablet >= 0) {
			ET_Builder_Element::set_style($render_slug, [
				'selector' => '%%order_class%% .dipi-text-highlight-wrapper svg',
				'declaration' => "top: calc(50% + " . abs((float) $shape_v_offset_tablet) . "px) !important;",
				'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
			]);
		} else {
			ET_Builder_Element::set_style($render_slug, [
				'selector' => '%%order_class%% .dipi-text-highlight-wrapper svg',
				'declaration' => "top: calc(50% - " . abs((float) $shape_v_offset_tablet) . "px) !important;",
				'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
			]);
		}
		if ((float) $shape_v_offset_phone >= 0) {
			ET_Builder_Element::set_style($render_slug, [
				'selector' => '%%order_class%% .dipi-text-highlight-wrapper svg',
				'declaration' => "top: calc(50% + " . abs((float) $shape_v_offset_phone) . "px) !important;",
				'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
			]);
		} else {
			ET_Builder_Element::set_style($render_slug, [
				'selector' => '%%order_class%% .dipi-text-highlight-wrapper svg',
				'declaration' => "top: calc(50% - " . abs((float) $shape_v_offset_phone) . "px) !important;",
				'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
			]);
		}

		if ((float) $shape_h_offset > 0) {
			ET_Builder_Element::set_style($render_slug, [
				'selector' => '%%order_class%% .dipi-text-highlight-wrapper svg',
				'declaration' => "left: calc(50% + " . abs((float) $shape_h_offset) . "px) !important;",
			]);
		} else {
			ET_Builder_Element::set_style($render_slug, [
				'selector' => '%%order_class%% .dipi-text-highlight-wrapper svg',
				'declaration' => "left: calc(50% - " . abs((float) $shape_h_offset) . "px) !important;",
			]);
		}
		if ((float) $shape_h_offset_tablet >= 0) {
			ET_Builder_Element::set_style($render_slug, [
				'selector' => '%%order_class%% .dipi-text-highlight-wrapper svg',
				'declaration' => "left: calc(50% + " . abs((float) $shape_h_offset_tablet) . "px) !important;",
				'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
			]);
		} else {
			ET_Builder_Element::set_style($render_slug, [
				'selector' => '%%order_class%% .dipi-text-highlight-wrapper svg',
				'declaration' => "left: calc(50% - " . abs((float) $shape_h_offset_tablet) . "px) !important;",
				'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
			]);
		}
		if ((float) $shape_h_offset_phone >= 0) {
			ET_Builder_Element::set_style($render_slug, [
				'selector' => '%%order_class%% .dipi-text-highlight-wrapper svg',
				'declaration' => "left: calc(50% + " . abs((float) $shape_h_offset_phone) . "px) !important;",
				'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
			]);
		} else {
			ET_Builder_Element::set_style($render_slug, [
				'selector' => '%%order_class%% .dipi-text-highlight-wrapper svg',
				'declaration' => "left: calc(50% - " . abs((float) $shape_h_offset_phone) . "px) !important;",
				'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
			]);
		}
		$this->apply_custom_margin_padding(
      $render_slug,
      'highlighted_text_margin',
      'margin',
      '%%order_class%% .dipi-text-highlight-wrapper'
    );
    $this->apply_custom_margin_padding(
      $render_slug,
      'highlighted_text_padding',
      'padding',
      '%%order_class%% .dipi-text-highlight-wrapper'
    );
	}
	public function render($attrs, $content, $render_slug)
	{
		wp_enqueue_script('dipi_text_highlighter_public');

		$textWrapperTag  	= 	$this->props['text_wrapper_tag'];
		$text_highlighter_prefix 	= 	$this->props['text_highlighter_prefix'];
		$text_highlighter_suffix		=	$this->props['text_highlighter_suffix'];
		$text_highlighter_text	=	$this->props['text_highlighter_text'];
		$highlight_animation_start = $this->props['highlight_animation_start'];
		$highlight_animation_start_viewport = $this->props['highlight_animation_start_viewport'];
		$highlight_animation_delay = $this->props['highlight_animation_delay'];
		$highlight_animation_duration = $this->props['highlight_animation_duration'];
		$highlight_delay_after_animation = $this->props['highlight_delay_after_animation'];
		$highlight_animation_repeat_mode = $this->props['highlight_animation_repeat_mode'];
		$highlight_animation_count_mode = $this->props['highlight_animation_count_mode'];
		$highlight_animation_repeat_counts = $this->props['highlight_animation_repeat_counts'];
		$reverse_animation = $this->props['reverse_animation'];

		// Prefix
		$text_prefix = "";
		if ( "" !== $text_highlighter_prefix ) {
			$text_prefix = sprintf(
				'<span class="dipi-highlight-prefix-text dipi-text-affixes">%1$s</span>',
				et_core_esc_previously( $text_highlighter_prefix )
			);
		}

		// Highlight Text
		$text_highlight = "";
		if ( "" !== $text_highlighter_text ) {
			$text_highlight = sprintf(
				'<span class="dipi-text-highlight-text dipi-text-highlight-text">%1$s</span>',
				et_core_esc_previously( $text_highlighter_text )
			);
		}

		// Suffix
		$text_suffix = "";
		if ( "" !== $text_highlighter_suffix ) {
			$text_suffix = sprintf(
				'<span class="dipi-highlight-suffix-text dipi-text-affixes">%1$s</span>',
				et_core_esc_previously( $text_highlighter_suffix )
			);
		}

		$svgprint = "";
		switch ($this->props['highlight_shape']) {
			case 'delete':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M497.4,23.9C301.6,40,155.9,80.6,4,144.4"></path><path d="M14.1,27.6c204.5,20.3,393.8,74,467.3,111.7"></path></svg>';
				break;	
			case 'multiline':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none">
					<path d="M3.7,125.7c50.5-3.7,442.9-7,487.5,4.7"></path>
					<path d="M488.6,133c-33.9-3-452.6-12-483.2-2.7"></path>
					<path d="M5.4,132.3c75.2,4.3,445.9-4,488.8-0.3"></path>
					</svg>';
				break;
			case 'dashed':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none">
			   			<path d="M2.1,139.3c5.2,0,9.7,0,15.3,0"/>
			   			<path d="M34.1,139.3c5.2,0,9.7,0,15.3,0"/>
			   			<path d="M66.1,139.3c5.2,0,9.7,0,15.3,0"/>
			   			<path d="M98.1,139.3c5.2,0,9.7,0,15.3,0"/>
			   			<path d="M130.1,139.3c5.2,0,9.7,0,15.3,0"/>
			   			<path d="M162.1,139.3c5.2,0,9.7,0,15.3,0"/>
			   			<path d="M194.1,139.3c5.2,0,9.7,0,15.3,0"/>
			   			<path d="M226.2,139.3c5.2,0,9.7,0,15.3,0"/>
			   			<path d="M258.2,139.3c5.2,0,9.7,0,15.3,0"/>
			   			<path d="M290.2,139.3c5.2,0,9.7,0,15.3,0"/>
			   			<path d="M322.2,139.3c5.2,0,9.7,0,15.3,0"/>
			   			<path d="M354.2,139.3c5.2,0,9.7,0,15.3,0"/>
			   			<path d="M386.2,139.3c5.2,0,9.7,0,15.3,0"/>
			   			<path d="M418.2,139.3c5.2,0,9.7,0,15.3,0"/>
			   			<path d="M450.2,139.3c5.2,0,9.7,0,15.3,0"/>
			   			<path d="M482.2,139.3c5.2,0,9.7,0,15.3,0"/>
			   		</svg>';
				break;
			case 'square_box':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M7.1,6.6C5.7,21.9,2.7,123,5.7,142.7s474.9-12,488.8-1c3-19.3,3.3-128-1.7-137.3c-5-9.3-476.2,3-481.9,5"/></svg>';
				break;
			case 'curly-line-1':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M3,146.1c17.1-8.8,33.5-17.8,51.4-17.8c15.6,0,17.1,18.1,30.2,18.1c22.9,0,36-18.6,53.9-18.6 c17.1,0,21.3,18.5,37.5,18.5c21.3,0,31.8-18.6,49-18.6c22.1,0,18.8,18.8,36.8,18.8c18.8,0,37.5-18.6,49-18.6c20.4,0,17.1,19,36.8,19 c22.9,0,36.8-20.6,54.7-18.6c17.7,1.4,7.1,19.5,33.5,18.8c17.1,0,47.2-6.5,61.1-15.6"></path></svg>';
				break;
			case 'curly-line-2':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M2.2,140.2l4.6-4.5c18.1-17.7,47.5-17.7,65.7,0l4.4,4.2l4.1-4c18.1-17.7,47.5-17.7,65.7,0l4.4,4.2l4.1-4c18.1-17.7,47.5-17.7,65.7,0l4.8,4.7l2.8-2.8c17.9-17.4,46.8-17.7,65-0.6l3.4,3.2l2.6-2.4c18.1-16.7,46.5-16.4,64.4,0.5l1.7,1.6l1.2-1.1c18-16.9,46.6-16.9,64.6,0.1l1.3,1.3l0.5-0.5c18.2-17.2,47.2-17,65.2,0.5l0,0"></path></svg>';
				break;
			case 'circle_1':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M325,18C228.7-8.3,118.5,8.3,78,21C22.4,38.4,4.6,54.6,5.6,77.6c1.4,32.4,52.2,54,142.6,63.7 c66.2,7.1,212.2,7.5,273.5-8.3c64.4-16.6,104.3-57.6,33.8-98.2C386.7-4.9,179.4-1.4,126.3,20.7"></path></svg>';
				break;
			case 'circle_2':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M29.7,117.9c43.4,27.7,151.8,30.4,226.1,28.1c120.4-3.8,242.5-24.6,241.6-60.9c-0.9-33-61.1-56.7-139.1-69.7C287.4,3.7,201.9,0.7,133,7.6C65.4,14.3,13.7,30.5,7.1,57c-12.9,59.8,74.8,73.3,183.5,77.6c90,3.6,164.9-3.1,251.4-21.7"></path></svg>';
				break;
			case 'diagonal':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M13.5,15.5c131,13.7,289.3,55.5,475,125.5"></path></svg>';
				break;
			case 'double':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M8.4,143.1c14.2-8,97.6-8.8,200.6-9.2c122.3-0.4,287.5,7.2,287.5,7.2"></path><path d="M8,19.4c72.3-5.3,162-7.8,216-7.8c54,0,136.2,0,267,7.8"></path></svg>';
				break;
			case 'double-line':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M5,125.4c30.5-3.8,137.9-7.6,177.3-7.6c117.2,0,252.2,4.7,312.7,7.6"></path><path d="M26.9,143.8c55.1-6.1,126-6.3,162.2-6.1c46.5,0.2,203.9,3.2,268.9,6.4"></path></svg>';
				break;
			case 'strikethrough':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M3,75h493.5"></path></svg>';
				break;
			case 'zigzag':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path class="st0" d="M6.7,111.6c0,0,487.1-6.7,488.2,7.4s-441.5-0.3-442.6,12.3c-1.1,12.6,296.4,5.6,309.9,16.6"></path></svg>';
				break;
			case 'zigzag_line':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M3,146.8l22.1-18l20.9,18l22.1-18l21,18.1l21.9-18.1l20.9,18l22.1-18l21,18.1l22-18.1l20.9,18l22.1-18l21,18.1l21.9-18.1l20.9,18l22.1-18l21,18.1l21.8-18.1l20.9,18l22.1-18l21,18.1l21.9-18.1l20.9,18l22.1-18"></path></svg>';
				break;
			case 'wave_1':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 466.33 50.26"><defs><style>.cls-1{fill:red;}</style></defs><title>Asset 4</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="cls-1" d="M0,40.46S116.21-9.15,131.26,9.53a6.89,6.89,0,0,1,1.3,5.28c-1.17,8.33-5.06,46.64,24.79,32.25,0,0,86.54-42.66,93.38-45.08,0,0,20.18-12,19.55,23.17a15.72,15.72,0,0,0,14.78,16.07c13.44.76,38.11-3.54,82.8-24.34,0,0,19-8.57,13.76,12.7a8.55,8.55,0,0,0,9.57,10.47c12.95-1.94,36.34-7.28,75.14-21.66"/></g></g></svg>';
				break;
			case 'wave_2':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 50 500 80" preserveAspectRatio="none"><path d="M12.8,143.9c4.9-27.9,40.8-50.5,45.7-47s-1.3,46.8,20.8,45.2c6.2-0.4,25.7-45.2,34.6-33.7c18.9,24.5,44.3,29.5,50.1,29.3c51.4-2.2,29.8-31.1,78-19.5c83.4,20,223,19.5,247.9,13.3"></path></svg>';
				break;
			case 'spiral':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 430.38 67.12"><defs><style>.cls-1{fill:#00828c;}</style></defs><title>Asset 6</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path class="cls-1" d="M0,50.34s42-.2,51.8-34.16c9-31.13-62.37,5.62-12.62,42.42A31,31,0,0,0,88.29,39.52a71.59,71.59,0,0,0,1.13-14.69C88.6-21,29.72,70.55,103.51,67c0,0,25.16-2.33,33.33-46.43S66.37,70.33,146,66.42c0,0,19.42-.55,31.31-42,10-34.76-46,2.39-14.18,27.27,20.15,15.76,50.17,9.74,62.52-12.68a62.5,62.5,0,0,0,5.48-13.71c7.45-27.17-30.26-8.58-15.54,17.6,11.71,20.84,41.15,21.5,55.42,2.32a47.54,47.54,0,0,0,9.64-28.76c.11-33.22-38,39.48,1.09,44.6a31.7,31.7,0,0,0,18.79-3.62c11-5.82,30.24-19.6,32.22-45.73,2.3-30.22-39,4.93-17.08,26.71,14,13.94,38,10.31,47.58-7a42.23,42.23,0,0,0,5.08-18.55c1.39-26.53-35.11-3.51-11.12,25.88a20.43,20.43,0,0,0,34.41-4.09c2.54-5.34,4.4-12.51,4.89-22.14,2-39.37-54.24,26.19,2.09,40.83,0,0,27.71,6.33,31.8-5.86"/></g></g></svg>';
				break;
			case 'brush':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M4.2,59.2c28.5-2.3,493-3,493-3L2.4,98.1c0,0,469-2.8,492.5-4.3"/></svg>';
				break;
			case 'splash':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 479.14 73.08"><title>Asset 3</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path d="M.53,23.05S-7,58,34.51,69C120.17,91.75,198.87,12,215.66,7c102.8-30.83,248.87,50.48,263.48,54.77"/></g></g></svg>';
				break;
			case 'brick-wall':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 470.31 23.83"><title>Asset 1</title><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g id="Layer_1-2-2" data-name="Layer 1-2"><path d="M470.31,0V23.83l-58.82-1.21V0H356.72V23.23H293.47L292.74,0H230.22l.49,23.23H164.79L164.55,0H99V23.23H37.2L37.56,0H0V23.23"/></g></g></g></svg>';
				break;
			case 'fluid':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M494.4,94.5c7.6-16.8-45-90.9-96.7-87.8c-46.6,2.8-59.5,66.4-104.5,62.8c-31-2.5-34.5-33.5-64.9-34.1c-44.6-0.9-65.7,65.1-92.1,55.9c-23.7-8.3-14.5-64.3-41-77.7C66.2-1.1,8.8,43.1,10.6,78.5c1.9,37,69,73.7,126.1,66c55.6-7.5,63.8-51.9,111.9-49c51,3.1,69.9,54.8,104,41.5c29.9-11.6,30-57.2,57.1-59.1c18.6-1.3,27.4,19.4,60.3,21.3C480.9,99.9,491.7,100.5,494.4,94.5z"></path></svg>';
				break;
			case 'bracket-1':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M30.5,3.7c0,0-22.2,0.5-26.2,0.5"/><path d="M4.1,7.6c0,0-2,134.2-0.3,137.2s24.6,1.3,26.6,0.3"/><path d="M467.9,4.7c0,0,23.1-2.4,24.7,0.3c1.7,2.7,2.2,133.6,1.9,136.6"/><path d="M494.3,144.9c0,0-20.7,1-24,0"/></svg>';
				break;
			case 'bracket-2':
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M494.3,31.2c0,0-1.7-22.2-1.7-26.2"/><path d="M485,5.4c0,0-466.2-6.2-475.3-1C4,7.6,4.6,26.9,6.6,30.7"/><path d="M489.7,118.6c0,0,4.4,21.6-0.9,23.1c-9.3,1.7-463.8,2.4-474.2,2.1"/><path d="M7.2,144.7c0,0-1-19.1,0.1-24"/></svg>';
				break;
			default:
				$svgprint =
					'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M7.7,145.6C109,125,299.9,116.2,401,121.3c42.1,2.2,87.6,11.8,87.3,25.7"></path></svg>';
				break;
		}


		$this->dipi_apply_css($render_slug);

		$config = [
			'animation_start' => $highlight_animation_start,
			'animation_start_viewport' => $highlight_animation_start_viewport,
			'animation_delay' => $highlight_animation_delay,
			'animation_duration' => $highlight_animation_duration,
			'delay_after_animation' => $highlight_delay_after_animation,
      		'repeat_mode' => $highlight_animation_repeat_mode,
			'count_mode' => $highlight_animation_count_mode,
			'animation_repeat_counts' => $highlight_animation_repeat_counts,
			'reverse_animation'  => $reverse_animation,
			'id' => self::get_module_order_class($render_slug)."_wrapper"
    ];

		$module_custom_classes = '';

		return sprintf( 
			'<%4$s class="dipi-highlight-text-wrapper" data-config="%6$s">
					%1$s<span class="dipi-text-highlight-wrapper %6$s">%3$s<span class="dipi-text-highlight-svg">%5$s</span></span>%2$s
			</%4$s>', 
			$text_prefix,
			$text_suffix,
			$text_highlight,
			$textWrapperTag,
			$svgprint, // #5
			esc_attr(htmlspecialchars(json_encode($config), ENT_QUOTES, 'UTF-8'))
		);
	}

}

new DIPI_TextHighlighter;
