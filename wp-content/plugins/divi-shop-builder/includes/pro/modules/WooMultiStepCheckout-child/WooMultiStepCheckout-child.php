<?php
class DSWCP_WooMultiStepCheckout_child extends ET_Builder_Module {
	static $MODULES;
	public $slug       = 'ags_woo_multi_step_checkout_child';
	public $vb_support = 'on';

	function init() {
		$this->name             = esc_html__('Checkout Step', 'divi-shop-builder');
		$this->type             = 'child';
		$this->child_title_var  = 'label';
		$this->main_css_element = '%%order_class%%';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(),
			),
			'advanced' => array(
				'toggles' => array(),
			),
		);

		$this->custom_css_fields = array(
			'filter_title'       => array(
				'label'    => esc_html__('Filter Title', 'divi-shop-builder'),
				'selector' => "{$this->main_css_element} ags-wc-filters-section-title",
			),
			'filter_title_arrow' => array(
				'label'    => esc_html__('Filter Toggle Arrow', 'divi-shop-builder'),
				'selector' => "{$this->main_css_element} .ags-wc-filters-section-toggle:after",
			),
			'filter_inner'       => array(
				'label'    => esc_html__('Filter Inner', 'divi-shop-builder'),
				'selector' => "{$this->main_css_element} .ags-wc-filters-section-inner",
			),
		);

		self::$MODULES = array(
			'ags_woo_checkout_billing_info' => esc_html__('Checkout Billing Info', 'divi-shop-builder'),
			'ags_woo_checkout_shipping_info' => esc_html__('Checkout Shipping Info', 'divi-shop-builder'),
			'ags_woo_checkout_order_review' => esc_html__('Checkout Order Review', 'divi-shop-builder'),
		);
		
		add_filter('et_module_process_display_conditions', [$this, 'maybeRegisterCheckoutStep'], 99, 3);
	}
	
	function get_fields() {
		$libraryLayouts = get_posts([
			'post_type' => 'et_pb_layout',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'ignore_sticky_posts' => true,
			'orderby' => 'title',
			'order' => 'ASC',
			'fields' => 'ids',
			'tax_query' => [
				[
					'taxonomy' => 'layout_type',
					'field' => 'slug',
					'terms' => 'section'
				]
			]
		]);
		
		$fields = array(
			'label'          => array(
				'label'            => esc_html__('Step Label', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Text entered here may appear in the checkout navigation.', 'divi-shop-builder'),
				'default'          => __('Step 1', 'divi-shop-builder'),
			),
			'slug'          => array(
				'label'            => esc_html__('Step Slug', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('Unique ID for this step that will be used for hash navigation. Should be lowercase, without spaces.', 'divi-shop-builder')
			),
			'enable_number' => [
				'label'           => esc_html__( 'Show Step Number', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Enable to show the step number on the tab for this step.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Show', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Hide', 'divi-shop-builder' ),
				),
				'option_category' => 'basic_option',
				'default'         => 'on',
			],
			'number_format'          => array(
				'label'            => esc_html__('Step Number Format', 'divi-shop-builder'),
				'type'             => 'text',
				'option_category'  => 'basic_option',
				'description'      => esc_html__('The format to use to display the number. %d is replaced with the number itself. For example, "%d" displays just the number, while "%d." displays the number followed by a period.', 'divi-shop-builder'),
				'default'          => esc_html__('%d', 'divi-shop-builder'),
				'show_if'         => [ 'enable_number' => 'on' ]
			),
			'tab_type' => [
				'label'           => esc_html__( 'Tab Display Type', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Choose how this tab should be displayed.', 'divi-shop-builder' ),
				'type'            => 'select',
				'options' 		  => array(
					'text' 	      => esc_html__( 'Text/Number Only', 'divi-shop-builder' ),
					'image'    => esc_html__( 'Image + Text/Number', 'divi-shop-builder' ),
					'icon' 	      => esc_html__( 'Icon + Text/Number', 'divi-shop-builder' ),
				),
				'option_category' => 'basic_option',
				'default'         => 'text',
			],
			'image'          => array(
				'label'           => esc_html__( 'Image', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Image to display on the tab for this step.', 'divi-shop-builder' ),
				'upload_button_text' => esc_attr__( 'Upload an image', 'divi-shop-builder' ),
				'choose_text'        => esc_attr__( 'Choose an Image', 'divi-shop-builder' ),
				'update_text'        => esc_attr__( 'Set As Image', 'divi-shop-builder' ),
				'type'            => 'upload',
				'option_category' => 'basic_option',
				'show_if'         => [ 'tab_type' => 'image' ]
			),
			'icon'          => array(
				'label'           => esc_html__( 'Icon', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Icon to display on the tab for this step.', 'divi-shop-builder' ),
				'type'            => 'select_icon',
				'option_category' => 'basic_option',
				'class'           => array( 'et-pb-font-icon' ),
				'show_if'         => [ 'tab_type' => 'icon' ]
			),
			'type'              => array(
				'label'            => esc_html__('Step Content', 'divi-shop-builder'),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => [
					'section' => esc_html__('A Section on this page containing a specified Divi Shop Builder module'),
					'layout' => esc_html__('A Section layout in the Divi Library'),
				],
				'description'      => esc_html__('Choose where the step content is sourced from.', 'divi-shop-builder'),
				'default'          => 'section'
			),
			'module'              => array(
				'label'            => esc_html__('Primary Module', 'divi-shop-builder'),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => self::$MODULES,
				'description'      => esc_html__('Choose the primary Divi Shop Builder in the Section for this step.', 'divi-shop-builder'),
				'default'          => key(self::$MODULES),
				'show_if'          => [
					'type' => 'section'
				]
			),
			'layout'              => array(
				'label'            => esc_html__('Library Layout', 'divi-shop-builder'),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => array_combine( $libraryLayouts, array_map('get_the_title', $libraryLayouts) ),
				'description'      => esc_html__('Choose the Divi Library layout for this step.', 'divi-shop-builder'),
				'default'          => 0,
				'show_if'          => [
					'type' => 'layout'
				]
			)
		);

		return $fields;
	}

	function get_advanced_fields_config() {
		return [];
	}

	private function apply_responsive($value, $selector, $css, $render_slug, $type, $default = null, $important = false) {

		$dstc_last_edited       = isset( $this->props[ $value . '_last_edited' ] ) ? $this->props[ $value . '_last_edited' ] : null;
		$dstc_responsive_active = et_pb_get_responsive_status($dstc_last_edited);

		switch ( $type ) {
			case 'custom_margin':

				$all_values = $this->props;
				$responsive = ET_Builder_Module_Helper_ResponsiveOptions::instance();

				// Responsive.
				$is_responsive = $responsive->is_responsive_enabled($all_values, $value);

				$margin_desktop = $responsive->get_any_value($all_values, $value);
				$margin_tablet  = $is_responsive ? $responsive->get_any_value($all_values, "{$value}_tablet") : '';
				$margin_phone   = $is_responsive ? $responsive->get_any_value($all_values, "{$value}_phone") : '';

				$styles = array(
					'desktop' => '' !== $margin_desktop ? rtrim(et_builder_get_element_style_css($margin_desktop, $css, $important)) : '',
					'tablet'  => '' !== $margin_tablet ? rtrim(et_builder_get_element_style_css($margin_tablet, $css, $important)) : '',
					'phone'   => '' !== $margin_phone ? rtrim(et_builder_get_element_style_css($margin_phone, $css, $important)) : '',
				);

				$responsive->declare_responsive_css($styles, $selector, $render_slug, $important);

				break;
			case 'alignment':
				$align        = esc_html($this->get_alignment());
				$align_tablet = esc_html($this->get_alignment('tablet'));
				$align_phone  = esc_html($this->get_alignment('phone'));

				// Responsive Image Alignment.
				// Set CSS properties and values for the image alignment.
				// 1. Text Align is necessary, just set it from current image alignment value.
				// 2. Margin {Side} is optional. Used to pull the image to right/left side.
				// 3. Margin Left and Right are optional. Used by Center to reset custom margin of point 2.
				$dstc_array = array(
					'desktop' => array(
						'text-align'    => $align,
						'margin-left'   => 'left' !== $align ? 'auto' : '',
						'margin-right'  => 'left' !== $align ? 'auto' : '',
						"margin-$align" => ! empty($align) && 'center' !== $align ? '0' : '',
					),
				);

				if ( ! empty($align_tablet) ) {
					$dstc_array['tablet'] = array(
						'text-align'           => $align_tablet,
						'margin-left'          => 'left' !== $align_tablet ? 'auto' : '',
						'margin-right'         => 'left' !== $align_tablet ? 'auto' : '',
						"margin-$align_tablet" => ! empty($align_tablet) && 'center' !== $align_tablet ? '0' : '',
					);
				}

				if ( ! empty($align_phone) ) {
					$dstc_array['phone'] = array(
						'text-align'          => $align_phone,
						'margin-left'         => 'left' !== $align_phone ? 'auto' : '',
						'margin-right'        => 'left' !== $align_phone ? 'auto' : '',
						"margin-$align_phone" => ! empty($align_phone) && 'center' !== $align_phone ? '0' : '',
					);
				}
				et_pb_responsive_options()->generate_responsive_css($dstc_array, $selector, $css, $render_slug, $important ? '!important' : '', $type);
				break;

			default:
				$re          = array('|', 'true', 'false');
				$dstc        = trim(str_replace($re, ' ', $this->props[ $value ]));
				$dstc_tablet = isset( $this->props[ $value . '_tablet' ] ) ? trim(str_replace($re, ' ', $this->props[ $value . '_tablet' ])) : '';
				$dstc_phone  = isset(  $this->props[ $value . '_phone' ] ) ? trim(str_replace($re, ' ', $this->props[ $value . '_phone' ])) : '';

				$dstc_array = array(
					'desktop' => esc_html($dstc),
					'tablet'  => $dstc_responsive_active ? esc_html($dstc_tablet) : '',
					'phone'   => $dstc_responsive_active ? esc_html($dstc_phone) : '',
				);
				et_pb_responsive_options()->generate_responsive_css($dstc_array, $selector, $css, $render_slug, $important ? '!important' : '', $type);
		}

	}

	private function css($render_slug) {
		$props = $this->props;
	}

	function render($attrs, $content = null, $render_slug = null) {
		$this->css($render_slug);
		
		if ($this->props['type'] == 'layout') {
			return
				'<div id="dswcp-checkout-section-'.esc_attr($this->props['slug']).'">'
				.do_shortcode('[et_pb_section global_module="'.((int) $this->props['layout']).'" /]')
				.'</div>';
		}
		
		return '<!-- DSWCP_PLACEHOLDER -->';
		
		
	}
	
	function maybeRegisterCheckoutStep($output, $unused, $module) {
		if ($module->slug == $this->slug) {
			global $dscwp_checkout_steps;

			if ($output) {
				$newStep = [
					'label' => $this->props['label'],
					'slug' => $this->props['slug'],
					'icon' => $this->props['tab_type'] == 'icon' ? $this->props['icon'] : null,
					'image' => $this->props['tab_type'] == 'image' ? $this->props['image'] : null,
					'number' => $this->props['enable_number'] == 'on' ? $this->props['number_format'] : null
				];
			}
			
			switch ($this->props['type']) {
				case 'section':
					$selector = '.et_pb_section:has(.'.$this->props['module'].'):first';
					if ($output) {
						$newStep['selector'] = $selector;
						$dscwp_checkout_steps[] = $newStep;
					} else {
						$dscwp_checkout_steps[] = [
							'selector' => $selector,
							'disable' => true
						];
					}
					break;
				case 'layout':
					if ($output) {
						$newStep['selector'] = '#dswcp-checkout-section-'.$this->props['slug'];
						$dscwp_checkout_steps[] = $newStep;
					}
					break;
			}
		}
		
		return $output == '<!-- DSWCP_PLACEHOLDER -->' ? '' : $output;
	}

}

new DSWCP_WooMultiStepCheckout_child();
