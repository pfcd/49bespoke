<?php

defined( 'ABSPATH' ) || exit;

/**
 * Module class of Woo My Account Avatar
 *
 */
class DSWCP_WooAccountNav extends DSWCP_WooAccountBase {

    use DSWCP_Module;

	public $slug       = 'ags_woo_account_navigation';
	public $vb_support = 'on';
	public $child_slug = 'ags_woo_account_navigation_item';
	protected $icon_path;
	protected $endpoint;

	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);

	public function init() {
		$this->name      = esc_html__('Account Navigation', 'divi-shop-builder');
		$this->icon_path = plugin_dir_path(__FILE__) . 'icon.svg';

		$this->settings_modal_toggles = array(
			'general'  => array(
				'toggles' => array(
					'main_content'     => esc_html__( 'Contents', 'divi-shop-builder' )
				),
			),
			'advanced' => array(
				'toggles' => array(
					'nav_item' 	   => array(
						'title'    => esc_html__( 'Navigation Item', 'divi-shop-builder' ),
						'priority' => 45
					),
					'nav_item_active'   => array(
						'title'    => esc_html__( 'Navigation Active Item', 'divi-shop-builder' ),
						'priority' => 46
					),
					'nav_item_icon'	=> array(
						'title'    => esc_html__( 'Navigation Item Icon', 'divi-shop-builder' ),
						'priority' => 47
					),
					'nav_item_active_icon'	=> array(
						'title'    => esc_html__( 'Navigation Active Item Icon', 'divi-shop-builder' ),
						'priority' => 47
					)
				),
			),
		);

		$this->advanced_fields = array(
			'link_options' => false,
			'text' 		   => false,
			'fonts'          => array(
				'nav_item' => array(
					'label'           => esc_html__( 'Navigation Item', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% nav > ul > li > a',
						'text_align' => '%%order_class%% nav > ul > li',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '14px',
					),
					'toggle_slug'     => 'nav_item',
				),
				'nav_item_active' => array(
					'label'           => esc_html__( 'Navigation Active Item', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% nav > ul > li.is-active > a',
						'text_align' => '%%order_class%% nav > ul > li',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '14px',
					),
					'toggle_slug'     => 'nav_item_active',
				),
				'nav_item_icon' => array(
					'label'           => esc_html__( 'Navigation Item Icon', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% nav > ul > li > a:before, %%order_class%% nav > ul > li > a:after',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '14px',
					),
					'hide_text_align' => true,
					'hide_font'		  => true,
					'hide_letter_spacing' => true,
					'toggle_slug'     => 'nav_item_icon',
				),
				'nav_item_active_icon' => array(
					'label'           => esc_html__( 'Navigation Active Item Icon', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% nav > ul > li.is-active > a:before, %%order_class%% nav > ul > li.is-active > a:after',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '14px',
					),
					'hide_text_align' => true,
					'hide_font'		  => true,
					'hide_letter_spacing' => true,
					'toggle_slug'     => 'nav_item_active_icon',
				)
			),
			'borders' => array(
				'default' => array(),
				'nav_item' => array(
					'label'           => esc_html__( 'Navigation Item Border', 'divi-shop-builder' ),
					'title'           => esc_html__( 'Navigation Item Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% nav.woocommerce-MyAccount-navigation ul li',
							'border_radii' 	=> '%%order_class%% nav.woocommerce-MyAccount-navigation ul li'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'on||||',
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => ''
						)
					),
					'toggle_slug'     => 'nav_item',
				),
				'nav_item_active' => array(
					'label'           => esc_html__( 'Navigation Active Item Border', 'divi-shop-builder' ),
					'title'           => esc_html__( 'Navigation Active Item Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% nav.woocommerce-MyAccount-navigation ul li.is-active',
							'border_radii' 	=> '%%order_class%% nav.woocommerce-MyAccount-navigation ul li.is-active'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'on||||',
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => ''
						)
					),
					'toggle_slug'     => 'nav_item_active',
				),
				'nav_item_icon' => array(
					'label'           => esc_html__( 'Navigation Item Icon Border', 'divi-shop-builder' ),
					'title'           => esc_html__( 'Navigation Item Icon Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% nav.woocommerce-MyAccount-navigation ul li a[data-icon]:before, %%order_class%% nav.woocommerce-MyAccount-navigation ul li a[data-icon]:after',
							'border_radii' 	=> '%%order_class%% nav.woocommerce-MyAccount-navigation ul li a[data-icon]:before, %%order_class%% nav.woocommerce-MyAccount-navigation ul li a[data-icon]:after'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'on||||',
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => ''
						)
					),
					'toggle_slug'     => 'nav_item_icon',
				),
				'nav_item_active_icon' => array(
					'label'           => esc_html__( 'Navigation Active Item Icon Border', 'divi-shop-builder' ),
					'title'           => esc_html__( 'Navigation Active Item Icon Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% nav.woocommerce-MyAccount-navigation ul li.is-active a[data-icon]:before, %%order_class%% nav.woocommerce-MyAccount-navigation ul li.is-active a[data-icon]:after',
							'border_radii' 	=> '%%order_class%% nav.woocommerce-MyAccount-navigation ul li.is-active a[data-icon]:before, %%order_class%% nav.woocommerce-MyAccount-navigation ul li.is-active a[data-icon]:after'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'on||||',
						'border_styles' => array(
							'width' => '0px',
							'style' => 'none',
							'color' => ''
						)
					),
					'toggle_slug'     => 'nav_item_active_icon',
				)
			),
			'margin_padding' => array(
				'css' => array(
					'margin'    => "%%order_class%%",
					'padding'   => "%%order_class%%",
					'important' => array( 'custom_margin' ),
				),
			),

		);

		/**
		 * Sets to current my account endpoint
		 * So it will render on all the my account endpoints
		 *
		 */
		$this->endpoint = WC()->query->get_current_endpoint();
	}

	public function get_fields(){
		return array(
			'warning'            => array(
				'type'       => 'ags_wc_warning-DSB',
				'toggleVar' =>  'ags_divi_wc_notAccountPage',
				'className' => 'ags-divi-wc-page-warning',
				'warningText'    => __( 'This module will not function properly on the front end of your website because this is not the assigned My Account page.', 'divi-shop-builder' ),
				'toggle_slug'	   => 'main_content'
			),
			'type' => array(
				'label'            => esc_html__( 'Navigation Type', 'divi-shop-builder' ),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => array(
					'vertical'         => esc_html__( 'Vertical', 'divi-shop-builder' ),
					'horizontal'       => esc_html__( 'Horizontal', 'divi-shop-builder' )
				),
				'description'      => esc_html__( 'Choose which type of navigation view you would like to display.', 'divi-shop-builder' ),
				'default'		   => 'vertical',
				'toggle_slug'	   => 'main_content'
			),
			'horizontal_align' => array(
				'label'            => esc_html__( 'Align', 'divi-shop-builder' ),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => array(
					'flex-start'         => esc_html__( 'Left', 'divi-shop-builder' ),
					'center'       => esc_html__( 'Center', 'divi-shop-builder' ),
					'flex-end'        => esc_html__( 'Right', 'divi-shop-builder' )
				),
				'description'      => esc_html__( 'Choose the align of navigation view you would like to display.', 'divi-shop-builder' ),
				'default'		   => 'left',
				'toggle_slug'	   => 'main_content',
				'show_if'		   => array(
						'type' => 'horizontal'
				)
			),
			'icon_position' => array(
				'label'            => esc_html__( 'Icon Position', 'divi-shop-builder' ),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => array(
					'none' 		   => esc_html__( 'None', 'divi-shop-builder' ),
					'list' 		   => esc_html__( 'List', 'divi-shop-builder' ),
					'before'       => esc_html__( 'Before', 'divi-shop-builder' ),
					'after'        => esc_html__( 'After', 'divi-shop-builder' )
				),
				'description'      => esc_html__( 'Choose icon placement in navigation items.', 'divi-shop-builder' ),
				'default'		   => 'none',
				'toggle_slug'	   => 'main_content'
			),
			'nav_item_padding' => array(
				'label'           => esc_html__( 'Navigation Item Padding', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "navigation item" custom padding', 'divi-shop-builder' ),
				'type' 			  => 'custom_padding',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '|||||',
				'toggle_slug'     => 'nav_item',
			),
			'nav_item_margin' => array(
				'label'           => esc_html__( 'Navigation Item Margin', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "navigation item" custom margin', 'divi-shop-builder' ),
				'type' 			  => 'custom_margin',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '|2em||||',
				'toggle_slug'     => 'nav_item',
			),
			'nav_item_icon_padding' => array(
				'label'           => esc_html__( 'Navigation Item Icon Padding', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "navigation item icon" custom padding', 'divi-shop-builder' ),
				'type' 			  => 'custom_padding',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '|||||',
				'toggle_slug'     => 'nav_item_icon',
			),
			'nav_item_icon_margin' => array(
				'label'           => esc_html__( 'Navigation Item Icon Margin', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Specify "navigation item icon" custom margin', 'divi-shop-builder' ),
				'type' 			  => 'custom_margin',
				'option_category' => 'configuration',
				'tab_slug' 		  => 'advanced',
				'default' 		  => '|5px||||',
				'toggle_slug'     => 'nav_item_icon',
			),
			'nav_item_bg_color' => array(
				'label'          => esc_html__( 'Navigation Item Background Color', 'divi-shop-builder' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'nav_item',
				'default'        => '',
				'hover'			 => 'tabs'
			),
			'nav_item_acitve_bg_color' => array(
				'label'          => esc_html__( 'Navigation Active Item Background Color', 'divi-shop-builder' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'nav_item_active',
				'default'        => '',
				'hover'			 => 'tabs'
			),
			'nav_item_icon_bg_color' => array(
				'label'          => esc_html__( 'Navigation Item Icon Background Color', 'divi-shop-builder' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'nav_item_icon',
				'default'        => '',
			),
			'nav_item_acitve_icon_bg_color' => array(
				'label'          => esc_html__( 'Navigation Active Item Icon Background Color', 'divi-shop-builder' ),
				'type'           => 'color-alpha',
				'custom_color'   => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'    => 'nav_item_active_icon',
				'default'        => '',
			),
//			'hide_bullets'		 => array(
//				'label'          => esc_html__( 'Hide Navigation Item Bullet Icons', 'divi-shop-builder' ),
//				'description'    => esc_html__( 'If you would like to control the size of the icon, you must first enable this option.', 'divi-shop-builder' ),
//				'type'           => 'yes_no_button',
//				'options'        => array(
//					'off' => esc_html__( 'No', 'divi-shop-builder' ),
//					'on'  => esc_html__( 'Yes', 'divi-shop-builder' ),
//				),
//				'default_on_front' => 'off',
//				'tab_slug'         => 'advanced',
//				'toggle_slug'      => 'nav_item',
//				'show_if'		   => array(
//					'icon_position' => 'none'
//				)
//			)
		);
	}

	public function render( $attrs, $content, $render_slug ){

		if( !$this->_can_render() ){
			return '';
		}

		$corners = array(
			'top' 	 => 0,
			'right'  => 1,
			'bottom' => 2,
			'left' 	 => 3
		);

		// Align for horizontal nav
		if( $this->props['horizontal_align'] ){
			$horizontal_align = $this->props['horizontal_align'];
			self::set_style_esc( $this->slug, array(
				'selector' 	  => '%%order_class%% nav.woocommerce-MyAccount-navigation ul',
				'declaration' => "justify-content: {$horizontal_align};"
			));
		}

		if( $this->props['nav_item_padding'] ){
			$values  = explode( '|', $this->props['nav_item_padding'] );
			foreach( $corners as $corner => $key ){
				if( !empty( $values[$key] ) ){
					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% nav.woocommerce-MyAccount-navigation ul li',
						'declaration' => "padding-{$corner}: {$values[$key]} !important;"
					));
				}
			}
		}

		if( $this->props['nav_item_margin'] ){
			$values  = explode( '|', $this->props['nav_item_margin'] );
			foreach( $corners as $corner => $key ){
				if( !empty( $values[$key] ) ){
					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% nav.woocommerce-MyAccount-navigation ul li',
						'declaration' => "margin-{$corner}: {$values[$key]} !important;"
					));
				}
			}
		}

		if( !empty( $this->props['nav_item_icon_padding'] ) ){
			$values  = explode( '|', $this->props['nav_item_icon_padding'] );
			foreach( $corners as $corner => $key ){
				if( !empty( $values[$key] ) ){
					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% nav.woocommerce-MyAccount-navigation ul li a[data-icon]:before, %%order_class%% nav.woocommerce-MyAccount-navigation ul li a[data-icon]:after',
						'declaration' => "padding-{$corner}: {$values[$key]} !important;"
					));
				}
			}
		}

		if( !empty( $this->props['nav_item_icon_margin'] ) ){
			$values  = explode( '|', $this->props['nav_item_icon_margin'] );
			foreach( $corners as $corner => $key ){
				if( !empty( $values[$key] ) ){
					self::set_style_esc( $this->slug, array(
						'selector' 	  => '%%order_class%% nav.woocommerce-MyAccount-navigation ul li a[data-icon]:before, %%order_class%% nav.woocommerce-MyAccount-navigation ul li a[data-icon]:after',
						'declaration' => "margin-{$corner}: {$values[$key]} !important;"
					));
				}
			}
		}

		if( !empty( $this->props['nav_item_icon_bg_color'] ) ){
			$bg_color = $this->props['nav_item_icon_bg_color'];
			self::set_style_esc( $this->slug, array(
				'selector' 	  => '%%order_class%% nav.woocommerce-MyAccount-navigation ul li a[data-icon]:before, %%order_class%% nav.woocommerce-MyAccount-navigation ul li a[data-icon]:after',
				'declaration' => "background-color:{$bg_color} !important;"
			));
		}

		if( !empty( $this->props['nav_item_acitve_icon_bg_color'] ) ){
			$active_bg_color = $this->props['nav_item_acitve_icon_bg_color'];
			self::set_style_esc( $this->slug, array(
				'selector' 	  => '%%order_class%% nav.woocommerce-MyAccount-navigation ul li.is-active a[data-icon]:before, %%order_class%% nav.woocommerce-MyAccount-navigation ul li.is-active a[data-icon]:after',
				'declaration' => "background-color:{$active_bg_color} !important;"
			));
		}

		if( !empty( $this->props['nav_item_bg_color'] ) ){
			$item_bg_color = $this->props['nav_item_bg_color'];
			self::set_style_esc( $this->slug, array(
				'selector' 	  => '%%order_class%% nav.woocommerce-MyAccount-navigation ul li',
				'declaration' => "background-color:{$item_bg_color} !important;"
			));
		}

		if( !empty( $this->props['nav_item_bg_color__hover'] ) ){
			$item_bg_color_hover = $this->props['nav_item_bg_color__hover'];
			self::set_style_esc( $this->slug, array(
				'selector' 	  => '%%order_class%% nav.woocommerce-MyAccount-navigation ul li:hover',
				'declaration' => "background-color:{$item_bg_color_hover} !important;"
			));
		}

		if( !empty( $this->props['nav_item_acitve_bg_color'] ) ){
			$active_item_bg_color = $this->props['nav_item_acitve_bg_color'];
			self::set_style_esc( $this->slug, array(
				'selector' 	  => '%%order_class%% nav.woocommerce-MyAccount-navigation ul li.is-active',
				'declaration' => "background-color:{$active_item_bg_color} !important;"
			));
		}

		if( !empty( $this->props['nav_item_acitve_bg_color__hover'] ) ){
			$active_item_bg_color_hover = $this->props['nav_item_acitve_bg_color__hover'];
			self::set_style_esc( $this->slug, array(
				'selector' 	  => '%%order_class%% nav.woocommerce-MyAccount-navigation ul li.is-active:hover',
				'declaration' => "background-color:{$active_item_bg_color_hover} !important;"
			));
		}

		// Hide bullets in nav
		if( !empty( $this->props['icon_position'] ) && $this->props['icon_position'] === 'none' ){
			self::set_style_esc( $this->slug, array(
				'selector' 	  => '%%order_class%% nav.woocommerce-MyAccount-navigation ul',
				'declaration' => "list-style-type: none !important;"
			));
		}

		return sprintf('
			<div class="woocommerce">
				<nav class="%s">
					<ul>
						%s
					</ul>
				</nav>
			</div>',
			join( ' ', array( 'woocommerce-MyAccount-navigation', $this->props['type'], "icon-{$this->props['icon_position']}" ) ),
			$this->content
		);
	}
}

new DSWCP_WooAccountNav;