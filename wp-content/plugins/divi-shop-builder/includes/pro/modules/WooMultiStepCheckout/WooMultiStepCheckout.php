<?php

class DSWCP_WooMultiStepCheckout extends ET_Builder_Module {

	use DSWCP_Module;

	public $slug = 'ags_woo_multi_step_checkout';
	public $vb_support = 'on';
	public $child_slug = 'ags_woo_multi_step_checkout_child';
	protected $icon_path;

	/**
	 * Based on this array margin and padding fields will be added
	 * set 'toggle_slug' as a key
	 * Update also in  .jsx
	 *
	 */
	private static $margin_padding_elements = array(
		'tabs'           => array(
			'selector'        => '%%order_class%% .dswcp-checkout-steps > li',
			'sub_toggle'      => 'spacing',
			'default_padding' => '|||',
			'toggle_slug'     => 'tabs',
			'label_prefix' => 'Tab '
		),
		'active_tab'      => array(
			'selector'        => '%%order_class%% .dswcp-checkout-steps >  li.dswcp-checkout-step-active',
			'sub_toggle'      => 'spacing',
			'default_padding' => '|||',
			'label_prefix' => 'Active Tab '
		),
		'tab_link'      => array(
			'selector'        => '%%order_class%%.ags_woo_multi_step_checkout .dswcp-checkout-steps > li a',
			'sub_toggle'      => 'spacing',
			'default_padding' => '|||',
			'toggle_slug'     => 'tabs',
			'label_prefix' => 'Tab Link '
		),
		'image'          => array(
			'selector'        => '%%order_class%% .dswcp-checkout-steps >  li .dswcp-checkout-tab-image',
			'sub_toggle'      => 'spacing',
			'default_padding' => '|||'
		),
		'icon'           => array(
			'selector'        => '%%order_class%% .dswcp-checkout-steps >  li .dswcp-checkout-tab-icon',
			'sub_toggle'      => 'spacing',
			'default_padding' => '|||'
		),
		'number'         => array(
			'selector'        => '%%order_class%% .dswcp-checkout-steps >  li .dswcp-checkout-tab-number',
			'sub_toggle'      => 'spacing',
			'default_padding' => '|||'
		),
		'step'           => array(
			'selector'        => '%%order_class%% .dswcp-checkout-steps >  li .dswcp-checkout-tab-inner',
			'sub_toggle'      => 'spacing',
			'default_padding' => '|||'
		),
		'tabs_container' => array(
			'selector'        => '%%order_class%%  ul.dswcp-checkout-steps',
			'sub_toggle'      => 'spacing',
			'default_padding' => '|||'
		),
	);

	private function getIconSvg($svg) {
		global $wp_filesystem;
		if (empty($wp_filesystem)) {
			WP_Filesystem();
		}
		return $wp_filesystem->get_contents( AGS_divi_wc::$plugin_directory . 'includes/media/field-images/' . $svg . '.svg' );
	}

	function init() {
		$this->name             = esc_html__( 'Woo Multi-Step Checkout (BETA)', 'divi-shop-builder' );
		$this->icon_path        = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->main_css_element = '%%order_class%%';

		$iconSvgs = [
			'typography_text'   => '',
			'padding_margins'   => '',
			'border'            => '',
			'background_colors' => '',
			'settings'          => ''
		];

		array_walk(
			$iconSvgs,
			function ( &$value, $key ) {
				$value = file_get_contents( AGS_divi_wc::$plugin_directory . 'includes/media/icons/' . $key . '.svg' );
			}
		);

		$this->settings_modal_toggles = array(
			'advanced' => array(
				'toggles' => array(
					'layout'         => array(
						'title' => esc_html__( 'Layout', 'divi-shop-builder' ),
					),
					'tabs'           => array(
						'title'             => esc_html__( 'Tabs', 'divi-shop-builder' ),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'          => array(
								'name'     => 'p',
								'icon_svg' => $iconSvgs['typography_text'],
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $iconSvgs['background_colors'],
							),
						),
					),
					'active_tab'     => array(
						'title'             => esc_html__( 'Active Tab', 'divi-shop-builder' ),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'          => array(
								'name'     => 'p',
								'icon_svg' => $iconSvgs['typography_text'],
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $iconSvgs['background_colors'],
							),
						),
					),
					'link'     => array(
						'title'             => esc_html__( 'Tab Link Border', 'divi-shop-builder' ),
					),
					'active_link'     => array(
						'title'             => esc_html__( 'Active Tab Link Border', 'divi-shop-builder' ),
					),
					'image'          => array(
						'title'             => esc_html__( 'Image', 'divi-shop-builder' ),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'settings'   => array(
								'name'     => 'settings',
								'icon_svg' => $iconSvgs['settings'],
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $iconSvgs['background_colors'],
							),
						),
					),
					'icon'           => array(
						'title'             => esc_html__( 'Icon', 'divi-shop-builder' ),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'settings'   => array(
								'name'     => 'settings',
								'icon_svg' => $iconSvgs['settings'],
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $iconSvgs['background_colors'],
							),
						),
					),
					'number'         => array(
						'title'             => esc_html__( 'Number', 'divi-shop-builder' ),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'          => array(
								'name'     => 'p',
								'icon_svg' => $iconSvgs['typography_text'],
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $iconSvgs['background_colors'],
							),
						),
					),
					// If layout 6/ 7
					'step'           => array(
						'title'             => esc_html__( 'Step Container', 'divi-shop-builder' ),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'          => array(
								'name'     => 'p',
								'icon_svg' => $iconSvgs['typography_text'],
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $iconSvgs['background_colors'],
							),
						),
					),
					'tabs_container' => array(
						'title'             => esc_html__( 'Tabs Container', 'divi-shop-builder' ),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'background' => array(
								'name'     => 'background',
								'icon_svg' => $iconSvgs['background_colors'],
							),
						),
					),
					'buttons'        => array(
						'title'             => esc_html__( 'Buttons', 'divi-shop-builder' ),
					),
					'back_button'        => array(
						'title'             => esc_html__( 'Back Button', 'divi-shop-builder' ),
					),
					'continue_button'        => array(
						'title'             => esc_html__( 'Continue Button', 'divi-shop-builder' ),
					),
				),
			),
		);

		$this->advanced_fields   = array(
			'fonts'          => array(
				'tabs'       => array(
					'label'       => esc_html__( 'Tabs', 'divi-shop-builder' ),
					'css'         => array(
						'main' => '%%order_class%% .dswcp-checkout-steps > li a, %%order_class%%__loader-container',
						'important' => 'all',
					),
					'toggle_slug' => 'tabs',
					'sub_toggle'  => 'p',
				),
				'active_tab' => array(
					'label'       => esc_html__( 'Tabs', 'divi-shop-builder' ),
					'css'         => array(
						'main' => '%%order_class%% .dswcp-checkout-steps > li.dswcp-checkout-step-active a',
						'important' => 'all',
					),
					'toggle_slug' => 'active_tab',
					'sub_toggle'  => 'p',
					'font'      => array(
						'default' => '|600|||||||',
					),
				),
				'step' => array(
					'label'       => esc_html__( 'Step', 'divi-shop-builder' ),
					'css'         => array(
						'main' => '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-inner',
						'important' => 'all',
					),
					'toggle_slug' => 'step',
					'sub_toggle'  => 'p',
				),
				'number'     => array(
					'label'       => esc_html__( 'Number', 'divi-shop-builder' ),
					'css'         => array(
						'main' => '%%order_class%% .dswcp-checkout-steps > li  a .dswcp-checkout-tab-number',
						'important' => 'all',
					),
					'toggle_slug' => 'number',
					'sub_toggle'  => 'p',
				),
			),
			'button'         => array(
				'continue' => array(
					'label'          => esc_html__( 'Continue Button', 'divi-shop-builder' ),
					'css'            => array(
						'main'      => '%%order_class%%__buttons-container .et_pb_button.dswcp-button-continue',
						'important' => 'all',
					),
					'box_shadow'     => array(
						'label' => esc_html__( 'Back Button Box Shadow', 'divi-shop-builder' ),
						'css'   => array(
							'main'      => '%%order_class%%__buttons-container .et_pb_button.dswcp-button-continue',
							'important' => true,
						)
					),
					'use_alignment'  => false,
					'margin_padding' => array(
						'css'           => array(
							'main'      => '%%order_class%%__buttons-container .et_pb_button.dswcp-button-continue',
							'important' => 'all'
						),
						'custom_margin' => array(
							'default' => '||||false|false',
						),
					),
					'icon'           => array(
						'css' => array(
							'main'      => '%%order_class%%__buttons-container .et_pb_button.dswcp-button-continue::after',
							'important' => 'all'
						)
					),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'continue_button'
				),
				'back' => array(
					'label'          => esc_html__( 'Back Button', 'divi-shop-builder' ),
					'css'            => array(
						'main'      => '%%order_class%%__buttons-container .et_pb_button.dswcp-button-back',
						'important' => 'all',
					),
					'box_shadow'     => array(
						'label' => esc_html__( 'Next Button Box Shadow', 'divi-shop-builder' ),
						'css'   => array(
							'main'      => '%%order_class%%__buttons-container .et_pb_button.dswcp-button-back',
							'important' => true,
						)
					),
					'use_alignment'  => false,
					'margin_padding' => array(
						'css'           => array(
							'main'      => '%%order_class%%__buttons-container .et_pb_button.dswcp-button-back',
							'important' => 'all'
						),
						'custom_margin' => array(
							'default' => '||||false|false',
						),
					),
					'icon'           => array(
						'css' => array(
							'main'      => '%%order_class%%__buttons-container .et_pb_button.dswcp-button-back::after',
							'important' => 'all'
						)
					),
					'tab_slug'       => 'advanced',
					'toggle_slug'    => 'back_button'
				),
			),
			'box_shadow'     => array(
				'default'    => array(
					'css' => array(
						'main' => '%%order_class%%',
					)
				),
				'tabs'       => array(
					'css'         => array(
						'main' => '%%order_class%% .dswcp-checkout-steps > li',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'tabs',
					'sub_toggle'  => 'border',
				),
				'tabs_link'  => array(
					'label'       => esc_html__( 'Tabs Link', 'divi-shop-builder' ),
					'css'         => array(
						'main' => '%%order_class%% .dswcp-checkout-steps > li a',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'link'
				),
				'active_tab' => array(
					'label'       => esc_html__( 'Active Tab', 'divi-shop-builder' ),
					'css'         => array(
						'main' => '%%order_class%% .dswcp-checkout-steps > li.dswcp-checkout-step-active',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'active_tab',
					'sub_toggle'  => 'border',
				),
				'active_tab_link' => array(
					'label'       => esc_html__( 'Active Tab Link', 'divi-shop-builder' ),
					'css'         => array(
						'main' => '%%order_class%% .dswcp-checkout-steps > li.dswcp-checkout-step-active a',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'active_link'
				),
				'image'      => array(
					'css'         => array(
						'main' => '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-image',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'image',
					'sub_toggle'  => 'border',
				),
				'icon'       => array(
					'css'         => array(
						'main' => '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-icon',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'icon',
					'sub_toggle'  => 'border',
				),
				'number'     => array(
					'css'         => array(
						'main' => '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-number',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'number',
					'sub_toggle'  => 'border',
				),
				'step'       => array(
					'css'         => array(
						'main' => '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-inner',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'step',
					'sub_toggle'  => 'border',
				),
			),
			'borders'        => array(
				'default'        => array(),
				'tabs'           => array(
					'label'       => esc_html__( 'Tabs', 'divi-shop-builder' ),
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dswcp-checkout-steps > li',
							'border_styles' => '%%order_class%% .dswcp-checkout-steps > li',
							'important' => 'all',
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee'
						),
						'border_radii'  => 'off'
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'tabs',
					'sub_toggle'  => 'border',
				),
				'tabs_link'      => array(
					'label'       => esc_html__( 'Tabs Link', 'divi-shop-builder' ),
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dswcp-checkout-steps > li a',
							'border_styles' => '%%order_class%% .dswcp-checkout-steps > li a',
							'important' => 'all',
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee'
						),
						'border_radii'  => 'off'
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'link'
				),
				'active_tab'     => array(
					'label'       => esc_html__( 'Active Tab', 'divi-shop-builder'),
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dswcp-checkout-steps > li.dswcp-checkout-step-active',
							'border_styles' => '%%order_class%% .dswcp-checkout-steps > li.dswcp-checkout-step-active',
							'important' => 'all',
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee'
						),
						'border_radii'  => 'off'
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'active_tab',
					'sub_toggle'  => 'border',
				),
				'active_tab_link'     => array(
					'label'       => esc_html__( 'Active Tab Link', 'divi-shop-builder'),
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dswcp-checkout-steps > li.dswcp-checkout-step-active a',
							'border_styles' => '%%order_class%% .dswcp-checkout-steps > li.dswcp-checkout-step-active a',
							'important' => 'all',
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee'
						),
						'border_radii'  => 'off'
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'active_link',
				),
				'image'          => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-image',
							'border_styles' => '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-image',
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee'
						),
						'border_radii'  => 'off'
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'image',
					'sub_toggle'  => 'border',
				),
				'icon'           => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-icon',
							'border_styles' => '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-icon',
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee',
						),
						'border_radii'  => 'off'
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'icon',
					'sub_toggle'  => 'border',
				),
				'number'         => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-number',
							'border_styles' => '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-number',
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee',
						),
						'border_radii'  => 'off'
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'number',
					'sub_toggle'  => 'border',
				),
				'step'           => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-inner',
							'border_styles' => '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-inner',
							'important' => 'all',
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee'
						),
						'border_radii'  => 'off'
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'step',
					'sub_toggle'  => 'border'
				),
				'tabs_container' => array(
					'css'         => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dswcp-checkout-steps',
							'border_styles' => '%%order_class%% .dswcp-checkout-steps',
						)
					),
					'defaults'    => array(
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => '#eee',
						),
						'border_radii'  => 'off'
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'tabs_container',
					'sub_toggle'  => 'border',
				),
			),
			'background'     => array(
				'label'                => esc_html__( 'Background Color', 'divi-shop-builder' ),
				'use_background_color' => true,
				'options'              => array(
					'background_color'     => array(
						'depends_show_if' => 'on',
						'default'         => '',
					),
					'use_background_color' => array(
						'default' => 'off',
					),
				),
				'css'                  => array(
					'main' => '%%order_class%%',
				),
			),
			'margin_padding' => array(
				'css' => array(
					'important' => false,
					'main'      => '%%order_class%%',
				),
			),
			'max_width'      => array(
				'css' => array(
					'main' => '%%order_class%%',
				),
			),
			'link_options'   => false,
			'text'           => false,
		);

		$this->custom_css_fields = array();
	}

	function get_fields() {
		$fields = [
			'warning'                  => array(
				'type'        => 'ags_wc_warning-DSB',
				'toggleVar'   => 'ags_divi_wc_notCheckoutPage',
				'className'   => 'ags-divi-wc-page-warning',
				'warningText' => __( 'This module may not function properly on the front end of your website because this is not the assigned Checkout page.', 'divi-shop-builder' ),
			),
			'nav_type'                 => array(
				'label'           => esc_html__( 'Navigation Style', 'divi-shop-builder' ),
				'type'            => 'DSLayoutMultiselect-DSB',
				'options'         => array(
					'layout-1'  => array(
						'title'   => __( 'Layout 1', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('nav_type/layout_1' )
					),
					'layout-2'  => array(
						'title'   => __( 'Layout 2', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('nav_type/layout_2' )
					),
					'layout-3'  => array(
						'title'   => __( 'Layout 3', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('nav_type/layout_3' )
					),
					'layout-4'  => array(
						'title'   => __( 'Layout 4', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('nav_type/layout_4' )
					),
					'layout-5'  => array(
						'title'   => __( 'Layout 5', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('nav_type/layout_5' )
					),
					'layout-6'  => array(
						'title'   => __( 'Layout 6', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('nav_type/layout_6' )
					),
					'layout-7'  => array(
						'title'   => __( 'Layout 7', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('nav_type/layout_7' )
					),
					'layout-8'  => array(
						'title'   => __( 'Layout 8', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('nav_type/layout_8' )
					),
					'layout-9'  => array(
						'title'   => __( 'Layout 9', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('nav_type/layout_9' )
					),
					'layout-10' => array(
						'title'   => __( 'Layout 10', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('nav_type/layout_10' )
					),
					'layout-11' => array(
						'title'   => __( 'Layout 11', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('nav_type/layout_11' )
					),
				),
				'option_category' => 'basic_option',
				'customClass'     => 'dswcp-checkout-img-select',
				'description'     => esc_html__( 'Style to use for navigation.', 'divi-shop-builder' ),
				'default'         => 'layout-1'
			),
			'continue_text'            => array(
				'label'           => esc_html__( 'Continue Button Text', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Text for the Continue button.', 'divi-shop-builder' ),
				'default'         => esc_html__( 'Continue', 'divi-shop-builder' ),
			),
			'back_text'                => array(
				'label'           => esc_html__( 'Back Button Text', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Text for the Back button.', 'divi-shop-builder' ),
				'default'         => esc_html__( 'Back', 'divi-shop-builder' ),
			),
			'loader_text'              => array(
				'label'           => esc_html__( 'Loader Text', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Text for the loader.', 'divi-shop-builder' ),
				'default'         => esc_html__( 'Loading...', 'divi-shop-builder' ),
			),

			/* ----  Layout  ---- */
			'primary_color'            => array(
				'label'       => esc_html__( 'Primary Color Accent', 'divi-shop-builder' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'layout'
			),
			'secondary_color'          => array(
				'label'       => esc_html__( 'Secondary Color Accent', 'divi-shop-builder' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'layout',
			),
			'tabs_width'               => array(
				'label'       => esc_html__( 'Default tab width (px/%)', 'divi-shop-builder' ),
				'type'        => 'range',
				'default_unit'   => 'px',
				'mobile_options' => true,
				'responsive'     => true,
				//optional
				'input_attrs' => array(
					'step' => 1,
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'layout',
			),
			'tabs_grow'                => array(
				'label'       => esc_html__( 'Grow tabs if possible', 'divi-shop-builder' ),
				'type'        => 'select',
				'options'     => array(
					'default' => esc_html__( 'Default', 'divi-shop-builder' ),
					'0'     => esc_html__( 'Off', 'divi-shop-builder' ),
					'1'      => esc_html__( 'On', 'divi-shop-builder' ),
				),
				'mobile_options' => true,
				'responsive'     => true,
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'layout',
			),
			'tabs_gap'                 => array(
				'label'       => esc_html__( 'Space between tabs', 'divi-shop-builder' ),
				'type'        => 'range',
				'default_unit'   => 'px',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
				'mobile_options' => true,
				'responsive'     => true,
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'layout',
			),
			'tabs_align'               => array(
				'label'       => esc_html__( 'Align tabs', 'divi-shop-builder' ),
				'type'        => 'multiple_buttons',
				'options'     => array(
					'default'    => array(
						'title' => esc_html__( 'Default', 'divi-shop-builder' ),
						'icon'  => 'animation-none',
					),
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'divi-shop-builder' ),
						'icon'  => 'align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'divi-shop-builder' ),
						'icon'  => 'align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'divi-shop-builder' ),
						'icon'  => 'align-right',
					),
				),
				'mobile_options' => true,
				'responsive'     => true,
				'default'     => 'default',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'layout',
			),
			'tabs_link_align'               => array(
				'label'       => esc_html__( 'Align links in tabs', 'divi-shop-builder' ),
				'type'        => 'multiple_buttons',
				'options'     => array(
					'default'    => array(
						'title' => esc_html__( 'Default', 'divi-shop-builder' ),
						'icon'  => 'animation-none',
					),
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'divi-shop-builder' ),
						'icon'  => 'align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'divi-shop-builder' ),
						'icon'  => 'align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'divi-shop-builder' ),
						'icon'  => 'align-right',
					),
				),
				'mobile_options' => true,
				'responsive'     => true,
				'default'     => 'default',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'layout',
			),
			'tabs_white_space'         => array(
				'label'       => esc_html__( 'Display text always in one line', 'divi-shop-builder' ),
				'type'        => 'select',
				'options'     => array(
					'nowrap' => esc_html__( 'On', 'divi-shop-builder' ),
					'off'    => esc_html__( 'Off', 'divi-shop-builder' ),
				),
				'mobile_options' => true,
				'responsive'     => true,
				'default'     => 'nowrap',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'layout',
			),
			'line_width'               => array(
				'label'       => esc_html__( 'Line Width', 'divi-shop-builder' ),
				'type'        => 'range',
				'default_unit'   => 'px',
				//optional
				'input_attrs' => array(
					'min'  => 0,
					'step' => 1,
				),
				'mobile_options' => true,
				'responsive'     => true,
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'layout',
				'show_if'     => array(
					'nav_type' => [
						'layout-6',
						'layout-7'
					]
				)
			),
			'line_position'            => array(
				'label'       => esc_html__( 'Line Position', 'divi-shop-builder' ),
				'type'        => 'range',
				'default_unit'   => 'px',
				//optional
				'input_attrs' => array(
					'min'  => 0,
					'step' => 1,
				),
				'mobile_options' => true,
				'responsive'     => true,
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'layout',
				'sub_toggle'  => 'settings',
				'show_if'     => array(
					'nav_type' => [
						'layout-6',
						'layout-7'
					]
				)
			),
			'line_color'        => array(
				'label'       => esc_html__( 'Line Color', 'divi-shop-builder' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'layout',
				'sub_toggle'  => 'settings',
				'show_if'     => array(
					'nav_type' => [
						'layout-1',
						'layout-2',
						'layout-3',
						'layout-4',
						'layout-5',
						'layout-6',
						'layout-7',
						'layout-8',
						'layout-9'
					]
				)
			),

			/* ----  Tabs  ---- */
			'tab_bg_color'             => array(
				'label'       => esc_html__( 'Tab Background Color', 'divi-shop-builder' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tabs',
				'sub_toggle'  => 'background'
			),
			'tab_link_bg_color'        => array(
				'label'       => esc_html__( 'Link Background Color', 'divi-shop-builder' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tabs',
				'sub_toggle'  => 'background'
			),
			/* ----  Active Tabs  ---- */
			'active_tab_bg_color'      => array(
				'label'       => esc_html__( 'Active Tab Background Color', 'divi-shop-builder' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug'    => 'active_tab',
				'sub_toggle' => 'background',
			),
			'active_tab_link_bg_color' => array(
				'label'       => esc_html__( 'Active Tab Link Background Color', 'divi-shop-builder' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'active_tab',
				'sub_toggle'  => 'background'
			),

			/* ----  Image  ---- */
			'image_max_width'          => array(
				'label'       => esc_html__( 'Image Max Width', 'divi-shop-builder' ),
				'type'        => 'range',
				'default_unit'   => 'px',
				//optional
				'input_attrs' => array(
					'min'  => 0,
					'step' => 1,
				),
				'mobile_options' => true,
				'responsive'     => true,
				'unitless'    => true,
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'image',
				'sub_toggle'  => 'settings'
			),
			'image_max_height'         => array(
				'label'       => esc_html__( 'Image Max Height', 'divi-shop-builder' ),
				'type'        => 'range',
				'default_unit'   => 'px',
				//optional
				'input_attrs' => array(
					'min'  => 0,
					'step' => 1,
				),
				'mobile_options' => true,
				'responsive'     => true,
				'unitless'    => true,
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'image',
				'sub_toggle'  => 'settings'
			),
			'image_bg_color'           => array(
				'label'       => esc_html__( 'Background Color', 'divi-shop-builder' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'image',
				'sub_toggle'  => 'background'
			),

			/* ----  Icon  ---- */
			'icon_color'               => [
				'label'       => esc_html__( 'Icon Color', 'divi-shop-builder' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'icon',
				'sub_toggle'  => 'background'
			],
			'icon_bg_color'            => array(
				'label'       => esc_html__( 'Icon Background Color', 'divi-shop-builder' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'icon',
				'sub_toggle'  => 'background'
			),
			'icon_size'                => array(
				'label'       => esc_html__( 'Icon Size', 'divi-shop-builder' ),
				'type'        => 'range',
				'default_unit'   => 'px',
				//optional
				'input_attrs' => array(
					'min'  => 0,
					'step' => 1,
				),
				'mobile_options' => true,
				'responsive'     => true,
				'unitless'    => true,
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'icon',
				'sub_toggle'  => 'settings'
			),

			/* ----  Number  ---- */

			'number_bg_color' => array(
				'label'       => esc_html__( 'Background Color', 'divi-shop-builder' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'number',
				'sub_toggle'  => 'background'
			),

			/* ----  Step  ---- */

			'step_bg_color' => array(
				'label'       => esc_html__( 'Step Container Background Color', 'divi-shop-builder' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'step',
				'sub_toggle'  => 'background',
				'show_if'     => array(
					'nav_type' => [
						'layout-6',
						'layout-7'
					]
				)
			),
			'active_step_bg_color' => array(
				'label'       => esc_html__( 'Active Step Container Background Color', 'divi-shop-builder' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'step',
				'sub_toggle'  => 'background',
				'show_if'     => array(
					'nav_type' => [
						'layout-6',
						'layout-7'
					]
				)
			),
			'hover_step_bg_color' => array(
				'label'       => esc_html__( 'Step Container Hover Background Color', 'divi-shop-builder' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'step',
				'sub_toggle'  => 'background',
				'show_if'     => array(
					'nav_type' => [
						'layout-6',
						'layout-7'
					]
				)
			),
			/* ----  Tabs Container  ---- */

			'tabs_container_bg_color' => array(
				'label'       => esc_html__( 'Background Color', 'divi-shop-builder' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'tabs_container',
				'sub_toggle'  => 'background'
			),
			/* ----  Buttons  ---- */

			'buttons_align' => array(
				'label'       => esc_html__( 'Buttons Align', 'divi-shop-builder' ),
				'type'        => 'multiple_buttons',
				'options'     => array(
					'default'    => array(
						'title' => esc_html__( 'Default', 'divi-shop-builder' ),
						'icon'  => 'animation-none',
					),
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'divi-shop-builder' ),
						'icon'  => 'align-left',
					),
					'center'     => array(
						'title' => esc_html__( 'Center', 'divi-shop-builder' ),
						'icon'  => 'align-center',
					),
					'flex-end'   => array(
						'title' => esc_html__( 'Right', 'divi-shop-builder' ),
						'icon'  => 'align-right',
					),
				),
				'mobile_options' => true,
				'responsive'     => true,
				'default'     => 'right',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'buttons'
			),

			'buttons_wrapper_max_width'               => array(
				'label'       => esc_html__( 'Buttons Wrapper Max Width', 'divi-shop-builder' ),
				'type'        => 'range',
				'default_unit'   => 'px',
				'mobile_options' => true,
				'responsive'     => true,
				'input_attrs' => array(
					'step' => 1,
				),
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'buttons'
			),

			'buttons_wrapper_bg_color' => array(
				'label'       => esc_html__( 'Buttons Wrapper Background Color', 'divi-shop-builder' ),
				'type'        => 'color-alpha',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'buttons',
			),
		];

		// Paddings, Margins Fields
		foreach ( self::$margin_padding_elements as $elementId => $params ) {

			$default_margin  = isset( $params['default_margin'] ) ? $params['default_margin'] : '';
			$default_padding = isset( $params['default_padding'] ) ? $params['default_padding'] : '';
			$toggle_slug     = isset( $params['toggle_slug'] ) ? $params['toggle_slug'] : $elementId;
			$label  = isset( $params['label_prefix'] ) ? $params['label_prefix'] : '';

			$fields[ $elementId . '_padding' ] = array(
				'label'           => esc_html($label) . esc_html__( 'Padding', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => $default_padding,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => $toggle_slug,
				'sub_toggle'      => $params['sub_toggle'],
			);
			$fields[ $elementId . '_margin' ]  = array(
				'label'           => esc_html($label) . esc_html__( 'Margin', 'divi-shop-builder' ),
				'type'            => 'custom_margin',
				'option_category' => 'basic_option',
				'mobile_options'  => true,
				'responsive'      => true,
				'default'         => $default_margin,
				'tab_slug'        => 'advanced',
				'toggle_slug'     => $toggle_slug,
				'sub_toggle'      => $params['sub_toggle'],
			);
		}

		return $fields;
	}

	private function apply_responsive( $value, $selector, $css, $render_slug, $type, $default = null, $important = false ) {

		$dstc_last_edited       = $this->props[ $value . '_last_edited' ];
		$dstc_responsive_active = et_pb_get_responsive_status( $dstc_last_edited );

		switch ( $type ) {
			case 'custom_margin':

				$all_values = $this->props;
				$responsive = ET_Builder_Module_Helper_ResponsiveOptions::instance();

				// Responsive.
				$is_responsive = $responsive->is_responsive_enabled( $all_values, $value );

				$margin_desktop = $responsive->get_any_value( $all_values, $value );
				$margin_tablet  = $is_responsive ? $responsive->get_any_value( $all_values, "{$value}_tablet" ) : '';
				$margin_phone   = $is_responsive ? $responsive->get_any_value( $all_values, "{$value}_phone" ) : '';

				$styles = array(
					'desktop' => '' !== $margin_desktop ? rtrim( et_builder_get_element_style_css( $margin_desktop, $css, $important ) ) : '',
					'tablet'  => '' !== $margin_tablet ? rtrim( et_builder_get_element_style_css( $margin_tablet, $css, $important ) ) : '',
					'phone'   => '' !== $margin_phone ? rtrim( et_builder_get_element_style_css( $margin_phone, $css, $important ) ) : '',
				);

				$responsive->declare_responsive_css( $styles, $selector, $render_slug, $important );

				break;
			case 'alignment':
				$align        = esc_html( $this->get_alignment() );
				$align_tablet = esc_html( $this->get_alignment( 'tablet' ) );
				$align_phone  = esc_html( $this->get_alignment( 'phone' ) );

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
						"margin-$align" => ! empty( $align ) && 'center' !== $align ? '0' : '',
					),
				);

				if ( ! empty( $align_tablet ) ) {
					$dstc_array['tablet'] = array(
						'text-align'           => $align_tablet,
						'margin-left'          => 'left' !== $align_tablet ? 'auto' : '',
						'margin-right'         => 'left' !== $align_tablet ? 'auto' : '',
						"margin-$align_tablet" => ! empty( $align_tablet ) && 'center' !== $align_tablet ? '0' : '',
					);
				}

				if ( ! empty( $align_phone ) ) {
					$dstc_array['phone'] = array(
						'text-align'          => $align_phone,
						'margin-left'         => 'left' !== $align_phone ? 'auto' : '',
						'margin-right'        => 'left' !== $align_phone ? 'auto' : '',
						"margin-$align_phone" => ! empty( $align_phone ) && 'center' !== $align_phone ? '0' : '',
					);
				}
				et_pb_responsive_options()->generate_responsive_css( $dstc_array, $selector, $css, $render_slug, $important ? '!important' : '', $type );
				break;

			default:
				$re          = array(
					'|',
					'true',
					'false'
				);
				$dstc        = trim( str_replace( $re, ' ', $this->props[ $value ] ) );
				$dstc_tablet = trim( str_replace( $re, ' ', $this->props[ $value . '_tablet' ] ) );
				$dstc_phone  = trim( str_replace( $re, ' ', $this->props[ $value . '_phone' ] ) );

				$dstc_array = array(
					'desktop' => esc_html( $dstc ),
					'tablet'  => $dstc_responsive_active ? esc_html( $dstc_tablet ) : '',
					'phone'   => $dstc_responsive_active ? esc_html( $dstc_phone ) : '',
				);
				et_pb_responsive_options()->generate_responsive_css( $dstc_array, $selector, $css, $render_slug, $important ? '!important;' : '', $type );
		}

	}

	function before_render() {
		global $dscwp_checkout_steps;
		$dscwp_checkout_steps = [];
	}

	private function css( $render_slug ) {

		// -----------------------------------------------------
		// Responsive CSS
		// -----------------------------------------------------

		// Paddings and Margins
		foreach ( self::$margin_padding_elements as $elementId => $params ) {
			$this->apply_responsive( $elementId . '_padding', $params['selector'], 'padding', $render_slug, 'custom_margin', isset( $params['default_padding'] ) ? $params['default_padding'] : '' );
			$this->apply_responsive( $elementId . '_margin', $params['selector'], 'margin', $render_slug, 'custom_margin', isset( $params['default_margin'] ) ? $params['default_margin'] : '' );
		}

		/* ----  Layout  ---- */

		if ( '' !== $this->props['primary_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%%, %%order_class%%__loader-container',
					'declaration' => sprintf( '--ags_woo_multi_step_checkout-accent:%s;', esc_attr( $this->props['primary_color'] ) ),
				)
			);
		}

		if ( '' !== $this->props['secondary_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%%',
					'declaration' => sprintf( '--ags_woo_multi_step_checkout-accent-secondary:%s;', esc_attr( $this->props['secondary_color'] ) ),
				)
			);
		}

		if ( $this->props['tabs_width'] !== '' ) {
			$this->apply_responsive( 'tabs_width', '%%order_class%% .dswcp-checkout-steps > li', 'flex-basis', $render_slug, 'default', '', true );
		}

		if ( $this->props['tabs_grow'] !== '' ) {
			$this->apply_responsive( 'tabs_grow', '%%order_class%% .dswcp-checkout-steps > li', 'flex-grow', $render_slug, 'default', '', true );
		}

		if ( $this->props['tabs_gap'] !== '' ) {
			$this->apply_responsive( 'tabs_grow', '%%order_class%% .dswcp-checkout-steps', 'gap', $render_slug, 'default', '', true );
		}

		if ( $this->props['tabs_align'] !== 'default' ) {
			$this->apply_responsive( 'tabs_align', '%%order_class%% .dswcp-checkout-steps', 'justify-content', $render_slug, 'default', '', true );
		}

		if ( $this->props['tabs_link_align'] !== 'default' ) {
			$this->apply_responsive( 'tabs_link_align', '%%order_class%% .dswcp-checkout-steps li a', 'justify-content', $render_slug, 'default', '', true );
		}


		if ( $this->props['tabs_white_space'] !== 'off' ) {
			$this->apply_responsive( 'tabs_white_space', '%%order_class%% .dswcp-checkout-tab-text', 'white-space', $render_slug, 'default' );
		}

		if ( $this->props['line_width'] !== 'off' && ( $this->props['nav_type'] === 'layout-6' || $this->props['nav_type'] === 'layout-7' ) ) {
			$this->apply_responsive( 'line_width', '%%order_class%% .dswcp-checkout-steps li::before ', 'height', $render_slug, 'default', '', true );
		}
		if ( $this->props['line_position'] !== '' && ( $this->props['nav_type'] === 'layout-6' || $this->props['nav_type'] === 'layout-7' ) ) {
			$this->apply_responsive( 'line_position', '%%order_class%% .dswcp-checkout-steps li::before ', 'top', $render_slug, 'default', '', true );
		}

		if ( '' !== $this->props['line_color'] ) {
			$navType = $this->props['nav_type'];
			$lineColor = esc_attr( $this->props['line_color'] );
			$selector = '';
			$declaration = '';

			switch ($navType) {
				case 'layout-1':
				case 'layout-2':
				case 'layout-3':
					$selector = '%%order_class%%.ags_woo_multi_step_checkout .dswcp-checkout-steps li a';
					$declaration = sprintf('border-color:%s;', $lineColor);
					break;
				case 'layout-4':
					$selector = '%%order_class%% .dswcp-checkout-steps.dswcp-checkout-steps-layout-4 li a';
					$declaration = sprintf('border-color:%s!important;', $lineColor);
					break;
				case 'layout-5':
					$selector = '%%order_class%% .dswcp-checkout-steps.dswcp-checkout-steps-layout-5 li:not(:last-child):after';
					$declaration = sprintf('color:%s;', $lineColor);
					break;
				case 'layout-6':
				case 'layout-7':
					$selector = '%%order_class%% .dswcp-checkout-steps li::before';
					$declaration = sprintf('background-color:%s!important;', $lineColor);
					break;
				case 'layout-8':
				case 'layout-9':
					$selector = '%%order_class%% .dswcp-checkout-steps li.dswcp-checkout-step-active:before,%%order_class%% .dswcp-checkout-steps li:hover:before';
					$declaration = sprintf('background-color:%s!important;', $lineColor);
					break;
			}

			// Apply the styles if the selector and declaration have been set
			if ( !empty($selector) && !empty($declaration) ) {
				self::set_style_esc(
					$render_slug,
					array(
						'selector'    => $selector,
						'declaration' => $declaration,
					)
				);
			}
		}

		/* ----  Tabs  ---- */

		if ( '' !== $this->props['tab_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-checkout-steps > li',
					'declaration' => sprintf( 'background-color:%s;', esc_attr( $this->props['tab_bg_color'] ) ),
				)
			);
		}

		if ( '' !== $this->props['tab_link_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-checkout-steps > li a',
					'declaration' => sprintf( 'background-color:%s;', esc_attr( $this->props['tab_link_bg_color'] ) ),
				)
			);
		}

		/* ----  Active Tabs  ---- */

		if ( '' !== $this->props['active_tab_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-checkout-steps > li.dswcp-checkout-step-active',
					'declaration' => sprintf( 'background-color:%s;', esc_attr( $this->props['active_tab_bg_color'] ) ),
				)
			);
		}

		if ( '' !== $this->props['active_tab_link_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-checkout-steps > li.dswcp-checkout-step-active a',
					'declaration' => sprintf( 'background-color:%s;', esc_attr( $this->props['active_tab_link_bg_color'] ) ),
				)
			);
		}
		/* ----  Image  ---- */

		if ( '' !== $this->props['image_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-image',
					'declaration' => sprintf( 'background-color:%s;', esc_attr( $this->props['image_bg_color'] ) ),
				)
			);
		}

		if ( $this->props['image_max_width'] !== '' ) {
			$this->apply_responsive( 'image_max_width', '%%order_class%% .dswcp-checkout-steps > li  .dswcp-checkout-tab-image', 'max-width', $render_slug, 'default' );
		}

		if ( $this->props['image_max_height'] !== '' ) {
			$this->apply_responsive( 'image_max_height', '%%order_class%% .dswcp-checkout-steps > li  .dswcp-checkout-tab-image', 'max-width', $render_slug, 'default' );
		}

		/* ----  Icon  ---- */

		if ( '' !== $this->props['icon_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-icon',
					'declaration' => sprintf( 'background-color:%s;', esc_attr( $this->props['icon_bg_color'] ) ),
				)
			);
		}
		if ( '' !== $this->props['icon_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-icon',
					'declaration' => sprintf( 'color:%s;', esc_attr( $this->props['icon_color'] ) ),
				)
			);
		}

		if ( $this->props['icon_size'] !== '' ) {
			$this->apply_responsive( 'image_max_height', '%%order_class%% .dswcp-checkout-steps > li  .dswcp-checkout-tab-icon', 'font-size', $render_slug, 'default' );
		}


		/* ----  Number  ---- */

		if ( '' !== $this->props['number_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-number',
					'declaration' => sprintf( 'background-color:%s;', esc_attr( $this->props['number_bg_color'] ) ),
				)
			);
		}

		/* ----  Step  ---- */

		if ( '' !== $this->props['step_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-checkout-steps > li .dswcp-checkout-tab-inner',
					'declaration' => sprintf( 'background-color:%s;', esc_attr( $this->props['step_bg_color'] ) ),
				)
			);
		}

		if ( '' !== $this->props['active_step_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-checkout-steps li.dswcp-checkout-step-active a .dswcp-checkout-tab-inner',
					'declaration' => sprintf( 'background-color:%s!important;', esc_attr( $this->props['active_step_bg_color'] ) ),
				)
			);
		}
		if ( '' !== $this->props['hover_step_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-checkout-steps li:hover a .dswcp-checkout-tab-inner',
					'declaration' => sprintf( 'background-color:%s;', esc_attr( $this->props['hover_step_bg_color'] ) ),
				)
			);
		}

		/* ----  Tabs Container  ---- */

		if ( '' !== $this->props['tabs_container_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-checkout-steps',
					'declaration' => sprintf( 'background-color:%s;', esc_attr( $this->props['tabs_container_bg_color'] ) ),
				)
			);
		}

		/* ----  Buttons  ---- */

		if ( $this->props['buttons_align'] !== 'default' ) {
			$this->apply_responsive( 'buttons_align', '%%order_class%%__buttons-container .dswcp-checkout-steps-buttons', 'justify-content', $render_slug, 'default', '', true );
		}

		if ( $this->props['buttons_wrapper_max_width'] !== '' ) {
			$this->apply_responsive( 'buttons_wrapper_max_width', '%%order_class%%__buttons-container .dswcp-checkout-steps-buttons.et_pb_row', 'max-width', $render_slug, 'default', '', true );
		}

		if ( '' !== $this->props['buttons_wrapper_bg_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%%__buttons-container.et_pb_section',
					'declaration' => sprintf( 'background-color:%s;', esc_attr( $this->props['buttons_wrapper_bg_color'] ) ),
				)
			);
		}

	}

	static function renderChildContent( $content ) {
		global $dscwp_checkout_child_content;
		if ( isset( $dscwp_checkout_child_content ) ) {
			$content .= $dscwp_checkout_child_content;
			unset( $dscwp_checkout_child_content );
		}
		remove_filter( 'et_pb_section_shortcode_output', [
			__CLASS__,
			'renderChildContent'
		] );

		return $content;
	}

	function render( $attrs, $content = null, $render_slug = null ) {
		global $dscwp_checkout_steps, $dscwp_checkout_child_content;

		$this->css( $render_slug );
		if ( $this->props['content'] ) {
			$dscwp_checkout_child_content = ( isset( $dscwp_checkout_child_content ) ? $dscwp_checkout_child_content : '' ) . $this->props['content'];
			add_filter( 'et_pb_section_shortcode_output', [
				__CLASS__,
				'renderChildContent'
			] );
		}

		$hiddenSteps = [];
		foreach ( $dscwp_checkout_steps as $stepIndex => $step ) {
			if ( ! empty( $step['disable'] ) ) {
				$hiddenSteps[] = $step['selector'];
				unset( $dscwp_checkout_steps[ $stepIndex ] );
			}
		}

		$layoutHasInner = ( $this->props['nav_type'] == 'layout-6' || $this->props['nav_type'] == 'layout-7' );

		ob_start();
		?>
        <ul class="dswcp-checkout-steps dswcp-checkout-steps-<?php echo( esc_attr( $this->props['nav_type'] ) ); ?> et_smooth_scroll_disabled"<?php if ( $hiddenSteps ) {
			echo( ' data-hidden-steps="' . esc_attr( implode( ',', $hiddenSteps ) ) . '"' );
		} ?>>
			<?php foreach ( array_values($dscwp_checkout_steps) as $stepIndex => $step ) { ?>
                <li data-selector="<?php echo( esc_attr( $step['selector'] ) ); ?>">
                    <a href="#<?php echo( empty( $step['slug'] ) ? 'step' . ( (int) $stepIndex + 1 ) : esc_attr( $step['slug'] ) ); ?>">
						<?php if ( $layoutHasInner ) { ?>
                        <span class="dswcp-checkout-tab-inner"><?php } ?>
							<?php if ( ! empty( $step['image'] ) ) { ?>
                                <span class="dswcp-checkout-tab-image">
							<img src="<?php echo( esc_url( $step['image'] ) ); ?>"
                                 alt="<?php echo( esc_attr( $step['label'] ) ); ?>">
						</span>
							<?php } else if ( ! empty( $step['icon'] ) ) { ?>
                                <span class="dswcp-checkout-tab-icon et-pb-icon<?php if ( function_exists( 'et_pb_maybe_fa_font_icon' ) && et_pb_maybe_fa_font_icon( $step['icon'] ) ) {
									echo( ' et-pb-fa-icon' );
								} ?>">
							<?php echo( esc_html( et_pb_process_font_icon( $step['icon'] ) ) ); ?>
						</span>
							<?php } ?>
							<?php if ( isset( $step['number'] ) && $step['number'] !== null ) { ?>
                                <span class="dswcp-checkout-tab-number"><?php echo( esc_html( str_replace( '%d', $stepIndex + 1, $step['number'] ) ) ); ?></span><?php } ?>
							<?php if ( $layoutHasInner ) { ?></span><?php } ?>
                        <span class="dswcp-checkout-tab-text"><?php echo( esc_html( $step['label'] ) ); ?></span>
                    </a>
                </li>
			<?php } ?>
        </ul>

        <div class="dswcp-checkout-loader <?php echo(esc_attr(ET_Builder_Element::get_module_order_class($this->slug))); ?>__loader-container">
            <div class="et_pb_row">
                <span class="dswcp-checkout-loader-icon"></span>
                <span class="dswcp-checkout-loader-text"><?php echo( esc_html( $this->props['loader_text'] ) ); ?></span>
            </div>
        </div>

        <div class="dswcp-checkout-steps-buttons-container <?php echo(esc_attr(ET_Builder_Element::get_module_order_class($this->slug))); ?>__buttons-container et_pb_section">
            <div class="dswcp-checkout-steps-buttons et_pb_row">
                <button type="button"
                        class="et_pb_button dswcp-button-back"><?php echo( esc_html( $this->props['back_text'] ) ); ?></button>
                <button type="button"
                        class="et_pb_button dswcp-button-continue"><?php echo( esc_html( $this->props['continue_text'] ) ); ?></button>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Override parent method to setup conditional text shadow fields
	 * {@see parent::_set_fields_unprocessed}
	 *
	 * @param Array fields array
	 */
	protected function _set_fields_unprocessed($fields) {

		if ( ! is_array($fields) ) {
			return;
		}

		$template            = ET_Builder_Module_Helper_OptionTemplate::instance();
		$newFields           = [];

		foreach ( $fields as $field => $definition ) {
			if ( ($definition === 'text_shadow' || $definition === 'box_shadow') && $template->is_enabled() && $template->has( $definition ) ) {

				$data    = $template->get_data($field);
				$setting = end($data);

				$settingWithShowIf = self::setFieldShowIf($setting);
				$new_definition    = $settingWithShowIf ? ET_Builder_Module_Fields_Factory::get($definition === 'box_shadow' ? 'BoxShadow' : 'TextShadow')->get_fields($settingWithShowIf) : null;

				if ( $new_definition ) {
					$field      = array_keys($new_definition)[0];
					$definition = array_values($new_definition)[0];
				}

			} else {
				$definitionWithShowIf = self::setFieldShowIf($definition);
				$definition           = $definitionWithShowIf ? $definitionWithShowIf : $definition;
			}

			$newFields[ $field ] = $definition;
		}

		return parent::_set_fields_unprocessed($newFields);
	}
	public static function setFieldShowIf($field) {
		if ( isset($field['toggle_slug']) ) {


			//do_action( 'qm/debug', $field );

			switch ( $field['toggle_slug'] ) {
				case 'step':
					$showIf = ['nav_type' => ['layout-6', 'layout-7']];
					break;
			}

			if (isset($showIf)) {
				if ( empty($field['show_if']) ) {
					$field['show_if'] = $showIf;
				} else {
					$field['show_if'] = array_merge($field['show_if'], $showIf);
				}
			}
			return $field;
		}

		return null;
	}

	protected function _add_borders_fields() {
		add_filter('et_builder_option_template_is_active', [__CLASS__, '_false']);
		parent::_add_borders_fields();
		remove_filter('et_builder_option_template_is_active', [__CLASS__, '_false']);
	}


	public static function _false() {
		return false;
	}
	public function process_advanced_button_options($slug) {
		add_filter('ags_woo_multi_step_checkout_css_selector', [__CLASS__, 'strip_button_selector_prefix']);
		parent::process_advanced_button_options($slug);
		remove_filter('ags_woo_multi_step_checkout_css_selector', [__CLASS__, 'strip_button_selector_prefix']);
	}
	
	public function process_margin_padding_advanced_css($slug) {
		add_filter('ags_woo_multi_step_checkout_css_selector', [__CLASS__, 'strip_button_selector_prefix']);
		parent::process_margin_padding_advanced_css($slug);
		remove_filter('ags_woo_multi_step_checkout_css_selector', [__CLASS__, 'strip_button_selector_prefix']);
	}

	public static function strip_button_selector_prefix($selector) {
		return strpos($selector, '.dswcp-button-') === false ? $selector : str_replace('body #page-container .et_pb_section ', 'body #page-container .et_pb_section', $selector);
	}

}

new DSWCP_WooMultiStepCheckout;
