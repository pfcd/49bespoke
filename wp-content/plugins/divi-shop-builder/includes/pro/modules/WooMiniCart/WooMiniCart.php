<?php

defined( 'ABSPATH' ) || exit;

/**
 * Module class of Woo Mini Cart
 *
 */
class DSWCP_WooMiniCart extends ET_Builder_Module {

    use DSWCP_Module;

    public $slug       		= 'ags_woo_mini_cart';
	public $vb_support 		= 'on';
	protected $icon_path;

	protected $module_credits = array(
		'module_uri' => 'https://wpzone.co/',
		'author'     => 'WP Zone',
		'author_uri' => 'https://wpzone.co/',
	);
	
	function __construct() {
		parent::__construct();
		add_filter('et_pb_set_style_selector', function($selector, $slug) {
			return $slug == $this->slug ? implode(',', array_map(function($selectorPart) {
				return (strpos($selectorPart, ET_BUILDER_CSS_PREFIX.' ') === false)
						? $selectorPart
					    : ((strpos($selectorPart, '.et_pb_button') === false && strpos($selectorPart, '.dswcp-buttons') === false) ? '' : $selectorPart.',').str_replace(ET_BUILDER_CSS_PREFIX.' ', '', $selectorPart);
			}, explode(',', $selector))) : $selector;
		}, 10, 2);
	}

	private function getIconSvg($svg) {
			global $wp_filesystem;
			if (empty($wp_filesystem)) {
				WP_Filesystem();
			}
		return $wp_filesystem->get_contents( AGS_divi_wc::$plugin_directory . 'includes/media/icons/' . $svg . '.svg' );
	}

	/**
	 * Based on this array margin and padding fields will be added
	 * set 'toggle_slug' as a key
	 * Update also in  .jsx
	 *
	 */
	private static $margin_padding_elements = array(
		'cart_icon'               => array(
			'selector'        => '%%order_class%% .dswcp-cart-icon.dswcp-mini-cart-icon',
			'sub_toggle'      => 'spacing',
			'default_padding' => '|||'
		),
		'cart_icon_count'               => array(
			'selector'        => '%%order_class%% a.dswcp-cart-link .dswcp-count',
			'sub_toggle'      => 'spacing',
			'default_padding' => '|||'
		),
		'dropdown'               => array(
			'selector'        => '%%order_class%% .dswcp-dropdown-cart',
			'sub_toggle'      => 'spacing',
			'default_padding' => '10px|10px|10px|10px'
		),
		'dropdown_container'               => array(
			'selector'        => '%%order_class%% .dswcp-dropdown-cart-container',
			'sub_toggle'      => 'spacing',
			'toggle_slug'     => 'dropdown',
			'default_padding' => '15px|||',
			'label_prefix' => 'Container '
		),
		'side_cart'               => array(
			'selector'        => '%%order_class%% .dswcp-side-cart',
			'sub_toggle'      => 'spacing',
			'default_padding' => '10px|10px|10px|10px'
		),
		'cart_icon_amount'               => array(
			'selector'        => '%%order_class%% a.dswcp-cart-link .dswcp-amount',
			'sub_toggle'      => 'spacing',
			'default_padding' => '|||'
		),
		'header'               => array(
			'selector'        => '%%order_class%% .dswcp-side-cart-header, %%order_class%% .dswcp-dropdown-cart-header',
			'sub_toggle'      => 'spacing',
			'default_padding' => '10px||10px|'
		),
		'product'               => array(
			'selector'        => '%%order_class%% .dswcp-dropdown-cart-item, %%order_class%% .dswcp-side-cart-item',
			'sub_toggle'      => 'spacing',
			'default_padding' => '|||'
		),
		'product_image'               => array(
			'selector'        => '%%order_class%% .dswcp-image-container',
			'sub_toggle'      => 'spacing',
			'default_padding' => '|||'
		),
		'product_name'               => array(
			'selector'        => '%%order_class%% h3.dswcp-product-name',
			'sub_toggle'      => 'spacing',
			'default_padding' => '|||'
		),
		'product_remove'               => array(
			'selector'        => '%%order_class%% .dswcp-remove',
			'sub_toggle'      => 'spacing',
			'default_padding' => '|||'
		),
		'footer'               => array(
			'selector'        => '%%order_class%% .dswcp-side-cart-footer, %%order_class%% .dswcp-dropdown-cart-footer',
			'sub_toggle'      => 'spacing',
			'default_padding' => '|||',
			'default_margin' => '1em|||'
		),
		'subtotal'               => array(
			'selector'        => '%%order_class%% .dswcp-subtotal',
			'sub_toggle'      => 'spacing',
			'default_padding' => '|||',
			'default_margin' => '||1em|'
		),
		'typography'               => array(
			'selector'        => '%%order_class%% .dswcp-dropdown-cart-header h2',
			'sub_toggle'      => 'title',
			'default_padding' => '|||',
			'default_margin'  => '|||'
		),
		'empty_message'               => array(
			'selector'        => '%%order_class%% .dswcp-cart-empty',
			'sub_toggle'      => 'spacing',
			'default_padding' => '|||',
			'default_margin'  => '|||'
		),
		'empty_message_p'               => array(
			'selector'        => '%%order_class%% .dswcp-cart-empty p',
			'sub_toggle'      => 'p',
			'toggle_slug'        => 'empty_message',
			'default_padding' => '|||',
			'default_margin'  => '|||'
		),
		'empty_message_icon'               => array(
			'selector'        => '%%order_class%% .dswcp-cart-empty-icon.et_pb_icon, %%order_class%% .dswcp-cart-empty-icon',
			'sub_toggle'      => 'icon',
			'toggle_slug'        => 'empty_message',
			'default_padding' => '|||',
			'default_margin'  => '|||'
		),
		'close_button'               => array(
			'selector'        => '%%order_class%% .dswcp-side-cart .dswcp-close, %%order_class%% .dswcp-dropdown-cart .dswcp-close',
			'sub_toggle'      => 'spacing',
			'toggle_slug'        => 'close_button',
			'default_padding' => '|||',
			'default_margin'  => '|||'
		),
	);

	public function init() {
		$this->name = esc_html__( 'Mini Cart', 'divi-shop-builder' );
		$this->icon_path        = plugin_dir_path(__FILE__) . 'icon.svg';
		$iconSvgs = [
			'typography_text'    => '',
			'typography_link'    => '',
			'padding_margins'    => '',
			'border'             => '',
			'background_colors'  => '',
			'typography_heading' => '',
			'settings' => '',
		];

		array_walk(
			$iconSvgs,
			function(&$value, $key) {
				$value = file_get_contents(AGS_divi_wc::$plugin_directory . 'includes/media/icons/' . $key . '.svg');
			}
		);

		$this->settings_modal_toggles = array(
			'general'	=> array(
				'toggles' => array(
					'type' => esc_html__( 'Type', 'divi-shop-builder' ),
					'minicart' => esc_html__( 'Mini Cart', 'divi-shop-builder' ),
					'dropdowncart' => esc_html__( 'Dropdown Cart', 'divi-shop-builder' ),
					'sidecart' => esc_html__( 'Side Cart', 'divi-shop-builder' ),
					'shared' => esc_html__( 'Shared Settings', 'divi-shop-builder' ),
					'cart_item' => esc_html__( 'Cart Item', 'divi-shop-builder' ),
					'buttons' => esc_html__( 'Buttons', 'divi-shop-builder' ),
					'empty_cart' => esc_html__( 'Empty Cart', 'divi-shop-builder' ),
				)
			),
			'advanced' => array (
				'toggles' => array(
					// Main
					'typography'            => array(
						'title'             => esc_html__('Typography', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'title'          => array(
								'name'     => 'title',
								'icon_svg' => $iconSvgs['typography_heading'],
							),
							'p'          => array(
								'name'     => 'p',
								'icon' => 'text',
							),
							'a'          => array(
								'name'     => 'a',
								'icon_svg' => $iconSvgs['typography_link'],
							),
							'count_label'          => array(
								'name'     => 'Count Label'
							)
						),
					),
					'cart_icon'            => array(
						'title'             => esc_html__('Mini Cart Icon', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'settings'          => array(
								'name'     => 'settings',
								'icon_svg' => $iconSvgs['settings'],
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
						),
					),
					'cart_icon_count'            => array(
						'title'             => esc_html__('Mini Cart Quantity', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'settings'          => array(
								'name'     => 'settings',
								'icon_svg' => $iconSvgs['settings'],
							),
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
					'cart_icon_amount'            => array(
						'title'             => esc_html__('Mini Cart Amount', 'divi-shop-builder'),
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
						),
					),

					// Dropdown
					'dropdown'            => array(
						'title'             => esc_html__('Dropdown Container', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'general'          => array(
								'name'     => 'general',
								'icon_svg' => $iconSvgs['settings'],
							),
							'typography'    => array(
								'name'     => 'typography',
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

					// Side Cart
					'side_cart'            => array(
						'title'             => esc_html__('Side Cart Container', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'general'          => array(
								'name'     => 'general',
								'icon_svg' => $iconSvgs['settings'],
							),
								'typography'    => array(
								'name'     => 'typography',
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

					// Shared
					'header' => array(
						'title'             => esc_html__('Dropdown and Side Cart Header', 'divi-shop-builder'),
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
					'product'            => array(
						'title'             => esc_html__('Product Wrapper', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'spacing'     => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
						),
					),
					'product_name'            => array(
						'title'             => esc_html__('Product Name', 'divi-shop-builder'),
					),
					'product_price'            => array(
						'title'             => esc_html__('Product Price', 'divi-shop-builder'),
					),
					'product_quantity'            => array(
						'title'             => esc_html__('Product Quantity', 'divi-shop-builder'),
					),
					'product_image'            => array(
						'title'             => esc_html__('Product Image', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'settings'          => array(
								'name'     => 'settings',
								'icon_svg' => $iconSvgs['settings'],
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
						),
					),
					'product_remove'            => array(
						'title'             => esc_html__('Product Remove Icon', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'settings'          => array(
								'name'     => 'settings',
								'icon_svg' => $iconSvgs['settings'],
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
						),
					),
					'product_subtotal'            => array(
						'title'             => esc_html__('Product Subtotal', 'divi-shop-builder'),
					),
					'subtotal'            => array(
						'title'             => esc_html__('Overall Subtotal', 'divi-shop-builder'),
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
							'spacing'    => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
						),
					),
					'footer' => array(
						'title'             => esc_html__('Dropdown and Side Cart Footer', 'divi-shop-builder'),
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
					'buttons'            => array(
						'title'             => esc_html__('Buttons', 'divi-shop-builder'),
					),
					'checkout'            => array(
						'title'             => esc_html__('Checkout Button', 'divi-shop-builder'),
					),
					'cart'            => array(
						'title'             => esc_html__('Cart Button', 'divi-shop-builder'),
					),
					'empty_message'            => array(
						'title'             => esc_html__('Empty Message', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'p'          => array(
								'name'     => 'p',
								'icon_svg' => $iconSvgs['typography_text'],
							),
							'icon'          => array(
								'name'     => 'icon',
								'icon' =>'background-image',
							),
							'background'          => array(
								'name'     => 'icon',
								'icon_svg' => $iconSvgs['background_colors'],
							),
							'spacing'          => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
						),
					),
					'close_button' => array(
						'title'             => esc_html__('Close Button', 'divi-shop-builder'),
						'tabbed_subtoggles' => true,
						'bb_icons_support'  => true,
						'sub_toggles'       => array(
							'general'          => array(
								'name'     => 'general',
								'icon_svg' => $iconSvgs['settings'],
							),
							'border'     => array(
								'name'     => 'border',
								'icon_svg' => $iconSvgs['border'],
							),
							'spacing'          => array(
								'name'     => 'spacing',
								'icon_svg' => $iconSvgs['padding_margins'],
							),
						),)
				)
			)
		);

		$this->main_css_element = '%%order_class%%';

		add_filter( 'dswcp_builder_js_data', array( $this, 'builder_js_data' ) );
		add_filter( 'et_builder_module_ags_woo_mini_cart_outer_wrapper_attrs', [$this, 'wrapper_attrs'] );
		add_filter( 'et_global_assets_list', [__CLASS__, 'maybe_load_icons'] );
		
		
		$this->advanced_fields = array(
			'link_options' => false,
			'text' => false,
			'fonts'          => array(
				'title' => array(
					'label'           => esc_html__( 'Title', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% h2',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '',
					),
					'line_height'     => array(
						'default' => '',
					),
					'font'            => array(
						'default' => '||||||||',
					),
					'tab_slug'       => 'advanced',
					'toggle_slug' => 'typography',
					'sub_toggle'  => 'title',
				),
				'typography' => array(
					'label'           => esc_html__( 'Texts', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%%',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '',
					),
					'line_height'     => array(
						'default' => '',
					),
					'font'            => array(
						'default' => '||||||||',
					),
					'tab_slug'       => 'advanced',
					'toggle_slug' => 'typography',
					'sub_toggle'  => 'p',
				),
				'main_links' => array(
					'label'           => esc_html__( 'Links', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% a:not(.et_pb_button)',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '',
					),
					'line_height'     => array(
						'default' => '',
					),
					'font'            => array(
						'default' => '||||||||',
					),
					'tab_slug'       => 'advanced',
					'toggle_slug' => 'typography',
					'sub_toggle'  => 'a',
				),
				'count_label' => array(
					'label'           => esc_html__( 'Count Label', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .dswcp-count-label',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '',
					),
					'line_height'     => array(
						'default' => '',
					),
					'font'            => array(
						'default' => '||||||||',
					),
					'tab_slug'       => 'advanced',
					'toggle_slug' => 'typography',
					'sub_toggle'  => 'count_label',
				),
				'cart_icon_count' => array(
					'label'           => esc_html__( 'Cart Icon Count', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% a.dswcp-cart-link .dswcp-count',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '',
					),
					'line_height'     => array(
						'default' => '',
					),
					'font'            => array(
						'default' => '||||||||',
					),
					'tab_slug'       => 'advanced',
					'toggle_slug' => 'cart_icon_count',
					'sub_toggle'  => 'p',
				),
				'cart_icon_amount' => array(
					'label'           => esc_html__( 'Amount', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% a.dswcp-cart-link .dswcp-amount',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '',
					),
					'line_height'     => array(
						'default' => '',
					),
					'font'            => array(
						'default' => '||||||||',
					),
					'tab_slug'       => 'advanced',
					'toggle_slug' => 'cart_icon_amount',
					'sub_toggle'  => 'p',
				),
				'product_name' => array(
					'label'           => esc_html__( 'Product Name', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% h3.dswcp-product-name',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '22px',
					),
					'line_height'     => array(
						'default' => '1em',
					),
					'toggle_slug'     => 'product_name',
					'font'            => array(
						'default' => '||||||||',
					),
				),
				'product_price' => array(
					'label'           => esc_html__( 'Product Price', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .dswcp-product-price',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '14px',
					),
					'line_height'     => array(
						'default' => '1.5em',
					),
					'toggle_slug'     => 'product_price',
					'font'            => array(
						'default' => '||||||||',
					)
				),
				'product_subtotal' => array(
					'label'           => esc_html__( 'Product Subtotal', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .dswcp-side-cart-items .dswcp-item-subtotal, %%order_class%% .dswcp-dropdown-cart-items .dswcp-item-subtotal',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '14px',
					),
					'line_height'     => array(
						'default' => '1.5em',
					),
					'toggle_slug'     => 'product_subtotal',
					'font'            => array(
						'default' => '||||||||',
					)
				),
				'subtotal' => array(
					'label'           => esc_html__( 'Overall Subtotal', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .dswcp-side-cart-footer .dswcp-subtotal, %%order_class%% .dswcp-dropdown-cart-footer .dswcp-subtotal',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '14px',
					),
					'line_height'     => array(
						'default' => '1.5em',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug'     => 'subtotal',
					'sub_toggle'        => 'p',
					'font'            => array(
						'default' => '||||||||',
					)
				),
				'empty_message' => array(
					'label'           => esc_html__( 'Empty Message', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .dswcp-cart-empty p',
						'text_align' => '%%order_class%% .dswcp-cart-empty',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '2em',
					),
					'line_height'     => array(
						'default' => '',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug'     => 'empty_message',
					'sub_toggle'        => 'p',
					'font'            => array(
						'default' => '||||||||',
					)
				),
				'dropdown' => array(
					'label'           => esc_html__( 'Dropdown', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .dswcp-dropdown-cart',
						'text_align' => '%%order_class%% .dswcp-dropdown-cart',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '',
					),
					'line_height'     => array(
						'default' => '',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug'     => 'dropdown',
					'sub_toggle'        => 'typography',
					'font'            => array(
						'default' => '||||||||',
					)
				),
				'side_cart' => array(
					'label'           => esc_html__( 'Dropdown', 'divi-shop-builder' ),
					'css'             => array(
						'main'      => '%%order_class%% .dswcp-side-cart',
						'text_align' => '%%order_class%% .dswcp-side-cart',
						'important' => 'all',
					),
					'font_size'       => array(
						'default' => '',
					),
					'line_height'     => array(
						'default' => '',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug'     => 'side_cart',
					'sub_toggle'        => 'typography',
					'font'            => array(
						'default' => '||||||||',
					)
				),
			),
			'button'         => array(
				'buttons' => array(
					'label'          => esc_html__( 'All Buttons', 'divi-shop-builder' ),
					'css'            => array(
						'main'         => '%%order_class%%.et_pb_module .et_pb_button, %%order_class%% .et_pb_button',
						'important'    => 'all',
					),
					'box_shadow'     => array(
						'css' => array(
							'main'      => '%%order_class%%.et_pb_module .et_pb_button, %%order_class%% .et_pb_button',
							'important' => true,
						),
					),
					'margin_padding' => array(
						'css' => array(
							'important' => 'all',
						),
					),
					'tab_slug'       => 'advanced',
					'toggle_slug' => 'buttons',
				),
				'cart' => array(
					'label'          => esc_html__( 'Cart Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'cart',
					'css'            => array(
						'main'         => '%%order_class%% .dswcp-side-cart-footer .dswcp-buttons .dswcp-btn-cart, %%order_class%% .dswcp-dropdown-cart-footer .dswcp-buttons .dswcp-btn-cart.et_pb_button',
						'important'    => 'all',
					),
					'box_shadow'     => array(
						'css' => array(
							'main'      => '%%order_class%% .dswcp-side-cart-footer .dswcp-buttons .dswcp-btn-cart, %%order_class%% .dswcp-dropdown-cart-footer .dswcp-buttons .dswcp-btn-cart.et_pb_button',
							'important' => true,
						),
					),
					'margin_padding' => array(
						'css' => array(
							'important' => 'all',
						),
					),
				),
				'checkout_button' => array(
					'label'          => esc_html__( 'Checkout Button', 'divi-shop-builder' ),
					'toggle_slug'     => 'checkout',
					'css'            => array(
						'main'         => '%%order_class%% .dswcp-side-cart-footer .dswcp-buttons .dswcp-btn-checkout, %%order_class%% .dswcp-dropdown-cart-footer .dswcp-buttons .dswcp-btn-checkout',
						'important'    => 'all',
					),
					'box_shadow'     => array(
						'css' => array(
							'main'      => '%%order_class%% .dswcp-side-cart-footer .dswcp-buttons .dswcp-btn-checkout,%%order_class%% .dswcp-dropdown-cart-footer .dswcp-buttons .dswcp-btn-checkout',
							'important' => true,
						),
					),
					'margin_padding' => array(
						'css' => array(
							'important' => 'all',
						),
					),
				),
			),
			'form_field'     => array(
				'quantity'         => array(
					'label'           => esc_html__( 'Product Quantity', 'divi-shop-builder' ),
					'css'             => array(
						'main'                   => '%%order_class%% .dswcp-quantity',
						'background_color'       => '%%order_class%% .dswcp-quantity',
						'background_color_hover' => '%%order_class%% .dswcp-quantity:hover',
						'focus_background_color' => '%%order_class%% .dswcp-quantity:focus',
						'form_text_color'        => '%%order_class%% .dswcp-quantity',
						'form_text_color_hover'  => '%%order_class%% .dswcp-quantity',
						'focus_text_color'       => '%%order_class%% .dswcp-quantity',
						'placeholder_focus'      => '%%order_class%% .dswcp-quantity:focus::-webkit-input-placeholder, %%order_class%% .dswcp-quantity:focus::-moz-placeholder, %%order_class%% .dswcp-quantity:focus:-ms-input-placeholder',
						'padding'                => '%%order_class%% .dswcp-quantity',
						'margin'                 => '%%order_class%% .dswcp-quantity',
						'important'              => array(
							'background_color',
							'background_color_hover',
							'focus_background_color',
							'form_text_color',
							'form_text_color_hover',
							'text_color',
							'focus_text_color',
							'padding',
							'margin',
						),
					),
					'box_shadow'      => array(
						'name'              => 'quantity',
						'css'               => array(
							'main' => '%%order_class%% .dswcp-quantity',
							'important' => 'all'
						),
						'default_on_fronts' => array(
							'color'    => '',
							'position' => '',
						),
					),
					'border_styles'   => array(
						'quantity'       => array(
							'name'         => 'quantity',
							'css'          => array(
								'main'      => array(
									'border_radii'  => '%%order_class%% .dswcp-quantity',
									'border_styles' => '%%order_class%% .dswcp-quantity',
								),
								'important' => 'all',
							),
							'defaults'        => array(
								'border_radii'  => 'off||||',
								'border_styles' => array(
									'width' => '',
									'style' => '',
									'color' => ''
								),
							)
						),
						'quantity_focus' => array(
							'name'         => 'quantity_focus',
							'css'          => array(
								'main'      => array(
									'border_radii'  => '%%order_class%% .dswcp-quantity:focus',
									'border_styles' => '%%order_class%% .dswcp-quantity:focus',
								),
								'important' => 'all',
							),
							'defaults'        => array(
								'border_radii'  => 'off||||',
								'border_styles' => array(
									'width' => '',
									'style' => '',
									'color' => ''
								),
							),
							'label_prefix' => esc_html__( 'Fields Focus', 'divi-shop-builder' ),
						),
					),
					'font_field'      => array(
						'css'         => array(
							'main'      => array(
								'%%order_class%% .dswcp-quantity',
							),
							'hover'     => array(
								'%%order_class%% .dswcp-quantity:hover',
								'%%order_class%% .dswcp-quantity:hover::-webkit-input-placeholder',
								'%%order_class%% .dswcp-quantity:hover::-moz-placeholder',
								'%%order_class%% .dswcp-quantity:hover:-ms-input-placeholder',
							),
							'important' => 'all',
						),
						'font_size'   => array(
							'default' => '14px',
						),
						'line_height' => array(
							'default' => '1em',
						),
					),
					'margin_padding'  => array(
						'css' => array(
							'main'      => '%%order_class%% .dswcp-quantity',
							'important' => array( 'custom_padding' ),
						),
					),
					'toggle_slug'     => 'product_quantity',
				),
			),
			'borders' => array(
				'default' => array(),
				'cart_icon_count' => array(
					'label'           => esc_html__( 'Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% .dswcp-count',
							'border_radii' 	=> '%%order_class%% .dswcp-count'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'on|50%|50%|50%|50%',
						'border_styles' => array(
							'width' => '',
							'style' => 'none',
							'color' => '',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'cart_icon_count',
					'sub_toggle'  => 'border',
				),
				'dropdown' => array(
					'label'           => esc_html__( 'Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% .dswcp-dropdown-cart',
							'border_radii' 	=> '%%order_class%% .dswcp-dropdown-cart'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'off||||',
						'border_styles' => array(
							'width' => '1px',
							'style' => 'solid',
							'color' => '#ccc',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'dropdown',
					'sub_toggle'  => 'border',
				),
				'side_cart' => array(
					'label'           => esc_html__( 'Side Cart Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% .dswcp-side-cart',
							'border_radii' 	=> '%%order_class%% .dswcp-side-cart'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'off||||',
						'border_styles' => array(
							'width' => '1px',
							'style' => 'solid',
							'color' => '#ccc',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'side_cart',
					'sub_toggle'  => 'border',
				),
				'header' => array(
					'label'           => esc_html__( 'Header Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% .dswcp-side-cart-header',
							'border_radii' 	=> '%%order_class%% .dswcp-side-cart-header'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'off||||',
						'border_styles' => array(
							'width' => '',
							'style' => 'none',
							'color' => '',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'header',
					'sub_toggle'  => 'border',
				),
				'footer' => array(
					'label'           => esc_html__( 'Footer Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% .dswcp-side-cart-footer,%%order_class%% .dswcp-dropdown-cart-footer ',
							'border_radii' 	=> '%%order_class%% .dswcp-dropdown-cart-footer'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'off||||',
						'border_styles' => array(
							'width' => '',
							'style' => 'none',
							'color' => '',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'footer',
					'sub_toggle'  => 'border',
				),
				'product' => array(
					'label'           => esc_html__( 'Product Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% .dswcp-dropdown-cart-item, %%order_class%% .dswcp-side-cart-item',
							'border_radii' 	=> '%%order_class%% .dswcp-dropdown-cart-item, %%order_class%% .dswcp-side-cart-item'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'off||||',
						'border_styles' => array(
							'width' => '',
							'style' => 'none',
							'color' => '',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'product',
					'sub_toggle'  => 'border',
				),
				'product_image' => array(
					'label'           => esc_html__( 'Product Image Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% .dswcp-image-container img',
							'border_radii' 	=> '%%order_class%% .dswcp-image-container img'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'off||||',
						'border_styles' => array(
							'width' => '1px',
							'style' => 'solid',
							'color' => '#E8E8E8',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'product_image',
					'sub_toggle'  => 'border',
				),
				'product_remove' => array(
					'label'           => esc_html__( 'Product Remove Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% .dswcp-remove',
							'border_radii' 	=> '%%order_class%% .dswcp-remove'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'off||||',
						'border_styles' => array(
							'width' => '',
							'style' => 'none',
							'color' => '',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'product_remove',
					'sub_toggle'  => 'border',
				),
				'subtotal' => array(
					'label'           => esc_html__( 'Subtotal Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% .dswcp-side-cart-footer .dswcp-subtotal, %%order_class%% .dswcp-dropdown-cart-footer .dswcp-subtotal',
							'border_radii' 	=> '%%order_class%% .dswcp-side-cart-footer .dswcp-subtotal, %%order_class%% .dswcp-dropdown-cart-footer .dswcp-subtotal'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'off||||',
						'border_styles' => array(
							'width' => '',
							'style' => 'none',
							'color' => '',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'subtotal',
					'sub_toggle'  => 'border',
				),
				'empty_message_icon' => array(
					'label'           => esc_html__( 'Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% .dswcp-cart-empty-icon.et_pb_icon, %%order_class%% .dswcp-cart-empty-icon',
							'border_radii' => '%%order_class%% .dswcp-cart-empty-icon.et_pb_icon, %%order_class%% .dswcp-cart-empty-icon'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'off||||',
						'border_styles' => array(
							'width' => '',
							'style' => 'none',
							'color' => '',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'empty_message',
					'sub_toggle'  => 'icon',
				),
				'close_button' => array(
					'label'           => esc_html__( 'Close Button Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% .dswcp-side-cart .dswcp-close, %%order_class%% .dswcp-dropdown-cart .dswcp-close',
							'border_radii' => '%%order_class%% .dswcp-side-cart .dswcp-close, %%order_class%% .dswcp-dropdown-cart .dswcp-close'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'off||||',
						'border_styles' => array(
							'width' => '',
							'style' => 'none',
							'color' => '',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'close_button',
					'sub_toggle'  => 'border',
				),
				'cart_icon' => array(
					'label'           => esc_html__( 'Cart Icon Border', 'divi-shop-builder' ),
					'css'             => array(
						'main' 		  => array(
							'border_styles' => '%%order_class%% .dswcp-mini-cart-icon',
							'border_radii' => '%%order_class%% .dswcp-mini-cart-icon'
						),
						'important'   => 'all',
					),
					'defaults'  => array(
						'border_radii'  => 'off||||',
						'border_styles' => array(
							'width' => '',
							'style' => 'none',
							'color' => '',
						),
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'cart_icon',
					'sub_toggle'  => 'border',
				),
			),
			'box_shadow'     => array(
				'cart_icon_count'           => array(
					'css'         => array(
						'main' => '%%order_class%% .cart_icon_count',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'cart_icon_count',
					'sub_toggle'  => 'border',
				),
				'dropdown'           => array(
					'css'         => array(
						'main' => '%%order_class%% .dswcp-dropdown-cart',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'dropdown',
					'sub_toggle'  => 'border',
				),
				'side_cart'           => array(
					'css'         => array(
						'main' => '%%order_class%% .dswcp-side-cart',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'side_cart',
					'sub_toggle'  => 'border',
				),
				'header'           => array(
					'css'         => array(
						'main' => '%%order_class%% .dswcp-side-cart-header, %%order_class%% .dswcp-dropdown-cart-header',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'header',
					'sub_toggle'  => 'border',
				),
				'footer'           => array(
					'css'         => array(
						'main' => '%%order_class%% .dswcp-side-cart-footer, %%order_class%% .dswcp-dropdown-cart-footer',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'footer',
					'sub_toggle'  => 'border',
				),
				'product_image'           => array(
					'css'         => array(
						'main' => '%%order_class%% .dswcp-image-container',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'product_image',
					'sub_toggle'  => 'border',
				),
				'product_remove'           => array(
					'css'         => array(
						'main' => '%%order_class%% .dswcp-remove',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'product_remove',
					'sub_toggle'  => 'border',
				),
				'empty_message_icon'           => array(
					'css'         => array(
						'main' => '%%order_class%% .dswcp-cart-empty .et_pb_icon, %%order_class%% .dswcp-cart-empty .dswcp-cart-icon',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'empty_message',
					'sub_toggle'  => 'icon',
				),
				'cart_icon'           => array(
					'css'         => array(
						'main' => '%%order_class%% .dswcp-mini-cart-icon',
					),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'cart_icon',
					'sub_toggle'  => 'border',
				),
			),
			'background' => false,
			'position_fields' => array(
				'css' => array(
					'main' => "%%order_class%%:not(.dswcp-side-cart)",
				),
			),
		);
	}
	
	public static function maybe_load_icons($assets) {
		if (!empty($assets['et_icons_all']) && !empty($assets['et_icons_fa'])) {
			return $assets;
		}
		
		$content = \Feature\ContentRetriever\ET_Builder_Content_Retriever::init()->get_entire_page_content( get_post( ET_Builder_Element::get_current_post_id() ) );
		$content .= self::get_current_page_menu_item_content();
		
		if (empty($assets['et_icons_all']) && et_pb_check_if_post_contains_divi_font_icon($content)) {
			$assets['et_icons_all'] = ['css' => et_get_dynamic_assets_path().'/css/icons_all.css'];
			unset($assets['et_icons_base'], $assets['et_icons_social']);
		}
		
		if (empty($assets['et_icons_fa']) && et_pb_check_if_post_contains_fa_font_icon($content)) {
			$assets['et_icons_fa'] = ['css' => et_get_dynamic_assets_path().'/css/icons_fa_all.css'];
		}
		
		return $assets;
	}
	
	public static function get_menus_with_mini_cart() {
		$menus = [];
		$menuItems = get_posts([
			'post_type' => 'nav_menu_item',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'ignore_sticky_posts' => true,
			'meta_key' => '_dswcp_is_mini_cart',
			'meta_value' => '1',
			'fields' => 'ids'
		]);
		foreach ($menuItems as $menuItemId) {
			$menu = wp_get_object_terms($menuItemId, 'nav_menu', ['fields' => 'ids']);
			if ($menu) {
				$menus[$menuItemId] = current($menu);
			}
		}
		return $menus;
	}
	
	public static function get_current_page_menu_item_content() {
		global $post;
		
		// Get menus with the mini cart men item
		$allMenus = self::get_menus_with_mini_cart();
		if (empty($allMenus)) {
			return '';
		}
		
		// Check which menus are assigned and used
		$assignedMenus = get_nav_menu_locations();
		$tbLayouts = et_theme_builder_get_template_layouts();
		if (!empty($tbLayouts[ET_THEME_BUILDER_HEADER_LAYOUT_POST_TYPE]['enabled']) && !empty($tbLayouts[ET_THEME_BUILDER_HEADER_LAYOUT_POST_TYPE]['override'])) {
			unset($tbLayouts['primary-menu']);
			unset($tbLayouts['secondary-menu']);
		}
		if (!empty($tbLayouts[ET_THEME_BUILDER_FOOTER_LAYOUT_POST_TYPE]['enabled']) && !empty($tbLayouts[ET_THEME_BUILDER_FOOTER_LAYOUT_POST_TYPE]['override'])) {
			unset($tbLayouts['footer-menu']);
		}
		$hasMenu = (bool) array_intersect(array_values($assignedMenus), $allMenus);
		
		if (!$hasMenu) {
		
			// Check which menus are used in page content via the et_pb_menu module
			// see Divi/includes/builder/feature/dynamic-assets/class-dynamic-assets.php
			$content = \Feature\ContentRetriever\ET_Builder_Content_Retriever::init()->get_entire_page_content( is_singular() ? $post : get_post( ET_Builder_Element::get_current_post_id() ) );
			preg_match_all( '/'.get_shortcode_regex(['et_pb_menu']).'/', $content, $results );
			foreach ($results as $result) {
				$resultAtts = shortcode_parse_atts($result[3]);
				if (isset($resultAtts['menu_id']) && in_array($resultAtts['menu_id'], $allMenus)) {
					$hasMenu = true;
					break;
				}
			}
			
		}
			
		if (!$hasMenu) {
			return '';
		}
		
		$layout = get_posts([
			'post_type' => 'et_pb_layout',
			'meta_key' => '_dswcp_is_mini_cart',
			'meta_compare' => 'EXISTS',
			'posts_per_page' => 1,
			'ignore_sticky_posts' => true
		]);
		
		return $layout ? current($layout)->post_content : '';
	}
	
	public function wrapper_attrs($attrs) {
		if ($this->props['action_click'] == 'sidecart') {
			$attrs['data-side-cart-id'] = ET_Builder_Element::get_module_order_class('ags_woo_mini_cart').'__side_cart';
		}
		if ($this->props['action_hover'] != 'none') {
			$attrs['data-action-hover'] = $this->props['action_hover']; // attr value escaped by et_html_attrs()
		}
		if ($this->props['action_click'] != 'cartpage') {
			$attrs['data-action-click'] = $this->props['action_click']; // attr value escaped by et_html_attrs()
		}
		if ($this->props['action_click_mobile'] != 'cartpage') {
			$attrs['data-action-click-mobile'] = $this->props['action_click_mobile']; // attr value escaped by et_html_attrs()
		}
		$attrs['data-update-cart-nonce'] = wp_create_nonce('dswcp-update-cart');
		$attrs['data-update-cart-config'] = json_encode(array_intersect_key($this->props, [
			'action_click' => 1,
			'action_hover' => 1,
			'icon' => 1,
			'label' => 1,
			'show_amount' => 1,
			'amount_position' => 1,
			'show_count' => 1,
			'show_count_zero' => 1,
			'count_title_plural' => 1,
			'display_cart_title' => 1,
			'cart_title' => 1,
			'show_images' => 1,
			'show_quantity' => 1,
			'remove_title' => 1,
			'remove_icon' => 1,
			'subtotal_text' => 1,
			'footer_info_text' => 1,
			'cart_btn_text' => 1,
			'checkout_btn_text' => 1,
			'shop_btn_text' => 1,
			'close_title' => 1,
			'close_icon' => 1,
			'quantity_label' => 1,
			'empty_icon' => 1,
			'show_empty_icon' => 1,
			'empty_custom_icon' => 1,
			'empty_text' => 1,
			'count_position' => 1,
			'show_product_quantity' => 1,
			'show_product_subtotal' => 1,
			'show_quantity_label' => 1,
			'quantity_label_position' => 1,
			'product_subtotal_text' => 1,
		]));
		$attrs['data-update-cart-config'] = base64_encode($attrs['data-update-cart-config']).'|'.hash_hmac('sha256', $attrs['data-update-cart-config'].floor(time()/7200), $this->get_config_key());
		
		$attrs['data-loading-text'] = $this->props['loading_text']; // attr value escaped by et_html_attrs()
		
		return $attrs;
	}
	
	public function get_config_key() {
		$key = get_option('dswcp_mini_cart_config_key');
		if (empty($key)) {
			$key = function_exists('random_bytes') ? random_bytes(64) : wp_generate_password(64, true, true);
			update_option('dswcp_mini_cart_config_key', base64_encode($key));
			return $key;
		}
		return base64_decode($key);
	}

	public function get_fields(){
		$fields = [

			// General Tab
			'_preview' => [
				'label'           => esc_html__( 'Preview', 'divi-shop-builder' ),
				'type'            => 'select',
				'options' 		  => array(
					'none' 	      => esc_html__( 'Mini cart only', 'divi-shop-builder' ),
					'dropdowncart' => esc_html__( 'Show dropdown cart', 'divi-shop-builder' ),
					'dropdowncart_empty' => esc_html__( 'Show dropdown cart (empty)', 'divi-shop-builder' ),
					'sidecart' => esc_html__( 'Show side cart', 'divi-shop-builder' ),
					'sidecart_empty' => esc_html__( 'Show side cart (empty)', 'divi-shop-builder' )
				),
				'option_category' => 'configuration',
				'default'         => 'none',
				'toggle_slug'     => 'type'
			],
			'ajax_only' => [
				'label'           => esc_html__( 'Load via Ajax', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Enable this to make the cart state and contents load via ajax after the rest of the page has loaded (helps with caching).', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Yes', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'No', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'off',
				'toggle_slug'     => 'type'
			],
			'action_hover' => [
				'label'           => esc_html__( 'Hover/Focus Action', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Specify what to do when hovering over the mini cart (and when it is in focus).', 'divi-shop-builder' ),
				'type'            => 'select',
				'options' 		  => array(
					'none' 	      => esc_html__( 'Do nothing', 'divi-shop-builder' ),
					'dropdowncart' => esc_html__( 'Show dropdown cart', 'divi-shop-builder' )
				),
				'option_category' => 'configuration',
				'default'         => 'dropdowncart',
				'toggle_slug'     => 'type'
			],
			'action_click' => [
				'label'           => esc_html__( 'Click Action', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Specify what to do when clicking the mini cart.', 'divi-shop-builder' ),
				'type'            => 'select',
				'options' 		  => array(
					'cartpage' 	      => esc_html__( 'Go to the cart page', 'divi-shop-builder' ),
					'dropdowncart' => esc_html__( 'Show dropdown cart', 'divi-shop-builder' ),
					'sidecart' => esc_html__( 'Open side cart', 'divi-shop-builder' )
				),
				'option_category' => 'configuration',
				'default'         => 'sidecart',
				'toggle_slug'     => 'type'
			],
			'action_click_mobile' => [
				'label'           => esc_html__( 'Click Action - Mobile', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Specify what to do when clicking the mini cart on mobile.', 'divi-shop-builder' ),
				'type'            => 'select',
				'options' 		  => array(
					'cartpage' 	      => esc_html__( 'Go to the cart page', 'divi-shop-builder' ),
					'sidecart' => esc_html__( 'Open side cart', 'divi-shop-builder' )
				),
				'option_category' => 'configuration',
				'default'         => 'sidecart',
				'toggle_slug'     => 'type'
			],
			'icon'          => [
				'label'           => esc_html__( 'Icon', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Select the icon to use as the cart icon.', 'divi-shop-builder' ),
				'type'            => 'DSLayoutMultiselect-DSB',
				'option_category' => 'basic_option',
				'options'         => array(
					'1' => array(
						'title'   => __( 'Icon 1', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_1' )
					),
					'2' => array(
						'title'   => __( 'Icon 2', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_2' )
					),
					'3' => array(
						'title'   => __( 'Icon 3', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_3' )
					),
					'4' => array(
						'title'   => __( 'Icon 4', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_4' )
					),
					'5' => array(
						'title'   => __( 'Icon 5', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_5' )
					),
					'6' => array(
						'title'   => __( 'Icon 6', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_6' )
					),
					'7' => array(
						'title'   => __( 'Icon 7', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_7' )
					),
					'8' => array(
						'title'   => __( 'Icon 8', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_8' )
					),
					'9' => array(
						'title'   => __( 'Icon 9', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_9' )
					),
					'10' => array(
						'title'   => __( 'Icon 10', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_10' )
					),
					'11' => array(
						'title'   => __( 'Icon 11', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_11' )
					),
					'12' => array(
						'title'   => __( 'Icon 12', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_12' )
					),
					'13' => array(
						'title'   => __( 'Icon 13', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_13' )
					),
					'14' => array(
						'title'   => __( 'Icon 14', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_14' )
					),
					'15' => array(
						'title'   => __( 'Icon 15', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_15' )
					),
				),
				'default'         => '1',
				'customClass'     => 'dswcp-mini-cart-icon-select',
				'toggle_slug'     => 'minicart',
			],
			'show_label' => [
				'label'           => esc_html__( 'Show Label', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Enable this to make the label text visible.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Show', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Hide', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'off',
				'toggle_slug'     => 'minicart'
			],
			'label'          => [
				'label'           => esc_html__( 'Label', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Enter text to use as a label for the mini cart.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'toggle_slug'     => 'minicart',
				'default'         => 'View Cart',
				'show_if'         => [
					'show_label' => 'on'
				]
			],
			'show_count' => [
				'label'           => esc_html__( 'Show Number of Items', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Show or hide the number of items on the cart icon.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Show', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Hide', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'on',
				'toggle_slug'     => 'minicart'
			],
			'show_count_zero' => [
				'label'           => esc_html__( 'Show Zero Items Count', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Show the number of items on the cart icon even when it is zero.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Show', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Hide', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'off',
				'toggle_slug'     => 'minicart',
				//				'show_if' => [
				//					'show_count' => 'on',
				//					'show_quantity_label' => 'on',
				//				]
			],
			'count_title_singular'          => [
				'label'           => esc_html__( 'Number of Items Text (Singular)', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Enter text to use in the title attribute for the product count when there is a single product in the cart.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'toggle_slug'     => 'minicart',
				'default'         => esc_html__('1 item in cart', 'divi-shop-builder' ),
//				'show_if' => [
//					'show_count' => 'on',
//					'show_quantity_label' => 'on',
//				]
			],
			'count_title_plural'          => [
				'label'           => esc_html__( 'Number of Items Text (Plural)', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Enter text to use in the title attribute for the product count when there are multiple products in the cart. %d is replaced with the number of items.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'toggle_slug'     => 'minicart',
				'default'         => esc_html__('%d items in cart', 'divi-shop-builder' ),
		//				'show_if' => [
		//					'show_count' => 'on',
		//					'show_quantity_label' => 'on',
		//				]
			],
			'show_amount' => [
				'label'           => esc_html__( 'Show Amount', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Show or hide the total cart amount next to the cart icon.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Show', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Hide', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'off',
				'toggle_slug'     => 'minicart'
			],
			'amount_position' => [
				'label'           => esc_html__( 'Amount Position', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Specify where to show the amount.', 'divi-shop-builder' ),
				'type'            => 'select',
				'options' 		  => array(
					'before' 	      => esc_html__( 'Before icon', 'divi-shop-builder' ),
					'after' 	      => esc_html__( 'After icon', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'before',
				'toggle_slug'     => 'minicart',
				'show_if' => [
					'show_amount' => 'on'
				]
			],
			'show_quantity_label' => [
				'label'           => esc_html__( 'Show Quantity Field Label', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Set whether or not the quantity field label is visible.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Show', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Hide', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'off',
				'toggle_slug'     => 'minicart'
			],
			'quantity_label_position' => [
				'label'           => esc_html__( 'Quantity Label Position', 'divi-shop-builder' ),
				'type'            => 'select',
				'options' 		  => array(
					'before'      => esc_html__( 'Before Icon', 'divi-shop-builder' ),
					'after' 	  => esc_html__( 'After Icon', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'after',
				'toggle_slug'     => 'minicart',
				'show_if'         => [
					'show_count' => 'on'
				]
			],
			'display_cart_title' => [
				'label'           => esc_html__( 'Title', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Show this title above the side cart.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Show', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Hide', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'on',
				'toggle_slug'     => 'shared'
			],
			'cart_title' => [
				'label'           => esc_html__( 'Title', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Show this title above the side cart.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__('Cart', 'divi-shop-builder' ),
				'toggle_slug'     => 'shared',
				'show_if'         => array ('display_cart_title' => 'on')
			],

			'show_empty_icon'          => [
				'label'           => esc_html__( 'Cart Empty Message Icon', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Select the icon to show above the empty cart message.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Show', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Hide', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'class'           => ['et-pb-font-icon'],
				'toggle_slug'     => 'empty_cart',
				'default'         => 'off'
			],

			'empty_custom_icon'          => [
				'label'           => esc_html__( 'Icon', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Select the icon to use in empty cart view.', 'divi-shop-builder' ),
				'type'            => 'DSLayoutMultiselect-DSB',
				'option_category' => 'basic_option',
				'options'         => array(
					'1' => array(
						'title'   => __( 'Icon 1', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_1' )
					),
					'2' => array(
						'title'   => __( 'Icon 2', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_2' )
					),
					'3' => array(
						'title'   => __( 'Icon 3', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_3' )
					),
					'4' => array(
						'title'   => __( 'Icon 4', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_4' )
					),
					'5' => array(
						'title'   => __( 'Icon 5', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_5' )
					),
					'6' => array(
						'title'   => __( 'Icon 6', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_6' )
					),
					'7' => array(
						'title'   => __( 'Icon 7', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_7' )
					),
					'8' => array(
						'title'   => __( 'Icon 8', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_8' )
					),
					'9' => array(
						'title'   => __( 'Icon 9', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_9' )
					),
					'10' => array(
						'title'   => __( 'Icon 10', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_10' )
					),
					'11' => array(
						'title'   => __( 'Icon 11', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_11' )
					),
					'12' => array(
						'title'   => __( 'Icon 12', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_12' )
					),
					'13' => array(
						'title'   => __( 'Icon 13', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_13' )
					),
					'14' => array(
						'title'   => __( 'Icon 14', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_14' )
					),
					'15' => array(
						'title'   => __( 'Icon 15', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart/cart_icon_15' )
					),
				),
				'default'         => '1',
				'customClass'     => 'dswcp-mini-cart-icon-select',
				'toggle_slug'     => 'empty_cart',
				'show_if'   => array (
					'show_empty_icon' => 'off'
				)
			],

			'empty_icon'          => [
				'label'           => esc_html__( 'Cart Empty Message Icon', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Select the icon to show above the empty cart message.', 'divi-shop-builder' ),
				'type'            => 'select_icon',
				'option_category' => 'configuration',
				'class'           => ['et-pb-font-icon'],
				'toggle_slug'     => 'empty_cart',
				'default'         => html_entity_decode('&#xe015;'),
				'show_if'   => array (
					'show_empty_icon' => 'on'
				)
			],
			'empty_text' => [
				'label'           => esc_html__( 'Cart Empty Message', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'This text will be shown when the cart is empty.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__('Your cart is empty.', 'divi-shop-builder' ),
				'toggle_slug'     => 'empty_cart'
			],
			'close_icon'          => [
				'label'           => esc_html__( 'Close Icon', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Select the icon to use as the close icon.', 'divi-shop-builder' ),
				'type'            => 'select_icon',
				'option_category' => 'configuration',
				'class'           => ['et-pb-font-icon'],
				'toggle_slug'     => 'sidecart',
				'default'         => html_entity_decode('&#x4d;')
			],
			'close_title' => [
				'label'           => esc_html__( 'Close Title', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'This text will be set as the title attribute of the close button.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__('Close', 'divi-shop-builder' ),
				'toggle_slug'     => 'sidecart'
			],
			'show_images' => [
				'label'           => esc_html__( 'Show Product Images', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Enable/disable showing images for the products in the cart.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Show', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Hide', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'on',
				'toggle_slug'     => 'cart_item'
			],
			'show_quantity' => [
				'label'           => esc_html__( 'Show Quantity Inputs', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Enable/disable showing the quantity field for items in the cart.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Show', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Hide', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'on',
				'toggle_slug'     => 'cart_item'
			],
			'show_product_quantity' => [
				'label'           => esc_html__( 'Show Quantity', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Enable/disable showing the number of items in the cart for each product.', 'divi-shop-builder' ),
				'type'            => 'select',
				'options'         => array(
					'hide'        => esc_html__( 'Don\'t show', 'divi-shop-builder' ),
					'after_price' => esc_html__( 'Display After Price', 'divi-shop-builder' ),
					'after_title' => esc_html__( 'Display After Title', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'after_price',
				'toggle_slug'     => 'cart_item'
			],
			'show_product_subtotal' => [
				'label'           => esc_html__( 'Show Product Subtotal', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Enable/disable showing the subtotal for items in the cart.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Show', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Hide', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'on',
				'toggle_slug'     => 'cart_item'
			],
			'product_subtotal_text' => [
				'label'           => esc_html__( 'Product Subtotal Text', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Text displayed before subtotal for items in the cart.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => 'Subtotal: ',
				'toggle_slug'     => 'cart_item',
				'show_if'   => ['show_product_subtotal' => 'on']
			],
			'quantity_label' => [
				'label'           => esc_html__( 'Quantity Field Label', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Enter text to label the quantity field.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__( 'Quantity:', 'divi-shop-builder' ),
				'toggle_slug'     => 'cart_item',
				'show_if' => [
					'show_quantity_label' => 'on'
				]
			],
			'remove_icon'          => [
				'label'           => esc_html__( 'Remove Item Icon', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Select the icon to use as the remove item icon.', 'divi-shop-builder' ),
				'type'            => 'select_icon',
				'option_category' => 'configuration',
				'class'           => ['et-pb-font-icon'],
				'toggle_slug'     => 'cart_item',
				'default'         => 'M'
			],
			'remove_title' => [
				'label'           => esc_html__( 'Remove Item Title', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'This text will be set as the title attribute of the remove item button.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__('Remove item', 'divi-shop-builder' ),
				'toggle_slug'     => 'cart_item'
			],
			'subtotal_text' => [
				'label'           => esc_html__( 'Subtotal Text', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'This text will be shown to the left of the subtotal.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__('Subtotal', 'divi-shop-builder' ),
				'toggle_slug'     => 'cart_item'
			],
			'footer_info_text' => [
				'label'           => esc_html__( 'Footer Info Text', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'This text will be shown on the below the buttons in the side cart footer.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__('Before shipping, tax, and discounts', 'divi-shop-builder' ),
				'toggle_slug'     => 'shared'
			],
			'cart_btn_text' => [
				'label'           => esc_html__( 'Cart Button Text', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'This text will be shown on the cart button.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__('Go to Cart', 'divi-shop-builder' ),
				'toggle_slug'     => 'buttons'
			],
			'checkout_btn_text' => [
				'label'           => esc_html__( 'Checkout Button Text', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'This text will be shown on the checkout button.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__('Checkout', 'divi-shop-builder' ),
				'toggle_slug'     => 'buttons'
			],
			'shop_btn_text' => [
				'label'           => esc_html__( 'Shop Button Text', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'This text will be shown on the shop button when the cart is empty.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__('Browse Products', 'divi-shop-builder' ),
				'toggle_slug'     => 'buttons'
			],
			'loading_text' => [
				'label'           => esc_html__( 'Loading Text', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'This text will be shown when the cart is reloading.', 'divi-shop-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'default'         => esc_html__('Loading...', 'divi-shop-builder' ),
				'toggle_slug'     => 'shared'
			],


			// Design

			// Icon

			'float_right'               => array(
				'label'            => esc_html__( 'Float Right', 'et_builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'On', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Off', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'off',
				'tab_slug'    => 'advanced',
				'toggle_slug'     => 'cart_icon',
				'sub_toggle'      => 'settings'
			),

			'cart_icon_col'         => array(
				'label'       => esc_html__('Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'cart_icon',
				'sub_toggle'  => 'settings',
			),
			'cart_icon_bg'         => array(
				'label'       => esc_html__('Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'cart_icon',
				'sub_toggle'  => 'settings',
			),
			'cart_icon_size' => array(
				'label'          => __( 'Icon Size', 'divi-shop-builder' ),
				'type'           => 'range',
				'allowed_units'  => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
				'validate_unit'  => true,
				'default_unit'   => 'px',
				'default'       => '24px',
				'mobile_options' => true,
				'responsive'     => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'     => 'cart_icon',
				'sub_toggle'      => 'settings',
			),


			'cart_icon_line-height' => array(
				'label'          => __( 'Icon Line Height', 'divi-shop-builder' ),
				'type'           => 'range',
				'allowed_units'  => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
				'validate_unit'  => true,
				'default_unit'   => 'px',
				'default'       => '32px',
				'mobile_options' => true,
				'responsive'     => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'     => 'cart_icon',
				'sub_toggle'      => 'settings',
			),
			// Count
			'cart_icon_count_position' => array(
				'label'           => __( 'Position', 'divi-shop-builder' ),
				'description'     => esc_html__( 'Choose the positioning of the tooltip', 'ds-advanced-pricing-table-for-divi' ),
				'type'            => 'DSLayoutMultiselect-DSB',
				'option_category' => 'basic_option',
				'options'         => array(
					'left' => array(
						'title'   => __( 'Left', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart-left' )
					),
					'right' => array(
						'title'   => __( 'Right', 'divi-shop-builder' ),
						'iconSvg' => $this->getIconSvg('mini-cart-right' )
					),
				),
				'default'         => 'right',
				'customClass'     => 'col-medium',
				'tab_slug'       => 'advanced',
				'toggle_slug'     => 'cart_icon_count',
				'sub_toggle'      => 'settings'
			),
			'cart_icon_count_position_top' => array(
				'label'          => __( 'Top', 'divi-shop-builder' ),
				'type'           => 'range',
				'allowed_units'  => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'validate_unit'  => true,
				'default_unit'   => 'em',
				'default'       => '-1em',
				'mobile_options' => true,
				'responsive'     => true,
				'range_settings' => array(
					'min'  => '-1000',
					'max'  => '1000',
					'step' => '0.1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'     => 'cart_icon_count',
				'sub_toggle'      => 'settings',
			),
			'cart_icon_count_position_left' => array(
				'label'          => __( 'Left', 'divi-shop-builder' ),
				'type'           => 'range',
				'allowed_units'  => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'validate_unit'  => true,
				'default_unit'   => 'em',
				'default'       => '-1em',
				'mobile_options' => true,
				'responsive'     => true,
				'range_settings' => array(
					'min'  => '-1000',
					'max'  => '1000',
					'step' => '0.1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'     => 'cart_icon_count',
				'sub_toggle'      => 'settings',
				'show_if'        => array(
					'cart_icon_count_position' => array(
						'left',
					)
				)
			),
			'cart_icon_count_position_right' => array(
				'label'          => __( 'Right', 'divi-shop-builder' ),
				'type'           => 'range',
				'allowed_units'  => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'validate_unit'  => true,
				'default_unit'   => 'em',
				'default'       => '-1em',
				'mobile_options' => true,
				'responsive'     => true,
				'range_settings' => array(
					'min'  => '-1000',
					'max'  => '1000',
					'step' => '0.1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'     => 'cart_icon_count',
				'sub_toggle'      => 'settings',
				'show_if'        => array(
					'cart_icon_count_position' => array(
						'right',
					)
				)
			),
			'cart_icon_count_bg'         => array(
				'label'       => esc_html__('Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'cart_icon_count',
				'sub_toggle'  => 'background',
			),

			// Dropdown
			'dropdown_direction' => [
				'label'           => esc_html__( 'Dropdown Open Direction', 'divi-shop-builder' ),
				'type'            => 'select',
				'options' 		  => array(
					'left' 	      => esc_html__( 'Left', 'divi-shop-builder' ),
					'right' 	   => esc_html__( 'Right', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'left',
				'tab_slug'       => 'advanced',
				'toggle_slug'     => 'dropdown',
				'sub_toggle'     => 'general'
			],
			'dropdown_top_position' => array(
				'label'          => __( 'Top Position', 'divi-shop-builder' ),
				'type'           => 'range',
				'validate_unit'  => true,
				'default_unit'   => 'px',
				'allowed_units'  => array( 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'       => '15px',
				'mobile_options' => true,
				'responsive'     => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '1000',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'     => 'dropdown',
				'sub_toggle'      => 'general',
			),
			'dropdown_width' => array(
				'label'          => __( 'Width', 'divi-shop-builder' ),
				'type'           => 'range',
				'validate_unit'  => true,
				'default_unit'   => 'px',
				'allowed_units'  => array( 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'       => '',
				'mobile_options' => true,
				'responsive'     => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '1000',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'     => 'dropdown',
				'sub_toggle'      => 'general',
			),

			'dropdown_min_width' => array(
				'label'          => __( 'Minimum Width', 'divi-shop-builder' ),
				'type'           => 'range',
				'validate_unit'  => true,
				'default_unit'   => 'px',
				'allowed_units'  => array( 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'       => '250px',
				'mobile_options' => true,
				'responsive'     => true,
				'tab_slug'       => 'advanced',
				'toggle_slug'     => 'dropdown',
				'sub_toggle'      => 'general',
			),
			'dropdown_max_width' => array(
				'label'          => __( 'Maximum Width', 'divi-shop-builder' ),
				'type'           => 'range',
				'validate_unit'  => true,
				'default_unit'   => 'px',
				'allowed_units'  => array( 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'       => '',
				'mobile_options' => true,
				'responsive'     => true,
				'range_settings' => array(
					'min'  => '-1000',
					'max'  => '1000',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'     => 'dropdown',
				'sub_toggle'      => 'general',
			),

			'dropdown_bg'         => array(
				'label'       => esc_html__('Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'dropdown',
				'sub_toggle'  => 'background',
			),

			// Side Cart

			'side_cart_show_overlay' => [
				'label'           => esc_html__( 'Show Overlay', 'divi-shop-builder' ),
				'description' 	  => esc_html__( 'Enable this to make the label text visible.', 'divi-shop-builder' ),
				'type'            => 'yes_no_button',
				'options' 		  => array(
					'on' 	      => esc_html__( 'Show', 'divi-shop-builder' ),
					'off' 	      => esc_html__( 'Hide', 'divi-shop-builder' ),
				),
				'option_category' => 'configuration',
				'default'         => 'on',
				'tab_slug'    => 'advanced',
				'toggle_slug'     => 'side_cart',
				'sub_toggle'      => 'general'
			],

			'side_cart_width' => array(
				'label'          => __( 'Width', 'divi-shop-builder' ),
				'type'           => 'range',
				'validate_unit'  => true,
				'default_unit'   => 'px',
				'allowed_units'  => array( 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'       => '',
				'mobile_options' => true,
				'responsive'     => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '1000',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'     => 'side_cart',
				'sub_toggle'      => 'general',
			),
			'side_cart_bg'         => array(
				'label'       => esc_html__('Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'side_cart',
				'sub_toggle'  => 'background',
			),

			// Header
			'header_bg'         => array(
				'label'       => esc_html__('Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'header',
				'sub_toggle'  => 'background',
			),

			// Footer
			'footer_bg'         => array(
				'label'       => esc_html__('Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'footer',
				'sub_toggle'  => 'background',
			),

			// Product Image
			'product_image_max_width' => array(
				'label'          => __( 'Maximum Width', 'divi-shop-builder' ),
				'type'           => 'range',
				'validate_unit'  => true,
				'default_unit'   => 'px',
				'allowed_units'  => array( 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'default'       => '',
				'mobile_options' => true,
				'responsive'     => true,
				'range_settings' => array(
					'min'  => '-1000',
					'max'  => '1000',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'     => 'product_image',
				'sub_toggle'      => 'settings',
			),

			// Product Remove Icon
			'remove_icon_size' => array(
				'label'          => __( 'Icon Size', 'divi-shop-builder' ),
				'type'           => 'range',
				'allowed_units'  => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
				'validate_unit'  => true,
				'default_unit'   => 'px',
				'default'       => '1.5em',
				'mobile_options' => true,
				'responsive'     => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'     => 'product_remove',
				'sub_toggle'      => 'settings',
			),
			'remove_color'         => array(
				'label'       => esc_html__('Icon Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'product_remove',
				'sub_toggle'  => 'settings',
			),
			'remove_bg'         => array(
				'label'       => esc_html__('Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'product_remove',
				'sub_toggle'  => 'settings',
			),

			//
			'empty_message_icon_size' => array(
				'label'          => __( 'Icon Size', 'divi-shop-builder' ),
				'type'           => 'range',
				'allowed_units'  => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
				'validate_unit'  => true,
				'default_unit'   => 'px',
				'default'       => '2em',
				'mobile_options' => true,
				'responsive'     => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'     => 'empty_message',
				'sub_toggle'      => 'icon',
			),
			'empty_message_icon_color'         => array(
				'label'       => esc_html__('Icon Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'empty_message',
				'sub_toggle'  => 'icon',
			),
			'empty_message_icon_bg'         => array(
				'label'       => esc_html__('Icon Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'empty_message',
				'sub_toggle'  => 'icon',
			),
			'empty_message_bg'         => array(
				'label'       => esc_html__('Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'empty_message',
				'sub_toggle'  => 'background',
			),

			// Close Button
			'close_btn_icon_size' => array(
				'label'          => __( 'Icon Size', 'divi-shop-builder' ),
				'type'           => 'range',
				'allowed_units'  => array('%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw'),
				'validate_unit'  => true,
				'default_unit'   => 'px',
				'default'       => '2em',
				'mobile_options' => true,
				'responsive'     => true,
				'range_settings' => array(
					'min'  => '1',
					'max'  => '100',
					'step' => '1',
				),
				'tab_slug'       => 'advanced',
				'toggle_slug'     => 'close_button',
				'sub_toggle'      => 'general',
			),
			'close_btn_icon_color'         => array(
				'label'       => esc_html__('Icon Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '',
				'hover'			 => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'close_button',
				'sub_toggle'  => 'general',
			),
			'close_btn_icon_bg'         => array(
				'label'       => esc_html__('Icon Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '',
				'hover'			 => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'close_button',
				'sub_toggle'  => 'general',
			),
			'close_btn_bg'         => array(
				'label'       => esc_html__('Background Color', 'divi-shop-builder'),
				'type'        => 'color-alpha',
				'default'     => '',
				'hover'			 => 'tabs',
				'tab_slug'    => 'advanced',
				'toggle_slug' => 'close_button',
				'sub_toggle'  => 'general',
			),


		];


		// Paddings, Margins Fields
		foreach ( self::$margin_padding_elements as $elementId => $params ) {

			$default_margin  = isset($params['default_margin']) ? $params['default_margin'] : '';
			$default_padding = isset($params['default_padding']) ? $params['default_padding'] : '';
			$toggle_slug = isset($params['toggle_slug']) ? $params['toggle_slug'] : $elementId;
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

	/**
	 *  Used to generate responsive module CSS
	 *  Custom margin is based on update_styles() function.
	 *  Divi/includes/builder/module/field/MarginPadding.php
	 *
	 */
	private function apply_responsive($value, $selector, $css, $render_slug, $type, $default = null, $important = false) {

		$dstc_last_edited       = $this->props[ $value . '_last_edited' ];
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
				$dstc_tablet = trim(str_replace($re, ' ', $this->props[ $value . '_tablet' ]));
				$dstc_phone  = trim(str_replace($re, ' ', $this->props[ $value . '_phone' ]));

				$dstc_array = array(
					'desktop' => esc_html($dstc),
					'tablet'  => $dstc_responsive_active ? esc_html($dstc_tablet) : '',
					'phone'   => $dstc_responsive_active ? esc_html($dstc_phone) : '',
				);
				et_pb_responsive_options()->generate_responsive_css($dstc_array, $selector, $css, $render_slug, $important ? '!important' : '', $type);
		}

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

			switch ( $field['toggle_slug'] ) {
				case 'cart_icon_count':
					$showIf = ['show_count' => 'on'];
					break;
				case 'cart_icon_amount':
					$showIf = ['show_amount' => 'on'];
					break;
				case 'product_quantity':
					$showIf = ['show_quantity' => 'on'];
					break;
				case 'product_image':
					$showIf = ['show_images' => 'on'];
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

	/**
	 * @since
	 */
	private function css($render_slug) {

		// -----------------------------------------------------
		// Responsive CSS
		// -----------------------------------------------------

		// Paddings and Margins
		foreach ( self::$margin_padding_elements as $elementId => $params ) {
			$this->apply_responsive( $elementId . '_padding', $params['selector'], 'padding', $render_slug, 'custom_margin', isset( $params['default_padding'] ) ? $params['default_padding'] : '' );
			$this->apply_responsive( $elementId . '_margin', $params['selector'], 'margin', $render_slug, 'custom_margin', isset( $params['default_margin'] ) ? $params['default_margin'] : '' );
		}


		// Cart Icon

		$this->apply_responsive('cart_icon_count_position_top', '%%order_class%% .dswcp-count', 'top', $render_slug, 'default', '-1em');

		if ($this->props['cart_icon_count_position'] === 'left') {
			$this->apply_responsive('cart_icon_count_position_left', '%%order_class%% .dswcp-count', 'left', $render_slug, 'default', '-1em');
		}

		if ($this->props['cart_icon_count_position'] === 'right') {
			$this->apply_responsive('cart_icon_count_position_right', '%%order_class%% .dswcp-count', 'right', $render_slug, 'default', '-1em');
		}

		if ( '' !== $this->props['cart_icon_bg'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-cart-icon.dswcp-mini-cart-icon',
					'declaration' => sprintf('background-color:%s;', esc_attr($this->props['cart_icon_bg'])),
				)
			);
		}

		if ( '' !== $this->props['cart_icon_col'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-cart-icon.dswcp-mini-cart-icon',
					'declaration' => sprintf('color:%s;', esc_attr($this->props['cart_icon_col'])),
				)
			);
		}

		if ( 'on' === $this->props['float_right'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .et_pb_module_inner',
					'declaration' =>'float: right;',
				)
			);
		}

		if ( '' !== $this->props['cart_icon_count_bg'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-count',
					'declaration' => sprintf('background-color:%s;', esc_attr($this->props['cart_icon_count_bg'])),
				)
			);
		}




		$this->apply_responsive('cart_icon_size', '%%order_class%% .dswcp-cart-icon.dswcp-mini-cart-icon', 'font-size', $render_slug, 'default', '24px');
		$this->apply_responsive('cart_icon_line-height', '%%order_class%% .dswcp-cart-icon.dswcp-mini-cart-icon', 'line-height', $render_slug, 'default', '32px');


		if ($this->props['dropdown_width'] !== '') {
			$this->apply_responsive('dropdown_width', '%%order_class%% .dswcp-dropdown-cart', 'width', $render_slug, 'default', '');
		}

		if ($this->props['dropdown_top_position'] !== '' && $this->props['dropdown_top_position'] !== '15px') {
			$this->apply_responsive('dropdown_top_position', '%%order_class%% .dswcp-dropdown-cart-container', 'top', $render_slug, 'default', '');
		}

		if ($this->props['dropdown_min_width'] !== '') {
			$this->apply_responsive('dropdown_min_width', '%%order_class%% .dswcp-dropdown-cart', 'min-width', $render_slug, 'default', '250px');
		}

		if ($this->props['dropdown_max_width'] !== '') {
			$this->apply_responsive('dropdown_max_width', '%%order_class%% .dswcp-dropdown-cart', 'max-width', $render_slug, 'default', '');
		}

		if ( '' !== $this->props['dropdown_bg'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-dropdown-cart',
					'declaration' => sprintf('background-color:%s;', esc_attr($this->props['dropdown_bg'])),
				)
			);
		}

		if ( '' !== $this->props['dropdown_direction'] && 'right' === $this->props['dropdown_direction'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-dropdown-cart-container',
					'declaration' => 'right: unset; left: 0px;',
				)
			);
		}


		if ($this->props['side_cart_width'] !== '') {
			$this->apply_responsive('side_cart_width', '%%order_class%% .dswcp-side-cart', 'width', $render_slug, 'default', '');
		}

		if ( '' !== $this->props['side_cart_bg'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-side-cart',
					'declaration' => sprintf('background-color:%s;', esc_attr($this->props['side_cart_bg'])),
				)
			);
		}

		if ( '' !== $this->props['header_bg'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-side-cart-header, %%order_class%% .dswcp-dropdown-cart-header',
					'declaration' => sprintf('background-color:%s;', esc_attr($this->props['header_bg'])),
				)
			);
		}
		if ( '' !== $this->props['footer_bg'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-side-cart-footer, %%order_class%% .dswcp-dropdown-cart-footer',
					'declaration' => sprintf('background-color:%s;', esc_attr($this->props['footer_bg'])),
				)
			);
		}


		if ($this->props['product_image_max_width'] !== '') {
			$this->apply_responsive('product_image_max_width', '%%order_class%% .dswcp-dropdown-cart-items .dswcp-image-container, %%order_class%% .dswcp-side-cart-items .dswcp-image-container', 'max-width', $render_slug, 'default', '');
		}


		if ($this->props['remove_icon_size'] !== '') {
			$this->apply_responsive('remove_icon_size', '%%order_class%% .dswcp-remove', 'font-size', $render_slug, 'default', '24px', true);
		}

		if ( '' !== $this->props['remove_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-remove',
					'declaration' => sprintf('color:%s;', esc_attr($this->props['remove_color'])),
				)
			);
		}


		if ( '' !== $this->props['remove_bg'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-remove',
					'declaration' => sprintf('background-color:%s;', esc_attr($this->props['remove_bg'])),
				)
			);
		}

		$this->apply_responsive('empty_message_icon_size', '%%order_class%% .dswcp-cart-empty-icon.et_pb_icon, %%order_class%% .dswcp-cart-empty-icon', 'font-size', $render_slug, 'default', '2em');


		if ( '' !== $this->props['empty_message_icon_color'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-cart-empty-icon.et_pb_icon, %%order_class%% .dswcp-cart-empty-icon',
					'declaration' => sprintf('color:%s;', esc_attr($this->props['empty_message_icon_color'])),
				)
			);
		}

		if ( '' !== $this->props['empty_message_icon_bg'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-cart-empty-icon.et_pb_icon, %%order_class%% .dswcp-cart-empty-icon',
					'declaration' => sprintf('background-color:%s;', esc_attr($this->props['empty_message_icon_bg'])),
				)
			);
		}

		if ( '' !== $this->props['empty_message_bg'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-cart-empty',
					'declaration' => sprintf('background-color:%s;', esc_attr($this->props['empty_message_bg'])),
				)
			);
		}


		$this->apply_responsive('close_btn_icon_size', '%%order_class%% .dswcp-side-cart .dswcp-close, %%order_class%% .dswcp-dropdown-cart .dswcp-close', 'font-size', $render_slug, 'default', '2em');


		if ( '' !== $this->props['close_btn_icon_color'] ) {

			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%%  .dswcp-close',
					'declaration' => sprintf('color:%s;', esc_attr($this->props['close_btn_icon_color'])),
				)
			);
		}

		if ( '' !== $this->props['close_btn_icon_bg'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-close',
					'declaration' => sprintf('background-color:%s;', esc_attr($this->props['close_btn_icon_bg'])),
				)
			);
		}

		if ( '' !== $this->props['empty_message_bg'] ) {
			self::set_style_esc(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dswcp-cart-empty',
					'declaration' => sprintf('background-color:%s;', esc_attr($this->props['empty_message_bg'])),
				)
			);
		}

		if ( 'on' === $this->props['side_cart_show_overlay'] ) {
			self::set_style(
				$render_slug,
				array(
					'selector'    => 'body:has(> .dswcp-side-cart)::after',
					'declaration' => 'background: #000; content: "";  height: 0; width: 0; pointer-events: none; position: absolute; top: 0; left: 0; z-index: 9998;opacity: 0;visibility: hidden;'
				)
			);
			self::set_style(
				$render_slug,
				array(
					'selector'    => 'body:has(> .dswcp-side-cart.dswcp-show-side-cart)::after',
					'declaration' => 'height: 100%; width: 100%; opacity: 0.2;visibility: visible;transition: opacity 1s ease-out; '
				)
			);
			self::set_style(
				$render_slug,
				array(
					'selector'    => 'body',
					'declaration' => 'position:relative;'
				)
			);
		}

	}
	
	public function render($attrs, $content, $render_slug) {
		$this->css($render_slug);

		global $post;
		$props = $this->props;
		
		if ($props['action_click'] == 'sidecart') {
			$sideCartId = ET_Builder_Element::get_module_order_class('ags_woo_mini_cart').'__side_cart';
		}
		
		ob_start();
		include(__DIR__.'/render.php');
		$result = ob_get_clean();
		
		return $result;
	}
	
	public function builder_js_data( $js_data ){
		$cartFrontendScript = wp_scripts()->query('wc-mini-cart-block-frontend');
		$locals = [
			'placeholderAmount' => wc_price(14.99),
			'placeholderTotal' => wc_price(29.98),
			'placeholderImage' => wc_placeholder_img_src()
		];

		$js_data['mini_cart'] = $locals;

		return $js_data;
	}
	
	public function process_advanced_button_options($slug) {
		add_filter('ags_woo_mini_cart_css_selector', [__CLASS__, 'strip_button_selector_prefix']);
		parent::process_advanced_button_options($slug);
		remove_filter('ags_woo_mini_cart_css_selector', [__CLASS__, 'strip_button_selector_prefix']);
	}

	public function process_margin_padding_advanced_css($slug) {
		add_filter('ags_woo_mini_cart_css_selector', [__CLASS__, 'strip_button_selector_prefix']);
		parent::process_margin_padding_advanced_css($slug);
		remove_filter('ags_woo_mini_cart_css_selector', [__CLASS__, 'strip_button_selector_prefix']);
	}


	public static function strip_button_selector_prefix($selector)  {
		return  strpos($selector, '.dswcp-btn-') === false && strpos($selector, '.et_pb_button') === false ? $selector : str_replace('body #page-container .et_pb_section ', '', $selector);
	}


}

new DSWCP_WooMiniCart;