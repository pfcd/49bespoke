<?php
class DIPI_Timeline extends DIPI_Builder_Module {

	public $slug       = 'dipi_timeline';
	public $vb_support = 'on';

	// Module item's slug
	public $child_slug = 'dipi_timeline_item';

	protected $module_credits = array(
		'module_uri' => 'https://divi-pixel.com/modules/timeline',
        'author' => 'Divi Pixel',
        'author_uri' => 'https://divi-pixel.com',
	);

	public function init() 
	{
		$this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';
		$this->name = esc_html__( 'Pixel Timeline', 'dipi-timeline-module-for-divi' );
		$this->settings_modal_toggles = array(
			'general'    => array(
				'toggles' => array(
					'card_arrow_settings' => esc_html__('Card Arrow', 'dipi-divi-pixel'),
				),
			),      
			'advanced'   => array(
				'toggles' => array(
          'layout_settings' => esc_html__( 'Layout', 'dipi-divi-pixel' ),
          'ribbon_icon_settings' => esc_html__( 'Timeline Icon', 'dipi-divi-pixel' ),
          'timeline_line_settings' => esc_html__( 'Timeline Line', 'dipi-divi-pixel' ),
          'card_arrow_settings' => esc_html__( 'Card Arrow', 'dipi-divi-pixel' ),
          'animation_timeline_settings' => esc_html__( 'Animation Timeline', 'dipi-divi-pixel' ),
				),
			)
    );
    $this->advanced_fields = array(
      'borders'        => array(
        'default' => array(),
      ),
      'fonts' => false,
      'margin_padding' => array(
        'css' => array(
            'important' => 'all',
        ),
      ),
    );

		/**
		 * Filter generated module selector
		 *
		 * @param string $selector Generated selector.
		 * @param string $module   Module name.
		 *
		 * @return string Custom selector.
		 */
		add_filter( 'et_pb_set_style_selector', function ( $selector, $module ) {
			// Bail early if current module is not Timeline module.
			if ( 'dipi_timeline' !== $module && 'dipi_timeline_item' !== $module ) {
				return $selector;
			}
      $new_selector =
        str_replace(
          '#et-boc .et-l ', '',
          str_replace( 
            '.et-db #et-boc .et-l ', '', 
            str_replace( 'body #page-container ', '', $selector ) 
          )
        );
          
			return ".et-db #et-boc .et-l ". str_replace(
        ',', ', .et-db #et-boc .et-l ',
        $new_selector). ", $new_selector";
		}, 10, 2 ); 
	}

	public function get_fields() {
    $et_accent_color = et_builder_accent_color();
		$start_position = array();
		$start_position['left'] = esc_html__('Left', 'dipi-divi-pixel');
		$start_position['right'] = esc_html__('Right', 'dipi-divi-pixel');

		return array(
      'show_card_arrow'  => array(
				'label'            => esc_html__( 'Show Card Arrow', 'dipi-divi-pixel' ),
				'description'      => esc_html__( 'Show Card Arrow', 'dipi-divi-pixel' ),
				'type'             => 'yes_no_button',
				'options'          => array(
					'off' => esc_html__('No', 'dipi-divi-pixel'),
					'on'  => esc_html__('Yes', 'dipi-divi-pixel'),
				),
				'toggle_slug'      => 'card_arrow_settings',
				'default_on_front' => 'on',
      ),
			'layout'      => array(
				'label'            => esc_html__( 'Layout', 'dipi-divi-pixel' ),
				'type'             => 'select',
				'option_category'  => 'layout',
				'options'          => array(
          'left'           => esc_html__( 'Left', 'dipi-divi-pixel' ),
          'right'          => esc_html__( 'Right', 'dipi-divi-pixel' ),
          'mixed'          => esc_html__( 'Mixed', 'dipi-divi-pixel' )
        ),
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'layout_settings',
				'description'      => esc_html__( 'Layout', 'dipi-divi-pixel' ),
        'default_on_front' => 'mixed',
        'default_tablet' => 'right',
        'default_phone' => 'right',
        'default'        => 'mixed', 
				'responsive'      => true,              
        'mobile_options'   => true,
				'hover'           => 'tabs',        
      ),      
			'start_position'      => array(
				'label'            => esc_html__( 'Start Position', 'dipi-divi-pixel' ),
				'type'             => 'select',
				'option_category'  => 'layout',
				'options'          => $start_position,
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'layout_settings',
				'description'      => esc_html__( 'Start position of first timeline item', 'dipi-divi-pixel' ),
				'default_on_front' => 'left',
        'mobile_options'   => false,
        'depends_show_if'  => 'mixed',
        'depends_on'       => array(
          'layout',
        ),
      ),
      'line_area_size'                  => array(
				'label'           => esc_html__( 'Line Area Size ', 'dipi-divi-pixel' ),
				'description'     => esc_html__( 'Adjust the size of the line area.', 'dipi-divi-pixel' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'timeline_line_settings',
				'mobile_options'  => true,
				'sticky'          => true,
				'validate_unit'   => true,
				'default'         => '60px',
				'default_unit'    => 'px',
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '1024',
					'step' => '1',
				),
				'responsive'      => true,
				'hover'           => 'tabs',
      ),
      'timeline_line_width' => array(
				'label'            => esc_html__( 'Default Line Width', 'dipi-divi-pixel' ),
				'description'      => esc_html__( 'Increasing the width of the default line will increase its size/thickness.', 'dipi-divi-pixel' ),
				'type'             => 'range',
				'option_category'  => 'configuration',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'timeline_line_settings',
				'default'          => '2px',
				'default_unit'     => 'px',
				'default_on_front' => '2px',
				'allowed_units'    => array( 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'range_settings'   => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'sticky'           => true,
				'hover'            => 'tabs',
      ),
      'timeline_line_style'    => array(
				'label'           => esc_html__( 'Default Line Style', 'dipi-divi-pixel' ),
				'description'     => esc_html__( 'Select the shape of the timeline line.', 'dipi-divi-pixel' ),
				'type'            => 'select',
				'option_category' => 'layout',
				'options'         => et_builder_get_border_styles(),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'timeline_line_settings',
				'default'         => 'solid',
        'hover'           => 'tabs',
			),
      'timeline_line_color' => array(
				'default'         => $et_accent_color,
				'label'           => esc_html__( 'Default Line Color', 'dipi-divi-pixel' ),
				'type'            => 'color-alpha',
				'description'     => esc_html__( 'Here you can define a custom color for the default line.', 'dipi-divi-pixel' ),
				'tab_slug'        => 'advanced',
        'toggle_slug'     => 'timeline_line_settings',
        'default'         => '#F2F3F3',
				'hover'           => 'tabs',
				'sticky'          => true,
      ),
      'use_active_line'  => array(
				'label'            => esc_html__( 'Use Active Line', 'dipi-divi-pixel' ),
				'description'      => esc_html__( 'Use active line which will be animated while scrolling.', 'dipi-divi-pixel' ),
				'type'             => 'yes_no_button',
				'options'          => array(
					'off' => esc_html__('No', 'dipi-divi-pixel'),
					'on'  => esc_html__('Yes', 'dipi-divi-pixel'),
				),
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'timeline_line_settings',
				'default_on_front' => 'on',
      ),
      'timeline_active_line_width' => array(
				'label'            => esc_html__( 'Active Line Width', 'dipi-divi-pixel' ),
				'description'      => esc_html__( 'Increasing the width of the active line will increase its size/thickness.', 'dipi-divi-pixel' ),
				'type'             => 'range',
        'option_category'  => 'configuration',
        'show_if'          => array(
          'use_active_line' => 'on'
        ),
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'timeline_line_settings',
				'default'          => '2px',
				'default_unit'     => 'px',
				'default_on_front' => '2px',
				'allowed_units'    => array( 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'range_settings'   => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'sticky'           => true,
				'hover'            => 'tabs',
      ),
      'timeline_active_line_style'    => array(
				'label'           => esc_html__( 'Active Line Style', 'dipi-divi-pixel' ),
				'description'     => esc_html__( 'Select the shape of the active line.', 'dipi-divi-pixel' ),
				'type'            => 'select',
				'option_category' => 'layout',
				'options'         => et_builder_get_border_styles(),
        'show_if'          => array(
          'use_active_line' => 'on'
        ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'timeline_line_settings',
				'default'         => 'solid',
        'hover'           => 'tabs',
			),
      'timeline_active_line_color' => array(
				'default'         => $et_accent_color,
				'label'           => esc_html__( 'Active Line Color', 'dipi-divi-pixel' ),
				'type'            => 'color-alpha',
				'description'     => esc_html__( 'Here you can define a custom color for the active line.', 'dipi-divi-pixel' ),
        'show_if'          => array(
          'use_active_line' => 'on'
        ),
				'tab_slug'        => 'advanced',
        'toggle_slug'     => 'timeline_line_settings',
        'default'         => '#2C3D49',
				'hover'           => 'tabs',
				'sticky'          => true,
      ),
      'card_arrow_size' => array(
				'label'            => esc_html__( 'Card Arrow Size', 'dipi-divi-pixel' ),
				'description'      => esc_html__( 'Card Arrow Size', 'dipi-divi-pixel' ),
				'type'             => 'range',
				'option_category'  => 'configuration',
				'tab_slug'         => 'advanced',
				'toggle_slug'      => 'card_arrow_settings',
				'default'          => '12px',
				'default_unit'     => '12x',
				'default_on_front' => '12px',
				'allowed_units'    => array( 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'range_settings'   => array(
					'min'  => '0',
					'max'  => '500',
					'step' => '1',
				),
				'mobile_options'   => true,
				'sticky'           => true,
        'hover'            => 'tabs',
        'show_if'          => array(
          'show_card_arrow' => 'on'
        ),
      ),
      'card_arrow_color' => array(
				'default'         => $et_accent_color,
				'label'           => esc_html__( 'Card Arrow Color', 'dipi-divi-pixel' ),
				'type'            => 'color-alpha',
				'description'     => esc_html__( 'Here you can define a custom color for card arrow.', 'dipi-divi-pixel' ),
				'tab_slug'        => 'advanced',
        'toggle_slug'     => 'card_arrow_settings',
        'default'         => '#F2F3F3',
				'hover'           => 'tabs',
				'sticky'          => true,
        'show_if'          => array(
          'show_card_arrow' => 'on'
        ),
      ),
		);
	}
  public function get_custom_style($slug_value, $type, $important) {
		return  sprintf('%1$s: %2$s%3$s;', $type, $slug_value, $important? ' !important' : '');
	}
	public function get_changed_prop_value($slug, $conv_matrix) {
		if(array_key_exists($this->props[$slug], $conv_matrix))
			$this->props[$slug] =  $conv_matrix[$this->props[$slug]];
  }
  
  public function apply_custom_style_for_phone(
		$function_name,
		$slug,
		$type,
		$class,
		$important = false,
		$zoom = '',
    $unit='',
    $wrap_func = '' /* traslate, clac ... */
    )
	{
		$slug_value_responsive_active = isset($this->props[$slug."_last_edited"]) ? et_pb_get_responsive_status($this->props[$slug."_last_edited"]) : false;
		$slug_value = (isset($this->props[$slug])) ? $this->props[$slug] : '';
		$slug_value_tablet = ($slug_value_responsive_active && isset($this->props[$slug."_tablet"])) ? $this->props[$slug."_tablet"] : $slug_value;
    $slug_value_phone = ($slug_value_responsive_active && isset($this->props[$slug."_phone"])) ? $this->props[$slug."_phone"]: $slug_value_tablet;
    
		if ($zoom === '') {
			$slug_value = $slug_value .$unit;
			$slug_value_tablet = $slug_value_tablet.$unit;
			$slug_value_phone = $slug_value_phone.$unit;
		} else {
			$slug_value = ((float)$slug_value * $zoom) .$unit;
			$slug_value_tablet = ((float)$slug_value_tablet * $zoom).$unit;
			$slug_value_phone = ((float)$slug_value_phone * $zoom).$unit;
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
				'declaration' => $this->get_custom_style($slug_value_phone, $type, $important),
				'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
			));
		}
  }
  
  public function apply_custom_style_for_tablet(
		$function_name,
		$slug,
		$type,
		$class,
		$important = false,
		$zoom = '',
    $unit='',
    $wrap_func = '' /* traslate, clac ... */
    )
	{
		$slug_value_responsive_active = isset($this->props[$slug."_last_edited"]) ? et_pb_get_responsive_status($this->props[$slug."_last_edited"]) : false;
		$slug_value = (isset($this->props[$slug])) ? $this->props[$slug] : '';
		$slug_value_tablet = ($slug_value_responsive_active && isset($this->props[$slug."_tablet"])) ? $this->props[$slug."_tablet"] : $slug_value;
    $slug_value_phone = ($slug_value_responsive_active && isset($this->props[$slug."_phone"])) ? $this->props[$slug."_phone"]: $slug_value_tablet;
    
		if ($zoom === '') {
			$slug_value = $slug_value .$unit;
			$slug_value_tablet = $slug_value_tablet.$unit;
			$slug_value_phone = $slug_value_phone.$unit;
		} else {
			$slug_value = ((float)$slug_value * $zoom) .$unit;
			$slug_value_tablet = ((float)$slug_value_tablet * $zoom).$unit;
			$slug_value_phone = ((float)$slug_value_phone * $zoom).$unit;
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
      'declaration' => $this->get_custom_style($slug_value_tablet, $type, $important),
      'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
    ));
    }
  }
  
  public function apply_custom_style_for_desktop(
		$function_name,
		$slug,
		$type,
		$class,
		$important = false,
		$zoom = '',
    $unit='',
    $wrap_func = '' /* traslate, clac ... */
    )
	{
    
    $slug_value_responsive_active = isset($this->props[$slug."_last_edited"]) ? et_pb_get_responsive_status($this->props[$slug."_last_edited"]) : false;
		$slug_value = (isset($this->props[$slug])) ? $this->props[$slug] : '';
		$slug_value_tablet = ($slug_value_responsive_active && isset($this->props[$slug."_tablet"])) ? $this->props[$slug."_tablet"] : $slug_value;
    $slug_value_phone = ($slug_value_responsive_active && isset($this->props[$slug."_phone"])) ? $this->props[$slug."_phone"]: $slug_value_tablet;
    
		if ($zoom === '') {
			$slug_value = $slug_value .$unit;
			$slug_value_tablet = $slug_value_tablet.$unit;
			$slug_value_phone = $slug_value_phone.$unit;
		} else {
			$slug_value = ((float)$slug_value * $zoom) .$unit;
			$slug_value_tablet = ((float)$slug_value_tablet * $zoom).$unit;
			$slug_value_phone = ((float)$slug_value_phone * $zoom).$unit;
		}
		if ($wrap_func !== '') {
      $slug_value = "$wrap_func($slug_value)";
      $slug_value_tablet = "$wrap_func($slug_value_tablet)";
      $slug_value_phone = "$wrap_func($slug_value_phone)";
    }

		if (isset($slug_value) && !empty($slug_value)) {
			ET_Builder_Element::set_style($function_name, array(
				'selector' => $class,
				'declaration' => $this->get_custom_style($slug_value, $type, $important),
			));
		}
  }

	public function apply_custom_style(
		$function_name,
		$slug,
		$type,
		$class,
		$important = false,
		$zoom = '',
    $unit='',
    $wrap_func = '' /* traslate, clac ... */
    )
	{
		$slug_value_responsive_active = isset($this->props[$slug."_last_edited"]) ? et_pb_get_responsive_status($this->props[$slug."_last_edited"]) : false;
		$slug_value = (isset($this->props[$slug])) ? $this->props[$slug] : '';
		$slug_value_tablet = ($slug_value_responsive_active && isset($this->props[$slug."_tablet"])) ? $this->props[$slug."_tablet"] : $slug_value;
    $slug_value_phone = ($slug_value_responsive_active && isset($this->props[$slug."_phone"])) ? $this->props[$slug."_phone"]: $slug_value_tablet;
    
		if ($zoom === '') {
			$slug_value = $slug_value .$unit;
			$slug_value_tablet = $slug_value_tablet.$unit;
			$slug_value_phone = $slug_value_phone.$unit;
		} else {
			$slug_value = ((float)$slug_value * $zoom) .$unit;
			$slug_value_tablet = ((float)$slug_value_tablet * $zoom).$unit;
			$slug_value_phone = ((float)$slug_value_phone * $zoom).$unit;
		}
		if ($wrap_func !== '') {
      $slug_value = "$wrap_func($slug_value)";
      $slug_value_tablet = "$wrap_func($slug_value_tablet)";
      $slug_value_phone = "$wrap_func($slug_value_phone)";
    }

		if (isset($slug_value) && !empty($slug_value)) {
			ET_Builder_Element::set_style($function_name, array(
				'selector' => $class,
				'declaration' => $this->get_custom_style($slug_value, $type, $important),
			));
		}

		if (isset($slug_value_tablet)
			&& !empty($slug_value_tablet)
			&& $slug_value_responsive_active) {
			ET_Builder_Element::set_style($function_name, array(
				'selector' => $class,
				'declaration' => $this->get_custom_style($slug_value_tablet, $type, $important),
				'media_query' => ET_Builder_Element::get_media_query('max_width_980'),
			));
		}

		if (isset($slug_value_phone)
			&& !empty($slug_value_phone)
			&& $slug_value_responsive_active) {
			ET_Builder_Element::set_style($function_name, array(
				'selector' => $class,
				'declaration' => $this->get_custom_style($slug_value_phone, $type, $important),
				'media_query' => ET_Builder_Element::get_media_query('max_width_767'),
			));
		}
	}
	public function apply_custom_margin_padding($function_name, $slug, $type, $class, $important = true)
	{
		$slug_value_responsive_active = isset($this->props[$slug."_last_edited"]) ? et_pb_get_responsive_status($this->props[$slug."_last_edited"]) : false;
		$slug_value = (isset($this->props[$slug])) ? $this->props[$slug] : '';
		$slug_value_tablet = ($slug_value_responsive_active && isset($this->props[$slug."_tablet"])) ? $this->props[$slug."_tablet"] : $slug_value;
    $slug_value_phone = ($slug_value_responsive_active && isset($this->props[$slug."_phone"])) ? $this->props[$slug."_phone"]: $slug_value_tablet;
  
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
  
  public function get_transition_fields_css_props() {
    $fields               = parent::get_transition_fields_css_props();
    $fields['timeline_line_width'] = array( 'border-width' => '%%order_class%% .dipi-timeline-line' );
    $fields['timeline_line_color'] = array( 'border-color' => '%%order_class%% .dipi-timeline-line' );
    $fields['timeline_line_style'] = array( 'border-style' => '%%order_class%% .dipi-timeline-line' );
    
    return $fields;
  }
	public function render( $attrs, $content, $render_slug ) {
    wp_enqueue_script('dipi_timeline_public');
    wp_enqueue_style('dipi_animate');
    $layout                            = $this->props['layout'];
    $layout_values                     = et_pb_responsive_options()->get_property_values( $this->props, 'layout' );
    $start_position                    = $this->props['start_position'];
    $use_active_line				           = $this->props['use_active_line'];
    $line_area_size                    = $this->props['line_area_size'];
    $line_area_size_values             = et_pb_responsive_options()->get_property_values( $this->props, 'line_area_size' ); 
    $show_card_arrow                   = $this->props['show_card_arrow'];
    $timline_line_html =  '<div class="dipi-timeline-line"></div>';
    if ($use_active_line == "on") {
      $timline_line_html .='<div class="dipi-timeline-line__active"></div>';
    }
    
	  $layout_tablet        = isset( $layout_values['tablet'] ) ? $layout_values['tablet'] : '';
    $layout_phone         = isset( $layout_values['phone'] ) ? $layout_values['phone'] : '';
    
    if ( is_rtl() && 'left' === $layout ) {
			$layout = 'right';
		}

		if ( is_rtl() && 'left' === $layout_tablet ) {
			$layout_tablet = 'right';
		}

		if ( is_rtl() && 'left' === $layout_phone ) {
			$layout_phone = 'right';
    }

    $module_custom_classes = 'dipi_timeline_custom_classes';
    $module_custom_classes .= $this->get_text_orientation_classname();
		$module_custom_classes .= sprintf( ' dipi_timeline_layout_%1$s', esc_attr( $layout ) );

    if ( ! empty( $layout_tablet ) ) {
			$module_custom_classes .=  " dipi_timeline_layout_{$layout_tablet}_tablet" ;
		} else {
      $module_custom_classes .=  " dipi_timeline_layout_right_tablet" ;
    }

		if ( ! empty( $layout_phone ) ) {
			$module_custom_classes .=  " dipi_timeline_layout_{$layout_phone}_phone" ;
		} else {
      $module_custom_classes .=  " dipi_timeline_layout_right_phone" ;
    }
    
    if ( ! empty( $start_position ) ) {
			$module_custom_classes .=  " startpos-{$start_position}" ;
    }
    
    if ($show_card_arrow == 'on') {
      $module_custom_classes .= " dipi_timeline_show-card-arrow" ;
    }
    $this->generate_styles(
      array(
        'base_attr_name' => 'line_area_size',
        'selector'       => '%%order_class%% .dipi_timeline_item .ribbon-icon-wrap, %%order_class%% .dipi_timeline_layout_right .dipi_timeline_item .ribbon-icon-wrap, %%order_class%%.dipi_timeline .dipi_timeline_layout_left .dipi_timeline_item .ribbon-icon-wrap',
        'css_property'   => 'width',
        'render_slug'    => $render_slug,
        'type'           => 'range',
      )
    );
    $this->generate_styles(
      array(
        'base_attr_name' => 'line_area_size',
        'selector'       => '%%order_class%% .dipi_timeline_item .ribbon-icon-wrap, %%order_class%% .dipi_timeline_layout_right .dipi_timeline_item .ribbon-icon-wrap, %%order_class%%.dipi_timeline .dipi_timeline_layout_left .dipi_timeline_item .ribbon-icon-wrap',
        'css_property'   => 'max-width',
        'render_slug'    => $render_slug,
        'type'           => 'range',
        'important'     => true
      )
    );

    $this->apply_custom_style_for_desktop(
      $this->slug,
      'line_area_size',
      'left',
      '%%order_class%% .dipi_timeline_layout_right .dipi-timeline-line__active,
      %%order_class%% .dipi_timeline_layout_right .dipi-timeline-line
      ',
      false,
      0.5,
      'px'
	  );
    $this->apply_custom_style_for_tablet(
      $this->slug,
      'line_area_size',
      'left',
      '%%order_class%%.dipi_timeline .dipi_timeline_layout_right_tablet .dipi_timeline_container .dipi-timeline-line__active,
      %%order_class%%.dipi_timeline .dipi_timeline_layout_right_tablet .dipi_timeline_container .dipi-timeline-line
      ',
      false,
      0.5,
      'px'
      );
    $this->apply_custom_style_for_phone(
      $this->slug,
      'line_area_size',
      'left',
      '%%order_class%%.et_pb_module.dipi_timeline .dipi_timeline_layout_right_phone .dipi_timeline_container .dipi-timeline-line__active,
      %%order_class%%.et_pb_module.dipi_timeline .dipi_timeline_layout_right_phone .dipi_timeline_container .dipi-timeline-line
      ',
      false,
      0.5,
      'px'
      );
    
    $this->apply_custom_style(
      $this->slug,
      'line_area_size',
      'right',
      '%%order_class%% .dipi_timeline_layout_left .dipi-timeline-line__active,
      %%order_class%% .dipi_timeline_layout_left .dipi-timeline-line',
      false,
      0.5,
      'px'
    );
    $this->apply_custom_style_for_tablet(
      $this->slug,
      'line_area_size',
      'right',
      '%%order_class%%.dipi_timeline .dipi_timeline_layout_left_tablet .dipi_timeline_container .dipi-timeline-line__active,
      %%order_class%%.dipi_timeline .dipi_timeline_layout_left_tablet .dipi_timeline_container .dipi-timeline-line',
      false,
      0.5,
      'px'
      );
    $this->apply_custom_style_for_phone(
      $this->slug,
      'line_area_size',
      'right',
      '%%order_class%%.et_pb_module.dipi_timeline .dipi_timeline_layout_left_phone .dipi_timeline_container .dipi-timeline-line__active,
      %%order_class%%.et_pb_module.dipi_timeline .dipi_timeline_layout_left_phone .dipi_timeline_container .dipi-timeline-line',
      false,
      0.5,
      'px'
    );

    $this->apply_custom_style_for_desktop(
      $this->slug,
      'timeline_line_width',
      'transform',
      '%%order_class%% .dipi_timeline_layout_left .dipi-timeline-line
      ',
      false,
      0.5,
      'px',
      'translateX'
	);
	$this->apply_custom_style_for_tablet(
		$this->slug,
		'timeline_line_width',
		'transform',
		'%%order_class%%.dipi_timeline .dipi_timeline_layout_left_tablet .dipi-timeline-line
		',
		false,
		0.5,
		'px',
		'translateX'
	  );
	$this->apply_custom_style_for_phone(
		$this->slug,
		'timeline_line_width',
		'transform',
		'%%order_class%%.dipi_timeline .dipi_timeline_layout_left_phone .dipi_timeline_container .dipi-timeline-line
		',
		false,
		0.5,
		'px',
		'translateX'
	);

    $this->generate_styles(
			array(
				'base_attr_name'                  => 'timeline_line_width',
				'selector'                        => '%%order_class%% .dipi-timeline-line',
				'css_property'                    => 'border-width',
				'render_slug'                     => $render_slug,
				'type'                            => 'range',
			)
    );
    
    $this->generate_styles(
			array(
				'base_attr_name'                  => 'timeline_line_color',
				'selector'                        => '%%order_class%% .dipi-timeline-line',
				'css_property'                    => 'border-color',
				'render_slug'                     => $render_slug,
				'type'                            => 'color',
			)
    );

    $this->generate_styles(
			array(
				'base_attr_name'                  => 'timeline_line_style',
				'selector'                        => '%%order_class%% .dipi-timeline-line',
				'css_property'                    => 'border-style',
				'render_slug'                     => $render_slug,
				'type'                            => 'select',
			)
    );
    /* Active line */
    $this->generate_styles(
			array(
				'base_attr_name'                  => 'timeline_active_line_width',
				'selector'                        => '%%order_class%% .dipi-timeline-line__active',
				'css_property'                    => 'border-width',
				'render_slug'                     => $render_slug,
				'type'                            => 'range',
			)
    );
    
    $this->generate_styles(
			array(
				'base_attr_name'                  => 'timeline_active_line_color',
				'selector'                        => '%%order_class%% .dipi-timeline-line__active',
				'css_property'                    => 'border-color',
				'render_slug'                     => $render_slug,
				'type'                            => 'color',
			)
    );

    $this->generate_styles(
			array(
				'base_attr_name'                  => 'timeline_active_line_style',
				'selector'                        => '%%order_class%% .dipi-timeline-line__active',
				'css_property'                    => 'border-style',
				'render_slug'                     => $render_slug,
				'type'                            => 'select',
			)
    );

    $this->apply_custom_style_for_desktop(
      $this->slug,
      'timeline_active_line_width',
      'transform',
      '%%order_class%% .dipi_timeline_layout_left .dipi-timeline-line__active
      ',
      false,
      0.5,
      'px',
      'translateX'
	  );
	
    $this->apply_custom_style_for_tablet(
      $this->slug,
      'timeline_active_line_width',
      'transform',
      '%%order_class%%.dipi_timeline .dipi_timeline_layout_left_tablet .dipi-timeline-line__active
      ',
      false,
      0.5,
      'px',
      'translateX'
	  );

    $this->apply_custom_style_for_phone(
      $this->slug,
      'timeline_active_line_width',
      'transform',
      '%%order_class%%.dipi_timeline .dipi_timeline_layout_left_phone .dipi_timeline_container .dipi-timeline-line__active
      ',
      false,
      0.5,
      'px',
      'translateX'
    );

    $this->apply_custom_style_for_desktop(
      $this->slug,
      'timeline_line_width',
      'transform',
      '%%order_class%% .dipi_timeline_layout_right .dipi-timeline-line
      ',
      false,
      -0.5,
      'px',
      'translateX'
    );

    $this->apply_custom_style_for_tablet(
      $this->slug,
      'timeline_line_width',
      'transform',
      '%%order_class%%.dipi_timeline .dipi_timeline_layout_right_tablet .dipi-timeline-line
      ',
      false,
      -0.5,
      'px',
      'translateX'
    );
    $this->apply_custom_style_for_phone(
      $this->slug,
      'timeline_line_width',
      'transform',
      '%%order_class%%.dipi_timeline .dipi_timeline_layout_right_phone .dipi_timeline_container .dipi-timeline-line
      ',
      false,
      -0.5,
      'px',
      'translateX'
    );

    $this->apply_custom_style_for_desktop(
      $this->slug,
      'timeline_active_line_width',
      'transform',
      '%%order_class%% .dipi_timeline_layout_right .dipi-timeline-line__active
      ',
      false,
      -0.5,
      'px',
      'translateX'
	  );

    $this->apply_custom_style_for_tablet(
      $this->slug,
      'timeline_active_line_width',
      'transform',
      '%%order_class%%.dipi_timeline .dipi_timeline_layout_right_tablet .dipi-timeline-line__active
      ',
      false,
      -0.5,
      'px',
      'translateX'
	  );
    $this->apply_custom_style_for_phone(
      $this->slug,
      'timeline_active_line_width',
      'transform',
      '%%order_class%%.dipi_timeline .dipi_timeline_layout_right_phone .dipi_timeline_container .dipi-timeline-line__active
      ',
      false,
      -0.5,
      'px',
      'translateX'
	  );
    /* Card Arrow */
    $this->generate_styles(
			array(
				'base_attr_name'                  => 'card_arrow_color',
				'selector'                        => '%%order_class%% .dipi_timeline_item_card-wrap:after',
				'css_property'                    => 'border-right-color',
				'render_slug'                     => $render_slug,
				'type'                            => 'color',
			)
    );
    $this->generate_styles(
			array(
				'base_attr_name'                  => 'card_arrow_color',
				'selector'                        => '%%order_class%% .dipi_timeline_item_card-wrap:after',
				'css_property'                    => 'border-left-color',
				'render_slug'                     => $render_slug,
				'type'                            => 'color',
			)
    );
    $this->generate_styles(
			array(
				'base_attr_name'                  => 'card_arrow_size',
				'selector'                        => '%%order_class%% .dipi_timeline_item_card-wrap:after',
				'css_property'                    => 'border-width',
				'render_slug'                     => $render_slug,
        'type'                            => 'range',
        'important'                       => true
			)
    );
    $this->apply_custom_style_for_desktop(
      $this->slug,
      'card_arrow_size',
      'left',
      '%%order_class%% .dipi_timeline_layout_right .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after,
       %%order_class%% .dipi_timeline_layout_mixed.startpos-right .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item:nth-child(odd) .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after,
       %%order_class%% .dipi_timeline_layout_mixed.startpos-left .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item:nth-child(even) .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after
      ',
      false,
      -1,
      'px'
	  );

    $this->apply_custom_style_for_tablet(
      $this->slug,
      'card_arrow_size',
      'left',
      '%%order_class%%.dipi_timeline .dipi_timeline_layout_right_tablet .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item:nth-child(odd) .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after,
       %%order_class%%.dipi_timeline .dipi_timeline_layout_right_tablet .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item:nth-child(even) .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after,
       %%order_class%% .dipi_timeline_layout_mixed_tablet.startpos-right .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item:nth-child(odd) .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after,
       %%order_class%% .dipi_timeline_layout_mixed_tablet.startpos-left .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item:nth-child(even) .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after
      ',
      false,
      -1,
      'px'
	  );
    $this->apply_custom_style_for_phone(
      $this->slug,
      'card_arrow_size',
      'left',
      '%%order_class%%.et_pb_module.dipi_timeline .dipi_timeline_layout_right_phone .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item:nth-child(odd) .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after,
       %%order_class%%.et_pb_module.dipi_timeline .dipi_timeline_layout_right_phone .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item:nth-child(even) .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after,
       %%order_class%%.et_pb_module .dipi_timeline_layout_mixed_phone.startpos-right .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item:nth-child(odd) .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after,
       %%order_class%%.et_pb_module .dipi_timeline_layout_mixed_phone.startpos-left .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item:nth-child(even) .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after
      ',
      false,
      -1,
      'px'
    );
    
    $this->apply_custom_style_for_desktop(
      $this->slug,
      'card_arrow_size',
      'right',
      '%%order_class%% .dipi_timeline_layout_left .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after,
       %%order_class%% .dipi_timeline_layout_mixed.startpos-right .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item:nth-child(even) .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after,
       %%order_class%% .dipi_timeline_layout_mixed.startpos-left .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item:nth-child(odd) .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after
      ',
      false,
      -1,
      'px'
	  );

    $this->apply_custom_style_for_tablet(
      $this->slug,
      'card_arrow_size',
      'right',
      '%%order_class%%.dipi_timeline .dipi_timeline_layout_left_tablet .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item:nth-child(even) .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after,
       %%order_class%%.dipi_timeline .dipi_timeline_layout_left_tablet .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item:nth-child(odd) .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after,
       %%order_class%% .dipi_timeline_layout_mixed_tablet.startpos-right .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item:nth-child(even) .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after,
       %%order_class%% .dipi_timeline_layout_mixed_tablet.startpos-left .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item:nth-child(odd) .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after
      ',
      false,
      -1,
      'px'
	  );
    $this->apply_custom_style_for_phone(
      $this->slug,
      'card_arrow_size',
      'right',
      '%%order_class%%.et_pb_module.dipi_timeline .dipi_timeline_layout_left_phone .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item:nth-child(even) .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after,
      %%order_class%%.et_pb_module.dipi_timeline .dipi_timeline_layout_left_phone .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item:nth-child(odd) .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after,
       %%order_class%%.et_pb_module .dipi_timeline_layout_mixed_phone.startpos-right .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item:nth-child(even) .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after,
       %%order_class%%.et_pb_module .dipi_timeline_layout_mixed_phone.startpos-left .dipi_timeline_container .dipi-timeline-items .dipi_timeline_item:nth-child(odd) .dipi_timeline_item_container .dipi_timeline_item_card-wrap:after
      ',
      false,
      -1,
      'px'
	  );
    //$this->wrapper_settings = array(
      // 'parallax_background'     => '',
      // 'video_background'        => '',
      // 'attrs'                   => array(),
      //  'inner_attrs'             => array(
      //  'class' => "dipi_timeline_container",
      //),
		//);
		return sprintf(
      '<div class="%3$s">
        <div class="dipi_timeline_container">
          <div class="dipi-timeline-items">%1$s</div>
          %2$s
        </div>
      </div>
      ',
      $this->props['content'],
      $timline_line_html,
      $module_custom_classes
		);
	}
}

new DIPI_Timeline;

