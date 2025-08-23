<?php

defined( 'ABSPATH' ) || die();

require_once DNWOO_ESSENTIAL_PATH . '/includes/modules/NextWooFilterMasonry/core/DataFactory.php';
require_once DNWOO_ESSENTIAL_PATH . '/includes/modules/NextWooFilterMasonry/core/FilterOptions.php';

use DNWoo_Essential\Includes\Modules\NextWooFilterMasonry\DataFactory;
use DNWoo_Essential\Includes\Modules\NextWooFilterMasonry\FilterOptions;
use DNWoo_Essential\Includes\Modules\NextWooFilterMasonry\Templates;

class DNWooFilterMasonry extends ET_Builder_Module {

	public $slug        = 'dnwoo_filter_masonry';
	protected $next_woocarousel_count = 0;
	public $vb_support                = 'on';
	public $folder_name;
	public $icon_path;
	public $text_shadow;
	public $margin_padding;
	public $_additional_fields_options;
	public $_original_content;
	public $dnwoo_filter_masonry_count;


	protected $module_credits = array(
		'module_uri' => 'https://wooessential.com/divi-woocommerce-product-filter-module/',
		'author'     => 'Divi Next',
		'author_uri' => 'https://www.divinext.com',
	);

	public function init() {
		$this->name                   = esc_html__( 'Woo Product Filter', 'dnwooe' );
		$this->icon_path              = plugin_dir_path( __FILE__ ) . 'icon.svg';
		$this->folder_name            = 'et_pb_woo_essential';
		$this->settings_modal_toggles = WooCommonSettings::carousel_modal_toggles( 'dnwoo_filter_masonry' );
		$this->settings_modal_toggles['general']['toggles']['accordion_settings'] = esc_html__( 'Settings', 'dnwooe' );
		$this->dnwoo_filter_masonry_count                                       = 1;
		$this->settings_modal_toggles['advanced']['toggles']['filter_settings'] = array(
			'title'             => esc_html__( 'Filter Settings', 'dnwooe' ),
			'sub_toggles'       => array(
				'product_cat' => array(
					'name' => esc_html__( 'Category', 'dnwooe' ),
				),
				'filter_bg'   => array(
					'name' => esc_html__( 'Background', 'dnwooe' ),
				),
			),
			'tabbed_subtoggles' => true,
		);
		$this->settings_modal_toggles['advanced']['toggles']['dnwoo_filter_grid'] = esc_html__( 'Grid', 'dnwooe' );

		$this->settings_modal_toggles['advanced']['toggles']['product_settings'] = esc_html__( 'Product Text', 'dnwooe' );
		$this->settings_modal_toggles['advanced']['toggles']['filter_title_text'] = esc_html__( 'Custom Filter Titles', 'dnwooe' );
		$this->settings_modal_toggles['advanced']['toggles']['filter_text'] = array(
			'title'             => esc_html__( 'Custom Filter Text', 'dnwooe' ),
			'sub_toggles'       => array(
				'filter_by_all_clear_text' => array(
					'name' => esc_html__( 'Clear Button Text', 'dnwooe' ),
				),
				'filter_by_reset_text' => array(
					'name' => esc_html__( 'Reset Button Text', 'dnwooe' ),
				),
			),
			'tabbed_subtoggles' => true,
		);
		$this->settings_modal_toggles['advanced']['toggles']['product_price']    = array(
			'title'             => esc_html__( 'Price Texts', 'dnwooe' ),
			'sub_toggles'       => array(
				'regular_price' => array(
					'name' => esc_html__( 'Regular Price', 'dnwooe' ),
				),
				'new_price'     => array(
					'name' => esc_html__( 'New Price', 'dnwooe' ),
				),
			),
			'tabbed_subtoggles' => true,
		);
		$this->settings_modal_toggles['advanced']['toggles']['item_settings']    = esc_html__( 'Product Settings', 'dnwooe' );

		$this->settings_modal_toggles['advanced']['toggles']['cartbtn'] = array(
			'title'             => esc_html__( 'Cart/Select Options Button', 'dnwooe' ),
			'sub_toggles'       => array(
				'addtocart' => array(
					'name' => esc_html__( 'Add to Cart', 'dnwooe' ),
				),
				'viewcart'  => array(
					'name' => esc_html__( 'View Cart', 'dnwooe' ),
				),
			),
			'tabbed_subtoggles' => true,
		);

		$this->settings_modal_toggles['advanced']['toggles']['quickviewpopupbox']             = array(
			'title'             => esc_html__( 'Quick View Pop Up Box', 'dnwooe' ),
			'tabbed_subtoggles' => true,
			'sub_toggles'       => array(
				'quickviewpopupbox_title' => array(
					'name' => esc_html__( 'Title', 'dnwooe' ),
				),
				'quickviewpopupbox_desc'  => array(
					'name' => esc_html__( 'Desc', 'dnwooe' ),
				),
				'quickviewpopupbox_price' => array(
					'name' => esc_html__( 'Price', 'dnwooe' ),
				),
				'quickviewpopupbox_btn'   => array(
					'name' => esc_html__( 'Button', 'dnwooe' ),
				),
				'quickviewpopupbox_meta'  => array(
					'name' => esc_html__( 'Meta', 'dnwooe' ),
				),
			),
		);
		$this->settings_modal_toggles['advanced']['toggles']['quickbox_popup_box_bg']         = esc_html__( 'Quick View Popup Box Background', 'dnwooe' );
		$this->settings_modal_toggles['advanced']['toggles']['quickbox_popup_box_arrow']      = esc_html__( 'Quick View Popup Box Arrow', 'dnwooe' );
		$this->settings_modal_toggles['advanced']['toggles']['quickview_popup_box_close_btn'] = esc_html__( 'Quick View Popup Box Close Button', 'dnwooe' );
		$this->settings_modal_toggles['advanced']['toggles']['wishlist_settings']             = esc_html__( 'Wishlist Button', 'dnwooe' );
		$this->settings_modal_toggles['advanced']['toggles']['compare_settings']              = esc_html__( 'Compare Button', 'dnwooe' );
		$this->settings_modal_toggles['advanced']['toggles']['quickview_settings']            = esc_html__( 'Quick View Button', 'dnwooe' );
		$this->settings_modal_toggles['advanced']['toggles']['dnwoo_filter_rating']           = esc_html__( 'Filter Rating', 'dnwooe' );
		$this->settings_modal_toggles['advanced']['toggles']['dnwoo_rating']                  = esc_html__( 'Rating', 'dnwooe' );
		$this->settings_modal_toggles['advanced']['toggles']['dnwoo_filter_pagination']       = esc_html__( 'Pagination', 'dnwooe' );
		$this->settings_modal_toggles['advanced']['toggles']['badge']                         = array(
			'title'             => esc_html__( 'Badge' ),
			'sub_toggles'       => array(
				'sale'       => array(
					'name' => esc_html__( 'Sale', 'dnwooe' ),
				),
				'outofstock' => array(
					'name' => esc_html__( 'Out of Stock', 'dnwooe' ),
				),
				'featured'   => array(
					'name' => esc_html__( 'Featured', 'dnwooe' ),
				),
			),
			'tabbed_subtoggles' => true,
		);

		$this->advanced_fields   = array(
			'text'       => false,
			'fonts'      => array(
				'header'                     => array(
					'css'             => array(
						'main' => '%%order_class%% .dnwoo_product_filter_title',
					),
					'toggle_slug'     => 'product_settings',
					'font'            => array(
						'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe' ),
					),
					'letter_spacing'  => array(
						'description' => esc_html__( 'Adjust the spacing between the letters of the text', 'dnwooe' ),
					),
					'text_alignment ' => array(
						'description' => esc_html__( 'Align the text to the left, right, center, or justify', 'dnwooe' ),
					),
					'line_height'     => array(
						'description' => esc_html__( 'Adjust the space between multiple lines added to the design', 'dnwooe' ),
					),
					'header_level'    => array(
						'default' => 'h3',
					),
				),
				'product_cats'               => array(
					'css'             => array(
						'main'       => '%%order_class%% .dnwoo_product_filter_menu li',
						'text_align' => '%%order_class%% .dnwoo_product_filter_menu',
					),
					'toggle_slug'     => 'filter_settings',
					'sub_toggle'      => 'product_cat',
					'font'            => array(
						'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe' ),
					),
					'text_alignment ' => array(
						'description' => esc_html__( 'Align the text to the left, right, center, or justify', 'dnwooe' ),
					),
					'letter_spacing'  => array(
						'description' => esc_html__( 'Adjust the spacing between the letters of the text', 'dnwooe' ),
					),
					'line_height'     => array(
						'description' => esc_html__( 'Adjust the space between multiple lines added to the design', 'dnwooe' ),
					),
				),
				'regular_price'              => array(
					'css'             => array(
						'main'       => '%%order_class%% .dnwoo_product_filter_price > span:first-child, %%order_class%% .dnwoo_product_filter_price > span:first-child span, %%order_class%% .dnwoo_product_filter_price del, %%order_class%% .dnwoo_product_filter_price del span,%%order_class%% .dnwoo_product_filter_item.product_type_variable .dnwoo_product_filter_price',
						'text_align' => '%%order_class%% .dnwoo_product_filter_price',
						'important'  => 'all',
					),
					'toggle_slug'     => 'product_price',
					'sub_toggle'      => 'regular_price',
					'font'            => array(
						'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe' ),
					),
					'letter_spacing'  => array(
						'description' => esc_html__( 'Adjust the spacing between the letters of the text', 'dnwooe' ),
					),
					'text_alignment ' => array(
						'description' => esc_html__( 'Align the text to the left, right, center, or justify', 'dnwooe' ),
					),
					'line_height'     => array(
						'description' => esc_html__( 'Adjust the space between multiple lines added to the design', 'dnwooe' ),
					),
				),
				'new_price'                  => array(
					'css'             => array(
						'main'      => '%%order_class%% .dnwoo_product_filter_price ins span',
						'important' => 'all',
					),
					'hide_text_align' => true,
					'toggle_slug'     => 'product_price',
					'sub_toggle'      => 'new_price',
					'font'            => array(
						'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe' ),
					),
					'letter_spacing'  => array(
						'description' => esc_html__( 'Adjust the spacing between the letters of the text', 'dnwooe' ),
					),
					'line_height'     => array(
						'description' => esc_html__( 'Adjust the space between multiple lines added to the design', 'dnwooe' ),
					),
				),
				'sale'                       => array(
					'hide_text_align' => true,
					'css'             => array(
						'main'      => '%%order_class%% .dnwoo_product_filter_onsale',
						'important' => 'all',
					),
					'toggle_slug'     => 'badge',
					'sub_toggle'      => 'sale',
					'font'            => array(
						'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe' ),
					),
					'letter_spacing'  => array(
						'description' => esc_html__( 'Adjust the spacing between the letters of the text', 'dnwooe' ),
					),
					'text_alignment ' => array(
						'description' => esc_html__( 'Align the text to the left, right, center, or justify', 'dnwooe' ),
					),
					'line_height'     => array(
						'description' => esc_html__( 'Adjust the space between multiple lines added to the design', 'dnwooe' ),
					),
				),
				'outofstock'                 => array(
					'hide_text_align' => true,
					'css'             => array(
						'main'      => '%%order_class%% .dnwoo_product_filter_stockout',
						'important' => 'all',
					),
					'toggle_slug'     => 'badge',
					'sub_toggle'      => 'outofstock',
					'font'            => array(
						'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe' ),
					),
					'letter_spacing'  => array(
						'description' => esc_html__( 'Adjust the spacing between the letters of the text', 'dnwooe' ),
					),
					'text_alignment ' => array(
						'description' => esc_html__( 'Align the text to the left, right, center, or justify', 'dnwooe' ),
					),
					'line_height'     => array(
						'description' => esc_html__( 'Adjust the space between multiple lines added to the design', 'dnwooe' ),
					),
				),
				'featured'                   => array(
					'hide_text_align' => true,
					'css'             => array(
						'main'      => '%%order_class%% .dnwoo_product_filter_featured',
						'important' => 'all',
					),
					'toggle_slug'     => 'badge',
					'sub_toggle'      => 'featured',
					'font'            => array(
						'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe' ),
					),
					'letter_spacing'  => array(
						'description' => esc_html__( 'Adjust the spacing between the letters of the text', 'dnwooe' ),
					),
					'text_alignment ' => array(
						'description' => esc_html__( 'Align the text to the left, right, center, or justify', 'dnwooe' ),
					),
					'line_height'     => array(
						'description' => esc_html__( 'Adjust the space between multiple lines added to the design', 'dnwooe' ),
					),
				),
				'add_to_card'                => array(
					'hide_text_align' => true,
					'css'             => array(
						'main'      => '%%order_class%% .add_to_cart_button,%%order_class%% .dnwoo_choose_variable_option',
						'important' => 'all',
					),
					'toggle_slug'     => 'cartbtn',
					'sub_toggle'      => 'addtocart',
					'font'            => array(
						'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe' ),
					),
					'letter_spacing'  => array(
						'description' => esc_html__( 'Adjust the spacing between the letters of the text', 'dnwooe' ),
					),
					'text_alignment ' => array(
						'description' => esc_html__( 'Align the text to the left, right, center, or justify', 'dnwooe' ),
					),
					'line_height'     => array(
						'description' => esc_html__( 'Adjust the space between multiple lines added to the design', 'dnwooe' ),
					),
				),
				'view_cart'                  => array(
					'hide_text_align' => true,
					'css'             => array(
						'main'      => '%%order_class%% .added_to_cart',
						'font'      => '%%order_class%% .added_to_cart',
						'color'     => '%%order_class%% .added_to_cart',
						'important' => 'all',
					),
					'toggle_slug'     => 'cartbtn',
					'sub_toggle'      => 'viewcart',
					'font'            => array(
						'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe' ),
					),
					'letter_spacing'  => array(
						'description' => esc_html__( 'Adjust the spacing between the letters of the text', 'dnwooe' ),
					),
					'text_alignment ' => array(
						'description' => esc_html__( 'Align the text to the left, right, center, or justify', 'dnwooe' ),
					),
					'line_height'     => array(
						'description' => esc_html__( 'Adjust the space between multiple lines added to the design', 'dnwooe' ),
					),
				),
				'wishlist'                   => array(
					'hide_text_align' => true,
					'css'             => array(
						'main'      => '%%order_class%% .dnwoo_product_filter_badge_btn a.dnwoo-filter-wishlist-btn',
						'important' => 'all',
					),
					'toggle_slug'     => 'wishlist_settings',
					'font'            => array(
						'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe' ),
					),
					'letter_spacing'  => array(
						'description' => esc_html__( 'Adjust the spacing between the letters of the text', 'dnwooe' ),
					),
					'text_alignment ' => array(
						'description' => esc_html__( 'Align the text to the left, right, center, or justify', 'dnwooe' ),
					),
					'line_height'     => array(
						'description' => esc_html__( 'Adjust the space between multiple lines added to the design', 'dnwooe' ),
					),
				),
				'compare'                    => array(
					'hide_text_align' => true,
					'css'             => array(
						'main'      => '%%order_class%% .dnwoo_product_filter_badge_btn .dnwoo-product-compare-btn',
						'important' => 'all',
					),
					'toggle_slug'     => 'compare_settings',
					'font'            => array(
						'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe' ),
					),
					'letter_spacing'  => array(
						'description' => esc_html__( 'Adjust the spacing between the letters of the text', 'dnwooe' ),
					),
					'text_alignment ' => array(
						'description' => esc_html__( 'Align the text to the left, right, center, or justify', 'dnwooe' ),
					),
					'line_height'     => array(
						'description' => esc_html__( 'Adjust the space between multiple lines added to the design', 'dnwooe' ),
					),
				),
				'quickview'                  => array(
					'hide_text_align' => true,
					'css'             => array(
						'main'      => '%%order_class%% .dnwoo_product_filter_badge_btn .dnwoo-quickview',
						'important' => 'all',
					),
					'toggle_slug'     => 'quickview_settings',
					'font'            => array(
						'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe' ),
					),
					'letter_spacing'  => array(
						'description' => esc_html__( 'Adjust the spacing between the letters of the text', 'dnwooe' ),
					),
					'text_alignment ' => array(
						'description' => esc_html__( 'Align the text to the left, right, center, or justify', 'dnwooe' ),
					),
					'line_height'     => array(
						'description' => esc_html__( 'Adjust the space between multiple lines added to the design', 'dnwooe' ),
					),
				),
				'quick_view_popup_box_title' => array(
					'hide_text_align' => true,
					'css'             => array(
						'main'       => '%%order_class%% .dnwoo-product-summery .product-title',
						'font'       => '%%order_class%% .dnwoo-product-summery .product-title',
						'text_align' => '%%order_class%% .dnwoo-product-summery .product-title',
						'color'      => '%%order_class%% .dnwoo-product-summery .product-title',
						'important'  => 'all',
					),
					'toggle_slug'     => 'quickviewpopupbox',
					'sub_toggle'      => 'quickviewpopupbox_title',
					'font'            => array(
						'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe' ),
					),
					'letter_spacing'  => array(
						'description' => esc_html__( 'Adjust the spacing between the letters of the text', 'dnwooe' ),
					),
					'text_alignment ' => array(
						'description' => esc_html__( 'Align the text to the left, right, center, or justify', 'dnwooe' ),
					),
					'line_height'     => array(
						'description' => esc_html__( 'Adjust the space between multiple lines added to the design', 'dnwooe' ),
					),
				),
				'quick_view_popup_box_desc'  => array(
					'hide_text_align' => true,
					'css'             => array(
						'main'       => '%%order_class%% .dnwoo-product-summery .product-description',
						'font'       => '%%order_class%% .dnwoo-product-summery .product-description',
						'text_align' => '%%order_class%% .dnwoo-product-summery .product-description',
						'color'      => '%%order_class%% .dnwoo-product-summery .product-description',
						'important'  => 'all',
					),
					'toggle_slug'     => 'quickviewpopupbox',
					'sub_toggle'      => 'quickviewpopupbox_desc',
					'font'            => array(
						'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe' ),
					),
					'letter_spacing'  => array(
						'description' => esc_html__( 'Adjust the spacing between the letters of the text', 'dnwooe' ),
					),
					'text_alignment ' => array(
						'description' => esc_html__( 'Align the text to the left, right, center, or justify', 'dnwooe' ),
					),
					'line_height'     => array(
						'description' => esc_html__( 'Adjust the space between multiple lines added to the design', 'dnwooe' ),
					),
				),
				'quick_view_popup_box_price' => array(
					'hide_text_align' => true,
					'css'             => array(
						'main'      => '%%order_class%% .dnwoo-product-summery .product-price span, %%order_class%% .dnwoo-product-summery .woocommerce-variation.single_variation',
						'important' => 'all',
					),
					'toggle_slug'     => 'quickviewpopupbox',
					'sub_toggle'      => 'quickviewpopupbox_price',
					'font'            => array(
						'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe' ),
					),
					'letter_spacing'  => array(
						'description' => esc_html__( 'Adjust the spacing between the letters of the text', 'dnwooe' ),
					),
					'text_alignment ' => array(
						'description' => esc_html__( 'Align the text to the left, right, center, or justify', 'dnwooe' ),
					),
					'line_height'     => array(
						'description' => esc_html__( 'Adjust the space between multiple lines added to the design', 'dnwooe' ),
					),
				),
				'quick_view_popup_box_meta'  => array(
					'hide_text_align' => true,
					'css'             => array(
						'main'       => '%%order_class%% .dnwoo-product-summery .product_meta, %%order_class%% .dnwoo-product-summery .product_meta span a',
						'font'       => '%%order_class%% .dnwoo-product-summery .product_meta, %%order_class%% .dnwoo-product-summery .product_meta span a',
						'text_align' => '%%order_class%% .dnwoo-product-summery .product_meta, %%order_class%% .dnwoo-product-summery .product_meta span a',
						'color'      => '%%order_class%% .dnwoo-product-summery .product_meta, %%order_class%% .dnwoo-product-summery .product_meta span a',
						'important'  => 'all',
					),
					'toggle_slug'     => 'quickviewpopupbox',
					'sub_toggle'      => 'quickviewpopupbox_meta',
					'font'            => array(
						'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe' ),
					),
					'letter_spacing'  => array(
						'description' => esc_html__( 'Adjust the spacing between the letters of the text', 'dnwooe' ),
					),
					'text_alignment ' => array(
						'description' => esc_html__( 'Align the text to the left, right, center, or justify', 'dnwooe' ),
					),
					'line_height'     => array(
						'description' => esc_html__( 'Adjust the space between multiple lines added to the design', 'dnwooe' ),
					),
				),
				'view_cart'                  => array(
					'css'             => array(
						'main'      => '%%order_class%% .dnwoo_product_grid_buttons .added_to_cart',
						'font'      => '%%order_class%% .dnwoo_product_grid_buttons .added_to_cart',
						'color'     => '%%order_class%% .dnwoo_product_grid_buttons .added_to_cart',
						'important' => 'all',
					),
					'toggle_slug'     => 'viewcartbtn',
					'sub_toggle'      => 'button',
					'font'            => array(
						'description' => esc_html__( 'Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe' ),
					),
					'letter_spacing'  => array(
						'description' => esc_html__( 'Adjust the spacing between the letters of the text', 'dnwooe' ),
					),
					'text_alignment ' => array(
						'description' => esc_html__( 'Align the text to the left, right, center, or justify', 'dnwooe' ),
					),
					'line_height'     => array(
						'description' => esc_html__( 'Adjust the space between multiple lines added to the design', 'dnwooe' ),
					),
				),
				'pagination_filter_text' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_pages_wrapper ul li, %%order_class%% .dnwoo_pages_wrapper ul li.loadmore',
                    ),
                    'toggle_slug' => 'dnwoo_filter_pagination',
                    'font' => array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe'),
                    ),
                    'text_alignment ' => array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'letter_spacing' => array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'line_height' => array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
				'all_clear_filter_text' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_Pro_filter_menu_left_sidebar_wrapper .all_clear',
                    ),
					'toggle_slug'     => 'filter_text',
					'sub_toggle'      => 'filter_by_all_clear_text',
                    'font' => array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe'),
                    ),
                    'text_alignment ' => array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'letter_spacing' => array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'line_height' => array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
				'reset_filter_text' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_Pro_filter_menu_left_sidebar_wrapper .filter-reset',
                    ),
					'toggle_slug'     => 'filter_text',
					'sub_toggle'      => 'filter_by_reset_text',
                    'font' => array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe'),
                    ),
                    'text_alignment ' => array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'letter_spacing' => array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'line_height' => array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
				'filter_title_text' => array(
                    'hide_text_align' => true,
                    'css' => array(
                        'main' => '%%order_class%% .dnwoo_product_filter_sidebar_heading',
                    ),
					'toggle_slug'     => 'filter_title_text',
                    'font' => array(
                        'description' => esc_html__('Choose a font. All Google web fonts are available here. You can upload a custom font as well.', 'dnwooe'),
                    ),
                    'text_alignment ' => array(
                        'description' => esc_html__('Align the text to the left, right, center, or justify', 'dnwooe'),
                    ),
                    'letter_spacing' => array(
                        'description' => esc_html__('Adjust the spacing between the letters of the text', 'dnwooe'),
                    ),
                    'line_height' => array(
                        'description' => esc_html__('Adjust the space between multiple lines added to the design', 'dnwooe'),
                    ),
                ),
			),
			'borders'    => array(
				'default'               => array(
					'css' => array(
						'main' => array(
							'border_radii'  => '%%order_class%%',
							'border_styles' => '%%order_class%%',
						),
					),
				),
				'single_product'        => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_product_filter_item',
							'border_styles' => '%%order_class%% .dnwoo_product_filter_item',
						),
					),
					'label_prefix' => esc_html__( 'Product', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'item_settings',
				),
				'image_border'          => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_product_filter_item .image_link img',
							'border_styles' => '%%order_class%% .dnwoo_product_filter_item .image_link img',
						),
					),
					'label_prefix' => esc_html__( 'Image', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_filter_masonry_image_settings',
				),
				'text_border'           => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_product_filter_title',
							'border_styles' => '%%order_class%% .dnwoo_product_filter_title',
						),
					),
					'label_prefix' => esc_html__( 'Text', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'product_settings',
				),
				'addtocart'             => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .add_to_cart_button, %%order_class%% .dnwoo_choose_variable_option',
							'border_styles' => '%%order_class%% .add_to_cart_button, %%order_class%% .dnwoo_choose_variable_option',
						),
					),
					'label_prefix' => esc_html__( 'Add to Cart', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'cartbtn',
					'sub_toggle'   => 'addtocart',
				),
				'viewcart'              => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .added_to_cart',
							'border_styles' => '%%order_class%% .added_to_cart',
						),
					),
					'label_prefix' => esc_html__( 'View Cart', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'cartbtn',
					'sub_toggle'   => 'viewcart',
				),
				'wishlist'              => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_product_filter_badge_btn a.dnwoo-filter-wishlist-btn',
							'border_styles' => '%%order_class%% .dnwoo_product_filter_badge_btn a.dnwoo-filter-wishlist-btn',
						),
					),
					'label_prefix' => esc_html__( 'Wishlist', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'wishlist_settings',
				),
				'compare'               => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_product_filter_badge_btn .dnwoo-product-compare-btn',
							'border_styles' => '%%order_class%% .dnwoo_product_filter_badge_btn .dnwoo-product-compare-btn',
						),
					),
					'label_prefix' => esc_html__( 'Compare', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'compare_settings',
				),
				'quickview'             => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_product_filter_badge_btn .dnwoo-quickview',
							'border_styles' => '%%order_class%% .dnwoo_product_filter_badge_btn .dnwoo-quickview',
						),
					),
					'label_prefix' => esc_html__( 'Quickview', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'quickview_settings',
				),
				'quickview_popup_arrow' => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .product-images .swiper-button-next, %%order_class%% .product-images .swiper-button-prev',
							'border_styles' => '%%order_class%% .product-images .swiper-button-next, %%order_class%% .product-images .swiper-button-prev',
						),
					),
					'label_prefix' => '',
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'quickbox_popup_box_arrow',
				),
				'sale_badge'            => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_product_filter_onsale',
							'border_styles' => '%%order_class%% .dnwoo_product_filter_onsale',
						),
					),
					'label_prefix' => esc_html__( 'Sale Badge', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'badge',
					'sub_toggle'   => 'sale',
				),
				'outofstock_badge'      => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_product_filter_stockout',
							'border_styles' => '%%order_class%% .dnwoo_product_filter_stockout',
						),
					),
					'label_prefix' => esc_html__( 'Out of Stock Badge', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'badge',
					'sub_toggle'   => 'outofstock',
				),
				'featured_badge'        => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_product_filter_featured',
							'border_styles' => '%%order_class%% .dnwoo_product_filter_featured',
						),
					),
					'label_prefix' => esc_html__( 'Featured', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'badge',
					'sub_toggle'   => 'featured',
				),
				'category_filter'       => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_product_filter_menu',
							'border_styles' => '%%order_class%% .dnwoo_product_filter_menu',
						),
					),
					'label_prefix' => esc_html__( 'Filter', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'filter_settings',
					'sub_toggle'   => 'product_cat',
				),
				'category_filter_item'  => array(
					'css'          => array(
						'main' => array(
							'border_radii'  => '%%order_class%% .dnwoo_product_filter_menu li',
							'border_styles' => '%%order_class%% .dnwoo_product_filter_menu li',
						),
					),
					'label_prefix' => esc_html__( 'Single Category', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'filter_settings',
					'sub_toggle'   => 'product_cat',
				),
				'pagination_filter_border' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .dnwoo_pages_wrapper ul li,%%order_class%% .dnwoo_pages_wrapper ul li.loadmore',
                            'border_styles' => '%%order_class%% .dnwoo_pages_wrapper ul li,%%order_class%% .dnwoo_pages_wrapper ul li.loadmore',
                        ),
                    ),
                    'label_prefix' => '',
                    'tab_slug' => 'advanced',
                    'toggle_slug' => 'dnwoo_filter_pagination',
                ),
				'all_clear_filter_border' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .dnwoo_Pro_filter_menu_left_sidebar_wrapper .all_clear',
                            'border_styles' => '%%order_class%% .dnwoo_Pro_filter_menu_left_sidebar_wrapper .all_clear',
                        ),
                    ),
                    'label_prefix' => '',
					'toggle_slug'     => 'filter_text',
					'sub_toggle'      => 'filter_by_all_clear_text',
                ),
				'reset_filter_border' => array(
                    'css' => array(
                        'main' => array(
                            'border_radii' => '%%order_class%% .dnwoo_Pro_filter_menu_left_sidebar_wrapper .filter-reset',
                            'border_styles' => '%%order_class%% .dnwoo_Pro_filter_menu_left_sidebar_wrapper .filter-reset',
                        ),
                    ),
                    'label_prefix' => '',
					'toggle_slug'     => 'filter_text',
					'sub_toggle'      => 'filter_by_reset_text',
                ),
			),
			'box_shadow' => array(
				'default'              => array(
					'css' => array(
						'main'      => '%%order_class%%',
						'important' => 'all',
					),
				),
				'single_product'       => array(
					'css'          => array(
						'main'      => '%%order_class%% .dnwoo_product_filter_item',
						'important' => 'all',
					),
					'label_prefix' => esc_html__( 'Product', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'item_settings',
				),
				'image_box_shadow'     => array(
					'css'          => array(
						'main'      => '%%order_class%% .dnwoo_product_filter_item .dnwoo_product_filter_item_child',
						'important' => 'all',
					),
					'label_prefix' => esc_html__( 'Image', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'dnwoo_filter_masonry_image_settings',
				),
				'text_box_shadow'      => array(
					'css'          => array(
						'main'      => '%%order_class%% .dnwoo_product_filter_title',
						'important' => 'all',
					),
					'label_prefix' => esc_html__( 'Text', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'product_settings',
				),
				'addtocart'            => array(
					'css'          => array(
						'main'      => '%%order_class%% .add_to_cart_button, %%order_class%% .dnwoo_choose_variable_option',
						'important' => 'all',
					),
					'label_prefix' => esc_html__( 'Add to Cart', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'cartbtn',
					'sub_toggle'   => 'addtocart',
				),
				'viewcart'             => array(
					'css'          => array(
						'main'      => '%%order_class%% .added_to_cart',
						'important' => 'all',
					),
					'label_prefix' => esc_html__( 'View Cart', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'cartbtn',
					'sub_toggle'   => 'viewcart',
				),
				'wishlist'             => array(
					'css'          => array(
						'main'      => '%%order_class%% .dnwoo_product_filter_badge_btn a.dnwoo-filter-wishlist-btn',
						'important' => 'all',
					),
					'label_prefix' => esc_html__( 'Wishlist', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'wishlist_settings',
				),
				'compare'              => array(
					'css'          => array(
						'main'      => '%%order_class%% .dnwoo_product_filter_badge_btn .dnwoo-product-compare-btn',
						'important' => 'all',
					),
					'label_prefix' => esc_html__( 'Compare', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'compare_settings',
				),
				'quickview'            => array(
					'css'          => array(
						'main'      => '%%order_class%% .dnwoo_product_filter_badge_btn .dnwoo-quickview',
						'important' => 'all',
					),
					'label_prefix' => esc_html__( 'Quickview', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'quickview_settings',
				),
				'sale_badge'           => array(
					'css'          => array(
						'main'      => '%%order_class%% .dnwoo_product_filter_onsale',
						'important' => 'all',
					),
					'label_prefix' => esc_html__( 'Sale Badge', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'badge',
					'sub_toggle'   => 'sale',
				),
				'outofstock_badge'     => array(
					'css'          => array(
						'main'      => '%%order_class%% .dnwoo_product_filter_stockout',
						'important' => 'all',
					),
					'label_prefix' => esc_html__( 'Out of Stock Badge', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'badge',
					'sub_toggle'   => 'outofstock',
				),
				'featured_badge'       => array(
					'css'          => array(
						'main'      => '%%order_class%% .dnwoo_product_filter_featured',
						'important' => 'all',
					),
					'label_prefix' => esc_html__( 'Featured', 'dnwooe' ),
					'tab_slug'     => 'advanced',
					'toggle_slug'  => 'badge',
					'sub_toggle'   => 'featured',
				),
				'category_filter'      => array(
					'css'         => array(
						'main'      => '%%order_class%% .dnwoo_product_filter_menu',
						'important' => 'all',
					),
					'label'       => esc_html__( 'Filter Bar Box Shadow', 'dnwooe' ),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_settings',
					'sub_toggle'  => 'product_cat',
				),
				'category_filter_item' => array(
					'css'         => array(
						'main'      => '%%order_class%% .dnwoo_product_filter_menu li',
						'important' => 'all',
					),
					'label'       => esc_html__( 'Single Category Box Shadow', 'dnwooe' ),
					'tab_slug'    => 'advanced',
					'toggle_slug' => 'filter_settings',
					'sub_toggle'  => 'product_cat',
				),
			),
			'filters'    => array(
				'child_filters_target' => array(
					'tab_slug'      => 'advanced',
					'toggle_slug'   => 'dnwoo_filter_masonry_image_settings',
					'label'         => esc_html__( 'Image', 'dnwooe' ),
					'masonry_image' => array(
						'css' => array(
							'main'  => '%%order_class%% .dnwoo_product_filter_item img',
							'hover' => '%%order_class%% .dnwoo_product_filter_item:hover img',
						),
					),
				),
			),
			'height'     => false,
		);
		$this->custom_css_fields = array(
			'wrapper'                      => array(
				'label'    => esc_html__( 'Content Wrapper', 'dnwooe' ),
				'selector' => '%%order_class%% .dnwoo_product_filter_bottom_content',
			),
			'product_name'                 => array(
				'label'    => esc_html__( 'Product Name', 'dnwooe' ),
				'selector' => '%%order_class%% .dnwoo_product_filter_title',
			),
			'product_price'                => array(
				'label'    => esc_html__( 'Product Price', 'dnwooe' ),
				'selector' => '%%order_class%% .dnwoo_product_filter_item .dnwoo_product_filter_price',
			),
			'product_rating'               => array(
				'label'    => esc_html__( 'Product Rating', 'dnwooe' ),
				'selector' => '%%order_class%% .dnwoo_product_filter_item .dnwoo_product_ratting>.star-rating',
			),
			'add_to_cart'                  => array(
				'label'    => esc_html__( 'Add To Cart', 'dnwooe' ),
				'selector' => '%%order_class%% .dnwoo_product_filter_item .add_to_cart_button',
			),
			'add_to_cart_icon'             => array(
				'label'    => esc_html__( 'Add To Cart Icon', 'dnwooe' ),
				'selector' => '%%order_class%% .dnwoo_product_filter_item .add_to_cart_button span.icon_cart:before',
			),
			'select_variable_options'      => array(
				'label'    => esc_html__( 'Select Options for Variable Product Button', 'dnwooe' ),
				'selector' => '%%order_class%% .dnwoo_product_filter_item .dnwoo_choose_variable_option',
			),
			'select_variable_options_icon' => array(
				'label'    => esc_html__( 'Select Options Icon for Variable Product Button', 'dnwooe' ),
				'selector' => '%%order_class%% .dnwoo_product_filter_item .dnwoo_choose_variable_option span.icon_menu:before',
			),
			'view_cart'                    => array(
				'label'    => esc_html__( 'View Cart', 'dnwooe' ),
				'selector' => '%%order_class%% .dnwoo_product_filter_item .added_to_cart',
			),
			'wishlist'                     => array(
				'label'    => esc_html__( 'Wishlist Button', 'dnwooe' ),
				'selector' => '%%order_class%% .dnwoo_product_filter_badge_btn a.dnwoo-filter-wishlist-btn',
			),
			'wishlist_icon'                => array(
				'label'    => esc_html__( 'Wishlist Icon', 'dnwooe' ),
				'selector' => '%%order_class%% .dnwoo_product_filter_badge_btn a.dnwoo-filter-wishlist-btn span.icon_heart:before,%%order_class%% .dnwoo_product_filter_badge_btn a.dnwoo-filter-wishlist-btn span.icon_heart_alt:before',
			),
			'compare'                      => array(
				'label'    => esc_html__( 'Compare Button', 'dnwooe' ),
				'selector' => '%%order_class%% .dnwoo_product_filter_badge_btn .dnwoo-product-compare-btn',
			),
			'compare_icon'                 => array(
				'label'    => esc_html__( 'Compare Icon', 'dnwooe' ),
				'selector' => '%%order_class%% .dnwoo_product_filter_badge_btn .dnwoo-product-compare-btn .icon_left-right::before',
			),
			'quickview'                    => array(
				'label'    => esc_html__( 'Quickview Button', 'dnwooe' ),
				'selector' => '%%order_class%% .dnwoo_product_filter_badge_btn .dnwoo-quickview',
			),
			'quickview_icon'               => array(
				'label'    => esc_html__( 'Quickview Icon', 'dnwooe' ),
				'selector' => '%%order_class%% .dnwoo_product_filter_badge_btn .dnwoo-quickview.icon_quickview::before',
			),
			'filter_wrapper'               => array(
				'label'    => esc_html__( 'Filter Bar', 'dnwooe' ),
				'selector' => '%%order_class%% .dnwoo_product_filter_menu',
			),
			'filter_item'                  => array(
				'label'    => esc_html__( 'Filter Item', 'dnwooe' ),
				'selector' => '%%order_class%% .dnwoo_product_filter_menu li',
			),
		);
	}

	public function get_fields() {
		$fields = array(
			'type'                   => array(
				'label'            => esc_html__( 'Product View Type', 'dnwooe' ),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'options'          => array(
					'default'          => esc_html__( 'Default (Menu ordering + name)', 'dnwooe' ),
					'latest'           => esc_html__( 'Latest Products', 'dnwooe' ),
					'featured'         => esc_html__( 'Featured Products', 'dnwooe' ),
					'sale'             => esc_html__( 'Sale Products', 'dnwooe' ),
					'best_selling'     => esc_html__( 'Best Selling Products', 'dnwooe' ),
					'top_rated'        => esc_html__( 'Top Rated Products', 'dnwooe' ),
					'product_category' => esc_html__( 'Product Category', 'dnwooe' ),
				),
				'default_on_front' => 'default',
				'description'      => esc_html__( 'Choose which type of product view you would like to display.', 'dnwooe' ),
				'toggle_slug'      => 'main_content',
				'computed_affects' => array(
					'__nextwooproductfilmas',
				),
			),
			'hide_out_of_stock'      => array(
				'label'            => esc_html__( 'Hide Out of Stock', 'dnwooe' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => esc_html__( 'Yes', 'dnwooe' ),
					'off' => esc_html__( 'No', 'dnwooe' ),
				),
				'default'          => 'on',
				'default_on_front' => 'on',
				'toggle_slug'      => 'main_content',
				'description'      => esc_html__( 'Hide out of stock product from the accordion.', 'dnwooe' ),
				'computed_affects' => array(
					'__nextwooproductfilmas',
				),
			),
			'dnwoo_badge_outofstock' => array(
				'label'           => esc_html__( 'Out of stock Product Text', 'dnwooe' ),
				'type'            => 'text',
				'default'         => 'Sold',
				'option_category' => 'configuration',
				'description'     => esc_html__( 'Define the Out of stock product text for your badge.', 'dnwooe' ),
				'toggle_slug'     => 'main_content',
				'dynamic_content' => 'text',
				'show_if'         => array(
					'hide_out_of_stock' => 'off',
				),
			),
			'thumbnail_size'         => array(
				'label'            => esc_html__( 'Thumbnail Size', 'dnwooe' ),
				'description'      => esc_html__( 'Here you can specify the size of product image.', 'dnwooe' ),
				'type'             => 'select',
				'options'          => array(
					'full'                  => esc_html__( 'Full', 'dnwooe' ),
					'woocommerce_thumbnail' => esc_html__( 'Woocommerce Thumbnail', 'dnwooe' ),
					'woocommerce_single'    => esc_html__( 'Woocommerce Single', 'dnwooe' ),
				),
				'default'          => 'woocommerce_thumbnail',
				'default_on_front' => 'woocommerce_thumbnail',
				'option_category'  => 'basic_option',
				'toggle_slug'      => 'main_content',
				'computed_affects' => array(
					'__nextwooproductfilmas',
				),
			),
			'include_categories'     => array(
				'label'            => esc_html__( 'Include Categories', 'dnwooe' ),
				'type'             => 'categories',
				'renderer_options' => array(
					'use_terms'  => true,
					'term_name'  => 'product_cat',
					'field_name' => 'et_pb_include_product_cat',
				),
				'meta_categories'  => array(
					'all' => esc_html__( 'All Categories', 'dnwooe' ),
				),
				'toggle_slug'      => 'main_content',
				'description'      => esc_html__( 'Select Categories. If no category is selected, products from all categories will be displayed.', 'dnwooe' ),
				'computed_affects' => array(
					'__nextwooproductfilmas',
				),
			),
			'products_number'        => array(
				'label'            => esc_html__( 'Product Count', 'dnwooe' ),
				'type'             => 'text',
				'option_category'  => 'configuration',
				'description'      => esc_html__( 'Define the number of product that should be displayed per page.', 'dnwooe' ),
				'computed_affects' => array(
					'__nextwooproductfilmas',
				),
				'mobile_options'   => true,
				'toggle_slug'      => 'main_content',
				'default'          => 10,
			),
			'offset'                 => array(
				'label'            => esc_html__( 'Product Offset', 'dnwooe' ),
				'type'             => 'text',
				'option_category'  => 'configuration',
				'description'      => esc_html__( 'Define the number of product that should be cut down from first.', 'dnwooe' ),
				'computed_affects' => array(
					'__nextwooproductfilmas',
				),
				'toggle_slug'      => 'main_content',
				'default'          => '',
			),
			'order'                  => array(
				'label'            => esc_html__( 'Sorted By', 'dnwooe' ),
				'description'      => esc_html__( 'Choose default sorting option', 'dnwooe' ),
				'type'             => 'select',
				'option_category'  => 'basic_option',
				'toggle_slug'      => 'main_content',
				'default'          => 'ASC',
				'options'          => array(
					'ASC'  => esc_html__( 'Ascending', 'dnwooe' ),
					'DESC' => esc_html__( 'Descending', 'dnwooe' ),
				),
				'default_on_front' => 'ASC',
				'computed_affects' => array( '__nextwooproductfilmas' ),
			),
			'orderby'                => array(
				'label'            => esc_html__( 'Order by', 'dnwooe' ),
				'type'             => 'select',
				'option_category'  => 'configuration',
				'options'          => array(
					'date'     => esc_html__( 'Date', 'dnwooe' ),
					'modified' => esc_html__( 'Modified Date', 'dnwooe' ),
					'title'    => esc_html__( 'Title', 'dnwooe' ),
					'name'     => esc_html__( 'Slug', 'dnwooe' ),
					'ID'       => esc_html__( 'ID', 'dnwooe' ),
					'rand'     => esc_html__( 'Random', 'dnwooe' ),
					'none'     => esc_html__( 'None', 'dnwooe' ),
				),
				'default'          => 'date',
				'show_if_not'      => array(
					'type' => array( 'latest', 'best_selling', 'top_rated', 'featured', 'product_category' ),
				),
				'option_category'  => 'basic_option',
				'toggle_slug'      => 'main_content',
				'description'      => esc_html__( 'Here you can specify the order in which the products will be displayed.', 'dnwooe' ),
				'computed_affects' => array(
					'__nextwooproductfilmas',
				),
			),
			'__nextwooproductfilmas' => array(
				'type'                => 'computed',
				'computed_callback'   => array( 'DNWooFilterMasonry', 'get_products' ),
				'computed_depends_on' => array(
					'type',
					'hide_out_of_stock',
					'thumbnail_size',
					'order',
					'products_number',
					'include_categories',
					'orderby',
					'offset',
					'accordion_style',
					'expand_last_item',
					'dnwoo_columns',
				),
			),
		);

		$show_hide = array(
			'show_product_filter'              => array(
				'label'           => esc_html__( 'Show Product Filter', 'dnwooe' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'dnwooe' ),
					'off' => esc_html__( 'No', 'dnwooe' ),
				),
				'default'         => 'on',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'display_setting',
				'description'     => esc_html__( 'Choose whether or not the product filter menu should be visible.', 'dnwooe' ),
			),
			'show_filter_menu'    => array(
				'label'           => esc_html__( 'Filter Bar Position', 'dnwooe' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'left_sidebar'  => esc_html__( 'Left', 'dnwooe' ),
					'right_sidebar' => esc_html__( 'Right', 'dnwooe' ),
					'default'       => esc_html__( 'Top', 'dnwooe' ),
				),
				'default'         => 'default',
				'description'     => esc_html__( 'Choose the filter bar position from top, left, & right.', 'dnwooe' ),
				'toggle_slug'     => 'display_setting',
				'mobile_options'  => true,
				'responsive'      => true,
				'show_if'         => array(
					'show_product_filter' => 'on',
				),
			),
			'dnwoo_category_title'=> array(
				'label'           => esc_html__( 'Change Categories Text', 'dnwooe' ),
				'type'            => 'text',
				'default'         => 'Categories',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Change the default Categories text', 'dnwooe' ),
				'toggle_slug'     => 'display_setting',
				'dynamic_content' => 'text',
				'show_if_not'         => array(
					'show_filter_menu' => 'default',
				),
			),
			'category_style'      	=> array(
				'label'           => esc_html__( 'Category Style', 'dnwooe' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'checkbox'  	=> esc_html__( 'Checkbox', 'dnwooe' ),
					'list'  		=> esc_html__( 'List', 'dnwooe' ),
				),
				'default'         => 'list',
				'description'     => esc_html__( 'Select Category Style', 'dnwooe' ),
				'toggle_slug'     => 'display_setting',
				'mobile_options'  => true,
				'responsive'      => true,
				'show_if_not'         => array(
					'show_filter_menu' => 'default',
				),
			),
			'single_category'     	=> array(
				'label'            => esc_html__( 'Filter single category item(s) in the category filter option', 'dnwooe' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'On' ),
					'off' => et_builder_i18n( 'Off' ),
				),
				'default'          => 'on',
				'default_on_front' => 'on',
				'toggle_slug'      => 'display_setting',
				'description'      => esc_html__( ' Enable/disable the option to select multiple individual categories, from the category filter.', 'dnwooe' ),
				'mobile_options'   => true,
				'hover'            => 'tabs',
				'show_if_not'         => array(
					'show_filter_menu' => 'default',
				),
			),
			'show_sub_categories'              => array(
				'label'            => esc_html__( 'Show Sub Categories', 'dnwooe' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'On' ),
					'off' => et_builder_i18n( 'Off' ),
				),
				'default'          => 'on',
				'default_on_front' => 'on',
				'toggle_slug'      => 'display_setting',
				'description'      => esc_html__( 'Display subcategories within parent categories.', 'dnwooe' ),
				'mobile_options'   => true,
				'hover'            => 'tabs',
				'show_if_not'         => array(
					'show_filter_menu' => 'default',
				),
			),
			'show_all_clear'   => array(
				'label'            => esc_html__( 'Reset all selections', 'dnwooe' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'On' ),
					'off' => et_builder_i18n( 'Off' ),
				),
				'default'          => 'off',
				'default_on_front' => 'off',
				'toggle_slug'      => 'display_setting',
				'description'      => esc_html__( 'This enables a reset option to clear all selected filter options such as category, ratings, etc.', 'dnwooe' ),
				'mobile_options'   => true,
				'hover'            => 'tabs',
				'show_if_not'         => array(
					'show_filter_menu' => 'default',
				),
			),
			'dnwoo_reset_all_clear_text'          => array(
				'label'           => esc_html__( 'Change Filter Reset all selections Text', 'dnwooe' ),
				'type'            => 'text',
				'default'         => 'Clear',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Change the default "Clear" text in the reset all selection', 'dnwooe' ),
				'toggle_slug'     => 'display_setting',
				'dynamic_content' => 'text',
				'show_if'         => array(
					'show_all_clear' => 'on',
				),
			),
			'show_reset'   => array(
				'label'            => esc_html__( 'Reset Filter', 'dnwooe' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'On' ),
					'off' => et_builder_i18n( 'Off' ),
				),
				'default'          => 'on',
				'default_on_front' => 'on',
				'toggle_slug'      => 'display_setting',
				'description'      => esc_html__( 'Display reset option for individual filters.', 'dnwooe' ),
				'mobile_options'   => true,
				'hover'            => 'tabs',
				'show_if_not'         => array(
					'show_filter_menu' => 'default',
				),
			),
			'dnwoo_reset_text'          => array(
				'label'           => esc_html__( 'Change Filter Reset Text', 'dnwooe' ),
				'type'            => 'text',
				'default'         => 'Reset',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Change the default Reset text. Only available in the left & right filter bar.', 'dnwooe' ),
				'toggle_slug'     => 'display_setting',
				'dynamic_content' => 'text',
				'show_if'         => array(
					'show_reset' => 'on',
				),
			),
			'show_rating_filter'               => array(
				'label'            => esc_html__( 'Filter by Rating', 'dnwooe' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'On' ),
					'off' => et_builder_i18n( 'Off' ),
				),
				'default'          => 'off',
				'default_on_front' => 'off',
				'toggle_slug'      => 'display_setting',
				'description'      => esc_html__( 'Enable filter option based on user ratings. Only available in the left & right filter bar.', 'dnwooe' ),
				'mobile_options'   => true,
				'hover'            => 'tabs',
				'show_if_not'         => array(
					'show_filter_menu' => 'default',
				),
			),
			'dnwoo_filter_rating_text'          => array(
				'label'           => esc_html__( 'Filter Rating Text', 'dnwooe' ),
				'type'            => 'text',
				'default'         => 'Rating',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Change the default rating text', 'dnwooe' ),
				'toggle_slug'     => 'display_setting',
				'dynamic_content' => 'text',
				'show_if'         => array(
					'show_rating_filter' => 'on',
				),
			),
			'dnwoo_filter_width'               => array(
				'label'           => esc_html__( 'Menu Size', 'dnwooe' ),
				'type'            => 'range',
				'option_category' => 'configuration',
				'toggle_slug'     => 'display_setting',
				'description'      => esc_html__( 'Adjust category menu size by increasing or decreasing the slider value. ', 'dnwooe' ),
				// 'default'         => '100%',
				'default'         => '20%',
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'mobile_options'  => true,
				'responsive'      => true,
				// 'unitless'         => true,
				'allowed_units'   => array( '%' ),
				'show_if'         => array(
					'show_product_filter' => 'on',
				),
			),
			'show_all_text_field'              => array(
				'label'           => esc_html__( 'Show All Text in Filter Menu', 'dnwooe' ),
				'description'     => esc_html__( 'Show/hide the ‘’All’’ category from the category filter option.', 'dnwooe' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'dnwooe' ),
					'off' => esc_html__( 'No', 'dnwooe' ),
				),
				'default'         => 'on',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'display_setting',
				'show_if'         => array(
					'show_product_filter' => 'on',
				),
			),
			'dnwoo_category_all_text'          => array(
				'label'           => esc_html__( 'Change Filter All Text', 'dnwooe' ),
				'type'            => 'text',
				'default'         => 'All',
				'option_category' => 'basic_option',
				'description'     => esc_html__( "Customize the 'All' category text to match your website's messaging.", 'dnwooe' ),
				'toggle_slug'     => 'display_setting',
				'dynamic_content' => 'text',
				'show_if'         => array(
					'show_product_filter' => 'on',
				),
			),


			'show_add_to_cart'                 => array(
				'label'           => esc_html__( 'Show Add to Cart', 'dnwooe' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'dnwooe' ),
					'off' => esc_html__( 'No', 'dnwooe' ),
				),
				'default'         => 'on',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'display_setting',
				'description'     => esc_html__( "Choose whether the 'Add to Cart' button is visible.", 'dnwooe' ),
			),
			'dnwoo_show_add_to_cart_text'      => array(
				'label'           => esc_html__( 'Add to Cart Text', 'dnwooe' ),
				'type'            => 'text',
				'default'         => 'Add to cart',
				'option_category' => 'basic_option',
				'description'     => esc_html__( "Define the text for the 'Add to Cart' button.", 'dnwooe' ),
				'toggle_slug'     => 'display_setting',
				'dynamic_content' => 'text',
				'show_if'         => array(
					'show_add_to_cart' => 'on',
				),
			),
			'dnwoo_select_options_text'        => array(
				'label'           => esc_html__( 'Select Options Button Text', 'dnwooe' ),
				'type'            => 'text',
				'default'         => 'Select Options',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Define the Select Options Button text for variable products.', 'dnwooe' ),
				'toggle_slug'     => 'display_setting',
				'dynamic_content' => 'text',
				'show_if'         => array(
					'show_add_to_cart' => 'on',
				),
			),
			'show_wishlist_button'             => array(
				'label'           => esc_html__( 'Show Wishlist', 'dnwooe' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'dnwooe' ),
					'off' => esc_html__( 'No', 'dnwooe' ),
				),
				'default'         => 'off',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'display_setting',
				'description'     => esc_html__( 'Choose whether or not the Wishlist button should be visible.', 'dnwooe' ),
			),
			'dnwoo_wishlist_text'              => array(
				'label'           => esc_html__( 'Wishlist Button Text', 'dnwooe' ),
				'type'            => 'text',
				'default'         => 'Wishlist',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Define the Wishlist Button text for variable products.', 'dnwooe' ),
				'toggle_slug'     => 'display_setting',
				'dynamic_content' => 'text',
				'show_if'         => array(
					'show_wishlist_button' => 'on',
				),
			),
			'show_compare_button'              => array(
				'label'           => esc_html__( 'Show Compare', 'dnwooe' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'dnwooe' ),
					'off' => esc_html__( 'No', 'dnwooe' ),
				),
				'default'         => 'off',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'display_setting',
				'description'     => esc_html__( 'Choose whether or not the Compare button should be visible.', 'dnwooe' ),
			),
			'dnwoo_compare_text'               => array(
				'label'           => esc_html__( 'Compare Button Text', 'dnwooe' ),
				'type'            => 'text',
				'default'         => 'Compare',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Define the Compare Button text for variable products.', 'dnwooe' ),
				'toggle_slug'     => 'display_setting',
				'dynamic_content' => 'text',
				'show_if'         => array(
					'show_compare_button' => 'on',
				),
			),
			'show_quickview_button'            => array(
				'label'           => esc_html__( 'Show Quickview', 'dnwooe' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'dnwooe' ),
					'off' => esc_html__( 'No', 'dnwooe' ),
				),
				'default'         => 'off',
				'tab_slug'        => 'general',
				'toggle_slug'     => 'display_setting',
				'description'     => esc_html__( 'Choose whether or not the Quickview button should be visible.', 'dnwooe' ),
			),
			'dnwoo_quickview_text'             => array(
				'label'           => esc_html__( 'Quickview Button Text', 'dnwooe' ),
				'type'            => 'text',
				'default'         => 'Quickview',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Define the Quickview Button text for variable products.', 'dnwooe' ),
				'toggle_slug'     => 'display_setting',
				'dynamic_content' => 'text',
				'show_if'         => array(
					'show_quickview_button' => 'on',
				),
			),
			'quickviewpopupbox_arrow_color'    => array(
				'label'        => esc_html__( 'Quick View Arrow Color', 'dnwooe' ),
				'description'  => esc_html__( 'Here you can define a custom color for Quick View Arrow', 'dnwooe' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'quickbox_popup_box_arrow',
			),
			'quickviewpopupbox_closebtn_color' => array(
				'label'        => esc_html__( 'Quick View Arrow Color', 'dnwooe' ),
				'description'  => esc_html__( 'Here you can define a custom color for Quick View close button', 'dnwooe' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'quickview_popup_box_close_btn',
			),
			'show_default_sorting'             => array(
				'label'            => esc_html__( 'Show Default Sorting', 'dnwooe' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'On' ),
					'off' => et_builder_i18n( 'Off' ),
				),
				'default'          => 'off',
				'default_on_front' => 'off',
				'toggle_slug'      => 'display_setting',
				'description'      => esc_html__( 'Enable default sorting to arrange items by preset criteria, such as price, popularity, etc.', 'dnwooe' ),
			),
			'show_price_text'     => array(
				'label'           => esc_html__( 'Filter by Price ', 'dnwooe' ),
				'type'            => 'yes_no_button',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'dnwooe' ),
					'off' => esc_html__( 'No', 'dnwooe' ),
				),
				'default'         => 'on',
				'option_category' => 'configuration',
				'toggle_slug'     => 'display_setting',
				'description'     => esc_html__( 'Enable product filter by price.', 'dnwooe' ),
			),
			'show_rating'                      => array(
				'label'            => esc_html__( 'Show Star Rating on Item', 'dnwooe' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'On' ),
					'off' => et_builder_i18n( 'Off' ),
				),
				'default'          => 'on',
				'default_on_front' => 'on',
				'toggle_slug'      => 'display_setting',
				'description'      => esc_html__( 'Enable user rating on showcased items. ', 'dnwooe' ),
				'mobile_options'   => true,
				'hover'            => 'tabs',
			),
			'show_featured_product'            => array(
				'label'            => esc_html__( 'Featured Product Badge', 'dnwooe' ),
				'type'             => 'yes_no_button',
				'option_category'  => 'configuration',
				'options'          => array(
					'on'  => et_builder_i18n( 'On' ),
					'off' => et_builder_i18n( 'Off' ),
				),
				'default'          => 'on',
				'default_on_front' => 'on',
				'toggle_slug'      => 'display_setting',
				'description'      => esc_html__( 'Enable the featured product badge on your items.', 'dnwooe' ),
			),
			'dnwoo_badge_featured'             => array(
				'label'           => esc_html__( 'Featured Product Badge Text', 'dnwooe' ),
				'type'            => 'text',
				'default'         => 'Hot',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Customize the text for your featured product badge.', 'dnwooe' ),
				'toggle_slug'     => 'display_setting',
				'dynamic_content' => 'text',
				'show_if'         => array(
					'show_featured_product' => 'on',
				),
			),
			'show_badge'                       => array(
				'label'           => esc_html__( 'Badge Type', 'dnwooe' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'none'       => esc_html__( 'None', 'dnwooe' ),
					'sale'       => esc_html__( 'Sale', 'dnwooe' ),
					'percentage' => esc_html__( 'Percentage', 'dnwooe' ),
				),
				'default'         => 'sale',
				'description'     => esc_html__( 'Enable or disable badges, choose between sale or percentage badge styles.', 'dnwooe' ),
				'toggle_slug'     => 'display_setting',
				'mobile_options'  => true,
				'hover'           => 'tabs',
			),
			'dnwoo_badge_sale'                 => array(
				'label'           => esc_html__( 'Badge type text', 'dnwooe' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Customize the text on your sale badge.', 'dnwooe' ),
				'toggle_slug'     => 'display_setting',
				'dynamic_content' => 'text',
				'show_if'         => array(
					'show_badge' => 'sale',
				),
			),
			'dnwoo_badge_percentage'           => array(
				'label'           => esc_html__( 'Percentage Badge type text', 'dnwooe' ),
				'type'            => 'text',
				'default'         => 'off',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Define the percentage badge type text for your product badge.', 'dnwooe' ),
				'toggle_slug'     => 'display_setting',
				'dynamic_content' => 'text',
				'show_if'         => array(
					'show_badge' => 'percentage',
				),
			),
		);

		$pagination_filter = array(
			'show_pagination'     => array(
				'label'           => esc_html__( 'Pagination Type', 'dnwooe' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'none'     => esc_html__( 'None', 'dnwooe' ),
					'numbers'  => esc_html__( 'Numbers', 'dnwooe' ),
					'loadmore' => esc_html__( 'Load More', 'dnwooe' ),
				),
				'default'         => 'none',
				'description'     => esc_html__( "Select pagination by page numbers or a 'load more' button.", 'dnwooe' ),
				'toggle_slug'     => 'display_setting',
				'mobile_options'  => true,
				'hover'           => 'tabs',
			),
			'loadmore_text' => array(
                'label' => esc_html__('Load More Text', 'dnwooe'),
                'type' => 'text',
                'default' => esc_html__('Load More', 'dnwooe'),
                'option_category' => 'configuration',
                'toggle_slug' => 'display_setting',
                'show_if' => array(
                    'show_pagination' => 'loadmore',
                ),
            ),
            'pagination_alignment' => array(
                'label' => esc_html__('Alignment', 'dnwooe'),
                'description' => esc_html__('Align to the left, right or center.', 'dnwooe'),
                'type' => 'align',
                'option_category' => 'layout',
                'options' => et_builder_get_text_orientation_options(array('justified')),
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnwoo_filter_pagination',
                'default' => 'center',
                'mobile_options' => true,
                'responsive' => true,
                'show_if_not' => array(
                    'show_pagination' => 'none',
                ),
            ),
            'pagination_bg_color' => array(
                'label' => esc_html__('Background Color', 'dnwooe'),
                'description' => esc_html__('Here you can define a custom color for pagination Background color', 'dnwooe'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnwoo_filter_pagination',
                'hover' => 'tabs',
                'show_if_not' => array(
                    'show_pagination' => 'none',
                ),
            ),
            'pagination_active_bg_color' => array(
                'label' => esc_html__('Active Background Color', 'dnwooe'),
                'description' => esc_html__('Here you can define a custom color for active page number Background color', 'dnwooe'),
                'type' => 'color-alpha',
                'custom_color' => true,
                'tab_slug' => 'advanced',
                'toggle_slug' => 'dnwoo_filter_pagination',
                'hover' => 'tabs',
                'show_if' => array(
                    'show_pagination' => 'numbers',
                ),
            ),
			'pagination_number_active_color'   => array(
				'label'        => esc_html__( 'Number Active Color', 'dnwooe' ),
				'description'  => esc_html__( 'Here you can define a custom color for number active color', 'dnwooe' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'dnwoo_filter_pagination',
                'show_if' => array(
                    'show_pagination' => 'numbers',
                ),
			),
        );

		$isotope_fields = array(
			'dnwoo_columns'               => array(
				'label'            => esc_html__( 'Columns', 'dnwooe' ),
				'type'             => 'range',
				'option_category'  => 'basic_option',
				'toggle_slug'      => 'dnwoo_filter_grid',
				'tab_slug'         => 'advanced',
				'default'          => '4',
				'range_settings'   => array(
					'min'  => '1',
					'max'  => '10',
					'step' => '1',
				),
				'mobile_options'   => true,
				'responsive'       => true,
				'unitless'         => true,
				'computed_affects' => array(
					'__nextwooproductfilmas',
				),
			),
			'dnwoo_gutter'                => array(
				'label'           => esc_html__( 'Gutter', 'dnwooe' ),
				'type'            => 'range',
				'option_category' => 'layout',
				'toggle_slug'     => 'dnwoo_filter_grid',
				'tab_slug'        => 'advanced',
				'default'         => '10',
				'range_settings'  => array(
					'min'  => '0',
					'max'  => '100',
					'step' => '1',
				),
				'mobile_options'  => true,
				'responsive'      => true,
				'unitless'        => true,
			),
			'filter_active_color'         => array(
				'label'        => esc_html__( 'Filter Active Color', 'dnwooe' ),
				'description'  => esc_html__( 'Choose a color for the active category text', 'dnwooe' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'filter_settings',
				'sub_toggle'   => 'product_cat',
				'show_if'      => array(
					'show_product_filter' => 'on',
				),
			),
			'filter_item_separator_color' => array(
				'label'        => esc_html__( 'Separator Color', 'dnwooe' ),
				'description'  => esc_html__( 'Choose a color for the category separator', 'dnwooe' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'filter_settings',
				'sub_toggle'   => 'product_cat',
				'show_if'      => array(
					'show_product_filter' => 'on',
				),
			),
		);

		$margin_padding = array(
			'dnwoo_filter_masonry_content_wrapper_margin'  => array(
				'label'           => esc_html__( 'Content Wrapper Margin', 'dnwooe' ),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
			),
			'dnwoo_filter_masonry_content_wrapper_padding' => array(
				'label'           => esc_html__( 'Content Wrapper Padding', 'dnwooe' ),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'default'         => '10px|10px|10px|10px',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
			),
			'dnwoo_filter_masonry_product_name_margin'     => array(
				'label'           => esc_html__( 'Product Name Margin', 'dnwooe' ),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
			),
			'dnwoo_filter_masonry_product_name_padding'    => array(
				'label'           => esc_html__( 'Product Name Padding', 'dnwooe' ),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
			),
			'dnwoo_filter_masonry_product_rating_margin'   => array(
				'label'           => esc_html__( 'Product Rating Margin', 'dnwooe' ),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'default'         => '5px|0|0|0',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
			),
			'dnwoo_filter_masonry_product_price_margin'    => array(
				'label'           => esc_html__( 'Product Price Margin', 'dnwooe' ),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
			),
			'dnwoo_filter_masonry_product_price_padding'   => array(
				'label'           => esc_html__( 'Product Price Padding', 'dnwooe' ),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
			),
			'dnwoo_filter_masonry_addtocart_margin'        => array(
				'label'           => esc_html__( 'Add To Cart Margin', 'dnwooe' ),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
			),
			'dnwoo_filter_masonry_addtocart_padding'       => array(
				'label'           => esc_html__( 'Add To Cart Padding', 'dnwooe' ),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
			),
			'dnwoo_filter_masonry_viewcart_margin'         => array(
				'label'           => esc_html__( 'View Cart Margin', 'dnwooe' ),
				'type'            => 'custom_margin',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
			),
			'dnwoo_filter_masonry_viewcart_padding'        => array(
				'label'           => esc_html__( 'View Cart Padding', 'dnwooe' ),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
			),
			'wishlist_margin'                              => array(
				'label'           => esc_html__( 'Wishlist Margin', 'dnwooe' ),
				'type'            => 'custom_margin',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
			),
			'wishlist_padding'                             => array(
				'label'           => esc_html__( 'Wishlist Padding', 'dnwooe' ),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
			),
			'compare_margin'                               => array(
				'label'           => esc_html__( 'Compare Margin', 'dnwooe' ),
				'type'            => 'custom_margin',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
			),
			'compare_padding'                              => array(
				'label'           => esc_html__( 'Compare Padding', 'dnwooe' ),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
			),
			'quickview_margin'                             => array(
				'label'           => esc_html__( 'Quickview Margin', 'dnwooe' ),
				'type'            => 'custom_margin',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
			),
			'quickview_padding'                            => array(
				'label'           => esc_html__( 'Quickview Padding', 'dnwooe' ),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
			),
			'dnwoo_filter_masonry_filter_wrapper_margin'   => array(
				'label'           => esc_html__( 'Filter Wrapper Margin', 'dnwooe' ),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
			),
			'dnwoo_filter_masonry_filter_wrapper_padding'  => array(
				'label'           => esc_html__( 'Filter Wrapper Padding', 'dnwooe' ),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'default'         => '0|0|0|0',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
			),
			'dnwoo_filter_masonry_filter_item_margin'      => array(
				'label'           => esc_html__( 'Filter Item Margin', 'dnwooe' ),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'default'         => '0|20px|10px|0',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
			),
			'dnwoo_filter_masonry_filter_item_padding'     => array(
				'label'           => esc_html__( 'Filter Item Top Bar Padding', 'dnwooe' ),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'default'         => '8px|15px|8px|15px',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
				'show_if'   	  => array(
					'show_filter_menu' => 'default',
				)
			),
			'dnwoo_filter_masonry_filter_item_left_right_padding'     => array(
				'label'           => esc_html__( 'Filter Item Left Right Padding', 'dnwooe' ),
				'type'            => 'custom_padding',
				'mobile_options'  => true,
				'hover'           => 'tabs',
				'default'         => '8px|15px|8px|0',
				'allowed_units'   => array( '%', 'em', 'rem', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ex', 'vh', 'vw' ),
				'option_category' => 'layout',
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'margin_padding',
				'show_if_not'   	  => array(
					'show_filter_menu' => 'default',
				)
			),
		);
		$filter_rating  = array(
			'filter_rating_active_color'   => array(
				'label'        => esc_html__( 'Active Color', 'dnwooe' ),
				'description'  => esc_html__( 'Here you can define a custom color for active rating star', 'dnwooe' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'dnwoo_filter_rating',
			),
			'filter_rating_inactive_color' => array(
				'label'        => esc_html__( 'Inactive Color', 'dnwooe' ),
				'description'  => esc_html__( 'Here you can define a custom color for nonactive rating star', 'dnwooe' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'dnwoo_filter_rating',
			),
		);
		$rating         = array(
			'rating_alignment'      => array(
				'label'           => esc_html__( 'Alignment', 'dnwooe' ),
				'description'     => esc_html__( 'Align to the left, right or center.', 'dnwooe' ),
				'type'            => 'align',
				'option_category' => 'layout',
				'options'         => et_builder_get_text_orientation_options( array( 'justified' ) ),
				'tab_slug'        => 'advanced',
				'toggle_slug'     => 'dnwoo_rating',
				'default'         => 'left',
				'mobile_options'  => true,
				'responsive'      => true,
				'show_if'         => array(
					'show_rating' => 'on',
				),
			),
			'rating_active_color'   => array(
				'label'        => esc_html__( 'Active Color', 'dnwooe' ),
				'description'  => esc_html__( 'Here you can define a custom color for active rating star', 'dnwooe' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'dnwoo_rating',
				'show_if'      => array(
					'show_rating' => 'on',
				),
			),
			'rating_inactive_color' => array(
				'label'        => esc_html__( 'Inactive Color', 'dnwooe' ),
				'description'  => esc_html__( 'Here you can define a custom color for nonactive rating star', 'dnwooe' ),
				'type'         => 'color-alpha',
				'custom_color' => true,
				'tab_slug'     => 'advanced',
				'toggle_slug'  => 'dnwoo_rating',
				'show_if'      => array(
					'show_rating' => 'on',
				),
			),
		);

		$opt              = array(
			'hover'       => 'tabs',
			'description' => esc_html__( 'Add a background fill color or gradient for the description text', 'dnwooe' ),
		);
		$content_bg_color = DNWoo_Common::background_fields( $this, 'content_', 'Background Color', 'item_settings', 'advanced', $opt );

		$category_bg_color = DNWoo_Common::background_fields(
			$this,
			'category_',
			'Background Color',
			'filter_settings',
			'advanced',
			array(
				'hover'       => 'tabs',
				'description' => esc_html__( 'Add a background fill color or gradient for the description text', 'dnwooe' ),
				'sub_toggle'  => 'filter_bg',
				'show_if'     => array(
					'show_product_filter' => 'on',
				),
			)
		);

		$category_item_bg_color = DNWoo_Common::background_fields(
			$this,
			'category_item_',
			'Single Category Background Color',
			'filter_settings',
			'advanced',
			array(
				'hover'       => 'tabs',
				'description' => esc_html__( 'Add a background fill color or gradient for the filter category item text', 'dnwooe' ),
				'sub_toggle'  => 'filter_bg',
				'show_if'     => array(
					'show_product_filter' => 'on',
				),
			)
		);

		$category_item_active_bg_color = DNWoo_Common::background_fields(
			$this,
			'category_item_active_',
			'Active Single Category Background Color',
			'filter_settings',
			'advanced',
			array(
				'hover'       => 'tabs',
				'description' => esc_html__( 'Add a background fill color or gradient for the filter category active item text', 'dnwooe' ),
				'sub_toggle'  => 'filter_bg',
				'show_if'     => array(
					'show_product_filter' => 'on',
				),
			)
		);

		$addtocart_bg_color = DNWoo_Common::background_fields(
			$this,
			'addtocart_',
			'Background Color',
			'cartbtn',
			'advanced',
			array(
				'hover'       => 'tabs',
				'description' => esc_html__( 'Add a background fill color or gradient for the add to cart button text', 'dnwooe' ),
				'sub_toggle'  => 'addtocart',
			)
		);
		$viewcart_bg_color  = DNWoo_Common::background_fields(
			$this,
			'viewcart_',
			'Background Color',
			'cartbtn',
			'advanced',
			array(
				'hover'       => 'tabs',
				'description' => esc_html__( 'Add a background fill color or gradient for the add to cart button text', 'dnwooe' ),
				'sub_toggle'  => 'viewcart',
			)
		);

		$wishlist_bg_color = DNWoo_Common::background_fields(
			$this,
			'wishlist_',
			'Background Color',
			'wishlist_settings',
			'advanced',
			array(
				'hover'       => 'tabs',
				'description' => esc_html__( 'Add a background fill color or gradient for the wishlist button text', 'dnwooe' ),
			)
		);

		$compare_bg_color = DNWoo_Common::background_fields(
			$this,
			'compare_',
			'Background Color',
			'compare_settings',
			'advanced',
			array(
				'hover'       => 'tabs',
				'description' => esc_html__( 'Add a background fill color or gradient for the compare button text', 'dnwooe' ),
			)
		);

		$quickview_bg_color = DNWoo_Common::background_fields(
			$this,
			'quickview_',
			'Background Color',
			'quickview_settings',
			'advanced',
			array(
				'hover'       => 'tabs',
				'description' => esc_html__( 'Add a background fill color or gradient for the quickview button text', 'dnwooe' ),
			)
		);

		$quickviewpopupbtn_bg       = DNWoo_Common::background_fields( $this, 'quickviewbtn_', 'Quick View Add to cart btn Background', 'quickviewpopupbox', 'advanced', array_merge( $opt, array( 'sub_toggle' => 'quickviewpopupbox_btn' ) ) );
		$quickviewpopup_view_btn_bg = DNWoo_Common::background_fields( $this, 'quickview_view_btn_', 'View Cart btn Background', 'quickviewpopupbox', 'advanced', array_merge( $opt, array( 'sub_toggle' => 'quickviewpopupbox_btn' ) ) );
		$quickviewpopup_bg          = DNWoo_Common::background_fields( $this, 'quickviewpopupbg_', 'Quick View Pop up Box Background', 'quickbox_popup_box_bg', 'advanced', $opt );
		$quickviewpopuparrow        = DNWoo_Common::background_fields( $this, 'quickviewpopuparrow_', 'Quick View Pop up Box Arrow', 'quickbox_popup_box_arrow', 'advanced', $opt );
		$quickviewpopup_close_btn   = DNWoo_Common::background_fields( $this, 'quickviewpopup_close_btn_', 'Quick Box Popup Close Button', 'quickview_popup_box_close_btn', 'advanced', $opt );
		$sale_bg_color              = DNWoo_Common::background_fields(
			$this,
			'sale_',
			'Background Color',
			'badge',
			'advanced',
			array(
				'hover'       => 'tabs',
				'description' => esc_html__( 'Add a background fill color or gradient for the sale badge text', 'dnwooe' ),
				'sub_toggle'  => 'sale',
			)
		);
		$outofstock_bg_color        = DNWoo_Common::background_fields(
			$this,
			'outofstock_',
			'Background Color',
			'badge',
			'advanced',
			array(
				'hover'       => 'tabs',
				'description' => esc_html__( 'Add a background fill color or gradient for the out of stock badge text', 'dnwooe' ),
				'sub_toggle'  => 'outofstock',
			)
		);
		$featured_bg_color          = DNWoo_Common::background_fields(
			$this,
			'featured_',
			'Background Color',
			'badge',
			'advanced',
			array(
				'hover'       => 'tabs',
				'description' => esc_html__( 'Add a background fill color or gradient for the featured badge text', 'dnwooe' ),
				'sub_toggle'  => 'featured',
			)
		);
		$filter_all_clear_bg_color          = DNWoo_Common::background_fields(
			$this,
			'filter_all_clear_',
			'Background Color',
			'filter_text',
			'advanced',
			array(
				'hover'       => 'tabs',
				'description' => esc_html__( 'Add a background fill color or gradient for the filter all clear text', 'dnwooe' ),
				'sub_toggle'  => 'filter_by_all_clear_text',
			)
		);

		return array_merge(
			$fields,
			$show_hide,
			$isotope_fields,
			$margin_padding,
			$content_bg_color,
			$category_bg_color,
			$category_item_bg_color,
			$category_item_active_bg_color,
			$addtocart_bg_color,
			$viewcart_bg_color,
			$sale_bg_color,
			$featured_bg_color,
			$outofstock_bg_color,
			$wishlist_bg_color,
			$compare_bg_color,
			$quickview_bg_color,
			$quickviewpopupbtn_bg,
			$quickviewpopup_view_btn_bg,
			$quickviewpopup_bg,
			$quickviewpopuparrow,
			$quickviewpopup_close_btn,
			$filter_rating,
			$rating,
			$pagination_filter,
			$filter_all_clear_bg_color
		);
	}

	public function get_filter_html( $filter_module_count ) {
		// filter start
		$show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', 'menu_order' ) );
		$catalog_orderby_options = apply_filters(
			'woocommerce_catalog_orderby',
			array(
				'menu_order' => __( 'Default sorting', 'dnwooe' ),
				'popularity' => __( 'Sort by popularity', 'dnwooe' ),
				'rating'     => __( 'Sort by average rating', 'dnwooe' ),
				'date'       => __( 'Sort by latest', 'dnwooe' ),
				'price'      => __( 'Sort by price: low to high', 'dnwooe' ),
				'price-desc' => __( 'Sort by price: high to low', 'dnwooe' ),
			)
		);

		$default_orderby = wc_get_loop_prop( 'is_search' ) ? 'relevance' : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', '' ) );
        // phpcs:disable WordPress.Security.NonceVerification.Recommended
		$orderby = isset( $_GET[ 'orderby' . $filter_module_count ] ) ? wc_clean( wp_unslash( sanitize_text_field( $_GET[ 'orderby' . $filter_module_count ] ) ) ) : $default_orderby;
        // phpcs:enable WordPress.Security.NonceVerification.Recommended

		if ( wc_get_loop_prop( 'is_search' ) ) {
			$catalog_orderby_options = array_merge( array( 'relevance' => __( 'Relevance', 'dnwooe' ) ), $catalog_orderby_options );

			unset( $catalog_orderby_options['menu_order'] );
		}

		if ( ! $show_default_orderby ) {
			unset( $catalog_orderby_options['menu_order'] );
		}

		if ( ! wc_review_ratings_enabled() ) {
			unset( $catalog_orderby_options['rating'] );
		}

		if ( ! array_key_exists( $orderby, $catalog_orderby_options ) ) {
			$orderby = current( array_keys( $catalog_orderby_options ) );
		}
		// return $orderby;
		$filter = '';
		ob_start();
		?>
		<form class="woocommerce-ordering" method="get">
			<select name="orderby<?php echo esc_attr($filter_module_count); ?>" class="dnwoo-orderby" aria-label="<?php esc_attr_e( 'Shop order', 'woocommerce' ); ?>">
				<?php foreach ( $catalog_orderby_options as $id => $name ) : ?>
					<option value="<?php echo esc_attr( $id ); ?>" <?php selected( $orderby, $id ); ?>><?php echo esc_html( $name ); ?></option>
				<?php endforeach; ?>
			</select>
			<input type="hidden" name="paged" value="1" />
			<?php wc_query_string_form_fields( null, array( 'orderby', 'submit', 'paged', 'product-page' ) ); ?>
		</form>
		<?php
		$filter .= ob_get_contents();
		ob_end_clean();

		return $filter;
	}

	public function render( $attrs, $content, $render_slug ) {
		if ( ! class_exists( 'WooCommerce' ) ) {
			DNWoo_Common::show_wc_missing_alert();
			return;
		}

		$this->callingScriptAndStyles();
		$data_factory   = new DataFactory();
		$filter_options = new FilterOptions();
		extract( $data_factory->get_settings_data( $this->props ) ); // phpcs:ignore
		$filter_menu_classlist = DNWoo_Common::get_alignment( 'show_filter_menu', $this, 'dnwoo' );
		$search                = isset( $_GET['s'] ) && ! empty( wp_verify_nonce( sanitize_text_field( $_GET['s'] ), 'dnwoo_filter_masonry' ) ) ? wp_verify_nonce( sanitize_text_field( $_GET['s'] ), 'dnwoo_filter_masonry' ) : '';
		$filter_module_count   = $this->dnwoo_filter_masonry_count++;
		$meta_key              = ( ! empty( $_GET[ 'orderby' . $filter_module_count ] ) ) ? sanitize_text_field( $_GET[ 'orderby' . $filter_module_count ] ) : '';
		$pagination_alignment = DNWoo_Common::get_alignment("pagination_alignment", $this, "dnwoo");

		if ( 'price' == $meta_key ) {
			$orderby  = 'meta_value_num';
			$meta_key = '_price';
			$order    = 'ASC';
		} elseif ( 'price-desc' == $meta_key ) {
			$orderby  = 'meta_value_num';
			$meta_key = '_price';
			$order    = 'DESC';
		} elseif ( 'date' == $meta_key ) {
			$orderby = 'date';
			$order   = 'DESC';
		} elseif ( 'rating' == $meta_key ) {
			$orderby  = array(
				'meta_value_num' => 'DESC',
				'ID'             => 'ASC',
			);
			$meta_key = '_wc_average_rating';
		} elseif ( 'popularity' == $meta_key ) {
			$orderby = 'total_sales';
			$order   = 'DESC';
		}

		$settings = array(
			'products_number'    => $products_number,
			'order'              => $order,
			'orderby'            => $orderby,
            'meta_key'           => $meta_key, // phpcs:ignore
			'type'               => $type,
			'offset'             => $offset,
			'include_categories' => $include_categories,
			'hide_out_of_stock'  => $hide_out_of_stock,
			'thumbnail_size'     => $thumbnail_size,
			'request_from'       => 'filter-product',
            'meta_query'         => [], // phpcs:ignore
            'tax_query'          => [], // phpcs:ignore
		);

		if ( 'product_category' === $type ) {
			$settings = $this->filter_products_query( $settings );
			add_action( 'pre_get_posts', array( $this, 'apply_woo_widget_filters' ), 10 );
		}

		if ( 'product_category' === $type ) {
			remove_action( 'pre_get_posts', array( $this, 'apply_woo_widget_filters' ), 10 );
			remove_filter( 'woocommerce_shortcode_products_query', array( $this, 'filter_products_query' ) );
		}

		$product_details 		= dnwoo_query_products( $settings );
		$order_class            = $this->get_module_order_class( $render_slug );
		$products = isset( $product_details['products'] ) ? $product_details['products'] : array();
		$show_reset = !empty($this->props['show_reset']) ? $this->props['show_reset'] : 'off';
		$single_products        = '';
		$category_html          = $filter_options->category_filter( 
		array( 'category_style' => $this->props['category_style'] ,
		'order_class' 			=> $order_class,
		'single' 				=> $this->props['single_category'],
		'order' 				=> $order,
		'orderby' 				=> $orderby,
		'include_categories' 	=> $include_categories,
		'show_sub_categories'	=> $show_sub_categories ,
		'show_reset'			=> $show_reset ,
		'reset_text'			=> $this->props['dnwoo_reset_text'] ,
		'dnwoo_category_all_text' => $this->props['dnwoo_category_all_text'] ,
		'show_all_text_field' 	=> $this->props['show_all_text_field'],
		'show_filter_menu' 		=> $this->props['show_filter_menu'],
		'dnwoo_category_title' 	=> $this->props['dnwoo_category_title'],
		) );
		

		$review_html            = $filter_options->review_filter( $show_reset , $show_rating_filter, $this->props['dnwoo_reset_text'], $this->props['dnwoo_filter_rating_text'] );
		$demo_image             = 'data:image/png;base64,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';
		$dataIcon               = '<span class="icon_cart icon_cart_btn et_pb_icon" data-icon=""></span>';
		$chooseSelectOptionIcon = '<span class="icon_menu icon_menu_btn et_pb_icon" data-icon="a"></span>';
		$addtocartIcon          = 'data-icon=""';
		$select_option_text     = isset( $this->props['dnwoo_select_options_text'] ) ? esc_html__( $this->props['dnwoo_select_options_text'], 'dnwooe' ) : esc_html__( 'Select Options', 'dnwooe' );

		if ( count( $products ) > 0 ) {
			foreach ( $products as $key => $value ) {

				$new_cat_arr = array();

				if ( isset( $value->striped_category ) && is_array( $value->striped_category ) && count( $value->striped_category ) > 0 ) {
					$new_cat_arr[] = $value->striped_category[0];
					// $new_cat_arr variable should not be here. Need to modified(nazmul - 2024-01-08)
				}

				foreach ( $new_cat_arr as $ckey => $cvalue ) {

					$image = sprintf( '<img src="%1$s" alt="Woo Product" />', $value->thumbnail ? $value->thumbnail : $demo_image );

					$product_variant_icon = $this->_add_to_cart( $value->ID, $value->get_type, $value->permalink, $show_add_to_cart, $dnwoo_show_add_to_cart_text, $select_option_text, $chooseSelectOptionIcon, $dataIcon );

					$wishlist_button = 'on' === $show_wishlist_button ? $this->_add_to_wishlist_icon( $value, $wishlist_text ) : '';

					$compare_button = 'on' === $show_compare_button ? $this->_product_compare_icon( $value->ID, $compare_text ) : '';

					$quickview_icon = 'on' === $show_quickview_button ? sprintf(
						'<a href="#" class="dnwoo_product_filter_quick_button dnwoo-quick-btn dnwoo-quickview icon_quickview" data-icon="" data-quickid="%1$s" data-orderclass="%2$s">&nbsp;%3$s</a>',
						$value->ID,
						$order_class,
						$quickview_text
					) : '';

					$sale_text = '' !== $dnwoo_badge_sale ? sprintf( '<div class="dnwoo_product_filter_onsale">%1$s</div>', esc_html( $dnwoo_badge_sale ) ) : '<div class="dnwoo_product_filter_onsale">' . apply_filters( 'dnwoo_sale_filter', __( 'Sale', 'dnwooe' ) ) . '</div>';

					$percentage_text = '' !== $dnwoo_badge_percentage ? esc_html( $dnwoo_badge_percentage ) : '';
					$percentage      = '' !== $value->percentage ? sprintf( '<div class="dnwoo_product_filter_onsale percent">%1$s %2$s</div>', esc_html( $value->percentage ), $percentage_text ) : '';

					$on_sale_badge      = ( 'percentage' == $show_badge && $value->is_on_sale ) ? $percentage : ( ( 'sale' == $show_badge && $value->is_on_sale ) ? $sale_text : '' );
					$out_of_stock_badge = 'outofstock' == $value->stock_status && 'off' == $hide_out_of_stock ? sprintf( '<div class="dnwoo_product_filter_stockout">%1$s</div>', esc_html( $dnwoo_badge_outofstock ) ) : '';
					$featured_badge     = $value->is_featured && 'outofstock' != $value->stock_status && 'on' == $show_featured_product ? sprintf( '<div class="dnwoo_product_filter_featured">%1$s</div>', esc_html( $dnwoo_badge_featured ) ) : '';

					$price_html      = 'on' == $show_price_text ? sprintf( '<div class="dnwoo_product_filter_price_wrapper"><div class="dnwoo_product_filter_price">%1$s</div></div>', $value->get_price_html ) : '';
					$product_ratting = ( isset( $show_rating ) && 0 < $value->get_rating_count && 'on' === $show_rating ? '<div class="dnwoo_product_ratting"><div class="star-rating"><span style="width:0%">' . esc_html__( 'Rated', 'dnwooe' ) . ' <strong class="rating">' . esc_html__( '0', 'dnwooe' ) . '</strong> ' . esc_html__( 'out of 5', 'dnwooe' ) . '</span>' . $value->product_rating . '</div></div>' : '' );
					$value_slug      = implode( ' ', $value->striped_category );
					$get_type        = ! empty( $value->get_type ) ? $value->get_type : '';
					$permalink       = ! empty( $value->permalink ) ? $value->permalink : '#';
					$post_title      = ! empty( $value->post_title ) ? $value->post_title : '';

					$single_products .= sprintf(
						'<div class="dnwoo_product_filter_item product_type_%12$s woocommerce %5$s">
                                    <div class="dnwoo_product_filter_item_child">
                                        <a href="%9$s" class="image_link">
                                            %1$s
                                            %2$s
                                            %3$s
                                            %10$s
                                        </a>
                                        <div class="dnwoo_product_filter_badge_btn">
                                            %4$s
                                            %13$s
                                            %14$s
                                            %15$s
                                        </div>
                                    </div>
                                    <div class="dnwoo_product_filter_bottom_content">
                                        <a href="%9$s"><%11$s class="dnwoo_product_filter_title">%6$s</%11$s></a>
                                            %7$s
                                            %8$s
                                    </div>
                                </div>',
						$image,
						$on_sale_badge,
						$out_of_stock_badge,
						'on' === $show_add_to_cart ? $product_variant_icon : '',
						urldecode( $value_slug ), // 5
						$post_title,
						$price_html,
						$product_ratting,
						$permalink, // 9
						$featured_badge,
						$tag,
						$get_type,
						$wishlist_button,
						$compare_button,
						$quickview_icon
					);
				}
			}
		}
		

		$category_filter = 'on' == $this->props['show_product_filter'] ? sprintf(
			'%1$s
            %2$s ',
			$category_html,
			'on' == $this->props['show_default_sorting'] ? $this->get_filter_html( $filter_module_count ) : ''
		) : '';

		$this->apply_spacing_css( $render_slug );
		$this->apply_css( $render_slug );
		$this->apply_background_css( $render_slug );
		$templates  = new Templates();
		$pagination = $templates->pagination(
			array(
				'pages'    => $product_details['pages'],
				'offset'   => 1,
				'alingment_class' => $pagination_alignment,
				'template' => $show_pagination,
				)
			);

		$attributes = $this->process_content($content);
		$all_clear_text =	$this->props['dnwoo_reset_all_clear_text'];
		$all_clear_html = ( $show_all_clear == 'on' && $show_filter_menu !== 'default' ) ? sprintf('<div class="clear_all_filter_wrapper"><div class="all_clear">%1$s</div> </div>',$all_clear_text)  : '';
		
		return sprintf(
			'
			<div class="dnwoo_product_filter_container %3$s">
				<div class="dnwoo_Pro_filter_menu_left_sidebar_wrapper">	
					%6$s
					%2$s
					%4$s
					%7$s
				</div>
				<div class="dnwoo_product_section">
					<div class="dnwoo_product_filter_wrap" 
						data-show_sub_categories=' . esc_html( $show_sub_categories ) . '
						data-show_filter_menu=' . esc_html( $show_filter_menu ) . '
						data-order_class=' . esc_html( $order_class ) . '
						data-show_pagination=' . esc_html( $show_pagination ) . '
						data-loadmore_text="' . esc_html( $loadmore_text ) . '"
						data-pagination_alignment=' . esc_html( $pagination_alignment ) . '
						data-products_number=' . esc_html( $products_number ) . '
						data-dnwoo_badge_percentage=' . esc_html( $dnwoo_badge_percentage ) . '
						data-show_badge=' . esc_html( $show_badge ) . '
						data-hide_out_of_stock=' . esc_html( $hide_out_of_stock ) . '
						data-show_add_to_cart=' . esc_html( $show_add_to_cart ) . '
						data-dnwoo_show_add_to_cart_text="' . esc_html( $dnwoo_show_add_to_cart_text ) . '"
						data-select_option_text="' . esc_html( $select_option_text ) . '"
						data-show_featured_product="' . esc_html( $show_featured_product ) . '"
						data-dnwoo_badge_featured=' . esc_html( $dnwoo_badge_featured ) . '
						data-tag=' . esc_html( $tag ) . '
						data-show_wishlist_button=' . esc_html( $show_wishlist_button ) . '
						data-wishlist_text="' . esc_html( $wishlist_text ) . '"
						data-show_compare_button=' . esc_html( $show_compare_button ) . '
						data-compare_text="' . esc_html( $compare_text ) . '"
						data-show_quickview_button=' . esc_html( $show_quickview_button ) . '
						data-quickview_text="' . esc_html( $quickview_text ) . '"
						data-dnwoo_badge_outofstock="' . esc_html( $dnwoo_badge_outofstock ) . '"
						data-dnwoo_badge_sale="' . $dnwoo_badge_sale . '"
					>
						<div class="grid-sizer"></div><div class="gutter-sizer"></div>
						%1$s
					</div>
					<div class="dnwoo_pages_wrapper">%5$s</div>
				</div>
            </div>',
			$single_products,
			$category_filter,
			$filter_menu_classlist,
			'default' !== $this->props['show_filter_menu'] ? "<div class='rating-wrapper'>". $review_html.'</div>' :'',
			$pagination,
			$all_clear_html,
			$attributes // 7
		);
	}

	public function apply_spacing_css( $render_slug ) {
		/**
		 * Custom Padding Margin Output
		 */
		$customMarginPadding = array(
			// No need to add "_margin" or "_padding" in the key
			'dnwoo_filter_masonry_content_wrapper' => array(
				'selector' => '%%order_class%% .dnwoo_product_filter_bottom_content',
				'type'     => array( 'margin', 'padding' ),
			),
			'dnwoo_filter_masonry_product_name'    => array(
				'selector' => '%%order_class%% .dnwoo_product_filter_title',
				'type'     => array( 'margin', 'padding' ),
			),
			'dnwoo_filter_masonry_product_rating'  => array(
				'selector' => '%%order_class%% .dnwoo_product_filter_item .dnwoo_product_ratting>.star-rating',
				'type'     => 'margin',
			),
			'dnwoo_filter_masonry_product_price'   => array(
				'selector' => '%%order_class%% .dnwoo_product_filter_item .dnwoo_product_filter_price',
				'type'     => array( 'margin', 'padding' ),
			),
			'dnwoo_filter_masonry_addtocart'       => array(
				'selector' => '%%order_class%% .dnwoo_product_filter_item .add_to_cart_button',
				'type'     => array( 'margin', 'padding' ),
			),
			'dnwoo_filter_masonry_viewcart'        => array(
				'selector' => '%%order_class%% .dnwoo_product_filter_item .added_to_cart',
				'type'     => array( 'margin', 'padding' ),
			),
			'wishlist'                             => array(
				'selector' => '%%order_class%% .dnwoo_product_filter_item .yith-wcwl-add-button',
				'type'     => 'margin',
			),
			'compare'                              => array(
				'selector' => '%%order_class%% .dnwoo_product_filter_item .compare-button',
				'type'     => 'margin',
			),
			'quickview'                            => array(
				'selector' => '%%order_class%% .dnwoo_product_filter_item .dnwoo-quickview',
				'type'     => array( 'margin', 'padding' ),
			),
			'dnwoo_filter_masonry_filter_wrapper'  => array(
				'selector' => '%%order_class%% .dnwoo_product_filter_menu',
				'type'     => array( 'margin', 'padding' ),
			),
			'dnwoo_filter_masonry_filter_item'     => array(
				'selector' => '%%order_class%% .dnwoo_product_filter_menu li',
				'type'     => 'margin',
			),
		);

		$different_type_spacing = array(
			'compare'  => array(
				'selector' => '%%order_class%% .dnwoo_product_filter_item .dnwoo-product-compare-btn',
				'type'     => 'padding',
			),
			'wishlist' => array(
				'selector' => '%%order_class%% .dnwoo_product_filter_item .yith-wcwl-add-button .dnwoo-filter-wishlist-btn',
				'type'     => 'padding',
			),
		);
		$different_type_top_spacing = '';
		if('default' === $this->props['show_filter_menu']){
            $different_type_top_spacing = array(
                'dnwoo_filter_masonry_filter_item'     => array(
                    'selector' => '%%order_class%% .dnwoo_product_filter_menu li',
                    'type'     => 'padding',
                ),
            );
        };

		$different_type_right_left_spacing = '';
		if('default' !== $this->props['show_filter_menu']){
            $different_type_right_left_spacing = array(
                'dnwoo_filter_masonry_filter_item_left_right'     => array(
                    'selector' => '%%order_class%% .dnwoo_product_filter_menu li',
                    'type'     => 'padding',
                ),
            );
        };

		DNWoo_Common::apply_spacing( $different_type_top_spacing, $render_slug, $this->props );
		DNWoo_Common::apply_spacing( $different_type_right_left_spacing, $render_slug, $this->props );
		DNWoo_Common::apply_spacing( $customMarginPadding, $render_slug, $this->props );
		DNWoo_Common::apply_spacing( $different_type_spacing, $render_slug, $this->props );
	}

	public function apply_css( $render_slug ) {
		$css_settings = array(
			// Option slug should be the key
			'dnwoo_gutter'                 => array(
				'css'      => 'margin-bottom: %1$spx !important;',
				'selector' => array(
					'desktop' => '%%order_class%% .dnwoo_product_filter_item',
				),
			),
			'dnwoo_gutter'                 => array(
				'css'      => 'width: %1$spx ;',
				'selector' => array(
					'desktop' => '%%order_class%% .gutter-sizer',
				),
			),
			'filter_active_color'          => array(
				'css'      => 'color: %1$s !important;accent-color: %1$s !important' ,
				'selector' => array(
					'desktop' => '%%order_class%% .dnwoo_product_filter_menu li.active label, %%order_class%% .dnwoo_product_filter_menu li input[type=checkbox]',
				),
			),
			'filter_item_separator_color'  => array(
				'css'      => 'color: %1$s !important',
				'selector' => array(
					'desktop' => '%%order_class%% .dnwoo_product_filter_menu li:before',
				),
			),
			'dnwoo_filter_width'           => array(
				// 'css'      => 'width: %1$s !important',
				'css'      => 'width: %1$s',
				'selector' => array(
					'desktop' => '%%order_class%% .dnwoo_show_filter_menu_default .dnwoo_Pro_filter_menu_left_sidebar_wrapper, %%order_class%% .dnwoo_show_filter_menu_left_sidebar .dnwoo_Pro_filter_menu_left_sidebar_wrapper, %%order_class%% .dnwoo_show_filter_menu_right_sidebar .dnwoo_Pro_filter_menu_left_sidebar_wrapper',
				),
			),
			'rating_alignment'             => array(
				'css'      => 'justify-content: %1$s !important;',
				'selector' => array(
					'desktop' => '%%order_class%% .woocommerce.dnwoo_product_filter_item .dnwoo_product_ratting',
				),
			),

			'rating_active_color'          => array(
				'css'      => 'color: %1$s !important;',
				'selector' => array(
					'desktop' => '%%order_class%% .dnwoo_product_filter_item .dnwoo_product_ratting span:before',
				),
			),
			'rating_inactive_color'        => array(
				'css'      => 'color: %1$s !important;',
				'selector' => array(
					'desktop' => '%%order_class%% .woocommerce.dnwoo_product_filter_item .star-rating:before',
				),
			),
			'filter_rating_active_color'   => array(
				'css'      => 'fill: %1$s !important;',
				'selector' => array(
					'desktop' => '%%order_class%% .dnwoo_Pro_filter_menu_left_sidebar_wrapper .rating_block .rating',
				),
			),
			'filter_rating_inactive_color' => array(
				'css'      => 'fill: %1$s !important;',
				'selector' => array(
					'desktop' => '%%order_class%% .dnwoo_Pro_filter_menu_left_sidebar_wrapper .rating_block .rating_light',
				),
			),
			'pagination_bg_color'          => array(
				'css'      => 'background: %1$s !important;',
				'selector' => array(
					'desktop' => '%%order_class%% .dnwoo_pages_wrapper ul li',
				),
			),
			'pagination_active_bg_color'          => array(
				'css'      => 'background: %1$s !important;',
				'selector' => array(
					'desktop' => '%%order_class%% .dnwoo_pages_wrapper ul li.active',
				),
			),
			'pagination_number_active_color'          => array(
				'css'      => 'color: %1$s !important;',
				'selector' => array(
					'desktop' => '%%order_class%% .dnwoo_pages_wrapper ul li.active',
				),
			)
		);

		foreach ( $css_settings as $key => $value ) {
			DNWoo_Common::set_css( $key, $value['css'], $value['selector'], $render_slug, $this );
		}

		// Image filter css
		DNWoo_Common::set_image_filter( 'masonry_image', $this, $render_slug );

		$dnwoo_columns                   = $this->props['dnwoo_columns'];
		$dnwoo_columns_responsive_active = isset( $this->props['dnwoo_columns_last_edited'] ) && et_pb_get_responsive_status( $this->props['dnwoo_columns_last_edited'] );
		$dnwoo_columns_tablet            = $dnwoo_columns_responsive_active && $this->props['dnwoo_columns_tablet'] ? $this->props['dnwoo_columns_tablet'] : $dnwoo_columns;
		$dnwoo_columns_phone             = $dnwoo_columns_responsive_active && $this->props['dnwoo_columns_phone'] ? $this->props['dnwoo_columns_phone'] : $dnwoo_columns_tablet;

		$dnwoo_gutter                   = $this->props['dnwoo_gutter'];
		$dnwoo_gutter_responsive_active = isset( $this->props['dnwoo_gutter_last_edited'] ) && et_pb_get_responsive_status( $this->props['dnwoo_gutter_last_edited'] );
		$dnwoo_gutter_tablet            = $dnwoo_gutter_responsive_active && isset( $this->props['dnwoo_gutter_tablet'] ) ? $this->props['dnwoo_gutter_tablet'] : $dnwoo_gutter;
		$dnwoo_gutter_phone             = $dnwoo_gutter_responsive_active && isset( $this->props['dnwoo_gutter_phone'] ) ? $this->props['dnwoo_gutter_phone'] : $dnwoo_gutter_tablet;

		// Width of grid items
		if ( '' !== $dnwoo_columns || '' !== $dnwoo_gutter ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .grid-sizer, %%order_class%% .dnwoo_product_filter_item',
					'declaration' => "width: calc((100% - ({$dnwoo_columns} - 1) * {$dnwoo_gutter}px) / {$dnwoo_columns});",
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .grid-item',
					'declaration' => "margin-bottom: {$dnwoo_gutter}px;",
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .grid-sizer, %%order_class%% .dnwoo_product_filter_item',
					'declaration' => "width: calc((100% - ({$dnwoo_columns_tablet} - 1) * {$dnwoo_gutter_tablet}px) / {$dnwoo_columns_tablet});",
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .grid-sizer, %%order_class%% .dnwoo_product_filter_item',
					'declaration' => "width: calc((100% - ({$dnwoo_columns_phone} - 1) * {$dnwoo_gutter_phone}px) / {$dnwoo_columns_phone});",
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}

		// Quick View Pop up Arrow Color
		$this->generate_styles(
			array(
				'base_attr_name' => 'quickviewpopupbox_arrow_color',
				'selector'       => '%%order_class%% .product-images .swiper-button-next, %%order_class%% .product-images .swiper-button-prev',
				'hover_selector' => '%%order_class%% .product-images .swiper-button-next:hover, %%order_class%% .product-images .swiper-button-prev:hover',
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'important'      => true,
				'type'           => 'color',
			)
		);
		// Quick View Pop up Close Button
		$this->generate_styles(
			array(
				'base_attr_name' => 'quickviewpopupbox_closebtn_color',
				'selector'       => '.dnwoo-quick-view-modal.dnwooquickview-open%%order_class%% .dnwoo-modal-dialog .dnwoo-modal-content .dnwoo-modal-close',
				'hover_selector' => '.dnwoo-quick-view-modal.dnwooquickview-open%%order_class%%  .dnwoo-modal-dialog .dnwoo-modal-content .dnwoo-modal-close:hover',
				'css_property'   => 'color',
				'render_slug'    => $render_slug,
				'important'      => true,
				'type'           => 'color',
			)
		);

		// Gutter of grid items
		if ( '' !== $dnwoo_gutter ) {
			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dnwoo_product_filter_item',
					'declaration' => "margin-bottom: {$dnwoo_gutter}px;",
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dnwoo_product_filter_item',
					'declaration' => "margin-bottom: {$dnwoo_gutter_tablet}px;",
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .dnwoo_product_filter_item',
					'declaration' => "margin-bottom: {$dnwoo_gutter_phone}px;",
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .gutter-sizer',
					'declaration' => "width: {$dnwoo_gutter}px;",
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .gutter-sizer',
					'declaration' => "width: {$dnwoo_gutter_tablet}px;",
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_980' ),
				)
			);

			ET_Builder_Element::set_style(
				$render_slug,
				array(
					'selector'    => '%%order_class%% .gutter-sizer',
					'declaration' => "width: {$dnwoo_gutter_phone}px;",
					'media_query' => ET_Builder_Element::get_media_query( 'max_width_767' ),
				)
			);
		}

		// product regular price
		$regular_price_order_class        = '%%order_class%% .dnwoo_product_filter_price > span:last-child,%%order_class%% .dnwoo_product_filter_price > span:last-child span,%%order_class%% .dnwoo_product_filter_price ins span.woocommerce-Price-amount.amount,%%order_class%% .dnwoo_product_filter_price ins span bdi > span.woocommerce-Price-currencySymbol,
        %%order_class%% .woocommerce.product_type_variable .dnwoo_product_filter_price span';
		$dnwoo_regular_price_color_values = et_pb_responsive_options()->get_property_values( $this->props, 'dnwoo_woocarousel_regular_price' );
		et_pb_responsive_options()->generate_responsive_css( $dnwoo_regular_price_color_values, $regular_price_order_class, 'color', $render_slug, '!important', 'color' );
	}

	public function apply_background_css( $render_slug ) {

		$gradient_opt = array(
			// total slug example = content_bg_color
			'content_'                  => array(
				'desktop' => '%%order_class%% .dnwoo_product_filter_item',
				'hover'   => '%%order_class%% .dnwoo_product_filter_item:hover',
			),
			'category_'                 => array(
				'desktop' => '%%order_class%% .dnwoo_product_filter_menu',
				'hover'   => '%%order_class%% .dnwoo_product_filter_menu:hover',
			),
			'category_item_'            => array(
				'desktop' => '%%order_class%% .dnwoo_product_filter_menu li',
				'hover'   => '%%order_class%% .dnwoo_product_filter_menu li:hover',
			),
			'category_item_active_'     => array(
				'desktop' => '%%order_class%% .dnwoo_product_filter_menu li.active',
				'hover'   => '%%order_class%% .dnwoo_product_filter_menu li.active:hover',
			),
			'addtocart_'                => array(
				'desktop' => '%%order_class%% .add_to_cart_button, %%order_class%% .dnwoo_choose_variable_option',
				'hover'   => '%%order_class%% .add_to_cart_button:hover,%%order_class%% .dnwoo_choose_variable_option:hover',
			),
			'viewcart_'                 => array(
				'desktop' => '%%order_class%% .added_to_cart',
				'hover'   => '%%order_class%% .added_to_cart:hover',
			),
			'wishlist_'                 => array(
				'desktop' => '%%order_class%% .dnwoo_product_filter_badge_btn a.dnwoo-filter-wishlist-btn',
				'hover'   => '%%order_class%% .dnwoo_product_filter_badge_btn a.dnwoo-filter-wishlist-btn:hover',
			),
			'compare_'                  => array(
				'desktop' => '%%order_class%% .dnwoo_product_filter_badge_btn .dnwoo-product-compare-btn',
				'hover'   => '%%order_class%% .dnwoo_product_filter_badge_btn .dnwoo-product-compare-btn:hover',
			),
			'quickview_'                => array(
				'desktop' => '%%order_class%% .dnwoo_product_filter_badge_btn .dnwoo-quickview',
				'hover'   => '%%order_class%% .dnwoo_product_filter_badge_btn .dnwoo-quickview:hover',
			),
			'quickviewbtn_'             => array(
				'desktop' => '%%order_class%% .dnwoo-product-summery .product-buttons .single_add_to_cart_button',
				'hover'   => '%%order_class%% .dnwoo-product-summery .product-buttons .single_add_to_cart_button:hover',
			),
			'quickview_view_btn_'       => array(
				'desktop' => '%%order_class%% .dnwoo-product-summery .single_variation_wrap .added_to_cart.wc-forward',
				'hover'   => '%%order_class%% .dnwoo-product-summery .single_variation_wrap .added_to_cart.wc-forward:hover',
			),
			'quickviewpopupbg_'         => array(
				'desktop' => '.dnwoo-quick-view-modal .dnwoo-modal-content %%order_class%%',
				'hover'   => '.dnwoo-quick-view-modal .dnwoo-modal-content %%order_class%%:hover',
			),
			'quickviewpopuparrow_'      => array(
				'desktop' => '%%order_class%% .product-images .swiper-button-next, %%order_class%% .product-images .swiper-button-prev',
				'hover'   => '%%order_class%% .product-images .swiper-button-next:hover, %%order_class%% .product-images .swiper-button-prev:hover',
			),
			'sale_'                     => array(
				'desktop' => '%%order_class%% .dnwoo_product_filter_onsale',
				'hover'   => '%%order_class%% .dnwoo_product_filter_onsale:hover',
			),
			'outofstock_'               => array(
				'desktop' => '%%order_class%% .dnwoo_product_filter_stockout',
				'hover'   => '%%order_class%% .dnwoo_product_filter_stockout:hover',
			),
			'featured_'                 => array(
				'desktop' => '%%order_class%% .dnwoo_product_filter_featured',
				'hover'   => '%%order_class%% .dnwoo_product_filter_featured:hover',
			),
			'quickviewpopup_close_btn_' => array(
				'desktop' => '.dnwoo-quick-view-modal.dnwooquickview-open%%order_class%%  .dnwoo-modal-dialog .dnwoo-modal-content .dnwoo-modal-close',
				'hover'   => '.dnwoo-quick-view-modal.dnwooquickview-open%%order_class%%  .dnwoo-modal-dialog .dnwoo-modal-content .dnwoo-modal-close:hover',
			),
			'filter_all_clear_' => array(
				'desktop' => '%%order_class%% .dnwoo_Pro_filter_menu_left_sidebar_wrapper .all_clear',
				'hover'   => '%%order_class%% .dnwoo_Pro_filter_menu_left_sidebar_wrapper .all_clear:hover',
			),
		);
		DNWoo_Common::apply_all_bg_css( $gradient_opt, $render_slug, $this );
	}

	public function callingScriptAndStyles() {
		wp_enqueue_style( 'dnwoo_magnific-popup' );
		wp_enqueue_style( 'dnwoo_product_masonry' );
		wp_enqueue_style( 'dnwoo_quickview_modal' );
		wp_script_is( 'dnext_isotope', 'enqueued' ) ? wp_enqueue_script( 'dnext_isotope' ) : wp_enqueue_script( 'dnwoo_isotope_frontend' );
		wp_script_is( 'dnext_imagesloaded', 'enqueued' ) ? wp_enqueue_script( 'dnext_imagesloaded' ) : wp_enqueue_script( 'dnwoo_imagesloaded' );
		wp_enqueue_script( 'dnwoo_swiper_frontend' );
		wp_style_is( 'dnext_swiper-min', 'enqueued' ) ? wp_enqueue_style( 'dnext_swiper-min' ) : wp_enqueue_style( 'dnwoo_swiper-min' );
		wp_script_is( 'magnific-popup', 'enqueued' ) ? wp_enqueue_script( 'magnific-popup' ) : wp_enqueue_script( 'dnwoo-magnific-popup' );
		wp_enqueue_script( 'dnwoo_scripts-public' );
		wp_enqueue_script( 'dnwoo-isotope-activation' );

		$form_data             = array();
		$form_data['ajax_url'] = admin_url( 'admin-ajax.php' );
		wp_localize_script( 'dnwoo-isotope-activation', 'filter', $form_data );
	}
	public static function get_products() {
		return '';
	}
	/*
	* _product_btn function
	*
	*   @param int $product_id ex: 5
	*   @param string $product_type ex: 'variable'
	*   @param string $permalink ex: 'https://www.sitename.com/products/hoodies
	*   @param string $show_add_to_cart
	*   @param string $add_to_cart_text
	*   @param string $select_option_text
	*   @param string $chooseOptionIcon
	*   @param string $cartIcon
	*/

	public function _add_to_cart( $product_id, $product_type, $permalink, $show_add_to_cart, $add_to_cart_text, $select_option_text, $chooseOptionIcon, $cartIcon ) {

		if ( 'variable' === $product_type ) {
			return sprintf(
				'<a href="%1$s" class="dnwoo_product_filter_btn product_type_variable dnwoo_choose_variable_option">%3$s %2$s</a>',
				$permalink,
				$select_option_text,
				$chooseOptionIcon
			);
		}
		return sprintf(
			'<a href="%1$s" data-quantity="1" class="dnwoo_product_filter_btn product_type_%3$s dnwoo_product_addtocart add_to_cart_button ajax_add_to_cart dnwoo_cart_text_button" data-product_id="%2$s">%5$s %4$s</a>',
			sprintf( '?add-to-cart=%1$s', $product_id ),
			$product_id,
			$product_type,
			'on' === $show_add_to_cart ? $add_to_cart_text : '',
			$cartIcon
		);
	}
	public function _add_to_wishlist_icon( $product, $wishlist_text, $normalicon = '<span data-icon="" class="icon_heart"></span>', $addedicon = '<span data-icon="" class="icon_heart_alt"></span>' ) {
		global $yith_wcwl;

		if ( ! class_exists( 'YITH_WCWL' ) || empty( get_option( 'yith_wcwl_wishlist_page_id' ) ) ) {
			return '';
		}

		$url          = YITH_WCWL()->get_wishlist_url();
		$product_type = $product->get_type;
		$exists       = $yith_wcwl->is_product_in_wishlist( $product->ID );
		$classes      = 'class="add_to_wishlist dnwoo-filter-wishlist-btn"';
		$add          = get_option( 'yith_wcwl_add_to_wishlist_text' );
		$browse       = get_option( 'yith_wcwl_browse_wishlist_text' );
		$added        = get_option( 'yith_wcwl_product_added_text' );

		$wishlist_text = isset( $wishlist_text ) ? '&nbsp;' . $wishlist_text : '';

		$output = '';

		$output .= '<div class="wishlist button-default yith-wcwl-add-to-wishlist add-to-wishlist-' . esc_attr( $product->ID ) . '">';
		$output .= '<div class="yith-wcwl-add-button';
		$output .= $exists ? ' hide" style="display:none;"' : ' show"';
		$output .= '><a href="' . esc_url( htmlspecialchars( YITH_WCWL()->get_wishlist_url() ) ) . '" data-product-id="' . esc_attr( $product->ID ) . '" data-product-type="' . esc_attr( $product_type ) . '" ' . $classes . ' >' . $normalicon . $wishlist_text . '</a>';
		$output .= '<i class="fa fa-spinner fa-pulse ajax-loading" style="visibility:hidden"></i>';
		$output .= '</div>';

		$output .= '<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;"><a class="dnwoo-filter-wishlist-btn" href="' . esc_url( $url ) . '">' . $addedicon . $wishlist_text . '</a></div>';
		$output .= '<div class="yith-wcwl-wishlistexistsbrowse ' . ( $exists ? 'show' : 'hide' ) . '" style="display:' . ( $exists ? 'block' : 'none' ) . '"><a href="' . esc_url( $url ) . '" class="dnwoo-filter-wishlist-btn dnwoo-product-action-btn">' . $addedicon . $wishlist_text . '</a></div>';
		$output .= '</div>';
		return $output;
	}

	public function _product_compare_icon( $product_id, $compare_text ) {
		if ( ! class_exists( 'YITH_Woocompare' ) ) {
			return '';
		}

		$comp_link    = home_url() . '?action=yith-woocompare-add-product';
		$comp_link    = add_query_arg( 'id', $product_id, $comp_link );
		$compare_text = isset( $compare_text ) ? $compare_text : '';

		$output = '';

		$output .= '<div class="woocommerce product compare-button">';
		$output .= '<a href="' . esc_url( $comp_link ) . '" class="dnwoo-product-compare-btn compare icon_compare"  data-product_id="' . esc_attr( $product_id ) . '" rel="nofollow">' . $compare_text . '</a></div>';
		$output .= '</div">';

		return $output;
	}

	public function filter_products_query( $args ) {
		if ( is_search() ) {
			$args['s'] = get_search_query();
		}

		if ( function_exists( 'WC' ) ) {
            $args['meta_query'] = WC()->query->get_meta_query(et_()->array_get($args, 'meta_query', array()), true); // phpcs:ignore
            $args['tax_query']  = WC()->query->get_tax_query(et_()->array_get($args, 'tax_query', array()), true); // phpcs:ignore

			// Add fake cache-busting argument as the filtering is actually done in self::apply_woo_widget_filters().
			$args['nocache'] = microtime( true );
		}

		return $args;
	}

	public function apply_woo_widget_filters( $query ) {
		global $wp_the_query;

		// Trick Woo filters into thinking the products shortcode query is the
		// main page query as some widget filters have is_main_query checks.
        $wp_the_query = $query; // phpcs:ignore

		// Set a flag to track that the main query is falsified.
		$wp_the_query->et_pb_shop_query = true;
		if ( function_exists( 'WC' ) ) {
			add_filter( 'posts_clauses', array( WC()->query, 'price_filter_post_clauses' ), 10, 2 );
		}
	}


	protected function sanitize_content($content){
		return preg_replace('/^<\/p>(.*)<p>/s', '$1', $content);
	}

	protected function process_content($content){
		$content = $this->sanitize_content($content);
		$content = str_replace(["&#91;", "&#93;"], ["[", "]"], $content);
		$content = do_shortcode($content);
		$content = str_replace(
			["<p><div", "</div></p>", "</div> <!-- .et_pb_section --></p>"],
			["<div", "</div>", "</div>"],
			$content
		);
		return $content;
	}
}
new DNWooFilterMasonry();
